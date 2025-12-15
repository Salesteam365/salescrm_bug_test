<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pi_Pdf_Model extends CI_Model
{
  var $table = 'quote';

  public function view($piid,$company='',$comEml='')
  {
	  
	  
	  
	/*
		$data['otherdata'] = $this->Performainvoice->get_data_detail($data['record']['page_name'],$data['record']['page_id']);
		$data['branch'] = $this->Performainvoice->getBranchData($data['record']['billedby_branchid']); $data['clientDtl'] = $this->Performainvoice->getVendorOrgData($data['record']['billedto_orgname'],$data['record']['page_name']);
		*/
		//$this->load->view('setting/proforma_pdf',$data);
		
	
   
      if($company==''){
		$session_company = $this->session->userdata('company_name');
	  }else{
		 $session_company=$company; 
	  }
	  if($comEml==''){
		$session_comp_email = $this->session->userdata('company_email');
	  }else{
		 $session_comp_email=$comEml; 
	  }
    $this->db->from('performa_invoice');
    $this->db->where('session_comp_email',$session_comp_email);
    $this->db->where('session_company',$session_company);
    $this->db->where('id',$piid);
	$query = $this->db->get();
    
    foreach($query->result() as $row)
    {
     $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Quotation</title>
		 <link rel="shortcut icon" type="image/png" href="'.base_url().'assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;">
				<h5><b>QUOTATION</b></h5>
				<hr style="width: 230px; border: 1px solid #50b1bd; margin-top: 10px;">
			  </td>
            </tr>

			<tr>
				<td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
				  <span><b>'.$this->session->userdata('company_name').'</b></span><br>
				  <span>'.$this->session->userdata('company_address').'</span><br>
				  <span>'.$this->session->userdata('city').',&nbsp;'.$this->session->userdata('state').'&nbsp;'.$this->session->userdata('zipcode').'</span><br>
				  <span><a style="text-decoration:none" href="'.$this->session->userdata('company_website').'">'.$this->session->userdata('company_website').'</a></span><br>
				  <span>'.$this->session->userdata('company_mobile').'</span><br>
				  <span><b>GSTIN:</b>&nbsp;'.$this->session->userdata('company_gstin').'</span><br>
				  <span><b>CIN:</b>&nbsp;'.$this->session->userdata('cin').'</span><br>
				</td>
				<td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;">
				
        			<table>
                     <tr> 
					 <td colspan="2" style="text-align:right">';
					$image = $this->session->userdata('company_logo');
					if(!empty($image))
					{
					$output .=  '<img style="width: 100px;" src="./uploads/company_logo/'.$image.'">';
					}
					else
					{
					$output .=  '<span class="h5 text-primary">'.$this->session->userdata('company_name').'</span>';
					}
					$output .= '
				</td>
				
                   </tr>
                    <tr><td colspan="2">
                    <span style="font-weight: bold;">QUOTATION ID : </span>&nbsp;<span>'.$row->invoice_no.'</span><br>
        				<b>DATE : </b><span >'.date('d-M-Y').'</span><br>
						<b>VALID UNTIL : </b><span>'.date('d-M-Y',strtotime($row->due_date)).'</span>
                        </td>
                        </tr>
                    </table>
				</td>
            </tr>
			<tr>
				<td colspan="6" style="padding:20px 0 40px; font-size: 12px;"> 
				  <b>ADDRESS :- </b><br>
				  <span class="h6 text-primary">'.$row->org_name.'</span><br>
				  <b>CONTACT&nbsp;PERSON</b> :&nbsp;<span>'.$row->contact_name.'</span><br>
				  <span style="white-space: pre-line">'.$row->billing_address.'</span>,
				  <span>'.$row->billing_state.'</span><br>
				  <span>'.$row->billing_city.'</span>&nbsp;,<span>'.$row->billing_zipcode.'</span>&nbsp;,<span>'.$row->billing_country.'</span><br>
				
				</td>

				<td colspan="6" style="padding:20px 0 40px; text-align:left; font-size: 12px;">
					<b>Place Of supply</b> : 
					<span>'.$row->billing_state.'</span><br>
					<b>Sales Person</b> : 
					<span>'.$row->owner.'</span><br>
					<b>Sales Person Mob</b> : 
					<span>'.$this->session->userdata('mobile').'</span><br>
					
				</td>
			</tr>
			
        </table>  

        <table class="table-responsive-sm table-striped text-center table-bordered" style="width:100% !important;">
            <thead style="background: #50b1bd; color: #fff; font-size: 12px;">
                <tr>
                    <th>S.No.</th>
                    <th>Product/Services</th>
                    <th>HSN/SAC</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 12px;">';
				$product_name = explode("<br>",$row->product_name);
				$quantity = explode("<br>",$row->quantity);
				$unit_price = explode("<br>",$row->unit_price);
				$total = explode("<br>",$row->total);
				$sku = explode("<br>",$row->sku);
				$hsnsac = explode("<br>",$row->hsn_sac);
				if(!empty($row->gst)){
				  $gst = explode("<br>",$row->gst);
				}
				$arrlength = count($product_name);
				$arrlength = count($product_name);
				for($x = 0; $x < $arrlength; $x++){
					$num = $x + 1;
					$output .='<tr>
						<td style="padding:5px; 0px;">'.$num.'</td>
						<td style="padding:5px; 0px;">'.$product_name[$x].'</td>
						<td style="padding:5px; 0px;">'.$hsnsac[$x].'</td>
						<td style="padding:5px; 0px;">'.$sku[$x].'</td>
						<td style="padding:5px; 0px;">'.$quantity[$x].'</td>
						<td style="padding:5px; 0px;">'.IND_money_format($unit_price[$x]).'</td>';
						if(!empty($gst)){
						  $output .='<td style="padding:5px; 0px;">GST@'.$gst[$x].'%</td>';
						}else{
						  $output .='<td style="padding:5px; 0px;">GST@18%</td>';
						}
						  $output .='<td style="padding:5px; 0px;">'.IND_money_format($total[$x]).'/-</td>
					</tr>';		
			    }
                $output .='
            </tbody>
        </table>

        <table width="100%; margin-top:20px; border:1px; margin-bottom:40px;" >
            <tr>
				<td colspan="6" style="font-size: 12px;">
				<br>
					<span class="h6">Terms And Conditions :-</span><br>
					<span style="white-space: pre-line;font-size: 10px;"></span><br>
					<span>'.nl2br($row->terms_condition).'</span><br>';
					if(!empty($row->customer_company_name) && !empty($row->customer_address))
					{
						$output .='<hr>
						<span class="h6">CUSTOMER DETAILS (IF REQUIRED)</span><br>
						<span style="white-space: pre-line;font-size: 10px;"></span><br>';
						  if(!empty($row->customer_company_name))
						  {
						  $output .='<span>Name:&nbsp;'.ucfirst($row->customer_company_name).'</span><br>';
						  }
						  if(!empty($row->customer_address))
						  {
						  $output .='<span>Address :&nbsp;'.ucwords($row->customer_address).'</span><br>';
						  }
						  if(!empty($row->customer_name))
						  {
						  $output .='<span>Contact Person :&nbsp;'.ucfirst($row->customer_name).'</span><br>';
						  }
						  if(!empty($row->customer_email))
						  {
						  $output .='<span>E-mail :&nbsp;'.$row->customer_email.'</span><br>';
						  }
						  if(!empty($row->customer_mobile))
						  {
						  $output .='<span>Contact&nbsp;No :&nbsp;'.$row->customer_mobile.'</span>';
						  }
						  $output .='
						<hr>';
					 }
					$output .='
				</td>
				<td colspan="2">
				</td>
				<td colspan="4" style="padding:3px;">
					<table class="float-right" style="border: 1px solid #ffffff; font-size:12px;">
						<tr style="line-height:35px;">
							<td style="padding:0px;">
							<b>Initial Total:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.IND_money_format($row->initial_total).'/-</span></td>
						</tr>
						<tr style="line-height:35px;">
							<td style="padding:0px;"><b>Discount:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.$row->discount.'/-</span></td>
						</tr>
						<tr style="line-height:35px;">
							<td style="padding:0px;"><b>After Discount:</b></td>
							<td style="padding:0px;"><span class="float-right" id="">'.IND_money_format($row->after_discount).'/-</span></td>
						</tr>';
							
							$type = $row->type;
							if($type == "Interstate")
							{
							  if($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 == '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							  elseif($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst12).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst28).'/-</span></td></tr>';
							  }
							}
							else if($type == "Instate")
							{
							  if($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 == '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst9).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							  elseif($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 != '0')
							  {
							$output .='
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst6).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->cgst14).'/-</span></td></tr>
							<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->sgst14).'/-</span></td></tr>';
							  }
							}
							else
							{
							$output .='<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">'.IND_money_format($row->igst18).'/-</span></td></tr>';
							}
							
							$output .='
						<tr style="line-height:35px;">
							<td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td>
							<td style="padding:0px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><span class="float-right"><b>INR '.IND_money_format($row->sub_totalq).'/-</b></span></td>
						</tr>
					</table>
				</td>
        </tr>
			
        </table>
        <br>
       
        <table width="100%" style="position:fixed; bottom: 60; font-size:11px;">

          <tr style="height:40px;">
            <td style="width:65%">
			<b>Accepted By</b><br>
			<b>Accepted Date</b> : '.date('d F Y').'
			
			</td>
			
			<td colspan="3">
			</td>
			<td style="width:35%">
    			<table>
    			<tr>
    			<td>
    			<b>Quotation Created By</b> : </td><td>'.ucfirst($row->owner).'</td>
    			</tr>
    			<tr>
    			<td>
    			<b>Quotation Created Date : </td><td>'.date("d F Y", strtotime($row->datetime)).'</td></tr>
    			</table>
			
			</td>
			
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated Quotation Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - '.$this->session->userdata('company_email').'</br>
             | Ph. - +91-'.$this->session->userdata('company_mobile').'</br>
              | GSTIN: '.$this->session->userdata('company_gstin').'</br>
               | CIN: '.$this->session->userdata('cin').'</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
      
      
      
	}
      
    return $output;
  }
  

//please write code above this
}
?>
