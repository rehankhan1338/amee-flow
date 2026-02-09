<section class="content">
	<div class="row">
		<div class="col-md-12" >
			<form class="" id="cmsFrm" method="post" action="cms/saveGuide">
<?php 
if($guideFor=='project-manager'){
   $oldguideDoc = $conDetails->pmGuide; 
   $shareURL = base_url().'share/guide/project-manager';
}else if($guideFor=='area-expert'){
   $oldguideDoc = $conDetails->areaExpertGuide; 
   $shareURL = base_url().'share/guide/area-expert';
}else{
   $oldguideDoc = $conDetails->userGuide; 
   $shareURL = base_url().'share/guide/user'; 
}
?>
				<input type="hidden" id="baseUrl" name="baseUrl" value="<?php echo base_url().$this->config->item('admin_directory_name');?>" />
				<input type="hidden" id="guideFor" name="guideFor" value="<?php if(isset($guideFor) && $guideFor!=''){echo $guideFor;}?>" />
                <input type="hidden" id="oldguideDoc" name="oldguideDoc" value="<?php echo $oldguideDoc;?>" />
				<div class="box no-border">	 
					<div class="box-body row" >
						
						<div id="resDisplay"></div>
						
						<div class="col-12">							
							<div class="form-group">								
								<label class="col-form-label">Upload your latest <?php echo strtolower($guideName);?> guide</label> <br />
								<input type="file" class="required" id="guideDoc" name="guideDoc" />
							</div>						
                        </div>
                        <div class="col-12 my-3">	
                            <button class="btn btn-primary" id="submitBtn" type="submit" style="padding:6px 50px;">Save</button>
                        </div>
 					  
						
					</div> 
                    <?php if(isset($oldguideDoc) && $oldguideDoc!=''){ //  target="_blank" href="<?php echo $shareURL;>"?>
                    <div class="box-footer py-3">
                        <h5 class="fs17" style="line-height:30px;">Share URL: <br /><?php echo $shareURL;?></h5>
                        <!-- <button type="button" class="btn btn-secondary w100" style="width:100%;"><?php //echo $shareURL;?></button> -->
                    </div>
                    
					<div class="box-footer">
						<iframe style="width:100%; height:650px;" frameborder="0" src="<?php echo base_url().'assets/guide/'.$oldguideDoc;?>"></iframe>
					</div>
                    <?php } ?>
				</div>
			
			</form>
<script>
$(document).ready(function(){
	$('#cmsFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){			
			var btnText = $('#submitBtn').html();
			var site_base_url = $('#baseUrl').val();
			var form = $('#cmsFrm');
			var url = site_base_url+form.attr('action');
            var formData = new FormData($('#cmsFrm').get(0));
			formData.append('guideDoc', $('#guideDoc')[0].files[0]);
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#submitBtn').prop("disabled", true);
					$('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||');
					if(result_arr[0]=='success'){
						window.location=result_arr[1];							
					}else{
						$("html, body").animate({ scrollTop: 0 }, "slow");
						$('#resDisplay').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#submitBtn').prop("disabled", false);
						$('#submitBtn').html(btnText);
					}
				},
				error: function(xhr, status, error_desc){				
					$("html, body").animate({ scrollTop: 0 }, "slow");
					$('#resDisplay').html('<div class="alert alert-danger">'+error_desc+'</div>');
					$('#submitBtn').prop("disabled", false);
					$('#submitBtn').html(btnText);
				}
			});			
			return false;
		}
	});
});
</script>
		</div>
	</div>
</section>