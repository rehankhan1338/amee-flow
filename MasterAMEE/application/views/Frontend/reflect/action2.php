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
<style>
/*.hornav {min-height: 62px}
.hornav li a{max-width: 250px;min-height: 61px;}*/
i{ cursor:pointer;}
</style>
<div class="box action3_rotation_plan">
<div class="nrow">	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#undergraduates_measurement_tools">UG Measurement and Benchmark Tabular </a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#graduates_measurement_tools">GR Measurement and Benchmark Tabular</a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'current';}?>"><a href="#program_measurement_tools">Program Measurement and Benchmark Tabular </a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="#sample_size_calcultor">Sample Size Calculator</a></li>
	</ul>
	<div id="undergraduates_measurement_tools" class="subcontent margin20"  style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
		
			<div class="contenttitle2 nomargintop">
				<h3> Undergraduate Measurement and Benchmark Tabular </h3>
			</div>
			<div class="clearfix"></div>
			<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){
					if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status!='' && $undergraduate_rotation_plan_status>0){
						include(APPPATH.'views/Frontend/reflect/undergraduate_tabular.php');
					}else{
						echo '<h4 class="padding10"><i>-- no undergraduate rotation plan selected yet --</i></h4>';
					}	
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
 	
	<div id="graduates_measurement_tools" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>;">
		
			<div class="contenttitle2 nomargintop">
				<h3> Graduate Measurement and Benchmark Tabular</h3>
			</div>
			<div class="clearfix"></div>	
			<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){
					if(isset($graduate_rotation_plan_status) && $graduate_rotation_plan_status!='' && $graduate_rotation_plan_status>0){
						include(APPPATH.'views/Frontend/reflect/graduate_tabular.php');
					}else{
						echo '<h4 class="padding10"><i>-- no graduate rotation plan selected yet --</i></h4>';
					}
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
	
	<div id="program_measurement_tools" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'block';}else{echo 'none';}?>;">		
		<div class="contenttitle2 nomargintop">
			<h3> Program Measurement and Benchmark Tabular</h3>
		</div>
		<div class="clearfix"></div>	
		<?php if(isset($plo_no_count) && $plo_no_count>0 && isset($program_count) && $program_count>0){
				if(isset($program_rotation_plan_status) && $program_rotation_plan_status!='' && $program_rotation_plan_status>0){
					include(APPPATH.'views/Frontend/reflect/program_tabular.php');
				}else{
					echo '<h4 class="padding10"><i>-- no program rotation plan selected yet --</i></h4>';
				}
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
	
	<div id="sample_size_calcultor" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'block';}else{echo 'none';}?>;">
	 	<?php include(APPPATH.'views/Frontend/reflect/sample_size_calculator.php');?>
	</div>
	
</div>	
 
</div>
<div class="clearfix"></div> <br /> 
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/reflect/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/reflect/action3" class="btn btn-info">Next Action3 >></a>
	</div>
</div> 	