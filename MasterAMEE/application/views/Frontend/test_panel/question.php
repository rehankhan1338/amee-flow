<?php if(isset($test_detail->time_limit_status) && $test_detail->time_limit_status=='0'){
	 
if(isset($_SESSION['session_remeaning_second']) && $_SESSION['session_remeaning_second']>0){
	$upgradeTime = $_SESSION['session_remeaning_second'];
}else if(isset($test_detail->time_limits)&&$test_detail->time_limits>0){
	$upgradeTime = $test_detail->time_limits;
}

?>
<script type="text/javascript">
//var upgradeTime = 5;
var upgradeTime = '<?php echo $upgradeTime;?>';
var seconds = upgradeTime;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    document.getElementById('countdown').innerHTML = hours + ":" + minutes + ":" + remainingSeconds;
    if (seconds == 0) {
        clearInterval(countdownTimer);        
        window.location = '<?php echo base_url()?>/test_form/result/<?php echo $test_code.'/'.$auth_code; ?>';
        // document.getElementById('countdown').innerHTML = "Completed";        
    } else {
        seconds--;
        $('#hidden_second').val(seconds);
    }
}
var countdownTimer = setInterval('timer()', 1000);
</script>
<?php } ?>

<div class="col-md-12">
<div class="questions_div">

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
	  },rules: {
		   new_password: {
			 required: true,
		   } ,
			   confirm_password: {
				equalTo: "#new_password",
		   }
	   }		
 }); 
});
</script>

<form class="" id="frm" method="post" action="<?php echo base_url();?>test_form/answer_save" enctype="multipart/form-data">	
	<input type="hidden" id="hidden_second" name="hidden_second" value="">
	
	<input type="hidden" id="h_test_code" name="h_test_code" value="<?php if(isset($test_detail->test_code)&&$test_detail->test_code!=''){echo $test_detail->test_code;}?>">
	<input type="hidden" id="h_current_test_type" name="h_current_test_type" value="<?php if(isset($test_detail->current_test_type)&&$test_detail->current_test_type!=''){echo $test_detail->current_test_type;}?>">
	<input type="hidden" id="h_test_id" name="h_test_id" value="<?php if(isset($test_detail->test_id)&&$test_detail->test_id!=''){echo $test_detail->test_id;}?>">
	<input type="hidden" id="h_department_id" name="h_department_id" value="<?php if(isset($test_detail->department_id)&&$test_detail->department_id!=''){echo $test_detail->department_id;}?>">
	<input type="hidden" id="h_auth_code" name="h_auth_code" value="<?php if(isset($auth_code)&&$auth_code!=''){echo $auth_code;}?>">
	<input type="hidden" name="next_page_link" id="next_page_link" value="<?php echo $next_page_link; ?>">

<?php $i=$current_page; foreach($test_questions_detail as $questions_detail){?>
<?php $answers_result = get_test_answers_detail_by_question_id($test_detail->test_id,$test_detail->current_test_type, $auth_code, $questions_detail->question_id);?>
			
	<input type="hidden" id="h_question_id[]" name="h_question_id[]" value="<?php if(isset($questions_detail->question_id)&&$questions_detail->question_id!=''){echo $questions_detail->question_id;}?>">
				
	<?php if(isset($questions_detail->question_type)&&$questions_detail->question_type==3){?>
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?>
			</div>
			
			<div class="qus_options">
				<input type="text" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="form-control <?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php if(isset($answers_result)&&$answers_result!=''){echo $answers_result;}?>"/>
			</div>
		</div>
	
	
	<?php }else if(isset($questions_detail->question_type)&& $questions_detail->question_type==1){ 
		$question_answers = get_choics_of_multiple_type_question_tests($questions_detail->question_id); ?>	
		
		<div class="qus_box">
			<div class="qus_head">
				<span><?php echo $i; ?></span>
				<?php if(isset($questions_detail->question_title)&&$questions_detail->question_title!=''){echo ucwords($questions_detail->question_title);} ?>
			</div>
			<div class="qus_options">
				<?php foreach($question_answers as $answers){?>
					<div class="radio">
						<label><input type="radio" title="<?php if(isset($questions_detail->required_message)&&$questions_detail->required_message!=''){echo $questions_detail->required_message;}?>" name="field_name<?php echo $questions_detail->question_id; ?>" id="field_name<?php echo $questions_detail->question_id; ?>" class="<?php if(isset($questions_detail->is_required)&&$questions_detail->is_required=='1'){echo 'required';}?>" value="<?php echo $answers->answer_id;?>" <?php if(isset($answers_result)&& $answers_result==$answers->answer_id){?> checked="" <?php }?> />
							<?php echo $answers->answer_choice; ?>
						</label>
					</div>
				<?php } ?>
				<div class="errorTxt<?php echo $questions_detail->question_id;?>"></div>
			</div>
		</div>
	<?php }?>	

<?php $i++; }?>	
	
	<div aria-label="Page" class="page_links" style="text-align: center;">
 		<input type="submit"  class="next_btn" name="next_page" id="next_page" value="Save"/>
 		<!--<a class="next_btn" href=""> Next </a>-->
	</div>
 	
	
</form>	
</div>
</div>

