<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pipeline_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->db->query('SET SESSION sql_mode =REPLACE(REPLACE(REPLACE(
                  @@sql_mode,"ONLY_FULL_GROUP_BY,", ""),",ONLY_FULL_GROUP_BY", ""),"ONLY_FULL_GROUP_BY", "")');
    }
    
    
 
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