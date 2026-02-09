<div id="assignment_results" class="subcontent" >
	<div>	
		<div class="contenttitle2 nomargintop">
 			<h3>
			<?php if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){ 
				echo 'Assignment Takers'; 
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){ 
				echo 'Demography';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='rater_status'){ 
				echo 'Rater Status';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='overall_rating'){ 
				echo 'Overall Ratings';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){ 
				echo 'Course Statistics';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='self_report_result'){ 
				echo 'Assignment Score Self-Report';
			}else if(isset($_GET['view_result']) && $_GET['view_result']=='rater_reliability'){ 
				echo 'Rater Reliability Report';
			}
			?>
			 Results </h3>
		</div>
		<div class="clearfix"></div>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> 
<script type="text/javascript">
function apply_view_filter(val){
	if(val!=''){
		window.location='<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8&ar_id=<?php echo $_GET['ar_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result='+val;
	}
}
function download_res_tbl(){
	var data = document.getElementById('assignment_section_tbl');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "assignment-result.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
	});
}
</script>		
<div class="row manage_filter">
	<div class="col-md-12" style="display: inline;float: none;">
		<span style="font-weight:600;">View Results:&nbsp;&nbsp;</span>
			<select class="form-control" id="filter_cross_tabulation" name="filter_cross_tabulation" style="display:inline-block; width:30%;" onchange="return apply_view_filter(this.value);">
				<option value="">--select--</option>
				<option value="takers" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){?> selected="selected" <?php } ?>>Assignment Takers</option>
				<option value="demography" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){?> selected="selected" <?php } ?>>Demography Only</option>
				<option value="overall_rating" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='overall_rating'){?> selected="selected" <?php } ?>>Overall Ratings</option>
				<option value="rater_status" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='rater_status'){?> selected="selected" <?php } ?>>Rater Status</option>
				<option value="rater_reliability" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='rater_reliability'){?> selected="selected" <?php } ?>>Rater Reliability</option>
				<option value="course_statistics" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){?> selected="selected" <?php } ?>>Course Statistics</option>
				<option value="self_report_result" <?php if(isset($_GET['view_result']) && $_GET['view_result']=='self_report_result'){?> selected="selected" <?php } ?>>Self-Report Result</option>
			</select>
			<?php if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){?>
			<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8&ar_id=<?php echo $_GET['ar_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers" class="btn btn-default" style="margin-left:10px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Assingment Takers Listing</a>
			<?php } ?>
	</div>
</div>	
<?php
if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){
	
	if(isset($_GET['auth_code']) && $_GET['auth_code']!='' && isset($_GET['individual_rating']) && $_GET['individual_rating']!=''){
		$auth_code = $_GET['auth_code'];
		include(APPPATH.'views/Frontend/create/assignments_rubrics/results/individual_raters_rating.php');	
	}else if(isset($_GET['auth_code']) && $_GET['auth_code']!=''){
		$auth_code = $_GET['auth_code'];
		include(APPPATH.'views/Frontend/create/assignments_rubrics/results/answer_details.php');	
	}else{	
		include(APPPATH.'views/Frontend/create/assignments_rubrics/results/assignment_takers.php');	
	}
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='demography'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/demography_result.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='overall_rating'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/overall_rating.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='rater_status'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/rater_status.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='course_statistics'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/course_statistics.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='self_report_result'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/self_report_result.php');	
	
}else if(isset($_GET['view_result']) && $_GET['view_result']=='rater_reliability'){

	include(APPPATH.'views/Frontend/create/assignments_rubrics/results/rater_reliability.php');	
	
}
?>
</div>
</div>