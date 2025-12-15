<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('vendor/autoload.php');
 
use Kreait\Firebase\Factory;
// use Kreait\Firebase\ServiceAccount;
 
class Firebase_model extends CI_Model {
 
    public function __construct() {
        parent::__construct();
    }
 
    public function initialize_firebase() {
        // Load Firebase credentials
        $this->config->load('firebase', TRUE);
        $firebase_config = $this->config->item('firebase');
        $firebase = (new Factory)->withServiceAccount($firebase_config['firebase']['service_account'])->withDatabaseUri($firebase_config['firebase']['database_url']);
 
        return $firebase;
    }
}