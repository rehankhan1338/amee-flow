<?php if($question_type==1){ ?>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;">Choices</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_choice_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="choice_count">2</span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_choice_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>
<script type="text/javascript">
		function multiple_choice_manage(status){	 
		var n = jQuery(".answer_fields").length;
		var cnt = n+1; 
		var choice_count = jQuery("#choice_count").html();		
		if(status=='plus'){			 
			jQuery("#choice_count").html(cnt);	
				var html = '<div class="col-md-12" id="div_choice_'+cnt+'"><div class="col-md-8"><div class="form-group answer_fields"><input type="text" name="choice_'+cnt+'" id="choice_'+cnt+'" value="" class="form-control required" placeholder="Insert text to write Choice '+cnt+'"  /></div></div></div>';
				//var html = html+'<div class="col-md-4"><div class="form-group" style="padding-left:60px;"><input type="radio" name="answer_radio" id="answer_radio" value="'+cnt+'" style="margin: 15px -3px 0;" /></div></div>';
			jQuery( ".multiple_choices_manage" ).append( html );			
		}else{
			jQuery("#choice_count").html(n-1);
			jQuery("#div_choice_"+n).remove();
		}	
	}
</script>
<div class="form-group">&nbsp;</div>
<?php } ?>

<?php if($question_type==1 || $question_type==2 || $question_type==3 || $question_type==4){ ?>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;">Validation</label>
	</div>
</div>
<div class="form-group">
	<div class="col-md-12 ">
		<div class="col-md-12 ">
			<label>Is Required:</label>
		</div>
		<div class="col-md-12 " style="margin-top:10px;" id="validation_status_div">
			<input type="radio" name="validation_status" id="validation_status" class="required" value="1" onclick="return valiation_check(this.value);" /> &nbsp;Yes
			&nbsp;&nbsp;&nbsp;<input type="radio" class="required"   name="validation_status" id="validation_status" value="2" onclick="return valiation_check(this.value);" /> &nbsp;No
		</div>
	</div>
</div>
<script type="text/javascript">
	function valiation_check(val){
		if(val==1){
			jQuery("#validation_error_message").addClass(" required ");
			jQuery('#validation_error_message_div').show();
		}else{
			jQuery("#validation_error_message").removeClass(" required ");
			jQuery('#validation_error_message_div').hide();
		}
	}
</script>
<div class="form-group" style="display:none;" id="validation_error_message_div">
	<div class="col-md-12 ">
		<div class="col-md-12 ">
			<label>Error Message:</label>
		</div>
		<div class="col-md-12 " style="margin-top:10px;">
			<textarea name="validation_error_message" id="validation_error_message" rows="5" class="form-control" style="resize:none;"></textarea>
		</div>
	</div>
</div>
<?php } ?>