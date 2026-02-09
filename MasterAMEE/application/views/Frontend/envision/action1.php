<?php include(APPPATH.'views/Frontend/envision/action_sliderbar.php'); ?>
<div class="clearfix"></div>
<div class="box">
<form data-toggle="validator" class="form-horizontal" id="frm" method="POST" action="" enctype="multipart/form-data">
	
	<div class="nrow">
			
		<ul class="hornav">
			<li class="current"><a href="#overview">Overview</a></li>
			<li><a href="#mission">Mission Statement</a></li>
			<li><a href="#vission">Vision Statement</a></li>
			<li><a href="#department_program_goals">Department / Program goals</a></li>
		</ul>

		<div id="overview" class="subcontent margin20">
			<div class="box">
				<div class="box-body">
	
					<div class="contenttitle2 nomargintop">
						<h3>Overview</h3>
					</div>
					<div class="clearfix"></div>
					<div class="sam_over instructions"><strong>Sample Overview:</strong> The Demo Department has a long history of assessment in our college.  We are the first college to build a culture of assessment with all full time faculty participation. This section demonstrates our commitment to program assessment through our mission and vision statements.  Department goals are broadly laid out to help us move to more specific thinking about our outcomes and objectives.</div>
					<div class="clearfix"></div>
					<textarea id="editor1" name="envision_step1_overview"><?php if(!empty($checklist_detail->envision_action1_overview)){echo $checklist_detail->envision_action1_overview;}?></textarea>
				
				</div>
			</div>
		</div>
		
		<div id="mission" class="subcontent margin20" style="display:none">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Mission Statement</h3>
					</div>
					<div class="clearfix"></div>
					<textarea id="editor2" name="mission"><?php if(!empty($checklist_detail->mission_statement)){echo $checklist_detail->mission_statement;}else{echo '';} ?></textarea>
				
				</div>
			</div>
		</div>

		<div id="vission" class="subcontent margin20" style="display:none">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Vision Statement</h3>
					</div>
					<div class="clearfix"></div>
					<textarea id="editor3" name="vision"><?php if(!empty($checklist_detail->vision_statement)){echo $checklist_detail->vision_statement;}else{echo '';} ?></textarea>
					
				</div>
			</div>
		</div>

		<div id="department_program_goals" class="subcontent margin20" style="display:none">
			<div class="box">
				<div class="box-body">
					
					<div class="contenttitle2 nomargintop">
						<h3>Department / Program goals</h3>
					</div>
					<div class="clearfix"></div>
					<textarea id="editor4" name="program_goals"><?php if(!empty($checklist_detail->program_goals)){echo $checklist_detail->program_goals;}else{echo '';} ?></textarea>
					
				</div>
			</div>
		</div>

	</div>
	<div><input type="submit" name="envision_save" class="btn btn-primary" value='Save & Update' /></div><br />
	<div class="clearfix"></div>
	<div class="box-footer">
		<div class="pull-right">
			<input type="submit" name="envision_next" class="btn btn-info" value='Next Action2 >>'/>
			<input type="submit" name="envision_next_action3" class="btn btn-info" value='Next Action3 >>'/>
		</div>
	</div>
	
</form>
</div>