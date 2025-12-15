<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function dd($data=null){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}
function pr($data=null){
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}