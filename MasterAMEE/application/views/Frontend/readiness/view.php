<div class="box">
	
<form class="form-horizontal" method="post" id="readnessFrm" action="readiness/save_checklist_data">
	<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />	
	<div class="col-xs-12">
		<div class="instructions">
			<strong>Instruction:</strong> Click on all that are established in your program.  This step must be completed to establish a program baseline.
		</div>		
<div id="resMsg"></div>
		<div class="box-body">
			
			<div class="col-xs-7">
				<?php foreach($web_readness_list as $readness_list){
					$fRes = filter_array_chk($my_checklist_data,$readness_list->id,'checklist_id');
					$checked_status = count($fRes);
				?>
						 
					<div class="col-xs-6" style="padding:15px 0;">
						<h4>
							<input type="checkbox" <?php if(isset($checked_status) && $checked_status>0){ ?> checked="checked" <?php } ?>  name="checklist_ids[]" id="checklist_ids[]" value="<?php echo $readness_list->id.'|'.$readness_list->purpose; ?>"/>&nbsp;&nbsp;<?php echo $readness_list->title;?>&nbsp;&nbsp;
						
							<a onclick="return open_popup_messages('purpose','<?php echo $readness_list->purpose;?>','<?php echo $readness_list->id; ?>');" class="btn btn-block btn-default btn-xs" style="width:auto; display:inline-block;">Read More <span id="lnk_<?php echo $readness_list->id;?>"></span></a>
						</h4>
					</div>
				<?php } ?> 
			</div>			
			
			<div class="col-xs-5">
				<?php if(isset($checklist_sum)&& $checklist_sum!=''){?>
					<div class="contenttitle2 nomargintop">
                            <h3>Readiness Statement</h3>
                        </div>
						
						<blockquote class="bq2 marginbottom0">
						
						<?php if($checklist_sum >= 9) { ?>
							
							Your program is doing <b> Fabulous Work! </b> You are prepared to start the assessment process without delay.  You will need access to all assessment elements that you check marked to start Amee's 6- step process. <br /><br />
							You are ready to investigate on your own, but we highly suggest using the Escort Pilot to make the process a meaningful experience.
						
						<?php } else if($checklist_sum == 8 || $checklist_sum == 6 || $checklist_sum == 7) { ?>

							Your program is doing <b> Good Work! </b> You have a sufficient number of elements completed to start the assessment process. To develop a fully comprehensive assessment program, consider developing the missing assessment elements.  <br /><br />
							You will need access to all your assessment elements that you check marked to start Amee's 6-step process. You may investigate on your own, but we highly suggest using the Escort Pilot to make the process easier. 

						<?php } else { ?>

							Your program needs <b>Ground Work!</b> You are missing the appropriate number of assessment elements to sufficiently complete the assessment process. This means you will have some delay in preparing your assessment plan. <br /><br />
							 You will need access to all your assessment elements that you check marked to start Amee's 6-step process. Rather than investigating on your own, we highly suggest using the Escort Pilot to navigate your way through each assessment step.  
 
						<?php } ?>
						<span class="bq2_end"></span>
					</blockquote><br />
				<?php } ?>
			</div>
		</div>
	
		<div class="box-footer">
			<button type="submit" class="btn btn-primary" id="saveBtn">Save &amp; Update</button>	
		</div>
	</div>
	</form>
</div>
<script>
jQuery(function () {
	jQuery('#readnessFrm').validate({
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
			var form = jQuery('#readnessFrm');
			var url = site_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#saveBtn').prop("disabled", true);
					jQuery('#saveBtn').html('Saving <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'department/readiness';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#saveBtn').html('Save & Update');
						jQuery('#saveBtn').prop("disabled", false);
					}				
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#saveBtn').html('Save & Update');
					jQuery('#saveBtn').prop("disabled", false);
				}
			});		
			return false;
		}
	});
});
</script>