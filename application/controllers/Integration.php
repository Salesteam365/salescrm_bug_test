<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Integration extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Integration_model');
	$this->load->model('mail_model');
  }
  
    public function index()
    {
        if(checkModuleForContr('Integrations')<1){
	     redirect('home');
	    }
		
		if(check_permission_status('Integration','retrieve_u')==true){ 
			$data['googleads']	= $this->Integration_model->get_googleads('google ads');
			$data['tradeindia']	= $this->Integration_model->get_googleads('tradeindia');
			$data['indiamart']	= $this->Integration_model->get_googleads('indiamart');
			$data['apijd']		= $this->Integration_model->get_googleads('just dial');
			$data['sulekha']	= $this->Integration_model->get_googleads('sulekha');
			$data['housing']	= $this->Integration_model->get_googleads('housing');
			$data['magicbricks']= $this->Integration_model->get_googleads('magicbricks');
			$data['acres']		= $this->Integration_model->get_googleads('99acres');
			$data['all_email'] 	= $this->mail_model->get_allemail();
			$this->load->view('setting/integration',$data);
		}else{
			redirect('permission');
		}
	}
	
	public function facebook_integration(){
	    if(checkModuleForContr('Integrations')<1){
	        redirect('home');
	    }
	    $this->load->view('setting/facebook-integration');
	}
	
	
	public function add_api(){
		$sess_eml 			= $this->session->userdata('email');
		$session_company 	= $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$id 				= $this->session->userdata('id');
		$apiName=$this->input->post('api_name');
		$action=$this->input->post('action');
		$googleads=$this->Integration_model->get_googleads('google ads');
		if($action=='add' && empty($googleads['id'])){
			$ip = $this->input->ip_address();
			$api_key=md5($id.time());
			$data = array(
				'sess_eml' 			=> $sess_eml,
				'session_company' 	=> $session_company,
				'session_comp_email'=> $session_comp_email,
				'api_name' 			=> $apiName,
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/googlelead?key='.$api_key,
				'delete_status' 	=> 1,
				'status' 			=> 1,
				'ip' 				=> $ip,
				'currentdate' 		=> date('Y-m-d H:i:s')
			);
			$aid=$this->Integration_model->create($data);
		}else{
			$api_key=md5($id.time());
			$data = array(
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/googlelead?key='.$api_key,
			);
			
			$upid=$this->input->post('upid');
			if(empty($upid)){
				$upid=$googleads['id'];
			}
			$aid=$this->Integration_model->update_key($data,$upid);
		}
		
		if($aid){
			echo 'https://api.team365.io/googlelead?key='.$api_key;
		}else{
			echo "<span><i class='fas fa-exclamation-triangle' style='color:red;'></i> &nbsp;&nbsp;Something went wrong, Please try later.</span>";
		}
	}
	
	
	public function add_api_jd(){
		$sess_eml 			= $this->session->userdata('email');
		$session_company 	= $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$id 				= $this->session->userdata('id');
		$apiName=$this->input->post('api_name');
		$action=$this->input->post('action');
		$googleads=$this->Integration_model->get_googleads('just dial');
		if($action=='add' && empty($googleads['id'])){
			$ip = $this->input->ip_address();
			$api_key=md5($id.time());
			$data = array(
				'sess_eml' 			=> $sess_eml,
				'session_company' 	=> $session_company,
				'session_comp_email'=> $session_comp_email,
				'api_name' 			=> $apiName,
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/justdiallead?key='.$api_key,
				'delete_status' 	=> 1,
				'status' 			=> 1,
				'ip' 				=> $ip,
				'currentdate' 		=> date('Y-m-d H:i:s')
			);
			$aid=$this->Integration_model->create($data);
		}else{
			$api_key=md5($id.time());
			$data = array(
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/justdiallead?key='.$api_key,
			);
			
			$upid=$this->input->post('upid');
			if(empty($upid)){
				$upid=$googleads['id'];
			}
			$aid=$this->Integration_model->update_key($data,$upid);
		}
		
		if($aid){
			echo 'https://api.team365.io/justdiallead?key='.$api_key;
		}else{
			echo "<span><i class='fas fa-exclamation-triangle' style='color:red;'></i> &nbsp;&nbsp;Something went wrong, Please try later.</span>";
		}
	}
	
	
	public function add_api_common(){
		$sess_eml 			= $this->session->userdata('email');
		$session_company 	= $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$id 				= $this->session->userdata('id');
		$apiName=$this->input->post('api_name');
		$action=$this->input->post('action');
		$googleads=$this->Integration_model->get_googleads($apiName);
		if($action=='add' && empty($googleads['id'])){
			$ip = $this->input->ip_address();
			$api_key=md5($id.time());
			$data = array(
				'sess_eml' 			=> $sess_eml,
				'session_company' 	=> $session_company,
				'session_comp_email'=> $session_comp_email,
				'api_name' 			=> $apiName,
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/leadapi?key='.$api_key,
				'delete_status' 	=> 1,
				'status' 			=> 1,
				'ip' 				=> $ip,
				'currentdate' 		=> date('Y-m-d H:i:s')
			);
			$aid=$this->Integration_model->create($data);
		}else{
			$api_key=md5($id.time());
			$data = array(
				'api_key' 			=> $api_key,
				'api_url' 			=> 'https://api.team365.io/leadapi?key='.$api_key,
			);
			
			$upid=$this->input->post('upid');
			if(empty($upid)){
				$upid=$googleads['id'];
			}
			$aid=$this->Integration_model->update_key($data,$upid);
		}
		
		if($aid){
			echo 'https://api.team365.io/leadapi?key='.$api_key;
		}else{
			echo "<span><i class='fas fa-exclamation-triangle' style='color:red;'></i> &nbsp;&nbsp;Something went wrong, Please try later.</span>";
		}
	}
	
	
	
	public function add_data_trade(){
		$sess_eml 			= $this->session->userdata('email');
		$session_company 	= $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$id 				= $this->session->userdata('id');
		
		$apiName	= $this->input->post('api_name');
		$action		= $this->input->post('action');
		$tuserid	= $this->input->post('tuserid');
		$tprofileid	= $this->input->post('tprofileid');
		$tkey		= $this->input->post('tkey');
		$tradeleads	= $this->Integration_model->get_googleads($apiName);
		
		if(!empty($tuserid) && !empty($tprofileid) && !empty($tkey)){
		if($action=='add' && empty($tradeleads['id'])){
			$ip = $this->input->ip_address();
			
			$data = array(
				'sess_eml' 			=> $sess_eml,
				'session_company' 	=> $session_company,
				'session_comp_email'=> $session_comp_email,
				'api_name' 			=> $apiName,
				'api_key' 			=> $tkey,
				'site_userid' 		=> $tuserid,
				'site_profileid' 	=> $tprofileid,
				'api_url' 			=> 'https://www.tradeindia.com/utils/my_inquiry.html?userid='.$tuserid.'&profile_id='.$tprofileid.'&key='.$tkey,
				'delete_status' 	=> 1,
				'status' 			=> 1,
				'ip' 				=> $ip,
				'currentdate' 		=> date('Y-m-d H:i:s')
			);
			$aid=$this->Integration_model->create($data);
		}else{
			$data = array(
				'api_key' 			=> $tkey,
				'site_userid' 		=> $tuserid,
				'site_profileid' 	=> $tprofileid,
				'api_url' 			=> 'https://www.tradeindia.com/utils/my_inquiry.html?userid='.$tuserid.'&profile_id='.$tprofileid.'&key='.$tkey,
				'updated_date'		=> date('Y-m-d H:i:s')
			);
			
			$upid=$this->input->post('upid');
			if(empty($upid)){
				$upid=$tradeleads['id'];
			}
			$aid=$this->Integration_model->update_key($data,$upid);
		}
		
		if($aid){
			echo "1";
		}else{
			echo "0";
		}
		}else{
			echo "3";
		}
	}
	
	
	public function add_data_mart(){
		$sess_eml 			= $this->session->userdata('email');
		$session_company 	= $this->session->userdata('company_name');
		$session_comp_email = $this->session->userdata('company_email');
		$id 				= $this->session->userdata('id');
		
		$apiName	= $this->input->post('api_name');
		$action		= $this->input->post('action');
		$mart_mobile= $this->input->post('mart_mobile');
		$mart_key	= $this->input->post('mart_key');
		$martleads	= $this->Integration_model->get_googleads($apiName);
		
		if(!empty($mart_mobile) && !empty($mart_key)){
		if($action=='add' && empty($martleads['id'])){
			$ip = $this->input->ip_address();
			$data = array(
				'sess_eml' 			=> $sess_eml,
				'session_company' 	=> $session_company,
				'session_comp_email'=> $session_comp_email,
				'api_name' 			=> $apiName,
				'api_key' 			=> $mart_key,
				'site_mobile' 		=> $mart_mobile,
				'api_url' 			=> 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/'.$mart_mobile.'/GLUSR_MOBILE_KEY/'.$mart_key,
				'delete_status' 	=> 1,
				'status' 			=> 1,
				'ip' 				=> $ip,
				'currentdate' 		=> date('Y-m-d H:i:s')
			);
			$aid=$this->Integration_model->create($data);
		}else{
			$data = array(
				'api_key' 			=> $mart_key,
				'site_mobile' 		=> $mart_mobile,
				'api_url' 			=> 'https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/'.$mart_mobile.'/GLUSR_MOBILE_KEY/'.$mart_key,
				'updated_date'		=> date('Y-m-d H:i:s')
			);
			
			$upid=$this->input->post('upid');
			if(empty($upid)){
				$upid=$martleads['id'];
			}
			$aid=$this->Integration_model->update_key($data,$upid);
		}
		
		if($aid){
			echo "1";
		}else{
			echo "0";
		}
		}else{
			echo "3";
		}
	}
	
	
	
	
	public function my_operator(){
	
                $username = 'admin';
                $password = '1234';
                 
                // Alternative JSON version
                // $url = 'http://twitter.com/statuses/update.json';
                // Set up and execute the curl process
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'https://developers.myoperator.co/user');
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                    'token' => '3db54ae2405076bfc0784021b9c07500',
                    'name' => 'Vikash',
                    'contact_number' => '7865898560',
                    'country_code' => '+91',
                    'extension' => '14',
                    'email' => 'test@gmial.com'
                ));
                 
                // Optional, delete this line if your API is open
               // curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);
                 
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                 
                $result = json_decode($buffer);
                
                print_r($result);
             
                if(isset($result->status) && $result->status == 'success')
                {
                    echo 'User has been updated.';
                }
                 
                else
                {
                    echo 'Something has gone wrong';
                }
            
	}
	
  
  

	
}
?>