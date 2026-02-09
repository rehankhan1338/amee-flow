<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >
<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">
	<div class="box">

		<div class="box-body">
		<div class="col-md-10">
			<div class="form-group">
				<label class="col-sm-3 control-label" for="inputEmail3">Name*</label>
				<div class="col-sm-9">
					<input type="text" class="form-control required" id="txt_name" name="txt_name" placeholder="Name" value="<?php echo $survey_templates_details->name;?>"  >
				</div>
			</div>

			<!-- <div class="form-group" id="js-rank">
			<label class="col-sm-3 control-label" for="inputEmail3">Rank*</label>
			<div class="col-sm-9">
			<?php // $faculty_directory_rank_list = faculty_directory_rank_h(); ?>
			<select class="form-control required" id="rank" name="rank"> 
			<option value="">--Select Rank--</option>
			<?php  //foreach ($faculty_directory_rank_list as $rank_list) {?>
			<option value="<?php //echo $rank_list->id;?>"><?php //echo $rank_list->name;?></option>
			<?php //} ?>
			</select>
			</div>
			</div>-->
		</div>
		</div> 
		
		<div class="box-footer">
			<button class="btn btn-primary" type="submit">Submit</button>
		</div>
	</div> 
</form>
</div>
</div>
</section>