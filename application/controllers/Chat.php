<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller
{
    public function index()
    {
      
        // Firebase_model ko load karein
        $this->load->model('firebase_model');
     echo 1;
        // Firebase ko initialize karein
        $firebase = $this->firebase_model->initialize_firebase();
       echo 2;
        // Firebase object ko view mein pass karein
        $data['firebase'] = $firebase;

        // View ko load karein aur Firebase object ko pass karein
      
    }
}
?>
