<div class="col-md-12">
	<div class="bdr">
		<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">1. Envision : Goals and Outcomes</h2>
		<h4>1.1 Overview, Mission, Vision &amp; Goals</h4>
		<ul class="timeline">
			<?php if(isset($checklist_detail->envision_action1_overview) && $checklist_detail->envision_action1_overview!=''){?>
			<li>
				<label class="assReportPage_title">Introduction</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->envision_action1_overview;?></div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(isset($checklist_detail->mission_statement) && $checklist_detail->mission_statement!=''){?>
			<li>
				<label class="assReportPage_title">Mission Statement</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->mission_statement;?></div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(isset($checklist_detail->vision_statement) && $checklist_detail->vision_statement!=''){?>
			<li>
				<label class="assReportPage_title">Vision Statement</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->vision_statement;?></div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(isset($checklist_detail->program_goals) && $checklist_detail->program_goals!=''){?>
			<li>
				<label class="assReportPage_title">Department / Program Goals</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->program_goals;?></div>
				</div>
			</li>
			<?php } ?>
		</ul>
		
		<h4>1.2 Learning Outcomes &amp; Objectives</h4>
		<ul class="timeline">
			<?php if(isset($checklist_detail->envision_action2_overview) && $checklist_detail->envision_action2_overview!=''){?>
			<li>
				<label class="assReportPage_title">Overview</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->envision_action2_overview;?></div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(count($department_pslos_undergraduate)>0){?>
			<li>
				<label class="assReportPage_title">Undergraduate PSLOs</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_pslos_undergraduate as $undergraduate){?>
								<li><strong><?php echo $undergraduate['plso_prefix'];?></strong> <?php echo ' : '.$undergraduate['plso_title']; ?></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(count($department_pslos_graduate)>0){?>
			<li>
				<label class="assReportPage_title">Graduate PSLOs</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_pslos_graduate as $graduate_courses){?>
								<li><strong><?php echo $graduate_courses['plso_prefix'];?></strong> <?php echo ' : '.$graduate_courses['plso_title']; ?></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(count($program_learning_outcomes_data)>0){?>
			<li>
				<label class="assReportPage_title">Program Learning Outcomes (PLO)</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($program_learning_outcomes_data as $plo_courses){?>
								<li><strong><?php echo $plo_courses['plso_prefix'];?></strong> <?php echo ' : '.$plo_courses['plso_title']; ?></li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
		 
		<h4>1.3 Assign Core Competencies</h4>
		<ul class="timeline">
		<?php if(count($department_pslos_undergraduate)>0){?>
			<li>
				<label class="assReportPage_title">Undergraduate PSLOs </label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_pslos_undergraduate as $undergraduate){
							
								$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$undergraduate['id'],'department_pslos_id');
								$core_competency_details_arr = array();
								if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
 									$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);									
								}							
							?>
								<li><strong><?php echo $undergraduate['plso_prefix'];?></strong> <?php echo ' : '.$undergraduate['plso_title']; 								
									if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = $coreComptyData[0]['name'].' (CC'.$cc.')';
											}
										}
									?>
									<div class="assCoreCom">&mdash; <?php echo implode(', ',$imCoreComArr);?></div>	
									<?php } ?>
								</li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
		<?php if(count($department_pslos_graduate)>0){?>
			<li>
				<label class="assReportPage_title">Graduate PSLOs </label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_pslos_graduate as $graduate_courses){
							
								$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$graduate_courses['id'],'department_pslos_id');
								$core_competency_details_arr = array();
								if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
 									$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);									
								}							
							?>
								<li><strong><?php echo $graduate_courses['plso_prefix'];?></strong> <?php echo ' : '.$graduate_courses['plso_title']; 								
									if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = $coreComptyData[0]['name'].' (CC'.$cc.')';
											}
										}
									?>
									<div class="assCoreCom">&mdash; <?php echo implode(', ',$imCoreComArr);?></div>	
									<?php } ?>
								</li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
		<?php if(count($program_learning_outcomes_data)>0){?>
			<li>
				<label class="assReportPage_title">Program Learning Outcomes </label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($program_learning_outcomes_data as $plo){
							
								$coreComptyData = filter_array_chk($deptAssignedCoreComtyData,$plo['id'],'department_pslos_id');
								$core_competency_details_arr = array();
								if(isset($coreComptyData) && $coreComptyData!='' && $coreComptyData>0){
 									$core_competency_details_arr = explode(',',$coreComptyData[0]['core_competency_id']);
									sort($core_competency_details_arr);									
								}							
							?>
								<li><strong><?php echo $plo['plso_prefix'];?></strong> <?php echo ' : '.$plo['plso_title']; 								
									if(count($core_competency_details_arr)>0){
										$imCoreComArr = array();
										foreach($core_competency_details_arr as $cc){
											$coreComptyData = filter_array_chk($masterCoreCompetencyArr,$cc,'id');
											if(isset($coreComptyData[0]['name']) && $coreComptyData[0]['name']!=''){
												$imCoreComArr[] = $coreComptyData[0]['name'].' (CC'.$cc.')';
											}
										}
									?>
									<div class="assCoreCom">&mdash; <?php echo implode(', ',$imCoreComArr);?></div>	
									<?php } ?>
								</li>
						<?php } ?>
						</ul>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>