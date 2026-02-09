<section class="content">
    <div class="box">         
        <div class="box-header no-border">
            <h3 class="box-title">Reports </h3>
            <div class="box-tools pull-right">                
                <button id="delProBtn" type="button" onclick="return deleteSamplingPlan();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <!-- <button id="emamBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageMam('<?php //echo $mamDetailsArr['ceId'];?>');" class='btn btn-primary'> Update Map </button>                -->
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
                            <th>Term/Year</th>
                            <th>Created On</th>
                            <th>Feedback</th>
                            <th>Approval(s)</th>
                            <!-- <th>ISLO</th>
                            <th>GISLO</th>
                            <th>PSLO</th>
                            <th>GPSLO</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($userSamplingPlanDataArr as $row){
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="spIds[]" name="spIds[]" value="<?php echo $row['spId'];?>" />  </td>
                            <td class="fw600"> <a class="pro_name" href="<?php echo base_url().'sampling_plan/report/'.$row['speId'];?>"> <?php echo $this->config->item('terms_assessment_array_config')[$row['termId']]['name'].' - '.$row['year'];?> </a>  </td>
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
                            <!-- <td> <?php //echo str_replace(',',', ',$row['alignISLO']);?> </td>
                            <td> <?php //echo str_replace(',',', ',$row['alignGISLO']);?> </td>
                            <td> <?php //echo str_replace(',',', ',$row['alignPSLO']);?> </td>
                            <td> <?php //echo str_replace(',',', ',$row['alignGPSLO']);?> </td>  -->
                            <td> 
                                <a class="deBtn" href="<?php echo base_url().'sampling_plan/participants/'.$row['speId'];?>"> <i class="icon-sm" data-feather="edit"></i> </a> 
                                <?php if(isset($row['comment']) && $row['comment']!=''){?> <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row['comment'];?>" > <i class="icon-sm mx-2" data-feather="info"></i> </span> <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
<script>
function deleteSamplingPlan(){
	var n = $(".case:checked").length;
	if(n>=1){
        var r = confirm("Are you sure want to delete it!");
        if (r == true) {    
            var new_array=[];
            $(".case:checked").each(function() {
                var n_total=parseInt($(this).val());
                new_array.push(n_total);
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url().'sampling_plan/deleteSamplingPlan?spIds=';?>'+new_array,
                beforeSend: function(){
                    $('#delProBtn').prop("disabled", true);
                    $('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().'sampling_plan';?>';      
                }
            });
        }
	}else{
		alert("Please select at least one plan!");
		return false;
	}
}
</script>

<?php include(APPPATH.'views/Frontend/reports/sampling_plan/view-feedback.php'); ?>


</div>
</section>