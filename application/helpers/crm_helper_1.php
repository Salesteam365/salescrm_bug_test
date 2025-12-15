<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
function get_org_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_org_report();
}
function get_contact_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_contact_report();
}
function get_lead_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_lead_report();
}
function get_opportunity_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_opp_report();
}
function get_quotation_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_quote_report();
}
function get_salesorder_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_so_report();
}
function get_vendor_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_vendor_report();
}
function get_purchaseorder_data()
{	
	$CI = &get_instance();
	$CI->load->model('Daily_reports');
	return $CI->Daily_reports->get_daily_po_report();
}


function check_permission($moduleName,$userId)
{	
	$CI = &get_instance();
	$CI->load->model('Permission_model');
	return $CI->Permission_model->check_permission($moduleName,$userId);
}

function check_permission_status($moduleName,$columnName)
{	
	$CI = &get_instance();
	$userType = $CI->session->userdata('type');
	$userId   = $CI->session->userdata('id');
	$checkPer=check_permission($moduleName,$userId); 
	if((isset($checkPer[$columnName]) && $checkPer[$columnName]==1) || $userType =='admin'){
		return true;
	}else{
		return false;
	}		
	
}


function sendMailWithTemp($to,$messageBody,$subject)
{
	$CI = &get_instance();
    $message='
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
                    <a href="" class="f-fallback email-masthead_name">';
    			    $image = $CI->session->userdata('company_logo');
    				if(!empty($image))
    				{ 
						$message .=  '<img  src="'.base_url().'/uploads/company_logo/'.$image.'" style="width:25%;">'; 
					}else{
    					$message .=  '<span class="h5 text-primary">'.$CI->session->userdata('company_name').'</span>';
    				}
    	
                  $message .=  '</a></td>
                </tr>
                <!-- Email Body -->
                <tr>
                  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                    <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                      <!-- Body content -->
                       <tr>
							<td class="content-cell">';
									$message.=$messageBody;
							$message.='
							</td>
                        </tr>
                    </table>
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
	$CI->load->library('email_lib');
	$CI->email_lib->send_email($to,$subject,$message);
}


function checkModule()
{	
	$CI 	= &get_instance();
	$CI->load->model('Workflow_model');
	$newArr=array();
	if($CI->session->userdata('account_type')=="Paid"){
		if($CI->session->userdata('type')=='admin'){ 
			$userid	= $CI->session->userdata('id');
			$plaId=$CI->Workflow_model->getPlanId($userid);
			//$planArr=explode(",",$plaId['plan_id']);
			$newArr=array();
			for($k=0; $k<count($plaId); $k++){
				$planidu=$plaId[$k]['plan_id'];
				$data=$CI->Workflow_model->getYourModule($planidu);
				for($i=0; $i<count($data); $i++){
					if (!in_array($data[$i]['module_name'], $newArr))
					{
						$newArr[]=$data[$i]['module_name'];
					}
				}
			}
		}else if($CI->session->userdata('type')=='standard'){
			$planid	= $CI->session->userdata('your_plan_id');
			$data=$CI->Workflow_model->getYourModule($planid);
			$newArr=array();
			for($i=0; $i<count($data); $i++){
				$newArr[]=$data[$i]['module_name'];
			}
		}
	}else if($CI->session->userdata('account_type')=="Trial"){
		//$planid	= $CI->session->userdata('your_plan_id');
		$data=$CI->Workflow_model->getYourModule(4);
		$newArr=array();
		for($i=0; $i<count($data); $i++){
			$newArr[]=$data[$i]['module_name'];
		}
	}
	return $newArr;
}

function checkModuleForContr($module)
{	
	$CI 	= &get_instance();
	$CI->load->model('Workflow_model');
	$planid	= $CI->session->userdata('your_plan_id');
	$dataCnt=$CI->Workflow_model->checkModuleForContr($module);
	return $dataCnt;
}


function updateid($id, $table,$culmnName)
{	
	$CI = &get_instance();
	$CI->load->model('setting_model');
	$data=$CI->setting_model->getprefixID($table);
	$datacount=$CI->setting_model->coutdata($table);
	if(isset($data['prefix_id']) && $data['prefix_id']!=""){
		$makeid=$data['prefix_id']."/".Date('Y')."/".$datacount;
	}else{
		$com=$CI->session->userdata('company_name');
		$comp=strtoupper(substr($com,0,3));
		$mdl=strtoupper(substr($table,0,3));
		$makeid=$comp."/".$mdl."/".Date('Y')."/".$datacount;
	}
	if($table!="performa_invoice"){
	    $arraData=array($culmnName=>$makeid);
	    $CI->setting_model->update_id($arraData,$id,$table);
	}
	 return $makeid;
}


function updateidForApi($id, $table,$culmnName)
{	
	$CI = &get_instance();
	$CI->load->model('setting_model');
	
	$dataDetail=$CI->setting_model->dataDetail($table,$id);

	$data=$CI->setting_model->getprefixIDForapi($table,$dataDetail['session_company'],$dataDetail['session_comp_email']);
	$datacount=$CI->setting_model->coutdataForApi($table,$dataDetail['session_company'],$dataDetail['session_comp_email']);
	if(isset($data['prefix_id']) && $data['prefix_id']!=""){
		$makeid=$data['prefix_id']."/".Date('Y')."/".$datacount;
	}else{
		$com=$dataDetail['session_company'];
		$comp=strtoupper(substr($com,0,3));
		$mdl=strtoupper(substr($table,0,3));
		$makeid=$comp."/".$mdl."/".Date('Y')."/".$datacount;
	}
	if($table!="performa_invoice"){
	    $arraData=array($culmnName=>$makeid);
	    $CI->setting_model->update_id($arraData,$id,$table);
	}
	 return $makeid;
}


function checkWorkFlow($module, $Recurrence)
{	
	$CI = &get_instance();
	$CI->load->model('Workflow_model');
	$data=$CI->Workflow_model->getStatusModule($module, $Recurrence);
	if(isset($data) && $data>0){
	return $data['trigger_workflow_on'];
	}else{
	    return 0;
	}
}


function IND_money_format($num){
	$num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
	return $num;
}



function time_elapsed_string($timestamp) {
    date_default_timezone_set("Asia/Kolkata");         
  $time_ago        = strtotime($timestamp);
  $current_time    = time();
  $time_difference = $current_time - $time_ago;
  $seconds         = $time_difference;
  
  $minutes = round($seconds / 60); // value 60 is seconds  
  $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
  $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
  $weeks   = round($seconds / 604800); // 7*24*60*60;  
  $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
  $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                
  if ($seconds <= 60){

    return "Just Now";

  } else if ($minutes <= 60){

    if ($minutes == 1){

      return "one minute ago";

    } else {

      return "$minutes minutes ago";

    }

  } else if ($hours <= 24){

    if ($hours == 1){

      return "an hour ago";

    } else {

      return "$hours hrs ago";

    }

  } else if ($days <= 7){

    if ($days == 1){

      return "yesterday";

    } else {

      return "$days days ago";

    }

  } else if ($weeks <= 4.3){

    if ($weeks == 1){

      return "a week ago";

    } else {

      return "$weeks weeks ago";

    }

  } else if ($months <= 12){

    if ($months == 1){

      return "a month ago";

    } else {

      return "$months months ago";

    }

  } else {
    
    if ($years == 1){

      return "one year ago";

    } else {

      return "$years years ago";

    }
  }
}


function calculateFiscalYearForDate($month)
{
    if($month >= 4){
        $y = date('Y');
        $pt = date('Y', strtotime('+1 year'));
        $fy = $y."-04-01".":".$pt."-03-31";
    }else{
        $y = date('Y', strtotime('-1 year'));
        $pt = date('Y');
        $fy = $y."-04-01".":".$pt."-03-31";
    }
    return $fy;
}



function AmountInWords(float $amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}




function getTreeView($id)
{
    $CI = & get_instance();
	$CI->load->model('roles_model');
    $dataVariable= $CI->roles_model->get_allroles_tree($id); 
    if(count($dataVariable)>0){
        echo "<ul>";
        foreach($dataVariable as $name){
        echo "<li> <span class='treeSpan'>".$name['role_name']."   <button class='btnid' data-id='".$name['id']."'><i class='fas fa-pencil-alt '></i></button>
        <button class='addRol' data-pid='".$name['id']."' ><i class='far fa-plus-square'></i></button></span>";
        
        $check= $CI->roles_model->get_allroles_tree($name['id']);
        if(count($check)>0){
            
        }else{
            echo "</li>";
        }
        
        getTreeView($name['id']);  
        }
        echo "</ul>";
    }  
}



function create_opportunity($post) {  
	
		$CI = & get_instance();
		$CI->load->model('Quotation_model','Quotation');
		$CI->load->model('Salesorders_model','Salesorders');
		$CI->load->model('Reports_model','Reports');
		$CI->load->model('Lead_model','Lead');
		$CI->load->model('Login_model','Login');
		$CI->load->model('Opportunity_model','Opportunity');
	if(isset($post['org_name'])){
        if(!empty($post['lead_id']))
		{
			$lead_id = $post['lead_id'];
			$status = "In Progress";
			$CI->Lead->lead_status($lead_id,$status);
		}
		  
	  
	  $initial_total = str_replace(",", "", $post['initial_total']);
      $unit_price = str_replace(",", "", $post['unit_price']);
      $total = str_replace(",", "", $post['total']);
      if(isset($post['discount'])){
      $discount = str_replace(",", "", $post['discount']);
      }else{
          
         $discount = 0; 
      }
      $sub_total =  ($initial_total+$discount);
	  
      $data = array(
        'sess_eml' 			=> $CI->session->userdata('email'),
        'session_company' 	=> $CI->session->userdata('company_name'),
        'session_comp_email'=> $CI->session->userdata('company_email'),        
        'owner' 			=> $post['owner'],
        'org_name' 			=> $post['org_name'],
        'name' 				=> 'Opportunity of '.$post['subject'],
        'contact_name' 		=> $post['contact_name'],                
        'product_name' 		=> implode("<br>", $post['product_name']),
        'quantity' 			=> implode("<br>", $post['quantity']),
        'unit_price' 		=> implode("<br>", $unit_price),
        'total' 			=> implode("<br>", $total),
        //'percent' 			=> implode("<br>", $post['percent']),
        'initial_total' 	=> $initial_total,
        'discount' 			=> $discount,
        'sub_total' 		=> $sub_total,
        'total_percent' 	=> $post['total_percent'],
        'currentdate' 		=> date("Y-m-d"),
        'track_status' 		=> 'opportunity'
      );
	  if(isset($post['lead_id'])){
		$data['lead_id'] =  $post['lead_id']; 
	  }
	  if(isset($post['expclose_date'])){
		$data['expclose_date'] =  $post['expclose_date']; 
	  }
	  if(isset($post['pipeline'])){
		$data['pipeline'] =  $post['pipeline']; 
	  }
	   if(isset($post['stage'])){
		$data['stage'] =  $post['stage']; 
	  }
	   if(isset($post['lead_source'])){
		$data['lead_source'] =  $post['lead_source']; 
	  }
	   if(isset($post['probability'])){
		$data['probability'] =  $post['probability']; 
	  }
	   if(isset($post['industry'])){
		$data['industry'] =  $post['industry']; 
	  }
	  if(isset($post['type'])){
		$data['type'] =  $post['type']; 
	  }
	  if(isset($post['employees'])){
		$data['employees'] =  $post['employees']; 
	  }
	  if(isset($post['weighted_revenue'])){
		$data['weighted_revenue'] =  $post['weighted_revenue']; 
	  }
	  if(isset($post['email'])){
		$data['email'] =  $post['email']; 
	  }
	  if(isset($post['mobile'])){
		$data['mobile'] =  $post['mobile']; 
	  }
	  if(isset($post['lost_reason'])){
		$data['lost_reason'] =  $post['lost_reason']; 
	  }
	  
      
      $id = $CI->Opportunity->create($data);
      $opportunity_id=updateid($id,'opportunity','opportunity_id');
      $opp_data = array('opportunity_id' => $opportunity_id, 'track_status' => 'opportunity');
	  if(isset($post['lead_id'])){
      $CI->Lead->update_lead_track_status(array('lead_id' => $post['lead_id']),$opp_data);
	  }
      $CI->load->model('Notification_model');
      $data=$CI->Notification_model->addNotification('opportunity',$id);
      return $opportunity_id;
	}
    }
  
  
  
    function create_quote($post,$opportunity_id)
    {  
	    $CI = & get_instance();
		$CI->load->model('Quotation_model','Quotation');
		$CI->load->model('Salesorders_model','Salesorders');
		$CI->load->model('Reports_model','Reports');
		$CI->load->model('Lead_model','Lead');
		$CI->load->model('Login_model','Login');
		$CI->load->model('Opportunity_model','Opportunity');
		
		if($CI->input->post('org_name')){
		
        $initial_total 	= str_replace(",", "", $CI->input->post('initial_total'));
        $unit_price 	= str_replace(",", "", $CI->input->post('unit_price'));
        $total 			= str_replace(",", "", $CI->input->post('total'));
        $after_discount = str_replace(",", "", $CI->input->post('after_discount'));
        $sub_total 		= str_replace(",", "", $CI->input->post('sub_total'));
		
		if($CI->input->post('igst')!=""){
			$igst=implode("<br>", $CI->input->post('igst'));
		}else{
			$igst='';
		}
		if($CI->input->post('cgst')!=""){
			$cgst=implode("<br>", $CI->input->post('cgst'));
		}else{
			$cgst='';
		}
		if($CI->input->post('sgst')!=""){
			$sgst=implode("<br>", $CI->input->post('sgst'));
		}else{
			$sgst='';
		}
		
		if($CI->input->post('terms_condition')){
			$terms_condition=implode("<br>",$CI->input->post('terms_condition'));
		}else{
			$terms_condition='';
		}
		if($CI->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $CI->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($CI->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $CI->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }
		
  
        $data = array(
          'sess_eml'			=> $CI->session->userdata('email'),
          'session_company' 	=> $CI->session->userdata('company_name'),
          'session_comp_email' 	=> $CI->session->userdata('company_email'),
          'opportunity_id' 		=> $opportunity_id,
          'owner' 				=> $CI->input->post('owner'),
          'org_name' 			=> $CI->input->post('org_name'),
          'subject' 			=> 'Quote of '.$CI->input->post('subject'),
          'contact_name' 		=> $CI->input->post('contact_name'),
          'opp_name' 			=> $CI->input->post('opp_name'),         
          'carrier' 			=> $CI->input->post('carrier'),          
          'billing_country' 	=> $CI->input->post('billing_country'),
          'billing_state' 		=> $CI->input->post('billing_state'),
          'billing_city' 		=> $CI->input->post('billing_city'),
          'billing_zipcode' 	=> $CI->input->post('billing_zipcode'),
          'billing_address' 	=> $CI->input->post('billing_address'),
          'shipping_country' 	=> $CI->input->post('shipping_country'),
          'shipping_state' 		=> $CI->input->post('shipping_state'),
          'shipping_city' 		=> $CI->input->post('shipping_city'),
          'shipping_zipcode' 	=> $CI->input->post('shipping_zipcode'),
          'shipping_address' 	=> $CI->input->post('shipping_address'),
          'product_name' 		=> implode("<br>", $CI->input->post('product_name')),
          'hsn_sac' 			=> implode("<br>", $CI->input->post('hsn_sac')),
          'sku' 				=> implode("<br>", $CI->input->post('sku')),
          'gst' 				=> implode("<br>", $CI->input->post('gst')),
          'quantity' 			=> implode("<br>", $CI->input->post('quantity')),
          'unit_price' 			=> implode("<br>", $unit_price),
          'total' 				=> implode("<br>", $total),
          //'percent' 			=> implode("<br>", $CI->input->post('percent')),
          'initial_total' 		=> $initial_total,
          'discount' 			=> str_replace(",", "",$CI->input->post('discount')),
          'after_discount' 		=> $after_discount,          
           'type' 				=> $CI->input->post('type'),
          'igst' 				=> $igst,
          'cgst' 				=> $cgst,
          'sgst' 				=> $sgst,
          'sub_total_with_gst'  => implode("<br>", $CI->input->post('sub_total_with_gst')),
		  'extra_charge_label'  => $extra_charge,
          'extra_charge_value'  => $extra_chargevalue,
		  'pro_discount'  		=> implode("<br>", $CI->input->post('discount_price')),
		  'total_igst' 			=> str_replace(",", "",$CI->input->post('total_igst')),
          'total_cgst' 			=> str_replace(",", "",$CI->input->post('total_cgst')),
          'total_sgst' 			=> str_replace(",", "",$CI->input->post('total_sgst')),
          'sub_totalq' 			=> $sub_total,
          'total_percent' 		=> $CI->input->post('total_percent'),
          'terms_condition' 	=> $terms_condition,
          'currentdate' 		=> date("y.m.d"),
        );
		 if(isset($post['quote_stage'])){
			$data['quote_stage'] =  $post['quote_stage']; 
		  }
		  if(isset($post['valid_until'])){
			$data['valid_until'] =  $post['valid_until']; 
		  }
		  if(isset($post['email'])){
			$data['email'] =  $post['email']; 
		  }
		  if(isset($post['type'])){
			$data['type'] =  $post['type']; 
		  }
		  //return $data; die;
		  $id = $CI->Quotation->create($data);
		 
		  $quote_id = updateid($id,'quote','quote_id');
		  $quote_data = array( 'track_status' => 'quote');
		  $CI->Lead->update_lead_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
		  $CI->Opportunity->update_opp_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
		  $CI->load->model('Notification_model');
		  $data=$CI->Notification_model->addNotification('quotation',$id);
		  return $quote_id;
		}
    
    }
    
  
  
    
function create_subdomain($subDomain,$cPanelUser,$cPanelPass,$rootDomain) {
 
//  $buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain;
 
    $buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain . "&dir=public_html/subdomains/" . $subDomain;
 
    $openSocket = fsockopen('localhost',2082);
    if(!$openSocket) {
        return "Socket error";
        exit();
    }
 
    $authString = $cPanelUser . ":" . $cPanelPass;
    $authPass = base64_encode($authString);
    $buildHeaders  = "GET " . $buildRequest ."\r\n";
    $buildHeaders .= "HTTP/1.0\r\n";
    $buildHeaders .= "Host:localhost\r\n";
    $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
    $buildHeaders .= "\r\n";
 
    fputs($openSocket, $buildHeaders);
    while(!feof($openSocket)) {
    fgets($openSocket,128);
    }
    fclose($openSocket);
 
    $newDomain = "http://" . $subDomain . "." . $rootDomain . "/";
 
 return "Created subdomain $buildHeaders";
 
}



?>
