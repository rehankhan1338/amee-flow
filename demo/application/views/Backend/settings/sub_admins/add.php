<script type="text/javascript">

	function checked_all_subcategory(category_id){ 
		if(jQuery('.case_category'+category_id).attr('checked')){
			jQuery('.case_subcategory'+category_id).prop('checked', true);
			jQuery('.case_ssubcat'+category_id).prop('checked', true);
		} else {
			jQuery('.case_subcategory'+category_id).prop('checked', false);
			jQuery('.case_ssubcat'+category_id).prop('checked', false);
		}
	
	}

</script>	
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements form-horizontal-->
          <div class="box">
             <form data-toggle="validator" class="" id="frm" method="post" action="" enctype="multipart/form-data">
              <div class="box-body">
                
        <p id="ret"><?php if(validation_errors() != false) { echo'<div class="alert alert-dismissable alert-danger"><small>'. validation_errors().'</small></div>'; } ?></p>
				  
				  		 
		<div class="col-md-4">
		
			<div class="form-group" >
				<label >Name*</label>
				<input type="text" class="form-control required" id="superadmin_name" name="superadmin_name" placeholder="Guest Name" value=""  >
			</div>
			
			<div class="form-group" >
				<label >E-Mail*</label>
				<input type="text" class="form-control required" id="guest_email" name="guest_email" placeholder="Guest Email" value=""  >
			</div>
 		
		</div>
		<div class="col-md-4">
		
			<div class="form-group" >
				<label>User Name/Login ID*</label>
				<input type="text" class="form-control required" id="guest_user_name" name="guest_user_name" placeholder="Guest User Name" value=""  >
			</div>
			
			<div class="form-group">
				<label>Password*</label>
				<input type="password" class="form-control" id="guest_password" name="guest_password" placeholder="Guest Password">
			</div>
			<div class="form-group col-md-1">
			
			</div>
 		
		</div>
		
		<div class="col-md-4">
			<div class="form-group" style="padding:0 20px;">
				<label>Status*</label> <br />
				<input type="radio" id="guest_password" name="guest_access"  class="required" value=""> Active &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" id="guest_password" name="guest_access"  class="required"  value=""> Deactive
 			</div>
		</div>
		
          </div>
		  <div class="box-footer">
                	
					<h4><b>Set Privillages</b></h4>
					<?php $menu_list = menu_list_helper($admin_type,$session_details->menu_ids);?>
					<?php $kl=1;foreach ($menu_list as $category_data) {?>
					<div class="col-md-4" style="margin:10px 0">
					
						<input type="checkbox"  name="category_ids[]" id="category_ids" class="case_category<?php echo $category_data->id;?>" onclick="return checked_all_subcategory('<?php echo $category_data->id;?>');" value="<?php echo $category_data->id;?>" /> <span style="font-weight:600;"><?php echo $category_data->menu_name;?></span>
						
						<?php $submenu_list = submenu_list_helper($category_data->id,$admin_type,$session_details->submenu_ids); 
						if(count($submenu_list)>0){ ?>
						
						<?php foreach ($submenu_list as $subcategory_data) {?>
							<div class="col-md-12" style="padding:3px 40px;">
							<?php if(isset($subcategory_data->submenu_active_class) && $subcategory_data->submenu_active_class!=''){ ?>
							
							<span style="color:#2C3B41;  font-weight:600;"><input type="checkbox" class="case_subcategory<?php echo $category_data->id;?>" name="subcategory_ids[]" id="subcategory_ids" value="<?php echo $subcategory_data->id;?>" />  <?php echo $subcategory_data->submenu_name;?></span>
							<?php $submenu_subcat_list = submenu_subcat_list_helper($subcategory_data->id,$admin_type,$session_details->submenu_subcat_ids);?>
							<?php foreach ($submenu_subcat_list as $submenu_subcat_data) {?>
								<div class="col-md-12" style="padding:3px 40px;">
								<input type="checkbox" name="subcategory_subcat_ids[]" id="subcategory_subcat_ids" class="case_ssubcat<?php echo $category_data->id;?>" value="<?php echo $submenu_subcat_data->id;?>" /> <?php echo $submenu_subcat_data->subcate_name;?>
								</div>
							<?php } ?>
							<?php } else{ ?>
							
							<input type="checkbox" name="subcategory_ids[]" id="subcategory_ids" class="case_subcategory<?php echo $category_data->id;?>" class="required" value="<?php echo $subcategory_data->id;?>" />  <?php echo $subcategory_data->submenu_name;?>
							<?php } ?>
							</div>
							
						<?php } ?>
						
						<?php } ?>
					 
					</div>
					<?php if($kl==3){?>
					<div style="clear:both;"></div>
					<?php } ?>
					<?php $kl++; } ?>
                 
              </div>
           <!-- /.box-body -->
              <div class="box-footer">
                
                <button type="submit" class="btn btn-primary" name="submit_login">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>

        </div>
        <!--/.col (left) -->
        <!-- right column -->
         
 
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>