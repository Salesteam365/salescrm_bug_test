<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upgrade_plan extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Login_model');
    $this->load->model('Upgrade_plan_model');
    $this->load->helper('url');
  }
    public function index(){
		if(!empty($this->session->userdata('email')))
		{
		    $data['planlist'] = $this->Login_model->yourplanid();
		    $data['allplanlist'] = $this->Upgrade_plan_model->getPlanList('CRM','');
			$this->load->view('users/upgrade-plan',$data);
		}
		
    }
	
	public function extend_subscription(){
		if(!empty($this->session->userdata('email')))
		{
		    $data['planlist'] 	 = $this->Login_model->yourplanid();
		    $data['allplanlist'] = $this->Upgrade_plan_model->getPlanList('CRM','');
			$this->load->view('users/extend-subscription',$data);
		}
    }
    
    public function getLicence(){
        $id=$this->input->post('id');
        $planlist = $this->Login_model->yourplanid($id);
        echo json_encode($planlist);
    }
	
    public function getLicenceBuy(){
        $id=$this->input->post('id');
        $planlist = $this->Upgrade_plan_model->getPlanList('CRM',$id);
        echo json_encode($planlist);
    }
    
    public function getLicenceOption(){
        $id=$this->input->post('id');
        $planlist = $this->Upgrade_plan_model->getPlanList('CRM','');
        echo "<option value='0'>Select Plan</option>";
       for($i=0; $i<count($planlist);$i++){
           if($id<$planlist[$i]['id']){
           echo "<option value='".$planlist[$i]['id']."'>".$planlist[$i]['plan_name']."</option>";
           }
       }
    }
    
    
	
}
?>