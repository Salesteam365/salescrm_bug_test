<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
 
 
 <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Service Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>home">Home</a></li>
              <li class="breadcrumb-item active">Service Form</li>
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
        <!-- Main row -->
         <!-- Map card -->
<!--             <div class="invoice-div">
              <p>Invoice no. <b>AUPTL1/1001</b></p>
            </div> -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
                <form action="#" id="form" class="form-horizontal">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="">Name</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Name" name="servicename" id="servicename">
                    </div>
                    <div class="col-md-3">
                      <label class="">SKU</label>
                      <input type="text" name="servicesku" id="servicesku" placeholder="Enter SKU Here" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                      <label class="">SAC Code</label>
                      <input type="text" name="serviceSAC" id="serviceSAC" placeholder="Enter SAC Code Here" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-1">
                      <label class="">Unit</label>
                      <input type="text" name="serviceUnit" id="serviceUnit" placeholder="Enter Unit" class="form-control form-control-sm">
                    </div>
					<div class="col-md-1">
                      <label class="">Service Quantity</label>
                      <input type="text" name="serviceQuantity" id="serviceQuantity" placeholder="Enter Quantity" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                      <label class="">Value</label>
                      <input type="text" name="serviceValue" id="serviceValue" placeholder="Value in invoice" class="form-control form-control-sm">
                    </div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-2">
                      <label>Category</label><br>
                      <select class="form-control form-control-sm" name="serviceCategory" id="serviceCategory">
                        <option value="Product">Product</option>
                        <option value="Service" selected>Service</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label class="">Sale Price/rate</label>
                      <input type="text" name="servicePrice" id="servicePrice" value="50.00" placeholder="" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                      <label class="">Description</label>
                      <textarea name="serviceDesc" id="serviceDesc" placeholder="Write Description" class="form-control form-control-sm"></textarea>
                    </div>
                    <div class="col-md-2">
                      <label>Income Account</label><br>
                      <select class="form-control form-control-sm" id="serviceIncAcc" name="serviceIncAcc">
                        <option>Services</option>
                        <option>Product Sales</option>
                        <option>Sales</option>
                        <option>Sales Software</option>
                        <option>Sales Support &amp; Management</option>
                      </select>
                    </div>
                    <div class="col-md-2"></div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-2">
                      <label>Inventory Asset Account</label><br>
                      <select class="form-control form-control-sm" name="serviceAssAcc" id="serviceAssAcc">
                        <option>---</option>
                        <option>Inventory Asset</option>
                        <option>---</option>
                      </select>
                    </div>
                    <div class="col-md-1">
                      <label>Tax</label>
                      <select class="form-control form-control-sm" name="serviceTax" id="serviceTax">
                        <option value="12">12% GST</option>
                        <option value="18">18% GST</option>
                        <option value="28">28% GST</option>
                        <option value="VAT">VAT</option>
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label>Abatement %</label>
                      <input type="text" name="serviceAbatement" id="serviceAbatement" placeholder="" class="form-control-sm form-control">
                    </div>
                    <div class="col-md-3">
                      <label>Service Type</label>
                      <select name="serviceType" id="serviceType" placeholder="" class="form-control-sm form-control">
                        <option value="Courier">Courier</option>
                        <option value="Commercial Coaching">Commercial Coaching</option>
                        <option value="Online Information">Online Information</option>
                        <option value="Anti virus">Anti virus</option>
                        <option value="Software Licence Key">Software Licence Key</option>
                      </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <label>Purchasing Information</label>
                        <p><input type="checkbox" name="serviceInfo" id="serviceInfo" value="1"> I purchase this product/service from a supplier.</p>
                        <button id="btnSave" onClick="save();" type="button" class="form-control-sm btn btn-info btn-sm" style="border-radius: 0; padding: 20px 30px;">Save</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
      </section>
    
    <!-- /.Main content -->

  </div>
 


  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="http://www.allegientservices.com/" target="_blank">Allegient Services</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 365.2.4
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<style>
.bgclr{
	background: #066675;
}
</style>

<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script>
  var save_method; //for save method string
  var table;

   /****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

  
function checkValidationVendor(){

  var servicename		=$('#servicename').val();
  var servicesku		=$('#servicesku').val();
  var serviceSAC		=$('#serviceSAC').val();
  var serviceUnit		=$('#serviceUnit').val();
  var serviceValue		=$('#serviceValue').val();
  var serviceCategory	=$('#serviceCategory').val();
  var servicePrice		=$('#servicePrice').val();
  var serviceDesc		=$('#serviceDesc').val();
  var serviceIncAcc		=$('#serviceIncAcc').val();
  var serviceAssAcc		=$('#serviceAssAcc').val();
  var serviceTax		=$('#serviceTax').val();
  var serviceAbatement	=$('#serviceAbatement').val();
  var serviceType		=$('#serviceType').val();
  var serviceInfo		=$('#serviceInfo').val();

    if(servicename=="" || servicename===undefined){
      changeClr('servicename');
      return false;
    }else if(servicesku=="" || servicesku===undefined){
      changeClr('servicesku');
      return false;
    }else if(serviceSAC=="" || serviceSAC===undefined){
      changeClr('serviceSAC');
      return false;
    }else if(serviceUnit=="" || serviceUnit===undefined || serviceUnit==null ){
      changeClr('serviceUnit');
      return false;
    }else{
      return true;
    } 
}
 
$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
}); 
  
  
  <?php if($this->session->userdata('create_product')=='1' || $this->session->userdata('update_product')=='1'):?>
    function save()
    { 
	
	save_method='add';
		if(checkValidationVendor()==true){	
		alert();
			$('#btnSave').text('saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable
			var url;
			if(save_method == 'add') {
				url = "<?= base_url('product_manager/service_create')?>";
			} else {
				url = "<?= base_url('product_manager/update_form')?>";
			}
			  // ajax adding data to database
			$.ajax({
				  url : url,
				  type: "POST",
				  data: $('#form').serialize(),
				  dataType: "JSON",
				  success: function(data)
				  {
					  console.log(data);
					if(data.status) //if success close modal and reload ajax table
					{
					  window.location.href = "<?=base_url();?>product-manager";
					}
					$('#btnSave').text('save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable
					if(data.st==202) 
					{
					  alert('Error adding / update data');
					  $('#btnSave').text('save'); 
					  $('#btnSave').attr('disabled',false);
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
    }
  <?php endif; ?>
  <?php if($this->session->userdata('update_vendor')=='1'):?>
    function update(id)
    {
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $("#add").find("tr").remove();
      $("#add_row").hide();
      $("#delete_row").hide();
      
      $("#gst_rtype").find("option").remove();
      var gst_rtype = "<option value=''>Select Carrier</option>"+
      "<option value='GST unregistered'>GST unregistered</option>"+
      "<option value='GST registered- Regular'>GST registered- Regular</option>"+
      "<option value='GST registered- Composition'>GST registered- Composition</option>"+
      "<option value='Overseas'>Overseas</option>"+
      "<option value='SEZ'>SEZ</option>";
      $("#gst_rtype").append(gst_rtype);

      $("#terms").find("option").remove();
      var terms = "<option value=''>Select Terms</option>"+
      "<option value='Due on receipt'>Due on receipt</option>"+
      "<option value='CDC On Delivery'>CDC On Delivery</option>"+
      "<option value='Net 15'>Net 15</option>"+
      "<option value='Net 30'>Net 30</option>"+
      "<option value='Net 60'>Net 60</option>";
      $("#terms").append(terms);

      $("#name_error").html('');
      $("#email_error").html('');
      $("#mobile_error").html('');
      $("#gstin_error").html('');
      $("#gst_rtype_error").html('');

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('vendors/getbyId/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          
          $('[name="id"]').val(data.id);
          $('[name="sess_eml"]').val(data.sess_eml);
          $('[name="name"]').val(data.name);
          $('[name="email"]').val(data.email);
          $('[name="mobile"]').val(data.mobile);
          $('[name="office_phone"]').val(data.office_phone);
          $('[name="website"]').val(data.website);
          $('[name="asigned_to"]').val(data.asigned_to);
          $('[name="pan_no"]').val(data.pan_no);
          var gst_rtype = data.gst_rtype;
          var carrier = "<option>"+gst_rtype+"</option>";
          //$("#gst_rtype").append(carrier);
          $('[name="gst_rtype"]').val(gst_rtype);
          var terms = data.terms;
          var trm = "<option>"+terms+"</option>";
          //$("#terms").append(trm);
          $('[name="terms"]').val(terms);
          $('[name="gstin"]').val(data.gstin);
          $('[name="opening_balance"]').val(data.opening_balance);
          $('[name="as_of"]').val(data.as_of);
          $('[name="tax_registration_no"]').val(data.tax_registration_no);
          $('[name="effective_date"]').val(data.effective_date);
          $('[name="country"]').val(data.country);
          $('[name="state"]').val(data.state);
          $('[name="city"]').val(data.city);
          $('[name="zipcode"]').val(data.zipcode);
          $('[name="address"]').val(data.address);
          $('[name="description"]').val(data.description);
          $('#vendor_form').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Update Vendors'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
      });
      $.ajax({
        url : "<?php echo site_url('vendors/getcontactById/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $.each(data, function(i, item) 
          {
            var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
            "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control form-control-sm' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
            "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control form-control-sm' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
            "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control form-control-sm start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
            "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control form-control-sm' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
            $("#add").append(markup);
          });

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
      });
    }
  <?php endif; ?>
  <?php if($this->session->userdata('retrieve_vendor')=='1'):?>
    function view(id)
    {
      $('#view')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $("#view_add").find("tr").not(':first').remove();
      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('vendors/getbyId/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $('[id="name"]').text(data.name);
          $('[id="created_by"]').text(data.created_by);
          $('[id="email"]').text(data.email);
          $('[id="mobile"]').text(data.mobile);
          $('[id="office_phone"]').text(data.office_phone);
          $('[id="website"]').text(data.website);
          $('[id="asigned_to"]').text(data.asigned_to);
          $('[id="pan_no"]').text(data.pan_no);
          $('[id="gst_rtype"]').text(data.gst_rtype);
          $('[id="terms"]').text(data.terms);
          $('[id="gstin"]').text(data.gstin);
          $('[id="opening_balance"]').text(data.opening_balance);
          $('[id="as_of"]').text(data.as_of);
          $('[id="tax_registration_no"]').text(data.tax_registration_no);
          $('[id="effective_date"]').text(data.effective_date);
          $('[id="country"]').text(data.country);
          $('[id="state"]').text(data.state);
          $('[id="city"]').text(data.city);
          $('[id="zipcode"]').text(data.zipcode);
          $('[id="address"]').text(data.address);
          $('[id="description"]').text(data.description);
          $('#vendor_form_one').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Vendor'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
      });
      $.ajax({
        url : "<?php echo site_url('vendors/getcontactById/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $.each(data, function(i, item) 
          {
            var markup = "<tr><td width='4%'></td>"+
            "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control form-control-sm' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
            "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control form-control-sm' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
            "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control form-control-sm start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
            "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control form-control-sm' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
            $("#view_add").append(markup);
          });

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
      });
    }
  <?php endif; ?>
  <?php if($this->session->userdata('delete_vendor')=='1'):?>
    function delete_entry(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?= site_url('vendors/delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
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