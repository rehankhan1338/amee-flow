<div id="assignment_results" class="subcontent" >
	<div>	
		<div class="contenttitle2 nomargintop">
 			<h3>
			<?php if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){ 
				echo 'Test Takers'; 
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){ 
				echo 'Demography';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='preandpostandonetime'){ 
				if(isset($test_details->test_type)&& $test_details->test_type==1){
					echo 'Pretest and Posttest';
				}else{
					echo 'One Time';
				}
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='preandpost_exam_criteria'){ 
				if(isset($test_details->test_type)&& $test_details->test_type==1){
					echo 'Pretest and Posttest Exam Score Criteria';
				}else{
					echo 'Test Exam Score Criteria';
				}
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='item_analysis'){ 
				echo 'Question Item Analysis';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='outcome_item_analysis'){ 
				echo 'Outcome Item Analysis';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){ 
				echo 'Course Statistics';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='overall_outcome_analysis'){ 
				echo 'Overall Outcome Analysis';
			}
			
			?>
			 Results </h3>
		</div>
		<div class="clearfix"></div>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>	 
<script type="text/javascript">
function apply_view_result_filter(val){
	if(val!=''){
		window.location='<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $_GET['test_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result='+val;
	}
}
function download_res_tbl(){
	var data = document.getElementById('test_section_tbl');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "test-result.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
	});
}
</script>		
	<div class="row manage_filter">	
	<div class="col-md-12" style="display: inline;float: none;">
		<span style="font-weight:600;">View Results:&nbsp;&nbsp;</span>
			<select class="form-control" id="filter_result" name="filter_result" style="display:inline-block; width:30%;" onchange="return apply_view_result_filter(this.value);">
				<option value="">--select--</option>
				<option value="takers" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){?> selected="selected" <?php } ?>>Test Takers</option>
				<option value="demography" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){?> selected="selected" <?php } ?>>Demography Only</option>
				<option value="course_statistics" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){?> selected="selected" <?php } ?>>Course Statistics</option>
				 
				<option value="preandpostandonetime" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='preandpostandonetime'){?> selected="selected" <?php } ?>><?php
				if(isset($test_details->test_type)&& $test_details->test_type==1){
					echo 'Pretest and Posttest';
				}else{
					echo 'One Time';
				}
				?> Results</option>
				 
				<option value="preandpost_exam_criteria" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='preandpost_exam_criteria'){?> selected="selected" <?php } ?>><?php if(isset($test_details->test_type)&& $test_details->test_type==1){
					echo 'Pretest and Posttest Exam Score Criteria';
				}else{
					echo 'Test Exam Score Criteria';
				}?> </option>
				<option value="item_analysis" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='item_analysis'){?> selected="selected" <?php } ?>>Question Item Analysis</option>
				<option value="outcome_item_analysis" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='outcome_item_analysis'){?> selected="selected" <?php } ?>>Outcome Item Analysis</option>
				
				<option value="overall_outcome_analysis" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='overall_outcome_analysis'){?> selected="selected" <?php } ?>>Overall Outcome Analysis</option>
			</select>
			<?php if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){?>
			<a href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $_GET['test_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers" class="btn btn-default" style="margin-left:10px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Test Takers Listing</a>
			<?php } ?>
		
	</div>
</div>	
<?php
if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){
	
	if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){
		$auth_code = $_GET['auth_code'];
		include(APPPATH.'views/Frontend/create/tests/results/answer_details.php');	
	}else{	
		include(APPPATH.'views/Frontend/create/tests/results/test_takers.php');	
	}
	
 	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){
	echo '<div class="instructions"><strong>INSTRUCTIONS:</strong> Click on question to see results.</div>';
	
	include(APPPATH.'views/Frontend/create/tests/results/demography_result.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='preandpostandonetime'){
	 
	include(APPPATH.'views/Frontend/create/tests/results/preandpostandonetime.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='preandpost_exam_criteria'){
	 
	include(APPPATH.'views/Frontend/create/tests/results/preandpost_exam_criteria.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='item_analysis'){
	echo '<div class="instructions"><strong>INSTRUCTIONS:</strong> Click on question to see results.</div>';
	include(APPPATH.'views/Frontend/create/tests/results/item_analysis.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='outcome_item_analysis'){
	echo '<div class="instructions"><strong>INSTRUCTIONS:</strong> Click on question to see results.</div>';
	include(APPPATH.'views/Frontend/create/tests/results/outcome_item_analysis.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){

	include(APPPATH.'views/Frontend/create/tests/results/course_statistics.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='overall_outcome_analysis'){
	 
	include(APPPATH.'views/Frontend/create/tests/results/overall_outcome_analysis.php');	
	
}
?>
</div>
</div>