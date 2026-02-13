<section class="content">
	<div class="box">
		<div class="box-header no-border">
            <h3 class="box-title">These email templates are automatically sent when users are added to your team.</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="emailSearchInput" placeholder="Search email templates..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="clearEmailSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
		<div class="box-body row"> 
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped" id="table_recordtbl12">
					<thead>
						<tr>
							<th width="3%">#</th>
							<th>Purpose</th> 
							<th>Subject</th>  
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach ($emailsList as $email_templates) { ?>
						<tr>
							<td><?php echo  $i;?></td>
							<td style="font-weight:500;"><?php echo $email_templates->purpose;?></td> 
							<td><?php echo $email_templates->subject;?></td> 	  
							<td>
								<button type="button" onclick="return email('<?php echo $email_templates->id;?>');" id="unet<?php echo $email_templates->id;?>" class="btn btn-primary btn-sm">Edit</button> 					
							</td>
						</tr>
						<?php  $i++; } ?> 			
					</tbody>				  
				</table>			
			</div>      
		</div>   
	</div>
</section>


<div class="modal fade" id="emailModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="emailModalLabel">Email Template</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="emailFrm" action="settings/updateEmailContent" method="post">
			<div id="resDayT"></div>
			 <div class="row">	
				<div class="col-12 mx-0">	
				<div class="alert btn-warning">WARNING: If you choose to edit this template, please ensure that the bracketed placeholders (e.g., {Name}, {Role}) remain unchanged. Modifying or removing these placeholders may result in an error when the email is generated</div>			 
				</div>
				<div id="emailFieldSec"></div>	
							 
				<div class="col-12 mt-2">
					<button type="submit" id="emailSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Update</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>

<script>
function email(eId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'settings/ajaxEmailFields?eId=';?>'+eId,
        beforeSend: function(){            
			$('#unet'+eId).prop("disabled", true);
			$('#unet'+eId).html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(result, status, xhr){
            $('#emailFieldSec').html(result);
            $('#emailModal').modal('show');
            $('#unet'+eId).html('Edit');
			$('#unet'+eId).prop("disabled", false);
        }
    });	    
}
$(document).ready(function () {
	// Search functionality
	function filterEmailsTable(){
		var searchText = $('#emailSearchInput').val().toLowerCase();
		$('#table_recordtbl12 tbody tr').each(function(){
			var rowText = $(this).text().toLowerCase();
			$(this).toggle(searchText === '' || rowText.indexOf(searchText) > -1);
		});
	}

	$('#emailSearchInput').on('input', function(){
		var v = $(this).val();
		if(v.length > 0){ $('#clearEmailSearch').css('display','flex'); } else { $('#clearEmailSearch').hide(); }
		filterEmailsTable();
	});
	$('#clearEmailSearch').on('click', function(){
		$('#emailSearchInput').val('');
		$(this).hide();
		filterEmailsTable();
	});

	$('#emailFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#emailSaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#emailFrm');
			var url = site_base_url+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#emailSaveBtn').prop("disabled", true);
					$('#emailSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#emailSaveBtn').prop("disabled", false);
						$('#emailSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>