<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Setting_model','setting');
    $this->load->model('Login_model');
    $this->load->library(array('upload','email_lib'));
  }
  
  
  public function addfbdata(){
        $dataRowCount=$this->setting->checkExistFbApp($this->input->post('FACEBOOK_FORM_ID'),$this->input->post('FACEBOOK_ACCESS_TOKEN'));
        if(count($dataRowCount)>0){
             $dataArrFb=array(
            'title'             => $this->input->post('TITLE'),
            'fb_app_id'         => $this->input->post('FACEBOOK_APP_ID'),
            'fb_secret_key'     => $this->input->post('FACEBOOK_APP_SECRET'),
            'fb_access_token'   => $this->input->post('FACEBOOK_ACCESS_TOKEN'),
            'fb_app_version'    => $this->input->post('FB_API_VERSION'),
            'fb_form_id'        => $this->input->post('FACEBOOK_FORM_ID'),
            'fb_page_id'        => $this->input->post('FACEBOOK_PAGE_ID'),
            'fb_form_name'      => $this->input->post('FACEBOOK_FORM_NAME'),
            'updated_date'      => date('Y-m-d'),
            'fb_form_status'    => $this->input->post('FACEBOOK_FORM_STATUS'),
            'ip'                => $this->input->ip_address()
          );
            $dataRow=$this->setting->UpdateFbData($dataArrFb,$this->input->post('FACEBOOK_FORM_ID'));
        }else{
			$dataArrFb=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'comp_id'           => $this->session->userdata('id'),
            'title'             => $this->input->post('TITLE'),
            'fb_app_id'         => $this->input->post('FACEBOOK_APP_ID'),
            'fb_secret_key'     => $this->input->post('FACEBOOK_APP_SECRET'),
            'fb_access_token'   => $this->input->post('FACEBOOK_ACCESS_TOKEN'),
            'fb_app_version'    => $this->input->post('FB_API_VERSION'),
            'fb_form_id'        => $this->input->post('FACEBOOK_FORM_ID'),
            'fb_page_id'        => $this->input->post('FACEBOOK_PAGE_ID'),
            'fb_form_name'      => $this->input->post('FACEBOOK_FORM_NAME'),
            'created_date'      => date('Y-m-d'),
            'delete_status'     => 1,
            'fb_form_status'    => $this->input->post('FACEBOOK_FORM_STATUS'),
            'status'            => 1,
            'ip'                => $this->input->ip_address()
          );
        $dataRow=$this->setting->AddFbData($dataArrFb);
         }
       if($dataRow){
           echo json_encode(array("status" => TRUE));
       }else{
           echo json_encode(array("error" => false));
       }
      
  }
  
  
  
  
#################################################
#                                               #
#                MEETING CODE                   #
#                                               #
#################################################
  
  public function meeting()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Create Followup')<1){
        	    redirect('home');
        	    exit;
        }
		if(check_permission_status('Meeting','retrieve_u')==true){ 
			$data['user'] 		= $this->Login_model->getusername();
			$data['users_data'] = $this->Login_model->get_company_users();
			$data['admin'] 		= $this->Login_model->getadminname();
			$this->load->view('setting/meeting',$data);
		}else{
			redirect("permission");
		}
    }
    else
    {
      redirect('login');
    }
  }
  
  
  
  public function ajax_list()
  {
	  
	$delete_mtng	=0;
	$update_mtng	=0;
	$retrieve_mtng  =0; 
	if(check_permission_status('Meeting','delete_u')==true){
		$delete_mtng	=1;
	}
	if(check_permission_status('Meeting','retrieve_u')==true){
		$retrieve_mtng	=1;
	}
	if(check_permission_status('Meeting','update_u')==true){
		$update_mtng	=1;
	}  
	  
    $list = $this->setting->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  //$row[] = $first_row;
    		  
      $first_row = "";
      $first_row.= ucfirst($post->meeting_title).'<!--<div class="links">';
      if($update_mtng==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-success">View / Update</a>';
      endif;
      
      if($delete_mtng==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_meeting('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      
      $row[] = $first_row;
      $row[] = ucfirst($post->host_name);
      $row[] = $post->location;
      
     $date=date_create($post->from_date);
     $date2=date_create($post->to_date);
     
     if($post->from_date==$post->to_date){
        $row[] = date_format($date,"d M Y").', (<text class="timeIc">'.$post->from_time.' - '.$post->to_time.'</text>)';
     }else{
        $row[] = date_format($date,"d M Y").' (<text class="timeIc">'.$post->from_time.'</text>) to '.date_format($date2,"d M Y").' (<text  class="timeIc">'.$post->to_time.'</text>)';
     }
      
      $status=$post->status;
      if($status==1){
          $ptStatus='<span class="badge badge-light">Not Started</span>';
      }else if($status==2){
          $ptStatus='<span class="badge badge-pill badge-success">Compeleted</span>';
      }else if($status==3){
          $ptStatus='<span class="badge badge-pill badge-info">Progress</span>';
      }else if($status==0){
          $ptStatus='<span class="badge badge-pill badge-dark">Deactive</span>';
      }else if($status==4){
          $ptStatus='<span class="badge badge-pill badge-danger">Pending</span>';
          
      }
      $row[] = $ptStatus;
	  
	    $action='<div class="row" style="font-size: 15px;">';
		if($update_mtng==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Meeting Details" ></i></a>';
		}
		if($update_mtng==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-primary border-right"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Meeting Details" ></i></a>';
		}	
		if($delete_mtng==1){	
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_meeting('."'".$post->id."'".')"  class="text-danger"><i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Meeting" ></i></a>';
		}
		$action.='</div>';
           
		$row[]=$action;
	  
	  
      
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->setting->count_all(),
      "recordsFiltered" => $this->setting->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  
   
  public function getbyid_meeting($id){
    $data = $this->setting->getbyid_meeting($id);
    echo json_encode($data);
  }
  
  public function delete_meeting($id){
    $data = array('delete_status'=>'2');
    $dataRow= $this->setting->updateMeeting($data,$id);
   if($dataRow){
       echo json_encode(array("status" => TRUE));
   }else{
       echo json_encode(array("error" => false));
   }
  }
  
  
 public function updateMeeting(){ 
     
  $addData=$this->input->post('saveDatamtng');
  $saveDatamtngid=$this->input->post('saveDatamtngid');
  
   if($addData=='1'){
       
    if($this->input->post('mtngParticepants')) { 
           $mtngParticepants= implode("<br>",$this->input->post('mtngParticepants'));
    }
       
       
       
    $dataArrMtng=array(
            'host_name'         => $this->input->post('mtngHost'),
            'meeting_title'     => $this->input->post('mtngTitle'),
            'location'          => $this->input->post('mtngLocation'),
            'from_date'         => $this->input->post('mtngFromDate'),
            'from_time'         => $this->input->post('mtngFromTime'),
            'to_date'           => $this->input->post('mtngToDate'),
            'to_time'           => $this->input->post('mtngToTime'),
            'reminder'          => $this->input->post('mtngReminder'),
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
            'ip'                => $this->input->ip_address()
          );
          //mtngParticepants
        if($this->input->post('mtngAllday')) { 
           $dataArrMtng['all_day'] = $this->input->post('mtngAllday');
        }
        
        if($this->input->post('mtngParticepants')) { 
           $dataArrMtng['particepants'] = $mtngParticepants;
        }
      
		$dataRow=$this->setting->updateMeeting($dataArrMtng,$saveDatamtngid);
		if($dataRow){
			echo json_encode(array("status" => TRUE));
		}else{
			echo json_encode(array("error" => false));
		}
   }
   
 }
  
  
 public function addMeeting(){ 
  
  $addData=$this->input->post('saveDatamtng');
  $saveDatamtngid=$this->input->post('saveDatamtngid');
  
    if($this->input->post('mtngParticepants')) { 
           $mtngParticepants= implode("<br>",$this->input->post('mtngParticepants'));
    }
  
   if($addData=='1'){
    $dataArrMtng=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'host_name'         => $this->input->post('mtngHost'),
            'meeting_title'     => $this->input->post('mtngTitle'),
            'location'          => $this->input->post('mtngLocation'),
            'from_date'         => $this->input->post('mtngFromDate'),
            'from_time'         => $this->input->post('mtngFromTime'),
            'to_date'           => $this->input->post('mtngToDate'),
            'to_time'           => $this->input->post('mtngToTime'),
            'reminder'          => $this->input->post('mtngReminder'),
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
             'ip'                => $this->input->ip_address(),
            'currentdate'       => date('Y-m-d'),
            'delete_status'     => 1
          );
          //mtngParticepants
        if($this->input->post('mtngAllday')) { 
           $dataArrMtng['all_day'] = $this->input->post('mtngAllday');
        }
        
        if($this->input->post('mtngParticepants')) { 
           $dataArrMtng['particepants'] = $mtngParticepants;
        }
      
    $dataRow=$this->setting->addMeeting($dataArrMtng);
       if($dataRow){
     $userEmail=$this->input->post('mtngParticepants');
    for($i=0; $i<count($userEmail); $i++){
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
                   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
                                        <h1>Hi, '.$userEmail[$i].'!</h1>
                                        <p>I would like to invite you to a meeting at '.$this->input->post('mtngLocation').'</p>
                                        
                                        <p>
                                        The meeting will take place on the '.$this->input->post('mtngFromDate').', starting at '.$this->input->post('mtngFromTime').' 
                                        and finishing at '.$this->input->post('mtngToDate').'  '.$this->input->post('mtngToTime').'. 
                                        Could you please confirm whether you will be able to participate?
                                        </p>
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
                									  <strong>Meeting:</strong> '.$this->input->post('mtngTitle').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Host By:</strong> '.$this->input->post('mtngHost').'
                									</span>
                                                  </td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									 '.$this->input->post('taskRemarks').'
                									</span>
                                                  </td>
                                                </tr>
                                               
                                              </table>
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
                $subject='Get ready for new meeting - '.$this->input->post('mtngTitle');           
                $this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
            }
          
           echo json_encode(array("status" => TRUE));
       }else{
           echo json_encode(array("error" => false));
       }
   }
   
 } 
  
     
 
 
#################################################
#                                               #
#                TASK CODE                      #
#                                               #
#################################################
  
  public function task()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Create Followup')<1){
        	    redirect('home');
        	    exit;
        }
		if(check_permission_status('Task','retrieve_u')==true){
		  $this->load->model('Login_model');  
		  $data['users_data'] = $this->Login_model->get_company_users();
		  $data['task'] 	  = $this->setting->getAllTask();
		  $this->load->view('setting/task',$data);
		}else{
			redirect("permission");
			exit;
		}
    }
    else
    {
      redirect('login');
    }
  }
  /*
  public function view_task($id){
	$data['record'] = $this->setting->get_by_id_task($id,'view');
	$this->load->view('followup/view-task',$data);  
  }
  */
  public function ajax_list_task()
  {
	$delete_task	= 0;
	$update_task	= 0;
	$retrieve_task  = 0; 
	if(check_permission_status('Task','delete_u')==true){
		$delete_task=1;
	}
	if(check_permission_status('Task','retrieve_u')==true){
		$retrieve_task=1;
	}
	if(check_permission_status('Task','update_u')==true){
		$update_task=1;
	}  
	  
    $list = $this->setting->get_datatables_tsk();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  //$row[] = $first_row;
    		  
      $first_row = "";
      $first_row.= ucfirst($post->task_subject).'<!--<div class="links">';
      if($update_task==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-success">View/Update</a>';
      endif;
      if($this->session->userdata('type')=='admin'):
        $first_row.= ' | <a style="text-decoration:none" href="javascript:void(0)" onclick="sendmail('."'".$post->id."'".')" class="text-success">Send Mail</a>';
      endif;
      if($delete_task==1):
        $first_row.= ' | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      
      $row[] = $first_row;
      $row[] = ucfirst($post->task_owner);
      $row[] = $post->task_priority;
      
     $date=date_create($post->task_due_date);
     
        $row[] = date_format($date,"d M Y");
     
     $status=$post->status;
      if($status==1){
          $ptStatus='<span class="badge badge-light">Not Started</span>';
      }else if($status==2){
          $ptStatus='<span class="badge badge-pill badge-success">Compeleted</span>';
      }else if($status==3){
          $ptStatus='<span class="badge badge-pill badge-info">Progress</span>';
      }else if($status==0){
          $ptStatus='<span class="badge badge-pill badge-dark">Deactive</span>';
      }else if($status==4){
          $ptStatus='<span class="badge badge-pill badge-danger">Pending</span>';
      }
	  
      $row[] = $ptStatus;
	  
	    $action='<div class="row" style="font-size: 15px;">';
		if($retrieve_task==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Task Details" ></i></a>';
		}
		if($update_task==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".','."'".$post->opportunity_id."'".')" class="text-primary border-right"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Task Details" ></i></a>';
		}

		if($this->session->userdata('type')=='admin'){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="sendmail('."'".$post->id."'".')" class="text-primary border-right"><i class="far fa-envelope text-info m-1" data-toggle="tooltip" data-container="body" title="Send Email" ></i></a>';
		}
		
		if($delete_task==1){	
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger"><i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Task" ></i></a>';
		}
		$action.='</div>';
           
		$row[]=$action;
	  
	  
        $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->setting->count_all_tsk(),
      "recordsFiltered" => $this->setting->count_filtered_tsk(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  
  
  public function getbyid_task($id){
    $data = $this->setting->get_by_id_task($id);
    echo json_encode($data);
  }
  
  public function getbyid_opp($id){
    $data = $this->setting->get_by_id_opp($id);
    echo json_encode($data);
  }
  
  public function delete_task($id){
	if(check_permission_status('Task','delete_u')==true){  
		$data = array('delete_status'=>'2');
		$dataRow= $this->setting->UpdateTask($data,$id);
	    if($dataRow){
		   echo json_encode(array("status" => TRUE));
	    }else{
		   echo json_encode(array("error" => false));
	    }
	}
  }
  
  public function updateTask(){
	if(check_permission_status('Task','update_u')==true){    
		$saveDatatask=$this->input->post('saveDatatask');
		$updateDatataskid=$this->input->post('updateDatataskid');
		if($this->input->post('taskUser')){
           $explodeData=implode("<br>",$this->input->post('taskUser'));
		}else{
           $explodeData='';
		}
	if($saveDatatask=='1'){
      $dataArrTask=array(
            'task_owner'        => $this->input->post('taskOwner'),
            'task_subject'      => $this->input->post('taskSubject'),
            'task_from_date'     => $this->input->post('taskFromDate'),
            'task_due_date'     => $this->input->post('taskDueDate'),
            'task_priority'     => $this->input->post('taskPriority'),
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
            'ip'                => $this->input->ip_address()
          );
          
          if($this->input->post('taskUser')){
             $dataArrTask['asign_to'] = $explodeData;
          }
          
          
         if($this->input->post('taskReminder')){ 
           $dataArrTask['task_reminder']=$this->input->post('taskReminder');
         }
         if($this->input->post('taskRepeat')){ 
           $dataArrTask['task_repeat']=$this->input->post('taskRepeat');
         }
      
	   $dataRow= $this->setting->UpdateTask($dataArrTask,$updateDatataskid);
	   if($dataRow){
		   echo json_encode(array("status" => TRUE));
	   }else{
		   echo json_encode(array("error" => false));
	   }
	}
	}
  }

public function addTask(){  
    if(check_permission_status('Task','create_u')==true){    
       if($this->input->post('taskUser')){
           $explodeData=implode("<br>",$this->input->post('taskUser'));
       }else{
           $explodeData='';
       }
       
      $dataArrTask=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'task_owner'        => $this->input->post('taskOwner'),
            'task_subject'      => $this->input->post('taskSubject'),
            'task_from_date'     => $this->input->post('taskFromDate'),
            'task_due_date'     => $this->input->post('taskDueDate'),
            'task_priority'     => $this->input->post('taskPriority'),
            'asign_to'          => $explodeData,
            'remarks'           => $this->input->post('taskRemarks'),
            'status'            => $this->input->post('taskStatus'),
            'ip'                => $this->input->ip_address(),
            'currentdate'       => date('Y-m-d'),
            'delete_status'     => 1
          );
          
         if($this->input->post('taskReminder')){ 
           $dataArrTask['task_reminder']=$this->input->post('taskReminder');
         }
         if($this->input->post('taskRepeat')){ 
           $dataArrTask['task_repeat']=$this->input->post('taskRepeat');
         }
      
        $dataRow=$this->setting->addTask($dataArrTask);
       if($dataRow){
           $userEmail=$this->input->post('taskUser');
    for($i=0; $i<count($userEmail); $i++){
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
   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
                        <h1>Hi, '.$userEmail[$i].'!</h1>
                        <p>The folllowing task has been assigned to you by '.$this->input->post('taskOwner').':</p>
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
									  <strong>Task:</strong> '.$this->input->post('taskSubject').'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Task Priority:</strong> '.$this->input->post('taskPriority').'
									</span>
                                  </td>
                                </tr>
                                
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>From Date:</strong> '.$this->input->post('taskFromDate').'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>End Date:</strong> '.$this->input->post('taskDueDate').'
									</span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
									  <strong>Description:</strong> '.$this->input->post('taskRemarks').'
									</span>
                                  </td>
                                </tr>
                              </table>
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
$subject='A new task assigned to you';           
$this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
   
}
           
       echo json_encode(array("status" => TRUE));
       
       }else{
           echo json_encode(array("error" => false));
       }
	   
	}
   
}
  
  
  
  
  
#################################################
#                                               #
#                CALL CODE                      #
#                                               #
################################################# 
  public function call()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Create Followup')<1){
        	    redirect('home');
        	    exit;
        }
		if(check_permission_status('Call','retrieve_u')==true){
		  $data['users_data'] = $this->Login_model->get_company_users();
		  $this->load->view('setting/call',$data);
		}else{
			redirect("permission");
		}
    }
    else
    {
      redirect('login');
    }
  }
  

public function ajax_list_call()
  {
	$delete_call	=0;
	$update_call	=0;
	$retrieve_call	=0; 
	if(check_permission_status('Call','delete_u')==true){
		$delete_call=1;
	}
	if(check_permission_status('Call','retrieve_u')==true){
		$retrieve_call=1;
	}
	if(check_permission_status('Call','update_u')==true){
		$update_call=1;
	}
	
    $list = $this->setting->get_datatables_call();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  //$row[] = $first_row;
    		  
      $first_row = "";
      $first_row.= ucfirst($post->call_subject).'<!--<div class="links">';
      if($update_call==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view('."'".$post->id."'".', '."'".$post->opportunity_id."'".')" class="text-success">View / Update</a>';
      endif;
      if($delete_call==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_call('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      
      $row[] = $first_row;
      $row[] = ucfirst($post->contact_name);
      $row[] = $post->call_purpose;
      $row[] = $post->related_to;
      $status= $post->status;
      if($status==1){
          $ptStatus='<span class="badge badge-light">Not Started</span>';
      }else if($status==2){
          $ptStatus='<span class="badge badge-pill badge-success">Compeleted</span>';
      }else if($status==3){
          $ptStatus='<span class="badge badge-pill badge-info">Progress</span>';
      }else if($status==0){
          $ptStatus='<span class="badge badge-pill badge-dark">Deactive</span>';
      }else if($status==4){
          $ptStatus='<span class="badge badge-pill badge-danger">Pending</span>';
          
      }
      $row[] = ucfirst($ptStatus);
	  
	  $action='<div class="row" style="font-size: 15px;">';
		if($update_call==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)"  onclick="view('."'".$post->id."'".', '."'".$post->opportunity_id."'".')" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Meeting Details" ></i></a>';
		}
		if($update_call==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)"  onclick="view('."'".$post->id."'".', '."'".$post->opportunity_id."'".')" class="text-primary border-right"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Meeting Details" ></i></a>';
		}	
		if($delete_call==1){	
			$action.='<a style="text-decoration:none" href="javascript:void(0)"  onclick="delete_call('."'".$post->id."'".')"   class="text-danger"><i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Meeting" ></i></a>';
		}
		$action.='</div>';
           
		$row[]=$action;
	  
	  
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->setting->count_all_call(),
      "recordsFiltered" => $this->setting->count_filtered_call(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  


 
  public function getbyid_call($id){
    $data = $this->setting->getbyid_call($id);
    echo json_encode($data);
  }
  
  public function delete_call($id){
	if(check_permission_status('Call','delete_u')==true){  
    $data = array('delete_status'=>'2');
    $dataRow= $this->setting->updateCall($data,$id);
	   if($dataRow){
		   echo json_encode(array("status" => TRUE));
	   }else{
		   echo json_encode(array("error" => false));
	   }
	}else{
		 //echo json_encode(array("error" => false));
	}
  }
  
  
 public function updateCall(){ 
  if(check_permission_status('Call','update_u')==true){  
	  $saveDataCall=$this->input->post('saveDataCall');
	  $saveDataCallid=$this->input->post('saveDataCallid');
	  
      if($saveDataCall=='1'){
       
        if($this->input->post('mtngParticepants')) { 
           $mtngParticepants= implode("<br>",$this->input->post('mtngParticepants'));
        }
    $dataArrMtng=array(
            'contact_name'     => $this->input->post('callContactName'),
            'call_subject'     => $this->input->post('callSubject'),
            'call_purpose'     => $this->input->post('callPurpose'),
            'owner'            => $this->input->post('mtngHost'),
            'from_date'        => $this->input->post('mtngFromDate'),
            'from_time'        => $this->input->post('mtngFromTime'),
            'to_date'          => $this->input->post('mtngToDate'),
            'to_time'          => $this->input->post('mtngToTime'),
            'related_to'       => $this->input->post('callRelated'),
            'call_type'        => $this->input->post('callType'),
            'call_detail'      => $this->input->post('callDeatils'),
            'contact_number'   => $this->input->post('contactNumber'),
            'call_description' => $this->input->post('callDescription'),
            'remarks'          => '',
            'status'           => $this->input->post('taskStatus'),
            'ip'               => $this->input->ip_address()
          );
          
        if($this->input->post('mtngParticepants')) { 
           $dataArrMtng['particepants'] = $mtngParticepants;
        }
  
       $dataRow=$this->setting->updateCall($dataArrMtng,$saveDataCallid);
       if($dataRow){
           echo json_encode(array("status" => TRUE));
       }else{
           echo json_encode(array("error" => false));
       }
	  } 
   }else{
	 echo json_encode(array("error" => false));  
   }
   
   
 }
 
  public function addCall(){
	if(check_permission_status('Call','create_u')==true){    
		$saveDataCall=$this->input->post('saveDataCall');
		$saveDataCallid=$this->input->post('saveDataCallid');
		if($this->input->post('mtngParticepants')) { 
			   $mtngParticepants= implode("<br>",$this->input->post('mtngParticepants'));
		}
  
    if($saveDataCall=='1'){
       $dataArrMtng=array(
            'sess_eml' 			=> $this->session->userdata('email'),
            'session_company' 	=> $this->session->userdata('company_name'),
            'session_comp_email'=> $this->session->userdata('company_email'),
            'contact_name'      => $this->input->post('callContactName'),
            'contact_number'    => $this->input->post('contactNumber'),
            'call_subject'     => $this->input->post('callSubject'),
            'call_purpose'     => $this->input->post('callPurpose'),
            'owner'            => $this->input->post('mtngHost'),
            'from_date'        => $this->input->post('mtngFromDate'),
            'from_time'        => $this->input->post('mtngFromTime'),
            'to_date'          => $this->input->post('mtngToDate'),
            'to_time'          => $this->input->post('mtngToTime'),
            'related_to'       => $this->input->post('callRelated'),
            'call_type'        => $this->input->post('callType'),
            'call_detail'      => $this->input->post('callDeatils'),
            'call_description' => $this->input->post('callDescription'),
            'remarks'          => '',
            'currentdate'      => date('Y-m-d'),
            'delete_status'    => 1,
            'status'           => 1,
            'ip'               => $this->input->ip_address()
          );
          
          if($this->input->post('mtngParticepants')) { 
           $dataArrMtng['particepants'] = $mtngParticepants;
        }
    }      
    $dataRow = $this->setting->addCall($dataArrMtng);
     
    if($dataRow){  
     $userEmail=$this->input->post('mtngParticepants');
    for($i=0; $i<count($userEmail); $i++){
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
                   .align-left{text-align:left}.align-center{text-align:center}.attributes_item{padding:20px;}
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
                                        <h1>Hi, '.$userEmail[$i].'!</h1>
                                        <p>I would like to invite you to a call. </p>
                                        
                                        <p>
                                        The call will take place on the '.$this->input->post('mtngFromDate').', starting at '.$this->input->post('mtngFromTime').' 
                                        and finishing at '.$this->input->post('mtngToDate').'  '.$this->input->post('mtngToTime').'. 
                                        Could you please confirm whether you will be able to participate?
                                        </p>
                                        <!-- Action -->
                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                          <tr>
                                            <td align="center">
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                  <td align="center">
                                                    <a href="'.base_url().'call" class="f-fallback button" target="_blank">Read More..</a>
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
                									  <strong>Call:</strong> '.$this->input->post('callContactName').'
                									</span>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									  <strong>Host By:</strong> '.$this->input->post('mtngHost').'
                									</span>
                                                  </td>
                                                </tr>
                                                
                                                <tr>
                                                  <td class="attributes_item">
                                                    <span class="f-fallback">
                									 '.$this->input->post('callDescription').'
                									</span>
                                                  </td>
                                                </tr>
                                               
                                              </table>
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
                $subject='Get ready for new call - '.$this->input->post('CallSubject');           
                $this->email_lib->send_email($userEmail[$i],$subject,$messageBody);
               // $this->email_lib->send_email('dev4@team365.io',$subject,$messageBody);
            }
          
           echo json_encode(array("status" => TRUE));
       
       }else{
           echo json_encode(array("error" => false));
       }
	}else{
		echo json_encode(array("error" => false));
	}
  }
  
  
  
/****************************************************/  
  
/*          SETTING MAIl FOR FOLLOW UP              */
 
/****************************************************/  


public function checkTaskforMail(){
    
$descriptionTxt=$this->input->post('descriptionTxt');
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
                        <p>Task information:</p>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    '.$descriptionTxt.'
                                  </td>
                                </tr>
                              </table>
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
    
$userEmail=$this->input->post('orgEmail');
$ccEmail=$this->input->post('ccEmail');
$subEmail=$this->input->post('subEmail');

if($this->email_lib->send_email($userEmail,$subEmail,$messageBody,$ccEmail)){
    echo 1;
}else{
    echo 0;
}


    
}



public function calendar(){
    $data['task'] = $this->setting->getAllTaskCal();
     $this->load->view('setting/calender',$data);
}

    #################################################
	#                                               #
	#                GST Code                       #
	#                                               #
	################################################# 
	
	
	
	public function add_gst()
	{
	    
    if(!empty($this->session->userdata('email')))
    {
		$data['user'] 		= $this->Login_model->getusername();
		$data['users_data'] = $this->Login_model->get_company_users();
		$data['admin'] 		= $this->Login_model->getadminname();
		if(checkModuleForContr('Tax')<1){
        	    redirect('home');
        	    exit;
        }
		if(check_permission_status('GST','retrieve_u')==true){ 
        $this->load->view('setting/add_gst');
		}
    }
    else
    {
      redirect('login');
    }
  }

  public function ajax_list_gst()
  {
    $list = $this->setting->get_datatables_gst();
    $data = array();
    $no = $_POST['start'];
	
	$delete_gst	=0;
	$update_gst	=0;
	$retrieve_gst=0; 
	if(check_permission_status('GST','delete_u')==true){
		$delete_gst=1;
	}
	if(check_permission_status('GST','retrieve_u')==true){
		$retrieve_gst=1;
	}
	if(check_permission_status('GST','update_u')==true){
		$update_gst=1;
	}
	
	
    foreach ($list as $post)
    {
      $no++;
      $row = array();
	  //$row[] = $first_row;
    		  
      $first_row = "";
      $first_row.= ucfirst($post->tax_name).'<!--<div class="links">';
      if($update_gst==1):
        $first_row.= '<a style="text-decoration:none" href="javascript:void(0)" onclick="updateTax('."'".$post->id."'".')" class="text-success"> Update</a>';
      endif;
      if($delete_gst==1):
        $first_row.= '|<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_gst('."'".$post->id."'".')" class="text-danger">Delete</a>';
      endif;
      $first_row.= '</div>-->';
      
      $row[] = $first_row;
      $row[] = $post->description;
      $row[] = $post->gst_percentage;
	  
      $row[] = $post->create_date;

	  $action='<div class="row" style="font-size: 15px;">';
		if($update_gst==1){
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="updateTax('."'".$post->id."'".')" class="text-primary border-right"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update Tax Details" ></i></a>';
		}	
		if($delete_gst==1){	
			$action.='<a style="text-decoration:none" href="javascript:void(0)" onclick="delete_gst('."'".$post->id."'".')" class="text-danger"><i class="far fa-trash-alt text-danger m-1"  data-toggle="tooltip" data-container="body" title="Delete Tax" ></i></a>';
		}
		$action.='</div>';
           
		$row[]=$action;
	  
	  
      
          $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->setting->count_all_gst(),
      "recordsFiltered" => $this->setting->count_filtered_gst(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
   
  public function getbyid_gst($id)
 {
    $data = $this->setting->getbyid_gst($id);
    echo json_encode($data);
  }
  
  public function delete_gst($id)
  {
	if(check_permission_status('GST','delete_u')==true){   
		$data = array('delete_status'=>'2');
		$dataRow= $this->setting->updategst($data,$id);
		if($dataRow){
			echo json_encode(array("status" => TRUE));
	    }else{
		   echo json_encode(array("error" => false));
	    }
	}else{
		 echo json_encode(array("error" => false));
	}
  }
  
 public function updategst()
 { 
  
  $addData=$this->input->post('saveDatagst');
  $saveDatamtngid=$this->input->post('saveDatagstid');
  
   if($addData=='1'){
   
    $dataArrMtng=array(
	'tax_name'           => $this->input->post('tax_name'),
	'description'        => $this->input->post('description'),
	'collection_of_sale' => $this->input->post('collection_of_sale'),
	'collection_of_purchases' => $this->input->post('collection_of_purchases'),
	'gst_percentage'         => $this->input->post('gst_percentage'),
	'ip'                     => $this->input->ip_address(),
	'update_date'            => date('Y-m-d')
          );
         
    $dataRow=$this->setting->updategst($dataArrMtng,$saveDatamtngid);
       if($dataRow){
           echo json_encode(array("status" => TRUE));
       }else{
           echo json_encode(array("status" => false));
       }
    }
  } 
 public function addgst()
 { 
  
  $addData=$this->input->post('saveDatagst');
   if($addData=='1'){
    $dataArrMtng=array(
	    'sess_eml' 			=> $this->session->userdata('email'),
	    'session_company' 	=> $this->session->userdata('company_name'),
	    'session_comp_email'=> $this->session->userdata('company_email'),
	    'tax_name'          => $this->input->post('tax_name'),
	    'description'       => $this->input->post('description'),
	    'collection_of_sale' => $this->input->post('collection_of_sale'),
	    'collection_of_purchases'=> $this->input->post('collection_of_purchases'),
	    'gst_percentage'    => $this->input->post('gst_percentage'),
	    'ip'                => $this->input->ip_address(),
        'create_date'       => date('Y-m-d')
          );
          
       $dataRow=$this->setting->addgst($dataArrMtng);
       if($dataRow){
           echo json_encode(array("status" => TRUE));
       }else{
           echo json_encode(array("status" => false));
       }
   } 
 } 
 
 
 /* START CODE PREFIX ID*/
 
public function set_prefix(){
	
    $this->load->model('Find_duplicate_modal','Find_duplicate');
	if(!empty($this->session->userdata('email')))
    { 
		if(check_permission_status('Set Prefix ID','retrieve_u')==true){ 	
			$list['table'] = $this->Find_duplicate->getTable();
			$this->load->view('setting/set-prefix',$list);
		}else{
			redirect("permission"); 
		}
    }
    else
    {
      redirect('login');
    }
}
 
public function savePrefix(){
	$tablename	= $this->input->post('tablename');
	$prefixid	= $this->input->post('prefixid');
	
	$dataRow=$this->setting->checkExistPrefix($tablename,$prefixid);
	if(count($dataRow)>0){
		$dataArrMtng=array(
			'module'            => $tablename,
			'prefix_id'         => $prefixid,
			);
    $dataRow=$this->setting->updateprefixData($dataArrMtng,$dataRow['id']);
	}else{
	$dataArrMtng=array(
	'sess_eml' 			=> $this->session->userdata('email'),
	'session_company' 	=> $this->session->userdata('company_name'),
	'session_comp_email'=> $this->session->userdata('company_email'),
	'module'            => $tablename,
	'prefix_id'         => $prefixid,
	'status'    		=> 1,
	'ip'                => $this->input->ip_address(),
    );
    $dataRow=$this->setting->saveprefixData($dataArrMtng);
	}
    if($dataRow){
           echo json_encode(array("status" => TRUE));
    }else{
           echo json_encode(array("status" => false));
    }
	//$list= $this->setting->saveprefixData();
}




/* START CODE STATE LIST */
 
public function state_list(){
	if(!empty($this->session->userdata('email'))){ 
		$this->load->view('setting/state-list');
    }else{
        redirect('login');
    }
}

public function ajax_list_state(){
    $list = $this->setting->get_datatables_state();
	
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row   = array();
      $row[] = $no;
      $row[] = ucfirst($post->name);
      $row[] = ucfirst('India');
      $row[] = ucfirst($post->tin);
      $data[]= $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->setting->count_all_state(),
      "recordsFiltered" => $this->setting->count_filtered_state(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
	/*END CODE STATE LIST*/
 
 
 

}
?>
