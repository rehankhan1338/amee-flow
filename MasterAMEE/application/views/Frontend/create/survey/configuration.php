<div id="survey_configuration" class="subcontent" >
	
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>survey/add_survey_configuration" enctype="multipart/form-data">
	<div class="col-md-8">
		<div class="contenttitle2 nomargintop">
			<h3> Sponsored by</h3>
		</div>
		<div class="col-md-12" style="margin:0; padding:0;">	
			<input type="hidden" name="h_survey_id" value="<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!=''){ echo $_GET['survey_id'];}?>">
			<input type="hidden" name="h_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>">
		
			<div class="col-md-6 form-group">
				<label for="inputEmail3"><h4>Sponsor Name</h4></label>
				<input type="text" name="survey_sponsor_name" id="survey_sponsor_name" value="<?php if(isset($survey_details->survey_sponsor_name) && $survey_details->survey_sponsor_name!=''){ echo $survey_details->survey_sponsor_name;}?>" class="form-control" placeholder="" />
			</div>
			
			<div class="col-md-3 form-group">
				<label for="inputEmail3"><h4>Sponsor Logo</h4></label>
				<input type="file" name="photo" id="photo" class="form-control-file" placeholder="" />
			</div>		
			<?php if(isset($survey_details->survey_sponsor_logo) && $survey_details->survey_sponsor_logo!=''){ ?>
			<div class="col-md-3 form-group">
				<img src="<?php echo base_url();?>assets/frontend/upload/surveys/thumbnails/<?php echo $survey_details->survey_sponsor_logo;?>" alt="" class="img-reponsive" />
			</div>
			<?php } ?>
				
		</div>
		<div class="clearfix"></div>
		
		<div class="contenttitle2 nomargintop">
			<h3>Customize Introductory Statement </h3>
		</div>	

		<div class="col-md-12">
			<div class="form-group">
				<label for="inputEmail3"><h4>Click box to add Introduction Message:</h4></label>
				<input type="checkbox" onchange="checkbox_apply_introduction(this.value);" name="is_introduction_msg" value="0" id="is_introduction_msg" <?php if(isset($survey_details->is_introduction_msg)&& $survey_details->is_introduction_msg=='0'){?> checked="checked" <?php } ?> style="margin-left:10px;"  />
			</div>

			<div class="form-group" id="introduction_show" <?php if(isset($survey_details->is_introduction_msg)&& $survey_details->is_introduction_msg!=0){?> style="display: none"; <?php }?> >
				<label for="inputEmail3"><h4>Introduction</h4></label>
				<textarea name="survey_introduction" id="editor"><?php if(isset($survey_details->survey_introduction) && $survey_details->survey_introduction!=''){ echo $survey_details->survey_introduction;}?></textarea>
			</div>
		</div>

		<div class="clearfix"></div>
		<div class="contenttitle2 nomargintop">
			<h3> Customize End of Survey Message </h3>
		</div>
		<div class="col-md-12">	 
			<div class="form-group">
				<label for="inputEmail3"><h4>Message</h4></label>
				<textarea name="survey_message" id="editor_end"><?php if(isset($survey_details->survey_message) && $survey_details->survey_message!=''){ echo $survey_details->survey_message;}?></textarea>
			</div>  		
		</div>
	</div>

	<div class="col-md-4">
		<div class="contenttitle2 nomargintop">
			<h3> Submission Deadline </h3>
		</div>
		<div class="col-md-12" style="margin:0; padding:0;">
		
		<?php $question_skip_logic_count = check_question_skip_logic_count_h($survey_details->survey_id);?>
							
			
            <div class="form-group">
				<label for="inputEmail3"><h4>Start Date</h4></label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control required" name="survey_start_date" value="<?php if(isset($survey_details->survey_start_date) && $survey_details->survey_start_date!='' && $survey_details->survey_start_date>0){ echo date('m/d/Y h:i A',$survey_details->survey_start_date);}?>"/>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>			
            
            <div class="form-group">
				<label for="inputEmail3"><h4>End Date</h4></label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control required" name="survey_end_date" value="<?php if(isset($survey_details->survey_end_date) && $survey_details->survey_end_date!='' && $survey_details->survey_end_date>0){ echo date('m/d/Y h:i A',$survey_details->survey_end_date);}?>" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
			
			<div class="form-group">
				<label for="inputEmail3"><h4> Questions per page </h4></label>
				<?php if($question_skip_logic_count==1){?>
				
					<input type="text" name="question_per_page" class="form-control required" id="question_per_page" readonly="" value="<?php if(isset($survey_details->question_per_page) && $survey_details->question_per_page){ echo $survey_details->question_per_page;} ?>" />
				<?php }else{ ?>
                <select class="form-control required" name="question_per_page">
                	<?php for($i=1; $i<=10; $i++){?>
                		<option value="<?php echo $i; ?>" <?php if(isset($survey_details->question_per_page)&&$survey_details->question_per_page==$i){?> selected="" <?php }?> > <?php echo $i; ?> </option>
                	<?php }?>
                </select>
				<?php } ?>
            </div>
			
			<div class="form-group">
				<label for="inputEmail3"><h4>Click the box to create a Sweepstakes Entry </h4></label>
				<input <?php if(isset($survey_details->result_sweepstakes_status)&& $survey_details->result_sweepstakes_status==1){?> readonly="" <?php } ?> type="checkbox" onchange="checkbox_apply_winners(this.value);" name="survey_sweepstakes" id="survey_sweepstakes" <?php if(isset($survey_details->survey_sweepstakes)&& $survey_details->survey_sweepstakes=='0'){?> checked="checked" <?php } ?> value="0" style="margin-left:10px;"  /> 
			</div>
			
			<div class="form-group" id="winners_show" <?php if(isset($survey_details->survey_sweepstakes)&& $survey_details->survey_sweepstakes!=0){?> style="display: none"; <?php }?> >
				<label for="inputEmail3"><h4>How many winners?</h4></label>
				<input type="text" name="survey_winners" id="survey_winners" value="<?php if(isset($survey_details->survey_winners) && $survey_details->survey_winners!=''){ echo $survey_details->survey_winners;}?>" class="form-control <?php if(isset($survey_details->survey_sweepstakes)&& $survey_details->survey_sweepstakes==0){ echo 'required'; }?>" placeholder="" <?php if(isset($survey_details->result_sweepstakes_status)&& $survey_details->result_sweepstakes_status==1){?> readonly="" <?php } ?>  />
			</div>						
		</div>
	</div>
		
	<div class="clearfix"></div>
		<div class="col-md-4"></div>
		<div class="col-md-4"><input name="design_save" class="btn btn-primary nmt20 w100" value="Save &amp; Update" type="submit"></div>
		<div class="col-md-4"></div>	
	</form>		 
</div>
<div class="clearfix"></div>


<script type="text/javascript">
function checkbox_apply_introduction() { 
	if(jQuery('#is_introduction_msg').prop("checked") == true){
		jQuery('#introduction_show').show();	
	}else{		
		jQuery('#introduction_show').hide();		
	}
}

function checkbox_apply_winners() { 
	if(jQuery('#survey_sweepstakes').prop("checked") == true){
		jQuery('#survey_winners').addClass(" required ");	
		jQuery('#winners_show').show();
 	}else{
		jQuery('#survey_winners').removeClass(" required ");	
		jQuery('#winners_show').hide();	
	}
}
</script>