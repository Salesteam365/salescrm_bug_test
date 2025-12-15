<?php $this->load->view('common_navbar');?>
<style>
  #ajax_datatable thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   /* padding-top:18px;
  padding-bottom:18px; */
  

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

  
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Assigned Leads</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."home"; ?>">Home</a></li>
              <li class="breadcrumb-item active">Assigned Leads</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <div class="container-fliud filterbtncon"  >
        <!-- /.row -->
        
        <div class="row mb-3">
            <div class="col-lg-2">
            <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="date_filter" value="" name="date_filter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li data-value="This Week">This Week</li>
        <?php $week = strtotime("-7 Day"); ?>
        <li data-value="<?= date('y.m.d', $week); ?>"onclick="getfilterdData('<?= date('Y-m-d',$week); ?>','date_filter');">Last Week</li>
        <?php $fifteen = strtotime("-15 Day"); ?>
        <li data-value="<?= date('y.m.d', $fifteen); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fifteen); ?>','date_filter');">Last 15 days</li>
        <?php $thirty = strtotime("-30 Day"); ?>
        <li data-value="<?= date('y.m.d', $thirty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$thirty); ?>','date_filter');">Last 30 days</li>
        <?php $fortyfive = strtotime("-45 Day"); ?>
        <li data-value="<?= date('y.m.d', $fortyfive); ?>"onclick="getfilterdData('<?= date('Y-m-d',$fortyfive); ?>','date_filter');">Last 45 days</li>
        <?php $sixty = strtotime("-60 Day"); ?>
        <li data-value="<?= date('y.m.d', $sixty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$sixty); ?>','date_filter');">Last 60 days</li>
        <?php $ninty = strtotime("-90 Day"); ?>
        <li data-value="<?= date('y.m.d', $ninty); ?>"onclick="getfilterdData('<?= date('Y-m-d',$ninty); ?>','date_filter');">Last 3 Months</li>
        <?php $six_month = strtotime("-180 Day"); ?>
        <li data-value="<?= date('y.m.d', $six_month); ?>"onclick="getfilterdData('<?= date('Y-m-d',$six_month); ?>','date_filter');">Last 6 Months</li>
        <?php $one_year = strtotime("-365 Day"); ?>
        <li data-value="<?= date('y.m.d', $one_year); ?>"onclick="getfilterdData('<?= date('Y-m-d',$one_year); ?>','date_filter');">Last 1 Year</li>
    </ul>
</div>
   </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btnstopcorner" onclick="listgrdvw('listview','gridview')"><i class="fas fa-list-ul"></i></button>
		  <button class="btn btnstopcorner" onclick="listgrdvw('gridview','listview')"><i class="fas fa-th"></i></button>
                  <button class="btnstopcorner" onclick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
                  <button class="btnstop"><a href="<?php echo base_url()."leads"; ?>" style="color: #fff;">Leads</a></button>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
         <!-- Map card -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body" id="listview">
              
              
            <div class="card-header mb-2"><b style="font-size:21px;">Assigned Leads</b> 
            <!-- <button type="button" id="btnshowhide" class="btn btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" style="">
                   <i class="fa fa-table" aria-hidden="true" style="color:purple;"></i>&nbsp;
                     Show/Hide Columns</button> -->
                    </div>
                     <div class="card-body">
                <table id="ajax_datatable" class="table table-striped table-bordered table-responsive-lg" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <?php if($this->session->userdata('delete_lead')=='1'):?>
                        <th><button class="btn" type="button" name="delete_all" id="delete_all2"><i class="fa fa-trash text-light"></i></button></th>
                      <?php endif; ?>
                      <th class="th-sm">Lead Name</th>
                      <th class="th-sm">Organisation Name</th>
                      <th class="th-sm">Email</th>
                      <th class="th-sm">Assigned By</th>
                      <th class="th-sm">Lead Status</th>
                      <th class="th-sm">Action</th>
                    </tr>
                  </thead>
                  <tbody>                       
                  </tbody>
                </table>
              </div>
              
              
            <div class="card-body" id="gridview"  style="display:none;" >
				<input type="text" class="form-control" id="searchRecord" name="searchRecord" style="margin-bottom: 13px; width: 33%;" placeholder="Search Data">
				<div class="row" style="width: 100%;">
					<?php
						$leadStatus=array('Pre-Qualified','Contacted','Junk Lead','Lost Lead','Not Contacted','Contact in Future','In Progress');
					    for($i=0; $i<count($leadStatus); $i++){ 
							$ind=str_replace(' ','',$leadStatus[$i]);
							$ind=str_replace('-','',$ind);
					?>
						<div class="hdr">
							<span><?=$leadStatus[$i];?></span>
							<br>
							<input type="hidden" id="<?=$ind;?>" value="<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>">
							<span>₹ <text id="txt<?=$ind;?>" data-min='<?php if($price[$ind]['initial_total']){ echo $price[$ind]['initial_total']; }else{ echo "0"; }?>'  data-delay='3' data-increment="99" > <?=IND_money_format($price[$ind]['initial_total']);?></text></span>
						</div>
					<?php  } ?>
				</div>
				<div class="row" style="width: 100%;" id="putLeadData"></div>
			    <div   id="pagination_link"></div>
			</div>
         </div>
      </div>
    </section>
  </div>
  
  
  <!-- View Lead Model  -->
   <div class="modal fade show" id="addnew_modal" role="dialog" aria-modal="true" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="organization_add_edit">View Lead</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body form">
              <form id="view" class="row" action="#">
                <div class="col-sm-12">
                   <div class="timeline-one">
                    <div class="events">
                      <ol>
                        <ul>
                          <li>
                            <a href="#" class="selected">Lead</a>
                          </li>
                          <li>
                            <a href="#" class="selected">Opportunity</a>
                          </li>
                          <li>
                            <a href="#" class="selected_red">Quote</a>
                          </li>
                          <li>
                            <a href="#" class="selected_red">Salesorder</a>
                          </li>
                          <li>
                            <a href="#" class="selected_red">Purchaseorder</a>
                          </li>
                        </ul>
                      </ol>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <h5 class="text-primary" id="track_status"></h5>
                  <input type="hidden" id="track_status_hidden" value="">
                </div>
                <div class="col-sm-12">
                  <h5 class="text-primary" id="name">Proposal for Corel renewal</h5>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Organization Name:</span>
				  <h6 class="text-primary" id="org_name">Holostik India Ltd</h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Ownership:</span>
				  <h6 class="text-primary" id="lead_owner"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Email:</span>
				  <h6 class="text-primary" id="email"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Office&nbsp;Phone:</span>
				  <h6 class="text-primary" id="office_phone"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Mobile:</span>
				  <h6 class="text-primary" id="mobile"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Lead&nbsp;Source:</span>
				  <h6 class="text-primary" id="lead_source"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Lead&nbsp;Status:</span>
				  <h6 class="text-primary" id="lead_status"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Industry:</span>
				  <h6 class="text-primary" id="industry"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Employees:</span>
				  <h6 class="text-primary" id="employees">0</h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Annual&nbsp;Revenue:</span>
				  <h6 class="text-primary" id="annual_revenue">0</h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Rating:</span>
				  <h6 class="text-primary" id="rating"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Website:</span>
				  <h6 class="text-primary" id="website"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Secondary&nbsp;Email:</span>
				  <h6 class="text-primary" id="secondary_email"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Assigned&nbsp;To:</span>
				  <h6 class="text-primary" id="assigned_to"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Contact&nbsp;Name:</span>
				  <h6 class="text-primary" id="contact_name"></h6>
                </div>
                <div class="col-sm-12">
                  <h5>Address&nbsp;Details:</h5>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;Country:</span>
				  <h6 class="text-primary" id="billing_country"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;State:</span>
				  <h6 class="text-primary" id="billing_state"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;Country:</span>
				  <h6 class="text-primary" id="shipping_country"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;State:</span>
				  <h6 class="text-primary" id="shipping_state"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;City:</span>
				  <h6 class="text-primary" id="billing_city"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Billing&nbsp;Zipcode:</span>
				  <h6 class="text-primary" id="billing_zipcode"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;City:</span>
				  <h6 class="text-primary" id="shipping_city"></h6>
                </div>
                <div class="col-sm-3">
                  <span class="text-secondary">Shipping&nbsp;Zipcode:</span>
				  <h6 class="text-primary" id="shipping_zipcode"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Billing&nbsp;Address:</span>
				  <h6 class="text-primary" id="billing_address"></h6>
                </div>
                <div class="col-sm-6">
                  <span class="text-secondary">Shipping&nbsp;Address:</span>
				  <h6 class="text-primary" id="shipping_address"></h6>
                </div>
                <div class="col-sm-12">
                  <span class="text-secondary">Description:</span>
				  <h6 class="text-primary" id="description"></h6>
                </div>
                <div class="col-md-12 mb-6">
                  <h5>Add&nbsp;Product&nbsp;Details</h5>
                </div>
                <div class="col-sm-12">
                  <table class="table table-responsive-lg-sm" id="add2" width="100%">
                    <tbody><tr>
                      <td><span class="text-secondary">Product&nbsp;Name</span></td>
                      <td><span class="text-secondary">Quantity</span></td>
                      <td><span class="text-secondary">Unit&nbsp;Price</span></td>
                      <td><span class="text-secondary">Total</span></td>
                    </tr>
                  <tr><td><h6 class="text-primary"></h6></td>
				  <td><h6 class="text-primary"></h6></td>
				  <td><h6 class="text-primary"></h6></td>
				  <td><h6 class="text-primary"></h6></td>
				  </tr></tbody></table>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                  <table class="float-right table table-responsive-lg-sm" width="100%">
                    <tbody><tr>
                      <td><span class="text-secondary">Initial&nbsp;Total:</span></td>
                      <td><h6 class="text-primary" id="initial_total"></h6></td>
                    </tr>
                    <tr>
                      <td><span class="text-secondary">Overall&nbsp;Discount:</span></td>
                      <td><h6 class="text-primary" id="discount"></h6></td>
                    </tr>
                    <tr>
                      <td><span class="text-secondary">Sub&nbsp;Total:</span></td>
                      <td><h6 class="text-primary" id="sub_total"></h6></td>
                    </tr>
                  </tbody></table>
                </div>
              </form>
            </div>                    
        </div>
      </div>
    </div>
              </div>
 <?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script>
function numberRoller(pttxt,maxprice){
		
            var min=parseInt($("#"+pttxt).attr('data-min'));
            var max=parseInt(maxprice);
            var timediff=parseInt($("#"+pttxt).attr('data-delay'));
            var increment=parseInt($("#"+pttxt).attr('data-increment'));
            var numdiff=max-min;
            var timeout=(timediff*1000)/numdiff;
            numberRoll(pttxt,min,max,increment,timeout);
            
    }
    function numberRoll(pttxt,min,max,increment,timeout){
        if(min<=max){
            $("#"+pttxt).html(min);
            min=parseInt(min)+parseInt(increment);
            setTimeout(function(){
			numberRoll(pttxt,eval(min),eval(max),eval(increment),eval(timeout))
			},timeout);
        }else{
            $("#"+pttxt).html(max);
        }
    }


function listgrdvw(dispid,idhide){
	$('#'+idhide).hide();
	$('#'+dispid).show();
}

 function load_country_data(page,dateFilter)
 {
	 
	var search		= $("#searchRecord").val();
	if(dateFilter===undefined){
		dateFilter='';
	}
  $.ajax({
   url:"<?php echo base_url(); ?>leads/pagination/"+page,
   method:"GET",
   data:"searchDate="+dateFilter+"&search="+search+"&assigned=assigned",
   dataType:"json",
   success:function(data)
   {
	  // console.log(data);
    $('#pagination_link').html(data.pagination_link);
   }
  });
 }
 
 load_country_data(1);

 $(document).on("click", ".pagination li a", function(event){
  event.preventDefault();
		var page = $(this).data("ci-pagination-page");
		var dateFilter	= $("#date_filter").val();
		load_country_data(page,dateFilter);
		getDataGrid(dateFilter,'',page);
 });


    //addElements();
	getDataGrid('','',1);
	function getDataGrid(dateFilter='',search='',page=''){
		$.ajax({
			url : "<?= site_url('leads/gridview');?>",
			type: "POST",
			data: "leadid=123&searchDate="+dateFilter+"&search="+search+'&page='+page+"&assigned=assigned",
			success: function(data){
				$("#putLeadData").html(data);
			}
		});
	}
	
	$("#searchRecord").keyup(function(){
		var search		= $(this).val();
		var date_filter	= $("#date_filter").val();
		getDataGrid(date_filter,search,1);
		load_country_data(1);
	});

	

</script>
<script>
$(document).ready(function () {
  var table;
  table = $('#ajax_datatable').DataTable({
          "processing": true,
          "serverSide": true,
          "order": [], 
          "ajax": {
              "url": "<?= base_url('leads/ajax_list_assigned')?>",
              "type": "POST",
              "data" : function(data){
                 data.searchDate = $('#date_filter').val();
              }
          },
          "columnDefs": [
          { 
              "targets": [ 0 ],
              "orderable": false,
          },
          ],
  });
  $('#date_filter').change(function(){
    table.ajax.reload();
      var searchDate = $('#date_filter').val();
	    getDataGrid(searchDate,'',1)
		load_country_data(1,searchDate);
  });
});
</script>
<script>
  jQuery(function(){
    jQuery('.show_div').click(function(){
          jQuery('.targetDiv').hide();
          jQuery('#div'+$(this).attr('target')).show();
    });
});
</script>

<script>
$(document).ready(function(){

 $('.delete_checkbox').click(function(){
  if($(this).is(':checked'))
  {
   $(this).closest('tr').addClass('removeRow');
  }
  else
  {
   $(this).closest('tr').removeClass('removeRow');
  }
 });
 
 $('#delete_all').click(function(){
  var checkbox = $('.delete_checkbox:checked');
  if(checkbox.length > 0)
  {
   var checkbox_value = [];
   $(checkbox).each(function(){
    checkbox_value.push($(this).val());
   });
   $.ajax({
    url:"<?= base_url();?>",
    method:"POST",
    data:{checkbox_value:checkbox_value},
    success:function()
    {
     $('.removeRow').fadeOut();
     reload_table();
    }
   })
  }
  else
  {
   alert('Select atleast one records');
  }
 });
});
</script>
<script>
function myFunction() {
  alert("Do You Want To Delete?");
}
</script>

<script>
function refreshPage(){
    window.location.reload();
} 
</script>




<?php if(check_permission_status('Leads','retrieve_u')==true):?>
  <script>
  $(document).ready(function(){
    //var track_status = document.getElementById('track_status').value;
  });

  </script>
 
  <script>
    jQuery(function(){
      jQuery('.show_div').click(function(){
            jQuery('.targetDiv').hide();
            jQuery('#div'+$(this).attr('target')).show();
      });
    });
  </script>
<?php endif; ?>
<script>
  function reload_table()
  {
    table.ajax.reload(null,false); //reload datatable ajax
  }
 
  <?php if(check_permission_status('Leads','retrieve_u')==true):?>
    function view(id)
    {
      $('#opportunity').removeClass('selected');
      $('#opportunity').removeClass('selected_red');
      $('#quote').removeClass('selected');
      $('#quote').removeClass('selected_red');
      $('#salesorder').removeClass('selected');
      $('#salesorder').removeClass('selected_red');
      $('#purchaseorder').removeClass('selected');
      $('#purchaseorder').removeClass('selected_red');
      //$('#view')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      //Ajax Load data from ajax
      $.ajax({
        url : "<?= base_url('leads/getbyId/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          $("#add2").find("tr").not(':first').remove();
          $('[id="name"]').text(data.name);
          $('[id="org_name_view"]').text(data.org_name);
          $('[id="lead_owner"]').text(data.lead_owner);
          $('[id="email"]').text(data.email);
          $('[id="website"]').text(data.website);
          $('[id="office_phone"]').text(data.office_phone);
          $('[id="mobile"]').text(data.mobile);
          $('[id="lead_source"]').text(data.lead_source);
          $('[id="lead_status"]').text(data.lead_status);
          $('[id="industry"]').text(data.industry);
          $('[id="employees"]').text(data.employees);
          $('[id="annual_revenue"]').text(data.annual_revenue);
          $('[id="rating"]').text(data.rating);
          $('[id="website"]').text(data.website);
          $('[id="secondary_email"]').text(data.secondary_email);
          $('[id="assigned_to"]').text(data.assigned_to);
          $('[id="assigned_to_name"]').text(data.assigned_to_name);
          $('[id="contact_name"]').text(data.contact_name);
          $('[id="billing_country"]').text(data.billing_country);
          $('[id="billing_state"]').text(data.billing_state);
          $('[id="shipping_country"]').text(data.shipping_country);
          $('[id="shipping_state"]').text(data.shipping_state);
          $('[id="billing_city"]').text(data.billing_city);
          $('[id="billing_zipcode"]').text(data.billing_zipcode);
          $('[id="shipping_city"]').text(data.shipping_city);
          $('[id="shipping_zipcode"]').text(data.shipping_zipcode);
          $('[id="billing_address"]').text(data.billing_address);
          $('[id="shipping_address"]').text(data.shipping_address);
          $('[id="description"]').html(data.description);
          var product_name = data.product_name;
          var quantity = data.quantity;
          var unit_price = data.unit_price;
          var total = data.total;
          var percent = data.percent;
          var p_name = product_name.split('<br>');
          var qty = quantity.split('<br>');
          var u_prc = unit_price.split('<br>');
          var ttl = total.split('<br>');
          for (var i=0; i < p_name.length; i++)
          {
            var markup = "<tr><td><h6 class='text-primary'>"+p_name[i]+"</h6></td>"+
            "<td><h6 class='text-primary'>"+qty[i]+"</h6></td>"+
            "<td><h6 class='text-primary'>"+numberToIndPrice(u_prc[i])+"</h6></td>"+
            "<td><h6 class='text-primary'>"+numberToIndPrice(ttl[i])+"</h6></td></tr>";
            $("#add2").append(markup);
          }
          $('[id="initial_total"]').text(numberToIndPrice(data.initial_total));
          $('[id="discount"]').text(data.discount);
          $('[id="sub_total"]').text(numberToIndPrice(data.sub_total));
          $('[id="total_percent"]').text(data.total_percent);
           if(data.track_status == "lead")
          { 
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected_red');
            $('#quote').addClass('selected_red');
            $('#salesorder').addClass('selected_red');
            $('#purchaseorder').addClass('selected_red');
          }
          else if(data.track_status == "opportunity")
          {
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected');
            $('#quote').addClass('selected_red');
            $('#salesorder').addClass('selected_red');
            $('#purchaseorder').addClass('selected_red');
          }
          else if(data.track_status == "quote")
          {
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected');
            $('#quote').addClass('selected');
            $('#salesorder').addClass('selected_red');
            $('#purchaseorder').addClass('selected_red');
          }
          else if(data.track_status == "salesorder")
          {
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected');
            $('#quote').addClass('selected');
            $('#salesorder').addClass('selected');
            $('#purchaseorder').addClass('selected_red');
          }
          else if(data.track_status == "purchaseorder")
          {
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected');
            $('#quote').addClass('selected');
            $('#salesorder').addClass('selected');
            $('#purchaseorder').addClass('selected');
          }
          else if(data.track_status == "")
          {
            $('#leads').addClass('selected');
            $('#opportunity').addClass('selected_red');
            $('#quote').addClass('selected_red');
            $('#salesorder').addClass('selected_red');
            $('#purchaseorder').addClass('selected_red');
          }
          $('#addnew_modal').modal('show'); // show bootstrap modal when complete loaded
          $('.modal-title').text('Lead'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          alert('Error Retrieving Data From Database');
        }
      });
    }
	
  <?php endif; ?>

 
  <?php if(check_permission_status('Leads','delete_u')==true):?>
    function delete_entry(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
        $.ajax({
          url : "<?= base_url('leads/delete')?>/"+id,
          type: "POST",
          dataType: "JSON",
          success: function(data)
          {
              //if success reload ajax table
              $('#lead_modal').modal('hide');
              window.location.reload();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error deleting data');
          }
        });
      }
    }
  <?php endif; ?>
</script>
<!-- AUTOCOMPLETE QUERY -->
<script>
function refreshPage(){
    window.location.reload();
} 

function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);

table.ajax.reload();
}
</script>
