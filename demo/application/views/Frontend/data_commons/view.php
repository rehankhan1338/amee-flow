<div class="data_common_page">
<div class="col-md-12">
	<div class="pull-right">
		<a onclick="return open_model_data_commons();" class="btn btn-primary" style="padding:3px 7px; font-size:15px;"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Data Commons </a>				
	</div>
</div>
<script type="text/javascript">
function open_model_data_commons(){							
	jQuery("#open_model_data_commons").modal('show');
}
</script>
<?php if(count($data_commons_details_not_dept_id)>0){?>    
<div class="row"> 
	<?php foreach($data_commons_details_not_dept_id as $commons_details_not_dept_id){ ?>      
		<div class="col-md-3">
			<div class="thumbnail">	
				<a class="img_s" href="<?php echo base_url();?>department/data_commons/details/<?php echo $commons_details_not_dept_id->id;?>">
					<?php if(isset($commons_details_not_dept_id->add_thumbnail)&& $commons_details_not_dept_id->add_thumbnail!=''){?>			
						<img style="height: 150px;" class="img-responsive" src="<?php echo base_url();?>assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/<?php echo $commons_details_not_dept_id->add_thumbnail; ?>" alt="">
					<?php }else{?>
						<img src="http://placehold.it/500x300" alt="">
					<?php }?>
				</a>
					
				<div class="caption">
					<h4><?php if(isset($commons_details_not_dept_id->title)&& $commons_details_not_dept_id->title!=''){echo $commons_details_not_dept_id->title;}?></h4>
					<p><?php if(isset($commons_details_not_dept_id->descriptive_text)&& $commons_details_not_dept_id->descriptive_text!=''){echo substr($commons_details_not_dept_id->descriptive_text, 0, 100).' [...]';}?></p>
					 
				</div>
				<div class="box-footer"> 
					<span class="pull-right"><?php if(isset($commons_details_not_dept_id->add_date)&& $commons_details_not_dept_id->add_date!=''){echo date('m/d/Y h:i A',$commons_details_not_dept_id->add_date) ;}?></span>
				</div>		
			</div>	
		</div>
	<?php }?>
	</div>
<?php } ?>
	 <?php if(count($data_commons_details)>0){?> 
	<div class="row">
		<div class="col-md-12" style="margin-bottom:10px;"><h4>Your Data Commons</h4> </div>
	<?php foreach($data_commons_details as $commons_details){ ?>      
		<div class="col-md-3">
			<div class="thumbnail">	
				<a  class="img_s" href="<?php echo base_url();?>department/data_commons/details/<?php echo $commons_details->id;?>">
					<?php if(isset($commons_details->add_thumbnail)&& $commons_details->add_thumbnail!=''){?>			
						<img class="img-responsive" src="<?php echo base_url();?>assets/frontend/upload/Data_commons/add_thumbnail/thumbnails/<?php echo $commons_details->add_thumbnail; ?>" alt="">
					<?php }else{?>
						<img src="http://placehold.it/500x300" alt="">
					<?php }?>
				</a>
					
				<div class="caption">
					<h4><?php if(isset($commons_details->title)&& $commons_details->title!=''){echo $commons_details->title;}?></h4>
					<p><?php if(isset($commons_details->descriptive_text)&& $commons_details->descriptive_text!=''){echo substr($commons_details->descriptive_text, 0, 100).' [...]';}?></p>
 
				</div>	
				<div class="box-footer"> 
 						<a href="<?php echo base_url();?>department/data_commons/edit/<?php echo $commons_details->id;?>" class="btn btn-success btn-xs">Edit</a>
 						<a href="<?php echo  base_url();?>data_commons/delete/<?php echo $commons_details->id;?>" onclick="return confirm('Are you sure you want to delete this question?');" class="btn btn-danger btn-xs">Delete</a>
						<span class="pull-right"><?php if(isset($commons_details->add_date)&& $commons_details->add_date!=''){echo date('m/d/Y h:i A',$commons_details->add_date) ;}?></span>
					</div> 	
			</div>	
		</div>

	<?php }?>
	

</div><!-- End row --> 
<?php } ?>
</div>
<?php include(APPPATH.'views/Frontend/data_commons/open_model_form.php');?>

