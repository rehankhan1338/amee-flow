<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
    });
</script> 
<?php $todayDate = strtotime(date('Y-m-d'));?>
<div class="">
    <input type="hidden" id="taskRedirectSts" value="0" />
    <div class="poptaskArea">
        <h5> <?php echo $taskDetailsArr['taskName'];?> </h5>
        <?php if(isset($taskDetailsArr['taskDesc']) && $taskDetailsArr['taskDesc']!=''){?>
           <?php echo $taskDetailsArr['taskDesc'];?>
        <?php } ?>
        <!-- <p> Priority: <label> <?php  //if(isset($taskDetailsArr['priorityId']) && $taskDetailsArr['priorityId']!='' && $taskDetailsArr['priorityId']>0){
                                //echo $this->config->item('task_priority_options_array_config')[$taskDetailsArr['priorityId']]['name']; } ?> </label> </p> -->
    </div>
    <?php if(count($subTaskDataArr)>0){ ?>
        <label class="tskLegSts completed"></label> Task Completed &nbsp; &nbsp; &nbsp; &nbsp;
        <label class="tskLegSts notStarted"></label> Not Completed
        <div class="popsubTaskArea px-3 mt-3">
            <h5>Sub Tasks</h5>
            <table class="table table-striped">
                <tr>
                    <th>Label</th>
                    <th>Short Description</th>
                    <th>Status</th>
                </tr>
                <?php foreach($subTaskDataArr as $subTask){ ?>
                <tr>
                    <td><?php echo $subTask['staskLbl'];?></td>
                    <td><?php echo $subTask['staskDesc'];?></td>  
                    <td>
                        <?php foreach($assignedProTaskDataArr as $au){ 
                            echo '<p class="my-0 py-0">'.$au['userName'];
                            $res = filter_array_two($completedTaskUserDataArr,$au['userId'],'userId',$subTask['subTaskId'],'subTaskId');
                            if(count($res)>0){
                                echo ' <label class="tskLegSts completed"></label>';
                            }else{
                                echo ' <label class="tskLegSts notStarted"></label>';
                            }
                            echo '</p>';
                            ?>

                            <?php } ?>
                    </td>                  
                </tr>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>