<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
    .content-header {background: #fff;}
	.ModalRight {
		right: 0;
		position: fixed;
		margin: auto;
		width: 100%;
		height: 100%;
	}
.Modalht100 {
	height: 100%;
    overflow-y: auto;
	}
	
	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		-webkit-transform: translate3d(0%, 0, 0);
		    -ms-transform: translate3d(0%, 0, 0);
		     -o-transform: translate3d(0%, 0, 0);
		        transform: translate3d(0%, 0, 0);
	}

	


        
/*Right*/
	.modal.right.fade .modal-dialog {
		-webkit-transition: opacity 0.5s linear, right 0.5s ease-out;
		   -moz-transition: opacity 0.5s linear, right 0.5s ease-out;
		     -o-transition: opacity 0.5s linear, right 0.5s ease-out;
		        transition: opacity 0.5s linear, right 0.5s ease-out;
	}
	
	.modal.right.fade.in .modal-dialog {
		right: 0;
	}

body {
  margin: 0;
}



.activeItm {
	border-bottom: 4px solid #111 !important;
    font-weight: 600;
	background: #284255;
    color: #fff;
}

.btn-circle.btn-xl {
    width: 50px;
    height: 50px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 50px;
    height: 50px;
    padding: 6px 0px;
    border-radius: 30px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}

.CursorPointer {
    Cursor:pointer;
}



/*-------------------*/



.block__item {
    margin-bottom: 20px;
}
.block__title {
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    padding-left: 30px;
    cursor: pointer;
}

.block__title::before,
.block__title::after {
    content: "";
    width: 10px;
    height: 1px;
    background-color: #000;
    position: absolute;
    top: 8px;
    transition: all 0.3s ease 0s;
}

.block__title:before {
    transform: rotate(40deg);
    left: 0;
}
.block__title::after{
    transform: rotate(-40deg);
    left: 8px;
}

.block__title.active::before,
.block__title.active::after {
    background-color: red;
}

.block__title.active::before {
    transform: rotate(-40deg);
}

.block__title.active::after {
    transform: rotate(40deg);
}

.block__text {
    display: none;
    padding-top: 10px;
}



</style>
<!-- Content Wrapper. Contains page content -->
<?php $this->session->set_flashdata('orgid', $record['id']); ?>
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
		 <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="javascript:history.back()"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email to vendor</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="<?=base_url();?>vendors?up=<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
							<li class="list-group-item text-center" onclick="add_formOrg('Vendor','hdhgh')"   ><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/add--v1.png"/></div>Add
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
		
		
		
		
	</div>
	<section class="content ">
        <div class="container-fluid card org_div">
            <div class="row" style="font-size: 14px;">
				<input type="hidden" value="<?=$record['id'];?>" id="orgidAct" >
			   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<div class="row text-center">
						<div class="col-md-3 p-2">
							<img src="https://img.icons8.com/dusk/50/000000/organization.png"/>
							<br>
							<br>
							<span style="font-size: 18px;">(Vendor)</span>
						</div>
						<div class="col-md-9 p-2">
						<h3><?=$record['org_name']?></h3>
						<p class="mb-1" ><?=$record['primary_contact']?></p>
						<p class="mb-1"><?=$record['email']?></p>
						</div>
						
						<hr>
					</div> 
					
					<hr>
					
					<div class="row">
						
					<div class="wrapper" style="width: 100%;">
						<div class="block one p-1">
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title active">About Vendor</div>
								<div class="block__text" style="display: block;">
									<p><text class="text-info">Website : </text> <?=$record['website'];?></p>
									<p><text class="text-info">Mobile : </text><?=$record['mobile'];?></p>
									<p><text class="text-info">Office Phone : </text><?=$record['office_phone'];?></p>
									<p><text class="text-info">Employees : </text><?=$record['employees'];?></p>
									<p><text class="text-info">Industry : </text><?=$record['industry'];?></p>
									<p><text class="text-info">Annual Revenue : </text><?=$record['annual_revenue'];?></p>
									<p><text class="text-info">Type : </text><?=$record['type'];?></p>
									<p><text class="text-info">Region : </text><?=$record['region'];?></p>
									<p><text class="text-info">GSTIN : </text><?=$record['gstin'];?></p>
									<p><text class="text-info">Pan Number : </text><?=$record['panno'];?></p>
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">Vendor Address</div>
								<div class="block__text">
									<p><b>Billing Address:-</b></p>
									<p><text class="text-info">Country : </text><?=$record['billing_country'];?></p>
									<p><text class="text-info">State : </text><?=$record['billing_state'];?></p>
									<p><text class="text-info">City : </text><?=$record['billing_city'];?></p>
									<p><text class="text-info">Zipcode : </text><?=$record['billing_zipcode'];?></p>
									<p><text class="text-info">Address : </text><?=$record['billing_address'];?></p>
									<p><b>Shipping Address:-</b></p>
									<p><text class="text-info">Country : </text><?=$record['shipping_country'];?></p>
									<p><text class="text-info">State : </text><?=$record['shipping_state'];?></p>
									<p><text class="text-info">City : </text><?=$record['shipping_city'];?></p>
									<p><text class="text-info">Zipcode : </text><?=$record['shipping_zipcode'];?></p>
									<p><text class="text-info">Address : </text><?=$record['shipping_address'];?></p>
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">Vendor Contact</div>
								<div class="block__text">
									<?php
									for($i=0; $i<count($contact); $i++){ 
										if($contact[$i]['name']!=""){ ?>
									<div class="card">
										<div class="card-header" id="heading<?=$contact[$i]['name']?>">
										  <h2 class="mb-0">
											<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$contact[$i]['name']?>" aria-expanded="true" aria-controls="collapse<?=$contact[$i]['name']?>">
											  <?=$contact[$i]['name']?>
											</button>
										  </h2>
										</div>

										<div id="collapse<?=$contact[$i]['name']?>" class="collapse" aria-labelledby="heading<?=$contact[$i]['name']?>">
										  <div class="card-body">
											<p><text class="text-info">Email : </text><?=$contact[$i]['email'];?></p>
											<p><text class="text-info">Mobile No. : </text><?=$contact[$i]['mobile'];?></p>
											<p><text class="text-info">Office No. : </text><?=$contact[$i]['office_phone'];?></p>
											<p class="text-right m-0" ><text class="text-info"><a href="#" onClick="contactEmail('<?=$contact[$i]['id']?>','<?=$contact[$i]['name']?>','<?=$contact[$i]['email']?>','<?=$contact[$i]['org_name']?>');" >Send Email</a></text></p>
										  </div>
										</div>
									</div>
									<?php } } ?>
								</div>
							</div>
						</div>
					</div>

					</div>
					
                </div>
                
				
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				
					<div class="row">
						
					  <div class="wrapper" style="width: 100%;">
						<div class="block one p-1">
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title active">
									<div class="row">
										<div class="col-md-6">
										<div>Purchase Order</div>
										</div>
										<div class="col-md-6 text-right pr-3">
											<?php if(check_permission_status('Purchase Order','create_u')==true){ ?>
											<span class="sub-icn-quote">
											<i class="fas fa-rupee-sign sub-icn-quote mr-1"></i><b><text id="putAllPrice">0.00</text></b></span>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="block__text" style="display: block;">
									<?php
										$totalPrice=0;
										for($i=0; $i<count($purchase); $i++){ 
											if($purchase[$i]['id']!=""){
												$totalPrice=$totalPrice+$purchase[$i]['sub_total'];
												?>
										<div class="card m-1">
											<div class="card-header p-1" id="heading<?=$purchase[$i]['id']?>">
											  <h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$purchase[$i]['id']?>" aria-expanded="true" aria-controls="collapse<?=$purchase[$i]['id']?>">
												  <?=$purchase[$i]['subject']?>
												</button>
												
												<button class="btn btn-link float-right text-info" type="button"><small>
												  <i class="far fa-calendar-alt sub-icn-so mr-2"></i><?php 
												  $newDate = date("d M Y", strtotime($purchase[$i]['currentdate']));
												  echo $newDate;?></small>
												</button>
												
											  </h2>
											</div>

											<div id="collapse<?=$purchase[$i]['id']?>" class="collapse <?php if($i==0){ ?> show <?php } ?>" aria-labelledby="heading<?=$purchase[$i]['id']?>">
											  <div class="card-body">
												<p><text class="text-info">PO ID : </text><?=$purchase[$i]['purchaseorder_id'];?></p>
												<p><text class="text-info">PO Owner : </text><?=$purchase[$i]['owner'];?></p>
												<p><text class="text-info">product : </text><?=$purchase[$i]['product_name'];?></p>
												<p><text class="text-info">Sub Total : </text><?=IND_money_format($purchase[$i]['sub_total']);?></p>
												<p class="text-right m-0"><a href="<?=base_url().'purchaseorders/view_pi_po/'.$purchase[$i]['id'];?>" >View Details</a></p>
											  </div>
											</div>
										</div>
									<?php } } ?> 
								</div>
							</div>
							
							
						</div>
					  </div>
					</div>
                </div>
            </div>
        </div>
	 </section>
	
</div>


<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg ModalRight">
    <div class="modal-content Modalht100">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email to customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Client's Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['org_name'];?>" name="orgName" id="orgName">
			  <input type="hidden" class="form-control" value="<?=$record['id'];?>" name="orgId" id="orgId">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['email'];?>" name="orgEmail" id="orgEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="  - #<?=$record['org_name'];?>" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$record['org_name'];?>,</p>
				
				<p>Regards ,</p>
				<p><?=$this->session->userdata['company_name'];?>, <?=$this->session->userdata('city');?></p>
			  </textarea>
            </div>
          </div>
			<div class="row text-center"   id="messageDiv" style="display:none; padding: 5%; " >
					
			</div>
			<div class="row" id="footerDiv">
				<div class="col-md-2 text-center" style="padding-top: 5%;">
				</div>
			</div>	
      </div>
	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button class="btn btn-info" id="sendEmail">Send Email</button>
      </div>
	  
    </div>
  </div>
 
</div>



<div class="modal fade" id="contactEmail" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg ModalRight">
    <div class="modal-content Modalht100">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email To Customer Contact</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Contact Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="orgName" id="orgNameCnt" readonly >
			  <input type="hidden" value="" name="orgNameCntid" id="orgNameCntid" readonly >
			  <input type="hidden" value="" name="contactOrgName" id="contactOrgName" readonly >
            </div>
			<div class="col-md-2 lbl">
				<label for="">Contact Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="orgEmail" id="orgEmailCnt" readonly >
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="ccEmail" id="ccEmailCnt">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="subEmail" id="subEmailCnt">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxtCnt"   name="descriptionTxt"></textarea>
            </div>
          </div>
			<div class="row text-center" id="messageDivCnt" style="display:none; padding: 5%;"></div>
			<div class="row" id="footerDivCnt">
				<div class="col-md-2 text-center" style="padding-top: 5%;">
				</div>
			</div>	
      </div>
	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button class="btn btn-info" id="sendEmailCnt">Send Email</button>
      </div>
	  
	  
	  
    </div>
  </div>
 
</div>


<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<script language="javascript">

var allPrice="<?=$totalPrice;?>";
$("#putAllPrice").html(numberToIndPrice(allPrice));

$(document).ready(function() {
    $('.block__title').click(function(event) {
        if($('.block').hasClass('one')){
            $('.block__title').not($(this)).removeClass('active');
            $('.block__text').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);
    });
});

$(".CursorPointer").click(function(){
	$(".CursorPointer").removeClass('activeItm');
	$(this).addClass('activeItm');
});
	
</script>
<script>
//CKEDITOR.replace( 'notearea' );
CKEDITOR.replace('notearea', {
    toolbar: [
        ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
    ]
});

//CKEDITOR.replace( 'notearea' );
	var editor  = CKEDITOR.replace( 'descriptionTxt' );
	var editor2 = CKEDITOR.replace( 'descriptionTxtCnt' );
	CKEDITOR.config.height='150px';
</script>
<script>

function contactEmail(id,name,email,contactOrgName){ 
	$("#orgNameCntid").val(id);
	$("#orgNameCnt").val(name);
	$("#orgEmailCnt").val(email);
	$("#contactOrgName").val(contactOrgName);
	
	var ccEmail		= $("#ccEmailCnt").val();
	var subEmail	= $("#subEmailCnt").val();
	$('#contactEmail').modal('show'); 
}

$("#sendEmailCnt").click(function(){
	var orgName		= $("#orgNameCnt").val();
	var contactOrgName		= $("#contactOrgName").val();
	var orgEmail	= $("#orgEmailCnt").val();
	var ccEmail		= $("#ccEmailCnt").val();
	var subEmail	= $("#subEmailCnt").val();
	var orgId		= $("#orgId").val();
	var orgNameCntid= $("#orgNameCntid").val();
	
	var descriptionTxt = CKEDITOR.instances["descriptionTxtCnt"].getData();
	$("#sendEmailCnt").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/Customer_activity/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,orgId:orgId,orgNameCntid:orgNameCntid,contactOrgName:contactOrgName},
     success: function(dataSucc){
      if(dataSucc==1){
		    $("#formDivCnt, #footerDivCnt").hide();
			$("#messageDivCnt").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email sent successfully.');
			$("#messageDivCnt").css('display','block');
			$("#sendEmailCnt").html('Send Email');
			setTimeout(function(){ $("#messageDivCnt").hide(); $("#formDivCnt, #footerDivCnt").show(); $('#contactEmail').modal('hide'); },4000)
	  }else{
		  $("#formDivCnt, #footerDivCnt").hide();
		  $("#messageDivCnt").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDivCnt").css('display','block');
		  $("#sendEmailCnt").html('Send Email');
		  setTimeout(function(){ $("#messageDivCnt").hide(); $("#formDivCnt, #footerDivCnt").show(); },4000)
	  }
     }
    });
});



function shareEmail(){ 
	$('#emailModel').modal('show'); 
}

$("#sendEmail").click(function(){
	var orgName		= $("#orgName").val();
	var orgEmail	= $("#orgEmail").val();
	var ccEmail		= $("#ccEmail").val();
	var subEmail	= $("#subEmail").val();
	var orgId	    = $("#orgId").val();
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/Customer_activity/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,orgId:orgId},
     success: function(dataSucc){
      if(dataSucc==1){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email sent successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
});

</script>

<script>
$('.form-control').keypress(function(){
  $(this).css('border-color','')
  $("#bank_details span").html("");
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});

</script>