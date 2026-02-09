<script>
function manageCCE(ceClassId,selceId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/ajaxCCEFields?ceClassId=';?>'+ceClassId+'&selceId='+selceId,
        beforeSend: function(){
            if(parseInt(ceClassId)==0){
                $('#addSocBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                $('#popCCEModelLabel').html('Add Course'); 
            }else{
                $('#popCCEModelLabel').html('Edit Course');
                $('#editCCEBtn'+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageCCEFieldSec').html(result);
            $('#popCCEModel').modal('show');
            if(parseInt(ceClassId)==0){
                $('#addSocBtn').html('Add New Course');
            }else{              
                $('#editCCEBtn'+ceClassId).html('<i class="icon-sm" data-feather="edit"></i>');
                feather.replace();
            }
        }
    });	    
}
$(document).ready(function () {
	$('#popCCEFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popCCESaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popCCEFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popCCEFrm').get(0));
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#popCCESaveBtn').prop("disabled", true);
					$('#popCCESaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = site_base_url+'sampling_plan/participants/<?php echo $spDetails['speId'];?>';
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#resCCE').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popCCESaveBtn').prop("disabled", false);
						$('#popCCESaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>
<div class="modal fade" id="popCCEModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCCEModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCCEModelLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCCEFrm" action="sampling_plan/manageClassEntry" method="post">
            <input type="hidden" id="addByuserAccessId" name="addByuserAccessId" value="<?php echo $sessionDetailsArr['userAccessId'];?>" />
			<div id="resCCE" class="ajaxFrmRes"></div>
			 <div class="row">	
				<div id="manageCCEFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popCCESaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>