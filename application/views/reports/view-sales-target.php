<!-- common header include -->
<?php $this->load->view('common_navbar');?>
<!-- common header include -->
<style>
    .content-header {background: #f2f2f2;}
   
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                             <li class="list-group-item text-center"><a href="<?=base_url('sales-profit-target');?>"><div><img src="https://img.icons8.com/ultraviolet/18/000000/circled-left.png"/></div>Back</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main" class="content">
        <div class="container-fluid">
            <div class="accordion" id="faq">
                <div class="card" >
                    <div class="card-header" id="faqhead1" > <a href="#" class="btn btn-header-link " data-toggle="collapse" data-target="#faq1" aria-expanded="true" aria-controls="faq1"><img src="https://img.icons8.com/bubbles/28/000000/sales-performance.png"/>Genearal Details</a>
                    </div>
                    <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <b>User Name</b>
                                    <p><?php 
                                    $userName = $this->uri->segment(3); 
                                    echo $userName;
                                    ?>
                                    </p>
                                </div>
                                <div class="col">
                                    <b>Financial Year</b>
                                    <p><?=$salesQuota['finacial_year']?></p>
                                </div>
                                <div class="col">
                                    <b>Total Sales Target</b>
									
                                    <p>₹ <?=IND_money_format($salesQuota['quota']);?>/-</p>
                                </div>
                                <div class="col">
                                    <b>Total Profit Target</b>
                                    <p>₹ <?=IND_money_format($salesQuota['profit_quota']);?>/-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!---Quartrly--->
                <div class="card">
                    <div class="card-header" id="faqhead2" > <a href="#faq2" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="true" aria-controls="faq2" ><img src="https://img.icons8.com/fluent/28/000000/total-sales-1.png"/> Sales Detail Quarterly</a>
				
                    </div>
                    <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
						<div class="card-body">
							<!-- <div>
								<form id="salesquarterfilterform">
                               <input type="text" id="quarsales_input" name="org_name" oninput="filterbydata();">
							   
							   </form>
                               </div> -->

						    <div class="row">
						        <table class="table">
						            <tr>
						            <th>Quarter Name</th>
						            <th>Set Sales Quota</th>
						            <th>Achieved Sales Quota</th>
						            <th>Gap Sales Quota</th>
						            <th>Performance (%)</th>
						            </tr>
						            <tr>
									
						            <td>First Quarter</td>
						            <td>₹ <?=IND_money_format($salesQuota['quat1']);?>/-</td>
						            <td>₹ <?=IND_money_format($firstQtrSales['sales']);?>/-</td>
						            <td>₹ <?php
						            if(is_numeric($salesQuota['quat1'])===true && is_numeric($firstQtrSales['sales'])===true){
						           $gap= $salesQuota['quat1']-$firstQtrSales['sales'];  
						            }else{
						               $gap=0; 
						            }
						            
						    if (isset($gap)){
							if (substr(strval($gap), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gap));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gap);?>
							</span>
							<?php } 	}  ?>
				            </td>
						            
				            <td>
				            <?php 
				            if(is_numeric($salesQuota['quat1'])===true && is_numeric($firstQtrSales['sales'])===true){
				                $achieved_percent = $firstQtrSales['sales']/$salesQuota['quat1'] * 100;
                                $perct= round($achieved_percent,2);
                                echo $perct;
				            }else{
				                echo 0;
				            }
				            ?>&nbsp;&nbsp;%</td>
						            
			           	 </tr>
					
            	 <tr>
						 
				            <td>Second Quarter</td>
				            <td>₹ <?=IND_money_format($salesQuota['quat1']);?>/-</td>
				            <td>₹ <?=IND_money_format($secondQtrSales['sales']);?>/-</td>
				            <td>₹ <?php
				             if(is_numeric($salesQuota['quat2'])===true && is_numeric($secondQtrSales['sales'])===true){ 
				               $gap2= $salesQuota['quat2']-$secondQtrSales['sales'];
				             }else{
				                 $gap2=0;
				             }
				            if (isset($gap2)){
							if (substr(strval($gap2), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gap2));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gap2);?>
							</span>
							<?php } 	}  ?>
						</td>
		                <td>
				            <?php 
				             if(is_numeric($salesQuota['quat2'])===true && is_numeric($secondQtrSales['sales'])===true){ 
				                $achieved_percent = $secondQtrSales['sales']/$salesQuota['quat2'] * 100;
	                            $perct= round($achieved_percent,2);
	                            echo $perct;
				             }else{
				                 echo 0;
				             }
				            ?>&nbsp;&nbsp;%</td>
       					</tr>
						       <tr>
						
			            <td>Third Quarter</td>
			            <td>₹ <?=IND_money_format($salesQuota['quat1']);?>/-</td>
			            <td>₹ <?=IND_money_format($thirdQtrSales['sales']);?>/-</td>
			            <td>₹ <?php
			            if(is_numeric($salesQuota['quat3'])===true && is_numeric($thirdQtrSales['sales'])===true){ 
			           		$gap3= $salesQuota['quat3']-$thirdQtrSales['sales'];
			            }else{
			               $gap3=0; 
			            }
			            if (isset($gap3)){
							if (substr(strval($gap3), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gap3));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gap3);?>
							</span>
							<?php } 	}  ?>
						</td>
			            <td>
			            <?php 
			              if(is_numeric($salesQuota['quat3'])===true && is_numeric($thirdQtrSales['sales'])===true){ 
			                $achieved_percent = $thirdQtrSales['sales']/$salesQuota['quat3'] * 100;
                            $perct= round($achieved_percent,2);
                            echo $perct;
			              }else{
			                  echo 0;
			              }
			            ?>&nbsp;&nbsp;%</td>
		            </tr>
					    <tr>
				
		            <td>Fourth Quarter</td>
		            <td>₹ <?=IND_money_format($salesQuota['quat4']);?>/-</td>
		            <td>₹ <?=IND_money_format($fourthQtrSales['sales']);?>/-</td>
		            <td>₹ <?php
		             if(is_numeric($salesQuota['quat4'])===true && is_numeric($fourthQtrSales['sales'])===true){ 
		           $gap4= $salesQuota['quat4']-$fourthQtrSales['sales'];
		             }else{
		                 $gap4=0;
		             }
		            if (isset($gap4)){
						if (substr(strval($gap4), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gap4));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gap4);?>
							</span>
							<?php } 	}  ?></td>
			            <td>
				            <?php 
				            if(is_numeric($salesQuota['quat4'])===true && is_numeric($fourthQtrSales['sales'])===true){ 
				                $achieved_percent = $fourthQtrSales['sales']/$salesQuota['quat4'] * 100;
                                $perct= round($achieved_percent,2);
                                echo $perct;
				            }else{
				                echo 0;
				            }
				            ?>&nbsp;&nbsp;%</td>
				            </tr>
							        </table>
					    </div>
                    </div>	
                </div>
            </div>
              
               <!---Monthly---->
               
               <div class="card">
    <div class="card-header" id="faqhead3">
        <a href="#faq3" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3" aria-expanded="true" aria-controls="faq3">
            <img src="https://img.icons8.com/dusk/28/000000/total-sales.png"/> Sales Detail Monthly
        </a>
    </div>
    <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
        <div class="card-body">
            <div class="row">
                <table class="table">
                    <tr>
                        <th>Month Name</th>
                        <th>Set Sales Quota</th>
                        <th>Achieved Sales Quota</th>
                        <th>Gap Sales Quota</th>
                        <th>Performance (%)</th>
                    </tr>
                    <?php 
                    $m=4;
                    for($i=1; $i<=12; $i++) { 
                        if($m>12){
                            $m=1;
                        }
                        $date=date_create("2013-".$m."-15");
                        $month=date_format($date,"M");
                        $monthName=date_format($date,"F");
                        $indexName=strtolower($month.'_month');
                        $indexSales=strtolower($month.'_pr');
                        $m++;
                        ?>
                        
                        <tr data-toggle="collapse" data-target="#<?=strtolower($month)?>-details" aria-expanded="false" aria-controls="<?=strtolower($month)?>-details">
                            <td><i class="fa-solid fa-chevron-right"></i>  &nbsp;&nbsp;<?=$monthName;?></td>
                            <td>₹ <?=IND_money_format($salesQuota[$indexName]);?>/-</td>
                            <td>₹ <?=IND_money_format($monthData[$indexSales]['sales']);?>/-</td>
                            <td>₹ <?php
                                if(is_numeric($salesQuota[$indexName])===true && is_numeric($monthData[$indexSales]['sales'])===true){ 
                                    $gapM=$salesQuota[$indexName]-$monthData[$indexSales]['sales'];
                                    -$fourthQtrSales['sales'];
                                }else{
                                    $gapM=0;
                                }
                                if (isset($gapM)){
                                    if (substr(strval($gapM), 0, 1) == "-"){ ?>
                                        <span class="text-success"> <span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gapM));?> </span>
                                    <?php } else { ?>
                                        <span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gapM);?> </span>
                                    <?php } 
                                }?></td>
                            <td>
                                <?php 
                                if(is_numeric($salesQuota[$indexName])===true && is_numeric($monthData[$indexSales]['sales'])===true){ 
                                    $achieved_percent = $monthData[$indexSales]['sales']/$salesQuota[$indexName] * 100;
                                    $perct= round($achieved_percent,2);
                                    echo $perct;
                                }else{
                                    echo 0;
                                }
                                ?>&nbsp;&nbsp;%
                            </td>
                        </tr>

                        <tr class="collapse" id="<?=strtolower($month)?>-details">        
                            <td colspan="5">
                                <table class="table table-bordered" style>
                                    <thead >
                                        <tr >
                                            <th >Customer Name</th>
                                            <th >Achieved Sales Quota</th>
											<th>Performance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										

                                         <?php 
                                            $detailRowCounter = 0; // Counter for generating unique IDs for detail rows
                                            for ($x = 0; $x < count($monthData[$indexSales]) - 2; $x++) { 
                                                // Generate unique IDs for detail rows
                                                $detailRowId = "details_" . $monthName . "_" . $x . "_" . $detailRowCounter++;
                                               
                                            ?>

                                            <tr data-toggle="collapse" data-target="#<?= $detailRowId ?>" aria-expanded="false" aria-controls="<?= $detailRowId ?>" onclick="toggleRowOrg('<?=$detailRowId ?>','<?= $monthData[$indexSales][$x]['org_name'] ?>','<?= $monthName ?>' ,'<?=$salesQuota[$indexName]?>')">
                                                <td><i class="fa-solid fa-chevron-right"></i> &nbsp;&nbsp; <?= $monthData[$indexSales][$x]['org_name'] ?></td>
                                                <td>₹ <?= IND_money_format($monthData[$indexSales][$x]['companyvise_sales']) ?>/-</td>
                                                <td>
                                                    <?php 
                                                    if (is_numeric($salesQuota[$indexName]) === true && is_numeric($monthData[$indexSales][$x]['companyvise_sales']) === true) { 
                                                        $achieved_percent = $monthData[$indexSales][$x]['companyvise_sales'] / $salesQuota[$indexName] * 100;
                                                        $perct = round($achieved_percent, 2);
                                                        echo $perct;
                                                    } else {
                                                        echo 0;
                                                    }
                                                    ?>&nbsp;&nbsp;%
                                                </td>
                                            </tr>
                                            
                                             <tr class="collapse" id="<?= $detailRowId ?>">
                                                <td colspan="4">
                                                    <table class="table table-bordered" id ="orgDetailsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Customer Name</th>
                                                                <th>So. Number</th>
                                                                <th>Achieved Sales Quota</th>
                                                                <th>Performance</th>
                                                            </tr>
                                                        </thead>
                                                        <tr>
                                                         
                                                        </tr>
                                                                                                        
                                                    </table>
                                                </td>
                                            </tr>

                                            <?php } ?>

                                    </tbody>
                                </table>
                            </td>
                        </tr>   

                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>

                
                
                 <!---Quartrly Profit--->
                <div class="card">
                    <div class="card-header" id="faqhead4"> <a href="#faq4" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq4" aria-expanded="true" aria-controls="faq4"><img src="https://img.icons8.com/color/28/000000/economic-improvement.png"/> Profit Detail Quarterly</a>
                    </div>
                    <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq">
						<div class="card-body">
						    <div class="row">
						        <table class="table">
						            <tr>
						            <th>Quarter Name</th>
						            <th>Set Profit Quota</th>
						            <th>Achieved Profit Quota</th>
						            <th>Gap Profit Quota</th>
						            <th>Performance (%)</th>
						            </tr>
						            <tr>
						            <td>First Quarter</td>
						            <td>₹ <?=IND_money_format($salesQuota['profit_quat1']);?>/-</td>
						            <td>₹ <?=IND_money_format($firstQtrSales['profit']);?>/-</td>
						            <td>₹ <?php
						            if(is_numeric($salesQuota['profit_quat1'])===true && is_numeric($firstQtrSales['profit'])===true){
						           $gapProfit= $salesQuota['profit_quat1']-$firstQtrSales['profit'];
						            }else{
						                $gapProfit=0;
						            }
						             if (isset($gapProfit)){
							if (substr(strval($gapProfit), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gapProfit));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gapProfit);?>
							</span>
							<?php } 	}  ?></td>
						            <td>
						            <?php 
						            if(is_numeric($salesQuota['profit_quat1'])===true && is_numeric($firstQtrSales['profit'])===true){
						                $achieved_percent = $firstQtrSales['profit']/$salesQuota['profit_quat1'] * 100;
                                        $perct= round($achieved_percent,2);
                                        echo $perct;
						            }else{
						                echo 0;
						            }
						            ?>&nbsp;&nbsp;%</td>
						            </tr>
						            <tr>
						            <td>Second Quarter</td>
						            <td>₹ <?=IND_money_format($salesQuota['profit_quat2']);?>/-</td>
						            <td>₹ <?=IND_money_format($secondQtrSales['profit']);?>/-</td>
						            <td>₹ <?php
						             if(is_numeric($salesQuota['profit_quat2'])===true && is_numeric($secondQtrSales['profit'])===true){
						           $gapProfit2= $salesQuota['profit_quat2']-$secondQtrSales['profit'];
						             }else{
						               $gapProfit2=0;
						             }
						           if (isset($gapProfit2)){
							if (substr(strval($gapProfit2), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gapProfit2));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gapProfit2);?>
							</span>
							<?php } 	}  ?></td>
						            <td>
						            <?php 
						            if(is_numeric($salesQuota['profit_quat2'])===true && is_numeric($secondQtrSales['profit'])===true){
						                $achieved_percent = $secondQtrSales['profit']/$salesQuota['profit_quat2'] * 100;
                                        $perct= round($achieved_percent,2);
                                        echo $perct;
						            }else{
						                echo 0;
						            }
						            ?>&nbsp;&nbsp;%</td>
						            </tr>
						            <tr>
						            <td>Third Quarter</td>
						            <td>₹ <?=IND_money_format($salesQuota['profit_quat3']);?>/-</td>
						            <td>₹ <?=IND_money_format($thirdQtrSales['profit']);?>/-</td>
						            <td>₹ <?php
						            if(is_numeric($salesQuota['profit_quat3'])===true && is_numeric($thirdQtrSales['profit'])===true){
						            
						           $gapProfit3= $salesQuota['profit_quat3']-$thirdQtrSales['profit'];
						            }else{
						                $gapProfit3=0;
						            }
						            if (isset($gapProfit3)){
							if (substr(strval($gapProfit3), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gapProfit3));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gapProfit3);?>
							</span>
							<?php } 	}  ?></td>
						            <td>
						            <?php 
						            if(is_numeric($salesQuota['profit_quat3'])===true && is_numeric($thirdQtrSales['profit'])===true){
						                $achieved_percent = $thirdQtrSales['profit']/$salesQuota['profit_quat3'] * 100;
                                        $perct= round($achieved_percent,2);
                                        echo $perct;
						            }else{
						                
						            }
						            ?>&nbsp;&nbsp;%</td>
						            </tr>
						            <tr>
						            <td>Fourth Quarter</td>
						            <td>₹ <?=IND_money_format($salesQuota['profit_quat4']);?>/-</td>
						            <td>₹ <?=IND_money_format($fourthQtrSales['profit']);?>/-</td>
						            <td>₹ <?php
						            if(is_numeric($salesQuota['profit_quat4'])===true && is_numeric($fourthQtrSales['profit'])===true){
						           $gapProfit4= $salesQuota['profit_quat4']-$fourthQtrSales['profit'];
						            }else{
						                $gapProfit4=0;
						            }
						            if (isset($gapProfit4)){
							if (substr(strval($gapProfit4), 0, 1) == "-"){ ?>
							<span class="text-success"> 	<span>(+)</span> &nbsp; ₹ <?=IND_money_format(str_replace("-","",$gapProfit4));?> 	</span>
							<?php } else { 	?>
							<span class="text-danger"> <span>(-)</span> &nbsp; ₹ <?=IND_money_format($gapProfit4);?>
							</span>
							<?php } 	}  ?></td>
						            <td>
						            <?php 
						            if(is_numeric($salesQuota['profit_quat4'])===true && is_numeric($fourthQtrSales['profit'])===true){
						                $achieved_percent = $fourthQtrSales['profit']/$salesQuota['profit_quat4'] * 100;
                                        $perct= round($achieved_percent,2);
                                        echo $perct;
						            }else{
						                echo 0;
						            }
						            ?>&nbsp;&nbsp;%</td>
						            </tr>
						            
						        </table>
						    </div>
                        </div>	
                    </div>
                </div>
              
               
<!---Monthly Profit---->
<div class="card">
    <div class="card-header" id="faqhead5"> 
        <a href="#faq5" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq5" aria-expanded="true" aria-controls="faq5">
            <img src="https://img.icons8.com/fluent/28/000000/economic-improvement.png"/> Profit Detail Monthly
        </a>
    </div>
    <div id="faq5" class="collapse show" aria-labelledby="faqhead5" data-parent="#faq">
        <div class="card-body">
            <div class="row">
                <table class="table">
                    <tr>
                        <th>Month Name</th>
                        <th>Set Profit Quota</th>
                        <th>Achieved Profit Quota</th>
                        <th>Gap Profit Quota</th>
                        <th>Performance (%)</th>
                    </tr>
                    <?php 
                    $m = 4;
                    for ($i = 1; $i <= 12; $i++) { 
                        if ($m > 12) {
                            $m = 1;
                        }

                        $date = date_create("2013-" . $m . "-15");
                        $month = date_format($date, "M");
                        $monthCurr = date_format($date, "m");
                        $curMon = date('m');
                        $monthName = date_format($date, "F");
                        $indexName2 = strtolower("profit_" . $month . '_month');
                        $indexSales = strtolower($month . '_pr');
                        $m++;
                    ?>
                    <tr data-toggle="collapse" data-target="#<?= strtolower($month) ?>-profitdetails" aria-expanded="false" aria-controls="<?= strtolower($month) ?>-profitdetails">
                        <td><i class="fa-solid fa-chevron-right"></i> &nbsp;&nbsp;<?= $monthName; ?></td>
                        <td>₹ <?= IND_money_format($salesQuota[$indexName2]); ?>/-</td>
                        <td>₹ <?= IND_money_format($monthData[$indexSales]['profit']); ?>/-</td>
                        <td>
                            ₹ <?php
                            if (is_numeric($salesQuota[$indexName2]) === true && is_numeric($monthData[$indexSales]['profit']) === true) {
                                $gapM = $salesQuota[$indexName2] - $monthData[$indexSales]['profit'];
                            } else {
                                $gapM = 0; 
                            }
                            if (isset($gapM)) {
                                if (substr(strval($gapM), 0, 1) == "-") { ?>
                                    <span class="text-success">(+)&nbsp;₹ <?= IND_money_format(str_replace("-", "", $gapM)); ?></span>
                                <?php } else { ?>
                                    <span class="text-danger">(-)&nbsp;₹ <?= IND_money_format($gapM); ?></span>
                                <?php } }
                            ?>
                        </td>
                        <td>
                            <?php 
                            if (is_numeric($salesQuota[$indexName2]) === true && is_numeric($monthData[$indexSales]['profit']) === true) {
                                if ($salesQuota[$indexName2] != 0) {
                                    $achieved_percent = $monthData[$indexSales]['profit'] / $salesQuota[$indexName2] * 100;
                                    $perct = round($achieved_percent, 2);
                                    echo $perct;
                                }
                            } else {
                                echo 0;
                            }
                            ?>&nbsp;%</td>
                    </tr>
                    <tr class="collapse" id="<?= strtolower($month) ?>-profitdetails">        
                        <td colspan="5" style="background:#fff;">
                            <table class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Achieved Profit Quota</th>
                                        <th>Performance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $detailCounter = 0;
                                    for ($x = 0; $x < count($monthData[$indexSales]) - 2; $x++) { 
                                        $detailRowIdprofit = "detail" . $monthName . "_" . $x . "_" . $detailCounter++;
                                        ?>
                                      <tr data-toggle="collapse" data-target="#<?= $detailRowIdprofit ?>" aria-expanded="false" aria-controls="<?= $detailRowIdprofit ?>" onclick="toggleRow('<?= $detailRowIdprofit ?>', '<?= $monthData[$indexSales][$x]['org_name']; ?>', '<?= $monthName; ?>','<?= $salesQuota[$indexName2]; ?>')">
                                            <td><i class="fa-solid fa-chevron-right"></i> &nbsp;&nbsp;<?= $monthData[$indexSales][$x]['org_name']; ?></td>
                                            <td>₹ <?= IND_money_format($monthData[$indexSales][$x]['companyvise_profit']); ?>/-</td>
                                            <td>
                                                <?php 
                                                if (is_numeric($salesQuota[$indexName2]) === true && is_numeric($monthData[$indexSales][$x]['companyvise_profit']) === true) { 
                                                    $achieved_percent = $monthData[$indexSales][$x]['companyvise_profit'] / $salesQuota[$indexName2] * 100;
                                                    $perct = round($achieved_percent, 2);
                                                    echo $perct;
                                                } else {
                                                    echo 0;
                                                }
                                                ?>&nbsp;%
                                            </td>
                                        </tr>

                                        <tr class="collapse" id="<?= $detailRowIdprofit ?>" aria-labelledby="" data-parent="">
                                            <td colspan="3">
                                                <table class="table table-bordered" id="orgDetailsTableprofit">
                                                    <thead>
                                                        <tr>
                                                            <th> Customer Name</th>
                                                            <th>P.O.Number</th>
                                                            <th>Achieved Profit Quota</th>
                                                            <th> Performance </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data will be populated here -->
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>


                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>  
    </div>

</div>



    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="left-buttons">
                        <ul class="list-group list-group-horizontal">
                            
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="right-buttons">
                        <ul class="list-group list-group-horizontal">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
</div>
</div>
<script>
	<?php $uri1 = $this->uri->segment(1);
	      $uri2 = $this->uri->segment(2);
	      $uri3 = $this->uri->segment(3);
		  $url = base_url("$uri1/$uri2/$uri3");
	
	?>
	function filterbydata(){
     location.href="<?php echo $url;?>/126";
}
</script>


<script>
function rowClicked(orgName, monthName,mAmount) {
    var url = "<?= base_url('Sales_profit_target/fetchData_org_month')?>";
    $.ajax({
        type: "GET",
        url: url,
        data: { orgName: orgName, monthName: monthName ,mAmount: mAmount},
        dataType: "JSON",
        success: function(response) {
    console.log(response);
    $('#orgDetailsTable tbody').empty();
    if (response.All_org && response.All_org.length > 0) {
        $.each(response.All_org, function(index, org_details) {
            var saleorder_id = org_details.saleorder_id;
            var lastThreeDigits = saleorder_id.substring(saleorder_id.length - 4);
            var initial_total = org_details.initial_total;
            var mAmount = response.mAmount; // Adding mAmount to each row
            var formatted_total = '₹ ' + parseFloat(initial_total).toLocaleString('en-IN', { maximumFractionDigits: 2 }) + '/-';

            var percentage = (initial_total / mAmount) * 100;

            var row = '<tr>' +
                '<td>' + org_details.org_name + '</td>' +
                '<td>' + lastThreeDigits + '</td>' +
                '<td>' + formatted_total + '</td>' +
                '<td>' + percentage.toFixed(2) + ' %</td>' + 
                '</tr>';
            $('#orgDetailsTable tbody').append(row);
        });
    } else {
        $('#orgDetailsTable tbody').append('<tr><td colspan="4">No data available</td></tr>');
    }
},


        error: function(xhr, status, error) {
            
            console.error(xhr.responseText);
            $('#orgDetailsTable tbody').append('<tr><td colspan="4">Error fetching data</td></tr>');
        }
    });
}

    var lastOpenedRowIdorg = null;
    function toggleRowOrg(rowId, orgName, month ,mAmount) {
        // Check if any row is already open
        if (lastOpenedRowIdorg !== null) {
            $('#' + lastOpenedRowIdorg).collapse('hide'); // Collapse the previously opened row
        }

        // Open the clicked row
        $('#' + rowId).collapse('show');
        lastOpenedRowIdorg = rowId;
        
        // Fetch data for the clicked row
        rowClicked(orgName, month,mAmount);
    }




function fetchData(orgname, month,mpAmount) {
    // alert(mpAmount);
    var url = "<?= base_url('Sales_profit_target/fetchData_profit')?>";
    $.ajax({
        type: "GET",
        url: url,
        data: { orgname: orgname, month: month,mpAmount: mpAmount },
        success: function(response) {
    $('#orgDetailsTableprofit tbody').empty();

    // Determine the minimum length of the arrays
    var minLength = Math.min(response.profit_org.length, response.profit_POID.length);

    // Iterate over the arrays up to the minimum length
    for (var i = 0; i < minLength; i++) {
        var org_details = response.profit_org[i];
        var po_details = response.profit_POID[i];
        var amountprofit = response.mpAmount[i];

        var purchaseorder_id = po_details.purchaseorder_id;
        var salAmount = org_details.profit_by_user;
        var formatted_profit = '₹ ' + parseFloat(salAmount).toLocaleString('en-IN', { maximumFractionDigits: 2 }) + '/-';
        
        var lastFourDigits = purchaseorder_id.substring(purchaseorder_id.length - 4);

        var percentageprofit = (salAmount / amountprofit) * 100;
        
        var row = '<tr>' +
            '<td>' + org_details.org_name + '</td>' +
            '<td>' + lastFourDigits + '</td>' +
            // '<td>' + org_details.initial_total + '</td>' +
            '<td>' + formatted_profit + '</td>' +
            '<td>' + percentageprofit.toFixed(2) + '% </td>' +
            '</tr>';
        $('#orgDetailsTableprofit tbody').append(row);
    }

    // If one array has more elements than the other, handle the remaining elements
    for (var j = minLength; j < response.profit_org.length; j++) {
        var org_details = response.profit_org[j];

        var row = '<tr>' +
            '<td>' + org_details.org_name + '</td>' +
            '<td>N/A</td>' +
            // '<td>' + org_details.initial_total + '</td>' +
            '<td>' + formatted_profit + '</td>' +
            '<td>' + percentageprofit .toFixed(2) + '% </td>' +
            '</tr>';
        $('#orgDetailsTableprofit tbody').append(row);
    }

    for (var k = minLength; k < response.profit_POID.length; k++) {
        var po_details = response.profit_POID[k];

        var row = '<tr>' +
            // '<td>' + po_details.org_name + '</td>' +
            '<td>N/A</td>' +
            '<td>' + po_details.purchaseorder_id.substring(purchaseorder_id.length - 4) + '</td>' +
            // '<td>N/A</td>' +
            '<td>N/A</td>' +
            '<td>N/A</td>' +
            '</tr>';
        $('#orgDetailsTableprofit tbody').append(row);
    }
},

        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
            $('#orgDetailsTableprofit tbody').append('<tr><td colspan="4">Error fetching data</td></tr>');
        }
    });
}
  
</script>

<script>
    var lastOpenedRowId = null;
    function toggleRow(rowId, orgName, month, mpAmount) {
        
        // Check if any row is already open
        if (lastOpenedRowId !== null) {
            $('#' + lastOpenedRowId).collapse('hide'); // Collapse the previously opened row
        }

        // Open the clicked row
        $('#' + rowId).collapse('show');
        lastOpenedRowId = rowId;
        
        // Fetch data for the clicked row
        fetchData(orgName, month,mpAmount);
    }
</script>





 <?php $this->load->view('footer');?>
<!-- common footer include -->
<?php $this->load->view('common_footer');?>
<!-- common footer include -->
<script>document.getElementsByTagName("html")[0].className += " js";</script>
