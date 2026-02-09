<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checkIfLoggedIn')){

    function checkIfLoggedIn($session_loggedIn){
        $loggedIn = $session_loggedIn;
        if($loggedIn == false){
            redirect(base_url().'login?dest='.urlencode($_SERVER['REQUEST_URI']));
        }
    }
}