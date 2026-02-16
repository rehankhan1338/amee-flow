<section class="content">
<div class="box">
    
    <div class="box-header">
        <h4>Project: <?php echo $projectDetails['projectName'].' - '.$this->config->item('terms_assessment_array_config')[$projectDetails['termId']]['name'].' '.$projectDetails['year'];?></h4>
    </div>
<div class="box-body userTaskPage">
    
<div class="row">
    <div class="col-4" align="center">
        <h5 class="bgHead">Completed Tasks </h5>
    </div>
    <div class="col-4" align="center">
        <h5 class="bgHead">Tasks in Progress </h5>
    </div>
    <div class="col-4" align="center">
        <h5 class="bgHead">Not Started Tasks </h5>
    </div>
</div>

<div class="row my-5">
    <div class="col-xs-12 table-responsive">
                <table class="table table-striped12" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th>Main Task(s)</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Complete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                        foreach($proTaskListDataArr as $task){
                            $priClsname = '';
                            if(isset($task['priorityId']) && $task['priorityId']!='' && $task['priorityId']>0){
                                $priClsname = $this->config->item('task_priority_options_array_config')[$task['priorityId']]['clsName'];
                            }
                            $subTskCnt = $task['subTskCnt'];
                            $tRes = filter_array($proWiseCompletedTaskListDataArr,$task['taskId'],'taskId');
                            $taskResCount = count($tRes);
                            ?>
                        <tr id="taskRow<?php echo $task['taskId'];?>">
                           
                            <td style="font-weight:600;"> <a style="text-decoration: underline;color: #4343d8;" data-bs-toggle="tooltip" data-bs-placement="top" title="Yes" class="pro_name cp" id="coltName<?php echo $task['taskId'];?>" onclick="return viewTaskDetails('<?php echo $task['taskId'];?>','<?php echo $projectDetails['projectId'];?>','<?php echo $projectDetails['proencryptId'];?>');"> <?php echo $task['taskName'];?> </a> </td>
                            <td class="<?php echo $priClsname;?>"> <span class="cp fw600" ><?php 
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
                            
                            if($subTskCnt>0){                                 
                                if($taskResCount==0){
                                    echo '<label class="tskSts notStarted"></label> Not Started';
                                }else{
                                    if($taskResCount==$subTskCnt){
                                        echo '<label class="tskSts completed"></label> Done';
                                    }else{
                                        echo '<label class="tskSts inProgress"></label> In Progress';
                                    }
                                }
                            }else{
                                if($taskResCount>0){
                                    echo '<label class="tskSts completed"></label> Done';
                                }else{
                                    echo '<label class="tskSts notStarted"></label> Not Started';
                                }
                            }
                            
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
                        <?php $i++; }?>
                       
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
            // $('#sendNotiModalTitle').html(taskName);
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
</script>
<div class="modal fade" id="sendNotiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sendNotiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen"> <!-- modal-sm -->
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="sendNotiModalTitle">Main Task</h5>
        <button type="button" class="btn-close" onclick="return closeTaskModal();"></button>
      </div>
      
        <div class="modal-body">
            <div id="resNotiModel"></div>
            <div id="sendNotiFieldSec">
			
            </div>		 		 
        </div> 
        
           
    </div>
  </div>
</div>

</div>   
</div>
</div>
</section>
