<?php include(APPPATH.'views/Frontend/design/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="box"> 
	<div class="nrow">
	
		<div class="col-md-12">
			<a onclick="return open_model_members_add();" class="btn btn-primary pull-right" style="padding:3px 15px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Team Member</a>		
 		  </div>
		  <div class="col-md-12">
		<?php $i=1; foreach ($team_members_detail_group_by as $row) { ?>

			<div class="col-md-3" >
				<div class="col-md-12" style="border: 1px dashed #485b79;padding: 20px 20px;margin: 10px 0;color: #fff;background: #485b79;border-radius: 5px;">
				<div class="contenttitle2 nomargintop" style="margin-bottom:5px">
					<h3 style="color:#f6e4a5;">Team <?php if(isset($row->team_id)&& $row->team_id!=''){echo $row->team_id;}?></h3>
				</div>
						
				<!--<a href="#" class="btn btn-default btn-xs pull-right">Manage</a>-->
									
				<?php $j=1; $member_names_detail = get_member_names_result_by_id($row->team_id);
					foreach($member_names_detail as $members_name){?>
					
						<p><?php echo $j;?>. <span id="name_txt_<?php echo $members_name->id;?>" style="font-weight:600;"><?php if(isset($members_name->name)&& $members_name->name!=''){echo $members_name->name;}?></span>

							<span style="float: right;">
								<a onclick="open_model_members_edit('<?php echo $members_name->id;?>');" class="btn btn-default btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a class="btn btn-default btn-sm" href="<?php echo base_url();?>members/delete/<?php echo $members_name->id;?>" onclick="return confirm('Are you sure you want to Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</span>
						</p>
				<?php $j++;} ?>
			</div>
		</div>
		<?php  $i++; } ?>
		</div>
	</div>	
</div>

<div class="clearfix"></div> <br />
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/design/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/design/action3" class="btn btn-info">Next Action3 >></a>
	</div>
</div> 

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
		
		jQuery('#frm_pop_edit').validate({
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


	function open_model_members_add(){
		var pop_title = 'Team Members : : Add';
		jQuery('#courses_add_popup_title').html(pop_title);
		jQuery("#open_model_members_add").modal('show');
	}

	function open_model_members_edit(id){
		var pop_title = 'Team Member : : Edit';
		
		jQuery('#courses_edit_popup_title').html(pop_title);
		jQuery('#hupdate_id').val(id);
		
		var name_txt = jQuery('#name_txt_'+id).html();
		jQuery('#name_txt').val(name_txt);	
		
		jQuery("#open_model_members_edit").modal('show');	
	}
</script>


<!--EDIT Model-->
<div class="modal fade" id="open_model_members_edit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-cust" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="courses_edit_popup_title"></strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
   
			<div class="modal-body" style="padding:10px;">
				<form method="post" id="frm_pop" action="<?php echo base_url();?>design/edit_team_members">
							
					<input type="hidden" name="hupdate_id" id="hupdate_id" value="" />			
					<div class="form-group">
						<input id="name_txt" name="name" class="form-control required" placeholder="Name"  autocomplete="off" />
					</div>
					
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary view_btn" value='Update'/>
					</div>
				</form>				
				<div class="clearfix"></div>
			</div>
    	</div>
	</div>
</div>


<!--ADD Model-->
<div class="modal fade" id="open_model_members_add" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-cust" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong id="courses_add_popup_title"></strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop_edit" class="" action="<?php echo base_url();?>design/add_team_members">
			
			<div class="form-group">
 				<select class="form-control required" id="team_id" name="team_id"> 
					<option value="">-- Team Name --</option>
					<?php  for($i=1; $i<=20; $i++) {?>
						<option value="<?php echo $i; ?>"> Team <?php echo $i; ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="form-group">
				<input type="text" class="form-control required" name="name[]" id="name" placeholder="Name" multiple="multiple" autocomplete="off" />
			</div>	
			<!--<button style="float: right;" type="button" id="btn2">Add More</button>		-->	
			
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit'/>
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>

<script>
	jQuery(document).ready(function(){
	   jQuery('#btn2').click(function(){
	        jQuery(this).before('<div class="form-group"><input type="text" class="form-control" name="name[]" id="name" placeholder="Name" multiple="multiple"/></div>');
	    });
	});	
</script>