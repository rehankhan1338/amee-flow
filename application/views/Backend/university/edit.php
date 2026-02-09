<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >

<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">

<!-- general form elements -->
<div class="box">
	<div class="box-body">
	<div class="col-md-10">

		 <div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">University/College/Program Name *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="university_name" name="university_name" placeholder="Name of University/College" value="<?php if(!empty($university_details->university_name)){echo $university_details->university_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('university_name'); ?></span>
			</div>
		</div>	
		
		 <div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Sub-domain Name *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" value="<?php if(!empty($university_details->subdomain_name)){echo $university_details->subdomain_name;}else{echo '';} ?>" id="subdomain_name" name="subdomain_name" placeholder="Subdomain Name" style="width:30%;display:inline-block; margin:0; " >
					<input type="text" disabled="disabled" class="form-control" id="subdomain_namec" name="subdomain_namec" placeholder="" value=".assessmentmadeeasy.com" readonly="" style="width:70%; display:inline-block;margin:-5px;padding:0 0 0 5px;" >
				<span style="color:red;"><?php echo form_error('subdomain_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">First Name*</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php if(!empty($university_details->first_name)){echo $university_details->first_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('first_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Last Name *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(!empty($university_details->last_name)){echo $university_details->last_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('last_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Email *</label>
			<div class="col-sm-8">
				<input type="email" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php if(!empty($university_details->email)){echo $university_details->email;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</div>
		</div>
		
		<!--<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Username for Admin Access *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="adminUsername" name="adminUsername" placeholder="Admin Access Username" value="<?php //if(!empty($university_details->email)){echo $university_details->email;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Password for Admin Access *</label>
			<div class="col-sm-8">
				<input type="password" class="form-control required" id="adminPassword" name="adminPassword" placeholder="Admin Access Password" value="<?php //if(!empty($university_details->email)){echo $university_details->email;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</div>
		</div>-->
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Phone *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="phone" name="phone" placeholder="Phone Number" value="<?php if(!empty($university_details->phone)){echo $university_details->phone;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('phone'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Address *</label>
			<div class="col-sm-8">
				<textarea type="text" class="form-control required" id="address" name="address" placeholder="Address"><?php if(!empty($university_details->address)){echo $university_details->address;}else{echo '';} ?></textarea>
				<span style="color:red;"><?php echo form_error('address'); ?></span>
			</div>
		</div>
		 
		<div class="form-group" id="js-rank">
			<label class="col-md-4 control-label" for="inputEmail3">State *</label>
			<div class="col-sm-8">
			<input type="text" class="form-control required" id="state" name="state" placeholder="State" value="<?php if(!empty($university_details->state)){echo $university_details->state;}else{echo '';} ?>">
				<!--<select class="form-control required" id="state" name="state"> 
					<option value="">--Select state--</option>
					<option value="1">Mp</option>
					<option value="2">CG</option>
					<option value="3">AP</option>
					<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>$university_details->university_name
						<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
					<?php //} ?>
				</select>-->
				<span style="color:red;"><?php echo form_error('state'); ?></span>
			</div>
		 </div> 
		 
		<div class="form-group" id="js-rank">
			<label class="col-md-4 control-label" for="inputEmail3">City *</label>
			<div class="col-sm-8">
			<input type="text" class="form-control required" id="city" name="city" placeholder="City" value="<?php if(!empty($university_details->city)){echo $university_details->city;}else{echo '';} ?>">  
				<!-- <select class="form-control required" id="city" name="city"> 
					<option value="">--Select City--</option>
					<option value="1">Ujjain</option>
					<option value="2">Bhopal</option>
					<option value="3">Dewas</option>
					<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
						<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
					<?php //} ?>
				</select> -->
				<span style="color:red;"><?php echo form_error('city'); ?></span>
			</div>
		 </div>
		 
		 <div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Zip Code *</label>
			<div class="col-sm-8">
				<input type="text" class="form-control required" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php if(!empty($university_details->zip_code)){echo $university_details->zip_code;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('zip_code'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-4 control-label" for="inputEmail3">Popup Message *</label>
			<div class="col-sm-8">
				<select class="form-control required" id="popup_message" name="popup_message">
					<option value="0" <?php if(isset($university_details->popup_message_status) && $university_details->popup_message_status=='0'){ ?> selected="selected" <?php }?>>Default</option>
					<option value="1" <?php if(isset($university_details->popup_message_status) && $university_details->popup_message_status=='1'){ ?> selected="selected" <?php }?>>Custom</option>
				</select>	
			</div>
			<span style="color:red;"><?php echo form_error('popup_message'); ?></span>
		</div>
		
		<div class="form-group" >
			<label class="col-md-4 control-label" for="inputEmail3">Image *</label>
			<div class="col-md-8" ><input type="file" name="photo"  onchange="readURL(this);"/></div>
		</div>
		
		<div class="form-group">
		<label class="col-md-4 control-label" for="inputEmail3">  </label>
		<div class="col-md-8" >
			<?php if(isset($university_details->image) && $university_details->image!=''){?>
				<img id="blah" src="<?php echo base_url();?>assets/upload/university/<?php echo $university_details->image; ?>" alt="" class="img-responsive" />
			<?php }else{?>		
				<img src="" alt="" id="blah" class="img-responsive" />
				<?php } ?>
				</div>
		</div>
	</div>


	</div> 
  <div class="box-footer">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
</form>
<!--/.col (left) -->
<!-- right column -->


</div>
<!--/.col (right) -->
</div>
      <!-- /.row -->
</section>