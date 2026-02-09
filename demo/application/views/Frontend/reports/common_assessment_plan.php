<table class="table table-bordered">
	<thead>
		<tr style="background-color:#f5f5f5;">
			<th style="vertical-align:middle; text-align:center;">Time Period</th>
			<th style="vertical-align:middle; text-align:center;">Learning Outcome</th>
			<th style="vertical-align:middle; text-align:center;">Measures to be used </th>
			<th style="vertical-align:middle; text-align:center;">Target Audience? </th>
			<th style="vertical-align:middle; text-align:center;">Benchmarks</th>
			<th style="vertical-align:middle; text-align:center;">Sample Size</th>
		</tr>				
		<tr style="background-color:#f5f5f5;">
			<th style="vertical-align:middle; text-align:center;">Year</th>
			<th style="vertical-align:middle; text-align:center;">What is to be assessed?</th>
			<th style="vertical-align:middle; text-align:center;">Kind of direct or indirect measures to be used </th>
			<th style="vertical-align:middle; text-align:center;">Courses to be assessed </th>
			<th style="vertical-align:middle; text-align:center;">What results would indicate success? What is the target? </th>
			<th style="vertical-align:middle; text-align:center;"># of Respondents Targeted</th>
		</tr>
	</thead>
	<tbody>
		<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){
		$academic_year = $rpy+1;
		
		$benchmark_tabuler_details = filter_array_chk_two($deptMeasurementAssessmentData,$academic_year,'year_id',$ass_status_value,'tabular_status');
		
		?>
			<tr>
				<td nowrap="nowrap" style="font-weight:600;"><?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
				<td>
				<?php
				$plsos_details_data = get_plsos_details_from_year_id_h($dept_session_details->id,$ass_status_value,$academic_year,$ass_rotation_plan_status);
				foreach($plsos_details_data as $plsos_details){
					$fPsloD = filter_array_chk($pslosResult,$plsos_details->plso_id,'id');
					if(isset($fPsloD[0]['plso_prefix']) && $fPsloD[0]['plso_prefix']!=''){
						echo '<p class="rtptdp">'.$fPsloD[0]['plso_prefix'].'</p>';
					}
				}
				?>
				</td>
				<td>
					<?php 
					$comAr = array();
					if(isset($benchmark_tabuler_details[0]['dam']) && $benchmark_tabuler_details[0]['dam']!=''){							
						$damArr = explode(',',$benchmark_tabuler_details[0]['dam']);
						foreach($damArr as $dam){
							$fDam = filter_array_chk($masterDirectAssessmentArr,$dam,'id');
							$comAr[] = $fDam[0]['name'];
						}							
					}
					if(isset($benchmark_tabuler_details[0]['indam']) && $benchmark_tabuler_details[0]['indam']!=''){							
						$indamArr = explode(',',$benchmark_tabuler_details[0]['indam']);
						foreach($indamArr as $indam){
							$finDam = filter_array_chk($masterIndirectAssessmentArr,$indam,'id');
							$comAr[] = $finDam[0]['name'];
						}							
					}							
					echo implode(', ',$comAr);?>							
				</td>
				<td>
				<?php
					$courses_details_data = get_courses_details_from_year_id_h($dept_session_details->id,$ass_status_value,$academic_year,$ass_rotation_plan_status);
					foreach($courses_details_data as $cdetails){
						$course_arr = explode(',',$cdetails->course_id);
						for($i=0;$i<count($course_arr);$i++){
							$fCourseD = filter_array_chk($coursesResult,$course_arr[$i],'id');
							if(isset($fCourseD[0]['course_prefix']) && $fCourseD[0]['course_prefix']!=''){
								echo '<p class="rtptdp">'.$fCourseD[0]['course_prefix'];
								if(isset($fCourseD[0]['course_number']) && $fCourseD[0]['course_number']>0){echo ' '.$fCourseD[0]['course_number'];}
								echo '</p>';
							}									
						}									 
					}
				?>
				</td>
				<td><?php if(isset($benchmark_tabuler_details[0]['criteria']) && $benchmark_tabuler_details[0]['criteria']!=''){echo $benchmark_tabuler_details[0]['criteria'];}else{echo '&ndash;';}?></td>
				<td><?php if(isset($benchmark_tabuler_details[0]['sample_size']) && $benchmark_tabuler_details[0]['sample_size']!=''){echo $benchmark_tabuler_details[0]['sample_size'];}else{echo '&ndash;';}?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>