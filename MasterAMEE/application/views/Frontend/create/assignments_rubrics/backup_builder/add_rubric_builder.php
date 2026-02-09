<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/manage_rubric_builder" enctype="multipart/form-data">

<div class="col-md-10">
	<table class="matrix table table-bordered" >
		<thead>
			<tr class="append_matric_column trbg" style="text-align:center;">
				<td style="text-align:center; vertical-align:middle; font-weight:600;">Categories</td>
				<td class="matrix_column td_matrix_column_1">
					<input type="text" name="range_name_column_1" id="range_name_column_1" value="" class="form-control required" placeholder="Excellent" />
					<input type="text" name="oprf_column_1" id="oprf_column_1" value="" class="form-control nxt_input required" placeholder="4" />
				</td>	
				
				<td class="matrix_column td_matrix_column_2">
					<input type="text" name="range_name_column_2" id="range_name_column_2" value="" class="form-control required" placeholder="Good" />
					<input type="text" name="oprf_column_2" id="oprf_column_2" value="" class="form-control nxt_input required" placeholder="3" />
				</td>
				
				<td class="matrix_column td_matrix_column_3">
					<input type="text" name="range_name_column_3" id="range_name_column_3" value="" class="form-control required" placeholder="Need Work" />
					<input type="text" name="oprf_column_3" id="oprf_column_3" value="" class="form-control nxt_input required" placeholder="2" />
				</td>	
				
				<td class="matrix_column td_matrix_column_4">
					<input type="text" name="range_name_column_4" id="range_name_column_4" value="" class="form-control required" placeholder="Does Not Meet SLO" />
					<input type="text" name="oprf_column_4" id="oprf_column_4" value="" class="form-control nxt_input required" placeholder="1" />
				</td>
				<td  style="text-align:center; vertical-align:middle; font-weight:600;">Scores</td>
			</tr>
		</thead>
		
		<tbody>
			<tr class="matrix_row div_Categories_1" style="border-top:1px solid #dedede;">

				<td><textarea name="category_row_1" id="category_row_1" value="" class="form-control required" rows="5" placeholder="Categories 1"></textarea></td>

				<td class="column_1" style="vertical-align:middle;"><textarea class="form-control required" name="option_row_1_column_1" rows="5" id="option_row_1_column_1"></textarea></td>

				<td class="column_2" style="vertical-align:middle;"><textarea class="form-control required" name="option_row_1_column_2" rows="5" id="option_row_1_column_2"></textarea></td>

				<td class="column_3" style="vertical-align:middle;"><textarea class="form-control required" name="option_row_1_column_3" rows="5" id="option_row_1_column_3"></textarea></td>

				<td class="column_4" style="vertical-align:middle;"><textarea class="form-control  required" name="option_row_1_column_4" rows="5" id="option_row_1_column_4"></textarea></td>

				<td><input type="text" name="score_field_matrix_row_1" id="score_field_matrix_row_1" value="" class="form-control required" placeholder="Score 1" /></td>
			</tr> 
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
		<div class="col-md-12" style="font-size:20px;margin-top:15px;">
			<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_Categories_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
				<span style="padding:10px;" id="Categories_count">1</span>				

				<input type="hidden" name="h_ar_id" id="h_ar_id" value="<?php echo $assignments_rubrics_row->id;?>">
				<input type="hidden" name="h_Categories_count" id="h_Categories_count" value="1">

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
	var html = '<tr class="matrix_row div_Categories_'+cnt+'"><td><textarea name="category_row_'+cnt+'" rows="5" id="category_row_'+cnt+'" value="" class="form-control required" placeholder="Categories '+cnt+'"></textarea></td>';
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

				<span style="padding:10px;" id="scale_point_count">4</span>

				<input type="hidden" name="h_scale_point_count" id="h_scale_point_count" value="4">

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

	var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="text" name="range_name_column_'+cnt+'" id="range_name_column_'+cnt+'" value="" class="form-control required" placeholder="Scale range '+cnt+'" /><input type="text" name="oprf_column_'+cnt+'" id="oprf_column_'+cnt+'" value="" class="form-control nxt_input required" placeholder="Scale range '+cnt+'"/></td>';

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