<section class="content">
	<div class="row">
<style>
.table small {display: block;margin-left: 5px; font-size: 95%;margin-top: 2px; font-weight:600;}
.mstus {border: 1px dashed;padding: 1px 10px;margin-bottom: 0;font-size: 14px;}
.accepted {color: green;}
.rejected {color: #a94442;}
.table .btn-group-sm>.btn, .btn-sm {font-size:13px;}
.org_details{ margin-bottom:10px;}
.org_details p{ margin-bottom:0; line-height:30px; margin-left:10px; font-size:16px;}
</style>
		<div class="col-md-12">
			<div class="box">
				<div class="box-body row">
					<div class="col-md-12">
						<h4 style="font-weight:600;">Organization: <?php echo $orgainzation_details->organizationName;?></h4>
						<div class="org_details">
							<p>Type of Account: &nbsp;&nbsp;<?php echo $this->config->item('organization_types_array_config')[$orgainzation_details->organizationType]['name'];?></p>
							<p>Type of Subcription : &nbsp;&nbsp;<?php echo $this->config->item('subscription_types_array_config')[$orgainzation_details->subscriptionType]['name'];
							
						if(isset($orgainzation_details->regCost) && $orgainzation_details->regCost!='' && $orgainzation_details->regCost>0){echo ' <strong>[$'.number_format($orgainzation_details->regCost,2).']</strong>';}
							?></p>
							<p>Expire On: &nbsp;&nbsp;<?php if(isset($orgainzation_details->expire_date) && $orgainzation_details->expire_date!='' && $orgainzation_details->expire_date>0){echo date('d M Y',$orgainzation_details->expire_date);}else{echo '&mdash;';}?></p>
							<p>Register Date: &nbsp;&nbsp;<?php if(isset($orgainzation_details->createDate) && $orgainzation_details->createDate!='' && $orgainzation_details->createDate>0){echo date('d M Y',$orgainzation_details->createDate);}else{echo '&mdash;';}?></p>
							<p>
							Institutional Account Members: &nbsp;&nbsp;<?php echo $orgainzation_details->instAccountMembers;?>
							</p>
						</div>
					</div>
					<div class="col-md-12" style="margin-bottom:5px;">
						<h4 style="font-weight:600;">Institutional Member's</h4>
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12 table-responsive">
						<table class="table table-striped table-bordered">
							<tr>
								<th width="1%">#</th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Directory</th>
								<?php if($orgainzation_details->organizationType==2){?><th>Sponsor</th><?php } ?>
								<th>Region</th>
								<th>Address</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							<?php $i=1; foreach($orgainzation_members_data as $member){?>
							
								<tr>
									<td><?php echo $i;?></td>
									<td><?php echo $member->firstName.' '.$member->lastName; ?><small><?php echo $member->contactNo; ?></small></td>
									<td><?php echo $member->email; ?><small><?php echo 'P: '.$member->password_v; ?></small></td>
									<td><?php if($member->isDirectory==1){echo 'Yes';}else{echo 'No';}?></td>
									<?php if($orgainzation_details->organizationType==2){?><td><?php if($member->sponsorSts==1){echo 'Yes';}else{echo 'No';}?></td><?php } ?>
									<td><?php if($member->regionId>0){echo $this->config->item('region_array_config')[$member->regionId]['name'];}else{echo '&ndash;';}?></td>
									<td><?php echo $member->streetAddress;?><small><?php echo $member->city.' - '.$member->zipCode;?></small></td>
									<td><?php if($member->isActive == 1){?>
				                         	<label class="mstus accepted" style="padding:0px 10px;">Active</label>
				                         <?php }else{ ?>
				                         	<label class="mstus rejected" style="padding:0px 10px;">In-active</label>
				                         <?php } ?></td>
									<td>
									<a id="editMem<?php echo $member->memberId;?>" class="btn btn-success btn-sm" onclick="return editMemeber('<?php echo $orgainzation_details->organizationId;?>','<?php echo $member->memberId;?>');">Edit</a>
									<a onclick="return deleteMember('<?php echo $orgainzation_details->encryptId;?>','<?php echo $member->memberId; ?>');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							<?php $i++;} ?>
						</table>
					</div>
					 
					
				</div>
				<?php //if($orgainzation_details->organizationType==4 && $orgainzation_details->subscriptionType==3){?>
				<div class="box-footer">
					<button type="button" id="addMemBtn" onclick="return addMember('<?php echo $orgainzation_details->organizationId;?>');" class="btn btn-primary">Add Member</button>
				</div>
				<?php //} ?>
			</div>
		</div>
<script type="text/javascript">
function deleteMember(encryptId,memberId) {
	if (memberId != "") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
			window.location = "<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'users/delete_member/';?>?memberId="+memberId+'&encryptId='+encryptId;
		}
	}
}
function editMemeber(organizationId, memberId){
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->config->item('admin_directory_name');?>users/ajax_edit_member?organizationId='+organizationId+'&memberId='+memberId,
		beforeSend: function(){
			$('#h_form_action').val('users/edit_member_entry');
			$('#popTitle').html('Edit Member');
			$('#editMem'+memberId).html('<i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			$('#memberInnerDiv').html(result);
			$("#memberModal").modal('show');
			$('#editMem'+memberId).html('Edit');
		}
	});
}
</script>
<?php //if($orgainzation_details->organizationType==4 && $orgainzation_details->subscriptionType==3){?>
<script>
function addMember(organizationId){
	$.ajax({
		type: "POST",
		url: '<?php echo base_url().$this->config->item('admin_directory_name');?>users/ajax_add_member?organizationId='+organizationId,
		beforeSend: function(){
			$('#h_form_action').val('users/add_member_entry');
			$('#popTitle').html('Add Member');
			$('#addMemBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
		},
		success: function(result, status, xhr){
			$('#memberInnerDiv').html(result);
			$("#memberModal").modal('show');
			$('#addMemBtn').html('Add Member');
		}
	});
}
</script>
<div class="modal fade" tabindex="-1" role="dialog" id="memberModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="display:inline-block" id="popTitle"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
			<form id="manageMemberFrm" action="" method="post">
				
				<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url().$this->config->item('admin_directory_name');?>" />
				<input type="hidden" id="h_ajax_base_url" name="h_ajax_base_url" value="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name');?>" />
				<input type="hidden" id="h_form_action" name="h_form_action" value="" />
				
				<div id="memberInnerDiv"></div>						 
				
				<div class="row">
					<div class="text-center my-3">
						<button type="submit" id="manageBtn" class="btn btn-primary " style="padding:5px 50px;">Save & Update</button>
					</div>
				</div>
			</form>
		</div>
  </div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#manageMemberFrm').validate({
			ignore: [], 
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
			},
			success: function(element) {
				element.closest('.form-group').removeClass('has-error');
				element.remove();
			},
			rules: {
				new_password: {
					required: true,
					pwcheck: true,
					minlength: 8	
				},	
				confirm_password: {
					equalTo: "#new_password",
				}	
			},
			messages: {
				new_password: {
					required: "Password Required",
					pwcheck: "Password must contain at least one uppercase (A-Z) and one lowercase (a-z) and one (0-9) and one special character and at least eight characters.",
					minlength: "Password must contain at least eight characters."
				}
			},
			errorElement: 'label',
			errorClass: 'error',
			errorPlacement: function (error, element) {
				if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.prop('type') === 'file') {
					error.insertAfter(element.parent());
				}else {
					error.insertAfter(element);
				}
			},
			submitHandler: function(form){
				var site_base_url = $('#h_base_url').val();
				var ajax_base_url = $('#h_ajax_base_url').val();
				var form = $('#manageMemberFrm'); 
				var form_action = $('#h_form_action').val();
				var url = ajax_base_url+form_action;				
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(),
					beforeSend: function(){
						$('#manageBtn').prop("disabled", true);
						$('#manageBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
					},
					success: function(result, status, xhr){
						var result_arr = result.split('||');
						if(result_arr[0]=='success'){
							window.location = site_base_url+'users/details/<?php echo $orgainzation_details->encryptId; ?>';			
						}else{						
							$('#result_display').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
							$("html, body").animate({ scrollTop: 0 }, "fast");
							$('#manageBtn').prop("disabled", false);
							$('#manageBtn').html('Save & Update');				
						}
					},
					error: function(xhr, status, error_desc){				
						$('#result_display').html('<div class="alert alert-danger"><strong>Error : </strong> '+error_desc+'</div>');
						$("html, body").animate({ scrollTop: 0 }, "fast");
						$('#manageBtn').prop("disabled", false);
						$('#manageBtn').html('Save & Update');
					}
				});		
				return false;
			}
		});
		$.validator.addMethod("pwcheck", function(value) {
		   return /^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{8,}$/.test(value);
		});
	});
</script>
<?php //} ?>
	</div>
</section>