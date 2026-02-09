<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
	<thead>
		<tr class="trbg">
			<th width="3%"  style="vertical-align:top;">#</th>
			<th style="vertical-align:top;">Name of Programs</th>
			<th style="vertical-align:top;">Strategic Priorities </th>
		</tr>
	</thead>
	<tbody>
		<?php $i=1; foreach ($unit_reviews_listing as $unit_reviews) { ?>
		<tr>
			<td><?php echo  $i;?></td>
			<td><?php echo ucfirst($unit_reviews->budget_unit_name);?></td>
 			<td><?php echo count(get_unit_strategic_priorities_count_h($unit_reviews->id));?></td>
		</tr>
		<?php  $i++; } ?>          
	
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2" style="font-weight:600; font-size:18px;">Total Strategic Priorities</td>
 			<td style="font-weight:600; font-size:18px;"><?php echo count($all_strategic_priorities_count);?></td>
 		</tr>
	</tfoot>
</table>