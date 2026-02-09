<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3> Survey Result </h3>
</div>

<!--<div class="btn_div pull-right" style="margin-top:-52px;">

</div>-->

<div class="clearfix"></div>		  
<table class="table table-hover table-bordered" id="table_recordtbl25">
	<thead>
		<tr class="trbg"> 
			<th class="survey_listing_td" style="vertical-align:middle;" width="5%" nowrap="nowrap">S. No</th>
			<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap">Code </th>
			<th class="survey_listing_td" style="vertical-align:middle;" width="20%" nowrap="nowrap">Start Date</th>
			<th class="survey_listing_td" style="vertical-align:middle;" width="20%" nowrap="nowrap">End Date</th>
			<th class="survey_listing_td" style="vertical-align:middle;" width="20%">Status</th>
			<th class="survey_listing_td" style="vertical-align:middle;" width="20%">Answers</th>
		</tr>
	</thead>
	<tbody>
	<?php $j=1; foreach($survey_email_detail as $email_detail){?>
	
		<tr>
 			<td><?php echo $j;?></td>		
			<td><?php if(isset($email_detail->auth_code)&& $email_detail->auth_code!=''){echo $email_detail->auth_code;};?></td>
			<td><?php echo date('m/d/Y',$email_detail->add_date);?></td>
			<td><?php if(isset($email_detail->finish_date)&& $email_detail->finish_date!=''){ echo date('m/d/Y h:i A',$email_detail->finish_date);}else{echo '-';}?></td>
			
			<td><?php if(isset($email_detail->finish_status) && $email_detail->finish_status=='1'){echo 'Complete';}else{echo 'Incomplete';}?></td>
						
			<td>
				<a class="btn btn-default" style="padding: 3px 15px;font-size: 15px;" href="<?php echo base_url();?>department/create/survey/answer/<?php echo $email_detail->survey_id;?>/<?php echo $email_detail->auth_code;?>">Answers</a>
 			</td>
		</tr>
	
	<?php $j++; } ?>
	</tbody>
</table>