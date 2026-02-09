<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php if(isset($title) && $title!=''){echo $title; }else{echo 'Assessment Report';}?></title>
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/custom.css" type="text/css" />
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<style>
.contentwrapper{padding:0 10px 20px}
.timeline{position:relative;/*margin:0 0 30px 0;*/padding:0;list-style:none}
.timeline:before{content:'';position:absolute;top:0;bottom:0;width:4px;background:#ddd;left:31px;margin:0;border-radius:2px}
.timeline>li{position:relative;margin-right:10px;margin-bottom:15px}
.timeline>li:before,.timeline>li:after{content:" ";display:table}
.timeline>li:after{clear:both}
.timeline>li>.timeline-item{-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);border-radius:3px;margin-top:0;background:#fff;color:#444;margin-left:60px;margin-right:15px;padding:0;position:relative}
.timeline>li>.timeline-item>.time{color:#999;float:right;padding:10px;font-size:12px}
.timeline>li>.timeline-item>.timeline-header{margin:0;color:#333;border-bottom:1px solid #f4f4f4;padding:10px 15px;font-size:15px;}
.timeline>li>.timeline-item>.timeline-header>a{font-weight:600}
.timeline>li>.timeline-item>.timeline-body,.timeline>li>.timeline-item>.timeline-footer{padding:10px}
.timeline>li>.fa,.timeline>li>.glyphicon,.timeline>li>.ion{width:30px;height:30px;font-size:15px;line-height:30px;position:absolute;color:#666;background:#d2d6de;border-radius:50%;text-align:center;left:18px;top:0}
.timeline>.time-label>span{font-weight:600;padding:5px;display:inline-block;background-color:#fff;border-radius:4px}
.timeline-inverse>li>.timeline-item{background:#f0f0f0;border:1px solid #ddd;-webkit-box-shadow:none;box-shadow:none}
.timeline-inverse>li>.timeline-item>.timeline-header{border-bottom-color:#ddd}

.assReportPage{margin:5px 0;}
.assReportPage_title { background: #485b79;padding: 5px 20px; font-size: 15px;  color: #fff; border-radius: 5px; font-weight: 600;}
.assReportPage .timeline > li > .timeline-item {-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);box-shadow: 0 1px 1px #f5f5f5;border-radius: 3px;margin-top: 15px;background: #f5f5f5;color: #333;margin-left: 60px;margin-right: 15px;padding: 0;position: relative;}
.assReportPage .timeline-header p{margin:0px;line-height:25px; padding-bottom:5px; padding-top:5px;} 
.assReportPage .timeline-header ul, .assReportPage .timeline-header ol{list-style-position: inside;}
.assReportPage .timeline-header ul li, .assReportPage .timeline-header ol li{ padding:5px 15px;}
.assReportPage .timeline-header b, .assReportPage .timeline-header strong{ font-weight:600;}

#myDeptAnlaysisModel .modal-body{ padding:10px 15px 15px 15px;} 
#myDeptAnlaysisModel .modal-dialog { max-width:650px; width:650px;}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ padding:6px;}
.w100{width:100%}
.mleft{ margin-left:50px;}

.bdr{border: 1px dashed #777;margin: 15px 20px;padding: 8px 15px;background:#fff;}
.bdr h4{ font-size:20px;  margin-bottom:15px; font-weight:600;}

.assCoreCom {
    padding-left: 30px;
    padding-top: 7px;
    color: #555;
    font-weight: 600;
}
.ctrTitle{ text-align: center;
    font-weight: 600;
    font-size: 18px;
    margin: 15px 0;}
.contentwrapper .rtptdp { margin:0; line-height:25px;}
.reportMainPage:before{ content: '';
    position: absolute;
    width: 27%;
    height: 1px;
    background-color: #fff;
    right: 36px;
    top: 90%;
    transform: rotate(-6deg);}
.reportMainPage:after{     content: '';
    position: absolute;
    width: 27%;
    height: 1px;
    background-color: #fff;
    left: 34px;
    top: 10%;
    transform: rotate(-6deg)}
.reportMainPage{ margin: 10px 20px;padding: 4% 0;background:#485b79; text-align:center; color:#fff;}
.reportMainPage h2{text-transform:uppercase; font-weight:600; padding:10px 0;}
.reportMainPage h3,.reportMainPage h4{ margin:0; padding:8px 0;}
.fiftyPerli{ width:49%; float:left;}
</style>
</head>
<body style="background:#f5f5f5;">
	<div class="bodywrapper">
		<div class="centercontent marleft0">
			<div id="contentwrapper" class="contentwrapper">
				<div class="box assReportPage">
				
					<div class="col-md-12">
						<div class="reportMainPage">
							<h2>Assessment / Evaluation Planning Report</h2>
							<h3><?php echo $this->config->item('project_name_page_first');?></h3>
							<h3><?php echo 'Department of '.$dept_detail->department_name;?></h3>
							<h4>Prepared by <?php echo $dept_detail->first_name.' '.$dept_detail->last_name;?></h4>
						</div>
					</div>

					<?php
						if((isset($_GET['s1']) && $_GET['s1']!='' && $_GET['s1']==1) || (isset($_GET['s2']) && $_GET['s2']!='' && $_GET['s2']==1) || (isset($_GET['s3']) && $_GET['s3']!='' && $_GET['s3']==1) || (isset($_GET['s4']) && $_GET['s4']!='' && $_GET['s4']==1)){
						
							$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
							$graduate_status_value = $this->config->item('con_graduate_status_value');
							$program_status_value = $this->config->item('con_program_status_value');
							
							$department_pslos_undergraduate = filter_array_chk($deptLearningOutcomesData,'0','pslos_status');
							$department_pslos_graduate = filter_array_chk($deptLearningOutcomesData,'1','pslos_status');
							$program_learning_outcomes_data = filter_array_chk($deptLearningOutcomesData,'2','pslos_status');
							
							$department_courses_result_undergraduate = filter_array_chk($deptAligementCoursesData,'0','course_status');
							$department_courses_result_graduate = filter_array_chk($deptAligementCoursesData,'1','course_status');
							$department_programs_align_matrix = filter_array_chk($deptAligementCoursesData,'2','course_status');
							
							$rotation_plan_count = $this->config->item('rotation_year_plans');
							$rotation_plan_start_year = $checklist_detail->rotation_plan_year;
							$undergraduate_rotation_plan_status = $checklist_detail->undergraduate_rotation_plan_status;
							$graduate_rotation_plan_status = $checklist_detail->graduate_rotation_plan_status;
							$program_rotation_plan_status = $checklist_detail->program_rotation_plan_status;
							
							include(APPPATH.'views/Frontend/assessment/planning_report.php');
						}
						if(isset($_GET['ar']) && $_GET['ar']!=''){include(APPPATH.'views/Frontend/assessment/analysis_reporting.php');}
						if(isset($_GET['ctl']) && $_GET['ctl']!=''){include(APPPATH.'views/Frontend/assessment/closing_loop.php');}
						if(isset($_GET['lm']) && $_GET['lm']!=''){include(APPPATH.'views/Frontend/assessment/logic_model.php');}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>