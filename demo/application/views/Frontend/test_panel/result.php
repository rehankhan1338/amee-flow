<div class="col-md-12">
	<div class="welcome_div">	
		
		<?php 
			$point_sum = get_point_value_by_test_id($test_id);
			if(isset($point_sum->point_value)&& $point_sum->point_value!=''){
				$total_score = $point_sum->point_value;
				$percentage = ($test_answers_result*100)/$total_score;
			}else{
				$total_score = '0';
				$percentage = 0;
			}
		?>
		
		<?php if((isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self>0 && $test_auth_code_detail->rate_your_self!='') || (isset($test_auth_code_detail->post_rate_your_self) && $test_auth_code_detail->post_rate_your_self>0 && $test_auth_code_detail->post_rate_your_self!='')){?>
			<h1 class="title" style="padding:5px 0;"> Test Result </h1>	
			<div class="row">
				<div class="col-md-12">
					<div class="subrprtBox2" style="text-align:center;">
						<div class="rprtbox"><h3> Score: <b><?php if(isset($test_answers_result) && $test_answers_result!=''){ echo $test_answers_result;} else{ echo "0";}?> Out Of <?php echo $total_score;?></b></h3></div>
						<div class="rprtbox2 bgLightGreen"><h3>Percentage: <b><?php echo round($percentage,2);?>%</b></h3></div>
						<!--<div class="rprtbox3"><h3> Result:<b> PASS</b></h3></div>-->
					</div>
				</div>
			</div>
		<?php }else{ ?>
			<div class="row">
				<div class="form-group" style="text-align:center; margin-top:20px;">
					<label class="control-label" style=" font-size:22px;">Self-Rate! Please rate how well you think you scored on this test.</label>
				</div>
				<div class="form-group" style="text-align:center; margin-top:20px;">
					<a class="btn btn-success" onclick="return open_model_self_rate_add();"><i class="fa fa-star" aria-hidden="true"></i> Self-rate</a>
				</div>
			</div>
		
		<?php } ?>
 		
	 
	</div>
</div>
<?php if(isset($test_detail->self_rating) && $test_detail->self_rating==0){?>
<script type="text/javascript">
function open_model_self_rate_add(){
 	jQuery("#open_model_self_rate_add").modal('show');
}
</script>
<div class="modal fade" id="open_model_self_rate_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Self-Rate</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	
	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_self_pop" class="" action="<?php echo base_url();?>test_form/self_rating_save" enctype="multipart/form-data">
			
			<div class="col-md-12 instructions">Click the drop down box below and select an option. </div>
			<input type="hidden" id="h_current_test_type" name="h_current_test_type" value="<?php if(isset($test_detail->current_test_type)&&$test_detail->current_test_type!=''){echo $test_detail->current_test_type;}?>">
			<input type="hidden" id="h_test_code" name="h_test_code" value="<?php if(isset($test_detail->test_code) && $test_detail->test_code!=''){echo $test_detail->test_code;}?>">
			<input type="hidden" id="h_test_id" name="h_test_id" value="<?php if(isset($test_detail->test_id) && $test_detail->test_id!=''){echo $test_detail->test_id;}?>">
			<input type="hidden" name="h_auth_code" id="h_auth_code" value="<?php echo $auth_code;?>" />
			
 			<div class="form-group">
				<label class="control-label">Rate Your-Self *</label>
				<select class="form-control required" name="txt_rate_your_self" id="txt_rate_your_self">
					<option value="">--select--</option>
						<option value="1"<?php if(isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self==1){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column_1.' ('.$criterion_detail->oprf_column_1.'-'.$criterion_detail->oprf_column_sec_1.')';?></option>	
						<option value="2"<?php if(isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self==2){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column_2.' ('.$criterion_detail->oprf_column_2.'-'.$criterion_detail->oprf_column_sec_2.')';?></option>
						<option value="3"<?php if(isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self==3){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column_3.' ('.$criterion_detail->oprf_column_3.'-'.$criterion_detail->oprf_column_sec_3.')';?></option>
						<?php if(isset($criterion_detail->range_name_column_4) && $criterion_detail->range_name_column_4!=''){?>
						<option value="4"<?php if(isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self==4){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column_4.' ('.$criterion_detail->oprf_column_4.'-'.$criterion_detail->oprf_column_sec_4.')';?></option>
						<?php } if(isset($criterion_detail->range_name_column_5) && $criterion_detail->range_name_column_5!=''){?>
						<option value="5"<?php if(isset($test_auth_code_detail->rate_your_self) && $test_auth_code_detail->rate_your_self==5){ ?> selected="selected" <?php } ?>><?php echo $criterion_detail->range_name_column_5.' ('.$criterion_detail->oprf_column_5.'-'.$criterion_detail->oprf_column_sec_5.')';?></option>	
						<?php } ?>
				</select>
			</div>
 
 			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
			
		</form>
		
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>
<?php } ?>