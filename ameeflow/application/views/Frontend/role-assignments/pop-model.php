<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="userFrm" action="roles/manageRole" method="post">
			<input type="hidden" id="rauniversityId" name="rauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="rauniAdminId" name="rauniAdminId" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="userRes"></div>
			 <div class="row">					 
				<div id="manageFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="userSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function deleteRole(){
	var n = $(".case:checked").length;
	if(n>=1){
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'roles/deleteRole?roleIds=';?>'+new_array,
            beforeSend: function(){
                $('#delBtn').prop("disabled", true);
                $('#delBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().'roles';?>';      
            }
        });
	}else{
		alert("Please select at least one user!");
		return false;
	}
}
function update_toggle_swtich_values(roleId,column_name){
	if(roleId>0){
		var checkstatus=$('#toggle-event-'+column_name+roleId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url();?>roles/updateStatus?roleId="+roleId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+roleId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+roleId).html('');
				}
			}
		});
	} 
}
function manageSRole(roleId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'roles/ajaxFormFields?roleId=';?>'+roleId,
        beforeSend: function(){
            if(parseInt(roleId)==0){
                // $('#addBtn').prop("disabled", true);
                $('#addBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#userModalLabel').html('Add new role');
            }else{
                $('#userModalLabel').html('Edit role');
                $('#edrole'+roleId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageFieldSec').html(result);
            $('#userModal').modal('show');
            if(parseInt(roleId)==0){
                // $('#addBtn').prop("disabled", false);
                $('#addBtn').html('<i class="fa fa-plus"></i> Add New');
            }else{
                $('#edrole'+roleId).html('Edit');
            }
        }
    });	    
}
/* ============================================================
   Single-row delete
   ============================================================ */
function deleteSingleRole(roleId){
	if(!confirm('Are you sure you want to delete this role?')) return false;
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().'roles/deleteRole?roleIds=';?>'+roleId,
		beforeSend: function(){},
		success: function(result, status, xhr){
			window.location = '<?php echo base_url().'roles';?>';      
		}
	});
}

/* ============================================================
   Search + Date filter
   ============================================================ */
$(document).ready(function(){

	// --- Search bar ---
	var $searchInput = $('#afRolesSearchInput'),
		$searchClear = $('#afRolesSearchClear'),
		$rows        = $('#table_recordtbl1 tbody tr'),
		$table       = $('#table_recordtbl1');

	function filterTable(){
		var query      = $.trim($searchInput.val()).toLowerCase();
		var dateFilter = $('#afDateFilterWrap').data('selectedDate') || '';
		var roleFilter = $('#afRoleFilterWrap').data('selectedRole') || '';

		$searchClear.css('display', query.length ? 'flex' : 'none');

		var visible = 0;
		$rows.each(function(){
			var $tr = $(this);
			if($tr.hasClass('af-roles-no-results')) return;

			var text   = $tr.text().toLowerCase();
			var trDate = $tr.attr('data-date') || '';
			var trRole = $tr.attr('data-role') || '';

			var matchSearch = !query || text.indexOf(query) !== -1;
			var matchDate   = !dateFilter || trDate === dateFilter;
			var matchRole   = !roleFilter || trRole === roleFilter;

			if(matchSearch && matchDate && matchRole){
				$tr.show();
				visible++;
			} else {
				$tr.hide();
			}
		});

		// Show/hide no results
		$('#afRolesNoResults').remove();
		if(visible === 0 && (query || dateFilter)){
			var colCount = $table.find('thead th').length;
			$table.find('tbody').append(
				'<tr id="afRolesNoResults" class="af-roles-no-results"><td colspan="'+colCount+'">' +
				'<div style="padding:20px 0;"><i class="fa fa-search" style="font-size:1.5rem;color:#ccc;display:block;margin-bottom:8px;"></i>' +
				'No matching records found</div></td></tr>'
			);
		}
	}

	$searchInput.on('input', filterTable);
	$searchClear.on('click', function(){ $searchInput.val('').trigger('input').focus(); });
	$searchInput.on('keydown', function(e){ if(e.key==='Escape') $(this).val('').trigger('input'); });

	// --- Date filter ---
	var $filterBtn   = $('#afDateFilterBtn'),
		$filterDrop  = $('#afDateFilterDropdown'),
		$filterClear = $('#afDateFilterClear'),
		$filterLabel = $filterBtn.find('.af-date-filter-label'),
		$filterWrap  = $('#afDateFilterWrap');

	// Init datepicker
	$('#afDatePicker').datepicker({
		format: 'mm/dd/yyyy',
		autoclose: false,
		todayHighlight: true
	}).on('changeDate', function(e){
		var dateStr = e.format('mm/dd/yyyy');
		$filterWrap.data('selectedDate', dateStr);
		$filterLabel.text(dateStr);
		$filterBtn.addClass('active');
		$filterClear.css('display', 'inline-flex');
		filterTable();
	});

	// Toggle dropdown
	$filterBtn.on('click', function(e){
		if($(e.target).closest('.af-date-filter-clear').length) return;
		$filterDrop.toggleClass('show');
	});

	// Clear date filter
	$filterClear.on('click', function(e){
		e.stopPropagation();
		$filterWrap.data('selectedDate', '');
		$filterLabel.text('Date Added');
		$filterBtn.removeClass('active');
		$filterClear.css('display', 'none');
		$('#afDatePicker').datepicker('clearDates');
		filterTable();
	});

	// Close dropdowns on outside click
	$(document).on('click', function(e){
		if(!$(e.target).closest('#afDateFilterWrap').length && !$(e.target).closest('.datepicker').length){
			$filterDrop.removeClass('show');
		}
		if(!$(e.target).closest('#afRoleFilterWrap').length){
			$('#afRoleFilterDropdown').removeClass('show');
		}
	});

	// --- Role Type filter ---
	var $roleBtn    = $('#afRoleFilterBtn'),
		$roleDrop   = $('#afRoleFilterDropdown'),
		$roleClear  = $('#afRoleFilterClear'),
		$roleLabel  = $roleBtn.find('.af-select-filter-label'),
		$roleWrap   = $('#afRoleFilterWrap');

	// Toggle dropdown
	$roleBtn.on('click', function(e){
		if($(e.target).closest('.af-select-filter-clear').length) return;
		$roleDrop.toggleClass('show');
	});

	// Select option
	$roleDrop.on('click', '.af-select-filter-option', function(e){
		e.preventDefault();
		var val = $(this).data('value');
		$roleDrop.find('.af-select-filter-option').removeClass('selected');
		$(this).addClass('selected');
		$roleWrap.data('selectedRole', val);
		$roleLabel.text(val);
		$roleBtn.addClass('active');
		$roleClear.css('display', 'inline-flex');
		$roleDrop.removeClass('show');
		filterTable();
	});

	// Clear role filter
	$roleClear.on('click', function(e){
		e.stopPropagation();
		$roleWrap.data('selectedRole', '');
		$roleLabel.text('Role Type');
		$roleBtn.removeClass('active');
		$roleClear.css('display', 'none');
		$roleDrop.find('.af-select-filter-option').removeClass('selected');
		filterTable();
	});
});

$(document).ready(function () {
	$('#userFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#userSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#userFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#userSaveBtn').prop("disabled", true);
					$('#userSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						//$('#dayTitleDiv').html(result_arr[1]);
						//$('#userModal').modal('hide');
						//displayToaster(result_arr[0], '<?php //echo $msgText;?>');	
						//$('#userSaveBtn').prop("disabled", false);
						//$('#userSaveBtn').html(btnText);
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#userSaveBtn').prop("disabled", false);
						$('#userSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>