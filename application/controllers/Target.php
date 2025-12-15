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