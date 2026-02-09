 <!-- /.content -->
  </div>
  
   <footer class="main-footer">
    <!--<div class="pull-right hidden-xs">
      <b>Version</b> 2.3.2
    </div>-->
    <strong>Copyright &copy; <?php echo date('Y');?> <a href="<?php echo base_url();?>"><?php echo $this->config->item('project_name_page_first').' '.$this->config->item('project_name_page_second');?></a>, All rights reserved.
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

 <script type="text/javascript" src="<?php echo base_url();?>assets/tinymce/tiny_mce.js"></script>

<script type="text/javascript">

       tinyMCE.init({
               // General options
               mode : "textareas",
               editor_selector : "mceEditor",
               theme : "advanced",
               plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

               // Theme options
               theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
               theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|undo,redo,|link,unlink,anchor,image,cleanup,|insertdate,inserttime,preview,|,forecolor,backcolor,|,code",
               theme_advanced_buttons3 : "",
               theme_advanced_buttons4 : "",
               theme_advanced_toolbar_location : "top",
               theme_advanced_toolbar_align : "left",
               theme_advanced_statusbar_location : "bottom",
               theme_advanced_resizing : true,

               // Example content CSS (should be your site CSS)
               content_css : "css/content.css",

               // Drop lists for link/image/media/template dialogs
               template_external_list_url : "lists/template_list.js",
               external_link_list_url : "lists/link_list.js",
               external_image_list_url : "lists/image_list.js",
               media_external_list_url : "lists/media_list.js",

               // Style formats
               style_formats : [
                       {title : 'Bold text', inline : 'b'},
                       {title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
                       {title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
                       {title : 'Example 1', inline : 'span', classes : 'example1'},
                       {title : 'Example 2', inline : 'span', classes : 'example2'},
                       {title : 'Table styles'},
                       {title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
               ],

               // Replace values for the template plugin
               template_replace_values : {
                       username : "Some User",
                       staffid : "991234"
               }
       });
</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/jquery.fancybox-1.3.4.pack.js"></script>
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
			$('#blah')
				.attr('src', e.target.result) 
				$('#blah').show();
				$('#blah1').hide();
		};
		reader.readAsDataURL(input.files[0]);
	}
}




$(document).ready(function() {
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
	 
	 $(".fancybox").fancybox({
	'width' : '90%',
	'height' : '95%',
	'autoScale' : false,
	'transitionIn' : 'elastic',
	'transitionOut' : 'elastic',
	'type' : 'iframe'/*,
	'onClosed': function() {
	parent.location.reload(true);
	}*/
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