<style>
.closingLoopAddYear h4{ margin-bottom:10px;}
.closingLoopAddYear label{ font-size:16px;}
.closingLoopAddYear .lbl{ display:block; padding-bottom:5px;}
.closingLoopAddYear .indiSec{ padding:5px 15px;}
.closingLoopAddYear form{ padding:10px;}
.closingLoopAddYear .panel-title{  margin-bottom:0}
.closingLoopAddYear .instructions p{ margin: 10px 0 0; line-height:25px;}
</style>
<script type="text/javascript">
function manageIndiField(inputId){
	if($('#popCase'+inputId).is(':checked')) {
		$('#popIndiVal'+inputId).show();
	}else{
		$('#popIndiVal'+inputId).hide();
	}
}
jQuery(function () {
	jQuery('#clYrFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#clYrFrm');
			var url = site_base_url+form.attr('action');
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#addYearBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var resultArr = result.split('||');
					if(resultArr[0]=='success'){
						window.location=site_base_url+'close_the_loop';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+resultArr[1]+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#addYearBtn').html('<?php echo $btnText;?>');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#addYearBtn').html('<?php echo $btnText;?>');
				}
			});		
			return false;
		}
	});
});
</script>

<div class="closingLoopAddYear">
	<div class="instructions"><strong>Instructions:</strong> Please click the (+) to select the option of indicators.
		<p>Closing the loop is the most difficult step in evaluating a program and it is typically where the assessment effort gets derailed. If the analysis is not compelling, stakeholders are unable to reach a consensus on which actions might be revealed by the data. Unable to even agree on a set of possible actions, no action is taken, and the program fails to "close the loop." </p>
		<p>Actions can be from major curriculum/training changes to increasing admission requirements and providing support structures such as tutoring or help sessions. Another action could be to reevaluate whether the learning outcomes for a training goal are appropriate.  </p>
		<p>To be successful at this step, create a closing-the-loop culture by using results to continuously improve. In other words, answer this question: How might your program use results to improve instruction/training, policy/programmatic changes, make decisions, and report on these improvements? Once a set of actions is identified below, create a strategic plan to implement them.</p>
	</div>
	<form method="post" id="clYrFrm" class="" action="<?php echo $form_action;?>">	
		<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
		<input type="hidden" id="h_loopId" name="h_loopId" value="<?php if(isset($loop_details->loopId) && $loop_details->loopId!=''){echo $loop_details->loopId;}else{echo '0';}?>" />
		<div id="resMsg"></div>		 
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>Title of the Year *</label>
					<input type="text" id="yearTitle" name="yearTitle" value="<?php if(isset($loop_details->yearTitle) && $loop_details->yearTitle!=''){echo $loop_details->yearTitle;}?>" class="form-control required" autocomplete="off" />
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label>Year *</label>
					<input type="text" id="add_year" name="add_year" placeholder="<?php echo date('Y');?>" value="<?php if(isset($loop_details->year) && $loop_details->year!=''){echo $loop_details->year;}?>" <?php if(isset($loop_details->year) && $loop_details->year!=''){?> readonly=""<?php }?> class="form-control number required" autocomplete="off" />
				</div>
			</div>
		</div>
		
		<?php for($loop=1;$loop<=3;$loop++){
			$lable_status=$loop;			
			$indicatorsListArr = filter_array_chk($indicatorMasters,$loop,'status');			
		?>
				<div class="panel-group" id="accordion<?php echo $loop;?>">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion<?php echo $loop;?>" href="#collapse<?php echo $loop;?>" aria-expanded="false"><?php if($lable_status==1){echo 'Program Curriculum';}else if($lable_status==2){echo 'Academic/Program Process';}else{echo 'Evaluation Plan';}?> <b>(+)</b></a>
						</h4>
					</div>
					<div id="collapse<?php echo $loop;?>" class="panel-collapse collapse " aria-expanded="false">
						<div class="panel-body">
							<?php foreach($indicatorsListArr as $indi){
								$indicatorId = $indi['id'];								
								$indiValArr = filter_array_chk($closing_loop_data_arr,$indicatorId,'indiOptId');						 
								
								?>	
								<div class="indiSec">		
									<label class="lbl"><input <?php if(count($indiValArr)>0){?> checked="checked"<?php } ?> type="checkbox" id="popCase<?php echo $indicatorId;?>" name="popCaseSel[]" value="<?php echo $indicatorId;?>" onclick="return manageIndiField('<?php echo $indicatorId;?>');" /> &nbsp;<?php echo $indi['heading_label'];?></label>
									<textarea id="popIndiVal<?php echo $indicatorId;?>" name="popIndiVal<?php echo $indicatorId;?>" style="display:<?php if(count($indiValArr)>0){echo 'block';}else{echo 'none';}?>;" placeholder="" class="form-control" rows="2"><?php if(count($indiValArr)>0){echo $indiValArr[0]['year_value'];}?></textarea>
									<input type="hidden" id="loopId<?php echo $indicatorId;?>" name="loopId<?php echo $indicatorId;?>" value="<?php echo $loop;?>" />
								</div>	
							<?php } ?>
						</div>
					</div>
				</div>	
				</div>
		<?php } ?>
		
		
		<hr />
		<div class="form-group">
			<button type="submit" class="btn btn-primary" id="addYearBtn"><?php echo $btnText;?></button>
		</div>
		
	</form>
</div>