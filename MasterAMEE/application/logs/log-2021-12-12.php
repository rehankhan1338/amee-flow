<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2021-12-12 08:59:15 --> Query error: Table 'mssracom_amee_demo.dev_department_pslos' doesn't exist - Invalid query: SELECT *
FROM `demo_assignment_courses`
WHERE `status` = '0'
AND  `pslo_number` in(select id from dev_department_pslos where pslos_status="0")
GROUP BY `pslo_number`
ERROR - 2021-12-12 09:11:22 --> Query error: Table 'mssracom_amee_demo.dev_department_pslos' doesn't exist - Invalid query: SELECT *
FROM `demo_assignment_courses`
WHERE `status` = '0'
AND  `pslo_number` in(select id from dev_department_pslos where pslos_status="1")
GROUP BY `pslo_number`
