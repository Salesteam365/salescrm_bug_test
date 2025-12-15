<!--common header include -->
<?php $this->load->view('common_navbar');?>
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6 offset-sm-1">
          <h1 class="m-0 text-dark text-right" style="-webkit-text-fill-color: unset;"><?php if(isset($action['data']) && $action['data']=='update'){ echo "Update"; }else{ echo "Generate"; } ?> Payment Receipt</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-5">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">
                <a href="<?php echo base_url()." home "; ?>">Home</a> </li>
             <li class="breadcrumb-item">
                 <a href="<?php echo base_url()."invoices "; ?>">Invoices</a>
            </li>
            <li class="breadcrumb-item active"><?php if(isset($action['data']) && $action['data']=='update'){ echo "Update"; }else{ echo "Add"; } ?> Invoice</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
 
  <div class="linkscontainer">
  <form class="form-horizontal"  id="form_invoice" method="post" enctype = "multipart/form-data">
  <div class="form-proforma">
    <div class="container">
	  <div class="invoice-section">
	   <div class="row">
			<input type="hidden"  name="invc_id"  id="invc_id" value="<?php if(!empty($this->uri->segment(3))){ echo $this->uri->segment(3); }?>">
			<input type="hidden" name="save_method" id="save_method" value="<?php if(isset($action['data']) && $action['data']=='update'){ echo 'Update'; }else{ echo "add";  }  ?>" >
		  <input type="hidden"  name="id"  id="id" value="<?php if(isset($record['id']) &&  $action['from']=='salesorder'){ echo $record['id']; }  ?>">
		   <input type="hidden" class="form-control" name="saleorder_id" id="saleorder_id" value="<?php if(isset($record['saleorder_id'])){ echo $record['saleorder_id']; }  ?>" placeholder="Sales Order ID">
	   
	   
	   <?php $supplier=$this->session->userdata('name');
	   if(isset($action['data']) && $action['data']=='update'){ 
			$supplier=$record['so_owner'];
	   }else{ 
			if(isset($record['owner'])){
			    $supplier=$record['owner'];
			
			};
	   } 
	   if(isset($action['data']) && $action['data']=='update'){ 
			$otherRef=$record['owner'];
	   }else{ 
			$otherRef=$this->session->userdata('name');
	   }  ?>
	   
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				 <div class="form-group">
					<label for="">Supplier's Ref.<span style="color: #f76c6c;">*</span>:</label>
					<input type="text" class="form-control" name="supplier" placeholder="Supplier's Name" id="supplier" value="<?=$supplier;?>" readonly >
					<span id="invoice_no_error"></span>
				 </div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				 <div class="form-group">
					<label for="">Other Reference(s)<span style="color: #f76c6c;">*</span>:</label>
					<input type="text" class="form-control" name="owner" placeholder="Invoice Owner" id="owner" value="<?=$otherRef;?>" readonly >
					<span id="invoice_no_error"></span>
				 </div>
			</div>
			<!--<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				 <div class="form-group">
					<label for="">Invoice No<span style="color: #f76c6c;">*</span>:</label>
					<input type="text" class="form-control" name="invoice_no" placeholder="Invoice No (INV-00001)" id="invoice_no" value="<?php if(isset($record['invoice_no'])){ echo $record['invoice_no']; }  ?>" <?php if(isset($record['invoice_no'])){ echo "readonly";   }else{ echo 'onblur="check_invoiceNo()"'; } ?>>
					<span id="invoice_no_error"></span>
				 </div>
			</div>-->
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				 <div class="form-group">
					<label for="">Buyer's Order No.<span style="color: #f76c6c;">*</span>:</label>
					<input type="text" class="form-control" name="order_no" placeholder="Buyer's Order No" id="order_no" value="<?php if(isset($record['cust_order_no'])){ echo $record['cust_order_no']; }  ?>">
					<span id="invoice_no_error"></span>
				 </div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="form-group">
					<label for="">Buyer's Order Date<span style="color: #f76c6c;">*</span>:</label>
					<input type="date" class="form-control" name="buyer_date" placeholder="Buyer's Order Date (MM/DD/YYYY)" id="buyer_date" value="<?php if(isset($record['buyer_date'])){ echo $record['buyer_date']; }  ?>" >
					<span id="invoice_date_error"></span>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="form-group">
					<label for="">Invoice Date<span style="color: #f76c6c;">*</span>:</label>
					<input type="date" class="form-control" name="invoice_date" placeholder="(MM/DD/YYYY)" id="datepicker" value="<?php if(isset($record['invoice_date'])){ echo $record['invoice_date']; }  ?>" >
					<span id="invoice_date_error"></span>
				</div>
			</div> 
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="form-group">
					<label for="">Due Date:</label>
					<input type="date" class="form-control" name="invoice_dueDate" placeholder="(MM/DD/YYYY)"   id="datepicker-1" value="<?php if(isset($record['due_date']) && $record['due_date']!=""){ echo $record['due_date']; }  ?>" >
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			
				<div class="form-group">
					<label for="">Terms<span class="text-danger">*</span>:</label>
					<div class="input-group">
					<select class="form-control" name="terms_select" id="terms_select">
						<?php
							foreach ($invoice_terms as $inv_terms) { ?>
							<option value="<?php echo $inv_terms['inv_terms'];?>" <?php if(isset($record['inv_terms']) && $record['inv_terms']==$inv_terms['inv_terms']){ echo 'selected'; }else if($inv_terms['marks_default']== 1){ echo 'selected'; } ?>><?php echo $inv_terms['inv_terms'];?></option>
						<?php } ?>
					 
					  <option value="end_of_month" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='end_of_month'){ echo 'selected'; } ?>>Due end of the month</option>
					  <option value="end_next_month" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='end_next_month'){ echo 'selected'; } ?>>Due end of the next month</option>
					  <option value="due_receipt" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='due_receipt'){ echo 'selected'; } ?>>Due on receipt</option>
					  <option value="custom" <?php if(isset($record['inv_terms']) && $record['inv_terms']=='custom'){ echo 'selected'; } ?>>Custom</option>
					  
					</select>
						<div class="input-group-append" style="cursor:pointer" title="Config terms" onclick="addpay()">
							<span class="input-group-text" style="border-radius: 0px;">
							<!--<i class="fas fa-plus-circle"></i>-->
							<img src="https://img.icons8.com/office/24/000000/plus.png">
							</span>
						</div>
					</div>
					<span id="org_name_error"></span>
				</div>
			</div>	
              
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"> 
			  
				<span id="show_more_fields">
				<?php if(isset($record['extra_field_label']) && $record['extra_field_label']!=""){  
				$extraField_label=explode("<br>",$record['extra_field_label']);
				$extraField_value=explode("<br>",$record['extra_field_value']);
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
			  <a href="javascript:void(0);" class="add_moreField">
			  <i class="fas fa-plus-circle sub-icn-integration mr-1"></i>Add More Fields</a>
           
			</div>
        </div>
      </div>
    </div>
  </div>
  <div class="billing-section">
    <div class="container">
      <div class="row">
	  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedby billedto">
		  <h3>Billed By:-<span> (Your Details)<span style="color: #f76c6c;">*</span> </span></h3>
		  <?php $city_name = $this->session->userdata('city');?>
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
			  <input type="hidden" name="gstnoBranch" id="gstnoBranch">
            </div>
			<span id="billedby_error"></span>
          </div>
        </div>
	  
	    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
          <div class="billedto billedby">
		  <h3>Billed To:-<span> (Client Details)<span style="color: #f76c6c;">*</span> </span></h3>
		    <div class="form-group">
                <div class="input-group">
				<input type="hidden" name="customer_id" id="customer_id" value="">
                    <select class="form-control" name="customer_name" id="customer_name">
						<option>Select Customer</option>
						<?php
							foreach ($customer_details as $cust_details) { ?>
							<option value="<?php echo $cust_details['org_name'];?>" <?php if(isset($record['org_name']) && $record['org_name']==$cust_details['org_name']){ echo 'selected'; } ?>><?php echo $cust_details['org_name'];?></option>
						<?php } ?>
				 
					</select>
					<div class="input-group-append" style="cursor:pointer" onclick="add_formOrg('Customer','form')">
						<span class="input-group-text" style="border-radius: 0px;">
						<!--<i class="fas fa-plus-circle"></i>-->
						<img src="https://img.icons8.com/office/24/000000/plus.png">
						</span>
					</div>
                </div>
				<span id="org_name_error"></span>
            </div>
		  
			  <div class="business_detail" id="show_bdetails">
			   
			  </div>
			  <input type="hidden" name="gstnoCustomer" id="gstnoCustomer" >
            <div class="business_detail text-center" id="show_addBdetails">
			
              <div class="container"> 
			  <i class="far fa-user-circle"></i>
                <p>Select a Client/Business from list</p>
                <p>Or</p>
                <button type="button" onclick="add_formOrg('Customer','form')"><i class="fa fa-plus"></i> Add New Client</button>
              </div>
            </div>
			<span id="billedto_error"></span>
          </div>
        </div>
	  
        
        
      </div>
      
      
      <div class="proforma-table-main">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <ul class="list-inline">
              <li class="list-inline-item">
                <label> <input type="checkbox" name="tax" id="add_gst" checked > Add GST</li></label>
            </ul>
            <?php
			if(isset($record['igst'])){ 
			    $igst = explode("<br>",$record['igst']);
			}else{
				$igst=array();
			}
			if(isset($record['cgst'])){ 
			    $cgst = explode("<br>",$record['cgst']);
			}else{
				$cgst=array();
			}	
			
			?>
			
            <ul class="list-inline hide_gst_checkbox">
              <li class="list-inline-item">
                <label><input type="radio" name="type" value="Interstate"  id="igst_checked" checked <?php if(isset($record['type']) && $record['type']=='Interstate'){ echo "checked"; } ?> > IGST</label></li>
              <li class="list-inline-item">
                <label><input type="radio" name="type" value="Instate" id="csgst_checked" <?php if(isset($record['Instate']) && $record['Instate']=='Interstate'){ echo "checked"; } ?>> CGST & SGST</label></li>
            </ul>
          </div>
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="proforma-table">
              <table class="table table-responsive-lg" width="100%" id="add_new_line" >
			  <?php 
			  
			   
			  ?>
                <thead style="background:rgba(35, 0, 140, 0.8)">
                  <tr>
                    <th>Items</th>
                    <th>HSN/SAC</th>
                    <th >GST(%)</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Discount</th>										
                    <th>Total</th>
                  </tr>
                </thead>
				
               <?php 
				$rw=45;
				$dataList='';
				$dataList.='<datalist id="taxName">';  
				foreach($gstPer as $gstrow){ 
                $dataList.='<option value="'.$gstrow['gst_percentage'].'">'.$gstrow['tax_name'].'@</option>';
                }
                $dataList.='</datalist>';
				
				
				if(isset($record['product_name'])){
					$proName	= explode("<br>",$record['product_name']); 
					$hsn_sac	= explode("<br>",$record['hsn_sac']); 
					$quantity	= explode("<br>",$record['quantity']); 
					$unit_price	= explode("<br>",$record['unit_price']); 
					$total		= explode("<br>",$record['total']); 
					$gst		= explode("<br>",$record['gst']); 
					
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
					if(isset($record['pro_discount'])){ 
						$proDiscount=explode("<br>",$record['pro_discount']); 
					} 
				
				for($pr=0; $pr<count($proName); $pr++){ 
				//print_r($proDescription[$pr]);
				?>
                  <tr class="removCL<?=$rw;?>">
                     <td>
					<input type="text" name="product_name[]"  class="form-control productItm checkvl" id="proName<?=$rw;?>" data-cntid="<?=$rw;?>" onkeyup="getproductinfo();"  placeholder="Items name(required)" value="<?=$proName[$pr];?>"><span id="items_error"></span></td>
					
                     <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn<?=$rw;?>" placeholder="HSN/SAC" value="<?php if(isset($hsn_sac[$pr])){ echo $hsn_sac[$pr]; } ?>"></td>
					
					<td >
					<input type="text" name="gst[]" class="form-control checkvl"  onkeyup="calculate_pro_price()" id="gst<?=$rw;?>" placeholder="GST in %" value="<?php if(isset($gst[$pr])){ echo $gst[$pr]; } ?>" list="taxName">
					        <?php echo $dataList; ?> </td>
					
                    <td ><input type="text"  onkeyup="calculate_pro_price()" name="quantity[]" id="qty<?=$rw;?>" class="form-control checkvl numeric"  placeholder="qty" value="<?=$quantity[$pr];?>"><span id="quantity_error"></span></td>
					
                    <td><input type="text" onkeyup="calculate_pro_price()" name="unit_price[]" id="price<?=$rw;?>" class="form-control start checkvl price_float"  placeholder="rate" value="<?=$unit_price[$pr];?>"><span id="unit_price_error"></span></td>
					
					<td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?=$rw;?>" class="form-control price_float"  placeholder="Discount Price" value="<?php if(isset($proDiscount[$pr])){ echo $proDiscount[$pr]; }else{ echo "0"; } ?>"></td>
					
                    <td>
					<input type="text" name="total[]" class="form-control" class="" readonly value="<?=$total[$pr];?>">
					<input type="hidden" name="cgst[]" value="<?php if(isset($cgst[$pr])){ echo $cgst[$pr]; } ?>" class="" readonly>
					<input type="hidden" name="sgst[]" value="<?php if(isset($sgst[$pr])){ echo  $sgst[$pr]; } ?>" class="" readonly>
					<input type="hidden" name="igst[]" value="<?php if(isset($igst[$pr])){ echo  $igst[$pr]; }?>" class="" readonly>
					<input type="hidden" name="sub_total_with_gst[]" class="" readonly>
					</td>
                  </tr>
                  <tr class="pro_descrptions removCL<?=$rw;?> addCL<?=$rw;?>" <?php if(empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> >
                    <td colspan="11">
                      <input type="text" name="product_desc[]"  id="itemsprodesc"value="<?php if(isset($proDescription[$pr])){ echo $proDescription[$pr]; }?>"  placeholder="Description">
                    </td>
                  </tr>
                  <tr class="removCL<?=$rw;?>">
                    <td class="delete_new_line" colspan="2">
                      <a href="javascript:void(0);" onClick="removeRow('removCL<?=$rw;?>');" ><img src="https://img.icons8.com/dusk/24/000000/filled-trash.png"> Delete Row</a>
                    </td> 
                    <td colspan="8">
                      <a href="javascript:void(0);" class="add_desc deschd<?=$rw;?>" onClick="addDesc('addCL<?=$rw;?>','deschd<?=$rw;?>')" <?php if(!empty($proDescription[$pr])){ ?> style="display:none;" <?php } ?> ><img src="https://img.icons8.com/dusk/24/000000/add-property.png"> Add Description</a>
                    </td>   
                  </tr>
				  
				<?php $rw++; } }else{  ?>
				
				<tr class="removCL0">
                     <td>
					<input type="text" name="product_name[]"  class="form-control productItm checkvl" id="proName0" data-cntid="0" onkeyup="getproductinfo();"  placeholder="Items name(required)" value=""><span id="items_error"></span></td>
					
                     <td><input type="text" name="hsn_sac[]" class="form-control" id="hsn0" placeholder="HSN/SAC" value=""></td>
					
					<td >
					<input type="text" name="gst[]" class="form-control checkvl"  onkeyup="calculate_pro_price()" id="gst0" placeholder="GST in %" value="" list="taxName">
					        <?php echo $dataList; ?>
					</td>
					
                    <td ><input type="text"  onkeyup="calculate_pro_price()" name="quantity[]" id="qty0" class="form-control checkvl numeric"  placeholder="qty" value=""><span id="quantity_error"></span></td>
					
                    <td><input type="text" onkeyup="calculate_pro_price()" name="unit_price[]" id="price0" class="form-control start checkvl price_float"  placeholder="rate" value=""><span id="unit_price_error"></span></td>
					
					<td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc0" class="form-control price_float"  placeholder="Discount Price" value="0"></td>
					
                    <td>
					<input type="text" name="total[]" class="form-control" class="" readonly value="">
					<input type="hidden" name="cgst[]" value="" class="" readonly>
					<input type="hidden" name="sgst[]" value="" class="" readonly>
					<input type="hidden" name="igst[]" value="" class="" readonly>
					<input type="hidden" name="sub_total_with_gst[]" class="" readonly>
					</td>
                  </tr>
                  <tr class="pro_descrption removCL0 addCL0"  style="display:none;" >
                    <td colspan="11">
                      <input type="text" name="product_desc[]"  id="itemsprodesc" value=""  placeholder="Description">
                    </td>
                  </tr>
                  <tr class="removCL0">
                    <td class="delete_new_line" colspan="2">
                      <a href="javascript:void(0);" onClick="removeRow('removCL0');" ><img src="https://img.icons8.com/dusk/24/000000/filled-trash.png"> Delete Row</a>
                    </td> 
                    <td colspan="8">
                      <a href="javascript:void(0);" class="add_desc deschd0" onClick="addDesc('addCL0','deschd0')" ><img src="https://img.icons8.com/dusk/24/000000/add-property.png"> Add Description</a>
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
          <div  class="add_line"> <a href="javascript:void(0);"><img src="https://img.icons8.com/ultraviolet/20/000000/plus.png" style="margin-bottom: 4px;"> Add New Line</a>
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
					<input type="hidden" name="after_discount" id="after_discount">
        			
        			
        		<!---Discount Field--->	
        		 <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5">
        		    <p class="discount">Overall Discount:<br>
        		    ₹ <b id="cal_disc"></b>
        		    </p>
                 </div>
                 <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2 text-right">
                     
                 </div>
                 <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 text-right">
                    <p class="discount">
                        <input type="text" id="discounts" name="discount" onkeyup="calculate_pro_price()" value="<?php if(isset($record['discount']) && $record['discount']!=""){ echo $record['discount'];  }?>" class="form-control">
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
				<input type="hidden" name="total_igst" id="total_igst" value="0">
				<input type="hidden" name="total_cgst" id="total_cgst" value="0">
				<input type="hidden" name="total_sgst" id="total_sgst" value="0">
              </div>
        			
        			
        	<div class="row" id="putExtraVl">
			<?php 
			if(isset($record['extra_charge_label']) && $record['extra_charge_label']!=""){ 
			$extraChargeName=explode("<br>",$record['extra_charge_label']);
			$extraChargeValue=explode("<br>",$record['extra_charge_value']);
			$td=30;
			for($ex=0; $ex<count($extraChargeName); $ex++){
			?>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext<?=$td;?>" style="margin-bottom: 3%;">
				<input type="text" name="extra_charge[]" value="<?php echo $extraChargeName[$ex]; ?>" placeholder="Extra Charges Label" class="form-control" >
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl<?=$td;?>" style="margin-bottom: 3%;">
				<input type="text" onkeyup="calculate_pro_price()" placeholder="Extra Charges Value"  name="extra_chargevalue[]" id="floatvald<?=$td;?>"  value="<?php echo $extraChargeValue[$ex]; ?>" class="form-control inptvl">
				</div>
				<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows<?=$td;?>" style="margin-bottom: 3%;">
				<a href="javascript:void(0);" class="remove_additionalchg" id="<?=$td;?>">X</a>
				</div>
			<?php $td++; } } ?>				
              
            </div>  
             

              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <p class="add_discount"><a href="javascript:void(0);"><img src="https://img.icons8.com/office/18/000000/add-tag.png"> Add Discount</a>
                </p>
                <p><a href="javascript:void(0);" class="add_additionalchg"><img src="https://img.icons8.com/ultraviolet/20/000000/plus.png" style="margin-bottom: 4px;"> Add Additional Charges</a>
                </p>
				<hr>
              </div>
            </div>  
			
			<div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="total-price">
                  <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 inrRp">
                      <h6>Advance Payment</h6>
                    </div>
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 col-12 inrIcn">
						<img src="https://img.icons8.com/ultraviolet/22/000000/rupee.png"/>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                      <input id="advance_payment" name="advance_payment" class="form-control alpha_numeric" type="text" placeholder="Adv. Payment (Optional)" value="<?php if(isset($record['advanced_payment']) && $record['advanced_payment']!=""){ echo $record['advanced_payment']; } ?>" readonly >
                    </div>
                  </div>
                </div>
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
                        <h4><img src="https://img.icons8.com/office/23/000000/rupee.png"></h4>
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
    <?php 
	
		if(isset($record['invoice_declaration']) && $record['invoice_declaration']!=""){
			$declarationInv	= $record['invoice_declaration']; 
		}else if(isset($declaration['invoice_declaration'])){
			$declarationInv	= $declaration['invoice_declaration']; 
		}else{
			$declarationInv='';
		}			
	?>
  <div class="notes" style="padding: 20px 0;">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <a href="javascript:void(0);" style="display:none;" class="add_desclaration"><img src="https://img.icons8.com/ultraviolet/20/000000/plus.png" style="margin-bottom: 4px;"> Add Invoice Declaration</a>
          <div class="InvoiceDeclaration" >
            <textarea class="form-control" name="invoice_declaration" rows="3" style="padding-right: 25px;" placeholder="Invoice Declaration"><?php  echo $declarationInv; ?></textarea>
            <button class="remove_declaration" style="position: absolute;top: 8px; right: 20px;
    border: 0;background: none;" type="button"><img src="https://img.icons8.com/cotton/24/000000/delete-sign--v2.png"/></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
	<div class="contact_details">
		<div class="container">
		  <p class="sub-icn-so">Your terms line (Jurisdiction) :</p>
		  <div class="row">
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			  <p>Jurisdiction</p>
			  <input type="text" name="jurisdiction" value="<?php if(isset($record['jurisdiction']) && $record['jurisdiction']!=""){ echo $record['jurisdiction'];  }?>" placeholder="Ex. Delhi">
			</div>
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
			  <p>Extra charge on late payment (%)</p>
			  <input type="text" name="late_charge" value="<?php if(isset($record['late_charge']) && $record['late_charge']!=""){ echo $record['late_charge'];  }?>" placeholder="Ex. 24">
			</div>
		  </div>
		</div>
	</div>
  
  
  <div class="form-footer-section py-5">
    <div class="container">
		<a href="javascript:void(0);" class="add_terms"><img src="https://img.icons8.com/ultraviolet/20/000000/plus.png" style="margin-bottom: 4px;"> Add Terms</a>
		<div id="show_terms" style="display:none;">
		  <p><img src="https://img.icons8.com/nolan/26/terms-and-conditions.png">Terms and Condition :</p>
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
		  <div class="row m-0" id="add_terms_condition"> <a href="javascript:void(0);"><img src="https://img.icons8.com/ultraviolet/20/000000/plus.png" style="margin-bottom: 4px;"> Add New Term & Condition</a>
		  </div>
		</div>
    </div>
  </div>

  <div class="notes" style="padding: 20px 0;">
    <div class="container">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          <a href="javascript:void(0);" class="add_notes"><img src="https://img.icons8.com/fluent/22/000000/note.png" style="margin-bottom: 4px;" > Add Notes</a>
          <div class="notes_left" <?php if(empty($record['notes'])){ echo "style='display:none;'"; } ?> >
            <textarea class="form-control" name="notes" rows="5" style="padding-right: 25px;" placeholder="Enter Notes"><?php if(isset($record['notes'])){ echo $record['notes']; } ?></textarea>
            <button class="remove_notes" type="button" style="top: 8px;" ><img src="https://img.icons8.com/cotton/24/000000/delete-sign--v2.png"/></button>
          </div>
        </div>
        
		
      </div>
    </div>
  </div>
  
 
<div  style="display: none">
<input type="file" name="upload_signature" readonly>
<input type="hidden" name="signature_image" >
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
            <button type="button" id="btnSave" onclick="save();">Save & Continue</button>
            <button type="button" id="btnSaveCls" style="display:none;">Validating Data...</button>
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
</div>
				</div>






<!-- common footer include -->
<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<?php $this->load->view('product_onkeyup');?> 

<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/jquery.signature.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/cropzee.js" type="text/javascript"></script>
<script src="<?php echo base_url()."assets/"; ?>js/jquery.betterdropdown.js" type="text/javascript"></script>

<script>
function save(){
	if(checkValidationWithClass('form_invoice')==1){
	        toastr.info('Please wait while we are processing your request');
			$('#btnSave').hide();
			$('#btnSaveCls').show();
			var url;
		    var save_method=$("#save_method").val();
			if(save_method == 'add') {
				url = "<?= site_url('invoices/add_invoiceDetails')?>";
			} else {
				url = "<?= site_url('invoices/update_invoiceDetails')?>";
			}
			
			$.ajax({
				url : url,
				type: "POST",
				data: $('#form_invoice').serialize(),
				dataType: "JSON",
				success: function(data)
				{ 
				  if(data.status) 
				  {
				    toastr.success('Quotation has been added successfully.');
					window.location.href = '<?=base_url()?>invoices/view-invoice'+data.id;   
				  }else{
				    toastr.info('You are not changed anything.');  
				  }
				  $('#btnSaveCls').hide(); 
				  $('#btnSave').show();
				  if(data.st==202)
				  {
				    toastr.error('Validation Error, Please fill all star marks fields'); 
					checkValidationWithClass('form_invoice');	
				  }else if(data.st==200)
				  {
					toastr.error('Something went wrong, Please try later.');  
				  }
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				  toastr.error('Something went wrong, Please try later.'); 
				  $('#btnSaveCls').hide(); 
				  $('#btnSave').show();
				}
			});
		}
    }
		
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
calculate_pro_price();
	i=1;
var rowid=400;	
	$(".add_line").click(function()
    {
	  i++;
	  rowid++;
     var markup = '<tr class="removCL'+i+'" ><td><input type="text" name="product_name[]" class="form-control productItm checkvl" onkeyup="getproductinfo();" id="proName'+rowid+'" data-cntid="'+rowid+'" placeholder="Items name(required)"><span id="items_error"></span></td>'+
      '<td><input type="text" name="hsn_sac[]" class="form-control" id="hsn'+rowid+'" placeholder="HSN/SAC"></td>'+
      '<td ><input type="text" name="gst[]" class="form-control"  onkeyup="calculate_pro_price()" id="gst'+rowid+'" value="" placeholder="GST in %" list="taxName" ></td>'+
      '<td><input type="text" onkeyup="calculate_pro_price()" id="qty'+rowid+'" class="form-control integer_validqty'+i+'" name="quantity[]" placeholder="qty"><span id="quantity_error"></span></td>'+
      '<td><input type="text" name="unit_price[]"  id="price'+rowid+'" class="form-control start checkvl parseFloat" onkeyup="calculate_pro_price()" placeholder="rate"><span id="unit_price_error"></td>'+ 
	  '<td><input type="text" onkeyup="calculate_pro_price()" name="discount_price[]" id="disc<?=$rw;?>" class="form-control parseFloat"  placeholder="Discount Price" value="0"></td>'+
	  '<td><input type="text" name="total[]" class="form-control" readonly>'+
       '<input type="hidden" name="cgst[]"  readonly>'+
      ' <input type="hidden" name="sgst[]" readonly>'+
       '<input type="hidden" name="igst[]"  readonly>'+
		'<input type="hidden" name="sub_total_with_gst[]" readonly></td> </tr>'+
		'<tr class="pro_descrption removCL'+i+' addCL'+i+'"><td colspan="8">'+
           '<input type="text" name="pro_description[]" id="" placeholder="Description"></td></tr>'+
          '<tr class="removCL'+i+'"><td class="delete_new_line" colspan="2" onClick="removeRow(`removCL'+i+'`);" >'+
                '<a href="javascript:void(0);"><img src="https://img.icons8.com/dusk/24/000000/filled-trash.png"> Delete Row</a></td>'+ 
               '<td colspan="8"><a href="javascript:void(0);" class="add_desc deschd'+i+'" onClick="addDesc(`addCL'+i+'`,`deschd'+i+'`);"><img src="https://img.icons8.com/dusk/24/000000/add-property.png"> Add Description</a></td></tr>';
      $("#add_new_line").append(markup);
	  
	  $('.igst,.gst,.sub_total,.cgst,.sgst').hide();
	  
		if($('#add_gst').is(":checked"))
        {
			if($('#igst_checked').is(":checked"))
			{
				$('.sub_amount,.sub_total,.gst,.igst').show();
				$('.cgst,.sgst').hide();
				
				calculate_pro_price();
			}else if($('#csgst_checked').is(":checked"))
			{
				$('.sub_amount,.gst,.sub_total').show();
				$('.cgst,.sgst').show();
				$('.igst').hide();
				
				calculate_pro_price();
			}
		}
	//only integer validation on quantity		
	$(".integer_validqty"+i+"").inputFilter(function(value) {
      return /^-?\d*$/.test(value); });
	$(".float_validup"+i+"").inputFilter(function(value) {
     return /^-?\d*[.,]?\d{0,2}$/.test(value); });  
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
       calculate_pro_price();
   }
   
   function addDesc(addCL,deschd){
       $("."+addCL).show();
       $("."+deschd).hide();
       
   }
   
/*********** start calculate invoice****/
function calculate_pro_price()
{
	  var Amount=0;
	  var IGST =0;
	  var DiscpriceT =0;
	  var cal_discount=0;
	  var extraCharge=0;
	  var SCGST = 0;
	$("input[name='quantity[]']").each(function (index) {
		    var quantity = $("input[name='quantity[]']").eq(index).val();
            var price = $("input[name='unit_price[]']").eq(index).val();
			price = price.replace(/,/g, "");
			var pricetwo=numberToIndPrice(price);
			$("input[name='unit_price[]']").eq(index).val(pricetwo);
			
			//Dicount Price
            var Discprice = $("input[name='discount_price[]']").eq(index).val();
			Discprice = Discprice.replace(/,/g, "");
			DiscpriceT=parseFloat(DiscpriceT)+parseFloat(Discprice);
			var Discpricetwo=numberToIndPrice(Discprice);
			$("input[name='discount_price[]']").eq(index).val(Discpricetwo);
			

            var gst = $("input[name='gst[]']").eq(index).val();
			if(gst==""){
				gst=0;
			}
            var output = parseInt(quantity) * parseFloat(price);
			output=parseInt(output)-parseInt(Discprice);
            var tax = parseFloat(output) * parseFloat(gst)/100;
			if (!isNaN(output))
            {
				Amount=parseFloat(Amount)+parseFloat(output);
                $("input[name='total[]']").eq(index).val(numberToIndPrice(output.toFixed(2)));
				if($('#add_gst').is(":checked"))
                {    
					
					IGST = parseFloat(IGST)+parseFloat(tax);
					SCGST = parseFloat(IGST)/2;
					var addgst_subTotal = parseFloat(tax) + parseFloat(output);
					$("input[name='sub_total_with_gst[]']").eq(index).val(addgst_subTotal.toFixed(2));
					if($('#igst_checked').is(":checked")){
						
					$("input[name='igst[]']").eq(index).val(tax.toFixed(2));
					   $("input[name='cgst[]']").eq(index).val('');
					   $("input[name='sgst[]']").eq(index).val('');
					}else if($('#csgst_checked').is(":checked"))
					{
						$("input[name='igst[]']").eq(index).val('');
						var taxs = parseFloat(tax)/2;
					   $("input[name='cgst[]']").eq(index).val(taxs.toFixed(2));
					   $("input[name='sgst[]']").eq(index).val(taxs.toFixed(2));
				    }
				}
				
			}
	});
	
	//console.log(Amount);
	var discount = document.getElementById('discounts').value;
	if(discount!="" && discount!=0){
	discount = discount.replace(/,/g, "");
	var cal_discount = parseFloat(discount);
	}else{
	var cal_discount=0;	
	}
	$('#discounts').val(numberToIndPrice(discount));
	
	$('#cal_disc').html(numberToIndPrice(cal_discount.toFixed(2)));
	$('#total_discount').val(numberToIndPrice(cal_discount.toFixed(2)));

	var GrandAmount=parseFloat(Amount)+parseFloat(IGST);
	GrandAmount=parseFloat(GrandAmount)-parseFloat(cal_discount);
	$('#after_discount').val(GrandAmount);
	$("input[name='extra_chargevalue[]']").each(function (index) {
		var extra_charge = $("input[name='extra_chargevalue[]']").eq(index).val();
		extra_charge = extra_charge.replace(/,/g, "");
		$("input[name='extra_chargevalue[]']").eq(index).val(numberToIndPrice(extra_charge));
		if(extra_charge!== undefined && extra_charge!="")
		{
			extraCharge=parseFloat(extraCharge)+parseFloat(extra_charge);		    
		}
	});
	
	GrandAmount=parseFloat(GrandAmount)+parseFloat(extraCharge);
	
	$("#show_subAmount").html(Amount.toFixed(2));
	$('#initial_total').val(numberToIndPrice(Amount.toFixed(2)));
	$("#show_igst").html(IGST.toFixed(2));
	$("#show_cgst").html(SCGST.toFixed(2));
	$("#show_sgst").html(SCGST.toFixed(2));
	if($('#igst_checked').is(":checked")){
		$("#total_igst").val(IGST.toFixed(2));
		$("#total_cgst").val('');
		$("#total_sgst").val('');
	}else{
		$("#total_cgst").val(SCGST.toFixed(2));
		$("#total_sgst").val(SCGST.toFixed(2));
		$("#total_igst").val('');
	}
	
	
	$('#final_total').val(numberToIndPrice(GrandAmount.toFixed(2)));
	$('#digittowords').html(digit_to_words(GrandAmount));
}
</script>
<script>

function getBranchDetails(){
	var id = $('#billed_by').val();
	if(id!=""){
		$.ajax({
            url : "<?php echo site_url('home/getbranchbyId/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
				gstSelect();
				$('#bname').html(data.company_name);
				$('#adress_by').html(data.address);
				$('#city_by').html(data.city);
				$('#state_by').html(data.state);
				$('#country_by').html(data.country);
				$('#zipcode_by').html(data.zipcode);
				$('#email_by').html(data.branch_email);
				$('#phone_by').html(data.contact_number);
				$('#gstin_by').html(data.gstin);
				$('#gstnoBranch').val(data.state);
				$('#pan_by').html(data.pan);
				
			}
		});
	}
}
	//show branch billed by on click
	getBranchDetails();
	 $('#billed_by').click(function() {
		getBranchDetails();
	 }); 
	 
function gstSelect(){
	var customergst	= $('#gstnoCustomer').val();
	var branchgst	= $('#gstnoBranch').val();

	if(customergst==branchgst){	
		$("#igst_checked").attr('checked', false);
		$("#csgst_checked").attr('checked', true);
		$('#csgst_checked').click();
		$("#csgst_checked").attr('disabled', false);
		$("#igst_checked").attr('disabled', true);
	}else{
		// -------------Old Code--------
		// $("#igst_checked").attr('disabled', false);
		// $("#csgst_checked").attr('disabled', true);
		// -----------------------------
		
		// -------------my new code--------
		// $("#igst_checked").attr('checked', true);
		$("#igst_checked").attr('checked', true);
		$("#csgst_checked").attr('checked', false);
		$('#igst_checked').click();
		$("#csgst_checked").attr('disabled', true);
		$("#igst_checked").attr('disabled', false);
		// -----------------------------

	}
}
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
		     calculate_pro_price();
		}else{
		  $('.hide_gst_checkbox').toggle("hide");
		  $('.gst').hide();
		  $('.igst').hide();
		  $('.cgst').hide();
		  $('.sgst').hide();
		  $('.sub_amount').hide();
		  $('.sub_total').hide();
          calculate_pro_price();		  
		}
		
    });
	
	
	
	/******by default show and hide start**********/
	
	$('.sub_amount').hide();
	$('.igst').hide();
	$('.gst').hide();
	$('.sub_total').hide();
	$('.cgst').hide();
	$('.sgst').hide();
	$('.add_discount').show();
	$('.discount').hide();
	$('.add_signature').show();
    $('.add_attach').show();
	$('#show_bdetails').hide();
	$('#show_addBdetails').show();
    $('#errorMsgbox').hide();
	
	
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
		calculate_pro_price();
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
		calculate_pro_price();
	}
   });
   
   <?php if(isset($record['igst'])){  $igst=explode("<br>",$record['igst']); if($igst[0]!=""){ ?>
	
	$('#igst_checked').prop('checked', true); $('#igst_checked').click(); 
	<?php }else{ ?> 
	
	$('#csgst_checked').prop('checked', true);  $('#csgst_checked').click(); 
	<?php } } ?>
	
   

   
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
		calculate_pro_price();
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
	
	//add add_desclaration
	$('.add_desclaration').click(function() {   
	    $('.add_desclaration').hide();
		$('.InvoiceDeclaration').show();
	});
	$('.remove_declaration').click(function() {   
	    $('.add_desclaration').show();
		$('.InvoiceDeclaration').hide();
		$('[name="invoice_declaration"]').val(function() {
        return this.defaultValue;
        });
	});
	
	
	//add more extra charge and value 
	var i = 1;
	$('.add_additionalchg').click(function() {  
	    i++;
	    var markup = '<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5" id="ext'+i+'" style="margin-bottom: 3%;"> <input type="text" name="extra_charge[]" value="" placeholder="Extra Charges" class="form-control" ></div>'+
		'<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6" id="extVl'+i+'" style="margin-bottom: 3%;"><input type="text" onkeyup="calculate_pro_price()" name="extra_chargevalue[]" id="floatvald'+i+'"  value="" class="form-control inptvl"></div>'+
             '<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-1" id="rows'+i+'" style="margin-bottom: 3%;"><a href="javascript:void(0);" class="remove_additionalchg" id="'+i+'"><i class="fas fa-times"></i></a></div>';

	  $("#putExtraVl").append(markup);
	  $("#floatvald"+i+"").inputFilter(function(value) {
       return /^-?\d*[.,]?\d{0,2}$/.test(value); });
	  
	});
	
	$(document).on('click','.remove_additionalchg',function(){
        var button_id = $(this).attr("id");
        $("#ext"+button_id+", #extVl"+button_id+", #rows"+button_id).remove();
		$("#floatvald"+button_id).val("");
		calculate_pro_price()
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

<script>


</script>
<!-- AUTOCOMPLETE QUERY -->


<script>
	showBillto();
	$("#customer_name").change(function(){
		showBillto();
	});
function showBillto(){
			
	var org_name=$("#customer_name").val();
	var invc_id	 =$("#invc_id").val();
		
		$.ajax({
          url:"<?=site_url('contacts/get_org_details')?>",
          method: 'post',
          data: {org_name: org_name},
          dataType: 'json',
          success: function(response){
            var len = response.length;
            if(len > 0)
            {
			  $('#show_bdetails').show();
			  $('#show_addBdetails').hide();
			  var org_id = response[0].id; 
			  $('#customer_id').val(org_id);
			  
              var email  = response[0].email;              
              var mobile = response[0].mobile;                                         
              var shipping_country = response[0].shipping_country;
              var shipping_state = response[0].shipping_state;
              var shipping_city = response[0].shipping_city;
              var shipping_zipcode = response[0].shipping_zipcode;
              var shipping_address = response[0].shipping_address;
			  var pan   = response[0].panno;  
			  var gstin = response[0].gstin;
			  var cust_state = response[0].shipping_state;
				
              $('#gstnoCustomer').val(cust_state);
			  
              $('#adress_to').html(shipping_address);
              $('#email_to').html(email);
              $('#phone_to').html(mobile);
              $('#city_to').html(shipping_city);
			  $('#zipcode_to').html(shipping_zipcode);
              $('#bname_to').html(org_name);
              $('#country_to').html(shipping_country);
              $('#state_to').html(shipping_state);
			  gstSelect();
			  var output = '<div class="container p-0"><div class="row"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12"><h5>Business Detail</h5></div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 text-right" id="show_editlinkto"></div></div></div><p><b>Business Name:</b> <span id="bname_to">'+response[0].org_name+'</span></p><p> <b>Address:</b>';
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
			  
			  
			}
			}
		});
		
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
$("#confirmed").click(function(){
  deleteBulkItem('organizations/delete_bulk'); 
});

function refreshPage(){
    window.location.reload();
} 
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
  //$('#customer_name').searchableSelect();
  $("#terms_select").select2();
  $("#customer_name").select2();
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

</script>