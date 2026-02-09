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
			<label class="col-sm-3 control-label" for="inputEmail3">First Name*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php if(!empty($client_profile_details->first_name)){echo $client_profile_details->first_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('first_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Last Name*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(!empty($client_profile_details->last_name)){echo $client_profile_details->last_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('last_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Email*</label>
			<div class="col-sm-9">
				<input type="email" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php if(!empty($client_profile_details->email)){echo $client_profile_details->email;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Phone*</label>
			<div class="col-sm-9">
				<input type="number" class="form-control required" id="phone" name="phone" placeholder="Phone Number" value="<?php if(!empty($client_profile_details->phone)){echo $client_profile_details->phone;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('phone'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Address*</label>
			<div class="col-sm-9">
				<textarea type="text" class="form-control required" id="address" name="address" placeholder="Address"><?php if(!empty($client_profile_details->address)){echo $client_profile_details->address;}else{echo '';} ?></textarea>
				<span style="color:red;"><?php echo form_error('address'); ?></span>
			</div>
		</div>
		 
		<div class="form-group" id="js-rank">
			<label class="col-sm-3 control-label" for="inputEmail3">State*</label>
			<div class="col-sm-9">
			<input type="text" class="form-control required" id="state" name="state" placeholder="State" value="<?php if(!empty($client_profile_details->state)){echo $client_profile_details->state;}else{echo '';} ?>">
				<!--<select class="form-control required" id="state" name="state"> 
					<option value="">--Select state--</option>
					<option value="1">Mp</option>
					<option value="2">CG</option>
					<option value="3">AP</option>
					<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>$client_profile_details->university_name
						<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
					<?php //} ?>
				</select>-->
				<span style="color:red;"><?php echo form_error('state'); ?></span>
			</div>
		 </div> 
		 
		<div class="form-group" id="js-rank">
			<label class="col-sm-3 control-label" for="inputEmail3">City*</label>
			<div class="col-sm-9">
			<input type="text" class="form-control required" id="city" name="city" placeholder="City" value="<?php if(!empty($client_profile_details->city)){echo $client_profile_details->city;}else{echo '';} ?>">  
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
			<label class="col-sm-3 control-label" for="inputEmail3">Zip Code*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="zip_code" name="zip_code" placeholder="Zip Code" value="<?php if(!empty($client_profile_details->zip_code)){echo $client_profile_details->zip_code;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('zip_code'); ?></span>
			</div>
		</div>
		
		<!--<div class="form-group" >
			<label class="col-sm-3 control-label" for="inputEmail3">Image*</label>
			<input type="file" name="photo"  onchange="readURL1(this);"/>
		</div>
		<div class="form-group">
		<label class="col-sm-3 control-label" for="inputEmail3">  </label>
			<?php if(isset($client_profile_details->image) && $client_profile_details->image!=''){?>
				<img id="blah1" src="<?php echo base_url();?>assets/university/<?php echo $client_profile_details->image; ?>">
			<?php }?>		
				<img src="" alt="" id="blah" class="img-responsive" />
		</div>-->
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Name of Organization*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="organization_name" name="organization_name" placeholder="Name of University/College" value="<?php if(!empty($client_profile_details->organization_name)){echo $client_profile_details->organization_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('organization_name'); ?></span>
			</div>
		</div>			
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Type of Organization*</label>
			<div class="col-sm-9">
				<select class="form-control required" id="organization_type" name="organization_type"> 
					<?php  foreach ($master_organization_type as $orgtype) {?>
						<option value="<?php echo $orgtype->id;?>" <?php if(isset($client_profile_details->organization_type)&& $client_profile_details->organization_type==$orgtype->id){?> selected="selected" <?php } ?>><?php echo $orgtype->type;?></option>
					<?php } ?>
				</select>
				<span style="color:red;"><?php echo form_error('organization_name'); ?></span>
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