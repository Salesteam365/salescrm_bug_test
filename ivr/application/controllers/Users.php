<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
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
