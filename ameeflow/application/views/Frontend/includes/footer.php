		</div><!-- /.content-wrapper -->

		<!-- ============================================================
		     Modern Footer
		     ============================================================ -->
		<footer class="af-footer">
			<div class="container-fluid">
				<div class="d-flex flex-wrap justify-content-between align-items-center">
					<div>
						&copy; 2010 &ndash; <?php echo date('Y');?>
						<strong><?php echo $this->config->item('product_name');?></strong>. All rights reserved.
					</div>
					<div class="af-footer-tagline d-none d-sm-block">
						<?php echo $this->config->item('short_product_desc');?>
					</div>
				</div>
			</div>
		</footer>

</div><!-- /.wrapper -->

<!-- Plugins & Scripts -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/backend/plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
function readURL(input){
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#blah').attr('src', e.target.result);
		};
		reader.readAsDataURL(input.files[0]);
	}
}
$(function(){

	$("#selectall").click(function () {
		$('.case').attr('checked', this.checked);
	});
	$(".case").click(function(){
		if($(".case").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}
	});

	$('#table_recordtbl').DataTable({
		"paging": true,
		"pageLength": 100,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"dom": '<"af-dt-top"f>rt<"af-dt-bottom"ilp>'
	});

	if($('#editor').length > 0){
		CKEDITOR.replace( 'editor',{height: '300px',});
	}

	$('#Date2').datepicker({
		startDate: new Date(),
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true
	});

	$('#Date1').datepicker({
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true
	});

	$('[data-bs-toggle="tooltip"]').tooltip({ html: true });
	feather.replace();

	/* ============================================================
	   Universal "No Data Found" Message for Empty Tables
	   ============================================================ */
	(function checkEmptyTables(){
		var noDataHTML = '<tr class="no-data-row"><td colspan="COL_COUNT" class="text-center" style="padding:40px 20px !important;">' +
			'<div style="display:flex;flex-direction:column;align-items:center;gap:8px;">' +
			'<i class="fa fa-inbox" style="font-size:2.5rem;color:#d0d5dd;"></i>' +
			'<p style="font-size:1rem;color:#999;margin:0;font-weight:500;">No data found</p>' +
			'</div></td></tr>';

		function addNoDataMessage($tbody, colCount){
			// Skip if already has our no-data row
			if($tbody.find('.no-data-row').length > 0) return;

			// Count real content rows (exclude hidden filter no-results rows)
			var contentRows = 0;
			$tbody.find('tr').each(function(){
				var $tr = $(this);
				// Skip hidden rows and special "no results" rows used by filters
				if($tr.hasClass('af-roles-no-results')) return;
				if($tr.hasClass('no-data-row')) return;
				// Count rows that are actual data
				contentRows++;
			});

			if(contentRows === 0){
				$tbody.append(noDataHTML.replace('COL_COUNT', colCount));
			}
		}

		// Check all tables on page load
		setTimeout(function(){
			$('table').each(function(){
				var $table = $(this);
				var $tbody = $table.find('tbody');
				if(!$tbody.length) return;
				// Skip nested tables (e.g. approval status tables inside cells)
				if($table.closest('td').length) return;
				var colCount = $table.find('> thead th, > thead > tr > th').length ||
				               $table.find('> thead td, > thead > tr > td').length || 1;
				addNoDataMessage($tbody, colCount);
			});
		}, 150);

		// Also check after DataTable initialization
		if($.fn.dataTable){
			$(document).on('init.dt', function(e, settings){
				var api = new $.fn.dataTable.Api(settings);
				var $tbody = $(settings.nTBody);
				var colCount = $(settings.nTable).find('thead th').length;
				setTimeout(function(){
					if(api.rows().count() === 0){
						addNoDataMessage($tbody, colCount);
					}
				}, 50);
			});
		}
	})();

	/* ============================================================
	   Universal Sticky Header for all DataTables
	   ============================================================ */
	(function initStickyHeaders(){
		var navH = $('.af-navbar').outerHeight() || 60;
		var stickyInstances = {};

		// Helper: Build clone for scrollX tables
		function buildCloneScrollX(inst){
			inst.$sticky.empty();
			var $clone = inst.$scrollHead.children().clone(false);
			inst.$sticky.append($clone);

			var $origThs = inst.$scrollHead.find('th');
			var $cloneThs = inst.$sticky.find('th');
			$origThs.each(function(i){
				var w = $(this).outerWidth();
				$cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
			});

			var $origInner = inst.$scrollHead.find('.dataTables_scrollHeadInner');
			var $cloneInner = inst.$sticky.find('.dataTables_scrollHeadInner');
			if($origInner.length){
				$cloneInner.css('width', $origInner[0].style.width || $origInner.outerWidth());
			}
			var $origTable = inst.$scrollHead.find('table').first();
			var $cloneTable = inst.$sticky.find('table').first();
			if($origTable.length){
				$cloneTable.css('width', $origTable[0].style.width || $origTable.outerWidth());
			}
		}

		// Helper: Build clone for regular tables (no scrollX)
		function buildCloneRegular(inst){
			inst.$sticky.empty();
			var $origTable = inst.$table;
			var $origThead = $origTable.find('thead');
			if(!$origThead.length) return;

			// Create a wrapper table with cloned thead
			var $cloneTable = $('<table class="' + $origTable.attr('class') + '"></table>');
			var $cloneThead = $origThead.clone(false);
			$cloneTable.append($cloneThead);
			inst.$sticky.append($cloneTable);

			// Match table width
			$cloneTable.css('width', $origTable.outerWidth());

			// Match each th width
			var $origThs = $origThead.find('th');
			var $cloneThs = $cloneThead.find('th');
			$origThs.each(function(i){
				var w = $(this).outerWidth();
				$cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
			});
		}

		function positionSticky(inst){
			var el = inst.$container[0];
			if(!el) return;
			var r = el.getBoundingClientRect();
			inst.$sticky.css({ left: r.left, width: r.width });
		}

		function syncScroll(inst){
			if(inst.hasScrollX){
				inst.$sticky.scrollLeft(inst.$scrollBody.scrollLeft());
			}
		}

		// Wait for DataTables to initialize
		setTimeout(function(){
			// Find all DataTables by looking for tables with dataTable class or in wrappers
			$('table.dataTable').each(function(){
				var $table = $(this);
				var tableId = this.id;
				if(!tableId) return;
				
				// Skip master-alignment-map table (has its own implementation)
				if(tableId === 'table_recordtbl_mam') return;
				
				// Skip if already processed
				if(stickyInstances[tableId]) return;
				
				var $wrapper = $table.closest('[id$="_wrapper"]');
				if(!$wrapper.length) $wrapper = $table.parent();
				
				var $scrollHead = $wrapper.find('.dataTables_scrollHead');
				var $scrollBody = $wrapper.find('.dataTables_scrollBody');
				var hasScrollX = $scrollHead.length > 0 && $scrollBody.length > 0;
				
				// Find the table container
				var $tableContainer = $wrapper.closest('.table-responsive, .box-body, .col-xs-12, .col-12, .box').first();
				if(!$tableContainer.length) $tableContainer = $wrapper.parent();
				
				// Create unique sticky header container
				var stickyId = 'af-sticky-' + tableId.replace(/[^a-zA-Z0-9]/g, '-');
				var $sticky = $('<div class="af-sticky-header" data-table-id="' + tableId + '"></div>');
				$sticky.attr('id', stickyId);
				$('body').append($sticky);
				
				// Get DataTable API instance
				var dt = null;
				try {
					dt = new $.fn.dataTable.Api('#' + tableId);
				} catch(e) {
					// Table might not be fully initialized yet
				}
				
				var inst = {
					$wrapper: $wrapper,
					$table: $table,
					$sticky: $sticky,
					$container: $tableContainer,
					tableId: tableId,
					hasScrollX: hasScrollX,
					$scrollHead: hasScrollX ? $scrollHead : null,
					$scrollBody: hasScrollX ? $scrollBody : null,
					dt: dt
				};
				
				stickyInstances[tableId] = inst;

				function onScroll(){
					var $header = hasScrollX ? inst.$scrollHead : inst.$table.find('thead');
					if(!$header.length) return;
					
					var headRect = $header[0].getBoundingClientRect();
					var containerRect = inst.$container[0].getBoundingClientRect();
					if(!containerRect) return;
					var wrapBottom = containerRect.bottom;

					if(headRect.top < navH && wrapBottom > navH + 50){
						if(!inst.$sticky.is(':visible')){
							if(hasScrollX){
								buildCloneScrollX(inst);
							} else {
								buildCloneRegular(inst);
							}
						}
						positionSticky(inst);
						syncScroll(inst);
						inst.$sticky.show();
					} else {
						inst.$sticky.hide();
					}
				}

				// Sync horizontal scroll for scrollX tables
				if(hasScrollX){
					inst.$scrollBody.on('scroll', function(){ 
						if(inst.$sticky.is(':visible')) syncScroll(inst); 
					});
					inst.$sticky.on('scroll', function(){ 
						inst.$scrollBody.scrollLeft(inst.$sticky.scrollLeft()); 
					});
				}

				// Bind scroll handler
				$(window).on('scroll.afSticky' + tableId, onScroll);
				
				// Rebuild on DataTable draw
				if(inst.dt){
					inst.dt.on('draw', function(){
						inst.$sticky.hide();
					});
				}
			});

			// Also check for tables by wrapper ID (fallback for tables without dataTable class)
			$('[id$="_wrapper"]').each(function(){
				var $wrapper = $(this);
				var wrapperId = this.id;
				var tableId = wrapperId.replace('_wrapper', '');
				
				if(tableId === 'table_recordtbl_mam' || stickyInstances[tableId]) return;
				
				var $table = $('#' + tableId);
				if(!$table.length) return;
				
				var $scrollHead = $wrapper.find('.dataTables_scrollHead');
				var $scrollBody = $wrapper.find('.dataTables_scrollBody');
				var hasScrollX = $scrollHead.length > 0 && $scrollBody.length > 0;
				
				var $tableContainer = $wrapper.closest('.table-responsive, .box-body, .col-xs-12, .col-12, .box').first();
				if(!$tableContainer.length) $tableContainer = $wrapper.parent();
				
				var stickyId = 'af-sticky-' + tableId.replace(/[^a-zA-Z0-9]/g, '-');
				var $sticky = $('<div class="af-sticky-header" data-table-id="' + tableId + '"></div>');
				$sticky.attr('id', stickyId);
				$('body').append($sticky);
				
				// Get DataTable API instance
				var dt = null;
				try {
					dt = new $.fn.dataTable.Api('#' + tableId);
				} catch(e) {
					// Table might not be fully initialized yet
				}
				
				var inst = {
					$wrapper: $wrapper,
					$table: $table,
					$sticky: $sticky,
					$container: $tableContainer,
					tableId: tableId,
					hasScrollX: hasScrollX,
					$scrollHead: hasScrollX ? $scrollHead : null,
					$scrollBody: hasScrollX ? $scrollBody : null,
					dt: dt
				};
				
				stickyInstances[tableId] = inst;

				function onScroll(){
					var $header = hasScrollX ? inst.$scrollHead : inst.$table.find('thead');
					if(!$header.length) return;
					
					var headRect = $header[0].getBoundingClientRect();
					var containerRect = inst.$container[0].getBoundingClientRect();
					if(!containerRect) return;
					var wrapBottom = containerRect.bottom;

					if(headRect.top < navH && wrapBottom > navH + 50){
						if(!inst.$sticky.is(':visible')){
							if(hasScrollX){
								buildCloneScrollX(inst);
							} else {
								buildCloneRegular(inst);
							}
						}
						positionSticky(inst);
						syncScroll(inst);
						inst.$sticky.show();
					} else {
						inst.$sticky.hide();
					}
				}

				if(hasScrollX){
					inst.$scrollBody.on('scroll', function(){ 
						if(inst.$sticky.is(':visible')) syncScroll(inst); 
					});
					inst.$sticky.on('scroll', function(){ 
						inst.$scrollBody.scrollLeft(inst.$sticky.scrollLeft()); 
					});
				}

				$(window).on('scroll.afSticky' + tableId, onScroll);
				if(inst.dt){
					inst.dt.on('draw', function(){
						inst.$sticky.hide();
					});
				}
			});

			// Also handle regular HTML tables (not DataTables) with thead
			$('table[id^="table_recordtbl"]').each(function(){
				var $table = $(this);
				var tableId = this.id;
				if(!tableId) return;
				
				// Skip if already processed or is master-alignment-map
				if(tableId === 'table_recordtbl_mam' || stickyInstances[tableId]) return;
				
				// Skip if it's a DataTable (already processed above)
				if($table.hasClass('dataTable')) return;
				
				// Only process tables with thead
				var $thead = $table.find('thead');
				if(!$thead.length) return;
				
				// Find the table container
				var $tableContainer = $table.closest('.table-responsive, .box-body, .col-xs-12, .col-12, .box').first();
				if(!$tableContainer.length) $tableContainer = $table.parent();
				
				// Create unique sticky header container
				var stickyId = 'af-sticky-' + tableId.replace(/[^a-zA-Z0-9]/g, '-');
				var $sticky = $('<div class="af-sticky-header" data-table-id="' + tableId + '"></div>');
				$sticky.attr('id', stickyId);
				$('body').append($sticky);
				
				var inst = {
					$wrapper: $table.parent(),
					$table: $table,
					$sticky: $sticky,
					$container: $tableContainer,
					tableId: tableId,
					hasScrollX: false,
					$scrollHead: null,
					$scrollBody: null,
					dt: null
				};
				
				stickyInstances[tableId] = inst;

				function onScroll(){
					var $header = inst.$table.find('thead');
					if(!$header.length) return;
					
					var headRect = $header[0].getBoundingClientRect();
					var containerRect = inst.$container[0].getBoundingClientRect();
					if(!containerRect) return;
					var wrapBottom = containerRect.bottom;

					if(headRect.top < navH && wrapBottom > navH + 50){
						if(!inst.$sticky.is(':visible')){
							buildCloneRegular(inst);
						}
						positionSticky(inst);
						inst.$sticky.show();
					} else {
						inst.$sticky.hide();
					}
				}

				// Bind scroll handler
				$(window).on('scroll.afSticky' + tableId, onScroll);
			});

			// Update on window resize
			$(window).on('resize.afSticky', function(){
				navH = $('.af-navbar').outerHeight() || 60;
				$.each(stickyInstances, function(id, inst){
					inst.$sticky.hide();
				});
			});
		}, 800);
	})();

	/* ============================================================
	   Modal Fix – move to <body>, center, close on backdrop/cross
	   ============================================================ */
	$('.wrapper .modal').appendTo('body');

	$('.modal').each(function(){
		this.setAttribute('data-bs-backdrop', 'true');
		this.removeAttribute('data-bs-keyboard');
	});

	$(document).on('click', '.modal [data-bs-dismiss="modal"], .modal .btn-close, .modal .close', function(e){
		e.preventDefault();
		var modalEl = $(this).closest('.modal')[0];
		if(modalEl){
			var inst = bootstrap.Modal.getInstance(modalEl);
			if(inst){ inst.hide(); }
		}
	});

	$(document).on('click', '.modal', function(e){
		if(e.target === this){
			var inst = bootstrap.Modal.getInstance(this);
			if(inst){ inst.hide(); }
		}
	});

	/* ---- Nested sub-dropdown (desktop hover) ---- */
	if (window.innerWidth >= 992) {
		document.querySelectorAll('.dropdown-submenu').forEach(function(el){
			el.addEventListener('mouseenter', function(){
				var sub = this.querySelector('.dropdown-menu');
				if(sub) sub.classList.add('show');
			});
			el.addEventListener('mouseleave', function(){
				var sub = this.querySelector('.dropdown-menu');
				if(sub) sub.classList.remove('show');
			});
		});
	}

	/* ---- Nested sub-dropdown (mobile click) ---- */
	document.querySelectorAll('.dropdown-submenu > .dropdown-item').forEach(function(el){
		el.addEventListener('click', function(e){
			if(window.innerWidth < 992){
				e.preventDefault();
				e.stopPropagation();
				var sub = this.nextElementSibling;
				if(sub) sub.classList.toggle('show');
			}
		});
	});
});
</script>
</body>
</html>
