<div class="col-md-12">
 	
	<?php if(isset($survey_detail->survey_sweepstakes) && $survey_detail->survey_sweepstakes==0){?>
		
<style type="text/css">
.form-control{width:40%;}
.sweepstakes h4{margin:0 0 30px 0;}
.error{color:#a94442; font-size:14px;}
.next_btn {margin-top: 10px;padding: 5px 20px;}
.alert{margin-top:15px; padding:10px 15px;}
.alert p{ font-weight:600;font-family:'Raleway', sans-serif; line-height:25px;}
</style>

<div class="alert alert-success"><?php if(isset($survey_detail->survey_message)&&$survey_detail->survey_message!=''){echo $survey_detail->survey_message;}?></div>

		<div class="col-md-12 sweepstakes">
			<script type="text/javascript">  
			  jQuery(function () {  
				jQuery('#frm').validate({
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
			</script>
			<h4>If you Would like to enter into the sweepstakes please enter your information below:</h4>	
			
			<div class="col-md-12">
	
			<form class="" id="frm" method="post" action="<?php echo base_url();?>survey_form/sweepstakes_entry" enctype="multipart/form-data">
			
				<input type="hidden" name="h_survey_code" id="h_survey_code" value="<?php echo $survey_code;?>" />
				<input type="hidden" name="h_survey_id" id="h_survey_id" value="<?php echo $survey_id;?>" />
				<input type="hidden" name="h_auth_code" id="h_auth_code" value="<?php echo $auth_code;?>" />
				
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">First Name:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control required" id="sweepstakes_first_name" name="sweepstakes_first_name" value="" placeholder="First Name" />
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Last Name:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control required" id="sweepstakes_last_name" name="sweepstakes_last_name" value="" placeholder="Last Name" />
					</div>
				</div>
				
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Email:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control email required" id="sweepstakes_email" name="sweepstakes_email" value="" placeholder="Email" />
					</div>
				</div>
				
				<div class="form-group row">
					<input type="submit"  class="next_btn" name="next_page" id="next_page" value="Done"/>
				</div>
				
			</form>
			
			</div>
			
		</div>
	<?php }else{ ?>	
		
		<div class="welcome_div">		
			
			<!--<h1 class="title"> Let's go with this! </h1>-->
			<div class="col-md-12">
				<div class="thankyou_msg"> 
				
					<i class="fa fa-check-circle" aria-hidden="true"></i>
					<h3>Thank You!</h3>
					<div class="succ_msg"><?php if(isset($survey_detail->survey_message) && $survey_detail->survey_message!=''){echo $survey_detail->survey_message;}?></div>
					
				</div>
				
			</div>	
 		
		</div>
	
	<?php } ?>
</div>