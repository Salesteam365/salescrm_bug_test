<?php $this->load->view('common_navbar');
?>
<style type="text/css">
  .achieved_red { color: #e85f7c !important; }
  .achieved_orange { color: orange !important; }
  .achieved_green { color: green !important; }
  select#date_filter {
    width: 350px;
}
button {
    color: #fff;
    background-color: #fdfdfd;
    border-color: #717575;
    width: 200px;
    height: 40px;
}
#org_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#org_datatable tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 14px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}
 

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Email Automation</h1>
			
          </div><!-- /.col -->
		   <!-- Export Data --> 
		  <div class="col-sm-4">
            
            
          </div><!-- /.col -->
		   
		 <div class="col-sm-4">
          
          </div><!-- /.col -->
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>#">Home</a></li>
              <li class="breadcrumb-item active">Sent Email</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <?php 
                            //        $fifteen = strtotime("-15 Day"); 
                            //        $thirty = strtotime("-30 Day"); 
                            //        $fortyfive = strtotime("-45 Day"); 
                            //        $sixty = strtotime("-60 Day"); 
                            //        $ninty = strtotime("-90 Day"); 
                            //        $six_month = strtotime("-180 Day"); 
                            //        $one_year = strtotime("-365 Day");
                            // ?>
         <div class="row mb-3">
         <div class="col-lg-2">
         <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
    <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>
</div>
                    <div class="col-sm-6  text-right">          
                       <!-- <button class="btn  btn-info" id="SendEmailBulk">Send Email In Bulk</button>-->
                    </div>
             </div>
             <div class="wrapper card p-4" style="border-radius:12px;border:none;box-shadow:0px;">
            <div class="card-header mb-2"><b style="font-size:21px;">Email Automation</b>
			 <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
					</div>
            <div class="card-body">
                <div class="table-responsive">
                <table id="org_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead>
					<tr>
					 <!-- <th>
					      <input type="checkbox" class="checkSingle" id="checkAll" value="allmail" >
					  </th>-->
						<th class="th-sm">Client Name</th>
						<th class="th-sm">Client Email</th>
						<th class="th-sm">Subject</th>
						<th class="th-sm">Status</th>
						<th class="th-sm">Sending Date</th>
						<th class="th-sm">Action</th>
					<!--	<th class="th-sm" id="count">Action
						</th>-->
					</tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
	
<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email Automation</h4>
        <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
	  <form method="post" action="" id="email_auto_form" enctype="multipart/form-data">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Client's Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control onlyLetters" name="clientname" value="" id="clientname">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" name="clientEmail" id="clientEmail" value="">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			<?php 
	  $session_comp_email = $this->session->userdata('company_email'); ?>
			  <input type="text" class="form-control" name="ccEmail" id="ccEmail" value="<?=$session_comp_email;?>">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
			</div>
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt" name="descriptionTxt"></textarea>
            </div>
			<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
			</div>
			<div class="col-md-12 lbl">
				<label for="">Image:</label>
			</div>
			<div class="col-md-12">
			  <input type="file"  name="images" id="images">
            </div>
          </div>
			<div class="row text-center" id="messageDiv" style="display:none; padding: 5%; " >	
			</div>
			<div class="row" id="footerDiv">
			    <div class="col-md-7" style="padding-top: 5%;"> </div>
				<div class="col-md-5 text-right" style="padding-top: 5%;">
					<button type="button" class="btn btn-info" id="sendEmail">Send Email</button>
				</div>
			</div>	
      </div>
	  </form>
    </div>
  </div>
</div>
    <!-- /.content -->
  </div>
<!-- common footer include -->

<!-- The Modal -->
<div class="modal fade" id="myModal" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Multiple Checkbox Mail</h4>
        <button type="button" class="close text-right" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <form method="post"   id="multi_email_auto" enctype="multipart/form-data">
                <div id="formDivsmult">
                <div class="row form-group" id="formDivsmult">
                     <div class="col-md-2"> 
                         <label>Subject</label>
                    </div>
                    <div class="col-md-10"> 
                    <input type="text" class="form-control" name="multi_subject" id="multi_subject" placeholder="Subject">
					<input type="hidden" class="form-control" name="all_email" id="all_email" value="">
					<input type="hidden" class="form-control" name="all_un_email" id="all_un_email" value="">
					
					</div>
                </div>
                <div class="row form-group">
                    <div class="col-md-2">
                    <label>Message</label>
                    </div>
                    <div class="col-md-10"> 
                    <textarea class="form-control" name="multi_description" id="multi_description" ></textarea>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12"> 
                        <label>Place image here</label>
                    </div>
                    <div class="col-md-12"> 
                        <input type="file" name="multi_image"  id="multi_image" placeholder="">
                    </div>
                </div>
                </div>
                <div class="row text-center" id="messageDivs" style="display:none; padding: 5%; " ></div>
            </form>
        </div>
        

      <!-- Modal footer -->
      <div class="modal-footer" id="footerDivs">
        <button type="submit" class="btn btn-info" id="all_sendEmail">Save</button>
      </div>

    </div>
  </div>
</div>


<?php $this->load->view('common_footer');?>

<script>
var editor = CKEDITOR.replace('descriptionTxt');
var multi_editor = CKEDITOR.replace('multi_description');
CKEDITOR.config.height='250px';
</script>
<script>
$(document).ready(function () {
    <?php if($this->session->userdata('retrieve_org')=='1'): ?>
        var table;
        table = $('#org_datatable').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?= base_url('Email_Marketing/sent_email_list')?>",
                "type": "POST",
                "data" : function(data)
                {
                    data.searchDate = $('#date_filter').val();
                    if($("#checkAll").prop('checked') == true){
                        data.checkall='checkedall';
                    }else{
                        data.checkall='not';
                    }
                }
            },
            //Set column definition initialisation properties.
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

$('#checkAll').click(function () {    
    $(':checkbox.select_checkbox').prop('checked', this.checked);    
 });
 
 


 
 $('#emailModel').change(function() {
    var opval = $(this).val();
    if(opval=="SendMessage"){
        $('#emailModel').modal("show");
    }
});

   
 function email_auto(userid){
	// alert(userid);
	 $.ajax({
	 url : "<?php echo base_url('Email_Marketing/getbyId/')?>/" +userid,
     method: "POST",
	 dataType: "JSON",
     success: function(data)
	 {   
	    //console.log(data);
		 $('[id="userid"]').val(data.id);
		 $('[id="clientname"]').val(data.primary_contact);
         $('[id="clientEmail"]').val(data.email);
         $('#emailModel').modal('show'); // show modal 
         $('.modal-title').text('Email Automation'); // Set title to Bootstrap modal title		 
	 }
   });
 } 
</script> 

<!--Single send email-->
 <script>
	$("#sendEmail").click(function(){
	var clientname   = $("#clientname").val();
	var clientEmail  = $("#clientEmail").val();
	var ccEmail      = $("#ccEmail").val();
	var subEmail     = $("#subEmail").val();
    
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	$("#descriptionTxt").val(descriptionTxt);
	var images          = $("#images").val();
	var form=$("#email_auto_form").get(0);
    var formData = new FormData(form);
	
   $("#sendEmail").attr('disabled',true);
   $.ajax({
     url: "<?= site_url(); ?>Email_Marketing/send_email",
		 method: "POST",
		 data:formData,
		 dataType: "JSON",
		 processData:false,
		 contentType:false,
		 cache:false,
		 success: function(dataSucc){
      if(dataSucc.status==1){
		    $("#formDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email has been sent successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ 
			     $('#emailModel').modal('hide');
			    $("#messageDiv").hide(); 
			    $("#formDiv").show(); 
			    $("#sendEmail").attr('disabled',false);
			},4000)
			
	  }else if(dataSucc.status==2){
		  $("#formDiv, #footerDivs").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>something went wrong.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
 });

</script>
<script>
var emailOrgno  = [];
var emailOrg    = [];
function checkEmail(ckid){
    if($("#checkAll").prop('checked') == true){
     if($("#ck"+ckid).prop('checked') == false){
        $("input[id='ck"+ckid+"']:not(:checked)").each(function() {
                emailOrgno.push($(this).val());
        }); 
     }else{
         $("input[id='ck"+ckid+"']:checked").each(function() {
            emailOrgno.splice( $.inArray($(this).val(),emailOrgno) ,1 );
        });
     }
        
    }else{
        if($("#ck"+ckid).prop('checked') == true){
         $("input[id='ck"+ckid+"']:checked").each(function() {
                emailOrg.push($(this).val());
         });
        }else{
            $("input[id='ck"+ckid+"']:not(:checked)").each(function() {
                emailOrg.splice( $.inArray($(this).val(),emailOrg) ,1 );
            });
        }
        
    }
}


 $("#SendEmailBulk").click(function(){
     
      if($("#checkAll").prop('checked') == true){	
		     emailOrg='allemail';
		     if(emailOrgno!==undefined){
		        emailOrgno.toString();
		     }
       }else{
    	    if(emailOrg!==undefined){
    	   	    emailOrg.toString();
    	    }
    	   var	emailOrgno='selectedmail'
       }
    	$("#all_un_email").val(emailOrgno);
		$("#all_email").val(emailOrg);
	
    if($("#checkAll").prop('checked') == true || emailOrg.length>0){
         $("#myModal").modal("show");
     }else{
        $('#putMsg').html('Please select at least a checkbox.');
		$("#alert_error").modal('show');
		setTimeout(function(){ $("#alert_error").modal('hide'); },2500);
     }
 });
      
	$("#all_sendEmail").click(function(e){
	    e.preventDefault();
		var multi_subject     = $("#multi_subject").val();
	//	var checkAll          = $("#checkAll").val();
	//	var all_email         = $("#all_email").val(checkAll);
		$("#all_sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
		var multi_description = CKEDITOR.instances["multi_description"].getData();
		$("#multi_description").val(multi_description);
		var multi_image       = $("#multi_image").val();
	$("#all_sendEmail").attr('disabled',true);	
		
	if($("#checkAll").prop('checked') == false){	
		 var emailOrg = [];
		 var emailOrgno = [];
        $("input[name='emailid[]']:checked").each(function() {
            emailOrg.push($(this).val());
        }); 
        emailOrg.toString();
	}else{
	   var  emailOrg='allemail';
	}
	

	
		var form=$("#multi_email_auto").get(0);
		var formData = new FormData(form);
	
         $.ajax({
         url: "<?= site_url(); ?>Email_Marketing/all_email_send",
		 method: "POST",
		 data:formData,
		 dataType: "JSON",
		 processData:false,
		 contentType:false,
		 success: function(dataSucc){
      if(dataSucc.status==1){
		    $("#formDivsmult").hide();
			$("#messageDivs").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email has been sent  successfully.');
			$("#messageDivs").css('display','block');
			$("#all_sendEmail").html('Send Email');
			setTimeout(function(){ 
			    $("#messageDivs").hide(); 
			    $("#formDivsmult").show(); 
			    $('#myModal').modal('hide'); 
			    $("#all_sendEmail").attr('disabled',false);
			},4000)
			
	  }else if(dataSucc.status==2){
		  $("#formDivsmult").hide();
		  $("#messageDivs").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDivs").css('display','block');
		  $("#all_sendEmail").html('Send Email');
		  setTimeout(function(){ 
		      $("#messageDivs").hide(); 
		  $("#formDivsmult").show(); 
		  $('#myModal').modal('hide'); 
		  $("#all_sendEmail").attr('disabled',false); },4000)
	  }
     }
    });
    }); 
    function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
</script>