<div class="modal fade" id="popMamModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popMamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popMamModalLabel">Upload your faculty</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCeFrm" action="course_enrollment/manageTemporaryFaculty" method="post">
			<input type="hidden" id="mauniversityId" name="mauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="mauniAdminId" name="mauniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="macreatedBy" name="macreatedBy" value="<?php echo $sessionDetailsArr['createdBy'];?>" />
			<input type="hidden" id="txtceId" name="txtceId" value="0" />
			<div id="resMam" class="ajaxFrmRes"></div>
			 <div class="row">		
                <!-- <div class="col-12" id="popCeInst">
                	<div class="alert alert-danger"><h5>WARNING!</h5> Are you sure you want to upload a new alignment map? This action will permanently delete the existing data and replace it with the new dataset!</div>
				</div> -->
				<div class="col-12 form-fields">
					<label class="form-label">Term / Year *</label>
					<select id="maceId" name="maceId" class="form-control required">
						<option value="">Select...</option>
						<?php foreach($courseEnrollmentDataArr as $course){?>
                        <option value="<?php echo $course['ceId'];?>"> <?php echo $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year']; ?> </option>
                    <?php } ?>
					</select>
				</div>
				<div class="col-12 form-fields mt-3">
					<!-- <label class="form-label">Add your file *</label> <br /> -->
					<input type="file" id="curFile" name="curFile" class="required" />
				</div>			 
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
function uploadNewTermFaculty(){
    $('#popMamModal').modal('show');	    
}
$(document).ready(function () {
	$('#popCeFrm').validate({
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
			var form = $('#popCeFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popCeFrm').get(0));
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
						window.location = site_base_url+'course_enrollment/recognitionFlow?ced='+result_arr[1];
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