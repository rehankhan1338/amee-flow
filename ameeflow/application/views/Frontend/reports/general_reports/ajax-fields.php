<?php 
if(isset($reportDetailsArr['rId']) && $reportDetailsArr['rId']!=''){
    $rId = $reportDetailsArr['rId'];
    $erId = $reportDetailsArr['erId'];
}else{
    $rId = 0;
    $erId = '';
}
?>
<input type="hidden" id="rIdChk" name="rIdChk" value="<?php echo $rId;?>" />
<input type="hidden" id="erIdChk" name="erIdChk" value="<?php echo $erId;?>" />
<div class="row">
    <div class="col-12 form-fields">
        <label class="form-label">Add a Title *</label>
        <input type="text" id="ntTopicName" name="ntTopicName" class="form-control required" placeholder="Add Title Here" value="<?php if(isset($reportDetailsArr['topicName']) && $reportDetailsArr['topicName']!=''){echo $reportDetailsArr['topicName'];}?>" autocomplete="off" />
    </div>
    <div class="col-12 form-fields">
        <label class="form-label">Add a Content *</label>
        <textarea rows="3" id="ntTopicContent" name="ntTopicContent" class="form-control required" placeholder="Add Content Details Here"><?php if(isset($reportDetailsArr['topicContent']) && $reportDetailsArr['topicContent']!=''){echo $reportDetailsArr['topicContent'];}?></textarea>
    </div>
    <div class="col-12 form-fields">
        <label class="form-label"> <span id="aiConLoader" class="aiLnk cp" onclick="return genAIGeneralReport();">Generate Report</span> </label>
        <textarea rows="5" id="reportSummary" name="reportSummary" class="form-control"><?php if(isset($reportDetailsArr['reportSummary']) && $reportDetailsArr['reportSummary']!=''){echo $reportDetailsArr['reportSummary'];}?></textarea>
    </div>     	 
</div>

<script>
$(function(){
    if($('#reportSummary').length > 0){
        CKEDITOR.replace( 'reportSummary',{height: '300px',}); 
    }
}); 
</script>