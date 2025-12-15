<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_profit_target extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Sales_profit_target_model','Sales_profit_target');
  }
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
    if(isset($_GET['q']) && !empty($_GET['q'])){
        $explVal=explode('-',$_GET['q']);
        $explVal1=$explVal[0];
        $explVal2=$explVal[1];
        $fistYear = str_replace('FY ','',$explVal1);
        $EndYear  = str_replace('FY ','',$explVal2);
        $fistQtrStDate = $fistYear.'-04-01';
        $EndQtrStDate  = $EndYear.'-03-31';
        $financialYear=$_GET['q'];
    }else{    
      $fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
    	$dateToGet=explode(':',$fiscal_year_for_date);
    	$fistQtrStDate	= $dateToGet['0'];
    	$EndQtrStDate	= $dateToGet['1'];
    	
    	  $date=date_create($fistQtrStDate);
        $firstYr    = date_format($date,"Y");
        $dateend    = date_create($EndQtrStDate);
        $secondYr   = date_format($dateend,"Y");
        
        $financialYear="FY ".$firstYr."-FY ".$secondYr;
        // $financialYear="FY ".$secondYr."-FY ".$secondYr+=1;
        // print_r($financialYear); exit();
        
    }
        
       $quotaU=$this->Sales_profit_target->getData($financialYear);

       // print_r($quotaU); exit;
       $data2['sales_users']=$this->Sales_profit_target->salesStdUser();
       
       $data3=array();
       
        if($this->session->userdata('type')=='admin'){
            $quotaA=$this->Sales_profit_target->getDataAdmin($financialYear);
           for($i=0; $i<count($quotaA); $i++){  
           $data=array();
           $so=$this->Sales_profit_target->getDataSo($quotaA[$i]['admin_email'],$fistQtrStDate,$EndQtrStDate);
           $data['standard_name'] = $quotaA[$i]['admin_name'];
           $data['finacial_year'] = $quotaA[$i]['finacial_year'];
           $data['quota']        = $quotaA[$i]['quota'];
           $data['profit_quota'] = $quotaA[$i]['profit_quota'];
           $data['id']           = $quotaA[$i]['id'];
             for($k=0; $k<count($so); $k++){
                 $data['sales']        = $so[$i]['subTotal'];
                 $data['profit']       = $so[$i]['profit'];
             }
             $data3[]=$data;
           }
       }
       
       //print_r($quotaU); exit;
       for($i=0; $i<count($quotaU); $i++){
           $data=array();
           $so=$this->Sales_profit_target->getDataSo($quotaU[$i]['standard_email'],$fistQtrStDate,$EndQtrStDate);
           $data['standard_name'] = $quotaU[$i]['standard_name'];
           $data['finacial_year'] = $quotaU[$i]['finacial_year'];
           $data['quota']        = $quotaU[$i]['quota'];
           $data['profit_quota'] = $quotaU[$i]['profit_quota'];
           $data['id']           = $quotaU[$i]['id'];
           if(count($so)>0 && !empty($so[0]['subTotal'])){
           for($k=0; $k<count($so); $k++){
               $data['sales']        = $so[$k]['subTotal'];
               $data['profit']       = $so[$k]['profit'];
           }
           }else{
               $data['sales']        = 0;
               $data['profit']       = 0;
           }
           $data3[] = $data;
       }
       $data2['quota'] = $data3;
      
       $this->load->view('reports/sales-profit-target',$data2);
    }
    else
    {
      redirect('login');
    }
  }
  
  
  public function view_sales_target_detail(){
      $quotaId = $this->uri->segment(2);
      $userName = $this->uri->segment(3);
      $org = $this->uri->segment(4);
      
      if(!empty($quotaId)){
       
        $qtData['salesQuota'] = $this->Sales_profit_target->getquotbyid($quotaId);
        
        $finacial_year = $qtData['salesQuota']['finacial_year'];
        $user_email   = $qtData['salesQuota']['user_email'];
        
      
        $explVal = explode('-',$finacial_year);
        $explVal1 = $explVal[0];
        $explVal2 = $explVal[1];
        $fistYear = str_replace('FY ','',$explVal1);
        $EndYear  = str_replace('FY ','',$explVal2);
        // print_r($EndYear); exit;

        // For anually...
        $fistQtrStDate = $fistYear.'-04-01';
        $EndQtrStDate  = $EndYear.'-03-31';
        $so = $this->Sales_profit_target->getDataSo($user_email,$fistQtrStDate,$EndQtrStDate,$org);
        $data=array();
        // print_r($so); exit;
        
        for($k=0; $k<count($so); $k++){
               $data['sales']        = $so[$k]['subTotal'];
               $data['profit']       = $so[$k]['profit'];     
        }
        $qtData['annualSales']=$data;

        // 1st qtr
        $fistQtr1 = $fistYear.'-04-01';
        $EndQtr1  = $fistYear.'-06-30';
        $so=$this->Sales_profit_target->getDataSo($user_email,$fistQtr1,$EndQtr1,$org);
        $data=array();
        for($k=0; $k<count($so); $k++){
           $data['sales']        = $so[$k]['subTotal'];
           $data['profit']       = $so[$k]['profit']; 
        }
        $qtData['firstQtrSales']=$data;
        
        // 2nd qtr
        $fistQtr2 = $fistYear.'-07-01';
        $EndQtr2  = $fistYear.'-09-30';
        $so=$this->Sales_profit_target->getDataSo($user_email,$fistQtr2,$EndQtr2,$org);
        $data=array();
        for($k=0; $k<count($so); $k++){
               $data['sales']        = $so[$k]['subTotal'];
               $data['profit']       = $so[$k]['profit'];   
        }
        $qtData['secondQtrSales']=$data;
        
        // 3rd qtr
        $fistQtr3 = $fistYear.'-10-01';
        $EndQtr3  = $fistYear.'-12-31';
        $so=$this->Sales_profit_target->getDataSo($user_email,$fistQtr3,$EndQtr3,$org);
        $data=array();
        for($k=0; $k<count($so); $k++){
               $data['sales']        = $so[$k]['subTotal'];
               $data['profit']       = $so[$k]['profit'];   
        }
        $qtData['thirdQtrSales']=$data;
        
        // 4th qtr
        $fistQtr4 = $EndYear.'-01-01';
        $EndQtr4  = $EndYear.'-03-31';
        $so=$this->Sales_profit_target->getDataSo($user_email,$fistQtr4,$EndQtr4,$org);
        $data=array();
        for($k=0; $k<count($so); $k++){
               $data['sales']        = $so[$k]['subTotal'];
               $data['profit']       = $so[$k]['profit'];    
        }
        $qtData['fourthQtrSales']=$data;
        
        $fistYearGt=$fistYear;      
        $m=4;  
        $getArr=array();

        for($j=1; $j<=12; $j++){  
        
        if($m>12){
            $m=1;
            $fistYearGt=($fistYearGt+1);
        }
        if($m<10){
            $Starting=$fistYearGt."-0".$m."-01";
        }else{
            $Starting=$fistYearGt."-".$m."-01";
        }
        
            $endDt=date('Y-m-t', strtotime($Starting));
            
            $so=$this->Sales_profit_target->getDataSo($user_email,$Starting,$endDt);
            $so2=$this->Sales_profit_target->getDataSo($user_email,$Starting,$endDt,'yes');
        
            $data=array();
                for($k=0; $k<count($so); $k++){
                    $data['sales']        = $so[$k]['subTotal'];
                    $data['profit']       = $so[$k]['profit'];
                }
                for($p=0; $p<count($so2); $p++){
                    $data[$p]['org_name'] = $so2[$p]['org_name'];
                    $data[$p]['companyvise_sales'] = $so2[$p]['subTotal'];
                    $data[$p]['companyvise_profit'] = $so2[$p]['profit'];
            }
                    $date=date_create($Starting);
                    $month=date_format($date,"M");
                    
                    $indexName=strtolower($month.'_pr');    
            $getArr[$indexName]=$data;  
            $m++;
        }


    $qtData['monthData']=$getArr; 
    // print_r($qtData);die;     

      $this->load->view('reports/view-sales-target',$qtData);
      }else{
          redirect('error');
      }
  }


  public function fetchData_org_month() {

    $orgName = $this->input->get('orgName');
    $monthName = $this->input->get('monthName');
    $mAmount = $this->input->get('mAmount');
   

    $m = date('m', strtotime($monthName));
    $y = date('Y', strtotime($monthName));
    
     $starting_date = date('Y-m-01', strtotime("$y-$m-01"));
     $end_date = date('Y-m-t', strtotime("$y-$m-01"));
   

    $All_org = $this->Sales_profit_target->getDataByOrgAndMonth($orgName ,$starting_date ,$end_date);
    // $qtData['salesQuota'] = $this->Sales_profit_target->getquotbyid($quotaId);
   
    foreach ($All_org as &$org_details) {
        $org_details['mAmount'] = $mAmount;
    }
    // $data = $org_details['mAmount'];

    $response = [
        'All_org' => $All_org,
        'mAmount' => $mAmount
    ];

    // print_r($response);die;

    // print_r($response);die;
    // header('Content-Type: application/json');
    echo json_encode($response);
}


// Controller code
public function fetchData_profit() {
    $orgName = $this->input->get('orgname');
    $monthName = $this->input->get('month');
    $mpAmount = $this->input->get('mpAmount');
    // print_r($mpAmount);die;


    // Assume $profit_org contains all the data
    $m = date('m', strtotime($monthName));
    $y = date('Y', strtotime($monthName));
    
    $starting_date = date('Y-m-01', strtotime("$y-$m-01"));
    $end_date = date('Y-m-t', strtotime("$y-$m-01"));

    $profit_org = $this->Sales_profit_target->get_PO_Number($orgName, $starting_date, $end_date);
    
    $sales_order_ids = array(); 
    foreach ($profit_org as $item) {
        $sales_order_ids[] = $item['saleorder_id'];
       

    }
    $profit_POID = $this->Sales_profit_target->get_PO_ID($sales_order_ids);



     // Prepare an array to hold repeated mpAmount values
    $mpAmountArray = array_fill(0, count($profit_org), $mpAmount);

    // Combine data into a single array
    $data = array(
        'profit_org' => $profit_org,
        'profit_POID' => $profit_POID,
        'mpAmount' => $mpAmountArray
    );

    // print_r($data);die;

    // Send JSON data
    header('Content-Type: application/json');
    echo json_encode($data);
}



  
  
  public function getSalesOrderPer(){
  
       $Starting=date('Y-m-01');
       $endDt=date('Y-m-t', strtotime($Starting));
       
       $fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
    	 $dateToGet=explode(':',$fiscal_year_for_date);
    	 $fistQtrStDate	= $dateToGet['0'];
    	 $EndQtrStDate	= $dateToGet['1'];
    	
    	  $date		= date_create($fistQtrStDate);
        $firstYr    = date_format($date,"Y");
        $dateend    = date_create($EndQtrStDate);
        $secondYr   = date_format($dateend,"Y");
        $financialYear="FY ".$firstYr."-FY ".$secondYr;
        
        $indexN=strtolower(date('M'));
        $indexNm=$indexN.'_month';
        $indexNmP='profit_'.$indexN.'_month';
        $totalProfitq=0;
        $totalSalesq=0;
        $quotaU=$this->Sales_profit_target->getDataForGraph($financialYear);
       
       for($i=0; $i<count($quotaU); $i++){
           $totalSalesq=$totalSalesq+$quotaU[$i][$indexNm];
           $totalProfitq=$totalProfitq+$quotaU[$i][$indexNmP];
       }
     
       
       if($this->session->userdata('type')=='standard'){
            $sess_eml 			= $this->session->userdata('email');
            $so=$this->Sales_profit_target->getDataSo($sess_eml,$Starting,$endDt);
        }else{
            $so=$this->Sales_profit_target->getDataSo('',$Starting,$endDt);
        }
      
       $totatSub=0;
       $totatSubProfit=0;
       $achieved_percentSO=0;
       $achieved_percentQt=0;
       for($k=0; $k<count($so); $k++){
            $totatSub=$totatSub+$so[$k]['subTotal'];
            $totatSubProfit=$totatSubProfit+$so[$k]['profit'];
        }
        if($totalSalesq>0){
        $achieved_percentSO = $totatSub/$totalSalesq * 100;
		}
		if($totalProfitq>0){
        $achieved_percentQt = $totatSubProfit/$totalProfitq * 100;
		}
        $salesScor=0;
        $profitScore=0;
        
        echo json_encode(array('sales_score'=>round($achieved_percentSO),'profit_score'=>round($achieved_percentQt), 'sales_quota'=>$totalSalesq,'profit_quota'=>$totalProfitq, 'get_sales'=>$totatSub,'get_profit'=>$totatSubProfit));
  }
  
  
  public function getquotbyid(){
      $qid=$this->input->post('qid');
      if(!empty($qid)){
      $qtData = $this->Sales_profit_target->getquotbyid($qid);
      echo json_encode($qtData);
      }else{
          echo json_encode(array('st'=>201, 'msg'=>'This data is not exist.'));
      }
  }
  
  
  public function createquota(){
      
	$validation = $this->check_validation();
    if($validation!=200)
    {
      echo $validation;die;
    }else{
	  $exit_user = $this->Sales_profit_target->exitquotaUser($this->input->post('sales_users'),$this->input->post('finacial_year'));
     if($exit_user){
         $data = array(
        'quota' 			=> str_replace(",", "",$this->input->post('set_quota')),
        'quat1' 		    => str_replace(",", "",$this->input->post('quat1')),
        'quat2' 	        => str_replace(",", "",$this->input->post('quat2')),
        'quat3' 			=> str_replace(",", "",$this->input->post('quat3')),
        'quat4' 			=> str_replace(",", "",$this->input->post('quat4')),
		'jan_month' 		=> str_replace(",", "",$this->input->post('per_month10')),
		'feb_month' 		=> str_replace(",", "",$this->input->post('per_month11')),
        'mar_month' 	    => str_replace(",", "",$this->input->post('per_month12')),
        'apr_month'         => str_replace(",", "",$this->input->post('per_month1')),
        'may_month' 	    => str_replace(",", "",$this->input->post('per_month2')),
		'jun_month' 		=> str_replace(",", "",$this->input->post('per_month3')),
		'jul_month' 		=> str_replace(",", "",$this->input->post('per_month4')),
        'aug_month' 	    => str_replace(",", "",$this->input->post('per_month5')),
        'sep_month' 	    => str_replace(",", "",$this->input->post('per_month6')),
        'oct_month' 		=> str_replace(",", "",$this->input->post('per_month7')),
		'nov_month' 		=> str_replace(",", "",$this->input->post('per_month8')),
		'dec_month' 		=> str_replace(",", "",$this->input->post('per_month9')),
		
		'profit_quota' 			=> str_replace(",", "",$this->input->post('set_quota_pr')),
        'profit_quat1' 		    => str_replace(",", "",$this->input->post('profitQuat1')),
        'profit_quat2' 	        => str_replace(",", "",$this->input->post('profitQuat2')),
        'profit_quat3' 			=> str_replace(",", "",$this->input->post('profitQuat3')),
        'profit_quat4' 			=> str_replace(",", "",$this->input->post('profitQuat4')),
		'profit_jan_month' 		=> str_replace(",", "",$this->input->post('pro_per_month10')),
		'profit_feb_month' 		=> str_replace(",", "",$this->input->post('pro_per_month11')),
        'profit_mar_month' 	    => str_replace(",", "",$this->input->post('pro_per_month12')),
        'profit_apr_month'         => str_replace(",", "",$this->input->post('pro_per_month1')),
        'profit_may_month' 	    => str_replace(",", "",$this->input->post('pro_per_month2')),
		'profit_jun_month' 		=> str_replace(",", "",$this->input->post('pro_per_month3')),
		'profit_jul_month' 		=> str_replace(",", "",$this->input->post('pro_per_month4')),
        'profit_aug_month' 	    => str_replace(",", "",$this->input->post('pro_per_month5')),
        'profit_sep_month' 	=> str_replace(",", "",$this->input->post('pro_per_month6')),
        'profit_oct_month' 		=> str_replace(",", "",$this->input->post('pro_per_month7')),
		'profit_nov_month' 		=> str_replace(",", "",$this->input->post('pro_per_month8')),
		'profit_dec_month' 		=> str_replace(",", "",$this->input->post('pro_per_month9'))
        
      );
		$resultdata = $this->Sales_profit_target->updateQuota($exit_user["id"],$data); 
	 }else{
	     $data = array(
        'sess_eml' 			=> $this->session->userdata('email'),
        'session_company' 	=> $this->session->userdata('company_name'),
        'session_comp_email'=> $this->session->userdata('company_email'),
        'user_email' 		=> $this->input->post('sales_users'),
        'finacial_year' 	=> $this->input->post('finacial_year'),  
        'quota' 			=> str_replace(",", "",$this->input->post('set_quota')),
        'quat1' 		    => str_replace(",", "",$this->input->post('quat1')),
        'quat2' 	        => str_replace(",", "",$this->input->post('quat2')),
        'quat3' 			=> str_replace(",", "",$this->input->post('quat3')),
        'quat4' 			=> str_replace(",", "",$this->input->post('quat4')),
		'jan_month' 		=> str_replace(",", "",$this->input->post('per_month10')),
		'feb_month' 		=> str_replace(",", "",$this->input->post('per_month11')),
        'mar_month' 	    => str_replace(",", "",$this->input->post('per_month12')),
        'apr_month'         => str_replace(",", "",$this->input->post('per_month1')),
        'may_month' 	    => str_replace(",", "",$this->input->post('per_month2')),
		'jun_month' 		=> str_replace(",", "",$this->input->post('per_month3')),
		'jul_month' 		=> str_replace(",", "",$this->input->post('per_month4')),
        'aug_month' 	    => str_replace(",", "",$this->input->post('per_month5')),
        'sep_month' 	    => str_replace(",", "",$this->input->post('per_month6')),
        'oct_month' 		=> str_replace(",", "",$this->input->post('per_month7')),
		'nov_month' 		=> str_replace(",", "",$this->input->post('per_month8')),
		'dec_month' 		=> str_replace(",", "",$this->input->post('per_month9')),
		
		'profit_quota' => str_replace(",", "",$this->input->post('set_quota_pr')),
        'profit_quat1' => str_replace(",", "",$this->input->post('profitQuat1')),
        'profit_quat2' => str_replace(",", "",$this->input->post('profitQuat2')),
        'profit_quat3' => str_replace(",", "",$this->input->post('profitQuat3')),
        'profit_quat4' => str_replace(",", "",$this->input->post('profitQuat4')),
		'profit_jan_month' => str_replace(",", "",$this->input->post('pro_per_month10')),
		'profit_feb_month' => str_replace(",", "",$this->input->post('pro_per_month11')),
        'profit_mar_month' => str_replace(",", "",$this->input->post('pro_per_month12')),
        'profit_apr_month' => str_replace(",", "",$this->input->post('pro_per_month1')),
        'profit_may_month' 	    => str_replace(",", "",$this->input->post('pro_per_month2')),
		'profit_jun_month' 		=> str_replace(",", "",$this->input->post('pro_per_month3')),
		'profit_jul_month' 		=> str_replace(",", "",$this->input->post('pro_per_month4')),
        'profit_aug_month' 	    => str_replace(",", "",$this->input->post('pro_per_month5')),
        'profit_sep_month' 	=> str_replace(",", "",$this->input->post('pro_per_month6')),
        'profit_oct_month' 		=> str_replace(",", "",$this->input->post('pro_per_month7')),
		'profit_nov_month' 		=> str_replace(",", "",$this->input->post('pro_per_month8')),
		'profit_dec_month' 		=> str_replace(",", "",$this->input->post('pro_per_month9')),
		'ip'                    => $this->input->ip_address()
        
      );
        $resultdata = $this->Sales_profit_target->createQuota($data);
	 }
      if($resultdata){
      echo json_encode(array("status" => TRUE));
	}
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
  
 
  
 
}
?>
