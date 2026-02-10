<section class="content">
    <div class="box">         
       
        <div class="box-header no-border">	
            <div class="row align-items-end w-100">	
                <div class="col-md-3">
                    <label class="form-label fw600 mb-2">Year</label>
                    <select class="form-control modern-select" id="yr" name="yr" onchange="return getSPTerms(this.value,'<?php if(isset($_GET['termId']) && $_GET['termId']!=''){echo $_GET['termId'];}else{echo '0';}?>');">
                        <option value="0">All Years</option>
                        <?php foreach($spYearArr as $yr){?>
                        <option <?php if(isset($_GET['yr']) && $_GET['yr']==$yr['year']){?> selected <?php }?> value="<?php echo $yr['year'];?>"><?php echo $yr['year'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw600 mb-2"><span id="termLoader">Term</span></label>
                    <select class="form-control modern-select" id="termId" name="termId">
                        <option value="0">All Terms</option>
                        <?php if(count($termsOptions)>0){ foreach($termsOptions as $term){?>
                        <option <?php if(isset($_GET['termId']) && $_GET['termId']==$term['termId']){?> selected <?php }?> value="<?php echo $term['termId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$term['termId']]['name'];?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw600 mb-2">Approval Status</label>
                    <select class="form-control modern-select" id="approvalStatus" name="approvalStatus">
                        <option value="all" <?php if(!isset($_GET['approvalStatus']) || $_GET['approvalStatus']=='all'){?> selected <?php }?>>All Status</option>
                        <option value="pending" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='pending'){?> selected <?php }?>>Pending</option>
                        <option value="approved" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='approved'){?> selected <?php }?>>Approved</option>
                        <option value="fully_approved" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='fully_approved'){?> selected <?php }?>>Fully Approved</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" id="goBtn" onclick="return applySpFilter();" class="btn btn-primary btn-modern">
                        <i class="fa fa-filter"></i> Apply Filter
                    </button>
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
                        <?php $i = 1; foreach($samplingPlanDataArr as $row){ 
                            $hasFeedback = isset($row['feedbackCnt']) && $row['feedbackCnt'] > 0;
                            $spApprovalDataArr = getApprovalDataArrCh($row['spId'],$shareReportFor);
                            
                            // Determine approval status for filtering
                            $hasPending = false;
                            $hasApproved = false;
                            $allApproved = false;
                            $approvalCount = count($spApprovalDataArr);
                            
                            if($approvalCount > 0){
                                $pendingCount = 0;
                                $approvedCount = 0;
                                foreach($spApprovalDataArr as $spApp){
                                    if($spApp['actionTakenSts'] == 0){
                                        $hasPending = true;
                                        $pendingCount++;
                                    } else if($spApp['actionTakenSts'] == 1 || $spApp['actionTakenSts'] == 2){
                                        $hasApproved = true;
                                        $approvedCount++;
                                    }
                                }
                                $allApproved = ($pendingCount == 0 && $approvedCount == $approvalCount);
                            }
                            
                            // Filter logic
                            $showRow = true;
                            if(isset($_GET['approvalStatus']) && $_GET['approvalStatus'] != 'all'){
                                if($_GET['approvalStatus'] == 'pending' && !$hasPending){
                                    $showRow = false;
                                } else if($_GET['approvalStatus'] == 'approved' && !$hasApproved){
                                    $showRow = false;
                                } else if($_GET['approvalStatus'] == 'fully_approved' && !$allApproved){
                                    $showRow = false;
                                }
                            }
                            
                            if(!$showRow) continue;
                        ?>
                        <tr>
                            <td> <?php echo $i;?>  </td>
                            <td class="fw600">
                                <?php if($hasFeedback){ ?>
                                    <span class="text-muted" style="cursor: not-allowed;" title="View disabled - Feedback available">
                                        <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year'];?>
                                        <i class="fa fa-lock text-muted ml-1" aria-hidden="true"></i>
                                    </span>
                                <?php } else { ?>
                                    <a class="pro_name" onclick="return viewCompleteReport('<?php echo $row['spId'];?>','<?php echo $row['speId'];?>','<?php echo $row['userId'];?>','<?php echo $shareReportFor;?>');">
                                        <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year'];?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="fw600" style="color:#3714D6;"> <?php echo $row['auName'];?> </td>
                            <td> <?php echo date('m/d/y, h:i A',$row['createTime']);?> </td>
                            <td class="fw600">
                                <?php if($hasFeedback){ ?>
                                    <a id="vfbkLnk<?php echo $row['spId'];?>" class="pro_name" onclick="return viewFeedback('<?php echo $row['spId'];?>','<?php echo $shareReportFor;?>');">
                                        <span class="badge bg-warning text-dark">View Feedback</span>
                                    </a>
                                    <span class="text-muted"> (<?php echo $row['feedbackCnt'];?>)</span>
                                <?php } else { ?>
                                    <span class="text-muted">No feedback</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
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
    var approvalStatus = $('#approvalStatus').val();
    window.location = '<?php echo base_url().$this->config->item('system_directory_name');?>reports/sampling_plan?yr='+yr+'&termId='+termId+'&approvalStatus='+approvalStatus;
}
function getSPTerms(year,selTerm){
	var yearChk = parseInt(year);
	if(yearChk>0){
		var uniAdminId = '<?php echo $useuniAdminId;?>';
		$.ajax({
			url: '<?php echo base_url().$this->config->item('system_directory_name');?>reports/ajaxGetSPTerms?uniAdminId='+uniAdminId+'&year='+year+'&selTerm='+selTerm,
			beforeSend: function(){
				$('#termLoader').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
				$('#termId').html('<option value="0">Loading...</option>');
				$('#termId').prop('disabled', true);
			},
			success: function(result, status, xhr){
				$('#termId').html(result);
				$('#termId').prop('disabled', false);
				$('#termLoader').html('Term');
			},
			error: function(){
				$('#termId').html('<option value="0">All Terms</option>');
				$('#termId').prop('disabled', false);
				$('#termLoader').html('Term');
			}
		});
	} else {
		$('#termId').html('<option value="0">All Terms</option>');
		$('#termId').prop('disabled', false);
	}
}
</script>
<?php 
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php');
include(APPPATH.'views/system-admin/team-reports/view-report-modal.php');
?>
</div>
</section>
