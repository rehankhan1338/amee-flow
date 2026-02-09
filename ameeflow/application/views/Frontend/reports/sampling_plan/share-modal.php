<div class="modal fade" id="popShareModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popShareModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
     
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popShareModelLabel">Share Your <?php echo $this->config->item('share_report_for_array_config')[$shareReportFor]['name'];?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popShareFrm" action="home/shareSamplingPlan" method="post">
			<div id="popShareRes" class="ajaxFrmRes"></div>
            <input type="hidden" id="h_shareReportFor" name="h_shareReportFor" value="<?php echo $shareReportFor;?>" /> 
            <input type="hidden" id="h_chkId" name="h_chkId" value="<?php echo $chkId;?>" />
            <input type="hidden" id="h_chkenId" name="h_chkenId" value="<?php echo $chkenId;?>" />
            <input type="hidden" id="h_chkuserId" name="h_chkuserId" value="<?php echo $sessionDetailsArr['userId'];?>" />
            <input type="hidden" id="h_chkuniversityId" name="h_chkuniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="h_chkuserName" name="h_chkuserName" value="<?php echo $sessionDetailsArr['userName'];?>" />
            <input type="hidden" id="h_chkuserEmail" name="h_chkuserEmail" value="<?php echo $sessionDetailsArr['userEmail'];?>" />
			 <div class="row">	
				<div id="popShareFieldSec">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-fields">
                                <label class="form-label">Submit for Review/Feedback & Approval *</label>
                                <select id="txt_submitFor" name="txt_submitFor" class="form-control required" onchange="return ajaxSPAIContent(this.value,'<?php echo $shareReportFor;?>','<?php echo $sessionDetailsArr['userId'];?>');">
                                    <option value="">Select...</option>
                                    <option value="1">Submit for review/feedback</option>
                                    <option value="2">Submit for approval</option>
                                    
                                </select>
                            </div>
                            <div class="form-fields" id="shareMsgContentSec">
                                
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-fields">
                                <label class="form-label"> Role Type *</label>
                                <select id="txt_roleType" name="txt_roleType" class="form-control required" onchange="return ajaxGetRoles(this.value);">
                                    <option value="">Select...</option>
                                    <?php $roleTypes = $this->config->item('user_roles_array_config');
                                    foreach($roleTypes as $key=>$value){ 
                                        if($value['status']==0){
                                            //if($shareReportFor!=1 && $key==4){}else{}?>
                                    <option value="<?php echo $key;?>" ><?php echo $value['name']; if(isset($value['shortDesc']) && $value['shortDesc']!=''){echo ' ('.$value['shortDesc'].')';} ?></option>
                                    <?php } } ?>
                                    <option value="self">Send to Self</option>
                                </select>
                            </div>
                            <button type="button" id="toggleCheckboxBtn" style="padding:5px 30px; display:none;" class="btn btn-warning btn-sm mb-1">Check All</button>
                            <div class="row px-2 fs16" id="shareToRes">
                                
                            </div>
                        </div>
                    </div>
                   
                </div>				 
				<div class="col-12 mt-2 firstHide" style="display:none;">
					<button type="submit" id="popShareSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Share</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function ajaxSPAIContent(submitFor,reportFor,userId){
    if(submitFor!=''){
        // var speId = $('#h_speId').val();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'home/ajaxSPAIContent?submitFor=';?>'+submitFor+"&reportFor="+reportFor+"&userId="+userId,
            beforeSend: function(){
                $('#popShareRes').html('');        
                $('#shareMsgContentSec').html('<h5 class="fs18 mx-2 my-4"> <i class="fa fa-spinner fa-spin"></i> Generating AI content</h5>');           
            },
            success: function(result, status, xhr){
                $('#shareMsgContentSec').html(result);           
            }
        });
    }
}
function shareReport(spId){
    $('#popShareModel').modal('show');	    
}
function ajaxGetRoles(rtype){
    if(rtype!=''){
        // var spId = $('#h_chkId').val();
        var spId = 0;
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'sampling_plan/ajaxGetRoles?rtype=';?>'+rtype+"&spId="+spId,
            beforeSend: function(){  
                $('#popShareRes').html('');
                if(parseInt(rtype)==4){
                    $('#toggleCheckboxBtn').show();
                }else{
                    $('#toggleCheckboxBtn').hide();
                }
                $('#shareToRes').html('<h5 class="fs18 mx-2 my-2"> <i class="fa fa-spinner fa-spin"></i> Please Wait</h5>');           
            },
            success: function(result, status, xhr){
                $('#shareToRes').html(result);
                $('.firstHide').show();            
            }
        });
    }
}
$(document).ready(function () {
	let allChecked = false;
	$('#toggleCheckboxBtn').on('click', function () {
		allChecked = !allChecked;
		$('.caseRoleIds').prop('checked', allChecked);
		$(this).text(allChecked ? 'Uncheck All' : 'Check All');
	}); 
    $('#popShareFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popShareSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popShareFrm');
			var url = site_base_url+form.attr('action');
            for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
                    $('#popShareRes').html('');
					$('#popShareSaveBtn').prop("disabled", true);
					$('#popShareSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
                        // $('#popShareSaveBtn').prop("disabled", false);
						// $('#popShareSaveBtn').html(btnText);
						// $('#popShareModel').modal('hide'); 
                        window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#popShareRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popShareSaveBtn').prop("disabled", false);
						$('#popShareSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>