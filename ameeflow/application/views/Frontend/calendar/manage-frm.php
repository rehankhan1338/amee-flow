<?php 


if(isset($eventDetails['eId']) && $eventDetails['eId']!=''){
    $eId = $eventDetails['eId'];
    $eDate = $eventDetails['eDate'];
}else{
    $eId = 0;
    $eDate = strtotime($selDate);
}

if(isset($copySts) && $copySts!='' && $copySts>0){
    $eId = 0;
}

?>
<input type="hidden" id="caleId" name="caleId" value="<?php echo $eId;?>" />
<input type="hidden" id="caleDate" name="caleDate" value="<?php echo $eDate;?>" />
<div class="col-12 form-fields">
    <label class="form-label">Event Name/Title *</label>
    <input type="text" id="eTitle" name="eTitle" class="form-control required" placeholder="Add Title Here" value="<?php if(isset($eventDetails['eTitle']) && $eventDetails['eTitle']!=''){echo $eventDetails['eTitle'];}?>" autocomplete="off" />
</div>
<div class="row">
    <div class="col-3 form-fields">
        <label class="form-label">Date *</label>
        <input type="text" id="txtDate" name="txtDate" class="form-control required" placeholder="" value="<?php if(isset($eDate) && $eDate!='' && $eDate>0){echo date('m/d/Y',$eDate);}?>" autocomplete="off" />
    </div>
    <div class="col-3 form-fields">
        <label class="form-label">Start Time *</label>
        <input type="time" id="stime" name="stime" class="form-control required" placeholder="" value="<?php if(isset($eventDetails['stime']) && $eventDetails['stime']!='' && $eventDetails['stime']>0){echo date('H:i',$eventDetails['stime']);}?>" autocomplete="off" />
    </div> 
    <div class="col-3 form-fields">
        <label class="form-label">End Time *</label>
        <input type="time" id="etime" name="etime" class="form-control required" placeholder="" value="<?php if(isset($eventDetails['etime']) && $eventDetails['etime']!='' && $eventDetails['etime']>0){echo date('H:i',$eventDetails['etime']);}?>" autocomplete="off" />
    </div> 
    <div class="col-3 form-fields">
        <label class="form-label">Timezone *</label>
        
        <select id="etimeZoneId" name="etimeZoneId" class="form-control required">
        <option value="">Select...</option>
            <?php $timezoneArr = $this->config->item('timezone_array_config');
            foreach($timezoneArr as $key=>$value){?>
            <option <?php if(isset($eventDetails['etimeZoneId']) && $eventDetails['etimeZoneId']==$key){?> selected<?php } ?> value="<?php echo $key;?>"><?php echo $value['name'].' ('.$value['short_name'].')';?></option>
            <?php } ?>
        </select>
    </div> 
</div>   
<div class="col-12 form-fields">
    <label class="form-label">Event Description *</label>
    <textarea rows="5" id="eDesc" name="eDesc"><?php if(isset($eventDetails['eDesc']) && $eventDetails['eDesc']!=''){echo $eventDetails['eDesc'];}?></textarea>
</div>
<div class="col-12 form-fields">
    <label class="form-label">Event URL </label>
    <input type="text" id="eURL" name="eURL" class="form-control" placeholder="Add URL Here" value="<?php if(isset($eventDetails['eURL']) && $eventDetails['eURL']!=''){echo $eventDetails['eURL'];}?>" autocomplete="off" />
</div>
<div class="col-12 form-fields">
    <button type="submit" id="calSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
    <?php if(isset($eventDetails['eId']) && $eventDetails['eId']!=''){?>
    <button type="button" id="backBtn"  onclick="return viewEvent('<?php echo $eId;?>');" class="btn btn-warning" style="margin-left:5px; padding:5px 20px;">Back</button>   
    <?php } ?>
</div>

<script>
$(function(){	       
    if($('#eDesc').length > 0){
        CKEDITOR.replace( 'eDesc',{height: '160px',}); 
    }
    $('#txtDate').datepicker({
		format: "mm/dd/yyyy",
		autoclose: true,
		todayHighlight: true		
	});
});
</script>