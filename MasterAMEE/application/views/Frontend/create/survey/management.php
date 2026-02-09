<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php echo ucwords($survey_details->survey_name);?> 
	<?php if($survey_details->status==0){?>
		<!--<a class="survey_status_live" title="Click to Deactive Now" href="<?php //echo base_url().'survey/update_survey_status_btn?status=1&id='.$survey_details->survey_id;?>"></a>-->
	<?php }else{?>
		<!--<a class="survey_status_demo" title="Click to Active Now" href="<?php //echo base_url().'survey/update_survey_status_btn?status=0&id='.$survey_details->survey_id;?>"></a>-->
	<?php } ?>
	</h3>
	<div class="btn_div">
		<a class="btn btn-primary" target="_blank" href="<?php echo base_url().'survey/form/preview/'.$survey_details->survey_code;?>">
		<i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp;Preview Survey</a>&nbsp;
 		<a class="btn btn-default" href="<?php echo base_url().'department/create/surveys';?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
 	</div>
</div>

<div class="clearfix"></div>
<div class="nrow">	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>">Survey Configuration</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management?tab_id=2<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>">Survey Questions</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management?tab_id=3<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1">Survey Distributions</a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management?tab_id=4<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>">Results</a></li>
		
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==6){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management?tab_id=6<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>">Responses</a></li>
		
		<?php if(isset($survey_details->survey_sweepstakes) && $survey_details->survey_sweepstakes==0){?>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/survey/management?tab_id=5<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>">Sweepstakes Winner</a></li>
		<?php } ?>
		
		
		
	</ul>
	
	
	<?php if(!isset($_GET['tab_id'])){
	
		include(APPPATH.'views/Frontend/create/survey/configuration.php');
		
	 } ?>
			
		<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2 && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			include(APPPATH.'views/Frontend/create/survey/questions_listing.php');
		
		 } ?>


		<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3 && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			include(APPPATH.'views/Frontend/create/survey/distributions.php');
		
		 } ?>
		 
		 <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4 && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			include(APPPATH.'views/Frontend/create/survey/results.php');
		
		 } ?>
		 
		 <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5 && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id') && isset($survey_details->survey_sweepstakes)&& $survey_details->survey_sweepstakes==0){
			 
			include(APPPATH.'views/Frontend/create/survey/sweepstakes.php');
		
		 } ?>
		 
		 	<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==6 && isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
			include(APPPATH.'views/Frontend/create/survey/responses.php');
		
		 } ?>

	
</div>