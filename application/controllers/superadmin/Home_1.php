<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('superadmin/Login_model','Login');
		$this->load->model('Branch_model');
		$this->load->model('Reports_model');
		$this->load->model('superadmin/home_model','home_model');
		$this->load->library('email_lib');
	}
	
	public function index()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	    	
	      $session_comp_email = $this->session->userdata('company_email');
	      $sess_eml = $this->session->userdata('email');
	      $session_company = $this->session->userdata('company_name');
	      $data = array();
	      $data['leads'] = $this->Reports_model->assigned_lead_status($session_comp_email,$sess_eml,$session_company);
	      $data['total_reg'] = $this->home_model->get_all_ragisterAdmin();
	      $data['total_active'] = $this->home_model->get_all_activeAdmin();
	      $data['total_inactive'] = $this->home_model->get_all_inactiveAdmin();
	      $data['total_currentmonReg'] = $this->home_model->get_all_currmonReg();
	      $type = $this->session->userdata('type');
	      if($type== 'standard')
	      {
	      	$data['sales_quota'] = $this->Login->get_total_so_amount($type);
	      	$data['profit_quota'] = $this->Login->get_total_profit_quota($type);
	      }
		  if($type== 'standard')
          {
			$data['bestTrgtuser'] = $this->Reports_model->TargetGetterUser('standard');
          }
	      
	      
	      //print_r($data['profit_quota']);print_r($data['sales_quota']);die;
	      // $data['user'] = $this->Login->getusername();
	      // $data['admin'] = $this->Login->getadminname();
	      $this->load->view('superadmin/dashboard',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
	}
	
	/***********user details start**************/
  public function ajax_list()
  {
	$product_type="CRM";
    $list = $this->home_model->get_datatables($product_type);
    $data = array();
    $no = $_POST['start'];
	$i=1;
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      // if($this->session->userdata('superdelete_org')=='1') { 
        // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
      // }
       $first_row = "";
       $first_row.= $i++.'<div class="links">';
      $first_row.= '</div>';
	  $row[] = $first_row;
	  $row[] = date('d M Y',strtotime($post->created_date));
      $row[] = $post->admin_name;
	  $row[] = $post->company_name;
      $row[] = date('d M Y',strtotime($post->activation_date));
	  $row[] = $post->account_type;
	  $row[] = $post->product_type;
	  $row[] = date('d M Y',strtotime($post->trial_end_date)); 
      $row[] = $post->admin_mobile; 
       $row[] = $post->user_type; 
	  $select_row = "";
      $select_row.='<select class="form-control change_status" onchange="change_status('.$post->id.')" name="update_status"> <option value= "1"';
				if($post->active == "1" ) { 
	                     $select_row.='selected'; 
						 }
            $select_row.='>Active</option> <option value="0" ';
				if($post->active == "0" ) {
                        $select_row.='selected'; 
						}
	        $select_row.= '>Non-active</option></select>';
	   $row[] = $select_row;			   
       $row[] ='<a href="" data-toggle="modal" data-target="#view_admindetails'.$post->id .'">View</a>';
      //$row[] = $post->billing_city;
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->home_model->count_all(),
      "recordsFiltered" => $this->home_model->count_filtered($product_type),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
	
	
	// get superadmin all user details
	public function user_details()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
			
	        $type = $this->session->userdata('types');
	      
	      if($type == 'superadmin')
	      {
	      	$admins = $this->Login->get_all_loginadmin();
			$data['all_admin'] = $admins->result_array();
		  }
	      
             $this->load->view('superadmin/admin_details',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
	}
	//show user details by id
	public function view_userDetails()
  	{
		 if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
			$view_id = $this->uri->segment(3);//die;
		    $all_admin = $this->Login->get_all_loginadmin($view_id);
			$admin = $all_admin->row_array();
			 
			 $standard_user = $this->Login->get_all_standarduser($admin['company_email'],$admin['company_name']);
			 $data['standared_users'] =  $standard_user->result_array();
		    $this->load->view('superadmin/view_adminDetails',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
  	}
	  ////////////////////////////////////////////
     //////////////Invoice User Details///////////
	//////////////////////////////////////////////
	
		public function invoice_details()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
			
	        $type = $this->session->userdata('types');
	      
	      if($type == 'superadmin')
	      {
	      	$admins = $this->Login->get_all_loginadmin();
			$data['all_admin'] = $admins->result_array();
		  }
	      
	      
             $this->load->view('superadmin/invoice_details',$data);

	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
	}
	
	
	public function ajax_list_invoice()
     {
		 $product_type="invoice";
    $list = $this->home_model->get_datatables($product_type);
    $data = array();
    $no = $_POST['start'];
	$i=1;
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      // if($this->session->userdata('superdelete_org')=='1') { 
        // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
      // }
       $first_row = "";
       $first_row.= $i++.'<div class="links">';
      $first_row.= '</div>';
	  $row[] = $first_row;
	  $row[] = date('d M Y',strtotime($post->created_date));
      $row[] = $post->admin_name;
	  $row[] = $post->company_name;
     // $row[] = date('d M Y',strtotime($post->license_activation_date));
	 
		if($post->invoice_license_active_date==""){
		 $row[] =  "Free";
	  }else{
		  $row[] = $post->invoice_license_active_date;
	  }
	  //$row[] = $post->invoice_account_type;
	  if($post->invoice_account_type==""){
		 $row[] =  "Free";
	  }else{
		  $row[] = $post->invoice_account_type;
	  }
	  $row[] = $post->invoice_license_type;
	  $row[] = $post->product_type;
	 // $row[] = date('d M Y',strtotime($post->trial_end_date)); 
	  if($post->created_date==""){
		 $row[] =  "Free";
	  }else{
		  $row[] =$post->created_date;
	  }
      $row[] = $post->admin_mobile; 
       $row[] = $post->user_type; 
	  $select_row = "";
      $select_row.='<select class="form-control change_status" onchange="change_status('.$post->id.')" name="update_status"> <option value= "1"';
				if($post->active == "1" ) { 
	                     $select_row.='selected'; 
						 }
            $select_row.='>Active</option> <option value="0" ';
				if($post->active == "0" ) {
                        $select_row.='selected'; 
						}
	        $select_row.= '>Non-active</option></select>';
	   $row[] = $select_row;			   
       $row[] ='<a href="" data-toggle="modal" data-target="#view_admindetails'.$post->id .'">View</a>';
      //$row[] = $post->billing_city;
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->home_model->count_all(),
      "recordsFiltered" => $this->home_model->count_filtered($product_type),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
	
   public function view_invoiceDetails()
  	{
		 if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
			$view_id = $this->uri->segment(3);//die;
		    $all_admin = $this->Login->get_all_loginadmin($view_id);
			$admin = $all_admin->row_array();
			 
			 $standard_user = $this->Login->get_all_standarduser($admin['company_email'],$admin['company_name']);
			 $data['standared_users'] =  $standard_user->result_array();
		    $this->load->view('superadmin/view_invoiceDetails',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
  	}

	public function change_status()
  	{
		$status = $this->input->post('selected_data');
		$selected_id = $this->input->post('selected_id');
		$status_data = array(
		     'active' => $status
			 );
        $data = $this->Login->status_update($selected_id ,$status_data );
        if($data == 200){
            
            $subject = 'Notifiction About Account';
            
            $output ='<!DOCTYPE> <html> <head>
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
							<tr style="height: 45px;"><td style="text-align: center;"><b>Congratulations!</b></td></tr>
							<tr><td colspan="2"><b>Dear Sir/Madam,</b></td></tr>
							<tr><td colspan="2">Your account approved by site administrator .Now you can login. For login click below link</td></tr>
							<tr><td>
								<table>
									<tr><td style="text-align:center;"><button><a href="'.base_url("login").'" >Login</a></button></td></tr>
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
						<td style="text-align:center;height: 40px; color: blue;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				   
				   if($status == 1){
				       $active_date = array(
		                   'activation_date' => date('Y-m-d H:i:a')
			          );
				       $this->Login->status_update($selected_id ,$active_date );
				   //fetch user email
				   $this->db->select('admin_email');
				   $this->db->where('id',$selected_id);
				   $adminemail = $this->db->get('admin_users')->row_array();
				   
				   //send notification mail for users
				   if($this->email_lib->send_email($adminemail['admin_email'],$subject,$output)){
				     print_r($data);  
				   }
				   }else{
				     print_r($data);   
				   }
        }
	    
  	}
	
	
	public function change_userStatus()
  	{
		//echo  $status = $this->input->post('selected_data'); die;
		 if($this->input->post('selected_data') == "u")
        {
			 $status = 0 ; 
		}else{
		   $status = $this->input->post('selected_data');
		}
		 $selected_id = $this->input->post('selected_id');//die;
		$status_data = array(
		     'status' => $status
			 );
        $data = $this->Login->statusUser_update($selected_id ,$status_data );
	    print_r($data);
  	}
	
	 public function status_filters()
  	 {
	  $output = '';
      // //$query = '';
  //echo 'hellooosss';
        if($this->input->post('searchDate'))
        {
         
        if($this->input->post('searchDate') == "u")
        {
			 $searchDate = 0 ;
		}else{
			  $searchDate = $this->input->post('searchDate');
		}

          $data = $this->Login->filter_data($searchDate);
	   
      $output .= '<table style="margin-bottom:5px;" id="view_add" width="100%">
                <tbody>
				<tr>
                  
                  <td width="15%"><b class="text-secondary">Standard Name:</b></td>
                  <td width="20%"><b class="text-secondary">Standard Email:</b></td>
				  <td width="20%"><b class="text-secondary">Company Email:</b></td>
                  <td width="15%"><b class="text-secondary">Standard Mobile:</b></td>
                  <td width="15%"><b class="text-secondary">Company Mobile:</b></td>
				  <td width="15%"><b class="text-secondary">Status:</b></td>
                </tr> ';

      if($data->num_rows() > 0)
       {
	   $i=1;
    foreach($data->result_array() as $all_user)
    {
     $output .= ' <tr>
			  <td width="15%">'.$all_user["standard_name"].'</td>
			  <td width="20%">'.$all_user["standard_email"].' </td>
			  <td width="20%">'.$all_user["company_email"] .'</td>
			  <td width="15%">'.$all_user["standard_mobile"].'</td>
			  <td width="15%">'.$all_user["company_mobile"] .' </td>
			  <td width="15%"><select class="form-control change_userstatus"  id="'. $all_user["id"].'" ><option value="1" ';
			     if($all_user['status'] =='1' ) { 
				    $output .= 'selected'; 
					} 
					$output .= '>Active</option><option value="0" ';
					  if($all_user['status'] =='0' ) {
						  $output .= 'selected';
						  } 
						 $output .= '>Non-active</option>
                       </select>
			  </td>
			  </tr> ';
    }
     }
     else
     {
    $output .= '<tr>
        <td colspan="9">No Data Found</td>
       </tr>';
   }
   $output .= '</tbody>
   </table>';
  echo $output;
  // echo json_encode($output);
	    }
	 }
	
	public function getdata()
  	{
	    $data = $this->Reports_model->get_profit_graph();
	    echo json_encode($data);
  	}
  	public function getdata_by_user()
  	{
	    $data = $this->Reports_model->get_all_sales_by_user();
	    echo json_encode($data);
  	}
	
	//signup user graph
  	public function signup_user_graph()
  	{
	    $type ="admin";
	    if($type == "admin")
	    {
	      $sort_date = $this->input->post('date');
	      //$salesorder = $this->Login->get_all_signupuser_by_date($sort_date,$type);

		  if($sort_date){
			
		    $filter_query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(created_date) as month_name FROM admin_users WHERE YEAR(created_date) = '" . $sort_date . "'  AND  type = 'admin' GROUP BY YEAR(created_date),MONTH(created_date)"); 
 
         $filter_record = $filter_query->result();
     
	      echo json_encode($filter_record);  
		  }else{
			 
		    $query =  $this->db->query("SELECT COUNT(id) as count,MONTHNAME(created_date) as month_name FROM admin_users WHERE YEAR(created_date) = '" . date('Y') . "'  AND  type = 'admin' GROUP BY YEAR(created_date),MONTH(created_date)"); 
 
         $record = $query->result();
     
	      echo json_encode($record); 
		  }
		  
		}
  	}
	
  	
	
 	public function profile()
  	{
	    if(!empty($this->session->userdata('loggedsuperadmin_in')))
	    {
	      //$data['user'] = $this->Login->getuserdata();
	      $data['basic'] = $this->Login->active_basic_lic();
	      $data['business'] = $this->Login->active_business_lic();
	      $data['enterprise'] = $this->Login->active_enterprise_lic();
	      $data['users_data'] = $this->Login->get_company_users();
	      $this->load->view('superadmin/profile',$data);
	    }
	    else
	    {
	      redirect('superadmin/login');
	    }
  	}
  	public function update_profile()
  	{
	    $validation = $this->check_validation();
	    if($validation!=200)
	    {
	      echo $validation;die;
	    }
	    else
	    {

	      $id = $this->input->post('id');
	      $image_data = $this->Login->get_image_name($id);
	      $image_name = $image_data['company_logo'];
	      if($this->session->userdata('type') == 'admin')
	      {
	        $id = $this->input->post('id');
	       
	        if(!empty($_FILES["company_logo"]['name']))
	        {
	            $dirpath = './uploads/company_logo/';
	            //unlink($dirpath.$image_name);
	            $config1['upload_path']   = './uploads/company_logo/';
	            $config1['allowed_types'] = 'jpg|jpeg|png';
	            $config1['max_size']      = 2097152;
	            $logo_name = time()."_".str_replace(' ','_',$_FILES["company_logo"]['name']);
	            $config1['file_name'] = $logo_name;
	            $this->load->library('upload', $config1);
	            $this->upload->initialize($config1);
	            $this->upload->do_upload('company_logo');
	            $uploadData = $this->upload->data();
	            $uploadedFile = $uploadData['file_name'];
			
	        }
	        else { $logo_name = $image_name; }
	        $data = array
	          (
	            'admin_name' => $this->input->post('name'),
	            'admin_email' => $this->input->post('email'),
	            'admin_mobile' => $this->input->post('company_contact'),
	            'country' => $this->input->post('country'),
	            'state' => $this->input->post('state'),
	            'city' => $this->input->post('city'),
	            'company_address' => $this->input->post('address'),
	            'zipcode' => $this->input->post('zipcode'),
	            'company_logo' => $logo_name,
	          );
	          $standard_user = $this->Login->update_standard_user_profile($logo_name);
	          
	      }
	      else if($this->session->userdata('type') == 'standard')
	      {
	      	$user_profile_data = $this->Login->get_user_profile_image($id);
	        $user_profile_image = $user_profile_data['profile_image'];
	        if(!empty($_FILES["profile_image"]['name']))
	        {
	          $profile_path = './uploads/profile_image/';;
	          unlink($profile_path.$user_profile_image);
	          $config['upload_path']   = './uploads/profile_image/';;
	          $config['allowed_types'] = 'jpg|jpeg';
	          $config['max_size']      = 2097152;
	          $profile_image = $id.'_'.time()."_".str_replace(' ','_',$_FILES["profile_image"]['name']);
	          $config['file_name'] = $profile_image;
	          $this->load->library('upload', $config);
	          $this->upload->initialize($config);
	          $this->upload->do_upload('profile_image');
	          $uploadData = $this->upload->data();
	          $uploadedFile = $uploadData['file_name'];
	          //echo $this->upload->display_errors();die();
	        }
	        else { $profile_image = $user_profile_image;}
	        $data = array
	          (
	            'standard_name' => $this->input->post('name'),
	            'standard_mobile' => $this->input->post('contact_number'),
	            'profile_image' => $profile_image,
	          );
	      }
	      $result = $this->Login->update_profile($data,$id);
	      
	      echo json_encode(array("status" => 200));
	      //redirect('login');
	    }
  	}
  	
  	
    /***** Extends Date******/
    public function update_extend()
	{
		  $id = $this->input->post('ext_id'); 
		  $resultdata=$this->Login->get_all_loginadmin($id)->row();
		  // print_r($resultdata);die;
		  $adminname =$resultdata->admin_name; 
		  $companyname =$resultdata->company_name; 
		  $trialdate =date_create($resultdata->trial_end_date); 
		  $ext_date= $this->input->post('extend_date');
		 
		  $date=date_create($ext_date);
          $extdate=date_format($date,"Y-m-d");
		  $totalextend_day=date_diff($date,$trialdate)->days;
		  //print_r($totalextend_day);die;
		 
		   $data = array(
              'trial_end_date'  =>$extdate
	       );
	      $result = $this->home_model->extends_update($id,$data);
	   
	      //Extend Trial Send To mail Update date 
		 //$subject='Thank You Team365!';
         //$this->email_lib->send_email('dev3@team365.io',$subject,$data['trial_end_date']);//send user
		 $subject='Your Team365 CRM trial account extended for '.$totalextend_day.' days.';

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
           .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
        	           <tr>
                      <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
        			   
        		<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0"><br><br>
        		<tr><td colspan="2">Dear <b>'.$adminname.',</td></tr><br><br>
        		
        		<tr><td><br>
        		<p>Your Team365 CRM trial account expires in '.date('d M Y',strtotime($resultdata->trial_end_date)).'</p>
        		<p>Congretulations,Your team365 CRM trial account extended for  '.$totalextend_day.' days .till date '.date('d M Y',strtotime($data['trial_end_date'])).'  </p>
        		<p>Regards</p>
        		<p>team365</>
        		<table>
        		
        		
        		   </table>
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
        	</body>
        	</html>';
            	//End Extend trial Send mail 
            	if($result){
            	    //send email company
            	  $this->email_lib->send_email($resultdata->company_email,$subject,$output);
            	$this->email_lib->send_email($resultdata->admin_email,$subject,$output);//send user
                  echo json_encode(array("st" => 200));	
            	}else{
            	  echo json_encode(array("st" => 201));
            	}
	 
	 	
	}
	public function getbyId($id)
	{
		$data = $this->home_model->get_by_id($id);
		echo json_encode($data);
	}
	
  	
  	
  	public function check_validation()
  	{
	    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
	    $this->form_validation->set_rules('name', 'Name', 'required|trim');
	    $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
	    if($this->session->userdata('type') == 'admin')
	    {
	    	$this->form_validation->set_rules('company_contact', 'Contact Number', 'regex_match[/^[0-9]{10}$/]|trim');
	    	$this->form_validation->set_rules('country', 'Country', 'required|trim');
		    $this->form_validation->set_rules('state', 'State', 'required|trim');
		    $this->form_validation->set_rules('city', 'City', 'required|trim');
		    $this->form_validation->set_rules('address', 'Address', 'required|trim');
		    $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
	    }
	    else if($this->session->userdata('type') == 'standard')
	    {
	    	$this->form_validation->set_rules('contact_number', 'Contact Number', 'regex_match[/^[0-9]{10}$/]|trim');
	    }
	    
	    $this->form_validation->set_message('required', '%s is required');
	    $this->form_validation->set_message('valid_email', '%s is not valid');
	    $this->form_validation->set_message('regex_match', '%s is not valid');
	    if($this->form_validation->run() == FALSE)
	    {
	    	if($this->session->userdata('type') == 'admin')
	    	{
	    		return json_encode(array('st'=>202, 'name'=> form_error('name'), 'mobile'=> form_error('mobile'), 'email'=> form_error('email'), 'company_contact'=> form_error('company_contact'), 'country'=> form_error('country'), 'state'=> form_error('state'), 'city'=> form_error('city'), 'address'=> form_error('address'), 'zipcode'=> form_error('zipcode') ));
	    	}
	    	else if($this->session->userdata('type') == 'standard')
	    	{
	    		return json_encode(array('st'=>202, 'name'=> form_error('name'), 'contact_number'=> form_error('contact_number') ));
	    	}
	    }
	    else
	    {
	      return 200;
	    }
  	}
  	public function create()
  	{

  		$validation = $this->check_user_validation();
	    if($validation!=200)
	    {
	      echo $validation;die;
	    }
	    else
	    {
		    if(!empty($this->input->post('first_name')))
		    {
		        $standard_name = $this->input->post('first_name')." ".$this->input->post('last_name');
		    }
		    else
		    {
		        $standard_name = $this->input->post('standard_name');
		    }
		    $type = "standard";
		    $data = array(
		      'standard_name' => $standard_name,
		      'standard_email' => $this->input->post('standard_email'),
		      'standard_mobile' => $this->input->post('standard_mobile'),
		      'standard_password' => md5($this->input->post('standard_password')),
		      'license_type'=> $this->input->post('license_type'),
		      'admin_name' => $this->session->userdata('name'),
		      'type' => $type,
		      'company_name' => $this->session->userdata('company_name'),
		      'country' => $this->session->userdata('country'),
		      'state' => $this->session->userdata('state'),
		      'city' => $this->session->userdata('city'),
		      'company_address' => $this->session->userdata('company_address'),
		      'zipcode' => $this->session->userdata('zipcode'),
		      'company_mobile' => $this->session->userdata('company_mobile'),
		      'company_email' => $this->session->userdata('company_email'),
		      'company_website' => $this->session->userdata('company_website'),
		      'company_gstin' => $this->session->userdata('company_gstin'),
		      'pan_number' => $this->session->userdata('pan_number'),
		      'cin' => $this->session->userdata('cin'),
		      'company_logo' => $this->session->userdata('company_logo'),
		      'terms_condition_customer' => $this->session->userdata('terms_condition_customer'),
		      'terms_condition_seller' => $this->session->userdata('terms_condition_seller'),
		    );
		    $this->Login->create($data);
		    echo json_encode(array("status" => TRUE));
		}
  	}
  	public function check_user_validation()
  	{
  		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
	    $this->form_validation->set_rules('standard_email', 'Email', 'required|valid_email|trim');
	    $this->form_validation->set_rules('standard_mobile', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
	    $this->form_validation->set_message('required', '%s is required');
	    $this->form_validation->set_message('valid_email', '%s is not valid');
	    $this->form_validation->set_message('regex_match', '%s is not valid');
	    if($this->form_validation->run() == FALSE)
	    {
	    	
	    	return json_encode(array('st'=>202, 'standard_email'=> form_error('standard_email'), 'standard_mobile'=> form_error('standard_mobile') ));
	    }
	    else
	    {
	      return 200;
	    }
  	}
  	public function check_duplicate_user()
  	{
  		$standard_name = $this->input->post('standard_name');
  		$check_name = $this->Login->check_duplicate_user($standard_name);
  		if($check_name == 202)
  		{
  			echo json_encode(array('st' => 202));
  		}
  		else if($check_name == 200)
  		{
  			echo json_encode(array('st' => 200));
  		}
  	}
  	public function viewUser()
	{
	    if(!empty($this->session->userdata('email')))
	    {
			
		  //$data = $this->Login->get_company_users();
		 // print_r($data);
	      $this->load->view('users/view_user');

	    }
	    else
	    {
	      redirect('login');
	    }
	}
	
	public function ajax_user_table()
	{
	    if(!empty($this->session->userdata('email')))
	    {
			
		    $list= $this->Login->get_company_users();
			$Adminlist = $this->Login->get_admin_detail();
			$totalEntry=count($list)+count($Adminlist);
			$data = array();
			$no = $_POST['start'];
			
			foreach ($Adminlist as $post)
				{
				  $no++;
				  $row = array();
				  // APPEND HTML FOR ACTION
				  $row[] = $post->admin_name.'<div class="links">
				  <a style="text-decoration:none" href="javascript:void(0)" onclick="set_target('."'".$post->id."'".',`'.$post->admin_name.'`,`admin` ,`'.$post->admin_email.'`)" class="text-primary">Set Target</a>
				  </div>';
				  $row[] = $post->admin_email;
				  $row[] = $post->admin_mobile;
				  $row[] = $post->company_website;
				  $row[] = $post->company_gstin;
				  $row[] = $post->license_type;
				  $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
				  $data[] = $row;
				}
			
			
			foreach ($list as $post)
				{
				  $no++;
				  $row = array();
				  // APPEND HTML FOR ACTION
				  
				  $row[] = $post['standard_name'].'<div class="links">
				  <a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post['id']."'".')" class="text-success">View</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post['id']."'".')" class="text-primary">Update</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="set_target('."'".$post['id']."'".',`'.$post['standard_name'].'`,`standard`,`'.$post['standard_email'].'`)" class="text-primary">Set Target</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post['id']."'".')" class="text-danger">Delete</a>
				  </div>';
				  $row[] = $post['standard_email'];
				  $row[] = $post['standard_mobile'];
				  $row[] = $post['company_website'];
				  $row[] = $post['company_gstin'];
				  $row[] = $post['license_type'];
				  //$row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
					  $data[] = $row;
				}
				
				$output = array(
				  "draw" 			=> $_POST['draw'],
				  "recordsTotal" 	=> $this->Login->count_all(),
				  "recordsFiltered" => $totalEntry,//$this->Login->count_filtered(),
				  "data" 			=> $data,
				);
				echo json_encode($output);

	    }
	    else
	    {
	      redirect('login');
	    }
	}
	
	
	public function view_user()
  	{
	    $list = $this->Login->get_datatables();
	    $data = array();
	    $no = $_POST['start'];
	    foreach ($list as $post)
	    {
	      $no++;
	      $row = array();
	      // APPEND HTML FOR ACTION
	      $row[] = ucwords($post->standard_name).'<div class="links">
	      <a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-info">View</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-secondary">Update</a>
	      | <a style="text-decoration:none" href="javascript:void(0);" class="text-success" onclick="set_target('."'".$post->id."'".')">Set Target</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_user('."'".$post->id."'".')" class="text-danger">Delete</a>
	      </div>';
	      $row[] = $post->standard_email;
	      $row[] = $post->standard_mobile;
	      $row[] = $post->company_website;
	      $row[] = $post->company_gstin;
	      $row[] = $post->license_type;
	      
	       $data[] = $row;
	    }
	    $output = array(
	      "draw" => $_POST['draw'],
	      "recordsTotal" => $this->Login->count_all(),
	      "recordsFiltered" => $this->Login->count_filtered(),
	      "data" => $data,
	    );
	    //output to json format
	    echo json_encode($output);
  	}
  	public function delete_bulk()
  	{
	    if($this->input->post('checkbox_value'))
	    {
	      $id = $this->input->post('checkbox_value');
	      for($count = 0; $count < count($id); $count++)
	      {
	        $this->Login->delete_bulk($id[$count]);
	      }
	    }
  	}
  	public function getuserbyId($id)
  	{
	    $data = $this->Login->get_by_id($id);
	    echo json_encode($data);
  	}
  	public function get_target_data()
  	{
	    $id = $this->input->post('id');
	    $data = $this->Login->get_user_target_data($id);
	    echo json_encode($data);
  	}
  	public function set_target()
  	{
	    $id = $this->input->post('data_id');
	    $data = array(
	                  'sales_quota' => $this->input->post('sales_quota'),
	                  'profit_quota' => $this->input->post('profit_quota')
	                );
	    $result = $this->Login->set_user_target($id,$data);
	    if($result == 200)
	    {
	      echo json_encode(array('st' => 200));
	    }
  	}
  	public function update()
  	{
  		$validation = $this->check_update_validation();
	    if($validation!=200)
	    {
	      echo $validation;die;
	    }
	    else
	    {
	    	//print_r($this->input->post());die;
	    	$data = array(
		      'id' => $this->input->post('update_id'),
		      'standard_name' => $this->input->post('standard_name'),
		      'standard_email' => $this->input->post('standard_email'),
		      'standard_mobile' => $this->input->post('standard_mobile'),
		      'country' => $this->input->post('country'),
		      'state' => $this->input->post('state'),
		      'city' => $this->input->post('city'),
		      'company_address' => $this->input->post('company_address'),
		      'zipcode' => $this->input->post('zipcode'),
		      'create_org' => $this->input->post('create_org'),
		      'retrieve_org' => $this->input->post('retrieve_org'),
		      'update_org' => $this->input->post('update_org'),
		      'delete_org' => $this->input->post('delete_org'),
		      'create_contact' => $this->input->post('create_contact'),
		      'retrieve_contact' => $this->input->post('retrieve_contact'),
		      'update_contact' => $this->input->post('update_contact'),
		      'delete_contact' => $this->input->post('delete_contact'),
		      'create_lead' => $this->input->post('create_lead'),
		      'retrieve_lead' => $this->input->post('retrieve_lead'),
		      'update_lead' => $this->input->post('update_lead'),
		      'delete_lead' => $this->input->post('delete_lead'),
		      'create_opp' => $this->input->post('create_opp'),
		      'retrieve_opp' => $this->input->post('retrieve_opp'),
		      'update_opp' => $this->input->post('update_opp'),
		      'delete_opp' => $this->input->post('delete_opp'),
		      'create_quote' => $this->input->post('create_quote'),
		      'retrieve_quote' => $this->input->post('retrieve_quote'),
		      'update_quote' => $this->input->post('update_quote'),
		      'delete_quote' => $this->input->post('delete_quote'),
		      'create_so' => $this->input->post('create_so'),
		      'retrieve_so' => $this->input->post('retrieve_so'),
		      'update_so' => $this->input->post('update_so'),
		      'delete_so' => $this->input->post('delete_so'),
		      'create_vendor' => $this->input->post('create_vendor'),
		      'retrieve_vendor' => $this->input->post('retrieve_vendor'),
		      'update_vendor' => $this->input->post('update_vendor'),
		      'delete_vendor' => $this->input->post('delete_vendor'),
		      'create_po' => $this->input->post('create_po'),
		      'retrieve_po' => $this->input->post('retrieve_po'),
		      'update_po' => $this->input->post('update_po'),
		      'delete_po' => $this->input->post('delete_po'),
		      'create_inv' => $this->input->post('create_inv'),
		      'retrieve_inv' => $this->input->post('retrieve_inv'),
		      'update_inv' => $this->input->post('update_inv'),
		      'delete_inv' => $this->input->post('delete_inv'),
		    );
		    $this->Login->update(array('id' => $this->input->post('update_id')), $data);
		    echo json_encode(array("st" => 200));
	    }
  	}
  	public function check_update_validation()
  	{
  		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
  		$this->form_validation->set_rules('standard_name', 'Name', 'required|trim');
	    $this->form_validation->set_rules('standard_email', 'Email', 'required|valid_email|trim');
	    $this->form_validation->set_rules('standard_mobile', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
	    $this->form_validation->set_rules('country', 'Country', 'required|trim');
	    $this->form_validation->set_rules('state', 'State', 'required|trim');
	    $this->form_validation->set_rules('city', 'City', 'required|trim');
	    $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
	    $this->form_validation->set_rules('company_gstin', 'GST', 'required|trim');
	    $this->form_validation->set_rules('company_address', 'Company Address', 'required|trim');
	    $this->form_validation->set_message('required', '%s is required');
	    $this->form_validation->set_message('valid_email', '%s is not valid');
	    $this->form_validation->set_message('regex_match', '%s is not valid');
	    if($this->form_validation->run() == FALSE)
	    {
	    	return json_encode(array('st'=>202, 'standard_name'=> form_error('standard_name'), 'standard_email'=> form_error('standard_email'), 'standard_mobile'=> form_error('standard_mobile'), 'country'=> form_error('country'), 'state'=> form_error('state'), 'city'=> form_error('city'), 'zipcode'=> form_error('zipcode'), 'company_gstin'=> form_error('company_gstin'), 'company_address'=> form_error('company_address') ));
	    }
	    else
	    {
	      return 200;
	    }
  	}
  	public function delete($id)
  	{
	    $this->Login->delete($id);
	    echo json_encode(array("status" => TRUE));
  	}
  	public function view_branches()
  	{
  		if(!empty($this->session->userdata('email')))
	    {
	      $this->load->view('users/view_branches');
	    }
	    else
	    {
	      redirect('login');
	    }
  	}
	public function ajax_list_branch()
  	{
	    $list = $this->Branch_model->get_datatables();
	    $data = array();
	    $no = $_POST['start'];
	    foreach ($list as $post)
	    {
	      $no++;
	      $row = array();
	      // APPEND HTML FOR ACTION
	      $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
	      $row[] = $post->branch_name.'<div class="links">
	      <a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-info">View</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-secondary">Update</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>
	      </div>';
	      $row[] = $post->branch_email;
	      $row[] = $post->contact_number;
	      $row[] = $post->company_name;
	      $row[] = $post->gstin;
	      $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
	          $data[] = $row;
	    }
	    $output = array(
	      "draw" => $_POST['draw'],
	      "recordsTotal" => $this->Branch_model->count_all(),
	      "recordsFiltered" => $this->Branch_model->count_filtered(),
	      "data" => $data,
	    );
	    //output to json format
	    echo json_encode($output);
  	}
  	public function create_branch()
  	{
  		$validation = $this->check_branch_validation();
  		if($validation!=200)
  		{
  			echo $validation;die;
  		}
  		else
  		{
		    $data = array(
		      'company_id' => $this->session->userdata('id'),
		      'sess_eml' => $this->session->userdata('email'),
		      'company_name' => $this->session->userdata('company_name'),
		      'branch_name' => $this->input->post('branch_name'),
		      'branch_email' => $this->input->post('branch_email'),
		      'contact_number' => $this->input->post('contact_number'),
		      'gstin' => $this->input->post('gstin'),
		      'cin' => $this->input->post('cin'),
		      'pan' => $this->input->post('pan'),
		      'country' => $this->input->post('country'),
		      'state' => $this->input->post('state'),
		      'city' => $this->input->post('city'),
		      'zipcode' => $this->input->post('zipcode'),
		      'address' => $this->input->post('address'),
		    );
		    $this->Branch_model->create($data);
		    echo json_encode(array("st" => 200));
		}
  	}
  	public function update_branch()
  	{
  		$validation = $this->check_branch_validation();
  		if($validation!=200)
  		{
  			echo $validation;die;
  		}
  		else
  		{
  			$data = array(
		      'id' => $this->input->post('id'),
		      'branch_name' => $this->input->post('branch_name'),
		      'branch_email' => $this->input->post('branch_email'),
		      'contact_number' => $this->input->post('contact_number'),
		      'gstin' => $this->input->post('gstin'),
		      'cin' => $this->input->post('cin'),
		      'pan' => $this->input->post('pan'),
		      'country' => $this->input->post('country'),
		      'state' => $this->input->post('state'),
		      'city' => $this->input->post('city'),
		      'zipcode' => $this->input->post('zipcode'),
		      'address' => $this->input->post('address'),
		    );
		    $this->Branch_model->update(array('id' => $this->input->post('id')), $data);
		    echo json_encode(array("st" => 200));
  		}  
  	}
  	public function check_branch_validation()
  	{
  		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
  		$this->form_validation->set_rules('branch_name', 'Name', 'required|trim');
	    $this->form_validation->set_rules('branch_email', 'Email', 'required|valid_email|trim');
	    $this->form_validation->set_rules('contact_number', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
	    $this->form_validation->set_rules('gstin', 'GSTIN', 'required|trim');
	    $this->form_validation->set_rules('cin', 'CIN', 'required|trim');
	    $this->form_validation->set_rules('country', 'Country', 'required|trim');
	    $this->form_validation->set_rules('pan', 'Pan', 'required|trim');
	    $this->form_validation->set_rules('state', 'State', 'required|trim');
	    $this->form_validation->set_rules('city', 'City', 'required|trim');
	    $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
	    $this->form_validation->set_rules('address', 'Branch Address', 'required|trim');
	    $this->form_validation->set_message('required', '%s is required');
	    $this->form_validation->set_message('valid_email', '%s is not valid');
	    $this->form_validation->set_message('regex_match', '%s is not valid');
	    if($this->form_validation->run() == FALSE)
	    {
	    	return json_encode(array('st'=>202, 'branch_name'=> form_error('branch_name'), 'branch_email'=> form_error('branch_email'), 'contact_number'=> form_error('contact_number'), 'gstin'=> form_error('gstin'), 'cin'=> form_error('cin'), 'pan'=> form_error('pan'), 'country'=> form_error('country'), 'state'=> form_error('state'), 'city'=> form_error('city'), 'zipcode'=> form_error('zipcode'), 'address'=> form_error('address') ));
	    }
	    else
	    {
	      return 200;
	    }
  	}
  	public function getbranchbyId($id)
  	{
	    $data = $this->Branch_model->get_by_id($id);
	    echo json_encode($data);
	}
	  public function delete_branch($id)
	  {
	    $this->Branch_model->delete($id);
	    echo json_encode(array("status" => TRUE));
	  }
	  public function delete_branch_bulk()
	  {
	    if($this->input->post('checkbox_value'))
	    {
	      $id = $this->input->post('checkbox_value');
	      for($count = 0; $count < count($id); $count++)
	      {
	        $this->Branch_model->delete_bulk($id[$count]);
	      }
	    }
  	}
    public function get_profit_table()
  	{
	    $list = $this->Reports_model->get_profit_datatables();
	    //print_r($list);die;
	    $data = array();
	    $no = $_POST['start'];
	    foreach ($list as $post)
	    {
	      $no++;
	      $row = array();
	      // APPEND HTML FOR ACTION
	      $row[] = ucfirst($post->owner);
	      $row[] = $post->saleorder_id;
	      $row[] = $post->purchaseorder_id;
	      $row[] = $post->subject;
	      $row[] = intval($post->after_discount);
	      $row[] = intval($post->after_discount_po);
	      $row[] = $post->total_orc;
	      $calc = intval($post->after_discount) - intval($post->after_discount_po) - intval($post->total_orc);
	      $row[] = intval($calc);
	      $data[] = $row;
	    }
	    $output = array(
	      "draw" => $_POST['draw'],
	      "recordsTotal" => $this->Reports_model->count_all_pro(),
	      "recordsFiltered" => $this->Reports_model->count_filtered_pro(),
	      "data" => $data,
	    );
	    //output to json format
	    echo json_encode($output);
  	}


//######## Function to send mail auto backup of database....############
public function sentMailAtt(){
	//set up email
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
          $this->email->to('dev2@team365.io');
          $this->email->subject('Salesorder Progress');
          $this->email->set_mailtype('html');
		  $output .='test Att Mail 12 3 12';
		  $this->email->message($output);
			// Database configuration
			$host = "localhost";
			$username = "root";
			$password = "";
			$database_name = "admintea_team365";
			// Get connection object and set the charset
			$conn = mysqli_connect($host, $username, $password, $database_name);
			$conn->set_charset("utf8");
			// Get All Table Names From the Database
			$tables = array();
			$sql = "SHOW TABLES";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_row($result)) {
				$tables[] = $row[0];
			}
			$sqlScript = "";
			foreach ($tables as $table) {
				// Prepare SQLscript for creating table structure
				$query = "SHOW CREATE TABLE $table";
				$result = mysqli_query($conn, $query);
				$row = mysqli_fetch_row($result);
				$sqlScript .= "\n\n" . $row[1] . ";\n\n";
				$query = "SELECT * FROM $table";
				$result = mysqli_query($conn, $query);
				$columnCount = mysqli_num_fields($result);
				// Prepare SQLscript for dumping data for each table
				for ($i = 0; $i < $columnCount; $i ++) {
					while ($row = mysqli_fetch_row($result)) {
						$sqlScript .= "INSERT INTO $table VALUES(";
						for ($j = 0; $j < $columnCount; $j ++) {
							$row[$j] = $row[$j];
							if (isset($row[$j])) {
								$sqlScript .= '"' . $row[$j] . '"';
							} else {
								$sqlScript .= '""';
							}
							if ($j < ($columnCount - 1)) {
								$sqlScript .= ',';
							}
						}
						$sqlScript .= ");\n";
					}
				}
				$sqlScript .= "\n"; 
			}
	if(!empty($sqlScript))
	{
		$backup_file_name = $database_name . '_backup_'.date('Y-m-d H i s').'.sql';
		$fileHandler = fopen($backup_file_name, 'w+');
		$number_of_lines = fwrite($fileHandler, $sqlScript);
		fclose($fileHandler);
	}
	$this->email->attach($backup_file_name);
	if(!$this->email->send()){}
	
}








// Please write code above this  
}
