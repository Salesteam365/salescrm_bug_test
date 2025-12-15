<?php $this->load->view('common_navbar');?>
<style>
  .direct-chat-messages{ height: 300px;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0 text-dark">Overall Summary</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card animate__animated animate__slideInUp">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Daily Summary
                </h3>
                <div class="card-tools">
                  <!-- <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span> -->
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                          data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button> -->
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-lg-4">
                    <div class="first-one">
                      <select class="form-control">
                      <option selected disabled>Select Date</option>
                      <option>Last 15 days</option>
                      <option>Last 30 days</option>
                      <option>Last 45 days</option>
                      <option>Last 60 days</option>
                      <option>Last 75 days</option>
                      <option>Last 100 days</option>
                    </select>
                    </div>
                  </div>
                </div>
                <div class="tab-content p-0">
                  <!-- <div id="barr-graph"></div> -->
                  <div id="manish"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- tables -->
            <div class="card direct-chat direct-chat-primary">
              <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                Staff Payment Summary
                </h3>

                <div class="card-tools">
                  <!-- <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary">3</span> -->
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <!-- <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts"
                          data-widget="chat-pane-toggle">
                    <i class="fas fa-comments"></i>
                  </button> -->
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="direct-chat-messages">
                  <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm">Staff Name</th>
                            <th class="th-sm">Till Date Salary</th>
                            <th class="th-sm">Closing Balance</th>
                            <th class="th-sm">Total Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Anupal Rawat</td>
                            <td>₹ 29,166.67</td>
                            <td>₹ 0.00</td>
                            <td>₹ 28,000.00</td>
                        </tr>
                        <tr>
                            <td>Manish Rawat</td>
                            <td>₹ 29,166.67</td>
                            <td>₹ 0.00</td>
                            <td>₹ 28,000.00</td>
                        </tr>
                        <tr>
                            <td>Himanshu</td>
                            <td>₹ 29,166.67</td>
                            <td>₹ 0.00</td>
                            <td>₹ 28,000.00</td>
                        </tr>
                        <tr>
                            <td>Sanoj Patel</td>
                            <td>₹ 29,166.67</td>
                            <td>₹ 0.00</td>
                            <td>₹ 28,000.00</td>
                        </tr>
                        <tr>
                            <td>Demo</td>
                            <td>₹ 29,166.67</td>
                            <td>₹ 0.00</td>
                            <td>₹ 28,000.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td>Total</td>
                        <td>₹ 92,666.67</td>
                        <td>₹ 0.00</td>
                        <td>₹ 28,000.00</td>
                      </tr>
                    </tfoot>
                </table>

                </div>
  
              </div>

            </div>
            <!--/.direct-chat -->


            <div class="card direct-chat direct-chat-primary">
              <!-- /.card-header -->


            </div>

            
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

            <!-- Map card -->
            <div class="card animate__animated animate__fadeInRight">
              <div class="card-header">
                <h3 class="card-title">
                 <i class="fas fa-chart-pie mr-1"></i>
                  Salary Breakup
                </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-lg-4">
                    <div class="first-one">
                      <select class="form-control">
                      <option selected disabled>Select Date</option>
                      <option>Last 15 days</option>
                      <option>Last 30 days</option>
                      <option>Last 45 days</option>
                      <option>Last 60 days</option>
                      <option>Last 75 days</option>
                      <option>Last 100 days</option>
                    </select>
                    </div>
                  </div>

                </div>
                <div class="tab-content p-0">
                  <div id="chart"></div>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                   <i class="fas fa-chart-pie mr-1"></i>
                  Payment Log
                </h3>

              </div>

              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-lg-4">
                    <div class="first-one">
                      <select class="form-control">
                      <option selected disabled>Select Date</option>
                      <option>Last 15 days</option>
                      <option>Last 30 days</option>
                      <option>Last 45 days</option>
                      <option>Last 60 days</option>
                      <option>Last 75 days</option>
                      <option>Last 100 days</option>
                    </select>
                    </div>
                  </div>

                </div>
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">                  
                    <!-- Morris chart - Sales -->
                    <!-- <div id="don-graph" style="height: 250px;"></div> -->                 
                    <div id="chart1"></div>
                   </div>
              </div>

            </div>
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script>
  var options = {
          series: [44, 55, 13, 33],
          chart: {
          width: 400,
          type: 'donut',
        },
        dataLabels: {
          enabled: false
        },
        // responsive: [{
        //   breakpoint: 480,
        //   options: {
        //     chart: {
        //       width: 200
        //     },
        //     legend: {
        //       show: false
        //     }
        //   }
        // }],
        // legend: {
        //   position: 'right',
        //   offsetY: 0,
        //   height: 230,
        // }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();     
</script>

<!-- <script>
new Morris.Donut({
  // ID of the element in which to draw the chart.
  element: 'don-graph',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: 
  [
    {label: "Download Sales", value: 12},
    {label: "In-Store Sales", value: 30},
    {label: "Mail-Order Sales", value: 20}
  ],

  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});
</script> -->

<script>
  var options1 = {
  chart: {
    height: 400,
    type: "radialBar",
  },
  series: [67],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      startAngle: -135,
      endAngle: 135,
      track: {
        background: '#333',
        startAngle: -135,
        endAngle: 135,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "horizontal",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};

new ApexCharts(document.querySelector("#chart1"), options1).render();

var options2 = {
  chart: {
    height: 280,
    type: "radialBar",
  },
  series: [67],
  colors: ["#20E647"],
  plotOptions: {
    radialBar: {
      startAngle: -90,
      endAngle: 90,
      track: {
        background: '#333',
        startAngle: -90,
        endAngle: 90,
      },
      dataLabels: {
        name: {
          show: false,
        },
        value: {
          fontSize: "30px",
          show: true
        }
      }
    }
  },
  fill: {
    type: "gradient",
    gradient: {
      shade: "dark",
      type: "horizontal",
      gradientToColors: ["#87D4F9"],
      stops: [0, 100]
    }
  },
  stroke: {
    lineCap: "butt"
  },
  labels: ["Progress"]
};
</script>


<script>
   var options = {
          series: [{
          name: 'Net Profit',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
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
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#manish"), options);
        chart.render();
      
</script>

<!-- <script>
var ctx = document.getElementById('sale').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Tiger Nixon', 'Garrett Winters', 'Ashton Cox', 'Cedric Kelly'],
        datasets: [{
            label: '# of Votes',
            data: [5, 9, 13, 15, 2, 3],
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
              'rgba(74, 74, 74, 1)'
              ],
            borderWidth: 1
        }]
    },
});
</script> -->

<script>
  var data = [
  {
    x: 1994,
    y: 2543763
  },
  {
    x: 1995,
    y: 4486659
  },
  {
    x: 1996,
    y: 7758386
  },
  {
    x: 1997,
    y: 12099221
  },
  {
    x: 1998,
    y: 18850762
  },
  {
    x: 1999,
    y: 28153765
  },
  {
    x: 2000,
    y: 41479495
  },
  {
    x: 2001,
    y: 50229224
  },
  {
    x: 2002,
    y: 66506501
  },
  {
    x: 2003,
    y: 78143598
  },
  {
    x: 2004,
    y: 91332777
  },
  {
    x: 2005,
    y: 103010128
  },
  {
    x: 2006,
    y: 116291681
  },
  {
    x: 2007,
    y: 137322698
  },
  {
    x: 2008,
    y: 157506752
  },
  {
    x: 2009,
    y: 176640381
  },
  {
    x: 2010,
    y: 202320297
  },
  {
    x: 2011,
    y: 223195735
  },
  {
    x: 2012,
    y: 249473624
  },
  {
    x: 2013,
    y: 272842810
  },
  {
    x: 2014,
    y: 295638556
  },
  {
    x: 2015,
    y: 318599615
  },
  {
    x: 2016,
    y: 342497123
  }
];

var labelFormatter = function(value) {
  var val = Math.abs(value);
  if (val >= 1000000) {
    val = (val / 1000000).toFixed(1) + " M";
  }
  return val;
};
var options = {
  chart: {
    height: 350,
    type: "line",
    zoom: {
      enabled: false
    }
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: "straight"
  },
  series: [
    {
      name: "Logarithmic",
      data: data
    },
    {
      name: "Linear",
      data: data
    }
  ],

  title: {
    text: "Logarithmic Scale",
    align: "left"
  },
  markers: {
    size: 0
  },
  xaxis: {
    type: "datetime"
  },
  yaxis: [
    {
      min: 1000000,
      max: 500000000,
      tickAmount: 4,
      logarithmic: true,
      seriesName: "Logarithmic",
      labels: {
        formatter: labelFormatter,
      }
    },
    {
      min: 1000000,
      max: 500000000,
      opposite: true,
      tickAmount: 4,
      seriesName: "Linear",
      labels: {
        formatter: labelFormatter
      }
    }
  ]
};

var chart = new ApexCharts(document.querySelector("#charting"), options);

chart.render();

</script>

<script>
  var ctx = document.getElementById('opportunity').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['Tiger Nixon', 'Garrett Winters', 'Ashton Cox', 'Cedric Kelly', 'Herrod Chandler', 'Brielle Williamson', 'Quinn Flynn'],
        datasets: [{
            label: 'My First dataset',
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
              'rgba(74, 74, 74, 1)'
              ],
            data: [0, 10, 50, 100, 200, 500, 1000]
        }]
    },

    // Configuration options go here
    options: {}
});
</script>