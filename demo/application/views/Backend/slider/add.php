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
				<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value=""  >
			</div>
			
			<div class="form-group" >
				<label >Sub-Title*</label>
				<input type="text" class="form-control required" id="txt_subtitle" name="txt_subtitle" placeholder="Sub Title" value=""  >
			</div>
			
			<div class="form-group" >
				<label>Image*</label>
				<input type="file" name="photo"  onchange="readURL(this);"/>
			</div>
			
			<div class="form-group">
				<img src="" alt="" id="blah" class="img-responsive" />
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
         
 
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>