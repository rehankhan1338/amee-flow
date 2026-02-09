<script type="text/javascript">
function apply_academic_filter(year){
	if(year==''){
		window.location='<?php echo base_url();?>admin/unit_review?tab=2';
	}else{
		window.location='<?php echo base_url();?>admin/unit_review?tab=2&year='+year;
	}
}
</script>
<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:top;">Name of Programs</th>
			<?php if($core_functions_loop>0){ for($kl=1;$kl<=$core_functions_loop;$kl++){?>
			<th style="vertical-align:top;"><?php echo 'Core Function #'.$kl;?></th>
			<?php } } ?> 
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($unit_reviews_listing as $unit_reviews) { 
		
			$core_function_arr = get_core_functions_arr_h($unit_reviews->id); 
		
		?>
		<tr>
			<td><?php echo ucfirst($unit_reviews->budget_unit_name);?></td>
			<?php if($core_functions_loop>0){ for($kl=0;$kl<$core_functions_loop;$kl++){?>
			<td><?php if(isset($core_function_arr[$kl]->core_functions) && $core_function_arr[$kl]->core_functions!=''){echo $core_function_arr[$kl]->core_functions;}else{echo '-';}?></td>
			<?php } } ?> 
		</tr>
		<?php  $i++; } ?>          
	
	</tbody>
	<tfoot>
		<tr>
			<td style="font-weight:600; font-size:18px;">Total</td>
			<?php if($core_functions_loop>0){ for($kl=1;$kl<=$core_functions_loop;$kl++){?>
			<td style="font-weight:600; font-size:18px;"><?php echo get_core_functions_count_all_unit_h($kl); ?></td>
			<?php } } ?>
		</tr>
	</tfoot>
</table>