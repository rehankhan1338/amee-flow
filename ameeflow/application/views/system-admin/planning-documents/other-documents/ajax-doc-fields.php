<?php 
if(isset($docDetails['docId']) && $docDetails['docId']!=''){
    $docId = $docDetails['docId'];
}else{
    $docId = 0;
}
?>
<input type="hidden" id="mdocId" name="mdocId" value="<?php echo $docId;?>" />
<div class="col-12 form-fields">
    <label class="form-label">Document Name/Title *</label>
    <input type="text" id="docTitle" name="docTitle" class="form-control required" placeholder="Add Title Here" value="<?php if(isset($docDetails['docTitle']) && $docDetails['docTitle']!=''){echo $docDetails['docTitle'];}?>" autocomplete="off" />
</div>
<div class="col-12 form-fields">
    <label class="form-label">Document Type *</label>
    <select id="docType" name="docType" class="form-control required" onchange="return docField(this.value);">
        <option value="">Select...</option>
        <option value="1" <?php if(isset($docDetails['docType']) && $docDetails['docType']==1){?> selected<?php } ?>>URL</option>
        <option value="2" <?php if(isset($docDetails['docType']) && $docDetails['docType']==2){?> selected<?php } ?>>Upload</option> 
    </select>
</div>
<div class="col-12 form-fields">
    <input type="text" id="docLnk" style="display:<?php if(isset($docDetails['docType']) && $docDetails['docType']==1){echo 'block';}else{echo 'none';}?>;" name="docLnk" class="form-control" placeholder="" value="<?php if(isset($docDetails['docLnk']) && $docDetails['docLnk']!=''){echo $docDetails['docLnk'];}?>" autocomplete="off" />
    <input type="file" id="docUp" style="display:<?php if(isset($docDetails['docType']) && $docDetails['docType']==2){echo 'block';}else{echo 'none';}?>;" name="docUp"/>
    <input type="hidden" id="oldDocName" name="oldDocName" value="<?php if(isset($docDetails['docFileName']) && $docDetails['docFileName']!=''){echo $docDetails['docFileName'];}?>" />
</div>
<div class="row mt-3">
    <h5>Assign Task</h5>
    <div class="col-12 form-fields">
        <?php include(APPPATH.'views/system-admin/planning-documents/other-documents/projects-assign.php'); ?>
    </div>
</div>