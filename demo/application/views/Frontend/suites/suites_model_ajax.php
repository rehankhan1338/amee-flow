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


	
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<strong id="result" class="pop_title"></strong>
 			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
 		</div>
		<div class="modal-body" style="padding:10px;">
		  
			<form method="post" id="frm_pop" class="" action="<?php echo base_url();?>suites/add_user">
				<input type="hidden" class="form-control" name="suites_id" id="suites_id" value="" />	
 				<input type="hidden" class="form-control"  name="university_id" id="university_id" value="<?php echo $this->config->item('cv_university_id');?>" />
				<div class="row">
					
	   			<div class="col-md-6" style="margin-right: 0px;padding-right: 0px">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="first_name" id="first_name" placeholder="First Name *" value="<?php //if(isset($suites_user_detail_row->first_name)&& $suites_user_detail_row->first_name!=''){echo $suites_user_detail_row->first_name;}?>" />
					</div>	
				</div>	
							
				<div class="col-md-6">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="last_name" id="last_name" placeholder="Last Name *" value="<?php //if(isset($suites_user_detail_row->last_name)&& $suites_user_detail_row->last_name!=''){echo $suites_user_detail_row->last_name;}?>" />
					</div>	
				</div>
								
				<div class="col-md-12">
		   			<div class="form-group">
						<input type="text" class="form-control email required" name="email" id="email" placeholder="Email *" value="<?php //if(isset($suites_user_detail_row->email)&& $suites_user_detail_row->email!=''){echo $suites_user_detail_row->email;}?>" />
					</div>	
				</div>	
							
				<div class="col-md-12">
		   			<div class="form-group">
						<input type="text" class="form-control required" name="phone" id="phone" placeholder="Phone Number *" value="<?php //if(isset($suites_user_detail_row->phone)&& $suites_user_detail_row->phone!=''){echo $suites_user_detail_row->phone;}?>" />
					</div>	
				</div>
					
				<div class="col-md-12" style=" <?php if(isset($precising_details)&& count($precising_details)==0){echo 'display: none';}?> ">
		 			<div class="form-group">
					<select class="form-control <?php if(isset($precising_details)&& count($precising_details)!=0){echo 'required';}?>" name="limit_precising" id="limit_precising">		
						<option value="">Select Pricing *</option>
						<?php foreach($precising_details as $precising){?>
							
							<option value="<?php echo $precising->id;?>" <?php //if(isset($suites_user_detail_row->limit_precising)&& $suites_user_detail_row->limit_precising==$precising->id){ selected="selected"  }?> >
								<?php echo $precising->limit.'&nbsp;&nbsp;$'.$precising->price;?>
							</option>
							
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