<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Target_model extends CI_Model
{

     public function __construct(){
         parent::__construct();
         $this->db->query('SET SESSION sql_mode =
                  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
     }
	 


	public function save_user_target($dataArr)
	{
        if($this->db->insert('std_user_target', $dataArr))
        {
          return 200;
        }
        else
        {
          return 202;
        }

    }

  public function delete($id)
  {
    $this->db->set('status',0);
    $this->db->where('id', $id);
	$this->db->update('std_user_target');
  }


/*##########CHECK EXIST##########*/
public function check_target($tgtid,$mnth,$data_type){
	if($data_type=='admin'){
		$this->db->where('admin_id' , $tgtid);
	}else{
      $this->db->where('std_user_id' , $tgtid);
	}
      $this->db->where('for_month' , $mnth);
      $session_comp_email = $this->session->userdata('company_email');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('status' , 1);
      $query = $this->db->get('std_user_target');
      if($query->num_rows()>0)
      {
        return true;
      }else
      {
        return false;
      }

}

public function get_detail($userid){
	$this->db->select('*');
    $this->db->from("std_user_target");
     $this->db->where('id',$userid);
     $session_comp_email = $this->session->userdata('company_email');
      $this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get();
    return $query->result();
}


	/*********Update Query Target**********/
	public function update_user_target($dataArr,$tid){
	   $this->db->where('id',$tid);
	   $this->db->update('std_user_target', $dataArr);
    }

    public function getuserdataTarget()
	{
	    $type = $this->session->userdata('type');
	    $sess_eml = $this->session->userdata('email');
	    if($type == 'admin')
	    {
	      $this->db->select('*');
	      $this->db->where('admin_email',$sess_eml);
	      $this->db->from("admin_users");
	    }
	    else
	    {
	      $this->db->select('standard.*,admin.company_logo as company_logo');
	      $this->db->from("standard_users as standard");
	      $this->db->join('admin_users as admin','admin.company_email=standard.company_email');
	      $this->db->where('standard_email',$sess_eml);
	      
	    }
	    $query = $this->db->get();
	    return ($query->num_rows() > 0)?$query->result_array():FALSE;
	}

     
     var $table = 'std_user_target';
     var $sort_by = array('standard_name',null);
     var $search_by = array('standard_name');
     var $order = array('std_user_target.id' => 'desc');
private function _get_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    //$this->db->from($this->table);

    $this->db->select('standard.standard_name,standard.standard_email,std_user_target.id,std_user_target.sales_quota,std_user_target.profit_quota,std_user_target.for_month,std_user_target.status');
    $this->db->from("std_user_target");
    $this->db->join('standard_users as standard','std_user_target.std_user_id=standard.id');
    $this->db->where('std_user_target.session_comp_email',$session_comp_email);
    $this->db->where('standard.company_name',$session_company);

// New Code......
      $this->db->where('std_user_target.status',"1");
      if($this->input->post('searchYrs'))
      { 
        $search_yrs = $this->input->post('searchYrs');
        $this->db->where('YEAR(std_user_target.for_month)',$search_yrs);
      }
      if($this->input->post('searchMnth'))
      { 
        $search_Mnth = $this->input->post('searchMnth');
        $this->db->where('MONTH(std_user_target.for_month)',$search_Mnth);
      }
      else
      {
      	$this->db->where('std_user_target.for_month',date('Y-m-01'));
      }


    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->search_by) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    
    if(isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order))
    {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }

  }
  
  
    var $sort_by_ad = array('admin_name',null);
    var $search_by_ad = array('admin_name');
    var $order_ad = array('std_user_target.id' => 'desc');
	 
  public function get_target_admin()
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
   
    $this->db->select('admin.admin_name,admin.admin_email,std_user_target.id,std_user_target.sales_quota,std_user_target.profit_quota,std_user_target.for_month,std_user_target.status');
    $this->db->from("std_user_target");
    $this->db->join('admin_users as admin','std_user_target.admin_id=admin.id');
   
      $this->db->where('std_user_target.status',"1");
      if($this->input->post('searchYrs'))
      { 
        $search_yrs = $this->input->post('searchYrs');
        $this->db->where('YEAR(std_user_target.for_month)',$search_yrs);
      }
      if($this->input->post('searchMnth'))
      { 
        $search_Mnth = $this->input->post('searchMnth');
        $this->db->where('MONTH(std_user_target.for_month)',$search_Mnth);
      }
      else
      {
      	$this->db->where('std_user_target.for_month',date('Y-m-01'));
      }
      
    $this->db->where('std_user_target.session_comp_email',$session_comp_email);
    //$this->db->where('standard.company_name',$session_company);

  
    $i = 0;
    foreach ($this->search_by_ad as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); 
          $this->db->like($item, $_POST['search']['value']);
        }
        else
        {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if(count($this->search_by_ad) - 1 == $i) //last loop
        $this->db->group_end(); //close bracket
      }
      $i++;
    }
    
    if(isset($_POST['order'])) 
    {
      $this->db->order_by($this->sort_by_ad[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    }
    else if(isset($this->order_ad))
    {
      $order = $this->order_ad;
      $this->db->order_by(key($order), $order[key($order)]);
    }

   $query = $this->db->get();
    return $query->result();
  }



/* code for display user target......03.10.20.......*/

  public function get_datatables_query_test($standard_email,$yearslct,$mnthslct)
  {
    
// New Code......
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $type = $this->session->userdata('type');
    $this->db->select_sum('so.sub_totals');
    $this->db->select_sum('so.profit_by_user');
    $this->db->from('salesorder as so');
    $this->db->join('purchaseorder as PO','PO.saleorder_id=so.saleorder_id');
    $this->db->where('so.sess_eml',$standard_email);
    $this->db->where('so.delete_status',1);
    $this->db->where('PO.delete_status',1);
    if($type == "admin")
    {
      $this->db->where('so.session_company',$session_company);
      $this->db->where('so.session_comp_email',$session_comp_email);
      $this->db->where('so.status','Approved');
      $this->db->group_by('so.owner');
    }
    else if($type == "standard")
    {
      $this->db->where('so.session_company',$session_company);
      $this->db->where('so.session_comp_email',$session_comp_email);
      $this->db->where('so.sess_eml', $sess_eml);
      $this->db->group_by('so.status');
    }
// New Code......
        $a_date = $yearslct."-".$mnthslct."-01";
        $lastday=date("Y-m-t", strtotime($a_date)); 
        $this->db->where('PO.currentdate>=',$a_date);
        $this->db->where('PO.currentdate<=',$lastday);
        $query = $this->db->get();
        $resultArr=$query->result();
        if($resultArr){
        foreach ($resultArr as $key => $value) {
          $dataArr=array( 
            'sub_totals'=>$value->sub_totals,
            'profit_by_user'=>$value->profit_by_user
          );
        }

      }else{
        $dataArr=array( 
            'sub_totals'=>"00.00",
            'profit_by_user'=>"00.00"
          );
      }
     return $dataArr;
  }




  public function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
    //echo $this->db->last_query();die;
    return $query->result();
  }
  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  public function count_all()
  {
	$session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->from($this->table);
    $this->db->where('session_comp_email',$session_comp_email);
    return $this->db->count_all_results();
  }

public function get_DateYear($value='',$dataVl='')
{
	if($value=='year'){
		$this->db->select('YEAR(for_month) as month');
		$this->db->order_by("month desc");
	}else{
		$this->db->select('MONTH(for_month) as month');
		if(!empty($dataVl)){
			$this->db->where('YEAR(for_month)',$dataVl);
		}
		$this->db->order_by("month asc");
	}
	$this->db->distinct();
    $this->db->from("std_user_target");
    
    $query = $this->db->get();
    return $query->result();
}


 public function get_target_by_id($id)
  {
    $this->db->from('std_user_target');
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }


}