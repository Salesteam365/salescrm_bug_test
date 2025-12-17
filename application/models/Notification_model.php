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
	
 /**
 * Add a notification record for a given entity (opportunity, quotation, salesorders, purchaseorders).
 * @example
 * $result = $this->Notification_model->addNotification('opportunity', 123);
 * echo $result // 45
 * @param {string} $notFor - Notification target type. One of: 'opportunity', 'quotation', 'salesorders', 'purchaseorders'.
 * @param {int} $id - ID of the related record for which the notification is created.
 * @returns {int} Inserted notification ID on success, or 202 on failure.
 */
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
	
 /**
  * Build the CodeIgniter query used to fetch unseen notifications for the current session/company.
  * @example
  * $ci =& get_instance();
  * $ci->load->model('Notification_model');
  * // ensure session contains 'email', 'company_email', 'company_name' and optionally 'type' => 'standard'
  * $ci->session->set_userdata(['email' => 'john@acme.com', 'company_email' => 'info@acme.com', 'company_name' => 'Acme Ltd', 'type' => 'standard']);
  * $ci->Notification_model->_get_datatables_query();
  * // execute the query built by the method
  * $query = $ci->db->get(); 
  * $result = $query->result();
  * print_r($result); // sample output: Array ( [0] => stdClass Object ( [id] => 12 [message] => 'New alert' [seen_status] => 0 ... ) )
  * @param void $none - No parameters are accepted.
  * @returns void No return value; the method configures the active CI query builder (select/from/where/order_by) for later execution.
  */
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
	
	
 /**
 * Retrieve up to 10 unseen, unpushed notifications for a given company and company email from the last day.
 * @example
 * $result = $this->Notification_model->push_notification('AcmeCorp', 'notify@acme.com');
 * print_r($result); // Sample output: Array ( [0] => Array ( 'id' => 123, 'session_company' => 'AcmeCorp', 'session_comp_email' => 'notify@acme.com', 'message' => 'New order received', 'created_date' => '2025-12-16', 'seen_status' => 0, 'push_noti_status' => 0 ) )
 * @param {string|int} $session_company - Company identifier (ID or name) used to filter notifications.
 * @param {string} $session_comp_email - Company email used to filter notifications.
 * @returns {array} Return array of associative notification records (up to 10) matching criteria.
 */
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
	
	
 /**
 * Retrieve a single row from a given table filtered by current session (company/email) and id.
 * @example
 * $result = $this->Notification_model->getTableData('notifications', 'id, title, message', 42);
 * print_r($result); // Sample output: Array ( [id] => 42 [title] => "Server Alert" [message] => "High CPU usage" )
 * @param {string} $tableName - Name of the database table to query.
 * @param {string|array} $fields - Fields to select (comma-separated string or array of column names).
 * @param {int|string} $id - Primary key value (id) of the record to retrieve.
 * @returns {array|null} Return associative array of the matched row or null if not found.
 */
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
	
 /**
 * Mark a specific notification as seen (sets seen_status = 1) for the current session's company and recipient; for "standard" users the session email is also enforced.
 * @example
 * $result = $this->Notification_model->update(123, 'employee');
 * echo $result // render true if update succeeded, false otherwise;
 * @param {{int}} {{id}} - Notification ID to update.
 * @param {{string}} {{notFor}} - Recipient category for the notification (e.g. 'employee', 'admin', 'client').
 * @returns {{bool}} True on successful update, false on failure.
 */
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
	
 /**
 * Mark a notification as seen by setting seen_status = 1 for a specific module column and ID.
 * @example
 * $result = $this->Notification_model->update_noti('order_id', 123, 'sales');
 * var_dump($result); // bool(true) on success or bool(false) on failure
 * @param string $moduleClm - Database column name identifying the module (e.g. 'order_id').
 * @param int|string $mid - Value of the module column to match (e.g. 123).
 * @param string $notFor - Notification target/type to match the noti_for column (e.g. 'sales', 'admin').
 * @returns bool Returns true if the notification row was successfully updated, false otherwise.
 */
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