<div class="clearfix"></div> <!-- /.content -->
  </div>
  </div>  </div>
   <footer class="main-footer">
     
     <div class="pull-left ">
      Copyright &copy; <?php echo date('Y');?> <strong style="color:#303f59;"><?php echo $this->config->item('project_name_page_first'); ?></span> <?php echo $this->config->item('project_name_page_second'); ?>.</strong> All rights reserved.
	  </div>
     <!--<div class="pull-right " style="text-align:right;">
         <img src="<?php echo base_url();?>assets/backend/images/amee_big.png" alt=""  style="max-width:35%;" />
      </div>-->
	  <div style="clear:both;"></div>
    <!-- /.container -->
  </footer>
  
  
  
  </div>
  
  <!-- ./wrapper -->

<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 
<script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>-->
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/backend/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/backend/dist/js/demo.js"></script>
 
<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/jquery.fancybox-1.3.4.pack.js"></script>-->
<script>
$("#modal-container-666931").on('hidden.bs.modal', function(e){window.location.reload(); });
</script>

<script type="text/javascript">
function readURL(input){
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#blah')
				.attr('src', e.target.result) 
				$('#blah').show();
		};
		reader.readAsDataURL(input.files[0]);
	}
}

function readURL1(input){
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#blah1')
				.attr('src', e.target.result)
				$('#blah1').show();
		};
		reader.readAsDataURL(input.files[0]);
	}
}

$(document).ready(function() {
	$('#from_date').datepicker({
	 format: "mm/dd/yyyy",
	   autoclose: true,
		//todayHighlight: true
	});	
	
	$('#to_date').datepicker({
	 format: "mm/dd/yyyy",
	   autoclose: true,
		//todayHighlight: true
	});

$('#Date2').datepicker({
 format: "mm/dd/yyyy"
   // autoclose: true,
    //todayHighlight: true
});

$('#Date1').datepicker({
 format: "mm/dd/yyyy"
   // autoclose: true,
    //todayHighlight: true
});
 
// Reset the form
   $('#resetButton').on('click', function() {
    $("#frm")[0].reset(); })
});
</script>
<script type="text/javascript">  
  $(function () {
  
  $('#frm').validate(
	 {
	 	  ignore: [], 
		  highlight: function(element) {
		    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		  },
		  success: function(element) {
		    element.closest('.form-group').removeClass('has-error').addClass('has-success');
		    element.remove();
		  },rules: {
               new_password: {
                 required: true,
      
               } ,

                   confirm_password: {
                    equalTo: "#new_password",
               }


           }
	 }); 
	    
    $('#table_recordtbl').DataTable({
      "paging": true,
	  "pageLength": 25,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
	
  	if($('#editor').length > 0){
    	CKEDITOR.replace( 'editor',{height: '200px',}); 
	}
	
	$('.datepicker').datepicker( {autoclose: true, format: 'dd-mm-yyyy'} );
	 
  });
</script>        
  
</body>
</html>