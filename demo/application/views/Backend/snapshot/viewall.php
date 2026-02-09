<section class="content">
<?php
$upslo_no_count = get_count_plsos_for_underg_grad_h($department_id,'0');
$gpslo_no_count = get_count_plsos_for_underg_grad_h($department_id,'1'); 
$ucourses_count = get_count_courses_for_underg_grad_h($department_id,'0');
$gcourses_count = get_count_courses_for_underg_grad_h($department_id,'1');
$dropdown_matrix_options = get_department_course_matrix_options_h();
?>
<div class="box snapshot_page"> 
<div class="col-md-12">
 	<ul class="timeline">
 		<li>
			<label class="snapshot_page_title">Mission Statement</label>
				<div class="timeline-item">
				<!--<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>-->
				<h3 class="timeline-header"><?php if(isset($checklist_detail->mission_statement) && $checklist_detail->mission_statement!=''){echo $checklist_detail->mission_statement;}?></h3>
			</div>
		</li>
 		<li>
			<label class="snapshot_page_title">Vision Statement</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($checklist_detail->vision_statement) && $checklist_detail->vision_statement!=''){echo $checklist_detail->vision_statement;}?></h3>
			</div>
		</li>
 		<li>
			<label class="snapshot_page_title">Goals</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($checklist_detail->program_goals) && $checklist_detail->program_goals!=''){echo $checklist_detail->program_goals;}?></h3>
			</div>
		</li>
		<li>
			<label class="snapshot_page_title">Program Student Learning Objectives</label>
			<div class="timeline-item same_background">
				<div>
				<div class="contenttitle2 nomargintop">
					<h3>Undergraduate Student Learning Objectives/Outcomes </h3>
				</div>
  				<div class="col-md-12">
				<table class="table table-hover table-bordered table-striped table_mar20">
					<?php if(count($department_pslos_undergraduate)>0){ ?>
					<thead>
						<tr class="trbg">
							<th>UG SLOs </th>
							<th width="30%">Type of SLO </th>
						</tr>
					</thead>
					<tbody>
						<?php $j=1; foreach($department_pslos_undergraduate as $undergraduate){?>
						<?php 				
							$core_competency1=array();
							$pslos_core_competency1 = get_pslos_core_competency_h($department_id,$undergraduate->id);
							  
							if(isset($pslos_core_competency1->core_competency_id) && $pslos_core_competency1->core_competency_id!=''){
								$core_competency_details1 = explode(',',$pslos_core_competency1->core_competency_id);
								sort($core_competency_details1);
								for($i=0;$i<count($core_competency_details1);$i++){
									
									$core_competency_title1 = get_core_competency_title_h($core_competency_details1[$i]);
									$core_competency1[] = '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst($core_competency_title1).'.">CC'.$core_competency_details1[$i].'</span>';
									//$core_competency1[] = 'CC'.$core_competency_details1[$i];
								}
								$cc_data = '<h5 class="ccshow">'.implode(',  ',$core_competency1).'</h5>';
							}else{
								$cc_data = '';
							}					
						?>
						<tr>
							<td style="vertical-align:middle;"><?php if(isset($undergraduate->plso_title) && $undergraduate->plso_title!=''){echo ucfirst($undergraduate->plso_prefix.': '.$undergraduate->plso_title);}?></td>
							<td><?php echo $cc_data;?></td>
						</tr>
						<?php $j++;} ?>
					</tbody>
					<?php }else{ echo '<tr><td colspan="2"><i>-- no learning outcome available for undergraduate --</i></td></tr>'; }  ?>
				</table>
				</div>
				</div>
				<div>
					<div class="contenttitle2 nomargintop">
					<h3>Graduate Student Learning Objectives/Outcomes  </h3>
				</div>
  				<div class="col-md-12">
				<table class="table table-hover table-bordered table-striped table_mar20">
					<?php if(count($department_pslos_graduate)>0){ ?>
					<thead>
						<tr class="trbg">
							<th>G SLOs  </th>
							<th width="30%">Type of SLO </th>
						</tr>
					</thead>
					<tbody>
 						<?php
							$k=1; foreach($department_pslos_graduate as $graduate){
							 				
							$core_competency1=array();
							$pslos_core_competency1 = get_pslos_core_competency_h($department_id,$graduate->id);
							  
							if(isset($pslos_core_competency1->core_competency_id) && $pslos_core_competency1->core_competency_id!=''){
								$core_competency_details1 = explode(',',$pslos_core_competency1->core_competency_id);
								sort($core_competency_details1);
								for($i=0;$i<count($core_competency_details1);$i++){
									
									$core_competency_title1 = get_core_competency_title_h($core_competency_details1[$i]);
									$core_competency1[] = '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst($core_competency_title1).'.">CC'.$core_competency_details1[$i].'</span>';
									//$core_competency1[] = 'CC'.$core_competency_details1[$i];
								}
								$cc_data = '<h5 class="ccshow">'.implode(',  ',$core_competency1).'</h5>';
							}else{
								$cc_data = '';
							}					
						?>
						<tr>
							<td style="vertical-align:middle;"><?php if(isset($graduate->plso_title) && $graduate->plso_title!=''){echo ucfirst($graduate->plso_prefix.': '.$graduate->plso_title);}?></td>
							<td><?php echo $cc_data;?></td>
						</tr>
						<?php $j++;}?>
					</tbody>
					<?php  }else{ echo '<tr><td colspan="2"><i>-- no learning outcome available for graduate --</i></td></tr>'; } ?>
				</table>
				</div>
				</div>
			</div>
		</li>
		<li>
			<label class="snapshot_page_title">Course Alignment Matrix</label>
			<div class="timeline-item same_background">
				<div>
				<div class="col-md-12 instructions"><strong>Instructions:</strong> I = Introduce, E=Emphasizing, D = Developing, M = Mastering, P=Practicing</div>
				<div class="contenttitle2 nomargintop">
					<h3>Traditional Alignment Matrix for Undergraduate Program  </h3>
				</div>
  				<div class="col-md-12">
					<table class="table table-hover table-bordered table-striped table_mar20">
						<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){?>
						<tr class="trbg">
							<td rowspan="2" class="rowspan" style="vertical-align:middle"><b>LEARNING OUTCOMES</b> </td>
							<td colspan="<?php echo count($department_courses_result_undergraduate);?>"  style="text-align:center" class="recourses"><b>REQUIRED COURSES</b></td>
						</tr>
						
						<tr class="trbg" style="text-align:center">
							<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){?>
							<td class="tdborder"><?php echo $undergraduate_courses->course_prefix;?> <?php echo $undergraduate_courses->course_number;?></td>
							<?php } ?>
						</tr>
						
						<?php foreach($department_pslos_undergraduate as $undergraduate_pslos){?>
							<tr>
								<td style="vertical-align:middle" class="pslo_title">
 									<span data-toggle="tooltip" data-placement="top" title="<?php echo $undergraduate_pslos->plso_title;?>"><?php echo ucfirst($undergraduate_pslos->plso_prefix);?></span>
 								</td>
				
  								<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){
								
								$class_color = get_colorcode_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id);
								if(isset($class_color) && $class_color!=''){
									$style_backgroung_td = $class_color;
								}else{
									$style_backgroung_td = '';
								}
 								?>
								<td class="<?php echo $style_backgroung_td;?>" style="vertical-align: middle; text-align:center;">
								 
										<?php foreach($dropdown_matrix_options as $matrix_options){
											
											$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id,$matrix_options->id);
										if($matrix_option_count>0){ echo $matrix_options->matrix_options; }	
										?>
											 
										<?php } ?>
									 
								</td>
								<?php } ?>
							</tr>
						<?php } }else{ if(isset($upslo_no_count) && $upslo_no_count==0){ ?>
							<tr><td colspan="2"><i>-- no learning outcome available for undergraduate program --</i></td></tr>
							<?php } if(isset($ucourses_count) && $ucourses_count==0){?>
							<tr><td colspan="2"><i>-- no courses available for undergraduate program --</i></td></tr>
						<?php } } ?>
					</table>
				</div>
				</div>
				<div>
					<div class="contenttitle2 nomargintop">
					<h3>Traditional Alignment Matrix for Graduate Program   </h3>
				</div>
  				<div class="col-md-12">
					<table class="table table-hover table-bordered table-striped table_mar20">
					<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){?>
						<tr class="trbg">
							<td rowspan="2" class="rowspan" style="vertical-align:middle"><b>LEARNING OUTCOMES</b></td>
							<td colspan="<?php echo count($department_courses_result_graduate);?>" style="text-align:center;" class="recourses"><b>REQUIRED COURSES</b></td>
						</tr>
						
						<tr class="trbg" style="text-align:center">
							<?php foreach($department_courses_result_graduate as $graduate_courses){?>
							<td class="tdborder"><?php echo $graduate_courses->course_prefix;?> <?php echo $graduate_courses->course_number;?></td>
							<?php } ?>
						</tr>
						
						<?php foreach($department_pslos_graduate as $graduate_pslos){?>
							<tr>
								<td style="vertical-align:middle;" class="pslo_title">
									 
									<span data-toggle="tooltip" data-placement="top" title="<?php echo $graduate_pslos->plso_title;?>"><?php echo ucfirst($graduate_pslos->plso_prefix);?></span>
 								</td> 
				
								<?php foreach($department_courses_result_graduate as $graduate_courses){
								
								$class_color = get_colorcode_matrix_option_h($department_id,$graduate_pslos->id,$graduate_courses->id);
								if(isset($class_color) && $class_color!=''){
									$style_backgroung_td = $class_color;
								}else{
									$style_backgroung_td = '';
								}
											
								?>
								<td class="<?php echo $style_backgroung_td;?>" style="vertical-align: middle; text-align:center;">
									 
										<?php foreach($dropdown_matrix_options as $matrix_options){
											
											$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$graduate_pslos->id,$graduate_courses->id,$matrix_options->id);
											if($matrix_option_count>0){ echo $matrix_options->matrix_options;}
										?>
											 
										<?php } ?>
									 
								</td>
								<?php } ?>
							</tr>
						<?php } }else{ if(isset($gpslo_no_count) && $gpslo_no_count==0){ ?>
							<tr><td colspan="2"><i>-- no learning outcome available for graduate program --</i></td></tr>
							<?php } if(isset($gcourses_count) && $gcourses_count==0){?>
							<tr><td colspan="2"><i>-- no courses available for graduate program --</i></td></tr>
						<?php } } ?>
					</table>
				</div>
				</div>
			</div>
		</li>
		<li>
			<label class="snapshot_page_title">Your Feedback's</label>
			<div class="timeline-item">
				
					<?php if(count($department_feedback)>0){
					$kl=1; foreach($department_feedback as $feedback_details){?>
					<div class="col-md-12">
						 
						
 							<div class="col-md-10">
								<blockquote class="">
									<p><?php echo $feedback_details->feedback;?></p>
									<small><?php echo date('m/d/Y h:i A',$feedback_details->add_date);?></small>
								</blockquote>
							</div>
							<div class="col-md-2"></div>
							
						 
					</div>	
					<?php $kl++; }} ?>
				<form method="post" id="frm" action="<?php echo base_url();?>admin/snapshot/feedback_save">
					<div class="col-md-12 form-group" style="width: 96%;">
						<label style="font-weight:600;">Great! Any Other Feedback?</label>
						<input type="hidden" name="h_department_id" id="h_department_id" value="<?php echo $department_id;?>" />
						<textarea class="form-control required" name="feedback_txt" id="feedback_txt" rows="5"></textarea>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-4"><button class="btn btn-primary" type="submit" style="width:100%; margin:15px 0;">Submit</button></div>
					<div class="col-md-4"></div>
				</form>
			</div>
		</li>
 	</ul>



</div>	
</div>
</section>