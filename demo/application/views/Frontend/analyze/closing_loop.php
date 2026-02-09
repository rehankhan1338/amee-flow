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

 	
			<div class="subcontent">	
				
				<div class="contenttitle2 nomargintop" style="margin:0px 0px 10px 0px;">
					<h3> Closing the Loop</h3>
				</div>
				<div class="pull-right">
				
					<a class="btn btn-default" onclick="return open_model_year_add();"  style="padding:3px 15px; font-size:15px;"><i class="fa fa-plus" aria-hidden="true"></i> Add Year</a>
 				
				</div>
				<div class="clearfix"></div>
				<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>analyze/save_closing_loop" enctype="multipart/form-data">
				
					<table class="table table-hover table-bordered table-striped" id="table_recordtbl25">
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
 								
 								for($loop=1;$loop<=3;$loop++){
								$lable_status=$loop;
 								
							?>
							
							<tr>
								<td colspan="<?php echo count($program_year_listing)+1;?>"><span style="font-weight:600;font-size:16px;"><?php 
								
								if($lable_status==1){
									echo 'Program Curriculum';
								}else if($lable_status==2){
									echo 'Academic Processes';
								}else{
									echo 'Evaluation Plan';
								}
								?></span>
								
								
<style type="text/css">
#checkboxes<?php echo $lable_status;?> {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:35%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#checkboxes<?php echo $lable_status;?> label {
  display: inline-block;padding: 3px 15px;width: 100%;color: #fff;font-size: 17px; text-align:left;
  }
#checkboxes<?php echo $lable_status;?> label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
</style>
<script type="text/javascript">
function showCheckboxes<?php echo $lable_status;?>() {
  var checkboxes = document.getElementById("checkboxes<?php echo $lable_status;?>");
  if (!expanded) {
  	jQuery('#indicator_<?php echo $lable_status;?>').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#indicator_<?php echo $lable_status;?>').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<?php $closing_loops_detail = get_master_closing_loops_detail_by_status($lable_status);?>
<div class="multiselect">
	<div class="selectBox" onclick="showCheckboxes<?php echo $lable_status;?>()">
		<select class="form-control" style=" display:inline-block;" id="indicator_<?php echo $lable_status;?>" name="undergraduate_direct_assesment">
			<option value="">-- Select --</option>
		</select>
		<div class="overSelect"></div>
	</div>
	<div id="checkboxes<?php echo $lable_status;?>">
	
		<?php  foreach($closing_loops_detail as $loops_detail){
			  $check_tr_status = check_loop_status_assign_h($loops_detail->id,$this->session->userdata('dept_id'));
		?>
			<label for="checkboxs_<?php echo $lable_status.$loops_detail->id;?>">
			<input type="checkbox" name="checkboxs_<?php echo $lable_status.$loops_detail->id;?>" onclick="return get_sub_indicator_manage(this.value,'<?php echo $lable_status;?>')" class="" <?php if(isset($check_tr_status) && $check_tr_status>0){?> checked="checked" <?php } ?> id="checkboxs_<?php echo $lable_status.$loops_detail->id;?>" value="<?php echo $loops_detail->id;?>" /> &nbsp;&nbsp;<?php echo $loops_detail->heading_label;?></label>
		<?php } ?> 
	</div>
</div>

</td>
								 
							</tr>		
								
								<?php 
								
								$closing_loops_detail = get_master_closing_loops_detail_by_status($lable_status);
 								foreach($closing_loops_detail as $loops_detail){
								
									  $check_tr_status = check_loop_status_assign_h($loops_detail->id,$this->session->userdata('dept_id'));
 								
								?>
									<tr id="sub_indicators_<?php echo $lable_status.$loops_detail->id;?>" style=" <?php if(isset($check_tr_status) && $check_tr_status>0){echo '';}else{ echo 'display:none';}?>">
										<td style="padding-left:30px; vertical-align:middle;">
										
										<input type="hidden" name="hidden_sub_indicator_status<?php echo $lable_status.$loops_detail->id;?>" id="hidden_sub_indicator_status<?php echo $lable_status.$loops_detail->id;?>" value="<?php if(isset($check_tr_status) && $check_tr_status>0){echo '1';}else{ echo '0';}?>" /><?php echo $loops_detail->heading_label;?></td>
										<?php foreach($program_year_listing as $program_year){
										
						$check_year_value_status = check_year_value_analyze_heading_h($lable_status,$loops_detail->id,$this->session->userdata('dept_id'),$program_year->year_id);
											 
											
											?>
											<td>
												<input type="text" class="form-control" id="year_value_<?php echo $lable_status.$loops_detail->id.$program_year->year_id;?>" name="year_value_<?php echo $lable_status.$loops_detail->id.$program_year->year_id;?>" value="<?php if(isset($check_year_value_status->year_value) && $check_year_value_status->year_value!=''){echo $check_year_value_status->year_value;}?>" />
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
			
<div class="clearfix"></div>		
<div class="modal fade" id="dialog_open_model_year_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong id="courses_add_popup_title">Program Year : : Add</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>analyze/add_program_year_entry">
			 
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