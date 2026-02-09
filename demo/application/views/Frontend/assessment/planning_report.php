<?php
if(isset($_GET['s1']) && $_GET['s1']!='' && $_GET['s1']==1){include(APPPATH.'views/Frontend/assessment/envision.php');}
if(isset($_GET['s2']) && $_GET['s2']!='' && $_GET['s2']==1){include(APPPATH.'views/Frontend/assessment/coordinate.php');}
if(isset($_GET['s3']) && $_GET['s3']!='' && $_GET['s3']==1){include(APPPATH.'views/Frontend/assessment/design.php');}
if(isset($_GET['s4']) && $_GET['s4']!='' && $_GET['s4']==1){include(APPPATH.'views/Frontend/assessment/reflect.php');}
?>