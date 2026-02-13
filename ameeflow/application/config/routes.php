<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['recover/password/(:any)/(:any)'] = 'forgot_password/recover_password';
$route['share/report/(:any)'] = 'home/sharedReport';
$route['share/alignment_map/(:any)'] = 'home/sharedAlignmentMap';
$route['share/guide/(:any)'] = 'home/helpGuide';
$route['share/notification/(:any)'] = 'home/sentNotification';
$route['404_override'] = '';

$route['profile'] = 'signin/profile';

$route['forgot-password/project-manager'] = 'signin/forgot_password';
$route['forgot-password/user'] = 'signin/forgot_password';
$route['recover-password/project-manager/(:any)/(:any)'] = 'signin/recover_password';
$route['recover-password/user/(:any)/(:any)'] = 'signin/recover_password';

///////////////// System Admin Controller //////////////////

$systemAdminDirName = str_replace('/','',$this->config->item('system_directory_name'));
$route["$systemAdminDirName/profile"] = "$systemAdminDirName/home/profile";
$route["$systemAdminDirName/updateProfile"] = "$systemAdminDirName/home/updateProfile";
$route["$systemAdminDirName/master-alignment-map"] = "$systemAdminDirName/master_alignment_map";
$route["$systemAdminDirName/master_alignment_map/toggleSLO"] = "$systemAdminDirName/master_alignment_map/toggleSLO";
$route["$systemAdminDirName/course-enrollment"] = "$systemAdminDirName/course_enrollment";

///////////////// Backend Controller //////////////////////

$adminDirName = str_replace('/','',$this->config->item('admin_directory_name'));
$route["$adminDirName"] = "$adminDirName/home/index";
$route["$adminDirName/profile"] = "$adminDirName/home/profile";
$route["$adminDirName/forgot_password"] = "$adminDirName/home/forgot_password";
$route["$adminDirName/recover_password/:any"] = "$adminDirName/home/recover_password";
$route["$adminDirName/setting/configuration/manage"] = "$adminDirName/home/manage_configuration";
$route["$adminDirName/setting/notification/send"] = "$adminDirName/home/send_notification";
$route["$adminDirName/setting/email_templates/manage"] = "$adminDirName/home/manage_email_templates";
$route["$adminDirName/setting/email_templates/edit"]="$adminDirName/home/edit_email_templates";
$route["$adminDirName/cms/home/welcome"] = "$adminDirName/cms/welcome_content";
/*$route["$adminDirName/sub_admins"] = "$adminDirName/sub_admins/index";
$route["$adminDirName/sub_admins"] = "$adminDirName/sub_admins/delete_guest";*/
$route["$adminDirName/logout"] = "$adminDirName/home/logout";
$route["$adminDirName/logo"] = "$adminDirName/Configuration/logo";

$route['translate_uri_dashes'] = FALSE;