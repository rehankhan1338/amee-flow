<div class="modal fade" id="popAIModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popAIModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">     
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popAIModalLabel">Generate Report</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popAIFrm" action="loads_report/saveAIreport" method="post">
			<div id="popAIRes" class="ajaxFrmRes"></div>             
            <input type="hidden" id="ai_rId" name="ai_rId" value="<?php echo $reportDetails['rId'];?>" />
            <input type="hidden" id="ai_erId" name="ai_erId" value="<?php echo $reportDetails['erId'];?>" />
            <div class="row">
                <div class="col-12">
                    <label class="form-label">Report * <span id="aiSpLoader" class="aiLnk cp" onclick="return genAIReport('<?php echo $reportDetails['erId'];?>','<?php echo $reportDetails['rId'];?>');"><?php echo $this->config->item('aiButtonTxt');?></span></label>
                    <textarea id="txt_aisummary" name="txt_aisummary"><?php if(isset($reportDetails['aiReport']) && $reportDetails['aiReport']!=''){echo $reportDetails['aiReport'];}?></textarea>
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
    $.ajax({
		type: "POST",
		url: '<?php echo base_url().'loads_report/genAIReport';?>',
		data: { 
			'erId': erId, 
			'rId': rId
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
}
function genAIReport(rId){
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