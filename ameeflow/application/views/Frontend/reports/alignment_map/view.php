<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
$(function(){
    var mamTable = $('#table_recordtbl1').DataTable({
        dom: "<'row'<'col-sm-12 col-md-12 mb-3 mt-3 ms-3'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4 text-center'l><'col-sm-12 col-md-4'p>>",
        paging: true,
        pageLength: 100,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        scrollX: true,
        fixedColumns: {
            leftColumns: 2,
            rightColumns: <?php echo (isset($sharePermission) && $sharePermission==1) ? '1' : '0'; ?>
        },
        columnDefs: [
            { orderable: false, targets: 0 }
        ],
        drawCallback: function(settings) {
            feather.replace();
        }
    });

    /* ── Top horizontal scrollbar (between thead and tbody) ── */
    /* ── + Sticky thead under fixed navbar ── */
    (function(){
        var $wrapper    = $('#table_recordtbl1_wrapper');
        var $scrollHead = $wrapper.find('.dataTables_scrollHead');
        var $scrollBody = $wrapper.find('.dataTables_scrollBody');
        if(!$scrollHead.length || !$scrollBody.length) return;

        // ── Create top scrollbar and insert between scrollHead and scrollBody ──
        var $topBar = $('<div id="mam-top-scrollbar"><div id="mam-top-scrollbar-inner"></div></div>');
        $scrollHead.after($topBar);

        function syncTopBarWidth(){
            var sw = $scrollBody[0].scrollWidth;
            $('#mam-top-scrollbar-inner').css('width', sw + 'px');
            $topBar.css('width', $scrollBody.outerWidth() + 'px');
        }
        syncTopBarWidth();

        // Bidirectional scroll sync (top scrollbar ↔ table body)
        var syncingFromBody = false;
        var syncingFromTop  = false;
        $topBar.on('scroll', function(){
            if(syncingFromBody) return;
            syncingFromTop = true;
            $scrollBody.scrollLeft($topBar.scrollLeft());
            syncingFromTop = false;
        });
        $scrollBody.on('scroll.topbar', function(){
            if(syncingFromTop) return;
            syncingFromBody = true;
            $topBar.scrollLeft($scrollBody.scrollLeft());
            syncingFromBody = false;
        });

        mamTable.on('draw.topbar', function(){ setTimeout(syncTopBarWidth, 50); });
        $(window).on('resize.topbar', function(){ syncTopBarWidth(); });

        // ── Sticky header clone ──
        var $sticky = $('<div id="mam-sticky-header"></div>');
        $('body').append($sticky);

        // Sticky scrollbar clone (appears right below sticky header)
        var $stickyBar = $('<div id="mam-sticky-scrollbar"><div id="mam-sticky-scrollbar-inner"></div></div>');
        $('body').append($stickyBar);

        var navH = $('.af-navbar').outerHeight() || 60;

        function buildClone(){
            $sticky.empty();
            var $clone = $scrollHead.children().clone(false);
            $sticky.append($clone);

            var $origThs  = $scrollHead.find('th');
            var $cloneThs = $sticky.find('th');
            $origThs.each(function(i){
                var w = $(this).outerWidth();
                $cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
            });

            var $origInner  = $scrollHead.find('.dataTables_scrollHeadInner');
            var $cloneInner = $sticky.find('.dataTables_scrollHeadInner');
            if($origInner.length){
                $cloneInner.css('width', $origInner[0].style.width || $origInner.outerWidth());
            }
            var $origTable  = $scrollHead.find('table').first();
            var $cloneTable = $sticky.find('table').first();
            if($origTable.length){
                $cloneTable.css('width', $origTable[0].style.width || $origTable.outerWidth());
            }

            // Update sticky scrollbar inner width
            var sw = $scrollBody[0].scrollWidth;
            $('#mam-sticky-scrollbar-inner').css('width', sw + 'px');
        }

        function syncScroll(){
            $sticky.scrollLeft($scrollBody.scrollLeft());
            $stickyBar.scrollLeft($scrollBody.scrollLeft());
        }

        function positionSticky(){
            var el = document.getElementById('mam-table-wrap');
            if(!el) return;
            var r = el.getBoundingClientRect();
            var stickyH = $sticky.outerHeight() || 0;
            $sticky.css({ left: r.left, width: r.width });
            $stickyBar.css({ left: r.left, width: r.width, top: navH + stickyH });
        }

        function onScroll(){
            var headRect = $scrollHead[0].getBoundingClientRect();
            var wrapEl   = document.getElementById('mam-table-wrap');
            if(!wrapEl) return;
            var wrapBottom = wrapEl.getBoundingClientRect().bottom;

            if(headRect.top < navH && wrapBottom > navH + 50){
                if(!$sticky.is(':visible')){
                    buildClone();
                }
                positionSticky();
                syncScroll();
                $sticky.show();
                $stickyBar.show();
            } else {
                $sticky.hide();
                $stickyBar.hide();
            }
        }

        // Sync horizontal scroll: body ↔ sticky header ↔ sticky scrollbar
        $scrollBody.on('scroll', function(){
            if($sticky.is(':visible')) syncScroll();
        });
        $sticky.on('scroll', function(){
            $scrollBody.scrollLeft($sticky.scrollLeft());
            $stickyBar.scrollLeft($sticky.scrollLeft());
        });
        $stickyBar.on('scroll', function(){
            $scrollBody.scrollLeft($stickyBar.scrollLeft());
            $sticky.scrollLeft($stickyBar.scrollLeft());
        });

        $(window).on('scroll', onScroll);
        $(window).on('resize', function(){
            navH = $('.af-navbar').outerHeight() || 60;
            $sticky.hide();
            $stickyBar.hide();
        });

        mamTable.on('draw', function(){
            $sticky.hide();
            $stickyBar.hide();
        });
    })();

    /* ── Department filter (dynamic) ── */
    function populateDepartmentFilter(){
        var departments = [];
        mamTable.column(1, { search: 'none' }).data().each(function(val){
            var txt = $.trim(val);
            if(txt.indexOf('-') !== -1){
                var prefix = txt.split('-')[0].trim();
                if(prefix && departments.indexOf(prefix) === -1){
                    departments.push(prefix);
                }
            }
        });
        departments.sort();
        var $dropdown = $('#afDepartmentDropdown');
        $dropdown.find('.af-select-filter-option:not(:first)').remove();
        $.each(departments, function(i, dept){
            $dropdown.append('<a href="#" class="af-select-filter-option" data-value="'+dept+'">'+dept+'</a>');
        });
    }
    populateDepartmentFilter();

    $('#afDepartmentBtn').on('click', function(e){
        e.stopPropagation();
        $('#afDepartmentDropdown').toggleClass('show');
        $('#afOversightDropdown').removeClass('show');
    });

    $(document).on('click', '#afDepartmentDropdown .af-select-filter-option', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        $('#afDepartmentDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(val && val !== ''){
            $('#afDepartmentBtn .af-select-filter-label').text(val);
            mamTable.column(1).search('^\\s*' + val + '\\s*-', true, false).draw();
        } else {
            $('#afDepartmentBtn .af-select-filter-label').text('All Departments');
            mamTable.column(1).search('').draw();
        }
        $('#afDepartmentDropdown').removeClass('show');
    });

    $(document).on('click', function(e){
        if(!$(e.target).closest('#afDepartmentWrap').length){ $('#afDepartmentDropdown').removeClass('show'); }
    });
});
</script>
<style>
	.af-sticky-header{
		padding: 0 !important;
	}
	</style>

<section class="content"> 
    <div class="box <?php if(isset($sharePermission) && $sharePermission==0){ echo 'mt-4';}?>"> 
        
        <?php if(!isset($sharePermission) || $sharePermission==1){ ?>
        <div class="box-header no-border">        
            <h3 class="box-title">Oversight Units</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-select-filter-wrap" id="afOversightWrap">
                    <span class="af-select-filter-btn" id="afOversightBtn" role="button">
                        <i class="fa fa-building"></i>
                        <span class="af-select-filter-label"><?php 
                            $mamLabel = 'Select Unit';
                            foreach($oversightsDataArr as $osd){
                                if($seloversigntId==$osd['oversigntId']){ $mamLabel = $osd['unitName']; }
                            }
                            echo htmlspecialchars($mamLabel);
                        ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afOversightDropdown">
                        <a href="#" class="af-select-filter-option" data-value="">Select...</a>
                    <?php foreach($oversightsDataArr as $osd){?>
                        <a href="#" class="af-select-filter-option <?php if($seloversigntId==$osd['oversigntId']){?> selected <?php }?>" data-value="<?php echo $osd['oversigntId'];?>"><?php echo htmlspecialchars($osd['unitName']);?></a>
                    <?php } ?>
                    </div>
                </div>
                <!-- Department Filter -->
                <div class="af-select-filter-wrap ms-3" id="afDepartmentWrap">
                    <span class="af-select-filter-btn" id="afDepartmentBtn" role="button">
                        <i class="fa fa-filter"></i>
                        <span class="af-select-filter-label">All Departments</span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afDepartmentDropdown">
                        <a href="#" class="af-select-filter-option selected" data-value="">All Departments</a>
                    </div>
                </div>
            </div>
            <div class="af-roles-toolbar-right" style="flex-wrap:wrap; gap:6px;">
                <button id="feedbackBtn" type="button" onclick="return viewFeedback('<?php echo $mamDetailsArr['mamId'];?>','<?php echo $sessionDetailsArr['userId'];?>');" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-comments"></i> Feedback</button>
                <button id="shareReportBtn" type="button" onclick="return shareReport();" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-share-alt"></i> Share</button>
            </div>
        </div>
        <?php } ?>

        <!-- SLO Color Legend -->
        <div class="mam-color-legend mt-3">
            <div class="mam-legend-title"><i class="fa fa-paint-brush"></i> Data legend for % of courses and SLO approaches:</div>
            <div class="mam-legend-grid">
                <div class="mam-legend-item"><span class="mam-legend-label">I</span><span class="mam-legend-swatch mam-clr-I"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">E</span><span class="mam-legend-swatch mam-clr-E"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">D</span><span class="mam-legend-swatch mam-clr-D"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">IE</span><span class="mam-legend-swatch mam-clr-IE"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">ID</span><span class="mam-legend-swatch mam-clr-ID"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">ED</span><span class="mam-legend-swatch mam-clr-ED"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">IED</span><span class="mam-legend-swatch mam-clr-IED"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">M</span><span class="mam-legend-swatch mam-clr-M"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">IP</span><span class="mam-legend-swatch mam-clr-IP"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">IM</span><span class="mam-legend-swatch mam-clr-IM"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">PM</span><span class="mam-legend-swatch mam-clr-PM"></span></div>
                <div class="mam-legend-item"><span class="mam-legend-label">IPM</span><span class="mam-legend-swatch mam-clr-IPM"></span></div>
            </div>
        </div>

        <div class="mam-note-info mt-3">
            <i class="fa fa-info-circle"></i>
            If your alignment map appears blank or incomplete, please verify that <strong>all required fields are fully and accurately filled out</strong>.
        </div>
       
        <div class="box-body">					 
            <div class="col-xs-12" id="mam-table-wrap">
                <table class="table" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Course</th>
                            <?php if($mamDetailsArr['ISLOCnt']>0){ for($is=1;$is<=$mamDetailsArr['ISLOCnt'];$is++){?>
                            <th class="mam-th-islo<?php if($is==1){echo ' mam-slo-group-start';}?>">ISLO<br /><small>(<?php echo $is;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GISLOCnt']>0){ for($gis=1;$gis<=$mamDetailsArr['GISLOCnt'];$gis++){?>
                            <th class="mam-th-gislo<?php if($gis==1){echo ' mam-slo-group-start';}?>">GISLO<br /><small>(<?php echo $gis;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['PSLOCnt']>0){ for($ps=1;$ps<=$mamDetailsArr['PSLOCnt'];$ps++){?>
                            <th class="mam-th-pslo<?php if($ps==1){echo ' mam-slo-group-start';}?>">PSLO<br /><small>(<?php echo $ps;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GPSLOCnt']>0){ for($gps=1;$gps<=$mamDetailsArr['GPSLOCnt'];$gps++){?>
                            <th class="mam-th-gpslo<?php if($gps==1){echo ' mam-slo-group-start';}?>">GPSLO<br /><small>(<?php echo $gps;?>)</small></th>
                            <?php } } ?>
                            <?php if(isset($sharePermission) && $sharePermission==1){?>
                                <th>Notes</th>
                            <?php } ?>   
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php 
                        $totalCols = 2 + $mamDetailsArr['ISLOCnt'] + $mamDetailsArr['GISLOCnt'] + $mamDetailsArr['PSLOCnt'] + $mamDetailsArr['GPSLOCnt'];
                        if(isset($sharePermission) && $sharePermission==1){ $totalCols++; }
                        $mamSloOptions = array('','Yes','I','E','D','IE','ID','ED','IED','M','IP','IM','PM','IPM');

                        // Helper: parse "1:I,3:ED" or legacy "1,3" into [1=>'I', 3=>'ED']
                        if(!function_exists('_parseSLOFront')){
                            function _parseSLOFront($str){
                                $r = array();
                                if(!isset($str) || $str==='') return $r;
                                foreach(explode(',',$str) as $item){
                                    $item = trim($item);
                                    if($item==='') continue;
                                    if(strpos($item,':')!==false){
                                        list($n,$v) = explode(':',$item,2);
                                        $r[trim($n)] = trim($v);
                                    } else {
                                        $r[$item] = 'Yes';
                                    }
                                }
                                return $r;
                            }
                        }

                        if(count($cousesDataArr) > 0){
                            $i = 1;
                            foreach($cousesDataArr as $row){ 
                                
                                // Parse SLO values into associative arrays  key=>value  e.g. [1=>'I', 3=>'ED']
                                $courseISLOMap  = _parseSLOFront(isset($row['courseISLO'])  ? $row['courseISLO']  : '');
                                $courseGISLOMap = _parseSLOFront(isset($row['courseGISLO']) ? $row['courseGISLO'] : '');
                                $coursePSLOMap = _parseSLOFront(isset($row['coursePSLO']) ? $row['coursePSLO'] : '');
                                $courseGPSLOMap = _parseSLOFront(isset($row['courseGPSLO']) ? $row['courseGPSLO'] : '');
                        ?>
                        <tr>
                            <td> <?php echo $i;?> </td>
                            <td nowrap class="mam-course-name"> <?php echo $row['courseSubject'].'-'.$row['courseNBR']; ?> </td>
                            <?php if($mamDetailsArr['ISLOCnt']>0){ for($is=1;$is<=$mamDetailsArr['ISLOCnt'];$is++){ $curVal = isset($courseISLOMap[$is]) ? $courseISLOMap[$is] : ''; ?>
                            <td class="mam-slo-cell<?php if($is==1){echo ' mam-slo-group-start';}?><?php if($curVal!='' && $curVal!='Yes') echo ' mam-td-'.$curVal;?>">
                                <select class="mam-slo-select<?php if($curVal!='' && $curVal!='Yes') echo ' mam-clr-'.$curVal;?>" data-course-id="<?php echo $row['mamCourseId'];?>" data-slo-type="ISLO" data-slo-number="<?php echo $is;?>">
                                    <?php foreach($mamSloOptions as $opt){ ?>
                                    <option value="<?php echo $opt;?>"<?php if($curVal==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '–' : $opt;?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GISLOCnt']>0){ for($gis=1;$gis<=$mamDetailsArr['GISLOCnt'];$gis++){ $curVal = isset($courseGISLOMap[$gis]) ? $courseGISLOMap[$gis] : ''; ?>
                            <td class="mam-slo-cell<?php if($gis==1){echo ' mam-slo-group-start';}?><?php if($curVal!='' && $curVal!='Yes') echo ' mam-td-'.$curVal;?>">
                                <select class="mam-slo-select<?php if($curVal!='' && $curVal!='Yes') echo ' mam-clr-'.$curVal;?>" data-course-id="<?php echo $row['mamCourseId'];?>" data-slo-type="GISLO" data-slo-number="<?php echo $gis;?>">
                                    <?php foreach($mamSloOptions as $opt){ ?>
                                    <option value="<?php echo $opt;?>"<?php if($curVal==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '–' : $opt;?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['PSLOCnt']>0){ for($ps=1;$ps<=$mamDetailsArr['PSLOCnt'];$ps++){ $curVal = isset($coursePSLOMap[$ps]) ? $coursePSLOMap[$ps] : ''; ?>
                            <td class="mam-slo-cell<?php if($ps==1){echo ' mam-slo-group-start';}?><?php if($curVal!='' && $curVal!='Yes') echo ' mam-td-'.$curVal;?>">
                                <select class="mam-slo-select<?php if($curVal!='' && $curVal!='Yes') echo ' mam-clr-'.$curVal;?>" data-course-id="<?php echo $row['mamCourseId'];?>" data-slo-type="PSLO" data-slo-number="<?php echo $ps;?>">
                                    <?php foreach($mamSloOptions as $opt){ ?>
                                    <option value="<?php echo $opt;?>"<?php if($curVal==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '–' : $opt;?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GPSLOCnt']>0){ for($gps=1;$gps<=$mamDetailsArr['GPSLOCnt'];$gps++){ $curVal = isset($courseGPSLOMap[$gps]) ? $courseGPSLOMap[$gps] : ''; ?>
                            <td class="mam-slo-cell<?php if($gps==1){echo ' mam-slo-group-start';}?><?php if($curVal!='' && $curVal!='Yes') echo ' mam-td-'.$curVal;?>">
                                <select class="mam-slo-select<?php if($curVal!='' && $curVal!='Yes') echo ' mam-clr-'.$curVal;?>" data-course-id="<?php echo $row['mamCourseId'];?>" data-slo-type="GPSLO" data-slo-number="<?php echo $gps;?>">
                                    <?php foreach($mamSloOptions as $opt){ ?>
                                    <option value="<?php echo $opt;?>"<?php if($curVal==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '–' : $opt;?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <?php } } ?>
                            <?php if(isset($sharePermission) && $sharePermission==1){?>
                                <td> <a class="mam-action-btn mam-btn-edit" id="editBtn<?php echo $row['mamCourseId'];?>" onclick="return manageNotesAM('<?php echo $row['mamCourseId'];?>','<?php echo $seloversigntId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a> </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; }
                        } else { ?>
                        <tr class="no-data-row">
                            <td colspan="<?php echo $totalCols; ?>" class="text-center py-5">
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
<?php if(isset($sharePermission) && $sharePermission==1){?>
<div class="modal fade" id="popCMAMModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCMAMModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCMAMModelLabel">Update your master alignment map</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCMAMFrm" action="sampling_plan/saveNotesAM" method="post">
			<div id="resCMAM" class="ajaxFrmRes"></div>
			 <div class="row">	
				<div id="manageCMAMFieldSec"></div>				 
				
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script> 
function manageNotesAM(mamCourseId,seloversigntId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/ajaxAMnotesField?mamCourseId=';?>'+mamCourseId+'&seloversigntId='+seloversigntId,
        beforeSend: function(){
            if(parseInt(mamCourseId)==0){
            }else{
                $('#popCMAMModelLabel').html('Add your note');
                $('#editBtn'+mamCourseId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageCMAMFieldSec').html(result);
            $('#popCMAMModel').modal('show');
            if(parseInt(mamCourseId)==0){
            }else{              
                $('#editBtn'+mamCourseId).html('<i class="icon-sm" data-feather="edit"></i>');
                feather.replace();
            }
        }
    });	    
}
$(document).ready(function () {
	$('#popCMAMFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popCMAMSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popCMAMFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popCMAMFrm').get(0));
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#popCMAMSaveBtn').prop("disabled", true);
					$('#popCMAMSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#resCMAM').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popCMAMSaveBtn').prop("disabled", false);
						$('#popCMAMSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script> 
<?php } ?>
<script>
/* ── SLO Color helpers ── */
var mamSloColors = ['I','E','D','IE','ID','ED','IED','M','IP','IM','PM','IPM'];
function mamApplyColor($sel, val){
    var $td = $sel.closest('td');
    for(var c=0;c<mamSloColors.length;c++){
        $sel.removeClass('mam-clr-'+mamSloColors[c]);
        $td.removeClass('mam-td-'+mamSloColors[c]);
    }
    if(val && val !== '' && val !== 'Yes'){
        $sel.addClass('mam-clr-'+val);
        $td.addClass('mam-td-'+val);
    }
}

/* ── SLO Dropdown (inline value selector) ── */
$(document).on('change', '.mam-slo-select', function(){
    var $sel      = $(this);
    var courseId   = $sel.data('course-id');
    var sloType   = $sel.data('slo-type');
    var sloNumber = $sel.data('slo-number');
    var value     = $sel.val();
    var prevValue = $sel.data('prev-value') || '';

    $sel.data('prev-value', prevValue);
    $sel.prop('disabled', true).addClass('mam-slo-saving');
    mamApplyColor($sel, value);

    $.ajax({
        type: 'POST',
        url: '<?php echo base_url();?>sampling_plan/toggleSLO',
        data: { mamCourseId: courseId, sloType: sloType, sloNumber: sloNumber, value: value },
        dataType: 'json',
        success: function(res){
            if(res.status === 'success'){
                $sel.data('prev-value', value);
            } else {
                $sel.val(prevValue);
                mamApplyColor($sel, prevValue);
                alert(res.message || 'Save failed');
            }
        },
        error: function(){
            $sel.val(prevValue);
            mamApplyColor($sel, prevValue);
            alert('Server error – could not save');
        },
        complete: function(){
            $sel.prop('disabled', false).removeClass('mam-slo-saving');
        }
    });
});
// Store initial values on page load for revert
$(function(){ $('.mam-slo-select').each(function(){ $(this).data('prev-value', $(this).val()); }); });
</script>
<script> 
function getOversigntData(val){
	if(val!=''){
        <?php if(isset($sharePermission) && $sharePermission==1){?>
		window.location = '<?php echo base_url().'sampling_plan/alignment_map?osd=';?>'+val;
        <?php }else{ ?>
        window.location = '<?php echo base_url().'share/alignment_map/'.$enwithShareId.'?osd=';?>'+val;
        <?php } ?>
	}
}
$(function(){
    /* Oversight dropdown */
    $('#afOversightBtn').on('click', function(e){
        e.stopPropagation();
        $('#afOversightDropdown').toggleClass('show');
    });
    $('#afOversightDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        if(val && val !== ''){
            getOversigntData(val);
        }
        $('#afOversightDropdown').removeClass('show');
    });
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afOversightWrap').length){ $('#afOversightDropdown').removeClass('show'); }
    });
});
</script>

<?php if(isset($sharePermission) && $sharePermission==1){
    include(APPPATH.'views/Frontend/reports/alignment_map/share-modal.php');
    include(APPPATH.'views/Frontend/reports/alignment_map/feedback-modal.php');
 }
?>

</section>
