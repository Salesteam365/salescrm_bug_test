<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Contact_model','Contact');
  }
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
            //print_r($jsonArrayResponse);
        
            $this->load->view('ivr/user-list',$jsonArrayResponse);
    }
    else
    {
      redirect('login');
    }
  }
  
  
  
  public function getLog(){
      
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'https://developers.myoperator.co/search');
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_POST, 1);
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                    'token' => '3db54ae2405076bfc0784021b9c07500'
                ));
                 
             
                $buffer = curl_exec($curl_handle);
                curl_close($curl_handle);
                 
                $result = json_decode($buffer);
                
                print_r($result->data);
             
                if(isset($result->status) && $result->status == 'success')
                {
                    echo 'User has been updated.';
                }
                 
                else
                {
                    echo 'Something has gone wrong';
                }
            
      
  }
  
  
  
   public function add_user()
  {
    if(!empty($this->session->userdata('email')))
    {
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
    else
    {
      redirect('login');
    }
  }
  
 
}
?>
