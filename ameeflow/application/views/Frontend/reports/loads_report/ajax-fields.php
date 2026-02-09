<?php 
if(isset($reportDetailsArr['rId']) && $reportDetailsArr['rId']!=''){
    $rId = $reportDetailsArr['rId'];
    $erId = $reportDetailsArr['erId'];
}else{
    $rId = 0;
    $erId = '';
}
?>
<input type="hidden" id="rIdChk" name="rIdChk" value="<?php echo $rId;?>" />
<input type="hidden" id="erIdChk" name="erIdChk" value="<?php echo $erId;?>" />
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Term *</label>
        <select id="txt_termId" name="txt_termId" class="form-control required">
            <option value="">Select...</option>
            <?php $termOptions = $this->config->item('terms_assessment_array_config');
            foreach($termOptions as $key=>$value){ if($value['status']==0){?>
            <option value="<?php echo $key;?>" <?php if(isset($reportDetailsArr['termId']) && $reportDetailsArr['termId']==$key){?> selected<?php } ?>><?php echo $value['name'];?></option>
            <?php } } ?>
        </select>
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Year *</label>
        <input type="number" id="txt_year" name="txt_year" class="form-control number required" placeholder="" value="<?php if(isset($reportDetailsArr['year']) && $reportDetailsArr['year']!=''){echo $reportDetailsArr['year'];}?>" autocomplete="off" />
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Courses/Programs * </label>
        <textarea id="courseProgram" name="courseProgram" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['courseProgram']) && $reportDetailsArr['courseProgram']!=''){echo $reportDetailsArr['courseProgram'];}?></textarea>        
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Strengths *</label>
        <textarea id="strengths" name="strengths" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['strengths']) && $reportDetailsArr['strengths']!=''){echo $reportDetailsArr['strengths'];}?></textarea>
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Areas for Improvement *</label>
        <textarea id="areaImprovement" name="areaImprovement" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['areaImprovement']) && $reportDetailsArr['areaImprovement']!=''){echo $reportDetailsArr['areaImprovement'];}?></textarea>
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Immediate Next Steps *</label>
        <textarea id="imdtNextStep" name="imdtNextStep" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['imdtNextStep']) && $reportDetailsArr['imdtNextStep']!=''){echo $reportDetailsArr['imdtNextStep'];}?></textarea>
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Recommendations for Faculty & Programs *</label>
        <textarea id="recdProgram" name="recdProgram" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['recdProgram']) && $reportDetailsArr['recdProgram']!=''){echo $reportDetailsArr['recdProgram'];}?></textarea>        
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Planned Follow-Up *</label>
        <textarea id="planFollowup" name="planFollowup" placeholder="add details" rows="3" class="form-control required"><?php if(isset($reportDetailsArr['planFollowup']) && $reportDetailsArr['planFollowup']!=''){echo $reportDetailsArr['planFollowup'];}?></textarea>                
    </div>    	 
</div> 