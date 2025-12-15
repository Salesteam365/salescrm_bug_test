<?php $this->load->view('superadmin/common_navbar'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Meta Tag Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Meta Tag Details</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
           <!--<div class="col-lg-2">
	       <b>From Date</b>	  
            <input type="date" placeholder="From Date" value="" id="fromDate"></div>
	      <div class="col-lg-2">
	        <b>To Date</b>
	        <input type="date" placeholder="To Date" value="" id="toDate">-->
    <!--<button class="btn btn-info" id="date_filter" title="Search Attendance">Filter</button>-->

           <!--<div class="first-one">
                <select class="form-control" name="date_filter" id="date_filter">
                  <option selected disabled>Select Date</option>
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
          </div>-->
          <div class="col-lg-12">
		     <?php if($this->session->userdata('success_msg')){ ?>
				<b id="hideDiv" style="color:green"><?php echo $this->session->userdata('success_msg'); ?> </b> 
			<?php }elseif($this->session->userdata('error_msg')){ ?>
			<span id="hideDiv" style="color:red"><?php echo $this->session->userdata('error_msg'); ?> </span>
			<?php } ?>
		  </div>
          <div class="col-lg-12">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
				  <!--<button class="btn btn-info btn-sm" style="width:135px;" onclick="import_excel()">Import&nbsp;Excel</button
                  <button class="btn btn-info btn-sm" onclick="add_form()">Add New</button>-->
				 <button class="btn btn-info btn-sm"> <a href="<?php echo base_url('superadmin/meta_tag/meta_addUpdate'); ?>" style="color:white;"><b>ADD</b></a></button>
              </div>
          </div>
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
                <table id="ajax_datatable_meta" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                           
							<th class="">#</th>
							<th class="th-sm">Page Name</th>
							<th class="th-sm">Meta Title</th>
							<th class="th-sm">Meta Keyword</th>
                            <th class="th-sm">Meta Description</th>
							<th class="th-sm">Status</th>
							<th>Action</th>
							
                        </tr>
                    </thead>
                    <tbody>
					<?php
				 
                 if($meta_details){	
                  $i=1;				 
				  foreach($meta_details as $post):
				?>
				
              <tr>
			  <td><?=$i++; ?></td>
			  <td><?=$post['page_title'] ?></td>
			  <td><?=$post['meta_title'] ?> </td>
			  <td><?=$post['meta_keyword'] ?></td>
			  <td><?=$post['meta_description'] ?></td>
			  
			  <td><?php  if($post['status'] =='1' ) { echo 'Active'; }else{ echo 'Non-active'; } ?>
			  </td>
			  <td><div><a href="<?php echo base_url("superadmin/meta_tag/meta_addUpdate/".$post['id']) ?>">Update</a></div><div><a href="<?php echo base_url("superadmin/meta_tag/meta_tagDelete/".$post["id"]) ?>" onclick="return confirm('Are you sure you want to delete this item?');" >Delete</a></div></td>
			  </tr>
			  
			  
				  <?php endforeach; } else{ ?>
				  <tr>
			  <td colspan="5">No Data Found</td>
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
  

<!-- common footer include -->
<?php $this->load->view('superadmin/common_footer');?>


<script>
$(document).ready(function () {
   
        var table;
        table = $('#ajax_datatable_meta').DataTable({
               "processing": true, //Feature control the processing indicator.
               /* "serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?= base_url('superadmin/meta_tag/ajax_list')?>",
                  "type": "POST",
                  "data" : function(data)
                  {
                     // data.searchDate = $('#fromDate').val();
					  //data.searchToDate = $('#toDate').val();
                  }
              },
              //Set column definition initialisation properties.
             "columnDefs": [
              {
                "targets": [0], //last column
                "orderable": false, //set not orderable
              },
              ],*/
         });
        
 
});

 function refreshPage()
  {
    window.location.reload();
  }
</script>



<script>
//$(document).ready(function () {
	// $('.change_status').change(function(){
		function change_status(selected_id){
        //alert('hello'); 
	    var selected_data = $('.change_status').val();		
		// var data1 = $('#change_status').data();
		//alert(selected_data);
    $.ajax({
         url: "<?= base_url(); ?>superadmin/home/change_status",
         method: "POST",
         data: {selected_data:selected_data, selected_id:selected_id},
		dataType: "json", 
         success: function(data){
			//alert(data);
			
			 if(data == 200){
              // $('#success_msg').html('Status Successfully Updated');
			   alert('Status Successfully Updated');
			 }else{
			    alert('Some Error Occure');
			 }
         }
        });
        };
       
        //});
 
</script>
