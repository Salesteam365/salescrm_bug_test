<?php defined('BASEPATH') OR exit('No direct script access allowed');
//require 'PHPMailer/PHPMailerAutoload.php';
class Email_lib {
    private $_CI;
    public function __construct() {
        $this->_CI = & get_instance();
        $this->_CI->load->model('Mail_model');
        error_reporting(0);
    }
    /**
    * Send an email using SMTP settings retrieved from Mail_model; initializes CodeIgniter email library and attempts to send the message.
    * @example
    * $result = $this->email_lib->send_email('recipient@example.com', 'Order Confirmation', '<p>Your order has shipped</p>', 'cc@example.com', '/path/to/invoice.pdf');
    * echo $result // render some sample output true (on success) or false (on failure);
    * @param {string|array} $to - Recipient email address or array of addresses.
    * @param {string} $subject - Email subject line.
    * @param {string} $message - Email body (HTML allowed).
    * @param {string|array} $cc - Optional CC recipient email address or array of addresses (default: '').
    * @param {string|array} $attach - Optional file path or array of file paths to attach (default: '').
    * @returns {bool} Return TRUE on successful send, FALSE on failure (also returns FALSE if SMTP config cannot be loaded and sets flashdata).
    */
    public function send_email($to, $subject, $message, $cc = '', $attach = '') {
        $data_all = $this->_CI->Mail_model->get_allemail();
        if(!$data_all){
            $SESS_CI = & get_instance();
            $SESS_CI->load->library('session');
            $SESS_CI->session->set_flashdata('msg', "<i class='fa fa-exclamation-triangle' style='color: red; margin-right: 7px;'></i>Sorry Our Mail Server is occur,  try again after some time.");
            return false;
        }
        $smtp_host = $data_all['smtp_host'];
        $smtp_user = $data_all['email_id'];
        $smtp_pass = $data_all['email_password'];
        $smtp_crypto = $data_all['encryption_type'];
        $smtp_port = $data_all['gmail_port'];

        $this->_CI->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = $smtp_host;
        $config['smtp_user'] = $smtp_user;
        $config['smtp_pass'] = $smtp_pass;
        $config['smtp_crypto'] = $smtp_crypto;
        $config['smtp_port'] = $smtp_port;
        $config['mailtype'] = "html";
        $config['crlf'] = "\r";
        $config['newline'] = "\n";
        $config['charset'] = "utf-8";
        $config['wordwrap'] = TRUE;
        $this->_CI->email->initialize($config);
        $this->_CI->email->set_crlf("\r\n");
        $this->_CI->email->set_newline("\r\n");
        $this->_CI->email->from($config['smtp_user']);
        $this->_CI->email->to($to);
        if ($cc !== '') {
            $this->_CI->email->cc($cc);
        }
        $this->_CI->email->subject($subject);
        $this->_CI->email->message($message);
        if ($attach !== '') {
            $this->_CI->email->attach($attach);
        }
        return $this->_CI->email->send();
        // return ($this->_CI->email->send()) ? TRUE : FALSE;
    }
}
