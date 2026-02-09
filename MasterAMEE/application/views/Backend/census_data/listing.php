<style>
.plpr{ padding-left:5px; padding-right:5px;}
.plprIn{padding-left:20px; padding-right:10px;}
.btn{padding: 5px 15px; font-size:15px; vertical-align:top; width:100%;}
hr{ border-top:1px dashed #888;}
</style>
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
<script src="https://bravofolio.com/assets/backend/js/canvasjs.min.js"></script>
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/departments/delete?id='+val;
 		} 
 	}
} 
function fetchYearRes(yr){
	if(yr!=''){
		window.location = '<?php echo base_url().'admin/census_data/?yr=';?>'+yr;
	}
}
function getCensusYearData(){
	var yearDrop = $('#yearDrop').val();
	var catDrop = $('#catDrop').val();
	if(yearDrop!='' && catDrop!=''){
		window.location = '<?php echo base_url().'admin/census_data?yr=';?>'+yearDrop+'&cid='+catDrop;
	}else{
		alert('Please select year and category first.');
	}
}
</script>
<section class="content">
<div class="box" style="padding:20px;"> 
	
	<div class="row">
		<div class="col-md-2 plpr">
			<select class="form-control required" id="yearDrop">
				<option value="">Select Year...</option>
				<?php for($ayr=2021;$ayr<=2025;$ayr++){?>
				<option value="<?php echo $ayr;?>" <?php if(isset($year) && $year==$ayr){?> selected="selected"<?php } ?>><?php echo $ayr;?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-2 plpr">
			<?php $census_categories_data = $this->config->item('census_categories_data_config');?>
			<select class="form-control required" id="catDrop">
				<option value="">Select Category...</option>
				<?php foreach($census_categories_data as $key => $value){?>
				<option value="<?php echo $key;?>" <?php if(isset($catId) && $catId==$key){?> selected="selected"<?php } ?>><?php echo $value['name'];?></option>
				<?php } ?>
			</select>
		</div>
		<div class="col-md-1 plpr">
			<button class="btn btn-primary" onclick="return getCensusYearData();">View</button>
		</div>
		<?php if(isset($year) && $year!='' && isset($catId) && $catId!='' && count($censusOptionsData)>0){?>
		<div class="col-md-2 plpr">
			<a href="<?php echo base_url();?>admin/census_data/edit/<?php echo $censusYearData->censusId;?>" class="btn btn-default">Edit <?php echo $year;?> Data</a>
		</div>
		<div class="col-md-2 plpr">
			<a onclick="return confirm('Are you sure want to delete <?php echo $year;?> data?');" href="<?php echo base_url();?>admin/census_data/delete/<?php echo $censusYearData->censusId;?>" class="btn btn-danger">Delete <?php echo $year;?> Data</a>
		</div>
		<?php } ?>
	</div>        
  <!-- start body div -->
	<?php if(isset($year) && $year!='' && isset($catId) && $catId!='' && count($censusOptionsData)>0){
		$totalPart = $censusYearData->totalPart;
	?>
	<div class="box-body row">
		<h4 class="trbg" style="padding:10px 20px;">Total Participants is: <?php echo $totalPart;?></h4>
		<div class="col-md-12">
		<?php
		$graphPoints = array();
		$masterCensusArr = filter_array_chk_two($masterCensusData,$catId,'catId','0','parentId');
		foreach($masterCensusArr as $censusData){
					
			$masterCensusFormOptionsDataArr = filter_array_chk($masterCensusData,$censusData['indicatorId'],'parentId');
			echo '<h4>'.$censusData['indicatorTitle'].'</h4>';
			if(count($masterCensusFormOptionsDataArr)==0){
 				
				$res = filter_array_chk_two($censusOptionsData,$censusData['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
				if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){
					echo '&mdash; '.$res[0]['indicatorAns'];
					$graphPoints[] = $res[0]['indicatorAns'].'||'.$censusData['indicatorTitle'].'||'.$censusData['indLegend'];
				}else{
					echo '&mdash; 0';
				}
 				
 			}else{
			
				$graphPoints = array();
				?><div class="col-md-12"><?php
				foreach($masterCensusFormOptionsDataArr as $options){
					
					$MoreOptionsArr = filter_array_chk($masterCensusData,$options['indicatorId'],'parentId');
				?>	
					<div class="col-md-12 plprIn">
					<label style="font-size:16px;"><?php echo $options['indicatorTitle'];?></label>
					<?php if(count($MoreOptionsArr)==0){
					
						$res = filter_array_chk_two($censusOptionsData,$options['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
						if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){
							echo '&mdash; <b>['.$res[0]['indicatorAns'].']</b>';
							$graphPoints[] = $res[0]['indicatorAns'].'||'.$options['indicatorTitle'];
						}else{
							echo '&mdash; <b>[0]';
						}
							
					}else{
						$graphMorePoints = array();
						foreach($MoreOptionsArr as $moreOptions){ ?>
							<div class="col-md-12 plprIn">
								<label style="font-size:16px;"><?php echo $moreOptions['indicatorTitle'];?></label>
								<?php $res = filter_array_chk_two($censusOptionsData,$moreOptions['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
								if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){
									echo '&mdash; <b>['.$res[0]['indicatorAns'].']</b>';
									$graphMorePoints[] = $res[0]['indicatorAns'].'||'.$moreOptions['indicatorTitle'];
								}else{echo '&mdash; <b>[0]';}?>
							</div>
							<div class="clearfix"></div>
						<?php } 
if(count($graphMorePoints)>0){?>
<div id="demoMoreChart<?php echo $options['indicatorId'];?>" style="height: 380px; width: 100%;"></div>	
<?php					 
	$dataMorePoints=array();
	foreach($graphMorePoints as $gmIndex){
		$gmIndexArr = explode('||',$gmIndex);
		$mper = round((($gmIndexArr[0]/$totalPart)*100));
		$dataMorePoints[] = array("y" => $mper, "label" => $gmIndexArr[1]);
	}
	$plotGraph = json_encode($dataMorePoints, JSON_NUMERIC_CHECK);						
?>						 
<script>
var chartMore<?php echo $options['indicatorId'];?> = new CanvasJS.Chart("demoMoreChart<?php echo $options['indicatorId'];?>", {
	animationEnabled: true,
	theme: "light2",
	backgroundColor: "#f9f9f9",
	exportFileName: "<?php echo $options['indicatorTitle'].' - '.$year;?>",
	exportEnabled: true,
	colorSet: "customColorSet",
	title: {
		text: "<?php echo $options['indicatorTitle'].' - '.$year;?>",
		fontSize: 26,
		fontWeight: "500",
		margin: 10,
		padding: 10
	},
	data: [{
		type: "doughnut",
		indexLabel: "{label} [{y}%]",
		showInLegend: "true",
		startAngle: 90,
		toolTipContent: "<b>{label}</b>: {y}%",
 		legendText: "{label}",
		indexLabelFontSize: 16,
		dataPoints: <?php echo $plotGraph; ?>
	}]
});
chartMore<?php echo $options['indicatorId'];?>.render();
</script>
<?php } ?>
						
						<?php } ?>
					</div>
					<div class="clearfix"></div>
	<?php } ?>
	</div>
	<div class="col-md-12"><!-- 9 -->
	<?php if(count($graphPoints)>0){?>
	<div id="demoChart<?php echo $censusData['indicatorId'];?>" style="height: 380px; width: 100%;"></div>	
	<?php
	$dataPoints=array();
	foreach($graphPoints as $gIndex){
		$gIndexArr = explode('||',$gIndex);
		$per = round((($gIndexArr[0]/$totalPart)*100));
		$dataPoints[] = array("y" => $per, "label" => $gIndexArr[1]);
	}
	$testing=json_encode($dataPoints, JSON_NUMERIC_CHECK);
	?>
<script>
//CanvasJS.addColorSet("customColorSet",["#FF0000","#FFFF00","#FFA500","#52a929","#4169E1"]);
var chart<?php echo $censusData['indicatorId'];?> = new CanvasJS.Chart("demoChart<?php echo $censusData['indicatorId'];?>", {
	animationEnabled: true,
	theme: "light2",
	backgroundColor: "#f9f9f9",
	exportFileName: "<?php echo $censusData['indicatorTitle'].' - '.$year;?>",
	exportEnabled: true,
	colorSet: "customColorSet",
	title: {
		text: "<?php echo $censusData['indicatorTitle'].' - '.$year;?>",
		fontSize: 26,
		fontWeight: "500",
 		margin: 10,
		padding: 10
	},
	data: [{
		<?php if($censusData['indicatorId']==6 || $censusData['indicatorId']==9){?>
			type: "bar",
			indexLabel: "{y}%",
		<?php }else{ ?>
			type: "pie",
			indexLabel: "{label} [{y}%]",
			showInLegend: "true",
		<?php } ?>
		startAngle: 90,
		toolTipContent: "<b>{label}</b>: {y}%",
 		legendText: "{label}",
		indexLabelFontSize: 16,
		dataPoints: <?php echo $testing; ?>
	}]
});
chart<?php echo $censusData['indicatorId'];?>.render();
</script>				
				<?php } ?>
				</div>
				<div class="clearfix"></div>
				<?php
				
			}
		if($catId==1){ echo '<hr />';}
				
		}
		
		if($catId==2 || $catId==3){
			if($catId==2){ $exFileName = 'Acceptance Rates';}else{ $exFileName = 'Placement Rates';}
			if(isset($graphPoints[0]) && $graphPoints[0]!='' && isset($graphPoints[1]) && $graphPoints[1]!=''){
				
				 $gZeroArr = explode('||',$graphPoints[0]);
				 $gOneArr = explode('||',$graphPoints[1]);
				 $per = round((($gOneArr[0]/$gZeroArr[0])*100));
		 ?>
<div id="chartContainer" style="height: 500px; width:100%;" class="container1" ></div>
<script>
var chart = new CanvasJS.Chart("chartContainer", {
  theme: "light2",
  exportEnabled: true,
  exportFileName: "<?php echo $exFileName;?>",
  backgroundColor: "#f9f9f9",
  title:{
		text: <?php echo $per;?> + "% <?php echo $exFileName;?>",
		horizontalAlign: "center",
		verticalAlign: "center",
		maxWidth:210,
		fontColor: "#34445e",
		fontSize: 40,
		fontWeight: "500",
		wrap: true,
	},/*subtitles:[
		{
			text: "This is a Subtitle",
			horizontalAlign: "center",
			verticalAlign: "top",
			//Uncomment properties below to see how they behave
			//fontColor: "red",
			//fontSize: 30
		}
		],*/
  data: [{
    type: "doughnut",
    innerRadius: "70%",
	radius: '100%',
    dataPoints: [    
      { y: <?php echo $gZeroArr[0];?>, color: "#34445e", indexLabel: "<?php echo $gZeroArr[0].' '.$gZeroArr[2];?>", indexLabelFontColor: "#34445e", indexLabelFontSize: 20},
      { y: <?php echo $gOneArr[0];?>, color: "#fb9337", indexLabel: "<?php echo $gOneArr[0].' '.$gOneArr[2];?>", indexLabelFontColor: "#fb9337", indexLabelFontSize: 20 }
    ]
  }]
});
chart.render();
</script> 
					 <?php
				}
			}
		?>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		</div>
	</div>
	<?php } ?>   
</div>
</section>    