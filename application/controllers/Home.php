<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
 /**
 * Initialize the Home controller: calls parent constructor and loads required helpers, models and libraries used by this controller (url helper; Login_model, Salesorders_model, Branch_model, Reports_model, Target_model, roles_model; and the upload and email_lib libraries).
 * @example
 * $home = new Home();
 * // constructs the controller, loading helpers/models/libraries; no return value
 * @param {{void}} {{none}} - No parameters.
 * @returns {{void}} Constructor does not return a value.
 */
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Login_model');
		$this->load->model('Salesorders_model');
		$this->load->model('Branch_model');
		$this->load->model('Reports_model');
		$this->load->model('Target_model');
		$this->load->model('roles_model');
		$this->load->library(array('upload', 'email_lib'));
		
	}


 /**
 * Load and prepare dashboard data for the authenticated user and render the 'users/newdashboard' view; redirects to company setup or login when session data is missing.
 * @example
 * // From a controller context (no arguments required)
 * $this->index();
 * // Result: renders 'users/newdashboard' populated with arrays such as:
 * // $data['total_leads'] = 120;
 * // $data['total_org'] = 45;
 * // or redirects to 'company' or 'login' when appropriate.
 * @param {void} None - No arguments are required for this method.
 * @returns {void} Performs redirects or renders the dashboard view; does not return a value.
 */
	public function index()
    {  
        $list = $this->Reports_model->get_profit_datatables_product_wise();
       
        // unset($_SESSION);
        // $this->session->set_userdata('email','kdevendra7999@gmail.com');
        // $this->session->set_userdata('company_email','kdevendra7999@gmail.com');
        // $this->session->set_userdata('company_name','Developer Team365');
        // $this->session->set_userdata('account_type','Paid');
        // $this->session->set_userdata('type','admin');
        // dd($_SESSION);
        if (!empty($this->session->userdata('email'))) {
            if (empty($this->session->userdata('company_name'))) {
                redirect(base_url('company'));
            }
            $session_comp_email = $this->session->userdata('company_email');
            $sess_eml = $this->session->userdata('email');
            $session_company = $this->session->userdata('company_name');
            $data = array();
            $data['dateyr'] = $this->Target_model->get_DateYear('year');
            $data['datemnth'] = $this->Target_model->get_DateYear('month');
            $data['dateyrGraph'] = $this->Reports_model->get_DateYear('year');
            $data['datemnthGraph'] = $this->Reports_model->get_DateYear('month');
            $data['leads'] = $this->Reports_model->assigned_lead_status($session_comp_email, $sess_eml, $session_company);
            $data['total_org'] = $this->Reports_model->get_all_org();
            $data['total_leads'] = $this->Reports_model->get_all_leads();
            $data['total_opp'] = $this->Reports_model->get_all_opportunities();
            $data['total_quotes'] = $this->Reports_model->get_all_quotation();
            $data['dealstats'] = $this->Reports_model->count_deal_status()->result_array();
           
 
            $type = $this->session->userdata('type');
            if ($type == 'standard') {
                $data['sales_quota'] = $this->Login_model->get_total_so_amount($type);
                $data['profit_quota'] = $this->Login_model->get_total_profit_quota($type);
            }
            if ($type == 'standard') {
                $data['bestTrgtuser'] = $this->Reports_model->TargetGetterUser('standard');
            }
            $this->load->model('Salesorders_model', 'Salesorders');
            $data['renewal_data'] = $this->Salesorders->get_renewal_so();
            $this->load->view('users/newdashboard', $data);
        } else {
            redirect('login');
        }
    }

 /**
  * Get year/month grouped totals for organizations (customers), leads, opportunities and quotes and echo them as JSON.
  * @example
  * $home = new Home();
  * $home->getyeargraph(); // Outputs JSON, e.g. {"totalcustarr":[2,5,1],"totalleadarr":[3,4,0],"totalopparr":[1,2,1],"totalquotearr":[0,1,0]}
  * @param void $none - This controller method accepts no parameters.
  * @returns string JSON-encoded object with keys: totalcustarr, totalleadarr, totalopparr, totalquotearr containing arrays of monthly totals.
  */
	public function getyeargraph(){
        $selyeargraph="YEAR(datetime) AS year, MONTH(datetime) AS month, COUNT(id) AS total";
		$data['totalcust_yeargraph']=$this->Salesorders_model->yeargraph($selyeargraph,'organization')->result_array();
		$data['totalleads_yeargraph']=$this->Salesorders_model->yeargraph($selyeargraph,'lead')->result_array();
		$data['totalopp_yeargraph']=$this->Salesorders_model->yeargraph($selyeargraph,'opportunity')->result_array();
		$data['totalquote_yeargraph']=$this->Salesorders_model->yeargraph($selyeargraph,'quote')->result_array();
         
        $totalcustarr = [];
        $totalleadarr = [];
        $totalopparr = [];
        $totalquotearr = [];


		foreach ($data['totalcust_yeargraph'] as $e) {
			$totalcustarr[] = $e['total'];
		}


		foreach ($data['totalleads_yeargraph'] as $e) {
			$totalleadarr[] = $e['total'];
		}


		foreach ($data['totalopp_yeargraph'] as $e) {
			$totalopparr[] = $e['total'];
		}


		foreach ($data['totalquote_yeargraph'] as $e) {
			$totalquotearr[] = $e['total'];
		}

		$dataa = array(
			'totalcustarr' => $totalcustarr,
			'totalleadarr' => $totalleadarr,
			'totalopparr' => $totalopparr,
			'totalquotearr' => $totalquotearr
		);

		// Return data as JSON
		echo json_encode($dataa);
	}


	public function getdata()
	{
		$data = $this->Reports_model->get_profit_graph();
		echo json_encode($data);
	}

 /**
 * Build and echo HTML <option> elements for months for a given year (taken from POST 'yearsDt').
 * @example
 * // Simulate a POST and call the controller method:
 * $_POST['yearsDt'] = '2020';
 * $this->getMonth();
 * // Sample output: "<option value='01'>January</option><option value='02'>February</option>...<option value='12'>December</option>"
 * @param string $yearsDt - Year value read from POST input 'yearsDt' (e.g. "2020").
 * @returns void Outputs HTML <option> elements for months directly via echo.
 */
	public function getMonth()
	{
		$yearsDt = $this->input->post('yearsDt');
		$data = $this->Reports_model->get_DateYear('month', $yearsDt);
		$txtData = '';
		foreach ($data as $key => $value) {
			$dataU = $value->month;
			$date = date_create('01-' . $dataU . '-2020');
			$dayMnt = date_format($date, "F");
			$dayMnt2 = date_format($date, "m");
			$txtData .= "<option value='" . $dayMnt2 . "'";
			if (date('F') == $dayMnt) {
				$txtData .= "selected";
			}
			$txtData .= ">" . $dayMnt . "</option>";
		}
		echo $txtData;
	}
	public function getdata_by_user()
	{
		$data = $this->Reports_model->get_all_sales_by_user();
		echo json_encode($data);
	}
 /**
 * Sort and output profit graph data for a given date as JSON.
 * @example
 * // Example for admin session:
 * $_POST['date'] = '2025-12-01';
 * $this->session->set_userdata('type', 'admin');
 * $home = new Home();
 * $home->sort_profit_graph();
 * // Example output:
 * // [{"owner":"user123","sub_total":1500},{"owner":"user456","sub_total":-200}]
 * @param string $date - Posted date string in 'YYYY-MM-DD' format (provided via POST).
 * @returns string JSON encoded array: for admin an array of objects {owner, sub_total}; for standard raw sales data array.
 */
	public function sort_profit_graph()
	{
		$type = $this->session->userdata('type');
		if ($type == "admin") {
			$sort_date = $this->input->post('date');
			$salesorder = $this->Reports_model->get_all_sales_by_date($sort_date, $type);
			$response = array();
			foreach ($salesorder as $sales) {
				$purchaseorder = $this->Reports_model->get_after_discount_po($sales['owner']); {
					$data = array("owner" => $sales['owner'], "sub_total" => intval($sales['after_discount']) - intval($purchaseorder['after_discount_po']) - intval($sales['total_orc']),);
					array_push($response, $data);
				}
			}
			echo json_encode($response);
		} else if ($type == "standard") {
			$sort_date = $this->input->post('date');
			$data = $this->Reports_model->get_all_sales_by_date($sort_date, $type);
			echo json_encode($data);
		}
	}
	public function getestimate()
	{
		$type = $this->session->userdata('type');
		$data = $this->Reports_model->get_all_estimate($type);
		if (count($data) > 0) {
			echo json_encode($data);
		} else {
			echo json_encode(array(array('owner' => "No User", 'sub_totalq' => 10)));
		}
	}

	public function sort_estimate_graph()
	{
		$type = $this->session->userdata('type');
		$sort_date = $this->input->post('date');
		$data = $this->Reports_model->get_all_estimate_by_date($sort_date, $type);
		echo json_encode($data);
	}

	public function getOPP()
	{
		$type = $this->session->userdata('type');
		$data = $this->Reports_model->get_top_opp_by_user($type);
		echo json_encode($data);
	}

	public function sort_opportunity_graph()
	{
		$type = $this->session->userdata('type');
		$sort_date = $this->input->post('date');
		$data = $this->Reports_model->get_top_opp_by_date($type, $sort_date);
		echo json_encode($data);
	}
	public function getSO()
	{
		$type = $this->session->userdata('type');
		$data = $this->Reports_model->get_all_so_by_user($type);
		echo json_encode($data);
	}
 /**
 * Get dashboard profit table as JSON for DataTables. Reads $_POST['start'] and $_POST['draw'], retrieves owner profit rows from Reports_model, formats monetary values with IND_money_format and echoes a JSON response.
 * @example
 * $_POST['start'] = 0;
 * $_POST['draw'] = 1;
 * $this->get_dashboard_profit_table();
 * // Sample echoed JSON output:
 * // {"draw":1,"recordsTotal":2,"recordsFiltered":2,"data":[["Alice","₹1,000","₹1,200","₹200"],["Bob","₹2,500","₹3,000","₹500"]]}
 * @param {void} $none - No direct parameters; uses $_POST for input.
 * @returns {void} Echoes a JSON-encoded array structured for DataTables (draw, recordsTotal, recordsFiltered, data).
 */
	public function get_dashboard_profit_table()
	{
		$list = $this->Reports_model->get_dashboard_profit_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post) {
			$no++;
			$row = array();
			$row[] = ucfirst($post->owner);
			$row[] = IND_money_format(intval($post->So_total));
			$row[] = IND_money_format(intval($post->So_total_estimate_price));
			//$calc = intval($post->profitUser);
			$row[] = IND_money_format(intval($post->profitUser));
			$data[] = $row;
		}
		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Reports_model->count_filtered_dashboard_profit(), "recordsFiltered" => $this->Reports_model->count_all_dashboard_profit(), "data" => $data,);
		echo json_encode($output);
	}
	public function get_purchase_profit_graph()
	{
		$list = $this->Reports_model->get_purchase_profit_graph();
		echo json_encode($list);
	}

 /**
 * Retrieve the top ten customers by profit using filters from POST and echo the result as JSON.
 * @example
 * // Simulate POST and session data, then call from a controller
 * $_POST['profitYear'] = '2025';
 * $_POST['profitMoth'] = '08'; // note: parameter name in code is 'profitMoth'
 * $_POST['searchDate'] = '2025-01-01';
 * $_POST['financial_year'] = '2024-2025';
 * $this->session->set_userdata(['type' => 'admin', 'company_email' => 'company@example.com']);
 * $this->gettoptencus();
 * // sample output (JSON string echoed)
 * // {"toptencus":[{"customer":"Acme Ltd","profit":"12345.67"},{"customer":"Beta Co","profit":"9876.54"}, ...]}
 * @param string $profitYear - Year to filter profits (from POST 'profitYear'), e.g. '2025'.
 * @param string $profitMonth - Month to filter profits (from POST 'profitMoth'), e.g. '08'.
 * @param string $searchDate - Start date for the date range (from POST 'searchDate'), format 'YYYY-MM-DD'.
 * @param string $financial_year - Financial year selector (from POST 'financial_year'), e.g. '2024-2025'.
 * @returns string JSON encoded response containing a 'toptencus' array with top customers and profit values.
 */
	public function gettoptencus() {
		$data['toptencus'] = [];
		$profityear = $this->input->post('profitYear');
		$profitmonth = $this->input->post('profitMoth');
		$dateRangeEnd = date('Y-m-d'); // Start from the current date
        $dateRangeStart = $this->input->post('searchDate');
		$financial = $this->input->post('financial_year');
	
		if ($this->session->userdata('type') == 'admin') {
			$whr = [
				'session_comp_email' => $this->session->userdata('company_email')
			];
			$data['toptencus'] = $this->Reports_model->gettoptencus($whr,$profityear,$profitmonth,$dateRangeStart,$dateRangeEnd,$financial);
		} else if ($this->session->userdata('type') == 'standard') {
			$whr = [
				'sess_eml' => $this->session->userdata('email'),
				'session_comp_email' => $this->session->userdata('company_email')
			];
			
			$data['toptencus'] = $this->Reports_model->gettoptencus($whr, $profityear,$profitmonth,$dateRangeStart,$dateRangeEnd,$financial);
		}
	
		echo json_encode($data);
	}
	
 /**
 * Fetches top quotations based on POST filters and the current session, renders them as HTML table rows and echoes a JSON-encoded string of that HTML.
 * @example
 * // Example usage from a controller context (POST and session must be set):
 * // POST: profitYear=2025, profitMoth=06, searchDate=2025-01-01, financial_year=2024-2025
 * // Session: type='admin', company_email='company@example.com'
 * $this->input->post('profitYear') = '2025';
 * $this->input->post('profitMoth') = '06';
 * $this->input->post('searchDate') = '2025-01-01';
 * $this->input->post('financial_year') = '2024-2025';
 * $this->session->set_userdata(['type' => 'admin', 'company_email' => 'company@example.com']);
 * $this->topquotes();
 * // Sample echoed output (JSON string containing HTML table rows):
 * // "\"<tr class=\\\"...\\\">...<\\/tr>\""
 * @param string|int $profitYear - POST 'profitYear' filter (year). Example: '2025'.
 * @param string|int $profitMoth - POST 'profitMoth' filter (month). Example: '06'.
 * @param string $searchDate - POST 'searchDate' filter (start date in Y-m-d). Example: '2025-01-01'.
 * @param string $financial_year - POST 'financial_year' filter. Example: '2024-2025'.
 * @returns string JSON-encoded HTML string containing table rows for the top quotations (this method echoes the result).
 */
	public function topquotes(){
		$data['topquotes'] = [];
		$profityear = $this->input->post('profitYear');
		$profitmonth = $this->input->post('profitMoth');
		$dateRangeEnd = date('Y-m-d'); // Start from the current date
        $dateRangeStart = $this->input->post('searchDate');
		$financial = $this->input->post('financial_year');
	
		if ($this->session->userdata('type') == 'admin') {
			$whr = [
				'session_comp_email' => $this->session->userdata('company_email')
			];
			$data['topquotes'] = $this->Reports_model->gettoptencus($whr,$profityear,$profitmonth,$dateRangeStart,$dateRangeEnd,$financial);
		} else if ($this->session->userdata('type') == 'standard') {
			$whr = [
				'sess_eml' => $this->session->userdata('email'),
				'session_comp_email' => $this->session->userdata('company_email')
			];
			
			$data['topquotes'] = $this->Reports_model->gettoptencus($whr, $profityear,$profitmonth,$dateRangeStart,$dateRangeEnd,$financial);
		}
		$top = $data['topquotes']=$this->Reports_model->toptenquote($whr, $profityear,$profitmonth,$dateRangeStart,$dateRangeEnd,$financial)->result_array();
		$output='';
		
         foreach($top as $top){
             $output.='<tr class="border border-inherit border-solid hover:bg-gray-100 dark:border-defaultborder/10 dark:hover:bg-light">
			 <th scope="row" class="!ps-4 !pe-5"><input class="form-check-input" type="checkbox"
				 id="checkboxNoLabel2" value="" aria-label="..."></th>
			 <td>
			   <div class="flex items-center font-semibold">
				 <span class="!me-2 inline-flex justify-center items-center">
				   <img src="'.base_url('').'/application/views/assets/images/faces/4.jpg" alt="img"
					 class="w-[1.75rem] h-[1.75rem] leading-[1.75rem] text-[0.65rem]  rounded-full">&nbsp;&nbsp;'.$top['org_name'].'
				 </span>
			   </div>
			 </td>
			 <td>'.$top['sess_eml'].'</td>
			 <td>₹ '.$top['sub_totalq'].'</td>
			 <td>
			   <span
				 class="inline-flex text-info !py-[0.15rem] !px-[0.45rem] rounded-sm !font-semibold !text-[0.75em] bg-info/10">'.$top['quote_stage'].'</span>
			 </td>
			 <td>'.$top['currentdate'].'</td>
			 <td>
			   <div class="flex flex-row items-center !gap-2 text-[0.9375rem]">
				 <a download aria-label="anchor" href="'.base_url().'quotation/view/' . $top['id'] . '/dn"
				   class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-success/10 text-success hover:bg-success hover:text-white hover:border-success"><i
					 class="ri-download-2-line"></i></a>
				 <a aria-label="anchor" href="'.base_url().'add-quote/' . $top['id'] . '"
				   class="ti-btn ti-btn-icon ti-btn-wave !gap-0 !m-0 !h-[1.75rem] !w-[1.75rem] text-[0.8rem] bg-primary/10 text-primary hover:bg-primary hover:text-white hover:border-primary"><i
					 class="ri-edit-line"></i></a>
			   </div>
			 </td>
		   </tr>';
		   
		 }
    echo json_encode($output);

	}
	/*
	public function sort_salesorder_graph()
		{
		$type = $this->session->userdata('type');
		$sort_date = $this->input->post('date');
		$data = $this->Reports_model->get_all_so_by_date($sort_date,$type);
		echo json_encode($data);
		}
		*/
			/*
		public function get_dashboard_profit_table()
		{
		$list = $this->Reports_model->get_dashboard_profit_datatables();
		//print_r($list);die;
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post)
		{
		$no++;
		$row = array();
		// APPEND HTML FOR ACTION
		$row[] = ucfirst($post->owner);
		$row[] = IND_money_format(intval($post->So_total));
		$row[] = IND_money_format(intval($post->So_total_estimate_price));
		//$calc = intval($post->So_total) - intval($post->So_total_estimate_price) - intval($post->totalOrc);
		// $row[] = IND_money_format(intval($calc));
		$row[] = IND_money_format(intval($post->profitUser));
		$data[] = $row;
		}
		$output = array(
		"draw" => $_POST['draw'],
		"recordsTotal" => $this->Reports_model->count_all_dashboard_profit(),
		"recordsFiltered" => $this->Reports_model->count_filtered_dashboard_profit(),
		"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	*/
	public function profile()
	{
		if (!empty($this->session->userdata('email'))) {
			$data = array();
			$data['roles'] = $this->roles_model->get_allroles();
			$data['plan_name'] = $this->Login_model->yourplanid();
			//$data['plan_name']  = $this->Login_model->plan_name();
			/* $data['basic']        = $this->Login_model->active_basic_lic();
			$data['business']     = $this->Login_model->active_business_lic();
			$data['enterprise']   = $this->Login_model->active_enterprise_lic();*/
			$data['users_data'] = $this->Login_model->get_company_users();
			$this->load->view('users/profile', $data);
		} else {
			redirect('login');
		}
	}
 /**
 * Update the current user's profile (admin or standard). Validates input, processes optional file uploads
 * (company logo for admin, profile image for standard users), updates the database via Login_model and
 * echoes a JSON status on success or a validation error code on failure.
 * @example
 * // Example usage from a controller context (simulating POST and FILES)
 * $_POST = [
 *   'id' => 123,
 *   'name' => 'Acme Admin',
 *   'email' => 'admin@acme.com',
 *   'company_contact' => '1234567890',
 *   'country' => 'USA',
 *   'state' => 'CA',
 *   'city' => 'San Francisco',
 *   'address' => '1 Market St',
 *   'zipcode' => '94105'
 * ];
 * // Optional file upload for admin:
 * $_FILES['company_logo'] = ['name' => 'logo.png', 'tmp_name' => '/tmp/php123', 'type' => 'image/png', 'size' => 102400];
 * // Then call the controller method:
 * $this->update_profile();
 * // Expected echoed output on success:
 * // {"status":200}
 * @param {{int}} {{id}} - User ID from POST (identifies which profile to update).
 * @param {{string}} {{name}} - Name from POST. For admin -> admin_name; for standard -> standard_name.
 * @param {{string}} {{email}} - Admin email from POST (POST key 'email'), required for admin updates.
 * @param {{string}} {{company_contact}} - Company contact number from POST (used for admin).
 * @param {{string}} {{contact_number}} - Contact number from POST (used for standard users).
 * @param {{string}} {{country}} - Country from POST.
 * @param {{string}} {{state}} - State from POST.
 * @param {{string}} {{city}} - City from POST.
 * @param {{string}} {{address}} - Company address from POST (used for admin).
 * @param {{string}} {{zipcode}} - Postal/ZIP code from POST.
 * @param {{array}} {{company_logo}} - Optional uploaded file array in $_FILES['company_logo'] for admin (allowed types: jpg|jpeg|png, max size 2MB).
 * @param {{array}} {{profile_image}} - Optional uploaded file array in $_FILES['profile_image'] for standard users (allowed types: jpg|jpeg|png, max size 2MB).
 * @param {{string}} {{session_type}} - Current session user type ('admin' or 'standard') used to determine the update flow.
 * @returns {{void}} Echoes JSON with status 200 on successful update or echoes a validation error code on failure.
 */
	public function update_profile()
	{
		$validation = $this->check_validation();
		if ($validation != 200) {
			echo $validation;
			die;
		} else {
			$id = $this->input->post('id');
			$image_data = $this->Login_model->get_image_name($id);
			$image_name = $image_data['company_logo'];
			if ($this->session->userdata('type') == 'admin') {
				$id = $this->input->post('id');

				if (!empty($_FILES["company_logo"]['name'])) {
					$dirpath = './uploads/company_logo/';
					//unlink($dirpath.$image_name);
					$config['upload_path'] = './uploads/company_logo/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 2097152;
					$logo_name = time() . "_" . str_replace(' ', '_', $_FILES["company_logo"]['name']);
					$config['file_name'] = $logo_name;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('company_logo');
					$uploadData = $this->upload->data();
					$uploadedFile = $uploadData['file_name'];
				} else {
					$logo_name = $image_name;
				}
				$data = array('admin_name' => $this->input->post('name'), 'admin_email' => $this->input->post('email'), 'admin_mobile' => $this->input->post('company_contact'), 'country' => $this->input->post('country'), 'state' => $this->input->post('state'), 'city' => $this->input->post('city'), 'company_address' => $this->input->post('address'), 'zipcode' => $this->input->post('zipcode'), 'company_logo' => $logo_name,);
				$standard_user = $this->Login_model->update_standard_user_profile($logo_name);
			} else if ($this->session->userdata('type') == 'standard') {
				$user_profile_data = $this->Login_model->get_user_profile_image($id);
				$user_profile_image = $user_profile_data['profile_image'];
				if (!empty($_FILES["profile_image"]['name'])) {
					$profile_path = './uploads/profile_image/';;
					unlink($profile_path . $user_profile_image);
					$config['upload_path'] = './uploads/profile_image/';
					$config['allowed_types'] = 'jpg|jpeg|png';
					$config['max_size'] = 2097152;
					$profile_image = $id . '_' . time() . "_" . str_replace(' ', '_', $_FILES["profile_image"]['name']);
					$config['file_name'] = $profile_image;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('profile_image');
					$uploadData = $this->upload->data();
					$uploadedFile = $uploadData['file_name'];
					//echo $this->upload->display_errors();die();

				} else {
					$profile_image = $user_profile_image;
				}
				$data = array('standard_name' => $this->input->post('name'), 'standard_mobile' => $this->input->post('contact_number'), 'profile_image' => $profile_image,);
			}
			$result = $this->Login_model->update_profile($data, $id);
			if ($result) {
				echo json_encode(array("status" => 200));
			}
			//redirect('login');

		}
	}

 /**
  * Validate posted form fields based on current user type (admin or standard) and return validation result.
  * @example
  * // From within a controller:
  * $result = $this->check_validation();
  * echo $result;
  * // Possible outputs:
  * // Success: 200
  * // Admin validation failure (JSON string):
  * // {"st":202,"name":"Name is required","mobile":"","email":"Email is not valid","company_contact":"Contact Number is not valid","country":"","state":"","city":"","address":"","zipcode":""}
  * // Standard user validation failure (JSON string):
  * // {"st":202,"name":"Name is required","contact_number":"Contact Number is not valid"}
  * @returns {int|string} 200 on success (int) or JSON-encoded array of field errors on validation failure (string).
  */
	public function check_validation()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'valid_email|trim');
		if ($this->session->userdata('type') == 'admin') {
			$this->form_validation->set_rules('company_contact', 'Contact Number', 'regex_match[/^[0-9]{10}$/]|trim');
			$this->form_validation->set_rules('country', 'Country', 'required|trim');
			$this->form_validation->set_rules('state', 'State', 'required|trim');
			$this->form_validation->set_rules('city', 'City', 'required|trim');
			$this->form_validation->set_rules('address', 'Address', 'required|trim');
			$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
		} else if ($this->session->userdata('type') == 'standard') {
			$this->form_validation->set_rules('contact_number', 'Contact Number', 'regex_match[/^[0-9]{10}$/]|trim');
		}
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is not valid');
		$this->form_validation->set_message('regex_match', '%s is not valid');
		if ($this->form_validation->run() == FALSE) {
			if ($this->session->userdata('type') == 'admin') {
				return json_encode(array('st' => 202, 'name' => form_error('name'), 'mobile' => form_error('mobile'), 'email' => form_error('email'), 'company_contact' => form_error('company_contact'), 'country' => form_error('country'), 'state' => form_error('state'), 'city' => form_error('city'), 'address' => form_error('address'), 'zipcode' => form_error('zipcode')));
			} else if ($this->session->userdata('type') == 'standard') {
				return json_encode(array('st' => 202, 'name' => form_error('name'), 'contact_number' => form_error('contact_number')));
			}
		} else {
			return 200;
		}
	}
 /**
 * Check whether a user email already exists and echo appropriate HTML/JS response.
 * @example
 * // Example 1: Email exists as admin
 * $_POST['standard_email'] = 'admin@example.com';
 * $this->checkUserExist();
 * // Echoed output:
 * // <i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists as a admin
 * // <script>$('#standard_email').val('');</script>
 * 
 * // Example 2: Email exists as standard user
 * $_POST['standard_email'] = 'user@example.com';
 * $this->checkUserExist();
 * // Echoed output:
 * // <i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists
 * // <script>$('#standard_email').val('');</script>
 * 
 * // Example 3: Email does not exist
 * $_POST['standard_email'] = 'newuser@example.com';
 * $this->checkUserExist();
 * // Echoed output:
 * // <script>$('#add_user_btn').prop('disabled',false);</script>
 * @param {string} $standard_email - The email address retrieved from POST key 'standard_email'.
 * @returns {void} Outputs HTML/JS directly; does not return a value.
 */
	public function checkUserExist()
	{
		$standard_email = $this->input->post('standard_email');
		$status = $this->Login_model->checkemail($standard_email);
		if ($status == 'admin') {

			echo '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists as a admin';
			echo "<script>$('#standard_email').val('');</script>";
		} else if ($status == 'standard_users') {
			echo '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists';
			echo "<script>$('#standard_email').val('');</script>";
		} else {
			echo "<script>$('#add_user_btn').prop('disabled',false);</script>";
		}
	}
 /**
 * Check whether the current logged-in user (partner, admin or user) can add another user based on licence limits, then echo a JSON response or plain status code.
 * @example
 * // Called from a controller context (no arguments). Possible outputs:
 * $this->checkUserPartner();
 * // Possible plain output:
 * // 200
 * // Possible JSON output:
 * // {"st":201,"show_msg":"<i class=\"fas fa-info-circle\">You have only 5 licences and you have already Added 4 Users</i>"}
 * @param void - No parameters.
 * @returns void Echoes a status code (200) or a JSON object with keys 'st' and 'show_msg' describing licence availability.*/
	public function checkUserPartner()
	{
		//$standard_email = $this->input->post('standard_email');
		$no_of_rows = $this->Login_model->checkuser();
		$user_type = $this->session->userdata('user_type');
		if ($user_type == 'partner') {
			if ($no_of_rows <= 5) {
				if ($no_of_rows == 5) {
					echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you have already Added 4 Users</i>'));
					exit;
				}
				echo 200;
			} else {
				echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you can add only 4 users</i>'));
			}
		} else {
			/******check admin & user for paid and trial*********/
			$list = $this->Login_model->get_company_users();
			$Adminlist = $this->Login_model->get_admin_detail();
			$totalEntry = count($list) + count($Adminlist);
			foreach ($Adminlist as $admin) :
				if ($admin->account_type == 'Trial') {
					if ($totalEntry <= 5) {
						if ($totalEntry == 5) {
							echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you have already Added 4 Users</i>'));
							exit;
						}
						echo json_encode(array('st' => 200));
					} else {
						echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you add ' . $totalEntry . ' users</i>'));
					}
				} else if ($admin->account_type == 'Paid') {
					$planList = $this->Login_model->yourplanid();
					$totalLicece = 0;
					$usedTotalLicece = 0;
					for ($i = 0; $i < count($planList); $i++) {
						$licence = $planList[$i]['plan_licence'];
						$totalLicece = $totalLicece + $licence;
						$usedLicence = $planList[$i]['used_licence'];
						$usedTotalLicece = $usedTotalLicece + $usedLicence;
					}
					if ($totalLicece > $usedTotalLicece) {
						echo json_encode(array('st' => 200));
					} else {
						echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only ' . $totalLicece . ' licences and you are using ' . ($usedTotalLicece) . ' licence already.</i>'));
					}
				}
			endforeach;
		}
	}

 /**
 * Create a new standard user for the current company if a licence is available: handles optional profile image upload, increments the plan's used licence, saves user data, sends a welcome email and outputs JSON response or error messages.
 * @example
 * // Simulate POST input and optional file upload before calling controller method:
 * $_POST = [
 *   'license_type'    => 2,
 *   'first_name'      => 'John',
 *   'last_name'       => 'Doe',
 *   'standard_name'   => 'John Doe',
 *   'standard_email'  => 'john.doe@example.com',
 *   'standard_mobile' => '9876543210',
 *   'standard_password'=> 'Secret123',
 *   'sel_role'        => 3,
 *   'reports_to'      => 1,
 *   'user_type'       => 'employee'
 * ];
 * // Optional file:
 * // $_FILES['profile_image'] = ['name'=>'avatar.png', 'tmp_name'=>'/tmp/php...','type'=>'image/png', ...];
 * $this->Home->create(); // Echoes JSON: {"status":true} on success or error JSON like {"st":201,"show_msg":"..."} on failure.
 * @param void No direct parameters. Uses CodeIgniter's input->post() and $_FILES to read data.
 * @returns void Outputs JSON or plain messages and terminates execution (echo/exit).
 */
	public function create()
	{
		
		$validation = $this->check_user_validation();
		if ($validation !== 200) {
			echo $validation;
			die;
		} else {

			$planId = $this->input->post('license_type');
			//echo '<pre>';print_r($planId);exit;
			$planDetail = $this->Login_model->yourplanid($planId);
			//  echo '<pre>';print_r($planDetail);exit;
			if ($planDetail['plan_licence'] > $planDetail['used_licence']) {
				if (!empty($this->input->post('first_name'))) {
					$standard_name = $this->input->post('first_name') . " " . $this->input->post('last_name');
					
				} else {
					
					$standard_name = $this->input->post('standard_name');
				}
				$type = "standard";
				$product_type = "CRM";
				

				if (!empty($_FILES["profile_image"]['name'])) {
					$dirpath = './uploads/company_logo/';
					//unlink($dirpath.$image_name);
					$config['upload_path'] = './uploads/company_logo/';

					$config['allowed_types'] = 'jpg|jpeg|png';
					// $config['max_size'] = 2097152;

					$logo_name = time() . "_" . str_replace(' ', '_', $_FILES["profile_image"]['name']);
					$config['file_name'] = $logo_name;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->do_upload('profile_image');

					$uploadData = $this->upload->data();
					$uploadedFile = $uploadData['file_name'];

					// print_r($logo_name);die;
				} else {
					$logo_name = $image_name;

					// print_r($standard_name);die;
				}


				$data = array(
					
					'standard_name' => $standard_name,
					'sub_domain' => $this->session->userdata('sub_domain'), 
					'standard_email' => $this->input->post('standard_email'),

					'user_photo'  => $logo_name,

				  	'standard_mobile' => $this->input->post('standard_mobile'),
				   	'standard_password' => md5($this->input->post('standard_password')),
				    'your_plan_id' => $this->input->post('license_type'), 
					'admin_name' => $this->session->userdata('name'), 
					'type' => $type, 'product_type' => $product_type, 
					'role_id' => $this->input->post('sel_role'), 
					'reports_to' => $this->input->post('reports_to'), 
					'user_type' => $this->input->post('user_type'), 
					'account_type' => $this->session->userdata('account_type'), 
					'company_name' => $this->session->userdata('company_name'), 
					'country' => $this->session->userdata('country'), 
					'state' => $this->session->userdata('state'), 
					'city' => $this->session->userdata('city'), 
					'company_address' => $this->session->userdata('company_address'), 
					'zipcode' => $this->session->userdata('zipcode'), 
					'company_mobile' => $this->session->userdata('company_mobile'), 
					'company_email' => $this->session->userdata('company_email'), 
					'company_website' => $this->session->userdata('company_website'), 
					'company_gstin' => $this->session->userdata('company_gstin'), 
					'pan_number' => $this->session->userdata('pan_number'), 
					'cin' => $this->session->userdata('cin'), 'status' => 1, 
					'company_logo' => $this->session->userdata('company_logo'), 
					'terms_condition_customer' => $this->session->userdata('terms_condition_customer'), 
					'terms_condition_seller' => $this->session->userdata('terms_condition_seller'),
					
				);



				$usedLicence = $planDetail['used_licence'];
				$updateLic = ($usedLicence + 1);
				//  echo '<pre>';print_r($data);exit;
				$this->Login_model->create($data);
				$updateLiArr = array('used_licence' => $updateLic);
				$this->Login_model->updateLicence($updateLiArr, $planDetail['id']);
				/******check admin & user for paid and trial*********/
				//	$list       = $this->Login_model->get_company_users();
				//	$Adminlist  = $this->Login_model->get_admin_detail();
				//	$totalEntry = count($list)+count($Adminlist);
				/*	foreach($Adminlist as $admin):
                if($admin->account_type == 'Trial'){
                if($totalEntry <= 5)
                {
                if($totalEntry == 5){
                echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you have already Added 4 Users</i>'));
                exit;
                }

                //Add user
                //$this->Login_model->create($data);
                //echo json_encode(array('st' => 200));

                }else{
                echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you add '.$totalEntry.' users</i>')); exit;
                }
                }else if($admin->account_type == 'Paid'){

                if($totalEntry <= $admin->total_licence)
                {
                if($totalEntry == $admin->total_licence){
                echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only '.$admin->total_licence.' licences and you add only '.($admin->total_licence-1).' users</i>'));
                exit;
                }

                //Add user
                //$this->Login_model->create($data);
                //echo json_encode(array('st' => 200));
                }else{

                echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only '.$admin->total_licence.' licences and you can add only '.($admin->total_licence-1).' users</i>')); exit;
                }
                }
                endforeach;*/
				$bodymsg = '<!doctype html>
		<html>
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Simple Transactional Email</title>
		<style>
		body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}
			table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}
			table td{font-family:sans-serif;font-size:14px;vertical-align:top}
			.body{background-color:#f6f6f6;width:100%}.container{display:block;Margin:0 auto!important;max-width:580px;padding:10px;width:580px}
			.content{box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:3px;width:100%}
			.wrapper{box-sizing:border-box;padding:20px}.footer{clear:both;padding-top:10px;text-align:center;width:100%}.footer a,.footer p,.footer span,
			.footer td{color:#999;font-size:12px;text-align:center}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}
			.powered-by a{text-decoration:none}@media only screen and (max-width:620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}
			table[class=body] a,table[class=body] ol,table[class=body] p,table[class=body] span,table[class=body] td,table[class=body] ul{font-size:16px!important}table[class=body] .article,table[class=body]
			.wrapper{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body]
			.main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body]
			.btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,
			.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;
			font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}}

		</style>
		</head>
		<body class="">
		<table border="0" cellpadding="0" cellspacing="0" class="body">
		<tr>
		<td>&nbsp;</td>
		<td class="container">
		<div class="content">
		<span class="preheader">Welcome, your added in ' . $this->session->userdata('company_name') . ' as a user.</span>
		<table class="main">
			<tr>
			<td class="wrapper">
			<table border="0" cellpadding="0" cellspacing="0">
			<tr>
			<td style="text-align: center;">
			<h2>WELCOME</h2>
			<h3>Dear, ' . $standard_name . '</h3>
			<h4>A new account created for you. Find detail bellow.</h4>
			<table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
			<tbody>
				<tr>
				<td align="left">
				<table border="0" cellpadding="0" cellspacing="0">
				<tbody>
				<tr>
				<td style="width: 30%;">Login url</td>
				<td> : </td>
				<td>' .base_url(). '</td>
				</tr>
				<tr>
				<td>Username/email</td>
				<td> : </td>
				<td>' . $this->input->post('standard_email') . '</td>
				</tr>
				<tr>
				<td>Password</td>
				<td> : </td>
				<td>' . $this->input->post('standard_password') . '</td>
				</tr>
				<tr>
				<td>Your Organization Name</td>
				<td> : </td>
				<td>' . $this->session->userdata('company_name') . '</td>
				</tr>
				</tbody>
				</table>
				</td>
				</tr>
			</tbody>
			</table>
								<p>Your account created by ' . $this->session->userdata('name') . ' as a user. if you have any problem to login, you can change your password.</p>
			<p>If you received this email by mistake, simply delete it.</p>
			</td>
			</tr>
			</table>
			</td>
			</tr>
		</table>
		<div class="footer">
			<table border="0" cellpadding="0" cellspacing="0"> <tr>
					<td class="content-block"> <span class="apple-link">team365.io</span>  </td>
			</tr>
			<tr> <td class="content-block powered-by">  Powered by <a href="https://www.allegientservices.com/">Customer Success Technology Pvt Ltd.</a>.
			</td> </tr>
			</table>
		</div>
		</div>
		</td>
		<td>&nbsp;</td>
		</tr>
		</table>
		</body>
		</html>';
				$subject = 'Your new account created by ' . $this->session->userdata('name');
				$this->email_lib->send_email($this->input->post('standard_email'), $subject, $bodymsg);
				echo json_encode(array("status" => TRUE));
			} else {
				if ($planDetail['account_type'] == 'Paid') {
					echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only ' . $planDetail['plan_licence'] . ' licence, you are already used all licence in this plan</i>'));
					exit;
				}
				if ($planDetail['account_type'] == 'Trial') {
					echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You are using the trial accout, you can access only 5 licenses</i>'));
					exit;
				}
			}
		}
	}
	
 /**
 * Validate posted user email and mobile fields and return validation status or errors.
 * @example
 * // Example when validation fails (missing or invalid fields):
 * $result = $this->check_user_validation();
 * echo $result; // outputs: {"st":202,"standard_email":"Email is required","standard_mobile":"Number is not valid"}
 *
 * // Example when validation passes:
 * $result = $this->check_user_validation();
 * echo $result; // outputs: 200
 * @param void $none - This method does not accept any arguments; it validates POST data (standard_email, standard_mobile).
 * @returns int|string Returns integer 200 on successful validation, or a JSON-encoded string containing 'st' => 202 and form error messages for 'standard_email' and 'standard_mobile' on failure.
 */
	public function check_user_validation()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
		$this->form_validation->set_rules('standard_email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('standard_mobile', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is not valid');
		$this->form_validation->set_message('regex_match', '%s is not valid');
		if ($this->form_validation->run() == FALSE) {
			return json_encode(array('st' => 202, 'standard_email' => form_error('standard_email'), 'standard_mobile' => form_error('standard_mobile')));
		} else {
			return 200;
		}
	}
	public function check_duplicate_user()
	{
		$standard_name = $this->input->post('standard_name');
		$check_name = $this->Login_model->check_duplicate_user($standard_name);
		if ($check_name == 202) {
			echo json_encode(array('st' => 202));
		} else if ($check_name == 200) {
			echo json_encode(array('st' => 200));
		}
	}
	public function viewUser()
	{
		if (!empty($this->session->userdata('email'))) {
			$data = array();
			$data['roles'] = $this->roles_model->get_allroles();
			$data['plan_name'] = $this->Login_model->yourplanid();
			$this->load->view('users/view_user', $data);
		} else {
			redirect('login');
		}
	}

	
 /**
 * Returns a JSON response for an AJAX DataTable containing company users and admin users.
 * @example
 * // Controller-level call (typical CodeIgniter request via HTTP)
 * // POST parameters expected: draw=1, start=0
 * $response = $this->ajax_user_table();
 * // This method echoes JSON directly. Example echoed output:
 * // {"draw":1,"recordsTotal":42,"recordsFiltered":10,"data":[["<img src=\"...\">","Admin Name<div class=\"links\">...","admin@example.com","9876543210","http://site.com","GSTIN123","License","<input type=\"checkbox\" value=\"1\">"],[...] ]}
 * @param int $draw - DataTables draw counter (expected in $_POST['draw']).
 * @param int $start - Paging start offset (expected in $_POST['start']).
 * @returns void Echoes a JSON-encoded array containing draw, recordsTotal, recordsFiltered and data for DataTables. Redirects to the login page if no active session. */
	public function ajax_user_table()
	{
		if (!empty($this->session->userdata('email'))) {
			$list = $this->Login_model->get_company_users();
			// print_r($list);die;

			$Adminlist = $this->Login_model->get_admin_detail();

			$totalEntry = count($list) + count($Adminlist);
			$data = array();
			$no = $_POST['start'];
			foreach ($Adminlist as $post) {
				if ($post->account_type == "End") {
					$update_data = array('status' => 0);
					$this->db->where('company_name', $this->session->userdata('company_name'));
					$this->db->where('company_email', $this->session->userdata('company_email'));
					$this->db->where('admin_name', $post->admin_name);
					$this->db->update('standard_users', $update_data);
				}
				$no++;
				$row = array();
				// APPEND HTML FOR ACTION

				if (!empty($post->user_photo)) {
					$row[] = '<img src="' . base_url('uploads/company_logo/' . $post->user_photo) . '" alt="Logo" class="img-fluid" style="max-width: 100px;">';
				} else {
					$row[] = '<span>No User </span>'; 
				}
				



				$row[] = $post->admin_name . '<div class="links">
				  <a style="text-decoration:none" href="javascript:void(0)" onclick="set_target(' . "'" . $post->id . "'" . ',`' . $post->admin_name . '`,`admin` ,`' . $post->admin_email . '`)" class="text-primary">Set Target</a>
				  </div>';
				$row[] = $post->admin_email;
				$row[] = $post->admin_mobile;
				$row[] = $post->company_website;
				$row[] = $post->company_gstin;
				$row[] = $post->license_type;
				$row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
				$data[] = $row;
			}

			foreach ($list as $post) {
				$no++;
				$row = array();
				// APPEND HTML FOR ACTION
				// print_r($post->user_photo);die;
					$user_img = $post['user_photo'];

				if (!empty($user_img)) {
					$row[] = '<img src="' . base_url('uploads/company_logo/' . $user_img) . '" alt="Logo" class="img-fluid" style="max-width: 100px;">';
				} else {
					$row[] = '<span>No User </span>'; 
				}
				
				$first_row = $post['standard_name'];
				$first_row .= '<div class="links">';
				if ($post['status'] == 1) :
					$first_row .= '<a style="text-decoration:none" href="javascript:void(0)" onclick="view(' . "'" . $post['id'] . "'" . ')" class="text-success">View</a> | <a style="text-decoration:none" href="' . base_url() . 'set-restriction/' . $post['standard_name'] . '?u=' . $post['id'] . '" class="text-primary">Set Restriction</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="update(' . "'" . $post['id'] . "'" . ')" class="text-primary">Update</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="set_target(' . "'" . $post['id'] . "'" . ',`' . $post['standard_name'] . '`,`standard`,`' . $post['standard_email'] . '`)" class="text-primary">Set Target</a>
				  | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post['id'] . "'" . ')" class="text-danger">Delete</a>
				  ';
				endif;
				$first_row .= '</div>';
				$row[] = $first_row;
				$row[] = $post['standard_email'];
				$row[] = $post['standard_mobile'];
				$row[] = $post['company_website'];
				$row[] = $post['company_gstin'];
				$dataPl = $this->Login_model->plan_name($post['your_plan_id']);
				if ($dataPl != null) {
					$row[] = $dataPl['plan_name'];
				} else {
					$row[] = 'NA';
				}
				$data[] = $row;
			}
			$totalRecord = $this->Login_model->count_all();
			$totalRecord = $totalRecord + 1;
			$output = array(
				"draw" => $_POST['draw'], "recordsTotal" => $totalRecord, "recordsFiltered" => $totalEntry, //$this->Login_model->count_filtered(),
				"data" => $data,
			);
			echo json_encode($output);
		} else {
			redirect('login');
		}
	}


 /**
 * Retrieve user list formatted for DataTables and output it as JSON.
 * @example
 * // Simulate a POST request context before calling the controller method:
 * $_POST['start'] = 0;
 * $_POST['draw']  = 1;
 * $this->view_user();
 * // Sample echoed JSON (example output truncated):
 * // {"draw":1,"recordsTotal":42,"recordsFiltered":42,"data":[["John Doe<div class=\"links\">...","john@example.com","9876543210","example.com","22AAAAA0000A1Z5","Premium"], ...]}
 * @param array $_POST - Expected POST parameters: 'start' (int offset for paging), 'draw' (int DataTables draw counter).
 * @returns void Outputs a JSON-encoded array compatible with DataTables containing "draw", "recordsTotal", "recordsFiltered" and "data" rows.
 */
	public function view_user()
	{
		$list = $this->Login_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post) {
			$no++;
			$row = array();
			// APPEND HTML FOR ACTION

			// $row[] = $post->user_photo;
			$row[] = ucwords($post->standard_name) . '<div class="links">
	      <a style="text-decoration:none" href="javascript:void(0)" onclick="view(' . "'" . $post->id . "'" . ')" class="text-info">View</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="update(' . "'" . $post->id . "'" . ')" class="text-secondary">Update</a>
	      | <a style="text-decoration:none" href="javascript:void(0);" class="text-success" onclick="set_target(' . "'" . $post->id . "'" . ')">Set Target</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_user(' . "'" . $post->id . "'" . ')" class="text-danger">Delete</a>
	      </div>';

			$row[] = $post->standard_email;
			$row[] = $post->standard_mobile;
			$row[] = $post->company_website;
			$row[] = $post->company_gstin;
			$row[] = $post->license_type;
			$data[] = $row;
		}
		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Login_model->count_all(), "recordsFiltered" => $this->Login_model->count_filtered(), "data" => $data,);
		//output to json format
		echo json_encode($output);
	}

	public function delete_bulk()
	{
		if ($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');
			for ($count = 0; $count < count($id); $count++) {
				$this->Login_model->delete_bulk($id[$count]);
			}
		}
	}
	public function getuserbyId($id)
	{
		$data = $this->Login_model->get_by_id($id);
		echo json_encode($data);
	}
	public function planName()
	{
		$id = $this->input->post('dataid');
		$data = $this->Login_model->plan_name($id);
		echo $data['plan_name'];
	}
	public function get_target_data()
	{
		$id = $this->input->post('id');
		$data = $this->Login_model->get_user_target_data($id);
		echo json_encode($data);
	}


	public function set_target()
	{
		$id = $this->input->post('data_id');
		$data = array('sales_quota' => $this->input->post('sales_quota'), 'profit_quota' => $this->input->post('profit_quota'));
		$result = $this->Login_model->set_user_target($id, $data);
		if ($result == 200) {
			echo json_encode(array('st' => 200));
		}
	}


 /**
 * Update controller action that processes a user/profile update including optional profile image upload, updates licence usage when plan changes, and echoes a JSON status response.
 * @example
 * // Simulate POST data and optional file upload then call the controller action
 * $_POST = [
 *   'update_id' => '5',
 *   'sel_role' => '2',
 *   'reports_to' => '1',
 *   'user_typeUpdate' => 'standard',
 *   'standard_name' => 'Acme Corp',
 *   'standard_email' => 'user@example.com',
 *   'standard_mobile' => '1234567890',
 *   'sel_lic_type' => '3',            // new plan id
 *   'sel_lic_type_hidden' => '2',     // previous plan id
 *   'country' => 'US',
 *   'state' => 'CA',
 *   'city' => 'San Francisco',
 *   'zipcode' => '94107'
 * ];
 * // Optional file upload structure (simulate)
 * $_FILES['profile_image'] = [
 *   'name' => 'logo.png',
 *   'tmp_name' => '/tmp/phpYzdqkD',
 *   'type' => 'image/png',
 *   'size' => 12345,
 *   'error' => 0
 * ];
 * $this->update();
 * // Possible echoed outputs:
 * // {"st":200}                         // success
 * // {"st":201,"show_msg":"Your licence quantity full in this licence, Please upgrade your licence."} // licence full
 * @param {void} $none - This method accepts no direct arguments; it reads from $_POST and $_FILES and uses models to persist changes.
 * @returns {void} Echoes JSON with status code (200 on success, 201 when licence capacity exceeded) and exits.
 */
	public function update()
	{
		$validation = $this->check_update_validation();
		if ($validation != 200) {
			echo $validation;
			die;
		} else {
			
			//print_r($this->input->post());die;
			//$this->input->post('sel_lic_type');
			$planId = $this->input->post('sel_lic_type');
			$planIdhidden = $this->input->post('sel_lic_type_hidden');
			$planDetail = $this->Login_model->yourplanid($planId);

			if (!empty($_FILES["profile_image"]['name'])) {
				$dirpath = './uploads/company_logo/';
				//unlink($dirpath.$image_name);
				$config['upload_path'] = './uploads/company_logo/';

				$config['allowed_types'] = 'jpg|jpeg|png';
				// $config['max_size'] = 2097152;

				$logo_name = time() . "_" . str_replace(' ', '_', $_FILES["profile_image"]['name']);
				$config['file_name'] = $logo_name;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$this->upload->do_upload('profile_image');
				$uploadData = $this->upload->data();
				$uploadedFile = $uploadData['file_name'];

				// print_r($logo_name);die;
			} else {
				$logo_name = $image_name;

				// print_r('test');die;
			}



			if ($planId == $planIdhidden || $planDetail['plan_licence'] > $planDetail['used_licence']) {
				$data = array(
					'id' => $this->input->post('update_id'), 
					'role_id' => $this->input->post('sel_role'), 
					'reports_to' => $this->input->post('reports_to'), 
					'user_type' => $this->input->post('user_typeUpdate'), 
					'standard_name' => $this->input->post('standard_name'), 

					'user_photo'  => $logo_name,

					'standard_email' => $this->input->post('standard_email'), 
					'standard_mobile' => $this->input->post('standard_mobile'), 
					'your_plan_id' => $this->input->post('sel_lic_type'), 
					'country' => $this->input->post('country'), 
					'state' => $this->input->post('state'), 
					'city' => $this->input->post('city'), 
					'zipcode' => $this->input->post('zipcode'), 
					'create_org' => $this->input->post('create_org'), 
					'retrieve_org' => $this->input->post('retrieve_org'), 
					'update_org' => $this->input->post('update_org'), 
					'delete_org' => $this->input->post('delete_org'), 
					'create_contact' => $this->input->post('create_contact'), 
					'retrieve_contact' => $this->input->post('retrieve_contact'), 
					'update_contact' => $this->input->post('update_contact'), 
					'delete_contact' => $this->input->post('delete_contact'), 
					'create_lead' => $this->input->post('create_lead'), 
					'retrieve_lead' => $this->input->post('retrieve_lead'), 
					'update_lead' => $this->input->post('update_lead'), 
					'delete_lead' => $this->input->post('delete_lead'), 
					'create_opp' => $this->input->post('create_opp'), 
					'retrieve_opp' => $this->input->post('retrieve_opp'), 
					'update_opp' => $this->input->post('update_opp'), 
					'delete_opp' => $this->input->post('delete_opp'), 
					'create_quote' => $this->input->post('create_quote'), 
					'retrieve_quote' => $this->input->post('retrieve_quote'), 
					'update_quote' => $this->input->post('update_quote'), 
					'delete_quote' => $this->input->post('delete_quote'), 
					'create_so' => $this->input->post('create_so'), 
					'retrieve_so' => $this->input->post('retrieve_so'), 
					'update_so' => $this->input->post('update_so'), 
					'delete_so' => $this->input->post('delete_so'), 
					'create_vendor' => $this->input->post('create_vendor'), 
					'retrieve_vendor' => $this->input->post('retrieve_vendor'), 
					'update_vendor' => $this->input->post('update_vendor'), 
					'delete_vendor' => $this->input->post('delete_vendor'), 
					'create_po' => $this->input->post('create_po'), 
					'retrieve_po' => $this->input->post('retrieve_po'), 
					'update_po' => $this->input->post('update_po'), 
					'delete_po' => $this->input->post('delete_po'), 
					'create_inv' => $this->input->post('create_inv'), 
					'retrieve_inv' => $this->input->post('retrieve_inv'), 
					'update_inv' => $this->input->post('update_inv'), 
					'delete_inv' => $this->input->post('delete_inv'), 
					'create_pi' => $this->input->post('create_pi'), 
					'retrieve_pi' => $this->input->post('retrieve_pi'), 
					'update_pi' => $this->input->post('update_pi'), 
					'delete_pi' => $this->input->post('delete_pi'), 
					'pending_payment_mail' => $this->input->post('pendingPayment'), 
					'accept_payment_mail' => $this->input->post('acceptMail'), 
					'so_approve_mail' => $this->input->post('approveMail'), 
					'so_approval' => $this->input->post('approveSO'), 
					'po_approval' => $this->input->post('approvePO'), 
					'notapprovalSO' => $this->input->post('notapproveSO'), 
					'notapprovalPO' => $this->input->post('notapprovePO'),
				);

				// print_r($data);die;
				$this->Login_model->update(array('id' => $this->input->post('update_id')), $data);
				$planIdhidden = $this->input->post('sel_lic_type_hidden');
				if ($planId != $planIdhidden) {
					$usedLicence = $planDetail['used_licence'];
					$updateLic = ($usedLicence + 1);
					if ($planDetail['plan_licence'] >= $updateLic) {
						$updateLiArr = array('used_licence' => $updateLic);
						$this->Login_model->updateLicence($updateLiArr, $planDetail['id']);
					}
					if ($planIdhidden != "0" && $planIdhidden != "") {
						$planDetailSec = $this->Login_model->yourplanid($planIdhidden);
						$usedLicenceSec = $planDetailSec['used_licence'];
						if ($usedLicenceSec != 0) {
							$updateLicSec = ($usedLicenceSec - 1);
							$updateLiArrSec = array('used_licence' => $updateLicSec);
							$this->Login_model->updateLicence($updateLiArrSec, $planDetailSec['id']);
						}
					}
				}
				echo json_encode(array("st" => 200));
			} else {
				echo json_encode(array("st" => 201, "show_msg" => "Your licence quantity full in this licence, Please upgrade your licence."));
			}
		}
	}



 /**
  * Validate update form input for a standard/user and return validation result.
  * @example
  * $result = $this->check_update_validation();
  * echo $result; // On validation failure (example): {"st":202,"standard_name":"Name is required","standard_email":"Email is not valid","standard_mobile":"Number is not valid","user_typeUpdate":"","country":"","state":"","city":"","zipcode":"","company_gstin":"","company_address":""}
  * // On success (example): 200
  * @param void $none - This method does not accept any parameters.
  * @returns mixed Returns a JSON-encoded string of validation errors with status 202 when validation fails, or integer 200 when validation succeeds.
  */
	public function check_update_validation()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
		$this->form_validation->set_rules('standard_name', 'Name', 'required|trim');
		$this->form_validation->set_rules('standard_email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('standard_mobile', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
		$this->form_validation->set_rules('user_typeUpdate', 'User type', 'required|trim');
		$this->form_validation->set_rules('country', 'Country', 'required|trim');
		$this->form_validation->set_rules('state', 'State', 'required|trim');
		$this->form_validation->set_rules('city', 'City', 'required|trim');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
		$this->form_validation->set_rules('company_gstin', 'GST', 'required|trim');
		$this->form_validation->set_rules('company_address', 'Company Address', 'required|trim');
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is not valid');
		$this->form_validation->set_message('regex_match', '%s is not valid');
		if ($this->form_validation->run() == FALSE) {
			return json_encode(array('st' => 202, 'standard_name' => form_error('standard_name'), 'standard_email' => form_error('standard_email'), 'standard_mobile' => form_error('standard_mobile'), 'user_typeUpdate' => form_error('user_typeUpdate'), 'country' => form_error('country'), 'state' => form_error('state'), 'city' => form_error('city'), 'zipcode' => form_error('zipcode'), 'company_gstin' => form_error('company_gstin'), 'company_address' => form_error('company_address')));
		} else {
			return 200;
		}
	}
 /**
 * Delete a login record by ID, decrement the associated plan's used_licence (if > 0), update the licence record, remove the login record, and output JSON status.
 * @example
 * $this->Home->delete(42);
 * // Outputs: {"status": true}
 * @param {int} $id - ID of the login record to delete (e.g. 42).
 * @returns {void} Sends JSON {"status": true} to indicate successful deletion; no return value.
 */
	public function delete($id)
	{
		$data = $this->Login_model->get_by_id($id);
		$planDetailSec = $this->Login_model->yourplanid($data->your_plan_id);
		$usedLicenceSec = $planDetailSec['used_licence'];
		if ($usedLicenceSec != 0) {
			$updateLicSec = ($usedLicenceSec - 1);
			$updateLiArrSec = array('used_licence' => $updateLicSec);
			$this->Login_model->updateLicence($updateLiArrSec, $planDetailSec['id']);
		}
		$this->Login_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
	public function view_branches()
	{
		if (!empty($this->session->userdata('email'))) {
			$this->load->view('users/view_branches');
		} else {
			redirect('login');
		}
	}
 /**
 * Returns a JSON-formatted list of branches prepared for DataTables server-side processing.
 * @example
 * // Called via AJAX from the client; example controller call:
 * $this->ajax_list_branch();
 * // Example JSON output (formatted):
 * // {"draw":1,"recordsTotal":25,"recordsFiltered":25,"data":[
 * //   ["<input type=\"checkbox\" ... value=\"1\">","Main Branch<div class=\"links\">...","main@company.com","1234567890","Company Ltd","GSTIN123","<input type=\"checkbox\" ... value=\"1\">"],
 * //   ["<input type=\"checkbox\" ... value=\"2\">","Second Branch<div class=\"links\">...","second@company.com","0987654321","Company Ltd","GSTIN456","<input type=\"checkbox\" ... value=\"2\">"]
 * // ]}
 * @param array $_POST - Input POST data expected: 'start' (int offset for paging) and 'draw' (int draw counter from DataTables).
 * @returns void Echoes JSON response for DataTables (draw, recordsTotal, recordsFiltered, data).
 */
	public function ajax_list_branch()
	{
		$list = $this->Branch_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post) {
			$no++;
			$row = array();
			// APPEND HTML FOR ACTION
			$row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
			$row[] = $post->branch_name . '<div class="links">
	      <a style="text-decoration:none" href="javascript:void(0)" onclick="view(' . "'" . $post->id . "'" . ')" class="text-info">View</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="update(' . "'" . $post->id . "'" . ')" class="text-secondary">Update</a>
	      | <a style="text-decoration:none" href="javascript:void(0)" onclick="delete_entry(' . "'" . $post->id . "'" . ')" class="text-danger">Delete</a>
	      </div>';
			$row[] = $post->branch_email;
			$row[] = $post->contact_number;
			$row[] = $post->company_name;
			$row[] = $post->gstin;
			$row[] = '<input type="checkbox" class="delete_checkbox" value="' . $post->id . '">';
			$data[] = $row;
		}
		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Branch_model->count_all(), "recordsFiltered" => $this->Branch_model->count_filtered(), "data" => $data,);
		//output to json format
		echo json_encode($output);
	}
 /**
  * Create a new branch for the currently authenticated company using POSTed form data.
  * Validates input via check_branch_validation(); on success it gathers session values and POST fields,
  * calls Branch_model->create($data) and echoes a JSON success status. On validation failure the numeric
  * validation code is echoed and execution is terminated.
  * @example
  * // Example HTTP POST (to Controller/Home/create_branch)
  * // POST fields:
  * // branch_name=Main Office
  * // branch_email=branch@example.com
  * // contact_number=+911234567890
  * // gstin=27AAAAA0000A1Z5
  * // cin=U12345MH2000PTC000000
  * // pan=AAAAA0000A
  * // country=India
  * // state=Maharashtra
  * // city=Mumbai
  * // zipcode=400001
  * // address=123, Example Street
  * // Expected server response on success:
  * // {"st":200}
  * $this->create_branch();
  * @param int $company_id - Company ID from session (sess userdata 'id').
  * @param string $sess_eml - Company user email from session (sess userdata 'email').
  * @param string $company_name - Company name from session (sess userdata 'company_name').
  * @param string $branch_name - Branch name (POST: 'branch_name').
  * @param string $branch_email - Branch email (POST: 'branch_email').
  * @param string $contact_number - Contact number for the branch (POST: 'contact_number').
  * @param string $gstin - GSTIN for the branch (POST: 'gstin').
  * @param string $cin - CIN for the branch (POST: 'cin').
  * @param string $pan - PAN for the branch (POST: 'pan').
  * @param string $country - Country for the branch (POST: 'country').
  * @param string $state - State for the branch (POST: 'state').
  * @param string $city - City for the branch (POST: 'city').
  * @param string|int $zipcode - Zip/postal code for the branch (POST: 'zipcode').
  * @param string $address - Street address for the branch (POST: 'address').
  * @returns void Echoes JSON {"st":200} on success; echoes validation numeric code and exits on failure.
  */
	public function create_branch()
	{
		$validation = $this->check_branch_validation();
		if ($validation != 200) {
			echo $validation;
			die;
		} else {
			$data = array('company_id' => $this->session->userdata('id'), 'sess_eml' => $this->session->userdata('email'), 'company_name' => $this->session->userdata('company_name'), 'branch_name' => $this->input->post('branch_name'), 'branch_email' => $this->input->post('branch_email'), 'contact_number' => $this->input->post('contact_number'), 'gstin' => $this->input->post('gstin'), 'cin' => $this->input->post('cin'), 'pan' => $this->input->post('pan'), 'country' => $this->input->post('country'), 'state' => $this->input->post('state'), 'city' => $this->input->post('city'), 'zipcode' => $this->input->post('zipcode'), 'address' => $this->input->post('address'),);
			$this->Branch_model->create($data);
			echo json_encode(array("st" => 200));
		}
	}
 /**
  * Update an existing branch record using POST data and echo a JSON status response.
  * @example
  * // Simulate POST request data (e.g. in a test)
  * $_POST = array(
  *     'id' => 5,
  *     'branch_name' => 'Main Branch',
  *     'branch_email' => 'branch@example.com',
  *     'contact_number' => '1234567890',
  *     'gstin' => '22AAAAA0000A1Z5',
  *     'cin' => 'L12345MH1990PLC123456',
  *     'pan' => 'ABCDE1234F',
  *     'country' => 'India',
  *     'state' => 'Maharashtra',
  *     'city' => 'Mumbai',
  *     'zipcode' => '400001',
  *     'address' => '123 Street'
  * );
  * $this->update_branch();
  * // Sample output on successful update:
  * // {"st":200}
  * @param int $id - Posted branch record identifier (POST key 'id').
  * @param string $branch_name - Posted branch name (POST key 'branch_name').
  * @param string $branch_email - Posted branch email (POST key 'branch_email').
  * @param string $contact_number - Posted contact number for the branch (POST key 'contact_number').
  * @param string $gstin - Posted GSTIN value (POST key 'gstin').
  * @param string $cin - Posted CIN value (POST key 'cin').
  * @param string $pan - Posted PAN value (POST key 'pan').
  * @param string $country - Posted country (POST key 'country').
  * @param string $state - Posted state (POST key 'state').
  * @param string $city - Posted city (POST key 'city').
  * @param string $zipcode - Posted postal/ZIP code (POST key 'zipcode').
  * @param string $address - Posted full address (POST key 'address').
  * @returns void Echoes JSON status on success or echoes validation error code and exits on failure.
  */
	public function update_branch()
	{
		$validation = $this->check_branch_validation();
		if ($validation != 200) {
			echo $validation;
			die;
		} else {
			$data = array('id' => $this->input->post('id'), 'branch_name' => $this->input->post('branch_name'), 'branch_email' => $this->input->post('branch_email'), 'contact_number' => $this->input->post('contact_number'), 'gstin' => $this->input->post('gstin'), 'cin' => $this->input->post('cin'), 'pan' => $this->input->post('pan'), 'country' => $this->input->post('country'), 'state' => $this->input->post('state'), 'city' => $this->input->post('city'), 'zipcode' => $this->input->post('zipcode'), 'address' => $this->input->post('address'),);
			$this->Branch_model->update(array('id' => $this->input->post('id')), $data);
			echo json_encode(array("st" => 200));
		}
	}
 /**
 * Validate branch form input using CodeIgniter form_validation; returns JSON encoded errors on failure or HTTP-like 200 on success.
 * @example
 * $result = $this->check_branch_validation();
 * // on validation success
 * echo $result; // 200
 * // on validation failure (sample)
 * echo $result; // '{"st":202,"branch_name":"<div class=\"error\">Name is required</div>","branch_email":"<div class=\"error\">Email is required</div>","contact_number":"<div class=\"error\">Number is not valid</div>","gstin":"<div class=\"error\">GSTIN is required</div>","cin":"<div class=\"error\">CIN is required</div>","pan":"<div class=\"error\">Pan is required</div>","country":"<div class=\"error\">Country is required</div>","state":"<div class=\"error\">State is required</div>","city":"<div class=\"error\">City is required</div>","zipcode":"<div class=\"error\">Zipcode is required</div>","address":"<div class=\"error\">Branch Address is required</div>"}'
 * @returns {int|string} 200 on successful validation, or a JSON encoded string containing 'st' = 202 and per-field error HTML strings on validation failure.
 */
	public function check_branch_validation()
	{
		$this->form_validation->set_error_delimiters('<div class="error" style="margin-bottom: -12px; color: red; font-size: 11px; float: left;" ><i class="fa fa-times" aria-hidden="true"></i>&nbsp;', '</div>');
		$this->form_validation->set_rules('branch_name', 'Name', 'required|trim');
		$this->form_validation->set_rules('branch_email', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('contact_number', 'Number', 'required|regex_match[/^[0-9]{10}$/]|trim');
		$this->form_validation->set_rules('gstin', 'GSTIN', 'required|trim');
		$this->form_validation->set_rules('cin', 'CIN', 'required|trim');
		$this->form_validation->set_rules('country', 'Country', 'required|trim');
		$this->form_validation->set_rules('pan', 'Pan', 'required|trim');
		$this->form_validation->set_rules('state', 'State', 'required|trim');
		$this->form_validation->set_rules('city', 'City', 'required|trim');
		$this->form_validation->set_rules('zipcode', 'Zipcode', 'required|trim');
		$this->form_validation->set_rules('address', 'Branch Address', 'required|trim');
		$this->form_validation->set_message('required', '%s is required');
		$this->form_validation->set_message('valid_email', '%s is not valid');
		$this->form_validation->set_message('regex_match', '%s is not valid');
		if ($this->form_validation->run() == FALSE) {
			return json_encode(array('st' => 202, 'branch_name' => form_error('branch_name'), 'branch_email' => form_error('branch_email'), 'contact_number' => form_error('contact_number'), 'gstin' => form_error('gstin'), 'cin' => form_error('cin'), 'pan' => form_error('pan'), 'country' => form_error('country'), 'state' => form_error('state'), 'city' => form_error('city'), 'zipcode' => form_error('zipcode'), 'address' => form_error('address')));
		} else {
			return 200;
		}
	}
	public function getbranchbyId($id)
	{
		$data = $this->Branch_model->get_by_id($id);
		echo json_encode($data);
	}
	public function delete_branch($id)
	{
		$this->Branch_model->delete($id);
		echo json_encode(array("status" => TRUE));
	}
	public function delete_branch_bulk()
	{
		if ($this->input->post('checkbox_value')) {
			$id = $this->input->post('checkbox_value');
			for ($count = 0; $count < count($id); $count++) {
				$this->Branch_model->delete_bulk($id[$count]);
			}
		}
	}





 /**
 * Retrieve profit data for sale orders, format it for DataTables and echo the result as JSON.
 * @example
 * $_POST = ['start' => 0, 'draw' => 1];
 * $this->get_profit_table();
 * // Outputs JSON like:
 * // {"draw":1,"recordsTotal":125,"recordsFiltered":10,"totalProfit":"12,345","data":[["Alice","SO/2025/001","Acme Ltd","Website build","₹10,000","₹12,000","01 Jan 2025","₹2,000"], ...]}
 * @param array $_POST - Superglobal POST array containing DataTables parameters (e.g. 'start' => 0, 'draw' => 1).
 * @returns void Returns nothing; echoes a JSON-encoded array with keys: draw, recordsTotal, recordsFiltered, totalProfit, and data.
 */
	public function get_profit_table()
	{
		$list = $this->Reports_model->get_profit_pro_datatables();
		// print_r($list);die;
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post) {
			$so_Id = $post->saleorder_id;
			$ex = explode("/", $so_Id);
			$output = array_slice($ex, 2);
			$saleorder_id = implode("/", $output);
			$newDate = date("d M Y", strtotime($post->currentdate));
           
			$no++;
			$row = array();
			$row[] = ucfirst($post->owner);
			$row[] = $saleorder_id;
			$row[] = $post->org_name;
			$row[] = $post->subject;
			$row[] = IND_money_format(intval($post->after_discount));
			$row[] = IND_money_format($post->total_orc);

			$row[] = "<text style='font-size: 12px;'>" . $newDate . "</text>";
			$row[] = IND_money_format($post->profit_by_user);
			$data[] = $row;
		}
		
		 $totalProfit = $this->Reports_model->count_profit_user_so();
		 $totalProfitValue = isset($totalProfit['profit_by_user']) ? $totalProfit['profit_by_user'] : 0;


		$output = array(
			"draw" => $_POST['draw'], 
			"recordsTotal" => $this->Reports_model->count_all_pro(), 
			"recordsFiltered" => $this->Reports_model->count_filtered_pro(), 
			"totalProfit" => $totalProfitValue, 
			"data" => $data,
		);
		
// 		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Reports_model->count_all_pro(), "recordsFiltered" => $this->Reports_model->count_filtered_pro(), "data" => $data,);
		// print_r($output);die;
		echo json_encode($output);
	}




	public function get_profitTable_all_User_so()
	{
		$list = $this->Reports_model->count_profit_user_so();
		echo $list['profit_by_user'];
	}


	
 /**
 * Outputs product-wise profit table data in DataTables JSON format (echoes JSON response).
 * @example
 * // Simulate POST data expected by the method
 * $_POST['start'] = 0;
 * $_POST['draw'] = 1;
 * $this->get_profit_table_product_wise();
 * // Example echoed JSON:
 * // {"draw":1,"recordsTotal":120,"recordsFiltered":60,"data":[["John Doe","SO1001","PO2001","Website Design&nbsp;..","1,500"],["Jane Smith","SO1002","PO2002","Mobile App","2,000"]]}
 * @param array $_POST - Global POST array containing 'start' (int) and 'draw' (int) used for pagination and draw count for DataTables.
 * @returns void Echoes a JSON-encoded array compatible with DataTables and does not return a value.
 */
	public function get_profit_table_product_wise()
	{
		$list = $this->Reports_model->get_profit_datatables_product_wise();
		$data = array();
		$no = $_POST['start'];
		$rw = 1;
		$arr = array();
		foreach ($list as $post) {
			$getActData = $this->Reports_model->get_Actual_profit_datatables_product_wise($post->saleorder_id, $post->purchaseorder_id);
			$no++;
			$row = array();
			$subject = $post->subject;
			if (strlen($subject) > 40) {
				$subject = substr($subject, 0, 40) . "&nbsp;..";
			}
			/*$proname=$post->pro_name;
		if(strlen($proname)>40){
		$proname=substr($proname,0,40)."&nbsp;...";
		}*/
					$row[] = ucfirst($post->owner);
					$row[] = $post->saleorder_id;
					$row[] = $post->purchaseorder_id;
					$row[] = $subject;
					//$row[] = $proname;
					// $row[] = intval($post->profit_by_user_po);
					$row[] = IND_money_format(intval($post->profit_by_user_po));
					//$calc = intval($post->after_discount) - intval($post->after_discount_po) - intval($post->total_orc);
					/* $calc  = intval($getActData[0]['so_pro_total']) - intval($getActData[0]['po_total_price']);

		if(in_array($post->saleorder_id, $arr))
		{
		$row[] = '0.00';
		$row[] = intval($post->actual_profit);
		$row[] = '-';
		}else{
		$profitTo=intval($calc)-intval($post->total_orc)-intval($post->discount)-intval($post->p_discount);
		$row[] = $post->total_orc;
		$row[] = intval($post->actual_profit);
		$row[] = $profitTo;

		$arr[]=$post->saleorder_id;
            		}*/
			$data[] = $row;
		}
		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Reports_model->count_all_pro_product_wise(), "recordsFiltered" => $this->Reports_model->count_filtered_pro_product_wise(), "data" => $data,);
		//output to json format
		echo json_encode($output);
	}
	public function get_act_profit_table_all_User()
	{
		$data = $this->Reports_model->get_profit_datatables_product_wise_for_count();
		$countProfit = 0;
		foreach ($data as $post) {
			$countProfit = $countProfit + $post->profit_by_user_po;
		}
		echo $countProfit;
	}
	//######## Function to send mail auto backup of database....############
 /**
  * Create a SQL backup of the configured MySQL database and send it as an email attachment via SMTP.
  *
  * @example
  * // From a controller method or instance where sentMailAtt is available:
  * $this->sentMailAtt();
  * // This will create a file similar to:
  * // "admintea_team365_backup_2025-12-22 14 30 00.sql"
  * // and attempt to send an email from "no-reply@team365.io" to "dev2@team365.io" with that file attached.
  *
  * @returns {void} No return value. The method writes a .sql backup file to the working directory and attempts to send an email with that file attached. Error details are not returned by this method.
  */
	public function sentMailAtt()
	{
		//set up email
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp', 'smtp_host' => 'smtp.office365.com', 'smtp_port' => 587, 'smtp_crypto' => 'tls', 'smtp_user' => 'no-reply@team365.io', // change it to yours
			'smtp_pass' => 'Wos13185', // change it to yours
			'mailtype' => 'html', 'wordwrap' => TRUE, 'crlf' => "\r", 'newline' => "\n", 'charset' => "utf-8", 'wordwrap' => TRUE
		);
		$this->email->initialize($config);
		$this->email->set_crlf("\r\n");
		$this->email->set_newline("\r\n");
		$this->email->from($config['smtp_user']);
		$this->email->to('dev2@team365.io');
		$this->email->subject('Salesorder Progress');
		$this->email->set_mailtype('html');
		$output = 'test Att Mail 12 3 12';
		$this->email->message($output);
		// Database configuration
		$host = "localhost";
		$username = "root";
		$password = "";
		$database_name = "admintea_team365";
		// Get connection object and set the charset
		$conn = mysqli_connect($host, $username, $password, $database_name);
		$conn->set_charset("utf8");
		// Get All Table Names From the Database
		$tables = array();
		$sql = "SHOW TABLES";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_row($result)) {
			$tables[] = $row[0];
		}
		$sqlScript = "";
		foreach ($tables as $table) {
			// Prepare SQLscript for creating table structure
			$query = "SHOW CREATE TABLE $table";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_row($result);
			$sqlScript .= "\n\n" . $row[1] . ";\n\n";
			$query = "SELECT * FROM $table";
			$result = mysqli_query($conn, $query);
			$columnCount = mysqli_num_fields($result);
			// Prepare SQLscript for dumping data for each table
			for ($i = 0; $i < $columnCount; $i++) {
				while ($row = mysqli_fetch_row($result)) {
					$sqlScript .= "INSERT INTO $table VALUES(";
					for ($j = 0; $j < $columnCount; $j++) {
						$row[$j] = $row[$j];
						if (isset($row[$j])) {
							$sqlScript .= '"' . $row[$j] . '"';
						} else {
							$sqlScript .= '""';
						}
						if ($j < ($columnCount - 1)) {
							$sqlScript .= ',';
						}
					}
					$sqlScript .= ");\n";
				}
			}
			$sqlScript .= "\n";
		}
		if (!empty($sqlScript)) {
			$backup_file_name = $database_name . '_backup_' . date('Y-m-d H i s') . '.sql';
			$fileHandler = fopen($backup_file_name, 'w+');
			$number_of_lines = fwrite($fileHandler, $sqlScript);
			fclose($fileHandler);
		}
		$this->email->attach($backup_file_name);
		if (!$this->email->send()) {
		}
	}



	// Please write code above this

}
