<link rel="stylesheet" href="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/css/style.css" />

<style>
#analyze_page .box-body li {
    font-size: 16px;
    margin: 10px 0;
    padding: 10px;
    font-weight: 600;
    cursor: pointer;
}
#sortable li {
    margin: 0 0 10px 0;
    min-height: 40px;
    background: #fff;
    border: 1px solid #e3e3e3;
    border-radius: 3px;
    color: #777;
    box-shadow: 0 0 3px #dedede;
}
#analyze_page .box-body i {
    margin-right: 10px;
}
</style>


<div class="box" id="analyze_page"> 	
	<!--<div class="pull-right">
		<a class="btn btn-default" href="<?php echo base_url();?>department/analyze" style="padding:3px 10px; font-size:15px;"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Dashboard</a>
	</div>-->
	<div class="clearfix"></div>	
	<div class="col-md-4"></div>
	<div class="col-md-4"></div>
	<div class="col-md-4"></div>
	<div class="clearfix"></div>	
		
	<?php if(count($department_reports_detail)>0){?>
	<div class="col-xs-12"> 	
		<div class="box-body">
			<ul id="sortable" class="sortable_drag ui-sortable" style="padding: 0px!important; margin-top: 25px!important;">
				<?php foreach($department_reports_detail as $department_reports){
					
					if(isset($department_reports->department_id)&&$department_reports->department_id!=''){

						$departments_detail = get_department_names_by_id($department_reports->department_id);}?>
						
					<a href="<?php echo base_url();?>assets/upload/department_reports/<?php echo $department_reports->file_name;?>">
						<li><i class="fa fa-download" aria-hidden="true"></i> <?php echo $department_reports->title.' ('.$departments_detail->department_name.') - '.date('m/d/Y h:i A', $department_reports->add_date);?></li>
					</a>									
				
				<?php }?>
			</ul>
		</div>
	</div>
	<?php } ?>

</div>		