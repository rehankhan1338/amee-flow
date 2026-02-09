<style type="text/css">
	#assignment_configuration h4{ font-weight:600; font-size:15px;}
	#assignment_configuration{ margin:10px 20px;}
	.contenttitle2{margin:10px 0;border-bottom: 2px dotted #FB9337;}
	option{padding:5px;}
</style>


<div id="assignment_configuration" class="subcontent" >
<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/add_course" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Interventions Data </h3>
		</div>
		<?php $rubric_builder_intervention_data=$this->config->item('rubric_builder_intervention_data_config');?>
		<input type="hidden" name="ar_id" value="<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!=''){echo $_GET['ar_id']; }?>" />
		
		<?php if(count($assignments_rubrics_course_detail)>0){ //print_r($assignments_rubrics_course_detail); die;?>
		<?php $j=1; foreach($assignments_rubrics_course_detail as $course_detail){?>
			
		<div  class="docfields">
			<input type="hidden" name="edit_course_count[]" id="edit_course_count[]" value="<?php echo $course_detail->id;?>" />
					
			<div class="col-md-3 form-group">
				<label for="inputEmail3"><h4>Course/Program/Intervention #<?php echo $j;?></h4></label>
				<input type="text" name="course_enrolled_edit_<?php echo $course_detail->id;?>" id="course_enrolled_1" value="<?php if(isset($course_detail->course_enrolled) && $course_detail->course_enrolled!=''){echo $course_detail->course_enrolled;} ?>" class="form-control required" placeholder="Insert the Name of core function" />
			</div>		

			<div class="col-md-2 form-group">
				<label for="inputEmail3"><h4>SLO Approaches</h4></label>
				<select name="course_i_edit_<?php echo $course_detail->id;?>" id="course_i_1" class="form-control required">
					<?php $dropdown_matrix_options = get_department_course_matrix_options_h(); 
						foreach($dropdown_matrix_options as $options){?>
							<option value="<?php echo $options->id;?>" <?php if(isset($course_detail->course_i) && $course_detail->course_i==$options->id){?> selected="selected" <?php }?> ><?php echo $options->matrix_options;?></option>
					<?php } ?>
				</select>
			</div>		

			<div class="col-md-3 form-group">
				<label for="inputEmail3"><h4> Intervention </h4></label>
				<select name="course_type_edit_<?php echo $course_detail->id;?>" id="course_type_1" class="form-control required">
					<option value="">Select...</option>
					<?php foreach($rubric_builder_intervention_data as $key => $value){ if($value['status']==0){?>
					<option value="<?php echo $key;?>" <?php if(isset($course_detail->course_type) && $course_detail->course_type==$key){?> selected="selected" <?php }?> ><?php echo $value['name'];?></option>
					<?php } }?>
				</select>
			</div>

			<div class="col-md-2 form-group">
				<label for="inputEmail3"><h4> PSLO Number</h4></label>
				<select name="pslo_number_edit_<?php echo $course_detail->id;?>" id="pslo_number_1" class="form-control required">
					<?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?>
						<option value="<?php echo $pslos_undergraduate->id;?>" <?php if(isset($course_detail->pslo_number) && $course_detail->pslo_number==$pslos_undergraduate->id){?> selected="selected" <?php }?> ><?php echo $pslos_undergraduate->plso_prefix; ?></option>
					<?php } ?>
					<?php foreach($department_pslos_graduate as $pslos_graduate){?>
						<option value="<?php echo $pslos_graduate->id;?>" <?php if(isset($course_detail->pslo_number) && $course_detail->pslo_number==$pslos_graduate->id){?> selected="selected" <?php }?> ><?php echo $pslos_graduate->plso_prefix; ?></option>
					<?php } ?>
				</select>
			</div>	
			
			<div class="col-md-2 form-group">
				<label for="inputEmail3"><h4>&nbsp;</h4></label>
				<br><a href="<?php echo base_url();?>assignments_rubrics/delete_course?ar_id=<?php echo $course_detail->ar_id;?>&id=<?php echo $course_detail->id;?>" style="margin-top: 1px;" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Delete #<?php echo $j;?>?');">Delete #<?php echo $j;?></a>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php $j++; } ?>
		<?php } else{ ?>
	
	
	
		<div class="docfields">
			<div class="col-md-3 form-group">
				<label for="inputEmail3"><h4>Course/Program/Intervention #1</h4></label>
				<input type="text" name="course_enrolled_1" id="course_enrolled_1" value="" class="form-control required"  placeholder="Insert the Name of core function" />
			</div>		

			<div class="col-md-2 form-group">
				<label for="inputEmail3"><h4>SLO Approaches</h4></label>
				<select name="course_i_1" id="course_i_1" class="form-control required">
					<option value="">--select--</option>
					<?php $dropdown_matrix_options = get_department_course_matrix_options_h(); 
						foreach($dropdown_matrix_options as $options){?>
							<option value="<?php echo $options->id;?>"><?php echo $options->matrix_options;?></option>
					<?php } ?>
				</select>
			</div>		

			<div class="col-md-3 form-group">
				<label for="inputEmail3"><h4> Intervention </h4></label>
				<select name="course_type_1" id="course_type_1" class="form-control required">
					<option value="">Select...</option>
					<?php foreach($rubric_builder_intervention_data as $key => $value){ if($value['status']==0){?>
					<option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
					<?php } }?>
				</select>
			</div>
		
			<div class="col-md-2 form-group">
				<label for="inputEmail3"><h4> PSLO Number </h4></label>
				<select name="pslo_number_1" id="pslo_number_1" class="form-control required">
					<option value="">Select...</option>
					<?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?>
						<option value="<?php echo $pslos_undergraduate->id;?>"  ><?php echo $pslos_undergraduate->plso_prefix; ?></option>
					<?php } ?>
					<?php foreach($department_pslos_graduate as $pslos_graduate){?>
						<option value="<?php echo $pslos_graduate->id;?>" ><?php echo $pslos_graduate->plso_prefix; ?></option>
					<?php } ?>
				</select>
			</div>			
		</div>
	<?php } ?>
		
		<div class="clearfix"></div>
		<div id="load_docs"></div>
		<div class="col-md-12">
			<a class="btn btn-success btn-sm pull-right" style="margin-top:20px; font-size:13px" onclick="return add_more_core_function();">Add Interventions</a>
		</div>
	</div>
     
	<div class="form-group">
		<button type="submit" class="btn btn-primary margin20" name="submit_login">Save and Continue</button>
	</div>
</form>
</div>


<script type="text/javascript">
function add_more_core_function(){
	var n = jQuery(".docfields").length;
	var cnt = n+1; 
	var html ='<div class="docfields"><div class="col-md-3 form-group"><label for="inputEmail3"><h4>Course/Program/Intervention # '+cnt+'</h4></label><input type="text" name="course_enrolled_add_more_'+cnt+'" class="form-control required" placeholder="Insert the Name of core function" /></div>';
	var html =html+'<div class="col-md-2 form-group"><label for="inputEmail3"><h4>SLO Approaches</h4></label><select name="course_i_add_more_'+cnt+'" id="course_i_add_more_'+cnt+'" class="form-control required"><option value="">--select--</option><?php $dropdown_matrix_options = get_department_course_matrix_options_h();foreach($dropdown_matrix_options as $options){?><option value="<?php echo $options->id;?>"><?php echo $options->matrix_options;?></option><?php } ?></select></div>';
	var html =html+'<div class="col-md-3 form-group"><label for="inputEmail3"><h4> Course </h4></label><select name="course_type_add_more_'+cnt+'" id="course_type_add_more_'+cnt+'" class="form-control required"><option value="">Select...</option><?php foreach($rubric_builder_intervention_data as $key => $value){ if($value['status']==0){?><option value="<?php echo $key;?>"><?php echo $value['name'];?></option><?php } }?></select></div>';
	var html =html+'<div class="col-md-2 form-group"><label for="inputEmail3"><h4> PSLO Number </h4></label><select name="pslo_number_add_more_'+cnt+'" id="pslo_number_add_more_'+cnt+'" class="form-control required"><option value="">--select--</option><?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?><option value="<?php echo $pslos_undergraduate->id;?>"  ><?php echo $pslos_undergraduate->plso_prefix; ?></option><?php } ?><?php foreach($department_pslos_graduate as $pslos_graduate){?><option value="<?php echo $pslos_graduate->id;?>" ><?php echo $pslos_graduate->plso_prefix; ?></option><?php } ?></select></div><input type="hidden" name="add_more_count[]" id="add_more_count[]" value="'+cnt+'" />';

	html = html+'<div class="col-md-2 form-group"><label for="inputEmail3"><h4>&nbsp;</h4></label><br><a style="margin-top: 1px;" class="btn btn-sm btn-danger" onclick="javascript:removeField(this);">Remove</a></div></div><div class="clearfix"></div>';
	jQuery('#load_docs').append(html);
}

function removeField(element){
	jQuery(element).closest(".docfields").remove();
}
</script> 


