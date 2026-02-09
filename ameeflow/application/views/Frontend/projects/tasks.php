<section class="content">
<div class="box">
<?php $proName = $projectDetails['projectName'].' - '.$this->config->item('terms_assessment_array_config')[$projectDetails['termId']]['name'].' '.$projectDetails['year'];?>    
    <div class="box-header">
        <h5>Project: <?php echo $proName;?></h5>
        <div class="box-tools pull-right">   
            <a id="calBtn" style="padding: 3px 25px; margin-right:5px; font-size:15px;" href="<?php echo base_url().'projects/downloadTask/'.$projectDetails['proencryptId'];?>" class='btn btn-primary'> Add task to external calendar </a> 
        </div> 
        
    </div>
<div class="box-body userTaskPage">
 
<?php
$topCompletedArr = array();
$topInprocessArr = array();
$topNotStartedArr = array();
foreach($proTaskListDataArr as $task){
    $subTskCnt = $task['subTskCnt'];
    $tRes = filter_array($proWiseCompletedTaskListDataArr,$task['taskId'],'taskId');
    $taskResCount = count($tRes);

    if($subTskCnt>0){                                 
        if($taskResCount==0){
            // echo '<label class="tskSts notStarted"></label> Not Started';
            $topNotStartedArr[] = 1;
        }else{
            if($taskResCount==$subTskCnt){
                // echo '<label class="tskSts completed"></label> Done';
                $topCompletedArr[] = 1;
            }else{
                // echo '<label class="tskSts inProgress"></label> In Progress';
                $topInprocessArr[] = 1;
            }
        }
    }else{
        if($taskResCount>0){
            // echo '<label class="tskSts completed"></label> Done';
            $topCompletedArr[] = 1;
        }else{
            // echo '<label class="tskSts notStarted"></label> Not Started';
            $topNotStartedArr[] = 1;
        }
    }
}
$todayDate = strtotime(date('Y-m-d'));
?>
<div class="row mt-3">
    <div class="col-4" align="center">
        <div class="bgHead completed">
            <h5 class="mt-2 fw600">Completed Tasks </h5>
            <h1 class="fw600 mt-2 mb-0"><?php echo array_sum($topCompletedArr);?></h1>
        </div>
    </div>
    <div class="col-4" align="center">
        <div class="bgHead inProgress">
            <h5 class="mt-2 fw600">Tasks in Progress </h5>
            <h1 class="fw600 mt-2 mb-0"><?php echo array_sum($topInprocessArr);?></h1>
        </div>
    </div>
    <div class="col-4" align="center">
        <div class="bgHead notStarted">
            <h5 class="mt-2 fw600">Not Started Tasks </h5>
            <h1 class="fw600 mt-2 mb-0"><?php echo array_sum($topNotStartedArr);?></h1>
        </div>
    </div>
</div>
<div class="row my-4">
    <div class="col-xs-12 table-responsive">
                <table class="table table-striped12" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th>Main Task</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Complete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $ic = 1;
                    $i = 1;
                        foreach($proTaskListDataArr as $task){
                            $priClsname = '';
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                $priClsname = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['clsName'];
                            }
                            $subTskCnt = $task['subTskCnt'];
                            $tRes = filter_array($proWiseCompletedTaskListDataArr,$task['taskId'],'taskId');
                            $taskResCount = count($tRes);

                            $chkTaskSts = 1; // 1=completed
                            if($subTskCnt>0){                                 
                                if($taskResCount==0){
                                    $tskSts = '<label class="tskSts notStarted"></label> Not Started';
                                    $chkTaskSts = 0;
                                }else{
                                    if($taskResCount==$subTskCnt){
                                        $tskSts = '<label class="tskSts completed"></label> Done';
                                    }else{
                                        $tskSts = '<label class="tskSts inProgress"></label> In Progress';
                                        $chkTaskSts = 0;
                                    }
                                }
                            }else{
                                if($taskResCount>0){
                                    $tskSts = '<label class="tskSts completed"></label> Done';
                                }else{
                                    $tskSts = '<label class="tskSts notStarted"></label> Not Started';
                                    $chkTaskSts = 0;
                                }
                            }
                            
                            ?>
                        <tr id="taskRow<?php echo $task['taskId']; //data-bs-toggle="tooltip" data-bs-placement="top" title="Yes"?>">
                           
                            <td class="fw600"> 
                                 
                            <?php echo $ic.'. &nbsp;'; if($chkTaskSts==0 && $todayDate>=$task['dueDateStr']){ echo '<i class="fa fa-flag-o fw600 flagSts notStarted"></i>';}else{echo '<i class="fa fa-flag-o fw600 flagSts pendingBg"></i>';}?>
                            <a  class="cp" id="coltName<?php echo $task['taskId'];?>" onclick="return viewTaskDetails('<?php echo $task['taskId'];?>','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <?php echo $task['taskName'];?> <i id="inIcon<?php echo $task['taskId'];?>" class="fa fa-info-circle"></i> </a> </td>
                            <td nowrap class="<?php echo $priClsname;?>"> <span class="cp fw600" ><?php 
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                echo $this->config->item('task_priority_options_array_config')[$task['priorityId']]['name'];
                                $prIcon = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['icon'];
                                if(isset($prIcon) && $prIcon!=''){
                                    echo ' &nbsp;'.$prIcon;
                                }
                            }
                            ?> </span> </td> 
                            <td> <span><?php if(isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0){
                                echo date('m/d/Y',$task['dueDateStr']);
                                }?> </span> </td>
                            <td class="cp fw600"> <?php 
                            
                            echo $tskSts;
                            
                           ?> </td>
                            <td> <?php 
                                if($subTskCnt>0){
                                    $percentage  = round(($taskResCount*100)/$subTskCnt);
                                }else{
                                    if($taskResCount>0){
                                        $percentage  = 100;
                                    }else{
                                        $percentage  = 0;
                                    }
                                }
                                
$totalSquares = 5;
$squareValue = 100 / $totalSquares;
$fullCount = floor($percentage / $squareValue);
$remainder = $percentage % $squareValue;
$halfCount = ($remainder >= ($squareValue / 2)) ? 1 : 0;
$emptyCount = $totalSquares - $fullCount - $halfCount;
                            ?>
                        <div class="dotted-bar">
    <?php for ($i = 0; $i < $fullCount; $i++): ?>
        <div class="dot full"></div>
    <?php endfor; ?>
    <?php if ($halfCount): ?>
        <div class="dot half"></div>
    <?php endif; ?>
    <?php for ($i = 0; $i < $emptyCount; $i++): ?>
        <div class="dot"></div>
    <?php endfor; ?>
    <span class="perShow"> &nbsp;<?php if($percentage==100){echo 'Done';}else{echo $percentage.'%';} ?></span>
</div>
  
                        
                        </td>
                        </tr>
                        <?php $i++; $ic++; }?>
                       
                    </tbody>
                </table>							
            </div>
<script type="text/javascript">
function takeActionOnSubTask(subtId,colName,tId,pId){
	if(tId>0){
        $('#taskRedirectSts').val('1');
        if(parseInt(subtId)>0){
		    var checkstatus=$('#toggle-'+colName+subtId).prop('checked');
        }else{
            var checkstatus=$('#toggle-'+colName+tId).prop('checked');
        }
		if(checkstatus == true){
			var status=1;		
		}else{
			var status=0;		 
		}	
		$.ajax({url: "<?php echo base_url();?>projects/ajaxTakeActionOnSubTask?subtId="+subtId+"&colName="+colName+"&status="+status+"&tId="+tId+"&pId="+pId, 
			beforeSend: function(){ 
				if(parseInt(subtId)>0){
                    $('#spinner_'+colName+'_'+subtId).html('<i class="fa fa-spinner fa-spin"></i>');
                }else{
                    $('#spinner_'+colName+'_'+tId).html('<i class="fa fa-spinner fa-spin"></i>');
                }
			},
			success: function(result){
				var result_arr = result.split('||')
                if(result_arr[0]=='success'){
					if(parseInt(subtId)>0){
                        $('#spinner_'+colName+'_'+subtId).html('');
                    }else{
                        $('#spinner_'+colName+'_'+tId).html('');
                    }
                    if(parseInt(result_arr[1])==0){
                        allTaskCompletedShow();
                    }
				}else{
                    $('#ajaxRoleRes').html(result_arr[1]);
                }
			}
		});
	} 
}  
function viewTaskDetails(taskId, projectId, proencryptId){
    var taskName = $('#coltName'+taskId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'projects/viewTaskDetails?tId=';?>'+taskId+'&pId='+projectId+'&epId='+proencryptId,
        beforeSend: function(){
            $('#inIcon'+taskId).addClass('fa-spinner fa-spin');
            $('#inIcon'+taskId).removeClass('fa-info-circle');
            // $('#sendNotiModalTitle').html('Main Task');
        },
        success: function(result, status, xhr){//alert(result);
            $('#sendNotiFieldSec').html(result);
            $('#sendNotiModal').modal('show');
            // $('#coltName'+taskId).html(taskName);
            $('#inIcon'+taskId).removeClass('fa-spinner fa-spin');
            $('#inIcon'+taskId).addClass('fa-info-circle');
        }
    });	    
}
function closeTaskModal(){
    var chk = parseInt($('#taskRedirectSts').val());
    if(chk==0){
        $('#sendNotiModal').modal('hide');
    }else{
        window.location = '<?php echo base_url().'projects/tasks/'.$projectDetails['proencryptId'];?>';
    }    
} 

function allTaskCompletedShow(){
    $('#taskCompletedModel').modal('show');
}  
</script>
</div>   
</div>
</div>
<?php include(APPPATH.'views/Frontend/projects/notifications/manage-notifications.php');?>
</section>

<div class="modal fade" id="taskCompletedModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="taskCompletedModelLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content ">	
            <div class="modal-header">
                <h5 class="modal-title"> Great Job! </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container d-flex justify-content-center">
                    <div class="completion-box col-md-12" align="center">
                        <img style="width:40%;" src="<?php echo base_url();?>assets/backend/images/confetti-cone.png" alt="" />
                        <h1 style="color: #71c7ec;font-weight: 600;margin: 20px 0;">Task(s) Completed</h1>
                        <h4 style="font-size: 24px;font-weight: 600;line-height: 30px;">You've completed all subtasks in your main task.</h4>
                    </div>
                </div>	 
            </div>
        </div>
    </div>
</div>