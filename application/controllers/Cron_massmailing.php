<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_massmailing extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Massmailing_model');
    $this->load->library(array('upload','email_lib'));
  }
  
  
	public function index()
	{
	   
	    
	    $email = $this->Massmailing_model->get_email();
	    for($k=0; $k<count($email); $k++){
	        if(isset($email[$k]['id']) && $email[$k]['id']!=""){
	            $userName=$email[$k]['full_name'];
				$userEmail=$email[$k]['eamil'];
				$template_name=$email[$k]['template_name'];
				$firstFile=$template_name;
				if(file_exists($firstFile)){
					$message=file_get_contents($firstFile);
					//$this->load->library('email_lib');
					//$filePathName=$firstFile;
					//echo $message;
					$this->email_lib->send_email($userEmail,'Hi Sir/Mam',$message);
					
				}else {
					//echo  $firstFile;
				}
				$this->Massmailing_model->update_email($email[$k]['id']);
           
			}
	    }
	    
	}
	
}
?>