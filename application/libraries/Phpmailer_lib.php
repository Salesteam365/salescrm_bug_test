<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Phpmailer_lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/phpmailer/src/Exception.php';
        require_once APPPATH.'third_party/phpmailer/src/PHPMailer.php';
        require_once APPPATH.'third_party/phpmailer/src/SMTP.php';
        //$mail = new PHPMailer(true);
        $mail = new PHPMailer;
        return $mail;
    }
}