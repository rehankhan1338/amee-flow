<section class="content">
    <div class="af-report-page">

        <!-- Top Action Bar -->
        <div class="af-report-topbar">
            <div class="af-report-topbar-left">
                <a href="<?php echo base_url().'loads_report';?>" class="af-report-back-btn">
                    <i data-feather="arrow-left"></i> Back
                </a>
                <h4 class="af-report-topbar-title">LOADs Report</h4>
            </div>
            <div class="af-report-topbar-right">
                <button type="button" id="generateReport" class="af-report-action-btn af-report-action-edit" onclick="return genAIReport('<?php echo $reportDetails['rId'];?>');">
                    <i data-feather="edit-3"></i> <span>Edit Report</span>
                </button>
                <button id="download-pdf" class="af-report-action-btn af-report-action-download">
                    <i data-feather="download"></i> <span>Download</span>
                </button>
                <button id="shareReportBtn" type="button" onclick="return shareReport('<?php echo $reportDetails['rId'];?>');" class="af-report-action-btn af-report-action-share">
                    <i data-feather="share-2"></i> <span>Share</span>
                </button>
            </div>
        </div>

        <!-- Report Card -->
        <div class="af-report-card">
            <?php include(APPPATH.'views/Frontend/reports/loads_report/result-sec.php'); ?>
        </div>

        <?php 
            include(APPPATH.'views/Frontend/reports/sampling_plan/share-modal.php');
            include(APPPATH.'views/Frontend/reports/loads_report/ai-summary.php');
        ?>
    </div>
</section>
