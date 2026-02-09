<div id="survey_reports" class="subcontent margin20" >

	<div class="contenttitle2 nomargintop">
		<h3> Sweepstakes Winner's</h3>
	</div>
	<div class="clearfix"></div>
	
	<div class="col-md-12" style="margin-bottom:50px;" >
		
	<?php 
		
	if($survey_details->result_sweepstakes_status==0){
		
	?>
		<a class="btn btn-primary" onclick="return confirm('Are you sure you want to select winners?');" href="<?php echo base_url();?>survey/fetch_winners?survey_winners=<?php echo $survey_details->survey_winners;?>&survey_id=<?php echo $survey_details->survey_id;?>&survey_code=<?php echo $survey_details->survey_code;?>"><i class="fa fa-trophy" style="margin-right:10px;" aria-hidden="true"></i> Select Winners Random</a>
		
	<?php	//update_random_sweepstakes_winners_h($survey_details->survey_winners,$survey_details->survey_id,$survey_details->survey_code);
		
	}else{
		
		$winners_listing = get_sweepstakes_winners_listing_h($survey_details->survey_code);
		
		if(count($winners_listing)>0){
			?>
			<ol class="col-md-12">
			<?php 
			$i=1; foreach($winners_listing as $winner_details){
		?>
 		
			<li style="margin:8px 0;"><h4><?php echo $winner_details->first_name.' '.$winner_details->last_name;?></h4><?php echo ' - '.$winner_details->email;?></li>
		
 		<?php $i++; }?>
		</ol><?php  } ?>
		
	<?php } ?>
		
	</div>
	

</div>	