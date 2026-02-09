<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Acct. Type</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created On</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $i = 1;
    foreach($seniorData as $sr){
    ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php $roleChk = $this->config->item('user_roles_array_config')[$sr['roleType']];
            echo $roleChk['name'];
            if(isset($roleChk['shortDesc']) && $roleChk['shortDesc']!=''){echo '<small>'.$roleChk['shortDesc'].'</small>';} ?></td>
            <td> <?php echo $sr['name'];?> </td>
            <td> <?php echo $sr['email'];?> </td>
            <td> <?php echo date('m/d/Y, h:i A',$sr['createTime']);?> </td>
        </tr>
    <?php $i++;} ?>
    </tbody>
</table>