<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permission extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Contact_model','Contact');
    $this->load->model('Permission_model','Permission');
	$this->load->model('Login_model');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
      $this->load->view('permission');
    }
    else
    {
      redirect('login');
    }
  }
  
  public function set_permission()
  {
    if(!empty($this->session->userdata('email')))
    {
	  if(isset($_GET['u'])){	
		  $id			= $_GET['u'];
		  $data['user'] = $this->Login_model->get_by_id($id);
		  $data['module'] = $this->Permission->get_all_module($id);
		  $this->load->view('users/set-permission',$data);
	  }else{
		   redirect('error');
	  }
    }
    else
    {
      redirect('login');
    }
  }
  
  public function change_permission()
  {
	 
    if(!empty($this->session->userdata('email'))){
	  $mdlName 	= $this->input->post('mdlName');
	  $status 	= $this->input->post('status');
	  $userEmail= $this->input->post('userEmail');
	  $userid 	= $this->input->post('userid');
	  $clmn 	= $this->input->post('clmn');
	  $set_by   = $this->session->userdata('email');
	  $session_company 	= $this->session->userdata('company_name');
	  $session_comp_email = $this->session->userdata('company_email');
	  $checkExist = $this->Permission->check_exist($mdlName,$userEmail,$userid);
	  
	  if(isset($checkExist['id']) && $checkExist['id']!=""){
		 
		$DataArr=array(
			$clmn =>$status,
			'updated_date' 	=> date('Y-m-d'),
			'update_by' 	=> $set_by
		);
		$this->Permission->update_status($DataArr,$checkExist['id']);
		echo "Updated";
	  }else{
		$DataArr=array(
			'user_id' 		=> $userid,
			'user_email' 	=> $userEmail,
			'set_by' 		=> $set_by,
			'session_company'=> $session_company,
			'session_comp_email'=> $session_comp_email,
			'module_name' 	=> $mdlName,
			$clmn 			=> $status,
			'currentdate' 	=> date('Y-m-d'),
			'delete_status'	=> 1,
			'ip' 			=> $this->input->ip_address()
		);
		$this->Permission->insert_status($DataArr);
		echo "Inserted";
	  }
	  
    }else{
      redirect('login');
    }
  }
 
}
?>
