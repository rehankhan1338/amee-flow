<?php 
if(isset($uniadminDetails['uniAdminId']) && $uniadminDetails['uniAdminId']!=''){
    $uniAdminId = $uniadminDetails['uniAdminId'];
    $accType = $uniadminDetails['accType'];    
}else{
    $uniAdminId = 0;
    $accType = 'project-manager';
}
?>
<input type="hidden" id="rauniAdminId" name="rauniAdminId" value="<?php echo $uniAdminId;?>" />
<input type="hidden" id="raaccType" name="raaccType" value="<?php echo $accType;?>" />
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Full Name *</label>
        <input type="text" id="fullName" name="fullName" class="form-control required" placeholder="" value="<?php if(isset($uniadminDetails['fullName']) && $uniadminDetails['fullName']!=''){echo $uniadminDetails['fullName'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Email *</label>
        <input type="text" id="email" name="email" class="form-control email required" placeholder="" value="<?php if(isset($uniadminDetails['email']) && $uniadminDetails['email']!=''){echo $uniadminDetails['email'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Contact Number *</label>
        <input type="number" id="contactNo" name="contactNo" class="form-control required" placeholder="" value="<?php if(isset($uniadminDetails['contactNo']) && $uniadminDetails['contactNo']!=''){echo $uniadminDetails['contactNo'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Unit/Department *</label>
        <input type="text" id="unitName" name="unitName" class="form-control required" placeholder="" value="<?php if(isset($uniadminDetails['unitName']) && $uniadminDetails['unitName']!=''){echo $uniadminDetails['unitName'];}?>" autocomplete="off" />
    </div>
    
</div>

<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Status *</label>
        <select id="isActive" name="isActive" class="form-control required">
            <option value="0" <?php if(isset($uniadminDetails['isActive']) && $uniadminDetails['isActive']==0){?> selected<?php } ?>>Active</option>
            <option value="1" <?php if(isset($uniadminDetails['isActive']) && $uniadminDetails['isActive']==1){?> selected<?php } ?>>In-active</option>
        </select>
    </div>
</div>
<?php if($accType!='system-admin'){?>
<div class="row mt-3">
    <h5>Set Privileges</h5>
    <div class="col-12 form-fields">
        <?php
        if(isset($uniadminDetails['menu_ids']) && $uniadminDetails['menu_ids']!=''){
            $menuIdsArr = explode(',',$uniadminDetails['menu_ids']);
        }else{
            $menuIdsArr = array();
        }
        if(isset($uniadminDetails['submenu_ids']) && $uniadminDetails['submenu_ids']!=''){
            $subMenuIdsArr = explode(',',$uniadminDetails['submenu_ids']);
        }else{
            $subMenuIdsArr = array();
        }
        foreach($menuDataArr as $menu){
            $subMenuRes =  filter_array($subMenuDataArr,$menu['id'],'menu_id');
            if(count($subMenuRes)>0){
            foreach($subMenuRes as $subMenu){?>
                <label class="potpn" for="subMenu<?php echo $subMenu['id'];?>"> <input <?php if(in_array($subMenu['id'],$subMenuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="subMenu<?php echo $subMenu['id'];?>" value="<?php echo $menu['id'].'||'.$subMenu['id'];?>" />&nbsp;<?php echo $subMenu['submenu_name']; // $menu['menu_name'].' - '.?></label>      
            <?php } }else{ ?>        
                <label class="potpn" for="menuId<?php echo $menu['id'];?>"> <input <?php if(in_array($menu['id'],$menuIdsArr)){?> checked<?php } ?> type="checkbox" name="menuIds[]" id="menuId<?php echo $menu['id'];?>" value="<?php echo $menu['id'].'||0';?>" />&nbsp;<?php echo $menu['menu_name'];?></label> 
        <?php } } ?>
    </div>
</div> 
<?php } ?>