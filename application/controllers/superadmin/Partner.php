<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('superadmin/home_model','home_model');
		$this->load->library('email_lib');
	}
	
	public function index()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	      $type = $this->session->userdata('type');
	      $data['all_partner']=$this->home_model->get_partner();
	      $this->load->view('superadmin/partner',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
	}
	
public function partner_detail()
{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	      $type = $this->session->userdata('type');
	      $uid=$_GET['ptr'];
	      $org=$_GET['org'];
	      $data['partner']=$this->home_model->get_partner_detail($uid,$org);
	      $this->load->view('superadmin/partner_detail',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
}

public function activate_partner()
{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	        $prtnrid    =$this->input->post('prtnrid');
	        $compNAme   =$this->input->post('comp_name');
	        $password   =md5($this->input->post('password'));
	        $dataList=$this->home_model->get_partner_detail($prtnrid,$compNAme);
            $dataArr=array();
            $msgArr=array();
            foreach ($dataList as $post)
            {
                
                $dataAdm=$this->home_model->checkExistAdmin($post['Email_first']);
                $dataStr=$this->home_model->checkExistStr($post['Email_first']);
                if($dataAdm['id']){
                    $msgArr=array("msg"=>'<i class="fas fa-exclamation-triangle" style="color:red;"></i> Already exist as admin');
                }
                if($dataStr['id']){
                    $msgArr=array("msg"=>'<i class="fas fa-exclamation-triangle" style="color:red;"></i> Already exist as standard users');
                }
                
                if(count($msgArr)<1){
                $dataArr['admin_name']      = ucwords($post['First_name'].' '.$post['Last_name']);
                $dataArr['admin_email']     = $post['Email_first'];
                $dataArr['admin_mobile']    = $post['Mobile_no'];
                $dataArr['admin_password']  = $password;
                $dataArr['type']            = 'admin';
                $dataArr['active']          = 1;
                $dataArr['user_type']       = 'partner';
                $dataArr['company_name']    = $post['Company_name'];
                $dataArr['country']         = $this->input->post('country');
                $dataArr['state']           = $this->input->post('state');
                $dataArr['city']            = $this->input->post('city');
                $dataArr['company_address'] = $post['Address'];
                $dataArr['zipcode']         = $post['Zip_code'];
                $dataArr['company_mobile']  = $post['Mobile_no'];
                $dataArr['company_email']   = $post['Email_first'];
                $dataArr['company_website'] = $post['Official_website'];
                $dataArr['company_gstin']   = $post['GST_id'];
                $endDate = date('Y-m-d', strtotime('+1 years'));
                $dataArr['activation_date'] = date('Y-m-d');
                $dataArr['trial_end_date']  = $endDate;
                $dataArr['account_type']    = 'Trial';
                $dataArr['created_date']    = date('Y-m-d');
                $dataArr['status']          = 1;
                $dataArr['create_user']         = 1;
                $dataArr['retrieve_user']       = 1;
                $dataArr['delete_user']         = 1;
                $dataArr['update_user']         = 1;
                $dataArr['create_org']          = 1;
                $dataArr['retrieve_org']        = 1;
                $dataArr['update_org']          = 1;
                $dataArr['delete_org']          = 1;
                $dataArr['create_contact']      = 1;
                $dataArr['retrieve_contact']    = 1;
                $dataArr['update_contact']      = 1;
                $dataArr['delete_contact']      = 1;
                $dataArr['create_lead']         = 1;
                $dataArr['retrieve_lead']       = 1;
                $dataArr['update_lead']         = 1;
                $dataArr['delete_lead']         = 1;
                $dataArr['create_opp']          = 1;
                $dataArr['retrieve_opp']        = 1;
                $dataArr['update_opp']          = 1;
                $dataArr['delete_opp']          = 1;
                $dataArr['create_quote']        = 1;
                $dataArr['retrieve_quote']      = 1;
                $dataArr['update_quote']        = 1;
                $dataArr['delete_quote']        = 1;
                $dataArr['create_so']           = 1;
                $dataArr['retrieve_so']         = 1;
                $dataArr['update_so']           = 1;
                $dataArr['delete_so']           = 1;
                $dataArr['create_vendor']       = 1;
                $dataArr['retrieve_vendor']     = 1;
                $dataArr['update_vendor']       = 1;
                $dataArr['delete_vendor']       = 1;
                $dataArr['create_product']      = 1;
                $dataArr['retrieve_product']    = 1;
                $dataArr['update_product']      = 1;
                $dataArr['delete_product']      = 1;
                $dataArr['create_po']           = 1;
                $dataArr['retrieve_po']         = 1;
                $dataArr['update_po']           = 1;
                $dataArr['delete_po']           = 1;
                $dataArr['create_inv']          = 1;
                $dataArr['retrieve_inv']        = 1;
                $dataArr['update_inv']          = 1;
                $dataArr['delete_inv']          = 1;
                $dataArr['retrieve_po']         = 1; 
                $dataList=$this->home_model->create_admin($dataArr);
                
                $statusArr=array(  'Status' => 1  );
                $this->home_model->update_partner($statusArr,$post['id']);
                
                $msgArr=array(
                    "msg_succ"=>'<i class="far fa-check-circle" style="color:green;"></i> Successfully activated this partner'
                    );
                
                
 ##### Send Mail To partner username & password ####
 ###################################################
 
$messageBody='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <h1>Welcome, '.ucwords($post['First_name'].' '.$post['Last_name']).'!</h1>
                        <p>Thanks for trying team365. We’re thrilled to have you on board. To get the most out of team365.io, do this primary next step:</p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="https://team365.io/" class="f-fallback button" target="_blank">Read More..</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>For reference, here is your login information:</p>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
										<strong>Login Page:</strong> http://allegient.team365.io/
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Username:</strong> '.$post['Email_first'].'
									</span>
                                  </td>
                                </tr>
								<tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Password:</strong> '.$this->input->post('password').'
									</span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>You have started a 1 year trial with 5 licence. You can upgrade to a paying account or cancel any time.</p>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Trial Start Date:</strong> '.date("Y-m-d").'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Trial End Date:</strong> '.$endDate.'
									</span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
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
     
    $subject='Your team365 account has been activated';           
    $this->email_lib->send_email($post['Email_first'],$subject,$messageBody);
    //$this->email_lib->send_email('dev2@team365.io',$subject,$messageBody);
				
				   
	/*Send Mail to Admin start*/
	
    $adminMSg='
<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <style>
     body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}
	 table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}
	 table td{font-family:sans-serif;font-size:14px;vertical-align:top}
	 .body{background-color:#f6f6f6;width:100%}.container{display:block;Margin:0 auto!important;max-width:580px;padding:10px;width:580px}
	 .content{box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:3px;width:100%}
	 .wrapper{box-sizing:border-box;padding:20px}.footer{clear:both;padding-top:10px;text-align:center;width:100%}.footer a,.footer p,.footer span,
	 .footer td{color:#999;font-size:12px;text-align:center}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}
	 .powered-by a{text-decoration:none}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}
	 table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body] 
	 .wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] 
	 .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body] 
	 .btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,
	 .ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;
	 font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}}
       
    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <span class="preheader">New account activate by you - team365</span>
            <table class="main">
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td style="text-align: center;">
                        <h1>New Account Activated </h1>
                        <h2>A new partner account added on crm by you.</h2>
                        <h3>Find detail bellow.</h3>
                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                          <tbody>
                            <tr>
                              <td align="left">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td style="width: 30%; padding: 6px;">Partner Name</td>
                                      <td style="padding: 6px;"> : </td>
                                      <td style="padding: 6px;">'.ucwords($post['First_name'].' '.$post['Last_name']).'</td>
                                    </tr><tr>
                                      <td style="padding: 6px;">Company Name</td>
                                      <td style="padding: 6px;"> : </td>
                                      <td style="padding: 6px;">'.$post['Company_name'].'</td>
                                    </tr><tr>
                                      <td style="padding: 6px;">Company Website</td>
                                      <td style="padding: 6px;"> : </td>
                                      <td style="padding: 6px;">'.$post['Official_website'].'</td>
                                    </tr><tr>
                                      <td style="padding: 6px;">Email</td>
                                      <td style="padding: 6px;"> : </td>
                                      <td style="padding: 6px;">'.$post['Email_first'].'</td>
                                    </tr><tr>
                                      <td style="padding: 6px;">Mobile No.</td>
                                      <td style="padding: 6px;"> : </td>
                                      <td style="padding: 6px;">'.$post['Mobile_no'].'</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        <p>More Information, Please login to admin panel and open admin deatil tab.<br>
						<a href="https://allegient.team365.io/superadmin/">Click here </a> to login</p>
                        <p>If you received this email by mistake, simply delete it.
						You won`t be subscribed if you don`t click the confirmation link above.</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0"> <tr> 
			  <td class="content-block"> <span class="apple-link">team365.io</span>  </td>
                </tr>
                <tr> <td class="content-block powered-by">  Powered by <a href="https://www.allegientservices.com/">allegient</a>.
                  </td> </tr>
              </table>
            </div>
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>';  
     $subjectAd='A new partner activated on crm - team365'; 
     $this->email_lib->send_email('sales@team365.io',$subjectAd,$adminMSg);      
  ###################################################    
                    
                echo json_encode($msgArr);
                }else{
                    echo json_encode($msgArr);
                }
            }
	      
	      
	      
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
}

public function create()
  	{

  		$validation = $this->check_user_validation();
	    if($validation!=200)
	    {
	      echo $validation;die;
	    }
	    else
	    {
		    if(!empty($this->input->post('first_name')))
		    {
		        $standard_name = $this->input->post('first_name')." ".$this->input->post('last_name');
		    }
		    else
		    {
		        $standard_name = $this->input->post('standard_name');
		    }
		    $type = "standard";
		    $data = array(
		      'standard_name' => $standard_name,
		      'standard_email' => $this->input->post('standard_email'),
		      'standard_mobile' => $this->input->post('standard_mobile'),
		      'standard_password' => md5($this->input->post('standard_password')),
		      'license_type'=> $this->input->post('license_type'),
		      'admin_name' => $this->session->userdata('name'),
		      'type' => $type,
		      'company_name' => $this->session->userdata('company_name'),
		      'country' => $this->session->userdata('country'),
		      'state' => $this->session->userdata('state'),
		      'city' => $this->session->userdata('city'),
		      'company_address' => $this->session->userdata('company_address'),
		      'zipcode' => $this->session->userdata('zipcode'),
		      'company_mobile' => $this->session->userdata('company_mobile'),
		      'company_email' => $this->session->userdata('company_email'),
		      'company_website' => $this->session->userdata('company_website'),
		      'company_gstin' => $this->session->userdata('company_gstin'),
		      'pan_number' => $this->session->userdata('pan_number'),
		      'cin' => $this->session->userdata('cin'),
		      'company_logo' => $this->session->userdata('company_logo'),
		      'terms_condition_customer' => $this->session->userdata('terms_condition_customer'),
		      'terms_condition_seller' => $this->session->userdata('terms_condition_seller'),
		    );
		    $this->Login_model->create($data);
		    echo json_encode(array("status" => TRUE));
		}
  	}
  



// Please write code above this  
}
