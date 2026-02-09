<div class="clearfix"></div>
<style>
.alert{ margin:-20px 0 30px;}
</style>
<script type="text/javascript">
function deletePlan(){
	var new_array=[];
	jQuery(".case:checked").each(function() {
		var n_total=parseInt(jQuery(this).val());
		new_array.push(n_total);
	}); 
 	if(new_array==''){
		alert('Please select at least one lesson plan.');
	}else{
		var result = confirm("Are you sure u want to delete?");
 		if(result){
			window.location='<?php echo base_url().'lesson_plan/delete_plan';?>?ids='+new_array;
		}
	}
}
function makeClone(){
	var new_array=[];
	jQuery(".case:checked").each(function() {
		var n_total=parseInt(jQuery(this).val());
		new_array.push(n_total);
	}); 
 	if(new_array==''){
		alert('Please select at least one lesson plan.');
	}else{
		var url = '<?php echo base_url().'lesson_plan/make_clone';?>?ids='+new_array;
		jQuery.ajax({
			type: "POST",
			url: url,
			beforeSend: function(){
				$('#cloneBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				if(result=='success'){
					window.location='<?php echo base_url().'lesson_plan';?>';
				}
			}
		});
		return false;
	}
}
</script>
<div class="survey_heading" style="text-align: left;margin-top: -20px; margin-bottom:5px;;">
	<h3 style="font-weight:600;">Lesson Plans</h3>
	<div class="btn_div" style="float:right;">
		<a class="btn btn-danger" onclick="return deletePlan();" style="padding:4px 15px;"> <i class="fa fa-trash-o"></i> &nbsp;Delete</a>
		<a class="btn btn-default" onclick="return makeClone();" id="cloneBtn" style="margin:0 5px;padding:4px 15px;"> <i class="fa fa-clone"></i> &nbsp;Make Copy</a>
		<a class="btn btn-primary" href="<?php echo base_url().'lesson_plan/create';?>" style="padding:4px 15px;"> <i class="fa fa-plus"></i> &nbsp;Create New Lesson Plan</a>
 	</div>
</div>
<div id="resMsg"></div>
<div class="col-md-12 instructions"><strong>Instructions:</strong> Click on lesson title to view Lesson Plan.</div>
<div class="clearfix"></div>  
 <table class="table table-striped" id="table_recordtbl12">
	<thead>
	<tr class="trbg">
		<th class="survey_listing_td" width="3#" style="vertical-align:middle;">#</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Lesson Title</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Session Date</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Name of Program</th>
		<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Instructor Name</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Last Modified</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Created On</th>
		<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
	</tr> 
	 </thead>
		<tbody>
			<?php $i=1; foreach($my_lesson_plan_data as $row){?>
				<tr>
					<td><input type="checkbox" class="case" id="lessonIds[]" name="lessonIds[]" value="<?php echo $row->lessonId;?>" /></td>
					<td><a class="ftdt" href="<?php echo base_url();?>lesson_plan/view/<?php echo $row->encryptLessonId;?>"><?php echo $row->lessonTitle;?></a></td>
					<td><?php echo date('d M Y',$row->sessionDate);?></td>
					<td><?php echo ucwords($row->programName);?></td>
					<td><?php echo $row->instructorName;?></td>
					<td><?php if(isset($row->lastModiTime) && $row->lastModiTime!=''){echo date('d M Y, h:i A',$row->lastModiTime);}?></td>
					<td><?php if(isset($row->createTime) && $row->createTime!=''){echo date('d M Y, h:i A',$row->createTime);}?></td>
					<td>
						<a href="<?php echo base_url();?>lesson_plan/edit/<?php echo $row->encryptLessonId;?>" class="btn btn-success btn-xs">Edit</a>
					</td>
				</tr>
			<?php $i++;} ?>
		</tbody>
</table>
</div>
 
<div class="clearfix"></div>
	 