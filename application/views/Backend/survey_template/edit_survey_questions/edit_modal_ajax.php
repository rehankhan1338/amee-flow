<?php if(isset($survey_question_fulldetails->question_type) && $survey_question_fulldetails->question_type==1){ 				
		
	$get_choics	= get_choics_of_multiple_type_question($survey_question_fulldetails->question_id);?>


		<?php $r=1;foreach($get_choics as $choics){?>			

			<div class="form-group docfields" style="margin:5px;" >
				<input type="hidden" name="answer_choice_id[]" id="answer_choice_id[]" value="<?php echo $choics->answer_id ;?>"/>
				<input type="text" name="choice_<?php echo $choics->answer_id ;?>" id="choice_<?php echo $choics->answer_id ;?>" value="<?php echo $choics->answer_choice ;?>" class="form-control required" style="width:40%; display:inline-block; " placeholder="Insert text to write Choice <?php echo $r;?>"/>
				&nbsp;&nbsp;<a href="<?php echo base_url();?>survey/delete_question_choice?answer_id=<?php echo $choics->answer_id ;?>&question_id=<?php echo $survey_question_fulldetails->question_id;?>&question_type=<?php echo $survey_question_fulldetails->question_type;?>" onclick="return confirm('Are you sure you want to delete this choice?');" class="btn btn-danger btn-xs"  >Delete</a>
			</div>													
			<?php $r++; } ?>

			<div id="load_docs"></div>	
			
			<div>
				<a class="btn btn-success btn-sm" style="margin-top:20px; font-size:15px" onclick="return add_more_core_function();">Add More Choices</a>
			</div>
			
		<?php }?>
		
		
<script type="text/javascript">
function add_more_core_function(){
	var n = jQuery(".docfields").length;
	var cnt = n+1; 
	var html ='<div class="form-group docfields" style="margin:5px;" ><input type="text" name="newchoice[]" id="newchoice[]" value="" class="form-control required" style="width:40%;display:inline-block;" placeholder="Insert text to write Choice '+cnt+'"/>&nbsp;&nbsp;<a class="btn btn-danger btn-xs" onclick="javascript:removeField(this);">Remove</a><div class="clearfix"></div></div>';
	
	jQuery('#load_docs').append(html);
}

function removeField(element){
	jQuery(element).closest(".docfields").remove();
}
</script>




