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
    </div>
    <!-- Modern Toolbar -->
    <div class="af-roles-toolbar">
        <div class="af-roles-toolbar-left">
            <div class="af-roles-search-wrap">
                <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                <input type="text" class="af-roles-search-input" id="taskSearchInput" placeholder="Search tasks..." autocomplete="off" />
                <button class="af-roles-search-clear" id="clearTaskSearch" type="button"><i class="fa fa-times"></i></button>
            </div>
            <!-- Priority Filter -->
            <div class="af-select-filter-wrap" id="afPriorityFilterWrap">
                <span class="af-select-filter-btn" id="afPriorityFilterBtn" role="button">
                    <i class="fa fa-flag"></i>
                    <span class="af-select-filter-label">All Priorities</span>
                    <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    <button class="af-select-filter-clear" id="afPriorityClear" type="button"><i class="fa fa-times"></i></button>
                </span>
                <div class="af-select-filter-dropdown" id="afPriorityDropdown">
                    <a href="#" class="af-select-filter-option selected" data-value="">All Priorities</a>
                    <?php 
                        $task_priority = $this->config->item('task_priority_options_array_config');
                        foreach($task_priority as $key=>$value){ 
                            if($value['status']==0){
                    ?>
                    <a href="#" class="af-select-filter-option" data-value="<?php echo $key;?>"><?php echo $value['name'];?></a>
                    <?php 
                            }
                        } 
                    ?>
                </div>
            </div>
            <!-- Due Date Filter -->
            <div class="af-date-filter-wrap" id="afDueDateFilterWrap">
                <span class="af-select-filter-btn" id="afDueDateFilterBtn" role="button">
                    <i class="fa fa-calendar"></i>
                    <span class="af-select-filter-label">Due Date</span>
                    <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    <button class="af-select-filter-clear" id="afDueDateClear" type="button"><i class="fa fa-times"></i></button>
                </span>
                <div class="af-select-filter-dropdown" id="afDueDateDropdown" style="padding:10px;">
                    <div id="afDueDatePicker"></div>
                </div>
            </div>
        </div>
        <div class="af-roles-toolbar-right" style="flex-wrap:wrap; gap:6px;">
            <a href="<?php echo base_url().$this->config->item('system_directory_name').'analytics/download/'.$projectDetails['proencryptId'];?>" class="btn btn-warning btn-sm" style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-download"></i> Download </a>
            <a href="<?php echo base_url().$this->config->item('system_directory_name').'analytics';?>" class="btn btn-primary btn-sm" style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-long-arrow-left"></i> Back </a>
        </div>
    </div>
    <!-- Hidden fields for filter logic -->
    <input type="hidden" id="priorityFilter" value="" />
    <input type="hidden" id="dueDateFilter" value="" />
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
                            <th>Main Task(s)</th>
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
                           
                            <td class="fw600"> <a style="text-decoration:underline;color:#4343d8;" class="cp" id="coltName<?php echo $task['taskId'];?>" onclick="return viewTaskDetails('<?php echo $task['taskId'];?>','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <?php echo $task['taskName'];?> </a> </td>
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
    var selectedPriority = '';
    var selectedDueDate = '';

    // Helper function to normalize timestamp to start of day
    function getStartOfDay(timestamp){
        var date = new Date(timestamp * 1000);
        date.setHours(0, 0, 0, 0);
        return Math.floor(date.getTime() / 1000);
    }

    // Initialize datepicker in dropdown
    $('#afDueDatePicker').datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true
    }).on('changeDate', function(e){
        var d = e.format();
        if(d){
            selectedDueDate = d;
            $('#dueDateFilter').val(d);
            $('#afDueDateFilterBtn .af-select-filter-label').text(d);
            $('#afDueDateFilterBtn').addClass('active');
            $('#afDueDateClear').css('display','inline-block');
            filterTasksTable();
        }
    });

    // Filter function
    function filterTasksTable(){
        var searchText = $('#taskSearchInput').val().toLowerCase();

        $('#table_recordtbl1 tbody tr').each(function(){
            var $row = $(this);
            var rowText = $row.text().toLowerCase();
            var rowPriorityId = String($row.data('priority-id') || '0');
            var rowDueDate = parseInt($row.data('due-date') || 0);
            
            var matchesSearch = (searchText === '' || rowText.indexOf(searchText) > -1);
            var matchesPriority = (selectedPriority === '' || rowPriorityId === selectedPriority);
            
            var matchesDueDate = true;
            if(selectedDueDate !== '' && rowDueDate > 0){
                var dateParts = selectedDueDate.split('/');
                if(dateParts.length === 3){
                    var selDate = new Date(parseInt(dateParts[2]), parseInt(dateParts[0]) - 1, parseInt(dateParts[1]));
                    selDate.setHours(0, 0, 0, 0);
                    var selDateStart = Math.floor(selDate.getTime() / 1000);
                    var selDateEnd = selDateStart + 86399;
                    var taskDueDateStart = getStartOfDay(rowDueDate);
                    matchesDueDate = (taskDueDateStart >= selDateStart && taskDueDateStart <= selDateEnd);
                } else {
                    matchesDueDate = false;
                }
            } else if(selectedDueDate !== '' && rowDueDate === 0){
                matchesDueDate = false;
            }
            
            $row.toggle(matchesSearch && matchesPriority && matchesDueDate);
        });
    }

    /* Search bar */
    $('#taskSearchInput').on('input', function(){
        var v = $(this).val();
        if(v.length > 0){ $('#clearTaskSearch').css('display','flex'); } else { $('#clearTaskSearch').hide(); }
        filterTasksTable();
    });
    $('#clearTaskSearch').on('click', function(){
        $('#taskSearchInput').val('');
        $(this).hide();
        filterTasksTable();
    });

    /* Priority dropdown */
    $('#afPriorityFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afDueDateDropdown').removeClass('show');
        $('#afPriorityDropdown').toggleClass('show');
    });
    $('#afPriorityDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        selectedPriority = val ? val.toString() : '';
        $('#priorityFilter').val(selectedPriority);
        $('#afPriorityDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        if(selectedPriority !== ''){
            $('#afPriorityFilterBtn .af-select-filter-label').text($(this).text());
            $('#afPriorityFilterBtn').addClass('active');
            $('#afPriorityClear').css('display','inline-block');
        } else {
            $('#afPriorityFilterBtn .af-select-filter-label').text('All Priorities');
            $('#afPriorityFilterBtn').removeClass('active');
            $('#afPriorityClear').hide();
        }
        $('#afPriorityDropdown').removeClass('show');
        filterTasksTable();
    });
    $('#afPriorityClear').on('click', function(e){
        e.stopPropagation();
        selectedPriority = '';
        $('#priorityFilter').val('');
        $('#afPriorityFilterBtn .af-select-filter-label').text('All Priorities');
        $('#afPriorityFilterBtn').removeClass('active');
        $(this).hide();
        $('#afPriorityDropdown .af-select-filter-option').removeClass('selected');
        filterTasksTable();
    });

    /* Due Date dropdown */
    $('#afDueDateFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afPriorityDropdown').removeClass('show');
        $('#afDueDateDropdown').toggleClass('show');
    });
    $('#afDueDateClear').on('click', function(e){
        e.stopPropagation();
        selectedDueDate = '';
        $('#dueDateFilter').val('');
        $('#afDueDatePicker').datepicker('update', '');
        $('#afDueDateFilterBtn .af-select-filter-label').text('Due Date');
        $('#afDueDateFilterBtn').removeClass('active');
        $(this).hide();
        filterTasksTable();
    });

    /* Close on outside click */
    $(document).on('click', function(e){
        // If the click target was removed from DOM (e.g. datepicker nav rebuild), skip closing
        if(!document.body.contains(e.target)) return;
        if(!$(e.target).closest('#afPriorityFilterWrap').length){ $('#afPriorityDropdown').removeClass('show'); }
        if(!$(e.target).closest('#afDueDateFilterWrap').length && !$(e.target).closest('.datepicker').length){ $('#afDueDateDropdown').removeClass('show'); }
    });
});

function viewTaskDetails(taskId, projectId, proencryptId){
    var origText = $('#coltName'+taskId).text();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'analytics/viewTaskDetails?tId=';?>'+taskId+'&pId='+projectId+'&epId='+proencryptId,
        beforeSend: function(){
            $('#coltName'+taskId).html('<i class="fa fa-spinner fa-spin"></i> '+origText);
        },
        success: function(result, status, xhr){
            $('#manageTaskFieldSec').html(result);
            $('#manageTaskModal').modal('show');
            $('#coltName'+taskId).text(origText);
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
