<style type="text/css"> 
.multiselect{
margin:10px 0;
}
.selectBox {
  position: relative;
}
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
#undergraduate_checkboxes {
display: none;
border: 1px #dadada solid;
position:absolute;
width:100%;
z-index:999;
background: #485b79 url(../images/default/headerbg.png);
}
#undergraduate_checkboxes label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px;
}
#undergraduate_checkboxes label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
#undergraduate_checkboxes1 {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:100%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#undergraduate_checkboxes1 label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px;
  }
#undergraduate_checkboxes1 label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
option{padding:5px;}
</style>

<script type="text/javascript">
var expanded = false;
 
function undergraduate_showCheckboxes() {
  var checkboxes = document.getElementById("undergraduate_checkboxes");
  if (!expanded) {
  	jQuery('#undergraduate_indirect_assesment').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#undergraduate_indirect_assesment').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
function undergraduate_showCheckboxes1() {
  var checkboxes = document.getElementById("undergraduate_checkboxes1");
  if (!expanded) {
  	jQuery('#undergraduate_direct_assesment').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#undergraduate_direct_assesment').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>

<div class="clearfix"></div>
<div class="row">
<div class="col-md-12">
	<div class="col-md-3"><h4>Direct Assessment Measures</h4>
	<?php $master_direct_assessment_list = get_master_direct_assessment_h();?>
	
	<div class="multiselect">
		<div class="selectBox" onclick="undergraduate_showCheckboxes1()">
			<select class="form-control required" id="undergraduate_direct_assesment" name="undergraduate_direct_assesment">
				<option value="">-- Select --</option>
			</select>
			<div class="overSelect"></div>
		</div>
		<div id="undergraduate_checkboxes1">
		
			<?php if(isset($checklist_detail->undergraduate_DAM) && $checklist_detail->undergraduate_DAM!=''){
					$undergraduate_DAM_arr = explode(',',$checklist_detail->undergraduate_DAM);
				}else{
					$undergraduate_DAM_arr = array();
				}
				foreach($master_direct_assessment_list as $direct_assessment_details){?>
				<label for="undergraduate_<?php echo $direct_assessment_details->name;?>">
				<input type="checkbox" name="undergraduate_direct_assesment_show[]" class="undergraduate_case1" id="undergraduate_<?php echo $direct_assessment_details->name;?>" <?php if(in_array($direct_assessment_details->id,$undergraduate_DAM_arr)){?> checked="checked" <?php } ?> value="<?php echo $direct_assessment_details->id;?>" /> &nbsp;&nbsp;<?php echo $direct_assessment_details->name;?></label>
			<?php } ?> 
		</div>
	</div>
	
		
	</div>
	
	<div class="col-md-3"><h4>Indirect Assessment Measures</h4>
	<?php $master_indirect_assessment_list = get_master_indirect_assessment_h();?>
	
	<div class="multiselect">
		<div class="selectBox" onclick="undergraduate_showCheckboxes()">
			<select class="form-control required" id="undergraduate_indirect_assesment" name="undergraduate_indirect_assesment">
				<option value="">-- Select --</option>
			</select>
			<div class="overSelect"></div>
		</div>
		<div id="undergraduate_checkboxes">
		
			<?php if(isset($checklist_detail->undergraduate_INDAM) && $checklist_detail->undergraduate_INDAM!=''){
					$undergraduate_INDAM_arr = explode(',',$checklist_detail->undergraduate_INDAM);
				}else{
					$undergraduate_INDAM_arr = array();
				}
				foreach($master_indirect_assessment_list as $direct_inassessment_details){?>
				<label for="undergraduate_<?php echo $direct_inassessment_details->name;?>">
				<input type="checkbox" name="undergraduate_indirect_assesment_show[]" class="undergraduate_case" id="undergraduate_<?php echo $direct_inassessment_details->name;?>"  <?php if(in_array($direct_inassessment_details->id,$undergraduate_INDAM_arr)){?> checked="checked" <?php } ?> value="<?php echo $direct_inassessment_details->id;?>" /> &nbsp;&nbsp;<?php echo $direct_inassessment_details->name;?></label>
			<?php } ?> 
		</div>
	</div>
	
		
	</div>
	
	<div class="col-md-3">
	
		<div class="form-group">
				<label for="inputEmail3">&nbsp;</label>
				<a class="btn btn-primary pull-left"  style="margin-top: 28px;"  onclick="return update_undergraduate_assesment_measure_columns();">Display Now!</a>
			</div>
	</div>
	
</div>
</div>
<script type="text/javascript">
	function update_undergraduate_assesment_measure_columns(){
		var new_array=[];
		jQuery(".undergraduate_case:checked").each(function() {
			var n_total=jQuery(this).val();
			new_array.push(n_total);
		}); 
		
		var new_array1=[];
		jQuery(".undergraduate_case1:checked").each(function() {
			var n_total1=jQuery(this).val();
			new_array1.push(n_total1);
		});
		
		window.location = '<?php echo base_url();?>reflect/update_assesment_measure_columns?dam='+new_array1+'&indam='+new_array+'&underg_grad_status=<?php echo $undergraduate_status_value;?>';
		
	}
</script>
<form method="post" action="<?php echo base_url();?>reflect/save_undergraduate_measurement_benchmark_tabular">
	<?php foreach($undergraduate_DAM_arr as $undergraduate_DAM){?>
	<input type="hidden" name="undergraduate_dam[]" id="undergraduate_dam[]" value="<?php echo $undergraduate_DAM;?>" />
	<?php } ?>
	<?php foreach($undergraduate_INDAM_arr as $undergraduate_INDAM){?>
	<input type="hidden" name="undergraduate_indam[]" id="undergraduate_indam[]" value="<?php echo $undergraduate_INDAM;?>" />
	<?php } ?>
	<table class="table table-bordered mart10">
	
	<tr class="trbg">
		<th rowspan="2" class="rowspan" style="vertical-align:middle;">Year</th>
		<th rowspan="2" class="rowspan" style="vertical-align:middle;">PSLO</th>
		<th rowspan="2" class="rowspan" style="vertical-align:middle;">Course</th>
		<th class="recourses" nowrap="nowrap" colspan="<?php echo count($undergraduate_DAM_arr);?>">Direct Assessment</th>
		<th class="recourses" nowrap="nowrap" colspan="<?php echo count($undergraduate_INDAM_arr);?>">Indirect Assessment</th>
		<th rowspan="2" class="rowspan" style="vertical-align:middle;" >Criteria</th>
		<th rowspan="2" class="rowspan" style="vertical-align:middle;" nowrap="nowrap" width="5%">Sample Size</th>
	</tr>
	
	<tr class="trbg">
		
		<?php foreach($undergraduate_DAM_arr as $undergraduate_DAM){?>
		<th class="tdborder" style="text-align:center;"><?php echo get_master_direct_assessment_codename_h($undergraduate_DAM); ?></th>
		<?php } ?>
			
		<?php foreach($undergraduate_INDAM_arr as $undergraduate_INDAM){?>
		<th class="tdborder" style="text-align:center;"><?php echo get_master_indirect_assessment_codename_h($undergraduate_INDAM); ?></th>
		<?php } ?>
 		
	</tr>
	
	<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){
	
		$academic_year = $rpy+1;
		
		$benchmark_tabuler_details = get_benchmark_tabuler_details_h($department_id,$academic_year,$undergraduate_status_value);
		
		?>
		
		<tr>
			<td nowrap="nowrap"><input type="hidden" name="hyear_id[]" id="hyear_id[]" value="<?php echo $academic_year;?>" />
			<?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<td nowrap="nowrap">
				<?php
 					$plsos_details_data = get_plsos_details_from_year_id_h($department_id,$undergraduate_status_value,$academic_year,$undergraduate_rotation_plan_status);
					foreach($plsos_details_data as $plsos_details){
						echo '<p style="margin:5px 0;" class="">'.get_plsos_name_from_plso_id_h($plsos_details->plso_id).'</p>';
 					}
				?>
			</td>
			<td nowrap="nowrap">
				<?php
 					$courses_details_data = get_courses_details_from_year_id_h($department_id,$undergraduate_status_value,$academic_year,$undergraduate_rotation_plan_status);
					foreach($courses_details_data as $courses_details){
						$course_arr = explode(',',$courses_details->course_id);
						for($i=0;$i<count($course_arr);$i++){
							echo '<p style="margin:5px 0;" class="">'.get_course_name_from_course_id_h($course_arr[$i]).'</p>';
						}
					}
				?>
			</td>
<?php foreach($undergraduate_DAM_arr as $undergraduate_DAM){

	if(isset($benchmark_tabuler_details->dam) && $benchmark_tabuler_details->dam!=''){
		$selected_dam_arr = explode(',',$benchmark_tabuler_details->dam);
	}else{
		$selected_dam_arr = array();
	}
?>
<td style="text-align:center; vertical-align:middle">
 <input type="checkbox" name="undergraduate_dam_<?php echo $undergraduate_DAM.$academic_year;?>" value="<?php echo $undergraduate_DAM;?>" <?php if(in_array($undergraduate_DAM,$selected_dam_arr)){?> checked="checked" <?php } ?> />
</td>
<?php } ?>

<?php foreach($undergraduate_INDAM_arr as $undergraduate_INDAM){

	if(isset($benchmark_tabuler_details->indam) && $benchmark_tabuler_details->indam!=''){
		$selected_indam_arr = explode(',',$benchmark_tabuler_details->indam);
	}else{
		$selected_indam_arr = array();
	}
?>
<td style="text-align:center; vertical-align:middle">
<input type="checkbox" name="undergraduate_indam_<?php echo $undergraduate_INDAM.$academic_year;?>" value="<?php echo $undergraduate_INDAM;?>" <?php if(in_array($undergraduate_INDAM,$selected_indam_arr)){?> checked="checked" <?php } ?> />
</td>
<?php } ?>
	<td><input type="text" class="form-control" name="undergraduate_criteria_<?php echo $academic_year;?>" id="undergraduate_criteria_<?php echo $academic_year;?>" value="<?php if(isset($benchmark_tabuler_details->criteria) && $benchmark_tabuler_details->criteria!=''){ echo $benchmark_tabuler_details->criteria;}?>" /></td>
	<td><input type="text" class="form-control" name="undergraduate_sample_size<?php echo $academic_year;?>" id="undergraduate_sample_size<?php echo $academic_year;?>" value="<?php if(isset($benchmark_tabuler_details->sample_size) && $benchmark_tabuler_details->sample_size!=''){ echo $benchmark_tabuler_details->sample_size;}?>" /></td>
</tr>
	
<?php  } ?>	
		
</table>
<div>
		<input type="submit" name="save_undergraduate_measurement_benchmark_tabular" id="save_undergraduate_measurement_benchmark_tabular" value="Save & Update" class="btn btn-primary" />
	</div>
</form>