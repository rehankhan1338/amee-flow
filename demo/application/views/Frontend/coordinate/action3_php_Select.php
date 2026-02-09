<?php include(APPPATH.'views/Frontend/coordinate/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<?php 
$department_id = $this->session->userdata('dept_id');	

$upslos_gpslos_count = get_count_plsos_for_underg_grad_h($department_id);
$upslo_no_count = $upslos_gpslos_count->upslo_no;
$gpslo_no_count = $upslos_gpslos_count->gpslo_no;


$dropdown_matrix_options = get_department_course_matrix_options_h();
?>
<div class="box action3_allignment_matrix">

<div class="nrow">	
		<ul class="hornav">
			<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#undergraduates_allignment_matrix">Alignment Matrix for Undergraduate Program </a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#graduates_allignment_matrix">Alignment Matrix for Graduate Program</a></li>
		</ul>

		<div id="undergraduates_allignment_matrix" class="subcontent margin20"  style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
			<div class="col-md-12">
				<div class="contenttitle2 nomargintop">
					<h3> Alignment Matrix for Undergraduate Program</h3>
				</div>
		<!--		<a onclick="return open_model_coordinate_add('0');" class="btn btn-primary pull-right" style="padding:2px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>-->
				<form method="post" action="<?php echo base_url();?>coordinate/save_undergraduate_allignment_matrix">
				<table class="table table-bordered" style="font-size:16px;">
					<tr style="background:#566680; color:#f5f5f5;">
						<td rowspan="2" style="text-align:center; line-height:40px;"><b>LEARNING OUTCOMES</b> <br />(I = Introduce; E=Emphasizing, D = Developing; M = Mastering, P=Practicing)</td>
						<td colspan="7" style="text-align:center; padding:10px;"><b>REQUIRED COURSES</b></td>
					</tr>
					<tr style="background:#566680; color:#f5f5f5; text-align:center">
						<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){?>
						<td><?php echo $undergraduate_courses->course_prefix;?> <br /><?php echo $undergraduate_courses->course_number;?></td>
						<?php } ?>
					</tr>
					
					<?php foreach($department_pslos_undergraduate as $undergraduate_pslos){?>
						<tr>
							<td  style="vertical-align:middle">
							<input type="hidden" name="upslos[]" id="upslos[]" value="<?php echo $undergraduate_pslos->id;?>" />
							<i><?php echo $undergraduate_pslos->plso_title;?></i> <?php echo $undergraduate_pslos->id;?></td>
							<?php foreach($department_courses_result_undergraduate as $undergraduate_courses){
							  
							$kl=0;
							
							foreach($dropdown_matrix_options as $matrix_options){
							
								$matrix_option_count = get_count_allignment_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id,$matrix_options->id);
								
 								if($kl==0){
								
									if($matrix_option_count>0){
										$bg_color = get_colorcode_matrix_option_h($department_id,$undergraduate_pslos->id,$undergraduate_courses->id);
										$style_backgroung_td = 'background:#'.$bg_color;
									}else{
										$style_backgroung_td = 'background:none;';
									}
									
									$undergradute_matrix_dropdown_list = '<td style="'.$style_backgroung_td.';"><select class="form-control" name="'.$undergraduate_pslos->id.'ucourses_'.$undergraduate_courses->id.'" id="ucourses_'.$undergraduate_courses->id.'" >';
									$undergradute_matrix_dropdown_list.= '<option value="">N/A</option>';
								
								}
								
								if($matrix_option_count>0){
 									$selected = 'selected="selected"';
								}else{
 									$selected = '';
 								}
								
								$undergradute_matrix_dropdown_list.='<option value="'.$matrix_options->id.'" '.$selected.'>'.$matrix_options->matrix_options.'</option>';
								 
 							$kl++; }
							
							echo $undergradute_matrix_dropdown_list.='</select></td>';
							
						  ?>
							
							<?php } ?>
						</tr>
					<?php } ?>
				</table>
				<div class="clearfix"></div>
 					<div class="box-footer">
						<input type="submit" name="coordinate_save" class="btn btn-primary" value='Save & Update' />
					</div>
				</form>
			</div>
		</div>		
		
		
		<div id="graduates_allignment_matrix" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>;">
			<div class="col-md-12">
				<div class="contenttitle2 nomargintop">
					<h3> Alignment Matrix for Graduate Program</h3>
				</div>
					
					
				 
			
			</div>
		</div>
	</div>
	
	
 <p>&nbsp;</p>
 <p>&nbsp;</p>
</div>	