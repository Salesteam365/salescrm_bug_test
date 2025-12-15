<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aifilters extends CI_Controller {

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
		// $this->load->model('Contact_model','Contact');
		$this->load->model('Login_model','Login');
		$this->load->model('Reports_model','Reports');

        $this->load->model('Aifilters_model','aifilter');
        //  $this->load->model('customreports_model','customreport');

		$this->load->model('Activities_model','Todo_work');
		$this->load->library('excel');
        $this->load->helper(['url', 'crm_helper']);
        $this->load->model('Quotation_model', 'Quotation');
        $this->load->model('Purchaseorders_model', 'Purchaseorders');
        $this->load->model('Lead_model', 'Lead');
        $this->load->model('Contact_model');
        $this->load->model('Workflow_model');
        $this->load->model('Opportunity_model', 'Opportunity');
        $this->load->library('upload');
        $this->load->library(['pdf', 'email_lib']);
      
   }

   public function index()
   {
// print_r('testing');die;
     if(!empty($this->session->userdata('email')))
        {
           
          $date = "Month";
          $data['leads_status'] = $this->Reports->get_leads_status();
          $data['opp_stage'] = $this->Reports->get_opp_stage();
          $data['quote_stage'] = $this->Reports->get_quote_stage();
          $data['organization'] = $this->Reports->getOrg();
          $data['user'] = $this->Login_model->getusername();
          $data['admin'] = $this->Login_model->getadminname();
         
          $this->load->view('aifilter',$data);
        }else{
          redirect('home');
        }
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


// < ------------------------------------ Start Ai Filters ------------------------------------>


public function get_users() {
    // Fetch user data
    $users = $this->Login_model->getusername();
    // print_r($users);die;
    // Fetch admin data
    $admin = $this->Login_model->getadminname();

    // Check if admin data is fetched successfully
    if ($admin === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch Admin']);
        return;
    } 

    // Check if user data is fetched successfully
    if ($users === false) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch User']);
        return;
    }

    // Prepare response data
    $response = [
        'admin' => $admin ? array_map(function($item) {
            return ['admin_name' => $item['admin_name'],'admin_email' => $item['admin_email']];  
        }, $admin) : [],
        'customers' => $users ? array_map(function($item) {
            return ['standard_name' => $item['standard_name'],'standard_email' => $item['standard_email']];
        }, $users) : [],
    ];

    // Send response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}


    public function get_customers() {
        $customers = $this->aifilter->get_all_customers(); 

        if ($customers === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch customers']);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode(['customers' => $customers]);
    }


    public function get_saleId() {
        
        $saleId = $this->aifilter->get_all_saleId(); 
        // print_r($saleId);die;

        if ($saleId === false) {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to fetch Sales order Id']);
            return;
        }
        
   
        header('Content-Type: application/json');
        echo json_encode(['saleId' => $saleId]);
    }


    public function get_org() {
        $org_id = $_POST['org_id'];
        $orgName = $this->aifilter->get_all_org($org_id); 
        // print_r($orgName);

        if (($orgName)) {
            $response = array(["orgName" =>$orgName, "status" => "success", "message" => "Data received"]);
            echo json_encode($response);
           
        }else{
            $response = array([
                "filterData" => "No Data Found",
                "status" => "failed",
                "message" => "No Data Found"
            ]);
            echo json_encode($response);
    
        }
    }


public function filterDataAll(){
    $filterdata = $this->aifilter->get_filtered_Alldata();
    // print_r($filterdata);die;
    if ($filterdata) {
        $response = array([
            "filterData" =>$filterdata, 
            "status" => "success",
             "message" => "Data received"
         ]);
        echo json_encode($response);
       
    }else{
        $response = array([
            "filterData" => "No Data Found",
            "status" => "failed",
            "message" => "No Data Found"
        ]);
        echo json_encode($response);

    }
    
}



public function Profit_customers() {
    // print_r('test');die;

    $filterUser = $this->input->post('filterUser');
    $org_id = $this->input->post('filterCustomer');
    $salesId = $this->input->post('salesId');
    $startDate = $this->input->post('startDate');
    $endDate = $this->input->post('endDate');
    // print_r($filterUser);die;

    $filterdata = $this->aifilter->get_filtered_data($filterUser, $org_id, $salesId, $startDate, $endDate);
    
    // print_r($filterdata);die;
    if (($filterdata)) {
        $response = array([
            "filterData" =>$filterdata, 
            "status" => "success",
             "message" => "Data received"
         ]);
        echo json_encode($response);
       
    }else{
        $response = array([
            "filterData" => "No Data Found",
            "status" => "failed",
            "message" => "No Data Found"
        ]);
        echo json_encode($response);

    }
    
}



// < -------------------------------------- End Ai Filters ---------------------------------------------->

//<----------------------------------------Start Total Filter Data ------------------------------------------->

    public function ajax_list()
    {
        $list = $this->aifilter->get_datatables();
        // print_r($list);die;
        $data = [];
        $no = $_POST['start'];
        $dataAct = $this->input->post('actDate');

        foreach ($list as $post) {
            $no++;
            $row = [];

            $proName = explode("<br>", $post->product_name);
            $proNamepo = 0;
            $soId = $post->saleorder_id;
            $poList = $this->aifilter->CountOrder($soId);
            $PiCount = $this->Quotation->check_pi_exist($post->saleorder_id);
            $invoiceCount = $this->aifilter->CountInvoice($post->saleorder_id);

            foreach ($poList as $Popost) {
                $proNamepo2 = explode("<br>", $Popost->product_name);
                $proNamepo = $proNamepo + count($proNamepo2);
            }

            $SOProNameCnt = count($proName);
            $POProNameCnt = $proNamepo;
            $first_row = "";
            $first_row .= ucfirst($post->subject) . '<!---<div class="links">';
            $first_row .= '</div>-->';
            $companydetail = "
                <div class='d-flex align-items-center'>
                    <div>
                        <span>".ucfirst($post->org_name)."</span><br>
                       
                    </div>
                </div>";
                $salesid =" 
                <span style='color: rgba(140, 80, 200, 1);
                font-weight: 700;'>".ucfirst($post->saleorder_id)."</span>"
                ;
            $row[] = ucfirst($post->owner);
            $row[] = $companydetail;
            $row[] = $first_row;
            $row[] = $salesid;
           
            if($post->total_percent == '0') {
                if ($invoiceCount > 0 && $post->invoice_id != "") {
                    $row[] = '<span class="btn btn_complete_st p-0">Complete</span>';
                } else {
                    $row[] = '<span class="btn btn_invoicepending_st p-0">Invoice Pending</span>';
                }
            }elseif($post->total_percent == '100') {
                $row[] = '<span class="btn btn_pending_st p-0">Pending</span>';
            }elseif($post->total_percent > 0 || $post->total_percent < 100) {
                $row[] = '<span class="btn btn_inprog_st p-0">In Progress</span>';
            }

            $newDate = date("d M Y", strtotime($post->currentdate));
            //$row[] = "<text style='font-size: 12px;'>".time_elapsed_string($post->datetime)."</text>";
            $row[] = "<text style='font-size: 12px;'>" . $newDate . "</text>";
            
            // Start po show 
            $pono = "";
                if (!empty($post->po_no)) {
                    $pono = "<span style='color: rgba(140, 80, 200, 1); font-weight: 700;'>" . ucfirst($post->po_no) . "</span>";
                }

                $row[] = $pono;
                $newDatepo = "";

                if (!empty($post->po_date)) {
                    $newDatepo = date("d M Y", strtotime($post->po_date));
                }

                $row[] = !empty($newDatepo) ? "<text style='font-size: 12px;'>" . $newDatepo . "</text>" : "";
            // end po 

            $data[] = $row;
        }
        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->aifilter->count_all(),
            "recordsFiltered" => $this->aifilter->count_filtered(),
            "data" => $data,
        ];


        //output to json format
        echo json_encode($output);
    }


}








