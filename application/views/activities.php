<?php $this->load->view('common_navbar');
?>
<style type="text/css">
  .achieved_red { color: #e85f7c !important; }
  .achieved_orange { color: orange !important; }
  .achieved_green { color: green !important; }
  
  .small-box {  min-height: 150px; }
  
  /*select#date_filter {
   
}*/

#org_datatable thead tr th,
#lead_datatable thead tr th,
#opp_datatable thead tr th,
#po_datatable thead tr th,
#pi_datatable thead tr th,
#call_datatable thead tr th,
#task_datatable thead tr th,
#meet_datatable thead tr th,
#vend_datatable thead tr th {
  background: rgba(35, 0, 140, 0.8);
  color: #fff;
  font-size: 16px;
  border-bottom: none;
}

#org_datatable tbody tr td,
#lead_datatable tbody tr td,
#opp_datatable tbody tr td,
#po_datatable tbody tr td,
#pi_datatable tbody tr td,
#call_datatable tbody tr td,
#task_datatable tbody tr td,
#meet_datatable tbody tr td,
#vend_datatable tbody tr td {
  background-color: #fff;
  font-size: 14px;
  font-family: system-ui;
  font-weight: 651;
  color: rgba(0, 0, 0, 0.7);
  padding-top: 16px;
  padding-bottom: 16px;
}

#org_datatable tbody tr td:nth-child(3),
#lead_datatable tbody tr td:nth-child(3),
#opp_datatable tbody tr td:nth-child(3),
#po_datatable tbody tr td:nth-child(3),
#pi_datatable tbody tr td:nth-child(3),
#call_datatable tbody tr td:nth-child(3),
#task_datatable tbody tr td:nth-child(3),
#meet_datatable tbody tr td:nth-child(3),
#vend_datatable tbody tr td:nth-child(3) {
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}



h4, h4 {
  color: #000;
  
}

.small-box{
 border-radius:12px;
background-color:#fff;
margin:8px;}


.your-element {
    border: 5px solid transparent; /* Transparent border to allow gradient */
    border-image: linear-gradient(to right, #6B46C1, #3182CE) 1; /* Gradient for the border */
}

 /* Media query for first box */

 @media screen and (max-width: 991px) {
           .filterbtncon{
            margin:auto;
           }
          }
          

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.7);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Today's Activities</h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
           </div>    
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>#">Home</a></li>
              <li class="breadcrumb-item active">To Do Work</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="container-fliud filterbtncon" style="box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);">
        <?php 
                                   $fifteen = strtotime("-15 Day"); 
                                   $thirty = strtotime("-30 Day"); 
                                   $fortyfive = strtotime("-45 Day"); 
                                   $sixty = strtotime("-60 Day"); 
                                   $ninty = strtotime("-90 Day"); 
                                   $six_month = strtotime("-180 Day"); 
                                   $one_year = strtotime("-365 Day");
                            ?>
         <!-- /.row -->
         <div class="row mb-3">
            <div class="col-lg-2">
            <div class="first-one custom-dropdown dropdown">
              <b>Select option</b>
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
                  <input type="hidden" name="date_filter" id="date_filter">
                  <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','getsovalue','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</li>
    </ul>
</div>
   </div>
          <div class="col-lg-2">
              <b>From Date</b>	  
            <input type="date" class="custom-select" placeholder="From Date" value="" id="fromDate">
          </div>
          <div class="col-lg-2">
	        <b>To Date</b>
	        <input type="date" class="custom-select" placeholder="To Date" value="" id="toDate">
          </div>
        </div>
        
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" style="margin-top:32px;">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" id="putData">
         <!-- small box -->
         <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
   <div class="small-box" style="border-left:4px solid #508aff; border-right:4px solid #508aff;box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="org_list()">
      <div class="inner animate__animated animate__flipInX">
         <div class="row">
            <div class="col-6">
               <h4 class="font-weight-bold" style="font-size:20px; float:left">Organization</h4>
            </div>
            <div class="col-6 text-right">
               <h4 class="font-weight-bold" style="font-size:20px;"><?=$total_org['total_org'];?></h4>
            </div>
         </div>
      </div>
   </div>
</div>

          
          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #ffc355; border-right:4px solid #ffc355; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="lead_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left">Leads</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?=$total_leads['total_leads'];?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Contacted:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($conatacted_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>In Progress:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($inprogess_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Cont. In Future:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($conatactinfuture_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Lost Lead:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($lostLead);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Closed Won:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($closeWon);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Not Qualified:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($NotQualified);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #ff7ead; border-right:4px solid #ff7ead; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="opport_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-8">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Opportunity 
                        <text style="float: left;">(₹<?php echo IND_money_format($get_opp_stage_count[0]['initial_total']); ?>)</text>
                    </h4>
                </div>
                <div class="col-4 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_opp['total_opp']; ?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Qualifying:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($quali_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Needs Analysis:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($neddsan_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Proposal:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($prop_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Negotiation:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($negot_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Closed Won:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($cwon_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Closed Lost:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($clost_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>New:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($new);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Ready To Close:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($ReadyToClose);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #8255ff; border-right:4px solid #8255ff; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="quotation_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Quotation</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_quotes['total_quotes']; ?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Draft:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($draft_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Negotiation:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($nego_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Delivered:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($deliv_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>On Hold:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($hold_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Confirmed:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($conf_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Closed Won:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($cwons_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Closed Lost:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($close_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #508aff; border-right:4px solid #508aff; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="sales_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Salesorder</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?=$total_sales['total_sales'];?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Pending:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($pending_status);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Completed:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($complete_status);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #ffc355; border-right:4px solid #ffc355; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="purchase_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-8">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Purchaseorder</h4>
                </div>
                <div class="col-4 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_purch['total_purch'];?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

          
          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #ff7ead; border-right:4px solid #ff7ead; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="task_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Task</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_task['total_task'];?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Today due task:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($todaydue);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Tomorrow Due:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($tomarrowdue);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Not Started:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($notStart);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>In Progress:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($progress);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Pending:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($pending);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Completed:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($completed);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #8255ff; border-right:4px solid #8255ff; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="meeting_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Meeting</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_meeting['total_meeting'];?></h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Today Meeting:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($todayMetting);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Tomorrow Meeting:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($tomarroeMetting);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Not Started:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($notStartMt);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>In Progress:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($progressMt);?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Pending:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($pendingMt);?></h4>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <h4>Completed:</h4>
                        </div>
                        <div class="col-4 text-right">
                            <h4><?=count($completedMt);?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- small box -->
    <div class="small-box" style="border-left:4px solid #508aff; border-right:4px solid #508aff; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="call_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Call</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;">0</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <h4>Not Started:</h4>
                </div>
                <div class="col-6 text-right">
                    <h4><?=count($notStartCl);?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h4>Progress:</h4>
                </div>
                <div class="col-6 text-right">
                    <h4><?=count($progressCl);?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h4>Completed:</h4>
                </div>
                <div class="col-6 text-right">
                    <h4><?=count($completedCl);?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <h4>Deactivate:</h4>
                </div>
                <div class="col-6 text-right">
                    <h4><?=count($deactiveCl);?></h4>
                </div>
            </div>
        </div>
    </div>
</div>


          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- Vendors Box -->
    <div class="small-box" style="border-left:4px solid #ffc355; border-right:4px solid #ffc355; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="vendors_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Vendors</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_vendors['total_vendors'];?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- Proforma Invoice Box -->
    <div class="small-box" style="border-left:4px solid #ff7ead; border-right:4px solid #ff7ead; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="proforma_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-6">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Proforma Invoice</h4>
                </div>
                <div class="col-6 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?=$total_pi['total_pi'];?></h4>
                    <h6><?//=count($pi_status);?></h6>
                </div>
            </div>
        </div>
    </div>
</div>

          <!-- ./col -->
          <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
    <!-- Roles Box -->
    <div class="small-box" style="border-left:4px solid #8255ff; border-right:4px solid #8255ff; box-shadow: 0 4px 10px rgba(107, 70, 193, 0.6), 0 4px 20px rgba(49, 130, 206, 0.6);" onclick="roles_list()">
        <div class="inner animate__animated animate__flipInX">
            <div class="row">
                <div class="col-8">
                    <h4 style="font-weight:bold; font-size:20px; float:left;">Roles</h4>
                </div>
                <div class="col-4 text-right">
                    <h4 style="font-weight:bold; font-size:20px;"><?= $total_roles['total_roles'];?></h4>
                    <h6><?//=count($roles_st);?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ./col -->

        <!-- /.row -->
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="card org_div" id="divOrgTable" style="display:none;">
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="org_datatable"  class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Organization Name</th>
                            <th class="th-sm">Email</th>
                            <th class="th-sm">Website</th>
                            <th class="th-sm">Mobile</th>
                            <th class="th-sm">Billing City</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>    
            <div class="card org_div" id="divLeadTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="lead_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th class="th-sm">Lead Name</th>
                          <th class="th-sm">Organisation Name</th>
                          <th class="th-sm">Email</th>
                          <th class="th-sm">Assigned To</th>
                          <th class="th-sm">Lead Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          <div class="card org_div" id="divOppTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="opp_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th class="th-sm">Opportunity Name</th>
                          <th class="th-sm">Organization Name</th>
                          <th class="th-sm">Email</th>
                          <th class="th-sm">Primary Phone</th>
                          <th class="th-sm">Opportunuity ID</th>
                          <th class="th-sm">Owner Name</th>
                          <th class="th-sm">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          <div class="card org_div" id="divQuotTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="quot_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="th-sm" style="width: 275px;">Subject</th>
                        <th class="th-sm" style="width: 275px;">Organization Name</th>
                        <th class="th-sm">Quote ID</th>
                        <th class="th-sm">Date</th>
                        <th class="th-sm">Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          <div class="card org_div" id="divSOTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="so_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th class="th-sm">Subject</th>
                        <th class="th-sm">Organization Name</th>
                        <th class="th-sm">Salesorder ID</th>
                        <th class="th-sm">Owner</th>
                        <th class="th-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
           <div class="card org_div" id="divPOTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="po_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Company Name</th>
                            <th class="th-sm">Customer Name</th>
                            <th class="th-sm">Vendor Name</th>
                            <th class="th-sm">Subject</th>
                            <th class="th-sm">PO Number</th>
                            <th class="th-sm">Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          <div class="card org_div" id="divTaskTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="task_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Task</th>
                            <th class="th-sm">Task Owner</th>
                            <th class="th-sm">Priority</th>
                            <th class="th-sm">Due Date</th>
							<th class="th-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          <div class="card org_div" id="divMeetTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="meet_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Meeting</th>
                            <th class="th-sm">Host By</th>
                            <th class="th-sm">Location</th>
                            <th class="th-sm">Date</th>
							<th class="th-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          <div class="card org_div" id="divCallTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="call_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Call</th>
                            <th class="th-sm">Contact Name</th>
                            <th class="th-sm">Call Purpose</th>
                            <th class="th-sm">Releted To</th>
							<th class="th-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          <div class="card org_div" id="divVendTable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="vend_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th class="th-sm">Vendor Name</th>
                          <th class="th-sm">Primary Email</th>
                          <th class="th-sm">Primary Phone</th>
                          <th class="th-sm">Created By</th>
                          <th class="th-sm">Assigned To</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          <div class="card org_div" id="divPITable" style="display:none;"> 
                <div class="row">
                <div class="col-lg-11"></div>
                <div class="col-lg-1 text-right"> <button class="btn btn-info CloseDiv">Back</button></div>
                </div>
              <div class="card-body">
                <table id="pi_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Invoice#</th>
                            <th class="th-sm">Billed To(Org Name)</th>
                            <th class="th-sm">Page Name</th>
                            <th class="th-sm">Total Amount</th>
                            <th class="th-sm">Status</th>
							<th class="th-sm">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
          </div>
          
          
          
          
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script>

$(".CloseDiv").click(function(){
    $(".org_div").hide();
    $('#putData').show();
});

		$('#date_filter').change(function(){
		    var date_filter= $('#date_filter').val();
            $.ajax({
             url: "<?= base_url();?>activities/getFiltered",
             method: "POST",
    		 data:{date_filter:date_filter},
             success: function(data)
    		 {
              $('#putData').html(data);
             }
            });  
        });
        
        $('#fromDate,#toDate').change(function(){
		    var fromDate = $('#fromDate').val();
			var toDate   = $('#toDate').val();
			if(fromDate!="" && toDate!=""){
                $.ajax({
                 url: "<?= base_url();?>activities/getFiltered",
                 method: "POST",
        		 data:{fromDate:fromDate,toDate:toDate},
                 success: function(data)
        		 {   	
                  $('#putData').html(data);
                 }
                }); 
			}
        });
      
      
   // For Organization...   
      
        var table;
        table = $('#org_datatable').DataTable({
            "processing": true, 
            "serverSide": true, 
            "order": [],
            "ajax": {
                "url": "<?= base_url('organizations/ajax_list')?>",
                "type": "POST",
                "data" : function(data)
                {
                    data.searchDate = $('#date_filter').val();
                    data.actDate = 'actdata';
                    data.fromDate = $('#fromDate').val();
				    data.toDate = $('#toDate').val();
                }
            },
            "columnDefs": [
            {
              "targets": [0], 
              "orderable": false, 
            },
            ],
        });
    function org_list()
    {
      $('#putData').hide();    
      $("#divOrgTable").show();    
      table.ajax.reload(); 
    }
    
    
     
  
  // For Getting Lead .......   
   leadtable = $('#lead_datatable').DataTable({
          "processing": true, 
          "serverSide": true, 
          "order": [], 
          "ajax": {
              "url": "<?= base_url('leads/ajax_list')?>",
              "type": "POST",
              "data" : function(data){
                 data.searchDate = $('#date_filter').val();
                 data.actDate = 'actdata';
                 data.fromDate = $('#fromDate').val();
				 data.toDate = $('#toDate').val();
              }
          },
          "columnDefs": [
          { 
              "targets": [ 0 ], 
              "orderable": false, 
          },
          ],
      });
     
	function lead_list()
    { 
      $('#putData').hide();    
      $("#divLeadTable").show();    
      leadtable.ajax.reload(); 
    }
    
    
  // For Opportunity......  
  opptable = $('#opp_datatable').DataTable({
        "processing": true,
        "serverSide": true, 
        "order": [],
        "ajax": {
            "url": "<?= base_url('opportunities/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
				data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
             }
        },
        "columnDefs": [
        {
            "targets": [ 0 ], 
            "orderable": false, 
        },
        ],
    });
  
  
  function opport_list()
    { 
      $('#putData').hide();    
      $("#divOppTable").show();    
      opptable.ajax.reload(); 
    }


// Quotation Code.......

    quottable = $('#quot_datatable').DataTable({
        "processing": true, 
        "serverSide": true, 
        "order": [], 
        "ajax": {
            "url": "<?php echo site_url('quotation/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
                 data.actDate = 'actdata';
                 data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
             }
        },
        "columnDefs": [
        {
            "targets": [ 0 ],
            "orderable": false,
        },
        ],
    });

	function quotation_list()
    {
	   $('#putData').hide();    
       $("#divQuotTable").show();    
       quottable.ajax.reload();   
    }
    
    
  // For Sales Order Code....  
  
    sotable = $('#so_datatable').DataTable({
        "processing": true, 
        "serverSide": true,
        "order": [],
        "ajax": {
          "url": "<?= base_url('salesorders/ajax_list'); ?>",
          "type": "POST",
          "data" : function(data)
           {
              data.searchDate = $('#date_filter').val();
              data.actDate = 'actdata';
              data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
           }
        },
        "columnDefs": [
        {
            "targets": [ 0 ],
            "orderable": false,
        },
        ],
    });
   
	function sales_list()
    {
	   $('#putData').hide();    
       $("#divSOTable").show();    
       sotable.ajax.reload();    
    }
    
    
   // FOr Purchase Order 
   
   potable = $('#po_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [], 
        "ajax": {
            "url": "<?php echo base_url('purchaseorders/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
                data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
             }
        },
        "columnDefs": [
        {
            "targets": [ 0 ],
            "orderable": false,
        },
        ],
    });
   
    function purchase_list()
    {
	   $('#putData').hide();    
       $("#divPOTable").show();    
       potable.ajax.reload();     
    }
    
   /*
   // For Task Get Data...
   tasktable = $('#task_datatable').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list_task')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
             }
        },
        "columnDefs": [
        {
            "targets": [ -1 ],
            "orderable": false,
        },
        ]
    });
    
	function task_list()
    {
	   $('#putData').hide();    
       $("#divTaskTable").show();    
       tasktable.ajax.reload();     
    }
    
    
    // For Meeting Code.......
    meettable = $('#meet_datatable').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
             }
        },
        "columnDefs": [
        {
            "targets": [ -1 ],
            "orderable": false,
        },
        ]
    });
    
	function meeting_list()
    {
	   $('#putData').hide();    
       $("#divMeetTable").show();    
       meettable.ajax.reload();       
    }
    
    
    
  // For Call Code....
  calltable = $('#call_datatable').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list_call')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
				data.actDate = 'actdata';
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ]
    });
  
  
	function call_list()
    {
	   $('#putData').hide();    
       $("#divCallTable").show();    
       calltable.ajax.reload();    
    }
    
    */
	// For geting Data Vendor List
	vendtable = $('#vend_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo base_url('vendors/ajax_list')?>",
            "type": "POST",
             "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
                data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
             }
        },
        "columnDefs": [
        {
            "targets": [ 0 ],
            "orderable": false,
        },
        ],
    });
	
	
	function vendors_list()
    {
	   $('#putData').hide();    
       $("#divVendTable").show();    
       vendtable.ajax.reload();    
    }
    
    
    // Get Proforma List
    
    pitable = $('#pi_datatable').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('proforma_invoice/ajax_list')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.actDate = 'actdata';
                data.fromDate = $('#fromDate').val();
				data.toDate = $('#toDate').val();
				
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ]
    });
    
	function proforma_list()
    {
	   $('#putData').hide();    
       $("#divPITable").show();    
       pitable.ajax.reload();  
    }

    function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
    
</script>
 
  