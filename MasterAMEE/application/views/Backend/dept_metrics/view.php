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
.calender_filter{display:inline-block; margin-left:20px;}
.calender_filter label{margin:0 10px;}
.calender_filter input{display:inline-block; margin-left:10px; width:auto;}
.calender_filter .btn{ display:inline-block; margin:0px 0 3px 15px;}
</style>

<section class="content">
	<div class="snapshot_page" style="margin:10px 0 10px 0;">
		<div class="nav-tabs-custom">
		
			<ul class="nav nav-tabs">
				<li class="<?php if(!isset($_GET['tab'])){echo 'active';}?>"><a href="<?php echo base_url();?>admin/department_metrics"><span style="font-weight:600;">Survey Metrics </span></a></li>
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==2){echo 'active';}?>"><a href="<?php echo base_url();?>admin/department_metrics?tab=2"><span style="font-weight:600;">Test Metrics </span></a></li>
				<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==3){echo 'active';}?>"><a href="<?php echo base_url();?>admin/department_metrics?tab=3"><span style="font-weight:600;">Assignment Metrics </span></a></li>
			 </ul>
			 
			<div class="tab-content">
			<?php if(!isset($_GET['tab'])){?>
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Survey Metrics </h3>
					</div>
					<div class="calender_filter">						
						<label>From: </label><input type="text" class="form-control" name="from_date" id="from_date" value="<?php if(isset($_GET['fd']) && $_GET['fd']!=''){echo $_GET['fd'];}?>" readonly=""/>
						<label>To: </label><input type="text" class="form-control" name="to_date" id="to_date" value="<?php if(isset($_GET['td']) && $_GET['td']!=''){echo $_GET['td'];}?>" readonly=""/>
						<input type="button" onclick="return fetch_detail('1');" value="Show" class="btn btn-primary" />
						<input type="button" onclick="return clear_date('1');" value="Clear" class="btn btn-default" />	
					</div>
					<?php include(APPPATH.'views/Backend/dept_metrics/survey.php');?>					
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['tab']) && $_GET['tab']==2){?>
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Test Metrics</h3>
					</div>
					<div class="calender_filter">						
						<label>From: </label><input type="text" class="form-control" name="from_date" id="from_date" value="<?php if(isset($_GET['fd']) && $_GET['fd']!=''){echo $_GET['fd'];}?>" readonly=""/>
						<label>To: </label><input type="text" class="form-control" name="to_date" id="to_date" value="<?php if(isset($_GET['td']) && $_GET['td']!=''){echo $_GET['td'];}?>" readonly=""/>
						<input type="button" onclick="return fetch_detail('1');" value="Show" class="btn btn-primary" />
						<input type="button" onclick="return clear_date('1');" value="Clear" class="btn btn-default" />	
					</div>
					<?php include(APPPATH.'views/Backend/dept_metrics/tests.php');?>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['tab']) && $_GET['tab']==3){?>	
				<div>
					<div class="contenttitle2 nomargintop">
						<h3>Assignment Metrics</h3>
					</div>
					<div class="calender_filter">						
						<label>From: </label><input type="text" class="form-control" name="from_date" id="from_date" value="<?php if(isset($_GET['fd']) && $_GET['fd']!=''){echo $_GET['fd'];}?>" readonly=""/>
						<label>To: </label><input type="text" class="form-control" name="to_date" id="to_date" value="<?php if(isset($_GET['td']) && $_GET['td']!=''){echo $_GET['td'];}?>" readonly=""/>
						<input type="button" onclick="return fetch_detail('1');" value="Show" class="btn btn-primary" />
						<input type="button" onclick="return clear_date('1');" value="Clear" class="btn btn-default" />	
					</div>
					<?php include(APPPATH.'views/Backend/dept_metrics/assignments.php');?>
				</div>
			<?php } ?>
			</div>
		
		</div>
	</div>
</section>


<script type="text/javascript">
function fetch_detail(tab_id){
	var from_date = $('#from_date').val();
	var str_from_date = Date.parse(from_date);	
	
	var to_date = $('#to_date').val();
	var str_to_date = Date.parse(to_date);

	//if(str_from_date!='' && str_to_date!=''){ 
	if(from_date!='' && to_date!=''){		
		if(tab_id=='1'){
			var url = '<?php echo base_url()?>admin/department_metrics';
			window.location= url+'?fd='+from_date+'&td='+to_date;
		}
		
		if(tab_id=='2'){
			var url = '<?php echo base_url()?>admin/department_metrics?tab_id=2';
			window.location= url+'&fd='+from_date+'&td='+to_date;
		}		
		
		if(tab_id=='3'){
			var url = '<?php echo base_url()?>admin/department_metrics?tab_id=3';
			window.location= url+'&fd='+from_date+'&td='+to_date;
		}		
	}	
}	

function clear_date(tab_id){
	if(tab_id=='1'){
		var url = '<?php echo base_url()?>admin/department_metrics';
		window.location= url;
	}	
	
	if(tab_id=='2'){
		var url = '<?php echo base_url()?>admin/department_metrics?tab_id=2';
		window.location= url;
	}	
	
	if(tab_id=='3'){
		var url = '<?php echo base_url()?>admin/department_metrics?tab_id=3';
		window.location= url;
	}	
}	
</script>