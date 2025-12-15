<?php $this->load->view('common_navbar');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Users Target</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Users Target</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
            <div class="first-one">
            </div>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>
                  <!-- <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#quotation_newpopup">Assign </button> -->
                  <!--<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#add_user_popup">Add User</button>--->
              </div>
          </div>
        </div>
		
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
	<style>
	   .th-sm { background: #4a4a4a;
	   color: #fff; }
	   
	   dispHover{
		   visibility:block;
		   display:block;
	   }
	</style>
     <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
			 <div class="col-md-12" style="margin-top: 2%;">
				  <div class="col-md-4" style="float:left;">
					<select class="form-control" id="slctYrs">
					<?php 
					foreach($dateyr as $key => $value ){
					  $dataU=$value->month;
					  $date=date_create("01-01-".$dataU);
					  $year=date_format($date,"Y");
					 ?>
					  <option value="<?=$year;?>" <?php if(date('Y')==$year){ echo "selected"; } ?> ><?php echo $year;?></option>
					<?php } ?>
				  </select>
				  </div>


				  <div class="col-md-4" style="float:left;">
					<select class="form-control" id="slctMnth">
					<?php foreach($datemnth as $key => $value ){
					  $dataU=$value->month;
					  $date=date_create('01-'.$dataU.'-2020');
					  $dayMnt=date_format($date,"F");
					  $dayMnt2=date_format($date,"m");

					 ?>
					  <option value="<?=$dayMnt2;?>" <?php if(date('F')==$dayMnt){ echo "selected"; } ?> ><?php echo $dayMnt;?></option>
					<?php } ?>
				  </select>
				  </div>
			</div>
			  
			  
              <div class="card-body">
                <table id="table" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
					<thead class="thead-primary">
					  <tr>
						  <th class="th-sm">User&nbsp;Name</th>
						  <th class="th-sm">Sales Quota</th>
						  <th class="th-sm">Sales Achievement</th>
						  <th class="th-sm">Profit Quota</th>
						  <th class="th-sm">Profit Achievement</th>
						  <th class="th-sm">Target Month</th>
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
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <!-- Add new modal -->
    <div class="modal fade" id="modal_view" role="dialog">
          <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">User&nbsp;Form</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body form">
                  <table  class="table table-borderless table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead class="thead-primary">
                          <tr>
                              <th>User&nbsp;Name</th>
                              <th>Sales Quota</th>
                              <th>Profit Quota</th>
                              <th>Target Month</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
        <!--VIEW DIV CLASS-->
       
        
        <!-- Add data modal -->
          <div class="modal fade show" id="target_popup" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="organization_add_edit">Set target</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body form">
                    <form action="#" id="target_form" name="target_form" class="form-horizontal" enctype="multipart/form-data" method="post">
                      <div class="form-body form-row">

                         <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Select Date</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="date" value="<?php echo date('01-m-Y');?>" class="form-control form-control-sm" name="quota_month" id="quota_month" >
                        </div>


                        <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Sales Quota</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control form-control-sm" name="sales_quota" id="sales_quota" placeholder="Emter Sales Quota">
                            
                        </div>
                        <div class="col-md-4 mb-2 text-center">
                            <label for="" class="">Profit Quota</label>
                        </div>
                        <div class="col-md-2 mb-2 text-center">
                            <label> - </label>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control form-control-sm" name="profit_quota" id="profit_quota" placeholder="Enter Profit Quota">
                            
                        </div>
                      </div>
                      <input type="hidden" name="data_id" id="data_id" value="">
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save_target();return false;" class="btn btn-info btn-sm">Save</button>
                  </div>
              </div>
            </div>
          </div>
          <!-- Add data modal -->

 <?php $this->load->view('footer');?>
 
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script type="text/javascript">

var save_method; //for save method string
var table;
$(document).ready(function() {
    //datatables
    table = $('#table').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('target/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchYrs = $('#slctYrs').val();
                data.searchMnth = $('#slctMnth').val();
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
    });
    //datepicker


    $('#slctMnth').change(function(){
        table.ajax.reload();
    });
   
    function getMonth(){
      var yearsDt=$('#slctYrs').val();
      url = "<?= site_url('target/getMonth')?>";
      $.ajax({
        url : url,
        type: "POST",
        data: 'yearsDt='+yearsDt,
        success: function(data)
        {
          $('#slctMnth').html(data);
          table.ajax.reload();
        }
      });
    }

    getMonth();
    $('#slctYrs').change(function(){
     getMonth();
    });
	
	$("#sales_quota,#profit_quota").keyup(function(){
	var price = $(this).val();
	price = price.replace(/,/g, "");
    var pricetwo=numberToIndPrice(price);
	$(this).val(pricetwo);
	});

});








function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}

function delete_entry(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('target/delete')?>/"+id,
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
</script>

<script >

  function update_target(id,username)
  {
    
    $("#organization_add_edit").html("Update target for <i>"+username+"</i>");
    $('#target_form')[0].reset(); // reset form on modals
    $("#data_id").val(id);
    $('#target_popup').modal('show');
    $.ajax({
      url : '<?php echo site_url('target/getTargetbyId/')?>',
      type : 'POST',
      data : { 'id' : id },
      dataType: "JSON",
      success : function(data)
      {
        $('#quota_month').val(data.for_month);
        $('#sales_quota').val(numberToIndPrice(data.sales_quota));
        $('#profit_quota').val(numberToIndPrice(data.profit_quota));

      }
    });
  }

  function save_target()
  {
    var data_id=$("#data_id").val();

    var qmonth=$("#quota_month").val();
    var qsales=$("#sales_quota").val();
    var qprofit=$("#profit_quota").val();
    if(qmonth=="" || qmonth===undefined || qmonth==null){
          $("#quota_month").css('border-color','red');
          setTimeout(function(){ $("#quota_month").css('border-color',''); },3000);
    }else if(qsales=="" || qsales===undefined || qsales==null){
          $("#sales_quota").css('border-color','red');
           setTimeout(function(){ $("#sales_quota").css('border-color',''); },3000);
    }else if(qprofit=="" || qprofit===undefined || qprofit==null){
          $("#profit_quota").css('border-color','red');
           setTimeout(function(){ $("#profit_quota").css('border-color',''); },3000);
    }else{
        $.ajax({
          url : '<?php echo base_url('index.php/target/update_target'); ?>',
          type: "POST",
          data: $("#target_form").serialize(),
          dataType: "JSON",
          success: function(data)
          {
            table.ajax.reload();
            $("#target_popup").modal('hide');
          }
        });
    }
  }


</script>
</html>
