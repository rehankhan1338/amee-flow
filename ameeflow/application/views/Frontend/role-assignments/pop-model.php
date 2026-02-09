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