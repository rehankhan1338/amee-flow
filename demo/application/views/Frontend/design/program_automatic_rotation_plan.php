<div class="clearfix"></div>
 <form method="post" action="<?php echo base_url();?>design/save_automatic_rotation_plan">
	<input type="hidden" name="hrotation_plan_status" id="hrotation_plan_status" value="<?php echo $program_status_value;?>" />
	<table class="table table-bordered mart10">
		
		<tr class="trbg">
			<td rowspan="2" class="rowspan" style="vertical-align:middle;" width="50%"><b>PLOs<?php echo count($department_programs_align_matrix);?></b></td>
			<td colspan="<?php echo $rotation_plan_count;?>" class="recourses"><b>Academic Year</b></td>
			<td rowspan="2" class="rowspan" nowrap="nowrap" style="vertical-align:middle;"><b>Assessment Team</b></td>
		</tr>
		
		<tr class="trbg" style="text-align:center">
			<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){?>
			<td class="tdborder" nowrap="nowrap" ><?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<?php } ?>
		</tr>
		
		<?php foreach($program_learning_outcomes_data as $plo){
		
			$automatic_rotation_plan_details = get_automatic_rotation_plan_details_by_plso_id_h($program_status_value,$department_id,$plo->id);
			if(isset($automatic_rotation_plan_details->id) && $automatic_rotation_plan_details->id!=''){
				$automatic_id = $automatic_rotation_plan_details->id;
			}else{
				$automatic_id = '';
			}
			
			?>
			<tr>
				<td style="vertical-align:middle;">
				<input type="hidden" name="pslos_id[]" id="pslos_id[]" value="<?php echo $plo->id;?>" />
				<h4><i><?php echo ucfirst($plo->plso_prefix.': '.$plo->plso_title);?></i></h4></td>
				<?php for($rpy=1;$rpy<=$rotation_plan_count;$rpy++){					
					$academic_courses_details_arr = array();
					$academic_courses_details = get_automatic_rotation_plan_academic_details_h($automatic_id,$rpy);
					if(isset($academic_courses_details) && $academic_courses_details!=''){					
						$academic_courses_details_arr = explode(',',$academic_courses_details);						
					}else{					
						$academic_courses_details_arr = array();				
					}				
				?>
				<td>
 				  
					<?php  //print_r($academic_courses_details_arr);
					foreach($department_programs_align_matrix as $program_courses){?>
						<?php if(in_array($program_courses->id,$academic_courses_details_arr)){
						 echo '<p style="margin:5px 0;" class="lsp5">'.$program_courses->course_prefix.'</p>';
						  } ?> 
					<?php }?>
 				
				</td>
				<?php } ?>
				<td style="vertical-align:middle">
					
					<select class="form-control" name="team_id<?php echo $plo->id;?>" id="team_id<?php echo $plo->id;?>">
						<option value="">Select...</option>
					<?php foreach($team_members_detail_group_by as $team_members_detail){?>
						<option value="<?php echo $team_members_detail->team_id;?>" <?php if(isset($automatic_rotation_plan_details->team_id) && $automatic_rotation_plan_details->team_id==$team_members_detail->team_id){?> selected="selected" <?php } ?> ><?php echo 'Team '.$team_members_detail->team_id;?></option>
					<?php } ?>
					</select>
					
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
	
	<div>
		<input type="submit" name="save_automatic_rotation_plan" id="save_automatic_rotation_plan" value="Save & Update" class="btn btn-primary" />
	</div>
	
</form>