<div class="col-md-12 instructions"><strong>Instructions:</strong> I = Introduce, E=Emphasizing, D = Developing, M = Mastering, P=Practicing</div>
<form method="post" action="<?php echo base_url();?>coordinate/save_undergraduate_allignment_matrix">
	<table class="table table-bordered" style="font-size:16px;">
	
		<tr class="trbg">
			<td rowspan="2" class="rowspan" style="vertical-align:middle"><b>LEARNING OUTCOMES</b> </td>
			<td colspan="<?php echo count($department_courses_result_undergraduate);?>" class="recourses"><b>PROGRAM / INTERVENTIONS</b></td>
		</tr>
		
		<tr class="trbg" style="text-align:center">
			<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){?>
			<td class="tdborder"><?php echo $undergraduate_courses->course_prefix;?> <?php echo $undergraduate_courses->course_number;?></td>
			<?php } ?>
		</tr>
		
		<?php foreach($department_pslos_undergraduate as $undergraduate_pslos){?>
			<tr>
				<td style="vertical-align:middle" class="pslo_title">
					<input type="hidden" name="upslos[]" id="upslos[]" value="<?php echo $undergraduate_pslos->id;?>" />
					<i><a data-toggle="tooltip" data-placement="top" title="<?php echo $undergraduate_pslos->plso_title;?>"><?php echo ucfirst($undergraduate_pslos->plso_prefix);?></a></i>
					<?php 				
						$core_competency=array();
						$pslos_core_competency = get_pslos_core_competency_h($department_id,$undergraduate_pslos->id);
						  
						if(isset($pslos_core_competency->core_competency_id) && $pslos_core_competency->core_competency_id!=''){
							$core_competency_details = explode(',',$pslos_core_competency->core_competency_id);
							sort($core_competency_details);
							for($i=0;$i<count($core_competency_details);$i++){
								
								$core_competency_title = get_core_competency_title_h($core_competency_details[$i]);
								$core_competency[] = '<a data-toggle="tooltip" data-placement="top" title="'.ucfirst($core_competency_title).'.">CC'.$core_competency_details[$i].'</a>';
							}
							echo '<h4>'.implode(', ',$core_competency).'</h4>';
						}					
					?>
				</td>

  					
		
				

				<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){
				
				$class_color = get_colorcode_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id);
				if(isset($class_color) && $class_color!=''){
					$style_backgroung_td = $class_color;
				}else{
					$style_backgroung_td = '';
				}
							
				?>
				<td class="<?php echo $style_backgroung_td;?>" style="vertical-align: middle;">
					<select class="form-control" name="<?php echo $undergraduate_pslos->id;?>ucourses_<?php echo $undergraduate_courses->id;?>" id="ucourses_<?php echo $undergraduate_courses->id;?>" >
						<option value=""></option>
						<?php foreach($dropdown_matrix_options as $matrix_options){
							
							$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id,$matrix_options->id);
							
						?>
							<option value="<?php echo $matrix_options->id;?>" <?php if($matrix_option_count>0){?> selected="selected" <?php } ?>><?php echo $matrix_options->matrix_options;?></option>
						<?php } ?>
					</select>
				</td>
				<?php } ?>
			</tr>
		<?php } ?>
		
		
	</table>
	<div class="clearfix"></div>
	<h4><strong><i>Data legend for % of courses and SLO approaches:</i></strong></h4>
	<div class="col-md-12 margin20">
	<?php foreach($dropdown_matrix_options as $matrix_options){ ?>
 			
		<div class="col-md-3" style="padding:8px;">
			<div class="col-md-2"><?php echo $matrix_options->matrix_options;?></div>
			<div class="col-md-1 <?php echo $matrix_options->color_name;?>" style="width:35px; height:20px;"></div>
			<div class="col-md-2" style="font-weight:600; letter-spacing:1px;">
				<?php  $allignment_matrix_courses_count = get_allignment_matrix_courses_count_h($department_id,$matrix_options->id,'0');
				echo number_format(($allignment_matrix_courses_count / $ucourses_count) * 100, 2).'%';
				?>
			</div>
		</div>		
		
	<?php } ?>
	</div>
	
	<div class="clearfix"></div>
	 
		<input type="submit" name="save_undergraduate_allignment_matrix_btn" class="btn btn-primary" value='Save & Update' />
	 
</form>