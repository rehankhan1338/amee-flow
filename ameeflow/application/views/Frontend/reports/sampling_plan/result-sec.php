<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $('#download-pdf').click(function () {
        var element = $('#your-html-section')[0];
        html2pdf(element, {
            margin: 1,
            filename: '<?php //echo $current_assessments_data->slug;?>sampling-plan-report.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'tabloid', orientation: 'portrait' }
        });
    });
});
</script>
<div class="col-12 spReport" id="your-html-section">
    <h3 class="my-4 hclr fw600">Course Sampling Plan Report</h3>
    <div class="topSec">
        <p>Area Expert: <label><?php if(isset($spUserAccessDetails['auName']) && $spUserAccessDetails['auName']!=''){echo $spUserAccessDetails['auName'];}else{echo $sessionDetailsArr['userName'];}?></label> </p>
        <p>Term/Year: <label><?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?> </label> </p>
        <p>Date: <label><?php echo date('M d, Y',$spDetails['createTime']);?></label> </p>
    </div>
    <h4 class="my-4 hclr">Course Sampling Details</h4>
    <table class="table">
        <tr>
            <th>#</th>
            <th>Collaborator Name</th>
            <th>Course Title</th>
            <th>Course Level</th>
            <th>Total Enrolled </th>                   
        </tr>
        <?php $i=1;
        $totalEnrollArr = array();
        foreach($samplingPlanCoursesDataArr as $row){
            if($row['courseSts']==1 || (isset($row['courseNotes']) && $row['courseNotes']!='')){
                ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row['lastName']; if(isset($row['firstName']) && $row['firstName']!=''){echo ', '.$row['firstName'];} ?></td>
            <td><?php echo $row['subject'].' '.$row['courseNBR'].' - '.$row['courseTitle'].' ('.strtoupper($row['sloFor']).')'; ?></td>
            <td><?php if(isset($row['courseLevel']) && $row['courseLevel']!=''){echo ucwords($row['courseLevel']);} ?></td>
            <td><?php echo $row['enrolled'];
            $totalEnrollArr[] = $row['enrolled']; ?></td>
        </tr>
        <?php $i++; } } ?>
        <tr>
            <th colspan="4">Total</th>
            <th> <?php echo array_sum($totalEnrollArr);?></th>
        </tr>
    </table>
    <?php if(isset($spDetails['aiSummary']) && $spDetails['aiSummary']!=''){ ?>
    <h4 class="mb-2 mt-4 hclr">Summary</h4>
    <div class="aiSum">
        <?php echo $spDetails['aiSummary'];?>
    </div>
    <?php } ?>
</div>