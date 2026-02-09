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

	<?php //echo validation_errors(); ?>  
		
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
						<label class="col-sm-3 control-label" for="inputEmail3">Fild Type*</label>
						<div class="col-sm-9">
 							<select class="form-control required" id="fild_type" name="fild_type" onclick="return apply_fild_type(this.value);" placeholder='Fild Type'>
 								<option value="">--Select--</option>
	 							<?php foreach($field_type_list as $fild_type){?> 
									<option value="<?php echo $fild_type->id;?>"><?php if(isset($fild_type->name)&& $fild_type->name!=''){echo $fild_type->name;}else{echo '';}?></option>
								<?php }?>
 							</select>
						</div>
					</div>
													

				  	<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Meta Key*</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="meta_key" name="meta_key" placeholder="Meta Key" value="<?php echo set_value('meta_key'); ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Meta Label*</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="meta_label1" name="meta_label" placeholder="Meta Label" value="<?php echo set_value('meta_label'); ?>"  >
						</div>
					</div>
					

			<!--Option fild-->					
					<div id="multi_fild" style="display:none;">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="inputEmail3">Option Name*</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="option_name[]" name="option_name[]" placeholder="Option Name">
							</div>
						</div>
						
						<div id="append_fild"></div>
						<div class="form-group">
							<button id="btn2" class="btn-info" type="button" style="float: right;">Add More</button>
						</div>
					</div>
			<!--Option fild-->
	

					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Placeholder*</label>
						<div class="col-sm-9">
							<input type="text" class="form-control required" id="placeholder" name="placeholder" placeholder="placeholder" value="<?php echo set_value('placeholder'); ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3">Is Required*</label>
						<div class="col-sm-9">
 							<select class="form-control required" id="is_required" name="is_required" placeholder='Is Required'> 
								<option value="">--Select--</option>
								<option value="0">Required</option>
								<option value="1">Not Required</option>
 							</select>
						</div>
					 </div>
				  </div>
           </div> 
          	  <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
          </div> </form>
      </div>
   </div>
</section>

<script type="text/javascript"> 
$('#multi_fild').hide();	
function apply_fild_type(id){
	if(id=='4' || id=='5'){
		$('#multi_fild').show();
		    $("#btn2").click(function(){
       			$("#append_fild").append('<div class="form-group"><label class="col-sm-3 control-label" for="inputEmail3">Option Name*</label><div class="col-sm-9"><input type="text" class="form-control required" id="option_name[]" name="option_name[]" placeholder="Option Name"></div></div>');
    	});
    
	}else{
		$('#multi_fild').hide();
	}	
}
</script>