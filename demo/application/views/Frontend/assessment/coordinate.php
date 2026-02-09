<div class="col-md-12">
	<div class="bdr">
		<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">2. COORDINATE : ALIGNMENT MATRIX</h2>
		<h4>2.1 Overview</h4>
		<ul class="timeline">
			<?php if(isset($checklist_detail->coordinate_action1_overview) && $checklist_detail->coordinate_action1_overview!=''){?>
			<li>
				<label class="assReportPage_title">Coordination Review</label>
					<div class="timeline-item">
					<div class="timeline-header"><?php echo $checklist_detail->coordinate_action1_overview;?></div>
				</div>
			</li>
			<?php } ?>
		</ul>
		<h4>2.2 Required Courses / Activities</h4>
		<ul class="timeline">
			<?php if(count($department_courses_result_undergraduate)>0){?>
			<li>
				<label class="assReportPage_title">Undergraduate Courses</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_courses_result_undergraduate as $undergraduate){?>
								<li class="fiftyPerli"><strong><?php echo $undergraduate['course_prefix'].' '.$undergraduate['course_number'];?></strong> <?php echo ' &ndash; '.$undergraduate['course_title']; ?></li>
						<?php } ?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</li>
			<?php } ?>
			
			<?php  if(count($department_courses_result_graduate)>0){?>
			<li>
				<label class="assReportPage_title">Graduate Courses</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_courses_result_graduate as $graduate){?>
								<li class="fiftyPerli"><strong><?php echo $graduate['course_prefix'].' '.$graduate['course_number'];?></strong> <?php echo ' &ndash; '.$graduate['course_title']; ?></li>
						<?php } ?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</li>
			<?php } ?>
			
			<?php if(count($department_programs_align_matrix)>0){?>
			<li>
				<label class="assReportPage_title">Program Alignment Courses</label>
					<div class="timeline-item">
					<div class="timeline-header">
						<ul>
							<?php foreach($department_programs_align_matrix as $plm){?>
								<li class="fiftyPerli"><strong><?php echo $plm['course_prefix'];?></strong> <?php echo ' &ndash; '.$plm['course_title']; ?></li>
						<?php } ?>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
			</li>
			<?php } ?>
		</ul>
		
		<h4>2.3 Identify Course / Activity Level</h4>
		<!--<div class="instructions"><strong>Instructions:</strong> I = Introduce, E=Emphasizing, D = Developing, M = Mastering, P=Practicing</div>-->
		<?php if(count($department_courses_result_undergraduate)>0){?>
			<h5 class="ctrTitle">Alignment Matrix for Undergraduate Program</h5>
			<?php
			$alignmentAction = 0;
			$coursesResult = $department_courses_result_undergraduate;
			$pslosResult = $department_pslos_undergraduate;
			include(APPPATH.'views/Frontend/assessment/common_alignment_matrix.php');
		} ?>
		
		<?php if(count($department_courses_result_graduate)>0){?>
			<h5 class="ctrTitle">Alignment Matrix for Graduate Program</h5>
			<?php
			$alignmentAction = 1;
			$coursesResult = $department_courses_result_graduate;
			$pslosResult = $department_pslos_graduate;
			include(APPPATH.'views/Frontend/assessment/common_alignment_matrix.php');
		} ?>
		
		<?php if(count($department_programs_align_matrix)>0){?>
			<h5 class="ctrTitle">Program Alignment Matrix</h5>
			<?php
			$alignmentAction = 2;
			$coursesResult = $department_programs_align_matrix;
			$pslosResult = $program_learning_outcomes_data;
			include(APPPATH.'views/Frontend/assessment/common_alignment_matrix.php');
		} ?>
		
	</div>
</div>