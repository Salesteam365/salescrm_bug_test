<?php $this->load->view('common_navbar');
?>
<style type="text/css">
	.achieved_red {
		color: #e85f7c !important;
	}

	.achieved_orange {
		color: orange !important;
	}

	.achieved_green {
		color: green !important;
	}

	select#date_filter {
		width: 350px;
	}

	button {
		color: #fff;
		background-color: #fdfdfd;
		border-color: #717575;
		height: 40px;
	}

	.content-header {
		background: #f2f2f2;
	}

	.ModalRight {
		right: 0;
		position: fixed;
		margin: auto;
		width: 100%;
		height: 100%;
	}

	.Modalht100 {
		height: 100%;
		overflow-y: auto;
	}

	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		-webkit-transform: translate3d(0%, 0, 0);
		-ms-transform: translate3d(0%, 0, 0);
		-o-transform: translate3d(0%, 0, 0);
		transform: translate3d(0%, 0, 0);
	}





	/*Right*/
	.modal.right.fade .modal-dialog {
		-webkit-transition: opacity 0.5s linear, right 0.5s ease-out;
		-moz-transition: opacity 0.5s linear, right 0.5s ease-out;
		-o-transition: opacity 0.5s linear, right 0.5s ease-out;
		transition: opacity 0.5s linear, right 0.5s ease-out;
	}

	.modal.right.fade.in .modal-dialog {
		right: 0;
	}
	
	#emailModel > div{
        margin-top: 35px;
    }
	#org_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#org_datatable tbody tr td {
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

  
    
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);overflow-x:clip;">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-4">
					<h1 class="m-0 text-dark">Email Automation</h1>
				</div>
				<div class="col-sm-4"></div>
				<div class="col-sm-4"></div>
				<div class="col-sm-12">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo base_url() . "home"; ?>#">Home</a></li>
						<li class="breadcrumb-item active">Email Automation</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
	
			<div class="container-fliud filterbtncon"  >
			<?php 
                                //    $fifteen = strtotime("-15 Day"); 
                                //    $thirty = strtotime("-30 Day"); 
                                //    $fortyfive = strtotime("-45 Day"); 
                                //    $sixty = strtotime("-60 Day"); 
                                //    $ninty = strtotime("-90 Day"); 
                                //    $six_month = strtotime("-180 Day"); 
                                //    $one_year = strtotime("-365 Day");
                            ?>
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

   <div class="col-lg-2">
               <!-- <?php if($this->session->userdata('type')==='admin'){ ?> -->
                <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
               <input type="hidden" id="cust_type" value="" name="cust_type">
               <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <!-- <select class="custom-select" name="user_filter" id="user_filter"> -->
                     <option selected  value="">Select Customer Type</option>
                     <?php foreach ($custype as $orgrow) {
									if ($orgrow['customer_type'] != "") { ?>
              <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= $orgrow['customer_type']; ?>','cust_type');"><?= $orgrow['customer_type']; ?></li>
            <?php } }?>
            
            </ul>
            </div>
        <?php } ?>
      </div>

						<!-- <div class="col-lg-2">
							<select class="custom-select" name="cust_type" id="cust_type">
								<option selected value="">Select Customer Type</option>
								<?php foreach ($custype as $orgrow) {
									if ($orgrow['customer_type'] != "") { ?>
										<option value="<?= $orgrow['customer_type']; ?>"><?= $orgrow['customer_type']; ?></option>
								<?php }
								} ?>
								<option value="Other">Other</option>
							</select>
						</div> -->
						<div class="col-lg-2"></div>
						<div class="col-sm-6  text-right">
							<div class="refresh_button float-right">
								<a href='<?= base_url() ?>Email_Marketing/email_export_csv' class="p-0"><button class="btn btnstopcorner" style="color:grey;">Export</button></a>
								<button class="btn btnstopcorn" id="SendEmailBulk">Send Email In Bulk</button>
								<button class="btn btncorner" id="SendEmailWithCSV">Send Email From CSV File</button>
								<button class="btn btnstop" id="SendEmailWithTemplate">Email using template</button>
								<!--<a href="<?= base_url(); ?>csv-mail" class="p-0">
                         <button class="btn  btn-info p-0" >Send Email From CSV File</button></a>-->
							</div>
						</div>
					</div>
							</div>
					<div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Email Automation</b>
			 <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
					</div>
            <div class="card-body">
					<table id="org_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><input type="checkbox" class="checkSingle" id="checkAll" value="allmail">
								</th>
								<th class="th-sm">Name</th>
								<th class="th-sm">Email</th>
								<th class="th-sm">Mobile</th>
								<th class="th-sm">Organization Name</th>
								<th class="th-sm" id="count">Action
								</th>
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

	<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog modal-lg ModalRight">
			<div class="modal-content Modalht100">
				<div class="modal-header text-center">
					<h4 class="modal-title">Email Automation</h4>
					<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" style="padding: 5%;">
					<form method="post" action="" id="email_auto_form" enctype="multipart/form-data">
						<div class="row" id="formDiv">
							<div class="col-md-2 lbl">
								<label for="">Client's Name:</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control onlyLetters" name="clientname" value="" id="clientname">
							</div>
							<div class="col-md-2 lbl">
								<label for="">Client's Email:</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control" name="clientEmail" id="clientEmail" value="">
							</div>
							<div class="col-md-2 lbl">
								<label for="">CC:</label>
							</div>
							<div class="col-md-10">
								<?php
								$session_comp_email = $this->session->userdata('company_email'); ?>
								<input type="text" class="form-control" name="ccEmail" id="ccEmail" value="<?= $session_comp_email; ?>">
							</div>
							<div class="col-md-2 lbl">
								<label for="">Subject:</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control" name="subEmail" id="subEmail">
							</div>
							<div class="col-md-12 lbl">
								<label for="">Message*:</label>
							</div>
							<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
							</div>
							<div class="col-md-12">
								<textarea class="form-control" id="descriptionTxt" name="descriptionTxt"></textarea>
							</div>
							<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
							</div>
							<div class="col-md-12 lbl">
								<label for="">Image:</label>
							</div>
							<div class="col-md-12">
								<input type="file" name="images" id="images">
							</div>
						</div>
						<div class="row text-center" id="messageDiv" style="display:none; padding: 5%; ">
						</div>
						<div class="row" id="footerDiv">
							<div class="col-md-7" style="padding-top: 5%;"> </div>
							<div class="col-md-5 text-right" style="padding-top: 5%;">
								<button type="button" class="btn btn-info" id="sendEmail">Send Email</button>
							</div>
						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
	<!-- /.content -->
</div>
<!-- common footer include -->

<!-- The Modal -->
<div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg ModalRight">
		<div class="modal-content Modalht100">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Multiple Checkbox Mail</h4>
				<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form method="post" id="multi_email_auto" enctype="multipart/form-data">
					<div id="formDivsmult">
						<div class="row form-group" id="formDivsmult">
							<div class="col-md-2">
								<label>Subject</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control" name="multi_subject" id="multi_subject" placeholder="Subject">
								<input type="hidden" name="all_email" id="all_email" value="">
								<input type="hidden" name="all_un_email" id="all_un_email" value="">
								<input type="hidden" name="customerType" id="customerType">

							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-2">
								<label>Message</label>
							</div>
							<div class="col-md-10">
								<textarea class="form-control" name="multi_description" id="multi_description"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12">
								<label>Place image here</label>
							</div>
							<div class="col-md-12">
								<input type="file" name="multi_image" id="multi_image">
								<input type="hidden" class="blah" name="blah" id="blah">
							</div>
						</div>
					</div>
					<div class="row text-center" id="messageDivs" style="display:none; padding: 5%; "></div>
				</form>
			</div>


			<!-- Modal footer -->
			<div class="modal-footer" id="footerDivs">
				<button class="btn btn-info" id="preview_Email">Preview</button>
				<button type="submit" class="btn btn-info" id="all_sendEmail">Save</button>
			</div>

			<div class="modal-body" style="display:none;" id="putPreviewEmail">
				<div style="text-align: right; border-top: 1px solid #d4d0d0d1;"><button type="button" id="clsPreview" class="close text-right">×</button></div>
				<iframe style="width: 100%; height: 450px; border: 0px;"></iframe>
			</div>

		</div>
	</div>
</div>

<style>
	.upload-btn-wrapper {
		position: relative;
		overflow: hidden;
		display: inline-block;
	}

	.btnCls {
		border: 1px solid #f7f7f7;
		background: #f7f7f7;
		padding: 8px;
		background: #1892cd;
		color: #fff;
	}

	.upload-btn-wrapper input[type=file] {
		position: absolute;
		left: 0;
		top: 0;
		opacity: 0;
	}
</style>
<!-- The Modal -->
<div class="modal fade" id="sendMailFromCSV">
	<div class="modal-dialog modal-lg ModalRight">
		<div class="modal-content Modalht100">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Send Email From Your CSV File</h4>
				<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form method="post" id="import_form" enctype="multipart/form-data">
					<div id="formDivsmult">

						<div class="row form-group">
							<div class="col-md-12" style="font-size: 12px;">
								<label class="m-0"><b>Note:- </b></label>
								Please note, we only accept valid CSV files that contain a header, that is the column names for the data to be imported.<br>
								We also have a limit on the file size you are allowed to upload, that is 15MB.<br>
								The import process might fail with some of the files, mainly because these are not correctly formatted or they contain invalid data.<br>
								You should first do a test import(in a test list) and see if that goes as planned then do it for your actual list.<br>
								<strong>Important:</strong> The CSV file column names will be used to create the list TAGS, if a tag does not exist, it will be created.<br>
								You can also <a href="<?= base_url(); ?>assets/excel/example-csv-import.csv"> click </a>here to see a csv file example.
							</div>

						</div>

						<div class="row form-group">
							<div class="col-md-2">
								<label>Upload CSV</label>
							</div>
							<div class="col-md-5">
								<div class="upload-btn-wrapper">
									<button class="btnCls">Upload a csv file</button>
									<input type="file" class="checkvl" onchange="fileSelect(this)" accept=".csv" name="csvfile" id="csvfile" />
								</div>
								<div id="msgForFile" style="display:none;">
									Uploaded File : <span id="uploadedFile"></span>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-center">
								<a href="<?= base_url(); ?>assets/excel/example-csv-import.csv" class="link-success">Download CSV File Formate</a>

							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-2">
								<label>Subject</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control checkvl" name="csv_subject" id="csv_subject" placeholder="Subject">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-2">
								<label>Message</label>
							</div>
							<div class="col-md-10">
								<textarea class="form-control" name="csv_description" id="csv_description"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-2">
								<label>Place image here</label>
							</div>
							<div class="col-md-10">
								<!--<input type="file" name="multi_image"  id="multi_image">-->
								<input type="hidden" class="blah" name="blah" id="blah">
								<div class="upload-btn-wrapper">
									<button class="btnCls">Select Image</button>
									<input type="file" name="scv_image" id="scv_image" onchange="imageSelect(this)" />

								</div>
								<div id="msgForFileImg" style="display:none;">
									Uploaded File : <span id="uploadedFileImg"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="row text-center" id="messageDivs" style="display:none; padding: 5%; "></div>
				</form>
			</div>


			<!-- Modal footer -->
			<div class="modal-footer" id="footerDivs">
				<button class="btn btn-secondary rounded-0" id="preview_Email_csv">Preview</button>
				<button type="submit" class="btn btn-info" id="csv_sendEmail">Send Email</button>
				<button type="submit" class="btn btn-secondary rounded-0" id="csv_sendEmail_msg" style="display:none;">Sending Mail...</button>
			</div>

			<div class="modal-body" style="display:none;" id="csvPutPreviewEmail">
				<div style="text-align: right; border-top: 1px solid #d4d0d0d1;">
					<button type="button" id="clsPreviewcsv" class="close text-right">×</button>
				</div>
				<iframe style="width: 100%; height: 450px; border: 0px;"></iframe>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="sendMailFromZipFile">
	<div class="modal-dialog modal-lg ModalRight">
		<div class="modal-content Modalht100">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Send Email From Your CSV File</h4>
				<button type="button" class="close text-right" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<form method="post" id="import_form_zip" enctype="multipart/form-data">
					<div id="formDivsmult">

						<div class="row form-group">
							<div class="col-md-12" style="font-size: 12px;">
								<label class="m-0"><b>Note:- </b></label>
								Please note, we only accept valid CSV files that contain a header, that is the column names for the data to be imported.<br>
								We also have a limit on the file size you are allowed to upload, that is 15MB.<br>
								The import process might fail with some of the files, mainly because these are not correctly formatted or they contain invalid data.<br>

								<strong>Important:</strong> The CSV file column names will be used to create the list TAGS, if a tag does not exist, it will be created.<br>
								You can also <a href="<?= base_url(); ?>assets/excel/example-csv-email.csv"> click </a>here to see a csv file example.
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-2">
								<label>Subject</label>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control checkvl" name="csv_subject" id="csv_subject" placeholder="Subject">
							</div>
						</div>

						<div class="row form-group">
							<div class="col-md-2">
								<label>Upload CSV</label>
							</div>
							<div class="col-md-5">
								<div class="upload-btn-wrapper">
									<button class="btnCls">Upload a csv file</button>
									<input type="file" class="checkvl" onchange="fileSelect(this)" accept=".csv" name="csvfileEmailzip" id="csvfileEmailzip" />
								</div>
								<div id="msgZipForFile" style="display:none;">
									Uploaded File : <span id="uploadedZipFile"></span>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-center">
								<a href="<?= base_url(); ?>assets/excel/example-csv-email.csv" class="link-success">Download CSV File Formate</a>

							</div>
						</div>


						<div class="row form-group">
							<div class="col-md-2">
								<label>Place zip file here</label>
							</div>
							<div class="col-md-10">
								<!--<input type="file" name="multi_image"  id="multi_image">-->
								<input type="hidden" class="blah" name="blah" id="blah">
								<div class="upload-btn-wrapper">
									<button class="btnCls">Select Template In Zip</button>
									<input type="file" name="scv_image_zip" id="scv_image_zip" accept=".zip" onchange="imageSelect(this)" />
								</div>
								<div id="msgForFileImg" style="display:none;">
									Uploaded File : <span id="uploadedFileImg"></span>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>


			<!-- Modal footer -->
			<div class="modal-footer" id="footerDivszip">
				<!--<button  class="btn btn-secondary rounded-0" id="preview_Email_zip">Preview</button>-->
				<button type="submit" class="btn btn-info" id="zip_sendEmail">Send Email</button>
				<button type="submit" class="btn btn-secondary rounded-0" id="zip_sendEmail_msg" style="display:none;"> <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Uploading File...</button>
			</div>

			<div class="modal-body" style="display:none;" id="zipPutPreviewEmail">
				<div style="text-align: right; border-top: 1px solid #d4d0d0d1;">
					<button type="button" id="clsPreviewcsvzip" class="close text-right">×</button>
				</div>
				<iframe style="width: 100%; height: 450px; border: 0px;"></iframe>
			</div>

		</div>
	</div>
</div>

<?php $this->load->view('common_footer'); ?>

<script>
	var editor = CKEDITOR.replace('descriptionTxt');
	var multi_editor = CKEDITOR.replace('multi_description');
	var csv_editor = CKEDITOR.replace('csv_description');
	CKEDITOR.config.height = '250px';
</script>

<script>
	$("#SendEmailWithTemplate").click(function() {
		$("#sendMailFromZipFile").modal("show");
	});

	$("#zip_sendEmail").click(function() {
		var csvfile = $("#csvfileEmailzip").val();
		if (csvfile != "") {
			var csvFilesize = $("#csvfileEmailzip")[0].files[0].size;
		} else {
			var csvFilesize = 0;
		}

		var zipFile = $("#scv_image_zip").val();
		if (zipFile != "") {
			var zipFilesize = $("#scv_image_zip")[0].files[0].size;
		} else {
			var zipFilesize = 0;
		}

		//15728640
		if (csvfile == "" || csvfile === undefined) {
			toastr.error('Please upload csv file');
		} else if (csvFilesize > 15728640) {
			toastr.error('Your csv file size is larger than 15MB');
		} else if (zipFile == "" || zipFile === undefined) {
			toastr.error('Please upload template file in zip');
		} else if (zipFilesize > 15728640) {
			toastr.error('Your zip file size is larger than 15MB');
		} else if (checkValidationWithClass('import_form_zip') == 1) {
			$("#zip_sendEmail").hide();
			$("#zip_sendEmail_msg").show();
			toastr.info('Please wait while we are processing your request.');
			$.ajax({
				url: "<?php echo base_url(); ?>Email_Marketing/file_upload",
				method: "POST",
				data: new FormData($('#import_form_zip')[0]),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function(response) {
					//console.log(response);
					if (response.status) {
						toastr.success('File uploaded successfully');
						$("#zip_sendEmail").show();
						$("#zip_sendEmail_msg").hide();
						$("#sendMailFromZipFile").modal("hide");
					} else {
						toastr.error('Mail has not been sent due to unknown reason.');
					}
				}
			})
		}
	});


	function fileSelect(input) {
		var fileName = input.files[0].name;
		$("#msgForFile").show();
		$("#uploadedFile").html(fileName);
	}

	function imageSelect(input) {
		var fileName = input.files[0].name;
		$("#msgForFileImg").show();
		$("#uploadedFileImg").html(fileName);
	}




	$("#csv_sendEmail").click(function() {
		var csvfile = $("#csvfile").val();

		if (csvfile != "") {
			var csvFilesize = $("#csvfile")[0].files[0].size;
		} else {
			var csvFilesize = 0;
		}

		//15728640
		if (csvfile == "" || csvfile === undefined) {
			toastr.error('Please upload csv file');

		} else if (csvFilesize > 15728640) {
			toastr.error('Your file size is larger than 15MB');
		} else if (checkValidationWithClass('import_form') == 1) {
			$("#csv_sendEmail").hide();
			$("#csv_sendEmail_msg").show();
			toastr.info('Please wait while we are processing your request.');
			var descriptionTxtCsv = CKEDITOR.instances["csv_description"].getData();
			$("#csv_description").val(descriptionTxtCsv);
			$.ajax({
				url: "<?php echo base_url(); ?>Email_Marketing/mail_using_csv",
				method: "POST",
				data: new FormData($('#import_form')[0]),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function(response) {
					if (response.status) {
						toastr.success('All mail has been sent successfully');
						$("#csv_sendEmail").show();
						$("#csv_sendEmail_msg").hide();
						$("#sendMailFromCSV").modal("hide");
					} else {
						toastr.error('Mail has not been sent due to unknown reason.');
					}
				}
			})
		}
	});
	$("#SendEmailWithCSV").click(function() {
		$("#sendMailFromCSV").modal("show");
	});
	$("#clsPreviewcsv").click(function() {
		$("#csvPutPreviewEmail").hide();
	});

	$("#preview_Email_csv").click(function(e) {
		var csv_description = CKEDITOR.instances["csv_description"].getData();
		$("#csv_description").val(csv_description);
		var form = $("#import_form").get(0);
		var formData = new FormData(form);
		$.ajax({
			url: "<?= site_url(); ?>Email_Marketing/preview_email",
			method: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(result) {
				$("#csvPutPreviewEmail").show();
				var iframe = $("#csvPutPreviewEmail").find('iframe');
				var context = iframe[0].contentDocument.write(result);
				iframe[0].contentWindow.document.close();
			}
		});
	});
</script>
<script>
	$(document).ready(function() {
		<?php if ($this->session->userdata('retrieve_org') == '1') : ?>
			var table;
			table = $('#org_datatable').DataTable({
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": "<?= base_url('Email_Marketing/ajax_list') ?>",
					"type": "POST",
					"data": function(data) {
						data.searchDate = $('#date_filter').val();
						data.cust_types = $('#cust_type').val();

						if ($("#checkAll").prop('checked') == true) {
							data.checkall = 'checkedall';
						} else {
							data.checkall = 'not';
						}
					}
				},
				//Set column definition initialisation properties.
				"columnDefs": [{
					"targets": [0], //last column
					"orderable": false, //set not orderable
				}, ],
			});
			$('#date_filter,#cust_type').change(function() {
				table.ajax.reload();
			});
		<?php endif; ?>
	});

	$('#checkAll').click(function() {
		$(':checkbox.select_checkbox').prop('checked', this.checked);
	});





	$('#emailModel').change(function() {
		var opval = $(this).val();
		if (opval == "SendMessage") {
			$('#emailModel').modal("show");
		}
	});


	function email_auto(userid) {
		// alert(userid);
		$.ajax({
			url: "<?php echo base_url('Email_Marketing/getbyId/') ?>/" + userid,
			method: "POST",
			dataType: "JSON",
			success: function(data) {
				//console.log(data);
				$('[id="userid"]').val(data.id);
				$('[id="clientname"]').val(data.primary_contact);
				$('[id="clientEmail"]').val(data.email);
				$('#emailModel').modal('show'); // show modal 
				$('.modal-title').text('Email Automation'); // Set title to Bootstrap modal title		 
			}
		});
	}
</script>

<!--Single send email-->
<script>
	$("#sendEmail").click(function() {
		var clientname = $("#clientname").val();
		var clientEmail = $("#clientEmail").val();
		var ccEmail = $("#ccEmail").val();
		var subEmail = $("#subEmail").val();

		$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
		var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
		$("#descriptionTxt").val(descriptionTxt);
		var images = $("#images").val();
		var form = $("#email_auto_form").get(0);
		var formData = new FormData(form);

		$("#sendEmail").attr('disabled', true);
		$.ajax({
			url: "<?= site_url(); ?>Email_Marketing/send_email",
			method: "POST",
			data: formData,
			dataType: "JSON",
			processData: false,
			contentType: false,
			cache: false,
			success: function(dataSucc) {
				if (dataSucc.status == 1) {
					$("#formDiv").hide();
					$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email has been sent successfully.');
					$("#messageDiv").css('display', 'block');
					$("#sendEmail").html('Send Email');
					setTimeout(function() {
						$('#emailModel').modal('hide');
						$("#messageDiv").hide();
						$("#formDiv").show();
						$("#sendEmail").attr('disabled', false);
					}, 4000)

				} else if (dataSucc.status == 2) {
					mess = (dataSucc.msg) ? dataSucc.msg : 'something went wrong.';
					$("#formDiv, #footerDivs").hide();
					$("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>' + mess);
					$("#messageDiv").css('display', 'block');
					$("#sendEmail").html('Send Email');
					$("#sendEmail").attr('disabled', false);
					setTimeout(function() {
						$("#messageDiv").hide();
						$("#formDiv, #footerDiv").show();
					}, 4000)
				}
			}
		});
	});
</script>
<script>
	var emailOrgno = [];
	var emailOrg = [];

	function checkEmail(ckid) {
		if ($("#checkAll").prop('checked') == true) {
			if ($("#ck" + ckid).prop('checked') == false) {
				$("input[id='ck" + ckid + "']:not(:checked)").each(function() {
					emailOrgno.push($(this).val());
				});
			} else {
				$("input[id='ck" + ckid + "']:checked").each(function() {
					emailOrgno.splice($.inArray($(this).val(), emailOrgno), 1);
				});
			}

		} else {
			if ($("#ck" + ckid).prop('checked') == true) {
				$("input[id='ck" + ckid + "']:checked").each(function() {
					emailOrg.push($(this).val());
				});
			} else {
				$("input[id='ck" + ckid + "']:not(:checked)").each(function() {
					emailOrg.splice($.inArray($(this).val(), emailOrg), 1);
				});
			}

		}
	}


	$("#SendEmailBulk").click(function() {
		var custType = $('#cust_type').val();
		$("#customerType").val(custType);
		if ($("#checkAll").prop('checked') == true) {
			emailOrg = 'allemail';
			if (emailOrgno !== undefined) {
				emailOrgno.toString();
			}
		} else {
			if (emailOrg !== undefined) {
				emailOrg.toString();
			}
			var emailOrgno = 'selectedmail'
		}
		$("#all_un_email").val(emailOrgno);
		$("#all_email").val(emailOrg);

		if ($("#checkAll").prop('checked') == true || emailOrg.length > 0) {
			$("#myModal").modal("show");
		} else {
			$('#putMsg').html('Please select at least a checkbox.');
			$("#alert_error").modal('show');
			setTimeout(function() {
				$("#alert_error").modal('hide');
			}, 2500);
		}
	});

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('.blah').val(e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#multi_image,#scv_image").change(function() {
		readURL(this);
	});


	$("#clsPreview").click(function() {
		$("#putPreviewEmail").hide();
	});

	$("#preview_Email").click(function(e) {
		var multi_description = CKEDITOR.instances["multi_description"].getData();
		$("#multi_description").val(multi_description);
		var form = $("#multi_email_auto").get(0);
		var formData = new FormData(form);
		$.ajax({
			url: "<?= site_url(); ?>Email_Marketing/preview_email",
			method: "POST",
			data: formData,
			processData: false,
			contentType: false,
			success: function(result) {
				$("#putPreviewEmail").show();
				var iframe = $("#putPreviewEmail").find('iframe');
				var context = iframe[0].contentDocument.write(result);
				iframe[0].contentWindow.document.close();
			}
		});
	});

	$("#all_sendEmail").click(function(e) {
		e.preventDefault();
		var multi_subject = $("#multi_subject").val();
		//	var checkAll          = $("#checkAll").val();
		//	var all_email         = $("#all_email").val(checkAll);
		$("#all_sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
		var multi_description = CKEDITOR.instances["multi_description"].getData();
		$("#multi_description").val(multi_description);
		var multi_image = $("#multi_image").val();
		if (multi_subject != "") {
			$("#all_sendEmail").attr('disabled', true);

			if ($("#checkAll").prop('checked') == false) {
				var emailOrg = [];
				var emailOrgno = [];
				$("input[name='emailid[]']:checked").each(function() {
					emailOrg.push($(this).val());
				});
				emailOrg.toString();
			} else {
				var emailOrg = 'allemail';
			}
			var form = $("#multi_email_auto").get(0);
			var formData = new FormData(form);
			$.ajax({
				url: "<?= site_url(); ?>Email_Marketing/all_email_send",
				method: "POST",
				data: formData,
				dataType: "JSON",
				processData: false,
				contentType: false,
				success: function(dataSucc) {
					if (dataSucc.status == 1) {
						$("#formDivsmult").hide();
						$("#messageDivs").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email has been sent  successfully.');
						$("#messageDivs").css('display', 'block');
						$("#all_sendEmail").html('Send Email');
						setTimeout(function() {
							$("#messageDivs").hide();
							$("#formDivsmult").show();
							$('#myModal').modal('hide');
							$("#all_sendEmail").attr('disabled', false);
						}, 4000)

					} else if (dataSucc.status == 2) {
						$("#formDivsmult").hide();
						$("#messageDivs").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
						$("#messageDivs").css('display', 'block');
						$("#all_sendEmail").html('Send Email');
						setTimeout(function() {
							$("#messageDivs").hide();
							$("#formDivsmult").show();
							$('#myModal').modal('hide');
							$("#all_sendEmail").attr('disabled', false);
						}, 4000)
					}
				}
			});
		}
	});
	function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
</script>