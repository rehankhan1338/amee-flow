<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php echo ucwords($survey_details->survey_name);?> 
	<?php if($survey_details->status==0){?>
		<a class="survey_status_live" title="Click to Deactive Now" href="<?php echo base_url().'survey/update_survey_status_btn?status=1&id='.$survey_details->survey_id;?>"></a>
	<?php }else{?>
		<a class="survey_status_demo" title="Click to Active Now" href="<?php echo base_url().'survey/update_survey_status_btn?status=0&id='.$survey_details->survey_id;?>"></a>
	<?php } ?>
	</h3>
	<div class="btn_div">
		<a class="btn btn-primary" target="_blank" href="<?php echo base_url().'survey/form/'.$survey_details->survey_code;?>/00000">
		<i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp;Preview Survey</a>&nbsp;
 		<a class="btn btn-default" href="<?php echo base_url().'department/create/surveys';?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
 	</div>
</div>
<style type="text/css">
.panel-default > .panel-heading {
    color: #555;
    background-color: #fff;
    border-color: #e3e3e3;
    box-shadow: 0 0 3px #dedede;
    line-height: 25px;
}
</style>
<div class="clearfix"></div>
	<div class="col-md-12 instructions">
	<strong>Instructions:</strong> Select template from dropdown then you can question of selected template.
	</div>
<div class="clearfix"></div>
<div class="nrow">
<div id="survey_questions" class="subcontent margin20">
<div class="col-md-123">
	<div class="clearfix"></div>
	<div class="col-md-12 survey_inner_question_title">
		<div class="form-group">
			<h4 style="display:inline-block; font-weight:600; margin-right:20px;">Survey Templates: </h4>
			<select onchange="return apply_survey_templates(this.value);" class="form-control required" name="survey_templates_id" id="survey_templates_id" style="width:auto;display: inline-block;">
				<option value=""> -- select survey template -- </option>
 				<?php foreach($survey_templates_details as $templates_details){?>				
					<option value="<?php echo $templates_details->id;?>" <?php if(isset($_GET['stid'])&& $_GET['stid']==$templates_details->id){?> selected="seelected" <?php } ?>> <?php echo ucfirst($templates_details->name);?> </option>
				<?php } ?>
			</select>
		</div>
	</div>

	<div class="clearfix"></div>
<div class="col-md-12">
	<?php if(isset($_GET['stid']) && $_GET['stid']!=''){?>
		<?php if(count($default_surveys_questions_detail)>0){ 
		$k=1; foreach($default_surveys_questions_detail as $questions_details){?>
		<div class="bs-example">
		<div class="panel-group" id="accordion_<?php echo $questions_details->question_id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<input type="checkbox" name="default_questions_ids[]" id="default_questions_ids[]" value="<?php echo $questions_details->question_id; ?>" class="case" />&nbsp;&nbsp;<a data-toggle="collapse" data-parent="#accordion_<?php echo $questions_details->question_id; ?>" href="#collapse_<?php echo $questions_details->question_id; ?>"><?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){echo '<b>Q.</b> '.ucfirst($questions_details->question_title);}?> 
				<b style="font-weight:600;">
					<?php if($questions_details->question_type==1){ echo ' (Multiple Choice)';}?>
					<?php if($questions_details->question_type==2){ echo ' (Matrix Table)';}?>
					<?php if($questions_details->question_type==3){ echo ' (Text Area)';}?>
					<?php if($questions_details->question_type==4){ echo ' (Net Promoter Score)';}?>
				</b>
				</a>
				</h4>
			</div>				

			 
		</div>
		</div>
		</div>

	<?php $k++;} ?>	

		<div class="col-md-12 margin20">
			<div class="col-md-4"></div>
			<div class="col-md-4"><a class="btn btn-default" onclick="return import_questions('<?php echo $survey_details->survey_id;?>','<?php echo $_GET['stid'];?>');" >Import Questions into Survey</a>	</div>
			<div class="col-md-4"></div>
		</div>
	<?php } ?>
	<?php } ?>	
</div></div>
</div>
</div>

<script type="text/javascript">
	function import_questions(survey_id,survey_template_id){
		var new_array=[];
		jQuery(".case:checked").each(function() {
			var n_total=parseInt(jQuery(this).val());
			new_array.push(n_total);
		}); 

		if(new_array==''){
			alert('Please select at least one question.');
		}else{
			var result = confirm("Are You Sure u want to import selected questions?");
			if(result){
			   window.location='<?php echo base_url();?>survey/import_default_questions?ques_id='+new_array+'&survey_id='+survey_id+'&survey_template_id='+survey_template_id;
			}
		}	
	}

	function apply_survey_templates(){
		var survey_templates_id = jQuery("#survey_templates_id").val();
 		if(survey_templates_id!=''){
			window.location = '?stid='+survey_templates_id;
		}
	}
</script>