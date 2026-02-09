<?php include(APPPATH.'views/Frontend/coordinate/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<style type="text/css">
textarea{resize:none;}.error{ display:block !important;}
</style>
<br />
<script type="text/javascript">  
jQuery(function () {jQuery('#frm_grad').validate(
	 {
	 	  ignore: [], 
		  highlight: function(element) {
		    jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		  },
		  success: function(element) {
		    element.closest('.form-group').removeClass('has-error').addClass('has-success');
		    element.remove();
		  }
	 });}); 
</script>
	
<div class="box">
<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>department/coordinate/action2/import_data_review_courses/<?php echo $course_status;?>" enctype="multipart/form-data">      

	<div class="box-body"> 
		<div class="col-md-12">
			<div class="contenttitle2 nomargintop">
				<h3>Import <?php echo ucfirst($course_status);?> Courses</h3>
			</div>
		</div>
		
		<div class="col-md-12">
    
			<div style="background-color:#EAEAEA;padding:10px; font-size:17px;">If you already have courses details in .xls, .xlsx or .csv formats, then use below import tool to add data into the AMEE Software:</div>
			
			<div style="padding:15px;"><a href="<?php echo base_url();?>assets/upload/sample_files/<?php echo $course_status;?>_courses_sample.xlsx" class="abtn" >Download Template - click here</a></div>
			
			<div style="background-color:#EAEAEA;padding:10px;font-size:17px;"> <span style="color:#666666">Step 1 of 2 - Upload<br />
Before uploading the file ensure that all required fields are properly filled.</span></div>
			<!--<div style="padding:10px;">
			<input type="checkbox" name="with_header" id="with_header">   Do not import first/header row
			</div>-->
	
		   <div style="padding:15px;">
			   <table width="50%">
				   <tr height="40">
					   <td style="font-weight:600;">Upload File: </td>
					   <td><input type="file" name="file" id="file"  class="required" style="display:inline;"></td>
				   </tr>					
			   </table>
			 
		   </div>			  
 				    
	 </div>
		 
	</div>
	
	<div class="col-md-12">
		<input type="submit" name="submit" class="btn btn-primary" value="Import"  />
	</div>
	<div class="clearfix"></div>

</form>

</div> 
<div class="clearfix"></div><br />
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/coordinate/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/coordinate/action3" class="btn btn-info">Next Action3 >></a>
		 
	</div>
</div> 