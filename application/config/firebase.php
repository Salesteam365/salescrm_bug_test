<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Firebase Realtime Database ke liye credentials
$config['firebase'] = array(
    'service_account' => APPPATH . 'config/team365chat-firebase-adminsdk-fdbqv-a266fff370.json',
    'database_url' => 'https://team365chat-default-rtdb.firebaseio.com/',
);
