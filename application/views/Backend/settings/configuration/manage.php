<section class="content">
<script type="text/javascript">
function fun_smtp(val){
 if(val==0){
	 $('.smtp_details_disable').show();	
	 $('.smtp_details_enable').hide();
 }else{
 	$('.smtp_details_disable').hide();	
	$('.smtp_details_enable').show();
 }
}
</script>
<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <!-- left column -->
        <div class="col-md-4" style="display:none;">
          
          <div class="box">
          
				<div class="box-header with-border">
				  <h3 class="box-title">Basic Details</h3>
				</div>
			
              <div class="box-body">
                <div class="col-md-12">	
					 
					 <div class="form-group">
						<label  for="inputEmail3">Title*</label>
						<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="Title" value="<?php if(isset($configuration_details->title) && $configuration_details->title!=''){ echo $configuration_details->title;}?>" />
					 </div>
					 
					 <div class="form-group">
						<label  for="inputEmail3">Logo</label>
						<input type="file" class="" id="photo" name="photo" onchange="return readURL(this);" />
					 </div>
					 
					 <div class="form-group">
						<?php if(isset($configuration_details->logo)&& $configuration_details->logo!=''){?>
							<img src="<?php echo base_url(); ?>assets/backend/logo/<?php echo $configuration_details->logo;?>" alt="LOGO HERE" class="img-responsive" id="blah" />
						<?php }else{ ?>
							<img src="<?php echo base_url();?>assets/backend/images/backend_dummy_logo.png" alt="LOGO HERE" class="img-responsive" id="blah" />
						<?php }?>
					 </div>
					  
				  			
				  
				  </div>
				  

           </div> 
          	  
			   
          </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
	  
	  
	  <div class="col-md-4">
          
          <div class="box">
          
				<div class="box-header with-border">
				  <h3 class="box-title">SMTP Details</h3>
				</div>
			
              <div class="box-body">
                <div class="col-md-12">	
					 
					 <div class="form-group">
						<label for="inputEmail3">Mail Title*</label>
						<input type="text" class="form-control required" id="mail_title" name="mail_title" placeholder="" value="<?php if(isset($configuration_details->mail_title) && $configuration_details->mail_title!=''){ echo $configuration_details->mail_title;}?>"  >
					 </div>
					 
					 
					 <div class="form-group">
						<label for="inputEmail3">Is SMTP*</label><br />
						<input type="radio" name="is_smtp" id="is_smtp" value="1" onclick="return fun_smtp(this.value);" <?php if(isset($configuration_details->is_smtp) && $configuration_details->is_smtp==1){?> checked="checked" <?php } ?> /> Enable 
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="is_smtp" id="is_smtp" value="0" onclick="return fun_smtp(this.value);" <?php if(isset($configuration_details->is_smtp) && $configuration_details->is_smtp==0){?> checked="checked" <?php } ?> /> Disable
					 </div>
					 
					  
					 
					  <div class="smtp_details_disable" style="display:<?php if(isset($configuration_details->is_smtp) && $configuration_details->is_smtp==1){ echo 'none';}else{echo 'block';}?>;">
					  
					 <div class="form-group">
						<label for="inputEmail3">From Email Address*</label>
						<input type="text" class="form-control required" id="mail_from_email_address" name="mail_from_email_address" placeholder="" value="<?php if(isset($configuration_details->mail_from_email_address) && $configuration_details->mail_from_email_address!=''){ echo $configuration_details->mail_from_email_address;}?>"  >
					 </div>
					
					</div>	 
						 
					 <div class="smtp_details_enable"  style="display:<?php if(isset($configuration_details->is_smtp) && $configuration_details->is_smtp==0){ echo 'none';}else{echo 'block';}?>;">
					 
						 <div class="form-group">
							<label for="inputEmail3">Host*</label>
							<input type="text" class="form-control required" id="smtp_host" name="smtp_host" placeholder="" value="<?php if(isset($configuration_details->smtp_host) && $configuration_details->smtp_host!=''){ echo $configuration_details->smtp_host;}?>"  >
						 </div>
						 
						 <div class="form-group">
							<label for="inputEmail3">Port*</label>
							<input type="text" class="form-control required" id="smtp_port" name="smtp_port" placeholder="" value="<?php if(isset($configuration_details->smtp_port) && $configuration_details->smtp_port!=''){ echo $configuration_details->smtp_port;}?>"  >
						 </div>
						 
						 <div class="form-group">
							<label for="inputEmail3">Username*</label>
							<input type="text" class="form-control required" id="smtp_username" name="smtp_username" placeholder="" value="<?php if(isset($configuration_details->smtp_username) && $configuration_details->smtp_username!=''){ echo $configuration_details->smtp_username;}?>"  >
						 </div>
						 
						 <div class="form-group">
							<label for="inputEmail3">Password*</label>
							<input type="text" class="form-control required" id="smtp_password" name="smtp_password" placeholder="" value="<?php if(isset($configuration_details->smtp_password) && $configuration_details->smtp_password!=''){ echo $configuration_details->smtp_password;}?>"  >
						 </div>
				  	
					</div>		
				  
				  </div>
				  

           </div> 
          	  
			   
          </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
	  
	  <div class="col-md-4" style="display:none;">
          
          <div class="box">
          
				<div class="box-header with-border">
				  <h3 class="box-title">Social Media Links</h3>
				</div>
			
              <div class="box-body">
                <div class="col-md-12">	
					 
					 <div class="form-group">
						<label for="inputEmail3">Facebook*</label>
						<input type="text" class="form-control required" id="social_facebook" name="social_facebook" placeholder="" value="<?php if(isset($configuration_details->social_facebook) && $configuration_details->social_facebook!=''){ echo $configuration_details->social_facebook;}?>"  >
					 </div>
					 
					 <div class="form-group">
						<label for="inputEmail3">Twitter*</label>
						<input type="text" class="form-control required" id="social_twitter" name="social_twitter" placeholder="" value="<?php if(isset($configuration_details->social_twitter) && $configuration_details->social_twitter!=''){ echo $configuration_details->social_twitter;}?>"  >
					 </div>
					 
					 <div class="form-group">
						<label for="inputEmail3">Google Plus*</label>
						<input type="text" class="form-control required" id="social_google_plus" name="social_google_plus" placeholder="" value="<?php if(isset($configuration_details->social_google_plus) && $configuration_details->social_google_plus!=''){ echo $configuration_details->social_google_plus;}?>"  >
					 </div>
					 
					 <div class="form-group">
						<label for="inputEmail3">Linkedin*</label>
						<input type="text" class="form-control required" id="social_linkedin" name="social_linkedin" placeholder="" value="<?php if(isset($configuration_details->social_linkedin) && $configuration_details->social_linkedin!=''){ echo $configuration_details->social_linkedin;}?>"  >
					 </div>
					 
					  <div class="form-group">
						<label for="inputEmail3">Youtube*</label>
						<input type="text" class="form-control required" id="social_youtube" name="social_youtube" placeholder="" value="<?php if(isset($configuration_details->social_youtube) && $configuration_details->social_youtube!=''){ echo $configuration_details->social_youtube;}?>"  >
					 </div>
					 
					 <div class="form-group">
						<label for="inputEmail3">Instragram*</label>
						<input type="text" class="form-control required" id="social_instagram" name="social_instagram" placeholder="" value="<?php if(isset($configuration_details->social_instagram) && $configuration_details->social_instagram!=''){ echo $configuration_details->social_instagram;}?>"  >
					 </div>
				  			
				  
				  </div>
				  

           </div> 
          	  
			   
          </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
	  
	  
        <!--/.col (right) -->
   </div>
   <div class="row" style="margin:10px 0;">
   <div class="col-md-4"></div>
                <div class="col-md-4"><button class="btn btn-primary" type="submit" style="width:100%;">Save & Update</button></div>
				<div class="col-md-4"></div>
               </div>
      <!-- /.row -->
	  </form>
</section>