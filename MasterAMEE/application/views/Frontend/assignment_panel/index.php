<div class="col-md-12">	
<div class="welcome_div">
<style>.alert{ padding:10px 15px; font-weight:600;}</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/html5gallery.js"></script>
	<?php if(isset($assingment_detail->instructions) && $assingment_detail->instructions==0){?>
		<h1 class="title">Please read instructions below or Download the file(s) to the right to review assessment instructions or assessment task.</h1> 
		<?php echo $assingment_detail->instructions; ?>
	<?php } ?>
	
	<?php if(isset($assingment_detail->assignment_code) && $assingment_detail->assignment_code!=''){
		$assignment_code = $assingment_detail->assignment_code;
	?>
<div class="row">	
<div class="col-md-6">
 <div style="display:block;margin:0 auto; float:left;" class="html5gallery1" data-skin="light" data-width="400" data-height="272" data-resizemode="fill">
	
 <?php $assingment_image = get_assingment_documents_h($assingment_detail->id,'image'); 
if(count($assingment_image)>0){?>
<?php foreach($assingment_image as $image_data){?>

		<a href="<?php echo base_url();?>assets/upload/assignment/thumbnails/<?php echo $image_data->file_name;?>"><img src="<?php echo base_url();?>assets/upload/assignment/thumbnails/<?php echo $image_data->file_name;?>" alt="<?php echo $image_data->document_title;?>"></a>
	<?php }  ?> 
<?php }  ?>
		
		<?php $assingment_youtube_video = get_assingment_documents_h($assingment_detail->id,'youtube_video_link');
if(count($assingment_youtube_video)>0){?>
		
 
	<?php foreach($assingment_youtube_video as $youtube_video_data){?>
	<div class="col-md-12 image_data youtube_video_data" style="margin:5px 0;">
		<h4 style="margin-bottom:10px;"><?php echo $youtube_video_data->document_title;?></h4>
		<?php if(isset($youtube_video_data->file_name) && $youtube_video_data->file_name!=''){
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
 
<?php } ?> 	
	
	</div> 
	
	</div> 
	
	 <div class="col-md-6" style="float:right">
	 <div class="col-md-12">
		<?php $assingment_documents = get_assingment_documents_h($assingment_detail->id,'document');
 if(count($assingment_documents)>0){?>
	<div class="col-md-12 m0p0" >
	 <!--filemgr_left -->
		<div class="filemgr_right">
			<div class="filemgr_rightinner">
				<div class="contenttitle2" style="margin-top: 0">
					<h4>Document</h4>
				</div><!--contenttitle-->
				<ul class="menuright" style="margin-left:10px;">
					<?php foreach($assingment_documents as $document_data){?>
					<li><a href="<?php echo base_url();?>assets/upload/assignment/<?php echo $document_data->file_name;?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $document_data->document_title;?></a></li>
					<?php } ?>
				</ul>
			</div><!-- filemgr_rightinner -->
		</div><!-- filemgr_right -->
		<br clear="all">
	</div> 
<?php } ?>
	</div>
	
	<div class="col-md-12">
		<?php $assingment_audio = get_assingment_documents_h($assingment_detail->id,'audio');
 if(count($assingment_audio)>0){?>
	<div class="col-md-12 m0p0" >
	 <!--filemgr_left -->
		<div class="filemgr_right">
			<div class="filemgr_rightinner">
			  	<ul class="menuright" style="margin-left:10px;">
					<?php foreach($assingment_audio as $audio_data){?>
					<li>
						<h4 style="margin-bottom:10px;"><i class="fa fa-angle-double-right" aria-hidden="true"></i>  <?php echo $audio_data->document_title;?></h4>
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
	 
	 </div>
 </div>
 	 	
   <form  id="startAssignFrm" method="post" action="assignment/startAssignmentEntry<?php if(isset($_GET['previewSts']) && $_GET['previewSts']==1){echo '?previewSts=1';}?>">
    
   
   		<input type="hidden" name="h_ajax_base_url" id="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url');?>" />
		<input type="hidden" name="h_base_url" id="h_base_url" value="<?php echo base_url();?>" /> 
		
		<input type="hidden" name="h_anonymousAssignment" id="h_anonymousAssignment" value="<?php echo $assingment_detail->anonymousAssignment;?>" />
		<input type="hidden" id="h_assignment_code" name="h_assignment_code" value="<?php if(isset($assingment_detail->assignment_code) && $assingment_detail->assignment_code!=''){echo $assingment_detail->assignment_code;}?>" />
		<input type="hidden" id="h_assignment_id" name="h_assignment_id" value="<?php if(isset($assingment_detail->id) && $assingment_detail->id!=''){echo $assingment_detail->id;}?>" />
		<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($assingment_detail->department_id) && $assingment_detail->department_id!=''){echo $assingment_detail->department_id;}?>" />
		
	<?php if($assingment_detail->anonymousAssignment==1){?>	
	
		<div class="form-group">
			<label class="control-label">First Name *</label>
			<div class=""><input type="text" class="form-control required" name="txt_first_name" id="txt_first_name" value="" /></div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Last Name *</label>
			<div class=""><input type="text" class="form-control required" name="txt_last_name" id="txt_last_name" value="" /></div>
		</div>
		
		<div class="form-group">
			<label class="control-label">Email *</label>
			<div class=""><input type="text" class="form-control email required" name="txt_email" id="txt_email" value="" /></div>
		</div>
	
	<?php } ?>
		
		<div class="form-group" id="result_display">
			<button type="submit" class="next_btn" id="startAssBtn" style="padding:5px 50px; font-size:15px;">Start Assignment</button>
		</div>	
 <!--
	<a class="next_btn" href="<?php echo base_url();?>assignment/questions/<?php //echo $assignment_code;?>/<?php //if(isset($auth_code) && $auth_code!=''){echo $auth_code;}?>"><i class="fa fa-hand-o-right" aria-hidden="true"></i> Start Assingment Now!</a>-->
	
	</form>
	<p>&nbsp;</p>
<p>&nbsp;</p>
<script>
jQuery(document).ready(function(){ 
	jQuery('#startAssignFrm').validate({
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		errorElement: 'span',
		errorClass: 'error',
		errorPlacement: function (error, element) {
			error.insertAfter(element);
		},
		submitHandler: function(form){
			var ajax_base_url = jQuery('#h_ajax_base_url').val();
			var site_base_url = jQuery('#h_base_url').val();
			var assignment_code = jQuery('#h_assignment_code').val();
			var form = jQuery('#startAssignFrm');
			var url = ajax_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					jQuery('#startAssBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){
						window.location=site_base_url+'assignment/questions/'+assignment_code+'/'+result_arr[1];
					}else{
						//jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						jQuery('#startAssBtn').html('Start Assignment');
					}
				},
				error: function(xhr, status, error_desc){				
					//jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#startAssBtn').html('Start Assignment');
				}
			});		
			return false;
		}
	});
});
</script>
	<?php } ?>
	
</div>
</div>
 