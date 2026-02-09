<section class="content">
	 <div class="box">
<style>
.progress{  border-radius:25px;}
.progress-bar{color: #000;    font-size: 16px;}
.avg{ border:1px dashed #333; padding:10px 60px ; text-align:center; line-height:25px; font-size:18px; }
</style>
		<div class="box-body row">
			<div class="col-md-12">
				<?php 
				
				$suggestion_box_satisfied_options = $this->config->item('suggestion_box_satisfied_options_array_config');
				
 				 	$avgGivenOptions = array();
					$avgCount = array();
				 ?>
			
				<h4>Total No. of Suggestion Received by User: <strong><?php echo count($getSuggestionsArr);?></strong></h4>
				
				<table class="table table-striped" style="margin-top:15px;">
				<?php 
				foreach($suggestion_box_satisfied_options as $key => $value){
				
					$res = count(filter_array($getSuggestionsArr,$key,'satisfiedOptionId'));
					if($res>0){
						$avgGivenOptions[] = 1;
						$avgCount[] = $res*$value['calNo'];
					}
					$per = ($res*100)/count($getSuggestionsArr);
					
				?>
				
					<tr>
						<td width="25%" style="font-weight:600;"><?php echo $value['name'];?></td>
						<td>
							<div class="progress">
							  <div class="progress-bar progress-bar-warning  progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%"><?php echo $res;?>
							  </div>
							</div>
						</td>
						<td width="10%" style="font-weight:600;"><?php echo $per.'%';?></td>
					</tr>
					<?php } ?>
				</table>
				
				<label class="avg">Average<br /><strong><?php echo array_sum($avgCount)/array_sum($avgGivenOptions);?></strong></label>
				
			</div>
		</div>
	</div>
</section>