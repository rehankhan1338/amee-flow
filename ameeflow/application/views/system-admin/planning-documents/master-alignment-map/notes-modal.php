<div class="modal fade" id="noteModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="noteModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="noteModelLabel">Shared Notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<div id="noteDataSec">
                     
                   
        </div>	 
      </div>      
    </div>
  </div>
</div>
<script>
function viewNote(mamCourseId){
    var btnText = $('#noteBtn').html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/ajaxViewNote?mamCourseId=';?>'+mamCourseId,
        beforeSend: function(){
            $('#noteBtn'+mamCourseId).html('<i class="fa fa-spinner fa-spin"></i>');          
        },
        success: function(result, status, xhr){
            $('#noteDataSec').html(result);
            $('#noteModel').modal('show');	
            $('#noteBtn'+mamCourseId).html('<i class="icon-sm" data-feather="eye"></i>');
            feather.replace();                
        }
    });
}
</script>