<script>
function taskNotification(taskId,subTaskId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'projects/ajaxSendNotiticationModal?tId=';?>'+taskId+'&subTaskId='+subTaskId,
        beforeSend: function(){
            $('#resNotiModel').html('');
            // $('#sendNotiModalTitle').html('Notification');
            $('#notiLnk'+subTaskId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#sendNotiFieldSec').html(result);
            $('#sendNotiModal').modal('show');
            $('#notiLnk'+subTaskId).html('<i class="icon-sm" data-feather="send"></i>');
            feather.replace();
        }
    });
}
function manageProNoti(nId,taskId,projectId,notiFor,subTaskId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'projects/ajaxAddProNotiFrm?tId=';?>'+taskId+'&pId='+projectId+'&notiFor='+notiFor+'&nId='+nId+'&subTaskId='+subTaskId,
        beforeSend: function(){
            $('#resNotiModel').html('');
            if(parseInt(nId)>0){
                $('#nteditBtn'+nId).html('<i class="fa fa-spinner fa-spin"></i>');
            }else{
                $('#addntProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
            }            
        },
        success: function(result, status, xhr){
            $('#sendNotiFieldSec').html(result);
        }
    });
}
function listProNoti(taskId,subTaskId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'projects/ajaxSendNotiticationModal?tId=';?>'+taskId+'&subTaskId='+subTaskId,
        beforeSend: function(){
            $('#resNotiModel').html('');
            $('#listntProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#sendNotiFieldSec').html(result);
            feather.replace();
        }
    });
}
function viewNotiMsg(nId){
    var btnText = $('#ntMsgSee'+nId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxNotiMsgModal?nId=';?>'+nId,
        beforeSend: function(){
            $('#ntComModalTitle').html('Message');
            $('#ntMsgSee'+nId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#ntComViewSec').html(result);
            var ntMsg = new bootstrap.Modal(document.getElementById('ntComViewModal'));
            ntMsg.show();
            $('#ntMsgSee'+nId).html(btnText);
        }
    });
}
function viewRecipientsLog(nId){
    var btnText = $('#ntRecpLog'+nId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxViewRecipientsLog?nId=';?>'+nId,
        beforeSend: function(){
            $('#ntComModalTitle').html('Recipients');
            $('#ntRecpLog'+nId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#ntComViewSec').html(result);
            var ntMsg = new bootstrap.Modal(document.getElementById('ntComViewModal'));
            ntMsg.show();
            $('#ntRecpLog'+nId).html(btnText);
        }
    });
}
function backsubTaskList(taskId, projectId, proencryptId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'projects/viewTaskDetails?tId=';?>'+taskId+'&pId='+projectId+'&epId='+proencryptId,
        beforeSend: function(){
            $('#backSubTaskBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
        },
        success: function(result, status, xhr){
            $('#sendNotiFieldSec').html(result); 
        }
    });	    
}
</script>
<div class="modal fade" id="sendNotiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sendNotiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen"> <!-- modal-sm -->
        <div class="modal-content ">	
            <div class="modal-header lgtBlue-mh">
                <h5 class="modal-title" id="sendNotiModalTitle"><?php echo 'Project: &nbsp;'.$proName;?></h5>
                <button type="button" class="btn-close" onclick="return closeTaskModal();"></button>
            </div>
            <div class="modal-body">
                <div id="resNotiModel" class="ajaxFrmRes"></div>
                <div id="sendNotiFieldSec">
                </div>		 		 
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ntComViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header lgtBlue-mh">
        <h5 class="modal-title" id="ntComModalTitle">Message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="ntComViewSec"></div>
      </div>
    </div>
  </div>
</div>