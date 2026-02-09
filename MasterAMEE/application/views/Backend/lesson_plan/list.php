<section class="content">
<div class="box snapshot_page">
	<div class="box-body row" style="padding:0;">
	<div class="col-md-12 table-responsive">
		<table class="table table-hover table-bordered12 table-striped" id="table_recordtbl">
			<thead>
				<tr class="trbg">
					<th width="3%"  style="vertical-align:top;">#</th>
		            <th style="vertical-align:top;">Name of Department </th> 
		            <th style="vertical-align:top;">Lesson Title</th> 
					<th style="vertical-align:top;">Session Date</th> 
					<th style="vertical-align:top;">Program Name</th>
					<th style="vertical-align:top;">Instructor Name</th>
					<th style="vertical-align:top;">Last Updated</th> 
					<th style="vertical-align:top;">Created On</th> 
		            <th style="vertical-align:top;">View</th>
				</tr>
			</thead>			
			<tbody>
				<?php $i=1; foreach ($lesson_plan_data as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
 					<td><?php echo $row->department_name;?></td> 
 					<td style="font-weight:600;"><?php echo $row->lessonTitle;?></td> 
					<td><?php echo date('d M Y',$row->sessionDate);?></td> 
					<td><?php echo $row->programName;?></td> 
					<td><?php echo $row->instructorName;?></td> 
					<td><?php echo date('d M Y, h:i A',$row->lastModiTime);?></td> 
					<td><?php echo date('d M Y, h:i A',$row->createTime);?></td> 
 					<td nowrap="nowrap">
						<a href="<?php echo base_url();?>admin/lesson_plan/view/<?php echo $row->encryptLessonId;?>"><i style="font-size: 25px;" class="fa fa-list-alt"></i></a> 
					</td>
				</tr>
				<?php  $i++; } ?> 
			</tbody>		                              
		</table>
	</div>
</div>  
</div>	
</section>
    