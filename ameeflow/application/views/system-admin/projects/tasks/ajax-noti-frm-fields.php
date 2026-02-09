<?php
if(isset($notiDetailsArr['nId']) && $notiDetailsArr['nId']!=''){
    $nId = $notiDetailsArr['nId'];
	$titleTxt = 'Edit';
}else{
    $nId = 0;
	$titleTxt = 'Add';
}
?>
<div class="row">
    <div class="col-md-6">
        <h5 class="fs18 fw600"><?php echo $titleTxt;?> your notification for <?php echo $taskDetailsArr['taskName'];?></h5>
    </div>
    <div class="col-md-6">
		<div class="pull-right">
			<button type="button" class="btn btn-warning mx-1 pd20" id="backTaskListBtn" onclick="return closeNotificationModal();"> <i class="fa fa-arrow-left"></i> Task List</button>
			<button type="button" class="btn btn-secondary pd20" id="listntProBtn" onclick="return listProNoti('<?php echo $taskDetailsArr['taskId'];?>');"> <i class="fa fa-long-arrow-left"></i> Back</button>
		</div>
    </div>  
</div>
<form id="sendNotiFrm" action="projects/sendProNotiEntry" method="post">
    <input type="hidden" id="ntuniversityId" name="ntuniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
    <input type="hidden" id="ntuniAdminId" name="ntuniAdminId" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
    <input type="hidden" id="ntTaskId" name="ntTaskId" value="<?php echo $taskDetailsArr['taskId'];?>" />
    <input type="hidden" id="ntProjectId" name="ntProjectId" value="<?php echo $proDetailsArr['projectId'];?>" />
    <input type="hidden" id="ntNotiFor" name="ntNotiFor" value="<?php echo $notiFor;?>" />
	<input type="hidden" id="ntnId" name="ntnId" value="<?php echo $nId;?>" />
    <div class="row">
        <div class="col-12 form-fields">
            <label class="form-label">Add a Topic *</label>
            <input type="text" id="ntTopicName" name="ntTopicName" class="form-control required" placeholder="" value="<?php if(isset($notiDetailsArr['topic']) && $notiDetailsArr['topic']!=''){echo $notiDetailsArr['topic'];}else{echo $taskDetailsArr['taskName'];}?>" autocomplete="off" />
        </div>
        <div class="col-12 form-fields">
            <label class="form-label">Message * <span id="aiConLoader" class="aiLnk cp" onclick="return genSentNotiAIMsg('5','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>');"><?php echo $this->config->item('aiButtonTxt');?></span> </label>
            <textarea rows="5" id="ntSendMsg" name="ntSendMsg" class="form-control"><?php if(isset($notiDetailsArr['sendMsg']) && $notiDetailsArr['sendMsg']!=''){echo $notiDetailsArr['sendMsg'];}?></textarea>
        </div>     	 
    </div>
	<div class="row">
		<div class="col-3 form-fields">
            <label class="form-label">Due Date *</label>
            <input type="text" id="ntDueDate" name="ntDueDate" readonly class="form-control required" placeholder="" value="<?php if(isset($taskDetailsArr['dueDateStr']) && $taskDetailsArr['dueDateStr']!='' && $taskDetailsArr['dueDateStr']>0){echo date('m/d/Y',$taskDetailsArr['dueDateStr']);}?>" autocomplete="off" />
        </div>
        <div class="col-3 form-fields">
            <label class="form-label">Schedule Send Date *</label>
            <input type="text" id="ntsendDate" name="ntsendDate" class="form-control required" placeholder="" value="<?php if(isset($notiDetailsArr['sendDate']) && $notiDetailsArr['sendDate']!='' && $notiDetailsArr['sendDate']>0){echo date('m/d/Y',$notiDetailsArr['sendDate']);}?>" autocomplete="off" />
        </div>
        <div class="col-3 form-fields">
            <label class="form-label">Schedule Follow up Date</label>
            <input type="text" id="ntfollowupDate" name="ntfollowupDate" class="form-control" placeholder="" value="<?php if(isset($notiDetailsArr['followupDate']) && $notiDetailsArr['followupDate']!='' && $notiDetailsArr['followupDate']>0){echo date('m/d/Y',$notiDetailsArr['followupDate']);}?>" autocomplete="off" />
        </div>
		<div class="col-3 form-fields">
            <label class="form-label">Response Option </label>
            <select id="ntresOptionId" name="ntresOptionId" class="form-control">
				<option value="0">Select...</option>
				<?php foreach($resOptionsArr as $opt){?>
					<option <?php if(isset($notiDetailsArr['resOptionId']) && $notiDetailsArr['resOptionId']==$opt['resOptionId']){?> selected<?php } ?> value="<?php echo $opt['resOptionId'];?>"><?php echo $opt['optName'];?></option>
					<?php					
						$choiceRes = filter_array($resOptionsChoiceArr,$opt['resOptionId'],'resOptionId');
						if(count($choiceRes)>0){
							$choiceOptArr = array();
							foreach($choiceRes as $choice){
							?>
							<option disabled value="0"><?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$choice['choiceName'];?></option>
							<?php
								// $choiceOptArr[] = $choice['choiceName'];
							}
							// echo ' ['.implode(', ',$choiceOptArr).']';
						}
					?>
				<?php } ?>
			</select>
        </div>      	 
    </div>
	<div class="">
		<h5>Assign Recipients</h5>
		<button type="button" id="toggleCheckboxBtn" style="padding:5px 30px; margin-top:10px;" class="btn btn-warning btn-sm mb-3">Check All</button>
		<div class="row mx-3">
			
		<?php 
		if(isset($notiDetailsArr['recipientsIds']) && $notiDetailsArr['recipientsIds']!=''){
			$recipientsIdsArr = explode(',',$notiDetailsArr['recipientsIds']);
		}else{
			$recipientsIdsArr = array();
		}
		if(isset($notiDetailsArr['userAccessIds']) && $notiDetailsArr['userAccessIds']!=''){
			$userAccessIdsArr = explode(',',$notiDetailsArr['userAccessIds']);
		}else{
			$userAccessIdsArr = array();
		}
		foreach($assignedUserDataArr as $assUser){ 
			$guestAccessDataArr = getGuestAccessListByAEch($assUser['userId']);?>
			<div class="col-3 form-fields">
				<label <?php if(count($guestAccessDataArr)>0){?>style="background:<?php echo $assUser['bgColor'];?>; color:<?php echo $assUser['fontColor'];?>;" <?php } ?> class="form-label w100 <?php if(count($guestAccessDataArr)>0){echo 'px-3 py-2';}?>" for="assuId<?php echo $assUser['userId'];?>"> <input class="caseRecpIds" <?php if(in_array($assUser['userId'],$recipientsIdsArr)){?> checked<?php } ?> type="checkbox" id="assuId<?php echo $assUser['userId'];?>" name="assuIds[]" value="<?php echo $assUser['userId'].'||0';?>" /> <?php echo $assUser['userName'];?> <small class="smallRecp"><?php echo $this->config->item('user_types_array_config')[$assUser['userType']]['name'];?></small> </label>
			</div> 
			<?php if(count($guestAccessDataArr)>0){
				foreach($guestAccessDataArr as $ga){ ?>
				<div class="col-3 form-fields" >
					<label style="background:<?php echo $assUser['bgColor'];?>; color:<?php echo $assUser['fontColor'];?>" class="w100 form-label px-3 py-2" for="assuaId<?php echo $ga['userAccessId'];?>"> <input class="caseRecpIds" <?php if(in_array($ga['userAccessId'],$userAccessIdsArr)){?> checked<?php } ?> type="checkbox" id="assuaId<?php echo $ga['userAccessId'];?>" name="assuIds[]" value="<?php echo $assUser['userId'].'||'.$ga['userAccessId'];?>" /> <?php echo $ga['auName'];?> <small class="smallRecp"><?php echo 'Guest by: '.$assUser['userName'];?></small> </label>
				</div> 
				<?php } } ?>

		<?php } ?>
		</div> 
	</div>				
    <div class="row mt-2">
        <div class="col-12 form-fields">
            <button type="submit" id="notiSendBtn" class="btn btn-primary" style="padding:5px 40px;">Save</button>
        </div>     	 
    </div>
</form>  
<script>
function genSentNotiAIMsg(promptId, taskId,projectId){
	var topicName = $('#ntTopicName').val();
	var aiConLoaderTxt = $('#aiConLoader').html();
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxGenProMsgAIContent';?>',
		data: { 
			'topicName': topicName, 
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
				// $('#ntSendMsg').html(result);
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
		$('.caseRecpIds').prop('checked', allChecked);
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
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
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
							url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxProSentNotificaionsDataArr?tId=';?>'+result_arr[1]+'&sentById='+result_arr[2]+'&notiFor='+result_arr[3],
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