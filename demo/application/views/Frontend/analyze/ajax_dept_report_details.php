<script type="text/javascript">  
jQuery(function () {
	if(jQuery('#anlaysisEditor').length > 0){CKEDITOR.replace( 'anlaysisEditor',{height: '220px',}); }	
}); 
</script> 
<div class="form-group">
	<label style="font-size:16px;">Write your own description for <strong><i>"<?php $fMas = filter_array_chk($optionsMasterArr,$deptReptDetails->anlaysisType,'id'); 
	if(isset($fMas[0]['title']) && $fMas[0]['title']!=''){echo $fMas[0]['title'];}?>"</i></strong></label>
	<textarea class="form-control required" id="anlaysisEditor" name="anlaysisDesc" placeholder="" rows="8"><?php echo ($deptReptDetails->reportDesc);?></textarea>
</div>	
<div class="row">
	<div class="col-md-6" style="padding-right:5px;"><button id="saveBtn" type="submit" class="btn btn-primary w100">Save!</button></div>
	<div class="col-md-6" style="padding-left:5px;"><button type="button" class="btn btn-default w100" onclick="return cancelEditAction();">Back</button></div>
</div>	