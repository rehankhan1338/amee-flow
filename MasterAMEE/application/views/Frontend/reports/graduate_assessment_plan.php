<table width="100%" cellpadding="0" cellspacing="0">
	
	<tr>
		<th nowrap="nowrap" style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Time Period</th>
		<th style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Learning Outcome</th>
		<th style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Measures to be used </th>
		<th style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Target Audience? </th>
		<th style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Benchmarks</th>
		<th style="padding: 10px; background:#485b79; color:#f6e4a5; vertical-align:middle; text-align:left;border:1px solid #ddd;">Sample Size</th>
	</tr>
	
	
	<tr>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">Year</th>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">What is to be assessed?</th>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">Kind of direct or indirect measures to be used </th>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">Courses to be assessed </th>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">What results would indicate success? What is the target? </th>
		<th style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border-left:1px solid #ddd;border-right:1px solid #ddd;border-bottom:1px solid #ddd;"># of Respondents Targeted</th>
	</tr>
	
	
	
	<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){
	
		$academic_year = $rpy+1;
		
		$benchmark_tabuler_details = get_benchmark_tabuler_details_h($department_id,$academic_year,$graduate_status_value);
		
		?>
		
		<tr>
			<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">
			<?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">
				<?php
 					$plsos_details_data = get_plsos_details_from_year_id_h($department_id,$graduate_status_value,$academic_year,$graduate_rotation_plan_status);
					foreach($plsos_details_data as $plsos_details){
						echo '<p style="margin:5px 0;" class="">'.get_plsos_name_from_plso_id_h($plsos_details->plso_id).'</p>';
 					}
				?>
			</td>
			
<?php 
	$dam_name_arr=array();
	$selected_dam_arr = array();
	if(isset($benchmark_tabuler_details->dam) && $benchmark_tabuler_details->dam!=''){
		$selected_dam_arr = explode(',',$benchmark_tabuler_details->dam);
		foreach($selected_dam_arr as $dam){
			$dam_name_arr[] = get_master_direct_assessment_title_h($dam);
		}
	}else{
		$selected_dam_arr = array();
		$dam_name_arr = array();
	}
	
	$indam_name_arr=array();
	$selected_indam_arr = array();
	if(isset($benchmark_tabuler_details->indam) && $benchmark_tabuler_details->indam!=''){
		$selected_indam_arr = explode(',',$benchmark_tabuler_details->indam);
		foreach($selected_indam_arr as $indam){
			$indam_name_arr[] = get_master_indirect_assessment_title_h($indam);
		}
	}else{
		$selected_indam_arr = array();
		$indam_name_arr = array();
	}
?>
	<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">
		<?php echo implode(',  ',$dam_name_arr);
		if(count($indam_name_arr)>0){
		echo ',  '.implode(',  ',$indam_name_arr);
		}?>
	</td>
	
	<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;">
		<?php
			$courses_details_data = get_courses_details_from_year_id_h($department_id,$graduate_status_value,$academic_year,$graduate_rotation_plan_status);
			foreach($courses_details_data as $courses_details){
				$course_arr = explode(',',$courses_details->course_id);
				for($i=0;$i<count($course_arr);$i++){
					echo '<p style="margin:5px 0;" class="">'.get_course_name_from_course_id_h($course_arr[$i]).'</p>';
				}
			}
		?>
	</td>



	<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;"><?php if(isset($benchmark_tabuler_details->criteria) && $benchmark_tabuler_details->criteria!=''){ echo $benchmark_tabuler_details->criteria;}?></td>
	<td style="padding: 10px;  color:#333; vertical-align:top; text-align:left;border-left:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><?php if(isset($benchmark_tabuler_details->sample_size) && $benchmark_tabuler_details->sample_size!=''){ echo $benchmark_tabuler_details->sample_size;}?></td>
</tr>
	
<?php  } ?>	
		
</table>