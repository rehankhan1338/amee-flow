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
		function addNoDataMessage($tbody, colCount){
			if($tbody.find('.no-data-row').length > 0) return;
			var hasContent = false;
			$tbody.find('tr').each(function(){
				if($(this).is(':visible') && $(this).text().trim() !== ''){
					hasContent = true;
					return false;
				}
			});
			if(!hasContent && $tbody.find('tr').length === 0){
				var $noDataRow = $('<tr class="no-data-row"><td colspan="' + colCount + '" class="text-center py-5"><div class="no-data-message"><i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i><p style="font-size: 1.1rem; color: #999; margin: 0; font-weight: 500;">No data found</p></div></td></tr>');
				$tbody.append($noDataRow);
			}
		}
		setTimeout(function(){
			$('table tbody').each(function(){
				var $tbody = $(this);
				var $table = $tbody.closest('table');
				var colCount = $table.find('thead th').length || $table.find('thead tr:first td').length || $table.find('tbody tr:first td').length || 1;
				addNoDataMessage($tbody, colCount);
			});
		}, 100);
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
