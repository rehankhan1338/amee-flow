<script>
function copyClipboard() {
  var copyText = document.getElementById("copyTxtToClipboard");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value); //copyText.value
  $('#copyToClipboardBtn').html('<i class="fa fa-clipboard"></i> Copied');
}
</script>
<div id="survey_distributions" class="subcontent margin20">
<div class="col-md-12">
	 <div class="contenttitle2 nomargintop">
		<h3> Survey Distributions</h3>
	</div> 
	<div class="clearfix"></div>
		
	<div class="survey_inner_question">
	<?php if($survey_details->status==1){?>
			<div class="alert alert-danger">Your survey is inactive. Please activate before sending the survey link.</div>
		<?php } ?>	
		<div class="col-md-2 dist_link" >
		 	<div class="form-group">
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/survey/management?tab_id=3<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==1){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"  ><i class="fa fa-link" aria-hidden="true"></i>  Preview Link </a>
				</div>	
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/survey/management?tab_id=3<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=3" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==3){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"  ><i class="fa fa-link"></i>  Distribution Link </a>
				</div>		
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/survey/compose_email?tab_id=3<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&survey_id='.$_GET['survey_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=2" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==2){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"  ><i class="fa fa-envelope" aria-hidden="true"></i>  Email Link </a>
				</div>
		 	</div>
		</div>
	
	
	
	<?php if(isset($_GET['menu']) && $_GET['menu']==3){ ?>
	
	
	<div class="col-md-10" style="text-align: center">
		 	<div class="form-group dist_preview">
				 
				<h2>Survey Distribution Link</h2>
				<div class="instrc">
					<p><label>Use an anonymous survey link, Paste this reusable link into emails or onto a website.</label> </p>
					<p><label>It can't be tracked, and can't be used to identify respondents.</label></p>
				</div>
				<div>
					<a class="btn btn-default nfw600" href="<?php echo base_url().'survey/form/'.$survey_details->survey_code;?>" target="_blank" id="copySec" >
						<?php if(isset($survey_details->survey_code)&&$survey_details->survey_code!=''){echo base_url().'survey/form/'.$survey_details->survey_code;}?>
					</a>
					<input type="text" style="display:none;" value="<?php if(isset($survey_details->survey_code)&&$survey_details->survey_code!=''){echo base_url().'survey/form/'.$survey_details->survey_code;}?>" id="copyTxtToClipboard">
					<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>
				</div> 
		  	</div>
		</div>
	
	

	
		<div class="clearfix"></div>
	
	
	
	
	
	<?php }else if(isset($_GET['menu']) && $_GET['menu']==1){
	
		$previewLnk = base_url().'survey/form/preview/'.$survey_details->survey_code;
	?>
		
		<div class="col-md-10" style="text-align: center">
		 	<div class="form-group dist_preview">
				 
				<h2>Preview Survey Link Only</h2>
				<div class="instrc">
					<p><label>This link is unable to track participants individually and should not be posted for the public.</label> </p>
					<p><label>This is a preview link only.  Please send individual emails to track participant data.</label></p>
				</div>
				<div>
					<a class="btn btn-default nfw600" href="<?php echo $previewLnk;?>" target="_blank"><?php echo $previewLnk;?></a>
					<input type="text" style="display:none;" value="<?php echo $previewLnk;?>" id="copyTxtToClipboard">
					<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>
				</div> 
		  	</div>
		</div>
	
	

	
		<div class="clearfix"></div>
		
		<!--<div class="col-md-10" style="text-align: center">
			<div class="form-group">
				<button type="button" class="btn btn-primary" >Save and Update</button>
			</div>
		</div>-->
	
	
	
	<?php }else if(isset($_GET['menu']) && $_GET['menu']==2){?>	
		<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>survey/save_email" id="frm" method="post" enctype="multipart/form-data">	
		<div class="col-md-10">	
			<input type="hidden" name="h_survey_id" value="<?php if(isset($_GET['survey_id']) && $_GET['survey_id']!=''){ echo $_GET['survey_id'];}?>">
			<input type="hidden" name="h_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>">
		
			<div class="form-group">
				<label for="inputEmail3" class="control-label">Recipient Emails*</label>
				<textarea name="email_to" id="email_to" value="" class="form-control required" style="margin:5px 0;" placeholder="name1@domain.com, name2@domain.com"></textarea>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="control-label">Email Subject*</label>
				<input type="text" name="email_subject" id="email_subject" value="" class="form-control required" style="margin:5px 0;" placeholder="Enter Email Subject" />
			</div>
			
			<div class="form-group">
				<label for="inputEmail3" class="control-label" style="margin-bottom:10px;">Email Message*</label>
 				<textarea name="email_message" id="editor_distribution"><?php if(isset($_GET['menu']) && $_GET['menu']==2){
					
					$survey_link = base_url().'survey/form/'.$survey_details->survey_code;
					
					if(isset($survey_details->survey_send_message) && $survey_details->survey_send_message!=''){ 
					
						echo str_replace('{survey_link}',$survey_link,$survey_details->survey_send_message);
					
					}else{
				
						$messsage = '<div style="background-color: rgb(246, 246, 246);padding: 50px;">
<table style="font-family: Open Sans,sans-serif; color: #515050; font-size: 14px; width: 100%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;padding: 20px;" border="0" cellspacing="0" cellpadding="10"><tbody><tr><td><p><strong>Hello,</strong></p><h4>Please follow the link below to take the survey.</h4><p><a  href="{survey_link}">Click Here</a> to continue</p><p>or</p><p>Follow the link below.</p><p>{survey_link}</p><p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p></td></tr><tr><td style="padding-bottom: 20px; border-bottom: 2px solid #fb9337; line-height:25px;"><strong>Best Regards,</strong><br />{department_name}</td>
</tr></tbody></table></div>';
						echo str_replace('{survey_link}',$survey_link,$messsage);
				
					}
				
				}?></textarea>
			</div>
			
			<?php if($survey_details->status==0){?>
				<div class="clearfix"></div>
				<div class="form-group">
					<input name="design_save" class="btn btn-primary" value="Send Email" type="submit">
				</div>	
			<?php } ?>
		</div>
		
	 	
		</form>
	<?php } ?>		
		

	</div>		 

</div>
</div>