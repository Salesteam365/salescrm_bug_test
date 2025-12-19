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
  /**
  * Display the change password page for an authenticated superadmin, or redirect to the superadmin login if not authenticated.
  * @example
  * // When superadmin is authenticated:
  * $this->session->set_userdata('superadmin_email', 'admin@example.com');
  * $this->Change_password->index();
  * // -> loads view 'superadmin/change_password'
  * // When not authenticated:
  * $this->session->unset_userdata('superadmin_email');
  * $this->Change_password->index();
  * // -> redirects to 'superadmin/login'
  * @param {void} $none - No parameters.
  * @returns {void} Performs a view load or redirect; does not return a value.
  */
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

  /**
  * Change the logged-in superadmin password: validates POST input ('newpass', 'connewpass'), updates via Password_model and echoes a JSON status message or redirects to login when not authenticated.
  * @example
  * $this->changePass();
  * // Possible echoed output: {"status":"<i class=\"fas fa-check-circle\" style=\"color:green\"></i>&nbsp;&nbsp;Password changed successfully"}
  * @param void $none - No direct parameters; reads POST 'newpass' and 'connewpass' and checks session 'superadmin_email'.
  * @returns void Echoes a JSON response with a 'status' HTML message on success/failure or redirects to 'superadmin/login'.
  */
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
  
  
  
  /**
  * Check the current user's password provided via POST and respond with JSON indicating whether it matches.
  * @example
  * // Simulate a POST request with the old password and call the controller method:
  * $_POST['oldpass'] = 'currentPassword123';
  * $ctrl = new Change_password();
  * $ctrl->checkPass();
  * // Possible outputs:
  * // {"status":true}  // when password matches
  * // {"status":false} // when password does not match
  * // {"status":"Old password can't be empty"} // when 'oldpass' is missing or empty
  * @param {string} $oldpass - The old/current password supplied via POST key 'oldpass'.
  * @returns {void} Echoes a JSON object with a 'status' key (boolean on check result or string on validation error) or redirects to superadmin login if session is missing.
  */
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