<?php $this->load->view('superadmin/common_navbar');?>

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
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
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
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-4 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->

            <!-- /.card -->  
        
         <!-- tables -->
            <div class="card direct-chat direct-chat-primary updated_info">
              <div class="card-tools ml-auto">
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="" data-toggle="modal" data-target="#edit_profile">
                    <i class="far fa-edit"></i>
                  </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?php if($this->session->userdata('types') == 'superadmin') { ?>
                  <img src="<?= base_url().'uploads/company_logo/'.$this->session->userdata('company_logo');?>" class="img-circle img-fluid" alt="User Image">
                <?php } else if($this->session->userdata('types') == 'standard') { ?>
                  <!-- <img src="<?= base_url().'uploads/profile_image/'.$this->session->userdata('user_image');?>" class="img-circle img-fluid" alt="User Image"> -->
                  <img src="<?= base_url().'uploads/profile_image/avatar2.png';?>" class="img-circle img-fluid" alt="User Image">
                <?php } ?>
                <div class="direct-chat-messages">
                  <h2><?= ucwords($this->session->userdata('superadmin_name')); ?></h2>
                  <p><i class="fas fa-map-marker-alt"></i> <?=ucfirst($this->session->userdata('superadmin_state')); ?>, <?= ucfirst($this->session->userdata('superadmin_country')); ?></p>
                  <h5><?= ucwords($this->session->userdata('supercompany_name')); ?></h5>
                  <h6><?= $this->session->userdata('supercompany_email'); ?></h6>
                </div>
              </div>
            </div>      
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-8 connectedSortable">

            <!-- Map card -->
            <div class="card bg-gradient-primary detail_section">
              <div class="card-tools ml-auto">
			   <?php if($this->session->userdata('types') == 'superadmin') { ?>
                  <button type="button" class="btn bg-info btn-tool" data-card-widget="" data-toggle="modal" data-target="#edit_user">
                    <i class="fas fa-user-plus"></i>
                  </button>
			   <?php } ?>
              </div>
              <h3 class="card-title">
               <i class="fas fa-info-circle"></i>
                Details
              </h3>
			  <?php //print_r($this->session->all_userdata()); ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                    <div class="row">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Name</label>
                          <h4><?= ucwords($this->session->userdata('superadmin_name')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Name</label>
                          <h4><?= ucwords($this->session->userdata('supercompany_name')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Contact</label>
                          <h4><?= $this->session->userdata('superadmin_mobile'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Email</label>
                          <h4><?= $this->session->userdata('supercompany_email'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Website</label>
                          <h4><?= $this->session->userdata('supercompany_website'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company GSTIN</label>
                          <h4><?= $this->session->userdata('supercompany_gstin'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Country</label>
                          <h4><?= ucfirst($this->session->userdata('superadmin_country')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">State</label>
                          <h4><?= $this->session->userdata('superadmin_state'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">City</label>
                          <h4><?= $this->session->userdata('superadmin_city'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Address</label>
                          <h4><?= $this->session->userdata('supercompany_address'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Zip Code</label>
                          <h4><?= $this->session->userdata('superadmin_zipcode'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">PAN</label>
                          <h4><?= $this->session->userdata('superpan_number'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">CIN</label>
                          <h4><?= $this->session->userdata('superadmin_cin'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Activation Date</label>
                          <h4><?= date('d-m-Y', strtotime($this->session->userdata('superlicense_activation_date'))); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Expiration Date</label>
                          <h4><?= date('d-m-Y', strtotime($this->session->userdata('superlicense_expiration_date'))); ?></h4>
                        </div>
                      </div>
                    </div>
                    <?php if($this->session->userdata('types') == 'superadmin') { ?>
                      <div class="row mt-3">
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Basic License Amount</label>
                            <h4><?= $this->session->userdata('superbasic_lic_amnt'); ?></h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Business License Amount</label>
                            <h4><?= $this->session->userdata('superbusiness_lic_amnt'); ?></h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Enterprise License Amount</label>
                            <h4><?= $this->session->userdata('superenterprise_lic_amnt'); ?></h4>
                          </div>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Active Basic License</label>
                            <h4>0</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Active Business License</label>
                            <h4>0</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Active Enterprise License</label>
                            <h4>7</h4>
                          </div>
                        </div>
                      </div>

                      <div class="row mt-3">
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Available Basic License</label>
                            <h4>5</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Available Business License</label>
                            <h4>5</h4>
                          </div>
                        </div>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Available Enterprise License</label>
                            <h4>2</h4>
                          </div>
                        </div>
                      </div>
                    <?php } ?>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Type</label>
                          <h4><?= $this->session->userdata('superlicense_type'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">

                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">

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
        <!-- /.row (main row) -->
        <?php if($this->session->userdata('types') == 'superadmin') { ?>
          <div class="row">
            <section class="col-lg-12 connectedSortable licence_table">
              <div class="card" style="max-height: 415px;overflow-y: scroll;">
                <div class="card-body">
                  <table class="table table-striped table-bordered table-responsive-lg">
                    <thead class="thead">
                      <tr>
                        <th>License Type</th>
                        <th>User Name</th>
                        <th>Email ID</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
					  if(!empty($users_data)) {
						  foreach($users_data as $users) { ?>
                        <tr>
                          <td><?= $users['license_type']; ?></td>
                          <td><?= $users['standard_name']; ?></td>
                          <td><?= $users['standard_email']; ?></td>
                        </tr>
                      <?php } } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        <?php } ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <!-- EDIT PROFILE MODAL -->
  <div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Edit Profile</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <form action="#" id="profile_edit" class="form-horizontal" enctype="multipart/form-data" method="post">
          <div class="form-body form-row">
            <div class="col-md-6 mb-3">
              <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Name" value="<?= $this->session->userdata('superadmin_name');?>">
            </div>
            <?php if($this->session->userdata('types') == 'superadmin') { ?>
              <div class="col-md-6 mb-3">
                <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" value="<?= $this->session->userdata('superadmin_email');?>">
                <span id="email_error"></span>
              </div>
            <?php } else if($this->session->userdata('types') == 'standard') { ?>
              <div class="col-md-6 mb-3">
                <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email" value="<?= $this->session->userdata('email');?>" readonly>
                <span id="email_error"></span>
              </div>
            <?php } ?>
            <?php if($this->session->userdata('types') == 'superadmin') { ?>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="company_contact" id="company_contact" placeholder="Company Contact" value="<?= $this->session->userdata('superadmin_mobile');?>">
                <span id="contact_error"></span>
              </div>
            <?php } else if($this->session->userdata('types') == 'standard') { ?>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="contact_number" id="contact_number" placeholder="Contact Number" value="<?= $this->session->userdata('mobile');?>">
                <span id="contact_error"></span>
              </div>
            <?php } ?>
            <?php if($this->session->userdata('types') == 'superadmin') { ?>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="country" id="country" placeholder="Country" value="<?= $this->session->userdata('superadmin_country');?>">
              </div>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="state" id="state" placeholder="State" value="<?= $this->session->userdata('superadmin_state');?>">
              </div>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="city" id="city" placeholder="City" value="<?= $this->session->userdata('superadmin_city');?>">
              </div>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="address" id="address" placeholder="Address" value="<?= $this->session->userdata('supercompany_address');?>">
              </div>
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="zipcode" id="zipcode" placeholder="Zipcode" value="<?= $this->session->userdata('superadmin_zipcode');?>">
              </div>
            <?php } ?>
            <?php if($this->session->userdata('types')=='superadmin') { ?>
              <div class="col-md-7 mb-3">
                <label>Upload Company logo
                <input type="file" onchange="ValidateSize(this)" name="company_logo" id="company_logo"></label>
              </div>
            <?php }  else if($this->session->userdata('types')=='standard') { ?>
              <div class="col-md-7 mb-3">
                <label>Upload Profile Image
                <input type="file" onchange="ValidateSize(this)" name="profile_image" id="profile_image"></label>
              </div>
            <?php } ?>
            <input type="hidden" name="id" id="id" value="<?= $this->session->userdata('superadmin_id'); ?>">
            <div class="col-md-5 mb-3">
              <button type="button" class="btn btn-info" id="update_profile">Update</button>
            </div>
          </div>

        </form>
        <span style="color: red; float: left;">**Note: To see updates you need to login again</span>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- EDIT PROFILE MODAL -->

<!-- ADD USER MODAL -->
  <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0">Add User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!--Body-->
      <div class="modal-body">
        <form action="#" id="add_user_form" class="form-horizontal" enctype="multipart/form-data" method="post" name="add_user_form">
          <div class="form-body form-row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" placeholder="First Name">
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" placeholder="Last Name">
                <span id="duplicate_name_error" style="color: red;float: left;font-size: 14px;"></span>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control form-control-sm" name="standard_email" id="standard_email" placeholder="Email">
                <span id="standard_email_error"></span>
            </div>
            <div class="col-md-6 mb-3">
                <input type="tel" class="form-control form-control-sm" name="standard_mobile" id="standard_mobile" placeholder="Mobile">
                <span id="standard_mobile_error"></span>
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control form-control-sm" id="first_password" placeholder="Password">
            </div>
            <div class="col-md-6 mb-3">
                <input type="password" class="form-control form-control-sm" name="standard_password" id="second_password" placeholder="Confirm Password" onkeyup="match_pass();return false;">
                <span id="match_pass_error" style="color: red;float: left;font-size: 14px;"></span>
            </div>
            <div class="col-md-6 mb-3">
                <select class="form-control form-control-sm" name="license_type">
                    <option>License Type</option>
                    <option value="Basic">Basic</option>
                    <option value="Business">Business</option>
                    <option value="Enterprise">Enterprise</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
              <button type="button" class="btn btn-info btn" onclick="save()" id="add_user_btn">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!-- ADD USER MODAL -->

  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>
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
  $("#update_profile").click(function(e)
  {
    e.preventDefault();
    $('#update_profile').text('saving...'); //change button text
    $('#update_profile').attr('disabled',true); //set button disable

    var url = "<?= base_url('home/update_profile'); ?>";
    var form=$("#profile_edit").get(0);
    var formData = new FormData(form);
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
	 
        if(data.status) //if success close modal and reload ajax table
        {
            // $('#modal_form').modal('hide');
            // reload_table();
            setInterval(window.location.href = '<?= base_url(); ?>', 3000)
            //window.location.href = '<?= base_url(); ?>';
        }
        $('#update_profile').text('save'); //change button text
        $('#update_profile').attr('disabled',false); //set button enable
        if(data.st==202)
        {
          <?php if($this->session->userdata('type')== 'admin') { ?>
            $("#name_error").html(data.name);
            $("#email_error").html(data.email);
            $("#contact_error").html(data.company_contact);
            $("#country_error").html(data.country);
            $("#state_error").html(data.state);
            $("#city_error").html(data.city);
            $("#address_error").html(data.address);
            $("#zipcode_error").html(data.zipcode);
          <?php } else if($this->session->userdata('type')== 'standard') { ?>
            $("#name_error").html(data.name);
            $("#contact_error").html(data.contact_number);
          <?php } ?>
        }
        else if(data.st==200)
        {
          <?php if($this->session->userdata('type')== 'admin') { ?>
            $("#name_error").html('');
            $("#email_error").html('');
            $("#contact_error").html('');
            $("#country_error").html('');
            $("#state_error").html('');
            $("#city_error").html('');
            $("#address_error").html('');
            $("#zipcode_error").html('');
          <?php } else if($this->session->userdata('type')== 'standard') { ?>
            $("#name_error").html('');
            $("#contact_error").html('');
          <?php } ?>

          $('#edit_profile').modal('hide');
          //setInterval('location.reload()', 1000);  
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding / update data');
        $('#update_profile').text('save'); //change button text
        $('#update_profile').attr('disabled',false); //set button enable
      }
    });
  });
  function save()
  {
    $('#add_user_btn').text('saving...'); //change button text
    $('#add_user_btn').attr('disabled',true); //set button disable
    var url;
    var formData;
    url = "<?= base_url('home/create'); ?>";
    formData = $('#add_user_form').serialize();
    // ajax adding data to database
    $.ajax({
      url : url,
      type: "POST",
      data: formData,
      dataType: "JSON",
      success: function(data)
      {  console.log(data);
        if(data.status==true) //if success close modal and reload ajax table
        {
          $('#edit_user').modal('hide');
          //reload_table();
        }
        if(data.st==202)
        {
          $("#standard_email_error").html(data.standard_email);
          $("#standard_mobile_error").html(data.standard_mobile);

          $('#add_user_btn').text('save'); //change button text
          $('#add_user_btn').attr('disabled',false); //set button disable
        }
        else if(data.st==200)
        {
          $("#standard_email_error").html('');
          $("#standard_mobile_error").html('');
          $('#add_user_btn').text('saving...'); //change button text
          $('#add_user_btn').attr('disabled',true); //set button disable

          $('#edit_user').modal('hide');
          setInterval('location.reload()', 500);  
        }
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding / update data');
        $('#add_user_btn').text('save'); //change button text
        $('#add_user_btn').attr('disabled',false); //set button enable
      }
    });
  }
  function match_pass() 
  {
    if (document.getElementById('first_password').value ==
          document.getElementById('second_password').value) {
          document.getElementById('second_password').style.borderColor = 'green';
        document.getElementById('match_pass_error').innerHTML = '';

    } 
    else {
        document.getElementById('second_password').style.borderColor = 'red';
        document.getElementById('match_pass_error').innerHTML = 'Password Not Matched';
    }
  }
  $("#last_name").blur(function()
  {
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var standard_name = first_name+" "+last_name;
    $.ajax({
      url: '<?php echo base_url("home/check_duplicate_user"); ?>',
      type : 'POST',
      data : {'standard_name' : standard_name },
      dataType : 'JSON',
      success : function(data)
      {
        if(data.st == 200)
        {
          $('#duplicate_name_error').html('');
          $('#add_user_btn').attr('disabled',false); //set button enable
        }
        else if(data.st == 202)
        {
          $('#duplicate_name_error').html('User Already Exists');
          $('#add_user_btn').attr('disabled',true); //set button enable
        }
      }


    })
  });
</script>