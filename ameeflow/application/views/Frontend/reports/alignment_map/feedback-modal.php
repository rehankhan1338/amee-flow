<div class="modal fade" id="feedbackModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="feedbackModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="feedbackModelLabel">Shared Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<div id="feedbackDataSec">
                     
                   
        </div>	 
      </div>      
    </div>
  </div>
</div>
<script>
function viewFeedback(mamId,userId){
    var btnText = $('#feedbackBtn').html();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/ajaxViewFeedback?mamId=';?>'+mamId+"&userId="+userId,
        beforeSend: function(){
            $('#feedbackBtn').prop("disabled", true);
            $('#feedbackBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');          
        },
        success: function(result, status, xhr){
            $('#feedbackDataSec').html(result);
            $('#feedbackModel').modal('show');	
            $('#feedbackBtn').prop("disabled", false);
            $('#feedbackBtn').html(btnText);                
        }
    });
}
</script>