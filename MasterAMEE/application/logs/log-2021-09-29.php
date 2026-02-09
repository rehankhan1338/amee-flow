<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-09-29 04:09:43 --> 404 Page Not Found: Faviconico/index
ERROR - 2021-09-29 15:37:01 --> 404 Page Not Found: Department/images
ERROR - 2021-09-29 15:37:06 --> 404 Page Not Found: Department/images
ERROR - 2021-09-29 15:42:15 --> Query error: Table 'mssracom_amee_demo.dev_department_pslos' doesn't exist - Invalid query: SELECT *
FROM `demo_assignment_courses`
WHERE `status` = '0'
AND  `pslo_number` in(select id from dev_department_pslos where pslos_status="0")
GROUP BY `pslo_number`
ERROR - 2021-09-29 15:42:15 --> 404 Page Not Found: Faviconico/index
