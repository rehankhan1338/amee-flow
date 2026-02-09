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
				<label >Title*</label><br />
				<div class="col-md-3" style="margin:0; padding:0;">
				<input type="text" class="form-control required"  id="txt_title" name="txt_title" placeholder="Title" value="<?php if(!empty($welcome_details->title)){echo $welcome_details->title;}else{echo "";}?>"  >
				</div>
				<div class="col-md-9" style="margin:0; padding:0 0 0px 5px;">
				<input type="text" class="form-control required"  id="txt_title_span" name="txt_title_span" placeholder="Title" value="<?php if(!empty($welcome_details->title_span)){echo $welcome_details->title_span;}else{echo "";}?>"  >
				</div>
			</div>
			<div class="form-group" ><label ></label></div>
			<div class="form-group" >
				<label >Sub-Title*</label>
				<input type="text" class="form-control required" id="txt_subtitle" name="txt_subtitle" placeholder="Sub Title" value="<?php if(!empty($welcome_details->subtitle)){echo $welcome_details->subtitle;}else{echo "";}?>"  >
			</div>
			
			<div class="form-group" >
				<label >Content*</label>
				<textarea class="form-control" id="editor" name="txt_content" placeholder="Content"><?php if(!empty($welcome_details->content)){echo $welcome_details->content;}else{echo "";}?></textarea>
			</div>
			
			<!--<div class="form-group" >
				<label>Image*</label>
				<input type="file" name="photo"  onchange="readURL(this);"/>
			</div>-->
			
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