<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3> Effectiveness Data Dashboard</h3>
	<div class="btn_div">
<a class="btn btn-primary" style="padding:5px 15px;" href="<?php echo base_url();?>department/create/effectiveness_data/manage"><i class="fa fa-plus" aria-hidden="true"></i> Add Effectiveness Data</a>
<!--<a class="btn btn-warning" style="padding:5px 15px;" onclick="return archive_delete_effectiveness('1');"><i class="fa fa-archive" aria-hidden="true"></i> Archive</a>-->
<a class="btn btn-danger" style="padding:5px 15px;" onclick="return archive_delete_effectiveness('2');"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
</div>
 </div>

<div class="clearfix"></div>		  
<table class="table table-striped table-bordered" id="table_recordtbl25">
	<thead>
		<tr class="trbg">
			<th style="vertical-align:middle; text-align:center;" width="3%"><input type="checkbox" name="list_check" id="selectall"></th>
			<th style="vertical-align:middle;">Title </th>
			<th style="vertical-align:middle;">Creation Date </th>
			<th style="vertical-align:middle;">Action</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($effectiveness_data_listing as $effectiveness_data){?>
	
		<tr>
			<td style="text-align:center;"><input class="case" type="checkbox" name="unit_id[]" id="unit_id[]" value="<?php echo $effectiveness_data->id;?>"></td>
			<td><a style="font-weight:600;"  href="<?php echo base_url();?>department/create/effectiveness_data/manage?data_id=<?php echo $effectiveness_data->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>"><?php echo ucwords($effectiveness_data->academic_unit_name);?></a></td>
			<td><?php echo date('m/d/Y',$effectiveness_data->add_date);?></td>
			<td>
				<a href="<?php echo base_url();?>department/create/effectiveness_data/manage?data_id=<?php echo $effectiveness_data->id;?>&dept_id=<?php echo $this->session->userdata('dept_id');?>" class="btn btn-success btn-xs">Edit</a>
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


function archive_delete_effectiveness(status){
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
			window.location='<?php echo base_url();?>effectiveness_data/archive_delete_effectiveness?arr='+new_array+'&status='+status;
		}
	}	
}
</script>