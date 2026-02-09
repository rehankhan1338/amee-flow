<?php

if(isset($val) && $val==1){

	$first_column_label = 'Thorough knowledge';
	$second_column_label = 'Sufficient knowledge';
	$third_column_label = 'Some knowledge';
	$fourth_column_label = 'Little Knowledge';
	$fifth_column_label = 'No discernible knowledge';
	
}else if(isset($val) && $val==2){

	$first_column_label = 'Exceeded standard';
	$second_column_label = 'Met standard';
	$third_column_label = 'Somewhat Met ';
	$fourth_column_label = 'Approached standard';
	$fifth_column_label = 'Did not meet standard';
	
}else if(isset($val) && $val==3){

	$first_column_label = 'Excellent';
	$second_column_label = 'Very Good';
	$third_column_label = 'Good';
	$fourth_column_label = 'Mediocre';
	$fifth_column_label = 'Poor';
	
} else if(isset($val) && $val==4){

	$first_column_label = 'Adept';
	$second_column_label = 'Able';
	$third_column_label = 'Inadequate';
	$fourth_column_label = '';
	$fifth_column_label = '';
	
} else {

 	$first_column_label = '';
	$second_column_label = '';
	$third_column_label = '';
	$fourth_column_label = '';
	$fifth_column_label = '';
}
?>
<tr style="text-align:center;">

	<td> 
		<input name="range_name_column_1" id="range_name_column_1" value="<?php if(isset($first_column_label) && $first_column_label!=''){echo $first_column_label;}?>" class="form-control required" placeholder="Option 1" type="text">
		<input name="oprf_column_1" id="oprf_column_1" value="" class="form-control nxt_input required" placeholder="4" type="text"> 
		<b>&ndash;</b>
		<input name="oprf_column_sec_1" id="oprf_column_sec_1" value="" class="form-control nxt_input required" placeholder="4" type="text">
	</td>		
	
	<td>
		<input name="range_name_column_2" id="range_name_column_2" value="<?php if(isset($second_column_label) && $second_column_label!=''){echo $second_column_label;}?>" class="form-control required" placeholder="Option 2" type="text">
		<input name="oprf_column_2" id="oprf_column_2" value="" class="form-control nxt_input required" placeholder="4" type="text"> 
		<b>&ndash;</b>
		<input name="oprf_column_sec_2" id="oprf_column_sec_2" value="" class="form-control nxt_input required" placeholder="4" type="text">
	</td>		
	<td>
		<input name="range_name_column_3" id="range_name_column_3" value="<?php if(isset($third_column_label) && $third_column_label!=''){echo $third_column_label;}?>" class="form-control required" placeholder="Option 3" type="text">
		<input name="oprf_column_3" id="oprf_column_3" value="" class="form-control nxt_input required" placeholder="4" type="text"> 
		<b>&ndash;</b>
		<input name="oprf_column_sec_3" id="oprf_column_sec_3" value="" class="form-control nxt_input required" placeholder="4" type="text">
	</td>		
	
	<?php if((isset($fourth_column_label) && $fourth_column_label!='') || (isset($val) && $val!=4)){?>
	<td>
		<input name="range_name_column_4" id="range_name_column_4" value="<?php if(isset($fourth_column_label) && $fourth_column_label!=''){echo $fourth_column_label;}?>" class="form-control" placeholder="Option 4" type="text">
		<input name="oprf_column_4" id="oprf_column_4" value="" class="form-control nxt_input" placeholder="4" type="text"> 
		<b>&ndash;</b>
		<input name="oprf_column_sec_4" id="oprf_column_sec_4" value="" class="form-control nxt_input" placeholder="4" type="text">
	</td>		
	<?php } ?>
	<?php if(isset($fifth_column_label) && $fifth_column_label!=''){?>
	<td>
		<input name="range_name_column_5" id="range_name_column_5" value="<?php if(isset($fifth_column_label) && $fifth_column_label!=''){echo $fifth_column_label;}?>" class="form-control required" placeholder="Option 5" type="text">
		<input name="oprf_column_5" id="oprf_column_5" value="" class="form-control nxt_input required" placeholder="5" type="text"> 
		<b>&ndash;</b> 
		<input name="oprf_column_sec_5" id="oprf_column_sec_5" value="" class="form-control nxt_input required" placeholder="5" type="text">
	</td>
<?php } ?>
</tr>

