<?php include(APPPATH.'views/Frontend/create/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="survey_heading">
	<h3> Unit Analysis Review : : <?php if(isset($unit_details->budget_unit_name) && $unit_details->budget_unit_name!=''){ echo ucwords($unit_details->budget_unit_name);}else{ echo 'Add';}?></h3>
	<div class="btn_div">
		<a class="btn btn-default" href="<?php echo base_url();?>department/create/unit_reviews">
		<i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Dashboard</a>
	</div>
 </div>
 <style type="text/css">
 	.unit_analysis_page h4{ font-weight:600; font-size:15px;}
 </style>
<div class="box unit_analysis_page">
<div class="box-body">
	<div class="nrow">	
		<ul class="hornav">
			<li class="<?php if(!isset($_GET['tab'])){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '?unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Set up Review</a></li>
			<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==2){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage?tab=2<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Mission Statement / Modifications </a></li>
			<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==3){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage?tab=3<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Core Functions </a></li>
			<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==4){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage?tab=4<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Evaluation Assessment</a></li>
			<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==5){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage?tab=5<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Discuss Evaluation Results</a></li>
			<li class="<?php if(isset($_GET['tab']) && $_GET['tab']==6){echo 'current';}?>"><a href="<?php echo base_url();?>department/create/unit_reviews/manage?tab=6<?php if(isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&unit_id='.$_GET['unit_id'].'&dept_id='.$_GET['dept_id'];}?>">Finances / Human Resources </a></li>
		</ul>
		<?php if(!isset($_GET['tab'])){?>
			<div class="subcontent margin20">		
				<div class="contenttitle2 nomargintop">
					<h3> Set up Review </h3>
				</div>
				<div class="clearfix"></div>
				<form data-toggle="validator" class="form-horizontal margin20" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/manage_unit_details<?php if(isset($unit_details->budget_unit_name) && $unit_details->budget_unit_name!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3">Budget Unit Name*</label>
						<div class="col-sm-6">
							<input type="text" class="form-control required" id="budget_unit_name" name="budget_unit_name" placeholder="Budget Unit Name" value="<?php if(isset($unit_details->budget_unit_name) && $unit_details->budget_unit_name!=''){ echo $unit_details->budget_unit_name;}?>"  >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label" for="inputEmail3">Academic Year*</label>
						<div class="col-sm-6">
							<select class="form-control required" id="academic_year" name="academic_year">
								<option value="">--select--</option>
								<?php for($yl=2015;$yl<=2050;$yl++){?>
								<option value="<?php echo $yl;?>" <?php if(isset($unit_details->academic_year) && $unit_details->academic_year==$yl){?> selected="selected" <?php }?>><?php echo $yl.' - '.($yl+1);?></option>
								<?php } ?>
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
		
		<?php if(isset($_GET['tab']) && $_GET['tab']==2 && isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
		<div class="subcontent margin20">	
			<div class="contenttitle2 nomargintop">
				<h3> Mission Statement / Modifications </h3>
			</div>
			<div class="clearfix"></div>
			<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/mission_statement_modifications<?php if(isset($unit_details->id) && $unit_details->id!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
				<textarea id="editor" name="mission_statement_modifications"><?php if(isset($unit_details->mission_statement_modifications) && $unit_details->mission_statement_modifications!=''){ echo $unit_details->mission_statement_modifications;}?></textarea> 
				<div class="form-group">
					<button type="submit" class="btn btn-primary margin20" name="submit_login">Save and Continue</button>
				</div>
			</form>
		</div>
		<?php } ?>
		
		<?php if(isset($_GET['tab']) && $_GET['tab']==3 && isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
		<div class="subcontent margin20">	
			<div class="contenttitle2 nomargintop">
				<h3> Core Functions </h3>
			</div>
			
			<div class="col-md-12 instructions"><strong>Instructions:</strong> List the core functions for this unit. For each, identify the college's strategic priority and/or college-wide student learning outcome that it supports.</div>
			<div class="clearfix"></div>
			
			<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/core_functions<?php if(isset($unit_details->id) && $unit_details->id!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
				<div class="form-group">
					<label  for="inputEmail3">Description of Core Function/Modifications</label>
  	 			<textarea id="editor" name="core_function_modifications"><?php if(isset($unit_details->core_function_modifications) && $unit_details->core_function_modifications!=''){ echo $unit_details->core_function_modifications;}?></textarea> 
</div>
					<div class="col-md-12" style="margin-top:20px;"> 
					<?php if(count($unit_core_functions_details)>0){?>
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){?>
						
						<div class="docfields">
						<div class="col-md-5 form-group">
							<label for="inputEmail3"><h4>Core Function #<?php echo $j;?></h4></label>
							<input type="text" name="core_function_add_edit<?php echo $unit_core_functions->id;?>" id="core_function_add_edit<?php echo $unit_core_functions->id;?>" value="<?php if(isset($unit_core_functions->core_functions) && $unit_core_functions->core_functions!=''){ echo $unit_core_functions->core_functions;}?>" class="form-control required" placeholder="Insert the Name of core function" />
						</div>
						<div class="col-md-5 form-group">
						<label for="inputEmail3"><h4>Strategic Priorities</h4></label>
						<?php $master_strategic_priorities = get_master_strategic_priorities_h();						
						
						if(isset($unit_core_functions->strategic_priorities_id) && $unit_core_functions->strategic_priorities_id!=''){
 							$strategic_priorities_arr = explode(',',$unit_core_functions->strategic_priorities_id);
 						}else{
							$strategic_priorities_arr[]='';
						}
						
						?>
							<select class="form-control required" multiple="multiple" name="strategic_priorities_add_edit<?php echo $unit_core_functions->id;?>[]" id="strategic_priorities_add_edit<?php echo $unit_core_functions->id;?>" >
								<option value="">-- select --</option>
								<?php foreach($master_strategic_priorities as $strategic_priorities){?>
									<option value="<?php echo $strategic_priorities->id;?>" <?php if(in_array($strategic_priorities->id,$strategic_priorities_arr)){ ?> selected="selected" <?php } ?> ><?php echo $strategic_priorities->name;?></option>
								<?php } ?>
							</select>
							<input type="hidden" name="edit_core_function_count[]" id="edit_core_function_count[]" value="<?php echo $unit_core_functions->id;?>" />
						</div>
							<div class="col-md-2"><label for="inputEmail3"><h4>&nbsp;</h4></label><br><a href="<?php echo base_url();?>unit_reviews/delete_core_function?unit_id=<?php echo $unit_details->id;?>&id=<?php echo $unit_core_functions->id;?>" style="margin-top: 7px;" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to Delete Core Function #<?php echo $j;?>?');">Delete Core Function #<?php echo $j;?></a></div>
						</div>
					<?php $j++; } ?>
					<?php } else{ ?>
					
					<div class="docfields">
						<div class="col-md-5 form-group">
							<label for="inputEmail3"><h4>Core Function #1</h4></label>
							<input type="text" name="core_function_add_first" id="core_function_add_first" value="" class="form-control required" placeholder="Insert the Name of core function" />
						</div>
						<div class="col-md-5 form-group">
						<label for="inputEmail3"><h4>Strategic Priorities</h4></label>
						<?php $master_strategic_priorities = get_master_strategic_priorities_h();?>
							<select class="form-control required" multiple="multiple" name="strategic_priorities_add_first[]" id="strategic_priorities_add_first" >
								<option value="">-- select --</option>
								<?php foreach($master_strategic_priorities as $strategic_priorities){?>
									<option value="<?php echo $strategic_priorities->id;?>"><?php echo $strategic_priorities->name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php } ?>
					<div class="clearfix"></div>
					<div id="load_docs"></div>
						<div class="col-md-12">
							<a class="btn btn-success btn-sm pull-right" style="margin-top:10px; font-size:15px" onclick="return add_more_core_function();">Add More Core Function</a>
						</div>
					</div>
                 
<script type="text/javascript">
function add_more_core_function(){
var n = jQuery(".docfields").length;
var cnt = n+1; 
var html = '<div class="docfields"><div class="col-md-5 form-group"><label for="inputEmail3"><h4>Core Function #'+cnt+'</h4></label><input type="text" name="core_function_add_more'+cnt+'" id="core_function_add_more'+cnt+'" value="" class="form-control required" placeholder="Insert the Name of core function" /></div><div class="col-md-5 form-group"><label for="inputEmail3"><h4>Strategic Priorities</h4></label><?php $master_strategic_priorities = get_master_strategic_priorities_h();?><select multiple="multiple" class="form-control required" name="strategic_priorities_add_more'+cnt+'[]" id="strategic_priorities_add_more'+cnt+'" ><option value="">-- select --</option><?php foreach($master_strategic_priorities as $strategic_priorities){?><option value="<?php echo $strategic_priorities->id;?>"><?php echo $strategic_priorities->name;?></option><?php } ?></select><input type="hidden" name="add_more_count[]" id="add_more_count[]" value="'+cnt+'" /></div>';
html = html + '<div class="col-md-2"><label for="inputEmail3"><h4>&nbsp;</h4></label><br><a style="margin-top: 7px;" class="btn btn-sm btn-danger" onclick="javascript:removeField(this);">Remove</a></div></div>';
jQuery('#load_docs').append(html);
}
function removeField(element){
jQuery(element).closest(".docfields").remove();
}
</script> 
			<div class="form-group">
			<button type="submit" class="btn btn-primary margin20" name="submit_login">Save and Continue</button>
		</div>
			
		</form>
	</div>
		
	<?php } ?>
	
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==4 && isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
		
		<div class="subcontent margin20">	
			
			<div class="contenttitle2 nomargintop">
				<h3> Evaluation Assessment </h3>
			</div>
		   <div class="col-md-12 instructions"><strong>Instructions:</strong> Identify goals for each core function, then identify how you will assess the core function. Next, measure a 1 or more of the core functions. After results are collected, describe how the evaluation results from last year compare with the results from the previous year.</div> 
			<div class="clearfix"></div>
			<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/evaluation_assessment<?php if(isset($unit_details->id) && $unit_details->id!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
			
			<div> 
				
				<?php if(count($unit_core_functions_details)>0){?>
				
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){
					
							$direct_measures_arr='';
							$indirect_measures_arr='';
							
							?>
					
					<div>
					
						<div class="col-md-4 form-group">
							<label for="inputEmail3"><h4>Core Function #<?php echo $j;?></h4></label>
							<input type="text" name="core_function_ea<?php echo $unit_core_functions->id;?>" id="core_function_ea<?php echo $unit_core_functions->id;?>" value="<?php if(isset($unit_core_functions->core_functions) && $unit_core_functions->core_functions!=''){ echo $unit_core_functions->core_functions;}?>" class="form-control required"  placeholder="Insert the Name of core function" />
						</div>
						
						<div class="col-md-4 form-group">
							<label for="inputEmail3"><h4>Goal  #<?php echo $j;?></h4></label>
							<input type="text" name="goal_ea<?php echo $unit_core_functions->id;?>" id="goal_ea<?php echo $unit_core_functions->id;?>" value="<?php if(isset($unit_core_functions->goals) && $unit_core_functions->goals!=''){ echo $unit_core_functions->goals;}?>" class="form-control"  placeholder="" />
						</div>
						
						<div class="col-md-4 form-group">
							<label for="inputEmail3"><h4>Direct/Indirect Measures</h4></label>
							<?php $master_direct_assessment = get_master_direct_assessment_h();?>
							<?php $master_indirect_assessment = get_master_indirect_assessment_h();
							
							if(isset($unit_core_functions->direct_measures) && $unit_core_functions->direct_measures!=''){
								$direct_measures_arr = explode(',',$unit_core_functions->direct_measures);
							}else{
								$direct_measures_arr[]='';
							}
							
							if(isset($unit_core_functions->indirect_measures) && $unit_core_functions->indirect_measures!=''){
								$indirect_measures_arr = explode(',',$unit_core_functions->indirect_measures);
							}else{
								$indirect_measures_arr[]='';
							}
						?>
							<select class="form-control" name="direct_indirect_measures_ea<?php echo $unit_core_functions->id;?>[]" multiple="multiple" id="direct_indirect_measures_ea<?php echo $unit_core_functions->id;?>" >
								<option value="">-- select --</option>
								<?php foreach($master_direct_assessment as $direct_assessment){?>
									<option value="1|<?php echo $direct_assessment->id;?>" <?php if(in_array($direct_assessment->id,$direct_measures_arr)){ ?> selected="selected" <?php } ?> ><?php echo $direct_assessment->name;?></option>
								<?php } ?>
								<?php foreach($master_indirect_assessment as $indirect_assessment){?>
									<option value="2|<?php echo $indirect_assessment->id;?>" <?php if(in_array($indirect_assessment->id,$indirect_measures_arr)){ ?> selected="selected" <?php } ?> ><?php echo $indirect_assessment->name;?></option>
								<?php } ?>
							</select>
							
							<input type="hidden" name="edit_ea_count[]" id="edit_ea_count[]" value="<?php echo $unit_core_functions->id;?>" />
						</div>
						
					
					</div>
					
					<?php $j++; } ?>
				
				<?php } ?>
				
				
				
			
			</div>
			
			<div class="col-md-12">
				
				<div class="form-group" >
					<label for="inputEmail3"><h4>Year-to-Year Comparisons</h4></label>
				
 				<textarea id="editor" name="year_to_year_comparisons"><?php if(isset($unit_details->year_to_year_comparisons) && $unit_details->year_to_year_comparisons!=''){ echo $unit_details->year_to_year_comparisons;}?></textarea> 
				
				</div>
						<div class="form-group">
					<button type="submit" class="btn btn-primary " name="submit_login">Save and Continue</button>
				</div>
			</div>
			
			</form>
			
		</div>	
	<?php } ?>	
		
		
		
		<?php if(isset($_GET['tab']) && $_GET['tab']==5 && isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
		
		<div class="subcontent margin20">	
			
			<div class="contenttitle2 nomargintop">
				<h3> Discuss Evaluation Results</h3>
			</div>
			<div class="col-md-12 instructions"><strong>Instructions:</strong> For each goal, list the course of actions for improvement. </div>
			<div class="clearfix"></div>
			<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/discuss_of_evaluation_result<?php if(isset($unit_details->id) && $unit_details->id!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
			
			<!--<div class="form-group">
				<label class="col-sm-12" for="inputEmail3">Year-to-Year Comparisons</label>
		</div>-->
	 
			<textarea id="editor" name="discuss_of_evaluation_result"><?php if(isset($unit_details->discuss_of_evaluation_result) && $unit_details->discuss_of_evaluation_result!=''){ echo $unit_details->discuss_of_evaluation_result;}?></textarea> 
			 
			<div  style="margin-top:20px;"> 
				
				<?php if(count($unit_core_functions_details)>0){?>
				
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){?>
					
					<div>
					
						<div class="col-md-6 form-group">
							<label for="inputEmail3"><h4>Goal  #<?php echo $j;?></h4></label>
							<input type="text" name="goal_er<?php echo $unit_core_functions->id;?>" id="goal_er<?php echo $unit_core_functions->id;?>" value="<?php if(isset($unit_core_functions->goals) && $unit_core_functions->goals!=''){ echo $unit_core_functions->goals;}?>" class="form-control"  placeholder="" />
						</div>
						
						
						<div class="col-md-6 form-group">
							<label for="inputEmail3"><h4>Actions for Improvement</h4></label>
							<input type="text" name="actions_for_improvement<?php echo $unit_core_functions->id;?>" id="actions_for_improvement<?php echo $unit_core_functions->id;?>" value="<?php if(isset($unit_core_functions->actions_for_improvement) && $unit_core_functions->actions_for_improvement!=''){ echo $unit_core_functions->actions_for_improvement;}?>" class="form-control"  placeholder="" />
							
							<input type="hidden" name="edit_er_count[]" id="edit_er_count[]" value="<?php echo $unit_core_functions->id;?>" />
							
						</div>
						
					
					</div>
					
					<?php $j++; } ?>
				
				<?php } ?>
				
				
					
			
			</div>
			
			<div class="form-group">
			<button type="submit" class="btn btn-primary margin20" name="submit_login">Save and Continue</button>
		</div>
			
			</form>
			
		</div>	
	<?php } ?>	
	
	
	<?php if(isset($_GET['tab']) && $_GET['tab']==6 && isset($_GET['unit_id']) && $_GET['unit_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){?>
		
		<div class="subcontent margin20">	
			
			<div class="contenttitle2 nomargintop">
				<h3>Management of Finances / Human Resources</h3>
			</div>
			
			<div class="clearfix"></div>
			<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="<?php echo base_url();?>unit_reviews/management_of_finance_hr<?php if(isset($unit_details->id) && $unit_details->id!=''){ echo '?unit_id='.$unit_details->id;}?>" enctype="multipart/form-data">
			
			<!--<div class="form-group">
				<label class="col-sm-12" for="inputEmail3">Year-to-Year Comparisons</label>
		</div>-->
	 
			<textarea id="editor" name="management_of_finance_hr"><?php if(isset($unit_details->management_of_finance_hr) && $unit_details->management_of_finance_hr!=''){ echo $unit_details->management_of_finance_hr;}else{ echo 'Briefly discuss the management of finances for this unit. Was the allocated budget exceeded? What future budgetary adjustments might be necessary?';}?></textarea> 
			 
			<div class="col-md-12" style="margin-top:20px;"> 
			
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="submit_login">Save and Continue</button>
				</div>
			
			</div>
		
			</form>
			
		</div>	
	<?php } ?>	
		
	</div>
 
	<div class="clearfix"></div>
</div>
</div>