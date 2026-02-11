<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<?php $v = '1.0.4';?>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<!-- Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<!-- AdminLTE (for content/box styles) -->
	<link href="<?php echo base_url();?>assets/backend/dist/css/AdminLTE.min.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/dist/css/skins/_all-skins.min.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" />
	<!-- DataTables -->
	<link href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- Datepicker -->
	<link href="<?php echo base_url();?>assets/backend/css/datepicker.css" rel="stylesheet" type="text/css" /> 
	<!-- Custom -->
	<link href="<?php echo base_url();?>assets/backend/css/custom.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" /> 
	<!-- jQuery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script>
	<!-- Bootstrap 5 JS -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
	<!-- Feather Icons -->
	<script src="https://unpkg.com/feather-icons"></script>
	<!-- jQuery Validate -->
	<script src="<?php echo base_url();?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
	<!-- DataTables -->
	<script src="<?php echo base_url();?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body class="hold-transition skin-red sidebar-mini af-system-admin">
<div class="wrapper">

	<!-- ============================================================
	     Modern Header Navbar
	     ============================================================ -->
	<nav class="navbar navbar-expand-lg af-navbar">
		<div class="container-fluid">

			<!-- Brand / Logo -->
			<a class="navbar-brand" href="<?php echo base_url();?>/system-admin/profile">
				<?php echo $this->config->item('product_name');?>
			</a>

			<!-- Mobile Toggle -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#afMainNav"
				aria-controls="afMainNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<!-- Collapsible Content -->
			<div class="collapse navbar-collapse" id="afMainNav">

				<!-- ===== Main Navigation (from sidebar menu) ===== -->
				<?php
				/* These items live exclusively in the profile dropdown */
				$af_profile_only = array('access-menu','support-menu','ameelab-menu');
				?>
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<?php
					$menu_list = administrator_menu_list_helper($sessionDetailsArr['accType'], $sessionDetailsArr['menu_ids']);
					foreach ($menu_list as $category_data) {
						/* Skip items that belong only in the profile dropdown */
						if (in_array($category_data->active_class, $af_profile_only)) { continue; }

						$submenu_list = administrator_submenu_list_helper($category_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_ids']);
						$isActive = (isset($active_class) && $active_class == $category_data->active_class);

						if (count($submenu_list) > 0) { ?>
							<li class="nav-item dropdown <?php if($isActive) echo 'af-active'; ?>">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="<?php echo $category_data->icon; ?> af-nav-icon"></i>
									<?php echo $category_data->menu_name; ?>
								</a>
								<ul class="dropdown-menu">
									<?php foreach ($submenu_list as $subcategory_data) {
										if (isset($subcategory_data->submenu_active_class) && $subcategory_data->submenu_active_class != '') {
											$submenu_subcat_list = administrator_submenu_subcat_list_helper($subcategory_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_subcat_ids']);
											if (count($submenu_subcat_list) > 0) { ?>
												<li class="dropdown-submenu">
													<a class="dropdown-item" href="#">
														<?php echo $subcategory_data->submenu_name; ?>
													</a>
													<ul class="dropdown-menu">
														<?php foreach ($submenu_subcat_list as $submenu_subcat_data) { ?>
															<li>
																<a class="dropdown-item" href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $submenu_subcat_data->subcate_link); ?>">
																	<i class="<?php echo $submenu_subcat_data->icon; ?> af-sub-icon"></i>
																	<?php echo $submenu_subcat_data->subcate_name; ?>
																</a>
															</li>
														<?php } ?>
													</ul>
												</li>
											<?php }
										} else { ?>
											<li>
												<a class="dropdown-item" href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $subcategory_data->redirect_link); ?>">
													<?php echo $subcategory_data->submenu_name; ?>
												</a>
											</li>
									<?php }
									} ?>
								</ul>
							</li>
						<?php } else { ?>
							<li class="nav-item <?php if($isActive) echo 'af-active'; ?>">
								<a class="nav-link" href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $category_data->menu_link); ?>">
									<i class="<?php echo $category_data->icon; ?> af-nav-icon"></i>
									<?php echo $category_data->menu_name; ?>
								</a>
							</li>
						<?php }
					} ?>
				</ul>

				<!-- ===== Profile Dropdown (right side) ===== -->
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle af-profile-toggle" href="#" role="button"
						   data-bs-toggle="dropdown" aria-expanded="false">
							<?php if(isset($sessionDetailsArr['image']) && $sessionDetailsArr['image']!=''){ ?>
								<img src="<?php echo base_url();?>assets/upload/photo/<?php echo $sessionDetailsArr['image'];?>" alt="User" />
							<?php }else{ ?>
								<img src="<?php echo base_url();?>assets/backend/images/default-avatar.jpg" alt="User" />
							<?php } ?>
							<span class="af-user-name d-none d-lg-inline">
								<?php echo ucwords(strtolower($sessionDetailsArr['fullName'])); ?>
							</span>
						</a>
						<ul class="dropdown-menu dropdown-menu-end af-profile-dropdown">
							<!-- Profile header card -->
							<li>
								<div class="af-profile-header">
									<?php if(isset($sessionDetailsArr['image']) && $sessionDetailsArr['image']!=''){ ?>
										<img src="<?php echo base_url();?>assets/upload/photo/<?php echo $sessionDetailsArr['image'];?>" alt="User" />
									<?php }else{ ?>
										<img src="<?php echo base_url();?>assets/backend/images/default-avatar.jpg" alt="User" />
									<?php } ?>
									<div class="af-pname"><?php echo ucwords(strtolower($sessionDetailsArr['fullName'])); ?></div>
									<div class="af-prole">
										<?php
										if($sessionDetailsArr['accType']=='system-admin'){
											echo 'Project Manager';
										}else{
											echo ucwords(str_replace('-',' ',$sessionDetailsArr['accType']));
										}?>
									</div>
									<div class="af-plastlogin">
										Last Login:
										<?php
										if(isset($sessionDetailsArr['lastLogin']) && $sessionDetailsArr['lastLogin']>0 && $sessionDetailsArr['lastLogin']!=''){
											echo date('d M Y, h:i A',$sessionDetailsArr['lastLogin']);
										}else if(isset($session_details->current_login) && $session_details->current_login>0 && $session_details->current_login!=''){
											echo date('F d, Y h:i:s A',$session_details->current_login);
										}else{
											echo 'Not Yet';
										}?>
									</div>
								</div>
							</li>

							<!-- Profile link -->
							<li>
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>profile">
									<i class="fa fa-user"></i> Profile
								</a>
							</li>
							<li><hr class="dropdown-divider"></li>

							<!-- Quick links -->
							<li>
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>access">
									<i class="fa fa-key"></i> Guest Access
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>tickets">
									<i class="fa fa-envelope"></i> Contact Support
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>home/ameelab">
									<i class="fa fa-flask"></i> AMEE Lab
								</a>
							</li>
							<?php if (isset($_SESSION['AFSESS_accType']) && ($_SESSION['AFSESS_accType'] == 'system-admin' || $_SESSION['AFSESS_accType'] == 'project-manager')) { ?>
							<li>
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>settings/emails">
									<i class="fa fa-cog"></i> System Settings
								</a>
							</li>
							<?php } ?>
							<li><hr class="dropdown-divider"></li>
							<li>
								<a class="dropdown-item af-logout-link" href="<?php echo base_url().$this->config->item('system_directory_name');?>home/logout">
									<i class="fa fa-sign-out"></i> Logout
								</a>
							</li>
						</ul>
					</li>
				</ul>

			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	<!-- ============================================================
	     Content Wrapper
	     ============================================================ -->
	<div class="content-wrapper">
		<section class="content-header">
			<h1>
				<?php echo $pageTitle;
				if(isset($pageSubTitle) && $pageSubTitle!=''){?>
					<small class="pageSubTitle"><?php echo '&ndash; '.$pageSubTitle;?></small>
				<?php } ?>
			</h1>
			<?php if(isset($success_msg) && $success_msg!=''){?>
				<div class="alert alert-success"><img src="<?php echo base_url();?>/assets/backend/images/success.png" class="af-alert-icon" /> <?php echo $success_msg;?> </div>
			<?php } ?>
			<?php if(isset($error_msg) && $error_msg!=''){?>
				<div class="alert alert-danger"><img src="<?php echo base_url();?>/assets/backend/images/warning.png" class="af-alert-icon" /> <?php echo $error_msg;?> </div>
			<?php } ?>
		</section>
