<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
        feather.replace();
    });
</script> 
<?php $todayDate = strtotime(date('Y-m-d'));?>
<div class="">
    <input type="hidden" id="taskRedirectSts" value="0" />
    <div class="poptaskArea">
        <h5> <?php echo 'Task: '.$taskDetailsArr['taskName'];?> </h5>
        <?php if(isset($taskDetailsArr['dueDateStr']) && $taskDetailsArr['dueDateStr']!='' && $taskDetailsArr['dueDateStr']>0){?>
        <h6> <?php echo 'Due Date: '.date('m/d/Y',$taskDetailsArr['dueDateStr']);?> </h6>
        <?php } if(isset($taskDetailsArr['taskDesc']) && $taskDetailsArr['taskDesc']!=''){?>
           <?php echo $taskDetailsArr['taskDesc'];?>
        <?php } ?>
        <!-- <p> Priority: <label> <?php  //if(isset($taskDetailsArr['priorityId']) && $taskDetailsArr['priorityId']!='' && $taskDetailsArr['priorityId']>0){
                                //echo $this->config->item('task_priority_options_array_config')[$taskDetailsArr['priorityId']]['name']; } ?> </label> </p> -->
    </div>
    <?php if(count($subTaskDataArr)>0){ ?>
        <div class="popsubTaskArea px-3 mt-3">
            <h5>Sub Tasks</h5>
            <table class="table table-striped">
                <tr>
                    <th>Label</th>
                    <th>Short Description</th>
                    <th>Status</th>
                    <th>Notification</th>
                </tr>
                <?php foreach($subTaskDataArr as $subTask){
                     
                     
                    ?>
                <tr>
                    <td class="fw600"><?php echo $subTask['staskLbl'];?></td>
                    <td><?php echo $subTask['staskDesc'];?></td>
                    <td class="modalbsToggle">
                        <?php
                         $chkSts = chkTaskActionTakenSts($subTask['subTaskId'],$taskDetailsArr['taskId'],$taskDetailsArr['projectId'],$sessionDetailsArr['userId']);
                          if($todayDate<=$taskDetailsArr['dueDateStr']){?>
                           
<input <?php if($chkSts==1){?> checked="checked" <?php } ?> id="toggle-actionSts<?php echo $subTask['subTaskId'];?>" onchange="return takeActionOnSubTask('<?php echo $subTask['subTaskId'];?>','actionSts','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $taskDetailsArr['projectId'];?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Done" data-off="Pending" type="checkbox">
<span id="spinner_actionSts_<?php echo $subTask['subTaskId'];?>"></span>
<?php }else{  if($chkSts==1){ ?>
    <label class="mstus accepted" style="padding:1px 10px;">Completed</label>
    <?php }else{?>
        <label class="mstus pending" style="padding:1px 10px;">Pending</label>
    <?php } } ?>
        
                    </td>
                    <td>
                        <label id="notiArea<?php echo $subTask['subTaskId'];?>">            
                            &nbsp; <span id="notiLnk<?php echo $subTask['subTaskId'];?>" onclick="return taskNotification('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $subTask['subTaskId'];?>');" class="notiarCls"> <i class="icon-sm" data-feather="send"></i> </span>             
                        </label>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    <?php }else{  
        
        
         if($todayDate<=$taskDetailsArr['dueDateStr']){
            $chkSts = chkTaskActionTakenSts('0',$taskDetailsArr['taskId'],$taskDetailsArr['projectId'],$sessionDetailsArr['userId']);
        ?>
    <div class="modalbsToggle">
        <input <?php if($chkSts==1){?> checked="checked" <?php } ?> id="toggle-actionSts<?php echo $taskDetailsArr['taskId'];?>" onchange="return takeActionOnSubTask('0','actionSts','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $taskDetailsArr['projectId'];?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Done" data-off="Pending" type="checkbox">
        <span id="spinner_actionSts_<?php echo $taskDetailsArr['taskId'];?>"></span>
        <label id="notiArea<?php echo $taskDetailsArr['taskId'];?>">            
            &nbsp; <span id="notiLnk<?php echo $taskDetailsArr['taskId'];?>" onclick="return taskNotification('<?php echo $taskDetailsArr['taskId'];?>','0');" class="notiarCls"> <i class="icon-sm" data-feather="send"></i> </span>             
        </label>
    </div>
    <?php } } ?>
</div>