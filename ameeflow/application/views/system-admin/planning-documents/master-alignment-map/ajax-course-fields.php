<?php 
if(isset($courseDetails['mamCourseId']) && $courseDetails['mamCourseId']!=''){
    $mamCourseId = $courseDetails['mamCourseId'];
}else{
    $mamCourseId = 0;
}
?>
<script>
    $(document).ready(function () {
        $('input[type="checkbox"][data-toggle="toggle"]').bootstrapToggle();
    });
</script>
 
<input type="hidden" id="txtmamCourseId" name="txtmamCourseId" value="<?php echo $mamCourseId;?>" />
<input type="hidden" id="txtoversigntId" name="txtoversigntId" value="<?php echo $seloversigntId;?>" />
<input type="hidden" id="txtmamId" name="txtmamId" value="<?php echo $mamDetails['mamId'];?>" />
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Program *</label>
        <input type="text" id="txtProgram" name="txtProgram" class="form-control required" placeholder="" value="<?php if(isset($courseDetails['program']) && $courseDetails['program']!=''){echo $courseDetails['program'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row mb-2">
    <div class="col-5 form-fields">
        <label class="form-label">Subject *</label>
        <input type="text" id="txtcourseSubject" name="txtcourseSubject" class="form-control required" placeholder="" value="<?php if(isset($courseDetails['courseSubject']) && $courseDetails['courseSubject']!=''){echo $courseDetails['courseSubject'];}?>" autocomplete="off" />
    </div>
    <div class="col-7 form-fields">
        <label class="form-label">Course NBR *</label>
        <input type="text" id="txtcourseNBR" name="txtcourseNBR" class="form-control required" placeholder="" value="<?php if(isset($courseDetails['courseNBR']) && $courseDetails['courseNBR']!=''){echo $courseDetails['courseNBR'];}?>" autocomplete="off" />
    </div>
</div>

<?php 
$ISLOCnt = $mamDetails['ISLOCnt'];
$GISLOCnt = $mamDetails['GISLOCnt'];
$PSLOCnt = $mamDetails['PSLOCnt'];
$GPSLOCnt = $mamDetails['GPSLOCnt'];
if(isset($courseDetails['courseISLO']) && $courseDetails['courseISLO']!=''){
    $courseISLOArr = explode(',',$courseDetails['courseISLO']);
}else{
    $courseISLOArr = array();
}
if(isset($courseDetails['courseGISLO']) && $courseDetails['courseGISLO']!=''){
    $courseGISLOArr = explode(',',$courseDetails['courseGISLO']);
}else{
    $courseGISLOArr = array();
}
if(isset($courseDetails['coursePSLO']) && $courseDetails['coursePSLO']!=''){
    $coursePSLOArr = explode(',',$courseDetails['coursePSLO']);
}else{
    $coursePSLOArr = array();
}
if(isset($courseDetails['courseGPSLO']) && $courseDetails['courseGPSLO']!=''){
    $courseGPSLOArr = explode(',',$courseDetails['courseGPSLO']);
}else{
    $courseGPSLOArr = array();
}
?>
<?php if($mamDetails['ISLOCnt']>0){ 
for($is=1;$is<=$mamDetails['ISLOCnt'];$is++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-5">ISLO <?php echo $is;?></label>
    </div>
    <div class="col-7 modalbsToggle">
    <input <?php if(in_array($is,$courseISLOArr)){?> checked="checked" <?php } ?> name="chkISLO[]" id="chkISLO<?php echo $is;?>" value="<?php echo $is;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } } ?>
<?php if($mamDetails['GISLOCnt']>0){ 
for($gis=1;$gis<=$mamDetails['GISLOCnt'];$gis++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-5">GISLO <?php echo $gis;?></label>
    </div>
    <div class="col-7 modalbsToggle">
    <input <?php if(in_array($gis,$courseGISLOArr)){?> checked="checked" <?php } ?> name="chkGISLO[]" id="chkGISLO<?php echo $gis;?>" value="<?php echo $gis;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } } ?>
<?php if($mamDetails['PSLOCnt']>0){ 
for($ps=1;$ps<=$mamDetails['PSLOCnt'];$ps++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-5">PSLO <?php echo $ps;?></label>
    </div>
    <div class="col-7 modalbsToggle">
    <input <?php if(in_array($ps,$coursePSLOArr)){?> checked="checked" <?php } ?> name="chkPSLO[]" id="chkPSLO<?php echo $ps;?>" value="<?php echo $ps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } } ?>
<?php if($mamDetails['GPSLOCnt']>0){ 
for($gps=1;$gps<=$mamDetails['GPSLOCnt'];$gps++){?>
<div class="row mb-2">
    <div class="col-5">
        <label class="form-label px-5">GPSLO <?php echo $gps;?></label>
    </div>
    <div class="col-7 modalbsToggle">
    <input <?php if(in_array($gps,$courseGPSLOArr)){?> checked="checked" <?php } ?> name="chkGPSLO[]" id="chkGPSLO<?php echo $gps;?>" value="<?php echo $gps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
    </div>
</div> 
<?php } } ?>