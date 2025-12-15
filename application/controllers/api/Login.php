<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Login extends REST_Controller {
    
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
   
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_post()
	{   
	    $username = $this->post('admin_email');
        $password = $this->post('admin_password');
	    $pass = md5($password);
        if(!empty($username && $password)){
            $validateadmin = $this->db->get_where("admin_users", ['admin_email' => $username,'admin_password' => $pass])->row_array();
            
            $validatestand = $this->db->get_where("standard_users", ['standard_email' => $username,'standard_password' => $pass])->row_array();
        
        if($validateadmin){
            $this->response($validateadmin, REST_Controller::HTTP_OK);
         }elseif($validatestand){
            $this->response($validatestand, REST_Controller::HTTP_OK);
         }else{
            $this->response(['Wrong username or password.'], REST_Controller::HTTP_OK); 
         }
         
        }else{
            // Set the response and exit
            $this->response(["Provide email and password."], REST_Controller::HTTP_OK);
        }
     
	}
	
	public function emaillog_post()
	{
	    $username = $this->post('admin_email');
	    $admin = ['admin_email' => $username,];
	    $user = ['standard_email' => $username,];
        if(!empty($username)){
            
            $this->db->from('admin_users');
            $this->db->where($admin);
            $this->db->where('sub_domain !=',' ');
            $qry = $this->db->get();
            $validateadmin = $qry->row_array();
           
             
            $this->db->from('standard_users');
            $this->db->where($user);
            $this->db->where('sub_domain !=',' ');
            $qry = $this->db->get();
            $validatestand = $qry->row_array();
        
                if($validateadmin){
                    $this->response(['id'=>$validateadmin['id']], REST_Controller::HTTP_OK);
                 }elseif($validatestand){
                    $this->response($validatestand, REST_Controller::HTTP_OK);
                 }else{
                    $this->response(['data'=>'1', 'message'=>'Please enter registered email Id.'], REST_Controller::HTTP_OK); 
                 }
         
        }else{
            // Set the response and exit
            $this->response(["Please enter your email Id"], REST_Controller::HTTP_OK);
        }
     
	}
	
	public function passlog_post()
	{   
	    
	    $rowid =  $this->uri->segment(4);
        $password = $this->post('admin_password');
	    $pass = md5($password);
        if(!empty($rowid && $password)){
            $validateadmin = $this->db->get_where("admin_users", ['id' => $rowid,'admin_password' => $pass])->row_array();
            
            $validatestand = $this->db->get_where("standard_users", ['id' => $rowid,'standard_password' => $pass])->row_array();
      
        if($validateadmin){
            $this->response($validateadmin, REST_Controller::HTTP_OK);
         }elseif($validatestand){
            $this->response($validatestand, REST_Controller::HTTP_OK);
         }else{
            $this->response(['data'=>'1','message'=>'Incorrect password.'], REST_Controller::HTTP_OK); 
         }
         
        }else{
            // Set the response and exit
            $this->response(["Please enter password."], REST_Controller::HTTP_OK);
        }
     
	}
	
	public function forget_password_post()
	{
	    $user = $this->post('contact');
	     
	    if(!empty($user))
	    {
	        $c = strpos($user,"@");
    	    if($c!='')
    	    {
    	        $user = "Email";
    	    }
    	    else
    	    {
    	        $user = "Phone";
    	    }
	    }
	    else{
	        $this->response(["Provide Email or contact."], REST_Controller::HTTP_OK);
	    }
	       // echo $user; exit;
    
		    $set = '0123456789';
		    $code = substr(str_shuffle($set), 0, 6);
		   //$code='123456';
		   
		    $d = strtotime("+2 minutes");
		    $key = date("Y-m-d H:i:s", $d);
		    if($user == 'Email')
		    {
				$email = $this->input->post('contact');
				$rdata = array(
                    'password_key' => $code,
                    'password_key_valid_untill' => $key,
                  );
                  $this->db->where('admin_email',$email);
                  $this->db->update('admin_users',$rdata);
                  
                  $this->db->select("*");
                  $this->db->where('admin_email',$email);
                  $this->db->from("admin_users");
                  $query = $this->db->get();
                  $data = $query->result_array();
                  
                  $rdata2 = array(
                     'password_key' => $code,
                     'password_key_valid_untill' => $key,
                  );
                  
                  $this->db->where('standard_email',$email);
                  $this->db->update('standard_users',$rdata2);
                  
                  $this->db->select("*");
                  $this->db->where('standard_email',$email);
                  $this->dsb->from("standard_users");
                  $query2 = $this->db->get();
                  $data2 = $query2->result_array();
				 
				 $subject = 'OTP - '.$code.' Reset Password from team365';
			   
				if(!empty($data))
				{
					foreach($data as $row)
					{
					    $output='<!DOCTYPE>
					    <html>
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
							<tr style="">
							  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo-team.png" style="marging:10px;width: 100px"></td>
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
							<td style="text-align:center;height: 40px; color: aliceblue;"><p style="font-size:14px;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</p></td>
									</tr>
						</table>
						</body>
					   </html>';
						
				// 	  $this->email->message($output);
					 
					}
				    // sending email
				    if($this->email_lib->send_email($email, $subject, $output))
				    {
				
						 $this->response(['user_id'=>$data[0]['id'],'message'=> 'OTP sent to your registered email address.'], REST_Controller::HTTP_OK);
				    }else{
						 $this->response(['Something went wrong. Try again in a few minutes.'], REST_Controller::HTTP_OK);
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
							<td style="text-align:center;height: 40px; color: blue;"><p style="font-size:14px;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</p></td>
						  </tr>
						</table>
						</body>
					   </html>';
					  //$this->email->message($output);
					  
					}
					// sending email
					if($this->email_lib->send_email($email, $subject, $output))
				    {
						 $this->response(['user_id'=>$data2[0]['id'],'message'=> 'OTP sent to your registered email address.'], REST_Controller::HTTP_OK);
		
				    }else{
				        
						$this->response(['Something went wrong. Try again in a few minutes.'], REST_Controller::HTTP_OK);
						
				    }
				}else{
				
					$this->response(['Please enter registered mobile number.'], REST_Controller::HTTP_OK);
				}
			}elseif($user == 'Phone')
			{
				$mobile = $this->input->post('contact');
				$data = array(
                    'password_key' => $code,
                    'password_key_valid_untill' => $key,
                  );
                  $this->db->where('admin_mobile',$mobile);
                  $this->db->update('admin_users',$data);
                  $this->db->select("*");
                  $this->db->where('admin_mobile',$mobile);
                  $this->db->from("admin_users");
                  $query = $this->db->get();
                  $data_m = $query->result_array();
                  
			      $data2 = array(
                          'password_key' => $code,
                          'password_key_valid_untill' => $key,
                          );
                  $this->db->where('admin_mobile',$mobile);
                  $this->db->update('admin_users',$data2);
                  $this->db->select("*");
                  $this->db->where('admin_mobile',$mobile);
                  $this->db->from("admin_users");
                  $query = $this->db->get();
                  $data_m2 = $query->result_array();
                   
				if(!empty($data_m) || !empty($data_m2))
				{
					$curl = curl_init();
					$url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/".'$mobile'."/".$code;
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
							$this->response(['Something went wrong. Try again in a few minutes.'], REST_Controller::HTTP_OK);
					}else{
					    if(!empty($data_m))
					    {
					        $this->response(['user_id'=>$data_m[0]['id'],'message'=> 'OTP sent to your registered mobile number.'], REST_Controller::HTTP_OK);
					    }
					    else
					    {
					        $this->response(['user_id'=>$data_m2[0]['id'],'message'=> 'OTP sent to your registered mobile number.'], REST_Controller::HTTP_OK);
					    }
					    
						
					}
				}else{
						$this->response(['Please enter registered mobile number.'], REST_Controller::HTTP_OK);
				}
			}
	}
	
	
	public function otp_password_post()
	{
	    $id =  $this->uri->segment(4);
	   // $d = strtotime("+30 minutes");
	    $key = date("Y-m-d H:i:s");
	    $password_key = $this->input->post('otp');
	  
	    $this->db->select("*");
        $this->db->where('id',$id);
        $this->db->where('password_key',$password_key);
        $this->db->where(' password_key_valid_untill>=',$key);
        $this->db->from("admin_users");
        $query = $this->db->get();
        $data = $query->result_array();
       
	    $this->db->select("*");
        $this->db->where('id',$id);
        $this->db->where('password_key',$password_key);
        $this->db->where(' password_key_valid_untill>=',$key);
        $this->db->from("standard_users");
        $query = $this->db->get();
        $data2 = $query->result_array();
       
	    if(!empty($data)||!empty($data2))
	    {
	        if(!empty($data))
	        {
	           //   print_r($d); exit;
	            $this->response(['user_id'=>$data[0]['id'],'message'=> 'Reset your password.'], REST_Controller::HTTP_OK);
	        }
	        else
	        {
	           //   print_r($d); exit;
	            $this->response(['user_id'=>$data2[0]['id'],'message'=> 'Reset your password.'], REST_Controller::HTTP_OK);
	        }
	       
	    }
	    else
	    {
           $this->response(["Please enter valid OTP."], REST_Controller::HTTP_OK);
	    }
	  
	}
	
	public function reset_password_post()
	{
		
        $id = $this->uri->segment(4);
       
        $this->db->select("*");
        $this->db->where('id',$id);
        $this->db->from("admin_users");
        $query = $this->db->get();
        $data['user'] = $query->result_array();
        
        $this->db->select("*");
        $this->db->where('id',$id);
        $this->db->from("standard_users");
        $query = $this->db->get();
        $data['user1'] = $query->result_array();
	
	   
          $password = md5($this->input->post('c_password'));
    	  $getvl=$this->input->get('tp');
    	  if(!empty($data['user'])){
    	      
    	      $rdata = array(
                    'admin_password' => $password,
                );
                 
                $this->db->where('id',$id);
                // $this->db->where('password_key',$password_key);
                $this->db->update('admin_users',$rdata);
              
                
    	  }else{
    	      $rdata = array(
                    'standard_password' => $password,
                );
                $this->db->where('id',$id);
                // $this->db->where('password_key',$password_key);
              $data2 = $this->db->update('standard_users',$rdata);
    		   
    	  }
    	  $this->response(["Password Changed Successfully."], REST_Controller::HTTP_OK);
       
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    
   
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('contact', $input, array('id'=>$id));
     
        $this->response(['Contact updated successfully.'], REST_Controller::HTTP_OK);
    }*/
     
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