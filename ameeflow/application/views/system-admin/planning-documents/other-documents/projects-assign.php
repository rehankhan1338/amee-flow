<div class="accordion accordion-flush" id="accordionFlushExample">
  <?php 
  
if(isset($docDetails['taskIds']) && $docDetails['taskIds']!=''){
  $taskIdsArr = explode(',',$docDetails['taskIds']);
}else{
  $taskIdsArr = array();
}

  foreach($projectDataArr as $pro){  
      
    ?>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-<?php echo $pro['projectId'];?>">
      <button style="font-weight:500; padding:10px; font-size:15px;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $pro['projectId'];?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $pro['projectId'];?>">
        <?php echo $pro['projectName'];?>
      </button>
    </h2>
    <div id="flush-collapse<?php echo $pro['projectId'];?>" class="accordion-collapse collapse" aria-labelledby="flush-<?php echo $pro['projectId'];?>" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
         <button type="button" id="toggleCheckboxBtn<?php echo $pro['projectId'];?>" style="padding:5px 30px;" class="btn btn-warning btn-sm mb-3">Check All</button>
<script>
let allChecked<?php echo $pro['projectId'];?> = false;
	$('#toggleCheckboxBtn<?php echo $pro['projectId'];?>').on('click', function () {
		allChecked<?php echo $pro['projectId'];?> = !allChecked<?php echo $pro['projectId'];?>;
		$('.odcaseTaskIds<?php echo $pro['projectId'];?>').prop('checked', allChecked<?php echo $pro['projectId'];?>);
		$(this).text(allChecked<?php echo $pro['projectId'];?> ? 'Uncheck All' : 'Check All');
	}); 
</script>
        <?php $proTaskListDataArrCh = proTaskListDataArrCh($pro['projectId']);
          foreach($proTaskListDataArrCh as $tsk){?>
           
            <div class="col-md-12 my-2">
            <label for="odTaskId<?php echo $tsk['taskId'];?>"> <input <?php if(in_array($tsk['taskId'],$taskIdsArr)){ ?>checked<?php } ?> type="checkbox" class="odcaseTaskIds<?php echo $pro['projectId'];?>" id="odTaskId<?php echo $tsk['taskId'];?>" name="odTaskIds[]" value="<?php echo $pro['projectId'].'||'.$tsk['taskId'];?>" /> &nbsp;<?php echo $tsk['taskName'];?></label>
            </div>
          <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>
</div>