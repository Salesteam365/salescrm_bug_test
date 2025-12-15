<?php $this->load->view('common_navbar');?>
   <style>
	 #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#ajax_datatable tbody tr td {
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

#ajax_datatable tbody tr td:nth-child(3) {
   
  color: rgba(140, 80, 200, 1);
  font-weight: 700;
}

 

   </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Leads</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
              <li class="breadcrumb-item active">Leads</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
		<div class="container-fliud filterbtncon"  >
        <div class="row mb-3">
          <!-- <div class="col-lg-2">
            <div class="first-one">
               <select class="custom-select" name="date_filter" id="date_filter">
					<?php 
					$dateYear=date('Y');
					for($n=($dateYear+5); $n>=($dateYear-5); $n--){ ?>
						<option value="<?="FY ".($n-1)."-FY ".$n;?>" <?php if(isset($_GET['q']) && $_GET['q']=="FY ".($n-1)."-FY ".$n){ echo "selected"; } ?>  ><?="FY ".($n-1)."-FY ".$n;?></option>
					<?php } ?>
				</select>
            </div>
          </div> -->

		  <div class="col-sm-2 form-group">
            <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<?php $currentyear = date('Y'); if(isset($_GET['q'])){ echo $_GET['q']; } else{ echo "FY ".$currentyear ."-FY ".($currentyear+1); } ?>
    </button>
            <input type="hidden" id="date_filter" value="" name="date_filter">
            <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
                                 
			<?php 
					$dateYear=date('Y');
					for($n=($dateYear+5); $n>=($dateYear-5); $n--){ $FY = "FY ".($n-1)."-FY ".$n; ?>
                        
               <li onclick="getfilterdData('<?= $FY; ?>','filter_by_fy','date_filter');">
			     <?="FY ".($n-1)."-FY ".$n;?></li>
                 <?php } ?>
                  </ul>
			
            </div>
            </div>

          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <?php if($this->session->userdata('type') == 'admin'){ ?>
                 <button type="button" class="btn btnstop" data-toggle="modal" data-target="#setquotaMOdal" id="btn2"><i class="fas fa-filter"></i>Set Quota</button>
				<?php } ?>
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <div class="card-body">
                  <?php //print_r($quota); ?>
                  <div class="table-responsive">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                    <thead style="background: #e6e6e6; color: #000;">  
                        <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">Sales</td>
                            <td colspan="3">Profit</td>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                          <th class="th-sm">User Name</th>
                          <th class="th-sm">Financial Year</th>
                          <th class="th-sm">Sales Target</th>
                          <th class="th-sm">Achieved Sales</th>
                          <th class="th-sm">Sales Gap</th>
                          <th class="th-sm">Profit Target</th>
                          <th class="th-sm">Achieved Profit</th>
                          <th class="th-sm">Profit Gap</th>
                        </tr>
                    </thead>
                    <tbody>  
                        <?php 
                        if(count($quota)>0){
                        for($i=0; $i<count($quota); $i++){ ?>
                        <tr>
                            <td><?=ucwords($quota[$i]['standard_name']);?>
                            <div class="links"> <a style="text-decoration:none" href="<?=base_url()?>sales-and-profit-target-detail/<?=$quota[$i]['id']?>/<?=$quota[$i]['standard_name']?>" class="text-success">View</a> <?php if($this->session->userdata('type') == 'admin'){ ?> | <a style="text-decoration:none" href="javascript:void(0)" onclick="update('<?=$quota[$i]['id']?>')" class="text-primary">Update</a>
                            <?php } ?>
                            </div>
                            </td>
                            <td><?=$quota[$i]['finacial_year'];?></td>
                            <td>₹<?=IND_money_format($quota[$i]['quota']);?></td>
                            <td>₹<?=IND_money_format($quota[$i]['sales']);?></td>
                            <td>
                            <?php $gap=$quota[$i]['quota']-$quota[$i]['sales'];
                            if (isset($gap)){
							if (substr(strval($gap), 0, 1) == "-"){
								?>
							<span class="text-success">
								<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$gap));?>
							</span>
							<?php
							} else {
								?>
							<span class="text-danger">
								<span>(-)</span>&nbsp;₹<?=IND_money_format($gap);?>
							</span>
							<?php
							}
						}
                            ?>
                            </td>
                            <td>₹<?=IND_money_format($quota[$i]['profit_quota']);?></td>
                            <td>₹<?=IND_money_format($quota[$i]['profit']);?></td>
                            <td><?php $gapp=$quota[$i]['profit_quota']-$quota[$i]['profit'];
                            
						if (isset($gapp)){
							if (substr(strval($gapp), 0, 1) == "-"){
								?>
							<span class="text-success">
								<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$gapp));?>
							</span>
							<?php
							} else {
								?>
							<span class="text-danger">
								<span>(-)</span>&nbsp;₹<?=IND_money_format($gapp);?>
							</span>
							<?php
							}
						}
						
						?>
                            
                            
                            </td>
                        </tr>
                        <?php } }else{  ?>
                        <tr>
                            <td colspan="8" class="text-center">
                                <i class="fas fa-info-circle"></i>
                                No record found for this financial year.
                            </td>
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
  
  <!--  Set Sales And Profit Quota Modal-->
  
    <div class="modal fade" id="setquotaMOdal" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable"  role="document">
           <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Add Quota</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body form">
                    <form id="quota_form" method="post">
						<div class="row m-0">
							<div class="col-sm-12">
							  <label for="finacial_year">Sales User <span class="text-danger">*</span></label>
								<div class="input-group mb-3">
								<select class="form-control" name="finacial_year" id="finacial_year">
									<?php $dateYear=date('Y');
									for($n=$dateYear; $n<=($dateYear+5); $n++){ ?>
								   <option value="<?="FY ".$n."-FY ".($n+1);?>"><?="FY ".$n."-FY ".($n+1);?></option>
									<?php } ?>
								</select>
								</div>
        					</div>
							
							<div class="col-sm-12">
							<label for="sales_users">Sales User <span class="text-danger">*</span></label>
							<div class="input-group mb-3">
							  <select class="form-control" name="sales_users" id="sales_users">
								<option value="">Select Users</option>
								<?php if($this->session->userdata('type') == 'admin'){ ?>
								<option value="<?=$this->session->userdata('email'); ?>"><?=$this->session->userdata('name'); ?> (Admin)</option>
								<?php } ?>
								  <?php 
								  foreach($sales_users as $salesusers){ ?>
									<option value="<?=$salesusers->standard_email ?>"><?=$salesusers->standard_name; ?></option>
								  <?php } ?>
							  </select>
							</div>
							
        					</div>
							
        			<div class="col-sm-6">
						<label for="set_quota">Set Sales Quota <span class="text-danger">*</span></label>
						<div class="input-group mb-3">
							  <div class="input-group-prepend">
								<span class="input-group-text">₹ </span>
							  </div>
							  <input type="text" placeholder=" Enter Quota"   data-type="currency" name="set_quota" id="set_quota" class="form-control numeric" aria-describedby="basic-addon3">
						</div>
        			</div>
        			<div class="col-sm-6">
						<label for="set_quota_pr">Set Profit Quota <span class="text-danger">*</span></label>
						<div class="input-group mb-3">
							  <div class="input-group-prepend">
								<span class="input-group-text">₹ </span>
							  </div>
							  <input type="text" placeholder="Enter Profit Quota"   data-type="currency" name="set_quota_pr" id="set_quota_pr" class="form-control numeric" aria-describedby="basic-addon3">
						</div>
        			</div>
					<div class="col-sm-12 form-group text-left monthlyquars" style="display:none;" data-toggle="collapse" href="#SetQuarterlyQuota">
								<span class="text-info" id="btnquartly" type="button">Set Quarterly Quota</span>
					</div>
							
					</div>
							
					<div class="row m-0 collapse" id="SetQuarterlyQuota">
						    
						<div class="row">
							    
						    <div class="col-sm-1"></div>
							<div class="col-sm-11" >
								<span id="notEqual_quota_error" style="color:red;"></span>
							</div>
						</div>
						<div class="row" style="padding-left: 6%;">
						    
						<div class="col-sm-6 mb-3">
							<label for="quat1">First Quarter (April - June)  <span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								</div>
								  <input type="text" placeholder=" Enter Quat1" data-type="currency" name="quat1" id="quat1" class="form-control numeric quota"  data-relate="firstQuita" >
							</div>
								<a class="text-info firstQtformonth"  >
									Set Monthly Quota
								</a>
								<div class="collapse firstQuita" id="firstQuita" >
								<div class="row">
									<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="ptMsgQ1" class="text-danger is-invalid"></div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month1">M1 (April) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text"  placeholder="Enter Per Month1" name="per_month1" id="per_month1" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month2">M2 (May) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month2" name="per_month2" id="per_month2" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month3">M3 (June) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month3" name="per_month3" id="per_month3" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
								</div>
								</div>
        				</div>
        				<!--Profit Set Target-->
        				<div class="col-sm-6 mb-3">
							<label for="profitQuat1">Set Profit For First Quarter (April - June)  <span class="text-danger">*</span></label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								</div>
								  <input type="text" placeholder=" Enter Quat1" data-type="currency" name="profitQuat1" id="profitQuat1" class="form-control numeric quotaProfit"  data-relate="firstQuitaProfit" >
							</div>
								<a class="text-info firstQtformonth" >
									Set Monthly Quota
								</a>
								<div class="collapse firstQuita" id="firstQuitaProfit" >
								<div class="row">
									<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="prptMsgQ1" class="text-danger is-invalid"></div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month1">M1 (April) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text"  placeholder="Enter Per Month1" name="pro_per_month1" id="pro_per_month1" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month2">M2 (May) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month2" name="pro_per_month2" id="pro_per_month2" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month3">M3 (June) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon3">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month3" name="pro_per_month3" id="pro_per_month3" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
								</div>
								</div>
        				</div>
							
							<div class="col-sm-6 mb-3">
								<label for="quat2">Second Quarter (July - September) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat2" name="quat2" id="quat2" data-type="currency" class="form-control numeric quota" data-relate="secQuita" >
								</div>
								<a class="text-info secondQtformonth" >
									Set Monthly Quota
								</a>
								<div class="collapse secQuita" id="secQuita">
								<div class="row">
								<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="ptMsgQ2" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month4">M4 (July) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month3" name="per_month4" id="per_month4" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month5">M5 (August) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month5" name="per_month5" id="per_month5" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month6">M6 (September) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month6" name="per_month6" id="per_month6" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
        					<!--SET PROFIT QUOTA-->
        					<div class="col-sm-6 mb-3">
								<label for="profitQuat2">Set Profit For Second Quarter (July - September) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat2" name="profitQuat2" id="profitQuat2" data-type="currency" class="form-control numeric quotaProfit" data-relate="secQuitaProfit" >
								</div>
								<a class="text-info secondQtformonth">
									Set Monthly Quota
								</a>
								<div class="collapse secQuita" id="secQuitaProfit" >
								<div class="row">
								<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="prptMsgQ2" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month4">M4 (July) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month3" name="pro_per_month4" id="pro_per_month4" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month5">M5 (August) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month5" name="pro_per_month5" id="pro_per_month5" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month6">M6 (September) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month6" name="pro_per_month6" id="pro_per_month6" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
							
							
							<div class="col-sm-6 mb-3">
								<label for="quat3">Third Quarter (October - December) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat3" name="quat3" id="quat3" data-type="currency" class="form-control numeric quota"  data-relate="thirdQuita" >
								</div>
								<a class="text-info thirdQtformonth">
									Set Monthly Quota
								</a>
								<div class="collapse thirdQuita" id="thirdQuita" >
								<div class="row">
								   <div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="ptMsgQ3" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month7">M7 (October) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month7" name="per_month7" id="per_month7" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month8">M8 (November) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month8" name="per_month8" id="per_month8" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month9">M9 (December) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month9" name="per_month9" id="per_month9" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
							
							<!---SET PROFIT QUOTA--->
							<div class="col-sm-6 mb-3">
								<label for="profitQuat3">Third Quarter (October - December) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat3" name="profitQuat3" id="profitQuat3" data-type="currency" class="form-control numeric quotaProfit"  data-relate="thirdQuitaProfit" >
								</div>
								<a class="text-info thirdQtformonth">
									Set Monthly Quota
								</a>
								<div class="collapse thirdQuita" id="thirdQuitaProfit" >
								<div class="row">
								   <div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="prptMsgQ3" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month7">M7 (October) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month7" name="pro_per_month7" id="pro_per_month7" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month8">M8 (November) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month8" name="pro_per_month8" id="pro_per_month8" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month9">M9 (December) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month9" name="pro_per_month9" id="pro_per_month9" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
        					
							
							<div class="col-sm-6 mb-3">
								<label for="quat4">Fourth Quarter (January - March) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder="Enter Quat4" name="quat4" id="quat4" data-type="currency" class="form-control numeric quota" data-relate="fourthQuita" >
								</div>
								<a class="text-info fourthQuitaProfit" data-toggle="collapse" href="#fourthQuita" >
									Set Monthly Quota
								</a>
								<div class="collapse fourthQuita" id="fourthQuita" >
								<div class="row">
									<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="ptMsgQ4" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month10">M10 (January) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month10" name="per_month10" id="per_month10" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month11">M11 (Febuary) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month11" name="per_month11" id="per_month11" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="per_month12">M12 (March) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month12" name="per_month12" id="per_month12" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
        					
        					<!---SET PROFIT QUOTA--->
        					
        					<div class="col-sm-6 mb-3">
								<label for="profitQuat4">Fourth Quarter (January - March) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder="Enter Quat4" name="profitQuat4" id="profitQuat4" data-type="currency" class="form-control numeric quotaProfit" data-relate="fourthQuitaProfit" >
								</div>
								<a class="text-info fourthQuitaProfit" >
									Set Monthly Quota
								</a>
								<div class="collapse fourthQuita" id="fourthQuitaProfit" >
								<div class="row">
									<div class="col-sm-1"></div>
									<div class="col-sm-11"><span id="prptMsgQ4" class="text-danger"></div>
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month10">M10 (January) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month10" name="pro_per_month10" id="pro_per_month10" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month11">M11 (Febuary) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month11" name="pro_per_month11" id="pro_per_month11" data-type="currency" class="form-control numeric" >
									</div>
									</div>
									
									<div class="col-sm-1"></div>
									<div class="col-sm-11">
									<label for="pro_per_month12">M12 (March) <span class="text-danger">*</span></label>
									<div class="input-group mb-3">
									  <div class="input-group-prepend">
										<span class="input-group-text">₹ </span>
									  </div>
									  <input type="text" placeholder="Enter Per Month12" name="pro_per_month12" id="pro_per_month12" data-type="currency" class="form-control numeric" >
									</div>
									</div>
								</div>
								</div>
        					</div>
        					
        					
							</div>
        				</div>
						<div class="col-sm-12 form-group text-center">
							<button class="btn btn-info" id="btnsaveData" onclick="savequota();" type="button">Save</button>
						</div>
        		</div>
						
					</form>
                </div>
            </div>
        </div>
		</div>
    
 <?php $this->load->view('footer');?>
 
</div>
<?php $this->load->view('common_footer');?>

<script>

//$('#ajax_datatable').DataTable(); 
function filter_by_fy(){
	var udata=$("#date_filter").val();
    var url ="<?= base_url();?>sales-profit-target?q="+udata;
    window.location = url;
}

 

$(".firstQtformonth").click(function(){
    $("#firstQuitaProfit,#firstQuita").toggle();
});
$(".secondQtformonth").click(function(){
    $(".secQuita").toggle();
});
$(".thirdQtformonth").click(function(){
    $(".thirdQuita").toggle();
});
$(".fourthQuitaProfit").click(function(){
    $(".fourthQuita").toggle();
});


$("#set_quota_pr").keyup(function(){
	$(".monthlyquars").show();
	var set_quota 	= $("#set_quota_pr").val();
	var set_quotas 	= set_quota.replace(/,/g, "");
	var perquart 	= (set_quotas/4);
	var permonth 	= (set_quotas/12);
	$(".quotaProfit").each(function(i, val) {
		$(this).val(numberToIndPrice(perquart.toFixed(2)));
	});
	$("#firstQuitaProfit input,#secQuitaProfit input, #thirdQuitaProfit input, #fourthQuitaProfit input").each(function(i, val) {
		$(this).val(numberToIndPrice(permonth.toFixed(2)));
	});
	$("#notEqual_quota_error").html('');
	$('#btnsaveData').attr('disabled',false); 
});



$("#set_quota").keyup(function(){
	$(".monthlyquars").show();
	var set_quota 	= $("#set_quota").val();
	var set_quotas 	= set_quota.replace(/,/g, "");
	var perquart 	= (set_quotas/4);
	var permonth 	= (set_quotas/12);
	$(".quota").each(function(i, val) {
		$(this).val(numberToIndPrice(perquart.toFixed(2)));
	});
	$("#firstQuita input,#secQuita input, #thirdQuita input, #fourthQuita input").each(function(i, val) {
		$(this).val(numberToIndPrice(permonth.toFixed(2)));
	});
	$("#notEqual_quota_error").html('');
	$('#btnsaveData').attr('disabled',false); 
});


$(".quota,.quotaProfit").keyup(function(){ 
	var qtrlQuota=$(this).val();
	var qtId=$(this).data('relate');
	var qtrlQuota 	= qtrlQuota.replace(/,/g, "");
	var perquart 	= (parseFloat(qtrlQuota)/3);
	$("#"+qtId+" input").val(numberToIndPrice(parseFloat(perquart).toFixed(2)));
});

$(".quotaProfit").change(function(){
	var set_quota = $("#set_quota_pr").val();
	var matches = 0;
	$(".quotaProfit").each(function(i, val) {
		var newVal=$(this).val();
		if(newVal!=""){
		var newVal = newVal.replace(/,/g, "");
	    matches=parseFloat(matches)+parseFloat(newVal);
		}
	});
	var set_quota = set_quota.replace(/,/g, "");
	var total_quat = parseFloat(matches);
	set_quota=set_quota.toString().split(".")[0]
    total_quat=total_quat.toString().split(".")[0];
	
	if(parseFloat(set_quota) != parseFloat(total_quat)){
		  $("#notEqual_quota_error").html('<i class="fas fa-exclamation-triangle" style="margin-right: 7px;color: #ea7468;"></i>Financial year quota and total quarterly quota should be same.');
		  $('#btnsaveData').attr('disabled',true); 
		
	}else{
		$("#notEqual_quota_error").html('');
		$('#btnsaveData').attr('disabled',false); 
	}
});


$(".quota").change(function(){
	var set_quota = $("#set_quota").val();
	var matches = 0;
	$(".quota").each(function(i, val) {
		var newVal=$(this).val();
		if(newVal!=""){
		var newVal = newVal.replace(/,/g, "");
	    matches=parseFloat(matches)+parseFloat(newVal);
		}
	});
	var set_quota = set_quota.replace(/,/g, "");
	var total_quat = parseFloat(matches);
	set_quota=set_quota.toString().split(".")[0]
    total_quat=total_quat.toString().split(".")[0];
	if(parseFloat(set_quota) != parseFloat(total_quat)){
		  $("#notEqual_quota_error").html('<i class="fas fa-exclamation-triangle" style="margin-right: 7px;color: #ea7468;"></i>Financial year quota and total quarterly quota should be same.');
		  $('#btnsaveData').attr('disabled',true); 
		
	}else{
		$("#notEqual_quota_error").html('');
		$('#btnsaveData').attr('disabled',false); 
	}
});


function checkEqualto(quotaId,quartrid,ptMsgQ){
	var matches = 0;
	$("#"+quotaId+" input").each(function(i, val) {
		var newVal=$(this).val();
		if(newVal!=""){
		var newVal = newVal.replace(/,/g, "");
	    matches=parseFloat(matches)+parseFloat(newVal);
		}
	});
	var set_quat1 = $("#"+quartrid).val();
	var set_quaterly = set_quat1.replace(/,/g, "");
	
	set_quaterly=set_quaterly.toString().split(".")[0]
    matches=matches.toString().split(".")[0];
	
	if(parseFloat(set_quaterly) != parseFloat(matches)){
		$("#"+ptMsgQ).html('<i class="fas fa-exclamation-triangle" style="margin-right: 7px;color: #ea7468;"></i>Quarterly Quota and total monthly quota should be same.');
		$('#btnsaveData').attr('disabled',true); 
	}else{
		$("#"+ptMsgQ).html('');
		$('#btnsaveData').attr('disabled',false); 
	}
}

$("#firstQuitaProfit input").change(function(){
	checkEqualto('firstQuitaProfit','profitQuat1','prptMsgQ1');
});
$("#secQuitaProfit input").change(function(){
	checkEqualto('secQuitaProfit','profitQuat2','prptMsgQ2');
});

$("#thirdQuitaProfit input").change(function(){
	checkEqualto('thirdQuitaProfit','profitQuat3','prptMsgQ3');
});
$("#fourthQuitaProfit input").change(function(){
	checkEqualto('fourthQuitaProfit','profitQuat4','prptMsgQ4');
});

$("#firstQuita input").change(function(){
	checkEqualto('firstQuita','quat1','ptMsgQ1');
});
$("#secQuita input").change(function(){
	checkEqualto('secQuita','quat2','ptMsgQ2');
});

$("#thirdQuita input").change(function(){
	checkEqualto('thirdQuita','quat3','ptMsgQ3');
});
$("#fourthQuita input").change(function(){
	checkEqualto('fourthQuita','quat4','ptMsgQ4');
});


// TO VIEW QUOT


function view(qid){
    getQuotaByid(qid)
    $("#setquotaMOdal input").attr('readonly',true);
    $("#setquotaMOdal select").attr('disabled',true);
    $('#setquotaMOdal').modal('show');
}



function getQuotaByid(qid){
     $.ajax({
        url :"<?= base_url('Sales_profit_target/getquotbyid')?>",
        type: "POST",
        data: 'qid='+qid+'&getdata=quota',
        dataType: "JSON",
        success: function(data){ 
            if(data){
                 $("#finacial_year").val(data.finacial_year);
                 $("#sales_users").val(data.user_email);
                 $("#set_quota").val(data.quota);
                 $("#quat1").val(data.quat1);
                 $("#quat2").val(data.quat2);
                 $("#quat3").val(data.quat3);
                 $("#quat4").val(data.quat4);
                 $("#per_month1").val(data.apr_month);
                 $("#per_month2").val(data.may_month);
                 $("#per_month3").val(data.jun_month);
                 $("#per_month4").val(data.jul_month);
                 $("#per_month5").val(data.aug_month);
                 $("#per_month6").val(data.sep_month);
                 $("#per_month7").val(data.oct_month);
                 $("#per_month8").val(data.nov_month);
                 $("#per_month9").val(data.dec_month);
                 $("#per_month10").val(data.jan_month);
                 $("#per_month11").val(data.feb_month);
                 $("#per_month12").val(data.mar_month);
                 
                 $("#set_quota_pr").val(data.profit_quota);
                 $("#profitQuat1").val(data.profit_quat1);
                 $("#profitQuat2").val(data.profit_quat2);
                 $("#profitQuat3").val(data.profit_quat3);
                 $("#profitQuat4").val(data.profit_quat4);
                 $("#pro_per_month1").val(data.profit_apr_month);
                 $("#pro_per_month2").val(data.profit_may_month);
                 $("#pro_per_month3").val(data.profit_jun_month);
                 $("#pro_per_month4").val(data.profit_jul_month);
                 $("#pro_per_month5").val(data.profit_aug_month);
                 $("#pro_per_month6").val(data.profit_sep_month);
                 $("#pro_per_month7").val(data.profit_oct_month);
                 $("#pro_per_month8").val(data.profit_nov_month);
                 $("#pro_per_month9").val(data.profit_dec_month);
                 $("#pro_per_month10").val(data.profit_jan_month);
                 $("#pro_per_month11").val(data.profit_feb_month);
                 $("#pro_per_month12").val(data.profit_mar_month);
                 
                 $(".monthlyquars").show();
                 $("#SetQuarterlyQuota").addClass('show');
                 $(".firstQuita, .secQuita, .thirdQuita, .fourthQuita").show();
            }else{
                toastr.error('Something went wrong in getting data.');
            } 
        }
    });
}


//TO RESET FORM...
$("#btn2").click(function(){
    $('#quota_form')[0].reset();
    $("#setquotaMOdal input").attr('readonly',false);
    $("#setquotaMOdal select").attr('disabled',false);
    $(".monthlyquars").hide();
    $("#SetQuarterlyQuota").removeClass('show');
    $(".firstQuita, .secQuita, .thirdQuita, .fourthQuita").hide();
});


// TO UPDATE MODAL OPEN

function update(qid){
    $("#setquotaMOdal input").attr('readonly',false);
    $("#setquotaMOdal select").attr('disabled',false);
    getQuotaByid(qid)
    $('#setquotaMOdal').modal('show');
}




// TO SAVE QUOTA AND PRICE.......
 function savequota()
    {
        
		if(checkValidationQuota()==true){
        $('#btnsaveData').text('Saving...'); //change button text
        $('#btnsaveData').attr('disabled',true); //set button disable
        var url;
        url = "<?= base_url('Sales_profit_target/createquota')?>";
        var dataString = $("#quota_form").serialize();
        
        $.ajax({
            url : url,
            type: "POST",
            data: dataString,
            dataType: "JSON",
            success: function(data)
            {  
              if(data.status) 
              {  
                  $('#setquotaMOdal').modal('hide');
				  toastr.success('Sales Quota & sales profit has been created successfully.');
                  //window.location.reload();
              }
              $('#btnsaveData').text('Save'); //change button text
              $('#btnsaveData').attr('disabled',false); //set button enable

              if(data.st==202)
              {
				toastr.error('Something went wrong, Please try later.');  
                  $("#finacial_year_error").html(data.name);
                  $("#sales_users_error").html(data.org_name);
                  $("#set_quota_error").html(data.contact_name);
              }
              else if(data.st==200)
              {
                  $("#finacial_year_error").html('');
                  $("#sales_users_error").html('');
                  $("#set_quota_error").html('');
                 
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                toastr.error('Something went wrong, Please try later.'); 
                $('#btnsaveData').text('Save'); //change button text
                $('#btnsaveData').attr('disabled',false); //set button enable
            }
        });
		}
    }
	
	function changeClr(idinpt){
	  $('#'+idinpt).css('border-color','red');
	  $('#'+idinpt).focus();
	  setTimeout(function(){ $('#'+idinpt).css('border-color',''); },3000);
	}

	
	function checkValidationQuota(){
	  var finacial_year = $('#finacial_year').val();
	  var sales_users = $('#sales_users').val();
	  var set_quota    = $('#set_quota').val();
	  //alert(sales_users);
		if(finacial_year=="" || finacial_year===undefined){
		  changeClr('finacial_year');
		  return false;
		}else if(sales_users=="" || sales_users===undefined){
		  changeClr('sales_users');
		  return false;
		}else if(set_quota=="" || set_quota===undefined){
		  changeClr('set_quota');
		  return false;
		}else{
		  return true;
		} 
}
$(".form-control").keyup(function(){
     $(this).css('border-color','');
});	
$(".form-control").change(function(){
     $(this).css('border-color','');
});


function getfilterdData(e,f,g,h=null){

var id = "#" + g;
$(id).val(e);

if(f!="null"){
window[f]();
}
   
 
}


</script>

