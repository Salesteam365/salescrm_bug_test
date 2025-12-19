<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Leadapi extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->library('email_lib');
    }
    
    public function getDetail($urlkey)
    {   
        $this->db->where('api_key',$urlkey);
        $data = $this->db->get("api_detail");
        $infoAdmn=$data->row_array();
        return $infoAdmn;
    }
	
	
 /**
 * Get the most recent lead record's assigned user for a company session, optionally filtered by user or lead id.
 * @example
 * $result = $this->assignedUser('admin@acme.com','Acme Inc','42','123');
 * print_r($result); // Array ( [assigned_to] => 42 [id] => 123 [assigned_to_name] => John Doe )
 * @param string $session_comp_email - Company session email used to filter leads.
 * @param string $session_company - Company identifier used to filter leads.
 * @param string $userAssign - (Optional) User ID to filter the assigned_to column.
 * @param string $leadid - (Optional) Lead ID to filter for a specific lead.
 * @returns array|null Returns associative array with keys 'assigned_to', 'id', 'assigned_to_name' for the latest matching lead, or null if no record found.
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
     * Handle POST request to create a new lead in Team365, assign it to an appropriate user (or fallback), send a notification email to the company admin, and return an HTTP 200 response.
     * @example
     * // Example HTTP request:
     * // POST /leadapi?key=abc123
     * $_GET['key'] = 'abc123';
     * $_POST = [
     *   'name' => 'John Doe',
     *   'email' => 'john.doe@example.com',
     *   'office_phone' => '0123456789',
     *   'mobile' => '+911234567890',
     *   'contact_name' => 'John Doe',
     *   'org_name' => 'Example Co',
     *   'product_name' => 'Product X',
     *   'address' => '123 Example St',
     *   'state' => 'StateName',
     *   'city' => 'CityName'
     * ];
     * // In controller:
     * $this->index_post();
     * // Result: sends POST to https://api.team365.io/api/leads/add, emails admin (company email from key), and responds with HTTP 200 and message "Lead access successfully."
     * @param {string} $key - Query parameter 'key' used to fetch admin/session details (e.g. 'abc123').
     * @param {string} $name - Lead name from POST (e.g. 'John Doe').
     * @param {string} $email - Lead email from POST (e.g. 'john.doe@example.com').
     * @param {string} $office_phone - Lead office phone from POST (e.g. '0123456789').
     * @param {string} $mobile - Lead mobile phone from POST (e.g. '+911234567890').
     * @param {string} $contact_name - Contact person name from POST (e.g. 'John Doe').
     * @param {string} $org_name - Organization name from POST (e.g. 'Example Co').
     * @param {string} $product_name - Product name associated with the lead (e.g. 'Product X').
     * @param {string} $address - Billing/address line from POST (e.g. '123 Example St').
     * @param {string} $state - Billing/state from POST (e.g. 'StateName').
     * @param {string} $city - Billing/city from POST (e.g. 'CityName').
     * @returns {void} Sends an HTTP 200 response via REST_Controller with message array and does not return a PHP value. */
    public function index_post()
    {   
        $urlkey=$_GET['key'];
        $infoAdmn=$this->getDetail($urlkey);
          $data = array(
            'sess_eml' 			=> $infoAdmn['sess_eml'],
            'session_company' 	=> $infoAdmn['session_company'],
            'session_comp_email'=> $infoAdmn['session_comp_email'],
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
		   
			$leadName       = $this->post('name');
			$email          = $this->post('email');
			$office_phone   = $this->post('office_phone');
			$mobile			= $this->post('mobile');
			$contact_name	= $this->post('contact_name');
			$org_name		= $this->post('org_name');
			$product_name	= $this->post('product_name');
			$billing_address= $this->post('address');
			$billing_state	= $this->post('state');
			$billing_city	= $this->post('city');
		   
			$data = array(
                $data['name'] 				= $leadName,
                $data['email'] 				= $email,
                $data['office_phone'] 		= $office_phone,
                $data['mobile'] 			= $mobile,
                $data['lead_source'] 		= 'Other',
                $data['lead_status'] 		= 'Attempted To Contact',
                $data['contact_name'] 		= $contact_name,
                $data['currentdate'] 		= date('Y-m-d'),
                $data['track_status'] 		= 'lead',
                $data['org_name']          	= $org_name,
                $data['product_name']      	= $product_name,
                $data['billing_address']   	= $billing_address,
                $data['billing_state']     	= $billing_state,
                $data['billing_city']      	= $billing_city
            );   
		 
        
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://api.team365.io/api/leads/add');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);  
      
     
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
                        <a href="https://team365.io/" class="f-fallback email-masthead_name">';
        					$messageBody .=  '<span class="h5 text-primary">'.$infoAdmn['session_company'].'</span>';
        		$messageBody.='</a>
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
                                <h1>Hi, Admin!</h1>';
                            $messageBody.='<p>A new enquiry for your products.</p>';
        					$messageBody.='<p>This lead came from google ads.</p>';
        					$messageBody.='<p>Lead detail are bellow.</p>';
        					if(isset($data['contact_name'])){
        					$messageBody.='<p>'.$data['contact_name'].'</p>';
        					}if(isset($data['mobile'])){
        					$messageBody.='<p>'.$data['mobile'].'</p>';
        					}if(isset($data['email'])){
        					$messageBody.='<p>'.$data['email'].'</p>';
        					}if(isset($data['org_name'])){
        					$messageBody.='<p>'.$data['org_name'].'</p>';
        					}
                              $messageBody.='</div>
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
                              <p class="f-fallback sub align-center">&copy; '.date("Y").' '.$infoAdmn['session_company'].'. All rights reserved</p>
                              <p class="f-fallback sub align-center">Powered by - team365</p>
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
        	
		$subEmail='A new lead from your listing products';
		$this->email_lib->send_email($infoAdmn['session_comp_email'],$subEmail,$messageBody);  
		$this->response(['Lead access successfully.'], REST_Controller::HTTP_OK);
	   
    } 
     
    
}
?>