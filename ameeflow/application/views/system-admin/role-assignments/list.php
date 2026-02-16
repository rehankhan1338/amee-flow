<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Area Expert</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <!-- Project Filter -->
                <div class="af-select-filter-wrap" id="afProjectFilterWrap">
                    <span class="af-select-filter-btn" id="afProjectFilterBtn" role="button">
                        <i class="fa fa-folder"></i>
                        <span class="af-select-filter-label">All Projects</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                        <button class="af-select-filter-clear" id="afProjectClear" type="button"><i class="fa fa-times"></i></button>
                    </span>
                    <div class="af-select-filter-dropdown" id="afProjectDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Projects</a>
                        <?php 
                            if(isset($projectDataArr) && count($projectDataArr)>0){
                                foreach($projectDataArr as $pro){
                        ?>
                        <a href="#" class="af-select-filter-option" data-value="<?php echo $pro['projectId'];?>"><?php echo htmlspecialchars($pro['projectName']);?></a>
                        <?php } } ?>
                    </div>
                </div>
                <!-- Unit Filter -->
                <div class="af-select-filter-wrap" id="afUnitFilterWrap">
                    <span class="af-select-filter-btn" id="afUnitFilterBtn" role="button">
                        <i class="fa fa-building"></i>
                        <span class="af-select-filter-label">All Units</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                        <button class="af-select-filter-clear" id="afUnitClear" type="button"><i class="fa fa-times"></i></button>
                    </span>
                    <div class="af-select-filter-dropdown" id="afUnitDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Units</a>
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
                        <a href="#" class="af-select-filter-option" data-value="<?php echo htmlspecialchars($opt);?>"><?php echo htmlspecialchars($opt);?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="rolesSearchInput" placeholder="Search users..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="rolesClearSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <button id="delBtn" type="button" onclick="return deleteUser();" class='btn btn-danger btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-trash"></i> Delete </button>
                <button id="resendBtn" type="button" onclick="return resendLoginDetails();" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-envelope"></i> Resend Login </button>
                <button id="addBtn" type="button" onclick="return manageUser('0');" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-plus"></i> Add New</button>
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
    var selectedUnit = '';
    var selectedProject = '';

    function filterRolesTable(){
        var searchText = $('#rolesSearchInput').val().toLowerCase();
        $('#table_recordtbl tbody tr').not('.no-data-row').each(function(){
            var $row = $(this);
            var rowText = $row.text().toLowerCase();
            var rowUnit = ($row.data('unit') || '').toString();
            var rowProjectIds = String($row.data('project-ids') || '');
            var projectIdsArr = rowProjectIds ? rowProjectIds.split(',') : [];

            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesUnit = (selectedUnit === '' || rowUnit === selectedUnit);
            var matchesProject = true;
            if(selectedProject !== ''){
                matchesProject = (projectIdsArr.indexOf(selectedProject) > -1);
            }
            if(matchesSearch && matchesUnit && matchesProject){
                $row.show();
            } else {
                $row.hide();
            }
        });
    }

    /* Search bar */
    $('#rolesSearchInput').on('input', function(){
        var v = $(this).val();
        if(v.length > 0){ $('#rolesClearSearch').css('display','flex'); } else { $('#rolesClearSearch').hide(); }
        filterRolesTable();
    });
    $('#rolesClearSearch').on('click', function(){
        $('#rolesSearchInput').val('');
        $(this).hide();
        filterRolesTable();
    });

    /* Unit filter dropdown */
    $('#afUnitFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afProjectDropdown').removeClass('show');
        $('#afUnitDropdown').toggleClass('show');
    });
    $('#afUnitDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        selectedUnit = $(this).data('value') || '';
        $('#afUnitDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(selectedUnit !== ''){
            $('#afUnitFilterBtn .af-select-filter-label').text($(this).text());
            $('#afUnitFilterBtn').addClass('active');
            $('#afUnitClear').css('display','inline-block');
        } else {
            $('#afUnitFilterBtn .af-select-filter-label').text('All Units');
            $('#afUnitFilterBtn').removeClass('active');
            $('#afUnitClear').hide();
        }
        $('#afUnitDropdown').removeClass('show');
        filterRolesTable();
    });
    $('#afUnitClear').on('click', function(e){
        e.stopPropagation();
        selectedUnit = '';
        $('#afUnitFilterBtn .af-select-filter-label').text('All Units');
        $('#afUnitFilterBtn').removeClass('active');
        $(this).hide();
        $('#afUnitDropdown .af-select-filter-option').removeClass('selected');
        filterRolesTable();
    });

    /* Project filter dropdown */
    $('#afProjectFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afUnitDropdown').removeClass('show');
        $('#afProjectDropdown').toggleClass('show');
    });
    $('#afProjectDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        selectedProject = val ? val.toString() : '';
        $('#afProjectDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(selectedProject !== ''){
            $('#afProjectFilterBtn .af-select-filter-label').text($(this).text());
            $('#afProjectFilterBtn').addClass('active');
            $('#afProjectClear').css('display','inline-block');
        } else {
            $('#afProjectFilterBtn .af-select-filter-label').text('All Projects');
            $('#afProjectFilterBtn').removeClass('active');
            $('#afProjectClear').hide();
        }
        $('#afProjectDropdown').removeClass('show');
        filterRolesTable();
    });
    $('#afProjectClear').on('click', function(e){
        e.stopPropagation();
        selectedProject = '';
        $('#afProjectFilterBtn .af-select-filter-label').text('All Projects');
        $('#afProjectFilterBtn').removeClass('active');
        $(this).hide();
        $('#afProjectDropdown .af-select-filter-option').removeClass('selected');
        filterRolesTable();
    });

    /* Close dropdowns on outside click */
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afUnitFilterWrap').length){ $('#afUnitDropdown').removeClass('show'); }
        if(!$(e.target).closest('#afProjectFilterWrap').length){ $('#afProjectDropdown').removeClass('show'); }
    });
});
</script>
</section>