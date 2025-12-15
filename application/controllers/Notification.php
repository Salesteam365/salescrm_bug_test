<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
    $this->load->model('Notification_model');
  }
  
  
	public function send_notification(){
		
		$messageTeam365='';
		$messageTeam365.='<div class="f-fallback">
							<center> <h2>A new Feedback found</h2> </center>
							<h3>Dear Mr,/Mrs. Team365 Owner,</h3>';
				$messageTeam365.='<p>There are a feedback about your crm </p>
				<p>Name : '.ucwords($this->session->userdata('name')).' </p>
				<p>Email : '.$this->session->userdata('email').'</p>
				<p>Customer name : '.$this->session->userdata('company_name').'</p>
				<p>Feedback Message : </p>';
				
				$messageTeam365.='<p>'.$this->input->post('feedbackMessage').'</p>';
				$messageTeam365.='</div>';
				$subEmail='A new feedback from '.$this->session->userdata('name');			
				sendMailWithTemp('sales@team365.io',$messageTeam365,$subEmail);	
	
	  echo "ok";
	}
  

  public function getNoti()
  {
	
		$quotdata 		= $this->Notification_model->oppnoti();
		$oppRow 		= $this->Notification_model->count_opp_noti();
				$arrayData=array();
				$jsnData=array();
				foreach($quotdata as $row){
					if(isset($row['noti_for']) && $row['noti_for']=='opportunity'){
						$urlName=base_url()."opportunities?oppid=".$row['opp_id']."&itm=opportunity&ntid=".$row['id'];
						$dtRow = $this->Notification_model->getTableData('opportunity','owner,name as subject ',$row['opp_id']);
					}else if(isset($row['noti_for']) && $row['noti_for']=='quotation'){
						$urlName=base_url().'quotation/view_pi_qt/'.$row['quote_id'].'?itm=quotation&ntid='.$row["id"].'&qr=get-data';
						$dtRow = $this->Notification_model->getTableData('quote','owner,subject',$row['quote_id']);
					}else if(isset($row['noti_for']) && $row['noti_for']=='salesorders'){
						$urlName=base_url().'salesorders/view_pi_so/'.$row['so_id'].'?itm=salesorders&ntid='.$row["id"].'&qr=get-data';
						$dtRow = $this->Notification_model->getTableData('salesorder','owner,subject',$row['so_id']);
					}else if(isset($row['noti_for']) && $row['noti_for']=='purchaseorders'){
						$urlName=base_url().'purchaseorders/view_pi_po/'.$row['po_id'].'?itm=purchaseorders&ntid='.$row["id"].'&qr=get-data';
						$dtRow = $this->Notification_model->getTableData('purchaseorder','owner,subject',$row['po_id']);
					}
					
					$arrayData['id'] 		= $row['id'];
					$arrayData['url'] 		= $urlName;
					$arrayData['subject'] 	= substr($dtRow['subject'],0,35);
					$arrayData['owner'] 	= ucwords($dtRow['owner']);
					$arrayData['created_date'] 	= time_elapsed_string($row['created_date']);
					$jsnData[]=$arrayData;
				}
				
				echo json_encode(array('notidata'=>$jsnData,'noticount'=>$oppRow));
		
	}
	
	
	public function update_notification(){
		$noti_id 	= $this->input->post('noti_id');
		$notifor 	= $this->input->post('notifor');
		$podata 	= $this->Notification_model->update($noti_id,$notifor);
		//echo $podata;
	}
	
	
	public function get_push_notification(){
		$company_name 	= $this->input->post('company_name');
		$company_email 	= $this->input->post('company_email');
		$pushNoti = $this->Notification_model->push_notification($company_name,$company_email);
		$array=array(); 
		$rows =array(); 
		$record = 0;
		foreach ($pushNoti as $key) {
			
			if(isset($key['noti_for']) && $key['noti_for']=='opportunity'){
				$urlName=base_url()."opportunities?oppid=".$key['opp_id']."&itm=opportunity&ntid=".$key['id'];
				$dtRow = $this->Notification_model->getTableData('opportunity','owner,name as subject ',$key['opp_id']);
				$title = 'A new opportunity created';
			}else if(isset($key['noti_for']) && $key['noti_for']=='quotation'){
				$urlName=base_url().'quotation/view_pi_qt/'.$key['quote_id'].'?itm=quotation&ntid='.$key["id"].'&qr=get-data';
				$dtRow = $this->Notification_model->getTableData('quote','owner,subject',$key['quote_id']);
				$title = 'A new quotation created';
			}else if(isset($key['noti_for']) && $key['noti_for']=='salesorders'){
				$urlName=base_url().'salesorders/view_pi_so/'.$key['so_id'].'?itm=salesorders&ntid='.$key["id"].'&qr=get-data';
				$title = 'A new sales order created';
				$dtRow = $this->Notification_model->getTableData('salesorder','owner,subject',$key['so_id']);
			}else if(isset($key['noti_for']) && $key['noti_for']=='purchaseorders'){
				$urlName=base_url().'purchaseorders/view_pi_po/'.$key['po_id'].'?itm=purchaseorders&ntid='.$key["id"].'&qr=get-data';
				$title = 'A new purchase order created';
				$dtRow = $this->Notification_model->getTableData('purchaseorder','owner,subject',$key['po_id']);
			}
			
		 $data['title'] = $title;
		 $data['msg'] 	= substr($dtRow['subject'],0,35).", By ".ucwords($dtRow['owner']).", ".time_elapsed_string($key['created_date']);
		 $data['icon'] 	= 'https://img.icons8.com/color/48/000000/sms-token.png';
		 $data['url'] 	= $urlName;
		 $rows[] 	= $data;
		 $this->Notification_model->updateNotification($key['id']);
		 $record++;
		}
		$array['notif'] = $rows;
		$array['count'] = $record;
		$array['result'] = true;
		echo json_encode($array);
	}
	
	
	//notification for customer activities
	
	public function get_metting_notification(){
		$company_name 	= $this->input->post('company_name');
		$company_email 	= $this->input->post('company_email');
		$userEmail 	    = $this->input->post('userEmail');
		
		$pushNoti = $this->Notification_model->getMeetingForMail($company_name,$company_email,$userEmail);
		$array=array(); 
		$rows =array(); 
		$record = 0;
		foreach($pushNoti as $noti){
			if($noti['reminder']!=""){
				
				if($noti['reminder']>5){
					$addTime=$noti['reminder']*60;
				}else if($noti['reminder']>'At time of event'){
					$addTime=0;
				}else{
					$addTime=$noti['reminder']*60*60;
				}
				$addedTime = date("H:i",time() + $addTime);
				$diff_time=(strtotime($addedTime)-strtotime($noti['from_time']))/60;
				if($diff_time==0){
					$diffTime=(strtotime(date("H:i"))-strtotime($noti['from_time']))/60;
					$userParti=explode("<br>",$noti['particepants']);
					if (in_array($userEmail, $userParti))
					{
						 $data['title'] = 'Your meeting is about to start , '.$noti['meeting_title'];
						 $data['msg'] 	= "Location : ".$noti['location']." , By ".ucwords($noti['host_name']).", ".$diffTime."Minutes left.";
						 $data['icon'] 	= '<img src="https://img.icons8.com/nolan/48/overtime.png"/>';
						 $data['url'] 	= '';
						 $rows[] 	= $data;
						 $this->Notification_model->updateFolloup('meeting',$noti['id']);
						 $record++;
					}
				}
			}
		}
		
		$pushNotiCall = $this->Notification_model->getCallForMail($company_name,$company_email,$userEmail);
		foreach($pushNotiCall as $noti){
			if($noti['reminder']!=""){
				if($noti['reminder']>5){
					$addTime=$noti['reminder']*60;
				}else if($noti['reminder']>'At time of event'){
					$addTime=0;
				}else{
					$addTime=$noti['reminder']*60*60;
				}
				$addedTime = date("H:i",time() + $addTime);
				$diff_time=(strtotime($addedTime)-strtotime($noti['from_time']))/60;
				if($diff_time==0){
					$diffTime=(strtotime(date("H:i"))-strtotime($noti['from_time']))/60;
					
					$userParti=explode("<br>",$noti['particepants']);
					if (in_array($userEmail, $userParti))
					{
						 $data['title'] = 'Your call is about to start , '.$noti['call_subject'];
						 $data['msg'] 	= "Call for ".$noti['call_purpose']." and related to  ".$noti['related_to'].", By ".ucwords($noti['host_name']).", ".$diffTime." Minutes left.";
						 $data['icon'] 	= '<img src="https://img.icons8.com/nolan/48/overtime.png"/>';
						 $data['url'] 	= '';
						 $rows[] 	= $data;
						 $this->Notification_model->updateFolloup('create_call',$noti['id']);
						 $record++;
					}
				}	
			}
		}
		$array['notif'] = $rows;
		$array['count'] = $record;
		$array['result'] = true;
		echo json_encode($array);
		
		
	}
	
	
	
	
  
	
// End Class.......	
}
?>