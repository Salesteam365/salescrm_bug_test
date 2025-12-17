<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pipeline_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->db->query('SET SESSION sql_mode =REPLACE(REPLACE(REPLACE(
                  @@sql_mode,"ONLY_FULL_GROUP_BY,", ""),",ONLY_FULL_GROUP_BY", ""),"ONLY_FULL_GROUP_BY", "")');
    }
    
    
 
  /**
   * Get aggregated pipeline values grouped by month for the current company (and current user when session type is "standard"), applying optional POST filters (filterYear, searchDate, filterStage, filterFrom/filterTo).
   * @example
   * $CI =& get_instance();
   * $CI->load->model('Pipeline_model');
   * $result = $CI->Pipeline_model->get_pipeline_value();
   * // Example returned value:
   * // [
   * //   (object) ['id' => 1, 'month_name' => 'January', 'sub_total' => '1500.00', 'weighted_revenue' => '750.00'],
   * //   (object) ['id' => 2, 'month_name' => 'February', 'sub_total' => '2000.00', 'weighted_revenue' => '1200.00']
   * // ]
   * @returns {array|false} Array of result objects (each with id, month_name, sub_total, weighted_revenue) when records exist, or false when no records found.
   */
  public function get_pipeline_value(){
	  
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
	  $type = $this->session->userdata('type');
      $this->db->select('id,MONTHNAME(currentdate) as month_name');
	  $this->db->select_sum('sub_total');
	  $this->db->select_sum('weighted_revenue');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
	if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');     
      $this->db->where('sess_eml',$sess_eml);
      
    }
    if($this->input->post('filterYear'))
    {
	   $filteryear = $this->input->post('filterYear');
	   $this->db->where('YEAR(currentdate)',$filteryear);
	}else{
      $this->db->where('YEAR(currentdate)',date('Y'));
	}
	if($this->input->post('searchDate'))
    {
	   $searchDate = $this->input->post('searchDate');
	   $this->db->where('currentdate >=',$searchDate);
	
    }
    if($this->input->post('filterStage')!='')
    {
	  $filterStage = $this->input->post('filterStage');
      $this->db->where('stage',$filterStage);
    }
    if($this->input->post('filterFrom') && $this->input->post('filterTo'))
    {
	   $filterFrom = $this->input->post('filterFrom');
	   $filterTo   = $this->input->post('filterTo');
       $this->db->where('currentdate >=', $filterFrom);
       $this->db->where('currentdate <=', $filterTo);
    } 
	
	
	  $this->db->where('delete_status',1);      
      $this->db->group_by('MONTH(currentdate)');	  
	 
      //get records
      $query = $this->db->get('opportunity');
      
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
}

/**
* Retrieve pipeline funnel totals grouped by stage for the current session/company, honoring optional POST filters (searchDate, filterStage, filterFrom/filterTo) and user type scoping.
* @example
* $result = $this->Pipeline_model->get_pipeline_funnel();
* // sample returned value (array of stdClass objects):
* // [
* //   (object) ['id' => '1', 'stage' => 'Prospect', 'sub_total' => '12500.00'],
* //   (object) ['id' => '2', 'stage' => 'Qualified', 'sub_total' => '8400.50']
* // ]
* var_dump($result);
* @param void $none - No arguments. Method uses session and POST data for scoping and filters.
* @returns array|false Returns an array of result objects (fields: id, stage, sub_total) grouped by stage, or false if no records are found.
*/
public function get_pipeline_funnel(){
	  
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
	  $type = $this->session->userdata('type');
      $this->db->select('id,stage');
	  $this->db->select_sum('sub_total');	  
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
	if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');     
      $this->db->where('sess_eml',$sess_eml);
      
    }
    
	if($this->input->post('searchDate'))
    {
	   $searchDate = $this->input->post('searchDate');
	   $this->db->where('currentdate >=',$searchDate);
	
    }
    if($this->input->post('filterStage'))
    {
	  $filterStage = $this->input->post('filterStage');
      $this->db->where('stage',$filterStage);
    }
    if($this->input->post('filterFrom') && $this->input->post('filterTo'))
    {
	   $filterFrom = $this->input->post('filterFrom');
	   $filterTo   = $this->input->post('filterTo');
       $this->db->where('currentdate >=', $filterFrom);
       $this->db->where('currentdate <=', $filterTo);
    } 

	  $this->db->where('stage !=',''); 
	  $this->db->where('delete_status',1);      
      $this->db->group_by('stage');	  
	 
      //get records
      $query = $this->db->get('opportunity');
      
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
}

  /**
  * Retrieve aggregated pipeline funnel data for a given stage.
  * @example
  * $result = $this->Pipeline_model->get_pipeline_funnel_byStage('Proposal');
  * print_r($result); // sample output: stdClass Object ( [id] => 12 [stage] => Proposal [total_oppo] => 3 [sub_total] => 4500 )
  * @param {string} $stage - Stage name to filter pipeline results (e.g. 'Qualification', 'Proposal', 'Negotiation').
  * @returns {object|false} Return an object containing id, stage, total_oppo and sub_total when records exist; returns false if no records found.
  */
  public function get_pipeline_funnel_byStage($stage){
	  $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
	  $type = $this->session->userdata('type');
      $this->db->select('id,stage,COUNT(id) as total_oppo');
	  $this->db->select_sum('sub_total');	  
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
	if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');     
      $this->db->where('sess_eml',$sess_eml);
      
    }
	$this->db->where('stage',$stage);
    $this->db->where('delete_status',1);      
    
      //get records
      $query = $this->db->get('opportunity');
      
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->row();
      }
      else
      {
        return false;
      }  
  }

  /**
  * Retrieve pipeline activity grouped by current date for the current session/company with optional filters (year, date range, stage).
  * @example
  * $this->load->model('Pipeline_model');
  * $result = $this->Pipeline_model->get_pipeline_activity();
  * // Example returned value (array of objects) on success:
  * // [
  * //   (object)[
  * //     'id' => 1,
  * //     'month_name' => '3',
  * //     'stage' => 'Negotiation',
  * //     'expclose_date' => '2025-06-01',
  * //     'name' => 'Deal A',
  * //     'sub_total' => '1500.00'
  * //   ],
  * //   ...
  * // ]
  * var_dump($result);
  * @param void No parameters.
  * @returns array|false Returns an array of result objects grouped by currentdate on success, or false if no records found.
  */
  public function get_pipeline_activity()
  {
	  
      $session_company = $this->session->userdata('company_name');
      $session_comp_email = $this->session->userdata('company_email');
	  $type = $this->session->userdata('type');
      $this->db->select('id,MONTH(currentdate) as month_name,stage,expclose_date,name');
	  $this->db->select_sum('sub_total');
	  
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
	if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');     
      $this->db->where('sess_eml',$sess_eml);
      
    }
    if($this->input->post('filterYear'))
    {
	   $filteryear = $this->input->post('filterYear');
	   $this->db->where('YEAR(currentdate)',$filteryear);
	}else{
      $this->db->where('YEAR(currentdate)',date('Y'));
	}
	if($this->input->post('searchDate'))
    {
	   $searchDate = $this->input->post('searchDate');
	   $this->db->where('currentdate >=',$searchDate);
	
    }
    if($this->input->post('filterStage'))
    {
	  $filterStage = $this->input->post('filterStage');
      $this->db->where('stage',$filterStage);
    }
    if($this->input->post('filterFrom') && $this->input->post('filterTo'))
    {
	   $filterFrom = $this->input->post('filterFrom');
	   $filterTo   = $this->input->post('filterTo');
       $this->db->where('currentdate >=', $filterFrom);
       $this->db->where('currentdate <=', $filterTo);
    } 
	
	  $this->db->where('expclose_date !=','');
	  $this->db->where('delete_status',1);  
      //$this->db->distinct();	  
      $this->db->group_by('currentdate');	  
	 
      //get records
      $query = $this->db->get('opportunity');
      
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
  }

  
  /**
  * Get monthly lead counts for the current year filtered by user/company based on the report type.
  * @example
  * $result = $this->Pipeline_model->get_report_leads_by_user('standard');
  * print_r($result); // Example output: Array ( [0] => stdClass Object ( [id] => 1 [month_name] => "January" [total_deals] => "10" ) )
  * @param {{string}} {{$type}} - Report type. Use 'standard' to filter by the current logged-in user, or 'admin' to get company-wide results.
  * @returns {{mixed}} Returns an array (or result object list) of monthly totals on success, or false if no records are found.
  */
  public function get_report_leads_by_user($type)
  {
    $y = strtotime('-1day');
    $x = date('d',$y);
    $w = strtotime('-'.$x.'day');
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,MONTHNAME(currentdate) as month_name,count("id") as total_deals');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
      
    }else if($type=="admin")
    {
      
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    }
     // $this->db->where('session_comp_email',$session_comp_email);
     // $this->db->where('session_company',$session_company);
      $this->db->where('YEAR(currentdate)',date('Y'));
	  $this->db->where('delete_status',1);      
      $this->db->group_by('MONTH(currentdate)');
	  //$this->db->group_by('YEAR(currentdate)');
	 
      //get records
      $query = $this->db->get('opportunity');
      //echo $this->db->last_query();die;
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  
  
  /**
   * Retrieve deal counts grouped by month for the current company (and optionally current user), with optional date and stage filters.
   * @example
   * $result = $this->Pipeline_model->get_all_deals_by_date('standard', '2025-01-01', '2025-01-01', '2025-12-31', 2025, 'Negotiation');
   * print_r($result); // Example output: [ (object) ['id' => 1, 'month_name' => 'January', 'total_deals' => 5], ... ] or bool(false) if no records
   * @param {string} $type - 'standard' to filter by the logged-in user and company, 'admin' to filter by company only.
   * @param {string} $date - (optional) Minimum currentdate to include (YYYY-MM-DD). Pass '' to ignore.
   * @param {string} $from_date - (optional) Start date for a date range (YYYY-MM-DD). Requires $to_date to be effective.
   * @param {string} $to_date - (optional) End date for a date range (YYYY-MM-DD).
   * @param {int|string} $date_year - (optional) Year to filter results by (e.g. 2025).
   * @param {string} $deal_stage - (optional) Deal stage to filter by (e.g. 'Closed Won').
   * @returns {array|false} Returns an array of result objects (fields: id, month_name, total_deals) grouped by month on success, or false if no records found.
   */
  public function get_all_deals_by_date($type,$date='',$from_date='',$to_date='',$date_year='',$deal_stage='')
  {
    $session_company = $this->session->userdata('company_name');
    $session_comp_email = $this->session->userdata('company_email');
    $this->db->select('id,MONTHNAME(currentdate) as month_name,count("id") as total_deals');
    if($type=="standard")
    {
      $sess_eml = $this->session->userdata('email');
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
      $this->db->where('sess_eml',$sess_eml);
    }else if($type=="admin")
    {
      $this->db->where('session_comp_email',$session_comp_email);
      $this->db->where('session_company',$session_company);
    } 
    if($date !="")
    {
      $this->db->where('currentdate >=',$date);
    }
    
    if($from_date !="" && $to_date !="")
    {
       $this->db->where('currentdate >=', $from_date);
       $this->db->where('currentdate <=', $to_date);
    } 
	if($date_year !="")
    {
      $this->db->where('YEAR(currentdate)',$date_year);
    }
	if($deal_stage !="")
    {
      $this->db->where('stage',$deal_stage);
    }
     $this->db->where('delete_status ', 1);
     $this->db->group_by('MONTH(currentdate)');
	  //$this->db->group_by('YEAR(currentdate)');
	 
      //get records
      $query = $this->db->get('opportunity');
      // check no. of records
      if($query->num_rows() > 0)
      {
        //return result
        return $query->result();
      }
      else
      {
        return false;
      }
    
  }
  
 
  
  
  
//Please write code above this
}
?>