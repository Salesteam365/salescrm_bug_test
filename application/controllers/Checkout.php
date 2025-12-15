<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Upgrade_plan_model');
		$this->load->model('Login_model');
		$this->load->library(array('email_lib'));
	}
	public function index()
	{   
	    
	    $remainingDays = $this->input->post('remainingDays');
	    $slectTab = $this->input->post('slectTab');
	    if($this->input->post('slectTab')=='add_licence_in_existing_plan'){
	        $plan_id        = $this->input->post('Ex_plan_id');
	        $exist_lic      = $this->input->post('exist_lic');
	        $ex_used_lic    = $this->input->post('ex_used_lic');
	        $ex_add_more    = $this->input->post('ex_add_more');
	        $ex_amount_exp_date  = str_replace(",","",$this->input->post('ex_amount_exp_date'));
	       
	        
	        $input = array(
	            'plan_id'       => $plan_id,
	            'exist_licence' => $exist_lic,
	            'used_licence'  => $ex_used_lic,
	            'add_extra_lic' => $ex_add_more,
	            'payable_amount'=> $ex_amount_exp_date,
	            'remainingDays' => $remainingDays,
	            'slectTab'      => $slectTab
	            );
	        
	    }else if($this->input->post('slectTab')=='change_existing_plan'){
	        $plan_id        = $this->input->post('chpl_plan_id');
	        $plan_id_into   = $this->input->post('chpl_into_plan_id');
	        $exist_lic      = $this->input->post('chpl_exist_lic');
	        $ex_add_more    = $this->input->post('chpl_add_more');
	        $ex_amount_exp_date  = str_replace(",","",$this->input->post('chpl_amount_exp_date'));
	       
	        $input = array(
	            'plan_id'       => $plan_id,
	            'plan_id_into'  => $plan_id_into,
	            'exist_licence' => $exist_lic,
	            'used_licence'  => $exist_lic,
	            'add_extra_lic' => $ex_add_more,
	            'payable_amount'=> $ex_amount_exp_date,
	            'remainingDays' => $remainingDays,
	            'slectTab'      => $slectTab
	            );
	        
	    }else if($this->input->post('slectTab')=='buy_new_plan'){
	        $plan_id        = $this->input->post('buyn_plan_id');
	        $plan_type      = $this->input->post('buyn_lic_type');
	        $exist_lic      = $this->input->post('chpl_exist_lic');
	        $ex_add_more    = $this->input->post('buyn_add_more');
	        $ex_amount_exp_date  = str_replace(",","",$this->input->post('buyn_amount_exp_date'));
	       
	        $input = array(
	            'plan_id'       => $plan_id,
	            'plan_id_into'  => $plan_id,
	            'plan_type'     => $plan_type,
	            'exist_licence' => 0,
	            'used_licence'  => 0,
	            'add_extra_lic' => $ex_add_more,
	            'payable_amount'=> $ex_amount_exp_date,
	            'remainingDays' => $remainingDays,
	            'slectTab'      => $slectTab
	            );
	        
	    }else{
	        redirect('upgrade-plan');
	        exit;
	    }
	    
	    $data['input']=$input;
	    $data['planlist'] = $this->Login_model->yourplanid($input['plan_id']);
	    if($slectTab=='change_existing_plan' || $slectTab=='buy_new_plan'){
	    $data['planlistChangeInto'] = $this->Upgrade_plan_model->getPlanList('CRM',$input['plan_id_into']);
	    }
	    $data['newplanlist'] = $this->Upgrade_plan_model->getPlanList('CRM',$input['plan_id']);
		$this->load->view('verification/checkout',$data);
			
	}
	
	public function plan()
	{
		$selectPlan        	 = $this->input->post('selectPlan');
		$input 				 = array( 'selectPlan' => $selectPlan);
		$data['input']		 = $input;
		$data['planlist'] 	 = $this->Login_model->yourplanid();
		$data['allplanlist'] = $this->Upgrade_plan_model->getPlanList('CRM','');
		$this->load->view('verification/extend-plan-checkout',$data);
	}
	
	
	
	public function checkuser()
	{
	    $username=$this->input->post('company');
	    $data = $this->Upgrade_plan_model->checkuser($username);
	    echo json_encode($data); 
	 	
	}
	
	 // initialized cURL Request
    private function curl_handler($payment_id, $amount)  {
        $url            = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        /****live key id***/
        $key_id         = "rzp_live_ueohvN1q49h0Vj";
        /*****test key id****/
        //$key_id         = "rzp_test_PGtHX7wCTGNzXM";
        $key_secret     = "dsCAQFVmc7jNbCRtK6Twd2iD";
        $fields_string  = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch; 
    }   
        
    // callback method
    public function callback_rozarpay() {   
	
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');
            
            $this->session->set_flashdata('razorpay_payment_id', $this->input->post('razorpay_payment_id'));
            $this->session->set_flashdata('merchant_order_id', $this->input->post('merchant_order_id'));
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {                
                $ch = $this->curl_handler($razorpay_payment_id, $amount);
                //execute post
                
              
                $result = curl_exec($ch);
                //  print_r($result); 
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                
                
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
            }
            
            $admin_id = $this->session->userdata('id');
            
            
    /*###########If Payment Getting Success  ##########*/        
            
    if($success === true) {
                $session_comp_email = $this->session->userdata('company_email');
                $dataArr = array(
					'order_id' 		    => $merchant_order_id,
					'payment_id' 	    => $razorpay_payment_id,
					'company_id' 		=> $this->session->userdata('id'),
					'product_name'   	=> 'Team365_CRM',
					'licence_type' 	    => $this->input->post('product_id'),
					'licence_duration' 	=> $this->input->post('CrmTime'),
					'user_name' 	    => $this->input->post('crmusername'),
					'company_name' 	    => $this->input->post('compname'),
					'company_email' 	=> $session_comp_email,
					'user_mobile' 	    => $this->input->post('commobile'),
					'price_per_licence' => $this->input->post('unit_price'),
					'total_licence'     => $this->input->post('licenceQty'),
					'total_price'       => $this->input->post('total_price'),
					'total_gst'     	=> $this->input->post('total_incgst'),
					'final_price'   	=> $this->input->post('merchant_amount'),
					'trans_id' 		    => $this->input->post('merchant_trans_id'),
					'payment_method'    => $response_array['method'],
					'payment_status'    => 1,
					'ip' 			    => $this->input->ip_address()
				);
				
				if($this->input->post('CrmTime')=='Annualy'){
				    $licence_exp = date('Y-m-d',strtotime("+1 Year"));
				    $subscriptionTime='1 Year';
				}elseif($this->input->post('CrmTime')=='Monthly'){
				    $licence_exp = date('Y-m-d',strtotime("+1 Month"));
				    $subscriptionTime='1 Month';
				}
				
			 if($this->input->post('slectTab')=='extend_plan'){
			     $plan_id   = $this->input->post('product_id');
			     $till_date = $this->input->post('till_date');
			     $data      = $this->Login_model->yourplanid($plan_id);
			     $addLice= $this->input->post('licenceQty');
			     $finalPrice= $this->input->post('merchant_amount');
			     $existLic  = $data['plan_licence'];
			     $licenceQty=$addLice+$existLic;
			     $planArr=array(
			         'licence_exp_date' => $till_date,
			         'plan_price'   => $finalPrice
			         );
			     $this->Upgrade_plan_model->updateExtendLicenceDetail($planArr); 
				$updatedataArr = array(
					'account_type'   	      => 'Paid',
					'status'   	              => 1,
					'total_licence' 	      => $licenceQty,
					'license_expiration_date' => $till_date,
					'business_lic_amnt' 	  => $this->input->post('merchant_amount')
				);
				$this->Upgrade_plan_model->update_adminusers($admin_id,$updatedataArr);	
			 }else if($this->input->post('slectTab')=='add_licence_in_existing_plan'){
			     $plan_id   = $this->input->post('product_id');
			     $data      = $this->Login_model->yourplanid($plan_id);
			     $addLice= $this->input->post('licenceQty');
			     $finalPrice= $this->input->post('merchant_amount');
			     $existLic  = $data['plan_licence'];
			     $licenceQty=$addLice+$existLic;
			     $planArr=array(
			         'plan_licence' => $licenceQty,
			         'plan_price'   => $finalPrice
			         );
			     $this->Upgrade_plan_model->updateLicenceDetail($planArr,$data['id']);    
			 }else if($this->input->post('slectTab')=='change_existing_plan'){
			     
			     $licenceQty= $this->input->post('licenceQty');
			     $finalPrice= $this->input->post('merchant_amount');
			     
			     $plan_id   = $this->input->post('product_id');
			     $dataInto  = $this->Login_model->yourplanid($plan_id);
			     
			     $exi_product_id  = $this->input->post('exi_product_id');
			     $changeit  = $this->Login_model->yourplanid($exi_product_id);
			     
    			   $planArr=array(
    			         'plan_id'      => $plan_id,
    			         'plan_licence' => $licenceQty,
    			         'plan_price'   => $finalPrice
			        );
			     if(count($dataInto)>0){
			         $this->Upgrade_plan_model->updateLicenceDetail($planArr,$dataInto['id']); 
			         $deleteArr=array('delete_status');
			         $this->Upgrade_plan_model->DeleteLicenceDetail($deleteArr,$changeit['id']); 
			     }else{
			         $this->Upgrade_plan_model->updateLicenceDetail($planArr,$changeit['id']); 
			     }
			     
			 }else if($this->input->post('slectTab')=='buy_new_plan'){
			     $licenceQty= $this->input->post('licenceQty');
			     $finalPrice= $this->input->post('merchant_amount');
			     $plan_id   = $this->input->post('product_id');
			     $session_comp_id = $this->session->userdata('id');
			     $sess_eml = $this->session->userdata('email');
			     $session_company    = $this->session->userdata('company_name');
			     $session_comp_email = $this->session->userdata('company_email');
			     $accountType= $this->session->userdata('account_type');
			     $expirDate=$this->session->userdata('license_expiration_date');
			     if($accountType=='Trial'){
			         $usedLic=1;
			         $licenceType=$this->input->post('CrmTime');
			         if($this->input->post('CrmTime')=='Annually'){
				        $licence_exp = date('Y-m-d',strtotime("+1 Year"));
				        $expirDate=$licence_exp;
				        $subscriptionTime='1 Year';
				        $licenceType='Annually';
    				}elseif($this->input->post('CrmTime')=='Monthly'){
    				    $licence_exp = date('Y-m-d',strtotime("+1 Month"));
    				    $subscriptionTime='1 Month';
    				    $expirDate=$licence_exp;
    				    $licenceType='Monthly';
    				}
			     }else{
			         $usedLic=0;
			         $expirDate=$expirDate;
			         $licenceType='Days';
			     }
			     $planArr=array(
    			         'admin_id'         =>$session_comp_id,
        			     'sess_eml'         => $sess_eml,
        			     'session_company'  => $session_company,
        			     'session_comp_email' =>$session_comp_email,
        			     'account_type'     => 'Paid',
        			     'plan_id'          => $plan_id,
        			     'plan_licence'     => $licenceQty,
        			     'plan_price'       => $finalPrice,
        			     'used_licence'     => $usedLic,
        			     'licence_act_date' => date('Y-m-d'),
        			     'licence_exp_date' => $expirDate,
        			     'licence_type'     => $licenceType,
        			     'currentdate'      => date('Y-m-d'),
        			     'ip'               => $this->input->ip_address(),
        			     'delete_status'    => 1
			        );
			    $this->Upgrade_plan_model->addLicenceDetail($planArr);  
			 }
			
			$accountType= $this->session->userdata('account_type');
			if($accountType=='Trial'){
				$updatedataArr = array(
					'license_activation_date' => date('Y-m-d'),
					'license_expiration_date' => $licence_exp,
					'activation_date' 		  => date('Y-m-d'),
					//'license_type'   	      => $this->input->post('ComLicencetype'),
					'account_type'   	      => 'Paid',
					'status'   	              => 1,
					'license_duration' 	      => $licenceType,
					'total_licence' 	      => $licenceQty,
					'business_lic_amnt' 	  => $this->input->post('merchant_amount')
					
				);
			}else{
			    	$updatedataArr = array(
					'account_type'   	      => 'Paid',
					'status'   	              => 1,
					'total_licence' 	      => $licenceQty,
					'business_lic_amnt' 	  => $this->input->post('merchant_amount')
					
				);
			}
				
				
				
			
				 $dataId=$this->Upgrade_plan_model->Addpayment($dataArr);
				 $this->Upgrade_plan_model->update_adminusers($admin_id,$updatedataArr);
				 
				 $this->session->set_flashdata('msgPayment', 'success');
				 
				 
				 $the_session = array("payment_status" => "1", "payment_id" => $dataId , "company_id" => $admin_id);
                 $this -> session -> set_userdata($the_session);
				 
				 
$messageBody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style type="text/css" rel="stylesheet" media="all">
    body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
   body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
   td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size:16px;line-height:1.625}p.sub{font-size:13px}.align-right{text-align:right}
   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
   .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0}
   .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
   .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
   .body-sub{margin-top:25px;padding-top:25px;border-top:1px solid #eaeaec}.content-cell{padding:35px}@media only screen and (max-width:600px){.email-body_inner,
   .email-footer{width:100%!important}}@media (prefers-color-scheme:dark){.email-body,.email-body_inner,.email-content,.email-footer,
   </style>
  </head>
  <body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead" align="center">
                <a href="https://team365.io/" class="f-fallback email-masthead_name">
                <img src="https://team365.io/assets/img/new-logo-team.png"></a>
              </a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <div style="text-align: center;">
                        <img src="https://team365.io/assets/img/check-img.png">
						<h3>Thank you, <br><text style="font-size: 16px;">Your payment has been recieved successfully.</text> </h3>
						</div>
						<h4>Hi, '.$this->input->post("comp_user_name").'!</h4>
                        <p>Thanks for trying team365. We’re thrilled to have you on board. </p>
                        <!-- Action -->
                        <p>You have started '.$subscriptionTime.' with '.$this->input->post('licenceQty').' licence. You can upgrade to a paying account any time.</p>
                        <h5>Your Payment Information:-</h5>
                        <table width="70%" cellpadding="5" cellspacing="2" role="presentation">
                            <tr><td ><strong>Product:</strong></td>
							<td>team365</td></tr>
							
							<tr><td><strong>Order Id:</strong></td>
							<td>'.$merchant_order_id.'</td></tr>
							
							<tr><td><strong>Subscription:</strong></td>
							<td>'.$subscriptionTime.'</td></tr>
							
							<tr><td><strong>Licence:</strong></td>
							<td>'.$this->input->post('licenceQty').'</td></tr>
							
							<tr><td><strong>GST Amount:</strong></td>
							<td>INR &nbsp;&nbsp'.$this->input->post('total_incgst').'/-</td></tr>
							
							<tr><td><strong>Total Amount:</strong></td>
							<td>INR &nbsp;&nbsp;'.$this->input->post('merchant_amount').'/-</td></tr>
							
							<tr><td><strong>Activation Date:</strong></td>
							<td>'.date('Y-m-d').'</td></tr>
							
							<tr><td><strong>Expiration Date:</strong></td>
							<td>'.$licence_exp.'</td></tr>
							
                        </table>
                        <p>If you have any questions, feel free to <a href="mailto:sales@team365.io">email our customer success team</a>. (We are lightning quick at replying.) We also offer <a href="https://team365.io/">live chat</a> during business hours.</p>
                        <p>Thanks,
                          <br>Team365 Team</p>
                        <p><strong>P.S.</strong> Need immediate help getting started? Check out our <a href="https://team365.io/contact">help documentation</a>. Or, just reply to this email, the team365 support team is always ready to help!</p>
                        <!-- Sub copy -->
                        <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                              <p class="f-fallback sub">https://team365.io/</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">&copy; '.date("Y").' team365. All rights reserved</p>
                      <p class="f-fallback sub align-center">team365</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
     
    $subject='Payment Confirmation - team365';           
   // $this->email_lib->send_email($post['Email_first'],$subject,$messageBody);
   $this->email_lib->send_email($this->input->post('crmusername'),$subject,$messageBody);
  			 
	 redirect(base_url('checkout/success'));
	 
    }else{
                //when failed payment
                $session_comp_email = $this->session->userdata('company_email');
                $dataArr = array(
					'order_id' 		    => $merchant_order_id,
					'payment_id' 	    => $razorpay_payment_id,
					'company_id' 		=> $admin_id,
					'product_name'   	=> 'Team365_CRM',
					'licence_type' 	    => $this->input->post('product_id'),
					'licence_duration' 	=> $this->input->post('CrmTime'),
					'user_name' 	    => $this->input->post('crmusername'),
					'company_name' 	    => $this->input->post('compname'),
					'company_email' 	=> $session_comp_email,
					'user_mobile' 	    => $this->input->post('commobile'),
					'price_per_licence' => $this->input->post('unit_price'),
					'total_licence'     => $this->input->post('licenceQty'),
					'total_price'       => $this->input->post('total_price'),
					'total_gst'     	=> $this->input->post('total_incgst'),
					'final_price'   	=> $this->input->post('merchant_amount'),
					'trans_id' 		    => $this->input->post('merchant_trans_id'),
					'payment_method'    => 'online',
					'payment_status'    => 0,
					'ip' 			    => $this->input->ip_address()
				);
				$dataId=$this->Upgrade_plan_model->Addpayment($dataArr);
				
				$this->session->set_flashdata('msgPayment', 'failed');
				
				
				 $the_session = array("payment_status" => "0", "payment_id" => $dataId , "company_id" => $admin_id);
                 $this -> session -> set_userdata($the_session);
				 
				 
$messageBody='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style type="text/css" rel="stylesheet" media="all">
    body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
   body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
   td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size:16px;line-height:1.625}p.sub{font-size:13px}.align-right{text-align:right}
   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
   .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0}
   .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
   .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
   .body-sub{margin-top:25px;padding-top:25px;border-top:1px solid #eaeaec}.content-cell{padding:35px}@media only screen and (max-width:600px){.email-body_inner,
   .email-footer{width:100%!important}}@media (prefers-color-scheme:dark){.email-body,.email-body_inner,.email-content,.email-footer,
   </style>
  </head>
  <body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead" align="center">
                <a href="https://team365.io/" class="f-fallback email-masthead_name">
                <img src="https://team365.io/assets/img/new-logo-team.png"></a>
              </a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="600" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <div style="text-align: center;">
                        <img src="https://team365.io/assets/img/failed-img.png">
						<h4>WE COULD NOT PROCESS YOUR PAYMENT</h4>
						</div>
						<h4>Hi, '.$this->input->post("comp_user_name").'!</h4>
                        <p>Unfortunately, we could not collect payment on your purchase.</p>
                        <!-- Action -->
                       
                       
                        <p>If you have any questions, feel free to <a href="mailto:sales@team365.io">email our customer success team</a>. (We are lightning quick at replying.) We also offer <a href="https://team365.io/">live chat</a> during business hours.</p>
                        <p>Thanks,
                          <br>Team365 Team</p>
                        <p><strong>P.S.</strong> Need immediate help getting started? Check out our <a href="https://team365.io/contact">help documentation</a>. Or, just reply to this email, the team365 support team is always ready to help!</p>
                        <!-- Sub copy -->
                        <table class="body-sub" role="presentation">
                          <tr>
                            <td>
                              <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                              <p class="f-fallback sub">https://team365.io/</p>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>
                <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <tr>
                    <td class="content-cell" align="center">
                      <p class="f-fallback sub align-center">&copy; '.date("Y").' team365. All rights reserved</p>
                      <p class="f-fallback sub align-center">team365</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
     
    $subject='Payment Failed - team365';           
   // $this->email_lib->send_email($post['Email_first'],$subject,$messageBody);
   $this->email_lib->send_email($this->input->post('crmusername'),$subject,$messageBody);
  			
			
                 redirect(base_url('checkout/failed'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    } 
	
	// Payment Success Message
    public function success() {
       
        if($this->session->userdata('payment_status')==1){
        $this->session->userdata('payment_status'); //1
        $this->session->userdata('payment_id');//
        $this->session->userdata('company_id');
        if($this->session->userdata('payment_id') && $this->session->userdata('payment_id')){
             $data = array();
            $data['successDt']=$this->Upgrade_plan_model->getpayement($this->session->userdata('payment_id'),$this->session->userdata('company_id'));
           $planid= $data['successDt'][0]->licence_type;
            $data['planlist'] = $this->Login_model->yourplanid($planid);
    		$this->load->view('verification/success',$data);
        }
        }else{
            redirect(base_url());
        }
    }  
	
	// Payment Failed Message
    public function failed() {
		$this->load->view('verification/failed');
    }
	

	
}