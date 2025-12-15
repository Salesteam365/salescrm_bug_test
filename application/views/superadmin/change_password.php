<?php $this->load->view('superadmin/common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
 
 
 <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url('superadmin/');?>home">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
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
                <form action="#" id="form" class="form-horizontal">
                  <div class="row">
				  <div class="col-md-1 mt-4">
				  </div>
                    <div class="col-md-10 mt-4">
                      <label class="">Old Password</label>
                        <input type="password" class="form-control form-control-sm" placeholder="Enter old password" name="oldpass" id="oldpass" autocomplete="nope">
                    </div>
					<div class="col-md-1 mt-4">
				  </div><div class="col-md-1 mt-4">
				  </div>
                    <div class="col-md-10 mt-4">
                      <label class="">New Password</label>
                      <input type="password" name="newpass" id="newpass" placeholder="Enter new password" class="form-control form-control-sm"  autocomplete="nope">
                    </div>
					<div class="col-md-1 mt-4">
				  </div>
				  
				  <div class="col-md-1 mt-4">
				  </div>
                    <div class="col-md-10 mt-4">
                      <label class="">Confirm New Password</label>
                      <input type="password" name="connewpass" id="connewpass" placeholder="Enter confirm new password" class="form-control form-control-sm" autocomplete="nope">
                    </div>
					<div class="col-md-1 mt-4">
				    </div>
					
					
					<div class="col-md-1 mt-4">
				    </div>
                    <div class="col-md-10 mt-4">
                      <label id="msgDIv"></label>
                    </div>
					<div class="col-md-1 mt-4">
				    </div>
					
					<div class="col-md-1 mt-4">
				    </div>
                    <div class="col-md-10 mt-4">
                      <button id="btnSave" onclick="save()" type="button" class="btn btn-info btn-sm" style="border-radius: 0; padding: 10px 30px;">Update</button>
                    </div>
					<div class="col-md-1 mt-4">
				    </div>
					
					
                  </div>
                </form>
              </div>
            </div>
        </div>
      </section>
  </div>
  

</div>
<!-- ./wrapper -->

<style>
.bgclr{
	background: #066675;
}
</style>

<!-- common footer include -->
<?php $this->load->view('superadmin/common_footer');?>

<script>
 

   /****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

function changeTxt(){
  setTimeout(function(){ $("#msgDIv").html(''); },3000);
}

  
function checkValidationVendor(){

  var oldpass		=$('#oldpass').val();
  var newpass		=$('#newpass').val();
  var connewpass	=$('#connewpass').val();
  

    if(oldpass=="" || oldpass===undefined){
      changeClr('oldpass');
      return false;
    }else if(newpass=="" || newpass===undefined){
      changeClr('newpass');
      return false;
    }else if(newpass=="" || newpass===undefined){
      changeClr('newpass');
      return false;
    }else if(newpass.length < 8 || newpass===undefined){
      changeClr('newpass');
	  $("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Password must be at least 8 characters');
	  changeTxt();
      return false;
    }else if(newpass!=connewpass){
      changeClr('connewpass');
	  $("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Must match the previous new password.');
	  changeTxt();
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
  
  
  
    function save()
    { 
		if(checkValidationVendor()==true){	
			var url = "<?= base_url('superadmin/Change_password/checkPass')?>";
			$('#btnSave').text('Checking..'); 
			$('#btnSave').attr('disabled',true);
			$.ajax({
				  url : url,
				  type: "POST",
				  data: $('#form').serialize(),
				  dataType: "JSON",
				  success: function(data)
				  { 
					if(data.status==true) 
					{
						$('#btnSave').text('Updating...'); 
					    $('#btnSave').attr('disabled',true);
						var url = "<?= base_url('superadmin/Change_password/changePass')?>";
						$.ajax({
						  url : url,
						  type: "POST",
						  data: $('#form').serialize(),
						  dataType: "JSON",
						  success: function(data)
						  {
							 $("#msgDIv").html(data.status);
							 changeTxt();
							 $('#form')[0].reset();
							 $('#btnSave').text('Update'); 
							 $('#btnSave').attr('disabled',false);
						  }
						});
					}else{
						$("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Your old password missmatch');
						changeTxt();
						$('#btnSave').text('Update'); 
					    $('#btnSave').attr('disabled',false);
					}
					
				  }
			});
		}
    }
  
  

</script>