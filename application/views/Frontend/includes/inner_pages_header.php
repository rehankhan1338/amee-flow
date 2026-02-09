 <section id="header" class="inner_head">
	<div class="top_head">
    	<div class="container">
        	<div class="row"><a class="logo" href="<?php echo base_url();?>">S<span class="o">O</span>C Builder</a><button type="button" class="btn btn-link navbar-toggle collapsed" data-toggle="modal" data-target="#menuModal"><img src="<?php echo base_url();?>assets/frontend/img/menu_btn.png" alt="MENU"/></button></div>
        </div>
    </div>
    <div class="big_txt">
    	<span class="b1"><?php echo $page_title;?></span>
    </div>
</section><!--header-->
<?php if(isset($success_msg) && $success_msg!=''){?>
	<div class="container"> 
 		<div class="col-md-12 col-sm-12">
 			<div class="alert alert-success" style="margin-top:10px;margin-bottom:0;">
				<?php echo $success_msg;?>
			</div>
		</div> 
	</div>
<?php } ?>	
<?php if(isset($error_msg) && $error_msg!=''){?>
	<div class="container"> 
 		<div class="col-md-12 col-sm-12">
 			<div class="alert alert-danger" style="margin-top:10px;margin-bottom:0;">
				<?php echo $error_msg;?>
			</div>
		</div> 
	</div>
<?php } ?> 