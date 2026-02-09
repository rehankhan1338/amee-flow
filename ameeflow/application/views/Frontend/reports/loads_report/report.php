<section class="content">
    <div class="box">        
        <div class="box-header no-border">     
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">   
                <a href="<?php echo base_url().'loads_report';?>" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class="btn btn-warning"> <i class="fa fa-long-arrow-left"></i> Back </a>             
                <button type="button" id="generateReport" class="btn btn-info" style="padding: 3px 15px; font-size:15px; margin-right:5px;" onclick="return genAIReport('<?php echo $reportDetails['rId'];?>');"> Edit Report</button>		  
                <button id="download-pdf" class="btn btn-secondary" style="padding: 3px 15px; font-size:15px; margin-right:5px;"> <i class="fa fa-download"></i> Download</button>		  
                <button id="shareReportBtn" type="button" style="padding: 3px 15px;  font-size:15px;" onclick="return shareReport('<?php echo $reportDetails['rId'];?>');" class='btn btn-primary'> <i class="fa fa-share-alt"></i> Share </button>               
            </div>
        </div>
        <div class="box-body row">
            <?php include(APPPATH.'views/Frontend/reports/loads_report/result-sec.php'); ?>
        </div>
        <?php 
            include(APPPATH.'views/Frontend/reports/sampling_plan/share-modal.php');
            include(APPPATH.'views/Frontend/reports/loads_report/ai-summary.php');
        ?>
    </div>
</section>