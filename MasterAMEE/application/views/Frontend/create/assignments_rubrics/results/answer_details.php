<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">

<thead>

<tr class="trbg">

	<th colspan="2" class="survey_listing_td" style="letter-spacing: 0.5px;"><?php if(isset($assingment_auth_code_detail->auth_code)&& $assingment_auth_code_detail->auth_code!=''){echo $assingment_auth_code_detail->auth_code;};if(isset($assingment_auth_code_detail->first_name)&& $assingment_auth_code_detail->first_name!=''){ echo ' / '.$assingment_auth_code_detail->first_name.' '.$assingment_auth_code_detail->last_name;}

	

	if(isset($assingment_auth_code_detail->rate_your_self) && $assingment_auth_code_detail->rate_your_self!='' && $assingment_auth_code_detail->rate_your_self>0){

		

		$self_rating_fulldetails = get_self_rating_fulldetails_h($assingment_auth_code_detail->rate_your_self);

	echo ' <span class="pull-right">Student Self Rating: '.$self_rating_fulldetails->range_name_column.' ('.$self_rating_fulldetails->oprf_column.' - '.$self_rating_fulldetails->oprf_column_sec.')'.'</span>';} 

	

	?></th>

</tr>

</thead>

<tbody>

<?php if(count($assignments_rubrics_questions_detail)>0){

$j=1; foreach($assignments_rubrics_questions_detail as $questions_detail){?>

<tr>

<?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){ ?>

<td width="40%"><?php echo ucfirst($questions_detail->question_title);?></td>

<?php }?>		

<td>

<?php 				

$question_id = $questions_detail->question_id;

$question_type = $questions_detail->question_type;

$assingment_id = $questions_detail->ar_id;

$assingment_ans = get_assingment_answers_detail_by_question_id($assingment_id, $auth_code, $question_id);

if($question_type==3){

echo $assingment_ans;	

}else if($question_type==1){

if(isset($assingment_ans) && $assingment_ans!=''){

	$answer_name = get_assignments_rubrics_question_answers_name_by_answer_id($assingment_ans,$question_type);

	echo $answer_name;								

}

}	

?>					

</td>

</tr>

<?php $j++;} }?>



<?php $i=1; foreach($assingment_courses_detail as $courses_detail){?>



<?php $courses_result = get_courses_assingment_answers_detail_by_course_id($assignments_rubrics_row->id, $courses_detail->id, $auth_code);?>



<tr>

<td>Course(s) currently enrolled in #<?php echo $i.': &nbsp;&nbsp;<b>'.$courses_detail->course_enrolled.'</b>';?></td>

<td><?php if($courses_result==1){ echo 'Yes';}else{echo 'No';}?></td>

</tr>



<?php $i++; }?>	

		

				 

</tbody>		 

</table>

<div class="clearfix"></div>