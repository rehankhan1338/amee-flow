<style type="text/css">
.btn{width: 100%;}
.mb20{margin: 10px 0;}	
.reprtView .fa{ font-size:18px;}
#fullReportModel .modal-body{ padding:10px 20px;}
#fullReportModel p{ margin:0; padding:0 10px; display:block}
#fullReportModel .modal-footer {padding: 10px 15px;text-align: left;}
#fullReportModel .modal-footer .btn{ width:49%}
</style>
<script>
function assessment_full_report(){
	jQuery("#fullReportModel").modal('show');
}
function reportGenerate(){
	var st = '?fr=1';
	if($('#aprSep1').is(':checked')){ var envision = '&s1=1'; }else{ var envision = ''; }
	if($('#aprSep2').is(':checked')){ var coordinate = '&s2=1';	}else{ var coordinate = '';	}
	if($('#aprSep3').is(':checked')){ var design = '&s3=1';	}else{ var design = '';	}
	if($('#aprSep4').is(':checked')){ var reflect = '&s4=1'; }else{ var reflect = ''; }
	
	var new_array_ar=[];
	$(".arcase:checked").each(function() {
		var n_total=parseInt($(this).val());
		new_array_ar.push(n_total);
	}); 
	var analysisReporting = '&ar='+new_array_ar;
	
	var new_array_clp=[];
	$(".clpcase:checked").each(function() {
		var n_total=parseInt($(this).val());
		new_array_clp.push(n_total);
	}); 
	var closeLoop = '&ctl='+new_array_clp;
	
	var new_array_lm=[];
	$(".lmdlcase:checked").each(function() {
		var n_total=parseInt($(this).val());
		new_array_lm.push(n_total);
	}); 
	var logicModel = '&lm='+new_array_lm;
	
	var qstring = st+envision+coordinate+design+reflect+analysisReporting+closeLoop+logicModel;
	var reportUrl = '<?php echo base_url().'assessment/report/'.$dept_session_details->deptEncryptId;?>'+qstring;
	window.open(reportUrl, '_blank');
}
</script>
<div class="container">
	<div class="box-body reprtView">
	
		<div class="col-md-12 instructions" style="margin:15px 0;">
			Click on each report to review and download for your files. Each report is a word document that can be edited. The assessment report is a template only.
		</div>
 		<div class="col-md-12 ">
 			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/preview_planning"> <i class="fa fa-file-text" aria-hidden="true"></i> &nbsp;Assessment Planning Report</a> 	
			</div>	
 			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/feedback"> <i class="fa fa-comments" aria-hidden="true"></i> &nbsp;Administrative Feedback Report</a>
			</div>
 			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/time_tracker"> <i class="fa fa-calculator" aria-hidden="true"></i> &nbsp;Time Tracker Report</a>
			</div>
			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" onclick="return assessment_full_report();"> <i class="fa fa-file-o" aria-hidden="true"></i> &nbsp;Full Evaluation Report</a>
			</div>
 			<!--<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/assessment_template"> Assessment Template Report</a>
			</div>	
			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/student_learning_outcome">UG - Student Learning Outcome Overall Performance Metrics</a>
			</div>	
			<div class="col-md-6 mb20">				
				<a class="btn btn-secondary" href="<?php echo base_url();?>department/reports/grad_student_learning_outcome">GRAD - Student Learning Outcome Overall Performance Metrics</a>
			</div>	-->					
 		</div>
	</div>
</div>

<div class="modal fade" id="fullReportModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="read_more_popup_title">Full Evaluation Report</strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>   
			<div class="modal-body">
				<div class="form-group">
					<label style="font-size:16px; font-weight:600;">Planning Report</label>
					<p><label><input type="checkbox" id="aprSep1" /> &nbsp;Envision : Goals And Outcomes</label></p>
					<p><label><input type="checkbox" id="aprSep2" /> &nbsp;Coordinate : Alignment Matrix</label></p>
					<p><label><input type="checkbox" id="aprSep3" /> &nbsp;Design : Rotation Plan</label></p>
					<p><label><input type="checkbox" id="aprSep4" /> &nbsp;Reflect : Assessment Plan</label></p>
				</div>
				
				<div class="form-group">
					<label style="font-size:16px; font-weight:600;">Anlaysis Reporting</label>
					<?php foreach($deptAnalysisReports as $reprt){?>
					<p><label><input type="checkbox" id="aprAanalysisReport[]" name="aprAanalysisReport[]" class="arcase" value="<?php echo $reprt['reportId'];?>" /> &nbsp;<?php echo $reprt['reportYear'].' - '.$reprt['reportTitle'];?></label></p>
					<?php } ?>
				</div>	
				
				<div class="form-group">
					<label style="font-size:16px; font-weight:600;">Close The Loop</label>
					<?php foreach($ClosingLoopList as $loop){?>
					<p><label><input type="checkbox" id="aprCloseLoop[]" name="aprCloseLoop[]" class="clpcase" value="<?php echo $loop['loopId'];?>" /> &nbsp;<?php echo $loop['year'].' - '.$loop['yearTitle'];?></label></p>
					<?php } ?>
				</div>
				
				<div class="form-group">
					<label style="font-size:16px; font-weight:600;">Logic Model</label>
					<?php foreach($deptLogicModelData as $model){?>
					<p><label><input type="checkbox" id="aprLogicModel[]" name="aprLogicModel[]" class="lmdlcase" value="<?php echo $model['modelId'];?>" /> &nbsp;<?php echo $model['programYear'].' - '.$model['programName'];?></label></p>
					<?php } ?>
				</div>	 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="disnotiBtn" onclick="return reportGenerate();">Generate Report</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
    	</div>
</div>
</div>