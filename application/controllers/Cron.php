<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
    $this->load->model('Purchaseorders_model');
	$this->load->model('Cron_model','CronModel');
	$this->load->model('Workflow_model');
    $this->load->library('email_lib');
  }
  
  
  
  
  private function _check_trial()
    {
		$data = $this->login_model->get_adminemail();
		foreach($data as $row)
	    {
	        $admin_email 	= $row['admin_email'];
	        $company_email 	= $row['company_email'];
	        $account_type   = $row['account_type'];
	        if($account_type=='Trial'){
    			$trial_end_date = date_create($row['trial_end_date']);
                $current_date 	= date_create(date('Y-m-d'));
                $diff 			= date_diff($trial_end_date,$current_date);
                $d 				= $diff->format("%a");
	        }elseif($account_type=='Paid'){
    	        $license_expiration_date = date_create($row['license_expiration_date']);
                $current_date 	         = date_create(date('Y-m-d'));
                $diff 			         = date_diff($license_expiration_date,$current_date);
                $d 				         = $diff->format("%a"); 
	        }
			if($d=="0")
            {
				$this->login_model->deactivateAcc($admin_email,$company_email);
				$this->login_model->deactivateAccUser($company_email);
			}
			
		}
	}
  
  private function _trial_end()
	{
	    // TRIAL END EMAIL
	    $data = $this->login_model->get_adminemail();
		//print_r($data);
	    foreach($data as $row)
	    {
	        $admin_email = $row['admin_email'];
	        $company_email = $row['company_email'];
			
			$account_type   = $row['account_type'];
			
	        if($account_type=='Trial'){
    			$trial_end_date = date_create($row['trial_end_date']);
                $current_date 	= date_create(date('Y-m-d'));
                $diff 			= date_diff($trial_end_date,$current_date);
                $d 				= $diff->format("%a");
            
            $subject = 'Your team365 trial acoount is about to end.';    
            if($d=="10" || $d=="8" || $d=="6" || $d=="4" || $d=="2")
            {
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
							<tr style="height: 45px;">
								<td style="text-align: right;"></td>
								<td style="text-align:left;"><b>Your team365 trial ends in '.$d.' days </b></td>
							</tr>
							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
							<tr><td colspan="2">Thanks for trying team365. You have added a lot of data, so here are several options for you to consider going forward.</td></tr>
							<tr><td colspan="2"><a href="https://www.team365.io/pricing">Upgrade your account</a></td></tr>
							<tr><td colspan="2">Your 1 year of trial is about to end to continue to use Team365 please contact our support staff to buy a subscription or visit the following link.<br> <a href="https://www.team365.io/pricing">Shop At Team365</a></td></tr>
							<tr><td colspan="2"><br></td></tr>
							<tr><td><br><br></td></tr>
							<tr><th style="text-align:left;"><br><br>Regards</th></tr>
							<tr><th style="text-align:left;">Team365</th></tr>
							
						</table>
					   </td>
					  </tr>
					  <tr style="background: linear-gradient(#0070d2, #448aff);">
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				   
	                //email send
                    $this->email_lib->send_email($admin_email, $subject, $output);
    		       
                }
                elseif($d=="0")
                {
					$output2 ='<!DOCTYPE> <html> <head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<title>Team365 Mail</title>
						<style type="text/css">body {margin: 0; padding: 0; min-width: 100%!important;}.content {width: 100%; max-width: 600px;} </style></head>
					<body>
					   <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
						<tr style="background: linear-gradient(#0170d2, #0170d2); height: 60px;">
						  <td style="text-align:center; height: 60px; color:#fff;"><img src="https://team365.io/assets/img/new-logo.png" style="marging:10px; width: 100px; height:60px;"></td>
						</tr>
						<tr><td>
							<table class="content" style="min-height: 120px; margin-top: 40px;margin-bottom: 40px;" align="center" cellpadding="0" cellspacing="0" border="0">
							<tr style="height: 45px;">
								<td style="text-align: right;"></td>
								<td style="text-align:left;"><b>Your team365 trial expired </b></td>
							</tr>
							<tr><td colspan="2"><b>Dear Sir,</b></td></tr>
							<tr><td colspan="2">Thanks for trying team365. You have added a lot of data, so here are several options for you to consider going forward.</td></tr>
							<tr><td colspan="2"><a href="https://www.team365.io/pricing">Upgrade your account</a></td></tr>
							<tr><td colspan="2">Your 1 year of trial is about to end to continue to use Team365 please contact our support staff to buy a subscription or visit the following link.<br> <a href="https://www.team365.io/pricing">Shop At Team365</a></td></tr>
							<tr><td colspan="2"><br></td></tr>
							<tr><td><br><br></td></tr>
							<tr><th style="text-align:left;"><br><br>Regards</th></tr>
							<tr><th style="text-align:left;">Team365</th></tr>
							
						</table>
					   </td>
					  </tr>
					  <tr style="background: linear-gradient(#0070d2, #448aff);">
						<td style="text-align:center;height: 40px; color: aliceblue;">Copyright © 2014-'.date("Y").' team365. All rights reserved.</td>
								</tr>
					</table>
					</body>
				   </html>';
				   
				    $this->email_lib->send_email($admin_email, $subject, $output2);
                   
                }
               
                
	        }elseif($account_type=='Paid'){
	            
    	        $license_expiration_date = date_create($row['license_expiration_date']);
                $current_date 	         = date_create(date('Y-m-d'));
                $diff 			         = date_diff($license_expiration_date,$current_date);
                $d 				         = $diff->format("%a"); 
                
                    
            if($d=="10" || $d=="8" || $d=="6" || $d=="4" || $d=="2")
            {
			 $output ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                        <img src="https://team365.io/assets/img/new-logo.png"></a>
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
                                                <h1>Hello,'.$row["admin_name"].'!</h1>
                                                <p>Thanks for using our Team365 CRM . We love having you as our customer. Your subscription will expire in '.$d.' days, so we thought we’d check in.</p>
                                                <p>If you want to continue taking advantage of our Team365 CRM and retain all your data and preferences, you can easily renew by going to..</p>
                                                <!-- Action -->
                                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                  <tr>
                                                    <td align="center">
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                        <tr>
                                                          <td align="center">
                                                            <a href="https://www.team365.io/pricing" class="f-fallback button" target="_blank">Upgrade your account</a>
                                                          </td>
                                                        </tr>
                                                      </table>
                                                    </td>
                                                  </tr>
                                                </table>
                                                <p>Your '.$d.'-days of paid is about to end to continue to use Team365 please contact our support staff to buy a subscription or visit the following link. <a href="https://www.team365.io/pricing">Shop At Team365</a></p>
                                                
                                                <p>Thank you,<br>Team365</p>
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
				    $subject = 'Your team365 Paid acoount subscription will expire in '.$d.' days.';
	                //email send
                    $this->email_lib->send_email($admin_email, $subject, $output);
    		        
                }
                elseif($d=="0")
                {
					$output2 ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                            <img src="https://team365.io/assets/img/new-logo.png"></a>
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
                                                    <h1>Hello,'.$row["admin_name"].'!</h1>
                                                    <p>Thanks for using our Team365 CRM . We love having you as our customer. Your team365 CRM paid subscription account expired .</p>
                                                    <p>If you want to continue taking advantage of our Team365 CRM and retain all your data and preferences, you can easily renew by going to..</p>
                                                    <!-- Action -->
                                                    <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                      <tr>
                                                        <td align="center">
                                                          <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                            <tr>
                                                              <td align="center">
                                                                <a href="https://www.team365.io/pricing" class="f-fallback button" target="_blank">Upgrade your account</a>
                                                              </td>
                                                            </tr>
                                                          </table>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                    <p>Your paid account is expired continue to use Team365 please contact our support staff to buy a subscription or visit the following link. <a href="https://www.team365.io/pricing">Shop At Team365</a></p>
                                                    
                                                    <p>Regards,<br>Team365</p>
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
				    $subject = 'Your team365 Paid acoount subscription expired.';
				    $this->email_lib->send_email($admin_email, $subject, $output2);
                   
                }
                
                
	        }
		
			
	    }
	}
	// Renewal Mail Function...
    private function _renewal_so()
	{
		
		$data = $this->CronModel->get_adminemail();
		
		
		foreach($data as $row)
	    {
	        $renewal_data	= array();
			$subject		= 'Renwal alerts for your sales order - team365 | CRM'; 
			$admin_email 	= $row['admin_email'];
	        $company_email 	= $row['company_email'];
	        $company_name 	= $row['company_name'];
			
			$checkPer	= $this->Workflow_model->check_workflows($company_email,$company_name,'Admin','Mail nofification for renewal');
		
		if((isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1)){
			
	      if($company_email!="" &&  $company_name!="" ){
			$renewal_data   = $this->CronModel->get_renewal_so($company_email,$company_name);
			$bodyMessage	="";
			if(count($renewal_data)>0){
		
			$current_date 	= date_create(date('Y-m-d'));
			
			$bodyMessage.="<table class='tblCls' width='100%' cellpadding='10' cellspacing='0'>";
				$bodyMessage.="<tr>";
				$bodyMessage.="<th>SO Subject</th>
				<th>SO ID</th>
				<th>Customer Name</th>
				<th>Contact Name</th>
				<th>SO Owner</th>
				<th>Renewal Date</th>
				<th>Days Left</th>
				";
				$bodyMessage.="</tr>";
			foreach($renewal_data as $renew){ 
				$renewa_end_date= date_create($renew['renewal_date']);		
				$diff 	= date_diff($renewa_end_date,$current_date);
				$d 		= $diff->format("%a");
				$bodyMessage.="<tr>";
				$bodyMessage.="
				<td>".$renew['subject']."</td>
				<td>".$renew['saleorder_id']."</td>
				<td>".$renew['org_name']."</td>
				<td>".$renew['contact_name']."</td>
				<td>".$renew['owner']."</td>
				<td>".$renew['renewal_date']."</td>
				<td>".$d." Days</td>
				";
				$bodyMessage.="</tr>";
			
			}
		
			$bodyMessage.="</table>";
		
		  
			$output2 ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html><head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <title></title>
                    <style type="text/css" rel="stylesheet" media="all">body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
                    body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
                    td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size: 14px;line-height: 24px; }p.sub{font-size:13px}.align-right{text-align:right} .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
                    .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0} .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
                    .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
                    .tblCls th, .tblCls td{
                            border: 1px solid #333;
                            font-size: 13px;
                    }
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
                                            <img src="https://team365.io/assets/img/new-logo.png"></a>
                                          </a>
                                        </td>
                                    </tr>
                                    <!-- Email Body -->
                                    <tr>
                                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                                            <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                              <!-- Body content -->
                                              <tr>
                                                <td class="content-cell">
                                                  <div class="f-fallback">
                                                    <h1>Hi,Admin!</h1>
                                                    <p>Here your renewal sales order-</p>
                                                    <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                      <tr>
                                                        <td align="center">
                                                          '.$bodyMessage.'
                                                        </td>
                                                      </tr>
                                                    </table>
                                                    <p>
													To prevent this revieving mail , Please login your team365 CRM account and change work-flow setting..
													</p>
                                                    <p>Regards,<br>Team365</p>
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
                            
            //$this->email_lib->send_email('dev2@team365.io', $subject, $output2);                
			$this->email_lib->send_email($admin_email, $subject, $output2);
			}
		  }
		 }
	    }
		
	}
	private function _renewal_so_user()
	{
		$data 		= $this->CronModel->get_adminemail();
		$subject	= 'Renwal alerts for your sales order - team365 | CRM';
		foreach($data as $row)
	    {
	        $bodyMessage='';
			
	        $company_email 	= $row['company_email'];
	        $company_name 	= $row['company_name'];
			
			$checkPer	= $this->Workflow_model->check_workflows($company_email,$company_name,'User','Mail nofification for renewal');
		 if((isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1)){	
			
	     if($company_email!="" &&  $company_name!="" ){
			$stdUser = $this->CronModel->get_std_user($company_email,$company_name);
			if(count($stdUser)>0){
			foreach($stdUser as $stdUserRow)
			{
			$checkPer=check_permission('Receive Renewal Mail',$stdUserRow['id']); 
			if((isset($checkPer['other']) && $checkPer['other']==1)){
			    
			$renewal_data   = $this->CronModel->get_renewal_so($company_email,$company_name,$stdUserRow['standard_email']);
			if(count($renewal_data)>0){
			$current_date 	= date_create(date('Y-m-d'));
			$bodyMessage="";
			$bodyMessage.="<table class='tblCls' width='100%' cellpadding='10' cellspacing='0'>";
				$bodyMessage.="<tr>";
				$bodyMessage.="<th>SO Subject</th>
				<th>SO ID</th>
				<th>Customer Name</th>
				<th>Contact Name</th>
				<th>SO Owner</th>
				<th>Renewal Date</th>
				<th>Days Left</th>
				";
				$bodyMessage.="</tr>";
			foreach($renewal_data as $renew){ 
				$renewa_end_date= date_create($renew['renewal_date']);		
				$diff 	= date_diff($renewa_end_date,$current_date);
				$d 		= $diff->format("%a");
				$bodyMessage.="<tr>";
				$bodyMessage.="
				<td>".$renew['subject']."</td>
				<td>".$renew['saleorder_id']."</td>
				<td>".$renew['org_name']."</td>
				<td>".$renew['contact_name']."</td>
				<td>".$renew['owner']."</td>
				<td>".$renew['renewal_date']."</td>
				<td>".$d." Days</td>
				";
				$bodyMessage.="</tr>";
			
			}
			$bodyMessage.="</table>";
			
			$output2 ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html><head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <title></title>
                    <style type="text/css" rel="stylesheet" media="all">body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
                    body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
                    td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size:16px;line-height:1.625}p.sub{font-size:13px}.align-right{text-align:right} .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
                    .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0} .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
                    .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
                     .tblCls th, .tblCls td{
                            border: 1px solid #333;
                            font-size: 13px;
                    }
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
                                            <img src="https://team365.io/assets/img/new-logo.png"></a>
                                          </a>
                                        </td>
                                    </tr>
                                    <!-- Email Body -->
                                    <tr>
                                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                                            <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                              <!-- Body content -->
                                              <tr>
                                                <td class="content-cell">
                                                  <div class="f-fallback">
                                                    <h1>Hi, '.$stdUserRow['standard_name'].'!</h1>
                                                    <p>Here your renewal sales order-</p>
                                                    <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                      <tr>
                                                        <td align="center">
                                                          '.$bodyMessage.'
                                                        </td>
                                                      </tr>
                                                    </table>
                                                    <p>
													To prevent this revieving mail , Please login your team365 CRM account and change work-flow setting..
													</p>
                                                    <p>Regards,<br>Team365</p>
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
               //$this->email_lib->send_email('dev2@team365.io', $subject, $output2);             
				$this->email_lib->send_email($stdUserRow['standard_email'], $subject, $output2);
				}
			}
			}
			}
	        }
		 }
		}
	}
	
	
	private function _renewal_so_customer()
	{
		$data 		= $this->CronModel->get_adminemail();
		
		foreach($data as $row)
	    {
	        $bodyMessage='';
			
	        $company_email 	= $row['company_email'];
	        $company_name 	= $row['company_name'];
			
			$subject	= 'Reminder for your renwal products - '.$company_name;
			
			$checkPer	= $this->Workflow_model->check_workflows($company_email,$company_name,'Customer','Mail notification for renewal');
		 if((isset($checkPer['trigger_workflow_on']) && $checkPer['trigger_workflow_on']==1)){	
			
	     if($company_email!="" &&  $company_name!="" ){
			$renewal_data   = $this->CronModel->get_renewal_so($company_email,$company_name);
			if(count($renewal_data)>0){
			$current_date 	= date_create(date('Y-m-d'));
			$bodyMessage="";
			$bodyMessage.="<table class='tblCls' width='100%' cellpadding='10' cellspacing='0'>";
				$bodyMessage.="<tr>";
				$bodyMessage.="<th>SO Subject</th>
				<th>SO ID</th>
				<th>Customer Name</th>
				<th>Contact Name</th>
				<th>SO Owner</th>
				<th>Renewal Date</th>
				<th>Days Left</th>";
				$bodyMessage.="</tr>";
			foreach($renewal_data as $renew){
				
				$renewa_end_date= date_create($renew['renewal_date']);		
				$diff 	= date_diff($renewa_end_date,$current_date);
				$d 		= $diff->format("%a");
				$bodyMessage.="<tr>";
				$bodyMessage.="
				<td>".$renew['subject']."</td>
				<td>".$renew['saleorder_id']."</td>
				<td>".$renew['org_name']."</td>
				<td>".$renew['contact_name']."</td>
				<td>".$renew['owner']."</td>
				<td>".$renew['renewal_date']."</td>
				<td>".$d." Days</td>
				";
				$bodyMessage.="</tr>";
			
			
			$bodyMessage.="</table>";
			
			$output2 ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html><head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> <title></title>
                    <style type="text/css" rel="stylesheet" media="all">body{width:100%!important;height:100%;margin:0;-webkit-text-size-adjust:none}a{color:#3869d4}td{word-break:break-word}
                    body,td,th{font-family:"Nunito Sans",Helvetica,Arial,sans-serif}h1{margin-top:0;color:#333;font-size:22px;font-weight:700;text-align:left}
                    td,th{font-size:16px}blockquote,ol,p,ul{margin:.4em 0 1.1875em;font-size:16px;line-height:1.625}p.sub{font-size:13px}.align-right{text-align:right} .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:0}
                    .related{width:100%;margin:0;padding:25px 0 0 0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0} .related_item{padding:10px 0;color:#cbcccf;font-size:15px;line-height:18px}.related_item-title{display:block;margin:.5em 0 0}
                    .related_heading{border-top:1px solid #cbcccf;text-align:center;padding:25px 0 10px}body{background-color:#f4f4f7;color:#51545e}p{color:#51545e}p.sub{color:#6b6e76}   .email-body{width:100%;margin:0;padding:0;-premailer-width:100%;-premailer-cellpadding:0;-premailer-cellspacing:0;background-color:#fff}
                     .tblCls th, .tblCls td{
                            border: 1px solid #333;
                            font-size: 13px;
                    }
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
                                            <a href="https://team365.io/" class="f-fallback email-masthead_name">'.strtoupper($company_name).'</a>
                                          </a>
                                        </td>
                                    </tr>
                                    <!-- Email Body -->
                                    <tr>
                                        <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                                            <table class="email-body_inner" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                              <!-- Body content -->
                                              <tr>
                                                <td class="content-cell">
                                                  <div class="f-fallback">
												    <center><h1>Renewal Alert</h1></center>
                                                    <h2>Hi, '.$renew['contact_name'].'!</h2>
                                                    <p>This mail is to remind you that your product licence is about to expire on the '.$renew['renewal_date'].'. </p>
													<p>'.$company_name.' company has been servicing you for your renewal.</p>
                                                    <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                      <tr>
                                                        <td align="center">
                                                          '.$bodyMessage.'
                                                        </td>
                                                      </tr>
                                                    </table>
                                                    <p>Regards,<br>'.$company_name.'</p>
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
                                                  <p class="f-fallback sub align-center">&copy; '.date("Y").' '.$company_name.'. All rights reserved</p>
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
				$this->email_lib->send_email($stdUserRow['standard_email'], $subject, $output2);
				}
			 
			}
	        }
		 }
		}
	}
	
	public function index()
	{
	    
		$this->_trial_end();
		$this->_check_trial();
		$this->_renewal_so();
		$this->_renewal_so_user();
		$this->_renewal_so_customer()();
	}
	
}
?>