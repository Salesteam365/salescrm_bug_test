<?php $this->load->view('common_navbar');?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Set Permission for <?=$user->standard_name;?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()."assets/"; ?>#">Home</a></li>
              <li class="breadcrumb-item active">Permission</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row mb-3">
          <div class="col-lg-2">
            
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btn-info btn-sm" onClick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
	
	<?php if(isset($user->id)){ ?>
	
	<input type="hidden" value="<?=$user->id;?>" id="userid" >
	<input type="hidden" value="<?=$user->standard_name;?>" id="username" >
	<input type="hidden" value="<?=$user->standard_email;?>" id="useremail" >
	
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
            <div class="card org_div">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dt-multi-checkbox1" class="table table-sm  table-bordered table-responsive-lg text-center" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="th-sm" width="20%">Module</th>
                            <th class="th-sm">Create</th>
                            <th class="th-sm">Update</th>
                            <th class="th-sm">Retrieve</th>
                            <th class="th-sm">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
						<tr>
                            <td class="text-left pl-3">Sellect All</td>
                            <td>
                              <label class="switch">
								<input type="checkbox"  id="selectAllCreate" >
								<span class="slider round createCl"></span>
							  </label>
                            </td>
                            <td>
                              <label class="switch">
								<input type="checkbox" id="selectAllUpdate" >
								<span class="slider round updateAll"></span>
							  </label>
                            </td>
                            <td>
                              <label class="switch">
							  <input type="checkbox" id="selectAllRetrieve" >
							  <span class="slider round retrieveAll"></span>
							  </label>
                            </td>
                            <td>
                              <label class="switch">
							  <input type="checkbox" id="selectAllDelete">
							  <span class="slider round deleteAll"></span>
							  </label>
                            </td>
                        </tr>
					<?php $data=check_permission('Customer',$user->id);?>
                        <tr>
                            <td class="text-left pl-3">Customer</td>
                            <td>
                              <label class="switch">
								<input type="checkbox"  id="customerMdl" onChange="setStatus('customerMdl','Customer','create_u');" <?php if(isset($data['create_u']) && $data['create_u']==1){ echo "checked"; } ?> ><span class="slider round createCl"></span>
							  </label>
                            </td>
                            <td>
                              <label class="switch">
								<input type="checkbox" id="customerMdlUp" onChange="setStatus('customerMdlUp','Customer','update_u');" <?php if(isset($data['update_u']) && $data['update_u']==1){ echo "checked"; } ?> >
								<span class="slider round updateAll"></span>
							  </label>
                            </td>
                            <td>
                              <label class="switch">
							  <input type="checkbox" id="customerMdlRet" onChange="setStatus('customerMdlRet','Customer','retrieve_u');" <?php if(isset($data['retrieve_u']) && $data['retrieve_u']==1){ echo "checked"; } ?> ><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="customerMdlDel" onChange="setStatus('customerMdlDel','Customer','delete_u');" <?php if(isset($data['delete_u']) && $data['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
					<?php $data2=check_permission('Contacts',$user->id);?>
                        <tr>
                            <td class="text-left pl-3">Contacts</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ContactsMdl" onChange="setStatus('ContactsMdl','Contacts','create_u');" <?php if(isset($data2['create_u']) && $data2['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ContactsMdlUp" onChange="setStatus('ContactsMdlUp','Contacts','update_u');" <?php if(isset($data2['update_u']) && $data2['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ContactsMdlRt" onChange="setStatus('ContactsMdlRt','Contacts','retrieve_u');" <?php if(isset($data2['retrieve_u']) && $data2['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ContactsMdlDel" onChange="setStatus('ContactsMdlDel','Contacts','delete_u');" <?php if(isset($data2['delete_u']) && $data2['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
					<?php $Leads=check_permission('Leads',$user->id);?>	
                        <tr>
                            <td class="text-left pl-3">Leads</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="LeadsMdl" onChange="setStatus('LeadsMdl','Leads','create_u');" <?php if(isset($Leads['create_u']) && $Leads['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="LeadsMdlUp" onChange="setStatus('LeadsMdlUp','Leads','update_u');" <?php if(isset($Leads['update_u']) && $Leads['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="LeadsMdlRt" onChange="setStatus('LeadsMdlRt','Leads','retrieve_u');" <?php if(isset($Leads['retrieve_u']) && $Leads['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="LeadsMdlDel" onChange="setStatus('LeadsMdlDel','Leads','delete_u');" <?php if(isset($Leads['delete_u']) && $Leads['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
					<?php $opp=check_permission('Opportunity',$user->id);?>	
                        <tr>
                            <td class="text-left pl-3">Opportunity</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="OpportunityMdl" onChange="setStatus('OpportunityMdl','Opportunity','create_u');" <?php if(isset($opp['create_u']) && $opp['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="OpportunityMdlUp" onChange="setStatus('OpportunityMdlUp','Opportunity','update_u');" <?php if(isset($opp['update_u']) && $opp['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="OpportunityMdlRt" onChange="setStatus('OpportunityMdlRt','Opportunity','retrieve_u');" <?php if(isset($opp['retrieve_u']) && $opp['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="OpportunityMdlDel" onChange="setStatus('OpportunityMdlDel','Opportunity','delete_u');" <?php if(isset($opp['delete_u']) && $opp['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $quote=check_permission('Quotations',$user->id);?>	
                        <tr>
                            <td class="text-left pl-3">Quotations</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="QuotationsMdl" onChange="setStatus('QuotationsMdl','Quotations','create_u');" <?php if(isset($quote['create_u']) && $quote['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="QuotationsMdlUp" onChange="setStatus('QuotationsMdlUp','Quotations','update_u');" <?php if(isset($quote['update_u']) && $quote['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="QuotationsMdlRt" onChange="setStatus('QuotationsMdlRt','Quotations','retrieve_u');" <?php if(isset($quote['retrieve_u']) && $quote['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="QuotationsMdlDel" onChange="setStatus('QuotationsMdlDel','Quotations','delete_u');" <?php if(isset($quote['delete_u']) && $quote['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $so=check_permission('Salesorders',$user->id);?>
                        <tr>
                            <td class="text-left pl-3">Salesorders</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SalesordersMdl" onChange="setStatus('SalesordersMdl','Salesorders','create_u');" <?php if(isset($so['create_u']) && $so['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SalesordersMdlUp" onChange="setStatus('SalesordersMdlUp','Salesorders','update_u');" <?php if(isset($so['update_u']) && $so['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SalesordersMdlRt" onChange="setStatus('SalesordersMdlRt','Salesorders','retrieve_u');" <?php if(isset($so['retrieve_u']) && $so['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SalesordersMdlDel" onChange="setStatus('SalesordersMdlDel','Salesorders','delete_u');" <?php if(isset($so['delete_u']) && $so['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $Proforma=check_permission('Proforma Invoice',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Proforma Invoice</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProformaMdl" onChange="setStatus('ProformaMdl','Proforma Invoice','create_u');" <?php if(isset($Proforma['create_u']) && $Proforma['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProformaMdlUp" onChange="setStatus('ProformaMdlUp','Proforma Invoice','update_u');" <?php if(isset($Proforma['update_u']) && $Proforma['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProformaMdlRt" onChange="setStatus('ProformaMdlRt','Proforma Invoice','retrieve_u');" <?php if(isset($Proforma['retrieve_u']) && $Proforma['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProformaMdlDel" onChange="setStatus('ProformaMdlDel','Proforma Invoice','delete_u');" <?php if(isset($Proforma['delete_u']) && $Proforma['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
					<?php $vendor=check_permission('Vendor',$user->id);?>	
                        <tr>
                            <td class="text-left pl-3">Vendor</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="VendorMdl" onChange="setStatus('VendorMdl','Vendor','create_u');" <?php if(isset($vendor['create_u']) && $vendor['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="VendorMdlUp" onChange="setStatus('VendorMdlUp','Vendor','update_u');" <?php if(isset($vendor['update_u']) && $vendor['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="VendorMdlRt" onChange="setStatus('VendorMdlRt','Vendor','retrieve_u');" <?php if(isset($vendor['retrieve_u']) && $vendor['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="VendorMdlDel" onChange="setStatus('VendorMdlDel','Vendor','delete_u');" <?php if(isset($vendor['delete_u']) && $vendor['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
					<?php $purchase=check_permission('Purchase Order',$user->id);?>	
                        <tr>
                            <td class="text-left pl-3">Purchase Order</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="PurchaseMdl" onChange="setStatus('VendorMdl','Purchase Order','create_u');" <?php if(isset($purchase['create_u']) && $purchase['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="PurchaseMdlUp" onChange="setStatus('VendorMdlUp','Purchase Order','update_u');" <?php if(isset($purchase['update_u']) && $purchase['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="PurchaseMdlRt" onChange="setStatus('PurchaseMdlRt','Purchase Order','retrieve_u');" <?php if(isset($purchase['retrieve_u']) && $purchase['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="PurchaseMdlDel" onChange="setStatus('VendorMdlDel','Purchase Order','delete_u');" <?php if(isset($purchase['delete_u']) && $purchase['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr> 
					<?php $invoice=check_permission('Invoice',$user->id);?>		
                        <tr>
                            <td class="text-left pl-3">Invoice</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="InvoiceMdl" onChange="setStatus('VendorMdl','Invoice','create_u');" <?php if(isset($invoice['create_u']) && $invoice['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="InvoiceMdlUp" onChange="setStatus('InvoiceMdlUp','Invoice','update_u');" <?php if(isset($invoice['update_u']) && $invoice['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="InvoiceMdlRt" onChange="setStatus('InvoiceMdlRt','Invoice','retrieve_u');" <?php if(isset($invoice['retrieve_u']) && $invoice['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="InvoiceMdlDel" onChange="setStatus('InvoiceMdlDel','Invoice','delete_u');" <?php if(isset($data['delete_u']) && $data['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $product=check_permission('Product',$user->id);?>	
						<tr>
                            <td class="text-left pl-3">Product</td>
                           <td>
                              <label class="switch"><input type="checkbox" id="ProductMdl" onChange="setStatus('ProductMdl','Product','create_u');" <?php if(isset($product['create_u']) && $product['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProductMdlUp" onChange="setStatus('ProductMdlUp','Product','update_u');" <?php if(isset($product['update_u']) && $product['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProductMdlRt" onChange="setStatus('ProductMdlRt','Product','retrieve_u');" <?php if(isset($product['retrieve_u']) && $product['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ProductMdlDel" onChange="setStatus('ProductMdlDel','Product','delete_u');" <?php if(isset($product['delete_u']) && $product['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $task=check_permission('Task',$user->id);?>	
						<tr>
                            <td class="text-left pl-3">Task</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="TaskMdl" onChange="setStatus('TaskMdl','Task','create_u');" <?php if(isset($task['create_u']) && $task['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="TaskMdlUp" onChange="setStatus('TaskMdlUp','Task','update_u');" <?php if(isset($task['update_u']) && $task['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="TaskMdlRt" onChange="setStatus('TaskMdlRt','Task','retrieve_u');" <?php if(isset($task['retrieve_u']) && $task['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="TaskMdlDel" onChange="setStatus('TaskMdlDel','Task','delete_u');" <?php if(isset($task['delete_u']) && $task['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $meeting=check_permission('Meeting',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Meeting</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="MeetingMdl" onChange="setStatus('MeetingMdl','Meeting','create_u');" <?php if(isset($meeting['create_u']) && $meeting['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="MeetingMdlUp" onChange="setStatus('MeetingMdlUp','Meeting','update_u');" <?php if(isset($meeting['update_u']) && $meeting['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="MeetingMdlRt" onChange="setStatus('MeetingMdlRt','Meeting','retrieve_u');" <?php if(isset($meeting['retrieve_u']) && $meeting['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="MeetingMdlDel" onChange="setStatus('MeetingMdlDel','Meeting','delete_u');" <?php if(isset($meeting['delete_u']) && $meeting['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $call=check_permission('Call',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Call</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="CallMdl" onChange="setStatus('CallMdl','Call','create_u');" <?php if(isset($call['create_u']) && $call['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="CallMdlUp" onChange="setStatus('CallMdlUp','Call','update_u');" <?php if(isset($call['update_u']) && $call['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="CallMdlRt" onChange="setStatus('CallMdlRt','Call','retrieve_u');" <?php if(isset($call['retrieve_u']) && $call['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="CallMdlDel" onChange="setStatus('CallMdlDel','Call','delete_u');" <?php if(isset($call['delete_u']) && $call['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $gst=check_permission('GST',$user->id);?>
						<tr>
                            <td class="text-left pl-3">GST</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="GSTMdl" onChange="setStatus('GSTMdl','GST','create_u');" <?php if(isset($gst['create_u']) && $gst['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="GSTMdlUp" onChange="setStatus('GSTMdlUp','GST','update_u');" <?php if(isset($gst['update_u']) && $gst['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="GSTMdlRt" onChange="setStatus('GSTMdlRt','Call','retrieve_u');" <?php if(isset($gst['retrieve_u']) && $gst['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="GSTMdlDel" onChange="setStatus('GSTMdlDel','GST','delete_u');" <?php if(isset($gst['delete_u']) && $gst['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $report=check_permission('Reports',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Reports</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ReportsMdl" onChange="setStatus('ReportsMdl','Reports','create_u');" <?php if(isset($report['create_u']) && $report['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ReportsMdlUp" onChange="setStatus('ReportsMdlUp','Reports','update_u');" <?php if(isset($report['update_u']) && $report['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ReportsMdlRt" onChange="setStatus('ReportsMdlRt','Reports','retrieve_u');" <?php if(isset($report['retrieve_u']) && $report['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ReportsMdlDel" onChange="setStatus('ReportsMdlDel','Reports','delete_u');" <?php if(isset($report['delete_u']) && $report['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $forecast=check_permission('Forecast and Quota',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Forecast and Quota</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ForecastMdl" onChange="setStatus('ForecastMdl','Forecast and Quota','create_u');" <?php if(isset($forecast['create_u']) && $forecast['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ForecastMdlUp" onChange="setStatus('ForecastMdlUp','Forecast and Quota','update_u');" <?php if(isset($forecast['update_u']) && $forecast['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ForecastMdlRt" onChange="setStatus('ForecastMdlRt','Forecast and Quota','retrieve_u');" <?php if(isset($forecast['retrieve_u']) && $forecast['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="ForecastMdlDel" onChange="setStatus('ForecastMdlDel','Forecast and Quota','delete_u');" <?php if(isset($forecast['delete_u']) && $forecast['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $integrat=check_permission('Integration',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Integration</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="IntegrationMdl" onChange="setStatus('IntegrationMdl','Integration','create_u');" <?php if(isset($integrat['create_u']) && $integrat['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="IntegrationMdlUp" onChange="setStatus('IntegrationMdlUp','Integration','update_u');" <?php if(isset($integrat['update_u']) && $integrat['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="IntegrationMdlRt" onChange="setStatus('IntegrationMdlRt','Integration','retrieve_u');" <?php if(isset($integrat['retrieve_u']) && $integrat['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="IntegrationMdlDel" onChange="setStatus('IntegrationMdlDel','Integration','delete_u');" <?php if(isset($integrat['delete_u']) && $integrat['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>
						<?php $setid=check_permission('Set Prefix ID',$user->id);?>
						<tr>
                            <td class="text-left pl-3">Set Prefix ID</td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SetMdl" onChange="setStatus('SetMdl','Set Prefix ID','create_u');" <?php if(isset($setid['create_u']) && $setid['create_u']==1){ echo "checked"; } ?>><span class="slider round createCl"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SetMdlUp" onChange="setStatus('SetMdlUp','Set Prefix ID','update_u');" <?php if(isset($setid['update_u']) && $setid['update_u']==1){ echo "checked"; } ?>><span class="slider round updateAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SetMdlRt" onChange="setStatus('SetMdlRt','Set Prefix ID','retrieve_u');" <?php if(isset($setid['retrieve_u']) && $setid['retrieve_u']==1){ echo "checked"; } ?>><span class="slider round retrieveAll"></span></label>
                            </td>
                            <td>
                              <label class="switch"><input type="checkbox" id="SetMdlDel" onChange="setStatus('SetMdlDel','Set Prefix ID','delete_u');" <?php if(isset($setid['delete_u']) && $setid['delete_u']==1){ echo "checked"; } ?>><span class="slider round deleteAll"></span></label>
                            </td>
                        </tr>	
                    </tbody>
                </table>

                <table class="table table-sm text-center  table-bordered table-responsive-lg mt-4" style="width: 38%;">
                  <thead>
                    <tr>
                      <th class="th-sm" width="60%">Other Permission</th>
                      <th>Others</th>
                    </tr>
                  </thead>
                  <tbody>
					<tr>
                      <td class="text-left pl-3">Select All</td>
                      <td>
                        <label class="switch">
							<input type="checkbox" id="selectAllOther">
							<span class="slider round selectOther"></span>
						</label>
                      </td>
                    </tr>
				  <?php $canApprove=check_permission('Sales Order can approve',$user->id);?>
				    <tr>
                      <td class="text-left pl-3">Sales Order can approve</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="soApprMdlUp" onChange="setStatus('soApprMdlUp','Sales Order can approve','other');" <?php if(isset($canApprove['other']) && $canApprove['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $canApprovePo=check_permission('Purchase Order can approve',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Purchase Order can approve</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="poApprMdlUp" onChange="setStatus('poApprMdlUp','Purchase Order can approve','other');" <?php if(isset($canApprovePo['other']) && $canApprovePo['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $nonsl=check_permission('No need to approve sales order',$user->id);?>
				    <tr>
                      <td class="text-left pl-3">No need to approve sales order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="nonMdlUp" onChange="setStatus('nonMdlUp','No need to approve sales order','other');" <?php if(isset($nonsl['other']) && $nonsl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $nonpo=check_permission('No need to approve purchase order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">No need to approve purchase order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="nonpoMdlUp" onChange="setStatus('nonpoMdlUp','No need to approve purchase order','other');" <?php if(isset($nonpo['other']) && $nonpo['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $nonslmt=check_permission('No need to approve sales order on limit',$user->id);?>
				    <tr>
                      <td class="text-left pl-3">No need to approve sales order on limit</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="noslMdlUp" onChange="setStatus('noslMdlUp','No need to approve sales order on limit','other');" <?php if(isset($nonslmt['other']) && $nonslmt['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $nonpomt=check_permission('No need to approve purchase order on limit',$user->id);?>
					<tr>
                      <td class="text-left pl-3">No need to approve purchase order on limit</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="noplMdlUp" onChange="setStatus('noplMdlUp','No need to approve purchase order on limit','other');" <?php if(isset($nonpomt['other']) && $nonpomt['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $RecRnMl=check_permission('Receive Renewal Mail',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive Renewal Mail</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="RenewalMdlUp" onChange="setStatus('RenewalMdlUp','Receive Renewal Mail','other');" <?php if(isset($RecRnMl['other']) && $RecRnMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $RecRnMlpop=check_permission('Receive  Renewal Alerts (in popup)',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive  Renewal Alerts (in popup) </td>
                      <td>
                        <label class="switch"><input type="checkbox" id="RenewalAlertsMdlUp" onChange="setStatus('RenewalAlertsMdlUp','Receive  Renewal Alerts (in popup)','other');" <?php if(isset($RecRnMlpop['other']) && $RecRnMlpop['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $frcqt=check_permission('Receive Forecast and Quota (All Users)',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive Forecast and Quota (All Users)</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="ReceiveForecast" onChange="setStatus('ReceiveForecast','Receive Forecast and Quota (All Users)','other');" <?php if(isset($frcqt['other']) && $frcqt['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $recpml=check_permission('Receive Pending Payment Mail',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive Pending Payment Mail</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="ReceivePending" onChange="setStatus('ReceivePending','Receive Pending Payment Mail','other');" <?php if(isset($recpml['other']) && $recpml['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $retrAct=check_permission('Retrieve Activities',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Retrieve Activities</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="Activities" onChange="setStatus('Activities','Retrieve Activities','other');" <?php if(isset($retrAct['other']) && $retrAct['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $custMl=check_permission('Receive email on create customer',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive email on create customer</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="emailoncreate" onChange="setStatus('emailoncreate','Receive email on create customer','other');" <?php if(isset($custMl['other']) && $custMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $leadMl=check_permission('Receive mail on create lead',$user->id);?>
                    <tr>
                      <td class="text-left pl-3">Receive mail on create lead</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="createlead" onChange="setStatus('createlead','Receive mail on create lead','other');" <?php if(isset($leadMl['other']) && $leadMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $oppMl=check_permission('Receive mail on create opportunity',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on create opportunity</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="createopportunity" onChange="setStatus('createopportunity','Receive mail on create opportunity','other');" <?php if(isset($oppMl['other']) && $oppMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $qtMl=check_permission('Receive mail on create quotation',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on create quotation</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="createquotation" onChange="setStatus('createquotation','Receive mail on create quotation','other');" <?php if(isset($qtMl['other']) && $qtMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $soMl=check_permission('Receive mail on create sales order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on create sales order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="createsalesorder" onChange="setStatus('createsalesorder','Receive mail on create sales order','other');" <?php if(isset($soMl['other']) && $soMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $poMl=check_permission('Receive mail on create purchase order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on create purchase order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="createpurchaseorder" onChange="setStatus('createpurchaseorder','Receive mail on create purchase order','other');" <?php if(isset($poMl['other']) && $poMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $ldpoMl=check_permission('Receive mail on create purchase order of user sales order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on create purchase order of user sales order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="purchaseorderMdlUp" onChange="setStatus('purchaseorderMdlUp','Receive mail on create purchase order of user sales order','other');" <?php if(isset($ldpoMl['other']) && $ldpoMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $reappMl=check_permission('Receive mail on approving sales order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on approving sales order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="approvingsales" onChange="setStatus('approvingsales','Receive mail on approving sales order','other');" <?php if(isset($reappMl['other']) && $reappMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					<?php $reapppoMl=check_permission('Receive mail on approving purchase order',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on approving purchase order</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="approvingpurchase" onChange="setStatus('approvingpurchase','Receive mail on approving purchase order','other');" <?php if(isset($reapppoMl['other']) && $reapppoMl['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					
					<?php $reappMlp=check_permission('Receive mail on approving sales order for purchase team',$user->id);?>
					<tr>
                      <td class="text-left pl-3">Receive mail on approving sales order for purchase team</td>
                      <td>
                        <label class="switch"><input type="checkbox" id="approvingsalesp" onChange="setStatus('approvingsalesp','Receive mail on approving sales order for purchase team','other');" <?php if(isset($reappMlp['other']) && $reappMlp['other']==1){ echo "checked"; } ?>><span class="slider round selectOther"></span></label>
                      </td>
                    </tr>
					
                  </tbody>
                </table>
              </div>
            </div>
      </div>
    </section>
	<?php }  ?>
  </div>

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script>

	$("#selectAllCreate").click(function () {
		$(".createCl").click();
    });
	
	$("#selectAllUpdate").click(function () {
		$(".updateAll").click();
    });
	$("#selectAllRetrieve").click(function () {
		$(".retrieveAll").click();
    });
	
	$("#selectAllDelete").click(function () {
		$(".deleteAll").click();
    });
	$("#selectAllOther").click(function () {
		$(".selectOther").click();
    });

function refreshPage(){
    window.location.reload();
} 

function setStatus(customerMdl,muduleName,clmn){
	var status = 0;
    if ($("#"+customerMdl).is(':checked')){
		status = 1;
	}else{
		status = 0;
	}
	var userid 	 = $("#userid").val();
	var email 	 = $("#useremail").val();
	var username = $("#username").val();
	$.ajax({
          url : "<?= base_url('permission/change_permission')?>",
          type: "POST",
          data: { mdlName:muduleName,status:status,userEmail:email,userid:userid,clmn:clmn },
          success: function(data)
          {
			if(status==1) { 
                toastr.success('Your action has been performed successfully.');  
			}else{
				toastr.error('Your action has been performed successfully.');  
			}
          }
    });
} 

</script>
