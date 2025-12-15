<?php $this->load->view('common_navbar');?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<style>
    
.card-body{
    height:98vh;
    border:1px dashed black;
  
}
.preloaded-table {
    border: 1px solid #ccc; /* Grey outline */
    border-collapse: collapse; 
   
}

.preloaded-table th,
.preloaded-table td {
    border: 1px solid #ccc; /* Grey outline for table cells */
    padding: 3px; 
    /* Add padding for better spacing */
}


#pptbox{
  
}
 #filterform {

        background-color: #ffffff; /* White background */
        padding: 20px; /* Add padding for spacing */
        border-radius: 5px; /* Add rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add shadow effect */
        margin-bottom: 20px; /* Add margin for spacing */
        font-size:13px;
        
    }
    #filterform select, #filterform input[type="date"] {
        margin-bottom: 5px; /* Add margin between elements */
        border: 1px solid #ccc; /* Add border */
        border-radius: 3px; /* Add rounded corners */
        width: 100%; /* Make elements fill the container width */
        font-size:13px;
    }
    #filterform label {
        display: block; /* Make labels display as block to stack them vertically */
        margin-bottom: 3px; /* Add margin between labels */
        font-size:13px;
    }
             

    .form-group {
    
        display: inline-block; /* Flex layout to align items in a row */
         /* Allow items to wrap to the next line */
        margin-bottom: 5px; /* Add margin between groups */
        font-size:13px;
        padding:2px;
    }
    .form-group label {
        width: 140px; /* Fixed width for labels */
        margin-right: 10px; /* Add margin between label and input */
    }
    .form-group select,
    .form-group input[type="date"] {
        flex: 1; /* Allow inputs to fill remaining space */
        padding: 1px; /* Add padding */
        border: 1px solid #ccc; /* Add border */
        border-radius: 3px; /* Add rounded corners */
        margin-right: 10px; /* Add margin between inputs */
    }
   #pptbox{
    display:flex;
    flex-wrap:wrap;
   }
  
</style>
<!-- Edit Chart Modal -->

<!-- Start Page Main Content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
            
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">Customer</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
         <div class="container-fliud filterbtncon mx-0" style="border-radius:4px;">
                            <?php 
                                   $fifteen = strtotime("-15 Day"); 
                                   $thirty = strtotime("-30 Day"); 
                                   $fortyfive = strtotime("-45 Day"); 
                                   $sixty = strtotime("-60 Day"); 
                                   $ninty = strtotime("-90 Day"); 
                                   $six_month = strtotime("-180 Day"); 
                                   $one_year = strtotime("-365 Day");
                             ?>
         <div class="row mb-3">
         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select graph
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
           <!--<li data-graphtype="table" class="graphtypes"><span style="color: #007bff;">&#x1F4C8;</span> table</li>-->
           <li data-graphtype="line" class="graphtypes"><span style="color: #007bff;">&#x1F4C8;</span> Line Chart</li>
           <li data-graphtype="bar" class="graphtypes"><span style="color: #6610f2;">&#x1F4CA;</span> Bar Chart</li>
           
           <!--<li data-graphtype="stackedcolumn" class="graphtypes"><span style="color: #6610f2;">&#x1F4CA;</span>Bar Chart with labels</li>-->
           <!--<li data-graphtype="distributedbar" class="graphtypes"><span style="color: #2411f2;">&#x1F4CA;</span> Colorful Bar Chart</li>-->
           <!--<li data-graphtype="pie" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Pie Chart</li>-->
           <!--<li data-graphtype="semidonut" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Semi Donut Chart</li>-->
           <!--<li data-graphtype="donut" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Donut Chart</li>-->
           <!--<li data-graphtype="stackedbar" class="graphtypes"><span style="color: #dc3545;">&#x1F4CC;</span>horizontal bar with labels</li>-->
           <!--<li data-graphtype="funnel" class="graphtypes"><span style="color: #dc3545;">&#x1F4C0;</span> Funnel Chart</li>-->
           <!--<li data-graphtype="radar" class="graphtypes"><span style="color: #fd7e14;">&#x1F6A8;</span> Radar Chart</li>-->
    </ul>
</div>
   </div>
                                 <!-- AI form -->
          <div class="col-lg-6">
            <!-- <form id="aiform">
          <input  type="text" id="ai_text"  value="" style="border:1px solid black; width:400px; padding-left:4px;">
           <button class="btn btn-primary" id="generate">generate</button>
        </form> -->
      </div>

                                <!-- AI form -->


        <!-- <div class="col-lg-2"></div> -->

            <div class="col-lg-4">
               <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <?php if($this->session->userdata('type')=='admin'){ ?>
                  <!--<a href='Export_data/export_customer_csv' class="p-0" ><button class="btnstopcorn">Export Data</button></a>-->
                  <?php } ?>
                  <?php if(check_permission_status('Customer','create_u')==true){ 
                     if($this->session->userdata('account_type')=="Trial" && ($countOrg>=2000 || $countContact>=2000)){
                     ?>
                  <!--<button class="btnstop" onclick="infoModal('You are exceeded  your customer/contact limit - 2,000')" >Add New</button>-->
                  <?php }else{ ?>
                  <!--<button class="btncorner" onclick="import_excel()">Import&nbsp;Customer</button>-->
                  <!-- <button class="btnstop" onclick="add_form()">Add New</button> -->
                  <button class="btnstop" id="deletefile" onclick="deletefile();">Delete</button>
                  <?php  } } ?>
               </div>
            </div>

         </div>

      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content" >
      <div class="container-fluid">
         <!-- Main row -->
         <!-- Map card -->
         <div class="row">
         <div class="col-md-9 pptcon">
         <div class="card org_div p-0 m-0">
         
            <div class="card-body" id="pptbox" style="">
          
          </div>
    <div>
 </div>
                  </div>
                  </div>
                  
          <div class="col-md-3 p-0 m-0" id="editChartModal">
          <div class="container-fluid" >
          <div class="card card-body" style="border:1px dashed grey; border-radius:1px;" >
                <!-- Your filter form goes here -->
                <div>
                 
                <select id="chartwidth" class="chartdim">
                <option value="">width</option>
                   <option value="20">20%</option>
                   <option value="25">25%</option>
                   <option value="30">30%</option>
                   <option value="35">35%</option>
                   <option value="40">40%</option>
                   <option value="45">45%</option>
                   <option value="50">50%</option>
                   <option value="60">60%</option>
                    <option value="65">65%</option>
                      <option value="70">70%</option>
                   <option value="75">75%</option>
                    <option value="85">85%</option>
                     <option value="90">90%</option>
                   <option value="95">95%</option>
                   <option value="100">100%</option>
              </select>
              <select id="chartheight" class="chartdim" >
              <option value="35">height</option>
                   <option value="20">20%</option>
                   <option value="25">25%</option>
                   <option value="30">30%</option>
                   <option value="35">35%</option>
                   <option value="40">40%</option>
                   <option value="45">45%</option>
                   <option value="50">50%</option>
                   <option value="60">60%</option>
                    <option value="65">65%</option>
                     <option value="70">70%</option>
                   <option value="75">75%</option>
                   <option value="85">80%</option>
                    <option value="85">85%</option>
                   <option value="95">95%</option>
                   <option value="100">100%</option>
              </select>
                  </div>
                  <div class="form-group">
        <label for="title">Chart Title</label>
        <input type="text" id="title" name="title" style="border:1px solid grey; padding:2px;">
        
    </div>
    <div class="form-group">
        <label for="x-axis-title">X-axis Title</label>
        <input type="text" id="x-axis-title" name="xtitle" style="border:1px solid grey; padding:2px;">
        
    </div>
    <div class="form-group">
        <label for="y-axis-title">Y-axis Title</label>
        <input type="text" id="y-axis-title" name="ytitle" style="border:1px solid grey; padding:2px;">
        
    </div>
                <form id="filterform" style="max-height:50vh;overflow-y:auto; ">
                  <!-- Your form fields --> <div class="form-group">
        <label for="module">Select by Module:</label>
        <select name="module" id="module" class="">
            <option value="">select by module</option>
            <option value="lead">Leads</option>
            <option value="quote">Quotation</option>
            <option value="salesorder">Saleorders</option>
            <option value="purchaseorder">Purchaseorder</option>
            <option value="organization">Organization</option>
        </select>
    </div>
    <div class="form-group">
        <label for="user">Select by User:</label>
        <select name="user" id="byuser" class="">
            <option value="all">Select by user</option>
            <option value="all">All</option>
            <?php foreach($admin as $admin){?>
                <option value="<?=$admin['admin_email'];?>"><?= $admin['admin_name'];?></option>
            <?php }?>
            <?php foreach($user as $user){?>
                <option value="<?=$user['standard_email'];?>"><?= $user['standard_name'];?></option>
            <?php }?>
        </select> 
    </div>
   
    <div class="form-group">
        <label for="xaxis">X-axis:</label>
        <select name="xaxis" id="x-axis" class="">
            <option value="">x-axis</option>
            <option value="user">User</option>
            <option value="organization">Organization</option>
            <option value="months">months</option>
            <option value="saleorder_id">SO ID</option>
            <option value="purchaseorder_id">PO ID</option>
            <option value="quote_id">Quotation ID</option>
            <option value="product">Products</option>
        </select>
    </div>
    <div class="form-group">
        <label for="yaxis">Y-axis:</label>
        <select name="yaxis" id="y-axis" class="">
        </select>
    </div>
  

    <!-- Date filter -->
    <div class="form-group">
        <label for="from_date">From Date:</label>
        <input type="date" id="from_date" name="from_date">
        
    </div>
    <div class="form-group">
        <label for="to_date">To Date:</label>
        <input type="date" id="to_date" name="to_date">
    </div>
    <div class="form-group">
        <label for="yaxis">Aggregations</label>
        <select name="aggr" id="aggr" class="">
            <option value = "totalcount">Total Count</option>
            <option value = "totalsalessum">Total Amount</option>
            <option value = "totalprofitsum">Total profit</option>
            <option value = "totalcount">Total Count</option>
            <option value = "totalgst">Total Gst</option>
        </select>
    </div>
    <div class="form-group">
        <label for="yaxis">Options</label>
        <select name="limit" id="limit" class="">
            <option value="desc5">Top 5</option>
            <option value="desc20">Top 20</option>
            <option value="desc10">Top 10</option>
            <option value="desc5">Top 5</option>
            <option value="asc20">Last 20</option>
            <option value="asc10">Last 10</option>
            <option value="asc5">Last 5</option>
        </select>
    </div>
    <div class="form-group">
        <label for="">Filter by column</label>
        <select name="fbycol" id="fbycol" class="">
        </select>
    </div>
    <div class="form-group">
        <label for="yaxis">Filter by</label>
        <select name="field" id="filterfield" class="">
            
        </select>
    </div>
     <div class="form-group">
        <label for="user">Select by Organization:</label>
        <input id="byorg" name="org" style="border:1px solid grey; padding:2px;">
    </div>
    <div class="form-group">
    <label for="yaxis">Table columns</label><br>
   <div id="coldops"></div>
</div>
</form>
                
                <button id="saveChartSize" class="btn btn-success">Save</button>
              </div>
            </div>
          </div>
           
            <div class="collapse" id="collapseFilters">
             
        </div>
    
            <!-- /.card-body -->
         </div>
         <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- End Page Main Content -->
<!-- Add new modal -->
<?php $this->load->view('common_footer');?>
<script>
var pptboxheight = $("#pptbox").height();
var pptboxwidth = $("#pptbox").width();
    var newcoun =  loadChartsFromLocalStorage();
    var newcoun2 = loadTableFromLocalStorage();
    if(newcoun2 > newcoun){
        newcoun = newcoun2;
    }
   
  
$('#module').change(function(){
    var selectedModule = $(this).val();
    $.ajax({
        url: "<?php echo base_url('Customreports/get_column_names');?>",
        type: "POST",
        data: {module: selectedModule},
        dataType: "json",
        success:function(response){
           
            var optionsHtml='';
            var checkbox='';
            var optionsHtmlforX = '<option value="months">Months</option><option value="years">Years</option><option value="fyear">Financial Year</option>';
            if((response)) { // Check if response is an array
                $.each(response, function(index, value){
                    optionsHtml += '<option value="' + index + '">' + value + '</option>';
                });

                 var chartid =   $("#editChartModal").attr('data-chartid');
            
            if($("#"+chartid).children().is('table')) {
                   $.each(response, function(index, value){
                       checkbox += '<input name="columns[]" type="checkbox" value="' + index + '">' + value + '<br>';
                   });
           }
            } else {
                console.error("Response is not an array:", response);
            }
            $('#x-axis').html(optionsHtmlforX+optionsHtml);
            $('#y-axis').html(optionsHtml);
            $("#fbycol").html(optionsHtml);
            $("#coldops").html(checkbox);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
});

$("#fbycol").change(function(){
    var selectedModule = $("#module").val();
    var field = $(this).val();
    $.ajax({
        url: "<?php echo base_url('Customreports/getfield_data');?>",
        type: "POST",
        data: {module: selectedModule,field:field},
        dataType: "json",
        success:function(response){
      var col = response.fields;
            var optionsHtml = '<option value="">filter by '+ col +'</option>';
            if(Array.isArray(response.dataset)) { // Check if response is an array
                $.each(response.dataset, function(index, value){
               
                    optionsHtml += '<option value="' + value[col] + '">' + value[col] + '</option>';
                });
            } else {
                console.error("Response is not an array:", response);
            }
           
            $('#filterfield').html(optionsHtml);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
        }
    });
})
 var i=newcoun;
 
 $("#generate").click(function(e){
    e.preventDefault();
    var text =$("#ai_text").val();
        $.ajax({
            url:'<?php echo base_url('Customreports/generatequery');?>',
            type:'post',
            data:{text:text},
            success:function(resp){
              
            }
        });
  });
   $(".graphtypes").each(function(){
   
    $(this).click(function(){
        i++;
        var graphtype = $(this).data('graphtype');

    var chartbox = $('<div></div>').attr('id', 'chart'+i).attr('class','card graphitem').css({'width':'30%','height':'9%','margin':'5px','padding':'5px','padding-bottom':'8px'});
        chartbox.draggable();
        
        $("#pptbox").append(chartbox);
      var tableid = 'dynamictablechart'+i;
        if(graphtype == 'table'){
        
          var table =`
     <table class="preloaded-table" id=${tableid}>
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
         
        </tbody>
    </table>

`;
chartbox.append(table);
        }
      
    else if(graphtype == 'pie'){
        var options = {
          series: [20,10,25,25,20],
          chart: {
       
        width:'100%',
          type: 'pie',
        },
        labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }],
        colors: ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0", "#D3DAFE", "#F97794", "#7A76FF", "#4ADE80", "#FFD166", "#6A4C93", "#8D6CAB", "#BAE8E8", "#B8B8D3", "#7A6563"],
        title: {
        text: 'Distribution of Sales by Team', // Title for the pie chart
        align: 'center', // Alignment of the title (left, center, right)
        margin: 15, // Margin around the title
        offsetX: 0, // Horizontal offset of the title
        offsetY:0, // Vertical offset of the title
        floating: false, // Whether the title should be floating above the chart
        style: {
            fontSize: '16px', // Font size of the title
            fontWeight: 'bold', // Font weight of the title
            color: '#263238' // Color of the title
        },
    },
        };

    }
    
      else if(graphtype =='distributedbar'){
    
        var options = {
            series: [
                {
                    name: "High - 2013",
                    data: [28, 29, 33, 36, 32, 32, 33],
                },
                {
                    name: "Low - 2013",
                    data: [12, 11, 14, 18, 17, 13, 13],
                }
            ],
            chart: {
                height: 280,
                type: 'bar',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.1
                },
                toolbar: {
                    show: true
                },
              
            },
            colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#00D9E9', '#FF66C3', '#FFE100'],
            plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true
            
          },
        },
            dataLabels: {
                enabled: true,
                
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#fff', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.1
                },
            },
            markers: {
                size: 1,
                show:false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                title: {
                    text: 'Month'
                }
            },
           
        //    colors:['red','blue'],
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            },
            
        };
    }
    else if(graphtype == 'semidonut'){
        var options = {
          series: [44, 55, 41, 17, 15],
          chart: {
          type: 'donut',
        
          
        },
        plotOptions: {
          pie: {
            startAngle: -90,
            endAngle: 90,
            offsetY: 10
          }
        },
        grid: {
          padding: {
            bottom: -50
          }
        },
        title:{
          text:'Distribution of sales'
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              height: 250
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };
    }
    else if(graphtype == 'donut'){
        var options = {
          series: [44, 55, 41, 17, 15],
          chart: {
          type: 'donut',
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };
    }
    else if(graphtype == 'funnel'){
        var options = {
          series: [
          {
            name: "Funnel Series",
            data: [1380, 1100, 990, 880, 740, 548, 330, 200],
          },
        ],
          chart: {
          type: 'bar',
          height: 350,
        },
        plotOptions: {
          bar: {
            borderRadius: 0,
            horizontal: true,
            barHeight: '80%',
            isFunnel: true,
          },
        },
        dataLabels: {
          enabled: true,
          formatter: function (val, opt) {
            return opt.w.globals.labels[opt.dataPointIndex] + ':  ' + val
          },
          dropShadow: {
            enabled: true,
          },
        },
        title: {
          text: 'Recruitment Funnel',
          align: 'middle',
        },
        xaxis: {
          categories: [
            'Sourced',
            'Screened',
            'Assessed',
            'HR Interview',
            'Technical',
            'Verify',
            'Offered',
            'Hired',
          ],
        },
        legend: {
          show: false,
        },
        };
    }
    else if(graphtype == 'stackedbar' || graphtype == 'stackedcolumn'){
        var options = {
          series: [{
          name: 'Marine Sprite',
          data: [44, 55, 41, 37, 22, 43, 21]
        }],
          chart: {
          type: 'bar',
          height: 350,
          stacked: true,
        },
        plotOptions: {
          bar: {
            horizontal: (graphtype === 'stackedbar'),
            dataLabels: {
              total: {
                enabled: true,
                offsetX: 0,
                style: {
                  fontSize: '13px',
                  fontWeight: 900
                }
              }
            }
          },
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        title: {
          text: 'Fiction Books Sales'
        },
        xaxis: {
          categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
          labels: {
            formatter: function (val) {
              return val
            }
          }
        },
        yaxis: {
          title: {
            text: undefined
          },
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + "K"
            }
          }
        },
        fill: {
          opacity: 1
        },
        legend: {
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
        }
        };
    }
    else{
        var options = {
            series: [
                {
                    name: "High - 2013",
                    data: [28, 29, 33, 36, 32, 32, 33],
                }
               
            ],
            chart: {
                height: 280,
                type: graphtype,
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.1
                },
                toolbar: {
                    show: true
                },
              
            },
            colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#00D9E9', '#FF66C3', '#FFE100'],
            
            dataLabels: {
                enabled: true,
                
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#fff', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.1
                },
            },
            markers: {
                size: 1,
                show:false
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                title: {
                    text: 'Month'
                }
            },
           
        //    colors:['red','blue'],
            legend: {

                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            },
            
        };
    }

        // Create the chart inside the newly created <div> element
      var chart ='chart'+i;
      window[chart] = new ApexCharts(chartbox[0], options);
      window[chart].render();
  
  });
}); 
$(".chartdim").each(function(){
    $(this).off('change').on('change', function(){
        var chartId = $('#editChartModal').attr('data-chartid');
        var newWidth = $('#chartwidth').val();
        var newHeight = $("#chartheight").val();

        $('#' + chartId).css({ 'width': newWidth + '%', 'height': newHeight + '%'});
        var chartbox = $("#"+chartId);
        // Update chart size in local storage
        var pptbox = $("#pptbox");
        var chartpositionTop = (chartbox.position().top / pptboxheight) * 100;
        var chartpositionLeft = (chartbox.position().left / pptboxwidth)* 100;
        if ($('#' + chartId).children('table').length > 0) {
        
          updatetableInLocalStorage(chartId,chartpositionTop,chartpositionLeft, newWidth, newHeight);
          }
          else{

        window[chartId].updateOptions({
            chart: {
                width:  '100%',
                height: newHeight + '%'
            }
        });
        updateChartInLocalStorage(chartId, chartpositionTop,chartpositionLeft, newWidth, newHeight);
      }
      
        
 
       
    });
});
// JavaScript
document.getElementById('title').addEventListener('input', function() {
  var newTitle = this.value;
  var chartId = $('#editChartModal').attr('data-chartid');
  window[chartId].updateOptions({
    title: {
      text: newTitle
    }
  });
});

document.getElementById('x-axis-title').addEventListener('input', function() {
  var newXAxisTitle = this.value;
  var chartId = $('#editChartModal').attr('data-chartid');
  window[chartId].updateOptions({
    xaxis: {
      title: {
        text: newXAxisTitle
      }
    }
  });
});

document.getElementById('y-axis-title').addEventListener('input', function() {
  var newYAxisTitle = this.value;
  var chartId = $('#editChartModal').attr('data-chartid');
  window[chartId].updateOptions({
    yaxis: {
      title: {
        text: newYAxisTitle
      }
    }
  });
});

   
$('#saveChartSize').click(function(){
    var chartId = $('#editChartModal').attr('data-chartid');
    var user = $("#byuser").val();
    var title = $("#title").val();

    // window[chartId].updateOptions({
    //         title:{
    //         text:title
    //    }
  // });
    // var formdata = $("#filterform").serialize();
    var formdata = new FormData($("#filterform")[0]);
    $.ajax({
        url:'<?php echo site_url('Customreports/filtereddata');?>',
        data:formdata,
        dataType:'JSON',
        contentType:false,
        processData:false,
        method:'post',
        success:function(data){
            var owner = [];
            var sub_total = [];
            var xaxisgrp=[];
          // start table
        
          if(data.table == 'true'){
          var table = `<thead><tr>`;
          Object.keys(data[0]).forEach((index) => {
              if(index != 'grp'){
                if(index != 'subtotal'){
                 table += `<th>${index}</th>`;
                }
              }
       });
          table += `</tr></thead><tbody>`;
          var keys = Object.keys(data);
for (var i = 0; i < keys.length - 1; i++) {
    table += `<tr>`;
    Object.keys(data[keys[i]]).forEach((index) => {
      if(index != 'grp'){
        if(index != 'subtotal'){
        table += `<td>${data[keys[i]][index]}</td>`;
        }
      }
    });
    table += `</tr>`;
}
          table += `</tbody>`;
         // end table
          $("#dynamictable"+chartId).html(table);
         var dwidth = $("#dynamictable"+chartId).width();
         var dheight = $("#dynamictable"+chartId).height();
         $("#dynamictable"+chartId).parent().css({'width':dwidth+20,'height':dheight});

        var chartbox = $("#"+chartId);
    var pptbox = $("#pptbox");
    var windowWidth = window.innerWidth;
    var chartboxWidthPercentage = (chartbox.width() / pptboxwidth) * 100;
    var windowHeight = window.innerHeight;
    var chartboxHeightPercentage = (chartbox.height() / pptboxheight) * 100;
    var chartpositionTop = (chartbox.position().top / pptboxheight) * 100;
    var chartpositionLeft = (chartbox.position().left / pptboxwidth) * 100;
        // var positabletop=$("#dynamictable").position().top;
        // var positableleft=$("#dynamictable").position().left;
        // var tablewidth=$("#dynamictable").width();
        // var tableheight=$("#dynamictable").height();
        var tableData = {
    html: table,
    chartid:chartId,
    position: {
        top: chartpositionTop,
        left: chartpositionLeft
    },
    size: {
        width: chartboxWidthPercentage,
        height: chartboxHeightPercentage
    }
};
localStorage.setItem('myTable'+chartId, JSON.stringify(tableData));
          }
          else{
         
            for (var i in data) {
            if(data[i].grp== null || data[i].grp == ""){
                data[i].grp = 'undefined';
            }
          xaxisgrp.push(data[i].grp);
          sub_total.push(parseInt(data[i].subtotal));
        }
        for (var i in data) {
          owner.push(data[i].owner + ' (₹) ');
        }
        var sum_so = 0;
        Array.from(sub_total).forEach((e)=>{
          sum_so += e;
        });
        var graph = window[chartId].opts.chart.type;
      
       if(graph == 'pie' || graph == 'semidonut' || graph == 'donut' ){
        var updatedOptions = {
                  series: sub_total,
                  labels: xaxisgrp,
                  
          };

           window[chartId].updateOptions(updatedOptions);
       }
       else{
        var updatedOptions = {
    series: [
        {
            name: "User",
            data: sub_total
        }
    ],
   
    xaxis: {
        categories: xaxisgrp
    }
};
       
window[chartId].updateOptions(updatedOptions);
    }
  
    var chartbox = $("#"+chartId);
    var pptbox = $("#pptbox");
    var windowWidth = window.innerWidth;
    var chartboxWidthPercentage = (chartbox.width() / pptboxwidth) * 100;
    var windowHeight = window.innerHeight;
    var chartboxHeightPercentage = (chartbox.height() / pptboxheight) * 100;
    var chartpositionTop = (chartbox.position().top / pptboxheight) * 100;
    var chartpositionLeft = (chartbox.position().left / pptboxwidth) * 100;

    saveChartToLocalStorage(chartId, window[chartId].opts,updatedOptions, chartpositionTop,chartpositionLeft, chartboxWidthPercentage, chartboxHeightPercentage);
        }
        }
      
    });
});
  

function saveChartToLocalStorage(chartId, options,updatedoptions, positiontop,positionleft, width, height) {
        var chartData = {
            id: chartId,
            updatedoptions:updatedoptions,
            options: options,
            positiontop: positiontop,
            positionleft:positionleft,
            width: width,
            height: height
        };
        // Convert to JSON and save to local storage
        localStorage.setItem(chartId, JSON.stringify(chartData));
    }

    // Function to update chart data in local storage
    function updateChartInLocalStorage(chartId, positiontop,positionleft, width, height) {
        var chartData = JSON.parse(localStorage.getItem(chartId));
        chartData.positiontop = positiontop;
        chartData.positionleft = positionleft;
        chartData.width = width;
        chartData.height = height;
        localStorage.setItem(chartId, JSON.stringify(chartData));
    }
function updatetableInLocalStorage(chartid,positiontop,positionleft, width, height) {
        var chartData = JSON.parse(localStorage.getItem('myTable'+chartid));
        chartData.position.top = positiontop;
        chartData.position.left = positionleft;
        chartData.size.width = width;
        chartData.size.height = height;
        localStorage.setItem('myTable'+chartid, JSON.stringify(chartData));
    }
     function loadTableFromLocalStorage() {
      var largestid =0;
      for (var i = 0; i < localStorage.length; i++) {
        var key = localStorage.key(i);
        if (key.startsWith('myTablechart')) {
          if(key.match(/\d+/g).join('') > largestid){
            largestid = key.match(/\d+/g).join('');
          }
    var savedTableData = localStorage.getItem(key);
    if (savedTableData) {
        savedTableData = JSON.parse(savedTableData);
   if (savedTableData.chartid) {
          if(savedTableData.chartid.match(/\d+/g).join('') > largestid){
            largestid = savedTableData.chartid.match(/\d+/g).join('');
          }
        }
        // Create chart element with loaded data
        var chartElement = $('<div></div>').addClass('card graphitem').attr('id', savedTableData.chartid);

        // Create table container
        var tableContainer = $('<table></table>').attr('id', 'dynamictable'+savedTableData.chartid).addClass('preloaded-table');
       

        // Set the table HTML
        tableContainer.html(savedTableData.html);
        chartElement.append(tableContainer);

        // Set additional properties
        chartElement.css({
            position:'absolute',
            left: savedTableData.position.left + '%',
            top: savedTableData.position.top + '%',
            width: savedTableData.size.width + '%',
            height: savedTableData.size.height + '%'
        });

        // Make the chart element draggable
        chartElement.draggable();

        // Append the chart element to the specified element
        $("#pptbox").append(chartElement);
    }
  }
  }
    return largestid;
}


// Call the function to load table from local storage


// Call the function to load table from local storage

    // Load charts from local storage when the page loads
    function loadChartsFromLocalStorage() {
    // Initialize chartData variable
    var chartData = null;
    var largestid = 0;
    // Loop through all keys in local storage
    for (var i = 0; i < localStorage.length; i++) {
        var key = localStorage.key(i);
        // Check if key starts with 'chart'
        if (key.startsWith('chart')) {
          if(key.match(/\d+/g).join('') > largestid){
            largestid = key.match(/\d+/g).join('');
          }
            // Parse chart data from localStorage
            chartData = JSON.parse(localStorage.getItem(key));
            // Create chart with loaded data
            var chartElement = $('<div></div>').attr('id', chartData.id).attr('class', 'card graphitem').css({
                'position': 'absolute',
                'top': chartData.positiontop + '%',
                'left': chartData.positionleft + '%',
                'width': chartData.width + '%',
                'height': chartData.height + '%'
            });
            chartElement.draggable();
             $("#pptbox").append(chartElement);
            var chart = chartData.id;
            window[chart] = new ApexCharts(chartElement[0], chartData.options);
            window[chart].render();
            
            window[chart].updateOptions(chartData.updatedoptions);
             window[chart].updateOptions({
               chart: {
                
                 height: chartData.height + '%'
             }
             });
           
        }
    }
    
    // Check if chartData is null
   
    // Return the id of the last chart processed
    return largestid;
}
    // Load charts from local storage when the page loads
    $(document).on('dblclick', '.graphitem', function(e) {
    e.stopPropagation();
   
    $('.chart-dropdown').remove();
     // Create dropdown menu
    var $dropdown = $('<div class="chart-dropdown" style="position: absolute; background-color: white; border: 1px solid #ccc; padding: 10px; z-index: 100;"></div>');
    $dropdown.append('<a href="javascript:void(0);" class="edit-chart">Edit</a><br>');
    $dropdown.append('<a href="javascript:void(0);" class="remove-chart">Remove</a>');

    // Position the dropdown based on where the user clicked
    $dropdown.css({ top: e.pageY, left: e.pageX });

    // Append dropdown to the body
    $('body').append($dropdown);

    // Click event for removing the chart
    $dropdown.on('click', '.remove-chart', function() {
        // Find the chart container element
        var $chartContainer = $(e.target).parents('.graphitem');
         
      
        $chartContainer.remove(); // Remove the chart
        $('.chart-dropdown').remove(); // Remove the dropdown menu
        var chartId = $chartContainer.attr('id');
         localStorage.removeItem(chartId);
           localStorage.removeItem('myTable'+chartId);
    });

    $dropdown.on('click', '.edit-chart', function() {
        // Find the chart container element
        var $chartContainer = $(e.target).parents('.graphitem');
        var chartId = $chartContainer.attr('id'); // Get the ID of the chart container
        // Store the current chartId in the modal for reference
        $('#editChartModal').attr('data-chartid', chartId);
        if(!($("#"+chartId).children().is('table'))) {
         
        $("#coldops").html('');
        }
        // Show the modal
        // Highlight the selected chart
        $(".graphitem").css('border','none');    
        $chartContainer.css('border','2px solid black');
        $('.chart-dropdown').remove();
     
       
    });

    // Prevent the dropdown menu from being immediately closed
    $dropdown.click(function(e) {
        e.stopPropagation();
    });
});

// Close the dropdown menu if the user clicks anywhere else on the page
$(document).click(function(){
    $('.chart-dropdown').remove();
});


function deletefile() {
   
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('chart')) {
            localStorage.removeItem(key);
            i--;
        }
         if (key.startsWith('myTablechart')) {
            localStorage.removeItem(key);
            i--;
        }
    }
   
    $("#pptbox").html('');
}

</script>
