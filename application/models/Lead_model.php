<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Lead_model extends CI_Model
{
    var $table = 'lead';
    var $chat = 'chats';
    var $sort_by = [null, 'name', 'org_name', 'email', 'assigned_to_name', 'lead_status', null];
    var $search_by = ['name', 'org_name', 'email', 'assigned_to_name', 'lead_status'];
    var $sort_by_assigned = [null, 'name', 'org_name', 'email', 'lead_owner', 'lead_status', null];
    var $search_by_assigned = ['name', 'org_name', 'email', 'lead_owner', 'lead_status'];
    var $order = ['id' => 'desc'];
    // private function _get_datatables_query()
    // {
    //     $sess_eml = $this->session->userdata('email');
    //     $session_comp_email = $this->session->userdata('company_email');
    //     $session_company = $this->session->userdata('company_name');
    //     if ($this->session->userdata('type') === 'admin') {
    //         $this->db->from($this->table);
    //         $this->db->where('session_comp_email', $session_comp_email);
    //         $this->db->where('session_company', $session_company);
    //         if ($this->input->post('searchDate')) {
    //             $search_date = $this->input->post('searchDate');
    //             if ($this->input->post('fromDate') && $this->input->post('toDate')) {
    //                 $this->db->where('currentdate >=', $this->input->post('fromDate'));
    //                 $this->db->where('currentdate <=', $this->input->post('toDate'));
    //             } elseif ($search_date == "This Week") {
    //                 $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
    //             } else {
    //                 $this->db->where('currentdate >=', $search_date);
    //             }
    //         }
    //         if ($this->input->post('searchUser')) {
    //             $searchUser = $this->input->post('searchUser');
    //             $this->db->where('sess_eml', $searchUser);
    //         }
    //         if ($this->input->post('searchStaus')) {
    //             $searchStaus = $this->input->post('searchStaus');
    //             $this->db->where('lead_status', $searchStaus);
    //         }
    //         $this->db->where('delete_status', 1);
    //     } elseif ($this->session->userdata('type') === 'standard') {
    //         $this->db->from($this->table);
    //         $this->db->where('sess_eml', $sess_eml);
    //         $this->db->where('session_comp_email', $session_comp_email);
    //         $this->db->where('session_company', $session_company);
    //         if ($this->input->post('searchDate')) {
    //             $search_date = $this->input->post('searchDate');
    //             if ($search_date == "This Week") {
    //                 $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
    //             } else {
    //                 $this->db->where('currentdate >=', $search_date);
    //             }
    //         }
    //         if ($this->input->post('searchStaus')) {
    //             $searchStaus = $this->input->post('searchStaus');
    //             $this->db->where('lead_status', $searchStaus);
    //         }
    //         $this->db->where('delete_status', 1);
    //     }
    //     $i = 0;
    //     foreach (
    //         $this->search_by
    //         as $item // loop column
    //     ) {
    //         if ($_POST['search']['value']) {
    //             // if datatable send POST for search
    //             if ($i === 0) {
    //                 // first loop
    //                 $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
    //                 $this->db->like($item, $_POST['search']['value']);
    //             } else {
    //                 $this->db->or_like($item, $_POST['search']['value']);
    //             }
    //             if (count($this->search_by) - 1 == $i) {
    //                 //last loop
    //                 $this->db->group_end();
    //             } //close bracket
    //         }
    //         $i++;
    //     }
    //     if (isset($_POST['order'])) {
    //         // here order processing
    //         $this->db->order_by($this->sort_by[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } elseif (isset($this->order)) {
    //         $order = $this->order;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }
        private function _get_datatables_query()
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        if ($this->session->userdata('type') === 'admin') {
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
            if ($this->input->post('searchStaus')) {
                $searchStaus = $this->input->post('searchStaus');
                $this->db->where('lead_status', $searchStaus);
            }
            $this->db->where('delete_status', 1);
        } 
        elseif ($this->session->userdata('type') === 'standard') {
            $this->db->from($this->table);
            $this->db->where('assigned_to', $sess_eml);
            
            if ($this->input->post('searchDate')) {
                $search_date = $this->input->post('searchDate');
                if ($search_date == "This Week") {
                    $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
                } else {
                    $this->db->where('currentdate >=', $search_date);
                }
            }
            
            if ($this->input->post('searchStaus')) {
                $searchStaus = $this->input->post('searchStaus');
                $this->db->where('lead_status', $searchStaus);
            }
            
            $this->db->where('delete_status', 1);
            
            // Use or_where to add the OR condition
            $this->db->group_start();
            $this->db->or_where('session_comp_email', $session_comp_email);
            $this->db->or_where('session_company', $session_company);
            $this->db->group_end();

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
    public function get_datatables()
    {
        $this->_get_datatables_query();
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
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_all_lead($search_date, $search, $per_page, $start)
    {
        //$status,

        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');

        $this->db->from($this->table);
        if ($this->session->userdata('type') === 'standard') {
            $this->db->where('sess_eml', $sess_eml);
        }
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        //$this->db->where('lead_status',$status);
        if ($search_date == "This Week") {
            $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
        } else {
            if ($search_date != "") {
                $this->db->where('currentdate >=', $search_date);
            } else {
                //$this->db->where('currentdate >=',date('Y-m-d',strtotime('last monday')));
            }
        }
        $i = 0;
        foreach (
            $this->search_by
            as $item // loop column
        ) {
            if ($search) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $search);
                } else {
                    $this->db->or_like($item, $search);
                }
                if (count($this->search_by) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        $this->db->where('delete_status', 1);

        $this->db->order_by('lead_status', 'desc');
        $this->db->order_by('id', 'desc');
        //$this->db->limit(15);
        $this->db->limit($per_page, $start);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_all_count($search_date, $search, $assigned = '')
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');

        $this->db->from($this->table);
        if ($this->session->userdata('type') === 'standard') {
            $this->db->where('sess_eml', $sess_eml);
        }
        if ($assigned != "") {
            $this->db->where('assigned_status', 1);
        }
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        if ($search_date == "This Week") {
            $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
        } else {
            if ($search_date != "") {
                $this->db->where('currentdate >=', $search_date);
            } else {
                $this->db->where('currentdate >=', date('Y-m-d', strtotime('last monday')));
            }
        }
        $i = 0;
        foreach (
            $this->search_by
            as $item // loop column
        ) {
            if ($search) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $search);
                } else {
                    $this->db->or_like($item, $search);
                }
                if (count($this->search_by) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getTotalPrice($lead_status, $assigned = '')
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('lead_status');
        $this->db->select_sum('initial_total');
        $this->db->from('lead');
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        if ($assigned != "") {
            $this->db->where('assigned_status', 1);
        }
        if ($this->session->userdata('type') === 'standard') {
            $this->db->where('sess_eml', $sess_eml);
        }
        $this->db->where('delete_status', 1);
        $this->db->where('lead_status', $lead_status);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function update_status($leadArr, $id)
    {
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $leadArr)) {
            return true;
        } else {
            return false;
        }
    }
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    public function lead_id($lead_id, $id)
    {
        $data = [
            'lead_id' => $lead_id,
        ];
        $this->db->where('id', $id);
        if ($this->db->update($this->table, $data)) {
            return true;
        } else {
            return false;
        }
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
    /*public function assignedUser($userAssign='',$leadid='')
      {  
    	$session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
    	
        $this->db->from('lead');
    	$this->db->select('assigned_to, id, assigned_to_name');
    	$this->db->where('session_comp_email',$session_comp_email);
        $this->db->where('session_company',$session_company);
    	if($userAssign!=""){
    		$this->db->where('assigned_to',$userAssign);
    	}
    	if($leadid!=""){
    		$this->db->where('id',$leadid);
    	}
    	$this->db->order_by('id','desc');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
      }*/
    public function update($where, $data)
    {
        if ($this->session->userdata('type') == 'admin') {
            $this->db->update($this->table, $data, $where);
        } else {
            $this->db->where('sess_eml', $this->session->userdata('email'));
            $this->db->update($this->table, $data, $where);
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
    private function _get_datatables_query_assigned()
    {
        $sess_eml = $this->session->userdata('email');
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        if ($this->session->userdata('type') === 'admin') {
            $this->db->from($this->table);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
            $this->db->where('assigned_status', 1);
            $this->db->where('delete_status', 1);
        } elseif ($this->session->userdata('type') === 'standard') {
            $this->db->from($this->table);
            $this->db->where('assigned_to', $sess_eml);
            $this->db->where('session_comp_email', $session_comp_email);
            $this->db->where('session_company', $session_company);
            $this->db->where('assigned_status', 1);
            $this->db->where('delete_status', 1);
        }
        $i = 0;
        foreach (
            $this->search_by_assigned
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
                if (count($this->search_by_assigned) - 1 == $i) {
                    //last loop
                    $this->db->group_end();
                } //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            // here order processing
            $this->db->order_by($this->sort_by_assigned[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function get_datatables_assigned()
    {
        $this->_get_datatables_query_assigned();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered_assigned()
    {
        $this->_get_datatables_query_assigned();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_assigned()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function lead_status($lead_id, $status)
    {
        $this->db->set('lead_status', $status);
        $this->db->where('lead_id', $lead_id);
        $this->db->update($this->table);
    }
    public function get_lead_id($id)
    {
        $this->db->select('lead_id');
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row()->lead_id;
    }
    public function get_chat_by_id($data)
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->from($this->chat);
        $this->db->where('entry_id', $data);
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $query = $this->db->get();
        return $query->result();
    }
    public function sendmsg($data)
    {
        $this->db->insert($this->chat, $data);
        return $this->db->insert_id();
    }
    public function update_lead_track_status($where, $data)
    {
        $this->db->update($this->table, $data, $where);
    }
    
     public function save_lead_status($data)
    {
        // print_r($data);die;
        $this->db->insert("lead_status", $data);
        return $this->db->insert_id();
    }

    public function get_leatStatus()
    {
        $session_comp_email = $this->session->userdata('company_email');
        $session_company = $this->session->userdata('company_name');
        $this->db->select('*');
        $this->db->from("lead_status");
        $this->db->where('session_comp_email', $session_comp_email);
        $this->db->where('session_company', $session_company);
        $query = $this->db->get();
        return $query->result_array();
    }

public function mass_save($mass_id, $dataArry)
  {
    // print_r($mass_id);die;
    $this->db->where('id', $mass_id);
    if($this->db->update($this->table, $dataArry)){
		  return true;
		}else{
      return false;
    }
  }
    
    
    
    
}
?>
