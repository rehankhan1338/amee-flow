<?php

defined('BASEPATH') OR exit('No direct script access allowed'); 

$route['default_controller'] = 'home';
$route['404_override'] = '';

$route['forgot_password'] = 'home/forgot_password';
$route['recover/password/(:any)/(:any)'] = 'home/recover_password';

$route['department/readiness'] = 'readiness';

$route['department/envision/action1'] = 'envision';
$route['department/envision/action2'] = 'envision/action2';
$route['department/envision/action2/upload'] = 'envision/upload_ungrad_grad_plso';
$route['department/envision/action3'] = 'envision/action3';

$route['department/coordinate/action1'] = 'coordinate';
$route['department/coordinate/action2'] = 'coordinate/action2';
$route['department/coordinate/action3'] = 'coordinate/action3';

$route['department/coordinate/action2/upload_courses/:any'] = 'coordinate/upload_courses';
$route['department/coordinate/action2/import_data_review_courses/:any'] = 'coordinate/import_data_review_courses';
$route['department/coordinate/action2/import_data_courses/:any'] = 'coordinate/import_data_courses';

$route['department/design/action1'] = 'design';
$route['department/design/action2'] = 'design/action2';
$route['department/design/action3'] = 'design/action3';

$route['department/reflect/action1'] = 'reflect';
$route['department/reflect/action2'] = 'reflect/action2';
$route['department/reflect/action3'] = 'reflect/action3';

$route['department/create'] = 'create';

$route['survey/form/:any'] = 'Survey_form';
$route['survey/form/questions/(:any)/(:any)'] = 'Survey_form/questions'; //Auth_code
$route['survey/form/questions/(:any)/(:any)/(:any)'] = 'Survey_form/questions'; //pagination
$route['survey/finish/(:any)/(:any)'] = 'Survey_form/finish';
$route['survey/error/(:any)'] = 'Survey_form/error';
$route['survey/complete/(:any)/(:any)'] = 'Survey_form/thankyou';

$route['survey/form/preview/:any'] = 'Survey_form/preview';


$route['test/:any'] = 'Test_form';
$route['test/questions/(:any)'] = 'Test_form/questions';
$route['test/questions/(:any)/(:any)'] = 'Test_form/questions';
$route['test/questions/(:any)/(:any)/(:any)'] = 'Test_form/questions';
$route['test/result/(:any)/(:any)'] = 'Test_form/result';
$route['test/error/(:any)'] = 'Test_form/error';

$route['test/preview/:any'] = 'Test_form/preview';

$route['assignment/preview/:any'] = 'Assignment/preview';
$route['assingment/error/(:any)'] = 'Assignment/error';
$route['assignment/startAssignmentEntry'] = 'Assignment/startAssignmentEntry';
$route['assignment/answer_save'] = 'Assignment/answer_save';
$route['assignment/self_rating_save'] = 'Assignment/self_rating_save';
$route['assignment/document_save'] = 'Assignment/document_save';
$route['assignment/apply_finish_status'] = 'Assignment/apply_finish_status';
$route['assignment/:any'] = 'Assignment';
$route['assignment/questions/(:any)'] = 'Assignment/questions';
$route['assignment/questions/(:any)/(:any)'] = 'Assignment/questions';
$route['assignment/upload/(:any)/(:any)'] = 'Assignment/upload';
$route['assignment/finish/(:any)/(:any)'] = 'Assignment/finish';

/*$route['assignment_raters/preview/:any'] = 'Assignment_raters/preview';
$route['assignment_raters/:any'] = 'Assignment_raters';*/
$route['assignment_raters/:any/:num'] = 'Assignment_raters';
$route['assignment/rating/:any/:any/:num'] = 'Assignment_raters/rating';

$route['department/create/surveys'] = 'survey';
$route['department/create/survey/add'] = 'survey/add';
$route['department/create/survey/management'] = 'survey/management';
$route['department/create/survey/question/add/:num'] = 'survey/add_question';
$route['department/create/survey/question/edit/:num'] = 'survey/edit_question';
$route['department/create/survey/email_link'] = 'survey/email_link';
$route['department/create/survey/compose_email'] = 'survey/compose_email';
$route['department/create/survey/templates/:num'] = 'survey/survey_templates';
$route['department/create/survey/results/:num'] = 'survey/results';
$route['department/create/survey/answer/(:any)/(:any)'] = 'survey/results_answer';

$route['department/create/tests'] = 'tests';
$route['department/create/tests/management'] = 'tests/management';
$route['department/create/tests/question/add/:num'] = 'tests/add_question';
$route['department/create/tests/question/demography_add/:num'] = 'tests/demography_add';
$route['department/create/tests/question/edit/:num'] = 'tests/edit_question';
$route['department/create/tests/demography/edit/:num'] = 'tests/edit_demography_question';
$route['department/create/tests/question/demography_edit/:num'] = 'tests/demography_edit';
$route['department/create/tests/compose_email'] = 'tests/compose_email';
$route['department/create/tests/results/:num'] = 'tests/results';
$route['department/create/tests/answer/(:any)/(:any)'] = 'tests/results_answer';

$route['department/create/assignments_rubrics'] = 'assignments_rubrics';
$route['department/create/assignments_rubrics/manage'] = 'assignments_rubrics/manage';
$route['department/create/assignments_rubrics/question/add/:num'] = 'assignments_rubrics/add_question';
$route['department/create/assignments_rubrics/question/edit/:num'] = 'assignments_rubrics/edit_question';
$route['department/create/assignments_rubrics/results/:num'] = 'assignments_rubrics/results';
$route['department/create/assignments_rubrics/answer/(:any)/(:any)'] = 'assignments_rubrics/results_answer';

$route['department/create/survey/configuration/:num'] = 'survey/configuration';
$route['department/create/survey/distributions/:num'] = 'survey/distributions';
$route['department/create/survey/reports/:num'] = 'survey/reports';

$route['department/create/unit_reviews'] = 'unit_reviews';
$route['department/create/unit_reviews/manage'] = 'unit_reviews/manage';
$route['department/create/effectiveness_data'] = 'effectiveness_data';
$route['department/create/effectiveness_data/manage'] = 'effectiveness_data/manage';

$route['department/analyze'] = 'analyze';
$route['department/analyze/closed_loop'] = 'analyze/closed_loop';
$route['department/analyze/upload/document'] = 'analyze/upload_document';

$route['department/data_commons'] = 'data_commons';
$route['department/data_commons/details/:num'] = 'data_commons/details';
$route['department/data_commons/edit/:num'] = 'data_commons/edit';

$route['department/reports'] = 'reports';
$route['department/reports/feedback'] = 'reports/feedback_report';
$route['department/reports/preview_planning'] = 'reports/preview_planning_report_new';
$route['department/reports/preview_planning_new'] = 'reports/preview_planning_report';
$route['department/reports/time_tracker'] = 'reports/time_tracker_report';

$route['department/reports/assessment_template'] = 'reports/assessment_template_report';
$route['department/reports/assessment/uplode'] = 'reports/assessment_template_upload';

$route['department/reports/student_learning_outcome'] = 'reports/student_learning_outcome';
$route['department/reports/grad_student_learning_outcome'] = 'reports/grad_student_learning_outcome';

$route['department/notifications'] = 'notifications';
$route['department/tutorials'] = 'tutorials';
$route['department/suites'] = 'suites';
$route['dashboard'] = 'home/dashboard';
$route['profile'] = 'home/profile';


///////////////// Backend Controller //////////////////////

$route['admin'] = 'admin/home/index';
$route['admin/forgot_password'] = 'admin/home/forgot_password';
$route['admin/recover_password/:any'] = 'admin/home/recover_password';
/*$route['admin/census_data/createEntry'] = 'admin/census_data/createEntry';
$route['admin/census_data/(:any)'] = 'admin/census_data';
$route['admin/census_data/(:any)/add'] = 'admin/census_data/add';*/
$route['admin/profile'] = 'admin/home/profile';
$route['admin/department_reports'] = 'admin/department_metrics/department_reports';
$route['admin/department/reports/view/:any'] = 'admin/department_metrics/department_reports_view';
$route['admin/setting/configuration/manage'] = 'admin/home/manage_configuration';
$route['admin/logo'] = 'admin/Configuration/logo';
$route['admin/setting/email_templates/manage'] = 'admin/home/manage_email_templates';
$route['admin/setting/email_templates/edit']='admin/home/edit_email_templates';
$route['admin/cms/home/welcome'] = 'admin/cms/welcome_content';
/*$route['admin/sub_admins'] = 'admin/sub_admins/index';
$route['admin/sub_admins'] = 'admin/sub_admins/delete_guest';*/
$route['admin/logout'] = 'admin/home/logout';
$route['translate_uri_dashes'] = FALSE;