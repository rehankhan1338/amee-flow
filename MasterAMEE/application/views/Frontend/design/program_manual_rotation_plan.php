<div class="edit_ugbtn">
<a href="<?php echo base_url();?>department/design/action3?tab_id=3&status=<?php echo $program_status_value;?>&edit=1" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
</div>
<div class="clearfix"></div>
	<table class="table table-bordered mart10">
		
		<tr class="trbg">
			<td rowspan="2" class="rowspan"  width="50%" style="vertical-align:middle;"><b>PSLOS</b></td>
			<td colspan="<?php echo $rotation_plan_count;?>" class="recourses"><b>Academic Year</b></td>
			<td rowspan="2" class="rowspan" nowrap="nowrap" style="vertical-align:middle;"><b>Assessment Team</b></td>
		</tr>
		
		<tr class="trbg" style="text-align:center">
			<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){?>
			<td class="tdborder" nowrap="nowrap" ><?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<?php } ?>
		</tr>
		
		<?php foreach($program_learning_outcomes_data as $program_pslos){
		
			$maunal_rotation_plan_details = get_maunal_rotation_plan_details_by_plso_id_h($program_status_value,$department_id,$program_pslos->id);
			if(isset($maunal_rotation_plan_details->id) && $maunal_rotation_plan_details->id!=''){
				$manual_id = $maunal_rotation_plan_details->id;
			}else{
				$manual_id = '';
			}
			
			?>
			<tr>
				<td style="vertical-align:middle;"><h4><i><?php echo ucfirst($program_pslos->plso_prefix.': '.$program_pslos->plso_title);?></i></h4></td>
				<?php for($rpy=1;$rpy<=$rotation_plan_count;$rpy++){
					
					$academic_courses_details_arr = array();
					$academic_courses_details = get_maunal_rotation_plan_academic_details_h($manual_id,$rpy);
					if(isset($academic_courses_details) && $academic_courses_details!=''){
					
						$academic_courses_details_arr = explode(',',$academic_courses_details);
						
					}else{
					
						$academic_courses_details_arr[]='';
						
					}
				
				?>
				<td>
 				 
					<?php foreach($department_programs_align_matrix as $program_courses_details){?>
						<?php if(in_array($program_courses_details->id,$academic_courses_details_arr)){
							if($program_courses_details->course_number>0){
								$pcourseNo = ' '.$program_courses_details->course_number;
							}else{
								$pcourseNo = '';
							}
							 echo '<p style="margin:5px 0;" class="lsp5">'.$program_courses_details->course_prefix.$pcourseNo.'</p>';
						  } ?> 
					<?php } ?>
 				
				</td>
				<?php } ?>
				<td style="vertical-align:middle">
					<?php if(isset($maunal_rotation_plan_details->team_id) && $maunal_rotation_plan_details->team_id>0){echo 'Team '.$maunal_rotation_plan_details->team_id;}?>
				</td>
			</tr>
		<?php } ?>		
		
	</table>
	<?php foreach($team_members_detail_group_by as $team_members_detail){
	
		$member_names_detail = get_member_names_result_by_id($team_members_detail->team_id);
		
		?>
	<h4 class="mar155"><?php echo '<b>Team '.$team_members_detail->team_id.'</b>';?>: &nbsp;&nbsp;<?php 
	$team_members_name='';
	foreach($member_names_detail as $members_name){
		if(isset($members_name->name)&& $members_name->name!=''){ $team_members_name.=$members_name->name.', ';}
	}
	echo substr(trim($team_members_name), 0, -1);
	?></h4>
	<?php } ?>