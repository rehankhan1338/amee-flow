<style type="text/css"> 
 
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
option{padding:3px;}
</style>

<script type="text/javascript">
var expanded = false;
</script>

<div class="clearfix"></div>

<form method="post" action="<?php echo base_url();?>reflect/save_graduate_measurement_benchmark_tabular">
	<?php $master_direct_assessment_list = get_master_direct_assessment_h();?>
	<?php $master_indirect_assessment_list = get_master_indirect_assessment_h();?> 
	<table class="table table-bordered ">
	
	<tr class="trbg">
		<th class="rowspan" style="vertical-align:middle;">Year</th>
		<th class="rowspan" style="vertical-align:middle;">PLO</th>
		<th class="rowspan" style="vertical-align:middle;">Course/Program</th>
		<th class="recourses" width="22.3%" nowrap="nowrap" colspan="<?php //echo count($graduate_DAM_arr);?>">Direct Measures <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $this->config->item('reflect_sec_info_Direct_Measures');?>"></i></th>
		<th class="recourses" width="22.3%" nowrap="nowrap" colspan="<?php //echo count($graduate_INDAM_arr);?>">Indirect Measures <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $this->config->item('reflect_sec_info_Indirect_Measures');?>"></i></th>
		<th class="rowspan" style="vertical-align:middle;" >Criteria <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $this->config->item('reflect_sec_info_Criteria');?>"></i></th>
		<th class="rowspan" style="vertical-align:middle;" nowrap="nowrap" width="5%">Sample Size <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="<?php echo $this->config->item('reflect_sec_info_Sample_Size');?>"></i></th>
	</tr>
	 
	
	<?php for($rpy=0;$rpy<$rotation_plan_count;$rpy++){
	
		$academic_year = $rpy+1;
		
		$benchmark_tabuler_details = get_benchmark_tabuler_details_h($department_id,$academic_year,$graduate_status_value);
		
		?>
		
		<tr>
			<td nowrap="nowrap"><input type="hidden" name="hyear_id[]" id="hyear_id[]" value="<?php echo $academic_year;?>" />
			<?php echo $rotation_plan_start_year+$rpy.' / '.(($rotation_plan_start_year+$rpy)+1);?></td>
			<td nowrap="nowrap">
				<?php
 					$plsos_details_data = get_plsos_details_from_year_id_h($department_id,$graduate_status_value,$academic_year,$graduate_rotation_plan_status);
					foreach($plsos_details_data as $plsos_details){
						echo '<p style="margin:5px 0;" class="">'.get_plsos_name_from_plso_id_h($plsos_details->plso_id).'</p>';
 					}
				?>
			</td>
			<td nowrap="nowrap">
				<?php
 					$courses_details_data = get_courses_details_from_year_id_h($department_id,$graduate_status_value,$academic_year,$graduate_rotation_plan_status);
					foreach($courses_details_data as $courses_details){
						$course_arr = explode(',',$courses_details->course_id);
						for($i=0;$i<count($course_arr);$i++){
							echo '<p style="margin:5px 0;" class="">'.get_course_name_from_course_id_h($course_arr[$i]).'</p>';
						}
					}
				?>
			</td>
<?php 

	$dam_name_arr=array();
	$selected_dam_arr = array();
	if(isset($benchmark_tabuler_details->dam) && $benchmark_tabuler_details->dam!=''){
		$selected_dam_arr = explode(',',$benchmark_tabuler_details->dam);
		foreach($selected_dam_arr as $dam){
			$dam_name_arr[] = get_master_direct_assessment_title_h($dam);
		}
	}else{
		$selected_dam_arr = array();
		$dam_name_arr = array();
	}
?>
<td style="text-align:center; line-height:25px;">

<style type="text/css">
#graduate_checkboxes<?php echo $academic_year;?> {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:20.7%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#graduate_checkboxes<?php echo $academic_year;?> label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px; text-align:left;
  }
#graduate_checkboxes<?php echo $academic_year;?> label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
</style>
<script type="text/javascript">
function graduate_showCheckboxes<?php echo $academic_year;?>() {
  var checkboxes = document.getElementById("graduate_checkboxes<?php echo $academic_year;?>");
  if (!expanded) {
  	jQuery('#graduate_direct_assesment<?php echo $academic_year;?>').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#graduate_direct_assesment<?php echo $academic_year;?>').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<div class="multiselect">
	<div class="selectBox" onclick="graduate_showCheckboxes<?php echo $academic_year;?>()">
		<select class="form-control required" id="graduate_direct_assesment<?php echo $academic_year;?>" name="graduate_direct_assesment">
			<option value="">-- Select --</option>
		</select>
		<div class="overSelect"></div>
	</div>
	<div id="graduate_checkboxes<?php echo $academic_year;?>">
	
		<?php if(isset($checklist_detail->graduate_DAM) && $checklist_detail->graduate_DAM!=''){
				$graduate_DAM_arr = explode(',',$checklist_detail->graduate_DAM);
			}else{
				$graduate_DAM_arr = array();
			}
			foreach($master_direct_assessment_list as $direct_assessment_details){?>
			<label for="graduate_<?php echo $direct_assessment_details->name;?><?php echo $academic_year;?>">
			<input type="checkbox" name="graduate_dam<?php echo $academic_year;?>[]" class="" id="graduate_<?php echo $direct_assessment_details->name;?><?php echo $academic_year;?>" <?php if(in_array($direct_assessment_details->id,$selected_dam_arr)){?> checked="checked" <?php } ?> value="<?php echo $direct_assessment_details->id;?>" /> &nbsp;&nbsp;<?php echo $direct_assessment_details->name;?></label>
		<?php } ?> 
	</div>
</div>
<div style="margin:10px 0;font-weight:600;"><?php echo implode(', ',$dam_name_arr);?></div>
</td>
 

<?php  

	$indam_name_arr=array();
	$selected_indam_arr = array();
	if(isset($benchmark_tabuler_details->indam) && $benchmark_tabuler_details->indam!=''){
		$selected_indam_arr = explode(',',$benchmark_tabuler_details->indam);
		foreach($selected_indam_arr as $indam){
			$indam_name_arr[] = get_master_indirect_assessment_title_h($indam);
		}
	}else{
		$selected_indam_arr = array();
		$indam_name_arr = array();
	}
?>
<td style="text-align:center; line-height:25px;">
<style type="text/css">
#graduate_checkboxes_indam<?php echo $academic_year;?> {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:20.7%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#graduate_checkboxes_indam<?php echo $academic_year;?> label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px; text-align:left;
  }
#graduate_checkboxes_indam<?php echo $academic_year;?> label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
</style>
<script type="text/javascript">
function graduate_showCheckboxes_indam<?php echo $academic_year;?>() {
  var checkboxes = document.getElementById("graduate_checkboxes_indam<?php echo $academic_year;?>");
  if (!expanded) {
  	jQuery('#graduate_indirect_assesment<?php echo $academic_year;?>').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#graduate_indirect_assesment<?php echo $academic_year;?>').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<div class="multiselect">
	<div class="selectBox" onclick="graduate_showCheckboxes_indam<?php echo $academic_year;?>()">
		<select class="form-control required" id="graduate_indirect_assesment<?php echo $academic_year;?>" name="graduate_indirect_assesment">
			<option value="">-- Select --</option>
		</select>
		<div class="overSelect"></div>
	</div>
	<div id="graduate_checkboxes_indam<?php echo $academic_year;?>">
	
		<?php if(isset($checklist_detail->graduate_INDAM) && $checklist_detail->graduate_INDAM!=''){
				$graduate_INDAM_arr = explode(',',$checklist_detail->graduate_INDAM);
			}else{
				$graduate_INDAM_arr = array();
			}
			foreach($master_indirect_assessment_list as $direct_inassessment_details){?>
			<label for="lab_graduate_indam_<?php echo $direct_inassessment_details->name;?><?php echo $academic_year;?>">
			<input type="checkbox" name="graduate_indam<?php echo $academic_year;?>[]" id="lab_graduate_indam_<?php echo $direct_inassessment_details->name;?><?php echo $academic_year;?>"  <?php if(in_array($direct_inassessment_details->id,$selected_indam_arr)){?> checked="checked" <?php } ?> value="<?php echo $direct_inassessment_details->id;?>" /> &nbsp;&nbsp;<?php echo $direct_inassessment_details->name;?></label>
		<?php } ?> 
	</div>
</div>
<div style="margin:10px 0; font-weight:600;"><?php echo implode(', ',$indam_name_arr);?></div>
</td>
 
	<td>
	
		<textarea class="form-control" name="graduate_criteria_<?php echo $academic_year;?>" rows="3" style="resize:none;"  id="graduate_criteria_<?php echo $academic_year;?>"><?php if(isset($benchmark_tabuler_details->criteria) && $benchmark_tabuler_details->criteria!=''){ echo $benchmark_tabuler_details->criteria;}?></textarea>
	</td>
	<td><input type="text" class="form-control" name="graduate_sample_size<?php echo $academic_year;?>" id="graduate_sample_size<?php echo $academic_year;?>" value="<?php if(isset($benchmark_tabuler_details->sample_size) && $benchmark_tabuler_details->sample_size!=''){ echo $benchmark_tabuler_details->sample_size;}?>" /></td>
</tr>
	
<?php  } ?>	
		
</table>
<div>
		<input type="submit" name="save_graduate_measurement_benchmark_tabular" id="save_graduate_measurement_benchmark_tabular" value="Save & Update" class="btn btn-primary" />
	</div>
</form>