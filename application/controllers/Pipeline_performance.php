<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pipeline_performance extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Login_model');
    $this->load->model('Pipeline_model','Pipeline');
    $this->load->library('excel');
    $this->perPage = 10;
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
       $data=array();
      /*$date = "Month";
      
      $data['leads_status'] = $this->Pipeline->get_leads_status();
      $data['opp_stage'] = $this->Pipeline->get_opp_stage();
      $data['quote_stage'] = $this->Pipeline->get_quote_stage();
      $data['user'] = $this->Login_model->getusername();
      $data['admin'] = $this->Login_model->getadminname();*/
      $this->load->view('sales/pipeline_performance', $data);
    }
    else
    {
      redirect('home');
    }
  }
  public function get_lead_for_record()
  {
    $list = $this->Pipeline->get_lead_for_record();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
  
      $row[] = $post->lead_owner;
      $row[] = $post->total_leads;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Pipeline->count_all_leads(),
      "recordsFiltered" => $this->Pipeline->count_filtered_leads(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  public function get_leads_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Pipeline->get_report_leads_by_user($type);
    echo json_encode($result);
  }
 
  public function sort_deals_graph()
  {
    $type = $this->session->userdata('type'); 
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
	$date_year = $this->input->post('date_year');
    $deal_stage = $this->input->post('deal_stage');
    $data = $this->Pipeline->get_all_deals_by_date($type,$sort_date,$from_date,$to_date,$date_year,$deal_stage);
    echo json_encode($data);
  }
  
  public function getdata_pipelineValue()
  {
    $data = $this->Pipeline->get_pipeline_value();
    echo json_encode($data);

  }
  
  public function getdata_pipelineFunnel()
  {    
    $result = $this->Pipeline->get_pipeline_funnel();
	if($result){
	$output='';

	$output.='[';		
	foreach($result as $row){
		$resultData = $this->Pipeline->get_pipeline_funnel_byStage($row->stage);
		
		$output.='{ y: '.$resultData->sub_total.', label: "'.$row->stage.'" , total: '.$resultData->total_oppo.'},';
	}
  $output.=']';
    echo json_encode($output);
	}else{
		echo json_encode('201');
	}
  }
   
  public function getdata_pipelineActivity()
  {    
    $result = $this->Pipeline->get_pipeline_activity();
	if($result){
		if($this->input->post('filterYear')){
			$filt_year = $this->input->post('filterYear');
		}else{
			$filt_year = date('Y');
		}
		//print_r($result);
	$output='';

	$output.='[';		
	foreach($result as $row){
		//$resultData = $this->Pipeline->get_pipeline_funnel_byStage($row->stage);
		
		$output.='{x: '.$row->month_name.', y: '.$row->sub_total.', z: 10,  stage: "'.$row->stage.'" , cdate: "'.$row->expclose_date.'",onam: "'.$row->name.'"},';
	}
  $output.=']';
      echo json_encode($output);
	}else{
		echo json_encode('201');
	}
  }
  


//Please write code above this  
}
?>
