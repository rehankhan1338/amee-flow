<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#time_tracker").click(function(event) {
        	$("#page_time_tracker").wordExport('performance_metrics_report');
      	});
    });
</script>

<div class="pull-right">
	<a class="btn btn-primary" id="time_tracker" style="padding:3px 10px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>
<div class="clearfix"></div>
<div id="page_time_tracker"> 
	<div style=" margin-bottom: 20px; text-align: center;">
	    <h2 style="color: #485b79; font-weight:600;"><?php echo $dept_session_details->department_name;?></h2>    
    </div>     

	<table width="100%" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">Name of Student</th>				
				<th nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">AMEE ID</th>
				<?php foreach($department_pslos_graduate as $pslos_graduate){ ?>
				<th nowrap="nowrap" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;"><?php echo get_plsos_name_from_plso_id_h($pslos_graduate->pslo_number); ?>
				<br /><?php 
					$heading_years=array();
 				$course_years = get_course_years_of_plsos_h($pslos_graduate->pslo_number);
				foreach($course_years as $course_years_details){
					$heading_years[]=$course_years_details->year;
				} echo ' ['.implode(' | ',$heading_years).']<br> Raw Score(s)';?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>	
		<?php if(count($undergraduate_student_listing)>0){ $i=0;foreach($undergraduate_student_listing as $undergraduate_student_details){?>  
			<tr>
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
					<?php if(isset($undergraduate_student_details->first_name)&& $undergraduate_student_details->first_name!=''){echo $undergraduate_student_details->first_name.' '.$undergraduate_student_details->last_name;}?>
				</td>
				
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
					<?php if(isset($undergraduate_student_details->email_to)&& $undergraduate_student_details->email_to!=''){echo get_amee_id_h($undergraduate_student_details->email_to);}?>
				</td>
				
					<?php foreach($department_pslos_graduate as $pslos_graduate){ $student_years_rating=''; ?>
				<td nowrap="nowrap" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">
					<?php $course_years = get_course_years_of_plsos_h($pslos_graduate->pslo_number);
				foreach($course_years as $course_years_details){
				
					
					$overall_average_rating=array();
					
					$cours_id = $course_years_details->id;
					$student_ass_id = $course_years_details->ar_id;
					$student_email = $undergraduate_student_details->email_to;
					$auth_code = get_authcode_of_student_email_id_h($student_email,$student_ass_id);
					
					$plso_selected_status = get_plso_selected_by_student_h($cours_id,$student_ass_id,$auth_code);					
					
					if(isset($auth_code) && $auth_code!='' && isset($plso_selected_status) && $plso_selected_status>0){
					
						$assingment_rubric_builder_category_list = $this->Assignment_mdl->assingment_rubric_builder_category_list($student_ass_id);
						$raters_listing = get_raters_listing_with_feedback_details_h($student_ass_id,$auth_code);
						
						if(count($raters_listing)>0){
							
							foreach($raters_listing as $raters_detail){
								$total_category_score=array();
								if(count($assingment_rubric_builder_category_list)>0){
									foreach($assingment_rubric_builder_category_list as $category_details){
										  $total_category_score[]=get_assingment_raters_score_of_category_count_h($student_ass_id, $raters_detail->rater_auth_code, $auth_code,$category_details->rubric_id);
										 
									}
								}
								$overall_average_rating[] = array_sum($total_category_score);
								
							}
							$student_years_rating[] = round(array_sum($overall_average_rating)/count($assingment_rubric_builder_category_list),2);
							
						}
					}
					 
				} if(count($student_years_rating)>0){ if(isset($student_years_rating) && $student_years_rating!=''){echo implode(' | ',$student_years_rating);}}?>
				</td>
				<?php  } ?>
			</tr>			
		<?php } } ?>	      
		</tbody>
		
	</table>
 
</div>