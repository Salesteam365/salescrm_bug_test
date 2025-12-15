<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Purchaseorders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Login_model');
    }

    var $table = 'purchaseorder';
    var $sort_by = [null, 'supplier_comp_name', 'customer_company_name', 'supplier_name', 'subject', 'purchaseorder_id', 'owner', 'approved_by', 'datetime', null];
    var $search_by = ['supplier_comp_name', 'customer_company_name', 'supplier_name', 'subject', 'purchaseorder_id', 'owner', 'approved_by', 'datetime','subscr_type'];
    var $order = ['id' => 'desc'];
    private function _get_datatables_query($subscr=null)
    {
        
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        if ($this->session->userdata('type') === 'admin') {
            // print_r('test');die;
            $this->db->from($this->table);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
           
            if ($this->input->post('searchDate')) {
                $search_date = $this->input->post('searchDate');
                if ($this->input->post('fromDate') && $this->input->post('toDate')) {
                    $this->db->where('currentdate >=', $this->input->post('fromDate'));
                    $this->db->where('currentdate <=', $this->input->post('toDate'));
                } elseif ($search_date == "This Week") {
                    $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
                } else {
                    $this->db->where('currentdate >=', $search_date);
                }
            }
            if ($this->input->post('searchUser')) {
                $searchUser = $this->input->post('searchUser');
                $this->db->where('sess_eml', $searchUser);
            }
            
            $this->db->where('delete_status', 1);
            if($subscr != null){
                $this->db->where('subscr_type !=', '');
            }
        } elseif ($this->session->userdata('type') === 'standard') {
            $this->db->from($this->table);
            if ($this->session->userdata('retrieve_po') != '1') {
                $this->db->where('sess_eml', $sess_eml);
            }
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
            if ($this->input->post('searchDate')) {
                $search_date = $this->input->post('searchDate');
                if ($search_date == "This Week") {
                    $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
                } else {
                    $this->db->where('currentdate >=', $search_date);
                }
            }
            $this->db->where('delete_status', 1);
            if($subscr != null){
                $this->db->where('subscr_type !=', '');
            }
        }
        
        $i = 0;
        foreach (
            $this->search_by
            as $item // loop column
        ) {
            if ($_POST['search']['value']) {
                // if datatable send POST for search
                if ($i === 0) {
                    // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->search_by) - 1 == $i) {
                    //last loop
                    $this->db->group_end();
                } //close bracket
            }
            $i++;
        }
        
        if (isset($_POST['order'])) {
            // here order processing
            $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    ////////////////////////////////////////////// fetch data for po graph (monthwise) starts ////////////////////////////////////////////////////

     public function getpo_graph(){
        $sess_eml = $this->session->userdata('email');
		$session_comp_email = $this->session->userdata('company_email');
		$session_company = $this->session->userdata('company_name');
        if($this->session->userdata('type')=='admin'){
            $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
            ->where('session_comp_email', $session_comp_email)
            ->where('session_company', $session_company)
            ->where('delete_status', 1)
            ->group_by('year, month')
            ->order_by('year, month')
            ->get('purchaseorder');
  
    if (!$query) {
        $error = $this->db->error();
        echo "Database Error: " . $error['message'];
    } else {
        return $query->result();
    }
     } 
     else if($this->session->userdata('type')=='standard'){
        $query = $this->db->select('YEAR(currentdate) AS year, MONTH(currentdate) AS month, SUM(sub_total) AS subtotal')
        ->where('session_comp_email', $session_comp_email)
        ->where('session_company', $session_company)
        ->where('sess_eml', $sess_eml)
        ->where('delete_status', 1)
        ->group_by('year, month')
        ->order_by('year, month')
        ->get('purchaseorder');

   if (!$query) {
    $error = $this->db->error();
    echo "Database Error: " . $error['message'];
  } else {
    return $query->result();
   }
 }
    
     }

////////////////////////////////////////////// fetch data for po graph (monthwise) ends ////////////////////////////////////////////////////


    public function get_datatables($subscr = null)
    {   if($subscr != null){
           $this->_get_datatables_query($subscr);
        }else{
           
           $this->_get_datatables_query();
        }
        
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->from($this->table);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        return $this->db->count_all_results();
    }
    public function get_so_id($saleorder_id, $sess_eml, $session_company, $session_comp_email)
    {
        $this->db->like('saleorder_id', $saleorder_id, 'both');
        if ($this->session->userdata('type') == 'standard') {
            $sess_eml = $this->session->userdata('email');
            $this->db->where('sess_eml', $sess_eml);
        }
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->order_by('currentdate', 'DESC');
        $this->db->limit(5);
        return $this->db->get('salesorder')->result();
    }
    public function getSOValue($saleorder_id)
    {
        $response = [];
        if ($saleorder_id['saleorder_id']) {
            $this->db->select('*');
            $this->db->where('saleorder_id', $saleorder_id['saleorder_id']);
            if ($this->session->userdata('type') == 'standard') {
                $sess_eml = $this->session->userdata('email');
                $this->db->where('sess_eml', $sess_eml);
            }
            $o = $this->db->get('salesorder');
            $response = $o->result_array();
        }
        return $response;
    }

    public function getProductInfo($saleorderId, $ProName)
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');

        $this->db->select('product_wise_profit.id,product_wise_profit.pro_name');
        $this->db->from('product_wise_profit');
        $this->db->join('purchaseorder', 'product_wise_profit.po_id=purchaseorder.purchaseorder_id');
        $this->db->where('product_wise_profit.so_id', $saleorderId);
        $this->db->where('purchaseorder.saleorder_id', $saleorderId);
        $this->db->where('product_wise_profit.pro_name', $ProName);
        $this->db->where('purchaseorder.session_company', $session_company);
        $this->db->where('purchaseorder.session_comp_email', $session_comp_email);
        $this->db->where('po_id<>', "");
        $this->db->where('product_wise_profit.delete_status', 1);
        $this->db->where('purchaseorder.delete_status', 1);
        $o = $this->db->get();
        $response = $o->result_array();
        return $response;
    }

    public function get_vendor_name($name, $sess_eml, $session_company, $session_comp_email)
    {
        $this->db->like('org_name', $name, 'both');
        //$this->db->where('sess_eml',$sess_eml);
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('delete_status', '1');
        $this->db->group_start();
        $this->db->where('customer_type', 'Vendor');
        $this->db->or_where('customer_type', 'Both');
        $this->db->group_end();
        $this->db->order_by('org_name', 'ASC');
        $this->db->limit(8);
        return $this->db->get('organization')->result();
    }
    public function get_vendor_details($supplier_name)
    {
        $sess_eml = $this->session->userdata('email');
        $session_company = $this->session->userdata('company_name');
        $session_comp_email = $this->session->userdata('company_email');
        $this->db->select('*');
        $this->db->where('org_name', $supplier_name);
        $this->db->from('organization');
        // $this->db->where('sess_eml',$sess_eml);
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('delete_status', '1');
        $this->db->group_start();
        $this->db->where('customer_type', 'Vendor');
        $this->db->or_where('customer_type', 'Both');
        $this->db->group_end();
        $o = $this->db->get();
        $response = $o->result_array();
        return $response;
    }

    public function get_vendor_contact($supplier_name)
    {
        $this->db->select('name as v_name');
        $this->db->where('org_name', $supplier_name);
        $this->db->where('contact_type', 'Vendor');
        $this->db->from('contact');
        $o = $this->db->get();
        $response = $o->result_array();
        return $response;
    }

    public function check_product($soid)
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('product_name,pro_dummy_id');
        $this->db->from($this->table);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $this->db->where('saleorder_id', $soid);
        //$this->db->where('id',$id);
        $this->db->where('delete_status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_data_for_update($id)
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->from($this->table);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_data_for_update_subscr_po($id){
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->from('subscription_po');
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
   public function checkexists($tbl,$cond){
    $session_comp_email = $this->session->userdata('company_email');
    $session_company = $this->session->userdata('company_name');
    $this->db->from($tbl);
    $this->db->where('session_comp_email', $session_comp_email);
    $this->db->where('session_company', $session_company);
    $this->db->where($cond);
    $query = $this->db->get();
    return $query->row_array();
   }
    public function statusPOapprove($where, $data, $stts)
    {
        $this->db->update($this->table, $data, $where);
        return $stts;
    }

    public function get_by_id2($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result_array() : false;
    }
    public function fetch_val($saleorder_id)
    {
        $this->db->select_sum('po_sub_total');
        $this->db->where('saleorder_id', $saleorder_id['saleorder_id']);
        $this->db->from('reports_table');
        $query = $this->db->get();
        //return $query->row()->po_sub_total;
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
    public function fetch_val_wotax($saleorder_id)
    {
        $this->db->select_sum('po_total_wotax');
        $this->db->where('saleorder_id', $saleorder_id['saleorder_id']);
        $this->db->from('reports_table');
        $query = $this->db->get();
        //return $query->row()->po_total_wotax;
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function create_subpo($data)
    {
        $this->db->insert('subscription_po', $data);
        return $this->db->insert_id();
    }
    public function purchaseorder_id($purchaseorder_id, $id)
    {
        $data = ['purchaseorder_id' => $purchaseorder_id];
        $this->db->where('id', $id);
        if ($this->db->update('purchaseorder', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function update($where, $data)
    {
        if ($this->session->userdata('type') == 'admin') {
            if ($this->db->update($this->table, $data, $where)) {
                return true;
            }
        } else {
            //$this->db->where('sess_eml',$this->session->userdata('email'));
            $this->db->update($this->table, $data, $where);
        }
        return $this->db->affected_rows();
    }
    public function updatesubpo($where, $data)
    {
        if ($this->session->userdata('type') == 'admin') {
            if ($this->db->update('subscription_po', $data, $where)) {
                return true;
            }
        } else {
            //$this->db->where('sess_eml',$this->session->userdata('email'));
            $this->db->update('subscription_po', $data, $where);
        }
        return $this->db->affected_rows();
    }
    public function delete($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('id', $id);
        $this->db->update($this->table);
    }
    public function delete_bulk($id)
    {
        $this->db->set('delete_status', 2);
        $this->db->where('id', $id);
        $this->db->update($this->table);
    }

    /*******Old pdf template**********/
    public function view_old($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get($this->table);

        foreach ($data->result() as $row) {
            $output =
                '<!DOCTYPE html>
      <html>
      <head>
        <title>Team365 | Purchase Order</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
      </head>
      <body>
        <table width="100%">
            <tr>
              <td colspan="12" style="text-align:center;"><h5><b>Purchase Order</b></h5><hr style="width: 230px; border: 1px solid #50b1bd;
            margin-top: 10px;"></td>
            </tr>
          <tr>
            <td colspan="6" style="padding:0px; margin-top:15px; font-size: 12px;">
              <span><b>' .
                $this->session->userdata('company_name') .
                '</b></span><br>
			  <span>' .
                $this->session->userdata('city') .
                ',&nbsp;' .
                $this->session->userdata('state') .
                '&nbsp;' .
                $this->session->userdata('zipcode') .
                '</span><br>
              <span><a style="text-decoration:none" href="' .
                $this->session->userdata('company_website') .
                '">' .
                $this->session->userdata('company_website') .
                '</a></span><br>
              <span>' .
                $this->session->userdata('company_mobile') .
                '</span><br>
              <span><b>GSTIN:</b>&nbsp;' .
                $this->session->userdata('company_gstin') .
                '</span><br>
              <span><b>CIN:</b>&nbsp;' .
                $this->session->userdata('cin') .
                '</span><br>
            </td>
            <td colspan="6" style="padding:0px 0 0px; text-align:left; font-size: 12px;">
            <table>
             <tr> 
			 <td colspan="2" style="text-align:right">';
            $image = $this->session->userdata('company_logo');
            if (!empty($image)) {
                $output .= '<img style="width: 100px;" src="./uploads/company_logo/' . $image . '">';
            } else {
                $output .= '<span class="h5 text-primary">' . $this->session->userdata('company_name') . '</span>';
            }
            $output .=
                '</td>
            </tr>
            <tr><td colspan="2">
            <span style="font-weight: bold;">PURCHASE ORDER ID : </span>&nbsp;<span>' .
                $row->purchaseorder_id .
                '</span><br>
					<b>DATE : </b><span >' .
                date('d-M-Y') .
                '</span><br>
               
                </td>
                </tr>
                </table>
            </td>
            </tr>

          <tr>
            <td colspan="6" style="padding:30px 0 40px; font-size: 12px;"> 
            
              <b>SUPPLIER NAME:-</b><br>
              <span><b>' .
                $row->supplier_comp_name .
                '</b></span><br>
              <span>Supplier Name: ' .
                $row->supplier_name .
                '</span><br>
              <span>' .
                $row->supplier_address .
                '<br>
              ' .
                $row->supplier_state .
                '</span><br>
			  <span>' .
                $row->supplier_city .
                '</span>&nbsp;,<span>' .
                $row->supplier_zipcode .
                '</span>&nbsp;,<span>' .
                $row->supplier_country .
                '</span><br>
              <span><b>GSTIN: ' .
                $row->supplier_gstin .
                '</b></span>
            </td>

            <td colspan="6" style="padding:30px 0; text-align:left; font-size: 12px;">
              <b>SHIP TO:-</b><br>
			  
              <span><b>' .
                $this->session->userdata('company_name') .
                '</b></span><br>
			   <b>Contact&nbsp;Name</b>:&nbsp;<span>' .
                $row->owner .
                '</span><br>
              <span>' .
                $row->shipping_address .
                '</span><br>
              <span>' .
                $row->shipping_state .
                '</span><br>
			  <span>' .
                $row->shipping_city .
                '</span>&nbsp;,
			  <span>' .
                $row->shipping_zipcode .
                '</span>&nbsp;,
			  <span>' .
                $row->shipping_country .
                '</span><br>
              <span>+91-' .
                $this->session->userdata('mobile') .
                '</span><br>
              <span><b>GSTIN: ' .
                $row->shipping_gstin .
                '</b></span><br>
              <span><b>CIN: ' .
                $this->session->userdata('cin') .
                '</b></span>
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
            $product_name = explode("<br>", $row->product_name);
            $quantity = explode("<br>", $row->quantity);
            $unit_price = explode("<br>", $row->unit_price);
            $total = explode("<br>", $row->total);
            $sku = explode("<br>", $row->sku);
            $hsnsac = explode("<br>", $row->hsn_sac);
            if (!empty($row->gst)) {
                $gst = explode("<br>", $row->gst);
            }
            $arrlength = count($product_name);
            $arrlength = count($product_name);
            for ($x = 0; $x < $arrlength; $x++) {
                $num = $x + 1;
                $output .=
                    '<tr>
						<td style="padding:5px; 0px;">' .
                    $num .
                    '</td>
						<td style="padding:5px; 0px;">' .
                    $product_name[$x] .
                    '</td>
						<td style="padding:5px; 0px;">' .
                    $hsnsac[$x] .
                    '</td>
						<td style="padding:5px; 0px;">' .
                    $sku[$x] .
                    '</td>
						<td style="padding:5px; 0px;">' .
                    $quantity[$x] .
                    '</td>
						<td style="padding:5px; 0px;">' .
                    IND_money_format($unit_price[$x]) .
                    '</td>';
                if (!empty($gst)) {
                    $output .= '<td style="padding:5px; 0px;">GST@' . $gst[$x] . '%</td>';
                } else {
                    $output .= '<td style="padding:5px; 0px;">GST@18%</td>';
                }
                $output .=
                    '<td style="padding:5px; 0px;">' .
                    IND_money_format($total[$x]) .
                    '/-</td>
					</tr>';
            }
            $output .=
                '
            </tbody>
        </table>

        <table width="100%; margin-top:20px; margin-bottom:20px;" >
            <tr>
            <td colspan="6" style="font-size: 12px;">
            <span class="h6">Terms And Conditions :-</span><br>
            <span style="white-space: pre-line;font-size: 10px;"></span><br>
            <span>' .
                nl2br($row->terms_condition) .
                '</span><br>';
                

                if (!empty($row->customer_company_name)) {
                $output .= '<hr>
				<span class="h6">CUSTOMER DETAILS (IF REQUIRED)</span><br>
				<span style="white-space: pre-line;font-size: 10px;"></span><br>';

                if (!empty($row->customer_company_name)) {
                    $output .= '<span>Name:&nbsp;' . ucfirst($row->customer_company_name) . '</span><br>';
                }
                if (!empty($row->customer_address)) {
                    $output .= '<span>Address :&nbsp;' . ucwords($row->customer_address) . '</span><br>';
                }
                if (!empty($row->customer_name)) {
                    $output .= '<span>Contact Person :&nbsp;' . ucfirst($row->customer_name) . '</span><br>';
                }
                if (!empty($row->customer_email)) {
                    $output .= '<span>E-mail :&nbsp;' . $row->customer_email . '</span><br>';
                }
                if (!empty($row->customer_mobile)) {
                    $output .= '<span>Contact&nbsp;No :&nbsp;' . $row->customer_mobile . '</span>';
                }

                if (!empty($row->microsoft_lan_no)) {
                    $output .= '<br><span>' . $row->microsoft_lan_no . '</span>';
                }

                $output .= '
				<hr>';
            }
            
            
            $output .=
                '
          </td>
          <td colspan="2">
          </td>
          <td colspan="4" style="padding:3px;">
          <table class="float-right" style="margin-top:20px; border: 1px solid #ffffff; font-size:12px;">
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Initial Total:</b></td><td style="padding:0px;"><span class="float-right" id="">' .
                IND_money_format($row->initial_total) .
                '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">' .
                $row->discount .
                '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>After Discount:</b></td><td style="padding:0px;"><span class="float-right" id="">' .
                IND_money_format($row->after_discount_po) .
                '/-</span></td></tr>';

            $type = $row->type;
            if ($type == "Interstate") {
                if ($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst12) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst18) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst28) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst12) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst18) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 == '0' && $row->igst28 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst28) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst12) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst18) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst18) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst28) .
                        '/-</span></td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst12) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->igst28) .
                        '/-</span></td></tr>';
                }
            } elseif ($type == "Instate") {
                if ($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst14) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst14) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst6) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst9) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 == '0' && $row->cgst14 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst14) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst14) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 == '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst9) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst9) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst14) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst14) .
                        '/-</span></td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 != '0') {
                    $output .=
                        '
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst6) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->cgst14) .
                        '/-</span></td></tr>
            <tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' .
                        IND_money_format($row->sgst14) .
                        '/-</span></td></tr>';
                }
            } else {
                $output .= '<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">' . IND_money_format($row->igst18) . '/-</span></td></tr>';
            }

            $output .=
                '<!--<tr style="line-height:35px;"><td style="padding:0px;"><b>IGST@18%:</b></td><td style="padding:0px;"><span class="float-right">2,409.12/-</span></td></tr>-->
			
            <tr style="line-height:35px;"><td style="padding:0px;" class="bg-info text-white"><b>Sub Total:</b></td><td style="padding:0px; border-right: 1px solid #17a2b8; " class="bg-info text-white"><span class="float-right"><b>INR ' .
                IND_money_format($row->sub_total) .
                '/-</b></span></td></tr>
          </table>
          </td>
        </tr>

        </table>
        <br>
        <table width="100%" style="position:fixed; font-size:11px; bottom: 80px;">
          <tr>
            <td style="width:70%">
			<b>Accepted By</b><br>
			<b>Accepted Date</b> : ' .
                date('d F Y') .
                '
			
			</td>
			<td colspan="3">
			</td>
			<td style="width:30%">
    			<table>
    			<tr>
    			<td>
    			<b>PO Created By</b> : </td><td>' .
                ucfirst($row->owner) .
                '</td>
    			</tr>
    			<tr>
    			<td>
    			<b>PO Created Date</b> : </td><td>' .
                date("d F Y", strtotime($row->datetime)) .
                '</td></tr>
    			</table>
			</td>
          </tr>
		 
		  
        </table>

        <footer>
        <div style="position: fixed;bottom: 8;">
          <center>
		  <span style="font-size:12px"><b>"This is System Generated PO Sign and Stamp not Required"</b></span><br>
          <b><span style="font-size: 10px;">E-mail - ' .
                $this->session->userdata('company_email') .
                '</br>
             | Ph. - +91-' .
                $this->session->userdata('company_mobile') .
                '</br>
              | GSTIN: ' .
                $this->session->userdata('company_gstin') .
                '</br>
               | CIN: ' .
                $this->session->userdata('cin') .
                '</span></b>
          </center>
        </div>
        </footer>
      </body>
      </html>';
        }
        return $output;
    }

    /*****new design for pdf******/
    public function view($id)
    {
        $this->db->where('id', $id);
        $data = $this->db->get($this->table);

        foreach ($data->result() as $row) {
            $admin_details = $this->Login_model->get_company_details($row->session_company, $row->session_comp_email);

            $output =
                '<!DOCTYPE html>
      <html>
      <head>
       
                <title>Team365 | Purchaseorder</title>
                <link rel="shortcut icon" type="image/png" href="' .
                base_url() .
                'assets/images/favicon.png">
                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
              <style>
               @page{
                      margin-top: 30px; /* create space for header */
                    }
                    footer .pagenum:before {
                        content: counter(page, decimal);
                    }
                </style>
              </head>
        
              <body style="font-family: Quicksand, sans-serif;">
              
              
              
              <main style="margin-bottom:30px;"> 
              <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                       <td>
                         <h3 style="color: #6539c0; margin-top:0px;margin-bottom: -5px;">Purchaseorder</h3>
                         <p style="margin-bottom: 0;font-size: 12px;"><text style="color: #9c9999; display:inline-block; width:25%;">Purchaseorder No#</text> <text style="display:inline-block;">' .
                $row->purchaseorder_id .
                '</text> <br>
                        <text style="color: #9c9999; display:inline-block; width:25%;"> Purchaseorder Date </text> <text style="display:inline-block;">' .
                date("d F Y", strtotime($row->datetime)) .
                '</text></p>
                       </td>
                       <td colspan="2" style="text-align:right">';
            $image = $admin_details["company_logo"];
            if (!empty($image)) {
                $output .= '<img style="width: 70px;" src="'.base_url().'/uploads/company_logo/' . $image . '">';
            } else {
                $output .= '<span class="h5 text-primary">' . $admin_details["company_name"] . '</span>';
            }

            $output .=
                ' </td>
                </tr>
                </tbody>
                </table>
                 <table width="100%" style="max-width:800px; background: #6539c01a; border-radius:10px; border-collapse: collapse;">
                
                   <tr>
                    <td style="width: 49.5%; padding: 10px; vertical-align: top;">
                        <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Purchase Order For</h4>
            
                  <p style="margin: 0; font-size: 14px;">' . $row->supplier_comp_name;

            $output .=
                '</p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">' . $row->supplier_address;

            if ($row->supplier_city != "") {
                $output .= ', ' . $row->supplier_city;
            }
            if ($row->supplier_zipcode != "") {
                $output .= ' - ' . $row->supplier_zipcode;
            }
            if ($row->supplier_state != "") {
                $output .= ', ' . $row->supplier_state;
            }

            if ($row->supplier_country != "") {
                $output .= ', ' . $row->supplier_country;
            }
            $output .= '</p>';
            if (isset($row->supplier_gstin)) {
                $output .= '<p style="font-size: 12px;margin: 2px 0px;"><b>GST No.:</b> ' . $row->supplier_gstin . '</p>';
            }
            if (!empty($row->supplier_name)) {
                $output .=
                    '<p style="margin-bottom: 0;font-size: 12px;margin-top: 5px;"><text style="font-size:12px;">
                            <b>Supplier Name :</b> ' .
                    $row->supplier_name .
                    '</text></p>';
            }
            if (isset($row->supplier_email)) {
                $output .=
                    '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;"><b>Email:</b> ' .
                    $row->supplier_email .
                    ' <br>
                          <b>Phone:</b> +91-' .
                    $row->supplier_contact .
                    '</p>';
            }
            $output .=
                '</td>
                       <td style="width: 1%; background:#fff;"></td>
                       <td style="width: 49.5%; padding: 10px; vertical-align: top; ">
                          <h4 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0;">Purchase Order From</h4>
                          <p style="margin: 0;font-size: 12px;">' . $admin_details["company_name"];

            $output .= '</p>
                            
                          <p style="margin-bottom: 0;font-size: 12px;margin-top: 10px;">';

            if (!empty($row->shipping_address)) {
                $output .= $row->shipping_address;
            }
            if (!empty($row->shipping_city)) {
                $output .= ', ' . $row->shipping_city;
            }
            if (!empty($row->shipping_zipcode)) {
                $output .= ' - ' . $row->shipping_zipcode;
            }
            if (!empty($row->shipping_state)) {
                $output .= ', ' . $row->shipping_state;
            }
            if (!empty($row->shipping_country)) {
                $output .= ', ' . $row->shipping_country;
            }
            $output .= '</p>';

            if ($admin_details["company_gstin"]) {
                $output .= '<p style="font-size: 12px;margin: 4px 0px;"><b>GST No.:</b>' . $admin_details["company_gstin"] . '</p>';
            }

            if (!empty($row->owner)) {
                $output .=
                    '<p style="margin-bottom: 0;font-size: 12px;margin-top: 5px;">
                            <b>Contact Name :</b> ' .
                    $row->owner .
                    '</p>';
            }

            if ($admin_details["company_email"]) {
                $output .=
                    '<p style="margin-bottom: 0;font-size: 12px;margin-top: 0px;"><b>Email:</b>' .
                    $admin_details["company_email"] .
                    '<br>
                          <b>Phone:</b> +91-' .
                    $admin_details["company_mobile"] .
                    '</p>';
            }

            $output .=
                '</td>
                    </tr>
                </table>
                <table width="100%" style="max-width:800px; background:#fff;">
                 <tbody>
                    <tr>
                      <td align="left" style="font-size:12px;width: 49.5%; ">
                <p><b>Country of Supply :</b>' .
                $row->shipping_country .
                '</p>
              </td>
              <td></td>
              <td align="left" style="font-size:13px;width: 49.5%; ">
                <p><b>Place of Supply :</b>' .
                $row->shipping_state .
                '</p>
              </td>
            </tr>
         </tbody>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:800px; width: 100%; border-radius: 7px; background: #efebf9; ">
        <thead style="color: #fff;" align="left">
            <tr>
                <th width="30%" style="font-size: 12px;">
                <div style="background: #6539c0;border-top-left-radius: 7px; padding: 11px;">Product/Services</div></th>
               <th style="font-size: 12px; background: #6539c0;">HSN/SAC</th>
               <th style="font-size: 12px; background: #6539c0;">SKU</th>
               <th style="font-size: 12px; background: #6539c0;">Qty</th>
               <th style="font-size: 12px; background: #6539c0;">Rate</th>
               <th style="font-size: 12px; background: #6539c0;">Tax</th>
               <th style="font-size: 12px;"><div style="background: #6539c0;border-top-right-radius: 7px; padding: 11px;">Amount</div></th>
               
             </tr>
           </thead>
           <tbody>';

            $product_name = explode("<br>", $row->product_name);
            $quantity = explode("<br>", $row->quantity);
            $unit_price = explode("<br>", $row->estimate_purchase_price_po);
            $total = explode("<br>", $row->initial_estimate_purchase_price_po);
            $sku = explode("<br>", $row->sku);
            $hsnsac = explode("<br>", $row->hsn_sac);
            if (!empty($row->gst)) {
                $gst = explode("<br>", $row->gst);
            }
            $proDesc = explode("<br>", $row->pro_description);
            $arrlength = count($product_name);

            $rw = 0;
            for ($x = 0; $x < $arrlength; $x++) {
                $num = $x + 1;
                $output .=
                    '<tr >
        						
        			<td style="font-size: 12px; padding:10px; border-top: 1px solid #dee2e6;">' .
                    $product_name[$x] .
                    '</td>
        			<td style="font-size: 12px;border-top: 1px solid #dee2e6;">' .
                    $hsnsac[$x] .
                    '</td>
        			<td style="font-size: 12px;border-top: 1px solid #dee2e6;">' .
                    $sku[$x] .
                    '</td>
        			<td style="font-size: 12px;border-top: 1px solid #dee2e6;">' .
                    $quantity[$x] .
                    '</td>
        			<td style="font-size: 12px;border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                    IND_money_format($unit_price[$x]) .
                    '</td>';
                if (!empty($gst)) {
                    $output .= '<td style="font-size: 12px;border-top: 1px solid #dee2e6;">GST@' . $gst[$x] . '%</td>';
                } else {
                    $output .= '<td style="font-size: 12px;border-top: 1px solid #dee2e6;">GST@18%</td>';
                }
                $output .=
                    '<td style="font-size: 12px;border-top: 1px solid #dee2e6;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                    IND_money_format($total[$x]) .
                    '</td>
        					</tr>';
                if (isset($proDesc[$x]) && $proDesc[$x] != "") {
                    $output .=
                        '<tr style="background: #efebf9;" >
        						<td colspan="7" style="font-size: 12px; padding:10px;">' .
                        $proDesc[$x] .
                        '</td></tr>';
                }
            }

            $output .=
                '</tbody>
               </table>

        <table width="100%" border="0"  cellspacing="0" cellpadding="10" align="center" style="max-width:800px; margin-top:-22px;">
                  <tbody>
                    <tr>
                    <td align="left" width="60%" style="position: relative;margin-top:-3px;">
                      <p style="font-size:12px;"><b>Total in words:</b> <text> ' .AmountInWords($row->sub_total) .' only</text></p>';
                        if($row->checkComp_name != "1") {    
                            if (!empty($row->customer_company_name)) {
                                $output .= '<table width="100%" border="0" style="max-width:800px; border-radius:7px; background: #6539c01a; font-size:12px;padding:7px;">
                
                               <tr>
                               
                               
                                <td colspan="3">
                                  
                                    <h5 style="margin-top: 0px;margin-bottom: 5px;color: #6539c0; font-size:13px;">Customer Details (If Required)</h5>
                                </td>
                               </tr>';

                                if ($row->customer_company_name != "") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left; padding-left:10px;">  Name :  <th>
                                                   <td>' .
                                        ucfirst($row->customer_company_name) .
                                        '</td>
                                               </tr>';
                                }
                                if ($row->customer_address != "") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left; padding-left:10px;">  Address:  <th>
                                                   <td>' .
                                        ucfirst($row->customer_address) .
                                        '</td>
                                               </tr>';
                                }
                                if ($row->customer_name != "") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left; padding-left:10px;">  Contact Person:  <th>
                                                   <td>' .
                                        ucfirst($row->customer_name) .
                                        '</td>
                                               </tr>';
                                }
                                if ($row->customer_email != "") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left; padding-left:10px;">  E-mail:  <th>
                                                   <td>' .
                                        $row->customer_email .
                                        '</td>
                                               </tr>';
                                }
                                if ($row->customer_mobile != "" && $row->customer_mobile != "0") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left; padding-left:10px;"> Contact No: <th>
                                                   <td>' .
                                        $row->customer_mobile .
                                        '</td>
                                               </tr>';
                                }
                                if ($row->microsoft_lan_no != "") {
                                    $output .=
                                        '<tr>
                                                   <th style="text-align:left;  padding-left:10px;">Licence No.:<th> 
                                                   <td>' .
                                        $row->microsoft_lan_no .
                                        '</td>
                                               </tr>';
                                }
                
                                $output .= '
                                              
                                        </table>';
                            }
                        }

            $output .=
                '</td>
                    <td align="" width="40%" style="text-align:right;">
                      <table align="" width="100%" style="text-align:right;">
                        <tbody>
                          <tr>
                            <th style="font-size: 12px;" align="left">Initial Amount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                IND_money_format($row->initial_total) .
                '</td>
                          </tr>
                          <!--<tr>
                            <th style="font-size: 12px;" align="left">Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                $row->discount .
                '</td>
                          </tr>
                          <tr>
                            <th style="font-size: 12px;" align="left">After Discount</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                IND_money_format($row->after_discount_po) .
                '</td>
                          </tr>-->';

            $type = $row->type;
            if ($type == "Interstate") {
                if ($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst12) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst18) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst28) .
                        '</td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst12) .
                        '</td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst18) .
                        '</td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 == '0' && $row->igst28 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst28) .
                        '</td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 != '0' && $row->igst28 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst12) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst18) .
                        '</td></tr>';
                } elseif ($row->igst12 == '0' && $row->igst18 != '0' && $row->igst28 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst18) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst28) .
                        '</td></tr>';
                } elseif ($row->igst12 != '0' && $row->igst18 == '0' && $row->igst28 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">IGST@12%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst12) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">IGST@28%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->igst28) .
                        '</td></tr>';
                }
            } elseif ($type == "Instate") {
                if ($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst6) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst6) .
                        '</td></tr>
        							<tr"><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst14) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst14) .
                        '</td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst6) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst6) .
                        '</td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst9) .
                        '</td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 == '0' && $row->cgst14 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst14) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst14) .
                        '</td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 != '0' && $row->cgst14 == '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst6) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst6) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst9) .
                        '</td></tr>';
                } elseif ($row->cgst6 == '0' && $row->cgst9 != '0' && $row->cgst14 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@9%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst9) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">CGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst14) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst14) .
                        '</td></tr>';
                } elseif ($row->cgst6 != '0' && $row->cgst9 == '0' && $row->cgst14 != '0') {
                    $output .=
                        '
        							<tr><th style="font-size: 12px;" align="left">CGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->cgst6) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@6%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst6) .
                        '</td></tr>
        							<tr><th>CGST@14%:</th><td style="font-size: 12px;">' .
                        IND_money_format($row->cgst14) .
                        '</td></tr>
        							<tr><th style="font-size: 12px;" align="left">SGST@14%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($row->sgst14) .
                        '</td></tr>';
                }
            } else {
                //$output .='<tr><th style="font-size: 12px;" align="left">IGST@18%:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.IND_money_format($row->igst18).'</td></tr>';
            }
            if ($row->total_igst > 0) {
                $output .= '<tr><th style="font-size: 12px;" align="left">IGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row->total_igst) . '</td></tr>';
            }
            if ($row->total_cgst > 0) {
                $output .= '<tr><th style="font-size: 12px;" align="left">CGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row->total_cgst) . '</td></tr>';
            }
            if ($row->total_sgst > 0) {
                $output .= '<tr><th style="font-size: 12px;" align="left">SGST:</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' . IND_money_format($row->total_sgst) . '</td></tr>';
            }

            if (isset($row->extra_charge_label) && !empty($row->extra_charge_label)) {
                $labelExra = explode("<br>", $row->extra_charge_label);
                $valueExra = explode("<br>", $row->extra_charge_value);
                for ($i = 0; $i < count($labelExra); $i++) {
                    $output .=
                        '<tr><th style="font-size: 12px;" align="left">' .
                        $labelExra[$i] .
                        ':</th><td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                        IND_money_format($valueExra[$i]) .
                        '</td></tr>';
                }
            }
            $output .=
                '
                          <tr><td style="font-size: 12px; padding:0px;" colspan="2"><hr style="margin:2px 0px; border: 0.5px solid #6539c0; "></td></tr>
                          <tr>
                          
                            <th style="font-size: 12px;" align="left">TOTAL</th>
        
                            <td style="font-size: 12px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>' .
                IND_money_format($row->sub_total) .
                '</td>
                          </tr>
                        </tbody>
                        
                      </table>
                    </td>
                  </tr>
                  </tbody>
                </table>';

            $output .= '<table width="60%" border="0"  cellspacing="0" cellpadding="10" align="" style="max-width:800px; margin-top:-22px;';
            if (!empty($row->customer_company_name)) {
                $output .= '0px;">';
            } else {
                $output .= '-20px;">';
            }
            $output .= '<tbody>
                    <tr>
                  <td align="left">
                    <h5 style="color: #6539c0;margin-bottom: 10px;margin-top:-3px;">Terms and Conditions</h5>
                    <ol style="padding: 0 15px; font-size:12px;">';
            $custTerm = explode("<br>", $row->terms_condition);
            $no = 1;
            for ($i = 0; $i < count($custTerm); $i++) {
                $output .= '<li>' . $custTerm[$i] . '</li>';
            }
            //'.nl2br($row->terms_condition).'
            $output .= '</ol>
                  </td>
                </tr>
                  </tbody>
                </table>
        
       </main>
      <!-- Footer -->
            <footer style="border-top: 1px dashed #333; margin-top: -45px; position: absolute; bottom: 0; width: 100%; padding: 10px 0;">
                <div class="pagenum-container" style="text-align: right; font-size: 12px; margin-top: -30px;">Page <span class="pagenum"> </span> of TPAGE</div>
                <center>
                    <span style="font-size:12px"><b>"This is System Generated PO, Sign and Stamp not Required"</b></span><br>
                    <b>
                        <span style="font-size: 10px;">
                            E-mail - ' . $admin_details["company_email"] . '</br>
                            | Ph. - +91-' . $admin_details["company_mobile"] . '</br>
                            | GSTIN: ' . $admin_details["company_gstin"] . '</br>
                            | CIN: ' . $admin_details["cin"] . '</span>
                    </b><br>
                    <b><span style="font-size:12px;">Powered By <a href="https://team365.io/">Team365 CRM</a></span></b>
                </center>
            </footer>
      </body>
      </html>';
        }

        return $output;
    }
    public function get_renewal_po()
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        if ($this->session->userdata('type') == 'admin') {
            $start_date = date('Y-m-d');
            $thirty_one = strtotime("31 Day"); // Add thirty one days to start date
            $last_date = date('Y-m-d', $thirty_one); //One Month later date
            $this->db->select('id,org_name,subject,renewal_date,purchaseorder_id,so_owner,customer_company_name');
            $this->db->from('purchaseorder');
            $this->db->where('session_company', $session_company);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('delete_status', 1);
            $this->db->where('is_renewal', 1);
            $this->db->where('renewal_date >=', $start_date);
            $this->db->where('renewal_date <=', $last_date);
            $this->db->where('end_renewal', 0);
        } elseif ($this->session->userdata('type') == 'standard') {
            $start_date = date('Y-m-d');
            $thirty_one = strtotime("31 Day"); // Add thirty one days to start date
            $last_date = date('Y-m-d', $thirty_one); //One Month later date
            $this->db->select('id,org_name,subject,renewal_date,purchaseorder_id,customer_company_name');
            $this->db->from('purchaseorder');
            $this->db->where('session_company', $session_company);
            $this->db->where('session_comp_email', $session_comp_email);
            //$this->db->where('sess_eml', $sess_eml);
            $this->db->where('so_owner', $this->session->userdata('name'));
            $this->db->where('delete_status', 1);
            $this->db->where('is_renewal', 1);
            $this->db->where('renewal_date >=', $start_date);
            $this->db->where('renewal_date <=', $last_date);
            $this->db->where('end_renewal', 0);
        }
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function update_end_renewal($id)
    {
        $this->db->set('end_renewal', 1);
        $this->db->where('id', $id);
        $this->db->update('purchaseorder');
    }

    public function soProfitDetails($saleorder_id, $productName)
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('id,so_after_discount,so_pro_total');
        $this->db->from('product_wise_profit');
        $this->db->where('session_company', $session_company);
        $this->db->where('session_comp_email', $session_comp_email);
        if ($this->session->userdata('type') == 'standard') {
            $this->db->where('sess_eml', $sess_eml);
        }
        $this->db->where('so_id', $saleorder_id);
        $this->db->where('pro_name', $productName);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function UpdateProductProfit($dtatArr, $proId, $saleorder_id)
    {
        $this->db->where('id', $proId);
        $this->db->where('so_id', $saleorder_id);
        $this->db->update('product_wise_profit', $dtatArr);
    }

    // PLease write code above this
    function dbGetSupplierName($supplier_comp_name)
    {
        if ($supplier_comp_name != null) {
            $sess_eml = $this->session->userdata('email');
            $this->db->select('contact.id,contact.name');
            $this->db->from('contact');
            $this->db->join('organization', 'contact.org_name=organization.org_name', 'left');
            $this->db->where('organization.org_name', $supplier_comp_name);
            $this->db->where('organization.delete_status', 1);
            $this->db->order_by('organization.datetime', 'DESC');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $query;
            }
        } else {
            return false;
        }
    }
    function dbGetSupplierDetails($supplier_name)
    {
        if ($supplier_name != null) {
            $sess_eml = $this->session->userdata('email');
            $this->db->select('contact.mobile, contact.email');
            $this->db->where('contact.id', $supplier_name);
            $query = $this->db->get('contact');
            return $query->result();
        } else {
            return false;
        }
    }

    // function dbGetSupplierPrimartyDetails($supplier_name)
    // {
    //     if ($supplier_name != null) {
    //         $sess_eml = $this->session->userdata('email');
    //         $this->db->select('organization.mobile, organization.email');
    //         $this->db->from('contact');
    //         $this->db->join('organization', 'contact.org_name=organization.org_name', 'left');
    //         // $this->db->where('organization.sess_eml', $sess_eml);
    //         $this->db->where('organization.id', $supplier_name);
    //         $this->db->order_by('organization.datetime', 'DESC');
    //         $query = $this->db->get();
    //         return $query->result();
    //     } else {
    //         return false;
    //     }
    // }



    //< ----------------- Mass Update --------------------------- >
  public function mass_save($mass_id, $dataArry)
  {
    // print_r($dataArry);die;
    $this->db->where('id', $mass_id);
    if($this->db->update('purchaseorder', $dataArry)){
		  return true;
	}else{
      return false;
    }
  }
  
}
?>
