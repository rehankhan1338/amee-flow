<section class="content">         
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="documentSearchInput" placeholder="Search documents..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="clearDocumentSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
                <!-- Project Filter -->
                <div class="af-select-filter-wrap" id="afDocProjectFilterWrap">
                    <span class="af-select-filter-btn" id="afDocProjectFilterBtn" role="button">
                        <i class="fa fa-folder"></i>
                        <span class="af-select-filter-label">All Projects</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                        <button class="af-select-filter-clear" id="afDocProjectClear" type="button"><i class="fa fa-times"></i></button>
                    </span>
                    <div class="af-select-filter-dropdown" id="afDocProjectDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Projects</a>
                        <?php 
                            if(isset($projectDataArr) && count($projectDataArr)>0){
                                foreach($projectDataArr as $pro){
                        ?>
                        <a href="#" class="af-select-filter-option" data-value="<?php echo $pro['projectId'];?>"><?php echo htmlspecialchars($pro['projectName']);?></a>
                        <?php } } ?>
                    </div>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <button id="delProBtn" type="button" onclick="return deleteDoc();" class='btn btn-danger btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-trash"></i> Delete </button>
                <button id="addProBtn" type="button" onclick="return manageDoc('0');" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-plus"></i> Add New</button>
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Document Name/Title </th>
                            <th>Project</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php 
                        if(count($documentsDataArr) > 0){
                            $i = 1;
                            foreach($documentsDataArr as $row){                     
                                if($row['docType']==1){
                                    $rLnk = $row['docLnk'];
                                }else{
                                    $rLnk = base_url().'assets/upload/documents/other/'.$row['docFileName'];
                                }
                        ?>
                        <tr data-project-ids="<?php echo isset($row['projectIds']) ? htmlspecialchars($row['projectIds']) : '';?>">
                            <td> <input type="checkbox" class="case" id="docIds[]" name="docIds[]" value="<?php echo $row['docId'];?>" /> </td>
                            <td class="fw600"> <a <?php if($row['docType']==1 || $row['docFileExt']=='pdf'){ ?> target="_blank"<?php } ?> id="proTitle<?php echo $row['docId'];?>" class="cp" href="<?php echo $rLnk;?>"> <?php echo $row['docTitle']; ?> <i class="fa fa-external-link" aria-hidden="true"></i> </a> </td>
                            <td> <?php 
                            if(isset($row['projectIds']) && $row['projectIds']!=''){
                                $projectIdsArr = explode(',',$row['projectIds']);
                                foreach($projectIdsArr as $p){
                                   $pRes = filter_array($projectDataArr,$p,'projectId');
                                   if(count($pRes)>0){
                                    echo '<p class="py-0 my-1">'.$pRes[0]['projectName'].'</p>';
                                   }
                                }
                            }else{
                                echo '-';
                            }
                            ?></td>                           
                            <td nowrap>
                                <a class="btn btn-primary btn-sm" id="epro<?php echo $row['docId'];?>" onclick="return manageDoc('<?php echo $row['docId'];?>');">Edit</a>
                                <a class="btn btn-danger btn-sm" id="deldoc<?php echo $row['docId'];?>" onclick="return deleteSingleDoc('<?php echo $row['docId'];?>');" style="margin-left:3px;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $i++; }
                        } else { ?>
                        <tr class="no-data-row">
                            <td colspan="4" class="text-center py-5">
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
include(APPPATH.'views/system-admin/planning-documents/other-documents/pro-models.php');
?>

<script type="text/javascript">
$(function(){
    var selectedProject = '';

    function filterDocumentsTable(){
        var searchText = $('#documentSearchInput').val().toLowerCase();
        $('#table_recordtbl1 tbody tr').not('.no-data-row').each(function(){
            var $row = $(this);
            var rowText = $row.text().toLowerCase();
            var rowProjectIds = String($row.data('project-ids') || '');
            var projectIdsArr = rowProjectIds ? rowProjectIds.split(',') : [];
            
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesProject = true;
            if(selectedProject !== ''){
                matchesProject = (projectIdsArr.indexOf(selectedProject) > -1);
            }
            if(matchesSearch && matchesProject){ $row.show(); } else { $row.hide(); }
        });
    }

    /* Search bar */
    $('#documentSearchInput').on('input', function(){
        var v = $(this).val();
        if(v.length > 0){ $('#clearDocumentSearch').css('display','flex'); } else { $('#clearDocumentSearch').hide(); }
        filterDocumentsTable();
    });
    $('#clearDocumentSearch').on('click', function(){
        $('#documentSearchInput').val('');
        $(this).hide();
        filterDocumentsTable();
    });

    /* Project filter dropdown */
    $('#afDocProjectFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afDocProjectDropdown').toggleClass('show');
    });
    $('#afDocProjectDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        selectedProject = val ? val.toString() : '';
        $('#afDocProjectDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(selectedProject !== ''){
            $('#afDocProjectFilterBtn .af-select-filter-label').text($(this).text());
            $('#afDocProjectFilterBtn').addClass('active');
            $('#afDocProjectClear').css('display','inline-block');
        } else {
            $('#afDocProjectFilterBtn .af-select-filter-label').text('All Projects');
            $('#afDocProjectFilterBtn').removeClass('active');
            $('#afDocProjectClear').hide();
        }
        $('#afDocProjectDropdown').removeClass('show');
        filterDocumentsTable();
    });
    $('#afDocProjectClear').on('click', function(e){
        e.stopPropagation();
        selectedProject = '';
        $('#afDocProjectFilterBtn .af-select-filter-label').text('All Projects');
        $('#afDocProjectFilterBtn').removeClass('active');
        $(this).hide();
        $('#afDocProjectDropdown .af-select-filter-option').removeClass('selected');
        filterDocumentsTable();
    });

    /* Close on outside click */
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afDocProjectFilterWrap').length){ $('#afDocProjectDropdown').removeClass('show'); }
    });
});
</script>
</section>