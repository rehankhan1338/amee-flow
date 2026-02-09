<div class="clearfix"></div>
<style>
.alert{ margin:-20px 0 30px;}
</style>
<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px; <?php //if(isset($success_msg)&& $success_msg!=''){ echo '0';}else{'-20px';}?>;">
	<h3 style="font-weight:600;">Logic Models<?php //echo ucwords($logic_model_details->programName);?></h3>
	<div class="btn_div" style="float:right;">
		<a class="btn btn-primary" href="<?php echo base_url().'logic_model/create';?>"> <i class="fa fa-plus"></i> &nbsp;Create New Logic Model</a>
 	</div>
</div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on Program Name to view Logic Model.</div>
<div class="clearfix"></div>  
 <table class="table table-striped" id="table_recordtbl12">
	<thead>
	<tr class="trbg">
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">#</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Program Name</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Year</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Last Modified</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Created Date</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
	</tr> 
	 </thead>
		<tbody>
			<?php $i=1; foreach($my_logic_model_data as $row){?>
				<tr>
					<td><?php echo $i;?></td>
					<td><a class="ftdt" href="<?php echo base_url();?>logic_model/view/<?php echo $row->encryptModelId;?>"><?php echo ucwords($row->programName);?></a></td>
					<td><?php echo $row->programYear;?></td>
					<td><?php if(isset($row->lastModiTime) && $row->lastModiTime!=''){echo date('M d Y, h:i A',$row->lastModiTime);}?></td>
					<td><?php if(isset($row->createTime) && $row->createTime!=''){echo date('M d Y, h:i A',$row->createTime);}?></td>
					<td>
						<a href="<?php echo base_url();?>logic_model/edit/<?php echo $row->encryptModelId;?>" class="btn btn-success btn-xs">Edit</a>
						<a href="<?php echo base_url();?>logic_model/delete?id=<?php echo $row->encryptModelId;?>" class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this program?');">Delete</a>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
</table>
</div>
 
<div class="clearfix"></div>
	 