<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:top;">Label of Direct / Indirect Measure</th>
			<th style="vertical-align:top;">Counts</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$master_direct_assessment = get_master_direct_assessment_h(); 
			$master_indirect_assessment = get_master_indirect_assessment_h();
			
			foreach($master_direct_assessment as $direct_assessment){
		
 		?>
			<tr>
				<td><?php echo $direct_assessment->name;?></td>
				<td><?php echo get_unit_direct_indirect_measure_count_h($direct_assessment->id,'direct_measures');?></td>
			</tr>
		<?php } foreach($master_indirect_assessment as $indirect_assessment){?> 
			<tr>
				<td><?php echo $indirect_assessment->name;?></td>
				<td><?php echo get_unit_direct_indirect_measure_count_h($indirect_assessment->id,'indirect_measures');?></td>
			</tr>
		<?php } ?>         
	
	</tbody>
	<tfoot>
		<tr>
			<td style="font-weight:600; font-size:18px;">Total</td>
 			<td style="font-weight:600; font-size:18px;"><?php echo count($all_direct_indirect_measures_count);?></td>
 		</tr>
	</tfoot>
</table>