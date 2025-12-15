<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Organizations extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Organization_model','Organization');
    $this->load->model('Contact_model','Contact');
    $this->load->model('Login_model');
	$this->load->library('excel');
	if(checkModuleForContr('Create Customers')<1){
	    redirect('home');
	}
  }
  public function index()
  { 
    if(!empty($this->session->userdata('email')))
    {
		if(check_permission_status('Customer','retrieve_u')==true){
			$data['countOrg']=$this->Organization->count_all();
			$data['countContact']=$this->Contact->count_all();
			 $data['user'] = $this->Login_model->getusername();
      $data['admin'] = $this->Login_model->getadminname();
			
			$this->load->view('essentials/organization',$data);
		}else{
			redirect("permission");
		}
    }else{
      redirect('login');
    }
  }
  
  public function count_all(){
	$countContact=$this->Organization->count_all();
	echo $countContact;	
  }
  
  public function ajax_list()
  {
	  
	$delete_org	=0;
	$update_org	=0;
	$retrieve_org=0;

	if(check_permission_status('Customer','delete_u')==true){
		$delete_org=1;
	}
	if(check_permission_status('Customer','retrieve_u')==true){
		$retrieve_org=1;
	}
	if(check_permission_status('Customer','update_u')==true){
		$update_org=1;
	}	
	  
    $list 	= $this->Organization->get_datatables();
    $data 	= array();
    $no 	= $_POST['start'];
    $dataAct=$this->input->post('actDate');
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      if($delete_org==1) { 
          if($dataAct!='actdata'){
          // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
           $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'" onclick="showAction(' . $post->id . ')">';
          }
      }
	  //onclick="view('."'".$post->id."'".')";
      $first_row = "";
      $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
            
        </div>
    </div>";
      $first_row.= $post->org_name.'<!--<div class="links">';
      if($retrieve_org==1):
        $first_row.= '<a style="text-decoration:none" href="'.base_url().'view-customer/'.$post->id.'"  class="text-success">View</a>|';
      endif;
      if($update_org==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary">Update</a>|';
      endif;
      if($delete_org==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_org('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      $row[] = '<a style="text-decoration:none" href="'.base_url().'view-customer/'.$post->id.'">' . $companydetail . '</a>';
      if($post->customer_type=='Both'){
        $row[] = 'Customer & Vendor'; 
      }else{
        $row[] = $post->customer_type;  
      }
      $row[] = $post->email;
      $row[] = $post->website;
      $row[] = $post->mobile;
      $row[] = $post->billing_city;
	  
	  $action='<div class="row" style="font-size: 15px;">';
			if($retrieve_org==1){
				$action.='<a style="text-decoration:none" href="'.base_url().'view-customer/'.$post->id.'"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Customer Details" ></i></a>';
			}
			
			 if($this->session->userdata('type') == 'admin') {
    			if($update_org==1){
    				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary border-right">
    					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Customer Details" ></i></a>';
    			}
			 }
			
			if($delete_org==1){	
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_org('."'".$post->id."'".')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Customer" ></i></a>';
			}
			$action.='</div>';
           
			$row[]=$action; 
	  
	  
      $data[] = $row;
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
  
  
  
  public function view_customer()
  { 
  
  
    if(!empty($this->session->userdata('email')))
    {
		if(check_permission_status('Customer','retrieve_u')==true){
			$id				= $this->uri->segment(2);
			$data['record'] = $this->Organization->get_by_id_view($id);
			$ArrOrg=array('org_name'=>$data['record']['org_name']);
			$data['contact'] 	 = $this->Contact->getContacts($ArrOrg);
			$data['leads']  	 = $this->Organization->get_leads($data['record']['org_name']);
			$data['opportunity'] = $this->Organization->get_opportunity($data['record']['org_name']);
			$data['quotation'] 	 = $this->Organization->get_quotation($data['record']['org_name']);
			$data['salesorder']  = $this->Organization->get_sales_order($data['record']['org_name']);
			
			//$data['users_data']  = $this->Organization->get_user();
			$this->load->model('Activity_model','Activity');
			$data['users_data']  	= $this->Activity->get_user();
			$data['users_data_ad']  = $this->Activity->get_admin_user();
			
			$data['activityCust']  	= $this->Activity->get_customer_activity($id);
			
			$this->load->view('essentials/view-customer',$data);
		}else{
			redirect("permission");
		}
    }else{
      redirect('login');
    }
  }
  
  
  public function create()
  {
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
		
      $customer 		= "Customer";
      $sess_eml 		= $this->session->userdata('email');
      $session_company 	= $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $contact_name_batch = $this->input->post('contact_name_batch');
      $email_batch 		= $this->input->post('email_batch');
      $phone_batch 		= $this->input->post('phone_batch');
      $mobile_batch 	= $this->input->post('mobile_batch');
      $org_name 		= $this->input->post('org_name');
      $cust_types 		= $this->input->post('cust_types');
      $website 			= $this->input->post('website');
      $assigned_to 		= $this->input->post('assigned_to');
      $sla_name 		= $this->input->post('sla_name');
      $billing_country 	= $this->input->post('billing_country');
      $billing_state 	= $this->input->post('billing_state');
      $shipping_country = $this->input->post('shipping_country');
      $shipping_state 	= $this->input->post('shipping_state');
      $billing_city 	= $this->input->post('billing_city');
      $billing_zipcode 	= $this->input->post('billing_zipcode');
      $shipping_city 	= $this->input->post('shipping_city');
      $shipping_zipcode = $this->input->post('shipping_zipcode');
      $billing_address 	= $this->input->post('billing_address');
      $shipping_address = $this->input->post('shipping_address');
      $description 		= $this->input->post('description');
      $currentdate 		= date("y.m.d");
	  
	  $orgData=$this->Organization->check_org($org_name,$this->input->post('email'));
	if($orgData==202){
		 echo json_encode(array("status" => 'Data exist'));
		 exit;
	}else{
      $data = array(
        'sess_eml' => $sess_eml,
        'session_company' 	=> $session_company,
        'session_comp_email'=> $session_comp_email,
        'org_name' 			=> $org_name,
        'customer_type' 	=> $cust_types,
        'ownership' 		=> $this->input->post('ownership'),
        'primary_contact' 	=> $this->input->post('primary_contact'),
        'email' 			=> $this->input->post('email'),
        'website' 			=> $website,
        'office_phone' 		=> $this->input->post('office_phone'),
        'mobile' 			=> $this->input->post('mobile'),
        'employees' 		=> $this->input->post('employees'),
        'industry' 			=> $this->input->post('industry'),
        'assigned_to' 		=> $assigned_to,
        'annual_revenue' 	=> $this->input->post('annual_revenue'),
        'type' 				=> $this->input->post('type'),
        'region' 			=> $this->input->post('region'),
        'sic_code' 			=> $this->input->post('sic_code'),
        'sla_name' 			=> $sla_name,
        'gstin' 			=> $this->input->post('gstin'),
        'panno' 			=> $this->input->post('panno'),
        'billing_country' 	=> $billing_country,
        'billing_state' 	=> $billing_state,
        'shipping_country' 	=> $shipping_country,
        'shipping_state' 	=> $shipping_state,
        'billing_city' 		=> $billing_city,
        'billing_zipcode' 	=> $billing_zipcode,
        'shipping_city' 	=> $shipping_city,
        'shipping_zipcode' 	=> $shipping_zipcode,
        'billing_address' 	=> $billing_address,
        'shipping_address' 	=> $shipping_address,
        'description' 		=> $description,
        'currentdate' 		=> $currentdate,
      );
      
    //     $sess_admin_email = $this->session->userdata('email');
    //     $this->db->select('*');
    //     $this->db->from('organization');
    //     $this->db->where('sess_eml',$sess_admin_email);
    //     $countcust = $this->db->count_all_results();
    //     $sessiondata = $this->session->userdata($sess_data);
    //     $sessionaccount_type = $this->session->userdata('account_type');
    //     // print_r($countcust);
    //     // echo '<pre>';print_r($sessiondata);die;
    //   if($countcust <= 5 && $sessionaccount_type == 'Trial'){
    //       $org_id 		= $this->Organization->create($data);
	   //   $organization_id=updateid($org_id,'organization','organization_id');
    //   }else{
    //       echo "You can't create above 5 users";
    //       exit;
    //   }
    //   if($sessionaccount_type == 'Paid'){
          $org_id 		= $this->Organization->create($data);
	      $organization_id=updateid($org_id,'organization','organization_id');
    //   }
      
	   //$org_id 		= $this->Organization->create($data);
	   //$organization_id=updateid($org_id,'organization','organization_id');
	
      $primary_contact = array(
        'sess_eml' 			=> $sess_eml,
        'session_company' 	=> $session_company,
        'session_comp_email'=> $session_comp_email,
        'contact_owner' 	=> $this->input->post('ownership'),
        // 'name' 				=> $org_name,
        'name'              => $this->input->post('primary_contact'),
        'org_id' 			=> $org_id,
        'org_name' 			=> $org_name,
        'email' 			=> $this->input->post('email'),
        'website' 			=> $website,
        'office_phone' 		=> $this->input->post('office_phone'),
        'mobile' 			=> $this->input->post('mobile'),
        'assigned_to' 		=> $assigned_to,
        'sla_name' 			=> $sla_name,
        'contact_type' 		=> $cust_types,
        'billing_country' 	=> $billing_country,
        'billing_state' 	=> $billing_state,
        'shipping_country' 	=> $shipping_country,
        'shipping_state' 	=> $shipping_state,
        'billing_city' 		=> $billing_city,
        'billing_zipcode' 	=> $billing_zipcode,
        'shipping_city' 	=> $shipping_city,
        'shipping_zipcode' 	=> $shipping_zipcode,
        'billing_address' 	=> $billing_address,
        'shipping_address' 	=> $shipping_address,
        'description' 		=> $description,
        'currentdate' 		=> $currentdate,
      );
      
      $id = $this->Contact->primary_contact($primary_contact);
      updateid($id,'contact','contact_id');
      
      if(!empty($contact_name_batch))
      {
            $this->Contact->contact_batch($sess_eml,$session_company,$session_comp_email,$contact_name_batch,$org_id,$org_name,$email_batch,$website,$phone_batch,$mobile_batch,$assigned_to,$sla_name,$customer,$billing_country,$billing_state,$shipping_country,$shipping_state,$billing_city,$billing_zipcode,$shipping_city,$shipping_zipcode,$billing_address,$shipping_address,$description,$currentdate);
        $x = "100";
        $id = $this->db->insert_id();
        updateid($id,'contact','contact_id');
        echo json_encode(array("status" => TRUE));
      }
      else
      {
        echo json_encode(array("status" => FALSE));
      }
	  
		if($org_id){ 
			$workFlowStsAdmin	= check_workflow_status('Admin','Mail notification on customer created');
			$workFlowStsAdminVnr= check_workflow_status('Admin','Mail notification on vendor created');
			$workFlowStsStsUser	= check_workflow_status('Customer','Mail notification to customer owner on created');
			$permissionSts		= check_permission_status('Receive email on create customer','other');
			$workFlowTocuto		= check_workflow_status('Customer','Welecome mail on created');  
			$workFlowToVend		= check_workflow_status('Vendor','Welecome mail on created');  
			if($workFlowTocuto==true && $cust_types=='Customer'){
				$this->sendEmailToCust($this->input->post('primary_contact'),$org_name,$this->input->post('email'));
			}
			if($workFlowToVend==true && $cust_types=='Vendor'){
				$this->sendEmailToCust($this->input->post('primary_contact'),$org_name,$this->input->post('email'));
				$messageVendor='';
				$messageVendor.='<div class="f-fallback">
							<center> <h1>Welcome our new supplier</h2> </center>
							<h3>Dear Mr,/Mrs.,</h3>';
				$messageVendor.='<p>We would like to welcome you as a supplier to our Company. We have a high demand for quality and no tolerance for error. Based on our research, that, also describes your firm. We are glad to be doing business with you.</p>';
				$messageVendor.='<p>'.$this->input->post('primary_contact').' will be your primary contact for all incoming materials and orders. if you have a question about payment, contact in our accounting office. HE/SHE will help you sort the matter out.</p>';
				$messageVendor.='<p>Again, welcome aboard. If there is anything we can do to help facilitate this new relationship, please donot hesitate to ask.</p>';
				$messageVendor.='</div>';
				$subEmail='Welcome our new supplier - '.$this->session->userdata('company_name');			
				sendMailWithTemp($emailto,$messageVendor,$subEmail);	
			}
		
			if($permissionSts==true && $workFlowStsStsUser==true){
				$messageBody='';
				$subjectLine="A new customer added by you - team365 | CRM";
				$messageBody.='<div class="f-fallback">
					<h1>Dear , '.ucwords($this->session->userdata('name')).'!</h1>';
				$messageBody.='<p>You just created a new customer from team365 | CRM</p>';
				$messageBody.='<p>Your customer detail are given bellow:-</p>';
				$messageBody.='<p>Customer Org Name : '.$org_name.'</p>';
				$messageBody.='<p>
					Contact  Name : '.$this->input->post('primary_contact').'
					<br>
					Email Address : '.$this->input->post('email').'
					<br>
					Contact No. : '.$this->input->post('mobile').'
					<br>
					Billing Address : '.$billing_address.', '.$billing_city.', '.$billing_state.' - '.$billing_zipcode.', '.$billing_country.'
					<br>
					Shipping Address : '.$shipping_address.', '.$shipping_city.', '.$shipping_state.' - '.$shipping_zipcode.', '.$shipping_country.'
					</p>
					</div>';
				sendMailWithTemp($this->session->userdata('email'),$messageBody,$subjectLine);
			}  
			  
			 /*  SEND TO ADMIN  */
			if($workFlowStsAdmin==true && $cust_types=='Customer'){ 
				$messagetoAdmin='';
				$subjectAdmin="A new customer created - team365 | CRM";
				$messagetoAdmin.='<div class="f-fallback">
					<h1>Dear , Admin!</h1>';
				$messagetoAdmin.='<p>A new customer "'.$this->input->post('name').'", Created.</p>';
				$messagetoAdmin.='<p>Customer detail:-</p>';
				$messageBody.='<p>Customer Org Name : '.$org_name.'</p>';
				$messageBody.='<p>
					Contact  Name : '.$this->input->post('primary_contact').'
					<br>
					Email Address : '.$this->input->post('email').'
					<br>
					Contact No. : '.$this->input->post('mobile').'
					<br>
					Billing Address : '.$billing_address.', '.$billing_city.', '.$billing_state.' - '.$billing_zipcode.', '.$billing_country.'
					<br>
					Shipping Address : '.$shipping_address.', '.$shipping_city.', '.$shipping_state.' - '.$shipping_zipcode.', '.$shipping_country.'
					</p>';
				$messagetoAdmin.='<p>
					customer created by  : '.$this->session->userdata('name').'
					</p>';
				$messagetoAdmin.='</div>';
				sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);
			}
		
			if($workFlowStsAdminVnr==true && $cust_types=='Vendor'){ 
				$messagetoAdmin='';
				$subjectAdmin="A new vendor added - team365 | CRM";
				$messagetoAdmin.='<div class="f-fallback">
					<h1>Dear , Admin!</h1>';
				$messagetoAdmin.='<p>A new vendor "'.$this->input->post('name').'", added.</p>';
				$messagetoAdmin.='<p>Vendor detail:-</p>';
				$messageBody.='<p>Vendor Name : '.$org_name.'</p>';
				$messageBody.='<p>
					Contact  Name : '.$this->input->post('primary_contact').'
					<br>
					Email Address : '.$this->input->post('email').'
					<br>
					Contact No. : '.$this->input->post('mobile').'
					<br>
					Billing Address : '.$billing_address.', '.$billing_city.', '.$billing_state.' - '.$billing_zipcode.', '.$billing_country.'
					<br>
					Shipping Address : '.$shipping_address.', '.$shipping_city.', '.$shipping_state.' - '.$shipping_zipcode.', '.$shipping_country.'
					</p>';
				$messagetoAdmin.='<p>
					customer created by  : '.$this->session->userdata('name').'
					</p>';
				$messagetoAdmin.='</div>';
				sendMailWithTemp($this->session->userdata('company_email'),$messagetoAdmin,$subjectAdmin);
			}
			
		}
	
	}
	  
	  
    }
  }
  
  
  
  public function sendEmailToCust($contactName,$orgName,$emailto){
	  $messageBody='';
					$messageBody.='<div class="f-fallback">
					<center>
						<h1>Welcome to '.$this->session->userdata('company_name').'</h2>
					</center>
                    <h1>Hi, '.ucwords($orgName).'!</h1>';
                    $messageBody.='<p>We are excited to have you as part of our customer.
								Customer is a lifelong journey and we look forward to helping you start yours.</p>';
					$messageBody.='<p>As a customer of '.$this->session->userdata('company_name').', you will enjoy many unique benefits. Please attend our upcoming customer meeting so we can explain these benefits and how you can get involved.</p>';
        			$messageBody.='<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
        			$messageBody.='<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>';
					$messageBody.='</div>';
		$subEmail='Thank you for your interest! - '.$this->session->userdata('company_name');			
        sendMailWithTemp($emailto,$messageBody,$subEmail);	
     
  }
  
  
  
  public function getbyId($id)
  {
    $data = $this->Organization->get_by_id($id);  
    echo json_encode($data);
  }
  public function update()
  {
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }
    else
    {
      //$customer = "Customer";
      $data = array(
        'org_name'          => $this->input->post('org_name'),
        'customer_type'     => $this->input->post('cust_types'),
        'primary_contact'   => $this->input->post('primary_contact'),
        'email'             => $this->input->post('email'),
        'website'           => $this->input->post('website'),
        'office_phone'      => $this->input->post('office_phone'),
        'mobile'            => $this->input->post('mobile'),
        'employees'         => $this->input->post('employees'),
        'industry'          => $this->input->post('industry'),
        'assigned_to'       => $this->input->post('assigned_to'),
        'annual_revenue'    => $this->input->post('annual_revenue'),
        'type'              => $this->input->post('type'),
        'region'            => $this->input->post('region'),
        'sic_code'          => $this->input->post('sic_code'),
        'sla_name'          => $this->input->post('sla_name'),
        'gstin'             => $this->input->post('gstin'),
        'panno' 	        => $this->input->post('panno'),
        'billing_country'   => $this->input->post('billing_country'),
        'billing_state'     => $this->input->post('billing_state'),
        'shipping_country'  => $this->input->post('shipping_country'),
        'shipping_state'    => $this->input->post('shipping_state'),
        'billing_city'      => $this->input->post('billing_city'),
        'billing_zipcode'   => $this->input->post('billing_zipcode'),
        'shipping_city'     => $this->input->post('shipping_city'),
        'shipping_zipcode'  => $this->input->post('shipping_zipcode'),
        'billing_address'   => $this->input->post('billing_address'),
        'shipping_address'  => $this->input->post('shipping_address'),
        'description'       => $this->input->post('description'),
                              
      );
	 
     if($this->session->userdata('type')=='admin'){
        $data['ownership'] = $this->input->post('ownership');
        $this->Organization->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
       }
      else{

      $this->Organization->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
      }
        
        // $contact_name_batch = $this->input->post('contact_name_batch');
        // $email_batch = $this->input->post('email_batch');
        // $phone_batch = $this->input->post('phone_batch');
        // $mobile_batch = $this->input->post('mobile_batch');
        
    //     $cid   =   $this->input->post('cid');
    //   for($i=0; $i < count($contact_name_batch); $i++)
	   //{
	   //       $id = $cid[$i];
	   //       $data2 = array(
    //              'name' =>  $contact_name_batch[$i],
    //              'email' =>  $email_batch[$i],
    //              'office_phone' => $phone_batch[$i],
    //              'mobile' =>  $mobile_batch[$i]
    //           );
        
	   //     $this->Contact->vendorupdate(array('id' => $id,'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data2);
	   //}
	   
      echo json_encode(array("status" => TRUE));
    }
  }
  public function delete($id)
  {
    $this->Organization->delete($id);
    echo json_encode(array("status" => TRUE));
  }
  
  
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $data=$this->Organization->get_org_data($id[$count]);  
        $orgName=$data[0]->org_name; 
        //echo $orgName;
        $dataArr=array('delete_status'=>2);
        $this->Organization->deleteContact($dataArr,$orgName); 
        $this->Organization->delete_bulk($id[$count]);
        
        
      }
    }
  }
  
  
  public function autocomplete_org()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    if (isset($_GET['term'])) {
      $result = $this->Organization->get_org_name($_GET['term'],$sess_eml,$session_company,$session_comp_email);
      if (count($result) > 0)
      {
        foreach ($result as $row)
        $arr_result[] = array(
          'label'   => $row->org_name,
          );
        echo json_encode($arr_result);
      }
      else
      {
        $arr_result[] = array(
          'label'   => "No Organizations Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  public function get_org_details()
  {
    $org_name = $this->input->post();
    $data = $this->Organization->getOrgValue($org_name);
    echo json_encode($data);
  }
  public function getcontactById($id)
  {
    $org_name = $this->Organization->OrgForCon($id);
    $result = $this->Organization->getByOrg($org_name);
    echo json_encode($result);
  }
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    if($this->input->post('save_method') == 'add' || $this->input->post('save_method') == 'add_org')
    {
        $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
    }
    $this->form_validation->set_rules('cust_types', 'Customer Type', 'required|trim');
    $this->form_validation->set_rules('primary_contact', 'Primary Contact', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]|trim');
    $this->form_validation->set_rules('billing_country', 'Billing Country', 'required|trim');
    $this->form_validation->set_rules('billing_state', 'Billing State', 'required|trim');
    $this->form_validation->set_rules('shipping_country', 'Shipping Country', 'required|trim');
    $this->form_validation->set_rules('shipping_state', 'Shipping State', 'required|trim');
    $this->form_validation->set_rules('billing_city', 'Billing City', 'required|trim');
    $this->form_validation->set_rules('billing_zipcode', 'Billing Zipcode', 'required|trim');
    $this->form_validation->set_rules('shipping_zipcode', 'Shipping Zipcode', 'required|trim');
    $this->form_validation->set_rules('shipping_city', 'Shipping City', 'required|trim');
    $this->form_validation->set_rules('billing_address', 'Billing Address', 'required|trim');
    $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');
    $this->form_validation->set_message('valid_email', '%s is not valid');
    $this->form_validation->set_message('regex_match','%s is invalid');
    if ($this->form_validation->run() == FALSE)
    {
      return json_encode(array('st'=>202, 'org_name'=> form_error('org_name'), 'cust_types'=> form_error('cust_types'), 'primary_contact'=> form_error('primary_contact'),'email'=> form_error('email'), 'mobile'=> form_error('mobile'),  'billing_country'=> form_error('billing_country'), 'billing_state'=> form_error('billing_state'), 'shipping_country'=> form_error('shipping_country'),'shipping_state'=> form_error('shipping_state'), 'billing_city'=> form_error('billing_city'), 'billing_zipcode'=> form_error('billing_zipcode'), 'shipping_city'=> form_error('shipping_city'), 'shipping_zipcode'=> form_error('shipping_zipcode'), 'billing_address'=> form_error('billing_address'), 'shipping_address'=> form_error('shipping_address')));
    }
    else
    {
      return 200;
    }
  }
  public function check_org()
  {
      if($this->Organization->check_org($_POST['org_name']) == 202)
      {
        echo '<span style="color:red;font-size:10px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Duplicate Entry</span>';
        echo "<script>$('#btnSave').prop('disabled',true);</script>";
      }
      else
      {
        echo "<script>$('#btnSave').prop('disabled',false);</script>";
      } 
  }


public function import()
{
	  $this->load->library('csvimport');
	
	if(check_permission_status('Customer','create_u')==true){
    if(isset($_FILES["file"]["name"]))
    {  
      $duplicate_array = array();
	  $message_array = array();
	  $file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);
		foreach($file_data as $row)
		{
		  $customer 		= "Customer";
          $org_name 		= $row["org_name"];
          $primary_contact 	= $row["primary_contact"];
          $email 			= $row["email"];
          $website 			= $row["website"];
          $office_phone 	= $row["office_phone"];
          $mobile 			= $row["mobile"];
          $employees 		= $row["employees"];
          $industry 		= $row["industry"];
          $annual_revenue 	= $row["annual_revenue"];
          $ownership 		= $row["ownership"];
          $type 			= $row["type"];
          $assigned_to 		= $row["assigned_to"];
          $sic_code 		= $row["sic_code"];  
          $sla_name 		= $row["sla_name"];  
          $region 			= $row["region"];  
          $gstin 			= $row["gstin"];  
          $billing_country 	= $row["billing_country"];
          $shipping_country = $row["shipping_country"];  
          $billing_city 	= $row["billing_city"];  
          $shipping_city 	= $row["shipping_city"];  
          $billing_state 	= $row["billing_state"];  
          $shipping_state 	= $row["shipping_state"];  
          $billing_zipcode 	= $row["billing_zipcode"];  
          $shipping_zipcode = $row["shipping_zipcode"];  
          $billing_address 	= $row["billing_address"];  
          $shipping_address = $row["shipping_address"];  
          $description 		= $row["description"];
          	if($row["name"]!=""){  
				$contact_name_batch   = $row["name"];
			}else{
				$contact_name_batch   = $row["primary_contact"];
			}
          $email_batch 		    = $row["email_id"];
          $phone_batch 		    = $row["office phone"];
          $mobile_batch 		= $row["mobile_no"];
          
          
          $currentdate 		= date('Y-m-d');  
          $delete_status 	= 1;  
		  
		  if($website==""){ $website='';  }
		  if($office_phone==""){ $office_phone='';}
		  if($employees==""){ $employees=''; }
		  if($annual_revenue==""){ $annual_revenue='';}
		  if($ownership==""){ $ownership='';}
		  if($assigned_to==""){$assigned_to='';}
		  if($sic_code==""){ $sic_code='';}
		  if($sla_name==""){ $sla_name='';}
		  if($gstin==""){ $gstin='';}
		  if($description==""){ $description='';}
          
          $dataArr = array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'org_name'   		=> $org_name,
            'customer_type'    	=> $customer,
            'primary_contact' 	=> $primary_contact,
            'email'  			=> $email,
            'website'   		=> $website,
            'office_phone'   	=> $office_phone,
            'mobile'   			=> $mobile,
            'employees'   		=> $employees,
            'industry'  		=> $industry,
            'annual_revenue'   	=> $annual_revenue,
            'ownership'   		=> $ownership,
            'type'  			=> $type,
            'assigned_to'  		=> $assigned_to,
            'sic_code'  		=> $sic_code,
            'sla_name'  		=> $sla_name,
            'region'  			=> $region,
            'gstin'  			=> $gstin,
            'billing_country'  	=> $billing_country,
            'shipping_country'  => $shipping_country,
            'billing_city'  	=> $billing_city,
            'shipping_city'  	=> $shipping_city,
            'billing_state'  	=> $billing_state,
            'shipping_state'  	=> $shipping_state,
            'billing_zipcode'  	=> $billing_zipcode,
            'shipping_zipcode'  => $shipping_zipcode,
            'billing_address'  	=> $billing_address,
            'shipping_address'  => $shipping_address,
            'description'  		=> $description,
            'currentdate'  		=> $currentdate,
            'delete_status'  	=> $delete_status
          );
       //echo $dataArr; exit;
	
		  
          if(empty($email_batch)){
			  $email_batch=$email;
		  }
		  if(empty($phone_batch)){
			  $phone_batch=$office_phone;
		  }
		  if(empty($mobile_batch)){
			  $mobile_batch=$mobile;
		  }
		  
		 if(empty($org_name) || empty($primary_contact) || empty($email) || empty($mobile) || empty($type) ||  empty($billing_country) || empty($billing_state) || empty($billing_city) || empty($billing_zipcode) || empty($billing_address) || empty($shipping_country) || empty($shipping_state) || empty($shipping_city) || empty($shipping_zipcode) || empty($shipping_address) )
			{
			  echo json_encode(array('st'=> 202, 'msg'=> 'Import Failed All Fields Are Required'));
			 
			  
			}else if(!empty($primary_contact) && !empty($org_name))
			{
				 
				$result = $this->Organization->check_duplicate_org_name($primary_contact,$org_name,$email);
				
				if(!empty($result)){ 
					array_push($duplicate_array, $result);
				}else{
					$id 			= $this->Organization->create($dataArr);
					$organization_id=updateid($id,'organization','organization_id');
					$primaryContact = array(
						'sess_eml' 			=> $this->session->userdata('email'),
						'session_company' 	=> $this->session->userdata('company_name'),
						'session_comp_email'=> $this->session->userdata('company_email'),
						'contact_owner' 	=> $this->session->userdata('name'),
						'name' 				=> $contact_name_batch,
						'org_name' 			=> $org_name,
						'org_id' 			=> $id,
						'email' 			=> $email_batch,
						'website' 			=> $website,
						'office_phone'		=> $phone_batch,
						'mobile' 			=> $mobile_batch,
						'assigned_to' 		=> $assigned_to,
						'sla_name' 			=> $sla_name,
						'contact_type' 		=> $customer,
						'billing_country' 	=> $billing_country,
						'billing_state' 	=> $billing_state,
						'shipping_country' 	=> $shipping_country,
						'shipping_state'	=> $shipping_state,
						'billing_city' 		=> $billing_city,
						'billing_zipcode' 	=> $billing_zipcode,
						'shipping_city' 	=> $shipping_city,
						'shipping_zipcode' 	=> $shipping_zipcode,
						'billing_address' 	=> $billing_address,
						'shipping_address' 	=> $shipping_address,
						'description' 		=> $description,
						'currentdate' 		=> $currentdate
					);
					   
					   $cid = $this->Contact->primary_contact($primaryContact);
					   $contact_id=updateid($cid,'contact','contact_id');
					   
					   $message_array=array('st'=> 200, 'msg'=> 'Data Imported Successfully');
				}
			}
		
		}//	
        
     
	  
	  if(count($duplicate_array)>0){
			echo json_encode($duplicate_array);
	  }else{
		   echo json_encode($message_array);
	  }
	}
      
    } 
  }
  
  
  public function send_email(){
	  $orgName		= $this->input->post('orgName');
	  $orgEmail		= $this->input->post('orgEmail');
	  $ccEmail		= $this->input->post('ccEmail');
	  $subEmail		= $this->input->post('subEmail');
	  $descriptionTxt=$this->input->post('descriptionTxt');
    $messageBody='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                <a href="https://team365.io/" class="f-fallback email-masthead_name">';
				$image = $this->session->userdata('company_logo');
				if(!empty($image))
				{ $messageBody .=  '<img  src="'.base_url().'/uploads/company_logo/'.$image.'">'; }
				else {
					$messageBody .=  '<span class="h5 text-primary">'.$this->session->userdata('company_name').'</span>';
				}
		$messageBody.='</a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">';
                         $messageBody.=$descriptionTxt;
                      $messageBody.='</div>
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
                      <p class="f-fallback sub align-center">&copy; '.date("Y").' '.$this->session->userdata('company_name').'. All rights reserved</p>
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
	$this->load->library('email_lib');
     if(!$this->email_lib->send_email($orgEmail,$subEmail,$messageBody,$ccEmail)){
		echo "0";
	}else{
		echo "1";
	}
	  
  }
  
  
  
	public function add_mass()
	{
		if ($this->input->is_ajax_request()) {

      $mass_id = $this->input->post('mass_id');
      $mass_name = $this->input->post('mass_name');
      $mass_value = $this->input->post('mass_value');
			$dataArry = array(
				$mass_name => $mass_value,
				'currentdate' => date('Y-m-d')
				
			);
        // print_r($dataArry);die;
			$mass_data = $this->Organization->mass_save($mass_id, $dataArry);
			if (!empty($mass_data)) {
				$response = array(
					'success' => true,
					'message' => 'Mass Update Successfully'
				);
				echo json_encode($response);
			} else {
				$response = array(
					'success' => false,
					'message' => 'Mass Update Failed'
				);
				echo json_encode($response);
			}
		} else {
			echo "Invalid request";
		}
	}
  


// Please write code above this  
}
?>
