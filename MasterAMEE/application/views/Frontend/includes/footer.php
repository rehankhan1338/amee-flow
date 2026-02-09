</div>
<br clear="all" />
</div>
</div>
<?php 
include(APPPATH.'views/Frontend/popup_modal/notificationModel.php');
include(APPPATH.'views/Frontend/popup_modal/view.php'); ?>

<script type="text/javascript">  
  jQuery(function () {  
   
  jQuery('#frm').validate( {
	 	  ignore: [], 
		  highlight: function(element) {
		    jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
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

    jQuery('#table_recordtbl').DataTable({
      "paging": true,
	  "pageLength": 25,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
	
  	/*if($('#editor').length > 0){
    	CKEDITOR.replace( 'editor',{height: '200px',}); 
	}*/
  });
</script> 

<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>			
<script type="text/javascript">
    jQuery(function () {
        jQuery('#datetimepicker1').datetimepicker();
    });   
    
    jQuery(function () {
        jQuery('#datetimepicker2').datetimepicker();
    });    
    
    jQuery(function () {
        jQuery('#datetimepicker3').datetimepicker();
    });   
    
    jQuery(function () {
        jQuery('#datetimepicker4').datetimepicker();
    });
</script>
	
</body>

</html>