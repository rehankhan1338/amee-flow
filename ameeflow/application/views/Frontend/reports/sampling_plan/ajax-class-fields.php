<?php 
if(isset($classDetails['ceClassId']) && $classDetails['ceClassId']!=''){
    $ceClassId = $classDetails['ceClassId'];
}else{
    $ceClassId = 0;
}
?>
<input type="hidden" id="txtceClassId" name="txtceClassId" value="<?php echo $ceClassId;?>" />
<input type="hidden" id="txtceId" name="txtceId" value="<?php echo $selceId;?>" />

<div class="row">
    <div class="col-12 form-fields">
        <h5 class="fs17 fw600">Term/Year: &nbsp;<?php echo $this->config->item('terms_assessment_array_config')[$ceDetailsArr['termId']]['name'].' - '.$ceDetailsArr['year']; ?></h5>
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Subject *</label>
        <?php if(count($groupSubjectArr)>0){?>
            <select id="subject" name="subject" class="form-control required">
                <option value="">Select....</option>
                <?php foreach($groupSubjectArr as $sub){?>
                <option <?php if(isset($classDetails['subject']) && $classDetails['subject']==$sub['subject']){echo 'selected';}?> value="<?php echo $sub['subject'];?>"><?php echo $sub['subject'];?></option>
                <?php } ?>
            </select>
        <?php }else{ ?> 
            <input type="text" id="subject" name="subject" class="form-control required" placeholder="" value="<?php if(isset($classDetails['subject']) && $classDetails['subject']!=''){echo $classDetails['subject'];}?>" autocomplete="off" />
        <?php } ?> 
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Course NBR *</label>
        <input type="text" id="courseNBR" name="courseNBR" class="form-control required" placeholder="" value="<?php if(isset($classDetails['courseNBR']) && $classDetails['courseNBR']!=''){echo $classDetails['courseNBR'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Class NBR *</label>
        <input type="text" id="classNBR" name="classNBR" class="form-control required" placeholder="" value="<?php if(isset($classDetails['classNBR']) && $classDetails['classNBR']!=''){echo $classDetails['classNBR'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Section No. *</label>
        <input type="text" id="sectionNo" name="sectionNo" class="form-control required" placeholder="" value="<?php if(isset($classDetails['sectionNo']) && $classDetails['sectionNo']!=''){echo $classDetails['sectionNo'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Course Title *</label>
        <input type="text" id="courseTitle" name="courseTitle" class="form-control required" placeholder="" value="<?php if(isset($classDetails['courseTitle']) && $classDetails['courseTitle']!=''){echo $classDetails['courseTitle'];}?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label"># of Students Enrolled *</label>
        <input type="text" id="enrolled" name="enrolled" class="form-control required" placeholder="" value="<?php if(isset($classDetails['enrolled']) && $classDetails['enrolled']!=''){echo $classDetails['enrolled'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Faculty Name *</label>
        <input type="text" id="facultyName" name="facultyName" class="form-control required" placeholder="" value="<?php if(isset($classDetails['lastName']) && $classDetails['lastName']!=''){echo $classDetails['lastName']; if(isset($classDetails['firstName']) && $classDetails['firstName']!=''){echo ', '.$classDetails['firstName']; } }?>" autocomplete="off" />
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Faculty Email *</label>
        <input type="text" id="facultyEmail" name="facultyEmail" class="form-control email required" placeholder="" value="<?php if(isset($classDetails['facultyEmail']) && $classDetails['facultyEmail']!=''){echo $classDetails['facultyEmail'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Department Name</label>
        <?php if(count($groupdeptNameArr)>0){?>
            <select id="deptName" name="deptName" class="form-control required">
                <option value="">Select....</option>
                <?php foreach($groupdeptNameArr as $aa){?>
                <option <?php if(isset($classDetails['deptName']) && $classDetails['deptName']==$aa['deptName']){echo 'selected';}?> value="<?php echo $aa['deptName'];?>"><?php echo $aa['deptName'];?></option>
                <?php } ?>
            </select>
        <?php }else{ ?> 
            <input type="text" id="deptName" name="deptName" class="form-control" placeholder="" value="<?php if(isset($classDetails['deptName']) && $classDetails['deptName']!=''){echo $classDetails['deptName'];}?>" autocomplete="off" />
        <?php } ?>
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Course Modality </label>
        <?php if(count($groupcourseModalityArr)>0){?>
            <select id="courseModality" name="courseModality" class="form-control required">
                <option value="">Select....</option>
                <?php foreach($groupcourseModalityArr as $aa){?>
                <option <?php if(isset($classDetails['courseModality']) && $classDetails['courseModality']==$aa['courseModality']){echo 'selected';}?> value="<?php echo $aa['courseModality'];?>"><?php echo $aa['courseModality'];?></option>
                <?php } ?>
            </select>
        <?php }else{ ?> 
            <input type="text" id="courseModality" name="courseModality" class="form-control" placeholder="" value="<?php if(isset($classDetails['courseModality']) && $classDetails['courseModality']!=''){echo $classDetails['courseModality'];}?>" autocomplete="off" />
        <?php } ?> 
    </div>
</div>
<div class="row">
    <div class="col-6 form-fields">
        <label class="form-label">Course Level</label>
        <?php if(count($groupcourseLevelArr)>0){?>
            <select id="courseLevel" name="courseLevel" class="form-control required">
                <option value="">Select....</option>
                <?php foreach($groupcourseLevelArr as $aa){?>
                <option <?php if(isset($classDetails['courseLevel']) && $classDetails['courseLevel']==$aa['courseLevel']){echo 'selected';}?> value="<?php echo $aa['courseLevel'];?>"><?php echo $aa['courseLevel'];?></option>
                <?php } ?>
            </select>
        <?php }else{ ?> 
            <input type="text" id="courseLevel" name="courseLevel" class="form-control" placeholder="" value="<?php if(isset($classDetails['courseLevel']) && $classDetails['courseLevel']!=''){echo $classDetails['courseLevel'];}?>" autocomplete="off" />
        <?php } ?> 
    </div>
    <div class="col-6 form-fields">
        <label class="form-label">Course Type</label>
        <?php if(count($groupcourseTypeArr)>0){?>
            <select id="courseType" name="courseType" class="form-control required">
                <option value="">Select....</option>
                <?php foreach($groupcourseTypeArr as $aa){?>
                <option <?php if(isset($classDetails['courseType']) && $classDetails['courseType']==$aa['courseType']){echo 'selected';}?> value="<?php echo $aa['courseType'];?>"><?php echo $aa['courseType'];?></option>
                <?php } ?>
            </select> 
        <?php }else{ ?> 
            <input type="text" id="courseType" name="courseType" class="form-control" placeholder="" value="<?php if(isset($classDetails['courseType']) && $classDetails['courseType']!=''){echo $classDetails['courseType'];}?>" autocomplete="off" />
        <?php } ?> 
    </div>
</div>
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Comment</label>
        <input type="text" id="comment" name="comment" class="form-control" placeholder="" value="<?php if(isset($classDetails['comment']) && $classDetails['comment']!=''){echo $classDetails['comment'];}?>" autocomplete="off" />
    </div>
</div>
