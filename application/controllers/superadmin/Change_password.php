<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Change_password extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('superadmin/Password_model','Password_model');
    
  }
  public function index()
  {

    if(!empty($this->session->userdata('superadmin_email')))
    {
      $this->load->view('superadmin/change_password');
    }
    else
    {
      redirect('superadmin/login');
    }

  }

  public function changePass()
  {

    if(!empty($this->session->userdata('superadmin_email')))
    {  
			$newpass 	= $this->input->post('newpass');
			$connewpass = $this->input->post('connewpass');
			if(strlen($newpass)<8){
				echo json_encode(array('status' => '<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Password must be at least 8 characters.'));
			}else if($newpass!=$connewpass){
				echo json_encode(array('status' => '<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Must match the previous new password'));
			}else{
				$msg=$this->Password_model->changePassword($newpass);
				if($msg){
					echo json_encode(array('status' => '<i class="fas fa-check-circle" style="color:green"></i>&nbsp;&nbsp;Password changed successfully'));
				}else{
					echo json_encode(array('status' => '<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Something went wrong! Please try later'));
				}
			}
		
	 
    }else
    {
      redirect('superadmin/login');
    }

  }
  
  
  
  public function checkPass()
  {
    if(!empty($this->session->userdata('superadmin_email')))
    {
  	 $oldpass = $this->input->post('oldpass');
	 if(!empty($oldpass)){
		 $data = $this->Password_model->checkPass($oldpass);
		 if($data){
			 echo json_encode(array('status' => true));
		 }else{
			 echo json_encode(array('status' => false));
		 }
	 }else{
		    echo json_encode(array('status' => "Old password can't be empty"));
	 } 
    }
    else
    {
      redirect('superadmin/login');
    }

  }


  /*******end function*******/
}