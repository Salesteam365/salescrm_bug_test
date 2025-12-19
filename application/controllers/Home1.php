<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
 /**
  * Constructor for the Home1 controller: initializes the parent controller and loads the URL helper, required models (Login_model, Salesorders_model, Branch_model, Reports_model, Target_model, roles_model) and libraries (upload, email_lib).
  * @example
  * $home = new Home1();
  * echo get_class($home); // Home1
  * @returns void Constructor performs initialization and returns nothing.
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
 * Load dashboard data (targets, reports, counts, renewal orders) and render the 'users/newdashboard' view or redirect to company/login if session is not valid.
 * @example
 * $home = new Home1();
 * $home->index();
 * // Expected: loads 'users/newdashboard' view with aggregated dashboard data (e.g. 'dateyr' => [2024], 'total_leads' => 125) or redirects to 'company' or 'login'.
 * @param void none - No parameters are required for this controller method.
 * @returns void Nothing is returned; this method either loads a view with prepared $data or redirects the user.
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
 * Retrieve yearly/monthly counts for organizations (customers), leads, opportunities and quotes and echo them as a JSON object.
 * @example
 * // Call from controller:
 * $this->getyeargraph();
 * // Example output:
 * // {"totalcustarr":[12,8,5],"totalleadarr":[9,6,2],"totalopparr":[4,3,1],"totalquotearr":[7,5,2]}
 * @param {void} none - No parameters required.
 * @returns {void} Echoes a JSON-encoded array with keys: totalcustarr, totalleadarr, totalopparr, totalquotearr.
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
 * Outputs HTML <option> elements for months available for a given year (reads POST parameter 'yearsDt').
 * @example
 * // Simulate POST and call from controller
 * $_POST['yearsDt'] = '2020';
 * $this->getMonth();
 * // Example echoed output:
 * // <option value='01'>January</option><option value='02'>February</option>...
 * @param string|int $yearsDt - Year value read from POST parameter 'yearsDt' used to fetch month data.
 * @returns void Echoes HTML <option> elements for each month (no return value).
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
 * Sort and output profit graph data as JSON based on the posted date and current user type.
 * For "admin" users the controller aggregates sales minus purchase costs and ORC to produce per-owner subtotals.
 * For "standard" users it returns the raw sales records for the given date.
 * @example
 * // Example for admin (outputs aggregated owner subtotals)
 * $this->session->set_userdata('type', 'admin');
 * $_POST['date'] = '2025-01-15';
 * $this->sort_profit_graph();
 * // Outputs JSON like:
 * // [{"owner":"Alice","sub_total":1500},{"owner":"Bob","sub_total":800}]
 * @example
 * // Example for standard (outputs raw sales data)
 * $this->session->set_userdata('type', 'standard');
 * $_POST['date'] = '2025-01-15';
 * $this->sort_profit_graph();
 * // Outputs JSON like:
 * // [{"owner":"Charlie","after_discount":"1200","total_orc":"50", ...}, ...]
 * @param string $date - Date filter read from POST parameter 'date' (format e.g. 'YYYY-MM-DD').
 * @returns string JSON-encoded response echoed to output: for admin an array of {owner, sub_total}, for standard the raw sales records.
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
 * Outputs a JSON-encoded DataTables response containing dashboard profit rows per owner.
 * @example
 * $this->get_dashboard_profit_table();
 * // Example echoed output:
 * // {"draw":1,"recordsTotal":2,"recordsFiltered":2,"data":[["Alice","Rp 1.000.000","Rp 800.000","Rp 200.000"],["Bob","Rp 500.000","Rp 400.000","Rp 100.000"]]}
 * @param {void} none - No parameters required.
 * @returns {void} Echoes a JSON string (DataTables format) with keys: draw, recordsTotal, recordsFiltered, data.
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
 * Retrieve and echo JSON of the top ten customers based on provided POST filters and current session.
 * @example
 * // Example usage from a controller context (POST values set by client)
 * // POST: profitYear=2025, profitMoth=03, searchDate=2025-01-01, financial_year=2024-2025
 * $this->gettoptencus();
 * // Sample echoed JSON:
 * // {"toptencus":[{"customer":"Acme Corp","total":12500.50},{"customer":"Beta LLC","total":9800.00}, ...]}
 * @param string|null $profitYear - POST 'profitYear': target profit year (e.g. "2025") or null to ignore.
 * @param string|null $profitMoth - POST 'profitMoth' (note: spelled 'profitMoth' in request): target profit month (e.g. "03") or null to ignore.
 * @param string|null $searchDate - POST 'searchDate': start date for range filtering in "YYYY-MM-DD" format (e.g. "2025-01-01") or null to use defaults.
 * @param string|null $financial_year - POST 'financial_year': financial year string (e.g. "2024-2025") or null to ignore.
 * @param string $session_type - Session 'type': determines access scope ("admin" or "standard"); uses session 'company_email' and optionally 'email'.
 * @returns string JSON string (echoed) containing a single key "toptencus" with an array of top customer objects. */
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
 * Generate and echo a JSON-encoded HTML string containing the "top quotes" table rows based on POSTed filters and current session.
 * @example
 * $_POST['profitYear'] = '2025';
 * $_POST['profitMoth'] = '04'; // note: key name uses the same typo as in the controller
 * $_POST['searchDate'] = '2025-01-01';
 * $_POST['financial_year'] = '2024-2025';
 * $this->session->set_userdata(['type' => 'admin', 'company_email' => 'admin@example.com']);
 * $this->topquotes(); // echos a JSON string, e.g. "[\"<tr class=\\\"...\\\">...<td>₹ 12,345</td>...</tr>\"]"
 * @param {string} profitYear - POST parameter 'profitYear' (year filter, e.g. '2025').
 * @param {string} profitMoth - POST parameter 'profitMoth' (month filter, note typo in key, e.g. '04').
 * @param {string} searchDate - POST parameter 'searchDate' (start date in 'Y-m-d', e.g. '2025-01-01').
 * @param {string} financial_year - POST parameter 'financial_year' (financial year string, e.g. '2024-2025').
 * @returns {string} JSON-encoded HTML string containing table rows for the top quotes (intended to be echoed directly).
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
 * Update the currently authenticated user's profile (admin or standard), handle optional file uploads (company logo or profile image), persist changes via Login_model, and echo a JSON status response.
 * @example
 * // For an admin updating company info with a new logo upload:
 * $_POST = ['id' => 5, 'name' => 'Acme Admin', 'email' => 'admin@acme.com', 'company_contact' => '1234567890', 'country' => 'US', 'state' => 'NY', 'city' => 'New York', 'address' => '1 Main St', 'zipcode' => '10001'];
 * // attach file in $_FILES['company_logo'] (jpg/png, max 2MB)
 * $this->update_profile();
 * // Example echoed output on success:
 * // {"status":200}
 * @param array $postData - POST payload read from request (expected keys for admin: id, name, email, company_contact, country, state, city, address, zipcode; for standard: id, name, contact_number). File inputs are read from $_FILES['company_logo'] or $_FILES['profile_image'].
 * @returns void Echoes a JSON object with a "status" key (200 on success) and terminates output. */
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
  * Validate form inputs based on current session user type and return JSON errors or success code.
  * @example
  * // For admin user (validation failure):
  * // $this->session->set_userdata('type', 'admin');
  * // $result = $this->check_validation();
  * // echo $result;
  * // Possible output:
  * // {"st":202,"name":"Name is required","mobile":"","email":"Email is not valid","company_contact":"Contact Number is not valid","country":"Country is required","state":"State is required","city":"City is required","address":"Address is required","zipcode":"Zipcode is required"}
  * //
  * // For standard user (validation failure):
  * // $this->session->set_userdata('type', 'standard');
  * // $result = $this->check_validation();
  * // echo $result;
  * // Possible output:
  * // {"st":202,"name":"Name is required","contact_number":"Contact Number is not valid"}
  * //
  * // On successful validation:
  * // $result = $this->check_validation();
  * // var_dump($result); // int(200)
  * @param void none - This method does not accept any parameters.
  * @returns int|string Returns 200 (int) on successful validation or a JSON encoded string of validation errors (st => 202) on failure.
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
 * Check if posted standard_email already exists and echo client-side HTML/JS response.
 * @example
 * $_POST['standard_email'] = 'user@example.com';
 * $this->checkUserExist();
 * // Possible outputs:
 * // 1) '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists as a admin' (and clears #standard_email)
 * // 2) '<i class="fas fa-exclamation-triangle" style="margin-right:7px; color:red"></i>This email already exists' (and clears #standard_email)
 * // 3) '<script>$("#add_user_btn").prop("disabled",false);</script>' (enables the add button)
 * @param string $standard_email - Email address read from POST input 'standard_email'.
 * @returns void Echoes HTML/JavaScript to the client (warning message or enables #add_user_btn); does not return a PHP value.
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
 * Check licence availability and output JSON/status indicating whether the current user can add another user (handles partner, admin trial and paid plans).
 * @example
 * // Called from a controller; the method echoes a status directly (no return value).
 * $this->checkUserPartner();
 * // Possible outputs:
 * // 200
 * // echo json_encode(array('st' => 200));
 * // echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you have already Added 4 Users</i>'));
 * // echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 5 licences and you can add only 4 users</i>'));
 * // echo json_encode(array('st' => 201, 'show_msg' => '<i class="fas fa-info-circle">You have only 3 licences and you are using 3 licence already.</i>'));
 * @param {void} none - This controller method does not accept any parameters.
 * @returns {void} Echoes JSON or numeric status and may exit; does not return a value.
 */
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
 * Create a new standard CRM user after validating the current user and plan licence availability.
 * Handles optional profile image upload, persists the new user, updates the plan's used licence count,
 * and sends a welcome email containing the login details. Emits JSON responses or error messages and may exit on failure.
 * @example
 * // Simulate POST data (in actual use this comes from form submission)
 * $_POST = array(
 *   'license_type' => 1,
 *   'first_name' => 'John',
 *   'last_name' => 'Doe',
 *   'standard_email' => 'john.doe@example.com',
 *   'standard_password' => 'Password123',
 *   'sel_role' => 4,
 *   'reports_to' => 2,
 *   'user_type' => 'employee',
 *   'standard_mobile' => '9999999999'
 * );
 * // Optionally upload a file into $_FILES['profile_image']
 * $this->Home1->create();
 * // Possible sample output (success):
 * // {"status":true}
 * // Possible sample output (license exhausted):
 * // {"st":201,"show_msg":"<i class=\"fas fa-info-circle\">You have only 5 licences ...</i>"}
 * @param array $post - Input POST data expected by the method (license_type, standard_email, standard_password, first_name, last_name, sel_role, reports_to, user_type, standard_mobile)
 * @returns void Echoes JSON responses or plain messages and may terminate execution (no return value).
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
				
				// user file upload
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
					
				// 	print_r($logo_name);die;

				} else {
					$logo_name = $image_name;
				// 	print_r('test');die;
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
 * Validate 'standard_email' and 'standard_mobile' form inputs using CodeIgniter form validation and return the validation result.
 * @example
 * $result = $this->check_user_validation();
 * // Success:
 * echo $result; // 200
 * // Failure (example JSON response):
 * // echo $result; // {"st":202,"standard_email":"Email is required","standard_mobile":"Number is not valid"}
 * @param {void} none - This method does not accept parameters; it validates POST input.
 * @returns {mixed} Returns integer 200 on successful validation, or a JSON-encoded string containing status 202 and field-specific error messages on failure.
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
 * Generate and echo a DataTables-compatible JSON payload of company users and admins for an AJAX request.
 * @example
 * // Simulate an AJAX call to this controller method
 * $_POST = ['draw' => 1, 'start' => 0];
 * $this->session->set_userdata(['email' => 'admin@example.com', 'company_name' => 'Acme Ltd', 'company_email' => 'info@acme.com']);
 * $this->ajax_user_table();
 * // Example output (printed JSON):
 * // {"draw":1,"recordsTotal":12,"recordsFiltered":5,"data":[["<img ...>","Admin Name","admin@example.com","9999999999","http://...","GSTIN","License","<input ...>"],["<img ...>","User Name","user@example.com","8888888888","http://...","GSTIN","Plan Name"]]}
 * @param {{array}} {{$_POST}} - Expected POST parameters: 'draw' (int) DataTables draw counter and 'start' (int) pagination offset.
 * @param {{CI_Session}} {{$this->session}} - Active session must contain 'email'; also uses 'company_name' and 'company_email' to scope data.
 * @returns {{void}} Echoes JSON response for DataTables; redirects to 'login' if no active session.
 */
	public function ajax_user_table()
	{
		if (!empty($this->session->userdata('email'))) {
			$list = $this->Login_model->get_company_users();
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
 * Outputs a JSON-formatted list of users (for DataTables) by reading POST parameters and using Login_model.
 * @example
 * // Simulate DataTables POST and call the controller method (typically accessed via HTTP)
 * $_POST['draw'] = 1;
 * $_POST['start'] = 0;
 * $this->view_user();
 * // Sample echoed JSON (rendered output):
 * // {"draw":1,"recordsTotal":42,"recordsFiltered":42,"data":[
 * //   ["Acme Corp<div class=\"links\"><a ...>View</a> | <a ...>Update</a> | <a ...>Set Target</a> | <a ...>Delete</a></div>","admin@acme.com","9876543210","https://acme.example","22AAAAA0000A1Z5","Premium"]
 * // ]}
 * @param {{none}} {{N/A}} - No direct function parameters; reads $_POST['draw'] and $_POST['start'] and queries Login_model.
 * @returns {{void}} Echoes a JSON response containing draw, recordsTotal, recordsFiltered and data for DataTables.
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
 * Update user/profile and manage licence counts; validates input, uploads a profile image (if provided), updates the user record in the Login_model, adjusts plan used_licence values when the user's plan changes, and prints a JSON response.
 * @example
 * // Simulate a POST request in a controller test (example values)
 * $_POST = [
 *   'update_id' => '123',
 *   'sel_role' => '2',
 *   'sel_lic_type' => '1',
 *   'sel_lic_type_hidden' => '0',
 *   'standard_name' => 'Acme Corp',
 *   'standard_email' => 'user@example.com',
 *   'standard_mobile' => '5551234567'
 * ];
 * // Optionally set an uploaded file in $_FILES['profile_image'] with a valid jpg/png to update user_photo
 * $this->Home1->update();
 * // Possible outputs:
 * // {"st":200} // update successful
 * // {"st":201,"show_msg":"Your licence quantity full in this licence, Please upgrade your licence."} // licence limit reached
 * // or a validation status code echoed directly if validation fails
 * @param {array} $_POST - POST input containing update fields (e.g., update_id, sel_role, sel_lic_type, sel_lic_type_hidden, standard_name, standard_email, permissions flags, etc.).
 * @param {array} $_FILES - FILES input; may include 'profile_image' (allowed types: jpg|jpeg|png) to update user_photo.
 * @returns {void} Prints (echoes) JSON responses or validation codes and terminates execution; does not return a PHP value.
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
			
            //<------------------update user------------------>
                
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
				    
				    
				   	//  echo '<pre>';print_r($data);exit; 
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
 * Validate update form fields (name, email, mobile, user type, address, GST, location, zipcode) and return the validation result.
 * @example
 * // Called from the Home1 controller
 * $result = $this->check_update_validation();
 * // On validation failure this returns a JSON-encoded string (example):
 * // {"st":202,"standard_name":"Name is required","standard_email":"Email is required","standard_mobile":"Number is required","user_typeUpdate":"User type is required","country":"Country is required","state":"State is required","city":"City is required","zipcode":"Zipcode is required","company_gstin":"GST is required","company_address":"Company Address is required"}
 * // On success this returns an integer:
 * // 200
 * @returns {int|string} Return 200 on successful validation, otherwise a JSON-encoded string containing 'st' => 202 and per-field error messages.
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
 * Delete a record by ID, decrement the associated plan's used licence if applicable, remove the record and echo a JSON status.
 * @example
 * $this->delete(123);
 * // outputs: {"status":true}
 * @param {int|string} $id - Identifier of the record/user to delete (e.g., 123).
 * @returns {void} Echoes a JSON-encoded response with the operation status ({"status": true} on success).
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
 * Outputs a JSON-formatted list of branches suitable for DataTables (reads paging from $_POST and uses Branch_model).
 * @example
 * $_POST['draw'] = 1;
 * $_POST['start'] = 0;
 * $this->ajax_list_branch();
 * // Sample JSON output:
 * // {"draw":1,"recordsTotal":5,"recordsFiltered":5,"data":[
 * //  ["<input type=\"checkbox\" class=\"delete_checkbox\" value=\"1\">","Main Branch<div class=\"links\"><a style=\"text-decoration:none\" href=\"javascript:void(0)\" onclick=\"view('1')\" class=\"text-info\">View</a> | <a style=\"text-decoration:none\" href=\"javascript:void(0)\" onclick=\"update('1')\" class=\"text-secondary\">Update</a> | <a style=\"text-decoration:none\" href=\"javascript:void(0)\" onclick=\"delete_entry('1')\" class=\"text-danger\">Delete</a></div>","branch@example.com","0123456789","ACME Corp","GSTIN123","<input type=\"checkbox\" class=\"delete_checkbox\" value=\"1\">"],
 * //  ["<input type=\"checkbox\" class=\"delete_checkbox\" value=\"2\">","Secondary Branch<div class=\"links\">...","branch2@example.com","0987654321","ACME Corp","GSTIN456","<input type=\"checkbox\" class=\"delete_checkbox\" value=\"2\">"]
 * // ]}
 * @param array $_POST - Superglobal array expected to contain 'draw' (int) and 'start' (int) for DataTables paging.
 * @returns void Echoes JSON response containing draw, recordsTotal, recordsFiltered and data array.
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
  * Create a new branch using POST data and the current session; echoes a JSON success status or a validation error and exits.
  * @example
  * // Setup (example values)
  * $this->session->set_userdata([
  *   'id' => 123,
  *   'email' => 'admin@example.com',
  *   'company_name' => 'Acme Ltd'
  * ]);
  * $_POST = [
  *   'branch_name' => 'Acme Branch',
  *   'branch_email' => 'branch@example.com',
  *   'contact_number' => '9876543210',
  *   'gstin' => '29ABCDE1234F2Z5',
  *   'cin' => 'U12345MH2010PTC123456',
  *   'pan' => 'ABCDE1234F',
  *   'country' => 'India',
  *   'state' => 'Karnataka',
  *   'city' => 'Bengaluru',
  *   'zipcode' => '560001',
  *   'address' => '123 Main St'
  * ];
  * $this->create_branch();
  * // Possible output on success:
  * // {"st":200}
  * // Possible output on validation failure (example):
  * // 400
  * @param void $none - This method does not accept parameters; it reads from session and POST data.
  * @returns void Echoes a JSON-encoded success object (e.g. {"st":200}) on success, or echoes a validation error code and terminates execution.
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
 * Update an existing branch record using POSTed form data after validation.
 * @example
 * $_POST = array(
 *   'id' => 12,
 *   'branch_name' => 'Main Branch',
 *   'branch_email' => 'main@example.com',
 *   'contact_number' => '1234567890',
 *   'gstin' => '27ABCDE1234F1Z5',
 *   'cin' => 'L12345MH2000PLC123456',
 *   'pan' => 'ABCDE1234F',
 *   'country' => 'India',
 *   'state' => 'Maharashtra',
 *   'city' => 'Mumbai',
 *   'zipcode' => '400001',
 *   'address' => '123 Some Street'
 * );
 * $result = $this->update_branch();
 * echo $result // render sample output: {"st":200}
 * @param array $post - Associative array of POST values expected (id, branch_name, branch_email, contact_number, gstin, cin, pan, country, state, city, zipcode, address).
 * @returns string JSON-encoded status response (e.g. '{"st":200}') or a validation error code echoed directly.
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
 * Validate branch form inputs and return validation result as JSON errors or success code.
 * @example
 * $result = $this->check_branch_validation();
 * echo $result; // Example outputs: 200 (on success) OR '{"st":202,"branch_name":"Name is required","branch_email":"Email is not valid","contact_number":"Number is not valid","gstin":"GSTIN is required","cin":"CIN is required","pan":"Pan is required","country":"Country is required","state":"State is required","city":"City is required","zipcode":"Zipcode is required","address":"Branch Address is required"}'
 * @param void $none - No arguments are required by this method.
 * @returns mixed Returns integer 200 on successful validation or a JSON-encoded string containing validation error messages with status 202 on failure.
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
 * Get profit table rows for DataTables and output them as a JSON response.
 * @example
 * // Example POST values expected by the method:
 * $_POST['start'] = 0;
 * $_POST['draw'] = 1;
 * // Call from controller:
 * $this->get_profit_table();
 * // Example JSON output (formatted):
 * // {
 * //   "draw": 1,
 * //   "recordsTotal": 125,
 * //   "recordsFiltered": 10,
 * //   "data": [
 * //     ["Alice","SO/2025/001","Acme Corp","Website Project","1,00,000","1,20,000","20,000"],
 * //     ["Bob","SO/2025/002","Beta LLC","App Development","80,000","90,000","10,000"]
 * //   ]
 * // }
 * @param array $_POST - Global POST array containing DataTables parameters (e.g. 'start' and 'draw').
 * @returns void Echoes JSON-encoded array for DataTables with keys: draw, recordsTotal, recordsFiltered and data.
 */
	public function get_profit_table()
	{
		$list = $this->Reports_model->get_profit_pro_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $post) {
			$so_Id = $post->saleorder_id;
			$ex = explode("/", $so_Id);
			$output = array_slice($ex, 2);
			$saleorder_id = implode("/", $output);
			$no++;
			$row = array();
			$row[] = ucfirst($post->owner);
			$row[] = $saleorder_id;
			$row[] = $post->org_name;
			$row[] = $post->subject;
			$row[] = IND_money_format(intval($post->after_discount));
			$row[] = IND_money_format($post->total_orc);
			$row[] = IND_money_format($post->profit_by_user);
			$data[] = $row;
		}
		$output = array("draw" => $_POST['draw'], "recordsTotal" => $this->Reports_model->count_all_pro(), "recordsFiltered" => $this->Reports_model->count_filtered_pro(), "data" => $data,);
		echo json_encode($output);
	}
	public function get_profitTable_all_User_so()
	{
		$list = $this->Reports_model->count_profit_user_so();
		echo $list['profit_by_user'];
	}
 /**
 * Outputs a JSON-encoded product-wise profit table (formatted for DataTables) based on POST parameters.
 * @example
 * // Typical controller call via HTTP POST (no direct return; method echoes JSON)
 * $this->get_profit_table_product_wise();
 * // Example echoed output (JSON):
 * // {"draw":1,"recordsTotal":100,"recordsFiltered":50,"data":[["Alice","SO123","PO456","Sample subject..","1,000"],["Bob","SO124","PO457","Another subject..","2,500"]]}
 * @param array $_POST - POST parameters used by the method (expects at least 'start' => int and 'draw' => int).
 * @returns void Outputs (echoes) a JSON string with keys: draw (int), recordsTotal (int), recordsFiltered (int), data (array of rows).
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
 * Generate a SQL dump of the local MySQL database and send it as an email (Office365 SMTP) with the dump attached.
 * @example
 * $this->sentMailAtt();
 * // Sends an email to dev2@team365.io from no-reply@team365.io and attaches a file like "admintea_team365_backup_2025-12-19 14 30 00.sql"
 * @param void $none - This method does not accept any arguments.
 * @returns void Performs side effects: creates a .sql backup file in the current working directory and attempts to send it as an email attachment; no value is returned.
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
