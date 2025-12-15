<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Upgrade_plan_model extends CI_Model
{
  public function getPlanList($tp='',$id='')
  {
    $this->db->from('team365_plan');
    if($tp!=""){
        $this->db->where('team365_type',$tp);
    }
    if($id!=""){
        $this->db->where('id',$id);
    }
    $this->db->where('delete_status',1);
    $query = $this->db->get();
    return $query->result_array();
  }
  
  
  
    public function Addpayment($data)
    {
      $this->db->insert('payment_details',$data);
      return $this->db->insert_id();
    }
    
    public function update_adminusers($admin_id,$data)
    {
      $this->db->where('id',$admin_id);
      return $this->db->update('admin_users',$data);
     
    }
    
    
    public function getpayement($paid,$coid){
      $this->db->select('*');
      $this->db->where('id',$paid);
      $this->db->where('company_id',$coid);
      $o = $this->db->get('payment_details');
      $response = $o->result();
    
    return $response;
        
    }
    
    public function updateLicenceDetail($planArr,$dataid){
        $this->db->where('id',$dataid);
      return $this->db->update('licence_detail',$planArr);
    } 
	public function updateExtendLicenceDetail($planArr){
		$dataid=$this->session->userdata('id');
        $this->db->where('admin_id',$dataid);
        return $this->db->update('licence_detail',$planArr);
    }
    public function addLicenceDetail($planArr){
      return $this->db->insert('licence_detail',$planArr);
    }
  
  

// Please write code above this  
}
?>
