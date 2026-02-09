<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<div class="survey_results" id="assignment_section_tbl">
<?php 
$assignment_id = $_GET['ar_id'];
$rater_reliability_listing = get_rater_reliability_listing_h($assignment_id);
$words = $rater_reliability_listing; 
if(isset($words) && $words!='' && count($words)>0){
	$num = count($words); 
}else{
	$num = 0;
}
$total = pow(2, $num);
 
$result_single=array();
$result_double=array();
for ($i = 0; $i < $total; $i++) {
	$result	= array();
    for($j = 0;$j < $num; $j++){ 
        if (pow(2, $j) & $i){ 
			//echo 'word - '.$words[$j].'<br>';
			$result[]= $words[$j];  
		}  
    }
	if(isset($result) && $result!=''){
		if(count($result)==1){
			$result_single[] = implode(',',$result);
		}else{
			if(count($result)>0){$result_double[] = $result;}
		}
	}
}
/*echo '<hr>';
echo '<pre>';
print_r($result); 
print_r($result_double);
echo count($result_double);*/
?>

<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr class="trbg">
			<th colspan="6" style="text-align:center; color:#f6e4a5; border:none;">Consensus Estimates</th>			
		</tr>
		<tr class="trbg">
			<th width="3%" style="vertical-align:top;">#</th>
			<th style="vertical-align:top;">Rater</th>
			<th style="vertical-align:top;">Total Obs.</th>
			<th style="vertical-align:top;">No. of Agreements</th>
			<th style="vertical-align:top;">Percentage of Agreements</th>
			<th style="vertical-align:top;">Strength of Agreement</th>			
		</tr>
		</thead>
		<?php if(count($result_double)>0){ 
			
			//$total_raters_count = count($result_single);
			$assingment_rubric_builder_category_list = $this->Assignment_mdl->assingment_rubric_builder_category_list($assignment_id);
			$total_observation = count($assingment_rubric_builder_category_list)*get_total_active_observation_h($assignment_id);
		
		?>
			
			<?php for($dkl=0;$dkl<count($result_double);$dkl++){
				
				$no_of_aggreements=0;
				$inner_arr=array();
				$inner_arr=$result_double[$dkl];
				if(count($inner_arr)<=2){
					
			?>
				<tr>
					<td><?php echo $dkl+1; //echo '<pre>';?></td>
					<td style="font-weight:600;" nowrap="nowrap"><?php //print_r($inner_arr);
						$element_arr1 = explode('|',$inner_arr[0]);
						$element_arr2 = explode('|',$inner_arr[1]);
						
						$first_rater_id = $element_arr1[0];
						$second_rater_id = $element_arr2[0];
						$first_raters_fulldetails = get_raters_fulldetails_by_rater_id_h($first_rater_id);
						$second_raters_fulldetails = get_raters_fulldetails_by_rater_id_h($second_rater_id);
						
						if(isset($first_raters_fulldetails->rater_name) && $first_raters_fulldetails->rater_name!=''){
							$first_rater_name=' / '.$first_raters_fulldetails->rater_name;
						}else{
							$first_rater_name='';
						}
						if(isset($second_raters_fulldetails->rater_name) && $second_raters_fulldetails->rater_name!=''){
							$second_rater_name=' / '.$second_raters_fulldetails->rater_name;
						}else{
							$second_rater_name='';
						}
						
						$first_raters_users = get_raters_users_of_assignment_h($assignment_id,$first_raters_fulldetails->auth_code);
						$second_raters_users = get_raters_users_of_assignment_h($assignment_id,$second_raters_fulldetails->auth_code);
						$commonvalue = array_intersect($first_raters_users,$second_raters_users);
 						print_r($second_rater_name);
						foreach($assingment_rubric_builder_category_list as $rubric_builder_category){
						
							$category_id = $rubric_builder_category->rubric_id;
							for($cu=0;$cu<count($commonvalue);$cu++){
								$common_user_auth_code = $commonvalue[$cu];
								$first_rater_score = get_total_rating_of_raters_h($category_id,$assignment_id,$first_raters_fulldetails->auth_code,$common_user_auth_code);
								$second_rater_score = get_total_rating_of_raters_h($category_id,$assignment_id,$second_raters_fulldetails->auth_code,$common_user_auth_code);
								
								if(isset($first_rater_score) && $first_rater_score>0 && isset($second_rater_score) && $second_rater_score>0 && $first_rater_score==$second_rater_score){
									
								$no_of_aggreements++;}
							}
							
						
						}
						//$first_raters_total_score = get_total_rating_of_raters($assignment_id,$first_raters_fulldetails->auth_code);
						
						echo 'Rater '.$element_arr1[1].' ('.$first_raters_fulldetails->auth_code.$first_rater_name.') vs. Rater '.$element_arr2[1].' ('.$second_raters_fulldetails->auth_code.$second_rater_name.')';
						?></td>
					<td>
					 	<?php echo $overall_total_observation[] = $total_observation;?>
					</td>
					<td><?php echo $no_of_aggreements_arr[] = $no_of_aggreements;?></td>
					<td><?php echo $agreement = @round(($no_of_aggreements/$total_observation)*100,0);?>%</td>
					<td><?php //&& $agreement <=100

			if($agreement>80) { echo "Very good";}

			else if($agreement>60 && $agreement<=80) { echo "Good"; }

			else if($agreement>40 && $agreement<=60) { echo "Moderate"; }

			else if($agreement>20 && $agreement<=40) { echo "Fair"; }

			else if($agreement>=0 && $agreement<=20) {  echo "Poor";}

			?></td>
				</tr>
			<?php } ?>
			 
		<?php } ?>
			
			<tr style="font-weight:bold; font-size:17px;">
				<td colspan="2">Overall</td>
				<td><?php echo $grand_totalObs = array_sum($overall_total_observation);?></td>
				<td><?php echo $total_match = array_sum($no_of_aggreements_arr);?></td>
				<td><?php echo $agreement_final = @round(($total_match/$grand_totalObs)*100,0);?>%</td>
				<td><?php //&& $agreement <=100

			if($agreement_final>80) { echo "Very good";}

			else if($agreement_final>60 && $agreement_final<=80) { echo "Good"; }

			else if($agreement_final>40 && $agreement_final<=60) { echo "Moderate"; }

			else if($agreement_final>20 && $agreement_final<=40) { echo "Fair"; }

			else if($agreement_final>=0 && $agreement_final<=20) {  echo "Poor";}

			?></td>
			</tr>
		
		<?php }else{ ?>
			
			<tr>
				<td colspan="6">No ratings made yet</td>
			</tr>
		
		<?php } ?>
		 
</table>

<div style="line-height:25px;">
<span style="color:#CA0B00; font-weight:bold;">Disclaimer:</span> These calculations are based on consensus estimates by adding up the number of scoring categories on the rating scale divided by the total number of scoring categories across cases to include the calculation of agreement. AMEE assumes no responsibility for the accuracy of the results above. You are advised to verify all reliability figures with an independent authority (e.g. a calculator) before incorporating them into any publication or presentation. To receive pairwise percentage agreement, Fleiss, Kappa, Cohen's Kappa, or Krippendorff's Alpha on average scores, download the(CSV) excel file of your data results located on this page and upload your results at ReCal by Deen Free on <u><a href="http://dfreelon.org/utils/recalfront/" target="_blank">http://dfreelon.org/utils/recalfront/</a></u>. Choose ReCal2 for 2 raters and ReCal3 for multiple raters.
</div>

</div>