<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box no-border">
				<div class="box-header no-border">
					<h3 class="box-title">Create your support ticket</h3>
					<div class="box-tools pull-right"> 
						<a style="padding: 3px 15px;vertical-align:top; margin-left:5px;" href="<?php echo $ticketSecBaseUrl.'tickets';?>" class="btn btn-primary" > Back </a>					
					</div>
				</div>
				<div class="box-body row ticket_page">      
 		 
					<form class="" method="post" id="ticketFrm" action="home/ticketEntry">
						<input type="hidden" name="createdBy" id="createdBy" value="<?php echo $createdBy;?>" />
						<input type="hidden" name="createdById" id="createdById" value="<?php echo $createdById;?>" />
						<input type="hidden" id="msg_by" name="msg_by" value="<?php echo $msg_by;?>" />
						<input type="hidden" name="ticketSecBaseUrl" id="ticketSecBaseUrl" value="<?php echo $ticketSecBaseUrl;?>" />
						<div id="resTicket"></div>
						<div class="col-md-12">
							<div class="form-fields">
								<label class="form-label" for="fs_title">Type of Support *</label>
								<?php $support_types=$this->config->item('support_types_array_config');?>
								<select name="type_of_support" class="form-control required" id="type_of_support">
									<option value="">Select...</option>
									<?php foreach($support_types as $key => $value){ if($value['status']==0){?>
									<option value="<?php echo $key;?>"><?php echo $value['name'];?></option>
									<?php } }?>
								</select>
							</div>
							<div class="form-fields">
								<label class="form-label">Message *</label>
								<textarea name="ticketMsgContent" id="editor"></textarea>
							</div>
							
						</div>
						<div class="clearfix"></div>	 	 			
						<div class="col-md-12">
							<div class="clearfix"></div>
							<button type="submit" class="btn btn-primary mt-2" id="addTicketBtn" style="padding:6px 30px;">Submit Now!</button>	
						</div>
						<div class="clearfix"></div>	
					</form>
				</div>	 
			</div>
		</div>
	</div>
</section>

<script>

$(function() {
	
	$('#ticketFrm').validate({
		ignore: [],
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnTxt = $('#addTicketBtn').html();
			var baseUrl = '<?php echo base_url(); ?>';
			var form = $('#ticketFrm');
			var url = baseUrl+form.attr('action');
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
            $.ajax({
                type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function() {
					$('#addTicketBtn').prop("disabled", true);
					$('#addTicketBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr) {
					var resultArr = result.split('||');
					if(resultArr[0] == 'success'){
						window.location = resultArr[1];
					}else{
						$('#resTicket').html('<div class="alert alert-danger">' + resultArr[1] + '</div>');
						$("html, body").animate({scrollTop: 0}, "slow");
						$('#addTicketBtn').html(btnTxt);
						$('#addTicketBtn').prop("disabled", false);
					}
				},
				error: function(xhr, status, error_desc){
					$("html, body").animate({scrollTop: 0}, "slow");
					$('#resTicket').html('<div class="alert alert-danger">' + error_desc + '</div>');
					$('#addTicketBtn').html(btnTxt);
					$('#addTicketBtn').prop("disabled", false);
				}
			});
			return false;
		}
	});
});
</script>