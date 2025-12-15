<?php
class Email_Marketing extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		ini_set('max_execution_time',300);
		$this->load->helper('url');
		$this->load->model('Organization_model','Organization');
		$this->load->model('Email_Marketing_model','Marketing_model');
		$this->load->model('Login_model');
		$this->load->library('email_lib');
		$this->load->library('excel');
		
		
	}
   public function index()
   {
    if(!empty($this->session->userdata('email')))
    { 
       if(checkModuleForContr('Email Marketing')<1){
	    redirect('home');
	    exit;
   	    } 
	  $data['orgdata']= $this->Marketing_model->getOrgData();
	  $data['custype']= $this->Marketing_model->cusr_type();
      $this->load->view('email_marketing/email_marketing',$data);
    }
    else
    {
      redirect('login');
    }
  }
  
  /*function index()
	{ 
		$this->load->view('upload_form_view', array('error' => ' ' ));
	}*/
	
	function file_upload()
	{
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "admintea_team365";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		
		
		$img_file      = $_FILES["csvfileEmailzip"]['name'];
		$uploadedFile='';
		$dirpath = './uploads/mail_temp/';
		if($img_file!=""){ 
				$config['upload_path']   = './uploads/mail_temp/';
				$config['allowed_types'] = 'csv';
				 //$config['max_size']      = 2097152;
				$img_file = time()."_".str_replace(' ','_',$_FILES["csvfileEmailzip"]['name']);
				$config['file_name'] = $img_file;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('csvfileEmailzip');
				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData['file_name'];
		}
		
		// Upload Zip file...
		$zip_file      = $_FILES["scv_image_zip"]['name'];
		$config['upload_path'] 	 = './uploads/mail_temp/';
		$config['allowed_types'] = 'zip';
		$config['file_name']	 = $zip_file;
		$config['max_size']		 = '';
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload('scv_image_zip'))
		{
			$error = array('error' => $this->upload->display_errors());
			//print_r($error); exit;
		}else{
			$data = array('upload_data' => $this->upload->data());
			$zip = new ZipArchive;
			$file = $data['upload_data']['full_path'];
			chmod($file,0777);
			if ($zip->open($file) === TRUE) {
    				$zip->extractTo('./uploads/mail_temp/');
    				$zip->close();
			}
			
			$newArr		= $data['upload_data'];
			$fileName	= $newArr['file_name'];
			$explVl		= explode(".",$fileName);
			$filePathName='';
			$firstFile	= './uploads/mail_temp/'.$explVl[0].'.html';
			$tempFile	= './uploads/mail_temp/'.$explVl[0].'/'.$explVl[0].'.html';
			if(file_exists($firstFile)){
				$message=file_get_contents($firstFile);
				$this->load->library('email_lib');
				$filePathName=$firstFile;
				//$this->email_lib->send_email('dev2@team365.io','test subjects',$message);
			}else if(file_exists($tempFile)){
				$message=file_get_contents($tempFile);
				$filePathName=$tempFile;
				$this->load->library('email_lib');
				//$this->email_lib->send_email('dev2@team365.io','test subjects',$message);
			}
			
		}
				
		$data 	= $dirpath.$uploadedFile;
		$handle = fopen($data, "r");
		$test 	= file_get_contents($data);
		$session_comp_email = $this->session->userdata('company_email');
		if ($handle) {
			$counter = 0;
			$sql ="INSERT INTO email_from_csv(session_comp_email,eamil,full_name,csv_file_name,path_name,template_name) VALUES ";
			while(($line = fgets($handle)) !== false) {
				//echo $line=str_replace(",","','",$line);
				if($counter>0){
					$sql .= "('".$session_comp_email."','".$line."','".$uploadedFile."','".$dirpath."','".$filePathName."'),";
				}
			  $counter++;
			}
			//mysql_connect 
			$sql = substr($sql, 0, strlen($sql) - 1);
				if ($conn->query($sql) === TRUE) {
					$conn->close();
				}else {
					
				}
			
			fclose($handle);
			
			echo json_encode(array('status'=>true));
			
			
		}else{
			echo json_encode(array('st'=>false));
		} 
		
		
		
	}
  
  
  public function send_mail_using_csv()
   {
    if(!empty($this->session->userdata('email')))
    { 
       if(checkModuleForContr('Email Marketing')<1){
	    redirect('home');
	    exit;
   	    } 
	  $data['orgdata']= $this->Marketing_model->getOrgData();
	  $data['custype']= $this->Marketing_model->cusr_type();
	  
      $this->load->view('email_marketing/send-mail-using-csv',$data);
      
      
    }
    else
    {
      redirect('login');
    }
  }
  
  
  
  
   public function sent_email()
   {
    if(!empty($this->session->userdata('email')))
    { 
	  if(checkModuleForContr('Email Marketing')<1){
	    redirect('home');
	    exit;
   	    } 
      $this->load->view('email_marketing/sent_email_list');
    }
    else
    {
      redirect('login');
    }
  }
  
  
   public function sent_email_list()
   {
       
    $list = $this->Marketing_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    $dataAct=$this->input->post('actDate');
    $checkall=$this->input->post('checkall');
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
     /* if($checkall=='checkedall'){
        $row[] = '<input type="checkbox" id="ck'.$no.'" onchange="checkEmail('.$no.')" checked class="select_checkbox" name="emailid[]" value="'.$post->client_email.'">';
      }else{
        $row[] = '<input type="checkbox" id="ck'.$no.'" onchange="checkEmail('.$no.')" class="select_checkbox" name="emailid[]" value="'.$post->client_email.'">';
      }*/
      $first_row = "";
      $first_row = "";
      $row[] = $post->client_name;
      $row[] = $post->client_email;
      $row[] = $post->subject;
      
      if($post->read_status==1){
          $status='<span class="badge badge-success">Mail Delivered</span>';
      }else{
          $status='<span class="badge badge-danger">Pending</span>';
      }
      $row[] = $status;
      $date=date_create($post->currentdate);
      //date_format($date,"d M Y H:i");
      $row[] = date_format($date,"d M Y ,  H:i");
      $row[] = '<a href="'.base_url().'view-email/'.$post->id.'"><i class="far fa-eye" style="color:green;"></i></a>';
      
      
	 /* $row[]='<select class="selectpicker form-control"  onchange="email_auto('.$post->id.')">
     <option value="0" selected="selected">Select Type</option>
     <option value="'.$post->id.'">Send Email</option>
     <option value="'.$post->id.'">Send Message</option>
     <option value="'.$post->id.'">Remove</option>
     </select>';*/
      $data[] =$row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Marketing_model->count_all(),
      "recordsFiltered" => $this->Marketing_model->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  
       
   }
  
  
  public function view_email(){
      if(checkModuleForContr('Email Marketing')<1){
	    redirect('home');
	    exit;
   	    } 
      $product_id = $this->uri->segment(2);
      $data['emailOne']=$this->Marketing_model->getemail($product_id);
      $this->load->view('email_marketing/view_email',$data);
  }
  
  public function update_status(){
      $gid=$_GET['email'];
      $this->Marketing_model->update_status($gid);
  }
  
  
public function mail_using_csv()
{
	  $this->load->library('csvimport');
	  $unsubArr=array();
	  $allData=$this->Marketing_model->getunsubscribemail();
	  
	  for($i=0; $i<count($allData); $i++){
	      $unsubArr[]=$allData[$i]['client_email'];
	  }
	  
	  
    if(isset($_FILES["csvfile"]["name"]))
    {
        
      $duplicate_array = array();
	  $message_array = array();
	  
	  $file_data = $this->csvimport->get_array($_FILES["csvfile"]["tmp_name"]);

		foreach($file_data as $row)
		{
			$row['Email'];
			$row['First name'];
			$row['Last name'];
			//$row['Age'];
			
			if (!in_array($row['Email'], $unsubArr)){
			    
			$clientname	 = $row['First name']."  ".$row['Last name'];
			$clientEmail = $row['Email'];
			//$ccEmail	 = $this->input->post('ccEmail');
			$subEmail 	 = $this->input->post('csv_subject');
			$descriptionTxt= $this->input->post('csv_description');
			$img_file      = $_FILES["scv_image"]['name'];
			$uploadedFile='';
			if($img_file!=""){ 
				$dirpath = './assets/email_file_img/';
				$config['upload_path']   = './assets/email_file_img/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				 //$config['max_size']      = 2097152;
				$img_file = time()."_".str_replace(' ','_',$_FILES["scv_image"]['name']);
				$config['file_name'] = $img_file;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('scv_image');
				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData['file_name'];
			}
   
		  $data=array(
			'sess_eml'          => $this->session->userdata('email'),
			'session_company'   => $this->session->userdata('company_name'),
			'session_comp_email'=> $this->session->userdata('company_email'),
			'client_name'       => $clientname,
			'client_email'      => $clientEmail,
			//'email_cc'          => $ccEmail,
			'subject'           => $subEmail,
			'message'           => $descriptionTxt,
			'images'            => $uploadedFile,
			'currentdate'       => date('Y-m-d H:i:s')
		 );
		 
		 $company=base64_encode($this->session->userdata('company_name'));
		 $company_email=base64_encode($this->session->userdata('company_email'));
		 $user_email=base64_encode($clientEmail);
		 
		$unscribeUrl= 
		$result = $this->Marketing_model->create_automation_email($data);
		$subjectLine=$subEmail;
		$output='<div class="f-fallback">
					<h3>Hi,'.$clientname.'</h3>
					<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
						<tr>
							<td class="attributes_content">
								<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
									<tr>
										<td class="attributes_item">
											<span class="f-fallback">
										      '.$descriptionTxt.'
											</span>
										</td>
								    </tr>
									<tr>
										<td class="attributes_item">
											<span class="f-fallback">';
											if($uploadedFile!=""){
												$output.='<img src="'.base_url().'assets/email_file_img/'.$uploadedFile.'" style="margin-left:15px;float:right;">';
											}
											$output.='</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
						<tr>
							<td class="attributes_content">
							<a href="'.base_url().'unsubscribe?eml='.$user_email.'&ceml='.$company_email.'&cmn='.$company.'">Unsubscribe</a>
							</td>
						</tr>
					</table>	
				</div>';
		 $output.='<img alt="" src="http://allegient.team365.io/Email_Marketing/update_status?email='.$result.'" style="width: 1px; height: 1px; display: none;" />';
		 sendMailWithTemp($clientEmail,$output,$subjectLine);
		}
		}
		
        
	   echo json_encode(array('status'=>1));
    } 
  }
  
  
  
   public function ajax_list()
   {
    $list = $this->Organization->get_datatables();
    $data = array();
    $no = $_POST['start'];
    $dataAct=$this->input->post('actDate');
    $checkall=$this->input->post('checkall');
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      if($checkall=='checkedall'){
        $row[] = '<input type="checkbox" id="ck'.$no.'" onchange="checkEmail('.$no.')" checked class="select_checkbox" name="emailid[]" value="'.$post->email.'">';
      }else{
        $row[] = '<input type="checkbox" id="ck'.$no.'" onchange="checkEmail('.$no.')" class="select_checkbox" name="emailid[]" value="'.$post->email.'">';
      }
      $first_row = "";
      $first_row = "";
      $row[] = $post->primary_contact;
      $row[] = $post->email;
      $row[] = $post->mobile;
      $row[] = $post->org_name;
	  
	  $action='<div class="row text-center" style="font-size: 15px;">';
		if($this->session->userdata('type')=='admin'){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onClick="email_auto('.$post->id.')" class="text-primary"><i class="far fa-envelope text-info m-1" data-toggle="tooltip" data-container="body" title="Send Email" ></i></a>';
		}
		$action.='</div>';
           
		$row[]=$action;
	  
	 
	 
      $data[] =$row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Organization->count_all(),
      "recordsFiltered" => $this->Organization->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
   public function getbyId($id)
   {
    $data = $this->Marketing_model->get_by_id($id);  
    echo json_encode($data);
   }
   public function send_email()
    {
			
	  $clientname	 = $this->input->post('clientname');
	  $clientEmail	 = $this->input->post('clientEmail');
	  $ccEmail		 = $this->input->post('ccEmail');
	  $subEmail		 = $this->input->post('subEmail');
	  $descriptionTxt= $this->input->post('descriptionTxt');
	  $img_file      = $_FILES["images"]['name'];
	  $uploadedFile='';
	 if($img_file!=""){ 
    	 $dirpath = './assets/email_file_img/';
    	 $config['upload_path']   = './assets/email_file_img/';
         $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
    	 //$config['max_size']      = 2097152;
    	 $img_file = time()."_".str_replace(' ','_',$_FILES["images"]['name']);
    	 $config['file_name'] = $img_file;
    	 $this->load->library('upload', $config);
    	 $this->upload->initialize($config);
    	 $this->upload->do_upload('images');
    	 $uploadData = $this->upload->data();
    	 $uploadedFile = $uploadData['file_name'];
	 }
   
      $data=array(
	   'sess_eml'          => $this->session->userdata('email'),
       'session_company'   => $this->session->userdata('company_name'),
       'session_comp_email'=> $this->session->userdata('company_email'),
	   'client_name'       => $clientname,
	   'client_email'      => $clientEmail,
	   'email_cc'          => $ccEmail,
	   'subject'           => $subEmail,
	   'message'           => $descriptionTxt,
	   'images'            => $uploadedFile,
	   'currentdate'       => date('Y-m-d H:i:s')
	 );
    $result = $this->Marketing_model->create_automation_email($data);
	
  $subject=$subEmail;
  $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                <a href="https://team365.io/" class="f-fallback email-masthead_name">
                <img src="https://team365.io/assets/img/new-logo-team.png"></a>
              </a>
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
                        <h3>Dear,'.$clientname.'</h3>
                        <!-- Action -->
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Name: </strong>'.$clientname.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Email: </strong>'.$clientEmail.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
								   <strong>Message: </strong>'.$descriptionTxt.'
									</span>
                                  </td>
                                </tr>
								 <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">';
                                    if($uploadedFile!=""){
								        $output.='<img src="'.base_url().'assets/email_file_img/'.$uploadedFile.'" style="margin-left:15px;float:right;">';
                                    }
									$output.='</span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </div>
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
 $output.='<img alt="" src="http://allegient.team365.io/Email_Marketing/update_status?email='.$result.'" style="width: 1px; height: 1px; display: none;" />';
    	    
    $my_mail_id = $this->db->insert_id();
	$resultMl = $this->email_lib->send_email($clientEmail,$subject,$output,$ccEmail);
	if($resultMl)
    {
		$this->Marketing_model->update_status($my_mail_id);
      	echo json_encode(array('status'=>1));
    }else{
		echo json_encode(array('status'=>2));
	}
  }
 ######################################### 
  // All Select..
 ######################################### 
  public function all_email_send()
  {
     
		$multi_subject		= $this->input->post('multi_subject');
	    $multi_description  = $this->input->post('multi_description');
	    $all_email          = $this->input->post('all_email');
	    $custType           = $this->input->post('custType');
	    
	    $attachment         = $_FILES['multi_image']['name'];
	    if($attachment!=""){
    		$multi_img_file         =$_FILES["multi_image"]['name'];
    		$dirpath                = './assets/email_file_img/';
    		$config['upload_path']  = './assets/email_file_img/';
            $config['allowed_types']= 'gif|jpg|png|jpeg|pdf';
    	//	$config['max_size']     = 2097152;
    		$multi_img_file = time()."_".str_replace(' ','_',$_FILES["multi_image"]['name']);
    		$config['file_name'] = $multi_img_file;
    		$this->load->library('upload', $config);
    		$this->upload->initialize($config);
    		$this->upload->do_upload('multi_image');
    		//$error = array('error' => $this->upload->display_errors());
    	
    		$uploadDatas = $this->upload->data();
    		$uploadedFiles = $uploadDatas['file_name'];
	    }else{
	        $uploadedFiles='';
	    }

       $subject=$multi_subject;
       $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
			<span></span>
			  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
				  <td class="email-masthead" align="center">
					<a href="https://team365.io/" class="f-fallback email-masthead_name">
					<img src="https://team365.io/assets/img/new-logo-team.png"></a>
				  </a>
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
							<!-- Action -->
							<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
									  <td class="attributes_item">';
									  if($this->input->post('multi_description')){
									    $output.= $this->input->post('multi_description');
									  }
										$output.= '
									  </td>
									</tr>
									 <tr>
									  <td class="attributes_item">
										<span class="f-fallback">';
										if($uploadedFiles){
									        $output.= '<img src="'.base_url().'assets/email_file_img/'.$uploadedFiles.'" style="margin-left:15px;float:right;">';
										}
									$output.='</span>
									  </td>
									</tr>
								  </table>
								</td>
							  </tr>
							</table>
						  </div>
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
	
$results='';
	if($this->input->post('all_email')=='allemail'){
	    $all_un_email=$this->input->post('all_email');
	    $explDatanotSel=explode(",",$all_un_email);
	        $allemail = $this->Marketing_model->multiple_emailValue($custType);
	        $session_comp_email = $this->session->userdata('company_email');
    	foreach($allemail as $sendemail)
    	{	if (!in_array($sendemail['email'], $explDatanotSel)) {
    	      
    	       $data=array(
            	   'sess_eml'          => $this->session->userdata('email'),
                   'session_company'   => $this->session->userdata('company_name'),
                   'session_comp_email'=> $this->session->userdata('company_email'),
            	   'client_name'       => $sendemail['email'],
            	   'client_email'      => $sendemail['email'],
            	   'email_cc'          => $session_comp_email,
            	   'subject'           => $subject,
            	   'message'           => $this->input->post('multi_description'),
            	   'images'            => $uploadedFiles,
            	   'currentdate'       => date('Y-m-d H:i:s')
            	 );
    $result = $this->Marketing_model->create_automation_email($data);
	
    	    $output.='<img alt="" src="http://allegient.team365.io/Email_Marketing/update_status?email='.$result.'" style="width: 1px; height: 1px; display: none;" />';
    	    $results=$this->email_lib->send_email($sendemail['email'],$subject,$output);
    	    }
    	}
    	
	    
    	$results=$this->email_lib->send_email($session_comp_email,$subject,$output);
	}else{
	    	$session_comp_email = $this->session->userdata('company_email');
	    $emailSelected=$this->input->post('all_email');
	    $explData=explode(",",$emailSelected);
	    for($i=0; $i<count($explData); $i++)
    	{ 
    	     $data=array(
            	   'sess_eml'          => $this->session->userdata('email'),
                   'session_company'   => $this->session->userdata('company_name'),
                   'session_comp_email'=> $this->session->userdata('company_email'),
            	   'client_email'      => $explData[$i],
            	   'email_cc'          => $session_comp_email,
            	   'subject'           => $subject,
            	   'message'           => $this->input->post('multi_description'),
            	   'images'            => $uploadedFiles,
            	   'currentdate'       => date('Y-m-d H:i:s')
            	 );
    $result = $this->Marketing_model->create_automation_email($data);
	
    	    $output.='<img alt="" src="http://allegient.servicestodays.com/Email_Marketing/update_status?email='.$result.'" style="width: 1px; height: 1px; display: none;" />';
    	    $results=$this->email_lib->send_email($explData[$i],$subject,$output);
    	}
    
    	$results=$this->email_lib->send_email($session_comp_email,$subject,$output);
	   
	}
	
	//$results=$this->email_lib->send_email('dev3@team365.io',$subject,$output);
	if($results)
    {
		echo json_encode(array('status'=>1));
    }else{
		echo json_encode(array('status'=>2));
	//}
   }
  }
  
  
  
  
  public function preview_email(){
	  
	if($this->input->post('multi_description')){
		$descriptionTxt= $this->input->post('multi_description');
	}else if($this->input->post('csv_description')){
		$descriptionTxt= $this->input->post('csv_description');
	}else{
		$descriptionTxt='According to instructions, you need to load the Upload library. Edit your question with the relevant server-side code. According to instructions, you need to load the Upload library. Edit your question with the relevant server-side code.';
	}
	  
	  //$subject=$multi_subject;
       $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
			<span></span>
			  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
				  <td class="email-masthead" align="center">
					<a href="https://team365.io/" class="f-fallback email-masthead_name">
					<img src="https://team365.io/assets/img/new-logo-team.png"></a>
				  </a>
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
							<!-- Action -->
							<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
									  <td class="attributes_item">';
									 
									    $output.= $descriptionTxt;
									  
										$output.= '
									  </td>
									</tr>
									 <tr>
									  <td class="attributes_item">
										<span class="f-fallback">';
										$attachment=$this->input->post('blah');
										
										if($attachment){
									        $output.= '<img src="'.$attachment.'" style="margin-left:15px;float:right;">';
										}
									$output.='</span>
									  </td>
									</tr>
								  </table>
								</td>
							  </tr>
							</table>
						  </div>
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
		
		
		echo $output;
	
  }
  
  
 ############################### 
		//Export Data
 ###############################
  public function email_export_csv()
  { 
	// file name 
	
	
	$filename = 'emails.csv'; 
	
	$csv_file = fopen('php://output', 'w');
	
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename="'.$filename.'"');
   // get data 
   
	$results = $this->Marketing_model->getemailcsv_details();
	//print_r($results);die;
	//echo "hello";die;
  // The column headings of your .csv file
	$header_row = array("primary_contact","email","mobile","org_name");
	fputcsv($csv_file,$header_row,',','"');
	foreach($results as $result)
	{
		// Array indexes correspond to the field names in your db table(s)
		$row = array(
			$result['primary_contact'],
			$result['email'],
			$result['mobile'],
			$result['org_name']
		);
		
		fputcsv($csv_file,$row,',','"');
	}
	fclose($csv_file);
  }
 }
?>
