<!-- Add new modal -->

 <!-- Add new modal -->
      <div class="modal fade show Modal" id="addnew_modal" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="organization_add_edits"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body form">
                    <form action="#" id="formcontact" class="form-horizontal">
                      <input type="hidden" name="save_method" id="save_method">
                      <input type="hidden"  name="id">
                      <div class="form-body form-row">
                        <div class="col-md-6 mb-3">
                          <label>Contact Name <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control onlyLetters" name="name" id="contact_name_check1" placeholder="Contact Name" onChange="check_contactmodal1()">
                          <span id="name_error1"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Ownership</label>
                          <input type="text" class="form-control" name="assigned_to" placeholder="Ownership" value="<?= $this->session->userdata('name')?>" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Organization Name <span style="color: #f76c6c;">*</span></label>
                          <div class="input-group-append">
                            <input type="text" class="form-control ui-autocomplete-input" name="org_name" placeholder="Organization Name" id="org_name1" >
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="add_formOrg('Customer')" ><i class="fa fa-plus"></i></button>
                          </div>
                          <span id="org_name_error1" style="display: block;width: 100%;"></span>
                        </div>
                         
                        <div class="col-md-6 mb-3">
                          <label>Website</label>
                          <input type="text" class="form-control" id="website1" name="website" placeholder="Website">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Email ID</label>
                          <input type="email" class="form-control" id="email1" name="email" placeholder="Enter Email ID">
                          <span id="email_error1"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Office Phone</label>
                          <input type="number" class="form-control landline" maxlength="10" id="office_phone1" name="office_phone" placeholder="Office Phone" maxlength="15">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Mobile Number <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control phonePaste numeric" maxlength="10" id="mobile1" name="mobile" placeholder="Enter Mobile Number">
                          <span id="mobile_error1"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SLA Name</label>
                          <input type="text" class="form-control onlyLetters" id="sla_name1" name="sla_name" placeholder="SLA Name">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Reports To</label>
                          <input type="text" class="form-control onlyLetters" name="report_to" id="report_to1" placeholder="Reports To">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Title</label>
                          <select class="form-control" name="title">
                            <option value="" selected=" disabled"></option>
                            <option value="CEO">CEO</option>
                            <option value="VP">VP</option>
                            <option value="Director">Director</option>
                            <option value="Sales Manager">Sales Manager</option>
                            <option value="Support Manager">Support Manager</option>
                            <option value="Sales Representative">Sales Representative</option>
                            <option value="Support Agent">Support Agent</option>
                            <option value="Procurment Manager">Procurment Manager</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Department</label>
                          <input type="text" class="form-control onlyLetters" name="department" id="department1" placeholder="Department">
                        </div>
                        <div class="col-md-6 mb-3">
                        </div>
                        <div class="col-md-6 mb-3">
                          <h6>Billing Address</h6>
                        </div>
                        <div class="col-md-5 mb-2">
                          <h6>Shipping Address</h6>
                        </div>
                        <div class="col-md-1 mb-1">
                          <button type="button" class="btn btn-info btn-sm" onclick="copy(this.form)">Copy</button>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_country" placeholder="Country" id="country1" required>
                          <input type="hidden" class="form-control" id="country_ids1" >
                          <span id="billing_country_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_state" placeholder="State" id="states1" required="">
                          <input type="hidden" class="form-control" id="state_id1" >
                          <span id="billing_state_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_country" placeholder="Country" id="s_country1" required>
                          <input type="hidden" class="form-control" id="s_country_id1" >
                          <span id="shipping_country_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states1" required>
                          <input type="hidden" class="form-control" id="s_state_id1" >
                          <span id="shipping_state_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="billing_city" placeholder="City" id="cities1" required>
                          <span id="billing_city_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="billing_zipcode" placeholder="Zipcode" id="zipcode1" required>
                          <span id="billing_zipcode_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities1" required>
                          <span id="shipping_city_error1"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode <span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control numeric" maxlength="6" name="shipping_zipcode" placeholder="Zipcode" id="s_zipcode1" required>
                          <span id="shipping_zipcode_error1"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address <span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control" name="billing_address" placeholder="Enter Address" id="address1" required></textarea>
                          <span id="billing_address_error1"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address <span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control" name="shipping_address" placeholder="Address" id="s_address1" required></textarea>
                          <span id="shipping_address_error1"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                          <label>Description</label>
                          <textarea type="text" class="form-control" name="description" id="descriptionTxt1" placeholder="Enter Description"></textarea>
                        </div>
                      </div>
                    </form>
                  </div>
              <div class="modal-footer">
                <button type="button" id="btnSavecontact" onclick="savecontact();return false;" class="btn btn-info btn-sm">Save</button>
              </div>
          </div>
        </div>
      </div>
     
    <script>
var editor = CKEDITOR.replace( 'descriptionTxt1' );
CKEDITOR.config.height='100px';
</script>
<script>
function copy(form)
{
  form.shipping_country.value=form.billing_country.value;
  form.shipping_state.value=form.billing_state.value;
  form.shipping_city.value=form.billing_city.value;
  form.shipping_zipcode.value=form.billing_zipcode.value;
  form.shipping_address.value=form.billing_address.value;
}
</script>
<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<script>
$(document).ready(function () {
  var save_method; //for save method string
  var table;
  <?php if(check_permission_status('Contacts','retrieve_u')==true): ?>
  
    table = $('#ajax_datatable').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= base_url('contacts/ajax_list')?>",
            "type": "POST",
            "data" : function(data)
            {
                data.searchDate = $('#date_filter').val();
            }
        },
        "columnDefs": [
        {
          "targets": [0], //last column
          "orderable": false, //set not orderable
        },
        ],
    });
    $('#date_filter').change(function(){
      table.ajax.reload();
    });
  <?php endif; ?>
});
</script>
<script>
  <?php if(check_permission_status('Contacts','create_u')==true):?>
    function add_formcontact()
    {
      save_method = 'add_contact';
      $('#formcontact')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#addnew_modal').modal('show'); // show bootstrap modal
      $('.modal-title').text('Add Contact'); // Set Title to Bootstrap modal title
       CKEDITOR.instances['descriptionTxt1'].setData('');
      //Reset Form Errors
      $("#name_error1").html('');
      $("#org_name_error1").html('');
      $("#mobile_error1").html('');
      $("#email_error1").html('');
      $("#billing_country_error1").html('');
      $("#billing_state_error1").html('');
      $("#shipping_country_error1").html('');
      $("#shipping_state_error1").html('');
      $("#billing_city_error1").html('');
      $("#billing_zipcode_error1").html('');
      $("#shipping_city_error1").html('');
      $("#shipping_zipcode_error1").html('');
      $("#billing_address_error1").html('');
      $("#shipping_address_error1").html('');
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','create_u')==true || check_permission_status('Contacts','update_u')==true):?>
    function savecontact() 
    {
      $('#btnSavecontact').text('saving...'); //change button text
      $('#btnSavecontact').attr('disabled',true); //set button disable
      var url;
      if(save_method == 'add_contact') {
          url = "<?= site_url('contacts/create')?>";
      } else {
          url = "<?= site_url('contacts/update')?>";
      }
	    for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
		};
      // ajax adding data to database
      $.ajax({
        url : url,
        type: "POST",
        data: $('#formcontact').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
            $('#addnew_modal').modal('hide');
            window.location.reload();
          }
          $('#btnSavecontact').text('save'); //change button text
          $('#btnSavecontact').attr('disabled',false); //set button enable

          if(data.st==202)
          {
            $("#name_error1").html(data.name);
            $("#org_name_error1").html(data.org_name);
            $("#email_error1").html(data.email);
            $("#mobile_error1").html(data.mobile);
            $("#billing_country_error1").html(data.billing_country);
            $("#billing_state_error1").html(data.billing_state);
            $("#shipping_country_error1").html(data.shipping_country);
            $("#shipping_state_error1").html(data.shipping_state);
            $("#billing_city_error1").html(data.billing_city);
            $("#billing_zipcode_error1").html(data.billing_zipcode);
            $("#shipping_city_error1").html(data.shipping_city);
            $("#shipping_zipcode_error1").html(data.shipping_zipcode);
            $("#billing_address_error1").html(data.billing_address);
            $("#shipping_address_error1").html(data.shipping_address);
          }
          else if(data.st==200)
          {
            $("#name_error1").html('');
            $("#email_error1").html('');
            $("#org_name_error1").html('');
            $("#mobile_error1").html('');
            $("#billing_country_error1").html('');
            $("#billing_state_error1").html('');
            $("#shipping_country_error1").html('');
            $("#shipping_state_error1").html('');
            $("#billing_city_error1").html('');
            $("#billing_zipcode_error1").html('');
            $("#shipping_city_error1").html('');
            $("#shipping_zipcode_error1").html('');
            $("#billing_address_error1").html('');
            $("#shipping_address_error1").html('');
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSavecontact').text('save'); //change button text
          $('#btnSavecontact').attr('disabled',false); //set button enable
        }
      });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','retrieve_u')==true):?>
    function view(id)
    {
      $('#view')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('contacts/getbyId/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('[id="name"]').text(data.name);
            $('[id="created_date"]').text(data.datetime);
            $('[id="org_name_view"]').text(data.org_name);
            $('[id="email1"]').text(data.email);
            $('[id="website1"]').text(data.website);
            $('[id="office_phone1"]').text(data.office_phone);
            $('[id="mobile1"]').text(data.mobile);
            $('[id="assigned_to1"]').text(data.contact_owner);
            $('[id="sla_name1"]').text(data.sla_name);
            $('[id="report_to1"]').text(data.report_to);
            $('[id="title1"]').text(data.title);
            $('[id="department1"]').text(data.department);
            $('[id="billing_country1"]').text(data.billing_country);
            $('[id="billing_state1"]').text(data.billing_state);
            $('[id="shipping_country1"]').text(data.shipping_country);
            $('[id="shipping_state1"]').text(data.shipping_state);
            $('[id="billing_city1"]').text(data.billing_city);
            $('[id="billing_zipcode1"]').text(data.billing_zipcode);
            $('[id="shipping_city1"]').text(data.shipping_city);
            $('[id="shipping_zipcode1"]').text(data.shipping_zipcode);
            $('[id="billing_address1"]').text(data.billing_address);
            $('[id="shipping_address1"]').text(data.shipping_address);
            $('[id="description1"]').html(data.description);
            $('#view_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Contact'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error Retrieving Data From Database');
          }
      });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','update_u')==true):?>
    function update(id)
    {
        save_method = 'update';
        $('#form_contact')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Reset Form Errors
        $("#name_error1").html('');
        $("#org_name_error1").html('');
        $("#email_error1").html('');
        $("#mobile_error1").html('');
        $("#billing_country_error1").html('');
        $("#billing_state_error1").html('');
        $("#shipping_country_error1").html('');
        $("#shipping_state_error1").html('');
        $("#billing_city_error1").html('');
        $("#billing_zipcode_error1").html('');
        $("#shipping_city_error1").html('');
        $("#shipping_zipcode_error1").html('');
        $("#billing_address_error1").html('');
        $("#shipping_address_error1").html('');

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('contacts/getbyId/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
              $('[name="id"]').val(data.id);
              $('[name="name"]').val(data.name);
              $('[name="org_name"]').val(data.org_name);
              $('[name="email"]').val(data.email);
              $('[name="website"]').val(data.website);
              $('[name="office_phone"]').val(data.office_phone);
              $('[name="mobile"]').val(data.mobile);
              $('[name="assigned_to"]').val(data.contact_owner);
              $('[name="sla_name"]').val(data.sla_name);
              $('[name="report_to"]').val(data.report_to);
              $('[name="title"]').val(data.title);
              $('[name="department"]').val(data.department);
              $('[name="billing_country"]').val(data.billing_country);
              $('[name="billing_state"]').val(data.billing_state);
              $('[name="shipping_country"]').val(data.shipping_country);
              $('[name="shipping_state"]').val(data.shipping_state);
              $('[name="billing_city"]').val(data.billing_city);
              $('[name="billing_zipcode"]').val(data.billing_zipcode);
              $('[name="shipping_city"]').val(data.shipping_city);
              $('[name="shipping_zipcode"]').val(data.shipping_zipcode);
              $('[name="billing_address"]').val(data.billing_address);
              $('[name="shipping_address"]').val(data.shipping_address);
              //$('[name="description"]').val(data.description);
			  CKEDITOR.instances['descriptionTxt1'].setData(data.description);
              $('#addnew_modal').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Update Contact'); // Set title to Bootstrap modal title
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error Retrieving Data From Database');
            }
        });
    }
  <?php endif; ?>
  <?php if(check_permission_status('Contacts','delete_u')==true):?>
    function delete_entry(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('contacts/delete')?>/"+id,
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
  <?php endif; ?>
</script>
<script>
  jQuery(function(){
        jQuery('.show_div').click(function(){
              jQuery('.targetDiv').hide();
              jQuery('#div'+$(this).attr('target')).show();
        });
  });
</script>

<script>
$(document).ready(function(){
  $(".add_row").click(function()
  {
    var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control' type='text' placeholder='Mobile'></td>";
    $("#add").append(markup);
  });
  // Find and remove selected table rows
  $(".delete_row").click(function()
  {
    $("#add").find('input[id="checkbox"]').each(function()
    {
      if($(this).is(":checked"))
      {
        $(this).parents("tr").remove();
      }
    });
  });
  
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
 
});


$('#delete_all2').click(function(){
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0)
  {
   $("#delete_confirmation").modal('show'); 
  }else{
   alert('Select atleast one records');
  }
 });
 
$("#confirmed").click(function(){
  deleteBulkItem('contacts/delete_bulk'); 
});


function check_contactmodal1()
{
  var contact_name = $('#contact_name_check1').val();
  if(contact_name != '')
  {
    $.ajax({
     url: "<?= base_url(); ?>contacts/check_contact",
     method: "POST",
     data: {contact_name:contact_name},
     success: function(data)
     {
        $('#name_error1').html(data);
     }
    });
  }
}
function import_excel()
{
  $('#excel_modal').modal('show'); // show bootstrap modal
  $('#file').val('');
  $("#excel_table").hide();
  $("#duplicate_entry").empty();
  $("#import_button").attr('disabled',false);
}
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
$(document).ready(function(){
  $('#org_name1').autocomplete({
    source: "<?= base_url('organizations/autocomplete_org');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#org_name1').each(function(){
        var org_name = $(this).val();
        // AJAX request
        $.ajax({
          url:'<?=base_url('contacts/get_org_details')?>',
          method: 'post',
          data: {org_name: org_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
              var email = response[0].email;
              var website = response[0].website;
              var mobile = response[0].mobile;
              var phone = response[0].phone;
              var sla_name = response[0].sla_name;
              var billing_country = response[0].billing_country;
              var billing_state = response[0].billing_state;
              var billing_city = response[0].billing_city;
              var billing_zipcode = response[0].billing_zipcode;
              var billing_address = response[0].billing_address;
              var shipping_country = response[0].shipping_country;
              var shipping_state = response[0].shipping_state;
              var shipping_city = response[0].shipping_city;
              var shipping_zipcode = response[0].shipping_zipcode;
              var shipping_address = response[0].shipping_address;
              $('#website1').val(website);
              $('#email1').val(email);
              $('#mobile1').val(mobile);
              $('#office_phone1').val(phone);
              $('#sla_name1').val(sla_name);
              $('#country1').val(billing_country);
              $('#states1').val(billing_state);
              $('#cities1').val(billing_city);
              $('#zipcode1').val(billing_zipcode);
              $('#address1').val(billing_address);
              $('#s_country1').val(shipping_country);
              $('#s_states1').val(shipping_state);
              $('#s_cities1').val(shipping_city);
              $('#s_zipcode1').val(shipping_zipcode);
              $('#s_address1').val(shipping_address);
            }
            else
            {
              $('#website1').val('');
              $('#email1').val('');
              $('#mobile1').val('');
              $('#office_phone1').val('');
              $('#sla_name1').val('');
              $('#country1').val('');
              $('#states1').val('');
              $('#cities1').val('');
              $('#zipcode1').val('');
              $('#address1').val('');
              $('#s_country1').val('');
              $('#s_states1').val('');
              $('#s_cities1').val('');
              $('#s_zipcode1').val('');
              $('#s_address1').val('');
            }
          }
        });
      });
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#country1').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#country_ids1').val(ui.item.values);
      return false;
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#states').autocomplete({
      source: function(request, response) {
           var country_id =$('#country_ids1').val();
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
    //source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#state_id1').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#cities').autocomplete({
    source: function(request, response) {
           var state_id =$('#state_id1').val();
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
    //source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#s_country1').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#s_country_id1').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_states1').autocomplete({
       source: function(request, response) {
           var country_id =$('#s_country_id1').val();
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
    //source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#s_state_id1').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_cities1').autocomplete({
       source: function(request, response) {
           var state_id =$('#s_state_id1').val();
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
    //source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $("#excel_table").hide();
 $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>contacts/import",
   method:"POST",
   data:new FormData(this),
   dataType : 'JSON',
   contentType:false,
   cache:false,
   processData:false,
   success:function(response)
   {
    
    if(response.st == 202)
    {
      $('#file').val('');
      alert(response.msg);
    }
    else if(response.st == 200)
    {
      $('#file').val('');
      alert(response.msg);
      $('#excel_modal').modal('hide');
      window.location.reload();
    }
    else 
    {
      // To append the Excel data
      $.each(response, function() 
      {
        $("#excel_table").show();
        var message = "<tr><td>"+this.name+"</td><td>"+this.org_name+"</td></tr>";
        $("#duplicate_entry").append(message);
       
     });
      
      $("#import_button").attr('disabled',true);
    }
    
   }
  })
 });

});
</script>
<script>
function refreshPage(){
    window.location.reload();
} 
</script>
