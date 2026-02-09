<?php include(APPPATH.'views/Frontend/coordinate/action_sliderbar.php'); ?>

<div class="clearfix"></div>

<form data-toggle="validator" class="form-horizontal" id="frm" method="POST" action="" enctype="multipart/form-data">
<div class="box">
	
	<div class="box-body">
		<div class="col-md-4"><br />
			<blockquote class="bq2 marginbottom0"><b>Great News!</b>&nbsp; You&apos;ve formulated all your goals. 
				<br /><br />
				The second step in the assessment process is to complete a Mapping Matrix. This includes: (1) determining what contribute to the attainment of those SLOs and (2) categorizing how those SLOs are approached in each activity.
				<br /><br />
				To get started, we need additional information to create your Mapping matrix: Use the drop down box to identify the number of courses or program offered in your program.<span class="bq2_end"></span>
			</blockquote>
		</div>
		
		<div class="col-md-8">
			<div class="contenttitle2 nomargintop">
				<h3>Overview</h3>
			</div>
			
			<div class="clearfix"></div>
			<textarea id="editor1" name="coordinate_action1_overview" class="form-control"><?php if(!empty($checklist_detail->coordinate_action1_overview)){echo $checklist_detail->coordinate_action1_overview;} ?></textarea>
			<div class="margin020"><input type="submit" name="coordinate_save" class="btn btn-primary" value='Save & Update' /></div> 
		</div>
		
		
		
		<div class="clearfix"></div>
	</div>
	
	<div class="clearfix"></div>
	 
	<div class="box-footer">
		<div class="pull-right">
			<input type="submit" name="coordinate_next" class="btn btn-info" value='Next Action2 >>'/>
			<input type="submit" name="coordinate_next_action3" class="btn btn-info" value='Next Action3 >>'/>
		</div>
	</div>
</div>
</form>