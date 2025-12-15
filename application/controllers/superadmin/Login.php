<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('superadmin/login_model','login_model');
    $this->load->model('Country_model','Country');
	// $this->load->library('Ajax_pagination');
	$this->load->library(array('upload','email_lib'));
	
  }
	public function index()
	{
		$this->load->view('superadmin/login');
	}
	public function sign_up()
    {
        $this->load->view('users/signup');
    }
    public function checkemail()
    {
      if($this->login_model->checkemail($_POST['admin_email']))
      {
        echo '<i class="fa fa-times-circle" style="margin-right:7px;" aria-hidden="true"></i>Duplicate Entry';
        echo "<script>$('#accept').prop('disabled',true);</script>";
      }
      else
      {
        echo "<script>$('#accept').prop('disabled',false);</script>";
      }
    }
    public function checkmobile()
    {
      if($this->login_model->checkmobile($_POST['admin_mobile']))
      {
        echo '<i class="fa fa-times-circle" aria-hidden="true" tyle="margin-right:7px;"></i>Duplicate Entry';
        echo "<script>$('#accept').prop('disabled',true);</script>";
      }
      else
      {
        echo "<script>$('#accept').prop('disabled',false);</script>";
      }
    }
	public function register()
	{
		if($this->input->post('register_user'))
		{
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('first_name', 'First name', 'trim|required'); 
			$this->form_validation->set_rules('last_name', 'Last name', 'trim|required'); 
			$this->form_validation->set_rules('admin_email', 'Emailid', 'trim|required|valid_email'); 
			$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required'); 
			$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]|max_length[40]'); 
			if($this->form_validation->run() == true)
			{
				$admin_name = $this->input->post('first_name')." ".$this->input->post('last_name');
				$admin_email = $this->input->post('admin_email');
				$admin_mobile = $this->input->post('admin_mobile');
				$admin_password = md5($this->input->post('admin_password'));
				$company_email = $this->input->post('admin_email');
				
				$type = "superadmin";
				$active = false;
				//generate simple random code
				$set = '1234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				$id = $this->login_model->register($admin_name,$admin_email,$admin_mobile,$admin_password,$company_email,
				$type,$active,$activation_code);
				
				//send activation code in mobile
				$curl = curl_init();
				$url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/".$admin_mobile."/".$activation_code;
				  curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_POSTFIELDS => "",
					CURLOPT_HTTPHEADER => array(
					  "content-type: application/x-www-form-urlencoded"
					),
				  ));

				  $response = curl_exec($curl);
				  $err = curl_error($curl);

				  curl_close($curl);

				  if ($err) {
					echo "cURL Error #:" . $err;
				  } else {
					echo $response;
				  }
				  
				  
				  $this->load->library('email');
				  $config = array(
				  'protocol'    => 'smtp',
				  'smtp_host'   => 'smtp.office365.com',
				  'smtp_port'   => 587,
				  'smtp_crypto' => 'tls',
				  'smtp_user'   => 'no-reply@team365.io', // change it to yours
				  'smtp_pass'   => 'Wos13185', // change it to yours
				  'mailtype'    => 'html',
				  'wordwrap'    => TRUE,
				  'crlf'        => "\r",
				  'newline'     => "\n",
				  'charset'     => "utf-8",
				  'wordwrap'    => TRUE
				 );
			  
			  $this->email->initialize($config);
			  $this->email->set_crlf("\r\n");
			  $this->email->set_newline("\r\n");
			  $this->email->from($config['smtp_user']);
			  $this->email->to($admin_email);
			  $this->email->subject('OTP - '.$activation_code.' from team365');
			  $this->email->set_mailtype('html');
			  $output='';
			  
			  $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style="background: linear-gradient(#0170d2, #0170d2); height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://allegient.team365.io/assets/images/logo.png" style="marging:10px; width: 100px; height:60px;"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
							<tr><td colspan="2">Enter the above code when asked to enter OTP to activate your account. If you don`t reconize, you can safely ignore this mail.</td></tr>
							<tr><td>
								<table>
									<tr><td></td></tr>
								</table>
							  </td>
							</tr>
							<tr><td><br></td></tr>
							<tr><th style="text-align:left;">Regards</th></tr>
							<tr><th style="text-align:left;">Team365</th></tr>
							
						</table>
					   </td>
					  </tr>
					  <tr style="background: linear-gradient(#0070d2, #448aff);">
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-2020 team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				  
				$this->email->message($output);
				if($this->email->send())
				{
					echo $this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 7px;"></i>Welcome, Your Registration Successful');
					redirect('superadmin/login/activate_account/'.$id);
				}
			}else{
				
				$this->session->set_flashdata('msg_err','Oops! Something went wrong We had a problem submitting your request. Please try again later');
				redirect(base_url());
			}
		}
	}
	public function activate_account()
	{
		$id =  $this->uri->segment(4);
		$this->load->view('verification/activate_account');
		if($this->input->post('submit'))
		{
		  $activation_code = $this->input->post('activation_code');
		  $active = true;
		  $this->login_model->activate_account($activation_code,$active,$id);
		  $status = $this->login_model->get_account_status($id);
		  if($status == '1')
		  {
			echo $this->session->set_flashdata('msg','Account Activated');
			redirect('superadmin/login');
		  }
		  else
		  {
			echo $this->session->set_flashdata('msg','<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Invalid OTP Code');
			redirect('superadmin/login/activate_account/'.$id);
		  }
		}
	}
	
	
	public function get_password_link()
	{
		$this->load->view('verification/get_password_link');
		if($this->input->post('submit'))
		{
		    $set = '0123456789';
		    $code = substr(str_shuffle($set), 0, 6);
		    $d = strtotime("+1 Hours");
		    $key = date("Y-m-d H:i:s", $d);
		    if($this->input->post('method') == 'Email')
		    {
				$email = $this->input->post('email');
				$data = $this->login_model->get_password_link($email,$code,$key);
				$data2 = $this->login_model->get_u_password_link($email,$code,$key);
				
				  $this->load->library('email');
				  $config = array(
				  'protocol'    => 'smtp',
				  'smtp_host'   => 'smtp.office365.com',
				  'smtp_port'   => 587,
				  'smtp_crypto' => 'tls',
				  'smtp_user'   => 'no-reply@team365.io', // change it to yours
				  'smtp_pass'   => 'Wos13185', // change it to yours
				  'mailtype'    => 'html',
				  'wordwrap'    => TRUE,
				  'crlf'        => "\r",
				  'newline'     => "\n",
				  'charset'     => "utf-8",
				  'wordwrap'    => TRUE
				 );
				 
				  $this->email->initialize($config);
				  $this->email->set_crlf("\r\n");
				  $this->email->set_newline("\r\n");
				  $this->email->from($config['smtp_user']);
				  $this->email->to($email);
				  $this->email->subject('OTP - '.$code.' Reset Password from team365');
				  $this->email->set_mailtype('html');
				 
				 
			   
				if(!empty($data))
				{
					foreach($data as $row)
					{
						
					$output='<!DOCTYPE><html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>Team365 Mail</title>
							<style type="text/css">
							 body {margin: 0; padding: 0; min-width: 100%!important;}
								.content {width: 100%; max-width: 600px;}  
							</style>
						</head>
						<body>
						   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
							<tr style="background: linear-gradient(#0170d2, #0170d2);">
							  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://allegient.team365.io/assets/images/logo.png" style="marging:10px;width: 100px"></td>
							</tr>
							<tr><td>
								<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
								<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$code.'</b></td></tr>
								<tr><td colspan="2"><b>Hi '.$row['admin_name'].',</b></td></tr>
								<tr><td colspan="2"> <p>You recently requested to reset your password for your team365 account. Use the OTP code above to reset it. <strong>This password reset is only valid for the next 60 minutes.</strong></p></td></tr>
								
								<tr><td colspan="2"> <p>If you did not request a password reset, please ignore this email or <a href="https://team365.io/contact" >contact support </a> if you have questions.</p></td></tr>
									
								<tr><td>
									<table>
										<tr><td></td></tr>
									</table>
								  </td>
								</tr>
								<tr><td><br></td></tr>
								<tr><th style="text-align:left;">Regards</th></tr>
								<tr><th style="text-align:left;">Team365</th></tr>
								
							</table>
						   </td>
						  </tr>
						  <tr style="background: linear-gradient(#0070d2, #448aff);">
							<td style="text-align:center;height: 40px; color: aliceblue;"><p style="font-size:14px;">Copyright © 2014-2020 team365. All rights reserved.</p></td>
									</tr>
						</table>
						</body>
					   </html>';
						
					  $this->email->message($output);
					  
					}
				    // sending email
				    if($this->email->send())
				    {
						$this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered email address');
						redirect('superadmin/login/otp_password/'.$row['id']);
				    }else{
						$this->session->set_flashdata('msg', "Something went wrong. Try again in a few minutes");
						redirect('superadmin/login/get_password_link/');
				    }
			    }else if(!empty($data2)){
					foreach($data2 as $row)
					{
						$output='<!DOCTYPE><html>
						<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
							<title>Team365 Mail</title>
							<style type="text/css">
							 body {margin: 0; padding: 0; min-width: 100%!important;}
								.content {width: 100%; max-width: 600px;}  
							</style>
						</head>
						<body>
						   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
							<tr style="background: linear-gradient(#0170d2, #0170d2);">
							  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://allegient.team365.io/assets/images/logo.png" style="marging:10px;width: 100px"></td>
							</tr>
							<tr><td>
								<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
								<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$code.'</b></td></tr>
								<tr><td colspan="2"><b>Hi '.$row['standard_name'].',</b></td></tr>
								<tr><td colspan="2"> <p>You recently requested to reset your password for your team365 account. Use the OTP code above to reset it. <strong>This password reset is only valid for the next 60 minutes.</strong></p></td></tr>
								
								<tr><td colspan="2"> <p>If you did not request a password reset, please ignore this email or <a href="https://team365.io/contact" >contact support </a> if you have questions.</p></td></tr>
									
								<tr><td>
									<table>
										<tr><td></td></tr>
									</table>
								  </td>
								</tr>
								<tr><td><br></td></tr>
								<tr><th style="text-align:left;">Regards</th></tr>
								<tr><th style="text-align:left;">Team365</th></tr>
								
							</table>
						   </td>
						  </tr>
						  <tr style="background: linear-gradient(#0070d2, #448aff);">
							<td style="text-align:center;height: 40px; color: aliceblue;"><p style="font-size:14px;">Copyright © 2014-2020 team365. All rights reserved.</p></td>
						  </tr>
						</table>
						</body>
					   </html>';
					  $this->email->message($output);
					  
					}
					// sending email
					if($this->email->send())
				    {
						$this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered email address');
						redirect('superadmin/login/otp_password/'.$row['id']);
				    }else{
						$this->session->set_flashdata('msg', "Something went wrong. Try again in a few minutes");
						redirect('superadmin/login/get_password_link/');
				    }
				}else{
					$this->session->set_flashdata('msg','Please enter registered email address');
					redirect('superadmin/login/get_password_link/');
				}
			}elseif($this->input->post('method') == 'Phone')
			{
				$mobile = $this->input->post('mobile');
				$data_m = $this->login_model->get_password_link_mobile($mobile,$code,$key);
				$data_m2 = $this->login_model->get_u_password_link_mobile($mobile,$code,$key);
				if(!empty($data_m) || !empty($data_m2))
				{
					$curl = curl_init();
					$url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/".$mobile."/".$code;
					curl_setopt_array($curl, array(
						CURLOPT_URL => $url,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "GET",
						CURLOPT_POSTFIELDS => "",
						CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded"),
						)
					);

					$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);

					if ($err) {
						echo "cURL Error #:" . $err;
					}else{
						echo $response;
						if(!empty($data_m))
						{
							foreach($data_m as $row)
							{
								$this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered mobile number');
								redirect('superadmin/login/otp_password/'.$row['id']);
							}
						}else if(!empty($data_m2))
						{
							foreach($data_m2 as $row)
							{
								$this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered mobile number');
								redirect('superadmin/login/otp_password/'.$row['id']);
							}
						}
					}
				}else{
					$this->session->set_flashdata('msg','Please enter registered mobile number');
					redirect('superadmin/login/get_password_link/');
				}
			}
		}
	}
	public function otp_password()
	{
    $this->load->view('verification/enter_otp_new');
	  $id =  $this->uri->segment(3);
	  if($this->input->post('submit'))
	  {
	    $password_key = $this->input->post('otp');
	    $data = $this->login_model->match_otp($id,$password_key);
	    $data2 = $this->login_model->match_otp_u($id,$password_key);
	    if(!empty($data))
	    {
	       redirect('superadmin/login/reset_password/'.$id);
	    }
	    else
	    {
	       $this->session->set_flashdata('msg','<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i> Enter valid OTP');
           redirect('superadmin/login/otp_password/'.$id);
	    }
	    if(!empty($data2))
	    {
	       redirect('superadmin/login/reset_password/'.$id);
	    }
	    else
	    {
	       $this->session->set_flashdata('msg','<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i> Enter valid OTP');
           redirect('superadmin/login/otp_password/'.$id);
	    }
	  }
	}
	public function reset_password()
	{
    $id = $this->uri->segment(3);
    $data['user'] = $this->login_model->get_password_link1($id);
    $data['user1'] = $this->login_model->get_u_password_link1($id);

    $this->load->view('verification/reset_password_new',$data);
    if($this->input->post('update'))
    {
      $password = md5($this->input->post('c_password'));
      $data = $this->login_model->reset_password($password,$id);
      $data2 = $this->login_model->reset_u_password($password,$id);
      $this->session->set_flashdata('msg','<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>Password Changed Successfully');
      redirect('superadmin/login');
    }
	}
  public function auth()
  {
    if($this->input->post('log_in'))
    {
      $email = $this->input->post('email',TRUE);
      $password = md5($this->input->post('password',TRUE));
      $validate = $this->login_model->validate_admin($email,$password);

      //$validate2 = $this->login_model->validate_user($email,$password);
      if($validate->num_rows() > 0)
      {
         $data = $validate->row_array();//die;
        $id = $data['id'];
        $name = $data['admin_name'];
        $email = $data['admin_email'];
        $mobile = $data['admin_mobile'];
        $type = $data['type'];
        $active = $data['active'];
        $company_name = $data['company_name'];
        $country = $data['country'];
        $state = $data['state'];
        $city = $data['city'];
        $company_address = $data['company_address'];
        $zipcode = $data['zipcode'];
        $company_mobile = $data['company_mobile'];
        $company_email = $data['company_email'];
        $company_website = $data['company_website'];
        $company_gstin = $data['company_gstin'];
        $pan_number = $data['pan_number'];
        $cin = $data['cin'];
        $company_logo = $data['company_logo'];
        $terms_condition_customer = $data['terms_condition_customer'];
        $terms_condition_seller = $data['terms_condition_seller'];
        $license_activation_date = $data['license_activation_date'];
        $license_expiration_date = $data['license_expiration_date'];
        $trial_end_date = $data['trial_end_date'];
        $license_type = $data['license_type'];
        $account_type = $data['account_type'];
        $basic_lic_amnt = $data['basic_lic_amnt'];
        $business_lic_amnt = $data['business_lic_amnt'];
        $enterprise_lic_amnt = $data['enterprise_lic_amnt'];
        $partner_name = $data['partner_name'];
        $license_duration = $data['license_duration'];
        $create_user = $data['create_user'];
        $retrieve_user = $data['retrieve_user'];
        $update_user = $data['update_user'];
        $delete_user = $data['delete_user'];
        $create_org = $data['create_org'];
        $retrieve_org = $data['retrieve_org'];
        $update_org = $data['update_org'];
        $delete_org = $data['delete_org'];
        $create_contact = $data['create_contact'];
        $retrieve_contact = $data['retrieve_contact'];
        $update_contact = $data['update_contact'];
        $delete_contact = $data['delete_contact'];
        $create_lead = $data['create_lead'];
        $retrieve_lead = $data['retrieve_lead'];
        $update_lead = $data['update_lead'];
        $delete_lead = $data['delete_lead'];
        $create_opp = $data['create_opp'];
        $retrieve_opp = $data['retrieve_opp'];
        $update_opp = $data['update_opp'];
        $delete_opp = $data['delete_opp'];
        $create_quote = $data['create_quote'];
        $retrieve_quote = $data['retrieve_quote'];
        $update_quote = $data['update_quote'];
        $delete_quote = $data['delete_quote'];
        $create_so = $data['create_so'];
        $retrieve_so = $data['retrieve_so'];
        $update_so = $data['update_so'];
        $delete_so = $data['delete_so'];
        $create_vendor = $data['create_vendor'];
        $retrieve_vendor = $data['retrieve_vendor'];
        $update_vendor = $data['update_vendor'];
        $delete_vendor = $data['delete_vendor'];
        $create_product = $data['create_product'];
        $retrieve_product = $data['retrieve_product'];
        $update_product = $data['update_product'];
        $delete_product = $data['delete_product'];
        $create_po = $data['create_po'];
        $retrieve_po = $data['retrieve_po'];
        $update_po = $data['update_po'];
        $delete_po = $data['delete_po'];
        $create_inv = $data['create_inv'];
        $retrieve_inv = $data['retrieve_inv'];
        $update_inv = $data['update_inv'];
        $delete_inv = $data['delete_inv'];
        $user_image = $data['user_image'];
        $login_count = $data['login_count'];
        $created_date = $data['created_date'];
        $sesdata = array(
          'superadmin_id' => $id,
          'superadmin_name' => $name,
          'superadmin_email' => $email,
          'superadmin_mobile' => $mobile,
          'types' => $type,
          'active' => $active,
          'supercompany_name' => $company_name,
          'superadmin_country' => $country,
          'superadmin_state' => $state,
          'superadmin_city' => $city,
          'supercompany_address' => $company_address,
          'superadmin_zipcode' => $zipcode,
          'supercompany_mobile' => $company_mobile,
          'supercompany_email' => $company_email,
          'supercompany_website' => $company_website,
          'supercompany_gstin' => $company_gstin,
          'superpan_number' => $pan_number,
          'superadmin_cin' => $cin,
          'supercompany_logo' => $company_logo,
          'superterms_condition_customer' => $terms_condition_customer,
          'superterms_condition_seller' => $terms_condition_seller,
          'superlicense_activation_date' => $license_activation_date,
          'superlicense_expiration_date' => $license_expiration_date,
          'supertrial_end_date' => $trial_end_date,
          'superlicense_type' => $license_type,
          'superaccount_type' => $account_type,
          'superbasic_lic_amnt' => $basic_lic_amnt,
          'superbusiness_lic_amnt' => $business_lic_amnt,
          'superenterprise_lic_amnt' => $enterprise_lic_amnt,
          'superpartner_name' => $partner_name,
          'superlicense_duration' => $license_duration,
          'supercreate_user' => $create_user,
          'retrieve_user' => $retrieve_user,
          'update_user' => $update_user,
          'delete_user' => $delete_user,
          'create_org' => $create_org,
          'superretrieve_org' => $retrieve_org,
          'update_org' => $update_org,
          'delete_org' => $delete_org,
          'create_contact' => $create_contact,
          'retrieve_contact' => $retrieve_contact,
          'update_contact' => $update_contact,
          'delete_contact' => $delete_contact,
          'create_lead' => $create_lead,
          'retrieve_lead' => $retrieve_lead,
          'update_lead' => $update_lead,
          'delete_lead' => $delete_lead,
          'create_opp' => $create_opp,
          'retrieve_opp' => $retrieve_opp,
          'update_opp' => $update_opp,
          'delete_opp' => $delete_opp,
          'create_quote' => $create_quote,
          'retrieve_quote' => $retrieve_quote,
          'update_quote' => $update_quote,
          'delete_quote' => $delete_quote,
          'create_so' => $create_so,
          'retrieve_so' => $retrieve_so,
          'update_so' => $update_so,
          'delete_so' => $delete_so,
          'create_vendor' => $create_vendor,
          'retrieve_vendor' => $retrieve_vendor,
          'update_vendor' => $update_vendor,
          'delete_vendor' => $delete_vendor,
          'create_product' => $create_product,
          'retrieve_product' => $retrieve_product,
          'update_product' => $update_product,
          'delete_product' => $delete_product,
          'create_po' => $create_po,
          'retrieve_po' => $retrieve_po,
          'update_po' => $update_po,
          'delete_po' => $delete_po,
          'create_inv' => $create_inv,
          'retrieve_inv' => $retrieve_inv,
          'update_inv' => $update_inv,
          'delete_inv' => $delete_inv,
          'user_image' => $user_image,
          'supeerlogin_count' => $login_count,
          'opp_notify' => 1,
          'supercreated_date' => $created_date,
          'loggedsuperadmin_in' => TRUE
        );
        
        $this->session->set_userdata($sesdata);
        if($type === 'superadmin')
        {
          if($active == true)
          {
            if(!empty($company_address))
            {
              $table = 'admin_users';
              $result = $this->login_model->update_login_count($table,$name,$email,$company_name,$login_count);
              redirect('superadmin/home');
            }
            else
            {
              redirect('superadmin/login/add_company_details');
            }
          }
          else
          {
			  
			    $type = "superadmin";
				$active = false;
				//generate simple random code
				$set = '01234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				
				
		    $d = strtotime("+1 Hours");
		    $key = date("Y-m-d H:i:s", $d);
		    $data2 = $this->login_model->updateOtpCode($email,$activation_code,$key);
				
				
				
				$curl = curl_init();
				$url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/".$mobile."/".$activation_code;
				  curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_POSTFIELDS => "",
					CURLOPT_HTTPHEADER => array(
					  "content-type: application/x-www-form-urlencoded"
					),
				  ));

				  $response = curl_exec($curl);
				  $err = curl_error($curl);

				  curl_close($curl);

				  if ($err) {
					echo "cURL Error #:" . $err;
				  } else {
					echo $response;
				  }
				  
				  
				 /* $this->load->library('email');
				  $config = array(
				  'protocol'    => 'smtp',
				  'smtp_host'   => 'smtp.office365.com',
				  'smtp_port'   => 587,
				  'smtp_crypto' => 'tls',
				  'smtp_user'   => 'no-reply@team365.io', // change it to yours
				  'smtp_pass'   => 'Wos13185', // change it to yours
				  'mailtype'    => 'html',
				  'wordwrap'    => TRUE,
				  'crlf'        => "\r",
				  'newline'     => "\n",
				  'charset'     => "utf-8",
				  'wordwrap'    => TRUE
				 );
			  
			  $this->email->initialize($config);
			  $this->email->set_crlf("\r\n");
			  $this->email->set_newline("\r\n");
			  $this->email->from($config['smtp_user']);
			  $this->email->to($email);
			  $this->email->
			  $this->email->set_mailtype('html');*/
			  
			  $subject = 'OTP - '.$activation_code.' from team365';
			  $output='';
			  
			  $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style="background: linear-gradient(#0170d2, #0170d2); height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://allegient.team365.io/assets/images/logo.png" style="marging:10px; width: 100px; height:60px;"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
							<tr><td colspan="2">Enter the above code when asked to enter OTP to activate your account. If you don`t reconize, you can safely ignore this mail.</td></tr>
							<tr><td>
								<table>
									<tr><td></td></tr>
								</table>
							  </td>
							</tr>
							<tr><td><br></td></tr>
							<tr><th style="text-align:left;">Regards</th></tr>
							<tr><th style="text-align:left;">Team365</th></tr>
							
						</table>
					   </td>
					  </tr>
					  <tr style="background: linear-gradient(#0070d2, #448aff);">
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				  
				//$this->email->message($output);
				if($this->email_lib->send_email($email,$subject,$output))
				{
					echo $this->session->set_flashdata('msg','<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Please Activate Your Account');
					redirect('superadmin/login/activate_account/'.$id);
				}
          }
        }
      }
      /*if($validate2->num_rows() > 0)
      {
        $data = $validate2->row_array();
        $id = $data['id'];
        $name = $data['standard_name'];
        $email = $data['standard_email'];
        $mobile = $data['standard_mobile'];
        $type = $data['type'];
        $company_name = $data['company_name'];
        $country = $data['country'];
        $state = $data['state'];
        $city = $data['city'];
        $company_address = $data['company_address'];
        $zipcode = $data['zipcode'];
        $company_mobile = $data['company_mobile'];
        $company_email = $data['company_email'];
        $company_website = $data['company_website'];
        $company_gstin = $data['company_gstin'];
        $pan_number = $data['pan_number'];
        $cin = $data['cin'];
        $company_logo = $data['company_logo'];
        $terms_condition_customer = $data['terms_condition_customer'];
        $terms_condition_seller = $data['terms_condition_seller'];
        $license_activation_date = $data['license_activation_date'];
        $license_expiration_date = $data['license_expiration_date'];
        $license_type = $data['license_type'];
        $account_type = $data['account_type'];
        $partner_name = $data['partner_name'];
        $license_duration = $data['license_duration'];
        $create_user = $data['create_user'];
        $retrieve_user = $data['retrieve_user'];
        $update_user = $data['update_user'];
        $delete_user = $data['delete_user'];
        $create_org = $data['create_org'];
        $retrieve_org = $data['retrieve_org'];
        $update_org = $data['update_org'];
        $delete_org = $data['delete_org'];
        $create_contact = $data['create_contact'];
        $retrieve_contact = $data['retrieve_contact'];
        $update_contact = $data['update_contact'];
        $delete_contact = $data['delete_contact'];
        $create_lead = $data['create_lead'];
        $retrieve_lead = $data['retrieve_lead'];
        $update_lead = $data['update_lead'];
        $delete_lead = $data['delete_lead'];
        $create_opp = $data['create_opp'];
        $retrieve_opp = $data['retrieve_opp'];
        $update_opp = $data['update_opp'];
        $delete_opp = $data['delete_opp'];
        $create_quote = $data['create_quote'];
        $retrieve_quote = $data['retrieve_quote'];
        $update_quote = $data['update_quote'];
        $delete_quote = $data['delete_quote'];
        $create_so = $data['create_so'];
        $retrieve_so = $data['retrieve_so'];
        $update_so = $data['update_so'];
        $delete_so = $data['delete_so'];
        $create_vendor = $data['create_vendor'];
        $retrieve_vendor = $data['retrieve_vendor'];
        $update_vendor = $data['update_vendor'];
        $delete_vendor = $data['delete_vendor'];
        $create_product = $data['create_product'];
        $retrieve_product = $data['retrieve_product'];
        $update_product = $data['update_product'];
        $delete_product = $data['delete_product'];
        $create_po = $data['create_po'];
        $retrieve_po = $data['retrieve_po'];
        $update_po = $data['update_po'];
        $delete_po = $data['delete_po'];
        $create_inv = $data['create_inv'];
        $retrieve_inv = $data['retrieve_inv'];
        $update_inv = $data['update_inv'];
        $delete_inv = $data['delete_inv'];
        $user_image = $data['profile_image'];
        $login_count = $data['login_count'];
        $sales_quota = $data['sales_quota'];
        $profit_quota = $data['profit_quota'];
        $sesdata = array(
          'id' => $id,
          'name' => $name,
          'email' => $email,
          'mobile' => $mobile,
          'type' => $type,
          'company_name' => $company_name,
          'country' => $country,
          'state' => $state,
          'city' => $city,
          'company_address' => $company_address,
          'zipcode' => $zipcode,
          'company_mobile' => $company_mobile,
          'company_email' => $company_email,
          'company_website' => $company_website,
          'company_gstin' => $company_gstin,
          'pan_number' => $pan_number,
          'cin' => $cin,
          'company_logo' => $company_logo,
          'terms_condition_customer' => $terms_condition_customer,
          'terms_condition_seller' => $terms_condition_seller,
          'license_activation_date' => $license_activation_date,
          'license_expiration_date' => $license_expiration_date,
          'license_type' => $license_type,
          'account_type' => $account_type,
          'partner_name' => $partner_name,
          'license_duration' => $license_duration,
          'create_user' => $create_user,
          'retrieve_user' => $retrieve_user,
          'update_user' => $update_user,
          'delete_user' => $delete_user,
          'create_org' => $create_org,
          'retrieve_org' => $retrieve_org,
          'update_org' => $update_org,
          'delete_org' => $delete_org,
          'create_contact' => $create_contact,
          'retrieve_contact' => $retrieve_contact,
          'update_contact' => $update_contact,
          'delete_contact' => $delete_contact,
          'create_lead' => $create_lead,
          'retrieve_lead' => $retrieve_lead,
          'update_lead' => $update_lead,
          'delete_lead' => $delete_lead,
          'create_opp' => $create_opp,
          'retrieve_opp' => $retrieve_opp,
          'update_opp' => $update_opp,
          'delete_opp' => $delete_opp,
          'create_quote' => $create_quote,
          'retrieve_quote' => $retrieve_quote,
          'update_quote' => $update_quote,
          'delete_quote' => $delete_quote,
          'create_so' => $create_so,
          'retrieve_so' => $retrieve_so,
          'update_so' => $update_so,
          'delete_so' => $delete_so,
          'create_vendor' => $create_vendor,
          'retrieve_vendor' => $retrieve_vendor,
          'update_vendor' => $update_vendor,
          'delete_vendor' => $delete_vendor,
          'create_product' => $create_product,
          'retrieve_product' => $retrieve_product,
          'update_product' => $update_product,
          'delete_product' => $delete_product,
          'create_po' => $create_po,
          'retrieve_po' => $retrieve_po,
          'update_po' => $update_po,
          'delete_po' => $delete_po,
          'create_inv' => $create_inv,
          'retrieve_inv' => $retrieve_inv,
          'update_inv' => $update_inv,
          'delete_inv' => $delete_inv,
          'user_image' => $user_image,
          'login_count' => $login_count,
          'opp_notify' => 1,
          'sales_quota' => $sales_quota,
          'profit_quota' => $profit_quota,
          'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);
        if($type === 'standard')
        {
          $table = 'standard_users';
          $result = $this->login_model->update_login_count($table,$name,$email,$company_name);
          redirect('home');
        }
      }*/
      else
      {
        echo $this->session->set_flashdata('msg','<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i>Username or Password is Wrong');
        redirect('superadmin/login');
      }
    }
  }
  public function add_company_details()
  {
    $this->load->view('superadmin/add_company_detail');
    if($this->input->post('add_details'))
    {
      $sess_eml = $this->session->userdata('email');
      $sess_id = $this->session->userdata('id');
      $company_name = $this->input->post('company_name');
      $company_website = $this->input->post('company_website');
      $company_email = $this->input->post('company_email');
      $company_mobile = $this->input->post('company_mobile');
      $pan_number = $this->input->post('pan_number');
      $cin = $this->input->post('cin');
      $company_gstin = $this->input->post('company_gstin');
      $country = $this->input->post('country');
      $state = $this->input->post('state');
      $city = $this->input->post('city');
      $zipcode = $this->input->post('zipcode');
      $company_address = $this->input->post('address');
      $terms_condition_customer = $this->input->post('terms_condition_customer');
      $terms_condition_seller = $this->input->post('terms_condition_seller');
      if($this->login_model->add_company_details($sess_eml,$company_name,$company_website,$company_email,$company_mobile,$pan_number,$cin,
      $company_gstin,$country,$state,$city,$zipcode,$company_address,$terms_condition_customer,$terms_condition_seller))
      {
		  
		  $sesdata = array(
          'company_name' => $company_name,
          'country' => $country,
          'state' => $state,
          'city' => $city,
          'company_address' => $company_address,
          'zipcode' => $zipcode,
          'company_mobile' => $company_mobile,
          'company_email' => $company_email,
          'company_website' => $company_website,
          'company_gstin' => $company_gstin,
          'pan_number' => $pan_number,
          'cin' => $cin,
          'terms_condition_customer' => $terms_condition_customer,
          'terms_condition_seller' => $terms_condition_seller
        );
        
        $this->session->set_userdata($sesdata);
		  
		  
		  
        $this->login_model->addBranch($sess_eml,$sess_id,$company_name,$company_email,$company_mobile,$pan_number,$cin,
        $company_gstin,$country,$state,$city,$zipcode,$company_address);

        $output = "<!DOCTYPE html>
          <html>
          <head>
              <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap' rel='stylesheet'>
              <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css'>
              <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>
              <style>
                  body{
                      font-family: 'Montserrat', sans-serif;
                  }
              </style>
          </head>
          <body>
          <div style='height:100%'>
            <div style='width:80%;margin:0;padding:10%;padding-bottom:0;background-color:#0070d2;height:200px;'>
                <div style='width:100%;background-color:#ffffff;padding:20px'>
                          <div style='marging:10px;width: 100px'>
                              <img src='https://allegient.team365.io/assets/images/logo.png' style='marging:10px;width: 100px'>
                          </div>
                              <center>
                                  <h2>Customer Details Registered For Trial of Team365</h2>
                              </center>
                              <br><br>
                             
                              <table class='table table-bordered'>
                                <thead>
                                  <tr>
                                    <th>Customer Name</th>
                                    <th>Company Name</th>
                                    <th>Company Website</th>
                                    <th>Company Email</th>
                                    <th>Company Mobile</th>
                                    <th>Company Address</th>
                                    <th>Registration Date</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>".ucwords($this->session->userdata('name'))."</td>
                                    <td>".$company_name."</td>
                                    <td>".$company_website."</td>
                                    <td>".$company_email."</td>
                                    <td>".$company_mobile."</td>
                                    <td>".$company_address."</td>
                                    <td>".date('d-m-Y', strtotime($this->session->userdata('created_date')))."</td>
                                  </tr>
                                </tbody>
                              </table>
                          </div>
                      </div>
                    </div>
                  </body>
                </html>";
                
        echo $this->session->set_flashdata('msg','Company Details Added Successfully');
        redirect('superadmin/home');
      }
    }
  }
  public function autocomplete_countries()
  {
    if (isset($_GET['term']))
    {
      $result = $this->Country->get_countries($_GET['term']);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label'	=> $row->name,
        );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label'	=> "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function autocomplete_states()
  {
    if (isset($_GET['term']))
    {
      $result = $this->Country->get_states($_GET['term']);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label'	=> $row->name,
        );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label'	=> "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function autocomplete_cities()
  {
    if (isset($_GET['term']))
    {
      $result = $this->Country->get_cities($_GET['term']);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label'	=> $row->name,
        );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label'	=> "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function logout()
  {
    $this->session->unset_userdata('loggedsuperadmin_in');
    $this->session->unset_userdata('superadmin_email');
    //$this->session->sess_destroy();
    redirect('superadmin/login');
  }
}
?>
