<div class="assignment_raters">
<script type="text/javascript">  
jQuery(function () {  
jQuery('#frm').validate({
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
function check_rater_name(){
	alert('Please enter you name first!');
}
</script>
	<div class="instructions_rater form-group">
		<form method="post" action="<?php echo base_url();?>assignment_raters/save_assingment_raters_name" id="frm">
			<div class="col-md-9"><strong>Note:</strong>  (1) Please add your name to the content box to the right and click save to populate assignments, then (2) Click RATE NOW to review and evaluate the assignment.</div>
			<div class="col-md-2">
				<input type="text" class="form-control required" name="rater_name" id="rater_name" value="<?php if(isset($rater_details->rater_name) && $rater_details->rater_name!=''){echo $rater_details->rater_name;}?>" />
				<input type="hidden" name="h_auth_code" id="h_auth_code" value="<?php echo $auth_code;?>" />
				<input type="hidden" name="h_assignment_code" id="h_assignment_code" value="<?php echo $assingment_code;?>" />
			</div> 
			<div class="col-md-1"><input type="submit" name="save_raters" class="next_btn_save" value="Save" /></div>
		</form>
	</div>
	<?php if(isset($success_msg) && $success_msg!=''){?>
		<div class="success_msg"><?php echo $success_msg;?></div>
	<?php } ?>
	<table class="table table-striped table-bordered">
		<thead>
			<tr class="trbg">
				<th width="3%">#</th>
				<th>Assignment Takers</th>
				<th>Completed Assignment </th>
				<th>Rater Status</th>
				<th>Completed On</th>
				<th>Rate Assignment</th>
			</tr>
		</thead>
		<tbody>
			<?php $i=1;foreach($assingment_user_listing as $assingment_user){
			
				$raters_feedback_details = get_raters_feedback_details_h($assingment_user->assingment_id,$auth_code,$assingment_user->auth_code);
				
				?>
				<tr>
					<td><?php echo $i;?></td>
					<td style="font-weight:600;"><?php echo $assingment_user->auth_code; if(isset($assingment_user->first_name) && $assingment_user->first_name!=''){ echo ' / '.$assingment_user->first_name.' '.$assingment_user->last_name;}?></td>
					<td><?php if(isset($assingment_user->finish_status) && $assingment_user->finish_status==1){?>
						<label class="mstus accepted">Yes</label>
					<?php }else{?>
					<label class="mstus rejected">No</label>
					<?php }?></td>
					<td><?php 
					if(isset($raters_feedback_details->final_answer_status) && $raters_feedback_details->final_answer_status==1){echo '<label class="mstus accepted">Completed</span>';}
					else if(isset($raters_feedback_details->final_answer_status) && $raters_feedback_details->final_answer_status==2){echo '<label class="mstus rejected">Incomplete</label>';}
					else{echo '<label class="mstus pending">Pending</label>';}?></td>
					<td><?php if(isset($assingment_user->finish_date) && $assingment_user->finish_date!=''){echo date('d M Y, h:i A',$assingment_user->finish_date);}else{echo '-';}?></td>
					<td>
						<?php if(isset($rater_details->rater_name) && $rater_details->rater_name!=''){?>
							<a href="<?php echo base_url();?>assignment/rating/<?php echo $assingment_code;?>/<?php echo $auth_code;?>/<?php echo $assingment_user->auth_code;?>" style="color:#<?php if(isset($raters_feedback_details->final_answer_status) && $raters_feedback_details->final_answer_status==1){echo '006600';}else{echo '333333';}?>; font-weight:600;">
							<?php if(isset($raters_feedback_details->final_answer_status) && $raters_feedback_details->final_answer_status==1){echo 'Already Rated';}else{echo 'Rate Now';}?>
							</a>
						<?php }else{ ?>
							<a onclick="return check_rater_name();" style="color:#fb9337; font-weight:600;">Rate Now</a>
						<?php } ?>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
	</table>	
	
 
</div>
 