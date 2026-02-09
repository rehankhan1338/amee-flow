<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header lgtBlue-mh">
        <h5 class="modal-title" id="userModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="userFrm" action="access/manageAccessEntry" method="post">
			<input type="hidden" id="rauniversityId" name="rauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
			<input type="hidden" id="rauniShortName" name="rauniShortName" value="<?php echo $sessionDetailsArr['shortName'];?>" />
            <input type="hidden" id="rauserId" name="rauserId" value="<?php echo $sessionDetailsArr['userId'];?>" />
            <input type="hidden" id="racreatedBy" name="racreatedBy" value="<?php echo $sessionDetailsArr['userAccessId'];?>" />
			<input type="hidden" id="senderName" name="senderName" value="<?php echo $sessionDetailsArr['auName'];?>" />
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
		var new_array=[];
		$(".case:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'access/deleteAccess?userAccessIds=';?>'+new_array,
            beforeSend: function(){
                $('#delBtn').prop("disabled", true);
                $('#delBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                window.location = '<?php echo base_url().'access';?>';      
            }
        });
	}else{
		alert("Please select at least one user!");
		return false;
	}
}
function update_toggle_swtich_values(userAccessId,column_name){
	if(userAccessId>0){
		var checkstatus=$('#toggle-event-'+column_name+userAccessId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url();?>access/updateAccessStatus?userAccessId="+userAccessId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+userAccessId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+userAccessId).html('');
				}
			}
		});
	} 
}
function manageAccess(gaId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'access/ajaxFormFields?gaId=';?>'+gaId,
        beforeSend: function(){
            if(parseInt(gaId)==0){
                $('#addBtn').prop("disabled", true);
                $('#addBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#userModalLabel').html('Add new access');
            }else{
                $('#userModalLabel').html('Edit access');
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
			var site_base_url = '<?php echo base_url();?>';
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