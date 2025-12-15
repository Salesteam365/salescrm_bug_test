<?php $this->load->view('superadmin/common_navbar'); ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Partner Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('superadmin/home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Admin Details</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          
          <div class="col-lg-4"></div>
          <div class="col-lg-12">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
				  <!--<button class="btn btn-info btn-sm" style="width:135px;" onclick="import_excel()">Import&nbsp;Excel</button
                  <button class="btn btn-info btn-sm" onclick="add_form()">Add New</button>-->
				 <button class="btn btn-info btn-sm"> <a href="<?php echo base_url('login'); ?>" style="color:white;"><b>User</b></a></button>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  <?php foreach($partner as $admin){ ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
          
              <div class="card-body">
                 <div class="modal-body form">
                      <form id="view" class="row" action="#">
                        <div class="col-sm-12">
                          <h5 class="text-primary" id="org_name"></h5>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Company&nbsp;Name:</b>
            			  <h6 class="text-primary" ><?=$admin['Company_name'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Company Website:</b>
                          <h6 class="text-primary"><?=$admin['Official_website'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Company&nbsp;Owner:</b>
                          <h6 class="text-primary" ><?=$admin['First_name']." ".$admin['Last_name'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Email:</b>
                          <h6 class="text-primary"><?=$admin['Email_first'] ?></h6>
                        </div>
                         <div class="col-sm-6">
                          <b class="text-secondary">Secondary Email:</b>
                          <h6 class="text-primary"><?=$admin['Email_second'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Mobile:</b>
                          <h6 class="text-primary" id="mobile"><?=$admin['Mobile_no'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Telephone:</b>
                          <h6 class="text-primary"><?=$admin['Telephone_no'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Fax:</b>
                          <h6 class="text-primary"><?=$admin['Fax'] ?></h6>
                        </div>
                        
                <?php
				   $ci =&get_instance();
                   $ci->load->model(array('superadmin/home_model'));
				   $country = $ci->home_model->get_data($admin['Country'],'countries');
				   $state   = $ci->home_model->get_data($admin['State'],'states'); 
				   $city    = $ci->home_model->get_data($admin['City'],'cities'); 
				?>
                        
                        
                        <div class="col-sm-6">
                          <b class="text-secondary">Country:</b>
                          <h6 class="text-primary"><?=$country['name']; ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">State:</b>
                          <h6 class="text-primary"><?=$state['name']; ?></h6>
                        </div>
                       
                        <div class="col-sm-6">
                          <b class="text-secondary">City:</b>
                          <h6 class="text-primary"><?=$city['name']; ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Zipcode:</b>
                          <h6 class="text-primary"><?=$admin['Zip_code'] ?></h6>
                        </div>
                      
                        <div class="col-sm-12">
                          <b class="text-secondary">Company&nbsp;Address:</b>
                          <h6 class="text-primary"><?=$admin['Address'] ?></h6>
                        </div>
                        
                         <div class="col-sm-12">
                           <h5 class="text-primary">Business Activity:-</h5>
                          <hr>
                         </div>
                        
                        <div class="col-sm-6">
                          <b class="text-secondary">Main Business :</b>
                          <h6 class="text-primary"><?=$admin['Main_business'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">GST IN :</b>
                          <h6 class="text-primary"><?=$admin['GST_id'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Customer Structure :</b>
                          <h6 class="text-primary"><?=$admin['Customer_structure'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Marketing Channel :</b>
                          <h6 class="text-primary"><?=$admin['Marketing_channel'] ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">Number of Employees :</b>
                          <h6 class="text-primary"><?=$admin['Numberof_empl'] ?> Employee</h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">How to know user about Team365:</b>
                          <h6 class="text-primary"><?=$admin['Team365']; ?></h6>
                        </div>
                        
                        <div class="col-sm-6">
                          <b class="text-secondary">Message:</b><h6 class="text-primary"><?=$admin['Messages']; ?></h6>
                        </div>
                        
            			 <div class="col-sm-6">
                          <b class="text-secondary">Register Date:</b>
                          <h6 class="text-primary"><?=date('d M Y h:i a',strtotime($admin['Currentdate'])); ?></h6>
                        </div>
                        <div class="col-sm-6">
                          <b class="text-secondary">IP Address:</b>
                          <h6 class="text-primary"><?=$admin['IP']; ?></h6>
                        </div>
            			<div class="col-sm-12">
                          <b class="text-secondary">Partner Status:</b>
                          <h6 class="text-primary">
                            <?php if($admin['Status']==0){ ?>
                                <i class="fas fa-exclamation-circle" style="color: #f17e75;"></i>
                                <b style="color: #f78383;">Not yet a partner, Request Pending. </b>
                            <?php }else{ 
                                echo '<i class="far fa-check-circle" style="color: #87c387;"></i> Request Confirmed, It is our partner';
                            } ?></h6>
                        </div>
                        <?php if($admin['Status']==0){ ?>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#tomakePartner" >
                              Click here to make partner.</button>
                        </div>
                        <?php } ?>
                        
                      </form>
                    </div>
              </div>
              
            </div>
      </div>
    </section>
    
    
    <div class="modal fade show" id="tomakePartner" role="dialog" aria-modal="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="organization_add_edits">Login details for partner</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
              <form id="form" class="row" action="#">
                  <div class="col-sm-12"  id="putMsg" style="padding-bottom: 12px;">
                      
                  </div>
                <div class="col-sm-12">
                    <input type="hidden" name="prtnrid" value="<?=$admin['id']; ?>" >
                    <input type="hidden" name="comp_name" value="<?=$admin['Company_name']; ?>" >
                    <input type="hidden" name="country" value="<?=$country['name']; ?>" >
                    <input type="hidden" name="state" value="<?=$state['name']; ?>" >
                    <input type="hidden" name="city" value="<?=$city['name']; ?>" >
                    
                  <h5 class="text-primary" id="org_name"><?=$admin['Company_name'] ?></h5>
                </div>
                <div class="col-sm-12">
                  <b class="text-secondary">Username/Emailid:</b>
    			  <input type="text" class="form-control" value="<?=$admin['Email_first']; ?>" >
                </div>
                <div class="col-sm-12">
                    <b class="text-secondary">Password</b>
                    <input type="text" class="form-control" name="password" id="password">
                </div>
                
                <div class="col-sm-5" style="padding:15px 10px;"><i class="fas fa-key"></i>&nbsp;&nbsp;<label onClick="randPass(5,3);">Generate Password</label></div>
                 <div class="col-sm-7" style="padding:15px 10px;">
                    <button type="button" onClick="activatePartner()" id="btnSave" class="btn btn-info btn-sm" >
                             Activate</button>
                </div>
                
              </form>
            </div>
        </div>
      </div>
    </div>
<?php } ?>
  </div>
<?php $this->load->view('superadmin/common_footer');?>
<script>
function activatePartner(){
   $("#btnSave").css('background','#067bf98c');
   $("#btnSave").attr('disabled',true);
   $("#btnSave").html('Activating..');
    $.ajax({
         url: "<?= base_url(); ?>superadmin/partner/activate_partner",
         method: "POST",
         data: $('#form').serialize(),
		 dataType: "json", 
         success: function(data){
             console.log(data)
             if(data.msg_succ){
                $("#putMsg").html(data.msg_succ);
                setTimeout(function(){ 
                    $('#tomakePartner').modal('hide');
                    $("#btnSave").css('background','');
                    $("#btnSave").attr('disabled',false);
                    $("#btnSave").html('Activate');
                    $("#putMsg").html('');
                },3000);
             }else{
                $("#putMsg").html(data.msg); 
                $("#btnSave").css('background','');
                $("#btnSave").attr('disabled',false);
                $("#btnSave").html('Activate');
                setTimeout(function(){  $("#putMsg").html('');  },3000);
             }
         }
        });
};




    function randPass(lettersLength,numbersLength) {
        var j, x, i;
        var result           = '';
        var letters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        var numbers       = '0123456789';
        for (i = 0; i < lettersLength; i++ ) {
            result += letters.charAt(Math.floor(Math.random() * letters.length));
        }
        for (i = 0; i < numbersLength; i++ ) {
            result += numbers.charAt(Math.floor(Math.random() * numbers.length));
        }
        result = result.split("");
        for (i = result.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = result[i];
            result[i] = result[j];
            result[j] = x;
        }
        result = result.join("");
        $("#password").val(result);
    }
randPass(5,3);
</script>
