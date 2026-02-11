<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteRole();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageSRole('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>

        <!-- Toolbar: Search + Date Filter -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i data-feather="search"></i></span>
                    <input type="text" class="af-roles-search-input" id="afRolesSearchInput" placeholder="Search by name, email, role..." autocomplete="off">
                    <button type="button" class="af-roles-search-clear" id="afRolesSearchClear"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <!-- Role Type Filter -->
                <div class="af-select-filter-wrap" id="afRoleFilterWrap">
                    <span class="af-select-filter-btn" id="afRoleFilterBtn" role="button">
                        <i data-feather="users"></i>
                        <span class="af-select-filter-label">Role Type</span>
                        <span class="af-select-filter-clear" id="afRoleFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-select-filter-dropdown" id="afRoleFilterDropdown">
                        <?php $user_roles = $this->config->item('user_roles_array_config');
                        foreach($user_roles as $rKey => $rVal){ ?>
                            <a href="#" class="af-select-filter-option" data-value="<?php echo $rVal['name']; ?>"><?php echo $rVal['name']; ?><?php if(isset($rVal['shortDesc']) && $rVal['shortDesc']!=''){ echo ' <small style="color:#999;">('.$rVal['shortDesc'].')</small>';} ?></a>
                        <?php } ?>
                    </div>
                </div>

                <!-- Date Filter -->
                <div class="af-date-filter-wrap" id="afDateFilterWrap">
                    <span class="af-date-filter-btn" id="afDateFilterBtn" role="button">
                        <i data-feather="calendar"></i>
                        <span class="af-date-filter-label">Date Added</span>
                        <span class="af-date-filter-clear" id="afDateFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-date-filter-dropdown" id="afDateFilterDropdown">
                        <div id="afDatePicker"></div>
                    </div>
                </div>
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
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($rolesDataArr as $row){                        
                        ?>
                        <?php $roleChk = $this->config->item('user_roles_array_config')[$row['roleType']]; ?>
                        <tr data-date="<?php echo date('m/d/Y',$row['createTime']);?>" data-role="<?php echo $roleChk['name']; ?>">
                            <td> <input type="checkbox" class="case" id="roleIds[]" name="roleIds[]" value="<?php echo $row['roleId'];?>" /> </td>
                            <td><?php echo $roleChk['name'];
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
                                <button type="button" class="af-row-delete-btn" title="Delete" onclick="return deleteSingleRole('<?php echo $row['roleId'];?>');">
                                    <i class="fa fa-trash"></i>
                                </button>
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
