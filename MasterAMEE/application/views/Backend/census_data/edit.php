<form class="censusFrm" id="censusFrm" method="post" action="admin/census_data/updateEntry">
	<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
	<input type="hidden" id="h_censusId" name="h_censusId" value="<?php echo $censusYearData->censusId;?>" />
	<div class="col-md-12">
		<div class="box">
			<?php include(APPPATH.'views/Backend/census_data/manage.php');?>
			<div class="box-footer" style="border-top: none; margin-top: -15px;">
				<button class="btn btn-primary" id="submitBtn" type="submit">Update Now!</button>
			</div> 
		</div>	
	</div>
</form> 
<p>&nbsp;</p> 
<p>&nbsp;</p>
<script type="text/javascript">  
$(function(){
	$('#censusFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		errorElement: 'label',
		errorClass: 'error',
		errorPlacement: function (error, element) {
			if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
				error.insertAfter(element.parent().parent());
			}else {
				error.insertAfter(element);
			}
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = $('#h_base_url').val();
			var form = $('#censusFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
					$("#submitBtn").prop('disabled', true);
				},
				success: function(result, status, xhr){//alert(result);
					var resultArr = result.split('||'); 
					if(resultArr[0]=='success'){
						window.location=resultArr[1];
					}else{
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#result_display').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						$('#submitBtn').html('Update Now!');
						$("#submitBtn").prop('disabled', false);
					}
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#result_display').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#submitBtn').html('Update Now!');
					$("#submitBtn").prop('disabled', false);
				}
			});		
			return false;
		}
	});
}); 
</script>