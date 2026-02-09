
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> PLO Competencies: </h3>
		</div>
		<span style="font-size:17px;">Please click the <b>(+)</b> to align your outcomes with core competencies.</span>
		<?php if(count($program_learning_outcomes_data)>0){ $k=1; foreach($program_learning_outcomes_data as $ploData){?>
		<div class="bs-example">
		<div class="panel-group" id="accordion_<?php echo $ploData->id; ?>">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<?php 				
					$core_competency1=array();
					$pslos_core_competency1 = get_pslos_core_competency_h($department_id,$ploData->id);
					  
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
				
					<a data-toggle="collapse" data-parent="#accordion_<?php echo $ploData->id; ?>" href="#collapse_<?php echo $ploData->id; ?>"><?php if(isset($ploData->plso_title) && $ploData->plso_title!=''){echo ucfirst($ploData->plso_prefix.': '.$ploData->plso_title);}?> <b>(+)</b> <?php echo $cc_data;?></a>
				</h4>
			</div>

			<div id="collapse_<?php echo $ploData->id; ?>" class="panel-collapse collapse">
				<div class="panel-body" >
				<form method="POST" id="core_<?php echo $ploData->id; ?>" action="<?php echo base_url();?>envision/assign_core_competency">
					<input type="hidden" name="course_status" id="course_status" value="2" />
					<input type="hidden" name="department_pslos_id" id="department_pslos_id" value="<?php if(isset($ploData->id)&&$ploData->id!=''){echo $ploData->id;}?>" />

						<?php
							if(isset($ploData->id)&& $ploData->id!=''){
							$pslos_id = $ploData->id;
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
	<?php $k++; } }else{ echo '<h4 class="padding10"><i>-- no learning outcome available --</i> <a href="'.base_url().'department/envision/action2?tab_id=5" class="btn btn-default" style="padding:4px 15px; font-size:15px;"> Add Program Learning Outcome Now!</a></h4>'; }?>
	</div>