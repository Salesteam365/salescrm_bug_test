<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_details extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_model');
		$this->load->model('Branch_model');
		$this->load->model('Reports_model');
		$this->load->model('mail_model');
		$this->load->library(array('upload','email_lib'));
	}
	
	public function index()
  	{
  	    if(!empty($this->session->userdata('email')))
	    {
	        $data['email_details'] = $this->mail_model->get_allemail();
	        $this->load->view('setting/view_label',$data);
		}else{
		    redirect(base_url());
		}
		
	
	}
	
	public function mail_configure()
  	{
		if(!empty($this->session->userdata('email')))
	    {
	      $data = array();
	      $id = $this->uri->segment(3); //die;
	      if($id){
	      $data['all_email'] = $this->mail_model->get_allemail($id);
	      }
	      $this->load->view('setting/mail_config',$data);
		}else{
		    redirect(base_url());
		}
		
	}
	
	public function composeMail(){
	    
	    $recEmail       = $this->input->post('recEmail');
	    $ccEmail        = $this->input->post('ccEmail');
	    $subEmail       = $this->input->post('subEmail');
	    $descriptionTxt = $this->input->post('descriptionTxt');
	    $RecName        = $this->input->post('RecName');
	    
	    $email_details = $this->mail_model->get_allemail();
	    
	    $this->load->library('phpmailer_lib');
	    $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host     = $email_details['smtp_host'];
        $mail->SMTPAuth = true;
        $mail->Username = $email_details['email_id']; 
        $mail->Password = $email_details['email_password']; 
        $mail->setFrom($email_details['email_id'], $email_details['session_company']);
        $mail->addAddress($recEmail, $RecName);
        $mail->addReplyTo($email_details['email_id'], $email_details['session_company']); 
        $mail->SMTPSecure = $email_details['encryption_type'];
        $mail->Port     = $email_details['gmail_port'];
        
        // Add cc or bcc 
        if($ccEmail){
        $mail->addCC($ccEmail);
        }
       // $mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subEmail;
        
        // Set email format to HTML
        $mail->isHTML(true);
        $mail->Body = $descriptionTxt;
       
        // Send email
        if(!$mail->send()){
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
           echo '0';
        }else{
            echo '1';
        }
	}
	
	public function mail_message_iframe()
  	{
		if(!empty($this->session->userdata('email')))
	    {
	        $id = $this->uri->segment(3); //die;
	        $data['email_details'] = $this->mail_model->get_allemail($id);
	        $this->load->view('setting/view_message_iframe',$data);
		}else{
		    redirect(base_url());
		}
	
	}
	
	public function mail_message()
  	{
		if(!empty($this->session->userdata('email')))
	    {
	        $id = $this->uri->segment(3); //die;
	        $data['email_details'] = $this->mail_model->get_allemail($id);
	        $this->load->view('setting/view_message',$data);
		}else{
		    redirect(base_url());
		}
	
	}
	
	public function add_mailDetails()
    {
        $config_id       = $this->input->post('config_id');
        
        $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
        $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'required|trim');
    if($config_id == 'add_new_config'){
	    $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email|trim|is_unique[mail_config.email_id]');
    }else{
        $this->form_validation->set_rules('email_id', 'Email', 'required|valid_email|trim');
    }
        $this->form_validation->set_rules('email_pass', 'Email Password', 'required|trim');
        $this->form_validation->set_rules('encryption_type', 'Encryption', 'required|trim');
        $this->form_validation->set_rules('folder_name', 'Folder', 'required|trim');
        $this->form_validation->set_rules('gmail_port', 'Gmail port', 'required|trim');
	    $this->form_validation->set_message('required', '%s is required');
	    $this->form_validation->set_message('valid_email', '%s is not valid');	   
	    if($this->form_validation->run() == FALSE)
	    {
			echo json_encode(array('st' => 202, 'smtp_host'=> form_error('smtp_host'), 'email_id'=> form_error('email_id'), 'email_pass'=> form_error('email_pass') , 'encryption_type'=> form_error('encryption_type') , 'folder_name'=> form_error('folder_name') , 'gmail_port'=> form_error('gmail_port')  ));
	    	exit;
	    }
	    else
	    {
	        
	        
	       $email_id        = $this->input->post('email_id');
		   $email_pass      = $this->input->post('email_pass');
		   $smtp_host       = $this->input->post('smtp_host');
		   $encryption_type = $this->input->post('encryption_type');
		   $folder_name     = $this->input->post('folder_name');
		   $gmail_port      = $this->input->post('gmail_port');
		   
		
		  $data = array(
			'sess_eml' 			=> $this->session->userdata('email'),
			'session_company' 	=> $this->session->userdata('company_name'),
			'session_comp_email'=> $this->session->userdata('company_email'),
			'email_id' 		    => $email_id,
			'email_password'    => $email_pass,
			'smtp_host' 		=> $smtp_host,
			'encryption_type'   => $encryption_type,
			'folder_name' 		=> $folder_name,
			'gmail_port'        => $gmail_port,
		  );
		  if($config_id == 'add_new_config'){
		     $id = $this->mail_model->create_mail($data);
		  }else{
		     $id = $this->mail_model->update_mail($config_id, $data); 
		  }
		  if($id){
			   //ajax_label_table($email_id,$email_pass);  
		    echo json_encode(array('status' => true,'st' => 200, 'id' => $id));
		  }else{
			echo json_encode(array('status' => false));  
		  }
		}
    }
  
  
  
	
}