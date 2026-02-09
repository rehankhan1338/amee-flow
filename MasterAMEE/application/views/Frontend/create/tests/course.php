<style type="text/css">
	#test_configuration h4{ font-weight:600; font-size:15px;}
	#test_configuration{ margin:10px 20px;}
	.contenttitle2{margin:10px 0;border-bottom: 2px dotted #FB9337;}
	option{padding:5px}
</style>


<div id="test_configuration" class="subcontent" >
<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>tests/add_course" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Course / Program Data</h3>
		</div>
		<div class="instructions"><strong>Instruction:</strong> Identify the courses/programs for which this test will be administered to.</div>
		<input type="hidden" name="test_id" value="<?php if(isset($_GET['test_id']) && $_GET['test_id']!=''){echo $_GET['test_id']; }?>" />
		
		<?php if(count($tests_course_detail)>0){ //print_r($tests_course_detail); die;?>
		<?php $j=1; foreach($tests_course_detail as $course_detail){?>
			
		<div style="line-height:40px;" class="docfields">
			<input type="hidden" name="edit_course_count[]" id="edit_course_count[]" value="<?php echo $course_detail->id;?>" />
					
			<div class="col-md-3">
				<label for="inputEmail3"><h4>Course/Program measured #<?php echo $j;?></h4></label>
				<input type="text" name="course_enrolled_edit_<?php echo $course_detail->id;?>" id="course_enrolled_1" value="<?php if(isset($course_detail->course_enrolled) && $course_detail->course_enrolled!=''){echo $course_detail->course_enrolled;} ?>" class="form-control required" placeholder="Insert the Name of course" />
			</div>		

			<div class="col-md-2">
				<label for="inputEmail3"><h4> SLO Approaches </h4></label>
				<select name="course_i_edit_<?php echo $course_detail->id;?>" id="course_i_1" class="form-control required">
					<?php $dropdown_matrix_options = get_department_course_matrix_options_h(); 
						foreach($dropdown_matrix_options as $options){?>
							<option value="<?php echo $options->id;?>" <?php if(isset($course_detail->course_i) && $course_detail->course_i==$options->id){?> selected="selected" <?php }?> ><?php echo $options->matrix_options;?></option>
					<?php } ?>
				</select>
			</div>		

			<div class="col-md-3">
				<label for="inputEmail3"><h4> Course / Program </h4></label>
				<select name="course_type_edit_<?php echo $course_detail->id;?>" id="course_type_1" class="form-control required">
					<option value="1" <?php if(isset($course_detail->course_type) && $course_detail->course_type=='1'){?> selected="selected" <?php }?> >Graduate</option>
					<option value="2" <?php if(isset($course_detail->course_type) && $course_detail->course_type=='2'){?> selected="selected" <?php }?> >Undergraduate</option>
					<option value="3" <?php if(isset($course_detail->course_type) && $course_detail->course_type=='3'){?> selected="selected" <?php }?> >Undergraduate/Graduate</option>
					<option value="4" <?php if(isset($course_detail->course_type) && $course_detail->course_type=='4'){?> selected="selected" <?php }?> >High School</option>
					<option value="5" <?php if(isset($course_detail->course_type) && $course_detail->course_type=='5'){?> selected="selected" <?php }?> >Elementary School</option>
				</select>
			</div>

			<div class="col-md-2">
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
			
			<div class="col-md-2">
				<label for="inputEmail3"><h4>&nbsp;</h4></label>
				<br><a href="<?php echo base_url();?>tests/delete_course?test_id=<?php echo $course_detail->test_id;?>&id=<?php echo $course_detail->id;?>" style="margin-top: 1px;" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Delete #<?php echo $j;?>?');">Delete #<?php echo $j;?></a>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php $j++; } ?>
		<?php } else{ ?>
	
	
	
		<div style="line-height:40px;" class="docfields">
			<div class="col-md-3">
				<label for="inputEmail3"><h4>Course/Program measured #1</h4></label>
				<input type="text" name="course_enrolled_1" id="course_enrolled_1" value="" class="form-control required" placeholder="Insert the Name of course" />
			</div>		

			<div class="col-md-2">
				<label for="inputEmail3"><h4> SLO Approaches </h4></label>
				<select name="course_i_1" id="course_i_1" class="form-control required">
					<option value="">--select--</option>
					<?php $dropdown_matrix_options = get_department_course_matrix_options_h(); 
						foreach($dropdown_matrix_options as $options){?>
							<option value="<?php echo $options->id;?>"><?php echo $options->matrix_options;?></option>
					<?php } ?>
				</select>
			</div>		

			<div class="col-md-3">
				<label for="inputEmail3"><h4> Course / Program </h4></label>
				<select name="course_type_1" id="course_type_1" class="form-control required">
					<option value="">--select--</option>
					<option value="1">Graduate</option>
					<option value="2">Under-Graduate</option>
					<option value="3">Undergraduate/Graduate</option>
					<option value="4">High School</option>
					<option value="5">Elementary School</option>

				</select>
			</div>
		
			<div class="col-md-2">
				<label for="inputEmail3"><h4> PSLO Number</h4></label>
				
				<select name="pslo_number_1" id="pslo_number_1" class="form-control required">
					<option value="">--select--</option><?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?><option value="<?php echo $pslos_undergraduate->id;?>"  ><?php echo $pslos_undergraduate->plso_prefix; ?></option><?php } ?><?php foreach($department_pslos_graduate as $pslos_graduate){?><option value="<?php echo $pslos_graduate->id;?>" ><?php echo $pslos_graduate->plso_prefix; ?></option><?php } ?>
				</select>
			</div>			
		</div>
	<?php } ?>
		
		<div class="clearfix"></div>
		<div id="load_docs" style="line-height:40px;"></div>
		<div class="col-md-12">
			<a class="btn btn-success btn-sm pull-right" style="margin-top:20px; font-size:13px" onclick="return add_more_core_function();">Add More Lines</a>
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
	var html ='<div class="docfields"><div class="col-md-3"><label for="inputEmail3"><h4>Course(s) currently enrolled # '+cnt+'</h4></label><input type="text" name="course_enrolled_add_more_'+cnt+'" class="form-control required" placeholder="Insert the Name of course" /></div>';
	var html =html+'<div class="col-md-2"><label for="inputEmail3"><h4> SLO Approaches </h4></label><select name="course_i_add_more_'+cnt+'" id="course_i_add_more_'+cnt+'" class="form-control required"><option value="">--select--</option><?php $dropdown_matrix_options = get_department_course_matrix_options_h();foreach($dropdown_matrix_options as $options){?><option value="<?php echo $options->id;?>"><?php echo $options->matrix_options;?></option><?php } ?></select></div>';
	var html =html+'<div class="col-md-3"><label for="inputEmail3"><h4> Course </h4></label><select name="course_type_add_more_'+cnt+'" id="course_type_add_more_'+cnt+'" class="form-control required"><option value="">--select--</option><option value="1">Graduate</option><option value="2">Under-Graduate</option><option value="3">Undergraduate/Graduate</option><option value="4">High School</option><option value="5">Elementary School</option></select></div>';
	var html =html+'<div class="col-md-2"><label for="inputEmail3"><h4> PSLO Number </h4></label><select name="pslo_number_add_more_'+cnt+'" id="pslo_number_add_more_'+cnt+'" class="form-control required"><option value="">--select--</option><?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?><option value="<?php echo $pslos_undergraduate->id;?>"  ><?php echo $pslos_undergraduate->plso_prefix; ?></option><?php } ?><?php foreach($department_pslos_graduate as $pslos_graduate){?><option value="<?php echo $pslos_graduate->id;?>" ><?php echo $pslos_graduate->plso_prefix; ?></option><?php } ?></select></div><input type="hidden" name="add_more_count[]" id="add_more_count[]" value="'+cnt+'" />';

	html = html+'<div class="col-md-2"><label for="inputEmail3"><h4>&nbsp;</h4></label><br><a style="margin-top: 1px;" class="btn btn-sm btn-danger" onclick="javascript:removeField(this);">Remove</a></div></div><div class="clearfix"></div>';
	jQuery('#load_docs').append(html);
}

function removeField(element){
	jQuery(element).closest(".docfields").remove();
}
</script> 


