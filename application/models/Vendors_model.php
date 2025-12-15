<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vendors_model extends CI_Model
{
  var $table = 'organization';
  var $sort_by = array(null,'org_name','email','website','mobile','billing_city',null);
  var $search_by = array('org_name','email','website','mobile','customer_type','assigned_to');
  var $order = array('id' => 'desc');
  private function _get_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if($this->session->userdata('type')==='admin')
    {
      //$this->db->from($this->table);
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      if($this->input->post('searchDate'))
      { 
        $search_date = $this->input->post('searchDate');
        if($this->input->post('fromDate') && $this->input->post('toDate')){
          $this->db->where('currentdate >=',$this->input->post('fromDate'));
          $this->db->where('currentdate <=',$this->input->post('toDate'));
        }else if($search_date == "This Week")
        {
          $this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
        }
        else
        {
          $this->db->where('currentdate >=',$search_date);
        }
      }
      
    }
    elseif($this->session->userdata('type')==='standard')
    {
      //$this->db->from($this->table);
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
      
    }
      $this->db->where('delete_status',1);
      $this->db->group_start();
      $this->db->where('customer_type', 'Vendor');
      $this->db->or_where('customer_type', 'Both');
      $this->db->group_end();
    
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if($_POST['search']['value']) // if datatable send POST for search
      {
        if($i===0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
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
    $query = $this->db->get('organization');
    return $query->result();
  }
  public function count_filtered()
  {
    $this->_get_datatables_query();
    $query = $this->db->get('organization');
    return $query->num_rows();
  }
  public function count_all()
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from('organization');
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->group_start();
    $this->db->where('customer_type', 'Customer');
    $this->db->or_where('customer_type', 'Both');
    $this->db->group_end();
    return $this->db->count_all_results();
  }
  public function create($data)
  {
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
  }
  public function get_by_id($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');  
    $this->db->from($this->table);
    $this->db->where('id',$id);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $query = $this->db->get();
    return $query->row();
  }
  
  public function get_vendor_by_id($id)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');  
    $this->db->from($this->table);
	$this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$id);
    $query = $this->db->get();
    return $query->row_array();
  }
  public function get_purchase_order($vendor_name)
  {
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');  
    $this->db->from('purchaseorder');
    $this->db->where('supplier_comp_name',$vendor_name);
	$session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name'); 
    $query = $this->db->get();
    return $query->result_array();
  }
  
   public function VenForCon($id)
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select("name");
    $this->db->where('id',$id);
    $this->db->from($this->table);
    $query = $this->db->get();
    return $query->row()->name;
  }
  public function getByVen($name)
  {
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select("*");
    $this->db->where('org_name',$name);
    $this->db->from("contact");
    $query = $this->db->get();
    return ($query->num_rows() > 0)?$query->result_array():FALSE;
  }
  public function vendor_id($vendor_id,$id)
  {
    $data = array('vendor_id' => $vendor_id);
    $this->db->where('id',$id);
    if($this->db->update($this->table,$data))
    {
      return true;
    }
    else
    { 
      return false;
    }
  }
  public function update($where,$data)
  {
    if($this->session->userdata('type') == 'admin')
    {
      $this->db->update($this->table, $data, $where);
    }
    else
    {
      $this->db->where('sess_eml',$this->session->userdata('email'));
      $this->db->update($this->table, $data, $where);
    }
    return $this->db->affected_rows();
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

// PLease write code above this
}
?>
