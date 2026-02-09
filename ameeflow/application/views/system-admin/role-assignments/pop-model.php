<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="userFrm" action="roles/manageUser" method="post">
			<input type="hidden" id="rauniversityId" name="rauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="rauniAdminId" name="rauniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="racreatedBy" name="racreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="ajaxRes" class="ajaxFrmRes"></div>
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
	
function resendLoginDetails(){
	var n = $(".case:checked").length;
	if(n>=1){
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item('system_directory_name').'roles/resendLoginDetails?userIds=';?>'+new_array,
            beforeSend: function(){
                $('#resendBtn').prop("disabled", true);
                $('#resendBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().$this->config->item('system_directory_name').'roles';?>';      
            }
        });
	}else{
		alert("Please select at least one user!");
		return false;
	}
}
function deleteUser(){
	var n = $(".case:checked").length;
	if(n>=1){
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item('system_directory_name').'roles/deleteUser?userIds=';?>'+new_array,
            beforeSend: function(){
                $('#delBtn').prop("disabled", true);
                $('#delBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().$this->config->item('system_directory_name').'roles';?>';      
            }
        });
	}else{
		alert("Please select at least one user!");
		return false;
	}
}
function deleteSingleUser(userId){
	if(confirm('Are you sure you want to delete this user?')){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item('system_directory_name').'roles/deleteUser?userIds=';?>'+userId,
            beforeSend: function(){
                $('#delrole'+userId).prop("disabled", true);
                $('#delrole'+userId).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().$this->config->item('system_directory_name').'roles';?>';      
            }
        });
    }
    return false;
}
function update_toggle_swtich_values(userId,column_name){
	if(userId>0){
		var checkstatus=$('#toggle-event-'+column_name+userId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>roles/updateUserStatus?userId="+userId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+userId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+userId).html('');
				}
			}
		});
	} 
}
function manageUser(userId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'roles/ajaxFormFields?userId=';?>'+userId,
        beforeSend: function(){
            if(parseInt(userId)==0){
                $('#addBtn').prop("disabled", true);
                $('#addBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#userModalLabel').html('Add new user');
            }else{
                $('#userModalLabel').html('Edit user');
                $('#edrole'+userId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageFieldSec').html(result);
            $('#userModal').modal('show');
            if(parseInt(userId)==0){
                $('#addBtn').prop("disabled", false);
                $('#addBtn').html('<i class="fa fa-plus"></i> Add New');
            }else{
                $('#edrole'+userId).html('Edit');
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
			var btnText = $('#userSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
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
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#ajaxRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
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