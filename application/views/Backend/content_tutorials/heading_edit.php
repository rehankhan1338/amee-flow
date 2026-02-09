<section class="content">
<div class="row">
<div class="col-md-12" >
	<form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title" style="display: inline-block;">&nbsp;</h3>    
			<div class="box-tools pull-right">
				<a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/content/tutorials/heading?as=<?php if(isset($_GET['as'])&& $_GET['as']!=''){echo $_GET['as'];}?>" class="btn btn-primary"><i class="fa fa-mail-reply" aria-hidden="true"></i> Back to Menu </a>
			</div>
	    </div>
		
		<div class="box-body">
			<input type="hidden" class="form-control" id="hidden_action_status" name="hidden_action_status" value="<?php if(!empty($content_tutorials_heading_rowdetails->action_status)){echo $content_tutorials_heading_rowdetails->action_status;}else{echo '';} ?>" / >
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="inputEmail3">Heading*</label>
					<input type="text" class="form-control required" id="heading" name="heading" placeholder="Name of Heading" value="<?php if(!empty($content_tutorials_heading_rowdetails->heading)){echo $content_tutorials_heading_rowdetails->heading;}else{echo '';} ?>"  >
					<span style="color:red;"><?php echo form_error('heading'); ?></span>
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
						$oFCKeditor->Value 		= $content_tutorials_heading_rowdetails->description;
						$oFCKeditor->ToolbarSet	= 'Default' ;
						$oFCKeditor->Create() ;	*/	
 					?>
					<textarea type="text" class="form-control" id="editor" name="description" placeholder="Description"><?php echo $content_tutorials_heading_rowdetails->description;?></textarea>
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