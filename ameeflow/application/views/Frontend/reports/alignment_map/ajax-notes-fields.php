<input type="hidden" id="txt_mamCourseId" name="txt_mamCourseId" value="<?php echo $mamCourseId;?>" />
<input type="hidden" id="txt_oversigntId" name="txt_oversigntId" value="<?php echo $seloversigntId;?>" />
<input type="hidden" id="txt_userId" name="txt_userId" value="<?php echo $sessionDetailsArr['userId'];?>" />
<input type="hidden" id="txt_userAccessId" name="txt_userAccessId" value="<?php echo $sessionDetailsArr['userAccessId'];?>" />

<!-- Course Info Badge -->
<div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding:14px 18px;background:linear-gradient(135deg,#f8fafc,#eef2f7);border-radius:12px;border:1px solid #e5e7eb;">
    <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#485b79,#3a4d6b);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;flex-shrink:0;">
        <i class="fa fa-book"></i>
    </div>
    <div>
        <div style="font-size:.82rem;color:#64748b;font-weight:500;">Course</div>
        <div style="font-size:1.05rem;color:#1e293b;font-weight:700;"><?php echo $courseDetails['courseSubject'].' '.$courseDetails['courseNBR']; ?></div>
    </div>
</div>

<?php if(isset($mamNoteDetails['notes']) && $mamNoteDetails['notes']!=''){?>
<!-- Existing Note Display -->
<div style="padding:16px 18px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;">
    <div style="font-size:.82rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Note</div>
    <div style="font-size:.93rem;color:#334155;line-height:1.65;"><?php echo $mamNoteDetails['notes'];?></div>
</div>
<?php }else{ ?>
<!-- Note Input -->
<div style="margin-bottom:18px;">
    <label class="form-label" for="txtNotes" style="font-size:.85rem;font-weight:600;color:#475569;margin-bottom:8px;display:block;">Notes <span style="color:#e1304c;">*</span></label>
    <textarea rows="5" id="txtNotes" name="txtNotes" class="form-control required" placeholder="Enter your notes here..." style="resize:vertical;"><?php if(isset($mamNoteDetails['notes']) && $mamNoteDetails['notes']!=''){echo $mamNoteDetails['notes'];}?></textarea>
</div>
<div>
    <button type="submit" id="popCMAMSaveBtn" class="btn" style="display:inline-flex;align-items:center;gap:6px;padding:10px 36px;border-radius:38px;font-size:.9rem;font-weight:600;background:linear-gradient(135deg,#485b79,#3a4d6b);color:#fff;border:none;cursor:pointer;transition:all .2s;">
        <i class="fa fa-check"></i> Save
    </button>
</div>
<?php } ?>