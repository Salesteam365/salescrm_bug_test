<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller
{
    
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('Login_model');
    $this->load->model('Reports_model','Reports');
    $this->load->library('excel');
    $this->perPage = 10;
  }
  
  /**
   * Load the reports page for an authenticated user with the "Create Report" module permission; otherwise redirect to home.
   * @example
   * // Via browser: GET https://example.com/reports  (calls Reports::index())
   * // From another controller:
   * $this->load->controller('Reports');
   * $this->Reports->index();
   * // Result: renders the 'reports/reports' view populated with:
   * //   $data['leads_status']  => array of lead statuses (sample: ['New','Contacted','Qualified'])
   * //   $data['opp_stage']     => array of opportunity stages (sample: ['Prospect','Proposal','Won'])
   * //   $data['quote_stage']   => array of quote stages (sample: ['Draft','Sent','Accepted'])
   * //   $data['organization']  => organization list/object (sample: ['Acme Corp'])
   * //   $data['user']          => current username (sample: 'jdoe')
   * //   $data['admin']         => admin name (sample: 'admin')
   * // If user not logged in or lacks permission, redirects to 'home'.
   * @returns void Performs view rendering or redirect; does not return a value.
   */
  public function index()
  {
    if(!empty($this->session->userdata('email')))
    {
       if(checkModuleForContr('Create Report')<1){
        	    redirect('home');
        } 
      $date = "Month";
      $data['leads_status'] = $this->Reports->get_leads_status();
      $data['opp_stage'] = $this->Reports->get_opp_stage();
      $data['quote_stage'] = $this->Reports->get_quote_stage();
      $data['organization'] = $this->Reports->getOrg();
      $data['user'] = $this->Login_model->getusername();
      $data['admin'] = $this->Login_model->getadminname();
      $this->load->view('reports/reports', $data);
    }
    else
    {
      redirect('home');
    }
  }
  
  /**
   * Get lead summary rows for DataTables and output as JSON.
   * @example
   * // Example POST values:
   * $_POST = ['start' => 0, 'draw' => 1];
   * // Call (controller method, no arguments):
   * $this->get_lead_for_record();
   * // Example echoed JSON:
   * // {
   * //   "draw": 1,
   * //   "recordsTotal": 123,
   * //   "recordsFiltered": 50,
   * //   "data": [
   * //     ["John Doe","1,234"],
   * //     ["Jane Smith","567"]
   * //   ]
   * // }
   * @param array $_POST - Superglobal POST input; expects 'start' (int) for paging and 'draw' (int) for DataTables draw counter.
   * @returns void Echoes a JSON-encoded array containing draw, recordsTotal, recordsFiltered and data rows (no return value).
   */
  public function get_lead_for_record()
  {
    $list = $this->Reports->get_lead_for_record();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
  
      $row[] = $post->lead_owner;
      $row[] = IND_money_format($post->total_leads);
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_leads(),
      "recordsFiltered" => $this->Reports->count_filtered_leads(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  public function get_leads_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Reports->get_report_leads_by_user($type);
    echo json_encode($result);
  }
 
  public function sort_lead_graph()
  {
    $type = $this->session->userdata('type'); 
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $data = $this->Reports->get_all_leads_by_date($type,$sort_date,$from_date,$to_date);
    echo json_encode($data);
  }
  
  /**
  * Export leads to CSV and force the file download. Reads filter and pagination parameters from POST (lead_keywords, lead_sortBy, lead_sortFrom, lead_sortTo, page), builds a report with columns "Lead Owner" and "Total Leads", streams the CSV (filename leads-<timestamp>.csv) to the client and exits.
  * @example
  * // Example (curl) — downloads CSV with sample filters:
  * // curl -X POST -F "lead_keywords=Acme" -F "lead_sortBy=created_at" -F "lead_sortFrom=2025-01-01" -F "lead_sortTo=2025-12-31" -F "page=0" https://example.com/reports/export_lead_to_csv
  * @param {null} none - No direct function arguments; input is obtained from POST parameters: 'lead_keywords' (string), 'lead_sortBy' (string), 'lead_sortFrom' (string, YYYY-MM-DD), 'lead_sortTo' (string, YYYY-MM-DD), 'page' (int).
  * @returns {void} Sends a CSV file as an HTTP attachment and terminates execution.
  */
  public function export_lead_to_csv()
  {
      $conditions = array();
      //calc offset number
      $page = $this->input->post('page');
      if(!$page){
        $offset = 0;
      }else{
          $offset = $page;
      }
      //set conditions for search
      $keywords = $this->input->post('lead_keywords');
      $sortBy = $this->input->post('lead_sortBy');
      //echo $sortBy;die;
      $sortFrom = $this->input->post('lead_sortFrom');
      $sortTo = $this->input->post('lead_sortTo');
      if(!empty($keywords)){
          $conditions['search']['keywords'] = $keywords;
      }
      if(!empty($sortBy)){
          $conditions['search']['sortBy'] = $sortBy;
          //echo $conditions['search']['sortBy'];die;
      }
      if(!empty($sortFrom)){
          $conditions['search']['sortFrom'] = $sortFrom;
      }
      if(!empty($sortTo)){
          $conditions['search']['sortTo'] = $sortTo;
      }
      if(empty($keywords) && empty($sortBy) && empty($sortFrom) && empty($sortTo))
      {
        $date = "Month";
      }
      else
      {
        $date = "Back";
      }
      //total rows count
      $totalRec = count((array)$this->Reports->get_lead_for_record($conditions,$date));
      //pagination configuration
      $config['target']      = '#Leadlist';
      $config['base_url']    = base_url().'reports/ajaxReportsLeadData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $config['link_func']   = 'searchFilter';
      //$this->ajax_pagination->initialize($config);
      //set start and limit
      $conditions['start'] = $offset;
      $conditions['limit'] = $this->perPage;
      //get posts data
      $lead_data = $this->Reports->get_lead_for_record($conditions,$date);
	  //print_r($lead_data);
      
      $fileName = 'leads-'.time().'.csv';  
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Lead Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total Leads');       
        // set Row
        $rowCount = 2;
        foreach ($lead_data as $element) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->lead_owner);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->total_leads);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=$fileName");
      $object_writer->save('php://output');  
      exit;  
  }
  
  public function get_top_opp_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Reports->get_top_opp_by_user($type);
    echo json_encode($result);
  }
  
  public function sort_opportunity_graph()
  {
    $type = $this->session->userdata('type');
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $data = $this->Reports->get_top_opp_by_date($type,$sort_date,$from_date,$to_date);
   
    echo json_encode($data);
  }
  
  /**
  * Output paginated opportunity records as a JSON response for DataTables.
  * @example
  * $_POST['start'] = 0;
  * $_POST['draw'] = 1;
  * $this->get_opportunity_for_record();
  * // Example echoed JSON output:
  * // {"draw":1,"recordsTotal":100,"recordsFiltered":50,"data":[["John Doe","₹1,234.00"],["Jane Smith","₹2,500.00"]]}
  * @param int $_POST['start'] - Starting record offset for pagination (DataTables start index).
  * @param int $_POST['draw'] - Draw counter from DataTables to be returned in the response.
  * @returns void Echoes a JSON encoded array containing draw, recordsTotal, recordsFiltered and data.
  */
  public function get_opportunity_for_record()
  {
    $list = $this->Reports->get_opp_for_record();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      $row[] = $post->owner;
      $row[] = IND_money_format($post->sub_total);
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_opp(),
      "recordsFiltered" => $this->Reports->count_filtered_opp(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  /**
  * Export opportunity summary grouped by owner to a CSV file and force download.
  * @example
  * // Set POST inputs (normally submitted from a form or AJAX request)
  * $_POST['opp_keywords']  = 'ACME';
  * $_POST['opp_sortBy']    = 'owner';
  * $_POST['opp_sortFrom']  = '2025-01-01';
  * $_POST['opp_sortTo']    = '2025-12-31';
  * $_POST['page']          = 0;
  * // From a controller context:
  * $this->Reports->export_opp_to_csv();
  * // This call sends headers and forces download of a file named like:
  * // Opportunity-1617181920.csv
  * @param int|null $page - (POST) Pagination offset / page index used to slice results. Example: 0
  * @param string|null $opp_keywords - (POST) Search keywords to filter opportunities. Example: "ACME"
  * @param string|null $opp_sortBy - (POST) Field to sort/filter by. Example: "owner"
  * @param string|null $opp_sortFrom - (POST) Start date for date range filter (YYYY-MM-DD). Example: "2025-01-01"
  * @param string|null $opp_sortTo - (POST) End date for date range filter (YYYY-MM-DD). Example: "2025-12-31"
  * @returns void Forces a CSV download of the aggregated opportunity data and exits the script.
  */
  public function export_opp_to_csv()
  {
      $conditions = array();
      //calc offset number
      $page = $this->input->post('page');
      if(!$page){
        $offset = 0;
      }else{
          $offset = $page;
      }
      //set conditions for search
      $keywords = $this->input->post('opp_keywords');
      $sortBy = $this->input->post('opp_sortBy');
      $sortFrom = $this->input->post('opp_sortFrom');
      $sortTo = $this->input->post('opp_sortTo');
      if(!empty($keywords)){
          $conditions['search']['keywords'] = $keywords;
      }
      if(!empty($sortBy)){
          $conditions['search']['sortBy'] = $sortBy;
      }
      if(!empty($sortFrom)){
          $conditions['search']['sortFrom'] = $sortFrom;
      }
      if(!empty($sortTo)){
          $conditions['search']['sortTo'] = $sortTo;
      }
      if(empty($keywords) && empty($sortBy) && empty($sortFrom) && empty($sortTo))
      {
        $date = "Month";
      }
      else
      {
        $date = "Back";
      }
      //total rows count
      $totalRec = count((array)$this->Reports->get_opp_for_record($conditions,$date));
      //pagination configuration
      $config['target']      = '#Po_list';
      $config['base_url']    = base_url().'reports/ajaxReportsOPPData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $config['link_func']   = 'searchFilter';
      //$this->ajax_pagination->initialize($config);
      //set start and limit
      $conditions['start'] = $offset;
      $conditions['limit'] = $this->perPage;
      $opp_data = $this->Reports->get_opp_for_record($conditions,$date);

      $fileName = 'Opportunity-'.time().'.csv';  
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total Opportunities');       
        // set Row
        $rowCount = 2;
        foreach ($opp_data as $element) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->owner);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->sub_total);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=$fileName");
      $object_writer->save('php://output');  
      exit;  
  }
  
  public function get_top_quote_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Reports->get_top_quotation_by_user($type);
    echo json_encode($result);
  }
  
  public function sort_quotation_graph()
  {
    $type = $this->session->userdata('type'); 
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    
    $data = $this->Reports->get_top_quote_by_date($type,$sort_date,$from_date,$to_date);
    echo json_encode($data);
  }
  
  /**
   * Get quotation records and output a JSON response formatted for DataTables.
   * @example
   * // simulate POST parameters expected by the method
   * $_POST['start'] = 0;
   * $_POST['draw'] = 1;
   * // call method (from within controller context)
   * $this->Reports->get_quotation_for_record();
   * // Example echoed output:
   * // {"draw":1,"recordsTotal":125,"recordsFiltered":25,"data":[["John Doe","1,200.00","1200"],["Jane Smith","850.00","850"]]}
   * @param int $start - POST parameter 'start' (paging offset), expected integer (e.g. 0).
   * @param int $draw - POST parameter 'draw' (DataTables draw counter), expected integer (e.g. 1).
   * @returns void Echoes a JSON-encoded array with keys: draw, recordsTotal, recordsFiltered, data.
   */
  public function get_quotation_for_record()
  {
    $list = $this->Reports->get_quote_for_record();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
  
      $row[] = $post->owner;
      $row[] = IND_money_format($post->sub_totalq);
      $row[] = $post->total_quote;
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_quote(),
      "recordsFiltered" => $this->Reports->count_filtered_quote(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
 
  /**
   * Export quotations to a CSV file and send it as a download response.
   * This controller method reads filter and pagination values from POST (quote_keywords, quote_sortBy, quote_sortFrom, quote_sortTo, page),
   * generates an Excel/CSV file containing Owner, Top Quotation and Total Quotation columns, sends appropriate headers and exits.
   * @example
   * // From a controller or route (no return value; triggers file download)
   * $this->Reports->export_quotation_to_csv();
   * // Initiates download of a file such as: "Quotation-1609459200.csv"
   * @param void $none - No parameters. Uses POST input for filtering and pagination.
   * @returns void Triggers file download (CSV/Excel5) and exits; does not return a value.
   */
  public function export_quotation_to_csv()
  {
      $conditions = array();
      //calc offset number
      $page = $this->input->post('page');
      if(!$page){
        $offset = 0;
      }else{
          $offset = $page;
      }
      //set conditions for search
      $keywords = $this->input->post('quote_keywords');
      $sortBy = $this->input->post('quote_sortBy');
      $sortFrom = $this->input->post('quote_sortFrom');
      $sortTo = $this->input->post('quote_sortTo');
      if(!empty($keywords)){
          $conditions['search']['keywords'] = $keywords;
      }
      if(!empty($sortBy)){
          $conditions['search']['sortBy'] = $sortBy;
      }
      if(!empty($sortFrom)){
          $conditions['search']['sortFrom'] = $sortFrom;
      }
      if(!empty($sortTo)){
          $conditions['search']['sortTo'] = $sortTo;
      }
      if(empty($keywords) && empty($sortBy) && empty($sortFrom) && empty($sortTo))
      {
        $date = "Month";
      }
      else
      {
        $date = "Back";
      }
      //total rows count
      $totalRec = count((array)$this->Reports->get_quote_for_record($conditions,$date));
      //pagination configuration
      $config['target']      = '#Quotelist';
      $config['base_url']    = base_url().'reports/ajaxReportsQuotationData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $config['link_func']   = 'searchFilter';
     // $this->ajax_pagination->initialize($config);
      //set start and limit
      $conditions['start'] = $offset;
      $conditions['limit'] = $this->perPage;
      //get posts data
      $quote_data = $this->Reports->get_quote_for_record($conditions,$date);

      $fileName = 'Quotation-'.time().'.csv';  
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Top Quotation');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total Quotation');       
        // set Row
        $rowCount = 2;
        foreach ($quote_data as $element) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->owner);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->sub_totalq);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->total_quote);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=$fileName");
      $object_writer->save('php://output');  
      exit;  
  }
  public function get_so_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Reports->get_all_so_by_user($type);
    echo json_encode($result);
  }
  public function sort_so_graph()
  {
    $type = $this->session->userdata('type'); 
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $data = $this->Reports->get_all_so_by_date($type,$sort_date,$from_date,$to_date);
    echo json_encode($data);
  }
  /**
   * Fetch sales orders for the current request and output a JSON response formatted for DataTables.
   * @example
   * // Simulate request parameters (normally provided by DataTables via POST)
   * $_POST['start'] = 0;
   * $_POST['draw']  = 1;
   *
   * // Call controller action (controller instantiation shown for example only)
   * $reports = new Reports();
   * $reports->get_salesorder_for_record();
   *
   * // Example output (echoed JSON):
   * // {
   * //   "draw": 1,
   * //   "recordsTotal": 100,
   * //   "recordsFiltered": 50,
   * //   "data": [
   * //     ["John Doe", "₹1,250.00"],
   * //     ["Jane Smith", "₹2,500.00"]
   * //   ]
   * // }
   * @param array $_POST - POST input array; expects 'start' (int) offset and 'draw' (int) DataTables draw counter.
   * @returns void Echoes a JSON-encoded array with keys: draw (int), recordsTotal (int), recordsFiltered (int), data (array of rows [owner, formatted_sub_total]).
   */
  public function get_salesorder_for_record()
  {
    $list = $this->Reports->get_sales_for_record();
    // print_r($list);die;
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
  
      $row[] = $post->owner;
      $row[] = IND_money_format($post->sub_totals);
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_sales(),
      "recordsFiltered" => $this->Reports->count_filtered_sales(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  


  /**
  * Export sales summary to a downloadable CSV file.
  * This controller method collects optional POST filter parameters (page, so_keywords, so_sortBy, so_sortFrom, so_sortTo),
  * retrieves aggregated sales data via Reports->get_so_for_record(), builds a CSV (Excel5 format) with columns "Owner" and "Total Sales",
  * sends appropriate headers and outputs the file for download, then exits.
  * @example
  * // via controller (example values)
  * $_POST['page'] = 0;
  * $_POST['so_keywords'] = 'John';
  * $_POST['so_sortBy'] = 'owner';
  * $_POST['so_sortFrom'] = '2025-01-01';
  * $_POST['so_sortTo'] = '2025-01-31';
  * $this->export_sales_to_csv(); // triggers download of "Sales-<timestamp>.csv" with contents like:
  * // Owner,Total Sales
  * // John Doe,1234.56
  * @param int $page - (POST) Zero-based offset / page index for pagination (example: 0).
  * @param string $so_keywords - (POST) Search keywords to filter sales by owner or other fields (example: 'John').
  * @param string $so_sortBy - (POST) Field to sort by (example: 'owner').
  * @param string $so_sortFrom - (POST) Start date for date-range filtering (YYYY-MM-DD, example: '2025-01-01').
  * @param string $so_sortTo - (POST) End date for date-range filtering (YYYY-MM-DD, example: '2025-01-31').
  * @returns void Writes CSV output to php://output, sends download headers and exits.
  */
  public function export_sales_to_csv()
  {
      $conditions = array();
      //calc offset number
      $page = $this->input->post('page');
      if(!$page){
        $offset = 0;
      }else{
          $offset = $page;
      }
      //set conditions for search
      $keywords = $this->input->post('so_keywords');
      $sortBy = $this->input->post('so_sortBy');
      $sortFrom = $this->input->post('so_sortFrom');
      $sortTo = $this->input->post('so_sortTo');
      if(!empty($keywords)){
          $conditions['search']['keywords'] = $keywords;
      }
      if(!empty($sortBy)){
          $conditions['search']['sortBy'] = $sortBy;
      }
      if(!empty($sortFrom)){
          $conditions['search']['sortFrom'] = $sortFrom;
      }
      if(!empty($sortTo)){
          $conditions['search']['sortTo'] = $sortTo;
      }
      if(empty($keywords) && empty($sortBy) && empty($sortFrom) && empty($sortTo))
      {
        $date = "Month";
      }
      else
      {
        $date = "Back";
      }
      //total rows count
      $totalRec = count((array)$this->Reports->get_so_for_record($conditions,$date));
    //   print_r($totalRec);die;
      //pagination configuration
      $config['target']      = '#So_list';
      $config['base_url']    = base_url().'reports/ajaxReportsSOData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $config['link_func']   = 'searchFilter';
     // $this->ajax_pagination->initialize($config);
      //set start and limit
      $conditions['start'] = $offset;
      $conditions['limit'] = $this->perPage;
      //get posts data
      $sales_data = $this->Reports->get_so_for_record($conditions,$date);

      $fileName = 'Sales-'.time().'.csv';  
      $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total Sales');       
        // set Row
        $rowCount = 2;
        foreach ($sales_data as $element) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['owner']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['sub_totals']);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=$fileName");
        
        
      $object_writer->save('php://output');  
      exit;  
  }
  
  
  public function get_top_po_report()
  {
    $type = $this->session->userdata('type');
    $result = $this->Reports->get_top_po_by_user($type);
    echo json_encode($result);
  }
  
  public function sort_po_graph()
  {
    $type = $this->session->userdata('type');
    $sort_date = $this->input->post('date');
    $from_date = $this->input->post('from_date');
    $to_date = $this->input->post('to_date');
    $data = $this->Reports->get_top_po_by_date($type,$sort_date,$from_date,$to_date);
    /*$sort_date = $this->input->post('date');
    $data = $this->Reports->get_top_po_by_date($sort_date,$type);*/
    echo json_encode($data);
  }
  /**
  * Retrieve purchase order records and output a JSON response suitable for DataTables server-side processing.
  * @example
  * // Simulate POST variables then call:
  * $_POST['start'] = 0;
  * $_POST['draw'] = 1;
  * $this->Reports->get_purchaseorder_for_record();
  * // Sample echoed JSON:
  * // {"draw":1,"recordsTotal":120,"recordsFiltered":80,"data":[["Acme Supplies","1,234.56"],["Beta Traders","2,000.00"]]}
  * @param {array} $_POST - POST payload expected to contain 'start' (int) and 'draw' (int) used for pagination and draw count.
  * @returns {void} Echoes a JSON-encoded array with keys: draw, recordsTotal, recordsFiltered and data.
  */
  public function get_purchaseorder_for_record()
  {
    $list = $this->Reports->get_po_for_record();
    // print_r($list);die;
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
  
      $row[] = $post->owner;
      $row[] = IND_money_format($post->sub_total);
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_po(),
      "recordsFiltered" => $this->Reports->count_filtered_po(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  
  
  
  /**
   * Export purchase records to a downloadable CSV/Excel file.
   * @example
   * // Example (controller context) using POST parameters and invoking the controller method:
   * $_POST['po_keywords'] = 'office supplies';
   * $_POST['po_sortBy']   = 'date';
   * $_POST['po_sortFrom'] = '2025-01-01';
   * $_POST['po_sortTo']   = '2025-01-31';
   * $_POST['page']        = 0;
   * $this->Reports->export_purchase_to_csv();
   * // Triggers download of a file named like "Purchase-1672531200.csv" with content:
   * // Owner,Total Purchase
   * // Acme Corp,12345.67
   * @param string|null $po_keywords - (POST) Keyword(s) to search purchase records. Example: 'office supplies'.
   * @param string|null $po_sortBy - (POST) Field to sort/filter by. Example: 'date' or 'owner'.
   * @param string|null $po_sortFrom - (POST) Start date for date range filter (YYYY-MM-DD). Example: '2025-01-01'.
   * @param string|null $po_sortTo - (POST) End date for date range filter (YYYY-MM-DD). Example: '2025-01-31'.
   * @param int|null $page - (POST) Pagination offset (zero-based). Example: 0.
   * @returns void Forces a download of the generated file and exits the script.
   */
  public function export_purchase_to_csv()
  {
      $conditions = array();
      //calc offset number
      $page = $this->input->post('page');
      if(!$page){
        $offset = 0;
      }else{
          $offset = $page;
      }
      //set conditions for search
      $keywords = $this->input->post('po_keywords');
      $sortBy = $this->input->post('po_sortBy');
      $sortFrom = $this->input->post('po_sortFrom');
      $sortTo = $this->input->post('po_sortTo');
      if(!empty($keywords)){
          $conditions['search']['keywords'] = $keywords;
      }
      if(!empty($sortBy)){
          $conditions['search']['sortBy'] = $sortBy;
      }
      if(!empty($sortFrom)){
          $conditions['search']['sortFrom'] = $sortFrom;
      }
      if(!empty($sortTo)){
          $conditions['search']['sortTo'] = $sortTo;
      }
      if(empty($keywords) && empty($sortBy) && empty($sortFrom) && empty($sortTo))
      {
        $date = "Month";
      }
      else
      {
        $date = "Back";
      }
      //total rows count
      $totalRec = count((array)$this->Reports->get_po_for_record($conditions,$date));
      //pagination configuration
      $config['target']      = '#Po_list';
      $config['base_url']    = base_url().'reports/ajaxReportsPOData';
      $config['total_rows']  = $totalRec;
      $config['per_page']    = $this->perPage;
      $config['link_func']   = 'searchFilter';
      //$this->ajax_pagination->initialize($config);
      //set start and limit
      $conditions['start'] = $offset;
      $conditions['limit'] = $this->perPage;
      //get posts data
      $purchase_data = $this->Reports->get_po_for_record($conditions,$date);
  
      $fileName = 'Purchase-'.time().'.csv';  
    $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Owner');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Total Purchase');       
        // set Row
        $rowCount = 2;
        foreach ($purchase_data as $element) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->owner);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element->sub_total);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=$fileName");
      $object_writer->save('php://output');  
      exit;  
  }


  /**
  * Generate a Sales Order profit table for DataTables or export the table as a CSV file.
  * When called via an AJAX POST it returns a JSON payload suitable for DataTables (draw, recordsTotal, recordsFiltered, data).
  * When POST contains 'exportCsv' it streams an Excel5-compatible CSV download named like "so-by-user-{timestamp}.csv" and exits.
  * @example
  * // Example 1: AJAX POST request for DataTables (returns JSON)
  * // POST payload: start=0, draw=1
  * // Controller call (HTTP POST): /reports/get_so_profit_table
  * // Sample returned JSON (abridged):
  * // {
  * //   "draw": 1,
  * //   "recordsTotal": 123,
  * //   "recordsFiltered": 50,
  * //   "data": [
  * //     ["JohnDoe","01/01/2025","SO123","Acme Corp","10/01/2025","₹1,000.00","<span class=\"btn btn-success\">Completed</span>"],
  * //     ...
  * //   ]
  * // }
  * 
  * // Example 2: Export CSV
  * // POST payload: exportCsv=1
  * // Submitting this POST will prompt a file download: so-by-user-1617181910.csv
  * @param {array} $post - POST data (expects keys like 'start', 'draw' for DataTables; 'exportCsv' to trigger CSV export).
  * @returns {void} Outputs JSON for DataTables or streams a CSV/Excel download and exits.*/
  public function get_so_profit_table()
  {
    $list = $this->Reports->get_so_profit_datatables();
    // print_r($list);die;
	$exprt=$this->input->post('exportCsv');
	if(isset($exprt)){
		//export data in csv...
		
		
		$fileName = 'so-by-user-'.time().'.csv';  
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'USERNAME');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'DATE');       
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SALES ORDER ID');       
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ORGNIZATION NAME');       
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'DUE DATE');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SUB TOTAL');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'SATUS');       
        // set Row
        $rowCount = 2;
        foreach ($list as $element) 
        {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element->owner);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, date('d/m/Y',strtotime($element->currentdate)));
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element->saleorder_id);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element->org_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date('d/m/Y',strtotime($element->due_date)));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element->after_discount);
			
			if($element->total_percent == '0')
			  {
				$spnmsg = 'Completed';
			  }
			  else if($element->total_percent == '100')
			  {
				$spnmsg = 'Pending';
			  }
			  else if($element->total_percent > 0 || $element->total_percent < 100)
			  {
				$spnmsg = 'In Progress';
			  }
			  $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $spnmsg);
            $rowCount++;
        }
        
      $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
      header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=$fileName");
      $object_writer->save('php://output');  
      exit;
		
		
		
	}
	
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
      $no++;
      $row = array();
      // APPEND HTML FOR ACTION
      $row[] = ucfirst($post->owner);
      $row[] = date('d/m/Y',strtotime($post->currentdate));
      $row[] = $post->saleorder_id;
      $row[] = ucfirst($post->org_name);
      $row[] = date('d/m/Y',strtotime($post->due_date));
      $row[] = IND_money_format($post->sub_totals);
      //$row[] = intval($post->total_percent);
      if($post->total_percent == '0')
      {
        $row[] = '<span class="btn btn-success" style="padding:2px;">Completed</span>';
      }
      else if($post->total_percent == '100')
      {
        $row[] = '<span class="btn btn-danger" style="padding:2px;">Pending</span>';
      }
      else if($post->total_percent > 0 || $post->total_percent < 100)
      {
        $row[] = '<span class="btn btn-warning" style="padding:2px;">In Progress</span>';
      }
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_all_so(),
      "recordsFiltered" => $this->Reports->count_filtered_so(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  
  //get_renewal_data
  /**
   * Retrieve renewal data for sales orders and output it as JSON for DataTables.
   * @example
   * // Trigger via controller route (POST expected): /reports/get_renewal_data
   * // Example POST payload:
   * // $_POST['draw'] = 1;
   * // $_POST['start'] = 0;
   * $this->get_renewal_data();
   * // Sample JSON output:
   * // {
   * //   "draw": 1,
   * //   "recordsTotal": 125,
   * //   "recordsFiltered": 10,
   * //   "data": [
   * //     [
   * //       "John",
   * //       "<a href='http://example.com/view-customer/12'>Acme Corp</a>",
   * //       "Product A",
   * //       "<a href='http://example.com/salesorders/view_pi_so/45'>SO-00045</a>",
   * //       "01/12/2024",
   * //       "01/12/2025",
   * //       "₹1,234.00"
   * //     ]
   * //   ]
   * // }
   * @param void No direct function parameters; reads paging values from $_POST['draw'] and $_POST['start'].
   * @returns void Outputs JSON via echo (does not return a PHP value).
   */
  public function get_renewal_data()
  {
    $list = $this->Reports->get_renewal_data_so();
	
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $post)
    {
		$orgid=$post->org_id;
      $no++;
      $row 	 = array();
      $row[] = ucfirst($post->owner);
	  if(isset($orgid) && $orgid!=""){
		$row[] = "<a href='".base_url()."view-customer/".$post->org_id."'>".$post->org_name."</a>";
	  }else{
		$row[] = $post->org_name;
	  }
      $row[] = ucfirst($post->product_name);
      $row[] = "<a href='".base_url()."salesorders/view_pi_so/".$post->id."'>".$post->saleorder_id."</a>";
      $row[] = date('d/m/Y',strtotime($post->currentdate));
	  $row[] = date('d/m/Y',strtotime($post->renewal_date));
      $row[] = IND_money_format($post->sub_totals);
      
      $data[] = $row;
    }
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->Reports->count_renewal_data_so(),
      "recordsFiltered" => $this->Reports->count_filtered_renewal_data_so(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);
  }
  
  public function get_sub_totals_renewal()
  {
    $list = $this->Reports->get_sub_totals_renewal();
	echo $list['sub_totals'];
  }
  
  
  
  
  

//Please write code above this  
}
?>
