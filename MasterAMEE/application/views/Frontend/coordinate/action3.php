<?php include(APPPATH.'views/Frontend/coordinate/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<?php 
$department_id = $this->session->userdata('dept_id');	
$upslo_no_count = get_count_plsos_for_underg_grad_h($department_id,'0');
$gpslo_no_count = get_count_plsos_for_underg_grad_h($department_id,'1'); 
$plo_no_count = get_count_plsos_for_underg_grad_h($department_id,'2'); 

$ucourses_count = get_count_courses_for_underg_grad_h($department_id,'0');
$gcourses_count = get_count_courses_for_underg_grad_h($department_id,'1'); 
$program_count = get_count_courses_for_underg_grad_h($department_id,'2'); 
$dropdown_matrix_options = get_department_course_matrix_options_h();
?>
<div class="box action3_allignment_matrix">
<div class="nrow">	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#undergraduates_allignment_matrix">Undergraduate Program </a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#graduates_allignment_matrix">Graduate Program</a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="#program_allignment_matrix">Program / Interventions</a></li>
	</ul>
	<div id="undergraduates_allignment_matrix" class="subcontent margin20"  style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
		<div class="col-md-12">
			<div class="contenttitle2 nomargintop">
				<h3> Alignment Matrix for Undergraduate Program</h3>
			</div>
			
			<?php if(isset($upslo_no_count) && $upslo_no_count>0 && isset($ucourses_count) && $ucourses_count>0){
					include(APPPATH.'views/Frontend/coordinate/undergraduate_alimnt_matrix.php');
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
 	
	<div id="graduates_allignment_matrix" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>;">
		<div class="col-md-12">
			<div class="contenttitle2 nomargintop">
				<h3> Alignment Matrix for Graduate Program</h3>
			</div>
				
			<?php if(isset($gpslo_no_count) && $gpslo_no_count>0 && isset($gcourses_count) && $gcourses_count>0){
					include(APPPATH.'views/Frontend/coordinate/graduate_alimnt_matrix.php');
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
	
	<div id="program_allignment_matrix" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'block';}else{echo 'none';}?>;">
		<div class="col-md-12">
			<div class="contenttitle2 nomargintop">
				<h3>Program / Interventions</h3>
			</div>
				
			<?php if(isset($plo_no_count) && $plo_no_count>0 && isset($program_count) && $program_count>0){
					include(APPPATH.'views/Frontend/coordinate/program_alimnt_matrix.php');
				}else{
					if(isset($plo_no_count) && $plo_no_count==0){
						echo '<h4 class="padding10"><i>-- no learning outcome available for program learning outcome --</i> <a href="'.base_url().'department/envision/action2?tab_id=5" class="btn btn-default" style="padding:4px 15px; font-size:15px;"> Add Program Learning Outcome Now!</a></h4></h4>';
					}
					if(isset($program_count) && $program_count==0){
						echo '<h4 class="padding10"><i>-- no courses available for program --</i> <a href="'.base_url().'department/coordinate/action2?tab_id=3" class="btn btn-default" style="padding:4px 15px; font-size:15px;"> Add Program Alignment Matrix Now!</a></h4></h4>';
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
		<a href="<?php echo base_url();?>department/coordinate/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/coordinate/action2" class="btn btn-info"><< Previous Action2</a>
	</div>
</div> 