<?php $this->load->view('superadmin/common_navbar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">  
         <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">User Details</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
               <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/user_details'); ?>">Admin Details</a></li>
			   <li class="breadcrumb-item active">User Details</li>
              </ol>
          </div><!-- /.col -->
        </div><br><br><br>
 
 <div class="col-sm-12">
		  <!-- <div class="row mb-3">
            <div class="col-lg-2">
             <div class="first-one">
                <select class="form-control status_filter"  id="status_filters">
                  <option>Select Status</option>  
                  <option value = "1">Active</option>
                  <option value = "u">non-active</option>
                </select>
            </div>
           </div>
		  </div>
		  <div id="result"> </div>-->
		  <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
              <table id="data_tables1"  class="table table-striped table-bordered table-responsive-lg" cellspacing="0"  width="100%">
                <thead>
				<tr>
                  
                  <td width="15%"  class="th-sm"><b class="text-secondary">Standard Name:</b></td>
                  <td width="20%"  class="th-sm"><b class="text-secondary">Standard Email:</b></td>
				  <td width="20%"  class="th-sm"><b class="text-secondary">Company Email:</b></td>
                  <td width="15%"  class="th-sm"><b class="text-secondary">Standard Mobile:</b></td>
                  <td width="15%"  class="th-sm"><b class="text-secondary">Company Mobile:</b></td>
				  <!--<td width="15%"><b class="text-secondary">Status:</b></td>-->
                </tr>
				</thead>
				<tbody>
				<?php
				  //$ci =&get_instance();
                   //$ci->load->model('Login_model');
                  // $standared_users = $ci->Login_model->get_all_standarduser($admin['company_email'],$admin['company_name']);
                 if($standared_users){				  
				  foreach($standared_users as $all_user):
				?>
				
              <tr>
			  <td width="15%"><?=$all_user['standard_name'] ?></td>
			  <td width="20%"><?=$all_user['standard_email'] ?> </td>
			  <td width="20%"><?=$all_user['company_email'] ?></td>
			  <td width="15%"><?=$all_user['standard_mobile'] ?></td>
			  <td width="15%"><?=$all_user['company_mobile'] ?> </td>
			  <!--<td width="15%"><select class="form-control change_userstatus"  id="<?php echo $all_user['id']; ?>" >
                           <option value="1" <?php  if($all_user['status'] =='1' ) { echo 'selected'; } ?>>Active</option>
                           <option value="u" <?php  if($all_user['status'] =='0' ) { echo 'selected'; } ?>>Non-active</option>
                       </select>
			  </td>-->
			  </tr>
			  
			  
				  <?php endforeach; } else{ ?>
				  <tr>
			  <td colspan="5">No Data Found</td>
			  </tr>
				  <?php } ?>
				  
			  </tbody>
			  </table>
			     </table>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
            </div>
		</div>
     </div>
	
</div>
 
<?php $this->load->view('superadmin/common_footer');?>
<script>
$(document).ready(function () {
   
        var table;
        table = $('#data_tables1').DataTable({
               "processing": true, //Feature control the processing indicator.
              /*"serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.
               // // Load data for the table's content from an Ajax source
              "columnDefs": [
              {
                "targets": [0], //last column
                "orderable": false, //set not orderable
              },
              ],*/
         });
         
});
</script> 