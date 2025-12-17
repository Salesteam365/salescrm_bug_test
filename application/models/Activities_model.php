<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Activities_model extends CI_Model
{
  /**
  * Count total organizations for the current session/company within a given date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_all_org('2025-01-01|2025-01-31', 'filter');
  * echo $result['total_org']; // 42
  * @param {{string}} {{$currDate}} - Date or date range string. Format: 'YYYY-MM-DD' or 'YYYY-MM-DD|YYYY-MM-DD'.
  * @param {{string}} {{$fltr}} - Filter mode; use 'filter' to treat the first date as a start date, otherwise exact date match is used.
  * @returns {{array|false|null}} Array with key 'total_org' on success, false if no rows found, or null if the current user is not an admin.
  */
  public function get_all_org($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');

    if ($type == "admin") {
      $this->db->select('count("org_name") as total_org');
      $this->db->from('organization');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }

  ////////////To get count of Organization ends //////////////

  //////////// To get count of Leads starts //////////

  /**
  * Get the total number of leads for the current company (admin only) within a specific date or date range.
  * @example
  * $result = $this->Activities_model->get_leads_status('2025-01-01|2025-01-31', 'filter');
  * print_r($result); // e.g. Array ( [total_leads] => 42 ) or false if none found
  * @param {string} $currDate - Date string in 'YYYY-MM-DD' or a range 'YYYY-MM-DD|YYYY-MM-DD'.
  * @param {string} $fltr - Filter mode; pass 'filter' to treat single $currDate as a lower bound, otherwise exact date match.
  * @returns {array|false} Array with key 'total_leads' containing the count of leads, or false if no rows found.
  */
  public function get_leads_status($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("name") as total_leads');
      $this->db->from('lead');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }
  /**
  * Get leads for the current session company filtered by date and optional lead status.
  * @example
  * $result = $this->Activities_model->leads_status('filter', '2025-12-17', 'Open');
  * print_r($result); // e.g. Array ( [0] => Array ( 'id' => 123, 'lead_status' => 'Open', 'currentdate' => '2025-12-17', ... ) )
  * @param {string} $fltr - 'filter' to apply ">=" comparison on currentdate, any other value applies exact match.
  * @param {string} $currentdate - Date string to filter on (e.g. '2025-12-17').
  * @param {string} $leadStatus - Optional lead status to filter by (e.g. 'Open'). Pass empty string to ignore.
  * @returns {array} Array of lead records matching the provided filters (result_array).
  */
  public function leads_status($fltr, $currentdate = '', $leadStatus = '')
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');

    if ($fltr == 'filter') {
      $this->db->where('currentdate >=', $currentdate);
    }
    else {
      $this->db->where('currentdate', $currentdate);
    }

    if ($leadStatus != '') {
      $this->db->where('lead_status', $leadStatus);
    }
    
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_comp_email);
    $query = $this->db->get('lead');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }
  //////////////////////////////////////////////////////////////// To get count of Leads ends /////////////////////////////////////////////////////

  //////////////////////////////////////////////////////////////// To get count of Opportunities starts ///////////////////////////////////////////
  /**
  * Count opportunities for a given date or date range for the current session company.
  * @example
  * $result = $this->Activities_model->get_opp_stage('2025-01-01|2025-01-31', 'filter');
  * print_r($result); // Array ( [total_opp] => 42 ) or bool(false)
  * @param {string} $currDate - Date string or date range separated by "|" (e.g. "2025-01-01" or "2025-01-01|2025-01-31").
  * @param {string} $fltr - Filter mode; use 'filter' to treat the first date as a start date in a range, otherwise an exact date match is used.
  * @returns {array|false} Returns associative array with key 'total_opp' containing the count of opportunities, or false if no rows found.
  */
  public function get_opp_stage($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("name") as total_opp');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }


  /**
  * Get sum of 'initial_total' for opportunities for the current admin company within a given date or date range.
  * @example
  * $result = $this->Activities_model->get_opp_stage_count('2025-01-01|2025-01-31', 'filter');
  * print_r($result); // render sample output: Array ( [0] => Array ( [initial_total] => "12345.00" ) ) or bool(false)
  * @param string $currDate - Date string or date range separated by '|' (e.g. '2025-01-01' or '2025-01-01|2025-01-31').
  * @param string $fltr - Filter mode, use 'filter' when you want to apply a start-only range; otherwise treated as exact date.
  * @returns array|false Return aggregated result array on success or false when no rows found.
  */
  public function get_opp_stage_count($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select_sum('initial_total');
      $this->db->from('opportunity');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->result_array();
      } else {
        return false;
      }
    }
  }


  /**/ **
  * Retrieve opportunities matching a date and status filter for the current session company.
  * @example
  * $result = $this->Activities_model->opport_status('filter', '2025-01-01', 'Open');
  * print_r($result); // Example output: Array ( [0] => Array ( 'id' => '12', 'currentdate' => '2025-01-02', 'stage' => 'Open', 'session_company' => 'Acme Inc', 'session_comp_email' => 'info@acme.com' ) )
  * @param string $fltr - Filter mode; pass 'filter' to apply currentdate >= $currentdate, otherwise currentdate == $currentdate.
  * @param string $currentdate - Date string (e.g. 'YYYY-MM-DD') used to compare against the opportunity.currentdate field.
  * @param string $oppStatus - Opportunity stage/status to filter by (e.g. 'Open', 'Won', 'Lost').
  * @returns array Return an array of associative arrays representing matching opportunity rows for the current session's company/email.
  */*/
  public function opport_status($fltr, $currentdate = '', $oppStatus = '')
  {

    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');

    if ($fltr == 'filter') {
      $this->db->where('currentdate >=', $currentdate);
    } else {
      $this->db->where('currentdate', $currentdate);
    }
    $this->db->where('stage', $oppStatus);
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_comp_email);

    $query = $this->db->get('opportunity');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }
  ////////////////////////////////////////////// To get count of Opportunities ends//////// //////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of Quoatation starts ///////////////////////////////////////////////
  /**
  * Get count of quotes grouped by quote_stage for the current session company within a given date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_quote_stage('2025-01-01|2025-01-31', '');
  * print_r($result); // e.g. Array ( [total_quotes] => 12 [quote_stage] => 'Draft' )
  * @param {string} $currDate - Date string, either a single date "YYYY-MM-DD" or a range "YYYY-MM-DD|YYYY-MM-DD".
  * @param {string} $fltr - Filter mode; use 'filter' to query records from $currDate onward when a single date is provided, otherwise the exact date is used.
  * @returns {array|false} Returns associative array with keys 'total_quotes' and 'quote_stage' when rows found, or false if no rows.
  */
  public function get_quote_stage($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("subject") as total_quotes,quote_stage');
      $this->db->from('quote');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }
  /**
  * Retrieve quotes for the current session company filtered by date and quote stage.
  * @example
  * $result = $this->Activities_model->quote_status('filter', '2025-12-01', 'approved');
  * print_r($result); // sample output: Array ( [0] => Array ( [id] => 123 [currentdate] => 2025-12-01 [quote_stage] => approved [session_company] => "Acme Ltd" ... ) )
  * @param string $fltr - Filter mode: use 'filter' to query quotes on or after $currentdate, otherwise exact date match.
  * @param string $currentdate - Date to filter quotes by (format: YYYY-MM-DD). Optional, defaults to empty string.
  * @param string $qtStatus - Quote stage/status to match (e.g., 'approved', 'pending').
  * @returns array Return an array of result rows (associative arrays) matching the filters for the current session company.
  */
  public function quote_status($fltr, $currentdate = '', $qtStatus = '')
  {

    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');

    if ($fltr == 'filter') {
      $this->db->where('currentdate >=', $currentdate);
    } else {
      $this->db->where('currentdate', $currentdate);
    }
    $this->db->where('quote_stage', $qtStatus);
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_comp_email);
    $query = $this->db->get('quote');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }
  ////////////////////////////////////////////////////////////// To get count of Quoatation end /////////////////////////////////////////////


  ////////////////////////////////////////////////////////////// To get count of Sales starts ///////////////////////////////////////////////
  /**
   * Get the number of sales (total_sales) for a given date or date range for the current session company (admin only).
   * @example
   * $result = $this->Activities_model->get_sales_stage('2025-01-01|2025-01-31', 'filter');
   * print_r($result); // Array ( [total_sales] => 42 ) or bool(false) if no records found
   * @param string $currDate - Date string or date range separated by '|' (e.g. 'YYYY-MM-DD' or 'YYYY-MM-DD|YYYY-MM-DD').
   * @param string $fltr - Filter mode; pass 'filter' to treat the first part of $currDate as a start date, otherwise exact date or range handling applies.
   * @returns array|false Return associative array with key 'total_sales' on success, or false if no matching records.
   */
  public function get_sales_stage($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("status") as total_sales');
      $this->db->from('salesorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }

  /**
  * Retrieve sales orders filtered by date and pending percentage for the current session company.
  * @example
  * $result = $this->Activities_model->sales_status('filter', '2025-12-01', '50');
  * print_r($result); // e.g. Array ( [0] => Array ( [id] => 123 [currentdate] => 2025-12-01 [total_percent] => 50 [session_company] => "Acme Ltd" [session_comp_email] => "info@acme.com" ) )
  * @param {string} $fltr - Filter mode: use 'filter' to query currentdate >= $currentdate, any other value queries currentdate == $currentdate.
  * @param {string} $currentdate - Date string used to filter salesorder.currentdate (e.g. '2025-12-01').
  * @param {string|int} $pending - Value to match salesorder.total_percent (e.g. '50' or 50).
  * @returns {array} Return result set as an array of database rows (empty array if no matches).
  */
  public function sales_status($fltr, $currentdate = '', $pending = '')
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    if ($fltr == 'filter') {
      $this->db->where('currentdate >=', $currentdate);
    } else {
      $this->db->where('currentdate', $currentdate);
    }
    $this->db->where('total_percent', $pending);
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_company);
    $query = $this->db->get('salesorder');
    return $query->result_array();
  }

  /////////  To get count of Sales end //// /////

  ///////// /// To get count of Purchaseorders starts /////// /////

  /**
  * Get count of purchase orders for the current session company filtered by a date or date range.
  * @example
  * $result = $this->Activities_model->get_purchase('2025-01-01|2025-01-31', 'filter');
  * echo isset($result['total_purch']) ? $result['total_purch'] : 'false'; // render some sample output value; e.g. 42
  * @param {string} $currDate - Date string or date range separated by '|' (e.g. '2025-01-01' or '2025-01-01|2025-01-31').
  * @param {string} $fltr - Filter mode; 'filter' treats a single date as a start date (>=), otherwise exact date match is used.
  * @returns {array|false} Return associative array with key 'total_purch' containing the count, or false if no rows found.
  */
  public function get_purchase($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("subject") as total_purch');
      $this->db->from('purchaseorder');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_company', $session_company);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  } ////////////////////////////////////////////////////////////// To get count of Purchaseorders end /////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of Task starts ///////////////////////////////////////////////
  /**
  * Get the count of tasks for the current session company filtered by date.
  * @example
  * $result = $this->Activities_model->get_task('2025-12-01|2025-12-31', 'filter');
  * // Sample output:
  * // Array
  * // (
  * //     [total_task] => 7
  * // )
  * var_export($result); // renders sample output value above or false if no records
  * @param {string} $currDate - Date string to filter tasks. Either a single date ('YYYY-MM-DD') or a range separated by '|' ('YYYY-MM-DD|YYYY-MM-DD').
  * @param {string} $fltr - Filter mode. Pass 'filter' to treat a single date as a lower bound; any other value treats a single date as exact match.
  * @returns {array|false} Return associative array with key 'total_task' containing the count, or false if no matching rows.
  */
  public function get_task($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("task_subject") as total_task');
      $this->db->from('opp_task');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0) {
        return $query->row_array();
      } else {
        return false;
      }
    }
  }



  /**
  * Get tasks for the current company filtered by date and due status.
  * @example
  * $result = $this->Activities_model->task_status('filter', '2025-01-10', 'todaydue');
  * print_r($result); // render sample output: Array ( [0] => Array ( [task_id] => 123, [task_name] => "Call client", [task_due_date] => "2025-01-10", [status] => "open" ) )
  * @param {string} $fltr - Filter mode, use 'filter' to compare dates with greater-or-equal, otherwise exact match.
  * @param {string} $currentdate - Current date in 'YYYY-MM-DD' format used for comparisons.
  * @param {string} $duedate - Due date filter: 'todaydue', 'tomarrowdue', a status value, or empty string.
  * @returns {array} Return an array of tasks matching the provided filters.
  */
  public function task_status($fltr, $currentdate = '', $duedate = '')
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');


    if ($duedate != '' && $duedate == 'todaydue') {
      $this->db->where('task_due_date', $currentdate);
    } else if ($duedate != '' && $duedate == 'tomarrowdue') {
      $date = strtotime("+1 day", strtotime($currentdate));
      $newData = date("Y-m-d", $date);
      $this->db->where('task_due_date', $newData);
    } else {
      if ($fltr == 'filter') {
        $this->db->where('currentdate >=', $currentdate);
      } else {
        $this->db->where('currentdate', $currentdate);
      }
      $this->db->where('status', $duedate);
    }
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_comp_email);
    $query = $this->db->get('opp_task');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }


  ////////////////////////////////////////////////////////////// To get count of Task end /////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of Meeting get_call starts ///////////////////////////////////////////////
  /**
  * Retrieve count of meetings for the current session company within a date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_meeting('2025-01-01|2025-01-31', 'filter');
  * print_r($result); // Array ( [total_meeting] => 12 )
  * @param {string} $currDate - Date string "YYYY-MM-DD" or range "YYYY-MM-DD|YYYY-MM-DD".
  * @param {string} $fltr - Filter mode; use 'filter' to treat $currDate as a start date when a single date is provided, otherwise an exact date match is used.
  * @returns {array|false} Returns associative array with key 'total_meeting' when the session user is admin and records exist, otherwise false.
  */
  public function get_meeting($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("meeting_title") as total_meeting');
      $this->db->from('meeting');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0)
        return $query->row_array();
    } else {
      return false;
    }
  }



  /**
  * Get meetings filtered by date/status for the current session company and email.
  * @example
  * $result = $this->Activities_model->meeting_status('filter', '2025-12-17', 'open');
  * print_r($result); // e.g. Array ( [0] => Array ( 'id' => 12, 'from_date' => '2025-12-18', 'currentdate' => '2025-12-17', 'status' => 'open', ... ) )
  * @param {string} $fltr - Filter mode; use 'filter' to include meetings on/after $currentdate, otherwise matches exact $currentdate.
  * @param {string} $currentdate - Date string in 'Y-m-d' format used for filtering (e.g. '2025-12-17').
  * @param {string} $duedate - Either 'todayMetting' or 'tomarroeMetting' to filter by from_date, or a status value to match the status column.
  * @returns {array} Array of meeting records that match the applied filters and the current session's company/email.
  */
  public function meeting_status($fltr, $currentdate = '', $duedate = '')
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');


    if ($duedate != '' && $duedate == 'todayMetting') {
      $this->db->where('from_date', $currentdate);
    } else if ($duedate != '' && $duedate == 'tomarroeMetting') {
      $date = strtotime("+1 day", strtotime($currentdate));
      $newData = date("Y-m-d", $date);
      $this->db->where('from_date', $newData);
    } else {
      if ($fltr == 'filter') {
        $this->db->where('currentdate >=', $currentdate);
      } else {
        $this->db->where('currentdate', $currentdate);
      }
      $this->db->where('status', $duedate);
    }
    $this->db->where('session_company', $session_company);
    $this->db->where('session_comp_email', $session_comp_email);
    $query = $this->db->get('meeting');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }



  //////////////////////////////////////
  /// To get count of call end//////// /////////////////////////////////////
  ////////////////////////////////////////////////////////////// To get count of  Call starts ///////////////////////////////////////////////
  /**
  * Count calls for the current session company/email within a given date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_call('2025-06-01|2025-06-30', 'filter');
  * echo $result['total_call']; // 42
  * @param {string} $currDate - Date string or range separated by '|' (e.g. '2025-06-01' or '2025-06-01|2025-06-30').
  * @param {string} $fltr - Filter mode: when 'filter' a single date is treated as >=, otherwise a single date is matched exactly.
  * @returns {array|false|null} Associative array with key 'total_call' on success, false if the user is not admin, or null if no matching records.
  */
  public function get_call($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("call_purpose") as total_call');
      $this->db->from('create_call');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0)
        return $query->row_array();
    } else {
      return false;
    }
  }
  /**
   * Retrieve call records from the create_call table filtered by date and optional status.
   * @example
   * $result = $this->Activities_model->call_status('filter', '2025-12-01', 'open');
   * print_r($result);
   * // Sample output:
   * // Array
   * // (
   * //     [0] => Array
   * //         (
   * //             [id] => 1
   * //             [status] => open
   * //             [currentdate] => 2025-12-01
   * //             [delete_status] => 1
   * //         )
   * // )
   * @param string $fltr - Filter mode; use 'filter' to apply "currentdate >=" comparison, otherwise exact match.
   * @param string $currentdate - Date to compare against (format YYYY-MM-DD). Default is empty string.
   * @param string $prospecting - (Optional) Status value to filter by. Default is empty string.
   * @returns array Array of associative arrays representing the matched call records.
   */
  public function call_status($fltr, $currentdate = '', $prospecting = '')
  {
    if ($fltr == 'filter') {
      $this->db->where('currentdate >=', $currentdate);
    } else {
      $this->db->where('currentdate', $currentdate);
    }

    if ($prospecting != '') {
      $this->db->where('status', $prospecting);
    }

    $this->db->where('delete_status', 1);
    $query = $this->db->get('create_call');
    return $query->result_array();
  }
  ///////////////////////////////////////////////////////////
  /// To get count of call end /////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of  Vendors starts ///////////////////////////////////////////////
  /**
   * Get count of vendors for the current session company within a date or date range.
   * @example
   * // Single date (exact match)
   * $result = $this->Activities_model->get_vendors('2025-07-01', '');
   * echo $result['total_vendors']; // e.g. 5
   *
   * // Date range
   * $result = $this->Activities_model->get_vendors('2025-07-01|2025-07-31', '');
   * echo $result['total_vendors']; // e.g. 12
   *
   * // From date (filter mode)
   * $result = $this->Activities_model->get_vendors('2025-07-01', 'filter');
   * echo $result['total_vendors']; // e.g. 8
   *
   * Note: The method uses session data (company_name, company_email, email, type).
   * It only returns results for users with session type "admin".
   * @param string $currDate - Date string in 'YYYY-MM-DD' or range 'YYYY-MM-DD|YYYY-MM-DD'.
   * @param string $fltr - If set to 'filter' and $currDate is a single date, the query will use >= $currDate.
   * @returns array|false Associative array with key 'total_vendors' on success, or false if not admin or no rows found.
   */
  public function get_vendors($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("name") as total_vendors');
      $this->db->from('vendor');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0)
        return $query->row_array();
    } else {
      return false;
    }
  }
  ////////////////////////////////////////////////////////////// To get count of Vendors end /////////////////////////////////////////////

  ////////////////////////////////////////////////////////////// To get count of  Proforma invoice starts ///////////////////////////////////////////////
  /**
  * Get count of proforma invoices for the current session company (admin-only).
  * @example
  * $result = $this->Activities_model->get_proforma('2025-01-01|2025-01-31', 'filter');
  * var_export($result); // sample output: array('total_pi' => 42) or false
  * @param {string} $currDate - Date or date range separated by '|' (e.g. '2025-01-01' or '2025-01-01|2025-01-31').
  * @param {string} $fltr - Filter mode; when 'filter' and a single date is provided it queries >= start date, otherwise exact date match.
  * @returns {array|false|null} Return associative array with key 'total_pi' containing the count on success, false if the session user is not admin, or null if no matching rows.
  */
  public function get_proforma($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("page_name") as total_pi');
      $this->db->from('performa_invoice');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0)
        return $query->row_array();
    } else {
      return false;
    }
  }


  ///////// To get count of Proforma invoice end ///////////


  ///////////// To get count of  Roles starts //////////////
  /**
  * Get count of roles for the current company filtered by a date or date range (admin only).
  * @example
  * $result = $this->Activities_model->get_roles('2025-12-01|2025-12-31', 'filter');
  * echo $result['total_roles']; // e.g. 42
  * @param {string} $currDate - Date string or date range separated by '|' (e.g. 'YYYY-MM-DD' or 'YYYY-MM-DD|YYYY-MM-DD').
  * @param {string} $fltr - Filter mode; use 'filter' to treat a single date as a lower bound, otherwise an exact date match is used.
  * @returns {array|false} Associative array with key 'total_roles' on success, or false if the user is not an admin or no rows found.
  */
  public function get_roles($currDate, $fltr)
  {
    $session_comp_email = $this->session->userdata('company_email');
    $sess_eml = $this->session->userdata('email');
    $session_company = $this->session->userdata('company_name');
    $type = $this->session->userdata('type');
    if ($type == "admin") {
      $this->db->select('count("role_name") as total_roles');
      $this->db->from('roles');
      $this->db->where('session_company', $session_company);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('delete_status', 1);
      $currDateExpl = explode("|", $currDate);
      if (isset($currDateExpl[1])) {
        $this->db->where('currentdate >=', $currDateExpl[0]);
        $this->db->where('currentdate <=', $currDateExpl[1]);
      } else {
        if ($fltr == 'filter') {
          $this->db->where('currentdate >=', $currDateExpl[0]);
        } else {
          $this->db->where('currentdate', $currDateExpl[0]);
        }
      }
      $query = $this->db->get();
      if ($query->num_rows() > 0)
        return $query->row_array();
    } else {
      return false;
    }
  }



  /**
  * Retrieve roles from the "roles" table, optionally filtering by current date and role name.
  * @example
  * $result = $this->Activities_model->roles_status('2025-01-01', 'admin');
  * echo print_r($result, true); // Example output: Array ( [0] => Array ( [id] => 1 [role_name] => admin [currentdate] => 2025-01-01 [delete_status] => 0 ) )
  * @param {string} $currentdate - Optional current date filter (format: YYYY-MM-DD). Pass empty string to ignore the date filter.
  * @param {string} $rolename - Optional role name filter. Pass empty string to ignore the name filter.
  * @returns {array} Array of associative arrays representing matching roles (as returned by result_array()).
  */
  public function roles_status($currentdate = '', $rolename = '')
  {
    if ($currentdate != '') {
      $this->db->where('currentdate', $currentdate);
    }
    if ($rolename != '') {
      $this->db->where('role_name', 'Role name');
    }
    $query = $this->db->get('roles');
    $this->db->where('delete_status', 1);
    return $query->result_array();
  }
  ////////////////////////////////////////////////////////////// To get count of Roles end /////////////////////////////////////////////

  public function get_by_id()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('organization');
    return $query->result_array();
  }
  public function get_by_leads()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('lead');
    return $query->result_array();
  }
  public function lead_status($lead_id, $status)
  {
    $this->db->set('lead_status', $status);
    $this->db->where('lead_id', $lead_id);
    $query = $this->db->get('lead');
    return $query->result_array();
  }
  public function get_by_opport()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('opportunity');
    return $query->result_array();
  }
  public function get_by_quotat()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('quote');
    return $query->result_array();
  }
  public function get_by_sales()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('salesorder');
    return $query->result_array();
  }
  public function get_by_task()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('opp_task');
    return $query->result_array();
  }
  public function get_by_meeting()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('meeting');
    return $query->result_array();
  }
  public function get_by_call()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('create_call');
    return $query->result_array();
  }
  public function get_by_purch()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('purchaseorder');
    return $query->result_array();
  }
  public function get_by_vendors()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('vendor');
    return $query->result_array();
  }
  public function get_by_proforma()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('performa_invoice');
    return $query->result_array();
  }
  public function get_by_roles()
  {
    $this->db->where('currentdate', date('Y-m-d'));
    $query = $this->db->get('roles');
    return $query->result_array();
  }
  ///////Select Date Start///////
  /////////////////////

  /**
   * Build a CodeIgniter datatables query for the organization table based on session type, company/session filters, optional date filter, search input and ordering.
   * @example
   * // set session example values
   * $this->session->set_userdata([
   *   'type' => 'admin',
   *   'company_email' => 'acme@example.com',
   *   'company_name' => 'Acme Co',
   *   'email' => 'user@acme.com'
   * ]);
   * // datatable search and order example inputs
   * $_POST['search']['value'] = 'Acme';
   * $_POST['order'][0]['column'] = 1;
   * $_POST['order'][0]['dir'] = 'asc';
   * // build the query on $this->db
   * $this->Activities_model->_get_datatables_query();
   * $rows = $this->db->get()->result(); // e.g. array of stdClass objects representing organization rows
   * @param void $unused - This method does not accept parameters; it uses session and POST data.
   * @returns void Builds the active query on $this->db (no direct return value).
   */
  private function _get_datatables_query()
  {
    $sess_eml = $this->session->userdata('email');
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    if ($this->session->userdata('type') === 'admin') {
      $this->db->from('organization');
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('session_company', $session_company);
      if ($this->input->post('searchDate')) {
        $search_date = $this->input->post('searchDate');
        if ($search_date == "This Week") {
          $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
        } else {
          $this->db->where('currentdate >=', $search_date);
        }
      }
      $this->db->where('delete_status', 1);
    } elseif ($this->session->userdata('type') === 'standard') {
      $this->db->from('organization');
      $this->db->where('sess_eml', $sess_eml);
      $this->db->where('session_comp_email', $session_comp_email);
      $this->db->where('session_company', $session_company);
      if ($this->input->post('searchDate')) {
        $search_date = $this->input->post('searchDate');
        if ($search_date == "This Week") {
          $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
        } else {
          $this->db->where('currentdate >=', $search_date);
        }
      }
      $this->db->where('delete_status', 1);
    }
    $i = 0;
    foreach ($this->search_by as $item) // loop column
    {
      if ($_POST['search']['value']) // if datatable send POST for search
      {
        if ($i === 0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }
        if (count($this->search_by) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }
    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }
}
