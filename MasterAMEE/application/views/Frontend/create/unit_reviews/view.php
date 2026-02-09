<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3> Unit Analysis Review Dashboard</h3>
	<div class="btn_div">
<a class="btn btn-primary" style="padding:5px 15px;" href="<?php echo base_url();?>department/create/unit_reviews/manage"><i class="fa fa-plus" aria-hidden="true"></i> Add Analysis Review</a>
<!--<a class="btn btn-warning" style="padding:5px 15px;" onclick="return archive_delete_unit_review('1');"><i class="fa fa-archive" aria-hidden="true"></i> Archive</a>-->
<a class="btn btn-danger" style="padding:5px 15px;" onclick="return archive_delete_unit_review('2');"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
</div>
 </div>

<div class="clearfix"></div>		  
<table class="table table-hover table-bordered table-striped" id="table_recordtbl25">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:middle;" width="3%"><input type="checkbox" name="list_check" id="selectall"></th>
			<th class="survey_listing_td" style="vertical-align:middle;" width="3%" nowrap="nowrap">#</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Title </th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Academic Year</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Creation Date </th>
			<th class="survey_listing_td" style="vertical-align:middle;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($unit_analysis_listing as $unit_analysis){?>
	
		<tr>
			<td><input class="case" type="checkbox" name="unit_id[]" id="unit_id[]" value="<?php echo $unit_analysis->id;?>"></td>
			<td><?php echo $j;?></td>
			<td><a class="ftdt" href="<?php echo base_url();?>department/create/unit_reviews/manage?unit_id=<?php echo $unit_analysis->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>"><?php echo ucwords($unit_analysis->budget_unit_name);?></a></td>
			<td><?php if(isset($unit_analysis->academic_year) && $unit_analysis->academic_year!='' && $unit_analysis->academic_year!=0){echo $unit_analysis->academic_year.' - '.($unit_analysis->academic_year+1);}?></td>
			<td><?php echo date('m/d/Y',$unit_analysis->add_date);?></td>
			<td>
				<a href="<?php echo base_url();?>department/create/unit_reviews/manage?unit_id=<?php echo $unit_analysis->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>" class="btn btn-success btn-xs">Edit</a>
 			</td>
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>

<script type="text/javascript">                 
jQuery(function(){
   // add multiple select / deselect functionality
   jQuery("#selectall").click(function () {
        jQuery('.case').attr('checked', this.checked); 
   });
   // if all checkbox are selected, check the selectall checkbox
   // and viceversa
   jQuery(".case").click(function(){
       if(jQuery(".case").length == jQuery(".case:checked").length) {
           jQuery("#selectall").attr("checked", "checked");
       } else {
           jQuery("#selectall").removeAttr("checked");
       }
   });
});


function archive_delete_unit_review(status){
	var new_array=[];
	jQuery(".case:checked").each(function() {
		var n_total=parseInt(jQuery(this).val());
		new_array.push(n_total);
	}); 
	
	if(new_array==''){
		alert('Please select at least one unit review.');
	}else{
		if(status==1){
			var result = confirm("Are You Sure u want to archive?");
		}else{
			var result = confirm("Are You Sure u want to delete?");
		}
		
		if(result){
		   window.location='<?php echo base_url();?>unit_reviews/archive_delete_unit_review?arr='+new_array+'&status='+status;
		}
	}	
}
</script>

