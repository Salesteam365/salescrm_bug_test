<?php $this->load->view('common_navbar');?>
<style>
   #Opp_list thead tr th,
#leadList thead tr th,
#Quotelist thead tr th,
#so_profit_table thead tr th,
#So_list thead tr th,
#Po_list thead tr th,
#profit_table_productOjx thead tr th,
#profit_table_product_wise thead tr th,
#put_data_renewal thead tr th {
   background-color: #fff;
   color: #000;
   font-size: 16px;
   border-bottom: none;
   padding-top: 18px;
   padding-bottom: 18px;
}

#Opp_list tbody tr td,
#leadList tbody tr td,
#Quotelist tbody tr td,
#so_profit_table tbody tr td,
#So_list tbody tr td,
#Po_list tbody tr td,
#profit_table_productOjx tbody tr td,
#profit_table_product_wise tbody tr td,
#put_data_renewal tbody tr td {
   background-color: #fff;
   font-size: 14px;
   font-family: system-ui;
   font-weight: 651;
   color: rgba(0,0,0,0.7);
   padding-top: 16px;
   padding-bottom: 16px;
}

#Opp_list tbody tr td:nth-child(3),
#leadList tbody tr td:nth-child(3),
#Quotelist tbody tr td:nth-child(3),
#so_profit_table tbody tr td:nth-child(3),
#So_list tbody tr td:nth-child(3),
#Po_list tbody tr td:nth-child(3),
#profit_table_productOjx tbody tr td:nth-child(3),
#profit_table_product_wise tbody tr td:nth-child(3),
#put_data_renewal tbody tr td:nth-child(3) {
   color: rgba(140, 80, 200, 1);
   font-weight: 700;
}

.quoteaccordion{
  margin:4px auto;
  border-radius:5px;
  background:rgba(197,180,227,0.1);
   border-top:none;
   border-left:5px solid purple;
   
   

}

.quoteacc_head{
  border-radius:5px;
  padding:2px;
  background:rgba(197,180,227,0.2);
  cursor:pointer;
 
  
}
.quoteaccordion1 {
        margin-bottom: 20px; /* Adjust the margin as needed */
    }
    .quoteaccordion {
         /* Adjust the margin as needed */
    }
    .quoteacc_head {
        padding: 15px; /* Adjust the padding as needed */
    }
    .quotaccbody {
        padding: 15px; /* Adjust the padding as needed */
    }

button.btnstopcorner {
    border: 1px solid #ccc; /* Light grey border on hover */
    border-radius: 4px;
    background: white;
    color: rgba(30, 0, 75);
  }

   button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; /* Light grey border on hover */
  }
  .small-box{
    background:#fff;
  }
</style>





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Report</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

      <!-- tabs -->
      <ul class="nav nav-tabs">
        <li onclick="change_nav('leads_data','lead_li');" class="nav-item" >
        <a id="lead_li" class="nav-link randmCl active" href="javascript:void(0);">Leads</a>
        </li>
          <li onclick="change_nav('Opportunity_data','opp_li');" class="nav-item" >
          <a id="opp_li" class="nav-link randmCl" href="javascript:void(0);">Opportunity</a>
        </li>
          <li onclick="change_nav('Quotation_data','quote_li');" class="nav-item">
          <a id="quote_li" class="nav-link randmCl" href="javascript:void(0);">Quotation</a>
        </li>
          <li onclick="change_nav('Salesorder_data','so_li');" class="nav-item" >
          <a id="so_li" class="nav-link randmCl" href="javascript:void(0);">SalesOrder</a>
        </li>
          <li onclick="change_nav('Purchaseorder_data','po_li');" class="nav-item" >
          <a id="po_li" class="nav-link randmCl" href="javascript:void(0);">PurchaseOrder</a>  
        </li>
          <li onclick="change_nav('Profit_table_data','prof_table');" class="nav-item" >
          <a id="prof_table" class="nav-link randmCl" href="javascript:void(0);">Profit&nbsp;Table</a>
        </li>
        <li onclick="change_nav('Profit_table_data_pro','prof_table_pro_wise');" class="nav-item" >
          <a id="prof_table_pro_wise" class="nav-link randmCl" href="javascript:void(0);">Profit form purchase Order</a>
        </li>
        <li onclick="change_nav('renewal_table','renewal_table_li');" class="nav-item" >
          <a id="renewal_table_li" class="nav-link randmCl" href="javascript:void(0);">Renewal Data</a>
        </li>
      </ul>

        <?php

        $dataArr=array("orange"," green"," pink","blue"," purple");
        ?>

  <!-- Tab panes -->
  <div class="tab-content">

  <!-- ----------------------- Start Lead customdata_1 ------------------------------------------>
    <div id="leads_data" class="container-fluid hddnCl"><br>
      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <?php 
                $i=0;
                if(!empty($leads_status)) { ?>
                <?php foreach($leads_status as $ld_st) { 
                if($i>4){
                    $i=0;
                }
                ?>
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box reportcards" style=" color:black; border-left:5px solid <?=$dataArr[$i];?>">
                          <div class="inner animate__animated animate__flipInX">
                              <h4><?= $ld_st['lead_status'];  ?></h4>

                              <h3><?= $ld_st['total_count'];?></h3>
                          
                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                      </div>
                  </div>
                
                <?php $i++; } } ?>
              </div>
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable" id="">
                    
                      <!-- Custom tabs (Charts with tabs)-->
                    <div class="quoteaccordion ">
                      <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i>  Graph</a>
                      </div>

                    <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq2">
                          <div class="card-body quotaccbody">
                                <!-- /.card-header -->
                                <div class="card-body">
                                  <div class="row mb-3">

                                  <div class="col-lg-2">
                                    <div class="first-one custom-dropdown dropdown">
                                      <b>Select By days</b>
                                      <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonlead" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Select By days
                                      </button>
                                      <input type="hidden" id="lead_date_filter" value="" name="lead_date_filter">
                                      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonlead">
                                          <li data-value="This Week">This Week</li>
                                          <?php $week = strtotime("-7 Day"); ?>
                                          <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last Week');">Last Week</li>

                                          <?php $fifteen = strtotime("-15 Day"); ?>
                                          <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 15 days');">Last 15 days</li>

                                          <?php $thirty = strtotime("-30 Day"); ?>
                                          <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 30 days');">Last 30 days</li>

                                          <?php $fortyfive = strtotime("-45 Day"); ?>
                                          <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 45 days');">Last 45 days</li>

                                          <?php $sixty = strtotime("-60 Day"); ?>
                                          <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 60 days');">Last 60 days</li>

                                          <?php $thirty = strtotime("-1 month"); ?>
                                          <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last Months');">Last Months</li>

                                          <?php $ninty = strtotime("-3 month"); ?>
                                          <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 3 Months');">Last 3 Months</li>

                                          <?php $six_month = strtotime("-6 month"); ?>
                                          <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 6 Months');">Last 6 Months</li>

                                          <?php $one_year = strtotime("-1 year"); ?>
                                          <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','change_lead_date','lead_date_filter'); setSelectedFilterlead('Last 1 Year');">Last 1 Year</li>

                                      </ul>
                                    </div>
                                  </div>

                                  <script>
                                      function setSelectedFilterlead(selectedText_lead) {
                                        document.getElementById('dropdownMenuButtonlead').innerText = selectedText_lead;
                                       }
                                  </script>

                                    
                                  <div class="col-lg-2 "><b>From:</b>
                                      <input class="custom-select" type="date" id="leads_sortFrom" name="leads_sortFrom" onchange="change_leadto_date()" />
                                  </div>
                                  <div class="col-lg-2 "><b>To:</b>
                                      <input class="custom-select" type="date" id="leads_sortTo" name="leads_sortTo" onchange="change_leadto_date()" />
                                  </div>
                                    
                                  </div>
                                  <div class="tab-content p-0">
                                      <!-- Morris chart - Sales -->
                                      <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 200px;">
                                          <canvas id="lead_graph" width="200" height="0"></canvas>
                                      </div>
                                  </div>
                                </div>
                                <!-- /.card-body -->
                          </div>
              
                  </section>
              
                  <?php if($this->session->userdata('type') == "admin") { ?>
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <!-- tables -->
                      <div class="card org_div">
                          <!-- /.card-header -->
                          <div class="card-body">
                              <form method="post" action="<?php echo base_url();?>Reports/export_lead_to_csv">
                                  <div class="row">
                                      
                                    <div class="col-lg-2">
                                      <div class="first-one custom-dropdown dropdown">
                                          <!-- <b>Select By Days</b> -->
                                          <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonleads" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Filter By Days
                                          </button>
                                          <input type="hidden" id="lead_sortBy" value="" name="lead_sortBy">
                                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonleads">
                                              <li data-value="This Week">This Week</li>
                                              <?php $week = strtotime("-7 Day"); ?>
                                              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last Week');">Last Week</li>

                                              <?php $fifteen = strtotime("-15 Day"); ?>
                                              <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 15 days');">Last 15 days</li>

                                              <?php $thirty = strtotime("-30 Day"); ?>
                                              <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 30 days');">Last 30 days</li>

                                              <?php $fortyfive = strtotime("-45 Day"); ?>
                                              <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 45 days');">Last 45 days</li>

                                              <?php $sixty = strtotime("-60 Day"); ?>
                                              <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 60 days');">Last 60 days</li>

                                              <?php $thirty = strtotime("-1 month"); ?>
                                              <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last Month');">Last Month</li>

                                              <?php $ninty = strtotime("-3 month"); ?>
                                              <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 3 months');">Last 3 Months</li>

                                              <?php $six_month = strtotime("-6 month"); ?>
                                              <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 6 Months');">Last 6 Months</li>

                                              <?php $one_year = strtotime("-1 year"); ?>
                                              <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','lead_sortBy','leadList'); setSelectedFilterleads('Last 1 Year');">Last 1 Year</li>

                                              <li class="dropdown-item" id="CustomDateLead">
                                                      <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                              </li>
                                          </ul>
                                      </div>
                                    </div>

                                    <div class="col-sm-2 form-group"><input class="form-control btn btnstopcorner btn-sm active" value="Export Lead" type="submit" id="" name="submit" /></div>

                                    <script>
                                      function setSelectedFilterleads(selectedText_leads) {
                                        document.getElementById('dropdownMenuButtonleads').innerText = selectedText_leads;
                                       }
                                    </script>

                                   <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="CustomDateLeadModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_lead" id="start_date_lead" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_lead" id="end_date_lead" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnLead">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#CustomDateLead').on('click', function() {
                                            $('#CustomDateLeadModel').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnLead').on('click', function() {
                                              var startDate = $('#start_date_lead').val();
                                              var endDate = $('#end_date_lead').val();
                                            // alert('endDate');

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'lead_sortBy','leadList');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#CustomDateLeadModel').modal('hide');
                                  
                                                  $('#start_date_lead').val('');
                                                  $('#end_date_lead').val('');
                                                  $('#lead_sortBy').val('');
                                              } else {
                                                  alert('Please select both start and end dates in Totals.');
                                              }
                                          });
                                      });
                                  </script>


                                        <!-- <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="lead_sortFrom" name="lead_sortFrom" onchange="searchLeadFilter()" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="lead_sortTo" name="lead_sortTo" onchange="searchLeadFilter()" /></div> -->
                                        <!-- <div class="col-sm-2 form-group"><input class="form-control btn btnstopcorner btn-sm active" value="Export" type="submit" id="" name="submit" /></div> -->
                                  </div>
                                  <table id="leadList" class="table table-striped table-bordered table-responsive-lg-sm" cellspacing="0" width="100%">
                                      <thead>
                                        <tr>
                                          <th>Lead Owner</th>
                                          <th class="th-sm">Total Leads</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                    
                                      </tbody>
                                  </table>
                                 
                              </form>
                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  </section>
                  <?php } ?>
                 
              </div>
             
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>





<!-- ----------------------- Start Opportunity customdata_2 ------------------------------------------>
    <div  class="container-fluid hddnCl" id="Opportunity_data" style="display:none;">
      <section class="content" >
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <?php 
                $k=0;
                if(!empty($opp_stage)) { foreach($opp_stage as $op_st) {
                if($k>4){
                    $k=0;
                }
                ?>
                  <div class="col-lg-3 col-6">
                      <!-- small box -->
                      <div class="small-box " style=" color:black; border-left:5px solid <?=$dataArr[$k];?>">
                          <div class="inner animate__animated animate__flipInX">
                              <h4><?= $op_st['stage'];  ?></h4>

                              <h3><?= $op_st['total_count'];?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                      </div>
                  </div>
                <?php $k++; } } ?>
                  <!-- ./col -->
                  
                  <!-- ./col -->
              </div>
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                     <div class="quoteaccordion ">
                        <div class="quoteacc_head" id="faqhead3" data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq3" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i>  Top Opportunities</a>
                        </div>
                        <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq3">
                          <div class="card-body quotaccbody">

                              <!-- /.card-header -->
                              <div class="card-body">
                                  <div class="row mb-3">
                                      <div class="col-lg-2">
                                        <div class="first-one custom-dropdown dropdown">
                                          <b>Select By Days</b>
                                            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonOpportunity" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select By Days
                                            </button>
                                            <input type="hidden" id="opportunity_date_filter" value="" name="opportunity_date_filter">
                                            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonOpportunity">
                                                <li data-value="This Week">This Week</li>
                                                <?php $week = strtotime("-7 Day"); ?>
                                                <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last Week');">Last Week</li>

                                                <?php $fifteen = strtotime("-15 Day"); ?>
                                                <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 15 days');">Last 15 days</li>

                                                <?php $thirty = strtotime("-30 Day"); ?>
                                                <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 30 days');">Last 30 days</li>

                                                <?php $fortyfive = strtotime("-45 Day"); ?>
                                                <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 45 days');">Last 45 days</li>

                                                <?php $sixty = strtotime("-60 Day"); ?>
                                                <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 60 days');">Last 60 days</li>

                                                <?php $thirty = strtotime("-1 month"); ?>
                                                <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last Month');">Last Month</li>

                                                <?php $ninty = strtotime("-3 month"); ?>
                                                <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 3 Months');">Last 3 Months</li>

                                                <?php $six_month = strtotime("-6 month"); ?>
                                                <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 6 Months');">Last 6 Months</li>

                                                <?php $one_year = strtotime("-1 year"); ?>
                                                <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','change_opp_date','opportunity_date_filter'); setSelectedFilterOpportunity('Last 1 year');">Last 1 Year</li>
                                            </ul>
                                        </div>
                                      </div>

                                      <script>
                                          function setSelectedFilterOpportunity(selectedText_opportunity) {
                                            document.getElementById('dropdownMenuButtonOpportunity').innerText = selectedText_opportunity;
                                          }
                                      </script>

                                        <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="opportunity_sortFrom" name="sortFroms" onchange="change_opp_filterdate()" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="opportunity_sortTo" name="sortTos" onchange="change_opp_filterdate()" /></div>
                                  </div>
                                  <div class="tab-content p-0">
                                      <!-- Morris chart - Sales -->
                                      <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 200px;">
                                          <canvas id="opp_graph" width="200" height="0"></canvas>
                                      </div>
                                  </div>
                              </div>
                              <!-- /.card-body -->
                          </div>
                  </section>
                  <!-- /.Left col -->
                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <?php if($this->session->userdata('type') == "admin") { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables -->
                        <div class="card org_div">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_opp_to_csv">
                                    <div class="row">
                                      
                                          <div class="col-lg-2">
                                            <div class="first-one custom-dropdown dropdown">
                                              <!-- <b>Select By Days</b> -->
                                              <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonOpportunitys" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter By Days
                                              </button>
                                              <input type="hidden" id="opp_sortBy" value="" name="opp_sortBy">
                                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonOpportunitys">
                                                  <li data-value="This Week">This Week</li>
                                                  <?php $week = strtotime("-7 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last Week');">Last Week</li>

                                                  <?php $fifteen = strtotime("-15 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 15 days');">Last 15 days</li>

                                                  <?php $thirty = strtotime("-30 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 30 days');">Last 30 days</li>

                                                  <?php $fortyfive = strtotime("-45 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 45 days');">Last 45 days</li>

                                                  <?php $sixty = strtotime("-60 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 60 days');">Last 60 days</li>

                                                  <?php $thirty = strtotime("-1 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last Month');">Last Month</li>

                                                  <?php $ninty = strtotime("-3 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 3 Months');">Last 3 Months</li>

                                                  <?php $six_month = strtotime("-6 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 6 Months');">Last 6 Months</li>

                                                  <?php $one_year = strtotime("-1 year"); ?>
                                                  <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','opp_sortBy','Opp_list'); setSelectedFilterOpportunitys('Last 1 year');">Last 1 Year</li>

                                                  <li class="dropdown-item" id="CustomDateOpportunity">
                                                      <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                  </li>

                                              </ul>
                                            </div>
                                          </div>

                                          <div class="col-sm-2 form-group"><input class="form-control btn btnstopcorner btn-sm active" value="Export Opportunity" type="submit" id="" name="submit" /></div>

                                          <script>
                                              function setSelectedFilterOpportunitys(selectedText_opportunitys) {
                                                document.getElementById('dropdownMenuButtonOpportunitys').innerText = selectedText_opportunitys;
                                              }
                                          </script>

                                          <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="CustomDateOpportunityModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_opportunity" id="start_date_opportunity" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_opportunity" id="end_date_opportunity" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnOpportunity">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#CustomDateOpportunity').on('click', function() {
                                            $('#CustomDateOpportunityModel').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnOpportunity').on('click', function() {
                                              var startDate = $('#start_date_opportunity').val();
                                              var endDate = $('#end_date_opportunity').val();
                                            // alert('endDate');

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'opp_sortBy','Opp_list');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#CustomDateOpportunityModel').modal('hide');
                                  
                                                  $('#start_date_opportunity').val('');
                                                  $('#end_date_opportunity').val('');
                                                  $('#opp_sortBy').val('');
                                              } else {
                                                  alert('Please select both start and end dates in Totals.');
                                              }
                                          });
                                      });
                                  </script>

                                          

                                        <!-- <div class="col-lg-2 form-group">
                                            <b>From:</b><input class="custom-select" type="date" id="opp_sortFrom" name="sortFrom" onchange="" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="opp_sortTo" name="sortTo" onchange="" /></div> -->
                                    </div>

                                    <table id="Opp_list" class="table table-striped table-bordered table-responsive-lg-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th class="th-sm">Total Opportunities</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                    
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                  <?php } ?>

                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>




<!------------------------------------Start Quotation Customdata_3 --------------------------------------------->
    <div id="Quotation_data" class="container-fluid hddnCl" style="display:none;"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                <?php 
                $k=0;
                if(!empty($quote_stage)) { foreach($quote_stage as $qt_st) {
                if($k>4){
                    $k=0;
                }
                ?>
                  <div class="col-lg-3 col-6">
                        <!-- small box -->
                    <div class="small-box "style=" color:black; border-left:5px solid <?=$dataArr[$k];?>">
                      <div class="inner animate__animated animate__flipInX">
                          <h4><?= $qt_st['quote_stage']; ?></h4>

                          <h3><?= $qt_st['total_count']; ?></h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                    </div>
                  </div>
                <?php $k++; } } ?>
              </div>
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="quoteaccordion ">
                        <div class="quoteacc_head" id="faqhead4" data-toggle="collapse" data-target="#faq4" aria-expanded="false" aria-controls="faq4" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i>  Top Quotation</a>
                        </div>
                        <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq4">
                                <div class="card-body quotaccbody">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-lg-2">
                                                

                                              <div class="first-one custom-dropdown dropdown">
                                                <b>Select By Days</b>
                                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonQuotation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Select By Days
                                                </button>
                                                <input type="hidden" id="quotation_date_filter" value="" name="quotation_date_filter">
                                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonQuotation">
                                                    <li data-value="This Week">This Week</li>
                                                    <?php $week = strtotime("-7 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last Week');">Last Week</li>

                                                    <?php $fifteen = strtotime("-15 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 15 days');">Last 15 days</li>

                                                    <?php $thirty = strtotime("-30 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 30 days');">Last 30 days</li>

                                                    <?php $fortyfive = strtotime("-45 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 45 days');">Last 45 days</li>

                                                    <?php $sixty = strtotime("-60 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 60 days');">Last 60 days</li>

                                                    <?php $thirty = strtotime("-1 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last Month');">Last Month</li>

                                                    <?php $ninty = strtotime("-3 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 3 months');">Last 3 Months</li>

                                                    <?php $six_month = strtotime("-6 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 6 Months');">Last 6 Months</li>

                                                    <?php $one_year = strtotime("-1 year"); ?>
                                                    <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','change_quote_date','quotation_date_filter'); setSelectedFilterQuotation('Last 1 Year');">Last 1 Year</li>
                                                    
                                                </ul>
                                              </div>
                                            </div>

                                            <script>
                                                  function setSelectedFilterQuotation(selectedText_quotation) {
                                                      document.getElementById('dropdownMenuButtonQuotation').innerText = selectedText_quotation;
                                                  }
                                            </script>

                                            <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="quotes_sortFrom" name="quotes_sortFrom" onchange="searchQuoteFilter();" /></div>
                                            <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="quotes_sortTo" name="lead_sortTo" onchange="searchQuoteFilter();" /></div>
                                        </div>

                                        <div class="tab-content p-0">
                                            <!-- Morris chart - Sales -->
                                          <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 200px;">
                                            <canvas id="quote_graph" width="200" height="0"></canvas>
                                          </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                  </section>
                  <!-- /.Left col -->

                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <?php if($this->session->userdata('type') == "admin") { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables -->
                        <div class="card org_div">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_quotation_to_csv">
                                    <div class="row">
                                          <!-- <div class="col-sm-3 form-group"><b>Search:</b><input class="custom-select" type="text" id="lead_keywords" name="lead_keywords" placeholder="Search..." onkeyup="" /></div> -->
                                         <div class="col-lg-2">
                                            <div class="first-one custom-dropdown dropdown">
                                              <!-- <b>Select By Days</b> -->
                                              <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonQuotations" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter By Days
                                              </button>
                                              <input type="hidden" id="quote_sortBy" value="" name="quote_sortBy">
                                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonQuotations">
                                                  <li data-value="This Week">This Week</li>
                                                  <?php $week = strtotime("-7 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last Week');">Last Week</li>

                                                  <?php $fifteen = strtotime("-15 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 15 days');">Last 15 days</li>

                                                  <?php $thirty = strtotime("-30 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 30 days');">Last 30 days</li>

                                                  <?php $fortyfive = strtotime("-45 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 45 days');">Last 45 days</li>

                                                  <?php $sixty = strtotime("-60 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 60 days');">Last 60 days</li>

                                                  <?php $thirty = strtotime("-1 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last Month');">Last Month</li>

                                                  <?php $ninty = strtotime("-3 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 3 Months');">Last 3 Months</li>

                                                  <?php $six_month = strtotime("-6 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 6 months');">Last 6 Months</li>

                                                  <?php $one_year = strtotime("-1 year"); ?>
                                                  <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','quote_sortBy','Quotelist'); setSelectedFilterQuotations('Last 1 Year');">Last 1 Year</li>

                                                  <li class="dropdown-item" id="CustomDateQuotation">
                                                      <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                  </li>
                                              </ul>
                                            </div>
                                          </div>

                                          <div class="col-sm-2 form-group"><input class="form-control btn btnstopcorner btn-sm active" value="Export Quotation" type="submit" id="" name="" onchange="" /></div>

                                          <script>
                                                  function setSelectedFilterQuotations(selectedText_quotations) {
                                                      document.getElementById('dropdownMenuButtonQuotations').innerText = selectedText_quotations;
                                                  }
                                            </script>

                                             <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="CustomDateQuotationModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_quotation" id="start_date_quotation" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_quotation" id="end_date_quotation" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnQuotation">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#CustomDateQuotation').on('click', function() {
                                            $('#CustomDateQuotationModel').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnQuotation').on('click', function() {
                                              var startDate = $('#start_date_quotation').val();
                                              var endDate = $('#end_date_quotation').val();
                                            // alert('endDate');

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'quote_sortBy','Quotelist');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#CustomDateQuotationModel').modal('hide');
                                  
                                                  $('#start_date_quotation').val('');
                                                  $('#end_date_quotation').val('');
                                                  $('#quote_sortBy').val('');
                                              } else {
                                                  alert('Please select both start and end dates in Totals.');
                                              }
                                          });
                                      });
                                  </script>

                                        <!-- <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="quote_sortFrom" name="quote_sortFrom" onchange="searchQuotationFilter();" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="lead_sortTo" name="lead_sortTo" onchange="searchQuotationFilter();" /></div> -->
                                    </div>
                                    <table id="Quotelist" class="table table-striped table-bordered table-responsive-lg-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th class="th-sm">Top Quotation</th>
                                                <th class="th-sm">Total Quote</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                  
                                        </tbody>
                                    </table>
                                  
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                  <?php } ?>

                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!------------------------------------End Quotation Customdata_3 --------------------------------------------->




<!------------------------------------Start Salesorder Customdata_4 --------------------------------------------->
    <div id="Salesorder_data" class="container-fluid hddnCl" style="display:none;"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="quoteaccordion ">
                      <div class="quoteacc_head" id="faqhead5" data-toggle="collapse" data-target="#faq5" aria-expanded="false" aria-controls="faq5" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Total Sales</a>
                      </div>

                    <div id="faq5" class="collapse" aria-labelledby="faqhead5" data-parent="#faq5">
                      <div class="card-body quotaccbody">

                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row mb-3">
                                  
                                    <div class="col-lg-2">
                                        
                                      <div class="first-one custom-dropdown dropdown">
                                            <b>Select By Days</b>
                                        <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonSales" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select By Days
                                        </button>
                                        <input type="hidden" id="so_date_filter" value="" name="so_date_filter">
                                        <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonSales">
                                            <li data-value="This Week">This Week</li>
                                            <?php $week = strtotime("-7 Day"); ?>
                                            <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last Week');">Last Week</li>

                                            <?php $fifteen = strtotime("-15 Day"); ?>
                                            <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 15 days');">Last 15 days</li>

                                            <?php $thirty = strtotime("-30 Day"); ?>
                                            <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 30 days');">Last 30 days</li>

                                            <?php $fortyfive = strtotime("-45 Day"); ?>
                                            <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 45 days');">Last 45 days</li>

                                            <?php $sixty = strtotime("-60 Day"); ?>
                                            <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 60 days');">Last 60 days</li>

                                            <?php $thirty = strtotime("-1 month"); ?>
                                            <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last month');">Last Month</li>

                                            <?php $ninty = strtotime("-3 month"); ?>
                                            <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 3 months');">Last 3 Months</li>

                                            <?php $six_month = strtotime("-6 month"); ?>
                                            <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 6 Months');">Last 6 Months</li>

                                            <?php $one_year = strtotime("-1 year"); ?>
                                            <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','change_so_date','so_date_filter'); setSelectedFilterSales('Last 2 Year');">Last 1 Year</li>
                                        </ul>
                                      </div>
                                    </div>

                                    <script>
                                          function setSelectedFilterSales(selectedText_sales) {
                                              document.getElementById('dropdownMenuButtonSales').innerText = selectedText_sales;
                                          }
                                    </script>

                                    <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="so_sortFroms" name="so_sortFroms" onchange="change_so_filterdate()" /></div>
                                    <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="so_sortsTo" name="so_sortsTo" onchange="change_so_filterdate()" /></div>
                                </div>

                                <div class="tab-content p-0">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 200px;">
                                        <canvas id="sales_graph" width="200" height="0"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                  </section>
                  <!-- /.Left col -->

                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <!-- tables -->
                      <div class="card org_div">
                        <!-- /.card-header -->
                        <div class="card-body">
                          <form method="post" action="<?=base_url('Reports/get_so_profit_table');?>">
                            <div class="row">
                                

                                <div class="col-lg-2">
                                  <div class="first-one custom-dropdown dropdown">
                  
                                  <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonSale" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter By Days
                                  </button>
                                  <input type="hidden" id="so_profit_date_filter" value="" name="so_profit_date_filter">
                                  <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonSale">
                                      <li data-value="This Week">This Week</li>
                                      <?php $week = strtotime("-7 Day"); ?>
                                      <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last Week');">Last Week</li>

                                      <?php $fifteen = strtotime("-15 Day"); ?>
                                      <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 15 days');">Last 15 days</li>

                                      <?php $thirty = strtotime("-30 Day"); ?>
                                      <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 30 days');">Last 30 days</li>

                                      <?php $fortyfive = strtotime("-45 Day"); ?>
                                      <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 45 days');">Last 45 days</li>

                                      <?php $sixty = strtotime("-60 Day"); ?>
                                      <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 60 days');">Last 60 days</li>

                                      <?php $thirty = strtotime("-1 month"); ?>
                                      <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last Manth');">Last Month</li>

                                      <?php $ninty = strtotime("-3 month"); ?>
                                      <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 3 Months');">Last 3 Months</li>

                                      <?php $six_month = strtotime("-6 month"); ?>
                                      <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 6 Months');">Last 6 Months</li>

                                      <?php $one_year = strtotime("-1 year"); ?>
                                      <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','so_profit_date_filter','so_profit_table'); setSelectedFilterSale('Last 1 Year');">Last 1 Year</li>

                                      <li class="dropdown-item" id="addnewdeliverychallanSales">
                                          <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                        </li>
                                  </ul>
                                  </div>
                                </div>

                                <script>
                                    function setSelectedFilterSale(selectedText_sale) {
                                      document.getElementById('dropdownMenuButtonSale').innerText = selectedText_sale;
                                    }
                                </script>

                                <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="linkedinvoiceformSales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_sales" id="start_date_sales" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_sales" id="end_date_sales" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnSales">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#addnewdeliverychallanSales').on('click', function() {
                                            $('#linkedinvoiceformSales').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnSales').on('click', function() {
                                              var startDate = $('#start_date_sales').val();
                                              var endDate = $('#end_date_sales').val();
                                            // alert(endDate);

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'So_profit_date_filter','so_profit_table');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#linkedinvoiceformSales').modal('hide');
                                  
                                                  $('#start_date_sales').val('');
                                                  $('#end_date_sales').val('');
                                                  $('#so_profit_date_filter').val('');
                                              } else {
                                                  alert('Please select both start and end dates.');
                                              }
                                          });
                                      });
                                  </script>




                                <?php if($this->session->userdata('type')=='admin') { ?>
                                  <div class="col-lg-2">
                                      <?php if($this->session->userdata('type')==='admin'){ ?>
                                        <div class="first-one custom-dropdown dropdown">
                                            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonSaleUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select By User
                                            </button>
                                                      <input type="hidden" id="so_user_filter" value="" name = "so_user_filter">
                                                      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonSaleUser">
                                                            <option selected  value="">Select User</option>
                                                            <?php foreach($admin as $adminDtl){ ?>
                                                              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','null','so_user_filter','so_profit_table'); setSelectedFilterSaleUser('<?=$adminDtl['admin_name'];?>');"><?=$adminDtl['admin_name'];?></li>
                                                            <?php } ?>
                                                            <?php foreach($user as $userDtl){ ?>
                                                              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','null','so_user_filter','so_profit_table'); setSelectedFilterSaleUser('<?=$userDtl['standard_name'];?>');"><?=$userDtl['standard_name'];?></li>
                                                            
                                                            <?php } ?>
                                                          
                                                            </ul>
                                      </div>
                                      <?php } ?>
                                    </div>
                                <?php } ?>

                                <script>
                                    function setSelectedFilterSaleUser(selectedText_saleUser) {
                                      document.getElementById('dropdownMenuButtonSaleUser').innerText = selectedText_saleUser;
                                    }
                                </script>
          
                                
                                <div class="col-lg-2 form-group"><input class="form-control btn btn-sm btnstopcorner active" value="Excel" type="submit" id="" name="" onchange="" /></div>
                            </div>
                          </form>
                          <table id="so_profit_table" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th class="th-sm">User</th>
                                      <th class="th-sm">Date</th>
                                      <th class="th-sm">Salesorder Id</th>
                                      <th class="th-sm">Organization Name</th>
                                      <th class="th-sm">Valid Upto</th>
                                      <th class="th-sm">Salesorder Sub Total</th>
                                      <th class="th-sm">Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  
                              </tbody>
                          </table>
                        </div>
                        <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  </section>


                  <?php if($this->session->userdata('type') == 'admin') { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables -->
                        <div class="card org_div">
                            <!-- /.card-header -->
                            <div class="card-body">
                                
                                <form method="post" action="<?php echo base_url();?>Reports/export_sales_to_csv">
                                    <div class="row">
                                        

                                        <div class="col-lg-2">
                                            <div class="first-one custom-dropdown dropdown">
                                                    <!-- <b>Select By Days</b> -->
                                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonSaleUsers" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  Filter By Days
                                                </button>
                                                <input type="hidden" id="so_sortBy" value="" name="so_sortBy">
                                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonSaleUsers">
                                                    <li data-value="This Week">This Week</li>
                                                    <?php $week = strtotime("-7 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last Week');">Last Week</li>

                                                    <?php $fifteen = strtotime("-15 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 15 Days');">Last 15 days</li>

                                                    <?php $thirty = strtotime("-30 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 30 days');">Last 30 days</li>

                                                    <?php $fortyfive = strtotime("-45 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 45 days');">Last 45 days</li>

                                                    <?php $sixty = strtotime("-60 Day"); ?>
                                                    <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 60 days');">Last 60 days</li>

                                                    <?php $thirty = strtotime("-1 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last Month');">Last Month</li>

                                                    <?php $ninty = strtotime("-3 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 3 Months');">Last 3 Months</li>

                                                    <?php $six_month = strtotime("-6 month"); ?>
                                                    <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 6 Months');">Last 6 Months</li>

                                                    <?php $one_year = strtotime("-1 year"); ?>
                                                    <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','so_sortBy','So_list'); setSelectedFilterSaleUsers('Last 1 Year');">Last 1 Year</li>

                                                    <li class="dropdown-item" id="CustomDateSaleorder">
                                                      <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                    </li>

                                                </ul>
                                              </div>
                                        </div>
                                        <div class="col-sm-2 form-group">
                                            <input class="form-control btn btnstopcorner btn-sm active" value="Export Salesorder" type="submit" id="" name="" />
                                            </div>

                                       

                                        <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="CustomDateSaleModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_total" id="start_date_total" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_total" id="end_date_total" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnTotal">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                        <!-- <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="so_sortFrom" name="so_sortFrom" onchange="" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="so_sortTo" name="so_sortTo" onchange="" /></div> -->

                                    </div>
                                    <table id="So_list" class="table table-striped table-bordered table-responsive-lg-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th class="th-sm">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    
                                        </tbody>
                                    </table>
                                   
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                  <?php } ?>

                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    
<!------------------------------------End Sales Customdata_4 ----- --------------------------------------------->



<!------------------------------------Start Report PO Customdata_5 --------------------------------------------->

    <div id="Purchaseorder_data" class="container-fluid hddnCl" style="display:none;"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="quoteaccordion ">
                          <div class="quoteacc_head" id="faqhead6" data-toggle="collapse" data-target="#faq6" aria-expanded="false" aria-controls="faq6" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Top Purchaseorder</a>
                          </div>
                          <div id="faq6" class="collapse" aria-labelledby="faqhead6" data-parent="#faq6">
                              <div class="card-body quotaccbody">

                                      <!-- /.card-header -->
                                      <div class="card-body">
                                          <div class="row mb-3">
                                              
                                              <div class="col-lg-2">
                                                    <div class="first-one custom-dropdown dropdown">
                                                          <b>Select By Days</b>
                                                          <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonDay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                              Select By Days
                                                          </button>
                                                      <input type="hidden" id="po_date_filter" value="" name="po_date_filter">
                                                      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonDay">
                                                          <li data-value="This Week">This Week</li>
                                                          <?php $week = strtotime("-7 Day"); ?>
                                                          <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last Week');">Last Week</li>

                                                          <?php $fifteen = strtotime("-15 Day"); ?>
                                                          <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last days');">Last 15 days</li>

                                                          <?php $thirty = strtotime("-30 Day"); ?>
                                                          <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 30 days');">Last 30 days</li>

                                                          <?php $fortyfive = strtotime("-45 Day"); ?>
                                                          <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 45 days');">Last 45 days</li>

                                                          <?php $sixty = strtotime("-60 Day"); ?>
                                                          <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 60 Days');">Last 60 days</li>

                                                          <?php $thirty = strtotime("-1 month"); ?>
                                                          <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last Month');">Last Month</li>

                                                          <?php $ninty = strtotime("-3 month"); ?>
                                                          <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 3 Months');">Last 3 Months</li>

                                                          <?php $six_month = strtotime("-6 month"); ?>
                                                          <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 6 Months');">Last 6 Months</li>

                                                          <?php $one_year = strtotime("-1 year"); ?>
                                                          <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','change_po_date','po_date_filter'); setSelectedFilter_day('Last 1 Year');">Last 1 Year</li>
                                                      </ul>
                                                    </div>
                                              </div>

                                              <script>
                                                  function setSelectedFilter_day(selectedText_day) {
                                                      document.getElementById('dropdownMenuButtonDay').innerText = selectedText_day;
                                                  }
                                              </script>

                                              <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="po_sortFroms" name="po_sortFroms" onchange="change_po_filterdate()" /></div>
                                              <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="po_sortsTo" name="po_sortsTo" onchange="change_po_filterdate()" /></div>
                                          </div>

                                          <div class="tab-content p-0">
                                              <!-- Morris chart - Sales -->
                                              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 200px;">
                                                  <canvas id="purchase_graph" width="200" height="0"></canvas>
                                              </div>
                                          </div>
                                      </div>
                                      <!-- /.card-body -->
                              </div>
                  </section>
                  <!-- /.Left col -->

                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <?php if($this->session->userdata('type') == "admin") { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables -->
                        <div class="card org_div">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_purchase_to_csv">
                                    <div class="row">
                                        <!-- <div class="col-sm-3 form-group"><b>Search:</b><input class="custom-select" type="text" id="lead_keywords" name="lead_keywords" placeholder="Search..." onkeyup="" /></div> -->
                                      

                                        <div class="col-lg-2">
                                            <div class="first-one custom-dropdown dropdown">
                                              <!-- <b>Select By Days</b> -->
                                              <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonDays" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Filter By Days
                                              </button>
                                              <input type="hidden" id="po_sortBy" value="" name="po_sortBy">
                                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonDays">
                                                  <li data-value="This Week">This Week</li>
                                                  <?php $week = strtotime("-7 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last Week');">Last Week</li>

                                                  <?php $fifteen = strtotime("-15 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 15 days');">Last 15 days</li>

                                                  <?php $thirty = strtotime("-30 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 30 days');">Last 30 days</li>

                                                  <?php $fortyfive = strtotime("-45 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 45 days');">Last 45 days</li>

                                                  <?php $sixty = strtotime("-60 Day"); ?>
                                                  <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 60 days');">Last 60 days</li>

                                                  <?php $thirty = strtotime("-1 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last Month');">Last Month</li>

                                                  <?php $ninty = strtotime("-3 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 3 Months');">Last 3 Months</li>

                                                  <?php $six_month = strtotime("-6 month"); ?>
                                                  <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 6 Months');">Last 6 Months</li>

                                                  <?php $one_year = strtotime("-1 year"); ?>
                                                  <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','po_sortBy','Po_list'); setSelectedFilter_days('Last 1 Year');">Last 1 Year</li>

                                                  <li class="dropdown-item" id="CustomDatePo">
                                                      <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                                  </li>

                                              </ul>
                                            </div>
                                        </div>

                                        <div class="col-sm-2 form-group"><input class="form-control btn btnstopcorner btn-sm active" value="Export PO." type="submit" id="" name="" onchange="" /></div>

                                        <script>
                                                  function setSelectedFilter_days(selectedText_days) {
                                                      document.getElementById('dropdownMenuButtonDays').innerText = selectedText_days;
                                                  }
                                              </script>

                                                 <!-- Modal Custom Date Start profit table -->
                                <div class="modal fade" id="CustomDatePoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Datepo </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_total_po" id="start_date_total_po" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_total_po" id="end_date_total_po" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnDatePo">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#CustomDatePo').on('click', function() {
                                            $('#CustomDatePoModel').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnDatePo').on('click', function() {
                                              var startDate = $('#start_date_total_po').val();
                                              var endDate = $('#end_date_total_po').val();
                                            // alert(startDate);

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'po_sortBy','Po_list');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#CustomDatePoModel').modal('hide');
                                  
                                                  $('#start_date_total_po').val('');
                                                  $('#end_date_total_po').val('');
                                                  $('#po_sortBy').val('');
                                              } else {
                                                  alert('Please select both start and end dates in Totals.');
                                              }
                                          });
                                      });
                                  </script>



                                        <!-- <div class="col-lg-2 form-group"><b>From:</b><input class="custom-select" type="date" id="po_sortFrom" name="po_sortFrom" onchange="" /></div>
                                        <div class="col-lg-2 form-group"><b>To:</b><input class="custom-select" type="date" id="po_sortTo" name="po_sortTo" onchange="" /></div> -->

                                    
                                    </div>
                                    <table id="Po_list" class="table table-striped table-bordered table-responsive-lg-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Owner</th>
                                                <th class="th-sm">Total Purchase</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                        </tbody>
                                    </table>
                                    
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                  <?php } ?>

                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
<!------------------------------------End  Report PO Customdata_5 --------------------------------------------->



    <!-- --------------------------------------- Report Profit Table Start Customdata_6---------------------------------------- -->
    <div id="Profit_table_data" class="container-fluid hddnCl" style="display:none;"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
                <div class="row" id="searchSoForm"> 
                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <div class="card org_div">
                        <!-- /.card-header -->
                        <div class="card-body">
                          <form method="post" action="">
                            <div class="row">
                                

                                <div class="col-lg-2">
                                  <div class="first-one custom-dropdown dropdown">
                          
                                    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_date" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Filter By Days
                                    </button>
                                    <input type="hidden" id="date_filter" value="" name="date_filter">
                                    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_date">
                                        <li data-value="This Week">This Week</li>

                                        <?php $week = strtotime("-7 Day"); ?>
                                        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last Week');">Last Week</li>

                                        <?php $fifteen = strtotime("-15 Day"); ?>
                                        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 15 days');">Last 15 days</li>

                                        <?php $thirty = strtotime("-30 Day"); ?>
                                        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 30 days');">Last 30 days</li>

                                        <?php $fortyfive = strtotime("-45 Day"); ?>
                                        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 45 days');">Last 45 days</li>

                                        <?php $sixty = strtotime("-60 Day"); ?>
                                        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 60 days');">Last 60 days</li>

                                        <?php $thirty = strtotime("-1 month"); ?>
                                        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last Month');">Last Month</li>

                                        <?php $ninty = strtotime("-3 month"); ?>
                                        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 3 Months');">Last 3 Months</li>

                                        <?php $six_month = strtotime("-6 month"); ?>
                                        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 6 Months');">Last 6 Months</li>

                                        <?php $one_year = strtotime("-1 year"); ?>
                                        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','date_filter','profit_table_productOjx'); setSelectedFilter('Last 1 Year');">Last 1 Year</li>

                                        <li class="dropdown-item" id="addnewdeliverychallan">
                                          <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                        </li>

                                    </ul>
                                  </div>
                                </div>

                                 

                                <script>
                                      function setSelectedFilter(selectedText_date) {
                                          document.getElementById('dropdownMenuButton_date').innerText = selectedText_date;
                                      }
                                  </script>
                                    <!-- Modal Custom Date Start profit table -->
                                    <div class="modal fade" id="linkedinvoiceform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date">From Date</label>
                                                              <input type="date" name="start_date_profit" id="start_date_profit" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date">To Date</label>
                                                              <input type="date" name="end_date_profit" id="end_date_profit" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnProfit">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->


                                     <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
                                  <script>
                                      $(document).ready(function() {

                                        $('#addnewdeliverychallan').on('click', function() {
                                            $('#linkedinvoiceform').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnProfit').on('click', function() {
                                              var startDate = $('#end_date_profit').val();
                                              var endDate = $('#end_date_profit').val();
                                            // alert(startDate);

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'Date_filter','profit_table_productOjx');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#linkedinvoiceform').modal('hide');
                                  
                                                  $('#end_date_profit').val('');
                                                  $('#end_date_profit').val('');
                                                  $('#date_filter').val('');
                                              } else {
                                                  alert('Please select both start and end dates.');
                                              }
                                          });
                                      });
                                  </script>

                                  <?php if($this->session->userdata('type')=='admin') { ?>
                                      <div class="col-lg-2">
                                        <?php if($this->session->userdata('type')==='admin'){ ?>
                                          <div class="first-one custom-dropdown dropdown">
                                            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select By User
                                            </button>
                                            <input type="hidden" id="user_filter" value="" name="user_filter">
                                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_user">
                                                
                                                  <option selected  value="">Select User</option>
                                                  <?php foreach($admin as $adminDtl){ ?>
                                                    <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','null','user_filter','profit_table_productOjx'); setSelectedUser('<?= $adminDtl['admin_name']; ?>');"><?=$adminDtl['admin_name'];?></li>
                                                  
                                                  <?php } ?>
                                                  <?php foreach($user as $userDtl){ ?>
                                                    <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','null','user_filter','profit_table_productOjx'); setSelectedUser('<?= $userDtl['standard_name']; ?>');"><?=$userDtl['standard_name'];?></li>
                                                
                                                  <?php } ?>
                                                
                                              </ul>
                                          </div>
                                        <?php } ?>
                                      </div>
                                  <?php } ?>

                                  <script>
                                      function setSelectedUser(selectedText_user) {
                                          document.getElementById('dropdownMenuButton_user').innerText = selectedText_user;
                                      }
                                  </script>


                                
                                  <div class="col-sm-2 form-group">
                                    <div class="first-one custom-dropdown dropdown">
                                        <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_year" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select By Year
                                        </button>
                                            <input type="hidden"  name="year_so_filter" id="year_so_filter">
                                            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_year">
                                            
                                                <?php 
                                                for($y=date("Y")-5; $y<=date("Y"); $y++){ ?>

                                                  <li onclick="getfilterdData('<?= $y; ?>','null','year_so_filter','profit_table_productOjx'); setSelectedYear('<?= $y; ?>');">
                                                      <?= $y; ?></li>
                                                <?php } ?>

                                            </ul>
                                    </div>
                                  </div>
                                  <script>
                                      function setSelectedYear(selectedText_year) {
                                          document.getElementById('dropdownMenuButton_year').innerText = selectedText_year;
                                      }
                                  </script>




                                  <div class="col-sm-2 form-group">
                                    <div class="first-one custom-dropdown dropdown">
                                      <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_month" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Select By Month
                                      </button>
                                      <input type="hidden" id="month_so_filter" value="" name="month_so_filter">
                                      <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_month">
                                                          
                                          <?php for ($m=1; $m<=12; $m++) {
                                          $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                          $month2 = date('m', mktime(0,0,0,$m, 1, date('Y')));
                                          ?>
                                                            
                                        <li onclick="getfilterdData('<?= $month2; ?>','null','month_so_filter','profit_table_productOjx'); setSelectedMonth('<?= $month; ?>');">
                                                      <?= $month; ?></li>
                                          <?php } ?>
                                      </ul> 
                                    </div>
                                  </div>
                                  <script>
                                      function setSelectedMonth(selectedText_month) {
                                          document.getElementById('dropdownMenuButton_month').innerText = selectedText_month;
                                      }
                                  </script>


                                    <div class="col-sm-2 form-group">
                                      <div class="first-one custom-dropdown dropdown">
                                          <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_org" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Select By Customer
                                          </button>
                                              <input type="hidden" name="so_org_filter" id="so_org_filter">
                                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_org" style="height:300px;overflow:auto;width:300px;">  
                                                <?php foreach ($organization as $org) { ?>

                                                <li onclick="getfilterdData('<?= $org['org_name']; ?>','null','so_org_filter','profit_table_productOjx'); setSelectedOrg('<?= $org['org_name']; ?>');">
                                                          <?= $org['org_name']; ?>
                                                </li>

                                                <?php } ?>
                                            </ul>
                                                  
                                      </div>
                                    </div>
                                    <script>
                                      function setSelectedOrg(selectedText_org) {
                                          document.getElementById('dropdownMenuButton_org').innerText = selectedText_org;
                                      }
                                  </script>

                            </div>

                          </form>

                          <table id="profit_table_productOjx" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th class="th-sm">User Name</th>
                                      <th class="th-sm">Salesorder Id</th>
                                      <th class="th-sm">Organization Name</th>
                                      <th class="th-sm">Subject </th>
                                      <th class="th-sm">SO Sub Total</th>
                                      <!--<th class="th-sm">Purchaseorder Sub Total</th>-->
                                      <th class="th-sm">ORC</th>
                                      <th class="th-sm"> So Date </th>
                                      <th class="th-sm">Profit</th>
                                  </tr>
                              </thead>
                              <tbody>
                                                  
                              </tbody>
                          </table>


                          <div  class="col-sm-5">
                            <label></label><text id="totalProfit"></text>
                             <!--<label>Total Actual Profit : </label><text id="acttotalprft_so"></text>-->
                          </div>
                        </div>
                      </div>
                    </section>

                  <!-- right col -->
                </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  <!-- -------------------------------------- End Profit Table  Customdata_6-------------------------------------------------------->






<!-------------------------------------------------PROFIT TABLE PRODUCT WISE Customdata_7------------------------------------------------>

    <div id="Profit_table_data_pro" class="container-fluid hddnCl" style="display:none;"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row"> 
                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body" id="searchForm">
                <form method="post" action="">
                  <div class="row">
                      

                       <div class="col-lg-2">
                            <div class="first-one custom-dropdown dropdown">
                            
                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_date_po" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Filter By Days
                                </button>
                                <input type="hidden" id="date_filter_product_wise" value="" name="date_filter_product_wise">
                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_date_po">
                                    <li data-value="This Week">This Week</li>
                                    <?php $week = strtotime("-7 Day"); ?>
                                    <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last Week');">Last Week</li>

                                    <?php $fifteen = strtotime("-15 Day"); ?>
                                    <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 15 days');">Last 15 days</li>

                                    <?php $thirty = strtotime("-30 Day"); ?>
                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 30 daty');">Last 30 days</li>

                                    <?php $fortyfive = strtotime("-45 Day"); ?>
                                    <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 45 days');">Last 45 days</li>

                                    <?php $sixty = strtotime("-60 Day"); ?>
                                    <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 60 days');">Last 60 days</li>

                                    <?php $thirty = strtotime("-1 month"); ?>
                                    <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last Month');">Last Month</li>

                                    <?php $ninty = strtotime("-3 month"); ?>
                                    <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 3 Months');">Last 3 Months</li>

                                    <?php $six_month = strtotime("-6 month"); ?>
                                    <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 6 Months');">Last 6 Months</li>

                                    <?php $one_year = strtotime("-1 year"); ?>
                                    <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','null','date_filter_product_wise','profit_table_product_wise'); setSelectedFilterPo('Last 1 Year');">Last 1 Year</li>
                                    
                                    <li class="dropdown-item" id="addnewdeliverychallanPo">
                                        <a style="color:#212529; padding-left:0px; font:14px ui-sans-serif, system-ui;" href="javascript:void(0);">Custom By Date</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                      
                    
                        <script>
                          function setSelectedFilterPo(selectedText_date_po) {
                              document.getElementById('dropdownMenuButton_date_po').innerText = selectedText_date_po;
                              }
                        </script>
                        <!-- Modal Custom Date Start profit table -->
                        <div class="modal fade" id="linkedinvoiceformPo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Custom Date</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form id="deliveryForm">
                                                      <div class="form-row">
                                                          <!-- From Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="start_date_po">From Date</label>
                                                              <input type="date" name="start_date_po" id="start_date_po" class="form-control" placeholder="Start Date">
                                                          </div>
                                                          <!-- End Date Column -->
                                                          <div class="form-group col-md-6">
                                                              <label for="end_date_po">To Date</label>
                                                              <input type="date" name="end_date_po" id="end_date_po" class="form-control" placeholder="End Date">
                                                          </div>
                                                      </div>
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                  <button type="button" class="btn btn-primary" id="applyFilterBtnpo">Submit</button>
                                              </div>
                                          </div>
                                      </div>
                                    </div>
                                    <!-- Modal Custom Date End -->
                                  

                                  <script>
                                    $(document).ready(function() {
                                        $('#addnewdeliverychallanPo').on('click', function() {
                                            $('#linkedinvoiceformPo').modal('show');  // Show the modal
                                        });

                                        $('#applyFilterBtnpo').on('click', function() {
                                            var startDate = $('#start_date_po').val();
                                            var endDate = $('#end_date_po').val();
                                            // alert('Start Date: ' + startDate + ', End Date: ' + endDate);

                                            if (startDate && endDate) {
                                              
                                                getfilterdData(startDate, endDate, 'null', 'profit_table_product_wise');
                                                $('#linkedinvoiceformPo').modal('hide');

                                                // Reset the input fields
                                                $('#start_date_po').val('');
                                                $('#end_date_po').val('');
                                                $('#date_filter_product_wise').val('');
                                            } else {
                                                alert('Please select both start and end dates.');
                                            }
                                        });
                                    });
                                </script>


                                 

                        <?php if($this->session->userdata('type')=='admin') { ?>
                        <div class="col-lg-2">
                            <?php if($this->session->userdata('type')==='admin'){ ?>
                              <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_user_po" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select By User
                                </button>
                                          <input type="hidden" id="user_filter_product_wise" value="" name="user_filter_product_wise">
                                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_user_po">
                                                <option selected  value="">Select By User</option>
                                                <?php foreach($admin as $adminDtl){ ?>
                                                  <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','null','user_filter_product_wise','profit_table_product_wise'); setSelectedFilterPouser('<?=$adminDtl['admin_name'];?>');"> <?=$adminDtl['admin_name'];?> </li>
                                                <?php } ?>
                                                <?php foreach($user as $userDtl){ ?>
                                                  <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','null','user_filter_product_wise','profit_table_product_wise'); setSelectedFilterPouser('<?=$userDtl['standard_name'];?>');"><?=$userDtl['standard_name'];?></li>
                                                <?php } ?>
                                                </ul>
                            </div>
                            <?php } ?>
                          </div>

                          <script>
                          function setSelectedFilterPouser(selectedText_user_po) {
                              document.getElementById('dropdownMenuButton_user_po').innerText = selectedText_user_po;
                              }
                        </script>


                          <div class="col-sm-2 form-group">
                            <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_year_po" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select By Year
                                </button>
                                            <input type="hidden"  name="year_act_filter" id="year_act_filter">
                                            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_year_po">
                                            
                                            <?php 
                                            for($y=date("Y")-5; $y<=date("Y"); $y++){ ?>

                                              <li onclick="getfilterdData('<?= $y; ?>','null','year_act_filter','profit_table_product_wise'); setSelectedFilterPoYear('<?= $y; ?>');">
                                                        <?= $y; ?></li>
                                            <?php } ?>

                                            </ul>
                              </div>
                          </div>

                          <script>
                          function setSelectedFilterPoYear(selectedText_year_po) {
                              document.getElementById('dropdownMenuButton_year_po').innerText = selectedText_year_po;
                              }
                        </script>


                          <div class="col-sm-2 form-group">
                              <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton_month_po" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select By month
                                </button>
                                        <input type="hidden" id="month_act_filter" value="" name="month_act_filter">
                                        <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton_month_po">
                                                            
                                            <?php for ($m=1; $m<=12; $m++) {
                                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                            $month2 = date('m', mktime(0,0,0,$m, 1, date('Y')));
                                            ?>
                                                              
                                          <li onclick="getfilterdData('<?= $month2; ?>','null','month_act_filter','profit_table_product_wise'); setSelectedFilterPoMonth('<?= $month; ?>');">
                                                        <?= $month; ?></li>
                                            <?php } ?>
                                              </ul>
                              </div>
                          </div>

                          <script>
                          function setSelectedFilterPoMonth(selectedText_month_po) {
                              document.getElementById('dropdownMenuButton_month_po').innerText = selectedText_month_po;
                              }
                        </script>
                      <?php } ?>
                  </div>


                </form>
                <table id="profit_table_product_wise" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">User Name</th>
                            <th class="th-sm">Salesorder Id</th>
                            <th class="th-sm">Purchaseorder Id</th>
                            <th class="th-sm">Subject </th>
                            <th class="th-sm">Total Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                                       
                    </tbody>
                </table>
				<div  class="col-sm-5">
					<label>Total Actual Profit : </label><text id="acttotalprft"></text>
				</div>
              </div>
              <!-- /.card-body -->
            </div>
                      <!-- /.card -->
                  </section>

                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    
<!-------------------------------------------------End PROFIT TABLE PRODUCT WISE- Customdata_7----------------------------------------------->
	

	<!-- ------------------------------------ Start Code Renewal Data Customdata_8 --------------------------------------------------------->
	<div id="renewal_table" class="container-fluid hddnCl" style="display:none;"><br>
		<section class="content">
			<div class="container-fluid">
				<div class="row"> 
					<section class="col-lg-12 connectedSortable">
						<div class="card org_div">
							<div class="card-body" id="searchFormRenewal">
								<form method="post" action="">
									<div class="row">

                        <div class="col-lg-2">
                          <?php if($this->session->userdata('type')==='admin'){ ?>
                            <div class="first-one custom-dropdown dropdown">
                              <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonRenewalUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Select By User
                              </button>
                              <input type="hidden" id="user_filter_renewal" value="" name="user_filter_renewal">
                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonRenewalUser">
                                    <option selected  value="">Select By User</option>
                                    <?php foreach($admin as $adminDtl){ ?>
                                      <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','null','user_filter_renewal','put_data_renewal'); setSelectedFilterRenewalUser('<?=$adminDtl['admin_name'];?>');"><?=$adminDtl['admin_name'];?></li>
                                    <?php } ?>
                                    <?php foreach($user as $userDtl){ ?>
                                      <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','null','user_filter_renewal','put_data_renewal'); setSelectedFilterRenewalUser('<?=$userDtl['standard_name'];?>');"><?=$userDtl['standard_name'];?></li>
                                    <?php } ?>
                              </ul>
                          </div>

										    </div>
										<?php } ?>

                    <script>
                          function setSelectedFilterRenewalUser(selectedText_renewal_user) {
                              document.getElementById('dropdownMenuButtonRenewalUser').innerText = selectedText_renewal_user;
                              }
                    </script>


                    <div class="col-sm-2 form-group">
                          <div class="first-one custom-dropdown dropdown">
                                      <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonRenewalYear" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Select By Year
                                      </button>
                              <input type="hidden"  name="year_filter_renewal" id="year_filter_renewal">
                              <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonRenewalYear">
                              
                              <?php 
                              for($y=date("Y")-5; $y<=date("Y"); $y++){ ?>

                                <li onclick="getfilterdData('<?= $y; ?>','null','year_filter_renewal','put_data_renewal'); setSelectedFilterRenewalYear(' <?= $y; ?>');">
                                          <?= $y; ?></li>
                              <?php } ?>

                              </ul>
                         </div>
                    </div>

                    <script>
                          function setSelectedFilterRenewalYear(selectedText_renewal_year) {
                              document.getElementById('dropdownMenuButtonRenewalYear').innerText = selectedText_renewal_year;
                              }
                    </script>


                      <div class="col-sm-2 form-group">
                        <div class="first-one custom-dropdown dropdown">
                            <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButtonRenewalMonth" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select By Month
                            </button>
                            <input type="hidden" id="month_filter_renewal" value="" name="month_filter_renewal">
                            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtonRenewalMonth">
                                                
                                <?php for ($m=1; $m<=12; $m++) {
                                $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                $month2 = date('m', mktime(0,0,0,$m, 1, date('Y')));
                                ?>
                                                  
                              <li onclick="getfilterdData('<?= $month2; ?>','null','month_filter_renewal','put_data_renewal'); setSelectedFilterRenewalMonth('<?= $month; ?>');">
                                            <?= $month; ?></li>
                                <?php } ?>
                            </ul>	
                        </div>
                      </div>
                      <script>
                          function setSelectedFilterRenewalMonth(selectedText_renewal_month) {
                              document.getElementById('dropdownMenuButtonRenewalMonth').innerText = selectedText_renewal_month;
                              }
                    </script>


				
										
										<div class="col-sm-2 form-group">
											<input type="date" class="custom-select" id="date_from_renewal" name="date_from_renewal" placeholder="Select from date">
										</div>
										<!-- <div class="col-sm-2 form-group">
											<input type="text" onfocus="(this.type='date')" class="custom-select" id="date_to_renewal" name="date_to_renewal" placeholder="Select to date">
										</div> -->

                    <div class="col-sm-2 form-group">
											<input type="date" class="custom-select" id="date_to_renewal" name="date_to_renewal" placeholder="Select to date">
										</div>
										 
									  
									</div>
								</form>
								<table id="put_data_renewal" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th class="th-sm">Renewal Owner</th>
											<th class="th-sm">Customer Name</th>
											<th class="th-sm">Product Name</th>
											<th class="th-sm">Salesorder Id</th>
											<th class="th-sm">SO Date</th>
											<th class="th-sm">Renewal Date</th>
											<th class="th-sm">Sub Total</th>
										</tr>
									</thead>
									<tbody>
													   
									</tbody>
								</table>
								<div  class="col-sm-5">
									<label class="text-success"><b>Total Renewal Value : <text id="renewalValue"></text></b></label>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</section>
    </div>
	



  </div>
    <!-- tabs -->

  </div>
  <!-- /.content-wrapper -->
 <?php $this->load->view('footer');?>
</div>
<!-- ./wrapper -->















<!-- common footer include -->
<?php $this->load->view('common_footer');?>

 <!-- -------jQuery Script to trigger modal custom profit -------->
                                  
    <script>
                                      $(document).ready(function() {

                                        $('#CustomDateSaleorder').on('click', function() {
                                            $('#CustomDateSaleModel').modal('show');
                                        });
                                          // Trigger the filter action on 'Apply Filter' button click
                                          $('#applyFilterBtnTotal').on('click', function() {
                                              var startDate = $('#start_date_total').val();
                                              var endDate = $('#end_date_total').val();
                                            // alert('endDate');

                                              // Ensure both start and end dates are selected
                                              if (startDate && endDate) {
                                                  getfilterdData(startDate, endDate,'so_sortBy','So_list');
                                                
                                                  // Close the modal after applying the filter
                                                  $('#CustomDateSaleModel').modal('hide');
                                  
                                                  $('#start_date_total').val('');
                                                  $('#end_date_total').val('');
                                                  $('#so_sortBy').val('');
                                              } else {
                                                  alert('Please select both start and end dates in Totals.');
                                              }
                                          });
                                      });
                                  </script>
 <script>
    function setSelectedFilterSaleUsers(selectedText_saleUsers) {
       document.getElementById('dropdownMenuButtonSaleUsers').innerText = selectedText_saleUsers;
      }
    </script>

<!-- ----------------------- Start OPPortunity customdata_1 ------------------------------------------>

<?php if($this->session->userdata('type') == 'admin') { ?>
  <script>
    $(document).ready(function () {
      var table;
      table = $('#leadList').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.
          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "<?= base_url('Reports/get_lead_for_record ')?>",
              "type": "POST",
              "data" : function(data)
              {
                  data.sortdate = $('#lead_sortBy').val(); 

                  data.startDate = $('#start_date_lead').val(); 
                  data.endDate = $('#end_date_lead').val();
              }
          },
          //Set column definition initialisation properties.
          "columnDefs": [
          {
            "targets": [0], //last column
            "orderable": false, //set not orderable
          },
          ],
      });
      $('#lead_sortBy').change(function(){
        table.ajax.reload();
      });
     
    });

  </script>
<?php } ?>

<!-- ----------------------- Start OPPortunity customdata_2 ------------------------------------------>
<?php if($this->session->userdata('type') == 'admin') { ?>
  <script>
    $(document).ready(function () {
      var table;
      table = $('#Opp_list').DataTable({
          "processing": true, //Feature control the processing indicator.
          "serverSide": true, //Feature control DataTables' server-side processing mode.
          "order": [], //Initial no order.
          // Load data for the table's content from an Ajax source
          "ajax": {
              "url": "<?= base_url('Reports/get_opportunity_for_record ')?>",
              "type": "POST",
              "data" : function(data)
              {
                  data.sortdate = $('#opp_sortBy').val();

                  data.startDate = $('#start_date_opportunity').val(); 
                  data.endDate = $('#end_date_opportunity').val();
              }
          },
          //Set column definition initialisation properties.
          "columnDefs": [
          {
            "targets": [0], //last column
            "orderable": false, //set not orderable
          },
          ],
      });
      $('#opp_sortBy').change(function(){
        table.ajax.reload();
      });
    });
  </script>
<?php } ?>


<!-- ----------------------- Start Quotation customdata_3 ------------------------------------------> 
<?php if($this->session->userdata('type') == 'admin') { ?>
  <script>
    $(document).ready(function () {
      var table;
      table = $('#Quotelist').DataTable({
          "processing": true, 
          "serverSide": true, 
          "order": [], 
          
          "ajax": {
              "url": "<?= base_url('Reports/get_quotation_for_record')?>",
              "type": "POST",
              "data" : function(data)
              {
                  data.sortdate = $('#quote_sortBy').val();
                  
                  data.startDate = $('#start_date_quotation').val(); 
                  data.endDate = $('#end_date_quotation').val();
                  
                 

              }
          },
          //Set column definition initialisation properties.
          "columnDefs": [
          {
            "targets": [-1], //last column
            "orderable": false, //set not orderable
          },
          ],
      });
      $('#quote_sortBy').change(function(){
        table.ajax.reload();
      });
    });
  </script>
<?php } ?>

<!-- ----------------------- Start Sales customdata_4 ------------------------------------------>
  <script>
    $(document).ready(function () {
      <?php if($this->session->userdata('type') == 'admin') { ?>
        var table;
        table = $('#So_list').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= base_url('Reports/get_salesorder_for_record ')?>",
                "type": "POST",
                "data" : function(data)
                {
                    data.startDate = $('#start_date_total').val(); 
                    data.endDate = $('#end_date_total').val();
                     
                    data.sortdate = $('#so_sortBy').val(); 
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
              "targets": [0], //last column
              "orderable": false, //set not orderable
            },
            ],
        });
        $('#so_sortBy').change(function(){
          table.ajax.reload();
        });
      <?php } ?>
   
      // Salesorder datatables
      So_table = $('#so_profit_table').DataTable({
          "processing": true, 
          "serverSide": true, 
          "order": [], 
         
          "ajax": {
              "url": "<?php echo site_url('Reports/get_so_profit_table')?>",
              "type": "POST",
              "data" : function(data)
              {
                data.startDate = $('#start_date_sales').val();
                data.endDate = $('#end_date_sales').val();

                data.searchDate = $('#so_profit_date_filter').val();
                data.searchUser = $('#so_user_filter').val();
              }
          },
        
          "columnDefs": [
          {
              "targets": [-1], 
              "orderable": false, 
          },
          ],
          dom: 'Bfrtip',
          lengthChange: false,
          // buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
          buttons: [ 'excel']
      });

      $('#so_profit_date_filter').change(function(){
        So_table.ajax.reload();
      });

      $('#so_user_filter').change(function(){
        So_table.ajax.reload();
      });
    });
  </script>

  <!-- --------------------------------------Start PO customdata_5 --------------------------------------------->

  <?php if($this->session->userdata('type') == 'admin') { ?>
    <script>
      $(document).ready(function () {
        var table;
        table = $('#Po_list').DataTable({
            "processing": true, 
            "serverSide": true, 
            "order": [], 
          
            "ajax": {
                "url": "<?= base_url('Reports/get_purchaseorder_for_record')?>",
                "type": "POST",
                "data" : function(data)
                {
                    
                    data.startDate = $('#start_date_total_po').val();
                    data.endDate = $('#end_date_total_po').val();

                    data.sortdate = $('#po_sortBy').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
              "targets": [-1], //last column
              "orderable": false, //set not orderable
            },
            ],
        });
        $('#po_sortBy').change(function(){
          table.ajax.reload();
        });
      });
    </script>
  <?php } ?>



  <!-- ----------------------- customdata_6 ------------------------------------------>

  <?php if($this->session->userdata('type') == 'admin') { ?>
    <script>
    var tableTBL;
    $(document).ready(function() {
    //   tableTBL = $('#profit_table_productOjx').DataTable({
    //       "processing": true, 
    //       "serverSide": true, 
    //       "order": [], 
    //       "ajax": {
    //           "url": "<?php echo site_url('Home/get_profit_table')?>",
    //           "type": "POST",
    //           "data" : function(data)
    //           {

    //             data.startDate = $('#start_date_profit').val();
    //             data.endDate = $('#end_date_profit').val();

    //              data.searchDate = $('#date_filter').val();
    //             data.searchUser = $('#user_filter').val();
    //             data.searchYear = $('#year_so_filter').val();
    //             data.searchMonth = $('#month_so_filter').val();
    //             data.search_data = $('#so_org_filter').val();

    //         // Add the custom date filters to the data object
          
    //             console.log(data); // Debugging line
    //           }
    //       },
    //       //Set column definition initialisation properties.
    //       "columnDefs": [
    //       {
    //           "targets": [-1], //last column
    //           "orderable": false, //set not orderable
    //       },
    //       ],
    //   });
    
     tableTBL = $('#profit_table_productOjx').DataTable({
          "processing": true, 
          "serverSide": true, 
          "order": [], 
          "ajax": {
              "url": "<?php echo site_url('Home/get_profit_table')?>",
              "type": "POST",
              "data" : function(data)
               {
                  data.searchDate = $('#date_filter').val();
                  data.searchUser = $('#user_filter').val();
                  data.searchYear = $('#year_so_filter').val();
                  data.searchMonth = $('#month_so_filter').val();
                  data.search_data = $('#so_org_filter').val();
               },
               "dataSrc": function(json) {

                // $('#totalProfit').text("Total Actual Profit : " + json.totalProfit);
                var totalProfitFormatted = formatCurrency(json.totalProfit);
                $('#totalProfit').text("Total Actual Profit : " + totalProfitFormatted);
                  return json.data; 
              }
          },
          //Set column definition initialisation properties.
          "columnDefs": [
          {
              "targets": [-1], //last column
              "orderable": false, //set not orderable
          },
          ],
      });
      
      

      $('#date_filter, #year_so_filter, #so_org_filter, #month_so_filter').change(function(){
        tableTBL.ajax.reload();
		    Act_profitAll_count();
      });
      
      $('#user_filter').change(function(){
        tableTBL.ajax.reload();
		    Act_profitAll_count();
      });
      
      function formatCurrency(amount) {
          var number = parseFloat(amount).toFixed(2); 
          var parts = number.split("."); 
          var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
          var decimalPart = parts[1];
          return "₹" + integerPart + "." + decimalPart;
      }
	  
	  
    function Act_profitAll_count(){
      var searchDate 	= $('#date_filter').val();
      var searchUser 	= $('#user_filter').val();
      var search 		= $('#so_org_filter').val();
      var searchYear  = $('#year_so_filter').val();
      var searchMonth = $('#month_so_filter').val();
      var vardataVl	=$("#date_filter option:selected").text();
      var userName	=$("#user_filter option:selected").text();
        // console.log(search);
        if(userName=='Select User'){
          var dataDisp='';
        }else{
          var dataDisp= "&nbsp;of <b>"+userName+"</b>,&nbsp;";
        }
        $.ajax({
        url: "<?php echo site_url('Home/get_profitTable_all_User_so')?>",
        method:"post",
        data:"searchDate="+searchDate+"&searchUser="+searchUser+"&searchYear="+searchYear+"&searchMonth="+searchMonth+'&search_data='+search,
        success: function(result){
            console.log(result);
        if(result!=""){
          const toCurrency = (number, currency, lang = undefined) => 
          Intl.NumberFormat(lang, { style : 'currency', currency }).format(number);
          const price =  toCurrency(result, 'INR', 'en-in');
          result=price
          if(vardataVl=='Select Date'){ 
          $('#acttotalprft_so').html(dataDisp+"&nbsp;:&nbsp;" +result);
          }else{
          $('#acttotalprft_so').html( dataDisp+"&nbsp;&nbsp;<i>"+vardataVl + "</i>&nbsp;:&nbsp;" +result);
          }
        }else{
          $('#acttotalprft_so').html("&nbsp;&nbsp;00.0");
        }
        }
        });
    }
	  
	   Act_profitAll_count();
	  
    });
  </script>
<?php } ?>


<!---------------------------------Start CustomData_7 ------------------------------------------------->
 <?php if($this->session->userdata('type') == 'admin') { ?>
    <script>
    var table_product_wise;
    $(document).ready(function() {
      //datatables
      table_product_wise = $('#profit_table_product_wise').DataTable({
          "processing": true, 
          "serverSide": true, 
          "order": [], 
          "ajax": {
              "url": "<?php echo site_url('Home/get_profit_table_product_wise')?>",
              "type": "POST",
              "data" : function(data)
               {
				 
                  data.startDate = $('#start_date_po').val();
                  data.endDate = $('#end_date_po').val();

                  data.searchDate = $('#date_filter_product_wise').val();
                  data.searchUser = $('#user_filter_product_wise').val();
				          data.yearDate   = $('#year_act_filter').val();
                  data.monthDate  = $('#month_act_filter').val();
                  console.log(data);
               }

          },
          "columnDefs": [
          {
              "targets": [-1], 
              "orderable": false, 
          },
          ]
      });

      $('#date_filter_product_wise').change(function(){
        table_product_wise.ajax.reload();
		    Act_profitAll();
      });

      $('#user_filter_product_wise').change(function(){
        table_product_wise.ajax.reload();
		    Act_profitAll();
      });

      $('#month_act_filter').change(function(){
      table_product_wise.ajax.reload();
      Act_profitAll();
      });
	  
      $('#searchForm input').keyup(function(){
        Act_profitAll();
        });
	  
	  
	/*########count profit###########
	#								#
	###############################*/
	 
    function Act_profitAll(){
      var searchDate 	= $('#date_filter_product_wise').val();
      var searchUser 	= $('#user_filter_product_wise').val();
      var search 		= $('#searchForm input').val();
      var year_act_filter  = $('#year_act_filter').val();
      var month_act_filter = $('#month_act_filter').val();
      var vardataVl	=$("#date_filter_product_wise option:selected").text();
      var userName	=$("#user_filter_product_wise option:selected").text();
        
        
        if(userName=='Select User'){
          var dataDisp='';
        }else{
          var dataDisp= "&nbsp;of <b>"+userName+"</b>,&nbsp;";
        }
        $.ajax({
        url: "<?php echo site_url('Home/get_act_profit_table_all_User')?>",
        method:"post",
        data:"searchDate="+searchDate+"&searchUser="+searchUser+"&yearDate="+year_act_filter+"&monthDate="+month_act_filter+'&search_data='+search,
        success: function(result){
            console.log(result);
        if(result!=""){
          const toCurrency = (number, currency, lang = undefined) => 
          Intl.NumberFormat(lang, { style : 'currency', currency }).format(number);
          const price =  toCurrency(result, 'INR', 'en-in');
          result=price
          if(vardataVl=='Select Date'){ 
          $('#acttotalprft').html(dataDisp+"&nbsp;:&nbsp;" +result);
          }else{
          $('#acttotalprft').html( dataDisp+"&nbsp;&nbsp;<i>"+vardataVl + "</i>&nbsp;:&nbsp;" +result);
          }
        }else{
          $('#acttotalprft').html("&nbsp;&nbsp;00.0");
        }
        }
        });
    }
	  
	  
	  Act_profitAll();
	  
	
    });
  </script>
<?php } ?>


<!-- ---------------------------- Start renewal Customdata_8 ------------------------------->
<?php if($this->session->userdata('type') == 'admin') { ?>
    <script>
      var table_for_renewal;
      $(document).ready(function() {
        table_for_renewal = $('#put_data_renewal').DataTable({
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            "ajax": {
                "url": "<?php echo site_url('reports/get_renewal_data')?>",
                "type": "POST",
                "data" : function(data)
                {
                    data.searchFromDate = $('#date_from_renewal').val();
                    data.searchToDate   = $('#date_to_renewal').val();

                    data.searchUser = $('#user_filter_renewal').val();
                    data.yearDate   = $('#year_filter_renewal').val();
                    data.monthDate  = $('#month_filter_renewal').val();
                }
            },
            "columnDefs": [
            {
                "targets": [-1], 
                "orderable": false, 
            },
            ]
      });
      
		$('#date_from_renewal,#date_to_renewal').change(function(){
			table_for_renewal.ajax.reload();
			renewal_sub_totals();
		});
		$('#user_filter_renewal').change(function(){
			table_for_renewal.ajax.reload();
			renewal_sub_totals();
		});
		$('#year_filter_renewal,#month_filter_renewal').change(function(){
			table_for_renewal.ajax.reload();
			renewal_sub_totals();
		});
	  
		$('#put_data_renewal_filter input').keyup(function(){
			renewal_sub_totals();
		});
	  
	  
      /*########count profit###########
      #								#
      ###############################*/
	 
    function renewal_sub_totals(){
      var searchFormDate 	= $('#date_from_renewal').val();
      var searchToDate 	= $('#date_to_renewal').val();
      var searchUser 	= $('#user_filter_renewal').val();
      var search 		= $('#put_data_renewal_filter input').val();
      var year_act_filter  = $('#year_filter_renewal').val();
      var month_act_filter = $('#month_filter_renewal').val();
        $.ajax({
        url		: "<?php echo site_url('reports/get_sub_totals_renewal')?>",
        method	: "post",
        data	: "searchFormDate="+searchFormDate+"&searchToDate="+searchToDate+"&searchUser="+searchUser+"&yearDate="+year_act_filter+"&monthDate="+month_act_filter+'&search_data='+search,
        success : function(result){
          console.log(result);
        if(result!=""){
          const toCurrency = (number, currency, lang = undefined) => 
          Intl.NumberFormat(lang, { style : 'currency', currency }).format(number);
          const price =  toCurrency(result, 'INR', 'en-in');
          result=price
          $('#renewalValue').html("&nbsp;" +result);
          
        }else{
          $('#renewalValue').html("&nbsp;&nbsp;00.0");
        }
        }
        });
    }
	  
	  
	  renewal_sub_totals();
	  
	
    });
  </script>
<?php } ?>


<script>
  $(document).ready(function () {
    $('#ajax_datatable').dataTable({

      columnDefs: [{
        orderable: false,
        className: 'select-checkbox',
        targets: 0
      }],
      select: {
        style: 'multi',
        selector: 'td:first-child'
      }
    });
  });
</script>
<?php // Lead garph ?>
  <script>
    
      var leadGraph;
      $.ajax({
        url : "<?php echo base_url();?>reports/get_leads_report",
        method: "GET",
        dataType : 'JSON',
        success: function(data)
        {
            //console.log(data);
          var lead_owner = [];
          var total_leads = [];
          for(var i in data)
          {
            lead_owner.push(data[i].lead_owner);
            total_leads.push(data[i].total_leads);
          }
          var chartdata = {
            labels: lead_owner,
            datasets : [
              {
                label: 'Total Leads',
               backgroundColor : [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(139, 159, 173)',
                'rgba(75, 192, 192, 1)',
                'rgba(119, 106, 146)',
                'rgba(175, 160, 145)',
                'rgba(74, 74, 74, 1)'
              ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(175, 212, 175)'
          ],
                data : total_leads
              }
            ] 
          };
          var ctx = $("#lead_graph");
          leadGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
        },
        error: function(data)
        {
          console.log(data);
        }
      });
      
      function sort_graph_leads(sort_date,from_date,to_date){
        $.ajax({
          url : "<?php echo base_url();?>reports/sort_lead_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : sort_date,'from_date' : from_date,'to_date' : to_date},
          success: function(response)
          {
              //console.log(response);
            var lead_owner = [];
            var total_leads = [];
            for(var i in response)
            {
              lead_owner.push(response[i].lead_owner);
              total_leads.push(response[i].total_leads);
            }
            leadGraph.data.labels = lead_owner ;
            leadGraph.data.datasets[0].data = total_leads;
            leadGraph.update();
          }
        });
      }
      function change_lead_date()
      {
        var date = $("#lead_date_filter").val();
        var form_date = '';
        var to_date = '';
        sort_graph_leads(date,form_date,to_date);
        
      }
      function change_leadto_date()
      {
        var date = '';
        var form_date = $("#leads_sortFrom").val();;
        var to_date = $("#leads_sortTo").val();;
        sort_graph_leads(date,form_date,to_date);
        
      }
    
  </script>
<?php //Lead Graph Ends ?>
<?php //Opportunity Graph Starts ?>
<script>
 
      var oppGraph;
      $.ajax({
        url : "<?php echo base_url();?>reports/get_top_opp_report",
        method: "GET",
        dataType : 'JSON',
        success: function(data)
        {
            
        <?php if($this->session->userdata('type')=="admin") { ?>
          var owner = [];
          var sub_total = [];
          for(var i in data)
          {
            owner.push(data[i].owner.toUpperCase());
            sub_total.push(data[i].sub_total);
          }
          var chartdata = {
            labels: owner,
            datasets : [
              {
                label: 'Total Amount',
                backgroundColor : [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
                ],
                  borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
            ],
                data : sub_total
              }
            ] 
          };
          var ctx = $("#opp_graph");
          oppGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
          
          <?php }else if($this->session->userdata('type')=="standard") {  ?>
             var currentdate = [];
          var sub_total = [];
          for(var i in data)
          {
            currentdate.push(data[i].currentdate);
            sub_total.push(data[i].sub_total);
          }
          var chartdata = {
            labels: currentdate,
            datasets : [
              {
                label: 'Total Amount',
                backgroundColor : [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
                ],
                  borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
            ],
                
                data : sub_total
              }
            ] 
          };
          var ctx = $("#opp_graph");
          oppGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
          <?php } ?>
        },
        error: function(data)
        {
          console.log(data);
        }
      });
      
      
       function sort_graph_opps(sort_date,from_date,to_date){
        $.ajax({
          url : "<?php echo base_url();?>home/sort_opportunity_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : sort_date,'from_date' : from_date,'to_date' : to_date},
          success: function(response)
          {
            <?php if($this->session->userdata('type')=="admin") {  ?>
                var owner = [];
                var sub_total = [];
                for(var i in response)
                {
                  owner.push(response[i].owner);
                  sub_total.push(response[i].sub_total);
                }
                oppGraph.data.labels = owner ;
                oppGraph.data.datasets[0].data = sub_total;
                oppGraph.update();
                
            <?php }else if($this->session->userdata('type')=="standard") { ?>  
                var currentdate = [];
                var sub_total = [];
                for(var i in response)
                {
                  currentdate.push(response[i].currentdate);
                  sub_total.push(response[i].sub_total);
                }
                oppGraph.data.labels = currentdate ;
                oppGraph.data.datasets[0].data = sub_total;
                oppGraph.update();
            
            
            <?php } ?>
          }
        });
      }
      
      
      function change_opp_date()
      {
        var date = $("#opportunity_date_filter").val();
        var form_date = '';
        var to_date = '';
        sort_graph_opps(date,form_date,to_date);
      } 
      
       function change_opp_filterdate(){
           var date = '';
           var form_date = $("#opportunity_sortFrom").val();
           var to_date = $("#opportunity_sortTo").val();
           sort_graph_opps(date,form_date,to_date);
       }
       
    
     /* var oppGraph;
      $.ajax({
        url : "<?php echo base_url();?>reports/get_top_opp_report",
        method: "GET",
        dataType : 'JSON',
        success: function(data)
        {
          var currentdate = [];
          var sub_total = [];
          for(var i in data)
          {
            currentdate.push(data[i].currentdate);
            sub_total.push(data[i].sub_total);
          }
          var chartdata = {
            labels: currentdate,
            datasets : [
              {
                label: 'Total Amount',
                backgroundColor : [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
                ],
                  borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
            ],
                
                data : sub_total
              }
            ] 
          };
          var ctx = $("#opp_graph");
          oppGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
        },
        error: function(data)
        {
          console.log(data);
        }
      });
      function change_opp_date()
      {
        var date = $("#opportunity_date_filter").val();
        $.ajax({
          url : "<?php echo base_url();?>home/sort_opportunity_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : date},
          success: function(response)
          {
            var currentdate = [];
            var sub_total = [];
            for(var i in response)
            {
              currentdate.push(response[i].currentdate);
              sub_total.push(response[i].sub_total);
            }
            oppGraph.data.labels = currentdate ;
            oppGraph.data.datasets[0].data = sub_total;
            oppGraph.update();
          }
        });
      }*/
    
</script>
<?php //Opportunity Graph Ends  ?>
<?php // Quotation Graph Starts ?>
  <script>
    
      var quoteGraph;
      $.ajax({
        url : "<?php echo base_url();?>reports/get_top_quote_report",
        method: "GET",
        dataType : 'JSON',
        success: function(data)
        {
        <?php if($this->session->userdata('type')=="standard") { ?>
          var currentdate = [];
          var sub_totalq = [];
          for(var i in data)
          {
            currentdate.push(data[i].currentdate);
            sub_totalq.push(data[i].sub_totalq);
          }
          var chartdata = {
            labels: currentdate,
            datasets : [
              {
                label: 'Total Amount',
               backgroundColor : [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
                ],
                  borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
            ],
                data : sub_totalq
              }
            ] 
          };
          var ctx = $("#quote_graph");
          quoteGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
          
        <?php } else if($this->session->userdata('type')=="admin") {  ?>
          var owner = [];
          var sub_totalq = [];
          for(var i in data)
          {
            owner.push(data[i].owner.toUpperCase());
            sub_totalq.push(data[i].sub_totalq);
          }
          var chartdata = {
            labels: owner,
            datasets : [
              {
                label: 'Total Amount',
               backgroundColor : [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
                ],
                  borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(139, 159, 173)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(119, 106, 146)',
                  'rgba(175, 160, 145)',
                  'rgba(74, 74, 74, 1)'
            ],
                data : sub_totalq
              }
            ] 
          };
          var ctx = $("#quote_graph");
          quoteGraph = new Chart(ctx, {
            type: 'bar',
            data : chartdata
          });
        <?php } ?>
          
        },
        error: function(data)
        {
          console.log(data);
        }
      });


      function sort_graph_quotes(sort_date,from_date,to_date){
        $.ajax({
          url : "<?php echo base_url();?>reports/sort_quotation_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : sort_date,'from_date' : from_date,'to_date' : to_date},
          success: function(response)
          {
              
            <?php if($this->session->userdata('type')=="standard") { ?>  
            var currentdate = [];
            var sub_totalq = [];
            for(var i in response)
            {
              currentdate.push(response[i].currentdate);
              sub_totalq.push(response[i].sub_totalq);
            }
            quoteGraph.data.labels = currentdate ;
            quoteGraph.data.datasets[0].data = sub_totalq;
            quoteGraph.update();
            
            <?php } else if($this->session->userdata('type')=="admin") {  ?>
             var owner = [];
            var sub_totalq = [];
            for(var i in response)
            {
              owner.push(response[i].owner);
              sub_totalq.push(response[i].sub_totalq);
            }
            quoteGraph.data.labels = owner ;
            quoteGraph.data.datasets[0].data = sub_totalq;
            quoteGraph.update();
            
            <?php } ?>
          }
        });
      }

      function change_quote_date()
      {
        var date = $("#quotation_date_filter").val();
        var form_date = '';
        var to_date = '';
        sort_graph_quotes(date,form_date,to_date);
      } 
      
       function searchQuoteFilter(){
           var date = '';
           var form_date = $("#quotes_sortFrom").val();
           var to_date = $("#quotes_sortTo").val();
           sort_graph_quotes(date,form_date,to_date);
       }
       
      
   
  </script>
<?php // Quotation Graph Ends ?>

<?php // Salesorder Graph Starts ?>
  <script>
   
        var salesGraph;
        $.ajax({
          url : "<?php echo base_url();?>reports/get_so_report",
          method: "GET",
          dataType : 'JSON',
          success: function(data)
          {
           <?php if($this->session->userdata('type')=="standard") { ?>
            var status = [];
            var sub_totals = [];
            for(var i in data)
            {
              status.push(data[i].status);
              sub_totals.push(data[i].sub_totals);
            }
            var chartdata = {
              labels: status,
              datasets : [
                {
                  label: 'Total Amount',
                 backgroundColor : [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
                  ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
              ],
                  data : sub_totals
                }
              ] 
            };
            var ctx = $("#sales_graph");
            salesGraph = new Chart(ctx, {
              type: 'bar',
              data : chartdata
            });
        <?php } else if($this->session->userdata('type')=="admin") { ?> 
         
            var owner = [];
            var sub_totals = [];
            for(var i in data)
            {
              owner.push(data[i].owner.toUpperCase());
              sub_totals.push(data[i].sub_totals);
            }
            var chartdata = {
              labels: owner,
              datasets : [
                {
                  label: 'Total Amount',
                 backgroundColor : [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
                  ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
              ],
                  data : sub_totals
                }
              ] 
            };
            var ctx = $("#sales_graph");
            salesGraph = new Chart(ctx, {
              type: 'bar',
              data : chartdata
            });
            
        <?php } ?>  
          },
          error: function(data)
          {
            console.log(data);
          }
        });
        
        function sort_graph_sales(sort_date,from_date,to_date){
        $.ajax({
          url : "<?php echo base_url();?>reports/sort_so_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : sort_date,'from_date' : from_date,'to_date' : to_date},
          success: function(response)
          {
              
            <?php if($this->session->userdata('type')=="standard") { ?>  
              var status = [];
              var sub_totals = [];
              for(var i in response)
              {
                status.push(response[i].status);
                sub_totals.push(response[i].sub_totals);
              }
              salesGraph.data.labels = status ;
              salesGraph.data.datasets[0].data = sub_totals;
              salesGraph.update();
            
            <?php } else if($this->session->userdata('type')=="admin") {  ?>
              var owner = [];
              var sub_totals = [];
              for(var i in response)
              {
                owner.push(response[i].owner);
                sub_totals.push(response[i].sub_totals);
              }
              salesGraph.data.labels = owner ;
              salesGraph.data.datasets[0].data = sub_totals;
              salesGraph.update();
            
            <?php } ?>
          }
        });
      }
      function change_so_date()
      {
        var date = $("#so_date_filter").val();
        var form_date = '';
        var to_date = '';
        sort_graph_sales(date,form_date,to_date);
      } 
      
       function change_so_filterdate(){
           var date = '';
           var form_date = $("#so_sortFroms").val();
           var to_date = $("#so_sortsTo").val();
           sort_graph_sales(date,form_date,to_date);
       }
        
        
     
  </script>
<?php // Salesorder Graph Ends ?>
<?php // PurchaseOrder Graph Starts ?>
<script>
  
    var purchseGraph;
    $.ajax({
      url : "<?php echo base_url();?>reports/get_top_po_report",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
          
        <?php if($this->session->userdata('type')=="standard") { ?>      
        var currentdate = [];
        var sub_total = [];
        for(var i in data)
        {
          currentdate.push(data[i].currentdate);
          sub_total.push(data[i].sub_total);
        }
        var chartdata = {
          labels: currentdate,
          datasets : [
            {
              label: 'Total Amount',
              backgroundColor : [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
                  ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
              ],
              data : sub_total
            }
          ] 
        };
        var ctx = $("#purchase_graph");
        purchseGraph = new Chart(ctx, {
          type: 'bar',
          data : chartdata
        });
        
        <?php } else if($this->session->userdata('type')=="admin") { ?>
    
            var owner = [];
            var sub_total = [];
            for(var i in data)
            {
              owner.push(data[i].owner.toUpperCase());
              sub_total.push(data[i].sub_total);
            }
            var chartdata = {
              labels: owner,
              datasets : [
             {
              label: 'Total Amount',
              backgroundColor : [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
                  ],
                    borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(139, 159, 173)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(119, 106, 146)',
                    'rgba(175, 160, 145)',
                    'rgba(74, 74, 74, 1)'
              ],
              data : sub_total
            }
          ] 
        };
        var ctx = $("#purchase_graph");
        purchseGraph = new Chart(ctx, {
          type: 'bar',
          data : chartdata
        });
        
        <?php } ?>
      },
      error: function(data)
      {
        console.log(data);
      }
    });
    
    function sort_graph_po(sort_date,from_date,to_date){
        $.ajax({
          url : "<?php echo base_url();?>reports/sort_po_graph",
          method: "POST",
          dataType : 'JSON',
          data : {'date' : sort_date,'from_date' : from_date,'to_date' : to_date},
          success: function(response)
          {
              
            <?php if($this->session->userdata('type')=="standard") { ?>  
              var currentdate = [];
              var sub_total = [];
              for(var i in response)
              {
                currentdate.push(response[i].currentdate);
                sub_total.push(response[i].sub_total);
              }
              purchseGraph.data.labels = currentdate ;
              purchseGraph.data.datasets[0].data = sub_total;
              purchseGraph.update();
            
            <?php } else if($this->session->userdata('type')=="admin") {  ?>
              var owner = [];
              var sub_total = [];
              for(var i in response)
              {
                owner.push(response[i].owner);
                sub_total.push(response[i].sub_total);
              }
              purchseGraph.data.labels = owner ;
              purchseGraph.data.datasets[0].data = sub_total;
              purchseGraph.update();
            
            <?php } ?>
          }
        });
      }
      function change_po_date()
      {
        var date = $("#po_date_filter").val();
        var form_date = '';
        var to_date = '';
        sort_graph_po(date,form_date,to_date);
      } 
      
       function change_po_filterdate(){
           var date = '';
           var form_date = $("#po_sortFroms").val();
           var to_date = $("#po_sortsTo").val();
           sort_graph_po(date,form_date,to_date);
       }
        
      
   
  
</script>
<?php // PurchaseOrder Grapg Ends ?>
<script>
  function change_nav(data, liid)
  {
	$(".randmCl").removeClass('active');
	$("#"+liid).addClass('active');
	$(".hddnCl").hide();
	$("#"+data).show();
  }


  
    //<--------------------------------------  All Customdata_6 ----------------------------------------------->
    // getfilterdData('<?= date('Y-m-d',$week); ?>','null','date_filter','profit_table_productOjx')

    // getfilterdData(startDate, endDate,'date_filter', 'date_filter','profit_table_productOjx');

    // function getfilterdData(e,f,g,h=null){
    //   alert(f);

    //     var id = "#" + g;
    //     $(id).val(e);
    //     if(f!="null"){
    //     window[f]();
    //     }
    //     if(h!=null){
    //       var ajaxtableid = "#" + h;
    //     }
    //   $(ajaxtableid).DataTable().ajax.reload();
    // }



function getfilterdData(startDate, endDate, filterFunc, tableId = null) {
    // Set the start date if it's provided
    if (startDate !== 'null' && startDate) {
        var id = "#" + filterFunc;
        $(id).val(startDate);
    }

    // Set the end date if it's provided and not null
    if (endDate !== 'null' && endDate) {
        var endDateId = "#end_date"; // The ID for the end date input
        $(endDateId).val(endDate);
    }

    // Call the function if filterFunc is valid
    if (typeof window[filterFunc] === 'function') {
        window[filterFunc]();
    }

    // If tableId is provided, reload the DataTable
    if (tableId != null) {
        var ajaxtableid = "#" + tableId;
        $(ajaxtableid).DataTable().ajax.reload();
    }
}











// <------------------------------------------ End Filter ------------------------------------------------------->


</script>