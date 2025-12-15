<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pipeline Performance</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Pipeline Performance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- tabs -->
  <ul class="nav nav-tabs">
    <li onclick="change_nav('Lead');" class="nav-item" ><a id="lead_li" class="nav-link" href="javascript:void(0);">Deals Added</a></li>
    <li onclick="change_nav('Opportunity');" class="nav-item" ><a id="opp_li" class="nav-link" href="javascript:void(0);">Pipeline value</a></li>
    <li onclick="change_nav('Quotation');" class="nav-item"><a id="quote_li" class="nav-link" href="javascript:void(0);">Funnel Progression</a></li>
    <li onclick="change_nav('SalesOrder');" class="nav-item" ><a id="so_li" class="nav-link" href="javascript:void(0);">Pipeline Activity</a></li>
    <!--<li onclick="change_nav('PurchaseOrder');" class="nav-item" ><a id="po_li" class="nav-link" href="javascript:void(0);">Product Pipeline</a>  </li>-->
   
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div id="leads_data" class="container-fluid"><br>
      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <!--<div class="row">
                <?php if(!empty($leads_status)) { ?>
                <?php foreach($leads_status as $ld_st) { ?>
                  <div class="col-lg-3 col-6">
                      <!-- small box 
                      <div class="small-box bg-info grey">
                          <div class="inner animate__animated animate__flipInX">
                              <h4><?= $ld_st['lead_status'];  ?></h4>

                              <h3><?= $ld_st['total_count'];?></h3>
                          
                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                      </div>
                  </div>
                
                <?php } } ?>
              </div>-->
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable" id="">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card animate__animated animate__slideInUp">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i>
                                  Deals Added
                              </h3>
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                            <div class="row mb-3">
							<div class="col-lg-2">
                                <div class="first-one">
                                    <b>View By</b>
                                  <select class="form-control" name="lead_date_filter" id="deals_year_filter" onchange="change_deals_year(); return false;">
                                    <option selected disabled>Select Option</option>
                                     <?php 
										$start_year = 2019;
										for($start_year; $start_year <= date('Y'); $start_year++){  				 
									  ?>
									  <option value="<?=$start_year;?>" <?php if(date('Y')==$start_year){ echo 'selected'; } ?>><?=$start_year;?></option>
										<?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="col-lg-2">
                                <div class="first-one">
                                    <b>Sort</b>
                                  <select class="form-control" name="lead_date_filter" id="lead_date_filter" onchange="change_lead_date(); return false;">
                                    <option value="" selected >Select Option</option>
                                    <?php $fifteen = strtotime("-15 Day"); ?>
                                    <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                                    <?php $thirty = strtotime("-30 Day"); ?>
                                    <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
									<option value="<?= date('Y-m-d', strtotime("-1 month")); ?>">Last Month</option>
                                    <?php $fortyfive = strtotime("-45 Day"); ?>
                                    <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                                    <?php $sixty = strtotime("-60 Day"); ?>
                                    <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                                   
                                    <option value="<?= date('Y-m-d', strtotime("-3 month")); ?>">Last 3 Months</option>
                                    <?php $six_month = strtotime("-6 month"); ?>
                                    <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                                    <?php $one_year = strtotime("-1 year"); ?>
                                    <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                                  </select>
                                </div>
                              </div>
                               <div class="col-lg-2">
                                <div class="first-one">
                                    <b>Deal Stage</b>
                                  <select class="form-control" name="lead_date_filter" id="deals_stage_filter" onchange="change_deals_stage(); return false;">
                                    <option value="" selected >Select Option</option>
                                      <option value="Qualifying">Qualifying</option>
									  <option value="Needs Analysis">Needs Analysis</option>
									  <option value="Proposal">Proposal</option>
									  <option value="Negotiation">Negotiation</option>
									  <option value="Closed Won">Closed Won</option>
									  <option value="Closed Lost">Closed Lost</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-sm-2 "><b>From:</b><input class="form-control" type="date" id="leads_sortFrom" name="leads_sortFrom" onchange="change_leadto_date()" /></div>
                              <div class="col-sm-2 form-group"><b>To:</b><input class="form-control" type="date" id="leads_sortTo" name="leads_sortTo" onchange="change_leadto_date()" /></div>
                              
                            </div>
                            <div class="tab-content p-0">
							   <span style="text-align:center;font-size:20px;">How many deals were added?</span>
							   
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                    <canvas id="lead_graph" width="200" height="0"></canvas>
                                </div>
                            </div>
                          </div>
                          <!-- /.card-body -->
                      </div>
                  </section>
                  <!-- /.Left col -->

                  <!-- right col ()
                  <?php if($this->session->userdata('type') == "admin") { ?>
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <!-- tables 
                      <div class="card org_div">
                          <!-- /.card-header 
                          <div class="card-body">
                              <form method="post" action="<?php echo base_url();?>Reports/export_lead_to_csv">
                                  <div class="row">
                                      
                                      <div class="col-sm-3 form-group">
                                        <b>Sort:</b>
                                        <select class="form-control" id="lead_sortBy" name="lead_sortBy">
                                          <option value="<?= date('y.m.d')?>">Today</option>
                                          <?php $d = strtotime("-1 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $d)?>">Yesterday</option>
                                          <?php $w = strtotime("-7 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $w)?>">Last 7 Days</option>
                                          <?php $f = strtotime("-15 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $f)?>">Last 15 Days</option>
                                          <?php $t = strtotime("-20 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $t)?>">Last 20 Days</option>
                                          <?php $m = strtotime("-30 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $m)?>">Last 30 Days</option>
                                          <?php $q = strtotime("-90 Day");
                                          ?>
                                          <option value="<?= date('y.m.d', $q)?>">Last 90 Days</option>
                                        </select>
                                      </div>
                                      <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="lead_sortFrom" name="lead_sortFrom" onchange="searchLeadFilter()" /></div>
                                      <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="lead_sortTo" name="lead_sortTo" onchange="searchLeadFilter()" /></div>
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
                                  <div class="col-sm-2 form-group"><input class="form-control btn btn-info btn-sm active" value="Export" type="submit" id="" name="submit" /></div>
                              </form>
                          </div>
                          <!-- /.card-body 
                      </div>
                      <!-- /.card 
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
    <div  class="container-fluid">
      <section class="content" >
          <div class="container-fluid" id="Opportunity_data">
              <!-- Small boxes (Stat box) -->
              <!--<div class="row">
                <?php if(!empty($opp_stage)) { foreach($opp_stage as $op_st) { ?>
                  <div class="col-lg-3 col-6">
                      <!-- small box 
                      <div class="small-box bg-info grey">
                          <div class="inner animate__animated animate__flipInX">
                              <h4><?= $op_st['stage'];  ?></h4>

                              <h3><?= $op_st['total_count'];?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                      </div>
                  </div>
                <?php } } ?>
                  <!-- ./col 
                  
                  <!-- ./col 
              </div>-->
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card animate__animated animate__slideInUp">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i>
                                  Pipeline Value
                              </h3>
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <div class="row mb-3">
                                  <div class="col-lg-2">
                                      <div class="first-one">
                                            <b>View By</b>
									  <select class="form-control" name="lead_date_filter" id="pipevalue_year_filter" onchange="getChartData(); return false;" >
										<option selected disabled>Select Option</option>
										 <?php 
											$start_year = 2019;
											for($start_year; $start_year <= date('Y'); $start_year++){  				 
										  ?>
										  <option value="<?=$start_year;?>" <?php if(date('Y')==$start_year){ echo 'selected'; } ?>><?=$start_year;?></option>
											<?php } ?>
									  </select>
									</div>
								  </div>
								  <div class="col-lg-2">
									<div class="first-one">
										<b>Sort</b>
									  <select class="form-control" name="lead_date_filter" id="pipevalue_date_filter" onchange="getChartData(); return false;" >
										<option value="" selected >Select Option</option>
										<?php $fifteen = strtotime("-15 Day"); ?>
										<option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
										<?php $thirty = strtotime("-30 Day"); ?>
										<option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
										<?php $fortyfive = strtotime("-45 Day"); ?>
										<option value="<?= date('Y-m-d', strtotime("-1 month")); ?>">Last Month</option>
										<option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
										<?php $sixty = strtotime("-60 Day"); ?>
										<option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
										
										<option value="<?= date('Y-m-d', strtotime("-3 month")); ?>">Last 3 Months</option>
										<?php $six_month = strtotime("-6 month"); ?>
										<option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
										<?php $one_year = strtotime("-1 year"); ?>
										<option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
									  </select>
									</div>
								  </div>
								   <div class="col-lg-2">
									<div class="first-one">
										<b>Deal Stage</b>
									  <select class="form-control" name="lead_date_filter" id="pipevalue_stage_filter" onchange="change_pipevalue_stage(); return false;">
										<option value="" selected >Select Option</option>
										  <option value="Qualifying">Qualifying</option>
										  <option value="Needs Analysis">Needs Analysis</option>
										  <option value="Proposal">Proposal</option>
										  <option value="Negotiation">Negotiation</option>
										  <option value="Closed Won">Closed Won</option>
										  <option value="Closed Lost">Closed Lost</option>
									  </select>
									</div>
								  </div>
								  <div class="col-sm-2 "><b>From:</b><input class="form-control" type="date" id="pipevalue_sortFrom" name="pipevalue_sortFrom"  /></div>
								  <div class="col-sm-2 form-group"><b>To:</b><input class="form-control" type="date" id="pipevalue_sortTo" name="pipevalue_sortTo" onchange="getChartData(); return false;"  /></div>
                              
                              </div>
                              <div class="tab-content p-0">
							  <span style="text-align:center;font-size:20px;">What is the value of my pipeline?</span>
                                  <!-- Morris chart - Sales
                                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                      <canvas id="opp_pipegraph" width="200" height="0"></canvas>
                                  </div> -->
							   <!-- Apex chart  -->
                              <div id="opp_pipegraph" width="200" height="0"></div>
                              </div>
                          </div>
                          <!-- /.card-body -->
                      </div>
                  </section>
                  <!-- /.Left col -->
                  <!-- right col (We are only adding the ID to make the widgets sortable)
                  <?php if($this->session->userdata('type') == "admin") { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables 
                        <div class="card org_div">
                            <!-- /.card-header 
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_opp_to_csv">
                                    <div class="row">
                                        <!-- <div class="col-sm-3 form-group"><b>Search:</b><input class="form-control" type="text" id="lead_keywords" name="lead_keywords" placeholder="Search..." onkeyup="" /></div> 
                                        <div class="col-sm-3 form-group">
                                          <b>Sort:</b>
                                          <select class="form-control" id="opp_sortBy" name="opp_sortBy">
                                            <option value="">Sort By Time</option>
                                            <option value="<?= date('y.m.d')?>">Today</option>
                                            <?php $d = strtotime("-1 Day"); ?>
                                            <option value="<?= date('y.m.d', $d)?>">Yesterday</option>
                                            <?php $w = strtotime("-7 Day"); ?>
                                            <option value="<?= date('y.m.d', $w)?>">Last 7 Days</option>
                                            <?php $f = strtotime("-15 Day"); ?>
                                            <option value="<?= date('y.m.d', $f)?>">Last 15 Days</option>
                                            <?php $t = strtotime("-20 Day"); ?>
                                            <option value="<?= date('y.m.d', $t)?>">Last 20 Days</option>
                                            <?php $m = strtotime("-30 Day"); ?>
                                            <option value="<?= date('y.m.d', $m)?>">Last 30 Days</option>
                                            <?php $q = strtotime("-90 Day"); ?>
                                            <option value="<?= date('y.m.d', $q)?>">Last 90 Days</option>
                                          </select>
                                        </div>
                                        <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="opp_sortFrom" name="sortFrom" onchange="" /></div>
                                        <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="opp_sortTo" name="sortTo" onchange="" /></div>
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
                                    <div class="col-sm-2 form-group"><input class="form-control btn btn-info btn-sm active" value="Export" type="submit" id="" name="submit" /></div>
                                </form>
                            </div>
                            <!-- /.card-body 
                        </div>
                        <!-- /.card 
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
    <div id="Quotation_data" class="container-fluid"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) 
              <div class="row">
                <?php if(!empty($quote_stage)) { foreach($quote_stage as $qt_st) { ?>
                  <div class="col-lg-3 col-6">
                        <!-- small box 
                    <div class="small-box bg-info grey">
                      <div class="inner animate__animated animate__flipInX">
                          <h4><?= $qt_st['quote_stage']; ?></h4>

                          <h3><?= $qt_st['total_count']; ?></h3>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                    </div>
                  </div>
                <?php } } ?>
              </div>-->
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card animate__animated animate__slideInUp">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i>
                                  Funnel Progression
                              </h3>
                          </div>
                          <div class="card-body">
                              <div class="row mb-3">
                                  <!--<div class="col-lg-2">
                                      <div class="first-one">
                                    <b>View By</b>
									  <select class="form-control" name="lead_date_filter" id="funnel_year_filter" onchange="getfunnelChartData(); return false;" >
										<option selected disabled>Select Option</option>
										 <?php 
											$start_year = 2019;
											for($start_year; $start_year <= date('Y'); $start_year++){  				 
										  ?>
										  <option value="<?=$start_year;?>" <?php if(date('Y')==$start_year){ echo 'selected'; } ?>><?=$start_year;?></option>
											<?php } ?>
									  </select>
									</div>
								  </div>-->
								  <div class="col-lg-2">
									<div class="first-one">
										<b>Sort</b>
									  <select class="form-control" name="lead_date_filter" id="funnel_date_filter" onchange="getfunnelChartData();" >
										<option value="" selected >Select Option</option>
										<?php $fifteen = strtotime("-15 Day"); ?>
										<option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
										<?php $thirty = strtotime("-30 Day"); ?>
										<option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
										<?php $fortyfive = strtotime("-45 Day"); ?>
										<option value="<?= date('Y-m-d', strtotime("-1 month")); ?>">Last Month</option>
										<option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
										<?php $sixty = strtotime("-60 Day"); ?>
										<option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
										
										<option value="<?= date('Y-m-d', strtotime("-3 month")); ?>">Last 3 Months</option>
										<?php $six_month = strtotime("-6 month"); ?>
										<option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
										<?php $one_year = strtotime("-1 year"); ?>
										<option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
									  </select>
									</div>
								  </div>
								   <div class="col-lg-2">
									<div class="first-one">
										<b>Deal Stage</b>
									  <select class="form-control" name="lead_date_filter" id="funnel_stage_filter" onchange="getfunnelChartData(); return false;">
										<option value="" selected >Select Option</option>
										  <option value="Qualifying">Qualifying</option>
										  <option value="Needs Analysis">Needs Analysis</option>
										  <option value="Proposal">Proposal</option>
										  <option value="Negotiation">Negotiation</option>
										  <option value="Closed Won">Closed Won</option>
										  <option value="Closed Lost">Closed Lost</option>
									  </select>
									</div>
								  </div>
								  <div class="col-sm-2 "><b>From:</b><input class="form-control" type="date" id="funnel_sortFrom" name="pipevalue_sortFrom"  /></div>
								  <div class="col-sm-2 form-group"><b>To:</b><input class="form-control" type="date" id="funnel_sortTo" name="funnel_sortTo" onchange="getfunnelChartData(); return false;"  /></div>
                              </div>
                              <div class="tab-content p-0">
							  <span style="text-align:center;font-size:20px;"></span>
								  <div id="chartContainer" style="height:450px; width:100% !important;"></div>
								  <input type="hidden" id="check_elm">
                              </div>
                          </div>
                          <!-- /.card-body -->
                      </div>
                  </section>
                  <!-- /.Left col -->
                  <!-- right col (We are only adding the ID to make the widgets sortable)
                  <?php if($this->session->userdata('type') == "admin") { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card -->
                        <!-- tables 
                        <div class="card org_div">
                            <!-- /.card-header
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_quotation_to_csv">
                                    <div class="row">
                                        <!-- <div class="col-sm-3 form-group"><b>Search:</b><input class="form-control" type="text" id="lead_keywords" name="lead_keywords" placeholder="Search..." onkeyup="" /></div> 
                                        <div class="col-sm-3 form-group">
                                            <b>Sort By Time:</b>
                                            <select class="form-control" id="quote_sortBy" name="quote_sortBy" onchange="">
                                                <option selected disabled>Sort By Time</option>
                                                <option value="<?= date('y.m.d')?>">Today</option>
                                                <?php $d = strtotime("-1 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $d)?>">Yesterday</option>
                                                <?php $w = strtotime("-7 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $w)?>">Last 7 Days</option>
                                                <?php $f = strtotime("-15 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $f)?>">Last 15 Days</option>
                                                <?php $t = strtotime("-20 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $t)?>">Last 20 Days</option>
                                                <?php $m = strtotime("-30 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $m)?>">Last 30 Days</option>
                                                <?php $q = strtotime("-90 Day");
                                                ?>
                                                <option value="<?= date('y.m.d', $q)?>">Last 90 Days</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="quote_sortFrom" name="quote_sortFrom" onchange="searchQuotationFilter();" /></div>
                                        <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="lead_sortTo" name="lead_sortTo" onchange="searchQuotationFilter();" /></div>
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
                                    <div class="col-sm-2 form-group"><input class="form-control btn btn-info btn-sm active" value="Export" type="submit" id="" name="" onchange="" /></div>
                                </form>
                            </div>
                            <!-- /.card-body 
                        </div>
                        <!-- /.card 
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
    <div id="Salesorder_data" class="container-fluid"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card animate__animated animate__slideInUp">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i>
                                  Pipeline Activity
                              </h3>
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <div class="row mb-3">
                                  <div class="col-lg-2">
                                      <div class="first-one">
                                            <b>View By</b>
									  <select class="form-control"  id="pipeactivity_year_filter" onchange="getChartPipeactivity(); return false;" >
										<option selected disabled>Select Option</option>
										 <?php 
											$start_year = 2019;
											for($start_year; $start_year <= date('Y'); $start_year++){  				 
										  ?>
										  <option value="<?=$start_year;?>" <?php if(date('Y')==$start_year){ echo 'selected'; } ?>><?=$start_year;?></option>
											<?php } ?>
									  </select>
									</div>
								  </div>
								  <div class="col-lg-2">
									<div class="first-one">
										<b>Sort</b>
									  <select class="form-control" id="pipeactivity_date_filter" onchange="getChartPipeactivity(); return false;" >
										<option value="" selected >Select Option</option>
										<?php $fifteen = strtotime("-15 Day"); ?>
										<option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
										<?php $thirty = strtotime("-30 Day"); ?>
										<option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
										<?php $fortyfive = strtotime("-45 Day"); ?>
										<option value="<?= date('Y-m-d', strtotime("-1 month")); ?>">Last Month</option>
										<option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
										<?php $sixty = strtotime("-60 Day"); ?>
										<option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
										
										<option value="<?= date('Y-m-d', strtotime("-3 month")); ?>">Last 3 Months</option>
										<?php $six_month = strtotime("-6 month"); ?>
										<option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
										<?php $one_year = strtotime("-1 year"); ?>
										<option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
									  </select>
									</div>
								  </div>
								   <div class="col-lg-2">
									<div class="first-one">
										<b>Deal Stage</b>
									  <select class="form-control" id="pipeactivity_stage_filter" onchange="getChartPipeactivity(); return false;">
										<option value="" selected >Select Option</option>
										  <option value="Qualifying">Qualifying</option>
										  <option value="Needs Analysis">Needs Analysis</option>
										  <option value="Proposal">Proposal</option>
										  <option value="Negotiation">Negotiation</option>
										  <option value="Closed Won">Closed Won</option>
										  <option value="Closed Lost">Closed Lost</option>
									  </select>
									</div>
								  </div>
								  <div class="col-sm-2 "><b>From:</b><input class="form-control" type="date" id="pipeactivity_sortFrom"  /></div>
								  <div class="col-sm-2 form-group"><b>To:</b><input class="form-control" type="date" id="pipeactivity_sortTo" onchange="getChartPipeactivity(); return false;"  /></div>
                              </div>
                              <div class="tab-content p-0">
                                  <!-- Morris chart - Sales 
                                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                      <canvas id="sales_graph" width="200" height="0"></canvas>
                                  </div>-->
								<div id="chartPipeactivity" style="height: 0px; width: 100%;"></div>
                              </div>
                          </div>
                          <!-- /.card-body -->
                      </div>
                  </section>
                  <!-- /.Left col -->
                  <!-- right col (We are only adding the ID to make the widgets sortable)
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card 
                      <!-- tables 
                      <div class="card org_div">
              <!-- /.card-header 
              <div class="card-body">
                <form method="post" action="<?=base_url('Reports/get_so_profit_table');?>">
                  <div class="row">
                      <div class="col-sm-3 form-group">
					    <input type="hidden" name="exportCsv"  value="exportCsv">
                          <select class="form-control" name="searchDate" id="so_profit_date_filter">
                            <option selected disabled>Select date</option>
                            <option value="This Week">This Week</option>
                            <?php $week = strtotime("-7 Day"); ?>
                            <option value="<?= date('y.m.d', $week); ?>">Last Week</option>
                            <?php $fifteen = strtotime("-15 Day"); ?>
                            <option value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</option>
                            <?php $thirty = strtotime("-30 Day"); ?>
                            <option value="<?= date('y.m.d', $thirty); ?>">Last 30 days</option>
                            <?php $fortyfive = strtotime("-45 Day"); ?>
                            <option value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</option>
                            <?php $sixty = strtotime("-60 Day"); ?> 
                            <option value="<?= date('y.m.d', $sixty); ?>">Last 60 days</option>
                            <?php $ninty = strtotime("-90 Day"); ?>
                            <option value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</option>
                            <?php $six_month = strtotime("-180 Day"); ?>
                            <option value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</option>
                            <?php $one_year = strtotime("-365 Day"); ?>
                            <option value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</option>
                          </select>
                      </div>
                      <?php if($this->session->userdata('type')=='admin') { ?>
                        <div class="col-sm-3 form-group">
                          <select class="form-control" name="searchDate" id="so_user_filter">
                            <option value="">Select User</option>
                            <?php if(!empty($user)) { foreach($user as $users) { ?>
                              <option value="<?= $users['standard_email']?>"><?= $users['standard_name']?></option>
                            <?php } } ?>
                            <?php if(!empty($admin)) { foreach($admin as $adm) { ?>
                              <option value="<?= $adm['admin_email']?>"><?= $adm['admin_name']?></option>
                            <?php } } ?>
                          </select>
                        </div>
                      <?php } ?>
 
                      <div class="col-sm-1 form-group"><input class="form-control btn btn-sm btn-info active" value="Excel" type="submit" id="" name="" onchange="" /></div>
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
              <!-- /.card-body 
            </div>
                      <!-- /.card 
                  </section>
                  <!--<?php if($this->session->userdata('type') == 'admin') { ?>
                    <section class="col-lg-12 connectedSortable">
                        <!-- /.card 
                        <!-- tables 
                        <div class="card org_div">
                            <!-- /.card-header
                            <div class="card-body">
                                <form method="post" action="<?php echo base_url();?>Reports/export_sales_to_csv">
                                    <div class="row">
                                        <div class="col-sm-3 form-group">
                                            <b>Sort By Time:</b>
                                            <select class="form-control" id="so_sortBy" name="so_sortBy" onchange="">
                                              <option selected disabled>Sort By Time</option>
                                              <option value="<?= date('y.m.d')?>">Today</option>
                                              <?php $d = strtotime("-1 Day");?>
                                              <option value="<?= date('y.m.d', $d)?>">Yesterday</option>
                                              <?php $w = strtotime("-7 Day");?>
                                              <option value="<?= date('y.m.d', $w)?>">Last 7 Days</option>
                                              <?php $f = strtotime("-15 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $f)?>">Last 15 Days</option>
                                              <?php $t = strtotime("-20 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $t)?>">Last 20 Days</option>
                                              <?php $m = strtotime("-30 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $m)?>">Last 30 Days</option>
                                              <?php $q = strtotime("-90 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $q)?>">Last 90 Days</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="so_sortFrom" name="so_sortFrom" onchange="" /></div>
                                        <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="so_sortTo" name="so_sortTo" onchange="" /></div>
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
                                    <div class="col-sm-2 form-group"><input class="form-control btn btn-info btn-sm active" value="Export" type="submit" id="" name="" onchange="" /></div>
                                </form>
                            </div>
                            <!-- /.card-body 
                        </div>
                        <!-- /.card 
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

    <div id="Purchaseorder_data" class="container-fluid"><br>
      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <section class="col-lg-12 connectedSortable">
                      <!-- Custom tabs (Charts with tabs)-->
                      <div class="card animate__animated animate__slideInUp">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-chart-pie mr-1"></i>
                                  Top Purchaseorder
                              </h3>
                          </div>

                          <!-- /.card-header -->
                          <div class="card-body">
                              <div class="row mb-3">
                                  <div class="col-lg-4">
                                      <div class="first-one">
                                          <b>Sort</b>
                                          <select class="form-control" name="po_date_filter" id="po_date_filter" onchange="change_po_date(); return false;">
                                            <option selected disabled>Select Option</option>
                                            <?php $fifteen = strtotime("-15 Day"); ?>
                                            <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                                            <?php $thirty = strtotime("-30 Day"); ?>
                                            <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                                            <?php $fortyfive = strtotime("-45 Day"); ?>
                                            <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                                            <?php $sixty = strtotime("-60 Day"); ?>
                                            <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                                            <option value="<?= date('Y-m-d', strtotime("-1 month")); ?>">Last Month</option>
                                            
                                            <option value="<?= date('Y-m-d', strtotime("-3 month")); ?>">Last 3 Months</option>
                                            <?php $six_month = strtotime("-6 month"); ?>
                                            <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                                            <?php $one_year = strtotime("-1 year"); ?>
                                            <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="po_sortFroms" name="po_sortFroms" onchange="change_po_filterdate()" /></div>
                                        <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="po_sortsTo" name="po_sortsTo" onchange="change_po_filterdate()" /></div>
                              </div>
                              <div class="tab-content p-0">
                                  <!-- Morris chart - Sales -->
                                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
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
                                        <!-- <div class="col-sm-3 form-group"><b>Search:</b><input class="form-control" type="text" id="lead_keywords" name="lead_keywords" placeholder="Search..." onkeyup="" /></div> -->
                                        <div class="col-sm-3 form-group">
                                            <b>Sort By Time:</b>
                                            <select class="form-control" id="po_sortBy" name="po_sortBy" onchange="">
                                              <option selected disabled>Sort By Time</option>
                                              <option value="<?= date('y.m.d')?>">Today</option>
                                              <?php $d = strtotime("-1 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $d)?>">Yesterday</option>
                                              <?php $w = strtotime("-7 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $w)?>">Last 7 Days</option>
                                              <?php $f = strtotime("-15 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $f)?>">Last 15 Days</option>
                                              <?php $t = strtotime("-20 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $t)?>">Last 20 Days</option>
                                              <?php $m = strtotime("-30 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $m)?>">Last 30 Days</option>
                                              <?php $q = strtotime("-90 Day");
                                              ?>
                                              <option value="<?= date('y.m.d', $q)?>">Last 90 Days</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3 form-group"><b>From:</b><input class="form-control" type="date" id="po_sortFrom" name="po_sortFrom" onchange="" /></div>
                                        <div class="col-sm-3 form-group"><b>To:</b><input class="form-control" type="date" id="po_sortTo" name="po_sortTo" onchange="" /></div>
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
                                    <div class="col-sm-3 form-group"><input class="form-control btn btn-info btn-sm active" value="Export" type="submit" id="" name="" onchange="" /></div>
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

    
	
  </div>
    <!-- tabs -->

  </div>
  <!-- /.content-wrapper -->
 <?php $this->load->view('footer');?>
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<?php // Lead garph ?>
  <script>
    
      var leadGraph;
      $.ajax({
        url : "<?php echo base_url();?>pipeline_performance/get_leads_report",
        method: "GET",
        dataType : 'JSON',
        success: function(data)
        {
            //console.log(data);
          var lead_owner = [];
          var total_leads = [];
          for(var i in data)
          {
            lead_owner.push(data[i].month_name);
            total_leads.push(data[i].total_deals);
          }
          var chartdata = {
            labels: lead_owner,
            datasets : [
              {
                label: 'Total Deals',
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
      
      function sort_graph_leads(sort_date,from_date,to_date,date_year,deal_stage){
        $.ajax({
          url : "<?php echo base_url();?>pipeline_performance/sort_deals_graph",
          method: "POST",
          dataType : 'JSON',
          data : {date : sort_date,from_date : from_date,to_date : to_date,date_year:date_year, deal_stage:deal_stage},
          success: function(response)
          {
              //console.log(response);
            var lead_owner = [];
            var total_leads = [];
            for(var i in response)
            {
              lead_owner.push(response[i].month_name);
              total_leads.push(response[i].total_deals);
            }
            leadGraph.data.labels = lead_owner ;
            leadGraph.data.datasets[0].data = total_leads;
            leadGraph.update();
          }
        });
      }
	  function change_deals_year()
      {
        var date_year = $("#deals_year_filter").val();
		var date = '';
        var form_date = '';
        var to_date = '';
		var deal_stage = '';
        sort_graph_leads(date,form_date,to_date,date_year,deal_stage);
        
      }
      function change_lead_date()
      {
        var date = $("#lead_date_filter").val();
		var date_year = $("#deals_year_filter").val();
        var form_date = '';
        var to_date = '';
		var deal_stage = '';
        sort_graph_leads(date,form_date,to_date,date_year,deal_stage);
        
      }
      function change_leadto_date()
      {
        var date = '';
        var form_date = $("#leads_sortFrom").val();
        var to_date = $("#leads_sortTo").val();
		var date_year = $("#deals_year_filter").val();
		var deal_stage = '';
        sort_graph_leads(date,form_date,to_date,date_year,deal_stage);
        
      }
	  function change_deals_stage()
      {
        var date_year = $("#deals_year_filter").val();
		var date = '';
        var form_date = '';
        var to_date = '';
	    var deal_stage = $("#deals_stage_filter").val();
        sort_graph_leads(date,form_date,to_date,date_year,deal_stage);
        
      }
    
  </script>
<?php //Lead Graph Ends ?>
<?php //Opportunity Graph Starts ?>
<script>

		getChartData();
		function getChartData(filterStage){
		var filterDate  = $("#pipevalue_date_filter").val();
		var filterYear  = $("#pipevalue_year_filter").val();
		//var filterStage = $("#pipevalue_stage_filter").val();
		var filterFrom  = $("#pipevalue_sortFrom").val();
		var filterTo    = $("#pipevalue_sortTo").val();
		
		var url = "<?php echo base_url();?>pipeline_performance/getdata_pipelineValue";
		var chart;
		$.ajax({
		  url : url,
		  method: "POST",
		  dataType : 'JSON',
		  data : {'searchDate' : filterDate,'filterYear':filterYear,'filterStage':filterStage,'filterFrom':filterFrom,'filterTo':filterTo},
		  success: function(data)
		  {  
			console.log(data);	  
			var month_name = [];
			var sub_total_pipeline = [];
			var total_weighted =[];
			for(var i in data){
              month_name.push(data[i].month_name);
    		  sub_total_pipeline.push(data[i].sub_total);
			  total_weighted.push(data[i].weighted_revenue);
        }
        var options = {
          series: [{
          name: 'Pipeline Amount',
          data: sub_total_pipeline
        }, {
       
          name: 'Weighted Revenue',
          data: total_weighted
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'flat'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: month_name,
		  title : {
            text: 'Month'
          }
        },
        yaxis: {
          title: {
            text: '(Indian Ruppes)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              //return "$ " + val + " thousands"
			  return "Total Amount: ₹" + val + " /-"
            }
          }
        }
        };

        $("#opp_pipegraph").html('');
        var chart = new ApexCharts(document.querySelector("#opp_pipegraph"), options);
        chart.render();
		},
      error: function(data)
      {
        console.log(data);
      }
    });
	
   }

      function change_pipevalue_stage()
      {
        var filterStage = $("#pipevalue_stage_filter").val();
		
        getChartData(filterStage);
        
      }
 
     
    
     
</script>
<?php //Opportunity Graph Ends  ?>
<?php // Quotation Graph Starts ?>
  <script>
  
		function getfunnelChartData(){
		var filterDate  = $("#funnel_date_filter").val();
		//var filterYear  = $("#pipevalue_year_filter").val();
		var filterStage = $("#funnel_stage_filter").val();
		var filterFrom  = $("#funnel_sortFrom").val();
		var filterTo    = $("#funnel_sortTo").val();
		//alert(filterDate);
		//alert(filterStage);
		var url = "<?php echo base_url();?>pipeline_performance/getdata_pipelineFunnel";
		var chart;
		$.ajax({
		  url : url,
		  method: "POST",
		  dataType : 'JSON',
		  data : {'searchDate' : filterDate,'filterStage':filterStage,'filterFrom':filterFrom,'filterTo':filterTo},
		  success: function(datasucess)
		  {   
          if(datasucess!='201'){	
          $("#chartContainer").html('');		  
		 // var objs =  '[' + datasucess + ']';       
		  var obj = eval('(' + datasucess + ')');                                                     
		  sucesschart(obj); 
		  }else{
			$("#chartContainer").html('<text style="text-align:center;margin:387px;font-size:36px;">No data available</text>');  
		  }	  
          
		  }
		  
		});
	}
  
      /*function change_funnel_stage()
      {
        var filterStage = $("#funnel_stage_filter").val();
		
        getfunnelChartData(filterStage);
        
      }*/
	  
	 
	  function sucesschart(result){
		  var testdata = result;	  
		  var chart = new CanvasJS.Chart("chartContainer", {
			animationEnabled: true,
			exportEnabled: true,
			theme: "light2", //"light1", "dark1", "dark2"
			title:{
				text: "How is funnel progression?"
			},
			data: [{
				type: "funnel",
				indexLabelPlacement: "inside",
				indexLabelFontColor: "white",
				toolTipContent: "<b>Sales Stage</b>:{label} <br/> Amount: ₹{y}  <br/> Opportunity: {total}",
				indexLabel: "{label}  {y}",
				dataPoints: testdata
			}]
		
		});
		//calculatePercentage();
		chart.render();
	
	  }
  
 /*window.onload = function () {

}*/
  
  </script>
  
<?php // Quotation Graph Ends ?>
<?php // Salesorder Graph Starts ?>
  <script>
 
		function getChartPipeactivity(){
		var filterDate  = $("#pipeactivity_date_filter").val();
		var filterYear  = $("#pipeactivity_year_filter").val();
		var filterStage = $("#pipeactivity_stage_filter").val();
		var filterFrom  = $("#pipeactivity_sortFrom").val();
		var filterTo    = $("#pipeactivity_sortTo").val();
		
		var url = "<?php echo base_url();?>pipeline_performance/getdata_pipelineActivity";
		
		//var chart;
		$.ajax({
		  url : url,
		  method: "POST",
		  dataType : 'JSON',
		  data : {'searchDate' : filterDate,'filterYear' : filterYear,'filterStage':filterStage,'filterFrom':filterFrom,'filterTo':filterTo},
		  success: function(resultdata)
		  {   
		   console.log(resultdata);
		  //alert(resultdata);
		    if(resultdata!='201')
			{	
			  $("#chartPipeactivity").html('');		  			      
			  var obj = eval('(' + resultdata + ')')                                                     
			  sucessActivitychart(obj); 
			}else{
				$("#chartPipeactivity").html('<text style="text-align:center;margin:387px;font-size:36px;">No data available</text>');  
			}
		  }
		  
		});
	}
	
	function sucessActivitychart(result)
	{
		//console.log(result);
	    var testdata = result;
		//alert(testdata);
		var chart = new CanvasJS.Chart("chartPipeactivity", {
		animationEnabled: true,
		zoomEnabled: true,
		exportEnabled: true,
		theme: "light2",
		title:{
			text: "Are big deals getting the right attention?"
		},
		legend: {
        horizontalAlign: "right",
        verticalAlign: "center"
        },
		axisX: {
			title:"Month",
			//toolTipContent: "{label}"
			/*suffix: "%",
			minimum:'0' ,
			maximum: '100',
			gridThickness: 1*/
			
			labelFormatter: function (e) {
                var xLabelFormat = '';
                if (e.value == 1) {
                    xLabelFormat = "January ";
                } else if (e.value == 2) {
                    xLabelFormat = "February ";
                } else if (e.value == 3) {
                    xLabelFormat = "March";
                } else if (e.value == 4) {
                    xLabelFormat = "April";
                } else if (e.value == 5) {
                    xLabelFormat = "May";
                
				} else if (e.value == 6) {
                    xLabelFormat = "June";
                
				} else if (e.value == 7) {
                    xLabelFormat = "July";
                
				} else if (e.value == 8) {
                    xLabelFormat = "August";
                
				} else if (e.value == 9) {
                    xLabelFormat = "Septmber";
                
				} else if (e.value == 10) {
                    xLabelFormat = "October";
                } else if (e.value == 11) {
                    xLabelFormat = "November";
                } else if (e.value == 12) {
                    xLabelFormat = "December";
                }
                return xLabelFormat;
            },
		},
		axisY:{
			title: "Opportunity Amount(₹)",
			//suffix: "mn"
		},
		data: [{
			type: "bubble",		
			toolTipContent: "<b>Opportunity Name:</b> {onam}<br/>Opportunity Amount: {y} <br/> Sales Stage: {stage}  <br/> Expected Closed Date: {cdate}",
			
			dataPoints: testdata

		}]
	});
	chart.render();
	}
    /* function change_funnel_stage()
      {
        var filterStage = $("#funnel_stage_filter").val();
		
        getfunnelChartData(filterStage);
        
      }*/

 
 
        
     
  </script>
<?php // Salesorder Graph Ends ?>
<?php // PurchaseOrder Graph Starts ?>
<script>
  
    /*var purchseGraph;
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
        */
    
   
  
</script>
<?php // PurchaseOrder Grapg Ends ?>
<script>
  $(document).ready()
  {
    //$("#leads_data").hide();
    $("#Opportunity_data").hide();
    $("#Quotation_data").hide();
    $("#Salesorder_data").hide();
    $("#Purchaseorder_data").hide();
    $("#Profit_table_data").hide();
    $("#Profit_table_data_pro").hide();
    $("#lead_li").addClass('active');
  }
  
  function change_nav(data)
  {
    if(data == "Lead")
    {
      $("#lead_li").addClass('active');
      $("#opp_li").removeClass('active');
      $("#quote_li").removeClass('active');
      $("#so_li").removeClass('active');
      $("#po_li").removeClass('active');
      $("#prof_table,#prof_table_pro_wise").removeClass('active');
      $("#leads_data").show();
      $("#Opportunity_data").hide();
      $("#Quotation_data").hide();
      $("#Salesorder_data").hide();
      $("#Purchaseorder_data").hide();
      $("#Profit_table_data, #Profit_table_data_pro").hide();
    }
    else if(data == "Opportunity")
    {
      $("#lead_li").removeClass('active');
      $("#opp_li").addClass('active');
      $("#quote_li").removeClass('active');
      $("#so_li").removeClass('active');
      $("#po_li").removeClass('active');
      $("#prof_table,#prof_table_pro_wise").removeClass('active');
      $("#leads_data").hide();
      $("#Opportunity_data").show();
      $("#Quotation_data").hide();
      $("#Salesorder_data").hide();
      $("#Purchaseorder_data").hide();
      $("#Profit_table_data,#Profit_table_data_pro").hide();
    }
    else if(data == "Quotation")
    {
		getfunnelChartData();
      $("#lead_li").removeClass('active');
      $("#opp_li").removeClass('active');
      $("#quote_li").addClass('active');
      $("#so_li").removeClass('active');
      $("#po_li").removeClass('active');
      $("#prof_table,#prof_table_pro_wise").removeClass('active');
      $("#leads_data").hide();
      $("#Opportunity_data").hide();
      $("#Quotation_data").show();
      $("#Salesorder_data").hide();
      $("#Purchaseorder_data").hide();
      $("#Profit_table_data, #Profit_table_data_pro").hide();
    }
    else if(data == "SalesOrder")
    {
		getChartPipeactivity();
      $("#lead_li").removeClass('active');
      $("#opp_li").removeClass('active');
      $("#quote_li").removeClass('active');
      $("#so_li").addClass('active');
      $("#po_li,#prof_table_pro_wise").removeClass('active');
      $("#prof_table").removeClass('active');
      $("#leads_data").hide();
      $("#Opportunity_data").hide();
      $("#Quotation_data").hide();
      $("#Salesorder_data").show();
      $("#Purchaseorder_data").hide();
      $("#Profit_table_data,#Profit_table_data_pro").hide();
    }
    else if(data == "PurchaseOrder")
    {
      $("#lead_li").removeClass('active');
      $("#opp_li").removeClass('active');
      $("#quote_li").removeClass('active');
      $("#so_li").removeClass('active');
      $("#po_li").addClass('active');
      $("#prof_table,#prof_table_pro_wise").removeClass('active');
      $("#leads_data").hide();
      $("#Opportunity_data").hide();
      $("#Quotation_data").hide();
      $("#Salesorder_data").hide();
      $("#Purchaseorder_data").show();
      $("#Profit_table_data,#Profit_table_data_pro").hide();
    }
    else if(data == "Profit_table")
    {
      $("#lead_li").removeClass('active');
      $("#opp_li").removeClass('active');
      $("#quote_li").removeClass('active');
      $("#so_li").removeClass('active');
      $("#po_li,#prof_table_pro_wise").removeClass('active');
      $("#prof_table").addClass('active');
      $("#leads_data").hide();
      $("#Opportunity_data").hide();
      $("#Quotation_data").hide();
      $("#Salesorder_data").hide();
      $("#Purchaseorder_data,#Profit_table_data_pro").hide();
      $("#Profit_table_data").show();
	  
    }else if(data == "Profit_table_pro")
    {
     
      $("#po_li, #prof_table,#so_li,#quote_li,#opp_li, #lead_li").removeClass('active');
      $("#prof_table_pro_wise").addClass('active');
      $("#leads_data,#Opportunity_data,#Quotation_data,#Salesorder_data,#Purchaseorder_data, #Profit_table_data").hide();
     
      $("#Profit_table_data_pro").show();
    }
	
	
    
  }
</script>