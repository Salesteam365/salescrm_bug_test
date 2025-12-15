<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
 
<style>
  form{
    width: 75%;
    margin: 0 auto; 
  }
.content .card .card-body form label {
  font-weight: 500;
  font-size: 14px;
  margin-right: 10px;
  display: inline-block;
}
.content .card .card-body form input[type=checkbox], .content .card .card-body form input[type=radio]{
  margin-right: 5px;
}
.content .card .card-body form .form-control {
  font-size: 14px;
  border: 1px solid #ccc;
}
</style>
 <div class="content-wrapper" style="min-height: 191px;">
    <!-- Content Header (Page header) -->
     <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Email Integration</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
              <li class="breadcrumb-item active">Email Integration</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <!--<section class="content">
      <div class="container-fluid">
            <div class="card org_div">
              <!-- /.card-header 
              <div class="card-body">
                <form action="#" id="form" class="form-horizontal">
                  <div class="row">
				  <div class="col-md-2 mt-4">
				  </div>
                    <div class="col-md-8 mt-4">
                      <label class="">Email Id</label>
                        <input type="text" class="form-control " placeholder="Enter email id" name="email_id" id="email_id">
						<span id="email_id_error"></span>
                    </div>
					<div class="col-md-2 mt-4">
				  </div><div class="col-md-2 mt-4">
				  </div>
                    <div class="col-md-8 mt-4">
                      <label class="">Email Password</label>
                      <input type="text" name="email_pass" id="email_pass" placeholder="Enter email password" class="form-control">
					  <span id="email_pass_error"></span>
                    </div>
					<div class="col-md-2 mt-4">
				  </div>
				  
				  <div class="col-md-2 mt-4">
				    </div>
                    <div class="col-md-8 mt-4">
                      <label id="msgDIv"></label>
                    </div>
					<div class="col-md-2 mt-4">
				    </div>
				  
					<div class="col-md-2 mt-4">
				    </div>
                    <div class="col-md-8 mt-4">
                      <button id="btnSave" onclick="save()" type="button" class="btn btn-info btn-sm" style="border-radius: 0; padding: 10px 30px;">Save</button>
                    </div>
					<div class="col-md-2 mt-4">
				    </div>
					
					
                  </div>
                </form>
              </div>
            </div>
        </div>
      </section>-->
      
      <!-- Content Wrapper. Contains page content 
  <div class="content-wrapper">-->
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

 

    <!-- Main content -->

 

    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
          <div class="card org_div">
            <!-- /.card-header -->
            <div class="card-body">
              <form id="form_data" class="form-horizontal" method="post">
                <!--<div class="row form-group">
                  <div class="col-md-12">
                    <label>
                      <input type="checkbox" name="">Active
                    </label>
                  </div>
                </div>-->
                 <label id="msgDIv"></label>
                
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>SMTP Host<span style="color: #f76c6c;">*</span></label>
                    <input type="text" name="smtp_host" id="smtp_host" value="<?php if(isset($all_email)){ echo $all_email['smtp_host']; } ?>" class="form-control" placeholder="SMTP Host (smtp.gmail.com)">
                    <span id="smtp_host_error"></span>
                  </div>
                  <div class="col-md-6">
                    <label>Email address (Login)<span style="color: #f76c6c;">*</span></label>
                    <input type="email" class="form-control" placeholder="Emailid (example@domain.com)" name="email_id" id="email_id" value="<?php if(isset($all_email)){ echo $all_email['email_id']; } ?>">
						<span id="email_id_error"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>Password<span style="color: #f76c6c;">*</span></label>
                    <div class="input-group mb-2 mr-sm-2">
                        <input type="password" class="form-control"  name="email_pass" id="email_pass" value="<?php if(isset($all_email)){ echo $all_email['email_password']; } ?>" placeholder="Type Your Password">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-eye-slash" id="eye"></i></div>
                      </div>
                    </div>
					  <span id="email_pass_error"></span>
                  </div>
                  <div class="col-md-6">
                    <label>Encryption<span style="color: #f76c6c;">*</span></label><br>
                      <label><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='tls'){ echo 'checked'; } } ?> value="tls">TLS</label>
                      <label><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='ssl'){ echo 'checked'; } } ?> value="ssl">SSL</label>
                      <label><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='STARTTLS'){ echo 'checked'; } } ?> value="STARTTLS">STARTTLS</label>
                      <span id="encryption_type_error"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>Folder Retrieve Folders<span style="color: #f76c6c;">*</span></label>
                    <select class="form-control" name="folder_name" id="folder_name">
                      <option value="inbox" selected="">Inbox</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Port<span style="color: #f76c6c;">*</span></label>
                    <input type="text" name="gmail_port" id="gmail_port" value="<?php if(isset($all_email)){ echo $all_email['gmail_port']; } ?>" placeholder="Port (587)" class="form-control">
                    <span id="gmail_port_error"></span>
                  </div>
                </div>
                <!--<div class="row form-group">
                  <div class="col-md-12">
                    <label><input type="checkbox" name="" checked=""><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="The script will auto set the email to opened after check. This is used to prevent checking all the emails again and again. Its not recommended to uncheck this option if you have a lot emails and you have setup a lot forwarding to the email you setup for leads"></i>Only check non opened emails</label>
                  </div>
                  <div class="col-md-12">
                    <label><input type="checkbox" name="" checked=""><i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="Used for further review on the submission and take the necessary action"></i>Create task if email sender is already customer and assign to responsible staff member.</label>
                  </div>
                  <div class="col-md-12">
                    <label><input type="checkbox" name="">Delete mail after import?</label>
                  </div>
                  <div class="col-md-12">
                    <label><input type="checkbox" name="">Auto mark as public</label>
                  </div>
                </div>-->
                <?php if(isset($all_email)){ ?> <input type="hidden" name="config_id" value="<?php echo $all_email['id'] ?>"> <?php  }else{ ?> <input type="hidden" name="config_id" value="add_new_config"><?php } ?>
                <div class="row form-group">
                  <div class="col-md-12">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-info w-25"><?php if(isset($all_email)){ echo 'Update'; }else{ echo 'Save'; } ?></button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- /.Main content -->

 


  <!-- /.content-wrapper 
	  
	  <section class="content">
      <div class="container-fluid">
        <!-- Main row 
         <!-- Map card 
            <div class="card org_div">
              <!-- /.card-header 
              <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <!-- <th><button class="btn btn-danger btn-sm" type="button" name="delete_all" id="delete_all" style="font-size:10px;"><i class="fa fa-trash text-light"></i></button></th> 
                            
                            <th class="th-sm">Email ID</th>
                            <th class="th-sm">Status</th>
                            <th class="th-sm">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody>
					 
                    <?php  foreach($all_email as $email){ ?>
					<tr>
					    <td class="th-sm"><?=$email['email_id']; ?></td>
                        <td class="th-sm"><?=$email['status']==1?'Active':'Non-Active'; ?></td>
                        <td class="th-sm"><a href="<?php echo base_url('mail_details/ajax_label_table/'.$email['id']) ?>">View</a></td>
					</tr>
					<?php } ?>
					 
                    </tbody>
                </table>
              </div>
              <!-- /.card-body 
            </div>
        <!-- /.row (main row) 
      </div><!-- /.container-fluid 
    </section>-->
	  
  </div>
  
  
 
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
  var table;
//$(document).ready(function () {
  table = $('#ajax_datatable').DataTable({
        /*"processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?= base_url('mail_details/ajax_label_table')?>",
            "type": "POST",
            "data" : function(data)
             {
                data.searchDate = $('#date_filter').val();
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        },
        ],*/
    });
    
    $('#date_filter').change(function(){
      table.ajax.reload();
    });


   /****** VALIDATION FUNCTION*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color','');  },3000);
}

$('#email_id').keypress(function(){
    $("#email_id_error").html('');
	
});
$('#email_pass').keypress(function(){
    $("#email_pass_error").html('');
  });

  
function checkValidationMail(){

  var smtp_host		    =$('#smtp_host').val();
  var email_id		    =$('#email_id').val();
  var email_pass		=$('#email_pass').val();
  var encryption_type	=$('[name="encryption_type"]').is('checked');
  //alert(encryption_type);
  var gmail_port	    =$('#gmail_port').val();
  
 
  
    if(smtp_host=="" || smtp_host===undefined){
      changeClr('smtp_host');
      return false;
    }else if(email_id=="" || email_id===undefined){
      changeClr('email_id');
      return false;
    }else if(email_pass=="" || email_pass===undefined){
      changeClr('email_pass');
      return false;
    }else  if($('input[name="encryption_type"]:checked').length == 0) {
        $('#encryption_type_error').html('<p style="color:red">Please ckeck any one.</p>');
      //changeClr('email_pass');
      return false;
    }else if(gmail_port=="" || gmail_port===undefined){
      changeClr('gmail_port');
      return false;
    }else{
         $('#encryption_type_error').html('');
      return true;
    } 
}
 
$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});

 $('input[name="encryption_type"]').click(function(){

   $('#encryption_type_error').html('');
});
  
   
  
    function save()
    { 
        
        $("#smtp_host_error").html('');
		$("#encryption_type_error").html('');
		$("#gmail_port_error").html('');
	    $("#email_id_error").html('');
		$("#email_pass_error").html('');
		var addconfig = $("input[name='config_id']").val();
		if(checkValidationMail()==true){
		    var redirect_url =  "<?= base_url('mail_details')?>";
		    
			    var url = "<?= base_url('mail_details/add_mailDetails')?>";
		   
			$('#btnSave').text('Saving..'); 
			$('#btnSave').attr('disabled',true);
			$.ajax({
				  url : url,
				  type: "POST",
				  data: $('#form_data').serialize(),
				  dataType: "JSON",
				  success: function(data)
				  { 
				      console.log(data);
					if(data.status==true) 
					{
						$('#btnSave').text('Save'); 
					    $('#btnSave').attr('disabled',false);
					    if(addconfig == 'add_new_config'){
						   $("#msgDIv").html('<i class="fa fa-check" style="color:green"></i>&nbsp;&nbsp;Data inserted successfully');
					    }else{
					        $("#msgDIv").html('<i class="fa fa-check" style="color:green"></i>&nbsp;&nbsp;Data upadted successfully');
					    }
						setTimeout(function(){ $("#msgDIv").html(''); window.location.href = redirect_url;   },3000);
					}else{
						 $("#msgDIv").html('<i class="fas fa-exclamation-triangle" style="color:red"></i>&nbsp;&nbsp;Some error occure!');
						 setTimeout(function(){ $("#msgDIv").html(''); },3000);
					} 
						
					if(data.st==202){
					    $("#smtp_host_error").html(data.smtp_host);
						$("#email_id_error").html(data.email_id);
						$("#email_pass_error").html(data.email_pass);
					    $("#encryption_type_error").html(data.encryption_type);
		                $("#gmail_port_error").html(data.gmail_port);
						$('#btnSave').text('Save'); 
					    $('#btnSave').attr('disabled',false);
					}
					
				  }
			});
		}
    }
  


$(function(){
  
  $('#eye').click(function(){
       
        if($(this).hasClass('fa-eye-slash')){
           
          $(this).removeClass('fa-eye-slash');
          
          $(this).addClass('fa-eye');
          
          $('#email_pass').attr('type','text');
            
        }else{
         
          $(this).removeClass('fa-eye');
          
          $(this).addClass('fa-eye-slash');  
          
          $('#email_pass').attr('type','password');
        }
    });
});

</script>