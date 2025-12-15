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
<div class="content-wrapper">


<?php
if($this->session->userdata('account_type')=="Trial" && $countOpp>=1000){ 
?>
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12 mb-3 mt-5 text-center">
              <i class="fas fa-exclamation-triangle" style="color: #f59393; font-size: 28px;"></i>
              </div>
            <div class="col-md-12 mb-3 text-center">
              You are now using trial account.<br>
			  <text>You are exceeded  your opportunity limit - 1,000</text><br>
			  <text>You can add only  1,000 opportunity on trial account</text><br>
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
          <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;"><?php if(isset($action['data']) && $action['data']=='update'){ echo "Update"; }else{ echo "Add"; } ?> Opportunity Form</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."leads "; ?>">opportunity</a>
            </li>
            <li class="breadcrumb-item active">add opportunity</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  
  
  <div class="linkscontainer">
  <form class="form-horizontal"  id="opp_form" method="post" enctype = "multipart/form-data">
  <div class="form-proforma">
    <div class="container">
	
	 <?php $sub_opp = $this->input->get('sub_opp');
          if ($sub_oppData) {
            $sub_opp_id = $sub_opp;
          }else{
            $sub_opp_id = '0';
          } ?>
          
      <div class="row">
	  
          <input type="hidden" name="save_method" id="save_method" value="<?php if(isset($action['data']) && $action['data']=='update'){ echo 'Update'; }else{ echo "add";  }  ?>" >
		  <input type="hidden"  name="id"  id="id" value="<?php if(isset($record['id']) &&  $action['from']=='opportunity'){ echo $record['id']; }  ?>">
		  <input type="hidden"  name="lead_id"  id="lead_id" value="<?php if(isset($record['id']) && $action['from']=='lead' ){ echo $record['id']; }  ?>">
		  <input type="hidden"  name="lead_id_uri"  id="lead_id_uri" value="<?php if(!empty($this->uri->segment(2))){ echo $this->uri->segment(2); }?>">
		  <input id="lead_test_val" name="total_percent" type="hidden" value="<?php if(isset($record['total_percent'])){ echo $record['total_percent']; }else{ echo "100.00"; }  ?>">
		  <input type="hidden"  class="put_org_id"  name="org_id_act"  id="org_id_act" value="<?php if(isset($record['org_id'])){ echo $record['org_id']; }  ?>">
		  <input type="hidden"   class="put_cnt_id" name="cnt_id_act"  id="cnt_id_act" value="<?php if(isset($record['cont_id'])){ echo $record['cont_id']; }  ?>">
		  
		 <!--   <div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Opportunity Ownership<span class="text-danger">*</span>:</label>-->
   <!--             <input type="text" class="form-control" name="owner" placeholder="Enter Lead Name."  value="<?php if(isset($record['owner'])){ echo $record['owner']; }else{ echo $this->session->userdata('name'); }?>" readonly >-->
			<!--	<span id="invoice_no_error"></span>-->
   <!--           </div>-->
			<!--</div> -->
			<!--<div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Opportuntiy Name<span class="text-danger">*</span>:</label>-->
   <!--            <input type="text" class="form-control checkvl" name="name" id="Lfname" value="<?php if(isset($record['name'])){ echo $record['name']; }  ?>" placeholder="Opportuntiy Name">-->
			<!--	<span id="name_error"></span>-->
   <!--           </div>-->
			<!--</div>-->
			<!--<div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Customer Name<span class="text-danger">*</span>:</label>-->
   <!--             <div class="input-group">-->
   <!--                 <input type="text" class="form-control orgName checkvl" name="org_name" placeholder="Organization Name" id="org_name_check" required  autocomplete="off" value="<?php if(isset($record['org_name'])){ echo $record['org_name']; }  ?>" >-->
			<!--		<div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','opp_form')">-->
			<!--			<span class="input-group-text" style="border-radius: 0px;"><i class="fas fa-plus-circle"></i></span>-->
			<!--		</div>-->
   <!--             </div>-->
			<!--	<span id="org_name_error"></span>-->
   <!--           </div>-->
			<!--</div>-->
			
			<?php if ($sub_oppData['track_status']) { ?>
                  <input type="hidden" name="track_status" id="track_status" value="<?= $sub_oppData['track_status']; ?>" >
             <?php }else{ ?>
                <input type="hidden" name="track_status" id="track_status" value="opportunity" >
             <?php } ?>

            <?php if ($sub_oppData['owner']) { ?>
              <div class="col-lg-6">
                    <div class="form-group">
                      <label for="">Opportunity Ownership<span class="text-danger">*</span>:</label>
                      <input type="hidden" name="sub_opp_id" id="sub_opp_id" value="<?= $sub_opp_id; ?>" >
                      <input type="text" class="form-control" name="owner" placeholder="Enter Lead Name."  value="<?php if(isset($sub_oppData['owner'])){ echo $sub_oppData['owner']; }else{ echo $this->session->userdata('name'); }?>" readonly >
                      <span id="invoice_no_error"></span>
                    </div>
              </div>
            <?php }else{ ?>
    
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="">Opportunity Ownership<span class="text-danger">*</span>:</label>
                     <input type="hidden" name="sub_opp_id" id="sub_opp_id" value="<?= $sub_opp_id; ?>" >
                    <input type="text" class="form-control" name="owner" placeholder="Enter Lead Name."  value="<?php if(isset($record['owner'])){ echo $record['owner']; }else{ echo $this->session->userdata('name'); }?>" readonly >
    				        <span id="invoice_no_error"></span>
                  </div>
    			</div>
    
            <?php } ?>


            <?php if ($sub_oppData['name']) { ?>
                 <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Opportuntiy Name<span class="text-danger">*</span>:</label>
                       <input type="text" class="form-control checkvl" name="name" id="Lfname" value="<?php if(isset($sub_oppData['name'])){ echo $sub_oppData['name']; }  ?>" placeholder="Opportuntiy Name">
        				    <span id="name_error"></span>
                      </div>
        			</div>
            <?php }else{ ?>
        
              <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Opportuntiy Name<span class="text-danger">*</span>:</label>
                       <input type="text" class="form-control checkvl" name="name" id="Lfname" value="<?php if(isset($record['name'])){ echo $record['name']; }  ?>" placeholder="Opportuntiy Name">
        				    <span id="name_error"></span>
                      </div>
        			</div>
        
            <?php } ?>
            
            
          <!--   <div class="col-lg-6">-->
          <!--            <div class="form-group">-->
          <!--              <label for="">Customer Name<span class="text-danger">*</span>:</label>-->
          <!--              <div class="input-group">-->
          <!--                  <input type="text" class="form-control orgName checkvl" name="org_name" placeholder="Organization Name" id="org_name_check" required  autocomplete="off" value="<?php if(isset($record['org_name'])){ echo $sub_oppData['org_name']; } ?>" >-->
        		<!--			         <div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','opp_form')">-->
        		<!--				        <span class="input-group-text" style="border-radius: 0px;"><i class="fas fa-plus-circle"></i></span>-->
        		<!--			      </div>-->
          <!--              </div>-->
        		<!--		    <span id="org_name_error"></span>-->
          <!--            </div>-->
        		<!--</div>-->


            <?php if ($sub_oppData['org_name']) { ?>
                <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Customer Name<span class="text-danger">*</span>:</label>
                        <div class="input-group">
                            <input type="text" class="form-control orgName checkvl" name="org_name" placeholder="Organization Name" id="org_name_check" required autocomplete="off" value="<?php if(isset($sub_oppData['org_name'])){ echo $sub_oppData['org_name']; } ?>">
        					       <div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','opp_form')">
        						        <span class="input-group-text" style="border-radius: 0px;"><i class="fas fa-plus-circle"></i></span>
        					      </div>
                        </div>
        				    <span id="org_name_error"></span>
                      </div>
        		</div>
            <?php }else{ ?>
        
              <div class="col-lg-6">
                      <div class="form-group">
                        <label for="">Customer Name<span class="text-danger">*</span>:</label>
                        <div class="input-group">
                            <input type="text" class="form-control orgName checkvl" name="org_name" placeholder="Organization Name" id="org_name_check" required autocomplete="off" value="<?php if(isset($record['org_name'])){ echo $record['org_name']; } ?>">
        					   <div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','opp_form')">
        						 <span class="input-group-text" style="border-radius: 0px;"><i class="fas fa-plus-circle"></i></span>
        					   </div>
                        </div>
        				    <span id="org_name_error"></span>
                      </div>
        			</div>
        
            <?php } ?>
			
			
			
			<div class="col-lg-6">
              <div class="form-group">
                <label for="">Contact Name<span class="text-danger">*</span>:</label>
                <select class="form-control orgContact checkvl" name="contact_name" id="opp_contact_name">
				<?php if(!isset($record['contact_name'])){  ?>
                    <option value="" selected="" disabled="">Select Contact Name</option>
				<?php } ?>	
					<option value="<?php if(isset($record['contact_name'])){ echo $record['contact_name']; } ?>" selected=""  ><?php if(isset($record['contact_name'])){ echo $record['contact_name']; } ?></option>
					
                </select>
				<span id="invoice_no_error"></span>
              </div>
			</div>
			
			<!--<div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Email Address<span class="text-danger">*</span>:</label>-->
   <!--             <input type="text" class="form-control orgEmail checkvl" name="email" placeholder="Enter Customer Email." id="lead_email" value="<?php if(isset($record['email'])){ echo $record['email']; }  ?>">-->
			<!--	<span id="email_error"></span>-->
   <!--           </div>-->
			<!--</div>-->
			<!--<div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Mobile Number<span class="text-danger">*</span>:</label>-->
   <!--             <input type="text" class="form-control orgMobile checkvl numeric" name="mobile" placeholder="Enter Mobile Number." id="mobile_op" maxlength="10" value="<?php if(isset($record['mobile'])){ echo $record['mobile']; }  ?>">-->
			<!--	<span id="mobile_error"></span>-->
   <!--           </div>-->
			<!--</div>-->
			<!--<div class="col-lg-6">-->
   <!--           <div class="form-group">-->
   <!--             <label for="">Expected Closing Date <span class="text-danger">*</span> :</label>-->
			<!--	<input type="text" onfocus="(this.type='date')" class="form-control checkvl" id="expcloseDate" name="expclose_date" placeholder="Expected Closing Date (DD-MM-YYYY)" value="<?php if(isset($record['expclose_date'])){ echo $record['expclose_date']; }  ?>" >-->
                
			<!--	<span id="invoice_no_error"></span>-->
   <!--           </div>-->
			<!--</div>-->
			
			
			
             <?php if ($sub_oppData['email']) { ?>
                    <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Email Address<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control orgEmail checkvl" name="email" placeholder="Enter Customer Email." id="lead_email" value="<?php if(isset($sub_oppData['email'])){ echo $sub_oppData['email']; }  ?>">
            				      <span id="email_error"></span>
                          </div>
            			</div>
                 <?php }else{ ?>
            
                 <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Email Address<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control orgEmail checkvl" name="email" placeholder="Enter Customer Email." id="lead_email" value="<?php if(isset($record['email'])){ echo $record['email']; }  ?>">
            				      <span id="email_error"></span>
                          </div>
            			</div>
            
                <?php } ?>
            
            
             <?php if ($sub_oppData['mobile']) { ?>
                    <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Mobile Number<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control orgMobile checkvl numeric" name="mobile" placeholder="Enter Mobile Number." id="mobile_op" maxlength="10" value="<?php if(isset($sub_oppData['mobile'])){ echo $sub_oppData['mobile']; }  ?>">
            				        <span id="mobile_error"></span>
                          </div>
            			</div>
                 <?php }else{ ?>
                    <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Mobile Number<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control orgMobile checkvl numeric" name="mobile" placeholder="Enter Mobile Number." id="mobile_op" maxlength="10" value="<?php if(isset($record['mobile'])){ echo $record['mobile']; }  ?>">
            				        <span id="mobile_error"></span>
                          </div>
            			</div>
            
                <?php } ?>
            
            			
            
                  <?php if ($sub_oppData['expclose_date']) { ?>
                    <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Expected Closing Date <span class="text-danger">*</span> :</label>
            				        <input type="text" onfocus="(this.type='date')" class="form-control checkvl" id="expcloseDate" name="expclose_date" placeholder="Expected Closing Date (DD-MM-YYYY)" value="<?php if(isset($sub_oppData['expclose_date'])){ echo $sub_oppData['expclose_date']; }  ?>" >
             
            				        <span id="invoice_no_error"></span>
                          </div>
            			</div>
                 <?php }else{ ?>
            
                  <div class="col-lg-6">
                          <div class="form-group">
                            <label for="">Expected Closing Date <span class="text-danger">*</span> :</label>
            				        <input type="text" onfocus="(this.type='date')" class="form-control checkvl" id="expcloseDate" name="expclose_date" placeholder="Expected Closing Date (DD-MM-YYYY)" value="<?php if(isset($record['expclose_date'])){ echo $record['expclose_date']; }  ?>" >
             
            				        <span id="invoice_no_error"></span>
                          </div>
            			</div>
            
                <?php } ?>
            			
			
			
			
			
			
			
			<div class="col-lg-6">
              <div class="form-group">
                <label for="">Pipeline:</label>
                <select class="form-control" id="pipelineId" name="pipeline">
                    <option value="Pipeline" value="<?php if(isset($record['pipeline']) && $record['pipeline']=='Pipeline'){ echo "selected"; }  ?>">Pipeline</option>
                    <option value="Standard" value="<?php if(isset($record['pipeline'])  && $record['pipeline']=='Standard'){ echo "selected"; }  ?>" >Standard</option>
                </select>
				<span id="invoice_no_error"></span>
              </div>
			</div>
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
			    <?php 
				if(isset($record['type'])){ 
					$dataSts=$record['type']; 
				}else{ 
					$dataSts=''; 
				}  ?>
			  
              <div class="form-group">
                <label for="">Customer Type<span class="text-danger">*</span>:</label>
                <select class="form-control checkvl" id="typeId" name="type">
                        <option selected="" disabled="">Type</option>
                        <option value="New Customer" <?php if($dataSts=='New Customer'){ echo "selected"; } ?> >New Customer</option>
                        <option value="Existing Customer" <?php if($dataSts=='Existing Customer'){ echo "selected"; } ?> >Existing Customer</option>
                        <option value="Partner" <?php if($dataSts=='Partner'){ echo "selected"; } ?> >Partner</option>
                </select>
				<span id="lead_status_error"></span>
              </div>
			</div>
			
			<div class="col-lg-6">
			    <?php 
				if(isset($record['lead_status'])){
					$dataSts=$record['lead_status'];
				}else if(isset($record['stage'])){ 
					$dataSts=$record['stage']; 
				}else{ 
					$dataSts=''; 
				}  ?>
			  
              <div class="form-group">
                <label for="">Opportunity Stage<span class="text-danger">*</span>:</label>
                <select class="form-control checkvl" id="stage" name="stage">
                    <option selected="" disabled="">Stage</option>
                    <option value="Qualifying" <?php if($dataSts=='Qualifying'){ echo "selected"; } ?> >Qualifying</option>
                    <option value="Needs Analysis" <?php if($dataSts=='Needs Analysis'){ echo "selected"; } ?> >Needs Analysis</option>
                    <option value="Proposal" <?php if($dataSts=='Proposal'){ echo "selected"; } ?> >Proposal</option>
                    <option value="Negotiation" <?php if($dataSts=='Negotiation'){ echo "selected"; } ?> >Negotiation</option>
                    <option value="Closed Won" <?php if($dataSts=='Closed Won'){ echo "selected"; } ?> >Closed Won</option>
                    <option value="Closed Lost" <?php if($dataSts=='Closed Lost'){ echo "selected"; } ?> >Closed Lost</option>
                </select>
				<span id="lead_status_error"></span>
              </div>
			</div>
			
			<div class="col-lg-6">
              <div class="form-group">
                <label for="">Probability:</label>
                <input type="text" class="form-control" id="probability" name="probability" placeholder="Probability" value="<?php if(isset($record['probability'])){ echo $record['probability']; }  ?>">
				<span id="lead_status_error"></span>
              </div>
			</div>
			
			
			<div class="col-lg-6">
			<?php 
				if(isset($record['industry'])){ 
					$dataTp=$record['industry']; 
				}else{ 
					$dataTp=''; 
				}  ?>
              <div class="form-group">
                <label for="">Industry Type<span class="text-danger">*</span>:</label>
                <select class="form-control orgIndustry checkvl" name="industry" id="ldindustry" required="">
                    <option value="" selected="" disabled="">Select Industry Type</option>
                    <option value="Government" <?php if($dataTp=='Government'){ echo "selected"; } ?> >Government</option>
                    <option value="Other" <?php if($dataTp=='Other'){ echo "selected"; } ?> >Other</option>
                    <option value="Utilies" <?php if($dataTp=='Utilies'){ echo "selected"; } ?> >Utilies</option>
                    <option value="Transportation" <?php if($dataTp=='Transportation'){ echo "selected"; } ?> >Transportation</option>
                    <option value="Telecommunications" <?php if($dataTp=='Telecommunications'){ echo "selected"; } ?> >Telecommunications</option>
                    <option value="Technology" <?php if($dataTp=='Technology'){ echo "selected"; } ?> >Technology</option>
                    <option value="'Shipping" <?php if($dataTp=='Shipping'){ echo "selected"; } ?> >Shipping</option>
                    <option value="Retail" <?php if($dataTp=='Retail'){ echo "selected"; } ?> >Retail</option>
                    <option value="Recreation" <?php if($dataTp=='Recreation'){ echo "selected"; } ?> >Recreation</option>
                    <option value="Not For Profit" <?php if($dataTp=='Not For Profit'){ echo "selected"; } ?> >Not For Profit</option>
                    <option value="Media" <?php if($dataTp=='Media'){ echo "selected"; } ?> >Media</option>
                    <option value="Manufacturing" <?php if($dataTp=='Manufacturing'){ echo "selected"; } ?> >Manufacturing</option>
                    <option value="Machinery" <?php if($dataTp=='Machinery'){ echo "selected"; } ?> >Machinery</option>
                    <option value="Insurance" <?php if($dataTp=='Insurance'){ echo "selected"; } ?> >Insurance</option>
                    <option value="Hospitality" <?php if($dataTp=='Hospitality'){ echo "selected"; } ?> >Hospitality</option>
                    <option value="Healthcare" <?php if($dataTp=='Healthcare'){ echo "selected"; } ?> >Healthcare</option>
                    <option value="Apparel" <?php if($dataTp=='Apparel'){ echo "selected"; } ?> >Apparel</option>
                    <option value="Food and Baverage" <?php if($dataTp=='Food and Baverage'){ echo "selected"; } ?> >Food and Baverage</option>
                    <option value="Finance" <?php if($dataTp=='Finance'){ echo "selected"; } ?> >Finance</option>
                    <option value="Environmental" <?php if($dataTp=='Environmental'){ echo "selected"; } ?> >Environmental</option>
                    <option value="Entertainment" <?php if($dataTp=='Entertainment'){ echo "selected"; } ?> >Entertainment</option>
                    <option value="Engineering" <?php if($dataTp=='Engineering'){ echo "selected"; } ?> >Engineering</option>
                    <option value="Energy" <?php if($dataTp=='Energy'){ echo "selected"; } ?> >Energy</option>
                    <option value="Electronic" <?php if($dataTp=='Electronic'){ echo "selected"; } ?> >Electronic</option>
                    <option value="Education" <?php if($dataTp=='Education'){ echo "selected"; } ?> >Education</option>
                    <option value="Consulting" <?php if($dataTp=='Consulting'){ echo "selected"; } ?> >Consulting</option>
                    <option value="Construction" <?php if($dataTp=='Construction'){ echo "selected"; } ?> >Construction</option>
                    <option value="Communications" <?php if($dataTp=='Communications'){ echo "selected"; } ?> >Communications</option>
                    <option value="Chemicals" <?php if($dataTp=='Chemicals'){ echo "selected"; } ?> >Chemicals</option>
                    <option value="Biotechnology" <?php if($dataTp=='Biotechnology'){ echo "selected"; } ?> >Biotechnology</option>
                    <option value="Banking" <?php if($dataTp=='Banking'){ echo "selected"; } ?> >Banking</option>
                </select>
				<span id="invoice_no_error"></span>
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
			<?php 
			if(isset($record['annual_revenue'])){ 
				$revenue=$record['annual_revenue'];
			}else if(isset($record['weighted_revenue'])) {
				$revenue=$record['weighted_revenue'];
			}else{
				$revenue='';
			}
				?>
			
              <div class="form-group">
                <label for="">Annual Revenue:</label>
                <input type="text" class="form-control ordAnnualRevenue" id="lfannual_revenue" name="weighted_revenue" placeholder="Annual Revenue" value="<?php if(isset($revenue)){ echo $revenue; }  ?>">
				<span id="invoice_no_error"></span>
              </div>
			</div>
			
			<div class="col-lg-6">
			<?php 
				if(isset($record['lost_reason'])){ 
					$dataRt=$record['lost_reason']; 
				}else{ 
					$dataRt=''; 
				}  ?>
              <div class="form-group">
                <label for="">Lost Reason:</label>
                <select class="form-control" name="lost_reason" id="lost_reason">
                        <option selected="" disabled="">Lost Reason</option>
                        <option value="Lost To Competitor" <?php if($dataRt=='Lost To Competitor'){ echo "selected"; } ?> >Lost To Competitor</option>
                        <option value="NO Budget/Lost Funding" <?php if($dataRt=='NO Budget/Lost Funding'){ echo "selected"; } ?> >No Budget/Lost Funding</option>
                        <option value="No Decision/Non-Responsive" <?php if($dataRt=='No Decision/Non-Responsive'){ echo "selected"; } ?> >No Decision/Non-Responsive</option>
                        <option value="Price" <?php if($dataRt=='Price'){ echo "selected"; } ?> >Price</option>
                        <option value="Other" <?php if($dataRt=='Other'){ echo "selected"; } ?> >Other</option>
                </select>
				<span id="invoice_no_error"></span>
              </div>
			</div>
      </div>
    </div>
  </div>
  <div class="billing-section" style="padding-top:0px;">
    <div class="container">
	
	<div class="col-md-12 mt-4">
        <div class="row">
            <div class="col-md-12">
                <h6 style="cursor:pointer;" data-toggle="collapse" href="#collapseExample" ><i class="fas fa-plus-circle"></i> Add Follow Up</h6>
            </div>
            <div class="col-md-12 pb-4 collapse" id="collapseExample" >
			<?php if(check_permission_status('Task','create_u')==true){ ?>
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#exampleModal">Task</button>
			<?php } if(check_permission_status('Meeting','create_u')==true){ ?>	
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#meeting_click">Meeting</button>
			<?php } if(check_permission_status('Call','create_u')==true){ ?>
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#call_click">Call</button>
			<?php } ?>	
            </div>
        </div>
    </div>
	
	
	
      <div class="proforma-table-main">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="">
              <table class="table table-responsive-lg" width="100%" id="add_new_line" >
                <thead style="background:rgba(35,0,140,0.8);">
                  <tr>
                    <th>Items</th>
                    <th>Quantity</th>
                    <th>Rate</th>                    
                    <th>Total Amount</th>
                  </tr>
                </thead>
				
                     <?php 
                    $rw=45;
                    if ($sub_oppData['product_name']) { ?>
                      <?php 
                          $rw=45;
                          $proName	= explode("<br>",$sub_oppData['product_name']); 
                          $quantity	= explode("<br>",$sub_oppData['quantity']); 
                          $unit_price	= explode("<br>",$sub_oppData['unit_price']); 
                          $total		= explode("<br>",$sub_oppData['total']); 
                          $proDescription= explode("<br>",$sub_oppData['pro_description']); 

                          //print_r($proDescription);
                                  for($pr=0; $pr<count($proName); $pr++){ ?>
                                            <tr class="removCL<?=$rw;?>">
                                              <td>
                                              <input type="text"  name="product_name[]"  class="form-control productItm checkvl" onkeyup="getproductinfo();" id="proName<?=$pr;?>" data-cntid="<?=$pr;?>" placeholder="Items name(required)" value="<?=htmlspecialchars($proName[$pr]);?>"><span id="items_error"></span></td>
                                    
                                              <td><input type="text"  onkeyup="calculate_pro_price()" class="form-control checkvl numeric" name="quantity[]" id="qty<?=$pr;?>"  placeholder="qty" value="<?=$quantity[$pr];?>"><span id="quantity_error"></span></td>
                                    
                                              <td><input type="text" class="form-control start checkvl parseFloat" onkeyup="calculate_pro_price()" name="unit_price[]"  id="price<?=$pr;?>"  placeholder="rate" value="<?=$unit_price[$pr];?>"><span id="unit_price_error"></span></td>   
                                    
                                              <td><input type="text" class="form-control " name="total[]"  id="total<?=$pr;?>" class="" readonly value="<?=$total[$pr];?>"></td>
                                            </tr>

                                            <tr class=" <?php if(empty($proDescription[$pr])){ ?> pro_descrption <?php } ?>  removCL<?=$rw;?> addCL<?=$rw;?>" <?php if(empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> >
                                              <td colspan="4">
                                                <input type="text" class="form-control " name="pro_description[]" id="description<?=$pr;?>" value="<?php if(isset($proDescription[$pr])){ echo htmlspecialchars($proDescription[$pr]); }?>"  placeholder="Description">
                                              </td>
                                            </tr>

                                            <tr class="removCL<?=$rw;?>">
                                              <td class="delete_new_line" colspan="1" onClick="removeRow('removCL<?=$rw;?>');">
                                                <a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                                              </td> 
                                              <td colspan="3">
                                                <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" <?php if(!empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                                              </td>   
                                            </tr>
                                    
                                  <?php $rw++; }
                      ?>
                     
                    <?php }else{ ?>
                      
                      <?php 
                                $rw=45;

                                if(isset($record['product_name'])){
                                  $proName	= explode("<br>",$record['product_name']); 
                                  $quantity	= explode("<br>",$record['quantity']); 
                                  $unit_price	= explode("<br>",$record['unit_price']); 
                                  $total		= explode("<br>",$record['total']); 
                                  $proDescription= explode("<br>",$record['pro_description']); 
                                  
                          
                                  //print_r($proDescription);
                                  for($pr=0; $pr<count($proName); $pr++){ ?>
                                            <tr class="removCL<?=$rw;?>">
                                              <td>
                                              <input type="text"  name="product_name[]"  class="form-control productItm checkvl" onkeyup="getproductinfo();" id="proName<?=$pr;?>" data-cntid="<?=$pr;?>" placeholder="Items name(required)" value="<?=htmlspecialchars($proName[$pr]);?>"><span id="items_error"></span></td>
                                    
                                              <td><input type="text"  onkeyup="calculate_pro_price()" class="form-control checkvl numeric" name="quantity[]" id="qty<?=$pr;?>"  placeholder="qty" value="<?=$quantity[$pr];?>"><span id="quantity_error"></span></td>
                                    
                                              <td><input type="text" class="form-control start checkvl parseFloat" onkeyup="calculate_pro_price()" name="unit_price[]"  id="price<?=$pr;?>"  placeholder="rate" value="<?=$unit_price[$pr];?>"><span id="unit_price_error"></span></td>   
                                    
                                              <td><input type="text" class="form-control " name="total[]"  id="total<?=$pr;?>" class="" readonly value="<?=$total[$pr];?>"></td>
                                            </tr>

                                            <tr class=" <?php if(empty($proDescription[$pr])){ ?> pro_descrption <?php } ?>  removCL<?=$rw;?> addCL<?=$rw;?>" <?php if(empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> >
                                              <td colspan="4">
                                                <input type="text" class="form-control " name="pro_description[]" id="description<?=$pr;?>" value="<?php if(isset($proDescription[$pr])){ echo htmlspecialchars($proDescription[$pr]); }?>"  placeholder="Description">
                                              </td>
                                            </tr>

                                            <tr class="removCL<?=$rw;?>">
                                              <td class="delete_new_line" colspan="1" onClick="removeRow('removCL<?=$rw;?>');">
                                                <a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                                              </td> 
                                              <td colspan="3">
                                                <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" <?php if(!empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                                              </td>   
                                            </tr>
                                    
                                  <?php $rw++; }
                                  
                                }else{  ?>
                                
                                        <tr class="removCL0">
                                            <td>
                                          <input type="text"  name="product_name[]" class="form-control productItm checkvl" onkeyup="getproductinfo();" id="proName01" data-cntid="01"  placeholder="Items name(required)" value=""><span id="items_error"></span></td>
                                  
                                            <td ><input type="text"  onkeyup="calculate_pro_price()" name="quantity[]" id="qty01" class="form-control  checkvl numeric"  placeholder="qty" value=""><span id="quantity_error"></span></td>
                                  
                                            <td><input type="text" class="form-control  start checkvl parseFloat" onkeyup="calculate_pro_price()" name="unit_price[]"  id="price01"  placeholder="rate" value=""><span id="unit_price_error"></span></td>   
                                  
                                            <td><input type="text" class="form-control " name="total[]" id="total01"  class="" readonly value=""></td>
                                  
                                        </tr>

                                        <tr class="pro_descrption removCL0 addCL0"  style="display:none;" >
                                            <td colspan="11">
                                              <input type="text" class="form-control " name="pro_description[]" id="description01"  value=""  placeholder="Description">
                                            </td>
                                        </tr>

                                        <tr class="removCL0">
                                            <td class="delete_new_line" colspan="2" onClick="removeRow('removCL0');">
                                              <a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                                            </td> 
                                            <td colspan="8">
                                              <a href="javascript:void(0);" class="add_desc deschd0" onClick="addDesc('addCL0','deschd0')" ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                                            </td>   
                                        </tr>
                                
                                <?php } ?>

                    <?php } ?>

				  
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="row">
          <div  class="add_line"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Line</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="price-breakup">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"></div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="price-breakup-right">
              
            <div class="row">
        			<input type="hidden" name="initial_total" id="initial_total">
        			<input type="hidden" name="total_discount" id="total_discount" value="<?php if(isset($record['discount'])){ echo $record['discount']; }else{ echo "0"; }  ?>" >
        	    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <p class="sub_amount">Amount :</p>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                    <p class="sub_amount" id="show_subAmount">₹0.00</p>
                </div>
            </div>  
              
            <div class="row">
			 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="total-price">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 inrRp">
                      <h6>Discount (INR)</h6>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 inrIcn">
                        <h5>₹</h5>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                      <input id="lead_discount" name="discount" class="form-control" onkeyup="calculate_pro_price()"  type="text" value="<?php if(isset($record['discount'])){ echo $record['discount']; }else{ echo "0"; }  ?>" >
                    </div>
                  </div>
                </div>
                <hr>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="total-price">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 inrRp">
                      <h4>Total (INR)</h4>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 inrIcn">
                        <h4>₹</h4>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                      <input id="final_total" name="sub_total" class="form-control" type="text" readonly>
                    </div>
                  </div>
                </div>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="price_in_words text-right">
                  <h6><b>Total (in words)</b></h6>
                  <h6 id="digittowords">Zero Ruppes Only</h6>
                </div>                
              </div>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </div>
  </div>
 
  <div class="contact_details">
    <div class="container">
      <p>Your contact details :</p>
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <p>For any enquiry, reach out via email at</p>
          <input type="email" name="enquiry_email" value="<?=$this->session->userdata('company_email');?>">
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <p>Or you can call on</p><label style="display: inline; border: 0; border-bottom: 1px solid #ccc;  background-color: transparent; ">+91-</label>
          <input type="text" style="width:90%;" name="enquiry_mobile" value="<?=$this->session->userdata('company_mobile');?>">
        </div>
      </div>
    <div class="row mt-5" id="errorMsgbox" style="display:none;">
	  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
		<div class="error-popup-msg-for-user">
			<p><i class="fas fa-exclamation-circle"></i>
				Please fill the following details:
			</p>
			<ol id="ErrorMsg">
			</ol>
		</div>
	  </div>
	  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12"></div>
	</div>
      <div class="row mt-5">
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
         
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="save-btn text-left">
            <button type="button" id="btnSave" onClick="save()"><?php if(isset($action['data']) && $action['data']=='update'){  echo "Update & Continue"; }else{ echo "Save & Continue"; } ?></button>
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
<?php include('task-call-modal.php');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?> 


<?php if(isset($_GET['org']) && $_GET['org']!=""){ ?> 
<script>
setOrgData("<?=$_GET['org'];?>");
</script>
<?php } ?> 
<script>



function save(){
	if(checkValidationWithClass('opp_form')==1){
	    toastr.info('Please wait..'); 
		$('#btnSave').text('Saving & Redirecting..');
		$('#btnSave').attr('disabled',true);
		var url;
		var save_method=$("#save_method").val();
		if(save_method == 'add') {
			  url = "<?= base_url('opportunities/create')?>";
		}else{
			  url = "<?= base_url('opportunities/update')?>";
		}
		//var dataString = $("#opp_form").serialize();
		var dataString = $("#opp_form, #meetingForm, #taskForm, #callForm").serialize();
		$.ajax({
			url : url,
			type: "POST",
			data: dataString,
			dataType: "JSON",
			success: function(data)
			{   
			  if(data.status) 
			  {
				toastr.success('Opportunity has been added successfully.'); 
				window.location.href = '<?=base_url()?>opportunities/';
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
				
				checkValidationWithClass('opp_form');
				
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

<script>
calculate_pro_price();
	i=1;	
	 rowid=450;
	$(".add_line").click(function()
    {
	  i++;
	  rowid++;
     var markup = '<tr class="removCL'+i+'" ><td><input type="text"  name="product_name[]" class="form-control productItm checkvl" data-cntid="'+rowid+'" onkeyup="getproductinfo();" id="proName'+rowid+'" placeholder="Items name(required)"><span id="items_error"></span></td>'+
     '<td ><input type="text" onkeyup="calculate_pro_price()" id="qty'+rowid+'" class="form-control checkvl" name="quantity[]" placeholder="qty"><span id="quantity_error"></span></td>'+
      '<td><input type="text" name="unit_price[]" id="price'+rowid+'" class="form-control   start checkvl parseFloat" onkeyup="calculate_pro_price()" placeholder="rate"><span id="unit_price_error"></td>'+ 
	  '<td><input type="text" name="total[]" id="total'+rowid+'"  class="form-control  " readonly></td>'+
		' </tr>'+
		'<tr class="pro_descrption removCL'+i+' addCL'+i+'"><td colspan="4">'+
           '<input type="text" class="form-control  " name="pro_description[]" id="description'+rowid+'" placeholder="Description"></td></tr>'+
          '<tr class="removCL'+i+'"><td class="delete_new_line" colspan="1" onClick="removeRow(`removCL'+i+'`);" >'+
                '<a href="javascript:void(0);"><i class="far fa-trash-alt delIcn"></i> Delete Row</a></td>'+ 
               '<td colspan="3"><a href="javascript:void(0);" class="add_desc deschd'+i+'" onClick="addDesc(`addCL'+i+'`,`deschd'+i+'`);"><i class="far fa-plus-square addIcn"></i> Add Description</a></td></tr>';
      $("#add_new_line").append(markup);
	});
	
   function removeRow(removCL){
       $("."+removCL).remove();
       calculate_pro_price();
   }
   
   function addDesc(addCL,deschd){
       $("."+addCL).show();
       $("."+deschd).hide();
       
   }
   

function calculate_pro_price()
{
	  var Amount=0;
	$("input[name='quantity[]']").each(function (index) {
		    var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
			price = price.replace(/,/g, "");
			var pricetwo=numberToIndPrice(price);
			$("input[name='unit_price[]']").eq(index).val(pricetwo);
            var output = parseInt(quantity) * parseFloat(price);
			if (!isNaN(output))
            {
				Amount=parseFloat(Amount)+parseFloat(output);
                $("input[name='total[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
				
			}
	});
	
	var lead_discount = $("#lead_discount").val();
	lead_discount = lead_discount.replace(/,/g, "");
	if(lead_discount>0 && lead_discount!=""){
		
		var GrandAmount=parseFloat(Amount)-parseFloat(lead_discount);
		$("#total_discount").val(lead_discount);
		var pricetwo=numberToIndPrice(lead_discount);
		$("#lead_discount").val(pricetwo);
	}else{
		var GrandAmount=parseFloat(Amount);
	}
	$("#show_subAmount").html('₹ '+Amount.toFixed(2));
	$('#initial_total').val(numberToIndPrice(Amount.toFixed(2)));
	$('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
	$('#digittowords').html(digit_to_words(GrandAmount));
}


</script>

<script>
$(document).ready(function(){
   $('.add_desc').click(function() {   
	    $(this).hide();
	});
});
</script>
<script>
$('#stage').on('change',function(){
  var probability = $(this).val();
  if(probability=="Qualifying")
  {
    $('#probability').val('10%');
  }
  else if(probability=="Needs Analysis")
  {
    $('#probability').val('35%');
  }
  else if(probability=="Proposal")
  {
    $('#probability').val('75%');
  }
  else if(probability=="Negotiation")
  {
    $('#probability').val('90%');
  }
  else if(probability=="Closed Won")
  {
    $('#probability').val('100%');
  }
  else if(probability=="Closed Lost")
  {
    $('#probability').val('0%');
  }
  else
  {
    $('#probability').val('');
  }
});
</script>

