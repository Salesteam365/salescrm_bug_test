<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<link rel="stylesheet" href="<?= base_url();?>assets/css/filter_multi_select.css" />
<style>
    .content-header {background: #fff;}
	.ModalRight {
		right: 0;
		position: fixed;
		margin: auto;
		width: 100%;
		height: 100%;
	}
.Modalht100 {
	height: 100%;
    overflow-y: auto;
	}
	
	.modal.left .modal-dialog,
	.modal.right .modal-dialog {
		-webkit-transform: translate3d(0%, 0, 0);
		    -ms-transform: translate3d(0%, 0, 0);
		     -o-transform: translate3d(0%, 0, 0);
		        transform: translate3d(0%, 0, 0);
	}

	


        
/*Right*/
	.modal.right.fade .modal-dialog {
		-webkit-transition: opacity 0.5s linear, right 0.5s ease-out;
		   -moz-transition: opacity 0.5s linear, right 0.5s ease-out;
		     -o-transition: opacity 0.5s linear, right 0.5s ease-out;
		        transition: opacity 0.5s linear, right 0.5s ease-out;
	}
	
	.modal.right.fade.in .modal-dialog {
		right: 0;
	}

body {
  margin: 0;
}



.activeItm {
	border-bottom: 4px solid #111 !important;
    font-weight: 600;
	background: #284255;
    color: #fff;
}

.btn-circle.btn-xl {
    width: 50px;
    height: 50px;
    padding: 10px 16px;
    border-radius: 35px;
    font-size: 24px;
    line-height: 1.33;
}

.btn-circle {
    width: 50px;
    height: 50px;
    padding: 6px 0px;
    border-radius: 30px;
    text-align: center;
    font-size: 12px;
    line-height: 1.42857;
}

.CursorPointer {
    Cursor:pointer;
}



/*-------------------*/



.block__item {
    margin-bottom: 20px;
}
.block__title {
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
    padding-left: 30px;
    cursor: pointer;
}

.block__title::before,
.block__title::after {
    content: "";
    width: 10px;
    height: 1px;
    background-color: #000;
    position: absolute;
    top: 8px;
    transition: all 0.3s ease 0s;
}

.block__title:before {
    transform: rotate(40deg);
    left: 0;
}
.block__title::after{
    transform: rotate(-40deg);
    left: 8px;
}

.block__title.active::before,
.block__title.active::after {
    background-color: red;
}

.block__title.active::before {
    transform: rotate(-40deg);
}

.block__title.active::after {
    transform: rotate(40deg);
}

.block__text {
    display: none;
    padding-top: 10px;
}



</style>
<!-- Content Wrapper. Contains page content -->
<?php $this->session->set_flashdata('orgid', $record['id']); ?>
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
		 <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
							<li class="list-group-item text-center"><a href="javascript:history.back()"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
							<li class="list-group-item text-center" onClick="shareEmail();"><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/email-open--v1.png"/></div>Email to customer</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons d-flex justify-content-end">
                        <ul class="list-group list-group-horizontal">
							
							<li class="list-group-item text-center"><a href="<?=base_url();?>organizations?up=<?=$record['id'];?>"><div><img src="https://img.icons8.com/cotton/18/000000/edit--v1.png"/></div>Edit</a>
                            </li>
							<li class="list-group-item text-center" onclick="add_formOrg('Customer','hdhgh')"   ><a href="#" ><div><img src="https://img.icons8.com/ultraviolet/18/000000/add--v1.png"/></div>Add
                            </a></li>
						
                            
                        </ul>
                    </div>
                </div>
            </div>
		
		
		
		
	</div>
	<section class="content ">
        <div class="container-fluid card org_div">
            <div class="row" style="font-size: 14px;">
				<input type="hidden" value="<?=$record['id'];?>" id="orgidAct" >
			   <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
					<div class="row text-center">
						<div class="col-md-3 p-2">
							<img src="https://img.icons8.com/dusk/50/000000/organization.png"/>
						</div>
						<div class="col-md-9 p-2">
						<h3><?=$record['org_name']?></h3>
						<p class="mb-1"><?=$record['primary_contact']?></p>
						<p><?=$record['email']?></p>
						</div>
						
						<hr>
					</div> 
					<div class="row text-center">
						<div class="col p-0"> 
							<button type="button" data-toggle="tooltip" title="Creat a note" class="btn btn-default btn-circle ripple" id="openModal">
							<i class="far fa-edit"></i></button>
							Note
						</div>
						<div class="col"> 
							<button type="button" data-toggle="tooltip" title="Creat a email" class="btn btn-default btn-circle ripple" onclick="shareEmail();">
							<i class="far fa-envelope"></i></button>
							Email
						</div>
						<div class="col" data-toggle="modal" data-target="#call_click"> 
							<button type="button" data-toggle="tooltip" title="Creat a call" class="btn btn-default btn-circle ripple" >
							<i class="fas fa-phone-alt"></i></button>
							Call
						</div>
						<div class="col" data-toggle="modal" data-target="#exampleModal"> 
							<button type="button" data-toggle="tooltip" title="Creat a task" class="btn btn-default btn-circle ripple" >
							<i class="fas fa-tasks"></i></button>
							Task
						</div>
						<div class="col" data-toggle="modal" data-target="#meeting_click"> 
							<button type="button" data-toggle="tooltip" title="Creat a meeting" class="btn btn-default btn-circle ripple" >
							<i class="far fa-handshake"></i></button>
							Meeting
						</div>
						
					</div> 
					<hr>
					
					<div class="row">
						
					<div class="wrapper" style="width: 100%;">
						<div class="block one p-1">
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title active">About Customer</div>
								<div class="block__text" style="display: block;">
									<p><text class="text-info">Website : </text> <?=$record['website'];?></p>
									<p><text class="text-info">Mobile : </text><?=$record['mobile'];?></p>
									<p><text class="text-info">Office Phone : </text><?=$record['office_phone'];?></p>
									<p><text class="text-info">Employees : </text><?=$record['employees'];?></p>
									<p><text class="text-info">Industry : </text><?=$record['industry'];?></p>
									<p><text class="text-info">Annual Revenue : </text><?=$record['annual_revenue'];?></p>
									<p><text class="text-info">Type : </text><?=$record['type'];?></p>
									<p><text class="text-info">Region : </text><?=$record['region'];?></p>
									<p><text class="text-info">GSTIN : </text><?=$record['gstin'];?></p>
									<p><text class="text-info">Pan Number : </text><?=$record['panno'];?></p>
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">Customer Address</div>
								<div class="block__text">
									<p><b>Billing Address:-</b></p>
									<p><text class="text-info">Country : </text><?=$record['billing_country'];?></p>
									<p><text class="text-info">State : </text><?=$record['billing_state'];?></p>
									<p><text class="text-info">City : </text><?=$record['billing_city'];?></p>
									<p><text class="text-info">Zipcode : </text><?=$record['billing_zipcode'];?></p>
									<p><text class="text-info">Address : </text><?=$record['billing_address'];?></p>
									<p><b>Shipping Address:-</b></p>
									<p><text class="text-info">Country : </text><?=$record['shipping_country'];?></p>
									<p><text class="text-info">State : </text><?=$record['shipping_state'];?></p>
									<p><text class="text-info">City : </text><?=$record['shipping_city'];?></p>
									<p><text class="text-info">Zipcode : </text><?=$record['shipping_zipcode'];?></p>
									<p><text class="text-info">Address : </text><?=$record['shipping_address'];?></p>
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">Customer Contact</div>
								<div class="block__text">
									<?php
									for($i=0; $i<count($contact); $i++){ 
										if($contact[$i]['name']!=""){ ?>
									<div class="card">
										<div class="card-header" id="heading<?=$contact[$i]['name']?>">
										  <h2 class="mb-0">
											<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$contact[$i]['name']?>" aria-expanded="true" aria-controls="collapse<?=$contact[$i]['name']?>">
											  <?=$contact[$i]['name']?>
											</button>
										  </h2>
										</div>

										<div id="collapse<?=$contact[$i]['name']?>" class="collapse" aria-labelledby="heading<?=$contact[$i]['name']?>">
										  <div class="card-body">
											<p><text class="text-info">Email : </text><?=$contact[$i]['email'];?></p>
											<p><text class="text-info">Mobile No. : </text><?=$contact[$i]['mobile'];?></p>
											<p><text class="text-info">Office No. : </text><?=$contact[$i]['office_phone'];?></p>
											<p class="text-right m-0" ><text class="text-info"><a href="#" onClick="contactEmail('<?=$contact[$i]['id']?>','<?=$contact[$i]['name']?>','<?=$contact[$i]['email']?>','<?=$contact[$i]['org_name']?>');" >Send Email</a></text></p>
										  </div>
										</div>
									</div>
									<?php } } ?>
								</div>
							</div>
						</div>
					</div>

					</div>
					
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12  border-right border-left" style="background: #f5f8fa;">
                    <div class="row text-center  bg-light">
						<div class="col border-bottom p-2 CursorPointer activeItm selectAct ripple"  data-activity="Activity" >Activity</div>
						<div class="col border-bottom p-2 CursorPointer selectAct ripple"  data-activity="customer_note" >Notes</div>
						<div class="col border-bottom p-2 CursorPointer selectAct ripple"  data-activity="customer_email" >Emails</div>
						<div class="col border-bottom p-2 CursorPointer selectAct ripple"  data-activity="customer_call" >Calls</div>
						<div class="col border-bottom p-2 CursorPointer selectAct ripple"  data-activity="customer_task" >Tasks</div>
						<div class="col border-bottom p-2 CursorPointer selectAct ripple"  data-activity="customer_meeting" >Meetings</div>
						<hr>
					</div>
					<div class="row p-2" id="putDataActivity">
						<?php $ci =& get_instance(); ?>
						<?php if(isset($activityCust) && count($activityCust)>1){
									foreach($activityCust as $row){ 
										$viewUrl='';
										if($row['activity_name']=='customer_note'){
											$tableName="customer_note";
											$selectClm="contact_name as title, owner, note";
											$iconName='far fa-edit sub-icn-forecast';
										}
										if($row['activity_name']=='customer_email'){
											$tableName="customer_email";
											$selectClm="subject as title, owner, contact_name,email_adress, cc_email,email_body,timedate";
											$iconName='far fa-envelope sub-icn-contact';
										}
										if($row['activity_name']=='customer_contact_email'){
											$tableName="customer_email";
											$selectClm="subject as title, owner";
											$iconName='far fa-envelope sub-icn-contact';
										}
										if($row['activity_name']=='customer_task'){
											$tableName="opp_task";
											$selectClm="task_subject as title, owner, contact_name,task_from_date,task_due_date,asign_to,currentdate,remarks, status, task_repeat, task_reminder";
											$viewUrl='task?tid=';
											$iconName='fas fa-tasks sub-icn-task';
										}
										if($row['activity_name']=='customer_call'){
											$tableName="create_call";
											$selectClm="call_subject as title, owner, particepants, contact_name, from_date, from_time, to_date, to_time, call_purpose,contact_number";
											$viewUrl='call?cid=';
											$iconName='fas fa-phone-alt sub-icn-call';
										}
										if($row['activity_name']=='customer_meeting'){
											$tableName="meeting";
											$selectClm="meeting_title as title, host_name as owner, location,all_day,from_date,from_time,to_date,to_time,particepants,currentdate, host_name,contact_name,reminder,remarks,status ";
											$viewUrl='meeting?mid=';
											$iconName='far fa-handshake sub-icn-meeting';
										}
										

									if(isset($tableName) && $tableName!=""){	
									$getActivity= $ci->Activity->getActivity($tableName,$selectClm,$row['activity_id']);
									
									
								?>
								<div class="col-sm-12 p-3 mb-1  bg-white">
									<div  class="bg-light p-1  bg-white" 
										data-toggle="collapse" 
										data-target="#collapse<?=$row['id'];?>" 
										aria-expanded="true" 
										aria-controls="collapse<?=$row['id'];?>">
										<?php 
											$activityName=str_replace("customer_"," ",$row['activity_name']);
											$activityName=str_replace("contact_"," ",$activityName); ?>
										<div class="row p-2 ">	
											<div class="col-sm-6 mt-1 mb-1">
											
												<i class="<?=$iconName;?> mr-3"></i>
												
												<text><?=ucwords($activityName);?></text>
											</div>
											<div class="col-sm-6 mt-1 mb-1  text-right">
												<?php  if(isset($row['timedate'])){?>
												<text><i class="far fa-calendar-alt mr-2"></i> 
												<?php $newDate = date("d M Y", strtotime($row['timedate'])); ?>
												<?php $newTime = date("H:i a", strtotime($row['timedate'])); ?>
												<?php echo $newDate.' <i class="far fa-clock mr-1 ml-1"></i> '.$newTime; ?>
											<?php }  ?>
											</div>
											
										</div>
									</div>
									<div id="collapse<?=$row['id'];?>" class="collapse bg-white">
										<div class="row p-2">	
											<div class="col-sm-12 mt-2 mb-1">
											
												<?php if($row['activity_name']=='customer_call'){ ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Call Purpose</text>
														<p><?=$getActivity['call_purpose']; ?></p>
													</div>
													<?php if($getActivity['contact_number']==1){?>	
													<div class="col-md-12">
														<text class="text-info" >Contact Number</text>
														<p><?=$getActivity['contact_number']; ?></p>
													</div>
													<?php } ?>
													<div class="col-md-6">
														<text class="text-info" >Start Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));$getActivity['from_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['from_time']));?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >End Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));$getActivity['to_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['to_time']));?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Particepants User</text>
														<?php
														if(isset($getActivity['particepants']) && $getActivity['particepants']!=""){
															$userArr=explode("<br>",$getActivity['particepants']);
															 echo "<ul class='ml-4'>";
															for($i=0; $i<count($userArr); $i++){
															 if($userArr[$i]!=""){
																
																$userList=$ci->Activity->getUser($userArr[$i]);
																//print_r($userList);
																$adminList=$ci->Activity->getUserAdmin($userArr[$i]);
																if(isset($userList) && count($userList)>0){
																	echo "<li>".$userList['standard_name']."</li>";
																} if(isset($adminList) && count($adminList)>0){
																	echo "<li>".$adminList['admin_name']."</li>";
																}
																 
															 }
															 
															}
															echo "</ul>";
														} 
														?>
													</div>
													<?php  if($viewUrl){ ?>
													<div class="col-md-12 text-right">
														<i class="far fa-eye mr-2"></i> 
														<a href="<?=base_url().$viewUrl.$row['activity_id'];?>" >View Details</a>
													</div>
													<?php } ?>
												</div>
												<?php } ?>
												
												<?php if($row['activity_name']=='customer_task'){ ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Task</text><text> assigned to </text>
														<?php
														if(isset($getActivity['asign_to']) && $getActivity['asign_to']!=""){
															$userArr=explode("<br>",$getActivity['asign_to']);
															 echo "<ul class='ml-4'>";
															for($i=0; $i<count($userArr); $i++){
															 if($userArr[$i]!=""){
																
																$userList=$ci->Activity->getUser($userArr[$i]);
																//print_r($userList);
																$adminList=$ci->Activity->getUserAdmin($userArr[$i]);
																if(isset($userList) && count($userList)>0){
																	echo "<li>".$userList['standard_name']."</li>";
																} if(isset($adminList) && count($adminList)>0){
																	echo "<li>".$adminList['admin_name']."</li>";
																}
																 
															 }
															 
															}
															echo "</ul>";
														} 
														?>
													</div>
													<div class="col-md-12 mt-1">
														<text class="text-info" >Task Subject</text>
														<p><?=$getActivity['title']; ?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >Start Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['task_from_date']));?></p>
													</div>
													
													<div class="col-md-6">
														<text class="text-info" >Due Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['task_due_date']));?>
														</p>
													</div>
													
													<?php if($getActivity['contact_name']!=""){ ?>	
													<div class="col-md-12">
														<text class="text-info" >Customer Contact Name</text>
														<p><?=$getActivity['contact_name']; ?></p>
													</div>
													<?php } ?>
													
													<div class="col-md-4">
														<text class="text-info" >Status</text>
														<p><?php if($getActivity['status']==1){ echo "Not Started"; }else if($getActivity['status']==2){ echo "Completed";  }else if($getActivity['status']==3){ echo "Progress";  }else if($getActivity['status']==0){ echo "Deactive";  } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >Reminder</text>
														<p><?php if($getActivity['task_reminder']==1){ echo "Yes";   }else{ echo "No"; } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >Reminder Repeat</text>
														<p><?php if($getActivity['task_repeat']==1){ echo "Yes";  }else{ echo "No"; } ?></p>
													</div>
													<div class="col-md-4">
														<text class="text-info" >remarks</text>
														<p><?=$getActivity['remarks'];?></p>
													</div>
													
													<div class="col-md-12">
														<text class="text-info" >Added Date</text>
														<p><?=date("d M Y h:s a", strtotime($getActivity['currentdate']));?></p>
													</div>
												
												</div>
												<?php } ?>
											
												<?php if($row['activity_name']=='customer_email'){ ?>
												<div class="row mt-3">
													<div class="col-md-12">
													    <b>Email</b><text> sent to <?=$getActivity['contact_name']; ?> < <?=$getActivity['email_adress']; ?> ></text>
														
													</div>
													
													
													<?php if($getActivity['cc_email']!=""){?>	
													<div class="col-md-12">
														<text class="text-info" >CC Email</text>
														<p class="pl-2"><?=$getActivity['cc_email']; ?></p>
													</div>
													<?php } ?>
													<div class="col-md-12">
														<text class="text-info">Subject</text>
														<text class="pl-2"><?=$getActivity['title']; ?></text>
													</div>
													<div class="col-md-12 mt-1">
														<p class="pl-2"><?php
														echo $getActivity['email_body'];
														/*$stripTags=strip_tags($getActivity['email_body']);
														
														echo substr($stripTags,0,100)."...";*/ ?></p>
													</div>
													<div class="col-md-12 text-right">
														<text class="text-info" >Date & Time</text>
														<p class="pl-2"><?=date("d M Y h:s a", strtotime($getActivity['timedate']));?></p>
													</div>
												
												</div>
												<?php } ?>
												
												<?php if($row['activity_name']=='customer_meeting'){ ?>
												<div class="row mt-3">
													<div class="col-md-12">
														<text class="text-info" >Meeting - </text>
														<text><?=$getActivity['title']; ?></text> by <?=ucwords($getActivity['host_name']); ?> <br>With <?=ucwords($getActivity['contact_name']); ?> 
													</div>
													<div class="col-md-12">
														<text class="text-info" >Location</text>
														<p><?=$getActivity['location']; ?></p>
													</div>
													<?php if($getActivity['all_day']==1){?>	
													<div class="col-md-12">
														<text class="text-info" >All Day or Not</text>
														<p>All day meeting</p>
													</div>
													<?php } ?>
													<div class="col-md-6">
														<text class="text-info" >Start Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));$getActivity['from_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['from_time']));?></p>
													</div>
													<div class="col-md-6">
														<text class="text-info" >End Time</text>
														<p><?=date("d M Y", strtotime($getActivity['from_date']));$getActivity['to_date']; ?>
														 ,  <?=date("h:i a", strtotime($getActivity['to_time']));?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Reminder </text>
														<p><?php if($getActivity['reminder']==1){ echo "Yes"; }else{ echo "No"; } ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Remarks</text>
														<p><?=$getActivity['remarks']; ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Status</text>
												<p><?php if($getActivity['status']==1){ echo "Not Started"; } else if($getActivity['status']==1){ echo "Completed"; }else if($getActivity['status']==3){ echo "Progress"; }else if($getActivity['status']==0){ echo "Deactive"; } ?></p>
													</div>
													<div class="col-md-12">
														<text class="text-info" >Particepants User</text>
														<p><?php
														if(isset($getActivity['particepants']) && $getActivity['particepants']!=""){
															$userArr=explode("<br>",$getActivity['particepants']);
															 echo "<ul class='ml-4'>";
															for($i=0; $i<count($userArr); $i++){
															 if($userArr[$i]!=""){
																
																$userList=$ci->Activity->getUser($userArr[$i]);
																//print_r($userList);
																$adminList=$ci->Activity->getUserAdmin($userArr[$i]);
																if(isset($userList) && count($userList)>0){
																	echo "<li>".$userList['standard_name']."</li>";
																} if(isset($adminList) && count($adminList)>0){
																	echo "<li>".$adminList['admin_name']."</li>";
																}
																 
															 }
															 
															}
															echo "</ul>";
														} 
														?></p>
													</div>
												</div>
												<?php } 
												
												if($row['activity_name']=='customer_note'){ ?>
													<div class="row mt-3">
														<div class="col-md-12">
														<?php echo $getActivity['note'];  ?>
														</div>
													</div>
												<?php }  ?>
											</div>
										</div>
									</div>
								</div>
						<?php  }} }else{ ?>	 
						<div class="col-md-12 text-center p-3">
						<img src="https://img.icons8.com/color/48/000000/nothing-found.png"/><br>
						No activity found yet.</div>
						<?php  } ?>	 
					</div>					
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
				
				
					<div class="row card">
						<div class="col-md-12 p-2 ">
							<h4 class="m-0">Last Contact Person</h4>
						</div>
						<div class="col-md-12 p-2">						
							<?php $i=1;
								if(isset($activityCust) && count($activityCust)>1){
									foreach($activityCust as $row){
										echo '<p><text class="text-info">Contact Name : </text>'.ucwords($row['contact_name']).'</p>';
										echo '<p><text class="text-info">Contact For : </text>'.ucwords(str_replace("_"," ",$row['activity_name'])).'</p>';
										$date = new DateTime($row['currentdate']);
										echo '<p class="text-right m-0">'.$date->format('d M Y').'</p>';
										break;
									}
								}
							?>
						</div>
					</div>
					<div class="row">
					  <div class="wrapper" style="width: 100%;">
						<div class="block one p-1">
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">
									<div class="row">
										<div class="col-md-6">
											Lead
										</div>
										<div class="col-md-6 text-right">
											<?php if(check_permission_status('Lead','create_u')==true){ ?>
											<a href="<?=base_url();?>add-lead?org=<?=$record['org_name'];?>" class="sub-icn-lead"> 
											<i class="fas fa-plus mr-1"></i>Add New</a>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="block__text">
									
									<?php
										for($i=0; $i<count($leads); $i++){ 
											if($leads[$i]['id']!=""){ ?>
										<div class="card m-1">
											<div class="card-header p-1" id="heading<?=$leads[$i]['id']?>">
											  <h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$leads[$i]['id']?>" aria-expanded="true" aria-controls="collapse<?=$leads[$i]['id']?>">
												  <?=$leads[$i]['name']?>
												</button>
												<button class="btn btn-link float-right text-info" type="button"><small>
												  <i class="far fa-calendar-alt sub-icn-so mr-2"></i><?php 
												  $newDate = date("d M Y", strtotime($leads[$i]['currentdate']));
												  echo $newDate;?></small>
												</button>
											  </h2>
											</div>

											<div id="collapse<?=$leads[$i]['id']?>" class="collapse" aria-labelledby="heading<?=$leads[$i]['id']?>">
											  <div class="card-body">
												<p><text class="text-info">Lead ID : </text><?=$leads[$i]['lead_id'];?></p>
												<p><text class="text-info">Lead Owner : </text><?=$leads[$i]['lead_owner'];?></p>
												<p><text class="text-info">Status : </text><?=$leads[$i]['lead_status'];?></p>
												<p><text class="text-info">Sub Total : </text><?=IND_money_format($leads[$i]['sub_total']);?></p>
												<p class="text-right m-0"><a href="<?=base_url().'leads?lid='.$leads[$i]['id'];?>" >View Details</a></p>
											  </div>
											</div>
										</div>
										<?php } } ?>
									
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">
									<div class="row">
										<div class="col-md-6">
										<div>Opportunity</div>
										</div>
										<div class="col-md-6 text-right">
										<?php if(check_permission_status('Opportunity','create_u')==true){ ?>
											<a href="<?=base_url();?>add-opportunity?org=<?=$record['org_name'];?>" class="sub-icn-product"> 
												<i class="fas fa-plus mr-1"></i>Add New
											</a>
										<?php } ?>
										</div>
									</div>
								</div>
								<div class="block__text">
									<?php 
										for($i=0; $i<count($opportunity); $i++){ 
											if($opportunity[$i]['id']!=""){ 
											
											?>
										<div class="card m-1">
											<div class="card-header p-1" id="heading<?=$opportunity[$i]['id']?>">
											  <h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$opportunity[$i]['id']?>" aria-expanded="true" aria-controls="collapse<?=$opportunity[$i]['id']?>">
												  <?=$opportunity[$i]['name']?>
												</button>
												<button class="btn btn-link float-right text-info" type="button"><small>
												  <i class="far fa-calendar-alt sub-icn-so mr-2"></i><?php 
												  $newDate = date("d M Y", strtotime($opportunity[$i]['currentdate']));
												  echo $newDate;?></small></button>
											  </h2>
											</div>

											<div id="collapse<?=$opportunity[$i]['id']?>" class="collapse" aria-labelledby="heading<?=$opportunity[$i]['id']?>">
											  <div class="card-body">
												<p><text class="text-info">Opportunity Id : </text><?=$opportunity[$i]['opportunity_id'];?></p>
												<p><text class="text-info">Opportunity Owner : </text><?=$opportunity[$i]['owner'];?></p>
												<p><text class="text-info">Stage : </text><?=$opportunity[$i]['stage'];?></p>
												<p><text class="text-info">Sub Total : </text><?=IND_money_format($opportunity[$i]['sub_total']);?></p>
												<p class="text-right m-0">
												<a href="<?=base_url().'opportunities?oppid='.$opportunity[$i]['id'];?>" >View Details</a>
												</p>
											  </div>
											</div>
										</div>
									<?php } } ?> 
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">
									<div class="row">
										<div class="col-md-6">
										<div>Quotation</div>
										</div>
										<div class="col-md-6 text-right">
											<?php if(check_permission_status('Quotation','create_u')==true){ ?>
											<a href="<?=base_url();?>add-quote?org=<?=$record['org_name'];?>" class=" sub-icn-quote">
											<i class="fas fa-plus mr-1"></i>Add New </a>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="block__text">
									<?php
										for($i=0; $i<count($quotation); $i++){ 
											if($quotation[$i]['id']!=""){ ?>
										<div class="card m-1">
											<div class="card-header p-1" id="heading<?=$quotation[$i]['id']?>">
											  <h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$quotation[$i]['id']?>" aria-expanded="true" aria-controls="collapse<?=$quotation[$i]['id']?>">
												  <?=$quotation[$i]['subject']?>
												</button>
												<button class="btn btn-link float-right text-info" type="button"><small>
												  <i class="far fa-calendar-alt sub-icn-so mr-2"></i><?php 
												  $newDate = date("d M Y", strtotime($quotation[$i]['currentdate']));
												  echo $newDate;?></small></button>
											  </h2>
											</div>

											<div id="collapse<?=$quotation[$i]['id']?>" class="collapse" aria-labelledby="heading<?=$quotation[$i]['id']?>">
											  <div class="card-body">
												<p><text class="text-info">Quote ID : </text><?=$quotation[$i]['quote_id'];?></p>
												<p><text class="text-info">Quote Owner : </text><?=$quotation[$i]['owner'];?></p>
												<p><text class="text-info">Stage : </text><?=$quotation[$i]['quote_stage'];?></p>
												<p><text class="text-info">Sub Total : </text><?=IND_money_format($quotation[$i]['sub_totalq']);?></p>
												<p class="text-right m-0"><a href="<?=base_url().'quotation/view_pi_qt/'.$quotation[$i]['id'];?>" >View Details</a></p>
											  </div>
											</div>
										</div>
									<?php } } ?> 
								</div>
							</div>
							<div class=" bg-light  border-bottom p-3">
								<div class="block__title">
									<div class="row">
										<div class="col-md-6">
										<div>Sales Order</div>
										</div>
										<div class="col-md-6 text-right">
										<?php if(check_permission_status('Salesorders','create_u')==true){ ?>
											<a href="<?=base_url();?>add-salesorder?org=<?=$record['org_name'];?>" class="sub-icn-so"><i class="fas fa-plus mr-1"></i>Add New</a>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="block__text">
									<?php
										for($i=0; $i<count($salesorder); $i++){ 
											if($salesorder[$i]['id']!=""){ ?>
										<div class="card m-1">
											<div class="card-header p-1" id="heading<?=$salesorder[$i]['id']?>">
											  <h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?=$salesorder[$i]['id']?>" aria-expanded="true" aria-controls="collapse<?=$salesorder[$i]['id']?>">
												  <?=$salesorder[$i]['subject']?>
												</button>
												<button class="btn btn-link float-right text-info" type="button"><small>
												  <i class="far fa-calendar-alt sub-icn-so mr-2"></i><?php 
												  $newDate = date("d M Y", strtotime($salesorder[$i]['currentdate']));
												  echo $newDate;?></small></button>
											  </h2>
											</div>

											<div id="collapse<?=$salesorder[$i]['id']?>" class="collapse" aria-labelledby="heading<?=$salesorder[$i]['id']?>">
											  <div class="card-body">
												<p><text class="text-info">Sales ID : </text><?=$salesorder[$i]['saleorder_id'];?></p>
												<p><text class="text-info">SO Owner : </text><?=$salesorder[$i]['owner'];?></p>
												<p><text class="text-info">Status : </text><?php if($salesorder[$i]['pay_terms_status']==1){ echo "Approved"; }else{ echo "Pending"; } ?></p>
												<p><text class="text-info">Sub Total : </text><?=IND_money_format($salesorder[$i]['sub_totals']);?></p>
												<p class="text-right m-0"><a href="<?=base_url().'salesorders/view_pi_so/'.$salesorder[$i]['id'];?>" >View Details</a></p>
											  </div>
											</div>
										</div>
									<?php } } ?> 
								</div>
							</div>
							
							
							
							
						</div>
					  </div>
					</div>
                </div>
            </div>
        </div>
	 </section>
	
</div>


<div class="modal fade" id="emailModel" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg ModalRight">
    <div class="modal-content Modalht100">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email to customer</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Client's Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['org_name'];?>" name="orgName" id="orgName">
			  <input type="hidden" class="form-control" value="<?=$record['id'];?>" name="orgId" id="orgId">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Client's Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="<?=$record['email'];?>" name="orgEmail" id="orgEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="ccEmail" id="ccEmail">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="  - #<?=$record['org_name'];?>" name="subEmail" id="subEmail">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxt"   name="descriptionTxt">
				<p>Hi <?=$record['org_name'];?>,</p>
				
				<p>Regards ,</p>
				<p><?=$this->session->userdata['company_name'];?>, <?=$this->session->userdata('city');?></p>
			  </textarea>
            </div>
          </div>
			<div class="row text-center"   id="messageDiv" style="display:none; padding: 5%; " >
					
			</div>
			<div class="row" id="footerDiv">
				<div class="col-md-2 text-center" style="padding-top: 5%;">
				</div>
			</div>	
      </div>
	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button class="btn btn-info" id="sendEmail">Send Email</button>
      </div>
	  
    </div>
  </div>
 
</div>



<div class="modal fade" id="contactEmail" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg ModalRight">
    <div class="modal-content Modalht100">
      <div class="modal-header text-center">
        <h4 class="modal-title">Email To Customer Contact</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding: 5%;">
          <div class="row" id="formDiv">
            <div class="col-md-2 lbl">
				<label for="">Contact Name:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="orgName" id="orgNameCnt" readonly >
			  <input type="hidden" value="" name="orgNameCntid" id="orgNameCntid" readonly >
			  <input type="hidden" value="" name="contactOrgName" id="contactOrgName" readonly >
            </div>
			<div class="col-md-2 lbl">
				<label for="">Contact Email:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="orgEmail" id="orgEmailCnt" readonly >
            </div>
			<div class="col-md-2 lbl">
				<label for="">CC:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="ccEmail" id="ccEmailCnt">
            </div>
			<div class="col-md-2 lbl">
				<label for="">Subject:</label>
			</div>
			<div class="col-md-10">
			  <input type="text" class="form-control" value="" name="subEmail" id="subEmailCnt">
            </div>
			<div class="col-md-12 lbl">
				<label for="">Message*:</label>
			</div>
			<div class="col-md-12">
			  <textarea class="form-control" id="descriptionTxtCnt"   name="descriptionTxt"></textarea>
            </div>
          </div>
			<div class="row text-center" id="messageDivCnt" style="display:none; padding: 5%;"></div>
			<div class="row" id="footerDivCnt">
				<div class="col-md-2 text-center" style="padding-top: 5%;">
				</div>
			</div>	
      </div>
	  
	  <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button class="btn btn-info" id="sendEmailCnt">Send Email</button>
      </div>
	  
	  
	  
    </div>
  </div>
 
</div>

<!--Save Note Modal---->
<div class="modal fade" id="AddNoteModal" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog  ModalRight" role="document">
    <div class="modal-content Modalht100">
      <div class="modal-header">
        <h5 class="modal-title" id="AddNoteModalLabel">Create a note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="noteForm">
			<input type="hidden" name="orgNameNote" id="orgNameNote" value="<?=$record['org_name'];?>">
			<input type="hidden" name="orgIdNote" id="orgIdNote" value="<?=$record['id'];?>">
		  <div class="form-group">
			<label for="contactName">Contact Name</label>
			<select class="form-control" id="contactName" name="contactName">
			<?php for($i=0; $i<count($contact); $i++){ 
				if($contact[$i]['name']!=""){ ?>
					<option value="<?=$contact[$i]['id']?>"><?=$contact[$i]['name']?></option>	
				<?php } } ?>	
			</select>
			<small id="emailHelp" class="form-text text-muted">You can select other contact person</small>
		  </div>
		  <div class="form-group">
			<label for="notearea">Note</label>
			<textarea class="form-control" id="notearea" name="notearea" placeholder="Start typing to leave a note"></textarea>
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="saveNote" >Save changes</button>
      </div>
    </div>
  </div>
</div>




<style>  .tskSpan{  border: none;
    font-weight: 700;
    background: no-repeat; }</style>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg ModalRight" >
    <div class="modal-content Modalht100">
      <div class="modal-header">
        <h5 class="modal-title" id="">Create Task</h5>
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="taskForm" method="post">
            <input type="hidden" value="<?=$record['id'];?>"  name="custnameid" id="custnameid">
            <div class="row">
				<div class="col-md-6 form-group">
					<label for="notearea">Customer Name</label>
					<input type="text" class="form-control checkvl" placeholder="Customer Name" name="custname" id="custname" value="<?=$record['org_name'];?>" >
				</div>
				<div class="col-md-6 form-group">
					<label for="notearea">Contact Person</label>
					<select class="form-control checkvl" id="contactNameid" name="contactNameid">
						<?php for($i=0; $i<count($contact); $i++){ 
							if($contact[$i]['name']!=""){ ?>
								<option value="<?=$contact[$i]['id']?>"><?=$contact[$i]['name']?></option>	
							<?php } } ?>	
						</select>
					<small id="emailHelp" class="form-text text-muted">You can select other contact person</small>
				</div>
				
				<div class="col-md-6 form-group">
					<label for="notearea">Task Subject</label>
					<input type="text" class="form-control" placeholder="Subject" name="taskSubject" id="taskSubject" >
				</div>
                <div class="col-md-6 form-group">
					<label for="notearea">Task Priority</label>
                    <select class="form-control" name="taskPriority" id="taskPriority">
                        <option value="">Select Priority</option>
                        <option value="High">High</option>
                        <option value="Highest">Highest</option>
                        <option value="Low">Low</option>
                        <option value="Lowest">Lowest</option>
                        <option value="Normal">Normal</option>
                    </select>
                </div>
                <div class="col-md-6 form-group">
					<label for="notearea">Task From Date :</label>
                    <input type="text" class="form-control" name="taskFromDate" id="taskFromDate" onfocus="(this.type='date')" placeholder="From Date">
                </div>
                
                <div class="col-md-6 form-group">
					<label for="notearea">Task Due Date<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control checkvl" name="taskDueDate" id="taskDueDate" onfocus="(this.type='date')" placeholder="Due Date">
                </div>
                
                <div class="col-md-6 form-group">
					<label for="notearea">Task Owner<span style="color: #f76c6c;">*</span></label>
                    <input type="text" class="form-control onlyLetters checkvl" name="taskOwner"  id="taskOwner" value="<?= $this->session->userdata('name'); ?>">
                </div>
                
                <div class="col-md-6 form-group">
					<label for="notearea">Task Asigned To</label>
                    <select class="form-control selctCl" multiple name="taskUser[]" id="taskUser" >
                        <?php foreach($users_data_ad as $row){ ?>
                            <option value="<?=$row['admin_email'];?>"><?=$row['admin_name'];?></option>
                        <?php } ?>
						<?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
					<small id="emailHelp" class="form-text text-muted">You can select multiple user</small>
                </div>
                
                <div class="col-md-6 form-group">
					<label for="notearea">Task Status</label>
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
				<div class="col-md-6 form-group"></div>
                <div class="col-md-6 form-group">
				   <label for="notearea">Task Reminder</label>
                    <label class="switch ">
                          <input type="checkbox" type="checkbox" value="1"  name="taskReminder" id="taskReminder">
                          <span class="slider round"></span>
                   </label>
                </div>
                
                <div class="col-md-6 form-group">
					<label for="notearea">Reminder Repeat</label>
                   <label class="switch ">
                          <input type="checkbox" value="1"  name="taskRepeat" id="taskRepeat"  >
                          <span class="slider round"></span>
                   </label>
                </div>
				
                
                
                <div class="col-md-12 form-group">
					<label for="notearea">Remarks</label>
                    <textarea class="form-control" name="taskRemarks" id="taskRemarks"></textarea>
                </div>
            </div>
            
            <div class="row" id="messageDiv" style="display:none;">
                <div class="col-md-2 form-group"></div>
                <div class="col-md-8 form-group text-center" id="putmsg" style="padding: 45px;"></div>
                <div class="col-md-2 form-group"></div>
            </div>
            
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info"  id="saveTask">Save</button>
        <button type="button" class="btn btn-secondary rounded-0" style="display:none;"  id="saveTaskAnother">Saving task...</button>
      </div>
    </div>
  </div>
</div>
<!--task click popup-->

<!--meeting click popup-->
<!-- Modal -->
<div class="modal fade right" id="meeting_click" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static" >
  <div class="modal-dialog modal-lg ModalRight" >
    <div class="modal-content Modalht100">
      <div class="modal-header">
        <h5 class="modal-title" id="">Meeting Information</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="meetingForm" method="post">
            <div class="row" id="formDivhd">
			    <input type="hidden" value="<?=$record['id'];?>" name="custnameid" id="">
				
				<div class="col-md-6 form-group">
					<label for="notearea">Customer Name</label>
					<input type="text" class="form-control checkvl" placeholder="Customer Name" name="custname" id="custname" value="<?=$record['org_name'];?>" >
				</div>
				<div class="col-md-6 form-group">
					<label for="notearea">Contact Person</label>
					<select class="form-control checkvl" id="contactNameid" name="contactNameid">
						<?php for($i=0; $i<count($contact); $i++){ 
							if($contact[$i]['name']!=""){ ?>
								<option value="<?=$contact[$i]['id']?>"><?=$contact[$i]['name']?></option>	
							<?php } } ?>	
						</select>
					<small id="emailHelp" class="form-text text-muted">You can select other contact person</small>
				</div>
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Meeting Title<span style="color: #f76c6c;">*</span></label>
                
                    <input type="text" class="form-control onlyLetters checkvl" placeholder="Title" value="New Meeting" name="mtngTitle" id="mtngTitle">
                </div>
                <div class="col-md-6 form-group">
                   <label for="notearea">Meeting Location<span style="color: #f76c6c;">*</span> </label>
                
                    <input type="text" class="form-control" placeholder="Location" name="mtngLocation" id="mtngLocation">
                </div>
				<div class="col-md-6 form-group">
                   <label for="notearea">Host Name<span style="color: #f76c6c;">*</span> </label>
               
                    <input type="text" class="form-control checkvl" name="mtngHost" id="mtngHost" placeholder="Host" value="<?= $this->session->userdata('name'); ?>">
                </div>
                <div class="col-md-6 form-group">
                   <label for="notearea">All Day Meeting: </label>
					<label class="switch ">
                          <input type="checkbox" value="1"  name="mtngAllday" id="mtngAllday"  >
                          <span class="slider round"></span>
                   </label>
                </div>
                
                <div class="col-md-3 form-group">
                   <label for="notearea">Start Date<span style="color: #f76c6c;">*</span> </label>
                
                    <input type="text" class="form-control" name="mtngFromDate" id="mtngFromDate" onfocus="(this.type='date')" placeholder="From (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
					<label for="notearea">Start Time<span style="color: #f76c6c;">*</span> </label>
                    <input type="text" class="form-control" name="mtngFromTime" id="mtngFromTime" onfocus="(this.type='time')" placeholder="From Time (hh-mm)">
                </div>
                
                <div class="col-md-3 form-group">
                   <label for="notearea">End Date<span style="color: #f76c6c;">*</span> </label>
                
                    <input type="text" class="form-control" name="mtngToDate" id="mtngToDate" onfocus="(this.type='date')" placeholder="To (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
					<label for="notearea">End Time<span style="color: #f76c6c;">*</span> </label>
                    <input type="text" class="form-control" name="mtngToTime" id="mtngToTime" onfocus="(this.type='time')" placeholder="To Time (hh-mm)">
                </div>
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Meeting Participants: </label>
                
                    <select class="form-control selctCl checkvl" multiple name="mtngParticepants[]" id="mtngParticepants"  >
                        <?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
                </div>
               
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Reminder : </label>
               
                    <select class="form-control selctCl" name="mtngReminder" id="mtngReminder" >
                            <option value="">Select Reminder</option>
                            <option value="At time of event">At time of event</option>
                            <option value="5">5 Minutes before</option>
                            <option value="10">10 Minutes before</option>
                            <option value="15">15 Minutes before</option>
                            <option value="30">30 Minutes before</option>
                            <option value="1">1 Hour before</option>
                            <option value="2">2 Hour before</option>
                       
                    </select>
                </div>
                
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Remarks : </label>
                    <textarea class="form-control" name="taskRemarks" id="taskRemarks"></textarea>
                </div>
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Task Status : </label>
                
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="CloseMeetingForm" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="MeetingFormSave">Save</button>
        <button type="button" class="btn btn-secondary rounded-0" style="display:none;" id="MeetingFormSaving">Creating meeting...</button>
      </div>
    </div>
  </div>
</div>
<!--meeting click popup-->

<!--call click popup-->
<!-- Modal -->
<div class="modal fade" id="call_click" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:99999;" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg ModalRight" >
    <div class="modal-content Modalht100">
      <div class="modal-header">
        <h5 class="modal-title" id="">Create Call</h5>
        </button>
      </div>
      <div class="modal-body">
        <form class="task-form" id="callForm" method="post">
            <div class="row" >
				<input type="hidden" value="<?=$record['id'];?>" name="custnameid" id="">
			
				<div class="col-md-6 form-group">
					<label for="notearea">Customer Name</label>
					<input type="text" class="form-control checkvl" placeholder="Customer Name" name="custname" id="custname" value="<?=$record['org_name'];?>" >
				</div>
				<div class="col-md-6 form-group">
					<label for="notearea">Contact Person</label>
					<select class="form-control checkvl" id="contactNameid" name="contactNameid">
						<?php for($i=0; $i<count($contact); $i++){ 
							if($contact[$i]['name']!=""){ ?>
								<option value="<?=$contact[$i]['id']?>"><?=$contact[$i]['name']?></option>	
							<?php } } ?>	
						</select>
					<small id="emailHelp" class="form-text text-muted">You can select other contact person</small>
				</div>
				
                
                <div class="col-md-6 form-group">
                    <label for="notearea">Subject<span style="color: #f76c6c;">*</span></label>
               
                    <input type="text" class="form-control checkvl" name="callSubject" id="callSubject" placeholder="Subject">
                </div>
                <div class="col-md-6 form-group">
                    <label for="notearea">Purpose<span style="color: #f76c6c;">*</span></label>
               
                    <select class="form-control checkvl" name="callPurpose" id="callPurpose">
                        <option selected disabled>Call Purpose</option>
                        <option>Prospecting</option>
                        <option>Administrative</option>
                        <option>Negotiation</option>
                        <option>Demo</option>
                        <option>Project</option>
                        <option>Desk</option>
                    </select>
                </div>
                
                <div class="col-md-6 form-group">
                    <label for="notearea">Related To<span style="color: #f76c6c;">*</span></label>
                
                    <select class="form-control checkvl" name="callRelated" id="callRelated">
                        <option selected disabled>Related To</option>
                        <option>Accounting</option>
                        <option>Deal</option>
                        <option>Campaign</option>
                    </select>
                </div>
				
				<div class="col-md-6 form-group">
					<label for="notearea">Call Asigned To</label>
                    <select class="form-control selctCl" multiple name="particepants[]" id="particepants" >
                        <?php foreach($users_data_ad as $row){ ?>
                            <option value="<?=$row['admin_email'];?>"><?=$row['admin_name'];?></option>
                        <?php } ?>
						<?php foreach($users_data as $row){ ?>
                            <option value="<?=$row['standard_email'];?>"><?=$row['standard_name'];?></option>
                        <?php } ?>
                    </select>
					<small id="emailHelp" class="form-text text-muted">You can select multiple user</small>
                </div>
				
				<div class="col-md-3 form-group">
                   <label for="notearea">Start Date<span style="color: #f76c6c;">*</span> </label>
                
                    <input type="text" class="form-control" name="mtngFromDate" id="mtngFromDate" onfocus="(this.type='date')" placeholder="From (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
					<label for="notearea">Start Time<span style="color: #f76c6c;">*</span> </label>
                    <input type="text" class="form-control" name="mtngFromTime" id="mtngFromTime" onfocus="(this.type='time')" placeholder="From Time (hh-mm)">
                </div>
                
                <div class="col-md-3 form-group">
                   <label for="notearea">End Date<span style="color: #f76c6c;">*</span> </label>
                
                    <input type="text" class="form-control" name="mtngToDate" id="mtngToDate" onfocus="(this.type='date')" placeholder="To (dd-mm-yyyy)">
                </div>
                <div class="col-md-3 form-group">
					<label for="notearea">End Time<span style="color: #f76c6c;">*</span> </label>
                    <input type="text" class="form-control" name="mtngToTime" id="mtngToTime" onfocus="(this.type='time')" placeholder="To Time (hh-mm)">
                </div>
				
				
                <div class="col-md-6 form-group">
                    <label for="notearea">Call Type : </label>
                    <select class="form-control" name="callType" id="callType">
                        <option selected disabled>Call Type</option>
                        <option>Outbound</option>
                        <option>Inbound</option>
                    </select>
                </div>
               
                <div class="col-md-6 form-group">
                    <label for="notearea">Call Deatils</label>
               
                    <input type="text" class="form-control" name="callDeatils" id="callDeatils" placeholder="Call Details">
                </div>
                
                <div class="col-md-6 form-group">
                   <label for="notearea">Call Status : </label>
                
                    <select class="form-control" name="taskStatus" id="taskStatus">
                        <option value="">Select Status</option>
                        <option value="1">Not Started</option>
                        <option value="2">Completed</option>
                        <option value="3">Progress</option>
                        <option value="0">Deactive</option>
                    </select>
                </div>
				<div class="col-md-6 form-group">
                   <label for="notearea">Reminder : </label>
                    <select class="form-control selctCl" name="mtngReminder" id="mtngReminder" >
                            <option value="">Select Reminder</option>
                            <option value="At time of event">At time of event</option>
                            <option value="5">5 Minutes before</option>
                            <option value="10">10 Minutes before</option>
                            <option value="15">15 Minutes before</option>
                            <option value="30">30 Minutes before</option>
                            <option value="1">1 Hour before</option>
                            <option value="2">2 Hour before</option>
                    </select>
                </div>
				
				<div class="col-md-12 form-group">
                    <label for="notearea">Call Description</label>
                    <textarea class="form-control" placeholder="Description" name="callDescription" id="callDescription"></textarea>
                </div>
				
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="callClose" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info"  id="callSave" >Save</button>
        <button type="button" class="btn btn-secondary" style="display:none;"  id="callSaveAnother" >Call saving..</button>
      </div>
    </div>
  </div>
</div>
<!--call -->

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<?php $this->load->view('commonAddorg_modal');?>
<script src="<?= base_url();?>assets/js/filter-multi-select-bundle.min.js"></script>
<script language="javascript">

$(document).ready(function() {
    $('.block__title').click(function(event) {
        if($('.block').hasClass('one')){
            $('.block__title').not($(this)).removeClass('active');
            $('.block__text').not($(this).next()).slideUp(300);
        }
        $(this).toggleClass('active').next().slideToggle(300);
    });

});


	$(".CursorPointer").click(function(){
		$(".CursorPointer").removeClass('activeItm');
		$(this).addClass('activeItm');
	});
	
	
	
	
	</script>
	<script language="javascript">
	$(function () { 
		$('#taskUser').filterMultiSelect(); 
		$('#particepants').filterMultiSelect(); 
		$('#mtngParticepants').filterMultiSelect();
	});
	
        function printdiv(printpage) {
            var headstr = "<html><head><title></title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>
<script>
//CKEDITOR.replace( 'notearea' );
CKEDITOR.replace('notearea', {
    toolbar: [
        ['Bold', 'Italic', 'Underline', 'Strike', 'TextColor', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
    ]
});

//CKEDITOR.replace( 'notearea' );
	var editor  = CKEDITOR.replace( 'descriptionTxt' );
	var editor2 = CKEDITOR.replace( 'descriptionTxtCnt' );
	CKEDITOR.config.height='150px';
</script>
<script>

$(".selectAct").click(function(){
	$("#putDataActivity").html('<div class="col-md-12 text-center p-3">  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><br>  Loading data ...</div>');
	var activity= $(this).data('activity');
	var cust_id	= $("#orgidAct").val();
	var url = "<?= base_url('Customer_activity/get_activity')?>";
	$.ajax({
        url : url,
        type: "POST",
        data: 'activity='+activity+'&cust_id='+cust_id,
        //dataType: "JSON",
        success: function(data){ 
			setTimeout(function(){ $("#putDataActivity").html(data); },500);
        }
    });
});




$("#MeetingFormSave").click(function(){
	if(checkValidationWithClass('meetingForm')==1){
	    $("#MeetingFormSave").hide();
		$("#MeetingFormSaving").show(); 
	    var dataString  = $("#meetingForm").serialize();
		var contactName = $('#contactNameid').find(":selected").text();
	    var url = "<?= base_url('Customer_activity/addMeeting')?>";
        $.ajax({
            url : url,
            type: "POST",
            data: dataString+'&contactName='+contactName,
            dataType: "JSON",
            success: function(data)
            { 
			
			  if(data.status) 
              {
                $('#meeting_click').modal('hide'); 
                toastr.success('Meeting has been added successfully.');   
                $("#MeetingFormSave").show();
				$("#MeetingFormSaving").hide();  
              }else{
				toastr.error('Something went wrong, please try later.');   
                $("#MeetingFormSave").show();
				$("#MeetingFormSaving").hide();  
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
				toastr.error('Something went wrong, please try later.'); 
                $("#MeetingFormSave").show();
				$("#MeetingFormSaving").hide();
            }
        });
	}
    
});

/*
	#####################
	#		Add Call 	#
	#####################
*/

$("#callSave").click(function(){
	if(checkValidationWithClass('callForm')==1){
		$("#callSave").hide();
	    $("#callSaveAnother").show();
	    var dataString = $("#callForm").serialize();
		var contactName = $('#contactNameid').find(":selected").text();
        var url = "<?= base_url('Customer_activity/addCall')?>";
		
        $.ajax({
            url : url,
            type: "POST",
            data: dataString+'&contactName='+contactName,
            dataType: "JSON",
            success: function(data)
            { 
              if(data.status) 
              {
                $('#call_click').modal('hide'); 
                toastr.success('Call has been added successfully.');   
                $("#callSave").show();
				$("#callSaveAnother").hide();  
              }else{
				toastr.error('Something went wrong, please try later.');   
                $("#callSave").show();
				$("#callSaveAnother").hide();  
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {    toastr.error('Something went wrong, please try later.'); 
                $("#callSave").show();
				$("#callSaveAnother").hide();
            }
        });
	}
});



$("#saveTask").click(function(){
	
  if(checkValidationWithClass('taskForm')==1){
	    $("#saveTask").hide();
	    $("#saveTaskAnother").show();
	    var dataString = $("#taskForm").serialize();
		var contactName = $('#contactNameid').find(":selected").text();
        var url = "<?= base_url('Customer_activity/addTask')?>";
        $.ajax({
            url : url,
            type: "POST",
            data: dataString+'&contactName='+contactName,
            dataType: "JSON",
            success: function(data)
            { 
              if(data.status) 
              {
				$('#exampleModal').modal('hide'); 
                toastr.success('Task has been added successfully.'); 
				$("#saveTask").show();
				$("#saveTaskAnother").hide();
              }else{
                toastr.error('Something went wrong, please try later.'); 
				$("#saveTask").show();
				$("#saveTaskAnother").hide();				
              }
              
            },
            error: function (jqXHR, textStatus, errorThrown)
            {   $("#saveTask").show();
				$("#saveTaskAnother").hide();
                toastr.error('Something went wrong, please try later.');   
            }
        });
	}
    
});


$("#openModal").click(function(){
	$("#AddNoteModal").modal('show');
});

$("#saveNote").click(function(){
	var contact = $('#contactName').find(":selected").text();
	var noteTxt = CKEDITOR.instances["notearea"].getData();
	for (var i in CKEDITOR.instances) {
            CKEDITOR.instances[i].updateElement();
	};
	$.ajax({
     url: "<?= site_url(); ?>/Customer_activity/add_note",
     method: "POST",
     data: $('#noteForm').serialize()+'&contact='+contact,
     success: function(dataSucc){
      if(dataSucc==1){
		  toastr.success('Notes saved successfully.');
		  $("#AddNoteModal").modal('hide');
	  }else{
		  toastr.error('Something went wrong, Please try later .');
	  }
     }
    });
	
});



function contactEmail(id,name,email,contactOrgName){ 
	$("#orgNameCntid").val(id);
	$("#orgNameCnt").val(name);
	$("#orgEmailCnt").val(email);
	$("#contactOrgName").val(contactOrgName);
	
	var ccEmail		= $("#ccEmailCnt").val();
	var subEmail	= $("#subEmailCnt").val();
	$('#contactEmail').modal('show'); 
}

$("#sendEmailCnt").click(function(){
	var orgName		= $("#orgNameCnt").val();
	var contactOrgName		= $("#contactOrgName").val();
	var orgEmail	= $("#orgEmailCnt").val();
	var ccEmail		= $("#ccEmailCnt").val();
	var subEmail	= $("#subEmailCnt").val();
	var orgId		= $("#orgId").val();
	var orgNameCntid= $("#orgNameCntid").val();
	
	var descriptionTxt = CKEDITOR.instances["descriptionTxtCnt"].getData();
	$("#sendEmailCnt").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/Customer_activity/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,orgId:orgId,orgNameCntid:orgNameCntid,contactOrgName:contactOrgName},
     success: function(dataSucc){
          console.log(dataSucc);
      if(dataSucc==1){
		    $("#formDivCnt, #footerDivCnt").hide();
			$("#messageDivCnt").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email sent successfully.');
			$("#messageDivCnt").css('display','block');
			$("#sendEmailCnt").html('Send Email');
			setTimeout(function(){ $("#messageDivCnt").hide(); $("#formDivCnt, #footerDivCnt").show(); $('#contactEmail').modal('hide'); },4000)
	  }else{
		  $("#formDivCnt, #footerDivCnt").hide();
		  $("#messageDivCnt").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDivCnt").css('display','block');
		  $("#sendEmailCnt").html('Send Email');
		  setTimeout(function(){ $("#messageDivCnt").hide(); $("#formDivCnt, #footerDivCnt").show(); },4000)
	  }
     }
    });
});



function shareEmail(){ 
	$('#emailModel').modal('show'); 
}

$("#sendEmail").click(function(){
	var orgName		= $("#orgName").val();
	var orgEmail	= $("#orgEmail").val();
	var ccEmail		= $("#ccEmail").val();
	var subEmail	= $("#subEmail").val();
	var orgId	    = $("#orgId").val();
	var descriptionTxt = CKEDITOR.instances["descriptionTxt"].getData();
	$("#sendEmail").html('<i class="fas fa-spinner fa-spin"></i>');
	
	$.ajax({
     url: "<?= site_url(); ?>/Customer_activity/send_email",
     method: "POST",
     data: {orgName:orgName,orgEmail:orgEmail,ccEmail:ccEmail,subEmail:subEmail,descriptionTxt:descriptionTxt,orgId:orgId},
     success: function(dataSucc){
      if(dataSucc==1){
		    $("#formDiv, #footerDiv").hide();
			$("#messageDiv").html('<i class="far fa-check-circle" style="color: #60b963; font-size: 42px;"></i><br>Your email sent successfully.');
			$("#messageDiv").css('display','block');
			$("#sendEmail").html('Send Email');
			setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); $('#emailModel').modal('hide'); },4000)
	  }else{
		  $("#formDiv, #footerDiv").hide();
		  $("#messageDiv").html('<i class="fas fa-exclamation-triangle" style="color:#e617089e; font-size: 42px;"></i><br>Something went wrong, Please try later.');
		  $("#messageDiv").css('display','block');
		  $("#sendEmail").html('Send Email');
		  setTimeout(function(){ $("#messageDiv").hide(); $("#formDiv, #footerDiv").show(); },4000)
	  }
     }
    });
});

</script>

<script>
$('.form-control').keypress(function(){
  $(this).css('border-color','')
  $("#bank_details span").html("");
});
$('.form-control').change(function(){
  $(this).css('border-color','')
});

</script>