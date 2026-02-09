	
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Profile</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
              <div class="box-body">
                 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
                  <p id="ret"><?php
				  
				  	if(validation_errors() != false) { 
		
			echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; 
			
		}
				  ?></p>
 				  <div class="col-md-12">
				  
				  			
							<div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Name*</label>
								<div class="col-sm-9">
									<input type="text" class="form-control required" id="name" name="name" placeholder="Name" value="<?php echo $session_details->name;?>"  >
								</div>
							 </div>
							 
							 
							  
							 
							 <div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Email*</label>
								<div class="col-sm-9">
									<input type="text" class="form-control email required" id="email" name="email" placeholder="" value="<?php echo $session_details->email;?>"  >
								</div>
							 </div>
							 
 							 <div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">User Name/Login ID *</label>
								<div class="col-sm-9">
									<input type="text" class="form-control required" id="user_name" name="user_name" placeholder="User Name" value="<?php echo $session_details->username;?>"  >
								</div>
							 </div>
							 
							 <div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Password<br />(If you don't want to change, please leave blank)</label>
								<div class="col-sm-9">
									 <input type="password" class="form-control" id="inputEmail3" name="password" placeholder="password">
								</div>
							 </div>
							 
							 <div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Profile Pic</label>
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
           <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-primary" name="submit_login">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>

        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          
          </div>
 
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
        }
  </script>
  