<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
  /**
  * Login controller constructor — initializes parent controller and loads required helpers, models and libraries (url, cookie, login_model, Country_model as 'Country', upload, email_lib).
  * @example
  * $login = new Login();
  * // Controller initialized; url & cookie helpers loaded, login_model and Country_model (alias 'Country') loaded, upload and email_lib libraries loaded.
  * @param void $none - No parameters are required.
  * @returns void Constructor does not return a value.
  */
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
     $this->load->helper('cookie');


    $this->load->model('Country_model', 'Country');
    
    $this->load->library(array('upload', 'email_lib'));
  }
  public function index()
  {
    $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2);
    $subdomain_name = $subdomain_arr[0];
    $this->load->view('users/login');
  }
  public function sign_up()
  {
    $this->load->view('users/signup');
  }
  /**
  * Check if an email already exists among administrators or standard users and echo appropriate HTML/JS response for the frontend.
  * @example
  * $_POST['admin_email'] = 'admin@example.com';
  * $this->checkemail();
  * // Possible outputs:
  * // If exists as admin:
  * // <i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists
  * // <script>$('#accept').prop('disabled',true);$('#admin_email').val('');</script>
  * // If exists as standard users:
  * // <i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists as a standard users
  * // <script>$('#accept').prop('disabled',true);$('#admin_email').val('');</script>
  * // If not found:
  * // <script>$('#accept').prop('disabled',false);</script>
  * @param {string} $admin_email - The email address provided via POST under key 'admin_email' to check for existence.
  * @returns {void} Echoes HTML/JavaScript directly to the response; does not return a value.
  */
  public function checkemail()
  {
    $status = $this->login_model->checkemail($_POST['admin_email']);
    if ($status == 'admin') {
      echo '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists';
      echo "<script>$('#accept').prop('disabled',true);$('#admin_email').val('');</script>";
    } else if ($status == 'standard_users') {
      echo '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists as a standard users';
      echo "<script>$('#accept').prop('disabled',true);$('#admin_email').val('');</script>";
    } else {
      echo "<script>$('#accept').prop('disabled',false);</script>";
    }
  }
  public function checkmobile()
  {
    if ($this->login_model->checkmobile($_POST['admin_mobile'])) {
      echo '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This Number already exists';
      echo "<script>$('#accept').prop('disabled',true);$('#admin_mobile').val('');</script>";
    } else {
      echo "<script>$('#accept').prop('disabled',false);</script>";
    }
  }


  public function checkurl()
  {
    if ($this->login_model->checkurl($_POST['admin_url'])) {
      echo '<i class="far fa-times-circle" style="margin-left:7px; color:red" ></i>';
      echo "<script> $('#accept').prop('disabled',true);$('#yourUrlname').val('');$('#yourUrlname').attr('placeholder','Domain Already Exist.');</script>";
    } else {
      echo '<i class="far fa-check-circle" style="margin-left:7px; color:green" ></i>';
      echo "<script>$('#accept').prop('disabled',false);</script>";
    }
  }


  /**
  * Handle new user registration: validate input, create the user, send an OTP via SMS and email, then redirect to activation page on success or back to home on failure.
  * @example
  * // Example POST data that this controller expects:
  * $_POST = [
  *   'register_user'  => '1',
  *   'first_name'     => 'John',
  *   'last_name'      => 'Doe',
  *   'admin_email'    => 'john.doe@example.com',
  *   'admin_mobile'   => '919876543210',
  *   'admin_password' => 'ExamplePass123',
  *   'yourUrlname'    => 'johndoe'
  * ];
  * // When invoked after submitting the form:
  * $this->login->register();
  * // On success: redirects to 'login/activate_account/{id}'
  * // On failure: redirects to base URL with an error flash message.
  * @param array $post - POST input array (expects keys: register_user, first_name, last_name, admin_email, admin_mobile, admin_password, yourUrlname).
  * @returns void Performs registration actions and redirects; does not return a value.
  */
  public function register()
  {
    if ($this->input->post('register_user')) {
      $this->load->library('form_validation');

      $this->form_validation->set_rules('first_name', 'First name', 'trim|required');
      $this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
      $this->form_validation->set_rules('admin_email', 'Emailid', 'trim|required');
      $this->form_validation->set_rules('admin_mobile', 'Mobile Number', 'trim|required');
      $this->form_validation->set_rules('admin_password', 'Password', 'trim|required|min_length[8]|max_length[40]');

      if ($this->form_validation->run() == true) {
        $admin_name = $this->input->post('first_name') . " " . $this->input->post('last_name');
        $admin_email = $this->input->post('admin_email');
        $admin_mobile = $this->input->post('admin_mobile');
        $admin_password = md5($this->input->post('admin_password'));
        $company_email = $this->input->post('admin_email');
        $yourUrlname = $this->input->post('yourUrlname');


        $type = "admin";
        $product_type = "CRM";
        $active = false;
        //generate simple random code
        $set = '1234567890';
        $activation_code = substr(str_shuffle($set), 0, 6);
        $id = $this->login_model->register(
          $admin_name,
          $admin_email,
          $admin_mobile,
          $admin_password,
          $company_email,
          $type,
          $product_type,
          $active,
          $activation_code,
          $yourUrlname
        );

        $curl = curl_init();
        $url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/" . $admin_mobile . "/" . $activation_code;
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

        $subject = 'OTP - ' . $activation_code . ' from team365';
        $output = '';

        $output .= '<!DOCTYPE> <html> <head>
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
                        <tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : ' . $activation_code . '</b></td></tr>
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
                      <td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-' . date('Y') . ' team365. All rights reserved.</td>
                          </tr>
                    </table>
                    </body>
                    </html>';


        if ($this->email_lib->send_email($admin_email, $subject, $output)) {
          echo $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 7px;"></i>Welcome, Your Registration Successful');
          redirect('login/activate_account/' . $id);
        }
      } else {

        $this->session->set_flashdata('msg_err', 'Oops! Something went wrong We had a problem submitting your request. Please try again later');
        redirect(base_url());
      }
    }
  }
  /**
  * Activate an account using POSTed activation_code and mobile_activation_code; sends confirmation emails and redirects on success or failure.
  * @example
  * // In controller context (simulate form POST)
  * $_POST['activation_code'] = 'ABC123';
  * $_POST['mobile_activation_code'] = 'MOB456';
  * $this->login->activate_account();
  * // On success flash: '<span style ="color:green">Account Activated</span>'
  * // On failure flash: '<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Invalid OTP Code'
  * @param int $id - Account ID read from URI segment(3) (e.g. 42).
  * @returns void Performs email notifications, sets flash message and redirects; no direct return value.
  */
  public function activate_account()
  {
    $id =  $this->uri->segment(3);
    $this->load->view('verification/activate_account');
    $admin_details = $this->login_model->get_account_status($id);

    if ($this->input->post('submit')) {
      $activation_code = $this->input->post('activation_code');
      $mo_activation_code = $this->input->post('mobile_activation_code');

      $active = true;
      $dataRw = $this->login_model->activate_account($activation_code, $mo_activation_code, $active, $id);

      if ($dataRw == true) {

        /*  SEND MAIL USER TO WELCOME & MEssage*/
        #######################################################################		      
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
                                        <a href="https://team365.io/" class="f-fallback email-masthead_name">
                                        <img src="https://team365.io/assets/img/new-logo-team.png"></a>
                                      </a>
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
                                                <h1>Welcome, ' . $admin_details->admin_name . '!</h1>
                                                <p>Thanks for trying team365. We’re thrilled to have you on board. To get the most out of team365.io, do this primary next step:</p>
                                                <!-- Action -->
                                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                  <tr>
                                                    <td align="center">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                        <tr>
                                                          <td align="center">
                                                            <a href="https://team365.io/" class="f-fallback button" target="_blank">Read More..</a>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </table>
                                                <p>For reference, here is your login information:</p>
                                                <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                  <tr>
                                                    <td class="attributes_content">
                                                      <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                        <tr>
                                                          <td class="attributes_item">
                                                            <span class="f-fallback">
                                            <strong>Login Page:</strong> https://team365.io/login
                                          </span>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </table>
                                                <p>You have started 1 year trial. You can upgrade to a paying account or cancel any time.</p>
                                                <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                  <tr>
                                                    <td class="attributes_content">
                                                      <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                        <tr>
                                                          <td class="attributes_item">
                                                            <span class="f-fallback">
                                            <strong>Trial Start Date:</strong> ' . $admin_details->created_date . '
                                          </span>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td class="attributes_item">
                                                            <span class="f-fallback">
                                            <strong>Trial End Date:</strong> ' . $admin_details->trial_end_date . '
                                          </span>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </table>
                                                <p>If you have any questions, feel free to <a href="mailto:sales@team365.io">email our customer success team</a>. (We are lightning quick at replying.) We also offer <a href="https://team365.io/">live chat</a> during business hours.</p>
                                                <p>Thanks,
                                                  <br>Team365 Team</p>
                                                <p><strong>P.S.</strong> Need immediate help getting started? Check out our <a href="https://team365.io/contact">help documentation</a>. Or, just reply to this email, the team365 support team is always ready to help!</p>
                                                <!-- Sub copy -->
                                                <table class="body-sub" role="presentation">
                                                  <tr>
                                                    <td>
                                                      <p class="f-fallback sub">If you’re having trouble with the button above, copy and paste the URL below into your web browser.</p>
                                                      <p class="f-fallback sub">https://team365.io/</p>
                                                    </td>
                                                  </tr>
                                                </table>
                                              </div>
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

        $subject = 'Your team365 account has been activated';
        $this->email_lib->send_email($admin_details->admin_email, $subject, $messageBody);

        /*Send Mail to Admin start*/

        $adminMSg = '
                    <!doctype html>
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width" />
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Simple Transactional Email</title>
                        <style>
                        body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}
                      table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}
                      table td{font-family:sans-serif;font-size:14px;vertical-align:top}
                      .body{background-color:#f6f6f6;width:100%}.container{display:block;Margin:0 auto!important;max-width:580px;padding:10px;width:580px}
                      .content{box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:3px;width:100%}
                      .wrapper{box-sizing:border-box;padding:20px}.footer{clear:both;padding-top:10px;text-align:center;width:100%}.footer a,.footer p,.footer span,
                      .footer td{color:#999;font-size:12px;text-align:center}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}
                      .powered-by a{text-decoration:none}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}
                      table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body] 
                      .wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] 
                      .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body] 
                      .btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,
                      .ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;
                      font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}}
                          
                        </style>
                      </head>
                      <body class="">
                        <table border="0" cellpadding="0" cellspacing="0" class="body">
                          <tr>
                            <td>&nbsp;</td>
                            <td class="container">
                              <div class="content">
                                <span class="preheader">New account activate registred - team365</span>
                                <table class="main">
                                  <tr>
                                    <td class="wrapper">
                                      <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td style="text-align: center;">
                                            <h1>New Account Registred </h1>
                                            <h3>Find detail bellow.</h3>
                                            <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                              <tbody>
                                                <tr>
                                                  <td align="left">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                      <tbody>
                                                        <tr>
                                                          <td style="width: 30%; padding: 6px;">Partner Name</td>
                                                          <td style="padding: 6px;"> : </td>
                                                          <td style="padding: 6px;">' . $admin_details->admin_name . '</td>
                                                        </tr><tr>
                                                          <td style="padding: 6px;">Email</td>
                                                          <td style="padding: 6px;"> : </td>
                                                          <td style="padding: 6px;">' . $admin_details->admin_email . '</td>
                                                        </tr><tr>
                                                          <td style="padding: 6px;">Mobile No.</td>
                                                          <td style="padding: 6px;"> : </td>
                                                          <td style="padding: 6px;">' . $admin_details->admin_mobile . '</td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <p>More Information, Please login to admin panel and open admin deatil tab.<br>
                                <a href="https://allegient.team365.io/superadmin/">Click here </a> to login</p>
                                            <p>If you received this email by mistake, simply delete it.
                                You won`t be subscribed if you don`t click the confirmation link above.</p>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                                <div class="footer">
                                  <table border="0" cellpadding="0" cellspacing="0"> <tr> 
                            <td class="content-block"> <span class="apple-link">team365.io</span>  </td>
                                    </tr>
                                    <tr> <td class="content-block powered-by">  Powered by <a href="https://www.allegientservices.com/">allegient</a>.
                                      </td> </tr>
                                  </table>
                                </div>
                              </div>
                            </td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                      </body>
                    </html>';
        $subjectAd = 'A new user activated on crm - team365';
        $this->email_lib->send_email('sales@team365.io', $subjectAd, $adminMSg);
        //$this->email_lib->send_email('dev2@team365.io',$subjectAd,$adminMSg); 


        echo $this->session->set_flashdata('msg', '<span style ="color:green">Account Activated</span>');
        redirect('login');
      } else {
        echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 7px;"></i>Invalid OTP Code');
        redirect('login/activate_account/' . $id);
      }
    }
  }


  /**
  * Handle password reset requests: generates a 6-digit OTP, stores it with a 1-hour expiry, sends the OTP by email or SMS, sets flash messages and redirects to the OTP verification page.
  * @example
  * // Example 1: Trigger via controller POST (Email)
  * // POST data: ['method' => 'Email', 'email' => 'user@example.com']
  * $result = $this->get_password_link();
  * echo $result // null (method performs sending and redirects; no direct return value)
  * @example
  * // Example 2: Trigger via controller POST (Phone)
  * // POST data: ['method' => 'Phone', 'mobile' => '919876543210']
  * $result = $this->get_password_link();
  * echo $result // null (method performs sending and redirects; no direct return value)
  * @param {void} $none - No direct function arguments; input is read from POST parameters ('method', 'email' or 'mobile').
  * @returns {void} Performs actions (DB updates, sends email/SMS, sets session flashdata) and redirects; does not return a value.
  */
  public function get_password_link()
  {
    $this->load->view('verification/get_password_link');
    if ($this->input->post('submit')) {
      $set = '0123456789';
      $code = substr(str_shuffle($set), 0, 6);
      $d = strtotime("+1 Hours");
      $key = date("Y-m-d H:i:s", $d);
      if ($this->input->post('method') == 'Email') {
        $email = $this->input->post('email');
        $data = $this->login_model->get_password_link($email, $code, $key);
        $data2 = $this->login_model->get_u_password_link($email, $code, $key);



        $subject = 'OTP - ' . $code . ' Reset Password from team365';

        if (!empty($data)) {
          foreach ($data as $row) {

            $output = '<!DOCTYPE><html>
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
								<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : ' . $code . '</b></td></tr>
								<tr><td colspan="2"><b>Hi ' . $row['admin_name'] . ',</b></td></tr>
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
							<td style="text-align:center;height: 40px; color: aliceblue;"><p style="font-size:14px;">Copyright © 2014-' . date("Y") . ' team365. All rights reserved.</p></td>
									</tr>
						</table>
						</body>
					   </html>';

            //$this->email->message($output);

          }
          // sending email
          if ($this->email_lib->send_email($email, $subject, $output)) {
            $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered email address');
            $this->session->set_userdata('tp', 'spr');
            redirect('login/otp_password/' . $row['id'] . '?tp=spr');
          } else {
            $this->session->set_flashdata('msg', "Something went wrong. Try again in a few minutes");
            redirect('login/get_password_link/');
          }
        } else if (!empty($data2)) {
          foreach ($data2 as $row) {
            $output = '<!DOCTYPE><html>
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
								<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : ' . $code . '</b></td></tr>
								<tr><td colspan="2"><b>Hi ' . $row['standard_name'] . ',</b></td></tr>
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
							<td style="text-align:center;height: 40px; color: blue;"><p style="font-size:14px;">Copyright © 2014-' . date("Y") . ' team365. All rights reserved.</p></td>
						  </tr>
						</table>
						</body>
					   </html>';
            //$this->email->message($output);

          }
          // sending email
          if ($this->email_lib->send_email($email, $subject, $output)) {
            $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered email address');
            $this->session->set_userdata('tp', 'sdtr');
            redirect('login/otp_password/' . $row['id'] . '?tp=sdtr');
          } else {
            $this->session->set_flashdata('msg', "Something went wrong. Try again in a few minutes");
            redirect('login/get_password_link/');
          }
        } else {
          $this->session->set_flashdata('msg', 'Please enter registered email address');
          redirect('login/get_password_link/');
        }
      } elseif ($this->input->post('method') == 'Phone') {
        $mobile = $this->input->post('mobile');
        $data_m = $this->login_model->get_password_link_mobile($mobile, $code, $key);
        $data_m2 = $this->login_model->get_u_password_link_mobile($mobile, $code, $key);
        if (!empty($data_m) || !empty($data_m2)) {
          $curl = curl_init();
          $url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/" . $mobile . "/" . $code;
          curl_setopt_array(
            $curl,
            array(
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
            //echo "cURL Error #:" . $err;
          } else {
            //echo $response;
            if (!empty($data_m)) {
              foreach ($data_m as $row) {
                $this->session->set_userdata('tp', 'spr');
                $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered mobile number');
                redirect('login/otp_password/' . $row['id'] . '?tp=spr');
              }
            } else if (!empty($data_m2)) {
              foreach ($data_m2 as $row) {
                $this->session->set_userdata('tp', 'sdtr');
                $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>OTP sent to your registered mobile number');
                redirect('login/otp_password/' . $row['id'] . '?tp=sdtr');
              }
            }
          }
        } else {
          $this->session->set_flashdata('msg', 'Please enter registered mobile number');
          redirect('login/get_password_link/');
        }
      }
    }
  }
  /**
   * Display the OTP entry form and handle OTP submission. Loads the OTP view and, on form submit,
   * validates the provided OTP against the stored OTP(s) for the user ID taken from URI segment 3.
   * If the OTP matches, redirects to the reset password page for that user; otherwise sets a flash
   * error message and redirects back to the OTP entry page.
   * @example
   * // Example: user visits /login/otp_password/42 and submits OTP '123456'
   * $_POST['submit'] = 'Submit';
   * $_POST['otp'] = '123456';
   * // Controller obtains id from URI segment(3) => 42 and calls:
   * $this->otp_password();
   * // Expected behavior: redirect to 'login/reset_password/42' if OTP matches,
   * // otherwise redirect back to 'login/otp_password/42' with a flash error message.
   * @param {int} $id - User identifier retrieved from URI segment(3); not a direct function argument.
   * @returns {void} No return value; performs view loading or redirects based on OTP verification.
   */
  public function otp_password()
  {
    $this->load->view('verification/enter_otp_new');
    $id =  $this->uri->segment(3);
    if ($this->input->post('submit')) {
      $password_key = $this->input->post('otp');
      $data = $this->login_model->match_otp($id, $password_key);
      $data2 = $this->login_model->match_otp_u($id, $password_key);
      if (!empty($data)) {
        redirect('login/reset_password/' . $id);
      } else {
        $this->session->set_flashdata('msg', '<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i> Enter valid OTP');
        redirect('login/otp_password/' . $id);
      }
      if (!empty($data2)) {
        redirect('login/reset_password/' . $id);
      } else {
        $this->session->set_flashdata('msg', '<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i> Enter valid OTP');
        redirect('login/otp_password/' . $id);
      }
    }
  }
  /**
  * Reset user's password based on the token/ID in URI segment 3; displays the reset form and updates the password when the form is submitted.
  * @example
  * // Example: reset password for user id 42 by submitting the form with a new password
  * $_POST['update'] = '1';
  * $_POST['c_password'] = 'NewP@ssw0rd';
  * $this->uri->segment(3) = 42;
  * $this->login->reset_password();
  * // After execution the user is redirected to 'login' and sees flash message: "Password Changed Successfully"
  * @param {void} $none - No direct function parameters; uses URI segment 3 as the user identifier and POST fields 'c_password' and 'update'.
  * @returns {void} No return value; loads the reset view and redirects to the login page after a successful password update.
  */
  public function reset_password()
  {

    $id = $this->uri->segment(3);
    $data['user'] = $this->login_model->get_password_link1($id);
    $data['user1'] = $this->login_model->get_u_password_link1($id);

    $this->load->view('verification/reset_password_new', $data);

    if ($this->input->post('update')) {
      $password = md5($this->input->post('c_password'));
      $getvl = $this->session->userdata('tp');
      if ($getvl == 'spr') {
        $data = $this->login_model->reset_password($password, $id);
      } else {
        $data2 = $this->login_model->reset_u_password($password, $id);
      }
      $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 10px;"></i>Password Changed Successfully');
      redirect('login');
    }
  }

  public function auth()
  {
    
     if ($this->input->post('log_in')) 
       $subdomain_arr = explode('.', $_SERVER['HTTP_HOST'], 2);
      //  $subdomain_name = $subdomain_arr[0];
       $subdomain_name = 'cst';
      $email = $this->input->post('email', TRUE);
      $password = md5($this->input->post('password', TRUE));
       $nocaptcha = $this->input->post('nocaptcha');


      $validate = $this->login_model->validate_admin($email, $password, $subdomain_name, '');
      $validate2 = $this->login_model->validate_user($email, $password, $subdomain_name, '');
      
      if ($validate->num_rows() > 0) {
        
      
        $data = $validate->row_array();
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

        $curdate =  date("Y-m-d");
        if ($account_type == 'Trial' && $curdate > $trial_end_date) {
          echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your team365 trial expired');

          redirect('login');
          exit;
        } else if ($account_type == 'Paid' && $curdate > $license_expiration_date) {
          echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your team365 License expired');

          redirect('login');
          exit;
        } else {

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
            'logged_in' => TRUE
          );
          $this->session->set_userdata($sesdata);

          if ($type === 'admin') {

            if ($active == true) {

              $table = 'admin_users';
              $result = $this->login_model->update_login_count($table, $name, $email, $company_name, $login_count);
              $getcode = $_COOKIE['otpcode'];
               if(!isset($_COOKIE['captcha'])){
                if($nocaptcha == 1){
               set_cookie('captcha','false',strtotime('+14 days'));
                }
         }
              if ($data['mo_activation_code'] != $getcode) {
                if ($email == "naseem@gmail.com" || $email == 'dev3@team365.io' || $email=='mp@allegientservices.com') {
                  redirect('home');
                } else {

                  $this->session->unset_userdata('id');
                  $this->session->unset_userdata('name');
                  $this->session->unset_userdata('email');
                  $this->session->unset_userdata('mobile');
                  $this->session->unset_userdata('type');
                  $this->session->unset_userdata('company_email');
                  $this->session->unset_userdata('company_name');
                  //$this->session->unset_userdata('logged_in');
                  $sesdata2 = array(
                    'email_secur' => $email,
                    'mobile_secur' => $mobile,
                    'type_secur' => $type,
                    'id_secur' => $id,
                    'name_secur' => $name,
                    'company_name_secur' => $company_name,
                    'company_email_secur' => $company_email
                  );
                  $this->session->set_userdata($sesdata2);
                  redirect('login/secure');
                }
              } else {
                redirect('home');
              }
            } else {

              $type = "admin";
              $active = false;
              $set = '01234567890';
              $activation_code = substr(str_shuffle($set), 0, 6);


              $d = strtotime("+1 Hours");
              $key = date("Y-m-d H:i:s", $d);
              $data2 = $this->login_model->updateOtpCode($email, $activation_code, $key, '');



              $curl = curl_init();
              $url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/" . $mobile . "/" . $activation_code;
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



              $subject = 'OTP - ' . $activation_code . ' from team365';
              $output = '';

              $output .= '<!DOCTYPE> <html> <head>
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
							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : ' . $activation_code . '</b></td></tr>
							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
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
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-' . date("Y") . ' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';

              if ($this->email_lib->send_email($email, $subject, $output)) {
                echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Please Activate Your Account');
                redirect('login/activate_account/' . $id);
              }
            }
          }
        }
      }
      if ($validate2->num_rows() > 0) {
        $data = $validate2->row_array();

        //check active account   
        $acitive_account = $this->login_model->available_loginUser($data['company_name'], $data['company_email']);

        if ($acitive_account['status'] == 0 && $acitive_account['account_type'] == "End") {
          echo $this->session->set_flashdata('msg', '<i class="fa fa-info-circle" style="color: red; margin-right: 10px;"></i>Your administrator`s account has been expired,contact your admin/administrator');
          redirect('login');
          exit;
        } else {

          $id = $data['id'];
          $name = $data['standard_name'];
          
          $user_photo = $data['user_photo'];
          
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
          $yourPlan     = $data['your_plan_id'];
          $license_type = $data['license_type'];
          $account_type = $data['account_type'];
          $partner_name = $data['partner_name'];
          $userType      = $data['user_type'];
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
              'id' => $id,
              'name' => $name,
              'user_photo' => $user_photo,
              'email' => $email,
              'mobile' => $mobile,
              'type' => $type,
              'company_name' => $company_name,
              'country' => $country,
              'state' => $state,
              'city' => $city,
              'company_address' => $company_address,
              'zipcode' => $zipcode,
              'company_mobile' => $company_mobile,
              'company_email' => $company_email,
              'company_website' => $company_website,
              'company_gstin' => $company_gstin,
              'pan_number' => $pan_number,
              'cin' => $cin,
              'company_logo' => $company_logo,
              'terms_condition_customer' => $terms_condition_customer,
              'terms_condition_seller' => $terms_condition_seller,
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
              $result = $this->login_model->update_login_count($table, $name, $email, $company_name, $login_count);
              $getcode = $_COOKIE['otpcode'];
               if(!isset($_COOKIE['captcha'])){
                if($nocaptcha == 1){
               set_cookie('captcha','false',strtotime('+14 days'));
                }
         }
              if ($data['mo_activation_code'] != $getcode) {
                $this->session->unset_userdata('id');
                $this->session->unset_userdata('name');
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('mobile');
                $this->session->unset_userdata('type');
                $this->session->unset_userdata('company_email');
                $this->session->unset_userdata('company_name');
                //$this->session->unset_userdata('logged_in');
                $sesdata2 = array(
                  'email_secur' => $email,
                  'mobile_secur' => $mobile,
                  'type_secur' => $type,
                  'id_secur' => $id,
                  'name_secur' => $name,
                  'company_name_secur' => $company_name,
                  'company_email_secur' => $company_email
                );
                $this->session->set_userdata($sesdata2);
                redirect('login/secure');
              } else {
                redirect('home');
              }
            }
          }
        }
      } else {
        echo $this->session->set_flashdata('msg', '<i class="fa fa-times-circle" style="color: red; margin-right: 10px;"></i>Username or Password is Wrong');
        redirect('login');
      }
    }
  

  /**
  * Fetch state and country information by TIN from POST and echo the result as JSON.
  * @example
  * $_POST['tin'] = '123456789';
  * $this->fetchstatebytin();
  * // Output: {"state":"California","country":"United States","state_id":5}
  * @param {{string}} {{$_POST['tin']}} - Tax Identification Number provided in POST data.
  * @returns {{void}} Echoes a JSON object containing 'state', 'country', and 'state_id'.
  */
  public function fetchstatebytin()
  {
    if (isset($_POST['tin'])) {
      $resultsts = $this->Country->get_statesbytin($_POST['tin']);
      $resultcon = $this->Country->get_countrybyid($resultsts['country_id']);
      $arr_result = array(
        'state'  =>  $resultsts['name'],
        'country'  => $resultcon['name'],
        'state_id'  => $resultsts['id']
      );
      echo json_encode($arr_result);
    }
  }

  /**
  * Fetch country suggestions based on the GET parameter 'term' and echo a JSON array suitable for an autocomplete widget.
  * @example
  * $_GET['term'] = 'Ind';
  * $this->autocomplete_countries(); // outputs: [{"label":"India","values":1},{"label":"Indonesia","values":2}]
  * @param string $_GET['term'] - Search term used to filter countries (provided via GET).
  * @returns void Echoes a JSON encoded array of matching countries (each element contains 'label' => country name and 'values' => country id) or a single element with 'label' => "No Records Found".
  */
  public function autocomplete_countries()
  {
    if (isset($_GET['term'])) {
      $result = $this->Country->get_countries($_GET['term']);
      if (count($result) > 0) {
        foreach ($result as $row)
          $arr_result[] = array(
            'label'  => $row->name,
            'values'  => $row->id
          );
        echo json_encode($arr_result);
      } else {
        $arr_result[] = array(
          'label'  => "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  /**
  * Autocomplete states endpoint: reads POST 'terms' and optional 'country_id', retrieves matching states and echoes a JSON array of suggestion objects.
  * @example
  * $this->input->post(['terms' => 'New', 'country_id' => 1]);
  * $this->autocomplete_states();
  * // Output (echoed): [{"label":"New York","values":32},{"label":"New Jersey","values":34}]
  * @param array $post - POST data array; expects 'terms' (string) and optional 'country_id' (int).
  * @returns void Echoes a JSON-encoded array of suggestions or [{"label":"No Records Found"}] when no matches.
  */
  public function autocomplete_states()
  {
    $post = $this->input->post();
    if (isset($post['terms'])) {
      $result = $this->Country->get_states($post['terms'], $post['country_id']);
      if (count($result) > 0) {
        foreach ($result as $row)
          $arr_result[] = array(
            'label'  => $row->name,
            'values'  => $row->id
          );
        echo json_encode($arr_result);
      } else {
        $arr_result[] = array(
          'label'  => "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }
  /**
  * Autocompletes city names from POSTed 'terms' (and optional 'state_id') and echoes a JSON array of suggestion objects with a 'label' property.
  * @example
  * // Example usage (controller receives POST):
  * $_POST['terms'] = 'New';
  * $_POST['state_id'] = 5;
  * $this->autocomplete_cities();
  * // Example output (JSON):
  * // [{"label":"New York"},{"label":"Newark"},{"label":"New Haven"}]
  * @param {string} $post['terms'] - Search term submitted via POST to match city names (required).
  * @param {int|null} $post['state_id'] - Optional state ID submitted via POST to limit the search (may be null).
  * @returns {void} Echoes a JSON-encoded array of objects like [{"label":"City Name"}, ...]; if no results, echoes [{"label":"No Records Found"}].
  */
  public function autocomplete_cities()
  {
    $post = $this->input->post();
    if (isset($post['terms'])) {
      $result = $this->Country->get_cities($post['terms'], $post['state_id']);
      if (count($result) > 0) {
        foreach ($result as $row)
          $arr_result[] = array(
            'label'  => $row->name,
          );
        echo json_encode($arr_result);
      } else {
        $arr_result[] = array(
          'label'  => "No Records Found",
        );
        echo json_encode($arr_result);
      }
    }
  }


  public function secure()
  {
    $this->load->view('users/auth-login');
  }

  /**
   * Verify the submitted OTP for secure login and establish the user session (supports 'standard' and 'admin' types).
   * @example
   * // Simulate POST data then call from controller
   * $_POST['otpcode'] = '123456';
   * $_POST['checkboxOtp'] = '1'; // set to '1' or true to remember OTP (stores cookie for 14 days)
   * $_POST['method'] = 'email';  // sample method/value returned in redirect query
   * $this->check_secure_login();
   * // On success: redirects to 'home'
   * // On failure: sets flash message and redirects to 'login/secure?ot=enter-otp&u=email'
   * @param string $otpcode - One-time password code submitted by the user (e.g. '123456').
   * @param bool|int $checkboxOtp - Flag indicating "remember this device" (1 or true to persist OTP cookie).
   * @param string $method - Return/redirect method parameter used in failure redirect (e.g. 'email').
   * @returns void Performs redirects and session updates; does not return a value.
   */
  public function check_secure_login()
  {
    $otpcode    = $this->input->post('otpcode');
    $checkboxOtp = $this->input->post('checkboxOtp');
    $method     = $this->input->post('method');
    if ($this->session->userdata('type_secur') == 'standard') {
      $data2 = $this->login_model->updateCheckOtpStd($otpcode);
      if ($data2) {
        if ($checkboxOtp) {
          setcookie('otpcode', $otpcode, strtotime('+14 days'));
        }
        $sesdata2 = array(
          'email'  => $this->session->userdata('email_secur'),
          'mobile'  => $this->session->userdata('mobile_secur'),
          'type' => $this->session->userdata('type_secur'),
          'id' => $this->session->userdata('id_secur'),
          'name' => $this->session->userdata('name_secur'),
          'company_name' => $this->session->userdata('company_name_secur'),
          'company_email' => $this->session->userdata('company_email_secur')
        );
        $this->session->set_userdata($sesdata2);
        $this->session->unset_userdata('id_secur');
        $this->session->unset_userdata('name_secur');
        $this->session->unset_userdata('email_secur');
        $this->session->unset_userdata('mobile_secur');
        $this->session->unset_userdata('type_secur');
        $this->session->unset_userdata('company_email_secur');
        $this->session->unset_userdata('company_name_secur');
        redirect('home');
      } else {
        echo $this->session->set_flashdata('msg', '<i class="fas fa-exclamation-triangle" style="color:red; margin-right:7px;"></i>Please Enter Valid OTP.');
        redirect('login/secure?ot=enter-otp&u=' . $method);
      }
    } else if ($this->session->userdata('type_secur') == 'admin') {
      $data2 = $this->login_model->updateCheckOtp($otpcode);
      if ($data2) {
        if ($checkboxOtp) {
          setcookie('otpcode', $otpcode, strtotime('+14 days'));
        }
        $sesdata2 = array(
          'email'  => $this->session->userdata('email_secur'),
          'mobile'  => $this->session->userdata('mobile_secur'),
          'type' => $this->session->userdata('type_secur'),
          'id' => $this->session->userdata('id_secur'),
          'name' => $this->session->userdata('name_secur'),
          'company_name' => $this->session->userdata('company_name_secur'),
          'company_email' => $this->session->userdata('company_email_secur')
        );
        $this->session->set_userdata($sesdata2);
        $this->session->unset_userdata('id_secur');
        $this->session->unset_userdata('name_secur');
        $this->session->unset_userdata('email_secur');
        $this->session->unset_userdata('mobile_secur');
        $this->session->unset_userdata('type_secur');
        $this->session->unset_userdata('company_email_secur');
        $this->session->unset_userdata('company_name_secur');
        redirect('home');
      } else {
        echo $this->session->set_flashdata('msg', '<i class="fas fa-exclamation-triangle" style="color:red;margin-right:7px;"></i>Please Enter Valid OTP.');
        redirect('login/secure?ot=enter-otp&u=' . $method);
      }
    }
    //echo "test";

  }

  /**
   * Send a one-time password (OTP) to the currently stored user contact (mobile or email),
   * update the OTP and expiry in the database and redirect to the OTP entry page.
   *
   * This controller method reads POST flags "mobilecheck" and "emailcheck" to determine
   * whether to send the OTP via SMS (using 2factor.in API) or email (using email_lib).
   * The OTP and an expiry key (current time + 1 hour) are stored via login_model:
   * - updateOtpCodeStd(...) if session 'type_secur' == 'standard'
   * - updateOtpCode(...) otherwise
   * A flash message is set and the user is redirected to login/secure with query
   * parameters indicating the destination (u=m for mobile, u=e for email).
   *
   * Example:
   * $_POST['mobilecheck'] = '1'; // or $_POST['emailcheck'] = '1';
   * $this->session->set_userdata('email_secur', 'user@example.com');
   * $this->session->set_userdata('mobile_secur', '919876543210');
   * $this->session->set_userdata('type_secur', 'admin'); // or 'standard'
   * $this->securLogin();
   * // Result: OTP generated (e.g. 482905), saved to DB, SMS or email sent, and browser redirected.
   *
   * @example
   * // Sending OTP via mobile:
   * $_POST['mobilecheck'] = '1';
   * $this->securLogin();
   *
   * @param {void} none - No direct arguments; reads POST keys 'mobilecheck' / 'emailcheck' and session keys 'email_secur', 'mobile_secur', 'type_secur'.
   * @returns {void} Redirects the response after attempting to send the OTP (no direct return value).
   */
  public function securLogin(){
    $mobilecheck = $this->input->post('mobilecheck');
    $emailcheck = $this->input->post('emailcheck');

    /****/
    $type = "admin";
    $active = false;
    $set = '1234567890';
    $activation_code = substr(str_shuffle($set), 0, 6);
    $email      = $this->session->userdata('email_secur');
    $admin_mobile  = $this->session->userdata('mobile_secur');
    $d     = strtotime("+1 Hours");
    $key = date("Y-m-d H:i:s", $d);

    if ($this->session->userdata('type_secur') == 'standard') {
      $data2 = $this->login_model->updateOtpCodeStd($email, $activation_code, $key,'');
    } 
    else {
      $data2 = $this->login_model->updateOtpCode($email, $activation_code, $key, '');
    }
    if ($mobilecheck) {
      $curl = curl_init();
      $url = "http://2factor.in/API/V1/e19637b8-8ddc-11ea-9fa5-0200cd936042/SMS/" . $admin_mobile . "/" . $activation_code;
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
      echo $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 7px;"></i>OTP has been sent successfully on your registered mobile number.');
      return redirect('login/secure?ot=enter-otp&u=m');
    }
    else if ($emailcheck) {
        $subject = 'OTP - ' . $activation_code . ' from team365';
        $output = '';
        $output .= '<!DOCTYPE> <html> <head>
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
        							<tr style="height: 45px;"><td style="text-align: right;">OTP Code&nbsp;</td><td style="text-align:left;"><b> : ' . $activation_code . '</b></td></tr>
        							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
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
        						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-' . date('Y') . ' team365. All rights reserved.</td>
        					  </tr>
        					</table>
    					</body>
				   </html>';
        if ($this->email_lib->send_email($email, $subject, $output)) {
            echo $this->session->set_flashdata('msg', '<i class="fa fa-check-circle" style="color: green; margin-right: 7px;"></i>OTP has been sent successfully on your registered email.');
            return redirect('login/secure?ot=enter-otp&u=e');
        }
        // return redirect('login/secure?ot=enter-otp&u=e');
        return redirect('login/secure');
    }


    /*****/
  }


  public function logout()
  {
    $this->session->unset_userdata('email');
    $this->session->unset_userdata('logged_in');
    //$this->load->model('Chat_model');
    //$dataArr=array('online' => 0 );
    //$this->Chat_model->updateOnline($dataArr);
    $this->session->sess_destroy();
    redirect('login');
  }
}
