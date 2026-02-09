<div class="modal fade" id="manageRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="manageRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="roleModalTitle">Assign Roles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div id="ajaxRoleRes">  </div>
            <div class="col-12"> <h5 id="roleModelSubTitle" class="mb-3"></h5>  </div>
        </div>
        <div class="row">					 
            <div id="manageRoleListSec"></div>
        </div>		 
      </div>      
    </div>
  </div>
</div>
<script>
function manageRole(raId,taskId,pId){
    var tskTitle = $('#tskTitle'+taskId).html(); 
    // var termYear = $('#proTerm'+pId).html();
    $('#roleModelSubTitle').html(tskTitle);   
    $('#manageRoleModal').modal('show');
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxRoleFields?raId=';?>'+raId+'&taskId='+taskId+'&pId='+pId,
        beforeSend: function(){
            $('#manageRoleListSec').html('<h5>Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i> </h5>');
        },
        success: function(result, status, xhr){
            $('#manageRoleListSec').html(result);
        }
    });	    
}
function assignassignStsInProjects(userId,column_name,pId,taskId){
	if(userId>0){
		var checkstatus=$('#toggle-'+column_name+userId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>projects/updateProAssignStatus?userId="+userId+"&column_name="+column_name+"&status="+status+"&pId="+pId+"&taskId="+taskId, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+userId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
          var result_arr = result.split('||')
          if(result_arr[0]=='success'){
            $('#spinner_'+column_name+'_'+userId).html('');
            if(parseInt(status)==0){
              $('#assignedRoles'+taskId).append(result_arr[2]);
              $('[data-bs-toggle="tooltip"]').tooltip({ html: true });
            }else{
              $('#assRoleuId'+taskId+userId).remove();
            }
          }else{
            $('#ajaxRoleRes').html(result_arr[1]);
          }
			}
		});
	} 
}
</script>