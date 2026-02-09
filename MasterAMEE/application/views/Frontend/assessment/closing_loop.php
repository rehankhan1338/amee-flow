<?php if(count($ClosingLoopList)>0){ ?>
	<div class="col-md-12">
		<div class="bdr">
			<h2 style="text-align:center; text-transform:uppercase; font-weight:600; padding:10px 0">Appendix I - Closing the loop</h2>
			<?php $ar = 1;foreach($ClosingLoopList as $loop){ ?>	
				
				<h4><?php echo $loop['year'].' - '.$loop['yearTitle'];?></h4>			
				<table class="table table-striped12 table-bordered" id="table_recordtbl12">
					<tbody>
						<?php for($ind=1;$ind<=3;$ind++){
							$lable_status=$ind;			
							$indicatorsOptionsArr = filter_array_chk_two($closing_loop_data_arr,$ind,'IndicatorId',$loop['loopId'],'loopId');
							if(count($indicatorsOptionsArr)>0){			
						?>
							<tr style="background:#eee; color:#000; font-weight:600;">
								<td colspan="2"><?php if($lable_status==1){echo 'Program Curriculum';}else if($lable_status==2){echo 'Academic Processes';}else{echo 'Evaluation Plan';}?></td> 
							</tr>
							<?php foreach($indicatorsOptionsArr as $indi){?>
								<tr>
									<td width="45%"><?php $indMas = filter_array_chk($indicatorMasters,$indi['indiOptId'],'id');
									 echo $indMas[0]['heading_label'];?></td>
									<td><?php echo $indi['year_value'];?></td>
								</tr>
							<?php } } ?>
						<?php } ?>
					</tbody>
				</table>			
			
			<?php $ar++; } ?>
		</div>
	</div>
<?php } ?>