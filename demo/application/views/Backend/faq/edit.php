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
				<label >Question*</label>
				<input type="text" class="form-control required" id="question" name="question" placeholder="Question" value="<?php echo $faq_details->question;?>"  >
			</div>
			
			<div class="form-group" >
				<label >Answer*</label>
				<textarea id="editor" name="description"><?php echo $faq_details->description;?></textarea>
			</div>
 		
		</div>
		
		
		
		
          </div>
		  
           <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-primary" name="submit_login">Update</button>
              </div>
              <!-- /.box-footer -->
            </form>

        </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>