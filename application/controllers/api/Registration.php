<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Registration extends REST_Controller {
    
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
       
//       public function index_post()
//     {
//         $set = '1234567890';
//         $activation_code = substr(str_shuffle($set), 0, 6);
//         $input = $this->input->post();
//         $input['sub_domain'] = $input['sub_domain'];
//         $input['company_email']     = $input['admin_email'];
//         $input['account_type'] 	    = "Trial";
//         $input['trial_end_date']    = date('Y-m-d', strtotime('+1 months'));
//         $input['type']   			= "admin";
//         $input['product_type'] 	    = "CRM";
//         $input['active'] 		    = false;
//         $input['mo_activation_code']  = $activation_code;
      
// 		$this->load->library('form_validation');
			
// 			$this->form_validation->set_rules('admin_name', 'Admin name', 'trim|required'); 
// 			$this->form_validation->set_rules('admin_email', 'Email id', 'trim|required|valid_email|is_unique[admin_users.admin_email]'); 
// 			$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[10]|regex_match[/^[0-9]{10}$/]'); 
// 			$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]');
			
//         if($this->form_validation->run() == true)
// 		{
        
//               $subject = 'OTP - '.$activation_code.' from team365';
// 			  $output='';
			  
// 			  $output .='<!DOCTYPE> <html> <head>
// 						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
// 						<title>Team365 Mail</title>
// 						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
// 					<body>
// 					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
// 						<tr style=" height: 60px;">
// 						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png"></td>
// 						</tr>
// 						<tr><td>
// 							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
// 							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
// 							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
// 							<tr><td colspan="2">Enter the above code when asked to enter OTP to activate your account. If you don`t reconize, you can safely ignore this mail.</td></tr>
// 							<tr><td>
// 								<table>
// 									<tr><td></td></tr>
// 								</table>
// 							  </td>
// 							</tr>
// 							<tr><td><br></td></tr>
// 							<tr><th style="text-align:left;">Regards</th></tr>
// 							<tr><th style="text-align:left;">Team365</th></tr>
							
// 						</table>
// 					   </td>
// 					  </tr>
// 					  <tr style="background: linear-gradient(#0070d2, #448aff);">
// 						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date('Y').' team365. All rights reserved.</td>
// 								</tr>
// 					</table>
// 					</body>
// 				   </html>';
				  
				
// 				$this->email_lib->send_email($this->input->post('admin_email'), $subject, $output);
// 				$this->db->insert('admin_users',$input);
//                 $this->response(['Your user details added successfully.'], REST_Controller::HTTP_OK);
        
//         }else{
//           $error = validation_errors();
//           $this->response([$error], REST_Controller::HTTP_OK);
//         } 
//     }
       
        public function index_post()
	    {
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('admin_name', 'Admin Name', 'trim|required');  
			$this->form_validation->set_rules('admin_email', 'Email Id', 'trim|required'); 
			$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required'); 
			$this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]|max_length[40]'); 
		    $this->form_validation->set_rules('subdomain', 'Sub Domain', 'trim|required');
		    
			if($this->form_validation->run() == true)
			{
			    $id =  $this->uri->segment(3);
				$admin_name = $this->input->post('admin_name');
				$admin_email = $this->input->post('admin_email');
				$admin_mobile = $this->input->post('admin_mobile');
				$admin_password = md5($this->input->post('admin_password'));
				$company_email = $this->input->post('admin_email');
				$yourUrlname = $this->input->post('subdomain');
				$type = "admin";
				$product_type = "CRM";
				$active = false;
				
				$this->db->where( 'sub_domain', $yourUrlname);
				$query = $this->db->get('admin_users');
                $rc = $query->num_rows();
				
				if($rc>=1)
				{
				    $this->response(['This Sub Domain already exist.'],                       REST_Controller::HTTP_OK);
				}
				else
				{
			
				    $date                  = date_create("2022-03-31");
				    $licenseExpirationDate = date_format($date,"Y-m-d");
               
		    
				$data = array(
                  'sub_domain' 		=> $yourUrlname,
                  'admin_name' 		=> $admin_name,
                  'admin_password' 	=> $admin_password,
                  'company_email' 	=> $company_email,
                  'account_type' 	=> "Trial",
                  'trial_end_date' 	=> $licenseExpirationDate,
                  'type' 			=> $type,
                  'product_type' 	=> $product_type,
                  'active' 			=> $active,
                  'your_plan_id'    => 4
                );
                
                
                 $this->db->where('id', $id);
                 $this->db->where('admin_mobile', $admin_mobile);
                 $this->db->where('admin_email', $admin_email);
                 $this->db->update('admin_users',$data);
                 $this->db->trans_complete();        

        			if($this->db->trans_status() === true)
        			{
    			        $current_date 	        = date('Y-m-d h:i:s');
            		    $date 	                = date_create("2021-12-25");
            		    $offerdt                = date_format($date,"Y-m-d");
        			    $input = array(
            	            'admin_id'      => $id,
            	            'sess_eml'      => $admin_email,
            	            'session_company'=> $admin_name,
            	            'session_comp_email'=> $admin_email,
            	            'account_type'  => 'Trial',
            	            'plan_id'       => '4',
            	            'plan_licence' => '10',
            	            'plan_price'    => 0,
            	            'used_licence'  => 0,
            	            'licence_act_date'=> $offerdt,
            	            'licence_exp_date'=> $licenseExpirationDate,
            	            'licence_type'  => 'offer',
            	            'currentdate' => $current_date,
            	            );
    	            $this->db->insert('licence_detail',$input);
                    $this->response(['user_id'=>$id,'message'=>'You are register successfully.'],                       REST_Controller::HTTP_OK);
        			}
        			else
        			{
        			    $this->response(['Something wrong! unable to register.'], REST_Controller::HTTP_OK);
        			}
    				    
			    }
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
		
	}
    
    public function mobile_post()
    {
        $this->load->library('form_validation');
    	$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required'); 
    	
    		if($this->form_validation->run() == true)
			{
				$admin_mobile = $this->input->post('admin_mobile');
				$this->db->where('admin_mobile',$admin_mobile);
				$query = $this->db->get('admin_users');
				$row = $query->result_array();
                $rc = $query->num_rows();
                
    			if($rc>0)
    			{
                    
                    if(empty($row[0]['sub_domain']))
                    {
                        //generate simple random code
    				$set = '1234567890';
    				$activation_code = substr(str_shuffle($set), 0, 6);
    				
    				$data = array(
                      'mo_activation_code' => $activation_code
                    );
                
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
                        if(empty($err))
                        {
                            $this->db->where('admin_mobile', $admin_mobile);
                            $this->db->update('admin_users',$data);
                            $this->response(['user_id'=> $row[0]['id'],'message'=> 'OTP send on your mobile successfully.'],  REST_Controller::HTTP_OK);
                        }
                        else
                        {
                            $this->response(['OTP not send something else.'],                       REST_Controller::HTTP_OK);
                        }
				        curl_close($curl);
                        
                    }
                    else
                    {
                        $this->response(['This mobile no already register  with us.'], REST_Controller::HTTP_OK);
                    }
    			     
    			}
    			else
    			{
    			    
		        //generate simple random code
				$set = '1234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				
				$data = array(
                  'admin_mobile' 	=> $admin_mobile,
                  'mo_activation_code' => $activation_code
                );
                
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
                    if(empty($err))
                    {
                        $this->db->insert('admin_users',$data);
                        $id = $this->db->insert_id();
                        $this->response(['user_id'=> $id,'message'=> 'OTP send on your mobile successfully.'],  REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $this->response(['OTP not send something else.'],                       REST_Controller::HTTP_OK);
                    }
				 
			    }
    		
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
    }
    
    public function mobileOtp_post()
    {
        $id =  $this->uri->segment(4);
        
        $mobile_otp = $this->input->post('mobile_otp');
        $this->db->where('id',$id);
        $this->db->where('mo_activation_code',$mobile_otp);
		$query = $this->db->get('admin_users');
		$row = $query->result_array();
        $rc = $query->num_rows();
        if($rc>0)
        {
              
             $this->response(['user_id'=>$id,'mobile'=>$row[0]['admin_mobile'],'message'=>'Mobile OTP verified successfully.'], REST_Controller::HTTP_OK);
        }
        else
        {
             $this->response(['Please enter valid mobile OTP.'],                       REST_Controller::HTTP_OK);
        }
    }
    
    public function email_post()
    {
        $id =  $this->uri->segment(4);
        $this->load->library('form_validation');
    	$this->form_validation->set_rules('admin_email', 'Email Id', 'trim|required'); 
    	
    		if($this->form_validation->run() == true)
			{
				$admin_email = $this->input->post('admin_email');
				$this->db->where('admin_email',$admin_email);
				$query = $this->db->get('admin_users');
				$row = $query->result_array();
                $rc = $query->num_rows();
    			if($rc>0)
    			{
    			    if(empty($row[0]['sub_domain']))
                    {
                        //generate simple random code
            			$set = '1234567890';
            			$activation_code = substr(str_shuffle($set), 0, 6);
            			
            			$data = array(
                          'activation_code' => $activation_code,
                          'password_key_valid_untill'	=> date('Y-m-d', strtotime('+30 minutes'))
                        );
                        
                         $subject = 'OTP - '.$activation_code.' from team365';
			             $output='';
			  
			  $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style=" height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Mr,/Mrs.,</b></td></tr>
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
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date('Y').' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				   
                        if($this->email_lib->send_email($admin_email, $subject, $output))
                        {
                            $this->db->where('id',$id);
                            $this->db->update('admin_users',$data);
                            $this->response(['user_id'=> $id,'message'=> 'OTP send on your Email Id successfully.'],  REST_Controller::HTTP_OK);
                        }
                        else
                        {
                            $this->response(['OTP not send something else.'],                       REST_Controller::HTTP_OK);
                        }
                    }
                    else
                    {
                         $this->response(['This Email Id already register  with us.'], REST_Controller::HTTP_OK);
                    }
    			    
    			}
    			else
    			{
		        //generate simple random code
				$set = '1234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				
				$data = array(
                  'admin_email' 	=> $admin_email,
                  'activation_code' => $activation_code,
                  'password_key_valid_untill'	=> date('Y-m-d', strtotime('+30 minutes')),
                );
                
			  $subject = 'OTP - '.$activation_code.' from team365';
			  $output='';
			  
			  $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style=" height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Mr,/Mrs.,</b></td></tr>
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
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date('Y').' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				  
    				
        			if($this->email_lib->send_email($admin_email, $subject, $output))
        			{
                        $this->db->where('id',$id);
                        $this->db->update('admin_users',$data);
                        $this->response(['user_id'=> $id,'message'=> 'OTP send on your Email Id successfully.'],  REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $this->response(['OTP not send something else.'],                       REST_Controller::HTTP_OK);
                    }
			
			    }
    		
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
    }
    
    public function emailOtp_post()
    {
        $id =  $this->uri->segment(4);
        
        $email_otp = $this->input->post('email_otp');
        $this->db->where('id',$id);
        $this->db->where('activation_code',$email_otp);
		$query = $this->db->get('admin_users');
		$row = $query->result_array();
        $rc = $query->num_rows();
        
        if($rc>0)
        {
             $this->response(['user_id'=>$id, 'email'=> $row[0]['admin_email'], 'mobile'=>$row[0]['admin_mobile'], 'message'=>'Email OTP verified successfully.'], REST_Controller::HTTP_OK);
        }
        else
        {
             $this->response(['Please enter valid Email OTP.'],                       REST_Controller::HTTP_OK);
        }
    }
    
    //Api for 2nd App team365
    public function emailreg_post()
    {
        $this->load->library('form_validation');
    	$this->form_validation->set_rules('admin_email', 'Email Id', 'trim|required'); 
    	
    		if($this->form_validation->run() == true)
			{
				$admin_email = $this->input->post('admin_email');
				$this->db->where('admin_email',$admin_email);
				$query = $this->db->get('admin_users');
				$row = $query->result_array();
                $rc = $query->num_rows();
                
    			if($rc>0)
    			{
    			    if(empty($row[0]['sub_domain']))
                    {
                        //generate simple random code
            			$set = '1234567890';
            			$activation_code = substr(str_shuffle($set), 0, 6);
            			
            			$data = array(
                          'activation_code' => $activation_code,
                          'password_key_valid_untill'	=> date('Y-m-d h:i:s', strtotime('+30 minutes'))
                        );
                        
                         $subject = 'OTP - '.$activation_code.' from team365';
			             $output='';
			  
		            $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style=" height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Mr,/Mrs.,</b></td></tr>
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
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date('Y').' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				   
                        if($this->email_lib->send_email($admin_email, $subject, $output))
                        {
                            $this->db->where('admin_email', $admin_email);
                            $this->db->update('admin_users',$data);
                            $this->response(['user_id'=> $row[0]['id'],'message'=> 'OTP send on your email id.'],  REST_Controller::HTTP_OK);
                        }
                        else
                        {
                            $this->response(['message' => 'OTP not send something else.', 'data' => 1],                       REST_Controller::HTTP_OK);
                        }
                    }
                    else
                    {
                         $this->response(['message'=>'This Email Id already register  with us.', 'exist' => 2], REST_Controller::HTTP_OK);
                    }
    			    
    			}
    			else
    			{
		        //generate simple random code
				$set = '1234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				
				$data = array(
                  'admin_email' 	=> $admin_email,
                  'activation_code' => $activation_code,
                  'password_key_valid_untill'	=> date('Y-m-d h:i:s', strtotime('+30 minutes')),
                );
                
			  $subject = 'OTP - '.$activation_code.' from team365';
			  $output='';
			  
			  $output .='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style=" height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : '.$activation_code.'</b></td></tr>
							<tr><td colspan="2"><b>Dear Mr,/Mrs.,</b></td></tr>
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
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date('Y').' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				  
    				
        			if($this->email_lib->send_email($admin_email, $subject, $output))
        			{
                        $this->db->insert('admin_users',$data);
                        $id = $this->db->insert_id();
                        $this->response(['user_id'=> $id,'message'=> 'OTP send on your email id.'],  REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $this->response(['message' => 'OTP not send something else.','data' => 1],                       REST_Controller::HTTP_OK);
                    }
			
			    }
    		
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
    }
    
     public function emailregOtp_post()
    {
        $id =  $this->uri->segment(4);
        
        $email_otp = $this->input->post('email_otp');
        $this->db->where('id',$id);
        $this->db->where('activation_code',$email_otp);
		$query = $this->db->get('admin_users');
		$row = $query->result_array();
        $rc = $query->num_rows();
        
        if($rc>0)
        {
             $this->response(['user_id'=>$id, 'email'=> $row[0]['admin_email'], 'message'=>'Email OTP verified successfully.'], REST_Controller::HTTP_OK);
        }
        else
        {
             $this->response(['Please enter valid Email OTP.'],                       REST_Controller::HTTP_OK);
        }
    }
    
    public function mobilereg_post()
    {
        $id =  $this->uri->segment(4);
        $this->load->library('form_validation');
    	$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required'); 
    	
    		if($this->form_validation->run() == true)
			{
				$admin_mobile = $this->input->post('admin_mobile');
				$this->db->where('admin_mobile',$admin_mobile);
				$query = $this->db->get('admin_users');
				$row = $query->result_array();
                $rc = $query->num_rows();
                
    			if($rc>0)
    			{
                    if(empty($row[0]['sub_domain']))
                    {
                        //generate simple random code
        				$set = '1234567890';
        				$activation_code = substr(str_shuffle($set), 0, 6);
        				
        				$data = array(
                        'mo_activation_code' => $activation_code
                    );
                
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
                        if(empty($err))
                        {
                            $this->db->where('admin_mobile', $admin_mobile);
                            $this->db->update('admin_users',$data);
                            $this->response(['user_id'=> $row[0]['id'],'message'=> 'OTP send on your mobile successfully.'],  REST_Controller::HTTP_OK);
                        }
                        else
                        {
                            $this->response(['message'=>'OTP not send something else.', 'data' => 1],                       REST_Controller::HTTP_OK);
                        }
				        curl_close($curl);
                        
                    }
                    else
                    {
                        $this->response(['message'=>'This mobile no already register  with us.', 'exist'=>2], REST_Controller::HTTP_OK);
                    }
    			     
    			}
    			else
    			{
		        //generate simple random code
				$set = '1234567890';
				$activation_code = substr(str_shuffle($set), 0, 6);
				
				$data = array(
                  'admin_mobile' 	=> $admin_mobile,
                  'mo_activation_code' => $activation_code
                );
                
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
                    if(empty($err))
                    {
                        $this->db->where('id',$id);
                        $this->db->update('admin_users',$data);
                        $this->response(['user_id'=> $id,'message'=> 'OTP send on your mobile successfully.'],  REST_Controller::HTTP_OK);
                    }
                    else
                    {
                        $this->response(['message' => 'OTP not send something else.', 'data' => 1],                       REST_Controller::HTTP_OK);
                    }
				 
			    }
    		
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
    }
    
    public function mobileregOtp_post()
    {
        $id =  $this->uri->segment(4);
        $mobile_otp = $this->input->post('mobile_otp');
        $this->db->where('id',$id);
        $this->db->where('mo_activation_code',$mobile_otp);
		$query = $this->db->get('admin_users');
		$row = $query->result_array();
        $rc = $query->num_rows();
        if($rc>0)
        {
             $this->response(['user_id'=>$id,'mobile'=>$row[0]['admin_mobile'],'email'=> $row[0]['admin_email'],'message'=>'Mobile OTP verified successfully.'], REST_Controller::HTTP_OK);
        }
        else
        {
             $this->response(['message'=>'Please enter valid mobile OTP.', 'data'=>1], REST_Controller::HTTP_OK);
        }
    }
    
    public function register_post()
	{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('admin_name', 'Admin Name', 'trim|required');
			$this->form_validation->set_rules('org_name', 'Organization Name', 'trim|required');  
			$this->form_validation->set_rules('admin_email', 'Email Id', 'trim|required'); 
			$this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required'); 
			$this->form_validation->set_rules('admin_password', 'Password', 'trim|required'); 
		    $this->form_validation->set_rules('subdomain', 'Sub Domain', 'trim|required');
		    
			if($this->form_validation->run() == true)
			{
			    $id =  $this->uri->segment(4);
				$org_name = $this->input->post('org_name');
				$admin_name = $this->input->post('admin_name');
				$admin_email = $this->input->post('admin_email');
				$admin_mobile = $this->input->post('admin_mobile');
				$admin_password = md5($this->input->post('admin_password'));
				$yourUrlname = $this->input->post('subdomain');
				$type = "admin";
				$product_type = "CRM";
				$active = false;
				
				$this->db->where( 'sub_domain', $yourUrlname);
				$query = $this->db->get('admin_users');
                $rc = $query->num_rows();
		
				
				if($rc>=1)
				{
				    $this->response(['message'=>'This Sub Domain already exist.', 'exist'=>1], REST_Controller::HTTP_OK);
				}
				else
				{
				    $data = array(
				        'admin_name' 		=> $admin_name,
                        'admin_password' 	=> $admin_password,
				        'sub_domain' => $yourUrlname,
				        'company_name' => $org_name,
				        'company_email' => $admin_email,
				        'account_type' => "Trial",
				        'trial_end_date' => date('Y-m-d', strtotime('+1 months')),
				        'type' => "admin",
				        'product_type' => "CRM",
				        'active' => false,
				        'mo_activation_code' => $activation_code
				    );
				    
                    $this->db->where('id', $id);
                    $this->db->where('admin_mobile', $admin_mobile);
                    $this->db->where('admin_email', $admin_email);
                    $this->db->update('admin_users',$data);
                    $this->db->trans_complete();        

        			if($this->db->trans_status() === true)
        			{
                        $this->response(['user_id'=>$id,'message'=>'You are register successfully.'],                       REST_Controller::HTTP_OK);
        			}
        			else
        			{
        			    $this->response(['message'=>'Something wrong! unable to register.','unable'=>2], REST_Controller::HTTP_OK);
        			}
			    }
			}else{
				
				$error = validation_errors();
                $this->response([$error], REST_Controller::HTTP_OK);
			}
		
	}
    // End api for 2nd app Team365
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $data = $this->db->get_where("admin_users", ['id' => $id])->row_array();
        }else{
            $data = $this->db->get("admin_users")->result();
        }
     
        $this->response($data, REST_Controller::HTTP_OK);
	}
      
    
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('admin_users', $input, array('id'=>$id));
     
        $this->response(['updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    
    public function index_delete($id)
    {
        $this->db->delete('contact', array('id'=>$id));
       
        $this->response(['Contact deleted successfully.'], REST_Controller::HTTP_OK);
    }*/
    	
}
?>