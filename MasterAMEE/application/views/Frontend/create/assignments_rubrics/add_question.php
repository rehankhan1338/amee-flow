<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php echo ucwords($assignments_rubrics_row->assignment_title);?> : : Question : : Add</h3>
</div>
<div class="clearfix"></div>
<div class="col-md-12 instructions">
	<strong>Instructions:</strong> Add question title then click question type to get started.
</div>
<div class="clearfix"></div>
<style>
.survey_inner_question{min-height:800px;}
.survey_inner_question_title{text-align:center;}
 .contenttitle2 {
    margin: 20px 0;
    border-bottom: 2px dotted #FB9337;
}
.error {
    color: #a94442;
    font-size: 15px !important;
    font-style: italic;
	padding-left:5px;
	font-weight:600;
}
#validation_status_div .error{position:absolute; margin-top:25px;}
table.matrix{  text-align:center;}
/*table.matrix td{ width:20%; padding:5px;}*/
table.matrix tr td:first-child{border-right: 1px solid #dedede;}
.nps span{ font-weight:600; font-size:18px;} 
</style>

<div class="survey_inner_question">
<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>assignments_rubrics/question_save" id="frm" method="post" enctype="multipart/form-data">

	<div class="col-md-12 survey_inner_question_title">
		<div class="contenttitle2 nomargintop">
			<h3> Question Title</h3>
		</div> 
		<div class="col-md-12 form-group">
			<input type="text" class="form-control required" id="rubric_question_title" style="height:40px; width:100%;" name="rubric_question_title" placeholder="Question Title" value="" />
		</div>
	</div>
	
	<div class="col-md-2" >
	 	<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<h3> Question Type</h3>
				<input type="hidden" name="hidden_ar_id" id="hidden_ar_id" value="<?php echo $assignments_rubrics_row->id;?>" />
				<input type="hidden" name="hidden_question_type" id="hidden_question_type" value="0" />
				<input type="hidden" name="hidden_choice_count" id="hidden_choice_count" value="" />
			</div> 
			
			
			<?php $master_question_type = get_master_question_type_rubric_h();
				foreach ($master_question_type as $question_type) {?>
				<div class="col-md-12" style="margin:0; padding:0;">
					<a id="selected_question_<?php echo $question_type->id;?>" onclick="return manage_questions('<?php echo $question_type->id;?>');" class="btn btn-default question_types_btn" style="margin:10px 0; width:85%"  > <?php echo $question_type->question_type;?></a>
				</div>
			<?php } ?>
	 	</div>
	</div>


<div class="col-md-8">
<script type="text/javascript">
	function manage_questions(question_type_id){
		
		jQuery("#hidden_question_type").val(question_type_id);		
		 if(question_type_id!=''){		 
		 	jQuery('.question_types_btn').css('background-color','#fff');
			jQuery('.question_types_btn').css('border-color','#ccc');
			jQuery('.question_types_btn').css('color','#333');
			
			jQuery('#selected_question_'+question_type_id).css('background-color','#34445e');
			jQuery('#selected_question_'+question_type_id).css('border-color','#34445e');
			jQuery('#selected_question_'+question_type_id).css('color','#f6e4a5');
		 	
			jQuery.ajax({
				url: '<?php echo base_url(); ?>assignments_rubrics/get_default_question_choice?question_type='+question_type_id,
				type: 'GET',
				beforeSend: function () {
					jQuery('.answer_choice_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
				},
				success: function (result) {  //alert(result);
 					jQuery('.answer_choice_according_to_question').html(result);
					
					//if(question_type_id==1 || question_type_id==2 || question_type_id==3){
						jQuery.ajax({
							url: '<?php echo base_url(); ?>assignments_rubrics/get_action_html_of_answer?question_type='+question_type_id,
							type: 'GET',
							beforeSend: function () {
								jQuery('.answer_action_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
							},
							success: function (result) {  //alert(result);
								jQuery('.answer_action_according_to_question').html(result);
							}
						});
					//}
				}
			});		
		 }
	}
</script>

	 	<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<h3> Choice Options</h3>
			</div> 
	  	</div>
		<div class="answer_choice_according_to_question">
			 	
		</div>	
	</div>

<div class="col-md-2">
	<div class="form-group">
		<div class="contenttitle2 nomargintop">
			<h3> Settings</h3>
		</div> 
  	</div>
	<div class="answer_action_according_to_question">
		
	</div>	
</div>
<div class="clearfix"></div>
<div class="col-md-4">&nbsp;</div>
<div class="col-md-4">
	<button type="submit" class="btn btn-primary" name="submit_login" onclick="return add_question();" style="width:100%; margin-top:20px;">Save and Update</button>
</div>
<script type="text/javascript">
	function add_question(){		
		var hidden_question_type = jQuery("#hidden_question_type").val();
		if(hidden_question_type=='0'){
			alert('Please select Question Type.');
			return false;
		}
		
		var tests_question_title = jQuery("#tests_question_title").val();			
		if(hidden_question_type==1){
			var choice_count = jQuery("#choice_count").html();
			jQuery("#hidden_choice_count").val(choice_count);
		}		
		if(survey_question_title!=''){
			if(hidden_question_type==0){
				alert('please select the question type!');return false;
			}
		}

	}
</script>
<div class="col-md-4">&nbsp;</div>
</form>
</div> 
<div class="clearfix"></div>