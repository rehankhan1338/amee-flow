<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('checkIfLoggedIn'))
{
    function checkIfLoggedIn($session_loggedIn)
    {
        $loggedIn = $session_loggedIn;
        if($loggedIn == false)
        {	
			//$redirect_url = urlencode(uri_string());
			if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=''){
				$redirect_url = urlencode(uri_string().'?'.$_SERVER['QUERY_STRING']);
			}else{
				$redirect_url = urlencode(uri_string());
			}
            redirect(base_url().'admin?redirect_url='.$redirect_url);
        }
    }
	
	
}