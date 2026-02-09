<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
function makeScreenshot(){
	$('#downloadBtn').html('Downloading <i class="fa fa-spinner fa-spin"></i>');
	var data = document.getElementById('knob-chart-div');
	html2canvas(data, {
		allowTaint: true,
		useCORS: true
	}).then(function(canvas){
		var link = document.createElement("a");
		document.body.appendChild(link);
		link.download = "<?php echo create_slug_ch($loop_details->yearTitle.' '.$loop_details->year);?>.jpg";
		link.href = canvas.toDataURL();
		link.target = '_blank';
		link.click();
		$('#downloadBtn').html('Download');
	});
	
}
</script>
<button class="btn btn-primary" onclick="return makeScreenshot();" id="downloadBtn">Download</button>
<div id="knob-chart-div" style="padding-top:10px;">
	<table class="table table-striped12 table-bordered" id="table_recordtbl12">
		<thead>
		<!--<tr class="trbg">
			<th style="vertical-align:middle;">Indicators</th>
			<th style="vertical-align:middle;">Value</th>
		</tr>--> 
		 </thead>
			<tbody>
				<?php for($ind=1;$ind<=3;$ind++){
					$lable_status=$ind;			
					$indicatorsOptionsArr = filter_array_chk($closing_loop_data_arr,$ind,'IndicatorId');			
				?>
					<tr style="background:#eee; color:#000; font-weight:600;">
						<td colspan="2"><?php if($lable_status==1){echo 'Program Curriculum';}else if($lable_status==2){echo 'Academic Processes';}else{echo 'Evaluation Plan';}?></td> 
					</tr>
					<?php foreach($indicatorsOptionsArr as $indi){?>
						<tr>
							<td><?php $indMas = filter_array_chk($indicatorMasters,$indi['indiOptId'],'id');
							 echo $indMas[0]['heading_label'];?></td>
							<td><?php echo $indi['year_value'];?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
	</table>
</div>