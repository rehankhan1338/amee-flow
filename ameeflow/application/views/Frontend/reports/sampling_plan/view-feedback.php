<div class="modal fade" id="viewFeedbackModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewFeedbackModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">     
    <div class="modal-content">	
      <div class="modal-header" id="viewFeedbackHeadModel">
        <h5 class="modal-title fs18" id="viewFeedbackModelLabel">Feedback</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding:6px 15px;">
        <div id="viewFeedbackRes" class="ajaxFrmRes"></div> 
      </div>      
    </div>
  </div>
</div>
<script>
function viewFeedback(chkId,shareReportFor){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/viewFeedback?chkId=';?>'+chkId+'&shareReportFor='+shareReportFor,
        beforeSend: function(){
            $('#vfbkLnk'+chkId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#viewFeedbackRes').html(result);
            $('#viewFeedbackModel').modal('show'); 
             $('#vfbkLnk'+chkId).html('View');    
        }
    });
}
</script>