<script>
$(function(){
    var tskId = '<?php echo $taskDetailsArr['taskId'];?>';	
	$('#txtDueDate'+tskId).datepicker({
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true
	}).on('changeDate', function(e) {
		var dueDate = $(this).datepicker('getFormattedDate');
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().$this->config->item('system_directory_name').'projects/ajaxUpdateTaskDueDate?tId=';?>'+tskId+'&dd='+dueDate,
            beforeSend: function(){
                $('#coltDate'+tskId).html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                var result_arr = result.split('||');
                if(result_arr[0]=='success'){
                    $('#coltDate'+tskId).html(result_arr[1]);
                }
            }
        });
    });		 
});
</script>
<input type="text" id="txtDueDate<?php echo $taskDetailsArr['taskId'];?>" name="txtDueDate<?php echo $taskDetailsArr['taskId'];?>" value="<?php if(isset($taskDetailsArr['dueDateStr']) && $taskDetailsArr['dueDateStr']!='' && $taskDetailsArr['dueDateStr']>0){echo date('m/d/Y',$taskDetailsArr['dueDateStr']);}?>" class="form-control" />