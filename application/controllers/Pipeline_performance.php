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
  /**
  * Display the pipeline performance page for authenticated users or redirect guests.
  * @example
  * // From another controller or test, call the method directly:
  * $this->pipeline_performance->index();
  * // Or access via browser: GET /pipeline_performance
  * // Effect: Renders the 'sales/pipeline_performance' view (HTML output) when user is logged in;
  * // otherwise performs a redirect to 'home'.
  * @param {void} none - No arguments are accepted by this method.
  * @returns {void} Returns nothing; this method either loads a view or redirects the request.
  */
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
  /**
  * Return JSON for DataTables containing lead counts grouped by lead owner for the requested page.
  * @example
  * // Called as a controller action; expects POST parameters 'start' and 'draw'.
  * $_POST['start'] = 0;
  * $_POST['draw'] = 1;
  * $this->get_lead_for_record();
  * // Example output printed to response:
  * // {"draw":1,"recordsTotal":10,"recordsFiltered":5,"data":[["Alice Smith",3],["Bob Jones",2]]}
  * @param {void} none - This controller method does not accept function arguments; it reads input from $_POST.
  * @returns {void} Echoes a JSON-encoded object with keys: draw, recordsTotal, recordsFiltered and data.
  */
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
  
  /**
  * Fetches pipeline funnel data by stage and echoes a JSON-encoded representation suitable for charting.
  * @example
  * $result = $this->getdata_pipelineFunnel();
  * echo $result // render sample output: "[{ y: 120, label: \"Qualification\" , total: 5},{ y: 80, label: \"Proposal\" , total: 3}]"
  * @param void $none - No parameters required.
  * @returns string Echoes a JSON-encoded string containing an array of funnel objects (each with y, label and total). If no data is found, echoes the string '201'.
  */
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
   
  /**
  * Fetch pipeline activity from the Pipeline model and echo a JSON-encoded string suitable for charting.
  * Uses POST parameter 'filterYear' (falls back to current year) to determine the filter year (though the current implementation only assigns it and does not alter output).
  * @example
  * // Call from a controller to output pipeline activity JSON to the response (no return value).
  * $this->getdata_pipelineActivity();
  * // Sample echoed output (json-encoded string):
  * // "[{x: Jan, y: 5, z: 10,  stage: \"Proposal\" , cdate: \"2025-03-15\",onam: \"Acme Corp\"},{x: Feb, y: 3, z: 10,  stage: \"Negotiation\" , cdate: \"2025-04-01\",onam: \"Beta Ltd\"}]"
  * @param void none - This method accepts no parameters.
  * @returns void Echoes a JSON-encoded string containing an array of objects with keys:
  *               x (month label), y (subtotal numeric), z (constant 10), stage (stage name),
  *               cdate (expected close date) and onam (opportunity name). If no data is found echoes JSON-encoded '201'.
  */
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
