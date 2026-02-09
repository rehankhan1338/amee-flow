<section class="content">
    <div class="box">  
 
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteReport();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageReport('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Term/Year</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>
                            <!-- <th>Courses / Programs</th>
                            <th>Strengths</th>
                            <th>Improvement</th>
                            <th>Next Steps</th>
                            <th>Recommendations</th>
                            <th>Planned Follow-Up</th> -->
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($userLoadsReportDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="rIds[]" name="rIds[]" value="<?php echo $row['rId'];?>" /> </td>
                            <td style="font-weight:500;"> <a href="<?php echo base_url().'loads_report/view/'.$row['erId'];?>" class="pro_name"> <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year']; ?> </a> </td>
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
                            <!-- <td><?php //echo $row['courseProgram'];?></td>
                            <td><?php //echo $row['strengths'];?></td>
                            <td><?php //echo $row['areaImprovement'];?></td>
                            <td><?php //echo $row['imdtNextStep'];?></td>
                            <td><?php //echo $row['recdProgram'];?></td>
                            <td><?php //echo $row['planFollowup'];?></td>-->
                            <td> <?php echo date('m/d/Y, h:i A',$row['createOn']);?></td>  
                            <td>                                
                                <a class="btn btn-secondary btn-sm" id="edrole<?php echo $row['rId'];?>" onclick="return manageReport('<?php echo $row['rId'];?>');">Edit</a>                                
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 

<?php 
include(APPPATH.'views/Frontend/reports/loads_report/pop-model.php');
include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php'); 
?>
</section>