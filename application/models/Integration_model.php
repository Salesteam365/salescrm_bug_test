<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Integration_model extends CI_Model
{
 
  
  public function create($data)
  {
    $this->db->insert('api_detail', $data);
    return $this->db->insert_id();
  }
  
  public function get_googleads_cron($apiName)
  {
    $this->db->from('api_detail');
    $this->db->where('api_name',$apiName);
	$this->db->where('delete_status',1);
	$this->db->where('status',1);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  
  public function get_googleads($apiName)
  {
	$session_company 	= $this->session->userdata('company_name');
	$session_comp_email = $this->session->userdata('company_email');  
    $this->db->from('api_detail');
    $this->db->where('api_name',$apiName);
	$this->db->where('session_company',$session_company);
	$this->db->where('session_comp_email',$session_comp_email);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  
  public function update_key($data,$id)
  {
    $this->db->where('id',$id);
	$this->db->update('api_detail', $data);
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
  
  public function get_googleads_with_key($urlkey)
  {  
    $this->db->from('api_detail');
    $this->db->where('api_name','google ads');
	$this->db->where('api_key',$urlkey);
    $query = $this->db->get();
    return $query->row_array();
  }
  
  
  
}
?>