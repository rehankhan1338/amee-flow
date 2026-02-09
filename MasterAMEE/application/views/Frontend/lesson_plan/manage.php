<script type="text/javascript">  
jQuery(function () {
	CKEDITOR.replace( 'essentialQuestions', {height: '150px',});
	CKEDITOR.replace( 'studentKnow', {height: '150px',});
	CKEDITOR.replace( 'studentBeAbleTo', {height: '150px',});
	CKEDITOR.replace( 'studentThinkAbout', {height: '150px',});
	CKEDITOR.replace( 'focusQuestion', {height: '150px',});
	CKEDITOR.replace( 'lpMaterials', {height: '150px',});
	CKEDITOR.replace( 'lpDoNowDesc', {height: '150px',});
	CKEDITOR.replace( 'lpMiniLessonDesc', {height: '150px',});
	CKEDITOR.replace( 'lpActivityDesc', {height: '150px',});
	CKEDITOR.replace( 'lpSummaryDesc', {height: '150px',});
	CKEDITOR.replace( 'lpHomeWork', {height: '150px',});
	CKEDITOR.replace( 'lpAssessment', {height: '150px',});
	CKEDITOR.replace( 'lpReflectionQues', {height: '150px',});
}); 
</script>
<style>
.lesson_plan_page{ font-size:16px;}
.lesson_plan_page h4{ font-size:17px; margin-bottom:10px; font-weight:600;}
.lesson_plan_page h4 span{ font-size:16px; font-weight:500;}
.lesson_plan_page p{ line-height:26px; margin:0 0 15px 0}
.lesson_plan_page strong{ font-weight:600;}
.lesson_plan_page .ques{ margin-top:15px;}
.lesson_plan_page .qdetails{ padding:0 15px;}
.lesson_plan_page .btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus{outline: none;}
.lesson_plan_page .plpr{ padding-left:5px; padding-right:5px;}
.lesson_plan_page .qdetails .lbl{ font-weight:600; font-size:16px; margin-bottom:10px;}
.lesson_plan_page .qdetails .lbl span{ font-weight:500; font-size:15px;}

.lesson_plan_page .qmore{ padding:0 15px;margin-top:15px;}
.lesson_plan_page .qmore .lbl{ font-weight:600; font-size:16px; margin-bottom:10px;}
.lesson_plan_page .qmore .lbl span{ font-weight:500; font-size:15px;}
.lesson_plan_page .qmore .cont{padding:0 15px;}
.lesson_plan_page .qmore .cont p{margin-top:10px; margin-bottom:5px;}
.lesson_plan_page .qmore .cont ul{margin-left:40px; line-height:25px; margin-bottom:5px;}
</style>
<div class="box lesson_plan_page">
	<div class="col-xs-12">
		<div id="resMsg"></div>
		<form class="form-horizontal" id="lessonPlanFrm" method="post" action="lesson_plan/save_entry">	
		<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
		<input type="hidden" id="h_lesson_id" name="h_lesson_id" value="<?php if(isset($lesson_plan_details->lessonId) && $lesson_plan_details->lessonId!=''){echo $lesson_plan_details->lessonId;}else{echo '0';}?>" />
		<div class="box-body">
			<p>A <strong>Lesson Plan</strong> refers to an instructor / facilitator's plan for a particular lesson. Here, an instructor / facilitator must plan what they want to teach or train students, why a topic is being covered and decide how to deliver the content. Learning objectives, learning activities and homework are all included in a lesson plan.</p>
			<div class="col-md-3">
				<div class="form-group plpr">
					<label><strong>Name of Program *</strong></label>
					<input class="form-control required" type="text" id="programName" name="programName" value="<?php if(isset($lesson_plan_details->lessonId) && $lesson_plan_details->lessonId!=''){echo $lesson_plan_details->programName;}?>" autocomplete="off" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group plpr">
					<label><strong>Name of Instructor/Facilitator *</strong></label>
					<input class="form-control required" type="text" id="instructorName" name="instructorName" value="<?php if(isset($lesson_plan_details->instructorName) && $lesson_plan_details->instructorName!=''){echo $lesson_plan_details->instructorName;}?>" autocomplete="off" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group plpr">
					<label><strong>Lesson Title *</strong></label>
					<input class="form-control required" type="text" id="lessonTitle" name="lessonTitle" value="<?php if(isset($lesson_plan_details->lessonTitle) && $lesson_plan_details->lessonTitle!=''){echo $lesson_plan_details->lessonTitle;}?>" autocomplete="off" />
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group plpr">
					<label><strong>Date of Session *</strong></label>
					<input type="text" class="form-control required" id="datetimepicker1" name="sessionDate" value="<?php if(isset($lesson_plan_details->sessionDate) && $lesson_plan_details->sessionDate!='' && $lesson_plan_details->sessionDate>0){echo date('m/d/y h:i A',$lesson_plan_details->sessionDate);}?>" />
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="ques">
				<h4>Step 1: Essential Question(s). <span>What is the MOST important with key questions if necessary (i.e., How do you conjugate regular and irregular verbs in the imperfect and preterit tenses? How do you use "gustar-like" verbs in Spanish?)</span></h4>
				
				<div class="qdetails">
					<textarea class="form-control" rows="3" id="essentialQuestions" name="essentialQuestions" placeholder=""><?php if(isset($lesson_plan_details->essentialQuestions) && $lesson_plan_details->essentialQuestions!=''){echo $lesson_plan_details->essentialQuestions;}?></textarea>
				</div>
			</div>
 			
			<div class="ques">
				<h4>Step 2: Objectives / Outcomes. <span>Write out the goals or objectives for the lesson. Try to limit these to the three types of objectives listed below and one or two per box.</span></h4>
				<div class="qdetails">
					<div class="col-md-4 plpr">
						<textarea class="form-control" rows="5" id="studentKnow" name="studentKnow" placeholder=""><?php if(isset($lesson_plan_details->studentKnow) && $lesson_plan_details->studentKnow!=''){echo $lesson_plan_details->studentKnow;}else{echo 'At the end of this lesson, students will <b>KNOW</b>:';}?></textarea>
					</div>
					<div class="col-md-4 plpr">
						<textarea class="form-control" rows="5" id="studentBeAbleTo" name="studentBeAbleTo" placeholder=""><?php if(isset($lesson_plan_details->studentBeAbleTo) && $lesson_plan_details->studentBeAbleTo!=''){echo $lesson_plan_details->studentBeAbleTo;}else{echo 'At the end of this lesson, students will <b>BE ABLE TO</b>:';}?></textarea>
					</div>
					<div class="col-md-4 plpr">
						<textarea class="form-control" rows="5" id="studentThinkAbout" name="studentThinkAbout" placeholder=""><?php if(isset($lesson_plan_details->studentThinkAbout) && $lesson_plan_details->studentThinkAbout!=''){echo $lesson_plan_details->studentThinkAbout;}else{echo 'At the end of this lesson, students will <b>THINK ABOUT</b>:';}?></textarea>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			
 			<div class="ques">
				<h4>Step 3: Focus Statement. <span>What is the big idea to anchor your lesson? (i.e., Art is about finding out about others-multicultural connections).</span></h4>
				<div class="qdetails">
					<textarea class="form-control" rows="3" id="focusQuestion" name="focusQuestion" placeholder=""><?php if(isset($lesson_plan_details->focusQuestion) && $lesson_plan_details->focusQuestion!=''){echo $lesson_plan_details->focusQuestion;}?></textarea>
				</div>
			</div>
			<div class="ques">
				<h4>Step 4: Lesson Plan Details</h4>
				<div class="qmore">
					<label class="lbl">Materials &ndash; <span>Create a list of materials to keep you organized. Listing them out in your materials list, also called an Anticipatory Set, helps you visualize what you'll need during your lesson. Don't forget to list items (i.e., whiteboard markers, projector, training packet, class laptops, case studies, assignment sheet)</span></label>
					<div class="cont">
					<textarea class="form-control" rows="3" id="lpMaterials" name="lpMaterials" placeholder=""><?php if(isset($lesson_plan_details->lpMaterials) && $lesson_plan_details->lpMaterials!=''){echo $lesson_plan_details->lpMaterials;}else{echo '';}?></textarea>
					</div>
				</div>
				
				<div class="qmore">
				<div class="instructions"><strong>Instructions: </strong>Write down exactly what you will do in the lesson and how the participants will engage in the activity. This section should be very clear with specific time allotments. Be realistic with what you can accomplish in the lesson, as adding too many activities for a time period can result in less successful learning.</div>
					<label class="lbl">DO NOW &ndash; <span>Do Now is an opportunity for you to engage your participants in their responses to any pretest, poll, videos, or materials reviewed before the lesson begins. For example, ask a question like, What was your response to the poll/pretest? What did your answers reveal to you?  Identify the amount of time you will allow for this discussion or discovery.</span></label>
					<div class="cont">
					
					<textarea class="form-control" rows="3" id="lpDoNowDesc" name="lpDoNowDesc" placeholder=""><?php if(isset($lesson_plan_details->lpDoNowDesc) && $lesson_plan_details->lpDoNowDesc!=''){echo $lesson_plan_details->lpDoNowDesc;}else{echo '';}?></textarea>
					<div class="input-group" style="margin-top:10px;">
					  <span class="input-group-addon" id="basic-addon3" style=" font-weight:600;">minutes </span>
					  <input type="number" class="form-control" style="width:20%;" id="lpDoNowMin" name="lpDoNowMin" aria-describedby="basic-addon3" value="<?php if(isset($lesson_plan_details->lpDoNowMin) && $lesson_plan_details->lpDoNowMin!=''){echo $lesson_plan_details->lpDoNowMin;}?>" />
					</div>
				</div>
				</div>
				
				<div class="qmore">
 					<label class="lbl">MINI-LESSON &ndash; <span>Narrate your lesson on this topic. For example, this lesson plan focuses on the theme "Art is about finding out about others. Participants will learn about Asian Art forms, aesthetics, and traditions. In this first lesson, participants learn about the Asian paper lantern and the traditional Chinese calendar with animal symbols.  Participants will explore rice paper, watercolor techniques, and materials. Participants should respond to two or three of the following statements or questions: (Why do the Chinese use animals in the calendar? What is the difference between rice paper and lantern techniques? If you could make a lantern, what color would it be? Why?)</span></label>
					<div class="cont">
					
					<!--<p>Q. XXX is a website to understand blah, blah, blah. This will be a great way for you to understand blah, blah, blah. Today, we are going to practice using blah, blah, blah to respond to your case study.<br />When you are reading the case study you need to respond to two of the three questions:</p>
					<ul>
						<li>Explain</li>
						<li>What was the problem in the story?</li>
						<li>If you could make changes, what would it be? Why?</li>
					</ul>-->
					<textarea class="form-control" rows="3" id="lpMiniLessonDesc" name="lpMiniLessonDesc" placeholder=""><?php if(isset($lesson_plan_details->lpMiniLessonDesc) && $lesson_plan_details->lpMiniLessonDesc!=''){echo $lesson_plan_details->lpMiniLessonDesc;}else{echo '';}?></textarea>
					<div class="input-group" style="margin-top:10px;">
					  <span class="input-group-addon" id="basic-addon3" style=" font-weight:600;">minutes </span>
					  <input type="number" class="form-control" style="width:20%" id="lpMiniLessonMin" name="lpMiniLessonMin" aria-describedby="basic-addon3" value="<?php if(isset($lesson_plan_details->lpMiniLessonMin) && $lesson_plan_details->lpMiniLessonMin!=''){echo $lesson_plan_details->lpMiniLessonMin;}?>" />
					</div>
					</div>
				</div>
				
				<div class="qmore">
 					<label class="lbl">ACTIVITY &ndash; <span>What activities will you use to activate your lesson and engage your learners? (i.e., create a lantern, provide a case to be solved in groups, learners will post responses to questions in a Google doc during the break-out session, etc.). Don't forget to tell us how much time you allow for this lesson.</span></label>
					<div class="cont">
					
				<!--	<p>Q. Walking through how to read a financial statement. Learning is acquired in groups. Although in groups, each person will provide a response in google docs individually.</p>-->
					<textarea class="form-control" rows="3" id="lpActivityDesc" name="lpActivityDesc" placeholder=""><?php if(isset($lesson_plan_details->lpActivityDesc) && $lesson_plan_details->lpActivityDesc!=''){echo $lesson_plan_details->lpActivityDesc;}else{echo '';}?></textarea>
					<div class="input-group" style="margin-top:10px;">
					  <span class="input-group-addon" id="basic-addon3" style=" font-weight:600;">minutes </span>
					  <input type="number" class="form-control" style="width:20%" id="lpActivityMin" name="lpActivityMin" aria-describedby="basic-addon3" value="<?php if(isset($lesson_plan_details->lpActivityMin) && $lesson_plan_details->lpActivityMin!=''){echo $lesson_plan_details->lpActivityMin;}?>" />
					</div>
					</div>
				</div>
				
				<div class="qmore">
 					<label class="lbl">SUMMARY &ndash; <span>How will the lesson be summarized. In other words, how will the lesson be concluded, and how will the participants summarize what was learned during the session at the end of the session? (The lesson will reiterate blah, blah, blah. Participants will explain how they will use this cultural artifact in their lives. Why? Take the posttest). Don't forget to tell us how much time you allow for this lesson.</span></label>
					<div class="cont">
					
					<!--<p>Q. Students explain how they will use blah, blah, blah? Why?</p>-->
					<textarea class="form-control" rows="3" id="lpSummaryDesc" name="lpSummaryDesc" placeholder=""><?php if(isset($lesson_plan_details->lpSummaryDesc) && $lesson_plan_details->lpSummaryDesc!=''){echo $lesson_plan_details->lpSummaryDesc;}else{echo '';}?></textarea>
					<div class="input-group" style="margin-top:10px;">
					  <span class="input-group-addon" id="basic-addon3" style=" font-weight:600;">minutes </span>
					  <input type="number" class="form-control" style="width:20%" id="lpSummaryMin" name="lpSummaryMin" aria-describedby="basic-addon3" value="<?php if(isset($lesson_plan_details->lpSummaryMin) && $lesson_plan_details->lpSummaryMin!=''){echo $lesson_plan_details->lpSummaryMin;}?>" />
					</div>
					</div>
				</div>
				
				<div class="qmore">
					<label class="lbl">HOMEWORK &ndash; <span>Participants will finish presentations or prepare to answer a set of questions to prepare for the next session (i.e., What did you find difficult about using blah, blah, blah? Why? What did you find easy about using blah, blah, blah? Why? How do you think you will use blah, blah, blah? Pick one goal for creating blah, blah, blah, and explain how you will accomplish this goal?). Don't forget to tell us how much time you allow for this lesson.</span></label>
					<div class="cont">
					<!--<p>Finishing presentations<br />Answering the following questions</p>
					<ul>
						<li>What did you find difficult about using blah, blah, blah? Why?</li>
						<li>What did you find easy about using blah, blah, blah? Why?</li>
						<li>How do you think you will use blah, blah, blah?</li>
						<li>Pick one goal for creating blah, blah, blah, and explain how you will accomplish this?</li>
					</ul>-->
					<textarea class="form-control" rows="3" id="lpHomeWork" name="lpHomeWork" placeholder=""><?php if(isset($lesson_plan_details->lpHomeWork) && $lesson_plan_details->lpHomeWork!=''){echo $lesson_plan_details->lpHomeWork;}else{echo '';}?></textarea>
					<div class="input-group" style="margin-top:10px;">
					  <span class="input-group-addon" id="basic-addon3" style=" font-weight:600;">minutes </span>
					  <input type="number" class="form-control" style="width:20%" id="lpHomeWorkMin" name="lpHomeWorkMin" aria-describedby="basic-addon3" value="<?php if(isset($lesson_plan_details->lpHomeWorkMin) && $lesson_plan_details->lpHomeWorkMin!=''){echo $lesson_plan_details->lpHomeWorkMin;}?>" />
					</div>
					</div>
				</div>
				
				<div class="qmore">
					<label class="lbl" >Assessment &ndash; <span>What assessment will you use in this lesson? (i.e., pretest/posttest, scored assignments, rated interviews, etc.).</span></label>
					<div class="cont">
					<textarea class="form-control" rows="3" id="lpAssessment" name="lpAssessment" placeholder=""><?php if(isset($lesson_plan_details->lpAssessment) && $lesson_plan_details->lpAssessment!=''){echo $lesson_plan_details->lpAssessment;}else{echo '';}?></textarea>
					</div>
				</div>
				
				<div class="qmore">
					<label class="lbl" >Reflection Questions &ndash; <span>Answer these questions after the lesson have been given. What did I purposefully plan to help participants achieve the learning outcomes? What did participants struggle with, and what revisions should be made?</span></label>
					<div class="cont">
					<textarea class="form-control" rows="3" id="lpReflectionQues" name="lpReflectionQues" placeholder=""><?php if(isset($lesson_plan_details->lpReflectionQues) && $lesson_plan_details->lpReflectionQues!=''){echo $lesson_plan_details->lpReflectionQues;}else{echo '';}?></textarea>
					</div>
				</div>
				
				
			</div>
			<div class="ques"></div>
		</div>	
		<div class="box-footer">
			<button type="submit" class="btn btn-primary" id="submitBtn">Save & Update</button>
		</div>
		</form>
	</div>
</div>
<div class="clearfix"></div>
<script>
jQuery(function () {
	jQuery('#lessonPlanFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#lessonPlanFrm');
			var url = site_base_url+form.attr('action');
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						window.location=site_base_url+'lesson_plan';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+result+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#submitBtn').html('Save & Update');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#submitBtn').html('Save & Update');
				}
			});		
			return false;
		}
	});
});
</script>