<table class="table table-striped1 table-bordered">
	<thead>
		<tr style="background-color:#f5f5f5;">
			<th rowspan="2" style="vertical-align:middle;">PROGRAM / INTERVENTIONS</th>
			<th style="text-align:center;" colspan="<?php echo count($pslosResult);?>">LEARNING OUTCOMES</th>
		</tr>
		<tr style="background-color:#f5f5f5;">
			<?php foreach($pslosResult as $pslos){?>
			<th style="text-align:center;"><?php echo $pslos['plso_prefix'];?></th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($coursesResult as $course){?>
			<tr>
				<td><?php echo $course['course_prefix']; if($alignmentAction<2){echo ' '.$course['course_number'];} echo ' - '.$course['course_title'];?></td>
				<?php foreach($pslosResult as $pslos){
					
					$matrixData = filter_array_chk_two($deptAligementMatrixDataArr,$pslos['id'],'pslos_id',$course['id'],'course_id');
					if(isset($matrixData) && $matrixData!='' && count($matrixData)>0){
						$matrix_option_id = $matrixData[0]['matrix_option_id'];
						$optionDetails = filter_array_chk($masterMatrixOptionsArr,$matrix_option_id,'id');
						$matrix_options = $optionDetails[0]['matrix_options'];
						$td_bg_color = 'background-color:#'.$optionDetails[0]['color_code'];
						$td_class = $optionDetails[0]['color_name'];
					}else{
						$matrix_options = '';
						$td_bg_color = '';
						$td_class = '';
					}
				
				?>
				<td style="text-align:center; font-weight:600;" class="<?php echo $td_class;?>"><?php echo ($matrix_options);?></td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>