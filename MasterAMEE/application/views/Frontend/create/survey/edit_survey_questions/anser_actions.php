<?php if($question_type==1 || $question_type==7 || $question_type==8){ 
$get_choics	= get_choics_of_multiple_type_question($edit_question_fulldetails->question_id);
?>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;">New Choices</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_choice_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="choice_count"><?php if(count($get_choics)>0){echo '0';}else{ echo '2';}?></span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_choice_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>
<?php if($question_type!=$edit_question_fulldetails->question_type){ ?>
<div class="form-group">
	<div class="col-md-12 ">
		<?php $scale_rating_list = get_5scale_rating_list_h();?>
		<select class="form-control" onchange="return manage_automatic_multiple_choice(this.value);">
			<option value="">--Select Automatic Multiple Choices--</option>
			<?php foreach($scale_rating_list as $scale_rating_details){?>
				<option value="<?php echo $scale_rating_details->id;?>"><?php echo $scale_rating_details->name;?></option>
			<?php } ?>
		</select>
	</div>
</div>
<script type="text/javascript">	
	function manage_automatic_multiple_choice(auto_scale_id){
		jQuery(".answer_fields").remove();
		$.ajax({url: "<?php echo base_url();?>survey/get_multiple_choice_rating_ajax?scale_id="+auto_scale_id, 
			beforeSend: function(){ 
				$('.multiple_choices_manage').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result!=''){
					$('.multiple_choices_manage').html(result);
					var h_choice_count = jQuery("#h_choice_count").val();
					jQuery("#choice_count").html(h_choice_count);
				}
			}
		});
	}
</script>	
<?php } ?>
<script type="text/javascript">	
	
	function multiple_choice_manage(status){
	 
		var n = jQuery(".answer_fields").length;
		var cnt = n+1; 
		var choice_count = jQuery("#choice_count").html();
		
		if(status=='plus'){
			 
			jQuery("#choice_count").html(cnt);
			var html = '<div class="form-group answer_fields" id="div_choice_'+cnt+'"><input type="hidden" name="new_choice_arr[]" id="new_choice_arr[]" value="'+cnt+'" /><input type="text" name="choice_'+cnt+'" id="choice_'+cnt+'" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice '+cnt+'"  /></div>';
			jQuery( ".multiple_choices_manage" ).append( html );
			
		}else{
			jQuery("#choice_count").html(n-1);
			jQuery("#div_choice_"+n).remove();
		}
	
	}

</script>
<div class="form-group">&nbsp;</div>
<?php } ?>


<?php if($question_type==2){

$get_column	= get_choics_of_multiple_column($edit_question_fulldetails->question_id);
$get_rows = get_choics_of_multiple_rows($edit_question_fulldetails->question_id);

 ?>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;"><?php if(count($get_rows)>0){echo 'New';}?> Statements</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_statement_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="statement_count"><?php if(count($get_rows)>0){echo '0';}else{ echo '1';}?></span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_statement_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>

<script type="text/javascript">
	function multiple_statement_manage(status){
	 	
		<?php if(count($get_column)>0){?>
			var new_scale_point_count = '<?php echo count($get_column);?>';
		<?php }else{?>
			var new_scale_point_count = '0';
		<?php }?>
		var n = jQuery(".matrix_row").length;			
		var cnt = n+1; 
		var statement_count = jQuery("#statement_count").html();
		var scale_point_count = parseInt(jQuery("#scale_point_count").html());
		
 		if(status=='plus'){
			 
			jQuery("#statement_count").html(cnt);
 			
			var html = '<tr class="matrix_row div_statement_'+cnt+'"><td><input type="text" name="field_matrix_row_'+cnt+'" id="field_matrix_row_'+cnt+'" value="" class="form-control required" placeholder="Statement '+cnt+'" /></td>';
			if(new_scale_point_count>0){
				for (i = 1; i <= new_scale_point_count; i++) { 
					var html =  html + '<td class="old_column_'+i+'"  style="vertical-align:middle;"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
				}
			}
			for (i = 1; i <= scale_point_count; i++) { 
 				var html =  html + '<td class="column_'+i+'"  style="vertical-align:middle;"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
 			}
 			
			var html =  html + '</tr>';
			jQuery( ".matrix" ).append( html );
 			jQuery('#h_tr_row_count').val(cnt);	
				
		}else{
			
			if(n>0){
				jQuery("#statement_count").html(n-1);
				jQuery(".div_statement_"+n).remove();
				jQuery('#h_tr_row_count').val(n-1);
			}
		}
	}

</script>

<div class="form-group">&nbsp;</div>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;"><?php if(count($get_column)>0){echo 'New';}?> Scale Point</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_scale_point_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="scale_point_count"><?php if(count($get_column)>0){echo '0';}else{ echo '4';}?></span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_scale_point_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>
<?php if($question_type!=$edit_question_fulldetails->question_type){ ?>
<div class="form-group">
	<div class="col-md-12 ">
		<?php $scale_rating_list = get_5scale_rating_list_h();?>
		<select class="form-control" onchange="return manage_automatic_scale_point(this.value);">
			<option value="">--Select Automatic Scale Points--</option>
			<?php foreach($scale_rating_list as $scale_rating_details){?>
				<option value="<?php echo $scale_rating_details->id;?>"><?php echo $scale_rating_details->name;?></option>
			<?php } ?>
		</select>
	</div>
</div>
<script type="text/javascript">
	
	function manage_automatic_scale_point(auto_scale_id){
		
		$.ajax({url: "<?php echo base_url();?>survey/get_matrix_scale_point_rating_ajax?scale_id="+auto_scale_id, 
			beforeSend: function(){ 
				$('.loader_result_apply_automatic_matrix_scales').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result!=''){
					$('.loader_result_apply_automatic_matrix_scales').html(result);
					var h_tr_colum_count = $('#h_tr_colum_count').val();
					$('#scale_point_count').html(h_tr_colum_count);
				}
			}
		});
	}
</script>	
<?php } ?>
<script type="text/javascript">	 
	
	function multiple_scale_point_manage(status){
	 	
 		var n = jQuery(".matrix_column").length;
		var cnt = n+1; 
		var scale_point_count = jQuery("#scale_point_count").html();
		var statement_count = jQuery("#statement_count").html();
		
		<?php if(count($get_rows)>0){?>
			var new_statement_count = '<?php echo count($get_rows);?>';
		<?php }else{?>
			var new_statement_count = '0';
		<?php }?>
		 
		if(status=='plus'){
			 
			jQuery("#scale_point_count").html(cnt);
			
 			var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="text" name="field_matrix_column_'+cnt+'" id="field_matrix_column_'+cnt+'" value="" class="form-control required" placeholder="Scale point '+cnt+'" /></td>';
  			
			jQuery( ".append_matric_column" ).append( html );
			 
			if(new_statement_count>0){
				for (var ji = 1; ji <= new_statement_count; ji++) { 
					var html = '<td class="column_'+cnt+'"  style="vertical-align:middle;"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
					jQuery( ".old_div_statement_"+ji ).append( html );
  				}	
			}
			for (i = 1; i <= statement_count; i++) { 
				var html = '<td class="column_'+cnt+'"  style="vertical-align:middle;"><input name="option_row_'+i+'" id="option_row_'+i+'" value="" type="radio"></td>';
 				jQuery( ".div_statement_"+i ).append( html );
			}
			
			jQuery('#h_tr_colum_count').val(cnt);
 			
		}else{
			if(n>0){
			jQuery("#scale_point_count").html(n-1);
			jQuery(".td_matrix_column_"+n).remove();
			jQuery(".column_"+n).remove();
			
			jQuery('#h_tr_colum_count').val(n-1);
			}
		}
	}

</script>
<div class="form-group">&nbsp;</div>
<?php } ?>

<?php if($question_type==1 || $question_type==2 || $question_type==3 || $question_type==4 || $question_type==7 || $question_type==8){ ?>
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
			<input type="radio" name="validation_status" id="validation_status" class="required" <?php if(isset($edit_question_fulldetails->is_required) && $edit_question_fulldetails->is_required==1){ ?> checked="checked" <?php } ?> value="1" onclick="return valiation_check(this.value);" /> &nbsp;Yes
			&nbsp;&nbsp;&nbsp;<input type="radio" class="required" <?php if(isset($edit_question_fulldetails->is_required) && $edit_question_fulldetails->is_required==2){ ?> checked="checked" <?php } ?>  name="validation_status" id="validation_status" value="2" onclick="return valiation_check(this.value);" /> &nbsp;No
		</div>
	</div>
</div>
<script type="text/javascript">
<?php if(isset($edit_question_fulldetails->is_required) && $edit_question_fulldetails->is_required==1){ ?>
jQuery(document).ready( function (){
	jQuery("#validation_error_message").addClass(" required ");
	jQuery('#validation_error_message_div').show();
});
<?php } ?>
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
			<textarea name="validation_error_message" id="validation_error_message" rows="5" class="form-control" style="resize:none;"><?php if(isset($edit_question_fulldetails->required_message) && $edit_question_fulldetails->required_message!=''){echo $edit_question_fulldetails->required_message;}?></textarea>
		</div>
	</div>
</div>
<?php } ?>