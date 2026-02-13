<section class="content">
    <div class="box">         
       
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <!-- Year Filter -->
                <div class="af-select-filter-wrap" id="afYearFilterWrap">
                    <span class="af-select-filter-btn" id="afYearFilterBtn" role="button">
                        <i class="fa fa-calendar-o"></i>
                        <span class="af-select-filter-label"><?php echo (isset($_GET['yr']) && $_GET['yr']!='0' && $_GET['yr']!='') ? $_GET['yr'] : 'All Years'; ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afYearDropdown">
                        <a href="#" class="af-select-filter-option <?php if(!isset($_GET['yr']) || $_GET['yr']=='0' || $_GET['yr']==''){?> selected <?php }?>" data-value="0">All Years</a>
                        <?php foreach($spYearArr as $yr){?>
                        <a href="#" class="af-select-filter-option <?php if(isset($_GET['yr']) && $_GET['yr']==$yr['year']){?> selected <?php }?>" data-value="<?php echo $yr['year'];?>"><?php echo $yr['year'];?></a>
                        <?php } ?>
                    </div>
                </div>
                <!-- Term Filter -->
                <div class="af-select-filter-wrap" id="afTermFilterWrap">
                    <span class="af-select-filter-btn" id="afTermFilterBtn" role="button">
                        <i class="fa fa-bookmark"></i>
                        <span class="af-select-filter-label" id="termFilterLabel"><?php 
                            if(isset($_GET['termId']) && $_GET['termId']!='' && $_GET['termId']!='0'){
                                foreach($termsOptions as $t){
                                    if($t['termId']==$_GET['termId']){
                                        echo $this->config->item('terms_assessment_array_config')[$t['termId']]['name'];
                                    }
                                }
                            } else { echo 'All Terms'; }
                        ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afTermDropdown">
                        <a href="#" class="af-select-filter-option <?php if(!isset($_GET['termId']) || $_GET['termId']=='0' || $_GET['termId']==''){?> selected <?php }?>" data-value="0">All Terms</a>
                        <?php if(count($termsOptions)>0){ foreach($termsOptions as $term){?>
                        <a href="#" class="af-select-filter-option <?php if(isset($_GET['termId']) && $_GET['termId']==$term['termId']){?> selected <?php }?>" data-value="<?php echo $term['termId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$term['termId']]['name'];?></a>
                        <?php } } ?>
                    </div>
                </div>
                <!-- Approval Status Filter -->
                <div class="af-select-filter-wrap" id="afApprovalFilterWrap">
                    <span class="af-select-filter-btn" id="afApprovalFilterBtn" role="button">
                        <i class="fa fa-check-circle"></i>
                        <span class="af-select-filter-label"><?php 
                            if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']!='all'){
                                echo ucwords(str_replace('_',' ',$_GET['approvalStatus']));
                            } else { echo 'All Status'; }
                        ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afApprovalDropdown">
                        <a href="#" class="af-select-filter-option <?php if(!isset($_GET['approvalStatus']) || $_GET['approvalStatus']=='all'){?> selected <?php }?>" data-value="all">All Status</a>
                        <a href="#" class="af-select-filter-option <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='pending'){?> selected <?php }?>" data-value="pending">Pending</a>
                        <a href="#" class="af-select-filter-option <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='approved'){?> selected <?php }?>" data-value="approved">Approved</a>
                        <a href="#" class="af-select-filter-option <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='fully_approved'){?> selected <?php }?>" data-value="fully_approved">Fully Approved</a>
                    </div>
                </div>
            </div>
            <div class="af-roles-toolbar-right">
                <button type="button" id="goBtn" onclick="return applySpFilter();" class="btn btn-primary btn-sm" style="border-radius:22px; padding:6px 18px; font-size:13px;">
                    <i class="fa fa-filter"></i> Apply Filter
                </button>
            </div>
        </div>
        <!-- Hidden selects for filter logic -->
        <select class="d-none" id="yr" name="yr">
            <option value="0">All Years</option>
            <?php foreach($spYearArr as $yr){?>
            <option <?php if(isset($_GET['yr']) && $_GET['yr']==$yr['year']){?> selected <?php }?> value="<?php echo $yr['year'];?>"><?php echo $yr['year'];?></option>
            <?php } ?>
        </select>
        <select class="d-none" id="termId" name="termId">
            <option value="0">All Terms</option>
            <?php if(count($termsOptions)>0){ foreach($termsOptions as $term){?>
            <option <?php if(isset($_GET['termId']) && $_GET['termId']==$term['termId']){?> selected <?php }?> value="<?php echo $term['termId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$term['termId']]['name'];?></option>
            <?php } } ?>
        </select>
        <select class="d-none" id="approvalStatus" name="approvalStatus">
            <option value="all" <?php if(!isset($_GET['approvalStatus']) || $_GET['approvalStatus']=='all'){?> selected <?php }?>>All Status</option>
            <option value="pending" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='pending'){?> selected <?php }?>>Pending</option>
            <option value="approved" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='approved'){?> selected <?php }?>>Approved</option>
            <option value="fully_approved" <?php if(isset($_GET['approvalStatus']) && $_GET['approvalStatus']=='fully_approved'){?> selected <?php }?>>Fully Approved</option>
        </select>
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
                        <?php 
                        $i = 1; 
                        $hasVisibleRows = false;
                        foreach($samplingPlanDataArr as $row){ 
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
                            $hasVisibleRows = true;
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
                        <?php if(!$hasVisibleRows){ ?>
                        <tr class="no-data-row">
                            <td colspan="6" class="text-center py-5">
                                <div class="no-data-message">
                                    <i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p style="font-size: 1.1rem; color: #999; margin: 0; font-weight: 500;">No data found</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
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
				$('#termFilterLabel').html('<i class="fa fa-spinner fa-spin"></i>');
				$('#termId').html('<option value="0">Loading...</option>');
				$('#termId').prop('disabled', true);
			},
			success: function(result, status, xhr){
				$('#termId').html(result);
				$('#termId').prop('disabled', false);
				$('#termFilterLabel').text('All Terms');
				// Rebuild term dropdown options
				var newOptions = '<a href="#" class="af-select-filter-option selected" data-value="0">All Terms</a>';
				$('#termId option').each(function(){
					if($(this).val() !== '0'){
						newOptions += '<a href="#" class="af-select-filter-option" data-value="'+$(this).val()+'">'+$(this).text()+'</a>';
					}
				});
				$('#afTermDropdown').html(newOptions);
				bindTermDropdown();
			},
			error: function(){
				$('#termId').html('<option value="0">All Terms</option>');
				$('#termId').prop('disabled', false);
				$('#termFilterLabel').text('All Terms');
			}
		});
	} else {
		$('#termId').html('<option value="0">All Terms</option>');
		$('#termId').prop('disabled', false);
		$('#afTermDropdown').html('<a href="#" class="af-select-filter-option selected" data-value="0">All Terms</a>');
		$('#termFilterLabel').text('All Terms');
	}
}

$(function(){
    /* Year dropdown */
    $('#afYearFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afTermDropdown, #afApprovalDropdown').removeClass('show');
        $('#afYearDropdown').toggleClass('show');
    });
    $('#afYearDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        $('#yr').val(val);
        $('#afYearDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        $('#afYearFilterBtn .af-select-filter-label').text($(this).text());
        if(val && val !== '0' && val !== 0){
            $('#afYearFilterBtn').addClass('active');
        } else {
            $('#afYearFilterBtn').removeClass('active');
        }
        $('#afYearDropdown').removeClass('show');
        getSPTerms(val, '0');
    });

    /* Term dropdown */
    function bindTermDropdown(){
        $('#afTermDropdown .af-select-filter-option').off('click').on('click', function(e){
            e.preventDefault(); e.stopPropagation();
            var val = $(this).data('value');
            $('#termId').val(val);
            $('#afTermDropdown .af-select-filter-option').removeClass('selected');
            $(this).addClass('selected');
            $('#termFilterLabel').text($(this).text());
            if(val && val !== '0' && val !== 0){
                $('#afTermFilterBtn').addClass('active');
            } else {
                $('#afTermFilterBtn').removeClass('active');
            }
            $('#afTermDropdown').removeClass('show');
        });
    }
    bindTermDropdown();
    $('#afTermFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afYearDropdown, #afApprovalDropdown').removeClass('show');
        $('#afTermDropdown').toggleClass('show');
    });

    /* Approval dropdown */
    $('#afApprovalFilterBtn').on('click', function(e){
        e.stopPropagation();
        $('#afYearDropdown, #afTermDropdown').removeClass('show');
        $('#afApprovalDropdown').toggleClass('show');
    });
    $('#afApprovalDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        $('#approvalStatus').val(val);
        $('#afApprovalDropdown .af-select-filter-option').removeClass('selected');
        $(this).addClass('selected');
        $('#afApprovalFilterBtn .af-select-filter-label').text($(this).text());
        if(val && val !== 'all'){
            $('#afApprovalFilterBtn').addClass('active');
        } else {
            $('#afApprovalFilterBtn').removeClass('active');
        }
        $('#afApprovalDropdown').removeClass('show');
    });

    /* Close on outside click */
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afYearFilterWrap').length){ $('#afYearDropdown').removeClass('show'); }
        if(!$(e.target).closest('#afTermFilterWrap').length){ $('#afTermDropdown').removeClass('show'); }
        if(!$(e.target).closest('#afApprovalFilterWrap').length){ $('#afApprovalDropdown').removeClass('show'); }
    });
});
</script>
<?php 
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php');
include(APPPATH.'views/system-admin/team-reports/view-report-modal.php');
?>
</div>
</section>
