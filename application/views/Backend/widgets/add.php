<script type="text/javascript">
function fun_ispage(val){
	if(val==1){
		$('#dpage_name').show();
		$("#page_name").addClass(" required ");
	}else{
		$('#dpage_name').hide();
		$("#page_name").removeClass(" required ");
	}
}
</script>
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12" >
		
		 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
		 
          <!-- general form elements -->
          <div class="box">
         <div class="box-header with-border">
               <h3 class="box-title">&nbsp;</h3>
			  <div class="box-tools pull-right">
                       <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/widgets/listing" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i> Back to Listing </a>
                    </div>
            </div>
             
              <div class="box-body">
                <div class="col-md-10">
				  
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Widget Key*</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="txt_key" name="txt_key" placeholder="Widget Key" value=""  >
						</div>
					 </div>
					 
					 <div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Widget Title*</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Widget Title" value=""  >
						</div>
					 </div>
					 
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Widget Type*</label>
						<div class="col-sm-9">
 							<select class="form-control required" id="widget_type" name="widget_type"> 
								<option value="">--Select--</option>
								<option value="0">Normal</option>
								<option value="1">Custom</option>
 							</select>
						</div>
					 </div>
 					 
					 <!--<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Is Page*</label>
						<div class="col-sm-9">
 							<select class="form-control required" id="page_status" name="page_status" onchange="return fun_ispage(this.value);"> 
								<option value="">--Select--</option>
								<option value="0">No</option>
								<option value="1">Yes</option>
 							</select>
						</div>
					 </div>
					 
					 <div class="form-group" id="dpage_name" style="display:none;">
						<label class="col-sm-3 control-label" for="inputEmail3">Page Name*</label>
						<div class="col-sm-9">
 							<input type="text" class="form-control" id="page_name" name="page_name" placeholder="Page Name" value=""  >
						</div>
					 </div>-->
		  
				  
				  </div>
				  

           </div> 
          	  <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
          </div> </form>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
        <!--/.col (right) -->
   </div>
      <!-- /.row -->
</section>