<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mail_model extends CI_Model
{
 
    var $table 		= 'mail_config';
	var $sort_by 	= array('invoice_no','invoice_date','billedto_orgname','client_bname','product_name','final_total',null);
	var $search_by 	= array('invoice_no','invoice_date','billedto_orgname','client_bname','product_name','final_total');
	var $order 		= array('id' => 'desc');
	
  
   private function _get_datatables_query()
   {
		$sess_eml           = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company    = $this->session->userdata('company_name');
    
        $this->db->from($this->table);
        $this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
        //$this->db->where('advanced_payment<sub_totals');     
      
      if($this->input->post('searchUser'))
      { 
		$this->db->where('sess_eml',$this->input->post('searchUser'));
      }
      
      if($this->input->post('firstDate') < $this->input->post('secondDate')){
          
          $this->db->where('invoice_date >=',$this->input->post('firstDate'));
          $this->db->where('invoice_date <=',$this->input->post('secondDate'));
          
      }else if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('invoice_date >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('invoice_date >=',$search_date);
        }
      }
	  
      $this->db->where('delete_status',1);
    
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {  
	      $searchVl=$this->input->post('search');
		 if(isset($_POST['search']['value'])) 
		  {
			$dataSearch=$_POST['search']['value'];  
		  }else{
			  $dataSearch=$searchVl;
		  }
		 
      if(isset($dataSearch)) 
      {
        if($i===0) 
        {
          $this->db->group_start(); 
          $this->db->like($item, $dataSearch);
        }else{
          $this->db->or_like($item, $dataSearch);
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
  public function get_datatables()
  {
    $this->_get_datatables_query();
    if($_POST['length'] != -1)
    $this->db->limit($_POST['length'], $_POST['start']);
    $query = $this->db->get();
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
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }  


  public function create_mail($data)
  {
    $this->db->insert("mail_config", $data);
    return $this->db->insert_id();
  }
  
   public function update_mail($id, $data)
  {
        
        $this->db->where("id", $id);
        $this->db->update("mail_config", $data);
        return $id;
  }
  
  
  
  public function get_allemail()
  {
    // old code
        // $sess_eml           = $this->session->userdata('email');
        // $session_comp_email = $this->session->userdata('company_email');
        // $session_company    = $this->session->userdata('company_name');
        // $this->db->select('*');
        // $this->db->where('session_comp_email',$session_comp_email);
        // $this->db->where('session_company',$session_company);
        // $this->db->where('status',1);
        // $this->db->where('delete_status',1);
        // if($id!=""){
        //   $this->db->where('id' ,$id);
        // }
        // $query = $this->db->get($this->table);
        // return $query->row_array();
 
        $where['session_comp_email'] = $this->session->userdata('company_email');
        $where['session_company'] = $this->session->userdata('company_name');
        $where['status'] = 1;
        $where['delete_status'] = 0;
        
        $mail_conf = $this->db->where($where)->get($this->table)->row_array();
        if(empty($mail_conf)){
          $mail_conf = $this->db->where(['default_setting'=>1])->get($this->table)->row_array();
        }
        return $mail_conf;
  }
  
  public function get_allroles_tree($prntid)
  {
    $sess_eml           = $this->session->userdata('email');
	$session_comp_email = $this->session->userdata('company_email');
	$session_company    = $this->session->userdata('company_name');  
    $this->db->select('*');
    $this->db->where('parent_role_id',$prntid);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('status',1);
    $this->db->where('delete_status',1);
    $query = $this->db->get('roles');
    return $query->result_array();
  }
  
  

  public function get_emailby_id($id)
  {
    $sess_eml           = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company    = $this->session->userdata('company_name');
    $this->db->select('*');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
	$this->db->where('id' ,$id);
	$this->db->where('status',1);
	$this->db->where('delete_status',1);
    $query = $this->db->get($this->table);
    return $query->row_array();
  }
/**********Role part end***************/

// Please Write Code Above This 
  
}