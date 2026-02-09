<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3>  Unit Effectiveness Data : : <?php if(isset($effectiveness_data->academic_unit_name) && $effectiveness_data->academic_unit_name!=''){ echo ucwords($effectiveness_data->academic_unit_name);}else{ echo 'Add';}?></h3>
	<div class="btn_div">
		<a class="btn btn-default" href="<?php echo base_url();?>department/create/effectiveness_data">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
	</div>
 </div>
  <style type="text/css">
 	.unit_analysis_page h4{ font-weight:600; font-size:16px; margin:5px 0;}
 </style>
<div class="box unit_analysis_page">

	<div class="box-body">
		<div class="nrow">	
			<ul class="hornav">
			
				<li class="<?php if(!isset($_GET['tab'])){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/effectiveness_data/manage<?php if(isset($_GET['data_id']) && $_GET['data_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?data_id='.$_GET['data_id'].'&dept_id='.$_GET['dept_id'];}?>">Set up Effectiveness Data</a></li>
				
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==2){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/effectiveness_data/manage?tab=2<?php if(isset($_GET['data_id']) && $_GET['data_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&data_id='.$_GET['data_id'].'&dept_id='.$_GET['dept_id'];}?>">Indicators </a></li>
				 
			</ul>
			
			<?php if(!isset($_GET['tab'])){?>
				<div class="subcontent margin20">		
				
					<div class="contenttitle2 nomargintop">
						<h3> Set up Effectiveness Data </h3>
					</div>
					<div class="clearfix"></div>
					<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>effectiveness_data/manage_unit_effectiveness_data<?php if(isset($effectiveness_data->academic_unit_name) && $effectiveness_data->academic_unit_name!=''){ echo '?data_id='.$effectiveness_data->id;}?>" enctype="multipart/form-data">
					
						<div class="form-group">
							<label class="control-label" for="inputEmail3" ><h4>Unit / Program Name *</h4></label>
								<input type="text" class="form-control required" id="academic_unit_name" name="academic_unit_name" placeholder="Unit / Program Name" value="<?php if(isset($effectiveness_data->academic_unit_name) && $effectiveness_data->academic_unit_name!=''){ echo $effectiveness_data->academic_unit_name;}?>"  >
 						</div>
						
						<div class="form-group">
							<label class="control-label" for="inputEmail3" ><h4>Overview *</h4></label>
							<textarea id="editor" name="overview"><?php if(isset($effectiveness_data->overview) && $effectiveness_data->overview!=''){ echo $effectiveness_data->overview;}?></textarea> 
						</div>
						
						
						<div class="form-group">
							<button type="submit" class="btn btn-primary" name="submit_login">Save and Continue</button>
 						</div>
						
					</form>	
					
				</div>	
			<?php } ?>
			
			<?php if(isset($_GET['tab']) && $_GET['tab']==2 && isset($_GET['data_id']) && $_GET['data_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
<style type="text/css"> 
.multiselect{display:inline-block; padding-left:20px;}
.selectBox {
  position: relative; 
}
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0; display:inline-block;
}
option{padding:3px;}
</style>	
<script type="text/javascript">
var expanded = false;

function get_sub_indicator_manage(sub_indicator_id,indicator_id){
	
	var test=document.getElementById('checkboxs_'+indicator_id+''+sub_indicator_id); 
	
	if (test.checked == 1){
	
		jQuery('#hidden_sub_indicator_status'+indicator_id+''+sub_indicator_id).val('1');
		jQuery('#sub_indicators_'+indicator_id+''+sub_indicator_id).show();
		
	}else{
	
		jQuery('#hidden_sub_indicator_status'+indicator_id+''+sub_indicator_id).val('0');
		jQuery('#sub_indicators_'+indicator_id+''+sub_indicator_id).hide();
		
	} 
 
}

function open_model_year_add(){
  
	jQuery("#dialog_open_model_year_add").modal('show');
}
jQuery(function () { 
		jQuery('#frm_pop').validate({
		  ignore: [], 
		  highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		  },
		  success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		  }
		});
		
		jQuery('#frm_pop_edit').validate({
		  ignore: [], 
		  highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		  },
		  success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		  }
		});
	});
</script>

 	
			<div class="subcontent margin20">	
				
				<div class="contenttitle2 nomargintop">
					<h3> Indicators</h3>
				</div>
				<div class="pull-right">
					<a class="btn btn-default" onclick="return open_model_year_add();"  style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus" aria-hidden="true"></i> Add Year</a>
				</div>
				<div class="clearfix"></div>
				<div class="instructions"><strong>INSTRUCTIONS:</strong> Select add year button before selecting indicators.</div>
				<div class="clearfix"></div>
				<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>effectiveness_data/save_indicators<?php if(isset($effectiveness_data->id) && $effectiveness_data->id!=''){ echo '?data_id='.$effectiveness_data->id;}?>" enctype="multipart/form-data">
				
					<table class="table table-hover table-bordered" id="table_recordtbl25">
						<thead>
							<tr class="trbg">
								<th class="rowspan" rowspan="2" style="vertical-align:middle;"  nowrap="nowrap">Indicators</th>
								<th class="recourses" colspan="<?php echo count($program_year_listing);?>" style="vertical-align:middle; text-align:center;"  nowrap="nowrap">Program Year</th>
							</tr>
							
							<tr class="trbg">
 								<?php foreach($program_year_listing as $program_year){?>
								<th class="tdborder" style="vertical-align:middle; text-align:center;"  nowrap="nowrap">YR <?php echo $program_year->year;?></th>
								<?php } ?>
							</tr>
							
							
						</thead>
						<tbody>
							<?php 
 								$master_indicators = get_master_indicators_h();
 								foreach($master_indicators as $indicators){
							?>
							
							<tr>
								<td colspan="<?php echo count($program_year_listing)+1;?>"><span style="font-weight:600; letter-spacing:0.5px; font-size:16px;"><?php echo $indicators->name;?></span>
								
								
<style type="text/css">
#checkboxes<?php echo $indicators->id;?> {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:35%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#checkboxes<?php echo $indicators->id;?> label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px; text-align:left;
  }
#checkboxes<?php echo $indicators->id;?> label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
</style>
<script type="text/javascript">
function showCheckboxes<?php echo $indicators->id;?>() {
  var checkboxes = document.getElementById("checkboxes<?php echo $indicators->id;?>");
  if (!expanded) {
  	jQuery('#indicator_<?php echo $indicators->id;?>').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#indicator_<?php echo $indicators->id;?>').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<?php $master_sub_indicators = get_master_sub_indicators_h($indicators->id);?>
<div class="multiselect">
	<div class="selectBox" onclick="showCheckboxes<?php echo $indicators->id;?>()">
		<select class="form-control" style=" display:inline-block;" id="indicator_<?php echo $indicators->id;?>" name="undergraduate_direct_assesment">
			<option value="">-- Select --</option>
		</select>
		<div class="overSelect"></div>
	</div>
	<div id="checkboxes<?php echo $indicators->id;?>">
	
		<?php  foreach($master_sub_indicators as $sub_indicators){
		$check_tr_status = check_indicator_assign_h($effectiveness_data->id,$sub_indicators->id,$this->session->userdata('dept_id'));	
		?>
			<label for="checkboxs_<?php echo $indicators->id.$sub_indicators->id;?>">
			<input type="checkbox" name="checkboxs_<?php echo $indicators->id.$sub_indicators->id;?>" onclick="return get_sub_indicator_manage(this.value,'<?php echo $indicators->id;?>')" class="" <?php if(isset($check_tr_status) && $check_tr_status>0){?> checked="checked" <?php } ?> id="checkboxs_<?php echo $indicators->id.$sub_indicators->id;?>" value="<?php echo $sub_indicators->id;?>" /> &nbsp;&nbsp;<?php echo $sub_indicators->name; if($sub_indicators->sub_indicators!='other'){echo ' - '.$sub_indicators->sub_indicators;}?></label>
		<?php } ?> 
	</div>
</div>

</td>
								 
							</tr>		
								
								<?php 
								
								$master_sub_indicators = get_master_sub_indicators_h($indicators->id);
 								foreach($master_sub_indicators as $sub_indicators){	
								
									  $check_tr_status = check_indicator_assign_h($effectiveness_data->id,$sub_indicators->id,$this->session->userdata('dept_id'));	
								
								?>
									<tr id="sub_indicators_<?php echo $indicators->id.$sub_indicators->id;?>" style=" <?php if(isset($check_tr_status) && $check_tr_status>0){echo '';}else{ echo 'display:none';}?>">
										<td style="padding-left:30px; vertical-align:middle;">
										
										<input type="hidden" name="hidden_sub_indicator_status<?php echo $indicators->id.$sub_indicators->id;?>" id="hidden_sub_indicator_status<?php echo $indicators->id.$sub_indicators->id;?>" value="<?php if(isset($check_tr_status) && $check_tr_status>0){echo '1';}else{ echo '0';}?>" /><?php echo $sub_indicators->name;if(isset($sub_indicators->sub_indicators) && $sub_indicators->sub_indicators!='other'){echo ' - '.$sub_indicators->sub_indicators;}?></td>
										<?php foreach($program_year_listing as $program_year){
										
											$check_year_value_status = check_year_value_assign_h($effectiveness_data->id,$indicators->id,$sub_indicators->id,$this->session->userdata('dept_id'),$program_year->year_id);
											
											?>
											<td>
												<input type="text" class="form-control" id="year_value_<?php echo $indicators->id.$sub_indicators->id.$program_year->year_id;?>" name="year_value_<?php echo $indicators->id.$sub_indicators->id.$program_year->year_id;?>" value="<?php if(isset($check_year_value_status->year_value) && $check_year_value_status->year_value!=''){echo $check_year_value_status->year_value;}?>" />
											</td>
										<?php } ?>
									</tr> 
									
							<?php }
							 } ?>
						
						</tbody>
					</table>
					<div>
		<input name="save_indicators" id="save_indicators" value="Save &amp; Update" class="btn btn-primary" type="submit">
	</div>
				</form>
			</div>
			
			<?php } ?>
			 
			
		</div>
	 
		<div class="clearfix"></div>
	</div>
	
</div>

<div class="modal fade" id="dialog_open_model_year_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong id="courses_add_popup_title">Program Year : : Add</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>effectiveness_data/add_program_year_entry?tab=2<?php if(isset($_GET['data_id']) && $_GET['data_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&data_id='.$_GET['data_id'].'&dept_id='.$_GET['dept_id'];}?>">
			 
			<div class="form-group">
 				<input type="text" id="add_year" name="add_year" placeholder="<?php echo date('Y');?>" class="form-control required" />
			</div>
  			
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
			
		</form>
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>