<section class="content">
    <div class="analytics-page-wrapper">
        <div class="analytics-header">
            <div class="analytics-header-content">
                <div class="analytics-icon-wrapper">
                    <svg width="48" height="48" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C15.523 0 20 4.477 20 10C20 15.523 15.523 20 10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0ZM14.596 5.404C14.497 5.30496 14.3662 5.24396 14.2267 5.23171C14.0872 5.21946 13.9478 5.25673 13.833 5.337C10.943 7.365 9.313 8.567 8.939 8.939C8.65761 9.2204 8.49952 9.60205 8.49952 10C8.49952 10.398 8.65761 10.7796 8.939 11.061C9.2204 11.3424 9.60205 11.5005 10 11.5005C10.398 11.5005 10.7796 11.3424 11.061 11.061C11.28 10.841 12.479 9.21 14.659 6.164C14.7401 6.05035 14.7783 5.91161 14.7668 5.77245C14.7553 5.63329 14.6947 5.50274 14.596 5.404ZM15.5 9C15.2348 9 14.9804 9.10536 14.7929 9.29289C14.6054 9.48043 14.5 9.73478 14.5 10C14.5 10.2652 14.6054 10.5196 14.7929 10.7071C14.9804 10.8946 15.2348 11 15.5 11C15.7652 11 16.0196 10.8946 16.2071 10.7071C16.3946 10.5196 16.5 10.2652 16.5 10C16.5 9.73478 16.3946 9.48043 16.2071 9.29289C16.0196 9.10536 15.7652 9 15.5 9ZM4.5 9C4.23478 9 3.98043 9.10536 3.79289 9.29289C3.60536 9.48043 3.5 9.73478 3.5 10C3.5 10.2652 3.60536 10.5196 3.79289 10.7071C3.98043 10.8946 4.23478 11 4.5 11C4.76522 11 5.01957 10.8946 5.20711 10.7071C5.39464 10.5196 5.5 10.2652 5.5 10C5.5 9.73478 5.39464 9.48043 5.20711 9.29289C5.01957 9.10536 4.76522 9 4.5 9ZM6.818 5.404C6.72575 5.30849 6.61541 5.23231 6.4934 5.1799C6.3714 5.12749 6.24018 5.0999 6.1074 5.09875C5.97462 5.0976 5.84294 5.1229 5.72005 5.17318C5.59715 5.22346 5.4855 5.29771 5.3916 5.3916C5.29771 5.4855 5.22346 5.59715 5.17318 5.72005C5.1229 5.84294 5.0976 5.97462 5.09875 6.1074C5.0999 6.24018 5.12749 6.3714 5.1799 6.4934C5.23231 6.61541 5.30849 6.72575 5.404 6.818C5.5926 7.00016 5.8452 7.10095 6.1074 7.09867C6.3696 7.0964 6.62041 6.99123 6.80582 6.80582C6.99123 6.62041 7.0964 6.3696 7.09867 6.1074C7.10095 5.8452 7.00016 5.5926 6.818 5.404ZM10 3.5C9.73478 3.5 9.48043 3.60536 9.29289 3.79289C9.10536 3.98043 9 4.23478 9 4.5C9 4.76522 9.10536 5.01957 9.29289 5.20711C9.48043 5.39464 9.73478 5.5 10 5.5C10.2652 5.5 10.5196 5.39464 10.7071 5.20711C10.8946 5.01957 11 4.76522 11 4.5C11 4.23478 10.8946 3.98043 10.7071 3.79289C10.5196 3.60536 10.2652 3.5 10 3.5Z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="analytics-header-text">
                    <h2 class="analytics-title">Analytics Dashboard</h2>
                    <p class="analytics-subtitle">View project analytics and performance metrics</p>
                </div>
            </div>
        </div>

        <?php if(count($uniProjectManagersDataArr)>0){
            foreach($uniProjectManagersDataArr as $proManager){?>
        <div class="manager-section">
            <div class="manager-header">
                <div class="manager-avatar">
                    <span><?php echo strtoupper(substr($proManager['fullName'], 0, 1)); ?></span>
                </div>
                <h3 class="manager-name"><?php echo $proManager['fullName'];?></h3>
            </div>
            
            <div class="projects-grid">
                <?php $projectArr = filter_array($uniProjectDataArr,$proManager['uniAdminId'],'uniAdminId');
                if(count($projectArr)>0){
                    foreach($projectArr as $pro){ ?>
                <div class="project-card-wrapper">
                    <div class="project-card" style="background: linear-gradient(135deg, <?php echo $pro['bgColor'];?> 0%, <?php echo $pro['bgColor'];?>dd 100%);" onclick="return viewProTask('<?php echo $pro['proencryptId'];?>','<?php echo $pro['projectId'];?>');">
                        <div class="project-card-header">
                            <div class="project-icon">
                                <i class="fa fa-folder-open"></i>
                            </div>
                            <div class="project-card-actions">
                                <span class="view-badge">View Details</span>
                            </div>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title" style="color: <?php echo $pro['fontColor'];?>;"><?php echo $pro['projectName'];?></h3>
                            <div class="project-meta">
                                <div class="meta-item">
                                    <i class="fa fa-calendar" style="color: <?php echo $pro['fontColor'];?>;"></i>
                                    <span style="color: <?php echo $pro['fontColor'];?>;">
                                        <strong><?php echo $this->config->item('terms_assessment_array_config')[$pro['termId']]['name'].' - '.$pro['year']; ?></strong>
                                    </span>
                                </div>
                                <div class="meta-item">
                                    <i class="fa fa-clock-o" style="color: <?php echo $pro['fontColor'];?>;"></i>
                                    <span style="color: <?php echo $pro['fontColor'];?>;">
                                        <?php echo date('m/d/Y', $pro['onTime']);?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="project-card-footer">
                            <div class="project-arrow" id="tlnk<?php echo $pro['projectId'];?>">
                                <i class="fa fa-arrow-right" style="color: <?php echo $pro['fontColor'];?>;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } } ?>
            </div>
        </div>
        <?php } }else{ ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fa fa-bar-chart"></i>
            </div>
            <h3>No Analytics Available</h3>
            <p>There are no projects available for analytics at this time.</p>
        </div>
        <?php } ?>
    </div>
<script>
function viewProTask(proencryptId,projectId){
    $('#tlnk'+projectId).html('<i class="fa fa-spinner fa-spin"></i>');
    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'analytics/tasks/';?>'+proencryptId;
}
</script>
</section>