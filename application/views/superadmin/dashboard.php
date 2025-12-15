<?php $this->load->view('superadmin/common_navbar');
?>
<style type="text/css">
  .achieved_red { color: #e85f7c !important; }
  .achieved_orange { color: orange !important; }
  .achieved_green { color: green !important; }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <?php //////////////////////// Total Ragistration ///////////// ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info grey">
              <div class="inner animate__animated animate__flipInX">
                <h4>Total Ragistration</h4>

                <h3><?= $total_reg['total_admin'];?></h3>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <?php //////////////////////// Total Ragistration End///////////// ?>
          <!-- ./col -->

          <?php //////////////////////// Leads card ///////////// ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success grey">
              <div class="inner animate__animated animate__flipInX">
                <h4>Total Active</h4>

                <h3><?= $total_active['total_admin']; ?></h3>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <?php //////////////////////// Leads card ///////////// ?>
          <!-- ./col -->

          <?php //////////////////////// Opportunity card ///////////// ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning grey">
              <div class="inner animate__animated animate__flipInX">
                <h4>Total Inactive</h4>

                <h3><?= $total_inactive['total_admin']; ?></h3>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <?php //////////////////////// Opportunity card ///////////// ?>

          <?php //////////////////////// Quotation card ///////////// ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger grey">
              <div class="inner animate__animated animate__flipInX">
                <h4>Total Reg. This Month</h4>

                <h3><?= $total_currentmonReg['total_admin'];?></h3>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <?php //////////////////////// Quotation card ///////////// ?>
        </div>
        <!-- /.row -->
      
	  
	   <!--<?php if($this->session->userdata('type') == 'standard') { ?>
        <?php  foreach ($bestTrgtuser as $key => $value) { ?>
          <div class="row">
            <div class="col-lg-6 col-6">
              <!-- small box 
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
                    if(!empty($bestTrgtuser))
                    {
                      $target = $value->sales_quota; 
                      $achieved = $value->after_discount;  
                      $achieved_percent = $achieved/$target * 100;
                      
                    } 
                    ?>
                    <?php
                      if(!empty($bestTrgtuser))
                      {
                        if($achieved_percent < 75) 
                        { $class = 'achieved_red'; } 
                        else if($achieved_percent >= 75 && $achieved_percent < 100)
                        { $class = 'achieved_orange'; } 
                        else if($achieved_percent >= 100) 
                        { $class = 'achieved_green'; } 
                      } 
                    ?>
                    <?php if(!empty($bestTrgtuser)) { ?>
                        <h4 class="<?= $class; ?>"><b> <span class="<?= $class; ?>" id="sales_achieved2"></span><?php echo IND_money_format($value->after_discount); ?> /-</b><span> (<?= round($achieved_percent,2); ?>%)</span></h4>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            
            <!-- ./col 
            <div class="col-lg-6 col-6">
              <!-- small box 
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
                   $profit_quota = $value->profit_by_user;//$so_total - $po_total; 
                   $target = $value->profit_quota; 
                   $achieved =  $profit_quota;  
                   $achieved_percent = $achieved/$target * 100; 
                   ?>
                    <?php if($achieved_percent < 75) { $class = 'achieved_red';} else if($achieved_percent >= 75 && $achieved_percent < 100){ $class = 'achieved_orange'; } else if($achieved_percent >= 100) { $class = 'achieved_green'; } ?>

                
                  <div class="col-sm-5 text-left">
                     <h4 class="<?= $class; ?>" ><b> <span class="<?= $class; ?>" id="profit_achieved4"></span><?php echo IND_money_format($value->profit_by_user); ?> /-</b><span> (<?= round($achieved_percent,2); ?>%)</span></h4>
                  </div>
                </div>
              </div>
            </div>
            <!-- ./col
          </div>
        <?php } ?>
        <?php } ?> -->
        <!-- Main row -->
	  

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <?php //////////////////////    Profit Garph Starts   ////////////////////////////////// ?>
            <div class="card animate__animated animate__slideInUp">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                 Signup User Monthwise in Year
                </h3>
                <div class="card-tools">
          
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-lg-4">
                    <div class="first-one">
                      <select class="form-control" name="profit_filter" id="profit_filter" onchange="change_profit(); return false;">
                      <option selected disabled>Select Option</option>
					  <?php 
                        $start_year = 2020;
                        for($start_year; $start_year <= date('Y'); $start_year++){  				 
					  ?>
					  <option value="<?=$start_year;?>"><?=$start_year;?></option>
						<?php } ?>
                      <!--<?php $fifteen = strtotime("-15 Day"); ?>
                      <option value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</option>
                      <?php $thirty = strtotime("-30 Day"); ?>
                      <option value="<?= date('y.m.d', $thirty); ?>">Last 30 days</option>
                      <?php $fortyfive = strtotime("-45 Day"); ?>
                      <option value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</option>
                      <?php $sixty = strtotime("-60 Day"); ?>
                      <option value="<?= date('y.m.d', $sixty); ?>">Last 60 days</option>
                      <?php $ninty = strtotime("-90 Day"); ?>
                      <option value="last month">Last Month</option>
                      <option value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</option>
                      <?php $six_month = strtotime("-180 Day"); ?>
                      <option value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</option>
                      <?php $one_year = strtotime("-365 Day"); ?>
                      <option value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</option>-->
                    </select>
                    </div>
                  </div>
                  
                </div>
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                      <canvas id="profit" width="200" height="0"></canvas>                         
                   </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <?php /////////////////////////////  Profit Graph Ends ///////////////////////////  ?>
 
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-12 connectedSortable">

            <!-- Calendar -->
            <div class="card bg-gradient-success blue">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu float-right" role="menu">
                      <a href="<?php echo base_url()."assets/"; ?>#" class="dropdown-item">Add new event</a>
                      <a href="<?php echo base_url()."assets/"; ?>#" class="dropdown-item">Clear events</a>
                      <div class="dropdown-divider"></div>
                      <a href="<?php echo base_url()."assets/"; ?>#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-info btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-info btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
 

<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('superadmin/common_footer');?>
<!-- <script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    table = $('#profit_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Home/get_profit_table')?>",
            "type": "POST",
            // "data" : function(data)
            //  {
            //     data.searchDate = $('#date_filter').val();
            //     data.searchUser = $('#user_filter').val();
            //  }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
</script> -->
<?php ///////////////////////////////////////////////////// Signup Graph Starts ////////////////////////////////////////////////////////////  ?>
<script>
  <?php ///////////////// Signup Graph Admin ///////////////////////  ?>
  
  <?php //if($this->session->userdata('type')=="admin") { ?>
    var profitGraph;
    $.ajax({
      url : "<?php echo base_url();?>superadmin/home/signup_user_graph",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_total = [];
        for(var i in data)
        {
          owner.push(data[i].month_name);
          sub_total.push((data[i].count));
        }
        var chartdata = {
          labels: owner,
          datasets : [
            {
              label: 'Total Signup User',
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
              'rgba(175, 212, 175)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(175, 212, 175)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(175, 212, 175)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(175, 212, 175)',
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(139, 159, 173)',
              'rgba(75, 192, 192, 1)',
              'rgba(119, 106, 146)',
              'rgba(175, 160, 145)',
              'rgba(175, 212, 175)'
              ],
              data : sub_total
            }
          ]
        };
        var ctx = $("#profit");
        profitGraph = new Chart(ctx, {
          type: 'bar',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
	
    function change_profit()
    {
      var date = $("#profit_filter").val();
	  //alert(date);
      $.ajax({
        url : "<?php echo base_url();?>superadmin/home/signup_user_graph",
        method: "POST",
        dataType : 'JSON',
        data : {'date' : date},
        success: function(response)
        {
         //alert(response);
		 console.log(response);
           var owner = [];
           var sub_total = [];
           for(var i in response)
           {
             owner.push(response[i].month_name);
             sub_total.push(response[i].count);
           }
           profitGraph.data.labels = owner ;
           profitGraph.data.datasets[0].data = sub_total;
           profitGraph.update();
        }
      });
    }
  <?php ///////////////////////////////////////////////////// Signup Graph Admin //////////////////////////////////////////////////////////  ?>

  <?php ///////////////////////////////////////////////////// Profit Graph User ////////////////////////////////////////////////////////////  ?> 
  <?php /*} else */if ($this->session->userdata('type')=="standard") { ?>
    var profitGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getdata_by_user",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_total = [];
        for(var i in data)
        {
          owner.push(data[i].owner);
          sub_total.push(parseInt(data[i].after_discount)-parseInt(data[i].after_discount_po)-parseInt(data[i].total_orc));
        }
        var chartdata = {
          labels: owner,
          datasets : [
            {
              label: 'Total Amount',
             backgroundColor : [
              'rgba(54, 162, 235, 1)',
            ],
              borderColor: [
              'rgba(54, 162, 235, 1)',
        ],
            data : sub_total
            }
          ]
        };
        var ctx = $("#profits");
        profitGraph = new Chart(ctx, {
          type: 'bar',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
	
    function change_profit()
    {
      var date = $("#profit_filter").val();
	  alert(date);
      $.ajax({
        url : "<?php echo base_url();?>superadmin/home/signup_user_graph",
        method: "POST",
        dataType : 'JSON',
        data : {'date' : date},
        success: function(response)
        {
				
            var owner = [];
           var sub_total = [];
           for(var i in response)
           {
             owner.push(response[i].owner);
             sub_total.push(response[i].sub_total);
           }
           profitGraph.data.labels = owner ;
           profitGraph.data.datasets[0].data = sub_total;
           profitGraph.update();
        }
      });
    }
  <?php } ?>
  <?php ///////////////////////////////////////////////////// Profit Graph User ////////////////////////////////////////////////////////////  ?>
</script>
<?php ///////////////////////////////////////////////////// Profit Graph Ends ////////////////////////////////////////////////////////////  ?>


<?php ///////////////////////////////////////////////////// Estimate Graph Starts ////////////////////////////////////////////////////////////  ?>
<script>
  <?php if($this->session->userdata('type')=="admin") { ?>
    var estimateGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getestimate",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_totalq = [];
        for(var i in data)
        {
          owner.push(data[i].owner);
          sub_totalq.push(parseInt(data[i].sub_totalq));
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
        var ctx = document.getElementById('estimates').getContext('2d');
        estimateGraph = new Chart(ctx, {
          type: 'doughnut',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
  <?php } else if($this->session->userdata('type')=="standard") {  ?>
    var estimateGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getestimate",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_totalq = [];
        for(var i in data)
        {
          owner.push(data[i].owner);
          sub_totalq.push(parseInt(data[i].sub_totalq));
        }
        var chartdata = {
          labels: owner,
          datasets : [
            {
              label: 'Total Amount',
              backgroundColor : [
                'rgba(74, 74, 74, 1)',
            ],
              borderColor: [
              'rgba(74, 74, 74, 1)',
        ],
              data : sub_totalq
            }
          ]
        };
        var ctx = document.getElementById('estimates').getContext('2d');
        estimateGraph = new Chart(ctx, {
          type: 'bar',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
  <?php } ?>
  function change_estimate_sales()
  {
    var date = $("#estimate_filter").val();
    $.ajax({
      url : "<?php echo base_url();?>home/sort_estimate_graph",
      method: "POST",
      dataType : 'JSON',
      data : {'date' : date},
      success: function(response)
      {
        var owner = [];
        var sub_total = [];
        for(var i in response)
        {
          owner.push(response[i].owner);
          sub_total.push(parseInt(response[i].sub_totalq));
        }
        estimateGraph.data.labels = owner ;
        estimateGraph.data.datasets[0].data = sub_total;
        estimateGraph.update();
      }
    });
  }
</script>
<?php ///////////////////////////////////////////////////// Estimate Graph Ends ////////////////////////////////////////////////////////////  ?>

<?php ///////////////////////////////////////////////////// Salesorder Graph Starts //////////////////////////////////////////////////////////  ?>
<script>
  <?php if($this->session->userdata('type')=="admin") { ?>
    var salesGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getSO",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_totals = [];
        for(var i in data)
        {
          owner.push(data[i].owner);
          sub_totals.push(parseInt(data[i].sub_totals));
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
                'rgba(74, 74, 74, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(139, 159, 173)',
                'rgba(75, 192, 192, 1)',
                'rgba(119, 106, 146)',
                'rgba(175, 160, 145)',
                'rgba(74, 74, 74, 1)'
              ],
               borderWidth: 1,
              data : sub_totals
            }
          ]
        };
        var ctx = document.getElementById('salesorders').getContext('2d');
        salesGraph = new Chart(ctx, {
          type: 'pie',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
    function change_salesorder()
    {
      var date = $("#salesorder_filter").val();
      $.ajax({
        url : "<?php echo base_url();?>home/sort_salesorder_graph",
        method: "POST",
        dataType : 'JSON',
        data : {'date' : date},
        success: function(response)
        {
          var owner = [];
          var sub_total = [];
          for(var i in response)
          {
            owner.push(response[i].owner);
            sub_total.push(parseInt(response[i].sub_totals));
          }
          salesGraph.data.labels = owner ;
          salesGraph.data.datasets[0].data = sub_total;
          salesGraph.update();
        }
      });
    }
  <?php  }  else if($this->session->userdata('type')=="standard") { ?>
    var salesGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getSO",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var status = [];
        var sub_totals = [];
        for(var i in data)
        {
          status.push(data[i].status);
          sub_totals.push(parseInt(data[i].sub_totals));
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
        var ctx = document.getElementById('salesorders').getContext('2d');
        salesGraph = new Chart(ctx, {
          type: 'doughnut',
          data : chartdata
        });
      },
      error: function(data)
      {
        console.log(data);
      }
    });
    function change_salesorder()
    {
      var date = $("#salesorder_filter").val();
      $.ajax({
        url : "<?php echo base_url();?>home/sort_salesorder_graph",
        method: "POST",
        dataType : 'JSON',
        data : {'date' : date},
        success: function(response)
        {
          var status = [];
          var sub_total = [];
          for(var i in response)
          {
            status.push(response[i].status);
            sub_total.push(parseInt(response[i].sub_totals));
          }
          salesGraph.data.labels = status ;
          salesGraph.data.datasets[0].data = sub_total;
          salesGraph.update();
        }
      });
    }
  <?php } ?>

</script>
<?php ///////////////////////////////////////////////////// Salesorder Graph Ends ////////////////////////////////////////////////////////// ?>

<?php ///////////////////////////////////////////////////// Top Opportunity Graph Starts /////////////////////////////////////////////////////// ?>
<script>
  <?php if($this->session->userdata('type')=="admin") {  ?>
    var oppGraph;
    $.ajax({
      url : "<?php echo base_url();?>home/getOPP",
      method: "GET",
      dataType : 'JSON',
      success: function(data)
      {
        var owner = [];
        var sub_total = [];
        for(var i in data)
        {
          owner.push(data[i].owner);
          sub_total.push(parseInt(data[i].sub_total));
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
            data : sub_total
            }
          ]
        };
        var ctx = document.getElementById('topOpportunity').getContext('2d');
        oppGraph = new Chart(ctx, {
          type: 'horizontalBar',
          data : chartdata
        });
      }
    });
  <?php } else if($this->session->userdata('type')=="standard") { ?>
    var oppGraph;
    $.ajax({
          url : "<?php echo base_url();?>home/getOPP",
          method: "GET",
          dataType : 'JSON',
          success: function(data)
          {
            var owner = [];
            var sub_total = [];
            for(var i in data)
            {
              owner.push(data[i].owner);
              sub_total.push(parseInt(data[i].sub_total));
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
                  data : sub_total
                }
              ]
            };
            var ctx = document.getElementById('topOpportunity').getContext('2d');
            oppGraph = new Chart(ctx, {
              type: 'horizontalBar',
              data : chartdata
            });
          },
          error: function(data)
          {
            console.log(data);
          }
        });
  <?php } ?>
  function change_opportunity()
  {
    var date = $("#opportunity_filter").val();
    $.ajax({
      url : "<?php echo base_url();?>home/sort_opportunity_graph",
      method: "POST",
      dataType : 'JSON',
      data : {'date' : date},
      success: function(response)
      {
        var owner = [];
        var sub_total = [];
        for(var i in response)
        {
          owner.push(response[i].owner);
          sub_total.push(parseInt(response[i].sub_total));
        }
        oppGraph.data.labels = owner ;
        oppGraph.data.datasets[0].data = sub_total;
        oppGraph.update();
      }
    });
  }
</script>
<?php ///////////////////////////////////////////////////// Top Opportunity Graph Ends /////////////////////////////////////////////////////// ?>
<script type="text/javascript">
var table;
$(document).ready(function(){
    //datatables
    table = $('#profit_table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('Home/get_dashboard_profit_table')?>",
            "type": "POST",
            // "data" : function(data)
            //  {
            //     data.searchDate = $('#date_filter').val();
            //     data.searchUser = $('#user_filter').val();
            //  }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
  });
</script>
<?php $slqt=$this->session->userdata('sales_quota');?>
<script>
  $(document).ready(function(){
	  
	  <?php if(!empty($slqt)) { ?>
      const toCurrency = (number, currency, lang = undefined) => 
      Intl.NumberFormat(lang, { style : 'currency', currency }).format(number);
      const sales_quota =  toCurrency(<?= $this->session->userdata('sales_quota');?>, 'INR', 'en-in');
      $('#sales_quota').text(sales_quota);
	  <?php } ?>

    <?php if(!empty($sales_quota)) { ?>
      var sales_achieved = toCurrency(<?= $sales_quota['after_discount'];?>, 'INR', 'en-in');;
      $('#sales_achieved').text(sales_achieved);
    <?php } ?>
    <?php if(!empty($this->session->userdata('profit_quota'))) { ?>
      var profit_quota =  toCurrency(<?= $this->session->userdata('profit_quota')?>, 'INR', 'en-in');
        $('#profit_quota').text(profit_quota);
        
       var so_after_discount = $("#so_after_discount").val();
       var po_after_discount = $("#po_after_discount").val();
       var profit_quota = so_after_discount - po_after_discount;
       var profit_quota = toCurrency(profit_quota, 'INR', 'en-in');
       $("#profit_achieved").text(profit_quota);
     <?php } ?>

      

  });
  
</script>