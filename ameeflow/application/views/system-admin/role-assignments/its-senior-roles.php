<div class="modal fade" id="srdModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="srdModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="srdModalLabel">Assign Roles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="my-2">This screenshot will show the project manager who area experts are adding to their task.</p>
		    <div id="srDetailSec"></div>			 
      </div>      
    </div>
  </div>
</div>
<script>
function viewSeniorDetails(userId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'roles/ajaxSeniorRoles?userId=';?>'+userId,
        beforeSend: function(){
            $('#srLnk'+userId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#srDetailSec').html(result);
            $('#srdModal').modal('show');
            $('#srLnk'+userId).html('View');
        }
    });	    
}
</script>