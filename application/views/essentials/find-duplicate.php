<?php $this->load->view('common_navbar');?>
  <!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />
<style>
  #dt-multi-checkbox thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   /* padding-top:18px;
  padding-bottom:18px; */
  

}


#dt-multi-checkbox tbody tr td {
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

#dt-multi-checkbox tbody tr td:nth-child(5) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}
</style>

  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Find Duplicate</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Find Duplicate</li>
            </ol>
          </div><!-- /.col -->
        </div>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
			  <form id="search_form" method="post">
                <div class="form-body form-row">
					<div class="col-md-3 mb-3"></div>
					<div class="col-md-6 mb-3">
                      <div class="col-md-12 mb-3">
                        				
						<?php $datatArr=array(				
						'contact', 'email_automation','gst', 'invoice', 'invoice_terms', 'invoices', 'lead', 'opportunity', 'organization', 'performa_invoice', 'product', 'purchaseorder', 'quote', 'salesorder', 'standard_users','vendor');
					 ?>				
                        <select class="form-control" name="tblName" id="tblName" onChange="getCulumn()" required>
                            
						<option value="">Select Module</option>
						<?php 
						for($i=0; $i<count($datatArr); $i++){
						?>
						
						<option value="<?=$datatArr[$i];?>"><?=ucwords(str_replace("_"," ",$datatArr[$i]));?></option>
						<?php } ?>
						</select>
                        <span id="org_name_error"></span>
                      </div>
                      <div class="col-md-12 mb-3" id="clmnDiv" style="display:none;">
                        
                      </div>
                      <div class="col-md-12 mb-3">
                        <button type="button" class="btn btn-info" name="search_duplicate" id="search_duplicate">Search</button>
                      </div>
					</div>
					<div class="col-md-3 mb-3"></div>
				</div>
				</form>
              </div>
              <!-- /.card-body -->
			  
			  
			   <div class="card-body" id="putDupData">
			   
			   </div>
			  
			  
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

 
</div>
<!-- ./wrapper -->


		<div class="modal fade" id="modal_view_form" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" id="putModalData">
                <div class="modal-header">
                    <h3 class="modal-title" id="contact_add_edit">Dublicate Row</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body form" id="putDatarow">
					
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>


<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>

<script>
function getCulumn()
{
  var tablename = $('#tblName').val();
  if(tablename != ''){
    $.ajax({
     url: "<?= site_url(); ?>/Find_duplicate/getField",
     method: "POST",
     data: {tablename:tablename},
     success: function(data){
       $('#clmnDiv').html(data);
	   $("#clmnDiv").show();
     }
    });
  }
}

function getallRow(clmnName,value,tblName){
	$("#modal_view_form").modal('show');
	$.ajax({
		url: "<?= site_url(); ?>/Find_duplicate/find_row_data",
		method: "POST",
		data: "clmnName="+clmnName+"&value="+value+"&tblName="+tblName,
		success: function(data){
			$("#putDatarow").html(data);
		}
    });
}

function delete_entry(tblName,rowid,clmnName,value){
	$.ajax({
		url: "<?= site_url(); ?>/Find_duplicate/delete_entry",
		method: "POST",
		data: "rowid="+rowid+"&tblName="+tblName,
		success: function(data){
			$("#search_duplicate").click();
			getallRow(clmnName,value,tblName);
		}
    });
}

$("#search_duplicate").click(function(){
		$.ajax({
			url: "<?= site_url(); ?>/Find_duplicate/find_duplicate_data",
			method: "POST",
			data: $('#search_form').serialize(),
			success: function(data){
				$("#putDupData").html(data);
			}
		});
	
});

</script>

