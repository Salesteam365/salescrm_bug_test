<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model
{

     public function __construct(){
         parent::__construct();
         $this->db->query('SET SESSION sql_mode =  REPLACE(REPLACE(REPLACE(
                  @@sql_mode,
                  "ONLY_FULL_GROUP_BY,", ""),
                  ",ONLY_FULL_GROUP_BY", ""),
                  "ONLY_FULL_GROUP_BY", "")');
     }
	
	public function get_pro_name($product_name)
	{
		$sess_eml 			= $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company 	= $this->session->userdata('company_name');
		
		//$this->db->from('product');
		$this->db->like('product_name', $product_name , 'both');
		//$this->db->where('sess_eml',$sess_eml);
		$this->db->where('session_company',$session_company);
		$this->db->where('session_comp_email',$session_comp_email);
		$this->db->order_by('product_name', 'ASC');
		$this->db->limit(5);
		return $this->db->get($this->table)->result();
    }
  public function getProValue($product_name)
  {
    $response = array();
    if($product_name['product_name'])
    {
      $sess_eml 			= $this->session->userdata('email');
	  $session_comp_email = $this->session->userdata('company_email');
	  $session_company 	= $this->session->userdata('company_name');  
        
      $this->db->select('*');
      $this->db->where('session_company',$session_company);
	  $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('product_name',$product_name['product_name']);
      $o = $this->db->get('product');
      $response = $o->result_array();
    }
    return $response;
  } 
  

	 
  var $table = 'product';
  var $sort_by = array(null,'product_name','sku','hsn_code','product_category',null,'product_unit_price','product_quantity','stock_alert',null);
  
  var $search_by = array('product_name','sku','hsn_code','product_category','product_unit_price','product_quantity','stock_alert');
  var $order = array('id' => 'desc');
  
  private function _get_datatables_query()
  {
    $sess_eml 			= $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      $this->db->select('*');
      $this->db->from('product');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
    }
    elseif($this->session->userdata('type')==='standard')
    {
      $this->db->from($this->table);
      $this->db->where('sess_eml',$sess_eml);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      $this->db->where('delete_status',1);
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
	$session_comp_email = $this->session->userdata('company_email');
    $session_company 	= $this->session->userdata('company_name');
    $this->db->from('product');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    return $this->db->count_all_results();
  }
  
  

	public function insertData($dataArr)
	{
		
        if($this->db->insert('product', $dataArr))
        {
          return $this->db->insert_id();
        }
        else
        {
          return 202;
        }

    }
	
	public function product_id($pro_id,$id)
    {
		$data = array('product_id' => $pro_id);
		$this->db->where('id',$id);
		if($this->db->update('product',$data))
		{
		  return true;
		}
		else
		{ 
		  return false;
		}
    }
	public function updateData($data,$id){
		$this->db->where('id',$id);
		if($this->db->update('product',$data))
		{
		  return $id;
		}
		else
		{ 
		  return 0;
		}
	}

	public function getById($id){
		
		$sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
  
		$this->db->from('product');
		$this->db->select('*');
		$this->db->where('id',$id);
		$this->db->where('session_company',$session_company);
		$this->db->where('session_comp_email',$session_comp_email);
		if($this->session->userdata('type') == 'standard')
		{
		$this->db->where('sess_eml',$sess_eml);
		}
		
		$query = $this->db->get();
		return $query->result();
	}
	
	
public function delete($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  public function delete_bulk($id)
  {
    $this->db->set('delete_status',2);
    $this->db->where('id', $id);
    $this->db->update($this->table);
  }
  public function get_by_id($id)
  {
    $this->db->from($this->table);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row();
  }
  
  
  public function check_duplicate_product($proName,$price,$sku)
  {
    $this->db->select('product_name,sku,product_unit_price');
    $this->db->from($this->table);
    $this->db->where('product_name',$proName);
    $this->db->where('product_unit_price',$price);
	$this->db->where('sku',$sku);
	$this->db->where('delete_status',1);
	$sess_eml 			= $this->session->userdata('email');
	$session_comp_email = $this->session->userdata('company_email');
	$session_company 	= $this->session->userdata('company_name');
	$this->db->where('session_comp_email',$session_comp_email);
	$this->db->where('session_company',$session_company);
	
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->row_array();
    }
    else
    {
      return false;
    }
  }

  public function mass_save($mass_id, $dataArry)
  {
  //  print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('product', $dataArry)){
		  return true;
		}else{
      return false;
    }
   


  }
  


}