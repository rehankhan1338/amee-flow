<?php if(count($selRolesUsersDataArr)>0){
    foreach($selRolesUsersDataArr as $row){
        $recpRes = filter_array($notiRecipientsDataArr,$row['email'],'recpEmail');
        $roleName = '';
        if(isset($row['roleType']) && $row['roleType']!=''){
            $roleName = $this->config->item('user_roles_array_config')[$row['roleType']]['name'];
        }
?>
<div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-2">
    <label class="af-user-check-item" for="uroleId<?php echo $row['roleId'];?>">
        <input class="caseRoleIds" <?php if(count($recpRes)>0){?> checked<?php } ?> type="checkbox" id="uroleId<?php echo $row['roleId'];?>" name="uroleIds[]" value="<?php echo $row['name'].'||'.$row['email'];?>" />
        <div>
            <span class="af-user-check-name"><?php echo $row['name'];?></span>
            <?php if($roleName!=''){ ?><span class="af-user-check-role"><?php echo $roleName;?></span><?php } ?>
        </div>
    </label>
</div>
<?php } } ?>

<?php if(count($userFacultyAccessorDataArr)>0){
    foreach($userFacultyAccessorDataArr as $row){
        if(isset($row['lastName']) && $row['lastName']!='' && ($row['courseSts']==1 || (isset($row['courseNotes']) && $row['courseNotes']!=''))){
            $recpRes = filter_array($notiRecipientsDataArr,$row['facultyEmail'],'recpEmail');
?>
<div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-2">
    <label class="af-user-check-item" for="uroleId<?php echo $row['ceClassId'];?>">
        <input class="caseRoleIds" <?php if(count($recpRes)>0){?> checked<?php } ?> type="checkbox" id="uroleId<?php echo $row['ceClassId'];?>" name="uroleIds[]" value="<?php echo trim($row['firstName'].' '.$row['lastName']).'||'.$row['facultyEmail'];?>" />
        <div>
            <span class="af-user-check-name"><?php echo $row['firstName'].' '.$row['lastName'];?></span>
            <span class="af-user-check-role">Faculty Assessor</span>
        </div>
    </label>
</div>
<?php } } } ?>