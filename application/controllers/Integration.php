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
  
    /**
    * Load the Integration settings page: verifies the Integrations module and user permissions, fetches integration configurations (google ads, tradeindia, indiamart, just dial, sulekha, housing, magicbricks, 99acres) and all email addresses, then loads the 'setting/integration' view or redirects if unauthorized.
    * @example
    * // From a controller context:
    * $this->Integration->index();
    * // Result: renders 'setting/integration' view with $data, example values:
    * // $data['googleads']   = ['id' => 1, 'name' => 'google ads', 'status' => 'active'];
    * // $data['tradeindia']  = ['id' => 2, 'name' => 'tradeindia', 'status' => 'inactive'];
    * // $data['all_email']   = ['info@example.com', 'support@example.com'];
    * @param void $none - No parameters are required for this controller action.
    * @returns void Loads a view or redirects; no return value.
    */
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
	
	
 /**
  * Create or update the Google Leads API key for the current session and echo the API endpoint or an error message.
  * @example
  * // To add a new API key (POST data normally provided by an HTTP request)
  * $_POST['action'] = 'add';
  * $_POST['api_name'] = 'google ads';
  * $this->Integration->add_api(); // echoes: https://api.team365.io/googlelead?key=abc123def4567890abcdef
  *
  * // To update an existing API key (provide upid or it will use existing google ads record)
  * $_POST['action'] = 'update';
  * $_POST['upid'] = 5;
  * $this->Integration->add_api(); // echoes: https://api.team365.io/googlelead?key=098fedcba654321
  * @param void $none - No direct function parameters; uses session data and POST fields ('action','api_name','upid').
  * @returns void Echoes the new API URL string on success or an HTML error message on failure.
  */
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
	
	
 /**
 * Add or update a "Just Dial" API integration: generates an API key and API URL, saves a new integration or updates the existing one in the Integration_model, and echoes the resulting API endpoint URL or an error HTML message.
 * @example
 * // Example (POST to controller endpoint):
 * // POST fields: api_name = "JustDialIntegration", action = "add"
 * // Response (on success):
 * // https://api.team365.io/justdiallead?key=5d41402abc4b2a76b9719d911017c592
 * $this->integration->add_api_jd();
 * @param string $_POST['api_name'] - Name/label for the API integration (e.g., "JustDialIntegration").
 * @param string $_POST['action'] - Action to perform: 'add' to create a new integration; any other value will update the existing integration key.
 * @param int|null $_POST['upid'] - Optional integration ID to update; if omitted or empty, the stored integration ID for "just dial" will be used.
 * @returns void Echoes the generated API URL (string) on success, otherwise echoes an HTML-formatted error message.
 */
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
	
	
 /**
 * Add or update a shared API integration key for the current session/company and echo the resulting API endpoint or an error message.
 * @example
 * // To add a new API key:
 * // POST data: api_name=googleads, action=add
 * // Example curl:
 * // curl -X POST -d "api_name=googleads&action=add" https://yourdomain.com/integration/add_api_common
 * // Sample echoed output on success:
 * // https://api.team365.io/leadapi?key=5f4dcc3b5aa765d61d8327deb882cf99
 * // To update an existing key:
 * // POST data: api_name=googleads, action=update, upid=123
 * @param {array} $_POST - HTTP POST input: requires 'api_name' (string), 'action' (string: 'add'|'update'), optional 'upid' (int).
 * @returns {string} Echoes the API URL (on success) or an HTML formatted error message (on failure).
 */
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
	
	
	
 /**
 * Add or update TradeIndia integration credentials using POST data and current session, then echo a status code.
 * @example
 * // Sample POST and session values (controller context)
 * $_POST['api_name']     = 'tradeindia';
 * $_POST['action']       = 'add'; // or 'update'
 * $_POST['tuserid']      = 'sampleUser';
 * $_POST['tprofileid']   = '12345';
 * $_POST['tkey']         = 'ABCDEF123456';
 * $this->session->set_userdata([
 *     'email' => 'user@example.com',
 *     'company_name' => 'Acme Corp',
 *     'company_email' => 'info@acme.com',
 *     'id' => 42
 * ]);
 * $this->Integration->add_data_trade();
 * // Possible echoed outputs:
 * // "1" => created or updated successfully
 * // "0" => database operation failed
 * // "3" => missing required POST fields (tuserid, tprofileid, or tkey)
 * @param string $api_name - POST: name of the API/integration (e.g. 'tradeindia').
 * @param string $action - POST: action to perform, expected 'add' to create new record or any other value to update.
 * @param string $tuserid - POST: TradeIndia user id (required for add/update), e.g. 'sampleUser'.
 * @param string $tprofileid - POST: TradeIndia profile id (required for add/update), e.g. '12345'.
 * @param string $tkey - POST: TradeIndia API key (required for add/update), e.g. 'ABCDEF123456'.
 * @param int $upid - POST: optional record id to update; if empty the existing record for the given api_name is used.
 * @param string $session email - Session: current user's email, used for record metadata.
 * @param string $session company_name - Session: current company name, used for record metadata.
 * @param string $session company_email - Session: current company email, used for record metadata.
 * @returns string Echoed status code: "1" on success, "0" on DB failure, "3" when required POST fields are missing.
 */
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
	
	
 /**
 * Add or update an IndiaMART data-mart integration using POSTed api_name, action, mart_mobile and mart_key; echoes status codes.
 * @example
 * // Example (controller context) — set POST values then call the method:
 * $_POST = [
 *   'api_name'   => 'indiamart',
 *   'action'     => 'add',
 *   'mart_mobile'=> '9876543210',
 *   'mart_key'   => 'ABC123DEF456'
 * ];
 * $this->add_data_mart();
 * // Output: "1" on successful insert, "0" on failure, "3" if required fields missing
 * @param array $post - POST data expected: 'api_name' (string), 'action' (string, e.g. 'add' or 'update'), 'mart_mobile' (string), 'mart_key' (string), optional 'upid' (int) for updates.
 * @returns string Echoed status code: "1" = success, "0" = failure, "3" = missing required parameters.
 */
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
	
	
	
	
 /**
 * Sends a POST request to the MyOperator API to create/update a user, prints the decoded JSON response and echoes a human-readable status message.
 * @example
 * $this->my_operator(); // called from a controller, e.g. application/controllers/Integration.php
 * // Possible output:
 * // stdClass Object ( [status] => success [data] => ... )   // print_r of decoded response
 * // User has been updated.                                // on success
 * // Something has gone wrong                               // on failure
 * @param {void} $none - No arguments are required.
 * @returns {void} No return value; outputs API response and echoes a status message.
 */
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