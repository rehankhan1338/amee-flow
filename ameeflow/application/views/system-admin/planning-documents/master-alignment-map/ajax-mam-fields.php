<?php 
if(isset($mamDetailsArr['mamId']) && $mamDetailsArr['mamId']!=''){
    $mamId = $mamDetailsArr['mamId'];
    $oldCurFile = $mamDetailsArr['curUploadedFile'];
}else{
    $mamId = 0;
    $oldCurFile = '';
}
?>
<input type="hidden" id="txtMamId" name="txtMamId" value="<?php echo $mamId;?>" />
<input type="hidden" id="txtoldCurFile" name="txtoldCurFile" value="<?php echo $oldCurFile;?>" />
<div class="col-12 form-fields">
    <!-- <label class="form-label">Add your file *</label> <br /> -->
    <input type="file" id="curFile" name="curFile" class="required" />
</div>