<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3>Test/Poll Dashboard</h3>
	<div class="btn_div">
		<a class="btn btn-primary" onclick="return open_model_test_add();" ><i class="fa fa-plus" aria-hidden="true"></i> &nbsp;Create Test</a>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Test Title to get started.</div>
<div class="clearfix"></div>		  
<table class="table table-striped" id="table_recordtbl">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Test/Poll Title</th>
			<th style="vertical-align:middle;" nowrap="nowrap">Test Type</th>
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
		<?php $i=1; foreach($tests_listing as $tests){?>
			<tr>
				<td><?php echo $i;?></td>			
				<td>
					<a style="font-weight:600;" id="test_name_details_<?php echo $tests->test_id;?>" href="<?php echo base_url();?>department/create/tests/management?test_id=<?php echo $tests->test_id;?>&dept_id=<?php echo $tests->department_id;?>"><?php echo ucwords($tests->test_title);?></a></td>			
				<td><?php if($tests->test_type==1){
						echo "Pre-Post Test";
					}elseif($tests->test_type==2){
						echo "One Time Test";
					}?>	
				</td>
				<td><?php if($tests->anonymousTest==0){ echo "Yes"; }else{echo 'No';}?></td>
				<td style=" font-weight:600;">
					<?php $tests_reponses_count = get_tests_reponses_count($tests->test_id,$tests->department_id);  echo $tests_reponses_count;?>	
				</td>					
						
				<td><?php if(isset($tests->last_modification) && $tests->last_modification!=''){echo date('M d Y, h:i A',$tests->last_modification);}else{echo '-';}?></td>				
				<td><?php if(isset($tests->creation_date_time) && $tests->creation_date_time!=''){echo date('M d Y, h:i A',$tests->creation_date_time);}?></td>				
				
				
				<td style="vertical-align:middle;" nowrap="nowrap"><?php if(isset($tests->status) && $tests->status==0){ ?>
						<label class="tbl_mstus accepted">Active</label>
					<?php }else{?>
						<label class="tbl_mstus rejected">In-active</label>
					<?php } ?></td>	
				<td>
			<a onclick="return open_model_test_edit('<?php echo $tests->test_id;?>', '<?php echo $tests->status;?>', '<?php echo $tests->anonymousTest;?>', '<?php echo $tests->test_type;?>');" ><i class="fa fa-pencil"></i></a>
			<a href="<?php echo base_url();?>tests/delete?id=<?php echo $tests->test_id;?>" onclick="return confirm('Are you sure you want to delete this test?');" style="margin-left:15px;"><i class="fa fa-trash"></i></a>
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
function open_model_test_add(){
 	jQuery("#open_model_survey_add").modal('show');
}
function open_model_test_edit(test_id, status, anonymousTest, typeId){
	if(test_id){
		var testname = jQuery("#test_name_details_"+test_id).html();
		jQuery("#open_model_test_edit").modal('show');
		jQuery("#h_test_id").val(test_id);
		jQuery("#h_testname").val(testname);	
		$("#selected_status_"+status).attr("selected", "selected");	
		$("#selected_at_"+anonymousTest).attr("selected", "selected");	
		if(typeId==2){
			$('#EanonymousField').show();
		}else{
			$('#EanonymousField').hide(); 
		}
	} 	
}
function anonymousManageFun(typeId){
	if(typeId==2){
		$('#anonymousField').show();
		$('#anonymousTest').addClass('required');
	}else{
		$('#anonymousField').hide();
		$('#anonymousTest').removeClass('required'); 
	}
}
</script>
<div class="modal fade" id="open_model_survey_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Create a Test from Scratch</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>tests/add">
   			<div class="form-group">
				<label style="font-weight:600;">Test Name/Title *</label>
				<input type="text" class="form-control required" name="test_title" id="test_title" placeholder="Enter your Test Title here" />
			</div>
 			<div class="form-group">
				<label style="font-weight:600;">Test Type *</label>
				<select class="form-control required" name="test_type" id="test_type" placeholder="Select Test Type" onchange="return anonymousManageFun(this.value);">
					<option value="">Select...</option>
					<option value="1">Pre-Post Test</option>
					<option value="2">One Time Test</option>
				</select>
			</div>
			<div class="form-group" style="display:none" id="anonymousField">
				<label style="font-weight:600;">Anonymous Test *</label>
				<select class="form-control" name="anonymousTest" id="anonymousTest">
					<option value="">Select...</option>
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

<div class="modal fade" id="open_model_test_edit" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Test : : Edit</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop_edit" class="" action="<?php echo base_url();?>tests/edit">
			<input type="hidden" name="h_test_id" id="h_test_id">
  			<div class="form-group">
				<label style="font-weight:600;">Test Name/Title *</label>
				<input type="text" class="form-control required" name="h_testname" id="h_testname" placeholder="Enter your survey name here"  />
			</div> 
			<div class="form-group" id="EanonymousField">
				<label style="font-weight:600;">Anonymous Test *</label>
				<select class="form-control required" name="h_anonymousTest" id="h_anonymousTest">
					<option value="">Select...</option>
					<option id="selected_at_0" value="0">Yes</option>
					<option id="selected_at_1" value="1">No</option>
				</select>
			</div> 			
 			<div class="form-group">
				<label style="font-weight:600;">Status *</label>
				<select class="form-control required" id="h_teststatus" name="h_teststatus">
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