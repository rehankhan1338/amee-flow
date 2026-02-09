<?php

$question_id=$_GET['question_id']; 
$question_fulldetails = get_survey_question_fulldetails_h($question_id);
$get_choics = get_choics_of_multiple_type_question($question_fulldetails->question_id);

$cross_tabu_question_id=$_GET['fques_id']; 
$question_cross_tab_fulldetails = get_survey_question_fulldetails_h($cross_tabu_question_id); 
?>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px;">Download as Image</button>
<!--<h4>Q<?php //if(isset($question_cross_tab_fulldetails->priority) && $question_cross_tab_fulldetails->priority>0){ echo $question_cross_tab_fulldetails->priority;}?> - </h4>-->	
<table class="table table-bordered table-hover" id="table_recordtbl_trend">
	<thead>
		<tr>
			<td class="trbg" rowspan="2" colspan="2" style="vertical-align:middle; text-align:center; font-weight:600;">Cross Tabulation</td>
			<td style="text-align:center;vertical-align:middle;  line-height:28px;font-weight:600; height:50px;background:#f5f5f5;" colspan="<?php echo count($get_choics);?>"><?php echo 'Q. '.$question_fulldetails->question_title;?></td>
		</tr>
		<tr>
			<?php foreach($get_choics as $choics){ ?><td class="trbg"><?php echo $choics->answer_choice;?></td><?php } ?>
		</tr>
	</thead>
	<tbody>		
<?php
$get_cross_tab_choics = get_choics_of_multiple_type_question($question_cross_tab_fulldetails->question_id);

$j=0; foreach($get_cross_tab_choics as $cross_tab_choics){ ?>
		
		<tr>
			<?php if($j==0){?>
			<td width="20%" rowspan="<?php echo count($get_cross_tab_choics);?>" style="vertical-align:middle; background:#f5f5f5; text-align:center; font-weight:600; line-height:28px;"><?php echo 'Q. '.$question_cross_tab_fulldetails->question_title;?></td>
			<?php } ?>
			<td class="trbg"><?php 
			
				echo $cross_tab_choics->answer_choice;
			
				$auth_codes_cross_tabulation=array();
				$cross_tabu_authcode_listing = get_authcode_from_cross_tabu_choice_id_h($cross_tab_choics->answer_id,$cross_tabu_question_id);
				
				if(count($cross_tabu_authcode_listing)>0){
				
					foreach($cross_tabu_authcode_listing as $cross_tabu_authcode){
						$auth_codes_cross_tabulation[]= $cross_tabu_authcode->auth_code;
					}
					$auth_codes = implode(',',$auth_codes_cross_tabulation);
					
					$all_choice_count = get_cross_all_count_from_authcodes_and_choice_answer_id_h($question_id,$auth_codes);
				
				}
			?></td>
			<?php foreach($get_choics as $choics){ ?>
			<td>
				<?php 
			 
 				 if(count($cross_tabu_authcode_listing)>0){
				 	
  					$choice_count = get_cross_count_from_authcodes_and_choice_answer_id_h($choics->answer_id,$question_id,$auth_codes);
					
					if($all_choice_count>0){
						$percentage = ($choice_count*100)/$all_choice_count;
					}else{
						$percentage = 0;
					}
					
				 echo round($percentage,2).'%';?><span style="font-weight:bold; margin-left:15px;">(<?php echo $choice_count;?>)</span>
					<?php
					
				 }else{
				 	?>
					0%<span style="font-weight:bold; margin-left:15px;">(0)</span>
				<?php } ?>
			</td>
			<?php } ?>
		</tr>
 
<?php $j++; } ?>
</tbody>
</table> 