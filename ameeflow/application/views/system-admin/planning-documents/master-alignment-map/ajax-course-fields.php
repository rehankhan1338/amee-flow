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

<!-- Programme & Course Fields -->
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Program *</label>
        <input type="text" id="txtProgram" name="txtProgram" class="form-control required" placeholder="" value="<?php if(isset($courseDetails['program']) && $courseDetails['program']!=''){echo $courseDetails['program'];}?>" autocomplete="off" />
    </div>
</div>
<div class="row mb-3">
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

<!-- SLO Toggles in 2-Column Grid -->
<?php if($mamDetails['ISLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">ISLO</div>
    <div class="af-toggle-grid">
        <?php for($is=1;$is<=$mamDetails['ISLOCnt'];$is++){?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">ISLO <?php echo $is;?></span>
            <div class="modalbsToggle">
                <input <?php if(in_array($is,$courseISLOArr)){?> checked="checked" <?php } ?> name="chkISLO[]" id="chkISLO<?php echo $is;?>" value="<?php echo $is;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['GISLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">GISLO</div>
    <div class="af-toggle-grid">
        <?php for($gis=1;$gis<=$mamDetails['GISLOCnt'];$gis++){?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">GISLO <?php echo $gis;?></span>
            <div class="modalbsToggle">
                <input <?php if(in_array($gis,$courseGISLOArr)){?> checked="checked" <?php } ?> name="chkGISLO[]" id="chkGISLO<?php echo $gis;?>" value="<?php echo $gis;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['PSLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">PSLO</div>
    <div class="af-toggle-grid">
        <?php for($ps=1;$ps<=$mamDetails['PSLOCnt'];$ps++){?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">PSLO <?php echo $ps;?></span>
            <div class="modalbsToggle">
                <input <?php if(in_array($ps,$coursePSLOArr)){?> checked="checked" <?php } ?> name="chkPSLO[]" id="chkPSLO<?php echo $ps;?>" value="<?php echo $ps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['GPSLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">GPSLO</div>
    <div class="af-toggle-grid">
        <?php for($gps=1;$gps<=$mamDetails['GPSLOCnt'];$gps++){?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">GPSLO <?php echo $gps;?></span>
            <div class="modalbsToggle">
                <input <?php if(in_array($gps,$courseGPSLOArr)){?> checked="checked" <?php } ?> name="chkGPSLO[]" id="chkGPSLO<?php echo $gps;?>" value="<?php echo $gps;?>" data-toggle="toggle" data-size="" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" type="checkbox">
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>