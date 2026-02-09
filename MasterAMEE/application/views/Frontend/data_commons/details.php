<div class="box data_commons_details_page">
<div class="box-body">
  
<div class="card mb-3">
	<h3 class="card-title">
		<?php if(isset($data_commons_details->title)&& $data_commons_details->title!=''){echo $data_commons_details->title;}?>
	</h3>		
	<div class="card_type">
		 
		<span>
			<b>Type :</b>
			<?php if(isset($data_commons_details->type_id)&& $data_commons_details->type_id!=''){
				$types_id = $data_commons_details->type_id;
				echo $types_name = get_master_survey_types_name_by_id($types_id);
			}?>
			
		</span> 
		<?php if(isset($data_commons_details->core_competency) && $data_commons_details->core_competency!='' && $data_commons_details->core_competency!=0){?>
		&nbsp; | | &nbsp;
		<span>
			<b>Core Competency :</b>
			<?php 
				$core_competency_id = $data_commons_details->core_competency;
				echo $core_competency_title = get_core_competency_title_h($core_competency_id);
			?>
		</span>
		<?php } ?>
		
		<?php if(isset($data_commons_details->add_date)&& $data_commons_details->add_date!=''){?>
		&nbsp; | | &nbsp;
		<span>
			<b>Share Date : </b>
			<?php echo date('m/d/Y h:i A',$data_commons_details->add_date);?>
		</span>	
		<?php } ?>		
		
	</div>
	
	<?php if(isset($data_commons_details->upload_image)&& $data_commons_details->upload_image!=''){?>
				
		<img class="img-responsive" src="<?php echo base_url();?>assets/frontend/upload/Data_commons/upload_images/<?php echo $data_commons_details->upload_image; ?>" alt="<?php if(isset($data_commons_details->title)&& $data_commons_details->title!=''){echo $data_commons_details->title;}?>">
	
	<?php }?>
  
	<div class="card-block">
		<?php if(isset($data_commons_details->descriptive_text)&& $data_commons_details->descriptive_text!=''){echo $data_commons_details->descriptive_text;}?>
	</div>
	
</div>

 
</div>
</div> 


