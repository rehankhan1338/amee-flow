<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-08-15 05:16:00 --> Severity: Warning --> A non-numeric value encountered /home2/mssracom/public_html/domains/assessmentmadeeasycom/demo/application/models/Reports_mdl.php 143
ERROR - 2021-08-15 05:27:39 --> 404 Page Not Found: Department/images
ERROR - 2021-08-15 05:30:14 --> Query error: Table 'mssracom_amee_demo.dev_department_pslos' doesn't exist - Invalid query: SELECT *
FROM `demo_assignment_courses`
WHERE `status` = '0'
AND  `pslo_number` in(select id from dev_department_pslos where pslos_status="0")
GROUP BY `pslo_number`
ERROR - 2021-08-15 05:30:15 --> 404 Page Not Found: Faviconico/index
