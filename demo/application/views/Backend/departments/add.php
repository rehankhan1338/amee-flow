<section class="content">
<div class="row">
<div class="col-md-12" >
<style>
.control-label{ font-weight:600;}
</style>
	<?php //echo validation_errors(); ?>

	<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		
		<div class="box-body">
		<div class="col-md-10">

			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Name of Department/Program *</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="department_name" name="department_name" placeholder="Name of Department/Program" value="<?php if(isset($pre_department_name) && $pre_department_name!='') { echo $pre_department_name;}else{echo set_value('department_name');} ?>"  >
					<span style="color:red;"><?php echo form_error('department_name'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Type *</label>
				<div class="col-sm-9">
					<select class="form-control required" id="department_type" name="department_type"> 
						<option value="">--Select Type--</option>
						<?php  foreach ($master_departments_type_detail as $dept_type) {?>
							<option value="<?php echo $dept_type->id;?>" <?php if(isset($pre_department_type) && $pre_department_type==$dept_type->id){ ?> selected="selected" <?php }?> ><?php echo $dept_type->txt_type.' '.$dept_type->txt_example;?></option>
						<?php } ?>
					</select>
					<span style="color:red;"><?php echo form_error('department_type'); ?></span>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">First Name *</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php if(isset($pre_first_name) && $pre_first_name!='') { echo $pre_first_name;}else{echo set_value('first_name');} ?>"  >
					<span style="color:red;"><?php echo form_error('first_name'); ?></span>
				</div>
			</div>
					
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Last Name *</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(isset($pre_last_name) && $pre_last_name!='') { echo $pre_last_name;}else{echo set_value('last_name');} ?>"  >
					<span style="color:red;"><?php echo form_error('last_name'); ?></span>
				</div>
			</div>	
					
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Email *</label>
				<div class="col-sm-9">
					<input type="email" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php if(isset($pre_department_name) && $pre_email!='') { echo $pre_email;}else{echo set_value('email');} ?>"  >
					<span style="color:red;"><?php echo form_error('email'); ?></span>
				</div>
			</div>	

			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">User Name *</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php if(isset($pre_user_name) && $pre_user_name!='') { echo $pre_user_name;}else{echo set_value('user_name');} ?>"  >
					<span style="color:red;"><?php echo form_error('user_name'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Password *</label>
				<div class="col-sm-9">
					<input type="password" class="form-control required" id="new_password" name="new_password" placeholder="Choose a password" value=""  >
					<span style="color:red;"><?php echo form_error('new_password'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Confirm Password *</label>
				<div class="col-sm-9">
					<input type="password" class="form-control required" id="confirm_password" name="confirm_password" placeholder="Confirm Password" value=""  >
				</div>
			</div>
			 
			<!--<div class="form-group" id="js-rank">
				<label class="col-sm-3 control-label" for="inputEmail3">State*</label>
				<div class="col-sm-9">
					<select class="form-control required" id="state" name="state"> 
						<option value="">--Select state--</option>
						<option value="1">Mp</option>
						<option value="2">CG</option>
						<option value="3">AP</option>
						<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
							<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
						<?php //} ?>
					</select>
					<span style="color:red;"><?php echo form_error('state'); ?></span>
				</div>
			 </div> 
		
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Image*</label>
				<div class="col-sm-9">
					<input type="file" name="photo"  onchange="readURL(this);"/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-9">
					<img src="" alt="" id="blah" class="img-responsive" />
				</div>
			</div>-->

		</div>
		</div> 
		  
		<div class="box-footer">
			<button class="btn btn-primary" type="submit" style="font-weight:600;">Submit Now!</button>
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