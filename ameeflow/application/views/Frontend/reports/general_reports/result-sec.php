<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $('#download-pdf').click(function () {
        var element = $('#your-html-section')[0];
        html2pdf(element, {
            margin: 1,
            filename: 'general-report.pdf',
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'tabloid', orientation: 'portrait' }
        });
    });
});
</script>
<div id="your-html-section">
    <!-- Report Title -->
    <div class="af-report-title-bar">
        <div class="af-report-title-icon" style="background:linear-gradient(135deg,#6c5ce7 0%,#a29bfe 100%);">
            <i data-feather="file-text"></i>
        </div>
        <div>
            <h3 class="af-report-title"><?php echo $reportDetails['topicName'];?></h3>
            <p class="af-report-subtitle">General Report</p>
        </div>
    </div>

    <!-- Meta Info Cards -->
    <div class="af-report-meta-grid">
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

    <!-- Report Content / Summary -->
    <?php if(isset($reportDetails['reportSummary']) && $reportDetails['reportSummary']!=''){ ?>
    <div class="af-report-summary-section">
        <div class="af-report-summary-heading">
            <i data-feather="align-left"></i>
            <h4>Report</h4>
        </div>
        <div class="af-report-summary-body">
            <?php echo $reportDetails['reportSummary'];?>
        </div>
    </div>
    <?php } ?>
</div>
