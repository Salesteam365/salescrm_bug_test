<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Massmailing_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
    }
	
  public function get_email()
  {
      $this->db->select('*');
      $this->db->from('email_from_csv');
	  $this->db->where('sent_status',0);
	  $this->db->limit(100);
      $query = $this->db->get();
      return $query->result_array();
  }	
  
	
  public function update_email($id)
  {
    $this->db->set('sent_status',1);
    $this->db->where('id',$id);
    $this->db->update('email_from_csv');
  }
  
  

// PLease write code above this
}
?>
