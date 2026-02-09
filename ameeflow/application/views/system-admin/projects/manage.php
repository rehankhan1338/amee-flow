<section class="content">
<!-- <a  class="plus_icon"> <img src="<?php echo base_url();?>assets/backend/images/plusIcon.svg" alt="" /> </a><h5>Projects  </h5> -->
            
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Project Listing</h3>
            <div class="box-tools pull-right">                
                <select id="termYearFilter" class="form-control form-control-sm" style="display:inline-block; width:180px; height:34px; margin-right:10px; vertical-align:middle;">
                    <option value="">All Terms</option>
                    <?php 
                        $termYearOptions = array();
                        foreach($projectDataArr as $pro){
                            $termYearLabel = $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'];
                            if(!in_array($termYearLabel, $termYearOptions)){
                                $termYearOptions[] = $termYearLabel;
                            }
                        }
                        sort($termYearOptions);
                        foreach($termYearOptions as $opt){
                    ?>
                    <option value="<?php echo $opt;?>"><?php echo $opt;?></option>
                    <?php } ?>
                </select>
                <div class="input-group input-group-sm" style="display:inline-flex; width:250px; margin-right:10px; vertical-align:middle;">
                    <input type="text" id="projectSearchInput" class="form-control" placeholder="Search projects..." style="height:34px;">
                    <span class="input-group-text" style="height:34px; cursor:pointer;" id="clearProjectSearch"><i class="fa fa-times"></i></span>
                </div>
                <button id="delProBtn" type="button" onclick="return deleteProject();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="copyProBtn" type="button" onclick="return copyProject();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-warning'> Copy Project </button>
                <button id="addProBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageProject('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Project</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Projects</th>
                            <th>Term - Year</th>
                            <!-- <th>Assigned To</th> -->
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($projectDataArr as $pro){                            
                                $taskList = proTaskListDataArrCh($pro['projectId']);
                        ?>
                        <tr data-term-year="<?php echo $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'];?>">
                            <td> <input type="checkbox" class="case" id="proIds[]" name="proIds[]" value="<?php echo $pro['projectId'];?>" /> </td>
                            <td style="font-weight:600;"> <a id="proTitle<?php echo $pro['projectId'];?>" class="pro_name" href="<?php echo base_url().$this->config->item('system_directory_name').'projects/tasks/'.$pro['proencryptId'];?>"> <?php echo $pro['projectName']; ?></a> </td>
                            <td id="proTerm<?php echo $pro['projectId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'];?></td>
                            <!-- <td style="font-weight:600;"> 
                                <label id="assignedRoles<?php echo $pro['projectId'];?>">
                                    <?php $assUsersCnt = getAssignedProUsersListCh($pro['projectId']);
                                    $svgImgIcon = base_url().'assets/system-administrator/images/plus-circle-28.svg';
                                    if(count($assUsersCnt)>0){ 
                                        // $svgImgIcon = base_url().'assets/system-administrator/images/edit-28.svg';
                                        foreach($assUsersCnt as $assUser){ if($assUser['assignSts']==0){?>
                                        <span id="assRoleuId<?php echo $pro['projectId'].$assUser['userId'];?>" class="arCls" style="background-color: <?php echo $assUser['bgColor']; ?>; color: <?php echo $assUser['fontColor']; ?>;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $assUser['userName'].'<br />'.$this->config->item('user_types_array_config')[$assUser['userType']]['name'];?>"><?php echo getTwoCharsFromEachWord($assUser['userName']);?></span>
                                    <?php } } } ?>
                                </label>
                                <img class="cp" onclick="return manageRole('0','<?php echo $pro['projectId'];?>');" src="<?php echo $svgImgIcon;?>" alt="" />
                                <!-- <i class="fa fa-plus-circle" aria-hidden="true"></i>  ->
                            </td>                              -->
                            <td>                                
                                <input <?php if(isset($pro['isActive']) && $pro['isActive']==0){?> checked="checked" <?php } ?> id="toggle-event-isActive<?php echo $pro['projectId'];?>" onchange="return update_toggle_swtich_values('<?php echo $pro['projectId'];?>','isActive');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" type="checkbox">
                                <span id="spinner_isActive_<?php echo $pro['projectId'];?>"></span>                                                
                            </td>
                            <td nowrap>
                                <a class="btn btn-primary btn-sm" id="epro<?php echo $pro['projectId'];?>" onclick="return manageProject('<?php echo $pro['projectId'];?>');">Edit</a>
                                <a class="btn btn-danger btn-sm" id="delpro<?php echo $pro['projectId'];?>" onclick="return deleteSingleProject('<?php echo $pro['projectId'];?>');" style="margin-left:3px;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/system-admin/projects/pro-models.php');
include(APPPATH.'views/system-admin/projects/copy-pro.php');
// include(APPPATH.'views/system-admin/projects/role-assignment/assign-role.php');
?>

<script type="text/javascript">
$(function(){
    function filterProjectTable(){
        var searchText = $('#projectSearchInput').val().toLowerCase();
        var selectedTerm = $('#termYearFilter').val();

        $('#table_recordtbl1 tbody tr').each(function(){
            var rowText = $(this).text().toLowerCase();
            var rowTermYear = $(this).data('term-year');
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesTerm = (selectedTerm === '' || rowTermYear === selectedTerm);
            $(this).toggle(matchesSearch && matchesTerm);
        });
    }

    $('#projectSearchInput').on('keyup', function(){
        filterProjectTable();
    });

    $('#termYearFilter').on('change', function(){
        filterProjectTable();
    });

    $('#clearProjectSearch').on('click', function(){
        $('#projectSearchInput').val('');
        filterProjectTable();
        $('#projectSearchInput').focus();
    });
});
</script>
</section>