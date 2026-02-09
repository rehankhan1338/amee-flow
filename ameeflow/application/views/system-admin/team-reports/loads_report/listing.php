<section class="content">
    <div class="box">  
 
         
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> # </th>
                            <th>Term & Year</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($loadsReportDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <?php echo $i; ?> </td>
 
<td class="fw600"> <a class="cp" onclick="return viewCompleteReport('<?php echo $row['rId'];?>','<?php echo $row['erId'];?>','<?php echo $row['userId'];?>','<?php echo $shareReportFor;?>');"> <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year']; ?> &nbsp;<i id="vrpt<?php echo $row['rId'];?>" class="fa fa-info-circle"></i> </a>  </td>
                            <td class="fw600"> <a id="vfbkLnk<?php echo $row['rId'];?>" class="pro_name" onclick="return viewFeedback('<?php echo $row['rId'];?>','<?php echo $shareReportFor;?>');">View</a> &nbsp;<?php echo '('.$row['feedbackCnt'].')';?> </td>
                            <td>
                                <?php $spApprovalDataArr = getApprovalDataArrCh($row['rId'],$shareReportFor);
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
                            <td> <?php echo date('m/d/Y, h:i A',$row['createOn']);?></td>  
                             
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 

<?php 
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php');
include(APPPATH.'views/system-admin/team-reports/view-report-modal.php');
?>
</section>