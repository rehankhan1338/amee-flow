<div class="clearfix"></div>
<style>
.alert{ margin:-20px 0 30px;}
</style>
<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px;;">
	<h3 style="font-weight:600;">Closing The Loop</h3>
	<div class="btn_div" style="float:right;">
		<a class="btn btn-primary" href="<?php echo base_url().'close_the_loop/add';?>"> <i class="fa fa-plus"></i> &nbsp;Create New Year Loop</a>
 	</div>
</div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Year Title to view Loop.</div>
<div class="clearfix"></div>  
 <table class="table table-striped" id="table_recordtbl12">
	<thead>
	<tr class="trbg">
		<th class="survey_listing_td" style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Year of the Title</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Year</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Last Modified</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Created Date</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
	</tr> 
	 </thead>
		<tbody>
			<?php $i=1; foreach($closing_loop_list as $row){?>
				<tr>
					<td><?php echo $i;?></td>
					<td><a class="ftdt" href="<?php echo base_url();?>close_the_loop/view/<?php echo $row->encryptLoopId;?>"><?php echo ucwords($row->yearTitle);?></a></td>
					<td><?php echo $row->year;?></td>
					<td><?php if(isset($row->lastModiTime) && $row->lastModiTime!=''){echo date('M d Y, h:i A',$row->lastModiTime);}?></td>
					<td><?php if(isset($row->createTime) && $row->createTime!=''){echo date('M d Y, h:i A',$row->createTime);}?></td>
					<td>
						<a href="<?php echo base_url();?>close_the_loop/edit/<?php echo $row->encryptLoopId;?>" class="btn btn-success btn-xs">Edit</a>
						<a href="<?php echo base_url();?>close_the_loop/delete?id=<?php echo $row->encryptLoopId;?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this program?');">Delete</a>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
</table>
</div>
 
<div class="clearfix"></div>
	 