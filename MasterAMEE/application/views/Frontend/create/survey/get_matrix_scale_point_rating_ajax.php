<?php $options = explode('@@',$multiple_choice_rating_list->options);?>
<input type="hidden" name="h_tr_row_count" id="h_tr_row_count" value="1">
<input type="hidden" name="h_tr_colum_count" id="h_tr_colum_count" value="<?php echo count($options);//count($options)-2;?>">
<table class="matrix table" >
	<thead>
		<tr class="append_matric_column">
			<td style="visibility:hidden;">Categories</td>
			<?php 			
			for($i=0;$i<count($options);$i++){ 
				if(trim($options[$i])!=''){// && trim($options[$i])!='Not applicable'
					$j=$i+1;
			?>
			<td class="matrix_column td_matrix_column_<?php echo $j;?>"><input type="text" name="field_matrix_column_<?php echo $j;?>" id="field_matrix_column_<?php echo $j;?>" value="<?php echo $options[$i];?>" class="form-control required" placeholder="Scale point <?php echo $j;?>" /></td>
			<?php } } ?>
		</tr>
	</thead>
	<tbody>
		<tr class="matrix_row div_statement_1" style="border-top:1px solid #dedede;">
			<td><input type="text" name="field_matrix_row_1" id="field_matrix_row_1" value="" class="form-control required" placeholder="Statement 1" /></td>
			<?php for($i=0;$i<count($options);$i++){ if(trim($options[$i])!=''){// && trim($options[$i])!='Not applicable' $j=$i+1; ?>
				<td class="column_<?php echo $j;?>" style="vertical-align:middle;"><input name="option_row_<?php echo $j;?>" id="option_row_<?php echo $j;?>" value="" type="radio"></td>
			<?php } } ?>
		</tr> 
	</tbody>
</table>