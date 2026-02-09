<?php 
if(isset($ceDetailsArr['ceId']) && $ceDetailsArr['ceId']!=''){
    $ceId = $ceDetailsArr['ceId'];
    $oldCurFile = $ceDetailsArr['ceFileName'];
}else{
    $ceId = 0;
    $oldCurFile = '';
}
?>
<input type="hidden" id="txtceId" name="txtceId" value="<?php echo $ceId;?>" />
<input type="hidden" id="txtoldCurFile" name="txtoldCurFile" value="<?php echo $oldCurFile;?>" />
<div class="col-12 form-fields">
    <label class="form-label">Term *</label>
    <select id="maTermId" name="maTermId" class="form-control required">
        <option value="">Select...</option>
        <?php $termOptions = $this->config->item('terms_assessment_array_config');
        foreach($termOptions as $key=>$value){ if($value['status']==0){?>
        <option value="<?php echo $key;?>" <?php if(isset($ceDetailsArr['termId']) && $ceDetailsArr['termId']==$key){?> selected<?php } ?>><?php echo $value['name'];?></option>
        <?php } } ?>
    </select>
</div>
<div class="col-12 form-fields">
    <label class="form-label">Year *</label>
    <input type="text" id="maYear" name="maYear" class="form-control number required" placeholder="" value="<?php if(isset($ceDetailsArr['year']) && $ceDetailsArr['year']!=''){echo $ceDetailsArr['year'];}?>" autocomplete="off" />
</div>
<div class="col-12 form-fields mt-3">
    <!-- <label class="form-label">Add your file *</label> <br /> -->
    <input type="file" id="curFile" name="curFile" class="required" />
</div>