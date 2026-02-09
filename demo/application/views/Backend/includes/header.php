<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title;?></title>
<!-- Tell the browser to be responsive to screen width -->
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css">
<link href="<?php echo base_url(); ?>assets/backend/css/datepicker.css" rel="stylesheet" type="text/css" />
<!--<link href="<?php echo base_url(); ?>assets/backend/css/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />-->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="<?php echo base_url(); ?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = '<?php echo base_url(); ?>assets/highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>-->
<!-- validation script -->
<script src="<?php echo base_url(); ?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
</head>
<body class="hold-transition skin-red layout-top-nav">
<!-- Site wrapper -->
<div class="wrapper">
<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="">
      <div class="">
        <div class="navbar-header"> <a href="<?php echo base_url();?>" class="navbar-brand">
          <div class="logo-lg" ><span><?php echo $this->config->item('project_name_page_first'); ?></span> <?php echo $this->config->item('project_name_page_second'); ?></div>
          <span class="tag"> Admin Panel</span></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse"> <i class="fa fa-bars"></i> </button>
        </div>
        
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if($session_details->image==''){ ?>
              <img alt="User Image" class="user-image" src="<?php echo base_url();?>assets/upload/profile_pic/dummy_user.jpg"   />
              <?php }else{ ?>
              <img src="<?php echo base_url();?>assets/upload/profile_pic/<?php echo $session_details->image;?>" class="user-image" alt="User Image" />
              <?php } ?>
              <span class="hidden-xs"><b style="font-size:15px; font-weight:600; color:#b9c2cf;font-family:'RobotoCondensed', Arial, Helvetica, sans-serif;">
              <?php  echo ucwords($session_details->first_name.' '.$session_details->last_name); ?>
              </b></span> </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <?php if($session_details->image==''){ ?>
                  <img src="<?php echo base_url();?>assets/upload/profile_pic/dummy_user.jpg" class="img-circle" alt="User Image" />
                  <?php }else{ ?>
                  <img src="<?php echo base_url();?>assets/upload/profile_pic/<?php echo $session_details->image;?>" class="img-circle" alt="User Image" />
                  <?php } ?>
                  <div style=" font-family:'RobotoCondensed', Arial, Helvetica, sans-serif; color:#b9c2cf; font-size: 14px; font-weight: 600; text-align: center; margin-top: 10px;"> Last Login <br>
                    <?php if($session_details->last_login==''){ echo 'Not Yet'; }else{ echo date('F d, Y H:i:s',$session_details->last_login); }?>
                  </div>
                </li>
                <li class="user-footer">
                  <div class="pull-left"> <a href="<?php echo base_url();?>admin/profile" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Profile</a> </div>
                  <div class="pull-right"> <a href="<?php echo base_url();?>admin/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a> </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
         
        
      </div>
      <div style="clear:both;"></div>
      <div class="main_menu">
        <div class="collapse navbar-collapse main_menu" id="navbar-collapse">
          <ul class="nav navbar-nav headermenu">
            <?php include(APPPATH.'views/Backend/includes/menu.php'); ?>
            
            <!--<li class="active"><a href="#"><i class="fa fa-link"></i> Clients</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i> System Setting <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Sub menu1</a></li>
                <li class="dropdown-submenu"><a href="#">Sub menu2</a>
 					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Sub sub menu1</a></li>
						<li><a href="#">Sub sub menu2</a></li>
						<li class="divider"></li>
					</ul>
 			  </li>
              </ul>
            </li>-->
            
          </ul>
          
          <!--<form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input class="form-control" id="navbar-search-input" placeholder="Search" type="text">
            </div>
          </form>--> 
          
        </div>
      </div>
    </div>
    
  </nav>
</header>
 
<div style="clear:both;"></div>
<div class="content-wrapper" style="min-height: 647px;">
<div class="">
<div class="">
<section class="content-header">
  <h1><?php echo $page_title; if(isset($census_add_icon) && $census_add_icon==1){?> <a href="<?php echo base_url();?>admin/census_data/add"> <i style="font-size: 38px;    vertical-align: middle;color: #485b79;" class="fa fa-plus-circle"></i> </a><?php } ?></h1>
  <?php if(isset($page_sub_title) && $page_sub_title!=''){ echo $page_sub_title.'<hr />';}?>
  <?php if(isset($success_msg) && $success_msg!=''){?>
  <div class="alert alert-success "><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/success.png" /> <?php echo $success_msg;?> </div>
  <?php } ?>
  <?php if(isset($error_msg) && $error_msg!=''){?>
  <div class="alert alert-danger "><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/warning.png" /> <?php echo $error_msg;?> </div>
  <?php } ?>
</section>