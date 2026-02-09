<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >

<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">

<!-- general form elements -->
	<div class="box">
		<div class="box-body">
		<div class="col-md-8">	
			
			<input type="hidden" name="hidden_university_id" id="hidden_university_id" value="<?php if(!empty($Popup_messages_detail_row->university_id)){echo $Popup_messages_detail_row->university_id;} else{echo ""; }?>">	 
				 			
			<div class="form-group">
				<label class="control-label" for="inputEmail3">Title*</label>
					<input type="text" class="form-control required" id="title" name="title" placeholder="Title" value="<?php if(!empty($Popup_messages_detail_row->title)){echo $Popup_messages_detail_row->title;} else{echo ""; }?>"  >
					<span style="color:red;"><?php echo form_error('title'); ?></span>
				
			</div>

			<div class="form-group">
				<label class="control-label" for="inputEmail3">Description*</label>
				
					<textarea class="form-control required" id="editor" name="description"><?php if(!empty($Popup_messages_detail_row->description)){echo $Popup_messages_detail_row->description;} else{echo ""; }?></textarea>
					<span style="color:red;"><?php echo form_error('description'); ?></span>
				
			</div>
						
		</div>
		</div> 

		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	</div> 
</form>
</div>
</section>




