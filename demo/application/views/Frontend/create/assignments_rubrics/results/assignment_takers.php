<?php if(isset($_GET['view_result']) && $_GET['view_result']=='takers'){?>
<script type="text/javascript">
function assignment_answer_details(assingment_id,auth_code){
	if(assingment_id!='' && auth_code!=''){
		$.ajax({url: "<?php echo base_url();?>assignments_rubrics/ajax_answer_details?assingment_id="+assingment_id+"&auth_code="+auth_code, 
			beforeSend: function(){ 
				$('#loading_btn'+auth_code).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
			},
			success: function(result){ //alert(result);
				if(result!=''){
					$('#open_model_assingment_answer_details').html(result);
					$('#loading_btn'+auth_code).html('');
					jQuery("#open_model_assingment_answer_details").modal('show');
				}
			}
		});
	}
}
function display_raters_page(change_to,id){
	if(change_to!='' && id!=''){
		$.ajax({url: "<?php echo base_url();?>assignments_rubrics/display_raters_page?change_to="+change_to+"&id="+id, 
			beforeSend: function(){ 
				$('#display_raters'+id).html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>');
			},
			success: function(result){ //alert(result);
				if(result!=''){
					//$('#open_model_assingment_answer_details').html(result);
					$('#display_raters'+id).html(result);
					//jQuery("#open_model_assingment_answer_details").modal('show');
				}
			}
		});
	}
}
</script>	
<div class="modal fade" id="open_model_assingment_answer_details" tabindex="-1" role="dialog"></div>  
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">
	<thead>
		<tr class="trbg"> 
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">#</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Code / Name </th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Start Date</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">End Date</th>
			<th class="survey_listing_td" style="vertical-align:middle;">Status</th>
			<th class="survey_listing_td" style="vertical-align:middle;">Answers</th>
			<th class="survey_listing_td" style="vertical-align:middle;">Individual Rating</th>
			<th class="survey_listing_td" style="vertical-align:middle;">Display Rater Page</th>
			<!--<th class="survey_listing_td" style="vertical-align:middle;">Action</th>-->
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($assignments_complete_incomplete_user_result as $result){?>
	
		<tr>
 			<td><?php echo $j;?></td>		
			<td style="font-weight:600;"><?php if(isset($result->auth_code)&& $result->auth_code!=''){echo $result->auth_code;};if(isset($result->first_name)&& $result->first_name!=''){ echo ' / '.$result->first_name.' '.$result->last_name;}?></td>
			<td><?php if(isset($result->start_date) && $result->start_date!='' && $result->start_date!=0){ echo date('m/d/Y h:i:s',$result->start_date);}else{echo '-';}?></td>
			<td><?php if(isset($result->finish_date)&& $result->finish_date!=''){ echo date('m/d/Y h:i:s',$result->finish_date);}else{echo '-';}?></td>
 			<td><?php if(isset($result->finish_status) && $result->finish_status=='1'){echo '<b>Complete</b>';}else{echo 'Incomplete';}?></td>
 			<td> 
				<?php if(isset($result->finish_status) && $result->finish_status=='1'){?>
				<a style="font-size: 25px;" href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8&ar_id=<?php echo $result->assingment_id;?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers&auth_code=<?php echo $result->auth_code;?>" ><i class="fa fa-list-alt" aria-hidden="true"></i></a>
				<?php }else{ echo '-';}?>
			</td>
			<td style="vertical-align:middle;">
			<?php if(isset($result->finish_status) && $result->finish_status=='1'){?><a style="font-size: 18px;" href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8&ar_id=<?php echo $result->assingment_id;?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=takers&auth_code=<?php echo $result->auth_code;?>&individual_rating=1"><i class="fa fa-star" aria-hidden="true"></i> </a>
			<?php }else{ echo '-';}?></td>
			<td style="vertical-align:middle;" id="display_raters<?php echo $result->id;?>" ><!--<i class="fa fa-circle"></i>-->
				<?php if(isset($result->department_status) && $result->department_status==0){ ?>
					<span class="user_display_rater_deactive" onclick="return display_raters_page('1','<?php echo $result->id;?>');"></span>
				<?php }else{?>
					<span class="user_display_rater_active" onclick="return display_raters_page('0','<?php echo $result->id;?>');"></span>
				<?php } ?>
			</td>
			<!--<td>
				 
			</td>-->
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>
<?php } ?>