<style>
.contentwrapper{padding:0 10px 20px}
.timeline{position:relative;margin:0 0 30px 0;padding:0;list-style:none}
.timeline:before{content:'';position:absolute;top:0;bottom:0;width:4px;background:#ddd;left:31px;margin:0;border-radius:2px}
.timeline>li{position:relative;margin-right:10px;margin-bottom:15px}
.timeline>li:before,.timeline>li:after{content:" ";display:table}
.timeline>li:after{clear:both}
.timeline>li>.timeline-item{-webkit-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);border-radius:3px;margin-top:0;background:#fff;color:#444;margin-left:60px;margin-right:15px;padding:0;position:relative}
.timeline>li>.timeline-item>.time{color:#999;float:right;padding:10px;font-size:12px}
.timeline>li>.timeline-item>.timeline-header{margin:0;color:#333;border-bottom:1px solid #f4f4f4;padding:10px 15px;font-size:16px;line-height:1.1}
.timeline>li>.timeline-item>.timeline-header>a{font-weight:600}
.timeline>li>.timeline-item>.timeline-body,.timeline>li>.timeline-item>.timeline-footer{padding:10px}
.timeline>li>.fa,.timeline>li>.glyphicon,.timeline>li>.ion{width:30px;height:30px;font-size:15px;line-height:30px;position:absolute;color:#666;background:#d2d6de;border-radius:50%;text-align:center;left:18px;top:0}
.timeline>.time-label>span{font-weight:600;padding:5px;display:inline-block;background-color:#fff;border-radius:4px}
.timeline-inverse>li>.timeline-item{background:#f0f0f0;border:1px solid #ddd;-webkit-box-shadow:none;box-shadow:none}
.timeline-inverse>li>.timeline-item>.timeline-header{border-bottom-color:#ddd}

.snapshot_page{margin:5px 0;}
.snapshot_page_title { background: #485b79;padding: 5px 15px; letter-spacing:0.2px; font-size: 16px;  color: #f6e4a5; border-radius: 5px; font-weight: 600;}
.snapshot_page .timeline > li > .timeline-item {-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);box-shadow: 0 1px 1px #f5f5f5;border-radius: 3px;margin-top: 15px;background: #f5f5f5;color: #333;margin-left: 60px;margin-right: 15px;padding: 0;position: relative;}
.snapshot_page .timeline-header p{margin:0px;line-height:25px; padding-bottom:5px; padding-top:5px;} 
.snapshot_page .timeline-header ul, .snapshot_page .timeline-header ol{list-style-position: inside;}
.snapshot_page .timeline-header ul li, .snapshot_page .timeline-header ol li{ padding:5px 15px;}

.snapshot_page .timeline-header b, .snapshot_page .timeline-header strong{ font-weight:600;}

#myDeptAnlaysisModel .modal-body{ padding:10px 15px 15px 15px;} 
#myDeptAnlaysisModel .modal-dialog { max-width:650px; width:650px;}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{ padding:6px; font-weight:600; font-size:15px;}
.w100{width:100%}
.hfr{font-size: 16px; margin:15px 0px 0px 0; font-weight:600;}
hr{border-top: 1px dashed #999;}
</style>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
function makeScreenshot(){
	$('#downloadBtn').html('Downloading <i class="fa fa-spinner fa-spin"></i>');
	var data = document.getElementById('knob-chart-div');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "<?php echo create_slug_ch($lesson_plan_details->lessonTitle);
		/*if(isset($lesson_plan_details->sessionDate) && $lesson_plan_details->sessionDate && $lesson_plan_details->sessionDate>0){
			echo '-'.date('d-M-Y',$lesson_plan_details->sessionDate);
		}*/?>.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
		$('#downloadBtn').html('Download');
	});
	
}
</script>
<div class="box snapshot_page">
	
	<div class=" pull-right">	
		<!--<button class="btn btn-primary" onclick="return makeScreenshot();" id="downloadBtn" style="padding:3px 15px; margin-left:5px; font-size:15px;">Download</button>-->
		<a class="btn btn-default" href="<?php echo base_url().'lesson_plan';?>" style="padding:3px 15px; margin-left:5px; font-size:15px;"><i class="fa fa-long-arrow-left"></i> Back to Lesson Plan List</a>
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
				<?php } ?>
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
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>