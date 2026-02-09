<?php include(APPPATH.'views/Frontend/envision/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<?php $department_id = $this->session->userdata('dept_id');	?>
<div class="box"> 
<div class="nrow">	
	<style>
		.ccshow{ font-size: 16px;
margin-left: 15px;
margin-top: 5px; } 
	</style>	
	<ul class="hornav">
		<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#Undergraduates">Undergraduates PSLOS</a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#Graduates">Graduates PSLOS </a></li>
		<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="#program_learning_outcomes">PLO Competencies </a></li>
	</ul>

	<div id="Undergraduates" class="subcontent margin20" style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Undergraduates PSLOS: </h3>
		</div>
		<span style="font-size:20px;">Please click the <b>(+)</b> to align your outcomes with core competencies.</span>
		<?php if(count($department_pslos_undergraduate)>0){ $j=1; foreach($department_pslos_undergraduate as $undergraduate){?>
		<div class="bs-example">
		<div class="panel-group" id="accordion_<?php echo $undergraduate->id; ?>">
		<div class="panel panel-default">
				  
			<div class="panel-heading">
				<h4 class="panel-title">
				<?php 				
					$core_competency1=array();
					$pslos_core_competency1 = get_pslos_core_competency_h($department_id,$undergraduate->id);
					  
					if(isset($pslos_core_competency1->core_competency_id) && $pslos_core_competency1->core_competency_id!=''){
						$core_competency_details1 = explode(',',$pslos_core_competency1->core_competency_id);
						sort($core_competency_details1);
						for($i=0;$i<count($core_competency_details1);$i++){
							
							$core_competency_title1 = get_core_competency_title_h($core_competency_details1[$i]);
							$core_competency1[] = '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst($core_competency_title1).'.">CC'.$core_competency_details1[$i].'</span>';
							//$core_competency1[] = 'CC'.$core_competency_details1[$i];
						}
						$cc_data = '<h5 class="ccshow">'.implode(',  ',$core_competency1).'</h5>';
					}else{
						$cc_data = '';
					}					
				?>
					<a data-toggle="collapse" data-parent="#accordion_<?php echo $undergraduate->id; ?>" href="#collapse_<?php echo $undergraduate->id; ?>"><?php if(isset($undergraduate->plso_title) && $undergraduate->plso_title!=''){echo ucfirst($undergraduate->plso_prefix.': '.$undergraduate->plso_title);}?> <b>(+)</b> <?php echo $cc_data;?></a>
				</h4>
			</div>
			<div id="collapse_<?php echo $undergraduate->id; ?>" class="panel-collapse collapse">
				
				<div class="panel-body" >
				<form method="POST" id="core_<?php echo $undergraduate->id; ?>" action="<?php echo base_url();?>envision/assign_core_competency">
					<input type="hidden" name="course_status" id="course_status" value="0" />
					<input type="hidden" name="department_pslos_id" id="department_pslos_id" value="<?php if(isset($undergraduate->id)&&$undergraduate->id!=''){echo $undergraduate->id;}?>" />

					<?php 
						if(isset($undergraduate->id)&& $undergraduate->id!=''){
						$pslos_id = $undergraduate->id;
						$competency_arr1 = get_assign_core_competency_detail_by_pslos_id($pslos_id);
						$competency_arr = explode(',',$competency_arr1);		
					}?>
					
					<?php foreach($core_competency_details as $competency){?>
					<div class="col-md-4" style="line-height: 20px; font-size: 17px; padding: 8px;">
					
						<input type="checkbox" <?php if(in_array($competency->id, $competency_arr)){ ?> checked="checked" <?php } ?>  name="core_competency_id[]" id="core_competency_id" value="<?php if(isset($competency->id)&&$competency->id!=''){echo $competency->id;}?>" />	&nbsp;				
						<?php if(isset($competency->name)&&$competency->name!=''){echo ucfirst($competency->name);} ?>
					</div>	                
					<?php } ?>
					<div class="clearfix"></div>
					<div class="col-md-12">
						<div class="form-group">
							<input type="submit" class="btn btn-primary" name="assign_competency" value="Save & Update" style=" margin-top:15px;" />
						</div> 
					</div>
				</form>
				</div>

			</div>
		</div>
		</div>
		</div>
		<?php $j++;} }else{ echo '<h4 class="padding10"><i>-- no learning outcome available for undergraduate --</i> <a href="'.base_url().'department/envision/action2?tab_id=3" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add PSLOS Now!</a></h4>'; } ?>
	</div>
	</div>
		
		
		
	<div id="Graduates" class="subcontent margin20" style="display: <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>;">	
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Graduates PSLOS: </h3>
		</div>
		<span style="font-size:17px;">Please click the <b>(+)</b> to align your outcomes with core competencies.</span>
		<?php if(count($department_pslos_graduate)>0){ $k=1; foreach($department_pslos_graduate as $graduate){?>
		<div class="bs-example">
		<div class="panel-group" id="accordion_<?php echo $graduate->id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<?php 				
					$core_competency1=array();
					$pslos_core_competency1 = get_pslos_core_competency_h($department_id,$graduate->id);
					  
					if(isset($pslos_core_competency1->core_competency_id) && $pslos_core_competency1->core_competency_id!=''){
						$core_competency_details1 = explode(',',$pslos_core_competency1->core_competency_id);
						sort($core_competency_details1);
						for($i=0;$i<count($core_competency_details1);$i++){
							
							$core_competency_title1 = get_core_competency_title_h($core_competency_details1[$i]);
							$core_competency1[] = '<span data-toggle="tooltip" data-placement="top" title="'.ucfirst($core_competency_title1).'.">CC'.$core_competency_details1[$i].'</span>';
							//$core_competency1[] = 'CC'.$core_competency_details1[$i];
						}
						$cc_data = '<h5 class="ccshow">'.implode(',  ',$core_competency1).'</h5>';
					}else{
						$cc_data = '';
					}					
				?>
				
					<a data-toggle="collapse" data-parent="#accordion_<?php echo $graduate->id; ?>" href="#collapse_<?php echo $graduate->id; ?>"><?php if(isset($graduate->plso_title) && $graduate->plso_title!=''){echo ucfirst($graduate->plso_prefix.': '.$graduate->plso_title);}?> <b>(+)</b> <?php echo $cc_data;?></a>
				</h4>
			</div>

			<div id="collapse_<?php echo $graduate->id; ?>" class="panel-collapse collapse">
				<div class="panel-body" >
				<form method="POST" id="core_<?php echo $graduate->id; ?>" action="<?php echo base_url();?>envision/assign_core_competency">
					<input type="hidden" name="course_status" id="course_status" value="1" />
					<input type="hidden" name="department_pslos_id" id="department_pslos_id" value="<?php if(isset($graduate->id)&&$graduate->id!=''){echo $graduate->id;}?>" />

						<?php
							if(isset($graduate->id)&& $graduate->id!=''){
							$pslos_id = $graduate->id;
							$competency_arr1 = get_assign_core_competency_detail_by_pslos_id($pslos_id);
							$competency_arr = explode(',',$competency_arr1);	
						}?>
					
					<?php foreach($core_competency_details as $competency){?>
					<div class="col-md-4" style="line-height: 20px; font-size: 17px; padding: 8px;">
						<input type="checkbox" <?php if(in_array($competency->id, $competency_arr)){ ?> checked="checked" <?php } ?>  name="core_competency_id[]" id="core_competency_id" value="<?php if(isset($competency->id)&&$competency->id!=''){echo $competency->id;}?>" />	&nbsp;				
						<?php if(isset($competency->name)&&$competency->name!=''){echo ucfirst($competency->name);} ?>
					</div>	                
					<?php } ?>
					<div class="clearfix"></div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" name="assign_competency" value="Save & Update" style=" margin-top:15px;" />
					</div> 
				</form>
				</div>
			</div>
		</div>
		</div>
		</div>
	<?php $k++; } }else{ echo '<h4 class="padding10"><i>-- no learning outcome available for graduate --</i> <a href="'.base_url().'department/envision/action2?tab_id=4" class="btn btn-default" style="padding:3px 7px; font-size:15px;"> Add PSLOS Now!</a></h4>'; }?>
	</div>
	</div>
		
	<div id="program_learning_outcomes" class="subcontent margin20" style="display: <?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'block';}else{echo 'none';}?>;">	
		<?php include(APPPATH.'views/Frontend/envision/plo_tab.php');?>	
	</div>
		
</div> 

</div><div class="clearfix"></div> <br />
<div class="box-footer">
		<div class="pull-right">
			<a href="<?php echo base_url();?>department/envision/action1" class="btn btn-info"><< Previous Action1</a>
			<a href="<?php echo base_url();?>department/envision/action2" class="btn btn-info"><< Previous Action2</a>
		</div>
	</div>                		                            