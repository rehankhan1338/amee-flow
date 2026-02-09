	
	<?php if(isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='super_admin'){?>
	
	<!--<li class="treeview <?php if(isset($active_class) && $active_class=='dashboard'){ echo 'active';}?>">
		<a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
	</li>-->
	
	<?php } ?>
	
	<?php $menu_list = menu_list_helper($admin_type,$session_details->menu_ids);?>
	
	<?php foreach ($menu_list as $category_data) {?>
		
		<?php $submenu_list = submenu_list_helper($category_data->id,$admin_type,$session_details->submenu_ids);
			
			if(count($submenu_list)>0){?>
		
		<li class="dropdown <?php if(isset($active_class) && $active_class==$category_data->active_class){ echo 'active';}?>">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="<?php echo $category_data->icon;?>"></i> <?php echo $category_data->menu_name;?> <span class="caret"></span> 
		</a>
		
		<ul class="dropdown-menu" role="menu">
		<?php foreach ($submenu_list as $subcategory_data) {?>
			
			<?php if(isset($subcategory_data->submenu_active_class) && $subcategory_data->submenu_active_class!=''){ ?>
			<?php $submenu_subcat_list = submenu_subcat_list_helper($subcategory_data->id,$admin_type,$session_details->submenu_subcat_ids);?>
			<?php if(count($submenu_subcat_list)>0){?>
			<li class="dropdown-submenu <?php if(isset($sub_active_class) && $sub_active_class==$subcategory_data->submenu_active_class){ echo 'active';}?>">
 				<a href="#"><?php echo $subcategory_data->submenu_name;?> </a>
 				<ul class="dropdown-menu" role="menu">
				
				<?php foreach ($submenu_subcat_list as $submenu_subcat_data) {?>
					<li><a href="<?php echo base_url().$submenu_subcat_data->subcate_link;?>" ><?php echo $submenu_subcat_data->subcate_name;?> </a></li>
				<?php } ?>
				</ul>	
			</li>
			<?php } ?>
			<?php }else{ ?>
			
			<li><a href="<?php echo base_url().$subcategory_data->redirect_link;?>" ><?php echo $subcategory_data->submenu_name;?> </a></li>
			<?php } ?>
			
			
		 <?php } ?>
		</ul>
	</li>
	
	
	<?php } else{ 
	
		$menu_link = $category_data->menu_link;
		if($menu_link=='data_dashboard'){
			$rWithLnk = str_replace('_','',$university_details->sdTblPrefix).'/'.$university_details->encryptId;
			$menu_link_red = $this->config->item('PAD_URL').str_replace('data_dashboard',$rWithLnk,$menu_link);
			$targetBlank = 1;
		}else{
			$menu_link_red = base_url().$menu_link;
			$targetBlank = 0;
		}
	?>
	
		<li class="<?php if(isset($active_class) && $active_class==$category_data->active_class){ echo 'active';}?>">
			<a <?php if($targetBlank==1){?> target="_blank"<?php } ?> href="<?php echo $menu_link_red;?>"><i class="<?php echo $category_data->icon;?>"></i> <span><?php echo $category_data->menu_name;?></span> </a>
		</li>
		
	<?php } ?>
	 
	
	
	<?php } ?>
	 
		<?php if(isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='super_admin'){?>
		
			<li class="dropdown <?php if(isset($active_class) && $active_class=='system_setting'){ echo 'active';}?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-gears"></i> System Setting <span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">  
					<!--<li><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>/AMEE User Guide 2018.pdf" target="_blank">Download Guide</a></li>-->  
					<li><a href="<?php echo base_url();?>admin/setting/configuration/manage">Configuration</a></li> 
					<li><a href="<?php echo base_url();?>admin/setting/email_templates/manage">Email Templates</a></li> 
					<!--<li><a href="<?php echo base_url();?>admin/paypal"><i class="fa fa-circle-o"></i>Paypal Settings</a></li> 
					<li><a href="<?php echo base_url();?>admin/guest_access"><i class="fa fa-circle-o"></i>Sub Admins</a></li>-->
				</ul>
			</li>
			
			<li class="">
				<a href="<?php echo base_url().'admin/profile';?>"><i class="fa fa-user"></i> <span>Profile</span> </a>
			</li>
		
		<?php }?>