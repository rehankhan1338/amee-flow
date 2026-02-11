<section class="content">
<style>
/* ============================================================
   My Projects – Modern Card Grid
   ============================================================ */
.af-projects-grid {
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	gap: 20px;
	padding: 20px;
}
@media (max-width: 991px) {
	.af-projects-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 575px) {
	.af-projects-grid { grid-template-columns: 1fr; padding: 14px; gap: 14px; }
}

/* --- Project Card --- */
.af-pro-card {
	background: #fff;
	border-radius: 14px;
	overflow: hidden;
	box-shadow: 0 2px 12px rgba(0,0,0,0.06);
	transition: transform .25s ease, box-shadow .25s ease;
	display: flex;
	flex-direction: column;
	position: relative;
	border: 1px solid #eef0f3;
}
.af-pro-card:hover {
	transform: translateY(-4px);
	box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

/* Colour accent strip at top */
.af-pro-accent {
	height: 5px;
	width: 100%;
	flex-shrink: 0;
}

/* Card body */
.af-pro-body {
	padding: 20px 22px 18px;
	flex: 1;
	display: flex;
	flex-direction: column;
}

/* Icon badge */
.af-pro-icon {
	width: 44px;
	height: 44px;
	border-radius: 12px;
	display: flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 14px;
	flex-shrink: 0;
}
.af-pro-icon svg,
.af-pro-icon i {
	width: 22px;
	height: 22px;
	stroke-width: 2;
}

/* Title */
.af-pro-title {
	font-size: 1.1rem;
	font-weight: 700;
	color: #2c3e50;
	margin: 0 0 10px;
	line-height: 1.35;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}

/* Meta row */
.af-pro-meta {
	display: flex;
	flex-wrap: wrap;
	gap: 10px;
	margin-bottom: 16px;
}
.af-pro-badge {
	display: inline-flex;
	align-items: center;
	gap: 5px;
	padding: 4px 12px;
	border-radius: 20px;
	font-size: .78rem;
	font-weight: 600;
	background: #f0f2f5;
	color: #555;
}
.af-pro-badge i,
.af-pro-badge svg {
	width: 13px;
	height: 13px;
	stroke-width: 2.5;
	font-size: .72rem;
	opacity: .7;
}

/* Spacer pushes footer down */
.af-pro-spacer { flex: 1; }

/* Card footer / CTA */
.af-pro-footer {
	padding: 14px 22px;
	border-top: 1px solid #f0f1f4;
	background: #fafbfc;
}
.af-pro-cta {
	display: inline-flex;
	align-items: center;
	gap: 8px;
	font-size: .86rem;
	font-weight: 600;
	color: #485b79;
	text-decoration: none;
	padding: 7px 18px;
	border-radius: 22px;
	border: 1.5px solid #485b79;
	transition: all .2s ease;
	background: transparent;
}
.af-pro-cta:hover {
	background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
	color: #fff;
	border-color: transparent;
	transform: translateX(2px);
	text-decoration: none;
}
.af-pro-cta i {
	transition: transform .2s ease;
	font-size: .8rem;
}
.af-pro-cta:hover i {
	transform: translateX(3px);
}

/* ============================================================
   Summary Bar
   ============================================================ */
.af-pro-summary {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 16px;
	padding: 16px 22px;
	background: #f8f9fb;
	border-bottom: 1px solid #eef0f3;
}
.af-pro-summary-item {
	display: flex;
	align-items: center;
	gap: 8px;
	font-size: .88rem;
	color: #666;
}
.af-pro-summary-count {
	font-weight: 700;
	color: #485b79;
	font-size: 1.05rem;
}

/* ============================================================
   Empty State
   ============================================================ */
.af-pro-empty {
	text-align: center;
	padding: 60px 30px 70px;
}
.af-pro-empty-icon {
	width: 80px;
	height: 80px;
	border-radius: 50%;
	background: linear-gradient(135deg, #eef1f6, #dfe4ec);
	display: inline-flex;
	align-items: center;
	justify-content: center;
	margin-bottom: 20px;
}
.af-pro-empty-icon i {
	font-size: 2rem;
	color: #8d99ae;
}
.af-pro-empty h3 {
	font-size: 1.25rem;
	font-weight: 700;
	color: #485b79;
	margin-bottom: 8px;
}
.af-pro-empty p {
	font-size: .92rem;
	color: #888;
	max-width: 420px;
	margin: 0 auto;
	line-height: 1.6;
}
</style>

<div class="box">
	<div class="box-header no-border">
		<h3 class="box-title">My Projects</h3>
	</div>

	<?php if(count($assignProjectsDataArr) > 0){ ?>

		<!-- Summary bar -->
		<div class="af-pro-summary">
			<div class="af-pro-summary-item">
				<i data-feather="briefcase" style="width:18px;height:18px;color:#485b79;"></i>
				<span><span class="af-pro-summary-count"><?php echo count($assignProjectsDataArr); ?></span> Project<?php echo count($assignProjectsDataArr) > 1 ? 's' : ''; ?></span>
			</div>
		</div>

		<!-- Project cards grid -->
		<div class="af-projects-grid">
			<?php foreach($assignProjectsDataArr as $pro){
				$taskCnt = getUserAssignProTaskCnt($pro['projectId'], $sessionDetailsArr['userId']);
				$termLabel = $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'];
				$bgColor = isset($pro['bgColor']) && $pro['bgColor'] != '' ? $pro['bgColor'] : '#485b79';
				$fontColor = isset($pro['fontColor']) && $pro['fontColor'] != '' ? $pro['fontColor'] : '#fff';
				$btnColor = isset($pro['btnColor']) && $pro['btnColor'] != '' ? $pro['btnColor'] : '#e18125';
			?>
			<div class="af-pro-card">
				<!-- Accent strip uses project colour -->
				<div class="af-pro-accent" style="background:<?php echo $bgColor;?>;"></div>

				<div class="af-pro-body">
					<!-- Icon badge -->
					<div class="af-pro-icon" style="background:<?php echo $bgColor;?>15;">
						<i data-feather="clipboard" style="color:<?php echo $bgColor;?>;"></i>
					</div>

					<!-- Title -->
					<h4 class="af-pro-title"><?php echo $pro['projectName'];?></h4>

					<!-- Meta badges -->
					<div class="af-pro-meta">
						<span class="af-pro-badge">
							<i data-feather="calendar"></i>
							<?php echo $termLabel; ?>
						</span>
						<span class="af-pro-badge">
							<i data-feather="check-circle"></i>
							<?php echo $taskCnt; ?> Task<?php echo $taskCnt != 1 ? 's' : ''; ?>
						</span>
					</div>

					<div class="af-pro-spacer"></div>
				</div>

				<!-- Footer with CTA -->
				<div class="af-pro-footer">
					<a href="<?php echo base_url().'projects/tasks/'.$pro['proencryptId'];?>" class="af-pro-cta">
						Go to Tasks <i class="fa fa-arrow-right"></i>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>

	<?php } else { ?>

		<!-- Empty state -->
		<div class="af-pro-empty">
			<div class="af-pro-empty-icon">
				<i class="fa fa-folder-open-o"></i>
			</div>
			<h3>No Projects Assigned</h3>
			<p>Your projects will appear here when you have been assigned tasks. Please check back later or contact your project lead.</p>
		</div>

	<?php } ?>
</div>

<script>
$(function(){
	feather.replace();
});
</script>
</section>
