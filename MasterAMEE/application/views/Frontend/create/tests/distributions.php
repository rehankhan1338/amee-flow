<style>
	.menu_active{
		background: #34445e;
		color: #f6e4a5;
		border: 1px solid #34445e;
	}
</style>
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
		<h3> <?php
		if(isset($test_details->current_test_type)&& $test_details->current_test_type>0){
 		if($test_details->current_test_type==1){
			echo "Pre Test";
		}elseif($test_details->current_test_type==2){
			echo "Post Test";
		}elseif($test_details->current_test_type==3){
			echo "One Time Test";
		}
 	}
	?>  Distributions</h3>
	</div>
	<div class="clearfix"></div>
		
	<div class="survey_inner_question">
	
		<?php if($test_details->status==1){?>
			<div class="alert alert-danger">Your assignment is inactive. Please activate before sending the assignment.</div>
		<?php } ?>	
		
 		<div class="col-md-2 dist_link">
		 	<div class="form-group">
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/tests/management?tab_id=6<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==1){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"><i class="fa fa-link" aria-hidden="true"></i>  Preview Link </a>
				</div>	
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/tests/management?tab_id=6<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=3" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==3){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"><i class="fa fa-link" aria-hidden="true"></i>  Distribution Link </a>
				</div>	
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/tests/compose_email?tab_id=6<?php if(isset($_GET['test_id']) && $_GET['test_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&test_id='.$_GET['test_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=2" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==2){echo 'menu_active';} ?>" style="margin:10px 0; width:100%;"><i class="fa fa-envelope" aria-hidden="true"></i> Email Link </a>
				</div>
		 	</div>
		</div>
	
	
	
	<?php 
	
	$test_distribution_link = base_url().'test/'.$test_details->test_code;
	
	if(isset($_GET['menu']) && $_GET['menu']==3){ ?>
	
	
	<div class="col-md-10" style="text-align: center">
		 	<div class="form-group dist_preview">
				 
				<h2>Test Distribution Link</h2>
				<div class="instrc">
					<p><label>Use an anonymous test link, Paste this reusable link into emails or onto a website.</label> </p>
					<p><label>It can't be tracked, and can't be used to identify respondents.</label></p>
				</div>
				<div>
					<a class="btn btn-default nfw600" href="<?php echo $test_distribution_link;?>" target="_blank" id="copySec"><?php echo $test_distribution_link;?></a>
					<input type="text" style="display:none;" value="<?php echo $test_distribution_link;?>" id="copyTxtToClipboard">
					<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>
				</div> 
		  	</div>
		</div>
	
	

	
		<div class="clearfix"></div>
	
	
	
	
	
	<?php }else if(isset($_GET['menu']) && $_GET['menu']==1){
		
		$previewLnk = base_url().'test/preview/'.$test_details->test_code;
		
	?>
 		
		<div class="col-md-8" style="text-align: center">
		 	<div class="form-group dist_preview">
				 
				<h2>Preview Test Link Only</h2>
				<div class="instrc">
					<p><label>This link is unable to track participants individually and should not be posted for the public.</label></p>
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
		<div class="col-md-2" > </div>
		
		<!--<div class="col-md-10" style="text-align: center">
			<div class="form-group">
				<button type="button" class="btn btn-primary" >Save and Update</button>
			</div>
		</div>-->
	
	
	
	<?php }else if(isset($_GET['menu']) && $_GET['menu']==2){
	
		
		
	?>	
		<label style="margin-bottom:15px; font-size:15px;" class="nfw600 pull-right">Test Distribution Link &ndash; <a  href="<?php echo $test_distribution_link;?>" target="_blank"><?php echo $test_distribution_link;?></a></label>
		<form data-toggle="validator" class="form-horizontal" action="<?php echo base_url();?>tests/save_email" id="frm" method="post" enctype="multipart/form-data">	
		<div class="col-md-10">	
			<input type="hidden" name="h_test_id" value="<?php if(isset($_GET['test_id']) && $_GET['test_id']!=''){ echo $_GET['test_id'];}?>">
			<input type="hidden" name="h_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>">
			<input type="hidden" name="h_test_type" value="<?php echo $test_details->test_type;?>" />
		
			<div class="form-group">
				<label for="inputEmail3"><h4>Recipient Emails</h4></label>
				<textarea name="email_to" id="email_to" value="" class="form-control required" style="margin:5px 0;" placeholder="name1@domain.com, name2@domain.com"></textarea>
			</div>

			<div class="form-group">
				<label for="inputEmail3"><h4>Email Subject</h4></label>
				<input type="text" name="email_subject" id="email_subject" value="" class="form-control required" style="margin:5px 0;" placeholder="Enter Email Subject" />
			</div>
			
			<div class="form-group">
				<label for="inputEmail3"><h4>Email Message</h4></label>
				<textarea name="email_message" id="editor_end"><?php if(isset($_GET['menu']) && $_GET['menu']==2){
					
 					if(isset($test_details->test_send_message) && $test_details->test_send_message!=''){ 
					
						echo str_replace('{test_link}',$test_distribution_link,$test_details->test_send_message);
					
					}else{
				
						$messsage = '<div style="background-color: rgb(246, 246, 246);padding: 50px;">
<table style="font-family: Open Sans,sans-serif; color: #515050; font-size: 14px; width: 100%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;padding: 20px;" border="0" cellspacing="0" cellpadding="10"><tbody><tr><td><p><strong>Hello,</strong></p><h4>Please follow the link below to take the test.</h4><p><a  href="{test_link}">Click Here</a> to continue</p><p>or</p><p>Follow the link below.</p><p>{test_link}</p><p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p></td></tr><tr><td style="padding-bottom: 20px; border-bottom: 2px solid #fb9337; line-height:25px;"><strong>Best Regards,</strong><br />{department_name}</td>
</tr></tbody></table></div>';

/*$messsage = '<p>Hello</p>
						<p>Please follow the link below to take the test.<br>	
						<a href="{test_link}/{auth_code}">Click Here</a> to continue <br> or <br>	
						Follow the link below.
						<br>{test_link}/{auth_code}</p>
						<p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p>
						<p>Best Regards,<br>{department_name}</p>';*/
						echo str_replace('{test_link}',$test_distribution_link,$messsage);
				
					}
				
				}?></textarea>
			</div>
			
			<?php if($test_details->status==0){?>
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