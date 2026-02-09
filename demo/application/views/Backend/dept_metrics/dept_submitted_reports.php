<section class="content">
<div class="box snapshot_page">
	<div class="box-body row" style="padding:0;">
	<div class="col-md-12 table-responsive">
		<table class="table table-hover table-bordered12 table-striped" id="table_recordtbl">
			<thead>
				<tr class="trbg">
					<th width="3%"  style="vertical-align:top;">#</th>
		            <th style="vertical-align:top;">Name of Department/Program </th> 
		            <th style="vertical-align:top;">Report Title</th> 
					<th style="vertical-align:top;">Year</th> 
					<th style="vertical-align:top;">Last Modification</th> 
					<th style="vertical-align:top;">Submitted On</th> 
		            <th style="vertical-align:top;">View Snapshot</th>
				</tr>
			</thead>			
			<tbody>
				<?php $i=1; foreach ($submitted_analysis_reports as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
 					<td><?php echo $row->department_name;?></td> 
 					<td style="font-weight:600;"><?php echo $row->reportTitle;?></td> 
					<td><?php echo $row->reportYear;?></td> 
					<td><?php echo date('d M Y, h:i A',$row->lastModiTime);?></td> 
					<td><?php echo date('d M Y, h:i A',$row->lastTimeSubmittedOn);?></td> 
 					<td nowrap="nowrap">
						<a href="<?php echo base_url();?>admin/department/reports/view/<?php echo $row->encryptReportId;?>"><i style="font-size: 25px;" class="fa fa-list-alt"></i></a> 
					</td>
				</tr>
				<?php  $i++; } ?> 
			</tbody>		                              
		</table>
	</div>
</div>  
</div>	
</section>
    