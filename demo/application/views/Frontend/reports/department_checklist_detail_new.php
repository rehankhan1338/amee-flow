<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#export_dept_checklist").click(function(event) {
        	$("#page_dept_checklist").wordExport('planning_report');
      	});
    });
</script>
<div class="pull-right">
	<a class="btn btn-primary" id="export_dept_checklist" style="padding:4px 15px; margin-right:5px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:4px 15px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>
<?php
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
?>
<style>
#page_dept_checklist ul, #page_dept_checklist ol{ list-style-position:inside;}
#page_dept_checklist ul li, #page_dept_checklist ol li{padding:2px 0px 2px 15px;}
#page_dept_checklist .secDets h3{ font-size:20px; margin:12px 0;}
</style>
<div class="clearfix"></div>
<div id="page_dept_checklist">
	 
	<div style="text-align: center;">
	  <h2 style="color: #485b79;margin: 10px 0; font-style:italic; text-transform:uppercase;"><b><?php echo $dept_session_details->department_name;?></b></h2>    
	  <h3 style=" margin:10px 0;color:#485b79; font-style:italic;"><b><?php if(isset($university_details->university_name)&& $university_details->university_name!=''){echo str_replace('College','',$university_details->university_name); }else{ echo 'DEMO College';} ?></b></h3>
	  <h6 style="font-size: 16px; margin:5px 0;color:#333;"><b>Assessment Planning Report</b></h6>
	  <h6 style="font-size: 16px; margin:10px 0;color:#333;"><b>Prepared by <?php echo $dept_session_details->first_name.' '.$dept_session_details->last_name;?></b></h6>
	</div>	     
    <?php if(isset($checklist_detail->envision_action1_overview) && $checklist_detail->envision_action1_overview!=''){?> 
    <div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->envision_action1_overview;?>
		</div>
	</div> 
	<?php } ?>
	<?php if(isset($checklist_detail->mission_statement) && $checklist_detail->mission_statement!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;"> Mission Statement</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->mission_statement;?>
		</div>
	</div>   
 	<?php } ?>
	<?php if(isset($checklist_detail->vision_statement) && $checklist_detail->vision_statement!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79;font-weight:600;"> Vision Statement </h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->vision_statement;?>
		</div>
	</div>	
	<?php } ?>
	<?php if(isset($checklist_detail->program_goals) && $checklist_detail->program_goals!=''){?> 
 	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;"> Department/Program Goals </h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->program_goals;?>
		</div>
	</div>
	<?php } ?>
	<?php if(isset($checklist_detail->envision_action2_overview) && $checklist_detail->envision_action2_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->envision_action2_overview;?>
		</div>
	</div>
 	<?php } ?>
	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;">Program Student Learning Objectives</h3>
		<?php if(count($department_pslos_undergraduate)>0){ ?>	
 		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Program Student Learning Outcomes:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
			
 				<thead>
					<tr>
						<th width="70%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">UG SLOs </th>
						<th width="30%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Type of SLO </th>
					</tr>
				</thead>
 				<tbody>	
				<?php $j=1; foreach($department_pslos_undergraduate as $undergraduate){?>        
					<?php 				
						$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$undergraduate['id'],'department_pslos_id');
						$core_competency_details_arr = array();
						if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
							$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);									
						}				
					?>
					
					<tr>
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
							<?php if(isset($undergraduate['plso_title']) && $undergraduate['plso_title']!=''){echo ucfirst($undergraduate['plso_prefix'].': '.$undergraduate['plso_title']);}?>
							</td>
								
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
							<?php if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = 'CC'.$cc;
											}
										}
									  ?><h5 class="ccshow"><?php echo implode(', ',$imCoreComArr);?> </h5>
									<?php } ?>
						</td>
					</tr>			
				<?php $j++;} ?>	      
				</tbody>
			
		 
			
			</table>
		</div>
		<?php }  ?>	
			
			<?php if(count($department_pslos_graduate)>0){ ?>		
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Program Student Learning Outcomes:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
			
			
				<thead>
					<tr>
						<th width="70%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">UG SLOs </th>
						<th width="30%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Type of SLO </th>
					</tr>
				</thead>
				
				<tbody>	
				<?php $j=1; foreach($department_pslos_graduate as $graduate_courses){
							
								$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$graduate_courses['id'],'department_pslos_id');
								$core_competency_details_arr = array();
								if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
 									$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);									
								}	?>        
				 
					
					<tr>
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
							<?php if(isset($graduate_courses['plso_title']) && $graduate_courses['plso_title']!=''){echo ucfirst($graduate_courses['plso_prefix'].': '.$graduate_courses['plso_title']);}?>
							</td>
								
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
							<?php if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = 'CC'.$cc;
											}
										}
									?>
									<h5 class="ccshow"><?php echo implode(', ',$imCoreComArr);?></h5>	
									<?php } ?>
						</td>
					</tr>			
				<?php $j++;} ?>	      
				</tbody>
			
			 
			
			</table>
		</div>
		<?php }  ?>	
		
		
		<?php if(count($program_learning_outcomes_data)>0){ ?>		
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Program Learning Outcomes:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
			
			
				<thead>
					<tr>
						<th width="70%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">UG SLOs </th>
						<th width="30%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Type of SLO </th>
					</tr>
				</thead>
				
				<tbody>	
				<?php $j=1;foreach($program_learning_outcomes_data as $plo){
							
								$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$plo['id'],'department_pslos_id');
								$core_competency_details_arr = array();
								if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
 									$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);
									sort($core_competency_details_arr);									
								}?>        
				 
					
					<tr>
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
							<?php if(isset($plo['plso_title']) && $plo['plso_title']!=''){echo ucfirst($plo['plso_prefix'].': '.$plo['plso_title']);}?>
							</td>
								
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
							<?php if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = 'CC'.$cc;
											}
										}
									?>
									<h5 class="ccshow"><?php echo implode(', ',$imCoreComArr);?></h5>	
									<?php } ?>
						</td>
					</tr>			
				<?php $j++;} ?>	      
				</tbody>
			
			 
			
			</table>
		</div>
		<?php }  ?>
		
	</div>
	
	<?php if(isset($checklist_detail->coordinate_action1_overview) && $checklist_detail->coordinate_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->coordinate_action1_overview;?>
		</div>
	</div>
	<?php } ?>		
	
	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;">Course Alignment Matrix</h3>
		<p style="background-color: #eaf4f6;border: 1px solid #dedede;margin: 15px 0;border-radius: 3px;padding: 10px;color: #333;">
			<strong>Instructions:</strong> I = Introduce, E=Emphasizing, D = Developing, M = Mastering, P=Practicing
		</p>
 		<?php if(count($department_courses_result_undergraduate)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Alignment Matrix for Undergraduate Program</h6>
				 <?php
					$alignmentAction = 0;
					$coursesResult = $department_courses_result_undergraduate;
					$pslosResult = $department_pslos_undergraduate;
					include(APPPATH.'views/Frontend/reports/common_alignment_matrix.php');
				?> 
			</div>
		<?php } ?>
		
		<?php if(count($department_courses_result_graduate)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Alignment Matrix for Graduate Program</h6>
				 <?php
					$alignmentAction = 1;
					$coursesResult = $department_courses_result_graduate;
					$pslosResult = $department_pslos_graduate;
					include(APPPATH.'views/Frontend/reports/common_alignment_matrix.php');
				?> 
			</div>
		<?php } ?>
		
		<?php if(count($department_programs_align_matrix)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Program Alignment Matrix</h6>
				 <?php
					$alignmentAction = 2;
					$coursesResult = $department_programs_align_matrix;
					$pslosResult = $program_learning_outcomes_data;
					include(APPPATH.'views/Frontend/reports/common_alignment_matrix.php');
				?> 
			</div>
		<?php } ?>
		
				
		 
		
	</div>
	
	<?php if(isset($checklist_detail->design_action1_overview) && $checklist_detail->design_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->design_action1_overview;?>
		</div>
	</div>
	<?php } ?>	
	
	<div style="margin:10px 0;">
		<h3 style="color: #485b79;font-weight:600;">Rotation Schedule</h3>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Team Members</h6> 
			
			
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
			 
			<?php
			foreach($commonTeam as $cTeam){?>
			<h6 style="font-size: 16px; margin:15px 0;color:#333; font-weight:500; margin-left:10px;"><strong>Team <?php echo $cTeam;?>: &nbsp;&nbsp; </strong>
						
						<?php 
						$teamNameArr = array();
						$fTeam = filter_array_chk($deptTeamMembersData,$cTeam,'team_id');
						foreach($fTeam as $team){?>
 							<?php $teamNameArr[] = ucwords($team['name']);?>
						<?php } echo  implode(', ',$teamNameArr); ?>
						
				</h6>
			<?php } ?>
			 <?php }
			
		?>
		
		<?php } ?>
		
		
		
		</div>
		
		<?php if(count($department_pslos_undergraduate)>0 && count($department_courses_result_undergraduate)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Rotation Schedule</h6>
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
			include(APPPATH.'views/Frontend/reports/common_rotation_plan.php');
		 ?>	
		</div>
		<?php } } ?>
		
		<?php if(count($department_pslos_graduate)>0 && count($department_courses_result_graduate)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Rotation Schedule</h6>
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
			include(APPPATH.'views/Frontend/reports/common_rotation_plan.php');
		 ?>	
		</div>
		<?php } } ?>
		
		<?php if(count($program_learning_outcomes_data)>0 && count($department_programs_align_matrix)>0){
		if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){		
		?>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Program Rotation Schedule</h6>
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
			include(APPPATH.'views/Frontend/reports/common_rotation_plan.php');
		 ?>	
		</div>
		<?php } } ?>
		
		 
	</div>
	
	<?php if(isset($checklist_detail->reflect_action1_overview) && $checklist_detail->reflect_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->reflect_action1_overview;?>
		</div>
	</div>
	<?php } ?>
	
	<div style="margin:10px 0;">
		<h3 style="color: #485b79;font-weight:600;">Assessment Schedule</h3>
		
		<?php if(count($department_pslos_undergraduate)>0 && count($department_courses_result_undergraduate)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Assessment Schedule</h6>
				<?php 
					$ass_status_value = $undergraduate_status_value;
					$ass_rotation_plan_status = $undergraduate_rotation_plan_status;
					$coursesResult = $department_courses_result_undergraduate;
					$pslosResult = $department_pslos_undergraduate;
					include(APPPATH.'views/Frontend/reports/common_assessment_plan.php');
				?>
			</div>	
		<?php } ?>
		
		<?php if(count($department_pslos_graduate)>0 && count($department_courses_result_graduate)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Assessment Schedule</h6>
				<?php 
					$ass_status_value = $graduate_status_value;
					$ass_rotation_plan_status = $graduate_rotation_plan_status;
					$coursesResult = $department_courses_result_graduate;
					$pslosResult = $department_pslos_graduate;
					include(APPPATH.'views/Frontend/reports/common_assessment_plan.php');
				?>
			</div>	
		<?php } ?>
		
		<?php if(count($program_learning_outcomes_data)>0 && count($department_programs_align_matrix)>0){?>
			<div style="font-size: 16px;line-height: 22px;">
				<h6 style="font-size: 16px; margin:15px 0;color:#333;">Program Assessment Schedule</h6>
				<?php 
					$ass_status_value = $program_status_value;
					$ass_rotation_plan_status = $program_rotation_plan_status;
					$coursesResult = $department_programs_align_matrix;
					$pslosResult = $program_learning_outcomes_data;
					include(APPPATH.'views/Frontend/reports/common_assessment_plan.php');
				?>
			</div>	
		<?php } ?>
		
		
		
		
	 </div>
	
	
</div>