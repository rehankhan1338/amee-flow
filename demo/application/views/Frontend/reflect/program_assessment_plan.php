<table class="table table-bordered mart10">
	
	<tr class="trbg">
		<th class="rowspan assessment_td" style="vertical-align:middle;" nowrap="nowrap">Time Period</th>
		<th class="rowspan assessment_td" style="vertical-align:middle;">Learning Outcome</th>
		<th class="rowspan assessment_td" style="vertical-align:middle;">Measures to be used </th>
		<th class="rowspan assessment_td" style="vertical-align:middle;">Target Audience</th>
		<th class="rowspan assessment_td" style="vertical-align:middle;">Benchmarks</th>
		<th class="rowspan assessment_td" style="vertical-align:middle;">Sample Size</th>
	</tr>
	
	
	<tr class="trbg">
		<th class="rowspan">Year</th>
		<th class="rowspan">What is to be assessed?</th>
		<th class="rowspan">Kind of direct or indirect measures to be used </th>
		<th class="rowspan">Program to be Assessed </th>
		<th class="rowspan">What results would indicate success? What is the target? </th>
		<th class="rowspan"># of Respondents Targeted</th>
	</tr>
	
	
	
	<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){
	
		$academic_year = $rpy+1;
		
		$benchmark_tabuler_details = get_benchmark_tabuler_details_h($department_id,$academic_year,$program_status_value);
		
		?>
		
		<tr>
			<td nowrap="nowrap">
			<?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<td nowrap="nowrap">
				<?php
					$pa1 = array();
 					$plsos_details_data = get_plsos_details_from_year_id_h($department_id,$program_status_value,$academic_year,$program_rotation_plan_status);
					foreach($plsos_details_data as $plsos_details){
						//echo '<p style="margin:5px 0;" class="">'.get_plsos_name_from_plso_id_h($plsos_details->plso_id).'</p>';
						$pa1[] = get_plsos_name_from_plso_id_h($plsos_details->plso_id);
 					}
					echo implode(', ',$pa1);
				?>
			</td>
			
<?php 
	$dam_name_arr=array();
	$selected_dam_arr =array();
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
	$selected_indam_arr =array();
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
	<td style="text-align:center; ">
		<?php echo implode(', ',$dam_name_arr);
		if(count($indam_name_arr)>0){
		echo ', '.implode(', ',$indam_name_arr);
		}?>
	</td>
	
	<td nowrap="nowrap">
		<?php
			$pa2 = array();
			$courses_details_data = get_courses_details_from_year_id_h($department_id,$program_status_value,$academic_year,$program_rotation_plan_status);
			foreach($courses_details_data as $courses_details){
				$course_arr = explode(',',$courses_details->course_id);
				for($i=0;$i<count($course_arr);$i++){
					//echo '<p style="margin:5px 0;" class="">'.get_course_name_from_course_id_h($course_arr[$i]).'</p>';
					$pa2[] = get_course_name_from_course_id_h($course_arr[$i]);
				}
			}
			echo implode(', ',$pa2);
		?>
	</td>



	<td><?php if(isset($benchmark_tabuler_details->criteria) && $benchmark_tabuler_details->criteria!=''){ echo $benchmark_tabuler_details->criteria;}?></td>
	<td><?php if(isset($benchmark_tabuler_details->sample_size) && $benchmark_tabuler_details->sample_size!=''){ echo $benchmark_tabuler_details->sample_size;}?></td>
</tr>
	
<?php  } ?>	
		
</table>