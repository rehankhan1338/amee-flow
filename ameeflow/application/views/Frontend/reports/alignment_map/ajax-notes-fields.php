<h5>Course: <?php echo $courseDetails['courseSubject'].' '.$courseDetails['courseNBR']; ?></h5>
<input type="hidden" id="txt_mamCourseId" name="txt_mamCourseId" value="<?php echo $mamCourseId;?>" />
<input type="hidden" id="txt_oversigntId" name="txt_oversigntId" value="<?php echo $seloversigntId;?>" />
<input type="hidden" id="txt_userId" name="txt_userId" value="<?php echo $sessionDetailsArr['userId'];?>" />
<input type="hidden" id="txt_userAccessId" name="txt_userAccessId" value="<?php echo $sessionDetailsArr['userAccessId'];?>" />
<?php if(isset($mamNoteDetails['notes']) && $mamNoteDetails['notes']!=''){?>
    <div class="col-12 form-fields mt-2">    
        <label class="form-label">Note: &nbsp;<?php echo $mamNoteDetails['notes'];?></label>
    </div>
<?php }else{ ?>
    <div class="col-12 form-fields mt-2">    
        <label class="form-label" for="txtNotes">Notes *</label>
        <textarea rows="5" id="txtNotes" name="txtNotes" class="form-control required"><?php if(isset($mamNoteDetails['notes']) && $mamNoteDetails['notes']!=''){echo $mamNoteDetails['notes'];}?></textarea>   
    </div>
    <div class="col-12 mt-2">
        <button type="submit" id="popCMAMSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
    </div>
<?php } ?>