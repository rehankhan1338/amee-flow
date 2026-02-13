<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> 

<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
$(function(){ 
    var mamTable = $('#table_recordtbl_mam').DataTable({
        dom: "<'row'<'col-sm-12 col-md-12 mb-3 mt-3'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4 text-center'l><'col-sm-12 col-md-4'p>>",
        paging: true,
        pageLength: 100,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        scrollX: true,   // enable horizontal scroll
        fixedColumns: {
            leftColumns: 2,
            rightColumns: 1
        },
        columnDefs: [
            { orderable: false, targets: 0 } // Disable sorting on first column (index 0)
        ],
        drawCallback: function(settings) {
            feather.replace();
        }
    });

    /* ── Sticky thead under fixed navbar ── */
    (function(){
        var $wrapper   = $('#table_recordtbl_mam_wrapper');
        var $scrollHead = $wrapper.find('.dataTables_scrollHead');
        var $scrollBody = $wrapper.find('.dataTables_scrollBody');
        if(!$scrollHead.length) return;

        // Create the fixed clone container
        var $sticky = $('<div id="mam-sticky-header"></div>');
        $('body').append($sticky);

        var navH = $('.af-navbar').outerHeight() || 60; // actual navbar height

        function buildClone(){
            $sticky.empty();
            // Clone the entire scrollHead contents (inner wrapper + table)
            var $clone = $scrollHead.children().clone(false);
            $sticky.append($clone);

            // Copy computed widths for every <th>
            var $origThs = $scrollHead.find('th');
            var $cloneThs = $sticky.find('th');
            $origThs.each(function(i){
                var w = $(this).outerWidth();
                $cloneThs.eq(i).css({ 'min-width': w, 'max-width': w, 'width': w, 'box-sizing': 'border-box' });
            });

            // Match inner wrapper + table widths
            var $origInner = $scrollHead.find('.dataTables_scrollHeadInner');
            var $cloneInner = $sticky.find('.dataTables_scrollHeadInner');
            if($origInner.length){
                $cloneInner.css('width', $origInner[0].style.width || $origInner.outerWidth());
            }
            var $origTable = $scrollHead.find('table').first();
            var $cloneTable = $sticky.find('table').first();
            if($origTable.length){
                $cloneTable.css('width', $origTable[0].style.width || $origTable.outerWidth());
            }
        }

        function syncScroll(){
            $sticky.scrollLeft($scrollBody.scrollLeft());
        }

        function positionSticky(){
            var el = document.getElementById('mam-table-wrap');
            if(!el) return;
            var r = el.getBoundingClientRect();
            $sticky.css({ left: r.left, width: r.width });
        }

        function onScroll(){
            var headRect   = $scrollHead[0].getBoundingClientRect();
            var wrapEl     = document.getElementById('mam-table-wrap');
            if(!wrapEl) return;
            var wrapBottom = wrapEl.getBoundingClientRect().bottom;

            if(headRect.top < navH && wrapBottom > navH + 50){
                if(!$sticky.is(':visible')){
                    buildClone();
                }
                positionSticky();
                syncScroll();
                $sticky.show();
            } else {
                $sticky.hide();
            }
        }

        // Sync horizontal scroll both ways
        $scrollBody.on('scroll', function(){ if($sticky.is(':visible')) syncScroll(); });
        $sticky.on('scroll', function(){ $scrollBody.scrollLeft($sticky.scrollLeft()); });

        $(window).on('scroll', onScroll);
        $(window).on('resize', function(){
            navH = $('.af-navbar').outerHeight() || 60;
            $sticky.hide();          // will rebuild on next scroll tick
        });

        mamTable.on('draw', function(){
            $sticky.hide();          // rebuild on next scroll tick
        });
    })();
    
});
</script>

<section class="content">
 
    <div class="box"> 
        <!-- Note moved to styled .mam-note-info below -->
        <div class="box-header no-border">
            <h3 class="box-title">Oversight Units</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <!-- Oversight Unit Selector -->
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
            </div>
            <div class="af-roles-toolbar-right" style="flex-wrap:wrap; gap:6px;">
                <button id="downloadCourseBtn" type="button" onclick="return downloadMap();" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-download"></i> Download Excel</button>
                <button id="delProBtn" type="button" onclick="return deleteCourse('<?php echo $seloversigntId;?>');" class='btn btn-danger btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-trash"></i> Delete </button>
                <button id="emamBtn" type="button" onclick="return manageMam('<?php echo $mamDetailsArr['mamId'];?>');" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-pencil"></i> Update Map </button>
            </div>
        </div>
       
        <div class="mam-note-info mt-3">
            <i class="fa fa-info-circle"></i>
            If your alignment map appears blank or incomplete, please verify that <strong>all required fields are fully and accurately filled out</strong>.
        </div>
        <div class="box-body row">					 
            <div class="col-xs-12" id="mam-table-wrap">
                <table class="table" id="table_recordtbl_mam">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php 
                        $totalCols = 3 + $mamDetailsArr['ISLOCnt'] + $mamDetailsArr['GISLOCnt'] + $mamDetailsArr['PSLOCnt'] + $mamDetailsArr['GPSLOCnt'];
                        if(count($cousesDataArr) > 0){
                            $i = 1;
                            foreach($cousesDataArr as $row){ 
                                
                                if(isset($row['courseISLO']) && $row['courseISLO']!=''){
                                    $courseISLOArr = explode(',',$row['courseISLO']);
                                }else{
                                    $courseISLOArr = array();
                                }
                                
                                if(isset($row['courseGISLO']) && $row['courseGISLO']!=''){
                                    $courseGISLOArr = explode(',',$row['courseGISLO']);
                                }else{
                                    $courseGISLOArr = array();
                                }
                                if(isset($row['coursePSLO']) && $row['coursePSLO']!=''){
                                    $coursePSLOArr = explode(',',$row['coursePSLO']);
                                }else{
                                    $coursePSLOArr = array();
                                }
                                if(isset($row['courseGPSLO']) && $row['courseGPSLO']!=''){
                                    $courseGPSLOArr = explode(',',$row['courseGPSLO']);
                                }else{
                                    $courseGPSLOArr = array();
                                }
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="courseIds[]" name="courseIds[]" value="<?php echo $row['mamCourseId'];?>" /> </td>
                            <td nowrap class="mam-course-name"> <?php echo $row['courseSubject'].'-'.$row['courseNBR']; ?> </td>
                            <?php if($mamDetailsArr['ISLOCnt']>0){ for($is=1;$is<=$mamDetailsArr['ISLOCnt'];$is++){?>
                            <td class="mam-slo-cell<?php if($is==1){echo ' mam-slo-group-start';}?>"><?php if(in_array($is,$courseISLOArr)){echo '<span class="mam-yes-badge"><i class="fa fa-check"></i></span>';}else{echo '<span class="mam-no-badge">&ndash;</span>';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GISLOCnt']>0){ for($gis=1;$gis<=$mamDetailsArr['GISLOCnt'];$gis++){?>
                            <td class="mam-slo-cell<?php if($gis==1){echo ' mam-slo-group-start';}?>"><?php if(in_array($gis,$courseGISLOArr)){echo '<span class="mam-yes-badge"><i class="fa fa-check"></i></span>';}else{echo '<span class="mam-no-badge">&ndash;</span>';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['PSLOCnt']>0){ for($ps=1;$ps<=$mamDetailsArr['PSLOCnt'];$ps++){?>
                            <td class="mam-slo-cell<?php if($ps==1){echo ' mam-slo-group-start';}?>"><?php if(in_array($ps,$coursePSLOArr)){echo '<span class="mam-yes-badge"><i class="fa fa-check"></i></span>';}else{echo '<span class="mam-no-badge">&ndash;</span>';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GPSLOCnt']>0){ for($gps=1;$gps<=$mamDetailsArr['GPSLOCnt'];$gps++){?>
                            <td class="mam-slo-cell<?php if($gps==1){echo ' mam-slo-group-start';}?>"><?php if(in_array($gps,$courseGPSLOArr)){echo '<span class="mam-yes-badge"><i class="fa fa-check"></i></span>';}else{echo '<span class="mam-no-badge">&ndash;</span>';}?></td>
                            <?php } } ?>
                            <td nowrap> 
                                <a class="mam-action-btn mam-btn-edit" id="editBtn<?php echo $row['mamCourseId'];?>" onclick="return manageCourseMAM('<?php echo $row['mamCourseId'];?>','<?php echo $seloversigntId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a>
                                <a class="mam-action-btn mam-btn-view" id="noteBtn<?php echo $row['mamCourseId'];?>" onclick="return viewNote('<?php echo $row['mamCourseId'];?>');"> <i class="icon-sm" data-feather="eye"></i> </a>
                                <a class="mam-action-btn mam-btn-delete" id="delcourse<?php echo $row['mamCourseId'];?>" onclick="return deleteSingleCourse('<?php echo $row['mamCourseId'];?>','<?php echo $seloversigntId;?>');"><i class="fa fa-trash"></i></a>
                            </td>
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
<div class="modal fade" id="popCMAMModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCMAMModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCMAMModelLabel"><i class="fa fa-pencil-square-o" style="margin-right:6px;"></i> Update your master alignment map</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCMAMFrm" action="master_alignment_map/manageClassEntry" method="post">
			<div id="resCMAM" class="ajaxFrmRes"></div>
			<div id="manageCMAMFieldSec"></div>				 
			<div class="mt-3 pt-3" style="border-top:1px solid #e5e7eb;">
				<button type="submit" id="popCMAMSaveBtn" class="af-noti-btn af-noti-btn-primary" style="padding:10px 40px;"><i class="fa fa-check"></i> Save</button>
			</div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function downloadMap(){
    $('#downloadCourseBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
    var url = '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/download';?>'; 
    window.location.href = url;
    setTimeout(() => {
        $('#downloadCourseBtn').html('Download');
    }, 3000);
}
function deleteCourse(selceId){
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
                url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/deleteCourse?courseIds=';?>'+new_array,
                beforeSend: function(){
                    $('#delProBtn').prop("disabled", true);
                    $('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'master-alignment-map?osd=';?>'+selceId;      
                }
            });
        }
	}else{
		alert("Please select at least one course!");
		return false;
	}
}
function deleteSingleCourse(mamCourseId, seloversigntId){
	var r = confirm("Are you sure you want to delete this course?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/deleteCourse?courseIds=';?>'+mamCourseId,
			beforeSend: function(){
				$('#delcourse'+mamCourseId).prop("disabled", true);
				$('#delcourse'+mamCourseId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'master-alignment-map?osd=';?>'+seloversigntId;
			}
		});
	}
}
function manageCourseMAM(mamCourseId,seloversigntId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/ajaxCMAMFields?mamCourseId=';?>'+mamCourseId+'&seloversigntId='+seloversigntId,
        beforeSend: function(){
            if(parseInt(mamCourseId)==0){
            }else{
                $('#popCMAMModelLabel').html('Update your master alignment map');
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
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
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
						window.location = site_base_url+'master-alignment-map?osd=<?php echo $seloversigntId;?>';
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
<?php include(APPPATH.'views/system-admin/planning-documents/master-alignment-map/mam-model.php');
include(APPPATH.'views/system-admin/planning-documents/master-alignment-map/notes-modal.php');?>
<script>
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
</section>
