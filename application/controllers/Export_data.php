<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Export_data extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('Export_model'));
    //   $this->load->model(array('Purchaseorders_model'));
    //  $this->load->model('Purchaseorders_model', 'Purchaseorders');
  }
  
  public function index(){ 
  
  echo "<a 	href='Export_data/export_customer_csv'> Click to download customer csv</a><br><br>";
  echo "<a 	href='Export_data/export_vendor_csv'> Click to download vendor csv</a><br><br>";
  echo "<a 	href='Export_data/export_customer_contact_csv'> Click to download Customer Contact</a><br><br>";
  echo "<a 	href='Export_data/export_opportunity'> Click to download Opportunity Data</a><br><br>";
  echo "<a 	href='Export_data/export_quotation'> Click to download quotation Data</a><br><br>";
  echo "<a 	href='Export_data/export_so'> Click to download sales order Data</a><br><br>";
  echo "<a 	href='Export_data/export_po'> Click to download purchase order Data</a><br><br>";
  echo "<a 	href='Export_data/export_invoice'> Click to download invoice Data</a><br><br>";
  
  }
  
  
    public function export_customer_csv(){ 
		/* file name */
		$filename = 'customer_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
	   /* get data */
		$usersData = $this->Export_model->getUserDetails();
		$file = fopen('php://output', 'w');
		$header = array("ADDED BY EMAIL",'CUSTOMER NAME', 'PRIMARY CONTACT','EMAIL','WEBSITE','OFFICE PHONE','MOBILE', 'EMPLOYEES','INDUSTRY', 'ANNUAL_REVENUE','OWNERSHIP','ASSIGNED TO','SIC CODE','SLA NAME','REGION','GSTIN','PAN NO','BILLING_COUNTRY','SHIPPING COUNTRY','BILLING CITY','SHIPPING CITY','BILLING STATE','SHIPPING STATE','BILLING ZIPCODE','SHIPPING ZIPCODE','BILLING ADDRESS','SHIPPING ADDRESS','DESCRIPTION', 'ADDED DATE');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
	public function export_vendor_csv(){ 
		/* file name */
		$filename = 'users_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
	   /* get data */
		$usersData = $this->Export_model->getUserDetails_vendor();
		$file = fopen('php://output', 'w');
		$header = array("ADDED BY EMAIL",'VENDOR NAME', 'PRIMARY CONTACT','EMAIL','WEBSITE','OFFICE PHONE','MOBILE', 'EMPLOYEES','INDUSTRY', 'ANNUAL_REVENUE','OWNERSHIP','ASSIGNED TO','SIC CODE','SLA NAME','REGION','GSTIN','PAN NO','BILLING_COUNTRY','SHIPPING COUNTRY','BILLING CITY','SHIPPING CITY','BILLING STATE','SHIPPING STATE','BILLING ZIPCODE','SHIPPING ZIPCODE','BILLING ADDRESS','SHIPPING ADDRESS','DESCRIPTION', 'ADDED DATE');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
    public function export_customer_contact_csv(){ 
		$filename = 'customer_contact_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->getUserDetails_contact();
		$file = fopen('php://output', 'w');
		$header = array("ADDED BY EMAIL","CONTACT OWNER",'CUSTOMER NAME', 'CUSTOMER ID', 'CONTACT NAME','EMAIL','WEBSITE','OFFICE PHONE','MOBILE','ASSIGNED TO','SLA NAME','BILLING_COUNTRY','SHIPPING COUNTRY','BILLING CITY','SHIPPING CITY','BILLING STATE','SHIPPING STATE','BILLING ZIPCODE','SHIPPING ZIPCODE','BILLING ADDRESS','SHIPPING ADDRESS','DESCRIPTION', 'ADDED DATE');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
    public function export_opportunity(){ 
		$filename = 'opportunity_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_opportunity_data();
		$file 	= fopen('php://output', 'w');
		$header = array("ADDED BY EMAIL","OPPORTUNITY OWNER",'CUSTOMER NAME', 'OPPORTUNITY NAME', 'CONTACT NAME','EXPCLOSE DATE','PIPELINE','STAGE','LEAD_SOURCE','NEXT STEP','TYPE','PROBABILITY','INDUSTRY','EMPLOYEES','WEIGHTED REVENUE','EMAIL','MOBILE','LOST REASON','DESCRIPTION','PRODUCT_NAME','QUANTITY','UNIT_PRICE', 'TOTAL','INITIAL_TOTAL','DISCOUNT','SUB TOTAL','PRO DESCRIPTION','DATETIME');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
  
    public function export_quotation(){ 
		$filename = 'quotation_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_quotation_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','OPPORTUNITY NAME','SUBJECT','CUSTOMER NAME','CONTACT NAME','QUOTE STAGE','VALID UNTIL','CARRIER','EMAIL','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE','BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE','SHIPPING ADDRESS','PRODUCT NAME','HSN SAC','SKU','QUANTITY','UNIT PRICE','TOTAL','INITIAL TOTAL','DISCOUNT','PRO DESCRIPTION','SUB TOTAL','GST','IGST','CGST','SGST','PRODUCT DISCOUNT','TOTAL IGST','TOTAL CGST','TOTAL SGST','TYPE','SUB TOTAL WITH GST','DATETIME');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}

	// <----------------------------------- Debit Note Start ----------------------------------->
	public function export_debitnote(){ 
		$filename = 'debitnote_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_debitnote_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','Owner','Debit Date' ,'Debit No.' ,'Debit Amount','Invoice No.','Invoice Amount','Invoice Date');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	// <------------------------------ Debit Note End -------------------------------------------->

	// <--------------------------------- Credit Note Start---------------------------------->
	public function export_creditnote(){ 
		$filename = 'creditnote_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_creditnote_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','Owner','Credit Date' ,'Credit No.' ,'Credit Amount','Invoice No.','Invoice Amount','Invoice Date');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	// <------------------------------- Credit Note End ------------------------>

	// <------------------------- Delivery Challan Start---------------------------->
	public function export_deliverychallan(){ 
		$filename = 'delivery_challan_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_deliverychallan_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','Owner','Delivery Challan Date' ,'Delivery Challan No.' ,'Delivery Challan Amount','Invoice No.','Invoice Amount','Invoice Date');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 

	//<------------------- Expenditure Management -------------------------->
	public function export_expenditure(){ 
		$filename = 'expenditure_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_expenditure_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','Expenditure Date' ,'Expenditure No.' ,'Po Date','Po No.','Owner',' Amount');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 
	// <-------------------------------- Expenditure Management End --------------------->

	
	//<------------------- Payment Reciept Start -------------------------->
	public function export_paymentreciept(){ 
		$filename = 'paymentreciept_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_paymentreciept_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','Payment Receipt Date' ,'Payment Reciept No.' ,'Billed TO','Currency','Owner',' Amount');
		
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	} 
	// <-------------------------------- Payment Reciept End --------------------->



// public function export_without_po() {
//         $filename = 'so_withoutPo_data_' . date('Ymd') . '.csv';
//         header("Content-Description: File Transfer");
//         header("Content-Disposition: attachment; filename=$filename");
//         header("Content-Type: application/csv");

//         $list_po = $this->Purchaseorders_model->get_datatables();
//         //  print_r($list_po);die;
//         $soId = [];

//         foreach ($list_po as $post) {
//             $soId[] = $post->saleorder_id;
//         }
       
//         $without_po_data = $this->Export_model->data_without_po($soId);
//         $all_data = []; // To collect all rows

//         if (!empty($without_po_data)) {
//         // Assuming data_without_po returns an array of rows
//             foreach ($without_po_data as $row) {
//                 $all_data[] = $row;
//             }
//         }
        
//         $file = fopen('php://output', 'w');
//         $header = array(
//             'ADDED BY EMAIL','ADDED BY NAME','OPPORTUNITY NAME','SUBJECT','CUSTOMER NAME',
//             'CONTACT NAME','PENDING','DUE UNTIL','CARRIER','PAYMENT TERMS','PAY TERMS STATUS',
//             'APPROVED BY','STATUS','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE',
//             'BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE',
//             'SHIPPING ADDRESS','PRODUCT NAME','HSN SAC','SKU','QUANTITY','UNIT PRICE',
//             'ESTIMATE PURCHASE PRICE','TOTAL','INITIAL TOTAL','INITIAL ESTIMATE PURCHASE PRICE',
//             'DISCOUNT','PRO DESCRIPTION','SUB TOTAL','TOTAL ESTIMATE PURCHASE PRICE','GST','IGST',
//             'CGST','SGST','PRODUCT DISCOUNT','TOTAL IGST','TOTAL CGST','TOTAL SGST','TYPE',
//             'SUB TOTAL WITH GST','TOTAL ORC','IS RENEWAL','RENEWAL DATE','ADVANCED PAYMENT',
//             'PENDING PAYMENT','DATETIME'
//         );
//         fputcsv($file, $header);
//         foreach ($all_data as $line) {
//             fputcsv($file, $line);
//         }

//         fclose($file);
//         exit;
//     }





	
	public function export_so(){ 
		$filename = 'sales_order_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_so_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','OPPORTUNITY NAME','SUBJECT','CUSTOMER NAME','CONTACT NAME','PENDING','DUE UNTIL','CARRIER','PAYMENT TERMS','PAY TERMS STATUS','APPROVED BY','STATUS','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE','BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE','SHIPPING ADDRESS','PRODUCT NAME','HSN SAC','SKU','QUANTITY','UNIT PRICE','ESTIMATE PURCHASE PRICE','TOTAL','INITIAL TOTAL','INITIAL ESTIMATE PURCHASE PRICE','DISCOUNT','PRO DESCRIPTION','SUB TOTAL','TOTAL ESTIMATE PURCHASE PRICE','GST','IGST','CGST','SGST','PRODUCT DISCOUNT','TOTAL IGST','TOTAL CGST','TOTAL SGST','TYPE','SUB TOTAL WITH GST','TOTAL ORC','IS RENEWAL','RENEWAL DATE','ADVANCED PAYMENT','PENDING PAYMENT','DATETIME');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
	public function export_po(){ 
	    ini_set('memory_limit', '64M');

		$filename = 'purchase_order_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_po_data();
// 		print_r($usersData);die;
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','SUBJECT','CONTACT NAME','BILLING GSTIN','SHIPPING GSTIN','BILLING COUNTRY','BILLING STATE','BILLING CITY','BILLING ZIPCODE','BILLING ADDRESS','SHIPPING COUNTRY','SHIPPING STATE','SHIPPING CITY','SHIPPING ZIPCODE','SHIPPING ADDRESS','	SUPPLIER NAME','SUPPLIER CONTACT','SUPPLIER COMP NAME','SUPPLIER EMAIL','SUPPLIER GSTIN','SUPPLIER COUNTRY','SUPPLIER STATE','SUPPLIER CITY','SUPPLIER ZIPCODE','SUPPLIER ADDRESS','TYPE','PRODUCT NAME','HSN SAC','SKU,QUANTITY','UNIT PRICE','TOTAL','GST','IGST','CGST','SGST','SUB TOTAL WITH GST','TOTAL IGST','TOTAL CGST','TOTAL SGST','PRO DISCOUNT','EXTRA CHARGE LABEL','EXTRA CHARGE VALUE','DELETE STATUS','TOTAL ORC PO','ESTIMATE PURCHASE PRICE PO','INITIAL ESTIMATE PURCHASE PRICE PO','TOTAL ESTIMATE PURCHASE PRICE PO','PROFIT BY USER PO','PRO DESCRIPTION','INITIAL TOTAL','DISCOUNT','AFTER DISCOUNT PO','SUB TOTAL','TERMS CONDITION','CUSTOMER COMPANY NAME','CUSTOMER NAME','CUSTOMER EMAIL','CUSTOMER MOBILE','LAN_NO','PROMO ID','CUSTOMER ADDRESS','APPROVE STATUS','APPROVED BY','SO OWNER','SO OWNER_EMAIL','ORG NAME','END RENEWAL','IS RENEWAL','RENEWAL DATE','DATETIME');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
	public function export_invoice(){ 
		$filename = 'invoice_data_'.date('Ymd').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
		$usersData = $this->Export_model->export_invoice_data();
		$file 	= fopen('php://output', 'w');
		$header = array('ADDED BY EMAIL','ADDED BY NAME','ADDED BY SALESORDER','SALEORDER_ID','INVOICE NO','INVOICE DATE','DUE DATE','BUYER DATE','INVOICE TERMS','EXTRA FIELD LABEL','EXTRA FIELD VALUE','CUSTOMER NAME','CUSTOMER ORDER NO','INVOICE DECLARATION','DECLARATION STATUS','NOTES','TYPE','PRODUCT DESCRIPTION','ENQUIRY EMAIL','ENQUIRY MOBILE','PRODUCT NAME','HSN SAC','GST','QUANTITY','UNIT PRICE','TOTAL','SGST','CGST','IGST','SUB TOTAL WITH GST','TOTAL IGST','TOTAL CGST','TOTAL SGST','PRO DISCOUNT','EXTRA CHARGE LABEL','EXTRA CHARGE VALUE','TERMS CONDITION','TOTAL DISCOUNT','DISCOUNT TYPE','DISCOUNT','INITIAL TOTAL','SUB TOTAL','ADVANCED PAYMENT','PENDING PAYMENT','DATETIME');
		fputcsv($file, $header);
		foreach ($usersData as $key => $line){ 
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}
	
	
  
  
  
  
// Please write code above this  
}
?>