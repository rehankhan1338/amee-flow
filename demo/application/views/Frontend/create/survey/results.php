<div id="survey_reports" class="subcontent margin20" >
<div class="col-md-123">
	<div class="contenttitle2 nomargintop">
		<h3> Survey Results</h3>
	</div>
	<div class="clearfix"></div>

<script src="<?php echo base_url();?>assets/frontend/js/canvasjs.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>	
<script type="text/javascript">

function apply_cross_tabulation(question_id,ques_type){
	var filter_question_id = jQuery('#filter_cross_tabulation').val();
	if(filter_question_id!=''){
		if(question_id!='' && ques_type!=''){
			window.location='<?php echo base_url();?>department/create/survey/management?tab_id=4&survey_id=<?php echo $_GET['survey_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&question_id='+question_id+'&ques_type='+ques_type+'&fques_id='+filter_question_id;
		}
	}else{
		alert('Please select at least one cross tabulation question.');
	}
}

function download_res_tbl(){
	var data = document.getElementById('table_recordtbl_trend');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "survey-result.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
	});
}
</script>	
	 
	<div class="row manage_filter">
		<div class="instructions"><strong>Instructions: </strong>Select a question first then you can cross tabulate.</div>
		<div class="col-md-12">
			<div class="col-md-12"><span style="font-weight:600;">Cross Tabulation:&nbsp;&nbsp;</span>
  				<select class="form-control" id="filter_cross_tabulation" name="filter_cross_tabulation" style="display:inline-block; width:60%;">
					<option value="">--select--</option>
					<?php if(isset($_GET['question_id']) && $_GET['question_id']!='' && isset($_GET['ques_type']) && ($_GET['ques_type']==1 || $_GET['ques_type']==2)){?>
						<?php $demography_ques = get_survey_questions_details_for_demography($_GET['question_id'],$_GET['survey_id'], $_GET['dept_id']); ?>
						<?php foreach($demography_ques as $dg_ques){ ?>		
							<option value="<?php echo $dg_ques->question_id;?>" <?php if(isset($_GET['fques_id']) && $_GET['fques_id']==$dg_ques->question_id){?> selected="selected" <?php } ?>><?php echo 'Q'.$dg_ques->priority.' - '.$dg_ques->question_title;?></option>
						<?php } ?>
					<?php } ?>
				</select>
				<a class="btn btn-default" onclick="return apply_cross_tabulation('<?php if(isset($_GET['question_id']) && $_GET['question_id']!=''){echo $_GET['question_id'];}?>','<?php if(isset($_GET['ques_type']) && $_GET['ques_type']!=''){echo $_GET['ques_type'];}?>');" style="padding:5px 15px; margin-left:5px; vertical-align:top;"><i class="fa fa-filter" aria-hidden="true"></i> Add Filter </a>
			</div>	
		</div>
	</div>	
	
	<div class="row survey_results">
	
		<div class="col-md-3 result_left_side" >
		
			<?php $i=1; foreach($survey_questions_details as $questions_details){ ?>
					
				<a href="<?php echo base_url();?>department/create/survey/management?tab_id=4&survey_id=<?php echo $_GET['survey_id'];?>&dept_id=<?php echo $_GET['dept_id'];?>&question_id=<?php echo $questions_details->question_id;?>&ques_type=<?php echo $questions_details->question_type;?>">
					<div class="col-md-12 left_side_que <?php if(isset($_GET['question_id']) && $_GET['question_id']==$questions_details->question_id){ echo 'que_selected';}?>">
						<h4><?php echo 'Q'.$i.' - '.ucfirst($questions_details->question_title); ?></h4>
					</div>
				</a>
				
			<?php $i++; } ?>
		
		</div>
		<div class="col-md-9 result_right_side" >
		
		
<?php if(isset($_GET['fques_id']) && $_GET['fques_id']!='' && isset($_GET['question_id']) && $_GET['question_id']!=''){ 

		include(APPPATH.'views/Frontend/create/survey/cross_tabulation_result.php');
 
}else{ 

if(isset($_GET['question_id']) && $_GET['question_id']!=''){ 

$question_id=$_GET['question_id']; 
$question_fulldetails = get_survey_question_fulldetails_h($question_id);
 
if(isset($question_fulldetails->question_type) && ($question_fulldetails->question_type==1 || $question_fulldetails->question_type==7)){ 
$get_choics	= get_choics_of_multiple_type_question($question_id);

$r=1;
foreach($get_choics as $choics){

	$choice_count = get_choice_survey_result_count_by_choice_id_h($choics->answer_id,$question_id);
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
		interval: 1,
		labelWrap: false
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
<table class="table table-hover table-bordered table-striped" id="table_recordtbl_trend">
	<thead>
		<tr class="trbg">
			<th width="3%">#</th>
			<th>Field</th>
			<th>Count</th>
			<th>Percentage</th>
		</tr>
		</thead>
		<tbody>
		<?php $all_choice_count = get_all_choice_survey_result_count_by_question_id_h($question_id);
		
		$kl=1;foreach($get_choics as $choics){
		
			$choice_count = get_choice_survey_result_count_by_choice_id_h($choics->answer_id,$question_id);
			
			if($all_choice_count>0){
				$percentage = round(($choice_count*100)/$all_choice_count,2);
			}else{
				$percentage = 0;
			}
			
			?>
		 
			<tr>
				<td><?php echo $kl;?></td>
				<td class="nfw600"><?php echo $choics->answer_choice;?></td>
				<td><?php echo $choice_count;?></td>
				<td><?php echo $percentage;?>%</td>
			</tr>	
			
		<?php $kl++;} ?>
			
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();">Download Table as Image</button>
</div>
<?php }

if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==2){
$testing='';

$color_set = array('#485b79','#fb9337','#f6e4a5','#4C9CA0','#AE7D99','#C9D45C','#5592AD','#DF874D','#52BCA8','#8E7AA3','#E3CB64','#C77B85','#C39762','#8DD17E','#B57952','#FCC26C"','#8CA1BC','#36845C','#017E82','#8CB9D0','#708C98','#94838D','#F08891','#0366A7','#008276','#EE7757','#E5BA3A','#F2990B','#03557B','#782970');
$get_column	= get_choics_of_multiple_column($question_fulldetails->question_id);
$get_rows = get_choics_of_multiple_rows($question_fulldetails->question_id);
$jk=0;
foreach($get_rows as $rows){
		$dataPoints=array();
		$testing.='{
			type: "bar",
			showInLegend: true,
			name: "'.$rows->choices.'",
			color: "'.$color_set[$jk].'",
			dataPoints: ';
			foreach($get_column as $column){
				 
					$choics_count_survey_of_matrix = get_choics_count_survey_of_matrix_question_h($question_fulldetails->question_id,$rows->row_id,$column->row_id);
					$dataPoints[] = array("y" => $choics_count_survey_of_matrix, "label" => $column->choices);
				
			}
		$json_file=json_encode($dataPoints, JSON_NUMERIC_CHECK);
		$testing.=$json_file.'},';
	$jk++;	
 }
  ?> 
<script type="text/javascript">
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportFileName: "Chart",
	exportEnabled: true,
	theme: "theme1",
	title:{
		text: "Q<?php if(isset($question_fulldetails->priority) && $question_fulldetails->priority>0){ echo $question_fulldetails->priority;}?> - <?php echo $question_fulldetails->question_title;?>"
	},
	axisY: {
		title: "Number of Responses"
	},
	legend: {
		cursor:"pointer",
		itemclick : toggleDataSeries
	},
	toolTip: {
		shared: true,
		content: toolTipFormatter
	},
	data: [<?php echo $testing; ?>]
});
chart.render();

function toolTipFormatter(e) {
	var str = "";
	var total = 0 ;
	var str3;
	var str2 ;
	for (var i = 0; i < e.entries.length; i++){
		var str1 = "<span style= \"color:"+e.entries[i].dataSeries.color + "\">" + e.entries[i].dataSeries.name + "</span>: <strong>"+  e.entries[i].dataPoint.y + "</strong> <br/>" ;
		total = e.entries[i].dataPoint.y + total;
		str = str.concat(str1);
	}
	str2 = "<strong>" + e.entries[0].dataPoint.label + "</strong> <br/>";
	str3 = "<span style = \"color:Tomato\">Total: </span><strong>" + total + "</strong><br/>";
	return (str2.concat(str)).concat(str3);
}

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else {
		e.dataSeries.visible = true;
	}
	chart.render();
}

}
</script>
 
<div id="chartContainer"></div>
<div style="position: absolute; display: block; margin-top: 41%; width:97%;">
<table class="table table-hover table-bordered table-striped" id="table_recordtbl_trend">
	<thead>
		<tr class="trbg">
			<th width="3%">#</th>
			<th>Field</th>
			<?php //$get_column = get_choics_of_multiple_column($question_fulldetails->question_id); 
			foreach($get_column as $column){?>
					<th  style="font-weight:600;"><?php echo $column->choices; ?></th>
			<?php } ?>
		</tr>
	</thead>
 	<tbody>
		<?php $kl=1; //$get_rows	= get_choics_of_multiple_rows($question_fulldetails->question_id);
			foreach($get_rows as $rows){
			$choics_all_count_survey_of_matrix = get_all_choics_count_survey_of_matrix_question_h($question_fulldetails->question_id,$rows->row_id);
				?>
				<tr style="border-top:1px solid #dedede;">	
					<td><?php echo $kl;?></td>
					<td style="font-weight:600;"><?php echo $rows->choices; ?></td>

					<?php foreach($get_column as $column){
						$choics_count_survey_of_matrix = get_choics_count_survey_of_matrix_question_h($question_fulldetails->question_id,$rows->row_id,$column->row_id);
						$percentage = round(($choics_count_survey_of_matrix*100)/$choics_all_count_survey_of_matrix,2);
					?>
						<td style="vertical-align:middle;"><?php echo round($percentage,2).'%';?><span style="font-weight:bold; margin-left:15px;">(<?php echo $choics_count_survey_of_matrix;?>)</span></td>
					<?php } ?>
				</tr>
		<?php $kl++;} ?>
	</tbody>
</table>
<button class="btn btn-primary pull-right" onclick="return download_res_tbl();">Download Table as Image</button>
</div>
<?php } ?>
	
<?php if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==3){?>

<table class="table table-hover table-bordered table-striped" id="table_recordtbl_trend">
	<thead>
		<tr class="trbg">
			<th class="nfw600">Q. <?php echo $question_fulldetails->question_title;?></th>
		</tr>
	</thead>
 	<tbody>
	<?php $authcode_listing = get_all_authcode_listing_h($_GET['survey_id'],$question_fulldetails->question_id);
		if(count($authcode_listing)>0){
			foreach($authcode_listing as $authcode_details){
			
				$auth_code = $authcode_details->auth_code;
				$auth_answer = get_all_authcode_textbox_answer_listing_h($_GET['survey_id'],$question_fulldetails->question_id,$auth_code);
	?>
		<tr>
			<td><span class="nfw600"><?php echo $auth_code.' - ';?></span><?php echo $auth_answer;?></td>
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

<?php if(isset($question_fulldetails->question_type) && $question_fulldetails->question_type==4){
 
	$no_of_promoters = get_percentage_of_nps_status_h('promoters',$_GET['survey_id'],$question_fulldetails->question_id);
	$no_of_passives = get_percentage_of_nps_status_h('passives',$_GET['survey_id'],$question_fulldetails->question_id);
	$no_of_detractors = get_percentage_of_nps_status_h('detractors',$_GET['survey_id'],$question_fulldetails->question_id);
	$total = get_percentage_of_nps_status_h('',$_GET['survey_id'],$question_fulldetails->question_id);
	if($total>0){
		$nps_count = round((($no_of_promoters-$no_of_detractors)/$total)*100,2);
	}else{
		$nps_count = 0;
	}
	 
?>
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
	data: [{
		type: "doughnut",
		//startAngle: 60,
		//innerRadius: 60,
		indexLabelFontSize: 17,
		indexLabel: "{label} - #percent%",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
			{ y: <?php echo $no_of_promoters;?>, label: "Promoters (9-10)" },
			{ y: <?php echo $no_of_passives;?>, label: "Passives (7-8)" },
			{ y: <?php echo $no_of_detractors;?>, label: "Detractors (0-6)" }
		]
	}]
});
chart.render();

}
</script>	 
<div id="chartContainer"></div>	
<div style="position: absolute; display: block; margin-top: 41%; width:97%;"> 
	<div class="col-md-5"></div>
	<div class="col-md-2 nps_score">NPS Score<p><?php echo $nps_count;?></p></div>
	<div class="col-md-5"></div>
</div>
		 
<?php } ?>


<?php } } ?>
</div>		
	</div>
	
</div>
</div> 