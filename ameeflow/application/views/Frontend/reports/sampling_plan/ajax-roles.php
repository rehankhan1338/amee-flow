<?php if($rtype=='other'){?>
<div class="row">
    <div class="col-6 my-2 form-fields">
        <label class="form-label">Name *</label>
        <input type="text" id="spName_1" name="spName[]" class="form-control required" autocomplete="off" />     
    </div>
    <div class="col-6 my-2 form-fields">
        <label class="form-label">Email *</label>
        <input type="text" id="spEmail_1" name="chRoleIds[]" class="form-control email required" autocomplete="off" />  
    </div>
</div>
<?php }else if($rtype=='self'){ ?>
<div class="col-6 my-2">
    <label class="fw600" for="chRoleId<?php echo $sessionDetailsArr['userId'];?>"> <input class="caseRoleIds" type="checkbox" id="chRoleId<?php echo $sessionDetailsArr['userId'];?>" name="chRoleIds[]" value="<?php echo $sessionDetailsArr['userId'];?>" /> <?php echo $sessionDetailsArr['userName'];?> </label>
</div>
<?php }else if($rtype==4){ 
    foreach($rolesDataArr as $row){
        if(isset($row['lastName']) && $row['lastName']!='' && ($row['courseSts']==1 || (isset($row['courseNotes']) && $row['courseNotes']!=''))){?>
<div class="col-6 my-2">
    <label class="fw600" for="chRoleId<?php echo $row['ceClassId'];?>"> <input class="caseRoleIds" type="checkbox" id="chRoleId<?php echo $row['ceClassId'];?>" name="chRoleIds[]" value="<?php echo $row['ceClassId'];?>" /> <?php echo $row['lastName'].', '.$row['firstName'];?> </label>
</div>
<?php } } }else{ foreach($rolesDataArr as $role){?>
<div class="col-6 my-2">
    <label class="fw600" for="chRoleId<?php echo $role['roleId'];?>"> <input class="caseRoleIds" type="checkbox" id="chRoleId<?php echo $role['roleId'];?>" name="chRoleIds[]" value="<?php echo $role['roleId'];?>" /> <?php echo $role['name'];?> </label>
</div>
<?php } } ?>