<div class="col-md-12">
	<div class="bdr">
		<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">4. REFLECT : ASSESSMENT Schedule</h2>
		<h4>4.1 Overview</h4>
		<ul class="timeline">
			<?php if(isset($checklist_detail->reflect_action1_overview) && $checklist_detail->reflect_action1_overview!=''){?>
			<li>
				<label class="assReportPage_title">Reflect Review</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->reflect_action1_overview;?></div>
				</div>
			</li>
			<?php } ?>
		</ul>
		<h4>4.2 Assessment Schedule</h4>
		<?php if(count($department_pslos_undergraduate)>0 && count($department_courses_result_undergraduate)>0){?>
			<h5 class="ctrTitle">Undergraduate Assessment Schedule</h5>
 		<?php 
			$ass_status_value = $undergraduate_status_value;
			$ass_rotation_plan_status = $undergraduate_rotation_plan_status;
			$coursesResult = $department_courses_result_undergraduate;
			$pslosResult = $department_pslos_undergraduate;
			include(APPPATH.'views/Frontend/assessment/common_assessment_plan.php');
		} ?>	
		
		<?php if(count($department_pslos_graduate)>0 && count($department_courses_result_graduate)>0){?>
			<h5 class="ctrTitle">Graduate Assessment Schedule</h5>
		<?php 
			$ass_status_value = $graduate_status_value;
			$ass_rotation_plan_status = $graduate_rotation_plan_status;
			$coursesResult = $department_courses_result_graduate;
			$pslosResult = $department_pslos_graduate;
			include(APPPATH.'views/Frontend/assessment/common_assessment_plan.php');
		} ?>
		
		<?php if(count($program_learning_outcomes_data)>0 && count($department_programs_align_matrix)>0){?>
			<h5 class="ctrTitle">Program Assessment Schedule</h5>
		<?php 
			$ass_status_value = $program_status_value;
			$ass_rotation_plan_status = $program_rotation_plan_status;
			$coursesResult = $department_programs_align_matrix;
			$pslosResult = $program_learning_outcomes_data;
			include(APPPATH.'views/Frontend/assessment/common_assessment_plan.php');
		} ?>
	</div>
</div>