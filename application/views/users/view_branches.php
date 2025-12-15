<?php $this->load->view('common_navbar');?>



  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Company Branches</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>

              <li class="breadcrumb-item active">Company Branches</li>

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

                  <button class="btn btn-info btn-sm" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>

                  <button class="btn btn-info btn-sm" onclick="add_form()">Add New</button>

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

                            <th><button class="btn" type="button" name="delete_all" id="delete_all" ><i class="fa fa-trash text-light"></i></button></th>

                            <th class="th-sm">Branch Name</th>

                            <th class="th-sm">Email ID</th>

                            <th class="th-sm">Contact no</th>

                            <th class="th-sm">Company Name</th>

                            <th class="th-sm">GSTIN</th>

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

<div class="modal fade show" id="branch_new_popup" role="dialog" aria-modal="true">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <div class="modal-header">

            <h3 class="modal-title" id="add_branch_title"></h3>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

        </div>

        <div class="modal-body form">

                  <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data" method="post" id="add_branch">

                    <div class="form-body form-row">

                        <input type="hidden" name="id">

                      <div class="col-md-6 mb-3">
                          <label>Branch Name<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="branch_name" placeholder="Branch Name">
                          <span id="name_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>Email<span style="color: #f76c6c;">*</span></label>
                          <input type="email" class="form-control " name="branch_email" placeholder="Email">
                          <span id="email_error"></span>
                      </div>

                      <div class="col-md-6 mb-3">
                          <label>Mobile<span style="color: #f76c6c;">*</span></label>
                          <input type="tel" class="form-control numeric" name="contact_number" placeholder="Mobile">
                          <span id="mobile_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>GSTIN<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="gstin" placeholder="GSTIN">
                          <span id="gstin_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>CIN<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="cin" placeholder="CIN">
                          <span id="cin_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>PAN<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="pan" placeholder="PAN">
                          <span id="pan_error"></span>
                      </div>

                      <div class="col-md-6 mb-3">
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters ui-autocomplete-input" name="country"  placeholder="Country" id="country" autocomplete="off">
                          <input type="hidden" class="form-control " id="country_ids" >
                          <span id="country_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters ui-autocomplete-input" name="state" placeholder="State" id="state" autocomplete="off">
                          <input type="hidden" class="form-control " id="state_id" >
                          <span id="state_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters ui-autocomplete-input" name="city" placeholder="City" id="city" autocomplete="off">
                          <span id="city_error"></span>

                      </div>

                      <div class="col-md-6 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" name="zipcode" placeholder="zipcode">
                          <span id="zipcode_error"></span>

                      </div>

                      <div class="col-md-12 mb-3">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea class="form-control " name="address" placeholder="Address"></textarea>
                          <span id="address_error"></span>

                      </div>

                    </div>

                  </form>

                </div>

        <div class="modal-footer">

          <button type="button" id="btnSave" onclick="save()" class="btn btn-info btn-sm">Save</button>

        </div>

    </div>

  </div>

</div>





<!-- view userbranch modal -->

<div class="modal fade show" id="view_branch" role="dialog" aria-modal="true">

          <div class="modal-dialog modal-dialog-scrollable modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title"></h3>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                </div>

                <div class="modal-body form">

                  <form id="view" class="row" action="#">

                    <div class="col-sm-12">

                      <h5 class="text-primary" id="company_name">Allegient Unified Technology Pvt. Ltd.</h5>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">Branch Name:</span><h6 class="text-primary" id="branch_name">Mumbai</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">Mobile:</span><h6 class="text-primary" id="contact_number">919873550688</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">Email:</span><h6 class="text-primary" id="branch_email">mp@allegientservices.com</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">GSTIN:</span><h6 class="text-primary" id="gstin">27AAMCA0717H1ZS</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">CIN:</span><h6 class="text-primary" id="cin">U72900DL2013PTC258753</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">PAN:</span><h6 class="text-primary" id="pan_number"></h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">Country:</span><h6 class="text-primary" id="country">India</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">State:</span><h6 class="text-primary" id="state">Maharashtra</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">City:</span><h6 class="text-primary" id="city">Mumbai</h6>

                    </div>

                    <div class="col-sm-6">

                      <span class="text-secondary">Zipcode:</span><h6 class="text-primary" id="zipcode">400064</h6>

                    </div>

                    <div class="col-sm-12">

                      <span class="text-secondary">Address:</span><h6 class="text-primary" id="address">Office No17, Ground Floor, Evershine Mall, Link Road, Chincholi Bunder, Malad West</h6>

                    </div>

                  </form>

                </div>

            </div>

          </div>

        </div>

<!-- view userbranch modal -->

 <?php $this->load->view('footer');?>

</div>

<!-- ./wrapper -->



<!-- common footer include -->

<?php $this->load->view('common_footer');?>

<script>

$(document).ready(function () {
  var table;
table = $('#ajax_datatable').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url('home/ajax_list_branch')?>",
            "type": "POST",
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
          "targets": [0], //last column
          "orderable": false, //set not orderable
        },
        ],
    });
});
function add_form()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#branch_new_popup').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Branch'); // Set Title to Bootstrap modal title
}
function save()
{
  $('#btnSave').text('saving...'); //change button text
  $('#btnSave').attr('disabled',true); //set button disable
  var url;
  if(save_method == 'add') {
      url = "<?= site_url('home/create_branch')?>";
  } else {
      url = "<?= site_url('home/update_branch')?>";
  }
  // ajax adding data to database
  $.ajax({
      url : url,
      type: "POST",
      data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data)
      {
        if(data.st == 202)
        {
          $('#name_error').html(data.branch_name);
          $('#email_error').html(data.branch_email);
          $('#mobile_error').html(data.contact_number);
          $('#gstin_error').html(data.gstin);
          $('#cin_error').html(data.cin);
          $('#pan_error').html(data.pan);
          $('#country_error').html(data.country);
          $('#state_error').html(data.state);
          $('#city_error').html(data.city);
          $('#zipcode_error').html(data.zipcode);
          $('#address_error').html(data.address);
        }
        else if(data.st == 200)
        {
          $('#name_error').html('');
          $('#email_error').html('');
          $('#mobile_error').html('');
          $('#gstin_error').html('');
          $('#cin_error').html('');
          $('#pan_error').html('');
          $('#country_error').html('');
          $('#state_error').html('');
          $('#city_error').html('');
          $('#zipcode_error').html('');
          $('#address_error').html('');
          $('#branch_new_popup').modal('hide');
          window.location.reload();
        }
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding / update data');
        $('#btnSave').text('save'); //change button text
        $('#btnSave').attr('disabled',false); //set button enable
      }
  });
}
function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax
}
function view(id)
{
  $('#view')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  //Ajax Load data from ajax
  $.ajax({
      url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
		  console.log(data);
        $('[id="company_name"]').text(data.company_name);
        $('[id="branch_name"]').text(data.branch_name);
        $('[id="branch_email"]').text(data.branch_email);
        $('[id="contact_number"]').text(data.contact_number);
        $('[id="gstin"]').text(data.gstin);
        $('[id="cin"]').text(data.cin);
        $('[id="pan_number"]').text(data.pan);
        $('[id="country"]').text(data.country);
        $('[id="state"]').text(data.state);
        $('[id="city"]').text(data.city);
        $('[id="zipcode"]').text(data.zipcode);
        $('[id="address"]').text(data.address);
        $('#view_branch').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Branch'); // Set title to Bootstrap modal title
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error Retrieving Data From Database');
      }
  });
}
function update(id)
{
  save_method = 'update';
  $('#form')[0].reset(); // reset form on modals
  $('.form-group').removeClass('has-error'); // clear error class
  $('.help-block').empty(); // clear error string
  //Ajax Load data from ajax
  $.ajax({
      url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('[name="id"]').val(data.id);
        $('[name="branch_name"]').val(data.branch_name);
        $('[name="branch_email"]').val(data.branch_email);
        $('[name="contact_number"]').val(data.contact_number);
        $('[name="gstin"]').val(data.gstin);
        $('[name="cin"]').val(data.cin);
        $('[name="pan"]').val(data.pan);
        $('[name="country"]').val(data.country);
        $('[name="state"]').val(data.state);
        $('[name="city"]').val(data.city);
        $('[name="zipcode"]').val(data.zipcode);
        $('[name="address"]').val(data.address);
        $('#branch_new_popup').modal('show'); // show bootstrap modal
        $('.modal-title').text('Update Branch'); // Set Title to Bootstrap modal title
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error Retrieving Data From Database');
      }
  });
}
function delete_entry(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?= site_url('home/delete_branch')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                window.location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}
</script>
<script>

function refreshPage(){

  window.location.reload();
} 
</script>
<script>
 $(document).ready(function(){
 $('.delete_checkbox').click(function(){
  if($(this).is(':checked'))
  {
   $(this).closest('tr').addClass('removeRow');
  }
  else
  {
   $(this).closest('tr').removeClass('removeRow');
  }
 });
   $('#delete_all').click(function(){
    var checkbox = $('.delete_checkbox:checked');
    if(checkbox.length > 0)
    {
     var checkbox_value = [];
     $(checkbox).each(function(){
      checkbox_value.push($(this).val());
     });
     $.ajax({
      url:"<?= base_url('home/delete_branch_bulk')?>",
      method:"POST",
      data:{checkbox_value:checkbox_value},
      success:function()
      {
       $('.removeRow').fadeOut();
       window.location.reload();
      }
     })
    }
    else
    {
     alert('Select atleast one records');
    }
   });
});
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= base_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#country_ids').val(ui.item.values);
      return false;
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#state').autocomplete({
       source: function(request, response) {
           var country_id =$('#country_ids').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= base_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#city').autocomplete({
     source: function(request, response) {
           var state_id =$('#state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= base_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
