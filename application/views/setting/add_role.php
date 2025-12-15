<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->  
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Role</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Role</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
	<div class="add_role_form">
		<div class="container-fluid">
			<form action="<?php echo base_url("roles/add_roleDetails"); ?>" method="post">
				<div class="row m-0">
					<div class="col-sm-2 form-group">
						<label>Role Name*</label>
					</div>
					<div class="col-sm-4 form-group">
						<input type="text" placeholder=" Enter role name" name="role_name" id="role_name" class="form-control">
					</div>
					<div class="col-sm-6"></div>
				</div>
				<div class="row m-0">
					<div class="col-sm-2 form-group">
						<label>Reports To</label>
					</div>
					<div class="col-sm-4 form-group">
						<!--<input type="text" placeholder="" value="Software" readonly class="form-control">-->
						<select class="form-control" name="parent_role">
							<option>Select parent role</option>
							<option value="0">parent role</option>
							<?php foreach($roles as $role) { ?>
							<option value="<?=$role['id'] ?>" ><?=$role['role_name'] ?></option>
							<?php } ?>
							<!--<option>Marketing Manager</option>
							<option>VP Of Customer Services</option>
							<option>IT Consultant</option>-->
						</select>
					</div>
					<div class="col-sm-6"></div>
				</div>
				<!--<div class="row m-0">
					<div class="col-sm-2 form-group">
						<label>License Type</label>
					</div>
					<div class="col-sm-4 form-group">
						<input type="text" placeholder="" value="Software" readonly class="form-control">
						<select class="form-control">
							<option>Select license type</option>
							<option>Standard1</option>
							<option>Standard2</option>
							
						</select>
					</div>
					<div class="col-sm-6"></div>
				</div>-->
				
				    <div class="col-sm-8 form-group text-center">
				        <button class="btn btn-info" type="submit">Save</button>
				    </div>
				
			</form>
		</div>
	</div>
</div>			
<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<!-- common footer include -->