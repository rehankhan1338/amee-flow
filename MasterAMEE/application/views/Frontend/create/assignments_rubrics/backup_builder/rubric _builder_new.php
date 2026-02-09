<style type="text/css">
	#survey_configuration h4{ font-weight:600; font-size:16px;}
	#survey_configuration{ margin:0px 20px;}
	.contenttitle2{margin:20px 0;border-bottom: 2px dotted #FB9337;}
	.nxt_input{margin: 2px auto;width: 50px;}
	.score_class{vertical-align: middle!important;padding: 0px 20px 20px!important;}

</style>

<div id="survey_configuration" class="subcontent" >
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>survey/add_survey_configuration" enctype="multipart/form-data">
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Rubric Builder </h3>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="inputEmail3"><h4>Would you like to create a rubric for this assignment? </h4></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" onclick="checkbox_rubric_yes(this.value);" name="radio_rubric" value="0" id="radio_rubric"/> Yes&nbsp;&nbsp;
				<input type="radio" onclick="checkbox_rubric_no(this.value);" name="radio_rubric" value="1" id="radio_rubric" checked="checked" /> No
			</div>
		</div>

<div class="col-md-12" id="introduction_show" style="display: none">	
<div class="col-md-10">
	<div class="form-group">&nbsp;</div>	
	<table class="matrix table" >
		<thead>
			<tr class="append_matric_column trbg">
				<td style="visibility:hidden;">Categories</td>
				<td class="matrix_column td_matrix_column_1">
					<input type="text" name="field_matrix_column_1" id="field_matrix_column_1" value="" class="form-control required" placeholder="Scale range 1" />
					<input type="text" name="field_matrix_column_1" id="field_matrix_column_1" value="" class="form-control nxt_input required"/>
				</td>		

				<td class="matrix_column td_matrix_column_2">
					<input type="text" name="field_matrix_column_2" id="field_matrix_column_2" value="" class="form-control required" placeholder="Scale range 2" />
					<input type="text" name="field_matrix_column_2" id="field_matrix_column_2" value="" class="form-control nxt_input required"/>
				</td>

				<td class="matrix_column td_matrix_column_3">
					<input type="text" name="field_matrix_column_3" id="field_matrix_column_3" value="" class="form-control required" placeholder="Scale range 3" />
					<input type="text" name="field_matrix_column_3" id="field_matrix_column_3" value="" class="form-control nxt_input required"/>
				</td>			

				<td class="matrix_column td_matrix_column_4">
					<input type="text" name="field_matrix_column_4" id="field_matrix_column_4" value="" class="form-control required" placeholder="Scale range 4" />
					<input type="text" name="field_matrix_column_4" id="field_matrix_column_4" value="" class="form-control nxt_input required"/>
				</td>				
				
				<td class="score_class"><b>Score</b></td>
			</tr>
		</thead>
		<tbody>
			<tr class="matrix_row div_Categories_1" style="border-top:1px solid #dedede;">
				<td><input type="text" name="field_matrix_row_1" id="field_matrix_row_1" value="" class="form-control required" placeholder="Categories 1" /></td>
				<td class="column_1" style="vertical-align:middle;"><input class="form-control" name="option_row_1" id="option_row_1" value="" type="text" placeholder="categories_1"></td>
				<td class="column_2" style="vertical-align:middle;"><input class="form-control" name="option_row_1" id="option_row_1" value="" type="text" placeholder="categories_1"></td>
				<td class="column_3" style="vertical-align:middle;"><input class="form-control" name="option_row_1" id="option_row_1" value="" type="text" placeholder="categories_1"></td>
				<td class="column_4" style="vertical-align:middle;"><input class="form-control" name="option_row_1" id="option_row_1" value="" type="text" placeholder="categories_1"></td>
				
				<td class="" style="vertical-align:middle;"><input class="form-control" name="score_row_1" id="score_row_1" value="" type="text" placeholder="score_1"></td>
			</tr> 
		</tbody>
	</table>	
</div>

<div class="col-md-2">	
	<div class="form-group">
		<div class="col-md-12 ">
			<label style="font-weight:600;">Categoriess</label>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-12">
		<div class="col-md-12" style="font-size:20px;">
			<i class="fa fa-minus-circle" aria-hidden="true" onclick="return multiple_Categories_manage('minus');" title="Remove the last Choice" style="cursor:pointer;"></i>
				<span style="padding:10px;" id="Categories_count">1</span>
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
	var html = '<tr class="matrix_row div_Categories_'+cnt+'"><td><input type="text" name="field_matrix_row_'+cnt+'" id="field_matrix_row_'+cnt+'" value="" class="form-control required" placeholder="Categories '+cnt+'" /></td>';
		for (i = 1; i <= scale_point_count; i++) { 
			var html =  html + '<td class="column_'+i+'" style="vertical-align:middle;"><input class="form-control" name="option_row_'+cnt+'" id="option_row_'+cnt+'" placeholder="Category_'+cnt+'" value="" type="text"></td>';
		}
		//var html =  html + '<td class="column_2"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
		//var html =  html + '<td class="column_3"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>';
		//var html =  html + '<td class="column_4"><input name="option_row_'+cnt+'" id="option_row_'+cnt+'" value="" type="radio"></td>'
		var html =  html + '<td class="" style="vertical-align:middle;"><input class="form-control" name="score_row_'+cnt+'" id="score_row_'+cnt+'" placeholder="score'+cnt+'" value="" type="text"></td>';
		var html =  html + '</tr>';
		jQuery( ".matrix" ).append( html );
		jQuery('#h_tr_row_count').val(cnt);		
	}else{
		jQuery("#Categories_count").html(n-1);
		jQuery(".div_Categories_"+n).remove();
		jQuery('#h_tr_row_count').val(n-1);
	}
}
</script>

	<div class="form-group">&nbsp;</div>
	<div class="form-group">
		<div class="col-md-12 ">
			<label style="font-weight:600;">Scale range</label>
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

<script type="text/javascript">
function multiple_scale_point_manage(status){
	var n = jQuery(".matrix_column").length;
	var cnt = n+1; 
	var scale_point_count = jQuery("#scale_point_count").html();
	var Categories_count = jQuery("#Categories_count").html();

	if(status=='plus'){
		jQuery("#scale_point_count").html(cnt);
	var html = '<td class="matrix_column td_matrix_column_'+cnt+'"><input type="text" name="field_matrix_column_'+cnt+'" id="field_matrix_column_'+cnt+'" value="" class="form-control required" placeholder="Scale range '+cnt+'" /><input type="text" name="field_matrix_column_'+cnt+'" id="field_matrix_column_'+cnt+'" value="" class="form-control nxt_input required"/></td>';
		//jQuery( ".append_matric_column" ).append( html );
		jQuery('.append_matric_column td').eq(-1).before( html );

		for (i = 1; i <= Categories_count; i++) { 
			var html = '<td class="column_'+cnt+'" style="vertical-align:middle;"><input class="form-control" name="option_row_'+i+'" id="option_row_'+i+'" placeholder="categories_'+i+'" value="" type="text"></td>';
			//jQuery( ".div_Categories_"+i ).append( html );
			jQuery('.matrix_row td').eq(-1).before( html );
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
</div>
</div>

		<div class="clearfix"></div>
		<div class="margin020">
			<input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit">
		</div>
	</div>
	</form>		 
</div>
<div class="clearfix"></div>

<script type="text/javascript">
	function checkbox_rubric_yes(){ 
		jQuery('#introduction_show').show(); }	

	function checkbox_rubric_no(){ 
		jQuery('#introduction_show').hide(); }
</script>