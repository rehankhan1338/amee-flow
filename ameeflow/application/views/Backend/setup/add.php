<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
<?php $wards_prefix = $this->config->item('wards_prefix');?>
<?php $zones_prefix = $this->config->item('zones_prefix');?>		
		 <form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
          <div class="box">
         
             
              <div class="box-body">
                <div class="col-md-10">
				  
					<?php if($section_status==2){?>
					<div class="form-group" id="js-rank">
						<label class="col-sm-3 control-label" for="inputEmail3">Zone # *</label>
						<div class="col-sm-9">
							<?php $zones_arr = fetchZonesArrCh(); ?>
							<select class="form-control required" id="parentId" name="parentId"> 
								<option value="">Select...</option>
								<?php  foreach ($zones_arr as $zone) {?>
									<option value="<?php echo $zone['id'];?>"><?php echo $zones_prefix.$zone['name'];?></option>
								<?php } ?>
							</select>
						</div>
					 </div> 
		  			<?php }else{ ?>
						<input type="hidden" id="parentId" name="parentId" value="0" />
					<?php } ?>
					
					<div class="form-group">
						<label class="col-sm-3 control-label" for="inputEmail3"><?php echo $section_status_label;?> <?php if($section_status==2 || $section_status==1){echo '#';}else{echo 'Name';}?> *</label>
						<div class="col-sm-9">
							<input type="text" class="form-control <?php if($section_status==2 || $section_status==1){echo 'number';}?> required" id="txt_name" name="txt_name" placeholder="Enter <?php echo $section_status_label;?> <?php if($section_status==2 || $section_status==1){echo '#';}else{echo 'Name';}?>" value=""  >
						</div>
					 </div>
					 
					 
					 
					 
				  			
				  
				  </div>
				  

           </div> 
          	  <div class="box-footer">
                <button class="btn btn-primary" type="submit" style="padding:4px 30px;">Submit</button>
              </div>
          </div> </form>
        <!--/.col (left) -->
        <!-- right column -->
         
 
      </div>
        <!--/.col (right) -->
   </div>
      <!-- /.row -->
</section>