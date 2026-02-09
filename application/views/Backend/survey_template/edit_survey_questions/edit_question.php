<style>
	.selected_question{ background-color: rgb(15, 125, 125);  border-color: rgb(15, 125, 125); color: rgb(255, 255, 255);	}
</style>
<section class="content">
<div class="row">
<div class="col-md-12" >

	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>admin/survey_template/update_question_entry" enctype="multipart/form-data">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title" style="display: inline-block;">&nbsp;</h3>    
			<div class="box-tools pull-right">
			  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/survey/template" class="btn btn-default"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Survey Template </a>
			  
			  <a style="padding: 3px 5px; margin-left:10px; vertical-align:top; " href="<?php echo base_url();?>admin/survey_template?stid=<?php if(isset($_GET['survey_id'])&& $_GET['survey_id']!=''){echo $_GET['survey_id'];}?>" class="btn btn-primary"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Question List </a>
			   
			</div>
	    </div>
		
		<div class="box-body">
			<div class="">
				<input type="hidden" class="form-control required" id="survey_template_id" name="survey_template_id" value="<?php if(isset($survey_template_id)&& $survey_template_id!=''){echo $survey_template_id;}?>"/ >
   			</div>					
			
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label" for="inputEmail3"> Question Title*</label>
					<input type="text" class="form-control required" id="survey_question_title" name="survey_question_title" placeholder="Question Title" value="<?php if(isset($default_surveys_questions_rowdetails->question_title) && $default_surveys_questions_rowdetails->question_title!=''){ echo $default_surveys_questions_rowdetails->question_title;}?>"  >
					<span style="color:red;"><?php echo form_error('survey_question_title'); ?></span>
				</div>
			</div>			
			
<div>
	<div class="col-md-2">
		<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<label class="control-label" for="inputEmail3"> Question Type</label>
				<input type="hidden" name="hidden_question_id" id="hidden_question_id" value="<?php if(isset($default_surveys_questions_rowdetails->question_id) && $default_surveys_questions_rowdetails->question_id!=''){ echo $default_surveys_questions_rowdetails->question_id;}?>" />
				<input type="hidden" name="hidden_old_question_type" id="hidden_old_question_type" value="<?php if(isset($default_surveys_questions_rowdetails->question_type) && $default_surveys_questions_rowdetails->question_type!=''){ echo $default_surveys_questions_rowdetails->question_type;}?>" />
				<input type="hidden" name="hidden_choice_count" id="hidden_choice_count" value="" />
				
				<input type="hidden" name="hidden_question_type" id="hidden_question_type" value="<?php if(isset($default_surveys_questions_rowdetails->question_type) && $default_surveys_questions_rowdetails->question_type!=''){ echo $default_surveys_questions_rowdetails->question_type;}?>" />	
			</div> 

			<?php  $master_question_type = get_master_question_type_h();?>
				
				<?php foreach ($master_question_type as $question_type) {?>
				<div class="col-md-12" style="margin:0; padding:0;">
<a id="selected_question_<?php echo $question_type->id;?>" onclick="return manage_questions('<?php echo $question_type->id;?>');" class="btn btn-default question_types_btn <?php if(isset($default_surveys_questions_rowdetails->question_type) && $default_surveys_questions_rowdetails->question_type==$question_type->id){ echo 'selected_question';}?>" style="margin:10px 0; width:100%"  > <?php echo $question_type->question_type;?></a>
				</div>

			<?php } ?>

	 	</div>
	</div>		
	
	
	<div class="col-md-8">		
		<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<label class="control-label" for="inputEmail3"> Choice Options</label>
			</div> 
	  	</div>	

		<div class="answer_choice_according_to_question">			

		</div>
		
		
<script type="text/javascript">
	jQuery(document).ready( function (){
		var question_type_id = '<?php echo $default_surveys_questions_rowdetails->question_type;?>';
		var question_id = '<?php echo $question_id;?>';
		
		jQuery.ajax({
			url: '<?php echo base_url(); ?>admin/survey_template/get_edit_default_question_choice?question_id='+question_id+'&question_type='+question_type_id,
			type: 'GET',
			beforeSend: function () {
				jQuery('.answer_choice_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
			},
			success: function (result) { //alert(result);
				jQuery('.answer_choice_according_to_question').html(result);
				
				//if(question_type_id==1 || question_type_id==2 || question_type_id==3){
					jQuery.ajax({
						url: '<?php echo base_url(); ?>admin/survey_template/get_edit_action_html_of_answer?question_id='+question_id+'&question_type='+question_type_id,
						type: 'GET',
						beforeSend: function () {
							jQuery('.answer_action_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
						},
						success: function (result) { // alert(result);
							jQuery('.answer_action_according_to_question').html(result);
						}
					});
				//}
			}
		});
	});
	
	function manage_questions(question_type_id){
		var question_id = '<?php echo $question_id;?>';
		jQuery("#hidden_question_type").val(question_type_id);		
		
		 if(question_type_id!=''){		 
			jQuery('.question_types_btn').css('background-color','#fff');
			jQuery('.question_types_btn').css('border-color','#ccc');
			jQuery('.question_types_btn').css('color','#333');
			
			jQuery('#selected_question_'+question_type_id).css('background-color','#0f7d7d');
			jQuery('#selected_question_'+question_type_id).css('border-color','#0f7d7d');
			jQuery('#selected_question_'+question_type_id).css('color','#fff');
			
			jQuery.ajax({
				url: '<?php echo base_url(); ?>admin/survey_template/get_edit_default_question_choice?question_id='+question_id+'&question_type='+question_type_id,
				type: 'GET',
				beforeSend: function () {
					jQuery('.answer_choice_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
				},
				success: function (result) {  //alert(result);
					jQuery('.answer_choice_according_to_question').html(result);
					
					//if(question_type_id==1 || question_type_id==2 || question_type_id==3){
						jQuery.ajax({
							url: '<?php echo base_url(); ?>admin/survey_template/get_edit_action_html_of_answer?question_id='+question_id+'&question_type='+question_type_id,
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
	</div>		
	
	
	<div class="col-md-2">
		<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<label class="control-label" for="inputEmail3"> Settings</label>
			</div> 
  		</div>

		<div class="answer_action_according_to_question">		

		</div>	
	</div>	
	
	

</div>	
	


		</div> 
		  
		  
		  
		<div class="clearfix"></div>
		<div class="col-md-4">&nbsp;</div>
		<div class="col-md-4">
			<button type="submit" class="btn btn-primary" name="submit_login" onclick="return add_question();" style="width:100%; margin-top:20px;">Save and Update</button>
		</div>		
		<div class="col-md-4">&nbsp;</div>
		
		<script type="text/javascript">
			function add_question(){
				/*var hidden_question_type = jQuery("#hidden_question_type").val();
				if(hidden_question_type=='0'){
					alert('Please select Question Type.');
					return false;
				}*/
				
				var survey_question_title = jQuery("#survey_question_title").val();
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
	
	</div>
	</form>
</div>

<div class="clearfix"></div>
</div>
</section>
