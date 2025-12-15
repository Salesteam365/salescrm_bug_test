<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Login_model');
   // $this->load->model('Company_model');
  }
  
    public function index(){
      //$data['plan_name']    = $this->Login_model->plan_name();
      // dd($this->db->where(['id'=>$this->session->userdata('id')])->get('admin_users')->row_array()['invoice_declaration']);
      if($this->session->userdata('email')==null){
        $this->session->set_flashdata('msg', '<i class="fas fa-exclamation-triangle" style="color: red; margin-right: 7px;"></i>Please Login First !!!!!!!!!!');
        return redirect('home');
      }

      $invoice_data = $this->db->where(['id'=>$this->session->userdata('id')])->get('admin_users');
      if($invoice_data->num_rows()>0){
        $invoice_data = $invoice_data->row()->invoice_declaration;
      }
      else{
        $invoice_data = "";
      }
      $this->load->view('users/add_company_detail',['invoice_declarations'=>$invoice_data]);
	}
  
  
  public function add_company_details()
  {
    
    if($this->input->post())
    {
      $sess_eml         = $this->session->userdata('email');
      $sess_id          = $this->session->userdata('id');
      
      if($this->input->post('company_name')){
      $company_name     = $this->input->post('company_name');
      }else{
        $company_name=$this->session->userdata('company_name');  
      }
      $company_website  = $this->input->post('company_website');
      if($this->input->post('company_email')){
      $company_email    = $this->input->post('company_email');
      }else{
        $company_email=$this->session->userdata('company_email');  
      }
	  
	  if($this->input->post('terms_condition_customer')){
		  $termsCondi=implode('<br>',$this->input->post('terms_condition_customer'));
	  }else{
		  $termsCondi='';
	  }
	  if($this->input->post('terms_condition_seller')){
		  $termsCondiSell=implode('<br>',$this->input->post('terms_condition_seller'));
	  }else{
		  $termsCondiSell='';
	  }
	  
      $company_mobile   = $this->input->post('company_mobile');
      $pan_number       = $this->input->post('pan_number');
      $cin              = $this->input->post('cin');
      $company_gstin    = $this->input->post('company_gstin');
      $country          = $this->input->post('country');
      $state            = $this->input->post('state');
      $city             = $this->input->post('city');
      $zipcode          = $this->input->post('zipcode');
      $company_address  = $this->input->post('address');
      $invoice_declaration  = $this->input->post('invoice_declaration');
      $terms_condition_customer = $termsCondi;
      $terms_condition_seller   = $termsCondiSell;
      if($this->Login_model->add_company_details($sess_eml,$company_name,$company_website,$company_email,$company_mobile,$pan_number,$cin,
      $company_gstin,$country,$state,$city,$zipcode,$company_address,$terms_condition_customer,$terms_condition_seller,$invoice_declaration))
      {
		  
		  $sesdata = array(
          'company_name'    => $company_name,
          'country'         => $country,
          'state'           => $state,
          'city'            => $city,
          'company_address' => $company_address,
          'zipcode'         => $zipcode,
          'company_mobile'  => $company_mobile,
          'company_email'   => $company_email,
          'company_website' => $company_website,
          'company_gstin'   => $company_gstin,
          'pan_number'      => $pan_number,
          'cin'             => $cin,
          'terms_condition_customer' => $terms_condition_customer,
          'terms_condition_seller' => $terms_condition_seller
        );

        $this->session->set_userdata($sesdata);
		  $licenseActivationDate     = $this->session->userdata('license_activation_date');
		  $licenseExpirationDate     = $this->session->userdata('license_expiration_date');
		  $CrtesDate     = $this->session->userdata('created_date');
		  $ipAddress=$this->input->ip_address();
		  
		  $datatCnt=$this->Login_model->yourplanid();
		  $offerdata = $this->Login_model->getoffer($sess_id);
		 
		  if(count($datatCnt)<1){
		    
		      if(!empty($offerdata))
		      {
		           
		          $dataArrPl=array(
                      'session_company' => $company_name,
                      'session_comp_email' => $company_email,
                      'used_licence'    => 1,
                      'currentdate'     => $CrtesDate,
                      'ip'              => $ipAddress,
                      'delete_status'   => 1
		         );
		         $this->Login_model->updateofferrow($dataArrPl,$sess_id);
		         
		      }
		      else
		      {
		     
		          $dataArrPl=array(
                  'admin_id'        => $sess_id,
                  'sess_eml'        => $sess_eml,
                  'session_company' => $company_name,
                  'session_comp_email' => $company_email,
                  'account_type'    => 'Trial',
                  'plan_id'         => '4',
                  'plan_licence'    => 5,
                  'plan_price'      => 0,
                  'used_licence'    => 1,
                  'licence_act_date'=> $licenseActivationDate,
                  'licence_exp_date'=> $licenseExpirationDate,
                  'licence_type'    => 'Monthly',
                  'currentdate'     => $CrtesDate,
                  'ip'              => $terms_condition_seller,
                  'delete_status'   => $ipAddress
		      );
		        $this->Login_model->insertplan($dataArrPl);
		      }
		     
		  }
		  
		  
        $this->Login_model->addBranch($sess_eml,$sess_id,$company_name,$company_email,$company_mobile,$pan_number,$cin,
        $company_gstin,$country,$state,$city,$zipcode,$company_address);
        echo '<i class="far fa-check-circle" style="color:green; display: block;    margin-bottom: 3%; font-size: 30px;" ></i>&nbsp;&nbsp;Your company information successfully submitted.';
      }else{
        echo '<i class="fas fa-exclamation-triangle" style="color:red; display: block; margin-bottom: 3%; font-size: 30px;" ></i>&nbsp;&nbsp;Oops! Something went wrong, PLease try again later.';
      }
    }
   }
  
  
	
}
?>