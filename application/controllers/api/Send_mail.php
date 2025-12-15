<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Send_mail extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->library('email_lib');
    }
       
       
       
    public function index_post()
    {
        $email   = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        if($email !='' && $subject !='' && $message !=''){
        
        if($this->email_lib->send_email($email, $subject, $message)){
           $this->response(['Mail send successfully.'], REST_Controller::HTTP_OK); 
        }else{
           $this->response(['Some error occure!.'], REST_Controller::HTTP_OK); 
        }
    	
        }else{
           $this->response(['Email and subject and message are required.'], REST_Controller::HTTP_OK); 
        }
    }
    
    
}
?>