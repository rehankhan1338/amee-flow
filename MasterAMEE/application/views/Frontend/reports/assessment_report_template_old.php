<script src="<?php echo base_url();?>assets/ExportHtml/FileSaver.js"></script> 
<script src="<?php echo base_url();?>assets/ExportHtml/jquery.wordexport.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
    	$("#export_dept_checklist").click(function(event) {
        	$("#page_dept_checklist").wordExport('planning_report');
      	});
    });
</script>
<div class="pull-right">
	<a class="btn btn-primary" id="export_dept_checklist" style="padding:3px 10px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
	<a class="btn btn-default" href="<?php echo base_url();?>department/reports" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
</div>

<?php
	$Overview = 'When you begin any information gathering process, you usually have a general idea of the topic. Obtaining background information on your subject can provide your readers with a context for your assessment. Use this section to provide a general overview of your report.';	
	
	$Methods = 'This section addressed the form or procedure for your assessment. It is the systematic way in which you accomplished your assessment. In other words, what steps did you take or materials used to conduct your assessment.';	

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
			<p style="margin: 20px 10px 10px;"><?php echo $Overview;?></p>
		</div>
	</div>     
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Methods</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p style="margin: 20px 10px 10px;"><?php echo $Methods;?></p>
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Desired Results</h6>
				
				<p style="margin: 10px 0;">Desired results are statements that reflects the results you wanted to see. You can create a base of information that address the following:</p>				
				<li style="margin: 0px 17px;">To what extent did your students achieve results?</li>
				<li style="margin: 0px 17px;">To what extent did your students achieve results?</li>
				<li style="margin: 0px 17px;">State the quality of results as it relates to your program.</li>
				<li style="margin: 0px 17px;">State the successes and areas of improvement.</li>
			</div>
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Description of Participants</h6>
				
				<p style="margin: 10px 0;">Characteristics of participants can be relevant and meaningful to people reading your assessment report. These data enable us to ensure that participants are representative, or at least identify and relevant differences between the characteristics of the sample of participants or and the target population such as:</p>	
				<li style="margin: 0px 17px;">Race/ethnicity\</li>
				<li style="margin: 0px 17px;">Race/ethnicity\</li>
				<li style="margin: 0px 17px;">Transfer/non-transfer</li>
				<li style="margin: 0px 17px;">Academic status</li>			
			</div>
		</div>	
	</div>
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Data Collection and Procedures</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p style="margin: 20px 10px 10px">This section provides information regarding steps taken to gather data. You may include some or all of the following:</p>			
			<div style="margin: 0px 15px 30px;font-size: 16px">
				<li style="margin: 0px 17px;">Measurement Used</li>
				<li style="margin: 0px 17px;">Research design</li>
				<li style="margin: 0px 17px;">Assignment formulated</li>
				<li style="margin: 0px 17px;">Number of items and questions</li>
				<li style="margin: 0px 17px;">How the instrument was disseminated</li>
				<li style="margin: 0px 17px;">Length of time data was retrieved</li>
				<li style="margin: 0px 17px;">Response rate</li>
				<li style="margin: 0px 17px;">Treatment of missing data</li>
				<li style="margin: 0px 17px;">Type of analysis planned</li>
				<li style="margin: 0px 17px;">Pilot testing</li>
			</div>	
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Faculty Participation</h6>
				
				<p style="margin: 10px 0;">This section can describe all involved in the assessment process and the role they played (i.e., rater). List the number of faculty/staff participants and their specific responsibilities. </p>
			</div>
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Training/Norming</h6>
				
				<p style="margin: 10px 0;">Note how many meetings were held for training/norming or other activities. Here are a few suggestions:</p>				
				<li style="margin: 0px 17px;">How many people were involved?</li>
				<li style="margin: 0px 17px;">How many times you met and why?</li>
				<li style="margin: 0px 17px;">Who did what to make the process effective?</li>
			</div>
		</div>	
	</div>
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Results and Findings</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p style="margin: 20px 10px 10px">The results section is where you report the findings of your assessment based upon the methodology [or methodologies] you applied to gather information. Theresults section should state the findings of the research arranged in a logical sequence without bias or interpretation. Just present the facts.</p>			

			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Benchmark Analysis</h6>
				
				<p style="margin: 10px 0;">A benchmark analysis checks your current results against the standards you set for achievement. Analysis begins with asking the following:</p>
					<li style="margin: 0px 17px;">What is the standard level of performance?</li>
					<li style="margin: 0px 17px;">Who is best meeting the standard?</li>
					<li style="margin: 0px 17px;">How do our participants compare with the set criteria?
					Here are few other things can be considered.</li>
					<li style="margin: 0px 17px;">Identify gaps that between actual performance and best performance, which is called a gap analysis.</li>
					<li style="margin: 0px 17px;">You may also state the best practices that will lead to superior performance</li>
			</div>
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Comparative Analysis</h6>
				
				<p style="margin: 10px 0;">A comparative analysis weighs two items equally or within a structured frame of reference. To do this, ask: </p>				
				<li style="margin: 0px 17px;">How do our participants compare against others across the program? Other programs across the state or nation?</li>
				<p style="margin: 10px 0;">Try not to compare apples to honeybuns. Also, consider the type of measurement tools used, student learning outcomes, and whether the content is truly comparable to your assessment activity.</p>		
			</div>			
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Significance of Results</h6>
				
				<p style="margin: 10px 0;">Significance does not have to refer to the p > value of your results. You could focus on the significance/importance of the results for your program. For example: Results indicate that 80% of our participants scored above average beyond our set criteria for civic engagement. Results indicate that our program is significantly meeting this learning outcome through our internship and service learning programs/courses.</p>
			</div>
		</div>	
	</div>
	
	
	<div style="margin:10px 0;">	
	    <h3 style="color: #485b79; font-weight:600;">Conclusions</h3>
 		<div style="font-size: 16px;color:#333;line-height: 22px;">
			<p style="margin: 20px 10px 10px">Conclusions provides a summary of findings. This section might include implications-the impact your conclusions might have on aspects of your program. You might consider whether and how your findings may be applied to other populations (i.e., course, schools, and programs). 
Phrases such as the following allow readers the freedom to make their own judgements.</p>			
			<div style="margin: 0px 15px 30px;font-size: 16px">
				<li style="margin: 0px 17px;">Assessment results imply</li>
				<li style="margin: 0px 17px;">Assessment results suggest</li>
			</div>
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Limitations</h6>
				
				<p style="margin: 10px 0;">Briefly discuss what you consider to be the weaknesses, shortcomings, or specific problems encountered in the assessment process. All problems cannot be solved. Focusing on problems most important or easily resolved might be an option.</p>
					<li style="margin: 0px 17px;">Look for differences between desired and actual results</li>
					<li style="margin: 0px 17px;">What are the reasons for the problems?</li>
					<li style="margin: 0px 17px;">Are there external factors creating disparities?</li>
			</div>
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Suggestions</h6>
				
				<p style="margin: 10px 0;">Your results will provide you with data, facts and results to help your program make decisions about curriculum changes, hiring needs, course content modifications, etc. Below are a few tips for making suggestions or recommendations:</p>				
				<li style="margin: 0px 17px;">Make sure the suggestions can be implemented in a timely manner</li>
				<li style="margin: 0px 17px;">Make sure the suggestions are cost effective or can save money</li>
				
				<li style="margin: 0px 17px;">Make sure suggestions are positive and not a complaint about a problem</li>
				<li style="margin: 0px 17px;">Make sure suggestions are thoughtful and substantive</li>	
			</div>			
			
			
			<div style="margin: 0px 50px 30px;font-size: 16px">
				<h6 style="font-size: 16px; margin:10px 0;color:#333;">Closing the Loop</h6>				
				<p style="margin: 10px 0;">This section considers the kinds of improvements and changes you have made to your program.</p>
			</div>
		</div>	
	</div> 
</div>