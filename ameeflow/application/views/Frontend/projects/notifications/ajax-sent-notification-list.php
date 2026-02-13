<?php
if(count($proSentNotificaionsDataArr)>0){
if(isset($subtaskDetails['subTaskId']) && $subtaskDetails['subTaskId']!='' && $subtaskDetails['subTaskId']>0){
	$subTaskId = $subtaskDetails['subTaskId'];
}else{
	$subTaskId = 0;
}
?>
<!-- Toolbar -->
<div class="af-noti-toolbar">
    <h5 class="af-noti-toolbar-title">
        <i class="fa fa-bell"></i> Notification: <?php if(isset($subtaskDetails['staskLbl']) && $subtaskDetails['staskLbl']!=''){echo $subtaskDetails['staskLbl'];}else{echo $taskDetailsArr['taskName'];}?>
    </h5>
    <div class="af-noti-toolbar-actions">
        <button type="button" class="af-noti-btn af-noti-btn-primary" id="addntProBtn" onclick="return manageProNoti('0','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $notiFor;?>','<?php echo $subTaskId;?>');"> <i class="fa fa-plus"></i> Add New</button>
        <button type="button" class="af-noti-btn af-noti-btn-warning" id="backSubTaskBtn" onclick="return backsubTaskList('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $proDetailsArr['proencryptId'];?>');"> <i class="fa fa-arrow-left"></i> SubTask List</button>
    </div>
</div>

<!-- Legend -->
<div class="af-noti-legend">
    <div class="af-noti-legend-item"><span class="af-noti-legend-dot sent"></span> Sent</div>
    <div class="af-noti-legend-item"><span class="af-noti-legend-dot pending"></span> Pending</div>
    <div class="af-noti-legend-item"><span class="af-noti-legend-dot failed"></span> Failed</div>
</div>

<!-- Notification Table -->
<div class="af-noti-table-wrap">
    <div class="table-responsive">
    <table class="af-noti-table">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th>Topic</th>
                <th>Message</th>
                <th>Send Date</th>
                <th>Follow up Date</th>
                <th>Response Option</th>
                <th>Recipients</th>
                <th style="text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
                foreach($proSentNotificaionsDataArr as $nt){ ?>
            <tr>
                <td><?php echo $i;?></td>
                <td class="fw600"><?php echo $nt['topic'];?></td>
                <td><a id="ntMsgSee<?php echo $nt['nId'];?>" onclick="return viewNotiMsg('<?php echo $nt['nId'];?>');" class="af-noti-view-link"><i class="fa fa-eye"></i> View</a></td>
                <td nowrap><?php echo date('m/d/Y',$nt['sendDate']);
                if($nt['sendDateSts']==1){
                    echo '&nbsp;<span class="af-noti-legend-dot sent"></span>';
                }else{
                     echo '&nbsp;<span class="af-noti-legend-dot pending"></span>';
                }
                ?></td>
                <td nowrap><?php if(isset($nt['followupDate']) && $nt['followupDate']!='' && $nt['followupDate']>0){echo date('m/d/Y',$nt['followupDate']);
                if($nt['followupDateSts']==1){
                    echo '&nbsp;<span class="af-noti-legend-dot sent"></span>';
                }else{
                     echo '&nbsp;<span class="af-noti-legend-dot pending"></span>';
                }
                 }else{ echo '&ndash;'; } ?></td>
                <td>
                    <?php 
                    if(isset($nt['resOptionId']) && $nt['resOptionId']!='' && $nt['resOptionId']>0){
                        $choiceRes = filter_array($resOptionsArr,$nt['resOptionId'],'resOptionId');
                        if(count($choiceRes)>0){
                            echo $choiceRes[0]['optName'];
                        }
                    }else{echo '&ndash;';}
                    ?>
                </td>
                <td><a id="ntRecpLog<?php echo $nt['nId'];?>" onclick="return viewRecipientsLog('<?php echo $nt['nId'];?>');" class="af-noti-view-link"><i class="fa fa-users"></i> View</a></td>
                <td style="text-align:center;"><a class="af-noti-edit-btn" id="nteditBtn<?php echo $nt['nId'];?>" onclick="return manageProNoti('<?php echo $nt['nId'];?>','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $notiFor;?>','<?php echo $subTaskId;?>');"><i class="icon-sm" data-feather="edit"></i></a></td>
            </tr>
            <?php $i++; }?>
        </tbody>
    </table>
    </div>
</div>
<?php }else{
    include(APPPATH.'views/Frontend/projects/notifications/ajax-noti-frm-fields.php');
}
?>