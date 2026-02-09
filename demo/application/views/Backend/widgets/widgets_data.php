<form data-toggle="validator" class="" id="wid_<?php echo $widgets_data->widget_key;?>" method="post" action="<?php echo base_url();?>admin/widgets/widgets_data_save" enctype="multipart/form-data">
	
	<input type="hidden" name="hwidget_id" id="hwidget_id" value="<?php echo $widgets_data->id;?>" />
	<!--<input type="hidden" name="hwidget_key" id="hwidget_key" value="<?php echo $widgets_data->widget_key;?>" />
	<input type="hidden" name="his_widgets_meta" id="his_widgets_meta" value="<?php echo $widgets_data->is_widgets_meta;?>" />
	-->
	
<div class="col-md-4">
  <div class="box box-default box-solid collapsed-box">
	<div class="box-header with-border">
	  <h3 class="box-title"><?php echo $widgets_data->widget_title;?></h3>

	  <div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
		</button>
	  </div>
	  <!-- /.box-tools -->
	</div>
	<!-- /.box-header -->
	<div class="box-body" style="">
	  <?php if(isset($widgets_data->widget_title) && $widgets_data->is_widgets_meta==0){?>
	  	
		<div class="form-group" style="margin:0;"> 
		<textarea class="form-control required" id="widget_value_<?php echo $widgets_data->widget_key;?>" name="widget_value_<?php echo $widgets_data->widget_key;?>" rows="<?php echo $widgets_data->textarea_height;?>"><?php if(isset($widgets_data->content) && $widgets_data->content!=''){ echo $widgets_data->content;}?></textarea>
		</div>
		 
 	  <?php } else{ $widgetsmeta_list = get_widgetsmeta_fields_h($widgets_data->id); ?>
	  	
		<?php foreach ($widgetsmeta_list as $widgetsmeta_data) {?>
			
			<div class="form-group">
				<label><?php echo $widgetsmeta_data->meta_label;if($widgetsmeta_data->is_required==0){ echo '*';}?></label>
				
				<?php if($widgetsmeta_data->field_type==1){?>
				
					<input type="text" class="form-control <?php if($widgetsmeta_data->is_required==0){ echo 'required';}?>" id="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" name="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" placeholder="<?php echo $widgetsmeta_data->placeholder;?>" value="<?php echo $widgetsmeta_data->meta_value;?>"  >
				
				<?php }else if($widgetsmeta_data->field_type==2){ ?>
					
					<textarea class="form-control <?php if($widgetsmeta_data->is_required==0){ echo 'required';}?>" id="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" name="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" placeholder="<?php echo $widgetsmeta_data->placeholder;?>"><?php echo $widgetsmeta_data->meta_value;?></textarea>
					
				<?php }else if($widgetsmeta_data->field_type==4){
					
					echo '<br>';
					
					$widgetmeta_options_list = get_widgetmeta_options_h($widgetsmeta_data->id);
					
					foreach ($widgetmeta_options_list as $widgetmeta_options_data) { ?>
					
						<input type="radio" class="<?php if($widgetsmeta_data->is_required==0){ echo 'required';}?>" id="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" name="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" value="<?php echo $widgetmeta_options_data->id;?>" <?php if(isset($widgetsmeta_data->meta_value) && $widgetsmeta_data->meta_value==$widgetmeta_options_data->id){ ?> checked="checked" <?php } ?> /> <?php echo $widgetmeta_options_data->option_name;?> &nbsp;&nbsp;
						
					<?php } ?>
					
				<?php }else if($widgetsmeta_data->field_type==5){
					 
 					?>
					<select class="form-control <?php if($widgetsmeta_data->is_required==0){ echo 'required';}?>" id="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" name="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>"> 
					<option value="">--select--</option>
					
					<?php $widgetmeta_options_list = get_widgetmeta_options_h($widgetsmeta_data->id);
					
					foreach ($widgetmeta_options_list as $widgetmeta_options_data) { ?>
					 	
						<option value="<?php echo $widgetmeta_options_data->id;?>" <?php if(isset($widgetsmeta_data->meta_value) && $widgetsmeta_data->meta_value==$widgetmeta_options_data->id){ ?> selected="selected" <?php } ?> ><?php echo $widgetmeta_options_data->option_name;?></option>
						
					<?php } ?>
					
					</select>
					
				<?php }else if($widgetsmeta_data->field_type==6){ ?>
				
					<input type="file" id="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" name="<?php echo $widgetsmeta_data->meta_key.$widgets_data->id;?>" class="<?php if($widgetsmeta_data->is_required==0){ echo 'required';}?>" onchange="readURL(this);" />
					 
  					<img style="margin-top:10px;" src="<?php if(isset($widgetsmeta_data->meta_value) && $widgetsmeta_data->meta_value!=''){  echo base_url().'assets/upload/'.$widgetsmeta_data->meta_value; } ?>" id="blah" alt="" class="img-responsive" />
						 
				<?php } ?>
			 </div>
			  
		<?php } ?>
		 
	  <?php } ?>
	</div>
	
	<div class="box-footer">
		<input class="btn btn-primary" type="submit" style="width:100%;" name="<?php echo $widgets_data->widget_key;?>" value="Save" />
	</div>
	<!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
</form>