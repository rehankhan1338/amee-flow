<div class="modal fade" id="manageTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="manageTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-sm -->
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="manageTaskModalTitle">Task Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="manageTaskFrm" action="projects/manageTaskEntry" method="post">
		
        <input type="hidden" id="mtuniversityId" name="mtuniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
        <input type="hidden" id="mtuniAdminId" name="mtuniAdminId" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
        <div class="modal-body">
            <div id="resTaskModel" class="ajaxFrmRes"></div>
            <div id="manageTaskFieldSec">
			
            </div>		 		 
        </div> 
        <div class="modal-footer">
            <button type="submit" id="taskSaveBtn" class="btn btn-primary" style="padding:5px 40px;">Save & Update</button>
			<button type="button" id="delSubTaskBtn" style="padding:5px 10px;" class="btn btn-danger btn-sm" onclick="return delSubTask();">Delete Subtask</button>
        </div>
      </form>     
    </div>
  </div>
</div>
<script type="text/javascript">
function manageTask(taskId, projectId, proencryptId){
    var taskName = $('#coltName'+taskId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxTaskFields?tId=';?>'+taskId+'&pId='+projectId+'&epId='+proencryptId,
        beforeSend: function(){
            if(parseInt(taskId)>0){
                $('#coltName'+taskId).html('<i class="fa fa-spinner fa-spin"></i>');
            }else{
                $('#anTaskBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
            }  
        },
        success: function(result, status, xhr){//alert(result);
            $('#manageTaskFieldSec').html(result);
            $('#manageTaskModal').modal('show');
			if(parseInt(taskId)>0){
            	$('#coltName'+taskId).html('<i class="icon-sm" data-feather="edit"></i>');
			}else{
				$('#anTaskBtn').html('<i class="fa fa-plus"></i> Add task');
			}
			feather.replace();
        }
    });	    
}
$(document).ready(function () {
	$('#manageTaskFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#taskSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#manageTaskFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#taskSaveBtn').prop("disabled", true);
					$('#taskSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						//$('#dayTitleDiv').html(result_arr[1]);
						//$('#addProModal').modal('hide');
						//displayToaster(result_arr[0], '<?php //echo $msgText;?>');	
						//$('#taskSaveBtn').prop("disabled", false);
						//$('#taskSaveBtn').html(btnText);
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#taskSaveBtn').prop("disabled", false);
						$('#taskSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
	 
});
function delSubTask(){
	var taskId = parseInt($('#mtTaskId').val());
	var n = $(".subTaskCase:checked").length;
	if(n>=1 && taskId>0){
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
			var new_array=[];
			$(".subTaskCase:checked").each(function() {
				var n_total=parseInt($(this).val());
				new_array.push(n_total);
			});
			$.ajax({
				type: "POST",
				url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/deleteSubTask?Ids=';?>'+new_array+'&taskId='+taskId,
				beforeSend: function(){
					$('#delSubTaskBtn').prop("disabled", true);
					$('#delSubTaskBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					$('#delSubTaskBtn').prop("disabled", false);
					$('#delSubTaskBtn').html('Delete Subtask');
					manageTask(taskId,'<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');
				}
			});
		}
	}else{
		alert("Please select at least one subtask!");
		return false;
	}
}
</script>