<div class="survey_results">
<script src="<?php echo base_url();?>assets/frontend/js/canvasjs.min.js"></script>
<?php 
$assignment_id = $_GET['ar_id'];

$courses_assginment_listing = get_courses_assginment_listing_h($assignment_id);

$words = $courses_assginment_listing; 
$num = count($words); 
$total = pow(2, $num);
 
$result_single=array();
$result_double=array();
for ($i = 0; $i < $total; $i++) {  

	$result	=array();
    for ($j = 0; $j < $num; $j++) { 

        if (pow(2, $j) & $i){  $result[]= $words[$j]; }     

    } 
	if(isset($result) && $result!=''){
		if(count($result)==1){
			$result_single[] = implode(',',$result);
		}else{
			if(count($result)>0){$result_double[] = implode(',',$result);}
		}
	}
}

?>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();" style="margin-bottom:10px; margin-top:-50px; ">Download as Image</button>
<table class="table table-hover table-bordered table-striped" id="assignment_section_tbl">
	<thead>
		<tr class="trbg">
			<th width="3%">#</th>
			<th>Courses</th>
			<th>Count</th>
			<th>Percentage</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		$all_choice_count = get_all_courses_assignment_result_count_by_couses_id_h($assignment_id);
		
		if(count($result_single)>0){
 		
		for($kl=0;$kl<count($result_single);$kl++){
		
			$course_id=trim($result_single[$kl]);
			$choice_count = get_courses_assingment_result_count_by_couses_id_h($course_id,$assignment_id);
			
			if($all_choice_count>0){
				$percentage = round(($choice_count*100)/$all_choice_count,2);
			}else{
				$percentage = 0;
			}
			
			?>
		 
			<tr>
				<td><?php echo $kl+1;?></td>
				<td style="font-weight:600;"><?php  
				$courses_fulldetails = get_all_assgingment_courses_fulldetails_by_couses_id_h($course_id);
				 echo $courses_fulldetails->course_enrolled;?></td>
				<td><?php echo $choice_count;?></td>
				<td><?php echo $percentage;?>%</td>
			</tr>	
			
		<?php } } if(count($result_double)>0){ 
			
			for($dkl=0;$dkl<count($result_double);$dkl++){
			
				$course_ids=trim($result_double[$dkl]);
				$course_ids_arr = explode(',',$course_ids);
				
				$choice_count = get_courses_assingment_result_count_by_couses_id_h($course_ids,$assignment_id);
			
				if($all_choice_count>0){
					$percentage = round(($choice_count*100)/$all_choice_count,2);
				}else{
					$percentage = 0;
				}
			?>
		
			<tr>
				<td><?php echo ($dkl+1)+$kl;?></td>
				<td style="font-weight:600;"><?php  
				for($cou=0;$cou<count($course_ids_arr);$cou++){
 					 $courses_fulldetails = get_all_assgingment_courses_fulldetails_by_couses_id_h($course_ids_arr[$cou]);
				 	 echo $courses_fulldetails->course_enrolled;
					 if($cou<count($course_ids_arr)-1){
					 	echo ' / ';
					 }
				}
			?></td>
				<td><?php echo $choice_count;?></td>
				<td><?php echo $percentage;?>%</td>
			</tr>
		
		<?php } } ?>
			
	</tbody>
</table>

</div>