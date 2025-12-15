<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Create_model extends CI_Model
{

      public function __construct() {
        parent::__construct();
        $this->load->dbforge(); // Required for DB Forge operations
    }


    
    public function table_exists($table_name) {
        return $this->db->table_exists($table_name);
    }

    public function get_existing_fields($table_name) {
        return $this->db->list_fields($table_name);
    }



    public function create_new_table($table_name, $fields) {
        $field_array = [];

        foreach($fields as $f) {
            $fname  = $f['name'];
            $ftype  = strtoupper($f['type']);
            $flen   = !empty($f['length']) ? $f['length'] : null;
            $fnull  = isset($f['null']) && $f['null'] == 'true' ? TRUE : FALSE;

            $field_array[$fname] = [
                'type' => $ftype,
                'constraint' => $flen,
                'null' => $fnull
            ];

            if(isset($f['auto_increment']) && $f['auto_increment'] == 'true'){
                $field_array[$fname]['auto_increment'] = TRUE;
                $this->dbforge->add_key($fname, TRUE); // Primary key
            }
        }

        $this->dbforge->add_field($field_array);
        return $this->dbforge->create_table($table_name, TRUE);
    }

    
    public function add_missing_columns($table_name, $fields) {
        $existing_fields = $this->get_existing_fields($table_name);
        $added_columns = [];

        foreach ($fields as $f) {
            $fname = $f['name'];

            if (!in_array($fname, $existing_fields)) {
                $ftype  = strtoupper($f['type']);
                $flen   = !empty($f['length']) ? $f['length'] : null;
                $fnull  = isset($f['null']) && $f['null'] == 'true' ? TRUE : FALSE;

                $new_field = [
                    $fname => [
                        'type' => $ftype,
                        'constraint' => $flen,
                        'null' => $fnull
                    ]
                ];

                if(isset($f['auto_increment']) && $f['auto_increment'] == 'true'){
                    $new_field[$fname]['auto_increment'] = TRUE;
                    $this->dbforge->add_key($fname, TRUE);
                }

                $this->dbforge->add_column($table_name, $new_field);
                $added_columns[] = $fname;
            }
        }

        return $added_columns;
    }
    
}
?>
