<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_task extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
    $this->load->model('Setting_model','setting');
    $this->load->library(array('upload','email_lib'));
  }
  
  

/****************************************************/  
  
/*          SETTING MAIl FOR FOLLOW UP              */
 
/****************************************************/  

private function _taskMail(){
    
 $dataRow=$this->setting->getTaskForMail();    
foreach($dataRow as  $row){
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
                        <h1>Hello, Team !</h1>
                        <p>The following task which is assigned to you is overdue:</p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                <tr>
                                  <td align="center">
                                    <a href="https://allegient.team365.io/task" class="f-fallback button" target="_blank">Open Task..</a>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>Task information:</p>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Task:</strong> '.$row->task_subject.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Task Priority:</strong> '.$row->task_priority.'
									</span>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>From Date:</strong> '.$row->task_from_date.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>End Date:</strong> '.$row->task_due_date.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Description:</strong> '.$row->remarks.'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Task Created By:</strong> '.$row->task_owner.'
									</span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>Please open the case and finish the task.</p>
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
                      <p class="f-fallback sub align-center">&copy; '.date("Y").' team365. All rights reserved</p>
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
$subject='Your task is overdue - '.$row->task_subject;       
$userName=explode("<br>",$row->asign_to);
    for($r=0; $r<count($userName); $r++){
        $this->email_lib->send_email($userName[$r],$subject,$messageBody);
    }
}
    
    
}
  
  
	public function index()
	{
		$this->_taskMail();
		//$this->_check_trial();
	}
	
}
?>