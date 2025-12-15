 <!-- Add new modal -->
<div class="modal fade show" id="modal_formOrg" role="dialog" aria-modal="true">
          <div class="modal-dialog modal-lg ModalRight">
            <div class="modal-content Modalht100">
                <div class="modal-header">
                    <h3 class="modal-title" id="organization_titles">Add Customer</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body form">
                  <form action="#" id="form_org" class="form-horizontal">
                    <input type="hidden" value="" name="id">
                    <input type="hidden" value="" name="sess_eml">
                    <input type="hidden" value="" name="save_method" id="save_method_org">
                    <input type="hidden" value="" name="formname" id="formname">
                    <div class="form-body form-row">
                      <div class="col-md-6 mb-3">
                        <label><text class="ptvl">Customer</text> Name<span style="color: #f76c6c;">*</span></label>
                        <input type="text" class="form-control " name="org_name" id="org_name_checkmodal" placeholder="Company Name" onChange="check_orgmodal()" required>
                        <span id="orgmodal_name_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label><text class="ptvl">Customer</text> Type<span style="color: #f76c6c;">*</span></label>    
                          <select class="form-control" name="cust_types" id="cust_type_select">
                            <option value="">Select Type</option>
                            <option value="Customer">Customer</option>
							<option value="Vendor">Vendor</option>
							<option value="Both">Both</option>
                          </select>
						  <span id="customer_type_error"></span>
                        </div>
                      <div class="col-md-6 mb-3">
                         <label>Ownership</label>
                        <input type="text" class="form-control " name="ownership" placeholder="Ownership" value="<?= $this->session->userdata('name'); ?>" readonly>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Primary Contact Person<span style="color: #f76c6c;">*</span></label>  
                        <input type="text" class="form-control " name="primary_contact" id="primary_contact_org" placeholder="Primary Contact Name">
                        <!--<span id="primary_contact_error"></span>-->
                      </div>
                      
                      <div class="col-md-6 mb-3">
                        <label>Email<span style="color: #f76c6c;">*</span></label>
                        <input type="email" class="form-control email_address" name="email" id="emailId" placeholder="Email">
                        <span id="email_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Website</label>
                        <input type="url" class="form-control " name="website" id="websiteId" placeholder="Website" required>
                        <span id="website_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Office Phone</label>  
                        <input type="tel" class="form-control  landline"  name="office_phone" id="officePhone" placeholder="Office Phone" required="">
                        <!--<span id="office_phone_error"></span>-->
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Mobile<span style="color: #f76c6c;">*</span></label> 
                        <input type="text" class="form-control phonePaste numeric" name="mobile" maxlength="10" id="mobileId" placeholder="Mobile" required="">
                        <span id="mobile_error"></span>
                      </div>
                      
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_divorg" target="1" id="forTarget1" style="width:100%;color:#ffffff">Other Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_divorg" target="2" id="forTarget2" style="width:100%;color:#ffffff">Address Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_divorg" target="3" style="width:100%;color:#ffffff">Contact Person</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_divorg" target="4" style="width:100%;color:#ffffff">Description</a>
                      </div>
                      <div class="col-md-3 mb-3">
                      </div>

                      <div id="div1" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-6 mb-3">
                          <label>Employees</label>
                          <input type="number" class="form-control " name="employees" id="employeesId" placeholder="Employees">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Industry</label>
                          <select class="form-control " name="industry" id="industryId" required="">
                            <option value="">Industry</option>
                            <option value="Government">Government</option>
                            <option value="Other">Other</option>
                            <option value="Utilies">Utilies</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Telecommunications">Telecommunications</option>
                            <option value="Technology">Technology</option>
                            <option value="'Shipping">Shipping</option>
                            <option value="Retail">Retail</option>
                            <option value="Recreation">Recreation</option>
                            <option value="Not For Profit">Not For Profit</option>
                            <option value="Media">Media</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Machinery">Machinery</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Apparel">Apparel</option>
                            <option value="Food and Baverage">Food and Baverage</option>
                            <option value="Finance">Finance</option>
                            <option value="Environmental">Environmental</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Energy">Energy</option>
                            <option value="Electronic">Electronic</option>
                            <option value="Education">Education</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Construction">Construction</option>
                            <option value="Communications">Communications</option>
                            <option value="Chemicals">Chemicals</option>
                            <option value="Biotechnology">Biotechnology</option>
                            <option value="Banking">Banking</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Assign To</label>
                          <input type="text" class="form-control " name="assigned_to" id="assigned_to" placeholder="Assigned To">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Annual Revenue</label>
                          <input type="number" class="form-control " name="annual_revenue" id="annualRevenue" placeholder="Annual Revenue">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Type</label>
                          <select class="form-control " name="type" id="typeId">
                            <option value="">Type</option>
                            <option value="Lead">Lead</option>
                            <option value="Sales Qualified Lead">Sales Qualified Lead</option>
                            <option value="Customer">Customer</option>
                            <option value="Compatitor">Compatitor</option>
                            <option value="Partner">Partner</option>
                            <option value="Analyst">Analyst</option>
                            <option value="Vendor">Vendor</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Region</label> 
						  <select class="form-control " name="region" id="regionID" >
							<option value="">Region</option>
							<option value="NAM">NAM</option>
							<option value="LAM">LAM</option>
							<option value="EU">EU</option>
							<option value="APAC">APAC</option>
							<option value="MEA">MEA</option>
						  </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SIC Code</label> 
                          <input type="text" class="form-control " name="sic_code" id="sicCode" placeholder="SIC Code">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SLA Name</label> 
                          <input type="text" class="form-control " name="sla_name" id="slaName" placeholder="SLA Name">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>GSTIN</label>  
                          <input type="text" class="form-control " name="gstin" id="gstinId" placeholder="GSTIN" maxlength="15">
                         <span id="gstin_error" style="color:red;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Pan Number</label>    
                          <input type="text" class="form-control " name="panno" id="panno" placeholder="Pan Number" maxlength="10">
                          <span id="panno_error"></span>
                        </div>
                      </div>

                      <div id="div2" class="targetDiv form-row col-md-12" style="display: none;">
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
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_country" placeholder="Country" id="country_org"  required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="country_ids" >
                          <span id="billingmodal_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_state" placeholder="State" id="states_org" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="state_id" >
                           <span id="billingmodal_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_country" placeholder="Shipping Country" id="s_country_org" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_country_id" >
                           <span id="shippingmodal_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states_org" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_state_id" >
                          <span id="shippingmodal_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_city" placeholder="City" id="cities_org" required="" autocomplete="off">
                          <span id="billingmodal_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="billing_zipcode" placeholder="Zipcode" required="" id="billingZipcode_org">
                           <span id="billingmodal_zipcode_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities_org" required="" autocomplete="off">
                           <span id="shippingmodal_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode<span style="color: #f76c6c;">*</span></label>
                          <input type="text" class="form-control " name="shipping_zipcode" placeholder="Zipcode" required="" id="shippingZipcode_org">
                          <span id="shippingmodal_zipcode_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control " name="billing_address" placeholder="Address" required="" id="billingAddress_org"></textarea>
                          <span id="billingmodal_address_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address<span style="color: #f76c6c;">*</span></label>
                          <textarea type="text" class="form-control " name="shipping_address" placeholder="Address" required="" id="shippingAddress_org"></textarea>
                          <span id="shippingmodal_address_error"></span>
                        </div>
                      </div>

                      <div id="div3" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-12 mb-6">
                          <table style="margin-bottom:5px;" id="addroworg">
                            <tbody>
								<tr>
								<td width="4%"><input id="checkbox" type="checkbox"></td>
								<td width="24%"><input name="contact_name_batch[]" id="contact_name_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Contact Name"></td>
								<td width="24%"><input name="email_batch[]" id="email_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Email"></td>
								<td width="24%"><input name="phone_batch[]" id="phone_batch" class="form-control  start" data-toggle="tooltip" title="Tittle" type="text" placeholder="Work Phone"></td>
								<td width="24%"><input name="mobile_batch[]" id="mobile_batch" class="form-control phonePaste numeric" maxlength="10" data-toggle="tooltip" title="Tittle" type="text" placeholder="Mobile"></td>
								</tr>
							</tbody>
						   </table>
                        </div>
                        <div class="col-md-2">
                          <input type="button" class="add_roworg btn btn-outline-info btn-sm" value="Add Row" id="add_roworg">
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="delete_roworg btn btn-outline-danger btn-sm" id="delete_roworg">Delete Row</button>
                        </div>
                        <div class="col-md-8">
                        </div>
                      </div>

                      <div id="div4" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-12 mb-3">
                          <label>Description</label>
                          <textarea type="text" class="form-control" name="description" id="descriptionTxtorg"  placeholder="Description"></textarea>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <span id="error_msg" style="color: red;font-size: 14px;font-weight: 200px;"></span>
				  <button type="button" class="btn btn-secondary"  data-dismiss="modal" aria-label="Close" >Close</button>
                  <button type="button" id="btnSaveorg" onclick="saveOrg()" class="btn btn-info ">Save</button>
                </div>
            </div>
          </div>
        </div>
		
<script>
var editor = CKEDITOR.replace( 'descriptionTxtorg' );
CKEDITOR.config.height='100px';
</script>		
<script>
    var save_method;
    function copy(form)
    {
      form.shipping_country.value=form.billing_country.value;
      form.shipping_state.value=form.billing_state.value;
      form.shipping_city.value=form.billing_city.value;
      form.shipping_zipcode.value=form.billing_zipcode.value;
      form.shipping_address.value=form.billing_address.value;
    }
    function check_orgmodal()
    {
      var org_name = $('#org_name_checkmodal').val();
      if(org_name != ''){
        $.ajax({
         url: "<?= base_url(); ?>organizations/check_org",
         method: "POST",
         data: {org_name:org_name},
         success: function(data){
          $('#orgmodal_name_error').html(data);
         }
        });
      }
    }
    <?php if(check_permission_status('Customer','create_u')==true): ?>
        function add_formOrg(customer_type,formname='')
        {
		
		<?php if($this->session->userdata('account_type')=="Trial"): ?>
			var org_name='count';
			$.ajax({
				url: "<?= base_url(); ?>organizations/count_all",
				method: "POST",
				data: {org_name:org_name},
				success: function(data){
					if(data>=2000){
						$(".Modalht100").html('<div class="col-md-12 mb-3 mt-5 text-center"><i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i></div><div class="col-md-12 mb-3 text-center">You are now using trial account.<br><text id="">You are exceeded  your customer/contact limit - 2,000</text><br>Please upgrade your plan to click bellow button.</div><div class="col-md-12 mb-4 text-center"><a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a></div>');
					}
				}
			});
		<?php endif; ?>	
			
          save_method = 'add_org';
          $("#formname").val(formname);
		 
          $("#organization_titles").html('Add '+customer_type);
          $(".ptvl").html(customer_type);
		  
          $("#save_method_org").val('add_org');
          $('#form_org')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string
          $('#modal_formOrg').modal('show'); // show bootstrap modal
          //$('#organization_titles').text('Add Customer'); // Set Title to Bootstrap modal title
          $('[id="cust_type_select"]').val(customer_type);
          $("#addroworg").find("tr").remove();
          var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
          "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
          "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
          "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
          "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control phonePaste numeric' maxlength='10' type='text' placeholder='Mobile'></td></tr>";
          $("#addroworg").append(markup);
          $("#add_roworg").show();
          $("#delete_roworg").show();
		  $("#org_name_checkmodal").attr('readonly', false);
          // Reset Form Errors
          $("#orgmodal_name_error").html('');
          
          $("#billingmodal_country_error").html('');
          $("#billingmodal_state_error").html('');
          $("#shippingmodal_country_error").html('');
          $("#shippingmodal_state_error").html('');
          $("#billingmodal_city_error").html('');
          $("#billingmodal_zipcode_error").html('');
          $("#shippingmodal_city_error").html('');
          $("#shippingmodal_zipcode_error").html('');
          $("#billingmodal_address_error").html('');
          $("#shippingmodal_address_error").html('');
          $('#btnSaveorg').text('Save'); //change button text
        }
    <?php endif; ?>
	
	
	/****** VALIDATION FUNCTION FOR ORG*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

function checkValidation_org(){
  var org_name_checkmodal=$('#org_name_checkmodal').val();
  var cust_types = $('#cust_type_select').val();
  var primary_contact=$('#primary_contact_org').val();
  var emailId=$('#emailId').val();
  var mobileId=$('#mobileId').val();

  //var typeId=$('#typeId').val();
  //var industryId=$('#industryId').val();
  //var regionID=$('#regionID').val();

  var country_org=$('#country_org').val();
  var states_org=$('#states_org').val();
  var cities_org=$('#cities_org').val();
  var billingZipcode_org=$('#billingZipcode_org').val();
  var billingAddress_org=$('#billingAddress_org').val();
  var s_country_org=$('#s_country_org').val();
  var s_states_org=$('#s_states_org').val();
  var s_cities_org=$('#s_cities_org').val();
  var shippingZipcode_org=$('#shippingZipcode_org').val();
  var shippingAddress_org=$('#shippingAddress_org').val();
  
    if(org_name_checkmodal=="" || org_name_checkmodal===undefined){
      changeClr('org_name_checkmodal');
      return false;
    }else if(cust_types=="" || cust_types===undefined || cust_types===null){
      changeClr('cust_type_select');
      return false;  
    }else if(primary_contact=="" || primary_contact===undefined){
      changeClr('primary_contact_org');
      return false;
    }else if(emailId=="" || emailId===undefined){
      changeClr('emailId');
      return false;
    }else if(mobileId=="" || mobileId===undefined){
      changeClr('mobileId');
      return false;
    }else if(country_org=="" || country_org===undefined || country_org===null){
      changeClr('country_org');
      $('#forTarget2').click();
	  console.log('country_org');
      return false;
    }else if(states_org=="" || states_org===undefined || states_org===null){
      changeClr('states_org');
      $('#forTarget2').click();
	  console.log('state');
      return false;
    }else if(cities_org=="" || cities_org===undefined){
      changeClr('cities_org');
      $('#forTarget2').click();
	  console.log('city');
      return false;
    }else if(billingZipcode_org=="" || billingZipcode_org===undefined || billingZipcode_org===null){
      changeClr('billingZipcode_org');
      $('#forTarget2').click();
	  console.log('bzip');
      return false;
    }else if(billingAddress_org=="" || billingAddress_org===undefined){
      changeClr('billingAddress_org');
      $('#forTarget2').click();
	  console.log('address');
      return false;
    }else if(s_country_org=="" || s_country_org===undefined){
      changeClr('s_country_org');
      $('#forTarget2').click();
	  console.log('s_country_org');
      return false;
    }else if(s_states_org=="" || s_states_org===undefined){
      changeClr('s_states_org');
      $('#forTarget2').click();
	  console.log('s_states_org');
      return false;
    }else if(s_cities_org=="" || s_cities_org===undefined){
      changeClr('s_cities_org');
      $('#forTarget2').click();
	  console.log('s_cities_org');
      return false;
    }else if(shippingZipcode_org=="" || shippingZipcode_org===undefined){
      changeClr('shippingZipcode_org');
      $('#forTarget2').click();
	  console.log('s_zip');
      return false;
    }else if(shippingAddress_org=="" || shippingAddress_org===undefined){
      changeClr('shippingAddress_org');
	  console.log('a_add');
      $('#forTarget2').click();
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

	
	
	
    <?php if(check_permission_status('Customer','create_u')==true || check_permission_status('Customer','update_u')==true): ?>
        function saveOrg()
        {
			if(checkValidation_org()==true){
				$('#btnSaveorg').text('Saving...'); //change button text
				$('#btnSaveorg').attr('disabled',true); //set button disable
				var url;
				if(save_method == 'add_org') {
				  url = "<?= base_url('organizations/create')?>";
				} else {
				  url = "<?= base_url('organizations/update')?>";
				}
		  
			  for (var i in CKEDITOR.instances) {
				CKEDITOR.instances[i].updateElement();
			  };
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form_org').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.status=='Data exist'){
						toastr.info('Entered data already exist, Please check customer or vendor.');
					}else if(data.status){
						$('#modal_formOrg').modal('hide');
						toastr.success('Your customer has been added successfully.');
						var org_name=$("#org_name_checkmodal").val();
						$.ajax({
							url:"<?= base_url('contacts/get_org_details')?>",
							method: 'POST',
							data: {org_name: org_name},
							dataType: 'json',
							success: function(response){
							var len = response.length;
							if(len > 0){
								var formname=$("#formname").val();
								var orgType=$("#cust_type_select").val();
								$("#"+formname+" .orgName").val(response[0].org_name);
								$("#"+formname+" .orgEmail").val(response[0].email);
								$("#"+formname+" .orgMobile").val(response[0].mobile);
								
								var orgSate=response[0].billing_state;
								var YourStateName=$("#YourStateName").val();				
								if(orgSate==YourStateName){
									$("#igst_checked").attr('checked', false);
									$("#csgst_checked").attr('checked', true);
									$('#csgst_checked').click();
									$("#csgst_checked").attr('disabled', false);
									$("#igst_checked").attr('disabled', true);
								}else{
									$("#igst_checked").attr('disabled', false);
									$("#csgst_checked").attr('disabled', true);
								}
								
								
								
							if(orgType=='Vendor'){
								var ContactHtml=response[0].primary_contact;
								$("#"+formname+" .orgContact").html(ContactHtml);
								$("#"+formname+" .orgGstin").val(response[0].gstin);
								$("#"+formname+" .orgCountry").val(response[0].billing_country);
								$("#"+formname+" .orgState").val(response[0].billing_state);
								$("#"+formname+" .orgCity").val(response[0].billing_city);
								$("#"+formname+" .orgZipcode").val(response[0].billing_zipcode);
								$("#"+formname+" .orgAddress").val(response[0].billing_address);
							}else{
								$("#"+formname+" .orgOfficePhone").val(response[0].office_phone);
								$("#"+formname+" .orgIndustry").val(response[0].industry);
								$("#"+formname+" .orgEmployee").val(response[0].employees);
								$("#"+formname+" .orgWebsite").val(response[0].website);
								var ContactHtml='<option value="'+response[0].primary_contact+'">'+response[0].primary_contact+'</option>';
								$("#"+formname+" .orgContact").html(ContactHtml);
								$("#"+formname+" .orgBillingCountry").val(response[0].billing_country);
								$("#"+formname+" .orgShippingCountry").val(response[0].shipping_country);
								$("#"+formname+" .orgBillingState").val(response[0].billing_state);
								$("#"+formname+" .orgShippingState").val(response[0].shipping_state); 
								$("#"+formname+" .orgBillingCity").val(response[0].billing_city);
								$("#"+formname+" .orgShippingCity").val(response[0].shipping_city); 
								$("#"+formname+" .orgBillingZip").val(response[0].billing_zipcode);
								$("#"+formname+" .orgShippingZip").val(response[0].shipping_zipcode); 
								$("#"+formname+" .orgBillingAddress").val(response[0].billing_address);
								$("#"+formname+" .orgShippingAddress").val(response[0].shipping_address);
							}
							}
						  }
						})
						var formname=$("#formname").val();
						if(formname=='PI'){
							var org_name=$("#org_name_checkmodal").val();
							$("#org_name").val(org_name);
							showBillto(org_name);
						}
					}
                $('#btnSaveorg').text('Save'); //change button text
                $('#btnSaveorg').attr('disabled',false); //set button enable

                if(data.st==202)
                {
                  $("#orgmodal_name_error").html(data.org_name);
                  $("#customer_type_error").html(data.cust_types);
                  $("#email_error").html(data.email);
                  $("#primary_contact_error").html(data.primary_contact);
                  $("#mobile_error").html(data.mobile);
                  $("#billingmodal_country_error").html(data.billing_country);
                  $("#billingmodal_state_error").html(data.billing_state);
                  $("#shippingmodal_country_error").html(data.shipping_country);
                  $("#shippingmodal_state_error").html(data.shipping_state);
                  $("#billingmodal_city_error").html(data.billing_city);
                  $("#billingmodal_zipcode_error").html(data.billing_zipcode);
                  $("#shippingmodal_city_error").html(data.shipping_city);
                  $("#shippingmodal_zipcode_error").html(data.shipping_zipcode);
                  $("#billingmodal_address_error").html(data.billing_address);
                  $("#shippingmodal_address_error").html(data.shipping_address);
                  $("#error_msg").html('oops! there will be some error ');
                }
                else if(data.st==200)
                {
                  $("#orgmodal_name_error").html('');
                  $("#customer_type_error").html('');
                  $("#email_error").html('');
                  $("#primary_contact_error").html('');
                  $("#email_error").html('');
                  $("#mobile_error").html('');
                  $("#billingmodal_country_error").html('');
                  $("#billingmodal_state_error").html('');
                  $("#shippingmodal_country_error").html('');
                  $("#shippingmodal_state_error").html('');
                  $("#billingmodal_city_error").html('');
                  $("#billingmodal_zipcode_error").html('');
                  $("#shippingmodal_city_error").html('');
                  $("#shippingmodal_zipcode_error").html('');
                  $("#billingmodal_address_error").html('');
                  $("#shippingmodal_address_error").html('');
                  $("#error_msg").html('');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  toastr.success('Something went wrong, Please try later.');
                  $('#btnSaveorg').text('Save'); //change button text
                  $('#btnSaveorg').attr('disabled',false); //set button enable
              }
          });
			}
        }
    <?php endif; ?>
    
</script>

<script>
  jQuery(function(){
        jQuery('.show_divorg').click(function(){
			$('.show_divorg').removeClass('bgclr');
              jQuery('.targetDiv').hide();
              jQuery('#div'+$(this).attr('target')).show();
			  $(this).addClass('bgclr');
			  
        });
});
</script>

<script>
$(document).ready(function(){
  $(".add_roworg").click(function()
  {
    var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td>";
    $("#addroworg").append(markup);
  });
  // Find and remove selected table rows
  $(".delete_roworg").click(function()
  {
    $("#addroworg").find('input[id="checkbox"]').each(function()
    {
      if($(this).is(":checked"))
      {
        $(this).parents("tr").remove();
      }
    });
  });
  
 $('.delete_checkboxorg').click(function(){
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
  var checkbox = $('.delete_checkboxorg:checked');
  if(checkbox.length > 0)
  {
   var checkbox_value = [];
   $(checkbox).each(function(){
    checkbox_value.push($(this).val());
   });
   $.ajax({
    // url:"https://allegient.team365.io/organizations/delete_bulk",
    url:"<?= base_url('organizations/delete_bulk'); ?>",
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

<script>
function refreshPage(){
    window.location.reload();
} 
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">

$("#gstinId").keyup(function () {  
 var inputvalues = $(this).val();  
 var reggstTow = /^([0-9])+$/;
 var reggstSev = /^([0-9]){2}([a-zA-Z])+$/;
 var reggstEl = /^([0-9]){2}([a-zA-Z]){5}([0-9])+$/;
 var reggstTw = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z])+$/;
 var reggstTh = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9])+$/;
 var reggstFo = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z])+$/;
 var reggstFi = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([a-zA-Z0-9])+$/;
 var strLen = inputvalues.length;
 if(strLen>0 && strLen<3 && !reggstTow.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>2 && strLen<8 && !reggstSev.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>7 && strLen<12 && !reggstEl.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>11 && strLen<13 && !reggstTw.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>12 && strLen<14 && !reggstTh.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>13 && strLen<15 && !reggstFo.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if((strLen>14 && !reggstFi.test(inputvalues)) || strLen>15){
	$(this).css('border-color','red'); 
 }
 /*	 
if(!reggst.test(inputvalues)){
  alert('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');
}*/
//07AAMCA0717H1ZU
}); 


$('#gstinId').change(function(){
    $('#gstin_error').text(''); 
    $('#country_org').val('');
    $('#states_org').val('');
    $('#state_id').val('');
    $('#panno').val('');
    var gstin =  $('#gstinId').val();
 if(gstin.length == 15){
     
     var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

    if (gstinformat.test(gstin)) {
    var tin = gstin.substring(0, 2);
    var panno =gstin.substring(2, 12);
    //alert(tin);
        $.ajax({ 
                url: "<?= site_url('login/fetchstatebytin');?>",
                data: {tin: tin},
                dataType: "json",
                type: "POST",
                success: function(data){
                    //console.log(data.country);
                    $('#country_org').val(data.country);
                    $('#states_org').val(data.state);
                    $('#state_id').val(data.state_id);
                }    
        });
   
    $('#panno').val(panno);
    }else{
    $('#gstin_error').text('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');
     setTimeout(function(){ $('#gstin_error').text(''); },4000);
   }
 }else{
    $('#gstin_error').text('Enter max 15 digit'); 
    setTimeout(function(){ $('#gstin_error').text(''); },3000);
 }
});

$('#gstinId').keypress(function(){
   $('#gstin_error').text('');
});

$(document).ready(function(){
  $('#country_org').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $('#country_org').val(ui.item.label);
      $('#country_ids').val(ui.item.values);
      return false;
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#states_org').autocomplete({
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
    //source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $('#states_org').val(ui.item.label);
      $('#state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#cities_org').autocomplete({
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
    //source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#s_country_org').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#s_country_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_states_org').autocomplete({
      source: function(request, response) {
           var country_id =$('#s_country_id').val();
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
      $('#s_state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_cities_org').autocomplete({
      source: function(request, response) {
           var state_id =$('#s_state_id').val();
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
		