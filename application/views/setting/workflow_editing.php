<?php $this->load->view('common_navbar');?>
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.signature.css">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/jquery.betterdropdown.css">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<style>
  .card .card-body .phases h2 {
    background: #ccc;
    display: block;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    text-align: center;
    margin-bottom: 0;
    margin: 0 auto;
    padding: 10px;
}
.card .card-body .phases h2:after {
    content: '';
    height: 100%;
    width: 1px;
    background: #ccc;
    display: block;
    position: absolute;
    left: 50%;
}
  .card .card-body .right-forms .form-group span.weekdays {
    cursor: pointer;
    border: 1px solid #ccc;
    padding: 0px 10px;
}
.card .card-body .right-forms .info-section {
    border: 1px solid #284255;
    padding: 15px 5px;
    margin-bottom: 20px;
    border-left: 6px solid;
    position: relative;
}
.card .card-body .right-forms .info-section h4 {
    font-size: 18px;
    color: #3c78ff;
}
.card .card-body .right-forms .info-section h4 i {
    margin-right: 5px;
    vertical-align: middle;
}
.card .card-body .right-forms .info-section p {
    margin: 0;
    font-size: 14px;
    margin-top: 10px;
}
.card .card-body .right-forms .info-section button.close {
    top: 10px;
    position: absolute;
    right: 10px;
}
#exampleModalScrollable.modal-dialog {
    position: fixed;
    margin: auto;
    width: 500px;
    height: 100%;
    right: 0px;
}
#exampleModalScrollable.modal-content {
    height: 100%;
}
.modal-dialog .modal-content .modal-body form .info-section{
    border: 1px solid #284255;
    padding: 15px 5px;
    margin-bottom: 20px;
    border-left: 6px solid;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">New Standard Workflow</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url()." home "; ?>">Home</a>
            </li>
            <li class="breadcrumb-item active">New Standard Workflow</li>
          </ol>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Main row -->
      <!-- Map card -->
      <div class="card org_div">
        <!-- /.card-header -->
        <div class="card-body">
          <form id="workflow_form" method="post">
		  
		  <input type="hidden"  name="workflow_id"  id="workflow_id" value="<?php if(!empty($this->uri->segment(3))){ echo $this->uri->segment(3); }?>">
		  
            <div class="row">
              <div class="col-md-1">
                <div class="phases">
                  <h2>1</h2> 
                </div>
              </div>
              <div class="col-md-11">
                <div class="right-forms">
                  <h3>Basic Information</h3>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Workflow Name<span style="color: #f76c6c;">*</span></label>
                      </div>
                      <div class="col-md-5">
                        <input type="text" name="workflow_name" id="workflow_name" class="form-control" value="<?php if(isset($record['workflow_name'])){ echo $record['workflow_name']; }  ?>">
						<span id="workflow_name_error"></span>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Target Module</label>
                      </div>
                      <div class="col-md-5">
					  <?php if(isset($record['module'])){ ?>
					    <input type="text" name="trgt_module" id="trgt_module "  class="form-control" value="<?php if(isset($record['module'])){ echo $record['module']; }  ?>" readonly>  
					  <?php }else{ ?>
                        <select class="form-control" name="trgt_module" id="trgt_module">
                          <option value="Leads">Leads</option>
						  <option value="Contacts">Contacts</option>
						  <option value="Organizations">Organizations</option>
						  <option value="Meetings">Meetings</option>
						  <option value="Tasks">Tasks</option>
						  <option value="Calls">Calls</option>
						  <option value="Opportunity">Opportunity</option>
						  <option value="Quotation">Quotation</option>
						  <option value="Salesorders">Salesorders</option>
						  <option value="Purchaseorders">Purchaseorders</option>
						  <option value="Vendors">Vendors</option>
						  <option value="Proform invoice">Proform invoice</option>
                        </select>
					  <?php } ?>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Status</label>
                      </div>
                      <div class="col-md-5">
                        <label>
                          <input type="radio"  name="workflow_status" id="workflow_status" <?php if(isset($record['status'])){ if($record['status']==1){ echo 'checked'; } }else{ echo 'checked'; } ?> value="1"> Active</label>
                        <label>
                          <input type="radio"  name="workflow_status" id="workflow_status" <?php if(isset($record['status'])){ if($record['status']==0){ echo 'checked'; } } ?> value="0"> InActive</label>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Description</label>
                      </div>
                      <div class="col-md-5">
                        <textarea class="form-control" rows="2" name="workflow_desc" id="workflow_desc" placeholder=""><?php if(isset($record['description'])){ echo $record['description']; }  ?></textarea>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-md-1">
                <div class="phases">
                  <h2>2</h2> 
                </div>
              </div>
              <div class="col-md-11">
                <div class="right-forms">
                  <h3>Workflow Trigger</h3>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Trigger Workflow On</label>
                      </div>
                      <div class="col-md-5">
                        <label><input type="radio" name="workflow_trigger" id="workflow_creation" <?php if(isset($record['trigger_workflow_on'])){ if($record['trigger_workflow_on']==1){ echo 'checked'; } } ?> value="1"> <text class="trigg_workflow">Leads</text> creation</label><br>
                        <label><input type="radio" name="workflow_trigger" id="workflow_updated" <?php if(isset($record['trigger_workflow_on'])){ if($record['trigger_workflow_on']==2){ echo 'checked'; } }else{ echo 'checked'; } ?>  value="2"  > <text class="trigg_workflow">Leads</text> updated (Includes Creation)</label><br>
                        <!--<label><input type="radio" name="workflow_trigger" id="workflow_tinterval" value="3"> Time Interval</label>-->
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <div class="form-group showHideDiv">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Recurrence</label>
                      </div>
                      <div class="col-md-5">
                        <label><input type="radio" name="workflow_recurrence"  value="Only first time conditions are met" <?php if(isset($record['Recurrence'])){ if($record['Recurrence']=='Only first time conditions are met'){ echo 'checked'; } } ?> > Only first time conditions are met</label><br>
                        <label><input type="radio" name="workflow_recurrence"  value="Every time conditions are met" <?php if(isset($record['Recurrence'])){ if($record['Recurrence']=='Every time conditions are met'){ echo 'checked'; } }else{ echo 'checked'; } ?>> Every time conditions are met</label>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <!--<div class="form-group showDiv" style="display:none;">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Frequency</label>
                      </div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <label>Run Workflow</label>
                          </div>
                          <div class="col-md-3">
                            <select class="form-control">
                              <option value="Hourly">Hourly</option>
                              <option value="Daily">Daily</option>
                              <option value="Weekly">Weekly</option>
                              <option value="specfic_date">On Specific Date</option>
                              <option value="monthbydate">Month By Date</option>
                              <option value="Yearly">Yearly</option>
                            </select>
                          </div>
                          <div class="col-md-7">
                            <p><i class="fa fa-info-circle"></i>You have used 0 out of 3 available Hourly workflows</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <div class="row">
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <label>On these days*</label>
                          </div>
                          <div class="col-md-10">
                            <span class="weekdays">Sunday</span>
                            <span class="weekdays">Monday</span>
                            <span class="weekdays">Tuesday</span>
                            <span class="weekdays">Wednesday</span>
                            <span class="weekdays">Thursday</span>
                            <span class="weekdays">Friday</span>
                            <span class="weekdays">Saturday</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <div class="row">
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <label>Choose Date*</label>
                          </div>
                          <div class="col-md-3">
                            <input type="date" name="" class="form-control">
                          </div>
                          <div class="col-md-7">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <div class="row">
                      <div class="col-md-3">
                      </div>
                      <div class="col-md-9">
                        <div class="row">
                          <div class="col-md-2">
                            <label>At Time *</label>
                          </div>
                          <div class="col-md-3">
                            <input type="time" name="" class="form-control">
                          </div>
                          <div class="col-md-7">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>-->
                </div>
              </div>
            </div>

           <!--<div class="row mt-5">
              <div class="col-md-1">
                <div class="phases">
                  <h2>3</h2> 
                </div>
              </div>
              <div class="col-md-11">
                <div class="right-forms">
                  <h3>Entry Criteria</h3>
                  <div class="info-section hideshowDiv" style="display:close;">
                    <h4><i class="fa fa-info-circle"></i>Info</h4>
                    <button type="button" class="close close_info">&times;</button>
                    <p>Workflows will execute on Closed records as well. You can add conditions to exclude closed records.</p>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>All Conditions (All conditions must be met)</label>
                      </div>
                      <div class="col-md-5">
                        <button type="button" id="all_condition" class="btn btn-info btn-sm">+ Add Condition</button>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
                  <span id="show_more_fields"></span>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Any Conditions (At least one of the conditions must be met)</label>
                      </div>
                      <div class="col-md-5">
                        <button type="button" id="any_condition" class="btn btn-info btn-sm">+ Add Condition</button>
                      </div>
                      <div class="col-md-4"></div>
                    </div>
                  </div>
				  <span id="show_moreany_fields"></span>
                </div>
              </div>
            </div>-->
            <div class="card org_div text-center">
            <!-- /.card-header -->
              <div class="card-body">
                <button type="button" onclick="cancel_workflow()" class="btn btn-primary">Cancel</button>
                <button type="button" id="workflowSave" class="btn btn-info">Save</button>
              </div>
            <!-- /.card-body -->
            </div>
          </form>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.Main content -->
</div>
<!-- /.content-wrapper -->
<!-- ./footer -->

<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Set Value</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <div class="row">
                <div class="col-md-3">
                  <select class="form-control">
                    <option>Raw text</option>
                    <option>Field</option>
                    <option>Expression</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <select class="form-control">
                    <option disabled="" selected="">Use Field</option>
                    <option>Deal Name</option>
                    <option>Amount</option>
                    <option>Organization name</option>
                    <option>Contact name</option>
                    <option>Expected Close date</option>
                    <option>Pipeline</option>
                    <option>Sales Stage</option>
                  </select>
                </div>
                <div class="col-md-5">
                  <select class="form-control">
                    <option disabled="" selected="">Use Function</option>
                    <option>concat</option>
                    <option>time_diffdays(a,b)</option>
                    <option>time_diffdays(a)</option>
                    <option>time_diff(a,b)</option>
                    <option>time_diff(a)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-12">
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="info-section">
              <h4><i class="fa fa-info-circle"></i>Field</h4>
              <p>annual_revenue
              <br>notify_owner</p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info">Save</button>  
        </div>
      </div>
    </div>
  </div>
<?php $this->load->view('footer');?>

</div>
<!-- ./footer -->
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<script>
function gloablehideDiv(addCL,deschd){
    $("."+addCL).show();
    $("."+deschd).hide();
       
}

$('#workflow_tinterval').click(function() {
  gloablehideDiv('showDiv','showHideDiv');
 
});
$('#workflow_creation,#workflow_updated').click(function() {
  gloablehideDiv('showHideDiv','showDiv');	
 
});
$('#workflow_creation').click(function() {
  //gloablehideDiv('showHideDiv','showDiv');	
 $(".showHideDiv").hide();
 $('[name="workflow_recurrence"]').val(function() {
    return this.defaultValue;
  });
 });
 <?php if(isset($record['trigger_workflow_on'])){ if($record['trigger_workflow_on']==1){  ?>
  $('#workflow_creation').click();
 <?php } } ?>
 

$('#workflow_updated').click(function() {	
 $(".showHideDiv").show();
});

$('.close_info').click(function() {
	$(".hideshowDiv").hide();

});
<?php if(isset($record['module'])){  ?>
    var target_module = '<?=$record["module"] ?>';
   $('.trigg_workflow').text(target_module);
<?php } ?>
$('#trgt_module').change(function() {
	var target_module =  $('#trgt_module').val();
    $('.trigg_workflow').text(target_module);
 
});

function cancel_workflow(){
	window.location.href='<?=base_url("workflows") ?> ';
}
</script>
<script>
var urlInvce='';
var woflowId=$('#workflow_id').val();
if(woflowId=="" && woflowId!==undefined){
	urlInvce="<?= base_url('workflows/add_workflowDetails')?>";
}else{
	urlInvce="<?= base_url('workflows/update_workflowDetails')?>";
}

   $('#workflowSave').click(function(e) {
        e.preventDefault();
		$('#workflowSave').text('saving...'); //change button text
        $('#workflowSave').attr('disabled',true); //set button disable
			
		//console.log($('#form_invoice').serialize());
		var data = new FormData($("#workflow_form")[0]);
		if(checkValidation_workflow()==true){
			
        $.ajax({
            url : urlInvce,
            type: "POST",
            data: data,
            dataType: "JSON",
			processData: false,
            contentType: false,
            success: function(data)
            { 
			 //console.log(data);
			    $('#workflowSave').text('Save & Continue'); 
                $('#workflowSave').attr('disabled',false);
				console.log(data); 
              if(data.status) //if success close modal and reload ajax table
              {
                //alert("Insert sucessfuly"); 
				$('#workflowSave').text('Save & Continue'); 
                $('#workflowSave').attr('disabled',false);
				if(woflowId=="" && woflowId!==undefined){
					$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Workflow sucessfuly added.');
				}else{
					$("#common_popupmsg").html('<i class="far fa-check-circle" style="color: #60b963;"></i><br>Workflow sucessfuly updated.');
				}
				
				$("#alert_popup").modal('show');
				setTimeout(function(){ $("#alert_popup").modal('hide'); window.location.href = '<?= base_url("workflows")?>';  },2000);
				
				//window.location.reload();
              }
			  
			  
			  if(data.st==202)
			  {
				$("#workflow_name_error").html(data.workflow_name);				
				$('#workflowSave').text('Save & Continue'); 
                $('#workflowSave').attr('disabled',false);
			  }
			  else if(data.st==200)
			  {
				$("#workflow_name_error").html('');
				
				
			  }
			}
		});
		}else{
            $('#workflowSave').text('Save & Continue'); 
            $('#workflowSave').attr('disabled',false);
        }
	});
	
	
	/**** check validation for adding invoice****/
	function changeClr(idinpt){
	  $('#'+idinpt).css('border-color','red');
	  $('#'+idinpt).focus();
	  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },5000);
	}
	function checkValidation_workflow(){
		
	  var workflow_name=$('#workflow_name').val();
	  

		if(workflow_name=="" || workflow_name===undefined ){
		  changeClr('workflow_name');
		  $('#workflow_name_error').html('<span style="color:red;">Workflow name is required</span>'); 		 
		  return false;
		
		}else{
		   return true;
		} 
	}
	
	$("#add_new_line input").keypress(function(){
		$(this).css('border-color','');
	});
	
	$('#workflow_name').keypress(function(){	 
	   $('#workflow_name_error').html('');
	  
	});
	
	$('.form-control').keypress(function(){
	  $(this).css('border-color','')
	});
	$('.form-control').change(function(){
	  $(this).css('border-color','')
	});

</script>
<script>

function common_appendRow(i){
	var markup = '<div id="row'+i+'"> <div class="form-group"> <div class="row"><div class="col-md-3"></div><div class="col-md-9"> <div class="row"><div class="col-md-4"><select class="form-control"><option>Deal Name</option><option>Amount</option><option>Organization Name</option><option>Contact Name</option><option>Expected Close Date</option><option>Pipeline</option></select></div>'+
    '<div class="col-md-3"><select class="form-control"><option>is</option><option>is not</option> <option>contains</option><option>does not contain</option><option>starts with</option><option>ends with</option></select></div><div class="col-md-4"> <a href="#" data-toggle="modal" data-target="#exampleModalScrollable" id="btn1"><input type="text" name="" class="form-control"></a> </div>'+
    '<div class="col-md-1"><a href="javascript:void(0);" class="remove_addmore" id="'+i+'"><i class="far fa-trash-alt"></i></a></div></div></div></div></div></div>';
	return markup;
}

 var i = 1;
    $("#all_condition").click(function()
    {
		 i++;
      var markup = common_appendRow(i);
      $("#show_more_fields").append(markup);
    });
    // Find and remove selected table rows
	$("#show_more_fields").on('click','.remove_addmore',function(){
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
    });
	
	var i = 1;
    $("#any_condition").click(function()
    {
		 i++;
      var markup = common_appendRow(i);
      $("#show_moreany_fields").append(markup);
    });
    // Find and remove selected table rows
	$("#show_moreany_fields").on('click','.remove_addmore',function(){
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
    });
</script>