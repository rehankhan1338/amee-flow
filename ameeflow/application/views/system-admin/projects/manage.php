<section class="content">
<!-- <a  class="plus_icon"> <img src="<?php echo base_url();?>assets/backend/images/plusIcon.svg" alt="" /> </a><h5>Projects  </h5> -->
            
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Project Listing</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="projectSearchInput" placeholder="Search projects..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="clearProjectSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
                <!-- Term/Year Filter -->
                <div class="af-select-filter-wrap" id="afTermYearFilterWrap">
                    <span class="af-select-filter-btn" id="afTermYearFilterBtn" role="button">
                        <i class="fa fa-calendar"></i>
                        <span class="af-select-filter-label">All Terms</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                        <button class="af-select-filter-clear" id="afTermYearClear" type="button"><i class="fa fa-times"></i></button>
                    </span>
                    <div class="af-select-filter-dropdown" id="afTermYearDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Terms</a>
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
                        <a href="#" class="af-select-filter-option" data-value="<?php echo $opt;?>"><?php echo $opt;?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <button id="delProBtn" type="button" onclick="return deleteProject();" class='btn btn-danger btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-trash"></i> Delete </button>
                <button id="copyProBtn" type="button" onclick="return copyProject();" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-copy"></i> Copy </button>
                <button id="addProBtn" type="button" onclick="return manageProject('0');" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-plus"></i> Project</button>
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
                        <?php 
                        if(count($projectDataArr) > 0){
                            $i = 1;
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
                        <?php $i++; }
                        } else { ?>
                        <tr class="no-data-row">
                            <td colspan="5" class="text-center py-5">
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
include(APPPATH.'views/system-admin/projects/pro-models.php');
include(APPPATH.'views/system-admin/projects/copy-pro.php');
// include(APPPATH.'views/system-admin/projects/role-assignment/assign-role.php');
?>

<script type="text/javascript">
$(function(){
    var selectedTermYear = '';

    function filterProjectTable(){
        var searchText = $('#projectSearchInput').val().toLowerCase();
        var visibleCount = 0;

        $('#table_recordtbl1 tbody tr').not('.no-data-row').each(function(){
            var $row = $(this);
            var rowText = $row.text().toLowerCase();
            var rowTermYear = $row.data('term-year');
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesTerm = (selectedTermYear === '' || rowTermYear === selectedTermYear);
            if(matchesSearch && matchesTerm){
                $row.show();
                visibleCount++;
            } else {
                $row.hide();
            }
        });
    }

    /* Search bar */
    $('#projectSearchInput').on('input', function(){
        var v = $(this).val();
        if(v.length > 0){ $('#clearProjectSearch').css('display','flex'); } else { $('#clearProjectSearch').hide(); }
        filterProjectTable();
    });
    $('#clearProjectSearch').on('click', function(){
        $('#projectSearchInput').val('');
        $(this).hide();
        filterProjectTable();
        $('#projectSearchInput').focus();
    });

    /* Term/Year filter dropdown */
    $('#afTermYearFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afTermYearDropdown').toggleClass('show');
    });
    $('#afTermYearDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var val = $(this).data('value');
        selectedTermYear = val || '';
        $('#afTermYearDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(selectedTermYear !== ''){
            $('#afTermYearFilterBtn .af-select-filter-label').text($(this).text());
            $('#afTermYearFilterBtn').addClass('active');
            $('#afTermYearClear').css('display','inline-block');
        } else {
            $('#afTermYearFilterBtn .af-select-filter-label').text('All Terms');
            $('#afTermYearFilterBtn').removeClass('active');
            $('#afTermYearClear').hide();
        }
        $('#afTermYearDropdown').removeClass('show');
        filterProjectTable();
    });
    $('#afTermYearClear').on('click', function(e){
        e.stopPropagation();
        selectedTermYear = '';
        $('#afTermYearFilterBtn .af-select-filter-label').text('All Terms');
        $('#afTermYearFilterBtn').removeClass('active');
        $(this).hide();
        $('#afTermYearDropdown .af-select-filter-option').removeClass('selected');
        filterProjectTable();
    });

    /* Close dropdowns on outside click */
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afTermYearFilterWrap').length){
            $('#afTermYearDropdown').removeClass('show');
        }
    });
});
</script>
</section>