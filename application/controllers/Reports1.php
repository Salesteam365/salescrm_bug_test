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
  public function get_salesorder_for_record()
  {
    $list = $this->Reports->get_sales_for_record();
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
  public function get_purchaseorder_for_record()
  {
    $list = $this->Reports->get_po_for_record();
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
  public function get_so_profit_table()
  {
    $list = $this->Reports->get_so_profit_datatables();
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
