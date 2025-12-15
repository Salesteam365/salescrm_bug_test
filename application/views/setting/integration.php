<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
}
.quoteacc_head{
	padding:16px;
	border-radius:4px;
	
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">App Store</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('integration'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Integration</li>
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
		 
		 
			<div class="accordion mx-3" id="faq">
			  <div class="card">
			  <div class="quoteacc_head" id="faqhead1" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-controls="faq1" > <a href="#" class="btn btn-header-link" style="font-size:24px; font-weight:500;" > Ads</a>
               </div>

				<div id="faq1" class="collapse" aria-labelledby="faqhead1" data-parent="#faq">
				  <div class="card-body">
					<div class="row">
					<div class="col text-center">
						<a href="<?=base_url();?>facebook-instagram-ads-lead-integration">
							<img src="<?=base_url();?>assets/images/integration-icon/fb.png" width="20%">
						</a>
				    </div>
				    <div class="col text-center">
					 <a href="<?=base_url();?>facebook-instagram-ads-lead-integration">
						<img src="<?=base_url();?>assets/images/integration-icon/insta.png" width="20%">
					  </a>
				    </div>
				    <div class="col text-center">
						<a style="cursor:pointer;"  onClick="openModalApi('apiGoogle');">
							<img src="<?=base_url();?>assets/images/integration-icon/google-ads.png" width="20%">
						</a>
				    </div>
				   
				   </div>
				  </div>
				</div>
			  </div>
			  
			  <div class="card">
			  <div class="quoteacc_head" id="faqhead2" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" > <a href="#" class="btn btn-header-link" style="font-size:24px; font-weight:500;" > Marketing</a>
               </div>
			   <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq2">
				  <div class="card-body">
					<div class="row">
						<div class="col text-center border-right">
						 <a style="cursor:pointer;"  onClick="openModalApi('apiIndiamart');"  data-toggle="tooltip" data-container="body" title="India Mart"><img src="<?=base_url();?>assets/images/integration-icon/india-mart.png" width="30%"></a>
					   </div>
					   
						<div class="col text-center border-right">
						 <a style="cursor:pointer;" onClick="openModalApi('apiTradeIndia');"   data-toggle="tooltip" data-container="body" title="Trade India"><img src="<?=base_url();?>assets/images/integration-icon/trade-india.png" width="35%"></a>
						</div>
						
						<div class="col text-center border-right">
						 <a style="cursor:pointer;"  onClick="openModalApi('apiJustDial');"  data-toggle="tooltip" data-container="body" title="Just Dial">
							<img src="<?=base_url();?>assets/images/integration-icon/jd.png" width="30%">
						 </a>
					   </div>
					   
					   <div class="col text-center">
						 <a style="cursor:pointer;"  onClick="openModalApi('apiSulekha');"  data-toggle="tooltip" data-container="body" title="Sulekha"><img src="<?=base_url();?>assets/images/integration-icon/sulekha.png" width="30%"></a>
					   </div>
					
					</div>
					<hr>
					<div class="row mt-4">
						<div class="col text-center border-right">
						 <a style="cursor:pointer;" onClick="openModalApi('apiHousing');"  data-toggle="tooltip" data-container="body" title="Housing.com"><img src="<?=base_url();?>assets/images/integration-icon/housing.png" width="30%"></a>
						</div>
						
						<div class="col text-center border-right">
						 <a style="cursor:pointer;"  onClick="openModalApi('apiMagicBricks');"  data-toggle="tooltip" data-container="body" title="magicbricks.com">
							<img src="<?=base_url();?>assets/images/integration-icon/magicbrcks.png" width="30%">
						 </a>
					    </div>
						<div class="col text-center border-right">
						 <a style="cursor:pointer;"  onClick="openModalApi('api99acres');"  data-toggle="tooltip" data-container="body" title="99acres.com">
							<img src="<?=base_url();?>assets/images/integration-icon/99acres.png" width="30%">
						 </a>
					    </div>
						<div class="col text-center">
						 <!--<a style="cursor:pointer;"  onClick="openModalApi('apiHousing');">
							<img src="<?=base_url();?>assets/images/integration-icon/jd.png" width="30%">
						 </a>-->
					    </div>
					
					</div>
					
					
				  </div>
				</div>
			  </div>
			  <div class="card">
			  <div class="quoteacc_head" id="faqhead3" data-toggle="collapse" data-target="#faq3" aria-expanded="false" aria-controls="faq3" > <a href="#" class="btn btn-header-link" style="font-size:24px; font-weight:500;"> Email</a>
               </div>
		
			   <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq3">
				  <div class="card-body">
					  <div class="row">
						<div class="col text-center">
						 <a href="#"  onClick="openModalApi('emailConfig');" >
							<img src="<?=base_url();?>assets/images/integration-icon/mail.png" width="8%"></a>
					    </div>
					  </div>
				  </div>
				</div>
			  </div>
			</div>
      </div>
    </section>
  </div>
</div>



<!--Modal For Email Config-->

<div class="modal fade" id="emailConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Enter Your Mail Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_data" class="form-horizontal" method="post">
                 <label id="msgDIv"></label>
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>SMTP Host<span style="color: #f76c6c;">*</span></label>
                    <input type="text" name="smtp_host" id="smtp_host" value="<?php if(isset($all_email)){ echo $all_email['smtp_host']; } ?>" class="form-control checkvl" placeholder="SMTP Host (smtp.gmail.com)">
                    <span id="smtp_host_error"></span>
                  </div>
                  <div class="col-md-6">
                    <label>Email address (Login)<span style="color: #f76c6c;">*</span></label>
                    <input type="email" class="form-control checkvl" placeholder="Emailid (example@domain.com)" name="email_id" id="email_id" value="<?php if(isset($all_email)){ echo $all_email['email_id']; } ?>">
						<span id="email_id_error"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>Password<span style="color: #f76c6c;">*</span></label>
                    <div class="input-group mb-2 mr-sm-2">
                        <input type="password" class="form-control checkvl"  name="email_pass" id="email_pass" value="<?php if(isset($all_email)){ echo $all_email['email_password']; } ?>" placeholder="Type Your Password">
                      <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-eye-slash" id="eye"></i></div>
                      </div>
                    </div>
					  <span id="email_pass_error"></span>
                  </div>
                  <div class="col-md-6">
                    <label class="mb-3" >Encryption<span style="color: #f76c6c;">*</span></label>
                      <label class="float-left mr-2 pr-2"><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='tls'){ echo 'checked'; } } ?> value="tls" class="mr-2" >TLS</label>
                      <label class="float-left mr-2"><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='ssl'){ echo 'checked'; } } ?> value="ssl" class="mr-2" >SSL</label>
                      <label class="float-left mr-2"><input type="radio" name="encryption_type" <?php if(isset($all_email)){ if($all_email['encryption_type']=='STARTTLS'){ echo 'checked'; } } ?> value="STARTTLS"  class="mr-2"  >STARTTLS</label>
                      <span id="encryption_type_error"></span>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-6">
                    <label>Folder Retrieve Folders<span style="color: #f76c6c;">*</span></label>
                    <select class="form-control checkvl" name="folder_name" id="folder_name">
                      <option value="inbox" selected="">Inbox</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Port<span style="color: #f76c6c;">*</span></label>
                    <input type="text" name="gmail_port" id="gmail_port" value="<?php if(isset($all_email)){ echo $all_email['gmail_port']; } ?>" placeholder="Port (587)" class="form-control checkvl">
                    <span id="gmail_port_error"></span>
                  </div>
                </div>
               
                <?php if(isset($all_email)){ ?> 
				<input type="hidden" name="config_id" value="<?php echo $all_email['id'] ?>"> 
				<?php  }else{ ?> 
				<input type="hidden" name="config_id" value="add_new_config">
				<?php } ?>
                
              </form>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-secondary" id="callClose">Close</button>
		<button type="button" id="btnSave" onclick="save()" class="btn btn-info w-25 ripple"><?php if(isset($all_email)){ echo 'Update'; }else{ echo 'Save'; } ?></button>
      </div>
    </div>
  </div>
</div>



<!--Modal For Google Ads-->

<div class="modal fade" id="apiGoogle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For Google Ads</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row" id="formDivhd" >
                <div class="col-md-12 form-group">
                   Copy this API and past webhook (URL) integration  :
				   <br><br> <div id="ptapi"><?php if(isset($googleads['api_url']) && $googleads['api_url']!=""){ echo $googleads['api_url']; $apiExt='exist'; }else{ $apiExt='0'; }?>
				   </div>
				   
				   <?php if(isset($googleads['api_url']) && $googleads['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKey" data-upid="<?=$googleads['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
				
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="callClose">Close</button>
      </div>
    </div>
  </div>
</div>



<!--Modal For Just Dial Ads-->

<div class="modal fade" id="apiJustDial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For JustDial Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="row" id="formDivhd" >
                <div class="col-md-12 form-group">
				Please ask just dial team to configure the below URL to receive leads form justDial to team365 CRM
                   <!--Copy this API and past webhook (URL) integration  :-->
				   <br><br> <div id="ptapiJd"><?php if(isset($apijd['api_url']) && $apijd['api_url']!=""){ echo $apijd['api_url']; $apiExtjd='exist'; }else{ $apiExtjd='0'; }?>
				   </div>
				   
				   <?php if(isset($apijd['api_url']) && $apijd['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKeyJd" data-upid="<?=$apijd['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
				
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="callClose">Close</button>
      </div>
    </div>
  </div>
</div>

<!--Modal For Sulekha Ads-->
<div class="modal fade" id="apiSulekha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For Sulekha Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
            <div class="row" >
			
			<div class="col-md-12 form-group">
			<label><b> Note:-</b></label>
				<p class="mb-0">Please ask sulekha team to configure the below URL to receive leads form sulekha to team365 CRM</p>
				<p>API shoukd be POST Formate and given column name.</p>
			</div>
                <div class="col-md-12 form-group">
					<table>
						<tr>
							<th>Fields</th><th>Column Name</th>
						</tr><tr>
							<td>Lead Name</td><td>name</td>
						</tr> <tr>
							<td>Contact Email</td><td>email</td>
						</tr> <tr>
							<td>Office Phone</td><td>office_phone</td>
						</tr> <tr>
							<td>Contact Number</td><td>mobile</td>
						</tr> <tr>
							<td>Contact Name</td><td>contact_name</td>
						</tr> <tr>
							<td>Customer Company</td><td>org_name</td>
						</tr> <tr>
							<td>Product Name</td><td>product_name</td>
						</tr> <tr>
							<td>Address</td><td>address</td>
						</tr> <tr>
							<td>State Name</td><td>state</td>
						</tr> <tr>
							<td>City Name</td><td>city</td>
						</tr>
					</table>
				</div>
				
                <div class="col-md-12 form-group">
				
                   <!--Copy this API and past webhook (URL) integration  :-->
				   <br> <b><div id="ptapiSulekha"><?php if(isset($sulekha['api_url']) && $sulekha['api_url']!=""){ echo $sulekha['api_url']; $apiExtSulekha='exist'; }else{ $apiExtSulekha='0'; }?>
				   </div></b>
				   
				   <?php if(isset($sulekha['api_url']) && $sulekha['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKeySulekha" data-upid="<?=$sulekha['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Modal For Housing Ads-->
<div class="modal fade" id="apiHousing" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For Housing Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
            <div class="row" >
				<div class="col-md-12 form-group">
			<label><b> Note:-</b></label>
				<p class="mb-0">Please ask Housing team to configure the below URL to receive leads form Housing to team365 CRM</p>
				<p>API shoukd be POST Formate and given column name.</p>
			</div>
                <div class="col-md-12 form-group">
					<table>
						<tr>
							<th>Fields</th><th>Column Name</th>
						</tr><tr>
							<td>Lead Name</td><td>name</td>
						</tr> <tr>
							<td>Contact Email</td><td>email</td>
						</tr> <tr>
							<td>Office Phone</td><td>office_phone</td>
						</tr> <tr>
							<td>Contact Number</td><td>mobile</td>
						</tr> <tr>
							<td>Contact Name</td><td>contact_name</td>
						</tr> <tr>
							<td>Customer Company</td><td>org_name</td>
						</tr> <tr>
							<td>Product Name</td><td>product_name</td>
						</tr> <tr>
							<td>Address</td><td>address</td>
						</tr> <tr>
							<td>State Name</td><td>state</td>
						</tr> <tr>
							<td>City Name</td><td>city</td>
						</tr>
					</table>
				</div>
                <div class="col-md-12 form-group">
				
                   <!--Copy this API and past webhook (URL) integration  :-->
				   <br> <b><div id="ptapiHousing"><?php if(isset($housing['api_url']) && $housing['api_url']!=""){ echo $housing['api_url']; $apiExtHousing='exist'; }else{ $apiExtHousing='0'; }?>
				   </div></b>
				   
				   <?php if(isset($housing['api_url']) && $housing['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKeyHousing" data-upid="<?=$housing['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Modal For MagicBricks apiMagicBrcks Ads-->
<div class="modal fade" id="apiMagicBricks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For MagicBricks Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
            <div class="row" >
			
			<div class="col-md-12 form-group">
			<label><b> Note:-</b></label>
				<p class="mb-0">Please ask MagicBricks team to configure the below URL to receive leads form MagicBricks to team365 CRM</p>
				<p>API shoukd be POST Formate and given column name.</p>
			</div>
                <div class="col-md-12 form-group">
					<table>
						<tr>
							<th>Fields</th><th>Column Name</th>
						</tr><tr>
							<td>Lead Name</td><td>name</td>
						</tr> <tr>
							<td>Contact Email</td><td>email</td>
						</tr> <tr>
							<td>Office Phone</td><td>office_phone</td>
						</tr> <tr>
							<td>Contact Number</td><td>mobile</td>
						</tr> <tr>
							<td>Contact Name</td><td>contact_name</td>
						</tr> <tr>
							<td>Customer Company</td><td>org_name</td>
						</tr> <tr>
							<td>Product Name</td><td>product_name</td>
						</tr> <tr>
							<td>Address</td><td>address</td>
						</tr> <tr>
							<td>State Name</td><td>state</td>
						</tr> <tr>
							<td>City Name</td><td>city</td>
						</tr>
					</table>
				</div>
			
                <div class="col-md-12 form-group">
                   <!--Copy this API and past webhook (URL) integration  :-->
				   <br> <b><div id="ptapiMagicBricks"><?php if(isset($magicbricks['api_url']) && $magicbricks['api_url']!=""){ echo $magicbricks['api_url']; $apiExtMagicBricks='exist'; }else{ $apiExtMagicBricks='0'; }?>
				   </div></b>
				   
				   <?php if(isset($magicbricks['api_url']) && $magicbricks['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKeyMagicBricks" data-upid="<?=$magicbricks['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Modal For 99acres Ads-->
<div class="modal fade" id="api99acres" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">API For 99acres Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
            <div class="row" >
			
			<div class="col-md-12 form-group">
			<label><b> Note:-</b></label>
				<p class="mb-0">Please ask 99acres team to configure the below URL to receive leads form 99acres to team365 CRM</p>
				<p>API shoukd be POST Formate and given column name.</p>
			</div>
                <div class="col-md-12 form-group">
					<table>
						<tr>
							<th>Fields</th><th>Column Name</th>
						</tr><tr>
							<td>Lead Name</td><td>name</td>
						</tr> <tr>
							<td>Contact Email</td><td>email</td>
						</tr> <tr>
							<td>Office Phone</td><td>office_phone</td>
						</tr> <tr>
							<td>Contact Number</td><td>mobile</td>
						</tr> <tr>
							<td>Contact Name</td><td>contact_name</td>
						</tr> <tr>
							<td>Customer Company</td><td>org_name</td>
						</tr> <tr>
							<td>Product Name</td><td>product_name</td>
						</tr> <tr>
							<td>Address</td><td>address</td>
						</tr> <tr>
							<td>State Name</td><td>state</td>
						</tr> <tr>
							<td>City Name</td><td>city</td>
						</tr>
					</table>
				</div>
			
                <div class="col-md-12 form-group">
				
                   <!--Copy this API and past webhook (URL) integration  :-->
				   <br> <b><div id="ptapi99acres"><?php if(isset($acres['api_url']) && $acres['api_url']!=""){ echo $acres['api_url']; $apiExtEcres='exist'; }else{ $apiExtEcres='0'; } ?>
				   </div></b>
				   
				   <?php if(isset($acres['api_url']) && $acres['api_url']!=""){?> <br><br> <a style="color: #0d84e2; cursor:pointer;" id="updateKey99acres" data-upid="<?=$acres['id'];?>">Click to Change Your Key.</a><?php } ?>
                </div>
            </div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>


<!--Modal For Trade India-->

<div class="modal fade" id="apiTradeIndia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Setting For Tradeindia Leads</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="tradeindiaFrom" class="needs-validation" novalidate method="post">
		<input type="hidden" id="upid" name="upid" <?php if(isset($tradeindia['id'])){ ?> value="<?=$tradeindia['id'];?>" <?php } ?>>
		<div class="form-group">
            <label for="tuserid">Tradeindia Userid<span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="tuserid" name="tuserid" <?php if(isset($tradeindia['site_userid'])){ ?> value="<?=$tradeindia['site_userid'];?>" <?php } ?> placeholder="Enter Tradeindia User ID">
		</div>	
		<div class="form-group">
			<label for="tprofileid">Tradeindia Profile ID<span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="tprofileid" name="tprofileid" <?php if(isset($tradeindia['site_profileid'])){ ?> value="<?=$tradeindia['site_profileid'];?>" <?php } ?>  placeholder="Enter Tradeindia Profile ID">
		</div>
		<div class="form-group">
			<label for="tkey">Tradeindia CRM Key<span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="tkey" name="tkey"  <?php if(isset($tradeindia['api_key'])){ ?> value="<?=$tradeindia['api_key'];?>" <?php } ?>  placeholder="Enter Tradeindia Key">
		</div>

		<div class="form-group">
			<label for="tnote">Note<span class="text-danger">*</span></label>
			<span style="font-size: 14px;">You need to be a paid customer of Tradeindia to get lead into crm.</span>
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveData" class="btn btn-secondary" ><?php if(isset($tradeindia['api_key'])){ echo "Update"; }else{ echo "Save"; } ?></button>
      </div>
    </div>
  </div>
</div>




<!--Modal For India Mart-->

<div class="modal fade" id="apiIndiamart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Setting For India Mart Leads</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form id="indiamartFrom" class="needs-validation" novalidate method="post">
	  <input type="hidden" id="upidmart" name="upidmart" <?php if(isset($indiamart['id'])){ ?> value="<?=$indiamart['id'];?>" <?php } ?>>
		<div class="form-group">
            <label for="mart_mobile">Indiamart Register Mobile<span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mart_mobile" name="mart_mobile" <?php if(isset($indiamart['site_mobile'])){ ?> value="<?=$indiamart['site_mobile'];?>" <?php } ?> placeholder="Enter Indiamart Mobile Number">
		</div>	
		<div class="form-group">
			<label for="mart_key">Indiamart API Key<span class="text-danger">*</span></label>
			<input type="text" class="form-control" id="mart_key" name="mart_key" <?php if(isset($indiamart['api_key'])){ ?> value="<?=$indiamart['api_key'];?>" <?php } ?>  placeholder="Enter Indiamart Key">
		</div>
		
		<div class="form-group">
			<label for="tnote">Note<span class="text-danger">*</span></label>
			<span style="font-size: 14px;">You need to be a paid customer of Indiamart to get lead into crm.</span>
		</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveDataMart" class="btn btn-secondary" ><?php if(isset($indiamart['api_key'])){ echo "Update"; }else{ echo "Save"; } ?></button>
      </div>
    </div>
  </div>
</div>


<!-- common footer include -->
<?php $this->load->view('common_footer');?>

<script>
function openModalApi(mdlId){
	var apiExt		="<?=$apiExt;?>";
	var apiExtJd	="<?=$apiExtjd;?>";
	var apiExtSulekha="<?=$apiExtSulekha;?>";
	var apiExtHousing="<?=$apiExtHousing;?>";
	var apiExtMagicBricks="<?=$apiExtMagicBricks;?>";
	var apiExtEcres="<?=$apiExtEcres;?>";
	if(mdlId=='apiGoogle' && apiExt!="exist"){
		//addApi('add','');
		var url= "<?= site_url(); ?>/integration/add_api";
		addApi('add','',url,'google ads','ptapi');
	}
	if(mdlId=='apiJustDial' && apiExtJd!="exist"){
		addApiJd('add','');
	}
	if(mdlId=='apiSulekha' && apiExtSulekha!="exist"){
		var url= "<?= site_url(); ?>/integration/add_api_common";
		addApi('add','',url,'sulekha','ptapiSulekha');
	}
	if(mdlId=='apiHousing' && apiExtHousing!="exist"){
		var url= "<?= site_url(); ?>/integration/add_api_common";
		addApi('add','',url,'housing','ptapiHousing');
	}
	if(mdlId=='apiMagicBricks' && apiExtMagicBricks!="exist"){
		var url= "<?= site_url(); ?>/integration/add_api_common";
		addApi('add','',url,'magicbricks','ptapiMagicBricks');
	}
	if(mdlId=='api99acres' && apiExtEcres!="exist"){
		var url= "<?= site_url(); ?>/integration/add_api_common";
		addApi('add','',url,'99acres','ptapi99acres');
	}
	
	$("#"+mdlId).modal('show');
}


function addApi(action,upid='',url,api_name,ptapi){
	$.ajax({
        url: url,
        type: "POST",
		data: {api_name:api_name,action:action,upid:upid},
        success: function(data)
        { 
			if(action=='add'){
				toastr.success('Api key successfully created');
			}else{
				toastr.success('Api key successfully updated');
			}
			
			$("#"+ptapi).html(data);
			//$("#apiGoogle").modal('show');
		}
	});
}


$("#updateKeySulekha").click(function(){
	var upid=$(this).data('upid');
	var url= "<?= site_url(); ?>/integration/add_api_common";
	addApi('update',upid,url,'sulekha','ptapiSulekha');
});

$("#updateKeyHousing").click(function(){
	var upid=$(this).data('upid');
	var url= "<?= site_url(); ?>/integration/add_api_common";
	addApi('update',upid,url,'housing','ptapiHousing');
});

$("#updateKeyMagicBricks").click(function(){
	var upid=$(this).data('upid');
	var url= "<?= site_url(); ?>/integration/add_api_common";
	addApi('update',upid,url,'magicbricks','ptapiMagicBricks');
});
$("#updateKey99acres").click(function(){
	var upid=$(this).data('upid');
	var url= "<?= site_url(); ?>/integration/add_api_common";
	addApi('update',upid,url,'99acres','ptapi99acres');
});


$("#updateKeyJd").click(function(){
	var upid=$(this).data('upid');
	addApiJd('update',upid);
});



$(".close").click(function(){
	//$('#tradeindiaFrom')[0].reset();
	$("#tradeindiaFrom input").removeClass('is-invalid');
	$("#tradeindiaFrom input").removeClass('is-valid');
	$("#indiamartFrom input").removeClass('is-invalid');
	$("#indiamartFrom input").removeClass('is-valid');
});

$(".form-control").keyup(function(){
	var data=$(this).val();
	if(data!=""){
	$(this).removeClass('is-invalid');
	$(this).addClass('is-valid');
	}
});


$("#saveDataMart").click(function(){
   var mart_mobile	= $("#mart_mobile").val();
   var mart_key		= $("#mart_key").val();
   var upid			= $("#upidmart").val();
   if(mart_mobile==""){
	   $("#mart_mobile").addClass('is-invalid');
   }else if(mart_key==""){
	   $("#mart_key").addClass('is-invalid');
   }else{
	   var textData=$("#saveDataMart").text();
	   if(textData=='Update'){ action='update'; }else{ action='add';  }
	   $.ajax({
        url: "<?= site_url(); ?>/integration/add_data_mart",
        type: "POST",
		data: {api_name:'indiamart',action:action,upid:upid,mart_mobile:mart_mobile,mart_key:mart_key},
        success: function(data)
        { 
			if(action=='add'){
				toastr.success('Indiamart info successfully added');
			}else{
				toastr.success('Indiamart info successfully updated');
			}
			$(".close").click();
			$("#mart_mobile").val(mart_mobile);
			$("#mart_key").val(mart_key);
			$("#saveDataMart").html('Update');
		}
	   });  
   }
});

$("#saveData").click(function(){
   var tuserid		=$("#tuserid").val();
   var tprofileid	=$("#tprofileid").val();
   var tkey			=$("#tkey").val();
   var upid			=$("#upid").val();
   if(tuserid==""){
	   $("#tuserid").addClass('is-invalid');
   }else if(tprofileid==""){
	   $("#tprofileid").addClass('is-invalid');
   }else if(tkey==""){
	   $("#tkey").addClass('is-invalid');
   }else{
	   var textData=$("#saveData").text();
	   if(textData=='Update'){ action='update'; }else{ action='add';  }
	   $.ajax({
        url: "<?= site_url(); ?>/integration/add_data_trade",
        type: "POST",
		data: {api_name:'tradeindia',action:action,upid:upid,tuserid:tuserid,tprofileid:tprofileid,tkey:tkey},
        success: function(data)
        { 
			if(action=='add'){
				toastr.success('Tradeindia info successfully added');
			}else{
				toastr.success('Tradeindia info successfully updated');
			}
			$(".close").click();
			$("#tuserid").val(tuserid);
			$("#tprofileid").val(tprofileid);
			$("#tkey").val(tkey);
			$("#saveData").html('Update');
		}
	   });  
   }
});



function save()
    { 
        
        $("#smtp_host_error").html('');
		$("#encryption_type_error").html('');
		$("#gmail_port_error").html('');
	    $("#email_id_error").html('');
		$("#email_pass_error").html('');
		var addconfig = $("input[name='config_id']").val();
		if($('input[name="encryption_type"]:checked').length == 0) {
			$('#encryption_type_error').html('<p style="color:red">Please ckeck any one.</p>');
			return false;
        }else if(checkValidationWithClass('form_data')==1){
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
				   
					if(data.status==true) 
					{
						$('#btnSave').text('Save'); 
					    $('#btnSave').attr('disabled',false);
					    if(addconfig == 'add_new_config'){
							toastr.success('Email config data saved successfully.');	
						 
					    }else{
					        toastr.success('Email config data updated successfully.');
					    }
						$("#emailConfig").modal('hide');
					}else if(data.st==202){
					    $("#smtp_host_error").html(data.smtp_host);
						$("#email_id_error").html(data.email_id);
						$("#email_pass_error").html(data.email_pass);
					    $("#encryption_type_error").html(data.encryption_type);
		                $("#gmail_port_error").html(data.gmail_port);
						$('#btnSave').text('Save'); 
					    $('#btnSave').attr('disabled',false);
					}else{
						toastr.error('Some error occure!');
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



//add_api_common


$("#updateKeyJd").click(function(){
	var upid=$(this).data('upid');
	addApiJd('update',upid);
});

function addApiJd(action,upid=''){
	$.ajax({
        url: "<?= site_url(); ?>/integration/add_api_jd",
        type: "POST",
		data: {api_name:'just dial',action:action,upid:upid},
        success: function(data)
        { 
			if(action=='add'){
				toastr.success('Api key successfully created');
			}else{
				toastr.success('Api key successfully updated');
			}
			$("#ptapiJd").html(data);
			$("#apiJustDial").modal('show');
		}
	});
}




/*
function addApi(action,upid=''){
	$.ajax({
        url: "<?= site_url(); ?>/integration/add_api",
        type: "POST",
		data: {api_name:'google ads',action:action,upid:upid},
        success: function(data)
        { 
		if(action=='add'){
			toastr.success('Api key successfully created');
		}else{
			toastr.success('Api key successfully updated');
		}
			$("#ptapi").html(data);
			$("#apiGoogle").modal('show');
		}
	});
}*/

$("#callClose").click(function(){  
 $("#apiGoogle").modal('hide');
});
</script>
