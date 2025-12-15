<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home_model extends CI_Model
{
	public function view()
	{
		$output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Quotation</title>
        <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
        <tr>
          <td colspan="12" style="text-align:center;"><h3><b>Quotation Order</b></h3><hr style="width: 230px; border: 1px solid #50b1bd;
          margin-top: 10px;"></td>
        </tr>
          <tr>
            <td colspan="6" style="padding:0px;">
              <img src="assets/img/allegient-logo.png" style="width: 100px; margin-bottom:25px;">
            </td>
            <td colspan="6" style="padding:2px; font-size: 14px;">
              <div class="float-right">
                <b>QUOTATION ID: </b><span>QUT/2020/1028</span><br>
                <b>DATE: </b><span>26-06-2020</span><br>
                <b>VALID UNTIL:</b><span>04-07-2020</span><br>
              </div>
            </td>
            </tr>

        <tr>
            <td colspan="6" style="padding:15px 0 10px; font-size: 14px;">
              <span><b>Allegient Unified Technology Pvt. Ltd</b></span><br>
              <span>DSM – 412,4th Floor, DLF Tower, Shivaji Marg Motinagar</span><br>
              <span>New Delhi, Delhi 110015</span><br>
              <span><a style="text-decoration:none" href="http://www.allegientservices.com/">www.allegientservices.com</a></span><br>
              <span>+91-9873550688</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>
            </td>
            <td colspan="6" style="padding:10px 0 50px; text-align:left; font-size: 14px;">
              <span><b>Ekta World Pvt Ltd</b></span><br>
              <span>401, Hallmark Business Plaza, Off Western Express Highway</span><br>
              <span> Near Bandra Kurla complex, Kalanagar</span><br>
              <span>Bandra - East, Mumbai-400051, Maharashtara, India</span><br>
            </td>
        </tr>

          <tr>
            <td colspan="6" style="padding:5px 0; font-size: 14px;">
              <b>Place of supply</b><br>
              <span>Maharashtara</span>
            </td>

            <td colspan="6" style="padding:2px; text-align:right; font-size: 14px;">

            </td>
          </tr>
        </table>  

        <table class="table table-responsive-sm table-striped text-center">
            <thead style="background: #50b1bd; color: #fff; font-size: 14px;">
                <tr>
                    <th>Contact person</th>
                    <th>Sales Person</th>
                    <th>Sales Person Contact</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 14px;">
                <tr>
                    <td>Manish Rawat</td>
                    <td>Aman Singh Bisht</td>
                    <td>9999999999</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-responsive-sm table-striped text-center">
            <thead style="background: #50b1bd; color: #fff; font-size: 14px;">
                <tr>
                    <th>S. No.</th>
                    <th>Product Services</th>
                    <th>HSN/SAC</th>
                    <th>Sku</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 14px;">
                <tr>
                    <td>1</td>
                    <td>MS Win 10 Pro Licence</td>
                    <td>97875485497545</td>
                    <td>97875485497545</td>
                    <td>1</td>
                    <td>10,650</td>
                    <td>GST 18%</td>
                    <td>10,650/-</td>
                </tr>
            </tbody>
        </table>

        <table width="100%">
            <tr>
          <td colspan="6" style="font-size: 12px;">
        <span class="h6">Terms And Conditions</span><br>
        <span style="white-space: pre-line;font-size: 10px;"></span><br>
        <span>1. Payment -100% advance by cheque/DD in favour of “Allegient Unified Technology Pvt. Ltd.</span><br>
        <span>2. Taxes -GST@18% will be charged will be extra.</span><br>
        <span>3. Delivery - within 2 working days after confirmation of Payment & PO.</span><br>
        <span>4. Validity - till 30-06-2020</span><br>
        <span>5. Support / Warranty - All Support / Warranty will be Provide by OEM.</span><br>
        <span>6. TDS - No TDS deduction under 194J/195</span><br>
        <span>7. Cancellation - No Cancellation after Order Process<./span><br>
        <span>8. The above prices are for supply of desktop only. Other services needed will be charged extra.</span>

        
          </td>
          <td colspan="2">
          </td>
          <td colspan="4" style="padding:2px;">
          <table class="float-right">
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Initial Total:</b></td><td style="padding:0px;"><span class="float-right" id="">10,650/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">0.00/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>After Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">10,650/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right" id="">3,240/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td><td style="padding:0px;" class="bg-info text-white"><span class="float-right">INR 24248/-</span></td></tr>
          </table>
          </td>
        </tr>
        </table>

        <table width="100%" style="position:fixed; bottom: 80px;">
          <tr>
            <td>
              <b>Accepted By</b>
            </td>
            <td>
              <b class="float-right">Accepted Date</b>
            </td>
          </tr>
        </table>        

        <footer>
        <div style="position: fixed;bottom: 2;">
          <center>
          <b><span style="font-size: 10px;">E-mail - mp@allegientservices.com</br>
             | Ph. - +91-9873550688</br>
              | GSTIN: 07AAMCA0717H1ZU</br>
               | CIN: U72900DL2013PTC258753</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
      return $output;
	}

  public function view_so()
  {
    $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Sales Order</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
        <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
      </head>
      <body>
        <table width="100%">
          <tr>
            <td colspan="12" style="text-align:center;"><h3><b>Sales Order</b></h3><hr style="width: 180px; border: 1px solid #50b1bd;
          margin-top: 10px;"></td>
          </tr>

          <tr>
            <td colspan="6" style="padding:0px;">
              <img src="assets/img/allegient-logo.png" style="width: 100px; margin-bottom:25px;">
            </td>
            <td colspan="6" style="padding:2px; font-size: 14px;">
              <div class="float-right">
                <b>SALESORDER ID: </b><span>SO/2020/673</span><br>
                <b>DATE: </b><span>27-06-2020</span><br>
                <b>VALID UNTIL:</b><span>27-06-2020</span>
              </div>
            </td>
            </tr>

        <tr>
            <td colspan="12" style="padding:0px; font-size: 14px;">
              <span><b>Allegient Unified Technology Pvt. Ltd</b></span><br>
              <span>DSM – 412,4th Floor, DLF Tower, Shivaji Marg</span><br>
              <span>Motinagar, New Delhi, Delhi 110015</span><br>
              <span><a style="text-decoration:none" href="http://www.allegientservices.com/">www.allegientservices.com</a></span><br>
              <span>+91-9873550688</span><br>
              <span>GSTIN: 07AAMCA0717H1ZU</span><br>
              <span>CIN: U72900DL2013PTC258753</span>
            </td>
        </tr>

        <tr>
            <td colspan="6" style="padding:30px 0; font-size: 14px;">
              <span><b>Bill To:-</b></span><br>
              <span><b>DRS IT Consultancy Pvt Ltd</b></span><br>
              <span>Contact Person: Rakesh Pandey</span><br>
              <span>Contact Person No.: 9999999999</span><br>
              <span>B 38/579, 1st Floor, Gali No.2 Ganesh Nagar 2<br>Shakarpur, Delhi, 110092, India</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>
            </td>

            <td colspan="6" style="padding:0; text-align:left; font-size: 14px;">
              <span><b>Ship To:-</b></span><br>
              <span><b>Allegient Unified Technology Pvt. Ltd</b></span><br>
              <span>DSM – 412,4th Floor, DLF Tower, Shivaji Marg, Motinagar</span><br>
              <span>New Delhi, Delhi 110015</span><br>
              <span><a style="text-decoration:none" href="http://www.allegientservices.com/">www.allegientservices.com</a></span><br>
              <span>+91-9873550688</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>
            </td>
        </tr>

          <tr>
            <td colspan="12" style="padding:15px 0 5px; font-size: 14px;">
              <b>Place of supply</b><br>
              <span>Delhi</span>
            </td>
          </tr>
        </table>  

        <table class="table table-responsive-sm table-striped text-center">
            <thead style="background: #50b1bd; color: #fff; font-size: 14px;">
                <tr>
                    <th>Sales Person</th>
                    <th>Sales Person Contact</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 14px;">
                <tr>
                    <td>Mahendra</td>
                    <td>9873550688</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-responsive-sm table-striped text-center">
            <thead style="background: #50b1bd; color: #fff; font-size: 14px;">
                <tr>
                    <th>S. No.</th>
                    <th>Product Services</th>
                    <th>HSN/SAC</th>
                    <th>Sku</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 14px;">
                <tr>
                    <td>1</td>
                    <td>WinSvrSTDCore 2019 SNGL OLP 2Lic NL Core Licence</td>
                    <td>9973</td>
                    <td>84754884</td>
                    <td>10</td>
                    <td>7,297</td>
                    <td>GST 18%</td>
                    <td>72,970/-</td>
                </tr>
            </tbody>
        </table>

        <table width="100%">
        <tr>
        <td colspan="6" style="font-size: 12px;">
        <span class="h6">Terms And Conditions</span><br>
        <span style="white-space: pre-line;font-size: 10px;"></span><br>
        <span>1. Payment -100% advance by cheque/DD in favour of “Allegient Unified Technology Pvt. Ltd.</span><br>
        <span>2. Taxes -GST@18% will be charged will be extra.</span><br>
        <span>3. Delivery - within 2 working days after confirmation of Payment & PO.</span><br>
        <span>4. Validity - till 30-06-2020</span><br>
        <span>5. Support / Warranty - All Support / Warranty will be Provide by OEM.</span><br>
        <span>6. TDS - No TDS deduction under 194J/195</span><br>
        <span>7. Cancellation - No Cancellation after Order Process<./span><br>
        <hr>
        <span class="h6">CUSTOMER DETAILS (IF REQUIRED)</span><br>
        <span style="white-space: pre-line;font-size: 10px;"></span><br>
        <span>Name: Indian Oil Corporation Ltd</span><br>
        <span>Address: Pipeline Terminal, Suchi Pind Jalandhar,Punjab -144009</span><br>
        <span>Contact Person: Sujit Bharti</span><br>
        <span>E-mail: sbharti@indianoil.in</span><br>
        <span>LAM: ABC144754898</span>
        <hr>
          </td>
          <td colspan="2">
          </td>
          <td colspan="4" style="padding:2px;">
          <table class="float-right">
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Initial Total:</b></td><td style="padding:0px;"><span class="float-right" id="">72,970/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">0.00/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>After Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">72,970/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>CGST@9%:</b></td><td style="padding:0px;"><span class="float-right" id="">6,567/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>SGST@9%:</b></td><td style="padding:0px;"><span class="float-right" id="">6,567/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td><td style="padding:0px;" class="bg-info text-white"><span class="float-right">INR 86,104.60/-</span></td></tr>
          </table>
          </td>
        </tr>

        </table>

        <table width="100%" style="position:fixed; bottom: 80px;">
          <tr>
            <td>
              <b>Accepted By</b>
            </td>
            <td>
              <b class="float-right">Accepted Date</b>
            </td>
          </tr>
        </table>        

        <footer>
        <div style="position: fixed;bottom: 2;">
          <center>
          <b><span style="font-size: 10px;">E-mail - mp@allegientservices.com</br>
             | Ph. - +91-9873550688</br>
              | GSTIN: 07AAMCA0717H1ZU</br>
               | CIN: U72900DL2013PTC258753</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
      return $output;
  }
    public function view_po()
    {
        $output = '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Purchase Order</title>
        <link rel="shortcut icon" type="image/png" href="<?= base_url();?>assets/images/favicon.png">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
          <tr>
            <td colspan="12" style="text-align:center;"><h3><b>Purchase Order</b></h3><hr style="width: 230px; border: 1px solid #50b1bd;
          margin-top: 10px;"></td>
          </tr>
          <tr>
            <td colspan="6" style="padding:0px;">
              <img src="assets/img/allegient-logo.png" style="width: 100px;"/>
            </td>
            <td colspan="6" style="padding:2px; text-align:right; font-size: 14px;">
              <div class="float-right">
                <b>PURCHASE ORDER ID: </b><span>PO/2020/664</span><br>
                <b>DATE: </b><span>26-06-2020</span>
              </div>
            </td>
            </tr>

          <tr>
            <td colspan="6" style="padding:0px; margin-top:15px; font-size: 14px;">
              <span><b>Allegient Unified Technology Pvt. Ltd</b></span><br>
              <span>DSM – 412,4th Floor, DLF Tower, Shivaji Marg</span><br>
              <span>Motinagar, New Delhi, Delhi 110015</span><br>
              <span><a style="text-decoration:none" href="http://www.allegientservices.com/">www.allegientservices.com</a></span><br>
              <span>+91-9873550688</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>
            </td>
            <td colspan="6" style="padding:0px 0 20px; text-align:left; font-size: 14px;">
              <b>Supplier Name:-</b><br>
              <span><b>Ingram Micro India Ltd</b></span><br>
              <span>Supplier Name: Aman Ahuja</span><br>
              <span>EMPIRE PLAZA BUILDING 5TH FLOOR A LBS MARG<br>
              VIKHROLI (WEST), MUMBAI-400083, MAHARASHTRA</span><br>
              <span><b>GSTIN: 7457588547858AU7</b></span>
            </td>
            </tr>

          <tr>
            <td colspan="6" style="padding:30px 0 40px; font-size: 14px;"> 
              <b>Bill To:-</b><br>
              <span><b>DRS IT Consultancy Pvt Ltd</b></span><br>
              <span>Contact Person: Rakesh Pandey</span><br>
              <span>Contact Person No.: 9999999999</span><br>
              <span>B 38/579, 1st Floor, Gali No.2 Ganesh Nagar 2<br>Shakarpur, Delhi, 110092, India</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>           
            </td>

            <td colspan="6" style="padding:30px 0; text-align:left; font-size: 14px;">
              <b>Ship To:-</b><br>
              <span><b>Allegient Unified Technology Pvt. Ltd</b></span><br>
              <span>DSM – 412,4th Floor, DLF Tower, Shivaji Marg</span><br>
              <span>Motinagar, New Delhi, Delhi 110015</span><br>
              <span><a style="text-decoration:none" href="http://www.allegientservices.com/">www.allegientservices.com</a></span><br>
              <span>+91-9873550688</span><br>
              <span><b>GSTIN: 07AAMCA0717H1ZU</b></span><br>
              <span><b>CIN: U72900DL2013PTC258753</b></span>
            </td>
          </tr>
        </table>  

        <table class="table table-responsive-sm table-striped text-center">
            <thead style="background: #50b1bd; color: #fff; font-size: 14px;">
                <tr>
                    <th>S. No.</th>
                    <th>Product Services</th>
                    <th>HSN/SAC</th>
                    <th>Sku</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Tax</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody style="background: #f5f5f5; color: #000000; font-weight: 500; font-size: 14px;">
                <tr>
                    <td>1</td>
                    <td>Acrobat Pro DC for teams</td>
                    <td>9973</td>
                    <td>65297932BA01A12</td>
                    <td>1</td>
                    <td>13,384</td>
                    <td>GST 18%</td>
                    <td>13,384.00/-</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Acrobat Pro DC for teams</td>
                    <td>9973</td>
                    <td>65297932BA01A12</td>
                    <td>1</td>
                    <td>13,384</td>
                    <td>GST 18%</td>
                    <td>13,384.00/-</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Acrobat Pro DC for teams</td>
                    <td>9973</td>
                    <td>65297932BA01A12</td>
                    <td>1</td>
                    <td>13,384</td>
                    <td>GST 18%</td>
                    <td>13,384.00/-</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Acrobat Pro DC for teams</td>
                    <td>9973</td>
                    <td>65297932BA01A12</td>
                    <td>1</td>
                    <td>13,384</td>
                    <td>GST 18%</td>
                    <td>13,384.00/-</td>
                </tr>
            </tbody>
        </table>

        <table width="100%">
            <tr>
            <td colspan="6" style="font-size: 12px;">
            <span class="h6">Terms And Conditions</span><br>
            <span style="white-space: pre-line;font-size: 10px;"></span><br>
            <span>1. Payment -100% advance by cheque/DD in favour of “Allegient Unified Technology Pvt. Ltd.</span><br>
            <span>2. Taxes -GST@18% will be charged will be extra.</span><br>
            <hr>
            <span class="h6">CUSTOMER DETAILS (IF REQUIRED)</span><br>
            <span style="white-space: pre-line;font-size: 10px;"></span><br>
            <span>Name: HDFC ERGO HEALTH INSURANCE</span><br>
            <span>Address :ILabs Centre, 2nd & 3rd Floor, Plot No</span><br>
            <span>404 - 405, Udyog Vihar, Phase – III, Gurgaon -</span><br>
            <span>122016, HARYANA VIP - 347AC0334F321FAECBAA</span><br>
            <span>Contact Person :Amar Sarin</span><br>
            <span>E-mail :amar.sarin@hdfcergohealth.com</span><br>
            <span>Contact No :8448283041</span><br>
            <span>LAM: ABC144754898</span>
            <hr>
          </td>
          <td colspan="2">
          </td>
          <td colspan="4" style="padding:2px;">
          <table class="float-right">
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Initial Total:</b></td><td style="padding:0px;"><span class="float-right" id="">13,384/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">0.00/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>After Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">13,384/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right" id="">2,409.12/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td><td style="padding:0px;" class="bg-info text-white"><span class="float-right">INR 15793.12/-</span></td></tr>
          </table>
          </td>
        </tr>

        </table>

        <table width="100%" style="position:fixed; bottom: 80px;">
          <tr>
            <td>
              <b>Accepted By</b>
            </td>
            <td>
              <b class="float-right">Accepted Date</b>
            </td>
          </tr>
        </table>

        <footer>
        <div style="position: fixed;bottom: 2;">
          <center>
          <b><span style="font-size: 10px;">E-mail - mp@allegientservices.com</br>
             | Ph. - +91-9873550688</br>
              | GSTIN: 07AAMCA0717H1ZU</br>
               | CIN: U72900DL2013PTC258753</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
      return $output;
    }
}
?>