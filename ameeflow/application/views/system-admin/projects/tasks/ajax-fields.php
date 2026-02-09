<?php 
if(isset($taskDetailsArr['taskId']) && $taskDetailsArr['taskId']!=''){
    $taskId = $taskDetailsArr['taskId'];    
}else{
    $taskId = 0;    
}
if(isset($_GET['pId']) && $_GET['pId']!='' && $_GET['pId']>0){
    $pId = $_GET['pId'];
}else{
    $pId = 0;
}
if(count($subTaskDataArr)>0){ 
    $chkRemove = 0;
}else{
    $chkRemove = 1;
}
?>
<input type="hidden" id="mtTaskId" name="mtTaskId" value="<?php echo $taskId;?>" />
<input type="hidden" id="mtProjectId" name="mtProjectId" value="<?php echo $pId;?>" />
<input type="hidden" id="mtproencryptId" name="mtproencryptId" value="<?php if(isset($_GET['epId']) && $_GET['epId']!=''){echo $_GET['epId'];}else{echo '0';}?>" />
<input type="hidden" name="h_item_cnt" id="h_item_cnt" value="<?php if(count($subTaskDataArr)>0){echo '0';}else{echo '1';}?>" />
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Task Name/Label *</label>
        <input type="text" id="mtTastName" name="mtTastName" class="form-control required" placeholder="" value="<?php if(isset($taskDetailsArr['taskName']) && $taskDetailsArr['taskName']!=''){echo $taskDetailsArr['taskName'];}?>" autocomplete="off" />
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Description * <span id="aiConTaskLoader" class="aiLnk cp" onclick="return genSentTaskAIMsg('4','<?php echo $taskId;?>','<?php echo $pId;?>');"><?php echo $this->config->item('aiButtonTxt');?></span></label>
        <textarea rows="5" id="mtTastDesc" name="mtTastDesc" class="form-control"> <?php if(isset($taskDetailsArr['taskDesc']) && $taskDetailsArr['taskDesc']!=''){echo $taskDetailsArr['taskDesc'];}?> </textarea>
    </div>     	 
</div>
<div class="mt-3">
    <h5>Sub Task (optional)</h5>
    <?php if(count($subTaskDataArr)>0){ 
        foreach($subTaskDataArr as $st){?>
        <div class="row mt-2 mb-2">
            <div class="col-4">
                <input type="hidden" id="mtsubTaskId<?php echo $st['subTaskId'];?>" name="mtsubTaskIds[]" value="<?php echo $st['subTaskId'];?>" />
                <input type="checkbox" class="subTaskCase mt-2" id="popsubTaskIds[]" name="popsubTaskIds[]" value="<?php echo $st['subTaskId'];?>" />&nbsp;
                <input type="text" style="width: 88%;float: right;" id="mtOldSubTaskLbl<?php echo $st['subTaskId'];?>" name="mtOldSubTaskLbl<?php echo $st['subTaskId'];?>" class="form-control" placeholder="Subtask Label" value="<?php echo $st['staskLbl'];?>" autocomplete="off" />
            </div>
            <div class="col-8">
                <input type="text" id="mtOldSubTaskDesc<?php echo $st['subTaskId'];?>" name="mtOldSubTaskDesc<?php echo $st['subTaskId'];?>" class="form-control" placeholder="Subtask Short Description" value="<?php echo $st['staskDesc'];?>" autocomplete="off" />
            </div>
        </div>
    <?php } }else{ ?>
    <div class="row">
        <div class="col-4">            
            <input type="text" id="mtSubTaskLbl1" name="mtSubTaskLbl1" class="form-control" placeholder="Subtask Label" value="" autocomplete="off" />
        </div>
        <div class="col-8">
            <input type="text" id="mtSubTaskDesc1" name="mtSubTaskDesc1" class="form-control" placeholder="Subtask Short Description" value="" autocomplete="off" />
        </div>
    </div>
    <?php } ?>
    <div id="append_subTask"></div>
    <div class="mt-3 row" > 
        <div class="col-3">
            <button style="padding:3px 15px; margin:0 2px; " class="btn btn-secondary btn-sm" type="button" id="add_new_item_btn" onclick="return add_new_line_item();"> <i class="fa fa-plus"></i> Add More </button>
        </div>
        <div class="col-6"> </div>
        <div class="col-3">
            <button style="padding:3px 15px; margin:0 2px; display:none;" id="removeRowBtn" class="btn btn-warning btn-sm" type="button" onclick="return remove_line_item();"> <i class="fa fa-minus"></i> Remove</button>
        </div>        
        
    </div>
</div>
<script>
function genSentTaskAIMsg(promptId,taskId,projectId){
	var topicName = $('#mtTastName').val();
	var aiConLoaderTxt = $('#aiConTaskLoader').html();
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxGenProMsgAIContent';?>',
		data: { 
			'topicName': topicName, 
			'taskId': taskId, 
            'promptId': promptId,
			'projectId': projectId
		},
		beforeSend: function(){
			$('#resTaskModel').html('');
			$('#aiConTaskLoader').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			if(result!=''){
				CKEDITOR.instances['mtTastDesc'].setData(result);
			}else{
				$('#resTaskModel').html('<div class="alert alert-danger">Oops, please add your topic first.</div>');				
			}
			$('#aiConTaskLoader').html(aiConLoaderTxt);
		}
	});	
}     
$(function(){     
    if($('#mtTastDesc').length > 0){
        CKEDITOR.replace( 'mtTastDesc',{height: '160px',}); 
    }	
});
function add_new_line_item(){
	var item_cnt = parseInt($('#h_item_cnt').val());
	var n_item = item_cnt+1;
	var html='<div class="row moreItem mt-2 mb-2"> <div class="col-4"> <input type="text" id="mtSubTaskLbl'+n_item+'" name="mtSubTaskLbl'+n_item+'" class="form-control required" placeholder="Subtask Label" value="" autocomplete="off" /> </div> <div class="col-8"> <input type="text" id="mtSubTaskDesc'+n_item+'" name="mtSubTaskDesc'+n_item+'" class="form-control required" placeholder="Subtask Short Description" value="" autocomplete="off" /> </div> </div>';
	$('#append_subTask').append(html);
	$('#h_item_cnt').val(n_item);
    $('#removeRowBtn').show();
}
function remove_line_item(){
	var item_cnt = parseInt($('#h_item_cnt').val());
	if(item_cnt><?php echo $chkRemove;?>){
		var n_item = item_cnt-1;
		$('#h_item_cnt').val(n_item);
		$('.moreItem:last').remove();

        // alert(n_item+' ---- '+<?php echo $chkRemove;?>);
        if(n_item==<?php echo $chkRemove;?>){
            $('#removeRowBtn').hide();
        }
	}else{
        $('#removeRowBtn').hide();
    }
}
</script>