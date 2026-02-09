<?php include(APPPATH.'views/Frontend/analyze/action_sliderbar.php'); ?>

<div class="clearfix"></div>
<div class="survey_heading">
	<h3><?php 
	if(isset($_GET['loop']) && $_GET['loop']==1){echo $heading = 'Program Curriculum';}
	else if(isset($_GET['loop']) && $_GET['loop']==2){echo $heading = 'Academic Processes'; }
	else if(isset($_GET['loop']) && $_GET['loop']==3){echo $heading = 'Evaluation Plan'; }
	?></h3>
</div>
<div class="clearfix"></div>
<!--<div class="col-md-12 instructions"></div>-->
<div class="clearfix"></div>
<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>analyze/save_loops_description" id="frm" method="post" enctype="multipart/form-data">
	
	<?php if(isset($_GET['loop']) && $_GET['loop']!=''){?>
	<table class="table table-hover table-bordered">
		<thead>
			<tr class="trbg">
				<th class="survey_listing_td" style="vertical-align:middle;" nowrap="nowrap" colspan="2"><?php echo $heading;?></th> 
			</tr> 
		</thead>
 		<tbody>	
		<?php 
			$lable_status = $_GET['loop'];
			$closing_loops_detail = get_master_closing_loops_detail_by_status($lable_status);		
		
			foreach($closing_loops_detail as $loops_detail){?>	
			<tr>			
				<td style="font-weight:600;" width="40%"><?php echo $loops_detail->heading_label; ?></td>
 				<td>
				<?php 
				$loop_id = $loops_detail->id;
				$loops_descreption = get_analyze_loop_description_by_loopid($loop_id,$lable_status);?>
	
				<input type="hidden" name='h_loop_id[]' id='h_loop_id[]' value="<?php echo $loops_detail->id;?>">	
				<input type="hidden" name='h_loop_status' id='h_loop_status' value="<?php echo $_GET['loop'];?>">
				
				<textarea class="form-control" name='descreption_<?php echo $loops_detail->id;?>' id='descreption_<?php echo $loops_detail->id;?>' placeholder='Insert Details' rows="2"><?php if(isset($loops_descreption)&&$loops_descreption!=''){echo $loops_descreption;}else{echo '';}?></textarea>
				</td>
			</tr>	
		<?php } ?>	
		</tbody>
	
	<?php } ?>	
	</table>
	<div class="clearfix"></div>
	<div class="col-md-4"></div>
	<div class="col-md-4"><button type="submit" class="btn btn-primary" name="submit_login" style="width:100%;">Save and Update</button></div>
	<div class="col-md-4"></div>
	<div class="clearfix"></div>
</form>	
<div class="clearfix"></div>