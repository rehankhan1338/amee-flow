<div class="modal fade" id="popShareModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popShareModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
<?php
$subContent = "You've been assigned an alignment map to review.";
$msgContent = '<p>Dear {receiverName}</p> 
<p>Please click the link below to view the alignment map for your program and provide your feedback or confirmation by the indicated deadline.</p>
<p><a href="{receiverActionLink}">{receiverActionLink}</a> </p>
<p>Let us know if you have any questions.</p>
<p>Warm Regards<br />'.$sessionDetailsArr['auName'].'</p>';


?>
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popShareModelLabel">Share Your Alignment Map</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popShareFrm" action="home/shareAlignmentMap" method="post">
			<div id="popShareRes" class="ajaxFrmRes"></div>
            <input type="hidden" id="shareFrom" name="shareFrom" value="<?php echo $shareFrom;?>" /> 
            <input type="hidden" id="seloversigntId" name="seloversigntId" value="<?php echo $seloversigntId;?>" />
            <input type="hidden" id="mamId" name="mamId" value="<?php echo $mamDetailsArr['mamId'];?>" />
            <input type="hidden" id="userId" name="userId" value="<?php echo $sessionDetailsArr['userId'];?>" />
            <input type="hidden" id="userAccessId" name="userAccessId" value="<?php echo $sessionDetailsArr['userAccessId'];?>" />
            <input type="hidden" id="universityId" name="universityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="uniAdminId" name="uniAdminId" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
            <input type="hidden" id="auName" name="auName" value="<?php echo $sessionDetailsArr['auName'];?>" />
            <input type="hidden" id="auEmailId" name="auEmailId" value="<?php echo $sessionDetailsArr['auEmailId'];?>" />
			 <div class="row">	
				<div id="popShareFieldSec">
                    <!-- Oversight & Department Row -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-fields">
                                <label class="form-label">Oversight Unit *</label>
                                <select id="shareOversigntId" name="shareOversigntId" class="form-control required" onchange="return populateShareDepartments(this.value);">
                                    <option value="">Select Oversight Unit...</option>
                                    <?php foreach($oversightsDataArr as $osd){ ?>
                                    <option value="<?php echo $osd['oversigntId'];?>" <?php if($seloversigntId==$osd['oversigntId']) echo 'selected';?>><?php echo htmlspecialchars($osd['unitName']);?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-fields">
                                <label class="form-label">Department *</label>
                                <select id="shareDepartment" name="shareDepartment" class="form-control required">
                                    <option value="">Select Department...</option>
                                    <option value="all">All Departments</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-fields">
                                <label class="form-label">Subject *</label>
                                <input type="text" id="amSubject" name="amSubject" value="<?php echo $subContent;?>" class="form-control required" autocomplete="off" /> 
                            </div>
                            <div class="form-fields" id="shareMsgContentSec">
                               <label class="form-label">Message *</label>
                               <textarea id="editor" name="amContent"> <?php echo $msgContent;?> </textarea>
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
                                    <option value="other">Other</option>
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
/* ── Populate department dropdown from courses in selected oversight ── */
function populateShareDepartments(oversigntId){
    var $dept = $('#shareDepartment');
    $dept.html('<option value="">Loading...</option>');
    if(!oversigntId || oversigntId===''){
        $dept.html('<option value="">Select Department...</option><option value="all">All Departments</option>');
        return;
    }
    $.ajax({
        type: 'GET',
        url: '<?php echo base_url();?>sampling_plan/ajaxGetDepartments?oversigntId='+oversigntId,
        dataType: 'json',
        success: function(res){
            var html = '<option value="">Select Department...</option><option value="all">All Departments</option>';
            if(res && res.length > 0){
                for(var i=0; i<res.length; i++){
                    html += '<option value="'+res[i]+'">'+res[i]+'</option>';
                }
            }
            $dept.html(html);
        },
        error: function(){
            $dept.html('<option value="">Select Department...</option><option value="all">All Departments</option>');
        }
    });
}
/* auto-populate departments for the currently selected oversight on modal open */
$(document).on('shown.bs.modal', '#popShareModel', function(){
    var curOsd = $('#shareOversigntId').val();
    if(curOsd && curOsd !== '') populateShareDepartments(curOsd);
});

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