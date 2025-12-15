<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Forecast extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Forecast_model','forecast');
    $this->load->model('Quotation_model','Quotation');
    $this->load->model('Lead_model','Lead');
    $this->load->library(array('upload','email_lib'));
    
  }
  

  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
        if(checkModuleForContr('Forecast and Quota')<1){
	     redirect('home');
	     exit;
	    }
    if(check_permission_status('Forecast and Quota','retrieve_u')==true){
		
		$fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
		$dateToGet=explode(':',$fiscal_year_for_date);
		$fistQtrStDate	= $dateToGet['0'];
		$EndQtrStDate	= $dateToGet['1'];
 
		$firstYear=$this->getData($fistQtrStDate, $EndQtrStDate);

	$next_month 	= date("Y-m-d", strtotime($fistQtrStDate." +3 month"));
	$nextMonth 		= date("Y-m-d", strtotime($next_month." -1 day"));
	$fistQtrEndDate	= $nextMonth;
	
	$secQtrStDate	= $next_month;
	$nextDate 		= date("Y-m-d", strtotime($secQtrStDate." +3 month"));
	$nextMonth2 	= date("Y-m-d", strtotime($nextDate." -1 day"));
	$secQtrEndDate	= $nextMonth2;
	
	$thirdQtrStDate	= $nextDate;
	$nextDate3 		= date("Y-m-d", strtotime($thirdQtrStDate." +3 month"));
	$nextMonth3 	= date("Y-m-d", strtotime($nextDate3." -1 day"));
	$thirdQtrEndDate= $nextMonth3;
	
	$frthQtrStDate	= $nextDate3;
	$nextDate4 		= date("Y-m-d", strtotime($frthQtrStDate." +3 month"));
	$nextMonth4 	= date("Y-m-d", strtotime($nextDate4." -1 day"));
	$frthQtrEndDate= $nextMonth4;
	
	$qtr1=$this->getData($fistQtrStDate, $fistQtrEndDate);
	$qtr2=$this->getData($secQtrStDate, $secQtrEndDate);
	$qtr3=$this->getData($thirdQtrStDate, $thirdQtrEndDate);
	$qtr4=$this->getData($frthQtrStDate, $frthQtrEndDate);
	
	$data['firstData']	= $qtr1;
	$data['secData']	= $qtr2;
	$data['thrdData']	= $qtr3;
	$data['frthData']	= $qtr4;
	$data['annually']	= $firstYear;
	
	$fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
	$dateToGet		= explode(':',$fiscal_year_for_date);
	$fistQtrStDate	= $dateToGet['0'];
	$date			= date_create($fistQtrStDate);
	$dateYear		= date_format($date,'Y');
	$dateMonth		= date_format($date,'m');
	$IndMont		= date_format($date,'M');
	$newData		= array();
	$newData[$IndMont]=$this->getMonthly($dateYear,$dateMonth);
		for($n=1; $n<=11; $n++){
			$nextDate = date("Y-m-d", strtotime($fistQtrStDate." +".$n." month"));
			$date=date_create($nextDate);
			$dateYear   =date_format($date,'Y');
			$dateMonth  =date_format($date,'m');
			$IndMont=date_format($date,'M');
			$newData[$IndMont]=$this->getMonthly($dateYear,$dateMonth);
		}
		$data['monthly']=$newData;
		$data["sales_users"]	= $this->forecast->salesStdUser();
		$this->load->view('sales/forecast-quota',$data);
	}else{
		redirect("permission");
	}
    }else{
      redirect('login');
    }
  }
  

public function getMonthly($year,$month){
    
    if(isset($_GET['q'])) {
        $getq=$_GET['q'];
    }else{
        $getq='team';
    }
    
	$dataList		= $this->forecast->get_forcast_monthly($year,$month,$getq);
	$dataArrLst=array();
	$totalPipeLine=0;
	$totalWon=0;
	$totalBest=0;
	$totalCommit=0;
	  foreach($dataList as $row){
		$dataArr=array();
		$dataRow 	= $this->forecast->get_forcast_user_monthly($year,$month,'Closed Won',$row->sess_eml);
		$dataRowBest 	= $this->forecast->get_forcast_bestCase_monthly($year,$month,$row->sess_eml);
		$dataRowCom 	= $this->forecast->get_forcast_Commit_monthly($year,$month,$row->sess_eml);
		
		//$date	 = date_create($startDate);
	    $dateF   = $month;
		$dateFY  = $year;
		if($dateF>1){  
			$finYer="FY ".$dateFY."-FY ".($dateFY+1);      
		}else{ 
			$finYer="FY ".($dateFY-1)."-FY ".($dateFY); 
		}	
		$dataUser 	= $this->forecast->get_forcast_quota($row->sess_eml,$finYer);
		$dataArr['quotadata']=$dataUser;
		
		$dataArr['pipeline']=$row->op_total;
		$totalPipeLine=($totalPipeLine+$row->op_total);
		$dataArr['owner']=$row->owner;
		if(count($dataRow)>0){
		foreach($dataRow as $listrow){ 
			if($listrow->op_total) {
			    $totalWon=($totalWon+$listrow->op_total);
			$dataArr['won']=$listrow->op_total; 
			}else{
			$dataArr['won']="";	
			}
		}
		}else{ 	$dataArr['won']="";	 }
	
		// best
		if(count($dataRowBest)>0){
		foreach($dataRowBest as $listrow){ 
			if($listrow->op_total) { 
			 $totalBest=($totalBest+$listrow->op_total);
			$dataArr['best']=$listrow->op_total; 
			}else{
			$dataArr['best']="";	
			}
		}
		}else{ 	$dataArr['best']="";	 }
		//commit
		if(count($dataRowCom)>0){
		foreach($dataRowCom as $listrow){ 
			if($listrow->op_total) { 
			    $totalCommit=($totalCommit+$listrow->op_total);
			$dataArr['commit']=$listrow->op_total; 
			}else{
			$dataArr['commit']="";	
			}
		}
		}else{ 	$dataArr['commit']="";	 }
		
		
		$dataArrLst[]=$dataArr;
	  }
	  $date		= date_create(date('Y').'-'.$month.'-01');
	  $dateF   	= date_format($date,'F');
	  $dataArrLst[$dateF]=$totalPipeLine;
	  $dataArrLst[$dateF.'won']=$totalWon;
	  $dataArrLst[$dateF.'best']=$totalBest;
	  $dataArrLst[$dateF.'commit']=$totalCommit;
	return $dataArrLst;
  
}


  public function getData($startDate, $endDate){
    if(isset($_GET['q'])) {
        $getq=$_GET['q'];
    }else{
        $getq='team';
    }
      
	$dataList		= $this->forecast->get_forcast($startDate, $endDate, $getq);
	$dataArrLst=array();
	  foreach($dataList as $row){
		$dataArr=array();
		$dataRow 	= $this->forecast->get_forcast_user($startDate, $endDate,'Closed Won',$row->sess_eml);
		
		$dataRowBest 	= $this->forecast->get_forcast_bestCase($startDate, $endDate,$row->sess_eml);
		$dataRowCom 	= $this->forecast->get_forcast_Commit($startDate, $endDate,$row->sess_eml);
		
		$date	 = date_create($startDate);
	    $dateF   = date_format($date,'m');
		$dateFY  = date_format($date,'Y');
		if($dateF>1){  
			$finYer="FY ".$dateFY."-FY ".($dateFY+1);      
		}else{ 
			$finYer="FY ".($dateFY-1)."-FY ".($dateFY); 
		}
			
		$dataUser 	= $this->forecast->get_forcast_quota($row->sess_eml,$finYer);
		$dataArr['quotadata']=$dataUser;
		$dataArr['pipeline']=$row->op_total;
		$dataArr['owner']=$row->owner;
		
		
		if(count($dataRow)>0){
		foreach($dataRow as $listrow){ 
			if($listrow->op_total) { 
			$dataArr['won']=$listrow->op_total; 
			}else{
			$dataArr['won']="";	
			}
		}
		}else{ 	$dataArr['won']="";	 }
	
		// best
		if(count($dataRowBest)>0){
		foreach($dataRowBest as $listrow){ 
			if($listrow->op_total) { 
			$dataArr['best']=$listrow->op_total; 
			}else{
			$dataArr['best']="";	
			}
		}
		}else{ 	$dataArr['best']="";	 }
		//commit
		if(count($dataRowCom)>0){
		foreach($dataRowCom as $listrow){ 
			if($listrow->op_total) { 
			$dataArr['commit']=$listrow->op_total; 
			}else{
			$dataArr['commit']="";	
			}
		}
		}else{ 	$dataArr['commit']="";	 }
		
		$dataArr['dataDate']=$startDate.":".$endDate;
		
		$dataArrLst[]=$dataArr;
	  }
	return $dataArrLst;
  }
  
  
  /*   ADD SALES QUOTA   */
  
  public function createquota(){
	  
	if(check_permission_status('Forecast and Quota','create_u')==true){  
	  
	  $validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }else{
     
	  $exit_user = $this->forecast->exitquotaUser($this->input->post('sales_users'));
	  
      $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'quota' 			=> str_replace(",", "",$this->input->post('set_quota')),
        'user_email' 			=> $this->input->post('sales_users'),
        'finacial_year' 	=> $this->input->post('finacial_year'),       
        'quat1' 		    => str_replace(",", "",$this->input->post('quat1')),
        'quat2' 	        => str_replace(",", "",$this->input->post('quat2')),
        'quat3' 			=> str_replace(",", "",$this->input->post('quat3')),
        'quat4' 			=> str_replace(",", "",$this->input->post('quat4')),
		'jan_month' 		=> str_replace(",", "",$this->input->post('per_month1')),
		'feb_month' 		=> str_replace(",", "",$this->input->post('per_month2')),
        'mar_month' 	    => str_replace(",", "",$this->input->post('per_month3')),
        'apr_month'         => str_replace(",", "",$this->input->post('per_month4')),
        'may_month' 	    => str_replace(",", "",$this->input->post('per_month5')),
		'jun_month' 		=> str_replace(",", "",$this->input->post('per_month6')),
		'jul_month' 		=> str_replace(",", "",$this->input->post('per_month7')),
        'aug_month' 	    => str_replace(",", "",$this->input->post('per_month8')),
        'sep_month' 	    => str_replace(",", "",$this->input->post('per_month9')),
        'oct_month' 		=> str_replace(",", "",$this->input->post('per_month10')),
		'nov_month' 		=> str_replace(",", "",$this->input->post('per_month11')),
		'dec_month' 		=> str_replace(",", "",$this->input->post('per_month12')),
		'ip'                => $this->input->ip_address()
        
      );
	  
     if($exit_user){
		$resultdata = $this->forecast->updateQuota($exit_user["user_id"],$data); 
	 }else{
        $resultdata = $this->forecast->createQuota($data);
	 }
      if($resultdata){
      echo json_encode(array("status" => TRUE));
	}
    }
	}else{
		echo json_encode(array("status" => FALSE));
	}
  }
 public function check_validation()
  {
    $this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; margin-left: 10px;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
    $this->form_validation->set_rules('finacial_year', 'Finacial Year', 'required|trim');
    $this->form_validation->set_rules('sales_users', 'Sales User', 'required|trim');
    $this->form_validation->set_rules('set_quota', 'Quota', 'required|trim');
   
	
    $this->form_validation->set_message('required', '%s is required');
   
    if ($this->form_validation->run() == FALSE)
    {
      return json_encode(array('st'=>202, 'finacial_year'=> form_error('finacial_year'), 'sales_users'=> form_error('sales_users'),'set_quota'=> form_error('set_quota')));
    }else
    {
      return 200;
    }
  } 
  
  
  
  

//please write code above this
}
?>
