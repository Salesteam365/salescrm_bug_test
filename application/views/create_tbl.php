<!--common header include -->
<?php $this->load->view('common_navbar');?>
 <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.signature.css">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.betterdropdown.css">
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
 
<!-- common header include -->
<style>


.error-popup-msg-for-user ol li {
    margin-bottom: 10px;
    color: red;
}
.error-popup-msg-for-user p {
    color: red;
    margin-bottom: 10px;
}
.error-popup-msg-for-user ol {
    list-style: revert;
    padding: 0 15px;
    margin: 0;
}
.error-popup-msg-for-user {
    border: 1px solid #ff0f0f;
    background: #ff00000d;
    padding: 15px;
}

.pro_descrption{ display:none; } .delIcn{color: #ef8d91; margin-right: 7px;} 
      .addIcn{color: #709870; margin-right: 7px;} #putExtraVl{ width:100%;}
      .inrIcn{padding-top: 6px; text-align: right; height: calc(2.25rem + 2px); }
      .inrRp{padding-top: 6px;   height: calc(2.25rem + 2px); }
      .dropdown-box-wrapper, .result, .filter-box { height: calc(2.25rem + 2px); display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: transparent;
    background-clip: padding-box;
    border:0;
    border-bottom: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out; }
    .form-proforma .row {
	background: #f8faff;
	padding: 15px;
	margin: 0;
	}
	.form-proforma {
	background: #ffffff;
	padding: 0;
	}
	.form-footer-section .container {
	background: #f8faff;
	padding: 20px;
	}
	.form-footer-section {
	background: #ffffff;
	padding: 0;
	}
	.contact_details .container {
	background: #f8faff;
	padding: 15px;
	}
	.contact_details {
	padding: 0;
	background-color: #ffffff;
	}
  .linkscontainer{
width:70vw;
padding:20px;
padding-top:50px;
border-radius:10px;
box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
margin:20px auto;
margin-bottom:50px;

}


#btnSave {
  background-color: initial;
  background-image: linear-gradient(#8614f8 0, #760be0 100%);
  border-radius: 5px;
  border-style: none;
  box-shadow: rgba(245, 244, 247, .25) 0 1px 1px inset;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: Inter, sans-serif;
  font-size: 16px;
  font-weight: 500;
  height: 40px;
  line-height: 20px;
  margin-left: -4px;
  outline: 0;
  text-align: center;
  transition: all .3s cubic-bezier(.05, .03, .35, 1);
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: bottom;
  width: 160px;
}

#btnSave:hover {
  opacity: .7;
}

@media screen and (max-width: 1000px) {
  #btnSave {
    font-size: 14px;
    height: 55px;
    line-height: 55px;
    width: 150px;
  }
}
@media screen and (max-width: 576px) {
.linkscontainer {
 width: 100vw;
}
}
</style>


<!-- modal Add lead status start-->
 <div class="modal fade" id="linkedinvoiceform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Lead Status </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="expanseForm" method="post" action="<?php echo base_url('add-expanse'); ?>">
            <div class="form-group">
              <label for="exampleInput"> Lead Status</label>
              <input type="text" class="form-control" name="leadstatus" id="leadstatus" placeholder="Enter New Lead Status">
            
            </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveChangesBtn">Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal Add Lead status end-->






<div class="content-wrapper">

<?php
if($this->session->userdata('account_type')=="Trial" && $countLead>=1000){ 
?>
<div class="content-header" style="background-color:rgba(240,240,246,0.8);">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12 mb-3 mt-5 text-center">
              <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
              </div>
            <div class="col-md-12 mb-3 text-center">
              You are now using trial account.<br>
			  <text>You are exceeded  your leads limit - 1,000'</text><br>
			  <text>You can add only  1,000 lead on trial account</text><br>
			  Please upgrade your plan to click bellow button.
            </div>
            <div class="col-md-12 mb-3 text-center">
              <a href="https://team365.io/pricing"><button class="btn btn-info">Buy Now</button></a>
            </div>
       
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>

<?php }else{ ?>
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 offset-sm-1">
          <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;">Lead Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."leads "; ?>">Table</a>
            </li>
            <li class="breadcrumb-item active">Create table</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  
  
<div class="linkscontainer">
    <form class="form-horizontal"  id="form" method="post" enctype = "multipart/form-data">
        <div class="form-proforma">
            <div class="container">
            <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                        <?php 
                        if(isset($record['lead_source'])){ 
                            $dataSrc=$record['lead_source']; 
                        }else{ 
                            $dataSrc=''; 
                        }  ?>
                    
                        <label for="">Lead Source<span class="text-danger">*</span>:</label>
                        <select class="form-control checkvl"  id="lead_source_ad" name="lead_source">
                            <option value="" selected="" disabled="">Select Lead Source</option>
                            <option value="Advertisement" <?php if($dataSrc=='Advertisement'){ echo "selected"; } ?> >Advertisement</option>
                            <option value="Cold Call" <?php if($dataSrc=='Cold Call'){ echo "selected"; } ?> >Cold Call</option>
                            <option value="Employee Referral" <?php if($dataSrc=='Employee Referral'){ echo "selected"; } ?> >Employee Referral</option>
                            <option value="External Referral" <?php if($dataSrc=='External Referral'){ echo "selected"; } ?> >External Referral</option>
                            <option value="Online Store" <?php if($dataSrc=='Online Store'){ echo "selected"; } ?> >Online Store</option>
                            <option value="Partner" <?php if($dataSrc=='Partner'){ echo "selected"; } ?> >Partner</option>
                            <option value="Public Relation" <?php if($dataSrc=='Public Relation'){ echo "selected"; } ?> >Public Relation</option>
                            <option value="Sales Email Alias" <?php if($dataSrc=='Sales Email Alias'){ echo "selected"; } ?> >Sales Email Alias</option>
                            <option value="Seminar Partner" <?php if($dataSrc=='Seminar Partner'){ echo "selected"; } ?> >Seminar Partner</option>
                            <option value="Internal Seminar" <?php if($dataSrc=='Internal Seminar'){ echo "selected"; } ?> >Internal Seminar</option>
                            <option value="Trade show" <?php if($dataSrc=='Trade show'){ echo "selected"; } ?> >Trade Show</option>
                            <option value="Web Download" <?php if($dataSrc=='Web Download'){ echo "selected"; } ?> >Web Download</option>
                            <option value="Web Research" <?php if($dataSrc=='Web Research'){ echo "selected"; } ?> >Web Research</option>
                            <option value="chat" <?php if($dataSrc=='chat'){ echo "selected"; } ?> >Chat</option>
                            <option value="Twitter" <?php if($dataSrc=='Twitter'){ echo "selected"; } ?> >Twitter</option>
                            <option value="Facebook" <?php if($dataSrc=='Facebook'){ echo "selected"; } ?> >Facebook</option>
                            <option value="Google+" <?php if($dataSrc=='Google+'){ echo "selected"; } ?> >Google+</option>
                            <option value="Existing Customer" <?php if($dataSrc=='Existing Customer'){ echo "selected"; } ?> >Existing Customer</option>
                        </select>
                        <span id="lead_source_error"></span>
                    </div>
                    </div>
                    
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Total Employees:</label>
                        <input type="text" class="form-control orgEmployee" id="ldemployees" name="employees" placeholder="No. Of Employees" value="<?php if(isset($record['employees'])){ echo $record['employees']; }  ?>">
                        <span id="invoice_no_error"></span>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Annual Revenue:</label>
                        <input type="text" class="form-control ordAnnualRevenue" id="lfannual_revenue" name="annual_revenue" placeholder="Annual Revenue" value="<?php if(isset($record['annual_revenue'])){ echo $record['annual_revenue']; }  ?>">
                        <span id="invoice_no_error"></span>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Customer Website:</label>
                        <input type="text" class="form-control orgWebsite" id="lead_website" name="website" placeholder="Website" value="<?php if(isset($record['website'])){ echo $record['website']; }  ?>">
                        <span id="invoice_no_error"></span>
                    </div>
                    </div>
            </div>
            </div>
        </div>
    </form>
</div>
   
<?php } ?>
  <!-- /.content-header -->
</div>
<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?> 

<script>
function save(){
	if(checkValidationWithClass('form')==1){	
	    toastr.info('Please wait while we are processing your request');
		$('#btnSave').text('Saving & Redirecting..');
		$('#btnSave').attr('disabled',true);
		var url;
		var save_method=$("#save_method").val();
		if(save_method == 'add') {
			  url = "<?= base_url('leads/create')?>";
		}else{
			  url = "<?= base_url('leads/update')?>";
		}
		var dataString = $("#form").serialize();
		
		var username=$('#sel1 option:selected').text();
		
		$.ajax({
			url : url,
			type: "POST",
			data: dataString+'&assigned_to_name='+username,
			dataType: "JSON",
			success: function(data)
			{   
			  if(data.status) 
			  {
			    toastr.success('A new lead has been added successfully.'); 
				window.location.href = '<?=base_url()?>leads/';
			  }
			  $('#btnSave').text('Save & Continue'); //change button text
			  $('#btnSave').attr('disabled',false); //set button enable
			  if(data.st==202)
			  {
			    toastr.error('Validation Error, Please fill all star marks fields');    
				$("#name_error").html(data.name);
				$("#org_name_error").html(data.org_name);
				$("#mobile_error").html(data.mobile);
				$("#email_error").html(data.email);
				$("#lead_source_error").html(data.lead_source);
				$("#lead_status_error").html(data.lead_status);
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
				
				checkValidationWithClass('form');
				
			  }
			  else if(data.st==200)
			  {
				toastr.error('Something went wrong, Please try later.');
			  }
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
			  toastr.error('Something went wrong, Please try later.');
			  $('#btnSave').text('Save & Continue'); //change button text
			  $('#btnSave').attr('disabled',false); //set button enable
			}
		});
	}
}
</script>


