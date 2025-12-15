<!--common header include -->
<?php $this->load->view('common_navbar');?>
 <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.signature.css">
   <link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.betterdropdown.css">
 <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!-- common header include -->
<style>
.kbw-signature { width: 400px; height: 200px;}
#signature canvas{
width: 100% !important;
height: auto;
}

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
      </style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;">Invoices</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."invoices "; ?>">Invoices</a>
            </li>
            <li class="breadcrumb-item active"><?php if($this->uri->segment(3)){ ?>Edit <?php }else{ ?>Add <?php } ?> Invoice</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
 <?php if($check_totalinvoice == 'not_full' || (!empty($this->uri->segment(3)))) { ?> 
  
  
  <form class="form-horizontal"  id="form_invoice" method="post" enctype = "multipart/form-data">
  <div class="form-proforma">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
          <div class="invoice-section">
		  
          <!--<input type="hidden" name="page_name" id="page_name" value="<?php if(isset($_GET['pg'])){ echo $_GET['pg']; }?>" >
		  <input type="hidden"  name="page_id"  id="page_id" value="<?php if(isset($_GET['qt'])){ echo $_GET['qt']; }?>">--->
		  
		  <input type="hidden"  name="invc_id"  id="invc_id" value="<?php if(!empty($this->uri->segment(3))){ echo $this->uri->segment(3); }?>">
		  
              <div class="form-group">
                <label for="">Invoice No<span style="color: #f76c6c;">*</span>:</label>
                <input type="text" class="form-control" name="invoice_no" placeholder="Invoice No (INV-00001)" id="invoice_no" value="<?php if(isset($record['invoice_no'])){ echo $record['invoice_no']; }  ?>" <?php if(isset($record['invoice_no'])){ echo "readonly";   }else{ echo 'onblur="check_invoiceNo()"'; } ?>>
				<span id="invoice_no_error"></span>
              </div>
              <div class="form-group">
                <label for="">Invoice Date<span style="color: #f76c6c;">*</span>:</label>
                <input type="date" class="form-control" name="invoice_date" placeholder="(MM/DD/YYYY)" id="datepicker" value="<?php if(isset($record['invoice_date'])){ echo $record['invoice_date']; }  ?>" >
				<span id="invoice_date_error"></span>
              </div>
              <div class="form-group">
                <label for="">Due Date:</label>
                <input type="date" class="form-control" name="invoice_dueDate" placeholder="(MM/DD/YYYY)"   id="datepicker-1" value="<?php if(isset($record['due_date']) && $record['due_date']!=""){ echo $record['due_date']; }  ?>" >
              </div>
			  <div class="form-group">
				<label>Terms</label>
				<div class="input-group-append">
				<select class="form-control" name="terms_select" id="terms_select">
				<?php
				//print_r($invoice_terms);die;
					foreach ($invoice_terms as $inv_terms) { ?>
                    <option value="<?php echo $inv_terms['inv_terms'];?>" <?php if(isset($record['inv_terms']) && $record['inv_terms']==$inv_terms['inv_terms']){ echo 'selected'; }else if($inv_terms['marks_default']== 1){ echo 'selected'; } ?>><?php echo $inv_terms['inv_terms'];?></option>
                <?php } ?>
				 
				  <option value="end_of_month" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='end_of_month'){ echo 'selected'; } ?>>Due end of the month</option>
				  <option value="end_next_month" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='end_next_month'){ echo 'selected'; } ?>>Due end of the next month</option>
				  <option value="due_receipt" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='due_receipt'){ echo 'selected'; } ?>>Due on receipt</option>
				  <option value="custom" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='custom'){ echo 'selected'; } ?>>Custom</option>
				  
				</select>
				<button class="btn btn-outline-secondary btn-sm input-group-text" type="button" title="Config terms" onclick="addpay()"><i class="fas fa-cog"></i></button>
				</div>
			  </div>
			  
              <span id="show_more_fields">
			  <?php if(isset($record['extraField_label']) && $record['extraField_label']!=""){  
			  $extraField_label=explode("<br>",$record['extraField_label']);
			  $extraField_value=explode("<br>",$record['extraField_value']);
			  $rwno=542;
			  for($cnt=0; $cnt<count($extraField_label); $cnt++){
			  ?>
				<div id="row<?=$rwno;?>"> 
					<div class="form-group">
					<label for=""><input type="text" name="label[]" value="<?=$extraField_label[$cnt]?>" placeholder="<?=$extraField_label[$cnt]?>:"></label>
					<div class="row p-0 m-0">
						<div class="col-md-12 p-0">
							<div class="input-group-append">
							<input type="text" class="form-control" name="label_value[]" placeholder="Enter Value." value="<?=$extraField_value[$cnt]?>">
							<a href="javascript:void(0);" class="remove_addmore" id="<?=$rwno;?>">X</a></div>
						</div>
					</div>
					</div>
				</div>
				
			  <?php $rwno++; } } ?>
			  </span>			  
			  <a href="javascript:void(0);" class="add_moreField"><i class="far fa-plus-square"></i> Add More Fields</a>
            
          </div>
        </div>
		
		<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
		</div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
          <div class="file-upload text-center" style="width:auto;">
		 
            <div class="image-upload-wrap" style="margin-top:0px;" id="putLogo" >
            <?php if(!empty($this->session->userdata('company_logo'))){ ?>    
			  <img class="file-upload-image" src="<?=base_url();?>uploads/company_logo/<?=$this->session->userdata('company_logo');?>" alt="your image" style="max-height: 200px;" />
             <?php }else{ ?>
                <div style="padding:20px;">
                    Logo not uploaded yet.
                </div>
             <?php } ?>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="billing-section">
    <div class="container">
      <div class="row">
	    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedto billedby">
		  <h3>Customer Name:-<span> (Vendor Details)<span style="color: #f76c6c;">*</span> </span></h3>
		  
              <div class="input-group-append form-group">				
				<select class="form-control" name="customer_name" id="vendor_name">
				<option>Select Customer</option>
				<?php
				//print_r($invoice_terms);die;
				    
					foreach ($customer_details as $cust_details) { ?>
                    <option value="<?php echo $cust_details['id'];?>" <?php if(isset($record['vendor_id']) && $record['vendor_id']==$cust_details['id']){ echo 'selected'; } ?>><?php echo $cust_details['org_name'];?></option>
                <?php } ?>
				 
				</select>
			   <button class="btn btn-outline-secondary btn-sm input-group-text" type="button" title="Add customer" onclick="add_form()"><i class="fa fa-plus"></i></button>
			  </div>
              <!--<div class="input-group-append form-group">
			  <input type="text" class="form-control" placeholder="Customer Name" name="customer_name" id="vendor_name" value="<?php if(isset($vendor_details)){ echo $vendor_details->name; }  ?>">
			  <button class="btn btn-outline-secondary btn-sm input-group-text" type="button" onclick="add_form()"><i class="fa fa-plus"></i></button>
              </div>-->

			  
			  <!--<div class="input-group-append">
				<input type="text" class="form-control ui-autocomplete-input" name="org_name" placeholder="Organization Name" id="org_name" autocomplete="off">
				<button class="btn btn-outline-secondary btn-sm" type="button" onclick="add_formOrg()"><i class="fa fa-plus"></i></button>
			  </div>-->
			  
			  <div class="business_detail" id="show_bdetails">
			   
			  </div>
            <div class="business_detail text-center" id="show_addBdetails">
			
              <div class="container"> 
			  <i class="far fa-user-circle"></i>
                <p>Select a Client/Business from list</p>
                <p>Or</p>
                <button type="button" onclick="add_form()"><i class="fa fa-plus"></i> Add New Client</button>
              </div>
            </div>
			<span id="billedto_error"></span>
          </div>
        </div>
	  
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedby billedto">
		  <h3>Ship To:-<span> (Your Details)<span style="color: #f76c6c;">*</span> </span></h3>
		  
              <div class="form-group">
			    <select class="form-control" name="shipto" id="billed_by">
				    <option value="">Select Branch</option>
				   <?php foreach($branch_details as $branch){ ?>
				    <option value="<?=$branch->id; ?>" <?php if(isset($record['billedby_branchid']) && $branch->id==$record['billedby_branchid'] ){ echo "selected"; }else if($branch->city == $city_name){ echo 'selected'; } ?> ><?=$branch->company_name.'('.$branch->branch_name.')'; ?></option>
				   <?php } ?>
                </select>
              </div>
            
            <div class="business_detail">
              <div class="container p-0">
                <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <h5>Business Detail</h5>
                  </div>
				  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-right" id="show_editlink">
				  </div> 
				 </div>
              </div>
              <p><b>Business Name:</b> <span id="bname"></span></p>
              <p><b>Address:</b> <span id="adress_by"></span>, <span id="city_by"></span>, <span id="state_by"></span>, <span id="country_by"></span> <span id="zipcode_by"></span></p>
			  <p><b>Email: </b><span id="email_by"></span></p>
			  <p><b>Phone:</b> <span id="phone_by"></span></p>
              <p><b>GSTIN: </b><span id="gstin_by"></span></p>
              <p><b>PAN:</b> <span id="pan_by"></span></p>
            </div>
			<span id="billedby_error"></span>
          </div>
        </div>
        
      </div>
      <!--<div class="row mt-3">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <p>
            <label><input type="checkbox" name="" id="showHide_div" <?php if(isset($record['client_bname']) && $record['client_bname']!==""){ echo "checked"; } ?> > Add Shipping Details</p></label>
        </div>
      </div>
      <div class="row show_shipping_details" <?php if(isset($record['client_bname']) && $record['client_bname']!==""){   }else{  ?>style="display: none;" <?php } ?>>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedby billedto">
            <h3>Shipped To</h3>
            <div class="business_detail text-center">
              <div class="container">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="name" name="client_bname" placeholder="Client's Business name" class="form-control onlyLetters" id="client_bname" value="<?php if(isset($record['client_bname']) && $record['client_bname']!==""){ echo $record['client_bname']; }else if(isset($record['org_name'])){ echo $record['org_name'];  } ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="name" name="client_address" placeholder="Address" class="form-control" id="client_address" value="<?php if(isset($record['client_address']) && $record['client_address']!==""){ echo $record['client_address'];  }else if(isset($record['shipping_address'])){ echo $record['shipping_address'];  }?>" >
                      </div>
                    </div>
                  </div>
				  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
					  <input type="name" name="client_country" placeholder="Country" class="form-control" id="client_country" value="<?php if(isset($record['client_country']) && $record['client_country']!==""){ echo $record['client_country'];  }else if(isset($record['shipping_country'])){ echo $record['shipping_country'];  }?>">
                        
                      </div>
                    </div>
					<div class="col-md-6">
                      <div class="form-group">
					  <input type="name" name="client_state" placeholder="State" class="form-control" id="client_state" value="<?php if(isset($record['client_state']) && $record['client_state']!==""){ echo $record['client_state'];  }else if(isset($record['shipping_state'])){ echo $record['shipping_state'];  }?>">
                      
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="name" name="client_city" placeholder="City" class="form-control" id="client_city" value="<?php if(isset($record['client_city']) && $record['client_city']!==""){ echo $record['client_city'];  }else if(isset($record['shipping_city'])){ echo $record['shipping_city'];  }?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <input type="name" name="client_zipcode" placeholder="Postal Code / Zip Code" class="form-control" id="client_zipcode" value="<?php if(isset($record['client_zipcode']) && $record['client_zipcode']!==""){ echo $record['client_zipcode'];  }else if(isset($record['shipping_zipcode'])){ echo $record['shipping_zipcode'];  }?>">
                      </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="name" name="client_gst" placeholder="Enter Your GSTIN Here (Optional)" id="client_gst" class="form-control" value="<?php if(isset($record['client_gst']) && $record['client_gst']!==""){ echo $record['client_gst'];  }?>" >
                      </div>
                    </div>
                  </div>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedto billedby">
            <h3>Transport Details</h3>
            <div class="business_detail text-center">
              <div class="container">
                
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="name" name="challan_number" placeholder="Challan Number" class="form-control" id="challan_number" value="<?php if(isset($record['challan_number'])){ echo $record['challan_number']; }?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="date" name="select_date" placeholder="(DD/MM/YYYY)" class="form-control datepicker-2" id="select_date" value="<?php if(isset($record['select_date'])){ echo $record['select_date']; }?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="name" name="transport" placeholder="Transport" class="form-control" id="transport" value="<?php if(isset($record['transport'])){ echo $record['transport']; }?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <textarea class="form-control" name="shipping_note" placeholder="Shipping Note" rows="3" id="shipping_note"><?php if(isset($record['shipping_note'])){ echo $record['shipping_note']; }?></textarea>
                      </div>
                    </div>
                  </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>-->
      
      <div class="proforma-table-main">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <ul class="list-inline">
              <li class="list-inline-item">
                <label> <input type="checkbox" name="tax" id="add_gst" > Add GST</li></label>
            </ul>
            <ul class="list-inline hide_gst_checkbox">
              <li class="list-inline-item">
                <label><input type="radio" name="tax" id="igst_checked" checked> IGST</li></label>
              <li class="list-inline-item">
                <label><input type="radio" name="tax" id="csgst_checked"> CGST & SGST</li></label>
            </ul>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="proforma-table">
              <table class="table table-responsive-lg" width="100%" id="add_new_line" >
			  <?php 
			  
			   
			  ?>
                <thead>
                  <tr>
                    <th>Items</th>
                    <th>HSN/SAC</th>
                    <th class="gst">GST(%)</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Amount</th>					                   
                    <th class="igst">IGST</th>				
                    <th class="cgst">CGST</th>
                    <th class="sgst">SGST</th>							
                    <th class="sub_total">Total</th>
                  </tr>
                </thead>
				
               <?php 
				$rw=45;
				if(isset($record['product_name'])){
					$proName=explode("<br>",$record['product_name']); 
					$hsn_sac=explode("<br>",$record['hsn_sac']); 
					//$sku=explode("<br>",$record['sku']); 
					$quantity=explode("<br>",$record['quantity']); 
					$unit_price=explode("<br>",$record['unit_price']); 
					$total=explode("<br>",$record['total']); 
					$gst=explode("<br>",$record['gst']); 
					
					$sgst=array();
					$cgst=array();
					$igst=array();
					$proDescription=array();
					
					if(isset($record['igst'])){ 
						$igst=explode("<br>",$record['igst']); 
					}
					if(isset($record['sgst'])){
						$sgst=explode("<br>",$record['sgst']); 
					}
					if(isset($record['cgst'])){ 
						$cgst=explode("<br>",$record['cgst']); 
					}
					
					if(isset($record['pro_description'])){ 
						$proDescription=explode("<br>",$record['pro_description']); 
					} 
				
				for($pr=0; $pr<count($proName); $pr++){ 
				//print_r($proDescription[$pr]);
				?>
                  <tr class="removCL<?=$rw;?>">
                    <td>
					<input type="text" name="items[]"  class="productItm" onKeyup="getproductinfo();" id="itemspro" placeholder="Items name(required)" value="<?=$proName[$pr];?>"><span id="items_error"></span></td>
					
                    <td><input type="text" name="hash[]" id="itemsprohsn" placeholder="HSN/SAC" value="<?=$hsn_sac[$pr];?>"></td>
					
                    <td class="gst">
					<input type="text" name="gst[]"  id="itemsprogst" onkeyup="calculate_invoice()" placeholder="GST in %" value="<?=$gst[$pr];?>"></td>
					
                    <td ><input type="text"  onkeyup="calculate_invoice()" name="quantity[]" id="qty"  value="1"  placeholder="qty" value="<?=$quantity[$pr];?>"><span id="quantity_error"></span></td>
					
                    <td><input type="text" class="start" onkeyup="calculate_invoice()" name="unit_price[]"  id="itemsproprice" placeholder="rate" value="<?=$unit_price[$pr];?>"><span id="unit_price_error"></span></td>   
					
                    <td><input type="text" name="total[]" class="" readonly value="<?=$total[$pr];?>"></td>
					
                    <td class="cgst"><input type="text" name="cgst[]" value="<?php if(isset($cgst[$pr])){ echo $cgst[$pr]; } ?>" class="" readonly></td>
					
                    <td class="sgst"><input type="text" name="sgst[]" value="<?php if(isset($sgst[$pr])){ echo  $sgst[$pr]; } ?>" class="" readonly></td>
					
                    <td class="igst"><input type="text" name="igst[]" value="<?php if(isset($igst[$pr])){ echo  $igst[$pr]; }?>" class="" readonly></td>
					
					<td class="sub_total"><input type="text" name="sub_total[]" class="" readonly></td>
                  </tr>
                  <tr class="pro_descrptions removCL<?=$rw;?> addCL<?=$rw;?>" <?php if(empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> >
                    <td colspan="11">
                      <input type="text" name="product_desc[]"  id="itemsprodesc"value="<?php if(isset($proDescription[$pr])){ echo $proDescription[$pr]; }?>"  placeholder="Description">
                    </td>
                  </tr>
                  <tr class="removCL<?=$rw;?>">
                    <td class="delete_new_line" colspan="2">
                      <a href="javascript:void(0);" onClick="removeRow('removCL<?=$rw;?>');" ><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                    </td> 
                    <td colspan="8">
                      <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" <?php if(!empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                    </td>   
                  </tr>
				  
				<?php $rw++; } }else{  ?>
				
				<tr class="removCL0">
                    <td>
					<input type="text" name="items[]" class="productItm" onKeyup="getproductinfo();" id="itemspro" placeholder="Items name(required)" value=""><span id="items_error"></span></td>
					
                    <td><input type="text" name="hash[]" id="itemsprohsn" placeholder="HSN/SAC" value=""></td>
					
                    <td class="gst">
					<input type="text" name="gst[]" id="itemsprogst" onkeyup="calculate_invoice()" placeholder="GST in %" value=""></td>
					
                    <td ><input type="text"  onkeyup="calculate_invoice()" name="quantity[]" id="qty" value="1"  placeholder="qty" value=""><span id="quantity_error"></span></td>
					
                    <td><input type="text" class="start" onkeyup="calculate_invoice()" name="unit_price[]"  id="itemsproprice" placeholder="rate" value=""><span id="unit_price_error"></span></td>   
					
                    <td><input type="text" name="total[]" class="" readonly value=""></td>
					
                    <td class="cgst"><input type="text" name="cgst[]" id="cgstval" value="" class="" readonly></td>
					
                    <td class="sgst"><input type="text" name="sgst[]" id="sgstval" value="" class="" readonly></td>
					
                    <td class="igst"><input type="text" name="igst[]" id="igstval" value="" class="" readonly></td>
					
					<td class="sub_total"><input type="text" name="sub_total[]" class="" readonly></td>
                  </tr>
                  <tr class="pro_descrption removCL0 addCL0"  style="display:none;" >
                    <td colspan="11">
                      <input type="text" name="product_desc[]"  id="itemsprodesc" value=""  placeholder="Description">
                    </td>
                  </tr>
                  <tr class="removCL0">
                    <td class="delete_new_line" colspan="2">
                      <a href="javascript:void(0);" onClick="removeRow('removCL0');" ><i class="far fa-trash-alt delIcn"></i> Delete Row</a>
                    </td> 
                    <td colspan="8">
                      <a href="javascript:void(0);" class="add_desc deschd0" onClick="addDesc('addCL0','deschd0')" ><i class="far fa-plus-square addIcn"></i> Add Description</a>
                    </td>   
                  </tr>
				
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
        	  <input type="hidden" name="total_discount" id="total_discount">
        		<!---Discount Field--->	
        		 <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
        		    <p class="discount">Overall Discount:<br>
        		    ₹ <b id="cal_disc"></b>
        		    </p>
                 </div>
                 <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 text-right">
                     <p class="discount">
                      <select class="form-control" id="sel_disc" name="sel_disc" onChange="calculate_invoice()">
                		 <option value="disc_persent" <?php if(isset($record['discount_type']) && $record['discount_type']=="disc_persent" ){ echo "selected";  }?> >%</option>
                		 <option value="disc_rupee" <?php if(isset($record['discount_type']) && $record['discount_type']=="disc_rupee" ){ echo "selected";  }?> >₹</option>
              		  </select>
              		  </p>
                 </div>
                 <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                    <p class="discount">
                        <input type="text" id="discounts" name="discount" onkeyup="calculate_invoice()" value="<?php if(isset($record['discount']) && $record['discount']!=""){ echo $record['discount'];  }?>" class="form-control">
                    </p>
                 </div>
                 
                 <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
                    <p class="discount"><a href="javascript:void(0);" id="remove_discount"><i class="fas fa-times"></i></a></p>
                 </div>
        			
        			
        	    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                    <p class="sub_amount">Amount :</p>
                </div>
				
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                    <p class="sub_amount" id="show_subAmount">₹0.00</p>
                </div>
                
                
        	 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                <p class="sgst">SGST :</p>
                <p class="cgst">CGST :</p>
        		<p class="igst">IGST :</p>
             </div>	
             
             <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 text-right">
                <p class="sgst" id="show_sgst">₹0.00</p>
                <p class="cgst" id="show_cgst">₹0.00</p>
                <p class="igst" id="show_igst">₹0.00</p>
              </div>
        			
        			
        	<div class="row" id="putExtraVl">
			<?php 
			if(isset($record['extraCharge_name']) && $record['extraCharge_name']!=""){ 
			$extraChargeName=explode("<br>",$record['extraCharge_name']);
			$extraChargeValue=explode("<br>",$record['extraCharge_value']);
			$td=30;
			for($ex=0; $ex<count($extraChargeName); $ex++){
			?>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext<?=$td;?>" style="margin-bottom: 3%;">
				<input type="text" name="extra_charge[]" value="<?php echo $extraChargeName[$ex]; ?>" placeholder="Extra Charges" class="form-control" >
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl<?=$td;?>" style="margin-bottom: 3%;">
				<input type="text" onkeyup="calculate_invoice()" name="extra_chargevalue[]" id="floatvald<?=$td;?>"  value="<?php echo $extraChargeValue[$ex]; ?>" class="form-control inptvl">
				</div>
				<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows<?=$td;?>" style="margin-bottom: 3%;">
				<a href="javascript:void(0);" class="remove_additionalchg" id="<?=$td;?>">X</a>
				</div>
			<?php $td++; } } ?>				
              
            </div>  
             

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <p class="add_discount"><a href="javascript:void(0);"><i class="fas fa-tag"></i> Add Discount</a>
                </p>
                <p><a href="javascript:void(0);" class="add_additionalchg"><i class="far fa-plus-square"></i> Add Additional Charges</a>
                </p>
				<hr>
              </div>
            </div>  
              
            <div class="row">
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
                      <input id="final_total" name="final_total" class="form-control" type="text" readonly>
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
  <div class="form-footer-section py-5">
    <div class="container">
		<a href="javascript:void(0);" class="add_terms"><i class="far fa-plus-square addIcn"></i> Add Terms</a>
		<div id="show_terms" style="display:none;">
		  <p>Terms and Condition :</p>
		  <span id="terms_condition">
		  <?php if(isset($record['terms_condition'])){ 
			$terms_condition=explode("<br>",$record['terms_condition']);
			$p=1;
			$dm=14;
			for($tm=0; $tm<count($terms_condition); $tm++){
		  ?>
		  <div class="row" id="addterms<?=$dm;?>"> 
			<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">
			<p><?=$p;?></p>
			</div> 
			<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> 
				<input type="text" name="terms_condition[]" value="<?=$terms_condition[$tm];?>" placeholder="Write Your Conditions">
			</div>
			<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> 
			<a href="javascript:void(0);" class="remove_terms" id="<?=$dm;?>">X</a>
			</div> 
		  </div>
			<?php $p++; $dm++; } } ?>
		  </span>
		  <div class="row m-0" id="add_terms_condition"> <a href="javascript:void(0);"><i class="far fa-plus-square"></i> Add New Term & Condition</a>
		  </div>
		</div>
    </div>
  </div>

  <div class="notes">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <a href="javascript:void(0);" class="add_notes"><i class="fas fa-calendar-minus addIcn"></i> Add Notes</a>
          <div class="notes_left" <?php if(empty($record['notes'])){ echo "style='display:none;'"; } ?> >
            <textarea class="form-control" name="notes" rows="8" placeholder="Notes"><?php if(isset($record['notes'])){ echo $record['notes']; } ?></textarea>
            <button class="remove_notes" type="button">X</button>
          </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
		
		<a href="javascript:void(0);" class="add_attach"><i class="fa fa-paperclip"></i> Add Attachments</a>
	
		<div id="show_attach" <?php if(isset($record['attachment']) && $record['attachment']!=""){ echo "style='display:block;'"; }else{ echo "style='display:none;'"; } ?> >
		<a href="javascript:void(0);" class="remove_attach" style="float:right;">X</a>
		  <p>Attachment :</p>
		  <img id="preview_attachment"   alt="your image" src="<?php if(isset($record['attachment']) && $record['attachment']!=""){ echo base_url()."assets/pi_images/".$record['attachment']; }?>" style="height:150px;width:150px" /><br>	
		  <input type="file" name="attachment" onchange="readURL(this,'preview_attachment','rndm');">
		  <span id="attachment_error" style="color:red;"></span>
		</div>
		
		
		</div>
		
      </div>
    </div>
  </div>
  
  <?php if($admin_details['invoice_account_type'] == 'Paid' && ($admin_details['invoice_license_type'] == 'Standard' || $admin_details['invoice_license_type'] == 'Professional')){
   ?>
		          

  <div class="form-footer-section py-5">
    <div class="container">
        
      <a href="javascript:void(0);" class="add_signature" ><i class="fas fa-calendar-minus addIcn"></i>Add Sgnature</a>
		
		<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 show_signPad" <?php if(isset($record['signature_img']) && $record['signature_img']!=""){ echo "style='display:block;'"; }else{ echo "style='display:none;'"; } ?> >
		    <label class="" for="">E-Signature:</label>
		    <p>Sign in the below area using mouse or touch or upload your signature
		    <a href="javascript:void(0);" class="remove_signaturepad" style="float:right;">X</a></p>
		    <div id="signature" <?php if(isset($record['signature_img']) && $record['signature_img']!=""){ echo "style='display:none;'"; }?> ></div>
            <img id="preview_sign"  alt="your image" style="height:198px;width:398px" src="<?php if(isset($record['signature_img']) && $record['signature_img']!=""){ echo base_url()."assets/pi_images/".$record['signature_img']; }?>" />	
            
            <div class="row">
            <div class="">
		    <button id="clear" type="button" class="btn"><i class="fas fa-minus-circle delIcn"></i>Clear</button>
	     	</div>
			<div class="image-upload-wrap" style="margin-left: 6%; margin-top: 0px; height: 30px; padding: 5px;">
              <input class="file-upload-input" style="width: 100%;" id="upload_sign" type="file"  onchange="readURL(this,'preview_sign','signature');" name="upload_signature" accept="image/*"/>
              <div class="drag-text">
                <h6><i class="fas fa-upload"></i> Upload Signature</h6>
              </div>
            </div>
            </div>
		    <textarea id="sigpad" name="signature_image" class="form-control" rows="8" style="display:none"></textarea>
		
		    <span id="uploadsign_error" style="color:red;"></span>
         </div>  
        
        
	<!--<a href="javascript:void(0);" class="add_attach"><i class="fa fa-paperclip"></i> Add Attachments</a>
	
	<div id="show_attach" <?php if(isset($record['attachment']) && $record['attachment']!=""){ echo "style='display:block;'"; }else{ echo "style='display:none;'"; } ?> >
	<a href="javascript:void(0);" class="remove_attach" style="float:right;">X</a>
      <p>Attachment :</p>
	  <img id="preview_attachment"   alt="your image" src="<?php if(isset($record['attachment']) && $record['attachment']!=""){ echo base_url()."assets/pi_images/".$record['attachment']; }?>" style="height:150px;width:150px" /><br>	
      <input type="file" name="attachment" onchange="readURL(this,'preview_attachment','rndm');">
	  <span id="attachment_error" style="color:red;"></span>
    </div>-->
   </div>
  </div>
<?php  }else{ ?>
<div  style="display: none">
<input type="file" name="upload_signature" readonly>
<input type="hidden" name="signature_image" >
</div>
<?php } ?>
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
    <div class="row mt-5" id="errorMsgbox">
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
          <!--<div class="draft-btn text-right">
            <button>Save As Draft</button>
          </div>-->
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="save-btn text-left">
            <button type="button" id="invoiceSave">Save & Continue</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
   </form>
   
  <!-- /.content-header -->
</div>

<!-- modal(branch detail) -->

<div class="modal fade" id="branch_details">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Business Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="business_detail_form" action="" id="business_mod">
          <h5>Basic Information</h5>
          <div class="row">
		  <input type="hidden" name="branch_id">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Country :</label>
                <input type="text" name="country_br" class="form-control onlyLetters" placeholder="Enter Country Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Branch Name :*</label>
                <input type="text" name="branch_name" id="branch_name" class="form-control onlyLetters" placeholder="Enter Branch Name (Required)">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Business Name :</label>
                <input type="text" name="comp_name" id="comp_name" class="form-control onlyLetters" placeholder="Enter Business Alias">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Email :</label>
                <input type="email" name="branch_email" id="branch_email" class="form-control" placeholder="Enter Email">
                <label><input type="checkbox" name="show_email" value="1"> Show Email in Invoice</label>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Phone Number :</label>
                <input type="tel" name="branch_phone" id="branch_phone" class="form-control" value="+91-"  placeholder="Enter Business Alias">
              </div>
            </div>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Branch GSTIN :</label>
                <input type="text" name="branch_gstin" id="branch_gstin" class="form-control" placeholder="Enter Business GSTIN (Optional)">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Branch CIN :</label>
                <input type="text" name="branch_cin" id="branch_cin" class="form-control" placeholder="Enter Business CIN (Optional)">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Branch PAN Number :</label>
                <input type="text" name="branch_pan" id="branch_pan" class="form-control"  placeholder="Enter Business PAN Number (Optional)">
              </div>
            </div>
          </div>

          <h5>Communication Address</h5>
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Street Address :</label>
                <input type="text" name="address_br" id="address_br" class="form-control" placeholder="Enter Street Address">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">State :</label>
                <input type="text" name="state_br" id="state_br" class="form-control" placeholder="Enter State Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">City :</label>
                <input type="text" name="city_br" id="city_br" class="form-control" placeholder="Enter City Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Pin Code :</label>
                <input type="tel" name="zipcode_br" id="zipcode_br" class="form-control" value=""  placeholder="Enter Pincode">
              </div>
            </div>
          </div>

          <button class="btn btn-info" style="float:right;" type="button" id="branchSave" onclick="save_branch()">Update</button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- modal(branch detail) -->
<!-- modal(organization detaqils) -->

<div class="modal fade" id="organiazation_detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Business Details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form class="business_detail_form" action="" id="business_mod">
          <h5>Basic Information</h5>
          <div class="row">
		  <input type="hidden" name="branch_id">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Country :</label>
                <input type="text" name="country_br" class="form-control" placeholder="Enter Country Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Branch Name :*</label>
                <input type="text" name="branch_name" class="form-control" placeholder="Enter Branch Name (Required)">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Company Name :</label>
                <input type="text" name="" class="form-control" placeholder="Enter Business Alias">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Email :</label>
                <input type="email" name="" class="form-control" placeholder="Enter Email">
                <label><input type="checkbox" name=""> Show Email in Invoice</label>
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Phone Number :</label>
                <input type="tel" name="" class="form-control" value="+91-"  placeholder="Enter Business Alias">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Business GSTIN :</label>
                <input type="text" name="" class="form-control" placeholder="Enter Business GSTIN (Optional)">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Business PAN Number :</label>
                <input type="text" name="" class="form-control"  placeholder="Enter Business PAN Number (Optional)">
              </div>
            </div>
          </div>

          <h5>Communication Address</h5>
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Street Address :</label>
                <input type="text" name="" class="form-control" placeholder="Enter Street Address">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">State :</label>
                <input type="text" name="state_mo" class="form-control" placeholder="Enter State Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">City :</label>
                <input type="text" name="city_mo" class="form-control" placeholder="Enter City Name">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Pin Code :</label>
                <input type="tel" name="" class="form-control" value=""  placeholder="Enter Pincode">
              </div>
            </div>
          </div>

          <h5>Custom Information</h5>
          <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <table class="table table-responsive-lg" width="100%">
                <thead>
                  <tr>
                    <th>Label</th>
                    <th>Value</th>
                    <th>#</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody id="add_moreModal">
                 
                  <tr>
                    <td><a href="javascript:void(0);" class="addMore_field_modal"><i class="far fa-plus-square"></i> Add More Fields</a></td>
                  </tr>
                </tbody>
              </table>
              <label><input type="checkbox" name=""> Update current changes for all existing invoices of this business.</label>
            </div>
            <button class="btn">Save</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<!-- FORM DIV -->

        <!-- Add new modal -->
        <div class="modal fade show" id="customer_modal" role="dialog" aria-modal="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="organization_add_edit">Add Customer</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id">
                    <input type="hidden" value="" name="sess_eml">
                    <input type="hidden" value="" name="save_method" id="save_method">
                    <div class="form-body form-row">
					
                      <div class="col-md-6 mb-3">
                         <label>Customer Name</label>
                        <input type="text" class="form-control onlyLetters" name="org_name" id="org_name_check" placeholder="Customer Name" onChange="check_org()" required>
                        <span id="org_name_error"></span>
                      </div>
					  <div class="col-md-6 mb-3">
                          <label>Customer Type</label>    
                          <select class="form-control" name="cust_types" id="cust_type_select">
                            <option value="">Select Customer Type</option>
                            <option value="Customer">Customer</option>
							<option value="Vendor">Vendor</option>
							<option value="Both">Both</option>
                          </select>
						  <span id="customer_type_error"></span>
                        </div>
                      <div class="col-md-6 mb-3">
                        <label>Ownership</label>
                        <input type="text" class="form-control " name="ownership" placeholder="Ownership" value="<?= $this->session->userdata('name'); ?>" readonly>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Contact Person </label>
                        <input type="text" class="form-control onlyLetters" name="primary_contact" id="primary_contact_org" placeholder="Contact Person Name">
                        <span id="primary_contact_error"></span>
                      </div>
                      
                      <div class="col-md-6 mb-3">
                        <label>Email</label>  
                        <input type="email" class="form-control " name="email" id="emailId" placeholder="Email">
                        <span id="email_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Website</label> 
                        <input type="url" class="form-control " name="website" id="websiteId" placeholder="Website" required>
                        <span id="website_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Office Phone</label>  
                        <input type="tel" class="form-control numeric" maxlength="10"  name="office_phone" id="officePhone" placeholder="Office Phone" required="">
                        <span id="office_phone_error"></span>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label>Mobile</label>  
                        <input type="tel" class="form-control numeric" name="mobile" maxlength="10" id="mobileId" placeholder="Mobile" required="">
                        <span id="mobile_error"></span>
                      </div>
                      
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="1" id="forTarget1" style="width:100%;color:#ffffff">Other Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="2" id="forTarget2" style="width:100%;color:#ffffff">Address Details</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="3" style="width:100%;color:#ffffff">Contact Person</a>
                      </div>
                      <div class="col-md-3 mb-3">
                        <a class="btn btn-info btn-sm show_div" target="4" style="width:100%;color:#ffffff">Description</a>
                      </div>
                      <div class="col-md-3 mb-3">
                      </div>

                      <div id="div1" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-6 mb-3">
                          <label>Employees</label>
                          <input type="number" class="form-control " name="employees" id="employeesId" placeholder="Employees">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Industry</label>    
                          <select class="form-control " name="industry" id="industryId" required="">
                            <option value="">Industry</option>
                            <option value="Government">Government</option>
                            <option value="Other">Other</option>
                            <option value="Utilies">Utilies</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Telecommunications">Telecommunications</option>
                            <option value="Technology">Technology</option>
                            <option value="'Shipping">Shipping</option>
                            <option value="Retail">Retail</option>
                            <option value="Recreation">Recreation</option>
                            <option value="Not For Profit">Not For Profit</option>
                            <option value="Media">Media</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Machinery">Machinery</option>
                            <option value="Insurance">Insurance</option>
                            <option value="Hospitality">Hospitality</option>
                            <option value="Healthcare">Healthcare</option>
                            <option value="Apparel">Apparel</option>
                            <option value="Food and Baverage">Food and Baverage</option>
                            <option value="Finance">Finance</option>
                            <option value="Environmental">Environmental</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Energy">Energy</option>
                            <option value="Electronic">Electronic</option>
                            <option value="Education">Education</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Construction">Construction</option>
                            <option value="Communications">Communications</option>
                            <option value="Chemicals">Chemicals</option>
                            <option value="Biotechnology">Biotechnology</option>
                            <option value="Banking">Banking</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Assign To</label>
                          <input type="text" class="form-control onlyLetters" name="assigned_to" id="assigned_to" placeholder="Assigned To">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Annual Revenue</label>
                          <input type="number" class="form-control " name="annual_revenue" id="annualRevenue" placeholder="Annual Revenue">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Type</label>    
                          <select class="form-control " name="type" id="typeId">
                            <option value="">Type</option>
                            <option value="Lead">Lead</option>
                            <option value="Sales Qualified Lead">Sales Qualified Lead</option>
                            <option value="Customer">Customer</option>
                            <option value="Compatitor">Compatitor</option>
                            <option value="Partner">Partner</option>
                            <option value="Analyst">Analyst</option>
                            <option value="Vendor">Vendor</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Region</label>    
						  <select class="form-control " name="region" id="regionID" >
							<option value="">Region</option>
							<option value="NAM">NAM</option>
							<option value="LAM">LAM</option>
							<option value="EU">EU</option>
							<option value="APAC">APAC</option>
							<option value="MEA">MEA</option>
						  </select>
                        </div>
                        <!--<div class="col-md-6 mb-3">
                          <label>SIC Code</label>    
                          <input type="text" class="form-control " name="sic_code" id="sicCode" placeholder="SIC Code">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>SLA Name</label>    
                          <input type="text" class="form-control " name="sla_name" id="slaName" placeholder="SLA Name">
                        </div>-->
                        <div class="col-md-6 mb-3">
                          <label>GSTIN</label>    
                          <input type="text" class="form-control " name="gstin" id="gstinId" placeholder="GSTIN" maxlength="15">
                          <span id="gstin_error" style="color:red;font-size: 14px;"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Pan Number</label>    
                          <input type="text" class="form-control " name="panno" id="panno" placeholder="Pan Number" maxlength="10">
                          <span id="panno_error"></span>
                        </div>
                      </div>

                      <div id="div2" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-6 mb-3">
                          <h6>Billing Address</h6>
                        </div>
                        <div class="col-md-5 mb-2">
                          <h6>Shipping Address</h6>
                        </div>
                        <div class="col-md-1 mb-1">
                          <button type="button" class="btn btn-info btn-sm" onclick="copy(this.form)">Copy</button>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_country" placeholder="Country" id="country"  required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="country_ids" >
                          <span id="billing_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_state" placeholder="State" id="states" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="state_id" >
                           <span id="billing_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Country</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_country" placeholder="Country" id="s_country" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_country_id" >
                           <span id="shipping_country_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>State</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_state" placeholder="State" id="s_states" required="" autocomplete="off">
                          <input type="hidden" class="form-control " id="s_state_id" >
                          <span id="shipping_state_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="billing_city" placeholder="City" id="cities" required="" autocomplete="off">
                          <span id="billing_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode</label>
                          <input type="text" class="form-control numeric" maxlength="6" name="billing_zipcode" placeholder="Zipcode" required="" id="billingZipcode">
                           <span id="billing_zipcode_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>City</label>
                          <input type="text" class="form-control  ui-autocomplete-input" name="shipping_city" placeholder="City" id="s_cities" required="" autocomplete="off">
                           <span id="shipping_city_error"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                          <label>Zipcode</label>
                          <input type="text" class="form-control numeric" maxlength="6" name="shipping_zipcode" placeholder="Zipcode" required="" id="shippingZipcode">
                          <span id="shipping_zipcode_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address</label>
                          <textarea type="text" class="form-control " name="billing_address" placeholder="Address" required="" id="billingAddress"></textarea>
                          <span id="billing_address_error"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label>Address</label>
                          <textarea type="text" class="form-control " name="shipping_address" placeholder="Address" required="" id="shippingAddress"></textarea>
                          <span id="shipping_address_error"></span>
                        </div>
                      </div>

                      <div id="div3" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-12 mb-6">
                          <table style="margin-bottom:5px;" id="add">
                            <tbody>
                          <tr><td width="4%"><input id="checkbox" type="checkbox"></td><td width="24%"><input name="contact_name_batch[]" id="contact_name_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Contact Name"></td><td width="24%"><input name="email_batch[]" id="email_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Email"></td><td width="24%"><input name="phone_batch[]" id="phone_batch" class="form-control  start" data-toggle="tooltip" title="Tittle" type="text" placeholder="Work Phone"></td><td width="24%"><input name="mobile_batch[]" id="mobile_batch" class="form-control " data-toggle="tooltip" title="Tittle" type="text" placeholder="Mobile"></td></tr></tbody></table>
                        </div>
                        <div class="col-md-2">
                          <input type="button" class="add_row btn btn-outline-info btn-sm" value="Add Row" id="add_row">
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="delete_row btn btn-outline-danger btn-sm" id="delete_row">Delete Row</button>
                        </div>
                        <div class="col-md-8">
                        </div>
                      </div>

                      <div id="div4" class="targetDiv form-row col-md-12" style="display: none;">
                        <div class="col-md-12 mb-3">
                          <label>Description</label>
                          <textarea type="text" class="form-control" name="description" id="descriptionTxt"  placeholder="Description"></textarea>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <span id="error_msg" style="color: red;font-size: 14px;font-weight: 200px;"></span>
                  <button type="button" id="btnSave" onclick="save()" class="btn btn-info">Save</button>
                </div>
            </div>
          </div>
        </div>
<!-- Add new modal -->

       
      <!-- Add new modal -->	  
      <div class="modal fade show" id="vendor_form_old" role="dialog" aria-modal="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="vendor_title">Add Vendors</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body form">
                      <form action="javascript:void(0);" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id">
                        <input type="hidden" value="" name="sess_eml">
                        <div class="form-body form-row">
                          <div class="col-md-6 mb-3">
                            <label>Vendor Company Name</label>  
                            <input type="text" class="form-control onlyLetters" name="name" id="name" placeholder="Vendor Company Name" required="">
                            <span id="name_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Created By</label>
                            <input type="text" class="form-control " name="created_by" id="created_by" placeholder="Cretaed By" value="<?= $this->session->userdata('name')?>" readonly="">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" class="form-control " name="email" id="email" placeholder="Email" required="">
                            <span id="email_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Mobile</label>
                            <input type="text" class="form-control  numeric" name="mobile" id="mobile" maxlength="10" placeholder="Mobile" required="">
                            <span id="mobile_error"></span>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Official Phone</label>
                            <input type="text" class="form-control numeric" name="office_phone" id="office_phone" maxlength="12" placeholder="Official Phone">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label>Website</label>
                            <input type="text" class="form-control " name="website" id="website" placeholder="Website">
                          </div>
                         
                          <div class="col-md-3 mb-3">
                            <a class="btn btn-info btn-sm show_this" target="1" id="trgt1" style="width:100%;color:#ffffff">Other Details</a>
                          </div>
                          <div class="col-md-3 mb-3">
                            <a class="btn btn-info btn-sm show_this" target="2" id="trgt2" style="width:100%;color:#ffffff">Address Details</a>
                          </div>
                          <div class="col-md-3 mb-3">
                            <a class="btn btn-info btn-sm show_this" target="3" id="trgt3" style="width:100%;color:#ffffff">Contact Person</a>
                          </div>
                          <div class="col-md-3 mb-3">
                            <a class="btn btn-info btn-sm show_this" target="4" id="trgt4" style="width:100%;color:#ffffff">Description</a>
                          </div>
                          <div class="col-md-3 mb-3">
                          </div>
                          <div id="div1" class="targetDiv form-row col-md-12" style="display: none;">
                            <div class="col-md-6 mb-3">
                              <label>Assigned To</label>
                              <input type="text" class="form-control " name="asigned_to" id="asigned_to" placeholder="Assigned To">
                            </div>
                            <div class="col-md-6 mb-3">
                               <label>Pan Number</label>
                               <input type="text" class="form-control " name="pan_no" id="pan_no" placeholder="PAN Number">
                            </div>
                            <div class="col-md-6 mb-3">
                            <label>Carrier</label>
                            <select class="form-control " name="gst_rtype" id="gst_rtype" onchange="gst_active();return false;">
                              <option selected="" disabled="">Select Carrier</option>
                              <option value="GST unregistered">GST unregistered</option>
                              <option value="GST registered- Regular">GST registered- Regular</option>
                              <option value="GST registered- Composition">GST registered- Composition</option>
                              <option value="Overseas">Overseas</option>
                              <option value="SEZ">SEZ</option>
                            </select>
                            <span id="gst_rtype_error"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>GSTIN</label>
                              <input type="text" class="form-control " name="gstin" id="gstin" placeholder="GSTIN"  maxlength="15" readonly="readonly">
                              <span id="gstin_error" style="color:red;font-size: 14px;"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Terms</label>
                              <select class="form-control " name="terms" id="terms">
                                <option selected="" disabled="">Select Terms</option>
                                <option value="Due on receipt">Due on receipt</option>
                                <option value="Net 15">Net 15</option>
                                <option value="Net 30">Net 30</option>
                                <option value="Net 60">Net 60</option>
                              </select>
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Opening Balance</label>
                              <input type="text" class="form-control " name="opening_balance" id="opening_balance" placeholder="Opening Balance">
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>As Of Now</label>
                              <input class="form-control " type="text" name="as_of" id="as_of" placeholder="As Of Now" onfocus="(this.type='date')">
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Tax Registration No</label>
                              <input type="text" class="form-control " name="tax_registration_no" id="tax_registration_no" placeholder="Tax Registration No.">
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Effective Date</label>
                              <input type="text" class="form-control " name="effective_date" id="effective_date" placeholder="Effective Date" onfocus="(this.type='date')">
                            </div>
                          </div>
                          <div id="div2" class="targetDiv form-row col-md-12" style="display: none;">
                            <div class="col-md-6 mb-3">
                              <h6>Address</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Country</label>
                              <input type="text" class="form-control  ui-autocomplete-input" name="country" placeholder="Country" id="country" autocomplete="off">
                              <input type="hidden" class="form-control " id="country_ids" >
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>State</label>
                              <input type="text" class="form-control  ui-autocomplete-input" name="state" placeholder="State" id="state" autocomplete="off">
                              <input type="hidden" class="form-control " id="state_id" >
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>City</label>
                              <input type="text" class="form-control  ui-autocomplete-input" name="city" placeholder="City" id="city" autocomplete="off">
                            </div>
                            <div class="col-md-6 mb-3">
                              <label>Zipcode</label>
                              <input type="text" class="form-control " name="zipcode" placeholder="Zipcode" id="zipcode">
                            </div>
                            <div class="col-md-12 mb-6">
                              <label>Address</label>
                              <textarea type="text" class="form-control " name="address" id="address" placeholder="Address"></textarea>
                            </div>
                          </div>
                          <div id="div3" class="targetDiv form-row col-md-12" style="display: none;">
                            <div class="col-md-12 mb-6">
                              <table style="margin-bottom:5px;" id="add">
                                <tbody>
                                  <tr>
                                    <td width="4%">
                                      <input id="checkbox" type="checkbox">
                                    </td>
                                    <td width="24%">
                                      <input name="contact_name_batch[]" id="contact_name_batch" class="form-control " type="text" placeholder="Contact Name">
                                    </td>
                                    <td width="24%">
                                      <input name="email_batch[]" id="email_batch" class="form-control " type="text" placeholder="Email">
                                    </td>
                                    <td width="24%">
                                      <input name="phone_batch[]" id="phone_batch" class="form-control  start" type="text" placeholder="Work Phone">
                                    </td>
                                    <td width="24%">
                                      <input name="mobile_batch[]" id="mobile_batch" class="form-control " type="text" placeholder="Mobile">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <div class="col-md-2">
                              <input type="button" class="add_row btn btn-outline-info btn-sm" value="Add Row" id="add_row">
                            </div>
                            <div class="col-md-2">
                              <button type="button" class="delete_row btn btn-outline-danger btn-sm" id="delete_row">Delete Row</button>
                            </div>
                            <div class="col-md-8">
                            </div>
                          </div>
                          <div id="div4" class="targetDiv form-row col-md-12" style="display: none;">
                            <div class="col-md-12 mb-3">
                              <label>Description</label>
                              <textarea type="text" class="form-control" name="description" id="descriptionTxt" placeholder="Description"></textarea>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" id="btnSave" onclick="save()" class="btn btn-info btn-sm">Save</button>
                    </div>
                </div>
              </div>
            </div>
<!-- modal(vendors details) -->



<!-- payment config modal -->


<!-- The Modal -->
<div class="modal fade" id="paymnet">
  <div class="modal-dialog">
    <div class="modal-content">


      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><span id="addnew_line">Configure Payment Terms</span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <span id="show_msg"> </span>
      <!-- Modal body -->
	 
      <form method="post" id="inv_payment_terms" action="">
        <div class="modal-body">
        <div class="names">
          <div class="row">
            <div class="col-lg-4">
              <p>Term Name*</p>
            </div>
            <div class="col-lg-4">
              <p>Number of days*</p>
            </div>
            <div class="col-lg-4"></div>
          </div>
        </div>
           <?php
		   $ro=80;
			foreach ($invoice_terms as $inv_terms) {  ?>

        <div class="blanks" id="myTable<?=$ro;?>">
          <div class="row" >
		  
		    <input type="hidden" name="terms_id[]"  value="<?php echo $inv_terms['id'];?>" >
		    <input type="hidden" name="defaults_value[]" id="defaults_value"  value="<?php echo $inv_terms['marks_default'];?>" >
		  
            <div class="col-lg-4">
              <div class="blanks_inner form-group">
                <input type="text" name="terms_name[]" id="terms_name" value="<?php echo $inv_terms['inv_terms'];?>" class="form-control">
              </div>
            </div>
			
            <div class="col-lg-3">
              <div class="blanks_inner form-group">
                <input type="text" name="no_ofdays[]" id="no_ofdays" value="<?php echo $inv_terms['inv_value'];?>" class="form-control">
              </div>
            </div>
            <div class="col-lg-5">
              <div class="blanks_inner_text d-none">
                <div class="row">
				 
				<?php if($inv_terms['marks_default'] == 1){ ?> 
				  <div class="col-lg-10">				  
                    <a href="#" class="d-none">Mark as default</a>
                    <p>Default</p>
                  </div>
				<?php }else{ ?>  
				  <div class="col-lg-10">
                    <a href="#">Mark as default</a>
                  </div>
                <?php } ?>  
                  <div class="col-lg-2 text-right">
                    <a href="#"><i class="far fa-times-circle"onclick="removeRow_terms('myTable<?=$ro;?>',<?=$inv_terms['id'] ?>)"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
			<?php $ro++; } ?>
       <!-- <div class="blanks">
          <div class="row">
            <div class="col-lg-4">
              <div class="blanks_inner form-group">
                <input type="" name="" value="Net 30" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="blanks_inner form-group">
                <input type="" name="" value="30" class="form-control">
              </div>
            </div>
            <div class="col-lg-5">
              <div class="blanks_inner_text d-none">
                <div class="row">
                  <div class="col-lg-10">
                    <a href="#">Mark as default</a>
                  </div>
                  <div class="col-lg-2 text-right">
                    <a href="#"><i class="far fa-times-circle"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>    
        </div>
        <div class="blanks">
          <div class="row">
            <div class="col-lg-4">
              <div class="blanks_inner form-group">
                <input type="" name="" value="Net 45" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="blanks_inner form-group">
                <input type="" name="" value="45" class="form-control">
              </div>
            </div>
            <div class="col-lg-5">
              <div class="blanks_inner_text d-none">
                <div class="row">
                  <div class="col-lg-10">
                    <a href="#">Mark as default</a>
                  </div>
                  <div class="col-lg-2 text-right">
                    <a href="#"><i class="far fa-times-circle"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="blanks">
          <div class="row">
            <div class="col-lg-4">
              <div class="blanks_inner form-group">
                <input type="" name="" value="Net 60" class="form-control">
              </div>
            </div>
            <div class="col-lg-3">
              <div class="blanks_inner form-group">
                <input type="" name="" value="60" class="form-control">
              </div>
            </div>
            <div class="col-lg-5">
              <div class="blanks_inner_text d-none">
                <div class="row">
                  <div class="col-lg-10">
                    <a href="#">Mark as default</a>
                  </div>
                  <div class="col-lg-2 text-right">
                    <a href="#"><i class="far fa-times-circle"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>-->
        
        
		<div  id="add_new_row"></div>
          <div class="row blanks">
          <div class="col-lg-12 form-group">
			<a href="#">
			<span id="addBtn">Add New</span></a>
          </div>
        </div>
       
		
      </div>
      </form>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-info" onclick="payment_terms()">Save</button>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>

<!-- payment config modal -->
<?php }else{  ?>
 <div class="form-proforma">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
           You can generate only <?=$totalinvoices; ?> invoices in a month .To generate more invoices upgrade now <br><br>
          <a href="https://team365.io/invoice-price"><button class="btn btn-info">Upgrade Now!</button></a>
        </div>
      </div>
     </div>
  </div>
    

<?php } ?>
</div>






<div class="modal fade" id="modalOpenForProduct">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Add Product</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form class="business_detail_form" action="" id="productForm">
            <input type="hidden" id="pronameid" >
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Product :</label>
                <input type="text" name="proname" id="proname" class="form-control onlyLetters" placeholder="Enter Product Name">
              </div>
            </div>
            
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">SKU :</label>
                <input type="text" name="prosku" id="prosku" placeholder="Enter SKU Here" class="form-control">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">HSN Code :</label>
                <input type="text" name="prohsn" id="prohsn" placeholder="Enter HSN Code Here" class="form-control">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">ISBN Code :</label>
                <input type="text" name="proisbn" id="proisbn" placeholder="Enter isbn Code Here" class="form-control" >
              </div>
            </div>
			<div class="col-xl-6 col-lg-16 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">Unit Price/rate :</label>
                <input type="text" name="proprice" id="proprice" placeholder="Product Price" class="form-control numeric">
              </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
              <div class="form-group">
                <label for="">GST on product :</label>
                <select name="proGST" id="proGST" class="form-control ">
                    <option value="12">12% GST</option>
                    <option value="18">18% GST</option>
                    <option value="28">28% GST</option>
                    <option value="VAT">VAT</option>
                 </select>
              </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="form-group">
                <label for="">About Product :</label>
                <textarea name="prodesc" id="prodesc" placeholder="Write Description" class="form-control"></textarea>
              </div>
            </div>
          </div>
          <button class="btn btn-info" style="float:right;" type="button" id="productSave" onclick="addProduct()">Add Product</button>
        </form>
      </div>

    </div>
  </div>
</div>




<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/jquery.signature.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/cropzee.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/jquery.betterdropdown.js" type="text/javascript"></script>

<script>

		
/********only integer and float value ****/
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));	
/********only integer and float value ****/	
	</script>
<script>
    /*$('#datepicker').datepicker({
        uiLibrary: 'bootstrap'
    });
    $('#datepicker-1').datepicker({
        uiLibrary: 'bootstrap'
    });
	    $('.datepicker-2').datepicker({
        uiLibrary: 'bootstrap'
    });*/
</script>

<!------ preview image of signature------------->
<script>
  function readURL(input,preview_sign,signature='') {
	if (input.files && input.files[0]) {
        var reader = new FileReader();
            reader.onload = function (e) {
				$('#'+preview_sign).show();
				$('#'+signature).hide();
                $('#'+preview_sign).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
    }
  }
</script>
  

<script>
calculate_invoice();
	i=1;	
	$(".add_line").click(function()
    {
	  i++;
     var markup = '<tr class="removCL'+i+'" ><td><input type="text" name="items[]" id="itemspro'+i+'" class="productItm" onKeyup="getproductinfo();" placeholder="Items name(required)"><span id="items_error"></span></td>'+
      '<td><input type="text" name="hash[]" id="itemspro'+i+'hsn" placeholder="HSN/SAC"></td>'+
      '<td class="gst"><input type="text" name="gst[]" id="itemspro'+i+'gst" onkeyup="calculate_invoice()" value="0" placeholder="GST in %"></td>'+
      '<td ><input type="text" onkeyup="calculate_invoice()" id="qty" class="integer_validqty'+i+'" name="quantity[]" value="1" placeholder="qty"><span id="quantity_error"></span></td>'+
      '<td><input type="text" name="unit_price[]" id="itemspro'+i+'price"class="start float_validup'+i+'" onkeyup="calculate_invoice()" placeholder="rate"><span id="unit_price_error"></td>'+ 
	  '<td><input type="text" name="total[]" class="" readonly></td>'+
       '<td class="cgst"><input type="text" name="cgst[]" id="cgstval" class="" readonly></td>'+
      ' <td class="sgst"><input type="text" name="sgst[]" id="sgstval" class="" readonly></td>'+
       '<td class="igst"><input type="text" name="igst[]" id="igstval" class="" readonly></td>'+
		'<td class="sub_total"><input type="text" name="sub_total[]" class="" readonly></td> </tr>'+
		'<tr class="pro_descrption removCL'+i+' addCL'+i+'"><td colspan="10">'+
           '<input type="text" name="product_desc[]" id="itemspro'+i+'desc" placeholder="Description"></td></tr>'+
          '<tr class="removCL'+i+'"><td class="delete_new_line" colspan="2"  >'+
                '<a href="javascript:void(0);" onClick="removeRow(`removCL'+i+'`);" ><i class="far fa-trash-alt delIcn"></i> Delete Row</a></td>'+ 
               '<td colspan="8"><a href="javascript:void(0);" class="add_desc deschd'+i+'" onClick="addDesc(`addCL'+i+'`,`deschd'+i+'`);"><i class="far fa-plus-square addIcn"></i> Add Description</a></td></tr>';
      $("#add_new_line").append(markup);
	  
	  $('.igst').hide();
	  $('.gst').hide();
	  $('.sub_total').hide();
	  $('.cgst').hide();
	  $('.sgst').hide();
		if($('#add_gst').is(":checked"))
        {
			if($('#igst_checked').is(":checked"))
			{
				$('.sub_amount').show();
				$('.gst').show();
				$('.igst').show();
				$('.sub_total').show();
				$('.cgst').hide();
				$('.sgst').hide();
				calculate_invoice();
			}else if($('#csgst_checked').is(":checked"))
			{
				$('.sub_amount').show();
				$('.gst').show();
				$('.sub_total').show();
				$('.igst').hide();
				$('.cgst').show();
				$('.sgst').show();
				calculate_invoice();
			}
		}
	//only integer validation on quantity		
	$(".integer_validqty"+i+"").inputFilter(function(value) {
      return /^-?\d*$/.test(value); });
	//float validation on unit price
	$(".float_validup"+i+"").inputFilter(function(value) {
     return /^-?\d*[.,]?\d{0,2}$/.test(value); });  
      //$("#show_more_fields").append(markup);
    });
	
	
	 var i = 1;
    $(".add_moreField").click(function()
    {
		 i++;
      var markup = '<div id="row'+i+'"> <div class="form-group">'+
                '<label for=""><input type="text" name="label[]" placeholder="Enter label:"></label>'+
                '<div class="row p-0 m-0"><div class="col-md-12 p-0"><div class="input-group-append"><input type="text" class="form-control" name="label_value[]" placeholder="Enter Value." id="">'+
                '<a href="javascript:void(0);" class="remove_addmore" id="'+i+'">X</a></div></div></div>'+
                '</div></div>';
      $("#show_more_fields").append(markup);
    });
    // Find and remove selected table rows
	$("#show_more_fields").on('click','.remove_addmore',function(){
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
    });
   
   function removeRow(removCL){
       $("."+removCL).remove();
       calculate_invoice();
   }
   
   function addDesc(addCL,deschd){
       $("."+addCL).show();
       $("."+deschd).hide();
       
   }
   

</script>
<script>

	//show branch billed by on default selected data 
	var id = $('#billed_by').val();
	
		$.ajax({
            url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				$('#bname').html(data.company_name);
				$('#adress_by').html(data.address);
				$('#city_by').html(data.city);
				$('#state_by').html(data.state);
				$('#country_by').html(data.country);
				$('#zipcode_by').html(data.zipcode);
				$('#email_by').html(data.branch_email);
				$('#phone_by').html(data.contact_number);
				$('#gstin_by').html(data.gstin);
				$('#pan_by').html(data.pan);
				$('#show_editlink').html('<a href="javascript:void(0)" style="color: #0075ff;" onclick="update_billedby('+data.id+')"><i class="fas fa-pen"></i> Edit</a>');
			}
		});
	//show branch billed by on click
	 $('#billed_by').click(function() {
		var id = $('#billed_by').val();
		$.ajax({
            url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				$('#bname').html(data.company_name);
				$('#adress_by').html(data.address);
				$('#city_by').html(data.city);
				$('#state_by').html(data.state);
				$('#country_by').html(data.country);
				$('#zipcode_by').html(data.zipcode);
				$('#email_by').html(data.branch_email);
				$('#phone_by').html(data.contact_number);
				$('#gstin_by').html(data.gstin);
				$('#pan_no').html(data.pan);
				$('#show_editlink').html('<a href="javascript:void(0)" onclick="update_billedby('+data.id+')"><i class="fas fa-pen"></i> Edit</a>');
			}
		});
		
	 }); 
	 
	function update_billedby(id)
    {
       
        $('#business_mod')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty();
		$('#branch_details').modal('show'); // show bootstrap modal when complete loaded
		//Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				  $('[name="branch_id"]').val(data.id);
				  $('[name="branch_name"]').val(data.branch_name);
				  $('[name="comp_name"]').val(data.company_name);
				  $('[name="branch_email"]').val(data.branch_email);
				   if(data.show_email == 1){
					  $('[name="show_email"]').prop('checked', true);  
				    }else{
					  $('[name="show_email"]').prop('checked', false); 	
					}
				  
				  $('[name="branch_phone"]').val(data.contact_number);
				  $('[name="branch_gstin"]').val(data.gstin);
				  $('[name="branch_cin"]').val(data.cin);
				  $('[name="branch_pan"]').val(data.pan);
				  $('[name="country_br"]').val(data.country);
				  $('[name="state_br"]').val(data.state);
				  $('[name="city_br"]').val(data.city);
				  $('[name="zipcode_br"]').val(data.zipcode);
				  $('[name="address_br"]').val(data.address);				
				  $('.modal-title').text('Update Branch Details'); // Set title to Bootstrap modal title
				
			}
		});
	}
	/********check validation update of branch**/
	function checkValidation_branch(){
		
	  var branch_name=$('[name="branch_name"]').val();
	  var comp_name=$('[name="comp_name"]').val();
	  var branch_email=$('[name="branch_email"]').val();
	  var branch_phone=$('[name="branch_phone"]').val();
	  var country_br=$('[name="country_br"]').val();
	  var state_br=$('[name="state_br"]').val();
	  var city_br=$('[name="city_br"]').val();
	  var address_br=$('[name="address_br"]').val();
	  var branch_gstin=$('[name="branch_gstin"]').val();
	  var branch_cin=$('[name="branch_cin"]').val();
	  var branch_pan=$('[name="branch_pan"]').val();
	  var zipcode_br=$('[name="zipcode_br"]').val();
	  
        if(country_br=="" || country_br===undefined ){
		  changeClr('country_br');		
		  return false;
	    }else if(branch_name=="" || branch_name===undefined ){
		  changeClr('branch_name');		
		  return false;
		}else if(comp_name=="" || comp_name===undefined ){
		  changeClr('comp_name');		
		  return false;
		}else if(branch_email=="" || branch_email===undefined){			 
		  changeClr('branch_email');		  	  
		  return false;
		}else if(branch_phone=="" || branch_phone===undefined || branch_phone===null){
		  changeClr('branch_phone');		  
		  return false;
		}else if(branch_gstin=="" || branch_gstin===undefined){
		  changeClr('branch_gstin');		 
		  return false;
		}else if(branch_cin=="" || branch_cin===undefined){
		  changeClr('branch_cin');		 
		  return false;
		}else if(branch_pan=="" || branch_pan===undefined){
		  changeClr('branch_pan');		 
		  return false;
		}else if(address_br=="" || address_br===undefined){
		  changeClr('address_br');		 
		  return false;
		}else if(state_br=="" || state_br===undefined){
		  changeClr('state_br');		 
		  return false;
		}else if(city_br=="" || city_br===undefined){
		  changeClr('city_br');		 
		  return false;
		}else if(zipcode_br=="" || zipcode_br===undefined){
		  changeClr('zipcode_br');		 
		  return false;
		}else{			
				return true;
		
		} 
	}
	/*$('.form-control').keypress(function(){
	  $(this).css('border-color','')
	});*/
	//save update branch
	function save_branch()
    {
    $('#branchSave').text('updating...'); //change button text
    $('#branchSave').attr('disabled',true); //set button disable
    if(checkValidation_branch()==true){
    // ajax adding data to database
    $.ajax({
        url : "<?= site_url('invoices/update_branch')?>",
        type: "POST",
        data: $('#business_mod').serialize(),
        dataType: "JSON",
        success: function(data)
        {
          if(data.status) //if success close modal and reload ajax table
          {
              $('#branch_details').modal('hide');
              //reload data start
			  var id = $('#billed_by').val();
	
					$.ajax({
						url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
						type: "GET",
						dataType: "JSON",
						success: function(data)
						{
							$('#bname').html(data.company_name);
							$('#adress_by').html(data.address);
							$('#city_by').html(data.city);
							$('#state_by').html(data.state);
							$('#country_by').html(data.country);
							$('#zipcode_by').html(data.zipcode);
							$('#gstin_by').html(data.gstin);
							$('#pan_no').html(data.pan);
							$('#show_editlink').html('<a href="javascript:void(0)" onclick="update_billedby('+data.id+')"><i class="fas fa-pen"></i> Edit</a>');
						}
					});
					//reload data end
          }
          $('#branchSave').text('Update'); //change button text
          $('#branchSave').attr('disabled',false); //set button enable
        }
    });
	}else{
            $('#branchSave').text('Update'); 
            $('#branchSave').attr('disabled',false);
        }
    }
	  
    $('#showHide_div').click(function() {
		
        $('#client_bname').val(function() {
        return this.defaultValue;
        }); 
		
		$('#client_address').val(function() {
        return this.defaultValue;
        }); 
		$('#client_city').val(function() {
        return this.defaultValue;
        }); 
		$('#client_zipcode').val(function() {
        return this.defaultValue;
        }); 
		$('#sel_state').val(function() {
        return this.defaultValue;
        }); 
		$('#client_gst').val(function() {
        return this.defaultValue;
        }); 
		$('#challan_number').val(function() {
        return this.defaultValue;
        }); 
		$('#select_date').val(function() {
        return this.defaultValue;
        }); 
		$('#transport').val(function() {
        return this.defaultValue;
        }); 
		$('#shipping_note').val(function() {
        return this.defaultValue;
        }); 
      $('.show_shipping_details').toggle("slide");
    });

</script>
<script>
$(document).ready(function(){
    $('#add_gst').click(function() {
	
		if($('#add_gst').is(":checked"))
        {
			
			$('.hide_gst_checkbox').toggle("show");
		    $('.gst').show();
		    $('.igst').show();
		    $('.cgst').hide();
		    $('.sgst').hide();
		    $('.sub_amount').show()
            $('.sub_total').show();
		     calculate_invoice();
		}else{
		  $('.hide_gst_checkbox').toggle("hide");
		  $('.gst').hide();
		  $('.igst').hide();
		  $('.cgst').hide();
		  $('.sgst').hide();
		  $('.sub_amount').hide();
		  $('.sub_total').hide();
          calculate_invoice();		  
		}
		
    });
	
	
	
	/******by default show and hide start**********/
	$('.hide_gst_checkbox').toggle("hide");
	$('.sub_amount').hide();
	$('.igst').hide();
	$('.gst').hide();
	$('.sub_total').hide();
	$('.cgst').hide();
	$('.sgst').hide();
	//$('.pro_descrption').hide();
	$('.add_discount').show();
	$('.discount').hide();
	//$('.notes_left').hide();
	$('.add_signature').show();
	//$('.show_signPad').hide();
    //$('.add_terms').show();
	//$('#show_attach').hide();
    $('.add_attach').show();
	$('#show_bdetails').hide();
	$('#show_addBdetails').show();
    $('#errorMsgbox').hide();
	
	<?php if(isset($record['gst'])){ ?> $('#add_gst').click(); <?php } ?>
	/******by default show and hide end**********/
	
	
   $('#igst_checked').click(function() {	
	if($('#igst_checked').is(":checked"))
    {
		
		$('.sub_amount').show();
		$('.gst').show();
		$('.igst').show();
		$('.sub_total').show();
		$('.cgst').hide();
		$('.sgst').hide();
		$('#cgstval').val('');
		$('#sgstval').val('');
		calculate_invoice();
	}
   });
  
   $('#csgst_checked').click(function() {
	if($('#csgst_checked').is(":checked"))
	{
		$('.sub_amount').show();
		$('.gst').show();
		$('.sub_total').show();
		$('.igst').hide();
		$('.cgst').show();
		$('.sgst').show();
		$('#igstval').val('');
		calculate_invoice();
	}
   });
   
   <?php if(isset($record['igst'])){  $igst=explode("<br>",$record['igst']); if($igst[0]!=""){ ?>
	
	$('#igst_checked').prop('checked', true); $('#igst_checked').click(); 
	<?php }else{ ?> 
	
	$('#csgst_checked').prop('checked', true);  $('#csgst_checked').click(); 
	<?php } } ?>
	
   
  /*<?php if(isset($record['cgst']) && $record['cgst']!=""){ ?>
  $('#csgst_checked').click();
  <?php } ?>*/  
   
   //add product description 
   $('.add_desc').click(function() {   
	    $(this).hide();
	});
	
	
	
	//add discount
	$('.add_discount').click(function() {   
	    $('.add_discount').hide();
		$('.discount').show();
	});
	$('#remove_discount').click(function() {   
	    $('.add_discount').show();
		$('.discount').hide();
		$('#discounts').val("");
		$('#cal_disc').html("");
		calculate_invoice();
	});
	<?php if(isset($record['total_discount']) && $record['total_discount']!=""){ ?>
		$('.add_discount').click(); 
	<?php } ?>
	
	
	//add notes
	$('.add_notes').click(function() {   
	    $('.add_notes').hide();
		$('.notes_left').show();
	});
	$('.remove_notes').click(function() {   
	    $('.add_notes').show();
		$('.notes_left').hide();
		$('[name="notes"]').val(function() {
        return this.defaultValue;
        });
	});
	
	//add attachment
	$('.add_attach').click(function() {   
	    $('#show_attach').show();
		$('#preview_attachment').show();
        $('.add_attach').hide();		
	});
	$('.remove_attach').click(function() {   
	    $('.add_attach').show();
		$('#show_attach').hide();
		$('#preview_attachment').attr('src', '');
		$('#preview_attachment').hide();
		$('[name="attachment"]').val(function() {
        return this.defaultValue;
        });
	});
	
	//add more extra charge and value 
	var i = 1;
	$('.add_additionalchg').click(function() {  
	    i++;
	    var markup = '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext'+i+'" style="margin-bottom: 3%;"> <input type="text" name="extra_charge[]" value="" placeholder="Extra Charges" class="form-control" ></div>'+
		'<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl'+i+'" style="margin-bottom: 3%;"><input type="text" onkeyup="calculate_invoice()" name="extra_chargevalue[]" id="floatvald'+i+'"  value="" class="form-control inptvl"></div>'+
             '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows'+i+'" style="margin-bottom: 3%;"><a href="javascript:void(0);" class="remove_additionalchg" id="'+i+'"><i class="fas fa-times"></i></a></div>';

	  $("#putExtraVl").append(markup);
	  $("#floatvald"+i+"").inputFilter(function(value) {
       return /^-?\d*[.,]?\d{0,2}$/.test(value); });
	  
	});
	
	$(document).on('click','.remove_additionalchg',function(){
        var button_id = $(this).attr("id");
        $("#ext"+button_id+", #extVl"+button_id+", #rows"+button_id).remove();
		$("#floatvald"+button_id).val("");
		calculate_invoice()
    });
});
</script>
<script>
$(document).ready(function()
{
	 var i = 0;
    $("#add_terms_condition").click(function()
    {
		 i++;
        var markup = '<div class="row" id="addterms'+i+'"> <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1 text-right">'+
          '<p>'+i+'.</p></div> <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10"> <input type="text" name="terms_condition[]" placeholder="Write Your Conditions">'+
        '</div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> <a href="javascript:void(0);" class="remove_terms" id="'+i+'">X</a></div> </div>';
		
		$("#terms_condition").append(markup);
		countPtg();
	});
		
    // Find and remove selected table rows
	$("#terms_condition").on('click','.remove_terms',function(){
        var button_id = $(this).attr("id");
        $("#addterms"+button_id+"").remove();
        countPtg();

    });
    
    function countPtg(){
        var arr = $('#terms_condition p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
    }
    
    
	
});
</script>
<script>

	
	$('.add_terms').click(function() {   
	    $('#show_terms').show();
        $('.add_terms').hide();		
	});
	<?php if(isset($record['terms_condition'])){ ?>
		$('#show_terms').show();
        $('.add_terms').hide();	
	<?php } ?>
	 var i = 0;
    //add more business label and value
	$(".addMore_field_modal").click(function()
    {
		 i++;
		  var markup = ' <tr id="addmod'+i+'"> <td><input type="text" name="" placeholder="Enter Label" class="form-control"></td>'+
            '<td><input type="text" name="" placeholder="Enter Value" class="form-control"></td>'+
            '<td><a href="#">Hide <i class="fas fa-eye"></i></a></td>'+
            '<td><a href="javascript:void(0);"  class="remove_more" id="'+i+'">Delete <i class="fas fa-trash-alt delIcn"></i></a></td</tr>';
       
		$("#add_moreModal").append(markup);
	});
		
    // Find and remove selected table rows
	$("#add_moreModal").on('click','.remove_more',function(){
        var button_id = $(this).attr("id");
        $("#addmod"+button_id+"").remove();

    });
	
	//add extra fields
	$(".add_ex_fields").click(function()
    {
		 i++;
		  var markup = '<div id="addexmod'+i+'" ><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5"> <input type="text" name="extra_label[]" class="form-control"></div>&nbsp;<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5"> <input type="text" name="extra_label[]" placeholder="Value" class="form-control"></div><div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1"> <a href="javascript:void(0);" class="remove_exmore" id="'+i+'">X</a></div></div>';
		$("#show_ex_fields").append(markup);
		});
		
    // Find and remove selected table rows
	$("#show_ex_fields").on('click','.remove_exmore',function(){
        var button_id = $(this).attr("id");
        $("#addexmod"+button_id+"").remove();
    });  
</script>
<script type="text/javascript">
	//signature add
	var signature = $('#signature').signature({syncField: '#sigpad', syncFormat: 'PNG'});
	//alert(signature);
	$('#clear').click(function(e) {
	e.preventDefault();
	signature.signature('clear');
	$("#sigpad").val('');
	});
    //add signature div and hide
	$('.add_signature').click(function() {   
	    $('.add_signature').hide();
		$('.show_signPad').show();
		 $('#preview_sign').hide();
	});
	$('.remove_signaturepad').click(function() {   
	    $('.add_signature').show();
		$('.show_signPad').hide();
		signature.signature('clear');
        $("#sigpad").val('');
		$("#preview_sign").attr('src','');
		$('#signature').show();
	});
	

</script>
<script>


var urlInvce='';
var invcId=$('#invc_id').val();
if(invcId=="" && invcId!==undefined){
	urlInvce="<?= base_url('invoices/add_invoiceDetails')?>";
}else{
	urlInvce="<?= base_url('invoices/update_invoiceDetails')?>";
}

    $('#invoiceSave').click(function(e) {
        e.preventDefault();
		$('#invoiceSave').text('saving...'); //change button text
        $('#invoiceSave').attr('disabled',true); //set button disable
		$("#businesslogo_error").show();
		$("#uploadsign_error").show();
		$("#attachment_error").show();	
		//console.log($('#form_invoice').serialize());
		var data = new FormData($("#form_invoice")[0]);
		if(checkValidation_invoice()==true){
        $.ajax({
            url : urlInvce,
            type: "POST",
            data: data,
            dataType: "JSON",
			processData: false,
            contentType: false,
            success: function(data)
            { 
			// console.log(data);
			$('#invoiceSave').text('Save & Continue'); 
                $('#invoiceSave').attr('disabled',false);
				console.log(data); 
              if(data.status) //if success close modal and reload ajax table
              {
                //alert("Insert sucessfuly"); 
				$('#invoiceSave').text('Save & Continue'); 
                $('#invoiceSave').attr('disabled',false);
				if(invcId=="" && invcId!==undefined){
					$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Invoice information has been added.');
				}else{
					$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Invoice information has been updated.');
				}
				
				$("#alert_popup").modal('show');
				setTimeout(function(){ $("#alert_popup").modal('hide'); window.location.href = '<?= base_url("invoices")?>';  },2000);
				
				//window.location.reload();
              }
			  
			  if(data.st=='error_fileupload') 
              {
				$("#businesslogo_error").html(data.error_business_logo);
				$("#uploadsign_error").html(data.error_uploadsignature);
				$("#attachment_error").html(data.error_attachment);
				$('#invoiceSave').text('Save & Continue'); 
                $('#invoiceSave').attr('disabled',false);
				setTimeout(function(){
		            $("#businesslogo_error").fadeOut('fast');
					$("#uploadsign_error").fadeOut('fast');
					$("#attachment_error").fadeOut('fast');		
					
			    },4000);
			  }
			  if(data.st==202)
			  {
				$("#invoice_no_error").html(data.invoice_no);
				$("#invoice_date_error").html(data.invoice_date);
				$("#items_error").html(data.items);
				$("#quantity_error").html(data.quantity);
				$("#unit_price_error").html(data.unit_price);
				$("#billedby_error").html(data.billedby);
				$("#billedto_error").html(data.billedto);
				$('#invoiceSave').text('Save & Continue'); 
                $('#invoiceSave').attr('disabled',false);
			  }
			  else if(data.st==200)
			  {
				$("#invoice_no_error").html('');
				$("#invoice_date_error").html('');
				$("#items_error").html('');
				$("#quantity_error").html('');
				$("#unit_price_error").html('');
				$("#billedby_error").html('');
				$("#billedto_error").html('');
				
			  }
			}
		});
		}else{
            $('#invoiceSave').text('Save & Continue'); 
            $('#invoiceSave').attr('disabled',false);
        }
	});
	
	
	/**** check validation for adding invoice****/
	function changeClr(idinpt){
	  $('#'+idinpt).css('border-color','red');
	  $('#'+idinpt).focus();
	  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },5000);
	}
	function checkValidation_invoice(){
		
	  var invoice_no=$('#invoice_no').val();
	  var invoice_date=$('#datepicker').val();
	  //var product_items=$('#items').val();
	  //var qty=$('#qty').val();
	  //var unit_price=$('#unit_price').val();
	  
	  var vendor_name=$('#vendor_name').val();
	  var billed_by=$('#billed_by').val();

		if(invoice_no=="" || invoice_no===undefined ){
		  changeClr('invoice_no');
		  $('#invoice_no_error').html('<span style="color:red;">Invoice number is required</span>'); 
		  $('#ErrorMsg').append('<li>Invoice number is required</li>'); 
		  $('#errorMsgbox').show();
		  return false;
		}else if(invoice_date=="" || invoice_date===undefined){			 
		  changeClr('datepicker');
		  $('#invoice_date_error').html('<span style="color:red;">Invoice date is required</span>');
		  $('#ErrorMsg').append('<li>Invoice date is required</li>'); 
		  $('#errorMsgbox').show();		  
		  return false;
		}else if(billed_by=="" || billed_by===undefined || billed_by===null){
		  changeClr('billed_by');
		  $('#billedby_error').html('<span style="color:red;">ShipTo is required</span>');
		  $('#ErrorMsg').append('<li>ShipTo is required</li>'); 
		  $('#errorMsgbox').show();
		  return false;
		}else if(vendor_name=="" || vendor_name===undefined){
		  changeClr('vendor_name');
		  $('#billedto_error').html('<span style="color:red;">Customer name is required</span>');
		  $('#ErrorMsg').append('<li>Customer name is required</li>'); 
		  $('#errorMsgbox').show();
		  return false;
		}else{
			var num=0;
		$("input[name='items[]']").each(function (index) {
		    var product = $("input[name='items[]']").eq(index).val();
		    var quantity = $("input[name='quantity[]']").eq(index).val();
		    var unit_price = $("input[name='unit_price[]']").eq(index).val();
			
			if(product==""){
				$("input[name='items[]']").eq(index).css('border-color','red');
				$("input[name='items[]']").focus();
				//$('#items_error').html('<span style="color:red;">Items is required</span>');
				setTimeout(function(){$("input[name='items[]']").eq(index).css('border-color','');},5000)
				num=1;
			}
			if(quantity=="" || quantity==0){
				$("input[name='quantity[]']").eq(index).css('border-color','red');
				$("input[name='quantity[]']").focus();
				//$('#quantity_error').html('<span style="color:red;">Quantity is required</span>');
				setTimeout(function(){$("input[name='quantity[]']").eq(index).css('border-color','');},5000)
				num=1;
			}
			if(unit_price=="" || unit_price==0){
				$("input[name='unit_price[]']").eq(index).css('border-color','red');
				$("input[name='unit_price[]']").focus();
				//$('#unit_price_error').html('<span style="color:red;">Unit Price is required</span>');
				setTimeout(function(){$("input[name='unit_price[]']").eq(index).css('border-color','');},5000)
				num=1;
			}
		});	
			if(num==0){
				return true;
			}else{
				return false;
			}
		} 
	}
	
	$("#add_new_line input").keypress(function(){
		$(this).css('border-color','');
	});
	
	$('#invoice_no').keypress(function(){	 
	   $('#invoice_no_error').html('');
	   $('#ErrorMsg').html('');
	});
	$('#datepicker').change(function(){	 
	   $('#invoice_date_error').html('');
	   $('#ErrorMsg').html('');
	});
	$('#items').keypress(function(){	 
	   $('#items_error').html('');
	  
	});
	$('#qty').keypress(function(){	 
	   $('#quantity_error').html('');
	  
	});
	$('#unit_price').keypress(function(){	 
	   $('#unit_price_error').html('');
	  
	});
	$('#billed_by').change(function(){	 
	   $('#billedby_error').html('');
	   $('#ErrorMsg').html('');
	});
	$('#vendor_name').change(function(){	 
	   $('#billedto_error').html('');
	   $('#ErrorMsg').html('');
	   $('#errorMsgbox').hide();
	});

	$('.form-control').keypress(function(){
	  $(this).css('border-color','')
	});
	$('.form-control').change(function(){
	  $(this).css('border-color','')
	});

</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">
$(document).ready(function(){
  $('#vendor_namess').autocomplete({
    source: "<?= site_url('organizations/autocomplete_vendor');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);	  
      $('#vendor_name').each(function(){
        var vendor_name = $(this).val();
		//alert(vendor_name);
        get_vendor_details(vendor_name);
      });
    }
  });
});

//change vendor id
$('#vendor_name').change(function(){
	var vendor_id = $(this).val();
    get_vendor_details(vendor_id);
	
});

</script>

<script>
<?php if(isset($record['vendor_id'])){ ?> 
	var vendor_id = '<?php echo $record["vendor_id"]; ?> '; 
	get_vendor_details(vendor_id);
<?php } ?>

  function get_vendor_details(vendor_id){
 // AJAX request
        $.ajax({
          url:'<?=site_url("invoices/get_vendor_details")?>',
          method: 'post',
          data: {vendor_id: vendor_id},
          dataType: 'json',
          success: function(response){
             // var len = response.length;
            //if(len > 0)
            //{
			  $('#show_bdetails').show();
			  $('#show_addBdetails').hide();
			  var vnd_id = response.id; 
              var email = response.email;  
              var gstin = response.gstin; 
              var pan   = response.panno;    			  
              var mobile = response.mobile;                                         
              var shipping_country = response.shipping_country;
              var shipping_state = response.shipping_state;
              var shipping_city = response.shipping_city;
              var shipping_zipcode = response.shipping_zipcode;
              var shipping_address = response.shipping_address;
              var output = '<div class="container p-0"><div class="row"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"><h5>Business Detail</h5></div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-right" id="show_editlinkto"><a href="javascript:void(0)" style="color: #0075ff;" onclick="update_cust('+vnd_id+')"><i class="fas fa-pen"></i> Edit</a></div></div></div><p><b>Business Name:</b> <span id="bname_to">'+response.org_name+'</span></p><p> <b>Address:</b>';
                    if(shipping_address != ''){
					output +='<span id="adress_to">'+shipping_address+'</span>,';
                    }   if(shipping_city != ''){
					output +='<span id="city_to">'+shipping_city+'</span>,';
                    }   if(shipping_state != ''){
					output +='<span id="state_to">'+shipping_state+'</span> - ';
                    }   if(shipping_zipcode != ''){
					output +='<span id="zipcode_to">'+shipping_zipcode+'</span>,';
                    }   if(shipping_country != ''){
					output +='<span id="country_to">'+shipping_country+'</span>';
                    }
				output +='</p>';
               if(email != ''){
				output +='<p><b>Email: </b><span id="email_to">'+email+'</span></p>';
               }   if(mobile != ''){
				output +='<p><b>Phone:</b> <span id="phone_to">'+mobile+'</span></p>';
               }   if(gstin != ''){
				output +='<p><b>GSTIN: </b><span id="gstin_to">'+gstin+'</span></p>';
               }   if(pan != ''){
				output +='<p><b>PAN: </b><span id="pan_to">'+pan+'</span></p>';
               }
               $('#show_bdetails').html(output);
               
              /*$('#show_bdetails').append(output);
              $('#adress_to').html(shipping_address);
              $('#email_to').html(email);
              $('#phone_to').html(mobile);
			  $('#gstin_to').html(gstin);
			  $('#pan_to').html(pan);
              $('#city_to').html(shipping_city);
			  $('#zipcode_to').html(shipping_zipcode);
              $('#bname_to').html(response.org_name);
              $('#country_to').html(shipping_country);
              $('#state_to').html(shipping_state);
			  $('#show_editlinkto').html('<a href="javascript:void(0)" style="color: #0075ff;" onclick="update_cust('+vnd_id+')"><i class="fas fa-pen"></i> Edit</a>');*/
			//}
          }
        });

  }

	$("#billedto_select").change();
	function showBillto(org_name){
			
		var page_name=$("#page_name").val();
		var invc_id=$("#invc_id").val();
		if(invc_id!="" && page_name==""){
			page_name="<?php if(isset($record['page_name'])){ echo $record['page_name']; } ?>";
		}
		$.ajax({
          url:"<?=site_url('contacts/get_org_details')?>",
          method: 'post',
          data: {org_name: org_name,page_name:page_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
			  $('#show_bdetails').show();
			  $('#show_addBdetails').hide();
			  var org_id = response[0].id; 
              var email = response[0].email;              
              var mobile = response[0].mobile;                                         
              var shipping_country = response[0].shipping_country;
              var shipping_state = response[0].shipping_state;
              var shipping_city = response[0].shipping_city;
              var shipping_zipcode = response[0].shipping_zipcode;
              var shipping_address = response[0].shipping_address;
              $('#adress_to').html(shipping_address);
              $('#email_to').html(email);
              $('#phone_to').html(mobile);
              $('#city_to').html(shipping_city);
			  $('#zipcode_to').html(shipping_zipcode);
              $('#bname_to').html(org_name);
              $('#country_to').html(shipping_country);
              $('#state_to').html(shipping_state);
			  $('#show_editlinkto').html('<a href="javascript:void(0)" onclick="update_org('+org_id+')"><i class="fas fa-pen"></i> Edit</a>');
			}
			}
		});
		
	 } 
	
	    // add organization
        function add_form()
        {
          save_method = 'add';
          $("#save_method").val('add');
          $('#form')[0].reset(); // reset form on modals
          $('.form-group').removeClass('has-error'); // clear error class
          $('.help-block').empty(); // clear error string
          $('#customer_modal').modal('show'); // show bootstrap modal
          $('.modal-title').text('Add Customer'); // Set Title to Bootstrap modal title
		  CKEDITOR.instances['descriptionTxt'].setData('');
          $("#add").find("tr").remove();
          var markup = "<tr><td width='4%'><input id='checkbox' type='checkbox'></td>"+
          "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name'></td>"+
          "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
          "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
          "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td></tr>";
          $("#add").append(markup);
          $("#add_row").show();
          $("#delete_row").show();
		  $("#org_name_check").attr('readonly', false);
          // Reset Form Errors
          $("#org_name_error").html('');
         // $("#cust_types_error").html('');
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
    
	
	/****** VALIDATION FUNCTION FOR ORG*********/
function changeClr(idinpt){
  $('#'+idinpt).css('border-color','red');
  $('#'+idinpt).focus();
  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
}

function checkValidation(){
  var org_name_check = $('#org_name_check').val();
  var cust_types = $('#cust_type_select').val();
  var primary_contact = $('#primary_contact_org').val();
  var emailId = $('#emailId').val();
  var mobileId = $('#mobileId').val();

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
    }else if(cust_types=="" || cust_types===undefined || cust_types===null){
      changeClr('cust_type_select');
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

	
        // save organization
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
		  
		  for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
		  };
          // ajax adding data to database
          $.ajax({
              url : url,
              type: "POST",
              data: $('#form').serialize(),
              dataType: "JSON",
              success: function(data)
              {
				  console.log(data);
                if(data.status) //if success close modal and reload ajax table
                {
                    $('#customer_modal').modal('hide');
					//reload customer details
					get_vendor_details(data.cust_id);
                    // window.location.reload();
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

                if(data.st==202)
                {
                  $("#org_name_error").html(data.org_name);
                  $("#customer_type_error").html(data.cust_types);
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
                  $("#customer_type_error").html('');
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
    
     //update organization
      function update_cust(id)
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
        $("#cust_types_error").html('');
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
            $('[id="cust_type_select"]').val(data.customer_type);
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
            $('[name="panno"]').val(data.panno);
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
            //$('[name="description"]').val(data.description);
			CKEDITOR.instances['descriptionTxt'].setData(data.description);
            $('#customer_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Update Customer'); // Set title to Bootstrap modal title
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
              "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control ' type='text' placeholder='Contact Name' value='"+data[i].name+"' readonly></td>"+
              "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email' value='"+data[i].email+"' readonly></td>"+
              "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone' value='"+data[i].office_phone+"' readonly></td>"+
              "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile' value='"+data[i].mobile+"' readonly></td>";
              $("#add").append(markup);
            });
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error Retrieving Data From Database');
          }
        });
      }
    
      function delete_org(id)
      {
          if(confirm('Are you sure, You want to delete this data?'))
          {
              // ajax delete data to database
              $.ajax({
                  url : "<?= base_url('organizations/delete')?>/"+id,
                  type: "POST",
                  dataType: "JSON",
                  success: function(data)
                  {
                      //if success reload ajax table
                      $('#customer_modal').modal('hide');
                       window.location.reload();
                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                      alert('Error deleting data');
                  }
              });
          }
      }
   
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
    "<td width='24%'><input name='contact_name_batch[]' id='contact_name_batch' class='form-control onlyLetters' type='text' placeholder='Contact Name'></td>"+
    "<td width='24%'><input name='email_batch[]' id='email_batch' class='form-control ' type='text' placeholder='Email'></td>"+
    "<td width='24%'><input name='phone_batch[]' id='phone_batch' class='form-control  start' type='text' placeholder='Work Phone'></td>"+
    "<td width='24%'><input name='mobile_batch[]' id='mobile_batch' class='form-control ' type='text' placeholder='Mobile'></td>";
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
         $("#delete_confirmation").modal('show'); 
        }else{
           alert('Select atleast one records');
        }
     });
});


$("#confirmed").click(function(){
  deleteBulkItem('organizations/delete_bulk'); 
});


</script>

<script>
function refreshPage(){
    window.location.reload();
} 
</script>
<!-- AUTOCOMPLETE QUERY -->
<script type="text/javascript">

$('#gstinId').change(function(){
    
    $('#gstin_error').text(''); 
    $('#country').val('');
    $('#states').val('');
    $('#state_id').val('');
    $('#panno').val('');
    var gstin =  $('#gstinId').val();
 if(gstin.length == 15){
    var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

    if (gstinformat.test(gstin)) {
     //return true; 
    var tin = gstin.substring(0, 2);
    var panno =gstin.substring(2, 12);
    //alert(tin);
        $.ajax({ 
                url: "<?= site_url('login/fetchstatebytin');?>",
                data: {tin: tin},
                dataType: "json",
                type: "POST",
                success: function(data){
                    //console.log(data.country);
                    $('#country').val(data.country);
                    $('#states').val(data.state);
                    $('#state_id').val(data.state_id);
                }    
        });
    
    //console.log(tin);
    //console.log(panno);
    $('#panno').val(panno);
    }else{
    $('#gstin_error').text('GST Identification Number is not valid. It should be in this "11AAAAA1111Z1A1" format');
     setTimeout(function(){ $('#gstin_error').text(''); },4000);
 }
 }else{
    $('#gstin_error').text('Enter max 15 digit'); 
    setTimeout(function(){ $('#gstin_error').text(''); },3000);
 }
});

$('#gstinId').keypress(function(){
   $('#gstin_error').text('');
});
$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $('#country').val(ui.item.label);
      $('#country_ids').val(ui.item.values);
      return false;
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#states').autocomplete({
        source: function(request, response) {
           var country_id =$('#country_ids').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $('#states').val(ui.item.label);
      $('#state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#cities').autocomplete({
      source: function(request, response) {
           var state_id =$('#state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= site_url('login/autocomplete_cities');?>",
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
      $('#s_country_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_states').autocomplete({
      source: function(request, response) {
           var country_id =$('#s_country_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_states');?>",
                data: { terms: request.term, country_id: country_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= site_url('login/autocomplete_states');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
      $('#s_state_id').val(ui.item.values);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $('#s_cities').autocomplete({
      source: function(request, response) {
           var state_id =$('#s_state_id').val();
             $.ajax({ 
                url: "<?= site_url('login/autocomplete_cities');?>",
                data: { terms: request.term, state_id: state_id},
                dataType: "json",
                type: "POST",
                success: function(data){
                    response(data);
                }    
              });
            },
    //source: "<?= site_url('login/autocomplete_cities');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
    }
  });
});
</script>
<script>
var editor = CKEDITOR.replace( 'descriptionTxt' );
CKEDITOR.config.height='100px';
</script>


<script>

function copy(form)
{
  form.shipping_country.value=form.billing_country.value;
  form.shipping_state.value=form.billing_state.value;
  form.shipping_city.value=form.billing_city.value;
  form.shipping_zipcode.value=form.billing_zipcode.value;
  form.shipping_address.value=form.billing_address.value;
}
//check duplicate organization
function check_org()
{
  var org_name = $('#org_name_check').val();
  if(org_name != ''){
    $.ajax({
     url: "<?= site_url(); ?>organizations/check_org",
     method: "POST",
     data: {org_name:org_name},
     success: function(data){
      $('#org_name_error').html(data);
     }
    });
  }
}
<?php if(isset($_GET['pg'])){ ?>
putInvoiceId();
<?php } ?>
function putInvoiceId()
{
	var page="<?php if(isset($_GET['pg'])){ echo $_GET['pg']; }else{ echo ''; } ?>";
	var itemid="<?php if(isset($_GET['qt'])){ echo $_GET['qt']; }else{ echo ''; } ?>";
	$.ajax({
     url: "<?= site_url(); ?>invoices/put_id_for_pi",
     method: "POST",
     data: {page:page,itemid:itemid},
     success: function(data){
		 $('#invoice_no').val(data);
      check_invoiceNo();
     }
    });
}

//check duplicate invoice no
function check_invoiceNo()
{
  var invoice_no = $('#invoice_no').val();
  //alert(invoice_no);
  if(invoice_no != ''){
    $.ajax({
     url: "<?= site_url(); ?>invoices/check_invoiceduplicate",
     method: "POST",
     data: {invoice_no:invoice_no},
     success: function(data){
		 //alert(data);
      $('#invoice_no_error').html(data);
     }
    });
  }
}

/********only integer and float value ****/

$("#unit_price").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });
$("#discounts").inputFilter(function(value) {
  return /^-?\d*[.,]?\d{0,2}$/.test(value); });

  
/********only integer****/ 
$("#qty").inputFilter(function(value) {
  return /^-?\d*$/.test(value); }); 
</script>

<script>
 $("#terms_select").click(function(){  });
    function addpay(){
      $('#paymnet').modal("show");
	setTimeout(function(){ $('#terms_select').click(); },100);  
    }
</script>
<script>
$(function(){
  //$('#terms_select').searchableSelect();
  //$('#vendor_name').searchableSelect();
  $("#terms_select").select2();
  $("#vendor_name").select2();
});
</script>

<script>
  var r=0;
  $("#addBtn").click(function(){
	//alert('addBtn');
	var appendData='';
	r++;
	appendData+='<div class="blanks"><div class="row" id="myTable'+r+'"><input type="hidden" name="terms_id[]"  value="0" ><input type="hidden" name="defaults_value[]" id="defaults_value"  value="0" ><div class="col-lg-4"><div class="blanks_inner form-group"><input type="text" name="terms_name[]" id="terms_name" placeholder="Net 0" class="form-control"> <span id="terms_name_error"></span></div></div>';

	appendData+='<div class="col-lg-3"><div class="blanks_inner form-group"><input type="text" name="no_ofdays[]" placeholder="" id="no_ofdays" class="form-control" value=""><span id="terms_value_error"></span> </div></div>';

	
    appendData+='<div class="col-lg-5"><div class="blanks_inner_text d-none"><div class="row"><div class="col-lg-10"><a href="#">Mark as default</a></div> <div class="col-lg-2 text-right"><a href="#"><i class="far fa-times-circle"onclick="removeRow_terms(`myTable'+r+'`,`not_delete`)"></i></a> </div> </div></div></div></div>';
	
    $("#add_new_row").append(appendData); 
	//$("myTable").append(appendData);

});

function removeRow_terms(id, terms_id){
	$("#"+id).remove();
	if(terms_id != 'not_delete'){
		if(confirm('are you sure you want to delete this row?')) {
		$.ajax({ 
            url: "<?= site_url('invoices/payment_terms_delete');?>",
            data: {terms_id:terms_id},
            dataType: "json",
            type: "POST",
            success: function(data)
		    {
			    console.log(data);
			}
        });	
	  }else{
		return false;  
	  }		
	}
} 
 function payment_terms()
 {
	 //var terms_name =$('#terms_name').val();
	 //var no_ofdays =$('#no_ofdays').val();
	    var num=0;
		$("input[name='terms_name[]']").each(function (index) {
		    var terms_name = $("input[name='terms_name[]']").eq(index).val();
		    var no_ofdays = $("input[name='no_ofdays[]']").eq(index).val();
		    
			if(terms_name==""){
				$("input[name='terms_name[]']").eq(index).css('border-color','red');
				$("input[name='terms_name[]']").focus();
				//$('#items_error').html('<span style="color:red;">Items is required</span>');
				setTimeout(function(){$("input[name='terms_name[]']").eq(index).css('border-color','');},4000)
				num=1;
			}
			if(no_ofdays=="" || no_ofdays==0){
				$("input[name='no_ofdays[]']").eq(index).css('border-color','red');
				$("input[name='no_ofdays[]']").focus();
				//$('#quantity_error').html('<span style="color:red;">Quantity is required</span>');
				setTimeout(function(){$("input[name='no_ofdays[]']").eq(index).css('border-color','');},4000)
				num=1;
			}
			
		});	
			if(num==1){
				return false;
			}else{
				
	 
             $.ajax({ 
                url: "<?= site_url('invoices/get_payment_terms');?>",
                data: $('#inv_payment_terms').serialize(),
                dataType: "json",
                type: "POST",
                success: function(data)
				{
					console.log(data);
					
                    if(data.st==200)
                    {
					    
					    $("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Invoice terms has been configured.');
				        $("#paymnet").modal('hide'); 
				        $("#alert_popup").modal('show');
				        setTimeout(function(){ $("#alert_popup").modal('hide'); location.reload(); },2000);
                         //alert('Add Payment Terms Successfully ');
                    }
				    else{
					  $("#show_msg").html('<text style="color:red;">Something went Wrong! </text>');
					  setTimeout(function(){$("#show_msg").html(''); },2000);
					  //alert('Something went Wrong');
                    }
					
				    if(data.st==202) 
					{
					  $("#terms_name_error").html(data.terms_name);
					  $("#terms_value_error").html(data.terms_value);
					 
					}
					else if(data.st==200)
					{
					  $("#terms_name_error").html('');
					  $("#terms_value_error").html('');
					  
					}	
					
               }    
          });
		}		  
      }
      
 function getproductinfo()
  { 

  $('.productItm').autocomplete({
    source: "<?= base_url('product_manager/autocomplete_product');?>",
    select: function (event, ui) {
     if(ui.item.data==2){
         var proid=$(this).attr('id');
         $("#"+proid).val('');
         openMOdal(proid,ui.item.name);
     }else{
         $(this).val(ui.item.label);
      $('.productItm').each(function (index) {
        var pro_name = $(this).val();
		$("input[name='unit_price[]']").eq(index).val('');
        $.ajax({
          url:"<?= base_url('product_manager/get_pro_details'); ?>",
          method: 'post',
          data:{product_name:pro_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
				var quantity = $("input[name='quantity[]']").eq(index).val();
				var price = $("input[name='unit_price[]']").eq(index).val();
				if(quantity=="" || quantity==0){
					$("input[name='quantity[]']").eq(index).val(1);
				}else{
					$("input[name='quantity[]']").eq(index).val(quantity);
				}
				if(price=="" || price==0){
					var product_unit_price = response[0].product_unit_price;
					price = product_unit_price.replace(/,/g, "");
					var pricetwo=numberToIndPrice(price);
							$("input[name='unit_price[]']").eq(index).val(pricetwo);
				}
			 calculate_invoice();
            }
            
          }
        });
        
      });
     }
    }
  });
  
  }
  
  function openMOdal(proid,name){
      $('#proname').val(name);
       $('#pronameid').val(proid);
      setTimeout(function(){
          $("#"+proid).val(name);
      },200);
      $("#modalOpenForProduct").modal('show');
  }
  
  function checkValidationPRo(){
      
      var proname		=$('#proname').val();
      var proprice		=$('#proprice').val();
      var prodesc		=$('#prodesc').val();

    if(proname=="" || proname===undefined){
      changeClr('proname');
      return false;
    }else if(proprice=="" || proprice===undefined){
      changeClr('proprice');
      return false;
    }else if(prodesc=="" || prodesc===undefined){
      changeClr('prodesc');
      return false;
    }else if(proGST=="" || proGST===undefined){
      changeClr('proGST');
      return false;
    }else{
      return true;
    } 
}
 
 function addProduct()
 { 
	if(checkValidationPRo()==true){	
		$('#productSave').text('saving...'); //change button text
		$('#productSave').attr('disabled',true); //set button disable
		var url;
		url = "<?= base_url('product_manager/createFromInvoice')?>";
		$.ajax({
			url : url,
			type: "POST",
			data: $('#productForm').serialize(),
			dataType: "JSON",
			success: function(data){
			if(data.status){
			    var ids         =$('#pronameid').val();
			    var proname		= $('#proname').val();
                var proprice	= $('#proprice').val();
                var prohsn		= $('#prohsn').val();
                var proGST		= $('#proGST').val();
                var desc		= $('#prodesc').val();
			    $('#'+ids).val(proname);
			    $('#'+ids+'hsn').val(prohsn);
			    $('#'+ids+'gst').val(proGST);
			    $('#'+ids+'price').val(proprice);
			    $('#'+ids+'desc').val(desc);
			    calculate_invoice();
                $("#modalOpenForProduct").modal('hide');
                $('#productForm')[0].reset();
			}
			$('#productSave').text('Add Product'); //change button text
			$('#productSave').attr('disabled',false); //set button enable
			if(data.st==202){
				alert('Error adding / update data');
				$('#productSave').text('save'); 
				$('#productSave').attr('disabled',false);
			}
		   },error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Error adding / update data');
				$('#productSave').text('save'); //change button text
				$('#productSave').attr('disabled',false); //set button enable
			}
		});
	}
 }
 
 
$('.form-control').keypress(function(){
  $(this).css('border-color','')
});
$('.form-control').change(function(){
  $(this).css('border-color','')
}); 
  
</script>