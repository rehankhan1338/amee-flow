<section class="content">         
    <div class="box">  

        <div class="box-header no-border">
            <h3 class="box-title">Other Documents</h3>
        </div>

        <!-- Toolbar: Search + File Type Filter -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <!-- Project Filter -->
                <div class="af-select-filter-wrap" id="afProjectFilterWrap">
                    <span class="af-select-filter-btn" id="afProjectFilterBtn" role="button">
                        <i class="fa fa-folder"></i>
                        <span class="af-select-filter-label">All Projects</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                        <button class="af-select-filter-clear" id="afProjectFilterClear" type="button"><i class="fa fa-times"></i></button>
                    </span>
                    <div class="af-select-filter-dropdown" id="afProjectFilterDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Projects</a>
                        <?php 
                            // Collect unique projects that appear in documents
                            $docProjectIds = array();
                            foreach($documentsDataArr as $doc){
                                if(isset($doc['projectIds']) && $doc['projectIds']!=''){
                                    $pIds = explode(',', $doc['projectIds']);
                                    foreach($pIds as $pid){
                                        $pid = trim($pid);
                                        if($pid!='' && !in_array($pid, $docProjectIds)){
                                            $docProjectIds[] = $pid;
                                        }
                                    }
                                }
                            }
                            foreach($projectDataArr as $pro){
                                if(in_array($pro['projectId'], $docProjectIds)){
                        ?>
                        <a href="#" class="af-select-filter-option" data-value="<?php echo $pro['projectId'];?>"><?php echo htmlspecialchars($pro['projectName']);?></a>
                        <?php } } ?>
                    </div>
                </div>
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i data-feather="search"></i></span>
                    <input type="text" class="af-roles-search-input" id="afDocSearchInput" placeholder="Search documents..." autocomplete="off">
                    <button type="button" class="af-roles-search-clear" id="afDocSearchClear"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <!-- File Type Filter -->
                <div class="af-select-filter-wrap" id="afFileTypeFilterWrap">
                    <span class="af-select-filter-btn" id="afFileTypeFilterBtn" role="button">
                        <i data-feather="file-text"></i>
                        <span class="af-select-filter-label">File Type</span>
                        <span class="af-select-filter-clear" id="afFileTypeFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-select-filter-dropdown" id="afFileTypeFilterDropdown">
                        <?php
                        // Collect unique file types
                        $fileTypes = array();
                        foreach($documentsDataArr as $doc){
                            if($doc['docType']==1){
                                $ft = 'URL';
                            } else {
                                $ft = strtoupper($doc['docFileExt']);
                            }
                            if(!in_array($ft, $fileTypes)){
                                $fileTypes[] = $ft;
                            }
                        }
                        sort($fileTypes);
                        foreach($fileTypes as $ft){ ?>
                            <a href="#" class="af-select-filter-option" data-value="<?php echo $ft; ?>">
                                <i class="fa <?php
                                    if($ft=='PDF') echo 'fa-file-pdf-o';
                                    elseif($ft=='DOCX' || $ft=='DOC') echo 'fa-file-word-o';
                                    elseif($ft=='XLSX' || $ft=='XLS') echo 'fa-file-excel-o';
                                    elseif($ft=='PPTX' || $ft=='PPT') echo 'fa-file-powerpoint-o';
                                    elseif($ft=='URL') echo 'fa-link';
                                    else echo 'fa-file-o';
                                ?>" style="margin-right:6px;opacity:.6;"></i>
                                <?php echo $ft; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="3%"> # </th>
                            <th>Document Name/Title </th>
                            <th>Project Name</th>
                            <th>File Type</th>
                            <!-- <th>Created On</th> -->
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($documentsDataArr as $row){                     
                                if($row['docType']==1){
                                    $rLnk = $row['docLnk'];
                                    $fileTypeLabel = 'URL';
                                }else{
                                    $rLnk = base_url().'assets/upload/documents/other/'.$row['docFileName'];
                                    $fileTypeLabel = strtoupper($row['docFileExt']);
                                }
                        ?>
                        <tr data-filetype="<?php echo $fileTypeLabel; ?>" data-project-ids="<?php echo isset($row['projectIds']) && $row['projectIds']!='' ? htmlspecialchars($row['projectIds']) : ''; ?>">
                            <td><?php echo $i;?></td>
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
                            <td>
                                <?php echo $fileTypeLabel; ?>
                            </td>
                            <!-- <td> <?php //echo date('m/d/Y, h:i A',$row['onTime']);?></td>                            -->
                            
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>

<script>
$(function(){
    feather.replace();

    var $searchInput = $('#afDocSearchInput'),
        $searchClear = $('#afDocSearchClear'),
        $rows        = $('#table_recordtbl1 tbody tr'),
        $table       = $('#table_recordtbl1');

    function filterTable(){
        var query         = $.trim($searchInput.val()).toLowerCase();
        var typeFilter    = $('#afFileTypeFilterWrap').data('selectedType') || '';
        var projectFilter = $('#afProjectFilterWrap').data('selectedProject') || '';

        $searchClear.css('display', query.length ? 'flex' : 'none');

        var visible = 0;
        $rows.each(function(){
            var $tr = $(this);
            if($tr.attr('id') === 'afDocNoResults') return;

            var text   = $tr.text().toLowerCase();
            var trType = $tr.attr('data-filetype') || '';
            var trProjectIds = ($tr.attr('data-project-ids') || '').toString();
            var projectIdsArr = trProjectIds ? trProjectIds.split(',') : [];

            var matchSearch  = !query || text.indexOf(query) !== -1;
            var matchType    = !typeFilter || trType === typeFilter;
            var matchProject = !projectFilter || projectIdsArr.indexOf(projectFilter) > -1;

            if(matchSearch && matchType && matchProject){
                $tr.show();
                visible++;
            } else {
                $tr.hide();
            }
        });

        // No results message
        $('#afDocNoResults').remove();
        if(visible === 0 && (query || typeFilter || projectFilter)){
            var colCount = $table.find('thead th').length;
            $table.find('tbody').append(
                '<tr id="afDocNoResults" class="af-roles-no-results"><td colspan="'+colCount+'">' +
                '<div style="padding:20px 0;"><i class="fa fa-search" style="font-size:1.5rem;color:#ccc;display:block;margin-bottom:8px;"></i>' +
                'No matching documents found</div></td></tr>'
            );
        }
    }

    // Search
    $searchInput.on('input', filterTable);
    $searchClear.on('click', function(){ $searchInput.val('').trigger('input').focus(); });
    $searchInput.on('keydown', function(e){ if(e.key==='Escape') $(this).val('').trigger('input'); });

    // --- Filter variable declarations ---
    var $ftBtn   = $('#afFileTypeFilterBtn'),
        $ftDrop  = $('#afFileTypeFilterDropdown'),
        $ftClear = $('#afFileTypeFilterClear'),
        $ftLabel = $ftBtn.find('.af-select-filter-label'),
        $ftWrap  = $('#afFileTypeFilterWrap');

    var $prBtn   = $('#afProjectFilterBtn'),
        $prDrop  = $('#afProjectFilterDropdown'),
        $prClear = $('#afProjectFilterClear'),
        $prLabel = $prBtn.find('.af-select-filter-label'),
        $prWrap  = $('#afProjectFilterWrap');

    // --- File Type filter ---
    $ftBtn.on('click', function(e){
        if($(e.target).closest('.af-select-filter-clear').length) return;
        $prDrop.removeClass('show');
        $ftDrop.toggleClass('show');
    });

    $ftDrop.on('click', '.af-select-filter-option', function(e){
        e.preventDefault();
        var val = $(this).data('value');
        $ftDrop.find('.af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        $ftWrap.data('selectedType', val);
        $ftLabel.text(val);
        $ftBtn.addClass('active');
        $ftClear.css('display', 'inline-flex');
        $ftDrop.removeClass('show');
        filterTable();
    });

    $ftClear.on('click', function(e){
        e.stopPropagation();
        $ftWrap.data('selectedType', '');
        $ftLabel.text('File Type');
        $ftBtn.removeClass('active');
        $ftClear.css('display', 'none');
        $ftDrop.find('.af-select-filter-option').removeClass('selected');
        filterTable();
    });

    // --- Project filter ---

    $prBtn.on('click', function(e){
        if($(e.target).closest('.af-select-filter-clear').length) return;
        $ftDrop.removeClass('show');
        $prDrop.toggleClass('show');
    });

    $prDrop.on('click', '.af-select-filter-option', function(e){
        e.preventDefault();
        var val = $(this).data('value');
        $prDrop.find('.af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(val !== '' && val !== undefined){
            $prWrap.data('selectedProject', val.toString());
            $prLabel.text($(this).text());
            $prBtn.addClass('active');
            $prClear.css('display', 'inline-block');
        } else {
            $prWrap.data('selectedProject', '');
            $prLabel.text('All Projects');
            $prBtn.removeClass('active');
            $prClear.css('display', 'none');
        }
        $prDrop.removeClass('show');
        filterTable();
    });

    $prClear.on('click', function(e){
        e.stopPropagation();
        $prWrap.data('selectedProject', '');
        $prLabel.text('All Projects');
        $prBtn.removeClass('active');
        $prClear.css('display', 'none');
        $prDrop.find('.af-select-filter-option').removeClass('selected');
        $prDrop.find('.af-select-filter-option').first().addClass('selected');
        filterTable();
    });

    // Close dropdowns on outside click
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afFileTypeFilterWrap').length){
            $ftDrop.removeClass('show');
        }
        if(!$(e.target).closest('#afProjectFilterWrap').length){
            $prDrop.removeClass('show');
        }
    });
});
</script>

</section>
