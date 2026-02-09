<div id="survey_reports" class="subcontent margin20" >
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Survey Responses</h3>
	</div>
	<div class="clearfix"></div>
<script>
jQuery(function(){
	jQuery("#srSelectall").click(function () {
        jQuery('.srCase').attr('checked', this.checked); 
   });
   jQuery(".srCase").click(function(){
       if(jQuery(".srCase").length == jQuery(".srCase:checked").length) {
           jQuery("#srSelectall").attr("checked", "checked");
       } else {
           jQuery("#srSelectall").removeAttr("checked");
       }
   });
});
function removeResponses(){
	var new_array=[];
	jQuery(".srCase:checked").each(function() {
		var n_total=jQuery(this).val();
		new_array.push(n_total);
	}); 
 	if(new_array==''){
		alert('Please select at least one response.');
	}else{
		var result = confirm("Are you sure want to remove responses?");
 		if(result){
			jQuery('#removeResBtn').html('Deleting <i class="fa fa-spinner fa-spin"></i>')
			window.location='<?php echo base_url();?>survey/remove_reponses?ids='+new_array+'<?php echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];?>';
		}
	}	

}
function open_model_responses_emails(){
 	jQuery("#open_model_responses_emails").modal('show');
}
function copyClipboard() {
  var copyText = document.getElementById("copyTxtToClipboard");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value); //copyText.value
  $('#copyToClipboardBtn').html('<i class="fa fa-clipboard"></i> Copied');
}
</script>
<div class=" pull-right">
<button class="btn btn-primary" id="" onclick="return open_model_responses_emails();" style="margin-bottom:10px; margin-top:-50px; padding:4px 20px; ">Get Emails</button>
<button class="btn btn-danger" id="removeResBtn" onclick="return removeResponses();" style="margin-bottom:10px; margin-top:-50px; padding:4px 20px; ">Delete</button>
	
</div>
	<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th style="vertical-align:middle;" width="3%" nowrap="nowrap"><input type="checkbox" name="list_check" id="srSelectall"></th>
			<th style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>
			<th style="vertical-align:middle;" nowrap="nowrap">E-Mail / IP </th>
			<th style="vertical-align:middle;" nowrap="nowrap">Given Date</th>
			<th style="vertical-align:middle;">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($survey_responses_data as $result){?>
	
		<tr>
 			<td><input type="checkbox" class="srCase" value="<?php echo $result->id.'|'.$result->auth_code;?>" /></td>		
			<td style="font-weight:600;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>
			<td><?php echo $result->email_to;?></td>
			<td><?php if(isset($result->finish_date)&& $result->finish_date!=''){ echo date('m/d/Y h:i:s',$result->finish_date);}else{echo '-';}?></td>
 			<td><?php if(isset($result->finish_status) && $result->finish_status=='1'){echo '<label class="tbl_mstus accepted">Complete</label>';}else{echo '<label class="tbl_mstus rejected">Incomplete</label>';}?></td>
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>
	
</div>
</div>

<div class="modal fade" id="open_model_responses_emails" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Responses Emails</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<?php $getEmailsArr = array();
		foreach($survey_responses_data as $result){
			$getEmailsArr[] = $result->email_to;
		}
		if(count($getEmailsArr)>0){
			$ResEmails =  implode(', ',$getEmailsArr);
			echo $ResEmails;?>
			<input type="text" style="display:none;" value="<?php echo $ResEmails;?>" id="copyTxtToClipboard">
			<?php
		} ?>
	</div>
	<div class="modal-footer" style="text-align:left;">
		<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>
	</div>
</div>
</div>
</div>