<?php $this->load->view('common_navbar'); ?>
<style type="text/css">

.button input[type="radio"] {
    display: none;
}

input[type="radio"]:checked + img {
    border: 2px solid red;
}
</style>
<body>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Invoice Template</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>home">Home</a></li>
              <li class="breadcrumb-item active">Invoice Template</li>
            </ol>
          </div><!-- /.col -->
        </div>
<label class="button">
  <input type="radio" name="test" value="template1" class="check_template" <?php if($checked_invoice['invoiceTemplate_setting'] == 'template1'){ echo 'checked'; } ?>>
  <img src="<?php echo base_url('assets/img/invoice_template1.png'); ?>" style="width: 300px;height:500px;">
</label>

<label class="button">
  <input type="radio" name="test" value="template2" class="check_template" <?php if($checked_invoice['invoiceTemplate_setting'] == 'template2'){ echo 'checked'; } ?>>
  <img src="<?php echo base_url('assets/img/invoice_template2.png'); ?>" style="width: 300px;height:500px;">
</label>

<label class="button"> 
  <input type="radio" name="test" value="template3" class="check_template" <?php if($checked_invoice['invoiceTemplate_setting'] == 'template3'){ echo 'checked'; } ?>>
  <img src="<?php echo base_url('assets/img/invoice_template3.png'); ?>" style="width: 300px;height:500px;">
</label>

<!--<label class="button">
  <input type="radio" name="test" value="template4" class="check_template" <?php if($checked_invoice['invoiceTemplate_setting'] == 'template4'){ echo 'checked'; } ?>>
  <img src="<?php echo base_url('assets/img/invoice_template4.png'); ?>" style="width: 300px;height:500px;">
</label>
<label class="button">
  <input type="radio" name="test" value="big">
  <img src="http://placehold.it/40x60/b0f/fff&text=C" style="width: 500px;height:500px;">
</label>-->


        
</div>
</div>
</div>
</body>


<?php $this->load->view('common_footer');?>
<script>
 $('.check_template').click(function(){
	 //alert("checked_value");
    var checked_value = $(this).val();
	//alert(checked_value);										
     $.ajax({
      url:"<?= site_url('setting_invoice/change_invoiceTemplate')?>",
      method:"POST",
      data:{checked_value:checked_value},
      success:function(data)
      {
		  if(data == 200){
		     alert('Invoice Template Change Sucessfully!'); 
		  }else{
			 alert('Some Error Occureif!'); 
		  }
	  }
	 });
 });
</script>