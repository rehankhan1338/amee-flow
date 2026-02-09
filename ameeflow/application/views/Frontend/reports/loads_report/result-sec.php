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
    <h3 class="my-4 hclr fw600">Learning Outcomes Assessment Data Report</h3>
    <div class="topSec">
        
        <p>Semester: <label><?php echo $this->config->item('terms_assessment_array_config')[$reportDetails['termId']]['name'].' - '.$reportDetails['year'];?> </label> </p>
        <p>College: <label><?php echo $sessionDetailsArr['universityName'];?></label> </p>
        <p>Prepared by: <label><?php echo $sessionDetailsArr['userName'];?></label> </p>
        <p>Date: <label><?php echo date('M d, Y',$reportDetails['createOn']);?></label> </p>
    </div>     
    <?php if(isset($reportDetails['aiReport']) && $reportDetails['aiReport']!=''){ ?>
    <h4 class="mb-2 mt-4 hclr">Summary</h4>
    <div class="aiSum">
        <?php echo $reportDetails['aiReport'];?>
    </div>
    <?php } ?>
</div>