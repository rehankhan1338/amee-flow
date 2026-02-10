<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<style>
    .select2-container--default .select2-selection--single { height:34px; border:1px solid #ced4da; border-radius:4px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height:32px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height:32px; }
    .select2-container { vertical-align:middle; margin-right:10px; }
</style>
    
<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Area Expert</h3>
            <div class="box-tools pull-right">                
                <select id="unitFilter" class="form-control form-control-sm" style="display:inline-block; width:200px; height:34px; margin-right:10px; vertical-align:middle;">
                    <option value="">All Units</option>
                    <?php 
                        $unitOptions = array();
                        foreach($uniUsersDataArr as $row){
                            $unitLabel = trim($row['unitName']);
                            if($unitLabel != '' && !in_array($unitLabel, $unitOptions)){
                                $unitOptions[] = $unitLabel;
                            }
                        }
                        sort($unitOptions);
                        foreach($unitOptions as $opt){
                    ?>
                    <option value="<?php echo htmlspecialchars($opt);?>"><?php echo htmlspecialchars($opt);?></option>
                    <?php } ?>
                </select>
                <select id="projectFilter" class="form-control form-control-sm" style="display:inline-block; width:200px; height:34px; margin-right:10px; vertical-align:middle;">
                    <option value="">All Projects</option>
                    <?php 
                        if(isset($projectDataArr) && count($projectDataArr)>0){
                            foreach($projectDataArr as $pro){
                    ?>
                    <option value="<?php echo $pro['projectId'];?>"><?php echo htmlspecialchars($pro['projectName']);?></option>
                    <?php } } ?>
                </select>
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
                            <th>Projects</th>
                            <!-- <th>Last Login</th> -->
                            <th nowrap>AE-Roles</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php 
                        if(count($uniUsersDataArr) > 0){
                            $i = 1;
                            foreach($uniUsersDataArr as $row){                        
                        ?>
                        <?php 
                            // Resolve project names for this user
                            $userProjectNames = array();
                            $userProjectIds = '';
                            if(isset($row['projectIds']) && $row['projectIds']!=''){
                                $userProjectIds = $row['projectIds'];
                                $pIdsArr = explode(',', $row['projectIds']);
                                foreach($pIdsArr as $pId){
                                    $pId = trim($pId);
                                    if(isset($projectMap[$pId])){
                                        $userProjectNames[] = $projectMap[$pId];
                                    }
                                }
                            }
                        ?>
                        <tr data-unit="<?php echo htmlspecialchars(trim($row['unitName']));?>" data-project-ids="<?php echo htmlspecialchars($userProjectIds);?>">
                            <td> <input type="checkbox" class="case" id="userIds[]" name="userIds[]" value="<?php echo $row['userId'];?>" /> </td>
                            <td style="font-weight:600;"> <?php echo $row['userName']; ?> <small><?php echo $this->config->item('user_types_array_config')[$row['userType']]['name']; ?></small> </td>
                            <td><?php echo $row['userEmail'];?> </td>
                            <td><?php echo $row['unitName'];?> <small>Short Name: <?php echo $row['unitShortName'];?></small> <small>Oversight Name: <?php echo $row['overSightName'];?></small> </td>
                            <td><?php echo (count($userProjectNames)>0) ? htmlspecialchars(implode(', ', $userProjectNames)) : '&ndash;'; ?></td>
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
                                <a class="btn btn-danger btn-sm" id="delrole<?php echo $row['userId'];?>" onclick="return deleteSingleUser('<?php echo $row['userId'];?>');" style="margin-left:3px;">Delete</a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; }
                        } else { ?>
                        <tr class="no-data-row">
                            <td colspan="8" class="text-center py-5">
                                <div class="no-data-message">
                                    <i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p style="font-size: 1.1rem; color: #999; margin: 0; font-weight: 500;">No data found</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/system-admin/role-assignments/pop-model.php');
include(APPPATH.'views/system-admin/role-assignments/its-senior-roles.php');
?>

<script type="text/javascript">
$(function(){
    $('#unitFilter').select2({ placeholder: 'All Units', allowClear: true, width: '200px' });
    $('#projectFilter').select2({ placeholder: 'All Projects', allowClear: true, width: '200px' });

    function filterRolesTable(){
        var selectedUnit = $('#unitFilter').val();
        var selectedProject = $('#projectFilter').val();
        $('#table_recordtbl tbody tr').each(function(){
            var rowUnit = $(this).data('unit');
            var rowProjectIds = String($(this).data('project-ids'));
            var projectIdsArr = rowProjectIds ? rowProjectIds.split(',') : [];
            var matchesUnit = (selectedUnit === '' || rowUnit === selectedUnit);
            var matchesProject = true;
            if(selectedProject !== ''){
                matchesProject = (projectIdsArr.indexOf(selectedProject) > -1);
            }
            $(this).toggle(matchesUnit && matchesProject);
        });
    }
    $('#unitFilter').on('change', function(){
        filterRolesTable();
    });
    $('#projectFilter').on('change', function(){
        filterRolesTable();
    });
});
</script>
</section>