<section class="content">
    <div class="box">         
       
        <div class="box-header ">	
            <div class="row">	
                <div class="col-md-2">
                    <label class="fw600">Year </label>
                    <select class="form-control" id="yr" name="yr" onchange="return getSPTerms(this.value,'<?php if(isset($_GET['termId']) && $_GET['termId']!=''){echo $_GET['termId'];}else{echo '0';}?>');">
                        <option value="0">All</option>
                        <?php foreach($spYearArr as $yr){?>
                        <option <?php if(isset($_GET['yr']) && $_GET['yr']==$yr['year']){?> selected <?php }?> value="<?php echo $yr['year'];?>"><?php echo $yr['year'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="fw600"><span id="termLoader">Term </span></label>
                    <select class="form-control" id="termId" name="termId">
                        <option value="0">All</option>
                        <?php if(count($termsOptions)>0){ foreach($termsOptions as $term){?>
                        <option <?php if(isset($_GET['termId']) && $_GET['termId']==$term['termId']){?> selected <?php }?> value="<?php echo $term['termId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$term['termId']]['name'];?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-2">
                        <button type="button" id="goBtn" onclick="return applySpFilter();" style="margin-top:20px;" class="btn btn-primary">Apply</button>
                </div>
            </div>
        </div>
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Term & Year</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>                             
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1; foreach($samplingPlanDataArr as $row){ ?>
                        <tr>
                            <td> <?php echo $i;?>  </td>
                            <td class="fw600"> <a class="pro_name" onclick="return viewCompleteReport('<?php echo $row['spId'];?>','<?php echo $row['speId'];?>','<?php echo $row['userId'];?>','<?php echo $shareReportFor;?>');"> <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year'];?> <!-- &nbsp;<i id="vrpt<?php echo $row['spId'];?>" class="fa fa-info-circle" aria-hidden="true"></i>--> </a>  </td>
                            <td class="fw600" style="color:#3714D6;"> <?php echo $row['auName'];?> </td>
                            <td> <?php echo date('m/d/y, h:i A',$row['createTime']);?> </td>
                            <td class="fw600"> <a id="vfbkLnk<?php echo $row['spId'];?>" class="pro_name" onclick="return viewFeedback('<?php echo $row['spId'];?>','<?php echo $shareReportFor;?>');">View</a> &nbsp;<?php echo '('.$row['feedbackCnt'].')';?> </td>
                            <td>
                                <?php $spApprovalDataArr = getApprovalDataArrCh($row['spId'],$shareReportFor);
                                if(count($spApprovalDataArr)>0){
                                    echo '<table class="">';
                                    foreach($spApprovalDataArr as $spApp){
                                        echo '<tr><td class="py-2">';
                                        echo $spApp['swName'].'</td> <td  class="px-2 py-2">';
                                        if($spApp['actionTakenSts']==0){echo '<label class="cscritical spAppSts">Pending</label>';}
                                        if($spApp['actionTakenSts']==1){echo '<label class="cslow spAppSts">Approved</label>';}
                                        if($spApp['actionTakenSts']==2){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="csmedium spAppSts">Approved w/Changes</label>';}
                                        if($spApp['actionTakenSts']==3){echo '<label data-bs-toggle="tooltip" data-bs-placement="bottom" title="'.$spApp['reason'].'" class="cshigh spAppSts">Rejected</label>';}
                                        
                                        echo '</td></tr>';
                                    } 
                                    echo '</table>';
                                }?>
                            </td>
                             
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
 <script>
function applySpFilter(){
    var yr = $('#yr').val();
    var termId = $('#termId').val();
    window.location = '<?php echo base_url().$this->config->item('system_directory_name');?>reports/sampling_plan?yr='+yr+'&termId='+termId;
}
function getSPTerms(year,selTerm){
	var yearChk = parseInt(year);
	if(yearChk>0){
		var uniAdminId = '<?php echo $useuniAdminId;?>';
		$.ajax({
			url: '<?php echo base_url().$this->config->item('system_directory_name');?>reports/ajaxGetSPTerms?uniAdminId='+uniAdminId+'&year='+year+'&selTerm='+selTerm,
			beforeSend: function(){
				$('#termLoader').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
				$('#termId').html('<option value="">Please Wait...</option>');
			},
			success: function(result, status, xhr){
				$('#termId').html(result);
				$('#termLoader').html('Term *');
			}
		});
	}
}
</script>
<?php 
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php');
include(APPPATH.'views/system-admin/team-reports/view-report-modal.php');
?>
</div>
</section>