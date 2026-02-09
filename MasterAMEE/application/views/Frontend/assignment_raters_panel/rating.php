<script src="<?php echo base_url();?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">  
jQuery(function () { if(jQuery('#editor').length > 0){CKEDITOR.replace( 'editor',{height: '150px',}); } }); 
</script>
<?php if(isset($assingment_detail->rubric_status) && $assingment_detail->rubric_status==1){

	$rubrics_builder_listing = get_assignments_rubrics_builder($assingment_detail->id);
	$builder_heading_listing = get_assignments_rubrics_builder_heading($assingment_detail->id);
?>
<form method="post" action="<?php echo base_url();?>assignment_raters/save_participant_feedback">
<input type="hidden" name="auth_code" id="auth_code" value="<?php echo $auth_code;?>" />
<input type="hidden" name="assingment_id" id="assingment_id" value="<?php echo $assingment_id;?>" />
<input type="hidden" name="assingment_code" id="assingment_code" value="<?php echo $assingment_code;?>" />
<input type="hidden" name="user_auth_code" id="user_auth_code" value="<?php echo $user_auth_code;?>" />

<?php if(count($assignments_user_upload_instruction)>0){ ?>

<div class="col-md-12 tac"><h1 class="title">Assignment:  Click this link to review assignment</h1></div> 
<div align="center">
<?php foreach($assignments_user_upload_instruction as $up){

if($up->upload_type=='image'){?>
<a href="<?php echo base_url();?>assets/upload/assignment/thumbnails/<?php echo $up->file_name;?>"><img src="<?php echo base_url();?>assets/upload/assignment/thumbnails/<?php echo $up->file_name;?>" alt="<?php echo $up->document_title;?>"></a>

<?php } if(isset($up->upload_type) && $up->upload_type!='youtube_video_link'){
				$video_link_path = $up->file_name;
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
			
			 if($up->upload_type=='document'){?>
			<a style="display:block;" href="<?php echo base_url();?>assets/upload/assignment/<?php echo $up->file_name;?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $up->document_title;?></a>
			
			<?php } ?>

<?php }?>
</div>
<?php } ?>

<table class="table table-hover table-bordered table-striped rating_table table-responsive">
	<thead>
		<tr class="trbg" style="text-align:center;">
			<th style="text-align:center; vertical-align:middle;">Category</th>
			<?php foreach($builder_heading_listing as $heading_details){?>
				<th style="text-align:center; vertical-align:middle;">
					<p><?php echo $heading_details->range_name_column;?></p>
					[<?php echo $heading_details->oprf_column;?>
					<b>&ndash;</b>
					<?php echo $heading_details->oprf_column_sec;?>]
				</th>
			<?php } ?>	
			<th style="text-align:center; vertical-align:middle;">Score</th>		
		</tr>
	</thead>
	<tbody>
		<?php $k=1; foreach($rubrics_builder_listing as $builder_details){?>
		
			<tr style="border-top:1px solid #dedede; vertical-align:top;">
				<td>
				
				<input type="hidden" name="category_ids[]" id="category_ids[]" value="<?php echo $builder_details->rubric_id;?>" />
				<?php echo $builder_details->category_name;?></td>
				<?php $l=1; foreach($builder_heading_listing as $heading_details){
					
					$option_value = get_assignments_rubrics_builder_option_details($heading_details->column_no, $builder_details->rubric_id);?>
					
					<td style="line-height:25px;"><?php echo $option_value;?></td>
				<?php $l++; }?>
				<td>
					<?php $highest_rating = get_assignments_rubrics_builder_highest_rating_h($assingment_detail->id);
						
						$rating_score = get_raters_rating_score_h($builder_details->rubric_id,$assingment_id,$auth_code,$user_auth_code);
						
						?>
					<select class="form-control" style="width:65px;" name="score_<?php echo $builder_details->rubric_id;?>" id="score_<?php echo $builder_details->rubric_id;?>">
 						<?php if($highest_rating>0){ for($kh=$highest_rating;$kh>=1;$kh--){?>
							<option value="<?php echo $kh;?>" <?php if(isset($rating_score) && $rating_score==$kh){?> selected="selected" <?php } ?>><?php echo $kh;?></option>
						<?php } }else{ ?>
						<option value="">0</option>
						<?php } ?>
					</select>
				</td>

			</tr> 		
		<?php $k++; }?>
	</tbody>
</table>


<div class="col-md-12 tac"><h1 class="title">Provide Participant Feedback</h1></div> 
<div class="col-md-12 instructions fs14"><strong>Instructions:</strong> Please provide constructive feedback to each participant about their assessment performance. They will receive these comments anonymously through their feedback link.</div>

<div class="col-md-12 m0p0"><textarea class="form-control" name="participant_feedback" id="editor"><?php if(isset($rater_feedback_details->participant_feedback) && $rater_feedback_details->participant_feedback!=''){echo $rater_feedback_details->participant_feedback;}?></textarea></div>
 
<div class="clearfix"></div>
 
<table class="table table-bordered final_answer_fields">
<tr>
<th width="30%">Is this your final answer? </th>
<th>
<input type="radio" name="final_answer_status" id="final_answer_status" value="1" <?php if(isset($rater_feedback_details->final_answer_status) && $rater_feedback_details->final_answer_status==1){?> checked="checked" <?php } ?> /> &nbsp;&nbsp;Yes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="final_answer_status" id="final_answer_status" value="2" <?php if(isset($rater_feedback_details->final_answer_status) && $rater_feedback_details->final_answer_status==2){?> checked="checked" <?php } ?> /> &nbsp;&nbsp;No
</th>
</tr>
</table> 
	
<div class="clearfix"></div>
<div class="rater_save_btn">
<div class="col-md-4">&nbsp;</div>
<div class="col-md-4"><input type="submit" name="submit" class="btn btn-primary view_btn" style="width:100%;" value='Save & Update'/></div>
<div class="col-md-4">&nbsp;</div>
</div>
</form>
<?php 		
}else{

}
?>	