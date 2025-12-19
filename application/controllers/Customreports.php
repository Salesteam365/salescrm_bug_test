<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customreports extends CI_Controller {

    /**
    * Initializes the Customreports controller: verifies admin session and loads required helpers, models and libraries.
    * @example
    * // Example when the current session user is an admin:
    * $this->session->set_userdata('type', 'admin');
    * $controller = new Customreports();
    * // Result: helpers, models (Invoice_model, vendors_model, Organization_model, Salesorders_model, Contact_model, Login_model, Reports_model, customreports_model, Activities_model) and the excel library are loaded; no redirect occurs.
    * // Example when the current session user is not an admin:
    * $this->session->set_userdata('type', 'user');
    * $controller = new Customreports();
    * // Result: user is redirected to 'home'.
    * @param {void} $none - No parameters required for the constructor.
    * @returns {void} No return value; controller initialization side-effects are performed (loads resources or redirects).
    */
    public function __construct()
	{
		parent::__construct();
        if($this->session->userdata('type') != 'admin'){
            redirect('home');
        }
		$this->load->helper('url');
        $this->load->model(array('Invoice_model','vendors_model','organization_model','Base_model'));
		$this->load->model('Organization_model','Organization');
        $this->load->model('Salesorders_model', 'Salesorders');
		$this->load->model('Contact_model','Contact');
		$this->load->model('Login_model','Login');
		$this->load->model('Reports_model','Reports');
        $this->load->model('customreports_model','customreport');
		$this->load->model('Activities_model','Todo_work');
		$this->load->library('excel');
      
   }
   public function index(){
      $data['user'] = $this->Login->getusername();
      $data['admin'] = $this->Login->getadminname();
      $this->load->view('customreports',$data);
   }


   /**
    * Return filtered aggregated data for custom reports based on POST filters and echoes a JSON response.
    * @example
    * // Example POST (via curl)
    * // curl -X POST -d 'module=salesorder&user=all&xaxis=months&yaxis=initial_total&aggr=totalsalessum&from_date=2025-01-01&to_date=2025-12-31&limit=DESC10' http://example.com/customreports/filtereddata
    * // Example expected JSON output (sample)
    * // [{"grp":"2025-01","saleorder_owner":"alice@example.com","subtotal":"12345.67"}, {"grp":"2025-02","saleorder_owner":"bob@example.com","subtotal":"9876.54"}]
    * @param string $module - (POST) Module/table name to query (e.g. 'salesorder', 'lead', 'organization', 'quote', 'purchaseorder').
    * @param string $user - (POST) 'all' or user identifier/email to filter by session user (e.g. 'all' or 'john@example.com').
    * @param string|null $org - (POST) Organization name to filter results by (optional).
    * @param string $xaxis - (POST) X-axis/grouping key: 'user','organization','product','months','years','days','saleorder_id','purchaseorder_id','quote_id','fyear', etc.
    * @param int|string $fbycol - (POST) Column index/key used for an additional filter (index into the module table fields).
    * @param string|null $field - (POST) Value to filter the fbycol column by (optional).
    * @param int|string $yaxis - (POST) Y-axis column index/key (index into the module table fields) used for aggregation.
    * @param string $aggr - (POST) Aggregation type: 'totalsalessum', 'totalcount', 'totalprofitsum', etc.
    * @param string|null $from_date - (POST) Start date for date range filter in 'YYYY-MM-DD' format (optional).
    * @param string|null $to_date - (POST) End date for date range filter in 'YYYY-MM-DD' format (optional).
    * @param string|null $limit - (POST) Optional limit string combining non-digits and digits (e.g. 'DESC10' where 'DESC' is ordering/alpha part and '10' is numeric limit).
    * @param array|null $columns - (POST) Optional array of column indexes to include as table columns in the response.
    * @returns void Echoes a JSON-encoded array/object of filtered results (aggregated rows with keys like grp, owner/subtotal and optional 'table' flag). 
    */
   public function filtereddata() {
   $istable = 'false';
      $session_comp_email = $this->session->userdata('company_email');
      $session_company = $this->session->userdata('company_name');
      $module = $this->input->post('module');
      $user = $this->input->post('user');
      $org = $this->input->post('org');
      $xaxis = $this->input->post('xaxis');
      $fbycol = $this->input->post('fbycol');
      $yaxis = $this->input->post('yaxis');
      $aggr = $this->input->post('aggr');
      $from = $this->input->post('from_date');
      $to = $this->input->post('to_date');
      $limit = $this->input->post('limit');
      $field = $this->input->post('field');
      $tablecolumns=$this->input->post('columns');
    
     
   
 
      if($module == 'lead') {
        $owner_column = 'lead_owner';
    } else if($module == 'organization') {
        $owner_column = 'ownership';
    } else {
        $owner_column = 'owner';
    }
      if($module == 'lead') {
          $subtotal_column = 'sub_total';
      } else if($module == 'quote') {
          $subtotal_column = 'sub_totalq';
      } else {
          $subtotal_column = 'sub_totals';
      }
      
  
     $cond = array();
     if (!empty($from) && !empty($to)) {
         $cond['currentdate >='] = $from;
         $cond['currentdate <='] = $to;
     }

     if ($user != 'all') {
        $cond['sess_eml'] = $user;
        $cond['session_company'] = $session_company;
        $cond['session_comp_email'] = $session_comp_email;
     } else {
        $cond['session_company'] = $session_company;
        $cond['session_comp_email'] = $session_comp_email;
     }
     if($org){
        $cond['org_name']=$org;
     }
     

    switch ($xaxis) {
        case 'user':
            $group_by = $owner_column;
            break;
        case 'organization':
            $group_by = 'org_name';
            break;
        case 'product':
            $group_by = 'product_name';
            break;
        case 'months':
            $group_by = 'CONCAT(YEAR(currentdate), "-", LPAD(MONTH(currentdate), 2, "0"))';
            break;
        case 'years':
            $group_by = 'YEAR(currentdate)';
            break;
        case 'days':
            $group_by = 'DATE(currentdate)';
            break;
        case 'saleorder_id':
            $group_by = 'saleorder_id';
            break;
        case 'purchaseorder_id':
            $group_by = 'purchaseorder_id';
            break;
        case 'quote_id':
            $group_by = 'quote_id';
            break;
        case 'product':
            $group_by = 'product_name';
            break;
        default:
            $group_by = $owner_column;
            break;
    }
   
    $columnXNames = $this->db->list_fields($module);
    if($xaxis == 'months'){
        $grpp = 'CONCAT(YEAR(currentdate), "-", LPAD(MONTH(currentdate), 2, "0"))';
    }
    elseif($xaxis == 'years'){
        $grpp = 'YEAR(currentdate)';
    }
    elseif($xaxis == 'fyear'){
        $grpp='CONCAT(
            CASE 
                WHEN MONTH(currentdate) >= 4 THEN YEAR(currentdate)
                ELSE YEAR(currentdate) - 1
            END,
            "-",
            CASE 
                WHEN MONTH(currentdate) >= 4 THEN YEAR(currentdate) + 1
                ELSE YEAR(currentdate)
            END
        )';
    }
    else{
    $grpp = $columnXNames[$xaxis];
    }
    $columnYNames = $this->db->list_fields($module);
    $ycol = $columnYNames[$yaxis];
    if ($tablecolumns) {
        $selcolumns = [];
        foreach ($tablecolumns as $tcol) {
         
            if (isset($columnYNames[$tcol])) {
                $selcolumns[] = $columnYNames[$tcol];
            }
        }
      $istable = 'true';
        
        $selstring = implode(', ', $selcolumns);
    }
    
    if(($module == 'salesorder') && ($ycol == 'initial_total' || $ycol == 'profit_by_user' || $aggr == 'totalsalessum' || $aggr =='totalprofitsum') && ($grpp != 'status') ){
        $cond['status']='Approved';
      }
    if ($aggr == 'totalsalessum' ){
        $sel = "$selstring,$grpp as grp,$owner_column,SUM($ycol) as subtotal";
    } else if ($aggr == 'totalcount') {
        $sel = "$selstring,$grpp as grp,$owner_column,COUNT(id) as subtotal";
    } else if ($aggr == 'totalprofitsum') {
        $sel = "$selstring,$grpp as grp,$owner_column,SUM($ycol) as subtotal";
    } 
    else {
        $sel = "$selstring,$grpp as grp,$owner_column,SUM($ycol) as subtotal";
    }
        if($field != ""){
             $cols=$columnXNames[$fbycol];
            $cond[$cols]=$field;
        }
        $cond['delete_status'] = 1;
        if($limit){
            preg_match('/^(\D+)(\d+)$/', $limit, $matches); 
            $alpha = $matches[1]; 
            $numeric = $matches[2]; 
            $data['filtereddata'] = $this->customreport->getdata($sel, $module, $cond, $grpp,'subtotal',$alpha,$numeric);
            if ($tablecolumns){
                $data['filtereddata']['table']=$istable;
            }
           
         }
    else{
        $data['filtereddata'] = $this->customreport->getdata($sel, $module, $cond, $grpp);
        if ($tablecolumns){
            $data['filtereddata']['table']=$istable;
        }
    }
        // print_r($data);
        echo json_encode($data['filtereddata']);
}
/**
* Retrieve and echo JSON-encoded, filtered column names for a database table specified via POST 'module'.
* @example
* $_POST['module'] = 'users';
* $result = $this->get_column_names();
* // Echoed output (example): ["username","email","created_at"]
* @param string $module - Module/table name expected via POST input (e.g., 'users').
* @returns string Echoes a JSON encoded array of filtered column names, or an error message ('No column names found.' or 'Invalid request.').
*/
public function get_column_names() {
    $module = $this->input->post('module');
    if($module != '') {
        $columnNames = $this->db->list_fields($module); // Retrieve column names dynamically
        $formattedColumnNames = $this->formatArrayItems($columnNames); // Format column names
        if ($formattedColumnNames) {
            $hidecolumns = ['Id', 'SessEml', 'SessionCompany', 'SessionCompEmail', 'OrgId', 'ContId', 'Pending', 'ApprovedBy', 'ProDummyId','AttachedFile', 'Total', 'Percent', 'Discount', 'Igst18', 'Igst12', 'Igst28', 'Cgst9', 'Cgst14', 'Sgst9','Cgst6','Sgst6','Cgst', 'Cgst14', 'Sgst14', 'TotalPercent', 'IsRenewal','DeleteStatus','Gst','Igst','Sgst','MicrosoftLanNo','SalesorderItemType','QuoteItemType','PromoId','CustomerCompanyName'];
            
            // Filter out the columns that exist in $hidecolumns array
            $filteredColumnNames = array_diff($formattedColumnNames, $hidecolumns);
            
            // Return the filtered column names array
            echo json_encode($filteredColumnNames);
        }
        else {
            echo 'No column names found.';
        }
    } else {
        echo 'Invalid request.';
    }
}

// Function to format array items
/**
* Format an array of snake_case strings into CamelCase (capitalize each word and remove underscores).
* @example
* $items = ['first_name', 'last_name', 'user_id'];
* $result = $this->formatArrayItems($items);
* print_r($result); // Array ( [0] => FirstName [1] => LastName [2] => UserId )
* @param {array} $array - Array of strings in snake_case to be formatted.
* @returns {array} Array of formatted strings in CamelCase.
*/
private function formatArrayItems($array) {
    $formattedArray = array();
    foreach ($array as $item) {
        // Capitalize first letter of each word
        $formattedItem = ucwords(str_replace('_', ' ', $item));
        // Remove underscores
        $formattedItem = str_replace(' ', '', $formattedItem);
        // Add formatted item to new array
        $formattedArray[] = $formattedItem;
    }
    return $formattedArray;
}
/**
* Convert an array of CamelCase strings into lowercase strings with underscores between words.
* @example
* $items = ['HelloWorld', 'MyItem'];
* $result = $this->reverseFormatArrayItems($items);
* echo json_encode($result); // ["hello_world","my_item"]
* @param {array} $array - Array of strings to format (e.g. ['HelloWorld','MyItem']).
* @returns {array} Formatted array with underscores inserted before capitals and all characters lowercased (e.g. ['hello_world','my_item']).
*/
private function reverseFormatArrayItems($array) {
    $reversedArray = array();
    foreach ($array as $item) {
        // Add underscores between words
        $reversedItem = preg_replace('/\B([A-Z])/', '_$1', $item);
        // Convert the first letter of each word to lowercase
        $reversedItem = strtolower($reversedItem);
        // Add reversed item to new array
        $reversedArray[] = $reversedItem;
    }
    return $reversedArray;
}

/**
* Fetch column data for a requested module/field (uses POST 'module' and 'field') and echoes JSON with dataset and field name.
* @example
* // POST payload: module = 'users', field = 2
* $result = $this->getfield_data(); // invoked in controller context (method reads POST and echoes JSON)
* echo $result // {"dataset":[{"email":"alice@example.com"},{"email":"bob@example.com"}],"fields":"email"}
* @param {string} $module - Module (table) name supplied via POST (e.g. 'users').
* @param {int} $field - Numeric index of the column in the module's field list supplied via POST (e.g. 2).
* @returns {string} JSON encoded string containing 'dataset' (array of rows) and 'fields' (column name).
*/
public function getfield_data(){
    
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $cond=['session_comp_email'=>$session_comp_email,'session_company'=>$session_company];
    
    $module = $this->input->post('module');
    $field = $this->input->post('field');
    $columnYNames = $this->db->list_fields($module);
    $ycol = $columnYNames[$field];
    $data['dataset']=$this->customreport->getcoldata($ycol,$module,$cond)->result_array();
    $data['fields']=$ycol;
    echo json_encode($data);

}

























   /**
   * Generate and echo matched table keywords from the posted 'text' using approximate string similarity.
   * @example
   * // Simulate POST input and call from controller
   * $_POST['text'] = 'create invoices for client';
   * $controller = new Customreports();
   * $controller->generateQuery();
   * // Example output:
   * // Word: invoices, Similarity: 1.00, Matching tablekeyword: invoices
   * @param string $text - Posted text input retrieved via $this->input->post('text'), e.g. 'create invoices for client'.
   * @returns void Echoes matched words, their similarity (0-1 formatted), and the matching table keyword; does not return a value.
   */
   public function generateQuery() {
    $text=$this->input->post('text');
    $texts = explode(' ',$text);
    
    $tablekeyword = ['salesorder', 'invoices', 'purchaseorder', 'organization', 'quotation', 'contacts', 'creditnote', 'debitnote'];
    
    // Function to calculate cosine similarity between two words
    function wordSimilarity($word1, $word2) {
        similar_text($word1, $word2, $percentage);
        return $percentage / 100; // Convert to a scale of 0 to 1
    }
    
    // Calculate similarity for each word in texts with each word in tablekeyword
    $results = [];
    foreach ($texts as $textWord) {
        $maxSimilarity = 0;
        $matchingtablekeyword = '';
        foreach ($tablekeyword as $tablekeywordWord) {
            $similarity = wordSimilarity($textWord, $tablekeywordWord);
            if ($similarity > $maxSimilarity) {
                $maxSimilarity = $similarity;
                $matchingtablekeyword = $tablekeywordWord;
            }
        }
        if ($maxSimilarity >= 0.85) { // Check if similarity is greater than or equal to 0.85
            $results[] = ['word' => $textWord, 'similarity' => $maxSimilarity, 'matching_tablekeyword' => $matchingtablekeyword];
        }
    }
    
    // Display results
    foreach ($results as $result) {
        echo "Word: " . $result['word'] . ", Similarity: " . number_format($result['similarity'], 2) . ", Matching tablekeyword: " . $result['matching_tablekeyword'] . PHP_EOL;
        echo "<br>";
    }
}

}
