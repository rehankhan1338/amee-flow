<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box">
           <!-- <div class="box-header with-border">
              <h3 class="box-title">EVENT COMPULSORY RECORDS</h3>
            </div>-->
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
                  <div class="col-md-12">
						 
 				  
							  <div class="form-group">
								<label  for="inputEmail3">Subject*</label>
								 
									<input type="text" class="form-control required" id="Subject" name="Subject" value="<?php echo $email_templates_details->subject;?>"  >
								<?php echo form_error('Subject');?>
								 
							 </div>
							 
							 <div class="form-group">
								<label  for="inputEmail3">Message*</label>
								 
									<textarea class="form-control mceEditor" id="mceEditor" style="height:500px;" name="message"><?php echo $email_templates_details->message;?></textarea>
								<?php echo form_error('message');?>
								 
							 </div>
							       
						
					</div>
                  
				   

           </div>
          	  <div class="box-footer">
                <input class="btn btn-primary pull-right" type="submit" name="cmdSubmit" value="Save"   />
              </div>
		 </form>

        </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
        <!--/.col (right) -->
   </div>
      <!-- /.row -->
</section>