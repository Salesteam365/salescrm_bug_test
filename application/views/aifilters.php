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


/*graph css */
    
.card-body{

/*    border:1px dashed black;*/
  
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
        width: 18rem; /* Fixed width for labels */
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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Filters</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Filters</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- tabs -->
  <ul class="nav nav-tabs">

     <li onclick="change_nav('Salesorder_data','so_li');" class="nav-item" >
      <a id="so_li" class="nav-link randmCl active" href="javascript:void(0);">All Data Filter</a>
    </li>


    <li onclick="change_nav('leads_data','lead_li');" class="nav-item" >
      <a id="lead_li" class="nav-link randmCl" href="javascript:void(0);"> Graph Filter </a>
    </li>

    <li onclick="change_nav('Opportunity_data','opp_li');" class="nav-item" >
      <a id="opp_li" class="nav-link randmCl" href="javascript:void(0);">Profit Filter</a>
    </li>


   <!--  <li onclick="change_nav('Quotation_data','quote_li');" class="nav-item">
      <a id="quote_li" class="nav-link randmCl" href="javascript:void(0);">Quotation</a>
    </li> -->

   

  </ul>


<?php

$dataArr=array("orange"," green"," pink","blue"," purple");
?>


  <!-- Tab panes -->
  <div class="tab-content">

     <div id="Salesorder_data" class="container-fluid hddnCl"><br>

       <!-- Main content -->
      <section class="content">

              <div class="container-fluid">
               <div class="row mb-2">  
               </div>
                <!-- /.row -->
                <div class="container-fliud filterbtncon mx-0" style="border-radius:4px;">            
                  <div class="row mb-3">

                    <div class="col-lg-10">  
                         
                    </div>

                    <!--<div class="col-lg-2">    -->
                    <!--  jnbnjhbn       -->
                    <!--</div>-->

                    <!--<div class="col-lg-2">-->
                    <!--  dfgdghd-->
                    <!--</div>-->

                    <!--<div class="col-lg-2">-->
                    <!--   hjklhbljf-->
                    <!--</div>-->

                    <!-- <div class="col-lg-2">-->
                    <!--   hjklhbljf-->
                    <!--</div>-->

                    <div class="col-lg-2">
                      <div class="refresh_button float-right">
                        <button type="button" class="btn btnstop mb-3" data-toggle="modal" data-target="#exampleModalScrollable" id="btn1">
                        <i class="fas fa-filter"></i> Filter
                        </button>
                      </div>
                    </div>


                    <!--All Data Filter Modal -->
                    
                   <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="     true" data-keyboard="false" data-backdrop="static">
                      <div class="modal-dialog modal-dialog-scrollable" id="filterMdl" role="document" style="position: fixed; right: 0px; margin: auto; width: 20%;">
                     
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                     
                          <div class="modal-body">
                            <form method="post">
                     
                              <!-- Start Date Input -->
                              <div class="col-lg-12 mb-2">
                                <label for="startDateAll" style="font-size: 0.85rem;">Start Date : </label>
                                <input type="date" class="form-control form-control-sm" id="startDateAll" name="startDateAll" placeholder=" " style="width: 100%;">
                              </div>
                     
                              <!-- End Date Input -->
                              <div class="col-lg-12 mb-2">
                                <label for="endDateAll" style="font-size: 0.85rem;">End Date : </label>
                                <input type="date" class="form-control form-control-sm" id="endDateAll" name="endDateAll" placeholder=" " style="width: 100%;">
                              </div>
                     
                              <!-- User Selection -->
                              <div class="col-lg-12 mb-2">
                                <label for="filterUserAll" style="font-size: 0.85rem;">Select User : </label>
                                <select id="filterUserAll" name="filterUserAll" class="form-control form-control-sm" style="width: 100%; font-size: 0.85rem;">
                                </select>
                              </div>
                     
                              <!-- Customer Selection -->
                              <div class="col-lg-12 mb-2">
                                <label for="filterCustomerAll" style="font-size: 0.85rem;">Select Customer : </label>
                                <select id="filterCustomerAll" name="filterCustomerAll" class="form-control form-control-sm" style="width: 100%; font-size: 0.85rem;">
                                </select>
                              </div>
                     
                              <!-- Sales ID Selection -->
                              <div class="col-lg-12 mb-2">
                                <label for="salesIdAll" style="font-size: 0.85rem;">Sales ID : </label>
                                <select id="salesIdAll" name="salesIdAll" class="form-control form-control-sm" style="width: 100%; font-size: 0.85rem;">
                                </select>
                              </div>
                     
                              <!-- PO Number Input -->
                              <div class="col-lg-12 mb-2">
                                <label for="po_filterAll" style="font-size: 0.85rem;">PO Number : </label>
                                <div class="first-one custom-dropdown dropdown">
                                  <input type="text" name="po_filterAll" id="po_filterAll" class="form-control form-control-sm" placeholder="Po Number" style="width: 100%; font-size: 0.85rem;">
                                </div>
                              </div>
                     
                              <!-- PO Date Input -->
                              <div class="col-lg-12 mb-2">
                                <label for="po_date" style="font-size: 0.85rem;">PO Date : </label>
                                <div class="first-one custom-dropdown dropdown">
                                  <input type="date" name="po_date" id="po_date" class="form-control form-control-sm" placeholder="Select Po Date" style="width: 100%; font-size: 0.85rem;">
                                </div>
                              </div>
                     
                              <!-- Order Type Selection -->
                              <div class="col-lg-12 mb-2">
                                <label for="new_Renew" style="font-size: 0.85rem;">Order Type : </label>
                                <select id="new_Renew" name="new_Renew" class="form-control form-control-sm" style="width: 100%; font-size: 0.85rem;">
                                  <option value="">Select Order Type</option>
                                  <option value="new">New</option>
                                  <option value="renew">Renew</option>
                                </select>
                              </div>
                     
                            </form>
                          </div>
                     
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-sm" id="applyFilterBtn" style="font-size: 0.85rem;">Apply Filter</button>
                            <a href="#" data-dismiss="modal" style="font-size: 0.85rem;">Cancel</a>
                          </div>
                     
                        </div>
                      </div>
                    </div>
 
                    <!-- All Data Filter Model -->

                  </div>

                </div>
                  <!-- /.container-fluid -->
              </div>
   
      </section>
      <!-- /.content -->

      <section class="content">
          <div class="container-fluid">
              <!-- Main row -->
              <div class="row">
                   <?php if($this->session->userdata('type') == 'admin') { ?>
                  <section class="col-lg-12 connectedSortable">
                      <!-- /.card -->
                      <!-- tables -->
                      <div class="card org_div">
                      <!-- /.card-header -->
                     
                        <div class="card-body">
                           <table id="ajax_datatable" class="table table-striped  table-bordered table-responsive-lg" cellspacing="4" width="100%" style="font-size: 15px; ">
                          
                              <thead>

                                 <tr>
                                    <?php if(check_permission_status('Salesorders','delete_u')==true): ?>
                                    <!-- <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>-->
                                    <?php endif; ?>
                                    <th class="th-sm" style="width:10%;">Owner</th>
                                    <th class="th-sm">Customer Name</th>
                                    <th class="th-sm">Subject</th>
                                    <th class="th-sm" >Salesorder ID</th>
                                    <th class="th-sm">Status</th>
                                    <th class="th-sm">Added Date</th>
                                    <th class="th-sm">Customer PO. NO.</th>
                                    <th class="th-sm">Customer PO. Date</th>
                                   
                                 </tr>
                              </thead>
                              <tbody>
                              </tbody>
                           </table>
                        </div>
                      </div>
              
                  </section>
                  <?php } ?>
              </div>
          </div>
      </section>
    </div>






    <div id="leads_data" class="container-fluid hddnCl" style="display:none;"><br>
      <!-- Main content -->
      <section class="content">

              <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                  
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
                     </ol> -->
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
                                    <li data-graphtype="table" class="graphtypes"><span style="color: #007bff;">&#x1F4C8;</span> table</li>
                                    <li data-graphtype="line" class="graphtypes"><span style="color: #007bff;">&#x1F4C8;</span> Line Chart</li>
                                    <li data-graphtype="bar" class="graphtypes"><span style="color: #6610f2;">&#x1F4CA;</span> Bar Chart</li>
                                    <li data-graphtype="stackedcolumn" class="graphtypes"><span style="color: #6610f2;">&#x1F4CA;</span>Bar Chart with labels</li>
                                    <li data-graphtype="distributedbar" class="graphtypes"><span style="color: #2411f2;">&#x1F4CA;</span> Colorful Bar Chart</li>
                                    <!--<li data-graphtype="area" class="graphtypes"><span style="color: #28a745;">&#x1F4C9;</span> Area Chart</li>-->
                                    <li data-graphtype="pie" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Pie Chart</li>
                                    <li data-graphtype="semidonut" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Semi Donut Chart</li>
                                    <li data-graphtype="donut" class="graphtypes"><span style="color: #dc3545;">&#x1F967;</span> Donut Chart</li>
                                    <li data-graphtype="stackedbar" class="graphtypes"><span style="color: #dc3545;">&#x1F4CC;</span>horizontal bar with labels</li>
                                    <li data-graphtype="funnel" class="graphtypes"><span style="color: #dc3545;">&#x1F4C0;</span> Funnel Chart</li>
                                    <li data-graphtype="radar" class="graphtypes"><span style="color: #fd7e14;">&#x1F6A8;</span> Radar Chart</li>
                                    <li data-graphtype="pyramid" class="graphtypes"><span style="color: #fd7e14;">&#x1F6A8;</span> Pyramid Chart</li>
                              </ul>
                        </div>
                    </div>
                          <!-- ----------------------------------------AI form ------------------------------------------->

                    <div class="col-lg-6">     
                    </div>

                      <!-- ---------------------------------------------AI form -------------------------------------------------------------->


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
                         
                          <?php }else{ ?>
                          
                          <button class="btnstop" id="deletefile" onclick="deletefile();">Delete</button>
                          <?php  } } ?>
                      </div>
                    </div>

                  </div>

                </div>
                  <!-- /.container-fluid -->
              </div>
      </section>
      <!-- /.content -->


      <!-- Main content -->
        <section class="content" >
            <div class="container-fluid">
                  <!-- Main row -->
                  <!-- Map card -->
                <div class="row">
                  <div class="col-md-9 pptcon">
                    <div class="card org_div p-0 m-0">
                  
                      <div class="card-body" id="pptbox" style="border:1px dashed black; height:98vh;"> </div>
                      
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

                        <form id="filterform" style="max-height:50vh;overflow-y:auto;">
                          <!-- Your form fields --> 
                          <div class="form-group">
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
                
                  <div class="collapse" id="collapseFilters"> </div>
          
                  <!-- /.card-body -->
              </div>
              <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>




    <div  class="container-fluid hddnCl" id="Opportunity_data" style="display:none;">
        <section class="content">

              <div class="container-fluid">
               <div class="row mb-2">
                  <div class="col-sm-6">
                  
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                     <!-- <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Customer</li>
                     </ol> -->
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
                          
                        </div>
                    </div>
                          <!-- ----------------------------------------AI form ------------------------------------------->

                    <div class="col-lg-6"> 


                    </div>

                      <!-- ---------------------------------------------AI form -------------------------------------------------------------->

                    <div class="col-lg-4">
                      <div class="refresh_button float-right">
                           <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-filter"></i> Profit Filter </button>
                      </div>
                    </div>

                  </div>

                </div>
                  <!-- /.container-fluid -->
              </div>
        </section>

         <section class="content">
              <div class="container-fluid">
               <div class="row mb-2">
               </div>
               
                <div class="container-fliud filterbtncon mx-0" style="border-radius:4px;">           
                  <div class="row mb-3">
                        <div class="col-lg-6"><strong> Organizations Name </strong> </div>
                         <div class="col-lg-6"><strong> Profit By Organizations </strong> </div>
                    <div class="col-lg-12">
                      <span id="resultProfit"> </span>
                       
                    </div>
                  </div>

                </div>
              </div>
        </section>

      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
             <div class="row">
 
                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-right selectCustom" role="document" >
                <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Filters </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 
                 
                <form class="" id="filterformProfit" enctype ="multipart/form-data">
                <div class="modal-body">
                 
                <div class="form-group">
                <label for="startDate"> Start Date : </label>
                <input type="date" class="form-control" id="startDate" name = "startDate" placeholder=" "style="width:29rem;>
               
                </div>
                 
                <div class="form-group">
                <label for="endDate"> End Date : </label>
                <input type="date" class="form-control" id="endDate" name = "endDate" placeholder=" "style="width:29rem;>
        
                </div>
                 
                              
                <div class="form-group " >
                <label for="filterUser"> Select User </label>
                <select id="filterUser" name = "filterUser" class="form-control" style="width:29rem;">
                <!-- <option selected>Select Customer</option> -->
                </select>
                </div>
                 
                 
                <div class="form-group">
                <label for="filterCustomer"> Select Customer </label>
                <select id="filterCustomer" name = "filterCustomer" class="form-control" style="width:29rem;">
                <!-- <option selected>Select Customer</option> -->
                </select>
                </div>
 
                  <div class="form-group">
                    <label for="salesId"> Sales ID </label>
                    <select id="salesId" name = "salesId" class="form-control" style="width:29rem;">
                    <!-- <option selected>Select Sales ID</option> -->
                    </select>
                    </div>
                     
                    </div>
                    <div class="modal-footer">
                    
                    </div>
                     
                    </form>
                     
                    <div class="modal-footer">
                      <button class="btn btn-secondary" id ="resetButton" data-dismiss="modal">Reset</button>
                      <button class="btn btn-primary" id="saveFilterProfit" data-dismiss="modal">Apply Filter</button>
                     
                    </div>
                    </div>
                    </div>
                    </div>
                     
                    </div>

          </div>
      </section>
    </div>

  </div>
  

  </div>
  <!-- /.content-wrapper -->
 <?php $this->load->view('footer');?>
</div>
<!-- ./wrapper -->
<!-- common footer include -->
<?php $this->load->view('common_footer');?>



  <script>
    $(document).ready(function () {
        // var table;
        table = $('#ajax_datatable').DataTable({
            "processing": true, 
            "serverSide": true,
             "pageLength": 15, 
            "order": [], 
            
            "ajax": {
                "url": "<?= base_url('aifilters/ajax_list ')?>",
                "type": "POST",
                "data" : function(data)
                {
                  data.start_date = $('#startDateAll').val(); 
                 data.end_date = $('#endDateAll').val(); 
                 data.searchUser = $('#filterUserAll').val();
                 data.searchcustomer = $('#filterCustomerAll').val();
                  data.searchsaleID = $('#salesIdAll').val();
                  data.searchPo = $('#po_filterAll').val();
                 data.searchPoDate = $('#po_date').val();
                 data.new_Renew = $('#new_Renew').val(); 
                 data.search_status = $('#status').val(); 
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
              "targets": [0],
              "orderable": false, //set not orderable
            },
            ],
        });

        // Trigger the filter action on 'Apply Filter' button click
        $('#applyFilterBtn').on('click', function() {
            var startDate = $('#startDateAll').val();
            var endDate = $('#endDateAll').val();
            var searchUser = $('#filterUserAll').val();
            var searchcustomer = $('#filterCustomerAll').val();
            var searchsalesID = $('#salesIdAll').val(); 
            var searchPo = $('#po_filterAll').val(); 
            var searchPodate = $('#po_date').val(); 
            var searchnew_Renew = $('#new_Renew').val(); 
            var searchstatus = $('#status').val();
            // var searchUserName = $('#filterUserAll option:selected').text();
                                                                             
              if (startDate && endDate) {
                  getfilterdData(startDate, endDate, 'getsovalue', 'cust_filter');
                    // $('#linkedinvoiceform').modal('hide');
                    // $('#start_date').val('');
                    // $('#end_date').val('');
                  }

              if (searchUser) {
                getfilterdData(searchUser, 'dummyParam', 'getsovalue', 'cust_filter');
              }

              if (searchcustomer) {
                getfilterdData(searchcustomer, 'dummyParam', 'getsovalue', 'cust_filter');
              }

              if (searchsalesID) {
                getfilterdData(searchsalesID, 'dummyParam', 'getsovalue', 'cust_filter');
                // $('#linkedinvoiceform').modal('hide');
              }

              if (searchPo) {
                getfilterdData(searchPo, 'dummyParam', 'getsovalue', 'cust_filter');
                // $('#linkedinvoiceform').modal('hide');
              }

              if (searchPodate) {
              getfilterdData(searchPodate, 'dummyParam', 'getsovalue', 'cust_filter');
              // $('#linkedinvoiceform').modal('hide');
              }

              if (searchnew_Renew) {
                getfilterdData(searchnew_Renew, 'dummyParam', 'getsovalue', 'cust_filter');
                // $('#linkedinvoiceform').modal('hide');
              }
              // else{
              //   alert('Please select Any Filter Data.');
              // }

          });

    });



    function change_nav(data, liid)
    {
    $(".randmCl").removeClass('active');
    $("#"+liid).addClass('active');
    $(".hddnCl").hide();
    $("#"+data).show();
    }

  
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
          // alert(graphtype);
          var chartbox = $('<div></div>').attr('id', 'chart'+i).attr('class','card graphitem').css({'width':'30%','height':'9%','margin':'5px','padding':'5px','padding-bottom':'8px'});
              
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
                </table>`;
            chartbox.append(table);

          }else if(graphtype == 'pie'){
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
                  text: 'Distribution of Sales by Team', 
                  align: 'center', 
                  margin: 15, 
                  offsetX: 0, 
                  offsetY:0, 
                  floating: false, 
                  style: {
                      fontSize: '16px', 
                      fontWeight: 'bold', 
                      color: '#263238' 
                  },
                },
              };
            

          }else if(graphtype =='distributedbar'){
      
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
          }else if(graphtype == 'semidonut'){
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
          }else if(graphtype == 'donut'){
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
          }else if(graphtype == 'funnel'){
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
        }else if(graphtype == 'stackedbar' || graphtype == 'stackedcolumn'){
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
        }else if(graphtype == 'pyramid'){
          var options = {
            series: [
            {
              name: "",
              data: [200, 330, 548, 740, 880, 990, 1100, 1380],
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
              distributed: true,
              barHeight: '80%',
              isFunnel: true,
            },
          },
          colors: [
            '#F44F5E',
            '#E55A89',
            '#D863B1',
            '#CA6CD8',
            '#B57BED',
            '#8D95EB',
            '#62ACEA',
            '#4BC3E6',
          ],
          dataLabels: {
            enabled: true,
            formatter: function (val, opt) {
              return opt.w.globals.labels[opt.dataPointIndex] 
            },
            dropShadow: {
              enabled: true,
            },
          },
          title: {
            text: 'Pyramid Chart',
            align: 'middle',
          },
          xaxis: {
            categories: ['Sweets', 'Processed Foods', 'Healthy Fats', 'Meat', 'Beans & Legumes', 'Dairy', 'Fruits & Vegetables', 'Grains'],
          },
          legend: {
            show: false,
          },
          };
            

          }else{
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



    $(document).ready(function() {
      $('.main-footer').css('');
    });

    var table;
    var colarr=[];
    var changed = [];
    var showcol = [];
    var saveChangesClicked;

    $('#exampleModal').on('show.bs.modal', function () {
        saveChangesClicked = false;
        changed=[];
        $(".inputbox").each(function(){
             var index = $(".inputbox").index(this);
             if(this.checked){
              showcol.push(index);
             }
         
        });
       
     });
  

    $('#exampleModal').on('hidden.bs.modal', function () {
        if (!saveChangesClicked) {
          changed.forEach(function (index) {
                if (!$(".inputbox").eq(index).prop('checked')) {
                    $(".inputbox").eq(index).prop('checked', true);
                } else {
                    $(".inputbox").eq(index).prop('checked', false);
                }
            });
            
            changed=[];
        }
      
    });
    
      function disableClick(e) {
        e.stopPropagation();
        e.preventDefault();
      }


  // < --------------------- Start Customers Fetch ------------------------------------>

  $(document).ready(function() {
      AllFilterData();
      function AllFilterData(){
                // alert('tet');
                $.ajax({
                    url: '<?= site_url('aifilters/filterDataAll');?>',
                    method: 'post',
                    dataType: 'json',
                    data: {},
                    success: function(res) {
                    if (res[0].status === "success") {
                        var filterData = res[0].filterData;
                        var output = '';

                        filterData.forEach(function(item) {
                            var base_url = '<?php echo base_url(); ?>';
                            var initial_total_value = parseFloat(item.total_initial_total);
                            var sub_totals_value = parseFloat(item.total_sub_total);
                            var profit = sub_totals_value - initial_total_value;
                            // var formatted_profit = profit.toFixed(2);
                            
                             var number = parseFloat(profit).toFixed(2); 
                            var parts = number.split("."); 
                            var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            var decimalPart = parts[1];

                            var formatted_profit = "₹" + integerPart + "." + decimalPart;


                            output += '<div class="container-fluid filterbtncon" style="border-radius:12px; background:#fff; padding-top:22px; padding-right:12px; padding-left:24px; margin:12px; margin-right:32px;">';
                            output += '<div class="row mb-3">';

                            // org_name with collapse functionality
                            output += '<div class="col-lg-6">';
                            output += '<p><i class="fa fa-chevron-right"></i> &nbsp;';
                            output += '<a data-toggle="collapse" href="#org-details-' + item.id + '" role="button" aria-expanded="false" aria-controls="org-details-' + item.id + '" data-org-id="' + item.org_id + '" data-loaded="false" onclick="handleAccordionClick(this)">';

                            // output += '<a data-toggle="collapse" href="#org-details-' + item.id + '" role="button" aria-expanded="false" aria-controls="org-details-' + item.id + '" onclick="fetchOrgDetails('+ item.org_id +')">';
                            output += item.org_name;
                            output += '</a>';
                            output += '</p>';
                            output += '</div>';

                            // output += '<div class="col-lg-2"><p><a href="' + base_url + 'salesorders/view_pi_so/' + item.id + '">' + item.saleorder_id + '</a></p></div>';
                            // output += '<div class="col-lg-2"> <p>' + item.status + '</p></div>';
                            output += '<div class="col-lg-2"> <p>' + formatted_profit + '</p></div>';

                            output += '</div>&nbsp;'; 

                            output += '<div class="collapse" id="org-details-' + item.id + '">';
                            output += '<div class="card card-body" style="margin-top: 10px;" id="OrgName-' + item.org_id + '">';
                            output += '</div>';
                            output += '</div>';

                            output += '</div>';  
                        });

                        $('#resultProfit').html(output);
                    } else {
                        var output = '<div class="alert alert-warning" role="alert" style="width:1640px; text-align:center">';
                        output += '<strong>Warning:</strong> ' + res[0].message;
                        output += '</div>';
                        $('#resultProfit').html(output);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
                    
                });
      }

      $('#saveFilterProfit').click(function(){
           var formData = $('#filterformProfit').serialize();
            // var formdata = new FormData($("#filterformProfit")[0]);
            console.log('Form data serialized:', formData); 
            // alert(formData);

            $.ajax({
                url: '<?= site_url('aifilters/Profit_customers');?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res[0].status === "success") {
                        var filterData = res[0].filterData;
                        var output = '';

                        filterData.forEach(function(item) {
                            var base_url = '<?php echo base_url(); ?>';
                            var initial_total_value = parseFloat(item.total_initial_total);
                            var sub_totals_value = parseFloat(item.total_sub_total);
                            var profit = sub_totals_value - initial_total_value;
                            // var formatted_profit = profit.toFixed(2);
                            
                            
                            
                             var number = parseFloat(profit).toFixed(2); 
                            var parts = number.split("."); 
                            var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            var decimalPart = parts[1];

                            var formatted_profit = "₹" + integerPart + "." + decimalPart;


                            output += '<div class="container-fluid filterbtncon" style="border-radius:12px; background:#fff; padding-top:22px; padding-right:12px; padding-left:24px; margin:12px; margin-right:32px;">';
                            output += '<div class="row mb-3">';

                            // org_name with collapse functionality
                            output += '<div class="col-lg-6">';
                            output += '<p><i class="fa fa-chevron-right"></i> &nbsp;';
                            output += '<a data-toggle="collapse" href="#org-details-' + item.id + '" role="button" aria-expanded="false" aria-controls="org-details-' + item.id + '" data-org-id="' + item.org_id + '" data-loaded="false" onclick="handleAccordionClick(this)">';

                            // output += '<a data-toggle="collapse" href="#org-details-' + item.id + '" role="button" aria-expanded="false" aria-controls="org-details-' + item.id + '" onclick="fetchOrgDetails('+ item.org_id +')">';
                            output += item.org_name;
                            output += '</a>';
                            output += '</p>';
                            output += '</div>';

                            // output += '<div class="col-lg-2"><p><a href="' + base_url + 'salesorders/view_pi_so/' + item.id + '">' + item.saleorder_id + '</a></p></div>';
                            // output += '<div class="col-lg-2"> <p>' + item.status + '</p></div>';
                            output += '<div class="col-lg-2"> <p>' + formatted_profit + '</p></div>';

                            output += '</div>&nbsp;'; 

                            output += '<div class="collapse" id="org-details-' + item.id + '">';
                            output += '<div class="card card-body" style="margin-top: 10px;" id="OrgName-' + item.org_id + '">';
                            output += '</div>';
                            output += '</div>';

                            output += '</div>';  
                        });

                        $('#resultProfit').html(output);
                    } else {
                        var output = '<div class="alert alert-warning" role="alert" style="width:1640px; text-align:center">';
                        output += '<strong>Warning:</strong> ' + res[0].message;
                        output += '</div>';
                        $('#resultProfit').html(output);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
      
      });
   
      // Handle form reset via the reset button click
      $('#resetButton').click(function(){
      // $('#resetButton').on('click', function() {
      // alert('test')
          $('#filterformProfit')[0].reset();
          $('#dropdownMenuButtonn').text('Select User');
          $('#filterUser').val('');
           // $('#filterUserAll').val('');
          // $('#resultProfit').html('');
           AllFilterData();
          // $('#resultProfit').html('<div class="alert alert-info" role="alert" style="width:1640px; text-align:center"><strong>Records not found.</strong></div>');
      });

      // Initialize select2 on dropdowns
      $('#filterUser,#filterUserAll, #filterCustomer,#filterCustomerAll, #salesId, #salesIdAll').select2();
  });

    // Function to fetch organization details

    function handleAccordionClick(element) {
      var orgId = $(element).data('org-id');
      var isLoaded = $(element).data('loaded');
      
      // Check if the data has already been loaded
      if (!isLoaded) {
        fetchOrgDetails(orgId);
        // Mark the data as loaded
        $(element).data('loaded', true);
      }
    }

    function fetchOrgDetails(orgId) {
        $.ajax({
            url: '<?= site_url('aifilters/get_org');?>',
            method: 'POST',
            data: { org_id: orgId },
            dataType: 'json',
            success: function(res) {
                if (res[0].status === "success") {
                    var orgName = res[0].orgName;
                    var output = '';
                    var base_url = '<?php echo base_url(); ?>';

                    // Check if the table already exists
                    if ($('#OrgName-' + orgId).find('table').length === 0) {
                        // Add table headers if not already present
                        output += '<table class="table table-bordered">';
                        output += '<thead>';
                        output += '<tr>';
                          output += '<th> Users </th>';
                        output += '<th>Customer Name</th>';
                        output += '<th> Subject </th>';
                        output += '<th>Sales order ID</th>';
                        output += '<th> Profit </th>';
                        output += '<th>Status</th>';
                        output += '<th>Current Date </th>';
                        output += '</tr>';
                        output += '</thead>';
                        output += '<tbody id="OrgNameBody-' + orgId + '"></tbody>';
                        output += '</table>';
                        $('#OrgName-' + orgId).html(output);
                    }

                    // Add rows to the table body
                    orgName.forEach(function(itemOrg) {
                        
                        var initial_value = parseFloat(itemOrg.initial_total);
                        var sub_totals = parseFloat(itemOrg.sub_totals);
                        // alert(sub_totals);
                        var profits = sub_totals - initial_value;
                        // var formatted_profits = profits.toFixed(2);
                        
                         var number = parseFloat(profits).toFixed(2); 
                            var parts = number.split("."); 
                            var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            var decimalPart = parts[1];

                            var formatted_profits = "₹" + integerPart + "." + decimalPart;
                
                        var row = '<tr>';
                        row += '<td>' + itemOrg.owner + '</td>';
                        row += '<td> <a href="' + base_url + 'salesorders/view_pi_so/' + itemOrg.id + '">' + itemOrg.org_name + ' </a></td>';
                        row += '<td> <a href="' + base_url + 'salesorders/view_pi_so/' + itemOrg.id + '">' + itemOrg.subject + '</a></td>';
                        row += '<td> <a href="' + base_url + 'salesorders/view_pi_so/' + itemOrg.id + '">' + itemOrg.saleorder_id + '</a></td>';
                        row += '<td>' + formatted_profits + '</td>';
                        row += '<td>' + itemOrg.status + '</td>';
                        row += '<td>' + itemOrg.currentdate + '</td>';
                        row += '</tr>';
                        $('#OrgNameBody-' + orgId).append(row);
                    });
                } else {
                    var output = '<div class="alert alert-warning" role="alert" style="width:1640px; text-align:center">';
                    output += '<strong>Warning:</strong> ' + res[0].message;
                    output += '</div>';
                    $('#OrgName-' + orgId).html(output);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        var selectButton = document.getElementById("dropdownMenuButtonn");
        var optionsContainer = document.getElementById("custom-options");
        var options = document.querySelectorAll("#custom-options li");

        // Toggle the dropdown menu on button click
        selectButton.addEventListener("click", function() {
            optionsContainer.classList.toggle("show");
        });

        // Handle option selection
        options.forEach(function(option) {
            option.addEventListener("click", function() {
                // Update the button text with the selected option
                selectButton.innerText = this.innerText;

                var userId = this.getAttribute('data-value');
                document.getElementById('filterUser').value = userId;

                optionsContainer.classList.remove("show");

            });
        });
    });

    $(document).ready(function() {
        loadUsers();
        loadCustomers();
        loadSaleId();
        
    });

      // Profits Model data

        function loadUsers() {
        $.ajax({
            url: '<?= site_url('aifilters/get_users'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    // Clear the dropdown before appending new options
                    $('#filterUser').empty().append('<option selected disabled> Select User </option>');
                     $('#filterUserAll').empty().append('<option selected disabled> Select User </option>');


                     // Append admins to the dropdown
                    if (Array.isArray(response.admin)) {
                        $.each(response.admin, function(index, admin) {
                            $('#filterUser').append('<option value="' + admin.admin_name + '">' + admin.admin_name + '</option>');
                            $('#filterUserAll').append('<option value="' + admin.admin_email + '">' + admin.admin_name + '</option>');

                        });
                    }

                    // Append customers to the dropdown
                    if (Array.isArray(response.customers)) {
                        $.each(response.customers, function(index, customer) {
                            $('#filterUser').append('<option value="' + customer.standard_name + '">' + customer.standard_name + '</option>');
                            $('#filterUserAll').append('<option value="' + customer.standard_email + '">' + customer.standard_name + '</option>');
                        });
                    }

                   

                } else {
                    console.error('Invalid response format:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
        }

        function loadCustomers() {
          // alert('test');
            $.ajax({
                url: '<?= site_url('aifilters/get_customers');?>',
                type: 'GET',
                dataType: 'json',
                // data: { user_id: userId },
                success: function(response) {
                    if (response && Array.isArray(response.customers)) {
                        // $('#filterCustomer').empty().append('<option selected></option>');
                          $('#filterCustomer').empty().append('<option selected disabled> Select Customer</option>');
                           $('#filterCustomerAll').empty().append('<option selected disabled> Select Customer</option>');
                        $.each(response.customers, function(index, customer) {
                            $('#filterCustomer').append('<option value="' + customer.id + '">' + customer.org_name + '</option>');
                             $('#filterCustomerAll').append('<option value="' + customer.id + '">' + customer.org_name + '</option>');
                        });
                    } else {
                        console.error('Invalid response format:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching customers:', error);
                }
            });
        }

        function loadSaleId() {
            $.ajax({
                url: '<?= site_url('aifilters/get_saleId');?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response);  // Log the raw response
                    if (response && Array.isArray(response.saleId)) {
                        // $('#salesId').empty().append('<option selected> </option>');
                          $('#salesId').empty().append('<option selected disabled> Select Sales ID</option>');
                           $('#salesIdAll').empty().append('<option selected disabled> Select Sales ID</option>');
                        $.each(response.saleId, function(index, salesid) {
                            $('#salesId').append('<option value="' + salesid.saleorder_id + '">' + salesid.saleorder_id + '</option>');
                             $('#salesIdAll').append('<option value="' + salesid.saleorder_id + '">' + salesid.saleorder_id + '</option>');
                        });
                    } else {
                        console.error('Invalid response format:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching customers:', error);
                    console.log(xhr.responseText);  // Log the full response text
                }
            });
        }

      function getfilterdData(selectedValue, functionName, filterId, dummyParam) {
            var id = "#" + filterId;
            $(id).val(selectedValue); 
         
            if (functionName === 'getsovalue') {
            }
            // alert('test2');
            // Reload the DataTable to fetch new data
            table.ajax.reload();
        }

</script>