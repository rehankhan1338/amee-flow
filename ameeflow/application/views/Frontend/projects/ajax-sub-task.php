<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
        feather.replace();
    });
</script>

<?php $todayDate = strtotime(date('Y-m-d'));?>
<input type="hidden" id="taskRedirectSts" value="0" />

<!-- Task Detail Card -->
<div class="af-task-detail-card">
    <div class="af-task-detail-header">
        <h5><i class="fa fa-tasks"></i> <?php echo $taskDetailsArr['taskName'];?></h5>
        <?php if(isset($taskDetailsArr['dueDateStr']) && $taskDetailsArr['dueDateStr']!='' && $taskDetailsArr['dueDateStr']>0){?>
        <span class="af-task-due-badge">
            <i class="fa fa-calendar"></i> Due: <?php echo date('m/d/Y',$taskDetailsArr['dueDateStr']);?>
        </span>
        <?php } ?>
    </div>

    <?php if(isset($taskDetailsArr['taskDesc']) && $taskDetailsArr['taskDesc']!=''){?>
    <div class="af-task-detail-desc"><?php echo $taskDetailsArr['taskDesc'];?></div>
    <?php } ?>

    <div class="af-task-detail-body">
        <?php if(count($subTaskDataArr)>0){ ?>
        <!-- Sub Tasks -->
        <div class="af-subtask-section">
            <h5><i data-feather="list"></i> Sub Tasks</h5>
            <table class="af-subtask-table">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Short Description</th>
                        <th>Status</th>
                        <th style="text-align:center;">Notification</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($subTaskDataArr as $subTask){
                        $chkSts = chkTaskActionTakenSts($subTask['subTaskId'],$taskDetailsArr['taskId'],$taskDetailsArr['projectId'],$sessionDetailsArr['userId']);
                    ?>
                    <tr>
                        <td class="fw600"><?php echo $subTask['staskLbl'];?></td>
                        <td><?php echo $subTask['staskDesc'];?></td>
                        <td class="modalbsToggle">
                            <input <?php if($chkSts==1){?> checked="checked" <?php } ?> id="toggle-actionSts<?php echo $subTask['subTaskId'];?>" onchange="return takeActionOnSubTask('<?php echo $subTask['subTaskId'];?>','actionSts','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $taskDetailsArr['projectId'];?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Done" data-off="Pending" type="checkbox">
                            <span id="spinner_actionSts_<?php echo $subTask['subTaskId'];?>"></span>
                        </td>
                        <td style="text-align:center;">
                            <label id="notiArea<?php echo $subTask['subTaskId'];?>">
                                <span id="notiLnk<?php echo $subTask['subTaskId'];?>" onclick="return taskNotification('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $subTask['subTaskId'];?>');" class="af-subtask-noti-btn"> <i class="icon-sm" data-feather="send"></i> </span>
                            </label>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php }else{
            $chkSts = chkTaskActionTakenSts('0',$taskDetailsArr['taskId'],$taskDetailsArr['projectId'],$sessionDetailsArr['userId']);
        ?>
        <!-- Single task action -->
        <div class="af-task-single-action modalbsToggle">
            <input <?php if($chkSts==1){?> checked="checked" <?php } ?> id="toggle-actionSts<?php echo $taskDetailsArr['taskId'];?>" onchange="return takeActionOnSubTask('0','actionSts','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $taskDetailsArr['projectId'];?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Done" data-off="Pending" type="checkbox">
            <span id="spinner_actionSts_<?php echo $taskDetailsArr['taskId'];?>"></span>
            <label id="notiArea<?php echo $taskDetailsArr['taskId'];?>">
                <span id="notiLnk<?php echo $taskDetailsArr['taskId'];?>" onclick="return taskNotification('<?php echo $taskDetailsArr['taskId'];?>','0');" class="af-subtask-noti-btn"> <i class="icon-sm" data-feather="send"></i> </span>
            </label>
        </div>
        <?php }  ?>
    </div>
</div>

<?php
$otherDoc = getOtherDocumentByTaskIdCh($taskDetailsArr['taskId']);
if(count($otherDoc)>0){ ?>
<!-- Attachments -->
<div class="af-attach-section">
    <h5><i class="fa fa-paperclip"></i> Attachments</h5>
    <div class="af-attach-grid">
        <?php foreach($otherDoc as $od){
            if($od['docType']==1){
                $rLnk = $od['docLnk'];
            }else{
                $rLnk = base_url().'assets/upload/documents/other/'.$od['docFileName'];
            }
            // Determine icon class
            $iconClass = 'af-attach-icon-file';
            $iconFA = 'fa-file-text-o';
            if($od['docType']==1){
                $iconClass = 'af-attach-icon-link';
                $iconFA = 'fa-link';
            }else{
                if($od['docFileExt']=='pdf'){
                    $iconClass = 'af-attach-icon-pdf';
                    $iconFA = 'fa-file-pdf-o';
                }else if($od['docFileExt']=='doc' || $od['docFileExt']=='docx'){
                    $iconClass = 'af-attach-icon-word';
                    $iconFA = 'fa-file-word-o';
                }else if($od['docFileExt']=='xls' || $od['docFileExt']=='xlsx' || $od['docFileExt']=='csv'){
                    $iconClass = 'af-attach-icon-excel';
                    $iconFA = 'fa-file-excel-o';
                }else if($od['docFileExt']=='ppt' || $od['docFileExt']=='pptx'){
                    $iconClass = 'af-attach-icon-ppt';
                    $iconFA = 'fa-file-powerpoint-o';
                }
            }
        ?>
        <a <?php if($od['docType']==1 || $od['docFileExt']=='pdf'){ ?> target="_blank"<?php } ?> href="<?php echo $rLnk;?>" class="af-attach-card">
            <div class="af-attach-icon <?php echo $iconClass;?>">
                <i class="fa <?php echo $iconFA;?>"></i>
            </div>
            <div class="af-attach-name"><?php echo $od['docTitle'];?> <i class="fa fa-external-link"></i></div>
        </a>
        <?php } ?>
    </div>
</div>
<?php } ?>