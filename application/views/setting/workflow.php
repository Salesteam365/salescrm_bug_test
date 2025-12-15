<?php $this->load->view('common_navbar');?>
<style>
   .linkscontainer{
width:70vw;
padding:20px;
padding-top:50px;
border-radius:10px;
box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
margin:20px auto;
margin-bottom:50px;

}

  #dt-multi-checkbox1 thead tr th{
   background:rgba(35, 0, 140, 0.8);
  

}
#dt-multi-checkbox1 thead tr th{
   background-color:#fff;
   color:#000;
   font-size: 16px;
   border-bottom:none;
   padding-top:18px;
  padding-bottom:18px;
  

}


#dt-multi-checkbox1 tbody tr td {
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



@media screen and (max-width: 576px) {
.linkscontainer {
 width: 100vw;
}
}
</style>
  <div class="content-wrapper" style="background-color:rgba(240,240,246,0.8);">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Set Workflow</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>#">Home</a></li>
              <li class="breadcrumb-item active">Workflow</li>
            </ol>
          </div><!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="container-fliud filterbtncon"  >
        <div class="row mb-3">
        

          <?php $moduleArr=array('Admin','Customer','Vendor','Lead','Opportunity','Quotation','Sales order','Invoice','Purchase order'); ?>
			  
			  
     
  


          
          <!-- rfe -->
          <div class="col-lg-2">
        <?php if($this->session->userdata('type') == 'admin') { ?>
          <div class="first-one custom-dropdown dropdown">
    <button class="custom-select bt dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Select Option
    </button>
    <input type="hidden" id="selectFilter" value="" name="selectFilter">
    <ul class="custom-options dropdown-menu" aria-labelledby="dropdownMenuButton">
         
            <?php foreach($moduleArr as $adminDtl) { ?>
              <li onclick="getfilterdData('<?=$adminDtl;?>','selectFilter');"><?=$adminDtl;?></li>
            <?php } ?>
            
            </ul>
            </div>
        <?php } ?>
      </div>
          <!--wer  -->
          <div class="col-lg-4"></div>
          <div class="col-lg-6">
              <div class="refresh_button float-right">
                  <button class="btn btnstopcorner btn-sm" onClick="refreshPage()"><i class="fas fa-redo-alt"></i></button>
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
	
	<?php
	if(isset($user[0]['admin_email'])){ ?>
	
	<input type="hidden" value="<?=$user[0]['admin_name'];?>" id="username" >
	<input type="hidden" value="<?=$user[0]['admin_email'];?>" id="useremail" >
	  
  <div class="linkscontainer"style="background:#fff;">
    
      
        <!-- Main row -->
            
              <!-- /.card-header -->
			 
			  
			  
                <table id="dt-multi-checkbox1" class="table table-sm  table-bordered table-responsive-lg text-center" cellspacing="0" style="width:100%">
                    <thead style="background:rgba(35,0,140,0.8);">
                        <tr class="thMdl">
                            <th class="th-sm" width="20%">Module</th>
                            <th class="th-sm">Work Flow Name</th>
                            <th class="th-sm">Trigger</th>
                        </tr>
                    </thead>
                    <tbody>
					<tr>
                            <td class="text-left pl-3"></td>
                            <td class="text-left pl-3">Sellect All</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" id="ckbCheckAll"  >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
					<?php $adminA=check_workflow('Admin','Mail notification on customer created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on customer created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall" id="adminA" onChange="setStatus('adminA','Admin','Mail notification on customer created');" <?php if(isset($adminA['trigger_workflow_on']) && $adminA['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin2=check_workflow('Admin','Mail notification on leads created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on leads created</td>
                            <td>
                              <label class="switch" >
								<input type="checkbox" class="checkall"  id="admin2" onChange="setStatus('admin2','Admin','Mail notification on leads created');" <?php if(isset($admin2['trigger_workflow_on']) && $admin2['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round" ></span>
							  </label>
                            </td>
                        </tr>
						
						<?php $admin3=check_workflow('Admin','Mail notification on opportunity created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on opportunity created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin3" onChange="setStatus('admin3','Admin','Mail notification on opportunity created');" <?php if(isset($admin3['trigger_workflow_on']) && $admin3['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php $admin4=check_workflow('Admin','Mail notification on quotation created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on quotation created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin4" onChange="setStatus('admin4','Admin','Mail notification on quotation created');" <?php if(isset($admin4['trigger_workflow_on']) && $admin4['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin5=check_workflow('Admin','Mail notification on sales order created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on sales order created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin5" onChange="setStatus('admin5','Admin','Mail notification on sales order created');" <?php if(isset($admin5['trigger_workflow_on']) && $admin5['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin6=check_workflow('Admin','Mail notification on purchase order created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on purchase order created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin6" onChange="setStatus('admin6','Admin','Mail notification on purchase order created');" <?php if(isset($admin6['trigger_workflow_on']) && $admin6['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin7=check_workflow('Admin','Mail notification on vendor created');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on vendor created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin7" onChange="setStatus('admin7','Admin','Mail notification on vendor created');" <?php if(isset($admin7['trigger_workflow_on']) && $admin7['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin8=check_workflow('Admin','Mail notification on approve sales order');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on approve sales order</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin8" onChange="setStatus('admin8','Admin','Mail notification on approve sales order');" <?php if(isset($admin8['trigger_workflow_on']) && $admin8['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin9=check_workflow('Admin','Mail notification on approve purchase order');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on approve purchase order</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin9" onChange="setStatus('admin9','Admin','Mail notification on approve purchase order');" <?php if(isset($admin9['trigger_workflow_on']) && $admin9['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $admin11=check_workflow('Admin','Mail notification on invoice create');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on invoice create</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin11" onChange="setStatus('admin11','Admin','Mail notification on invoice create');" <?php if(isset($admin11['trigger_workflow_on']) && $admin11['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
                        
                        <?php $invpay=check_workflow('Admin','Mail notification on accept invoice payment');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification on accept invoice payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invpay" onChange="setStatus('invpay','Admin','Mail notification on accept invoice payment');" <?php if(isset($invpay['trigger_workflow_on']) && $invpay['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
                        
						<?php $admin10=check_workflow('Admin','Mail notification SO pending Payment');?>
                        <tr class="Admin">
                            <td class="text-left pl-3">Admin</td>
                            <td class="text-left pl-3">Mail notification SO pending Payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="admin10" onChange="setStatus('admin10','Admin','Mail notification SO pending Payment');" <?php if(isset($admin10['trigger_workflow_on']) && $admin10['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
					<?php $data=check_workflow('Customer','Welecome mail on created');?>
                        <tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Welecome mail on created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer1" onChange="setStatus('customer1','Customer','Welecome mail on created');" <?php if(isset($data['trigger_workflow_on']) && $data['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $Customer=check_workflow('Customer','Mail notification to customer owner on created');?>
                        <tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification to customer owner on created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer0" onChange="setStatus('customer0','Customer','Mail notification to customer owner on created');" <?php if(isset($Customer['trigger_workflow_on']) && $Customer['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $data2=check_workflow('Customer','Mail notification on quotation created');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification on quotation created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer2" onChange="setStatus('customer2','Customer','Mail notification on quotation created');" <?php if(isset($data2['trigger_workflow_on']) && $data2['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $data3=check_workflow('Customer','Mail notification on so created');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification on so created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer3" onChange="setStatus('customer3','Customer','Mail notification on so created');" <?php if(isset($data3['trigger_workflow_on']) && $data3['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
                        <?php $invce=check_workflow('Customer','Mail notification on invoice created');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification on invoice created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invce3" onChange="setStatus('invce3','Customer','Mail notification on invoice created');" <?php if(isset($invce['trigger_workflow_on']) && $invce['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
                        <?php $accept=check_workflow('Customer','Mail notification on accept payment');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification on accept payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="accept4" onChange="setStatus('accept4','Customer','Mail notification on accept payment');" <?php if(isset($accept['trigger_workflow_on']) && $accept['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $data4=check_workflow('Customer','Mail notification for renewal');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification for renewal</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer4" onChange="setStatus('customer4','Customer','Mail notification for renewal');" <?php if(isset($data4['trigger_workflow_on']) && $data4['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $data5=check_workflow('Customer','Mail notification for followup');?>
						<tr class="Customer">
                            <td class="text-left pl-3">Customer</td>
                            <td class="text-left pl-3">Mail notification for followup</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="customer5" onChange="setStatus('customer5','Customer','Mail notification for followup');" <?php if(isset($data5['trigger_workflow_on']) && $data5['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						
						
						<?php $vendor=check_workflow('Vendor','Welecome mail on created');?>
                        <tr class="Vendor">
                            <td class="text-left pl-3">Vendor</td>
                            <td class="text-left pl-3">Welecome mail on created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="vendor1" onChange="setStatus('vendor1','Vendor','Welecome mail on created');" <?php if(isset($vendor['trigger_workflow_on']) && $vendor['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php $vendor2=check_workflow('Vendor','Mail notification on created purchase order');?>
                        <tr class="Vendor">
                            <td class="text-left pl-3">Vendor</td>
                            <td class="text-left pl-3">Mail notification on created purchase order</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="vendor2" onChange="setStatus('vendor2','Vendor','Mail notification on created purchase order');" <?php if(isset($vendor2['trigger_workflow_on']) && $vendor2['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$leads=check_workflow('Lead','Mail notification to lead owner on lead created');
						?>
                        <tr class="Lead">
                            <td class="text-left pl-3">Lead</td>
                            <td class="text-left pl-3">Mail notification to lead owner on lead created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="Lead1" onChange="setStatus('Lead1','Lead','Mail notification to lead owner on lead created');" <?php if(isset($leads['trigger_workflow_on']) && $leads['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$opp=check_workflow('Opportunity','Mail notification to opportunity owner on opportunity created');
						?>
                        <tr class="Opportunity">
                            <td class="text-left pl-3">Opportunity</td>
                            <td class="text-left pl-3">Mail notification to opportunity owner on opportunity created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="opportunity1" onChange="setStatus('opportunity1','Opportunity','Mail notification to opportunity owner on opportunity created');" <?php if(isset($opp['trigger_workflow_on']) && $opp['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$quotation=check_workflow('Quotation','Mail notification to quotation owner on quotation created');
						?>
                        <tr class="Quotation">
                            <td class="text-left pl-3">Quotation</td>
                            <td class="text-left pl-3">Mail notification to quotation owner on quotation created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="quotation1" onChange="setStatus('quotation1','Quotation','Mail notification to quotation owner on quotation created');" <?php if(isset($quotation['trigger_workflow_on']) && $quotation['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$salesorder=check_workflow('Sales order','Mail notification to sales order owner on sales order created');
						?>
                        <tr class="Sales_order">
                            <td class="text-left pl-3">Sales order</td>
                            <td class="text-left pl-3">Mail notification to sales order owner on sales order created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="salesorder" onChange="setStatus('salesorder','Sales order','Mail notification to sales order owner on sales order created');" <?php if(isset($salesorder['trigger_workflow_on']) && $salesorder['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$salesorderAp=check_workflow('Sales order','Mail notification to sales owner on sales order approve');
						?>
                        <tr class="Sales_order">
                            <td class="text-left pl-3">Sales order</td>
                            <td class="text-left pl-3">Mail notification to sales owner on sales order approve</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="salesorder1" onChange="setStatus('salesorder1','Sales order','Mail notification to sales owner on sales order approve');" <?php if(isset($salesorderAp['trigger_workflow_on']) && $salesorderAp['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$salesorderApp=check_workflow('Sales order','Mail notification to all PO creater on sales order approve');
						?>
                        <tr class="Sales_order">
                            <td class="text-left pl-3">Sales order</td>
                            <td class="text-left pl-3">Mail notification to all PO creater on sales order approve</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="salesorder2" onChange="setStatus('salesorder2','Sales order','Mail notification to all PO creater on sales order approve');" <?php if(isset($salesorderApp['trigger_workflow_on']) && $salesorderApp['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$salesorderCmp=check_workflow('Sales order','Comolete sales order without purchase order');
						?>
                        <tr class="Sales_order">
                            <td class="text-left pl-3">Sales order</td>
                            <td class="text-left pl-3">Comolete sales order without purchase order</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="salesorderCmp" onChange="setStatus('salesorderCmp','Sales order','Comolete sales order without purchase order');" <?php if(isset($salesorderCmp['trigger_workflow_on']) && $salesorderCmp['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$salesorder5=check_workflow('Sales order','Auto approve by limit SO');
						?>
                        <tr class="Sales_order">
                            <td class="text-left pl-3">Sales order</td>
                            <td class="text-left pl-3">
							<div class="row">
							<div class="col-md-6">Auto approve by limit SO</div>
								<div class="col-md-6">
									<input type="text" id="solimit" placeholder="Enter Price value" class="form-control form-control-sm price_float" value="<?php if(isset($salesorder5['price_limit']) && $salesorder5['trigger_workflow_on']==1){ echo IND_money_format($salesorder5['price_limit']); } ?>">
								</div>
							</div>
							</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="salesorder5" onChange="setStatusLimitSo('salesorder5','Sales order','Auto approve by limit SO');" <?php if(isset($salesorder5['trigger_workflow_on']) && $salesorder5['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$invoice=check_workflow('Invoice','Mail notification to invoice owner on created');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification to invoice owner on created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoice" onChange="setStatus('invoice','Invoice','Mail notification to invoice owner on created');" <?php if(isset($invoice['trigger_workflow_on']) && $invoice['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$invoice1=check_workflow('Invoice','Mail notification to SO owner on invoice created');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification to SO owner on invoice created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoice1" onChange="setStatus('invoice1','Invoice','Mail notification to SO owner on invoice created');" <?php if(isset($invoice1['trigger_workflow_on']) && $invoice1['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$invoiceRvpy=check_workflow('Invoice','Mail notification to invoice owner on recieve payment');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification to invoice owner on recieve payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoiceRvpy" onChange="setStatus('invoiceRvpy','Invoice','Mail notification to invoice owner on recieve payment');" <?php if(isset($invoiceRvpy['trigger_workflow_on']) && $invoiceRvpy['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
                        
                        <?php 
							$invoiceRvpyUser=check_workflow('Invoice','Mail notification  on recieve payment');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification  on recieve payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoiceRvpyUser" onChange="setStatus('invoiceRvpyUser','Invoice','Mail notification  on recieve payment');" <?php if(isset($invoiceRvpyUser['trigger_workflow_on']) && $invoiceRvpyUser['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$invoiceRv=check_workflow('Invoice','Mail notification to SO owner on recieve payment');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification to SO owner on recieve payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoiceRv" onChange="setStatus('invoiceRv','Invoice','Mail notification to SO owner on recieve payment');" <?php if(isset($invoiceRv['trigger_workflow_on']) && $invoiceRv['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$invoicepn=check_workflow('Invoice','Mail notification to SO owner for pending payment');
						?>
                        <tr class="Invoice">
                            <td class="text-left pl-3">Invoice</td>
                            <td class="text-left pl-3">Mail notification to SO owner for pending payment</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="invoicepn" onChange="setStatus('invoicepn','Invoice','Mail notification to SO owner for pending payment');" <?php if(isset($invoicepn['trigger_workflow_on']) && $invoicepn['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						
						<?php 
							$purchaseorder=check_workflow('Purchase order','Mail notification to purchase order owner on purchase order created');
						?>
                        <tr class="Purchase_order">
                            <td class="text-left pl-3">Purchase order</td>
                            <td class="text-left pl-3">Mail notification to purchase order owner on purchase order created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="purchaseorder" onChange="setStatus('purchaseorder','Purchase order','Mail notification to purchase order owner on purchase order created');" <?php if(isset($purchaseorder['trigger_workflow_on']) && $purchaseorder['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$purchaseorder1=check_workflow('Purchase order','Mail notification to sales owner on purchase order created');
						?>
                        <tr class="Purchase_order">
                            <td class="text-left pl-3">Purchase order</td>
                            <td class="text-left pl-3">Mail notification to sales owner on purchase order created</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="purchaseorder" onChange="setStatus('purchaseorder','Purchase order','Mail notification to sales owner on purchase order created');" <?php if(isset($purchaseorder1['trigger_workflow_on']) && $purchaseorder1['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						<?php 
							$purchaseorder3=check_workflow('Purchase order','Mail notification to PO owner on purchase order approve');
						?>
                        <tr class="Purchase_order">
                            <td class="text-left pl-3">Purchase order</td>
                            <td class="text-left pl-3">Mail notification to PO owner on purchase order approve</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="purchaseorder3" onChange="setStatus('purchaseorder3','Purchase order','Mail notification to PO owner on purchase order approve');" <?php if(isset($purchaseorder3['trigger_workflow_on']) && $purchaseorder3['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
						<?php 
							$purchaseorder4=check_workflow('Purchase order','Auto approve by limit PO');
						?>
                        <tr class="Purchase_order">
                            <td class="text-left pl-3">Purchase order</td>
                            <td class="text-left pl-3">
							<div class="row">
							<div class="col-md-6">Auto approve by limit PO</div>
								<div class="col-md-6">
									<input type="text" id="polimit" placeholder="Enter Price value" class="form-control form-control-sm price_float" value="<?php if(isset($purchaseorder4['price_limit']) && $purchaseorder4['trigger_workflow_on']==1){ echo IND_money_format($purchaseorder4['price_limit']); } ?>">
								</div>
							</div>
							</td>
                            <td>
                              <label class="switch">
								<input type="checkbox" class="checkall"  id="purchaseorder4" onChange="setStatusLimit('purchaseorder4','Purchase order','Auto approve by limit PO');" <?php if(isset($purchaseorder4['trigger_workflow_on']) && $purchaseorder4['trigger_workflow_on']==1){ echo "checked"; } ?> >
								<span class="slider round"></span>
							  </label>
                            </td>
                        </tr>
						
                    </tbody>
                </table>

                
              </div>
            </div>
      
    
          
	<?php }  ?>
  </div>

<?php $this->load->view('footer');?>
<?php $this->load->view('common_footer');?>
<script>

    function filter(){
    
    
		var className=$("#selectFilter").val();

		$("tr").hide();
		if(className==""){
			$("tr").show();
		}else{
			className=className.replace(" ", "_");
        $("."+className).show();
		}
		$(".thMdl").show();
        
    }

function getfilterdData(e,g){

var id = "#" + g;
$(id).val(e);
filter();

}

	
	
$("#ckbCheckAll").click(function () {
    
		$(".slider").click();
        $(".checkall").prop('checked', $(this).prop('checked'));
        
    });
  
function refreshPage(){
    window.location.reload();
} 

function setStatus(customerMdl,muduleName,workFlow){
	var status = 0;
    if ($("#"+customerMdl).is(':checked')){
		status = 1;
	}else{
		status = 0;
	}
	
	 if ($("#ckbCheckAll").is(':checked')){
		status = 1;
	 }
	
	
	$.ajax({
          url : "<?= base_url('Workflows/change_workflows')?>",
          type: "POST",
          data: { mdlName:muduleName,status:status,workFlowName:workFlow },
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



$(".form-control").keyup(function(){
	var price = $(this).val();
	price = price.replace(/,/g, "");
	var pricetwo=numberToIndPrice(price);
	$(this).val(pricetwo);
});
function setStatusLimit(customerMdl,muduleName,workFlow){
	var status = 0;
    if ($("#"+customerMdl).is(':checked')){
		status = 1;
	}else{
		status = 0;
	}
	var polimit = $("#polimit").val();
	if((polimit=="" || polimit==0 ) && $("#"+customerMdl).is(':checked')){
		$("#polimit").css('border-color','red');
		toastr.error('Please enter price value for automatically update');
		$("#"+customerMdl).prop('checked', false);
	}else{
	$.ajax({
          url : "<?= base_url('Workflows/change_workflows')?>",
          type: "POST",
          data: { mdlName:muduleName,status:status,workFlowName:workFlow,limit:polimit },
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
} 
function setStatusLimitSo(customerMdl,muduleName,workFlow){
	var status = 0;
    if ($("#"+customerMdl).is(':checked')){
		status = 1;
	}else{
		status = 0;
	}
	var solimit = $("#solimit").val();
	if((solimit=="" || solimit==0 ) && $("#"+customerMdl).is(':checked') ){
		$("#solimit").css('border-color','red');
		toastr.error('Please enter price value for automatically update');
		$("#"+customerMdl).prop('checked', false);
	}else{
	$.ajax({
          url : "<?= base_url('Workflows/change_workflows')?>",
          type: "POST",
          data: { mdlName:muduleName,status:status,workFlowName:workFlow,limit:solimit  },
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
} 
function change_status(){
$(".checkall").each(function(){
  if(this.checked){
    $(this).siblings('span').css('background','rgba(35,0,140,0.8)');  
  }
  else{
    $(this).siblings('span').css('background','lightgrey');   
  } 

  $(this).change(function(){
    if(this.checked){
    $(this).siblings('span').css('background','rgba(35,0,140,0.8)');  
  }
  else{
    $(this).siblings('span').css('background','lightgrey');   
  } 
  })
})
}
change_status();

</script>
