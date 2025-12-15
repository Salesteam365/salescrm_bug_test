<?php $this->load->view('common_navbar');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">User Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
     .treeSpan{
        background: #c5c7c742;
        padding: 4px;
        border: 1px solid #18a2b836;
        border-radius: 4px;
     }
     #dt-multi-checkboxss thead tr th{
   background:rgba(35, 0, 140, 0.8);
  

}
#dt-multi-checkboxss  thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   
  

}


#dt-multi-checkboxss tbody tr td {
  background-color: #fff; /* Set background color */
  font-size: 14px; /* Increase font size */
  font-family: system-ui;
  font-weight: 651;
  color:rgba(0,0,0,0.7);
  padding-top:16px;
  padding-bottom:16px;
   /* Change font family */
  /* Add any other styles as needed */
}

 button.btnstopcorner{
    
    border-radius: 4px;
    background: #f2f3f4;
    color: #ccc;
    font-weight:600;
    padding:7px;
  }

  /* div.refresh_button button.btnstopcorner:hover {
    background:lightgrey;
    border: 1px solid #ccc; 
  } */
    
   button.btnstop{
    border: 1px solid #ccc; 
    border-radius: 4px;
    background: #845ADF;
    color: #fff;
    font-weight:600;
    padding:7px;
  }

   button.btnstop:hover{
    
    color:#fff!important;
  }

    </style>
	
	<?php
	
	 $CI = & get_instance();
	 $CI->load->model('roles_model');
	?>
	
	
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->

        <!-- /.row (main row) -->
        <div class="row">
          <section class="col-lg-12 connectedSortable licence_table">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#home">Tree View</a></li>
              <li><a data-toggle="tab" href="#menu1">Table View</a></li>
            </ul>
            <div class="card">
              <div class="card-body">
                <div class="tab-content">
                     <div class="row">
						<div class="col-sm-12 form-group text-right">
						    
							<button class="btnstopcorner" type="button" onclick="reload_table()"><i class="fas fa-redo-alt"></i></button>								 
							<button class="btnstop" type="button"><a href="#" style="color:white;">Create Role</a></button>
						</div>
                     </div>
                    
                    
                  <div id="home" class="tab-pane fade in active show">
                    <div class="container-fluid">
                      <ul id="tree1">
                           <li> <?=$this->session->userdata('company_name');?>  <i class="fas fa-sitemap"></i>
                               <ul>
                        <?php 
                        $dataTree= $this->roles_model->get_allroles_tree(0);
                        foreach($dataTree as $rowView){
                         if(count($dataTree)>0){   
                        ?>  
                          <li> <span class="treeSpan">
                              <?=$rowView['role_name'];?>
                              <button class="btnid" data-id="<?=$rowView['id'];?>"><i class="fas fa-pencil-alt"></i></button>
                              <button class="addRol" data-pid="<?=$rowView['id'];?>"><i class="far fa-plus-square"></i></button> </span>
                              <?php getTreeView($rowView['id']); ?>
                              
                          </li>
                         <?php }  } ?> 
                          </ul>
                         </li>
                      </ul>
                      
                    </div>
                  </div>
                  
                  <div id="menu1" class="tab-pane fade">
                    <table id="dt-multi-checkboxss" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>
						<?php if($this->session->userdata('delete_so')=='1'):?>
                        <?php endif; ?>                           
                            <th class="th-sm">Role Name</th>
                            <th class="th-sm">Report To</th>                            
                            <th class="th-sm">Status</th>
							<th class="th-sm">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody> 
                     <?php 
					 foreach($roles as $role) { 
					   
						if($role['parent_role_id']==0){
						$reportto = "";	
						}else{
						$parentroles = $CI->roles_model->get_roleby_id($role['parent_role_id']);
						$reportto = $parentroles['role_name'];
						}
					 ?>
					 <tr>
           <td>
    <div style="display: flex; align-items: center;">
        <img src="<?php echo base_url('');?>application/views/assets/images/faces/4.jpg" alt="img" class="rounded-circle mr-2" style="width: 1.75rem; height: 1.75rem;">
        <span><?= $role['role_name']; ?></span>
    </div>
</td>



						<td><?=$reportto; ?></td>
						<?php if($role['status']==1){ ?>
						<td>Active</td>	
                        <?php }else{ ?>	
						<td>Non-active</td>
                        <?php } ?>							
						<td><a href="#" class="btnid" data-id="<?=$role['id'];?>" >Edit</a> | <a href="#" class="delete" data-id="<?=$role['id'];?>" >Delete</a></td>
					 </tr>
                    <?php } ?>					 
                    </tbody>
                </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
  
  
  <!-- Add data modal -->
          <div class="modal fade show" id="target_popup" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="organization_add_edit">Add Role</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body form">
                    <form action="<?php echo base_url("roles/add_roleDetails"); ?>" method="post">
                        <input type="hidden" name="methodSaving" id="methodSaving" value=='save'>
                        <input type="hidden" name="updateId" id="updateId" value=='0'>
        				<div class="row m-0">
        					<div class="col-sm-4 form-group">
        						<label>Role Name<span style="color: #f76c6c;">*</span></label>
        					</div>
        					<div class="col-sm-8 form-group">
        						<input type="text" placeholder=" Enter role name" name="role_name" id="role_name" class="form-control">
        					</div>
        				</div>
        				<div class="row m-0">
        					<div class="col-sm-4 form-group">
        						<label>Reports To</label>
        					</div>
        					<div class="col-sm-8 form-group">
        						<select class="form-control" name="parent_role" id="parent_role">
        							<option>Select parent role</option>
        							<option value="0">parent role</option>
        							<?php foreach($roles as $role) { ?>
        							<option value="<?=$role['id'] ?>" ><?=$role['role_name'] ?></option>
        							<?php } ?>
        						</select>
        					</div>
        				</div>
				    <div class="col-sm-12 form-group text-center">
				        <button class="btn btn-info" id="btnsaveData" type="submit">Save</button>
				    </div>
			    </form>
                  </div>
              </div>
            </div>
          </div>
          <!-- Add data modal -->
          
          <!-- Add data modal -->
          <div class="modal fade show" id="delete_popup" role="dialog" aria-modal="true">
            <div class="modal-dialog modal-md">
              <div class="modal-content">
                  <div class="modal-header">
                      <h3 class="modal-title" id="organization_add_edit">Delete Data</h3>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body form">
                    <form action="<?php echo base_url("roles/add_roleDetails"); ?>" method="post">
                        <input type="hidden" name="methodSaving" id="methodSaving" value="delete">
                        <input type="hidden" name="deleteId" id="deleteId" value=='0'>
        				<div class="row m-0">
        					<div class="col-sm-12 form-group">
        						<label>Are You sure, You want to delete it? </label>
        					</div>
        				</div>
        				
				    <div class="col-sm-12 form-group text-center">
				        <button class="btn btn-primary"  data-dismiss="modal" aria-label="Close" id="CancelData" type="button">No</button>
				        <button class="btn btn-danger" id="btnsaveData" style="margin-left: 10%;" type="submit">Yes</button>
				    </div>
			    </form>
                  </div>
              </div>
            </div>
          </div>
          <!-- Add data modal -->
  
  
  

 <?php $this->load->view('footer');?>
</div>
<!-- ./wrapper -->

<!-- common footer include -->
<?php $this->load->view('common_footer');?>
 <script>
 
 
 
  $(".delete").click(function(){ 
     var dataid=$(this).data('id');
     $("#deleteId").val(dataid);
     $("#delete_popup").modal('show');
 })
 
 $(".btnid").click(function(){ 
     var dataid=$(this).data('id');
     $("#updateId").val(dataid);
     $("#methodSaving").val('update');
     $.ajax({
        url:"<?php echo base_url(); ?>roles/getrolesbyId",
        method:"POST",
        dataType:'json',
        data:{dataid:dataid},
        success:function(data)
        {
            console.log(data.id);
            $("#role_name").val(data.role_name);
            $("#parent_role").val(data.parent_role_id);
            $("#target_popup").modal('show'); 
            
       
        }
    });
 })
 
 $(".addRol, .add_button").click(function(){ 
     
     $("#updateId").val('0');
     $("#methodSaving").val('save');
     
     var dataid=$(this).data('pid');
     if(dataid){
        $("#parent_role").val(dataid);
     }else{
        $("#parent_role").val(0);
       
     }
      $("#role_name").val('');
     $("#target_popup").modal('show'); 
     return false; 
 })
 
 
 $("#btnsaveData").click(function(){  
     var role_name=$("#role_name").val();
     if(role_name==""){
         $("#role_name").css('border-color','red');
         return false;
     }else{
         return true;
     }
     
     
 })
 
 
      $.fn.extend({
    treed: function (o) {
      
      var openedClass = 'fas fa-minus-square';
      var closedClass = 'far fa-plus-square';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

      $('#tree1').treed();
      
      
      $(".branch").click();
      
    </script>

