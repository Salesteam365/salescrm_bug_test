<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create_tbl extends CI_Controller {

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


        $this->load->model('Create_model');
        $this->load->dbforge();        
      
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
         
          $this->load->view('tables/table_list',$data);
        }else{
          redirect('home');
        }
    }


    public function create_tbl(){
        $data['create_tbl'] = "Create Tables";
        $this->load->view('tables/create_tbl', $data);
    }



    // public function create_table(){


    //         $table_name = $this->input->post('table_name');
    //         $fields     = $this->input->post('fields'); 
    //         //  print_r($fields);die;


    //         if(!$table_name || empty($fields)) {
    //             echo "Table name & fields required!";
    //             return;
    //         }

    //         // Check if table already exists
    //         if ($this->db->table_exists($table_name)) {
    //             echo json_encode(['status' => false, 'message' => "Table `{$table_name}` already exists!"]);
    //             return;
    //         }else{
                
    //         }

    //         $field_array = [];

    //         foreach($fields as $f) {
    //             $fname  = $f['name'];
    //             $ftype  = strtoupper($f['type']);
    //             $flen   = !empty($f['length']) ? $f['length'] : null;
    //             $fnull  = isset($f['null']) && $f['null'] == 'true' ? TRUE : FALSE;

    //             $field_array[$fname] = [
    //                 'type' => $ftype,
    //                 'constraint' => $flen,
    //                 'null' => $fnull
    //             ];

    //             if(isset($f['auto_increment']) && $f['auto_increment'] == 'true'){
    //                 $field_array[$fname]['auto_increment'] = TRUE;
    //                 $this->dbforge->add_key($fname, TRUE); // primary key
    //             }
    //         }

    //         $this->dbforge->add_field($field_array);

    //         if ($this->dbforge->create_table($table_name, TRUE)) {
    //             echo json_encode(['status' => true, 'message' => "Table `{$table_name}` created successfully!"]);
    //         } else {
    //             echo json_encode(['status' => false, 'message' => 'Error creating table!']);
    //         }

        
    

    // }



     public function create_table() {
        $table_name = $this->input->post('table_name');
        $fields     = $this->input->post('fields'); 

        if(!$table_name || empty($fields)) {
            echo json_encode(['status' => false, 'message' => "Table name & fields required!"]);
            return;
        }




        // Table does NOT exist → Create it
        if (!$this->Create_model->table_exists($table_name)) {

            $created = $this->Create_model->create_new_table($table_name, $fields);
            if ($created) {
                echo json_encode(['status' => true, 'message' => "Table `{$table_name}` Created Successfully!"]);
            } else {
                echo json_encode(['status' => false, 'message' => "Error creating table `{$table_name}`."]);
            }
        } 
        // Table exists → Add missing columns
        else {
            $added = $this->Create_model->add_missing_columns($table_name, $fields);

            if (!empty($added)) {
                echo json_encode(['status' => true, 'message' => "Table exists. Added new columns: " . implode(', ', $added)]);
            } else {
                echo json_encode(['status' => true, 'message' => "Table and all columns already exist. Nothing to change."]);
            }
        }
    }



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

//<----------------------------------------- End Ajax List --------------------------------------------------->







}








