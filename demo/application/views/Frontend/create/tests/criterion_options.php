<style type="text/css">
#test_criterion h4{ font-weight:600; font-size:16px;}
#test_criterion{ margin:0px 20px;}
#test_criterion img{padding:5px;}
.contenttitle2{margin:20px 0;border-bottom: 2px dotted #FB9337;}
.criterion_option_box{border: 1px solid #e3dbdb; width: 100%; height: 380px; padding: 15px;}
td{padding: 10px;}
textarea{resize:none;}
.trbg .error {color: #d5706e;}
.nxt_input{ display:inline-block; margin:10px auto;width: 30%;}
</style>

<div id="test_criterion" class="subcontent" >
	<?php $count_test_rating = get_count_test_rating_h($_GET['test_id']);?>
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>tests/save_criterion_option" enctype="multipart/form-data">
	<?php $criterion_details = get_test_criteion_details_h($_GET['test_id']);?>
	<div class="col-md-12">
		<div class="contenttitle2 nomargintop">
			<h3> Criterion Otions </h3>
		</div>
		<div class="col-md-12 instructions"><strong>INSTRUCTIONS:</strong> Select a criterion option from the dropdown box or create an option.</div>
		<?php if(isset($count_test_rating) && $count_test_rating>0){ ?>
		<div class="col-md-12 instructions"><strong>Note:</strong> You cannot edit criterion options because the test has already been completed by participants.</div>
		<?php } ?>
		<div class="col-md-12" style="margin:0; padding:0;">	
			<input type="hidden" name="hidden_test_id" id="hidden_test_id" value="<?php if(isset($_GET['test_id']) && $_GET['test_id']!=''){ echo $_GET['test_id'];}?>" />
			<input type="hidden" name="hidden_dept_id" id="hidden_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>" />		
		
			<table class="table table-bordered">
				<thead>
					<tr class="trbg">
						<td id="d_colspan" colspan="5">
							<h4 style="font-size:18px;">Criterion Option
								<?php if(isset($count_test_rating) && $count_test_rating==0){ ?>
								<select onchange="return apply_criterion_option_new(this.value,'<?php echo $_GET['test_id'];?>');" style="display:inline-block; margin-left:10px; width:auto;" name="option_id" id="option_id" class="form-control required">
									<option value="">-- select option -- </option>
									<option value="1" <?php if(isset($criterion_details->option_id) && $criterion_details->option_id==1){?> selected="selected" <?php } ?>>Criterion Option 1</option>
									<option value="2" <?php if(isset($criterion_details->option_id) && $criterion_details->option_id==2){?> selected="selected" <?php } ?>>Criterion Option 2</option>
									<option value="3" <?php if(isset($criterion_details->option_id) && $criterion_details->option_id==3){?> selected="selected" <?php } ?>>Criterion Option 3</option>
									<option value="4" <?php if(isset($criterion_details->option_id) && $criterion_details->option_id==4){?> selected="selected" <?php } ?>>Criterion Option 4</option>
									<option value="5" <?php if(isset($criterion_details->option_id) && $criterion_details->option_id==5){?> selected="selected" <?php } ?>>Criterion Option 5</option>
								</select>
								<?php }else{ ?>
								
									<input type="text" style="display:inline-block; margin-left:10px; width:auto;" name="hoption_id" id="hoption_id" class="form-control" value="Criterion Option <?php echo $criterion_details->option_id;?>" readonly="" />
								<?php } ?>
							</h4>
						</td>
					</tr>
				</thead>
				<tbody class="criterion_table">
					<tr style="text-align:center;">

						<td> 
							<input name="range_name_column_1" id="range_name_column_1" value="<?php if(isset($criterion_details->range_name_column_1) && $criterion_details->range_name_column_1!=''){echo $criterion_details->range_name_column_1;}?>" class="form-control required" placeholder="Option 1" type="text">
							<input name="oprf_column_1" id="oprf_column_1" value="<?php if(isset($criterion_details->oprf_column_1) && $criterion_details->oprf_column_1!=''){echo $criterion_details->oprf_column_1;}?>" class="form-control nxt_input required" placeholder="4" type="text"> 
							<b>&ndash;</b>
							<input name="oprf_column_sec_1" id="oprf_column_sec_1" value="<?php if(isset($criterion_details->oprf_column_sec_1) && $criterion_details->oprf_column_sec_1!=''){echo $criterion_details->oprf_column_sec_1;}?>" class="form-control nxt_input required" placeholder="4" type="text">
						</td>		
						
						<td>
							<input name="range_name_column_2" id="range_name_column_2" value="<?php if(isset($criterion_details->range_name_column_2) && $criterion_details->range_name_column_2!=''){echo $criterion_details->range_name_column_2;}?>" class="form-control required" placeholder="Option 2" type="text">
							<input name="oprf_column_2" id="oprf_column_2" value="<?php if(isset($criterion_details->oprf_column_2) && $criterion_details->oprf_column_2!=''){echo $criterion_details->oprf_column_2;}?>" class="form-control nxt_input required" placeholder="4" type="text"> 
							<b>&ndash;</b>
							<input name="oprf_column_sec_2" id="oprf_column_sec_2" value="<?php if(isset($criterion_details->oprf_column_sec_2) && $criterion_details->oprf_column_sec_2!=''){echo $criterion_details->oprf_column_sec_2;}?>" class="form-control nxt_input required" placeholder="4" type="text">
						</td>		
						
						<td>
							<input name="range_name_column_3" id="range_name_column_3" value="<?php if(isset($criterion_details->range_name_column_3) && $criterion_details->range_name_column_3!=''){echo $criterion_details->range_name_column_3;}?>" class="form-control required" placeholder="Option 3" type="text">
							<input name="oprf_column_3" id="oprf_column_3" value="<?php if(isset($criterion_details->oprf_column_3) && $criterion_details->oprf_column_3!=''){echo $criterion_details->oprf_column_3;}?>" class="form-control nxt_input required" placeholder="4" type="text"> 
							<b>&ndash;</b>
							<input name="oprf_column_sec_3" id="oprf_column_sec_3" value="<?php if(isset($criterion_details->oprf_column_sec_3) && $criterion_details->oprf_column_sec_3!=''){echo $criterion_details->oprf_column_sec_3;}?>" class="form-control nxt_input required" placeholder="4" type="text">
						</td>		
						
						<td>
							<input name="range_name_column_4" id="range_name_column_4" value="<?php if(isset($criterion_details->range_name_column_4) && $criterion_details->range_name_column_4!=''){echo $criterion_details->range_name_column_4;}?>" class="form-control required" placeholder="Option 4" type="text">
							<input name="oprf_column_4" id="oprf_column_4" value="<?php if(isset($criterion_details->oprf_column_4) && $criterion_details->oprf_column_4!=''){echo $criterion_details->oprf_column_4;}?>" class="form-control nxt_input required" placeholder="4" type="text"> 
							<b>&ndash;</b>
							<input name="oprf_column_sec_4" id="oprf_column_sec_4" value="<?php if(isset($criterion_details->oprf_column_sec_4) && $criterion_details->oprf_column_sec_4!=''){echo $criterion_details->oprf_column_sec_4;}?>" class="form-control nxt_input required" placeholder="4" type="text">
						</td>		
						
						<td>
							<input name="range_name_column_5" id="range_name_column_5" value="<?php if(isset($criterion_details->range_name_column_5) && $criterion_details->range_name_column_5!=''){echo $criterion_details->range_name_column_5;}?>" class="form-control required" placeholder="Option 5" type="text">
							<input name="oprf_column_5" id="oprf_column_5" value="<?php if(isset($criterion_details->oprf_column_5) && $criterion_details->oprf_column_5!=''){echo $criterion_details->oprf_column_5;}?>" class="form-control nxt_input required" placeholder="5" type="text"> 
							<b>&ndash;</b> 
							<input name="oprf_column_sec_5" id="oprf_column_sec_5" value="<?php if(isset($criterion_details->oprf_column_sec_5) && $criterion_details->oprf_column_sec_5!=''){echo $criterion_details->oprf_column_sec_5;}?>" class="form-control nxt_input required" placeholder="5" type="text">
						</td>
					
					</tr>
				</tbody>
				<?php if(isset($count_test_rating) && $count_test_rating==0){ ?>
				<tfoot colspan="5">
					<td><input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit"></td>
				</tfoot>
				<?php } ?>
			</table>		 
		 
			 
	</div>
	</div>

 	</form>		 
</div>
<div class="clearfix"></div>

<script type="text/javascript">
function apply_criterion_option_new(val,test_id){
	if(val!=''){
		$.ajax({url: "<?php echo base_url();?>tests/apply_criterion_option?test_id="+test_id+"&val="+val, 
			beforeSend: function(){ 
				$('.criterion_table').html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered" />');
			},
			success: function(result){ //alert(result);
				if(result!=''){
					$('.criterion_table').html(result);
				}
			}
		});
	}
}

 
</script>
