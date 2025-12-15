<?php $this->load->view('superadmin/common_navbar'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Admin Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Admin Details</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
	        <b>From Date</b>	  
            <input type="date" placeholder="From Date" value="" id="fromDate"></div>
	      <div class="col-lg-2">
	        <b>To Date</b>
	        <input type="date" placeholder="To Date" value="" id="toDate">
    <!--<button class="btn btn-info" id="date_filter" title="Search Attendance">Filter</button>-->

           <!--<div class="first-one">
                <select class="form-control" name="date_filter" id="date_filter">
                  <option selected disabled>Select Date</option>
                  <option value="This Week">This Week</option>
                  <?php $week = strtotime("-7 Day"); ?>
                  <option value="<?= date('y.m.d', $week); ?>">Last Week</option>
                  <?php $fifteen = strtotime("-15 Day"); ?>
                  <option value="<?= date('y.m.d', $fifteen); ?>">Last 15 days</option>
                  <?php $thirty = strtotime("-30 Day"); ?>
                  <option value="<?= date('y.m.d', $thirty); ?>">Last 30 days</option>
                  <?php $fortyfive = strtotime("-45 Day"); ?>
                  <option value="<?= date('y.m.d', $fortyfive); ?>">Last 45 days</option>
                  <?php $sixty = strtotime("-60 Day"); ?>
                  <option value="<?= date('y.m.d', $sixty); ?>">Last 60 days</option>
                  <?php $ninty = strtotime("-90 Day"); ?>
                  <option value="<?= date('y.m.d', $ninty); ?>">Last 3 Months</option>
                  <?php $six_month = strtotime("-180 Day"); ?>
                  <option value="<?= date('y.m.d', $six_month); ?>">Last 6 Months</option>
                  <?php $one_year = strtotime("-365 Day"); ?>
                  <option value="<?= date('y.m.d', $one_year); ?>">Last 1 Year</option>
                </select>
            </div>-->
          </div>
         
		  <div class="col-lg-4" style="margin-top:17px;">
		    <div class="col-md-6 mb-3">
                <select class="form-control" name="account_type" id="account_type">
                    <option value="">Select Account Type</option>
                    <option value="Trial">Trial</option>
                    <option value="Paid">Paid</option>
					
                </select>
            </div>
		  </div>
          <div class="col-lg-12">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
				  <!--<button class="btn btn-info btn-sm" style="width:135px;" onclick="import_excel()">Import&nbsp;Excel</button
                  <button class="btn btn-info btn-sm" onclick="add_form()">Add New</button>-->
				 <button class="btn btn-info btn-sm"> <a href="<?php echo base_url('login'); ?>" style="color:white;"><b>User</b></a></button>
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
                           <!-- <?php if($this->session->userdata('delete_org')=='1'):?>
                              <th><button class="btn" type="button" name="delete_all" id="delete_all"><i class="fa fa-trash text-light"></i></button></th>
                            <?php endif; ?>-->
							<th class="th-sm">#</th>
							<th class="th-sm">Ragistration Date</th>
							<th class="th-sm">Name</th>
                            <th class="th-sm">Company Name</th>
                            <th class="th-sm">Activation Date</th>                            
							<th class="th-sm">Account Type</th>
							<th class="th-sm">Product Type</th>
							<th class="th-sm">Trial/Paid End Date</th>
                            <th class="th-sm">Mobile</th>
                            <th class="th-sm">User Type</th>
							<th class="th-sm">status</th>
							<th class="th-sm">Details</th>
                            
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$i=1;
					//print_r($all_admin);
					foreach($all_admin as $admin): ?>
					<tr>
					    <td><?php echo $i++; ?></td>
						<td><?php echo date('d M Y',strtotime($admin['created_date'])); ?></td>
						<td><?php echo $admin['admin_name']; ?></td>
						<td><?php echo $admin['company_name']; ?></td>
						<td><?php echo  date('d M Y',strtotime($admin['activation_date'])); ?></td>
						<td><?php echo $admin['account_type']; ?></td>
						<td><?php echo $admin['product_type']; ?></td>
						<td><?php echo date('d M Y',strtotime($admin['trial_end_date'])); ?></td>						
					    <td><?php echo $admin['admin_mobile']; ?></td>
					     <td><?php echo $admin['user_type']; ?></td>
						<td>
						<select class="form-control change_status" onchange="change_status('.$admin['id'].')" name="update_status"  >
                           <option value="1" <?php  if($admin['active'] ==1 ) { echo 'selected'; } ?>>Active</option>
                           <option value="0" <?php  if($admin['active'] ==0 ) { echo 'selected'; } ?>>Non-active</option>
                       </select>
				         </td>
						 <td><a href="" data-toggle="modal" data-target="#view_admindetails<?=$admin['id'] ?>">View</a></td>
					</tr>
					<?php endforeach; ?>
					
					
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
  
    <!-- View admin details  modal -->
	<?php 

	foreach($all_admin as $admin):
	
	?>
<div class="modal fade show" id="view_admindetails<?=$admin['id'] ?>" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edits">Admin details</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
          <form id="view" class="row" action="#">
            <div class="col-sm-12">
              <h5 class="text-primary" id="org_name"></h5>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Admin&nbsp;Name:</b>
			  <h6 class="text-primary" ><?=$admin['admin_name'] ?></h6>
			  
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company Name:</b><h6 class="text-primary"><?=$admin['company_name'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company&nbsp;Website:</b><h6 class="text-primary" ><?=$admin['company_website'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Email:</b><h6 class="text-primary"><?=$admin['admin_email'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Mobile:</b><h6 class="text-primary" id="mobile"><?=$admin['admin_mobile'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company Mobile:</b><h6 class="text-primary"><?=$admin['company_mobile'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company Email:</b><h6 class="text-primary"><?=$admin['company_email'] ?></h6>
            </div>
			<div class="col-sm-6">
              <b class="text-secondary">Trail End Date:</b><h6 class="text-primary"><?=$admin['trial_end_date'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company&nbsp;Gstin:</b><h6 class="text-primary"><?=$admin['company_gstin'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Pan&nbsp;No:</b><h6 class="text-primary"><?=$admin['pan_number'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">CIN:</b><h6 class="text-primary"><?=$admin['cin'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Type:</b><h6 class="text-primary"><?=$admin['type'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Terms&nbsp;Condition Customer:</b><h6 class="text-primary"><?=$admin['terms_condition_customer'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Terms&nbsp;Condition Seller:</b><h6 class="text-primary"><?=$admin['terms_condition_seller'] ?></h6>
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Account Type:</b><h6 class="text-primary"><?=$admin['account_type']; ?></h6>
            </div>
			 <div class="col-sm-6">
              <b class="text-secondary">Last Login:</b><h6 class="text-primary"><?=date('d M Y h:i a',strtotime($admin['last_login'])); ?></h6>
            </div>
			<div class="col-sm-6">
              <b class="text-secondary">Login Count:</b><h6 class="text-primary"><?=$admin['login_count']; ?></h6>
            </div>
            <div class="col-sm-12">
              <h5>Address&nbsp;Details:</h5>
            </div>
            <div class="col-sm-3">
              <b class="text-secondary">Country:</b><h6 class="text-primary"><?=$admin['country'] ?></h6>
            </div>
            <div class="col-sm-3">
              <b class="text-secondary">State:</b><h6 class="text-primary"><?=$admin['state'] ?></h6>
            </div>
           
            <div class="col-sm-3">
              <b class="text-secondary">City:</b><h6 class="text-primary"><?=$admin['city'] ?></h6>
            </div>
            <div class="col-sm-3">
              <b class="text-secondary">Zipcode:</b><h6 class="text-primary"><?=$admin['zipcode'] ?></h6>
            </div>
          
            <div class="col-sm-12">
              <b class="text-secondary">Company&nbsp;Address:</b><h6 class="text-primary"><?=$admin['company_address'] ?></h6>
            </div>
			<br><br>
			<?php
				   $ci =&get_instance();
                   $ci->load->model(array('Login_model','superadmin/home_model'));
                   $standared_users = $ci->Login_model->get_all_standarduser($admin['company_email'],$admin['company_name']);   
				  //print_r($standared_users);
				  $all_organization  = $ci->home_model->get_allOrganization($admin['company_email'],$admin['company_name']);   
				?>
				
             <div class="col-sm-4">
              <b class="text-secondary">No Of Users:</b><h6 class="text-primary"><?=$standared_users->num_rows(); ?></h6> 
			  <button><a href="<?php echo base_url('superadmin/view_userDetails/'.$admin['id']); ?>" style="color:black;" >View User</a></button>
			  <button type="button" onclick="update_trial('<?=$admin['id']?>')"><a href="" data-toggle="modal" data-target="#extend_trial<?=$admin['id']?>" style="color:black;" >Extend Trial</a></button>
            </div>
			<div class="col-sm-4">
              <b class="text-secondary">No Of Organization:</b><h6 class="text-primary"><?=$all_organization->num_rows(); ?></h6>
            </div>
            
          </form>
        </div>
    </div>
  </div>
</div>
<?php 
endforeach;
?>

<!-- View modal -->


  
<div class="modal fade show" id="extend_trial" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="organization_add_edits">Extend Trial</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body form">
          <form id="extend_trial_id" class="row" action="#">
            <div class="col-sm-12">
              <h5 class="text-primary" id="org_name"></h5>
            </div>
            <div class="col-sm-6">
			  <input type="hidden" name="ext_date" id="ext_date" value="" >
              <b class="text-secondary">Admin&nbsp;Name:</b>
			  <h3 class="text-primary" id="admin_name"></h3>
			  <input type="hidden" name="admin_name" value="">
            </div>
            <div class="col-sm-6">
              <b class="text-secondary">Company Name:</b>
			  <h3 class="text-primary" id="company_name"></h3>
			  <input type="hidden" name="company_name" value="">
            </div>
           
           
            <div class="col-sm-3">
              <b class="text-secondary">Trail End Date:</b>
			  <input type="date" name="extend_date" id="extend_date" value="">
			   
            </div>
			<br><br>
             <div class="col-sm-4">
			  <button type="button" onclick="extends_trails()" id="extnd_date" style="margin-left: 8em;margin-top: 2em;}">Update</button>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>

<!-- Extend Trial modal -->

<!-- common footer include -->
<?php $this->load->view('superadmin/common_footer');?>

<script>
  function import_excel()
  {
    $('#modal_import_org').modal('show'); // show bootstrap modal
    $('#file').val('');
    $("#excel_table").hide();
    $("#duplicate_entry").empty();
    $("#import_button").attr('disabled',false);
  }
</script>
<script>
$(document).ready(function(){
  $("#excel_table").hide();
 $('#import_form').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>organizations/import",
   method:"POST",
   data:new FormData(this),
   dataType : 'JSON',
   contentType:false,
   cache:false,
   processData:false,
   success:function(response)
   {
	   console.log(response);
    if(response.st == 202)
    {
      $('#file').val('');
      alert(response.msg);
    }
    else if(response.st == 200)
    {
      $('#file').val('');
      alert(response.msg);
      $('#modal_import_org').modal('hide');
      table.ajax.reload(null,false); //reload datatable ajax
    }
    else 
    {
      // To append the Excel data
      $.each(response, function() 
      {
        $("#excel_table").show();
        var message = "<tr><td>"+this.org_name+"</td><td>"+this.email+"</td><td>"+this.primary_contact+"</td></tr>";
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
$(document).ready(function () {
    <?php //if($this->session->userdata('superretrieve_org')=='1'): ?>
        var table;
        table = $('#ajax_datatable').DataTable({
               "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.
               // // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?= base_url('superadmin/home/ajax_list')?>",
                  "type": "POST",
                  "data" : function(data)
                  {
                      data.searchDate = $('#fromDate').val();
					  data.searchToDate = $('#toDate').val();
					  data.account_type = $('#account_type').val();
                  }
              },
             // //Set column definition initialisation properties.
              "columnDefs": [
              {
                "targets": [0], //last column
                "orderable": false, //set not orderable
              },
              ],
         });
         $('#toDate').change(function(){
			// alert('hello');
           table.ajax.reload();
        });
		 $('#account_type').change(function(){
           table.ajax.reload();
        });
    <?php //endif; ?>
});
</script>



<script>
//$(document).ready(function () {
	// $('.change_status').change(function(){
		function change_status(selected_id){
        //alert('hello'); 
	    var selected_data = $('.change_status').val();		
		// var data1 = $('#change_status').data();
		//alert(selected_data);
    $.ajax({
         url: "<?= base_url(); ?>superadmin/home/change_status",
         method: "POST",
         data: {selected_data:selected_data, selected_id:selected_id},
		dataType: "json", 
         success: function(data){
			//alert(data);
			
			 if(data == 200){
              // $('#success_msg').html('Status Successfully Updated');
			   alert('Status Successfully Updated');
			 }else{
			    alert('Some Error Occure');
			 }
         }
        });
        };
       
        //});
 
</script>
<script>
$(document).ready(function () {
	 $('.change_userstatus').change(function(){
       
	    var selected_data = $(this).val();
		var selected_id = $(this).prop('id'); 
		//var selected_id = $(this).attr("data-target");
		// var data1 = $('#change_status').data();
		//alert(selected_data);
		//alert(selected_id);
    $.ajax({
         url: "<?= base_url(); ?>superadmin/home/change_userStatus",
         method: "POST",
         data: {selected_data:selected_data, selected_id:selected_id},
		dataType: "json", 
         success: function(data){
		  //alert(data);
			
			 if(data == 200){
              // $('#success_msg').html('Status Successfully Updated');
			   alert('Status Successfully Updated');
			 }else{
			    alert('Some Error Occure');
			 }
         }
        });
        });
       
        });

</script>

<script>
 $(document).ready(function () {
	 
  $('.status_filter').change(function(){
	   var searchDate = $(this).val();
        // var searchDate = $('.status_filter').val(); 
		// alert(searchDate);
		   $.ajax({
                url:"<?=base_url('superadmin/home/status_filters')?>",
                method:"POST",
			   data:{searchDate:searchDate},
          success:function(data){
			 // alert(data);
          $('#result').html(data);
        }
		  });
    });
 });
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
    function check_org()
    {
      var org_name = $('#org_name_check').val();
      if(org_name != ''){
        $.ajax({
         url: "<?= base_url(); ?>organizations/check_org",
         method: "POST",
         data: {org_name:org_name},
         success: function(data){
          $('#org_name_error').html(data);
         }
        });
      }
    }
    <?php if($this->session->userdata('create_org')=='1'): ?>
        function add_form()
        {
          save_method = 'add';
          $("#save_method").val('add');
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string
          $('#modal_form').modal('show'); // show bootstrap modal
          $('.modal-title').text('Add Organization'); // Set Title to Bootstrap modal title
          $("#add").find("tr").remove();
          var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
          "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control form-control-sm' type='text' placeholder='Contact Name'></td>"+
          "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control form-control-sm' type='text' placeholder='Email'></td>"+
          "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control form-control-sm start' type='text' placeholder='Work Phone'></td>"+
          "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control form-control-sm' type='text' placeholder='Mobile'></td></tr>";
          $("#add").append(markup);
          $("#add_row").show();
          $("#delete_row").show();
		  $("#org_name_check").attr('readonly', false);
          // Reset Form Errors
          $("#org_name_error").html('');
          $("#primary_contact_error").html('');
          $("#email_error").html('');
          $("#office_phone_error").html('');
          $("#mobile_error").html('');
          $("#gstin_error").html('');
          $("#billing_country_error").html('');
          $("#billing_state_error").html('');
          $("#shipping_country_error").html('');
          $("#shipping_state_error").html('');
          $("#billing_city_error").html('');
          $("#billing_zipcode_error").html('');
          $("#shipping_city_error").html('');
          $("#shipping_zipcode_error").html('');
          $("#billing_address_error").html('');
          $("#shipping_address_error").html('');
          $('#btnSave').text('Save'); //change button text
        }
    <?php endif; ?>
	
	
	/****** VALIDATION FUNCTION FOR ORG*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

function checkValidation(){
  var org_name_check=$('#org_name_check').val();
  var primary_contact=$('#primary_contact_org').val();
  var emailId=$('#emailId').val();
  var mobileId=$('#mobileId').val();

  var typeId=$('#typeId').val();
  var industryId=$('#industryId').val();
  var regionID=$('#regionID').val();

  var country=$('#country').val();
  var states=$('#states').val();
  var cities=$('#cities').val();
  var billingZipcode=$('#billingZipcode').val();
  var billingAddress=$('#billingAddress').val();
  var s_country=$('#s_country').val();
  var s_states=$('#s_states').val();
  var s_cities=$('#s_cities').val();
  var shippingZipcode=$('#shippingZipcode').val();
  var shippingAddress=$('#shippingAddress').val();
  
    if(org_name_check=="" || org_name_check===undefined){
      changeClr('org_name_check');
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
    }else if(typeId=="" || typeId===undefined || typeId===null){
      changeClr('typeId');
      $('#forTarget1').click();
      return false;
    }else if(industryId=="" || industryId===undefined || industryId===null){
      changeClr('industryId');
      $('#forTarget1').click();
      return false;
    }else if(regionID=="" || regionID===undefined || regionID===null){
      changeClr('regionID');
      $('#forTarget1').click();
      return false;
    }else if(country=="" || country===undefined || country===null){
      changeClr('country');
      $('#forTarget2').click();
	  console.log('country');
      return false;
    }else if(states=="" || states===undefined || states===null){
      changeClr('states');
      $('#forTarget2').click();
	  console.log('state');
      return false;
    }else if(cities=="" || cities===undefined){
      changeClr('cities');
      $('#forTarget2').click();
	  console.log('city');
      return false;
    }else if(billingZipcode=="" || billingZipcode===undefined || billingZipcode===null){
      changeClr('billingZipcode');
      $('#forTarget2').click();
	  console.log('bzip');
      return false;
    }else if(billingAddress=="" || billingAddress===undefined){
      changeClr('billingAddress');
      $('#forTarget2').click();
	  console.log('address');
      return false;
    }else if(s_country=="" || s_country===undefined){
      changeClr('s_country');
      $('#forTarget2').click();
	  console.log('s_country');
      return false;
    }else if(s_states=="" || s_states===undefined){
      changeClr('s_states');
      $('#forTarget2').click();
	  console.log('s_states');
      return false;
    }else if(s_cities=="" || s_cities===undefined){
      changeClr('s_cities');
      $('#forTarget2').click();
	  console.log('s_cities');
      return false;
    }else if(shippingZipcode=="" || shippingZipcode===undefined){
      changeClr('shippingZipcode');
      $('#forTarget2').click();
	  console.log('s_zip');
      return false;
    }else if(shippingAddress=="" || shippingAddress===undefined){
      changeClr('shippingAddress');
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

	
	
	
    <?php if($this->session->userdata('create_org')=='1' || $this->session->userdata('update_org')=='1'): ?>
        function save()
        {
			if(checkValidation()==true){
          $('#btnSave').text('saving...'); //change button text
          $('#btnSave').attr('disabled',true); //set button disable
          var url;
          if(save_method == 'add') {
              url = "<?= base_url('organizations/create')?>";
          } else {
              url = "<?= base_url('organizations/update')?>";
          }
          // ajax adding data to database
          $.ajax({
              url : url,
              type: "POST",
              data: $('#form').serialize(),
              dataType: "JSON",
              success: function(data)
              {
                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                     window.location.reload();
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                if(data.st==202)
                {
                  $("#org_name_error").html(data.org_name);
                  $("#primary_contact_error").html(data.primary_contact);
                  $("#email_error").html(data.email);
                  $("#office_phone_error").html(data.office_phone);
                  $("#mobile_error").html(data.mobile);
                  $("#gstin_error").html(data.gstin);
                  $("#billing_country_error").html(data.billing_country);
                  $("#billing_state_error").html(data.billing_state);
                  $("#shipping_country_error").html(data.shipping_country);
                  $("#shipping_state_error").html(data.shipping_state);
                  $("#billing_city_error").html(data.billing_city);
                  $("#billing_zipcode_error").html(data.billing_zipcode);
                  $("#shipping_city_error").html(data.shipping_city);
                  $("#shipping_zipcode_error").html(data.shipping_zipcode);
                  $("#billing_address_error").html(data.billing_address);
                  $("#shipping_address_error").html(data.shipping_address);
                  $("#error_msg").html('oops! there will be some error ');
                }
                else if(data.st==200)
                {
                  $("#org_name_error").html('');
                  $("#primary_contact_error").html('');
                  $("#email_error").html('');
                  $("#office_phone_error").html('');
                  $("#mobile_error").html('');
                  $("#gstin_error").html('');
                  $("#billing_country_error").html('');
                  $("#billing_state_error").html('');
                  $("#shipping_country_error").html('');
                  $("#shipping_state_error").html('');
                  $("#billing_city_error").html('');
                  $("#billing_zipcode_error").html('');
                  $("#shipping_city_error").html('');
                  $("#shipping_zipcode_error").html('');
                  $("#billing_address_error").html('');
                  $("#shipping_address_error").html('');
                  $("#error_msg").html('');
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
    <?php if($this->session->userdata('retrieve_org')=='1'): ?>
        function view(id)
        {
            $('#view')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $("#view_add").find("tr").not(':first').remove();
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo base_url('organizations/getbyId/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                  $('[id="org_name"]').text(data.org_name);
                  $('[id="created_date"]').text(data.datetime);
                  $('[id="ownership"]').text(data.ownership);
                  $('[id="primary_contact"]').text(data.primary_contact);
                  $('[id="email"]').text(data.email);
                  $('[id="website"]').text(data.website);
                  $('[id="office_phone"]').text(data.office_phone);
                  $('[id="mobile"]').text(data.mobile);
                  $('[id="employees"]').text(data.employees);
                  $('[id="industry"]').text(data.industry);
                  $('[id="assigned_to"]').text(data.assigned_to);
                  $('[id="annual_revenue"]').text(data.annual_revenue);
                  $('[id="type"]').text(data.type);
                  $('[id="region"]').text(data.region);
                  $('[id="sic_code"]').text(data.sic_code);
                  $('[id="sla_name"]').text(data.sla_name);
                  $('[id="gstin"]').text(data.gstin);
                  $('[id="billing_country"]').text(data.billing_country);
                  $('[id="billing_state"]').text(data.billing_state);
                  $('[id="shipping_country"]').text(data.shipping_country);
                  $('[id="shipping_state"]').text(data.shipping_state);
                  $('[id="billing_city"]').text(data.billing_city);
                  $('[id="billing_zipcode"]').text(data.billing_zipcode);
                  $('[id="shipping_city"]').text(data.shipping_city);
                  $('[id="shipping_zipcode"]').text(data.shipping_zipcode);
                  $('[id="billing_address"]').text(data.billing_address);
                  $('[id="shipping_address"]').text(data.shipping_address);
                  $('[id="description"]').text(data.description);
                  $('#view_popup').modal('show'); // show bootstrap modal when complete loaded
                  $('.modal-title').text('Organization'); // Set title to Bootstrap modal title
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error Retrieving Data From Database');
                }
            });
            $.ajax({
              url : "<?php echo base_url('organizations/getcontactById/')?>" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                $.each(data, function(i, item) 
                {
                  var markup = "<tr>"+
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
    <?php if($this->session->userdata('update_org')=='1'): ?>
      function update(id)
      {
        save_method = 'update';
        $("#save_method").val('update');
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $("#add").find("tr").remove();
        $("#add_row").hide();
        $("#delete_row").hide();
        $("#org_name_check").attr('readonly', true);
        // Reset Form Errors
        $("#org_name_error").html('');
        $("#primary_contact_error").html('');
        $("#email_error").html('');
        $("#office_phone_error").html('');
        $("#mobile_error").html('');
        $("#gstin_error").html('');
        $("#billing_country_error").html('');
        $("#billing_state_error").html('');
        $("#shipping_country_error").html('');
        $("#shipping_state_error").html('');
        $("#billing_city_error").html('');
        $("#billing_zipcode_error").html('');
        $("#shipping_city_error").html('');
        $("#shipping_zipcode_error").html('');
        $("#billing_address_error").html('');
        $("#shipping_address_error").html('');
        $('#btnSave').text('Update'); //change button text

        //Ajax Load data from ajax
        $.ajax({
          url : "<?php echo base_url('organizations/getbyId/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('[name="id"]').val(data.id);
            $('[name="sess_eml"]').val(data.sess_eml);
            $('[name="org_name"]').val(data.org_name);
            $('[name="ownership"]').val(data.ownership);
            $('[name="primary_contact"]').val(data.primary_contact);
            $('[name="email"]').val(data.email);
            $('[name="website"]').val(data.website);
            $('[name="office_phone"]').val(data.office_phone);
            $('[name="mobile"]').val(data.mobile);
            $('[name="employees"]').val(data.employees);
            $('[name="industry"]').val(data.industry);
            $('[name="assigned_to"]').val(data.assigned_to);
            $('[name="annual_revenue"]').val(data.annual_revenue);
            $('[name="type"]').val(data.type);
            $('[name="region"]').val(data.region);
            $('[name="sic_code"]').val(data.sic_code);
            $('[name="sla_name"]').val(data.sla_name);
            $('[name="gstin"]').val(data.gstin);
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
            $('[name="description"]').val(data.description);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Update Organization'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error Retrieving Data From Database');
          }
        });
        $.ajax({
          url : "<?php echo base_url('organizations/getcontactById/')?>" + id,
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
    <?php if($this->session->userdata('delete_org')=='1'):?>
      function delete_org(id)
      {
          if(confirm('Are you sure delete this data?'))
          {
              // ajax delete data to database
              $.ajax({
                  url : "<?= base_url('organizations/delete')?>/"+id,
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
			$('.show_div').removeClass('bgclr');
              jQuery('.targetDiv').hide();
              jQuery('#div'+$(this).attr('target')).show();
			  $(this).addClass('bgclr');
			  
        });
});
</script>

<script>
$(document).ready(function(){
  $(".add_row").click(function()
  {
    var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control form-control-sm' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control form-control-sm' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control form-control-sm start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control form-control-sm' type='text' placeholder='Mobile'></td>";
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
  $('#states').autocomplete({
    source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#cities').autocomplete({
    source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
  $('#s_country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_states').autocomplete({
    source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_cities').autocomplete({
    source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>

<!---Extend Trail Start-->
<script>
    function update_trial(ext_date_id)
	{
	   $('#extend_trial').modal('show');
	   $.ajax({
	   url: "<?php echo site_url('superadmin/home/getbyId/')?>" + ext_date_id,
		method: "GET",	
		dataType: "JSON",
		success: function(data)
		{
			//console.log(data);
			$('[id="ext_date"]').val(data.id);
			$('[id="admin_name"]').html(data.admin_name);
			$('[id="company_name"]').html(data.company_name);
			$('[id="extend_date"]').val(data.trial_end_date);
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error Retrieving Data From Database');
        }
	   });
	}
	
  function extends_trails()
  { 
     var ext_id=$("#ext_date").val();
     var admin_name=$("#admin_name").val();
     var company_name=$("#company_name").val();
     var extend_date=$("#extend_date").val();
      $("#extnd_date").html('<i class="fas fa-spinner fa-spin"></i>');
	 $.ajax({
        url: "<?= base_url(); ?>superadmin/home/update_extend",
         method: "POST",
         data: {ext_id:ext_id,extend_date:extend_date},
		 dataType: "JSON",
         success: function(data)
         {
			 //console.log(data);
			if(data.st==200){
			    $("#extnd_date").html('Update');
			    $("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Trial Date Extended successfully.');
			    $('#extend_trial').modal('hide');
				$("#alert_popup").modal('show');
				setTimeout(function(){ 
				    $("#alert_popup").modal('hide'); 
				    window.location.reload(); 
				    },3000);
			   
    		}else{
    		    $("#extnd_date").html('Update');
    			$("#common_popupmsg").html('<i class="fa fa-exclamation-triangle" style="color: red;"></i><br>Some error occure!');
				$("#alert_popup").modal('show');
				setTimeout(function(){ $("#alert_popup").modal('hide');  },3000);
    		}
         }
     });
    }
</script>