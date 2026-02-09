<div class="subcontent margin20">	
<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/save_instructions<?php if(isset($assignments_rubrics_row->id) && $assignments_rubrics_row->id!=''){ echo '?ar_id='.$assignments_rubrics_row->id;}?>" enctype="multipart/form-data">
<div class="contenttitle2 nomargintop">
	<h3> Prepare Instructions  </h3>
</div>
<div class="pull-right">

	<button type="submit" class="btn btn-primary" style="padding:3px 10px; font-size:15px;" name="submit_login"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save and update Instruction</button>
	
	<a class="btn btn-default" onclick="return open_model_upload_instruction_add();" style="padding:3px 10px; font-size:15px;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Instruction Documents</a>			
</div>
<!--<div class="col-md-12 instructions">
<strong>Instructions:</strong> List the core functions for this unit. For each, identify the college's strategic priority and/or college-wide student learning outcome that it supports.https://github.com/swooningfish/ffmpeg-web-gui/blob/master/upload-and-convert.php
</div>-->
<style type="text/css">
iframe{border:1px solid #ccc; padding:3px;}
.upload_inst{ margin:20px 0;}
.image_data img{border:1px solid #ccc; padding:3px; }
.youtube_video_data h4{margin-bottom:5px;}
.m0p0{margin:0; padding:0;}
</style>			
<div class="clearfix"></div>		 
<div class="col-md-12">
	<div class="row">
		<textarea id="editor1" name="txt_instructions"><?php echo $assignments_rubrics_row->instructions;?></textarea>
	</div>
</div>
<div class="clearfix"></div>
<div class="row upload_inst">
<script type="text/javascript">
function delete_document(id,upload_type,dept_id,ar_id){
var result = confirm("Are You Sure u want to delete this document?");
	if(result){
		window.location='<?php echo base_url();?>assignments_rubrics/delete_prepare_document?id='+id+'&upload_type='+upload_type+'&dept_id='+dept_id+'&ar_id='+ar_id;
	}
}
</script>
<?php $assingment_image = get_assingment_documents_h($assignments_rubrics_row->id,'image'); 
if(count($assingment_image)>0){?>
<div class="col-md-9 m0p0">
<div class="contenttitle2" style="margin-top: 0">
<h3>Image Files</h3>
</div>
<div class="col-md-12 m0p0">
		<?php foreach($assingment_image as $image_data){?>
		<div class="col-md-3 image_data" style="margin:5px 0;">
			<h4 style="margin-bottom:10px;"><?php echo $image_data->document_title;?> <i style="margin-left:10px; color:#FF0000; cursor:pointer;" class="fa fa-trash" onclick="return delete_document('<?php echo $image_data->id;?>','<?php echo $image_data->upload_type;?>','<?php echo $image_data->department_id;?>','<?php echo $image_data->assignment_id;?>');"></i></h4>
			<img src="<?php echo base_url();?>assets/upload/assignment/thumbnails/<?php echo $image_data->file_name;?>" class="img-responsive" alt="<?php echo $image_data->document_title;?>" />
		</div>
	<?php }  ?>
</div>
</div>
<?php }  ?>

<?php $assingment_documents = get_assingment_documents_h($assignments_rubrics_row->id,'document');
 if(count($assingment_documents)>0){?>
	<div class="col-md-3 m0p0" >
	 <!--filemgr_left -->
		<div class="filemgr_right">
			<div class="filemgr_rightinner">
				<div class="contenttitle2" style="margin-top: 0">
					<h3>Document Files</h3>
				</div><!--contenttitle-->
				<ul class="menuright">
					<?php foreach($assingment_documents as $document_data){?>
					<li><a href="<?php echo base_url();?>assets/upload/assignment/<?php echo $document_data->file_name;?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $document_data->document_title;?></a> <i style="margin-left:10px; color:#FF0000; cursor:pointer;" class="fa fa-trash" onclick="return delete_document('<?php echo $document_data->id;?>','<?php echo $document_data->upload_type;?>','<?php echo $document_data->department_id;?>','<?php echo $document_data->assignment_id;?>');"></i></li>
					<?php } ?>
				</ul>
			</div><!-- filemgr_rightinner -->
		</div><!-- filemgr_right -->
		<br clear="all">
	</div> 
<?php } ?>

</div>	

<div class="row upload_inst">

<?php $assingment_youtube_video = get_assingment_documents_h($assignments_rubrics_row->id,'youtube_video_link');
if(count($assingment_youtube_video)>0){?>
		
<div class="col-md-9 m0p0">
	<div class="contenttitle2" style="margin-top: 0">
		<h3>Video Files</h3>
	</div>
	<div class="clearfix"></div>
	<?php foreach($assingment_youtube_video as $youtube_video_data){?>
	<div class="col-md-4 youtube_video_data">
		<h4 style="margin-bottom:10px;"><?php echo $youtube_video_data->document_title;?> <i style="margin-left:10px; color:#FF0000; cursor:pointer;" class="fa fa-trash" onclick="return delete_document('<?php echo $youtube_video_data->id;?>','<?php echo $youtube_video_data->upload_type;?>','<?php echo $youtube_video_data->department_id;?>','<?php echo $youtube_video_data->assignment_id;?>');"></i></h4>
		<?php 
		
		if(isset($youtube_video_data->file_name) && $youtube_video_data->file_name!=''){
				$video_link_path = $youtube_video_data->file_name;
				if(strpos($video_link_path, 'youtu') !== false){
				
				if(strpos($video_link_path, '?v=') !== false){
					
					$video_link_path_arr = explode('?v=',$video_link_path);
					if(strpos($video_link_path_arr[1], '&') !== false){
						$video_link_path_arr1 = explode('&',$video_link_path_arr[1]);
						$vedio_short_name=$video_link_path_arr1[0];
					}else{
						$vedio_short_name=$video_link_path_arr[1];
					}
					
				}else{
					
					if(strpos($video_link_path, 'embed/') !== false){
						$video_link_path_arr = explode('embed/',$video_link_path);
						if(strpos($video_link_path_arr[1], '/') !== false){
							$video_link_path_arr1 = explode('/',$video_link_path_arr[1]);
							$vedio_short_name=$video_link_path_arr1[0];
						}else{
							$vedio_short_name=$video_link_path_arr[1];
						}
					}else{
						$video_link_path_arr = explode('.be/',$video_link_path);
						$vedio_short_name=$video_link_path_arr[1];
					}
					
				}
				if(isset($vedio_short_name) && $vedio_short_name!=''){
				?><iframe width="100%"  src="<?php echo 'https://www.youtube.com/embed/'.$vedio_short_name;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><?php
			} }
			}
		?>
			 
	</div>
<?php } ?>
</div>
<?php } ?>

<?php $assingment_audio = get_assingment_documents_h($assignments_rubrics_row->id,'audio');
 if(count($assingment_audio)>0){?>
	<div class="col-md-3 m0p0" >
	 <!--filemgr_left -->
		<div class="filemgr_right">
			<div class="filemgr_rightinner">
				<div class="contenttitle2" style="margin-top: 0">
					<h3>Audio Files</h3>
				</div><!--contenttitle-->
				<ul class="menuright">
					<?php foreach($assingment_audio as $audio_data){?>
					<li>
						<h4 style="margin-bottom:10px;"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  <?php echo $audio_data->document_title;?>  <i style="margin-left:10px; color:#FF0000; cursor:pointer;" class="fa fa-trash" onclick="return delete_document('<?php echo $audio_data->id;?>','<?php echo $audio_data->upload_type;?>','<?php echo $audio_data->department_id;?>','<?php echo $audio_data->assignment_id;?>');"></i></h4>
						<audio controls>
						  <source src="<?php echo base_url();?>assets/upload/assignment/<?php echo $audio_data->file_name;?>" type="audio/<?php echo $audio_data->file_type;?>">
						</audio> 
					</li>
					<?php } ?>
				</ul>
			</div><!-- filemgr_rightinner -->
		</div><!-- filemgr_right -->
		<br clear="all">
	</div> 
<?php } ?>

</div>
	
</form>
</div>
		
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
function open_model_upload_instruction_add(){
 	jQuery("#open_model_upload_instruction_add").modal('show');
}
function fun_upload_instruction(upload_type){
	if(upload_type=='youtube_video_link'){
		jQuery('#d_browse').hide();
		jQuery('#upload_inst').removeClass(" required ");
		jQuery('#d_youtube_link').show();
		jQuery('#txt_youtube_link').addClass(" required ");
	}else{
 		jQuery('#d_youtube_link').hide();
		jQuery('#txt_youtube_link').removeClass(" required ");
		jQuery('#d_browse').show();
		jQuery('#upload_inst').addClass(" required ");
	}
}
</script>		
<div class="modal fade" id="open_model_upload_instruction_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Upload Instruction</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>assignments_rubrics/document_save" enctype="multipart/form-data">
			<input type="hidden" name="h_assignment_id" id="h_assignment_id" value="<?php echo $assignments_rubrics_row->id;?>" />
			
			<div class="form-group">
				<label style="margin-bottom:5px;">Document Title*</label>
				<input type="text" class="form-control required" name="document_title" id="document_title" value="" placeholder="Document Title" />
			</div>	
			
			<div class="form-group">
				<label style="margin-bottom:5px;">Upload Type*</label>
				<select class="form-control required" name="upload_instruction_type" id="upload_instruction_type" onchange="return fun_upload_instruction(this.value);">
					<option value="">--select--</option>
					<option value="document">Document</option>
					<option value="image">Image</option>
					<option value="audio">Audio</option>
					<!--<option value="video">Video</option>-->
					<option value="youtube_video_link">Video Link</option>					
				</select>
			</div>
			
			<div class="form-group" id="d_browse" style="display:none;">
				<input type="file" class="required" name="upload_inst" id="upload_inst" />
			</div>
			
			<div class="form-group" id="d_youtube_link" style="display:none;">
				<label style="margin-bottom:5px;">Video Link*</label>
				<input type="text" class="form-control" name="txt_youtube_link" id="txt_youtube_link" value="" placeholder="https://www.youtube.com/watch?v=UFuyjjYAz_U" />
			</div>	
			
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
			
		</form>
		
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>