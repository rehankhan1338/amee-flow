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
</script>
<button class="btn btn-danger pull-right" id="removeResBtn" onclick="return removeResponses();" style="margin-bottom:10px; margin-top:-50px; padding:4px 20px; ">Delete</button>	
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