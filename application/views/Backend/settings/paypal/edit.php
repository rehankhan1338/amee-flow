<section class="content">
<form data-toggle="validator" class="" id="frm1" method="post" action="" enctype="multipart/form-data">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          
          <div class="box">
          
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $showcase_paypal_setting->purpose;?></h3>
				  <div class="box-tools pull-right">
				  	<a style="padding: 3px 5px; vertical-align:top;" href="<?php echo base_url();?>admin/paypal" class="btn btn-primary" > <i class="fa fa-arrow-circle-left"></i> Back to Listing</a>
				  </div>
				</div>
			
              <div class="box-body">
                <div class="col-md-4">
 					 
					 <div class="form-group">



                        <label>Paypal IPN: </label>
                        <input type="text" class="form-control email required" id="showcase_paypal_id" name="showcase_paypal_id" value="<?php echo $showcase_paypal_setting->paypal_id;?>"  >
                        <?php echo form_error('showcase_paypal_id');?>
                        </div> 
						
						 <div class="form-group">
                        <label>Item Name: </label>
                        <input type="text" class="form-control required" id="showcase_item_name" name="showcase_item_name"  value="<?php echo $showcase_paypal_setting->item_name;?>" >
                        <?php echo form_error('showcase_item_name');?>
                        </div>
				   
				   </div>
				  
				  <div class="col-md-4">
				  		<div class="form-group">
                        <label>Amount($): </label>
                        <input type="text" class="form-control number required" id="showcase_amount" name="showcase_amount" value="<?php echo $showcase_paypal_setting->amount;?>"  >
                        <?php echo form_error('showcase_amount');?>
                        </div>
						
						<div class="form-group">
                        <label>Currency Code: </label>
                        <input type="text" class="form-control required" id="showcase_currency_code" name="showcase_currency_code"  value="<?php echo $showcase_paypal_setting->currency_code;?>" >
                        <?php echo form_error('showcase_currency_code');?>
                        </div>    
                      
					  
						<div class="form-group">
                        <label>Month Duration: </label>
                        <input type="text" class="form-control number required" id="showcase_duration" name="showcase_duration" value="<?php echo $showcase_paypal_setting->duration;?>"  >
                        <?php echo form_error('showcase_duration');?>
                        </div>
				  </div>
				  
				  <div class="col-md-4">
				    
						<div class="form-group">
                        <label>Status: </label><br />
                        <input type="radio" class="required" id="showcase_status" name="showcase_status" value="sandbox" <?php if(isset($showcase_paypal_setting->status) && $showcase_paypal_setting->status=='sandbox'){?> checked="checked" <?php } ?> > Sandbox (Test)
						 
						<input type="radio" class="required" id="showcase_status" name="showcase_status" value="paypal" <?php if(isset($showcase_paypal_setting->status) && $showcase_paypal_setting->status=='paypal'){?> checked="checked" <?php } ?> > Paypal (Live)
                        <?php echo form_error('showcase_status');?>
                        </div>
						
				  </div>

           </div> 
          	   <div class="box-footer">
			   <button class="btn btn-primary" type="submit">Submit</button>
			   </div>
			   
          </div>
        <!--/.col (left) -->
        <!-- right column -->
          
      </div>
         <!--/.col (right) -->
   </div>
       <!-- /.row -->
	  </form>
</section>