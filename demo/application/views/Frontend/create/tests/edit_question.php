<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/multiple-select/multiple-select.css">
<script src="<?php echo base_url();?>assets/backend/multiple-select/multiple-select.js"></script>
<script>
  // Here the mounted function is same as })
 $(function() { 
    $('#courses_taught_during_entitlement').multipleSelect();
  });
</script>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php echo ucwords($test_details->test_title);?> : : Question : : Edit
	<div class="btn_div">
 		<a class="btn btn-default" href="<?php echo base_url();?>department/create/tests/management?tab_id=3&test_id=<?php echo $test_details->test_id;?>&dept_id=<?php echo $test_details->department_id;?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Questions List</a>
	</div>
	</h3>
</div>
<div class="clearfix"></div>
<style>
.survey_inner_question{min-height:800px;}
.survey_inner_question_title{text-align:left;}
 .contenttitle2 {
    margin: 20px 0;
    border-bottom: 2px dotted #FB9337;
}
.error {
    color: #a94442;
    font-size: 15px !important;
    letter-spacing: 1px;
    font-style: italic;
	padding-left:5px;
	font-weight:600;
	float:left
}
#validation_status_div .error{position:absolute; margin-top:25px;}
.is_demo_question .error{position:absolute; margin-top:25px;}
table.matrix{  text-align:center;}
/*table.matrix td{ width:20%; padding:5px;}*/
table.matrix tr td:first-child{border-right: 1px solid #dedede;}
.nps span{ font-weight:600; font-size:18px;} 
</style>
<div class="survey_inner_question">

<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>tests/update_question_entry" id="frm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="hidden_tab_type" id="hidden_tab_type" value="test_question" />	
	
	<input type="hidden" name="h_question_id" id="h_question_id" value="<?php echo $tests_questions_fulldetails->question_id;?>" />
	<input type="hidden" name="h_question_type" id="h_question_type" value="<?php echo $tests_questions_fulldetails->question_type;?>" />
	<input type="hidden" name="h_test_id" id="h_test_id" value="<?php echo $tests_questions_fulldetails->test_id;?>" />
	
	
<div class="col-md-1"></div> 
<div class="col-md-12 survey_inner_question_title">
	<div class="col-md-12 form-group">
		<label style="font-weight:600; margin-bottom:10px;">Question Title</label>
		<input type="text" class="form-control required" id="test_question_title"  name="test_question_title"   placeholder="Question Title" value="<?php if(isset($tests_questions_fulldetails->question_title) && $tests_questions_fulldetails->question_title!=''){ echo $tests_questions_fulldetails->question_title;}?>" />
	</div>
	
	<div class="col-md-9 form-group">
	<?php if(isset($tests_questions_fulldetails->question_type) && $tests_questions_fulldetails->question_type==1){ 				
		$get_choics	= get_choics_of_multiple_type_question_tests($tests_questions_fulldetails->question_id); ?>


<div class="col-md-12">
<div class="col-md-8">
	<label style="margin: 0px 0 10px -15px;font-weight:600;">Answers</label>
</div>

<div class="col-md-4">
	<label style="margin: 0px 0 10px -15px;font-weight:600;">Correct Answer</label>
</div>
</div>

			<?php $r=1;foreach($get_choics as $choics){?>				
				<div class="col-md-12 docfields" style="margin:5px;" >
					<div class="col-md-8">
						<input type="hidden" name="answer_choice_id[]" id="answer_choice_id[]" value="<?php echo $choics->answer_id ;?>"/>
						<input type="text" name="choice_<?php echo $choics->answer_id ;?>" id="choice_<?php echo $choics->answer_id ;?>" value="<?php echo $choics->answer_choice ;?>" class="form-control required" style="width:87%; display:inline-block; " placeholder="Insert text to write Choice <?php echo $r;?>"/>
						&nbsp;&nbsp;<a href="<?php echo base_url();?>tests/delete_question_choice?answer_id=<?php echo $choics->answer_id ;?>&question_id=<?php echo $tests_questions_fulldetails->question_id;?>&question_type=<?php echo $tests_questions_fulldetails->question_type;?>&tab_type=test_question" onclick="return confirm('Are you sure you want to delete this choice?');" class="btn btn-danger btn-xs"  >Delete</a>
					</div>	
				
					<div class="col-md-4">
						<div class="form-group" style="padding-left: 50px;">
							<input type="radio" name="answer_radio" id="answer_radio" value="<?php echo $choics->answer_id ;?>" style="margin: 10px;" class="required" <?php if(isset($tests_questions_fulldetails->correct_answer) && $tests_questions_fulldetails->correct_answer==$choics->answer_id){?> checked="checked" <?php }?> />
						</div>
					</div>			
				</div>												
			<?php $r++; } ?>	
			
			<div id="load_docs"></div>



<style type="text/css">
#undergraduate_checkboxes {
  display: none;
  border: 1px #dadada solid;
  position:absolute;
  width:90.1%;
  z-index:999;
  background: #485b79 url(../images/default/headerbg.png);
}
#undergraduate_checkboxes label {
  display: block;padding: 3px 15px;width: 47%%;color: #fff;font-size: 17px; text-align:left;
}
#undergraduate_checkboxes label:hover {
  background-color: #fb9337; color:#fff; border-radius:3px;
}
</style>

<div class="col-md-12" style="margin:5px 20px;" >
<div class="col-md-8">				
<div class="form-group" id="">
<label>Select Point Value (Marks of Question)</label>
<select name="point_value" id="point_value" class="form-control required" placeholder="Select Point Value">
	<option value="">Select Point Value (Marks of Question)</option>
	<?php for($i=1; $i<=20; $i++){?>
		<option value="<?php echo $i;?>" <?php if(isset($tests_questions_fulldetails->point_value) && $tests_questions_fulldetails->point_value==$i){?> selected="selected" <?php }?> ><?php echo $i;?></option>
	<?php } ?>
</select>
</div>	


<div class="form-group" id="" >
<label>Click on the dropdown box to align your question with a program learning objective/outcome. </label>
	<div onclick="undergraduate_showCheckboxes()">
		<select class="form-control" id="undergraduate_direct_assesment[]" name="undergraduate_direct_assesment[]">
			<option value="">-- Select --</option>
		</select>
		<div class="overSelect"></div>
	</div>
		
		
		<?php if(isset($tests_questions_fulldetails->learning_outcomes)&& $tests_questions_fulldetails->learning_outcomes!=''){
			$learning_outcomes = explode(",", $tests_questions_fulldetails->learning_outcomes);
		}else{$learning_outcomes[] ='';}
		?>		
	<div id="undergraduate_checkboxes">		
		<?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?>	
			<label for="undergraduate_<?php echo $pslos_undergraduate->id;?>">
			<input type="checkbox" name="undergraduate_dam[]" class="" id="undergraduate_<?php echo $pslos_undergraduate->id;?>" value="<?php echo $pslos_undergraduate->id;?>" <?php if(in_array($pslos_undergraduate->id, $learning_outcomes)){?> checked="checked" <?php } ?> /> &nbsp;&nbsp;<?php echo $pslos_undergraduate->plso_title;?></label>
		<?php } ?>	
		
		<?php foreach($department_pslos_graduate as $pslos_graduate){?>	
			<label for="undergraduate_<?php echo $pslos_graduate->id;?>">
			<input type="checkbox" name="undergraduate_dam[]" class="" id="undergraduate_<?php echo $pslos_graduate->id;?>" value="<?php echo $pslos_graduate->id;?>" <?php if(in_array($pslos_graduate->id, $learning_outcomes)){?> checked="checked" <?php } ?>/> &nbsp;&nbsp;<?php echo $pslos_graduate->plso_title;?></label>
		<?php } ?>
	</div>
</div>		
</div>			
</div>			
			
				
			<div>
				<a class="btn btn-success btn-sm" style="margin-top:20px; font-size:15px" onclick="return add_more_core_function();">Add More Choices</a>
			</div>
	<?php }?>				
	
<script type="text/javascript">
function add_more_core_function(){
var n = jQuery(".docfields").length;
var cnt = n+1; 
var html ='<div class="col-md-12 docfields" style="margin:5px;" ><div class="col-md-8"><input type="text" name="newchoice[]" id="newchoice[]" value="" class="form-control required" style="width:87%;display:inline-block;" placeholder="Insert text to write Choice '+cnt+'"/>&nbsp;&nbsp;<a class="btn btn-danger btn-xs" onclick="javascript:removeField(this);">Remove</a></div><div class="col-md-4"><div class="form-group" style="padding-left: 50px;"><input type="radio" name="answer_radio" id="answer_radio" value="1" style="margin: 10px;" class="required" /></div></div><div class="clearfix"></div></div>';

jQuery('#load_docs').append(html);
}

function removeField(element){
jQuery(element).closest(".docfields").remove();
}
</script>
</div>
	

	
	<div class="col-md-3" style="margin: 0 -50px; width: 30%;">
		<div class="col-md-12">
			<label style="font-weight:600;margin-bottom:20px;">Validation</label>
		</div>
		
		<div class="col-md-12">	
			<div class="col-md-6">
				<label>Is Required:</label>
			</div>	
			<div class="col-md-6">
				<div class="form-group">
					<div id="validation_status_div">
						<input type="radio" name="validation_status" id="validation_status" class="required" <?php if(isset($tests_questions_fulldetails->is_required) && $tests_questions_fulldetails->is_required==1){ ?> checked="checked" <?php } ?> value="1" onclick="return valiation_check(this.value);" /> &nbsp;Yes
						&nbsp;&nbsp;&nbsp;<input type="radio" class="required"   name="validation_status" id="validation_status" <?php if(isset($tests_questions_fulldetails->is_required) && $tests_questions_fulldetails->is_required==2){ ?> checked="checked" <?php } ?> value="2" onclick="return valiation_check(this.value);" /> &nbsp;No
					</div>
				</div>
			</div>
		</div>	
		
	<script type="text/javascript">
	<?php if(isset($tests_questions_fulldetails->is_required)&&$tests_questions_fulldetails->is_required==1){ ?>
		jQuery(document).ready( function (){
			jQuery("#validation_error_message").addClass(" required ");
			jQuery('#validation_error_message_div').show();
		});
	<?php } ?>
		function valiation_check(val){
			if(val==1){
				jQuery("#validation_error_message").addClass(" required ");
				jQuery('#validation_error_message_div').show();
			}else{
				jQuery("#validation_error_message").removeClass(" required ");
				jQuery('#validation_error_message_div').hide();
			}
		}
	</script>

			<div class="col-md-12" style="margin: 0 20px; padding: 0px;">		
				<div class="form-group" style="display:none;" id="validation_error_message_div">
					<div class="col-md-12 ">
						<div class="col-md-12 ">
							<label>Error Message: Add a message to indicate the question is required.</label>
						</div>
						<div class="col-md-12" style="margin-top:10px;">
							<textarea name="validation_error_message" id="validation_error_message" rows="5" class="form-control" style="resize:none;"><?php if(isset($tests_questions_fulldetails->required_message) && $tests_questions_fulldetails->required_message!=''){echo $tests_questions_fulldetails->required_message;}?></textarea>
						</div>
					</div>
				</div>
			</div>	
	</div>
	
	
	
	
</div>
	<div class="col-md-1"></div> 
<div class="clearfix"></div>
<div class="col-md-4">&nbsp;</div>
<div class="col-md-4">
	<button type="submit" class="btn btn-primary" name="submit_login"  style="width:100%; margin-top:10px;">Save and Update</button>
</div>
<div class="col-md-4">&nbsp;</div>
</form>

</div> 
<div class="clearfix"></div>


<script type="text/javascript">
 var expanded = false;
function undergraduate_showCheckboxes() {
  var checkboxes = document.getElementById("undergraduate_checkboxes");
  if (!expanded) {
  	jQuery('#undergraduate_direct_assesment').html('<option>Click Here to Hide Options</option>'); 
    checkboxes.style.display = "block";
    expanded = true;
  } else {
  	jQuery('#undergraduate_direct_assesment').html('<option>-- Select --</option>'); 
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>