<?php 
if(isset($proDetailsArr['projectId']) && $proDetailsArr['projectId']!=''){
    $projectId = $proDetailsArr['projectId'];
}else{
    $projectId = 0;
}
?>
<input type="hidden" id="maProjectId" name="maProjectId" value="<?php echo $projectId;?>" />
<div class="col-12 form-fields">
    <label class="form-label">Project Name/Title *</label>
    <input type="text" id="maProName" name="maProName" class="form-control required" placeholder="Add Title Here" value="<?php if(isset($proDetailsArr['projectName']) && $proDetailsArr['projectName']!=''){echo $proDetailsArr['projectName'];}?>" autocomplete="off" />
</div>
<div class="col-12 form-fields">
    <label class="form-label">Term *</label>
    <select id="maTermId" name="maTermId" class="form-control required">
        <option value="">Select...</option>
        <?php $termOptions = $this->config->item('terms_assessment_array_config');
        foreach($termOptions as $key=>$value){ if($value['status']==0){?>
        <option value="<?php echo $key;?>" <?php if(isset($proDetailsArr['termId']) && $proDetailsArr['termId']==$key){?> selected<?php } ?>><?php echo $value['name'];?></option>
        <?php } } ?>
    </select>
</div>
<div class="col-12 form-fields">
    <label class="form-label">Year *</label>
    <input type="text" id="maYear" name="maYear" class="form-control number required" placeholder="" value="<?php if(isset($proDetailsArr['year']) && $proDetailsArr['year']!=''){echo $proDetailsArr['year'];}?>" autocomplete="off" />
</div>