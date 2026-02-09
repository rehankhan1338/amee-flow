<section class="content">
	<div class="row">
<style>
.uniDiv label{ display:block; margin-top:5px; font-weight:500;}
</style>
		<div class="col-md-12">
			<form class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
				<div class="box">
					<div class="box-body">
						<div class="col-md-10">
							<div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Title *</label>
								<div class="col-sm-9">
									<input type="text" class="form-control required" id="notiTitle" name="notiTitle" placeholder="Notification Title" value="<?php echo $notifications_details->title;?>" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="inputEmail3">Message *</label>
								<div class="col-sm-9">
									<textarea id="editor" name="msgBody"><?php echo $notifications_details->messageBody;?></textarea>
								</div>
							</div>
							<div class="form-group" id="js-rank">
								<label class="col-sm-3 control-label" for="inputEmail3">Send To *</label>
								<div class="col-sm-9 uniDiv">
									<?php 
									$uniIds = array();
									if(isset($notifications_details->sendTo) && $notifications_details->sendTo!=''){ $uniIds = explode(',',$notifications_details->sendTo);}
									foreach($university_data as $university) {?>
									<label><input type="checkbox" id="uniIds[]" name="uniIds[]" value="<?php echo $university['id'];?>" <?php if(in_array($university['id'],$uniIds)){?> checked="checked"<?php } ?> /> &nbsp;<?php echo $university['university_name'];?></label>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>   
					<div class="box-footer">
						<button class="btn btn-primary" type="submit">Update Now!</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>