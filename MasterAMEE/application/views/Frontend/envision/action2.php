<?php include(APPPATH.'views/Frontend/envision/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<style>
.pslo-title{font-style:italic;font-size:16px;}
.pslo-title .st{ font-weight:600;}
</style>
<form data-toggle="validator" class="form-horizontal" id="frm" method="POST" action="" enctype="multipart/form-data">

<div class="box">

	<div class="nrow">
				
		<ul class="hornav">
			<li class="<?php if(!isset($_GET['tab_id'])){echo 'current';}?>"><a href="#overview">Overview</a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'current';}?>"><a href="#mission">Instructions </a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'current';}?>"><a href="#vission">Undergraduate PSLOs </a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'current';}?>"><a href="#department_program_goals">Graduate PSLOs</a></li>
			<li class="<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5){echo 'current';}?>"><a href="#program_learning_outcomes">Program Learning Outcomes </a></li>
		</ul>

		<div id="overview" class="subcontent margin20" style="display:<?php if(!isset($_GET['tab_id'])){echo 'block';}else{echo 'none';}?>">
			<div class="box">
				<div class="box-body">
						
					<div class="contenttitle2 nomargintop">
						<h3>Overview</h3>
					</div>
					
					<div class="clearfix"></div>
					<div class="sam_over instructions"><strong>Sample Overview:</strong> Program outcomes are statements of what faculty expect graduates should be able to do after completing their programs of study. Like learning objectives, these statements are written in specific, demonstrable (measurable), and student-centered terms. The Department of Demo has seven program learning outcomes for our undergraduate program. We continue to work on our graduate learning outcomes to distinguish them from our undergraduate program. See the list below</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<div class="col-md-12"><textarea id="editor1" name="envision_action2_overview"><?php if(!empty($checklist_detail->envision_action2_overview)){echo $checklist_detail->envision_action2_overview;} ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12"><input type="submit" name="envision_save" class="btn btn-primary" value='Save & Update' /></div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div id="mission" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==2){echo 'block';}else{echo 'none';}?>">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Instructions</h3>
					</div>
					<div class="clearfix"></div>
					<h4 style="line-height:25px; font-style:italic; font-size:17px;">Student/Participant learning outcomes (SLOs) are specific, concise statements of how students or participants can demonstrate their mastery of the program's learning goals. Each student/participant learning outcome is directly drawn from the programs learning goals. To upload your student/participant learning outcomes for your program, <a href="<?php echo base_url();?>department/envision/action2/upload" class="abtn">click here</a></h4>
				
				</div>
			</div>
		</div>

		<div id="vission" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==3){echo 'block';}else{echo 'none';}?>">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Undergraduate PSLOs </h3>
					</div>
					<a onclick="return open_model_plsos_add('0');" class="btn btn-primary pull-right" style="padding:2px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>
					<div class="clearfix"></div>
						<?php if(count($department_pslos_undergraduate)>0){?>
						<table class="table table-bordered table-hover table-striped">
							<?php $i=1; foreach($department_pslos_undergraduate as $undergraduate){?>			
							
								<tr>
									<td><h4 class="pslo-title"><?php echo $i.'. <span class="st" id="msg_'.$undergraduate->id.'">'.$undergraduate->plso_prefix.'</span>: <span id="title_msg_'.$undergraduate->id.'">'.$undergraduate->plso_title.'</span>'; ?></h4></td>
									<td nowrap="nowrap"><a onclick="return open_model_plsos_edit('0', '<?php echo $undergraduate->id;?>');" class="btn btn-success btn-xs">Edit</a>
									<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>envision/plso_delete?id=<?php echo $undergraduate->id; ?>&status=0" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
								</tr>			 
							
							<?php $i++; } ?>
						</table>
						<?php }else{ echo '<h4 class="padding10"><i>-- no data available --</i>';} ?>
 				</div>
			</div>
		</div>

		<div id="department_program_goals" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==4){echo 'block';}else{echo 'none';}?>">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Graduate PSLOs </h3>
					</div>
					<a onclick="return open_model_plsos_add('1');" class="btn btn-primary pull-right" style="padding:2px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New</a>
					<div class="clearfix"></div>	
						<?php if(count($department_pslos_graduate)>0){?>			
						<table class="table table-bordered table-hover table-striped">
							<?php $i=1; foreach($department_pslos_graduate as $graduate_courses){?>			
							
								<tr>
									<td><h4 class="pslo-title"><?php echo $i.'. <span class="st" id="msg_'.$graduate_courses->id.'">'.$graduate_courses->plso_prefix.'</span>: <span id="title_msg_'.$graduate_courses->id.'">'.$graduate_courses->plso_title.'</span>'; ?></h4></td>
									<td nowrap="nowrap"><a onclick="return open_model_plsos_edit('1', '<?php echo $graduate_courses->id;?>');" class="btn btn-success btn-xs">Edit</a>
									<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>envision/plso_delete?id=<?php echo $graduate_courses->id; ?>&status=1" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
								</tr>			 
							
							<?php $i++; } ?>
						</table>
						<?php }else{ echo '<h4 class="padding10"><i>-- no data available --</i>';} ?>				
				</div>
			</div>
		</div>
		
		<div id="program_learning_outcomes" class="subcontent margin20" style="display:<?php if(isset($_GET['tab_id']) && $_GET['tab_id']==5){echo 'block';}else{echo 'none';}?>">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Program Learning Outcomes (PLO) </h3>
					</div>
					<a onclick="return open_model_plsos_add('2');" class="btn btn-primary pull-right" style="padding:2px 10px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Program</a>
					<div class="clearfix"></div>	
						<?php if(count($program_learning_outcomes_data)>0){?>			
						<table class="table table-bordered table-hover table-striped">
							<?php $i=1; foreach($program_learning_outcomes_data as $ploData){?>			
							
								<tr>
									<td><h4 class="pslo-title"><?php echo $i.'. <span class="st" id="msg_'.$ploData->id.'">'.$ploData->plso_prefix.'</span>: <span id="title_msg_'.$ploData->id.'">'.$ploData->plso_title.'</span>'; ?></h4></td>
									<td nowrap="nowrap"><a onclick="return open_model_plsos_edit('2', '<?php echo $ploData->id;?>');" class="btn btn-success btn-xs">Edit</a>
									<a class="btn btn-danger btn-xs" href="<?php echo base_url();?>envision/plso_delete?id=<?php echo $ploData->id; ?>&status=2" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
								</tr>			 
							
							<?php $i++; } ?>
						</table>
						<?php }else{ echo '<h4 class="padding10"><i>-- no data available --</i>';} ?>				
				</div>
			</div>
		</div>

	</div>	  
  
	<div class="box-footer">
		<div class="pull-right">
			<input type="submit" name="envision_previous" class="btn btn-info" value='<< Previous Action1'/>
			<input type="submit" name="envision_next" class="btn btn-info" value='Next Action3 >>'/>
		</div>
	</div> 

</div>
</form>


<div class="modal fade" id="dialog_open_model_plsos_add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="plsos_add_popup_title"></strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
   
			<div class="modal-body" style="padding:10px;">
				<form method="post" id="frm_pop" action="<?php echo base_url();?>envision/add_ugrad_grad_plso_entry">
					<div class="form-group">
						<input type="text" id="txt_add_plso_prefix" name="txt_add_plso_prefix" class="form-control required" value="" placeholder="PSLO Prefix" />
					</div>
					
					<div class="form-group">
						<textarea id="txt_add_plso_title" name="txt_add_plso_title" rows="5" class="form-control required"  placeholder="PSLO Description"></textarea>
						<input type="hidden" name="hadd_pslos_status" id="hadd_pslos_status" value="" />
					</div>
					
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary view_btn" value='Submit Now!' />
					</div>
				</form>				
				<div class="clearfix"></div>
			</div>
    	</div>
	</div>
</div>

<div class="modal fade" id="dialog_open_model_plsos_edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width:500px;">
        <div class="modal-content">
            <div class="modal-header">
	            <strong id="plsos_edit_popup_title"></strong>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
   
			<div class="modal-body" style="padding:10px;">
				<form method="post" id="frm_pop" action="<?php echo base_url();?>envision/edit_ugrad_grad_plso_entry">
					<div class="form-group">
						<input type="text" id="txt_edit_plso_prefix" name="txt_edit_plso_prefix" class="form-control required" value="" placeholder="PSLO Prefix" />
					</div>
					
					<div class="form-group">
						<textarea id="txt_edit_plso_title" name="txt_edit_plso_title" rows="5" class="form-control required"></textarea>
						<input type="hidden" name="hedit_pslos_status" id="hedit_pslos_status" value="" />
						<input type="hidden" name="hupdate_id" id="hupdate_id" value="" />
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
<script>
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

function open_model_plsos_add(pslos_status){
	if(pslos_status==0){
		var pop_title = 'Undergraduate PSLOs : : Add';
	}else if(pslos_status==1){
		var pop_title = 'Graduate PSLOs : : Add';
	}else{
		var pop_title = 'Program Learning Outcome : : Add';
	}
	
	if(pslos_status==2){
		jQuery('#txt_add_plso_prefix').attr('placeholder','PLO Prefix');
		jQuery('#txt_add_plso_title').attr('placeholder','Intervention title (i.e., name of workshop, training or course etc.)');
	}else{
		jQuery('#txt_add_plso_prefix').attr('placeholder','PSLO Prefix');
		jQuery('#txt_add_plso_title').attr('placeholder','PSLO Description');
	}
	
	jQuery('#hadd_pslos_status').val(pslos_status);
	jQuery('#plsos_add_popup_title').html(pop_title);
	jQuery("#dialog_open_model_plsos_add").modal('show');
}

function open_model_plsos_edit(pslos_status,id){
	if(pslos_status==0){
		var pop_title = 'Undergraduate PSLOs : : Edit';
	}else if(pslos_status==1){
		var pop_title = 'Graduate PSLOs : : Edit';
	}else{
		var pop_title = 'Program Learning Outcome : : Edit';
	}
	if(pslos_status==2){
		jQuery('#txt_add_plso_prefix').attr('placeholder','PLO Prefix');
		jQuery('#txt_add_plso_title').attr('placeholder','Intervention title (i.e., name of workshop, training or course etc.)');
	}else{
		jQuery('#txt_add_plso_prefix').attr('placeholder','PSLO Prefix');
		jQuery('#txt_add_plso_title').attr('placeholder','PSLO Description');
	}
	jQuery('#hedit_pslos_status').val(pslos_status);
	jQuery('#plsos_edit_popup_title').html(pop_title);
	jQuery('#hupdate_id').val(id);
	var txt_content_prefix = jQuery('#msg_'+id).html();
	var txt_content_title = jQuery('#title_msg_'+id).html();
	jQuery('#txt_edit_plso_prefix').val(txt_content_prefix);
	jQuery('#txt_edit_plso_title').val(txt_content_title);
	jQuery("#dialog_open_model_plsos_edit").modal('show');	
}
</script>