<div class="clearfix"></div>
<style>
.alert-success{ margin:-20px 0 30px;}

</style>
<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px;;">
	<h3 style="font-weight:600;">Analysis Reporting : Step 6</h3>
	<?php if(count($myDeptReportListing)>0){?>
	<div class="btn_div" style="float:right;">
		<a class="btn btn-primary" onclick="return createReport();"> <i class="fa fa-plus"></i> &nbsp;Create Report</a>
 	</div>
	<?php } ?>
</div>
<?php if(count($myDeptReportListing)>0){?>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Title to view Anlaysis Report.</div>
<div class="clearfix"></div>
 <table class="table table-striped" id="table_recordtbl12">
	<thead>
	<tr class="trbg">
		<th class="survey_listing_td" style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Report Title</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Year</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Last Modified</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Created Date</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Submitted</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
	</tr> 
	 </thead>
		<tbody>
			<?php $i=1; foreach($myDeptReportListing as $row){?>
				<tr>
					<td><?php echo $i;?></td>
					<td><a id="rpt<?php echo $row['reportId'];?>" class="ftdt" href="<?php echo base_url();?>analyze/view/<?php echo $row['encryptReportId'];?>"><?php echo ucwords($row['reportTitle']);?></a></td>
					<td id="rpy<?php echo $row['reportId'];?>"><?php echo $row['reportYear'];?></td>
					<td><?php if(isset($row['lastModiTime']) && $row['lastModiTime']!=''){echo date('M d Y, h:i A',$row['lastModiTime']);}?></td>
					<td><?php if(isset($row['createTime']) && $row['createTime']!=''){echo date('M d Y, h:i A',$row['createTime']);}?></td>
					<td id="tdSubSts_<?php echo $row['reportId'];?>">
						<?php if($row['submittedSts']==1){?>
							<label class="tbl_mstus accepted">Yes</label>
						<?php }else{ ?>
							<label class="tbl_mstus rejected">No</label>
						<?php } ?>
					</td>
					<td>
						<?php if($row['submittedSts']==0){?>
							<a id="sbmtLnk_<?php echo $row['reportId'];?>" onclick="return submitReport('<?php echo $row['reportId'];?>');" class="btn btn-default btn-xs">Submit</a>
						<?php } ?>
						<a onclick="return editReport('<?php echo $row['reportId'];?>');" class="btn btn-success btn-xs">Edit</a>
						<a href="<?php echo base_url();?>analyze/deleteReport?id=<?php echo $row['reportId'];?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this report?');">Delete</a>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
</table>
<?php }else{ ?>
	<div align="center">
		<p>&nbsp;</p>
		<h3><i>No report has been created.</i></h3>
		<p style="font-size:18px;">please click the button Create Report to start.</p>
		<a class="btn btn-default" onclick="return createReport();" style="padding:4px 30px; font-size:16px;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Create Report</a>
	</div>
<?php } ?>
<script>
function submitReport(reportId){
	if(reportId){
		var url = '<?php echo base_url().'analyze/ajax_submit_report?reportId=';?>'+reportId;
		jQuery.ajax({
			type: "POST",
			url: url,
			beforeSend: function(){
				jQuery('#sbmtLnk_'+reportId).html('Submitting <i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				if(result=='success'){
					jQuery('#tdSubSts_'+reportId).html('<label class="tbl_mstus accepted">Yes</label>');
					jQuery('#sbmtLnk_'+reportId).hide();
				}else{
					alert(result);
					jQuery('#sbmtLnk_'+reportId).html('Submit');
				}					
			},
			error: function(xhr, status, error_desc){				
				alert(error_desc);
				jQuery('#sbmtLnk_'+reportId).html('Submit');
			}
		});	
	}
}
function editReport(reportid){
	if(reportid){
		jQuery("#h_report_id").val(reportid);
		var rTitle = jQuery("#rpt"+reportid).html();
		var rYear = jQuery("#rpy"+reportid).html();
 		jQuery("#h_report_title").val(rTitle);
		jQuery("#h_report_year").val(rYear);
 		jQuery("#editAnlaysisModel").modal('show');
	} 	
}
function createReport(){
	jQuery("#createAnlaysisModel").modal('show');
}
jQuery(function () {
	jQuery('#editRptFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#he_base_url').val();
			var form = jQuery('#editRptFrm');
			var url = site_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#editBtn').html('Updating <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'department/analyze';
					}else{						
						jQuery('#editresMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery('#editBtn').html('Update Now!');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery('#editresMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#editBtn').html('Update Now!');
				}
			});		
			return false;
		}
	});
	jQuery('#createRptFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#createRptFrm');
			var url = site_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#createBtn').html('Creating <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'department/analyze';
					}else{						
						jQuery('#createresMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery('#createBtn').html('Create Now!');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery('#createresMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#createBtn').html('Create Now!');
				}
			});		
			return false;
		}
	});
});
</script> 

<div class="modal fade" id="editAnlaysisModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong>Analysis Report : : Edit</strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>   
			<div class="modal-body" style="padding:15px;">
				<form method="post" id="editRptFrm" class="" action="analyze/edit_report">
					<div id="editresMsg"></div>
					<input type="hidden" id="h_report_id" name="h_report_id" value="0" />
					<input type="hidden" id="he_base_url" name="he_base_url" value="<?php echo base_url();?>" />
					<div class="form-group">
						<label style="font-weight:600;">Report Title/Name *</label>
						<input type="text" class="form-control required" name="h_report_title" id="h_report_title" value="" autocomplete="off" />
					</div>
					<div class="form-group">
						<label style="font-weight:600;">Year *</label>
						<input type="text" id="h_report_year" maxlength="4" name="h_report_year" autocomplete="off" placeholder="<?php echo date('Y');?>" value="" class="form-control number required" autocomplete="off" />	
					 </div>	
					<div class="form-group">
						<button type="submit" class="btn btn-primary" id="editBtn">Update Now!</button>
					</div>
					 					 
				</form>
				<div class="clearfix"></div>			 
			</div>
    	</div>
	</div>
</div>

<div class="modal fade" id="createAnlaysisModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong>Create your Analysis Report</strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>   
			<div class="modal-body" style="padding:15px;">
				<form method="post" id="createRptFrm" class="" action="analyze/create_report">
					<div id="createresMsg"></div>
					<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
					<div class="form-group">
						<label style="font-weight:600;">Report Title/Name *</label>
						<input type="text" class="form-control required" name="createReportTitle" id="createReportTitle" autocomplete="off" placeholder="" />
					</div>
					<div class="form-group">
						<label style="font-weight:600;">Year *</label>
						<input type="text" id="createReportYear" maxlength="4" name="createReportYear" autocomplete="off" placeholder="<?php echo date('Y');?>" value="" class="form-control number required" autocomplete="off" />	
					 </div>	
					<div class="form-group">
						<button type="submit" class="btn btn-primary" id="createBtn">Create Now!</button>
					</div>
					 					 
				</form>
				<div class="clearfix"></div>			 
			</div>
    	</div>
	</div>
</div>
<div class="clearfix"></div>
	 