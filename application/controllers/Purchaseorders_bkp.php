<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchaseorders extends CI_Controller
{
  /**
  * Constructor for the Purchaseorders_bkp controller — calls parent constructor and loads required helpers, models and libraries used by this controller.
  * @example
  * // In CodeIgniter the controller constructor is invoked automatically when controller is instantiated.
  * $CI = new Purchaseorders_bkp(); // instantiation example
  * // After construction: URL helper, models (Quotation, Salesorders, Reports, Purchaseorders, Login, Lead, Opportunity, Workflow) and libraries (upload, pdf, email_lib) are available via $this.
  * @param void $none - No parameters.
  * @returns void Constructor does not return a value.
  */
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Quotation_model','Quotation');
    $this->load->model('Salesorders_model','Salesorders');
    $this->load->model('Reports_model','Reports');
    $this->load->model('Purchaseorders_model','Purchaseorders');
    $this->load->model('Login_model','Login');
    $this->load->model('Lead_model','Lead');
    $this->load->model('Opportunity_model','Opportunity');
	$this->load->model('Workflow_model');
    $this->load->library('upload');
    $this->load->library(array('pdf','email_lib'));
  }
  /**
  * Index method for the Purchaseorders controller — loads the purchase orders page for authenticated users or redirects unauthenticated users to login.
  * @example
  * // When a user is logged in (session 'email' exists)
  * $this->session->set_userdata('email', 'user@example.com');
  * $this->Purchaseorders_bkp->index();
  * // Renders the 'inventory/purchaseorders' view and provides sample data:
  * // $data['branch'] => 'Main Branch'
  * // $data['renewal_data'] => array(...)
  * // $data['workflow_details'] => array(...)
  * // When a user is not logged in (no session 'email')
  * $this->session->unset_userdata('email');
  * $this->Purchaseorders_bkp->index();
  * // Redirects to 'login'
  * @param void $none - No parameters required.
  * @returns void Loads the purchaseorders view with data for authenticated users or performs a redirect to the login page for unauthenticated users.
  */
  public function index()
  {
     
    if(!empty($this->session->userdata('email')))
    {
        
      $data['branch'] = $this->Login->branch_name();
      $data['renewal_data'] = $this->Purchaseorders->get_renewal_po();
	  $data['workflow_details'] = $this->Workflow_model->get_workflows_byModule('Purchaseorders','Purchaseorder approved by user');
      $this->load->view('inventory/purchaseorders',$data);
    }
    else
    {
      redirect('login');
    }
  }
  
  /**
  * Toggle the approval status of a purchase order based on POST input and current session permissions; sends notification emails when a purchase order is approved.
  * @example
  * $_POST['poid'] = 123;
  * $_POST['povalue'] = 1;
  * // Ensure session user is admin or has po_approval = '1'
  * $result = $this->Purchaseorders_bkp->changeStatus();
  * echo $result; // outputs: 1 (success), 0 (update failed) or 2 (unauthorized)
  * @param int $poid - Purchase order ID provided via POST key 'poid' (e.g. 123).
  * @param int $povalue - Approval flag provided via POST key 'povalue': 1 = approve, any other value = disapprove (e.g. 1).
  * @returns int Echoed integer status code: 1 = update successful (and emails sent if approved), 0 = update failed, 2 = unauthorized (insufficient permissions).
  */
  public function changeStatus(){
    if($this->session->userdata('type') == 'admin' || $this->session->userdata('po_approval')=='1')
    {
  	
   $purchase_data = $this->Purchaseorders->get_by_id($this->input->post('poid'));	
   $value= $this->input->post('povalue');
   if($value==1){
    $stts=1;
   }else{
    $stts=0;
   }
   $approved_by = $this->session->userdata('name');
   $chngeSt=array('approve_status' =>$stts ,'approved_by' => $approved_by);
   $where=array('id' => $this->input->post('poid'));
   $data=$this->Purchaseorders->statusPOapprove($where,$chngeSt,$stts);
   echo $data;
   if($data == 1){
	   $subject = "Payment Terms Status";
	   //$adminmessage = "Your Payment Terms Approved";
	    $adminmessage ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>'.$purchase_data->session_company.' Mail</title>
                    <style type="text/css">
                     body {margin: 0; padding: 0; min-width: 100%!important;}
                        .content {width: 100%; max-width: 600px;}  
                    </style>
                </head>
                <body>
                   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: linear-gradient(#0070d2, #448aff);">
                      <td style="text-align:center; height: 60px; color:#fff;"><h2>'.$purchase_data->session_company.'</h2></td>
                    </tr>
                    <tr><td>
                        <table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr><td colspan="2">Hello <b>Team,</td></tr>
                        <tr><td colspan="2">your Purchaseorder Approved with purchaseorder id : <b>'.$purchase_data->purchaseorder_id.'</b></td>
                                        </tr>
                        <tr><td>
                            <table>
                                <tr><td>Purchaseorder ID</td><th>:</th><td>'.$purchase_data->purchaseorder_id.'</td>
                                                </tr>
                                
                                <tr><td>Subject</td><th>:</th><td>'.$purchase_data->subject.'</td>
                                                </tr>
                                <tr><td>Product Name</td><th>:</th><td>'.$purchase_data->product_name.'</td>
                                                </tr>
                                <tr><td>Date</td><th>:</th><td>'.$purchase_data->currentdate.'</td>
                                                </tr>
                            </table>
                          </td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr><th><a href="'.base_url("purchaseorders/view/".$purchase_data->id).'"><button style="background: #1275d9;border: none;color: #fff;padding:5px;border-radius:50px;">View Order</button></a></th></tr>
                        
                        <tr><td><br></td></tr>
                        <tr><th style="text-align:left;">Regards</th></tr>
                        <tr><th style="text-align:left;"><a href="www.team365.io">Team365</a></th></tr>
                    </table>
                   </td>
                  </tr>
                  <tr style="background: linear-gradient(#0070d2, #448aff);">
                    <td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date("Y").' Allegient Services. All rights reserved.</td>
                            </tr>
                </table>
                </body>
               </html>';
	   //send admin email
	   $this->email_lib->send_email($purchase_data->session_comp_email,$subject,$adminmessage);
	   
	   //send purchaseorder user email
	  $this->email_lib->send_email($purchase_data->sess_eml,$subject,$adminmessage);
	   
   }
 }else{
   echo '2';
 }
}


  
  
  
  /**
  * Return a JSON payload of purchase orders formatted for DataTables (echoes output).
  * @example
  * // Prepare POST inputs (examples)
  * $_POST['start'] = 0;
  * $_POST['draw'] = 1;
  * $_POST['actDate'] = '2025-12-01'; // optional
  * // Call from controller context:
  * $this->ajax_list();
  * // Example echoed output (formatted):
  * // {"draw":1,"recordsTotal":42,"recordsFiltered":10,"data":[["Supplier Co<div class=\"links\"><a ...>View</a>|<a ...>Update</a>|<a ...>Delete</a></div>","Customer Co","Supplier Name","Subject text","PO123","Owner Name","Approved By"], ...]}
  * @param array $_POST - POST input used by the method (expects 'start' int, 'draw' int, optional 'actDate' string).
  * @returns void Echoes a JSON-encoded array with keys: draw (int), recordsTotal (int), recordsFiltered (int), data (array of row arrays).
  */
  public function ajax_list()
  {
    $list = $this->Purchaseorders->get_datatables();
    $data = array();
    $no = $_POST['start'];
	$dataAct=$this->input->post('actDate');
    /*if($this->session->userdata('account_type') == 'Trial')
    {*/
		foreach ($list as $post)
		{
			  $no++;
			  $row = array();
			  // APPEND HTML FOR ACTION
			  if($this->session->userdata('delete_po')=='1') { 
			       if($dataAct!='actdata'){
				$row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
			       }
			  }
			  $first_row = "";
			  $first_row.= ucfirst($post->supplier_comp_name).'<div class="links">';
			  if($this->session->userdata('retrieve_po')=='1' || $this->session->userdata('create_inv')==='1'):
				$first_row.= '<a style="text-decoration:none" href="'.base_url().'purchaseorders/view_pi_po/'.$post->id.'" class="text-success">View</a>';
			  endif;
			  if($this->session->userdata('update_po')=='1'):
				$first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary">Update</a>';
			  endif;
			  if($this->session->userdata('delete_po')=='1'):
				$first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
			  endif;
			  $first_row.= '</div>';
			  $row[] = $first_row;
			  $row[] = ucfirst($post->customer_company_name);
			  $row[] = ucfirst($post->supplier_name);
			  $row[] = $post->subject;
			  $row[] = ucfirst($post->purchaseorder_id);
			  $row[] = ucfirst($post->owner);
			  $row[] = $post->approved_by;
			 
			  $data[] = $row;
		/*}
    }elseif($this->session->userdata('account_type') == 'Paid')
    {
		if($this->session->userdata('license_type') == 'Business' || $this->session->userdata('license_type') == 'Enterprise')
		{
			foreach ($list as $post)
			{
				$no++;
				$row = array();
				// APPEND HTML FOR ACTION
				if($this->session->userdata('delete_po')=='1') { 
				     if($dataAct!='actdata'){
					$row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
				     }
				}
				$first_row = "";
				$first_row.= ucfirst($post->supplier_comp_name).'<div class="links">';
				if($this->session->userdata('retrieve_po')=='1' || $this->session->userdata('create_inv')==='1'):
					$first_row.= '<a style="text-decoration:none" href="'.base_url().'purchaseorders/view_pi_po/'.$post->id.'" class="text-success">View</a>';
				endif;
				if($this->session->userdata('update_po')=='1'):
					$first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary">Update</a>';
				endif;
				if($this->session->userdata('delete_po')=='1'):
					$first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
				endif;
				$first_row.= '</div>';
				$row[] = $first_row;
				$row[] = ucfirst($post->customer_company_name);
				$row[] = ucfirst($post->supplier_name);
				$row[] = $post->subject;
				$row[] = ucfirst($post->purchaseorder_id);
				$row[] = ucfirst($post->owner);
				$data[] = $row;
			}
		}*/
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Purchaseorders->count_all(),
      "recordsFiltered" => $this->Purchaseorders->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  /**
  * Returns a JSON array of matching sales order IDs for an autocomplete field based on the 'term' GET parameter and current session context.
  * @example
  * // Simulate request and session context
  * $_GET['term'] = 'SO123';
  * $this->session->set_userdata('email', 'user@example.com');
  * $this->session->set_userdata('company_name', 'Acme Ltd');
  * $this->session->set_userdata('company_email', 'sales@acme.example');
  * // Call the controller action (invoked via HTTP in normal use)
  * $this->Purchaseorders_bkp->autocomplete_soid();
  * // Example output when matches found:
  * // [{"label":"SO12345"},{"label":"SO12346"}]
  * // Example output when no matches:
  * // [{"label":"No Salesorder Found"}]
  * @param {string} $term - Search term obtained from $_GET['term'], e.g. "SO123".
  * @returns {void} Outputs JSON-encoded array of objects with 'label' keys (matching saleorder_id values) or a single 'No Salesorder Found' entry.
  */
  public function autocomplete_soid()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if (isset($_GET['term'])) {
      $result = $this->Purchaseorders->get_so_id($_GET['term'],$sess_eml,$session_company,$session_comp_email);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label' => $row->saleorder_id,
          );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label' => "No Salesorder Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  
  
  
  
  public function check_product_po()
  {
	  $saleorderId 	= $this->input->post('saleorder_id');
	  $ProName 		= $this->input->post('productName');
	  $data 		= $this->Purchaseorders->getProductInfo($saleorderId,$ProName);
	  if(count($data)>0){
		echo $data[0]['pro_name'];
	  }else{
		echo 'found';
	  }
  }
  
  /**
  * Retrieve sale order details and compute product lines that still require purchase orders; echoes a JSON response.
  * @example
  * // Example usage (controller receives POST request):
  * $_POST = ['saleorder_id' => 45];
  * // Within CodeIgniter, calling the controller action will echo the result:
  * $this->Purchaseorders_bkp->get_SO_details();
  * // Example output (success):
  * // {"id":"1","opportunity_id":"10","org_name":"Acme Corp","product_name":"Widget A<br>Widget B","quantity":"2<br>1", ...}
  * // Example output (error when PO already created):
  * // {"error_msg":"<i class=\"fas fa-info-circle\" style=\"color:red;\"></i>&nbsp;&nbsp;PO already created of this SO."}
  * @param {{array}} {{$postData}} - POST payload from $this->input->post(), expected to include 'saleorder_id' (int) identifying the sale order.
  * @returns {{string}} JSON encoded string: on success a JSON object with sale order fields and remaining product-line strings (joined by "<br>"), on failure a JSON object containing 'error_msg'.
  */
  public function get_SO_details()
  {
	  
    $saleorder_id = $this->input->post();
    $data = $this->Purchaseorders->getSOValue($saleorder_id);
	
	 $proName=explode("<br>",$data[0]['product_name']);
	  
	  $proNamepo=0;
	  $soId=$data[0]['saleorder_id'];
	  $poList = $this->Salesorders->CountOrder($soId);
	  foreach ($poList as $Popost)
      {
		$proNamepo2=explode("<br>",$Popost->product_name);
		
		$proNamepo=$proNamepo+count($proNamepo2);
	  }
	  $SOProNameCnt=count($proName);
	  $POProNameCnt=$proNamepo;
	  $arrayData=array();
	if($SOProNameCnt!=$POProNameCnt){
		
		$arrayData['id']			= $data[0]['id'];
		$arrayData['opportunity_id']= $data[0]['opportunity_id'];
		$arrayData['org_name']		= $data[0]['org_name'];
		$arrayData['currentdate']	= $data[0]['currentdate'];
		$arrayData['owner']			= $data[0]['owner'];
		$arrayData['product_line']	= $data[0]['product_line'];
		$arrayData['sess_eml']		= $data[0]['sess_eml'];
		$arrayData['contact_name']	= $data[0]['contact_name'];
		$arrayData['billing_country']= $data[0]['billing_country'];
		$arrayData['billing_state']	 = $data[0]['billing_state'];
		$arrayData['billing_city']	 = $data[0]['billing_city'];
		$arrayData['billing_zipcode']	=$data[0]['billing_zipcode'];
		$arrayData['billing_address']	=$data[0]['billing_address'];
		$arrayData['shipping_country']	=$data[0]['shipping_country'];
		$arrayData['shipping_state']	=$data[0]['shipping_state'];
		$arrayData['shipping_city']		=$data[0]['shipping_city'];
		$arrayData['shipping_zipcode']	=$data[0]['shipping_zipcode'];
		
		$arrayData['shipping_address']  =$data[0]['shipping_address'];      
		$arrayData['type']				=$data[0]['type']; 
		$arrayData['pay_terms_status']	=$data[0]['pay_terms_status']; 
		
		
		$producrName=explode("<br>",$data[0]['product_name']);
		$quantity=explode("<br>",$data[0]['quantity']);
		$unit_price=explode("<br>",$data[0]['unit_price']);
		$total=explode("<br>",$data[0]['total']);
		$percent=explode("<br>",$data[0]['percent']);
		$hsn_sac=explode("<br>",$data[0]['hsn_sac']);
		$hsn_sac=explode("<br>",$data[0]['hsn_sac']);
		
		
		$gst=explode("<br>",$data[0]['gst']);
		$initial_estimate_purchase_price=explode("<br>",$data[0]['initial_estimate_purchase_price']);
		$estimate_purchase_price=explode("<br>",$data[0]['estimate_purchase_price']);
		$sku=explode("<br>",$data[0]['sku']);
		
		
		$ArrTOStrPr=array();
		$ArrTOStrQty=array();
		$ArrTOStrUPr=array();
		$ArrTOStrTtl=array();
		$ArrTOStrPer=array();
		$ArrTOStrHsn=array();
		$ArrTOStrSku=array();
		$ArrTOStrGst=array();
		$ArrTOStrIni=array();
		$ArrTOStrEst=array();
		for($rw=0; $rw<count($producrName); $rw++){
			$prname=$producrName[$rw];
			$dataPr = $this->Purchaseorders->getProductInfo($soId,$prname);
			if(count($dataPr)<1){
				$ArrTOStrPr[]		=$producrName[$rw];      
				$ArrTOStrQty[]		=$quantity[$rw];
				$ArrTOStrUPr[]		=$unit_price[$rw]; 
				$ArrTOStrTtl[]		=$total[$rw];   
				$ArrTOStrPer[]		=$percent[$rw];  
				$ArrTOStrHsn[]		=$hsn_sac[$rw];    
				$ArrTOStrSku[]		=$sku[$rw];
				$ArrTOStrGst[]		=$gst[$rw];
				$ArrTOStrIni[]		=$initial_estimate_purchase_price[$rw];
				$ArrTOStrEst[]		=$estimate_purchase_price[$rw];
				
			}
			
		}  
		
		
				$arrayData['product_name']	=implode("<br>",$ArrTOStrPr);      
				$arrayData['quantity']		=implode("<br>",$ArrTOStrQty); 
				$arrayData['unit_price']	=implode("<br>",$ArrTOStrUPr); 
				$arrayData['total']			=implode("<br>",$ArrTOStrTtl); 
				$arrayData['percent']		=implode("<br>",$ArrTOStrPer);  
				$arrayData['hsn_sac']		=implode("<br>",$ArrTOStrHsn);     
				$arrayData['sku']			=implode("<br>",$ArrTOStrSku); 
				$arrayData['gst']			=implode("<br>",$ArrTOStrGst); 
				$arrayData['initial_estimate_purchase_price']=implode("<br>",$ArrTOStrIni);
				$arrayData['estimate_purchase_price']=implode("<br>",$ArrTOStrEst);

		
		$arrayData['initial_total']=$data[0]['initial_total'];      
		$arrayData['discount']		=$data[0]['discount'];      
		$arrayData['after_discount']=$data[0]['after_discount'];      
		$arrayData['igst12']		=$data[0]['igst12'];      
		$arrayData['igst18']		=$data[0]['igst18'];      
		$arrayData['igst28']		=$data[0]['igst28'];      
		$arrayData['cgst6']			=$data[0]['cgst6'];  

		
		$arrayData['sgst6']			=$data[0]['sgst6'];      
		$arrayData['cgst9']			=$data[0]['cgst9'];      
		$arrayData['sgst9']			=$data[0]['sgst9'];      
		$arrayData['cgst14']		=$data[0]['cgst14'];      
		$arrayData['sgst14']		=$data[0]['sgst14'];      
		$arrayData['sub_totals']	=$data[0]['sub_totals'];      
		$arrayData['customer_company_name']=$data[0]['customer_company_name'];      
		$arrayData['customer_name']	=$data[0]['customer_name'];  

		
		$arrayData['customer_email']	=$data[0]['customer_email'];      
		$arrayData['customer_mobile']	=$data[0]['customer_mobile'];      
		$arrayData['customer_address']	=$data[0]['customer_address'];      
		$arrayData['microsoft_lan_no']	=$data[0]['microsoft_lan_no'];      
		$arrayData['promo_id']	=$data[0]['promo_id'];      
		$arrayData['total_estimate_purchase_price']	=$data[0]['total_estimate_purchase_price'];      
		$arrayData['total_percent']	=$data[0]['total_percent'];        
             
              
               
		echo json_encode($arrayData);
		
	}else{
		$arr_result = array(
          'error_msg' => '<i class="fas fa-info-circle" style="color:red;"></i>&nbsp;&nbsp;PO already created of this SO.'
        );
        echo json_encode($arr_result);
	}
	
  }
  public function get_sub_total()
  {
    $saleorder_id = $this->input->post();
    $val = $this->Purchaseorders->fetch_val($saleorder_id);
    echo json_encode($val);
  }
  public function get_sub_total_wotax()
  {
    $saleorder_id = $this->input->post();
    $val2 = $this->Purchaseorders->fetch_val_wotax($saleorder_id);
    echo json_encode($val2);
  }
  /**
   * Autocomplete vendor names for AJAX requests; retrieves matching vendors based on the GET 'term'
   * and echoes a JSON-encoded array of suggestion objects with 'label' keys.
   * @example
   * // Example using file_get_contents to request the controller endpoint with a search term:
   * $result = file_get_contents('https://example.com/purchaseorders_bkp/autocomplete_vendor?term=Acme');
   * echo $result; // sample output: [{"label":"Acme Corporation"},{"label":"Acme Supplies"}]
   * @param {string} $term - Search term provided via GET parameter 'term' used to match vendor names.
   * @returns {void} Echoes a JSON-encoded array of vendor label suggestions (or [{"label":"No Vendor Found"}]) and does not return a value.
   */
  public function autocomplete_vendor()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if (isset($_GET['term'])) {
      $result = $this->Purchaseorders->get_vendor_name($_GET['term'],$sess_eml,$session_company,$session_comp_email);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label' => $row->org_name,
          );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label' => "No Vendor Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function get_vendor_details()
  {
    $supplier_name = $this->input->post('supplier_name');  
    $data = $this->Purchaseorders->get_vendor_details($supplier_name);
    
    $data2 = $this->Purchaseorders->get_vendor_contact($supplier_name);
    $data3=array_merge($data,$data2);
    echo json_encode($data);
  }
  public function create()
  { 
	 
  
  // echo"testing";
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    { // echo"hello";
      $saleorder_id = $this->input->post('saleorder_id');
     // echo $saleorder_id;
      $progress_remain = $this->input->post('progress_remain');
      $sess_eml = $this->session->userdata('email');
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $sub_total = $this->input->post('sub_total');
      $after_discount = $this->input->post('after_discount');
      $so_owner = $this->input->post('so_owner');
      $so_owner_email = $this->input->post('so_owner_email');
      $org_name = $this->input->post('org_name');
      $currentdate = date("y.m.d");
      $page_source = $this->input->post('page_source');
	  
	  if($this->input->post('terms_condition')){
		  $terms_condition=implode("<br>",$this->input->post('terms_condition'));
	  }else{
		  $terms_condition="";
	  }
	  
     // echo $page_source;
      if($page_source == 'salesorder')
      {  // echo"hello";
  
  
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price_p 	= str_replace(",", "",$this->input->post('unit_price_p'));
        $total_p 		= str_replace(",", "",$this->input->post('total_p'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
        //$total_orc 		= str_replace(",", "",$this->input->post('total_orc'));
        $estimate_purchase_price_p 	= str_replace(",", "",$this->input->post('estimate_purchase_price_p'));
        $initial_est_purchase_price_p 	= str_replace(",", "",$this->input->post('initial_est_purchase_price_p'));
        $total_est_purchase_price 		= str_replace(",", "",$this->input->post('total_est_purchase_price'));
		$profit_by_user					= str_replace(",", "",$this->input->post('profit_by_user'));
  
        $data = array(
          'sess_eml' 			=> $sess_eml,
          'session_company' 	=> $session_company,
          'session_comp_email' 	=> $session_comp_email,
          'owner' 				=> $this->input->post('owner'),
          'saleorder_id' 		=> $saleorder_id,
          'subject' 			=> $this->input->post('subject'),
          'contact_name' 		=> $this->input->post('contact_name'),
          'billing_gstin' 		=> $this->input->post('billing_gstin'),
          'shipping_gstin' 		=> $this->input->post('shipping_gstin'),
          'billing_country' 	=> $this->input->post('billing_country'),
          'billing_state' 		=> $this->input->post('billing_state'),
          'shipping_country' 	=> $this->input->post('shipping_country'),
          'shipping_state' 		=> $this->input->post('shipping_state'),
          'billing_city' 		=> $this->input->post('billing_city'),
          'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
          'shipping_city' 		=> $this->input->post('shipping_city'),
          'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
          'billing_address' 	=> $this->input->post('billing_address'),
          'shipping_address' 	=> $this->input->post('shipping_address'),
          'supplier_name' 		=> $this->input->post('supplier_name'),
          'supplier_contact' 	=> $this->input->post('supplier_contact'),
          'supplier_gstin' 		=> $this->input->post('supplier_gstin'),
          'supplier_comp_name' 	=> $this->input->post('supplier_comp_name'),
          'supplier_email' 		=> $this->input->post('supplier_email'),
          'supplier_country' 	=> $this->input->post('supplier_country'),
          'supplier_state' 		=> $this->input->post('supplier_state'),
          'supplier_city' 		=> $this->input->post('supplier_city'),
          'supplier_zipcode' 	=> $this->input->post('supplier_zipcode'),
          'supplier_address' 	=> $this->input->post('supplier_address'),
          'product_name' 		=> implode("<br>",$this->input->post('product_name_p')),
          'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac_p')),
          'sku' 				=> implode("<br>",$this->input->post('sku_p')),
          'gst' 				=> implode("<br>",$this->input->post('gst_p')),
          'quantity' 			=> implode("<br>",$this->input->post('quantity_p')),
          'unit_price' 			=> implode("<br>",$unit_price_p),
          'total' 				=> implode("<br>",$total_p),
          'percent' 			=> implode("<br>",$this->input->post('percent_p')),
          'initial_total' 		=> $initial_total,
          'discount' 			=> $this->input->post('discount'),
          'after_discount_po' 	=> $after_discount,
          'type' 				=> $this->input->post('type_hidden'),
          'igst12' 				=> $this->input->post('igst12'),
          'igst18' 				=> $this->input->post('igst18'),
          'igst28' 				=> $this->input->post('igst28'),
          'cgst6' 				=> $this->input->post('cgst6'),
          'sgst6' 				=> $this->input->post('sgst6'),
          'cgst9' 				=> $this->input->post('cgst9'),
          'sgst9' 				=> $this->input->post('sgst9'),
          'cgst14' 				=> $this->input->post('cgst14'),
          'sgst14' 				=> $this->input->post('sgst14'),
          'sub_total' 			=> $sub_total,
          'total_percent' 		=> $this->input->post('total_percent'),
          'progress' 			=> $this->input->post('progress'),
          'progress_remain' 	=> $progress_remain,
          'terms_condition' 	=> $terms_condition,
          'customer_company_name' => $this->input->post('company_name'),
          'customer_name' 		=> $this->input->post('customer_name'),
          'customer_email' 		=> $this->input->post('customer_email'),
          'customer_mobile' 	=> $this->input->post('customer_mobile'),
          'microsoft_lan_no' 	=> $this->input->post('microsoft_lan_no'),
          'promo_id' 			=> $this->input->post('promo_id'),
          'customer_address' 	=> $this->input->post('customer_address'),
          'currentdate' 		=> $currentdate,
          'estimate_purchase_price_po' 			=> implode("<br>",$estimate_purchase_price_p),
          'initial_estimate_purchase_price_po' 	=> implode("<br>",$initial_est_purchase_price_p),
          'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
          'profit_by_user_po' 	=> $profit_by_user,
          'so_owner'			=> $this->input->post('owner'),
          'so_owner_email' 		=> $sess_eml,
          'opportunity_id' 		=> $this->input->post('opportunity_id'),
          'org_name' 			=> $org_name,
          'is_renewal' 			=> $this->input->post('is_newed'),
          'renewal_date' 		=> $this->input->post('renewal_date'),
        );
      }
      else if($page_source == 'purchaseorder')
      {
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
        $total 			= str_replace(",", "",$this->input->post('total'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
        //$total_orc 		= str_replace(",", "",$this->input->post('total_orc'));
        $estimate_purchase_price 		= str_replace(",", "",$this->input->post('estimate_purchase_price'));
        $initial_est_purchase_price 	= str_replace(",", "",$this->input->post('initial_est_purchase_price'));
        $total_est_purchase_price 		= str_replace(",", "",$this->input->post('total_est_purchase_price'));
		$profit_by_user					= str_replace(",", "",$this->input->post('profit_by_user'));
		
		if($this->input->post('type_hidden')!=="") {
		     $type = $this->input->post('type_hidden');
		 }else{
		     $type = $this->input->post('type');
		 }
		
        $data = array(
          'sess_eml' 			=> $sess_eml,
          'session_company' 	=> $session_company,
          'session_comp_email' 	=> $session_comp_email,
          'owner' 				=> $this->input->post('owner'),
          'saleorder_id' 		=> $saleorder_id,
          'subject' 			=> $this->input->post('subject'),
          'contact_name' 		=> $this->input->post('contact_name'),
          'billing_gstin' 		=> $this->input->post('billing_gstin'),
          'shipping_gstin' 		=> $this->input->post('shipping_gstin'),
          'billing_country' 	=> $this->input->post('billing_country'),
          'billing_state' 		=> $this->input->post('billing_state'),
          'shipping_country' 	=> $this->input->post('shipping_country'),
          'shipping_state' 		=> $this->input->post('shipping_state'),
          'billing_city' 		=> $this->input->post('billing_city'),
          'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
          'shipping_city' 		=> $this->input->post('shipping_city'),
          'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
          'billing_address' 	=> $this->input->post('billing_address'),
          'shipping_address' 	=> $this->input->post('shipping_address'),
          'supplier_name' 		=> $this->input->post('supplier_name'),
          'supplier_contact' 	=> $this->input->post('supplier_contact'),
          'supplier_gstin' 		=> $this->input->post('supplier_gstin'),
          'supplier_comp_name' 	=> $this->input->post('supplier_comp_name'),
          'supplier_email' 		=> $this->input->post('supplier_email'),
          'supplier_country' 	=> $this->input->post('supplier_country'),
          'supplier_state' 		=> $this->input->post('supplier_state'),
          'supplier_city' 		=> $this->input->post('supplier_city'),
          'supplier_zipcode' 	=> $this->input->post('supplier_zipcode'),
          'supplier_address' 	=> $this->input->post('supplier_address'),
          'product_name' 		=> implode("<br>",$this->input->post('product_name')),
          'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
          'sku' 				=> implode("<br>",$this->input->post('sku')),
          'gst' 				=> implode("<br>",$this->input->post('gst')),
          'quantity' 			=> implode("<br>",$this->input->post('quantity')),
          'unit_price' 			=> implode("<br>",$unit_price),
          'total' 				=> implode("<br>",$total),
          'percent' 			=> implode("<br>",$this->input->post('percent')),
          'initial_total' 		=> $initial_total,
          'discount' 			=> $this->input->post('discount'),
          'after_discount_po' 	=> $after_discount,
          'type' 				=> $type,
          'igst12' 				=> $this->input->post('igst12'),
          'igst18' 				=> $this->input->post('igst18'),
          'igst28' 				=> $this->input->post('igst28'),
          'cgst6' 				=> $this->input->post('cgst6'),
          'sgst6' 				=> $this->input->post('sgst6'),
          'cgst9' 				=> $this->input->post('cgst9'),
          'sgst9' 				=> $this->input->post('sgst9'),
          'cgst14' 				=> $this->input->post('cgst14'),
          'sgst14' 				=> $this->input->post('sgst14'),
          'sub_total' 			=> $sub_total,
          'total_percent' 		=> $this->input->post('total_percent'),
          'progress' 			=> $this->input->post('progress'),
          'progress_remain' 	=> $progress_remain,
          'terms_condition' 	=> $terms_condition,
          'customer_company_name' => $this->input->post('company_name'),
          'customer_name' 		=> $this->input->post('customer_name'),
          'customer_email' 		=> $this->input->post('customer_email'),
          'customer_mobile' 	=> $this->input->post('customer_mobile'),
          'microsoft_lan_no' 	=> $this->input->post('microsoft_lan_no'),
          'promo_id' 			=> $this->input->post('promo_id'),
          'customer_address' 	=> $this->input->post('customer_address'),
          'currentdate' 		=> $currentdate,
          'estimate_purchase_price_po' 			=> implode("<br>",$estimate_purchase_price),
          'initial_estimate_purchase_price_po' 	=> implode("<br>",$initial_est_purchase_price),
          'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
          'profit_by_user_po' 	=> $profit_by_user,
          'so_owner' 			=> $this->input->post('owner'),
          'so_owner_email' 		=> $sess_eml,
          'opportunity_id' 		=> $this->input->post('opportunity_id'),
		  'org_name' 			=> $org_name,
          'is_renewal' 			=> $this->input->post('is_newed'),
          'renewal_date' 		=> $this->input->post('renewal_date'),
        );
      }
      //print_r($data);die;
      $id = $this->Purchaseorders->create($data);
      $val = $this->input->post('val');
      $val2 = $this->input->post('val2');
	  //echo json_encode(array("status" => TRUE));
	  
	   $workflow_details = $this->Workflow_model->get_workflows_byModule('Purchaseorders','Purchaseorder approved by value');
         $povalue_workflow = $workflow_details['limit_so'];
	     //$sovalue_workflow = 1000;
		 //automatic approved PO
	  if($sub_total <= $povalue_workflow){
	       $chngeSt=array('approve_status' => 1 ,'approved_by' => 'auto');
           $where=array('id' => $id);
           $this->Purchaseorders->statusPOapprove($where,$chngeSt,$stts=1); 
	  }
	  
      if(!empty($id))
      {
        
		if($page_source == 'salesorder')
		{	
				$proName		=$this->input->post('product_name_p');
				$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
				$unit_price_prt = str_replace(",", "",$this->input->post('unit_price_p'));
				$total_prt 		= str_replace(",", "",$this->input->post('total_p'));
				$after_discount = str_replace(",", "",$this->input->post('after_discount'));
				$sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
				$quantity_p 	= str_replace(",", "",$this->input->post('quantity_p'));
				$estimate_purchase_price_prt = str_replace(",", "",$this->input->post('estimate_purchase_price_p'));
				$initial_est_purchase_price_prt = str_replace(",", "",$this->input->post('initial_est_purchase_price_p'));
				$total_est_purchase_price = str_replace(",", "",$this->input->post('total_est_purchase_price'));
				$profit_by_user = str_replace(",", "",$this->input->post('profit_by_user'));
			
		}else if($page_source == 'purchaseorder')
		{
				$proName=$this->input->post('product_name');
				$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
				$unit_price_prt = str_replace(",", "",$this->input->post('unit_price'));
				$total_prt 		= str_replace(",", "",$this->input->post('total'));
				$after_discount = str_replace(",", "",$this->input->post('after_discount'));
				$sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
				$quantity_p 	= str_replace(",", "",$this->input->post('quantity'));
				$estimate_purchase_price_prt = str_replace(",", "",$this->input->post('estimate_purchase_price'));
				$initial_est_purchase_price_prt = str_replace(",", "",$this->input->post('initial_est_purchase_price'));
				$total_est_purchase_price = str_replace(",", "",$this->input->post('total_est_purchase_price'));
				$profit_by_user = str_replace(",", "",$this->input->post('profit_by_user'));
		}
		$x = "100";
       // $id = $this->db->insert_id();
        $po = $id+$x;
        $purchaseorder_id = "PO/".date('Y')."/".$po;
		
		$productLine	= $this->input->post('productLine');
		$cntProduct 	= count($proName);
		$totalLine		= intval($productLine)-intval($cntProduct);
		
		if($productLine==$cntProduct || $totalLine==0){
			$this->Salesorders->total_percent($progress_remain,$saleorder_id);
			$dataArr=array(
				'product_line' =>0
			);
			$this->Salesorders->update_product_line($saleorder_id,$dataArr);
		}else{
			$dataArr=array(
				'product_line' =>$totalLine
			);
			$this->Salesorders->update_product_line($saleorder_id,$dataArr);
		}
        $this->Purchaseorders->purchaseorder_id($purchaseorder_id,$id);
        $data = $this->Purchaseorders->get_by_id2($id);
        $this->load->model('Notification_model');
	    $this->Notification_model->addNotification('purchaseorders',$id);
		
		
		
		
			
		$productQty=count($proName);
		
		$calc='';
		for($pr=0; $pr<$productQty; $pr++){
			
			//echo $saleorder_id.",".$proName[$pr]; exit;
			$soDetails = $this->Purchaseorders->soProfitDetails($saleorder_id,$proName[$pr]);
			if(!empty($soDetails)){
			foreach($soDetails as $postSo){
			$calc	= intval($postSo['so_pro_total']) - intval($total_prt[$pr]);
			$proId=$postSo['id'];
			}
			$dtatArr=array(
				'po_id' 			=> $purchaseorder_id,
				'po_qty' 			=> $quantity_p[$pr],
				'po_q_price'		=> $unit_price_prt[$pr],
				'po_est_price'		=> $estimate_purchase_price_prt[$pr],
				'po_total_est_price'=> $initial_est_purchase_price_prt[$pr],
				'po_total_price'	=> $total_prt[$pr],
				'po_after_discount'	=> $after_discount,
				'sales_person_margin'=> $profit_by_user,
				'actual_profit'		=> $calc
			);	
		   $this->Purchaseorders->UpdateProductProfit($dtatArr,$proId,$saleorder_id);
			}
		}
		
	   
		  //set up email
        $this->load->library('email');
           $config = array(
              'protocol'    => 'smtp',
              'smtp_host'   => 'smtp.office365.com',
              'smtp_port'   => 587,
              'smtp_crypto' => 'tls',
              'smtp_user'   => 'no-reply@team365.io', // change it to yours
              'smtp_pass'   => 'Wos13185', // change it to yours
              'mailtype'    => 'html',
              'wordwrap'    => TRUE,
              'crlf'        => "\r",
              'newline'     => "\n",
              'charset'     => "utf-8",
              'wordwrap'    => TRUE
            );
          
          $this->email->initialize($config);
          $this->email->set_crlf("\r\n");
          $this->email->set_newline("\r\n");
          
          /**** SEND TO OWNER MAIL ****/
          $this->email->from($config['smtp_user']);
          $this->email->to($so_owner_email);
          $this->email->subject('Salesorder Progress');
          $this->email->set_mailtype('html');
		  
          if(!empty($data))
          {
			$output = '';
            foreach($data as $row)
            {
               $output .='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Team365 Mail</title>
                    <style type="text/css">
                     body {margin: 0; padding: 0; min-width: 100%!important;}
                        .content {width: 100%; max-width: 600px;}  
                    </style>
                </head>
                <body>
                   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: linear-gradient(#0070d2, #448aff);">
                      <td style="text-align:center; height: 60px; color:#fff;"><h2>Team365</h2></td>
                    </tr>
                    <tr><td>
                        <table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr><td colspan="2">Hello <b>'.$so_owner.'</b></td></tr>
                        <tr><td colspan="2">Purchase order for your Salesorder with salesorder id : <b>'.$row['saleorder_id'].'</b> is created by <b>'.ucwords($row['owner']).'</b></td>
                                        </tr>
                        <tr><td>
                            <table>
                                <tr><td>Salesorder ID</td><th>:</th><td>'.$row['saleorder_id'].'</td>
                                                </tr>
                                <tr><td>Purchaseorder ID</td><th>:</th><td>'.$row['purchaseorder_id'].'</td>
                                                </tr>
                                <tr><td>Vendor Name</td><th>:</th><td>'.$row['supplier_comp_name'].'</td>
                                                </tr>
                                <tr><td>Subject</td><th>:</th><td>'.$row['subject'].'</td>
                                                </tr>
                                <tr><td>Product Name</td><th>:</th><td>'.$row['product_name'].'</td>
                                                </tr>
                                <tr><td>Date</td><th>:</th><td>'.$row['currentdate'].'</td>
                                                </tr>
                            </table>
                          </td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr><th style="text-align:left;">Regards</th></tr>
                        <tr><th style="text-align:left;">Team365</th></tr>
                        
                    </table>
                   </td>
                  </tr>
                  <tr style="background: linear-gradient(#0070d2, #448aff);">
                    <td style="text-align:center;height: 40px; color: aliceblue; font-size:14px;">Copyright © 2014-2020 Allegient Services. All rights reserved.</td>
                            </tr>
                </table>
                </body>
               </html>';         
				$this->email->message($output);
				if(!$this->email->send()){
					  //echo "Mailer Error: " . $mail->ErrorInfo;
				}
            }
          }
		  
		  /**** SEND TO ADMIN MAIL ****/
          
          $this->email->from($config['smtp_user']);
          $this->email->to($session_comp_email);
          $this->email->subject('Salesorder Progress');
          $this->email->set_mailtype('html');
		  
		  
		  if(!empty($data))
          {
              $output = '';
            foreach($data as $row)
            {
                
                $output .='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>Team365 Mail</title>
                    <style type="text/css">
                     body {margin: 0; padding: 0; min-width: 100%!important;}
                        .content {width: 100%; max-width: 600px;}  
                    </style>
                </head>
                <body>
                   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
                    <tr style="background: linear-gradient(#0070d2, #448aff);">
                      <td style="text-align:center; height: 60px; color:#fff;"><h2>Team365</h2></td>
                    </tr>
                    <tr><td>
                        <table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
                        <tr><td colspan="2">Hello <b>Sir,</td></tr>
                        <tr><td colspan="2">Purchase order for your Salesorder with salesorder id : <b>'.$row['saleorder_id'].'</b> is created by <b>'.ucwords($row['owner']).'</b></td>
                                        </tr>
                        <tr><td>
                            <table>
                                <tr><td>Salesorder ID</td><th>:</th><td>'.$row['saleorder_id'].'</td>
                                                </tr>
                                <tr><td>Purchaseorder ID</td><th>:</th><td>'.$row['purchaseorder_id'].'</td>
                                                </tr>
                                <tr><td>Vendor Name</td><th>:</th><td>'.$row['supplier_comp_name'].'</td>
                                                </tr>
                                <tr><td>Subject</td><th>:</th><td>'.$row['subject'].'</td>
                                                </tr>
                                <tr><td>Product Name</td><th>:</th><td>'.$row['product_name'].'</td>
                                                </tr>
                                <tr><td>Date</td><th>:</th><td>'.$row['currentdate'].'</td>
                                                </tr>
                            </table>
                          </td>
                        </tr>
                        <tr><td><br></td></tr>
                        <tr><td><br></td></tr>
                        <tr><th style="text-align:left;">Regards</th></tr>
                        <tr><th style="text-align:left;">Team365</th></tr>
                    </table>
                   </td>
                  </tr>
                  <tr style="background: linear-gradient(#0070d2, #448aff);">
                    <td style="text-align:center;height: 40px; color: aliceblue; font-size:14px;">Copyright © 2014-2020 Allegient Services. All rights reserved.</td>
                            </tr>
                </table>
                </body>
               </html>';
                            
              $this->email->message($output);
              if(!$this->email->send())
              {
                  //echo "Mailer Error: " . $mail->ErrorInfo;
              }
            }
            
          }
          
         /**** end code mail*******/
		  
		  
		  
        // $this->Reports->insert_po_reports($sess_eml,$session_company,$session_comp_email,$saleorder_id,
        // $sub_total,$after_discount,$val,$val2,$currentdate);
        if($progress_remain <= 1)
        {
            $status = "Approved";
            $this->Salesorders->status($status,$saleorder_id);
            // $this->Reports->insert_report_status($status,$saleorder_id);
        }
        else
        {
            $status = "Pending";
            $this->Salesorders->status($status,$saleorder_id);
            // $this->Reports->insert_report_status($status,$saleorder_id);
        }
      //  $this->Reports->insert_report_status($status,$saleorder_id);
       // $reportdate = date("y.m.d");
        // $this->Reports->reportdate($reportdate,$saleorder_id);
        // $this->Reports->salesorder_reportdate($reportdate,$saleorder_id);
        $po_data = array( 'track_status' => 'purchaseorder');
        $this->Lead->update_lead_track_status(array('opportunity_id' => $this->input->post('opportunity_id')),$po_data);
        $this->Opportunity->update_opp_track_status(array('opportunity_id' => $this->input->post('opportunity_id')),$po_data);
        echo json_encode(array("status" => TRUE));
      }
      else
      {
        echo json_encode(array("status" => FALSE));
      }


    }
  }
  public function getbyId($id)
  {
    $data = $this->Purchaseorders->get_by_id($id);
    echo json_encode($data);
  }
  /**
  * Update an existing purchase order using POSTed form data, validate input, persist changes, update related reports and product profit details, and output a JSON status response.
  * @example
  * // Example HTTP call:
  * // GET: ?id=123
  * // POST (sample fields):
  * // subject = "Office Supplies PO"
  * // product_name[] = ["Paper","Ink"]
  * // unit_price[] = ["100","250"]
  * // total[] = ["200","500"]
  * // initial_total = "700"
  * // after_discount = "650"
  * // sub_total = "650"
  * // estimate_purchase_price[] = ["80","200"]
  * // initial_est_purchase_price[] = ["160","400"]
  * // total_est_purchase_price = "560"
  * // profit_by_user = "90"
  * $this->update();
  * // Possible output on success:
  * // {"status":true}
  * @param {int} $id - Purchase order ID obtained from GET parameter 'id'.
  * @returns {void} Echoes a JSON response: {"status":true} on successful update, {"status":false} on failure; may also echo an integer validation error code and terminate if validation fails.
  */
  public function update()
  {
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
		
		
		$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
        $unit_price 	= str_replace(",", "",$this->input->post('unit_price'));
        $total 			= str_replace(",", "",$this->input->post('total'));
        $after_discount = str_replace(",", "",$this->input->post('after_discount'));
        $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
        //$total_orc 		= str_replace(",", "",$this->input->post('total_orc'));
        $estimate_purchase_price 		= str_replace(",", "",$this->input->post('estimate_purchase_price'));
        $initial_est_purchase_price 	= str_replace(",", "",$this->input->post('initial_est_purchase_price'));
        $total_est_purchase_price 		= str_replace(",", "",$this->input->post('total_est_purchase_price'));
		$profit_by_user					= str_replace(",", "",$this->input->post('profit_by_user'));
		if($this->input->post('terms_condition')){
		  $terms_condition=implode("<br>",$this->input->post('terms_condition'));
	    }else{
		  $terms_condition="";
	    }
        $id = $this->input->get('id');
        $data = array(
          'subject' 			=> $this->input->post('subject'),
          'contact_name' 		=> $this->input->post('contact_name'),
          'billing_gstin' 		=> $this->input->post('billing_gstin'),
          'shipping_gstin' 		=> $this->input->post('shipping_gstin'),
          'billing_country' 	=> $this->input->post('billing_country'),
          'billing_state' 		=> $this->input->post('billing_state'),
          'shipping_country' 	=> $this->input->post('shipping_country'),
          'shipping_state' 		=> $this->input->post('shipping_state'),
          'billing_city' 		=> $this->input->post('billing_city'),
          'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
          'shipping_city' 		=> $this->input->post('shipping_city'),
          'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
          'billing_address' 	=> $this->input->post('billing_address'),
          'shipping_address' 	=> $this->input->post('shipping_address'),
          'supplier_name' 		=> $this->input->post('supplier_name'),
          'supplier_gstin' 		=> $this->input->post('supplier_gstin'),
          'supplier_contact' 	=> $this->input->post('supplier_contact'),
          'supplier_comp_name'  => $this->input->post('supplier_comp_name'),
          'supplier_email' 		=> $this->input->post('supplier_email'),
          'supplier_country' 	=> $this->input->post('supplier_country'),
          'supplier_state' 		=> $this->input->post('supplier_state'),
          'supplier_city' 		=> $this->input->post('supplier_city'),
          'supplier_zipcode' 	=> $this->input->post('supplier_zipcode'),
          'supplier_address' 	=> $this->input->post('supplier_address'),
          'product_name' 		=> implode("<br>",$this->input->post('product_name')),
          'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
          'sku' 				=> implode("<br>",$this->input->post('sku')),
          'gst' 				=> implode("<br>",$this->input->post('gst')),
          'quantity' 			=> implode("<br>",$this->input->post('quantity')),
          'unit_price' 			=> implode("<br>",$unit_price),
          'total' 				=> implode("<br>",$total),
          'percent' 			=> implode("<br>",$this->input->post('percent')),
          'initial_total' 		=> $initial_total,
          'discount' 			=> $this->input->post('discount'),
          'after_discount_po' 	=> $after_discount,
          'type' 				=> $this->input->post('type_hidden'),
          'igst12' 				=> $this->input->post('igst12'),
          'igst18' 				=> $this->input->post('igst18'),
          'igst28' 				=> $this->input->post('igst28'),
          'cgst6' 				=> $this->input->post('cgst6'),
          'sgst6' 				=> $this->input->post('sgst6'),
          'cgst9' 				=> $this->input->post('cgst9'),
          'sgst9' 				=> $this->input->post('sgst9'),
          'cgst14' 				=> $this->input->post('cgst14'),
          'sgst14' 				=> $this->input->post('sgst14'),
          'sub_total' 			=> $sub_total,
          'total_percent' 		=> $this->input->post('total_percent'),
          'progress' 			=> $this->input->post('progress'),
          'progress_remain' 	=> $this->session->userdata('progress_remain'),
          'terms_condition' 	=> $terms_condition,
          'customer_company_name' => $this->input->post('company_name'),
          'customer_name' 		=> $this->input->post('customer_name'),
          'customer_email' 		=> $this->input->post('customer_email'),
          'customer_mobile' 	=> $this->input->post('customer_mobile'),
          'microsoft_lan_no' 	=> $this->input->post('microsoft_lan_no'),
          'promo_id'	 		=> $this->input->post('promo_id'),
          'customer_address' 	=> $this->input->post('customer_address'),
          'estimate_purchase_price_po' 			=> implode("<br>",$estimate_purchase_price),
          'initial_estimate_purchase_price_po' 	=> implode("<br>",$initial_est_purchase_price),
          'total_estimate_purchase_price_po' 	=> $total_est_purchase_price,
          'profit_by_user_po' 					=> $profit_by_user
        );
        //print_r($data);die;
        $result = $this->Purchaseorders->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
        if(!empty($result))
        {
          $reportdate = date("y.m.d");
          $x = "100";
          $slo = $id+$x;
          $saleorder_id = "SO/".date('Y')."/".$slo;
          $this->Reports->salesorder_reportdate($reportdate,$saleorder_id);
		  
		  
		 
			$proName=$this->input->post('product_name');
			$saleorderId 	= $this->input->post('saleorder_id');
			$initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
			$unit_price_prt = str_replace(",", "",$this->input->post('unit_price'));
			$total_prt 		= str_replace(",", "",$this->input->post('total'));
			$after_discount = str_replace(",", "",$this->input->post('after_discount'));
			$sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
			$quantity_p 	= str_replace(",", "",$this->input->post('quantity'));
			$estimate_purchase_price_prt = str_replace(",", "",$this->input->post('estimate_purchase_price'));
			$initial_est_purchase_price_prt = str_replace(",", "",$this->input->post('initial_est_purchase_price'));
			$total_est_purchase_price = str_replace(",", "",$this->input->post('total_est_purchase_price'));
			$profit_by_user = str_replace(",", "",$this->input->post('profit_by_user'));
		
			
		$productQty=count($proName);
		
		$calc='';
		for($pr=0; $pr<$productQty; $pr++){
			$soDetails = $this->Purchaseorders->soProfitDetails($saleorderId,$proName[$pr]);
			if(!empty($soDetails)){
			foreach($soDetails as $postSo){
			$calc	= intval($postSo['so_pro_total']) - intval($total_prt[$pr]);
			$proId=$postSo['id'];
			}
			$dtatArr=array(
				'po_qty' 			=> $quantity_p[$pr],
				'po_q_price'		=> $unit_price_prt[$pr],
				'po_est_price'		=> $estimate_purchase_price_prt[$pr],
				'po_total_est_price'=> $initial_est_purchase_price_prt[$pr],
				'po_total_price'	=> $total_prt[$pr],
				'po_after_discount'	=> $after_discount,
				'sales_person_margin'=> $profit_by_user,
				'actual_profit'		=> $calc
			);	
		   $this->Purchaseorders->UpdateProductProfit($dtatArr,$proId,$saleorderId);
			}
		}
		  
		  
		  
          echo json_encode(array("status" => TRUE));
        }else
        {
          echo json_encode(array("status" => FALSE));
        }

    }
  }
  /**
   * Validate purchase order input fields using CodeIgniter's form_validation library.
   * @example
   * $result = $this->check_validation();
   * echo $result // On failure sample output: {"st":202,"subject":"Subject is required","contact_name":"Contact Name is required","billing_country":"Billing Country is required",...}
   * echo $result // On success sample output: 200
   * @returns {int|string} Returns integer 200 when validation passes, or a JSON encoded string (st=>202 and per-field errors) when validation fails.
   */
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    //$this->form_validation->set_rules('saleorder_id', 'Salesorder Id', 'required|trim');
    $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
    $this->form_validation->set_rules('contact_name', 'Contact Name', 'required|trim');
    $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
    $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
    $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
    $this->form_validation->set_rules('shipping_state', 'Shipping State', 'required|trim');
    $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
    $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
    $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
    $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
    $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
    $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
    $this->form_validation->set_rules('supplier_comp_name', 'Supplier Company Name', 'required|trim');
    $this->form_validation->set_rules('supplier_contact', 'Supplier Contact', 'required|trim');
    $this->form_validation->set_rules('supplier_email', 'Supplier Email', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');
    if ($this->form_validation->run() == FALSE)
    {
      return json_encode(array('st'=>202, 'subject'=> form_error('subject'),'contact_name'=> form_error('contact_name'), 'billing_country'=> form_error('billing_country'), 'billing_state'=> form_error('billing_state'), 'shipping_country'=> form_error('shipping_country'),'shipping_state'=> form_error('shipping_state'), 'billing_city'=> form_error('billing_city'), 'billing_zipcode'=> form_error('billing_zipcode'), 'shipping_city'=> form_error('shipping_city'), 'shipping_zipcode'=> form_error('shipping_zipcode'), 'billing_address'=> form_error('billing_address'), 'shipping_address'=> form_error('shipping_address'), 'supplier_comp_name'=> form_error('supplier_comp_name'), 'supplier_contact'=> form_error('supplier_contact'), 'supplier_email'=> form_error('supplier_email')));
    }
    else
    {
      return 200;
    }
  }
  public function delete($id)
  {
    $this->Purchaseorders->delete($id);
    echo json_encode(array("status" => TRUE));
  }
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $this->Purchaseorders->delete_bulk($id[$count]);
      }
    }
  }
  public function getbranchVal()
  {
    $postData = $this->input->post();
    $data = $this->Login->getbranchVals($postData);
    echo json_encode($data);
  }
  /**
   * Generate and stream a Purchase Order PDF for a given purchase ID (from URI segment 3). If URI segment 4 is 'dn' the PDF will be forced as a download.
   * @example
   * // Via HTTP: GET /purchaseorders_bkp/view/123/dn
   * // Or call from controller code:
   * $this->Purchaseorders_bkp->view(); // with URI segment(3) = 123 and segment(4) = 'dn' will stream PURCHASE_123.pdf as a download
   * @param void $none - No direct function parameters. Uses $this->uri->segment(3) for purchase ID (int) and optional $this->uri->segment(4) == 'dn' to force download.
   * @returns void Streams the generated PDF to the browser (either inline or as attachment); does not return a PHP value.
   */
  public function view()
  {
    //if(!empty($this->session->userdata('email')))
   // {  
        if($this->uri->segment(3))
        {
          $download = $this->uri->segment(4);
          $id = $this->uri->segment(3);
          $html_content = '';
          $html_content .= $this->Purchaseorders->view($id);
         // print_r($html_content);die;
          $this->dompdf->loadHtml($html_content);
          ini_set('memory_limit', '128M');
          $this->dompdf->render();
    	  $this->dompdf->setPaper('A4', 'landscape');
    	  
    	  $canvas = $this->dompdf->getCanvas();
          $pdf = $canvas->get_cpdf();
    
          foreach ($pdf->objects as &$o) {
            if ($o['t'] === 'contents') {
                $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
            }
          }
    	  
    	  if(isset($download) && $download=='dn'){
    		$this->dompdf->stream("PURCHASE_".$id.".pdf", array("Attachment"=>1));  
    	  }else{
    		$this->dompdf->stream("PURCHASE_".$id.".pdf", array("Attachment"=>0));  
    	  }
          //$this->dompdf->stream("PURCHASE".$id.".pdf", array("Attachment"=>0));
        }else{
    		redirect('purchaseorders');
    	}
   /* }
    else
    {
      redirect('login');
    }*/ 	
  }
  public function end_renewal()
  {
    $id = $this->input->post('id');
    $this->Purchaseorders->update_end_renewal($id);
    echo json_encode(TRUE);
  }
  public function update_renewal_data()
  {
    $data = $this->Purchaseorders->get_renewal_po();
    echo json_encode($data);
  }
  public function get_po_renewal()
  {
    $data = $this->Purchaseorders->get_renewal_po();
    echo json_encode($data);
  }
  
    /**
    * Load and display the proforma invoice view for a given purchase order ID. If the user is not logged in, redirect to the login page.
    * @example
    * // Call from another controller or within application routing:
    * $this->Purchaseorders_bkp->view_pi_po(123);
    * // Or access via URL: /purchaseorders_bkp/view_pi_po/123
    * @param int $id - Purchase order ID used to retrieve the purchase order record (e.g., 123).
    * @returns void Loads the 'sales/proforma_view_invoicepo' view with the fetched purchase order data or redirects to 'login' if unauthenticated.
    */
    public function view_pi_po($id)
    {
        if(!empty($this->session->userdata('email')))
        {
		$this->db->where('id', $id);
        $data['record'] = $this->db->get('purchaseorder')->row_array();
  	    $this->load->view('sales/proforma_view_invoicepo',$data);
        }
        else
        {
          redirect('login');
        }
		
    
    }
    
    /**
    * Generate a PDF file for a purchase order, save it as assets/img/PURCHASE_<po_id>.pdf and return the file path.
    * @example
    * $result = $this->generate_pdf_attachment(123);
    * echo $result // render some sample output value; // assets/img/PURCHASE_123.pdf
    * @param {int|string} $po_id - Purchase order identifier used to render the PDF and form the filename.
    * @returns {string} Return the relative path to the generated PDF file.
    */
    public function generate_pdf_attachment($po_id)
    {
        
          $this->load->library('pdf');
          
          //$download='';
          $html_content = '';
          $html_content .= $this->Purchaseorders->view($po_id);
          $this->dompdf->loadHtml($html_content);
          ini_set('memory_limit', '128M');
          $this->dompdf->render();
          $canvas = $this->dompdf->getCanvas();
          $pdf = $canvas->get_cpdf();
    
          foreach ($pdf->objects as &$o) {
            if ($o['t'] === 'contents') {
                $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
            }
          }
    	  $attachmentpdf =  $this->dompdf->output();
    	  $path = "assets/img/PURCHASE_".$po_id.".pdf";	 
          file_put_contents($path, $attachmentpdf);
    	  return $path;
    
    }
	
  /**
  * Sends a purchase order email using values from POST, generates a PDF attachment for the given PO id, attempts to send the email (with optional CC) and echoes result.
  * @example
  * $_POST = [
  *   'orgName' => 'Acme Corp',
  *   'orgEmail' => 'billing@acme.test',
  *   'ccEmail' => 'accounting@acme.test',
  *   'subEmail' => 'Purchase Order #12345',
  *   'descriptionTxt' => '<p>Thank you for your order.</p>',
  *   'invoiceurl' => 'https://example.com/invoices/12345',
  *   'po_id' => '12345'
  * ];
  * $this->send_email();
  * // On success this method echoes "1", on failure it echoes "0" and exits.
  * @param {string} $orgName - Organization name read from POST['orgName'].
  * @param {string} $orgEmail - Recipient email read from POST['orgEmail'].
  * @param {string} $ccEmail - CC email read from POST['ccEmail'] (optional).
  * @param {string} $subEmail - Email subject or subtitle read from POST['subEmail'].
  * @param {string} $descriptionTxt - HTML description/body read from POST['descriptionTxt'].
  * @param {string} $invoiceurl - URL to the invoice/purchase order read from POST['invoiceurl'].
  * @param {int|string} $po_id - Purchase order identifier read from POST['po_id']; used to generate the PDF attachment.
  * @returns {void} Echoes "1" on successful send, "0" on failure; the method exits after output and removes the temporary PDF file.
  */
	 public function send_email(){
	  
	  $orgName		  = $this->input->post('orgName');
	  $orgEmail		  = $this->input->post('orgEmail');
	  $ccEmail		  = $this->input->post('ccEmail');
	  $subEmail		  = $this->input->post('subEmail');
	  $descriptionTxt =$this->input->post('descriptionTxt');
	  $invoiceurl	  =$this->input->post('invoiceurl');
	  $po_id	      =$this->input->post('po_id');
	  //attachment 
	  $attach_pdf = $this->generate_pdf_attachment($po_id);
	  
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
                        <a href="https://team365.io/" class="f-fallback email-masthead_name">';
        				$image = $this->session->userdata('company_logo');
        				if(!empty($image))
        				{ $messageBody .=  '<img  src="'.base_url().'/uploads/company_logo/'.$image.'">'; }
        				else {
        					$messageBody .=  '<span class="h5 text-primary">'.$this->session->userdata('company_name').'</span>';
        				}
        		$messageBody.='</a>
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
                                <h1>Hi, '.ucwords($orgName).'!</h1>';
        						
                                $messageBody.='<p>Thank you for shopping at '.$this->session->userdata('company_name').'.</p>';
        						$messageBody.='<p>We appreciate your continued patronage and feel honored that you have chosen our product.</p>';
        						$messageBody.='<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
        						$messageBody.='<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>';
        						
        						
                                $messageBody.='<!-- Action -->
                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                  <tr>
                                    <td align="center">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                        <tr>
                                          <td align="center">
                                            <a href="'.$invoiceurl.'" class="f-fallback button" target="_blank">View Purchaseorder Invoice</a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>';
                                 $messageBody.=$descriptionTxt;
                              $messageBody.='</div>
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
        	
     if(!$this->email_lib->send_email($orgEmail,$subEmail,$messageBody,$ccEmail,$attach_pdf)){
		 echo "0";
	 }else{
		 echo "1";
	 }
	  unlink($attach_pdf); exit;
	  
  }


//Please write code above this
}
?>
