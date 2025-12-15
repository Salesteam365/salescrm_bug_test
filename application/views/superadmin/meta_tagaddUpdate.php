<?php $this->load->view('superadmin/common_navbar'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">  
         <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?php if($meta_details){ echo 'Update';}else{ echo 'Add'; }  ?> Meta Tag</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li> 
               <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/meta_tag'); ?>">Meta Tag</a></li>			   
			   <li class="breadcrumb-item active">meta_addUpdate</li>
              </ol>
          </div><!-- /.col -->
        </div><br><br><br>
 <div class="col-lg-12">
		     <?php if($this->session->userdata('success_msg')){ ?>
				<b id="hideDiv" style="color:green"><?php echo $this->session->userdata('success_msg'); ?> </b> 
			<?php }elseif($this->session->userdata('error_msg')){ ?>
			<span id="hideDiv" style="color:red"><?php echo $this->session->userdata('error_msg'); ?> </span>
			<?php } ?>
		  </div>
 <div class="col-sm-12">
		<h2>Meta Tag Form</h2>
		<div style="color:red">
            <?php //echo validation_errors(); ?>
        </div>  
  <form action="<?php if($meta_details){ echo base_url('superadmin/meta_tag/meta_update/'.$meta_details["id"]);}else{ echo base_url('superadmin/meta_tag/meta_add'); }?>" method="post">
  <div class="form-group">
      <label for="page_name">Page Title:</label>
	  <select name="page_name" id="page_name" class="form-control">
	  <option value="">Select Page</option>
	  <option value="organizations" <?php if($meta_details){  if($meta_details['page_title'] == 'organizations'){ echo 'selected'; } } ?>>organizations</option>
	  <option value="contacts" <?php if($meta_details){ if($meta_details['page_title'] == 'contacts'){ echo 'selected'; } }?>>contacts</option>
	  <option value="leads" <?php if($meta_details){ if($meta_details['page_title'] == 'leads'){ echo 'selected'; } }?>>leads</option>
	  <option value="opportunities" <?php if($meta_details){ if($meta_details['page_title'] == 'opportunities'){ echo 'selected'; } } ?>>opportunities</option>
	  <option value="quotation" <?php if($meta_details){ if($meta_details['page_title'] == 'quotation'){ echo 'selected'; } }?>>quotation</option>
	  <option value="salesorders" <?php if($meta_details){ if($meta_details['page_title'] == 'salesorders'){ echo 'selected'; }  } ?>>salesorders</option>
	  <option value="vendors" <?php if($meta_details){ if($meta_details['page_title'] == 'vendors'){ echo 'selected'; } }?>>vendors</option>
	  <option value="purchaseorders" <?php if($meta_details){ if($meta_details['page_title'] == 'purchaseorders'){ echo 'selected'; } }?>>purchaseorders</option>
	  </select>
      <!--<input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" value="<?=$meta_details['meta_title']; ?>">-->
	  <span style="color:red"><?php echo form_error('page_name'); ?></span>
    </div>
    <div class="form-group">
      <label for="meta_title">Meta Title:</label>
      <input type="text" class="form-control" id="meta_title" placeholder="Enter Meta Title" name="meta_title" value="<?php if($meta_details){ echo $meta_details['meta_title']; }else{ echo set_value('meta_title');} ?>">
	  <span style="color:red"><?php echo form_error('meta_title'); ?></span>
    </div>
    <div class="form-group">
      <label for="meta_keyword">Meta Keyword:</label>
      <input type="text" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" name="meta_keyword" value="<?php if($meta_details){ echo $meta_details['meta_keyword']; }else{ echo set_value('meta_keyword');} ?>">
	  <span style="color:red"><?php echo form_error('meta_keyword'); ?>
    </div>
	<div class="form-group">
      <label for="meta_desc">Meta Description:</label>
	  <textarea type="text" class="form-control" id="meta_desc" placeholder="Enter Meta Description" name="meta_desc"><?php if($meta_details){ echo $meta_details['meta_description']; }else{ echo set_value('meta_desc');} ?></textarea> 
     <span style="color:red"><?php echo form_error('meta_desc'); ?>
    </div>
    <!--<div class="checkbox">
      <label><input type="checkbox" name="remember"> Remember me</label>
    </div>-->
    <button type="submit" <?php if($meta_details){ ?>name="update"<?php }else{ ?>name="add" <?php } ?> class="btn btn-default"><?php if($meta_details){ echo 'Update'; }else{ echo 'Add'; } ?></button>
  </form>
            </div>
		</div>
     </div>
	
</div>
  
<?php $this->load->view('superadmin/common_footer');?>
<script>
   /* $("#btnSave").click(function(e)
    {
      e.preventDefault();
      //$('#btnSave').text('saving...'); //change button text
      //$('#btnSave').attr('disabled',true); //set button disable
      var url;
      if(save_method == 'add') {
          url = "<?= site_url('salesorders/create')?>";
      } else {
          url = "<?= site_url('salesorders/update')?>";
      }
     // alert(url);
      // ajax adding data to database
      var form=$("#form").get(0);
      var formData = new FormData(form);
      //FormData = $('#form').serialize();
    if(checkValidationSO()==true){
        
      $.ajax({
        url : <?= base_url('salesorders/update')?>,
        type: "POST",
        data: formData,
        dataType: "JSON",
        processData:false,
        contentType:false,
        cache:false,
       // async:false,
        success: function(data)
        {
            //console.log(data);
          if(data.status) //if success close modal and reload ajax table
          {
            
            reload_table();
          }
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
          if(data.st==202)
          {
            $("#quote_id_error").html(data.quote_id);
            $("#subject_error").html(data.subject);
            $("#contact_name_error").html(data.contact_name);
            
          }
          else if(data.st==200)
          {
            $("#quote_id_error").html('');
            $("#subject_error").html('');
            $("#contact_name_error").html('');
           
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error adding / update data');
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button enable
        }
      });
    }else{
          $('#btnSave').text('save'); 
          $('#btnSave').attr('disabled',false);
    }
    });*/
</script> 