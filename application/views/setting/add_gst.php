<?php $this->load->view('common_navbar');?>
<style>
	 #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

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

#ajax_datatable tbody tr td:nth-child(3) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}

button.btnstopcorner{
    
    border-radius: 4px;
    background: #f2f3f4;
    color: #ccc;
    font-weight:600;
    /* padding:7px; */
  }

  /* div.refresh_button button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; 
  } */
    
   button.btnstop{
    border: 1px solid #ccc; 
    border-radius: 4px;
    background: #845ADF;
    color: #fff;
    font-weight:600;
    /* padding:7px; */
  }

   button.btnstop:hover{
    
    color:#fff!important;
  }


  

   </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">GST</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">GST</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      
    <!-- /.content-header -->
    <div class="container-fliud filterbtncon"  >
			  <form method="post" action="">
       
        <?php 
                                  //  $fifteen = strtotime("-15 Day"); 
                                  //  $thirty = strtotime("-30 Day"); 
                                  //  $fortyfive = strtotime("-45 Day"); 
                                  //  $sixty = strtotime("-60 Day"); 
                                  //  $ninty = strtotime("-90 Day"); 
                                  //  $six_month = strtotime("-180 Day"); 
                                  //  $one_year = strtotime("-365 Day");
                            ?>
        <!-- /.row -->
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

                       		  						
						 <div class="clearfix"></div>
						  
							<div class="col-sm-10 form-group text-right">
								  <button class="btn btnstopcorner rounded-0" type="button" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>								 
								  <button type="button" class="btn btnstop add_button rounded-0" id="AddGst"><a href="#" style="color:#fff;">Add GST</a></button>
								  
							</div>
						
                      
                  </div>
                </form>
</div>
                <div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">GST</b> 
            <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
                    </div>
            <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                  
                            <th class="th-sm">Tax Name</th>
                            <th class="th-sm">Description</th>
                            <th class="th-sm">GST Rate/Sales Rate (%)</th>  
                            <th class="th-sm">Added Date</th>
							<th class="th-sm" style="width:8%">Action</th>							
                        </tr>
                    </thead>
                    <tbody>         
                    </tbody>
                </table>
              </div>
            </div>
      </div>
    </section>
  </div>
</div>


<style>


input#collection_of_sale {
    width: 70px;
}
input#collection_of_purchases {
    width: 70px;
}
</style>


<!--meeting click popup-->
<!-- Modal -->
<div class="modal fade" id="gst_modal" tabindex="-1" aria-labelledby="meeting_clickLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gst_modal_title">View / Update GST Information</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="gstForm" method="post">
            <div class="row" id="formDivhd">
                <input type="hidden" value="1"  name="saveDatagst" id="saveDatagst">
                <input type="hidden" value="0"  name="saveDatagstid" id="saveDatagstid">
                <input type="hidden" value="0"  name="addgstCheck" id="addgstCheck">
                
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Select Tax Type<span class="text-danger">*</span>:</label>
                      <input type="text" class="form-control checkvl" list="taxName" name="tax_name" id="tax_name" placeholder="Select TAX">
                      <datalist id="taxName">  
                          <option value="">Select Tax Type</option>
                          <option value="GST">GST (India)</option>
                          <option value="VAT">VAT</option>
                          <option value="PPN">PPN</option>
                          <option value="SST">SST</option>
                          <option value="HST">HST</option>
                          <option value="TAX">TAX</option>
                          <option value="Custom">Custom (Add text type)</option>
                      </datalist>
                    </div>
    			</div>
    			<div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Tax Rate (%)<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control checkvl" name="gst_percentage" id="gst_percentage" placeholder="Tax Rate">
                    </div>
    			</div>
    			
    			<div class="col-lg-12">
                    <div class="form-group">
                        <label for="">Description :</label>
                        <textarea class="form-control selctCl" name="description" id="description"></textarea>
                    </div>
    			</div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Collection on Sales :</label>
                        <input type="checkbox" id="myCheck" name="collection_of_sale" value="1">
                    </div>
    			</div>
    		    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Collection on Purchases :</label>
                        <input type="checkbox" id="myCheck_purchases" name="collection_of_purchases" value="1" >
                    </div>
    			</div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-secondary rounded-0">Close</button>
        <button type="button" class="btn btn-info"  id="GstFormSave">Save</button>
      </div>
    </div>
  </div>
</div>
<!--meeting click popup-->

<?php $this->load->view('common_footer');?>

<script type="text/javascript">
var save_method;
var table;
$(document).ready(function() {
    table = $('#dt-multi-checkbox').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list_gst')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data){
                data.searchDate = $('#date_filter').val();
				data.searchUser = $('#user_filter').val();
				data.firstDate  = $('#firstDate').val();
				data.secondDate = $('#secondDate').val();
            }
        },
        "columnDefs": [{
            "targets": [ -1 ], 
            "orderable": false, 
        },]
    });
    $('#date_filter').change(function(){
		table.ajax.reload();
    });
  }); 
  function reload_table()
  {
    table.ajax.reload(null,false);
  }

  function delete_gst(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          $.ajax({
              url : "<?= site_url('setting/delete_gst')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                if(data.status) 
                {
                    toastr.info('Item has been deleted successfully');
                    reload_table();
                }else{
                    toastr.error('Something went wrong, Try later.');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  toastr.error('Something went wrong, Try later.');
              }
          });
      }
  }
  
 
  function updateTax(id)
  {   
      $("#gst_modal_title").html('Update Tax Information');
        $.ajax({
              url : "<?= site_url('setting/getbyid_gst')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              { 
                 $("#addgstCheck").val('update');
                 $('#saveDatagstid').val(data.id);
                 $('#tax_name').val(data.tax_name);
                 $("#description").val(data.description);
                 if(data.collection_of_sale == 1){
                 $("#myCheck").prop('checked',true);
                 }
                 if(data.collection_of_purchases == 1){
                 $("#myCheck_purchases").prop('checked',true);
                 }
				 $('#gst_percentage').val(data.gst_percentage);
              }
        });
      $("#gst_modal").modal('show');
  }

 

$("#AddGst").click(function(){  
    $("#addgstCheck").val('add');
    $("#GstFormSave").html('Save');
    $("#gst_modal").modal('show');
    $("#gst_modal_title").html('Add Tax Information');
    $('#gstForm')[0].reset();
});

$("#GstFormSave").click(function(){
	if(checkValidationWithClass('gstForm')==1){
	    toastr.info('Please wait while we are processing your request');
	    var dataString = $("#gstForm").serialize();
	    var adddt=$("#addgstCheck").val();
	    if(adddt=='add'){
            var url = "<?= base_url('setting/addgst')?>";
	    }else{
	        var url = "<?= base_url('setting/updategst')?>";   
	    }
        $.ajax({
            url : url,
            type: "POST",
            data: dataString,
            dataType: "JSON",
            success: function(data)
            { 
              if(data.status){
                toastr.success('Your Tax information saved successfully.');  
                $('#gst_modal').modal('hide');
                reload_table();
              }else{
                 toastr.error('Something went wrong, please try later.'); 
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error('Something went wrong, please try later.'); 
            }
        });
	}else{
	    toastr.error('Please fill * mark fields');
	}
    
});
function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}

</script>