<section class="content">
    <div class="box">         
        <div class="box-header no-border">
            <h3 class="box-title">Reports </h3>
            <div class="box-tools pull-right">                
                <button id="delProBtn" type="button" onclick="return deleteSamplingPlan();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <!-- <button id="emamBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageMam('<?php //echo $mamDetailsArr['ceId'];?>');" class='btn btn-primary'> Update Map </button>                -->
            </div>
        </div>

        <!-- Toolbar: Search + Filters -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i data-feather="search"></i></span>
                    <input type="text" class="af-roles-search-input" id="afSpSearchInput" placeholder="Search plans..." autocomplete="off">
                    <button type="button" class="af-roles-search-clear" id="afSpSearchClear"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <!-- Term/Year Filter -->
                <div class="af-select-filter-wrap" id="afTermFilterWrap">
                    <span class="af-select-filter-btn" id="afTermFilterBtn" role="button">
                        <i data-feather="bookmark"></i>
                        <span class="af-select-filter-label">Term / Year</span>
                        <span class="af-select-filter-clear" id="afTermFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-select-filter-dropdown" id="afTermFilterDropdown">
                        <?php
                        // Collect unique Term/Year values
                        $termYears = array();
                        foreach($userSamplingPlanDataArr as $sp){
                            $label = $this->config->item('terms_assessment_array_config')[$sp['termId']]['name'].' - '.$sp['year'];
                            if(!in_array($label, $termYears)){
                                $termYears[] = $label;
                            }
                        }
                        sort($termYears);
                        foreach($termYears as $ty){ ?>
                            <a href="#" class="af-select-filter-option" data-value="<?php echo $ty; ?>"><?php echo $ty; ?></a>
                        <?php } ?>
                    </div>
                </div>

                <!-- Created On Date Filter -->
                <div class="af-date-filter-wrap" id="afSpDateFilterWrap">
                    <span class="af-date-filter-btn" id="afSpDateFilterBtn" role="button">
                        <i data-feather="calendar"></i>
                        <span class="af-date-filter-label">Created On</span>
                        <span class="af-date-filter-clear" id="afSpDateFilterClear" role="button"><i class="fa fa-times"></i></span>
                    </span>
                    <div class="af-date-filter-dropdown" id="afSpDateFilterDropdown">
                        <div id="afSpDatePicker"></div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
                            <th>Term/Year</th>
                            <th>Created On</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($userSamplingPlanDataArr as $row){
                                $termYearLabel = $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year'];
                        ?>
                        <tr data-termyear="<?php echo $termYearLabel; ?>" data-date="<?php echo date('m/d/Y',$row['createTime']); ?>">
                            <td> <input type="checkbox" class="case" id="spIds[]" name="spIds[]" value="<?php echo $row['spId'];?>" />  </td>
                            <td class="fw600"> <a class="pro_name" href="<?php echo base_url().'sampling_plan/report/'.$row['speId'];?>"> <?php echo $termYearLabel; ?> </a>  </td>
                            <td> <?php echo date('m/d/y, h:i A',$row['createTime']);?> </td>
                            <td class="fw600"> <a id="vfbkLnk<?php echo $row['spId'];?>" class="pro_name" onclick="return viewFeedback('<?php echo $row['spId'];?>','<?php echo $shareReportFor;?>');">View</a> &nbsp;<?php echo '('.$row['feedbackCnt'].')';?> </td>
                            <td>
                                <?php $spApprovalDataArr = getApprovalDataArrCh($row['spId'],$shareReportFor);
                                if(count($spApprovalDataArr)>0){
                                    echo '<table class="">';
                                    foreach($spApprovalDataArr as $spApp){
                                        echo '<tr><td class="py-2">';
                                        echo $spApp['swName'].'</td> <td  class="px-2 py-2">';
                                        if($spApp['actionTakenSts']==0){echo '<label class="cscritical spAppSts">Pending</label>';}
                                        if($spApp['actionTakenSts']==1){echo '<label class="cslow spAppSts">Approved</label>';}
                                        if($spApp['actionTakenSts']==2){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="csmedium spAppSts">Approved w/Changes</label>';}
                                        if($spApp['actionTakenSts']==3){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="cshigh spAppSts">Rejected</label>';}
                                        
                                        echo '</td></tr>';
                                    } 
                                    echo '</table>';
                                }?>
                            </td>
                            <td nowrap> 
                                <a class="deBtn" href="<?php echo base_url().'sampling_plan/participants/'.$row['speId'];?>"> <i class="icon-sm" data-feather="edit"></i> </a> 
                                <?php if(isset($row['comment']) && $row['comment']!=''){?> <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row['comment'];?>" > <i class="icon-sm mx-2" data-feather="info"></i> </span> <?php } ?>
                                <button type="button" class="af-row-delete-btn" title="Delete" onclick="return deleteSingleSP('<?php echo $row['spId'];?>');">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
<script>
/* Single-row delete */
function deleteSingleSP(spId){
    if(!confirm('Are you sure you want to delete this sampling plan?')) return false;
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/deleteSamplingPlan?spIds=';?>'+spId,
        beforeSend: function(){},
        success: function(){
            window.location = '<?php echo base_url().'sampling_plan';?>';
        }
    });
}

/* Bulk delete */
function deleteSamplingPlan(){
	var n = $(".case:checked").length;
	if(n>=1){
        var r = confirm("Are you sure want to delete it!");
        if (r == true) {    
            var new_array=[];
            $(".case:checked").each(function() {
                var n_total=parseInt($(this).val());
                new_array.push(n_total);
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url().'sampling_plan/deleteSamplingPlan?spIds=';?>'+new_array,
                beforeSend: function(){
                    $('#delProBtn').prop("disabled", true);
                    $('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().'sampling_plan';?>';      
                }
            });
        }
	}else{
		alert("Please select at least one plan!");
		return false;
	}
}

/* ============================================================
   Search + Filters
   ============================================================ */
$(function(){
    feather.replace();

    var $searchInput = $('#afSpSearchInput'),
        $searchClear = $('#afSpSearchClear'),
        $rows        = $('#table_recordtbl1 tbody tr'),
        $table       = $('#table_recordtbl1');

    function filterTable(){
        var query      = $.trim($searchInput.val()).toLowerCase();
        var termFilter = $('#afTermFilterWrap').data('selectedTerm') || '';
        var dateFilter = $('#afSpDateFilterWrap').data('selectedDate') || '';

        $searchClear.css('display', query.length ? 'flex' : 'none');

        var visible = 0;
        $rows.each(function(){
            var $tr = $(this);
            if($tr.attr('id') === 'afSpNoResults') return;

            var text     = $tr.text().toLowerCase();
            var trTerm   = $tr.attr('data-termyear') || '';
            var trDate   = $tr.attr('data-date') || '';

            var matchSearch = !query || text.indexOf(query) !== -1;
            var matchTerm   = !termFilter || trTerm === termFilter;
            var matchDate   = !dateFilter || trDate === dateFilter;

            if(matchSearch && matchTerm && matchDate){
                $tr.show();
                visible++;
            } else {
                $tr.hide();
            }
        });

        // No results
        $('#afSpNoResults').remove();
        if(visible === 0 && (query || termFilter || dateFilter)){
            var colCount = $table.find('thead th').length;
            $table.find('tbody').append(
                '<tr id="afSpNoResults" class="af-roles-no-results"><td colspan="'+colCount+'">' +
                '<div style="padding:20px 0;"><i class="fa fa-search" style="font-size:1.5rem;color:#ccc;display:block;margin-bottom:8px;"></i>' +
                'No matching records found</div></td></tr>'
            );
        }
    }

    // Search
    $searchInput.on('input', filterTable);
    $searchClear.on('click', function(){ $searchInput.val('').trigger('input').focus(); });
    $searchInput.on('keydown', function(e){ if(e.key==='Escape') $(this).val('').trigger('input'); });

    // --- Term/Year filter ---
    var $termBtn   = $('#afTermFilterBtn'),
        $termDrop  = $('#afTermFilterDropdown'),
        $termClear = $('#afTermFilterClear'),
        $termLabel = $termBtn.find('.af-select-filter-label'),
        $termWrap  = $('#afTermFilterWrap');

    $termBtn.on('click', function(e){
        if($(e.target).closest('.af-select-filter-clear').length) return;
        $termDrop.toggleClass('show');
    });

    $termDrop.on('click', '.af-select-filter-option', function(e){
        e.preventDefault();
        var val = $(this).data('value');
        $termDrop.find('.af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        $termWrap.data('selectedTerm', val);
        $termLabel.text(val);
        $termBtn.addClass('active');
        $termClear.css('display', 'inline-flex');
        $termDrop.removeClass('show');
        filterTable();
    });

    $termClear.on('click', function(e){
        e.stopPropagation();
        $termWrap.data('selectedTerm', '');
        $termLabel.text('Term / Year');
        $termBtn.removeClass('active');
        $termClear.css('display', 'none');
        $termDrop.find('.af-select-filter-option').removeClass('selected');
        filterTable();
    });

    // --- Created On date filter ---
    var $dateBtn   = $('#afSpDateFilterBtn'),
        $dateDrop  = $('#afSpDateFilterDropdown'),
        $dateClear = $('#afSpDateFilterClear'),
        $dateLabel = $dateBtn.find('.af-date-filter-label'),
        $dateWrap  = $('#afSpDateFilterWrap');

    $('#afSpDatePicker').datepicker({
        format: 'mm/dd/yyyy',
        autoclose: false,
        todayHighlight: true
    }).on('changeDate', function(e){
        var dateStr = e.format('mm/dd/yyyy');
        $dateWrap.data('selectedDate', dateStr);
        $dateLabel.text(dateStr);
        $dateBtn.addClass('active');
        $dateClear.css('display', 'inline-flex');
        filterTable();
    });

    $dateBtn.on('click', function(e){
        if($(e.target).closest('.af-date-filter-clear').length) return;
        $dateDrop.toggleClass('show');
    });

    $dateClear.on('click', function(e){
        e.stopPropagation();
        $dateWrap.data('selectedDate', '');
        $dateLabel.text('Created On');
        $dateBtn.removeClass('active');
        $dateClear.css('display', 'none');
        $('#afSpDatePicker').datepicker('clearDates');
        filterTable();
    });

    // Close dropdowns on outside click
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afTermFilterWrap').length){
            $termDrop.removeClass('show');
        }
        if(!$(e.target).closest('#afSpDateFilterWrap').length && !$(e.target).closest('.datepicker').length){
            $dateDrop.removeClass('show');
        }
    });
});
</script>

<?php include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php'); ?>


</div>
</section>
