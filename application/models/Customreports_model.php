<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Customreports_model extends CI_Model
{
   /**
   * Retrieve rows from a table with optional select, where, group by, order and limit using CodeIgniter's query builder.
   * @example
   * $result = $this->Customreports_model->getdata('SUM(amount) as subtotal, org_name', 'invoices', ['status' => 'paid'], 'organization', 'subtotal', 'desc', 10);
   * print_r($result); // Example output: Array ( [0] => Array ( [subtotal] => "12500.00" [org_name] => "Acme Corp" ) )
   * @param {string|null} $sel - Columns or expressions to select (e.g. 'SUM(amount) as subtotal, org_name').
   * @param {string} $tbl - Table name to query (e.g. 'invoices').
   * @param {array|string|null} $whr - Optional WHERE clause as associative array or SQL string (e.g. ['status' => 'paid']).
   * @param {string|null} $grp - Optional group key. Accepts 'organization' (mapped to 'org_name'), 'user' (mapped to 'lead_owner' for Lead table or 'owner' otherwise) or an explicit column name.
   * @param {string|null} $orderby - Optional column to order by (defaults to 'subtotal' when not provided).
   * @param {string} $order - Sort direction, 'asc' or 'desc' (default 'desc').
   * @param {int|null} $limit - Optional limit on number of rows to return.
   * @returns {array} Result set as an array of associative arrays (rows).
   */
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

