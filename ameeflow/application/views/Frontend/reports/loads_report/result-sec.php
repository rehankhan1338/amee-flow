<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $('#download-pdf').click(function () {
        var element = $('#your-html-section')[0];
        html2pdf(element, {
            margin: 1,
            filename: 'loads-report.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'tabloid', orientation: 'portrait' }
        });
    });
});
</script>
<div id="your-html-section">
    <!-- Report Title -->
    <div class="af-report-title-bar">
        <div class="af-report-title-icon">
            <i data-feather="file-text"></i>
        </div>
        <div>
            <h3 class="af-report-title">Learning Outcomes Assessment Data Report</h3>
            <p class="af-report-subtitle"><?php echo $this->config->item('terms_assessment_array_config')[$reportDetails['termId']]['name'].' - '.$reportDetails['year'];?></p>
        </div>
    </div>

    <!-- Meta Info Cards -->
    <div class="af-report-meta-grid">
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="calendar"></i> Semester</span>
            <span class="af-report-meta-value"><?php echo $this->config->item('terms_assessment_array_config')[$reportDetails['termId']]['name'].' - '.$reportDetails['year'];?></span>
        </div>
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="briefcase"></i> College</span>
            <span class="af-report-meta-value"><?php echo $sessionDetailsArr['universityName'];?></span>
        </div>
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="user"></i> Prepared by</span>
            <span class="af-report-meta-value"><?php echo $sessionDetailsArr['userName'];?></span>
        </div>
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="clock"></i> Date</span>
            <span class="af-report-meta-value"><?php echo date('M d, Y',$reportDetails['createOn']);?></span>
        </div>
    </div>

    <!-- AI Summary Section -->
    <?php if(isset($reportDetails['aiReport']) && $reportDetails['aiReport']!=''){ ?>
    <div class="af-report-summary-section">
        <div class="af-report-summary-heading">
            <i data-feather="align-left"></i>
            <h4>Summary</h4>
        </div>
        <div class="af-report-summary-body">
            <?php echo $reportDetails['aiReport'];?>
        </div>
    </div>
    <?php } ?>
</div>
