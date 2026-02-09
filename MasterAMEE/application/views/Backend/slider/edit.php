<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12">
  <!-- general form elements form-horizontal-->

	<div class="box">
	<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box-body">        
        <p id="ret"><?php if(validation_errors() != false) { echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; } ?></p>
		  		 
		<div class="col-md-12">
			<div class="form-group" >
				<label >Title*</label>
				<input type="text" class="form-control required" id="txt_title" name="txt_title" value="<?php if(!empty($slider_details->title)){echo $slider_details->title;} else{echo ""; }?>"  >
			</div>
			
			<div class="form-group" >
				<label >Sub-Title*</label>
				<input type="text" class="form-control required" id="txt_subtitle" name="txt_subtitle" value="<?php if(!empty($slider_details->sub_title)){echo $slider_details->sub_title;} else{echo ""; }?>"  >
			</div>
			
			<div class="form-group" >
				<label>Image*</label>
				<input type="file" name="photo"  onchange="readURL1(this);"/>
			</div>
			
			<div class="form-group">
				<?php if(isset($slider_details->image) && $slider_details->image!=''){?>
					<img id="blah1" src="<?php echo base_url();?>assets/homeslider/<?php echo $slider_details->image; ?>">
				<?php }?>		
					<img src="" alt="" id="blah" class="img-responsive" />
			</div>
		</div>
	</div>
	
		<div class="box-footer">
			<button type="submit" class="btn btn-primary" name="submit_login">Submit</button>
		</div>
		
    </form>
	</div>
</div>
</div>
</section>