<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#export_dept_checklist").click(function(event) {
        	$("#page_dept_checklist").wordExport('planning_report');
      	});
    });
</script>
<div class="pull-right">
	<a class="btn btn-primary" id="export_dept_checklist" style="padding:4px 15px; margin-right:5px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:4px 15px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>
<?php
$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
$graduate_status_value = $this->config->item('con_graduate_status_value');
	
$upslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$undergraduate_status_value);
$gpslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$graduate_status_value); 
$ucourses_count = get_count_courses_for_underg_grad_h($department_id,$undergraduate_status_value);
$gcourses_count = get_count_courses_for_underg_grad_h($department_id,$graduate_status_value); 

$undergraduate_rotation_plan_status = get_rotation_plan_status_h($department_id,$undergraduate_status_value);
$graduate_rotation_plan_status = get_rotation_plan_status_h($department_id,$graduate_status_value);
$dropdown_matrix_options = get_department_course_matrix_options_h();
?>
<style>
#page_dept_checklist ul, #page_dept_checklist ol{ list-style-position:inside;}
#page_dept_checklist ul li, #page_dept_checklist ol li{padding:2px 0px 2px 15px;}
#page_dept_checklist .secDets h3{ font-size:20px; margin:12px 0;}
</style>
<div class="clearfix"></div>
<div id="page_dept_checklist">
	 
	<div style="text-align: center;">
	  <h2 style="color: #485b79;margin: 10px 0; font-style:italic; text-transform:uppercase;"><b><?php echo $dept_session_details->department_name;?></b></h2>    
	  <h3 style=" margin:10px 0;color:#485b79; font-style:italic;"><b><?php if(isset($university_details->university_name)&& $university_details->university_name!=''){echo str_replace('College','',$university_details->university_name); }else{ echo 'DEMO College';} ?></b></h3>
	  <h6 style="font-size: 16px; margin:5px 0;color:#333;"><b>Assessment Planning Report</b></h6>
	  <h6 style="font-size: 16px; margin:10px 0;color:#333;"><b>Prepared by <?php echo $dept_session_details->first_name.' '.$dept_session_details->last_name;?></b></h6>
	</div>	     
    <?php if(isset($checklist_detail->envision_action1_overview) && $checklist_detail->envision_action1_overview!=''){?> 
    <div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->envision_action1_overview;?>
		</div>
	</div> 
	<?php } ?>
	<?php if(isset($checklist_detail->mission_statement) && $checklist_detail->mission_statement!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;"> Mission Statement</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->mission_statement;?>
		</div>
	</div>   
 	<?php } ?>
	<?php if(isset($checklist_detail->vision_statement) && $checklist_detail->vision_statement!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79;font-weight:600;"> Vision Statement </h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->vision_statement;?>
		</div>
	</div>	
	<?php } ?>
	<?php if(isset($checklist_detail->program_goals) && $checklist_detail->program_goals!=''){?> 
 	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;"> Department/Program Goals </h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->program_goals;?>
		</div>
	</div>
	<?php } ?>
	<?php if(isset($checklist_detail->envision_action2_overview) && $checklist_detail->envision_action2_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div class="secDets" style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->envision_action2_overview;?>
		</div>
	</div>
 	<?php } ?>
	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;">Program Student Learning Objectives</h3>
 		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Program Student Learning Outcomes:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
			<?php if(count($department_pslos_undergraduate)>0){ ?>	
 				<thead>
					<tr>
						<th width="70%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">UG SLOs </th>
						<th width="30%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Type of SLO </th>
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
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
							<?php if(isset($undergraduate->plso_title) && $undergraduate->plso_title!=''){echo ucfirst($undergraduate->plso_prefix.': '.$undergraduate->plso_title);}?>
							</td>
								
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
							<?php echo $cc_data;?>
						</td>
					</tr>			
				<?php $j++;} ?>	      
				</tbody>
			
			<?php }else{?>
				<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no learning outcome available for undergraduate --</i></td></tr>
			<?php }  ?>	
			</table>
		</div>
		
				
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Program Student Learning Outcomes:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
			<?php if(count($department_pslos_graduate)>0){ ?>	
			
				<thead>
					<tr>
						<th width="70%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;">UG SLOs </th>
						<th width="30%" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">Type of SLO </th>
					</tr>
				</thead>
				
				<tbody>	
				<?php $j=1; foreach($department_pslos_graduate as $undergraduate){?>        
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
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
							<?php if(isset($undergraduate->plso_title) && $undergraduate->plso_title!=''){echo ucfirst($undergraduate->plso_prefix.': '.$undergraduate->plso_title);}?>
							</td>
								
						<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;">
							<?php echo $cc_data;?>
						</td>
					</tr>			
				<?php $j++;} ?>	      
				</tbody>
			
			<?php }else{?>
				<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no learning outcome available for undergraduate --</i></td></tr>
			<?php }  ?>	
			</table>
		</div>
		
	</div>
	
	<?php if(isset($checklist_detail->coordinate_action1_overview) && $checklist_detail->coordinate_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->coordinate_action1_overview;?>
		</div>
	</div>
	<?php } ?>		
	
	<div style="margin:10px 0;">
	    <h3 style="color: #485b79;font-weight:600;">Course Alignment Matrix</h3>
		<p style="background-color: #eaf4f6;border: 1px solid #dedede;margin: 15px 0;border-radius: 3px;padding: 10px;color: #333;">
			<strong>Instructions:</strong> I = Introduce, E=Emphasizing, D = Developing, M = Mastering, P=Practicing
		</p>
 		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Alignment Matrix:</h6>
			 <table width="100%" cellpadding="0" cellspacing="0">
						<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){?>
						<tr>
							<th rowspan="2" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;"><b>LEARNING OUTCOMES</b> </td>
							
							<th colspan="<?php echo count($department_courses_result_undergraduate);?>"  style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" class="recourses"><b>REQUIRED COURSES</b></th>
						</tr>
						
						<tr>
							<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){?>
							<td style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" class="tdborder"><?php echo $undergraduate_courses->course_prefix;?> <?php echo $undergraduate_courses->course_number;?></td>
							<?php } ?>
						</tr>
						
						<?php foreach($department_pslos_undergraduate as $undergraduate_pslos){?>
							<tr>
								<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
 									<span data-toggle="tooltip" data-placement="top" title="<?php echo $undergraduate_pslos->plso_title;?>"><?php echo ucfirst($undergraduate_pslos->plso_prefix);?></span>
 								</td>
				
  								<?php $td=1; foreach($department_courses_result_undergraduate as $undergraduate_courses){
								
								$class_color = get_colorcode_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id);
								if(isset($class_color) && $class_color!=''){
									$style_backgroung_td = $class_color;
								}else{
									$style_backgroung_td = '';
								}
								
								if($style_backgroung_td=='align_matrix_red'){
									$td_bg_color = 'background:#f46060;';
								}else if($style_backgroung_td=='align_matrix_yellow'){
									$td_bg_color = 'background:#f8ed86;';
								}else if($style_backgroung_td=='align_matrix_blue'){
									$td_bg_color = 'background:#8DB3E2;';
								}else if($style_backgroung_td=='align_matrix_orange'){
									$td_bg_color = 'background:#fb9337;';
								}else if($style_backgroung_td=='align_matrix_purple'){
									$td_bg_color = 'background:#9966FF;';
								}else if($style_backgroung_td=='align_matrix_green'){
									$td_bg_color = 'background:#8bc34a;';
								}else if($style_backgroung_td=='align_matrix_brown'){
									$td_bg_color = 'background:#7d5e3f;';
								}else{
									$td_bg_color = '';
								}
 								?>
								<td style=" <?php echo $td_bg_color;?>  padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd; text-align:center; <?php if($td==count($department_courses_result_undergraduate)){?> border-right:1px solid #ddd;<?php } ?>" >
								 
										<?php foreach($dropdown_matrix_options as $matrix_options){
											
											$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id,$matrix_options->id);
										if($matrix_option_count>0){ echo $matrix_options->matrix_options; }	
										?>
											 
										<?php } ?>
									 
								</td>
								<?php $td++; } ?>
							</tr>
						<?php } }else{ if(isset($upslo_no_count) && $upslo_no_count==0){ ?>
							<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no learning outcome available for undergraduate program --</i></td></tr>
							<?php } if(isset($ucourses_count) && $ucourses_count==0){?>
							<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no courses available for undergraduate program --</i></td></tr>
						<?php } } ?>
					</table>
		</div>
		
				
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Alignment Matrix:</h6>
			<table width="100%" cellpadding="0" cellspacing="0">
					<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){?>
						<tr>
							<th rowspan="2" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left;border:1px solid #ddd;"><b>LEARNING OUTCOMES</b></td>
							<td colspan="<?php echo count($department_courses_result_graduate);?>" style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" class="recourses"><b>REQUIRED COURSES</b></td>
						</tr>
						
						<tr>
							<?php foreach($department_courses_result_graduate as $graduate_courses){?>
							<td style="padding: 10px; background:#485b79; color:#fff; vertical-align:middle; text-align:left; text-align:center; border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;" class="tdborder"><?php echo $graduate_courses->course_prefix;?> <?php echo $graduate_courses->course_number;?></td>
							<?php } ?>
						</tr>
						
						<?php foreach($department_pslos_graduate as $graduate_pslos){?>
							<tr>
								<td style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
 									<span data-toggle="tooltip" data-placement="top" title="<?php echo $graduate_pslos->plso_title;?>"><?php echo ucfirst($graduate_pslos->plso_prefix);?></span>
 								</td> 
				
								<?php $td=1; foreach($department_courses_result_graduate as $graduate_courses){
								
								$class_color = get_colorcode_matrix_option_h($department_id,$graduate_pslos->id,$graduate_courses->id);
								if(isset($class_color) && $class_color!=''){
									$style_backgroung_td = $class_color;
								}else{
									$style_backgroung_td = '';
								}
								if($style_backgroung_td=='align_matrix_red'){
									$td_bg_color = 'background:#f46060;';
								}else if($style_backgroung_td=='align_matrix_yellow'){
									$td_bg_color = 'background:#f8ed86;';
								}else if($style_backgroung_td=='align_matrix_blue'){
									$td_bg_color = 'background:#8DB3E2;';
								}else if($style_backgroung_td=='align_matrix_orange'){
									$td_bg_color = 'background:#fb9337;';
								}else if($style_backgroung_td=='align_matrix_purple'){
									$td_bg_color = 'background:#9966FF;';
								}else if($style_backgroung_td=='align_matrix_green'){
									$td_bg_color = 'background:#8bc34a;';
								}else if($style_backgroung_td=='align_matrix_brown'){
									$td_bg_color = 'background:#7d5e3f;';
								}else{
									$td_bg_color = '';
								}			
								?>
								<td style=" <?php echo $td_bg_color;?> padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd; text-align:center; <?php if($td==count($department_courses_result_graduate)){?> border-right:1px solid #ddd;<?php } ?>">
									 
										<?php foreach($dropdown_matrix_options as $matrix_options){
											
											$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$graduate_pslos->id,$graduate_courses->id,$matrix_options->id);
											if($matrix_option_count>0){ echo $matrix_options->matrix_options;}
										?>
											 
										<?php } ?>
									 
								</td>
								<?php $td++;} ?>
							</tr>
						<?php } }else{ if(isset($gpslo_no_count) && $gpslo_no_count==0){ ?>
							<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no learning outcome available for graduate program --</i></td></tr>
							<?php } if(isset($gcourses_count) && $gcourses_count==0){?>
							<tr><td colspan="2" style="padding: 10px;color:#333;border-bottom:1px solid #ddd;border-left:1px solid #ddd;border-right:1px solid #ddd;"><i>-- no courses available for graduate program --</i></td></tr>
						<?php } } ?>
					</table> 
		</div>
		
	</div>
	
	<?php if(isset($checklist_detail->design_action1_overview) && $checklist_detail->design_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->design_action1_overview;?>
		</div>
	</div>
	<?php } ?>	
	
	<div style="margin:10px 0;">
		<h3 style="color: #485b79;font-weight:600;">Rotation Plan</h3>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Team Members:</h6>
			<?php foreach($team_members_detail_group_by as $team_members_detail){
 			$member_names_detail = get_member_names_result_by_id($team_members_detail->team_id);
 			?>
			<h6 style="font-size: 16px; margin:15px 0;color:#333; font-weight:500; margin-left:10px;">
				<?php echo '<b>Team '.$team_members_detail->team_id.'</b>';?>: &nbsp;&nbsp;<?php 
				$team_members_name='';
				foreach($member_names_detail as $members_name){
					if(isset($members_name->name)&& $members_name->name!=''){ $team_members_name.=$members_name->name.', ';}
				}
				echo substr(trim($team_members_name), 0, -1);?>
			</h6>
			<?php } ?> 
		</div>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Rotation Plan:</h6>
			<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){?>
				<?php if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){?>
					<?php 
						if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==1){
					
							include(APPPATH.'views/Frontend/reports/undergraduate_automatic_rotation_plan.php');
						
						}else if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==2){
						
							include(APPPATH.'views/Frontend/reports/undergraduate_manual_rotation_plan.php');
							
						}
					?>					
				<?php } ?>
			<?php } ?>
		</div>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Rotation Plan:</h6>
			<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){?>
				<?php if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){?>
					<?php 
						if(isset($graduate_rotation_plan_status) && $graduate_rotation_plan_status==1){
					
							include(APPPATH.'views/Frontend/reports/graduate_automatic_rotation_plan.php');
						
						}else if(isset($graduate_rotation_plan_status) && $graduate_rotation_plan_status==2){
						
							include(APPPATH.'views/Frontend/reports/graduate_manual_rotation_plan.php');
							
						}
					?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	
	<?php if(isset($checklist_detail->reflect_action1_overview) && $checklist_detail->reflect_action1_overview!=''){?> 
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<?php echo $checklist_detail->reflect_action1_overview;?>
		</div>
	</div>
	<?php } ?>
	
	<div style="margin:10px 0;">
		<h3 style="color: #485b79;font-weight:600;">Assessment Plan</h3>
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Undergraduate Assessment Plan:</h6>
			<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){?>
				<?php include(APPPATH.'views/Frontend/reports/undergraduate_assessment_plan.php');?>
			<?php } ?>
		</div>	
		<div style="font-size: 16px;line-height: 22px;">
			<h6 style="font-size: 16px; margin:15px 0;color:#333;">Graduate Assessment Plan:</h6>
			<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){?>
				<?php include(APPPATH.'views/Frontend/reports/graduate_assessment_plan.php');?>
			<?php } ?>
		</div>
	 </div>
	
	
</div>