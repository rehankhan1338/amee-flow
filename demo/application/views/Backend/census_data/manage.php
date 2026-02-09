<?php if(validation_errors() != false) { echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>';  } ?>
<div class="box-body">
	<div id="result_display"></div>
		<div class="col-md-12 plpr">
			<div class="instructions"><strong>Instructions:</strong> Select the year to enter data. Only provide whole numbers.</div>
		</div>
		<?php if(count($masterCensusFormData)>0){ ?>
		<div class="col-md-12 plpr">
			<div class="form-group">
				<label class="control-label">Year *</label>
				<select class="form-control required" id="censusYear" name="censusYear" style="width:50%;">
					<option value="">Select Year</option>
					<?php for($ayr=2021;$ayr<=2025;$ayr++){?>
						<option value="<?php echo $ayr;?>" <?php if(isset($censusYearData->year) && $censusYearData->year==$ayr){?> selected="selected"<?php } ?>><?php echo $ayr;?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label class="control-label">Total Participants is: *</label>
				<input type="number" class="form-control number required" id="totalPart" name="totalPart" style="width:50%;" placeholder="" value="<?php if(isset($censusYearData->totalPart) && $censusYearData->totalPart!=''){echo $censusYearData->totalPart;}?>" autocomplete="off" />
			</div>
		</div>
		 
		<?php 					
		$census_categories_data = $this->config->item('census_categories_data_config');
		foreach($census_categories_data as $key => $value){					
		?>
		<div class="col-md-12 plpr"><h4><strong><?php echo $value['name'];?> &ndash;</strong></h4></div>
		
		<?php
		$masterCensusFormDataArr = filter_array_chk_two($masterCensusFormData,$key,'catId','0','parentId');
		foreach($masterCensusFormDataArr as $censusData){
		
		$masterCensusFormOptionsDataArr = filter_array_chk($masterCensusFormData,$censusData['indicatorId'],'parentId');
		?>
		
		<?php if(count($masterCensusFormOptionsDataArr)==0){
			
			$fsts = '';
			if(isset($censusYearData->censusId) && $censusYearData->censusId!=''){
				$res = filter_array_chk_two($censusOptionsData,$censusData['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
				if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){$fsts = $res[0]['indicatorAns'];}
			}
				 
				?>
		
			<div class="col-md-6 plpr">
				<input type="hidden" id="indicatorIds[]" name="indicatorIds[]" value="<?php echo $censusData['indicatorId'].'|'.$censusData['catId'];?>" />
				<div class="form-group">
					<label class="control-label"><?php echo $censusData['indicatorTitle'];?></label>
					<input type="number" class="form-control number" id="indicator_<?php echo $censusData['indicatorId'];?>" name="indicator_<?php echo $censusData['indicatorId'];?>" placeholder="" value="<?php echo $fsts;?>" autocomplete="off" />							
				</div>
			</div>
		
		<?php }else{?>
		
			<div class="flDiv">
				<h4><?php echo $censusData['indicatorTitle'];?> &ndash;</h4>
				<div class="flDiv">
				<?php foreach($masterCensusFormOptionsDataArr as $options){
					
					$MoreOptionsArr = filter_array_chk($masterCensusFormData,$options['indicatorId'],'parentId');
					if(count($MoreOptionsArr)==0){
					
						$ssts = '';
						if(isset($censusYearData->censusId) && $censusYearData->censusId!=''){
							$res = filter_array_chk_two($censusOptionsData,$options['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
							if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){$ssts = $res[0]['indicatorAns'];}
						}
				?>
					
					<div class="col-md-3 plpr">
						<input type="hidden" id="indicatorIds[]" name="indicatorIds[]" value="<?php echo $options['indicatorId'].'|'.$options['catId'];?>" />
						<div class="form-group">
							<label class="control-label"><?php echo $options['indicatorTitle'];?></label>
							<input type="number" class="form-control number" id="indicator_<?php echo $options['indicatorId'];?>" name="indicator_<?php echo $options['indicatorId'];?>" placeholder="" value="<?php echo $ssts;?>" autocomplete="off" />							
						</div>
					</div>
					
				<?php }else{ ?>
					
					<h4><?php echo $options['indicatorTitle'];?> &ndash;</h4>
					<div class="flDiv">
					<?php foreach($MoreOptionsArr as $moreOptions){
						$tsts = '';
						if(isset($censusYearData->censusId) && $censusYearData->censusId!=''){
							$res = filter_array_chk_two($censusOptionsData,$moreOptions['indicatorId'],'indicatorId',$censusYearData->censusId,'censusId');
							if(isset($res[0]['indicatorAns']) && $res[0]['indicatorAns']!=''){$tsts = $res[0]['indicatorAns'];}
						}
					?>
						<div class="col-md-2 plpr">
							<input type="hidden" id="indicatorIds[]" name="indicatorIds[]" value="<?php echo $moreOptions['indicatorId'].'|'.$moreOptions['catId'];?>" />
							<div class="form-group">
								<label class="control-label"><?php echo $moreOptions['indicatorTitle'];?></label>
								<input type="number" class="form-control number" id="indicator_<?php echo $moreOptions['indicatorId'];?>" name="indicator_<?php echo $moreOptions['indicatorId'];?>" placeholder="" value="<?php echo $tsts;?>" autocomplete="off" />							
							</div>
						</div>
					<?php } ?>
						<div class="clearfix"></div> 
					</div>
				<?php } } ?>
				</div>
				<div class="clearfix"></div> 
			</div>
		<?php } } ?>
		<div class="clearfix"></div> 
		<hr class="hr" />
		<?php } } ?>
	
	
	<div class="clearfix"></div> 
</div>