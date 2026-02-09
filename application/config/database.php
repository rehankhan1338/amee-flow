<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;
$CI = get_instance();

$db_subdomain_name=$CI->config->item("subdomain_name");
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'secondw6_amee';
$db['default']['password'] = '3ORTdGVMe=kD';
$db['default']['database'] = 'secondw6_amee_web';
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = 'tbl_';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

if(isset($_GET['universityId']) && $_GET['universityId']!=''){

$db['amee_pro']['hostname'] = 'localhost';
$db['amee_pro']['username'] = 'mssracom_amee_db';
$db['amee_pro']['password'] = '7Z-4&Y!E(#QB';
$db['amee_pro']['database'] = $_GET['udbname'];
$db['amee_pro']['dbdriver'] = 'mysqli';
$db['amee_pro']['dbprefix'] = $_GET['tblpre'];
$db['amee_pro']['pconnect'] = FALSE;
$db['amee_pro']['db_debug'] = TRUE;
$db['amee_pro']['cache_on'] = FALSE;
$db['amee_pro']['cachedir'] = '';
$db['amee_pro']['char_set'] = 'utf8';
$db['amee_pro']['dbcollat'] = 'utf8_general_ci';
$db['amee_pro']['swap_pre'] = '';
$db['amee_pro']['autoinit'] = TRUE;
$db['amee_pro']['stricton'] = FALSE;
}