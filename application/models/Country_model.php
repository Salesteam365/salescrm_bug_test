<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Country_model extends CI_Model
{
  private $_countryName;
  public function setCountryName($country_id)
  {
    return $this->_countryName = $country_id;
  }
  public function get_countries($name)
  {
        $this->db->like('name', $name, 'after' );
		$this->db->order_by('name', 'ASC');
		$this->db->limit(5);
		return $this->db->get('countries')->result();
  }
  public function get_states($name,$country_id)
  {
        $this->db->like('name', $name , 'after');
        $this->db->where('country_id',$country_id);
		$this->db->order_by('name', 'ASC');
		$this->db->limit(5);
		return $this->db->get('states')->result();
  }
  public function get_cities($name,$state_id)
  {
        $this->db->like('name', $name , 'after');
        $this->db->where('state_id',$state_id);
		$this->db->order_by('name', 'ASC');
		$this->db->limit(5);
		return $this->db->get('cities')->result();
  }
  
  public function get_statesbytin($tin)
  {
        $this->db->where('tin',$tin);
		return $this->db->get('states')->row_array();
  }
  public function get_countrybyid($countryid)
  {
        $this->db->where('id',$countryid);
		return $this->db->get('countries')->row_array();
  }
}
?>
