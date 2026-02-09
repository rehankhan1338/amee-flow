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
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
function call_heading_desc(heading_id,cnt_subheading,loop_id){
jQuery('.case').removeClass(' current ');
jQuery('#heading_title_'+heading_id).addClass(' current ');
jQuery('.sub_case').hide();
if(heading_id!='' && cnt_subheading>0){
	jQuery('#subheading_ul_'+heading_id).show();
} 
window.location='#heading'+heading_id;
}
</script>
</head>

<body class="withvernav" data-spy="scroll" >
<div class="bodywrapper" id="tutorial_page" >
 
	<div class="tutorial_info">
	<div class="vernav2 iconmenu12">
    <div class="tut_header">
		<a class="back_btn" href="<?php echo base_url();?>department/create">
			<i class="fa fa-angle-left"></i>
		</a>
		<h1 class="logo">Help <span>Center</span></h1>
   </div>
		<ul>	
		 
			<?php if(count($tutorials_heading_details)>0){
			 $hi=0; foreach($tutorials_heading_details as $heading){
			 	$sub_heading_details = get_content_tutorials_sub_heading_details_by_heading_id($heading->id);
 			?>
			
			<li class="case <?php if($hi==0){ echo 'current';}?>" id="heading_title_<?php echo $heading->id;?>"><a onclick="return call_heading_desc('<?php echo $heading->id;?>','<?php echo count($sub_heading_details);?>','<?php echo $hi;?>');" class="a_current"><?php if(isset($heading->heading) && $heading->heading!=''){echo ucwords($heading->heading);}?></a>
				<?php 
				if(count($sub_heading_details)>0){?>
				<span class="arrow"></span>
					<ul class="sub_case" id="subheading_ul_<?php echo $heading->id;?>" style="display:<?php if($hi==0){ echo 'block';}else{ echo 'none';}?>">
						<?php foreach($sub_heading_details as $sub_heading){?>
							<li><a href="#subheading<?php echo $sub_heading->id;?>"><?php if(isset($sub_heading->sub_heading)&& $sub_heading->sub_heading!=''){echo ucwords($sub_heading->sub_heading);}?></a></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</li>
			
			<?php $hi++; } } ?>
			
 		</li>
		</ul>

	<br /><br />
	</div>


<div class="centercontent ">
<?php 
if(count($tutorials_heading_details)>0){
$hi=0; foreach($tutorials_heading_details as $heading){
?>
	<div class="topic_box">
	<div class="pageheader" id="heading<?php echo $heading->id;?>">
		<h1 class="pagetitle"><?php if(isset($heading->heading)&& $heading->heading!=''){echo ucwords($heading->heading);}?></h1>
	</div>
	<div id="contentwrapper" class="contentwrapper">
		<div class="pagedesc"><?php if(isset($heading->description)&& $heading->description!=''){echo $heading->description;}?></div>
	</div>
	
	<?php $sub_heading_details = get_content_tutorials_sub_heading_details_by_heading_id($heading->id); if(count($sub_heading_details)>0){ ?>
	
	<?php foreach($sub_heading_details as $sub_heading){?>
	<div class="pageheader" id="subheading<?php echo $sub_heading->id;?>">
		<h1 class="pagetitle"><?php if(isset($sub_heading->sub_heading)&& $sub_heading->sub_heading!=''){echo ucwords($sub_heading->sub_heading);}?></h1>
	</div>
	<div id="contentwrapper" class="contentwrapper">
		<div class="pagedesc"><?php if(isset($sub_heading->description)&& $sub_heading->description!=''){echo $sub_heading->description;}?></div>
	</div>
  	<?php } } ?>
    </div>
<?php $hi++; } } ?>
</div>  
</div>
</div>
</body>
</html>
