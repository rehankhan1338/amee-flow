 <style type="text/css">
.nav-tabs-custom > .nav-tabs > li.active {
border-top-color: #f6e4a5;
}
.nav-tabs-custom > .nav-tabs > li.active > a, .nav-tabs-custom > .nav-tabs > li.active:hover > a {
background: url('<?php echo base_url();?>assets/frontend/images/default/topheaderbg.png');
color: #f6e4a5;
border: 1px solid #34445e;
}
.tab-content > .active {
display: block; 
}
.nav-tabs {
border-bottom: 2px solid #34445e !important;
}
.tab-pane .box{
border-top: 3px solid #d2d6de;
box-shadow:0 2px 2px 1px rgba(0, 0, 0, 0.1);
}
.nav-tabs-custom > .tab-content {
background: #f8f8f8 none repeat scroll 0 0;
border-bottom-left-radius: 0px;
border-bottom-right-radius: 0px;
padding: 20px 15px;
}
.nav-tabs-custom {
background: #f8f8f8 none repeat scroll 0 0;
border-radius: 3px;
box-shadow: 0 0 10px #d7d7d7;
margin-bottom: 20px;
padding:10px;
min-height: 450px;
}
.count_label{
font-size: 16px;
font-weight: bold;
margin: 0px;
padding: 0px;
}
</style>
<section class="content">
	<div class="snapshot_page" style="margin:10px 0 10px 0;">
		<div class="nav-tabs-custom">
		
			<ul class="nav nav-tabs">
				<li class="<?php if(!isset($_GET['tab'])){echo 'active';}?>"><a href="<?php echo base_url();?>admin/unit_review"><span style="font-weight:600;">Unit Reviews <label class="count_label">(<?php echo count($unit_reviews_listing);?>)</label></span></a></li>
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==2){echo 'active';}?>"><a href="<?php echo base_url();?>admin/unit_review?tab=2"><span style="font-weight:600;">Core functions <label class="count_label">(<?php echo count($unit_core_functions_listing);?>)</label></span></a></li>
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==3){echo 'active';}?>"><a href="<?php echo base_url();?>admin/unit_review?tab=3"><span style="font-weight:600;">Strategic Priorities <label class="count_label">(<?php echo count($all_strategic_priorities_count);?>)</label></span></a></li>
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==4){echo 'active';}?>"><a href="<?php echo base_url();?>admin/unit_review?tab=4"><span style="font-weight:600;">Direct / Indirect Measures <label class="count_label">(<?php echo count($all_direct_indirect_measures_count);?>)</label></span></a></li>
			 </ul>
			 
			<div class="tab-content">
			<?php if(!isset($_GET['tab'])){?>
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Unit Reviews </h3>
					</div>
					<table class="table table-hover table-bordered table-striped table_mar20" id="table_recordtbl12">
						<thead>
							<tr class="trbg">
								<th width="3%"  style="vertical-align:top;">#</th>
								<th style="vertical-align:top;">Name of Departments/Programs</th> 
								<th style="vertical-align:top;">Department/Program</th>
								<th style="vertical-align:top;">Academic Year</th>
								<th style="vertical-align:top;">Creation Date</th>
							</tr>
						</thead>
 						<tbody>
							<?php $i=1; foreach ($unit_reviews_listing as $unit_reviews) { 
							
								$department_fulldetails = get_department_fulldetails_h($unit_reviews->department_id)
								
								?>
							<tr>
								<td><?php echo  $i;?></td>
								<td><?php echo ucfirst($unit_reviews->budget_unit_name);?></td>
								<td><?php echo $department_fulldetails->department_name;?></td>
								<td><?php echo $unit_reviews->academic_year.' - '.($unit_reviews->academic_year+1);?></td> 
								<td><?php echo date('m/d/Y',$unit_reviews->add_date);?></td> 
							</tr>
							<?php  $i++; } ?>          
			
						</tbody>
 					</table>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['tab']) && $_GET['tab']==2){?>
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Core functions</h3>
					</div>
					<select class="form-control" style="display:inline-block; margin-left:10px; width:auto;" onchange="return apply_academic_filter(this.value);">
						<option value="">-- All Academic Year --</option>
						<?php for($yl=2015;$yl<=2050;$yl++){?>
							<option value="<?php echo $yl;?>" <?php if(isset($_GET['year']) && $_GET['year']==$yl){?> selected="selected" <?php } ?>><?php echo $yl.' - '.($yl+1);?></option>
						<?php } ?>
					</select>
					<?php include(APPPATH.'views/Backend/unit_review/core_functions.php');?>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['tab']) && $_GET['tab']==3){?>	
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Strategic Priorities</h3>
					</div>
					<?php include(APPPATH.'views/Backend/unit_review/strategic_priorities.php');?>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['tab']) && $_GET['tab']==4){?>	
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Direct / Indirect Measures</h3>
					</div>
					<?php include(APPPATH.'views/Backend/unit_review/direct_indirect_measures.php');?>
				</div>
				<?php } ?>
			</div>
		
		</div>
	</div>
</section>