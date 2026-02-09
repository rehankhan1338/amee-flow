<div class="modal fade" id="addProModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="addProModalLabel">Create your project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="addProFrm" action="projects/manageProEntry" method="post">
			<input type="hidden" id="mauniversityId" name="mauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="mauniAdminId" name="mauniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="macreatedBy" name="macreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="resDayT"></div>
			 <div class="row">					 
				<div id="manageProFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="addProSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function deleteProject(){
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
				url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/deleteProject?pIds=';?>'+new_array,
				beforeSend: function(){
					$('#delProBtn').prop("disabled", true);
					$('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					window.location = '<?php echo base_url().$this->config->item('system_directory_name').'projects';?>';      
				}
			});
		}
	}else{
		alert("Please select at least one project!");
		return false;
	}
}
function deleteSingleProject(projectId){
	var r = confirm("Are you sure you want to delete this project?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/deleteProject?pIds=';?>'+projectId,
			beforeSend: function(){
				$('#delpro'+projectId).prop("disabled", true);
				$('#delpro'+projectId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'projects';?>';
			}
		});
	}
}
function update_toggle_swtich_values(projectId,column_name){
	if(projectId>0){
		var checkstatus=$('#toggle-event-'+column_name+projectId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>projects/update_pro_status?projectId="+projectId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+projectId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+projectId).html('');
				}
			}
		});
	} 
}
function manageProject(pId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxProjectFields?pId=';?>'+pId,
        beforeSend: function(){
            if(parseInt(pId)==0){
                $('#addProBtn').prop("disabled", true);
                $('#addProBtn').html('<i class="fa fa-spinner fa-spin"></i> Project');
                $('#addProModalLabel').html('Create your project');
            }else{
                $('#addProModalLabel').html('Edit your project');
                $('#epro'+pId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageProFieldSec').html(result);
            $('#addProModal').modal('show');
            if(parseInt(pId)==0){
                $('#addProBtn').prop("disabled", false);
                $('#addProBtn').html('<i class="fa fa-plus"></i> Project');
            }else{
                $('#epro'+pId).html('Edit');
            }
        }
    });	    
}
$(document).ready(function () {
	$('#addProFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#addProSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#addProFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#addProSaveBtn').prop("disabled", true);
					$('#addProSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						//$('#dayTitleDiv').html(result_arr[1]);
						//$('#addProModal').modal('hide');
						//displayToaster(result_arr[0], '<?php //echo $msgText;?>');	
						//$('#addProSaveBtn').prop("disabled", false);
						//$('#addProSaveBtn').html(btnText);
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#addProSaveBtn').prop("disabled", false);
						$('#addProSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>
<!-- <div class="modal fade" id="manageTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="manageTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="manageTaskModalTitle">Add your Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="manageTaskFrm" action="projects/manageTaskEntry" method="post">
        <input type="hidden" id="mtuniversityId" name="mtuniversityId" value="<?php //echo $sessionDetailsArr['universityId'];?>" />
        <input type="hidden" id="mtuniAdminId" name="mtuniAdminId" value="<?php //echo $sessionDetailsArr['uniAdminId'];?>" />
        <div class="modal-body">
            <div id="resTaskModel"></div>
            <div id="manageTaskFieldSec">
			
            </div>		 		 
        </div> 
        <div class="modal-footer">
            <button type="submit" id="taskSaveBtn" class="btn btn-primary">Save</button>
        </div>
      </form>     
    </div>
  </div>
</div>
<script type="text/javascript">
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
				var site_base_url = '<?php //echo base_url().$this->config->item('system_directory_name');?>';
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
</script> -->