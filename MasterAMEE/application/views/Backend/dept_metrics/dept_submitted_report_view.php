<section class="content">
<style>
.snapshot_page{margin:5px 0;}
.snapshot_page_title { background: #485b79;padding: 5px 15px; letter-spacing:0.2px; font-size: 16px;  color: #f6e4a5; border-radius: 5px; font-weight: 600;}
.snapshot_page .timeline > li > .timeline-item {-webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);box-shadow: 0 1px 1px #f5f5f5;border-radius: 3px;margin-top: 15px;background: #f5f5f5;color: #333;margin-left: 60px;margin-right: 15px;padding: 0;position: relative;}
.snapshot_page .timeline-header p{margin:0px;line-height:25px; padding-bottom:5px; padding-top:5px;} 
.snapshot_page .timeline-header ul li, .snapshot_page .timeline-header ol li{ padding:5px 15px;}

.snapshot_page .timeline-header b, .snapshot_page .timeline-header strong{ font-weight:600;}
</style>
<div class="box snapshot_page"> 
	<div class=" pull-right">
		<a class="btn btn-default" href="<?php echo base_url().'admin/department_reports';?>" style="padding:3px 15px; margin-left:5px; font-weight:600; font-size:15px;"><i class="fa fa-long-arrow-left"></i> Back to Report List</a>
	</div>
<div class="col-md-12">
 	<?php if(count($myDeptReportingData)>0){?>
	<ul class="timeline">
		<?php foreach($myDeptReportingData as $reportDetails){?>
 		<li>
			<label class="snapshot_page_title"><?php $fMas = filter_array_chk($optionsMasterArr,$reportDetails['anlaysisType'],'id'); echo $fMas[0]['title'];?></label>
				<div class="timeline-item">
				<div class="timeline-header"><?php echo $reportDetails['reportDesc'];?></div>
			</div>
		</li>		 
 	<?php } ?> 
	</ul>
	<?php } ?>
</div>	
</div>
</section>