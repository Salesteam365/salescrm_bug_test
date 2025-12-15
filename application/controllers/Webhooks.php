<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhooks extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('login_model');
    $this->load->library(array('upload','email_lib'));
   // $this->load->model('Company_model');
   $this->load->model('Setting_model','setting');
   $this->load->database();
  }
  
  
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
  
    public function index()
    {

        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];
        if ($verify_token === 'abc123') {
          echo $challenge;
        }
        
    $input = json_decode(file_get_contents('php://input'), true);
        
    // $ArrData=$input; 
    $dataentry  = $input['entry'];
    $dataVl     = $dataentry[0]['changes'];
    $leadGen    = $dataVl[0]['value'];
    $leadgen_id = $leadGen['leadgen_id']; 
    $form_id    = $leadGen['form_id'];    
        
    $dataRowCount=$this->setting->checkExistFbApp($form_id);
    
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,'https://graph.facebook.com/v10.0/'.$leadgen_id.'?access_token='.$dataRowCount->fb_access_token);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $result = json_decode($response);
    curl_close($ch); // Close the connection
    $FormName=$dataRowCount->fb_form_name;

    $subject='New lead found from facebook - '.$FormName;
    $output="<table><tr><td>TIME</td><td>".$result->created_time."</td></tr>";
    $valuData=$result->field_data;
    $newArr=array();
    $newArr2=0;
     for($k = 0;  $k <count($valuData); $k++) {
         $dataget=$valuData[$k];
         if (!in_array($dataget->values[0], $newArr)){
             if($dataget->name=='full_name' || $dataget->name=='FULL_NAME'){
                 $newArr=$dataget->values[0];
                 $fullName=$dataget->values[0];
                $output.="<tr><td>NAME : </td><td>".$fullName."</td></tr>";
             }
            if($dataget->name=='phone_number' || $dataget->name=='PHONE'){
                 $phone=$dataget->values[0];
                $output.="<tr><td>PHONE : </td><td>".$phone."</td></tr>";
             }
             if($dataget->name=='EMAIL' || $dataget->name=='email'){
                 $email=$dataget->values[0];
                $output.="<tr><td>EMAIL : </td><td>".$email."</td></tr>";
             }
             if($dataget->name=='company_name' || $dataget->name=='COMPANY_NAME'){
                 $orgName=$dataget->values[0];
                $output.="<tr><td>COMPANY_NAME : </td><td>".$orgName."</td></tr>";
             }
             if($dataget->name=='city' || $dataget->name=='CITY'){
                 $city=$dataget->values[0];
                $output.="<tr><td>CITY : </td><td>".$city."</td></tr>";
             }
        
       
            if($dataRowCount->session_comp_email=='info@appvela.com'){
               $admin_email='mp@allegientservices.com';
               $urlCurl="http://allegient.servicestodays.com/api/apileads";
               $dataArrFb=array(
                    'sess_eml' 			=> 'mp@allegientservices.com',
                    'session_company' 	=> 'Allegient Unified Technology Pvt. Ltd.',
                    'session_comp_email'=> 'mp@allegientservices.com',
                    'name' 			    => 'Facebook Lead - '.$dataRowCount->title,
                    'org_name'          => $orgName,
                    'email'             => $email,
                    'mobile'            => $phone,
                    'contact_name'      => $fullName,
                    'billing_city'      => $city,
                    'delete_status'     => 1,
                    'lead_source'       => 'Facebook',
                    'currentdate'       => date('Y-m-d')
                  ); 
            }else{
               //$admin_email='dev2@team365.io';
               $admin_email=$dataRowCount->session_comp_email;
               $urlCurl="https://allegient.team365.io/api/apileads";
              $dataArrFb=array(
                    'sess_eml' 			=> $dataRowCount->sess_eml,
                    'session_company' 	=> $dataRowCount->session_company,
                    'session_comp_email'=> $dataRowCount->session_comp_email,
                    'name' 			    => 'Facebook Lead - '.$dataRowCount->title,
                    'org_name'          => $orgName,
                    'email'             => $email,
                    'mobile'            => $phone,
                    'contact_name'      => $fullName,
                    'billing_city'      => $city,
                    'delete_status'     => 1,
                    'lead_source'       => 'Facebook',
                    'currentdate'       => date('Y-m-d')
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
				   
				  
            }
         
        $newArr2=($k+1); 
        if(count($valuData)==$newArr2){
            $newArr2=0;
            $ch = curl_init($urlCurl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArrFb);
           $response = curl_exec($ch);
           $newArr2['sts']=$response;
            curl_close($ch); 
        }
         
         }     
    }
    $output.="</table>";
    $this->email_lib->send_email($admin_email, $subject, $output);
	
    
        
	}
	public function my_plateform()
    {
     ?>
<script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '2787703948108895',
          xfbml      : true,
          version    : 'v10.0'
        });
      };
    
      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
    
      function subscribeApp(page_id, page_access_token) {
        console.log('Subscribing page to app! ' + page_id);
        FB.api(
          '/' + page_id + '/subscribed_apps',
          'post',
          {access_token: page_access_token, subscribed_fields: ['leadgen']},
          function(response) {
            console.log('Successfully subscribed page', response);
          }
        );
      }
        
      //Only works after `FB.init` is called
      function myFacebookLogin() {
        FB.login(function(response){
          console.log('Successfully logged in', response);
          FB.api('/me/accounts', function(response) {
            console.log('Successfully retrieved pages', response);
            var pages = response.data;
            var ul = document.getElementById('list');
            for (var i = 0, len = pages.length; i < len; i++) {
              var page = pages[i];
              var li = document.createElement('li');
              var a = document.createElement('a');
              a.href = "#";
              a.onclick = subscribeApp.bind(this, page.id, page.access_token);
              a.innerHTML = page.name;
              li.appendChild(a);
              ul.appendChild(li);
            }
          });
        }, {scope: 'leads_retrieval'});
      }
</script>

<button onclick="myFacebookLogin()">Login with Facebook</button>
<ul id="list"></ul>
<?php 	}
  
  
}
?>