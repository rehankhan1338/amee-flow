<style type="text/css">
	#survey_configuration h4{ font-weight:600; font-size:16px;}
	#survey_configuration{ margin:0px 20px;}
	.contenttitle2{margin:20px 0;border-bottom: 2px dotted #FB9337;}
	.nxt_input{margin: 2px auto;width: 50px;}
	textarea{resize:none;}
	.trbg .error {color: #d5706e;}
</style>

<div id="survey_configuration" class="subcontent" >
	<div class="col-md-12">	
		<div class="contenttitle2 nomargintop">
			<h3> Rubric Builder </h3>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="inputEmail3"><h4 style="letter-spacing:0.5px">Would you like to create a rubric for this assignment? </h4></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" onclick="checkbox_rubric(this.value);" name="radio_rubric" value="1" id="radio_rubric" <?php if(isset($assignments_rubrics_row->rubric_status)&&$assignments_rubrics_row->rubric_status=='1'){?> checked="checked" <?php } ?>/> &nbsp;&nbsp;Yes&nbsp;&nbsp;
				<input type="radio" onclick="checkbox_rubric(this.value);" name="radio_rubric" value="2" id="radio_rubric" <?php if(isset($assignments_rubrics_row->rubric_status)&&$assignments_rubrics_row->rubric_status=='2'){?> checked="checked" <?php } ?>/> &nbsp;&nbsp;No
			</div>
		</div>
	</div>	
	
	
<?php if(isset($assignments_rubrics_row->rubric_status)&&$assignments_rubrics_row->rubric_status==1){?>	
<div class="col-md-12" id="introduction_show">	
	
	<?php $builder_status = check_assignments_rubrics_builder_status($assignments_rubrics_row->id);
		if($builder_status>0){
			
			include(APPPATH.'views/Frontend/create/assignments_rubrics/edit_rubric_builder.php');
			
		}else{
			
			include(APPPATH.'views/Frontend/create/assignments_rubrics/add_rubric_builder.php');
			
		}
	?>
	
</div>
<?php } ?>
		 
</div>
<div class="clearfix"></div>

<script type="text/javascript">
	function checkbox_rubric(status){ 
		if(status!=''){
		
			window.location.href = '<?php echo base_url();?>assignments_rubrics/update_rubric_status?status='+status+'&ar_id=<?php echo $assignments_rubrics_row->id;?>';		
			//jQuery('#introduction_show').show(); 
		}
	}	
</script>