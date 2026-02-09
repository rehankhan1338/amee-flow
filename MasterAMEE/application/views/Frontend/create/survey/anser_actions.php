<?php if($question_type==1 || $question_type==7 || $question_type==8){ ?>
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
<div class="form-group">
	<div class="col-md-12 ">
		<?php $scale_rating_list = get_5scale_rating_list_h();?>
		<select class="form-control" onchange="return manage_automatic_multiple_choice(this.value);">
			<option value="">-- Select Automatic Multiple Choices --</option>
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
				$('.multiple_choices_manage').html('<h4>Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i></h4>');
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
	
	function multiple_choice_manage(status){
	 
		var n = jQuery(".answer_fields").length;
		var cnt = n+1; 
		var choice_count = jQuery("#choice_count").html();
		
		if(status=='plus'){
			 
			jQuery("#choice_count").html(cnt);
			var html = '<div class="form-group answer_fields" id="div_choice_'+cnt+'"><input type="text" name="choice_'+cnt+'" id="choice_'+cnt+'" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice '+cnt+'"  /></div>';
			jQuery( ".multiple_choices_manage" ).append( html );
			
		}else{
			jQuery("#choice_count").html(n-1);
			jQuery("#div_choice_"+n).remove();
		}
	
	}

</script>
<div class="form-group">&nbsp;</div>
<?php } ?>


<?php if($question_type==2){ ?>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;">Statements</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_statement_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="statement_count">1</span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_statement_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>

<script type="text/javascript">
	function multiple_statement_manage(status){
	 
		var n = jQuery(".matrix_row").length;			
		var cnt = n+1; 
		var statement_count = jQuery("#statement_count").html();
		var scale_point_count = jQuery("#scale_point_count").html();
		
		if(status=='plus'){
			 
			jQuery("#statement_count").html(cnt);
 			
			var html = '<tr class="matrix_row div_statement_'+cnt+'"><td><input type="text" name="field_matrix_row_'+cnt+'" id="field_matrix_row_'+cnt+'" value="" class="form-control required" placeholder="Statement '+cnt+'" /></td>';
			
			for (i = 1; i <= scale_point_count; i++) { 
			
				var html =  html + '<td class="column_'+i+'"  style="vertical-align:middle;"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
			
			}
			//var html =  html + '<td class="column_2"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
			
			//var html =  html + '<td class="column_3"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
			
			//var html =  html + '<td class="column_4"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>'
			
			var html =  html + '</tr>';
			jQuery( ".matrix" ).append( html );
			
			jQuery('#h_tr_row_count').val(cnt);		
		}else{
			jQuery("#statement_count").html(n-1);
			jQuery(".div_statement_"+n).remove();
			
			jQuery('#h_tr_row_count').val(n-1);
		}
	}

</script>

<div class="form-group">&nbsp;</div>
<div class="form-group">
	<div class="col-md-12 ">
		<label style="font-weight:600;">Scale Point</label>
	</div>
</div>	
<div class="form-group">
	<div class="col-md-12">
	<div class="col-md-12" style="font-size:20px;">
		<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_scale_point_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="scale_point_count">4</span>
		<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_scale_point_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
	</div>
	</div>
</div>

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
	
	function multiple_scale_point_manage(status){
	 
		var n = jQuery(".matrix_column").length;
		var cnt = n+1; 
		var scale_point_count = jQuery("#scale_point_count").html();
		var statement_count = jQuery("#statement_count").html();
		
		if(status=='plus'){
			 
			jQuery("#scale_point_count").html(cnt);
			
 			var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="text" name="field_matrix_column_'+cnt+'" id="field_matrix_column_'+cnt+'" value="" class="form-control required" placeholder="Scale point '+cnt+'" /></td>';
  			
			jQuery( ".append_matric_column" ).append( html );
			
			for (i = 1; i <= statement_count; i++) { 
				var html = '<td class="column_'+cnt+'"  style="vertical-align:middle;"><input name="option_row_'+i+'" id="option_row_'+i+'" value="" type="radio"></td>';
  			
				jQuery( ".div_statement_"+i ).append( html );
			}
			jQuery('#h_tr_colum_count').val(cnt);
 			
		}else{
			jQuery("#scale_point_count").html(n-1);
			jQuery(".td_matrix_column_"+n).remove();
			jQuery(".column_"+n).remove();
			
			jQuery('#h_tr_colum_count').val(n-1);
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
			<input type="radio" name="validation_status" id="validation_status" class="required" value="1" checked="checked" onclick="return valiation_check(this.value);" /> &nbsp;Yes
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
<div class="form-group" style="display:block;" id="validation_error_message_div">
	<div class="col-md-12 ">
		<div class="col-md-12 ">
			<label>Error Message:</label>
		</div>
		<div class="col-md-12 " style="margin-top:10px;">
			<textarea name="validation_error_message" id="validation_error_message" rows="5" class="form-control" style="resize:none;">This question is required.</textarea>
		</div>
	</div>
</div>
<?php } ?>