<section class="content">
      <div class="row">
        <div class="col-md-12">		
		 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="">
          <div class="box">
             
              <div class="box-body">
                <div class="col-md-10">
				  
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Template Name *</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="txt_template_name" name="txt_template_name" placeholder="Template Name" value="<?php echo $default_survey_templates_fulldetail->name;?>" />
						</div>
					 </div>
					 
					 <div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Status *</label>
						<div class="col-sm-9">
							<select class="form-control required" id="status" name="status">
								<option value="0" <?php if($default_survey_templates_fulldetail->status==0){?> selected="selected"<?php } ?>>Active</option>
								<option value="1" <?php if($default_survey_templates_fulldetail->status==1){?> selected="selected"<?php } ?>>Inactive</option>
							</select>
						</div>
					 </div>
					 				  
				  </div>				  

           </div> 
          	  <div class="box-footer">
                <button class="btn btn-primary" type="submit">Update Now!</button>
              </div>
          </div>
		  </form>
 
      </div>
   </div>
</section>