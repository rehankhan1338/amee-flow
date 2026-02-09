<?php include(APPPATH.'views/Frontend/design/action_sliderbar.php'); ?>

<div class="clearfix"></div>

<form data-toggle="validator" class="form-horizontal" id="frm" method="POST" action="" enctype="multipart/form-data">
<div class="box">
	
	<div class="box-body">
		<div class="col-md-4"><br /><br />
			<blockquote class="bq2 marginbottom0">
				You are half way there!  
				<br /><br />
				You&#8242;ve successfully completed your Alignment Matrix.  
				<br /><br />
				The third step in the assessment process is to design your rotation plan and create your assessment teams. 
				<span class="bq2_end"></span>
			</blockquote>
		</div>
		
		<div class="col-md-8">
			<div class="contenttitle2 nomargintop">
				<h3>Overview</h3>
			</div>
			<div class="clearfix"></div>
			<div class="sam_over instructions"><strong>Sample Overiew:</strong> Working in teams has been the most beneficial part of the assessment process in the Department of DEMO. All of our faculty participate in the assessment process.  We have four rotating teams and the assessment liaison as a constant team member. The Department of Demo has five (5) rotating teams that represent each of the emphasis areas. Each team evaluates the courses in their emphasis area to keep to produce high- quality evaluations.  The teams below demonstrate our rotating team process.</div>
			<div class="clearfix"></div>
				<textarea id="editor1" name="design_action1_overview" class="form-control"><?php if(!empty($checklist_detail->design_action1_overview)){echo $checklist_detail->design_action1_overview;} ?></textarea>
				<div class="margin020"><input type="submit" name="design_save" class="btn btn-primary" value='Save & Update' /></div> 
		</div>
		
		<div class="clearfix"></div>
	</div>
	
	<div class="clearfix"></div>
	 
	<div class="box-footer">
		<div class="pull-right">
			<input type="submit" name="design_next" class="btn btn-info" value='Next Action2 >>'/>
			<input type="submit" name="design_next_action3" class="btn btn-info" value='Next Action3 >>'/>
		</div>
	</div>
</div>
</form>