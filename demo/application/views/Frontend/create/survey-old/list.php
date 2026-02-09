<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>

<div class="clearfix"></div>
<div class="survey_heading">
	<h3>Survey Builder Dashboard</h3>
	<div class="btn_div">
		<a class="btn btn-primary" onclick="return open_model_survey_add();" ><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Create Survey</a>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Survey Name to get started.</div>
<div class="clearfix"></div>		  
 <table class="table table-striped" id="table_recordtbl">
	<thead>
	<tr class="trbg">
		<th style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
		<th style="vertical-align:middle;" nowrap="nowrap">Survey Name</th>
		<th style="vertical-align:middle;" nowrap="nowrap">Anonymous</th>
		<th style="vertical-align:middle;">Responses</th>
		<th style="vertical-align:middle;">Last Updated</th>
		<th style="vertical-align:middle;">Created On </th>
		<!--<th style="vertical-align:middle;">Owner</th>-->
		<th style="vertical-align:middle;">Status</th>
		<th style="vertical-align:middle;">Action</th>
	</tr> 
	 </thead>
		<tbody>
			<?php $i=1; foreach($survey_listing as $survey_details){?>
				<tr>
					<td><?php echo $i;?></td>
					<td><a style=" font-weight:600;" id="survey_name_details_<?php echo $survey_details->survey_id;?>" href="<?php echo base_url();?>department/create/survey/management?survey_id=<?php echo $survey_details->survey_id;?>&dept_id=<?php echo $survey_details->department_id;?>"><?php echo ucwords($survey_details->survey_name);?></a></td>
					
					<td style="vertical-align:middle;"><?php if(isset($survey_details->anonymousSurvey) && $survey_details->anonymousSurvey==0){ echo 'Yes'; }else{echo 'No'; } ?></td>
					<td style=" font-weight:600;">
						<?php echo get_survey_responses_count($survey_details->survey_id,$survey_details->department_id);?>				
					</td>
					
					
					<td><?php if(isset($survey_details->last_modification) && $survey_details->last_modification!=''){echo date('M d Y, h:i A',$survey_details->last_modification);}else{echo '-';}?></td>
					<td><?php if(isset($survey_details->creation_date_time) && $survey_details->creation_date_time!=''){echo date('M d Y, h:i A',$survey_details->creation_date_time);}?></td>
						
								
					
					<!--<td><?php //if($survey_details->department_id==$this->session->userdata('dept_id')){echo 'Me';}?></td>-->
					<td style="vertical-align:middle;" nowrap="nowrap"><?php if(isset($survey_details->status) && $survey_details->status==0){ ?>
						<label class="tbl_mstus accepted">Active</label>
					<?php }else{?>
						<label class="tbl_mstus rejected">In-active</label>
					<?php } ?></td>
					<td>
						<a onclick="return open_model_survey_edit('<?php echo $survey_details->survey_id;?>', '<?php echo $survey_details->status;?>', '<?php echo $survey_details->anonymousSurvey;?>');" ><i class="fa fa-pencil"></i></a>
						<a href="<?php echo base_url();?>survey/delete?id=<?php echo $survey_details->survey_id;?>" onclick="return confirm('Are you sure you want to delete this survey?');" style="margin-left:15px;"><i class="fa fa-trash"></i></a>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
</table>
</div>
<script type="text/javascript">
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
function open_model_survey_add(){
 	jQuery("#open_model_survey_add").modal('show');
}
function open_model_survey_edit(surveyid, status, anonymousSurvey){
	if(surveyid){
		var surveyname = jQuery("#survey_name_details_"+surveyid).html();
		jQuery("#open_model_survey_edit").modal('show');
		jQuery("#h_survey_id").val(surveyid);
		jQuery("#h_surveyname").val(surveyname);	
		$("#selected_status_"+status).attr("selected", "selected");	
		$("#anonymousSurveyOpt"+anonymousSurvey).attr("selected", "selected");	
	} 	
}
</script>
<div class="modal fade" id="open_model_survey_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Create a Survey from Scratch</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>survey/add">
   			<div class="form-group">
				<label>Survey Name *</label>
				<input type="text" class="form-control required" name="create_survey" id="create_survey" placeholder="Enter your survey name here" />
			</div>
			<div class="form-group">
				<label style="font-weight:600;">Anonymous Survey *</label>
				<select class="form-control required" id="anonymousSurvey" name="anonymousSurvey">
					<option value="">Select....</option>
					<option value="0">Yes</option>
					<option value="1">No</option>
				</select>	
			 </div>	
 			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Create Now!'/>
			</div>
		</form>
 		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>
<!--Edit Model-->
<div class="modal fade" id="open_model_survey_edit" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Survey : : Edit</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop_edit" class="" action="<?php echo base_url();?>survey/edit">
			<input type="hidden" name="h_survey_id" id="h_survey_id">
  			<div class="form-group">
				<label style="font-weight:600;">Survey Name *</label>
				<input type="text" class="form-control required" name="h_surveyname" id="h_surveyname" placeholder="Enter your survey name here"  />
			</div>  
			<div class="form-group">
				<label style="font-weight:600;">Anonymous Survey *</label>
				<select class="form-control required" id="h_anonymousSurvey" name="h_anonymousSurvey">
					<option value="">Select....</option>
					<option id="anonymousSurveyOpt0" value="0">Yes</option>
					<option id="anonymousSurveyOpt1" value="1">No</option>
				</select>	
			 </div>			
 			<div class="form-group">
				<label style="font-weight:600;">Status *</label>
				<select class="form-control required" id="h_surveystatus" name="h_surveystatus">
					<option value="">--select--</option>
					<option id="selected_status_0" value="0">Active</option>
					<option id="selected_status_1" value="1">In-active</option>
				</select>	
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
<div class="clearfix"></div>
	 