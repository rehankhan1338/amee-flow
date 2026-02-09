<div class="clearfix"></div>
<div id="page_wrapper">
	<div class="container">
	  <div class="row">
		<div class="col-lg-12">
			<h1 class="title">Accreditation</h1>
			<p>Explore and read more about your regional accreditation agency and receive the most up-to-date news for assessment <i class="fas fa-long-arrow-alt-right"></i></p>
			
			<?php foreach($accreditation_list as $accreditation){?>
				<hr />
				<div class="accreditation_block">
					<img src="<?php echo base_url();?>assets/frontend/img/accreditation/<?php echo $accreditation->image;?>" alt="<?php echo $accreditation->title;?>" />
					<h3><?php echo $accreditation->title;?></h3>
					<?php if(isset($accreditation->sub_title) && $accreditation->sub_title!=''){?>
					<h4><?php echo $accreditation->sub_title;?></h4>
					<?php } ?>
					<label class="identify_number"><?php echo $accreditation->identify_number;?></label>
					<div class="scope_of_recognition">
						<label>Scope of recognition:</label> <?php echo $accreditation->scope_of_recognition;?>
					</div>
					<div class="event_details">	
						<p><?php echo $accreditation->name;?></p>
						<ul>
							<li>Address : <?php echo $accreditation->address;?>, <?php echo $accreditation->state_city_zip;?></li>
							<li>Phone : <?php echo $accreditation->phone;?></li>
							<li>Fax : <?php echo $accreditation->fax;?></li>
							<li>E-mail Address : <?php echo $accreditation->email_address;?></li>
							<li>Web Address : <?php echo $accreditation->web_address;?></li>
						</ul>
					</div>
				</div>
			<?php } ?> 		
			 					
		</div>
	  </div>
	</div>
</div>