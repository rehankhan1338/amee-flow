<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<?php if(isset($_GET['test_id'])&& $_GET['test_id']!=''){$test_id = $_GET['test_id'];}?>

	<h3><?php echo ucwords($test_details->test_title);	
	if(isset($test_details->current_test_type)&& $test_details->current_test_type>0){
 		if($test_details->current_test_type==1){
			echo " (Pre Test)";
		}elseif($test_details->current_test_type==2){
			echo " (Post Test)";
		}elseif($test_details->current_test_type==3){
			echo " (One Time Test)";
		}
 	}?>	
	- Total Score =
	<?php $point_sum = get_point_value_by_test_id($test_id);
		if(isset($point_sum->point_value)&& $point_sum->point_value!=''){echo $total_score = $point_sum->point_value;}else{echo $total_score = '0';}
		
	if($test_details->status==0){?>
		<!--<a class="survey_status_live" href="<?php //echo base_url().'tests/update_test_status_btn?status=1&id='.$test_details->test_id;?>"></a>-->
	<?php }else{?>
		<!--<a class="survey_status_demo" href="<?php //echo base_url().'tests/update_test_status_btn?status=0&id='.$test_details->test_id;?>"></a>-->
	<?php } ?>
	</h3>
	
	<div class="btn_div">
		<a class="btn btn-primary" target="_blank" href="<?php echo base_url().'test/preview/'.$test_details->test_code;?>">
		<i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp;Preview Test</a>&nbsp;
		<a class="btn btn-default" href="<?php echo base_url().'department/create/tests';?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
	</div>
</div>

<div class="clearfix"></div>
<div class="nrow">	
	<ul class="hornav">
		
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>">Demographic Questions</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=2<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>"> Courses / Program  </a></li>		
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=3<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>">Test Questions</a></li>		
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=4<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>">Submission Deadline</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=5<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1">Criterion Options</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==6){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=6<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1">
		
		<?php
		if(isset($test_details->current_test_type)&& $test_details->current_test_type>0){
 		if($test_details->current_test_type==1){
			echo "Pre Test";
		}elseif($test_details->current_test_type==2){
			echo "Post Test";
		}elseif($test_details->current_test_type==3){
			echo "One Time Test";
		}
 	}
	?> Distributions</a></li>
	
	
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==7){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/tests/management?tab_id=7<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>">Results</a></li>
	</ul>
	
	
	<?php if(!isset($_GET['tab_id'])){
	
		include(APPPATH.'views/Frontend/create/tests/demography_questions_listing.php');
		
	 } ?>
			
	<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/tests/course.php');
	
	 } ?>	
	 
	 
	<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
	
		include(APPPATH.'views/Frontend/create/tests/questions_listing.php');
		
	 } ?>
	 
	 <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/tests/submission_deadline.php');
	
	 } ?>


	<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/tests/criterion_options.php');
	
	 } ?>
	 
	 
	<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==6 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/tests/distributions.php');
	
	 } ?>
	 
	 <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==7 && isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/tests/results.php');
	
	 } ?>

</div>