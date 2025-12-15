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