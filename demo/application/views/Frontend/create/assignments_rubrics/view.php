<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<style type="text/css">
.count_lbl{ font-size: 16px;font-weight: 600;margin-left: 15px;margin-top: 0px;vertical-align: top;}
.modal-dialog {max-width: 360px;}
.ftdtf{ font-weight:600;}
</style>
<div class="assignment_heading">
	<h3>Rubric Builder Dashboard</h3>
	<div class="btn_div">
		<a class="btn btn-primary" style="padding:5px 15px;" onclick="return open_model_assignment_add();"><i class="fa fa-plus" aria-hidden="true"></i> Create Assignment</a>
		<!--<a class="btn btn-warning" style="padding:5px 15px;" onclick="return archive_delete_analysis_review('1');"><i class="fa fa-archive" aria-hidden="true"></i> Archive</a>-->
		<a class="btn btn-danger" style="padding:5px 15px;" onclick="return archive_delete_analysis_review('2');"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Assignment Title to get started.</div>
<div class="clearfix"></div>	
<table class="table table-hover table-striped" id="table_recordtbl25">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:middle;text-align:center;" width="3%"><input type="checkbox" name="list_check" id="selectall"></th>
			<th style="vertical-align:middle;" nowrap="nowrap">Assignment Title </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Assignment Type </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Anonymous</th>		
			<th style="vertical-align:middle;" nowrap="nowrap">Results </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Created On </th>				
			<th style="vertical-align:middle;" nowrap="nowrap">Status </th>
			<th style="vertical-align:middle;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php if(count($assignments_rubrics_listing)>0){ $j=1; foreach($assignments_rubrics_listing as $assignments){?>
		<tr>
			<td style="text-align:center;"><input class="case" type="checkbox" name="unit_id[]" id="unit_id[]" value="<?php echo $assignments->id;?>"></td>
			<td><a class="ftdtf" href="<?php echo base_url();?>department/create/assignments_rubrics/manage?ar_id=<?php echo $assignments->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>"><?php echo ucwords($assignments->assignment_title);?></a></td>
			<td><?php echo get_master_direct_assessment_name_h($assignments->assignment_type);?></td>
			<td style="vertical-align:middle;">
				<?php if(isset($assignments->anonymousAssignment) && $assignments->anonymousAssignment==0){echo 'Yes';}else{echo 'No';} ?>
			</td>
			
			<td>
			<?php $assingment_responses_count = get_assingment_responses_count($assignments->id,$assignments->department_id);?>
				 <a style="font-size:25px;" href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8&ar_id=<?php echo $assignments->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>&view_result=takers"><i class="fa fa-list-alt" aria-hidden="true"></i></a><label class="count_lbl">(<?php echo $assingment_responses_count;?>)</label>	
			</td>
			<td><?php echo date('m/d/Y, h:i A',$assignments->add_date);?></td>
			<td style="vertical-align:middle;" nowrap="nowrap"><?php if(isset($assignments->status) && $assignments->status==0){ ?>
				<label class="tbl_mstus accepted">Active</label>
			<?php }else{?>
				<label class="tbl_mstus rejected">In-active</label>
			<?php } ?></td>	
			<td>
				<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?ar_id=<?php echo $assignments->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>" class="btn btn-success btn-xs">Edit</a>
				<!--<a href="<?php echo base_url();?>assignments_rubrics/reusing?ar_id=<?php echo $assignments->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>" class="btn btn-default btn-xs">Reuse</a>-->
 			</td>
		</tr>
	<?php $j++; } }else{ ?>
	
		<tr>
			<td colspan="8">No data available</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">                 
function open_model_assignment_add(){
 	jQuery("#open_model_assignment_add").modal('show');
}
jQuery(function(){
   // add multiple select / deselect functionality
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
	
	jQuery("#selectall").click(function () {
        jQuery('.case').attr('checked', this.checked); 
   });
   // if all checkbox are selected, check the selectall checkbox
   // and viceversa
   jQuery(".case").click(function(){
       if(jQuery(".case").length == jQuery(".case:checked").length) {
           jQuery("#selectall").attr("checked", "checked");
       } else {
           jQuery("#selectall").removeAttr("checked");
       }
   });
});
function archive_delete_analysis_review(status){
	var new_array=[];
	jQuery(".case:checked").each(function() {
		var n_total=parseInt(jQuery(this).val());
		new_array.push(n_total);
	}); 
 	if(new_array==''){
		alert('Please select at least one unit review.');
	}else{
		if(status==1){
			var result = confirm("Are You Sure u want to archive?");
		}else{
			var result = confirm("Are You Sure u want to delete?");
		}
		
		if(result){
			window.location='<?php echo base_url();?>assignments_rubrics/archive_delete_analysis_review?arr='+new_array+'&status='+status;
		}
	}	
}
</script>
<div class="modal fade" id="open_model_assignment_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Create a Assignment from Scratch</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>assignments_rubrics/set_assignment">
			
  			<div class="form-group">
				<label class="control-label" for="inputEmail3">Assignment Title *</label>
				<input type="text" class="form-control required" id="assignment_title" name="assignment_title" placeholder="Assignment Title" value="<?php if(isset($assignments_rubrics_row->assignment_title) && $assignments_rubrics_row->assignment_title!=''){ echo $assignments_rubrics_row->assignment_title;}?>" >
			</div>
			
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Assignment Type *</label>
				<select class="form-control required" id="assignment_type" name="assignment_type" placeholder="Assignment Type">
					<option value=""> Select Type </option>
 					<?php $master_direct_assessment = get_master_direct_assessment_h(); 
 						foreach($master_direct_assessment as $assessments){?>
 							<option value="<?php echo $assessments->id;?>" <?php if(isset($assignments_rubrics_row->assignment_type) && $assignments_rubrics_row->assignment_type==$assessments->id){?> selected="selected" <?php }?> > <?php echo $assessments->name; ?> </option>
					<?php }	?>
				</select>
			</div>	
			<div class="form-group">
				<label style="font-weight:600;">Anonymous Link *</label>
				<select class="form-control required" name="anonymousAssignment" id="anonymousAssignment">
					<option value="">Select...</option>
					<option value="0">Yes</option>
					<option value="1">No</option>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Create Now!' />
			</div>
			
		</form>
		
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>