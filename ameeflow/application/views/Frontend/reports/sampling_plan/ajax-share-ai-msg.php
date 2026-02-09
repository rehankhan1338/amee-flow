<label class="form-label">Message *</label>
<textarea id="txt_sentMsg" name="txt_sentMsg" class="form-control" rows="5"><?php if(isset($aiShareContent) && $aiShareContent!=''){echo $aiShareContent;}?></textarea>
<script>
$(function(){ 
    if($('#txt_sentMsg').length > 0){
        CKEDITOR.replace( 'txt_sentMsg',{height: '200px',}); 
    }
});
</script>