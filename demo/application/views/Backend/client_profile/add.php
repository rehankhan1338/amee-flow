<section class="content">
<div class="row">
<div class="col-md-12" >

	<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		
		<div class="box-body">
		<div class="col-md-10">

			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">First Name*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php echo set_value('first_name');?>"  >
					<span style="color:red;"><?php echo form_error('first_name'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Last Name*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo set_value('last_name');?>"  >
					<span style="color:red;"><?php echo form_error('last_name'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Email*</label>
				<div class="col-sm-9">
					<input type="email" class="form-control required" id="email" name="email" placeholder="Email Address" value="<?php echo set_value('email');?>"  >
					<span style="color:red;"><?php echo form_error('email'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Phone*</label>
				<div class="col-sm-9">
					<input type="number" class="form-control required" id="phone" name="phone" placeholder="Phone Number" value="<?php echo set_value('phone');?>"  >
					<span style="color:red;"><?php echo form_error('phone'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Address*</label>
				<div class="col-sm-9">
					<textarea type="text" class="form-control required" id="address" name="address" placeholder="Address"><?php echo set_value('address');?></textarea>
					<span style="color:red;"><?php echo form_error('address'); ?></span>
				</div>
			</div>
			 
			<div class="form-group" id="js-rank">
				<label class="col-sm-3 control-label" for="inputEmail3">State*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="state" name="state" placeholder="State" value="<?php echo set_value('state');?>"  >
					<!--<select class="form-control required" id="state" name="state"> 
						<option value="">--Select state--</option>
						<option value="1">Mp</option>
						<option value="2">CG</option>
						<option value="3">AP</option>
						<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
							<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
						<?php //} ?>
					</select>-->
					<span style="color:red;"><?php echo form_error('state'); ?></span>
				</div>
			 </div> 
			 
			<div class="form-group" id="js-rank">
				<label class="col-sm-3 control-label" for="inputEmail3">City*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="city" name="city" placeholder="City" value="<?php echo set_value('city');?>"  >
					<!--<select class="form-control required" id="city" name="city"> 
						<option value="">--Select City--</option>
						<option value="1">Ujjain</option>
						<option value="2">Bhopal</option>
						<option value="3">Dewas</option>
						<!--<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
							<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
						<?php //} ?>
					</select>-->
					<span style="color:red;"><?php echo form_error('city'); ?></span>
				</div>
			 </div>
			 
			 <div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Zip Code*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="zip_code" name="zip_code" placeholder="Phone Number" value="<?php echo set_value('zip_code');?>"  >
					<span style="color:red;"><?php echo form_error('zip_code'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Name Of Organization*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="organization_name" name="organization_name" placeholder="Name of Organization" value="<?php echo set_value('organization_name');?>"  >
					<span style="color:red;"><?php echo form_error('organization_name'); ?></span>
				</div>
			</div>					
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Type Of Organization*</label>
				<div class="col-sm-9">
					<select class="form-control required" id="organization_type" name="organization_type"> 
						<option value="">--Select Type--</option>
						
						<?php  foreach ($master_organization_type as $orgtype) {?>
							<option value="<?php echo $orgtype->id;?>"><?php echo $orgtype->type;?></option>
						<?php } ?>
					</select>
					<span style="color:red;"><?php echo form_error('organization_type'); ?></span>
				</div>
			</div>		
			
			<!--<div class="form-group">
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