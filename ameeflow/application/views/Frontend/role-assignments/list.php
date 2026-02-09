<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteRole();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageSRole('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Role Type</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Added</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($rolesDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="roleIds[]" name="roleIds[]" value="<?php echo $row['roleId'];?>" /> </td>
                            <td><?php $roleChk = $this->config->item('user_roles_array_config')[$row['roleType']];
                            echo $roleChk['name'];
                            if(isset($roleChk['shortDesc']) && $roleChk['shortDesc']!=''){echo '<small>'.$roleChk['shortDesc'].'</small>';} ?></td>
                            <td class="fw600"> <?php echo $row['name']; ?>  </td>
                            <td><?php echo $row['email'];?></td>
                            
                            <td> <?php echo date('m/d/Y, h:i A',$row['createTime']);?> </td>                             
                            <td>                                
                                <input <?php if(isset($row['isActive']) && $row['isActive']==0){?> checked="checked" <?php } ?> id="toggle-event-isActive<?php echo $row['roleId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['roleId'];?>','isActive');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" type="checkbox">
                                <span id="spinner_isActive_<?php echo $row['roleId'];?>"></span>                                                
                            </td>
                            <td nowrap>
                                
                                <a class="btn btn-primary btn-sm" id="edrole<?php echo $row['roleId'];?>" onclick="return manageSRole('<?php echo $row['roleId'];?>');">Edit</a>                                
                                
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/Frontend/role-assignments/pop-model.php');
?>
</section>