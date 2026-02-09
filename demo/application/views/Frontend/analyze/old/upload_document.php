<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />
<div class="box" id="analyze_page">
 	
	<div class="pull-right">
		<a class="btn btn-default" href="<?php echo base_url();?>department/analyze" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
	</div>
	<div class="clearfix"></div>	
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<form class="well" id="frm" action="<?php echo base_url();?>analyze/upload" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<input type="text" class="form-control required" name="title" id="title" placeholder="Enter File Title.." />
			</div>		
			<div class="form-group">
				<input type="file" name="photo"  class="required" />
			</div>
			<input type="submit" class="btn btn-primary" value="Upload Report" style="width:100%;" />
		</form>
	</div>
	<div class="col-md-4"></div>
	<div class="clearfix"></div>
<?php if(count($department_reports_detail)>0){?>
<div class="col-xs-12"> 	
	<div class="box-body">
		<ul id="sortable" class="sortable_drag ui-sortable">
			<?php foreach($department_reports_detail as $department_reports){?>

				<a href="<?php echo base_url();?>assets/upload/department_reports/<?php echo $department_reports->file_name;?>">
					<li><i class="fa fa-upload" aria-hidden="true"></i> <?php echo $department_reports->title;?></li>
				</a>									
			
			<?php }?>
		</ul>
	</div>
</div>
<?php } ?>

</div>		