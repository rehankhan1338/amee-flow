<section class="content">
<style type="text/css">
img{max-width: 100% !important;}
</style>
<div class="box snapshot_page"> 
<div class="col-md-12">
 	<ul class="timeline">
 		<li>
			<label class="snapshot_page_title">Mission Statement / Modifications </label>
				<div class="timeline-item">
				<!--<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>-->
				<h3 class="timeline-header"><?php if(isset($unit_details->mission_statement_modifications) && $unit_details->mission_statement_modifications!=''){echo $unit_details->mission_statement_modifications;}?></h3>
			</div>
		</li>
 		<li>
			<label class="snapshot_page_title">Core Function / Modifications</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($unit_details->core_function_modifications) && $unit_details->core_function_modifications!=''){echo $unit_details->core_function_modifications;}?></h3>
				<div class="col-md-12">
			<table class="table table-bordered table-striped table_mar20">
				<?php if(count($unit_core_functions_details)>0){ ?>
				<thead>
					<tr class="trbg">
						<th>Core Function </th>
						<th width="60%">Strategic Priorities</th>
					</tr>
				</thead>
				<tbody>
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){
						$strategic_priorities_arr='';
						if(isset($unit_core_functions->strategic_priorities_id) && $unit_core_functions->strategic_priorities_id!=''){
 							$strategic_priorities_arr1 = explode(',',$unit_core_functions->strategic_priorities_id);
							if(count($strategic_priorities_arr1)>0){
								for($lp=0;$lp<count($strategic_priorities_arr1);$lp++){
									if(isset($strategic_priorities_arr1[$lp]) && $strategic_priorities_arr1[$lp]!=''){
										$strategic_priorities_arr[]=get_name_master_strategic_priorities_by_id_h($strategic_priorities_arr1[$lp]);
									}
								}
							}
  						}else{
							$strategic_priorities_arr[]='';
						}
						
						?>
 					<tr>
						<td style="vertical-align:middle;"><?php if(isset($unit_core_functions->core_functions) && $unit_core_functions->core_functions!=''){ echo ucfirst($unit_core_functions->core_functions);}?></td>
						<td><?php echo implode(' , &nbsp;&nbsp;',$strategic_priorities_arr);?></td> 
					</tr>
					<?php $j++;} ?>
				</tbody>
				<?php }else{ echo '<tr><td colspan="2"><i>-- no core funtion available --</i></td></tr>'; }  ?>
			</table>
			</div>
			</div>
			
		</li>
 		<li>
			<label class="snapshot_page_title">Evaluation Assessment</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($unit_details->year_to_year_comparisons) && $unit_details->year_to_year_comparisons!=''){echo $unit_details->year_to_year_comparisons;}?></h3>
				<div class="col-md-12">
				<table class="table table-bordered table-striped table_mar20">
				<?php if(count($unit_core_functions_details)>0){ ?>
				<thead>
					<tr class="trbg">
						<th>Core Function </th>
						<th width="30%">Goal</th>
						<th width="40%">Direct / Indirect Measure</th>
					</tr>
				</thead>
				<tbody>
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){
						$direct_indirect_measures_arr=array();
						if(isset($unit_core_functions->direct_measures) && $unit_core_functions->direct_measures!=''){
 							$direct_measures_arr1 = explode(',',$unit_core_functions->direct_measures);
							if(count($direct_measures_arr1)>0){
								for($lp=0;$lp<count($direct_measures_arr1);$lp++){
									if(isset($direct_measures_arr1[$lp]) && $direct_measures_arr1[$lp]!=''){
										$direct_measures_name = get_name_master_direct_measures_by_id_h($direct_measures_arr1[$lp]);
										if(isset($direct_measures_name) && $direct_measures_name!=''){
											$direct_indirect_measures_arr[]=$direct_measures_name;
										}
									}
								}
							}
  						} 
						if(isset($unit_core_functions->indirect_measures) && $unit_core_functions->indirect_measures!=''){
 							$indirect_measures_arr1 = explode(',',$unit_core_functions->indirect_measures);
							if(count($indirect_measures_arr1)>0){
								for($lp=0;$lp<count($indirect_measures_arr1);$lp++){
									if(isset($indirect_measures_arr1[$lp]) && $indirect_measures_arr1[$lp]!=''){
										$indirect_measures_name=get_name_master_indirect_measures_by_id_h($indirect_measures_arr1[$lp]);
										if(isset($indirect_measures_name) && $indirect_measures_name!=''){
											$direct_indirect_measures_arr[]=$indirect_measures_name;
										}
									}
								}
							}
  						}
						
						?>
 					<tr>
						<td style="vertical-align:middle;"><?php if(isset($unit_core_functions->core_functions) && $unit_core_functions->core_functions!=''){ echo ucfirst($unit_core_functions->core_functions);}?></td>
						<td style="vertical-align:middle;"><?php if(isset($unit_core_functions->goals) && $unit_core_functions->goals!=''){ echo ucfirst($unit_core_functions->goals);}?></td>
						<td><?php echo implode(' , &nbsp;&nbsp;',$direct_indirect_measures_arr);?></td> 
					</tr>
					<?php $j++;} ?>
				</tbody>
				<?php }else{ echo '<tr><td colspan="2"><i>-- no core funtion available --</i></td></tr>'; }  ?>
			</table>
			</div>
			</div>
		</li>
		<li>
			<label class="snapshot_page_title">Discuss Evaluation Results</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($unit_details->discuss_of_evaluation_result) && $unit_details->discuss_of_evaluation_result!=''){echo $unit_details->discuss_of_evaluation_result;}?></h3>
				<div class="col-md-12">
			<table class="table table-bordered table-striped table_mar20">
				<?php if(count($unit_core_functions_details)>0){ ?>
				<thead>
					<tr class="trbg">
						<th>Goal</th>
						<th width="60%">Actions for Improvement</th>
					</tr>
				</thead>
				<tbody>
					<?php $j=1; foreach($unit_core_functions_details as $unit_core_functions){
 						?>
 					<tr>
						<td style="vertical-align:middle;"><?php if(isset($unit_core_functions->goals) && $unit_core_functions->goals!=''){ echo ucfirst($unit_core_functions->goals);}?></td>
						<td style="vertical-align:middle;"><?php if(isset($unit_core_functions->actions_for_improvement) && $unit_core_functions->actions_for_improvement!=''){ echo ucfirst($unit_core_functions->actions_for_improvement);}?></td>
					</tr>
					<?php $j++;} ?>
				</tbody>
				<?php }else{ echo '<tr><td colspan="2"><i>-- no core funtion available --</i></td></tr>'; }  ?>
			</table>
			</div>
 			</div>
 		</li>
		<li>
			<label class="snapshot_page_title">Management of Finances / Human Resources</label>
			<div class="timeline-item">
				<h3 class="timeline-header"><?php if(isset($unit_details->management_of_finance_hr) && $unit_details->management_of_finance_hr!=''){echo $unit_details->management_of_finance_hr;}?></h3>
 			</div>
 		</li> 
		 
		<li>
			<label class="snapshot_page_title">Your Feedback's</label>
			<div class="timeline-item">
				
					<?php if(count($department_feedback)>0){
					$kl=1; foreach($department_feedback as $feedback_details){?>
					<div class="col-md-12">
						 
						
 							<div class="col-md-10">
								<blockquote class="">
									<p><?php echo $feedback_details->feedback;?></p>
									<small><?php echo date('m/d/Y h:i A',$feedback_details->add_date);?></small>
								</blockquote>
							</div>
							<div class="col-md-2"></div>
							
						 
					</div>	
					<?php $kl++; }} ?>
				<form method="post" id="frm" action="<?php echo base_url();?>admin/snapshot/feedback_save">
					<div class="col-md-12 form-group" style="width: 96%;">
						<label style="font-weight:600;">Great! Any Other Feedback?</label>
						<input type="hidden" name="h_department_id" id="h_department_id" value="<?php echo $department_id;?>" />
						<textarea class="form-control required" name="feedback_txt" id="feedback_txt" rows="5"></textarea>
					</div>
					<div class="col-md-4"></div>
					<div class="col-md-4"><button class="btn btn-primary" type="submit" style="width:100%; margin:15px 0;">Submit</button></div>
					<div class="col-md-4"></div>
				</form>
			</div>
		</li>
 	</ul>



</div>	
</div>
</section>