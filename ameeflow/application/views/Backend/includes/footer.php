</div>
<footer class="main-footer">
	Copyright &copy; 2010 &ndash; <?php echo date('Y');?> <i><?php echo $this->config->item('product_name');?></i>, All rights reserved.
</footer>
</div>
<script src="<?php echo base_url(); ?>assets/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/backend/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="<?php //echo base_url(); ?>assets/backend/dist/js/demo.js"></script> -->
<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-datepicker.js" type="text/javascript"></script>
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
      "autoWidth": true
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
});
</script>  
</body>
</html>