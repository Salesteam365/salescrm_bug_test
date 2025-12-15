<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  
  
  
  <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Inventory Form</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>home">Home</a></li>
              <li class="breadcrumb-item active">Inventory Form</li>
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
		<?php 
		$data=array();
		foreach($pro as $key => $value){
			$data=$value;
		}
		
		?>	
			
			
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
                <form action="#" id="form" class="form-horizontal">
                  <div class="row">
                    <div class="col-md-3">
                      <label class="">Name<span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control onlyLetters" placeholder="Enter Name" name="proname" id="proname" value="<?php if(isset($data->product_name)){ echo $data->product_name; }?>">
                    </div>
                    <div class="col-md-3">
                      <label class="">SKU<span style="color: #f76c6c;">*</span></label>
                      <input type="text" name="prosku" id="prosku" placeholder="Enter SKU Here" class="form-control " value="<?php if(isset($data->sku)){ echo $data->sku; }?>">
                    </div>
                    <div class="col-md-3">
                      <label class="">HSN Code<span style="color: #f76c6c;">*</span></label>
                      <input type="text" name="prohsn" id="prohsn" placeholder="Enter HSN Code Here" class="form-control " value="<?php if(isset($data->hsn_code)){ echo $data->hsn_code; }?>">
                    </div>
					 <div class="col-md-3">
                      <label class="">isbn Code</label>
                      <input type="text" name="proisbn" id="proisbn" placeholder="Enter isbn Code Here" class="form-control "value="<?php if(isset($data->isbn)){ echo $data->isbn; }?>">
                    </div>
                    
                  </div>
                  <div class="row mt-4">
					<div class="col-md-3">
                      <label class="">Unit<span style="color: #f76c6c;">*</span></label>
                      <input type="text" name="prounit" id="prounit" placeholder="Enter Unit Here" class="form-control numeric" value="<?php if(isset($data->unit)){ echo $data->unit; }?>">
                    </div>
                    <div class="col-md-3">
                      <label>Category<span style="color: #f76c6c;">*</span></label>
					  <?php if(isset($data->product_category)){ $cate=$data->product_category; }else{ $cate=''; }?>
                      <select class="form-control " name="procategory" id="procategory">
                        <option value="Product" <?php if($cate=='Product'){ echo "selected"; }?> <?php if(!isset($data->product_category)){ echo "selected"; } ?> >Product</option>
                        <!--<option value="Service" <?php if($cate=='Service'){ echo "selected"; }?> >Service</option> -->
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="">Unit Price/rate<span style="color: #f76c6c;">*</span></label>
                      <input type="text" name="proprice" id="proprice" placeholder="" class="form-control numeric" value="<?php if(isset($data->product_unit_price)){ echo $data->product_unit_price; }?>">
                    </div>
					
					<!--<div class="col-md-2">
                      <label class="">Sale Price/rate</label>
                      <input type="text" name="proprice" id="proprice" value="" placeholder="" class="form-control " value="<?php if(isset($data->product_selling_price)){ echo $data->product_selling_price; }?>">
                    </div>-->
					
					<div class="col-md-3">
                      <label>Tax<span style="color: #f76c6c;">*</span></label>
					  <?php if(isset($data->pro_gst)){ $pro_gst=$data->pro_gst; }else{ $pro_gst=''; }?>
                      <select name="proGST" id="proGST" class="form-control ">
                        <option value="12" <?php if($pro_gst==12){ echo "selected"; } ?> >12% GST</option>
                        <option value="18"  <?php if($pro_gst==18){ echo "selected"; } ?> >18% GST</option>
                        <option value="28" <?php if($pro_gst==28){ echo "selected"; } ?>>28% GST</option>
                        <option value="VAT" <?php if($pro_gst=='VAT'){ echo "selected"; } ?>>VAT</option>
                      </select>
                    </div>
					
                  </div>
                  <div class="row mt-4">
				   <div class="col-md-3">
                      <label>Income Account</label>
					  <?php if(isset($data->income_account)){ $pro_incm=$data->income_account; }else{ $pro_incm=''; }?>
                      <select name="proIncAcc" id="proIncAcc" class="form-control ">
                        <option value="Product Sales" <?php if($pro_incm=='Product Sales'){ echo "selected"; } ?> >Product Sales</option>
                        <option value="Sales" <?php if($pro_incm=='Sales'){ echo "selected"; } ?>>Sales</option>
                        <option value="Sales Software" <?php if($pro_incm=='Sales Software'){ echo "selected"; } ?>>Sales Software</option>
                        <option value="Sales Support and Management" <?php if($pro_incm=='Sales Support and Management'){ echo "selected"; } ?>>Sales Support and Management</option>
                      </select>
                    </div>
                   <!-- <div class="col-md-2">
                      <label>Inventory Asset Account</label><br>
                      <select name="proInvAssAcc" id="proInvAssAcc" class="form-control ">
                        <option>---</option>
                        <option value="Inventory Asset">Inventory Asset</option>
                        <option>---</option>
                      </select>
                    </div>-->
                    
                    <div class="col-md-2">
                      <label>Reverse Charge %</label>
                      <input type="text" name="proRevCharge" id="proRevCharge" placeholder="" class=" form-control" value="<?php if(isset($data->reverse_charge)){ echo $data->reverse_charge; }?>">
                    </div>
                    <div class="col-md-2">
                      <label>Preferred Supplier</label>
                      <input type="text" name="proPrefSupp" id="proPrefSupp" placeholder="" class=" form-control" value="<?php if(isset($data->preferred_supplier)){ echo $data->preferred_supplier; }?>">
                    </div>
					
					 <div class="col-md-5">
                      <label class="">Description<span style="color: #f76c6c;">*</span></label>
                      <textarea name="prodesc" id="prodesc" placeholder="Write Description" row="1" class="form-control onlyLetters"><?php if(isset($data->product_description)){ echo $data->product_description; }?></textarea>
                    </div>
					
					
					
                    <div class="col-md-3"></div>
                    <div class="col-md-2"></div>
                  </div>
                  <div class="row mt-4">
                    <div class="col-md-6">
                      <table class="table table-responsive-lg-sm table-striped" width="100%">
                        <tbody>
                          <tr>
                            <td>Quantity on hand
                              <div class="additional">
                                <p class="m-0">Adjust: <a href="#" class="text-info">Quantity</a> | <a href="#" class="text-info">Starting value</a></p>
                              </div>
                            </td>
                            <td><input type="text" name="proQty" id="proQty" value="1" class="form-control"value="<?php if(isset($data->product_quantity)){ echo $data->product_quantity; }?>" ></td>
                          </tr>
                          <tr>
                            <td>Low stock alert
                              <div class="additional">
                                <a href="#" class="text-info">What's the low stock alert?</a>
                              </div>
                            </td>
                            <td><input type="text" name="proLowAlert" id="proLowAlert" value="2" class="form-control"></td>
                          </tr>
                          <tr>
                            <td>Quantity on PO</td>
                            <td>1</td>
                          </tr>
                        </tbody>
                      </table>
					  <?php if(isset($data->id)){ ?>
					  <input type="hidden" name="proid" id="proid" value="<?php if(isset($data->id)){ echo $data->id; } ?>">
					  <button type="button" onClick="save('update');" id="btnSave" class=" btn btn-info btn-sm" style="border-radius: 0; padding: 20px 30px;">Update</button>
					  <?php }else{ ?>
                      <button type="button" onClick="save('save');" id="btnSave" class=" btn btn-info btn-sm" style="border-radius: 2px; padding: 10px 30px; background:rgba(35,0,140,0.8)">Save</button>
					  <?php } ?>
                    </div>
                    <div class="col-md-6"></div>  
                  </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
      </section>
    
    <!-- /.Main content -->

  </div>

  <!-- /.content-wrapper -->
 
 <?php $this->load->view('footer');?>
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

  var proname		=$('#proname').val();
  var prosku		=$('#prosku').val();
  var prohsn		=$('#prohsn').val();
  var prounit		=$('#prounit').val();
  var procategory	=$('#procategory').val();
  var proprice		=$('#proprice').val();
  var prodesc		=$('#prodesc').val();
  var proIncAcc		=$('#proIncAcc').val();
  var proInvAssAcc	=$('#proInvAssAcc').val();
  var proGST		=$('#proGST').val();
  var proRevCharge	=$('#proRevCharge').val();
  var proPrefSupp	=$('#proPrefSupp').val();
  var proLowAlert	=$('#proLowAlert').val();

    if(proname=="" || proname===undefined){
      changeClr('proname');
      return false;
    }else if(prosku=="" || prosku===undefined){
      changeClr('prosku');
      return false;
    }else if(prohsn=="" || prohsn===undefined){
      changeClr('prohsn');
      return false;
    }else if(prounit=="" || prounit===undefined || prounit==null ){
      changeClr('prounit');
      return false;
    }else if(procategory=="" || procategory===undefined || procategory==null ){
      changeClr('procategory');
      return false;
    }else if(proprice=="" || proprice===undefined){
      changeClr('proprice');
      return false;
    }else if(proGST=="" || proGST===undefined){
      changeClr('proGST');
      return false;
    }else if(prodesc=="" || prodesc===undefined){
      changeClr('prodesc');
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
    function save(save_method)
    { 
	
		if(checkValidationVendor()==true){	
			$('#btnSave').text('saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable
			var url;
			if(save_method == 'save') {
				url = "<?= base_url('product_manager/create')?>";
			} else {
				url = "<?= base_url('product_manager/update_form')?>";
			}
			
			$.ajax({
				  url : url,
				  type: "POST",
				  data: $('#form').serialize(),
				  dataType: "JSON",
				  success: function(data)
				  {
					 // console.log(data);
					if(data.status)
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
            "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
            "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
            "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
            "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
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
            "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
            "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
            "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
            "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
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

<script>
  jQuery(function(){
        jQuery('.show_this').click(function(){
			$('.show_this').removeClass('bgclr');
			$(this).addClass('bgclr');
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
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td>";
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
 $('#delete_all').click(function(){
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0)
  {
   var checkbox_value = [];
   $(checkbox).each(function(){
    checkbox_value.push($(this).val());
   });
   $.ajax({
    url:"<?= base_url('Vendors/delete_bulk');?>",
    method:"POST",
    data:{checkbox_value:checkbox_value},
    success:function()
    {
     $('.removeRow').fadeOut();
     reload_table();
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


<script>
$(document).ready(function(){
  
  $(".add_row").click(function()
  {
    var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td>";
    $("#add_edit").append(markup);
  });
  // Find and remove selected table rows
  $(".delete_row").click(function()
  {
    $("#add_edit").find('input[id="checkbox"]').each(function()
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
</script>
<script>
function refreshPage(){
    window.location.reload();
} 
</script>

<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#state').autocomplete({
    source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#city').autocomplete({
    source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
function fetchGSTList() {
    $.ajax({
      url: '<?php echo base_url('Setting/fetch_gst_list')?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.error) {
          console.error(response.error);
          // Handle the error if needed
        } else {
          var data = response.data;
          var select = $('#proGST');
          select.empty(); // Clear existing options

          if (data && data.length > 0) {
            $.each(data, function(index, item) {
              // Assuming your data has 'value' and 'text' properties
              select.append($('<option>', {
                value: item.gst_percentage,
                text: item.gst_percentage + '% ' + item.tax_name
              }));
            });
          } else {
            // If no data is available, set default options
            select.html(
              '<option value="12">12% GST</option>' +
              '<option value="18">18% GST</option>' +
              '<option value="28">28% GST</option>' +
              '<option value="VAT">VAT</option>'
            );
          }
          
          // Check a condition and select an option if needed
          <?php
            // Check your PHP condition here
            $selectedValue = $data->pro_gst; // Change this to your condition

            echo "var selectedValue = '$selectedValue';\n";
          ?>
          if (selectedValue) {
            select.val(selectedValue);
          }
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
        // Handle the error if needed
      }
    });
  }

  // Call the fetchGSTList function to populate the dropdown and select an option
  fetchGSTList();
});
</script>