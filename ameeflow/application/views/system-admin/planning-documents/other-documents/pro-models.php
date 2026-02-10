<div class="modal fade" id="addProModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="addProModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="docFrm" action="other_documents/manageDocEntry" method="post">
			<input type="hidden" id="mauniversityId" name="mauniversityId" value="<?php echo $sessionDetailsArr['universityId'];?>" />
            <input type="hidden" id="mauniAdminId" name="mauniAdminId" value="<?php echo $useuniAdminId;?>" />
			<input type="hidden" id="macreatedBy" name="macreatedBy" value="<?php echo $sessionDetailsArr['uniAdminId'];?>" />
			<div id="ajaxRes" class="ajaxFrmRes"></div>
			 <div class="row">					 
				<div id="manageProFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="docSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function deleteDoc(){
	var n = $(".case:checked").length;
	if(n>=1){
		var r = confirm("Are you sure want to delete it!");
        if (r == true) { 
			var new_array=[];
			$(".case:checked").each(function() {
				var n_total=parseInt($(this).val());
				new_array.push(n_total);
			});
			$.ajax({
				type: "POST",
				url: '<?php echo base_url().$this->config->item('system_directory_name').'other_documents/deleteDoc?docIds=';?>'+new_array,
				beforeSend: function(){
					$('#delProBtn').prop("disabled", true);
					$('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					window.location = '<?php echo base_url().$this->config->item('system_directory_name').'other_documents';?>';      
				}
			});
		}
	}else{
		alert("Please select at least one document!");
		return false;
	}
}
function deleteSingleDoc(docId){
	var r = confirm("Are you sure you want to delete this document?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'other_documents/deleteDoc?docIds=';?>'+docId,
			beforeSend: function(){
				$('#deldoc'+docId).prop("disabled", true);
				$('#deldoc'+docId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'other_documents';?>';
			}
		});
	}
}
function update_toggle_swtich_values(docId,column_name){
	if(docId>0){
		var checkstatus=$('#toggle-event-'+column_name+docId).prop('checked');
		if(checkstatus == true){
			var status=0;		
		}else{
			var status=1;		 
		}	
		$.ajax({url: "<?php echo base_url(). $this->config->item('system_directory_name');?>other_documents/update_pro_status?docId="+docId+"&column_name="+column_name+"&status="+status, 
			beforeSend: function(){ 
				$('#spinner_'+column_name+'_'+docId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				if(result=='success'){
					$('#spinner_'+column_name+'_'+docId).html('');
				}
			}
		});
	} 
}
function docField(dType){
	if(parseInt(dType)==1){
		$('#docLnk').show();
		$('#docLnk').addClass('required');
		$('#docUp').hide();
		$('#docUp').removeClass('required');
	}else if(parseInt(dType)==2){
		$('#docLnk').hide();
		$('#docLnk').removeClass('required');
		$('#docUp').show();
		$('#docUp').addClass('required');
	}else{
		$('#docLnk').hide();
		$('#docLnk').removeClass('required');
		$('#docUp').hide();
		$('#docUp').removeClass('required');
	}
}
function manageDoc(docId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'other_documents/ajaxDocFields?docId=';?>'+docId,
        beforeSend: function(){
            if(parseInt(docId)==0){
                $('#addProBtn').prop("disabled", true);
                $('#addProBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
                $('#addProModalLabel').html('Add your document');
            }else{
                $('#addProModalLabel').html('Edit your document');
                $('#epro'+docId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageProFieldSec').html(result);
            $('#addProModal').modal('show');
            if(parseInt(docId)==0){
                $('#addProBtn').prop("disabled", false);
                $('#addProBtn').html('<i class="fa fa-plus"></i> Add New');
            }else{
                $('#epro'+docId).html('Edit');
            }
        }
    });	    
}
$(document).ready(function () {
	$('#docFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#docSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#docFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#docFrm').get(0));
			formData.append('docUp', $('#docUp')[0].files[0]);
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#docSaveBtn').prop("disabled", true);
					$('#docSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#resMam').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#docSaveBtn').prop("disabled", false);
						$('#docSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>