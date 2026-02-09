<?php if(count($assignUsersDataArr)>0){ ?>
<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
    });
</script>
<table class="table table-striped table-bordered">
<thead>
<tr>
    <th>Name</th>
    <th>Role</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php foreach($assignUsersDataArr as $row){
    $chkSts = chkUserProAssignStsCh($row['userId'],$assignProjectId,$assignTaskId);
    ?>

<tr id="asRoleRow<?php echo $row['userId'];?>">
    <td style="font-weight:600;"><?php echo $row['userName'];?></td>
    <td><?php echo $this->config->item('user_types_array_config')[$row['userType']]['name'];?></td>
    <td class="modalbsToggle">
        <input <?php if($chkSts==0){?> checked="checked" <?php } ?> id="toggle-assignSts<?php echo $row['userId'];?>" onchange="return assignassignStsInProjects('<?php echo $row['userId'];?>','assignSts','<?php echo $assignProjectId;?>','<?php echo $assignTaskId;?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Yes " data-off="No" type="checkbox">
        <span id="spinner_assignSts_<?php echo $row['userId'];?>"></span>
    </td>
</tr>    

<?php } ?>
</tbody>
</table>
<?php } ?>