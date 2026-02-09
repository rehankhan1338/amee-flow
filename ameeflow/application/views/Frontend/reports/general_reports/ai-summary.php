<div class="modal fade" id="popAIModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popAIModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">     
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popAIModalLabel">Edit Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popAIFrm" action="general_reports/updateAIreport" method="post">
			<div id="popAIRes" class="ajaxFrmRes"></div>             
            <input type="hidden" id="ai_rId" name="ai_rId" value="<?php echo $reportDetails['rId'];?>" />
            <input type="hidden" id="ai_erId" name="ai_erId" value="<?php echo $reportDetails['erId'];?>" />
            <div class="row">
                <div class="col-12 form-fields">
					<label class="form-label">Add a Title *</label>
					<input type="text" id="txt_topicName" name="txt_topicName" class="form-control required" placeholder="" value="<?php if(isset($reportDetails['topicName']) && $reportDetails['topicName']!=''){echo $reportDetails['topicName'];}?>" autocomplete="off" />
				</div>
				<div class="col-12 form-fields">
					<label class="form-label">Add a Content *</label>
					<textarea rows="3" id="txt_topicContent" name="txt_topicContent" class="form-control required" placeholder="Add Content Details Here"><?php if(isset($reportDetails['topicContent']) && $reportDetails['topicContent']!=''){echo $reportDetails['topicContent'];}?></textarea>
				</div>
				<div class="col-12">
                    <label class="form-label">Report * <span id="aiSpLoader" class="aiLnk cp" onclick="return genAIReport('<?php echo $reportDetails['erId'];?>','<?php echo $reportDetails['rId'];?>');"><?php echo $this->config->item('aiButtonTxt');?></span></label>
                    <textarea id="txt_aisummary" name="txt_aisummary"><?php if(isset($reportDetails['reportSummary']) && $reportDetails['reportSummary']!=''){echo $reportDetails['reportSummary'];}?></textarea>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" id="popAISaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save & Update</button>
                </div>
            </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>

<script>
function genAIReport(erId,rId){
    var aiSpLoaderTxt = $('#aiSpLoader').html();
	var topicName = $('#txt_topicName').val();
	var topicContent = $('#txt_topicContent').val();
	if(topicName!=''){
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().'general_reports/genAIGeneralReport';?>',
			data: { 
				'erId': erId, 
				'rId': rId,
				'topicName': topicName,
				'topicContent': topicContent
			},
			beforeSend: function(){
				$('#popAIRes').html('');
				$('#aiSpLoader').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				CKEDITOR.instances['txt_aisummary'].setData(result);
				$('#aiSpLoader').html(aiSpLoaderTxt);
			}
		});
	}else{
		$('#popAIRes').html('<div class="alert alert-danger">Oops, please add your topic first.</div>');
	}
}
function genAIGeneralReport(rId){
    $('#popAIModal').modal('show');	    
}
$(document).ready(function () {
    if($('#txt_aisummary').length > 0){
        CKEDITOR.replace( 'txt_aisummary',{height: '300px',}); 
    }
	$('#popAIFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popAISaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popAIFrm');
			var url = site_base_url+form.attr('action');
            for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#popAISaveBtn').prop("disabled", true);
					$('#popAISaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){ 
                        window.location = result_arr[1];
					}else{
						$('#popAIRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popAISaveBtn').prop("disabled", false);
						$('#popAISaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>