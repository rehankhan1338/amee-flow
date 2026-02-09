<style>
.rto{ padding-left:20px;}
.rto label{ display:block; line-height:25px;}
.rto label input{ margin-right:5px;}
</style>
 <form data-toggle="validator" class="" id="editFrm" method="post" action="" enctype="multipart/form-data">
		  
		 <div class="col-md-12">  <div class="box">
		 <?php
				  
				  	if(validation_errors() != false) { 
		
			echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; 
			
		}
				  ?> 
				  
				  	
		<div class="box-body">
		<div class="col-md-3">

			<div class="form-group">
				<label class="control-label" for="inputEmail3">Name of University / College *</label>
				
					<input type="text" class="form-control required" id="university_name" name="university_name" placeholder="Name of University/College" value="<?php if(isset($university_details->university_name) && $university_details->university_name!=''){ echo $university_details->university_name; }?>"  >
					<span style="color:red;"><?php echo form_error('university_name'); ?></span>
				
			</div>	
			  
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Address *</label>
				
					<input type="text" class="form-control required" id="address" name="address" value="<?php if(isset($university_details->address) && $university_details->address!=''){ echo $university_details->address; }?>" placeholder="Address" />
					<span style="color:red;"><?php echo form_error('address'); ?></span>
				</div>
			
			 
			<div class="form-group" id="js-rank">
				<label class="control-label" for="inputEmail3">State *</label>
				
					<input type="text" class="form-control required" id="state" name="state" placeholder="State" value="<?php if(isset($university_details->state) && $university_details->state!=''){ echo $university_details->state; }?>"  >
					 
					<span style="color:red;"><?php echo form_error('state'); ?></span>
				
			 </div> 
			 
			<div class="form-group" id="js-rank">
				<label class="control-label" for="inputEmail3">City *</label>
				
					<input type="text" class="form-control required" id="city" name="city" placeholder="City" value="<?php if(isset($university_details->city) && $university_details->city!=''){ echo $university_details->city; }?>"  >
				 
					<span style="color:red;"><?php echo form_error('city'); ?></span>
				
			 </div>
			 
			 <div class="form-group">
				<label class="control-label" for="inputEmail3">Zip Code *</label>
				
					<input type="text" class="form-control required" id="zip_code" name="zip_code" placeholder="Phone Number" value="<?php if(isset($university_details->zip_code) && $university_details->zip_code!=''){ echo $university_details->zip_code; }?>"  >
					<span style="color:red;"><?php echo form_error('zip_code'); ?></span>
				
			</div>
			
			

		</div>
		
		<div class="col-md-3">
		
			<div class="form-group">
								<label class="control-label" for="inputEmail3">First Name *</label>
								
									<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $university_details->first_name;?>"  >
								
							 </div>
							 
							 <div class="form-group">
								<label class="control-label" for="inputEmail3">Last Name *</label>
								
									<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $university_details->last_name;?>"  >
								
							 </div>
							  
							 
							 <div class="form-group">
								<label class="control-label" for="inputEmail3">Email *</label>
								
									<input type="text" class="form-control email required" id="email" name="email" placeholder="" value="<?php echo $university_details->email;?>"  >
								
							 </div>
							 
							 <div class="form-group">
				<label class="control-label" for="inputEmail3">Phone *</label>
				
					<input type="text" class="form-control required" id="phone" name="phone" placeholder="Phone Number" value="<?php echo $university_details->phone;?>"  >
					<span style="color:red;"><?php echo form_error('phone'); ?></span>
				 
			</div>
			
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Logo</label>
				
					<input type="file" name="logo"  onchange="readURL1(this);"/>
				
			</div>
			
			<div class="form-group">
				<div class="col-md-6">
 				<?php if(isset($session_details->logo) && $session_details->logo!=''){ ?>
				<img id="blah1" src="<?php echo base_url();?>assets/upload/profile_pic/<?php echo $session_details->logo;?>" class="img-responsive" alt="" />
				<?php }else{ ?>
				<img id="blah1" alt="" class="img-responsive" src="" />
				<?php } ?>
				</div>
			</div>
			
		</div>
		 
 				 <div class="col-md-3">
				  
				  		
							
							 
 							 <div class="form-group">
								<label class="control-label" for="inputEmail3">User Name / Login ID *</label>
								
									<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php echo $session_details->username;?>"  >
								
							 </div>
							 
							 <div class="form-group">
								<label class="control-label" for="inputEmail3">Password<br />(If you don't want to change, please leave blank)</label>
								
									 <input type="password" class="form-control" id="inputEmail3" name="password" placeholder="password">
								
							 </div>
							 
							 <div class="form-group">
								<label class="control-label" for="inputEmail3">Profile Pic (300*300)</label>
								
									<input type="file" onchange="readURL(this);" name="photo" id="userfile" /> 
								
							 </div>
							 
							 <div class="form-group">
								<label class="control-label" for="inputEmail3"> </label>
								
								<?php if($session_details->image==''){ ?>
									<img id="blah" alt="" class="img-responsive" src="<?php echo base_url();?>assets/upload/profile_pic/dummy_user.jpg"   />
								<?php }else{ ?>
									<img id="blah" src="<?php echo base_url();?>assets/upload/profile_pic/<?php echo $session_details->image;?>" class="img-responsive" alt="" />
								<?php } ?>
			  
 								
								</div>
				  
				  </div>
				  
				  <div class="col-md-3">
				  
				  	<div class="form-group">
						<label class="control-label" for="inputEmail3">Public Dashboard Title *</label>				
						<input type="text" class="form-control required" id="dashboardTitle" name="dashboardTitle" placeholder="Public Dashboard Title" value="<?php if(isset($university_details->dashboardTitle) && $university_details->dashboardTitle!=''){ echo $university_details->dashboardTitle; }?>"  >
						<span style="color:red;"><?php echo form_error('dashboardTitle'); ?></span>				
					</div>
					
					<?php if(isset($university_details->reportTypeOptions) && $university_details->reportTypeOptions!=''){
						$reportTypeOptionsArr = explode('||',$university_details->reportTypeOptions);
					}else{
						$reportTypeOptionsArr = array();
					}
					?>
					<div class="form-group">
						<label class="control-label" for="inputEmail3">Public Dashboard Options *</label>				
						<div class="rto">
							<label><input type="checkbox" value="survey" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array('survey',$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Survery</label>
							<label><input type="checkbox" value="test" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array('test',$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Test / Poll</label>
							<label><input type="checkbox" value="assignment" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array('assignment',$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Assignment</label>
							<label><input type="checkbox" value="1" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array(1,$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Demographics</label>
							<label><input type="checkbox" value="2" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array(2,$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Acceptance Rates</label>
							<label><input type="checkbox" value="3" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array(3,$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Placement Rates</label>
							<label><input type="checkbox" value="carrer_readiness" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array('carrer_readiness',$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> Career Readiness Assessment</label>
							<label><input type="checkbox" value="college_readiness" name="reportTypeOptions[]" id="reportTypeOptions" class="required" <?php if(in_array('college_readiness',$reportTypeOptionsArr)){ ?> checked="checked"<?php } ?> /> College Readiness Assessment</label>
						</div>			
					</div>
					
				  
				  </div>
				  <div class="clearfix"></div>
				  <div class="col-md-12">
				  	<div class="form-group">
						<label class="control-label" for="inputEmail3">Data Dashboard Access URL &ndash;</label><br />
						<?php 
							$PADurl = $this->config->item('PAD_URL').str_replace('_','',$university_details->sdTblPrefix).'/'.$university_details->encryptId;
						?>
						<a href="<?php echo $PADurl;?>" target="_blank"><?php echo $PADurl;?></a>
					</div>
				  </div>
				  <div class="clearfix"></div>
		
		</div> 
		  
		  
		<div class="box-footer" style="border-top: 1px dashed #ccc;">
			<button class="btn btn-primary" type="submit" style="padding:5px 30px; font-size:15px; font-weight:600;">Update Now!</button>
		</div> 
	</div>
	
   </div>
</form> 
<p>&nbsp;</p> 
<p>&nbsp;</p>
<script type="text/javascript">  
$(function(){
	$('#editFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		errorElement: 'label',
		errorClass: 'error',
		errorPlacement: function (error, element) {
			if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
				error.insertAfter(element.parent().parent());
			}else {
				error.insertAfter(element);
			}
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		}
	});
}); 
</script>