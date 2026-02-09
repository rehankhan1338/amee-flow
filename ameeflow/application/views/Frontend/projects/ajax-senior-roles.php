



<?php 



if(count($selRolesUsersDataArr)>0){

    foreach($selRolesUsersDataArr as $row){

        $recpRes = filter_array($notiRecipientsDataArr,$row['email'],'recpEmail');

        ?>

<div class="col-3 my-2">

<label class="form-label" for="uroleId<?php echo $row['roleId'];?>"> <input class="caseRoleIds" <?php if(count($recpRes)>0){?> checked<?php } ?> type="checkbox" id="uroleId<?php echo $row['roleId'];?>" name="uroleIds[]" value="<?php echo $row['name'].'||'.$row['email'];?>" /> <?php echo $row['name']; 

if(isset($row['roleType']) && $row['roleType']!=''){echo '<small class="smlRoletag">'.$this->config->item('user_roles_array_config')[$row['roleType']]['name'].'</small>';}?>  </label>				

</div>

<?php } } ?>



<?php 

if(count($userFacultyAccessorDataArr)>0){

    foreach($userFacultyAccessorDataArr as $row){

        if(isset($row['lastName']) && $row['lastName']!='' && ($row['courseSts']==1 || (isset($row['courseNotes']) && $row['courseNotes']!=''))){

        $recpRes = filter_array($notiRecipientsDataArr,$row['facultyEmail'],'recpEmail');

        ?>

<div class="col-3 my-2">

<label class="form-label" for="uroleId<?php echo $row['ceClassId'];?>"> <input class="caseRoleIds" <?php if(count($recpRes)>0){?> checked<?php } ?> type="checkbox" id="uroleId<?php echo $row['ceClassId'];?>" name="uroleIds[]" value="<?php echo trim($row['firstName'].' '.$row['lastName']).'||'.$row['facultyEmail'];?>" /> <?php echo $row['firstName'].' '.$row['lastName']; 

echo '<small class="smlRoletag">Faculty Assessor</small>';?>  </label>				

</div>

<?php } } }



// print_r($notiRecipientsDataArr);

?>



