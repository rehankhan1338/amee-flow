<div class="modal fade" id="copyProModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="copyProModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="copyProModalLabel">Copy Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="copyProFrm" action="projects/copyProEntry" method="post">
			<input type="hidden" id="copyuniversityId" name="copyuniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="copyuniAdminId" name="copyuniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="copycreatedBy" name="copycreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="copyProRes" class="ajaxFrmRes"></div>
			 <div class="row">	
                <div class="col-12 form-fields">
                    <label class="form-label">Project Copy From *</label>
                    <select id="copyProjectId" name="copyProjectId" class="form-control required">
                        <option value="">Select...</option>
                        <?php foreach($projectDataArr as $pro){  ?>
                        <option value="<?php echo $pro['projectId'];?>"><?php echo $pro['projectName'].' ('.$this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year'].')';?></option>
                        <?php }  ?>
                    </select>
                </div>				 
				<div class="col-12 form-fields">
                    <label class="form-label">New Project Name/Title *</label>
                    <input type="text" id="copyProName" name="copyProName" class="form-control required" placeholder="Add Title Here" value="" autocomplete="off" />
                </div>
                <div class="col-12 form-fields">
                    <label class="form-label">Term *</label>
                    <select id="copyTermId" name="copyTermId" class="form-control required">
                        <option value="">Select...</option>
                        <?php $termOptions = $this->config->item('terms_assessment_array_config');
                        foreach($termOptions as $key=>$value){ if($value['status']==0){?>
                        <option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-12 form-fields">
                    <label class="form-label">Year *</label>
                    <input type="text" id="copyYear" name="copyYear" class="form-control number required" placeholder="" value="" autocomplete="off" />
                </div>
				<div class="col-12 form-fields">
                    <label class="form-label">New Start Date *</label>
                    <input type="text" id="copyStartDate" name="copyStartDate" class="form-control required" placeholder="" value="" autocomplete="off" />
                </div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="copyProSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function copyProject(){
    $('#copyProModal').modal('show');
}
$(document).ready(function () {
	$('#copyStartDate').datepicker({
		startDate: new Date(),
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true		
	});
	$('#copyProFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#copyProSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#copyProFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#copyProSaveBtn').prop("disabled", true);
					$('#copyProSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#copyProRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#copyProSaveBtn').prop("disabled", false);
						$('#copyProSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>