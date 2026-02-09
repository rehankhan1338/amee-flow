<li class="treeview <?php if (isset($active_class) && $active_class == 'project-menu') { echo 'active'; } ?>">
	<a href="<?php echo base_url().'projects'; ?>"><i class="fa fa-cube"></i> <span>My Projects</span> </a>
</li>

<li class="treeview <?php if (isset($active_class) && $active_class == 'assignment-menu') { echo 'active'; } ?>">
	<a href="<?php echo base_url().'roles'; ?>"><i class="fa fa-users"></i> <span>Role Assignments</span> </a>
</li>

<li class="treeview <?php if (isset($active_class) && $active_class == 'reports-menu'){ echo 'active';} ?>">
	<a href="#"><i class="fa fa-file"></i> <span>Docs/Reports</span> <i class="fa fa-angle-left pull-right"></i></a>
	<ul class="treeview-menu">
		<li><a href="<?php echo base_url().'sampling_plan/build'; ?>"> <i class="fa fa-circle-o"></i> Build Sampling Plan</a></li>
		<li><a href="<?php echo base_url().'sampling_plan'; ?>"> <i class="fa fa-circle-o"></i> Sampling Plan Reports</a></li>
		<li><a href="<?php //echo base_url().'sampling_plan'; ?>"> <i class="fa fa-circle-o"></i> LOADs Report </a></li>
		<li><a href="<?php //echo base_url().'sampling_plan'; ?>"> <i class="fa fa-circle-o"></i> General Reports </a></li>
		<li><a href="<?php echo base_url().'sampling_plan/alignment_map'; ?>"> <i class="fa fa-circle-o"></i> Alignment Map</a></li>
		<li><a href="<?php //echo base_url().'sampling_plan'; ?>"> <i class="fa fa-circle-o"></i> Other Documents </a></li>
	</ul>
</li>

<li class="treeview <?php if (isset($active_class) && $active_class == 'support-menu') { echo 'active'; } ?>">
	<a href="<?php echo base_url().'tickets'; ?>"><i class="fa fa-envelope-o"></i> <span>Contact Support</span> </a>
</li>