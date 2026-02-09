<div class="modal fade" id="popNoteModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popNoteModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popNoteModelLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popNoteFrm" action="sampling_plan/manageClassNotes" method="post">
			<div id="popNoteRes" class="ajaxFrmRes"></div>

            <input type="hidden" id="txtNotesloFor" name="txtNotesloFor" value="" />
            <input type="hidden" id="txtNoteceId" name="txtNoteceId" value="<?php echo $ceId;?>" />
            <input type="hidden" id="txtNoteceClassId" name="txtNoteceClassId" value="0" />
            <input type="hidden" id="txtNotespId" name="txtNotespId" value="<?php echo $spDetails['spId'];?>" />

			 <div class="row">	
				<div id="popNoteFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popNoteSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>

<script>
function manageNotes(ceClassId,sloFor){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/ajaxNoteFields?ceClassId=';?>'+ceClassId+'&sloFor='+sloFor+"&ceId=<?php echo $ceId;?>&spId=<?php echo $spDetails['spId'];?>",
        beforeSend: function(){           
            $('#txtNotesloFor').val(sloFor);  
            $('#txtNoteceClassId').val(ceClassId);  
            $('#popNoteModelLabel').html('Add your note');
            $('#enoteLnk'+sloFor+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');           
        },
        success: function(result, status, xhr){
            $('#popNoteFieldSec').html(result);
            $('#popNoteModel').modal('show');                        
            $('#enoteLnk'+sloFor+ceClassId).html('<i class="icon-sm" data-feather="edit"></i>');
            feather.replace();            
        }
    });	    
}
$(document).ready(function () {
	$('#popNoteFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popNoteSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popNoteFrm');
			var url = site_base_url+form.attr('action');
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(), // serializes the form's elements.
				beforeSend: function(){
					$('#popNoteSaveBtn').prop("disabled", true);
					$('#popNoteSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
                        $('#popNoteSaveBtn').prop("disabled", false);
						$('#popNoteSaveBtn').html(btnText);
						$('#popNoteModel').modal('hide'); 
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#popNoteRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popNoteSaveBtn').prop("disabled", false);
						$('#popNoteSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>