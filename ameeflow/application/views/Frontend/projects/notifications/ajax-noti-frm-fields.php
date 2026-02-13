<?php
if(isset($notiDetailsArr['nId']) && $notiDetailsArr['nId']!=''){
    $nId = $notiDetailsArr['nId'];
	$titleTxt = 'Edit';
}else{
    $nId = 0;
	$titleTxt = 'Add';
}
if(isset($subtaskDetails['subTaskId']) && $subtaskDetails['subTaskId']!='' && $subtaskDetails['subTaskId']>0){
	$subTaskId = $subtaskDetails['subTaskId'];
}else{
	$subTaskId = 0;
}
?>
<!-- Toolbar -->
<div class="af-noti-toolbar">
    <h5 class="af-noti-toolbar-title">
        <i class="fa fa-edit"></i> <?php echo $titleTxt;?> Notification &mdash; <?php if(isset($subtaskDetails['staskLbl']) && $subtaskDetails['staskLbl']!=''){echo $subtaskDetails['staskLbl'];}else{echo $taskDetailsArr['taskName'];}?>
    </h5>
    <div class="af-noti-toolbar-actions">
        <button type="button" class="af-noti-btn af-noti-btn-secondary" id="listntProBtn" onclick="return listProNoti('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $subTaskId;?>');"><i class="fa fa-arrow-left"></i> Back</button>
        <button type="button" class="af-noti-btn af-noti-btn-warning" id="backSubTaskBtn" onclick="return backsubTaskList('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $proDetailsArr['proencryptId'];?>');"><i class="fa fa-long-arrow-left"></i> SubTask List</button>
    </div>
</div>

<!-- Form Card -->
<div class="af-noti-form-card">
    <form id="sendNotiFrm" action="projects/sendNotiFromUsersEntry" method="post">
        <input type="hidden" id="ntuniversityId" name="ntuniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
        <input type="hidden" id="ntuniAdminId" name="ntuniAdminId" value="<?php echo $sessionDetailsArr['userId'];?>" />
        <input type="hidden" id="ntTaskId" name="ntTaskId" value="<?php echo $taskDetailsArr['taskId'];?>" />
        <input type="hidden" id="ntSubTaskId" name="ntSubTaskId" value="<?php echo $subTaskId;?>" />
        <input type="hidden" id="ntProjectId" name="ntProjectId" value="<?php echo $proDetailsArr['projectId'];?>" />
        <input type="hidden" id="ntNotiFor" name="ntNotiFor" value="<?php echo $notiFor;?>" />
        <input type="hidden" id="ntsendFrom" name="ntsendFrom" value="<?php echo $sendFrom;?>" />
        <input type="hidden" id="ntnId" name="ntnId" value="<?php echo $nId;?>" />

        <div class="af-noti-form-body">
            <!-- Topic -->
            <div class="af-noti-form-row cols-1">
                <div class="af-noti-form-group">
                    <label for="ntTopicName">Topic <span style="color:#e1304c;">*</span></label>
                    <input type="text" id="ntTopicName" name="ntTopicName" class="form-control required" placeholder="Enter notification topic..." value="<?php if(isset($notiDetailsArr['topic']) && $notiDetailsArr['topic']!=''){echo $notiDetailsArr['topic'];}else{ if(isset($subtaskDetails['staskLbl']) && $subtaskDetails['staskLbl']!=''){echo $subtaskDetails['staskLbl'];}else{echo $taskDetailsArr['taskName']; }}?>" autocomplete="off" />
                </div>
            </div>

            <!-- Message -->
            <div class="af-noti-form-row cols-1">
                <div class="af-noti-form-group">
                    <label for="ntSendMsg">Message <span style="color:#e1304c;">*</span> <span id="aiConLoader" class="aiLnk cp" onclick="return genSentNotiAIMsg('12','<?php echo $subTaskId;?>','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>');"><?php echo $this->config->item('aiButtonTxt');?></span></label>
                    <textarea rows="5" id="ntSendMsg" name="ntSendMsg" class="form-control"><?php if(isset($notiDetailsArr['sendMsg']) && $notiDetailsArr['sendMsg']!=''){echo $notiDetailsArr['sendMsg'];}?></textarea>
                </div>
            </div>

            <!-- Date & Options Row -->
            <div class="af-noti-form-row cols-3">
                <div class="af-noti-form-group">
                    <label for="ntsendDate">Send Date <span style="color:#e1304c;">*</span></label>
                    <input type="text" id="ntsendDate" name="ntsendDate" class="form-control required" placeholder="mm/dd/yyyy" value="<?php if(isset($notiDetailsArr['sendDate']) && $notiDetailsArr['sendDate']!='' && $notiDetailsArr['sendDate']>0){echo date('m/d/Y',$notiDetailsArr['sendDate']);}?>" autocomplete="off" />
                </div>
                <div class="af-noti-form-group">
                    <label for="ntfollowupDate">Follow up Date</label>
                    <input type="text" id="ntfollowupDate" name="ntfollowupDate" class="form-control" placeholder="mm/dd/yyyy" value="<?php if(isset($notiDetailsArr['followupDate']) && $notiDetailsArr['followupDate']!='' && $notiDetailsArr['followupDate']>0){echo date('m/d/Y',$notiDetailsArr['followupDate']);}?>" autocomplete="off" />
                </div>
                <div class="af-noti-form-group">
                    <label for="ntresOptionId">Response Option</label>
                    <select id="ntresOptionId" name="ntresOptionId" class="form-control">
                        <option value="0">Select...</option>
                        <?php foreach($resOptionsArr as $opt){?>
                            <option <?php if(isset($notiDetailsArr['resOptionId']) && $notiDetailsArr['resOptionId']==$opt['resOptionId']){?> selected<?php } ?> value="<?php echo $opt['resOptionId'];?>"><?php echo $opt['optName'];?></option>
                                <?php $choiceRes = filter_array($resOptionsChoiceArr,$opt['resOptionId'],'resOptionId');
                                if(count($choiceRes)>0){
                                    foreach($choiceRes as $choice){ ?>
                                        <option value="0" disabled> <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$choice['choiceName'];?></option>
                                    <?php }
                                } ?>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Recipients Panel -->
            <div class="af-recipients-panel">
                <h5><i class="fa fa-users"></i> Assign Recipients</h5>
                <div class="af-recipients-layout">
                    <!-- Roles sidebar -->
                    <div class="af-recipients-roles">
                        <?php
                        if(isset($notiDetailsArr['recipientsIds']) && $notiDetailsArr['recipientsIds']!=''){
                            $userRoleTypesArr = explode(',',$notiDetailsArr['recipientsIds']);
                        }else{
                            $userRoleTypesArr = array();
                        }
                        $user_roles = $this->config->item('user_roles_array_config');
                        foreach($user_roles as $key=>$value){ ?>
                            <label class="af-role-check-item" for="userRole<?php echo $key;?>">
                                <input onclick="return getSeniorRoleByuroleIds('<?php echo $nId;?>');" class="uroleCase" <?php if(in_array($key,$userRoleTypesArr)){?> checked<?php } ?> type="checkbox" id="userRole<?php echo $key;?>" name="userRoleTypes[]" value="<?php echo $key;?>" />
                                <span><?php echo $value['name']; if(isset($value['shortDesc']) && $value['shortDesc']!=''){echo ' &ndash; '.$value['shortDesc'];}?></span>
                            </label>
                        <?php } ?>
                    </div>
                    <!-- Users area -->
                    <div class="af-recipients-users">
                        <button type="button" id="toggleCheckboxBtn" class="af-check-all-btn">Check All</button>
                        <div class="row" id="uroleDataSec"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer / Submit -->
        <div class="af-noti-form-footer">
            <button type="submit" id="notiSendBtn" class="af-noti-save-btn"><i class="fa fa-check"></i> Save Notification</button>
        </div>
    </form>
</div>

<script>
<?php if(isset($notiDetailsArr['recipientsIds']) && $notiDetailsArr['recipientsIds']!=''){?>
$(function(){
	getSeniorRoleByuroleIds('<?php echo $nId;?>');
});
<?php } ?>
function getSeniorRoleByuroleIds(nId){
	var n = $(".uroleCase:checked").length;
	if(n>=1){
		var new_array=[];
		$(".uroleCase:checked").each(function() {
			var n_total=parseInt($(this).val());
			new_array.push(n_total);
		});
		$('#uroleDataSec').html(new_array);
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>projects/ajaxSelRolesUsersDataArr?roleIds='+new_array+'&nId='+nId,
            beforeSend: function(){
                $('#uroleDataSec').html('<h5>Please Wait <i class="fa fa-spinner fa-spin"></i></h5>');
            },
            success: function(result, status, xhr){
                $('#uroleDataSec').html(result);     
            }
        });
	}else{
		alert("Please select at least one role!");
		return false;
	}
}
function genSentNotiAIMsg(promptId,subTaskId,taskId,projectId){
	var topicName = $('#ntTopicName').val();
	var aiConLoaderTxt = $('#aiConLoader').html();
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().'projects/ajaxGenUserProMsgAIContent';?>',
		data: { 
			'topicName': topicName, 
			'subTaskId': subTaskId, 
			'promptId': promptId,
			'taskId': taskId, 
			'projectId': projectId
		},
		beforeSend: function(){
			$('#resNotiModel').html('');
			$('#aiConLoader').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			if(result!=''){
				CKEDITOR.instances['ntSendMsg'].setData(result);
			}else{
				$('#resNotiModel').html('<div class="alert alert-danger">Oops, please add your topic first.</div>');				
			}
			$('#aiConLoader').html(aiConLoaderTxt);
		}
	});	
}  
$(function(){	 
    let allChecked = false;
	$('#toggleCheckboxBtn').on('click', function () {
		allChecked = !allChecked;
		$('.caseRoleIds').prop('checked', allChecked);
		$(this).text(allChecked ? 'Uncheck All' : 'Check All');
	});    
    if($('#ntSendMsg').length > 0){
        CKEDITOR.replace( 'ntSendMsg',{height: '160px',}); 
    }
	$('#ntsendDate').datepicker({
		startDate: new Date(),
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true		
	});	
	$('#ntfollowupDate').datepicker({
		startDate: new Date(),
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true		
	});	
    $('#sendNotiFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#notiSendBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#sendNotiFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#resNotiModel').html('');
					$('#notiSendBtn').prop("disabled", true);
					$('#notiSendBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){ 
						$.ajax({
							type: "POST",
							url: '<?php echo base_url().'projects/ajaxSendNotiticationModal?tId=';?>'+result_arr[1]+'&sentById='+result_arr[2]+'&notiFor='+result_arr[3]+'&subTaskId='+result_arr[4],
							success: function(result, status, xhr){
								$('#sendNotiFieldSec').html(result);
								feather.replace();
							}
						});
					}else{						
						$('#resNotiModel').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');	
						$('#notiSendBtn').prop("disabled", false);
						$('#notiSendBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});	
});
</script>