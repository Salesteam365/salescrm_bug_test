<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoices</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Invoices</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
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
              <div class="card-body" id="countSearch">
			  <form method="post" action="">
                  <div class="row">
                      <div class="col-sm-2 form-group">
                          <select class="form-control" name="date_filter" id="date_filter">
                              <option value="">Select Date</option>
							  <option value="This Week">This Week</option>
							  <?php $week = strtotime("-7 Day"); ?>
							  <option value="<?= date('y.m.d', $week); ?>">Last Week</option>
							  <?php $fifteen = strtotime("-15 Day"); ?>
							  <option value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</option>
							  <?php $thirty = strtotime("-30 Day"); ?>
							  <option value="<?= date('y.m.d', $thirty); ?>">Last 30 days</option>
							  <?php $fortyfive = strtotime("-45 Day"); ?>
							  <option value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</option>
							  <?php $sixty = strtotime("-60 Day"); ?> 
							  <option value="<?= date('y.m.d', $sixty); ?>">Last 60 days</option>
							  <?php $ninty = strtotime("-90 Day"); ?>
							  <option value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</option>
							  <?php $six_month = strtotime("-180 Day"); ?>
							  <option value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</option>
							  <?php $one_year = strtotime("-365 Day"); ?>
							  <option value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</option>
                          </select>
                      </div>
                       
                      <!--<div class="col-sm-2 form-group">
                        <select class="form-control" name="user_filter" id="user_filter">
                          <option value="">Select User</option>
							<?php if(!empty($user)) { foreach($user as $users) { ?>
							  <option value="<?= $users['standard_email']?>"><?= $users['standard_name']?></option>
							<?php } } ?>
							<?php if(!empty($admin)) { foreach($admin as $adm) { ?>
							  <option value="<?= $adm['admin_email']?>"><?= $adm['admin_name']?></option>
							<?php } } ?>
                        </select>
                      </div>-->
                      
                      <div class="col-sm-2 form-group">
                        <input type="date" class="form-control" name="firstDate" id="firstDate">
                      </div>
                      
                      <div class="col-sm-2 form-group">
                         <input type="date" class="form-control" name="secondDate" id="secondDate">
                      </div>
					   				  						
						 <div class="clearfix"></div>
						  
							  <div class="col-sm-6 form-group text-right">
								  <button class="btn btn-info" type="button" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>								 
								   <button class="btn btn-info add_button check_invoice"><a href="javascript:void(0);" style="color:white;">Create New Invoice</a></button>
							  </div>
						
                      <!--<div class="col-sm-6 total-amount text-right">
                      <p>1,40000/- INR</p>
                  </div>-->
                  </div>
                </form>
                <table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>
						<?php if($this->session->userdata('delete_so')=='1'):?>
                      <?php endif; ?>                           
                            <th class="th-sm">Invoice#</th>
                            <th class="th-sm">Customer Name</th>
                            <!--<th class="th-sm">Purchase Order</th>-->
                            <th class="th-sm">Total Amount</th>
                            <th class="th-sm">Status</th>
							<th class="th-sm">Date</th>
                            
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
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script type="text/javascript">
var save_method; //for save method string
var table;
$(document).ready(function() {

    table = $('#dt-multi-checkbox').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('invoices/ajax_list')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
			
             {
                data.searchDate = $('#date_filter').val();
				data.searchUser = $('#user_filter').val();
				data.firstDate  = $('#firstDate').val();
				data.secondDate = $('#secondDate').val();
				
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ 0 ], //last column
            "orderable": false, //set not orderable
        },
        ]
    });
	//count_pending_price();
    $('#date_filter').change(function(){
		//alert('date_filter');
		table.ajax.reload();
		
    });
	$('#user_filter').change(function(){
		table.ajax.reload();
		
    });
    
    $('#firstDate,#secondDate').change(function(){
		table.ajax.reload();
		
    });
    
  }); 
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax
  }
  //delete proforma invoice
  function delete_invoice(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('invoices/delete_pi')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
				$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Invoice information has been deleted.');				
				$("#alert_popup").modal('show');
				setTimeout(function(){ $("#alert_popup").modal('hide'); reload_table();  },2000);
                  //if success reload ajax table
                 //alert('PI delete sucessfully');
                  //reload_table();
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

$('.check_invoice').click(function(){
	$.ajax({
		url : "<?= base_url('invoices/checkInvoicetotal'); ?>",
		type: "POST",
		data: "",
		dataType: "JSON",
		success: function(data){
		//	alert(data);
			//console.log(data);
			if(data.status == 200){
			   	$('.check_invoice').attr('disabled',false); 
			   window.location.href = "<?=base_url('invoices/new-invoice'); ?>";
				
			}else if(data.status == 201){
			    
				$(".putappend_msg").html('You can generate only '+data.totalinvoices+' invoices in a month .To generate more invoices upgrade now');
				$("#addModal").modal('show');
				//setTimeout(function(){ $("#alert_popup").modal('hide');  },2000);
				//$("#show_msgs").html(data.show_msg);
				$('.check_invoice').attr('disabled',true);
			}
			
			
			}
		});
    
    });	

</script>
