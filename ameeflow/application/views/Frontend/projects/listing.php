<section class="content">

<div class="box">
	<div class="box-header no-border">
		<h3 class="box-title">My Projects</h3>
	</div>

	<?php if(count($assignProjectsDataArr) > 0){ ?>

		<!-- Summary bar with search -->
		<div class="af-pro-summary">
			<div class="af-pro-summary-left">
				<div class="af-pro-summary-item">
					<i data-feather="briefcase" style="width:18px;height:18px;color:#485b79;"></i>
					<span><span class="af-pro-summary-count" id="afProVisibleCount"><?php echo count($assignProjectsDataArr); ?></span> Project<?php echo count($assignProjectsDataArr) > 1 ? 's' : ''; ?></span>
				</div>
			</div>
			<div class="af-pro-search-wrap">
				<span class="af-pro-search-icon"><i data-feather="search"></i></span>
				<input type="text" class="af-pro-search-input" id="afProSearchInput" placeholder="Search projects..." autocomplete="off">
				<button type="button" class="af-pro-search-clear" id="afProSearchClear"><i class="fa fa-times"></i></button>
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
				$taskUrl = base_url().'projects/tasks/'.$pro['proencryptId'];
			?>
			<a href="<?php echo $taskUrl; ?>" class="af-pro-card-link">
			<div class="af-pro-card" style="--card-color:<?php echo $bgColor;?>;">
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
					<span class="af-pro-cta">
						Go to Tasks <i class="fa fa-arrow-right"></i>
					</span>
				</div>
			</div>
			</a>
			<?php } ?>

			<!-- No search results (hidden by default) -->
			<div class="af-pro-no-results" id="afProNoResults">
				<div class="af-pro-no-results-icon"><i class="fa fa-search"></i></div>
				<h5>No projects found</h5>
				<p>Try a different search term</p>
			</div>
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

	// --- Project Search ---
	var $input    = $('#afProSearchInput'),
		$clearBtn = $('#afProSearchClear'),
		$cards    = $('.af-pro-card-link'),
		$noResult = $('#afProNoResults'),
		$count    = $('#afProVisibleCount'),
		totalCount = $cards.length;

	$input.on('input', function(){
		var query = $.trim($(this).val()).toLowerCase();

		// Toggle clear button
		$clearBtn.css('display', query.length ? 'flex' : 'none');

		var visible = 0;
		$cards.each(function(){
			var title = $(this).find('.af-pro-title').text().toLowerCase();
			var meta  = $(this).find('.af-pro-badge').text().toLowerCase();
			var match = title.indexOf(query) !== -1 || meta.indexOf(query) !== -1;
			$(this).css('display', match ? '' : 'none');
			if(match) visible++;
		});

		// Update count & no-results message
		$count.text(visible);
		$noResult.css('display', visible === 0 && query.length ? 'block' : 'none');
	});

	// Clear button
	$clearBtn.on('click', function(){
		$input.val('').trigger('input').focus();
	});

	// Allow Escape key to clear search
	$input.on('keydown', function(e){
		if(e.key === 'Escape'){
			$(this).val('').trigger('input');
		}
	});
});
</script>
</section>
