<?php 
if(isset($gaDetailsArr['userAccessId']) && $gaDetailsArr['userAccessId']!=''){
    $userAccessId = $gaDetailsArr['userAccessId'];
}else{
    $userAccessId = 0;
}
?>
<input type="hidden" id="rauserAccessId" name="rauserAccessId" value="<?php echo $userAccessId;?>" />
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Full Name *</label>
        <input type="text" id="txtFullName" name="txtFullName" class="form-control required" placeholder="" value="<?php if(isset($gaDetailsArr['auName']) && $gaDetailsArr['auName']!=''){echo $gaDetailsArr['auName'];}?>" autocomplete="off" />
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Email ID *</label>
        <input type="text" id="txtEmail" name="txtEmail" class="form-control email required" placeholder="" value="<?php if(isset($gaDetailsArr['auEmailId']) && $gaDetailsArr['auEmailId']!=''){echo $gaDetailsArr['auEmailId'];}?>" autocomplete="off" />
    </div>
</div>
