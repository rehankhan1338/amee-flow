<section class="content"> 
    <div class="box">
<style>
.fm{ font-family:"Poppins", sans-serif !important;}
.mamPage { font-size:17px;}
</style>
        <div class="box-body row">
            <form id="addProFrm" action="sampling_plan/moveStepTwo" method="post">
            <div class="col-12">
				<div id="popNoteRes" class="ajaxFrmRes"></div>
                <div class="">					 
                    <h4 class="fm">Let's Create Your Sampling Plan</h4>
                    <p class="fm mamPage">Step 1: Identify Term and Year</p>
                    
                    
                    <div class="row">
                        <div class="col-3 form-fields">
                            <label class="form-label">Term *</label>
                            <?php $terms_assessment = $this->config->item('terms_assessment_array_config');?>
                            <select id="termId" name="termId" class="form-control required">
                                <option value="">Select...</option>
                                <?php foreach($terms_assessment as $key=>$value){?>
                                        <option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="col-3 form-fields">
                            <label class="form-label">Year *</label>
                            <input type="number" id="year" name="year" class="form-control required" placeholder="" value="" autocomplete="off">
                        </div>

						<div class="col-3 form-fields">
                            <label class="form-label">Unit Oversight *</label>
                            <select id="oversigntId" name="oversigntId" class="form-control required">
								<option value="">Select...</option>
								<?php foreach($oversightDataArr as $op){ ?>
									<option value="<?php echo $op['oversigntId'];?>"><?php echo $op['unitName'];?></option>
								<?php } ?>
							</select>
                        </div>
						 
                    </div>
                </div>
                <button type="submit" id="continueBtn" class="btn btn-primary mt-2" style="padding:5px 50px;">Continue</button>
            </div>
                                </form>
<script>
$(document).ready(function () {
	$('#addProFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#continueBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#addProFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#continueBtn').prop("disabled", true);
					$('#continueBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						//$('#dayTitleDiv').html(result_arr[1]);
						//$('#addProModal').modal('hide');
						//displayToaster(result_arr[0], '<?php //echo $msgText;?>');	
						//$('#continueBtn').prop("disabled", false);
						//$('#continueBtn').html(btnText);
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#popNoteRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#continueBtn').prop("disabled", false);
						$('#continueBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>
        </div>
    </div>
 
 
</section>