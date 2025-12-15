<?php $this->load->view('common_navbar');?>

<script src="https://kit.fontawesome.com/db85a9eb98.js" crossorigin="anonymous"></script>
<style>
  /* .wrapper{max-width:800px;
  margin-top:80px;
margin-right:auto;
margin-left:auto;
border:1px solid black;} */
table{
  margin:10px;
}
td{
  font-size:14px;
  padding:7px;
}

   
   .statusso{
   height: 55px;
   cursor:pointer;
   }

   .accordion1{
    margin:20px;
   }
/* 
   .quoteaccordion{
  margin:15px auto;
  border-radius:50px;
}
.quoteacc_head{
  border-radius:10px;
  padding:7px;
  background:rgba(230,242,255,0.4);
  cursor:pointer;
} */
   .firstDiv:hover{
   transform: translateY(-9px);
   /*-webkit-transition: all 0.6s;
   -moz-transition: all 0.6s;*/
   border-bottom: 9px solid #eeda24;
   }
   .secondDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #125baa;
   }
   .thirdDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #828587;
   }
   .fourthDiv:hover{
   transform: translateY(-9px);
   border-bottom: 9px solid #82d324;
   }
   .activediv{
   transform: translateY(-9px);
   border-bottom: 9px solid #82d324;
   }

   .filterbox{
  display:flex;
  /* height:10vw;
  width:85vw; */
  margin:0px 15px;;
  border-radius:15px;
  /* margin-left:20px; */
  background:rgba(230,242,255,0.4);
}
.form-control{
  border:1px solid lightgrey;
  border-radius:2px;
  background-color:white;
}

.form-control:hover{
  border-color:purple;
  border-radius:0px;
  background-color:white;
}
.linkscontainer{
  width:65vw;
  padding:20px;
  padding-top:50px;
  border-radius:10px;
  box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
  margin:auto auto;
  margin-bottom:50px;
  
}

.linkstable tbody tr td:nth-child(2):hover ,.linkstable tbody tr td:nth-child(3):hover{
  cursor:pointer;
  background:rgba(240,240,255);
  border-radius:4px;
}
@media screen and (max-width: 576px) {
  .linkscontainer {
    width: 100vw;
  }
}

   
   /*-------------------*/
</style>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Reports</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                  <li class="breadcrumb-item active">Reports</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
         <div class="row mb-3">
            
         </div>
      </div>
      <!-- /.container-fluid -->
 </div>


   <!-- filter box -->
   <div class="linkscontainer">
      <div class="filterbox">
        
        <div class="card-body">
          <h4 style="margin-bottom:18px;">Select Filters to see Reports</h4>
                
        <div class ="row mb-3">
            <div class="col-lg-3"><h5>Start Date </h5>
            </div>
            <div class="col-lg-3"><h5>End Date </h5>
            </div>
              
        </div>
         

          <div id="dateFilterForm">
            <div class="row mb-3">
              <div class="col-lg-3">
                <div class="first-one">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    </div>
                    <input type="date" name="startDate" id="startDate" class="form-control" placeholder="Start Date" aria-label="Start Date" aria-describedby="basic-addon1">
                  </div>
                </div>
              </div>
              <div class="col-lg-3">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                  </div>
                  <input type="date" name="endDate" id="endDate" class="form-control" placeholder="End Date" aria-label="End Date" aria-describedby="basic-addon1">
                </div>
              </div>
            </div>
          </div>



      </div>
    </div>


<div class="wrapper">
<div id="accordion" class="accordion1 mx-3">

  <div class="card">
      <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <h5 class="mb-0">
          <button class="btn btn-link" >
            Invoices Summary
          </button>
        </h5>
      </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body" style="background-color: rgba(220,220,220,0.1); border-radius:5px; display:flex;alingn-item:center;">
                <div class="container-fluid">
      <div class="row">
          <div class="col-md-3">
              <i class="fa-solid fa-file-invoice fa-beat" style="color: #74C0FC; font-size:24px;"></i>
              &nbsp;&nbsp;
              <abbr title="Invoices with invoice date during this period excludes Draft Invoices" style="text-decoration: none;"><strong>Invoices :</strong></abbr><br>
              <span id="count_ino" style="display: inline-block; width: 100px; text-align: right;"></span>
          </div>

          <div class="col-md-3">
              <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #74C0FC; font-size:24px; "></i>
              &nbsp;&nbsp;
              <abbr title="Amount Total of all the invoices with invoice date during this period Includes Taxes" style="text-decoration: none;"><strong>Invoices Amount :</strong></abbr><br>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
              <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_subtotal_ino"></span></span> <span style="vertical-align: middle;"></span>
          </div>

          <div class="col-md-3">
              <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #4eb00c; font-size:24px;"></i>
              &nbsp;&nbsp;
              <abbr title="Pending amount to be collected against invoices with invoice date during this period." style="text-decoration: none;"><strong>Amount Due :</strong></abbr> <br>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
              <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_pending_payment_ino"></span></span> <span style="vertical-align: middle;"></span>
          </div>

          <div class="col-md-3">
              <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #4eb00c; font-size:24px;"></i>
              &nbsp;&nbsp;
              <abbr title="Pending amount to be collected against invoices with invoice date during this period." style="text-decoration: none;"><strong>GST:</strong></abbr> <br>
              <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_gst_ino"></span></span> <span style="vertical-align: middle;"></span>
          </div>
          
      </div>
  </div>

              </div>
      </div>
  </div>

  <div class="card">
    <div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed">
         Expenditures Summary
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
    <div class="card-body" style="background-color: rgba(220,220,220,0.1); border-radius:5px; display:flex;alingn-item:center;">
    <div class="container-fluid">
                  <div class="row">
                       <div class="col-md-3">
                       <i class="fa-solid fa-file-invoice fa-beat" style="color: #74C0FC; font-size:24px; "></i>&nbsp;&nbsp;&nbsp;&nbsp;<abbr title="Number of expenses noted." style="text-decoration: none;"><strong>Expenditures :</strong></abbr> <br>
                       <span id = "count_expenditure" style="display: inline-block; width: 100px; text-align: right;"> </span>
                      </div>

                      <div class="col-md-5">
                          <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #74C0FC; font-size:24px; "></i>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <abbr title="Amount Total of all the invoices with invoice date during this period Includes Taxes" style="text-decoration: none;"><strong>Expense Amount :</strong></abbr> <br>&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                          <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_subtotal_exp"></span></span> <span style="vertical-align: middle;"></span>
                      </div>

                      <div class="col-md-4">
                          <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #74C0FC; font-size:24px; "></i>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <abbr title="Amount Total of all the invoices with invoice date during this period Includes Taxes" style="text-decoration: none;"><strong> Amount Due : </strong></abbr> <br> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                          <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_pending_payment_exp"></span></span> <span style="vertical-align: middle;"></span>
                      </div>

                      </div>
                  </div>
                </div>
                 
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingThree" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed">
          Purchase Order Summary
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordion">
    <div class="card-body" style="background-color: rgba(220,220,220,0.1); border-radius:5px; display:flex;alingn-item:center;">
    <div class="container-fluid">
                  <div class="row">
                        <div class="col-md-3">
                        <i class="fa-regular fa-circle-dot fa-beat" style="color: #74C0FC; font-size:24px;" ></i>&nbsp;&nbsp;&nbsp;&nbsp;<abbr title="Purchase Orders with purchase order date during this period. Excludes Draft Purchase Orders" style="text-decoration: none;"><strong>Purchase Orders :</strong> </abbr> <br><span id = "count_par"  style="display: inline-block; width: 100px; text-align: right;"> </span>
                        </div>


                        <div class="col-md-5">
                          <i class="fa-solid fa-file-invoice-dollar fa-beat " style="color: #74C0FC; font-size:24px; "></i>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <abbr title="Amount Total of all the invoices with invoice date during this period Includes Taxes" style="text-decoration: none;"><strong> Purchase Amount :</strong></abbr> <br> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                          <span style="display: inline-block; width: 100px; text-align: right;">₹.<span id="total_subtotal_par"></span></span> <span style="vertical-align: middle;"></span>
                      </div>
                      
                      </div>
                  </div>
                </div>
</div>
                  </div>
    </div>
  </div>
  <!-- table for accounts receivables start -->

  <div class="reportlinks">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
  <table class="linkstable">
  <thead>
    <tr>
      <th style="background-color:white; color:rgb(128,128,128);"><h5><b>Accounting Reports</h5></b></th>
      
    </tr>
  </thead>
  <tbody>
    <tr  style="margin:40px;">
      <td>performa invoice</td>
      <td> <a href="<?= base_url ('proforma_invoice')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    
      <td> <a href=""><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV</a></td>
    </tr>

    <tr>
      <td>Invoices</td>
      <td> <a href="<?=base_url('invoices')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
      <td> <a href="<?= base_url ('Export_data/export_invoice')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>Client Report</td>
      <td> <a href="<?= base_url ('organizations')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
   
    </tr>

    <tr>
      <td>Payment Report</td>
      <td> <a href="<?= base_url('payment-reciept')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>

      <td><a href="<?= base_url ('Export_data/export_paymentreciept')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV</a> </td>
    </tr>

    <tr>
      <td>TDS Report</td>
      <td><a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    
      <td> <a href=""><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>GSTR-1 Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>

    <tr>
      <td>GST Report</td>
      <td> <a href="<?= base_url ('gst')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      <td> <a href="javascript:void(0);"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>Credit Note GST Report</td>
      <td> <a href="<?= base_url ('Export_data/export_creditnote')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>Line Item Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>

    <tr>
      <td>HSN Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>
    
   
  </tbody>
</table>
</div>
<!--table for account receivables end -->

<!-- table for account payable starts -->
<div class="col-md-4">
<table class="linkstable">
  <thead>
    <tr>
      <th style="background-color:white; color:rgb(128,128,128);"><h5><b>Accounts Payable</h5></b></th>
      
    </tr>
  </thead>
  <tbody >
    <tr>
      <td>Purchase Order</td> 
      <td> <a href="<?=base_url('purchaseorders')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
    </tr>

    <tr>
      <td>Expenditures</td>
      <td>  <a href="<?= base_url ('expanse-manage')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    
      <td>  <a href="<?= base_url ('Export_data/export_expenditure')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV</a></td>
    </tr>

    <tr>
      <td>Vendor Report</td>
      <td> <a href="<?= base_url('vendors')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
      <td> <a href=" <?= base_url('Export_data/export_vendor_csv')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>Payment Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
     
      <td> <a href="javascript:void(0);"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>TDS Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    
      <td> <a href="javascript:void(0);"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>GST Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
      <td> <a href="javascript:void(0);"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr>
      <td>Line Item Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>

    <tr>
      <td>HSN </td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>
  
  </tbody>
</table>
</div>
<!-- table for account payable ends -->

<!-- table for othaer reports starts -->
<div class="col-md-4">
<table class="linkstable">
  <thead>
    <tr>
      <th style="background-color:white; color:rgb(128,128,128);"><h5><b>Other Reports</h5></b></th>
      
    </tr>
  </thead>
  <tbody>
    <tr align="top" style="position: relative;">
      <td >Delivery Challans</td>
      <td> <a href="<?=base_url('delivery-Chalan')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
      <td> <a href="<?= base_url('Export_data/export_deliverychallan')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td>
    </tr>

    <tr align="top" style="position: relative;">
      <td > Product Report</td>
      <td> <a href="<?=base_url('product-manager')?>"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
      <!-- <td> <a href="<?= base_url('Export_data/export_deliverychallan')?>"><i class="fa-solid fa-download" style="color: #d5d8dd;"></i>&nbsp; CSV </a></td> -->
    </tr>



  </tbody>
</table>
</div>
</div>


<!-- table for other reports end -->

<!-- new table start -->
<!-- table for advanced accounting reports starts -->
<div class="reportlinks">
  <table class="linkstable">
  <thead>
    <tr>
      <th style="background-color:white; color:rgb(128,128,128);"><h5><b>Accounting Reports</h5></b></th>
      
    </tr>
  </thead>
  <tbody>
    <tr  style="margin:40px;">
      <td>Trial Balance</td>
      <td><a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
    </tr>

    <tr>
      <td>Balance Sheet</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
    </tr>

    <tr>
      <td>Income Statement</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
    </tr>

    <tr>
      <td>Profit And Loss</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
      
    </tr>

    <tr>
      <td>DayBook Report</td>
      <td> <a href="javascript:void(0);"><i class="fa-regular fa-file" style="color: #c8c6c1;"></i>&nbsp; Open </a></td>
     
    </tr>

    
   
  </tbody>
</table>
<!-- table for advanced accounting reports end -->
<!-- new table end -->





</div>
</div>
</div>
</div>


   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- Main row -->
         <!-- Map card -->
         <div class="card org_div">
            <!-- /.card-header -->
           
            <!-- <div class="card-body">
            <button type="button" class="btn btn-outline-secondary" style="margin-bottom:-56px;color:purple; border-color:purple; margin-left:58vw; height:30px;line-height:10px;">
                <i class="fa fa-table" aria-hidden="true"style="color:purple;"></i>&nbsp;
                Show/Hide Columns
</button> -->

<!-- Modal -->


             
            </div>
            <!-- /.card-body -->
         </div>
         <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php if(check_permission_status('Salesorders','retrieve_u')==true):?>
<?php //SalesOrder Renewal Modal Starts ?>
<div class="modal fade" id="sales_alert" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title sales_alert">Renewal&nbsp;Alert </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body form">
            <!-- <button class="btn btn-secondary float-right" onclick="reload_notify_table()"><i class="fas fa-sync-alt"></i></button>
            <table class="table">
               <thead>
                  <tr>
                     <th>SO&nbsp;Id</th>
                     <th>Subject</th>
                     <th>Organization&nbsp;Name</th>
                     <th>Renewal&nbsp;Date</th>
                     <th>Owner</th>
                     <th>Action</th>
                     <th>Action</th>
                  </tr>
               </thead> -->
               <!-- <tbody id="notify_table">
                  <?php $cnt=0;if(!empty($renewal_data)) { foreach($renewal_data as $renew) { $cnt=1;?>
                  <tr>
                     <td><?= $renew['saleorder_id']; ?></td>
                     <td><?= $renew['subject']; ?></td>
                     <td><?= $renew['org_name']; ?></td>
                     <td><?= $renew['renewal_date']; ?></td>
                     <td><?= $renew['owner']; ?></td>
                     <td>
                        <button class="btn btn-primary btn-sm" onclick="view_so(<?= $renew['id'];?>);">View</button>
                     </td>
                     <td><button class="btn btn-danger btn-sm" onclick="end_renewal(<?= $renew['id'];?>);">End</button></td>
                  </tr>
                  <?php } } ?>
               </tbody>
            </table> -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();">Close</button>
         </div>
      </div>
   </div>
</div>
<?php //Purchaseorder Renewal Modal Ends ?>
<?php endif;?>
<!-- Purchaseorder create Modal Start -->
<?php if(!empty($po_popup)):?>
<!-- SalesOrder Renewal Modal Starts  -->
<div class="modal fade" id="salescreate_alert" role="dialog" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg">
      <div class="modal-content" >
         <div class="modal-header">
            <h4 class="modal-title sales_alert">
               Purchase Order Pending&nbsp;Alert 
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <!-- <div class="modal-body form">
            <table class="">
               <thead>
                  <tr>
                     <th>SO&nbsp;Id</th>
                     <th>Subject</th>
                     <th>Organization&nbsp;Name</th>
                     <th>Salesorder&nbsp;Date</th>
                     <th style="min-width:80px;">Due&nbsp;Date</th>
                     <th style="min-width:100px;">Owner</th>
                     <th style="min-width:80px;">Amount</th>
                     <th style="min-width:80px;">Profit</th>
                     <th colspan="2" class="text-center">Action</th>
                     <th>Action</th>
                  </tr>
               </thead> -->
               <tbody id="notify_PO">
                  <?php 
                     $cpo=0; 
                     if(!empty($po_popup)) 
                     { 
                       $amount = 0;
                       $profit = 0;
                     foreach($po_popup as $sales) { 
                       $cpo=1;
                       $sid = $sales['saleorder_id'];
                       $ex = explode('/', $sid);
                       $so_id = end($ex); 
                     
                       $cu = $sales['currentdate'];
                       $currentdate = date("d-m-y", strtotime($cu));
                     
                       $du = $sales['due_date'];
                       $duedate = date("d-m-y", strtotime($du));
                     ?>
                  <tr>
                     <td><?= $so_id; ?></td>
                     <td><?= $sales['subject']; ?></td>
                     <td><?= $sales['org_name']; ?></td>
                     <td><?= $currentdate; ?></td>
                     <td><?= $duedate; ?></td>
                     <td><?= $sales['owner']; ?></td>
                     <td><?= (int)$sales['initial_total']; ?>&#8377;</td>
                     <td><?= (int)$sales['profit_by_user']; ?>&#8377;</td>
                     <td>
                        <a style="text-decoration:none" href="<?= base_url(); ?>salesorders/view_pi_so/<?= $sales['id'];?>" class="text-success border-right"><i class="far fa-eye sub-icn-opp m-1" data-toggle="tooltip" data-container="body" title="View Sales Details" ></i></a>
                     </td>
                     <td>
                        <a style="text-decoration:none" href="<?= base_url();?>add-purchase-order?so=<?= $sales['id'];?>" class="text-info border-right">
                        <i class="fas fa-shopping-basket sub-icn-po m-1" data-toggle="tooltip" data-container="body" title="Create Purchase Order" ></i></a>
                     </td>
                  </tr>
                  <?php $amount += $sales['initial_total'];
                     $profit += $sales['profit_by_user'] ;   } } ?>
                  <tr>
                     <td colspan="6" style="text-align:right; padding-right:15px; color:green">Total : </td>
                     <td><?= $amount; ?>&#8377;</td>
                     <td><?= $profit; ?>&#8377;</td>
                     <td></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="close_notify_sess();">Close</button>
         </div>
      </div>
   </div>
</div>
<?php endif;?>
<!-- Purchaseorder Renewal Modal End -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php if(isset($_GET['soid'])){
   $soid=$_GET['soid'];
   $ntid=$_GET['ntid'];
   }else{
   $soid='';
   $ntid='';
   }	?>





<!---------------------------------------Start filter date ------------------------------------>

<script>
$(document).ready(function(){

  // Function to fetch data
  function fetchData(startDate, endDate) {
    $.ajax({
      type: 'POST',
      url: '<?php echo site_url('Accounting/fetch_Date_filter'); ?>',
      data: { startDate: startDate, endDate: endDate },
      dataType: 'json', 
      success: function(response){
        console.log(response);

        if (response) {
          $('#count_ino').text(response.count_ino);
          $('#total_subtotal_ino').text(response.total_subtotal_ino);
          $('#total_pending_payment_ino').text(response.total_pending_payment_ino); 
          $('#total_gst_ino').text(response.total_gst_ino); 

          $('#count_par').text(response.count_par);
          $('#total_subtotal_par').text(response.total_subtotal_par);

          $('#count_expenditure').text(response.count_expenditure);
          $('#total_subtotal_exp').text(response.total_subtotal_exp);
          $('#total_pending_payment_exp').text(response.total_pending_payment_exp);
        } else {
          // If no data is available, display an error message
          $('#error_message').text('No data available.');
        }
      },

      error: function(xhr, status, error) {
        // If there is an error with the AJAX request, display an error message
        $('#error_message').text('Error fetching data: ' + error);
      }
    });
  }

  // Function to fetch data by default
  function fetchDefaultData() {
    // Call fetchData with default start and end dates
    fetchData('', '');
  }

  // Call fetchDefaultData to load data by default
  fetchDefaultData();

  // Function to fetch data when start or end date changes
  function fetchDataOnInputChange() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    if(startDate && endDate) {
      fetchData(startDate, endDate);
    }
  }

  // Call fetchDataOnInputChange when either start or end date changes
  $('#startDate, #endDate').change(fetchDataOnInputChange);
});
</script>


<!-------------------------------- End filter date -------------------------------------->


<script>
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

////////////////////////////////////////////// it triggers automatically when page load (starts)///////////////////////////////////////////////////////////
    $(".inputbox").each(function(){

      var index = $(".inputbox").index(this);
      if(this.checked){
        
       colarr.push({'visible':true})
      }
      else{
        colarr.push({'visible':false})
      }
     
      $(this).change(function(){

           changed.push(index);
           var value  = parseInt(index);
      
           if(this.checked){
               showcol.push(value);
            }
            else{
                  showcol = showcol.filter(function(item){
                 return item != value;
                  });
            }
        })
    });
  ////////////////////////////////////////////// it triggers automatically when page load (starts)///////////////////////////////////////////////////////////

     <?php if(check_permission_status('Salesorders','retrieve_u')==true):?>
       table = $('#ajax_datatable').DataTable({
         "processing": true, 
         "serverSide": true, 
   "pageLength": 15,
         "order": [], 
         "ajax": {
           "url": "<?= base_url('salesorders/ajax_list'); ?>",
           "type": "POST",
           "data" : function(data)
            {
               data.searchDate = $('#date_filter').val();
               data.searchUser = $('#user_filter').val();
               data.searchStatus = $('#status_filter').val();
            }
         },
         "columnDefs": [
         {
             "targets": [ 0 ], //last column
             "orderable": false, //set not orderable
         },
         ],
         "columns":colarr
       });
    
       function disableClick(e) {
        e.stopPropagation();
        e.preventDefault();
    }

    // Attach the click event handler to the element with ID 'ajax_datatable_filter'
    $('#ajax_datatable_filter').on('click', disableClick);
       $("#savecolvis").click(function () {
         var columnVisibility = [];
        saveChangesClicked = true;
    // Set visibility to false for columns in showcol array
    for (var i = 0; i < showcol.length; i++) {
        var columnIndex = showcol[i];
        if (columnIndex < table.columns().header().length) {
            columnVisibility.push(columnIndex);
        }
    }
    console.log(columnVisibility);
    // Set column visibility
    table.columns().visible(false);
    table.columns(columnVisibility).visible(true);

    // Redraw the table
    table.draw();
});
   
       $('#date_filter, #user_filter').change(function(){
         table.ajax.reload();
   getsovalue();
       });
    
    $('ajax_datatable_filter input').keyup(function(){
   getsovalue();
       });
   
    $('.statusso').click(function(){
     $('.statusso').css('border-bottom','');
     $('.statusso').css('transform','');
     var clr=$(this).data('color');
     //$(this).addClass('activediv');
     $(this).css('transform','translateY(-9px)');
     $(this).css('border-bottom','9px solid #'+clr);
     
     var value=$(this).data('status');
     
     $('#status_filter').val(value);
           table.ajax.reload();
     
       });
       function reload_table()
       {
           table.ajax.reload(null,false);
       }
    
    
   function getsovalue(){
   var searchDate 	= $('#date_filter').val();
   var searchUser 	= $('#user_filter').val();
   var search 		= $('#ajax_datatable_filter input').val();
     $.ajax({
   	url		: "<?= site_url('salesorders/getstatusvalue');?>",
   	method	: "post",
   	data	: "searchDate="+searchDate+"&searchUser="+searchUser+'&search_data='+search,
   	dataType: "JSON",
   	success : function(result){
   		if(result.pening){
   		$("#dendingData").html(numberToIndPrice(result.pening));
   	    }
   	    if(result.inProgress){
   		$("#inProgressData").html(numberToIndPrice(result.inProgress));
   	    }
   	    if(result.invoicePend){
   		$("#invoicePendData").html(numberToIndPrice(result.invoicePend));
   	    }
   	    if(result.complete){
   		$("#completeData").html(numberToIndPrice(result.complete));
   	    }
   	}
     });
     }
   getsovalue(); 
     <?php endif; ?>
     
     
     function changeNotiStatus(){
   var noti_id="<?=$ntid;?>";
   url = "<?= site_url('notification/update_notification');?>";
     	$.ajax({
     		url : url,
     		type: "POST",
     		data: "noti_id="+noti_id+"&notifor=salesorders",
     		success: function(data)
     		{ }
     	});
     }
   
   
   
   function approve_entry(soid,soidapp,stts,textid) {
   if(stts==1){  
   toastr.info('Please wait while we are processing your request..');
   }
     var urlst = "salesorders/changeStatus";
   $("#"+textid).html('');
     $.ajax({
         url : urlst,
         type: "POST",
         data: "soid="+soid+'&sovalue='+stts,
         success: function(data)
         { 
             if(data==1){
   		toastr.success('Sales order ID #'+soidapp+" has been approved successfully.");
             }else if(data==0){
                 toastr.error('Sales order ID #'+soidapp+" disapproved successfully.");
             }else{
                 toastr.success('Sales Order ID #'+soidapp+" has been Approved Successfully.");
             }
   	 table.ajax.reload();
         }
     });
   };  
     
     
   <?php if(check_permission_status('Salesorders','create_u')==true): ?>
    
     function ValidateSize(file)
     {
       var FileSize = file.files[0].size / 1024 / 1024; // in MB
       if (FileSize > 2)
       {
         alert('File is larger than 2MB');
         $(file).val(''); //for clearing with Jquery
       }
       else
       {
   
       }
     }
   <?php endif; ?>
   
</script>
<script>
   $(document).ready(function(){
   	$('#delete_all2').click(function(){
   	  var checkbox = $('.delete_checkbox:checked');
   	  if(checkbox.length > 0)
   	  {
   	   $("#delete_confirmation").modal('show');
   	  }
   	  else
   	  {
   	   alert('Select atleast one records');
   	  }
   	});
   });
   
   $("#confirmed").click(function(){
     deleteBulkItem('salesorders/delete_bulk'); 
   });
</script>
<script>
   <?php if(check_permission_status('Salesorders','delete_u')==true):?>
     function delete_entry(id,soid)
     {
   
       if(confirm('Are you sure delete this data?'))
       {
         // ajax delete data to database
         $.ajax({
           url : "<?= base_url('salesorders/delete'); ?>/"+id+"/"+soid,
           type: "POST",
           dataType: "JSON",
           success: function(data)
           {
             if(data.status){
             //if success reload ajax table
             $('#sales_popup').modal('hide');
             //reload_table();
             refreshPage();
             }
           },
           error: function (jqXHR, textStatus, errorThrown)
           {
             alert('Error deleting data');
           }
         });
       }
     }
   <?php endif; ?>
</script>
<script>
   // $(document).ready(function()
   // {
   //     var countRn='<?php echo $cnt;?>';
   //     if(countRn>0){
   //         $("#sales_alert").modal('show');
   //     }
   // });
   
   $(document).ready(function()
   {
       var countSO='<?php echo $cpo;?>';
       if(countSO>0){
           $("#salescreate_alert").modal('show');
       }
   });
   
   function end_renewal(id)
   {
     $.ajax({
       url:'<?=site_url("salesorders/end_renewal")?>',
       method: 'post',
       data: {id:id},
       dataType: 'json',
       success: function(response)
       {
         $.ajax({
           url:'<?=site_url("salesorders/update_renewal_data")?>',
           method: 'post',
           data: {id:id},
           dataType: 'json',
           success: function(response)
           {
             $("#notify_table").empty();
             var table;
             $.each(response,function(index,data)
             {
               table = "<tr><td>"+data['saleorder_id']+"</td>"+"<td>"+data['subject']+"</td>"+"<td>"+data['org_name']+"</td>"+"<td>"+data['renewal_date']+"</td>"+""+"<td>"+data['owner']+"</td>"+"<td><button class='btn btn-primary btn-sm' onclick='view_so("+data['id']+")'>View</button></td>"+"<td><button class='btn btn-danger btn-sm' onclick='end_renewal("+data['id']+")'>End</button></td>"+"</tr>";
               $("#notify_table").append(table);  
             });
           }
         });
       }
     });
   }
   
   function view_so(sales_id){
    window.location.href = "<?=base_url('salesorders/view_pi_so/'); ?>"+sales_id;	
   }
   function refreshPage(){
       window.location.reload();
   } 
   
</script>
<script>
 $.ajax({
  url:'<?php echo site_url('salesorders/so_graph')?>',
              method:'post',
              success:function(response){
              if (response.status === 'success') {
              
var so_amount = [];
var xAxisCategories=[];
for (var i = 0; i < response.data.length; i++) {
  so_amount.push(parseFloat(response.data[i].subtotal)); 
    xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
}


var options = {
    series: [
        { name: 'Total SO Amount of month', data: so_amount },
    ],
    chart: {
        height: 250,
        type: 'area'
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth',
        width: 1
    },
    xaxis: {
        categories: xAxisCategories,
        tickAmount: Math.ceil(xAxisCategories.length / 3),
        tickPlacement: 'on'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                // Format the y-axis labels using Indian numbering system
                return '₹ '+new Intl.NumberFormat('en-IN').format(value);
            }
        }
    }
};
        var chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();

              }
             }
    });
      

</script>
