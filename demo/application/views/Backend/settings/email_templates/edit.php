<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            
 <form class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
              <div class="box-body"> 

                

                  <div class="col-md-12">

						 

 				  

							  <div class="form-group">

								<label for="inputEmail3">Subject *</label>

								 

									<input type="text" class="form-control required" id="Subject" name="Subject" value="<?php echo $email_templates_details->subject;?>"  >

								<?php echo form_error('Subject');?>

								 

							 </div>

							 

							 <div class="form-group">

								<label  for="inputEmail3">Message *</label>

								 

									<textarea class="form-control" id="editor" name="message"><?php echo $email_templates_details->message;?></textarea>

								<?php echo form_error('message');?>

								 

							 </div>

							       

						

					</div>

                  

				   



           </div>

          	  <div class="box-footer">

                <input class="btn btn-primary " style="font-weight:600; font-size:15px; padding:5px 20px;" type="submit" name="cmdSubmit" value="Update Now!"   />

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