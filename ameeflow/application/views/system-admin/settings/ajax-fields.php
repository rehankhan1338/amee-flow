<?php 
if(isset($emailDetails['id']) && $emailDetails['id']!=''){
    $etId = $emailDetails['id'];
}else{
    $etId = 0;
}
?>
<input type="hidden" id="emailId" name="emailId" value="<?php echo $etId;?>" />
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Subject *</label>
        <input type="text" id="eSubject" name="eSubject" class="form-control required" placeholder="" value="<?php if(isset($emailDetails['subject']) && $emailDetails['subject']!=''){echo $emailDetails['subject'];}?>" autocomplete="off" />
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Message *</label>
        <textarea rows="5" id="eMsg" name="eMsg" class="form-control"> <?php if(isset($emailDetails['message']) && $emailDetails['message']!=''){echo $emailDetails['message'];}?> </textarea>
    </div>     	 
</div>
<script>    
$(function(){     
    if($('#eMsg').length > 0){
        CKEDITOR.replace( 'eMsg',{height: '250px',}); 
    }	
});
</script> 