<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';


$route['about_us'] = 'home/about_us';
$route['accreditation'] = 'home/accreditation';
$route['leadership/team'] = 'home/leadership_team';
$route['product/updates'] = 'home/product_updates';
$route['terms_conditions'] = 'home/terms_conditions';



///////////////// Backend Controller //////////////////////

$route['admin'] = 'admin/home/index';

$route['admin/survey/template'] = 'admin/survey_template/template';
$route['admin/survey/template/add'] = 'admin/survey_template/add_template';

$route['admin/content/tutorials/heading'] = 'admin/content_tutorials/heading';
$route['admin/content/tutorials/heading/description/(:any)'] = 'admin/content_tutorials/heading_description';

$route['admin/content/tutorials/heading/add'] = 'admin/content_tutorials/heading_add';
$route['admin/content/tutorials/heading/edit'] = 'admin/content_tutorials/heading_edit';



$route['admin/forgot_password'] = 'admin/home/forgot_password';
$route['admin/profile'] = 'admin/home/profile';

$route['admin/setting/configuration/manage'] = 'admin/home/manage_configuration';
$route['admin/setting/track-readiness/read-mores'] = 'admin/home/track_readiness_read_mores';
$route['admin/setting/track-readiness/read-mores-edit/:num'] = 'admin/home/track_readiness_read_mores_edit';

$route['admin/setting/email_templates/manage'] = 'admin/home/manage_email_templates';
$route['admin/setting/email_templates/edit']='admin/home/edit_email_templates';
$route['admin/cms/home/welcome'] = 'admin/cms/welcome_content';

/*$route['admin/sub_admins'] = 'admin/sub_admins/index';
$route['admin/sub_admins'] = 'admin/sub_admins/delete_guest';*/

$route['admin/logout'] = 'admin/home/logout';



$route['admin/logo'] = 'admin/Configuration/logo';

 
$route['translate_uri_dashes'] = FALSE;