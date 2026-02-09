<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>    
    
<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Area Expert</h3>
            <div class="box-tools pull-right">                
                <button id="delBtn" type="button" onclick="return deleteUser();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="resendBtn" type="button" onclick="return resendLoginDetails();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-warning'> Resend Login </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageUser('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>User Info.</th>
                            <th>Email ID</th>
                            <th>Unit</th>
                            <!-- <th>Last Login</th> -->
                            <th nowrap>AE-Roles</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($uniUsersDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="userIds[]" name="userIds[]" value="<?php echo $row['userId'];?>" /> </td>
                            <td style="font-weight:600;"> <?php echo $row['userName']; ?> <small><?php echo $this->config->item('user_types_array_config')[$row['userType']]['name']; ?></small> </td>
                            <td><?php echo $row['userEmail'];?> </td>
                            <td><?php echo $row['unitName'];?> <small>Short Name: <?php echo $row['unitShortName'];?></small> <small>Oversight Name: <?php echo $row['overSightName'];?></small> </td>
                            <!-- <td> <?php //if(isset($row['lastLogin']) && $row['lastLogin']!='' && $row['lastLogin']>0){echo date('d M, Y',$row['lastLogin']);?> <small><?php //echo date('h:i A',$row['lastLogin']);?></small> <?php //}else{echo '&ndash;';} ?> </td>                              -->
                            <td nowrap>
                                <?php if($row['srRoleCnt']>0){?>
                                (<?php echo $row['srRoleCnt'];?>) <a class="pro_name" id="srLnk<?php echo $row['userId'];?>" onclick="return viewSeniorDetails('<?php echo $row['userId'];?>');"> View</a> 
                                <?php }else{echo '&ndash;'; } ?>
                            </td>
                            <td>                                
                                <input <?php if(isset($row['isActive']) && $row['isActive']==0){?> checked="checked" <?php } ?> id="toggle-event-isActive<?php echo $row['userId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['userId'];?>','isActive');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" type="checkbox">
                                <span id="spinner_isActive_<?php echo $row['userId'];?>"></span>                                                
                            </td>
                            <td nowrap>
                                <?php if($row['uniAdminId']==$sessionDetailsArr['uniAdminId']){?>
                                <a class="btn btn-primary btn-sm" id="edrole<?php echo $row['userId'];?>" onclick="return manageUser('<?php echo $row['userId'];?>');">Edit</a>                                
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/system-admin/role-assignments/pop-model.php');
include(APPPATH.'views/system-admin/role-assignments/its-senior-roles.php');
?>
</section>