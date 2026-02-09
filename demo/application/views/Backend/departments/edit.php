<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >
<style>
.control-label{ font-weight:600;}
</style>
<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">

<!-- general form elements -->
<div class="box">
	<div class="box-body">
	<div class="col-md-10">
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Name of Department/Program *</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="department_name" name="department_name" placeholder="Name of Department/Program" value="<?php if(!empty($departments_details->department_name)){echo $departments_details->department_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('department_name'); ?></span>
			</div>
		</div>		
		
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Type *</label>
			<div class="col-sm-9">
				<select class="form-control required" id="department_type" name="department_type"> 
					<?php  foreach ($master_departments_type_detail as $dept_type) {?>
						<option value="<?php echo $dept_type->id;?>" <?php if(isset($departments_details->department_type) && $departments_details->department_type == $dept_type->id){ ?> selected="selected" <?php }?> ><?php echo $dept_type->txt_type.' '.$dept_type->txt_example;?></option>
					<?php } ?>
				</select>
				<span style="color:red;"><?php echo form_error('department_type'); ?></span>
			</div>
		</div>
	
			
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">First Name *</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php if(!empty($departments_details->first_name)){echo $departments_details->first_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('first_name'); ?></span>
			</div>
		</div>
				
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Last Name *</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php if(!empty($departments_details->last_name)){echo $departments_details->last_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('last_name'); ?></span>
			</div>
		</div>	
				
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Email *</label>
			<div class="col-sm-9">
				<input type="email" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php if(!empty($departments_details->email)){echo $departments_details->email;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('email'); ?></span>
			</div>
		</div>		
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">User Name *</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php if(!empty($departments_details->user_name)){echo $departments_details->user_name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('user_name'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Password <br>(If you don't want to change, please leave blank)</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" id="password" name="password" placeholder="Choose a password" value=""  >
				<span style="color:red;"><?php echo form_error('password'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
		<label class="col-sm-3 control-label" for="inputEmail3">Status *</label>
		<div class="col-sm-9">
			<select class="form-control required" id="status" name="status">
				<option value="1" <?php if(isset($departments_details->status) && $departments_details->status=='1'){ ?> selected="selected" <?php }?> >Active</option>
				<option value="0" <?php if(isset($departments_details->status) && $departments_details->status=='0'){ ?> selected="selected" <?php }?> >Deactive</option>
			</select>	
		</div>
		</div>
	</div>


	</div> 
  <div class="box-footer">
    <button class="btn btn-primary" type="submit" style="font-weight:600;">Update Now!</button>
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