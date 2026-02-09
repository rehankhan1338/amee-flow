<section class="content">
<div class="row">
<div class="col-md-12" >

	<?php //echo validation_errors(); ?>

	<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		
		<div class="box-body">
		<div class="col-md-10">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3"> Name*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="name" name="name" placeholder="Name of Core Competency" value="<?php echo set_value('name'); ?>">
					<span style="color:red;"><?php echo form_error('name'); ?></span>
				</div>
			</div>
		</div>
		</div> 
		  
		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
		

	</form>
<!--/.col (left) -->
<!-- right column -->


</div>
<!--/.col (right) -->
</div>
      <!-- /.row -->	</div>
</section>