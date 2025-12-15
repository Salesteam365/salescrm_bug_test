<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendors extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Vendors_model','Vendors');
    $this->load->model('Country_model','Country');
    $this->load->model('Contact_model','Contact');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
		if(check_permission_status('Vendor','retrieve_u')==true){	
			$this->load->view('inventory/vendors');
		}else{
			redirect('permission');
		}
	  
    }
    else
    {
      redirect('login');
    }
  }
  public function ajax_list()
  {
	$delete_vendor	=0;
	$update_vendor	=0;
	$retrieve_vendor=0; 
	if(check_permission_status('Vendor','delete_u')==true){
		$delete_vendor=1;
	}
	if(check_permission_status('Vendor','retrieve_u')==true){
		$retrieve_vendor=1;
	}
	if(check_permission_status('Vendor','update_u')==true){
		$update_vendor=1;
	}
	   
    $list = $this->Vendors->get_datatables();
    $data = array();
    $no   = $_POST['start'];
    $dataAct=$this->input->post('actDate');
   
        foreach ($list as $post)
        {
          $no++;
          $row = array();
          // APPEND HTML FOR ACTION
          if($delete_vendor==1) { 
              if($dataAct!='actdata'){
            $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
              }
          }
          $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
           
        </div>
    </div>";
          $first_row = "";
          $first_row.= ucwords($post->org_name).'<!--<div class="links">';
          if($retrieve_vendor==1):
            $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-success">View</a>|';
          endif;
          if($update_vendor==1):
            $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary">Update</a>|';
          endif;
          if($delete_vendor==1):
            $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_org('."'".$post->id."'".')" class="text-danger">Delete</a>';
          endif;
          $first_row.= '</div>-->';
          $row[] = $companydetail ;
          if($post->customer_type=='Both'){
            $row[] = 'Customer & Vendor'; 
          }else{
            $row[] = $post->customer_type;  
          }
          $row[] = $post->email;
          $row[] = $post->mobile;
          $row[] = ucfirst($post->ownership);
          $row[] = ucfirst($post->assigned_to);
		  
		  $action='<div class="row" style="font-size: 15px;">';
			if($retrieve_vendor==1){
				//$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')"   class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Vendor Details" ></i></a>';
				
				$action.='<a style="text-decoration:none" href="'.base_url().'view-vendor/'.$post->id.'"   class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Vendor Details" ></i></a>';
			}
			if($update_vendor==1){
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary border-right">
					<i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Vendor Details" ></i></a>';
			}	
			
			if($delete_vendor==1){	
				$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_org('."'".$post->id."'".')"  class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Vendor" ></i></a>';
			}
			$action.='</div>';
           
			$row[]=$action; 
		  
          $data[] = $row;
        }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Vendors->count_all(),
      "recordsFiltered" => $this->Vendors->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  
	public function view_vendor(){
		if(!empty($this->session->userdata('email')))
		{
			if(check_permission_status('Vendor','retrieve_u')==true){
				$id				 = $this->uri->segment(2);
				$data['record']  = $this->Vendors->get_vendor_by_id($id);
				$ArrOrg=array('org_name'=>$data['record']['org_name']);
				$data['contact'] = $this->Contact->getContacts($ArrOrg);
				$data['purchase']= $this->Vendors->get_purchase_order($data['record']['org_name']);
				$this->load->view('inventory/view-vendor',$data);
			}else{
				redirect("permission");
			}
		}else{
		  redirect('login');
		}
	}
  
  
  public function getbyId($id)
  {
    $data = $this->Vendors->get_by_id($id);
    echo json_encode($data);
  }
  public function getcontactById($id)
  {
    $name = $this->Vendors->VenForCon($id);
    $data = $this->Vendors->getByVen($name);
    echo json_encode($data);
  }
  public function create()
  {
    $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }else
    {
      $sess_eml = $this->session->userdata('email');
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $name = $this->input->post('name');
      $contact_name_batch = $this->input->post('contact_name_batch');
      $email_batch = $this->input->post('email_batch');
      $phone_batch = $this->input->post('phone_batch');
      $mobile_batch = $this->input->post('mobile_batch');
      $website = $this->input->post('website');
      $asigned_to = $this->input->post('asigned_to');
      $contact_type = "Vendor";
      $country = $this->input->post('country');
      $state = $this->input->post('state');
      $city = $this->input->post('city');
      $zipcode = $this->input->post('zipcode');
      $address = $this->input->post('address');
      $description = $this->input->post('description');
      $currentdate = date("y.m.d");
      $data = array(
        'sess_eml' => $sess_eml,
        'session_company' => $session_company,
        'session_comp_email' => $session_comp_email,
        'name' => $name,
        'created_by' => $this->input->post('created_by'),
        'email' => $this->input->post('email'),
        'mobile' => $this->input->post('mobile'),
        'office_phone' => $this->input->post('office_phone'),
        'website' => $website,
        'asigned_to' => $asigned_to,
        'pan_no' => $this->input->post('pan_no'),
        'gst_rtype' => $this->input->post('gst_rtype'),
        'gstin' => $this->input->post('gstin'),
        'terms' => $this->input->post('terms'),
        'opening_balance' => $this->input->post('opening_balance'),
        'as_of' => $this->input->post('as_of'),
        'tax_registration_no' => $this->input->post('tax_registration_no'),
        'effective_date' => $this->input->post('effective_date'),
        'country' => $country,
        'state' => $state,
        'city' => $city,
        'zipcode' => $zipcode,
        'address' => $address,
        'description' => $description,
        'currentdate' => $currentdate,
      );
      //print_r($data);die;
      $id = $this->Vendors->create($data);
      if(!empty($id))
      {
        $x = "100";
        $vd = $id+$x;
        $vendor_id = "VND/".date('Y')."/".$vd;
        $this->Vendors->vendor_id($vendor_id,$id);
      }
      if(!empty($contact_name_batch))
      {
        $con_id = $this->Contact->contact_batch2($sess_eml,$session_company,$session_comp_email,$contact_name_batch,
        $name,$email_batch,$phone_batch,$mobile_batch,$website,$asigned_to,$contact_type,$country,$state,$city,
        $zipcode,$address,$description,$currentdate);
        $x = "100";
        $con = $con_id+$x;
        $contact_id = "CON/".date('Y')."/".$con;
        $this->Contact->contact_id($contact_id,$con_id);
        echo json_encode(array("status" => TRUE));
      }
      else 
      {
        echo json_encode(array("status" => FALSE));
      }
    }
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
      $id = $this->input->post('id');
      $sess_eml = $this->session->userdata('email');
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
      $name = $this->input->post('name');
      $contact_name_batch = $this->input->post('contact_name_batch');
      $email_batch = $this->input->post('email_batch');
      $phone_batch = $this->input->post('phone_batch');
      $mobile_batch = $this->input->post('mobile_batch');
      $website = $this->input->post('website');
      $asigned_to = $this->input->post('asigned_to');
      $contact_type = "Vendor";
      $country = $this->input->post('country');
      $state = $this->input->post('state');
      $city = $this->input->post('city');
      $zipcode = $this->input->post('zipcode');
      $address = $this->input->post('address');
      $description = $this->input->post('description');
      $data = array(
        'sess_eml' => $sess_eml,
        'session_company' => $session_company,
        'session_comp_email' => $session_comp_email,
        'name' => $name,
        'created_by' => $this->input->post('created_by'),
        'email' => $this->input->post('email'),
        'mobile' => $this->input->post('mobile'),
        'office_phone' => $this->input->post('office_phone'),
        'website' => $website,
        'asigned_to' => $asigned_to,
        'pan_no' => $this->input->post('pan_no'),
        'gst_rtype' => $this->input->post('gst_rtype'),
        'gstin' => $this->input->post('gstin'),
        'terms' => $this->input->post('terms'),
        'opening_balance' => $this->input->post('opening_balance'),
        'as_of' => $this->input->post('as_of'),
        'tax_registration_no' => $this->input->post('tax_registration_no'),
        'effective_date' => $this->input->post('effective_date'),
        'country' => $country,
        'state' => $state,
        'city' => $city,
        'zipcode' => $zipcode,
        'address' => $address,
        'description' => $description,
      );
      //print_r($data);die;
      $result = $this->Vendors->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
      echo json_encode(array("status" => TRUE)); 
    }
  }
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('name', 'Vendor Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]|trim');
    $this->form_validation->set_rules('gstin', 'GST Number', 'required|trim');
    $this->form_validation->set_rules('gst_rtype', 'GST Type', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');
    $this->form_validation->set_message('valid_email', '%s is not valid');
    $this->form_validation->set_message('regex_match','%s is invalid'); 
    if ($this->form_validation->run() == FALSE)
    {
      return json_encode(array('st'=>202, 'name'=> form_error('name'), 'email'=> form_error('email'), 'mobile'=> form_error('mobile'), 'gstin'=> form_error('gstin'), 'gst_rtype'=> form_error('gst_rtype') ));
    }
    else
    {
      return 200;
    }
  }
  public function delete($id)
  {
    $this->Vendors->delete($id);
    echo json_encode(array("status" => TRUE));
  }
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $this->Vendors->delete_bulk($id[$count]);
      }
    }
  }

//Please write code above this  
}