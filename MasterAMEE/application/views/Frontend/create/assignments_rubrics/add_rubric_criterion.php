<style>
#survey_configuration h4{ font-weight:600; font-size:16px;}
#survey_configuration{ margin:0 20px;}
.contenttitle2{margin:20px 0;border-bottom: 2px dotted #FB9337;}
textarea{resize:none;}
.trbg .error {color: #d5706e;}
.nxt_input{ display:inline-block; margin:10px auto;width: 30%;}
</style>
<div id="survey_configuration" class="subcontent" >
	 <div class="col-md-12">	
		<div class="contenttitle2 nomargintop">
			<h3> Rubric Criterion </h3>
		</div>
	 
	</div> 	
	

<?php if(isset($assignments_rubrics_row->rubric_status)&&$assignments_rubrics_row->rubric_status==1){?>	
<div class="col-md-12" id="introduction_show">	
	 	<?php $criterion_heading_listing = get_assignments_rubrics_criterion_heading($assignments_rubrics_row->id); ?>

<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/manage_rubric_criterion" enctype="multipart/form-data">
<!--<div class="col-md-12">	
	<div class="form-group">&nbsp;</div>
	<div class="form-group">
		<div class="col-md-12 ">
			<label style="font-weight:600;"><h4>Scale range</h4></label>
		</div>
	</div>	

	<div class="form-group">
		<div class="col-md-12">
		<div class="col-md-12" style="font-size:20px;margin-top:15px;">
			<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_scale_point_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
			<span style="padding:10px;" id="scale_point_count"><?php if(count($criterion_heading_listing)>0){echo count($criterion_heading_listing);}else{echo '4';} ?></span>
			
			<input type="hidden" name="hidden_ar_id" id="hidden_ar_id" value="<?php echo $assignments_rubrics_row->id;?>">
			<input type="hidden" name="h_scale_point_count" id="h_scale_point_count" value="<?php if(count($criterion_heading_listing)>0){echo count($criterion_heading_listing);}else{echo '4';} ?>">
				
			<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_scale_point_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
		</div>
		</div>
	</div>
 
</div>-->

<table class="matrix table table-bordered">
	<thead>
		<tr class="trbg">
			<td id="d_colspan" colspan="<?php if(count($criterion_heading_listing)>0){ echo count($criterion_heading_listing);}?>">
			<h4 style="font-size:18px;">Rubric Criterion
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_scale_point_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
				<span style="padding:10px;" id="scale_point_count"><?php if(count($criterion_heading_listing)>0){echo count($criterion_heading_listing);}else{echo '4';} ?></span>
				
				<input type="hidden" name="hidden_ar_id" id="hidden_ar_id" value="<?php echo $assignments_rubrics_row->id;?>">
				<input type="hidden" name="h_scale_point_count" id="h_scale_point_count" value="<?php if(count($criterion_heading_listing)>0){echo count($criterion_heading_listing);}else{echo '4';} ?>">
				
				<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_scale_point_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
				
			</h4></td>
		</tr>
	</thead>
	<tbody>
	
		<tr class="append_matric_column" style="text-align:center;">
			<?php foreach($criterion_heading_listing as $heading_details){ ?>	
			
				<td class="matrix_column td_matrix_column_<?php echo $heading_details->column_no;?>">
				
				<input type="hidden" name="h_heading_id[]" id="h_heading_id[]" value="<?php echo $heading_details->id;?>">
				<input type="text" name="range_name_column_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" id="range_name_column_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" value="<?php if(isset($heading_details->range_name_column)&& $heading_details->range_name_column!=''){echo $heading_details->range_name_column;}?>" class="form-control required" placeholder="Category"/>
			
				<input type="text" name="oprf_column_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" id="oprf_column_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" value="<?php if(isset($heading_details->oprf_column)&& $heading_details->oprf_column!=''){echo $heading_details->oprf_column;}?>" class="form-control nxt_input required" placeholder="4" /> 
			<b>&ndash;</b>
				<input type="text" name="oprf_column_sec_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" id="oprf_column_sec_<?php if(isset($heading_details->column_no)&& $heading_details->column_no!=''){echo $heading_details->column_no;}else{echo '1';} ?>" value="<?php if(isset($heading_details->oprf_column_sec)&& $heading_details->oprf_column_sec!=''){echo $heading_details->oprf_column_sec;}?>" class="form-control nxt_input required" placeholder="4"/>
				
 				</td>		
			<?php } ?>	
		</tr>
	
	</tbody>
</table>
 
<script type="text/javascript">
function multiple_scale_point_manage(status){
	var n = jQuery(".matrix_column").length;
	var cnt = n+1; 
	var scale_point_count = jQuery("#scale_point_count").html();
	var Categories_count = jQuery("#Categories_count").html();

	if(status=='plus'){
	
		jQuery("#scale_point_count").html(cnt);
		jQuery("#h_scale_point_count").val(cnt);
		jQuery('#d_colspan').attr('colspan',cnt);
		
		var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="text" name="range_name_column_'+cnt+'" id="range_name_column_'+cnt+'" value="" class="form-control required" placeholder="Scale range '+cnt+'" /><span id="span_inline"><input type="text" name="oprf_column_'+cnt+'" id="oprf_column_'+cnt+'" value="" class="form-control nxt_input required" placeholder="'+cnt+'"/> <b>&ndash;</b> <input type="text" name="oprf_column_sec_'+cnt+'" id="oprf_column_sec_'+cnt+'" value="" class="form-control nxt_input required" placeholder="'+cnt+'" /></span></td>';
		
		jQuery( ".append_matric_column" ).append( html );
		
	}else{
	
	 	jQuery('#d_colspan').attr('colspan',n-1);
		jQuery("#scale_point_count").html(n-1);
		jQuery("#h_scale_point_count").val(n-1);
		jQuery(".td_matrix_column_"+n).remove();
		jQuery(".column_"+n).remove(); 
	}
}
</script>
<div class="clearfix"></div> 
<input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit"> 
</form>
</div>
<?php } ?>
</div>

<div class="clearfix"></div>