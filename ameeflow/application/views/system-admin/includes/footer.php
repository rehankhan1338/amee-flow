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
	   Universal Sticky Header for all DataTables with scrollX
	   ============================================================ */
	(function initStickyHeaders(){
		// Helper functions
		function buildClone(inst){
			inst.$sticky.empty();
			var $clone = inst.$scrollHead.children().clone(false);
			inst.$sticky.append($clone);

			// Copy computed widths for every <th>
			var $origThs = inst.$scrollHead.find('th');
			var $cloneThs = inst.$sticky.find('th');
			$origThs.each(function(i){
				var w = $(this).outerWidth();
				$cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
			});

			// Match inner wrapper + table widths
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

		function syncScroll(inst){
			inst.$sticky.scrollLeft(inst.$scrollBody.scrollLeft());
		}

		function positionSticky(inst){
			var el = inst.$container[0];
			if(!el) return;
			var r = el.getBoundingClientRect();
			inst.$sticky.css({ left: r.left, width: r.width });
		}

		// Wait a bit for all DataTables to initialize
		setTimeout(function(){
			var navH = $('.af-navbar').outerHeight() || 60;
			var stickyInstances = {};

			// Find all DataTable wrappers with scrollX enabled
			$('[id$="_wrapper"]').each(function(){
				var $wrapper = $(this);
				var wrapperId = this.id;
				var tableId = wrapperId.replace('_wrapper', '');
				
				// Skip master-alignment-map table (has its own implementation)
				if(tableId === 'table_recordtbl_mam') return;
				
				var $scrollHead = $wrapper.find('.dataTables_scrollHead');
				var $scrollBody = $wrapper.find('.dataTables_scrollBody');
				
				// Only process tables with scrollX enabled (have scrollHead)
				if(!$scrollHead.length || !$scrollBody.length) return;
				
				// Get the DataTable instance
				var dt = $.fn.dataTable.Api ? new $.fn.dataTable.Api('#' + tableId) : null;
				if(!dt || !dt.settings || !dt.settings().length) return;
				
				// Find the table container (look for closest .table-responsive or .box-body or parent)
				var $tableContainer = $wrapper.closest('.table-responsive, .box-body, .col-xs-12, .col-12').first();
				if(!$tableContainer.length) $tableContainer = $wrapper.parent();
				
				// Create unique sticky header container
				var stickyId = 'af-sticky-' + tableId.replace(/[^a-zA-Z0-9]/g, '-');
				var $sticky = $('<div class="af-sticky-header" data-table-id="' + tableId + '"></div>');
				$sticky.attr('id', stickyId);
				$('body').append($sticky);
				
				var inst = {
					$wrapper: $wrapper,
					$scrollHead: $scrollHead,
					$scrollBody: $scrollBody,
					$sticky: $sticky,
					$container: $tableContainer,
					tableId: tableId
				};
				
				stickyInstances[tableId] = inst;

				function onScroll(){
					var headRect = inst.$scrollHead[0].getBoundingClientRect();
					var containerRect = inst.$container[0].getBoundingClientRect();
					if(!containerRect) return;
					var wrapBottom = containerRect.bottom;

					if(headRect.top < navH && wrapBottom > navH + 50){
						if(!inst.$sticky.is(':visible')){
							buildClone(inst);
						}
						positionSticky(inst);
						syncScroll(inst);
						inst.$sticky.show();
					} else {
						inst.$sticky.hide();
					}
				}

				// Sync horizontal scroll both ways
				inst.$scrollBody.on('scroll', function(){ 
					if(inst.$sticky.is(':visible')) syncScroll(inst); 
				});
				inst.$sticky.on('scroll', function(){ 
					inst.$scrollBody.scrollLeft(inst.$sticky.scrollLeft()); 
				});

				// Bind scroll handler
				$(window).on('scroll.afSticky' + tableId, onScroll);
				
				// Rebuild on DataTable draw
				dt.on('draw', function(){
					inst.$sticky.hide();
				});
			});

			// Update on window resize
			$(window).on('resize.afSticky', function(){
				navH = $('.af-navbar').outerHeight() || 60;
				$.each(stickyInstances, function(id, inst){
					inst.$sticky.hide();
				});
			});
		}, 500);
	})();

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
});
</script>
</body>
</html>
