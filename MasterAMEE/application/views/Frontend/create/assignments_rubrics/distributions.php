<script>
function copyClipboard() {
  var copyText = document.getElementById("copyTxtToClipboard");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value); //copyText.value
  $('#copyToClipboardBtn').html('<i class="fa fa-clipboard"></i> Copied');
}
function copyClipboardSec() {
  var copyText = document.getElementById("copyTxtToClipboardSec");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value); //copyText.value
  $('#copyToClipboardBtnSec').html('<i class="fa fa-clipboard"></i> Copied');
}
</script>
<div id="survey_distributions" class="subcontent margin20">
<div class="col-md-12">
	<div class="contenttitle2 nomargintop">
		<h3> Assignment Distributions</h3>
	</div>
	<div class="clearfix"></div>
		
	<div class="survey_inner_question">
		<?php if($assignments_rubrics_row->status==1){?>
			<div class="alert alert-danger">Your assignment is inactive. Please activate before sending the assignment.</div>
		<?php } ?>	
		<div class="col-md-2 dist_link" style="padding-right:0;" >
		 	<div class="form-group">
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=1" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==1){echo 'menu_active';} ?>" style="margin:10px 0; width:100%; padding:6px 15px;"  ><i class="fa fa-link" aria-hidden="true"></i> Preview Link </a>
				</div>
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=4" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==4){echo 'menu_active';} ?>" style="margin:10px 0; width:100%; padding:6px 15px;"  ><i class="fa fa-link" aria-hidden="true"></i> Distribution Link </a>
				</div>			
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=2" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==2){echo 'menu_active';} ?>" style="margin:10px 0; width:100%; padding:6px 15px;"  ><i class="fa fa-envelope" aria-hidden="true"></i> Assignment Email </a>
				</div>
				
				<div class="col-md-12" style="margin:0; padding:0;">
					<a href="<?php echo base_url();?>department/create/assignments_rubrics/manage?tab=7<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!='' && isset($_GET['dept_id']) && $_GET['dept_id']==$this->session->userdata('dept_id')){ echo '&ar_id='.$_GET['ar_id'].'&dept_id='.$_GET['dept_id'];}?>&menu=3" class="btn btn-default question_types_btn <?php if(isset($_GET['menu'])&&$_GET['menu']==3){echo 'menu_active';} ?>" style="margin:10px 0; width:100%; padding:6px 15px;"  ><i class="fa fa-star" aria-hidden="true"></i> Rater Email </a>
				</div>
				
		 	</div>
		</div>
		
	<?php 
	$ass_distribution_link = base_url().'assignment/'.$assignments_rubrics_row->assignment_code;
	$assAnymRatorLink = base_url().'assignment_raters/'.$assignments_rubrics_row->assignment_code;
	if(isset($_GET['menu']) && $_GET['menu']==4){ ?>
	
		<div class="col-md-10" style="text-align: center">
		 	<div class="form-group dist_preview">
				<h2>Assignment Distribution Link</h2>
				<div class="instrc">
					<p><label>Use an anonymous assignment link, Paste this reusable link into emails or onto a website.</label> </p>
					<p><label>It can't be tracked, and can't be used to identify respondents.</label></p>
				</div>		
				
				<a class="btn btn-default nfw600" href="<?php echo $ass_distribution_link;?>" target="_blank"><?php echo $ass_distribution_link;?></a>
				<input type="text" style="display:none;" value="<?php echo $ass_distribution_link;?>" id="copyTxtToClipboard">
				<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>					
				<!--<p>
					<a class="btn btn-default nfw600" href="<?php //echo $assAnymRatorLink;?>" target="_blank"><?php //echo $assAnymRatorLink;?></a>
					<input type="text" style="display:none;" value="<?php //echo $assAnymRatorLink;?>" id="copyTxtToClipboardSec">
					<button onclick="copyClipboardSec()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtnSec"><i class="fa fa-clipboard"></i> Copy</button>				
				</p>-->
				
				
		  	</div>
		</div>
	
	
		<div class="clearfix"></div>
	
	<?php }else if(isset($_GET['menu']) && $_GET['menu']==1){?>
		
		<div class="col-md-10" style="text-align: center">
		 	<div class="form-group dist_preview">
				<?php $assPreviewLink = base_url().'assignment/preview/'.$assignments_rubrics_row->assignment_code;
				$assRatorPreviewLink = base_url().'assignment_raters/'.$assignments_rubrics_row->assignment_code.'/000000';
				?> 
				<h2>Preview Assignment Link</h2>
					<div class="instrc">
						<p>This link is unable to track participants individually and should not be posted for the public. </p>
						<p>This is a preview link only.  Please send individual emails to track participant data.</p>
					</div>
					<a class="btn btn-default nfw600" href="<?php echo $assPreviewLink;?>" target="_blank"><?php echo $assPreviewLink;?></a>
					<input type="text" style="display:none;" value="<?php echo $assPreviewLink;?>" id="copyTxtToClipboard">
					<button onclick="copyClipboard()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtn"><i class="fa fa-clipboard"></i> Copy</button>					
					<p>
						<a class="btn btn-default nfw600" href="<?php echo $assRatorPreviewLink;?>" target="_blank"><?php echo $assRatorPreviewLink;?></a>
						<input type="text" style="display:none;" value="<?php echo $assRatorPreviewLink;?>" id="copyTxtToClipboardSec">
						<button onclick="copyClipboardSec()" style="height:35px; margin-left:10px;" class="btn btn-primary" id="copyToClipboardBtnSec"><i class="fa fa-clipboard"></i> Copy</button>				
					</p>
		  	</div>
		</div>
	
	
		<div class="clearfix"></div>

	<?php }else if(isset($_GET['menu']) && ($_GET['menu']==2 || $_GET['menu']==3)){?>			
			
		<div class="col-md-10" style="padding-left:15px;">
		<form  action="<?php echo base_url();?>assignments_rubrics/save_email" id="frm" method="post" enctype="multipart/form-data">
		 
			
			<input type="hidden" name="h_menu" value="<?php if(isset($_GET['menu']) && $_GET['menu']!=''){ echo $_GET['menu'];}?>">
 			<input type="hidden" name="h_assingment_id" id="h_assingment_id" value="<?php if(isset($_GET['ar_id']) && $_GET['ar_id']!=''){ echo $_GET['ar_id'];}?>">
			<input type="hidden" name="h_dept_id" value="<?php if(isset($_GET['dept_id']) && $_GET['dept_id']!=''){ echo $_GET['dept_id'];}?>">
		
			<div class="form-group">
				<label for="inputEmail3"><h4>Recipient Emails *</h4></label>
				<textarea name="email_to" id="email_to" value="" class="form-control required" rows="3" style="margin:5px 0;" placeholder="name1@domain.com, name2@domain.com"></textarea>
			</div>

			<div class="form-group">
				<label for="inputEmail3"><h4>Email Subject *</h4></label>
				<input type="text" name="email_subject" id="email_subject" value="" class="form-control required" style="margin:5px 0;" placeholder="Enter Email Subject" />
			</div>
			
			<div class="form-group">
				<label for="inputEmail3"><h4>Email Message *</h4></label>
				<textarea name="email_message" id="editor_distribution"><?php 
				
				if(isset($_GET['menu']) && $_GET['menu']==2){
					 
					
					if(isset($assignments_rubrics_row->assignment_send_message) && $assignments_rubrics_row->assignment_send_message!=''){ 
					
						echo str_replace('{assignment_link}',$ass_distribution_link,$assignments_rubrics_row->assignment_send_message);
					
					}else{
				
						/*$messsage = '<div style="background-color: rgb(246, 246, 246);padding: 50px;">
<table style="font-family: Open Sans,sans-serif; color: #515050; font-size: 14px; width: 100%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;padding: 20px;" border="0" cellspacing="0" cellpadding="10"><tbody><tr><td><p><strong>Hello,</strong></p><h4>Please follow the link below to take the assignment.</h4><p><a  href="{assignment_link}">Click Here</a> to continue</p><p>or</p><p>Follow the link below.</p><p>{assignment_link}</p><p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p></td></tr><tr><td style="padding-bottom: 20px; border-bottom: 2px solid #fb9337; line-height:25px;"><strong>Best Regards,</strong><br />{department_name}</td>
</tr></tbody></table></div>';*/

$messsage = '<p>Hello,</p>
<p>Please follow the link below to take the assignment.</p>
<p><a href="{assignment_link}">Click Here</a> to continue <br> or <br>	
Follow the link below.
<br>{assignment_link}</p>
<p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p>
<p>Best Regards,<br>{department_name}</p>';
						echo str_replace('{assignment_link}',$ass_distribution_link,$messsage);
				
					}
				
				}else{
									
					if(isset($assignments_rubrics_row->assignment_rater_send_message) && $assignments_rubrics_row->assignment_rater_send_message!=''){ 
					
						echo str_replace('{assignment_link}',$assAnymRatorLink,$assignments_rubrics_row->assignment_rater_send_message);
					
					}else{
				
						/*$messsage = '<div style="background-color: rgb(246, 246, 246);padding: 50px;">
<table style="font-family: Open Sans,sans-serif; color: #515050; font-size: 14px; width: 100%; background: rgb(255, 255, 255) none repeat scroll 0% 0%;padding: 20px;" border="0" cellspacing="0" cellpadding="10"><tbody><tr><td><p><strong>Hello,</strong></p><h4>Please follow the link below to take the assignment.</h4><p><a  href="{assignment_link}/{auth_code}">Click Here</a> to continue</p><p>or</p><p>Follow the link below.</p><p>{assignment_link}/{auth_code}</p><p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p></td></tr><tr><td style="padding-bottom: 20px; border-bottom: 2px solid #fb9337; line-height:25px;"><strong>Best Regards,</strong><br />{department_name}</td>
</tr></tbody></table></div>';*/

$messsage = '<p>Hello,</p>
<p>Please follow the link below to give rating of the assignment.</p>
<p><a href="{assignment_link}/{auth_code}">Click Here</a> to continue <br> or <br>	
Follow the link below.
<br>{assignment_link}/{auth_code}</p>
<p>Be sure to keep this email safe. You will need this unique link each time you access our system.</p>
<p>Best Regards,<br>{department_name}</p>';
						echo str_replace('{assignment_link}',$assAnymRatorLink,$messsage);
				
					}
				
				}?></textarea>
			</div>
			<?php if($assignments_rubrics_row->status==0){?>
				<div class="clearfix"></div>
				<div class="form-group">
					<input name="design_save" class="btn btn-primary" value="Send Email" type="submit">
				</div>	
			<?php } ?>
		</form>
		</div>
 		
		
	<?php } ?>		
		

	</div>		 

</div>
</div>