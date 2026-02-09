<?php if(isset($suites_detail_row)&& $suites_detail_row!=''){?>

<script type="text/javascript">
jQuery(function () { 
	jQuery('#frm_pop').validate({
	  ignore: [], 
	  highlight: function(element) {
		jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
	  },
	  success: function(element) {
		element.closest('.form-group').removeClass('has-error').addClass('has-success');
		element.remove();
	  }
	});
});
</script>

<style>
body.modal-open { padding-right: 0px !important; overflow-y: auto; }
.modal-dialog { max-width:600px; }
.modal-header strong { color:#f6e4a5; font-size:20px; }
.modal-header .close { color:#f6e4a5; opacity:0.6; }
.modal-body{padding:5px;}
.modal-body p{padding:5px;}
#dialog_read_more_popup_messages .modal-body{font-size: 16px;font-family: Georgia, "Times New Roman", Times, serif;font-style: italic;line-height: 26px;padding: 0 10px;margin: 10px 0;}
.modal-body .form-group{margin-bottom:10px;}
.modal-body .form-group .control-label{ margin-bottom:5px; font-weight:600;}
.modal-body p:last-child{ display:inline-block;}
.modal-body .view_btn { color:#fff; width:100%; text-align:center; border:none; margin-bottom:-10px;}
.modal-body ul{ margin-left:20px; margin-bottom:10px !important;}

.modal-header {
    background: url('<?php echo base_url();?>assets/frontend/images/default/topheaderbg.png');
    border-radius: 4px 4px 0 0;
    border-bottom: 3px solid #fb9337;
}
.modal-content{border-radius: 5px;}
</style>

	 
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<strong id="result" class="pop_title"></strong>
 			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 		</div>
		<div class="modal-body" style="padding:10px;">
			<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>admin/suites/add_user">
				<input type="hidden" class="form-control" name="suites_id" id="suites_id" value="" />	
 				<input type="hidden" class="form-control" name="university_id" id="university_id" value="<?php echo $this->config->item('cv_university_id');?>" />
				<div class="row">	
	   			<div class="col-md-6">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="first_name" id="first_name" placeholder="Enter your First Name" value="" />
					</div>	
				</div>	
							
				<div class="col-md-6">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="last_name" id="last_name" placeholder="Enter your Last Name" value="" />
					</div>	
				</div>
								
				<div class="col-md-12">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="email" id="email" placeholder="Enter your Email" value="" />
					</div>	
				</div>	
							
				<div class="col-md-12">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="phone" id="phone" placeholder="Enter your Phone Number." value="" />
					</div>	
				</div>
					
				<div class="col-md-12" style=" <?php if(isset($precising_details) && count($precising_details)==0){echo 'display: none';}?> ">
		 			<div class="form-group">
					<select class="form-control <?php if(isset($precising_details) && count($precising_details)!=0){echo 'required';}?>" name="limit_precising" id="limit_precising" placeholder="Select Precising">		
						<option value="">-- Select Pricing --</option>
						<?php foreach($precising_details as $precising){?>
 							<option value="<?php echo $precising->id;?>"><?php echo $precising->limit.'&nbsp;&nbsp;$'.$precising->price;?></option>
 						<?php } ?>
					</select>
					</div>	
				</div>	
				</div>
	 			<div class="form-group">
					<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
				</div>
			</form>
	 		<div class="clearfix"></div>
		</div>
	</div>
	</div>
	 
<?php }?>