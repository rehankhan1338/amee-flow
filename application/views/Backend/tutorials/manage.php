<link rel='stylesheet' id='prettyPhoto-css'  href='<?php echo base_url(); ?>assets/backend/css/prettyPhoto.css?ver=3f720f300f1eb0e2a97e9188f8ed59d1' type='text/css' media='all' />	
<link href="<?php echo base_url(); ?>assets/backend/css/effects/normalize.css" type="text/css" rel="stylesheet"/> 
<link href="<?php echo base_url(); ?>assets/backend/css/effects/set2.css" type="text/css" rel="stylesheet"/>				

<script type='text/javascript' src='<?php echo base_url();?>assets/backend/js/jquery.prettyPhoto.js?ver=3.1.5'></script>
<script type="text/javascript">
$(document).ready( function(){
	$('#frm').validate();
	$("a[rel^='prettyPhoto']").prettyPhoto({
		allow_resize: true, /* Resize the photos bigger than viewport. true/false */
        default_width: 800,
        default_height: 544,
        horizontal_padding: 20
	});
});
</script>


<section class="content">
<div class="box">

	<div class="box-header with-border">
      <h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/tutorials/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
		</div>
    </div>
            
  	<!-- start body div -->
	<div class="box-body">
	<div class="row">
		
		<div class="grid">
			<?php $i=1; foreach ($tutorials_details as $row) { 

				$txt_link = trim($row->txt_link); 
				if (strpos($txt_link,"?v=")){
					$short_name = explode('?v=',$txt_link);
					$short_name_1 = explode('&',$short_name[1]);
					$video_short_name = $short_name_1[0];
				}else{
					$short_name = explode('/',$txt_link);
					$video_short_name = $short_name[3];	 
				} 			
			?>

			<div class="col-md-3"> 
				<figure class="effect-duke">
					<img src="http://img.youtube.com/vi/<?php echo $video_short_name;?>/mqdefault.jpg" alt="img27" class="img-responsive" />
					<figcaption>
						<p><a href="<?php echo base_url();?>admin/tutorials/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a>	
						<a href="<?php echo base_url();?>admin/tutorials/delete/<?php echo $row->id;?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></p>
					</figcaption>	
				</figure>
				<p style="color: #8e1518; text-align: left;padding: 5px; font-size:16px; letter-spacing:1px;"><?php if(!empty($row->txt_title)) { echo $row->txt_title ; } else { echo ' ' ; } ?></p><a rel="prettyPhoto" href="<?php echo $txt_link ?>" style="color:#f9f9f9;"></a>		
				
			</div>
		<?php }?>	
		</div>
		
	</div>
	</div>

</div>
</section>

