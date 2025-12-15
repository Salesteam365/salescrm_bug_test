<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['default_controller'] = 'login';
$route['404_override'] = 'Error_ci';
$route['translate_uri_dashes'] = FALSE;
$route['profile'] = 'home/profile';
$route['upgrade-plan'] = 'upgrade_plan';
$route['extend-subscription'] = 'upgrade_plan/extend_subscription';
$route['viewUser'] = 'home/viewUser';
$route['branches'] = 'home/view_branches';
$route['product-manager'] = 'Product_manager';
$route['inventory-form'] = 'Product_manager/inventory_form';
$route['inventory-form/:num'] = 'Product_manager/inventory_form';
$route['proforma_invoice/view-pi'] = 'proforma_invoice/view_pi';
$route['service-form'] = 'Product_manager/service_form';
$route['task'] = 'setting/task';
$route['meeting'] = 'setting/meeting';
$route['call'] = 'setting/call';
$route['facebook-instagram-ads-lead-integration'] = 'integration/facebook_integration';
$route['indiamart-integration'] = 'integration/indiamart_integration';

$route['superadmin/user_details'] = 'superadmin/home/user_details';
$route['superadmin/crm_order_details'] = 'superadmin/home/crm_order_details';
$route['superadmin/invoice_details'] = 'superadmin/home/invoice_details';
$route['superadmin/invoice_order_details'] = 'superadmin/home/invoice_order_details';
$route['superadmin/view-userDetails/:any'] = 'superadmin/home/view_userDetails/$1';
$route['superadmin/view_invoiceDetails/:any'] = 'superadmin/home/view_invoiceDetails/$1';
$route['change-password'] = 'change_password';
$route['gst'] = 'setting/add_gst';
$route['email-marketing'] = 'Email_Marketing';
$route['sent-email'] = 'Email_Marketing/sent_email';
$route['view-email/:any'] = 'Email_Marketing/view_email/$1';
$route['locked'] = 'login/locked';
$route['find-duplicate'] = 'Find_duplicate';

$route['invoices/view-invoice'] = 'invoices/view_invoice';
$route['invoices/generate-pdf'] = 'invoices/generate_pdf';
$route['invoices/new-invoice'] = 'invoices/new_invoice';
$route['invoices/edit-invoice/:any'] = 'invoices/new_invoice';
$route['set-prefix'] = 'setting/set_prefix';
$route['sales-profit-target'] = 'sales_profit_target';
$route['sales-and-profit-target-detail/:any/:any'] = 'sales_profit_target/view_sales_target_detail';
$route['sales-and-profit-target-detail/:any/:any/:any'] = 'sales_profit_target/view_sales_target_detail';
$route['sales-and-profit-target-detail/:any'] = 'sales_profit_target/view_sales_target_detail';
// Add New Routs For add form 
$route['add-lead/:num'] = 'leads/add_leads';
$route['add-lead'] = 'leads/add_leads';
$route['view-lead/:num'] = 'leads/view_leads';

$route['add-opportunity/:num'] = 'Opportunities/add_opportunity';
$route['add-opportunity'] = 'Opportunities/add_opportunity';

$route['add-quote/:num'] = 'Quotation/add_quote';
$route['add-quote'] = 'Quotation/add_quote';

$route['add-salesorder/:num'] = 'salesorders/add_salesorder';
$route['add-salesorder'] = 'salesorders/add_salesorder';

$route['add-purchase-order/:num'] = 'purchaseorders/add_purchase';
$route['add-purchase-order'] = 'purchaseorders/add_purchase';

$route['set-restriction/:any'] = 'Permission/set_permission';
$route['set-restriction'] = 'Permission/set_permission';
$route['update-invoice/:num'] = 'invoices/new_invoice';
$route['add-invoice'] = 'invoices/new_invoice';
$route['csv-mail'] = 'Email_Marketing/send_mail_using_csv';
$route['view-customer/:num'] = 'organizations/view_customer';
$route['view-vendor/:num'] = 'vendors/view_vendor';
$route['state-list'] = 'Setting/state_list';


// new routes added by Ankit Singh
$route['subpurchaseorders']='purchaseorders/subpurchaseorders';
$route['add-subpurchaseorder/:num']='purchaseorders/add_subpurchase/$1';
$route['newdashboard'] = 'Accounting/newdashboard';
$route['accounting-report'] = 'Accounting/reports';
$route['performa-invoice'] = 'Accounting/performainvoice';
$route['expanse-manage'] = 'Accounting/expansemanage';
// $route['payment-reciept'] = 'Accounting/paymentreciept';
$route['delivery-Chalan'] = 'Accounting/deliverychallan';
// $route['credit-note'] = 'Accounting/creditnote';
// $route['debit-note'] = 'Accounting/debitnote';
// $route['add-creditnote'] = 'Accounting/add_creditnote';
// $route['add-creditnote/:any'] = 'Accounting/add_creditnotee';
// $route['add-debitnote'] = 'Accounting/add_debitnote';

// routes added by Indrajeet Chaudhary 
$route['credit-note'] = 'Accounting/creditnote';
$route['add-creditnote'] = 'Accounting/add_creditnote';
$route['add-creditnote/:any'] = 'Accounting/loadcreditnote_view';
$route['view-creditnote'] = 'Accounting/view_load_creditnote';
 
$route['debit-note'] = 'Accounting/debitnote';
$route['add-debitnote'] = 'Accounting/add_debitnote';
$route['add-debitnote/:any'] = 'Accounting/loaddebitnote_view';
$route['view-debitnote'] = 'Accounting/view_load_debitnote';
 
$route['Accounting/generate-pdf'] = 'Accounting/generate_pdf';
$route['Accounting/generate-pdf-credit'] = 'Accounting/generate_pdf_credit';
$route['add-expanse'] = 'Accounting/add_expanse';
$route['add-deliverychallan'] = 'Accounting/add_deliverychallan';
// $route['add-paymentreciept'] = 'Accounting/add_paymentreciept';
$route['payment-reciept'] = 'Accounting/paymentreciept';
$route['add-paymentreciept'] = 'Accounting/add_paymentreciept';
$route['add-paymentreciept/:any'] = 'Accounting/loadpaymentreceipt_view';
$route['view-paymentreceipt'] = 'Accounting/view_load_paymentreceipt';
$route['Accounting/generate-pdf-paymentreceipt'] = 'Accounting/generate_pdf_paymentreceipt';
$route['chat']='Chat/index';

$route['customreports']='Customreports/index';
$route['aifilters']='Aifilters/index';
$route['tbl_list']='Create_tbl/index';
$route['create_tbl']='Create_tbl/create_tbl';

// for testing login
$route['dashborad'] = 'Home/index';