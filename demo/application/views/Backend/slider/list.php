<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/slider/delete?id='+val;
 		} 
 	}
} 
</script> 
<style type="text/css">
.acc_action_btns {
    display: inline-block;
    text-align: right;
    width: 100%;
	cursor:pointer;
}
.acc_action_btns a{
    display: inline-block; width:30px; height:30px; line-height:28px; background-color:#fff; border-radius:50%; margin-left:3px; text-align:center;color:#117e40;
}
.acc_action_btns a:hover,.acc_action_btns a:focus{ background-color:#117e40;color:#fff;}
.acc_action_btns a i.fa-trash{color:#FF0000;}
.trash_a{ background:#fff;}
</style>
<section class="content">

<div class="box ">
	 <div class="box-header with-border">
	  <h3 class="box-title">Home Slider</h3>
	  <div class="box-tools pull-right">
					 
                      <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/slider/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
                    </div>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
	
	<?php if(count($slider_details)>0){?>
	
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<?php $i=0; foreach ($slider_details as $slider_data) { ?>
					<li data-target="#carousel-example-generic" data-slide-to="<?php echo $i;?>" class="<?php if($i==0){ echo 'active';}?>"></li>
				<?php $i++; } ?>
			</ol>
			<div class="carousel-inner ">
			
				<?php $i=0; foreach ($slider_details as $slider_data) { ?>
				
					<div class="item <?php if($i==0){ echo 'active';}?>">
						<img src="<?php echo base_url();?>assets/homeslider/<?php echo $slider_data->image;?>" alt="First slide">
						
						<div class="carousel-caption" >
							<h1><?php echo $slider_data->title;?></h1>
							<h2><?php echo $slider_data->sub_title;?></h2>
							<div class="acc_action_btns" style="margin:10px; z-index:999;">
								<a href="<?php echo base_url();?>admin/slider/edit/<?php echo $slider_data->id;?>"><i class="fa fa-pencil"></i></a>
								<a class="trash_a" onclick="return delete_entry('<?php echo $slider_data->id;?>');"><i class="fa fa-trash"></i> </a>
							</div>
						</div>
					
					</div>
				<?php $i++;  } ?>
				
			</div>
			<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
				<span class="fa fa-angle-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
				<span class="fa fa-angle-right"></span>
			</a>
		</div>
	  <?php } ?>
	</div>
	<!-- /.box-body -->
  </div>