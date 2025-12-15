<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Email Label</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Email Label</li>
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
                  <button class="btn btn-info" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>
                  <?php if(isset($email_details["id"])){ ?>
                  <button class="btn btn-info"><a href="<?php echo base_url('mail_details/mail_configure/'.$email_details["id"]) ?>" style="color:#f4f5f7">Edit mail config </a></button> 
                  <?php } ?>
                  <button class="btn btn-info check_user" data-toggle="modal" data-target="#emailModel">Compose Mail</button>
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
                            <th class="th-sm">Date</th>
                            <th class="th-sm">Sender mail</th>
                            <th class="th-sm">Email Subject</th>
                            <th class="th-sm">View Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        error_reporting(1);
                        ini_set('display_errors', 1);
                        
                		 $data= ['mail'=> ['username'=>$email_details['email_id'], 'password'=>$email_details['email_password']]];   
                		 print_r($email_details);
                	    $smtp_host = $email_details['smtp_host'].':587/tls'; 
                		$mail_handle=imap_open("{".$smtp_host."}",$data['mail']['username'],$data['mail']['password']);
                	   print_r($mail_handle);die;
                		if($mail_handle){
                		$headers=imap_headers($mail_handle);
                	
                    	     //$singleMail=imap_header($mail_handle,3);
                    	    //$singleMailBody=imap_body($mail_handle,6);
                    	   //echo '<pre>';
                    	  //print_r($singleMail);
                		
                	 $n=6; $st = imap_fetchstructure($mail_handle, $n); 
                	 if (!empty($st->parts)) { 
                	     for($i = 0, $j = count($st->parts); $i < $j; $i++) {
                	         $part = $st->parts[$i]; 
                	            if($part->subtype == 'HTML'){
                	               $body = imap_fetchbody($mail_handle, $n, $i+1); 
                	            }   
                	         
                	     } 
                	     
                	 } else { $body = imap_body($mail, $n); } 
                        
                        //echo quoted_printable_decode($body);
                        
                        	$last=imap_num_msg($mail_handle);
                        	
                        	$id = $this->uri->segment(3);// die;
                        	
                        for($i=1; $i<=$last; $i++ ){ 
                            $singleMail=imap_header($mail_handle,$i);
                            $singleMailBody=imap_body($mail_handle,$i);
                         //print_r($singleMail); 
                        if(strpos($singleMail->Subject,'Undeliverable') === false){
                        ?>
                        
                        <tr>
                          <td><?=date('d M Y',strtotime($singleMail->date)) ?></td> 
                          <td><?=$singleMail->sender[0]->personal ?></td>   
                          <td><?=$singleMail->Subject ?></td>  
                          <td><a href="#" onClick="getINfo('<?=$id;?>','<?=$i;?>');" >View Message</a></td>  
                        </tr> 
                        <?php } }  imap_close($mail_handle); }else{ ?>
                         <tr>
                          <td colspan="4" class="text-center">No email synchronize yet, <a href="<?=base_url();?>mail_details/mail_configure"> Click here </a> to synchronize</td> 
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<div style="text-align:center" id="show_msgs"></div>



<div class="modal fade" id="emailModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Compose Email</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
           
			<div class="col-md-2 lbl">
				<label for="">Reciever Email:</label>
			</div>
			<div class="col-md-10">
			  <input placeholder="example@domain.com" type="text" class="form-control" value="" name="recEmail" id="recEmail">
            </div>
            
            <div class="col-md-2 lbl">
				<label for="">Reciever Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" placeholder="Ex. xyz" class="form-control" value="" name="RecName" id="RecName">
            </div>
            
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$this->session->userdata('company_email');?>" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" placeholder="Mail Subject" class="form-control" value="" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt"></textarea>
            </div>
          </div>
			<div class="row text-center"   id="messageDivMl" style="display:none; padding: 5%; " >
					
			</div>
				
			<div class="row" id="footerDiv">
				<div class="col-md-12 text-center" style="padding-top: 5%;">
					<button class="btn btn-info" id="sendEmail">Send Email</button>
				</div>
			</div>	
      </div>
    </div>
  </div>
</div>

  
  <div class="modal fade profile_popup" id="newownermodal"  data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h6 class="modal-title">INBOX MESSAGE</h6>
        <button type="button" class="close clsMdl" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row form-group">
          <div class="col-lg-12" id="putData">
           
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary clsMdl" data-dismiss="modal">Back</button>
      </div>

    </div>
  </div>
</div>
  
  
</div>
<!-- ./wrapper -->
<?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>

<script>


$("#sendEmail").click(function(){
    
	var recEmail = $("#recEmail").val();
	var ccEmail  = $("#ccEmail").val();
	var subEmail = $("#subEmail").val();
	var RecName = $("#RecName").val();

	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	if(recEmail!=""){
	    
	   $("#sendEmail").html('Sending...');
	   
	forDisableInput("#sendEmail",1);
	$.ajax({
     url: "<?= site_url(); ?>Mail_details/composeMail",
     method: "POST",
     data: {recEmail:recEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,RecName:RecName},
     success: function(dataSucc){
      if(dataSucc=='1'){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDivMl").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your message has been sent successfully.');
			$("#messageDivMl").css('display','block');
			setTimeout(function(){ $("#messageDivMl").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); $("#sendEmail").html('Send Email'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDivMl").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDivMl").css('display','block');
		  setTimeout(function(){ $("#messageDivMl").hide(); $("#formDiv, #footerDiv").show(); $("#sendEmail").html('Send Email'); },4000)
	  }
     }
    });
	}
});


function getINfo(id,inbx){
    $("#newownermodal").modal('show');
    $("#putData").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin: 14% 0% 14% 45%; width: 3rem;   height: 3rem;"></span>');
    $.ajax({
        url:"<?= base_url('mail_details/mail_message_iframe')?>/"+id+"?inbx="+inbx,
        method:"GET",
        data:{checkbox_value:'test'},
        success:function(data)
        {
            $("#putData").html(data);
          
        }
    });
}


$(".clsMdl").click(function(){ 
    $("#putData").html('');
});

  var table;
$(document).ready(function () {
  table = $('#ajax_datatable').DataTable({
       /* "processing": true, //Feature control the processing indicator.
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
        url:"<?= base_url('home/delete_bulk')?>",
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
     function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax
    }
</script>