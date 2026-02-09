<div class="clearfix"></div>
  <style type="text/css">
 	.unit_analysis_page h4{ font-weight:600; font-size:16px; margin:5px 0;}
 </style>
 
 
<div class="box unit_analysis_page">
<div class="box-body">
<div class="nrow">
<div class="subcontent margin20">
	<div class="contenttitle2 nomargintop">
		<h3>Data Commons : : Edit</h3>
	</div>
	<div class="clearfix"></div>

	<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
	
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label" for="inputEmail3" ><h4>Title*</h4></label>
			<input class="form-control required" name="txt_title" id="txt_title" placeholder="Title" value="<?php if(isset($data_commons_details->title)&& $data_commons_details->title!=''){echo $data_commons_details->title;}?>" />
		</div>
	</div>
			
	<div class="col-md-4">
		<div class="form-group">
			<label class="control-label" for="inputEmail3" ><h4>Data Type*</h4></label>
			<select class="form-control required" name="data_type" id="data_type" onchange="return get_types(this.value);" >
				<option value="">-- select --</option>
				<option value="1" <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='1'){?> selected="selected" <?php }?> >Survey</option>
				<option value="2" <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='2'){?> selected="selected" <?php }?>>Assignment</option>
				<option value="3" <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='3'){?> selected="selected" <?php }?>>Test</option>
			</select>
		</div>
	</div>
	
 
	
	<div class="col-md-4"> 
		<div class="form-group" id="survey_type" style="display: <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='1'){ echo 'block';}else{ echo 'none';}?>;">
			<label class="control-label" for="inputEmail3" ><h4>Survey Type*</h4></label>
			<select class="form-control" name="survey_type" id="survey_type1">
				<option value="">-- select --</option>
				<?php foreach($master_survey_types as $survey_types){?>
					<option value="<?php echo $survey_types->id;?>" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==$survey_types->id){?> selected="selected" <?php }?>><?php echo $survey_types->name;?></option>
				<?php }?>
			</select>
		</div>

		<div class="form-group" id='assignment_type' style="display: <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='2'){ echo 'block';}else{ echo 'none';}?>;">
			<label class="control-label" for="inputEmail3" ><h4>Assignment Type*</h4></label>
			<select class="form-control" name="assignment_type" id="assignment_type1">
				<option value="">-- select --</option>					
				<?php $master_direct_assessment = get_master_direct_assessment_h(); 
				
					foreach($master_direct_assessment as $assessments){?>
						<option value="<?php echo $assessments->id;?>" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==$assessments->id){?> selected="selected" <?php }?>> <?php echo $assessments->name; ?> </option>
					<?php }	?>
			</select>
		</div>

		<div class="form-group" id='test_type' style="display: <?php if(isset($data_commons_details->data_type)&& $data_commons_details->data_type=='3'){ echo 'block';}else{ echo 'none';}?>;">
			<label class="control-label" for="inputEmail3" ><h4>Test Type*</h4></label>
			<select class="form-control" name="test_type" id="test_type1">
				<option value="">-- select --</option>
				<option value="1" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==1){?> selected="selected" <?php }?>>Pre-Post Test</option>
				<option value="2" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==2){?> selected="selected" <?php }?>>One Time Test</option>
			</select>
		</div>
	</div>
	
	<div class="col-md-4"> 
		<div class="form-group">
			<label class="control-label" for="inputEmail3" ><h4>Core Competency*</h4></label>
			<select class="form-control" name="core_competency" id="core_competency" >
				<option value="">-- select --</option>
				<?php foreach($core_competency_details as $core_competency){?>
					<option value="<?php echo $core_competency->id;?>" <?php if(isset($data_commons_details->core_competency)&& $data_commons_details->core_competency==$core_competency->id){?> selected="selected" <?php }?> ><?php echo $core_competency->name;?></option>
				<?php }?>
			</select>
		</div>	
	</div>	
		
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label" for="inputEmail3" ><h4>Descriptive Text*</h4></label>
			<textarea class="form-control required" rows="5" name="descriptive_text" id="descriptive_text" placeholder="Enter Descriptive text"><?php if(isset($data_commons_details->descriptive_text)&& $data_commons_details->descriptive_text!=''){echo $data_commons_details->descriptive_text;}?></textarea>
			<!--<textarea id="editor" name="overview"></textarea> -->
		</div>
	</div>
	
	
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label" for="inputEmail3" ><h4>Upload Data*</h4></label>
			<input type="file" onchange="readURL(this);" name="photo" id="userfile" /><br> 
						
			<?php if(isset($data_commons_details->upload_image)&&$data_commons_details->upload_image!=''){?>
				<img src="<?php echo base_url();?>assets/frontend/upload/Data_commons/upload_images/thumbnails/<?php echo $data_commons_details->upload_image; ?>" alt="" id="blah" class="img-responsive" />
			<?php }else{?>	
				<img src="" alt="" id="blah" class="img-responsive"/>
			<?php }?>	
		</div>		
	</div>		
	
	<div class="col-md-6">
		<div class="form-group">	
			<label class="control-label" for="inputEmail3" ><h4>Add Thumbnail*</h4></label>
			<input type="file" onchange="readURL1(this);" name="photo1" id="userfile" /><br>
			
			<?php if(isset($data_commons_details->add_thumbnail)&&$data_commons_details->add_thumbnail!=''){?>
				<img src="<?php echo base_url();?>assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/<?php echo $data_commons_details->add_thumbnail; ?>" alt="" id="blah1" class="img-responsive" />
			<?php }else{?>	
				<img src="" alt="" id="blah1" class="img-responsive"/>
			<?php }?>	
		</div>	
	</div>	
	
	<div class="col-md-12" >
		<div class="form-group">
			<button type="submit" class="btn btn-primary pull-right" name="submit_login">Save and Continue</button>
		</div>
	</div>

	</form>	

</div>	
	</div>

<div class="clearfix"></div>
</div>	
</div>


<script type="text/javascript">
function get_types(data_type){
	$.ajax({
		url: '<?php echo base_url(); ?>Data_commons/get_type_ajax?typ='+data_type,
		type: 'GET',
 		beforeSend: function(){
			$('#email_newsletter_error').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered"/>'); 
		},				
		success: function (result) { // alert(result);			
			if(data_type==1){
				$('#survey_type').show();
				$('#assignment_type').hide();
				$('#test_type').hide();
				$('#survey_type1').html(result);
				
				jQuery('#survey_type1').addClass('required');
				jQuery('#assignment_type1').removeClass('required');
				jQuery('#test_type1').removeClass('required');
			}else if(data_type==2){
				$('#survey_type').hide();
				$('#test_type').hide();
				$('#assignment_type').show();
				$('#assignment_type1').html(result);
				
				jQuery('#survey_type1').removeClass('required');
				jQuery('#assignment_type1').addClass('required');
				jQuery('#test_type1').removeClass('required');
			}else if(data_type==3){
				$('#survey_type').hide();
				$('#assignment_type').hide();
				$('#test_type').show();	
				$('#test_type1').html(result);
				
				jQuery('#survey_type1').removeClass('required');
				jQuery('#assignment_type1').removeClass('required');
				jQuery('#test_type1').addClass('required');
			}						
		}
	});
}

 
function readURL(input) { 
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('#blah')
                .attr('src', e.target.result);
                jQuery('#blah').show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL1(input) { 
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            jQuery('#blah1')
                .attr('src', e.target.result);
                jQuery('#blah1').show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>


