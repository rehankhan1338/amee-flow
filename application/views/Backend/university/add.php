<section class="content">
<div class="row">
<div class="col-md-12" >

	<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Name of University/College/Program *</label>
					<input type="text" class="form-control required" id="university_name" name="university_name" placeholder="Name of University/College/Program" value="<?php if(isset($_SESSION['sess_university_name']) && $_SESSION['sess_university_name']!=''){ echo $_SESSION['sess_university_name']; }else{ echo set_value('university_name'); }?>"  >
					<span style="color:red;"><?php echo form_error('university_name'); ?></span>
				</div>	
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Sub-domain Name *</label><br />
					 <input type="text" class="form-control required" value="<?php if(isset($_SESSION['sess_subdomain_name']) && $_SESSION['sess_subdomain_name']!=''){ echo $_SESSION['sess_subdomain_name']; }?>" id="subdomain_name" name="subdomain_name" placeholder="Subdomain Name" style="width:30%;display:inline-block; margin:0; " >
					 <input type="text" disabled="disabled" class="form-control" id="subdomain_namec" name="subdomain_namec" placeholder="" value=".<?php echo $this->config->item('site_domain'); ?>" readonly="" style="width:70%; display:inline-block;margin:-5px;padding:0 0 0 5px;" >
				 	<!--<div class="input-group">
						<input type="text" class="form-control required" id="subdomain_name" name="subdomain_name" placeholder="Subdomain Name" >
						<span class="input-group-addon">.<?php echo $this->config->item('site_domain'); ?></span>
					</div>-->	
				<span style="color:red;"><?php echo form_error('subdomain_name'); ?></span>
				</div>

				<div class="form-group">
					<label class="control-label" for="inputEmail3">Address *</label>
					<textarea type="text" class="form-control required" id="address" name="address" placeholder="Address"><?php if(isset($_SESSION['sess_address']) && $_SESSION['sess_address']!=''){ echo $_SESSION['sess_address']; }else{ echo set_value('address'); }?></textarea>
					<span style="color:red;"><?php echo form_error('address'); ?></span>
				</div>
				
				<div class="form-group" id="js-rank">
					<label class="control-label" for="inputEmail3">State *</label>
					<input type="text" class="form-control required" id="state" name="state" placeholder="State" value="<?php if(isset($_SESSION['sess_state']) && $_SESSION['sess_state']!=''){ echo $_SESSION['sess_state']; }else{ echo set_value('state');}?>"  >
					<!--<select class="form-control required" id="state" name="state"> 
						<option value="">--Select state--</option>
						<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
							<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
						<?php //} ?>
					</select>-->
					<span style="color:red;"><?php echo form_error('state'); ?></span>
				 </div> 
				 
				<div class="form-group" id="js-rank">
					<label class="control-label" for="inputEmail3">City *</label>
					<input type="text" class="form-control required" id="city" name="city" placeholder="City" value="<?php if(isset($_SESSION['sess_city']) && $_SESSION['sess_city']!=''){ echo $_SESSION['sess_city']; }else{ echo set_value('city');}?>"  >
					<!--<select class="form-control required" id="city" name="city"> 
						<option value="">--Select City--</option>
						<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
							<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
						<?php //} ?>
					</select>-->
					<span style="color:red;"><?php echo form_error('city'); ?></span>
				 </div>
				 
				 <div class="form-group">
					<label class="control-label" for="inputEmail3">Zip Code *</label>
					<input type="text" class="form-control required" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php if(isset($_SESSION['sess_zip_code']) && $_SESSION['sess_zip_code']!=''){ echo $_SESSION['sess_zip_code']; }else{ echo set_value('zip_code');}?>"  >
					<span style="color:red;"><?php echo form_error('zip_code'); ?></span>
				</div>
			</div>
			
			
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">First Name *</label>
					<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php if(isset($_SESSION['sess_first_name']) && $_SESSION['sess_first_name']!=''){ echo $_SESSION['sess_first_name']; }else{ echo set_value('first_name');}?>"  >
					<span style="color:red;"><?php echo form_error('first_name'); ?></span>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Last Name *</label>
					<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(isset($_SESSION['sess_last_name']) && $_SESSION['sess_last_name']!=''){ echo $_SESSION['sess_last_name']; }else{ echo set_value('last_name');}?>"  >
					<span style="color:red;"><?php echo form_error('last_name'); ?></span>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Email *</label>
					<input type="text" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php if(isset($_SESSION['sess_email']) && $_SESSION['sess_email']!=''){ echo $_SESSION['sess_email']; }else{ echo set_value('email');}?>"  >
					<span style="color:red;"><?php echo form_error('email'); ?></span>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Phone *</label>
					<input type="text" class="form-control required" id="phone" name="phone" placeholder="Phone Number" value="<?php if(isset($_SESSION['sess_phone']) && $_SESSION['sess_phone']!=''){ echo $_SESSION['sess_phone']; }else{ echo set_value('phone');}?>"  >
					<span style="color:red;"><?php echo form_error('phone'); ?></span>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Popup Message *</label>
					<select class="form-control required" id="popup_message" name="popup_message">
						<option value="0" <?php if(isset($_SESSION['sess_popup_message']) && $_SESSION['sess_popup_message']=='0'){ ?> selected="selected" <?php }?>>Default</option>
						<option value="1" <?php if(isset($_SESSION['sess_popup_message']) && $_SESSION['sess_popup_message']=='1'){ ?> selected="selected" <?php }?>>Custom</option>
					</select>	
					<span style="color:red;"><?php echo form_error('popup_message'); ?></span>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Logo</label>
					<input type="file" name="photo"  onchange="readURL(this);"/>
				</div>
				
				<div class="form-group">
					<img src="" alt="" id="blah" class="img-responsive" />
				</div>
			</div>
		</div> 
		  
		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	
	</div>
	</form>
</div>
</div>
</section>