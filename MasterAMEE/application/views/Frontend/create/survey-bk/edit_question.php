<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php echo ucwords($survey_details->survey_name);?> : : Question : : Edit
	<div class="btn_div">
 		<a class="btn btn-default" href="<?php echo base_url();?>department/create/survey/management?tab_id=2&survey_id=<?php echo $survey_details->id;?>&dept_id=<?php echo $survey_details->department_id;?>">
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
<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>survey/update_question_entry" id="frm" method="post" enctype="multipart/form-data">
<input type="hidden" name="h_question_id" id="h_question_id" value="<?php echo $survey_question_fulldetails->question_id;?>" />
<input type="hidden" name="h_question_type" id="h_question_type" value="<?php echo $survey_question_fulldetails->question_type;?>" />
<input type="hidden" name="h_survey_id" id="h_survey_id" value="<?php echo $survey_question_fulldetails->survey_id;?>" />
<div class="col-md-1"></div> 
	<div class="col-md-10 survey_inner_question_title">
		<!--<div class="contenttitle2 nomargintop">
			<h3> Question Title</h3>
		</div> -->
		<div class="col-md-12 form-group">
			<label style="font-weight:600; margin-bottom:10px;">Question Title</label>
			<input type="text" class="form-control required" id="survey_question_title"  name="survey_question_title"   placeholder="Question Title" value="<?php if(isset($survey_question_fulldetails->question_title) && $survey_question_fulldetails->question_title!=''){ echo $survey_question_fulldetails->question_title;}?>" />
		</div>
		
 
		
		<div class="col-md-12 form-group">
		<?php if(isset($survey_question_fulldetails->question_type) && $survey_question_fulldetails->question_type==1){ 				
			$get_choics	= get_choics_of_multiple_type_question($survey_question_fulldetails->question_id);?>
			
			
			<label style="font-weight:600;margin-bottom:5px;">Answers</label>
			<?php $r=1;foreach($get_choics as $choics){?>			

				<div class="col-md-12 docfields" style="margin:5px;" >
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
	var html ='<div class="col-md-12 docfields" style="margin:5px;" ><input type="text" name="newchoice[]" id="newchoice[]" value="" class="form-control required" style="width:40%;display:inline-block;" placeholder="Insert text to write Choice '+cnt+'"/>&nbsp;&nbsp;<a class="btn btn-danger btn-xs" onclick="javascript:removeField(this);">Remove</a><div class="clearfix"></div></div>';
	
	jQuery('#load_docs').append(html);
}

function removeField(element){
	jQuery(element).closest(".docfields").remove();
}
</script>
		 
				
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