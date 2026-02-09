<input type="hidden" id="adm_organizationId" name="adm_organizationId" value="<?php echo $orgainzation_details->organizationId; ?>" />
<input type="hidden" id="adm_organizationType" name="adm_organizationType" value="<?php echo $orgainzation_details->organizationType; ?>" />
<input type="hidden" id="adm_expire_date" name="adm_expire_date" value="<?php echo $orgainzation_details->expire_date; ?>" />
<input type="hidden" id="adm_membersCnt" name="adm_membersCnt" value="<?php echo $orgainzation_details->membersCnt; ?>" />
<input type="hidden" id="h_memberId" name="h_memberId" value="<?php if(isset($member_details->memberId) && $member_details->memberId!=''){echo $member_details->memberId;}else{echo '0';}?>" />

<div class="row">
	<div id="result_display"></div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<div class="mb-3">
				<label for="firstname" class="control-label">First Name *</label>
				<input type="text" class="form-control required" id="firstName" name="firstName" placeholder="First Name" autocomplete="off" value="<?php if(isset($member_details->firstName) && $member_details->firstName!=''){echo $member_details->firstName;}?>" />
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="form-group">
			<div class="mb-3">
				<label for="lastname" class="control-label">Last Name *</label>
				<input type="text" class="form-control required" id="lastName" name="lastName" placeholder="Last Name" autocomplete="off" value="<?php if(isset($member_details->lastName) && $member_details->lastName!=''){echo $member_details->lastName;}?>"  />
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6 mb-3">
		<div class="form-group">
			<label for="email" class="control-label">Email ID / Login ID *</label>
			<input type="text" class="form-control email required" id="emailAddress" name="emailAddress" placeholder="Email"  autocomplete="off" value="<?php if(isset($member_details->email) && $member_details->email!=''){echo $member_details->email;}?>" />
		</div>
	</div>
	<div class="col-lg-6 mb-3">
		<div class="form-group">
			<label for="contactno" class="control-label">Contact #</label>
			<input type="text" class="form-control" id="contactNo" name="contactNo" placeholder="Contact Number" autocomplete="off" value="<?php if(isset($member_details->contactNo) && $member_details->contactNo!=''){echo $member_details->contactNo;}?>" />
		</div>
	</div>
</div>

<?php if(isset($member_details->memberId) && $member_details->memberId!=''){?>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<div class="mb-3">
				<label for="address" class="control-label">Password <i>(If you don't want to change, please leave blank)</i></label>
				<input type="password" class="form-control" minlength="8" id="password" name="password" placeholder="New Password" autocomplete="off" value="" />
			</div>
		</div>
	</div>
</div>

<?php }else{ ?>
<div class="row">
	<div class="col-lg-6 mb-3">
		<div class="form-group">
			<label for="new_password" class="control-label">New Password *</label>
			<input type="password" class="form-control required" minlength="8" id="new_password" name="new_password" placeholder="New Password" autocomplete="off" value="" />
		</div>
	</div>
	<div class="col-lg-6 mb-3">
		<div class="form-group">
			<label for="confirm_password" class="control-label">Confirm Password *</label>
			<input type="password" class="form-control required" id="confirm_password" name="confirm_password" placeholder="Confirm Password" autocomplete="off" value="" />
		</div>
	</div>
</div>
<?php } ?>

<?php if($orgainzation_details->organizationType==2){?>
<div class="row">		 
	<div class="col-lg-12"><label class="control-label">Would you like to be on the sponsor list?</label></div>
	<div class="col-lg-12 mb-3">
		<label class="optLbl"><input type="radio" <?php if(isset($member_details->sponsorSts) && $member_details->sponsorSts==1){?>checked="checked"<?php } ?> name="sponsorSts" id="sponsorSts" value="1"  /> &nbsp;Yes</label>
		<label class="optLbl"><input type="radio" <?php if(isset($member_details->sponsorSts) && $member_details->sponsorSts==0){?>checked="checked"<?php } ?> name="sponsorSts" id="sponsorSts" value="0"  /> &nbsp;No</label>
	</div>               
</div>
<?php } ?>
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<div class="mb-3">
				<label for="address" class="control-label">What is your Role? *</label>
				<input type="text" class="form-control required" id="role" name="role" placeholder="i.e., assessment coordinator, director of..." autocomplete="off" value="<?php if(isset($member_details->role) && $member_details->role!=''){echo $member_details->role;}?>"  />
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 mb-3">
		<div class="form-group">
			<label for="address" class="control-label">Street Address *</label>
			<input type="text" class="form-control required" id="streetAddress" name="streetAddress" placeholder="Street Address" autocomplete="off" value="<?php if(isset($member_details->streetAddress) && $member_details->streetAddress!=''){echo $member_details->streetAddress;}?>" />
		</div>
	</div>						
</div>

<div class="row">
	<div class="col-lg-3 mb-3">
		<div class="form-group">
			<label for="regionId" class="control-label">Region *</label>
			<select class="form-control required" id="regionId" name="regionId">
				<option value="">Select...</option>
				<?php $region=$this->config->item('region_array_config');
				foreach($region as $key => $value){ if($value['status']==0){?>
				<option value="<?php echo $key;?>" <?php if(isset($member_details->regionId) && $member_details->regionId==$key){?> selected="selected"<?php } ?>><?php echo $value['name'];?></option>
				<?php } }?>
			</select>
		</div>
	</div>
	<div class="col-lg-3 mb-3">
		<div class="form-group">
			<label for="state" class="control-label">State *</label>
			<select class="form-control required" id="state" name="state">
				<option value="">Select...</option>
				<?php $usa_states_array_config=$this->config->item('usa_states_array_config');
				foreach($usa_states_array_config as $key => $value){ if($value['status']==0){?>
				<option value="<?php echo $value['name'];?>" <?php if(isset($member_details->state) && $member_details->state==$value['name']){?> selected="selected"<?php } ?>><?php echo $value['name'];?></option>
				<?php } }?>
			</select>
		</div>
	</div>
	<div class="col-lg-3 mb-3">
		<div class="form-group">
			<label for="city" class="control-label">City *</label>
			<input type="text" class="form-control required" id="city" name="city" placeholder="City" autocomplete="off" value="<?php if(isset($member_details->city) && $member_details->city!=''){echo $member_details->city;}?>" />
		</div>
	</div>
	<div class="col-lg-3 mb-3">
		<div class="form-group">
			<label for="zipCode" class="control-label">Zip Code *</label>
			<input type="text" class="form-control required" id="zipCode" name="zipCode" placeholder="Zip Code" autocomplete="off" value="<?php if(isset($member_details->zipCode) && $member_details->zipCode!=''){echo $member_details->zipCode;}?>" />
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-3 mb-3">
		<div class="form-group">
			<label for="isActive" class="control-label">Status</label>
			<select class="form-control" id="isActive" name="isActive">
				<option value="1" <?php if(isset($member_details->isActive) && $member_details->isActive==1){?> selected="selected"<?php } ?>>Active</option>
				<option value="0" <?php if(isset($member_details->isActive) && $member_details->isActive==0){?> selected="selected"<?php } ?>>In-active</option>
			</select>
		</div>
	</div>
</div>

<div class="row my-2">
	<div class="col-lg-12 mb-3">
		<div class="form-group my-4">
			<label class="control-label"><input type="checkbox" <?php if(isset($member_details->isDirectory) && $member_details->isDirectory==1){?>checked="checked"<?php } ?> name="isDirectory" id="isDirectory" value="1" /> &nbsp;I want my information to appear in the <strong>National Assessment Directory</strong> <i>(only subscribers will have access to the directory)</i>.</label>
		</div>
	</div>
</div>