<section class="content">
<div class="box">
 
<?php

$totalTaskIncSubTaskArr = array();
if(count($proTaskListDataArr)>0){
    foreach($proTaskListDataArr as $task){
        $res = filter_array($assignedProjectManagersDataArr,$task['taskId'],'taskId');
        $mulSubTsk = 1;
        if($task['subTskCnt']>0){
            $mulSubTsk = $task['subTskCnt'];
        }
        $totalTaskIncSubTaskArr[] = count($res)*$mulSubTsk;
        // echo '<br>';
    }
}

$expectedTasks = array_sum($totalTaskIncSubTaskArr);
$tasksSubmitted = count($taskSubmittedDataArr);
 


$proName = $projectDetails['projectName'].' - '.$this->config->item('terms_assessment_array_config')[$projectDetails['termId']]['name'].' '.$projectDetails['year'];
?>
    <div class="box-header">
        <h5>Project: <?php echo $proName;?></h5>
        <div class="box-tools pull-right">
            <div class="input-group input-group-sm" style="display:inline-flex; width:250px; margin-right:10px; vertical-align:middle;">
                <input type="text" id="taskSearchInput" class="form-control" placeholder="Search tasks..." style="height:34px;">
                <span class="input-group-text" style="height:34px; cursor:pointer;" id="clearTaskSearch"><i class="fa fa-times"></i></span>
            </div>
            <select id="priorityFilter" class="form-control form-control-sm" style="display:inline-block; width:180px; height:34px; margin-right:10px; vertical-align:middle;">
                <option value="">All Priorities</option>
                <?php 
                    $task_priority = $this->config->item('task_priority_options_array_config');
                    foreach($task_priority as $key=>$value){ 
                        if($value['status']==0){
                ?>
                <option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
                <?php 
                        }
                    } 
                ?>
            </select>
            <select id="dueDateFilter" class="form-control form-control-sm" style="display:inline-block; width:180px; height:34px; margin-right:10px; vertical-align:middle;">
                <option value="">All Dates</option>
                <option value="overdue">Overdue</option>
                <option value="today">Today</option>
                <option value="this_week">This Week</option>
                <option value="this_month">This Month</option>
                <option value="future">Future</option>
            </select>
            <a href="<?php echo base_url().$this->config->item('system_directory_name').'analytics/download/'.$projectDetails['proencryptId'];?>" style="padding: 3px 15px; font-size:15px; margin-right:5px;" class="btn btn-warning"> <i class="fa fa-download"></i> Download </a>                
            <a href="<?php echo base_url().$this->config->item('system_directory_name').'analytics';?>" style="padding: 3px 15px; font-size:15px;" class="btn btn-primary"> <i class="fa fa-long-arrow-left"></i> Back </a>                
        </div>
    </div>
<div class="box-body userTaskPage">
 
 <div class="row mt-0 mb-4">
    <div class="col-4" align="center">
        <div class="bgHead completed">
            <h4 class="mt-2 fw600">Expected Tasks </h4>
            <h1 class="fw600 mt-2 mb-0"><?php echo $expectedTasks;?></h1>
        </div>
    </div>
    <div class="col-4" align="center">
        <div class="bgHead inProgress">
            <h4 class="mt-2 fw600">Tasks Submitted </h4>
            <h1 class="fw600 mt-2 mb-0"><?php echo $tasksSubmitted;?></h1>
        </div>
    </div>
    <div class="col-4" align="center">
        <div class="bgHead notStarted">
            <h4 class="mt-2 fw600">Overdue Tasks </h4>
            <h1 class="fw600 mt-2 mb-0"> 0 <?php //echo array_sum($topNotStartedArr);?></h1>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-xs-12 table-responsive">
                <table class="table table-striped12" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th>Main Task</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th class="text-center">Completed Tasks</th>
                            <th class="text-center">Tasks in Progress</th>
                            <th class="text-center">Not Started Tasks</th>
                            <th>Avg. Completion</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                        foreach($proTaskListDataArr as $task){
                            $priClsname = '';
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                $priClsname = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['clsName'];
                            }
                            // $subTskCnt = $task['subTskCnt'];                          
                                
                            $tRes = filter_array($proWiseSubTaskDataArr,$task['taskId'],'taskId');
                            $subTskCnt = count($tRes);

                            $assignedProjectManagersDataArr = assignedProTaskDataArr($task['projectId'],$task['taskId']);
                            $totalProjectManagersCnt = count($assignedProjectManagersDataArr);
                            
                            $avgPer = 0;
                            if($subTskCnt>0){
                                $avgSubTaskActioArr = array();
                                $completedUserArr = array();
                                $inProcessUserArr = array();
                                $notStartedUserArr = array();
                                foreach($tRes as $subTask){ 
                                    if($totalProjectManagersCnt>0){                                   
                                        $avgSubTaskActioArr[] = avgUserTakeSubTaskActionCntCh($subTask['subTaskId'])/$totalProjectManagersCnt;
                                    }else{
                                        $avgSubTaskActioArr[] = 0;
                                    }
                                }

                              
                                if(count($avgSubTaskActioArr)>0){
                                    $avgPer = round((array_sum($avgSubTaskActioArr)/count($avgSubTaskActioArr))*100,2);
                                }
                                foreach($assignedProjectManagersDataArr as $roleDetails){                                     
                                    $chkStsUserRes = chkStsofUserTakeActionCh($roleDetails['userId'],$task['taskId']);
                                    if($chkStsUserRes==$subTskCnt){
                                        $completedUserArr[] = 1;
                                    }else if($chkStsUserRes>0){
                                        $inProcessUserArr[] = 1;
                                    }else{
                                        $notStartedUserArr[] = 1;  
                                    }
                                }                                
                                $completedUserCnt = count($completedUserArr);
                                $inProcessUserCnt = count($inProcessUserArr);
                                $notStartedUserCnt = count($notStartedUserArr);
                            }else{
                                $completedUserCnt = avgUserTakeTaskActionCntCh($task['taskId']);
                                $avgPer = 0;
                                if($totalProjectManagersCnt>0){
                                    $avgPer = round(($completedUserCnt/$totalProjectManagersCnt)*100,2);
                                }
                                $inProcessUserCnt = 0;
                                $notStartedUserCnt = $totalProjectManagersCnt-$completedUserCnt;
                            } 
                              //data-bs-toggle="tooltip" data-bs-placement="top" title="Yes"
                              //echo '<br>';
                            ?>
                        <tr id="taskRow<?php echo $task['taskId'];?>" data-priority-id="<?php echo isset($task['priorityId']) && $task['priorityId']!='' ? $task['priorityId'] : '0';?>" data-due-date="<?php echo isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0 ? $task['dueDateStr'] : '0';?>">
                           
                            <td class="fw600"> <a class="cp" id="coltName<?php echo $task['taskId'];?>" onclick="return viewTaskDetails('<?php echo $task['taskId'];?>','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <?php echo $task['taskName'];?>  <i id="inIcon<?php echo $task['taskId'];?>" class="fa fa-info-circle"></i> </a> </td>
                            <td nowrap class="<?php echo $priClsname;?>"> <span class="fw600" ><?php 
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                echo $this->config->item('task_priority_options_array_config')[$task['priorityId']]['name'];
                                $prIcon = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['icon'];
                                if(isset($prIcon) && $prIcon!=''){
                                    echo ' &nbsp;'.$prIcon;
                                }
                            }
                            ?> </span> </td> 
                            <td> <?php if(isset($task['dueDateStr']) && $task['dueDateStr']!='' && $task['dueDateStr']>0){
                                echo date('m/d/Y',$task['dueDateStr']);
                                }?>  </td>
                            
                            <td class="fw600 text-center"> <?php echo $completedUserCnt;?> </td>
                            <td class="fw600 text-center "> <?php echo $inProcessUserCnt;?> </td>
                            <td class="fw600 text-center"> <?php echo $notStartedUserCnt;?> </td>
                            <td> <?php 
                                 
                                
$totalSquares = 5;
$squareValue = 100 / $totalSquares;
$fullCount = floor($avgPer / $squareValue);
$remainder = $avgPer % $squareValue;
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
    <span class="perShow"> &nbsp;<?php if($avgPer==100){echo 'Done';}else{echo $avgPer.'%';} ?></span>
</div>
  
                        
                        </td>
                        </tr>
                        <?php $i++; }?>
                       
                    </tbody>
                </table>							
            </div>
<script type="text/javascript">
$(function(){
    // Helper function to normalize timestamp to start of day
    function getStartOfDay(timestamp){
        var date = new Date(timestamp * 1000);
        date.setHours(0, 0, 0, 0);
        return Math.floor(date.getTime() / 1000);
    }
    
    // Helper function to normalize timestamp to end of day
    function getEndOfDay(timestamp){
        var date = new Date(timestamp * 1000);
        date.setHours(23, 59, 59, 999);
        return Math.floor(date.getTime() / 1000);
    }

    // Filter function
    function filterTasksTable(){
        var searchText = $('#taskSearchInput').val().toLowerCase();
        var selectedPriority = $('#priorityFilter').val();
        var selectedDueDate = $('#dueDateFilter').val();
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        var todayStart = Math.floor(today.getTime() / 1000);
        var todayEnd = todayStart + 86399; // End of today (23:59:59)
        
        // Calculate date ranges
        var weekStart = new Date(today);
        weekStart.setDate(today.getDate() - today.getDay()); // Start of week (Sunday)
        weekStart.setHours(0, 0, 0, 0);
        var weekStartTimestamp = Math.floor(weekStart.getTime() / 1000);
        
        var weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);
        weekEnd.setHours(23, 59, 59, 999);
        var weekEndTimestamp = Math.floor(weekEnd.getTime() / 1000);
        
        var monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
        monthStart.setHours(0, 0, 0, 0);
        var monthStartTimestamp = Math.floor(monthStart.getTime() / 1000);
        
        var monthEnd = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        monthEnd.setHours(23, 59, 59, 999);
        var monthEndTimestamp = Math.floor(monthEnd.getTime() / 1000);

        $('#table_recordtbl1 tbody tr').each(function(){
            var rowText = $(this).text().toLowerCase();
            var rowPriorityId = String($(this).data('priority-id') || '0');
            var rowDueDate = parseInt($(this).data('due-date') || 0);
            
            // Search filter
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            
            // Priority filter
            var matchesPriority = true;
            if(selectedPriority !== ''){
                matchesPriority = (rowPriorityId === selectedPriority);
            }
            
            // Due Date filter
            var matchesDueDate = true;
            if(selectedDueDate !== '' && rowDueDate > 0){
                var taskDueDateStart = getStartOfDay(rowDueDate);
                var taskDueDateEnd = getEndOfDay(rowDueDate);
                
                switch(selectedDueDate){
                    case 'overdue':
                        matchesDueDate = (taskDueDateEnd < todayStart);
                        break;
                    case 'today':
                        matchesDueDate = (taskDueDateStart >= todayStart && taskDueDateStart <= todayEnd);
                        break;
                    case 'this_week':
                        matchesDueDate = (taskDueDateStart >= weekStartTimestamp && taskDueDateStart <= weekEndTimestamp);
                        break;
                    case 'this_month':
                        matchesDueDate = (taskDueDateStart >= monthStartTimestamp && taskDueDateStart <= monthEndTimestamp);
                        break;
                    case 'future':
                        matchesDueDate = (taskDueDateStart > todayEnd);
                        break;
                }
            } else if(selectedDueDate !== '' && rowDueDate === 0){
                // If filter is selected but task has no due date, hide it
                matchesDueDate = false;
            }
            
            $(this).toggle(matchesSearch && matchesPriority && matchesDueDate);
        });
    }

    // Search input event
    $('#taskSearchInput').on('keyup', function(){
        filterTasksTable();
    });

    // Clear search button
    $('#clearTaskSearch').on('click', function(){
        $('#taskSearchInput').val('');
        filterTasksTable();
    });

    // Priority filter change event
    $('#priorityFilter').on('change', function(){
        filterTasksTable();
    });

    // Due Date filter change event
    $('#dueDateFilter').on('change', function(){
        filterTasksTable();
    });
});

function viewTaskDetails(taskId, projectId, proencryptId){
    var taskName = $('#coltName'+taskId).html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'analytics/viewTaskDetails?tId=';?>'+taskId+'&pId='+projectId+'&epId='+proencryptId,
        beforeSend: function(){
            $('#inIcon'+taskId).addClass('fa-spinner fa-spin');
            $('#inIcon'+taskId).removeClass('fa-info-circle');
            // $('#manageTaskModalTitle').html(taskName);
        },
        success: function(result, status, xhr){//alert(result);
            $('#manageTaskFieldSec').html(result);
            $('#manageTaskModal').modal('show');
            // $('#coltName'+taskId).html(taskName);
            $('#inIcon'+taskId).removeClass('fa-spinner fa-spin');
            $('#inIcon'+taskId).addClass('fa-info-circle');
        }
    });	    
}
function closeTaskModal(){
    var chk = parseInt($('#taskRedirectSts').val());
    if(chk==0){
        $('#manageTaskModal').modal('hide');
    }else{
        window.location = '<?php echo base_url().'projects/tasks/'.$projectDetails['proencryptId'];?>';
    }    
} 
</script>
<div class="modal fade" id="manageTaskModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="manageTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl"> <!-- modal-sm -->
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="manageTaskModalTitle"><?php echo $proName;?></h5>
        <button type="button" class="btn-close" onclick="return closeTaskModal();"></button>
      </div>      
        <div class="modal-body">
            <div id="resTaskModel"></div>
            <div id="manageTaskFieldSec">
			
            </div>		 		 
        </div>           
    </div>
  </div>
</div>
</div>  
    <!-- <div class="row ">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped12" id="table_recordtbl1">
                <thead>
                    <tr>
                        <th>Projects</th>
                        <th>Manager</th>
                        <th>Open Tasks</th>
                        <th>Close Tasks</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div> -->
</div>
</div>
</section>