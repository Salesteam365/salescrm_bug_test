<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {
    
 /**
 * Load logs and user list from the MyOperator API and render the 'logs' view.
 * @example
 * $logsController = new Logs();
 * $logsController->index();
 * // After execution the view 'logs' receives $result where:
 * // $result['loglist'][0]->id  => 'log123'      (sample value)
 * // $result['userList'][0]->phone => '9876543210' (sample value)
 * @param void $none - No arguments required.
 * @returns void Loads the 'logs' view with decoded JSON in $result['loglist'] and $result['userList'].
 */
	public function index()
	{
	      $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'https://developers.myoperator.co/search');
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                    'token' => '3db54ae2405076bfc0784021b9c07500'
                ));
                 
             
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                 
                $result['loglist'] = json_decode($buffer);
                
                
            //GETTING USER LIST.......    
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, 'https://developers.myoperator.co/user?token=3db54ae2405076bfc0784021b9c07500');
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            $phoneList = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            $result['userList'] = json_decode($phoneList);
                
                
                
		$this->load->view('logs',$result);
	}
	
}
