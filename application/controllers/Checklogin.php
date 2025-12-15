<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checklogin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('login_model');
    $this->load->helper('url');
  }
  public function index()
  {
    if (!empty($this->input->get('q'))) {
      // dd($this->input->get());
      $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2);
      $subdomain_name = $subdomain_arr[0];

      $code = $this->input->get('q');

      $email = $this->input->post('email', TRUE);
      $password = md5($this->input->post('password', TRUE));
      $validate = $this->login_model->check_admin($subdomain_name, $code);
      $validate2 = $this->login_model->check_user($subdomain_name, $code);

      if ($validate->num_rows() > 0) {
        $data = $validate->row_array();

        // $invoice_declaration = $data['invoice_declaration'];
        
        $id     = $data['id'];
        $sub_domain = $data['sub_domain'];
        $name     = $data['admin_name'];
        $email     = $data['admin_email'];
        $mobile   = $data['admin_mobile'];
        $type     = $data['type'];
        $active   = $data['active'];
        $company_name = $data['company_name'];
        $country   = $data['country'];
        $state     = $data['state'];
        $city     = $data['city'];
        $company_address = $data['company_address'];
        $zipcode     = $data['zipcode'];
        $company_mobile = $data['company_mobile'];
        $company_email   = $data['company_email'];
        $company_website = $data['company_website'];
        $company_gstin   = $data['company_gstin'];
        $pan_number   = $data['pan_number'];
        $cin       = $data['cin'];
        $company_logo   = $data['company_logo'];
        $terms_condition_customer = $data['terms_condition_customer'];
        $terms_condition_seller = $data['terms_condition_seller'];
        $license_activation_date = $data['license_activation_date'];
        $license_expiration_date = $data['license_expiration_date'];
        $trial_end_date = $data['trial_end_date'];
        $yourPlan     = $data['your_plan_id'];
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

        $create_pi = $data['create_pi'];
        $retrieve_pi = $data['retrieve_pi'];
        $update_pi = $data['update_pi'];
        $delete_pi = $data['delete_pi'];

        $user_image = $data['user_image'];
        $login_count = $data['login_count'];
        $created_date = $data['created_date'];
        $userStatus = $data['status'];
        
        $sesdata = array(
          'id'       => $id,
          'sub_domain'   => $sub_domain,
          'name'     => $name,
          'email'     => $email,
          'mobile'     => $mobile,
          'type'     => $type,
          'active'     => $active,
          'company_name' => $company_name,
          'country'   => $country,
          'state'     => $state,
          'city'       => $city,
          'company_address' => $company_address,
          'zipcode'     => $zipcode,
          'company_mobile'   => $company_mobile,
          'company_email'   => $company_email,
          'company_website' => $company_website,
          'company_gstin'   => $company_gstin,
          'pan_number'     => $pan_number,
          'cin'       => $cin,
          'company_logo'   => $company_logo,
          'terms_condition_customer' => $terms_condition_customer,
          'terms_condition_seller'   => $terms_condition_seller,
          'license_activation_date' => $license_activation_date,
          'license_expiration_date' => $license_expiration_date,
          'trial_end_date'   => $trial_end_date,
          'your_plan_id'   => $yourPlan,
          'license_type'   => $license_type,
          'account_type'   => $account_type,
          'basic_lic_amnt'   => $basic_lic_amnt,
          'business_lic_amnt' => $business_lic_amnt,
          'enterprise_lic_amnt' => $enterprise_lic_amnt,
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

          'create_pi' => $create_pi,
          'retrieve_pi' => $retrieve_pi,
          'update_pi' => $update_pi,
          'delete_pi' => $delete_pi,

          'user_image' => $user_image,
          'login_count' => $login_count,
          'opp_notify' => 1,
          'created_date' => $created_date,

          // 'invoice_declaration' => $invoice_declaration,
          
          'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);

        if ($type === 'admin') {
          if ($active == true) {
            $this->login_model->change_code($id);
            redirect('home');
          } else {
            redirect('login');
          }
        }
      }
      if ($validate2->num_rows() > 0) {
        $data = $validate2->row_array();

        $acitive_account = $this->login_model->available_loginUser($data['company_name'], $data['company_email']);

        if ($acitive_account['status'] == 0 && $acitive_account['account_type'] == "End") {
          echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your administrator`s account has been expired,contact your admin/administrator');
          redirect('login');
          exit;
        } else {
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
          $yourPlan     = $acitive_account['your_plan_id'];
          $license_type = $data['license_type'];
          $account_type = $data['account_type'];
          $partner_name = $data['partner_name'];
          $userType     = $data['user_type'];
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
          $so_approval = $data['so_approval'];
          $po_approval = $data['po_approval'];
          $notapprovalSO = $data['notapprovalSO'];
          $notapprovalPO = $data['notapprovalPO'];
          $user_image = $data['profile_image'];
          $login_count = $data['login_count'];
          $sales_quota = $data['sales_quota'];
          $profit_quota = $data['profit_quota'];
          $userStatus   = $data['status'];

          if ($userStatus == 0) {
            echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your account has been disabled, please contact your admin/administrator');
            redirect('login');
            exit;
          } else {
            $sesdata = array(
              'id'          => $id,
              'name'        => $name,
              'email'       => $email,
              'mobile'      => $mobile,
              'type'        => $type,
              'company_name' => $company_name,
              'country'     => $country,
              'state'       => $state,
              'city'        => $city,
              'company_address' => $company_address,
              'zipcode'         => $zipcode,
              'company_mobile'  => $company_mobile,
              'company_email'   => $company_email,
              'company_website' => $company_website,
              'company_gstin'   => $company_gstin,
              'pan_number'      => $pan_number,
              'cin'             => $cin,
              'company_logo'    => $company_logo,
              'terms_condition_customer' => $terms_condition_customer,
              'terms_condition_seller'  => $terms_condition_seller,
              'license_activation_date' => $license_activation_date,
              'license_expiration_date' => $license_expiration_date,
              'your_plan_id'   => $yourPlan,
              'license_type' => $license_type,
              'account_type' => $account_type,
              'partner_name' => $partner_name,
              'userType'     => $userType,
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
              'so_approval' => $so_approval,
              'po_approval' => $po_approval,
              'notapprovalSO' => $notapprovalSO,
              'notapprovalPO' => $notapprovalPO,
              'user_image' => $user_image,
              'login_count' => $login_count,
              'opp_notify' => 1,
              'sales_quota' => $sales_quota,
              'profit_quota' => $profit_quota,
              'logged_in' => TRUE
            );
            $this->session->set_userdata($sesdata);
            if ($type === 'standard') {
              $table = 'standard_users';
              redirect('home');
            }
          }
        }
      }
      $this->session->set_flashdata('msg', '<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i>Username or Password is Wrong');
      return redirect('login');
    }
    return redirect('login');
  }
}
