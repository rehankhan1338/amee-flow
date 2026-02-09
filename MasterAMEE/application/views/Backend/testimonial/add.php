<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >

 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
 
  <!-- general form elements -->
	<div class="box">
	<div class="box-body">
		
		<div class="col-md-8">			 	
			 <div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Name*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="<?php echo set_value('name'); ?>"  >
					<span style="color:red;"><?php echo form_error('name'); ?></span>
				</div>
			 </div>		
			 
			 <div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Designation*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="designation" name="designation" placeholder="Designation" value="<?php echo set_value('designation'); ?>"  >
					<span style="color:red;"><?php echo form_error('designation'); ?></span>
				</div>
			 </div>		
			 
			 <div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Message*</label>
				<div class="col-sm-9">
					<textarea class="form-control required" id="content" name="content" rows="5" placeholder='Content'><?php echo set_value('content'); ?></textarea>
					<span style="color:red;"><?php echo form_error('content'); ?></span>
				</div>
			 </div>			 
						 
			 <div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Status*</label>
				<div class="col-sm-9">
					<select class="form-control required" id="is_status" name="is_status">
						<option value="0">Active</option>
						<option value="1">Deactive</option>
					</select>	
					<span style="color:red;"><?php echo form_error('is_status'); ?></span>
				</div>
			 </div>
		</div>
			 
		<div class="col-md-4">		 
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Image</label>
				<div class="col-sm-9">
					<input type="file" onchange="readURL(this);" name="photo" id="userfile" /> 
				</div>
			</div>
			 

			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3"> </label>
				<div class="col-sm-9" style="float:left;">
					<img id="blah" src="#" alt="" style=" max-width:100%; float:left; max-height:100%; margin:auto; display:block;" />
				</div>
			</div>
		</div>
		
	</div> 
	
		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	</div> </form>
<!--/.col (left) -->
<!-- right column -->
 

</div>
<!--/.col (right) -->
</div>
      <!-- /.row -->
</section>


<script type="text/javascript">
$('#blah').hide();
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                   .attr('src', e.target.result)
                    .width(200)
                   .height(200);
                   $('#blah').show();
            };
            reader.readAsDataURL(input.files[0]);
           }
</script>