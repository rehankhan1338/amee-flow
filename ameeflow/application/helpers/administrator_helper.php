<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('chkAFUserLoggedIn')){
    function chkAFUserLoggedIn($sessId){
        $CI = & get_instance();
        if($sessId == false){	
            $cookie_prefix=$CI->config->item('cookie_prefix');
            if(isset($_COOKIE[$cookie_prefix.'light_user_access_sts']) && $_COOKIE[$cookie_prefix.'light_user_access_sts']!=''){                  
                $CI->Users_mdl->chkLightAccessPermission($_COOKIE[$cookie_prefix.'light_user_access_sts']);
            }else{           
                if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=''){
                    $reURL = urlencode(uri_string().'?'.$_SERVER['QUERY_STRING']);
                }else{
                    $reURL = urlencode(uri_string());
                }			
                redirect(base_url().'signin?qs='.$reURL);	
            }		
        }else{
            // $CI->load->model('Users_mdl');
            return $CI->Users_mdl->userAccessDetails($sessId);
        }
    }
}
if (!function_exists('chkSystemAdminLoggedIn')){
    function chkSystemAdminLoggedIn($sessId){
        $CI = & get_instance();
        if($sessId == false){	
            if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=''){
                $reURL = urlencode(uri_string().'?'.$_SERVER['QUERY_STRING']);
            }else{
                $reURL = urlencode(uri_string());
            }			
            redirect(base_url().'signin?qs='.$reURL);			
        }else{
            // $CI->load->model('Users_mdl');
            return $CI->Users_mdl->systemAdminDetails($sessId);
        }
    }
}
if (!function_exists('chkSystemAdministratorLoggedIn')){
    function chkSystemAdministratorLoggedIn($sessId){
        $CI = & get_instance();
        if($sessId == false){	
            $uniAuthSts = 0;
            $uniShortName = $CI->uri->segment(2);
            if(isset($uniShortName) && $uniShortName!=''){
                $uniAuthSts = chkUniversityUrlShortNameSts($uniShortName);
            }
            if($uniAuthSts==0){
                redirect(base_url().$CI->config->item('system_directory_name').'error/unauthorised-university');
            }else{
                if(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!=''){
                    $reURL = urlencode(uri_string().'?'.$_SERVER['QUERY_STRING']);
                }else{
                    $reURL = urlencode(uri_string());
                }			
                redirect(base_url().$CI->config->item('system_directory_name').$uniShortName.'?qs='.$reURL);
            }			
        }else{
            $CI->load->model('Backend/Accounts_mdl');
            return $CI->Accounts_mdl->accounts_details_arr($sessId);
        }
    }
}
function chkUniversityUrlShortNameSts($uniShortName){
    $CI = & get_instance();
    $CI->load->model('Backend/Accounts_mdl');
    return $CI->Accounts_mdl->chkUniversityUrlShortNameSts($uniShortName);
}
function administrator_menu_list_helper($admin_type,$menu_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->administrator_menu_list($admin_type,$menu_ids);
}
function administrator_submenu_list_helper($menu_id,$admin_type,$submenu_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->administrator_submenu_list($menu_id,$admin_type,$submenu_ids);
}
function administrator_submenu_subcat_list_helper($submenu_id,$admin_type,$submenu_subcat_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->administrator_submenu_subcat_list($submenu_id,$admin_type,$submenu_subcat_ids);
}

function user_menu_list_helper($userType,$menu_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->user_menu_list($userType,$menu_ids);
}
function user_submenu_list_helper($menu_id,$userType,$submenu_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->user_submenu_list($menu_id,$userType,$submenu_ids);
}
function user_submenu_subcat_list_helper($submenu_id,$userType,$submenu_subcat_ids){
    $CI = & get_instance();
    $CI->load->model('Master_data_mdl');
    return $CI->Master_data_mdl->user_submenu_subcat_list($submenu_id,$userType,$submenu_subcat_ids);
}