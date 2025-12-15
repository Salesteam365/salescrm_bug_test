<?php $this->load->view('common_navbar');?>
<style>
  .quoteaccordion{
  margin:15px auto;
  border-radius:5px;
  background:rgba(197,180,227,0.1);
   border-top:none;
   border-left:5px solid purple;
}
.quoteacc_head{
  border-radius:10px;
  padding:7px;
  background:rgba(197,180,227,0.2);
  cursor:pointer;
}
#btnshowhide{
    color:grey; 
    border-color:lightgrey;
    cursor:pointer;
    float:right;
    height:30px;
   margin-right:12px;
    line-height:10px;
}
#btnshowhide:hover{
  background:rgba(230,242,255,0.4);
}
#ajax_datatable thead tr th{
   background:rgba(35, 0, 140, 0.8);
  

}
#ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   
  

}


#ajax_datatable tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 14px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}

/* #ajax_datatable tbody tr td:nth-child(6) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
} */
/* .filterbox{
  display:flex;
  height:10vw;
  width:85vw;
  border-radius:15px;
  margin-left:20px;
  background:rgba(230,242,255,0.4);
}
 */
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

</style>

 <!-- modal Mass Product start-->
  <div class="modal fade" id="mass_product_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Mass Update </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="massForm" method="post" action="">
              <div class="col-lg-12">
                <div class="form-row d-flex align-items-end">

                    <!-- ID Field -->
                    <input type="hidden" id="mass_id" name="mass_id" placeholder="Enter ID" class="form-control">

                    <!-- Field Selection -->
                    <div class="col pr-1">
                      <div class="form-group">
                          <label>Select Field</label>
                          <select class="form-control type-select" name="mass_name" id="mass_name" required>
                            <option value="" selected disabled>Select a Field</option>
                            <option value="customer_company_name">Customer Name</option>
                            <option value="subject"> Subject </option>
                            <option value="owner"> Owner Created By </option>
                          
                            <option value="renewal_date"> Renewal Date With Calendar </option>

                            <option value="billing_gstin"> Billing GST </option> 
                            <option value="billing_country">Billing Country</option> 
                            <option value="billing_state">Billing State</option> 
                            <option value="billing_city">Billing City</option>
                            <option value="billing_zipcode">Billing Zipcode</option>
                            <option value="billing_address">Billing Address</option>

                            <option value="shipping_gstin">Shipping GST</option>
                            <option value="shipping_country">Shipping Country</option>
                            <option value="shipping_state">Shipping State</option>
                            <option value="shipping_city">Shipping City</option>
                            <option value="shipping_zipcode">Shipping Zipcode</option> 
                            <option value="shipping_address">Shipping Address</option>

                            <option value="supplier_name"> Vendor Name </option>
                            <option value="supplier_comp_name"> Company Name </option>
                            <option value="supplier_contact">Supplier Contact </option>
                            <option value="supplier_email"> Supplier Email</option>
                            <option value="supplier_gstin"> Supplier GST </option>
                            <option value="supplier_country"> Supplier Country </option>
                            <option value="supplier_state"> Supplier State </option>
                            <option value="supplier_city"> Supplier City </option>
                            <option value="supplier_zipcode"> Supplier Zipcode </option> 
                            <option value="supplier_address"> Supplier Address </option> 

                            <option value="customer_company_name"> Customer Company Name </option> 
                            <option value="customer_name"> Customer Name </option> 
                            <option value="customer_email"> Customer Email </option> 
                            <option value="customer_mobile"> Customer Mobile </option> 
                            <option value="microsoft_lan_no"> Licence No. </option> 
                            <option value="customer_address"> Customer Address </option> 
                            

                          </select>
                      </div>
                  
                    </div>
                      
                    <div class="col pr-1 dummytext" >
                      <div class ="form-group">
                          <input type="text" id ="dummytext" placeholder="Enter Value" class="form-control" readonly>
                      </div>
                    </div> 

                    <!-- Input or Dropdown Field -->
                    <div class="col pl-1 length-wrapper" style="display: none;">
                      <div class="form-group">
                          <!-- Text Input -->
                          <input type="text" class="form-control length-input" id="value_input" placeholder="Enter Value">
                          <input type="date" class="form-control renewal_date-select" id="renewal_date_select" placeholder="select date" style="display: none;"> 
                          
                          <!-- payment_terms  --> 
                          <select class="form-control payment_terms-select" id="payment_terms_select" style="display: none;">
                            <option value=""> Payment Terms</option>

                            <?php for($i=1; $i<=30; $i++){ ?>
                              <option value="<?=$i;?>" <?php if($dataPy==$i){ echo "selected"; } ?> ><?=$i;?></option>
                            <?php } ?>
                              <option value="After Delivery"> After Delivery </option>
                              <option value="Against Advance">Against Advance</option>
                              <option value="Other">Other</option>
                          </select>

                      </div>
                    </div>
                </div>
              </div>

            
              <!-- Hidden field that carries final value -->
              <input type="hidden" name="mass_value" id="final_value_input">

              <!-- Submit Button -->
              <!-- <button type="submit" id="massUpdateBtn" class="btn btn-primary mt-2">Mass Update</button> -->
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="massUpdateBtn">Update </button>
          </div>
        </div>
      </div>
  </div>

  <!-- modal Mass Product end-->





<div class="modal fade" id="mailmodal" tabindex="-1" role="dialog" aria-labelledby="mailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mailModalLabel">Share Purchase Order via Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="pomailform">
      <div class="form-group">
         
          <input type="hidden" class="form-control" name="po_id" id="po_id" placeholder="Enter recipient email">
        </div>
       <div class="form-group">
          <label for="recipientEmail">PO number</label>
          <input type="text" class="form-control" name="po_number" id="po_number"  placeholder="">
        </div>
       <div class="form-group">
          <label for="recipientEmail">To</label>
          <input type="email" class="form-control" name="to" id="to" placeholder="Enter recipient email">
        </div>
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" class="form-control" name="subject" id="subject" placeholder="Enter email subject">
        </div>
        <div class="form-group">
          <label for="message">CC</label>
          <textarea class="form-control" id="ccmail" name="cc" rows="5" placeholder="Enter your message"></textarea>
        </div>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="sendmailbtn" onclick="sendpobymail();">Send</button>
      </div>
    </div>
  </div>
</div>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Purchase Order</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home')?>">Home</a></li>
              <li class="breadcrumb-item active">Purchase Order</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <div class="container-fliud filterbtncon"  >
        <?php 
                                  //  $fifteen = strtotime("-15 Day"); 
                                  //  $thirty = strtotime("-30 Day"); 
                                  //  $fortyfive = strtotime("-45 Day"); 
                                  //  $sixty = strtotime("-60 Day"); 
                                  //  $ninty = strtotime("-90 Day"); 
                                  //  $six_month = strtotime("-180 Day"); 
                                  //  $one_year = strtotime("-365 Day");
                            ?>
         <div class="row mb-3">
         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>

            <div class="col-lg-2">
               <?php if($this->session->userdata('type')==='admin'){ ?>
                <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
               <input type="hidden" id="user_filter" value="" name="user_filter">
               <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                     <option selected  value="">Select User</option>
                     <?php foreach($admin as $adminDtl) { ?>
              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$adminDtl['admin_email'];?>','user_filter');"><?=$adminDtl['admin_name'];?></li>
            <?php } ?>
            <?php  foreach($user as $userDtl) { ?>
              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?=$userDtl['standard_email'];?>','user_filter');"><?=$userDtl['standard_name'];?></li>
            
            <?php } ?>
            </ul>
            </div>
        <?php } ?>
      </div>
           
      <div class="col-lg-2"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
          <?php if($this->session->userdata('type')=='admin'){ ?>
                <a href='Export_data/export_po' class="p-0" ><button class="btncorner">Export Data</button></a>
          <?php } ?>
                  <!-- <button class="btn btn-info" data-toggle="modal" data-target="#notify_popup"><i class="fas fa-bell"></i></button>
                  <button class="btn btn-info" ><a href="<?= base_url('add-purchase-order')?>" style="color: #fff; padding: 0px;">Add New</a></button> -->
         
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>

    <div class="card mx-md-5 mt-2 mb-0 px-5 py-4" style="border-radius:12px;">
    <div class="accordion mx-3" id="faq" >
            <div class="quoteaccordion">
               <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Purchase order Summary</a>
               </div>
               <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                  <div class="card-body">
                     Total Purchase orders : <?= $countPO; ?>
                  </div>
               </div>
            </div>
            <div class="quoteaccordion">
               <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" > <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Purchase Orders Graph</a>
               </div>
               <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq2">
                  <div class="card-body">
                    <div id="chart-line"></div>
                  </div>
               </div>
            </div>
          </div>
          </div>
    <!-- /.content-header -->
    <?php if(check_permission_status('Purchase Order','retrieve_u')==true): ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
        <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                   <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
                </div>
              </div>
          </div>
            <div class=" org_div" id="listview">
                <div class="card-body">
                

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Column visibility</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <table class="table table-striped">
                            <thead style="background:rgba(60,60,170)">
                              <tr>
                                <th>Columns</th>
                                <th>Visibility</th>
                              </tr>
                            </thead>
                            <tbody>
                                 <?php if($this->session->userdata('type')=='admin'){?>
                                 <tr>
                                  <td>Delete</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                <td>Company Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Customer Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Vendor Name</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Subject</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Po Number</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                  <td>Created By</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Status</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Added date</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Action</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                            </tbody>
                          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="savecolvis">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Purchase Order</b>
                  <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns
                  </button>
                      &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;  &nbsp;&nbsp;

                 
                        <a id="mass_model" href="#" style="text-decoration:none;">
                            <button type="button" id="mass_product" class="btn" style="display:none; border-radius: 2rem; margin-bottom: 1rem; background: #845ADF; color:#fff; font-weight: 500;">
                              Mass Update
                            </button>
                        </a>
                     
                 

            </div>

            <div class="card-body">
                  <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%" style="font-size: 15px;">
                      <thead>
                          <tr>
                            <?php if(check_permission_status('Purchase Order','delete_u')==true):?>
                              <th style="width:3%;" ><button class="btn" type="button" name="delete_all" id="delete_all2" ><i class="fa fa-trash text-light"></i></button></th>
                            <?php endif; ?>
                            <th class="th-sm" style="width:15%;" >Customer Name</th>
                            <th class="th-sm"style="width:13%;"  >Company Name</th>
                            
                            <th class="th-sm">Vendor Name</th>
                            <th class="th-sm">Subject</th>
                            <th class="th-sm">PO Number</th>
                            <th class="th-sm" style="width:9%;" >Created By</th>
              <th class="th-sm">Status</th>
              <th class="th-sm" style="width:9%;">Added Date</th>
              <th class="th-sm" style="width:10%;">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                              
                      </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
                            </div>
                            </div>
                            </div>
      <!-- /.content -->
    <?php endif; ?>
  
  <!-- /.content-wrapper -->

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php if(isset($_GET['poid'])){
  $poid=$_GET['poid'];
  $ntid=$_GET['ntid'];
}else{
  $poid='';
  $ntid='';
} ?>
<script>
  
<?php if($this->session->userdata('terms_condition_seller')){ ?> 
    hideShowOnly('termLblPO','termConAppPO');
 <?php } ?>
  var save_method; 
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

$(document).ready(function () {
  $('#ajax_datatable').on('click', '.sendmailpo', function() {
        var po_id = $(this).data('id');
        var po_number = $(this).data('po_number');

        $("#mailmodal").modal('show');
        $("#po_id").val(po_id);
        $("#po_number").val(po_number);
        console.log(po_id);
    });
  <?php if(check_permission_status('Purchase Order','retrieve_u')==true):?>
    //datatables
    table = $('#ajax_datatable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo base_url('purchaseorders/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
                data.searchUser = $('#user_filter').val();
             }
        },
    "createdRow": function( row, data, dataIndex){
            if( data[5] == "<?=$poid; ?>"  ){
                $(row).css('background-color', 'rgb(84 81 81 / 44%)');
        changeNotiStatus();
            }
        },
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ],
        "columns": colarr,
       
        
    });
    function disableClick(e) {
        e.stopPropagation();
        e.preventDefault();
    }

    // Attach the click event handler to the element with ID 'ajax_datatable_filter'
    $('#ajax_datatable_filter').on('click', disableClick);
    //console.log(table);
    $('#date_filter,#user_filter').change(function(){
      table.ajax.reload();
    });

    $("#savecolvis").click(function () {
    var columnVisibility = [];
    saveChangesClicked = true;
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

    
  <?php endif; ?>
  
 function changeNotiStatus(){
  var noti_id="<?=$ntid;?>";
  url = "<?= site_url('notification/update_notification');?>";
  $.ajax({
    url : url,
    type: "POST",
    data: "noti_id="+noti_id+"&notifor=purchaseorders",
    success: function(data)
    {
      console.log(data);
      
    }
  });
}
});
function reload_table() {
    table.ajax.reload(null,false); //reload datatable ajax
}

  <?php if(check_permission_status('Purchase Order','delete_u')==true):?>
    function delete_entry(id,soid)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= base_url('purchaseorders/delete')?>/"+id,
                type: "POST",
                data: "soid="+soid,
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
  <?php endif; ?>
  
function approve_po_entry(poid,poidapp,stts, textid) {
  if(stts==1){  
  toastr.info('Please wait while we are processing your request..');
  }
  $("#"+textid).html('');
    var urlst = "purchaseorders/changeStatus";
    $.ajax({
        url : urlst,
        type: "POST",
        data: "poid="+poid+'&povalue='+stts,
        success: function(data)
        { 
            if(data==1){
        toastr.success('Purchase order ID #'+poidapp+" has been approved successfully.");
            }else if(data==0){
                toastr.error('Purchase order ID #'+poidapp+" disapproved successfully.");
            }else{
                toastr.success('Purchase Order ID #'+poidapp+" has been Approved Successfully.");
            }
       table.ajax.reload();
        }
    });
}; 

</script>

  <script>
  $(document).ready(function(){
    
  <?php if(check_permission_status('Purchase Order','delete_u')==true): ?>
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
  <?php endif; ?>
 
  });
  
$("#confirmed").click(function(){
  deleteBulkItem('purchaseorders/delete_bulk'); 
});
function refreshPage(){
      window.location.reload();
} 
</script>
<script>
  ////////////////////////////////////// fetch the data of month wise purchase order amount for purchase order graph/////////////////////////////////////
  $.ajax({
  url:'<?php echo site_url('purchaseorders/po_graph')?>',
              method:'post',
              success:function(response){
              if (response.status === 'success') {
              
var po_amount = [];
var xAxisCategories=[];
for (var i = 0; i < response.data.length; i++) {
  po_amount.push(parseFloat(response.data[i].subtotal)); 
    xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
}


var options = {
    series: [
        { name: 'Total PO Amount of month', data: po_amount },
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
   
    function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
} 
   

    
function sendpobymail(){

var formdata = $("#pomailform").serialize();
  $.ajax({
    url:'<?php echo site_url('Purchaseorders/sharepobymail'); ?>',
    method:'post',
    data:formdata,
    success:function(resp){
      alert(resp);
    }
  })
}
      
</script>





<!---------------------------- New Ajax Start MAss UPdate ---------------------------->
<script>

 function checkCheckbox(){
  
  }

function showAction(id) {
    var checkbox = $('input[value="' + id + '"].delete_checkbox');
    if (checkbox.is(':checked')) {
        $('#mass_id').val(id);
        // Show the button
        $('#mass_product').show();
       
    } else {
        // Hide the button if unchecked
        $('#mass_product').hide();    
    }
}


$("#mass_model").click(function(){
      $('#mass_product_model').modal('show')
 });

</script>


<script>
  const typesRequiringLength = [
    'subject','owner','renewal_date','customer_company_name','customer_name','customer_email','customer_mobile','microsoft_lan_no','customer_address',
    'supplier_name','supplier_comp_name','supplier_contact','supplier_email','supplier_gstin','supplier_country','supplier_state','supplier_city','supplier_zipcode','supplier_address',
     'billing_gstin','billing_country','billing_state', 'billing_city', 'billing_zipcode', 'billing_address',
    'shipping_gstin','shipping_country', 'shipping_state', 'shipping_city', 'shipping_zipcode','shipping_address'
  ];

  document.addEventListener('change', function (e) {
    if (e.target.matches('.type-select')) {
      
      
      const selectedType = e.target.value.trim().toLowerCase();

      const wrapper = e.target.closest('.form-row');
      const lengthWrapper = wrapper.querySelector('.length-wrapper');
      const dummytextWrapper = wrapper.querySelector('.dummytext');
      const input = wrapper.querySelector('.length-input');
      const renewal_dateSelect = wrapper.querySelector('.renewal_date-select'); 

      const payment_termsSelect = wrapper.querySelector('.payment_terms-select'); 



      if (typesRequiringLength.includes(selectedType)) {
        lengthWrapper.style.display = 'block';
        dummytextWrapper.style.display = 'none';

        // Hide all first
        input.style.display = 'none';
        renewal_dateSelect.style.display = 'none';

        // Show appropriate one 
        if (selectedType === 'renewal_date') { 
          renewal_dateSelect.style.display = 'block';
        }else if (selectedType === 'payment_terms') {
          payment_termsSelect.style.display = 'block';
        }else {
          input.style.display = 'block';
          input.placeholder = 'Enter value';
        }
      } else {
        lengthWrapper.style.display = 'none';
        input.value = '';
      }
    }
  });

  $('#massUpdateBtn').click(function (event) {
   
    event.preventDefault();

    // Get selected type
    var selectedType = $('#mass_name').val();
    var finalValue = '';

    // Decide which input to pick from 
    if (selectedType === 'renewal_date') {
      finalValue = $('#renewal_date_select').val();
    }else if (selectedType === 'payment_terms') {
      finalValue = $('#payment_terms_select').val();
    }else {
      finalValue = $('#value_input').val();
    }

    // Set hidden field
    $('#final_value_input').val(finalValue);

    // Submit via AJAX
    var formData = $('#massForm').serialize();
     
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('purchaseorders/add_mass'); ?>",
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.success) {
          alert(response.message);
          $('#mass_product_model').modal('hide');
           window.location.reload();
        } else {
          alert(response.message);
          window.location.reload();
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert('An error occurred while processing your request.');
      }
    });
  });
</script>

