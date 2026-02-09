<?php 
if(isset($gaDetailsArr['uniAdminId']) && $gaDetailsArr['uniAdminId']!=''){
    $uniAdminId = $gaDetailsArr['uniAdminId'];
}else{
    $uniAdminId = 0;
}
?>
<input type="hidden" id="rauniAdminId" name="rauniAdminId" value="<?php echo $uniAdminId;?>" />
<div class="row">
    <div class="col-4 form-fields">
        <label class="form-label">Full Name *</label>
        <input type="text" id="txtFullName" name="txtFullName" class="form-control required" placeholder="" value="<?php if(isset($gaDetailsArr['fullName']) && $gaDetailsArr['fullName']!=''){echo $gaDetailsArr['fullName'];}?>" autocomplete="off" />
    </div>
    <div class="col-4 form-fields">
        <label class="form-label">Email ID / Login ID *</label>
        <input type="text" id="txtEmail" name="txtEmail" class="form-control email required" placeholder="" value="<?php if(isset($gaDetailsArr['email']) && $gaDetailsArr['email']!=''){echo $gaDetailsArr['email'];}?>" autocomplete="off" />
    </div>
    <div class="col-4 form-fields">
        <label class="form-label">Contact Number *</label>
        <input type="number" id="txtcontactNo" name="txtcontactNo" class="form-control" placeholder="" value="<?php if(isset($gaDetailsArr['contactNo']) && $gaDetailsArr['contactNo']!=''){echo $gaDetailsArr['contactNo'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <h5>Set Privileges</h5>
    <div class="col-12 form-fields">
        <?php
        if(isset($gaDetailsArr['menu_ids']) && $gaDetailsArr['menu_ids']!=''){
            $menuIdsArr = explode(',',$gaDetailsArr['menu_ids']);
        }else{
            $menuIdsArr = array();
        }
        if(isset($gaDetailsArr['submenu_ids']) && $gaDetailsArr['submenu_ids']!=''){
            $subMenuIdsArr = explode(',',$gaDetailsArr['submenu_ids']);
        }else{
            $subMenuIdsArr = array();
        }
        foreach($menuDataArr as $menu){
            $subMenuRes =  filter_array($subMenuDataArr,$menu['id'],'menu_id');
            if(count($subMenuRes)>0){
            foreach($subMenuRes as $subMenu){?>
                <label class="potpn" for="subMenu<?php echo $subMenu['id'];?>"> <input <?php if(in_array($subMenu['id'],$subMenuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="subMenu<?php echo $subMenu['id'];?>" value="<?php echo $menu['id'].'||'.$subMenu['id'];?>" />&nbsp;<?php echo $subMenu['submenu_name']; //$menu['menu_name'].' - '.?></label>      
            <?php } }else{ ?>        
                <label class="potpn" for="menuId<?php echo $menu['id'];?>"> <input <?php if(in_array($menu['id'],$menuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="menuId<?php echo $menu['id'];?>" value="<?php echo $menu['id'].'||0';?>" />&nbsp;<?php echo $menu['menu_name'];?></label> 
        <?php } } ?>
    </div>
</div>