<?php $this->load->view('superadmin/common_navbar'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Admin Details</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
	        <b>From Date</b>	  
            <input type="date" placeholder="From Date" value="" id="fromDate"></div>
	      <div class="col-lg-2">
	        <b>To Date</b>
	        <input type="date" placeholder="To Date" value="" id="toDate">
    <!--<button class="btn btn-info" id="date_filter" title="Search Attendance">Filter</button>-->

           <div class="first-one">
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
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-12">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
				 <button class="btn btn-info btn-sm"> <a href="<?php echo base_url('login'); ?>" style="color:white;"><b>User</b></a></button>
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
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
							<th class="th-sm">#</th>
							<th class="th-sm">Company NAme</th>
							<th class="th-sm">User Name</th>
                            <th class="th-sm">Website</th>
                            <th class="th-sm">Email</th> 
							<th class="th-sm">Mobile No.</th>
							<th class="th-sm">status</th>
							<th class="th-sm">Details</th>
                            
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$i=1;
					foreach($all_partner as $admin): ?>
					<tr>
					    <td><?php echo $i++; ?></td>
						<td><?php echo $admin['Company_name']; ?></td>
						<td><?php echo $admin['First_name'].' '.$admin['Last_name']; ?></td>
						<td><?php echo $admin['Official_website']; ?></td>
						<td><?php echo $admin['Email_first']; ?></td>
						<td><?php echo $admin['Mobile_no']; ?></td>
						<td>
						    <select class="form-control change_status" onchange="change_status('<?=$admin['id'];?>')" name="update_status"  >
                                <option value="1" <?php  if($admin['Status'] ==1 ) { echo 'selected'; } ?>>Active</option>
                                <option value="0" <?php  if($admin['Status'] ==0 ) { echo 'selected'; } ?>>Non-active</option>
                            </select>
				        </td>
					    <td><a href="<?php echo base_url().'superadmin/partner/partner_detail?ptr='.$admin['id'].'&org='.$admin['Company_name']; ?>">View</a></td>
					</tr>
					<?php endforeach; ?>
					
                    </tbody>
                </table>
              </div>
            </div>
      </div>
    </section>

  </div>

<?php $this->load->view('superadmin/common_footer');?>
<script>
$('#ajax_datatable').DataTable({});
</script>
