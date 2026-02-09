<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_PHPMailer {
    public function __construct() {
	}
	public function My_PHPMailer() {
        require_once('PHPMailer/PHPMailerAutoload.php');
    }
}