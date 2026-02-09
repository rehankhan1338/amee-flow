<table class="table table-bordered"> 
	<thead>
		<tr style="background-color:#f5f5f5;">
			<th style="vertical-align:middle;" rowspan="2">Program Student Learning Outcomes (PSLO)</th>
			<th style="text-align:center;" colspan="<?php echo $rotation_plan_count;?>">Academic Year</th>
			<th style="vertical-align:middle;" rowspan="2">Assessment Team</th>
		</tr>
		<tr style="background-color:#f5f5f5;">
			<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){?>
			<th nowrap="nowrap" style="text-align:center;"><?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($pslosResult as $resPlso){
			
			$ftrRotationPlan = filter_array_chk_two($deptCommonRotationPlansData,$resPlso['id'],'plso_id',$rotation_plan_status,'rotation_plan_status');
			if(count($ftrRotationPlan)>0 && isset($ftrRotationPlan[0]['id']) && $ftrRotationPlan[0]['id']!=''){
				$automatic_id = $ftrRotationPlan[0]['id'];
			}else{
				$automatic_id = '';
			}
		
		?>
			<tr>
				<td style="vertical-align:middle;"><?php echo $resPlso['plso_prefix'];//.': '.$resPlso['plso_title'];?></td>
				<?php for($rpy=1;$rpy<=$rotation_plan_count;$rpy++){?>
				<td>
					<?php 
						$ftrRotationCourse = filter_array_chk_two($deptCommonRotationPlanCoursesData,$automatic_id,'manual_id',$rpy,'academic_year');
						if(isset($ftrRotationCourse[0]['course_id']) && $ftrRotationCourse[0]['course_id']!=''){
							$academic_courses_details_arr = explode(',',$ftrRotationCourse[0]['course_id']);
							foreach($academic_courses_details_arr as $rcourse){
								$res = filter_array_chk($coursesResult,$rcourse,'id');
								if(count($res)>0){
									echo '<label class="rtptdp">'.$res[0]['course_prefix']; 
									if($res[0]['course_number']>0){echo ' '.$res[0]['course_number'];}
									echo '</label>';
								}
							}
						}									 
					?>
				</td>
				<?php } ?>
				<td style="vertical-align:middle;"><?php if(count($ftrRotationPlan)>0 && isset($ftrRotationPlan[0]['team_id']) && $ftrRotationPlan[0]['team_id']!=''){echo 'Team '.$ftrRotationPlan[0]['team_id'];}else{ echo '&ndash;';}?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>