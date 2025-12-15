<?php $this->load->view('common_navbar');?>
<style>
.lbla {
    text-decoration: none;
    margin: 1px 0px;
    border-radius: 5px;
    font-size: 12px;
    padding: 0px 6px;
    background: #1a6aae;
    color: #faf9f8 !important;
}
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

/* #ajax_datatable tbody tr td:nth-child(3) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
} */
/* .filterbox{
  display:flex;
 
  width:70vw;
  border-radius:5px;
  background:rgba(197,180,227,0.2);
   border-top:none;
   border-left:5px solid purple;
  margin-left:18px;
  
} */
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
div.refresh_button button.btnstopcorner {
    /* border: 1px solid #ccc; 
    border-radius: 4px;
    background: white;
    color: #ccc; */

    border-radius: 4px;
    background: #f2f3f4;
    color: #ccc;
    font-weight: 600;
  }

  div.refresh_button button.btnstopcorner:hover {
    /* background:lightgrey;
    border: 1px solid #ccc;  */
  }
  a.btnstopcorner {
    border: 1px solid #ccc; /* Light grey border on hover */
    border-radius: 4px;
    background: white;
    color: rgba(30, 0, 75);
  }

  a.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; /* Light grey border on hover */
  }

    h5{
      font-size:16px;
    }
    h4{
      font-size:20px;
      font-weight:bolder;
    }
    /* Custom select box */
.custom-select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding: 8px 32px 8px 8px;
  border: none; /* Remove border */
  background-color: transparent; /* Make background transparent */
  font-size: 14px;
  color: #495057;
  cursor: pointer; /* Show pointer cursor */
}

.custom-select::after {
  /* content: '\25BC'; Unicode down arrow */
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  pointer-events: none; /* Ensure clicks go through */
}

.custom-select:hover {
  color: #000; /* Change text color on hover */
}

.custom-select option {
  background-color:#ccc; /* Change background color */
  color: #000; /* Change text color */
  border:none !important;
}

.custom-select option:hover {
  background-color: #f0f0f0; /* Change background color on hover */
}



</style>


 <!-- modal Payment -->
 <div class="modal fade" id="linkedinvoiceform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Add New Payment Reciept</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="paymentreceptForm" method="post" action="<?php echo base_url('add-paymentreciept'); ?>">
            <div class="form-group">
              <label for="exampleInput">Linked Invoice no.</label>
              <input type="text" class="form-control" name="paymentnum" id="linkedpaymentenum" placeholder="Enter linked invoice number">
            
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveChangesBtn">Submit</button>
          </div>
        </div>
      </div>
    </div>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.3);overflow-x:clip;">
    <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Payment Receipt</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
                <li class="breadcrumb-item active">Payment Receipt</li>
              </ol>
            </div><!-- /.col -->
          </div>
          

          <!-- /.row -->
          <div class="container-fliud filterbtncon"  >

            <div class="row mb-3">
                 
                    <div class="col-lg-2">
                      <div class="first-one custom-dropdown dropdown">
                          <button class="custom-select bt dropdown" type="button" id="dropdownMenuButtondate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Select Date
                          </button>
                          <input type="hidden" id="date_filter" value="" name="date_filter">
                          <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButtondate">
                              <li data-value="This Week">This Week</li>
                              <?php $week = strtotime("-7 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $week); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$week); ?>');">Last Week</li>
                              <?php $fifteen = strtotime("-15 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $fifteen); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$fifteen); ?>');">Last 15 days</li>
                              <?php $thirty = strtotime("-30 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $thirty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$thirty); ?>');">Last 30 days</li>
                              <?php $fortyfive = strtotime("-45 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $fortyfive); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$fortyfive); ?>');">Last 45 days</li>
                              <?php $sixty = strtotime("-60 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $sixty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$sixty); ?>');">Last 60 days</li>
                              <?php $ninty = strtotime("-90 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $ninty); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$ninty); ?>');">Last 3 Months</li>
                              <?php $six_month = strtotime("-180 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $six_month); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$six_month); ?>');">Last 6 Months</li>
                              <?php $one_year = strtotime("-365 Day"); ?>
                              <li data-value="<?= date('Y-m-d', $one_year); ?>" onclick="setSelectedOptiondate('<?= date('Y-m-d',$one_year); ?>');">Last 1 Year</li>
                          </ul>
                      </div>
                    </div>


                    <div class="col-lg-3">
                        <?php if($this->session->userdata('type')==='admin'): ?>
                            <div class="first-one custom-dropdown dropdown">
                                <button class="custom-select bt dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select User
                                </button>
                                <input type="hidden" id="user_filter" value="" name="user_filter">
                                <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <option selected value="">Select User</option>
                                    <?php foreach($admin as $adminDtl): ?>
                                        <li data-value="<?= $adminDtl['admin_email']; ?>" onclick="setSelectedOption(this);"><?php echo $adminDtl['admin_name']; ?></li>
                                    <?php endforeach; ?>
                                    <?php foreach($user as $userDtl): ?>
                                        <li data-value="<?= $userDtl['standard_email']; ?>" onclick="setSelectedOption(this);"><?php echo $userDtl['standard_name']; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-1"></div>
           
                
                    <!-- <div class="col-lg-2"></div> -->

                        <div class="col-lg-6">
                          <div class="refresh_button float-right">
                            <button class="btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
                            <button class="btnstopcorner" onclick="listgrdvw('gridview','listview','grid')"><i class="fas fa-th"></i></button>
                            <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                            <?php if($this->session->userdata('type')=='admin'){ ?>
                            <a href='Export_data/export_paymentreciept' class="p-0" ><button class="btncorner">Export Data</button></a>
                            <?php } ?>
                            <?php if(check_permission_status('Quotations','create_u')==true){
                              if($this->session->userdata('account_type')=="Trial" && $countQuote>=500){
                            ?> 
                            <button class="btnstopcorner" onclick="infoModal('You are exceeded  your quotation limit - 500')" style="border: 1px solid #ccc; border-radius: 4px; background: #845ADF; color: #fff; font-weight:600;" >Add New</button>
                            <?php }else{ ?>
                            
              
                            <a class="btnstopcorner dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #ccc; border-radius: 4px; background: #845ADF; color: #fff; font-weight:600;">
                            Add New
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            
                              <!-- <div class="dropdown-item" id="addpaymentreceipt"><a style="color:black; padding-left:0px;" href="javascript:void(0);">Add New Payment Reciept</a></div> -->

                              <div class="dropdown-item"><a style="color:black; padding-left:0px;" href="<?php echo base_url('add-paymentreciept');?>">Add New Payment Receipt</a></div>
                            
                            </div>

                            <?php } } ?>
                          </div>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
          </div>
            <!-- filter box starts-->
            <div class="card mx-md-5 mt-2 mb-0 px-5 py-4" style="border-radius:12px;">
                    <!-- filter box ends -->
                    <div class="accordion mx-3" id="faq" >
                      <div class="quoteaccordion">
                        <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Payment Receipt Summary</a>
                        </div>

                        <div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="row">
                                <div class="col-md-4">
                                  <div class="card-body">
                                  <span id ="totalRecords"> </span>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="card-body">
                                    <span id = "totalAmounts"> </span>
                                  </div>
                                </div>
                                <!-- <div class="col-md-2">
                                  <div class="card-body">
                                    Payment Consumed :
                                  </div>
                                </div> -->
                            </div>
                        </div>
                      </div>

                      <div class="quoteaccordion">
                        <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2"> <a href="#" class="btn btn-header-link" ><i class="fas fa-file-alt"></i> Payment Reciept Graph</a>
                        </div>
                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <div class="card-body">
                                  <div id="chart-line">
                                  </div>
                            </div>
                        </div>
                      </div>
                    </div>
            </div>
          </div>
          <!-- /.content-header -->
          <!-- Main content -->
      
      <section class="content">
        <div class="container-fluid">
          <!-- Main row -->
           <!-- Map card -->
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
                <!-- /.card-header -->
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
                                  <td>Payment Receipt Date</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>Payment Receipt NO.</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked  ></td>
                                </tr>
                                <tr>
                                <td>Billed To</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>

                                 <tr>
                                <td>Invoice No.</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr> 
                                <tr>
                                <td>Currency</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <!-- <tr>
                                <td>Status</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr> -->
                                <!-- <tr>
                                <td>GSTIN/UIN of Recipient</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr>
                                <tr>
                                <td>PAN</td>
                                  <td align="center"><input class="inputbox" type="checkbox" checked ></td>
                                </tr> -->
                                <td>Amount </td>
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
            <div class="card-header mb-2"><b style="font-size:21px;">Payment Receipt</b> <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button></div>
                  <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                <!-- modelstart     -->
      
           <!-- model end -->
                    <thead>
                      <tr>
                        <?php if(check_permission_status('Quotations','delete_u')==true):?>
                          <!-- <th style="width:4%;" ><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th> -->
                          <th style="width:4%;" ><button class="btn" type="button" name="delete_all" id="delete_all2">Sr No.</button></th>
                        <?php endif; ?>
                        <th class="th-sm" style="" >Date</th>
                        <th class="th-sm" style="">Payment Receipt</th>
                        <th class="th-sm">Billed To</th>
                        <th class="th-sm">Invoice No.</th>
                        <th class="th-sm">Currency </th>
                        <th class="th-sm">Amount </th>
                       
                        <!-- <th class="th-sm">GSTIN/UIN of Recipient</th>
                        <th class="th-sm">PAN</th>
                        <th class="th-sm">Amount Due</th> -->
                        <th class="th-sm">Action</th>
                      </tr>
                    </thead>
                    <tbody>                                     
                    </tbody>
                  </table>
                </div>
            </div>
                <!-- GRID VIEW -->
            <div class="card-body" id="gridview" style="display:none;" >
        <input type="text" class="form-control" id="searchRecord" name="searchRecord" style="margin-bottom: 13px; width: 33%;" placeholder="Search Data">
        <div class="row" style="width: 100%;">
          <?php 
            $leadStatus=array('Negotiation','On Hold','Draft','Confirmed','Closed Lost','Closed Won','Delivered');
           for($i=0; $i<count($leadStatus); $i++){ 
            $ind=str_replace(' ','',$leadStatus[$i]);
            $ind=str_replace('-','',$ind);
           ?>
             <div class="hdr">
              <span><?=$leadStatus[$i];?></span>
              <br>
              <input type="hidden" id="<?=$ind;?>" value="<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>">
              <span>₹ 
              <text id="txt<?=$ind;?>" data-min='<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>'  data-delay='3' data-increment="99" > <?=IND_money_format($price[$ind]['initial_total']);?></text></span>
             </div>
          <?php  } ?>
        </div>
        <div class="row" style="width: 100%;" id="putLeadData"></div>
        <div   id="pagination_link"></div>
      </div> 
        </div>
      </section>
  </div>

 <?php $this->load->view('footer');?>
 
<!-- ./wrapper -->
<?php $this->load->view('common_footer');?>
<?php if(isset($_GET['qtid'])){
  $qtid=$_GET['qtid'];
  $ntid=$_GET['ntid'];
}else{
  $qtid='';
  $ntid='';
} ?>

<script>

$("#addpaymentreceipt").click(function(){
      
      $('#linkedinvoiceform').modal('show')
 })


 //delete Paymentreciept
function delete_paymentreciept(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('Accounting/paymentreciept_delete')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                $("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Payment Receipt information has been deleted.');				
                $("#alert_popup").modal('show');
                setTimeout(function(){ $("#alert_popup").modal('hide'); reload_table();  },2000);
                 
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
              $("#common_popupmsg").html('<i class="fa fa-exclamation-triangle" style="color: red;"></i><br>Error deleting data!');				
              $("#alert_popup").modal('show');
              setTimeout(function(){ $("#alert_popup").modal('hide'); },2000);
                  //alert('Error deleting data');
              }
          });
      }
  }




function numberRoller(pttxt,maxprice){
    
            var min=parseInt($("#"+pttxt).attr('data-min'));
            var max=parseInt(maxprice);
            var timediff=parseInt($("#"+pttxt).attr('data-delay'));
            var increment=parseInt($("#"+pttxt).attr('data-increment'));
            var numdiff=max-min;
            var timeout=(timediff*1000)/numdiff;
            numberRoll(pttxt,min,max,increment,timeout);
            
}
function numberRoll(pttxt,min,max,increment,timeout){
        if(min<=max){
            $("#"+pttxt).html(min);
            min=parseInt(min)+parseInt(increment);
            setTimeout(function(){
      numberRoll(pttxt,eval(min),eval(max),eval(increment),eval(timeout))
      },timeout);
        }else{
            $("#"+pttxt).html(max);
        }
}

function listgrdvw(dispid,idhide,grid=''){
  if(grid=='grid'){
    $("#user_filter").hide();
    $("#stage_filter").hide();
  }else{
    $("#user_filter").show();
    $("#stage_filter").show();
  }
  $('#'+idhide).hide();
  $('#'+dispid).show();
}

 function load_country_data(page,dateFilter)
 {
   
  var search    = $("#searchRecord").val();
  if(dateFilter===undefined){
    dateFilter='';
  }
  $.ajax({
   url:"<?php echo base_url(); ?>quotation/pagination/"+page,
   method:"GET",
   data:"searchDate="+dateFilter+"&search="+search,
   dataType:"json",
   success:function(data)
   {
    $('#pagination_link').html(data.pagination_link);
   }
  });
 }
 
 load_country_data(1);

 $(document).on("click", ".pagination li a", function(event){
  event.preventDefault();
    var page = $(this).data("ci-pagination-page");
    var dateFilter  = $("#date_filter").val();
    load_country_data(page,dateFilter);
    getDataGrid(dateFilter,'',page);
 });


    //addElements();
  getDataGrid('','',1);
  function getDataGrid(dateFilter='',search='',page=''){
    $.ajax({
      url : "<?= site_url('quotation/gridview');?>",
      type: "POST",
      data: "leadid=123&searchDate="+dateFilter+"&search="+search+'&page='+page,
      success: function(data){
        $("#putLeadData").html(data);
      }
    });
  }
  
  $("#searchRecord").keyup(function(){
    var search    = $(this).val();
    var date_filter = $("#date_filter").val();
    getDataGrid(date_filter,search,1);
    load_country_data(1);
  });

  

  $("#saveChangesBtn").click(function() {
      // Trigger form submission
      $("#paymentreceptForm").submit();
    });
</script>

<script type="text/javascript">
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
  
  <?php if(check_permission_status('Quotations','retrieve_u')==true):?>
    //datatables



table = $('#ajax_datatable').DataTable({
  
  "processing": true,
  "serverSide": true,
  "searching": true,
  "order": [],
  "ajax": {
      "url": "<?php echo site_url('Accounting/ajax_listpayment')?>",
      "type": "POST",
      "dataType":"json",
      "data": function (data) {
        // alert(data)
          data.searchDate = $('#date_filter').val();
          data.searchUser = $('#user_filter').val();
          // data.searchStage = $('#stage_filter').val();
      },

      "dataSrc": function(json) {
       
       $('#totalRecords').text("Payment Receipts : " + json.recordsTotal);
        $('#totalAmounts').text("Payment Receipt Amount : ₹ " + json.Totalamount); 
        return json.data; 
     }
     

  },

  "columnDefs": [
      {
          "targets": [0], // Last column
          "orderable": false, // Set not orderable
      },
  ],
  "columns": colarr
  
});


function setSelectedOptiondate(dateValue) {
    var button = document.getElementById("dropdownMenuButtondate");
    var selectedText = ""; // Variable to store the selected text
    switch (dateValue) {
        case "<?= date('Y-m-d', $week); ?>":
            selectedText = "Last Week";
            break;
        case "<?= date('Y-m-d', $fifteen); ?>":
            selectedText = "Last 15 days";
            break;
        case "<?= date('Y-m-d', $thirty); ?>":
            selectedText = "Last 30 days";
            break;
        case "<?= date('Y-m-d', $fortyfive); ?>":
            selectedText = "Last 45 days";
            break;

        case "<?= date('Y-m-d', $sixty); ?>":
            selectedText = "Last 60 days";
            break;

        case "<?= date('Y-m-d', $ninty); ?>":
            selectedText = "Last 3 Months";
            break;

        case "<?= date('Y-m-d', $six_month); ?>":
            selectedText = "Last 6 Months";
            break;
            
        case "<?= date('Y-m-d', $one_year); ?>":
            selectedText = "Last 1 year";
            break;
        // Add cases for other date options as needed
        default:
            selectedText = dateValue; 
            break;
    }
    button.textContent = selectedText; 
    document.getElementById("date_filter").value = dateValue;

    // Reload table data
    getfilterdData(dateValue, 'getsovalue', 'date_filter');
}


    function setSelectedOption(option) {
        var selectedText = option.textContent;
        var button = document.getElementById("dropdownMenuButton");
        button.textContent = selectedText;

        var selectedValue = option.getAttribute("data-value");
        document.getElementById("user_filter").value = selectedValue;

        // Close the dropdown
        var dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.classList.remove('show');

        // Reload table data
        getfilterdData(selectedValue, 'user_filter');
    }

    function getfilterdData(e, f, g) {
      
    var id = "#" + g;
    $(id).val(e);
    if (typeof window[f] === "function") {
        window[f]();
    }
    table.ajax.reload();
} 

  



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

  

    $('#date_filter').change(function(){
        var search    = $("#searchRecord").val();
      var date_filter = $("#date_filter").val();
      getDataGrid(date_filter,search,1);
      load_country_data(1,date_filter);
      table.ajax.reload();
    });
  
  $('#user_filter,#stage_filter').change(function(){
      table.ajax.reload();
    });
    //datepicker
    
    
   function changeNotiStatus(){
  var noti_id="<?=$ntid;?>";
  url = "<?= site_url('notification/update_notification');?>";
  $.ajax({
    url : url,
    type: "POST",
    data: "noti_id="+noti_id+"&notifor=quotation",
    success: function(data)
    {
    
    }
  });
} 
    
    
  <?php endif; ?>
    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }
  

  <?php if(check_permission_status('Quotations','delete_u')==true):?>
    function delete_entry(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
            url : "<?= site_url('quotation/delete')?>/"+id,
            type: "POST",
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

</script>
<script>
$(document).ready(function(){
 $('.delete_checkbox').click(function(){
  if($(this).is(':checked'))
  {
   $(this).closest('tr').addClass('removeRow');
  }
  else
  {
   $(this).closest('tr').removeClass('removeRow');
  }
});
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
  deleteBulkItem('quotation/delete_bulk'); 
});

 function refreshPage()
  {
    window.location.reload();
  }
</script>

<script>
 
      ////////////////////////////////////// fetch the data of month wise Payment Receipt amount for Recipt graph/////////////////////////////////////

  $.ajax({
        url:'<?php echo site_url('Accounting/get_paymentreceipt_graph')?>',
        method:'post',
        success:function(response){
        if (response.status === 'success') {
              
        var Paymentreceipt_amount = [];
        var xAxisCategories=[];
        for (var i = 0; i < response.data.length; i++) {
          Paymentreceipt_amount.push(parseFloat(response.data[i].subtotal)); 
          xAxisCategories.push(response.data[i].month + "/" + response.data[i].year);
        }


      var options = {
          series: [
              { name: 'Payment Receipt Amount of month', data: Paymentreceipt_amount },
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
          },
          // colors: ['#6a0dad']
      };
        var chart = new ApexCharts(document.querySelector("#chart-line"), options);
        chart.render();

              }
             }
  });
      
</script>