<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_lead extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Integration_model');
    $this->load->library(array('upload','email_lib'));
	$this->load->database();
  }
  
  /**
  * Retrieve the latest lead's assigned user information for a company session.
  * @example
  * $result = $this->assignedUser('billing@acme.com', 'Acme Corp', 123, 456);
  * print_r($result); // Array ( [assigned_to] => 123 [id] => 456 [assigned_to_name] => John Doe )
  * @param {string} $session_comp_email - Company session email used to filter leads.
  * @param {string} $session_company - Company identifier used to filter leads.
  * @param {int|string} $userAssign - (optional) Assigned user ID or identifier to filter by a specific user.
  * @param {int|string} $leadid - (optional) Lead ID to filter by a specific lead.
  * @returns {array|null} Associative array with keys 'assigned_to', 'id', and 'assigned_to_name' for the matched lead, or null if none found.
  */
  public function assignedUser($session_comp_email,$session_company,$userAssign='',$leadid='')
    {   
		$this->db->from('lead');
		$this->db->select('assigned_to, id, assigned_to_name');
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->where('session_company',$session_company);
		if($userAssign!=""){
			$this->db->where('assigned_to',$userAssign);
		}
		if($leadid!=""){
			$this->db->where('id',$leadid);
		}
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
    }

    public function getusername($session_comp_email,$session_company)
    {   
		$this->db->from('standard_users');
		$this->db->select('standard_name, id, standard_email');
		$this->db->where('company_email',$session_comp_email);
		$this->db->where('company_name',$session_company);
		$this->db->where('delete_status',1);
		$query = $this->db->get();
		return $query->row_array();
    }
  
 /**
 * Process cron integrations for IndiaMART and TradeIndia: fetch leads from remote APIs, normalize lead data,
 * attempt to assign owners, post leads to the Team365 leads API, and send a debug email for TradeIndia responses.
 * @example
 * // Run from a controller or CLI in CodeIgniter
 * $cron = new Cron_lead();
 * $cron->index();
 * // No return value; leads are forwarded to https://api.team365.io/api/leads/add and a debug email is sent for TradeIndia.
 * @param void $none - This method accepts no parameters.
 * @returns void No return value; side effects include HTTP requests to external services and sending email.
 */
	public function index()
	{
	    
	    $indiamart = $this->Integration_model->get_googleads_cron('indiamart');
	    for($k=0; $k<count($indiamart); $k++){
	        if(isset($indiamart[$k]['id']) && $indiamart[$k]['id']!=""){
	            
	            $Start_Time=date('d-M-Y', strtotime("-1 days"));
	            $End_Time=date('d-M-Y');
	            
    	    $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, $indiamart[$k]['api_url'].'/Start_Time/'.$Start_Time.'/End_Time/'.$End_Time.'/');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
    		$buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            $result = json_decode($buffer);
            if(count($result)){
    		for($i=0; $i<count($result); $i++){
    				$LEAD_ID    = $result[$i]->QUERY_ID;
    				$contactName= $result[$i]->SENDERNAME;
    				$email      = $result[$i]->SENDEREMAIL;
    				$leadName   = $result[$i]->SUBJECT;
    				$lead_Date  = $result[$i]->DATE_RE;
    				$mobile     = $result[$i]->MOB;
    				$address    = $result[$i]->ENQ_ADDRESS;
    				$city       = $result[$i]->ENQ_CITY;
    				$state      = $result[$i]->ENQ_STATE;
    				$product    = $result[$i]->PRODUCT_NAME;
    				$sec_email  = $result[$i]->EMAIL_ALT;
    				$sec_mobile = $result[$i]->MOBILE_ALT;
    				$org_name   = $result[$i]->GLUSR_USR_COMPANYNAME;
    	    $data = array(
                'sess_eml' 			=> $indiamart[$k]['sess_eml'],
                'session_company' 	=> $indiamart[$k]['session_company'],
                'session_comp_email'=> $indiamart[$k]['session_comp_email'],
                'name' 				=> $leadName,
                'email' 			=> $email,
                'office_phone' 		=> $sec_mobile,
                'mobile' 			=> $mobile,
                'lead_source' 		=> 'India Mart',
                'lead_status' 		=> 'Attempted To Contact',
                'contact_name' 		=> $contactName,
                'currentdate' 		=> $lead_Date,
                'track_status' 		=> 'lead',
                'org_name'          => $org_name,
                'product_name'      => $product,
                'secondary_email'   => $sec_email,
                'billing_address'   => $address,
                'billing_state'     => $state,
                'billing_city'      => $city
              );
			  
			$assignedto = getusername($infoAdmn['session_comp_email'],$infoAdmn['session_company']);
			$idArr 	= array();
			for($k=0; $k<count($assignedto); $k++){
				$assignUser=assignedUser($infoAdmn['session_comp_email'],$infoAdmn['session_company'],$assignedto[$k]['standard_email']);
				if(isset($assignUser) && count($assignUser)>0){
					$idArr[]= $assignUser['id'];
				}else{
					$data['assigned_to']=$assignedto[$k]['standard_email'];
					$data['assigned_to_name']=$assignedto[$k]['standard_name'];
				}		
			}
			$idUSerAssi=min($idArr);
			$assignUserLast=assignedUser($infoAdmn['session_comp_email'],$infoAdmn['session_company'],'',$idUSerAssi);
			if(!isset($data['assigned_to'])  || $data['assigned_to']==""){
				$data['assigned_to']	 = $assignUserLast['assigned_to'];
				$data['assigned_to_name']= $assignUserLast['assigned_to_name'];
			}
		     
			  
              $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_URL, 'https://api.team365.io/api/leads/add');
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle); 
    		}
            }
	    }
	    }
	    
	   
	    $tradeindia= $this->Integration_model->get_googleads_cron('tradeindia');
	    for($k=0; $k<count($tradeindia); $k++){
	         $curl_handle = curl_init();
	         
	         $Start_Time=date('Y-m-d', strtotime("-1 days"));
	         $End_Time=date('Y-m-d');
	         
            curl_setopt($curl_handle, CURLOPT_URL, $tradeindia[$k]['api_url'].'&from_date='.$Start_Time.'&to_date='.$End_Time);
            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
    		$buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            $result = json_decode($buffer);
	        $messageBody=$buffer;
	        $this->email_lib->send_email('dev2@team365.io', 'test subject for trade india leas', $messageBody);
	    }
	    
		
	}
	
}
?>