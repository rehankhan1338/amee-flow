<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />

<div class="box" id="analyze_page">
	<div class="contenttitle2 nomargintop">
		<h3><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp; Ways to Analyze Data With AMEE </h3>
	</div>
	<div class=" pull-right">
		<a class="btn btn-default" href="<?php echo base_url();?>department/analyze/upload/document" style="padding:3px 15px; font-size:16px;"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;Upload Report</a>
	</div>	

<div class="col-xs-12"> 		
	<div class="box-body">
		<ul id="sortable" class="sortable_drag ui-sortable">
			<li onclick="return open_popup_messages('purpose','analyze_overview','1');"><i class="fa fa-eye" aria-hidden="true"></i> Overview <label id="lnk_1"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_method','2');"><i class="fa fa-line-chart" aria-hidden="true"></i> Methods <label id="lnk_2"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_desired_results','3');"><i class="fa fa-bullseye" aria-hidden="true"></i> Desired Results <label id="lnk_3"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_description_of_participants','4');"><i class="fa fa-users" aria-hidden="true"></i> Description of Participants <label id="lnk_4"></label> </li>
			<li onclick="return open_popup_messages('purpose','analyze_data_collect_and_procedures','5');"><i class="fa fa-table" aria-hidden="true"></i> Data Collect and Procedures <label id="lnk_5"></label>	</li>
			<li onclick="return open_popup_messages('purpose','analyze_faculty_participation_training','6');"><i class="fa fa-user" aria-hidden="true"></i> Faculty Participation / Training <label id="lnk_6"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_results_and_findings','7');"><i class="fa fa-search" aria-hidden="true"></i> Results and Findings <label id="lnk_7"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_benchmark_analysis','8');"><i class="fa fa-line-chart" aria-hidden="true"></i> Benchmark Analysis <label id="lnk_8"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_comparative_analysis','9');"><i class="fa fa-compress" aria-hidden="true"></i> Comparative Analysis <label id="lnk_9"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_significance_of_results','10');"><i class="fa fa-bar-chart" aria-hidden="true"></i> Significance of Results <label id="lnk_10"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_conclusions','11');"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Conclusions <label id="lnk_11"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_limitations','12');"><i class="fa fa-stop" aria-hidden="true"></i> Limitations <label id="lnk_12"></label></li>
			<li onclick="return open_popup_messages('purpose','analyze_suggestions','13');"><i class="fa fa-question-circle" aria-hidden="true"></i> Suggestions <label id="lnk_13"></label></li>
			<!--<li onclick="return open_popup_messages('purpose','analyze_closing_the_loop','14');"><i class="fa fa-refresh" aria-hidden="true"></i>  Closing the Loop <label id="lnk_14"></label></li>-->
		</ul>
	</div>
</div>
</div>		