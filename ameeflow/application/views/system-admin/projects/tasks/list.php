<?php  
$tdAddSign = '<i class="fa fa-plus-square-o"></i>';
?>
 
<section class="content">
<!-- <a  class="plus_icon"> <img src="<?php echo base_url();?>assets/backend/images/plusIcon.svg" alt="" /> </a><h5>Projects  </h5> -->
            
    <div class="box">  
        
        <div class="box-header no-border">
            <div class="box-title">Project: &nbsp;<?php echo $projectDetails['projectName'];?>  <?php echo ' ('.$this->config->item('terms_assessment_array_config')[$projectDetails['termId']]['name'].' - '.$projectDetails['year'].')';?></div> 
            <div class="box-tools pull-right">
            <button id="delTaskBtn" type="button" onclick="return deleteTask('<?php echo $projectDetails['proencryptId'];?>','<?php echo $projectDetails['projectId'];?>');" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
            <a href="<?php echo base_url().$this->config->item('system_directory_name').'projects';?>" style="padding: 3px 15px; font-size:15px;" class='btn btn-primary'> <i class="fa fa-long-arrow-left"></i> Back </a>
                
                
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Main Task</th>
                            <th>Assigned To</th>
                            <th width="15%">Priority</th>
                            <th>Due Date</th>
                            <th>Notification Required?</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                    <?php 
                    $svgImgIcon = base_url().'assets/system-administrator/images/plus-circle-28.svg';
                    if(count($proTaskListDataArr) > 0){
                        $i = 1;
                        foreach($proTaskListDataArr as $task){
                            $priClsname = '';
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                $priClsname = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['clsName'];
                            }
                            ?>
                        <tr id="taskRow<?php echo $task['taskId'];?>">
                            <td> <input type="checkbox" class="case" id="taskIds[]" name="taskIds[]" value="<?php echo $task['taskId'];?>" /> </td>
                            <td class="fw600"> <a class="cp" onclick="return manageTask('<?php echo $task['taskId'];?>','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <span id="tskTitle<?php echo $task['taskId'];?>"><?php echo $task['taskName'];?></span> <span id="coltName<?php echo $task['taskId'];?>"><i class="icon-sm" data-feather="edit"></i><span> </a> </td>
                            <td>


<div id="assignedRoles<?php echo $task['taskId'];?>">
    <?php $assUsersCnt = getAssignedProTaskUsersListCh($task['taskId']);
    // echo count($assUsersCnt).'<br>';
    if(count($assUsersCnt)>0){ 
        foreach($assUsersCnt as $assUser){ if($assUser['assignSts']==0){?>
        <?php //echo 'test --- '.$assUser['userName'].'<br>';?>
        <label id="assRoleuId<?php echo $task['taskId'].$assUser['userId'];?>" class="arCls" style="background-color: <?php echo $assUser['usrbgColor']; ?>; color: <?php echo $assUser['usrfontColor']; ?>;" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $assUser['userName'].'<br />'.$this->config->item('user_types_array_config')[$assUser['userType']]['name'];?>"><?php echo getTwoCharsFromEachWord($assUser['userName']);?></label>
    <?php } } } ?>
</div>
<img class="cp" onclick="return manageRole('0','<?php echo $task['taskId'];?>','<?php echo $task['projectId'];?>');" src="<?php echo $svgImgIcon;?>" alt="" />

                            </td>
                            <td class="<?php echo $priClsname;?>" id="coltPri<?php echo $task['taskId'];?>"> <span class="cp fw600" onclick="return placeEdit('<?php echo $task['taskId'];?>');"><?php if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                echo $this->config->item('task_priority_options_array_config')[$task['priorityId']]['name'];
                                $prIcon = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['icon'];
                                if(isset($prIcon) && $prIcon!=''){
                                    echo ' &nbsp;'.$prIcon;
                                }
                                }else{echo $tdAddSign;}?> </span> </td> 
                            <td id="coltDate<?php echo $task['taskId'];?>"> <span class="cp fw600" onclick="return dueDateEdit('<?php echo $task['taskId'];?>');"><?php if(isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0){echo date('m/d/Y',$task['dueDateStr']);}else{echo $tdAddSign;}?> </span> </td>
                            <td>
                                <input <?php if(isset($task['reminderSts']) && $task['reminderSts']==1){?> checked="checked" <?php } ?> id="toggle-event-reminderSts<?php echo $task['taskId'];?>" onchange="return update_toggle_swtich_values('<?php echo $task['taskId'];?>','reminderSts');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Yes" data-off="No" type="checkbox">
                                <span id="spinner_reminderSts_<?php echo $task['taskId'];?>"></span>
                                <label id="notiArea<?php echo $task['taskId'];?>">
                                    <?php if(isset($task['reminderSts']) && $task['reminderSts']==1){
                                        // data-bs-toggle="tooltip" data-bs-placement="top" title="Send Notification"
                                        ?>
                                    &nbsp; <span id="notiLnk<?php echo $task['taskId'];?>" onclick="return manageNotification('<?php echo $task['taskId'];?>');" class="notiarCls"> <i class="icon-sm" data-feather="send"></i> </span>
                                    <?php } ?>
                                </label>
                            </td>
                            <td nowrap>
                                <a class="btn btn-danger btn-sm" id="deltask<?php echo $task['taskId'];?>" onclick="return deleteSingleTask('<?php echo $task['taskId'];?>','<?php echo $projectDetails['proencryptId'];?>','<?php echo $projectDetails['projectId'];?>');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $i++; }?>
                        <tr>
                            <td></td>
                            <td colspan="6"> <span id="anTaskBtn" class="cp fw600" onclick="return manageTask('0','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <i class="fa fa-plus"></i> Add task</span> </td>
                        </tr>
                    <?php } else { ?>
                        <tr class="no-data-row">
                            <td colspan="7" class="text-center py-5">
                                <div class="no-data-message">
                                    <i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p style="font-size: 1.1rem; color: #999; margin: 0; font-weight: 500;">No data found</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="6"> <span id="anTaskBtn" class="cp fw600" onclick="return manageTask('0','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <i class="fa fa-plus"></i> Add task</span> </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>							
            </div>
             
        </div>
    </div>
 
<script>
function update_toggle_swtich_values(taskId,column_name){
	if(taskId>0){
		var checkstatus=$('#toggle-event-'+column_name+taskId).prop('checked');
		if(checkstatus == true){
			var status=1;		
		}else{
			var status=0;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>projects/update_reminder_status?taskId="+taskId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+taskId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				var result_arr = result.split('||')
                if(result_arr[0]=='success'){
					$('#spinner_'+column_name+'_'+taskId).html('');
                    $('#notiArea'+taskId).html(result_arr[1]);
                    $('[data-bs-toggle="tooltip"]').tooltip({ html: true });
                    feather.replace();
				}
			}
		});
	} 
}
function deleteTask(proencryptId,projectId){
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
				url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/deleteTask?tIds=';?>'+new_array+'&epId='+proencryptId+'&projectId='+projectId,
				beforeSend: function(){
					$('#delTaskBtn').prop("disabled", true);
					$('#delTaskBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					window.location = '<?php echo base_url().$this->config->item('system_directory_name').'projects/tasks/'.$projectDetails['proencryptId'];?>';      
				}
			});
		}
	}else{
		alert("Please select at least one task!");
		return false;
	}
}
function deleteSingleTask(taskId, proencryptId, projectId){
	var r = confirm("Are you sure you want to delete this task?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/deleteTask?tIds=';?>'+taskId+'&epId='+proencryptId+'&projectId='+projectId,
			beforeSend: function(){
				$('#deltask'+taskId).prop("disabled", true);
				$('#deltask'+taskId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'projects/tasks/'.$projectDetails['proencryptId'];?>';
			}
		});
	}
}
function dueDateEdit(taskId){
    // var p = $('#coltDate'+taskId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxGetDueDateInput?tId=';?>'+taskId,
        beforeSend: function(){
            $('#coltDate'+taskId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#coltDate'+taskId).html(result);            
        }
    });
    
}
function placeEdit(taskId){
    var p = $('#coltPri'+taskId).html();
    var priField = '<select id="prio'+taskId+'" onchange="return updateTaskPri('+taskId+', this.value);" name="prio'+taskId+'" class="form-control required"> <option value="">Select...</option> <?php 
        $task_priority = $this->config->item('task_priority_options_array_config');
        foreach($task_priority as $key=>$value){ 
            if($value['status']==0){
                ?> <option value="<?php echo $key;?>"><?php echo $value['name'];?></option> <?php 
                } } ?></select> ';
    $('#coltPri'+taskId).html(priField);
    $('#coltPri'+taskId).removeClass();
}
function updateTaskPri(taskId,val){
    if(val!=''){
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxUpdateTaskPri?tId=';?>'+taskId+'&pId='+val,
            beforeSend: function(){
                $('#coltPri'+taskId).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){//alert(result);
                var result_arr = result.split('||')
                if(result_arr[0]=='success'){
                    $('#coltPri'+taskId).html(result_arr[1]);
                    $('#coltPri'+taskId).removeClass();
                    $('#coltPri'+taskId).addClass(result_arr[2]);
                }
            }
        });
    }
}
// $('#reminderSts').bootstrapToggle();
</script>
<?php 
include(APPPATH.'views/system-admin/projects/tasks/manage.php');
include(APPPATH.'views/system-admin/projects/tasks/manage-notifications.php');
include(APPPATH.'views/system-admin/projects/role-assignment/assign-role.php');
?>
</section>