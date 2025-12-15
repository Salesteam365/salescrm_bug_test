<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
    .content-header {background: #f2f2f2;}
</style>
<!-- Content Wrapper. Contains page content -->
<?php 
$ci 		=& get_instance();
$OppCount 	= $ci->Opportunity->check_opp_exist($record['lead_id']);
?>
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="<?=base_url('leads');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-lead/<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
							<?php  if($this->session->userdata('create_opportunity')=='1' && $OppCount<1){ ?>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-opportunity?qt=<?=$record['id'];?>"><div><img src="https://img.icons8.com/fluent/18/000000/create-order.png"/></div>Create Opportunity</a>
                            </li>
							<?php } ?>
							
							
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="<?=base_url();?>quotation/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>quotation/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main" class="content">
        <div class="container-fluid">
            <div class="accordion" id="faq">
                <div class="card">
                    <div class="card-header" id="faqhead1"> <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><i class="fas fa-file-alt"></i> Quick Quotation Detail</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>Lead Id</b>
                                    <p><?=$record['lead_id']?></p>
                                </div>
                                <div class="col">
                                    <b>Billed To</b>
                                    <p><?=$record['org_name']?></p>
                                </div>
                                <div class="col">
                                    <b>Total Amount</b>
                                    <p>₹ <?=$record['sub_total']?></p>
                                </div>
                                <div class="col">
                                    <b>Lead Date</b>
                                    <p><?=date('d-M-Y',strtotime($record['currentdate']));?></p>
                                </div>
                                <div class="col">
                                    <b>Assigned To</b>
                                    <p><?=date('d-M-Y',strtotime($record['assigned_to_name'])); ?></p>
                                </div>
                                <div class="col">
                                    <b>Share</b>
                                    <p><i class="fas fa-check-double"></i> Email Delivered</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="card">
                    <div class="card-header" id="faqhead7"> <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7" aria-expanded="true" aria-controls="faq7"><i class="fas fa-link"></i> Linked Quotation</a>
                    </div>
                    <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                        <div class="card-body">
                            <table class="table table-responsive-lg">
                                <thead>
                                    <tr>
                                        <th>Lead#</th>
                                        <th>Quotation Date</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$record['lead_id']?></td>
                                        <td><?=date('d-M-Y',strtotime($record['currentdate'])); ?></td>
                                        <td><?=$record['email']?></td>
                                        <td><?=$record['mobile']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="invoice-type">
        <div class="container">
            <h1>Lead</h1>
            <hr>
            <div class="row mt-3">
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                    <p>Lead</p>
                    <p>Lead Id#</p>
                    <p>Lead Date</p>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                    <p><b><?=$record['name']?></b></p>
                    <p><b><?=$record['lead_id']?></b></p>
                    <p><b><?=date('d-M-Y');?></b></p>
                </div>
            </div>
            <div class="invoice-address-info mt-3">
                <div class="row">
                    <div class="col">
                        <div class="billed-by">
                            <h3>Billed By</h3>
                            <b><?=$this->session->userdata('company_name');?></b>
                            <p><?=$this->session->userdata('company_address');?></p>
                            <p><?=$this->session->userdata('city');?></p>
                            <p><?=$this->session->userdata('state');?>-<?=$this->session->userdata('zipcode');?>, <?=$this->session->userdata('country');?></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="billed-to billed-by">
                            <h3>Billed To</h3>
                            <b><?=$record['contact_name'];?></b><br>
                            <b><?=$record['org_name'];?></b><br>
							<b><?=$record['billing_address'];?></b><br>
                            <p><?=$record['billing_city'];?>,<?=$record['billing_state'];?>-<?=$record['billing_zipcode'];?>, <?=$record['billing_country'];?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="invoice-table mt-3 text-left">
                <div class="row">
                    <div class="col">
                        <p><b>Country of Supply :</b> <?=$record['billing_country'];?></p>
                    </div>
                    <div class="col">
                        <p><b>Place of Supply :</b> <?=$record['billing_city'];?> (<?=$record['billing_zipcode'];?>)</p>
                    </div>
                </div>
                <table class="table table-responsive-lg">
                    <thead>
                        <tr>
						    <th>S.No</th>
                            <th>Product/Services</th>
                            <th>Qty</th>
                            <th>Rate</th>
							<th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					$totaliGst=0;
					$totalsGst=0;
					$totalcGst=0;
					if($record['product_name']!=""){
						$product_name=explode("<br>",$record['product_name']);
						if(!empty($record['gst'])){
						$gst=explode("<br>",$record['gst']);
						}
						$quantity		= explode("<br>",$record['quantity']);
						$unit_price		= explode("<br>",$record['unit_price']);
						
						$total			= explode("<br>",$record['total']);
						$descriptionPro	= explode("<br>",$record['pro_description']);
						
						for($rw=0; $rw<count($product_name); $rw++){
							$num = $rw + 1;
						?>
                        <tr>
						    <td><?=$num;?></td>
                            <td style="cursor:pointer;" data-toggle="collapse" href="#proDesc<?=$rw;?>" ><?=$product_name[$rw];?></td>
                            <td><?=$quantity[$rw];?></td>
                            <td>₹ <?=IND_money_format($unit_price[$rw]);?></td>
							
							<td>₹ <?=IND_money_format($total[$rw]);?></td>
                        </tr>
						
						<tr class="collapse" id="proDesc<?=$rw;?>" >
						    <td colspan="6" style="border-top: 0px solid !important; font-size: 14px;"><?php if(isset($descriptionPro[$rw]) && $descriptionPro[$rw]!=""){echo $descriptionPro[$rw]; }else{ echo "NA"; } ?></td>
						</tr>
						<?php } } ?>
                    </tbody>
                </table>
            </div>
            <div class="bank-total">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-6">
                        <div class="bank-total-left">
                            <p>Total In Words: <b>
							<?php  $get_amount= AmountInWords($record['sub_total']);
							echo $get_amount;
							?></b></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6">
                        <div class="bank-total-right">
                            <div class="row">
                                <div class="col">
                                    Sub Total
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($record['initial_total']);?>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                <div class="col">
                                    Total (INR)
                                </div>
                                <div class="col text-right">
                                    ₹ <?=IND_money_format($record['sub_total']);?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
           
        </div>
    </div>
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="<?=base_url('lead');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-lead/<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
							<?php  if($this->session->userdata('create_opportunity')=='1' && $OppCount<1){ ?>
							<li class="list-group-item text-center"><a href="<?=base_url();?>add-salesorder?qt=<?=$record['id'];?>"><div><img src="https://img.icons8.com/fluent/18/000000/create-order.png"/></div>Create Opportunity</a>
                            </li>
							<?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="<?=base_url();?>quotation/view/<?=$record['id']?>" target="_blank"><div><img src="https://img.icons8.com/color/18/000000/print.png"/></div>Print</a>
                            </li>
                            <li class="list-group-item text-center"><a href="<?=base_url();?>quotation/view/<?=$record['id']?>/dn" target="_blank"><div><img src="https://img.icons8.com/fluent/20/000000/download.png"/></div>Download</a>
                            </li>
                            <li class="list-group-item text-center" onclick="update_billedby(15)" style="cursor:pointer;" ><a><div><img src="https://img.icons8.com/office/18/000000/share.png"/></div>Share</a>
                            </li>
                            <li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email invoice</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="milestones" id="my2"></div>
        </div>
    </div>
</div>
<style>
.shareIcn{
	font-size: 33px;
	cursor: pointer;
}
.fa-whatsapp{
	color: #4caf5094
}
.fa-envelope{
	color: #ff57228c;
}
.fa-link{
	color: #1918188c;
}
.lbl{
	padding-top: 12px;
}
</style>

<div class="modal fade" id="branch_details" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Share Invoice Link</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-md-12 text-center">
					<h6>A link is genereted for this invoice. Share the link with your client to get paid.</h6>
				</div>
			</div>
          <div class="row">
            <div class="col-md-3"></div>
			<div class="col-md-6">
			 <div class="row text-center " style="padding-top: 5%;">
              <div class="col-md-4">
				<i class="fab fa-whatsapp shareIcn" onClick="share();"></i>
				<text style="display: block;">WhatsApp</text>
              </div>
			  <div class="col-md-4">
				<i class="far fa-envelope shareIcn" onClick="shareEmail();"></i>
				<text style="display: block;">Email</text>
              </div>
			  <div class="col-md-4">
			  <?php $actual_link = base_url()."quotation/view/".$record['id']; ?>
				<input type="hidden" name="invoiceurlCp" id="invoiceurlCp" value="<?=$actual_link;?>" >
				<i class="fas fa-link shareIcn iconcopy" onclick='copyToClipboard("<?=$actual_link;?>")'></i>
				<text style="display: block;" id="copy_linkmsg">Copy Link</text>
              </div>
			  </div>
            </div>
			<div class="col-md-3"></div>
          </div>
			<div class="row">
				<div class="col-md-12 text-center" style="padding-top: 5%;">
					Note: Anyone with the link can view this invoice.
				</div>
			</div>	
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email Invoice</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Client's Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['org_name'];?>" name="orgName" id="orgName">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['org_email'];?>" name="orgEmail" id="orgEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['session_comp_email'];?>" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="Quotation For <?=$record['org_name'];?> - #<?=$record['quote_id'];?>" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12" style="font-size: 11px; margin: 3px 0px;">
				Invoice PDF attachment and Online Link will be added to the email automatically.
			</div>
			
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$record['org_name'];?>,</p>
				<p>Please find attached Quotation #<?=$record['quote_id'];?>.</p>
				<p>Quotation Id: #<?=$record['quote_id'];?></p>
				<p>Billed To: <?=$record['org_name'];?></p>
				<p>Total Amount: ₹ <?=IND_money_format($record['sub_totalq']);?></p>
				<p>Thank you for your business.</p>
				<p>Regards ,</p>
				<p><?=$this->session->userdata['company_name'];?>, <?=$this->session->userdata('city');?></p>
			  </textarea>
            </div>
          </div>
			<div class="row text-center"   id="messageDiv" style="display:none; padding: 5%; " >
					
			</div>
				
			
			<div class="row" id="footerDiv">
				<div class="col-md-10" style="padding-top: 5%;">
					<i class="fas fa-info-circle"></i>&nbsp;&nbsp;Note: Anyone with the link can view this invoice.
				</div>
				<div class="col-md-2 text-center" style="padding-top: 5%;">
					<button class="btn btn-info" id="sendEmail">Send Email</button>
				</div>
			</div>	
      </div>
    </div>
  </div>
 
</div>


<?php  
$stage=1.5;
$checks=1;
if(isset($OppCount) && $OppCount>0){ 
	$stage=2.5;
	$checks=2;
}

if(isset($PiCount) && $PiCount>0){ 
	$stage=3;
	$checks=3;
}

// if(count($proArr)==count($proArrPro) || count($proArr)>count($proArrPro)){ 
	// $stage=3;
	// $checks=3;
// }

?>

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='150px';
</script>
<script>
function share() { 
        var message =  "<?php echo base_url();?>quotation/view/<?=$record['id']?>"; 
        window.open("https://web.whatsapp.com/send?text=" + message, '_blank'); 
}  

function update_billedby(id){ 
	$('#branch_details').modal('show'); 
}

function shareEmail(){ 
    $('#branch_details').modal('hide'); 
	$('#emailModel').modal('show'); 
}

/*function CopyFunction() {
  var copyText = document.getElementById("invoiceurlCp");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  alert("Copied the text: " + copyText.value);
  $('#branch_details').modal('hide');
}*/
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(element).select();
  document.execCommand("copy");
  $temp.remove();
  $('#copy_linkmsg').text('Link copied'); 
  $('#copy_linkmsg').css('color','rgb(37 211 102)');
  $('.iconcopy').css('color','rgb(37 211 102)');
  setTimeout(function(){ $("#copy_linkmsg").text('Copy link'); $("#copy_linkmsg, .iconcopy").css('color','');  },4000)
  
}


$("#sendEmail").click(function(){
	var orgName=$("#orgName").val();
	var orgEmail=$("#orgEmail").val();
	var ccEmail=$("#ccEmail").val();
	var subEmail=$("#subEmail").val();
	var invoiceurl="<?php echo base_url();?>/quotation/view/<?=$record['id']?>";
	var quote_id ="<?=$record['id'];?>";
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/quotation/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,invoiceurl:invoiceurl,quote_id,quote_id},
     success: function(dataSucc){
          console.log(dataSucc);
      if(dataSucc==1){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your Quotation shared successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Your Quotation shared failed.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
});

</script>
<script>


var no=421;
$("#addtermsLine").click(function(){
	no++;
	appendLineb('putline',no,'terms_conditionbnk','');
});

function countPtgb(pid){
        var arr = $('#'+pid+' p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
}

function appendLineb(appendDataid,no,inputName,value=''){
		var appendData='<div class="col-md-1 numberDisp " id="noid'+no+'"><p>'+no+'.</p></div>'+
		'<div class="col-md-10" id="inptdv'+no+'"><input type="text" id="inpt'+no+'" class="form-control inputbootomBor" name="'+inputName+'[]" value="'+value+'" placeholder="Online payment Terms & Condition" ></div>'+
		'<div class="numberDisp" style="" id="rm'+no+'"><i class="far fa-times-circle" onClick="removeRow('+no+',`'+appendDataid+'`)" ></i></div>';
		$("#"+appendDataid).append(appendData);
		countPtgb(appendDataid);
}
</script>

<script>document.getElementsByTagName("html")[0].className += " js";</script>
<script>
  $('#my2').milestones({
    stage: "<?=$stage?>",
    checks: "<?=$checks?>",
    stageclass: 'doneclass',
    labels: ["Lead Details","Opportunity Generated","Quotation Generated","SO Generated","PO Generated"]
  });
  
  
 
  
</script>