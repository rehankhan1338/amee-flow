 	<li class="treeview <?php if(isset($active_class) && $active_class=='dashboard'){ echo 'active';}?>">
		<a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
	</li>
	
	<li class="treeview <?php if(isset($active_class) && $active_class=='unit_types_menu'){ echo 'active';}?>">
		<a href="#"><i class="fa fa-th"></i> <span>Unit Types</span> </a>
	</li>
	
	<li class="treeview <?php if(isset($active_class) && $active_class=='cms_menu'){ echo 'active';}?>">
		<a href="#">
		<i class="fa fa-book"></i> <span>CMS</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
		<ul class="treeview-menu">
			<li><a href="#" target="_blank"><i class="fa fa-circle-o"></i>Welcome to Villa Amor</a></li>
			<li><a href="#" target="_blank"><i class="fa fa-circle-o"></i>FAQs </a></li>
		</ul>
	</li>
		 
	<!--<li class="treeview <?php if(isset($active_class) && $active_class=='curriculum_menu'){ echo 'active';}?>">
		<a href="#">
		<i class="fa fa-code"></i> <span>Curriculum Development</span> <i class="fa fa-angle-left pull-right"></i>
		</a>
		<ul class="treeview-menu">
			<li><a href="<?php echo base_url();?>curriculum_dev/course_listing" target="_blank"><i class="fa fa-circle-o"></i>Course listing</a></li>
			<li><a href="<?php echo base_url();?>curriculum_dev/course_description" target="_blank"><i class="fa fa-circle-o"></i>Course Descriptions </a></li>
			<li><a href="<?php echo base_url();?>curriculum_dev/classroom_availability" target="_blank"><i class="fa fa-circle-o"></i>Classroom Availability</a></li>
		</ul>
	</li>-->
	 
	
	 
		<?php if(isset($_SESSION['admin_type']) && $_SESSION['admin_type']=='super_admin'){?>
		
			<li class="treeview <?php if(isset($active_class) && $active_class=='system_setting'){ echo 'active';}?>">
				<a href="#">
					<i class="fa fa-gears"></i> <span>System Setting</span> <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">  
					<li><a href="<?php echo base_url();?>admin/setting/configuration/manage"><i class="fa fa-circle-o"></i>Configuration</a></li> 
					<li><a href="<?php echo base_url();?>admin/setting/email_templates/manage"><i class="fa fa-circle-o"></i>Email Templates</a></li> 
					<li><a href="<?php echo base_url();?>admin/guest_access"><i class="fa fa-circle-o"></i>Guest Access</a></li>
				</ul>
			</li>
		
		<?php }?>
	
	
		
		
		
		
	
