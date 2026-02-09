<?php
include("assets/fckeditor/fckeditor.php") ;
?>
<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >

 <form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
 
  <!-- general form elements -->
	<div class="box">
	<div class="box-body">
		
		<div class="col-md-6">
		
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Title*</label>
				<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php if(isset($page_content->title) && $page_content->title!=''){echo $page_content->title;}?>"  >
			</div>	
		
		</div>
		
		<?php if($page_content->is_subtitle==1){ ?>
		
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="inputEmail3" >Sub-Title*</label>
					<input type="text" class="form-control" id="txt_subtitle" name="txt_subtitle" placeholder="Subtitle" value="<?php if(isset($page_content->subtitle) && $page_content->subtitle!=''){echo $page_content->subtitle;}?>"  >
				</div>	
			</div>
		
		<?php }else{ ?>
		
			<input type="hidden" name="txt_subtitle" id="txt_subtitle" value="<?php if(isset($page_content->subtitle) && $page_content->subtitle!=''){echo $page_content->subtitle;}?>" />
		<?php } ?>
		
		<div class="clearfix"></div>
		 <div class="col-md-12">	
		<div class="form-group">
			<label class="control-label" for="inputEmail3">Content*</label>
			<?php		
				if(isset($page_content->title) && $page_content->title!=''){$content=$page_content->content;}else{$content='';}
				$oFCKeditor = new FCKeditor('txt_content') ;
				$oFCKeditor->BasePath 	=  base_url().'assets/fckeditor/' ;
				$oFCKeditor->Width		= '100%' ;
				$oFCKeditor->Height		= '375' ;
				$oFCKeditor->Value 		= $content;
				$oFCKeditor->ToolbarSet	= 'Default' ;
				$oFCKeditor->Create() ;		
					
			?><!--<textarea class="form-control" id="editor1" name="special_test" placeholder="Special Section Text"></textarea>-->
		</div>
	</div>
		  
	<div class="clearfix"></div>
	
	<div class="col-md-6">
		
		<div class="form-group">
			<label class="control-label" for="inputEmail3">Featured Image</label>
			<input type="file" class="required" id="txt_title" name="txt_title" />
		</div>	
	
	</div>
	
	 
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

	</div> 
	
		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	</div>
	
	</form>
<!--/.col (left) -->
<!-- right column -->

</div>
<!--/.col (right) -->
</div>
      <!-- /.row -->
</section>