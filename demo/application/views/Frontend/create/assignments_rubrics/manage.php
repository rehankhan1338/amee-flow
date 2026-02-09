<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php if(isset($assignments_rubrics_row->assignment_title) && $assignments_rubrics_row->assignment_title!=''){ echo ucwords($assignments_rubrics_row->assignment_title);}else{ echo 'Assignments / Rubrics';}
	 if($assignments_rubrics_row->status==0){?>
		<!--<a class="survey_status_live" href="<?php //echo base_url().'assignments_rubrics/update_assignment_status_btn?status=3&id='.$assignments_rubrics_row->id;?>"></a>-->
	<?php }else{?>
		<!--<a class="survey_status_demo" href="<?php //echo base_url().'assignments_rubrics/update_assignment_status_btn?status=0&id='.$assignments_rubrics_row->id;?>"></a>-->
	<?php } ?>
	
	</h3>
	<div class="btn_div">
		<a class="btn btn-primary" target="_blank" href="<?php echo base_url().'assignment/preview/'.$assignments_rubrics_row->assignment_code;?>">
		<i class="fa fa-sign-out" aria-hidden="true"></i> &nbsp;Preview Assignment</a>&nbsp;
 		<a class="btn btn-default" href="<?php echo base_url().'department/create/assignments_rubrics';?>">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
	</div>
	
</div>
<style type="text/css">
.unit_analysis_page h4{ font-weight:600; font-size:16px;}
/*.hornav li a {padding: 9px 10px;}*/
</style>
<div class="box unit_analysis_page">

<div class="box-body">
<div class="nrow">	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab'])){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Set up </a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==2){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=2<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Demographic Data</a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==3){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=3<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Interventions</a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==4){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=4<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Prepare Instructions</a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==5){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=5<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Submission Deadline</a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==6){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=6<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Rubric Builder</a></li>
		
		<!--<li class="<?php //if(isset($_GET['tab']) && $_GET['tab']==7){echo 'current';}?>"><a href="<?php //echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php //if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>">Rubric Criterion</a></li>-->
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==7){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1">Distribution</a></li>
		
		<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==8){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=8<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&view_result=takers">Rubric Results</a></li>
		
	</ul>
	 
	<?php if(!isset($_GET['tab'])){?>
	<div class="subcontent margin20">		
		<div class="contenttitle2 nomargintop">
			<h3> Set up Assignment(s) </h3>
		</div>
		<div class="clearfix"></div>
		<form data-toggle="validator" class="form-horizontal margin20" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/set_assignment<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>" enctype="multipart/form-data">

			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputEmail3">Rubric Title *</label>
				<div class="col-sm-6">
					<input type="text" style="width:98%;" class="form-control required" id="assignment_title" name="assignment_title" placeholder="Assignment Title" value="<?php if(isset($assignments_rubrics_row->assignment_title) && $assignments_rubrics_row->assignment_title!=''){ echo $assignments_rubrics_row->assignment_title;}?>" >
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputEmail3">Rubric Type *</label>
				<div class="col-sm-6">
				<select class="form-control required" id="assignment_type" name="assignment_type" placeholder="Assignment Type" style="width:98%;">
					<option value="">Select...</option>
					
					<?php $master_direct_assessment = get_master_direct_assessment_h(); 
						
						foreach($master_direct_assessment as $assessments){?>
							
							<option value="<?php echo $assessments->id;?>" <?php if(isset($assignments_rubrics_row->assignment_type) && $assignments_rubrics_row->assignment_type==$assessments->id){?> selected="selected" <?php }?> > <?php echo $assessments->name; ?> </option>
					<?php }	?>
				</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputEmail3">Anonymous Link *</label>
				<div class="col-sm-6">
					<select class="form-control required" name="anonymousAssignment" id="anonymousAssignment" style="width:98%;">
						<option value="">Select...</option>
						<option value="0" <?php if(isset($assignments_rubrics_row->anonymousAssignment) && $assignments_rubrics_row->anonymousAssignment==0){?> selected="selected" <?php }?>>Yes</option>
						<option value="1" <?php if(isset($assignments_rubrics_row->anonymousAssignment) && $assignments_rubrics_row->anonymousAssignment==1){?> selected="selected" <?php }?>>No</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputEmail3">Status *</label>
				<div class="col-sm-6">
				<select class="form-control required" id="assignment_status" name="assignment_status" style="width:98%;">
 					<option value="0" <?php if(isset($assignments_rubrics_row->status) && $assignments_rubrics_row->status==0){?> selected="selected" <?php }?> >Active</option>
					<option value="3" <?php if(isset($assignments_rubrics_row->status) && $assignments_rubrics_row->status==3){?> selected="selected" <?php }?> >In-active</option>
				</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inputEmail3"></label>
				<div class="col-sm-8">
					<button type="submit" class="btn btn-primary" name="submit_login">Save and Continue</button>
				</div>
			</div>
		</form>	
	</div>	
	<?php } ?>
	
	
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==2 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/demographic_questions.php');	

	} ?>
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==3 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/course_data.php');	

	} ?>
	
	
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==4 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
	
		include(APPPATH.'views/Frontend/create/assignments_rubrics/prepare_instructions.php');	
		
	  } ?>


	
	<?php if(isset($_GET['tab']) && $_GET['tab']==5 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
			
		include(APPPATH.'views/Frontend/create/assignments_rubrics/submission_deadline.php');	
				
	} ?>	
	
	
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==6 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/rubric_builder.php');	
	
	} ?>
	
	<?php /*if(isset($_GET['tab']) && $_GET['tab']==7 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/rubric_criterion.php');	
	
	} */?>
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==7 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/distributions.php');	
	
	} ?>
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==8 && isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){
		
		
		include(APPPATH.'views/Frontend/create/assignments_rubrics/results.php');	
	
	} ?>
	
</div>

<div class="clearfix"></div>
</div>
</div>