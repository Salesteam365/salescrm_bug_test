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




    function create_opportunity($post)
    {  
	
		$CI = & get_instance();
		$CI->load->model('Quotation_model','Quotation');
		$CI->load->model('Salesorders_model','Salesorders');
		$CI->load->model('Reports_model','Reports');
		$CI->load->model('Lead_model','Lead');
		$CI->load->model('Login_model','Login');
		$CI->load->model('Opportunity_model','Opportunity');
	
    	//$CI->input->post() = $post;
        if(!empty($post['lead_id']))
		{
			$lead_id = $post['lead_id'];
			$status = "In Progress";
			$CI->Lead->lead_status($lead_id,$status);
		}
		  
	  
	  $initial_total = str_replace(",", "", $post['initial_total']);
      $unit_price = str_replace(",", "", $post['unit_price']);
      $total = str_replace(",", "", $post['total']);
      //$sub_total = str_replace(",", "", $post['sub_total']);
      $discount = str_replace(",", "", $post['discount']);
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
        'percent' 			=> implode("<br>", $post['percent']),
        'initial_total' 	=> $initial_total,
        'discount' 			=> $discount,
        'sub_total' 		=> $sub_total,
        'total_percent' 	=> $post['total_percent'],
        'currentdate' 		=> date("y.m.d"),
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
      $x = "100";
      $opportunity = $id+$x;
      $opportunity_id = "OPP/".date('Y')."/".$opportunity;
      $CI->Opportunity->opportunity_id($opportunity_id,$id);
      $opp_data = array('opportunity_id' => $opportunity_id, 'track_status' => 'opportunity');
	  if(isset($post['lead_id'])){
      $CI->Lead->update_lead_track_status(array('lead_id' => $post['lead_id']),$opp_data);
	  }
      $CI->load->model('Notification_model');
      $data=$CI->Notification_model->addNotification('opportunity',$id);
      return $opportunity_id;
     
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
		
    	//$CI->input->post() = $post;
		
        $initial_total 	= str_replace(",", "", $CI->input->post('initial_total'));
        $unit_price 	= str_replace(",", "", $CI->input->post('unit_price'));
        $total 			= str_replace(",", "", $CI->input->post('total'));
        $after_discount = str_replace(",", "", $CI->input->post('after_discount'));
        $sub_total 		= str_replace(",", "", $CI->input->post('sub_total'));
		
		if($CI->input->post('terms_condition')){
			$terms_condition=implode("<br>",$CI->input->post('terms_condition'));
		}else{
			$terms_condition='';
		}
  
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
          'percent' 			=> implode("<br>", $CI->input->post('percent')),
          'initial_total' 		=> $initial_total,
          'discount' 			=> $CI->input->post('discount'),
          'after_discount' 		=> $after_discount,          
          'igst12' 				=> $CI->input->post('igst12'),
          'igst18' 				=> $CI->input->post('igst18'),
          'igst28' 				=> $CI->input->post('igst28'),
          'cgst6' 				=> $CI->input->post('cgst6'),
          'sgst6' 				=> $CI->input->post('sgst6'),
          'cgst9' 				=> $CI->input->post('cgst9'),
          'sgst9' 				=> $CI->input->post('sgst9'),
          'cgst14' 				=> $CI->input->post('cgst14'),
          'sgst14' 				=> $CI->input->post('sgst14'),
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
		  $x = "100";
		  $qut = $id+$x;
		  $quote_id = "QUT/".date('Y')."/".$qut;
		  $CI->Quotation->quote_id($quote_id,$id);
		  $quote_data = array( 'track_status' => 'quote');
		  $CI->Lead->update_lead_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
		  $CI->Opportunity->update_opp_track_status(array('opportunity_id' => $opportunity_id),$quote_data);
		  $CI->load->model('Notification_model');
		  $data=$CI->Notification_model->addNotification('quotation',$id);
		  return $quote_id;
    
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
