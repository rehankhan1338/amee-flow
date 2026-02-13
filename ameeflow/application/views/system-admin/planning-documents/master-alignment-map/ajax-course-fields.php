<?php 
if(isset($courseDetails['mamCourseId']) && $courseDetails['mamCourseId']!=''){
    $mamCourseId = $courseDetails['mamCourseId'];
}else{
    $mamCourseId = 0;
}

// Helper: parse "1:I,3:ED" or legacy "1,3" into [1=>'I', 3=>'ED']
if(!function_exists('_parseSLOModal')){
    function _parseSLOModal($str){
        $r = array();
        if(!isset($str) || $str==='') return $r;
        foreach(explode(',',$str) as $item){
            $item = trim($item);
            if($item==='') continue;
            if(strpos($item,':')!==false){
                list($n,$v) = explode(':',$item,2);
                $r[trim($n)] = trim($v);
            } else {
                $r[$item] = 'Yes';
            }
        }
        return $r;
    }
}

$modalSloOptions = array('','Yes','I','E','D','IE','ID','ED','IED','M','IP','IM','PM','IPM');
?>
 
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

$courseISLOMap  = _parseSLOModal(isset($courseDetails['courseISLO']) ? $courseDetails['courseISLO'] : '');
$courseGISLOMap = _parseSLOModal(isset($courseDetails['courseGISLO']) ? $courseDetails['courseGISLO'] : '');
$coursePSLOMap = _parseSLOModal(isset($courseDetails['coursePSLO']) ? $courseDetails['coursePSLO'] : '');
$courseGPSLOMap = _parseSLOModal(isset($courseDetails['courseGPSLO']) ? $courseDetails['courseGPSLO'] : '');
?>

<!-- SLO Dropdowns in 2-Column Grid -->
<?php if($mamDetails['ISLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">ISLO</div>
    <div class="af-toggle-grid">
        <?php for($is=1;$is<=$mamDetails['ISLOCnt'];$is++){ $cv = isset($courseISLOMap[$is]) ? $courseISLOMap[$is] : ''; ?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">ISLO <?php echo $is;?></span>
            <select name="sloISLO[<?php echo $is;?>]" class="form-select form-select-sm mam-modal-slo-select<?php if($cv!='') echo ' has-value';?>">
                <?php foreach($modalSloOptions as $opt){ ?>
                <option value="<?php echo $opt;?>"<?php if($cv==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '– None –' : $opt;?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['GISLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">GISLO</div>
    <div class="af-toggle-grid">
        <?php for($gis=1;$gis<=$mamDetails['GISLOCnt'];$gis++){ $cv = isset($courseGISLOMap[$gis]) ? $courseGISLOMap[$gis] : ''; ?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">GISLO <?php echo $gis;?></span>
            <select name="sloGISLO[<?php echo $gis;?>]" class="form-select form-select-sm mam-modal-slo-select<?php if($cv!='') echo ' has-value';?>">
                <?php foreach($modalSloOptions as $opt){ ?>
                <option value="<?php echo $opt;?>"<?php if($cv==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '– None –' : $opt;?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['PSLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">PSLO</div>
    <div class="af-toggle-grid">
        <?php for($ps=1;$ps<=$mamDetails['PSLOCnt'];$ps++){ $cv = isset($coursePSLOMap[$ps]) ? $coursePSLOMap[$ps] : ''; ?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">PSLO <?php echo $ps;?></span>
            <select name="sloPSLO[<?php echo $ps;?>]" class="form-select form-select-sm mam-modal-slo-select<?php if($cv!='') echo ' has-value';?>">
                <?php foreach($modalSloOptions as $opt){ ?>
                <option value="<?php echo $opt;?>"<?php if($cv==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '– None –' : $opt;?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<?php if($mamDetails['GPSLOCnt']>0){ ?>
<div class="af-toggle-section">
    <div class="af-toggle-section-title">GPSLO</div>
    <div class="af-toggle-grid">
        <?php for($gps=1;$gps<=$mamDetails['GPSLOCnt'];$gps++){ $cv = isset($courseGPSLOMap[$gps]) ? $courseGPSLOMap[$gps] : ''; ?>
        <div class="af-toggle-item">
            <span class="af-toggle-label">GPSLO <?php echo $gps;?></span>
            <select name="sloGPSLO[<?php echo $gps;?>]" class="form-select form-select-sm mam-modal-slo-select<?php if($cv!='') echo ' has-value';?>">
                <?php foreach($modalSloOptions as $opt){ ?>
                <option value="<?php echo $opt;?>"<?php if($cv==$opt && $opt!='') echo ' selected';?>><?php echo $opt==='' ? '– None –' : $opt;?></option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>

<script>
// Toggle green styling on modal dropdowns when value changes
$(document).off('change','.mam-modal-slo-select').on('change','.mam-modal-slo-select',function(){
    if($(this).val()!==''){$(this).addClass('has-value');}else{$(this).removeClass('has-value');}
});
</script>