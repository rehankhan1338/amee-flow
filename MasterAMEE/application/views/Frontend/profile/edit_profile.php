<div class="box">
	<div class="box-body margin20">
		<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
			 
				<?php if(validation_errors() != false) { 
					echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; 
				}?>
			 
	  
		<div class="col-md-7">			
			
		<!--	<div class="form-group">
				 
				<div class="contenttitle2" >
            	<h3 style="font-weight:600; letter-spacing:1px;"><?php //echo ucwords($dept_session_details->department_name);?> Department</h3>
            </div> 
				
			</div>	-->			
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">First Name*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control required" id="first_name" name="first_name" placeholder="First Name" value="<?php echo $dept_session_details->first_name;?>"  >
				</div>
			</div>		
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">Last Name*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control required" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $dept_session_details->last_name;?>"  >
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">Email*</label>
				<div class="col-sm-8">
					<input type="text" class="form-control email required" id="email" name="email" placeholder="" value="<?php echo $dept_session_details->email;?>"  >
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">Profile Pic</label>
				<div class="col-sm-8">
					<input type="file" onchange="readURL(this);" name="photo" id="userfile" /> 
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3"> </label>
				<div class="col-sm-8" >
					<img id="blah" src="<?php echo base_url();?>assets/upload/department/<?php echo $dept_session_details->image;?>" alt="" style=" max-width:100%;" />
				</div>
			</div>
		</div> 
		
		<div  style="clear:both;"></div>
	
		<div class="box-footer">
			<button type="submit" class="btn btn-primary" name="submit_login">Submit</button>
		</div>
	</form>
	</div>
	</div>

<script type="text/javascript">
 
function readURL(input) { 

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            jQuery('#blah')
                .attr('src', e.target.result);
                jQuery('#blah').show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
  