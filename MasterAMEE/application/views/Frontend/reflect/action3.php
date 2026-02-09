<?php include(APPPATH.'views/Frontend/reflect/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<?php 
$department_id = $this->session->userdata('dept_id');

$undergraduate_status_value = $this->config->item('con_undergraduate_status_value');
$graduate_status_value = $this->config->item('con_graduate_status_value');
$program_status_value = $this->config->item('con_program_status_value');
	
$upslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$undergraduate_status_value);
$gpslo_no_count = get_count_plsos_for_underg_grad_h($department_id,$graduate_status_value); 
$plo_no_count = get_count_plsos_for_underg_grad_h($department_id,$program_status_value); 

$ucourses_count = get_count_courses_for_underg_grad_h($department_id,$undergraduate_status_value);
$gcourses_count = get_count_courses_for_underg_grad_h($department_id,$graduate_status_value);
$program_count = get_count_courses_for_underg_grad_h($department_id,$program_status_value); 

$undergraduate_rotation_plan_status = get_rotation_plan_status_h($department_id,$undergraduate_status_value);
$graduate_rotation_plan_status = get_rotation_plan_status_h($department_id,$graduate_status_value);
$program_rotation_plan_status = get_rotation_plan_status_h($department_id,$program_status_value);

//$dropdown_matrix_options = get_department_course_matrix_options_h();
?>
<div class="box action3_assessment_plan">
<div class="nrow">	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#undergraduates_rotation_plan">Undergraduate Assessment Plan </a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#graduates_rotation_plan">Graduate Assessment Plan</a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="#program_rotation_plan">Program Assessment Plan</a></li>
	</ul>
	<div id="undergraduates_rotation_plan" class="subcontent margin20"  style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
		<div class="col-md-123">
			<div class="contenttitle2 nomargintop">
				<h3> Undergraduate Assessment Plan</h3>
			</div>
			<div class="clearfix"></div>
			<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){
					include(APPPATH.'views/Frontend/reflect/undergraduate_assessment_plan.php');
				}else{
					if(isset($upslo_no_count) && $upslo_no_count==0){
						echo '<h4 class="padding10"><i>-- no learning outcome available for undergraduate program --</i> <a href="'.base_url().'department/envision/action2?tab_id=3" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add PSLOS Now!</a></h4>';
					}
					if(isset($ucourses_count) && $ucourses_count==0){
						echo '<h4 class="padding10"><i>-- no courses available for undergraduate program --</i> <a href="'.base_url().'department/coordinate/action2" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add Courses Now!</a></h4>';
					}
				}	
			?>
			
		</div>
	</div>		
 	
	<div id="graduates_rotation_plan" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>;">
		<div class="col-md-123">
			<div class="contenttitle2 nomargintop">
				<h3> Graduate Assessment Plan</h3>
			</div>
			<div class="clearfix"></div>	
			<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){
					include(APPPATH.'views/Frontend/reflect/graduate_assessment_plan.php');
				}else{
					if(isset($gpslo_no_count) && $gpslo_no_count==0){
						echo '<h4 class="padding10"><i>-- no learning outcome available for graduate program --</i> <a href="'.base_url().'department/envision/action2?tab_id=4" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add PSLOS Now!</a></h4></h4>';
					}
					if(isset($gcourses_count) && $gcourses_count==0){
						echo '<h4 class="padding10"><i>-- no courses available for graduate program --</i> <a href="'.base_url().'department/coordinate/action2?tab_id=2" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add Courses Now!</a></h4></h4>';
					}
				}	
			?>			 
		
		</div>
	</div>
	
	<div id="program_rotation_plan" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'block';}else{echo 'none';}?>;">
		<div class="col-md-123">
			<div class="contenttitle2 nomargintop">
				<h3> Program Assessment Plan</h3>
			</div>
			<div class="clearfix"></div>	
			<?php if(isset($plo_no_count) && $plo_no_count>0 && isset($program_count) && $program_count>0){
					include(APPPATH.'views/Frontend/reflect/program_assessment_plan.php');
				}else{
					if(isset($plo_no_count) && $plo_no_count==0){
						echo '<h4 class="padding10"><i>-- no program learning outcome available --</i> <a href="'.base_url().'department/envision/action2?tab_id=5" class="btn btn-default" style="padding:3px 15px; font-size:15px;">Add Program Learning Outcome Now!</a></h4></h4>';
					}
					if(isset($program_count) && $program_count==0){
						echo '<h4 class="padding10"><i>-- no courses available for program --</i> <a href="'.base_url().'department/coordinate/action2?tab_id=3" class="btn btn-default" style="padding:3px 15px; font-size:15px;">Add Program Alignment Matrix Now!</a></h4></h4>';
					}
				}	
			?>			 
		
		</div>
	</div>
	
</div>	
 
</div>
<div class="clearfix"></div> <br /> 
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/reflect/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/reflect/action2" class="btn btn-info"><< Previous Action2</a>
	</div>
</div> 	