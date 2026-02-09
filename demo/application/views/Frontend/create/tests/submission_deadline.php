<style type="text/css">
#survey_configuration h4{ font-weight:600; font-size:16px;}
#survey_configuration{ margin:0px 20px;}
.contenttitle2{margin:20px 0;border-bottom: 2px dotted #FB9337;}
.form-group label{margin-bottom: 5px; font-weight:600;}
.input-group .error{position: absolute;float: left;padding-top: 35px;}
</style>

<div id="survey_configuration" class="subcontent" >
	
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>tests/add_test_deadline" enctype="multipart/form-data">
	
<input type="hidden" name="hidden_test_id" id="hidden_test_id" value="<?php if(isset($_GET['test_id']) && $_GET['test_id']!=''){ echo $_GET['test_id'];}?>" />
<input type="hidden" name="hidden_dept_id" id="hidden_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>" />
		
	<div class="col-md-4">
		<div class="contenttitle2 nomargintop">
			<h3> submission deadline </h3>
		</div>
		<div class="col-md-12">	
 		 		 
				<?php if(isset($test_details->test_type) && $test_details->test_type==1){?>
				
				<div class="form-group">
					<label for="inputEmail3">Current Test Type</label>
	                <select class="form-control required" name="current_test_type">
						<option value="">--select--</option>
						<option value="1" <?php if(isset($test_details->current_test_type) && $test_details->current_test_type==1){?> selected="selected" <?php } ?> >Pre Test</option>
						<option value="2" <?php if(isset($test_details->current_test_type) && $test_details->current_test_type==2){?> selected="selected" <?php } ?> >Post Test</option>
 					</select>
	            </div>
				
				<?php }else{ ?>
					<input type="hidden" name="current_test_type" id="current_test_type"  value="3" />
				<?php } ?>
				
 				<div class="form-group" id="pre_one_time_start_date">
					<label for="inputEmail3"><?php if(isset($test_details->test_type) && $test_details->test_type==1){echo 'Pre Test';}?> Start Date</label>
	                <div class='input-group date' id='datetimepicker1'>
	                    <input type='text' class="form-control required" name="start_date" value="<?php if(isset($test_details->start_date) && $test_details->start_date!=''){ echo date('m/d/Y h:i A', $test_details->start_date);}?>"/>
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>			
       
				<div class="form-group"  id="pre_one_time_end_date">
					<label for="inputEmail3"><?php if(isset($test_details->test_type) && $test_details->test_type==1){echo 'Pre Test';}?> End Date</label>
	                <div class='input-group date' id='datetimepicker2'>
	                    <input type='text' class="form-control required" name="end_date" value="<?php if(isset($test_details->end_date) && $test_details->end_date!=''){ echo date('m/d/Y h:i A', $test_details->end_date);}?>" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div> 
				
				<?php if(isset($test_details->test_type) && $test_details->test_type==1){?>
				
				<div class="form-group" id="post_start_date">
					<label for="inputEmail3">Post Test Start Date</label>
	                <div class='input-group date' id='datetimepicker3'>
	                    <input type='text' class="form-control required" name="post_start_date" value="<?php if(isset($test_details->post_start_date) && $test_details->post_start_date!=''){ echo date('m/d/Y h:i A', $test_details->post_start_date);}?>"/>
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div>			
       
				<div class="form-group"  id="post_end_date">
					<label for="inputEmail3">Post Test End Date</label>
	                <div class='input-group date' id='datetimepicker4'>
	                    <input type='text' class="form-control required" name="post_end_date" value="<?php if(isset($test_details->post_end_date) && $test_details->post_end_date!=''){ echo date('m/d/Y h:i A', $test_details->post_end_date);}?>" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	            </div> 
				
				<?php } ?>
				
            </div>
		</div>
		
		
		<div class="col-md-4" style="margin-bottom: 10px;">	
		
		<div class="contenttitle2 nomargintop">
				<h3> Time Limit </h3>
			</div>		
			<div  class="form-group" style="margin-bottom:5px;">
				<label for="inputEmail3"> Time Limit Enable</label>
				<input type="checkbox" onchange="checkbox_apply_minutes(this.value);" name="minute_checkbox" value="0" id="minute_checkbox" <?php if(isset($test_details->time_limit_status)&& $test_details->time_limit_status=='0'){?> checked="checked" <?php } ?> style="margin-left:10px;"  />
			</div>
			
			<div class="form-group">
			<div class="input-group" id="minutes_input_show" <?php if(isset($test_details->time_limit_status)&& $test_details->time_limit_status!=0){?> style="display: none"; <?php }?> >
				<label for="inputEmail3"><h4></h4></label>
				<input type='text' class="form-control" name="time_limits" id="time_limits" placeholder="In Minutes" value="<?php if(isset($test_details->time_limits) && $test_details->time_limits!=''){ echo ($test_details->time_limits/60);}?>"/>
				<span class="input-group-addon" id="basic-addon2">Minutes</span>
			</div>
		</div>							
		</div>
		
			
            <div class="col-md-4">
			<div class="contenttitle2 nomargintop">
				<h3> Configuration </h3>
			</div>
				<div class="form-group">
					<label for="inputEmail3"> Questions per page</label>
	                <select class="form-control required" name="question_per_page">
	                	<option value=""> Choose </option>
	                	<?php for($i=1; $i<=10; $i++){?>
	                		<option value="<?php echo $i; ?>" <?php if(isset($test_details->question_per_page)&&$test_details->question_per_page==$i){?> selected="" <?php }?> > <?php echo $i; ?> </option>
	                	<?php }?>
	                </select>
            	</div>			
           	 
				<div class="form-group">
					<label for="inputEmail3">Student Self Rating</label>
					<input type="checkbox" name="self_rating" id="self_rating" <?php if(isset($test_details->self_rating)&& $test_details->self_rating=='0'){?> checked="checked" <?php } ?> value="0" style="margin-left:10px;"  />
				</div>
			</div>	
		 

	<div class="clearfix"></div>
	<div class="margin020">
		<input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit">
	</div>	
	</form>		 
</div>
<div class="clearfix"></div>



<script type="text/javascript">
function checkbox_apply_minutes() { 
	if(jQuery('#minute_checkbox').prop("checked") == true){
		jQuery('#minutes_input_show').show();	
	}else{		
		jQuery('#minutes_input_show').hide();		
	}
}
</script>
