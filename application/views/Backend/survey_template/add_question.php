<style type="text/css">
option{padding:5px;}
</style>
<section class="content">
<div class="row">
<div class="col-md-12" >

	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>admin/Survey_template/question_save" enctype="multipart/form-data">
	<div class="box">	
		<div class="box-header with-border">
			<h3 class="box-title" style="display: inline-block;">&nbsp;</h3>    
			<div class="box-tools pull-right">
			  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/survey/template" class="btn btn-default"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Survey Template </a>
			  
			  <a style="padding: 3px 5px; margin-left:10px; vertical-align:top; " href="<?php echo base_url();?>admin/survey_template?stid=<?php if(isset($_GET['stid'])&& $_GET['stid']!=''){echo $_GET['stid'];}?>" class="btn btn-primary"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Question List </a>
			  
			</div>
	    </div>
		
		<div class="">
			<input type="hidden" class="form-control required" id="survey_template_id" name="survey_template_id" value="<?php if(isset($_GET['stid'])&& $_GET['stid']!=''){echo $_GET['stid'];}?>"/ >
   		</div>
		
		<div class="box-body">			
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label" for="inputEmail3"><h4>Question Title*</h4></label>
					<input type="text" class="form-control required" id="survey_question_title" name="survey_question_title" placeholder="Question Title" value="<?php //if(isset($_SESSION['sess_city']) && $_SESSION['sess_city']!=''){ echo $_SESSION['sess_city']; }else{ echo set_value('city');}?>"  >
					<span style="color:red;"><?php echo form_error('survey_templates'); ?></span>
				</div>
			</div>			
			
<div>
	<div class="col-md-2">
		<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<h4> Question Type</h4>
				<input type="hidden" name="hidden_question_type" id="hidden_question_type" value="0" />
				<input type="hidden" name="hidden_survey_id" id="hidden_survey_id" value="<?php //echo $survey_details->survey_id;?>" />
				<input type="hidden" name="hidden_choice_count" id="hidden_choice_count" value="" />
			</div> 

			<?php  $master_question_type = get_master_question_type_h();?>
				
				<?php foreach ($master_question_type as $question_type) {?>
				<div class="col-md-12" style="margin:0; padding:0;">
					<a id="selected_question_<?php echo $question_type->id;?>" onclick="return manage_questions('<?php echo $question_type->id;?>');" class="btn btn-default question_types_btn" style="margin:10px 0; width:100%"  > <?php echo $question_type->question_type;?></a>
				</div>

			<?php } ?>

	 	</div>
	</div>		
	
	
	<div class="col-md-8">		
		<div class="form-group">
			<div class="contenttitle2 nomargintop">
				<h4> Choice Options</h4>
			</div> 
	  	</div>	

		<div class="answer_choice_according_to_question">			

		</div>
		
		
		<script type="text/javascript">
		function manage_questions(question_type_id){

			jQuery("#hidden_question_type").val(question_type_id);			

			 if(question_type_id!=''){	 

			 	jQuery('.question_types_btn').css('background-color','#fff');
				jQuery('.question_types_btn').css('border-color','#ccc');
				jQuery('.question_types_btn').css('color','#333');			

				jQuery('#selected_question_'+question_type_id).css('background-color','#0f7d7d');
				jQuery('#selected_question_'+question_type_id).css('border-color','#0f7d7d');
				jQuery('#selected_question_'+question_type_id).css('color','#fff');

				jQuery.ajax({
					url: '<?php echo base_url(); ?>admin/Survey_template/get_default_question_choice?question_type='+question_type_id,
					type: 'GET',
					beforeSend: function () {
						jQuery('.answer_choice_according_to_question').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" alt="" />');
					},
					success: function (result) {  //alert(result);
	 					jQuery('.answer_choice_according_to_question').html(result);
	 											
						//if(question_type_id==1 || question_type_id==2 || question_type_id==3){
							jQuery.ajax({
								url: '<?php echo base_url(); ?>admin/Survey_template/get_action_html_of_answer?question_type='+question_type_id,
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
				<h4> Settings</h4>
			</div> 
  		</div>

		<div class="answer_action_according_to_question">		

		</div>	
	</div>	
	
	

</div>	

<div class="clearfix"></div>
<div class="col-md-4">&nbsp;</div>
<div class="col-md-4">
	<button type="submit" class="btn btn-primary" name="submit_login" onclick="return add_question();" style="width:100%; margin-top:20px;">Save and Update</button>
</div>		
<div class="col-md-4">&nbsp;</div>

		</div> 
		  
		  
		  
		
		
		<script type="text/javascript">
			function add_question(){
				var hidden_question_type = jQuery("#hidden_question_type").val();
				if(hidden_question_type=='0'){
					alert('Please select Question Type.');
					return false;
				}
				
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