<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Customer_activity extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Activity_model', 'Activity');
        $this->load->library('email_lib');
        if (checkModuleForContr('Create Customers') < 1) {
            redirect('home');
        }
    }
    public function add_note() {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $contactName = $this->input->post('contactName');
        $notearea = $this->input->post('notearea');
        $contact = $this->input->post('contact');
        $org_name = $this->input->post('orgNameNote');
        $orgIdNote = $this->input->post('orgIdNote');
        $currentdate = date("Y-m-d");
        $data = array('sess_eml' => $sess_eml, 'session_company' => $session_company, 'session_comp_email' => $session_comp_email, 'org_name' => $org_name, 'org_id' => $orgIdNote, 'contact_id' => $contactName, 'contact_name' => $contact, 'note' => $notearea, 'delete_status' => 1, 'currentdate' => $currentdate, 'ip' => $this->input->ip_address());
        $activity_id = $this->Activity->insertData($data, 'customer_note');
        add_customer_activity($activity_id, $org_name, $orgIdNote, $contactName, $contact, 'customer_note');
        if ($activity_id) {
            echo "1";
        } else {
            echo "0";
        }
    }
    public function send_email() {
        
        // Load the form validation library
        $this->load->library('form_validation');
        // Define validation rules for your form fields
        $this->form_validation->set_rules('orgName', 'Organization Name', 'required');
        $this->form_validation->set_rules('orgEmail', 'Organization Email', 'required|valid_email');
        $this->form_validation->set_rules('subEmail', 'Subject', 'required');
        // Add validation rules for other fields as needed
        
        if ($this->form_validation->run() === FALSE) {
            // Form validation failed, return an error response
            echo validation_errors(); // You can customize the error handling as needed
        } else {
                         echo "here";
                exit;
                $session_comp_email = $this->session->userdata('company_email');
                $sess_eml = $this->session->userdata('email');
                $session_company = $this->session->userdata('company_name');
                $orgName = $this->input->post('orgName');
                $contactOrgName = $this->input->post('contactOrgName');
                $orgEmail = $this->input->post('orgEmail');
                $ccEmail = $this->input->post('ccEmail');
                $subEmail = $this->input->post('subEmail');
                $orgIdNote = $this->input->post('orgId');
                $orgNameCntid = $this->input->post('orgNameCntid');
                $descriptionTxt = $this->input->post('descriptionTxt');
    
                if (isset($orgNameCntid) && $orgNameCntid != "") {
                    $contactId = $orgNameCntid;
                    $actvName = 'customer_contact_email';
                    $orgNameCnt = $contactOrgName;
                } else {
                    $contactId = '';
                    $actvName = 'customer_email';
                    $orgNameCnt = $orgName;
                }
                
                $currentdate = date("Y-m-d");
                
                $dataEml = array(
                    'sess_eml' => $sess_eml,
                    'session_company' => $session_company,
                    'session_comp_email' => $session_comp_email,
                    'org_name' => $orgNameCnt,
                    'org_id' => $orgIdNote,
                    'contact_id' => $contactId,
                    'contact_name' => $orgName,
                    'email_adress' => $orgEmail,
                    'subject' => $subEmail,
                    'cc_email' => $ccEmail,
                    'email_body' => $descriptionTxt,
                    'delete_status' => 1,
                    'currentdate' => $currentdate,
                    'ip' => $this->input->ip_address()
                );
    
                $activity_id = $this->Activity->insertData($dataEml, 'customer_email');
                add_customer_activity($activity_id, $orgNameCnt, $orgIdNote, $contactId, $orgName, $actvName);
    
                $messageBody = '
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html>
                      <head>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title></title>
                        <!-- Your email styles go here -->
                      </head>
                      <body>
                        <!-- Your email content goes here -->
                      </body>
                    </html>';
    
                if (!$this->email_lib->send_email($orgEmail, $subEmail, $messageBody, $ccEmail)) {
                    echo "0"; // Email sending failed
                } else {
                    echo "1"; // Email sent successfully
                }
        }
    }
    public function addTask() {
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $currentdate = date("Y-m-d");
        if (check_permission_status('Task', 'create_u') == true) {
            if ($this->input->post('taskUser')) {
                $explodeData = implode("<br>", $this->input->post('taskUser'));
            } else {
                $explodeData = '';
            }
            $dataArrTask = array('sess_eml' => $this->session->userdata('email'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email'), 'task_owner' => $this->input->post('taskOwner'), 'org_name' => $this->input->post('custname'), 'org_id' => $this->input->post('custnameid'), 'contact_id' => $this->input->post('contactNameid'), 'contact_name' => $this->input->post('contactName'), 'task_subject' => $this->input->post('taskSubject'), 'task_from_date' => $this->input->post('taskFromDate'), 'task_due_date' => $this->input->post('taskDueDate'), 'task_priority' => $this->input->post('taskPriority'), 'asign_to' => $explodeData, 'remarks' => $this->input->post('taskRemarks'), 'status' => $this->input->post('taskStatus'), 'ip' => $this->input->ip_address(), 'currentdate' => date('Y-m-d'), 'delete_status' => 1);
            if ($this->input->post('taskReminder')) {
                $dataArrTask['task_reminder'] = $this->input->post('taskReminder');
            }
            if ($this->input->post('taskRepeat')) {
                $dataArrTask['task_repeat'] = $this->input->post('taskRepeat');
            }
            $dataRowId = $this->Activity->insertData($dataArrTask, 'opp_task');
            add_customer_activity($dataRowId, $this->input->post('custname'), $this->input->post('custnameid'), $this->input->post('contactNameid'), $this->input->post('contactName'), 'customer_task');
            //$dataRow=$this->setting->addTask($dataArrTask);
            if ($dataRowId) {
                $userEmail = $this->input->post('taskUser');
                for ($i = 0;$i < count($userEmail);$i++) {
                    $messageBody = '<div class="f-fallback">
						<h1>Hi, ' . $userEmail[$i] . '!</h1>
						<p>The folllowing task has been assigned to you by ' . $this->input->post('taskOwner') . ':</p>
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
													  <strong>Task:</strong> ' . $this->input->post('taskSubject') . '
													</span>
												  </td>
												</tr>
												<tr>
												  <td class="attributes_item">
													<span class="f-fallback">
													  <strong>Task Priority:</strong> ' . $this->input->post('taskPriority') . '
													</span>
												  </td>
												</tr>
												
												<tr>
												  <td class="attributes_item">
													<span class="f-fallback">
													  <strong>From Date:</strong> ' . $this->input->post('taskFromDate') . '
													</span>
												  </td>
												</tr>
												<tr>
												  <td class="attributes_item">
													<span class="f-fallback">
													  <strong>End Date:</strong> ' . $this->input->post('taskDueDate') . '
													</span>
												  </td>
												</tr>
												<tr>
												  <td class="attributes_item">
													<span class="f-fallback">
													  <strong>Description:</strong> ' . $this->input->post('taskRemarks') . '
													</span>
												  </td>
												</tr>
											  </table>
											</td>
										  </tr>
										</table>
									  </div>';
                    $subject = 'A new task assigned to you';
                    //$this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
                    sendMailWithTemp($userEmail[$i], $messageBody, $subject);
                }
                echo json_encode(array("status" => TRUE));
            } else {
                echo json_encode(array("error" => false));
            }
        }
    }
    public function addCall() {
        if (check_permission_status('Call', 'create_u') == true) {
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $currentdate = date("Y-m-d");
            $saveDataCall = $this->input->post('saveDataCall');
            $saveDataCallid = $this->input->post('saveDataCallid');
            if ($this->input->post('particepants')) {
                $particepants = implode("<br>", $this->input->post('particepants'));
            }
            $dataArrCall = array('sess_eml' => $this->session->userdata('email'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email'), 'org_name' => $this->input->post('custname'), 'org_id' => $this->input->post('custnameid'), 'contact_id' => $this->input->post('contactNameid'), 'contact_name' => $this->input->post('contactName'), 'contact_number' => $this->input->post('contactNumber'), 'call_subject' => $this->input->post('callSubject'), 'call_purpose' => $this->input->post('callPurpose'), 'owner' => $this->session->userdata('name'), 'from_date' => $this->input->post('mtngFromDate'), 'from_time' => $this->input->post('mtngFromTime'), 'to_date' => $this->input->post('mtngToDate'), 'to_time' => $this->input->post('mtngToTime'), 'related_to' => $this->input->post('callRelated'), 'reminder' => $this->input->post('mtngReminder'), 'call_type' => $this->input->post('callType'), 'call_detail' => $this->input->post('callDeatils'), 'call_description' => $this->input->post('callDescription'), 'remarks' => '', 'currentdate' => date('Y-m-d'), 'delete_status' => 1, 'status' => 1, 'ip' => $this->input->ip_address());
            if ($this->input->post('particepants')) {
                $dataArrCall['particepants'] = $particepants;
            }
            $dataRowCl = $this->Activity->insertData($dataArrCall, 'create_call');
            add_customer_activity($dataRowCl, $this->input->post('custname'), $this->input->post('custnameid'), $this->input->post('contactNameid'), $this->input->post('contactName'), 'customer_call');
            if ($dataRowCl) {
                $userEmail = $this->input->post('particepants');
                for ($i = 0;$i < count($userEmail);$i++) {
                    $messageBody = '<div class="f-fallback">
                        <h1>Hi, ' . $userEmail[$i] . '!</h1>
                        <p>I would like to invite you to a call. </p>
                        <p>The call will take place on the ' . $this->input->post('mtngFromDate') . ', starting at ' . $this->input->post('mtngFromTime') . '  and finishing at ' . $this->input->post('mtngToDate') . '  ' . $this->input->post('mtngToTime') . '.  Could you please confirm whether you will be able to participate? </p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                            <td align="center">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                  <td align="center">
                                                    <a href="' . base_url() . 'call" class="f-fallback button" target="_blank">Read More..</a>
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
                									  <strong>Call:</strong> ' . $this->input->post('callContactName') . '
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Host By:</strong> ' . $this->input->post('mtngHost') . '
                									</span>
                                                  </td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									 ' . $this->input->post('callDescription') . '
                									</span>
                                                  </td>
                                                </tr>
                                               
                                              </table>
                                            </td>
                                          </tr>
                                        </table>
                                      </div>';
                    $subject = 'Get ready for new call - ' . $this->input->post('CallSubject');
                    //$this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
                    sendMailWithTemp($userEmail[$i], $messageBody, $subject);
                }
                echo json_encode(array("status" => TRUE));
            } else {
                echo json_encode(array("error" => false));
            }
        } else {
            echo json_encode(array("error" => false));
        }
    }
    public function addMeeting() {
        $addData = $this->input->post('saveDatamtng');
        $saveDatamtngid = $this->input->post('saveDatamtngid');
        $session_comp_email = $this->session->userdata('company_email');
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $currentdate = date("Y-m-d");
        if ($this->input->post('mtngParticepants')) {
            $mtngParticepants = implode("<br>", $this->input->post('mtngParticepants'));
        }
        $dataArrMtng = array('sess_eml' => $this->session->userdata('email'), 'session_company' => $this->session->userdata('company_name'), 'session_comp_email' => $this->session->userdata('company_email'), 'host_name' => $this->input->post('mtngHost'), 'org_name' => $this->input->post('custname'), 'org_id' => $this->input->post('custnameid'), 'contact_id' => $this->input->post('contactNameid'), 'contact_name' => $this->input->post('contactName'), 'meeting_title' => $this->input->post('mtngTitle'), 'location' => $this->input->post('mtngLocation'), 'from_date' => $this->input->post('mtngFromDate'), 'from_time' => $this->input->post('mtngFromTime'), 'to_date' => $this->input->post('mtngToDate'), 'to_time' => $this->input->post('mtngToTime'), 'reminder' => $this->input->post('mtngReminder'), 'remarks' => $this->input->post('taskRemarks'), 'status' => $this->input->post('taskStatus'), 'ip' => $this->input->ip_address(), 'currentdate' => date('Y-m-d'), 'delete_status' => 1);
        if ($this->input->post('mtngAllday')) {
            $dataArrMtng['all_day'] = $this->input->post('mtngAllday');
        }
        if ($this->input->post('mtngParticepants')) {
            $dataArrMtng['particepants'] = $mtngParticepants;
        }
        $dataRowMtng = $this->Activity->insertData($dataArrMtng, 'meeting');
        add_customer_activity($dataRowMtng, $this->input->post('custname'), $this->input->post('custnameid'), $this->input->post('contactNameid'), $this->input->post('contactName'), 'customer_meeting');
        $userEmail = $this->input->post('mtngParticepants');
        if ($dataRowMtng && isset($userEmail) && $userEmail != "") {
            for ($i = 0;$i < count($userEmail);$i++) {
                $messageBody = '<div class="f-fallback">
                        <h1>Hi, ' . $userEmail[$i] . '!</h1>
                        <p>I would like to invite you to a meeting at ' . $this->input->post('mtngLocation') . '</p>
                        <p>The meeting will take place on the ' . $this->input->post('mtngFromDate') . ', starting at ' . $this->input->post('mtngFromTime') . ' and finishing at ' . $this->input->post('mtngToDate') . '  ' . $this->input->post('mtngToTime') . '.   Could you please confirm whether you will be able to participate? </p>
                        <!-- Action -->
                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td align="center">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                        <tr>
                                            <td align="center">
                                                <a href="https://allegient.team365.io/meeting" class="f-fallback button" target="_blank">Read More..</a>
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
                									<strong>Meeting:</strong> ' . $this->input->post('mtngTitle') . '
                								</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="attributes_item">
                                                <span class="f-fallback">
                									<strong>Host By:</strong> ' . $this->input->post('mtngHost') . '
                								</span>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td class="attributes_item">
                                                <span class="f-fallback">
                									 ' . $this->input->post('taskRemarks') . '
                								</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>';
                $subject = 'Get ready for new meeting - ' . $this->input->post('mtngTitle');
                //$this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
                sendMailWithTemp($userEmail[$i], $messageBody, $subject);
            }
            echo json_encode(array("status" => TRUE));
        } else {
            echo json_encode(array("error" => false));
        }
    }
    public function get_activity() {
        $id = $this->input->post('cust_id');
        $activity_name = $this->input->post('activity');
        if ($activity_name == 'Activity') {
            $activity_name = '';
        }
        $activityCust = $this->Activity->get_customer_activity($id, $activity_name);
        if (count($activityCust) > 0) {
            foreach ($activityCust as $row) {
                $viewUrl = '';
                if ($row['activity_name'] == 'customer_note') {
                    $tableName = "customer_note";
                    $selectClm = "contact_name as title, owner, note";
                    $iconName = 'far fa-edit sub-icn-forecast';
                }
                if ($row['activity_name'] == 'customer_email') {
                    $tableName = "customer_email";
                    $selectClm = "subject as title, owner, contact_name,email_adress, cc_email,email_body,timedate";
                    $iconName = 'far fa-envelope sub-icn-contact';
                }
                if ($row['activity_name'] == 'customer_contact_email') {
                    $tableName = "customer_email";
                    $selectClm = "subject as title, owner";
                    $iconName = 'far fa-envelope sub-icn-contact';
                }
                if ($row['activity_name'] == 'customer_task') {
                    $tableName = "opp_task";
                    $selectClm = "task_subject as title, owner, contact_name,task_from_date,task_due_date,asign_to,currentdate,remarks, status, task_repeat, task_reminder";
                    $viewUrl = 'task?tid=';
                    $iconName = 'fas fa-tasks sub-icn-task';
                }
                if ($row['activity_name'] == 'customer_call') {
                    $tableName = "create_call";
                    $selectClm = "call_subject as title, owner, particepants, contact_name, from_date, from_time, to_date, to_time, call_purpose,contact_number";
                    $viewUrl = 'call?cid=';
                    $iconName = 'fas fa-phone-alt sub-icn-call';
                }
                if ($row['activity_name'] == 'customer_meeting') {
                    $tableName = "meeting";
                    $selectClm = "meeting_title as title, host_name as owner, location,all_day,from_date,from_time,to_date,to_time,particepants,currentdate, host_name,contact_name,reminder,remarks,status ";
                    $viewUrl = 'meeting?mid=';
                    $iconName = 'far fa-handshake sub-icn-meeting';
                }
                if (isset($tableName) && $tableName != "") {
                    $getActivity = $this->Activity->getActivity($tableName, $selectClm, $row['activity_id']);
?>
			<div class="col-sm-12 p-3 mb-1  bg-white">
									<div  class="bg-light p-1  bg-white" 
										data-toggle="collapse" 
										data-target="#collapse<?=$row['id']; ?>" 
										aria-expanded="true" 
										aria-controls="collapse<?=$row['id']; ?>">
										<?php
                    $activityName = str_replace("customer_", " ", $row['activity_name']);
                    $activityName = str_replace("contact_", " ", $activityName); ?>
										<div class="row p-2 ">	
											<div class="col-sm-6 mt-1 mb-1">
											
												<i class="<?=$iconName; ?> mr-3"></i>
												
												<text><?=ucwords($activityName); ?></text>
											</div>
											<div class="col-sm-6 mt-1 mb-1  text-right">
												<?php if (isset($row['timedate'])) { ?>
												<text><i class="far fa-calendar-alt mr-2"></i> 
												<?php $newDate = date("d M Y", strtotime($row['timedate'])); ?>
												<?php $newTime = date("H:i a", strtotime($row['timedate'])); ?>
												<?php echo $newDate . ' <i class="far fa-clock mr-1 ml-1"></i> ' . $newTime; ?>
											<?php
                    } ?>
											</div>
											
										</div>
									</div>
									<div id="collapse<?=$row['id']; ?>" class="collapse bg-white">
										<div class="row p-2">	
											<div class="col-sm-12 mt-2 mb-1">
											
												<?php if ($row['activity_name'] == 'customer_call') { ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Call Purpose</text>
														<p><?=$getActivity['call_purpose']; ?></p>
													</div>
													<?php if ($getActivity['contact_number'] == 1) { ?>	
													<div class="col-md-12">
														<text class="text-info" >Contact Number</text>
														<p><?=$getActivity['contact_number']; ?></p>
													</div>
													<?php
                        } ?>
													<div class="col-md-6">
														<text class="text-info" >Start Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));
                        $getActivity['from_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['from_time'])); ?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >End Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));
                        $getActivity['to_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['to_time'])); ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Particepants User</text>
														<?php
                        if (isset($getActivity['particepants']) && $getActivity['particepants'] != "") {
                            $userArr = explode("<br>", $getActivity['particepants']);
                            echo "<ul class='ml-4'>";
                            for ($i = 0;$i < count($userArr);$i++) {
                                if ($userArr[$i] != "") {
                                    $userList = $this->Activity->getUser($userArr[$i]);
                                    //print_r($userList);
                                    $adminList = $this->Activity->getUserAdmin($userArr[$i]);
                                    if (isset($userList) && count($userList) > 0) {
                                        echo "<li>" . $userList['standard_name'] . "</li>";
                                    }
                                    if (isset($adminList) && count($adminList) > 0) {
                                        echo "<li>" . $adminList['admin_name'] . "</li>";
                                    }
                                }
                            }
                            echo "</ul>";
                        }
?>
													</div>
													<?php if ($viewUrl) { ?>
													<div class="col-md-12 text-right">
														<i class="far fa-eye mr-2"></i> 
														<a href="<?=base_url() . $viewUrl . $row['activity_id']; ?>" >View Details</a>
													</div>
													<?php
                        } ?>
												</div>
												<?php
                    } ?>
												
												<?php if ($row['activity_name'] == 'customer_task') { ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Task</text><text> assigned to </text>
														<?php
                        if (isset($getActivity['asign_to']) && $getActivity['asign_to'] != "") {
                            $userArr = explode("<br>", $getActivity['asign_to']);
                            echo "<ul class='ml-4'>";
                            for ($i = 0;$i < count($userArr);$i++) {
                                if ($userArr[$i] != "") {
                                    $userList = $this->Activity->getUser($userArr[$i]);
                                    //print_r($userList);
                                    $adminList = $this->Activity->getUserAdmin($userArr[$i]);
                                    if (isset($userList) && count($userList) > 0) {
                                        echo "<li>" . $userList['standard_name'] . "</li>";
                                    }
                                    if (isset($adminList) && count($adminList) > 0) {
                                        echo "<li>" . $adminList['admin_name'] . "</li>";
                                    }
                                }
                            }
                            echo "</ul>";
                        }
?>
													</div>
													<div class="col-md-12 mt-1">
														<text class="text-info" >Task Subject</text>
														<p><?=$getActivity['title']; ?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >Start Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['task_from_date'])); ?></p>
													</div>
													
													<div class="col-md-6">
														<text class="text-info" >Due Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['task_due_date'])); ?>
														</p>
													</div>
													
													<?php if ($getActivity['contact_name'] != "") { ?>	
													<div class="col-md-12">
														<text class="text-info" >Customer Contact Name</text>
														<p><?=$getActivity['contact_name']; ?></p>
													</div>
													<?php
                        } ?>
													
													<div class="col-md-4">
														<text class="text-info" >Status</text>
														<p><?php if ($getActivity['status'] == 1) {
                            echo "Not Started";
                        } else if ($getActivity['status'] == 2) {
                            echo "Completed";
                        } else if ($getActivity['status'] == 3) {
                            echo "Progress";
                        } else if ($getActivity['status'] == 0) {
                            echo "Deactive";
                        } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >Reminder</text>
														<p><?php if ($getActivity['task_reminder'] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >Reminder Repeat</text>
														<p><?php if ($getActivity['task_repeat'] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >remarks</text>
														<p><?=$getActivity['remarks']; ?></p>
													</div>
													
													<div class="col-md-12">
														<text class="text-info" >Added Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['currentdate'])); ?></p>
													</div>
												
												</div>
												<?php
                    } ?>
											
												<?php if ($row['activity_name'] == 'customer_email') { ?>
												<div class="row mt-3">
													<div class="col-md-12">
													    <b>Email</b><text> sent to <?=$getActivity['contact_name']; ?> < <?=$getActivity['email_adress']; ?> ></text>
														
													</div>
													
													
													<?php if ($getActivity['cc_email'] != "") { ?>	
													<div class="col-md-12">
														<text class="text-info" >CC Email</text>
														<p class="pl-2"><?=$getActivity['cc_email']; ?></p>
													</div>
													<?php
                        } ?>
													<div class="col-md-12">
														<text class="text-info">Subject</text>
														<text class="pl-2"><?=$getActivity['title']; ?></text>
													</div>
													<div class="col-md-12 mt-1">
														<p class="pl-2"><?php
                        echo $getActivity['email_body'];
                        /*$stripTags=strip_tags($getActivity['email_body']);
                        
                        echo substr($stripTags,0,100)."...";*/
?></p>
													</div>
													<div class="col-md-12 text-right">
														<text class="text-info" >Date & Time</text>
														<p class="pl-2"><?=date("d M Y h:s a", strtotime($getActivity['timedate'])); ?></p>
													</div>
												
												</div>
												<?php
                    } ?>
												
												<?php if ($row['activity_name'] == 'customer_meeting') { ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Meeting - </text>
														<text><?=$getActivity['title']; ?></text> by <?=ucwords($getActivity['host_name']); ?> <br>With <?=ucwords($getActivity['contact_name']); ?> 
													</div>
													<div class="col-md-12">
														<text class="text-info" >Location</text>
														<p><?=$getActivity['location']; ?></p>
													</div>
													<?php if ($getActivity['all_day'] == 1) { ?>	
													<div class="col-md-12">
														<text class="text-info" >All Day or Not</text>
														<p>All day meeting</p>
													</div>
													<?php
                        } ?>
													<div class="col-md-6">
														<text class="text-info" >Start Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));
                        $getActivity['from_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['from_time'])); ?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >End Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));
                        $getActivity['to_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['to_time'])); ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Reminder </text>
														<p><?php if ($getActivity['reminder'] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        } ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Remarks</text>
														<p><?=$getActivity['remarks']; ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Status</text>
												<p><?php if ($getActivity['status'] == 1) {
                            echo "Not Started";
                        } else if ($getActivity['status'] == 1) {
                            echo "Completed";
                        } else if ($getActivity['status'] == 3) {
                            echo "Progress";
                        } else if ($getActivity['status'] == 0) {
                            echo "Deactive";
                        } ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Particepants User</text>
														<p><?php
                        if (isset($getActivity['particepants']) && $getActivity['particepants'] != "") {
                            $userArr = explode("<br>", $getActivity['particepants']);
                            echo "<ul class='ml-4'>";
                            for ($i = 0;$i < count($userArr);$i++) {
                                if ($userArr[$i] != "") {
                                    $userList = $this->Activity->getUser($userArr[$i]);
                                    //print_r($userList);
                                    $adminList = $this->Activity->getUserAdmin($userArr[$i]);
                                    if (isset($userList) && count($userList) > 0) {
                                        echo "<li>" . $userList['standard_name'] . "</li>";
                                    }
                                    if (isset($adminList) && count($adminList) > 0) {
                                        echo "<li>" . $adminList['admin_name'] . "</li>";
                                    }
                                }
                            }
                            echo "</ul>";
                        }
?></p>
													</div>
												</div>
												<?php
                    }
                    if ($row['activity_name'] == 'customer_note') { ?>
													<div class="row mt-3">
														<div class="col-md-12">
														<?php echo $getActivity['note']; ?>
														</div>
													</div>
												<?php
                    } ?>
											</div>
										</div>
									</div>
								</div>
			<?php
                }
            }
        } else {
            echo '<div class="col-md-12 text-center p-3">Record not found</div>';
        } ?>	  
				
					<?php
    }
}
?>
