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



/**
* Returns a human-readable relative time string (e.g., "2 days ago") for a given timestamp.
* @example
* $result = time_elapsed_string('2025-12-18 10:00:00');
* echo $result // render some sample output value; // e.g., "3 days ago"
* @param {string} $timestamp - A date/time string parsable by strtotime (e.g., '2025-12-18 10:00:00').
* @returns {string} Human-readable elapsed time (e.g., "Just Now", "one minute ago", "yesterday", "2 weeks ago").
*/
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



/**
* Convert a numeric amount into words in Indian currency format (Rupees and Paise) in title case.
* @example
* $result = AmountInWords(1234.56);
* echo $result; // One Thousand Two Hundred Thirty Four Rupees And Fifty Six Paise
* @param {{float}} $amount - Amount in rupees (integer part) and paise (decimal part up to 2 places).
* @returns {{string}} String representation of the amount in words, including "Rupees" and optional "Paise".
*/
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




/**
* Generate and echo a nested HTML unordered list (<ul>/<li>) representing the roles tree starting from the given role id.
* @example
* // Example: render tree starting from root (id 0)
* getTreeView(0);
* // Sample output snippet:
* // <ul>
* //   <li> <span class='treeSpan'>Admin   <button class='btnid' data-id='1'>...</button>
* //   <button class='addRol' data-pid='1'>...</button></span>
* //     <ul>
* //       <li> <span class='treeSpan'>Manager ...
* //       </li>
* //     </ul>
* //   </li>
* // </ul>
* @param {int} $id - Parent role ID to build the tree from (use 0 or root id to build full tree).
* @returns {void} Echoes HTML output directly; no value is returned.
*/
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




    /**
     * Create an opportunity record from provided POST-like data, update related lead status, and add a notification.
     * @example
     * $post = array(
     *   'owner' => 'John Doe',
     *   'org_name' => 'Acme Inc',
     *   'subject' => 'New Website',
     *   'contact_name' => 'Jane Smith',
     *   'product_name' => array('Website Design'),
     *   'quantity' => array('1'),
     *   'unit_price' => array('2000'),
     *   'total' => array('2000'),
     *   'percent' => array('0'),
     *   'initial_total' => '2000',
     *   'discount' => '0',
     *   'total_percent' => '2000',
     *   'lead_id' => 1,
     *   'expclose_date' => '2025-12-31',
     *   'pipeline' => 'Sales',
     *   'stage' => 'Qualification',
     *   'lead_source' => 'Website',
     *   'probability' => '50',
     *   'industry' => 'Software',
     *   'type' => 'New Business',
     *   'employees' => '25',
     *   'weighted_revenue' => '1000',
     *   'email' => 'jane@acme.com',
     *   'mobile' => '1234567890'
     * );
     * $result = create_opportunity($post);
     * echo $result; // render sample output value, e.g. "OPP/2025/101"
     * @param {array} $post - Associative array of opportunity data (owner, org_name, subject, product arrays, pricing fields, optional lead and metadata).
     * @returns {string} Generated opportunity identifier (e.g. "OPP/2025/101").
     */
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
  
  
  
    /**
    * Creates a quotation record from posted form data, links it to an opportunity, updates lead/opportunity status and adds a notification, returning the generated quote identifier.
    * @example
    * $post = array(
    *   'owner' => 'John Doe',
    *   'subject' => 'Website Development',
    *   'org_name' => 'Acme Inc',
    *   'product_name' => array('Design','Development'),
    *   'unit_price' => array('1,000','2,000'),
    *   'quantity' => array('1','2'),
    *   'initial_total' => '3,000',
    *   'after_discount' => '2,700',
    *   'sub_total' => '2,700',
    *   'terms_condition' => array('Net 30','No refunds')
    * );
    * $result = create_quote($post, 42);
    * echo $result; // QUT/2025/142
    * @param {{array}} {{$post}} - Associative array of posted quotation data (form fields like owner, subject, product_name[], unit_price[], quantity[], discount, terms_condition[], etc.).
    * @param {{int}} {{$opportunity_id}} - Numeric ID of the related opportunity (e.g. 42).
    * @returns {{string}} Generated quote identifier string in the format "QUT/{year}/{number}" (e.g. "QUT/2025/142").
    */
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
    
    /**
    * Create a subdomain on the local cPanel instance via socket and HTTP request.
    * @example
    * $result = create_subdomain('blog','cpaneluser','cpanelpass','example.com');
    * echo $result // Created subdomain GET /frontend/x3/subdomain/doadddomain.html?rootdomain=example.com&domain=blog&dir=public_html/subdomains/blog ...
    * @param {{string}} {{$subDomain}} - Subdomain name to create (e.g. 'blog').
    * @param {{string}} {{$cPanelUser}} - cPanel username for Basic auth.
    * @param {{string}} {{$cPanelPass}} - cPanel password for Basic auth.
    * @param {{string}} {{$rootDomain}} - Root domain under which to create the subdomain (e.g. 'example.com').
    * @returns {{string}} Returns a status string on success (starts with 'Created subdomain ...') or 'Socket error' on failure.
    */
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
