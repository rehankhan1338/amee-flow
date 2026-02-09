<section class="content">
<div class="row">
<div class="col-md-12">
<div class="box">
<form class="form-horizontal" id="topSectionFrm" method="post" action="cms/top_section_update">
	<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url().$this->config->item('admin_directory_name'); ?>" />
	<input type="hidden" name="h_page_name" id="h_page_name" value="<?php echo $top_section->page_name;?>" />
	<input type="hidden" name="h_module_name" id="h_module_name" value="<?php echo $top_section->module_name;?>" />
	<div class="box-body">
          		  		 
		<div class="col-md-12">
		
			<div class="form-group" >
				<label class="col-sm-3 control-label">Title Line *</label>
				<div class="col-md-8">
					<textarea rows="3" class="form-control required" id="content" name="content"><?php if(isset($top_section->content) && $top_section->content!=''){echo $top_section->content;}?></textarea>
				</div>
			</div> 			 
			
			<div class="form-group" >
				<label class="col-sm-3 control-label">Short Title *</label>
				<div class="col-md-8">
					<input type="text" class="form-control required" id="title_span" name="title_span" placeholder="Sub Title" value="<?php if(isset($top_section->title_span) && $top_section->title_span!=''){echo $top_section->title_span;}?>" />
				</div>
			</div>
			
			<div class="form-group" >
				<label class="col-sm-3 control-label">Button Text *</label>
				<div class="col-md-8">
					<input type="text" class="form-control required" id="subtitle" name="subtitle" placeholder="Sub Title" value="<?php if(isset($top_section->subtitle) && $top_section->subtitle!=''){echo $top_section->subtitle;}?>" />
				</div>
			</div>
			
			<div class="form-group" >
				<label class="col-sm-3 control-label">Theme Title *</label>
				<div class="col-md-8">
					<input type="text" class="form-control required" id="title" name="title" placeholder="Sub Title" value="<?php if(isset($top_section->title) && $top_section->title!=''){echo $top_section->title;}?>" />
				</div>
			</div> 
			
			<div class="form-group" >
				<label class="col-sm-3 control-label">Start Date * </label>
				<div class="col-md-8">
					<input type="text" class="form-control required" id="Date1" name="startDate" placeholder="" value="<?php if(isset($top_section->image) && $top_section->image!=''){echo date('m/d/Y',$top_section->image);}?>" />
				</div>
			</div>

			<div class="form-group" >
				<label class="col-sm-3 control-label">End Date *</label>
				<div class="col-md-8">
					<input type="text" class="form-control required" id="Date2" name="endDate" placeholder="" value="<?php if(isset($top_section->add_date) && $top_section->add_date!=''){echo date('m/d/Y',$top_section->add_date);}?>" />
				</div>
			</div>
 		
		</div>
		
	</div>
	
	<div class="box-footer">	
		<button type="submit" class="btn btn-primary" style="padding:5px 30px;" id="saveBtn">Update Now!</button>
	</div>
</form>

<script>
	$(function() {
		$('#topSectionFrm').validate({
			ignore: [],
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				element.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove();
			},
			submitHandler: function(form) {
				var site_base_url = $('#h_base_url').val();
				var form = $('#topSectionFrm');
				var url = site_base_url + form.attr('action');
				$.ajax({
					type: "POST",
					url: url,
					data: form.serialize(),
					beforeSend: function() {
						$('#saveBtn').prop("disabled", true);
						$('#saveBtn').html('Updating <i class="fa fa-spinner fa-spin"></i>');
					},
					success: function(result, status, xhr) {
						var resultArr = result.split('||');
						if (resultArr[0] == 'success') {
							window.location = site_base_url + 'cms/top_content';
						} else {
							$('#resMsg').html('<div class="alert alert-danger">' + resultArr[1] + '</div>');
							$("html, body").animate({scrollTop: 0}, "slow");
							$('#saveBtn').html('Update Now!');
							$('#saveBtn').prop("disabled", false);
						}
					},
					error: function(xhr, status, error_desc) {
						$("html, body").animate({scrollTop: 0}, "slow");
						$('#resMsg').html('<div class="alert alert-danger">' + error_desc + '</div>');
						$('#saveBtn').html('Update Now!');
						$('#saveBtn').prop("disabled", false);
					}
				});
				return false;
			}
		});
	});
</script>

</div>
</div>
</div>
</section>