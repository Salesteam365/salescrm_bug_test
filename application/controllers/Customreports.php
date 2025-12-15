<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customreports extends CI_Controller {

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
