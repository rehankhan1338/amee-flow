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
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <div class="input-group input-group-sm" style="display:inline-flex; width:250px; margin-right:10px; vertical-align:middle;">
                    <input type="text" id="documentSearchInput" class="form-control" placeholder="Search documents..." style="height:34px;">
                    <span class="input-group-text" style="height:34px; cursor:pointer;" id="clearDocumentSearch"><i class="fa fa-times"></i></span>
                </div>
                <select id="projectFilter" class="form-control form-control-sm" style="display:inline-block; width:200px; height:34px; margin-right:10px; vertical-align:middle;">
                    <option value="">All Projects</option>
                    <?php 
                        if(isset($projectDataArr) && count($projectDataArr)>0){
                            foreach($projectDataArr as $pro){
                    ?>
                    <option value="<?php echo $pro['projectId'];?>"><?php echo htmlspecialchars($pro['projectName']);?></option>
                    <?php } } ?>
                </select>
                <button id="delProBtn" type="button" onclick="return deleteDoc();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addProBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageDoc('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
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
    // Initialize Select2 for project filter
    $('#projectFilter').select2({ placeholder: 'All Projects', allowClear: true, width: '200px' });

    // Filter function
    function filterDocumentsTable(){
        var searchText = $('#documentSearchInput').val().toLowerCase();
        var selectedProject = $('#projectFilter').val();

        $('#table_recordtbl1 tbody tr').each(function(){
            var rowText = $(this).text().toLowerCase();
            var rowProjectIds = String($(this).data('project-ids') || '');
            var projectIdsArr = rowProjectIds ? rowProjectIds.split(',') : [];
            
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesProject = true;
            if(selectedProject !== ''){
                matchesProject = (projectIdsArr.indexOf(selectedProject) > -1);
            }
            
            $(this).toggle(matchesSearch && matchesProject);
        });
    }

    // Search input event
    $('#documentSearchInput').on('keyup', function(){
        filterDocumentsTable();
    });

    // Clear search button
    $('#clearDocumentSearch').on('click', function(){
        $('#documentSearchInput').val('');
        filterDocumentsTable();
    });

    // Project filter change event
    $('#projectFilter').on('change', function(){
        filterDocumentsTable();
    });
});
</script>
</section>