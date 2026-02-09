<?php $menu_list = administrator_menu_list_helper($sessionDetailsArr['accType'], $sessionDetailsArr['menu_ids']); ?>

<?php foreach ($menu_list as $category_data) { ?>

	<?php $submenu_list = administrator_submenu_list_helper($category_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_ids']);

	if (count($submenu_list) > 0) { ?>

		<li class="treeview <?php if (isset($active_class) && $active_class == $category_data->active_class) {echo 'active';} ?>">

			<a href="#"><i class="<?php echo $category_data->icon; ?>"></i> <span><?php echo $category_data->menu_name; ?></span> <i class="fa fa-angle-left pull-right"></i></a>

			<ul class="treeview-menu">
				<?php foreach ($submenu_list as $subcategory_data) { ?>
					<?php if (isset($subcategory_data->submenu_active_class) && $subcategory_data->submenu_active_class != '') { ?>
						<?php $submenu_subcat_list = administrator_submenu_subcat_list_helper($subcategory_data->id, $sessionDetailsArr['accType'], $sessionDetailsArr['submenu_subcat_ids']); ?>
						<?php if (count($submenu_subcat_list) > 0) { ?>
							<li class="treeview <?php if (isset($sub_active_class) && $sub_active_class == $subcategory_data->submenu_active_class) {
													echo 'active';
												} ?>">
								<a href="#"><i class="fa fa-circle-o"></i><?php echo $subcategory_data->submenu_name; ?> <i class="fa fa-angle-left pull-right"></i></a>
								<ul class="treeview-menu">
									<?php foreach ($submenu_subcat_list as $submenu_subcat_data) { ?>
										<li><a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $submenu_subcat_data->subcate_link); ?>"><i class="<?php echo $submenu_subcat_data->icon; ?>" style="width: 10px;"></i><?php echo $submenu_subcat_data->subcate_name; ?> </a></li>
									<?php } ?>
								</ul>
							</li>
						<?php } ?>
					<?php } else { ?>

						<li><a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $subcategory_data->redirect_link); ?>"><i class="fa fa-circle-o"></i><?php echo $subcategory_data->submenu_name; ?> </a></li>
					<?php } ?>

				<?php } ?>
			</ul>
		</li>

	<?php } else { ?>

		<li class="treeview <?php if (isset($active_class) && $active_class == $category_data->active_class) { echo 'active'; } ?>">
			<a href="<?php echo base_url() . str_replace('{admin}', $this->config->item('system_directory_name'), $category_data->menu_link); ?>"><i class="<?php echo $category_data->icon; ?>"></i> <span><?php echo $category_data->menu_name; ?></span> </a>
		</li>		

	<?php } ?>

<?php } ?>

<?php if (isset($_SESSION['AFSESS_accType']) && ($_SESSION['AFSESS_accType'] == 'system-admin' || $_SESSION['AFSESS_accType'] == 'project-manager')) { ?>
	<li class="treeview <?php if (isset($active_class) && $active_class == 'system_setting'){ echo 'active';} ?>">
		<a href="#"><i class="fa fa-gears"></i> <span>System Setting</span> <i class="fa fa-angle-left pull-right"></i></a>
		<ul class="treeview-menu">
			<!-- <li><a href="<?php //echo base_url().$this->config->item('system_directory_name').'access'; ?>"> <i class="fa fa-circle-o"></i> Guest Access</a></li> -->
			<li><a href="<?php echo base_url().$this->config->item('system_directory_name').'settings/emails'; ?>"> <i class="fa fa-circle-o"></i> Email Templates</a></li>			
		</ul>
	</li>
<?php } ?>

<li class="treeview">
	<a href="<?php echo base_url().$this->config->item('system_directory_name');?>home/logout"><i class="fa fa-sign-out"></i> <span>Logout</span> </a>
</li>