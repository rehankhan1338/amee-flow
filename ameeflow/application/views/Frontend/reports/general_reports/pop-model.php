<div class="modal fade" id="reportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="reportFrm" action="general_reports/saveReport" method="post">
			<input type="hidden" id="rauniversityId" name="rauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="rauniAdminId" name="rauniAdminId" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<input type="hidden" id="rauserId" name="rauserId" value="<?php echo $sessionDetailsArr['userId'];?>" />
			<div id="ajaxRes" class="ajaxFrmRes"></div>
			 <div class="row">					 
				<div id="manageFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="saveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>

<script>
/* Single-row delete */
function deleteSingleReport(rId){
    if(!confirm('Are you sure you want to delete this report?')) return false;
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'general_reports/deleteReport?rIds=';?>'+rId,
        success: function(){
            window.location = '<?php echo base_url().'general_reports';?>';
        }
    });
}

/* Bulk delete */
function deleteReport(){
	var n = $(".case:checked").length;
	if(n>=1){
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'general_reports/deleteReport?rIds=';?>'+new_array,
            beforeSend: function(){
                $('#delBtn').prop("disabled", true);
                $('#delBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().'general_reports';?>';      
            }
        });
	}else{
		alert("Please select at least one report!");
		return false;
	}

}
function genAIGeneralReport(){
	var topicName = $('#ntTopicName').val();
	var topicContent = $('#ntTopicContent').val();
	var aiConLoaderTxt = $('#aiConLoader').html();
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().'general_reports/genAIGeneralReport';?>',
		data: { 
			'topicName': topicName,
			'topicContent': topicContent
		},
		beforeSend: function(){
			$('#ajaxRes').html('');
			$('#aiConLoader').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			if(result!=''){
				CKEDITOR.instances['reportSummary'].setData(result);
			}else{
				$('#ajaxRes').html('<div class="alert alert-danger">Oops, before generating report add your topic and content.</div>');				
			}
			$('#aiConLoader').html(aiConLoaderTxt);
		}
	});	
} 
function manageReport(rId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'general_reports/ajaxFormFields?rId=';?>'+rId,
        beforeSend: function(){
            if(parseInt(rId)==0){
                $('#addBtn').prop("disabled", true);
                $('#addBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#reportModalLabel').html('Add New Report');
            }else{
                $('#reportModalLabel').html('Edit Report');
                $('#edrole'+rId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageFieldSec').html(result);
            $('#reportModal').modal('show');
            if(parseInt(rId)==0){
                $('#addBtn').prop("disabled", false);
                $('#addBtn').html('<i class="fa fa-plus"></i> Add New');
            }else{
                $('#edrole'+rId).html('Edit');
            }
        }
    });	    
}
$(document).ready(function () {
	$('#reportFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#saveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#reportFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#saveBtn').prop("disabled", true);
					$('#saveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#ajaxRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#saveBtn').prop("disabled", false);
						$('#saveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});

/* ============================================================
   Search + Date Filter
   ============================================================ */
$(function(){
    feather.replace();

    var $searchInput = $('#afGrSearchInput'),
        $searchClear = $('#afGrSearchClear'),
        $rows        = $('#table_recordtbl1 tbody tr:not(.af-roles-no-results)'),
        $noResults   = $('#table_recordtbl1 .af-roles-no-results');

    function filterTable(){
        var query      = $.trim($searchInput.val()).toLowerCase();
        var dateFilter = $('#afGrDateFilterWrap').data('selectedDate') || '';

        $searchClear.css('display', query.length ? 'flex' : 'none');

        var visible = 0;
        $rows.each(function(){
            var $tr = $(this);
            var text   = $tr.text().toLowerCase();
            var trDate = $tr.attr('data-date') || '';

            var matchSearch = !query || text.indexOf(query) !== -1;
            var matchDate   = !dateFilter || trDate === dateFilter;

            if(matchSearch && matchDate){
                $tr.show();
                visible++;
            } else {
                $tr.hide();
            }
        });

        $noResults.toggle(visible === 0);
    }

    // Search
    $searchInput.on('input', filterTable);
    $searchClear.on('click', function(){ $searchInput.val('').trigger('input').focus(); });
    $searchInput.on('keydown', function(e){ if(e.key==='Escape') $(this).val('').trigger('input'); });

    // --- Date filter ---
    var $dateBtn   = $('#afGrDateFilterBtn'),
        $dateDrop  = $('#afGrDateFilterDropdown'),
        $dateClear = $('#afGrDateFilterClear'),
        $dateLabel = $dateBtn.find('.af-date-filter-label'),
        $dateWrap  = $('#afGrDateFilterWrap');

    $('#afGrDatePicker').datepicker({
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
        $dateLabel.text('Last Updated');
        $dateBtn.removeClass('active');
        $dateClear.css('display', 'none');
        $('#afGrDatePicker').datepicker('clearDates');
        filterTable();
    });

    // Close dropdown on outside click
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afGrDateFilterWrap').length && !$(e.target).closest('.datepicker').length){
            $dateDrop.removeClass('show');
        }
    });
});
</script>