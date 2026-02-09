<section class="content">
<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ padding:8px; font-weight:600; font-size:14px;}
.hfr{font-size: 16px; margin:15px 0px 0px 0; font-weight:600;}
</style>
<div class="box snapshot_page">
	
	<div class=" pull-right">	
		<!--<button class="btn btn-primary" onclick="return makeScreenshot();" id="downloadBtn" style="padding:3px 15px; margin-left:5px; font-size:15px;">Download</button>-->
		<a class="btn btn-default" href="<?php echo base_url().'admin/lesson_plan';?>" style="padding:3px 15px; margin-left:5px; font-size:15px;"><i class="fa fa-long-arrow-left"></i> Back to Lesson Plan List</a>
	</div>
	<div id="knob-chart-div">
		<div class="clearfix"></div>
		<div class="col-md-12">
			<table class="table table-bordered table-striped" style="margin-top:20px;">
				<tr>
					<td width="20%">Name of Program :</td>
					<td width="30%"><?php echo $lesson_plan_details->programName;?></td>
					<td width="20%">Name of Instructor/Facilitator :</td>
					<td width="30%"><?php echo $lesson_plan_details->instructorName;?></td>
				</tr>
				<tr>
					<td>Lesson Title :</td>
					<td><?php echo $lesson_plan_details->lessonTitle;?></td>
					<td>Date of Session :</td>
					<td><?php if(isset($lesson_plan_details->sessionDate) && $lesson_plan_details->sessionDate && $lesson_plan_details->sessionDate>0){echo date('d M Y',$lesson_plan_details->sessionDate);}?></td>
				</tr>
			</table>
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12">
			<ul class="timeline">
				<?php if(isset($lesson_plan_details->essentialQuestions) && $lesson_plan_details->essentialQuestions!=''){?>
				<li>
					<label class="snapshot_page_title">Step 1: Essential Question(s)</label>
						<div class="timeline-item">
						<div class="timeline-header"><?php echo $lesson_plan_details->essentialQuestions;?></div>
					</div>
				</li>
				<?php } ?>
				<li>
					<label class="snapshot_page_title">Step 2: Objectives / Outcomes</label>
						<div class="timeline-item">
						<div class="timeline-header">
							<?php if(isset($lesson_plan_details->studentKnow) && $lesson_plan_details->studentKnow!=''){?>
							<h4 class="hfr">At the end of this lesson, students will KNOW &ndash;</h4>
							<?php echo $lesson_plan_details->studentKnow; }?>
							
							<?php if(isset($lesson_plan_details->studentBeAbleTo) && $lesson_plan_details->studentBeAbleTo!=''){?>
							<h4 class="hfr">At the end of this lesson, students will BE ABLE TO &ndash;</h4>
							<?php echo $lesson_plan_details->studentBeAbleTo; }?>
							
							<?php if(isset($lesson_plan_details->studentThinkAbout) && $lesson_plan_details->studentThinkAbout!=''){?>
							<h4 class="hfr">At the end of this lesson, students will sTHINK ABOUT &ndash;</h4>
							<?php echo $lesson_plan_details->studentThinkAbout;}?>
						
						</div>
					</div>
				</li>
				<?php if(isset($lesson_plan_details->focusQuestion) && $lesson_plan_details->focusQuestion!=''){?>
				<li>
					<label class="snapshot_page_title">Step 3: Focus Question / Objective</label>
						<div class="timeline-item">
						<div class="timeline-header"><?php echo $lesson_plan_details->focusQuestion;?></div>
					</div>
				</li>
				<?php }
				
		/*		if((isset($lesson_plan_details->lpMaterials) && $lesson_plan_details->lpMaterials!='') || isset($lesson_plan_details->lpDoNowMin) && $lesson_plan_details->lpDoNowMin!='') || isset($lesson_plan_details->lpDoNowDesc) && $lesson_plan_details->lpDoNowDesc!='') || isset($lesson_plan_details->lpMiniLessonMin) && $lesson_plan_details->lpMiniLessonMin!='') || isset($lesson_plan_details->lpMiniLessonDesc) && $lesson_plan_details->lpMiniLessonDesc!='') || isset($lesson_plan_details->lpActivityMin) && $lesson_plan_details->lpActivityMin!='') || isset($lesson_plan_details->lpActivityDesc) && $lesson_plan_details->lpActivityDesc!='') || isset($lesson_plan_details->lpSummaryMin) && $lesson_plan_details->lpSummaryMin!='') || isset($lesson_plan_details->lpSummaryDesc) && $lesson_plan_details->lpSummaryDesc!='') || isset($lesson_plan_details->lpHomeWork) && $lesson_plan_details->lpHomeWork!='') || isset($lesson_plan_details->lpHomeWorkMin) && $lesson_plan_details->lpHomeWorkMin!='') || isset($lesson_plan_details->lpAssessment) && $lesson_plan_details->lpAssessment!='') || isset($lesson_plan_details->lpReflectionQues) && $lesson_plan_details->lpReflectionQues!='')){*/	
				
				
				
				?>
				
				<li>
					<label class="snapshot_page_title">Step 4: Lesson Plan Details</label>
						<div class="timeline-item">
						<div class="timeline-header">
							<?php if(isset($lesson_plan_details->lpMaterials) && $lesson_plan_details->lpMaterials!=''){?>
							<h4 class="hfr">MATERIALS  &ndash;</h4>
							<?php echo $lesson_plan_details->lpMaterials;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpDoNowMin) && $lesson_plan_details->lpDoNowMin!=''){?>
							<h4 class="hfr">DO NOW <?php echo '('.$lesson_plan_details->lpDoNowMin.' minutes)';?> &ndash;</h4>
							<?php } if(isset($lesson_plan_details->lpDoNowDesc) && $lesson_plan_details->lpDoNowDesc!=''){echo $lesson_plan_details->lpDoNowDesc;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpMiniLessonMin) && $lesson_plan_details->lpMiniLessonMin!=''){?>
							<h4 class="hfr">MINI-LESSON <?php echo '('.$lesson_plan_details->lpMiniLessonMin.' minutes)';?> &ndash;</h4>
							<?php } if(isset($lesson_plan_details->lpMiniLessonDesc) && $lesson_plan_details->lpMiniLessonDesc!=''){echo $lesson_plan_details->lpMiniLessonDesc;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpActivityMin) && $lesson_plan_details->lpActivityMin!=''){?>
							<h4 class="hfr">ACTIVITY <?php echo '('.$lesson_plan_details->lpActivityMin.' minutes)';?> &ndash;</h4>
							<?php } if(isset($lesson_plan_details->lpActivityDesc) && $lesson_plan_details->lpActivityDesc!=''){echo $lesson_plan_details->lpActivityDesc;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpSummaryMin) && $lesson_plan_details->lpSummaryMin!=''){?>
							<h4 class="hfr">SUMMARY <?php echo '('.$lesson_plan_details->lpSummaryMin.' minutes)';?> &ndash;</h4>
							<?php } if(isset($lesson_plan_details->lpSummaryDesc) && $lesson_plan_details->lpSummaryDesc!=''){echo $lesson_plan_details->lpSummaryDesc;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpHomeWork) && $lesson_plan_details->lpHomeWork!=''){?>
							<h4 class="hfr">HOMEWORK <?php echo '('.$lesson_plan_details->lpHomeWorkMin.' minutes)';?> &ndash;</h4>
							<?php echo $lesson_plan_details->lpHomeWork; }?>
							<hr />
							<?php if(isset($lesson_plan_details->lpAssessment) && $lesson_plan_details->lpAssessment!=''){?>
							<h4 class="hfr">ASSESSMENT  &ndash;</h4>
							<?php echo $lesson_plan_details->lpAssessment;} ?>
							<hr />
							<?php if(isset($lesson_plan_details->lpReflectionQues) && $lesson_plan_details->lpReflectionQues!=''){?>
							<h4 class="hfr">REFLECTION QUESTIONS  &ndash;</h4>
							<?php echo $lesson_plan_details->lpReflectionQues;} ?>						
						
						</div>
					</div>
				</li>
				<?php //} ?>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
</section>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>