<?php if(isset($data_type)&& $data_type=='1'){?>
 
			<option value="">-- select --</option>
			<?php foreach($master_survey_types as $survey_types){?>
				<option value="<?php echo $survey_types->id;?>" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==$survey_types->id){?> selected="selected" <?php }?>><?php echo $survey_types->name;?></option>
			<?php }?>
		 
	


<?php }else if(isset($data_type)&& $data_type=='2'){?>
	 
			<option value="">-- select --</option>					
			<?php $master_direct_assessment = get_master_direct_assessment_h(); 
			
				foreach($master_direct_assessment as $assessments){?>
					<option value="<?php echo $assessments->id;?>" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id==$assessments->id){?> selected="selected" <?php }?> > <?php echo $assessments->name; ?> </option>
				<?php }	?>
		 
	
	
<?php }else if(isset($data_type)&& $data_type=='3'){?>	
	 
			<option value="">-- select --</option>
			<option value="1" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id=='1'){?> selected="selected" <?php }?> >Pre-Post Test</option>
			<option value="2" <?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id=='2'){?> selected="selected" <?php }?>>One Time Test</option>
		 
<?php }?>