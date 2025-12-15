<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Customreports_model extends CI_Model
{
   public function getdata($sel, $tbl, $whr = null, $grp = null,$orderby= null,$order='desc',$limit=null) {
   
        // Reset any previous selections
        $this->db->reset_query();

 if($grp == 'organization'){
    $grp = 'org_name';
 }
 else if($grp == 'user'){
    if($tbl=='Lead'){
      $grp = 'lead_owner';
 }
 else{
    $grp = 'owner';
 }
 }
        // Construct the select statement
        if ($sel !== null) {
            $this->db->select($sel);
        }
        // Add the SUM function if specified in $sel
        // Set the table to fetch data from
        $this->db->from($tbl);
        
        // Apply the WHERE clause if provided and not equal to 'all'
        if ($whr !== null) {
            $this->db->where($whr);
        }
        // Apply the GROUP BY clause if provided
        if ($grp !== null) {
            $this->db->group_by($grp);

        }
        if($orderby != null){
            $this->db->order_by($orderby,$order);
        }
        else{
            $this->db->order_by('subtotal','desc');
        }
      if($limit != null){
        $this->db->limit($limit);
      }
    
    //    $this->db->limit(20);
        // Execute the query
        $query = $this->db->get();
       
        // Return the result as an array
        return $query->result_array();
    }
    public function getcoldata($sel,$tbl,$cond){
      
        $this->db->select($sel);
        $this->db->from($tbl);
        $this->db->where($cond);
        $this->db->group_by($sel);
        return $this->db->get();
    }
    
}

?>

