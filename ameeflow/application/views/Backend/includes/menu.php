<?php if (isset($_SESSION['admin_type']) && $_SESSION['admin_type'] == 'super_admin1') { ?>

	<li class="treeview <?php if (isset($active_class) && $active_class == 'dashboard') {
							echo 'active';
						} ?>">
		<a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
	</li>

<?php } ?>

<?php $menu_list = menu_list_helper($admin_type, $session_details->menu_ids); ?>

<?php foreach ($menu_list as $category_data) { ?>

	<?php $submenu_list = submenu_list_helper($category_data->id, $admin_type, $session_details->submenu_ids);

	if (count($submenu_list) > 0) { ?>

		<li class="treeview <?php if (isset($active_class) && $active_class == $category_data->active_class) {
								echo 'active';
							} ?>">
			<a href="#"><i class="<?php echo $category_data->icon; ?>"></i> <span><?php echo $category_data->menu_name; ?></span> <i class="fa fa-angle-left pull-right"></i></a>

			<ul class="treeview-menu">
				<?php foreach ($submenu_list as $subcategory_data) { ?>
					<?php if (isset($subcategory_data->submenu_active_class) && $subcategory_data->submenu_active_class != '') { ?>
						<?php $submenu_subcat_list = submenu_subcat_list_helper($subcategory_data->id, $admin_type, $session_details->submenu_subcat_ids); ?>
						<?php if (count($submenu_subcat_list) > 0) { ?>
							<li class="treeview <?php if (isset($sub_active_class) && $sub_active_class == $subcategory_data->submenu_active_class) {
													echo 'active';
												} ?>">
								<a href="#"><i class="fa fa-circle-o"></i><?php echo $subcategory_data->submenu_name; ?> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">

									<?php foreach ($submenu_subcat_list as $submenu_subcat_data) { ?>
										<li><a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('admin_directory_name'), $submenu_subcat_data->subcate_link); ?>"><i class="<?php echo $submenu_subcat_data->icon; ?>" style="width: 10px;"></i><?php echo $submenu_subcat_data->subcate_name; ?> </a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
					<?php } else { ?>

						<li><a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('admin_directory_name'), $subcategory_data->redirect_link); ?>"><i class="fa fa-circle-o"></i><?php echo $subcategory_data->submenu_name; ?> </a></li>
					<?php } ?>

				<?php } ?>
			</ul>
		</li>

	<?php } else { ?>

		<li class="treeview <?php if (isset($active_class) && $active_class == $category_data->active_class) {
								echo 'active';
							} ?>">
			<a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('admin_directory_name'), $category_data->menu_link); ?>"><i class="<?php echo $category_data->icon; ?>"></i> <span><?php echo $category_data->menu_name; ?></span> </a>
		</li>
		

	<?php } ?>

<?php } ?>

<?php if (isset($_SESSION['admin_type']) && $_SESSION['admin_type'] == 'super_admin') { ?>

	<li class="treeview <?php if (isset($active_class) && $active_class == 'system_setting'){ echo 'active';} ?>">
		<a href="#"><i class="fa fa-gears"></i> <span>System Setting</span> <i class="fa fa-angle-left pull-right"></i></a>
		<ul class="treeview-menu">
			<li><a href="<?php echo base_url().$this->config->item('admin_directory_name').'cms/prompts'; ?>"> <i class="fa fa-circle-o"></i> AI Prompts</a></li>
			<li><a href="<?php echo base_url().$this->config->item('admin_directory_name').'setting/email_templates/manage'; ?>"> <i class="fa fa-circle-o"></i> Email Templates</a></li>
			<li><a href="<?php echo base_url().$this->config->item('admin_directory_name').'cms/guide/project-manager'; ?>"> <i class="fa fa-circle-o"></i> Project Manager Guide</a></li>
			<li><a href="<?php echo base_url().$this->config->item('admin_directory_name').'cms/guide/area-expert'; ?>"> <i class="fa fa-circle-o"></i> Area Expert/Coll. Guide</a></li>
			
			<!-- <li><a href="<?php echo base_url() . $this->config->item('admin_directory_name') . 'subadmins'; ?>"> <i class="fa fa-circle-o"></i> Guest Access</a></li> -->
		</ul>
	</li>
<?php } ?>
<!--<li class="treeview <?php //if (isset($active_class) && $active_class == 'profile_menu'){echo 'active';} ?>">
	<a href="<?php //echo base_url() . $this->config->item('admin_directory_name') . '/profile'; ?>"><i class="fa fa-user"></i> <span>Profile</span> </a>
</li>
<li class="treeview">
	<a href="<?php //echo base_url() . $this->config->item('admin_directory_name') . '/logout'; ?>"><i class="fa fa-sign-out"></i> <span>Logout</span> </a>
</li>-->