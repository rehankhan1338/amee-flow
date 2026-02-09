<section class="content">
<div class="row">
	
	<div class="col-md-12" >
	<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
	
		<div class="box-body">
			<div class="col-md-10">			 	
				 <input type="hidden" name="university" id="university" value="0" />	
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="inputEmail3"> Page Name*</label>
					<div class="col-sm-9">
						<select class="form-control required" id="page_name" name="page_name">
							<option value="">--select--</option>
							<option value="readiness">Readiness</option>
						</select>					
						<span style="color:red;"><?php echo form_error('page_name'); ?></span>
					</div>
				</div>	

				<div class="form-group">
					<label class="col-sm-3 control-label" for="inputEmail3">Purpose*</label>
					<div class="col-sm-9">
						<input type="text" class="form-control required" id="purpose" name="purpose" placeholder="Purpose" value="<?php echo set_value('purpose'); ?>"  >
						<span style="color:red;"><?php echo form_error('purpose'); ?></span>
					</div>
				</div>	
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label" for="inputEmail3">Title*</label>
					<div class="col-sm-9">
						<input type="text" class="form-control required" id="title" name="title" placeholder="Title" value="<?php echo set_value('title'); ?>"  >
						<span style="color:red;"><?php echo form_error('title'); ?></span>
					</div>
				</div>		

				<div class="form-group">
					<label class="col-sm-3 control-label" for="inputEmail3">Description*</label>
					<div class="col-sm-9">
						<textarea class="form-control required" id="description" name="description" rows="3" placeholder='Description'>Default Content</textarea>
						<span style="color:red;"><?php echo form_error('description'); ?></span>
					</div>
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
