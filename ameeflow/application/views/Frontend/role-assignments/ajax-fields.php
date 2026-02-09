<?php 
if(isset($roleDetailsArr['roleId']) && $roleDetailsArr['roleId']!=''){
    $roleId = $roleDetailsArr['roleId'];
}else{
    $roleId = 0;
}
?>
<input type="hidden" id="roleId" name="roleId" value="<?php echo $roleId;?>" />
<div class="row">    
    <div class="col-12 form-fields">
        <label class="form-label">Role Assignment *</label>
        <select id="txtroleType" name="txtroleType" class="form-control required">
            <option value="">Select...</option>
            <?php $roleTypes = $this->config->item('user_roles_array_config');
            foreach($roleTypes as $key=>$value){ if($value['status']==0 && $value['assRoleFrm']==1){?>
            <option value="<?php echo $key;?>" <?php if(isset($roleDetailsArr['roleType']) && $roleDetailsArr['roleType']==$key){?> selected<?php } ?>><?php 
            
            echo $value['name'];
            if(isset($value['shortDesc']) && $value['shortDesc']!=''){echo ' ('.$value['shortDesc'].')';}
            ?></option>
            <?php } } ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Full Name *</label>
        <input type="text" id="txtFullName" name="txtFullName" class="form-control required" placeholder="" value="<?php if(isset($roleDetailsArr['name']) && $roleDetailsArr['name']!=''){echo $roleDetailsArr['name'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Email *</label>
        <input type="text" id="txtEmail" name="txtEmail" class="form-control email required" placeholder="" value="<?php if(isset($roleDetailsArr['email']) && $roleDetailsArr['email']!=''){echo $roleDetailsArr['email'];}?>" autocomplete="off" />
    </div>
</div>
