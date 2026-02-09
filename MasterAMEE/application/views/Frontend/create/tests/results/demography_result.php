<div class="row survey_results"> 
<script src="<?php echo base_url();?>assets/frontend/js/canvasjs.min.js"></script>		
		<div class="col-md-3 result_left_side" >
		
			<?php $i=1; foreach($dempgraphy_questions_detail as $questions_details){ ?>
					
				<a href="<?php echo base_url();?>department/create/tests/management?tab_id=7&test_id=<?php echo $_GET['test_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&view_result=demography&question_id=<?php echo $questions_details->question_id;?>&ques_type=<?php echo $questions_details->question_type;?>">
					<div class="col-md-12 left_side_que <?php if(isset($_GET['question_id']) && $_GET['question_id']==$questions_details->question_id){ echo 'que_selected';}?>">
						<h4><?php echo 'Q'.$i.' - '.ucfirst($questions_details->question_title); ?></h4>
					</div>
				</a>
				
			<?php $i++; } ?>
		
		</div>
		<div class="col-md-9 result_right_side">
		
<?php  

if(isset($_GET['question_id']) && $_GET['question_id']!=''){ 

$question_id=$_GET['question_id']; 

$question_fulldetails = get_test_question_fulldetails_h($question_id);
 
if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==1){ 

$get_choics	= get_choics_of_multiple_type_question_tests($question_id); 

$r=1;
foreach($get_choics as $choics){

	$choice_count = get_choice_test_result_count_by_choice_id_h($choics->answer_id,$question_id);
 	$dataPoints[] = array("y" => $choice_count, "label" => $choics->answer_choice);
	$r++;

}

?>    
<div id="chartContainer"></div> 

<script type="text/javascript">
 
window.onload = function () {
	
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "theme1",
	exportFileName: "Chart",
	exportEnabled: true,
	title:{
		text:"Q<?php if(isset($question_fulldetails->priority) && $question_fulldetails->priority>0){ echo $question_fulldetails->priority;}?> - <?php echo $question_fulldetails->question_title;?>"
	},
	axisX:{
		interval: 1
	},
	axisY2:{
		//interlacedColor: "rgba(1,77,101,.2)",
		//gridColor: "rgba(1,77,101,.1)",
		interlacedColor: "#ffffff",
		gridColor: "#ffffff",
		title: "Number of Responses"
	},
	data: [{
		type: "bar",
		name: "companies",
		axisYType: "secondary",
		color: "#485b79",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
  
}
 
</script>

<div style="position: absolute; display: block; margin-top: 41%; width:97%;">
<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg">
			<th width="5%">#</th>
			<th>Field</th>
			<th>Count</th>
			<th>Percentage</th>
		</tr>
		</thead>
		<tbody>
		<?php $all_choice_count = get_all_choice_test_result_count_by_question_id_h($question_id);
		
		$kl=1;foreach($get_choics as $choics){
		
			$choice_count = get_choice_test_result_count_by_choice_id_h($choics->answer_id,$question_id);
			
			if($all_choice_count>0){
				$percentage = ($choice_count*100)/$all_choice_count;
			}else{
				$percentage = 0;
			}
			
			?>
		 
			<tr>
				<td><?php echo $kl;?></td>
				<td style="font-weight:600;"><?php echo $choics->answer_choice;?></td>
				<td><?php echo $choice_count;?></td>
				<td><?php echo round($percentage,2);?>%</td>
			</tr>	
			
		<?php $kl++;} ?>
			
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();">Download Table as Image</button>
</div>
<?php } ?>
<?php if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==3){?>

<table class="table table-hover table-bordered table-striped" id="test_section_tbl">
	<thead>
		<tr class="trbg">
			<th class="nfw600">Q. <?php echo $question_fulldetails->question_title;?></th>
		</tr>
	</thead>
 	<tbody>
	<?php 
		if(count($tests_email_detail)>0){
			foreach($tests_email_detail as $authcode_details){
			
				$auth_code = $authcode_details->auth_code;
				$auth_answer = get_all_test_authcode_textbox_answer_listing_h($_GET['test_id'],$question_fulldetails->question_id,$auth_code);
	?>
		<tr>
			<td><span class="nfw600"><?php echo 'Answer '.$auth_code.' - ';?></span><?php echo $auth_answer;?></td>
		</tr>	
	<?php } }else{ ?>
		<tr>
			<td>-- no answer available --</td>
		</tr>
	<?php } ?>
	
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();">Download Table as Image</button>	
<?php } ?>

<?php } ?>
</div>		
	</div>