<table class="table  table-bordered table-striped" id="table_recordtbl25">
<thead>
<tr class="trbg">
	<th colspan="2" class="survey_listing_td" style="letter-spacing: 0.5px;"><?php if(isset($test_auth_code_detail->auth_code)&& $test_auth_code_detail->auth_code!=''){echo $test_auth_code_detail->auth_code;};if(isset($test_auth_code_detail->first_name)&& $test_auth_code_detail->first_name!=''){ echo ' / '.$test_auth_code_detail->first_name.' '.$test_auth_code_detail->last_name;}
	
	if(isset($_GET['test_type']) && $_GET['test_type']!='' && $_GET['test_type']==1){
		
		echo ' <span style="color:#fff;">(Pre Test)</span>';
		
	}else if(isset($_GET['test_type']) && $_GET['test_type']!='' && $_GET['test_type']==2){
	
		echo ' <span style="color:#fff;">(Post Test)</span>';
	}
	 
	 	if(isset($test_details->self_rating) && $test_details->self_rating!='' && $test_details->self_rating==0){
			
			if(isset($_GET['test_type']) && $_GET['test_type']!='' && $_GET['test_type']==2){
				$rate_your_self = $test_auth_code_detail->post_rate_your_self;					
			}else{ 
				$rate_your_self = $test_auth_code_detail->rate_your_self;				
			}
			
			if(isset($rate_your_self) && $rate_your_self!='' && $rate_your_self>0){	
				
		 		$self_rating_fulldetails = get_test_self_rating_fulldetails_h($test_details->test_id);
				
				if($rate_your_self==1){
				
					$range_name_column = $self_rating_fulldetails->range_name_column_1;
					$oprf_column = $self_rating_fulldetails->oprf_column_1;
					$oprf_column_sec = $self_rating_fulldetails->oprf_column_sec_1;
					
				}else if($rate_your_self==2){
				
					$range_name_column = $self_rating_fulldetails->range_name_column_2;
					$oprf_column = $self_rating_fulldetails->oprf_column_2;
					$oprf_column_sec = $self_rating_fulldetails->oprf_column_sec_2;
					
				}else if($rate_your_self==3){
				
					$range_name_column = $self_rating_fulldetails->range_name_column_3;
					$oprf_column = $self_rating_fulldetails->oprf_column_3;
					$oprf_column_sec = $self_rating_fulldetails->oprf_column_sec_3;
					
				}else if($rate_your_self==4){
				
					$range_name_column = $self_rating_fulldetails->range_name_column_4;
					$oprf_column = $self_rating_fulldetails->oprf_column_4;
					$oprf_column_sec = $self_rating_fulldetails->oprf_column_sec_4;
					
				}else if($rate_your_self==5){
				
					$range_name_column = $self_rating_fulldetails->range_name_column_5;
					$oprf_column = $self_rating_fulldetails->oprf_column_5;
					$oprf_column_sec = $self_rating_fulldetails->oprf_column_sec_5;
					
				} 
				if(isset($range_name_column) && $range_name_column!=''){
					echo ' <span class="pull-right">Student Self Rating: '.$range_name_column.' ('.$oprf_column.' - '.$oprf_column_sec.')'.'</span>';
				}
			}
		} 
	
	?></th>
</tr>
</thead>
<tbody>
<?php if(count($dempgraphy_questions_detail)>0){
$j=1; foreach($dempgraphy_questions_detail as $questions_detail){?>
<tr>
<?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){ ?>
<td width="40%"><?php echo ucfirst($questions_detail->question_title);?></td>
<?php }?>		
<td>
<?php 				
$question_id = $questions_detail->question_id;
$question_type = $questions_detail->question_type;
$test_id = $questions_detail->test_id;
$test_answers = get_test_demo_answers_detail_by_question_id($test_id, $auth_code, $question_id);

if($question_type==3){
	echo $test_answers;	
}else if($question_type==1){
	if(isset($test_answers) && $test_answers!=''){
		$answer_name = get_test_question_answers_name_by_answer_id($test_answers,$question_type);
		echo $answer_name;								
	}
}	
?>					
</td>
</tr>
<?php $j++;} }?>

<?php $i=1; foreach($tests_course_detail as $courses_detail){?>

<?php $courses_result = get_courses_test_answers_detail_by_course_id($test_details->test_id, $courses_detail->id, $auth_code);?>

<tr>
<td>Course(s) currently enrolled in #<?php echo $i.': &nbsp;&nbsp;<b>'.$courses_detail->course_enrolled.'</b>';?></td>
<td><?php if($courses_result==1){ echo 'Yes';}else{echo 'No';}?></td>
</tr>

<?php $i++; }?>	
		
<tr>
	<td colspan="2" style="font-weight:600; text-align:center; padding:15px;">Test Questions and Answers</td>
</tr>
<?php if(count($tests_questions_detail)>0){
$j=1; foreach($tests_questions_detail as $questions_detail){?>

<?php if(isset($questions_detail->question_title) && $questions_detail->question_title!=''){ ?>
<tr><td colspan="2"><b>Q. </b><?php echo ucfirst($questions_detail->question_title);?></td></tr>
<?php }?>		
<tr><td colspan="2" style="padding-left:20px;"> Answer : <b>
<?php 				
$question_id = $questions_detail->question_id;
$question_type = $questions_detail->question_type;
$test_id = $questions_detail->test_id;
//$test_answers = get_test_demo_answers_detail_by_question_id($test_id, $auth_code, $question_id);
$test_answers = get_test_current_answers_detail_by_question_id_h($test_id, $_GET['test_type'], $auth_code, $question_id);

if($question_type==3){
	echo $test_answers;	
}else if($question_type==1){
	if(isset($test_answers) && $test_answers!=''){
		$answer_name = get_test_question_answers_name_by_answer_id($test_answers,$question_type);
		echo $answer_name;	
		if(isset($questions_detail->correct_answer) && $questions_detail->correct_answer>0 && $questions_detail->correct_answer==$test_answers){
			?><i class="fa fa-star" aria-hidden="true" style="color:#485b79; margin-left:10px;"></i><?php
		}							
	}
}	
?>	
</b>				
</td>
</tr>
<?php $j++;} }?>
				 
</tbody>		 
</table>
<div class="clearfix"></div>