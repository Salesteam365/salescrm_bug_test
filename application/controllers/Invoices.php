<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Invoices extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('invoice_model','vendors_model','organization_model'));
	$this->load->model('Branch_model');
	$this->load->model('Setting_model');
	$this->load->model('Salesorders_model','Salesorders');
	$this->load->model('Login_model','Login');
	$this->load->library('email_lib');
  }
  /**
  * Display the invoice list view or redirect based on authentication and permission checks.
  * @example
  * // Typical call from routing / another controller:
  * $this->Invoices->index();
  * // Possible outcomes:
  * // - Not logged in: redirects to 'login'
  * // - Missing 'Generate Invoicing' module: redirects to 'home'
  * // - Missing 'Invoice' retrieve permission: redirects to 'permission'
  * // - Success: loads 'sales/list-view-invoice' with sample data, e.g.:
  * //   $data['user']  = 'john.doe@example.com';
  * //   $data['admin'] = 'Site Admin';
  * @param void none - No parameters.
  * @returns void Performs redirects or renders the invoice list view.
  */
  public function index()
  {
  	if($this->session->userdata('email'))
    { 
        if(checkModuleForContr('Generate Invoicing')<1){
	        redirect('home');
	    }
		if(check_permission_status('Invoice','retrieve_u')==true){
		  $data 		 = array();
		  $data['user']  = $this->Login->getusername();
		  $data['admin'] = $this->Login->getadminname();
		  $this->load->view('sales/list-view-invoice',$data);
		}else{
			redirect('permission');
		}
		
    }
    else
    {
      redirect('login');
    }
  }
  
  /**
  * Displays invoice detail page after verifying user session, module access and retrieve permission. Expects base64-encoded GET parameters inv_id (invoice id), cnp and ceml; loads 'sales/view-invoice-details' with invoice, branch, client and payment data or redirects to login/permission/home when checks fail.
  * @example
  * // Example (browser URL with sample base64 values):
  * // /invoices/view_invoice?inv_id=MTAwMQ==&cnp=Y29tcGFueTEyMw==&ceml=Y2xpZW50QGV4YW1wbGUuY29t
  * @param {void} $none - No direct function parameters; the method reads GET parameters inv_id, cnp and ceml (base64-encoded).
  * @returns {void} Loads the invoice details view or issues a redirect (to login, permission or home) depending on session and permission checks.
  */
  public function view_invoice()
  {
  	  if($this->session->userdata('email'))
      {
          if(checkModuleForContr('Generate Invoicing')<1){
	        redirect('home');
	      }
	    if(check_permission_status('Invoice','retrieve_u')==true){
    	  $data 		= array();
    	  $data['user'] = $this->Login->getusername();
          $data['admin']= $this->Login->getadminname();
    		$product_id = base64_decode($_GET['inv_id']);
    		$cnp 		= base64_decode($_GET['cnp']);
    		$ceml 		= base64_decode($_GET['ceml']);
    		$data['bank_details_terms'] = $this->invoice_model->get_bank_details();

    		$data['record']  = $this->invoice_model->get_pi_byId($product_id,$cnp,$ceml);
			$data['paymentAd'] = $this->invoice_model->get_inv_payment($product_id);
			
    		if($data['record']['id']){
				$data['otherdata'] =array();
				$data['branch'] = $this->invoice_model->getBranchData($data['record']['branch_id']); 
				$data['clientDtl'] = $this->organization_model->get_by_id($data['record']['cust_id']);
				$this->load->view('sales/view-invoice-details',$data);
    		}
		}else{
			redirect("permission");
		}
      }else{
    	redirect('login');		
      }
    
  }

  public function getinvoicedata()
  {
	 $invoicenum = $this->input->post('invoicenum');
	 $cond=['invoice_no'=>$invoicenum];
  	 $data['invo']=$this->invoice_model->getinvoicedata($cond)->result_array();
	 echo json_encode($data);
    
  }
  
  /**
  * Send an invoice email to a recipient, optionally CC an address and attach a generated PDF invoice.
  * @example
  * $_POST = [
  *   'orgName' => 'Acme Corp',
  *   'orgEmail' => 'billing@acme.com',
  *   'ccEmail' => 'accounting@acme.com',
  *   'subEmail' => 'Invoice from Team365',
  *   'descriptionTxt' => '<p>Your invoice is attached.</p>',
  *   'invoiceurl' => 'https://team365.io/invoice/123',
  *   'piid' => '123',               // internal invoice id
  *   'compeml' => 'invoices@me.com',
  *   'compname' => 'My Company'
  * ];
  * $this->Invoices->send_email();
  * // outputs '1' on success or '0' on failure and exits
  * @param string $orgName - Recipient organization name (POST 'orgName').
  * @param string $orgEmail - Recipient email address (POST 'orgEmail').
  * @param string|null $ccEmail - CC email address, optional (POST 'ccEmail').
  * @param string $subEmail - Email subject (POST 'subEmail').
  * @param string $descriptionTxt - Additional HTML description/body content (POST 'descriptionTxt').
  * @param string $invoiceurl - URL to view the invoice (POST 'invoiceurl').
  * @param int|string $piid - Purchase/invoice identifier used to generate the PDF attachment (POST 'piid').
  * @param string $compeml - Company email used in PDF generation (POST 'compeml').
  * @param string $compname - Company name used in PDF generation and email header (POST 'compname').
  * @returns string Echoes '1' on successful send, '0' on failure; the method echoes the result and exits (no return value).
  */
  public function send_email(){
	  
	  $orgName		= $this->input->post('orgName');
	  $orgEmail		= $this->input->post('orgEmail');
	  $ccEmail		= $this->input->post('ccEmail');
	  $subEmail		= $this->input->post('subEmail');
	  $descriptionTxt=$this->input->post('descriptionTxt');
	  $invoiceurl	=$this->input->post('invoiceurl');
	  $piid		    = $this->input->post('piid');
	  $compeml		= $this->input->post('compeml');
	  $compname		= $this->input->post('compname');
	  //attachment 
	  $attach_pdf = $this->generate_pdf_attachment($piid,$compname,$compeml);
	  //$attach_pdf  = $attach_path;
	  
		  
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
				{ $messageBody .=  '<img  src="'.base_url().'/uploads/company_logo/'.$image.'" style="height:150px;"  >'; }
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
                                    <a href="'.$invoiceurl.'" class="f-fallback button" target="_blank">View Invoice</a>
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
		echo '0';
	}else{
		echo '1';
		
	}
     unlink($attach_pdf); exit;  
	  
  }
  
  
  
  /**
  * Return a JSON-encoded list of invoices formatted for DataTables and echo it.
  * @example
  * // Typical AJAX POST to CodeIgniter controller endpoint:
  * // POST to: /invoices/ajax_list with DataTables parameters (draw, start, length, search, etc.)
  * // Example JSON response:
  * // {
  * //   "draw": 1,
  * //   "recordsTotal": 125,
  * //   "recordsFiltered": 12,
  * //   "data": [
  * //     [
  * //       "INV-001",               // invoice_no (with inline action links)
  * //       "Acme Corporation",      // org_name
  * //       "₹1,200.00",             // formatted sub_total
  * //       "Active",                // status label (Active/Pending)
  * //       "2 days ago",            // human-friendly invoice date (with tooltip full date)
  * //       "<action html>"          // action buttons HTML (view/edit/delete depending on permissions)
  * //     ],
  * //     [
  * //       "INV-002",
  * //       "Beta Ltd",
  * //       "₹3,500.00",
  * //       "Pending",
  * //       "1 month ago",
  * //       "<action html>"
  * //     ]
  * //   ]
  * // }
  * @param void $none - No direct function parameters; uses $_POST and session data inside the controller.
  * @returns void Echoes the JSON response expected by DataTables (draw, recordsTotal, recordsFiltered, data).
  */
  public function ajax_list()
  {
	
	$delete_inv	=0;
	$update_inv	=0;
	$retrieve_inv=0; 
	if(check_permission_status('Invoice','delete_u')==true){
		$delete_inv=1;
	}
	if(check_permission_status('Invoice','retrieve_u')==true){
		$retrieve_inv=1;
	}
	if(check_permission_status('Invoice','update_u')==true){
		$update_inv=1;
	}
	  
    $list = $this->invoice_model->get_datatables();
	
	//print_r($list); exit;
	
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
		
		$encrypted_id 	= base64_encode($post->id);
		$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		$sessionCompany	= base64_encode($this->session->userdata('company_name'));
		 
      $no++;
      $row = array();
        $first_row = "";
        $first_row.= $post->invoice_no.'<!--<div class="links">'; 
        if($retrieve_inv==1):
		$first_row.= '<a style="text-decoration:none" href="'.base_url("invoices/view-invoice?inv_id=".$encrypted_id."&cnp=".$sessionCompany."&ceml=".$sessionEmail).'" class="text-success">View</a> | '; 
		endif;
        if($update_inv==1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url("invoices/edit-invoice/".$post->id."").'" onclick="view('."'".$post->id."'".')" class="text-success">Update</a>';     
        endif;
        if($delete_inv==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_invoice('."'".$post->id."'".')" class="text-danger">Delete</a>';
        endif;
       
      $first_row.= '</div>-->';
      $row[] = $first_row;
	  $row[]    = ucfirst($post->org_name);
      $total    = ucfirst($post->sub_total);     
	  $row[]    = IND_money_format($total);
	  if($post->pi_status==1){
        $row[] = "<text style='color:green;'>Active</text>";
      }else{
        $row[] = "<text style='color:red;'>Pending</text>";
      }	 
	
		$newDate = date("d M Y", strtotime($post->invoice_date));
        $row[] = "<text style='font-size: 12px;' data-toggle='tooltip' data-container='body' title='".$newDate."' >".time_elapsed_string($post->invoice_date)."</text>";
	   
	    $action='<div class="row" style="font-size: 15px;">';
			if($retrieve_inv==1){
				$action.='<a style="text-decoration:none" href="'.base_url("invoices/view-invoice?inv_id=".$encrypted_id."&cnp=".$sessionCompany."&ceml=".$sessionEmail).'"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Invoice Details" ></i></a>';
			}
			if($update_inv==1){
				$action.='<a style="text-decoration:none" href="'.base_url("invoices/edit-invoice/".$post->id."").'" onclick="view('."'".$post->id."'".')"  class="text-primary border-right"> <i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Invoice Details" ></i></a>';
			}	
			
			if($delete_inv==1){	
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_invoice('."'".$post->id."'".')"   class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Invoice" ></i></a>';
			}
			$action.='</div>';
           
	    $row[]=$action; 
  
  
  
          $data[] = $row;
	}
	$output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" =>$this->invoice_model->count_all(),
      "recordsFiltered" => $this->invoice_model->count_filtered(),
      "data" => $data,
    );
      
    echo json_encode($output);
  } 
  
  
  /**
  * Display the "New Invoice" page (or load an existing invoice for update) after validating session and permissions.
  * @example
  * // From a controller context:
  * $this->invoices->new_invoice();
  * // Result: loads 'sales/add-invoices' view with prepared $data (branch, customer, terms, declaration, record, action)
  * // or redirects to 'login', 'home', or 'permission' depending on session/permission checks.
  * @param {void} none - No arguments.
  * @returns {void} Renders the invoice creation/update view or performs a redirect.
  */
  public function new_invoice()
  {
	
  	if($this->session->userdata('email'))
    {
        if(checkModuleForContr('Generate Invoicing')<1){
	        redirect('home');
	        exit;
	    } 

		if(check_permission_status('Invoice','create_u')==true){
			$data['branch_details'] 	= $this->invoice_model->get_branch();
			$data['customer_details']   = $this->invoice_model->get_organization_bytype(); 

			$data['invoice_terms'] 		= $this->invoice_model->getall_terms();
			$data['declaration'] 		= $this->invoice_model->get_declaration();
			$id=$this->uri->segment(3);  
			if(isset($_GET['so']) && $_GET['so']!=""){
				$data['record'] = $this->Salesorders->get_data_for_update($_GET['so']);
				$data['action']=array('data'=>'add','from'=>'quotation');
			}else if(isset($id) && $id!=""){
				$data['record'] = $this->invoice_model->get_data_for_update($id);
				$data['action']=array('data'=>'update','from'=>'salesorder');
			}else{
				$data['action']=array('data'=>'add','from'=>'direct');
			}
			
			$data['gstPer']     = $this->Salesorders->get_gst();
			// print_r($data['record'] );die;
			$this->load->view('sales/add-invoices',$data);
			
		}else{
			redirect("permission");
		}			
	
    }
    else
    {
      redirect('login');
    }
  }
  
  
  
  
  /**
   * Prepare and render the "New Invoice" creation page after validating session, module access,
   * user permissions and account license/invoice limits. Loads data used by the 'setting/invoices' view
   * (admin, branch, customer, terms, and any existing record when an ID segment is present).
   * May redirect to 'login', 'permission' or 'home' depending on checks.
   * @example
   * // From another controller method (when session/email present and permissions allow):
   * $this->Invoices->new_invoice_old();
   * // Result: renders the 'setting/invoices' view with prepared $data, or redirects to 'login', 'permission' or 'home'.
   * @param {{void}} {{none}} - This controller method does not accept parameters.
   * @returns {{void}} Does not return a value; outputs a view or performs a redirect.
   */
  public function new_invoice_old()
  {
  	if($this->session->userdata('email'))
    {
        if(checkModuleForContr('Generate Invoicing')<1){
	        redirect('home');
	        exit;
	    } 

		if(check_permission_status('Invoice','create_u')==true){
            
		$data = array();
		
		 $Adminlist = $this->Login->get_admin_detail();
	     $totalinvoice = $this->invoice_model->total_invoiceMonth();//exit;
		 foreach($Adminlist as $admin):
		 if($admin->invoice_account_type == ''){
			if($totalinvoice == 10)
			{
			    $data['totalinvoices'] = $totalinvoice;
			    $data['check_totalinvoice'] = 'full';
			}else{ 
				$data['check_totalinvoice'] = 'not_full';
				
			 }
		    }else if($admin->invoice_account_type == 'Paid'){
		        if($admin->invoice_license_type == 'Basic'){
		            if($totalinvoice == 100)
        			{
        			    $data['totalinvoices'] = $totalinvoice;
        			    $data['check_totalinvoice'] = 'full';
        			}else{ 
        				$data['check_totalinvoice'] = 'not_full';
        				
        			 }
		      	   //$data['check_totalinvoice'] =  'not_full';
		        }elseif($admin->invoice_license_type == 'Standard'){
		            if($totalinvoice == 500)
        			{
        			    $data['totalinvoices'] = $totalinvoice;
        			    $data['check_totalinvoice'] = 'full';
        			}else{ 
        				$data['check_totalinvoice'] = 'not_full';
        				
        			 }
		        }elseif($admin->invoice_license_type == 'Professional'){
		            $data['check_totalinvoice'] = 'not_full';
		        }
		    }
        endforeach;
		
        if($this->uri->segment(3))
        {
            $product_id = $this->uri->segment(3);
            $data['record'] = $this->invoice_model->get_pi_byId($product_id);
                               		
        }else{
            $data['record']=array(); 
        }
        $session_comp_email 		= $this->session->userdata('company_email');
        $data['admin_details'] 		= $this->invoice_model->get_Comp($session_comp_email);
        $data['branch_details'] 	= $this->invoice_model->get_branch();
        $data['customer_details'] = $this->invoice_model->get_organization_bytype(); 
                	 
        $data['city_name'] = $this->session->userdata("city");
        $data['invoice_terms'] = $this->invoice_model->getall_terms();
    
        $this->load->view('setting/invoices',$data);
		}else{
			redirect("permission");
		}			
	
    }
    else
    {
      redirect('login');
    }
  }
  
    /**
     * Check monthly invoice total against the admin account/license limits and echo a JSON response.
     * This method retrieves admin details and the total invoices for the current month, compares the total
     * against different limits depending on the admin's invoice_account_type and invoice_license_type,
     * and echoes a JSON object indicating whether the limit is exceeded.
     * Behavior:
     *  - For free accounts (invoice_account_type == '') the limit is 9 invoices.
     *  - For Paid accounts with license 'Basic' the limit is 99 invoices.
     *  - For Paid accounts with license 'Standard' the limit is 499 invoices.
     *  - For Paid accounts with license 'Professional' there is no limit (always returns status 200).
     *  - If the total is within the allowed limit the method echoes: {"status":200}
     *  - If the total exceeds the allowed limit the method echoes: {"status":201,"totalinvoices":<number>}
     *
     * @example
     * // Called from a controller context (no arguments). Example outputs shown:
     * $this->Invoices->checkInvoicetotal();
     * // Possible echoed responses:
     * // {"status":200}
     * // {"status":201,"totalinvoices":123}
     *
     * @returns {void} Echoes a JSON response directly; no return value.
     */
    public function checkInvoicetotal()
    {
         $Adminlist = $this->Login->get_admin_detail();
	     $totalinvoice = $this->invoice_model->total_invoiceMonth();//exit;
		 foreach($Adminlist as $admin):
		 if($admin->invoice_account_type == ''){
			if($totalinvoice <= 9)
			{
			    echo json_encode(array("status" => 200));
			}else{ 
				 echo json_encode(array("status" => 201 , "totalinvoices" => $totalinvoice));   
				
			 }
		    }else if($admin->invoice_account_type == 'Paid'){
		        
		        if($admin->invoice_license_type == 'Basic'){
		            if($totalinvoice <= 99)
        			{
        			     echo json_encode(array("status" => 200));
        			}else{ 
        				 echo json_encode(array("status" => 201 , "totalinvoices" => $totalinvoice));
        				
        			 }
		      	   //$data['check_totalinvoice'] =  'not_full';
		        }elseif($admin->invoice_license_type == 'Standard'){
		            if($totalinvoice <= 499)
        			{
        			     echo json_encode(array("status" => 200));
        			}else{ 
        				 echo json_encode(array("status" => 201 , "totalinvoices" => $totalinvoice));
        				
        			 }
		        }elseif($admin->invoice_license_type == 'Professional'){
		           echo json_encode(array("status" => 200));
		        }
		    
		      	    
		    }
        endforeach;
    }
  public function put_id_for_pi(){
	 $pageName	= $this->input->post('page');
	 $itmid		= explode("/",$this->input->post('itemid'));
	 if($pageName=='quotation'){
			echo "QTN".date('Y').($itmid[2]-100);
	 }else if($pageName=='salesorder'){
			echo "SO".date('Y').($itmid[2]-100);
	 }else if($pageName=='purchaseorder'){
			echo "PO".date('Y').($itmid[2]-100);
	 }
  }
  
  
  
  /**
  * Delete a pro forma invoice (PI) by ID, update the related sale order payment and output a JSON status.
  * @example
  * $result = $this->delete_pi(123);
  * echo $result // {"status":true}
  * @param {int} $id - ID of the pro forma/invoice to delete.
  * @returns {void} Echoes a JSON encoded status response (e.g., {"status":true}).
  */
  public function delete_pi($id)
  {
    $this->invoice_model->delete_pi($id);
	$data = $this->invoice_model->get_pi_byId($id);
	    $data=array(
		 "invoice_id" 		=> '',
		 "pending_payment" 	=> $data['sub_total'],
		 "advanced_payment" => 0
        );	
		
		$this->invoice_model->update_so_payment(array('saleorder_id' => $data['saleorder_id'],'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
	
    echo json_encode(array("status" => TRUE));
  }
  
  /**
  * Create a new invoice from submitted POST data: validate input, assemble invoice details, persist the invoice,
  * create payment history and update related sales order payment, then send workflow-driven email notifications.
  * Echoes a JSON response with a redirect URL fragment on success or an error status on failure.
  * @example
  * // Invoked from controller (reads $_POST). Example successful echoed output:
  * // $this->add_invoiceDetails();
  * // Outputs: {"status": true, "id": "?inv_id=MTIz&cnp=Q29tcGFueQ==&ceml=Y2VtcEBleGFtcGxlLmNvbQ=="}
  * @param {void} $none - No function arguments; uses $this->input->post() to read form fields.
  * @returns {void} Echoes JSON. On success: {"status": true, "id": "<url_fragment>"}; on failure: {"status": false} or validation error code.
  */
  public function add_invoiceDetails()
  {
	
  	$validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
	  
    }
    else
    {
		
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", $this->input->post('discount_price'));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	    $advanced_payment = str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
		
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
       
	  
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'saleorder_id' 		=> $this->input->post('saleorder_id'),
        'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
        'cust_order_no'		=> $this->input->post('order_no'),
        'buyer_date'		=> $this->input->post('buyer_date'),
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
        'invoice_declaration'=> $this->input->post('invoice_declaration'),
        'branch_id'   		=> $this->input->post('shipto'),
		//'discount_type' 	=> $this->input->post('sel_disc'),
		//'discount' 	        => $this->input->post('discount'),
		'notes' 			=> $this->input->post('notes'),
		//'attachment' 		=> $attachment,
		//'signature_img' 	=> $signature_img,
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment	        

      );
	//   print_r($data);die;
      $id = $this->invoice_model->create_pi($data);
	  
      if($id){
		$invoice_no=updateid($id,'invoices','invoice_no');	
		
		$createdata=array(
	     "sales_id"           => $this->input->post('saleorder_id'),
	     "invoice_id"         => $id,
	     "sess_eml"           => $this->session->userdata('email'),
		 "session_company"    => $this->session->userdata('company_name'),
		 "session_comp_email" => $this->session->userdata('company_email'),
         "payment_mode"       => 'Adavanced Payment',
		 "reference_no"       => 'Advanced Payment by Customer',		
		 "total_payment"      => $sub_total,
		 "adv_payment"        => $advanced_payment,
		 "pending_payment"    => $pendingPayment,
		 "payment_date"       => $this->input->post('buyer_date'),
		 "remarks"            => '',
		 "ip"                 => $this->input->ip_address()
         );
	$results = $this->invoice_model->create_paymentHistory($createdata);
	$data=array(
		 "invoice_id" 		=> $invoice_no,
		 "pending_payment" 	=> $pendingPayment,
		 "advanced_payment" => $advanced_payment
        );	
		
		$result = $this->invoice_model->update_so_payment(array('saleorder_id' => $this->input->post('saleorder_id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
		
		$encrypted_id 	= base64_encode($id);
		$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		$sessionCompany	= base64_encode($this->session->userdata('company_name'));
		$url="?inv_id=".$encrypted_id."&cnp=".$sessionCompany."&ceml=".$sessionEmail;
		echo json_encode(array("status" => TRUE,'id'=>$url));
	
	$CustomerDtl= $this->organization_model->get_by_id($org_id);	
	$workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on invoice create');
	if($workFlowStsAdmin==true){
		 $messagetoAdmin='';
		 $subjectAdmin="A new invoice created";
		 $messagetoAdmin.='
		 <div class="f-fallback">
		        <center><h1>INVOICE</h1></center>
            <h2>Dear , Admin!</h2>';
        $messagetoAdmin.='<p>A new invoice created by '.$this->session->userdata('name').'</p>';
    	$messagetoAdmin.='<p>Invoice Detail:-</p>';
		$messagetoAdmin.='<p>Invoice create for : '.$CustomerDtl->org_name.'</p>';
		$messagetoAdmin.='<p>Contact name : '.$CustomerDtl->primary_contact.'</p>';
		$messagetoAdmin.='<p>Supplier Ref. : '.$this->input->post('supplier').'</p>';
		$messagetoAdmin.='<p>Other Reference(s) : '.$this->session->userdata('name').'</p>';
    	$messagetoAdmin.='<p>
			Invoice No. : '.$invoice_no.'
			<br>
			BuyerOrder No.: '.$this->input->post('order_no').'
			<br>
			Due Date : '.date('d M Y',strtotime($this->input->post('invoice_dueDate'))).'
			<br>
			Total Price : ₹'.$this->input->post('sub_total').'
			</p>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);
	}
	
	
	$workFlowStsUser	= check_workflow_status('Invoice','Mail notification to invoice owner on created');
	if($workFlowStsUser==true){
		 $messagetoAdmin='';
		 $subjectAdmin="A new invoice created by you";
		 $messagetoAdmin.='
		 <div class="f-fallback">
		        <center><h1>INVOICE</h1></center>
            <h2>Dear , '.$this->session->userdata('name').'!</h2>';
        $messagetoAdmin.='<p>A new invoice created by '.$this->session->userdata('name').'</p>';
    	$messagetoAdmin.='<p>Invoice Detail:-</p>';
		$messagetoAdmin.='<p>Invoice create for : '.$CustomerDtl->org_name.'</p>';
		$messagetoAdmin.='<p>Contact name : '.$CustomerDtl->primary_contact.'</p>';
		$messagetoAdmin.='<p>Supplier Ref. : '.$this->input->post('supplier').'</p>';
		$messagetoAdmin.='<p>Other Reference(s) : '.$this->session->userdata('name').'</p>';
    	$messagetoAdmin.='<p>
			Invoice No. : '.$invoice_no.'
			<br>
			BuyerOrder No.: '.$this->input->post('order_no').'
			<br>
			Due Date : '.date('d M Y',strtotime($this->input->post('invoice_dueDate'))).'
			<br>
			Total Price : ₹'.$this->input->post('sub_total').'
			</p>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->session->userdata('email'),$messagetoAdmin,$subjectAdmin);
	}
	
	$workFlowStsCust = check_workflow_status('Customer','Mail notification on invoice created');	
	if($workFlowStsCust==true){
	     $messagetoCust='';
		 $messagetoCust="You have new invoice from ".$this->session->userdata('company_name');
		 $messagetoCust.='
		 <div class="f-fallback">
		        <center><h1>INVOICE</h1></center>
            <h2>Dear , '.$org_name.'!</h2>';
        $messagetoCust.='<p>A new invoice for you from '.$this->session->userdata('company_name').'</p>';
    	$messagetoCust.='<p>We have prepared following invoice for you :-</p>';
		$messagetoAdmin.='<p>Invoice create for : '.$CustomerDtl->org_name.'</p>';
		$messagetoAdmin.='<p>Contact name : '.$CustomerDtl->primary_contact.'</p>';
		$messagetoCust.='<p>Supplier Ref. : '.$this->input->post('supplier').'</p>';
		$messagetoCust.='<p>Other Reference(s) : '.$this->session->userdata('name').'</p>';
    	$messagetoCust.='<p>
			Invoice No. : '.$invoice_no.'
			<br>
			Buyer Order No.: '.$this->input->post('order_no').'
			<br>
			Due Date : '.date('d M Y',strtotime($this->input->post('invoice_dueDate'))).'
			<br>
			Total Price : ₹'.$this->input->post('sub_total').'
			</p>';
    		$messagetoCust.='</div>';
			sendMailWithTemp($CustomerDtl->email,$messagetoAdmin,$subjectAdmin);
	}
	
	
	$workFlowStsSoOwner = check_workflow_status('Invoice','Mail notification to SO owner on invoice created');	
	if($workFlowStsSoOwner==true){
	    
	    $sales_data = $this->invoice_model->getsalesbyid($this->input->post('saleorder_id'));
	     $messagetoCust='';
		 $messagetoCust="A new invoice for your sales order";
		 $messagetoCust.='
		 <div class="f-fallback">
		        <center><h1>INVOICE</h1></center>
            <h2>Dear , '.$this->input->post('supplier').'!</h2>';
        $messagetoCust.='<p>A new invoice for your customer '.$CustomerDtl->org_name.'</p>';
    	$messagetoCust.='<p>We have prepared following invoice for your customer :-</p>';
		$messagetoAdmin.='<p>Invoice create for : '.$CustomerDtl->org_name.'</p>';
		$messagetoAdmin.='<p>Contact name : '.$CustomerDtl->primary_contact.'</p>';
		$messagetoCust.='<p>Supplier Ref. : '.$this->input->post('supplier').'</p>';
		$messagetoCust.='<p>Other Reference(s) : '.$this->session->userdata('name').'</p>';
    	$messagetoCust.='<p>
    	    Sales order id : '.$this->input->post('saleorder_id').'
			<br>
			Invoice No. : '.$invoice_no.'
			<br>
			Buyer Order No.: '.$this->input->post('order_no').'
			<br>
			Due Date : '.date('d M Y',strtotime($this->input->post('invoice_dueDate'))).'
			<br>
			Total Price : ₹'.$this->input->post('sub_total').'
			</p>';
    		$messagetoCust.='</div>';
			sendMailWithTemp($sales_data['sess_eml'],$messagetoAdmin,$subjectAdmin);
	}
	
		
	  }
      else
      {
        echo json_encode(array("status" => FALSE));
      }
	}
  }
  
  
  /**
  * Update invoice details from POST data, persist changes to the database and echo a JSON status response.
  * @example
  * // Called in a controller context after sending POST data (invoice_date, product_name, unit_price, etc.)
  * $this->update_invoiceDetails();
  * // Sample echoed output:
  * // {"status":true,"id":"?inv_id=QzEyMzQ=&cnp=Q29tcGFueU5hbWU=&ceml=Y29tcEBleGFtcGxlLmNvbQ==","st":200}
  * @param array|null $postData - POST payload (accessed via $this->input->post()) containing invoice fields such as 'invoice_date' => '2025-12-01', 'product_name' => ['Widget A','Widget B'], 'unit_price' => ['1000','2000'], 'invc_id' => '1234', etc.
  * @returns void Echoes JSON indicating success or failure and does not return a value.
  */
  public function update_invoiceDetails(){
	  
	$validation = $this->check_validation();
    if($validation!=200){
      echo $validation;die;
    }else{  
		if($this->input->post('igst')!=""){
			$igst=implode("<br>", $this->input->post('igst'));
		}else{ $igst=''; }
		if($this->input->post('cgst')!=""){
			$cgst=implode("<br>", $this->input->post('cgst'));
		}else{ 	$cgst=''; }
		if($this->input->post('sgst')!=""){
			$sgst=implode("<br>", $this->input->post('sgst'));
		}else{ $sgst=''; }
		
		if($this->input->post('discount_price')!=""){
			$discount_price=implode("<br>", str_replace(",","",$this->input->post('discount_price')));
		}else{ $discount_price=''; }
		
		if($this->input->post('terms_condition')){
			$terms_condition=implode("<br>",$this->input->post('terms_condition'));
		}else{ $terms_condition=''; }
		if($this->input->post('extra_charge')!=""){
			$extra_charge=implode("<br>", $this->input->post('extra_charge'));
		}else{ $extra_charge=''; }
		if($this->input->post('extra_chargevalue')!=""){
			$extra_chargevalue=implode("<br>", $this->input->post('extra_chargevalue'));
		}else{ $extra_chargevalue=''; }	
		if($this->input->post('label')){
			$lable=implode("<br>",$this->input->post('label'));
	    }else{ $lable='';}
	    if($this->input->post('label_value')){
			$label_value=implode("<br>",$this->input->post('label_value'));
	    }else{ $label_value='';}
	    if($this->input->post('product_desc')){
			$product_desc=implode("<br>",$this->input->post('product_desc'));
	    }else{ $product_desc=''; }
	   
	   if($this->input->post('sub_total_with_gst')){
			$sub_totalwithgst=implode("<br>",$this->input->post('sub_total_with_gst'));
	    }else{ $sub_totalwithgst=''; }
	   
	   
      $unit_price 		= str_replace(",", "",$this->input->post('unit_price'));
      $total 			= str_replace(",", "",$this->input->post('total'));
	  $after_discount 	= str_replace(",", "",$this->input->post('after_discount'));
	  $initial_total 	= str_replace(",", "",$this->input->post('initial_total'));
	  $total_discount 	= str_replace(",", "",$this->input->post('discount'));
	  $sub_total 		= str_replace(",", "",$this->input->post('sub_total'));
	  
	  $advanced_payment=str_replace(",", "",$this->input->post('advance_payment'));
		if($advanced_payment==""){
			$advanced_payment=0;
		}
		$pendingPayment=$sub_total-$advanced_payment;
	  
	  $org_name = $this->input->post('customer_name');
	  $org_id = $this->input->post('customer_id');
       
	  
      $data = array(
        'invoice_date' 		=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
        'due_date' 			=> date('Y-m-d',strtotime($this->input->post('invoice_dueDate'))),
		'inv_terms' 		=> $this->input->post('terms_select'),
        'extra_field_label' => $lable,
		'extra_field_value' => $label_value,
        'org_name' 	    	=> $org_name,
        'cust_id' 	    	=> $org_id,
		'so_owner' 			=> $this->input->post('supplier'),
        'owner' 			=> $this->input->post('owner'),
        'cust_order_no'		=> $this->input->post('order_no'),
		'buyer_date'		=> $this->input->post('buyer_date'),
        'branch_id'   		=> $this->input->post('shipto'),
		'invoice_declaration'=> $this->input->post('invoice_declaration'),
		'notes' 			=> $this->input->post('notes'),
		'pro_description' 	=> $product_desc,		
		'enquiry_email' 	=> $this->input->post('enquiry_email'),
		'enquiry_mobile' 	=> $this->input->post('enquiry_mobile'),
		'jurisdiction' 		=> $this->input->post('jurisdiction'),
		'late_charge' 		=> $this->input->post('late_charge'),
        'product_name' 		=> implode("<br>",$this->input->post('product_name')),
        'hsn_sac' 			=> implode("<br>",$this->input->post('hsn_sac')),
		'gst' 				=> implode("<br>",$this->input->post('gst')),
		'quantity' 			=> implode("<br>",$this->input->post('quantity')),
        'unit_price' 		=> implode("<br>",$unit_price),
        'pro_discount' 		=> $discount_price,
        'total' 			=> implode("<br>",$total),
		'sgst' 				=> $sgst,
		'igst' 				=> $igst,
		'cgst' 				=> $cgst,
		'type' 				=> $this->input->post('type'),
		'sub_total_with_gst'=> $sub_totalwithgst,
		'extra_charge_label'=> $extra_charge,
		'extra_charge_value'=> $extra_chargevalue,
		'terms_condition' 	=> $terms_condition,
        'total_discount' 	=> $total_discount,
        'initial_total' 	=> $initial_total,        
        'sub_total' 		=> $sub_total,
		'total_igst' 		=> str_replace(",", "",$this->input->post('total_igst')),
        'total_cgst' 		=> str_replace(",", "",$this->input->post('total_cgst')),
        'total_sgst' 		=> str_replace(",", "",$this->input->post('total_sgst')),
		'advanced_payment' 	=> $advanced_payment,
        'pending_payment' 	=> $pendingPayment,
		
		// 'pay_mode' 			=> $this->input->post('pay_mode'),
		// 'transction_id' 	=> $this->input->post('transction_id'),
		// 'reference_no' 		=> $this->input->post('reference_no'),
		// 'paid_amount' 		=> $this->input->post('paid_amount'),
		// 'due_amount' 		=> $this->input->post('due_amount')
		

      );
	  
	  $piId=$this->input->post('invc_id');
	//   print_r($data);die;
      $id = $this->invoice_model->update_pi($data,$piId);
	  
      if($id){	
		$encrypted_id 	= base64_encode($piId);
		$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
		$sessionCompany	= base64_encode($this->session->userdata('company_name'));
		$url="?inv_id=".$encrypted_id."&cnp=".$sessionCompany."&ceml=".$sessionEmail;
		echo json_encode(array("status" => TRUE,'id'=>$url,'st'=>200));
	  }else{
        echo json_encode(array("status" => FALSE));
      }
	}  
	  
  }
  
  
  /**
  * Validate invoice form input and return validation errors as JSON or HTTP status 200 on success.
  * @example
  * $result = $this->check_validation();
  * echo $result; // On failure (sample): {"st":202,"invoice_date":"Invoice Date is required","product_name":"product name is required","quantity":"Quantity is required","unit_price":"Unit Price is required","billedby":"Ship To is required","billedto":"Customer Name is required"}
  * // On success (sample):
  * echo $result; // 200
  * @returns {int|string} Return 200 (int) when validation passes; otherwise a JSON-encoded string containing validation error messages and a status code 202.
  */
  public function check_validation()
  {
    //$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
    $this->form_validation->set_rules('product_name[]', 'product name', 'required|trim');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
    $this->form_validation->set_rules('unit_price[]', 'Unit Price', 'required|trim');
	$this->form_validation->set_rules('shipto', 'Ship To', 'required|trim');
	$this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');

    // $this->form_validation->set_rules('pay_mode', 'Pay Mode', 'required|trim');
    // $this->form_validation->set_rules('transction_id', 'Transction Id', 'required|trim');
    // $this->form_validation->set_rules('reference_no', 'Refeence No', 'required|trim');
    // $this->form_validation->set_rules('paid_amount', 'Paid Amount', 'required|trim');
    // $this->form_validation->set_rules('due_amount', 'Due Amount', 'required|trim');

   
    if ($this->form_validation->run() == FALSE)
    {
		
      return json_encode(array('st'=>202, 'invoice_date'=> form_error('invoice_date'),'product_name'=> form_error('product_name'), 'quantity'=> form_error('quantity'), 'unit_price'=> form_error('unit_price'), 'billedby'=> form_error('shipto'), 'billedto'=> form_error('customer_name')));
		
    }
    else
    {
      return 200;
    }
  }
  /**
  * Uploads a base64-encoded signature image (data URI) to the server and returns the saved filename.
  * @example
  * $signatureData = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...'; // sample base64 data URI
  * $result = $this->uploadSignature($signatureData);
  * echo $result; // render some sample output value, e.g. "605c8e3a9f7b2.png"
  * @param {{string}} {{$signature_image}} - Base64-encoded image string in data URI format (e.g. "data:image/png;base64,...").
  * @returns {{string}} The generated filename (unique id + extension) of the saved image (e.g. "605c8e3a9f7b2.png").
  */
  public function uploadSignature($signature_image)
  {
	    $folderPath = "./assets/pi_images/";
 
		$image_parts = explode(";base64,", $signature_image);
		 
		$image_type_aux = explode("image/", $image_parts[0]);
		 
		$image_type = $image_type_aux[1];
		 
		$image_base64 = base64_decode($image_parts[1]);
		$uniqid = uniqid(); 
		$file = $folderPath . $uniqid . '.'.$image_type;		
		file_put_contents($file, $image_base64); 
        return $signature_img = $uniqid . '.'.$image_type; 	
  }
    /**
    * Update an existing branch using POSTed form data and return a JSON status.
    * @example
    * $_POST = array(
    *   'branch_id' => 5,
    *   'branch_name' => 'Main Branch',
    *   'branch_email' => 'branch@example.com',
    *   'comp_name' => 'Example Company Pvt Ltd',
    *   'branch_phone' => '+911234567890',
    *   'branch_gstin' => '27ABCDE1234F1Z5',
    *   'branch_cin' => 'U12345MH2000PTC000000',
    *   'branch_pan' => 'ABCDE1234F',
    *   'country_br' => 'India',
    *   'state_br' => 'Maharashtra',
    *   'city_br' => 'Mumbai',
    *   'zipcode_br' => '400001',
    *   'address_br' => '123 Example Street',
    *   'show_email' => '1'
    * );
    * $this->update_branch();
    * // Outputs: {"status":true}
    * @param {int} $branch_id - Branch ID to update (taken from POST key 'branch_id').
    * @param {string} $branch_name - Branch name (POST key 'branch_name').
    * @param {string} $branch_email - Branch contact email (POST key 'branch_email').
    * @param {string} $company_name - Company name associated with the branch (POST key 'comp_name').
    * @param {string} $contact_number - Branch contact number (POST key 'branch_phone').
    * @param {string} $gstin - GSTIN of the branch (POST key 'branch_gstin').
    * @param {string} $cin - CIN of the company/branch (POST key 'branch_cin').
    * @param {string} $pan - PAN of the branch/company (POST key 'branch_pan').
    * @param {string} $country - Country of the branch (POST key 'country_br').
    * @param {string} $state - State of the branch (POST key 'state_br').
    * @param {string} $city - City of the branch (POST key 'city_br').
    * @param {string} $zipcode - ZIP/postal code of the branch (POST key 'zipcode_br').
    * @param {string} $address - Full address of the branch (POST key 'address_br').
    * @param {string|int} $show_email - Flag to indicate whether to show email (POST key 'show_email', e.g. '1' or '0').
    * @returns {string} JSON encoded string with operation status, e.g. '{"status":true}'.
    */
    public function update_branch()
    {
     $data = array(      
      'branch_name' => $this->input->post('branch_name'),
      'branch_email' => $this->input->post('branch_email'),
      'company_name' => $this->input->post('comp_name'),
	  'contact_number' => $this->input->post('branch_phone'),
      'gstin' => $this->input->post('branch_gstin'),
      'cin' => $this->input->post('branch_cin'),
      'pan' => $this->input->post('branch_pan'),
      'country' => $this->input->post('country_br'),
      'state' => $this->input->post('state_br'),
      'city' => $this->input->post('city_br'),
      'zipcode' => $this->input->post('zipcode_br'),
      'address' => $this->input->post('address_br'),
	  'show_email' => $this->input->post('show_email'),
    );
    $this->Branch_model->update(array('id' => $this->input->post('branch_id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  //check invoice no
  /**
  * Check whether an invoice number already exists and echo HTML/JS to enable or disable the invoice save button.
  * @example
  * $_POST['invoice_no'] = 'INV-001';
  * $this->check_invoiceduplicate();
  * // If exists: echoes '<span style="color:red;font-size:10px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Invoice no already exit!</span>'
  * // and echoes "<script>$('#invoiceSave').prop('disabled',true);</script>"
  * // If not exists: echoes "<script>$('#invoiceSave').prop('disabled',false);</script>"
  * @param string $invoice_no - Invoice number supplied via $_POST['invoice_no'] (e.g. 'INV-001').
  * @returns void No return value; outputs HTML/JS directly to the response.
  */
  public function check_invoiceduplicate()
  {
      if($this->invoice_model->check_invice_no($_POST['invoice_no']))
      {
        echo '<span style="color:red;font-size:10px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Invoice no already exit!</span>';
        echo "<script>$('#invoiceSave').prop('disabled',true);</script>";
      }
      else
      {
        echo "<script>$('#invoiceSave').prop('disabled',false);</script>";
      } 
  }
  
  public function get_vendor_details()
  {
	  
    $cust_id = $this->input->post('vendor_id');
    $data = $this->organization_model->get_by_id($cust_id);
    echo json_encode($data);
  }
  

  /*****new generate pdf template*****/
  public function generate_pdf()
  {
	    $product_id = base64_decode($_GET['inv_id']);
		$cnp = base64_decode($_GET['cnp']);
		$ceml = base64_decode($_GET['ceml']);
		$row = $this->invoice_model->get_pi_byId($product_id,$cnp,$ceml);
	if($row['id']){
		$rowOwner = $this->invoice_model->get_Owner($row['sess_eml']);
		if(empty($rowOwner['standard_name'])){
			$rowOwner = $this->invoice_model->get_Admin($row['sess_eml']);
		}
		$compnyDtail= $this->invoice_model->get_Comp($row['session_comp_email']);
		$branch = $this->invoice_model->getBranchData($row['branch_id']); 
		$clientDtl = $this->organization_model->get_by_id($row['cust_id']);
		$bank_details_terms = $this->invoice_model->get_bank_details();
      
      $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Invoice</title>
                <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
              <style>
                 @page{
                      margin-top: 10px; /* create space for header */
                    }
                 footer .pagenum:before {
                     content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">';
              	if($row['declaration_status'] == 1) {  
                $output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
              	}else{
              	    
              	$output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
              	}
                
                 $output .= ' <table style="font-size:11px; width:100%; text-align:center;">';
					  
					  
					if($row['declaration_status'] == 1) {   
					$output .= '<tr>
						<td style="font-size:10px;">
						<text><b>Declaration:-</b></text>
						'.$row['invoice_declaration'].'
						</td>
					  </tr>';
					}
					if($row['jurisdiction']!="") {  
					$output .= ' <tr>
						<td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
					  </tr>';
					}
					if($row['late_charge']!="") {  
					$output .= '  <tr>
						<td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
					  </tr>';
					}
					$output .= '  <tr>
						<td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
					  </tr>
					  <tr>
						<td><b>"This is system generated invoice, Sign and stamp not required"</b></td>
					  </tr>
					  <tr>
						<td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
                     | Ph. - +91-'.$branch['contact_number'].'</br>
                      | GSTIN: '.$branch['gstin'].'</br>
                       | CIN: '.$branch['cin'].'</span></b><br>
                    <b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
					  </tr>
				  </table>
                 
                
                </footer>
              
              <main style="margin-bottom:10px;">
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td style="width:35%; vertical-align: top;">
						<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						<tr>
							<td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax Invoice</b></text></td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;" >Invoice No.</td><td>'.$row['invoice_no'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Invoice Date.</td><td>'.date("d F Y", strtotime($row['invoice_date'])).'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Terms</td><td>';
						if($row['inv_terms'] == 'end_of_month') { 
						    $output .= 'Due end of month';
						}else if($row['inv_terms'] == 'end_next_month'){
							$output .= 'Due end of next month';
						}else if($row['inv_terms'] == 'due_receipt'){
							$output .= 'Due on reciept';
						}else if($row['inv_terms'] == 'custom'){
							$output .= 'Custom';
                        }else{
							$output .= $row["inv_terms"];
						}		
						$output .= '</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
						</tr>
						</table>
                       </td>
					   <td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
					   
						<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						<tr><td colspan="2"></td></tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$row['cust_order_no'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($row['buyer_date'])).'</td>
						</tr>
						</table>
					   
					   </td>
                       <td style="text-align:right; width:30%;">';
        				$image = $compnyDtail['company_logo'];
        					if(!empty($image))
        					{
        					$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
        					}
        					else
        					{
        					$output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
        					}
        					$output .= '
        				</td>
                    </tr>
                     </tbody>
                    </table>
                     <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                    
                        <tr>
						
						<td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
                            <h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Invoice From</h5>
                            <p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
                           ';
                          if($branch["address"]!=""){
                          $output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
                          }
                          if($branch["city"]!=""){
                          $output .=  ', '.$branch["city"];
                          }
                          if($branch["zipcode"]!=""){
                          $output .=  ' - '.$branch["zipcode"];
                          }
                          if($branch["state"]!=""){
                          $output .=  ', '.$branch["state"];
                          }
                          
                          if($branch["country"]!=""){
                          $output .=  ', '.$branch["country"];
                          }
                          $output .=  '</p>';
						  if($branch["gstin"]!=""){
                          $output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
                          }
						  if($branch["branch_email"]!="" && $branch["show_email"]== 1){
						   $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
						  }
						  if($branch["contact_number"]!=""){
						   $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
						  }
                          $output .=  ' </td>
						   
						 <td style="width: 1%;background:#fff;"></td>
						 
                         <td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
						    <h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;">Invoice To</h5>
                          <p style="margin: 0;font-size: 12px;">'.
        				  $clientDtl->org_name.'</p>';
        				  if(!empty($clientDtl->primary_contact)){
                          $output .= '<p style="margin: 0;font-size: 11px;">
                            <b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
                           }
                           $output .= '
                          <p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
                          
                          if(!empty($clientDtl->shipping_address)){
                           $output .= $clientDtl->shipping_address;
                          }
                          if(!empty($clientDtl->shipping_city)){
                           $output .= ', '.$clientDtl->shipping_city;
                          }
                          if(!empty($clientDtl->shipping_zipcode)){
                           $output .= ' - '.$clientDtl->shipping_zipcode;
                          }
                          if(!empty($clientDtl->shipping_state)){
                           $output .= ', '.$clientDtl->shipping_state;
                          }
                          if(!empty($clientDtl->shipping_country)){
                           $output .= ', '.$clientDtl->shipping_country;
                          }
                           $output .= '</p>';
						   
                          if(!empty($clientDtl->gstin!="")){
                          $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
                          }
                            if(isset($clientDtl->email)){
                          $output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
                          <b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
                            }
                       $output .= '</td>
						  
                    </tr>
                </table>
                <!--<table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
                      </td>
                    </tr>
                 </tbody>
                </table>-->
        
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">';
                   
                        $igsttotal=0;
        				$sgsttotal=0;
        				$cgsttotal=0;
        				
        				$igst = explode("<br>",$row['igst']);
        				$sgst = explode("<br>",$row['sgst']);
        				$cgst = explode("<br>",$row['cgst']);
        				$proDiscount = explode("<br>",$row['pro_discount']);
						$totalDiscount=array_sum($proDiscount);
                   
                    $output .= '<tr>
					  <th width="3%" style="font-size: 11px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
                       S.No.</div></th>
                       <th width="18%" style="font-size: 11px; background: #6539c0;">
                       Product/Services</th>
                       <th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
                      
                       <th style="font-size: 11px; background: #6539c0;">Qty</th>
					   <th style="font-size: 11px; background: #6539c0;">Tax</th>
                       <th style="font-size: 11px; background: #6539c0;">Rate</th>';
					   if($totalDiscount>0){
                       $output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
					   }
        				$output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
                       </tr>
                   </thead>
                   <tbody >';
                   
                        $product_name = explode("<br>",$row['product_name']);
        				$quantity = explode("<br>",$row['quantity']);
        				$unit_price = explode("<br>",$row['unit_price']);
        				$total = explode("<br>",$row['total']);
        				$total_withgst = explode("<br>",$row['sub_total_with_gst']);
        				$hsnsac = explode("<br>",$row['hsn_sac']);
        				$after_discount = ($row['initial_total']-$row['total_discount']);
        				if(!empty($row['gst'])){
        				  $gst = explode("<br>",$row['gst']);
        				}
        				$proDesc = explode("<br>",$row['pro_description']);
        				
        				
				        $arrlength = count($product_name);
        				$rw=0;
						$sr=1;
        				for($x = 0; $x < $arrlength; $x++){
        				    $rw++;
        					$num = $x + 1;
        					
        					if(isset($igst[$x]) && $igst[$x]!=""){
        						$igsttotal=$igsttotal+$igst[$x];
        					}
        					if(isset($sgst[$x]) && $sgst[$x]!=""){
        						$sgsttotal=$sgsttotal+$sgst[$x];
        					}
        					if(isset($igst[$x]) && $cgst[$x]!=""){
        						$cgsttotal=$cgsttotal+$cgst[$x];
        					}
				
        					
        					$output .='<tr>
        						<td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
        						<td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
        						
        						<td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
        						
        						<td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
								<td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
        						<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
        						if($totalDiscount>0){
        						$output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
								}
        						$output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
        					</tr>';
							if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
							$output.='<tr>
							        <td style="font-size: 11px; padding:5px 10px;"></td>
									<td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
							}
						$sr++;
        			    }
        			    
                        $output .='
                  </tbody>
                </table>
        
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
                       if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
               
                        $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
                               <tr>
                                <td colspan="3">
                                    <h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
                                </td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
                                   <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
                                   <td>'.$bank_details_terms->account_no.'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
                                   <td>'.$bank_details_terms->ifsc_code.'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
                                   <td>'.ucfirst($bank_details_terms->account_type).'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
                                   <td>'.ucfirst($bank_details_terms->bank_name).'</td>
                               </tr><tr style="line-height: 0.8;">';
                              
                                if($bank_details_terms->upi_id!=""){
                                $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
                                   <td>'.$bank_details_terms->upi_id.'</td>';
                                }
                                if(isset($_GET['dn']) && $_GET['dn']==1){
                                  $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
                                }
                                
                                 $output .= '</tr>
                             </table>';
                   
                   }  
                   
                     $output .='</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
                          </tr>';
						  if($row["discount"]>0){
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
                          </tr>';
						  
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
                          </tr>';
                          }
                          if($igsttotal!=0){	
							$output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
    					  }else{
    						
    							if($sgsttotal!=0){	
    								$output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
    							}
    							if($cgsttotal!=0){	
    								$output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
    							}
    						}
    						if($row['extra_charge_label']!=""){
    						 $extraCharge_name=explode("<br>",$row['extra_charge_label']);
    						 $extraCharge_value=explode("<br>",$row['extra_charge_value']);
    						for($y=0; $y<count($extraCharge_name); $y++){	
    							$output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
    						}
    						}
        							
                          $output .='
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';
        
                $output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
                    if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
                        $output .='0px;">';
                        
                    }else{ 
                        $output .='-20px;">'; 
                        
                    }
                    $output .='<tbody>
                    <tr>
                  <td align="left" style="width:60%; padding:1px;">
                    <h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
                    <ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
                     $custTerm=explode("<br>",$row["terms_condition"]); $no=1;
					 for($i=0; $i<count($custTerm); $i++){ 
					   $output .='<li>'.$custTerm[$i].'</li>'; 
					 }
                      //'.nl2br($row->terms_condition).'
                    $output .='</ol>
                  </td>';
                  
                  $output .='<td style="text-align:center;">';
        				$image = $row['signature_img'];
        				if(!empty($image)){
        			    $output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
        				}else{
							//$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
						}
                  $output .= '</td>';
        					$output .= '</tr>
							
					
                  </tbody>
                </table>';
				
				 
        
              $output .='</main>
        
              </body>
              </html>';
      //return $output;
      
		}
		//echo $output; exit;
		//print_r($output); die;
	  $this->load->library('pdf');
      $this->dompdf->loadHtml($output);
      ini_set('memory_limit', '128M');
      $this->dompdf->render();
      $canvas = $this->dompdf->getCanvas();
      $pdf = $canvas->get_cpdf();

      foreach ($pdf->objects as &$o) {
        if ($o['t'] === 'contents') {
            $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
        }
      }
      
	  if(isset($_GET['dn']) && $_GET['dn']==1){
		$this->dompdf->stream("Invoice_".$product_id.".pdf", array("Attachment"=>1));  
	  }else{
		$this->dompdf->stream("Invoice_".$product_id.".pdf", array("Attachment"=>0));  
	  }
	  
	  
  }
 
 public function getbankdetails()
  {
    $data = $this->invoice_model->get_bank_details();
	if($data){
	  echo json_encode($data);
	}else{
      echo json_encode(array("st" => "add"));
    }
    
  }
  /**
  * Change the declaration status of a proforma invoice: reads POST keys 'inv_id' and 'declaration_status', updates the invoice via the model and echoes a JSON result.
  * @example
  * // HTTP POST example (curl)
  * // curl -X POST -d "inv_id=123&declaration_status=approved" https://example.com/invoices/chnage_declaration_status
  * // Sample successful response:
  * // {"status":true,"st":200}
  * // Sample failure response:
  * // {"status":false}
  * @param int $inv_id - Invoice ID supplied in POST (key: 'inv_id'), e.g. 123.
  * @param string $declaration_status - Declaration status supplied in POST (key: 'declaration_status'), e.g. 'approved'.
  * @returns void Echoes a JSON response indicating success ({ "status": true, "st": 200 }) or failure ({ "status": false }); does not return a PHP value.
  */
  public function chnage_declaration_status()
  {
	  $piId=$this->input->post('inv_id');
	  $status=$this->input->post('declaration_status');
	  $data=array('declaration_status' => $status );
      $id = $this->invoice_model->update_pi($data,$piId);
      if($id){	  
		echo json_encode(array("status" => TRUE,'st'=>200));
	  }else{
        echo json_encode(array("status" => FALSE));
      }
  }
  
  /**
  * Change the enable_payment status for a bank detail record using POSTed values.
  * @example
  * // Example using HTTP POST to the controller endpoint:
  * // POST: bankdetails_id=123 & bank_status=1
  * $result = file_get_contents('http://example.com/invoices/changebankstatus', false, stream_context_create([
  *   'http' => [
  *     'method' => 'POST',
  *     'header' => 'Content-type: application/x-www-form-urlencoded',
  *     'content' => http_build_query(['bankdetails_id' => 123, 'bank_status' => 1])
  *   ]
  * ]));
  * echo $result; // {"st":200}
  * @param {{int}} {{bankdetails_id}} - ID of the bank details record provided via POST.
  * @param {{int|bool}} {{bank_status}} - New enable_payment value from POST (e.g. 1 to enable, 0 to disable).
  * @returns {{void}} Echoes a JSON response with status: {"st":200} on success or {"st":201} on failure.
  */
  public function changebankstatus()
  {
	  $bankdetails_id = $this->input->post('bankdetails_id');
	  $bank_status = $this->input->post('bank_status');
	    $data = array(
        'enable_payment' 			=> $bank_status
		);
	  $data = $this->invoice_model->update_bank_detail($data,$bankdetails_id);
	if($data){
	  echo json_encode(array("st" => 200));
	}else{
      echo json_encode(array("st" => 201));
    }
    
  }
  
  
  /**
   * Create bank details from POSTed form data, save to the database, and echo a JSON result indicating success or failure.
   * @example
   * // Example using cURL:
   * // curl -X POST http://example.com/invoices/create_bankDetails \
   * //  -d "bank_name=ABC Bank" \
   * //  -d "account_no=123456789012" \
   * //  -d "acc_holder_name=John Doe" \
   * //  -d "ifsc_code=ABCD0123456" \
   * //  -d "account_type=Savings" \
   * //  -d "mobile_no=9999999999" \
   * //  -d "upi_id=john@upi" \
   * //  -d "terms_conditionbnk[]=Term1" -d "terms_conditionbnk[]=Term2" \
   * //  -d "bank_country=India"
   * // Possible printed responses:
   * // Success: {"status":true,"st":200}
   * // Failure: {"status":false}
   * // Validation error (if check_validation_bank() returns non-200): prints the validation message and exits.
   * @param void $none - No direct function arguments; reads required values from POST and session.
   * @returns void Outputs JSON (or a validation message) and terminates execution.
   */
  public function create_bankDetails()
  {
	 
  	$validation = $this->check_validation_bank();
    if($validation!=200)
    {
      echo $validation;die;
	  
    }
    else
    {
	
	  if($this->input->post('terms_conditionbnk')){
			$terms_bnk=implode("<br>",$this->input->post('terms_conditionbnk'));
	  }else{
		  $terms_bnk='';
	  }
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'bank_name' 		=> $this->input->post('bank_name'),       
        'account_no' 	    => $this->input->post('account_no'),
        'acc_holder_name' 	=> $this->input->post('acc_holder_name'),
        'ifsc_code' 		=> $this->input->post('ifsc_code'),
        'account_type' 		=> $this->input->post('account_type'),
        'register_mobile' 	=> $this->input->post('mobile_no'),
        'upi_id' 			=> $this->input->post('upi_id'),
        'terms_condition' 	=> $terms_bnk,
        'bank_country' 		=> $this->input->post('bank_country'),
        
      );
      $id = $this->invoice_model->create_bank_detail($data);
      if($id){	  
		echo json_encode(array("status" => TRUE,'st'=>200));
	  }
      else
      {
        echo json_encode(array("status" => FALSE));
      }
	}
  }
  /**
  * Handle validation and update of bank details from POST data; echoes a JSON response indicating success or failure.
  * @example
  * // Example POST data (sent to Invoices/update_bankDetails via HTTP POST)
  * $_POST = [
  *   'bank_name' => 'State Bank',
  *   'account_no' => '1234567890',
  *   'acc_holder_name' => 'John Doe',
  *   'ifsc_code' => 'SBIN0001234',
  *   'account_type' => 'Savings',
  *   'mobile_no' => '9876543210',
  *   'upi_id' => 'john@upi',
  *   'terms_conditionbnk' => ['Term A','Term B'],
  *   'bank_country' => 'India',
  *   'account_details_id' => '5'
  * ];
  * $this->invoices->update_bankDetails();
  * // Sample echoed output on success:
  * echo '{"status":true,"st":200}';
  * @param {string} bank_name - Bank name submitted via POST.
  * @param {string} account_no - Account number submitted via POST.
  * @param {string} acc_holder_name - Account holder's name submitted via POST.
  * @param {string} ifsc_code - IFSC code submitted via POST.
  * @param {string} account_type - Account type (e.g., 'Savings', 'Current') submitted via POST.
  * @param {string} mobile_no - Registered mobile number submitted via POST.
  * @param {string} upi_id - UPI ID submitted via POST (optional).
  * @param {array|string} terms_conditionbnk - Terms/conditions as array (checkboxes) or string; will be imploded with "<br>".
  * @param {string} bank_country - Country of the bank submitted via POST.
  * @param {int|string} account_details_id - ID of the bank account record to update.
  * @returns {string} JSON - Echoes a JSON encoded string indicating status: success {"status":true,"st":200} or failure {"status":false}.
  */
  public function update_bankDetails()
  {
	 
  	$validation = $this->check_validation_bank();
    if($validation!=200)
    {
      echo $validation;die;
	  
    }
    else
    {
        if($this->input->post('terms_conditionbnk')){
			$terms_bnk=implode("<br>",$this->input->post('terms_conditionbnk'));
	    }else{
		   $terms_bnk='';
	   }
	
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'bank_name' 		=> $this->input->post('bank_name'),       
        'account_no' 	    => $this->input->post('account_no'),
        'acc_holder_name' 	=> $this->input->post('acc_holder_name'),
        'ifsc_code' 		=> $this->input->post('ifsc_code'),
        'account_type' 		=> $this->input->post('account_type'),
        'register_mobile' 	=> $this->input->post('mobile_no'),
        'upi_id' 			=> $this->input->post('upi_id'),
        'terms_condition' 	=> $terms_bnk,
        'bank_country' 		=> $this->input->post('bank_country'),
        
      );
      $acc_id=$this->input->post('account_details_id');
      //$this->invoice_model->update_bank_detail($data,$acc_id);
      if($this->invoice_model->update_bank_detail($data,$acc_id)){	  
		echo json_encode(array("status" => TRUE,'st'=>200));
	  }
      else
      {
        echo json_encode(array("status" => FALSE));
      }
	}
  }
  /**
  * Validate bank-related POST inputs and return either success or JSON-encoded validation errors.
  * @example
  * // Typical usage inside the Invoices controller:
  * $result = $this->check_validation_bank();
  * // On validation failure (missing required fields) returns JSON:
  * // echo $result; // {"st":202,"bank_country":"Bank Country is required","bank_name":"Bank Name is required","acc_holder_name":"Account Holder Name is required","account_no":"Acoount Number is required","ifsc_code":"IFSC Code is required","mobile_no":"Phone no is required"}
  * // If UPI checkbox was set to 'checked_upi' and upi_id is missing:
  * // echo $result; // {"st":202,...,"upi_id":"UPI Id is required"}
  * // On success returns integer 200:
  * // echo $result; // 200
  * @param void $none - This function does not accept direct arguments; it validates POST data via $this->input->post().
  * @returns int|string 200 on successful validation, or a JSON-encoded string (st = 202) containing field-specific error messages on failure.
  */
  public function check_validation_bank()
  {
	  //print_r($this->input->post());
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
	//$piId=$this->input->post('invc_id');
	//if(empty($piId)){
    //$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim|is_unique[performa_invoice.invoice_no]');
	//}
	$this->form_validation->set_rules('bank_country', 'Bank Country', 'required|trim');
    $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
    $this->form_validation->set_rules('acc_holder_name', 'Account Holder Name', 'required|trim');
    $this->form_validation->set_rules('account_no', 'Acoount Number', 'required|trim');
    $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim');
	$this->form_validation->set_rules('mobile_no', 'Phone no', 'required|trim');
	$upichecked=$this->input->post('check_upi');
	if($upichecked == 'checked_upi'){
	$this->form_validation->set_rules('upi_id', 'UPI Id', 'required|trim');
	}
	
    $this->form_validation->set_message('required', '%s is required');
   
    if ($this->form_validation->run() == FALSE)
    {
	    if($upichecked == 'checked_upi'){
            return json_encode(array('st'=>202,'bank_country'=> form_error('bank_country'), 'bank_name'=> form_error('bank_name'), 'acc_holder_name'=> form_error('acc_holder_name'),'account_no'=> form_error('account_no'), 'ifsc_code'=> form_error('ifsc_code'),'mobile_no'=> form_error('mobile_no') ,'upi_id'=> form_error('upi_id')));
		}else{
			return json_encode(array('st'=>202,'bank_country'=> form_error('bank_country'), 'bank_name'=> form_error('bank_name'), 'acc_holder_name'=> form_error('acc_holder_name'),'account_no'=> form_error('account_no'), 'ifsc_code'=> form_error('ifsc_code'),'mobile_no'=> form_error('mobile_no')));
		}
    }
    else
    {
      return 200;
    }
  }
  
  /**
  * Generate a PDF invoice for a given product/invoice record, save it to disk and return the saved file path.
  * @example
  * $result = $this->generate_pdf_attachment_old(123, 'CNP001', 'owner@example.com');
  * echo $result // outputs 'assets/img/invoice_123.pdf';
  * @param {int} $product_id - The numeric ID of the product/invoice record to generate the PDF for.
  * @param {string} $cnp - Company/record identifier used to locate the proforma/invoice (e.g. 'CNP001').
  * @param {string} $ceml - Company or session email associated with the record (e.g. 'owner@example.com').
  * @returns {string} Return the relative path to the generated PDF file (e.g. 'assets/img/invoice_123.pdf').
  */
  public function generate_pdf_attachment_old($product_id,$cnp,$ceml)
  {
	  	$row = $this->invoice_model->get_pi_byId($product_id,$cnp,$ceml);
	if($row['id']){
		$rowOwner = $this->invoice_model->get_Owner($row['sess_eml']);
		if(empty($rowOwner['standard_name'])){
			$rowOwner = $this->invoice_model->get_Admin($row['sess_eml']);
		}
		$compnyDtail= $this->invoice_model->get_Comp($row['session_comp_email']);
		
		$otherdata = $this->invoice_model->get_data_detail($row['page_name'],$row['page_id']);
		$branch = $this->invoice_model->getBranchData($row['billedby_branchid']); 
		$clientDtl = $this->organization_model->get_by_id($row['billedto_orgname'],$row['page_name']);
		//$this->load->view('setting/proforma_view_detail',$data);
		
		$output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Invoice</title>
		 <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>INVOICE</b></h5>
				<hr style="width: 250px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>

			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
				  <span><b>'.$branch['company_name'].'</b></span><br>
				  <span>'.$branch["address"].'</span><br>
				  <span>'.$branch["city"].',&nbsp;'.$branch["state"].'&nbsp;'.$branch["zipcode"].'</span><br>
				  <span><a style="text-decoration:none" href="'.$compnyDtail['company_website'].'">'.$compnyDtail['company_website'].'</a></span><br>
				  <span>'.$branch["contact_number"].'</span><br>
				  <span><b>GSTIN:</b>&nbsp;'.$branch["gstin"].'</span><br>
				  <span><b>CIN:</b>&nbsp;'.$branch["cin"].'</span><br>
				</td>
				<td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;" class="float-right"  >
				
        			<table class="float-right" >
                     <tr> 
					 <td colspan="2" style="text-align:right">';
					$image = $compnyDtail['company_logo'];
					if(!empty($image))
					{
					$output .=  '<img style="width: 100px;" src="./uploads/company_logo/'.$image.'">';
					}
					else
					{
					$output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
					}
					$output .= '
				</td>
				
                   </tr>
                    <tr><td colspan="2"  >
                    <span style="font-weight: bold;">INVOICE NO : </span>&nbsp;<span>'.$row['invoice_no'].'</span><br>
        				<b>DATE : </b><span >'.date('d-M-Y').'</span><br>
						<b>DUE DATE : </b><span>'.date('d-M-Y',strtotime($row['due_date'])).'</span>
                        </td>
                        </tr>
                    </table>
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:20px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">'.$row['billedto_orgname'].'</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>'.$clientDtl->primary_contact.'</span><br>
				  <span style="white-space: pre-line">'.$clientDtl->billing_address.'</span>,
				  <span>'.$clientDtl->billing_state.'</span><br>
				  <span>'.$clientDtl->billing_city.'</span>&nbsp;,<span>'.$clientDtl->billing_zipcode.'</span>&nbsp;,<span>'.$clientDtl->billing_country.'</span><br>
				
				</td>

				<td colspan="6" style="font-size: 12px;" >
				<table class="float-right" >
                     <tr> <td>
					<b>Place Of supply</b> : 
					<span>'.$clientDtl->billing_state.'</span><br>
					<b>Sales Person</b> : 
					<span>'.$rowOwner['standard_name'].'</span><br>
					<b>Sales  Mobile</b> : 
					<span>'.$rowOwner['standard_mobile'].'</span><br>
					</td></tr></table>
				</td>
			</tr>
			
        </table>  

        <table class="table-responsive-sm table-striped text-center table-bordered" style="width:100% !important; ">
            <thead style="background: #50b1bd; color: #fff; font-size: 12px;">
                <tr>
                    <th>S.No.</th>
                    <th>Product/Services</th>
                    <th>HSN/SAC</th>
                    <th>Qty</th>
                    <th>Rate</th>';
					$output .='<th>Tax</th>';
                    $output .='<th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 12px;">';
				$product_name = explode("<br>",$row['product_name']);
				$quantity = explode("<br>",$row['quantity']);
				$unit_price = explode("<br>",$row['unit_price']);
				$total = explode("<br>",$row['total']);
				$hsnsac = explode("<br>",$row['hsn_sac']);
				if(!empty($row['gst'])){
				  $gst = explode("<br>",$row['gst']);
				}
				
				$igsttotal=0;
				$sgsttotal=0;
				$cgsttotal=0;
				$igst = explode("<br>",$row['igst']);
				$sgst = explode("<br>",$row['sgst']);
				$cgst = explode("<br>",$row['cgst']);
				
				
				$arrlength = count($product_name);
				$arrlength = count($product_name);
				for($x = 0; $x < $arrlength; $x++){
					
					if(isset($igst[$x]) && $igst[$x]!=""){
						$igsttotal=$igsttotal+$igst[$x];
					}
					if(isset($sgst[$x]) && $sgst[$x]!=""){
						$sgsttotal=$sgsttotal+$sgst[$x];
					}
					if(isset($igst[$x]) && $igst[$x]!=""){
						$cgsttotal=$cgsttotal+$igst[$x];
					}
					
					$num = $x + 1;
					$output .='<tr>
						<td style="padding:5px; 0px;">'.$num.'</td>
						<td style="padding:5px; 0px;">'.$product_name[$x].'</td>
						<td style="padding:5px; 0px;">'.$hsnsac[$x].'</td>
						<td style="padding:5px; 0px;">'.$quantity[$x].'</td>
						<td style="padding:5px; 0px;">'.IND_money_format($unit_price[$x]).'</td>';
						if(!empty($gst)){
						  $output .='<td style="padding:5px; 0px;">GST@'.$gst[$x].'%</td>';
						}
						  $output .='<td style="padding:5px; 0px;">'.IND_money_format($total[$x]).'/-</td>
					</tr>';		
			    }
                $output .='
            </tbody>
        </table>

        <table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
				<br>
					<span class="h6">Terms And Conditions :-</span><br>
					<span style="white-space: pre-line;font-size: 10px;"></span><br>
					<span>'.nl2br($row['terms_condition']).'</span><br>';
					
					$output .='
				</td>
				<td colspan="2">
				</td>
				<td colspan="4" style="padding:3px;">
					<table class="float-right" style="border: 1px solid #ffffff; font-size:12px; ">
						<tr>
							<td style="padding-bottom:8px;">
							Initial Total:</td>
							<td style="padding:0px;"><span class="float-right" id="">'.IND_money_format($row['initial_total']).'/-</span></td>
						</tr>
						<tr>
							<td style="padding-bottom:8px;">Discount:</td>
							<td style="padding:0px;"><span class="float-right" id="">'.$row['total_discount'].'/-</span></td>
						</tr>';
							
						if($igsttotal!=0){	
							$output .='<tr>
							<td style="padding-bottom:8px;">IGST :</td>
							<td style="padding-bottom:1px;"><span class="float-right">'.IND_money_format($igsttotal).'/-</span></td>
							</tr>';
						}else{
						
							if($sgsttotal!=0){	
								$output .='<tr>
								<td style="padding-bottom:8px;"><b>SGST :</b></td>
								<td style="padding:0px;"><span class="float-right">'.IND_money_format($sgsttotal).'/-</span></td>
								</tr>';
							}
							if($cgsttotal!=0){	
								$output .='<tr>
								<td style="padding-bottom:8px;"><b>CGST :</b></td>
								<td style="padding:0px;"><span class="float-right">'.IND_money_format($cgsttotal).'/-</span></td>
								</tr>';
							}
						}
						if($row['extra_charge_label']!=""){
						 $extraCharge_name=explode("<br>",$row['extra_charge_label']);
						 $extraCharge_value=explode("<br>",$row['extra_charge_value']);
						for($y=0; $y<count($extraCharge_name); $y++){	
							$output .='<tr>
								<td style="padding-bottom:8px;"><b>'.$extraCharge_name[$y].' :</b></td>
								<td style="padding:0px;"><span class="float-right">'.IND_money_format($extraCharge_value[$y]).'/-</span></td>
								</tr>';
						}
						}
							
							
							$output .='
						<tr style="">
							<td style="padding-left:5px; padding-bottom:5px;" class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding-left:5px;padding-right:5px; padding-bottom:5px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><b>INR '.IND_money_format($row['sub_total']).'/-</b></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table>
        <br>
       
        <table width="100%" style="position:fixed; bottom: 60; font-size:11px;">

          <tr style="height:40px;">
            <td style="width:65%"> <b>Accepted By</b><br>
			<b>Accepted Date</b> : '.date('d F Y').'
			</td>
			
			<td colspan="3">
			</td>
			<td style="width:35%">
    			<table width="100%">
    			<tr>
					<td><b>Invoice Created By</b> : </td><td>'.ucfirst($rowOwner['standard_name']).'</td>
    			</tr>
    			<tr><td><b>Invoice Created Date : </td><td>'.date("d F Y", strtotime($row['currentdate'])).'</td>
				</tr>
				</table>
			</td>
			
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated Quotation Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - '.$this->session->userdata('company_email').'</br>
             | Ph. - +91-'.$branch['contact_number'].'</br>
              | GSTIN: '.$branch['gstin'].'</br>
               | CIN: '.$branch['cin'].'</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
		}
		
	  $this->load->library('pdf');
      $this->dompdf->loadHtml($output);
      ini_set('memory_limit', '128M');
      $this->dompdf->render();
	  $attachmentpdf =  $this->dompdf->output();
	  $path = "assets/img/invoice_".$product_id.".pdf";	 
      file_put_contents($path, $attachmentpdf);
	  return $path;
	 
  }
  
  /************New attachment pdf********/
  public function generate_pdf_attachment($product_id,$cnp,$ceml)
  {
	  	$row = $this->invoice_model->get_pi_byId($product_id,$cnp,$ceml);
	if($row['id']){
		$rowOwner = $this->invoice_model->get_Owner($row['sess_eml']);
		if(empty($rowOwner['standard_name'])){
			$rowOwner = $this->invoice_model->get_Admin($row['sess_eml']);
		}
		$compnyDtail= $this->invoice_model->get_Comp($row['session_comp_email']);
		$branch = $this->invoice_model->getBranchData($row['branch_id']); 
		$clientDtl = $this->organization_model->get_by_id($row['cust_id']);
		$bank_details_terms = $this->invoice_model->get_bank_details();
	
       $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Invoice</title>
                <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
              <style>
                 @page{
                      margin-top: 10px; /* create space for header */
                    }
                 footer .pagenum:before {
                     content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">';
              	if($row['declaration_status'] == 1) {  
                $output .= '<footer style="position: fixed;  bottom: 110;border-top:0.5px solid #333; " >';
              	}else{
              	    
              	$output .= '<footer style="position: fixed;  bottom: 80;border-top:0.5px solid #333; " >';
              	}
                $output .= '<table style="font-size:11px; width:100%; text-align:center;">';
					  
					  
					if($row['declaration_status'] == 1) {   
					$output .= '<tr>
						<td style="font-size:10px;">
						<text><b>Declaration:-</b></text>
						'.$row['invoice_declaration'].'
						</td>
					  </tr>';
					}
					if($row['jurisdiction']!="") {  
					$output .= ' <tr>
						<td style="font-size:10px;"><b>"SUBJECT TO '.strtoupper($row['jurisdiction']).' JURISDICTION"</b></td>
					  </tr>';
					}
					if($row['late_charge']!="") {  
					$output .= '  <tr>
						<td style="font-size:10px;">INTEREST@ '.$row['late_charge'].'% P.A WILL BE CHARGED IF THE PAYMENT IS NOT MADE WITHIN THE STIPULATED TIME.</td>
					  </tr>';
					}
					$output .= '
					  <tr>
						<td><div class="pagenum-container"style="text-align:right;font-size:10px; border-top:1px dashed #333; ">Page <span class="pagenum"></span></div></td>
					  </tr>
					  <tr>
						<td><b>"This is system generated invoice, Sign and stamp not required"</b></td>
					  </tr>
					  <tr>
						<td><b><span style="font-size: 10px;">E-mail - '.$branch['branch_email'].'</br>
                     | Ph. - +91-'.$branch['contact_number'].'</br>
                      | GSTIN: '.$branch['gstin'].'</br>
                       | CIN: '.$branch['cin'].'</span></b><br>
                    <b><span style="font-size:11px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b> </td>
					  </tr>
				  </table>
                 
                
                </footer>
              
              <main style="margin-bottom:10px;">
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td style="width:35%; vertical-align: top;">
						<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						<tr>
							<td colspan="2"><text style="color: #6539c0;font-size:13px;"><b>Tax Invoice</b></text></td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;" >Invoice No.</td><td>'.$row['invoice_no'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Invoice Date.</td><td>'.date("d F Y", strtotime($row['invoice_date'])).'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Terms</td><td>';
						if($row['inv_terms'] == 'end_of_month') { 
						    $output .= 'Due end of month';
						}else if($row['inv_terms'] == 'end_next_month'){
							$output .= 'Due end of next month';
						}else if($row['inv_terms'] == 'due_receipt'){
							$output .= 'Due on reciept';
						}else if($row['inv_terms'] == 'custom'){
							$output .= 'Custom';
                        }else{
							$output .= $row["inv_terms"];
						}		
						$output .= '</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Due Date</td><td>'.date("d F Y", strtotime($row['due_date'])).'</td>
						</tr>
						</table>
                       </td>
					   <td style="text-align:left; width:35%; padding-top:15px; vertical-align: top; ">
					   
						<table width="100%" style="max-width:800px; background:#fff; font-size:11px;">
						<tr><td colspan="2"></td></tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Supplier'."'".'s Ref:</td><td>'.$row['so_owner'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Other Reference(s):</td><td>'.$row['owner'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Buyer'."'".'s Order No.:</td><td>'.$row['cust_order_no'].'</td>
						</tr>
						<tr style="line-height: 0.8;">
							<td style="color: #615e5e;">Buyer'."'".'s Order Date:</td><td>'.date("d F Y", strtotime($row['buyer_date'])).'</td>
						</tr>
						</table>
					   
					   </td>
                       <td style="text-align:right; width:30%;">';
        				$image = $compnyDtail['company_logo'];
        					if(!empty($image))
        					{
        					$output .=  '<img style="width: 70px;" src="./uploads/company_logo/'.$image.'">';
        					}
        					else
        					{
        					$output .=  '<span class="h5 text-primary">'.$compnyDtail['company_name'].'</span>';
        					}
        					$output .= '
        				</td>
                    </tr>
                     </tbody>
                    </table>
                     <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                    
                        <tr>
						
						<td style="width: 49.5%; padding: 2px 10px 4px 10px; vertical-align: top;">
                            <h5 style="margin-top: 0px;margin-bottom: 2px;color: #6539c0;">Invoice From</h5>
                            <p style="margin: 0;font-size: 12px;">'.$branch['company_name'].'</p>
                           ';
                          if($branch["address"]!=""){
                          $output .=' <p style="margin: 0;font-size: 11px;">'.$branch["address"];
                          }
                          if($branch["city"]!=""){
                          $output .=  ', '.$branch["city"];
                          }
                          if($branch["zipcode"]!=""){
                          $output .=  ' - '.$branch["zipcode"];
                          }
                          if($branch["state"]!=""){
                          $output .=  ', '.$branch["state"];
                          }
                          
                          if($branch["country"]!=""){
                          $output .=  ', '.$branch["country"];
                          }
                          $output .=  '</p>';
						  if($branch["gstin"]!=""){
                          $output .=  '<p style="margin: 0;font-size: 11px;"><b>GSTIN:</b> '.$branch["gstin"].'</p>';
                          }
						  if($branch["branch_email"]!="" && $branch["show_email"]== 1){
						   $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">'.$branch["branch_email"].'</p>';
						  }
						  if($branch["contact_number"]!=""){
						   $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">+91-'.$branch["contact_number"].'</p>';
						  }
                          $output .=  ' </td>
						   
						 <td style="width: 1%;background:#fff;"></td>
						 
                         <td style="width: 49.5%; padding:0px 10px 4px 10px; vertical-align: top;">
						    <h5 style="margin-top: 0px;margin-bottom: 0px;color: #6539c0;">Invoice To</h5>
                          <p style="margin: 0;font-size: 12px;">'.
        				  $clientDtl->org_name.'</p>';
        				  if(!empty($clientDtl->primary_contact)){
                          $output .= '<p style="margin: 0;font-size: 11px;">
                            <b>Contact Name :</b> '.$clientDtl->primary_contact.'</p>';
                           }
                           $output .= '
                          <p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;">';
                          
                          if(!empty($clientDtl->shipping_address)){
                           $output .= $clientDtl->shipping_address;
                          }
                          if(!empty($clientDtl->shipping_city)){
                           $output .= ', '.$clientDtl->shipping_city;
                          }
                          if(!empty($clientDtl->shipping_zipcode)){
                           $output .= ' - '.$clientDtl->shipping_zipcode;
                          }
                          if(!empty($clientDtl->shipping_state)){
                           $output .= ', '.$clientDtl->shipping_state;
                          }
                          if(!empty($clientDtl->shipping_country)){
                           $output .= ', '.$clientDtl->shipping_country;
                          }
                           $output .= '</p>';
						   
                          if(!empty($clientDtl->gstin!="")){
                          $output .=  '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>GSTIN:</b> '.$clientDtl->gstin.'</p>';
                          }
                            if(isset($clientDtl->email)){
                          $output .= '<p style="margin-bottom: 0;font-size: 11px;margin-top: 0px;"><b>Email:</b>'.$clientDtl->email.' <br>
                          <b>Phone:</b> +91-'.$clientDtl->mobile.'</p>';
                            }
                       $output .= '</td>
						  
                    </tr>
                </table>
                <!--<table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Country of Supply : </b>'.$clientDtl->shipping_country.'</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Place of Supply : </b>'.$clientDtl->shipping_state.'</p>
                      </td>
                    </tr>
                 </tbody>
                </table>-->
        
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; margin-top:10px; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">';
                   
                        $igsttotal=0;
        				$sgsttotal=0;
        				$cgsttotal=0;
        				
        				$igst = explode("<br>",$row['igst']);
        				$sgst = explode("<br>",$row['sgst']);
        				$cgst = explode("<br>",$row['cgst']);
        				$proDiscount = explode("<br>",$row['pro_discount']);
						$totalDiscount=array_sum($proDiscount);
                   
                    $output .= '<tr>
					  <th width="3%" style="font-size: 11px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px;  padding: 6px;">
                       S.No.</div></th>
                       <th width="18%" style="font-size: 11px; background: #6539c0;">
                       Product/Services</th>
                       <th style="font-size: 11px; background: #6539c0;">HSN/SAC</th>
                      
                       <th style="font-size: 11px; background: #6539c0;">Qty</th>
					   <th style="font-size: 11px; background: #6539c0;">Tax</th>
                       <th style="font-size: 11px; background: #6539c0;">Rate</th>';
					   if($totalDiscount>0){
                       $output .= '<th style="font-size: 11px; background: #6539c0;">Discount</th>';
					   }
        				$output .= '<th style="font-size: 11px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 6px;">Tot. Price</div></th>
                       </tr>
                   </thead>
                   <tbody >';
                   
                        $product_name = explode("<br>",$row['product_name']);
        				$quantity = explode("<br>",$row['quantity']);
        				$unit_price = explode("<br>",$row['unit_price']);
        				$total = explode("<br>",$row['total']);
        				$total_withgst = explode("<br>",$row['sub_total_with_gst']);
        				$hsnsac = explode("<br>",$row['hsn_sac']);
        				$after_discount = ($row['initial_total']-$row['total_discount']);
        				if(!empty($row['gst'])){
        				  $gst = explode("<br>",$row['gst']);
        				}
        				$proDesc = explode("<br>",$row['pro_description']);
        				
        				
				        $arrlength = count($product_name);
        				$rw=0;
						$sr=1;
        				for($x = 0; $x < $arrlength; $x++){
        				    $rw++;
        					$num = $x + 1;
        					
        					if(isset($igst[$x]) && $igst[$x]!=""){
        						$igsttotal=$igsttotal+$igst[$x];
        					}
        					if(isset($sgst[$x]) && $sgst[$x]!=""){
        						$sgsttotal=$sgsttotal+$sgst[$x];
        					}
        					if(isset($igst[$x]) && $cgst[$x]!=""){
        						$cgsttotal=$cgsttotal+$cgst[$x];
        					}
				
        					
        					$output .='<tr>
        						<td style="font-size: 11px;padding: 5px 10px;">'.$sr.'</td>
        						<td style="font-size: 11px;padding: 5px 10px;">'.$product_name[$x].'</td>
        						
        						<td style="font-size: 11px;padding: 5px 10px;">'.$hsnsac[$x].'</td>
        						
        						<td style="font-size: 11px;padding: 5px 10px;">'.$quantity[$x].'</td>
								<td style="font-size: 11px;padding: 5px 10px;">GST@'.$gst[$x].'%</td>
        						<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($unit_price[$x]).'</td>';
        						if($totalDiscount>0){
        						$output .='<td style="font-size: 11px;padding: 5px 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($proDiscount[$x]).'</td>';
								}
        						$output .='<td style="font-size: 11px;padding: 5px 10px; "><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($total[$x]).'</td>
        					</tr>';
							if(isset($proDesc[$x]) && $proDesc[$x]!=""){	
							$output.='<tr>
							        <td style="font-size: 11px; padding:5px 10px;"></td>
									<td colspan="6" style="font-size: 11px; padding:5px 10px;">'.$proDesc[$x].'</td></tr>';
							}
						$sr++;
        			    }
        			    
                        $output .='
                  </tbody>
                </table>
        
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px; margin-top:0px; margin-bottom:8px;"><b style="font-size:12px;">Total in words:</b> <text style="font-size:11px;"> '.AmountInWords($row["sub_total"]).' only</text></p>';
                       if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){
               
                        $output .='<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:11px;">
                               <tr>
                                <td colspan="3">
                                    <h5 style="margin: 0px 0px 0px 8px; color: #6539c0; font-size:12px;">Bank Details</h5>
                                </td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">Account Holder Name:  <th>
                                   <td>'.ucfirst($bank_details_terms->acc_holder_name).'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
                                   <td>'.$bank_details_terms->account_no.'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
                                   <td>'.$bank_details_terms->ifsc_code.'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
                                   <td>'.ucfirst($bank_details_terms->account_type).'</td>
                               </tr>
                               <tr style="line-height: 0.8;">
                                   <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
                                   <td>'.ucfirst($bank_details_terms->bank_name).'</td>
                               </tr><tr style="line-height: 0.8;">';
                              
                                if($bank_details_terms->upi_id!=""){
                                $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
                                   <td>'.$bank_details_terms->upi_id.'</td>';
                                }
                                if(isset($_GET['dn']) && $_GET['dn']==1){
                                  $output .= '<th style="text-align:left;padding-left:10px;"><a href="'.base_url("home").'" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
                                }
                                
                                 $output .= '</tr>
                             </table>';
                   
                   }  
                   
                     $output .='</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["initial_total"]).'</td>
                          </tr>';
						  if($row["discount"]>0){
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$row["discount"].'</td>
                          </tr>';
						  
                          $output .='<tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($after_discount).'</td>
                          </tr>';
                          }
                          if($igsttotal!=0){	
							$output .='<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($igsttotal).'</td></tr>';
    					  }else{
    						
    							if($sgsttotal!=0){	
    								$output .='<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($sgsttotal).'</td></tr>';
    							}
    							if($cgsttotal!=0){	
    								$output .='<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($cgsttotal).'</td></tr>';
    							}
    						}
    						if($row['extra_charge_label']!=""){
    						 $extraCharge_name=explode("<br>",$row['extra_charge_label']);
    						 $extraCharge_value=explode("<br>",$row['extra_charge_value']);
    						for($y=0; $y<count($extraCharge_name); $y++){	
    							$output .='<tr><th style="font-size: 12px;" align="left">'.$extraCharge_name[$y].'</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($extraCharge_value[$y]).'</td></tr>';
    						}
    						}
        							
                          $output .='
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row["sub_total"]).'</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';
        
                $output .='<table width="100%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-bottom:30px margin-top:';
                    if(isset($bank_details_terms) && $bank_details_terms->enable_payment==1){ 
                        $output .='0px;">';
                        
                    }else{ 
                        $output .='-20px;">'; 
                        
                    }
                    $output .='<tbody>
                    <tr>
                  <td align="left" style="width:60%; padding:1px;">
                    <h5 style="color: #6539c0;margin: 0px;">Terms and conditions</h5>
                    <ol style="padding: 0 8px; font-size:11px; margin: 1px;">';
                     $custTerm=explode("<br>",$row["terms_condition"]); $no=1;
					 for($i=0; $i<count($custTerm); $i++){ 
					   $output .='<li>'.$custTerm[$i].'</li>'; 
					 }
                      //'.nl2br($row->terms_condition).'
                    $output .='</ol>
                  </td>';
                  
                  $output .='<td style="text-align:center;">';
        				$image = $row['signature_img'];
        				if(!empty($image)){
        			    $output .=  '<img style="width: 90px;" src="./assets/pi_images/'.$image.'">	';
        				}else{
							//$output .= '<text style="color: #615e5e; font-size:11px;">For '.$this->session->userdata('company_name').' (signature)</text>';
						}
                  $output .= '</td>';
        					$output .= '</tr>
							
					
                  </tbody>
                </table>';
				
				 
        
              $output .='</main>
        
              </body>
              </html>';
		}
		
	  $this->load->library('pdf');
      $this->dompdf->loadHtml($output);
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
	  $path = "assets/img/invoice_".$product_id.".pdf";	 
      file_put_contents($path, $attachmentpdf);
	  return $path; 
  }
  
  
  /**
  * Handle creation and update of invoice payment terms from POSTed arrays and respond with JSON status.
  * @example
  * // Simulate POST payload (controller context)
  * $_POST['terms_name'] = ['Net 30', 'Due on receipt'];
  * $_POST['no_ofdays'] = [30, 0];
  * $_POST['defaults_value'] = [0, 1];
  * $_POST['terms_id'] = [0, 5]; // 0 = create new term, 5 = update existing term with ID 5
  * // Call the controller method
  * $this->get_payment_terms();
  * // Possible outputs (echoed JSON):
  * // {"st":200}   // all terms processed successfully
  * // {"st":201}   // database save/update failed
  * // {"st":202,"terms_name":"Terms name and terms value is required"} // validation error for missing name/value
  * @param void $none - No function arguments; reads POST arrays: terms_name[], no_ofdays[], defaults_value[], terms_id[].
  * @returns void Echoes a JSON status object; does not return a PHP value.
  */
  public function get_payment_terms()
  {
	$terms_name		= $this->input->post('terms_name'); 
	$no_ofdays	    = $this->input->post('no_ofdays');
	$defaults_value	= $this->input->post('defaults_value');
	$terms_ids		= $this->input->post('terms_id');
	  
	for($rw=0; $rw < count($terms_name); $rw++ ){
		if($terms_name[$rw] && $no_ofdays[$rw] != ''){
		    $data = array(
			  'sess_eml' 		   => $this->session->userdata('email'),
			  'session_company'    => $this->session->userdata('company_name'),
			  'session_comp_email' => $this->session->userdata('company_email'),
			  'inv_terms' 	       => $terms_name[$rw],
			  'inv_value' 	       => $no_ofdays[$rw],
			  'marks_default'      => $defaults_value[$rw]
		    );
			if($terms_ids[$rw] != 0){
				$result= $this->invoice_model->update_payment_term($terms_ids[$rw], $data);
			}else{
				$result= $this->invoice_model->create_payment_term($data);
			} 
		}else{
			echo json_encode(array('st'=>202,'terms_name'=>'Terms name and terms value is required',));
		}
	} 
    if($result){	  
		echo json_encode(array('st'=>200));
	}else{
        echo json_encode(array('st'=>201));
    }
  } 
  
  function payment_terms_delete(){
	$terms_id		= $this->input->post('terms_id'); 
    $result = $this->invoice_model->delete_payment_term($terms_id);	
  }
  
  public function getpayment_byid($id){
    $result = $this->invoice_model->get_payment_byid($id);
	echo json_encode($result);	
  }
  public function getpayment($id){
    $result = $this->invoice_model->get_payment_adv($id);
	echo json_encode($result);	
  }
   
  /**
  * Deletes a payment record and updates related invoice and sale order payment totals.
  * @example
  * deletePayment(123);
  * // Outputs: {"status":true}
  * @param {int} $id - ID of the payment_history record to delete.
  * @returns {void} Echoes a JSON object {"status": true} on success and does not return a value.
  */
  public function deletePayment($id){
    $result 	= $this->invoice_model->get_payment_byid($id);
	$allResult 	= $this->invoice_model->get_inv_payment($result['invoice_id']);
	$indexVl	= count($allResult)-1;
	$pandingAmount=$allResult[$indexVl]['pending_payment'];
	$updateId=$allResult[$indexVl]['id'];
	$increasePendingAmount=($pandingAmount+$result['adv_payment']);
	$advanced_payment=$result['total_payment']-$increasePendingAmount;
	$data=array(
		 "pending_payment" 	=> $increasePendingAmount,
		 "advanced_payment" => $advanced_payment
    );
	$this->invoice_model->update_inv_payment(array('id' => $result['invoice_id'],'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
	$this->invoice_model->update_so_payment(array('saleorder_id' => $result['sales_id'],'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
	$dataDelete=array(
		 "delete_status" 	=> 0
    );
	$dataUpdateAm=array(
		 "pending_payment" 	=> $increasePendingAmount
    );
	
	$this->invoice_model->updatePayment_history(array('id' => $result['id'],'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $dataDelete);
	$this->invoice_model->updatePayment_history(array('id' => $updateId,'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $dataUpdateAm);
	echo json_encode(array("status" => TRUE));
  }
  
  /**
  * Update payment mode and advanced payment for an invoice and corresponding sales order.
  * Validates POST input, updates invoice and sales-order payment records, creates a payment history entry,
  * triggers workflow email notifications based on configurable rules and returns a JSON response.
  * @example
  * $_POST = [
  *   'sales_id' => '123', 
  *   'inv_id' => '456',
  *   'payment_mode' => 'Cash',
  *   'cheque_no' => '',
  *   'adv_payments' => '1,000',
  *   'add_adv_payment' => '0',
  *   'cal_pending_amount' => '5,000',
  *   'totals_amt' => '6,000',
  *   'payment_date' => '2025-12-17',
  *   'remarks' => 'Payment received'
  * ];
  * $result = $this->Invoices->update_paymentMode();
  * echo $result; // sample output: {"status":true} or {"st":202,"payment_mode":"Payment Mode is required","adv_payments":""}
  * @param string $sales_id - POST sales order id. Example: '123'
  * @param string $inv_id - POST invoice id. Example: '456'
  * @param string $payment_mode - POST payment mode (required). Example: 'Cash' or 'Cheque'
  * @param string $cheque_no - POST cheque/reference number (optional). Example: 'CHK12345'
  * @param string|float $adv_payments - POST advanced payment amount (required, commas allowed). Example: '1,000'
  * @param string|float $add_adv_payment - POST additional advanced payment to add (optional). Example: '0'
  * @param string|float $cal_pending_amount - POST calculated pending amount (required). Example: '5,000'
  * @param string|float $totals_amt - POST total invoice amount. Example: '6,000'
  * @param string $payment_date - POST payment date. Example: '2025-12-17'
  * @param string $remarks - POST optional remarks. Example: 'Received partial payment'
  * @returns string JSON encoded response: returns status JSON. On success: '{"status":true}', on DB update failure: '{"status":false}', on validation failure: '{"st":202,"payment_mode":"<error>","adv_payments":"<error>"}'.
  */
  public function update_paymentMode()
  {
	$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('payment_mode', 'Payment Mode', 'required|trim');
    //$this->form_validation->set_rules('cheque_no', 'Cheque Number', 'required|trim');
    $this->form_validation->set_rules('adv_payments', 'Advanced Payment', 'required|trim');
	$this->form_validation->set_message('required', '%s is required');
    if ($this->form_validation->run() == FALSE){
      return json_encode(array('st'=>202, 'payment_mode'=> form_error('payment_mode'), 'adv_payments'=> form_error('adv_payments')));
    }else{
		
     $sales_id = $this->input->post('sales_id');
     $inv_id = $this->input->post('inv_id');
	// echo $sales_id; exit;
     if($sales_id){   
        $payment_mode   = $this->input->post('payment_mode');
	    $cheque_no      = $this->input->post('cheque_no');
	    $adv_payments   = str_replace(",","",$this->input->post('adv_payments'));
	    $add_adv_payment= str_replace(",","",$this->input->post('add_adv_payment'));
        $adv_payment = $adv_payments+$add_adv_payment;
        $data=array(
		 "pending_payment" 	=> str_replace(",","",$this->input->post('cal_pending_amount')),
		 "advanced_payment" => $adv_payment
        );
		
		$result = $this->invoice_model->update_inv_payment(array('id' => $inv_id,'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
		$result = $this->invoice_model->update_so_payment(array('saleorder_id' => $sales_id,'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
	
	$createdata=array(
	     "sales_id"           => $sales_id,
	     "invoice_id"         => $inv_id,
	     "sess_eml"           => $this->session->userdata('email'),
		 "session_company"    => $this->session->userdata('company_name'),
		 "session_comp_email" => $this->session->userdata('company_email'),
         "payment_mode"       => $payment_mode,
		 "reference_no"       => $cheque_no,		
		 "total_payment"      => str_replace(",","",$this->input->post('totals_amt')),
		 "adv_payment"        => str_replace(",","",$this->input->post('adv_payments')),
		 "pending_payment"    => str_replace(",","",$this->input->post('cal_pending_amount')),
		 "payment_date"       => $this->input->post('payment_date'),
		 "remarks"            => $this->input->post('remarks'),
		 "ip"                 => $this->input->ip_address()
         );
	$results = $this->invoice_model->create_paymentHistory($createdata);
	
	if($result){
		$sales_data = $this->invoice_model->get_pi_byId($inv_id,$this->session->userdata('company_name'),$this->session->userdata('company_email'));
	
		$resultdata = $this->invoice_model->get_inv_payment($inv_id);
		$orgData 	= $this->invoice_model->orgDetail($sales_data['cust_id']);
		
	   // $resultdata = $this->Salesorders->get_paymentHistory_by_id($sales_id);
		//$sales_data = $this->Salesorders->get_by_id($sales_id);
            ###################################
            #       SETTING MAIL TO USER...   #
            ###################################
            
    $salesOrder = $this->invoice_model->getsalesbyid($sales_data['saleorder_id']);        
            
    $permissionSts		= check_permission_status('Receive mail on receive pending payment','other'); 
    $workFlowStsStsOwner	= check_workflow_status('Invoice','Mail notification on recieve payment');
    
	if($permissionSts==true && $workFlowStsStsOwner==true){
		$messageBody='';
		$subjectLine="Payement Confirmation - team365 | CRM";
		$messageBody.='<div class="f-fallback">
            <h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
            $messageBody.='<p>You just updated pending payment in invoice from team365 | CRM</p>';
    		$messageBody.='<p>Your Invoice Detail are given bellow:-</p>';
			$messageBody.='<p>Customer Name : '.$sales_data['org_name'].'</p>';
    		$messageBody.='<p>
			Invoice No. : '.$sales_data['invoice_no'].'
			<br>
			Invoice Date. : '.$sales_data['invoice_date'].'
			<br>
			Salesorder ID : '.$sales_data['saleorder_id'].'
			</p>';
    		$messageBody.=' </div>';
			sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
	}
	
	
	$workFlowStsStsOwnerInv	= check_workflow_status('Invoice','Mail notification to invoice owner on recieve payment');
	
	if($workFlowStsStsOwnerInv==true && $this->session->userdata('email')!=$sales_data['sess_eml']){
		$messageCust='';
		$subjectLine="Payement Confirmation from ".$this->session->userdata('company_name');
		$messageCust.='<div class="f-fallback">
            <h1>Dear , '.$sales_data['owner'].'</h1>';
            $messageCust.='<p>Payment has been reveived successfully of your sales order ₹ '.$this->input->post('adv_payments').' payment. Now your pending payment is ₹ '.$this->input->post('cal_pending_amount').' of total payment ₹ '.$this->input->post('totals_amt').'</p>';
    		$messageCust.='<p>Your Invoice Detail are given bellow:-</p>';
			$messageCust.='<p> Invoice No. : '.$sales_data['invoice_no'].'
			<br> Invoice Date. : '.$sales_data['invoice_date'].'
			</p>';
			$messageCust.='<p><b>Billed By : </b>'.$this->session->userdata('company_name').'</p>';
			$messageCust.='<p><b>Contact Person : </b>'.$this->session->userdata('name').'</p>';
			$messageCust.='<p><b>Email : </b>'.$this->session->userdata('email').'</p>';
    		$messageCust.=' </div>';
			sendMailWithTemp($sales_data['sess_eml'],$messageCust,$subjectLine);
	
	}
	
	
	$workFlowStsStsOwnerSo	= check_workflow_status('Invoice','Mail notification to SO owner on recieve payment');
	
	
	if($workFlowStsStsOwnerSo==true && $this->session->userdata('email')!=$sales_data['sess_eml']){
		$messageCust='';
		$subjectLine="Payement Confirmation from ".$this->session->userdata('company_name');
		$messageCust.='<div class="f-fallback">
            <h1>Dear , '.$salesOrder['owner'].'</h1>';
            $messageCust.='<p>Payment has been reveived successfully of your sales order ₹ '.$this->input->post('adv_payments').' payment. Now your pending payment is ₹ '.$this->input->post('cal_pending_amount').' of total payment ₹ '.$this->input->post('totals_amt').'</p>';
    		$messageCust.='<p>Your Invoice Detail are given bellow:-</p>';
			$messageCust.='<p> Invoice No. : '.$sales_data['invoice_no'].'
			<br> Invoice Date. : '.$sales_data['invoice_date'].'
			</p>';
			$messageCust.='<p><b>Billed By : </b>'.$this->session->userdata('company_name').'</p>';
			$messageCust.='<p><b>Contact Person : </b>'.$this->session->userdata('name').'</p>';
			$messageCust.='<p><b>Email : </b>'.$this->session->userdata('email').'</p>';
    		$messageCust.=' </div>';
			sendMailWithTemp($salesOrder['sess_eml'],$messageCust,$subjectLine);
	
	}
	
	$workFlowStsStsCut	= check_workflow_status('Customer','Mail notification on accept payment');
	
	if($workFlowStsStsCut==true){
		$messageCust='';
		$subjectLine="Payement Confirmation from ".$this->session->userdata('company_name');
		$messageCust.='<div class="f-fallback">
            <h1>Dear , '.$orgData['primary_contact'].'</h1>';
            $messageCust.='<p>Thank you for your ₹ '.$this->input->post('adv_payments').' payment. Now your pending payment is ₹ '.$this->input->post('cal_pending_amount').' of total payment ₹ '.$this->input->post('totals_amt').'</p>';
    		$messageCust.='<p>Your Invoice Detail are given bellow:-</p>';
			$messageCust.='<p> Invoice No. : '.$sales_data['invoice_no'].'
			<br> Invoice Date. : '.$sales_data['invoice_date'].'
			</p>';
			$messageCust.='<p><b>Billed By : </b>'.$this->session->userdata('company_name').'</p>';
			$messageCust.='<p><b>Contact Person : </b>'.$this->session->userdata('name').'</p>';
			$messageCust.='<p><b>Email : </b>'.$this->session->userdata('email').'</p>';
    		$messageCust.=' </div>';
			sendMailWithTemp($orgData['email'],$messageCust,$subjectLine);
	}
	
			/*  SEND TO ADMIN  */
	$workFlowStsStsAdmin = check_workflow_status('Admin','Mail notification on accept invoice payment');
	if($workFlowStsStsAdmin==true){
		 $messagetoAdmin='';
		 $subjectAdmin='Payment status updated by '.ucwords($this->session->userdata('name')).'  - team365 | CRM';
		 $messagetoAdmin.='<div class="f-fallback">
            <h1>Dear , Admin!</h1>';
            $messagetoAdmin.='<p>Payment status updated by '.ucwords($this->session->userdata('name')).'  - team365 | CRM</p>';
    		$messagetoAdmin.='<p>Payment detail:-</p>';
			$messagetoAdmin.='<p>Customer Name : '.$sales_data['org_name'].'</p>';
    		$messagetoAdmin.='<p>
			Invoice No. : '.$sales_data['org_name'].'
			<br>
			Invoice Date. : '.$sales_data['invoice_date'].'
			<br>
			Salesorder ID : '.$sales_data['saleorder_id'].'
			<br>
			Accept Payment : '.$this->input->post('adv_payments').'
			<br>
			Pending Payment : '.$this->input->post('cal_pending_amount').'
			<br>
			Payment Mode : '.$this->input->post('payment_mode').'
			<br>';
    		$messagetoAdmin.='</div>';
			sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);;	
	}	
			
	    /*
	    //$sales_data = $this->Salesorders->get_by_id($sales_id);
		$email= $sales_data->sess_eml;
		$subject = "Payement Accepted #".$sales_data->saleorder_id." - Allegient.";
	    $adminmessage ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <title>'.$sales_data->session_company.' Mail</title>
                    <style type="text/css">
                     body {margin: 0; padding: 0; min-width: 100%!important;}
                        .content {width: 100%; max-width: 600px;}  
                    </style>
                </head>
                <body>
		   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
			<tr style="background: linear-gradient(#0070d2, #448aff);">
			  <td style="text-align:center; height: 60px; color:#fff;"><h2>'.$sales_data->session_company.'</h2></td>
			</tr>
			<tr><td>
				<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr><td colspan="2"><b>Dear&nbsp</b>'.$sales_data->owner.',</td></tr>
				 <tr><td colspan="2"><b>Your Salesorder</b>:'.$sales_data->saleorder_id.',</td></tr>
				 <tr><td colspan="2"><b>I have received Rs '.$this->input->post('adv_payments').' for your sales order.</b>'.$sales_data->total_payment.',</td></tr>
				<tr><td><b>SO-Id&nbsp&nbsp:</b>'.$sales_data->saleorder_id.'</td></tr>
					<tr><td><b>Payment Accepted By&nbsp:</b>'.$this->session->userdata('name').'</td></tr>
				<br>
				<tr><td>
					<table style="width:70%;">
						<tr><td><b>Subject</b></td><th>:</th><td>'.$sales_data->subject.'</td></tr>
						<tr><td><b>Organization Name</b></td><th>:</th><td>'.$sales_data->org_name.'</td></tr>';
				$adminmessage .='<tr><td><b>Total Amount</b></td><th>:</th><td>'.$sales_data->sub_totals.'</td></tr>';
						$total=$sales_data->sub_totals;
						$advPay=$sales_data->advanced_payment;
						$pendingPay=$total-$advPay;
						$adminmessage .='<tr><td><b>Pending Amount</b></td><th>:</th><td>'.$pendingPay.'</td></tr></table>';
						$adminmessage .='<table>
						
						<tr style="background: #caccce;">
						<th>Payment Mode</th>
						<th>Paid Amount</th>
						<th>Payment Date</th>
						</tr>';
						foreach($resultdata as $row){
							
							$adminmessage .='<tr><td>'.$row->payment_mode.'</td><td>'.$row->adv_payment.'</td><td>'.$row->payment_date.'</td></tr>';
						}
					$adminmessage .='</table>
				  </td>
				</tr>
				<tr><td><br></td></tr>
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
	   $this->email_lib->send_email($email,$subject,$adminmessage);
	   $this->email_lib->send_email($this->session->userdata('company_email'),$subject,$adminmessage);
	   
	   $userListNoti = $this->Salesorders->get_stnduser_notification('On Accept Payment');
	   $dataUserlist=explode(',',$userListNoti[0]['user_list']);
	   
	    for($i=0; $i<count($dataUserlist); $i++){
	       $standerd_email = $this->Salesorders->get_stnduser_foremail($dataUserlist[$i]);
	       foreach($standerd_email as $stand_user){
		        $this->email_lib->send_email($stand_user->standard_email,$subject,$adminmessage);
	       }  
	    }*/
		
	    
       echo json_encode(array("status" => TRUE));
	}else{
		 echo json_encode(array("status" => FALSE));
	}
     }
	}
  }
  
  
// Please write code above this  
}
?>