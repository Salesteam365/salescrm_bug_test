<?php $this->load->view('common_navbar');?>
<style>
.timeIc{ color: #18a2b8;
    margin: 2px;
}

  #calendar {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 10px;
  }
  
   #top {
    background: #eee;
    border-bottom: 1px solid #ddd;
    padding: 0 10px;
    line-height: 40px;
    font-size: 12px;
  }
  .userNm{
    margin: 5px;
    font-size: 14px;
    border: 1px solid #f5efef;
    padding: 3px 6px;
    border-radius: 4px;
    background: #fdfbfb;
    display: none;
}
</style>
<link href='<?= base_url();?>assets/css/main.css' rel='stylesheet' />
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Search List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('home'); ?>">Home</a></li>
              <li class="breadcrumb-item active">Search</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <div class="card-body" id="countSearch">
			  <form method="post" action="" >
                  <div class="row">
                      
					  <div class="col-sm-8 form-group text-right">
							  
					 </div>
                    <div class="clearfix"></div>
						  
							  
                      
                  </div>
                </form>
        <?php
		$arrDatasrt=array();
		$newArrData=array();
		$rcrd=0;
		for($k=0; $k<count($result); $k++){
			$newData=$result[$k];
			if(count($newData)>1){ 
				for($i=0; $i<count($newData); $i++){
					if(isset($newData[$i])){
						$dataTest=$newData[$i];
						$rcrd=1;
						$searchitem='';
						foreach($dataTest as $key => $value){
							if(isset($value) && $value!=""){
								if(checkExitsString($value, $search, '#03a9f5')==1){
								$searchitem.="<text style='margin-right: 34px;'><b style='color:#7a7a79;'>".ucwords(str_replace("_"," ",$key))."</b> : ".highlightStr($value, $search, '#03a9f5')."</text>";
								}
							}
						}
						if($newData['table_name']=='contact'){
							$urlData=base_url()."contacts?cnt=".$dataTest['id'];
						}
						if($newData['table_name']=='create_call'){
							$urlData=base_url()."call?cid=".$dataTest['id'];
						}
						if($newData['table_name']=='customer_activity'){
							$urlData=base_url()."view-customer/".$dataTest['id'];
						}
						if($newData['table_name']=='invoices'){
							$encrypted_id 	= base64_encode($dataTest['id']);
							$sessionEmail 	= base64_encode($this->session->userdata('company_email'));
							$sessionCompany	= base64_encode($this->session->userdata('company_name'));
							$urlData=base_url()."invoices/view-invoice?inv_id=".$encrypted_id."&cnp=".$sessionCompany."&ceml=".$sessionEmail;
						}
						if($newData['table_name']=='lead'){
							$urlData=base_url()."lead?lid=".$dataTest['id'];
						}
						if($newData['table_name']=='meeting'){
							$urlData=base_url()."meeting?mid=".$dataTest['id'];
						}
						if($newData['table_name']=='opportunity'){
							$urlData=base_url()."opportunities?oppid=".$dataTest['id'];
						}
						if($newData['table_name']=='opp_task'){
							$urlData=base_url()."task?tid=".$dataTest['id'];
						}
						if($newData['table_name']=='organization'){
							$urlData=base_url()."view-customer/".$dataTest['id'];
						}
						if($newData['table_name']=='product'){
							$urlData=base_url()."product-manager?prd".$dataTest['id'];
						}
						if($newData['table_name']=='purchaseorder'){
							$urlData=base_url()."purchaseorders/view_pi_po/".$dataTest['id'];
						}
						if($newData['table_name']=='quote'){
							$urlData=base_url()."quotation/view_pi_qt/".$dataTest['id'];
						}
						if($newData['table_name']=='salesorder'){
							$urlData=base_url()."salesorders/view_pi_so/".$dataTest['id'];
						}
						if($newData['table_name']=='vendor'){
							$urlData=base_url()."view-vendor/".$dataTest['id'];
						}
						if($newData['table_name']=='workflow'){
							$urlData=base_url()."workflows";
						}
						
						 $ven = $newData[0]['customer_type'];
						
						if($newData['table_name']=='organization' && ($ven =='Vendor' || $ven == 'Both'))
						{
				
						    $newData['table_name']='Vendor';
						    $urlData=base_url()."view-customer/".$dataTest['id'];
						}
						$arrDatasrt['module']	= $newData['table_name'];
						$arrDatasrt['text']	 	= $searchitem;
						$date = new DateTime($dataTest['currentdate']);
						$arrDatasrt['last_date']= $date->format('Y-m-d');
						$arrDatasrt['url']		= $urlData;
						$newArrData[]=$arrDatasrt;
					}
				}
			}
		}
		
		usort($newArrData, function($a, $b) {
		  return new DateTime($b['last_date']) <=> new DateTime($a['last_date']);
		});
		?>
			
				<table id="dt-multi-checkbox" class="table table-striped table-bordered table-responsive-lg dataTable no-footer" cellspacing="0" width="100%">
                    <thead>
                        <tr>                     
                            <th class="th-sm" style="width: 15%;">Module </th>
                            <th class="th-sm">Search Item</th>
                            <th class="th-sm"style="width: 11%;">Last Activity Date</th>
                            <th class="th-sm" style="width: 11%;">View Detail</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php 
					if(count($newArrData)>0){
					for($i=0; $i<count($newArrData); $i++){ ?>
						<tr>
							<td><?=$newArrData[$i]['module'];?></td>
							<td><?=$newArrData[$i]['text'];?></td>
							<td>
								<?php
								$date = new DateTime($newArrData[$i]['last_date']);
								echo  $date->format('d M Y');
								//$newArrData[$i]['last_date'];?>
							</td>
							<td><a href="<?=$newArrData[$i]['url'];?>">View Detail</a></td>
						</tr>
					<?php } }else{ ?>
						<tr>
							<td colspan="4" style="text-align: center;"> 
								<div class="col-md-12 text-center p-3">
								<img src="https://img.icons8.com/color/48/000000/nothing-found.png">
								<br>No record found yet.</div>
							</td>
						</tr>
					<?php }  ?>
                    </tbody>
				</table>
					
				
				
				
              </div>
            </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script type="text/javascript">
var save_method; //for save method string
var table;
/*
    table = $('#dt-multi-checkbox').DataTable({
        "processing": true, 
        "serverSide": true, 
		"searching": true,
        "order": [], 
        "ajax": {
            url: "<?php echo site_url('setting/ajax_list_state')?>",
            type: "POST",
			dataType : "JSON",
            data : function(data)
             {
                data.searchDate = $('#date_filter').val();
				
             }
        },
        //Set column definition initialisation properties.
        "columnDefs": [
        {
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ]
    });

   */
    
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax
  }
  //delete proforma invoice
  function delete_entry(id)
  {
      if(confirm('Are you sure delete this data?'))
      {
          // ajax delete data to database
          $.ajax({
              url : "<?= site_url('setting/delete_task')?>/"+id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                if(data.status) 
                {
                    alert('Task deleted successfully.')
                    reload_table();
                }else{
                    alert('Something went wrong, Try later.')
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error deleting data');
              }
          });
      }
  }
</script>

