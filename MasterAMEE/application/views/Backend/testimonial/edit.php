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
					<input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="<?php if(!empty($testimonial_details->name)){echo $testimonial_details->name;} else{echo ""; }?>"  >
					<span style="color:red;"><?php echo form_error('name'); ?></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Designation*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="designation" name="designation" placeholder="Designation" value="<?php if(!empty($testimonial_details->designation)){echo $testimonial_details->designation;} else{echo ""; }?>"  >
					<span style="color:red;"><?php echo form_error('designation'); ?></span>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Message*</label>
				<div class="col-sm-9">
					<textarea class="form-control required" id="content" rows="5" name="content"><?php if(!empty($testimonial_details->content)){echo $testimonial_details->content;} else{echo ""; }?></textarea>
					<span style="color:red;"><?php echo form_error('content'); ?></span>
				</div>
			</div>			
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Status*</label>
				<div class="col-sm-9">
					<select class="form-control required" id="is_status" name="is_status">
						<option value="0" <?php if(isset($testimonial_details->is_status) && $testimonial_details->is_status=='0'){ ?> selected="selected" <?php }?> >Active</option>
						<option value="1" <?php if(isset($testimonial_details->is_status) && $testimonial_details->is_status=='1'){ ?> selected="selected" <?php }?> >Deactive</option>
					</select>	
				</div>
			 </div>
		</div>
			 	 
		<div class="col-md-4">		 
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Image</label>
				<div class="col-sm-9">
					<input type="file" name="photo"  onchange="readURL1(this);"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3"> </label>
				<div class="col-sm-9" style="float:left;">
				<?php if(isset($testimonial_details->image) && $testimonial_details->image!=''){?>
					<img id="blah1" src="<?php echo base_url();?>assets/backend/testimonial/<?php echo $testimonial_details->image; ?>" style="max-width:100%; float:left; max-height:100%; margin:auto;">
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
	  </form>
	</div> 
	<!--/.col (left) -->
	<!-- right column -->


	</div>
</section>



<script type="text/javascript">
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah')
               .attr('src', e.target.result)
                .width(200)
               .height(200);
               $('#blah').show();
               $('#blah1').hide();
        };
        reader.readAsDataURL(input.files[0]);
       }
</script>
