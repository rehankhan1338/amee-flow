<div class="subcontent margin20">	
<!--<div class="col-md-12 instructions">
<strong>Instructions:</strong> Identify goals for each core function, then identify how you will assess the core function. Next, measure a 1 or more of the core functions. After results are collected, describe how the evaluation results from last year compare with the results from the previous year.
</div> -->
<style type="text/css">
.form-group label{margin-bottom: 5px;}
.contenttitle2{border-bottom: 2px dotted #FB9337;}
.input-group .error{position: absolute;float: left;padding-top: 35px;}
</style>		
	<div class="clearfix"></div>
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>assignments_rubrics/add_deadline" enctype="multipart/form-data">
		<div class="col-md-4" style="margin-bottom: 10px;">
			<div class="contenttitle2 nomargintop">
				<h3> submission deadline </h3>
			</div>
			<div class="col-md-12" style="margin:0; padding:0;">	
				<input type="hidden" name="hidden_ar_id" id="hidden_ar_id" value="<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!=''){ echo $_GET['ar_id'];}?>" />
				<input type="hidden" name="hidden_dept_id" id="hidden_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>" />		
			
				<div class="col-md-12">
					<div class="form-group">
						<label for="inputEmail3"><h4>Open Assignment</h4></label>
		                <div class='input-group date' id='datetimepicker1'>
		                    <input type='text' class="form-control required" name="start_date" value="<?php if(isset($assignments_rubrics_row->start_date) && $assignments_rubrics_row->start_date!=''){ echo date('m/d/Y h:i A', $assignments_rubrics_row->start_date);}?>"/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>			
		       	</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label for="inputEmail3"><h4>Close Assignment</h4></label>
		                <div class='input-group date' id='datetimepicker2'>
		                    <input type='text' class="form-control required" name="end_date" value="<?php if(isset($assignments_rubrics_row->end_date) && $assignments_rubrics_row->end_date!=''){ echo date('m/d/Y h:i A', $assignments_rubrics_row->end_date);}?>" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		        </div>		
			</div>
		</div>
		
		<div class="col-md-4" style="margin-bottom: 10px;">
			<div class="contenttitle2 nomargintop">
				<h3> Rater deadline </h3>
			</div>
			<div class="col-md-12" style="margin:0; padding:0;">	
				<div class="col-md-12">
					<div class="form-group">
						<label for="inputEmail3"><h4>Open Rating</h4></label>
		                <div class='input-group date' id='datetimepicker3'>
		                    <input type='text' class="form-control" name="open_rating" value="<?php if(isset($assignments_rubrics_row->open_rating) && $assignments_rubrics_row->open_rating!='' && $assignments_rubrics_row->open_rating!=0){ echo date('m/d/Y h:i A', $assignments_rubrics_row->open_rating);}?>"/>
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>			
		       	</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label for="inputEmail3"><h4>Close Rating</h4></label>
		                <div class='input-group date' id='datetimepicker4'>
		                    <input type='text' class="form-control" name="close_rating" value="<?php if(isset($assignments_rubrics_row->close_rating) && $assignments_rubrics_row->close_rating!='' && $assignments_rubrics_row->close_rating!=0){ echo date('m/d/Y h:i A', $assignments_rubrics_row->close_rating);}?>" />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
		            </div>
		        </div>		
			</div>
		</div>
		
		<div class="col-md-4" style="margin-bottom: 10px;">	
		
		<div class="contenttitle2 nomargintop">
				<h3> Time Limit </h3>
			</div>		
			<div  style="margin-bottom:5px;">
				<label for="inputEmail3"><h4> Time Limit Enable</h4></label>
				<input type="checkbox" onchange="checkbox_minutes_enable(this.value);" name="minutes_enable" id="minutes_enable" <?php if(isset($assignments_rubrics_row->minutes_enable)&& $assignments_rubrics_row->minutes_enable=='0'){?> checked="checked" <?php  } ?> value="0" style="margin-left:10px;"  />
			</div>
			
			<div class="form-group" id="time_box_open" <?php if(isset($assignments_rubrics_row->minutes_enable)&& $assignments_rubrics_row->minutes_enable!=0){?> style="display: none"; <?php }?> >
				 
				<div class="input-group">
					<input type="text" class="form-control <?php if(isset($assignments_rubrics_row->minutes_enable)&& $assignments_rubrics_row->minutes_enable==0){echo 'required';}?>" placeholder="" name="time_rubric" id="time_rubric" value="<?php if(isset($assignments_rubrics_row->time_rubric) && $assignments_rubrics_row->time_rubric!=''){ echo $assignments_rubrics_row->time_rubric;}?>" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2">Minutes</span>
				</div>
 
 			</div>							
		</div>		

		<div class="clearfix"></div>
		 
		<div class="col-md-12">	
			<input name="design_save" class="btn btn-primary" value="Save &amp; Update" type="submit">
 		</div>	
	</form>
</div>

<script type="text/javascript">
function checkbox_minutes_enable() { 
	if(jQuery('#minutes_enable').prop("checked") == true){
		jQuery('#time_rubric').addClass(" required ");
		jQuery('#time_box_open').show();			
	}else{
		jQuery('#time_rubric').removeClass(" required ");
		jQuery('#time_box_open').hide();	
	}
}
</script>