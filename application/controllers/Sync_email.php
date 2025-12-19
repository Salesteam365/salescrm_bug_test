<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sync_email extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
   // $this->load->model('Company_model');
  }
  
    public function index()
    {
		$this->load->view('users/add_company_detail');
	}
  
  
  /**
  * Handle incoming POST request to add or update company details, store them in session and the database, and echo an HTML success or error message.
  * @example
  * // Example (controller context): simulate POST data (CodeIgniter)
  * $_POST = [
  *   'company_name' => 'Acme Corp',
  *   'company_website' => 'https://www.acme.example',
  *   'company_email' => 'info@acme.example',
  *   'company_mobile' => '+1234567890',
  *   'pan_number' => 'ABCDE1234F',
  *   'cin' => 'L12345MH2000PLC123456',
  *   'company_gstin' => '27ABCDE1234F1Z5',
  *   'country' => 'India',
  *   'state' => 'Maharashtra',
  *   'city' => 'Mumbai',
  *   'zipcode' => '400001',
  *   'address' => '123 Acme Street',
  *   'terms_condition_customer' => ['Customer term 1','Customer term 2'],
  *   'terms_condition_seller' => ['Seller term 1']
  * ];
  * $this->sync_email->add_company_details();
  * // Sample echoed success output:
  * // <i class="far fa-check-circle" style="color:green; display: block; margin-bottom: 3%; font-size: 30px;" ></i>&nbsp;&nbsp;Your company information successfully submitted.
  * @param {array} $post - POST input array (via $this->input->post()). Expected keys: company_name (string, optional), company_website (string), company_email (string, optional), company_mobile (string), pan_number (string), cin (string), company_gstin (string), country (string), state (string), city (string), zipcode (string), address (string), terms_condition_customer (array|string), terms_condition_seller (array|string).
  * @returns {void} Echoes an HTML formatted success or error message; does not return a value.
  */
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
      $terms_condition_customer = $termsCondi;
      $terms_condition_seller   = $termsCondiSell;
      if($this->login_model->add_company_details($sess_eml,$company_name,$company_website,$company_email,$company_mobile,$pan_number,$cin,
      $company_gstin,$country,$state,$city,$zipcode,$company_address,$terms_condition_customer,$terms_condition_seller))
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
		  
        $this->login_model->addBranch($sess_eml,$sess_id,$company_name,$company_email,$company_mobile,$pan_number,$cin,
        $company_gstin,$country,$state,$city,$zipcode,$company_address);
        echo '<i class="far fa-check-circle" style="color:green; display: block;    margin-bottom: 3%; font-size: 30px;" ></i>&nbsp;&nbsp;Your company information successfully submitted.';
      }else{
        echo '<i class="fas fa-exclamation-triangle" style="color:red; display: block; margin-bottom: 3%; font-size: 30px;" ></i>&nbsp;&nbsp;Oops! Something went wrong, PLease try again later.';
      }
    }
   }
  
  
	
}
?>