<?php defined('BASEPATH') or exit('No direct script access allowed');
class Proforma_invoice extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Performainvoice_model', 'Performainvoice');
    $this->load->model('Branch_model');
    $this->load->model('Login_model', 'Login');
    $this->load->library('email_lib');
  }
  public function index()
  {
    if (!empty($this->session->userdata('email'))) {
      if (checkModuleForContr('Create Proforma Invoice') < 1) {
        redirect('home');
      }
      if (check_permission_status('Proforma Invoice', 'retrieve_u') == true) {
        $data = array();
        $data['user'] = $this->Login->getusername();
        $data['admin'] = $this->Login->getadminname();
        // dd($data);
        $this->load->view('sales/proforma-invoice-list', $data);
      } else {
        redirect('permission');
      }
    } else {
      redirect('login');
    }
  }

  public function view_pi()
  {
    if (!empty($this->session->userdata('email'))) {
      if (checkModuleForContr('Create Proforma Invoice') < 1) {
        redirect('home');
      }
      if (check_permission_status('Proforma Invoice', 'retrieve_u') == true) {
        $data = array();
        $data['user'] = $this->Login->getusername();
        $data['admin'] = $this->Login->getadminname();

        $product_id = base64_decode($_GET['pi']);
        $cnp = base64_decode($_GET['cnp']);
        $ceml = base64_decode($_GET['ceml']);

        $data['bank_details_terms'] = $this->Performainvoice->get_bank_details();
        $data['record'] = $this->Performainvoice->get_pi_byId($product_id, $cnp, $ceml);
        if ($data['record']['id']) {
          $data['otherdata'] = $this->Performainvoice->get_data_detail($data['record']['page_name'], $data['record']['page_id']);
          $data['branch'] = $this->Performainvoice->getBranchData($data['record']['billedby_branchid']);
          $data['clientDtl'] = $this->Performainvoice->getVendorOrgData($data['record']['billedto_orgname'], $data['record']['page_name']);
          $this->load->view('sales/view-proforma-detail', $data);
        } else {
        }
      } else {
        redirect('permission');
      }
    } else {
      redirect('login');
    }
  }

  public function send_email()
  {

    $orgName    = $this->input->post('orgName');
    $orgEmail    = $this->input->post('orgEmail');
    $ccEmail    = $this->input->post('ccEmail');
    $subEmail    = $this->input->post('subEmail');
    $descriptionTxt = $this->input->post('descriptionTxt');
    $invoiceurl  = $this->input->post('invoiceurl');
    $piid        = $this->input->post('piid');
    $compeml    = $this->input->post('compeml');
    $compname    = $this->input->post('compname');
    //attachment 
    $attach_pdf = $this->generate_pdf_attachment($piid, $compname, $compeml);
    //$attach_pdf  = $attach_path;


    $messageBody = '
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
    if (!empty($image)) {
      $messageBody .=  '<img  src="' . base_url() . '/uploads/company_logo/' . $image . '" style="height:150px;"  >';
    } else {
      $messageBody .=  '<span class="h5 text-primary">' . $this->session->userdata('company_name') . '</span>';
    }
    $messageBody .= '</a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <h1>Hi, ' . ucwords($orgName) . '!</h1>';

    $messageBody .= '<p>Thank you for shopping at ' . $this->session->userdata('company_name') . '.</p>';
    $messageBody .= '<p>We appreciate your continued patronage and feel honored that you have chosen our product.</p>';
    $messageBody .= '<p>Our company will do the best of our abilities to meet your expectations and provide the service that you deserve.</p>';
    $messageBody .= '<p>We have grown so much as a corporation because of customers like you, and we certainly look forward to more years of partnership with you.</p>';


    $messageBody .= '<!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="' . $invoiceurl . '" class="f-fallback button" target="_blank">View Proforma Invoice</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>';
    $messageBody .= $descriptionTxt;
    $messageBody .= '</div>
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
                      <p class="f-fallback sub align-center">&copy; ' . date("Y") . ' team365. All rights reserved</p>
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
    /*$this->email->message($messageBody);
	if(!$this->email->send()){
		echo "0";
	}else{
		echo "1";
	}*/
    if (!$this->email_lib->send_email($orgEmail, $subEmail, $messageBody, $ccEmail, $attach_pdf)) {
      echo '0';
    } else {
      echo '1';
    }
    unlink($attach_pdf);
    exit;
  }



  public function ajax_list()
  {

    $delete_pi  = 0;
    $update_pi  = 0;
    $retrieve_pi = 0;

    if (check_permission_status('Proforma Invoice', 'delete_u') == true) {
      $delete_pi = 1;
    }
    if (check_permission_status('Proforma Invoice', 'retrieve_u') == true) {
      $retrieve_pi = 1;
    }
    if (check_permission_status('Proforma Invoice', 'update_u') == true) {
      $update_pi = 1;
    }
    $list = $this->Performainvoice->get_datatables();

    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post) {
      $encrypted_id   = base64_encode($post->id);
      $sessionEmail   = base64_encode($this->session->userdata('company_email'));
      $sessionCompany  = base64_encode($this->session->userdata('company_name'));

      $no++;
      $row = array();
      $first_row = "";
      $first_row .= $post->invoice_no . '<!--<div class="links">';
      if ($retrieve_pi == 1) :
        $first_row .= '<a style="text-decoration:none" href="' . base_url("proforma_invoice/view-pi?pi=" . $encrypted_id . "&cnp=" . $sessionCompany . "&ceml=" . $sessionEmail) . '" class="text-success">View</a> | ';
      endif;
      if ($update_pi == 1) :
        $first_row .= '<a style="text-decoration:none" href="' . base_url("proforma_invoice/create_newProforma/" . $post->id . "") . '" onclick="view(' . "'" . $post->id . "'" . ')" class="text-success">Update</a>';
      endif;
      if ($delete_pi == 1) :
        $first_row .= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_invoice(' . "'" . $post->id . "'" . ')" class="text-danger">Delete</a>';
      endif;

      $first_row .= '</div>--->';
      $row[] = $first_row;
      $row[]    = ucfirst($post->billedto_orgname);
      $row[]    = ucfirst($post->page_name);
      $total    = ucfirst($post->final_total);
      $row[]    = IND_money_format($total);
      if ($post->pi_status == 1) {
        $row[] = "<text style='color:green;'>Active</text>";
      } else {
        $row[] = "<text style='color:red;'>Pending</text>";
      }

      $newDate = date("d M Y", strtotime($post->invoice_date));
      $row[] = "<text style='font-size: 12px;' data-toggle='tooltip' data-container='body' title='" . $newDate . "' >" . time_elapsed_string($post->invoice_date) . "</text>";

      $action = '<div class="row" style="font-size: 15px;">';
      if ($retrieve_pi == 1) {
        $action .= '<a style="text-decoration:none" href="' . base_url("proforma_invoice/view-pi?pi=" . $encrypted_id . "&cnp=" . $sessionCompany . "&ceml=" . $sessionEmail) . '"  class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Proforma Invoice Details" ></i></a>';
      }
      if ($update_pi == 1) {
        $action .= '<a style="text-decoration:none" href="' . base_url("proforma_invoice/create_newProforma/" . $post->id . "") . '"  class="text-primary border-right"> <i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Proforma Invoice Details" ></i></a>';
      }
      if ($delete_pi == 1) {
        $action .= '<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_invoice(' . "'" . $post->id . "'" . ')"   class="text-danger">
					<i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Proforma Invoice" ></i></a>';
      }
      $action .= '</div>';
      $row[] = $action;




      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Performainvoice->count_all(),
      "recordsFiltered" => $this->Performainvoice->count_filtered(),
      "data" => $data,
    );

    echo json_encode($output);
  }

  public function create_newProforma()
  {
    if (!empty($this->session->userdata('email'))) {
      if (checkModuleForContr('Create Proforma Invoice') < 1) {
        redirect('home');
      }
      if (check_permission_status('Proforma Invoice', 'create_u') == true) {
        $data = array();
        if (isset($_GET['pg'])) {
          $pg = $_GET['pg'];
          if (isset($_GET['qt'])) {
            $qt = $_GET['qt'];
          } else {
            $qt = "";
          }
          $data['record'] = $this->Performainvoice->get_data_detail($pg, $qt);
        } else if ($this->uri->segment(3)) {
          $product_id = $this->uri->segment(3);
          $data['record'] = $this->Performainvoice->get_pi_byId($product_id);
        } else {
          $data['record'] = array();
        }
        $data['branch_details'] = $this->Performainvoice->get_branch();
        $data['org_details'] = $this->Performainvoice->get_organization();
        $data['city_name'] = $this->session->userdata("city");
        $data['gstPer']     = $this->Performainvoice->get_gst();
        $this->load->view('sales/add-proforma-invoice', $data);
      } else {
        redirect('permission');
      }
    } else {
      redirect('login');
    }
  }

  public function put_id_for_pi()
  {
    $pi_id = updateid(420, 'performa_invoice', 'invoice_no');
    echo $pi_id;
  }



  public function delete_pi($id)
  {
    $this->Performainvoice->delete_pi($id);
    echo json_encode(array("status" => TRUE));
  }

  public function add_invoiceDetails()
  {

    $validation = $this->check_validation();
    if ($validation != 200) {
      echo $validation;
      die;
    } else {

      $signature_img = '';
      $attachment = $_FILES['attachment']['name'];
      /*$business_logo = $_FILES['business_logo']['name'];*/
      $upload_signature = $_FILES['upload_signature']['name'];
      //print_r($this->input->post());die;
      $image_path = './assets/pi_images/';
      if ($upload_signature !== '') {
        $config['upload_path'] = $image_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = true;
        /*$config['max_size'] = 2000;
        $config['max_width'] = 1500;
        $config['max_height'] = 1500;*/

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('upload_signature')) {
          echo json_encode(array('error_uploadsignature' => $this->upload->display_errors(), 'st' => 'error_fileupload'));
          die;
        } else {
          $image_metadata = $this->upload->data();
          $signature_img =  $image_metadata['file_name'];
        }
      } else if ($this->input->post('signature_image')) {

        $signature_img = $this->uploadSignature($this->input->post('signature_image'));
      }

      if ($attachment !== '') {
        $config['upload_path'] = $image_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('attachment')) {
          echo json_encode(array('error_attachment' => $this->upload->display_errors(), 'st' => 'error_fileupload'));
          die;
        } else {
          $image_metadata = $this->upload->data();
          $attachment =  $image_metadata['file_name'];
        }
      }


      $unit_price = str_replace(",", "", $this->input->post('unit_price'));
      $total = str_replace(",", "", $this->input->post('total'));
      $cgst = str_replace(",", "", $this->input->post('cgst'));
      $igst = str_replace(",", "", $this->input->post('igst'));
      $sgst = str_replace(",", "", $this->input->post('sgst'));
      $sub_totalwithgst = str_replace(",", "", $this->input->post('sub_total'));
      $initial_total = str_replace(",", "", $this->input->post('initial_total'));
      $total_discount = str_replace(",", "", $this->input->post('total_discount'));
      $extraCharge_value = str_replace(",", "", $this->input->post('extra_chargevalue'));
      $final_total = str_replace(",", "", $this->input->post('final_total'));

      if ($extraCharge_value != "") {
        $extraCharge_value = implode("<br>", $extraCharge_value);
      } else {
        $extraCharge_value = '';
      }


      if ($this->input->post('label')) {
        $lable = implode("<br>", $this->input->post('label'));
      } else {
        $lable = '';
      }
      if ($this->input->post('label_value')) {
        $label_value = implode("<br>", $this->input->post('label_value'));
      } else {
        $label_value = '';
      }
      if ($this->input->post('extra_charge')) {
        $extra_label = implode("<br>", $this->input->post('extra_charge'));
      } else {
        $extra_label = '';
      }
      if ($this->input->post('terms_condition')) {
        $terms_condition = implode("<br>", $this->input->post('terms_condition'));
      } else {
        $terms_condition = '';
      }
      if ($this->input->post('product_desc')) {
        $product_desc = implode("<br>", $this->input->post('product_desc'));
      } else {
        $product_desc = '';
      }

      if ($this->input->post('page_name')) {
        $page_name = $this->input->post('page_name');
      } else {
        $page_name = '';
      }
      if ($this->input->post('page_id')) {
        $page_id = $this->input->post('page_id');
      } else {
        $page_id = '';
      }



      $data = array(
        'sess_eml'       => $this->session->userdata('email'),
        'session_company'   => $this->session->userdata('company_name'),
        'session_comp_email' => $this->session->userdata('company_email'),
        'invoice_no'     => $this->input->post('invoice_no'),
        'page_name'     => $page_name,
        'page_id'       => $page_id,
        'invoice_date'     => date('Y-m-d', strtotime($this->input->post('invoice_date'))),
        'due_date'       => date('Y-m-d', strtotime($this->input->post('invoice_dueDate'))),
        'extraField_label'   => $lable,
        'extraField_value'   => $label_value,
        // 'business_logo' 	=>  $business_logo,
        'billedto_orgname'   => $this->input->post('billedto'),
        'billedby_branchid' => $this->input->post('billedby'),
        'client_bname'     => $this->input->post('client_bname'),
        'client_address'   => $this->input->post('client_address'),
        'client_country'   => $this->input->post('client_country'),
        'client_state'     => $this->input->post('client_state'),
        'client_city'     => $this->input->post('client_city'),
        'client_zipcode'   => $this->input->post('client_zipcode'),
        'client_gst'     => $this->input->post('client_gst'),
        'challan_number'   => $this->input->post('challan_number'),
        'select_date'     => date('Y-m-d', strtotime($this->input->post('select_date'))),
        'transport'     => $this->input->post('transport'),
        'shipping_note'   => $this->input->post('shipping_note'),
        'discount_type'   => $this->input->post('sel_disc'),
        'discount'           => $this->input->post('discount'),
        'signature_img'   => $signature_img,
        'notes'       => $this->input->post('notes'),
        'attachment'     => $attachment,
        'pro_description'   => $product_desc,
        'pro_image'     => '',
        'enquiry_email'   => $this->input->post('enquiry_email'),
        'enquiry_mobile'   => $this->input->post('enquiry_mobile'),
        'product_name'     => implode("<br>", $this->input->post('items')),
        'hsn_sac'         => implode("<br>", $this->input->post('hash')),
        'gst'         => implode("<br>", $this->input->post('gst')),
        'quantity'       => implode("<br>", $this->input->post('quantity')),
        'unit_price'     => implode("<br>", $unit_price),
        'total'       => implode("<br>", $total),
        'sgst'         => implode("<br>", $sgst),
        'igst'         => implode("<br>", $igst),
        'cgst'         => implode("<br>", $cgst),
        'sub_totalwithgst'   => implode("<br>", $sub_totalwithgst),
        'extraCharge_name'   => $extra_label,
        'extraCharge_value' => $extraCharge_value,
        'terms_condition'   => $terms_condition,
        'total_discount'   => $total_discount,
        'initial_total'   => $initial_total,
        'final_total'     => $final_total

      );
      $id = $this->Performainvoice->create_pi($data);
      if ($id) {
        echo json_encode(array("status" => TRUE, 'st' => 200));
      } else {
        echo json_encode(array("status" => FALSE));
      }
    }
  }


  public function update_invoiceDetails()
  {
    $validation = $this->check_validation();
    if ($validation != 200) {
      echo $validation;
      die;
    } else {

      $signature_img = '';
      $attachment = $_FILES['attachment']['name'];
      $upload_signature = $_FILES['upload_signature']['name'];
      $image_path = './assets/pi_images/';
      if ($upload_signature !== '') {
        $config['upload_path'] = $image_path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = true;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('upload_signature')) {
          echo json_encode(array('error_uploadsignature' => $this->upload->display_errors(), 'st' => 'error_fileupload'));
          die;
        } else {
          $image_metadata = $this->upload->data();
          $signature_img  = $image_metadata['file_name'];
        }
      } else if ($this->input->post('signature_image')) {
        $signature_img = $this->uploadSignature($this->input->post('signature_image'));
      }

      if ($attachment !== '') {
        $config['upload_path']     = $image_path;
        $config['allowed_types']   = 'gif|jpg|png|jpeg|pdf';
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('attachment')) {
          echo json_encode(array('error_attachment' => $this->upload->display_errors(), 'st' => 'error_fileupload'));
          die;
        } else {
          $image_metadata = $this->upload->data();
          $attachment   = $image_metadata['file_name'];
        }
      }


      $unit_price   = str_replace(",", "", $this->input->post('unit_price'));
      $total     = str_replace(",", "", $this->input->post('total'));
      $cgst     = str_replace(",", "", $this->input->post('cgst'));
      $igst     = str_replace(",", "", $this->input->post('igst'));
      $sgst     = str_replace(",", "", $this->input->post('sgst'));
      $sub_totalwithgst = str_replace(",", "", $this->input->post('sub_total'));
      $initial_total   = str_replace(",", "", $this->input->post('initial_total'));
      $total_discount   = str_replace(",", "", $this->input->post('total_discount'));
      $extraCharge_value = str_replace(",", "", $this->input->post('extra_chargevalue'));
      $final_total   = str_replace(",", "", $this->input->post('final_total'));

      if ($extraCharge_value != "") {
        $extraCharge_value = implode("<br>", $extraCharge_value);
      } else {
        $extraCharge_value = '';
      }


      if ($this->input->post('label')) {
        $lable = implode("<br>", $this->input->post('label'));
      } else {
        $lable = '';
      }
      if ($this->input->post('label_value')) {
        $label_value = implode("<br>", $this->input->post('label_value'));
      } else {
        $label_value = '';
      }
      if ($this->input->post('extra_charge')) {
        $extra_label = implode("<br>", $this->input->post('extra_charge'));
      } else {
        $extra_label = '';
      }
      if ($this->input->post('terms_condition')) {
        $terms_condition = implode("<br>", $this->input->post('terms_condition'));
      } else {
        $terms_condition = '';
      }
      if ($this->input->post('product_desc')) {
        $product_desc = implode("<br>", $this->input->post('product_desc'));
      } else {
        $product_desc = '';
      }

      if ($this->input->post('page_name')) {
        $page_name = $this->input->post('page_name');
      } else {
        $page_name = '';
      }
      if ($this->input->post('page_id')) {
        $page_id = $this->input->post('page_id');
      } else {
        $page_id = '';
      }

      $data = array(
        'invoice_date'     => date('Y-m-d', strtotime($this->input->post('invoice_date'))),
        'due_date'       => date('Y-m-d', strtotime($this->input->post('invoice_dueDate'))),
        'extraField_label'   => $lable,
        'extraField_value'   => $label_value,
        'billedto_orgname'   => $this->input->post('billedto'),
        'billedby_branchid' => $this->input->post('billedby'),
        'client_bname'     => $this->input->post('client_bname'),
        'client_address'   => $this->input->post('client_address'),
        'client_country'   => $this->input->post('client_country'),
        'client_state'     => $this->input->post('client_state'),
        'client_city'     => $this->input->post('client_city'),
        'client_zipcode'   => $this->input->post('client_zipcode'),
        'client_gst'     => $this->input->post('client_gst'),
        'challan_number'   => $this->input->post('challan_number'),
        'select_date'     => date('Y-m-d', strtotime($this->input->post('select_date'))),
        'transport'     => $this->input->post('transport'),
        'shipping_note'   => $this->input->post('shipping_note'),
        'notes'       => $this->input->post('notes'),
        'discount_type'   => $this->input->post('sel_disc'),
        'discount'           => $this->input->post('discount'),
        'pro_description'   => $product_desc,
        'enquiry_email'   => $this->input->post('enquiry_email'),
        'enquiry_mobile'   => $this->input->post('enquiry_mobile'),
        'product_name'     => implode("<br>", $this->input->post('items')),
        'hsn_sac'       => implode("<br>", $this->input->post('hash')),
        'gst'         => implode("<br>", $this->input->post('gst')),
        'quantity'       => implode("<br>", $this->input->post('quantity')),
        'unit_price'     => implode("<br>", $unit_price),
        'total'       => implode("<br>", $total),
        'sgst'         => implode("<br>", $sgst),
        'igst'         => implode("<br>", $igst),
        'cgst'         => implode("<br>", $cgst),
        'sub_totalwithgst'   => implode("<br>", $sub_totalwithgst),
        'extraCharge_name'   => $extra_label,
        'extraCharge_value' => $extraCharge_value,
        'terms_condition'   => $terms_condition,
        'total_discount'   => $total_discount,
        'initial_total'   => $initial_total,
        'final_total'     => $final_total
      );

      if (isset($attachment) && $attachment != "") {
        $data['attachment'] = $attachment;
      }
      if (isset($signature_img) && $signature_img != "") {
        $data['signature_img'] = $signature_img;
      }

      $piId = $this->input->post('invc_id');
      $id = $this->Performainvoice->update_pi($data, $piId);
      if ($id) {
        echo json_encode(array("status" => TRUE, 'st' => 200));
      } else {
        echo json_encode(array("status" => FALSE));
      }
    }
  }


  public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $piId = $this->input->post('invc_id');
    if (empty($piId)) {
      $this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim|is_unique[performa_invoice.invoice_no]');
    }
    $this->form_validation->set_rules('invoice_date', 'Invoice Date', 'required|trim');
    $this->form_validation->set_rules('items[]', 'Iitems', 'required|trim');
    $this->form_validation->set_rules('quantity[]', 'Quantity', 'required|trim');
    $this->form_validation->set_rules('unit_price[]', 'Unit Price', 'required|trim');
    $this->form_validation->set_rules('billedby', 'BusinessBy', 'required|trim');
    $this->form_validation->set_rules('billedto', 'BusinessTo', 'required|trim');
    $this->form_validation->set_message('required', '%s is required');

    if ($this->form_validation->run() == FALSE) {
      if (empty($piId)) {
        return json_encode(array('st' => 202, 'invoice_no' => form_error('invoice_no'), 'invoice_date' => form_error('invoice_date'), 'items' => form_error('items'), 'quantity' => form_error('quantity'), 'unit_price' => form_error('unit_price'), 'billedby' => form_error('billedby'), 'billedto' => form_error('billedto')));
      } else {
        return json_encode(array('st' => 202, 'invoice_date' => form_error('invoice_date'), 'items' => form_error('items'), 'quantity' => form_error('quantity'), 'unit_price' => form_error('unit_price'), 'billedby' => form_error('billedby'), 'billedto' => form_error('billedto')));
      }
    } else {
      return 200;
    }
  }
  public function uploadSignature($signature_image)
  {
    $folderPath = "./assets/pi_images/";

    $image_parts = explode(";base64,", $signature_image);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);
    $uniqid = uniqid();
    $file = $folderPath . $uniqid . '.' . $image_type;
    file_put_contents($file, $image_base64);
    return $signature_img = $uniqid . '.' . $image_type;
  }
  public function update_branch()
  {
    $data = array(
      'branch_name' => $this->input->post('branch_name'),
      'branch_email' => $this->input->post('branch_email'),
      'company_name' => $this->input->post('comp_name'),
      'contact_number' => $this->input->post('branch_phone'),
      'gstin' => $this->input->post('branch_gstin'),
      'cin' => $this->input->post('branch_cin'),
      'pan' => $this->input->post('branch_pan'),
      'country' => $this->input->post('country_br'),
      'state' => $this->input->post('state_br'),
      'city' => $this->input->post('city_br'),
      'zipcode' => $this->input->post('zipcode_br'),
      'address' => $this->input->post('address_br'),
      'show_email' => $this->input->post('show_email'),
    );
    $this->Branch_model->update(array('id' => $this->input->post('branch_id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  //check invoice no
  public function check_invoiceduplicate()
  {
    if ($this->Performainvoice->check_invice_no($_POST['invoice_no'])) {
      echo '<span style="color:red;font-size:10px;"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Invoice no already exit!</span>';
      echo "<script>$('#invoiceSave').prop('disabled',true);</script>";
    } else {
      echo "<script>$('#invoiceSave').prop('disabled',false);</script>";
    }
  }
  /******old generate pdf template****/
  public function generate_pdf_old()
  {
    $product_id = base64_decode($_GET['pi']);
    $cnp = base64_decode($_GET['cnp']);
    $ceml = base64_decode($_GET['ceml']);

    $row = $this->Performainvoice->get_pi_byId($product_id, $cnp, $ceml);
    if ($row['id']) {
      $rowOwner = $this->Performainvoice->get_Owner($row['sess_eml']);
      if (empty($rowOwner['standard_name'])) {
        $rowOwner = $this->Performainvoice->get_Admin($row['sess_eml']);
      }
      $compnyDtail = $this->Performainvoice->get_Comp($row['session_comp_email']);

      $otherdata = $this->Performainvoice->get_data_detail($row['page_name'], $row['page_id']);
      $branch = $this->Performainvoice->getBranchData($row['billedby_branchid']);
      $clientDtl = $this->Performainvoice->getVendorOrgData($row['billedto_orgname'], $row['page_name']);
      $bank_details_terms = $this->Performainvoice->get_bank_details();
      //$this->load->view('setting/proforma_view_detail',$data);

      $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Proforma Invoice</title>
		 <link rel="shortcut icon" type="image/png" href="' . base_url() . 'assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>PROFORMA INVOICE</b></h5>
				<hr style="width: 250px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>

			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
				  <span><b>' . $branch['company_name'] . '</b></span><br>
				  <span>' . $branch["address"] . '</span><br>
				  <span>' . $branch["city"] . ',&nbsp;' . $branch["state"] . '&nbsp;' . $branch["zipcode"] . '</span><br>
				  <span><a style="text-decoration:none" href="' . $compnyDtail['company_website'] . '">' . $compnyDtail['company_website'] . '</a></span><br>
				  <span>' . $branch["contact_number"] . '</span><br>
				  <span><b>GSTIN:</b>&nbsp;' . $branch["gstin"] . '</span><br>
				  <span><b>CIN:</b>&nbsp;' . $branch["cin"] . '</span><br>
				</td>
				<td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;" class="float-right"  >
				
        			<table class="float-right" >
                     <tr> 
					 <td colspan="2" style="text-align:right">';
      $image = $compnyDtail['company_logo'];
      if (!empty($image)) {
        $output .=  '<img style="width: 100px;" src="./uploads/company_logo/' . $image . '">';
      } else {
        $output .=  '<span class="h5 text-primary">' . $compnyDtail['company_name'] . '</span>';
      }
      $output .= '
				</td>
				
                   </tr>
                    <tr><td colspan="2"  >
                    <span style="font-weight: bold;">INVOICE NO : </span>&nbsp;<span>' . $row['invoice_no'] . '</span><br>
        				<b>DATE : </b><span >' . date('d-M-Y') . '</span><br>
						<b>DUE DATE : </b><span>' . date('d-M-Y', strtotime($row['due_date'])) . '</span>
                        </td>
                        </tr>
                    </table>
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:20px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">' . $row['billedto_orgname'] . '</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>' . $clientDtl['primary_contact'] . '</span><br>
				  <span style="white-space: pre-line">' . $clientDtl['billing_address'] . '</span>,
				  <span>' . $clientDtl['billing_state'] . '</span><br>
				  <span>' . $clientDtl['city'] . '</span>&nbsp;,<span>' . $clientDtl['billing_zipcode'] . '</span>&nbsp;,<span>' . $clientDtl['country'] . '</span><br>
				
				</td>

				<td colspan="6" style="font-size: 12px;" >
				<table class="float-right" >
                     <tr> <td>
					<b>Place Of supply</b> : 
					<span>' . $clientDtl['billing_state'] . '</span><br>
					<b>Sales Person</b> : 
					<span>' . $rowOwner['standard_name'] . '</span><br>
					<b>Sales  Mobile</b> : 
					<span>' . $rowOwner['standard_mobile'] . '</span><br>
					</td></tr></table>
				</td>
			</tr>
			
        </table>  

        <table class="table-responsive-sm table-striped text-center table-bordered" style="width:100% !important; ">
            <thead style="background: #50b1bd; color: #fff; font-size: 12px;">
                <tr>
                    <th>S.No.</th>
                    <th>Product/Services</th>
                    <th>HSN/SAC</th>
                    <th>Qty</th>
                    <th>Rate</th>';
      $output .= '<th>Tax</th>';
      $output .= '<th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 12px;">';
      $product_name = explode("<br>", $row['product_name']);
      $quantity = explode("<br>", $row['quantity']);
      $unit_price = explode("<br>", $row['unit_price']);
      $total = explode("<br>", $row['total']);
      $hsnsac = explode("<br>", $row['hsn_sac']);
      if (!empty($row['gst'])) {
        $gst = explode("<br>", $row['gst']);
      }

      $igsttotal = 0;
      $sgsttotal = 0;
      $cgsttotal = 0;
      $igst = explode("<br>", $row['igst']);
      $sgst = explode("<br>", $row['sgst']);
      $cgst = explode("<br>", $row['cgst']);


      $arrlength = count($product_name);
      $arrlength = count($product_name);
      for ($x = 0; $x < $arrlength; $x++) {

        if (isset($igst[$x]) && $igst[$x] != "") {
          $igsttotal = $igsttotal + $igst[$x];
        }
        if (isset($sgst[$x]) && $sgst[$x] != "") {
          $sgsttotal = $sgsttotal + $sgst[$x];
        }
        if (isset($igst[$x]) && $igst[$x] != "") {
          $cgsttotal = $cgsttotal + $igst[$x];
        }

        $num = $x + 1;
        $output .= '<tr>
						<td style="padding:5px; 0px;">' . $num . '</td>
						<td style="padding:5px; 0px;">' . $product_name[$x] . '</td>
						<td style="padding:5px; 0px;">' . $hsnsac[$x] . '</td>
						<td style="padding:5px; 0px;">' . $quantity[$x] . '</td>
						<td style="padding:5px; 0px;">' . IND_money_format($unit_price[$x]) . '</td>';
        if (!empty($gst)) {
          $output .= '<td style="padding:5px; 0px;">GST@' . $gst[$x] . '%</td>';
        }
        $output .= '<td style="padding:5px; 0px;">' . IND_money_format($total[$x]) . '/-</td>
					</tr>';
      }
      $output .= '
            </tbody>
        </table>

        <table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
				<br>
					<span class="h6">Terms And Conditions :-</span><br>
					<span style="white-space: pre-line;font-size: 10px;"></span><br>
					<span>' . nl2br($row['terms_condition']) . '</span><br>';

      $output .= '
				</td>
				<td colspan="2">
				</td>
				<td colspan="4" style="padding:3px;">
					<table class="float-right" style="border: 1px solid #ffffff; font-size:12px; ">
						<tr>
							<td style="padding-bottom:8px;">
							Initial Total:</td>
							<td style="padding:0px;"><span class="float-right" id="">' . IND_money_format($row['initial_total']) . '/-</span></td>
						</tr>
						<tr>
							<td style="padding-bottom:8px;">Discount:</td>
							<td style="padding:0px;"><span class="float-right" id="">' . $row['total_discount'] . '/-</span></td>
						</tr>';

      if ($igsttotal != 0) {
        $output .= '<tr>
							<td style="padding-bottom:8px;">IGST :</td>
							<td style="padding-bottom:1px;"><span class="float-right">' . IND_money_format($igsttotal) . '/-</span></td>
							</tr>';
      } else {

        if ($sgsttotal != 0) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>SGST :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($sgsttotal) . '/-</span></td>
								</tr>';
        }
        if ($cgsttotal != 0) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>CGST :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($cgsttotal) . '/-</span></td>
								</tr>';
        }
      }
      if ($row['extraCharge_name'] != "") {
        $extraCharge_name = explode("<br>", $row['extraCharge_name']);
        $extraCharge_value = explode("<br>", $row['extraCharge_value']);
        for ($y = 0; $y < count($extraCharge_name); $y++) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>' . $extraCharge_name[$y] . ' :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($extraCharge_value[$y]) . '/-</span></td>
								</tr>';
        }
      }


      $output .= '
						<tr style="">
							<td style="padding-left:5px; padding-bottom:5px;" class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding-left:5px;padding-right:5px; padding-bottom:5px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><b>INR ' . IND_money_format($row['final_total']) . '/-</b></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table>';
      if (isset($_GET['dn']) && $_GET['dn'] == 1) {
        if ($bank_details_terms->enable_payment == 1) {
          $output .= '<table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6">
					
					<a href="' . base_url() . '" style="text-decoration:none; display:block; margin: 25px auto 15px; width:100%; color:#fff; background:#17a2b8; text-align:center; padding:10px;><i class="fas fa-money-bill-wave-alt"></i>Pay Now</a>
				</td>
			</tr>
        </table>';
        }
      }
      $output .= '<table width="100%" style="position:fixed; bottom: 60; font-size:11px;">

          <tr style="height:40px;">
            <td style="width:65%"> <b>Accepted By</b><br>
			<b>Accepted Date</b> : ' . date('d F Y') . '
			</td>
			
			<td colspan="3">
			</td>
			<td style="width:35%">
    			<table width="100%">
    			<tr>
					<td><b>Proforma Created By</b> : </td><td>' . ucfirst($rowOwner['standard_name']) . '</td>
    			</tr>
    			<tr><td><b>Proforma Created Date : </td><td>' . date("d F Y", strtotime($row['currentdate'])) . '</td>
				</tr>
				</table>
			</td>
			
          </tr>
		 
		  
        </table>';

      $output .= '<footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated Quotation Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - ' . $this->session->userdata('company_email') . '</br>
             | Ph. - +91-' . $branch['contact_number'] . '</br>
              | GSTIN: ' . $branch['gstin'] . '</br>
               | CIN: ' . $branch['cin'] . '</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
    }

    //print_r($output); die;
    $this->load->library('pdf');
    $this->dompdf->loadHtml($output);
    ini_set('memory_limit', '128M');
    $this->dompdf->render();
    if (isset($_GET['dn']) && $_GET['dn'] == 1) {
      $this->dompdf->stream("proforma_invoice_" . $product_id . ".pdf", array("Attachment" => 1));
    } else {
      $this->dompdf->stream("proforma_invoice_" . $product_id . ".pdf", array("Attachment" => 0));
    }
  }

  /*****new generate pdf template*****/
  public function generate_pdf()
  {
    $product_id = base64_decode($_GET['pi']);
    $cnp = base64_decode($_GET['cnp']);
    $ceml = base64_decode($_GET['ceml']);

    $row = $this->Performainvoice->get_pi_byId($product_id, $cnp, $ceml);
    if ($row['id']) {
      $rowOwner = $this->Performainvoice->get_Owner($row['sess_eml']);
      if (empty($rowOwner['standard_name'])) {
        $rowOwner = $this->Performainvoice->get_Admin($row['sess_eml']);
      }
      $compnyDtail = $this->Performainvoice->get_Comp($row['session_comp_email']);

      $otherdata = $this->Performainvoice->get_data_detail($row['page_name'], $row['page_id']);
      $branch = $this->Performainvoice->getBranchData($row['billedby_branchid']);
      $clientDtl = $this->Performainvoice->getVendorOrgData($row['billedto_orgname'], $row['page_name']);
      $bank_details_terms = $this->Performainvoice->get_bank_details();
      //$this->load->view('setting/proforma_view_detail',$data);


      $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Proforma Invoice</title>
                <link rel="shortcut icon" type="image/png" href="' . base_url() . 'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
              <style>
                 @page{
                      margin-top: 20px; /* create space for header */
                    }
                 footer .pagenum:before {
                     content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">
              
                <footer style="position: fixed;bottom: 30;border-top:1px dashed #333; " >
                  <div class="pagenum-container"style="text-align:right;font-size:12px;">Page <span class="pagenum"> </span>of TPAGE</div>
                  <center>
        		  <span style="font-size:12px"><b>"This is System Generated PI, Sign and Stamp not Required"</b></span><br>
                  <b><span style="font-size: 10px;">E-mail - ' . $branch["branch_email"] . '</br>
                     | Ph. - +91-' . $branch["contact_number"] . '</br>
                      | GSTIN: ' . $branch["gstin"] . '</br>
                       | CIN: ' . $branch["cin"] . '</span></b><br>
                    <b><span style="font-size:12px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b>  
                  </center>
                
                </footer>
              
              <main style="margin-bottom:30px;">
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Proforma Invoice</h3>
                         <p style="margin-bottom: 0;font-size: 12px;"><text style="color: #9c9999;display:inline-block; width:20%;">Invoice No#</text><text style="display:inline-block;"> ' . $row['invoice_no'] . ' </text><br>
                        <text style="color: #9c9999;display:inline-block; width:20%;"> Invoice Date: </text><text style="display:inline-block;"> ' . date("d F Y", strtotime($row['invoice_date'])) . '</text><br>
                        <text style="color: #9c9999;display:inline-block; width:20%;">Due Date: </text><text style="display:inline-block;"> ' . date("d F Y", strtotime($row['due_date'])) . '</text>
                             </p>
                       </td>
                       <td colspan="2" style="text-align:right">';
      $image = $compnyDtail['company_logo'];
      if (!empty($image)) {
        $output .=  '<img style="width: 70px;" src="./uploads/company_logo/' . $image . '">';
      } else {
        $output .=  '<span class="h5 text-primary">' . $compnyDtail['company_name'] . '</span>';
      }
      $output .= '
        				</td>
                    </tr>
                     </tbody>
                    </table>
                     <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                    
                        <tr>
                         <td style="width: 49.5%; padding: 10px;">
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Proforma invoice from</h4>
                            <p style="margin: 0;font-size: 14px;">' . $branch['company_name'] . '</p>
        					
                           ';
      if ($branch["address"] != "") {
        $output .=  ' <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">' . $branch["address"];
      }
      if ($branch["city"] != "") {
        $output .=  ', ' . $branch["city"];
      }
      if ($branch["zipcode"] != "") {
        $output .=  ' - ' . $branch["zipcode"];
      }
      if ($branch["state"] != "") {
        $output .=  ', ' . $branch["state"];
      }

      if ($branch["country"] != "") {
        $output .=  ', ' . $branch["country"];
      }
      $output .=  '</p>';
      if ($branch["branch_email"] != "") {
        $output .=  '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b> ' . $branch["branch_email"] . ' <br>
                          <b>Phone:</b> +91-' . $branch["contact_number"] . '</p>';
      }
      $output .=  '</td>
                       <td style="width: 1%;background:#fff;"></td>
                       <td style="width: 49.5%; padding: 10px;">
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Proforma invoice for</h4>
                          <p style="margin: 0;font-size: 12px;">' .
        $row['billedto_orgname'];
      if (!empty($clientDtl['primary_contact'])) {
        $output .= '<br><text style="font-size:12px;">
                            <b>Contact Name :</b> ' . $clientDtl['primary_contact'];
      }
      $output .= '</text></p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">';

      if (!empty($clientDtl['billing_address'])) {
        $output .= $clientDtl['billing_address'];
      }
      if (!empty($clientDtl['city'])) {
        $output .= ', ' . $clientDtl['city'];
      }
      if (!empty($clientDtl['billing_zipcode'])) {
        $output .= ' - ' . $clientDtl['billing_zipcode'];
      }
      if (!empty($clientDtl['billing_state'])) {
        $output .= ', ' . $clientDtl['billing_state'];
      }
      if (!empty($clientDtl['country'])) {
        $output .= ', ' . $clientDtl['country'];
      }
      $output .= '</p>';

      if (isset($clientDtl['email'])) {
        $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b>' . $clientDtl['email'] . ' <br>
                          <b>Phone:</b> +91-' . $clientDtl["mobile"] . '</p>';
      }
      $output .= '</td>
                    </tr>
                </table>
                <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Country of Supply : </b>' . $clientDtl['country'] . '</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Place of Supply : </b>' . $clientDtl['billing_state'] . '</p>
                      </td>
                    </tr>
                 </tbody>
                </table>
        
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">';

      $igsttotal = 0;
      $sgsttotal = 0;
      $cgsttotal = 0;
      $igst = explode("<br>", $row['igst']);
      $sgst = explode("<br>", $row['sgst']);
      $cgst = explode("<br>", $row['cgst']);



      $output .= '<tr>
                       <th width="18%" style="font-size: 12px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">
                       Product/Services</div></th>
                       <th style="font-size: 12px; background: #6539c0;">HSN/SAC</th>
                      
                       <th style="font-size: 12px; background: #6539c0;">Qty</th>
                       <th style="font-size: 12px; background: #6539c0;">Rate</th>
                       <th style="font-size: 12px; background: #6539c0;">Tax</th>
                       <th style="font-size: 12px; background: #6539c0;">Amount</th>';

      if (!empty($row['gst']) && $igst[0] != "") {
        $output .= '<th style="font-size: 12px; background: #6539c0;">IGST</th>';
      } elseif (!empty($sgst)) {
        $output .= '<th style="font-size: 12px; background: #6539c0;">SGST</th><th style="font-size: 12px; background: #6539c0;">CGST</th>';
      }
      $output .= '<th style="font-size: 12px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 11px;">Tot. Price</div></th>
                       </tr>
                   </thead>
                   <tbody >';

      $product_name = explode("<br>", $row['product_name']);
      $quantity = explode("<br>", $row['quantity']);
      $unit_price = explode("<br>", $row['unit_price']);
      $total = explode("<br>", $row['total']);
      $total_withgst = explode("<br>", $row['sub_totalwithgst']);
      //$sku = explode("<br>",$row['sku']);
      $hsnsac = explode("<br>", $row['hsn_sac']);
      $after_discount = ($row['initial_total'] - $row['total_discount']);
      $proDesc = explode("<br>", $row['pro_description']);
      if (!empty($row['gst'])) {
        $gst = explode("<br>", $row['gst']);
      }


      $arrlength = count($product_name);
      $newLenth = ($arrlength);
      $rw = 0;
      for ($x = 0; $x < $newLenth; $x++) {
        $rw++;
        $num = $x + 1;

        if (isset($igst[$x]) && $igst[$x] != "") {
          $igsttotal = $igsttotal + $igst[$x];
        }
        if (isset($sgst[$x]) && $sgst[$x] != "") {
          $sgsttotal = $sgsttotal + $sgst[$x];
        }
        if (isset($igst[$x]) && $cgst[$x] != "") {
          $cgsttotal = $cgsttotal + $cgst[$x];
        }


        $output .= '<tr>
        						
        						<td style="font-size: 12px; padding:10px; border-top: 1px solid #dee2e6;">' . $product_name[$x] . '</td>
        						
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">' . $hsnsac[$x] . '</td>
        						
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;">' . $quantity[$x] . '</td>
        						<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($unit_price[$x]) . '</td>';
        if (!empty($gst)) {
          $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;">GST@' . $gst[$x] . '%</td>';
        } else {
          $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;">GST@18%</td>';
        }

        $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total[$x]) . '</td>';

        if (!empty($row['gst']) && $igst[$x] != "") {
          $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $igst[$x] . '</td>';
        } elseif ($sgst[$x] != "") {
          $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $sgst[$x] . '</td><td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $cgst[$x] . '</td>';
        }

        $output .= '<td style="font-size: 12px; border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total_withgst[$x]) . '</td>
        					</tr>';
        if (isset($proDesc[$x]) && $proDesc[$x] != "") {
          $output .= '<tr >
        						<td colspan="7" style="font-size: 12px; padding:10px;">' . $proDesc[$x] . '</td></tr>';
        }
      }

      $output .= '
                  </tbody>
                </table>
        
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px;"><b>Total in words:</b> <text> ' . AmountInWords($row["final_total"]) . ' only</text></p>';
      //if(isset($download , $bank_details_terms) && $download=='dn' ){
      //if(isset($bank_details_terms)){
      if (isset($bank_details_terms) && $bank_details_terms->enable_payment == 1) {

        $output .= '<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:12px;padding:7px;">
                               <tr>
                                <td colspan="3">
                                 
                                    <h5 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0; font-size:13px;">Bank Details</h5>
                                </td>
                               </tr>
                              
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Holder Name:  <th>
                                   <td>' . ucfirst($bank_details_terms->acc_holder_name) . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
                                   <td>' . $bank_details_terms->account_no . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
                                   <td>' . $bank_details_terms->ifsc_code . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
                                   <td>' . ucfirst($bank_details_terms->account_type) . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
                                   <td>' . ucfirst($bank_details_terms->bank_name) . '</td>
                               </tr><tr>';

        if ($bank_details_terms->upi_id != "") {
          $output .= '<th style="text-align:left;  padding-left:10px;">UPI Id:<th>
                                   <td>' . $bank_details_terms->upi_id . '</td>';
        }
        if (isset($_GET['dn']) && $_GET['dn'] == 1) {
          $output .= '<th style="text-align:left;padding-left:10px;"><a href="' . base_url("home") . '" style="text-decoration:none; background:#6539c0; color:#fff; font-size:10px; padding:4px; display:inline-block; border-radius:3px;">Pay Now</a></th>';
        }

        $output .= '</tr>
                             </table>';
      }

      $output .= '</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row["initial_total"]) . '</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $row["discount"] . '</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($after_discount) . '</td>
                          </tr>';

      if ($igsttotal != 0) {
        $output .= '<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($igsttotal) . '</td></tr>';
      } else {

        if ($sgsttotal != 0) {
          $output .= '<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($sgsttotal) . '</td></tr>';
        }
        if ($cgsttotal != 0) {
          $output .= '<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($cgsttotal) . '</td></tr>';
        }
      }
      if ($row['extraCharge_name'] != "") {
        $extraCharge_name = explode("<br>", $row['extraCharge_name']);
        $extraCharge_value = explode("<br>", $row['extraCharge_value']);
        for ($y = 0; $y < count($extraCharge_name); $y++) {
          $output .= '<tr><th style="font-size: 12px;" align="left">' . $extraCharge_name[$y] . '</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($extraCharge_value[$y]) . '</td></tr>';
        }
      }

      $output .= '
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row["final_total"]) . '</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';

      $output .= '<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:';
      if (isset($bank_details_terms) && $bank_details_terms->enable_payment == 1) {
        $output .= '0px;">';
      } else {
        $output .= '-20px;">';
      }
      $output .= '<tbody>';
      if (isset($row["notes"]) && $row["notes"] != "") {
        $output .= '<tr>
					  <td align="left">
						<h5 style="color: #6539c0;margin-bottom: 10px;">Notes</h5>
						';
        $output .= '<span style="font-size:12px;">' . $row["notes"];
        $output .= '</span>
					  </td>
					</tr>';
      }
      $output .= ' <tr>
                  <td align="left">
                    <h5 style="color: #6539c0;margin-bottom: 10px;">Terms and Conditions</h5>
                    <ol style="padding: 0 15px; font-size:12px;">';
      $custTerm = explode("<br>", $row["terms_condition"]);
      $no = 1;
      for ($i = 0; $i < count($custTerm); $i++) {
        $output .= '<li>' . $custTerm[$i] . '</li>';
      }
      //'.nl2br($row->terms_condition).'
      $output .= '</ol>
                  </td>
                </tr>
                  </tbody>
                </table>
        
              </main>
        
              </body>
              </html>';
      //return $output;

    }

    //print_r($output); die;
    $this->load->library('pdf');
    $this->dompdf->loadHtml($output);
    ini_set('memory_limit', '128M');
    $this->dompdf->render();
    $canvas = $this->dompdf->getCanvas();
    $pdf = $canvas->get_cpdf();

    foreach ($pdf->objects as &$o) {
      if ($o['t'] === 'contents') {
        $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
      }
    }

    if (isset($_GET['dn']) && $_GET['dn'] == 1) {
      $this->dompdf->stream("proforma_invoice_" . $product_id . ".pdf", array("Attachment" => 1));
    } else {
      $this->dompdf->stream("proforma_invoice_" . $product_id . ".pdf", array("Attachment" => 0));
    }
  }

  public function getbankdetails()
  {
    $data = $this->Performainvoice->get_bank_details();
    if ($data) {
      echo json_encode($data);
    } else {
      echo json_encode(array("st" => "add"));
    }
  }
  public function changebankstatus()
  {
    $bankdetails_id = $this->input->post('bankdetails_id');
    $bank_status = $this->input->post('bank_status');
    $data = array(
      'enable_payment'       => $bank_status
    );
    $data = $this->Performainvoice->update_bank_detail($data, $bankdetails_id);
    if ($data) {
      echo json_encode(array("st" => 200));
    } else {
      echo json_encode(array("st" => 201));
    }
  }


  public function create_bankDetails()
  {

    $validation = $this->check_validation_bank();
    if ($validation != 200) {
      echo $validation;
      die;
    } else {

      if ($this->input->post('terms_conditionbnk')) {
        $terms_bnk = implode("<br>", $this->input->post('terms_conditionbnk'));
      } else {
        $terms_bnk = '';
      }
      $data = array(
        'sess_eml'       => $this->session->userdata('email'),
        'session_company'   => $this->session->userdata('company_name'),
        'session_comp_email' => $this->session->userdata('company_email'),
        'bank_name'     => $this->input->post('bank_name'),
        'account_no'       => $this->input->post('account_no'),
        'acc_holder_name'   => $this->input->post('acc_holder_name'),
        'ifsc_code'     => $this->input->post('ifsc_code'),
        'account_type'     => $this->input->post('account_type'),
        'register_mobile'   => $this->input->post('mobile_no'),
        'upi_id'       => $this->input->post('upi_id'),
        'terms_condition'   => $terms_bnk,
        'bank_country'     => $this->input->post('bank_country'),

      );
      $id = $this->Performainvoice->create_bank_detail($data);
      if ($id) {
        echo json_encode(array("status" => TRUE, 'st' => 200));
      } else {
        echo json_encode(array("status" => FALSE));
      }
    }
  }
  public function update_bankDetails()
  {

    $validation = $this->check_validation_bank();
    if ($validation != 200) {
      echo $validation;
      die;
    } else {
      if ($this->input->post('terms_conditionbnk')) {
        $terms_bnk = implode("<br>", $this->input->post('terms_conditionbnk'));
      } else {
        $terms_bnk = '';
      }

      $data = array(
        'sess_eml'       => $this->session->userdata('email'),
        'session_company'   => $this->session->userdata('company_name'),
        'session_comp_email' => $this->session->userdata('company_email'),
        'bank_name'     => $this->input->post('bank_name'),
        'account_no'       => $this->input->post('account_no'),
        'acc_holder_name'   => $this->input->post('acc_holder_name'),
        'ifsc_code'     => $this->input->post('ifsc_code'),
        'account_type'     => $this->input->post('account_type'),
        'register_mobile'   => $this->input->post('mobile_no'),
        'upi_id'       => $this->input->post('upi_id'),
        'terms_condition'   => $terms_bnk,
        'bank_country'     => $this->input->post('bank_country'),

      );
      $acc_id = $this->input->post('account_details_id');
      //$this->Performainvoice->update_bank_detail($data,$acc_id);
      if ($this->Performainvoice->update_bank_detail($data, $acc_id)) {
        echo json_encode(array("status" => TRUE, 'st' => 200));
      } else {
        echo json_encode(array("status" => FALSE));
      }
    }
  }
  public function check_validation_bank()
  {
    //print_r($this->input->post());
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    //$piId=$this->input->post('invc_id');
    //if(empty($piId)){
    //$this->form_validation->set_rules('invoice_no', 'Invoice Number', 'required|trim|is_unique[performa_invoice.invoice_no]');
    //}
    $this->form_validation->set_rules('bank_country', 'Bank Country', 'required|trim');
    $this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim');
    $this->form_validation->set_rules('acc_holder_name', 'Account Holder Name', 'required|trim');
    $this->form_validation->set_rules('account_no', 'Acoount Number', 'required|trim');
    $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'required|trim');
    $this->form_validation->set_rules('mobile_no', 'Phone no', 'required|trim');
    $upichecked = $this->input->post('check_upi');
    if ($upichecked == 'checked_upi') {
      $this->form_validation->set_rules('upi_id', 'UPI Id', 'required|trim');
    }

    $this->form_validation->set_message('required', '%s is required');

    if ($this->form_validation->run() == FALSE) {
      if ($upichecked == 'checked_upi') {
        return json_encode(array('st' => 202, 'bank_country' => form_error('bank_country'), 'bank_name' => form_error('bank_name'), 'acc_holder_name' => form_error('acc_holder_name'), 'account_no' => form_error('account_no'), 'ifsc_code' => form_error('ifsc_code'), 'mobile_no' => form_error('mobile_no'), 'upi_id' => form_error('upi_id')));
      } else {
        return json_encode(array('st' => 202, 'bank_country' => form_error('bank_country'), 'bank_name' => form_error('bank_name'), 'acc_holder_name' => form_error('acc_holder_name'), 'account_no' => form_error('account_no'), 'ifsc_code' => form_error('ifsc_code'), 'mobile_no' => form_error('mobile_no')));
      }
    } else {
      return 200;
    }
  }

  public function generate_pdf_attachment_old($product_id, $cnp, $ceml)
  {
    $row = $this->Performainvoice->get_pi_byId($product_id, $cnp, $ceml);
    if ($row['id']) {
      $rowOwner = $this->Performainvoice->get_Owner($row['sess_eml']);
      if (empty($rowOwner['standard_name'])) {
        $rowOwner = $this->Performainvoice->get_Admin($row['sess_eml']);
      }
      $compnyDtail = $this->Performainvoice->get_Comp($row['session_comp_email']);

      $otherdata = $this->Performainvoice->get_data_detail($row['page_name'], $row['page_id']);
      $branch = $this->Performainvoice->getBranchData($row['billedby_branchid']);
      $clientDtl = $this->Performainvoice->getVendorOrgData($row['billedto_orgname'], $row['page_name']);
      //$this->load->view('setting/proforma_view_detail',$data);

      $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Proforma Invoice</title>
		 <link rel="shortcut icon" type="image/png" href="' . base_url() . 'assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>PROFORMA INVOICE</b></h5>
				<hr style="width: 250px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>

			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
				  <span><b>' . $branch['company_name'] . '</b></span><br>
				  <span>' . $branch["address"] . '</span><br>
				  <span>' . $branch["city"] . ',&nbsp;' . $branch["state"] . '&nbsp;' . $branch["zipcode"] . '</span><br>
				  <span><a style="text-decoration:none" href="' . $compnyDtail['company_website'] . '">' . $compnyDtail['company_website'] . '</a></span><br>
				  <span>' . $branch["contact_number"] . '</span><br>
				  <span><b>GSTIN:</b>&nbsp;' . $branch["gstin"] . '</span><br>
				  <span><b>CIN:</b>&nbsp;' . $branch["cin"] . '</span><br>
				</td>
				<td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;" class="float-right"  >
				
        			<table class="float-right" >
                     <tr> 
					 <td colspan="2" style="text-align:right">';
      $image = $compnyDtail['company_logo'];
      if (!empty($image)) {
        $output .=  '<img style="width: 100px;" src="./uploads/company_logo/' . $image . '">';
      } else {
        $output .=  '<span class="h5 text-primary">' . $compnyDtail['company_name'] . '</span>';
      }
      $output .= '
				</td>
				
                   </tr>
                    <tr><td colspan="2"  >
                    <span style="font-weight: bold;">INVOICE NO : </span>&nbsp;<span>' . $row['invoice_no'] . '</span><br>
        				<b>DATE : </b><span >' . date('d-M-Y') . '</span><br>
						<b>DUE DATE : </b><span>' . date('d-M-Y', strtotime($row['due_date'])) . '</span>
                        </td>
                        </tr>
                    </table>
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:20px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">' . $row['billedto_orgname'] . '</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>' . $clientDtl['primary_contact'] . '</span><br>
				  <span style="white-space: pre-line">' . $clientDtl['billing_address'] . '</span>,
				  <span>' . $clientDtl['billing_state'] . '</span><br>
				  <span>' . $clientDtl['city'] . '</span>&nbsp;,<span>' . $clientDtl['billing_zipcode'] . '</span>&nbsp;,<span>' . $clientDtl['country'] . '</span><br>
				
				</td>

				<td colspan="6" style="font-size: 12px;" >
				<table class="float-right" >
                     <tr> <td>
					<b>Place Of supply</b> : 
					<span>' . $clientDtl['billing_state'] . '</span><br>
					<b>Sales Person</b> : 
					<span>' . $rowOwner['standard_name'] . '</span><br>
					<b>Sales  Mobile</b> : 
					<span>' . $rowOwner['standard_mobile'] . '</span><br>
					</td></tr></table>
				</td>
			</tr>
			
        </table>  

        <table class="table-responsive-sm table-striped text-center table-bordered" style="width:100% !important; ">
            <thead style="background: #50b1bd; color: #fff; font-size: 12px;">
                <tr>
                    <th>S.No.</th>
                    <th>Product/Services</th>
                    <th>HSN/SAC</th>
                    <th>Qty</th>
                    <th>Rate</th>';
      $output .= '<th>Tax</th>';
      $output .= '<th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 12px;">';
      $product_name = explode("<br>", $row['product_name']);
      $quantity = explode("<br>", $row['quantity']);
      $unit_price = explode("<br>", $row['unit_price']);
      $total = explode("<br>", $row['total']);
      $hsnsac = explode("<br>", $row['hsn_sac']);
      if (!empty($row['gst'])) {
        $gst = explode("<br>", $row['gst']);
      }

      $igsttotal = 0;
      $sgsttotal = 0;
      $cgsttotal = 0;
      $igst = explode("<br>", $row['igst']);
      $sgst = explode("<br>", $row['sgst']);
      $cgst = explode("<br>", $row['cgst']);


      $arrlength = count($product_name);
      $arrlength = count($product_name);
      for ($x = 0; $x < $arrlength; $x++) {

        if (isset($igst[$x]) && $igst[$x] != "") {
          $igsttotal = $igsttotal + $igst[$x];
        }
        if (isset($sgst[$x]) && $sgst[$x] != "") {
          $sgsttotal = $sgsttotal + $sgst[$x];
        }
        if (isset($igst[$x]) && $igst[$x] != "") {
          $cgsttotal = $cgsttotal + $igst[$x];
        }

        $num = $x + 1;
        $output .= '<tr>
						<td style="padding:5px; 0px;">' . $num . '</td>
						<td style="padding:5px; 0px;">' . $product_name[$x] . '</td>
						<td style="padding:5px; 0px;">' . $hsnsac[$x] . '</td>
						<td style="padding:5px; 0px;">' . $quantity[$x] . '</td>
						<td style="padding:5px; 0px;">' . IND_money_format($unit_price[$x]) . '</td>';
        if (!empty($gst)) {
          $output .= '<td style="padding:5px; 0px;">GST@' . $gst[$x] . '%</td>';
        }
        $output .= '<td style="padding:5px; 0px;">' . IND_money_format($total[$x]) . '/-</td>
					</tr>';
      }
      $output .= '
            </tbody>
        </table>

        <table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
				<br>
					<span class="h6">Terms And Conditions :-</span><br>
					<span style="white-space: pre-line;font-size: 10px;"></span><br>
					<span>' . nl2br($row['terms_condition']) . '</span><br>';

      $output .= '
				</td>
				<td colspan="2">
				</td>
				<td colspan="4" style="padding:3px;">
					<table class="float-right" style="border: 1px solid #ffffff; font-size:12px; ">
						<tr>
							<td style="padding-bottom:8px;">
							Initial Total:</td>
							<td style="padding:0px;"><span class="float-right" id="">' . IND_money_format($row['initial_total']) . '/-</span></td>
						</tr>
						<tr>
							<td style="padding-bottom:8px;">Discount:</td>
							<td style="padding:0px;"><span class="float-right" id="">' . $row['total_discount'] . '/-</span></td>
						</tr>';

      if ($igsttotal != 0) {
        $output .= '<tr>
							<td style="padding-bottom:8px;">IGST :</td>
							<td style="padding-bottom:1px;"><span class="float-right">' . IND_money_format($igsttotal) . '/-</span></td>
							</tr>';
      } else {

        if ($sgsttotal != 0) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>SGST :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($sgsttotal) . '/-</span></td>
								</tr>';
        }
        if ($cgsttotal != 0) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>CGST :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($cgsttotal) . '/-</span></td>
								</tr>';
        }
      }
      if ($row['extraCharge_name'] != "") {
        $extraCharge_name = explode("<br>", $row['extraCharge_name']);
        $extraCharge_value = explode("<br>", $row['extraCharge_value']);
        for ($y = 0; $y < count($extraCharge_name); $y++) {
          $output .= '<tr>
								<td style="padding-bottom:8px;"><b>' . $extraCharge_name[$y] . ' :</b></td>
								<td style="padding:0px;"><span class="float-right">' . IND_money_format($extraCharge_value[$y]) . '/-</span></td>
								</tr>';
        }
      }


      $output .= '
						<tr style="">
							<td style="padding-left:5px; padding-bottom:5px;" class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding-left:5px;padding-right:5px; padding-bottom:5px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><b>INR ' . IND_money_format($row['final_total']) . '/-</b></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table>
        <br>
       
        <table width="100%" style="position:fixed; bottom: 60; font-size:11px;">

          <tr style="height:40px;">
            <td style="width:65%"> <b>Accepted By</b><br>
			<b>Accepted Date</b> : ' . date('d F Y') . '
			</td>
			
			<td colspan="3">
			</td>
			<td style="width:35%">
    			<table width="100%">
    			<tr>
					<td><b>Proforma Created By</b> : </td><td>' . ucfirst($rowOwner['standard_name']) . '</td>
    			</tr>
    			<tr><td><b>Proforma Created Date : </td><td>' . date("d F Y", strtotime($row['currentdate'])) . '</td>
				</tr>
				</table>
			</td>
			
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated Quotation Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - ' . $this->session->userdata('company_email') . '</br>
             | Ph. - +91-' . $branch['contact_number'] . '</br>
              | GSTIN: ' . $branch['gstin'] . '</br>
               | CIN: ' . $branch['cin'] . '</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
    }

    $this->load->library('pdf');
    $this->dompdf->loadHtml($output);
    ini_set('memory_limit', '128M');
    $this->dompdf->render();
    $attachmentpdf =  $this->dompdf->output();
    $path = "assets/img/proforma_invoice_" . $product_id . ".pdf";
    file_put_contents($path, $attachmentpdf);
    return $path;
  }

  /************New attachment pdf********/
  public function generate_pdf_attachment($product_id, $cnp, $ceml)
  {
    $row = $this->Performainvoice->get_pi_byId($product_id, $cnp, $ceml);
    if ($row['id']) {
      $rowOwner = $this->Performainvoice->get_Owner($row['sess_eml']);
      if (empty($rowOwner['standard_name'])) {
        $rowOwner = $this->Performainvoice->get_Admin($row['sess_eml']);
      }
      $compnyDtail = $this->Performainvoice->get_Comp($row['session_comp_email']);

      $otherdata = $this->Performainvoice->get_data_detail($row['page_name'], $row['page_id']);
      $branch = $this->Performainvoice->getBranchData($row['billedby_branchid']);
      $clientDtl = $this->Performainvoice->getVendorOrgData($row['billedto_orgname'], $row['page_name']);
      //$this->load->view('setting/proforma_view_detail',$data);
      $bank_details_terms = $this->Performainvoice->get_bank_details();

      $output = '<!DOCTYPE html>
              <html>
              <head>
                <title>Team365 | Proforma Invoice</title>
                <link rel="shortcut icon" type="image/png" href="' . base_url() . 'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
              <style>
                 @page{
                      margin-top: 20px; /* create space for header */
                    }
                 footer .pagenum:before {
                     content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">
              
                <footer style="position: fixed;bottom: 30;border-top:1px dashed #333; " >
                  <div class="pagenum-container"style="text-align:right;font-size:12px;">Page <span class="pagenum"> </span>of TPAGE</div>
                  <center>
        		  <span style="font-size:12px"><b>"This is System Generated PI, Sign and Stamp not Required"</b></span><br>
                  <b><span style="font-size: 10px;">E-mail - ' . $branch["branch_email"] . '</br>
                     | Ph. - +91-' . $branch["contact_number"] . '</br>
                      | GSTIN: ' . $branch["gstin"] . '</br>
                       | CIN: ' . $branch["cin"] . '</span></b><br>
                    <b><span style="font-size:12px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b>  
                  </center>
                
                </footer>
              
              <main style="margin-bottom:30px;">
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Proforma Invoice</h3>
                         <p style="margin-bottom: 0;font-size: 12px;"><text style="color: #9c9999;">Invoice No#</text> ' . $row['invoice_no'] . ' <br>
                        <text style="color: #9c9999;"> Invoice Date </text> ' . date("d F Y", strtotime($row['invoice_date'])) . '<br>
                        <text style="color: #9c9999;">Due Date </text> ' . date("d F Y", strtotime($row['due_date'])) . '
                             </p>
                       </td>
                       <td colspan="2" style="text-align:right">';
      $image = $compnyDtail['company_logo'];
      if (!empty($image)) {
        $output .=  '<img style="width: 70px;" src="./uploads/company_logo/' . $image . '">';
      } else {
        $output .=  '<span class="h5 text-primary">' . $compnyDtail['company_name'] . '</span>';
      }
      $output .= '
        				</td>
                    </tr>
                     </tbody>
                    </table>
                     <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                    
                        <tr>
                         <td style="width: 49.5%; padding: 10px;">
                            <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Proforma invoice from</h4>
                            <p style="margin: 0;font-size: 14px;">' . $branch['company_name'] . '</p>
        					
                           ';
      if ($branch["address"] != "") {
        $output .=  ' <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">' . $branch["address"];
      }
      if ($branch["city"] != "") {
        $output .=  ', ' . $branch["city"];
      }
      if ($branch["zipcode"] != "") {
        $output .=  ' - ' . $branch["zipcode"];
      }
      if ($branch["state"] != "") {
        $output .=  ', ' . $branch["state"];
      }

      if ($branch["country"] != "") {
        $output .=  ', ' . $branch["country"];
      }
      $output .=  '</p>';
      if ($branch["branch_email"] != "") {
        $output .=  '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b> ' . $branch["branch_email"] . ' <br>
                          <b>Phone:</b> +91-' . $branch["contact_number"] . '</p>';
      }
      $output .=  '</td>
                       <td style="width: 1%;background:#fff;"></td>
                       <td style="width: 49.5%; padding: 10px;">
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Proforma invoice for</h4>
                          <p style="margin: 0;font-size: 12px;">' .
        $row['billedto_orgname'];
      if (!empty($clientDtl['primary_contact'])) {
        $output .= '<br><text style="font-size:12px;">
                            <b>Contact Name :</b> ' . $clientDtl['primary_contact'];
      }
      $output .= '</text></p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">';

      if (!empty($clientDtl['billing_address'])) {
        $output .= $clientDtl['billing_address'];
      }
      if (!empty($clientDtl['city'])) {
        $output .= ', ' . $clientDtl['city'];
      }
      if (!empty($clientDtl['billing_zipcode'])) {
        $output .= ' - ' . $clientDtl['billing_zipcode'];
      }
      if (!empty($clientDtl['billing_state'])) {
        $output .= ', ' . $clientDtl['billing_state'];
      }
      if (!empty($clientDtl['country'])) {
        $output .= ', ' . $clientDtl['country'];
      }
      $output .= '</p>';

      if (isset($clientDtl['email'])) {
        $output .= '<p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;"><b>Email:</b>' . $clientDtl['email'] . ' <br>
                          <b>Phone:</b> +91-' . $clientDtl["mobile"] . '</p>';
      }
      $output .= '</td>
                    </tr>
                </table>
                <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Country of Supply : </b>' . $clientDtl['country'] . '</p>
                      </td>
                      <td></td>
                      <td align="left" style="font-size:12px;width: 49.5%;">
                        <p><b>Place of Supply : </b>' . $clientDtl['billing_state'] . '</p>
                      </td>
                    </tr>
                 </tbody>
                </table>
        
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius: 7px; background: #efebf9;">
                   <thead style="color: #fff;" align="left">';

      $igsttotal = 0;
      $sgsttotal = 0;
      $cgsttotal = 0;
      $igst = explode("<br>", $row['igst']);
      $sgst = explode("<br>", $row['sgst']);
      $cgst = explode("<br>", $row['cgst']);



      $output .= '<tr>
                       <th width="18%" style="font-size: 12px;">
                        <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">
                       Product/Services</div></th>
                       <th style="font-size: 12px; background: #6539c0;">HSN/SAC</th>
                      
                       <th style="font-size: 12px; background: #6539c0;">Qty</th>
                       <th style="font-size: 12px; background: #6539c0;">Rate</th>
                       <th style="font-size: 12px; background: #6539c0;">Tax</th>
                       <th style="font-size: 12px; background: #6539c0;">Amount</th>';

      if (!empty($row['gst']) && $igst[0] != "") {
        $output .= '<th style="font-size: 12px; background: #6539c0;">IGST</th>';
      } elseif (!empty($sgst)) {
        $output .= '<th style="font-size: 12px; background: #6539c0;">SGST</th><th style="font-size: 12px; background: #6539c0;">CGST</th>';
      }
      $output .= '<th style="font-size: 12px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 11px;">Tot. Price</div></th>
                       </tr>
                   </thead>
                   <tbody >';

      $product_name = explode("<br>", $row['product_name']);
      $quantity = explode("<br>", $row['quantity']);
      $unit_price = explode("<br>", $row['unit_price']);
      $total = explode("<br>", $row['total']);
      $total_withgst = explode("<br>", $row['sub_totalwithgst']);
      //$sku = explode("<br>",$row['sku']);
      $hsnsac = explode("<br>", $row['hsn_sac']);
      $after_discount = ($row['initial_total'] - $row['total_discount']);
      if (!empty($row['gst'])) {
        $gst = explode("<br>", $row['gst']);
      }


      $arrlength = count($product_name);
      $newLenth = ($arrlength - 1);
      $rw = 0;
      for ($x = 0; $x < $newLenth; $x++) {
        $rw++;
        $num = $x + 1;

        if (isset($igst[$x]) && $igst[$x] != "") {
          $igsttotal = $igsttotal + $igst[$x];
        }
        if (isset($sgst[$x]) && $sgst[$x] != "") {
          $sgsttotal = $sgsttotal + $sgst[$x];
        }
        if (isset($igst[$x]) && $cgst[$x] != "") {
          $cgsttotal = $cgsttotal + $cgst[$x];
        }


        $output .= '<tr style="background: #efebf9;" >
        						
        						<td style="font-size: 12px; padding:10px;">' . $product_name[$x] . '</td>
        						
        						<td style="font-size: 12px;">' . $hsnsac[$x] . '</td>
        						
        						<td style="font-size: 12px;">' . $quantity[$x] . '</td>
        						<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($unit_price[$x]) . '</td>';
        if (!empty($gst)) {
          $output .= '<td style="font-size: 12px;">GST@' . $gst[$x] . '%</td>';
        } else {
          $output .= '<td style="font-size: 12px;">GST@18%</td>';
        }

        $output .= '<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total[$x]) . '</td>';

        if (!empty($row['gst']) && $igst[$x] != "") {
          $output .= '<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $igst[$x] . '</td>';
        } elseif ($sgst[$x] != "") {
          $output .= '<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $sgst[$x] . '</td><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $cgst[$x] . '</td>';
        }

        $output .= '<td style="font-size: 12px;background: #efebf9;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total_withgst[$x]) . '</td>
        					</tr>';
      }



      if (isset($igst[$rw]) && $igst[$rw] != "") {
        $igsttotal = $igsttotal + $igst[$rw];
      }
      if (isset($sgst[$rw]) && $sgst[$rw] != "") {
        $sgsttotal = $sgsttotal + $sgst[$rw];
      }
      if (isset($igst[$rw]) && $cgst[$rw] != "") {
        $cgsttotal = $cgsttotal + $cgst[$rw];
      }


      $output .= '<tr>
        						
        						<td style="">
        						<div style="background: #efebf9;border-bottom-left-radius: 7px; padding: 12px; font-size: 12px;">
        						' . $product_name[$rw] . '</div></td>
        						
        						<td style="font-size: 12px; background: #efebf9;">' . $hsnsac[$rw] . '</td>
        					
        						<td style="font-size: 12px; background: #efebf9;">' . $quantity[$rw] . '</td>
        						<td style="font-size: 12px; background: #efebf9;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($unit_price[$rw]) . '</td>';
      if (!empty($gst)) {
        $output .= '<td style="font-size: 12px; background: #efebf9;">GST@' . $gst[$rw] . '%</td>';
      } else {
        $output .= '<td style="font-size: 12px; background: #efebf9;">GST@18%</td>';
      }

      $output .= '<td style="font-size: 12px;background: #efebf9;">
        						  <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total[$rw]) . '</td>';

      if (!empty($row['gst']) && $igst[0] != "") {
        $output .= '<td style="font-size: 12px;background: #efebf9;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $igst[$x] . '</td>';
      } elseif (!empty($sgst)) {
        $output .= '<td style="font-size: 12px;background: #efebf9;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $sgst[$x] . '</td>
        						     <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $cgst[$x] . '</td>';
      }

      $output .= '<td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($total_withgst[$x]) . '</td>	  
        					      </tr>';

      $output .= '
                  </tbody>
                </table>
        
                <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:0px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;">
                      <p style="font-size:12px;"><b>Total in words:</b> <text> ' . AmountInWords($row["final_total"]) . ' only</text></p>';
      //if(isset($download , $bank_details_terms) && $download=='dn' ){
      //if(isset($bank_details_terms)){
      if (isset($bank_details_terms) && $bank_details_terms->enable_payment == 1) {

        $output .= '<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a;font-size:12px;padding:7px;">
                               <tr>
                                <td colspan="3">
                                 
                                    <h5 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0; font-size:13px;">Bank Details</h5>
                                </td>
                               </tr>
                              
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Holder Name:  <th>
                                   <td>' . ucfirst($bank_details_terms->acc_holder_name) . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  Account Number:  <th>
                                   <td>' . $bank_details_terms->account_no . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;">  IFSC:  <th>
                                   <td>' . $bank_details_terms->ifsc_code . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Account Type:  <th>
                                   <td>' . ucfirst($bank_details_terms->account_type) . '</td>
                               </tr>
                               <tr>
                                   <th style="text-align:left; padding-left:10px;"> Bank Name: <th>
                                   <td>' . ucfirst($bank_details_terms->bank_name) . '</td>
                               </tr>';

        if ($bank_details_terms->upi_id != "") {
          $output .= '<tr><th style="text-align:left;  padding-left:10px;">UPI Id:<th>
                                   <td>' . $bank_details_terms->upi_id . '</td></tr>';
        }

        $output .= '
                             </table>';
      }

      $output .= '</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;position: absolute;top: 0px;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row["initial_total"]) . '</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . $row["discount"] . '</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($after_discount) . '</td>
                          </tr>';

      if ($igsttotal != 0) {
        $output .= '<tr><th style="font-size: 12px;" align="left">IGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($igsttotal) . '</td></tr>';
      } else {

        if ($sgsttotal != 0) {
          $output .= '<tr><th style="font-size: 12px;" align="left">SGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($sgsttotal) . '</td></tr>';
        }
        if ($cgsttotal != 0) {
          $output .= '<tr><th style="font-size: 12px;" align="left">CGST</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($cgsttotal) . '</td></tr>';
        }
      }
      if ($row['extraCharge_name'] != "") {
        $extraCharge_name = explode("<br>", $row['extraCharge_name']);
        $extraCharge_value = explode("<br>", $row['extraCharge_value']);
        for ($y = 0; $y < count($extraCharge_name); $y++) {
          $output .= '<tr><th style="font-size: 12px;" align="left">' . $extraCharge_name[$y] . '</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($extraCharge_value[$y]) . '</td></tr>';
        }
      }

      $output .= '
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row["final_total"]) . '</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';

      $output .= '<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:';
      if (isset($bank_details_terms) && $bank_details_terms->enable_payment == 1) {
        $output .= '0px;">';
      } else {
        $output .= '-20px;">';
      }
      $output .= '<tbody>
                    <tr>
                  <td align="left">
                    <h5 style="color: #6539c0;margin-bottom: 10px;">Terms and Conditions</h5>
                    <ol style="padding: 0 15px; font-size:12px;">';
      $custTerm = explode("<br>", $row["terms_condition"]);
      $no = 1;
      for ($i = 0; $i < count($custTerm); $i++) {
        $output .= '<li>' . $custTerm[$i] . '</li>';
      }
      //'.nl2br($row->terms_condition).'
      $output .= '</ol>
                  </td>
                </tr>
                  </tbody>
                </table>
        
              </main>
        
              </body>
              </html>';
    }

    $this->load->library('pdf');
    $this->dompdf->loadHtml($output);
    ini_set('memory_limit', '128M');
    $this->dompdf->render();
    $canvas = $this->dompdf->getCanvas();
    $pdf = $canvas->get_cpdf();

    foreach ($pdf->objects as &$o) {
      if ($o['t'] === 'contents') {
        $o['c'] = str_replace('TPAGE', $canvas->get_page_count(), $o['c']);
      }
    }
    $attachmentpdf =  $this->dompdf->output();
    $path = "assets/img/proforma_invoice_" . $product_id . ".pdf";
    file_put_contents($path, $attachmentpdf);
    return $path;
  }


  // Please write code above this  
}
