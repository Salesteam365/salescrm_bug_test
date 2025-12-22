<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Roles extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Performainvoice_model','Performainvoice');
	$this->load->model('roles_model');
	$this->load->model('Login_model','Login');
  }
  /**
   * Index method for the Roles controller.
   * Checks for an authenticated session user (by 'email'). If present, it loads role data and admin name,
   * then renders the 'setting/view_roles' view. If no authenticated session is found, it redirects to the 'login' route.
   * @example
   * // Accessed via browser:
   * // GET https://example.com/roles  -> renders 'setting/view_roles' when logged in or redirects to '/login' when not.
   * // Example call from code:
   * $this->load->controller('Roles');
   * $this->roles->index();
   * // Example data passed to the view when logged in:
   * // $data = [
   * //   'roles' => [
   * //     ['id' => 1, 'name' => 'Admin'],
   * //     ['id' => 2, 'name' => 'Editor']
   * //   ],
   * //   'admin' => 'site_admin'
   * // ];
   * @param void none - This method accepts no parameters.
   * @returns void Renders 'setting/view_roles' with roles and admin data when the session email exists; otherwise redirects to 'login'.
   */
  public function index()
  {
      
    /*  
    $data= ['mail'=> ['username'=>'team365.dev2@gmail.com', 'password'=>'sanoj@123']];    
    //$data=require_once('config.php');
    $mail_handle=imap_open("{imap.gmail.com:993/ssl}",$data['mail']['username'],$data['mail']['password']);
    $headers=imap_headers($mail_handle);
    $last=imap_num_msg($mail_handle);
    $singleMail=imap_header($mail_handle,3);
    $singleMailBody=imap_body($mail_handle,2);
    echo $singleMailBody;
    imap_close($mail_handle); 
    exit;
   */
   
   
   /*
   $data= ['mail'=> ['username'=>'no-reply@team365.io', 'password'=>'Wos13185']];    
    //$data=require_once('config.php');
    $mail_handle=imap_open("{smtp.office365.com:993/ssl}",$data['mail']['username'],$data['mail']['password']);
    $headers=imap_headers($mail_handle);
    echo "<pre>";
    print_r($headers);
    echo "</pre>";
    
    $last=imap_num_msg($mail_handle);
    $singleMail=imap_header($mail_handle,3);
    $singleMailBody=imap_body($mail_handle,2);
    //echo $singleMailBody;
    imap_close($mail_handle); 
    exit;
    
    */
    
    /*
    
    $data= ['mail'=> ['username'=>'team365.dev2@yahoo.com', 'password'=>'autpl@2020']];    
    //$data=require_once('config.php');
    $mail_handle=imap_open("{imap.mail.yahoo.com:993/ssl}",$data['mail']['username'],$data['mail']['password']);
    $headers=imap_headers($mail_handle);
    echo "<pre>";
    print_r($headers);
    echo "</pre>";
    
    $last=imap_num_msg($mail_handle);
    $singleMail=imap_header($mail_handle,3);
    $singleMailBody=imap_body($mail_handle,2);
    //echo $singleMailBody;
    imap_close($mail_handle); 
    exit;
      */
      
      
      
  	if(!empty($this->session->userdata('email')))
    {
	  $data = array();
	  $data['roles'] = $this->roles_model->get_allroles();
      $data['admin'] = $this->Login->getadminname();
      $this->load->view('setting/view_roles',$data);
    }
    else
    {
      redirect('login');
    }
  }
  
    public function getrolesbyId()
  	{
	    $id=$this->input->post('dataid');
        $data = $this->roles_model->get_roleby_id($id);
	    echo json_encode($data);
  	}
  

  
  /**
  * Load the "Add Role" page with available roles if the user is authenticated; otherwise redirect to the login page.
  * @example
  * $rolesController = new Roles();
  * $rolesController->create_newRole();
  * // When session userdata('email') is set, this renders 'setting/add_role' with $data['roles'] populated.
  * // If not authenticated, it redirects the browser to 'login'.
  * @param void $none - This method does not accept any parameters.
  * @returns void - Does not return a value; renders a view or issues a redirect.
  */
  public function create_newRole()
  {
  	if(!empty($this->session->userdata('email')))
    {
	 $data = array();
	  
	   $data['roles'] = $this->roles_model->get_allroles();
      $this->load->view('setting/add_role',$data);
    }
    else
    {
      redirect('login');
    }
  }
  
  
  public function delete_pi($id)
  {
    $this->Performainvoice->delete_pi($id);
    echo json_encode(array("status" => TRUE));
  }
  
  /**
   * Add, update or soft-delete a role record based on the POST 'methodSaving' flag.
   * @example
   * $_POST = [
   *   'methodSaving' => 'save', // valid values: 'save', 'update', 'delete'
   *   'role_name'    => 'Project Manager',
   *   'parent_role'  => '2',
   *   'updateId'     => '5',    // required when methodSaving == 'update'
   *   'deleteId'     => '5'     // required when methodSaving == 'delete'
   * ];
   * // When called in controller context, the method will create/update/delete the role
   * // via $this->roles_model and then redirect to the roles listing:
   * // $this->add_roleDetails();
   * @param {void} $none - No direct parameters; function reads data from POST and session.
   * @returns {void} Redirects to base_url('roles') after performing the requested operation.
   */
  public function add_roleDetails()
  {
   
	 $saveMethod=$this->input->post('methodSaving');
	 
	 if(isset($saveMethod) && $saveMethod=='save'){
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'role_name' 		=> $this->input->post('role_name'),
        'parent_role_id'    => $this->input->post('parent_role'),
      
      );
      $id = $this->roles_model->create_role($data);
	 }else if($saveMethod=='update'){
	      $data = array(
    	    'role_name' 		=> $this->input->post('role_name'),
            'parent_role_id'    => $this->input->post('parent_role'),
         );
         $updateId=$this->input->post('updateId');
         $id = $this->roles_model->update_role($data,$updateId);
	 }else if($saveMethod=='delete'){
	      $data = array( 'delete_status'     => 2  );
         $updateId=$this->input->post('deleteId');
         $id = $this->roles_model->update_role($data,$updateId);
	 }
      if($id){	  
		redirect(base_url('roles'));
	  }
      else
      {
		  redirect(base_url('roles'));
      }
	//}
  }
  
  
  
  
  
  
  /**
  * Update invoice details using POSTed form data and echo JSON success/failure response.
  * @example
  * // Example using curl:
  * // curl -X POST https://example.com/roles/update_invoiceDetails \
  * //  -d "client_bname=ACME Corp" \
  * //  -d "client_address=123 Main St" \
  * //  -d "client_country=US" \
  * //  -d "client_state=CA" \
  * //  -d "client_city=Los Angeles" \
  * //  -d "client_zipcode=90001" \
  * //  -d "invc_id=42"
  * // Expected output on success:
  * // {"status":true,"st":200}
  * // Expected output on failure:
  * // {"status":false}
  * @param string $client_bname - Client business name (POST)
  * @param string $client_address - Client address (POST)
  * @param string $client_country - Client country (POST)
  * @param string $client_state - Client state (POST)
  * @param string $client_city - Client city (POST)
  * @param string $client_zipcode - Client ZIP/postal code (POST)
  * @param int $invc_id - Invoice ID to update (POST)
  * @returns void Echoes JSON response; on success {"status":true,"st":200}, on failure {"status":false}.
  */
  public function update_invoiceDetails(){
	$validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
	  
    }
    else
    {
	
      $data = array(
       
        'client_bname' 		=> $this->input->post('client_bname'),
        'client_address' 	=> $this->input->post('client_address'),
        'client_country' 	=> $this->input->post('client_country'),
        'client_state' 		=> $this->input->post('client_state'),
        'client_city' 		=> $this->input->post('client_city'),
        'client_zipcode' 	=> $this->input->post('client_zipcode'),
      
      );
	 
	  
	  $piId=$this->input->post('invc_id');
      $id = $this->Performainvoice->update_pi($data,$piId);
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
   * Validate performa invoice form input and return validation result.
   * @example
   * // Example when a required field is missing (e.g. invoice_no not provided):
   * // Simulate form POST and call from a controller method:
   * $_POST = [
   *   'invoice_date' => '2025-12-22',
   *   'items' => ['Item A'],
   *   'quantity' => ['2'],
   *   'unit_price' => ['10.00'],
   *   'billedby' => 'Seller Co',
   *   'billedto' => 'Buyer LLC'
   * ];
   * $result = $this->check_validation();
   * echo $result;
   * // Possible output (validation failed): 
   * // {"st":202,"invoice_no":"<div class=\"error\">Invoice Number is required</div>","invoice_date":"","items":"","quantity":"","unit_price":"","billedby":"","billedto":""}
   *
   * // Example when validation passes (all required fields provided):
   * $_POST['invoice_no'] = 'PI-1001';
   * $result = $this->check_validation();
   * echo $result; // Outputs: 200
   *
   * @returns int|string Returns integer 200 on successful validation, or a JSON-encoded string (st => 202) with per-field error messages on failure.
   */
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
	$piId=$this->input->post('invc_id');
	if(empty($piId)){
    $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim|is_unique[performa_invoice.invoice_no]');
	}
    $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
    $this->form_validation->set_rules('items[]', 'Iitems', 'required|trim');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
    $this->form_validation->set_rules('unit_price[]', 'Unit Price', 'required|trim');
	$this->form_validation->set_rules('billedby', 'BusinessBy', 'required|trim');
	$this->form_validation->set_rules('billedto', 'BusinessTo', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');
   
    if ($this->form_validation->run() == FALSE)
    {
		if(empty($piId)){
      return json_encode(array('st'=>202, 'invoice_no'=> form_error('invoice_no'), 'invoice_date'=> form_error('invoice_date'),'items'=> form_error('items'), 'quantity'=> form_error('quantity'), 'unit_price'=> form_error('unit_price'), 'billedby'=> form_error('billedby'), 'billedto'=> form_error('billedto')));
		}else{
			 return json_encode(array('st'=>202, 'invoice_date'=> form_error('invoice_date'),'items'=> form_error('items'), 'quantity'=> form_error('quantity'), 'unit_price'=> form_error('unit_price'), 'billedby'=> form_error('billedby'), 'billedto'=> form_error('billedto')));
		}
    }
    else
    {
      return 200;
    }
  }
  
   /**
   * Get role by ID from POST and echo JSON of the parent role or a status code when no parent exists.
   * @example
   * // HTTP POST example (via curl):
   * // curl -X POST -d "role_id=5" https://example.com/roles/get_rolebyid
   * // Possible responses:
   * // {"id":5,"name":"Editor","parent_role_id":2}   // when parent exists
   * // "201"                                        // when parent_role_id == 0
   * @param int $role_id - Role ID supplied via POST (example: 5).
   * @returns void Outputs JSON-encoded role details (array/object) when a parent exists or the string "201" when parent_role_id is 0.
   */
   public function get_rolebyid()
  {
      $role_id = $this->input->post('role_id');
      $data = $this->roles_model->get_roleby_id($role_id);
      $data_details=array();
      if($data['parent_role_id']==0){
         $data_details = '201';  
      }else{
         $data_details = $this->roles_model->get_roleby_id($data['parent_role_id']);
      }
	  echo json_encode($data_details);
  }
 // Please write code above this  
}
?>