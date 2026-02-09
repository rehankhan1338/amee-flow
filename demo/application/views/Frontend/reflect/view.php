<?php include(APPPATH.'views/Frontend/reflect/action_sliderbar.php'); ?>

<div class="clearfix"></div>

<form data-toggle="validator" class="form-horizontal" id="frm" method="POST" action="" enctype="multipart/form-data">
<div class="box">
	
	<div class="box-body">
		<div class="col-md-4"><br /><br />
			<blockquote class="bq2 marginbottom0">
				<b>Congratulations!</b>
				<br /><br />
				You′ve successfully completed your Rotation Plan and you are on the last step to complete your Assessment Plan.
				<br /><br />
				In the next step, identify direct, indirect measurement tools, and targets for your forward looking plan.
				<span class="bq2_end"></span>
			</blockquote>
		</div>
		
		<div class="col-md-8">
			<div class="contenttitle2 nomargintop">
				<h3>Overview</h3>
			</div>
			<div class="clearfix"></div>
			<div class="sam_over instructions"><strong>Sample Overview:</strong> The Methods of Measuring Learning Outcomes provides a way to categorize the range of methodologies that can be used to answer the broad question, what knowledge and abilities have students acquired from both their academic work and their co-curricular activities during their years in college?  Taken together, the data collected using these methodologies can help assess the value-added.  The Department of Demo Studies provides a variety of tools, most direct measurements. Each year, a measurement tool and benchmark are set for each learning outcome.</div>
			<div class="clearfix"></div>
				<textarea id="editor1" name="reflect_action1_overview" class="form-control"><?php if(!empty($checklist_detail->reflect_action1_overview)){echo $checklist_detail->reflect_action1_overview;} ?></textarea>
				<div class="margin020"><input type="submit" name="reflect_save" class="btn btn-primary" value='Save & Update' /></div> 
		</div>
		
		<div class="clearfix"></div>
	</div>
	
	<div class="clearfix"></div>
	 
	<div class="box-footer">
		<div class="pull-right">
			<input type="submit" name="reflect_next" class="btn btn-info" value='Next Action2 >>'/>
			<input type="submit" name="reflect_next_action3" class="btn btn-info" value='Next Action3 >>'/>
		</div>
	</div>
</div>
</form>