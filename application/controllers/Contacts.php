<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Contacts extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Contact_model','Contact');
    $this->load->library('excel');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
       if(checkModuleForContr('Create Contacts')<1){
        	    redirect('home');
        	    exit;
       } 
	if(check_permission_status('Contacts','create_u')==true){
      $name = "";
      $this->Contact->auto_delete($name);
	  //$data['countOrg']=$this->Organization->count_all();
	  $data['countContact']=$this->Contact->count_all();
      $this->load->view('essentials/contacts');
	}
    }
    else
    {
      redirect('login');
    }
  }
  public function ajax_list()
  {
   
	$delete_contact	=0;
	$update_contact	=0;
	$retrieve_contact=0; 
	if(check_permission_status('Contacts','delete_u')==true){
		$delete_contact=1;
	}
	if(check_permission_status('Contacts','retrieve_u')==true){
		$retrieve_contact=1;
	}
	if(check_permission_status('Contacts','update_u')==true){
		$update_contact=1;
	}
	  
    $list = $this->Contact->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  
      if($delete_contact==1) { 
        // $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'">';
          $row[] = '<input type="checkbox" class="delete_checkbox" value="'.$post->id.'" onclick="showAction(' . $post->id . ')">';
      }		  
      
      $first_row = "";
      $first_row.= ucfirst($post->name).'<!--<div class="links">';
      if($retrieve_contact==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-success">View</a>';
      endif;
      if($update_contact==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary">Update</a>';
      endif;
      if($delete_contact==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      $companydetail = "
    <div class='d-flex align-items-center'>
        <img src='".base_url('')."/application/views/assets/images/faces/4.jpg' alt='img'
            class='rounded-circle mr-2' style='width: 1.75rem; height: 1.75rem;'>
        <div>
            <span>".ucfirst($post->org_name)."</span><br>
            
        </div>
    </div>";
      // $row[] = $companydetail;
       $row[] = '<a style="text-decoration:none" href="'.base_url().'view-customer/'.$post->id.'">' . $companydetail . '</a>';
      $row[] = $first_row;
     
      $row[] = $post->email;
      $row[] = $post->mobile;
      $row[] = ucfirst($post->contact_owner);
	  
		$action='<div class="row" style="font-size: 15px;">';
		if($retrieve_contact==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Contact Details" ></i></a>';
		}
		if($update_contact==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="update('."'".$post->id."'".')" class="text-primary border-right"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Contact Details" ></i></a>';
		}	
		if($delete_contact==1){	
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')"  class="text-danger"><i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Contact" ></i></a>';
		}
		$action.='</div>';
           
			$row[]=$action;
	  
	  
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Contact->count_all(),
      "recordsFiltered" => $this->Contact->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
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
      $customer = "Customer";
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'contact_owner' 	=> $this->session->userdata('name'),
        'name' 				=> $this->input->post('name'),
        'org_name' 			=> $this->input->post('org_name'),
        'email' 			=> $this->input->post('email'),
        'website' 			=> $this->input->post('website'),
        'office_phone' 		=> $this->input->post('office_phone'),
        'mobile' 			=> $this->input->post('mobile'),
        'assigned_to' 		=> $this->input->post('assigned_to'),
        'sla_name' 			=> $this->input->post('sla_name'),
        'report_to' 		=> $this->input->post('report_to'),
        'title' 			=> $this->input->post('title'),
        'department' 		=> $this->input->post('department'),
        'contact_type' 		=> $customer,
        'billing_country' 	=> $this->input->post('billing_country'),
        'billing_state' 	=> $this->input->post('billing_state'),
        'shipping_country' 	=> $this->input->post('shipping_country'),
        'shipping_state' 	=> $this->input->post('shipping_state'),
        'billing_city' 		=> $this->input->post('billing_city'),
        'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
        'shipping_city' 	=> $this->input->post('shipping_city'),
        'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
        'billing_address' 	=> $this->input->post('billing_address'),
        'shipping_address' 	=> $this->input->post('shipping_address'),
        'description' 		=> $this->input->post('description'),
        'currentdate' 		=> date("y.m.d"),
      );
      $id = $this->Contact->create($data);
      updateid($id,'contact','contact_id');
      echo json_encode(array("status" => TRUE));
    }
  }
  public function getbyId($id)
  {
    $data = $this->Contact->get_by_id($id);
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
      $customer = "Customer";
      $data = array(
        'name' 			=> $this->input->post('name'),
        'org_name' 		=> $this->input->post('org_name'),
        'email' 		=> $this->input->post('email'),
        'website' 		=> $this->input->post('website'),
        'office_phone' 	=> $this->input->post('office_phone'),
        'mobile' 		=> $this->input->post('mobile'),
        'assigned_to' 	=> $this->input->post('assigned_to'),
        'sla_name' 		=> $this->input->post('sla_name'),
        'report_to' 	=> $this->input->post('report_to'),
        'title' 		=> $this->input->post('title'),
        'department' 	=> $this->input->post('department'),
        'billing_country' 	=> $this->input->post('billing_country'),
        'billing_state' 	=> $this->input->post('billing_state'),
        'shipping_country' 	=> $this->input->post('shipping_country'),
        'shipping_state'	=> $this->input->post('shipping_state'),
        'billing_city' 		=> $this->input->post('billing_city'),
        'billing_zipcode' 	=> $this->input->post('billing_zipcode'),
        'shipping_city' 	=> $this->input->post('shipping_city'),
        'shipping_zipcode' 	=> $this->input->post('shipping_zipcode'),
        'billing_address' 	=> $this->input->post('billing_address'),
        'shipping_address' 	=> $this->input->post('shipping_address'),
        'description' 		=> $this->input->post('description')
      );
      //print_r($data);die;
      $this->Contact->update(array('id' => $this->input->post('id'),'session_company' =>$this->session->userdata('company_name'),'session_comp_email' =>$this->session->userdata('company_email')), $data);
      echo json_encode(array("status" => TRUE));
    }
  }
  public function delete($id)
  {
    $this->Contact->delete($id);
    echo json_encode(array("status" => TRUE));
  }
  public function delete_bulk()
  {
    if($this->input->post('checkbox_value'))
    {
      $id = $this->input->post('checkbox_value');
      for($count = 0; $count < count($id); $count++)
      {
        $this->Contact->delete_bulk($id[$count]);
      }
    }
  }
  public function get_org_details()
  {
	  
    $org_name = $this->input->post();
    $data = $this->Contact->getOrgValue($org_name);
    echo json_encode($data);
  }
  
  
  //page_name
  
  public function getContact()
  {
    $postData = $this->input->post();
    $data = $this->Contact->getContacts($postData);
    echo json_encode($data);
  }
  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('name', 'Contact Name', 'required|trim');
    $this->form_validation->set_rules('org_name', 'Organization Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
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
      return json_encode(array('st'=>202, 'org_name'=> form_error('org_name'), 'name'=> form_error('name'),'email'=> form_error('email'), 'mobile'=> form_error('mobile'), 'billing_country'=> form_error('billing_country'), 'billing_state'=> form_error('billing_state'), 'shipping_country'=> form_error('shipping_country'),'shipping_state'=> form_error('shipping_state'), 'billing_city'=> form_error('billing_city'), 'billing_zipcode'=> form_error('billing_zipcode'), 'shipping_city'=> form_error('shipping_city'), 'shipping_zipcode'=> form_error('shipping_zipcode'), 'billing_address'=> form_error('billing_address'), 'shipping_address'=> form_error('shipping_address')));
    }
    else
    {
      return 200;
    }
  }
 
public function import()
  {
    $this->load->library('csvimport');
    if(isset($_FILES["file"]["name"]))
    {
      $path = $_FILES["file"]["tmp_name"];
      $duplicate_array  = array();
	  $message_array    = array();
	  $file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);

		foreach($file_data as $row)
		{
       
          $contact_name     = $row["Contact Name"];
          $contact_owner    = $row["Contact Owner"];
          $organization     = $row["Organization Name"];
          $mobile           = $row["Mobile"];
          $billing_country  = $row["Billing Country"];
          $billing_state    = $row["Billing State"];
          $billing_city     = $row["Billing City"];
          $billing_zipcode  = $row["Billing Zipcode"];
          $billing_address  = $row["Billing Address"];
          $shipping_country = $row["Shipping Country"];
          $shipping_state   = $row["Shipping State"];
          $shipping_city    = $row["Shipping City"];
          $shipping_zipcode = $row["Shipping Zipcode"];
          $shipping_address = $row["Shipping Address"];  
	
          $data[] = array(
            'sess_eml'          => $this->session->userdata('email'),
            'session_company'   => $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'assigned_to'       => $this->session->userdata('name'),
            'name'              => $contact_name,
            'contact_owner'     => $contact_owner,
            'org_name'          => $organization,
            'mobile'            => $mobile,
            'billing_country'   => $billing_country,
            'billing_state'     => $billing_state,
            'billing_city'      => $billing_city,
            'billing_zipcode'   => $billing_zipcode,
            'billing_address'   => $billing_address,
            'shipping_country'  => $shipping_country,
            'shipping_state'    => $shipping_state,
            'shipping_city'     => $shipping_city,
            'shipping_zipcode'  => $shipping_zipcode,
            'shipping_address'  => $shipping_address,
          );
        }
        if(empty($contact_name) || empty($contact_owner) || empty($organization) || empty($mobile) || empty($billing_country) || empty($billing_state) || empty($billing_city) || empty($billing_zipcode) || empty($billing_address) || empty($shipping_country) || empty($shipping_state) || empty($shipping_city) || empty($shipping_zipcode) || empty($shipping_address) )
        {
          echo json_encode(array('st'=> 202, 'msg'=> 'Import Failed All Fields Are Required'));
          exit;
        }
        else if(!empty($contact_name) && !empty($organization))
        {
          $result = $this->Contact->check_duplicate_contact_name($contact_name,$organization);
          if(!empty($result))
          {
            array_push($duplicate_array, $result);
            //$goto = $this->check_duplicate();
          }
          else
          {
            $this->Contact->insert_excel($data);
            $message_array=array('st'=> 200, 'msg'=> 'Data Imported Successfully');
          }
        }
        
     if(count($duplicate_array)>0){
			echo json_encode($duplicate_array);
	  }else{
		   echo json_encode($message_array);
	  }
    } 
  }
  
  
  
  
  
  public function check_duplicate()
  {
    $path = $_FILES["file"]["tmp_name"];
    $object = PHPExcel_IOFactory::load($path);
    $duplicate_array = array();
    
      $file_data = $this->csvimport->get_array($_FILES["file"]["tmp_name"]);

		foreach($file_data as $row)
		{
            $contact_name = $row["Contact Name"];
            $contact_owner= $row["Contact Owner"];
            $organization = $row["Organization Name"];
            if(!empty($contact_name) && empty(!$organization))
            {
              $result = $this->Contact->check_duplicate_contact_name($contact_name,$organization);
              array_push($duplicate_array, $result);
            }
       }
    
    echo json_encode($duplicate_array);
  }
  
  
  
  public function check_contact()
  {
    $contact_name = $this->input->post('contact_name');
    if($this->Contact->check_contact_name($contact_name) == 202)
    {
      echo '<span style="color:red;font-size:10px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Duplicate Entry</span>';
      echo "<script>$('#btnSave').prop('disabled',true);</script>";
    }
    else
    {
      echo "<script>$('#btnSave').prop('disabled',false);</script>";
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
			$mass_data = $this->Contact->mass_save($mass_id, $dataArry);
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
