<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php if(isset($title) && $title!=''){echo $title; }else{echo '';}?></title>
<link href="<?php echo base_url(); ?>assets/frontend/images/favicon.png" rel="shortcut icon">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/backend/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/css/custom.css" type="text/css" />  
<script type="text/javascript" src="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<?php if(isset($drap_drop_js) && $drap_drop_js==1){?>
<script type="text/javascript" src="<?php echo base_url();?>/assets/frontend/dynamic_drag_drop/js/jquery-ui-1.10.4.custom.min.js"></script>
<?php }else{ ?>
<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/jquery-ui-1.8.16.custom.min.js"></script>
<?php } ?>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/jquery-ui.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/frontend/js/general.js"></script>
<script type="text/javascript">  
jQuery(function () {
	jQuery('[data-toggle="tooltip"]').tooltip({html:true}); 
	jQuery('#accordion').accordion({autoHeight:  false});	
});
</script> 
<script src="<?php echo base_url(); ?>assets/backend/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
<?php if(isset($active_class) && ($active_class=='tickets_menu' || $active_class=='create_menu')){?>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<?php } ?>
<script src="<?php echo base_url();?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript">  
jQuery(function () {
	if(jQuery('#editor').length > 0){CKEDITOR.replace( 'editor',{height: '200px',}); }
	if(jQuery('#editor_end').length > 0){CKEDITOR.replace( 'editor_end',{height: '150px',}); }
	if(jQuery('#editor_distribution').length > 0){CKEDITOR.replace( 'editor_distribution',{height: '500px',}); }	
}); 
</script>
</head>
<body class="withvernav" >
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
           <a style="cursor:pointer;" href="<?php echo base_url();?>readiness"> <h1 class="logo">
            	<?php echo $this->config->item('project_name_page_first'); ?><!--<span> <?php //echo $this->config->item('project_name_page_second'); ?></span>-->
            </h1></a>
            <span class="slogan"><?php if(isset($dept_session_details->department_name)&& $dept_session_details->department_name!=''){echo $dept_session_details->department_name; }else{ echo 'Department Panel';} ?></span>
            <!--<div class="search">
            	<form action="#" method="post">
                	<input type="text" name="keyword" id="keyword" value="Enter keyword(s)" />
                    <button class="submitbutton"></button>
                </form>
            </div>--><!--search data-toggle="tooltip" data-placement="bottom" title="View All Notifications" -->
            <br clear="all" />
        </div>
        
        <div class="right">
        	<div class="notiBell">
                <a class="cnt" href="<?php echo base_url().'notifications';?>"><span><i class="fa fa-bell-o"></i></span></a>
        	</div>
            <div class="userinfo">
				<?php if($dept_session_details->image==''){ ?>
					<img src="<?php echo base_url();?>assets/frontend/images/thumbs/avatar.png" alt="" />
				<?php }else{ ?>
					<img  class="img-responsive" style="display: initial; width: 28px;" src="<?php echo base_url();?>assets/upload/department/thumbnails/<?php echo $dept_session_details->image;?>" alt="User Image" />
				<?php } ?>
				
                <span>
                	<?php if(isset($dept_session_details->first_name)&& $dept_session_details->first_name!=''){
                		echo 'Welcome back, '.ucwords($dept_session_details->first_name).'!';} ?>
                </span>
            </div><!--userinfo-->
            
            <div class="userinfodrop">
            	<div class="avatar">
                	<a href="#">
	                	<?php if($dept_session_details->image==''){ ?>
							<img src="<?php echo base_url();?>assets/frontend/images/thumbs/avatarbig.png" alt="" />
						<?php }else{ ?>
							<img class="img-responsive" src="<?php echo base_url();?>assets/upload/department/thumbnails/<?php echo $dept_session_details->image;?>" alt="" />
						<?php } ?>
                	</a>
                    <div class="changetheme">
                    	Last Login <br />
                    	<?php if($dept_session_details->last_login==''){ echo 'Not Yet'; }else{ echo date('m/d/y h:i A',$dept_session_details->last_login); }?>
                    </div>
                </div><!--avatar-->
                <div class="userdata">
                	<h4>
                		<?php echo ucwords($dept_session_details->first_name.' '.$dept_session_details->last_name); ?>
                	</h4><br />
                    <span class="email">
                    	<?php echo $dept_session_details->email; ?>
                    </span>
                    <ul>
                    	<li><a href="<?php echo base_url();?>Home/profile">Edit Profile</a></li>
                        <li><a href="<?php echo base_url();?>Home/account">Account Settings</a></li>
                        <!--<li><a href="help.html">Help</a></li>-->
                        <li><a href="<?php echo base_url();?>Home/logout">Sign Out</a></li>
                    </ul>
                </div><!--userdata-->
            </div><!--userinfodrop-->
        </div>
    </div><!-- topheader -->
    
    <div class="header">
    	<ul class="headermenu">
		
        	<li class="<?php if(isset($active_class) && $active_class=='readiness_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/readiness">TRACK <span><i class="fa fa-book"></i></span> Readiness</a></li>
			
			<?php if(isset($dept_session_details->department_type)&& $dept_session_details->department_type==2){ ?>
			
			<li><a onclick="return dialog_feature_disabled_popup_messages();">STEP 1<span><i class="fa fa-eye"></i></span>Envision</a></li>
			<li><a onclick="return dialog_feature_disabled_popup_messages();">STEP 2<span><i class="fa fa-location-arrow"></i></span>Co-ordinate</a></li>
			<li><a onclick="return dialog_feature_disabled_popup_messages();">STEP 3<span><i class="fa fa-paint-brush"></i></span>Design</a></li>
			<li><a onclick="return dialog_feature_disabled_popup_messages();">STEP 4<span><i class="fa fa-recycle"></i></span>Reflect</a></li>
			
			<?php }else{ ?>
			
            <li class="<?php if(isset($active_class) && $active_class=='envision_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/envision/action1">STEP 1<span><i class="fa fa-eye"></i></span>Envision</a></li>
			
            <li class="<?php if(isset($active_class) && $active_class=='coordinate_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/coordinate/action1">STEP 2<span><i class="fa fa-location-arrow"></i></span>Co-ordinate</a></li>
			
            <li class="<?php if(isset($active_class) && $active_class=='Design_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/design/action1">STEP 3<span><i class="fa fa-paint-brush"></i></span>Design</a></li>
			
            <li class="<?php if(isset($active_class) && $active_class=='Reflect_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/reflect/action1">STEP 4<span><i class="fa fa-recycle"></i></span>Reflect</a></li>
			
			<?php } ?>
			
            <li class="<?php if(isset($active_class) && $active_class=='create_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/create">STEP 5<span><i class="fa fa-bar-chart"></i></span>Create</a></li>
			
            <li class="<?php if(isset($active_class) && $active_class=='Analyze_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/analyze">Analysis<span><i class="fa fa-files-o"></i></span>Reporting</a></li>
			
			 <li class="<?php if(isset($active_class) && $active_class=='ClosingLoop_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>close_the_loop">CLOSE<span><i class="fa fa-spinner"></i></span>THE LOOP</a></li>
			
			<!--<li class="<?php //if(isset($active_class) && $active_class=='data_commons_menu'){echo 'current';}?>"><a href="<?php //echo base_url();?>department/data_commons">DATA <span><i class="fa fa-share-alt"></i></span>Commons</a></li>-->
			
			<li class="<?php if(isset($active_class) && $active_class=='logic_model_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>logic_model">LOGIC <span><i class="fa fa-lightbulb-o"></i></span>Model</a></li>
			
			<li class="<?php if(isset($active_class) && $active_class=='lesson_plan_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>lesson_plan">LESSON <span><i class="fa fa-bookmark"></i></span>PLANS</a></li>
			
			<!--<li class="<?php //if(isset($active_class) && $active_class=='data_dashboard_menu'){echo 'current';}?>"><a target="_blank" href="<?php //echo "https://bravofolio.com/program_assessment/".str_replace('_','',$this->config->item('sdTblPrefix')).'/'.$this->config->item('cv_university_encryptId');?>">DATA <span><i class="fa fa-database"></i></span>Dashboard</a></li>-->
			
            <li class="<?php if(isset($active_class) && $active_class=='reports_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/reports">RUN <span><i class="fa fa-flag-checkered"></i></span>Reports</a></li>
			
            <!--<li class="<?php if(isset($active_class) && $active_class=='notifications_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/notifications">SEND <span><i class="fa fa-envelope-o"></i></span>Notifications <?php //if(get_unread_stauts_notification_h($this->session->userdata('dept_id'))>0){?><sup><i class="fa fa-circle notification_icon"></i></sup><?php //}?></a></li>-->
			
			<li class="<?php if(isset($active_class) && $active_class=='tickets_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>tickets">Support <span><i class="fa fa-envelope-o"></i></span>Tickets</a></li>
			
            <li class="<?php if(isset($active_class) && $active_class=='Tutorials_menu'){echo 'current';}?>"><a href="<?php echo base_url();?>department/tutorials">AMEE <span><i class="fa fa-leanpub"></i></span>Tutorials</a></li> 
			
			<!--<li class="<?php //if(isset($active_class) && $active_class=='suites_menu'){echo 'current';}?>"><a href="<?php //echo base_url();?>department/suites">AMEE <span><i class="fa fa-suitcase"></i></span>Suites</a></li>
			
			<li><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'];?>/AMEE User Guide 2018.pdf" target="_blank">DOWNLOAD <span><i class="fa fa-download"></i></span>Guide</a></li>
			
			<li><a href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'];?>/AMEE User Guide 2018.pdf" target="_blank">UPLOADS <span><i class="fa fa-upload"></i></span>Report</a></li>-->
			
        </ul>
        
        <!--<div class="headerwidget">
        	<div class="earnings">
            	<div class="one_half">
                	<h4>Total Activity</h4>
                    <h2>640.01</h2>
                </div>
                <div class="one_half last alignright">
                	<h4>Steps Completed</h4>
                    <h2>53%</h2>
                </div>
            </div>
        </div>-->
    </div><!--header -->   
    <div class="centercontent marleft0">
        <div class="pageheader <?php if(isset($page_sub_title) && $page_sub_title!=''){echo 'notab ';} if(isset($data_commons_page_enable) && $data_commons_page_enable==1){echo 'data_commons_page_enable';}?>">
            <h1 class="pagetitle"><?php if(isset($page_title) && $page_title!=''){echo $page_title;}?>
			<?php if(isset($page_description) && $page_description!=''){?><span class="pagedesc"><?php echo $page_description;?></span><?php } ?>
			</h1>
            <?php if(isset($page_sub_title) && $page_sub_title!=''){?><span class="pagedesc"><?php echo $page_sub_title;?></span><?php } ?>
        </div> 
		
 	<div id="contentwrapper" class="contentwrapper">
 	
	<?php if(isset($success_msg)&& $success_msg!=''){ ?>
		<div class="alert alert-success"> <img style="margin-top:-3px; vertical-align:middle;" src="<?php echo base_url();?>assets/backend/images/success.png"> <?php echo $success_msg; ?> </div>
	<?php }elseif(isset($error_msg)&& $error_msg!=''){ ?>
		<div class="alert alert-danger">
			<?php if($error_msg=='yes'){ 
			
				$department_id = $this->session->userdata('dept_id');
				$import_error = get_import_error_log_h($department_id);
				foreach($import_error as $import_error_data){
				echo '<p>'.$import_error_data->error_reason.'</p>';
				}
			
			}else{echo $error_msg; }?>
		</div>
	<?php } ?>
	