<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<?php $v = '1.0.4';?>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YcnS/1WR6zNicjFg3bGKwi0Liq1bGNMRhcd9" crossorigin="anonymous">
	<link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/css/datepicker.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>assets/backend/css/custom.css?v=<?php echo $v;?>" rel="stylesheet" type="text/css" />
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

<style>
/* ========== AMEE Flow Modern System Admin Theme ========== */
:root {
	--af-primary: #485b79;
	--af-accent: #e18125;
	--af-gradient: linear-gradient(45deg, #485b79 25%, #e18125 100%);
	--af-dark: #3a4a63;
	--af-light: #f4f6f9;
	--af-white: #ffffff;
	--af-text: #333333;
	--af-text-muted: #7a8a9e;
	--af-border: #e0e4ea;
	--af-shadow: 0 2px 12px rgba(72, 91, 121, 0.10);
	--af-shadow-lg: 0 8px 32px rgba(72, 91, 121, 0.16);
	--af-radius: 12px;
	--af-radius-sm: 8px;
	--af-radius-xs: 6px;
	--af-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

* { box-sizing: border-box; }

body {
	font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Helvetica Neue', Arial, sans-serif;
	background: var(--af-light) !important;
	color: var(--af-text);
	margin: 0;
	padding: 0;
	overflow-x: hidden;
}

/* ===== Remove AdminLTE defaults ===== */
.wrapper, .content-wrapper, .main-sidebar, .main-header, .main-footer,
.sidebar-mini .content-wrapper, .sidebar-mini .main-footer {
	all: unset !important;
	display: block !important;
}
.main-sidebar { display: none !important; }

/* ===== Top Navigation Bar ===== */
.af-navbar {
	background: var(--af-gradient);
	padding: 0 24px;
	box-shadow: var(--af-shadow-lg);
	position: sticky;
	top: 0;
	z-index: 1050;
	min-height: 64px;
}
.af-navbar .navbar-brand {
	font-size: 1.35rem;
	font-weight: 700;
	color: var(--af-white) !important;
	letter-spacing: 0.5px;
	padding: 12px 0;
	display: flex;
	align-items: center;
	gap: 10px;
	text-decoration: none;
}
.af-navbar .navbar-brand .brand-icon {
	width: 36px;
	height: 36px;
	background: rgba(255,255,255,0.18);
	border-radius: var(--af-radius-sm);
	display: flex;
	align-items: center;
	justify-content: center;
	font-weight: 800;
	font-size: 0.85rem;
	color: var(--af-white);
	backdrop-filter: blur(4px);
}
.af-navbar .navbar-toggler {
	border: 2px solid rgba(255,255,255,0.3);
	border-radius: var(--af-radius-xs);
	padding: 6px 10px;
}
.af-navbar .navbar-toggler:focus {
	box-shadow: 0 0 0 3px rgba(255,255,255,0.2);
}
.af-navbar .navbar-toggler-icon {
	background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
}

/* ===== Nav Links ===== */
.af-navbar .navbar-nav .nav-link {
	color: rgba(255,255,255,0.85) !important;
	font-weight: 500;
	font-size: 0.9rem;
	padding: 8px 16px !important;
	border-radius: var(--af-radius-xs);
	transition: var(--af-transition);
	white-space: nowrap;
}
.af-navbar .navbar-nav .nav-link:hover,
.af-navbar .navbar-nav .nav-link:focus {
	color: var(--af-white) !important;
	background: rgba(255,255,255,0.12);
}
.af-navbar .navbar-nav .nav-item.active > .nav-link,
.af-navbar .navbar-nav .nav-link.active-link {
	color: var(--af-white) !important;
	background: rgba(255,255,255,0.18);
}

/* Nav dropdown styling */
.af-navbar .navbar-nav .dropdown-menu {
	background: var(--af-white);
	border: 1px solid var(--af-border);
	border-radius: var(--af-radius-sm);
	box-shadow: var(--af-shadow-lg);
	padding: 8px 0;
	margin-top: 4px;
	min-width: 220px;
	animation: af-fadeDown 0.2s ease;
}
@keyframes af-fadeDown {
	from { opacity: 0; transform: translateY(-6px); }
	to { opacity: 1; transform: translateY(0); }
}
.af-navbar .dropdown-menu .dropdown-item {
	padding: 10px 20px;
	font-size: 0.875rem;
	font-weight: 500;
	color: var(--af-text);
	border-radius: 0;
	transition: var(--af-transition);
}
.af-navbar .dropdown-menu .dropdown-item:hover {
	background: rgba(72, 91, 121, 0.07);
	color: var(--af-primary);
}
.af-navbar .dropdown-menu .dropdown-item i {
	width: 20px;
	text-align: center;
	margin-right: 10px;
	color: var(--af-text-muted);
}
.af-navbar .dropdown-menu .dropdown-item:hover i {
	color: var(--af-accent);
}
.af-navbar .dropdown-menu .dropdown-divider {
	border-color: var(--af-border);
	margin: 6px 0;
}

/* ===== Nested Submenu Dropdown ===== */
.af-navbar .dropdown-submenu {
	position: relative;
}
.af-navbar .dropdown-submenu > .dropdown-menu {
	top: -8px;
	left: 100%;
	margin-top: 0;
	margin-left: 0;
}
.af-navbar .dropdown-submenu > .dropdown-item::after {
	content: "\f105";
	font-family: FontAwesome;
	float: right;
	margin-left: 10px;
	color: var(--af-text-muted);
}

/* ===== Profile Dropdown ===== */
.af-profile-trigger {
	display: flex;
	align-items: center;
	gap: 10px;
	padding: 6px 12px !important;
	border-radius: 50px !important;
	background: rgba(255,255,255,0.10) !important;
	border: 1px solid rgba(255,255,255,0.15);
	transition: var(--af-transition);
	cursor: pointer;
	text-decoration: none;
}
.af-profile-trigger:hover {
	background: rgba(255,255,255,0.18) !important;
	border-color: rgba(255,255,255,0.25);
}
.af-profile-avatar {
	width: 34px;
	height: 34px;
	border-radius: 50%;
	object-fit: cover;
	border: 2px solid rgba(255,255,255,0.3);
}
.af-profile-name {
	color: var(--af-white);
	font-weight: 600;
	font-size: 0.875rem;
	max-width: 140px;
	overflow: hidden;
	text-overflow: ellipsis;
	white-space: nowrap;
}
.af-profile-caret {
	color: rgba(255,255,255,0.6);
	font-size: 0.7rem;
	transition: var(--af-transition);
}
.af-profile-trigger[aria-expanded="true"] .af-profile-caret {
	transform: rotate(180deg);
}

/* Profile Dropdown Menu */
.af-profile-dropdown {
	min-width: 260px;
	border-radius: var(--af-radius) !important;
	padding: 0 !important;
	overflow: hidden;
}
.af-profile-dropdown .af-profile-header {
	background: var(--af-gradient);
	padding: 20px;
	text-align: center;
}
.af-profile-dropdown .af-profile-header img {
	width: 56px;
	height: 56px;
	border-radius: 50%;
	object-fit: cover;
	border: 3px solid rgba(255,255,255,0.3);
	margin-bottom: 10px;
}
.af-profile-dropdown .af-profile-header .af-profile-fullname {
	color: var(--af-white);
	font-weight: 600;
	font-size: 0.95rem;
	margin: 0;
}
.af-profile-dropdown .af-profile-header .af-profile-role {
	color: rgba(255,255,255,0.75);
	font-size: 0.8rem;
	margin: 4px 0 0;
}
.af-profile-dropdown .af-profile-header .af-last-login {
	color: rgba(255,255,255,0.6);
	font-size: 0.72rem;
	margin: 6px 0 0;
}
.af-profile-dropdown .af-profile-body {
	padding: 8px 0;
}
.af-profile-dropdown .af-profile-body .dropdown-item {
	padding: 11px 22px;
	font-size: 0.875rem;
	font-weight: 500;
	color: var(--af-text);
	transition: var(--af-transition);
}
.af-profile-dropdown .af-profile-body .dropdown-item:hover {
	background: rgba(72, 91, 121, 0.06);
	color: var(--af-primary);
}
.af-profile-dropdown .af-profile-body .dropdown-item i {
	width: 22px;
	text-align: center;
	margin-right: 12px;
	font-size: 0.95rem;
	color: var(--af-text-muted);
}
.af-profile-dropdown .af-profile-body .dropdown-item:hover i {
	color: var(--af-accent);
}
.af-profile-dropdown .af-profile-body .dropdown-item.af-logout-item {
	color: #dc3545;
}
.af-profile-dropdown .af-profile-body .dropdown-item.af-logout-item i {
	color: #dc3545;
}
.af-profile-dropdown .af-profile-body .dropdown-item.af-logout-item:hover {
	background: rgba(220, 53, 69, 0.06);
}

/* ===== Page Content Wrapper ===== */
.af-page-wrapper {
	min-height: calc(100vh - 64px - 56px);
	padding: 0;
}

/* ===== Page Header / Breadcrumb ===== */
.af-page-header {
	background: var(--af-white);
	padding: 18px 30px;
	border-bottom: 1px solid var(--af-border);
	margin-bottom: 0;
}
.af-page-header h1 {
	font-size: 1.35rem;
	font-weight: 700;
	color: var(--af-primary);
	margin: 0;
	line-height: 1.4;
}
.af-page-header h1 small, .af-page-header h1 .pageSubTitle {
	font-size: 0.8rem;
	font-weight: 500;
	color: var(--af-text-muted);
	margin-left: 8px;
}

/* ===== Content Area ===== */
.content-wrapper {
	min-height: calc(100vh - 130px) !important;
	background: var(--af-light) !important;
	margin-left: 0 !important;
	padding: 0 !important;
}
.content-header {
	background: var(--af-white) !important;
	padding: 18px 30px !important;
	border-bottom: 1px solid var(--af-border) !important;
	margin: 0 !important;
}
.content-header h1 {
	font-size: 1.35rem !important;
	font-weight: 700 !important;
	color: var(--af-primary) !important;
	margin: 0 0 4px 0 !important;
}
.content-header h1 small, .content-header h1 .pageSubTitle {
	font-size: 0.82rem !important;
	font-weight: 500 !important;
	color: var(--af-text-muted) !important;
}
section.content {
	padding: 24px 30px !important;
}

/* ===== Alerts ===== */
.content-header .alert,
.af-page-header .alert {
	margin: 12px 0 0;
	border-radius: var(--af-radius-sm);
	font-size: 0.875rem;
	padding: 10px 16px;
	border: none;
}
.content-header .alert-success {
	background: #e8f5e9 !important;
	color: #2e7d32 !important;
}
.content-header .alert-danger {
	background: #fce4ec !important;
	color: #c62828 !important;
}

/* ===== Cards / Box ===== */
.box {
	background: var(--af-white);
	border-radius: var(--af-radius) !important;
	border: 1px solid var(--af-border) !important;
	box-shadow: var(--af-shadow) !important;
	margin-bottom: 20px;
	overflow: hidden;
}
.box-header {
	padding: 18px 24px !important;
	border-bottom: 1px solid var(--af-border) !important;
	background: var(--af-white) !important;
}
.box-header .box-title {
	font-size: 1.05rem !important;
	font-weight: 700 !important;
	color: var(--af-primary) !important;
}
.box-body {
	padding: 20px 24px !important;
}

/* ===== Tables ===== */
.table {
	border-collapse: separate;
	border-spacing: 0;
}
.table thead th {
	background: var(--af-primary) !important;
	color: var(--af-white) !important;
	font-weight: 600;
	font-size: 0.82rem;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	padding: 12px 16px !important;
	border: none !important;
}
.table thead th:first-child {
	border-radius: var(--af-radius-sm) 0 0 0;
}
.table thead th:last-child {
	border-radius: 0 var(--af-radius-sm) 0 0;
}
.table tbody td {
	padding: 12px 16px !important;
	vertical-align: middle !important;
	border-bottom: 1px solid var(--af-border) !important;
	border-top: none !important;
	font-size: 0.875rem;
}
.table-striped tbody tr:nth-of-type(odd) {
	background-color: rgba(72, 91, 121, 0.025) !important;
}
.table tbody tr:hover {
	background-color: rgba(72, 91, 121, 0.05) !important;
}

/* ===== Buttons ===== */
.btn {
	border-radius: var(--af-radius-xs) !important;
	font-weight: 600 !important;
	font-size: 0.85rem !important;
	padding: 8px 18px !important;
	transition: var(--af-transition) !important;
	border: none !important;
}
.btn-primary {
	background: var(--af-primary) !important;
	color: var(--af-white) !important;
}
.btn-primary:hover {
	background: var(--af-dark) !important;
	box-shadow: 0 4px 12px rgba(72, 91, 121, 0.3) !important;
}
.btn-danger {
	background: #dc3545 !important;
}
.btn-danger:hover {
	background: #c82333 !important;
	box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3) !important;
}
.btn-warning {
	background: var(--af-accent) !important;
	color: var(--af-white) !important;
}
.btn-warning:hover {
	background: #c97220 !important;
	box-shadow: 0 4px 12px rgba(225, 129, 37, 0.3) !important;
}
.btn-sm {
	padding: 5px 12px !important;
	font-size: 0.8rem !important;
}

/* ===== Forms ===== */
.form-control {
	border-radius: var(--af-radius-xs) !important;
	border: 1px solid var(--af-border) !important;
	padding: 8px 14px !important;
	font-size: 0.875rem !important;
	transition: var(--af-transition) !important;
}
.form-control:focus {
	border-color: var(--af-primary) !important;
	box-shadow: 0 0 0 3px rgba(72, 91, 121, 0.12) !important;
}

/* ===== Modals ===== */
.modal-content {
	border-radius: var(--af-radius) !important;
	border: none !important;
	box-shadow: var(--af-shadow-lg) !important;
	overflow: hidden;
}
.modal-header {
	background: var(--af-gradient);
	color: var(--af-white);
	padding: 16px 24px;
	border-bottom: none !important;
}
.modal-header .modal-title, .modal-header .close, .modal-header .btn-close {
	color: var(--af-white) !important;
}
.modal-body {
	padding: 24px !important;
}
.modal-footer {
	padding: 16px 24px !important;
	border-top: 1px solid var(--af-border) !important;
}

/* ===== Footer ===== */
.main-footer {
	background: var(--af-primary) !important;
	color: rgba(255,255,255,0.75) !important;
	text-align: center !important;
	padding: 16px 30px !important;
	font-size: 0.82rem !important;
	margin-left: 0 !important;
	border: none !important;
	position: relative;
}
.main-footer i {
	font-style: italic;
	color: var(--af-accent);
}

/* ===== DataTables overrides ===== */
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
	border-radius: var(--af-radius-xs) !important;
	border: 1px solid var(--af-border) !important;
	padding: 5px 10px !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
	border-radius: var(--af-radius-xs) !important;
	margin: 0 2px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
	background: var(--af-primary) !important;
	color: var(--af-white) !important;
	border-color: var(--af-primary) !important;
}
.dataTables_wrapper .dataTables_info {
	font-size: 0.82rem;
	color: var(--af-text-muted);
}

/* ===== Scrollbar ===== */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-track { background: var(--af-light); }
::-webkit-scrollbar-thumb { background: #c1c9d6; border-radius: 4px; }
::-webkit-scrollbar-thumb:hover { background: var(--af-primary); }

/* ===== Toastr overrides ===== */
.toast-success { background-color: #485b79 !important; }
.toast-info { background-color: #5a7099 !important; }

/* ===== Toggle switch ===== */
.toggle.btn { border-radius: 20px !important; }
.toggle-handle { border-radius: 50% !important; }

/* ===== Pro Name Link ===== */
a.pro_name {
	color: var(--af-primary) !important;
	font-weight: 600;
	text-decoration: none;
	transition: var(--af-transition);
}
a.pro_name:hover {
	color: var(--af-accent) !important;
	text-decoration: underline;
}

/* ===== Responsive ===== */
@media (max-width: 991.98px) {
	.af-navbar { padding: 0 16px; }
	.af-navbar .navbar-collapse {
		background: var(--af-dark);
		border-radius: var(--af-radius-sm);
		padding: 12px;
		margin-top: 8px;
		max-height: 80vh;
		overflow-y: auto;
		box-shadow: var(--af-shadow-lg);
	}
	.af-navbar .navbar-nav .nav-link {
		padding: 10px 14px !important;
		border-radius: var(--af-radius-xs);
	}
	.af-navbar .navbar-nav .dropdown-menu {
		background: rgba(255,255,255,0.06);
		border: none;
		box-shadow: none;
		padding-left: 14px;
	}
	.af-navbar .dropdown-menu .dropdown-item {
		color: rgba(255,255,255,0.85);
		font-size: 0.85rem;
	}
	.af-navbar .dropdown-menu .dropdown-item:hover {
		background: rgba(255,255,255,0.1);
		color: var(--af-white);
	}
	.af-navbar .dropdown-menu .dropdown-item i {
		color: rgba(255,255,255,0.6);
	}
	.af-navbar .dropdown-submenu > .dropdown-menu {
		position: static !important;
		left: 0;
		margin-left: 10px;
	}
	.af-profile-dropdown {
		background: var(--af-white) !important;
	}
	.af-profile-dropdown .af-profile-body .dropdown-item {
		color: var(--af-text) !important;
	}
	.af-profile-name { display: none; }
	section.content { padding: 16px !important; }
	.content-header { padding: 14px 16px !important; }
}

@media (max-width: 575.98px) {
	.af-navbar .navbar-brand { font-size: 1.1rem; }
	.content-header h1 { font-size: 1.1rem !important; }
	.box-header, .box-body { padding: 14px 16px !important; }
}
</style>

</head>
<body>

<?php 
	$sysDir = $this->config->item('system_directory_name');
	$baseUrl = base_url();
	$userImage = (isset($sessionDetailsArr['image']) && $sessionDetailsArr['image'] != '') 
		? $baseUrl.'assets/upload/photo/'.$sessionDetailsArr['image'] 
		: $baseUrl.'assets/backend/images/default-avatar.jpg';
	$userName = ucwords(strtolower($sessionDetailsArr['fullName']));
	$accType = $sessionDetailsArr['accType'];
	$accTypeLabel = ($accType == 'system-admin') ? 'Project Manager' : ucwords(str_replace('-',' ',$accType));
?>

<!-- ===== Modern Top Navbar ===== -->
<nav class="navbar navbar-expand-lg af-navbar">
	<div class="container-fluid">
		<!-- Brand -->
		<a class="navbar-brand" href="<?php echo $baseUrl.$sysDir; ?>">
			<span class="brand-icon">AF</span>
			<?php echo $this->config->item('product_name'); ?>
		</a>

		<!-- Mobile Toggle -->
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#afMainNav" aria-controls="afMainNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Nav Content -->
		<div class="collapse navbar-collapse" id="afMainNav">
			<!-- Main Navigation Links (from dynamic menu) -->
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<?php 
				$menu_list = administrator_menu_list_helper($sessionDetailsArr['accType'], $sessionDetailsArr['menu_ids']);
				foreach ($menu_list as $category_data) {
					$submenu_list = administrator_submenu_list_helper($category_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_ids']);
					$isActive = (isset($active_class) && $active_class == $category_data->active_class) ? 'active' : '';
					
					if (count($submenu_list) > 0) { ?>
						<li class="nav-item dropdown <?php echo $isActive; ?>">
							<a class="nav-link dropdown-toggle <?php if($isActive) echo 'active-link'; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="<?php echo $category_data->icon; ?>" style="margin-right:5px;"></i> <?php echo $category_data->menu_name; ?>
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
														<li><a class="dropdown-item" href="<?php echo $baseUrl . str_replace('{admin}', $sysDir, $submenu_subcat_data->subcate_link); ?>">
															<i class="<?php echo $submenu_subcat_data->icon; ?>" style="width:16px;"></i> <?php echo $submenu_subcat_data->subcate_name; ?>
														</a></li>
													<?php } ?>
												</ul>
											</li>
										<?php }
									} else { ?>
										<li><a class="dropdown-item" href="<?php echo $baseUrl . str_replace('{admin}', $sysDir, $subcategory_data->redirect_link); ?>">
											<i class="fa fa-circle-o" style="font-size:0.6rem;margin-right:8px;"></i> <?php echo $subcategory_data->submenu_name; ?>
										</a></li>
									<?php }
								} ?>
							</ul>
						</li>
					<?php } else { ?>
						<li class="nav-item <?php echo $isActive; ?>">
							<a class="nav-link <?php if($isActive) echo 'active-link'; ?>" href="<?php echo $baseUrl . str_replace('{admin}', $sysDir, $category_data->menu_link); ?>">
								<i class="<?php echo $category_data->icon; ?>" style="margin-right:5px;"></i> <?php echo $category_data->menu_name; ?>
							</a>
						</li>
					<?php }
				} ?>
			</ul>

			<!-- Profile Dropdown (Right Side) -->
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="af-profile-trigger dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="afProfileDropdown">
						<img src="<?php echo $userImage; ?>" alt="<?php echo $userName; ?>" class="af-profile-avatar" />
						<span class="af-profile-name"><?php echo $userName; ?></span>
						<i class="fa fa-chevron-down af-profile-caret"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-end af-profile-dropdown" aria-labelledby="afProfileDropdown">
						<!-- Profile Header -->
						<li class="af-profile-header">
							<img src="<?php echo $userImage; ?>" alt="<?php echo $userName; ?>" />
							<p class="af-profile-fullname"><?php echo $userName; ?></p>
							<p class="af-profile-role"><?php echo $accTypeLabel; ?></p>
							<p class="af-last-login">
								Last Login: <?php 
								if(isset($sessionDetailsArr['lastLogin']) && $sessionDetailsArr['lastLogin']>0 && $sessionDetailsArr['lastLogin']!=''){
									echo date('d M Y, h:i A', $sessionDetailsArr['lastLogin']);
								} else {
									echo 'Not Yet';
								} ?>
							</p>
						</li>
						<li class="af-profile-body">
							<a class="dropdown-item" href="<?php echo $baseUrl.$sysDir; ?>profile">
								<i class="fa fa-user"></i> My Profile
							</a>
						</li>
						<li><hr class="dropdown-divider" style="margin:0;"></li>
						<li class="af-profile-body">
							<a class="dropdown-item" href="<?php echo $baseUrl.$sysDir; ?>access">
								<i class="fa fa-users"></i> Guest Access
							</a>
						</li>
						<li class="af-profile-body">
							<a class="dropdown-item" href="<?php echo $baseUrl.$sysDir; ?>tickets">
								<i class="fa fa-life-ring"></i> Contact Support
							</a>
						</li>
						<li class="af-profile-body">
							<a class="dropdown-item" href="<?php echo $baseUrl; ?>amee-lab">
								<i class="fa fa-flask"></i> AMEE Lab
							</a>
						</li>
						<?php if ($accType == 'system-admin' || $accType == 'project-manager') { ?>
						<li class="af-profile-body">
							<a class="dropdown-item" href="<?php echo $baseUrl.$sysDir; ?>settings">
								<i class="fa fa-cog"></i> System Settings
							</a>
						</li>
						<?php } ?>
						<li><hr class="dropdown-divider" style="margin:0;"></li>
						<li class="af-profile-body">
							<a class="dropdown-item af-logout-item" href="<?php echo $baseUrl.$sysDir; ?>home/logout">
								<i class="fa fa-sign-out"></i> Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<!-- ===== Page Wrapper (keeps compatibility with footer closing tags) ===== -->
<div class="wrapper" style="display:block !important;">
	<div class="content-wrapper">
		<section class="content-header">
			<h1><?php echo $pageTitle; if(isset($pageSubTitle) && $pageSubTitle!=''){?><small class="pageSubTitle"><?php echo '&ndash; '.$pageSubTitle;?></small> <?php } ?></h1>
			<?php if(isset($success_msg) && $success_msg!=''){?>
				<div class="alert alert-success"><img style="margin-top:-3px;" src="<?php echo $baseUrl; ?>assets/backend/images/success.png" /> <?php echo $success_msg;?></div> 
			<?php } ?>
			<?php if(isset($error_msg) && $error_msg!=''){?>
				<div class="alert alert-danger"><img style="margin-top:-3px;" src="<?php echo $baseUrl; ?>assets/backend/images/warning.png" /> <?php echo $error_msg;?></div>
			<?php } ?>
		</section>

<script>
// Handle nested submenus on hover (desktop) and click (mobile)
document.addEventListener('DOMContentLoaded', function() {
	// Desktop: hover to open submenu
	document.querySelectorAll('.dropdown-submenu').forEach(function(el) {
		el.addEventListener('mouseenter', function() {
			if (window.innerWidth >= 992) {
				this.querySelector('.dropdown-menu').classList.add('show');
			}
		});
		el.addEventListener('mouseleave', function() {
			if (window.innerWidth >= 992) {
				this.querySelector('.dropdown-menu').classList.remove('show');
			}
		});
		// Mobile: click to toggle submenu
		el.querySelector('.dropdown-item').addEventListener('click', function(e) {
			if (window.innerWidth < 992) {
				e.preventDefault();
				e.stopPropagation();
				var subMenu = this.nextElementSibling;
				if (subMenu) {
					subMenu.classList.toggle('show');
				}
			}
		});
	});
});
</script>