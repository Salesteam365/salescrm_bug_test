<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
 /**
 * Load users list and render the 'users' view if a logged-in session exists; otherwise redirect to the login page.
 * @example
 * // Called without arguments from the controller (index method):
 * $this->index();
 * // After execution, the view 'users' receives:
 * // $jsonArrayResponse['userList'] => decoded JSON response from MyOperator API
 * // Example decoded value: [{"id":1,"name":"John Doe","phone":"9876543210"}]
 * @returns void Executes a view load with user data or performs a redirect; does not return a value.
 */
	public function index()
	{
	    if(!empty($this->session->userdata('email')))
        {
            
	        $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, 'https://developers.myoperator.co/user?token=3db54ae2405076bfc0784021b9c07500');
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $phoneList = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $jsonArrayResponse['userList'] = json_decode($phoneList);
		    $this->load->view('users',$jsonArrayResponse);
        }
        else
        {
          redirect('http://allegient.team365.io/');
        }
        
	}
	
	
 /**
  * Add a new user by reading POST input, forwarding data to the MyOperator user API, and echoing a JSON result.
  * @example
  * // Example using PHP cURL to call this controller method
  * $ch = curl_init('https://your-domain/Users/adduser');
  * curl_setopt($ch, CURLOPT_POST, true);
  * curl_setopt($ch, CURLOPT_POSTFIELDS, [
  *     'userName'  => 'John Doe',
  *     'userEmail' => 'john@example.com',
  *     'phoneType' => 'mobile',
  *     'userMobile'=> '919876543210',
  *     'userExt'   => '',
  *     'alt_num'   => '',
  *     'alt_cntry' => '91',
  *     'cod_cntry' => '91'
  * ]);
  * curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  * $result = curl_exec($ch);
  * echo $result; // possible output: {"status":200,"msg":"success"} or {"status":400,"msg":"failed"}
  * @param string $userName - POST 'userName': full name of the user.
  * @param string $userEmail - POST 'userEmail': email address of the user.
  * @param string $phoneType - POST 'phoneType': type of phone (e.g., 'mobile', 'landline').
  * @param string $userMobile - POST 'userMobile': contact mobile number (digits, include country code if required).
  * @param string $userExt - POST 'userExt': phone extension if applicable.
  * @param string $alt_num - POST 'alt_num': alternate phone number (optional).
  * @param string $alt_cntry - POST 'alt_cntry': alternate number country code (optional).
  * @param string $cod_cntry - POST 'cod_cntry': contact country code for the primary number.
  * @returns void Echoes a JSON response indicating success or failure (e.g., {"status":200,"msg":"success"} or {"status":400,"msg":"failed"}).
  */
	public function adduser()
    {
        if(!empty($this->session->userdata('email')))
        {
            
            if($this->input->post('userName')){
                
                $userName   = $this->input->post('userName');
                $userEmail  = $this->input->post('userEmail');
                $phoneType  = $this->input->post('phoneType');
                $userMobile = $this->input->post('userMobile');
                $userExt    = $this->input->post('userExt');
                $alt_num    = $this->input->post('alt_num');
                $alt_cntry  = $this->input->post('alt_cntry');
                $cod_cntry  = $this->input->post('cod_cntry');
                
                    $curl_handle = curl_init();
                    curl_setopt($curl_handle, CURLOPT_URL, 'https://developers.myoperator.co/user');
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl_handle, CURLOPT_POST, 1);
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                        'token'         => '3db54ae2405076bfc0784021b9c07500',
                        'name'          => $userName,
                        'contact_number'=> $userMobile,
                        'country_code'  => $cod_cntry,
                        'extension'     => $userExt,
                        'email'         => $userEmail
                    ));
                     
                 
                    $buffer = curl_exec($curl_handle);
                    curl_close($curl_handle);
                    $result = json_decode($buffer);
                    if(isset($result->status) && $result->status == 'success')
                    {
                        echo json_encode(array('status'=>200, 'msg'=>'success'));
                    }else
                    {
                        echo json_encode(array('status'=>400, 'msg'=>'failed'));
                    }
                    
            }else{
                
            }
                
    	}
        else
        {
          redirect('login');
        }
    }
    
    
/**
 * Send an outbound dialer (OBD) request using POSTed PhoneNumber and userId, echoing the request payload and the API response.
 * @example
 * // Example (set POST values before calling)
 * $_POST['PhoneNumber'] = '9876543210';
 * $_POST['userId'] = '6049e37a1d588506';
 * $this->call();
 * // Example output (first the payload echoed, then the remote API response):
 * // {"company_id":"603dfb5012c3d619","secret_token":"c857fb46...06f82","type":"1","number":"+919876543210","user_id":"6049e37a1d588506","public_ivr_id":"6050805bcef7b782","region":"DL, IN","caller_id":"","group":""}
 * // {"status":"success","message":"Request queued","job_id":"abc123"}
 * @param {string} PhoneNumber - Phone number digits read from POST 'PhoneNumber' (without country code). Example: '9876543210'.
 * @param {string} userId - User identifier read from POST 'userId'. Example: '6049e37a1d588506'.
 * @returns {string} Echoes JSON strings: first the request payload, then the OBD API JSON response.
 */
public function call(){
          
    // "company_id": "603dfb5012c3d619",
     //"secret_token": "c857fb463ceb999d7f74eac8a22a7383785d289ce9537e627fe295ca45106f82",
    // "user_id": "6049e37a1d588506",
    //  "x-api-key: oomfKA3I2K6TCJYistHyb7sDf0l0F6c8AZro5DJh",  
    
    
    
    $PhoneNumber  = $this->input->post('PhoneNumber');
    $userId       = $this->input->post('userId');
    
    $dataArr=array(
        "company_id"    => "603dfb5012c3d619",
        "secret_token"  => "c857fb463ceb999d7f74eac8a22a7383785d289ce9537e627fe295ca45106f82",
        "type"          => "1",
         "number"       => "+91".$PhoneNumber, 
         "user_id"      => $userId,
         "public_ivr_id"=> "6050805bcef7b782",
         "region"       => "DL, IN",
         "caller_id"    => "",
         "group"        => ""
        );
        
        //6049e37a1e8a0685
        //6049e37a1d588506
        
       
        
        echo json_encode($dataArr);
    
$curl = curl_init();
curl_setopt_array($curl, array(
 CURLOPT_URL => "https://obd-api.myoperator.co/obd-api-v1",
 CURLOPT_RETURNTRANSFER => true,
 CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_POSTFIELDS =>json_encode($dataArr),
 CURLOPT_HTTPHEADER => array(
 "x-api-key: oomfKA3I2K6TCJYistHyb7sDf0l0F6c8AZro5DJh",
 "Content-Type: application/json"
 ),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;      
          
    }
	
	
	
	
}
