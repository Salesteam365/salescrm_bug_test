<?php $this->load->view('common_navbar'); ?>

<style type="text/css">
  
  .achieved_red {
    color: #e85f7c !important;
  }

  .achieved_orange {
    color: orange !important;
  }

  .achieved_green {
    color: green !important;
  }
  .form-control{
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    border:none;
    border-radius:10px;
    background:white;
  }
  .form-control option{
    /* box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; */

  }
  .card{
    background-color:rgba(250,254,255,0.7);
    padding-bottom:0px;
    border-radius:7px;
  }
  .topdashicons img{
    padding:10px;
    background:rgba(150,250,0,0.1);
    border-radius:5px;
    
  }
 
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background:rgba(250,250,253,0.8);">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url() . "home"; ?>#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard test</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">

    <!-- <div class="container-fluid">
      <div class="row">
        <div class="col-6">
           <div class="col-md-6">
              
               <a href="<?= base_url() ?>organizations">
            <div class="small-box">
              <div class="inner animate__animated animate__flipInX">
                <h5 style="color:grey;">Customers</h5>
                <h3 style="color:grey; "><?= $total_org['total_org']; ?></h3>
              </div>
              <div class="icon topdashicons">
                <img src="https://img.icons8.com/ios/80/000000/non-profit-organisation.png">
              </div>
              
            </div>
          </a>
               
            </div>
            <div class="col-md-6">
               <div class="card">
                
                </div>
            </div>
            <div class="col-md-3">
               <div class="card">
                
                </div>
            </div>
            <div class="col-md-3">
              <div class="card">
                
                </div>
            </div>
</div>
       </div>
    </div> -->
  
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <?php //////////////////////// Organization card ///////////// 
        ?>

        <div class="col-lg-3 col-6">
          <a href="<?= base_url() ?>organizations">
            <div class="small-box bg-info grey orange">
              <div class="inner animate__animated animate__flipInX">
                <h4>Customers</h4>
                <h3><?= $total_org['total_org']; ?></h3>
              </div>
              <div class="icon">
                <img src="https://img.icons8.com/ios/80/000000/non-profit-organisation.png">
              </div>
            </div>
          </a>
        </div>

        <?php //////////////////////// Organization card ///////////// 
        ?>
        <!-- ./col -->

        <?php //////////////////////// Leads card ///////////// 
        ?>
        <div class="col-lg-3 col-6">
          <a href="<?= base_url() ?>leads">
            <div class="small-box bg-success grey green">
              <div class="inner animate__animated animate__flipInX">
                <h4>Leads</h4>
                <h3><?= $total_leads['total_leads']; ?></h3>
              </div>
              <div class="icon">
                <img src="https://img.icons8.com/ios/50/000000/omnichannel.png">
              </div>
            </div>
          </a>
        </div>
        <?php //////////////////////// Leads card ///////////// 
        ?>
        <!-- ./col -->

        <?php //////////////////////// Opportunity card ///////////// 
        ?>
        <div class="col-lg-3 col-6">
          <a href="<?= base_url() ?>opportunities">
            <div class="small-box bg-warning grey pink">
              <div class="inner animate__animated animate__flipInX">
                <h4>Opportunities</h4>

                <h3><?= $total_opp['total_opp']; ?></h3>
              </div>
              <div class="icon">
                <img src="https://img.icons8.com/ios/40/000000/new-job.png">
              </div>
            </div>
          </a>
        </div>
        <!-- ./col -->

        <?php //////////////////////// Quotation card ///////////// 
        ?>
        <div class="col-lg-3 col-6">
          <a href="<?= base_url() ?>quotation">
            <div class="small-box bg-danger grey bluee">
              <div class="inner animate__animated animate__flipInX">
                <h4>Quotations</h4>
                <h3><?= $total_quotes['total_quotes']; ?></h3>
              </div>
              <div class="icon">
                <img src="https://img.icons8.com/pastel-glyph/64/000000/hot-price--v2.png">
              </div>
            </div>
          </a>
        </div>
        <!-- ./col -->
        <?php //////////////////////// Quotation card ///////////// 
        ?>
      </div>
      <!-- /.row -->


      <?php if ($this->session->userdata('type') == 'standard') { ?>
        <?php foreach ($bestTrgtuser as $key => $value) { ?>
          <div class="row">
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-info grey animate__animated animate__slideInLeft">

                <div class="inner row pt-3">

                  <div class="col-sm-5 text-right">
                    <h4>Sales Quota</h4>
                  </div>
                  <div class="col-sm-2 text-center">
                    <h4> - </h4>
                  </div>
                  <div class="col-sm-5 text-left">
                    <h4 id="sales_quota1" style="font-weight: bolder;"><?php echo IND_money_format($value->sales_quota); ?>/-</h4>
                  </div>
                </div>

                <div class="inner row">
                  <div class="col-sm-5 text-right">
                    <h4>Sales Achievement</h4>
                  </div>
                  <div class="col-sm-2 text-center">
                    <h4> - </h4>
                  </div>

                  <div class="col-sm-5 text-left">

                    <?php
                    if (!empty($bestTrgtuser)) {
                      $target = $value->sales_quota;
                      $achieved = $value->after_discount;
                      $achieved_percent = $achieved / $target * 100;
                    }
                    ?>
                    <?php
                    if (!empty($bestTrgtuser)) {
                      if ($achieved_percent < 75) {
                        $class = 'achieved_red';
                      } else if ($achieved_percent >= 75 && $achieved_percent < 100) {
                        $class = 'achieved_orange';
                      } else if ($achieved_percent >= 100) {
                        $class = 'achieved_green';
                      }
                    }
                    ?>
                    <?php if (!empty($bestTrgtuser)) { ?>
                      <h4 class="<?= $class; ?>"><b> <span class="<?= $class; ?>" id="sales_achieved2"></span><?php echo IND_money_format($value->after_discount); ?> /-</b><span> (<?= round($achieved_percent, 2); ?>%)</span></h4>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>


            <!-- ./col -->
            <div class="col-lg-6 col-6">
              <!-- small box -->
              <div class="small-box bg-info grey animate__animated animate__slideInDown">
                <div class="inner row pt-3">
                  <div class="col-sm-5 text-right">
                    <h4>Profit Quota</h4>
                  </div>
                  <div class="col-sm-2 text-center">
                    <h4> - </h4>
                  </div>
                  <div class="col-sm-5 text-left">
                    <h4 id="profit_quota3" style="font-weight: bolder;"><?php echo IND_money_format($value->profit_quota); ?>/-</h4>
                  </div>
                </div>

                <input type="hidden" id="so_after_discount" value="<?= $profit_quota['after_discount']; ?>">
                <input type="hidden" id="po_after_discount" value="<?= $profit_quota['after_discount_po']; ?>">

                <div class="inner row">
                  <div class="col-sm-5 text-right">
                    <h4>Profit Achievement</h4>
                  </div>
                  <div class="col-sm-2 text-center">
                    <h4> - </h4>
                  </div>
                  <?php
                  $so_total = $profit_quota['after_discount'];
                  $po_total = $profit_quota['after_discount_po'];
                  $profit_quota = $value->profit_by_user; //$so_total - $po_total; 
                  $target = $value->profit_quota;
                  $achieved =  $profit_quota;
                  $achieved_percent = $achieved / $target * 100;
                  ?>
                  <?php if ($achieved_percent < 75) {
                    $class = 'achieved_red';
                  } else if ($achieved_percent >= 75 && $achieved_percent < 100) {
                    $class = 'achieved_orange';
                  } else if ($achieved_percent >= 100) {
                    $class = 'achieved_green';
                  } ?>


                  <div class="col-sm-5 text-left">
                    <h4 class="<?= $class; ?>"><b> <span class="<?= $class; ?>" id="profit_achieved4"></span><?php echo IND_money_format($value->profit_by_user); ?> /-</b><span> (<?= round($achieved_percent, 2); ?>%)</span></h4>
                  </div>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
        <?php } ?>
      <?php } ?>
      <!-- Main row -->

      <!-- Main row -->
      <div class="row">
        <section class="col-xl-6 connectedSortable" >
          <?php /// SO Profit Graph Start  /////// 
          ?>
          <div class="card animate__animated animate__slideInUp" style="background-color:rgba(250,254,255); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius:7px;" >
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Profit from sales orders
              </h3>
              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="profit_filter_new" id="profit_filter_new" onchange="getChartData(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="so_frofit_year" id="so_frofit_year" onchange="getChartData(); return false;">
                      <?php foreach ($dateyrGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create("01-01-" . $dataU);
                        // $year = date_format($date, "Y");
                        $year = ($date!=null) ? date_format($date, "Y") : null ;
                      ?>
                        <option value="<?= $year; ?>" <?=(date('Y') == $year)?"selected":null;?>> <?= $year; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="so_frofit_month" id="so_frofit_month" onchange="getChartData(); return false;">
                      <option value="">Select Month</option>
                      <?php foreach ($datemnthGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create('01-' . $dataU . '-2020');
                        // $dayMnt = date_format($date, "F");
                        // $dayMnt2 = date_format($date, "m");
                        $dayMnt  = ($date!=null) ? date_format($date, "F") : null ;
                        $dayMnt2 = ($date!=null) ? date_format($date, "m") : null ;
                      ?>
                        <option value="<?= $dayMnt2; ?>" <?php if (date('F') == $dayMnt) {
                                                          echo "selected";
                                                        } ?>><?php echo $dayMnt; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

              </div>

              <div class="tab-content p-0">
                <div id="profit"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php /////////////////////  Profit Graph Ends ////////////////  
          ?>
        </section>
        <!-- ///////////////////////////////////////////////////////////////////////////////// -->
                   
        <!-- ////////////////////////////////////////////////////////////////////////////////////////// -->
        <section class="col-xl-6 connectedSortable">
          <div class="card animate__animated animate__slideInUp" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Profit from purchase orders
              </h3>
              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>

                <button type="button" class="btn bg-purple btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="po_profit_date" id="po_profit_date" onchange="getChartDataPoProfit(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="po_profit_year" id="po_profit_year" onchange="getChartDataPoProfit(); return false;">
                      <?php foreach ($dateyrGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create("01-01-" . $dataU);
                        // $year = date_format($date, "Y");
                        $year = ($date!=null) ? date_format($date, "Y") : null ;

                      ?>
                        <option value="<?= $year; ?>" <?php if (date('Y') == $year) {
                                                      echo "selected";
                                                    } ?>><?php echo $year; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="po_profit_month" id="po_profit_month" onchange="getChartDataPoProfit(); return false;">
                      <?php foreach ($datemnthGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create('01-' . $dataU . '-2020');
                        // $dayMnt = date_format($date, "F");
                        // $dayMnt2 = date_format($date, "m");
                        $dayMnt  = ($date!=null) ? date_format($date, "F") : null ;
                        $dayMnt2 = ($date!=null) ? date_format($date, "m") : null ;
                      ?>
                        <option value="<?= $dayMnt2; ?>" <?php if (date('F') == $dayMnt) {
                                                          echo "selected";
                                                        } ?>><?php echo $dayMnt; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="tab-content p-0">
                <div id="purchase_profit_graph" style="height:365px"></div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

      <section class="col-xl-12 connectedSortable">
          <?php /// SO Profit Graph Start  /////// 
          ?>
          <div class="card animate__animated animate__slideInUp" style="background-color:rgba(250,254,255); box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius:7px;" >
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
               Top ten Customers
              </h3>
              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-3">
                  <div class="first-one">
                    <select class="form-control" name="topcus_filter" id="topcus_filter" onchange="gettoptencus(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="first-one">
                    <select class="form-control" name="topcus_year" id="topcus_year" onchange="gettoptencus(); return false;">
                      <?php foreach ($dateyrGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create("01-01-" . $dataU);
                        // $year = date_format($date, "Y");
                        $year = ($date!=null) ? date_format($date, "Y") : null ;
                      ?>
                        <option value="<?= $year; ?>" <?=(date('Y') == $year)?"selected":null;?>> <?= $year; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                
                <div class="col-lg-3">
                  <div class="first-one">
                    <select class="form-control" name="topcus_month" id="topcus_month" onchange="gettoptencus(); return false;">
                      <option value="">Select Month</option>
                      <?php foreach ($datemnthGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create('01-' . $dataU . '-2020');
                        // $dayMnt = date_format($date, "F");
                        // $dayMnt2 = date_format($date, "m");
                        $dayMnt  = ($date!=null) ? date_format($date, "F") : null ;
                        $dayMnt2 = ($date!=null) ? date_format($date, "m") : null ;
                      ?>
                        <option value="<?= $dayMnt2; ?>" <?php if (date('F') == $dayMnt) {
                                                          echo "selected";
                                                        } ?>><?php echo $dayMnt; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3">
                  <div class="first-one">
                    <select class="form-control" name="Financial_year" id="Financial_year" onchange="gettoptencus(); return false;">
                    <option value="">Select Financial year</option>

                      <?php foreach ($dateyrGraph as $key => $value) {
                        $dataU = $value->month;
                        $date = date_create("01-01-" . $dataU);
                        // $year = date_format($date, "Y");
                        $year = ($date!=null) ? date_format($date, "Y") : null ;
                      ?>
                        <option value="<?= $year; ?>" <?=(date('Y') == $year)?"selected":null;?>> <?= $year; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="tab-content p-0">
                <div id="toptencuschart"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          <?php /////////////////////  Profit Graph Ends ////////////////  
          ?>
        </section>

      <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
      <!--  PROFIT SCORE GRAPH..    -->
      <div class="row">
        <section class="col-lg-6 connectedSortable" >
          <div class="card direct-chat direct-chat-primary" style="min-height: 445px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-table mr-1"></i>
                Your profit score of this month
              </h3>
              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="direct-chat-messages" style="height: auto;">
                <table style="width: 100%;">
                  <tr>
                    <td style="text-align: center; padding: 2px;">
                      <text class="font-weight-bold"> Sales Quota :</text> ₹ <text id="ptSlq">0.00</text>

                    </td>
                    <td style="text-align: center; padding: 2px;">
                      <text class="font-weight-bold"> Profit Quota :</text> ₹ <text id="ptProq"></text>

                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: center; padding: 2px;">

                      <text class="font-weight-bold"> Achieved Sales : </text>₹ <text id="ptAchSlq">0.00</text>

                    </td>
                    <td style="text-align: center; padding: 2px;">
                      <text class="font-weight-bold"> Achieved Profit :</text> ₹ <text id="ptAchProq">0.00</text>

                    </td>
                  </tr>
                  <tr>
                    <td style="text-align: -webkit-center;" class="border-right">
                      <figure class="highcharts-figure">
                        <div id="containerScore" class="chart-container"></div>
                      </figure>
                      <!-- <div class="chart-container" id="gaugechart"></div> -->
                    </td>
                    <td style="text-align: -webkit-center;">
                      <figure class="highcharts-figure">
                        <div id="containerScoreProfit" class="chart-container"></div>
                      </figure>
                    <!-- <div class="chart-container" id="gaugechart2"></div> -->


                    </td>
                  </tr>
                </table>

              </div>

            </div>

          </div>
        </section>

        <section class="col-lg-6 connectedSortable">
          <?php ///////// Tpo Opportunity Graph Ends ////////// 
          ?>
          <div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">

            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Top opportunities this month
              </h3>
            </div>

            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="opportunity_filter" id="opportunity_filter" onchange="change_opportunity(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                <canvas id="topOpportunity" width="200" height="0"></canvas>
              </div>
            </div>

          </div>
          <?php /////// Top Opportunity Graph Ends //////////  
          ?>
        </section>
      </div>

      <div class="row">
        <section class="col-lg-6 connectedSortable">
          <?php ////// Salesorder Graph Starts /////// 
          ?>
          <div class="card  animate__animated animate__slideInLeft" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Sales order this month
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="salesorder_filter" id="salesorder_filter" onchange="change_salesorder(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                <!-- <canvas id="salesorders" width="200" height="0"></canvas> -->
                <div id="salesorders" style="width:100%; display:flex; justify-content:center;"></div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </section>

        <section class="col-lg-6 connectedSortable">

          <?php //// Estimate Sales Graph Starts ////// 
          ?>
          <div class="card animate__animated animate__fadeInRight" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Estimated sales this month
              </h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-lg-4">
                  <div class="first-one">
                    <select class="form-control" name="estimate_filter" id="estimate_filter" onchange="change_estimate_sales(); return false;">
                      <option selected value="">Select Option</option>
                      <?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('Y-m-d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('Y-m-d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('Y-m-d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('Y-m-d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('Y-m-d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('Y-m-d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('Y-m-d', $one_year); ?>">Last 1 Year</option>
                    </select>
                  </div>
                </div>

              </div>
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                  <!-- <canvas id="estimates" width="200" height="0"></canvas> -->
               <div id="estimates" style="display:flex; justify-content:center;"></div>

                </div>
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer bg-transparent" style="display: none;">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->
          <?php ////// Estimate Sales Graph Ends /////// 
          ?>
        </section>
      </div>
      <div class="row">
        <section class="col-lg-6 connectedSortable">
          <div class="card direct-chat direct-chat-primary" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header">

              <h3 class="card-title">
                <i class="fas fa-table mr-1"></i>
                Profit of this financial year
                <?php $fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
                $dateToGet = explode(':', $fiscal_year_for_date);
                $date = date_create($dateToGet[0]);
                $date2 = date_create($dateToGet[1]);
                echo date_format($date, "Y") . "-" . date_format($date2, "Y");

                ?>
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="direct-chat-messages" style="height: 395px;">
                <table id="profit_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead  style="background:rgba(35,0,140,0.8)">

                    <tr>
                      <th class="th-sm">Owner</th>
                      <th class="th-sm">So Value</th>
                      <th class="th-sm">PO value</th>
                      <th class="th-sm">Profit</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>

              </div>

            </div>

          </div>
        </section>

        <section class="col-lg-6 connectedSortable">
          <?php /// Lead Assigned Data Starts ///////// 
          ?>
          <div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
            <div class="card-header" >
              <h3 class="card-title">
                <i class="fas fa-table mr-1"></i>
                Latest assigned leads
              </h3>

              <div class="card-tools">
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="collapse" >
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn bg-purple btn-sm" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body" style="color: #000;">
              <table class="table table-hover">
                <thead style="background:rgba(35,0,140,0.8)">
                  <tr>
                    <th>Lead&nbsp;ID</th>
                    <th>Assigned&nbsp;To</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($leads)) {
                    foreach ($leads as $lead) { ?>
                      <tr>
                        <td><?= $lead['lead_id'] ?></td>
                        <td><?= $lead['assigned_to_name'] ?></td>
                        <?php if ($lead['lead_status'] != "In Progress" && $lead['lead_status'] != "Closed Won" && $lead['lead_status'] != "Closed Lost") { ?>
                          <td>
                            <div style="font-size:12px;margin:0;padding:5px;background-image: linear-gradient(rgba(250,150,250,0.6),blue);border-radius: .25rem;color: #fff;letter-spacing: .5px;"><?= $lead['lead_status'] ?></div>
                          </td>
                        <?php } elseif ($lead['lead_status'] == "In Progress") { ?>
                          <td>
                            <div style="font-size:12px;margin:0;padding:5px;background-image: linear-gradient(rgba(100,150,250,0.8),cyan);border-radius: .25rem;color: #fff;letter-spacing: .5px;"><?= $lead['lead_status'] ?></div>
                          </td>
                        <?php } elseif ($lead['lead_status'] == "Closed Won") { ?>
                          <td>
                            <div class="alert alert-success" style="font-size:12px;margin:0;padding:5px;border-radius: .25rem;"><?= $lead['lead_status'] ?></div>
                          </td>
                        <?php } elseif ($lead['lead_status'] == "Closed Lost") { ?>
                          <td>
                            <div style="font-size:12px;margin:0;padding:5px;background-color: #FF6384;border-radius: .25rem;color: #fff;letter-spacing: .5px;"><?= $lead['lead_status'] ?></div>
                          </td>
                        <?php } ?>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>
<!-- /.content-wrapper -->


<?php if (check_permission_status('Salesorders', 'retrieve_u') == true) : ?>

  <?php //SalesOrder Renewal Modal Starts 
  ?>
  <div class="modal fade" id="sales_alert" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title sales_alert">Renewal&nbsp;Alert </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body form">
          <!-- <button class="btn btn-secondary float-right" onclick="reload_notify_table()"><i class="fas fa-sync-alt"></i></button> -->
          <table class="table">
            <thead style="background:rgb(120,50,240);">
              <tr>
                <th>SO&nbsp;Id</th>
                <th>Subject</th>
                <th>Organization&nbsp;Name</th>
                <th>Renewal&nbsp;Date</th>
                <th>Owner</th>
                <th>Action</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="notify_table">
              <?php $cnt = 0;
              if (!empty($renewal_data)) {
                foreach ($renewal_data as $renew) {
                  $cnt = 1; ?>
                  <tr>
                    <td><?= end(explode('/',$renew['saleorder_id'])); ?></td>
                    <td><?= $renew['subject']; ?></td>
                    <td><?= $renew['org_name']; ?></td>
                    <td><?= date("d/m/Y", strtotime($renew['renewal_date'])); ?></td>
                    <td><?= $renew['owner']; ?></td>
                    <td>
                      <button class="btn btn-primary btn-sm" onclick="view_so(<?= $renew['id']; ?>);">View</button>
                    </td>
                    <td><button class="btn btn-danger btn-sm" onclick="end_renewal(<?= $renew['id']; ?>);">End</button></td>
                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php //Purchaseorder Renewal Modal Ends 
  ?>
<?php endif; ?>


<?php $this->load->view('footer'); ?>
</div>
<!-- ./wrapper -->
<style>
  .highcharts-figure .chart-container {
    width: 250px;
    height: 230px;
  }

  .highcharts-data-table tr:hover {
    background: #f1f7ff;
  }
</style>
<!-- common footer include -->
<?php $this->load->view('common_footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>



<script>
  $(document).ready(function() {
    var countRn = '<?php echo $cnt; ?>';
    if (countRn > 0) {
      $("#sales_alert").modal('show');
    }
  });

  function end_renewal(id) {
    $.ajax({
      url: '<?= site_url("salesorders/end_renewal") ?>',
      method: 'post',
      data: {
        id: id
      },
      dataType: 'json',
      success: function(response) {
        $.ajax({
          url: '<?= site_url("salesorders/update_renewal_data") ?>',
          method: 'post',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {
            $("#notify_table").empty();
            var table;
            $.each(response, function(index, data) {
              table = "<tr><td>" + data['saleorder_id'] + "</td>" + "<td>" + data['subject'] + "</td>" + "<td>" + data['org_name'] + "</td>" + "<td>" + data['renewal_date'] + "</td>" + "" + "<td>" + data['owner'] + "</td>" + "<td><button class='btn btn-primary btn-sm' onclick='view_so(" + data['id'] + ")'>View</button></td>" + "<td><button class='btn btn-danger btn-sm' onclick='end_renewal(" + data['id'] + ")'>End</button></td>" + "</tr>";
              $("#notify_table").append(table);
            });
          }
        });
      }
    });
  }

  function view_so(sales_id) {
    window.location.href = "<?= base_url('salesorders/view_pi_so/'); ?>" + sales_id;
  }

  /////////////////////////////      You profit score  of  this month  statrts  ///////////////////////////////////////////////////////////////////////

// var options={
//   chart: {
//     height: 280,
//     type: "radialBar",
//   },

//   series: [6],
//   colors: ["#20E647"],
//   plotOptions: {
//     radialBar: {
//       hollow: {
//         margin: 0,
//         size: "70%",
//         background: "#293450"
//       },
//       track: {
//         dropShadow: {
//           enabled: true,
//           top: 2,
//           left: 0,
//           blur: 4,
//           opacity: 0.15
//         }
//       },
//       dataLabels: {
//         name: {
//           offsetY: -10,
//           color: "#fff",
//           fontSize: "13px"
//         },
//         value: {
//           color: "#fff",
//           fontSize: "30px",
//           show: true
//         }
//       }
//     }
//   },
//   fill: {
//     type: "gradient",
//     gradient: {
//       shade: "dark",
//       type: "vertical",
//       gradientToColors: ["#87D4F9"],
//       stops: [0, 100]
//     }
//   },
//   stroke: {
//     lineCap: "round"
//   },
//   labels: ["Progress"]
// };

// var chart = new ApexCharts(document.querySelector("#gaugechart"), options);

// chart.render();

// var options={
//   chart: {
//     height: 280,
//     type: "radialBar",
//   },

//   series: [67],
//   colors: ["#20E647"],
//   plotOptions: {
//     radialBar: {
//       hollow: {
//         margin: 0,
//         size: "70%",
//         background: "#293450"
//       },
//       track: {
//         dropShadow: {
//           enabled: true,
//           top: 2,
//           left: 0,
//           blur: 4,
//           opacity: 0.15
//         }
//       },
//       dataLabels: {
//         name: {
//           offsetY: -10,
//           color: "#fff",
//           fontSize: "13px"
//         },
//         value: {
//           color: "#fff",
//           fontSize: "30px",
//           show: true
//         }
//       }
//     }
//   },
//   fill: {
//     type: "gradient",
//     gradient: {
//       shade: "dark",
//       type: "vertical",
//       gradientToColors: ["#87D4F9"],
//       stops: [0, 100]
//     }
//   },
//   stroke: {
//     lineCap: "round"
//   },
//   labels: ["Progress"]
// };

// var chart2 = new ApexCharts(document.querySelector("#gaugechart2"), options);

// chart2.render();

 /////////////////////////////      You profit score  of  this month  ends  ///////////////////////////////////////////////////////////////////////

  function saleOrderScore(score, scoreDivId, text) {
    var gaugeOptions = {
      chart: {
        type: 'solidgauge',
      },

      title: null,

      pane: {
        center: ['50%', '85%'],
        size: '110%',
        startAngle: -90,
        endAngle: 90,
        background: {
          backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'rgba(60,180,250,0.14)',
          innerRadius: '60%',
          outerRadius: '100%',
          shape: 'arc',
     
          borderWidth:0
        }
        
      },

      exporting: {
        enabled: false
      },

      tooltip: {
        enabled: false
      },

      // the value axis
      yAxis: {
        stops: [
          ['#008ffb']
        ],
        lineWidth: 0,
        tickWidth: 0,
        minorTickInterval: null,
        tickAmount: 2,
        title: {
          y: -70
        },
        labels: {
          y: 16
        }
      },

      plotOptions: {
        solidgauge: {
          dataLabels: {
            y: 5,
            borderWidth: 0,
            useHTML: true
          }
        }
      }
    };

    
    // The speed gauge
    var chartSpeed = Highcharts.chart(scoreDivId, Highcharts.merge(gaugeOptions, {
      yAxis: {
        min: 0,
        max: 150,
        title: {
          text: 'Total ' + text + ' %'
        }
      },

      credits: {
        enabled: false
      },

      series: [{
        name: 'Speed',
        data: [score],
        dataLabels: {
          format: '<div style="text-align:center">' +
            '<span style="font-size:25px">{y} %</span><br/>' +
            '<span style="font-size:12px;opacity:0.4">' + text + ' Percentage</span>' +
            '</div>'
        },
        tooltip: {
          valueSuffix: text + ' %'
        }
      }]

    }));
  }

  var setData = 'profit Score';
  var urlP = "<?php echo base_url(); ?>/Sales_profit_target/getSalesOrderPer";

  $.ajax({
    url: urlP,
    method: "POST",
    dataType: 'JSON',
    data: {
      'getData': setData
    },
    success: function(data) {

      saleOrderScore(data.sales_score, 'containerScore', 'Sales');
      saleOrderScore(data.profit_score, 'containerScoreProfit', 'Profit');

      $("#ptSlq").html(numberToIndPrice(data.sales_quota));
      $("#ptAchSlq").html(numberToIndPrice(data.get_sales));
      $("#ptProq").html(numberToIndPrice(data.profit_quota));
      $("#ptAchProq").html(numberToIndPrice(data.get_profit));

    }
  });
</script>

<script>
//////////////////////////////////////////////////////////// //////////////////////   Top 10 customers  starts  ////////////////////////////////////////////////////////////////

function gettoptencus(){
    var company=[];
    var amount=[];
    var profit=[];
    var profitDate = $("#topcus_filter").val();
    var profitYear = $("#topcus_year").val();
    var profitMoth = $("#topcus_month").val();
    var financial_year = $("#Financial_year").val();

     $.ajax({
        url:'<?php echo base_url();?>/home/gettoptencus',
        method:'post',
        dataType:'JSON',
        data:{
          'searchDate': profitDate,
          'profitYear': profitYear,
          'profitMoth': profitMoth,
          'financial_year':financial_year
        },
        success:function(resp){
          $("#topcus_filter").val("");
          $("#Financial_year").val("");
          
          if (resp.toptencus) {
           resp.toptencus.forEach(function(item) {
              company.push(item.org_name);
              amount.push(item.total_subtotal);
              profit.push(item.totalprofit);
       });
    }


          var options = {
          series: [{
            name: 'Total Sales Price (₹)',
            data: amount,
            color: 'rgb(120,50,240)'
          }, {
            name: 'Total Net Profit (₹)',
            data: profit,
            color: 'rgb(10,200,255)'
          }],
          chart: {
            brush: {
        enabled: false,
        target: undefined,
        autoScaleYaxis: false
      },
            type: 'bar',

            // stacked: true,
            height: 350
          },
          plotOptions: {
            bar: {
              borderRadius:'5',
              horizontal: false,
              columnWidth: '42%',
              endingShape: 'flat'
            },
          },
         
          stroke: {
            // show: true,
            // curve:'smooth',
            width: 10,
            colors: ['transparent']
          },
          dataLabels: {
          enabled: false,
          
        },
        grid:{
          show:false
        },
          xaxis: {
            categories: company,
            title: {
              text: 'Users'
            },
          },
          yaxis: {
            title: {
              text: '(Indian Ruppes)'
            },
            labels: {
            formatter: (val) => {
              return val / 1000 + 'K'
            }
          }
          },
          fill: {
            opacity: 1,
          
          },
          tooltip: {
            y: {
              formatter: function(val) {
                return "" + numberToIndPrice(val) + "/-"
              }
            }
          },
    //       annotations: {
    //         position: 'front',
    // yaxis: [{
    //     y: '10%',
    //     x:'0%',
    //     borderColor: '#999',
    //     label: {
    //         text: 'Applied Filters: ' +
    //             (profitDate ? 'Date: ' + profitDate + ' | ' : '') +
    //             (profitYear ? 'Year: ' + profitYear + ' | ' : '') +
    //             (profitMoth ? 'Month: ' + profitMoth + ' | ' : '') +
    //             (financial_year ? 'Financial Year: ' + financial_year + ' | ' : ''),
    //         style: {
    //             color: '#fff',
    //             background: '#00E396',
    //             textAlign: 'center'
    //         },
    //     }
    // }]
    //     }
      };
       

        $("#toptencuschart").html('');
        var chart = new ApexCharts(document.querySelector("#toptencuschart"), options);
        chart.render();
       
        }
       
      

     })
}
gettoptencus();

//////////////////////////////////////////////////////////// //////////////////////   Top 10 customers  ends  ////////////////////////////////////////////////////////////////

  <?php /////// Profit Graph Admin //////  
  ?>

  $("#so_frofit_month").change(function() {
    $("#profit_filter_new").val('');
  });

  getChartData();

  function getChartData() {

    var profitDate = $("#profit_filter_new").val();
    var profitYear = $("#so_frofit_year").val();
    var profitMoth = $("#so_frofit_month").val();

    var url = "<?php echo base_url(); ?>/home/getdata";
    var chart;
    $.ajax({
      url: url,
      method: "POST",
      dataType: 'JSON',
      data: {
        'searchDate': profitDate,
        'profitYear': profitYear,
        'profitMoth': profitMoth
      },
      success: function(data) {

        var owner = [];
        var content =[];
        var sub_total_salesorder = [];
        var sub_initial_total = [];
        for (var i in data) {
          owner.push(data[i].owner);
          sub_total_salesorder.push(data[i].profit_by_user);
          sub_initial_total.push(data[i].initial_total);
        }
        
      for(var own of owner){
         var series = 
          {
            name:'Sales By '+own,
            group:'Sales',
            data:sub_total_salesorder,
          }

        
         
        content.push(series);
      }
       
        var options = {
          series: [{
            name: 'Total Sales Price (₹)',
            data: sub_initial_total,
            color: 'rgb(120,50,240)'
          }, {
            name: 'Total Net Profit (₹)',
            data: sub_total_salesorder,
            color: 'rgb(10,200,255)'
          }],
          chart: {
            brush: {
        enabled: false,
        target: undefined,
        autoScaleYaxis: false
      },
            type: 'bar',

            // stacked: true,
            height: 350
          },
          plotOptions: {
            bar: {
              borderRadius:'5',
              horizontal: false,
              columnWidth: '30%',
              endingShape: 'flat',
              color:'purple'
            },
          },
         
          stroke: {
            // show: true,
            // curve:'smooth',
            width: 4,
            colors: ['transparent']
          },
          dataLabels: {
          enabled: false,
          
        },
        grid:{
          show:false
        },
          xaxis: {
            categories: owner,
            title: {
              text: 'Users'
            },
            
           
          },
          yaxis: {
            title: {
              text: '(Indian Ruppes)'
            },
            labels: {
            formatter: (val) => {
              return val / 1000 + 'K'
            }
          }
          },
          fill: {
            opacity: 1,
            

          },
          tooltip: {
            y: {
              formatter: function(val) {
                return "" + numberToIndPrice(val) + "/-"
              }
            }
          }
        };
       

        $("#profit").html('');
        var chart = new ApexCharts(document.querySelector("#profit"), options);
        chart.render();
      },
      error: function(data) {
        //console.log(data);
      }
    });

  }

  getMonth();

  function getMonth() {
    $("#profit_filter_new").val('');
    var yearsDt = $('#so_frofit_year').val();
    url = "<?= site_url('home/getMonth') ?>";
    $.ajax({
      url: url,
      type: "POST",
      data: 'yearsDt=' + yearsDt,
      success: function(data) {
        $('#so_frofit_month').html(data);
        //getChartachiveData();
      }
    });
  }
  $('#so_frofit_year').change(function() {
    getMonth();
  });


  // Purchase Profit.....

  $("#po_profit_month").change(function() {
    $("#po_profit_date").val('');
  });

  getChartDataPoProfit();

  function getChartDataPoProfit() {
    var poProfitdate = $("#po_profit_date").val();
    var poProfitYear = $("#po_profit_year").val();
    var poProfitMonth = $("#po_profit_month").val();
    var url = "<?php echo base_url(); ?>home/get_purchase_profit_graph";
    var chart;
    $.ajax({
      url: url,
      method: "POST",
      dataType: 'JSON',
      data: {
        'searchDate': poProfitdate,
        'poProfitYear': poProfitYear,
        'poProfitMonth': poProfitMonth
      },
      success: function(data) {
        //console.log(data);
        var owner = [];
        var content=[];
        var sub_total_salesorder = [];
        for (var i in data) {
          owner.push(data[i].owner);
          sub_total_salesorder.push(data[i].profit_by_user_po);
        var series={
          name:data[i].owner,
          data:[data[i].profit_by_user_po,7],
        }
         content.push(series);
        }
       
        console.log(content); 
       
      
    
        var options = {
          series: [{
            name: 'Total Purchase Profit (₹)',
            data: sub_total_salesorder
          }],
          chart: {
            type: 'bar',
            height: 320
          },
          plotOptions: {
            bar: {
              borderRadius:10,
              horizontal: false,
              columnWidth: '20%',
              endingShape: 'flat'
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
          },
          grid:{
          show:false
        },
          xaxis: {
            categories: owner,
            title: {
              text: 'Users'
            }
          },
          yaxis: {
            
            title: {
              text: '(Indian Ruppes)'
            }
            
          },
          fill: {
            opacity: 1,
           
            
          },
          
          tooltip: {
            y: {
              formatter: function(val) {
                return "" + numberToIndPrice(val) + "/-"
              }
            }
          }
        };
      
        $("#purchase_profit_graph").html('');
        var chart = new ApexCharts(document.querySelector("#purchase_profit_graph"), options);
        chart.render();
      },
      error: function(data) {
        //console.log(data);
      }
    });

  }



  getMonthPo();

  function getMonthPo() {
    $("#po_profit_date").val('');
    var yearsDt = $('#po_profit_year').val();
    url = "<?= site_url('home/getMonth') ?>";
    $.ajax({
      url: url,
      type: "POST",
      data: 'yearsDt=' + yearsDt,
      success: function(data) {
        $('#po_profit_month').html(data);
      }
    });
  }
  $('#po_profit_year').change(function() {
    getMonthPo();
  });
</script>

<?php /////////////// Estimate Graph Starts ///////////////  
?>
<script>
  <?php if ($this->session->userdata('type') == "admin") { ?>
    var estimateGraph;
    $.ajax({
      url: "<?php echo base_url(); ?>home/getestimate",
      method: "GET",
      dataType: 'JSON',
      success: function(data) {
        
        var owner = [];
        var sub_totalq = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_totalq.push(parseInt(data[i].sub_totalq));
        }
        var options = {
          series:sub_totalq,
          labels:owner,
          chart: {
         width:450,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        title: {
          text: ''
        },
        responsive: [{
          breakpoint: 450,
          options: {
            chart: {
              width:290
            },
            legend: {
              position: 'top'
            }
          }
        }]
        };
        $("#estimates").html('');
        var chart = new ApexCharts(document.querySelector("#estimates"), options);
        chart.render();
        // var chartdata = {
        //   labels: owner,
        //   datasets: [{
        //     label: 'Total Amount',

        //     backgroundColor: [
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)'
        //     ],
        //     borderColor: [
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)'
        //     ],
        //     data: sub_totalq
        //   }]
        // };
        // var ctx = document.getElementById('estimates').getContext('2d');
        // estimateGraph = new Chart(ctx, {
        //   type: 'doughnut',
        //   data: chartdata
        // });
      },
      error: function(data) {
        //console.log(data);
      }
    });
  <?php } else if ($this->session->userdata('type') == "standard") {  ?>
    var estimateGraph;
    $.ajax({
      url: "<?php echo base_url(); ?>home/getestimate",
      method: "GET",
      dataType: 'JSON',
      success: function(data) {
        var owner = [];
        var sub_totalq = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_totalq.push(parseInt(data[i].sub_totalq));
        }
        var options = {
          series:sub_totalq,
          labels:owner,
          chart: {
         width:450,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        title: {
          text: ''
        },
        responsive: [{
          breakpoint: 320,
          options: {
            chart: {
              width:290
            },
            legend: {
              position: 'top'
            }
          }
        }]
        };
        $("#estimates").html('');
         estimateGraph = new ApexCharts(document.querySelector("#estimates"), options);
         estimateGraph.render();
        // var estimateGraph = chart;
  
      },
      error: function(data) {
        //console.log(data);
      }
    });
  <?php } ?>

  
//   function change_estimate_sales() {
//   var date = $("#estimate_filter").val();
//   $.ajax({
//     url: "<?php echo base_url(); ?>home/sort_estimate_graph",
//     method: "POST",
//     dataType: 'JSON',
//     data: {
//       'date': date
//     },
//     success: function(response) {
//       var owner = [];
//       var sub_totalq = [];
//       for (var i in response) {
//         owner.push(response[i].owner + ' (₹) ');
//         sub_totalq.push(parseInt(response[i].sub_totalq));
//       }

//       // Check if estimateGraph is defined and has the expected structure
//       if (estimateGraph && estimateGraph.data && estimateGraph.data.labels && estimateGraph.data.series) {
//         estimateGraph.updateSeries([{ data: sub_totalq }]);
//         estimateGraph.updateOptions({ labels: owner });
//       } else {
//         console.error('estimateGraph is not properly initialized or does not have the expected structure.');
//       }
//     },
//     error: function(jqXHR, textStatus, errorThrown) {
//       console.error('Ajax request failed:', textStatus, errorThrown);
//     }
//   });
// }
function change_estimate_sales() {
    var date = $("#estimate_filter").val();
    $.ajax({
      url: "<?php echo base_url(); ?>home/sort_estimate_graph",
      method: "POST",
      dataType: 'JSON',
      data: {
        'date': date
      },
      success: function(response) {
        //console.log(response);
        var owner = [];
        var sub_total = [];
        for (var i in response) {
          owner.push(response[i].owner + ' (₹) ');
          sub_total.push(parseInt(response[i].sub_totalq));
         
        }
        console.log(sub_total);
        var options = {
          series:sub_total,
          labels:owner,
          chart: {
         width:450,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        title: {
          text: ''
        },
        responsive: [{
          breakpoint: 320,
          options: {
            chart: {
              width:290
            },
            legend: {
              position: 'top'
            }
          }
        }]
        };
        $("#estimates").html('');
         var chart = new ApexCharts(document.querySelector("#estimates"), options);
         chart.render();
       
        // estimateGraph.options.labels = owner;
        // estimateGraph.options.datasets[0].data = sub_total;
        // estimateGraph.update();
      }
    });
  }
</script>
<?php ////// Estimate Graph Ends //////  
?>

<?php //////// Salesorder Graph Starts ////////////////  
?>
<script>
  change_salesorder();

  function change_salesorder() {
    var salesGraph;
    var date = $("#salesorder_filter").val();
    $.ajax({
      url: "<?php echo base_url(); ?>home/getSO",
      method: "POST",
      data: {
        'date': date
      },
      dataType: 'JSON',
      success: function(data) {
        var owner = [];
        var sub_totals = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_totals.push(parseInt(data[i].sub_totals));
        }
        


        var options = {
          series:sub_totals,
          labels:owner,
          chart: {
         width:450,
          type: 'donut',
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 270
          }
        },
        
        dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function(val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        title: {
          text: ''
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width:290
            },
            legend: {
              position: 'top'
            }
          }
        }]
        };
        $("#salesorders").html('');
        var chart = new ApexCharts(document.querySelector("#salesorders"), options);
        chart.render();
        
      
      

        // var chartdataa = {
         
        //   labels: owner,
        //   datasets: [{
        //     label: 'Total Amount',

        //     backgroundColor: [
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)'
        //     ],
        //     borderColor: [
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)',
        //       'rgba(255, 99, 132, 1)',
        //       'rgba(54, 162, 235, 1)',
        //       'rgba(139, 159, 173)',
        //       'rgba(75, 192, 192, 1)',
        //       'rgba(119, 106, 146)',
        //       'rgba(175, 160, 145)',
        //       'rgba(74, 74, 74, 1)'
        //     ],
            
        //     borderWidth: 1,
        //     data: sub_totals
        //   }]
        // };
        // $("#salesorders").html('');
        // var ctx = document.getElementById('salesorders').getContext('2d');
        // salesGraph = new Chart(ctx, {
        //   type: 'doughnut',
        //   data: chartdata
        // });
      },
      error: function(data) {
        //console.log(data);
      }
    });
  }
</script>
<?php ///////////// Salesorder Graph Ends //////////////////////// 
?>

<?php /////////////// Top Opportunity Graph Starts //////// /////// 
?>
<script>
  <?php if ($this->session->userdata('type') == "admin") {  ?>
    var oppGraph;
    $.ajax({
      url: "<?php echo base_url(); ?>home/getOPP",
      method: "GET",
      dataType: 'JSON',
      success: function(data) {
        var owner = [];
        var sub_total = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_total.push(parseInt(data[i].sub_total));
        }
        
        var chartdata = {
          labels: owner,
         
          datasets: [{
            label: 'Total Amount',
            backgroundColor: [
            
              'rgba(35, 189, 235, 0.4)',
              'rgba(35, 139, 235, 0.2)',
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
              'rgba(74, 74, 74, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(74, 74, 74, 1)'
            ],
            

            data: sub_total
          }]
        };
        var ctx = document.getElementById('topOpportunity').getContext('2d');
        oppGraph = new Chart(ctx, {
          type: 'line',
          data: chartdata,
          

        });
      }
    });
  <?php } else if ($this->session->userdata('type') == "standard") { ?>
    var oppGraph;
    $.ajax({
      url: "<?php echo base_url(); ?>home/getOPP",
      method: "GET",
      dataType: 'JSON',
      success: function(data) {
        var owner = [];
        var sub_total = [];
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
          sub_total.push(parseInt(data[i].sub_total));
        }
        
        var chartdata = {
          labels: owner,
          datasets: [{
            label: 'Total Amount',
            backgroundColor: [
              'rgba(35, 189, 235, 0.4)',
              'rgba(35, 139, 235, 0.2)',
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
              'rgba(74, 74, 74, 1)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(74, 74, 74, 1)'
            ],
            data: sub_total,
            
          }]
        };
        var ctx = document.getElementById('topOpportunity').getContext('2d');
        oppGraph = new Chart(ctx, {
          type: 'line',
          data: chartdata
        });
      },
      error: function(data) {
        //console.log(data);
      }
    });
  <?php } ?>

  function change_opportunity() {
    var date = $("#opportunity_filter").val();
    $.ajax({
      url: "<?php echo base_url(); ?>home/sort_opportunity_graph",
      method: "POST",
      dataType: 'JSON',
      data: {
        'date': date
      },
      success: function(response) {
        var owner = [];
        var sub_total = [];
        for (var i in response) {
          owner.push(response[i].owner + ' (₹) ');
          sub_total.push(parseInt(response[i].sub_total));
        }
        oppGraph.data.labels = owner;
        oppGraph.data.datasets[0].data = sub_total;
        oppGraph.update();
      }
    });
  }
</script>
<?php ///////////////////////////////////////////////////// Top Opportunity Graph Ends /////////////////////////////////////////////////////// 
?>
<script type="text/javascript">
  var table;
  $(document).ready(function() {
    table = $('#profit_table').DataTable({
      "processing": true,
      "serverSide": true,
      "order": [],
      "ajax": {
        "url": "<?php echo site_url('Home/get_dashboard_profit_table') ?>",
        "type": "POST",
      },
      "columnDefs": [{
        "targets": [-1],
        "orderable": false,
      }, ],
    });
  });
</script>
<?php $slqt = $this->session->userdata('sales_quota'); ?>
<script>
  $(document).ready(function() {

    <?php if (!empty($slqt)) { ?>
      const toCurrency = (number, currency, lang = undefined) =>
        Intl.NumberFormat(lang, {
          style: 'currency',
          currency
        }).format(number);
      const sales_quota = toCurrency(<?= $this->session->userdata('sales_quota'); ?>, 'INR', 'en-in');
      $('#sales_quota').text(sales_quota);
    <?php } ?>

    <?php if (!empty($sales_quota)) { ?>
      var sales_achieved = toCurrency(<?= $sales_quota['after_discount']; ?>, 'INR', 'en-in');;
      $('#sales_achieved').text(sales_achieved);
    <?php } ?>
    <?php if (!empty($this->session->userdata('profit_quota'))) { ?>
      var profit_quota = toCurrency(<?= $this->session->userdata('profit_quota') ?>, 'INR', 'en-in');
      $('#profit_quota').text(profit_quota);

      var so_after_discount = $("#so_after_discount").val();
      var po_after_discount = $("#po_after_discount").val();
      var profit_quota = so_after_discount - po_after_discount;
      var profit_quota = toCurrency(profit_quota, 'INR', 'en-in');
      $("#profit_achieved").text(profit_quota);
    <?php } ?>



  });
</script>
