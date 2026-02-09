<div class="col-md-12">
	<div class="bdr">
		<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">3. DESIGN : Team Rotation Schedule</h2>
		<h4>3.1 Overview</h4>
		<ul class="timeline">
			<?php if(isset($checklist_detail->design_action1_overview) && $checklist_detail->design_action1_overview!=''){?>
			<li>
				<label class="assReportPage_title">Design Review</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->design_action1_overview;?></div>
				</div>
			</li>
			<?php } ?>
		</ul>
		<h4>3.2 Team Members</h4>
		<ul class="timeline">
		<li>
				<label class="assReportPage_title"><?php echo 'Teams';?></label>
					<div class="timeline-item">
					<div class="timeline-header">
		<?php if(count($deptTeamMembersData)>0){
		
			$commonTeam = array();
			foreach($deptTeamMembersData as $team){
				if(!in_array($team['team_id'],$commonTeam)){
					$commonTeam[] = $team['team_id'];
				}			
				sort($commonTeam);
			}
			
			if(count($commonTeam)>0){
			?>
			<ul>
			<?php
			foreach($commonTeam as $cTeam){?>
			<li><strong>Team <?php echo $cTeam;?> &mdash; </strong>
						
						<?php 
						$teamNameArr = array();
						$fTeam = filter_array_chk($deptTeamMembersData,$cTeam,'team_id');
						foreach($fTeam as $team){?>
 							<?php $teamNameArr[] = ucwords($team['name']);?>
						<?php } echo  implode(', ',$teamNameArr); ?>
						
				</li>	
			<?php } ?>
			</ul><?php }
			
		?>
		
		<?php } ?>
		</div>
				</div>
			</li>
		</ul>
		<h4>3.3 Rotation Schedule</h4>
		<?php if(count($department_pslos_undergraduate)>0 && count($department_courses_result_undergraduate)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<h5 class="ctrTitle">Undergraduate Rotation Schedule</h5>
		<?php
			$rotation_plan_status = $undergraduate_status_value;
			$coursesResult = $department_courses_result_undergraduate;
			$pslosResult = $department_pslos_undergraduate;
			
			if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==1){				
				$deptCommonRotationPlansData = $deptRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptRotationPlanCoursesData;			 
			}else{ 
				$deptCommonRotationPlansData = $deptMaunalRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptManualRotationPlanCoursesData;
			}			
			include(APPPATH.'views/Frontend/assessment/common_rotation_plan.php');
		} } ?>	
		
		
		<?php if(count($department_pslos_graduate)>0 && count($department_courses_result_graduate)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<h5 class="ctrTitle">Graduate Rotation Schedule</h5>
		<?php
			$rotation_plan_status = $graduate_status_value;
			$coursesResult = $department_courses_result_graduate;
			$pslosResult = $department_pslos_graduate;
			
			if(isset($graduate_rotation_plan_status) && $graduate_rotation_plan_status==1){
				$deptCommonRotationPlansData = $deptRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptRotationPlanCoursesData;			 
			}else{ 
				$deptCommonRotationPlansData = $deptMaunalRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptManualRotationPlanCoursesData;
			}			
			include(APPPATH.'views/Frontend/assessment/common_rotation_plan.php');
		} } ?>
		
		<?php if(count($program_learning_outcomes_data)>0 && count($department_programs_align_matrix)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<h5 class="ctrTitle">Program Rotation Schedule</h5>
		<?php
			$rotation_plan_status = $program_status_value;
			$coursesResult = $department_programs_align_matrix;
			$pslosResult = $program_learning_outcomes_data;
			
			if(isset($program_rotation_plan_status) && $program_rotation_plan_status==1){
				$deptCommonRotationPlansData = $deptRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptRotationPlanCoursesData;			 
			}else{ 
				$deptCommonRotationPlansData = $deptMaunalRotationPlansData;
				$deptCommonRotationPlanCoursesData = $deptManualRotationPlanCoursesData;
			}			
			include(APPPATH.'views/Frontend/assessment/common_rotation_plan.php');
		} } ?>	
	</div>
</div>