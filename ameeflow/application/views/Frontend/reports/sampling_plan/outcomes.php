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
?>
<section class="content"> 
    <div class="box"> 
		<div class="box-header no-border">
        <h3 class="box-title">Term/Year: &nbsp; <?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?></h3>        
    </div>
        <form id="addProFrm" action="sampling_plan/moveStepThree" method="post">
        <style>
.form-label{float:right;}
            </style>
        <div class="box-body row">
            <input type="hidden" id="spId" name="spId" value="<?php echo $spDetails['spId'];?>" />
            <input type="hidden" id="speId" name="speId" value="<?php echo $spDetails['speId'];?>" />
<?php if($mamDetails['ISLOCnt']>0){ ?>
    <div class="col-3">
        <?php for($is=1;$is<=$mamDetails['ISLOCnt'];$is++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-2">ISLO <?php echo $is;?></label>
    </div>
    <div class="col-6 modalbsToggle">
    <input <?php if(in_array($is,$courseISLOArr)){?> checked="checked" <?php } ?> name="chkISLO[]" id="chkISLO<?php echo $is;?>" value="<?php echo $is;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } ?>
</div> 
<?php } ?>
<?php if($mamDetails['GISLOCnt']>0){ ?>
    <div class="col-3">
        <?php
for($gis=1;$gis<=$mamDetails['GISLOCnt'];$gis++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-2">GISLO <?php echo $gis;?></label>
    </div>
    <div class="col-6 modalbsToggle">
    <input <?php if(in_array($gis,$courseGISLOArr)){?> checked="checked" <?php } ?> name="chkGISLO[]" id="chkGISLO<?php echo $gis;?>" value="<?php echo $gis;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } ?>
</div> 
<?php } ?>
<?php if($mamDetails['PSLOCnt']>0){ ?>
    <div class="col-3">
        <?php
for($ps=1;$ps<=$mamDetails['PSLOCnt'];$ps++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-2">PSLO <?php echo $ps;?></label>
    </div>
    <div class="col-6 modalbsToggle">
    <input <?php if(in_array($ps,$coursePSLOArr)){?> checked="checked" <?php } ?> name="chkPSLO[]" id="chkPSLO<?php echo $ps;?>" value="<?php echo $ps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } ?>
</div> 
<?php } ?>
<?php if($mamDetails['GPSLOCnt']>0){ ?>
    <div class="col-3">
        <?php
for($gps=1;$gps<=$mamDetails['GPSLOCnt'];$gps++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-2">GPSLO <?php echo $gps;?></label>
    </div>
    <div class="col-6 modalbsToggle">
    <input <?php if(in_array($gps,$courseGPSLOArr)){?> checked="checked" <?php } ?> name="chkGPSLO[]" id="chkGPSLO<?php echo $gps;?>" value="<?php echo $gps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } ?>
</div> 
<?php } ?>
</div>
<div class="box-footer">
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
 
 
</section>