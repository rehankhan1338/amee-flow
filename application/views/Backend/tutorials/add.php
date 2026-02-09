<section class="content">
<div class="row">
<div class="col-md-12" >

	<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		
		<div class="box-body">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Title*</label>
					<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php echo set_value('txt_title');?>"  >
					<span style="color:red;"><?php echo form_error('txt_title'); ?></span>
				</div>	
				
				<div class="form-group">
					<label class="control-label" for="inputEmail3">You-tube Link*</label>
					<input type="text" class="form-control required" id="txt_link" name="txt_link" placeholder="You-tube Link" value="<?php echo set_value('txt_link');?>"  >
					<span style="color:red;"><?php echo form_error('txt_link'); ?></span>
				</div>	
			</div>
			
			
			<div class="col-md-6">
				
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