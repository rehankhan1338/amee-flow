<script type="text/javascript">
jQuery(function () { 
	jQuery('#frm_pop').validate({
	  ignore: [], 
	  highlight: function(element) {
		jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
	  },
	  success: function(element) {
		element.closest('.form-group').removeClass('has-error').addClass('has-success');
		element.remove();
	  }
	});
});
</script>


<div class="modal" id="open_model_data_commons" tabindex="-1" role="dialog" ><!--class='fade'-->
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong id="result">Data Commons : : Add</strong>		
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>Data_commons/add" enctype="multipart/form-data">
			
			<div class="row">
			
   			<div class="col-md-12">
	   			<div class="form-group">
					<label class="nfw600">Title *</label>
					<input class="form-control required" name="txt_title" id="txt_title" placeholder="Title" />
				</div>	
			</div>	
			
			<div class="col-md-4">
	   			<div class="form-group">
					<label class="nfw600">Data Type *</label>
					<select class="form-control required" name="data_type" id="data_type" >
						<option value="">-- select --</option>
						<option value="1">Survey</option>
						<option value="2">Assignment</option>
						<option value="3">Test</option>
					</select>
				</div>	
			</div>	
								
			<div class="col-md-4">
	   			<div class="form-group" id="survey_type_show">
					<label class="nfw600">Survey Type</label>
					<select class="form-control" name="survey_type" id="survey_type">
						<option value="">-- select --</option>
						<?php foreach($master_survey_types as $survey_types){?>
							<option value="<?php echo $survey_types->id;?>"><?php echo $survey_types->name;?></option>
						<?php }?>
					</select>
				</div>	
				
				<div class="form-group" id="assignment_type_show">
					<label class="nfw600">Assignment Type</label>
					<select class="form-control" name="assignment_type" id="assignment_type">
						<option value="">-- select --</option>						
						
					<?php $master_direct_assessment = get_master_direct_assessment_h(); 
 						foreach($master_direct_assessment as $assessments){?>
 							<option value="<?php echo $assessments->id;?>"> <?php echo $assessments->name; ?> </option>
					<?php }	?>
					</select>
				</div>	
				
				<div class="form-group" id="test_type_show">
					<label class="nfw600">Test Type</label>
					<select class="form-control" name="test_type" id="test_type">
						<option value="">-- select --</option>
						<option value="1">Pre-Post Test</option>
						<option value="2">One Time Test</option>					
					</select>
				</div>
				
				<div class="form-group" id="type_show">
					<label class="nfw600"> Type</label>
					<select class="form-control" id="type">
						<option value="">-- select --</option>				
					</select>
				</div>		
			</div>				
			
			<div class="col-md-4">
	   			<div class="form-group">
					<label class="nfw600">Core Competency *</label>
					<select class="form-control" name="core_competency" id="core_competency" >
						<option value="">-- select --</option>
						<?php foreach($core_competency_details as $core_competency){?>
							<option value="<?php echo $core_competency->id;?>"><?php echo $core_competency->name;?></option>
						<?php }?>
					</select>
				</div>		
			</div>
														
			<div class="col-md-6">
	   			<div class="form-group">
					<label class="nfw600">Upload Data *</label>
					<input type="file" class="required" name="photo" id="photo"/>
				</div>	
			</div>
				
			<div class="col-md-6">
	   			<div class="form-group">
					<label class="nfw600">Add Thumbnail *</label>
					<input type="file" class="required" name="photo1" id="photo1"/>
				</div>	
			</div>	
			
			<div class="col-md-12">
				<div class="form-group">
					<label class="nfw600">Descriptive Text *</label>
 					<textarea class="form-control required" rows="5" name="descriptive_text" id="descriptive_text" placeholder="Enter Descriptive text"></textarea>
				</div>	
			</div>	
			
			</div>
			
 			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Share Now&nbsp;!'/>
			</div>
		</form>
 		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>
	
	
<script type="text/javascript">
jQuery(document).ready(function(){ 

jQuery('#survey_type_show').hide();
jQuery('#assignment_type_show').hide();
jQuery('#test_type_show').hide();
jQuery('#type').addClass('required');		

	  jQuery('#data_type').change(function(e){	  	
	  	var data_type = jQuery('#data_type').val();	  	
		  	if(data_type==1){
		  		jQuery('#survey_type_show').show();				
				jQuery('#assignment_type_show').hide();
		  		jQuery('#test_type_show').hide();				
		  		jQuery('#type_show').hide();	
		  		
		  		jQuery('#survey_type').addClass('required');
				jQuery('#assignment_type').removeClass('required');
				jQuery('#test_type').removeClass('required');
				jQuery('#type').removeClass('required');				  		
			
			}else if(data_type==2){
				jQuery('#survey_type_show').hide();
		  		jQuery('#assignment_type_show').show();
		  		jQuery('#test_type_show').hide();					
		  		jQuery('#type_show').hide();	
		  		
		  		jQuery('#survey_type').removeClass('required');
				jQuery('#assignment_type').addClass('required');
				jQuery('#test_type').removeClass('required');
				jQuery('#type').removeClass('required');	
								
			}else if(data_type==3){
				jQuery('#survey_type_show').hide();
		  		jQuery('#assignment_type_show').hide();
		  		jQuery('#test_type_show').show();			
		  		jQuery('#type_show').hide();	
		  		
		  		jQuery('#survey_type').removeClass('required');
				jQuery('#assignment_type').removeClass('required');
				jQuery('#test_type').addClass('required');
				jQuery('#type').removeClass('required');			
			}		
	  });
});
</script>	