<section class="content">
<div class="row">
<div class="col-md-12" >
 
	<form data-toggle="validator" class="" id="frm" method="post" action="<?php echo base_url();?>admin/content_tutorials/update_sub_heading" enctype="multipart/form-data">
	<div class="box">	
		<div class="box-header with-border">
			<h3 class="box-title" style="display: inline-block;">
				<?php if(isset($_GET['hid'])&& $_GET['hid']!=''){$heading_id = $_GET['hid'];
					echo $heading_name = get_content_tutorials_heading_name_by_heading_id($heading_id);			
				}?>			
			</h3> 
			<div class="box-tools pull-right">
				<a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/content/tutorials/heading?as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-primary"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Menu </a>
				<a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/content_tutorials?hid=<?php echo $heading_id; ?>&as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-default"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Sub-Menu </a>
			</div>
	    </div>
		
		<div class="box-body">	
		<input type="hidden" name="hidden_action_status" id="hidden_action_status" value="<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>"/>						
		<input type="hidden" name="hidden_heading_id" id="hidden_heading_id" value="<?php echo $heading_id;?>"/>						
		<input type="hidden" name="hidden_sub_heading_id" id="hidden_sub_heading_id" value="<?php if(!empty($content_tutorials_sub_heading_rowdetails->id)){echo $content_tutorials_sub_heading_rowdetails->id;}else{echo '';} ?>"/>						
	
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Sub Heading*</label>
					<input type="text" class="form-control required" id="sub_heading" name="sub_heading" placeholder="Name of Sub Heading" value="<?php if(!empty($content_tutorials_sub_heading_rowdetails->sub_heading)){echo $content_tutorials_sub_heading_rowdetails->sub_heading;}else{echo '';} ?>"  >
					<span style="color:red;"><?php echo form_error('sub_heading'); ?></span>
				</div>					
			</div>
		
			
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Description*</label>
					<?php		
						/*$oFCKeditor = new FCKeditor('description') ;
						$oFCKeditor->BasePath 	=  base_url().'assets/fckeditor/' ;
						$oFCKeditor->Width		= '100%' ;
						$oFCKeditor->Height		= '350' ;
						$oFCKeditor->Value 		= $content_tutorials_sub_heading_rowdetails->description;
						$oFCKeditor->ToolbarSet	= 'Default' ;
						$oFCKeditor->Create() ;	*/	
 					?>
					<textarea type="text" class="form-control" id="editor" name="description" placeholder="Description"><?php echo $content_tutorials_sub_heading_rowdetails->description; ?></textarea>
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
</div>
</section>