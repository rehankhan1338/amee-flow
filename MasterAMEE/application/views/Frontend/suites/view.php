<style type="text/css">
.suites_pages{margin-top:15px;}
.suites_pages .right_side_bar{padding-top:30px;}
.suites_pages .right_side_bar p{font-size:17px; line-height:30px;}
.suites_pages .suite_items .loading_img{vertical-align: middle;display: inline-block;}
.suites_pages .suite_items .btn-primary{padding:5px 16px;}
.suites_pages .suite_items .btn-default{padding:5px 16px; margin-left:5px;}
</style>

<input type="hidden" name="university_id" id="university_id" value="<?php echo $this->config->item('cv_university_id');?>" />
<div class="suites_pages">
	<?php $i=0;foreach($suites_details as $row){?>
		<div class="col-md-12 suite_items">
			
			<?php if($i%2==0) {?>
			<div class="col-md-2">
				<img class="img-responsive" src="<?php echo  base_url().$row->image;?>" alt="<?php echo $row->name;?>" /> 
			</div>
			<div class="col-md-10 right_side_bar">
				<h3 id="suite_title<?php echo $row->id;?>"><?php echo strtoupper($row->name);?></h3>
				<p><?php echo $row->description;?></p>
				<p>
					<a href="<?php echo $row->redirect_link;?>" target="_blank" class="btn btn-primary">Vist Site <i class="fa fa-send"></i></a>
					<a onclick="return open_model_suites('<?php echo $row->id;?>');" class="btn btn-default">Form <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
 					<a class="loading_img" id="loading_img<?php echo $row->id;?>"></a>
				</p>
			</div>
			
			<?php }else{ ?>
		
			<div class="col-md-10 right_side_bar">
				<h3 id="suite_title<?php echo $row->id;?>"><?php echo strtoupper($row->name);?></h3>
				<p><?php echo $row->description;?></p>
				<p>
					<a href="<?php echo $row->redirect_link;?>" target="_blank" class="btn btn-primary">Vist Site <i class="fa fa-send"></i></a>
					<a onclick="return open_model_suites('<?php echo $row->id;?>');" class="btn btn-default">Form <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
 					<a class="loading_img" id="loading_img<?php echo $row->id;?>"></a>
				</p>
			</div>
				<div class="col-md-2">
				<img class="img-responsive" src="<?php echo  base_url().$row->image;?>" alt="<?php echo $row->name;?>" /> 
			</div>
			
			<?php } ?>
		</div> 
				
		<div class="clearfix"></div>
		<hr />
	<?php $i++;} ?>
</div>
<div class="modal" id="open_model_suites" tabindex="-1" role="dialog" ><!--class='fade'--></div>
<script type="text/javascript">
function open_model_suites(status){
var university_id = jQuery('#university_id').val();
if(status!='' && university_id!=''){		
	$.ajax({
		url: '<?php echo base_url(); ?>suites/suites_detail_row_ajax?id='+status+'&uniid='+university_id,
		type: 'GET',				
		beforeSend: function(){
			$('#loading_img'+status).html('<img src="<?php echo base_url();?>assets/backend/images/ajax-loading.gif" class="centered"/>'); 
		},		
		success: function (result){		
			jQuery('#loading_img'+status).html('');	
			jQuery("#open_model_suites").html(result);
			var suite_title= jQuery("#suite_title"+status).html();
			jQuery(".pop_title").html(suite_title);	
			jQuery("#suites_id").val(status);									
			jQuery("#open_model_suites").modal('show');					
		}
	});		
} 	
}
</script>	