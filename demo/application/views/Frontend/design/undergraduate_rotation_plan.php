<div class="col-md-3">	
	<h4>Would you like to add rotation plan? </h4>
</div>
<div class="col-md-9">
	<input type="radio" name="undergraduate_rotation_plan_status" id="undergraduate_rotation_plan_status" value="1" <?php if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==1){?> checked="checked" <?php } ?> onclick="return manage_rotation_plan_status(this.value,'<?php echo $undergraduate_status_value;?>');" /> <b>&nbsp;Automatic</b>&nbsp;&nbsp;
	<input type="radio" name="undergraduate_rotation_plan_status" id="undergraduate_rotation_plan_status" value="2" <?php if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==2){?> checked="checked" <?php } ?> onclick="return manage_rotation_plan_status(this.value,'<?php echo $undergraduate_status_value;?>');" /> <b>&nbsp;Manual</b>
</h4>

</div>
<script type="text/javascript">
	function func_change_rotation_plan_year(year,status){
		if(year!=''){
			window.location='<?php echo base_url();?>design/change_rotation_plan_year?year='+year+'&status='+status;
		}
	}
</script>
<div class="clearfix"></div><br />
<div class="col-md-1">
 	<h4 style="padding-top:5px; font-weight:600;">Start Plan </h4>
</div>
<div class="col-md-2">
	<select class="form-control" onchange="return func_change_rotation_plan_year(this.value,'<?php echo $undergraduate_status_value;?>');">
		<option value="">--select--</option>
		<?php for($yr=2020;$yr<=2030;$yr++){?>
		<option value="<?php echo $yr;?>" <?php if(isset($rotation_plan_start_year) && $rotation_plan_start_year==$yr){?> selected="selected" <?php } ?>><?php echo $yr;?></option>
		<?php } ?>
	</select>
</div>

<?php 
if(isset($rotation_plan_start_year) && $rotation_plan_start_year!='' && $rotation_plan_start_year>0){

	if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==1){
		include(APPPATH.'views/Frontend/design/undergraduate_automatic_rotation_plan.php');
	}
	
	if(isset($undergraduate_rotation_plan_status) && $undergraduate_rotation_plan_status==2){
		if(isset($_GET['edit']) && $_GET['edit']==1 && isset($_GET['status']) && $_GET['status']==$undergraduate_status_value){
			include(APPPATH.'views/Frontend/design/edit_undergraduate_manual_rotation_plan.php');
		}else{
			include(APPPATH.'views/Frontend/design/undergraduate_manual_rotation_plan.php');
		}	
	}

}else{
	
	echo '<div class="col-md-12 mart10"><h4 class="padding10"><i>-- no start plan year added yet, please select the start plan year from above dropdown --</i> </h4></div>';

}

?>