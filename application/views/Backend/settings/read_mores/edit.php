<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12" >
		
		 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
		 
          <!-- general form elements -->
          <div class="box">
         
             
              <div class="box-body">
                <div class="col-md-10">
				  
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Title *</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php echo $track_readiness_read_mores_details->title;?>"  >
						</div>
					 </div>
					 
					 <div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Description *</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="editor" name="description"><?php echo $track_readiness_read_mores_details->description;?></textarea>
						</div>
					 </div>
					 
				 	<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Status *</label>
						<div class="col-sm-9">
							<select class="form-control required" id="status" name="status">
								<option value="0" <?php if($track_readiness_read_mores_details->status==0){?> selected="selected"<?php } ?>>Active</option>
								<option value="1" <?php if($track_readiness_read_mores_details->status==1){?> selected="selected"<?php } ?>>In-active</option>
							</select>
						</div>
					 </div>
		  
					 
					 
				  			
				  
				  </div>
				  

           </div> 
          	  <div class="box-footer">
                <button class="btn btn-primary" type="submit">Update Now!</button>
              </div>
          </div> </form>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
        <!--/.col (right) -->
   </div>
      <!-- /.row -->
</section>