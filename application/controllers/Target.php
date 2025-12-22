<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Target extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Target_model');
    $this->load->model('Login_model');
    //$this->load->library('Ajax_pagination');
    $this->perPage = 5;
    
  }
  /**
  * Display the user target page when a user is authenticated; otherwise redirect to the login page.
  * @example
  * // Call from code or a test:
  * $targetController = new Target();
  * $targetController->index();
  * // Or access via browser: GET /target
  * // Example resulting data available to the view:
  * // $data['user'] = ['id' => 1, 'email' => 'user@example.com'];
  * // $data['dateyr'] = [2025];
  * // $data['datemnth'] = ['January', 'February', 'March'];
  * @param void $none - This method does not accept any parameters.
  * @returns void No direct return; the method loads the 'users/user_target' view with data or redirects to 'login'.
  */
  public function index()
  {

    if(!empty($this->session->userdata('email')))
    {
      $data['user'] = $this->Target_model->getuserdataTarget();
      $data['dateyr'] = $this->Target_model->get_DateYear('year');
      $data['datemnth'] = $this->Target_model->get_DateYear('month');
      $this->load->view('users/user_target',$data);
    }
    else
    {
      redirect('login');
    }

  }


  /**
  * Generate and echo HTML <option> elements for months available for a posted year ('yearsDt').
  * @example
  * $_POST['yearsDt'] = '2020';
  * $this->Target->getMonth();
  * // Echoes sample output (depending on months returned by Target_model->get_DateYear):
  * // "<option value='01'>January</option><option value='02'>February</option><option value='03'>March</option>"
  * @param string $yearsDt - Year value read from POST input 'yearsDt' (e.g., "2020").
  * @returns void Echoes HTML <option> elements representing months for the given year.
  */
  public function getMonth(){
  	 $yearsDt = $this->input->post('yearsDt');
  	 $data = $this->Target_model->get_DateYear('month',$yearsDt);
  	 $txtData='';
  	 foreach($data as $key => $value ){
              $dataU=$value->month;
              $date=date_create('01-'.$dataU.'-2020');
              $dayMnt=date_format($date,"F");
              $dayMnt2=date_format($date,"m");
             
              $txtData.="<option value='".$dayMnt2."'";
              if(date('F')==$dayMnt){ $txtData.="selected"; }
              $txtData.=">".$dayMnt."</option>";

    }
  	 echo $txtData;
  }

  /***********CHECk EXiST TARGET**************/
  public function checkExist()
  {
    $id = $this->input->post('data_id');
    $data_type = $this->input->post('data_type');
    $qmonth = $this->input->post('quota_month');
    $result = $this->Target_model->check_target($id,$qmonth,$data_type);
    echo $result;
  }


  /***********SAVE TARGET**************/
  public function set_target()
  {
    $id 		= $this->input->post('data_id');
    $qmonth 	= $this->input->post('quota_month');
    $data_type 	= $this->input->post('data_type');
    $data_email = $this->input->post('data_email');
    $ipAdd		= $this->input->ip_address();
	$qsales 	= str_replace(",", "",$this->input->post('sales_quota'));
	$qprofit 	= str_replace(",", "",$this->input->post('profit_quota'));
	
	if($data_type=='standard'){
    $data = array(
                  'std_user_id' 		=>$id,
				  'sess_eml' 			=>$data_email,
                  'session_comp_email' 	=>$this->session->userdata('company_email'),
                  'sales_quota' 		=>$qsales,
                  'profit_quota'		=>$qprofit,
                  'for_month'   		=>$qmonth,
                  'created_date'		=>date('d-m-Y'),
                  'updated_date'		=>date('d-m-Y'),
                  'status'      		=>1,
                  'ip'          		=>$ipAdd
                );
	}else if($data_type=='admin'){
		$data = array(
                  'admin_id' 			=>$id,
                  'sess_eml' 			=>$data_email,
                  'session_comp_email' 	=>$this->session->userdata('company_email'),
                  'sales_quota' 		=>$qsales,
                  'profit_quota'		=>$qprofit,
                  'for_month'   		=>$qmonth,
                  'created_date'		=>date('d-m-Y'),
                  'updated_date'		=>date('d-m-Y'),
                  'status'      		=>1,
                  'ip'          		=>$ipAdd
                );
		
	}
    $result = $this->Target_model->save_user_target($data);
    if($result == 200)
    {
      echo json_encode(array('st' => 200));
    }
  }

/**********Updated Target***********/

public function update_target()
  {
    $id = $this->input->post('data_id');
    $qmonth = $this->input->post('quota_month');
	$qsales 	= str_replace(",", "",$this->input->post('sales_quota'));
	$qprofit 	= str_replace(",", "",$this->input->post('profit_quota'));
    $data = array(
    	          'sales_quota' =>$qsales,
                  'profit_quota'=>$qprofit,
                  'for_month'   =>$qmonth,
                  'updated_date'=>date('d-m-Y')
                );
    $result = $this->Target_model->update_user_target($data,$id);
    
      echo json_encode(array('st' => $id ));
    
  }
/********************/

/***********Target Detail************/
/*public function getTargetUser(){
	$tblid=$this->input->post('tid');
    $list = $this->Target_model->get_detail($tblid);
    $tbltxt='';
    foreach ($list as $post)
    {
    	$tbltxt.="<tr><td>".$post->."</td><td>"

    }
}*/


/**********Delete Target*************/
  public function delete($id)
  {
    $this->Target_model->delete($id);
    echo json_encode(array("status" => TRUE));
  }

/*****************************/

	
  /**
  * Return JSON payload for DataTables containing target rows (admins and standards) with sales/profit summaries.
  * @example
  * // Call via controller (method echoes JSON directly)
  * $target = new Target();
  * $target->ajax_list(); // Outputs JSON like:
  * // {"draw":1,"recordsTotal":42,"recordsFiltered":10,"data":[["John Doe<div>...","10,000","<b>8,500</b>","2,000","<b>1,500</b>","March 2025"],["Standard A<div>...","5,000","<b>4,200</b>","1,000","<b>800</b>","February 2025"]]}
  * @param int|null $start - DataTables paging start index (read from $_POST['start']).
  * @param int|null $draw - DataTables draw counter (read from $_POST['draw']).
  * @param string|null $searchYrs - Optional year filter (read from POST 'searchYrs').
  * @param string|null $searchMnth - Optional month filter (read from POST 'searchMnth').
  * @returns void Echoes a JSON-encoded array with keys: draw, recordsTotal, recordsFiltered and data (array of table rows).
  */
  public function ajax_list()
  {
    $list = $this->Target_model->get_datatables();
	$adminlist = $this->Target_model->get_target_admin();
   $yearslct=$this->input->post('searchYrs');
   $mnthslct=$this->input->post('searchMnth');
    $data = array();
    $no = $_POST['start'];
	foreach ($adminlist as $post)
    {
    	
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      $row[] = $post->admin_name.'<div class="">
	  <a style="text-decoration:none" href="javascript:void(0)" onclick="update_target('."'".$post->id."'".',`'.$post->admin_name.'`)" class="text-primary">Update Target</a>
      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>
      </div>';
      $dataTrg=$this->Target_model->get_datatables_query_test($post->admin_email,$yearslct,$mnthslct);
      $dataU=$post->for_month;
      $date=date_create($dataU);
      $row[] = IND_money_format($post->sales_quota);
      $row[] = "<b>".IND_money_format($dataTrg['sub_totals'])."</b>";
      $row[] = IND_money_format($post->profit_quota);
      $row[] = "<b>".IND_money_format($dataTrg['profit_by_user'])."</b>";
      $row[] = date_format($date,"F Y");
      $data[] = $row;
    }
	
    foreach ($list as $post)
    {
    	
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      $row[] = $post->standard_name.'<div class="">      
       <a style="text-decoration:none" href="javascript:void(0)" onclick="update_target('."'".$post->id."'".',`'.$post->standard_name.'`)" class="text-primary">Update Target</a>
      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry('."'".$post->id."'".')" class="text-danger">Delete</a>
      </div>';
      $dataTrg=$this->Target_model->get_datatables_query_test($post->standard_email,$yearslct,$mnthslct);
      $dataU=$post->for_month;
      $date=date_create($dataU);
      $row[] = IND_money_format($post->sales_quota);
      $row[] = "<b>".IND_money_format($dataTrg['sub_totals'])."</b>";
      $row[] = IND_money_format($post->profit_quota);
      $row[] = "<b>".IND_money_format($dataTrg['profit_by_user'])."</b>";
      $row[] = date_format($date,"F Y");
      $data[] = $row;
    }

    //print_r( $data);
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Target_model->count_all(),
      "recordsFiltered" => $this->Target_model->count_filtered(),
      "data" => $data
    );
    //output to json format
    echo json_encode($output);
  }


  public function getTargetbyId()
  {
  	$id=$this->input->post('id');
    $data = $this->Target_model->get_target_by_id($id);
    echo json_encode($data);
  }



  /*******end function*******/
}