<?php $this->load->view('common_navbar'); ?>
<style>
	.lbl {
		padding-top: 12px;
	}
</style>

<div class="content-wrapper" style="min-height: 191px;">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Access Permission Denied</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>home">Home</a></li>
						<li class="breadcrumb-item active">Access Permision</li>
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
			<div class="card org_div">
				<!-- /.card-header -->
				<div class="card-body">
					<?php if ($this->session->userdata('type') === 'standard') { ?>
						<div class="row text-center" id="permissionDiv">
							<div class="col-md-2 mt-4">
							</div>
							<div class="col-md-8 mt-4">
								<img src="https://img.icons8.com/cute-clipart/100/000000/restriction-shield.png" style="display: block;   margin: 0 auto; margin-bottom: 12px;" />
								You are not permitted to access this action by your Organiazation/Admin
							</div>

							<div class="col-md-12 mt-4">
								<button class="btn btn-info" id="requestAcc">Request to Access</button>
							</div>

						</div>

						<form action="#" id="form" class="form-horizontal" style="display:none;">
							<div class="row" id="formDiv">
								<div class="col-md-12 lbl text-right">
									<i class="far fa-times-circle" style="font-size:20px;color: #f44336;" id="hideDive"></i>
								</div>

								<div class="col-md-1 lbl"></div>
								<div class="col-md-2 lbl mt-4">
									<label for="">Organiazation Name:</label>
								</div>
								<div class="col-md-8 mt-4">
									<input type="text" class="form-control" name="orgName" id="orgName" value="<?= $this->session->userdata('company_name'); ?>">
								</div>

								<div class="col-md-1 lbl"></div>
								<div class="col-md-1 lbl"></div>
								<div class="col-md-2 lbl mt-4">
									<label for="">Organiazation Email:</label>
								</div>
								<div class="col-md-8 mt-4">
									<input type="text" class="form-control" name="orgEmail" id="orgEmail" value="<?= $this->session->userdata('company_email'); ?>">
								</div>
								<div class="col-md-1 lbl"></div>
								<div class="col-md-1 lbl"></div>
								<div class="col-md-2 lbl mt-4">
									<label for="">CC:</label>
								</div>
								<div class="col-md-8 mt-4">
									<input type="text" class="form-control" name="ccEmail" id="ccEmail" value="<?= $this->session->userdata('email') ?>">
								</div>
								<div class="col-md-1 lbl"></div>

								<div class="col-md-1 lbl"></div>
								<div class="col-md-2 lbl mt-4">
									<label for="">Subject:</label>
								</div>
								<div class="col-md-8 mt-4">
									<input type="text" class="form-control" name="subEmail" id="subEmail" value="request for acceess - ">
								</div>
								<div class="col-md-1 lbl"></div>
								<div class="col-md-1 lbl"></div>
								<div class="col-md-10 lbl mt-4">
									<label for="">Message*:</label>
								</div>
								<div class="col-md-1 lbl"></div>

								<div class="col-md-1 lbl"></div>
								<div class="col-md-10 mt-4">
									<textarea class="form-control" id="descriptionTxt" name="descriptionTxt">

						  </textarea>
								</div>
								<div class="col-md-1 lbl"></div>

								<div class="col-md-12 text-center lbl mt-4">
									<button class="btn btn-info" id="">Send Request</button>
								</div>

							</div>
							<div class="row text-center" id="messageDiv" style="display:none; padding: 5%; "></div>
						</form>
					<?php } else { ?>
						<div class="row text-center">
							Something went wrong, Plese Try later.
						</div>
					<?php } ?>

				</div>
			</div>
		</div>
	</section>
</div>



<?php $this->load->view('footer'); ?>
</div>
<!-- ./wrapper -->

<style>
	.bgclr {
		background: #066675;
	}
</style>

<!-- common footer include -->
<?php $this->load->view('common_footer'); ?>
<script>
	var editor = CKEDITOR.replace('descriptionTxt');
	CKEDITOR.config.height = '150px';
</script>
<script>
	$("#requestAcc").click(function() {
		$("#permissionDiv").hide(400);
		$("#form").show(400);
	})
	$("#hideDive").click(function() {
		$("#form").hide(400);
		$("#permissionDiv").show(400);

	})



	/****** VALIDATION FUNCTION*********/
	function changeClr(idinpt) {
		$('#' + idinpt).css('border-color', 'red');
		$('#' + idinpt).focus();
		setTimeout(function() {
			$('#' + idinpt).css('border-color', '');
		}, 3000);
	}

	function changeTxt() {
		setTimeout(function() {
			$("#msgDIv").html('');
		}, 3000);
	}


	function checkValidationVendor() {

		var oldpass = $('#oldpass').val();
		var newpass = $('#newpass').val();
		var connewpass = $('#connewpass').val();


		if (oldpass == "" || oldpass === undefined) {
			changeClr('oldpass');
			return false;
		} else if (newpass == "" || newpass === undefined) {
			changeClr('newpass');
			return false;
		} else if (newpass == "" || newpass === undefined) {
			changeClr('newpass');
			return false;
		} else if (newpass.length < 8 || newpass === undefined) {
			changeClr('newpass');
			$("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Password must be at least 8 characters');
			changeTxt();
			return false;
		} else if (newpass != connewpass) {
			changeClr('connewpass');
			$("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Must match the previous new password.');
			changeTxt();
			return false;
		} else {
			return true;
		}
	}

	$('.form-control').keypress(function() {
		$(this).css('border-color', '')
	});
	$('.form-control').change(function() {
		$(this).css('border-color', '')
	});



	function save() {
		if (checkValidationVendor() == true) {
			var url = "<?= base_url('Change_password/checkPass') ?>";
			$('#btnSave').text('Checking..');
			$('#btnSave').attr('disabled', true);
			$.ajax({
				url: url,
				type: "POST",
				data: $('#form').serialize(),
				dataType: "JSON",
				success: function(data) {
					if (data.status == true) {
						$('#btnSave').text('Updating...');
						$('#btnSave').attr('disabled', true);
						var url = "<?= base_url('Change_password/changePass') ?>";
						$.ajax({
							url: url,
							type: "POST",
							data: $('#form').serialize(),
							dataType: "JSON",
							success: function(data) {
								$("#msgDIv").html(data.status);
								changeTxt();
								$('#form')[0].reset();
								$('#btnSave').text('Update');
								$('#btnSave').attr('disabled', false);
							}
						});
					} else {
						$("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Your old password missmatch');
						changeTxt();
						$('#btnSave').text('Update');
						$('#btnSave').attr('disabled', false);
					}

				}
			});
		}
	}
</script>