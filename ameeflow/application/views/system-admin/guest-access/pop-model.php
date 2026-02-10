<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header lgtBlue-mh">
        <h5 class="modal-title" id="userModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="userFrm" action="access/manageAccessEntry" method="post">
			<input type="hidden" id="rauniversityId" name="rauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="racreatedBy" name="racreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
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
function deleteAccess(){
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
				url: '<?php echo base_url().$this->config->item('system_directory_name').'access/deleteAccess?uniAdminIds=';?>'+new_array,
				beforeSend: function(){
					$('#delBtn').prop("disabled", true);
					$('#delBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					window.location = '<?php echo base_url().$this->config->item('system_directory_name').'access';?>';      
				}
			});
		}
	}else{
		alert("Please select at least one user!");
		return false;
	}
}
function deleteSingleAccess(uniAdminId){
	var r = confirm("Are you sure you want to delete this guest access?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'access/deleteAccess?uniAdminIds=';?>'+uniAdminId,
			beforeSend: function(){
				$('#delrole'+uniAdminId).prop("disabled", true);
				$('#delrole'+uniAdminId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'access';?>';
			}
		});
	}
}
function update_toggle_swtich_values(uniAdminId,column_name){
	if(uniAdminId>0){
		var checkstatus=$('#toggle-event-'+column_name+uniAdminId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>access/updateAccessStatus?uniAdminId="+uniAdminId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+uniAdminId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+uniAdminId).html('');
				}
			}
		});
	} 
}
function manageAccess(gaId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'access/ajaxFormFields?gaId=';?>'+gaId,
        beforeSend: function(){
            if(parseInt(gaId)==0){
                $('#addBtn').prop("disabled", true);
                $('#addBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#userModalLabel').html('Guest Access');
            }else{
                $('#userModalLabel').html('Guest Access');
                $('#edrole'+gaId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageFieldSec').html(result);
            $('#userModal').modal('show');
            if(parseInt(gaId)==0){
                $('#addBtn').prop("disabled", false);
                $('#addBtn').html('<i class="fa fa-plus"></i> Add New');
            }else{
                $('#edrole'+gaId).html('Edit');
            }
        }
    });	    
}
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
			var btnText = $('#saveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#userFrm');
			var url = site_base_url+form.attr('action');
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
</script>