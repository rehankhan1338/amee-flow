<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<?php $v = '1.0.3';?>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- <link href="<?php echo base_url();?>assets/backend/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
	<link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/dist/css/AdminLTE.min.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/dist/css/skins/_all-skins.min.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/css/datepicker.css" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo base_url();?>assets/backend/css/custom.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" /> 
	<!-- <script src="<?php echo base_url();?>assets/backend/js/jquery-1.11.3.min.js"></script>
	<script src="<?php echo base_url();?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/backend/bootstrap/js/bootstrap.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="<?php echo base_url();?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<a href="<?php echo base_url();?>" class="logo">
		<span class="logo-mini"><b>AF</b></span>
		<span class="logo-lg fmc"><?php echo $this->config->item('product_name');?></span>
		</a>
		<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="navbar-custom-menu nbs-five"> 
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					<?php if(isset($sessionDetailsArr['image']) && $sessionDetailsArr['image']!=''){ ?>>
						<img src="<?php echo base_url();?>assets/upload/photo/<?php echo $sessionDetailsArr['image'];?>" class="user-image" alt="User Image"  />
					<?php }else{ ?>
						<img alt="User Image" class="user-image" src="<?php echo base_url();?>assets/backend/images/default-avatar.jpg"   />
					<?php } ?>
					<span class="hidden-xs1 fmc fs16"><?php echo 'Hi, '.ucwords(strtolower($sessionDetailsArr['fullName'])); ?> </span>
				</a>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
						<li class="user-header">
							<?php if(isset($sessionDetailsArr['image']) && $sessionDetailsArr['image']!=''){ ?>>
								<img src="<?php echo base_url();?>assets/upload/photo/<?php echo $sessionDetailsArr['image'];?>" class="img-circle" alt="User Image" />
							<?php }else{ ?>
								<img src="<?php echo base_url();?>assets/backend/images/default-avatar.jpg" class="img-circle" alt="User Image" />
							<?php } ?>
							<div style="color: rgb(255, 255, 255); font-size: 14px; font-weight: 600; text-align: center; margin-top: 10px;">
								Last Login <br>  
								<?php if(isset($sessionDetailsArr['lastLogin']) && $sessionDetailsArr['lastLogin']>0 && $sessionDetailsArr['lastLogin']!=''){ echo date('d M Y, h:i A',$sessionDetailsArr['lastLogin']); }else if(isset($session_details->current_login) && $session_details->current_login>0 && $session_details->current_login!=''){ echo date('F d, Y h:i:s A',$session_details->current_login);}else{echo 'Not Yet';}?> 
							</div>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="<?php echo base_url().$this->config->item('system_directory_name');?>profile" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Profile</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url().$this->config->item('system_directory_name');?>home/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Logout</a>
							</div>
						</li>
					</ul>
				</li>            
			</ul>
		</div>
		</nav>
	</header>
	<aside class="main-sidebar">
		<section class="sidebar" style="height: auto;">
			<div class="user-panel">
				<div class="pull-left image">
					<?php if(isset($sessionDetailsArr['image']) && $sessionDetailsArr['image']!=''){ ?>
						<img src="<?php echo base_url();?>assets/upload/photo/<?php echo $sessionDetailsArr['image'];?>" class="img-circle" alt="User Image" />
					<?php }else{ ?>
						<img src="<?php echo base_url();?>assets/backend/images/default-avatar.jpg" class="img-circle" alt="User Image" />
					<?php } ?>
				</div>
				<div class="pull-left info">
					<p><?php echo ucwords(strtolower($sessionDetailsArr['fullName']));?> </p> 
					<div class="adminType"> &ndash; <?php 
					if($sessionDetailsArr['accType']=='system-admin'){
						echo 'Project Manager';
					}else{
						echo ucwords(str_replace('-',' ',$sessionDetailsArr['accType']));
					}?></div>
				</div>
			</div>	
			<ul class="sidebar-menu">
				<li class="header">MAIN NAVIGATION</li>
				<?php include(APPPATH.'views/system-admin/includes/menu.php'); ?>
			</ul>
		</section>
	</aside>
	<div class="content-wrapper" style="min-height: 647px;">
		<section class="content-header">
			<h1><?php echo $pageTitle; if(isset($pageSubTitle) && $pageSubTitle!=''){?><small class="pageSubTitle"><?php echo '&ndash; '.$pageSubTitle;?></small> <?php } ?></h1>
			<?php if(isset($success_msg) && $success_msg!=''){?>
				<div class="alert alert-success "><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/success.png" /> <?php echo $success_msg;?> </div> 
			<?php } ?>
			<?php if(isset($error_msg) && $error_msg!=''){?>
				<div class="alert alert-danger "><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/warning.png" /> <?php echo $error_msg;?> </div>
			<?php } ?>
		</section> 