<?php
	$rubrics_builder_listing = get_assignments_rubrics_builder($assignments_rubrics_row->id);
	$builder_heading_listing = get_assignments_rubrics_builder_heading($assignments_rubrics_row->id);
?>

<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/update_rubric_builder" enctype="multipart/form-data">
<div class="col-md-10">
	<table class="matrix table table-bordered" >
		<thead>
			<tr class="append_matric_column trbg" style="text-align:center;">
				<td style="text-align:center; vertical-align:middle; font-weight:600;">Categories</td>

				<?php foreach($builder_heading_listing as $heading_details){?>
					<td class="matrix_column td_matrix_column_<?php echo $heading_details->column_no;?>">
						<input type="hidden" name="h_heading_id[]" id="h_heading_id[]" value="<?php echo $heading_details->id;?>">
						<input type="text" name="range_name_column_<?php echo $heading_details->column_no;?>" id="range_name_column_<?php echo $heading_details->column_no;?>" value="<?php echo $heading_details->range_name_column;?>" class="form-control required" placeholder="Excellent" />
						<input type="text" name="oprf_column_<?php echo $heading_details->column_no;?>" id="oprf_column_<?php echo $heading_details->column_no;?>" value="<?php echo $heading_details->oprf_column;?>" class="form-control nxt_input required" placeholder="4" />
					</td>
				<?php } ?>			

				<td style="text-align:center; vertical-align:middle; font-weight:600;">Scores</td>
			</tr>
		</thead>

		<tbody>
			<?php $k=1; foreach($rubrics_builder_listing as $builder_details){?>
			
				<tr class="matrix_row div_Categories_<?php echo $k;?>" style="border-top:1px solid #dedede;">
					<td>
					<input type="hidden" name="h_category_row[]" id="h_category_row[]" value="<?php echo $builder_details->rubric_id;?>">
					<textarea name="category_row_<?php echo $k;?>" id="category_row_<?php echo $k;?>" class="form-control required" rows="5" placeholder="Categories <?php echo $k;?>"><?php echo $builder_details->category_name;?></textarea></td>

					<?php $l=1; foreach($builder_heading_listing as $heading_details){
						
						$option_value = get_assignments_rubrics_builder_option_details($heading_details->column_no, $builder_details->rubric_id);?>

						<td class="column_<?php echo $l;?>" style="vertical-align:middle;"><textarea class="form-control required" name="option_row_<?php echo $k;?>_column_<?php echo $l;?>" rows="5" id="option_row_<?php echo $k;?>_column_<?php echo $l;?>"><?php echo $option_value;?></textarea></td>
					<?php $l++; }?>

					<td><input type="text" name="score_field_matrix_row_<?php echo $k;?>" id="score_field_matrix_row_<?php echo $k;?>" value="<?php echo $builder_details->score_field;?>" class="form-control required" placeholder="Score <?php echo $k;?>" /></td>
				</tr> 		

			<?php $k++; }?>
		</tbody>
	</table>	
</div>

<div class="col-md-2">	
	<div class="form-group">
		<div class="col-md-12 ">
			<label style="font-weight:600;"><h4>Categoriess</h4></label>
		</div>
	</div>	

	<div class="form-group">
		<div class="col-md-12">
		<div class="col-md-12" style="font-size:20px; margin-top:15px;">
			<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_Categories_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
				<span style="padding:10px;" id="Categories_count"><?php echo count($rubrics_builder_listing); ?></span>

				<input type="hidden" name="h_ar_id" id="h_ar_id" value="<?php echo $assignments_rubrics_row->id;?>">
				<input type="hidden" name="h_Categories_count" id="h_Categories_count" value="<?php echo count($rubrics_builder_listing); ?>">
			<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_Categories_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>
		</div>
		</div>
	</div>

<script type="text/javascript">

function multiple_Categories_manage(status){

	var n = jQuery(".matrix_row").length;			

	var cnt = n+1; 

	var Categories_count = jQuery("#Categories_count").html();

	var scale_point_count = jQuery("#scale_point_count").html();



	if(status=='plus'){

		jQuery("#Categories_count").html(cnt);

		jQuery("#h_Categories_count").val(cnt);

	var html = '<tr class="matrix_row div_Categories_'+cnt+'"><td><input type="hidden" name="h_category_row[]" id="h_category_row[]" value="0"><textarea name="category_row_'+cnt+'" rows="5" id="category_row_'+cnt+'" value="" class="form-control required" placeholder="Categories '+cnt+'"></textarea></td>';

		for (i = 1; i <= scale_point_count; i++) { 

			var html =  html + '<td class="column_'+i+'" style="vertical-align:middle;"><textarea rows="5" class="form-control required" name="option_row_'+cnt+'_column_'+i+'" id="option_row_'+cnt+'_column_'+i+'" placeholder="val_'+cnt+'"></textarea></td>';

		}

		//var html =  html + '<td class="column_2"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';

		//var html =  html + '<td class="column_3"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';

		//var html =  html + '<td class="column_4"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>'

		var html = html + '<td><input type="text" name="score_field_matrix_row_'+cnt+'" id="score_field_matrix_row_'+cnt+'" value="" class="form-control required" placeholder="Score '+cnt+'" /></td>';

		var html =  html + '</tr>';

		jQuery( ".matrix" ).append( html );

		jQuery('#h_tr_row_count').val(cnt);		

	}else{

		jQuery("#Categories_count").html(n-1);

		jQuery("#h_Categories_count").val(n-1);

		jQuery(".div_Categories_"+n).remove();

		jQuery('#h_tr_row_count').val(n-1);

	}

}

</script>



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

				<span style="padding:10px;" id="scale_point_count"><?php echo count($builder_heading_listing); ?></span>

				<input type="hidden" name="h_scale_point_count" id="h_scale_point_count" value="<?php echo count($builder_heading_listing); ?>">

			<i class="fa fa-plus-circle" aria-hidden="true"  onclick="return multiple_scale_point_manage('plus');" title="Add a Choice" style="cursor:pointer;"></i>

		</div>

		</div>

	</div>



<script type="text/javascript">

function multiple_scale_point_manage(status){

	var n = jQuery(".matrix_column").length;

	var cnt = n+1; 

	var scale_point_count = jQuery("#scale_point_count").html();

	var Categories_count = jQuery("#Categories_count").html();



	if(status=='plus'){

		jQuery("#scale_point_count").html(cnt);

		jQuery("#h_scale_point_count").val(cnt);

	var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="hidden" name="h_heading_id[]" id="h_heading_id[]" value="0"><input type="text" name="range_name_column_'+cnt+'" id="range_name_column_'+cnt+'" value="" class="form-control required" placeholder="Scale range '+cnt+'" /><input type="text" name="oprf_column_'+cnt+'" id="oprf_column_'+cnt+'" value="" class="form-control nxt_input required" placeholder="Scale range '+cnt+'"/></td>';

		//jQuery( ".append_matric_column" ).append( html );

		jQuery('.append_matric_column td').eq(-1).before( html );



		for (i = 1; i <= Categories_count; i++) { 

			var html = '<td class="column_'+cnt+'" style="vertical-align:middle;"><textarea rows="5" class="form-control required" name="option_row_'+i+'_column_'+cnt+'" id="option_row_'+i+'_column_'+cnt+'" placeholder="v_'+i+'"></textarea></td>';

			//jQuery( ".div_Categories_"+i ).append( html );

			jQuery('.div_Categories_'+i+' td').eq(-1).before( html );

		}

		jQuery('#h_tr_colum_count').val(cnt);

	}else{

		jQuery("#scale_point_count").html(n-1);

		jQuery("#h_scale_point_count").val(n-1);

		jQuery(".td_matrix_column_"+n).remove();

		jQuery(".column_"+n).remove();

		jQuery('#h_tr_colum_count').val(n-1);

	}

}

</script>	

</div>

		<div class="clearfix"></div>

	<div class="col-md-12">

			<input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit">

		</div>

	</form>