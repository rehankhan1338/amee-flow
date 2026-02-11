<?php 
$ISLOCnt = $mamDetails['ISLOCnt'];
$GISLOCnt = $mamDetails['GISLOCnt'];
$PSLOCnt = $mamDetails['PSLOCnt'];
if(isset($spDetails['alignISLO']) && $spDetails['alignISLO']!=''){
    $courseISLOArr = explode(',',$spDetails['alignISLO']);
}else{
    $courseISLOArr = array();
}
if(isset($spDetails['alignGISLO']) && $spDetails['alignGISLO']!=''){
    $courseGISLOArr = explode(',',$spDetails['alignGISLO']);
}else{
    $courseGISLOArr = array();
}
if(isset($spDetails['alignPSLO']) && $spDetails['alignPSLO']!=''){
    $coursePSLOArr = explode(',',$spDetails['alignPSLO']);
}else{
    $coursePSLOArr = array();
}
if(isset($spDetails['alignGPSLO']) && $spDetails['alignGPSLO']!=''){
    $courseGPSLOArr = explode(',',$spDetails['alignGPSLO']);
}else{
    $courseGPSLOArr = array();
}

// Check which outcome groups exist
$outcomeGroups = array();
if($ISLOCnt > 0)  $outcomeGroups[] = array('key'=>'ISLO',  'count'=>$ISLOCnt,  'checked'=>$courseISLOArr,  'color'=>'#3b6dd6', 'bg'=>'#eef3ff');
if($GISLOCnt > 0) $outcomeGroups[] = array('key'=>'GISLO', 'count'=>$GISLOCnt, 'checked'=>$courseGISLOArr, 'color'=>'#38855e', 'bg'=>'#eef7f0');
if($PSLOCnt > 0)  $outcomeGroups[] = array('key'=>'PSLO',  'count'=>$PSLOCnt,  'checked'=>$coursePSLOArr,  'color'=>'#9b59b6', 'bg'=>'#f5eef9');
if(isset($mamDetails['GPSLOCnt']) && $mamDetails['GPSLOCnt']>0)  $outcomeGroups[] = array('key'=>'GPSLO', 'count'=>$mamDetails['GPSLOCnt'], 'checked'=>$courseGPSLOArr, 'color'=>'#e67e22', 'bg'=>'#fef5eb');
?>
<section class="content"> 
    <div class="af-wizard-page">

        <!-- Step Indicator -->
        <div class="af-wizard-steps">
            <div class="af-wizard-step completed">
                <span class="af-wizard-step-num"><i class="fa fa-check"></i></span>
                <span class="af-wizard-step-label">Term & Year</span>
            </div>
            <div class="af-wizard-step-line done"></div>
            <div class="af-wizard-step active">
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
                <div class="af-wizard-card-icon" style="background:linear-gradient(135deg,#38855e 0%,#5aae7e 100%);">
                    <i data-feather="check-square"></i>
                </div>
                <div>
                    <h3 class="af-wizard-card-title">Identify the Outcomes Being Assessed</h3>
                    <p class="af-wizard-card-subtitle">
                        <span class="af-wizard-badge"><?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?></span>
                        Step 2: Select the outcomes you are assessing
                    </p>
                </div>
            </div>

            <form id="addProFrm" action="sampling_plan/moveStepThree" method="post">
                <input type="hidden" id="spId" name="spId" value="<?php echo $spDetails['spId'];?>" />
                <input type="hidden" id="speId" name="speId" value="<?php echo $spDetails['speId'];?>" />

                <?php if(count($outcomeGroups) > 0){ ?>
                <div class="af-outcomes-grid">
                    <?php foreach($outcomeGroups as $grp){ ?>
                    <div class="af-outcome-group">
                        <div class="af-outcome-group-header" style="border-left-color:<?php echo $grp['color'];?>;">
                            <span class="af-outcome-group-tag" style="background:<?php echo $grp['bg'];?>;color:<?php echo $grp['color'];?>;"><?php echo $grp['key'];?></span>
                            <span class="af-outcome-group-count"><?php echo $grp['count'];?> item<?php echo $grp['count']>1?'s':'';?></span>
                        </div>
                        <div class="af-outcome-items">
                            <?php for($i=1; $i<=$grp['count']; $i++){ ?>
                            <div class="af-outcome-item">
                                <label class="af-outcome-label" for="chk<?php echo $grp['key'].$i;?>"><?php echo $grp['key'].' '.$i;?></label>
                                <div class="modalbsToggle">
                                    <input <?php if(in_array($i,$grp['checked'])){?> checked="checked" <?php } ?> name="chk<?php echo $grp['key'];?>[]" id="chk<?php echo $grp['key'].$i;?>" value="<?php echo $i;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="af-wizard-empty">
                    <i data-feather="alert-circle"></i>
                    <p>No outcomes available. Please ensure your alignment map is configured.</p>
                </div>
                <?php } ?>

                <div class="af-wizard-card-footer">
                    <a href="<?php echo base_url().'sampling_plan/build';?>" class="af-wizard-btn-secondary">
                        <i data-feather="arrow-left"></i> Back
                    </a>
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
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
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
