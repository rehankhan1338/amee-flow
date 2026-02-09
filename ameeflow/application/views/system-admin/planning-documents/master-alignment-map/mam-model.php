<div class="modal fade" id="popMamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popMamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popMamModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popMamFrm" action="master_alignment_map/manageEntry" method="post">
			<input type="hidden" id="mauniversityId" name="mauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="mauniAdminId" name="mauniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="macreatedBy" name="macreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="resMam" class="ajaxFrmRes"></div>
			 <div class="row">		
                <div class="col-12" id="popMamInst">
                	<div class="alert alert-danger"><h5>WARNING!</h5> Are you sure you want to upload a new alignment map? This action will permanently delete the existing data and replace it with the new dataset!</div>
				</div>
				<div id="manageMamFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function getOversigntData(val){
	if(val!=''){
		window.location = '<?php echo base_url().$this->config->item('system_directory_name').'master-alignment-map?osd=';?>'+val;
	}
}
function manageMam(mamId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/ajaxFields?mamId=';?>'+mamId,
        beforeSend: function(){
            if(parseInt(mamId)==0){
				$('#popMamInst').hide();
                $('#addMamBtn').prop("disabled", true);
                $('#addMamBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#popMamModalLabel').html('Add your master alignment map');
            }else{
				$('#popMamInst').show();
                $('#popMamModalLabel').html('Upload your master alignment map');
				$('#emamBtn').prop("disabled", true);
                $('#emamBtn').html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageMamFieldSec').html(result);
            $('#popMamModal').modal('show');
            if(parseInt(mamId)==0){
                $('#addMamBtn').prop("disabled", false);
                $('#addMamBtn').html('<?php echo $addBtnTxt;?>');
            }else{
				$('#emamBtn').prop("disabled", false);
                $('#emamBtn').html('Update Map');
            }
        }
    });	    
}
$(document).ready(function () {
	$('#popMamFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#popMamFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popMamFrm').get(0));
			formData.append('curFile', $('#curFile')[0].files[0]);
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#popSaveBtn').prop("disabled", true);
					$('#popSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						//$('#resMam').html(result_arr[1]);
						//$('#addProModal').modal('hide');
						//displayToaster(result_arr[0], '<?php //echo $msgText;?>');	
						//$('#addProSaveBtn').prop("disabled", false);
						//$('#addProSaveBtn').html(btnText);
						window.location = site_base_url+'master-alignment-map';
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#resMam').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popSaveBtn').prop("disabled", false);
						$('#popSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>