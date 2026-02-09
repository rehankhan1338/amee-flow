<?php
if(count($proSentNotificaionsDataArr)>0){
if(isset($subtaskDetails['subTaskId']) && $subtaskDetails['subTaskId']!='' && $subtaskDetails['subTaskId']>0){
	$subTaskId = $subtaskDetails['subTaskId'];
}else{
	$subTaskId = 0;
}
?>
<div class="row">
    <div class="col-md-6">
        <h5 class="fs18 fw600">Notification: <?php if(isset($subtaskDetails['staskLbl']) && $subtaskDetails['staskLbl']!=''){echo $subtaskDetails['staskLbl'];}else{echo $taskDetailsArr['taskName'];}?></h5>
    </div>
    <div class="col-md-6 ">
        <div class="pull-right">
            <button type="button" class="btn btn-secondary pd20" id="addntProBtn" onclick="return manageProNoti('0','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $notiFor;?>','<?php echo $subTaskId;?>');"> <i class="fa fa-plus"></i> Add New</button>
            &nbsp;&nbsp;<button type="button" class="btn btn-warning pd20" id="backSubTaskBtn" onclick="return backsubTaskList('<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $proDetailsArr['proencryptId'];?>');"> <i class="fa fa-arrow-left"></i>  SubTask List</button>
         </div>
    </div>  
</div>
<div class="row mt-3">
<div class="col-md-12 mb-3">
    <label class="completed tskLegSts"></label> Sent &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class="inProgress tskLegSts"></label> Pending &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label class="notStarted tskLegSts"></label> Failed
</div>
<div class="col-xs-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th>Topic</th>
                <th>Message</th>
                <th>Send Date</th>
                <th>Follow up Date</th>
                <th>Response Option</th>
                <th>Recipients</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
                foreach($proSentNotificaionsDataArr as $nt){ ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $nt['topic'];?></td>
                <td> <a id="ntMsgSee<?php echo $nt['nId'];?>" onclick="return viewNotiMsg('<?php echo $nt['nId'];?>');" class="pro_name" > View </a></td>
                <td><?php echo date('m/d/Y',$nt['sendDate']);
                if($nt['sendDateSts']==1){
                    echo '&nbsp;<label class="completed tskLegSts"></label>';
                }else{
                     echo '&nbsp;<label class="inProgress tskLegSts"></label>';
                }
                ?></td>
                <td><?php if(isset($nt['followupDate']) && $nt['followupDate']!='' && $nt['followupDate']>0){echo date('m/d/Y',$nt['followupDate']);
                if($nt['followupDateSts']==1){
                    echo '&nbsp;<label class="completed tskLegSts"></label>';
                }else{
                     echo '&nbsp;<label class="inProgress tskLegSts"></label>';
                }
                 } ?></td>
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
                <td> <a id="ntRecpLog<?php echo $nt['nId'];?>" onclick="return viewRecipientsLog('<?php echo $nt['nId'];?>');" class="pro_name" > View </a></td>
                <td> <a class="deBtn" id="nteditBtn<?php echo $nt['nId'];?>" onclick="return manageProNoti('<?php echo $nt['nId'];?>','<?php echo $taskDetailsArr['taskId'];?>','<?php echo $proDetailsArr['projectId'];?>','<?php echo $notiFor;?>','<?php echo $subTaskId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a></td>
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