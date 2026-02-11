<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $('#download-pdf').click(function () {
        var element = $('#your-html-section')[0];
        html2pdf(element, {
            margin: 1,
            filename: 'sampling-plan-report.pdf',
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
            <h3 class="af-report-title">Course Sampling Plan Report</h3>
            <p class="af-report-subtitle"><?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?></p>
        </div>
    </div>

    <!-- Meta Info Cards -->
    <div class="af-report-meta-grid">
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="user"></i> Area Expert</span>
            <span class="af-report-meta-value"><?php if(isset($spUserAccessDetails['auName']) && $spUserAccessDetails['auName']!=''){echo $spUserAccessDetails['auName'];}else{echo $sessionDetailsArr['userName'];}?></span>
        </div>
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="calendar"></i> Term/Year</span>
            <span class="af-report-meta-value"><?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?></span>
        </div>
        <div class="af-report-meta-item">
            <span class="af-report-meta-label"><i data-feather="clock"></i> Date</span>
            <span class="af-report-meta-value"><?php echo date('M d, Y',$spDetails['createTime']);?></span>
        </div>
    </div>

    <!-- Course Sampling Details Table -->
    <div class="af-report-summary-section">
        <div class="af-report-summary-heading">
            <i data-feather="book-open"></i>
            <h4>Course Sampling Details</h4>
        </div>
        <div class="af-report-table-wrap">
            <table class="af-report-table">
                <thead>
                    <tr>
                        <th width="4%">#</th>
                        <th>Collaborator Name</th>
                        <th>Course Title</th>
                        <th>Course Level</th>
                        <th width="12%">Total Enrolled</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1;
                    $totalEnrollArr = array();
                    foreach($samplingPlanCoursesDataArr as $row){
                        if($row['courseSts']==1 || (isset($row['courseNotes']) && $row['courseNotes']!='')){
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td class="fw600"><?php echo $row['lastName']; if(isset($row['firstName']) && $row['firstName']!=''){echo ', '.$row['firstName'];} ?></td>
                        <td><?php echo $row['subject'].' '.$row['courseNBR'].' - '.$row['courseTitle'].' ('.strtoupper($row['sloFor']).')'; ?></td>
                        <td><?php if(isset($row['courseLevel']) && $row['courseLevel']!=''){echo ucwords($row['courseLevel']);} ?></td>
                        <td><?php echo $row['enrolled'];
                        $totalEnrollArr[] = $row['enrolled']; ?></td>
                    </tr>
                    <?php $i++; } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo array_sum($totalEnrollArr);?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- AI Summary Section -->
    <?php if(isset($spDetails['aiSummary']) && $spDetails['aiSummary']!=''){ ?>
    <div class="af-report-summary-section" style="margin-top:28px;">
        <div class="af-report-summary-heading">
            <i data-feather="align-left"></i>
            <h4>Summary</h4>
        </div>
        <div class="af-report-summary-body">
            <?php echo $spDetails['aiSummary'];?>
        </div>
    </div>
    <?php } ?>
</div>
