<section class="content">
<div class="box snapshot_page">
	 
   <!-- start body div -->
	<div class="box-body" style="padding:0;">
	<div class="table-responsive">
		<table class="table table-hover table-bordered table-striped" id="table_recordtbl12">
			<thead>
				<tr class="trbg">
					<th width="3%"  style="vertical-align:top;">#</th>
		            <th style="vertical-align:top;">Department/Program </th> 
		            <th style="vertical-align:top;">Type</th> 
		            <th style="vertical-align:top;">View Snapshot</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; foreach ($departments_details as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
 					<td style="font-weight:600;"><?php echo $row->department_name;?></td> 
 					<td>
						<?php if(!empty($row->department_type)){ $dept_id = $row->department_type;}
							$department_type_result = get_master_department_type_by_id($dept_id);
							echo $department_type_result->txt_type;
						?>
					</td> 
 					<td nowrap="nowrap">
					<a  href="<?php echo base_url();?>admin/snapshot/display/<?php echo $row->id;?>"><i style="font-size: 25px;" class="fa fa-list-alt" aria-hidden="true"></i></a> 
					</td>
				</tr>
				<?php  $i++; } ?>          

			</tbody>
		                              
		</table>

	</div>

</div>
<!-- /.box-body -->
<!-- Modal -->    
</div>	
  <!-- /.box -->
</section>
    