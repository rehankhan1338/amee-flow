<?php if(count($deptAnalysisReports)>0){ ?>
	<div class="col-md-12">
		<div class="bdr">
			<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">Analysis Reporting</h2>
			<?php 
			$ar = 1;foreach($deptAnalysisReports as $report){
			$filterDeptAnalysisReportData = filter_array_chk($deptAnalysisReportData,$report['reportId'],'reportId');
			?>
			
				
				<h4><?php echo $report['reportYear'].' - '.$report['reportTitle'];?></h4>
				<ul class="timeline">
					<?php foreach($filterDeptAnalysisReportData as $optDetails){?>
					<li>
						<label class="assReportPage_title"><?php $fMas = filter_array_chk($optionsMasterArr,$optDetails['anlaysisType'],'id'); echo $fMas[0]['title'];?></label>
							<div class="timeline-item">
							<div class="timeline-header"><?php echo $optDetails['reportDesc'];?></div>
						</div>
					</li>
					<?php } ?> 
				</ul>
				<?php if($ar<count($deptAnalysisReports)){ ?><hr /><?php } ?>
				
			
			<?php $ar++; } ?>
		</div>
	</div>
<?php } ?>