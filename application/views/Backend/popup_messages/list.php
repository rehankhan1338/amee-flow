<style type="text/css">
	textarea{resize:none;}
</style>
<script type="text/javascript">
	function get_universtity_messages(id){
		window.location='<?php echo base_url();?>admin/Popup_messages?id='+id;	
	}
</script> 
<section class="content"> 
		 
			<!--<h3 class="box-title">Listing</h3>-->

		<div class="form-group">
			<h4  style="display:inline-block;  ">Messages for University: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
			 
				<select class="form-control required" id="university" name="university" style="display:inline-block; width:30%;" onchange="return get_universtity_messages(this.value);">
					<option value="0" <?php if(isset($_GET['id']) && $_GET['id']=='0'){?> selected="selected" <?php } ?>>Default</option>
					<?php foreach($university_detail_custom as $row){?>
							<option value="<?php echo $row->id ;?>" <?php if(isset($_GET['id']) && $_GET['id']==$row->id){?> selected="selected" <?php } ?>><?php if(isset($row->university_name)&& $row->university_name!=''){ echo ucwords($row->university_name);} ?></option>
					<?php } ?>
				</select>					
				<span style="color:red;"><?php echo form_error('university'); ?></span>
			 
		</div>	
	 <hr />
		
		<div class="clearfix"></div>
			
			<?php foreach($popup_messages_details_group_by_page as $page_name_details){

				$pop_messages_data = pop_messages_listing_h($page_name_details->page_name);

			?> 
			
			<div class="row">
			
			<div class="col-md-12"><h4><?php echo ucwords($page_name_details->page_name);?> Page</h4></div>
				
				<?php foreach($pop_messages_data as $pop_messages_details){ ?>
			<div class="col-md-4">
				<div class="box box-default box-solid collapsed-box">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo ucwords($pop_messages_details->title);?></h3>
		
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
						</div>	
					</div>
					<!-- /.box-header -->
		
					<div class="box-body" style=""> 
 						<?php if(isset($pop_messages_details->description) && $pop_messages_details->description!=''){ echo $pop_messages_details->description;}?>
					</div>
		
					<div class="box-footer">
						<a class="btn btn-primary" href="<?php echo base_url();?>admin/popup_messages/edit?id=<?php echo $pop_messages_details->id;?>">Edit</a>
					</div>
		
				</div>
			</div>
			
			<?php } ?>
			
			</div>
			<hr />
		
		<div class="clearfix"></div>
			<?php } ?>
 


</section>