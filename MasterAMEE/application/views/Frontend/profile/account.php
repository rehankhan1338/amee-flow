<div class="box">
	<div class="box-body margin20">
		<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
			 
				<?php if(validation_errors() != false) { 
					echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; 
				}?>
			 
	  
		<div class="col-md-9">	
			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">User Name/Login ID *</label>
				<div class="col-sm-8">
					<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php echo $dept_session_details->user_name;?>"  >
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for="inputEmail3">Password<br />(If you don't want to change, please leave blank)</label>
				<div class="col-sm-8">
			 		<input type="password" class="form-control" id="inputEmail3" name="password" placeholder="password">
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
}
</script>
  