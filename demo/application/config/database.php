<?php defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

$CI = get_instance();

$db['default']['hostname'] = $CI->config->item("sbHost");
$db['default']['username'] = $CI->config->item("sbUsername");
$db['default']['password'] = $CI->config->item("sbPassword");
$db['default']['database'] = $CI->config->item("sbDatabase");
$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = $CI->config->item("sdTblPrefix");
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['amee_web']['hostname'] = $CI->config->item("webHost");
$db['amee_web']['username'] = $CI->config->item("webUser");
$db['amee_web']['password'] = $CI->config->item("webPass");
$db['amee_web']['database'] = $CI->config->item("webDbName");
$db['amee_web']['dbdriver'] = 'mysqli';
$db['amee_web']['dbprefix'] = $CI->config->item("superadmin_table_prefix");
$db['amee_web']['pconnect'] = FALSE;
$db['amee_web']['db_debug'] = TRUE;
$db['amee_web']['cache_on'] = FALSE;
$db['amee_web']['cachedir'] = '';
$db['amee_web']['char_set'] = 'utf8';
$db['amee_web']['dbcollat'] = 'utf8_general_ci';
$db['amee_web']['swap_pre'] = '';
$db['amee_web']['autoinit'] = TRUE;
$db['amee_web']['stricton'] = FALSE;