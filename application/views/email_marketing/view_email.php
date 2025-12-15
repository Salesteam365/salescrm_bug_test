<?php $this->load->view('common_navbar');?>
<style>
.inner_details{
    color: #0c213a;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
		<?php foreach($emailOne as $users){?>
      
        <div class="row">
          <!-- Left col -->
          
          <section class="col-lg-12 connectedSortable">

            <div class="card bg-gradient-primary detail_section">
              <div class="card-tools ml-auto">
			  <?php if($this->session->userdata('type') == "admin"){
                    if($this->session->userdata('basic_lic_amnt') != "0" || $this->session->userdata('business_lic_amnt') != "0" || $this->session->userdata('enterprise_lic_amnt') != "0"){?>
                  <button type="button" class="btn bg-info btn-tool"  onclick="add_form()">
                    <i class="fas fa-user-plus"></i>
                  </button>
				<?php }
                 }?>
              </div>
              <h3 class="card-title">
               <i class="fas fa-info-circle"></i>
                Details
              </h3>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                    <div class="row">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
						   <h4>Name</h4>
						   <?= $users['client_name']?>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <h4>Company Name</h4>
                          NA
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
							<h4>Company Contact</h4>
							NA
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
						   <h4>Email</h4>
						   <?= $users['client_email']?>
                        </div>
                      </div>
                      </div>

                    <div class="row mt-3">
                      <div class="col-lg-12 col-6">
                        <div class="inner_details">
                          <h4>Subject</h4>
                          <?= $users['subject']?>
                        </div>
                      </div>
                      </div>

                    <div class="row mt-3">
                      <div class="col-lg-12 col-6">
                        <div class="inner_details">
                          <h4>Message</h4>
                          <?= $users['message']?>
                        </div>
                      </div>
                    </div>
                    <?php if($users['images']){ ?>
                    <div class="row mt-3">
                      <div class="col-lg-12 col-6">
                        <div class="inner_details">
                            <img src="<?=base_url();?>assets/email_file_img/<?=$users['images'];?>">
                        </div>
                      </div>
                    </div>
                    <?php } ?>
                     <div class="row mt-3">
                      <div class="col-lg-12 col-6">
                        <div class="inner_details">
                          <h4>Delivery Status</h4>
                          <?php if($users['read_status']==1){?>
                            <span class="badge badge-success">Mail Delivered</span>
                          <?php }else{ ?>
                            <span class="badge badge-danger">Pending</span>
                          <?php } ?>
                        </div>
                      </div>
                    </div>
                     <div class="row mt-3">
                      <div class="col-lg-12 col-6">
                        <div class="inner_details">
                          <h4>Date</h4>
                          <?php
                          $date=date_create($users['currentdate']);
                          echo date_format($date,"d M Y ,  H:i");?>
                        </div>
                      </div>
                    </div>
                    
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
		
		<!-- ADD USER DIV -->
       
		
		 <?php }?>
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

 

</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script src="<?php echo base_url()."assets/"; ?>js/jquery.signature.min.js" type="text/javascript"></script>
<script>
function add_form()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add User'); // Set Title to Bootstrap modal title
}
$("#btnSave").click(function(e)
{
   e.preventDefault();
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable
    $("#uploadsign_error").html('');
    var url ;
    
    if(save_method == 'add') {
        url = "<?= site_url('home/create')?>";
        formData = $('#form').serialize();
    } else {
        url = "<?= site_url('home/update_profile')?>";
       // var form=$("#edit_profile").get(0);
		//alert(form);
        //var formData = new FormData(form);
         var formData = new FormData($("#edit_profile")[0]);
    }
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        processData:false,
        contentType:false,
        cache:false,
        success: function(data)
        {
            console.log(data);
        
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          if(data.st=='error_fileupload') 
          {
			//	$("#businesslogo_error").html(data.error_business_logo);
				$("#uploadsign_error").html(data.error_uploadsignature);
				
				setTimeout(function(){
		          //  $("#businesslogo_error").fadeOut('fast');
					$("#uploadsign_error").fadeOut('fast');
					
			    },4000);
		  }
          if(data.st==202)
          {
            $("#name_error").html(data.name);
            $("#email_error").html(data.email);
            $("#company_contact_error").html(data.company_contact);
            $("#country_error").html(data.country);
            $("#state_error").html(data.state);
            $("#city_error").html(data.city);
            $("#address_error").html(data.address);
            $("#zipcode_error").html(data.zipcode);
          }
          else if(data.st==200)
          {
            $("#name_error").html('');
            $("#email_error").html('');
            $("#company_contact_error").html('');
            $("#country_error").html('');
            $("#state_error").html('');
            $("#city_error").html('');
            $("#address_error").html('');
            $("#zipcode_error").html('');

            $('#edit_form').modal('hide');
            setInterval('location.reload()', 1000);  
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
        }
    });
});
function save()
{
    $('#btnSave1').text('saving...'); //change button text
    $('#btnSave1').attr('disabled',true); //set button disable
    var url;
    var formData;
    if(save_method == 'add') {
        url = "<?= site_url('home/create')?>";
        formData = $('#form').serialize();
    } else {
        url = "<?= site_url('home/update_profile')?>";
        formData = $('#edit_profile').serialize();
    }
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: formData,
        dataType: "JSON",
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
              $('#modal_form').modal('hide');
              reload_table();
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          if(data.st==202)
          {
            $("#name_error").html(data.name);
            $("#email_error").html(data.email);
            $("#company_contact_error").html(data.company_contact);
            $("#country_error").html(data.country);
            $("#state_error").html(data.state);
            $("#city_error").html(data.city);
            $("#address_error").html(data.address);
            $("#zipcode_error").html(data.zipcode);
          }
          else if(data.st==200)
          {
            $("#name_error").html('');
            $("#email_error").html('');
            $("#company_contact_error").html('');
            $("#country_error").html('');
            $("#state_error").html('');
            $("#city_error").html('');
            $("#address_error").html('');
            $("#zipcode_error").html('');

            $('#edit_form').modal('hide');
            setInterval('location.reload()', 500);  
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
        }
    });
}
function edit_form()
{
    save_method = 'edit';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#edit_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Edit Profile'); // Set Title to Bootstrap modal title
}
function ValidateSize(file)
{
  var FileSize = file.files[0].size / 1024 / 1024; // in MB
  if (FileSize > 2)
  {
    alert('File is larger than 2MB');
    $(file).val(''); //for clearing with Jquery
  }
  else
  {

  }
}
</script>
<script type="text/javascript">
	//signature add
	var signature = $('#signature').signature({syncField: '#sigpad', syncFormat: 'PNG'});
	$("#preview_sign").hide();
	//alert(signature);
	$('#clear').click(function(e) {
	e.preventDefault();
	signature.signature('clear');
	$("#sigpad").val('');
	$("#preview_sign").attr('src','');
	$('#signature').show();
	$("#preview_sign").hide();
	});
    <?php if(isset($users['signature_img'])!=""){  ?>
       $("#preview_sign").show();
    <?php } ?>

 function readURL(input,preview_sign,signature='') {
	if (input.files && input.files[0]) {
        var reader = new FileReader();
            reader.onload = function (e) {
				$('#'+preview_sign).show();
				$('#'+signature).hide();
                $('#'+preview_sign).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
    }
  }
  

</script>