<section class="content"> 
    <div class="af-wizard-page">

        <!-- Step Indicator -->
        <div class="af-wizard-steps">
            <div class="af-wizard-step active">
                <span class="af-wizard-step-num">1</span>
                <span class="af-wizard-step-label">Term & Year</span>
            </div>
            <div class="af-wizard-step-line"></div>
            <div class="af-wizard-step">
                <span class="af-wizard-step-num">2</span>
                <span class="af-wizard-step-label">Outcomes</span>
            </div>
            <div class="af-wizard-step-line"></div>
            <div class="af-wizard-step">
                <span class="af-wizard-step-num">3</span>
                <span class="af-wizard-step-label">Participants</span>
            </div>
        </div>

        <!-- Wizard Card -->
        <div class="af-wizard-card">
            <div class="af-wizard-card-header">
                <div class="af-wizard-card-icon">
                    <i data-feather="clipboard"></i>
                </div>
                <div>
                    <h3 class="af-wizard-card-title">Let's Create Your Sampling Plan</h3>
                    <p class="af-wizard-card-subtitle">Step 1: Identify Term and Year</p>
                </div>
            </div>

            <form id="addProFrm" action="sampling_plan/moveStepTwo" method="post">
                <div id="popNoteRes" class="ajaxFrmRes"></div>

                <div class="af-wizard-form-grid">
                    <div class="af-wizard-field">
                        <label class="af-wizard-label" for="termId">Term <span class="text-danger">*</span></label>
                        <?php $terms_assessment = $this->config->item('terms_assessment_array_config');?>
                        <select id="termId" name="termId" class="af-wizard-select required">
                            <option value="">Select term...</option>
                            <?php foreach($terms_assessment as $key=>$value){?>
                                <option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="af-wizard-field">
                        <label class="af-wizard-label" for="year">Year <span class="text-danger">*</span></label>
                        <input type="number" id="year" name="year" class="af-wizard-input required" placeholder="e.g. <?php echo date('Y');?>" value="" autocomplete="off">
                    </div>
                    <div class="af-wizard-field">
                        <label class="af-wizard-label" for="oversigntId">Unit Oversight <span class="text-danger">*</span></label>
                        <select id="oversigntId" name="oversigntId" class="af-wizard-select required">
                            <option value="">Select unit...</option>
                            <?php foreach($oversightDataArr as $op){ ?>
                                <option value="<?php echo $op['oversigntId'];?>"><?php echo $op['unitName'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="af-wizard-card-footer">
                    <button type="submit" id="continueBtn" class="af-wizard-btn-primary">
                        Continue <i data-feather="arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

<script>
$(document).ready(function () {
    feather.replace();
	$('#addProFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.af-wizard-field').addClass('has-error');
		},
		success: function(element) {
			element.closest('.af-wizard-field').removeClass('has-error');
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
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
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
</section>
