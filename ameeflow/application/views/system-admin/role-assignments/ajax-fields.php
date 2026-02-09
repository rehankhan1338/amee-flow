<?php 
if(isset($userDetailsArr['userId']) && $userDetailsArr['userId']!=''){
    $userId = $userDetailsArr['userId'];
    $uaeId = $userDetailsArr['uaeId'];
}else{
    $userId = 0;
    $uaeId = 0;
}
if(isset($userDetailsArr['projectIds']) && $userDetailsArr['projectIds']!=''){
    $assProIdArr = explode(',',$userDetailsArr['projectIds']);
}else{
    $assProIdArr = array();
}

?>
<input type="hidden" id="rauserId" name="rauserId" value="<?php echo $userId;?>" />
<input type="hidden" id="rauserAccesseId" name="rauserAccesseId" value="<?php echo $uaeId;?>" />
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Full Name *</label>
        <input type="text" id="txtFullName" name="txtFullName" class="form-control required" placeholder="" value="<?php if(isset($userDetailsArr['userName']) && $userDetailsArr['userName']!=''){echo $userDetailsArr['userName'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Email ID / Login ID *</label>
        <input type="text" id="txtEmail" name="txtEmail" class="form-control email required" placeholder="" value="<?php if(isset($userDetailsArr['userEmail']) && $userDetailsArr['userEmail']!=''){echo $userDetailsArr['userEmail'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Unit Name *</label>
        <input type="text" id="txtUnitName" name="txtUnitName" class="form-control required" placeholder="" value="<?php if(isset($userDetailsArr['unitName']) && $userDetailsArr['unitName']!=''){echo $userDetailsArr['unitName'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Unit Short Name *</label>
        <input type="text" id="txtShortName" name="txtShortName" class="form-control required" placeholder="Name of unit/department/Program" value="<?php if(isset($userDetailsArr['unitShortName']) && $userDetailsArr['unitShortName']!=''){echo $userDetailsArr['unitShortName'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Unit Oversight Name *</label>
        <input type="text" id="txtOverSight" name="txtOverSight" class="form-control required" placeholder="" value="<?php if(isset($userDetailsArr['overSightName']) && $userDetailsArr['overSightName']!=''){echo $userDetailsArr['overSightName'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Role Assignment *</label>
        <select id="txtUserType" name="txtUserType" class="form-control required">
            <option value="">Select...</option>
            <?php $userTypes = $this->config->item('user_types_array_config');
            foreach($userTypes as $key=>$value){ if($value['status']==0){?>
            <option value="<?php echo $key;?>" <?php if(isset($userDetailsArr['userType']) && $userDetailsArr['userType']==$key){?> selected<?php } ?>><?php echo $value['name'];//.$value['moreInfo']; ?></option>
            <?php } } ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Light Access Permission *</label>
        <select id="lightAccess" name="lightAccess" class="form-control required">
            <option value="">Select...</option>
            <option <?php if(isset($userDetailsArr['lightAccess']) && $userDetailsArr['lightAccess']==1){?> selected<?php } ?> value="1">Yes</option>
            <option <?php if(isset($userDetailsArr['lightAccess']) && $userDetailsArr['lightAccess']==0){?> selected<?php } ?> value="0">No</option> 
        </select>
    </div>
</div>

<div class="row mt-1">
    <h5>Assign Project</h5>
    <div class="col-12 form-fields">
        <?php foreach($projectDataArr as $pro){?>
            <div class="col-md-12 my-2 mx-3">
            <label class="fs16" for="assProId<?php echo $pro['projectId'];?>"> <input <?php if(in_array($pro['projectId'],$assProIdArr)){ ?>checked<?php } ?> type="checkbox" class="caseProId<?php echo $pro['projectId'];?>" id="assProId<?php echo $pro['projectId'];?>" name="assProIds[]" value="<?php echo $pro['projectId'];?>" /> &nbsp;<?php echo $pro['projectName'];?></label>
            </div>
        <?php } ?>
    </div>
</div>

<div class="row mt-3">
    <h5>Set Privileges for Dashboard User</h5>
    <div class="col-12 form-fields">
        <?php
        if(isset($userDetailsArr['menu_ids']) && $userDetailsArr['menu_ids']!=''){
            $menuIdsArr = explode(',',$userDetailsArr['menu_ids']);
        }else{
            $menuIdsArr = array();
        }
        if(isset($userDetailsArr['submenu_ids']) && $userDetailsArr['submenu_ids']!=''){
            $subMenuIdsArr = explode(',',$userDetailsArr['submenu_ids']);
        }else{
            $subMenuIdsArr = array();
        }
        foreach($menuDataArr as $menu){
            $subMenuRes =  filter_array($subMenuDataArr,$menu['id'],'menu_id');
            if(count($subMenuRes)>0){
            foreach($subMenuRes as $subMenu){?>
                <label class="potpn" for="subMenu<?php echo $subMenu['id'];?>"> <input <?php if(in_array($subMenu['id'],$subMenuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="subMenu<?php echo $subMenu['id'];?>" value="<?php echo $menu['id'].'||'.$subMenu['id'];?>" />&nbsp;<?php echo $subMenu['submenu_name'];?></label>      
            <?php } }else{ ?>        
                <label class="potpn" for="menuId<?php echo $menu['id'];?>"> <input <?php if(in_array($menu['id'],$menuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="menuId<?php echo $menu['id'];?>" value="<?php echo $menu['id'].'||0';?>" />&nbsp;<?php echo $menu['menu_name'];?></label> 
        <?php } } ?>
    </div>
</div>