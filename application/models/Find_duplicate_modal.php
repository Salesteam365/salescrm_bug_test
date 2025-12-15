<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Find_duplicate_modal extends CI_Model
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
    

   public function getTable(){
	   
	   $tables = $this->db->list_tables();
	   return  $tables;
   }
   
   public function getField($table_name){
	   $fields = $this->db->field_data($table_name);
	   return  $fields;
   }
  
 public function find_duplicate_data($tableName,$clmname){
	$sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
	
	$columnName=implode(',',$clmname);
	$this->db->select($columnName.', COUNT(*)');
	$this->db->from($tableName);
	if($this->session->userdata('type')==='standard'){
	$this->db->where('sess_eml',$sess_eml);
	}
	
    $this->db->where('delete_status',1);
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
	$this->db->group_by($columnName);
	$this->db->having('COUNT(*) >','1');
	
	$query = $this->db->get();
    return $query->result_array();
}

public function find_data($tableName,$clmname,$value){
	
	$sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
	
	$columnName=implode(',',$clmname);
	$this->db->select('*');
	$this->db->from($tableName);
	if($this->session->userdata('type')==='standard'){
	$this->db->where('sess_eml',$sess_eml);
	}
    $this->db->where('session_company',$session_company);
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('delete_status',1);
	
	for($i=0; $i<count($clmname); $i++){
		$this->db->where($clmname[$i],$value[$i]);
	}
	$query = $this->db->get();
    return $query->result_array();
}
  
public function delete_data($tblName,$rowid,$data){
	$this->db->where('id', $rowid);
    $update=$this->db->update($tblName, $data);
	if($update){
        return true;
    }else{
        return false;
    }
}

// Please Write Code Above This  
}
?>
