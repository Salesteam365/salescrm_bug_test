<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Company Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Company Profile</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card bg-gradient-primary detail_section">
                <div class="row" style="border-bottom: 1px solid #e0dcdcad;  padding-bottom: 8px;">
                    <div class="card-tools ml-auto col-lg-9 ">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i>
                            <?php if(empty($this->session->userdata('company_name'))) { echo "Add your company detail to use team365 CRM "; }else{ echo "Details"; } ?> 
                        </h3>
                    </div>
                    <div class="card-tools ml-auto col-lg-3 text-right">
    			        <?php if($this->session->userdata('type') == 'admin') { ?>
                        <button type="button" id="idForModel" class="btn bg-info btn-tool" data-card-widget="" data-toggle="modal" data-target="#edit_profile">
                          <?php if(empty($this->session->userdata('company_name'))) { ?><i class="fas fa-plus-circle"></i>
                        <?php }else{ ?>
                        <i class="fas fa-pen-square"></i>
                        <?php } ?>
                        </button>
    			        <?php } ?>
                    </div>
                </div>
              <div class="card-body">
                <div class="tab-content p-0">
                    <div class="row">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Name</label>
                          <h4><?= ucwords($this->session->userdata('name')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Name <span class="text-info">*</sapn></label>
                          <h4><?= ucwords($this->session->userdata('company_name')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company Contact</label>
                          <h4><?= $this->session->userdata('mobile'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Email <span class="text-info">*</sapn></label>
                          <h4><?= $this->session->userdata('company_email'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Website</label>
                          <h4><?= $this->session->userdata('company_website'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Company GSTIN</label>
                          <h4><?= $this->session->userdata('company_gstin'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Country</label>
                          <h4><?= ucfirst($this->session->userdata('country')); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">State</label>
                          <h4><?= $this->session->userdata('state'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">City</label>
                          <h4><?= $this->session->userdata('city'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Address</label>
                          <h4><?= $this->session->userdata('company_address'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">Zip Code</label>
                          <h4><?= $this->session->userdata('zipcode'); ?></h4>
                        </div>
                      </div>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">PAN</label>
                          <h4><?= $this->session->userdata('pan_number'); ?></h4>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">CIN</label>
                          <h4><?= $this->session->userdata('cin'); ?></h4>
                        </div>
                      </div>
                       <?php if($this->session->userdata('license_activation_date')!=='0000-00-00'){ ?>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Activation Date</label>
                          <h4><?= date('d-m-Y', strtotime($this->session->userdata('license_activation_date'))); ?></h4>
                        </div>
                      </div>
                       <?php } if($this->session->userdata('license_expiration_date')!=='0000-00-00'){ ?>
                      <div class="col-lg-4 col-6">
                        <div class="inner_details">
                          <label for="">License Expiration Date</label>
                          <h4><?= date('d-m-Y', strtotime($this->session->userdata('license_expiration_date'))); ?></h4>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                    <?php if($this->session->userdata('type') == 'admin') { ?>
                        <?php if($this->session->userdata('account_type')=='Trial'){?>
                        <div class="col-lg-4 col-6">
                          <div class="inner_details">
                            <label for="">Account Valid To</label>
                            <h4><?= date('d-m-Y', strtotime($this->session->userdata('trial_end_date'))); ?></h4>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                    <div class="row mt-3">
                    <span class="text-secondary mt-4">
                        Note:- * You can't change.
                    </span>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </section>
          <!-- right col -->
        </div>
        
      </div>
    </section>
  </div>
  
  
  <style>
  .inputbootomBor{
	border: 0;
    border-radius: 0px;
    border-bottom: 1px solid #bfb9b9;
  }
  .numberDisp{
	  
    margin-left: 10px;
    padding-top: 18px;

  }
  </style>
  <!-- EDIT PROFILE MODAL -->
  <div class="modal fade" id="edit_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-info modal-lg" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <h4 class="heading mb-0"><?php if(empty($this->session->userdata('company_name')))
    	    { echo 'Add'; }else{ echo 'Update'; } ?> your company details</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="formDiv">
        <form class="row" method="post" id="profile_company">
            <?php if(empty($this->session->userdata('company_name'))){ ?>
		<div class="col-12">
		  <div class="form-group">
			<label for="">Company Name<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control onlyLetters" name="company_name" id="company_name" value="<?php echo $this->session->userdata('company_name'); ?>" placeholder="Company Name">
		  </div>
		</div>
          <?php  } ?>
        <div class="col-6">
            <div class="form-group">
                <label for="">Company Website <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control" name="company_website" id="company_website" value="<?php echo $this->session->userdata('company_website'); ?>" placeholder="Company Website">
           </div>
        </div>
           <?php if(empty($this->session->userdata('company_email'))){ ?>
        <div class="col-6">
            <div class="form-group">
              <label for="">Company Email<span class="text-danger">*</span>:</label>
            <input type="email" class="form-control" name="company_email" id="company_email" value="<?php echo $this->session->userdata('company_email'); ?>" placeholder="Company Email">
          </div>
        </div>  
          <?php } ?>
        <div class="col-6">
            <div class="form-group">
            <label for="">Company Mobile No.<span class="text-danger">*</span>:</label>   
            <input type="text" class="form-control numeric" name="company_mobile" id="company_mobile" maxlength="10" value="<?php echo $this->session->userdata('company_mobile'); ?>" placeholder="Company Mobile" >
          </div>
        </div>  
        <div class="col-6">
            <div class="form-group">
            <label for="">Company PAN No.<span class="text-danger">*</span>:</label>    
            <input type="text" class="form-control text-uppercase" maxlength="10" name="pan_number" id="pan_number" value="<?php echo $this->session->userdata('pan_number'); ?>" placeholder="PAN">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Company CIN No.:</label>
                <input type="text" class="form-control" name="cin"  value="<?php echo $this->session->userdata('cin'); ?>" placeholder="CIN">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Company GSTIN:</label>
                <input type="text" class="form-control text-uppercase" name="company_gstin" id="company_gstin" value="<?php echo $this->session->userdata('company_gstin'); ?>" maxlength="15" placeholder="GSTIN">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
               <label>Country
                <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control onlyLetters" name="country" id="country" placeholder="Country" value="<?php echo $this->session->userdata('country'); ?>">
                <input type="hidden" class="form-control" id="country_ids"  >
            </div> 
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>State
                <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control onlyLetters" name="state" id="states" placeholder="State" value="<?php echo $this->session->userdata('state'); ?>" >
                <input type="hidden" class="form-control" id="state_id" >
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>City
                <span class="text-danger">*</span>:</label>   
                <input type="text" class="form-control onlyLetters" name="city" id="cities" placeholder="City" value="<?php echo $this->session->userdata('city'); ?>" >
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
               <label>Pincode
                <span class="text-danger">*</span>:</label>
                <input type="text" class="form-control numeric" name="zipcode" id="zipcode" placeholder="Zipcode" value="<?php echo $this->session->userdata('zipcode'); ?>">
            </div>
        </div>
        <div class="col-md-12 mb-3">
				<div class="form-group">
					<label for="">Company Address<span style="color: #f76c6c;">*</span>:</label>
					<textarea type="text" class="form-control" name="address" id="address" placeholder="Address"  required><?php echo $this->session->userdata('company_address'); ?></textarea>
				</div>	
        </div>
		  <div class="col-md-12 mb-3">
				<div class="form-group">
					<label for="">Invoice Declaration<span style="color: #f76c6c;">*</span>:</label>
					 <textarea type="text" class="form-control" name="invoice_declaration" id="invoice_declaration" placeholder="Address"  required><?= $invoice_declarations; ?></textarea>
				</div>
          </div>
		  <?php $custTerm=explode("<br>",$this->session->userdata('terms_condition_customer')); $no=1;
		  if(count($custTerm)<1){
		  ?>
		  <div class="col-md-12 mb-3 text-left" id="termLbl">
              <a id="termLbl" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add Terms & Conditions</a>
          </div>
          <?php } ?>
          <div class="col-md-12 mb-3" id="termConApp" <?php if(count($custTerm)<1){ ?> style="display:none;" <?php } ?> >
			    <div class="row mt-3" id="msgDiv12">
					<div class="col-lg-12 col-12 text-left">
                    Customer Terms & Conditions  
					</div>
				</div>
			    <div class="row mt-3" id="putline">
					
					<?php for($i=0; $i<count($custTerm); $i++){ ?>
						<div class="col-lg-1 col-1 numberDisp " id="noid<?=$i;?>">
							<p><?=$no;?></p>
						</div>
						<div class="col-lg-10 col-10" id="inptdv<?=$i;?>">
							<input type="text" id="inpt<?=$i;?>" class="form-control inputbootomBor" name="terms_condition_customer[]"  value="<?php echo $custTerm[$i];?>" placeholder="Customer Terms & Condition" >
						</div>
						<div class="numberDisp" style="" id="rm<?=$i;?>">
						<i class="far fa-times-circle" onClick="removeRow(<?=$i;?>,'putline')" ></i>
						</div>
					<?php $no++; } ?>
                      
				</div>
				<div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details text-left" >
                          <a id="addLine" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add line</a>
                        </div>
                      </div>
				</div>
			  
				 
          </div>
		 
		<?php $custTermSell=explode("<br>",$this->session->userdata('terms_condition_seller')); $no=1; 
		
		if(count($custTermSell)<1){
		?>
		
		    <div class="col-md-12 mb-3 text-left" id="termSel">
              <a id="termLblSel" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add Seller Terms & Conditions</a>
            </div>
            <?php } ?>
          <div class="col-md-12 mb-3" id="termConAppSell" <?php if(count($custTermSell)<1){ ?> style="display:none;" <?php } ?> >
              
			<div class="row mt-3" id="msgDiv21">
					<div class="col-lg-12 col-12 text-left">
                    Seller Terms & Conditions  
					</div>
			</div>
			    <div class="row mt-3" id="putlineSell">
					
					<?php $id=101; for($i=0; $i<count($custTermSell); $i++){ ?>
						<div class="col-lg-1 col-1 numberDisp " id="noid<?=$id;?>">
							<p><?=$no;?></p>
						</div>
						<div class="col-lg-10 col-10" id="inptdv<?=$id;?>">
							<input type="text" id="inpt<?=$id;?>" class="form-control inputbootomBor" name="terms_condition_seller[]"  value="<?php echo $custTermSell[$i];?>" placeholder="Seller Terms & Condition" >
						</div>
						<div class="numberDisp" style="" id="rm<?=$id;?>">
						<i class="far fa-times-circle" onClick="removeRow(<?=$id;?>,'putlineSell')" ></i>
						</div>
					<?php $no++; } ?>
                      
				</div>
				<div class="row mt-3">
                      <div class="col-lg-4 col-6">
                        <div class="inner_details text-left" >
                          <a id="addLineSell" style="cursor: pointer;" > <i class="fas fa-plus-circle"></i> Add line</a>
                        </div>
                      </div>
				</div>  
			  
			  
          </div>
          <div class="col-md-9 mb-3">
          </div>
          <div class="col-md-3 mb-3">
              <button type="button" class="btn btn-primary btn-sm float-right" name="add_details" id="add_details" >Submit</button>
          </div>
        </form>
       
        <span style="color: red; float: left;">**Note: Add your company detail to use team365 CRM</span>
      </div>
      
      <div class="modal-body" style="display:none; padding:10%;" id="msgDiv">
          
      </div>
      
    </div>
  </div>
</div>
 <?php $this->load->view('footer');?>
 <!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>

<?php if(empty($this->session->userdata('company_name'))) { ?>
$('#idForModel').click();
<?php } ?>

$("#termLblSel").click(function(){
	$("#termConAppSell").show();
	$("#termLblSel").hide();
});

var num=201;
$("#addLineSell").click(function(){
	num++;
	var appendData='<div class="col-lg-1 col-1 numberDisp " id="noid'+num+'"><p>'+num+'.</p></div>'+
	'<div class="col-lg-10 col-10" id="inptdv'+num+'"><input type="text" id="inpt'+num+'" class="form-control inputbootomBor" name="terms_condition_seller[]" placeholder="Customer Terms & Condition" ></div>'+
	'<div class="numberDisp" style="" id="rm'+num+'"><i class="far fa-times-circle" onClick="removeRow('+num+',`putlineSell`)" ></i></div>';
	$("#putlineSell").append(appendData);
	countPtg('putlineSell');
});

$("#termLbl").click(function(){
	$("#termConApp").show();
	$("#termLbl").hide();
});

var no=541;
$("#addLine").click(function(){
	no++;
	var appendData='<div class="col-lg-1 col-1 numberDisp " id="noid'+no+'"><p>'+no+'.</p></div>'+
	'<div class="col-lg-10 col-10" id="inptdv'+no+'"><input type="text" id="inpt'+no+'" class="form-control inputbootomBor" name="terms_condition_customer[]" placeholder="Customer Terms & Condition" ></div>'+
	'<div class="numberDisp" style="" id="rm'+no+'"><i class="far fa-times-circle" onClick="removeRow('+no+',`putline`)" ></i></div>';
	$("#putline").append(appendData);
	countPtg('putline');
});


function removeRow(id,pid){
	$("#noid"+id+", #inptdv"+id+", #inpt"+id+", #rm"+id).remove();
	countPtg(pid);
}
function countPtg(pid){
        var arr = $('#'+pid+' p');
        var cnt=1;
        for(i=0;i<arr.length;i++)
        {
          $(arr[i]).html(cnt+".");
          cnt++;
        }
}



$("#pan_number").keyup(function () {  
 var inputvalues = $(this).val(); 
 var reggstFi = /^([a-zA-Z])+$/;
 var reggstNi = /^([a-zA-Z]){5}([0-9])+$/;
 var reggstTe = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
 
 var strLen = inputvalues.length;
 if(strLen>0 && strLen<6 && !reggstFi.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>5 && strLen<10 && !reggstNi.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>9  && !reggstTe.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 
}); 

       
$("#company_gstin").keyup(function () {  
 var inputvalues = $(this).val();  
 var reggstTow = /^([0-9])+$/;
 var reggstSev = /^([0-9]){2}([a-zA-Z])+$/;
 var reggstEl = /^([0-9]){2}([a-zA-Z]){5}([0-9])+$/;
 var reggstTw = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z])+$/;
 var reggstTh = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9])+$/;
 var reggstFo = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z])+$/;
 var reggstFi = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([a-zA-Z0-9])+$/;
 var strLen = inputvalues.length;
 if(strLen>0 && strLen<3 && !reggstTow.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>2 && strLen<8 && !reggstSev.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>7 && strLen<12 && !reggstEl.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>11 && strLen<13 && !reggstTw.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>12 && strLen<14 && !reggstTh.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if(strLen>13 && strLen<15 && !reggstFo.test(inputvalues)){
	$(this).css('border-color','red'); 
 }
 if((strLen>14 && !reggstFi.test(inputvalues)) || strLen>15){
	$(this).css('border-color','red'); 
 }
}); 

 $('#add_details').click(function(){
     
     var com_name="<?php echo $this->session->userdata('company_name'); ?>";
     var com_eml="<?php echo $this->session->userdata('company_email'); ?>";
     var reggst = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([a-zA-Z0-9]){1}?$/;
     var reggstPan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
	 var company_name   = $("#company_name").val();
	 var company_website= $("#company_website").val();
	 var company_mobile = $("#company_mobile").val();
	 var company_email  = $("#company_email").val();
	 var country        = $("#country").val();
	 var states         = $("#states").val();
	 var cities         = $("#cities").val();
	 var zipcode        = $("#zipcode").val();
	 var address        = $("#address").val();
	 var panNumber      = $("#pan_number").val();
	 var companyGstin   = $("#company_gstin").val();
	 
	 var terms_condition_customer=$("#terms_condition_customer").val();
	 var terms_condition_seller=$("#terms_condition_seller").val();
	 
	 if(company_name=="" && com_name==""){
		 $("#company_name").css('border-color','red');
		 $("#company_name").focus();
		 return false
	 }else if(company_website==""){
		 $("#company_website").css('border-color','red');
		 $("#company_website").focus();
		 return false
	 }else if(company_email=="" && com_eml==""){
		 $("#company_email").css('border-color','red');
		 $("#company_email").focus();
		 return false
	 }else if(IsEmail(company_email)==false && com_eml==""){
		 $("#company_email").css('border-color','red');
		 $("#company_email").val('');
		 $("#company_email").attr('placeholder','Enter Valid Email Address');
		 $("#company_email").focus();
		 return false
	 }else if(company_mobile=="" || company_mobile==0 ){
		 $("#company_mobile").css('border-color','red');
		 $("#company_mobile").focus();
		 return false
	 }else if(panNumber=="" || !reggstPan.test(panNumber) ){
		 $("#pan_number").css('border-color','red');
		 $("#pan_number").focus();
		 toastr.error('PAN is not valid. It should be in this "AAAAA1111A" format');
		 return false
	 }else if(companyGstin!="" && !reggst.test(companyGstin) ){
		 $("#company_gstin").css('border-color','red');
		 $("#company_gstin").focus();
		 toastr.error('GSTIN is not valid. It should be in this "11AAAAA1111Z1A1" format');
		 return false
	 }else if(country==""){
		 $("#country").css('border-color','red');
		 $("#country").focus();
		 return false
	 }else if(states==""){
		 $("#states").css('border-color','red');
		 $("#states").focus();
		 return false
	 }else if(cities==""){
		 $("#cities").css('border-color','red');
		 $("#cities").focus();
		 return false
	 }else if(zipcode==""){
		 $("#zipcode").css('border-color','red');
		 $("#zipcode").focus();
		 return false
	 }else if(address==""){
		 $("#address").css('border-color','red');
		 $("#address").focus();
		 return false
	 }else if(terms_condition_customer==""){
		 $("#terms_condition_customer").css('border-color','red');
		 $("#terms_condition_customer").focus();
		 return false
	 }else if(terms_condition_seller==""){
		 $("#terms_condition_seller").css('border-color','red');
		 $("#terms_condition_seller").focus();
		 return false
	 }else{
		
    	var url = "<?= base_url('company/add_company_details'); ?>";
        var form=$("#profile_company").get(0);
        var formData = new FormData(form);
        $.ajax({
          url : url,
          type: "POST",
          data: formData,
          processData:false,
          contentType:false,
          cache:false,
          success: function(data){     
            $("#msgDiv").html(data);
            $("#formDiv").hide();
            $("#msgDiv").show();
            setTimeout(function(){
              $('#profile_company')[0].reset();
              $("#msgDiv").hide();
              $("#formDiv").show();
              $("#msgDiv").html('');
              $('#edit_profile').modal('hide');
              location.reload();
            },3000);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error adding / update data');
            $('#update_profile').text('save'); //change button text
            $('#update_profile').attr('disabled',false); //set button enable
          }
        });
	 }
	 
 });
function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}
$(".form-control").keypress(function(){
	$(this).css('border-color','');
});


/*#########
validation to checkvebsite

//alert(isValidURL('http://appvela.com/')); 

function isValidURL(str) {
   var a  = document.createElement('a');
   a.href = str;
   return (a.host && a.host != window.location.host);
}
###########*/

 $("#company_mobile").keypress(function (e) {
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});

$(document).ready(function(){
  $('#country').autocomplete({
    source: "<?= site_url('login/autocomplete_countries');?>",
    select: function (event, ui) {
      $(this).val(ui.item.label);
       $('#country_ids').val(ui.item.values);
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
      $(this).val(ui.item.label);
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
