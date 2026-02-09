<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Help Center : : AMEE</title>
<link href="<?php echo base_url();?>assets/frontend/images/favicon.png" rel="shortcut icon">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/help_custom.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/plugins/jquery-1.7.min.js"></script>


<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
</head>

<body class="withvernav">
<div class="bodywrapper">
	<div class="topheader">
		<div class="left">
			<h1 class="logo">Help <span>Center</span></h1>
			<span class="slogan">Small description about help</span>
			<br clear="all" />
		</div><!--left-->

		<div class="right">
			<a href="<?php echo base_url();?>department/create">
				<div class="userinfo"> 
					<span><i class="fa fa-arrow-left"></i> Back to Dashboard</span>
				</div><!--userinfo-->
			</a>
		</div><!--right-->
	</div><!--topheader-->
	

	<div class="header">      </div> 
	
	
	<div class="vernav2 iconmenu12">
		<ul>
		<?php if(count($tutorials_heading_details>0)){
			foreach($tutorials_heading_details as $heading){if(isset($heading->id)&& $heading->id!=''){$heading_id = $heading->id;}?>
		
				<li class="dropdown-toggle" onclick="slide_up_down('<?php echo $heading_id;?>');">
					<a href="#heading<?php echo $heading_id;?>" class="">
						<?php if(isset($heading->heading)&& $heading->heading!=''){echo $heading->heading;}?>
					</a>
				
					<?php $sub_heading_details = get_content_tutorials_sub_heading_details_by_heading_id($heading_id);
					
					if(count($sub_heading_details>0)){?>
						<span class="arrow"></span>
						<ul id="formsub12" class="dropdown_menu slidedown_<?php echo $heading_id;?>" style="display: none;">
							
							<?php foreach($sub_heading_details as $sub_heading){
								if(isset($sub_heading->id)&& $sub_heading->id!=''){$sub_heading_id = $sub_heading->id;}?>

								<li class="current12"><a href="#subheading<?php echo $sub_heading_id;?>">
									<?php if(isset($sub_heading->sub_heading)&& $sub_heading->sub_heading!=''){echo $sub_heading->sub_heading;}?>
								</a></li>
								
							<?php } ?>		
						</ul>						
					<?php } ?>					
				</li>
			
		<?php } }else{echo '';}?>
		</ul>


		
	<br /><br />
	</div><!--leftmenu-->

<style>
	.pagetitle{margin: 0 0 0 0!important;}	
	.pagedesc{margin: 0 0px!important;}	
	.pagesubheader{margin-left: 2%; margin-top: 30px;}	
	.pagesubheader .pagetitle{color: #fb9337;}
</style>

	<div class="centercontent">
	<?php if(count($tutorials_heading_details>0)){
		foreach($tutorials_heading_details as $heading){if(isset($heading->id)&& $heading->id!=''){$heading_id = $heading->id;}?>

			<div id="contentwrapper" class="contentwrapper">			
				<div class="pageheader">
					<h1 class="pagetitle"><?php if(isset($heading->heading)&& $heading->heading!=''){echo $heading->heading;}?></h1>
					<span class="pagedesc"><?php if(isset($heading->description)&& $heading->description!=''){echo $heading->description;}?></span>
				
					
					<?php $sub_heading_details = get_content_tutorials_sub_heading_details_by_heading_id($heading_id);
										
						if(count($sub_heading_details>0)){
						foreach($sub_heading_details as $sub_heading){
							if(isset($sub_heading->id)&& $sub_heading->id!=''){$sub_heading_id = $sub_heading->id;}?>
					
							<div class="pagesubheader">
								<h1 class="pagetitle"><?php if(isset($sub_heading->sub_heading)&& $sub_heading->sub_heading!=''){echo $sub_heading->sub_heading;}?></h1>
								<span class="pagedesc"><?php if(isset($sub_heading->description)&& $sub_heading->description!=''){echo $sub_heading->description;}?></span>
							</div>
							
					<?php } }?>				
				</div>							
			</div>
	
	<?php } } ?>
	</div>
	

</div><!--bodywrapper-->
</body>
</html>


<script type="text/javascript">
	function slide_up_down(id){
	   $(this).addClass("current");
	    setTimeout(function(){	
	    	$('.dropdown_menu').slideUp('fast'); 
	    	$('.slidedown_'+id).slideToggle()   		        
	    }, 300 );
	    
	}	
</script>	
    


