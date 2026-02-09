<section class="content">
<div class="row">
<div class="col-md-12">
<form class="" id="frm" method="post" action="" enctype="multipart/form-data"> 
<div class="box">
	<div class="box-body">		
		<div class="col-md-12">
		
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Title *</label>
				<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php if(isset($page_content->title) && $page_content->title!=''){echo $page_content->title;}?>"  >
			</div>	
		
		</div>
		
		<?php if($page_content->is_subtitle==1){ ?>
		
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label" for="inputEmail3" >Sub-Title *</label>
					<input type="text" class="form-control" id="txt_subtitle" name="txt_subtitle" placeholder="Sub-title" value="<?php if(isset($page_content->subtitle) && $page_content->subtitle!=''){echo $page_content->subtitle;}?>"  >
				</div>	
			</div>
		
		<?php }else{ ?>
		
			<input type="hidden" name="txt_subtitle" id="txt_subtitle" value="<?php if(isset($page_content->subtitle) && $page_content->subtitle!=''){echo $page_content->subtitle;}?>" />
		<?php } ?>
		
		<div class="clearfix"></div>
		 <div class="col-md-12">	
		<div class="form-group">
			<label class="control-label" for="inputEmail3">Content *</label>
			<?php		
				if(isset($page_content->title) && $page_content->title!=''){$content=$page_content->content;}else{$content='';}
			?>
			<textarea class="form-control" id="editor" name="txt_content" placeholder="Special Section Text"><?php echo $content;?></textarea>
		</div>
	</div>
		  
	<div class="clearfix"></div>
	
	<?php $custom_fields = get_cmsmeta_fields_h($page_content->id); ?>
 	
	<?php if(count($custom_fields)>0){?>
		
		<?php foreach ($custom_fields as $field_data) { ?>
		
			<div class="col-md-6">
			
				<div class="form-group">
					<label class="control-label" for="inputEmail3"><?php echo $field_data->meta_label;?><?php if($field_data->is_required==0){echo '*';}?></label>
					<input type="text" class="form-control <?php if($field_data->is_required==0){ echo 'required';}?>" id="<?php echo $field_data->meta_key;?>" name="<?php echo $field_data->meta_key;?>" placeholder="<?php echo $field_data->placeholder;?>" value="<?php if(isset($field_data->meta_value) && $field_data->meta_value!=''){echo $field_data->meta_value;}?>"  >
				</div>	
			
			</div>
		
		<?php } ?>
	
	<?php } ?>	
	
	<?php if($page_content->is_meta_tags==1){ ?>
	
		<div class="col-md-6">
			
			<div class="form-group">
				<label class="control-label" for="inputEmail3"><?php echo $field_data->meta_label;?><?php if($field_data->is_required==0){echo '*';}?></label>
				<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php if(isset($page_content->title) && $page_content->title!=''){echo $page_content->title;}?>"  />
			</div>	
		
		</div>
	
	<?php } ?>
	
	<?php if($page_content->is_featured_image==1){ ?>
	<div class="col-md-6">		
		<div class="form-group">
			<label class="control-label" for="upDoc">Featured Image</label>
			<input type="file" onchange="readURL(this);" id="upDoc" name="upDoc" />
			<input type="hidden" name="old_upload_doc" id="old_upload_doc" value="<?php if(isset($page_content->image) && $page_content->image!=''){echo $page_content->image;}?>" />
		</div>
		<div class="form-group">
			<img id="blah" src="<?php if(isset($page_content->image) && $page_content->image!=''){echo base_url().'assets/upload/logo/'.$page_content->image;}else{echo '#';}?>" alt="" style=" max-width:100%; float:left; max-height:100%; margin:auto; display:block;" />
		</div>	
	</div>
	<?php } ?>

	</div> 
	
	<div class="box-footer">
		<button class="btn btn-primary" type="submit" style="padding:4px 30px">Save &amp; Update</button>
	</div>
	
</div>	
</form>
<script type="text/javascript">
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#blah').attr('src', e.target.result);
			$('#blah').show();
		};
		reader.readAsDataURL(input.files[0]);
	}
}
</script>
</div>
</div>
</section>