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
	<!-- Bootstrap Toggle -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<style>
		/* ============================================================
		   AMEE Flow – Modern Layout (No Sidebar)
		   ============================================================ */

		/* ---------- Reset AdminLTE sidebar layout ---------- */
		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
			background: #f4f6f9 !important;
			overflow-x: hidden;
		}
		.main-header,
		.main-sidebar {
			display: none !important;
		}
		.content-wrapper,
		.main-footer {
			margin-left: 0 !important;
		}
		.content-wrapper {
			min-height: calc(100vh - 140px) !important;
			background: #f4f6f9 !important;
			padding-top: 8px;
		}

		/* ---------- Header / Navbar ---------- */
		.af-navbar {
			background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
			padding: 0 1.5rem;
			min-height: 58px;
			box-shadow: 0 2px 18px rgba(0,0,0,0.13);
			position: sticky;
			top: 0;
			z-index: 1050;
			border: none;
		}
		.af-navbar .navbar-brand {
			color: #fff !important;
			font-weight: 700;
			font-size: 1.3rem;
			letter-spacing: .4px;
			padding: .45rem 0;
			display: flex;
			align-items: center;
			gap: 8px;
		}
		.af-navbar .navbar-brand:hover { color: #f0f0f0 !important; }
		.af-navbar .navbar-brand .af-brand-icon {
			width: 32px;
			height: 32px;
			background: rgba(255,255,255,0.2);
			border-radius: 8px;
			display: flex;
			align-items: center;
			justify-content: center;
			font-size: 1rem;
		}

		/* Toggler */
		.af-navbar .navbar-toggler {
			border: 2px solid rgba(255,255,255,0.45);
			padding: 4px 10px;
			border-radius: 8px;
		}
		.af-navbar .navbar-toggler:focus { box-shadow: 0 0 0 3px rgba(255,255,255,0.25); }
		.af-navbar .navbar-toggler-icon {
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
		}

		/* Nav links */
		.af-navbar .nav-link {
			color: rgba(255,255,255,0.88) !important;
			font-size: .875rem;
			font-weight: 500;
			padding: .55rem .85rem !important;
			border-radius: 8px;
			transition: all .2s ease;
			white-space: nowrap;
		}
		.af-navbar .nav-link:hover,
		.af-navbar .nav-link:focus {
			color: #fff !important;
			background: rgba(255,255,255,0.15);
		}
		.af-navbar .nav-item.af-active > .nav-link {
			color: #fff !important;
			background: rgba(255,255,255,0.22);
		}

		/* Dropdown menus */
		.af-navbar .dropdown-menu {
			border: none;
			border-radius: 12px;
			box-shadow: 0 10px 35px rgba(0,0,0,0.12);
			padding: .45rem 0;
			margin-top: .35rem;
			min-width: 220px;
			animation: afFadeIn .2s ease;
		}
		@keyframes afFadeIn {
			from { opacity: 0; transform: translateY(-6px); }
			to   { opacity: 1; transform: translateY(0); }
		}
		.af-navbar .dropdown-menu .dropdown-item {
			padding: .5rem 1.15rem;
			font-size: .855rem;
			color: #444;
			transition: all .15s ease;
		}
		.af-navbar .dropdown-menu .dropdown-item:hover,
		.af-navbar .dropdown-menu .dropdown-item:focus {
			background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
			color: #fff;
		}
		.af-navbar .dropdown-menu .dropdown-item i {
			width: 20px;
			text-align: center;
			margin-right: 8px;
			font-size: .82rem;
		}
		.af-navbar .dropdown-divider {
			margin: .3rem 0;
			border-top-color: #eaeaea;
		}

		/* Nested sub-dropdown */
		.af-navbar .dropdown-submenu { position: relative; }
		.af-navbar .dropdown-submenu > .dropdown-menu {
			top: 0; left: 100%;
			margin-top: -.45rem; margin-left: 0;
			border-radius: 10px;
		}
		.af-navbar .dropdown-submenu > .dropdown-item::after {
			content: "\f105";
			font-family: FontAwesome;
			float: right;
			margin-left: 10px;
			opacity: .6;
		}

		/* ---------- Profile dropdown ---------- */
		.af-profile-toggle {
			display: flex;
			align-items: center;
			gap: 10px;
			cursor: pointer;
		}
		.af-profile-toggle img {
			width: 34px; height: 34px;
			border-radius: 50%;
			object-fit: cover;
			border: 2px solid rgba(255,255,255,0.5);
		}
		.af-profile-toggle .af-user-name {
			color: #fff;
			font-weight: 500;
			font-size: .88rem;
		}
		.af-profile-dropdown { min-width: 260px !important; border-radius: 14px !important; overflow: hidden; }

		.af-profile-header {
			text-align: center;
			padding: 1.3rem 1rem 1rem;
			background: linear-gradient(45deg, #485b79 25%, #e18125 100%);
		}
		.af-profile-header img {
			width: 58px; height: 58px;
			border-radius: 50%;
			object-fit: cover;
			border: 3px solid rgba(255,255,255,0.55);
			margin-bottom: 8px;
		}
		.af-profile-header .af-pname {
			color: #fff; font-weight: 600; font-size: .95rem; margin-bottom: 2px;
		}
		.af-profile-header .af-prole {
			color: rgba(255,255,255,0.78); font-size: .76rem;
		}
		.af-profile-header .af-plastlogin {
			color: rgba(255,255,255,0.65); font-size: .7rem; margin-top: 5px;
		}

		/* ---------- Content area ---------- */
		.content-header {
			padding: 15px 15px 0 15px;
		}
		.content-header > h1 {
			font-size: 1.45rem;
			font-weight: 600;
			color: #485b79;
		}
		.content-header > h1 small,
		.content-header > h1 .pageSubTitle {
			font-size: .82rem;
			color: #888;
			font-weight: 400;
		}

		/* Box modern look */
		.box {
			border-radius: 12px !important;
			border: none !important;
			box-shadow: 0 2px 14px rgba(0,0,0,0.055) !important;
			overflow: hidden;
		}
		.box-header { border-bottom: 1px solid #f0f0f0 !important; }

		/* Alert */
		.alert { border-radius: 10px; border: none; }

		/* ---------- Footer ---------- */
		.af-footer {
			background: #485b79;
			color: rgba(255,255,255,0.85);
			padding: 16px 28px;
			font-size: .84rem;
		}
		.af-footer a {
			color: rgba(255,255,255,0.9);
			text-decoration: none;
			transition: color .2s;
		}
		.af-footer a:hover { color: #e18125; }
		.af-footer .af-footer-tagline {
			color: rgba(255,255,255,0.55);
			font-style: italic;
			font-size: .8rem;
		}

		/* ---------- Responsive ---------- */
		@media (max-width: 991.98px) {
			.af-navbar { padding: .5rem 1rem; }
			.af-navbar .navbar-collapse {
				background: rgba(55,70,95,0.97);
				border-radius: 12px;
				padding: .8rem 1rem;
				margin-top: .5rem;
				box-shadow: 0 10px 30px rgba(0,0,0,0.25);
				max-height: 75vh;
				overflow-y: auto;
			}
			.af-navbar .dropdown-menu {
				background: rgba(255,255,255,0.08);
				box-shadow: none;
				border-radius: 8px;
			}
			.af-navbar .dropdown-menu .dropdown-item {
				color: rgba(255,255,255,0.88);
			}
			.af-navbar .dropdown-menu .dropdown-item:hover {
				background: rgba(255,255,255,0.13);
			}
			.af-navbar .dropdown-submenu > .dropdown-menu {
				left: 0;
				position: static;
				margin-left: 1rem;
			}
			.af-profile-dropdown {
				position: static !important;
				transform: none !important;
			}
			.af-profile-header {
				border-radius: 10px 10px 0 0;
			}
		}

		@media (max-width: 576px) {
			.content-header > h1 { font-size: 1.15rem; }
			.af-footer {
				text-align: center;
				padding: 14px 15px;
			}
			.af-footer .d-flex { flex-direction: column; gap: 4px; }
		}

		/* ---------- Scrollbar ---------- */
		::-webkit-scrollbar { width: 6px; }
		::-webkit-scrollbar-track { background: #f1f1f1; }
		::-webkit-scrollbar-thumb { background: #485b79; border-radius: 3px; }
		::-webkit-scrollbar-thumb:hover { background: #3a4a63; }
	</style>
</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

	<!-- ============================================================
	     Modern Header Navbar
	     ============================================================ -->
	<nav class="navbar navbar-expand-lg af-navbar">
		<div class="container-fluid">

			<!-- Brand / Logo -->
			<a class="navbar-brand" href="<?php echo base_url();?>">
				<span class="af-brand-icon"><i class="fa fa-cube"></i></span>
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
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<?php
					$menu_list = administrator_menu_list_helper($sessionDetailsArr['accType'], $sessionDetailsArr['menu_ids']);
					foreach ($menu_list as $category_data) {
						$submenu_list = administrator_submenu_list_helper($category_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_ids']);
						$isActive = (isset($active_class) && $active_class == $category_data->active_class);

						if (count($submenu_list) > 0) { ?>
							<li class="nav-item dropdown <?php if($isActive) echo 'af-active'; ?>">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="<?php echo $category_data->icon; ?>" style="margin-right:4px;"></i>
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
																	<i class="<?php echo $submenu_subcat_data->icon; ?>" style="width:10px;"></i>
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
									<i class="<?php echo $category_data->icon; ?>" style="margin-right:4px;"></i>
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
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>home">
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
								<a class="dropdown-item" href="<?php echo base_url().$this->config->item('system_directory_name');?>home/logout" style="color:#dc3545;">
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
				<div class="alert alert-success"><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/success.png" /> <?php echo $success_msg;?> </div>
			<?php } ?>
			<?php if(isset($error_msg) && $error_msg!=''){?>
				<div class="alert alert-danger"><img style="margin-top:-3px;" src="<?php echo base_url();?>/assets/backend/images/warning.png" /> <?php echo $error_msg;?> </div>
			<?php } ?>
		</section>
