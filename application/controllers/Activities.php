<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  class Activities extends CI_Controller
  {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Organization_model','Organization');
		$this->load->model('Contact_model','Contact');
		$this->load->model('Login_model');
		$this->load->model('Reports_model','Reports');
		$this->load->model('Activities_model','Todo_work');
		$this->load->library('excel');
   }
   
  public function getData($currentdate,$fltr){
    // echo $this->input->post('fromDate')."text test";
    $data['total_org']    = $this->Todo_work->get_all_org($currentdate,$fltr);
    $data['total_leads']  = $this->Todo_work->get_leads_status($currentdate,$fltr);
    $data['total_opp']    = $this->Todo_work->get_opp_stage($currentdate,$fltr);
    $data['get_opp_stage_count'] = $this->Todo_work->get_opp_stage_count($currentdate,$fltr);
    
    $data['total_quotes'] = $this->Todo_work->get_quote_stage($currentdate,$fltr);
    $data['total_sales']  = $this->Todo_work->get_sales_stage($currentdate,$fltr);
    $data['total_purch']  = $this->Todo_work->get_purchase($currentdate,$fltr);
    $data['total_task']   = $this->Todo_work->get_task($currentdate,$fltr);
    $data['total_meeting']= $this->Todo_work->get_meeting($currentdate,$fltr);
    $data['total_call']   = $this->Todo_work->get_call($currentdate,$fltr);
    $data['total_vendors']= $this->Todo_work->get_vendors($currentdate,$fltr);
    $data['total_pi']	  = $this->Todo_work->get_proforma($currentdate,$fltr);
    $data['total_roles']  = $this->Todo_work->get_roles($currentdate,$fltr);
    
    // Lead Status Access...
    // $data['conatacted_status'] = $this->Todo_work->leads_status($currentdate,'contacted',$fltr);
    // $data['inprogess_status'] = $this->Todo_work->leads_status($currentdate,'In Progress',$fltr);
    // $data['conatactinfuture_status'] = $this->Todo_work->leads_status($currentdate,'Conatact In Future',$fltr);
    // $data['lostLead'] = $this->Todo_work->leads_status($currentdate,'Lost Lead',$fltr);
    // $data['NotQualified'] = $this->Todo_work->leads_status($currentdate,'Not-Qualified',$fltr);
    // $data['closeWon'] = $this->Todo_work->leads_status($currentdate,'Closed Won',$fltr);
    $data['conatacted_status']       = $this->Todo_work->leads_status($fltr,$currentdate,'contacted');
    $data['inprogess_status']        = $this->Todo_work->leads_status($fltr,$currentdate,'In Progress');
    $data['conatactinfuture_status'] = $this->Todo_work->leads_status($fltr,$currentdate,'Conatact In Future');
    $data['lostLead']                = $this->Todo_work->leads_status($fltr,$currentdate,'Lost Lead');
    $data['NotQualified']            = $this->Todo_work->leads_status($fltr,$currentdate,'Not-Qualified');
    $data['closeWon']                = $this->Todo_work->leads_status($fltr,$currentdate,'Closed Won');
    // Opportunity Status Access...
    
    $data['quali_status']     = $this->Todo_work->opport_status($fltr,$currentdate,'Qualifying');
    $data['neddsan_status']   = $this->Todo_work->opport_status($fltr,$currentdate,'Needs Analysis');
    $data['prop_status']      = $this->Todo_work->opport_status($fltr,$currentdate,'Proposal');
    $data['negot_status']     = $this->Todo_work->opport_status($fltr,$currentdate,'Negotiation');
    $data['cwon_status']      = $this->Todo_work->opport_status($fltr,$currentdate,'Closed Won');
    $data['clost_status']     = $this->Todo_work->opport_status($fltr,$currentdate,'Closed Lost');
    $data['new']              = $this->Todo_work->opport_status($fltr,$currentdate,'New');
    $data['ReadyToClose']     = $this->Todo_work->opport_status($fltr,$currentdate,'Ready To Close');
    $data['valueProposition'] = $this->Todo_work->opport_status($fltr,$currentdate,'Value Proposition');
    
    
    // Quotation Status Access...
    $data['draft_status']   = $this->Todo_work->quote_status($fltr,$currentdate,'Draft');
    $data['nego_status']    = $this->Todo_work->quote_status($fltr,$currentdate,'Negotiation');
    $data['deliv_status']   = $this->Todo_work->quote_status($fltr,$currentdate,'Delivered');
    $data['hold_status']    = $this->Todo_work->quote_status($fltr,$currentdate,'On Hold');
    $data['conf_status']    = $this->Todo_work->quote_status($fltr,$currentdate,'Confirmed');
    $data['cwons_status']   = $this->Todo_work->quote_status($fltr,$currentdate,'Closed Won');
    $data['close_status']   = $this->Todo_work->quote_status($fltr,$currentdate,'Closed Lost');
    
    
    
    // Sales Status Access...
    $data['pending_status']     = $this->Todo_work->sales_status($fltr,$currentdate,'100');
    $data['complete_status']    = $this->Todo_work->sales_status($fltr,$currentdate,'0');
    
    // Task Status Access...
    $data['todaydue']       = $this->Todo_work->task_status($fltr,$currentdate,'todaydue');
    $data['tomarrowdue']    = $this->Todo_work->task_status($fltr,$currentdate,'tomarrowdue');
    $data['notStart']       = $this->Todo_work->task_status($fltr,$currentdate,'1');
    $data['progress']       = $this->Todo_work->task_status($fltr,$currentdate,'3');
    $data['pending']        = $this->Todo_work->task_status($fltr,$currentdate,'4');
    $data['completed']      = $this->Todo_work->task_status($fltr,$currentdate,'2');
    $data['deactive']       = $this->Todo_work->task_status($fltr,$currentdate,'0');
    
    //Meeting Status Access...
    $data['todayMetting']     = $this->Todo_work->meeting_status($fltr,$currentdate,'todayMetting');
    $data['tomarroeMetting']  = $this->Todo_work->meeting_status($fltr,$currentdate,'tomarroeMetting');
    $data['notStartMt']       = $this->Todo_work->meeting_status($fltr,$currentdate,'1');
    $data['progressMt']       = $this->Todo_work->meeting_status($fltr,$currentdate,'3');
    $data['pendingMt']        = $this->Todo_work->meeting_status($fltr,$currentdate,'4');
    $data['completedMt']      = $this->Todo_work->meeting_status($fltr,$currentdate,'2');
    $data['deactiveMt']       = $this->Todo_work->meeting_status($fltr,$currentdate,'0');
    
    //Call Status Access...
      $data['notStartCl']       = $this->Todo_work->call_status($fltr,$currentdate,'1');
    $data['progressCl']       = $this->Todo_work->call_status($fltr,$currentdate,'3');
    $data['pendingCl']        = $this->Todo_work->call_status($fltr,$currentdate,'4');
    $data['completedCl']      = $this->Todo_work->call_status($fltr,$currentdate,'2');
    $data['deactiveCl']       = $this->Todo_work->call_status($fltr,$currentdate,'0');
    return $data;

  } 
  
    
  public function index()
  {
	
	if(!empty($this->session->userdata('email'))){
    // dd(check_permission_status('Retrieve Activities','other')); 
		if(check_permission_status('Retrieve Activities','other')==true){ 
			$currentdate=date('Y-m-d'); 
			$data = $this->getData($currentdate,'');
      $this->load->view('activities',$data);
		}else{
			redirect("permission");
		}
	}else{
	  redirect('login');
	}
  }
  
  
  public function getFiltered(){
    if(!empty($this->session->userdata('email')))
	{
	    
	    $currentdate=$this->input->post('date_filter'); 
	    if($currentdate == "This Week")
        {
          $currentdate=date('Y-m-d',strtotime('last monday'));
        }
	  if(empty($currentdate)){
	  $fromDate= $this->input->post('fromDate');
	  $toDate  = $this->input->post('toDate'); 
	  $currentdate=$fromDate."|".$toDate;
	  }
      $data=$this->getData($currentdate,'filter');
      
      ?>
     <style>
      h4, h5 {
  color: #000;
  
}

.small-box{
 border-radius:12px;
background-color:#fff;
margin:8px;}
     </style> 
      <div class="row" id="putData">
         <!-- small box -->
           <div class="col-lg-4 col-6">
            <div class="small-box " style="border-left:7px solid #ffcba4 ;" onclick="org_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Organization</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?=$data['total_org']['total_org'];?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          
          <!-- ./col -->
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ace1af;" onclick="lead_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Leads</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?=$data['total_leads']['total_leads'];?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Contacted:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['conatacted_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>In Progress:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['inprogess_status']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Contact In Future:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['conatactinfuture_status']);?><h4>
                      </div>
                    </div>
                  </div>
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Lost Lead:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['lostLead']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Closed Won:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['closeWon']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Not Qualified:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4> <?=count($data['NotQualified']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                
                
              </div>
			 
            </div>
          </div>
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ff4040;" onclick="opport_list()">
              <div class="inner animate__animated animate__flipInX">
                  
                <div class="row">
                  <div class="col-lg-3">
                  <h4 style="font-weight:bold; font-size:20px;">Opportunity</h4>
                    </div>
                  <div class="col-lg-7">  
                    <text style="float: right;">(₹ <?php echo $data['get_opp_stage_count'][0]['initial_total'];?>)</text>
                  </div>
                  <div class="col-lg-2 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_opp']['total_opp']; ?></h4>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Qualifying:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['quali_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Needs Analysis:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['neddsan_status']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Proposal:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['prop_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Negotiation:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['negot_status']);?></h4>
                      </div>
                    </div>
                  </div>
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Closed Won:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['cwon_status']);?></h4>
                      </div>
                    </div>
                  </div> 
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Closed Lost:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['clost_status']);?></h4>
                      </div>
                    </div>
                  </div>
                 </div> 
                 <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>New:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['new']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Ready To Close:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['ReadyToClose']);?></h4>
                      </div>
                    </div>
                  </div>
                  </div>
                  
              </div>
            </div>
          </div>
          
          
          
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #45b1e8;" onclick="quotation_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Quotation</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_quotes']['total_quotes'];?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Draft:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['draft_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Negotiation:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['nego_status']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Delivered:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['deliv_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>On Hold:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['hold_status']);?></h4>
                      </div>
                    </div>
                  </div> 
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Confirmed:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['conf_status']);?></h4>
                      </div>
                    </div>
                  </div>
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Closed Won:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['cwons_status']);?></h4>
                      </div>
                    </div>
                  </div>
				  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Closed Lost:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['close_status']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #dda0dd;" onclick="sales_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Salesorder</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?=$data['total_sales']['total_sales'];?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Pending :</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4> <?=count($data['pending_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Completed :</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4> <?=count($data['complete_status']);?></h4>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ffcba4;" onclick="purchase_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-8">
                  <h4 style="font-weight:bold; font-size:20px;">Purchaseorder</h4>
                  </div>
                  <div class="col-lg-4 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_purch']['total_purch'];?></h4>
                  </div>
                </div>
              
              </div>
            </div>
          </div>
          
          <!-- ./col -->
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ace1af;" onclick="task_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Task</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?=$data['total_task']['total_task'];?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Today due task:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['todaydue']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Tomorrow Due:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['tomarrowdue']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Not Started:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['notStart']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>In Progress:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['progress']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Pending:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['pending']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Completed:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4> <?=count($data['completed']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid red; " onclick="meeting_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Meeting</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_meeting']['total_meeting'];?></h4>
                  </div>
                </div>
               <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Today Meeting:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['todayMetting']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Tomorrow Meeting:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4> <?=count($data['tomarroeMetting']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Not Started:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4> <?=count($data['notStartMt']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>In Progress:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['progressMt']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Pending:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['pendingMt']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Completed:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['completedMt']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"  style="border-left:7px solid #45b1e8;" onclick="call_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Call</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_call']['total_call'];?></h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Not Started:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4><?=count($data['notStartCl']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Progress:<h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['progressCl']);?></h4>
                      </div>
                    </div>
                  </div>
                </div>
               <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4>Completed:</h4>
                      </div>
                      <div class="col-lg-4 text-right" style="border-right: 1px solid #ccc;">
                      <h4> <?=count($data['completedCl']);?></h4>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-8">
                      <h4> Deactivate:</h4>
                      </div>
                      <div class="col-lg-4 text-right">
                      <h4><?=count($data['deactiveCl']);?></h4>
                      </div>
                    </div>
                  </div>
				 
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
		  
		 <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #dda0dd" onclick="vendors_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Vendors</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_vendors']['total_vendors'];?></h4>
                  </div>
                </div>
              
              </div>
            </div>
          </div>
          <!-- ./col -->
       <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box"style="border-left:7px solid #ffcba4" onclick="proforma_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-6">
                  <h4 style="font-weight:bold; font-size:20px;">Proforma Invoice</h4>
                  </div>
                  <div class="col-lg-6 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?=$data['total_pi']['total_pi'];?></h4>
					<h6><?//=count($pi_status);?></h6>
                  </div>
                </div>
               <div class="row">
                 
                </div>
              
              </div>
            </div>
          </div>
          <!-- ./col -->
		  <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ace1af" onclick="roles_list()">
              <div class="inner animate__animated animate__flipInX">
                <div class="row">
                  <div class="col-lg-8">
                  <h4 style="font-weight:bold; font-size:20px;">Roles</h4>
                  </div>
                  <div class="col-lg-4 text-right">
                  <h4 style="font-weight:bold; font-size:20px;"><?= $data['total_roles']['total_roles'];?></h4>
                  <h4 style="font-weight:bold; font-size:20px;"><?//=count($roles_st);?></h4>
                  </div>
                </div>
              
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      <?php
	}
	else
	{
	  redirect('login');
	}
  }
  
  
   public function getId_org()
   {
    $data = $this->Todo_work->get_by_id(); 
	$output = 
		 '<thead>
			<tr>
			<th class="th-sm">Organization Name</th>
			<th class="th-sm">Email</th>
			<th class="th-sm">Website</th>
			<th class="th-sm">Mobile</th>
			<th class="th-sm">Billing City</th>
		  </tr>
		</thead>';
		echo $output;
     foreach($data as $org_list)
	 {
		 $output = 
		 '<tr><td>'.$org_list['org_name'].'</td>
		 <td>'.$org_list['email'].'</td>		 
		 <td>'.$org_list['website'].'</td>	 
		 <td>'.$org_list['mobile'].'</td>	 
		 <td>'.$org_list['billing_city'].'</td></tr>';	
       echo $output;		 
	 } 
  }
  public function getId_leads()
   {
    $data_leads = $this->Todo_work->get_by_leads(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Lead Name</th>
				<th class="th-sm">Organization Name</th>
				<th class="th-sm">Email</th>
				<th class="th-sm">Assigned To</th>
				<th class="th-sm">Lead Status</th>
			</tr>
		</thead>';
		echo $output;
     foreach($data_leads as $lead_list)
	 {
		 $output = 
		 '<tr><td>'.$lead_list['name'].'</td>
		 <td>'.$lead_list['org_name'].'</td>		 
		 <td>'.$lead_list['email'].'</td>	 
		 <td>'.$lead_list['assigned_to_name'].'</td>
         <td>'.$lead_list['lead_status'].'</td></tr>';	
      echo $output;		 
	}
  }
  public function getId_opport()
   {
    $data_opprt = $this->Todo_work->get_by_opport(); 
	$output = 
		'<thead>
			<tr>
				<th class="th-sm">Opportunity Name</th>
				<th class="th-sm">Organization Name</th>
				<th class="th-sm">Email</th>
				<th class="th-sm">Primary Phone</th>
				<th class="th-sm">Opportunuity ID</th>
			</tr>
         </thead>';
		echo $output;
     foreach($data_opprt as $opprt_list)
	 {
		 $output = 
		 '<tr><td>'.$opprt_list['name'].'</td>
		 <td>'.$opprt_list['org_name'].'</td>		 
		 <td>'.$opprt_list['email'].'</td>	 
		 <td>'.$opprt_list['mobile'].'</td>	 
		 <td>'.$opprt_list['opportunity_id'].'</td></tr>';	
   echo $output;		 
	 }
  }
  public function getId_quotat()
   {
    $data_quot = $this->Todo_work->get_by_quotat(); 
	$output = 
		 '<thead>
		  <tr>
			<th class="th-sm">Subject</th>
			<th class="th-sm">Organization Name</th>
			<th class="th-sm">Quote ID</th>
			<th class="th-sm">Date</th>
			<th class="th-sm">Owner</th>
		</tr>
	</thead>';
		echo $output;
     foreach($data_quot as $quot_list)
	 {
		 $output = 
		 '<tr><td>'.$quot_list['subject'].'</td>
		 <td>'.$quot_list['org_name'].'</td>		 
		 <td>'.$quot_list['quote_id'].'</td>	 
		 <td>'.$quot_list['currentdate'].'</td>	 
		 <td>'.$quot_list['owner'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_sales()
   {
    $data_sales = $this->Todo_work->get_by_sales(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Subject</th>
				<th class="th-sm">Organization Name</th>
				<th class="th-sm">Salesorder ID </th>
				<th class="th-sm">Date</th>
				<th class="th-sm">Status</th>
			</tr>
         </thead>';
		echo $output;
     foreach($data_sales as $sales_list)
	 {
		 $output = 
		 '<tr><td>'.$sales_list['subject'].'</td>
		 <td>'.$sales_list['org_name'].'</td>		 
		 <td>'.$sales_list['saleorder_id'].'</td>	 
		 <td>'.$sales_list['currentdate'].'</td>	 
		 <td>'.$sales_list['status'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_task()
   {
    $data_task = $this->Todo_work->get_by_task(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Task</th>
				<th class="th-sm">Task Owner</th>
				<th class="th-sm">Priority</th>
				<th class="th-sm">Due Date</th>
				<th class="th-sm">Status</th>
			</tr>
         </thead>';
		echo $output;
     foreach($data_task as $task_list)
	 {
		 $output = 
		 '<tr><td>'.$task_list['task_subject'].'</td>
		 <td>'.$task_list['task_owner'].'</td>		 
		 <td>'.$task_list['task_priority'].'</td>	 
		 <td>'.$task_list['task_due_date'].'</td>	 
		 <td>'.$task_list['status'].'</td></tr>';	
       echo $output;		 
	 }
   } 
   public function getId_meeting()
   {
    $data_meeting = $this->Todo_work->get_by_meeting(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Meeting</th>
				<th class="th-sm">Host By</th>
				<th class="th-sm">Location</th>
				<th class="th-sm">Date</th>
				<th class="th-sm">Status</th>
			</tr>
         </thead>';
		echo $output;
     foreach($data_meeting as $meeting_list)
	 {
		 $output = 
		 '<tr><td>'.$meeting_list['meeting_title'].'</td>
		 <td>'.$meeting_list['host_name'].'</td>		 
		 <td>'.$meeting_list['location'].'</td>	 
		 <td>'.$meeting_list['currentdate'].'</td>	 
		 <td>'.$meeting_list['status'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_call()
   {
    $data_call = $this->Todo_work->get_by_call(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Call</th>
				<th class="th-sm">Contact Name</th>
				<th class="th-sm">Call Purpose</th>
				<th class="th-sm">Releted To</th>
				<th class="th-sm">Status</th>
			</tr>
         </thead>';
		echo $output;
     foreach($data_call as $call_list)
	 {
		 $output = 
		 '<tr><td>'.$call_list['call_subject'].'</td>
		 <td>'.$call_list['contact_name'].'</td>		 
		 <td>'.$call_list['call_purpose'].'</td>	 
		 <td>'.$call_list['related_to'].'</td>	 
		 <td>'.$call_list['status'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_purch()
   {
    $data_purch = $this->Todo_work->get_by_purch(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Company Name</th>
				<th class="th-sm">Customer Name</th>
				<th class="th-sm">Vendor Name</th>
				<th class="th-sm">Subject</th>
				<th class="th-sm">PO Number</th>
				<th class="th-sm">Created By</th>
			</tr>
		</thead>';
		echo $output;
     foreach($data_purch as $purch_list)
	 {
		 $output = 
		 '<tr><td>'.$purch_list['supplier_comp_name'].'</td>
		 <td>'.$purch_list['customer_company_name'].'</td>		 
		 <td>'.$purch_list['supplier_name'].'</td>	 
		 <td>'.$purch_list['subject'].'</td>	 
		 <td>'.$purch_list['purchaseorder_id'].'</td>	
		 <td>'.$purch_list['owner'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_vendors()
   {
    $data_vendor= $this->Todo_work->get_by_vendors(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Vendor Name</th>
				<th class="th-sm">Primary Email</th>
				<th class="th-sm">Primary Phone</th>
				<th class="th-sm">Created By</th>
				<th class="th-sm">Assigned To</th>
			</tr>
		</thead>';
		echo $output;
     foreach($data_vendor as $vend_list)
	 {
		 $output = 
		 '<tr><td>'.$vend_list['name'].'</td>
		 <td>'.$vend_list['email'].'</td>		 
		 <td>'.$vend_list['mobile'].'</td>	 
		 <td>'.$vend_list['created_by'].'</td>
		 <td>'.$vend_list['asigned_to'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_proforma()
   {
    $data_pro= $this->Todo_work->get_by_proforma(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Invoice#</th>
				<th class="th-sm">Billed To(Org Name)</th>
				<th class="th-sm">Page Name</th>
				<th class="th-sm">Total Amount</th>
				<th class="th-sm">Status</th>
				<th class="th-sm">Date</th>
			</tr>
		</thead>';
		echo $output;
     foreach($data_pro as $pi_list)
	 {
		 $output = 
		 '<tr><td>'.$pi_list['invoice_no'].'</td>
		 <td>'.$pi_list['billedto_orgname'].'</td>		 
		 <td>'.$pi_list['page_name'].'</td>	 
		 <td>'.$pi_list['final_total'].'</td>
		 <td>'.$pi_list['pi_status'].'</td>
		 <td>'.$pi_list['currentdate'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function getId_roles()
   {
    $data_roles= $this->Todo_work->get_by_roles(); 
	$output = 
		 '<thead>
			<tr>
				<th class="th-sm">Role Name</th>
				<th class="th-sm">Report To</th>
				<th class="th-sm">Status</th>
			</tr>
		</thead>';
		echo $output;
     foreach($data_roles as $roles_list)
	 {
		 $output = 
		 '<tr><td>'.$roles_list['role_name'].'</td>
		 <td>'.$roles_list['parent_role_id'].'</td>
		 <td>'.$roles_list['status'].'</td></tr>';	
       echo $output;		 
	 }
   }
   public function select_date()
   {
	   
   }
  }
?>