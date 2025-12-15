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

  </style>
  <!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />

  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.3);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Set Prefix ID</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Set Prefix ID</li>
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
			  
				<table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th class="th-sm">Module Name</th>
                          <th class="th-sm">Prefix ID</th>
                          <th class="th-sm">Example</th>
                          <th class="th-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php $datatArr=array(				
						'contact', 'invoices', 'lead', 'opportunity', 'organization', 'performa_invoice', 'product', 'purchaseorder', 'quote', 'salesorder','vendor');
					 ?>	
					 <?php 
						for($i=0; $i<count($datatArr); $i++){
							$getid=$datatArr[$i]."_id";
							if($getid=='invoices_id'){
								$getid="invoice_no";
							}
							if($getid=='performa_invoice_id'){
								$getid="invoice_no";
							}if($getid=='salesorder_id'){
								$getid="saleorder_id";
							}
							$dataRow=$this->setting->getallid($datatArr[$i],$getid);
							
							$prefix=$this->setting->getprefixID($datatArr[$i]);
							//print_r($prefix);
							if(isset($prefix['prefix_id'])){
							    $prefixId=$prefix['prefix_id'];
							}else{
							    $prefixId='';
							}
							
							if(isset($dataRow[$getid])){
							    $dataRowId=$dataRow[$getid];
							}else{
							    $dataRowId='';
							}
							
							
						?>
                        <tr> 
						<td><?=ucwords(str_replace("_"," ",$datatArr[$i]));?>
						    <!--<div class="links"><a style="text-decoration:none" href="javascript:void(0)" onclick="update('<?=$datatArr[$i];?>','<?=$prefixId;?>')" class="text-primary">Add/Update</a></div>--></td>
						<td><?php echo $prefixId; ?></td>
						<td><?php echo $dataRowId; ?></td>
						<td><a style="text-decoration:none" href="javascript:void(0)" onclick="update('<?=$datatArr[$i];?>','<?=$prefixId;?>')" class="text-primary"><i class="far fa-edit sub-icn-so m-1" data-toggle="tooltip" data-container="body" title="Update/Add" ></i></a></td>
						</tr>
						<?php } ?>
                    </tbody>
                </table>
			  
			 
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

 
</div>
<!-- ./wrapper -->


		<div class="modal fade" id="modal_form" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content" id="putModalData">
                <div class="modal-header">
                    <h3 class="modal-title" id="contact_add_edit">Add/Update Prefix ID</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body form" id="putDatarow">
					<form id="search_form" method="post">
                <div class="form-body form-row">
					<div class="col-md-3 mb-3">Prefix ID #</div>
					<div class="col-md-6 mb-3">
                      <div class="col-md-12 mb-3">
                        <input type="text" class="form-control" name="prefixid" id="prefixid" placeholder="Enter prefix id (EX. ALLE)" required="">
						<input type="hidden" name="tblName" id="tblName" required="">
                      </div>
					</div>
					<div class="col-md-3 mb-3"></div>
				</div>
				</form>
                </div>
                <div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" id="saveBtn" onclick="savePrefix()" >Save</button>
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>





<!-- common footer include -->

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="<?= base_url();?>assets/js/common_pages.js"></script>
<script src="<?= base_url();?>assets/js/validation.js"></script>
<?php $this->load->view('common_footer');?>

<script>
function savePrefix()
{
  var prefixid  = $('#prefixid').val();
  var tablename = $('#tblName').val();
  if(prefixid != ''){
    $.ajax({
     url: "<?= site_url(); ?>/setting/savePrefix",
     method: "POST",
     data: {tablename:tablename,prefixid:prefixid},
	 dataType:"json",
     success: function(data){
      //if(data.status==true){
		  // $("#modal_form").modal('hide');
			// $('#tblName').val(''); 
		  //}else{
			// alert('Something went wrong.');
		  //}
      // $('#clmnDiv').html(data);
	    //$("#clmnDiv").show();

      // $("#modal_form").modal('hide');
			// $('#tblName').val('');

      if(data.status==true){
        location.reload(); 
		  }else{
        alert('Something went wrong.');
		  }
		  
     }
    });
  }
}

function update(tblName,prefixid){
	$("#modal_form").modal('show');
	$('#tblName').val(tblName);
	$('#prefixid').val(prefixid);
}

</script>

