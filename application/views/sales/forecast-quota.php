<?php $this->load->view('common_navbar');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<style>
.timeline-one .events ul li a {
    font-size: 12px;
    top: -30px;
    font-weight: 600;
}
.timeline-one .events ul li {
    width: 24%;
}
.timeline-one .events ul li .selected_gray:after {
    background: #606060;
}
.timeline-one .events{
  margin: 16px 0;
  height: 2px;
}
.timeline-one{
  height: auto;
}
.content .card .card-body table tbody button.btn.btn-info {
  border-radius: 0px;
  width: auto;
  margin: 0 auto;
  display: inline-block;
  background: #284255;
}
#filterMdl {
    position: fixed;
    margin: auto;
    width: 400px;
    height: 100%;
    right: 0px;
}
.small-box{
 border-radius:12px;
background-color:#fff;
margin:12px;
margin-bottom:22px;}

div.staff-button button.btnstop{
    border: 1px solid #ccc; 
    border-radius: 4px;
    background: #845ADF;
    color: #fff;
    font-weight:600;
  }

  div.staff-button button.btncorner {
   
   border-radius: 4px;
   background: #26BF941A  ;
   color: #26BF94 ;
   font-weight:600;
 }

 div.staff-button button.btncorner:hover {
   background:#26BF94 ;
   color: #fff; 
 }
 
 h4 {
  font-size: clamp(0.5rem, 1vw, 1rem) !important;
}

h3 {
  font-size: clamp(0.6rem, 1.2vw, 1.2rem) !important;
}

@media (max-width:1350px) {
	.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
    font-size: 0.9rem !important;
}
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Forecast and Quota</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
              <li class="breadcrumb-item active">Forecast and Quota</li>
            </ol>
          </div><!-- /.col -->
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
        <div class="card org_div">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div class="dropdown staff-button">
                  <button class="btn btncorner dropdown-toggle" type="button" data-toggle="dropdown" >
                      <span></span>My Team<span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
				  
				  <?php if(check_permission_status('Receive Forecast and Quota (All Users)','other')==true){ ?>
                    <li><a href="<?=base_url();?>forecast?q=team">My Team</a></li>
				  <?php } ?>
                      <li selected ><a href="<?=base_url();?>forecast?q=self">My Self</a></li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="dropdown staff-button text-right">
				 <?php if($this->session->userdata('type') == 'admin'){ ?>
                 <!--<button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#setquotaMOdal" id="btn2"><i class="fas fa-filter"></i>Set Quota</button>-->
				<?php } ?>
                  <button type="button" class="btn btnstop" data-toggle="modal" data-target="#exampleModalScrollable" id="btn1"><i class="fas fa-filter"></i>Filter</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ffcba4 ;display: flex; align-items: center;">
			<i class="fa-solid fa-layer-group fa-2xl" style="color: #c7c6c6;font-size:44px;padding-left:7px;"></i>
              <div class="inner animate__animated animate__flipInX" style="margin-left: 7px;">
                <h4>Quota</h4>
                <h3 id="fullquotaSet" style="font-size:24px;">0.00</h3>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #ace1af;display: flex; align-items: center;">
			<i class="fa-solid fa-layer-group fa-2xl" style="color: #c7c6c6;font-size:44px;padding-left:7px;"></i>
              <div class="inner animate__animated animate__flipInX" style="margin-left: 7px;">
                <h4>Closed Won</h4>
                <h3 id="fullCloseWon" style="font-size:24px;">0.00</h3>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="border-left:7px solid #dda0dd;display: flex; align-items: center;">
			<i class="fa-solid fa-layer-group fa-2xl" style="color: #c7c6c6;font-size:44px;padding-left:7px;"></i>
              <div class="inner animate__animated animate__flipInX" style="margin-left: 7px;">
                <h4>Gap</h4>
                <h3 id="totalGap" class="text-danger" style="font-size:24px;">0.00</h3>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
			<div class="small-box" style="border-left:7px solid #45b1e8; display: flex; align-items: center;">
    <i class="fa-solid fa-layer-group fa-2xl" style="color: #c7c6c6;font-size:44px;padding-left:7px;"></i>
    <div class="inner animate__animated animate__flipInX" style="margin-left: 7px;">
        <h4 >Pipeline</h4>
        <h3 id="fullPipeline" style="font-size:24px;" >0.00</h3>
    </div>


              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
    </section>

<style>
.listViewSubHeader{
	width:10%;
}.listViewTd{
	width: 9.5%;
}
.spanCircle{
	margin-right: 8px;
    background: #ffffff;
    color: #a0a1a2;
    padding: 7px 14px;
    border-radius: 50%;
    font-size: 19px;
    font-weight: 700;
}
.monthly{
    display:none;
}
.annually{
    display:none;
}
</style>
    <!-- /.content -->
    <section class="content">
      <div class="container-fluid" >
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div" style="border-radius:7px ; padding:6px;">
              <!-- /.card-header -->
              <div class="card-body">
                  <?php 
				$fiscal_year_for_date = calculateFiscalYearForDate(date('m'));
				$dateToGet=explode(':',$fiscal_year_for_date);
				
				$date=date_create($dateToGet[0]);
				$date2=date_create($dateToGet[1]);
				?>
				<div class="table-responsive">
                <table id="dt-multi-checkbox" class="table table-bordered table-responsive-lg " cellspacing="0" width="100%">
                  <thead class="thead-light">
                    <tr>
                        <th class="text-left" style="min-width: 225px;">Time Period : Q1 FY <?=date_format($date,"Y");?>-Q4 FY <?=date_format($date2,"Y");?></th>
                        <th colspan="3" class="text-center quotaTd">Quota</th>
                        <th colspan="7" class="text-center forecastTd">Forecast</th>
                    </tr>
                   </thead>

                  
                <tr>
                    <td></td>
                    <td class="listViewSubHeader quotaTd"><b>Quota</b></td>
                    <td class="listViewSubHeader quotaTd"><b>Closed Won</b></td>
                    <td class="listViewSubHeader quotaTd"><b>Gap</b> 
					  <i title="Gap is difference between quota and closed won" class="fa fa-info-circle fa-sm"></i></td>
                    <td class="listViewSubHeader forecastTd"><b>Pipeline</b></td>
                    <td class="listViewSubHeader forecastTd"><b>Best Case</b></td>
                    <td class="listViewSubHeader forecastTd"><b>Commit</b></td>
                    <td class="listViewSubHeader forecastTd"><b>Funnel&nbsp;Total</b></td>
                    </tr>
                    <tbody class="qtrl">

<?php
$totalWonG  = 0;
$totalPipeG = 0;
$totalGapG  = 0;
$totalQuotaG= 0;

$totalWonGQ	 = 0;
$totalPipeGQ = 0;
$totalGapGQ	 = 0;
$totalQuotaGQ= 0;

$nextYear = date("Y", strtotime(" +1 Year"));
 for($m=1; $m<=4; $m++){ 
	if(($m==1 && count($firstData)>0) || ($m==2 && count($secData)) || ($m==3 && count($thrdData)) || ($m==4 && count($frthData)>0) ){
		
		if($m==1){
			$dataRow=$firstData;
		}else if($m==2){
			$dataRow=$secData;
		}else if($m==3){
			$dataRow=$thrdData;
		}else if($m==4){ 
			$dataRow=$frthData;
		}
		
		$CloseWonY		= array_sum(array_column($dataRow, 'won'));
		$pipelineY		= array_sum(array_column($dataRow, 'pipeline'));
		$bestY			= array_sum(array_column($dataRow, 'best'));
		$commitY		= array_sum(array_column($dataRow, 'commit'));
		$setquotaY		= array_column($dataRow, 'quotadata');
		$sumsetquotaY	= array_sum(array_column($setquotaY, 'quat'.$m));
		
		if(isset($CloseWonY) && $CloseWonY==""){
			$CloseWonY=0;
		}
		if(isset($sumsetquotaY) && $sumsetquotaY==""){
			$sumsetquotaY=0;
		}
		
		$totalGap=($sumsetquotaY-$CloseWonY);
		
		$totalWonGQ	 = $totalWonG+$CloseWonY;
		$totalPipeGQ = $totalPipeG+$pipelineY;
		$totalGapGQ	 = $totalGapG+$totalGap;
		$totalQuotaGQ= $totalQuotaG+$sumsetquotaY;
		
 ?>
         <tr data-toggle="collapse" data-target="#accordion<?=$m;?>" class="clickable">
                    <td><i class="fa mr-2 fa-chevron-down"></i>Q<?=$m;?> FY <?php if($m==4){ echo date_format($date2,"Y");}else{ echo date_format($date,"Y"); } ?></td>
                    <td class="quotaTd"><span>₹<?=IND_money_format($sumsetquotaY);?></span></td>
                    <td class="quotaTd"><a href="javascript:;" >₹<?=IND_money_format($CloseWonY);?></a></td>
                    <td class="quotaTd">
						<?php 
						if (isset($totalGap)){
							if (substr(strval($totalGap), 0, 1) == "-"){
								?>
							<span class="text-success">
								<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$totalGap));?>
							</span>
							<?php
							} else {
								?>
							<span class="text-danger">
								<span>(-)</span>&nbsp;₹<?=IND_money_format($totalGap);?>
							</span>
							<?php
							}
						}
						
						?>
                        
                    </td>
                        <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($pipelineY);?></a></td>
                        <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($bestY);?></a></td>
                        <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($commitY);?></a></td>
                        <td class="forecastTd">₹<?=IND_money_format($pipelineY);?></td>
                    </tr>
					<tr id="accordion<?=$m;?>" class="collapse">
					
                      <td colspan="8" style="padding: 0px;">
                            <table style="width:100%">
							<?php 
							 
							for($r=0; $r<count($dataRow); $r++){
								if($dataRow[$r]['owner']!=""){
							   
								$quota=$dataRow[$r]['quotadata'];
								if(isset($quota['quat'.$m])){ $userQuota=$quota['quat'.$m]; }else{ $userQuota=0; }
								
								$wonUs  	 = $dataRow[$r]['won'];
								if(isset($wonUs) && $wonUs==""){
									$wonUs=0;
								}
								if(is_numeric($userQuota) && is_numeric($wonUs)){
									$totalGapus	 = $userQuota-$wonUs;
								}else{
									$totalGapus  = $wonUs;
								}
							
							
							?>
							
                                <tr class="">
								<td style="width: 29%;" class="addWidth"><span class="spanCircle"><i class="far fa-user"></i></span><?=ucwords($dataRow[$r]['owner']); 
								
								?>
								</td>
                                  <td class="listViewTd quotaTd"><span><?php if(isset($quota['quat'.$m])){ echo "₹".IND_money_format($quota['quat'.$m]); }else{ echo "Not Set"; } ?></span></td>
                                  <td  class="listViewTd quotaTd"><a href="javascript:;">₹<?=IND_money_format($wonUs);?></a></td>
                                  <td  class="listViewTd quotaTd">
                                      <?php 
									if (isset($totalGapus)){
										if (substr(strval($totalGapus), 0, 1) == "-"){
											?>
										<span class="text-success">
											<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$totalGapus));?>
										</span>
										<?php
										} else {
											?>
										<span class="text-danger">
											<span>(-)</span>&nbsp;₹<?=IND_money_format($totalGapus);?>
										</span>
										<?php
										}
									}
									
									?>
                                  </td>
                                  <td  class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['pipeline']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['best']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['commit']);?></a></td>
                                  <td class="listViewTd forecastTd"><?=IND_money_format($dataRow[$r]['pipeline']);?></td>
                                </tr>
							<?php } } ?>
                            </table>
                      </td>
                    </tr>
<?php } }  ?>
</tbody>
<tbody class="monthly">
<?php
#############################
#       Monthly Wise        #
#############################

	$totalWon=0;
	$totalpipeline=0;

$d=4;
 for($m=1; $m<=12; $m++){
     if($d>12){
     $d=1;
     }

	    $nextDate	= date('Y-'.$d.'-d');
	    $date		= date_create($nextDate);
	    $dateYear   = date_format($date,'F');
	    $dateMonth  = date_format($date,'M');
		
	    $monthly[$dateMonth];
		
	     $d++;
	    if(count($monthly[$dateMonth])>0 && $monthly[$dateMonth][$dateYear]>0){
	          $forQuota=$monthly[$dateMonth];
			  $colmn=strtolower($dateMonth."_month");
			  
			$setquotaY		= array_column($forQuota, 'quotadata');  
			$sumsetquotaY	= array_sum(array_column($setquotaY, $colmn));
			$closeWoneDt	= $monthly[$dateMonth][$dateYear.'won'];
			if(isset($closeWoneDt) && $closeWoneDt==""){
				$closeWoneDt=0;
			}
			if($sumsetquotaY!=""){
			$totalGap		= ($sumsetquotaY-$closeWoneDt);
			}else{
				$totalGap		= $closeWoneDt;
			}
			  
 ?>
                    <tr data-toggle="collapse" data-target="#accordion<?=$dateMonth;?>" class="clickable">
                        <td><i class="fa mr-2 fa-chevron-down"></i><?=$dateYear;?></td>
                        <td class="quotaTd"><span>₹<?=IND_money_format($sumsetquotaY);?></span></td>
                        <td class="quotaTd"><a href="javascript:;" id="ClosedWonPt">₹ <?=IND_money_format($monthly[$dateMonth][$dateYear.'won']);?></a></td>
                        <td  class="quotaTd">
                            <?php 
						if (isset($totalGap)){
							if (substr(strval($totalGap), 0, 1) == "-" || $sumsetquotaY==""){
								?>
							<span class="text-success">
								<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$totalGap));?>
							</span>
							<?php
							} else {
								?>
							<span class="text-danger">
								<span>(-)</span>&nbsp;₹<?=IND_money_format($totalGap);?>
							</span>
							<?php
							}
						}
						
						?>
                        </td>
                        <td class="forecastTd"><a href="javascript:;" id="pipeLine">₹ <?=IND_money_format($monthly[$dateMonth][$dateYear]);?></a></td>
                        <td class="forecastTd"><a href="javascript:;" id="bestCase">₹ <?=IND_money_format($monthly[$dateMonth][$dateYear.'best']);?></a></td>
                        <td class="forecastTd"><a href="javascript:;" id="commit">₹ <?=IND_money_format($monthly[$dateMonth][$dateYear.'commit']);?></a></td>
                        <td class="forecastTd">₹<?=IND_money_format($monthly[$dateMonth][$dateYear]);?></td>
                    </tr>
					<tr id="accordion<?=$dateMonth;?>" class="collapse">
					
                      <td colspan="8" style="padding: 0px;">
                            <table style="width:100%">
							<?php 
							$dataRow=$monthly[$dateMonth];
							$totatQt=0;
							for($r=0; $r<(count($dataRow)-4); $r++){
								if($dataRow[$r]['owner']){
							    if($dataRow[$r]['won']!=""){
									$wonprice=$dataRow[$r]['won'];
								}else{
									$wonprice=0;
								}
								if($dataRow[$r]['pipeline']){
									$pipeprice=$dataRow[$r]['pipeline'];
								}else{
									$pipeprice=0;
								}
								
								if($dataRow[$r]['best']){
									$bestprice=$dataRow[$r]['best'];
								}else{
									$bestprice=0;
								}
								if($dataRow[$r]['commit']){
									$commitprice=$dataRow[$r]['commit'];
								}else{
									$commitprice=0;
								}
								
								$totalWon=($totalWon+$wonprice);
								$totalpipeline=$totalpipeline+$pipeprice;
								
							$setQuotVl=$forQuota[$r]['quotadata'];
							
							if(isset($setQuotVl[$colmn])){ 
								//echo "₹ ".IND_money_format($setQuotVl[$colmn]);
								$totatQt=$totatQt+$setQuotVl[$colmn];
							}else{ 
								//echo "Not Set"; 
							} 
							if(isset($setQuotVl[$colmn]) && $setQuotVl[$colmn]!="" ){
							$gapValue=((int)$setQuotVl[$colmn]-(int)$dataRow[$r]['won']);
							}else{
								$gapValue=$dataRow[$r]['won'];
							}
							?>
							
                                <tr class="">
								<td style="width: 29%;" class="addWidth"><span class="spanCircle"><i class="far fa-user"></i></span><?=ucwords($dataRow[$r]['owner']);?></td>
                                  <td class="listViewTd quotaTd"><span><?php if(isset($setQuotVl[$colmn])){ echo "₹ ".IND_money_format($setQuotVl[$colmn]);}else{ echo "Not Set"; } ?></span></td>
                                  <td  class="listViewTd quotaTd"><a href="`javascript:;">₹<?=IND_money_format($dataRow[$r]['won']);?></a></td>
                                  <td  class="listViewTd quotaTd">
                                    <?php 
									if (isset($gapValue)){
										if (substr(strval($gapValue), 0, 1) == "-" || !isset($setQuotVl[$colmn])){ ?>
										<span class="text-success">
											<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$gapValue));?>
										</span>
										<?php } else { ?>
										<span class="text-danger">
											<span>(-)</span>&nbsp;₹<?=IND_money_format($gapValue);?>
										</span>
									<?php } } ?>
                                  </td>
                                  <td  class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['pipeline']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['best']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['commit']);?></a></td>
                                  <td class="listViewTd forecastTd">₹00</td>
                                </tr>
							<?php } } ?>
                            </table>
                      </td>
                    </tr>
<?php } } ?>

                    
                  </tbody>
				  
<tbody class="annually">
<?php
#############################
#       Annually Wise       #
#############################
$totalWonG=0;
$totalPipeG=0;
$totalGapG=0;
$totalQuotaG=0;
if(count($annually)>0){
		$finDate=$annually[0]['dataDate'];
		$finDateexp=explode(":",$finDate);
	    $date=date_create($finDateexp[0]);
	    $dateYear   =date_format($date,'Y');
		
		
		$CloseWonY		= array_sum(array_column($annually, 'won'));
		$pipelineY		= array_sum(array_column($annually, 'pipeline'));
		$bestY			= array_sum(array_column($annually, 'best'));
		$commitY		= array_sum(array_column($annually, 'commit'));
		$setquotaY		= array_column($annually, 'quotadata');
		$sumsetquotaY	= array_sum(array_column($setquotaY, 'quota'));
		
		if(isset($CloseWonY) && $CloseWonY==""){
			$CloseWonY=0;
		}
		if($sumsetquotaY!=""){
			$totalGap		= ($sumsetquotaY-$CloseWonY);
		}else{
			$totalGap		= $CloseWonY;
		}
		
$totalWonG	= $CloseWonY;
$totalPipeG	= $pipelineY;
$totalGapG	= $totalGap;
$totalQuotaG= $sumsetquotaY;
		
 ?>
        <tr data-toggle="collapse" data-target="#accordion<?=$m;?>" class="clickable">
            <td><i class="fa mr-2 fa-chevron-down"></i>Financial Year <?php echo $dateYear." - ".($dateYear+1); ?></td>
            <td class="quotaTd"><span id="setQuota">₹<?=IND_money_format($sumsetquotaY);?></span></td>
            <td class="quotaTd"><a href="javascript:;">₹<?=IND_money_format($CloseWonY);?></a></td>
            <td class="quotaTd">
                <?php 
				if (isset($totalGap)){
					if (substr(strval($totalGap), 0, 1) == "-" || $sumsetquotaY==""){ ?>
						<span class="text-success">
							<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$totalGap));?></span>
						<?php
					} else { ?>
						<span class="text-danger">
							<span>(-)</span>&nbsp;₹<?=IND_money_format($totalGap);?>
							</span>
				<?php } } ?>
            </td>
            <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($pipelineY);?></a></td>
            <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($bestY);?></a></td>
            <td class="forecastTd"><a href="javascript:;" >₹<?=IND_money_format($commitY);?></a></td>
            <td class="forecastTd" id="funnelData<?=$m;?>">₹00</td>
        </tr>
		<tr id="accordion<?=$m;?>" class="collapse">
			<td colspan="8" style="padding: 0px;">
                <table style="width:100%">
					<?php 
					$dataRow=$annually;
					for($r=0; $r<count($dataRow); $r++){
						if($dataRow[$r]['owner']!=""){
							$quota=$dataRow[$r]['quotadata'];
							
							$userQuotaA = $quota['quota'];
							$userClosewn= $dataRow[$r]['won'];
							if(isset($userClosewn) && $userClosewn==""){
								$userClosewn=0;
							}
							if(isset($userQuotaA) && $userQuotaA!=""){
								$userGap=$userQuotaA-$userClosewn;
							}else{
								$userGap=$userClosewn;
							}
							?>
							
                            <tr class="">
								<td style="width: 29%;" class="addWidth"><span class="spanCircle"><i class="far fa-user"></i></span><?=ucwords($dataRow[$r]['owner']); 
								
								?>
								</td>
                                  <td class="listViewTd quotaTd"><span><?php if(isset($quota['quota'])){ echo "₹ ".IND_money_format($quota['quota']); }else{ echo "Not Set"; } ?></span></td>
                                  <td  class="listViewTd quotaTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['won']);?></a></td>
                                  <td  class="listViewTd quotaTd">
                                      <?php 
									if (isset($userGap)){
										if (substr(strval($userGap), 0, 1) == "-" || $userQuotaA==""){ ?>
											<span class="text-success">
												<span>(+)</span>&nbsp;₹<?=IND_money_format(str_replace("-","",$userGap));?></span>
											<?php
										} else { ?>
											<span class="text-danger">
												<span>(-)</span> ₹<?=IND_money_format($userGap);?>
												</span>
									<?php } } ?>
                                  </td>
                                  <td  class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['pipeline']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['best']);?></a></td>
                                  <td class="listViewTd forecastTd"><a href="javascript:;">₹<?=IND_money_format($dataRow[$r]['commit']);?></a></td>
                                  <td class="listViewTd forecastTd"><?=IND_money_format($dataRow[$r]['pipeline']);?></td>
                                </tr>
							<?php } } ?>
                            </table>
                      </td>
                    </tr>
<?php }  ?>
                    
                  </tbody>  
				  
				  
                </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row (main row) -->
		
      </div><!-- /.container-fluid -->
    </section>
  </div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable" id="filterMdl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Filter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>View By</label>
                </div>
                <div class="col-md-8">
                  <select class="form-control" id="viewby">
                    <option value="Monthly">Monthly</option>
                    <option selected value="Quaterly">Quaterly</option>
                   <option value="Annually">Annually (Financial Year)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Forecast Type</label>
                </div>
                <div class="col-md-8">
                  <select class="form-control">
                    <option>Amount</option>
                    <option>Weighted Revenue</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Currency</label>
                </div>
                <div class="col-md-8">
                  <select class="form-control">
                    <option>My Prefered Currency</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-4">
                  <label>Show</label>
                </div>
                <div class="col-md-8">
                  <label><input type="radio" name="showby" value="1">Quota</label> &nbsp;
                  <label><input type="radio" name="showby" value="2">Forecast</label>&nbsp;
                  <label><input type="radio" name="showby" checked value="3">Both</label>
                </div>
              </div>
            </div>
           
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="applyBtn" class="btn btn-info">Apply</button>
          <a href="#" data-dismiss="modal">Cancel</a>         
        </div>
      </div>
    </div>
  </div>



<!-- Add data modal -->
    <div class="modal fade" id="setquotaMOdal" data-keyboard="false" data-backdrop="static" >
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
							
        					<div class="col-sm-12">
							<label for="set_quota">Set Quota <span class="text-danger">*</span></label>
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
								<span class="input-group-text">₹ </span>
							  </div>
							  <input type="text" placeholder=" Enter Quota"   data-type="currency" name="set_quota" id="set_quota" class="form-control numeric" aria-describedby="basic-addon3">
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
							<div class="row">
							<div class="col-sm-1"></div>
							<div class="col-sm-11 mb-3">
								<label for="quat1">First Quarter (April - June)  <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text" placeholder=" Enter Quat1" data-type="currency" name="quat1" id="quat1" class="form-control numeric quota"  data-relate="firstQuita" >
								</div>
								<a class="text-info" data-toggle="collapse" href="#firstQuita" >
									Set Monthly Quota
								</a>
								<div class="collapse" id="firstQuita" >
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
							
							<div class="col-sm-1"></div>
							<div class="col-sm-11 mb-3">
								<label for="quat2">Second Quarter (July - September) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat2" name="quat2" id="quat2" data-type="currency" class="form-control numeric quota" data-relate="secQuita" >
								</div>
								<a class="text-info" data-toggle="collapse" href="#secQuita">
									Set Monthly Quota
								</a>
								<div class="collapse" id="secQuita" >
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
							
							<div class="col-sm-1"></div>
							<div class="col-sm-11 mb-3">
								<label for="quat3">Third Quarter (October - December) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder=" Enter Quat3" name="quat3" id="quat3" data-type="currency" class="form-control numeric quota"  data-relate="thirdQuita" >
								</div>
								<a class="text-info" data-toggle="collapse" href="#thirdQuita">
									Set Monthly Quota
								</a>
								<div class="collapse" id="thirdQuita" >
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
							
							
							<div class="col-sm-1"></div>
							<div class="col-sm-11 mb-3">
								<label for="quat4">Fourth Quarter (January - March) <span class="text-danger">*</span></label>
								<div class="input-group">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon3">₹ </span>
								  </div>
								  <input type="text"  placeholder="Enter Quat4" name="quat4" id="quat4" data-type="currency" class="form-control numeric quota" data-relate="fourthQuita" >
								</div>
								<a class="text-info" data-toggle="collapse" href="#fourthQuita" >
									Set Monthly Quota
								</a>
								<div class="collapse" id="fourthQuita" >
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
							</div>
        				</div>
        				</div>
						<div class="col-sm-12 form-group text-center">
							<button class="btn btn-info" id="btnsaveData" onclick="savequota();" type="button">Save</button>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
          <!-- Add data modal -->

</div>
<!-- ./footer -->

<?php $this->load->view('common_footer');?>
   <?php 
	if (isset($totalGapG)){
		if (substr(strval($totalGapG), 0, 1) == "-"){ ?>
			<script> $("#totalGap").html(' (+) &nbsp; ₹ <?=IND_money_format(str_replace("-","",$totalGapG));?>'); </script>
			<?php
		} else { ?>
			<script> $("#totalGap").html('(-)&nbsp; ₹ <?=IND_money_format($totalGapG);?> '); </script>
	<?php } } ?>
<script>
$("#fullCloseWon").html("₹ <?=IND_money_format($totalWonG);?>");
//$("#totalGap").html("₹ <?=IND_money_format($totalGapG);?>");
$("#fullPipeline").html("₹ <?=IND_money_format($totalPipeG);?>");
$("#fullquotaSet").html("₹ <?=IND_money_format($totalQuotaG);?>");


$("#applyBtn").click(function(){
    var viewby=$("#viewby").val();
    if(viewby=='Monthly'){
        $(".qtrl, .annually").hide();
        $(".monthly").show();
    }else if(viewby=='Annually'){
        $(".qtrl,.monthly").hide();
        $(".annually").show();
    }else{
       $(".monthly, .annually").hide();
       $(".qtrl").show();
    }
    
   var radioVl= $('input[name="showby"]:checked').val();
   if(radioVl=='1'){
       $(".addWidth").css('width','67%');
        $(".forecastTd").hide();
        $(".quotaTd").show();
    }else if(radioVl=='2'){
       $(".addWidth").css('width','57%');
       $(".quotaTd").hide();
       $(".forecastTd").show();
    }else{
        $(".addWidth").css('width','29%');
        $(".quotaTd").show();
        $(".forecastTd").show();
    }
    $("#exampleModalScrollable").modal('hide');
});



$("#set_quota").keyup(function(){
	$(".monthlyquars").show();
	var set_quota 	= $("#set_quota").val();
	var set_quotas 	= set_quota.replace(/,/g, "");
	var perquart 	= (set_quotas/4);
	var permonth 	= (set_quotas/12);
	$(".quota").each(function(i, val) {
		$(this).val(numberToIndPrice(perquart));
	});
	$("#firstQuita input,#secQuita input, #thirdQuita input, #fourthQuita input").each(function(i, val) {
		$(this).val(numberToIndPrice(permonth));
	});
});


$(".quota").keyup(function(){ 
	var qtrlQuota=$(this).val();
	var qtId=$(this).data('relate');
	var qtrlQuota 	= qtrlQuota.replace(/,/g, "");
	var perquart 	= (parseFloat(qtrlQuota)/3);
	$("#"+qtId+" input").val(numberToIndPrice(parseFloat(perquart)));

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
	if(parseFloat(set_quaterly) != parseFloat(matches)){
		$("#"+ptMsgQ).html('<i class="fas fa-exclamation-triangle" style="margin-right: 7px;color: #ea7468;"></i>Quarterly Quota and total monthly quota should be same.');
		$('#btnsaveData').attr('disabled',true); 
	}else{
		$("#"+ptMsgQ).html('');
		$('#btnsaveData').attr('disabled',false); 
	}
}

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
</script>

<script>
    function savequota()
    {
        
		if(checkValidationQuota()==true){
        $('#btnsaveData').text('saving...'); //change button text
        $('#btnsaveData').attr('disabled',true); //set button disable
        var url;
        url = "<?= base_url('forecast/createquota')?>";
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
				  toastr.success('Sales Quota has been created successfully.');
                  //window.location.reload();
              }
              $('#btnsaveData').text('save'); //change button text
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
                $('#btnsaveData').text('save'); //change button text
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
</script>
<script>

$("input[data-type='currency']").on({
	
    keyup: function() {
		
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  //return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  return n.replace(/\D/g, "").replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val =  left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;
    
    // final formatting
    if (blur === "blur") {
      input_val += ".00";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}

</script>