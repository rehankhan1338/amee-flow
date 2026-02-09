<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<th width="40%" rowspan="2" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;"><b>PSLOS</b></td>
		<td colspan="<?php echo $rotation_plan_count;?>" style="padding: 10px; text-align:center; background:#485b79; color:#fff; vertical-align:middle;border:1px solid #ddd;"><b>Academic Year</b></td>
		<td width="10%" rowspan="2" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><b>Assessment Team</b></td>
	</tr>
	
	<tr class="trbg" style="text-align:center">
		<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){?>
		<td style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" nowrap="nowrap" ><?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
		<?php } ?>
	</tr>
		
		<?php foreach($department_pslos_undergraduate as $undergraduate_pslos){
		
			$maunal_rotation_plan_details = get_maunal_rotation_plan_details_by_plso_id_h($undergraduate_status_value,$department_id,$undergraduate_pslos->id);
			if(isset($maunal_rotation_plan_details->id) && $maunal_rotation_plan_details->id!=''){
				$manual_id = $maunal_rotation_plan_details->id;
			}else{
				$manual_id = '';
			}
			
			?>
			<tr>
				<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;"><?php echo ucfirst($undergraduate_pslos->plso_prefix.': '.$undergraduate_pslos->plso_title);?></td>
				<?php for($rpy=1;$rpy<=$rotation_plan_count;$rpy++){
					
					$academic_courses_details_arr = array();
					$academic_courses_details = get_maunal_rotation_plan_academic_details_h($manual_id,$rpy);
					if(isset($academic_courses_details) && $academic_courses_details!=''){
					
						$academic_courses_details_arr = explode(',',$academic_courses_details);
						
					}else{
					
						$academic_courses_details_arr[]='';
						
					}
				
				?>
				<td style=" padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd; text-align:center; ">
 				 
					<?php foreach($department_courses_result_undergraduate as $undergraduate_courses_details){?>
						<?php if(in_array($undergraduate_courses_details->id,$academic_courses_details_arr)){
						 echo '<p style="margin:5px 0;" class="lsp5">'.$undergraduate_courses_details->course_prefix.' '.$undergraduate_courses_details->course_number.'</p>';
						  } ?> 
					<?php } ?>
 				
				</td>
				<?php } ?>
				<td style="  padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd; text-align:center; border-right:1px solid #ddd;">
					<?php if(isset($maunal_rotation_plan_details->team_id) && $maunal_rotation_plan_details->team_id>0){echo 'Team '.$maunal_rotation_plan_details->team_id;}?>
				</td>
			</tr>
		<?php } ?>		
		
	</table> 