<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#export_dept_checklist").click(function(event) {
        	$("#page_dept_checklist").wordExport('assessment_template_report');
      	});
    });
</script>
<div class="pull-right">
	<!--<a class="btn btn-default" href="<?php echo base_url();?>department/reports/assessment/uplode" style="padding:3px 10px; font-size:15px;"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;Upload Report</a>-->
	<a class="btn btn-primary" id="export_dept_checklist" style="padding:3px 10px; font-size:15px; margin:0 5px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>

<?php
	$Overview = 'When you begin any information gathering process, you usually have a general idea of the topic. Obtaining background information on your subject can provide your readers with a context for your assessment. Use this section to provide a general overview of your report.';	
	
	$Methods = 'This section addressed the form or procedure for your assessment. It is the systematic way in which you accomplished your assessment. In other words, what steps did you take or materials used to conduct your assessment.';		
	
	$Desired_results = 'Desired results are statements that reflects the results you wanted to see. You can create a base of information that address the following:';	
	
	$Description_of_Participants = 'Characteristics of participants can be relevant and meaningful to people reading your assessment report. These data enable us to ensure that participants are representative, or at least identify and relevant differences between the characteristics of the sample of participants or and the target population such as:';	
	
	
	$Results_and_Findings = 'The results section is where you report the findings of your assessment based upon the methodology [or methodologies] you applied to gather information. Theresults section should state the findings of the research arranged in a logical sequence without bias or interpretation. Just present the facts.';

	$Significance_of_Results = 'Significance does not have to refer to the p > value of your results. You could focus on the significance/importance of the results for your program. For example: Results indicate that 80% of our participants scored above average beyond our set criteria for civic engagement. Results indicate that our program is significantly meeting this learning outcome through our internship and service learning programs/courses.';
	
	$Conclusions = 'Conclusions provides a summary of findings. This section might include implications-the impact your conclusions might have on aspects of your program. You might consider whether and how your findings may be applied to other populations (i.e., course, schools, and programs). 
Phrases such as the following allow readers the freedom to make their own judgements.';
	
	$Limitations = 'Briefly discuss what you consider to be the weaknesses, shortcomings, or specific problems encountered in the assessment process. All problems cannot be solved. Focusing on problems most important or easily resolved might be an option.';	
	
	$Suggestions = 'Your results will provide you with data, facts and results to help your program make decisions about curriculum changes, hiring needs, course content modifications, etc. Below are a few tips for making suggestions or recommendations:';

?>


<div class="clearfix"></div>
<div id="page_dept_checklist">
	 
	<div style="text-align: center;">
		<h2 style="color: #485b79;margin: 15px 0; font-style:italic;"><b><?php echo $dept_session_details->department_name;?></b></h2>    
		<!--<h3 style=" margin:15px 0;color:#485b79; font-style:italic;"><b><?php if(isset($university_details->university_name)&& $university_details->university_name!=''){echo str_replace('College','',$university_details->university_name); }else{ echo 'DEMO College';} ?></b></h3>-->
		<h6 style="font-size: 16px; margin:15px 0;color:#333;"><b>Assessment Data Analysis Report </b></h6>
		<h6 style="font-size: 16px; margin:15px 0;color:#333;"><b>Prepared by <?php echo $dept_session_details->first_name.' '.$dept_session_details->last_name;?></b></h6>
	</div>	 
		    
	    
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Overview</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p><?php echo $Overview;?></p>
		</div>
	</div>	
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Methods</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p><?php echo $Methods;?></p>
		</div>
	</div>
	
		
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Desired Results</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p><?php echo $Desired_results;?></p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>To what extent did your students achieve results?</li>
				<li>To what extent did your students achieve results?</li>
				<li>State the quality of results as it relates to your program.</li>
				<li>State the successes and areas of improvement.</li>
			</ul>
		</div>
	</div>	
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Description of Participants</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p><?php echo $Description_of_Participants;?></p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>Race/ethnicity\</li>
				<li>Race/ethnicity\</li>
				<li>Transfer/non-transfer</li>
				<li>Academic status</li>
			</ul>
		</div>
	</div>
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Data Collection and Procedures</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p>This section provides information regarding steps taken to gather data. You may include some or all of the following:</p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>Measurement Used</li>
				<li>Research design</li>
				<li>Assignment formulated</li>
				<li>Number of items and questions</li>
				<li>How the instrument was disseminated</li>
				<li>Length of time data was retrieved</li>
				<li>Response rate</li>
				<li>Treatment of missing data</li>
				<li>Type of analysis planned</li>
				<li>Pilot testing</li>
			</ul>
		</div>
	</div>
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Faculty Participation</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p>This section can describe all involved in the assessment process and the role they played (i.e., rater). List the number of faculty/staff participants and their specific responsibilities. </p>
		</div>
	</div>
	
		
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Training/Norming</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p>Note how many meetings were held for training/norming or other activities. Here are a few suggestions:</p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>How many people were involved?</li>
				<li>How many times you met and why?</li>
				<li>Who did what to make the process effective?</li>
			</ul>
		</div>
	</div>	
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Results and Findings</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p><?php echo $Results_and_Findings;?></p>
		</div>
	</div>
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Benchmark Analysis</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p>A benchmark analysis checks your current results against the standards you set for achievement. Analysis begins with asking the following:</p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>What is the standard level of performance?</li>
				<li>Who is best meeting the standard?</li>
				<li>How do our participants compare with the set criteria?
				Here are few other things can be considered.</li>
				<li>Identify gaps that between actual performance and best performance, which is called a gap analysis.</li>
				<li>You may also state the best practices that will lead to superior performance</li>
			</ul>
		</div>
	</div>
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Comparative Analysis</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p>A comparative analysis weighs two items equally or within a structured frame of reference. To do this, ask: </p>
				
			<li style="margin: -18px 17px;">How do our participants compare against others across the program? Other programs across the state or nation?</li>
			
			<p>
				Try not to compare apples to honeybuns. Also, consider the type of measurement tools used, student learning outcomes, and whether the content is truly comparable to your assessment activity.
			</p>
		</div>
	</div>
	
		
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Significance of Results</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p><?php echo $Significance_of_Results;?></p>
		</div>
	</div>	
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Conclusions</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p><?php echo $Conclusions;?></p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>Assessment results imply</li>
				<li>Assessment results suggest</li>
			</ul>
		</div>
	</div>
		
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Limitations</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p><?php echo $Limitations;?></p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>Look for differences between desired and actual results</li>
				<li>What are the reasons for the problems?</li>
				<li>Are there external factors creating disparities?</li>
			</ul>
		</div>
	</div>	
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Suggestions</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p><?php echo $Suggestions;?></p>
			<ul style="margin: -14px 35px 20px; line-height: 29px;">
				<li>Make sure the suggestions can be implemented in a timely manner</li>
				<li>Make sure the suggestions are cost effective or can save money</li>				
				<li>Make sure suggestions are positive and not a complaint about a problem</li>
				<li>Make sure suggestions are thoughtful and substantive</li>	
			</ul>
		</div>
	</div>	
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Closing the Loop</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
 			<p>This section considers the kinds of improvements and changes you have made to your program.</p>
		</div>
	</div>
	
</div>