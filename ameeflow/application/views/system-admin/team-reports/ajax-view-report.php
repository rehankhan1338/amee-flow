<?php 
if($reportFor==1){
    include(APPPATH.'views/Frontend/reports/sampling_plan/result-sec.php'); 
}else if($reportFor==2){
    include(APPPATH.'views/Frontend/reports/loads_report/result-sec.php'); 
}else if($reportFor==3){
    include(APPPATH.'views/Frontend/reports/general_reports/result-sec.php'); 
}
?>