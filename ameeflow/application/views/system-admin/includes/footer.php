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
	   Modal Fix – move to <body>, center, close on backdrop/cross
	   ============================================================ */
	/* Move every .modal out of .wrapper to <body> so they share the
	   root stacking context with .modal-backdrop (appended to body
	   by Bootstrap). This permanently fixes the "backdrop on top"
	   problem caused by AdminLTE's wrapper creating a stacking context. */
	$('.wrapper .modal').appendTo('body');

	/* Allow closing on backdrop click & Escape key.
	   Bootstrap 5 reads data-bs-* when the Modal is first constructed,
	   so we patch the attributes BEFORE any modal is ever shown. */
	$('.modal').each(function(){
		this.setAttribute('data-bs-backdrop', 'true');
		this.removeAttribute('data-bs-keyboard');   // default = true (Escape closes)
	});

	/* Ensure close buttons (cross) always work, even if Bootstrap
	   missed binding them after the DOM move. */
	$(document).on('click', '.modal [data-bs-dismiss="modal"], .modal .btn-close, .modal .close', function(e){
		e.preventDefault();
		var modalEl = $(this).closest('.modal')[0];
		if(modalEl){
			var inst = bootstrap.Modal.getInstance(modalEl);
			if(inst){ inst.hide(); }
		}
	});

	/* Close when clicking directly on the modal overlay (outside modal-dialog) */
	$(document).on('click', '.modal', function(e){
		if(e.target === this){                       // clicked the overlay itself, not a child
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

	/* ============================================================
	   Universal Sticky Table Headers for system-admin
	   ============================================================ */
	(function(){
		var navH = $('.af-navbar').outerHeight() || 60;
		var stickyHeaders = {}; // Store sticky header instances

		// Function to create sticky header for a DataTable
		function initStickyHeader(tableId, dtInstance){
			var $wrapper = $('#' + tableId + '_wrapper');
			if(!$wrapper.length) return;

			var $scrollHead = $wrapper.find('.dataTables_scrollHead');
			var $scrollBody = $wrapper.find('.dataTables_scrollBody');
			var $table = $wrapper.find('table').first();
			var hasScrollX = $scrollHead.length > 0;

			// Find the table container (could be in .table-responsive, .box-body, etc.)
			var $tableContainer = $table.closest('.table-responsive, .box-body, .col-xs-12, .col-12').first();
			if(!$tableContainer.length) $tableContainer = $wrapper;

			// Create unique sticky header ID
			var stickyId = 'af-sticky-header-' + tableId.replace(/[^a-zA-Z0-9]/g, '-');
			var $sticky = $('<div class="af-sticky-header" id="' + stickyId + '"></div>');
			$('body').append($sticky);

			function buildClone(){
				$sticky.empty();
				var $clone;

				if(hasScrollX){
					// For scrollX tables: clone the scrollHead contents
					$clone = $scrollHead.children().clone(false);
				} else {
					// For regular tables: clone the thead
					var $thead = $table.find('thead').first();
					if(!$thead.length) return;
					$clone = $('<div class="dataTables_scrollHeadInner"><table class="' + $table.attr('class') + '"><thead></thead></table></div>');
					$clone.find('thead').html($thead.html());
					$clone.find('table').css('width', $table.outerWidth());
				}

				$sticky.append($clone);

				// Copy computed widths for every <th>
				var $origThs = hasScrollX ? $scrollHead.find('th') : $table.find('thead th');
				var $cloneThs = $sticky.find('th');
				$origThs.each(function(i){
					if($cloneThs.eq(i).length){
						var w = $(this).outerWidth();
						$cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
					}
				});

				// Match inner wrapper + table widths for scrollX tables
				if(hasScrollX){
					var $origInner = $scrollHead.find('.dataTables_scrollHeadInner');
					var $cloneInner = $sticky.find('.dataTables_scrollHeadInner');
					if($origInner.length && $cloneInner.length){
						$cloneInner.css('width', $origInner[0].style.width || $origInner.outerWidth());
					}
					var $origTable = $scrollHead.find('table').first();
					var $cloneTable = $sticky.find('table').first();
					if($origTable.length && $cloneTable.length){
						$cloneTable.css('width', $origTable[0].style.width || $origTable.outerWidth());
					}
				}
			}

			function syncScroll(){
				if(hasScrollX && $scrollBody.length){
					$sticky.scrollLeft($scrollBody.scrollLeft());
				}
			}

			function positionSticky(){
				var el = $tableContainer[0];
				if(!el) return;
				var r = el.getBoundingClientRect();
				$sticky.css({ left: r.left, width: r.width });
			}

			function onScroll(){
				var headRect, wrapBottom;
				
				if(hasScrollX){
					headRect = $scrollHead[0].getBoundingClientRect();
				} else {
					var theadEl = $table.find('thead')[0];
					if(!theadEl) return;
					headRect = theadEl.getBoundingClientRect();
				}

				var wrapEl = $tableContainer[0];
				if(!wrapEl) return;
				wrapBottom = wrapEl.getBoundingClientRect().bottom;

				if(headRect.top < navH && wrapBottom > navH + 50){
					if(!$sticky.is(':visible')){
						buildClone();
					}
					positionSticky();
					syncScroll();
					$sticky.show();
				} else {
					$sticky.hide();
				}
			}

			// Sync horizontal scroll both ways (for scrollX tables)
			if(hasScrollX && $scrollBody.length){
				$scrollBody.on('scroll.' + tableId, function(){ 
					if($sticky.is(':visible')) syncScroll(); 
				});
				$sticky.on('scroll.' + tableId, function(){ 
					$scrollBody.scrollLeft($sticky.scrollLeft()); 
				});
			}

			// Store instance
			stickyHeaders[tableId] = {
				onScroll: onScroll,
				buildClone: buildClone,
				positionSticky: positionSticky,
				syncScroll: syncScroll,
				$sticky: $sticky
			};

			// Initial check
			setTimeout(onScroll, 100);
		}

		// Initialize sticky headers for all existing DataTables
		function initAllStickyHeaders(){
			$.fn.dataTable.tables({ visible: true, api: true }).each(function(){
				var dt = this;
				var tableId = dt.table().node().id;
				if(tableId && !stickyHeaders[tableId]){
					initStickyHeader(tableId, dt);
				}
			});
		}

		// Listen for window scroll
		var scrollTimer;
		$(window).on('scroll', function(){
			clearTimeout(scrollTimer);
			scrollTimer = setTimeout(function(){
				Object.keys(stickyHeaders).forEach(function(tableId){
					stickyHeaders[tableId].onScroll();
				});
			}, 10);
		});

		// Listen for window resize
		var resizeTimer;
		$(window).on('resize', function(){
			navH = $('.af-navbar').outerHeight() || 60;
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function(){
				Object.keys(stickyHeaders).forEach(function(tableId){
					var inst = stickyHeaders[tableId];
					inst.$sticky.hide();
					setTimeout(function(){ inst.onScroll(); }, 50);
				});
			}, 100);
		});

		// Listen for DataTable draw events (page change, sort, filter, etc.)
		$(document).on('draw.dt', function(e, settings){
			var tableId = settings.sTableId;
			if(stickyHeaders[tableId]){
				stickyHeaders[tableId].$sticky.hide();
				setTimeout(function(){ stickyHeaders[tableId].onScroll(); }, 50);
			}
		});

		// Initialize on page load
		setTimeout(initAllStickyHeaders, 500);

		// Also check periodically for new DataTables (in case they're initialized later)
		setInterval(function(){
			$.fn.dataTable.tables({ visible: true, api: true }).each(function(){
				var dt = this;
				var tableId = dt.table().node().id;
				if(tableId && !stickyHeaders[tableId]){
					initStickyHeader(tableId, dt);
				}
			});
		}, 2000);
	})();
});
</script>
</body>
</html>
