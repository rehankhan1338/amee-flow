<?php include(APPPATH.'views/Frontend/coordinate/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="box"> 
	<div class="nrow">
		
		<ul class="hornav">
			<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#undergraduates_course_listing">Undergraduates Course Listing </a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']=='2'){echo 'current';}?>"><a href="#graduates_course_listing">Graduates Course Listing </a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']=='3'){echo 'current';}?>"><a href="#program_matrix">Program Alignment Matrix</a></li>
		</ul>

		<div id="undergraduates_course_listing" class="subcontent margin20"  style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
			<div class="col-md-12">
				<div class="contenttitle2 nomargintop">
					<h3> Undergraduates Course Listing</h3>
				</div>
				<div class="pull-right">
					<a href="<?php echo base_url();?>department/coordinate/action2/upload_courses/undergraduate" class="btn btn-default" style="padding:3px 15px; font-size:15px;"><i class="fa fa-download" aria-hidden="true"></i> Download Template</a>
 					<a onclick="return open_model_coordinate_add('0');" class="btn btn-primary" style="padding:3px 15px; margin-left:5px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Undergraduate Course</a>				
				</div>

				<?php if(count($department_courses_result_undergraduate)>0){?>
				<table class="table table-bordered table-hover table-striped">
					<?php $i=1; foreach($department_courses_result_undergraduate as $undergraduate){?>			
					
						<tr>
							<td>
								<h5 style="font-style:italic; font-size:16px;"><?php echo $i.'. ';?>
									<span id="prefix_msg_<?php echo $undergraduate->id;?>"><?php echo $undergraduate->course_prefix;?></span>
									<span id="numbe_msg_<?php echo $undergraduate->id;?>" style="font-weight:600;"><?php echo $undergraduate->course_number;?></span>&nbsp; &ndash;&nbsp;
									<span id="title_msg_<?php echo $undergraduate->id;?>"><?php echo ucfirst($undergraduate->course_title);?></span>
								</h5>
							</td>
							<td><a onclick="open_model_coordinate_edit('0', '<?php echo $undergraduate->id;?>');" class="btn btn-success btn-xs">Edit</a>
							<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>coordinate/delete_courses_ugrad_grad_entry?id=<?php echo $undergraduate->id; ?>&status=0" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
						</tr>			 
					
					<?php $i++; } ?>
				</table>
				<?php }else{ ?>
					<h4 class="padding10"><i>-- no data available --</i></h4>
				<?php } ?>
			</div>
		</div>		
		
		
		<div id="graduates_course_listing" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']=='2'){echo 'block';}else{echo 'none';}?>;">
			<div class="col-md-12">
				<div class="contenttitle2 nomargintop">
					<h3> Graduates Course Listing </h3>
				</div>
				<div class="pull-right">
					<a href="<?php echo base_url();?>department/coordinate/action2/upload_courses/graduate" class="btn btn-default" style="padding:3px 15px; font-size:15px;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Graduate Courses</a>
					
					<a onclick="return open_model_coordinate_add('1');" class="btn btn-primary" style="padding:3px 15px;margin-left:5px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Graduate Course</a>				
				
				</div>
				
				<?php if(count($department_courses_result_graduate)>0){?>
				<table class="table table-bordered table-hover table-striped">
					<?php $i=1; foreach($department_courses_result_graduate as $graduate){?>			
					
						<tr>
							<td>							
								<h5 style="font-style:italic; font-size:16px;"><?php echo $i.'. ';?>
									<span id="prefix_msg_<?php echo $graduate->id;?>"><?php echo $graduate->course_prefix;?></span>
									<span id="numbe_msg_<?php echo $graduate->id;?>" style="font-weight:600;"><?php echo $graduate->course_number;?></span>&nbsp; &ndash;&nbsp;
									<span id="title_msg_<?php echo $graduate->id;?>"><?php echo ucfirst($graduate->course_title);?></span>
								</h5>
							</td>
							
							<td><a onclick="return open_model_coordinate_edit('1', '<?php echo $graduate->id;?>');" class="btn btn-success btn-xs">Edit</a>
							<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>coordinate/delete_courses_ugrad_grad_entry?id=<?php echo $graduate->id; ?>&status=1" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
						</tr>			 
					
					<?php $i++; } ?>
				</table>
				<?php }else{ ?>
					<h4 class="padding10"><i>-- no data available --</i></h4>
				<?php } ?>
			</div>
		</div>
		
		<div id="program_matrix" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']=='3'){echo 'block';}else{echo 'none';}?>;">
			<div class="col-md-12">
				<div class="contenttitle2 nomargintop">
					<h3> Program Alignment Matrix </h3>
				</div>
				<div class="pull-right">					
					<a onclick="return open_model_coordinate_add('2');" class="btn btn-primary" style="padding:3px 15px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Program</a>				
				</div>
				
				<?php if(count($department_programs_align_matrix)>0){?>
				<table class="table table-bordered table-hover table-striped">
					<?php $i=1; foreach($department_programs_align_matrix as $prm){?>								
						<tr>
							<td>							
								<h5 style="font-style:italic; font-size:16px;"><?php echo $i.'. ';?>
									<span id="prefix_msg_<?php echo $prm->id;?>"><?php echo $prm->course_prefix;?></span>&nbsp; &ndash;&nbsp;
									<span id="title_msg_<?php echo $prm->id;?>"><?php echo ucfirst($prm->course_title);?></span>
								</h5>
							</td>							
							<td><a onclick="return open_model_coordinate_edit('2', '<?php echo $prm->id;?>');" class="btn btn-success btn-xs">Edit</a>
							<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>coordinate/delete_courses_ugrad_grad_entry?id=<?php echo $prm->id; ?>&status=2" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
						</tr>						
					<?php $i++; } ?>
				</table>
				<?php }else{ ?>
					<h4 class="padding10"><i>-- no data available --</i></h4>
				<?php } ?>
			</div>
		</div>
	
	</div>	
</div>
<div class="clearfix"></div> <br />
<div class="box-footer">
	<div class="pull-right">
		<a href="<?php echo base_url();?>department/coordinate/action1" class="btn btn-info"><< Previous Action1</a>
		<a href="<?php echo base_url();?>department/coordinate/action3" class="btn btn-info">Next Action3 >></a>
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


	function open_model_coordinate_add(status){
			
		if(status==0){
			var pop_title = 'Undergraduate Course : : Add';
		}else if(status==1){
			var pop_title = 'Graduate Course : : Add';
		}else{
			var pop_title = 'Program : : Add';			
		}
		
		if(status==2){
			jQuery('#course_prefix').attr('placeholder','Program Prefix');
			jQuery('#add_course_title').attr('placeholder','Intervention title (i.e., name of workshop, training or course etc.)');
			jQuery("#course_number").removeClass('required');
			jQuery("#course_number").hide();
		}else{
 			jQuery('#course_prefix').attr('placeholder','Course Prefix');
			jQuery('#add_course_title').attr('placeholder','Course Title');
			jQuery("#course_number").addClass('required');
			jQuery("#course_number").show();
		}
		 
		
		jQuery('#hcourse_add_status').val(status);		
		jQuery('#courses_add_popup_title').html(pop_title);
		jQuery("#dialog_open_model_coordinate_add").modal('show');
	}


	function open_model_coordinate_edit(status,id){
		if(status==0){
			var pop_title = 'Undergraduate Course : : Edit';
		}else if(status==1){
			var pop_title = 'Graduate Course : : Add';
		}else{
			var pop_title = 'Program : : Add';			
		}
		
		if(status==2){
			jQuery("#label_edit_prefix_msg").html('Program Prefix');
			jQuery("#label_edit_title_msg").html('Intervention title (i.e., name of workshop, training or course etc.)');
			
			jQuery('#txt_edit_prefix_msg').attr('placeholder','Program Prefix');
			jQuery('#txt_edit_title_msg').attr('placeholder','Intervention title (i.e., name of workshop, training or course etc.)');
			jQuery("#txt_edit_numbe_msg").removeClass('required');
			jQuery("#coure_num_div").hide();
		}else{
			jQuery("#label_edit_prefix_msg").html('Course Prefix');
			jQuery("#label_edit_title_msg").html('Course Title');
		
 			jQuery('#txt_edit_prefix_msg').attr('placeholder','Course Prefix');
			jQuery('#txt_edit_title_msg').attr('placeholder','Course Title');
			jQuery("#txt_edit_numbe_msg").addClass('required');
			jQuery("#coure_num_div").show();
		}
		
		jQuery('#hcourse_edit_status').val(status);		
		jQuery('#courses_edit_popup_title').html(pop_title);
		jQuery('#hupdate_id').val(id);
		
		var prefix_msg = jQuery('#prefix_msg_'+id).html();
		jQuery('#txt_edit_prefix_msg').val(prefix_msg);	
		
		var numbe_msg = jQuery('#numbe_msg_'+id).html();
		jQuery('#txt_edit_numbe_msg').val(numbe_msg);	
		
		var title_msg = jQuery('#title_msg_'+id).html();
		jQuery('#txt_edit_title_msg').val(title_msg);
		
		jQuery("#dialog_open_model_coordinate_edit").modal('show');	
	}
</script>

<!--EDIT Model-->
<div class="modal fade" id="dialog_open_model_coordinate_edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="courses_edit_popup_title"></strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
   
			<div class="modal-body" style="padding:10px;">
				<form method="post" id="frm_pop" action="<?php echo base_url();?>coordinate/edit_courses_ugrad_grad_entry">
					
					<div class="form-group">
						<label class="control-label" id="label_edit_prefix_msg">Course Prefix</label>
						<input id="txt_edit_prefix_msg" name="course_prefix" placeholder="Course Prefix" class="form-control required"/>
					</div>
					
					<div class="form-group" id="coure_num_div">
						<label class="control-label" id="label_edit_numbe_msg">Course #</label>
						<input id="txt_edit_numbe_msg" name="course_number" placeholder="Course #" class="form-control required"/>
					</div>					
					
					<div class="form-group">
						<label class="control-label" id="label_edit_title_msg">Course Title</label>
						<textarea id="txt_edit_title_msg" name="course_title" class="form-control required" placeholder="Course Title"></textarea>
						<input type="hidden" name="hcourse_edit_status" id="hcourse_edit_status" value="" />
						<input type="hidden" name="hupdate_id" id="hupdate_id" value="" />
					</div>
					
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary view_btn" value='Update Now!' />
					</div>
				</form>				
				<div class="clearfix"></div>
			</div>
    	</div>
	</div>
</div>


<!--ADD Model-->
<div class="modal fade" id="dialog_open_model_coordinate_add" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong id="courses_add_popup_title"></strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body" style="padding:10px;">
		<form method="post" id="frm_pop_edit" class="" action="<?php echo base_url();?>coordinate/add_courses_ugrad_grad_entry">
			<input type="hidden" name="hcourse_add_status" id="hcourse_add_status">
			
			<div class="form-group">
 				<input type="text" id="course_prefix" name="course_prefix" placeholder="Course Prefix" class="form-control required" />
			</div>
			
			<div class="form-group">
 				<input type="text" id="course_number" name="course_number" placeholder="Course #" class="form-control required" />
			</div>			
			
			<div class="form-group">
 				<textarea id="add_course_title" name="add_course_title" class="form-control required"  placeholder="Course Title"></textarea>
			</div>
			
			<div class="form-group">
				<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit Now!'/>
			</div>
		</form>
		<div class="clearfix"></div>
	</div>
</div>
</div>
</div>