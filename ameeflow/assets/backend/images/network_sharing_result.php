<script src="<?php echo base_url();?>assets/frontend/js/Chart.min.js"></script>
<div class="content">
<?php 
$userId = $session_details->userId; 
$year = 0;
$shareToOptions = $this->config->item('share_to_options_array_config');
$viewOptionsDataArr = array();
$usersCnt = getShareUsersCntCh($year,$userId);
$SentEmailUsersCnt = getSentEMailsUsersCntCh($year,$userId);
if($usersCnt>0){
?>
<div class="box no-border">    
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-2">Total Shared</h5>
                <table class="table table-bordered" id="table_recordtbl12">
                    <tr>
                        <th>ePortfolio Network</th>
                        <th style="text-align:center;">Count</th>
                        <th style="text-align:center;">Percentage</th>
                    </tr>
                    <?php $i=1;                    
                    $sharedPerOnlyArr = array();
                    $sharedPerWithLabelArr = array();
                    foreach($shareToOptions as $key => $value){
                        $shareCnt = getShareCntBasedonOptionCh($key,$year,$userId);
                        $catPer = round(($shareCnt*100)/$usersCnt);
                        if($shareCnt>0){
                            $sharedPerOnlyArr[] = $catPer;
                            $sharedPerWithLabelArr[] = '"'.$value['name'].' ('.$catPer.'%)"';
                        }
                        ?>			
                        <tr>
                            <td style="font-weight:600;"> <?php echo $value['name'];?> </td>
                            <td style="font-weight:600;text-align:center;"> <?php echo $shareCnt;?> </td>                    
                            <td style="text-align:center;"> <?php echo $catPer.'%';?></td>
                        </tr>			
                    <?php $i++; } ?>                    
                    </tbody>                                      
                </table> 
            </div>
            <div class="col-md-6">
                <canvas id="reportChart"></canvas>
                <script>
                var oilCanvas = document.getElementById("reportChart");
                oilCanvas.height = 270;
                Chart.defaults.global.defaultFontFamily = "Inter";
                Chart.defaults.global.defaultFontSize = 16;
                var reportData = {
                    datasets: [{
                        data: [<?php echo implode(',',$sharedPerOnlyArr);?>],
                        backgroundColor: ["#DB7093","#0496FF", "#003566", "#cdb4db", "#FF7D00", "#00AE50", "#FF00FD", "#C4044C", "#7CB518", "#F69708", "#BC6C25", "#FFC300", "#31572C", "#8338EC"]
                    }],
                    labels: [<?php echo implode(', ',$sharedPerWithLabelArr);?>,],
                };
                var pieChart = new Chart(oilCanvas, {
                    type: 'pie',
                    data: reportData
                });
                </script>
            </div>
        </div>
    </div>
</div>

<?php } 

if(isset($SentEmailUsersCnt['emailsCnt']) && $SentEmailUsersCnt['emailsCnt']!='' && $SentEmailUsersCnt['emailsCnt']>0){ ?>

<div class="box no-border">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-2">Total Viewed</h5>
                <table class="table  table-bordered" id="table_recordtbl12">
                    <tr>
                        <th>ePortfolio Network</th>
                        <th style="text-align:center;">Count</th>
                        <th style="text-align:center;">Percentage</th>
                    </tr>
                    <?php $i=1;                   
                    $viewedPerOnlyArr = array();
                    $viewedPerWithLabelArr = array();
                    foreach($shareToOptions as $key => $value){

                        $sentEmailsCntArr = getSentEmailsCntBasedonOptionCh($key,$year,$userId);  
                        $sentEmailsCnt = 0;
                        $sentEmailsPer = 0;
                        if(isset($sentEmailsCntArr['emailsCnt']) && $sentEmailsCntArr['emailsCnt']!='' && $sentEmailsCntArr['emailsCnt']>0){
                            $sentEmailsCnt = $sentEmailsCntArr['emailsCnt'];
                            $sentEmailsPer = round(($sentEmailsCnt*100)/$SentEmailUsersCnt['emailsCnt']);
                            $viewedPerOnlyArr[] = $sentEmailsPer;
                            $viewedPerWithLabelArr[] = '"'.$value['name'].' ('.$sentEmailsPer.'%)"';
                        }                     
                        
                        ?>			
                        <tr>
                            <td style="font-weight:600;"> <?php echo $value['name'];?> </td>
                            <td style="font-weight:600;text-align:center;"> <?php echo $sentEmailsCnt;?></td>
                            <td style="text-align:center;"> <?php echo $sentEmailsPer.'%';?></td>
                        </tr>			
                    <?php $i++; } ?>                    
                    </tbody>                                      
                </table> 
            </div>
            <div class="col-md-6">
                <canvas id="viewedChart"></canvas>
                <script>
                var oilCanvas = document.getElementById("viewedChart");
                oilCanvas.height = 270;
                Chart.defaults.global.defaultFontFamily = "Inter";
                Chart.defaults.global.defaultFontSize = 16;
                var viewedData = {
                    datasets: [{
                        data: [<?php echo implode(',',$viewedPerOnlyArr);?>],
                        backgroundColor: ["#00AE50","#F69708", "#FFC300", "#8338EC", "#FF7D00", "#DB7093", "#FF00FD", "#C4044C", "#7CB518", "#BC6C25", "#0496FF", "#003566", "#31572C", "#cdb4db"]
                    }],
                    labels: [<?php echo implode(', ',$viewedPerWithLabelArr);?>,],
                };
                var pieChart = new Chart(oilCanvas, {
                    type: 'pie',
                    data: viewedData
                });
                </script>
            </div>
        </div>
    </div>
</div>

<?php } ?>


</div>