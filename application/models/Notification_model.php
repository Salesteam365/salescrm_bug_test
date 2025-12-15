<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Notification_model extends CI_Model
{

     public function __construct(){
         parent::__construct();
     }
	


	#############################
	#							#
	#	Add Notification 		#
	#							#
	#############################
	
	public function addNotification($notFor,$id){
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		$session_id 		= $this->session->userdata('id');
		$userType			= $this->session->userdata('type');
		if($userType=="standard"){
			$usertp="standard";
		}else{
			$usertp="admin";
		}
		
		$dataArr=array(
			'sess_eml' 				=> $sess_eml,
			'session_company' 		=> $session_company,
			'session_comp_email'	=> $session_comp_email,
			'seen_status'			=> 0,
			'user_type' 			=> $usertp,
			'status'				=> 0,
			'created_date'			=> date('Y-m-d H:i:s')
		);
		
		if($userType=="admin"){
			$dataArr['comp_id']=$session_id;
		}else{
			$dataArr['user_id']=$session_id;
		}
		
		if($notFor=='opportunity'){
			$dataArr['opp_id']=$id;
			$dataArr['noti_for']='opportunity';
		}
		if($notFor=='quotation'){
			$dataArr['quote_id']=$id;
			$dataArr['noti_for']='quotation';
		}
		if($notFor=='salesorders'){
			$dataArr['so_id']=$id;
			$dataArr['noti_for']='salesorders';
		}
		if($notFor=='purchaseorders'){
			$dataArr['po_id']=$id;
			$dataArr['noti_for']='purchaseorders';
		}
		
		
		if($this->db->insert('notification', $dataArr))
        {
          return $this->db->insert_id();
        }
        else
        {
          return 202;
        }
	}
	
	
	#############################
	#							#
	#	  Get Notification 		#
	#							#
	#############################
	
	
	public function oppnoti()
	{
		$this->_get_datatables_query();
		$this->db->limit(50);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function count_opp_noti()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	private function _get_datatables_query()
	{
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		
		$this->db->from('notification');
		$this->db->select('*');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('sess_eml',$sess_eml);
		}
		$notiId = $this->input->post('notiId');
		if(isset($notiId) && $notiId!=""){
			$this->db->where('id>',$notiId);
		}			
		
		$this->db->order_by('id','desc');
		$this->db->where('notification.seen_status',0);
	}
	
	
	public function push_notification($session_company,$session_comp_email)
	{
		
		$this->db->from('notification');
		$this->db->select('*');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		$this->db->order_by('id','desc');
		$this->db->where('seen_status',0);
		$this->db->where('push_noti_status',0);
		$day_before = date( 'Y-m-d', strtotime( date('Y-m-d') . ' -1 day' ) );
		$this->db->where('created_date >=',$day_before);
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	public function getTableData($tableName,$fields,$id){
		$sess_eml = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
		$this->db->from($tableName);
		$this->db->select($fields);
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('sess_eml',$sess_eml);
		}
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function update($id,$notFor){
		
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		
		$dataArr=array('seen_status'=> 1);
		
		$this->db->where('id', $id);
		$this->db->where('noti_for', $notFor);
		$this->db->where('notification.session_comp_email',$session_comp_email);
		$this->db->where('notification.session_company',$session_company);
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('notification.sess_eml',$sess_eml);
		}
		if($this->db->update('notification', $dataArr))
        {
          return true;
        }
        else
        {
          return false;
        }
	}
	
	public function updateNotification($keyid){
		$dataArr=array('push_noti_status'=> 1);
		$this->db->where('id', $keyid);
		if($this->db->update('notification', $dataArr))
        {
          return true;
        }else
        {
          return false;
        }
	}
	
	public function updateFolloup($tableName,$notiid){
		$dataArr=array('reminder_status'=> 0);
		$this->db->where('id', $notiid);
		if($this->db->update($tableName, $dataArr))
        {
          return true;
        }else
        {
          return false;
        }
	}
	
	public function update_noti($moduleClm,$mid,$notFor){
		
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		$dataArr=array('seen_status'=> 1);
		
		$this->db->where($moduleClm, $mid);
		$this->db->where('noti_for', $notFor);
		$this->db->where('notification.session_comp_email',$session_comp_email);
		$this->db->where('notification.session_company',$session_company);
		if($this->session->userdata('type')==='standard')
		{
		 $this->db->where('notification.sess_eml',$sess_eml);
		}
		if($this->db->update('notification', $dataArr))
        {
          return true;
        }
        else
        {
          return false;
        }
	}
	
	
	public function getMeetingForMail($company_name,$company_email,$userEmail)
    { 
		$this->db->from('meeting');
		$this->db->where('from_date',date('Y-m-d'));
		$this->db->where('session_company',$company_name);
		$this->db->where('session_comp_email',$company_email);
		$this->db->where('reminder<>',"");
		$this->db->where('reminder_status',1);
		$query = $this->db->get();
		return $query->result_array();
    }
	public function getCallForMail($company_name,$company_email,$userEmail)
    { 
		$this->db->from('create_call');
		$this->db->where('from_date',date('Y-m-d'));
		$this->db->where('session_company',$company_name);
		$this->db->where('session_comp_email',$company_email);
		$this->db->where('reminder<>',"");
		$this->db->where('reminder_status',1);
		$query = $this->db->get();
		return $query->result_array();
    }
	
	
	
	
	
	
	
	

}