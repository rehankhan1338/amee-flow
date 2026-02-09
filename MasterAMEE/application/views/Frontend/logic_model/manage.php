<style>
.logic_model{ font-size:16px;}
.logic_model h4{ font-size:18px; margin-bottom:10px; font-weight:600;}
.logic_model p{ line-height:26px; margin:0 0 15px 0}
.logic_model strong{ font-weight:600;}
.logic_model .ques{ margin-top:15px;}
.logic_model .qdetails{ padding:0 15px;}
.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus{outline: none;}
.plpr{ padding-left:5px; padding-right:5px;}
</style>

<script type="text/javascript">  
jQuery(function () {
	CKEDITOR.replace( 'priority', {extraPlugins: 'placeholder', height: '150px', toolbar : ''});
	CKEDITOR.replace( 'inputs', {height: '150px',});
	CKEDITOR.replace( 'participants', {height: '150px',});
	CKEDITOR.replace( 'activities', {height: '150px',});
	CKEDITOR.replace( 'directProducts', {height: '150px',});
	CKEDITOR.replace( 'shortOutCome', {height: '150px',});
	CKEDITOR.replace( 'intermediateOutCome', {height: '150px',});
	CKEDITOR.replace( 'longOutCome', {height: '150px',});
}); 
</script>
<div class="box logic_model">
	<div class="col-xs-12">
		<div id="resMsg"></div>
		<form class="form-horizontal" id="logicModelFrm" method="post" action="logic_model/save_entry">	
		<input type="hidden" id="h_base_url" name="h_base_url" value="<?php echo base_url();?>" />
		<input type="hidden" id="h_model_id" name="h_model_id" value="<?php if(isset($logic_model_details->modelId) && $logic_model_details->modelId!=''){echo $logic_model_details->modelId;}else{echo '0';}?>" />
		<div class="box-body">
			<p>A <strong>Logic Model</strong> is a visual tool that presents the logic, or rationale, behind a program or process. A <strong>Logic Model</strong> is also a tool to show how your proposed project/program links the purpose, goals, objectives, and tasks stated with the activities and expected outcomes or "change" and can help to plan, implement, and assess your project/program. The model also links the purpose, goals, objectives, and activities back into planning and evaluation. A properly targeted Logic Model will show a logical pathway from inputs to intended outcomes, in which the included outcomes address the needs identified in the Statement of Need.</p>
			<div class="col-md-8">
				<div class="form-group">
					<label><strong>Program Name *</strong></label>
					<input class="form-control required" type="text" id="programName" name="programName" value="<?php if(isset($logic_model_details->modelId) && $logic_model_details->modelId!=''){echo $logic_model_details->programName;}?>" />
				</div>
			</div>
			<div class="col-md-4" >
				<div class="form-group" style="padding-left:10px;">
					<label><strong>Year *</strong></label>
					<input type="text" class="form-control number required" id="programYear" name="programYear" value="<?php if(isset($logic_model_details->modelId) && $logic_model_details->modelId!=''){echo $logic_model_details->programYear;}?>" />
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="ques">
				<h4>Step 1: Describe the need of your program.</h4>
				<div class="qdetails">
					<p><strong>Statement of Need</strong> (Situation). Your <strong>Logic Model</strong> should be based on a review of your Statement of Need, in which you state the conditions that gave rise to the project with your target group. Consider: what problems will your program address? What are the causes of the problem? Who is impacted by the problem? Who else is working on the problem and who cares if it is solved? What do we know about how the target group experiences the problem? Why is it important? (Consider magnitude, trends, severity, and economic costs).</p>
					<textarea class="form-control required" rows="3" id="situation" name="situation" placeholder="Children in AMEETOWN are below the state average in meeting developmental milestones."><?php if(isset($logic_model_details->situation) && $logic_model_details->situation!=''){echo $logic_model_details->situation;}?></textarea>
				</div>
			</div>
			
			<div class="ques">
				<h4>Step 2: Describe the priorities of your program.</h4>
				<div class="qdetails">
					<p><strong>Priority</strong>. Be specific about the positive behaviors you want to see strengthened or the negative behaviors you want to see changed and target audience.</p>
					<textarea class="form-control required" rows="3" id="priority" name="priority" placeholder=""><?php if(isset($logic_model_details->priority) && $logic_model_details->priority!=''){echo $logic_model_details->priority;}else{echo 'Community involvement, support community request, real life activity, High quality images uploaded to website.';}?></textarea>
				</div>
			</div>
			
			<div class="ques">
				<h4>Step 3: Describe the support you expect for your program.</h4>
				<div class="qdetails">
					<p><strong>Inputs </strong> (resources) that you have which you draw on to address the problem identified in your problem statement or that you invest. It is good to think of both the material resources (e.g., funding, physical spaces) and the non-material resources (e.g., staff knowledge), people (e.g., staff hours, volunteer hours), funds and other resources (e.g., facilities, equipment, community services).</p>
					<p><i></i></p>
					<textarea class="form-control required" rows="3" id="inputs" name="inputs" placeholder=""><?php if(isset($logic_model_details->inputs) && $logic_model_details->inputs!=''){echo $logic_model_details->inputs;}else{echo "Qualified and experienced staff and management time, volunteer time,  Funding, Partnering Organizations, Research and evidence about what works, travel cost for volunteer, purchase for drones, Playgroup standards of practice, Program resources (e.g., games), Community center with child friendly spaces.";}?></textarea>
				</div>
			</div>
			
			<div class="ques">
				<h4>Step 4: Describe the program components.</h4>
				<div class="qdetails">
					<p><strong><u>Outputs</u> </strong> (deliverables) include participants, activities, and direct products. </p>
					<p><strong><u>Participants</u> </strong> describes who will be involved. It is good to clearly define the target group for your program and include relevant information about this population group (for example age or cultural background). You should also include information about staff and others that may be involved and the role they play (e.g., volunteers, staff from other organizations).</p>
					<p><strong><u>Activities</u> </strong> are the things that you do. This is likely to include running the program and training staff. It might also include developing a program manual and resources or providing referrals to families. It is good to be specific about the numbers of program sessions you will run.</p>
					<p><strong><u>Direct Products </u></strong> are what you are creating (e.g., 4-hour training sessions)</p>
					<div class="col-md-4 plpr">
						<p><i></i></p>
						<textarea class="form-control required" rows="5" id="participants" name="participants" placeholder=""><?php if(isset($logic_model_details->participants) && $logic_model_details->participants!=''){echo $logic_model_details->participants;}else{echo 'Participants';}?></textarea>
					</div>
					<div class="col-md-4 plpr">
						<p><i></i></p>
						<textarea class="form-control required" rows="5" id="activities" name="activities" placeholder=""><?php if(isset($logic_model_details->activities) && $logic_model_details->activities!=''){echo $logic_model_details->activities;}else{echo 'Activities';}?></textarea>
					</div>
					<div class="col-md-4 plpr">
						<p><i></i></p>
						<textarea class="form-control required" rows="5" id="directProducts" name="directProducts" placeholder=""><?php if(isset($logic_model_details->directProducts) && $logic_model_details->directProducts!=''){echo $logic_model_details->directProducts;}else{echo 'Direct Products';}?></textarea>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			
			 
			
			<div class="ques">
				<h4>Step 5: What should participants be able to do at the end of the program?</h4>
				<div class="qdetails">
					<p>The <strong><u>Inputs</u></strong>, and <strong>Outputs</strong> all lead to the <strong>Outcomes</strong> (Achievement).  Outcomes are classified asshort-term, intermediate-term, and long-term. </p>
					<p><strong><u>Short-term outcomes</u></strong> are stated as changes in awareness, knowledge/attitude skills and motivations. They arethe changes you expect to see on completion of your program. These are the easiest to measure, and the timeframe will usually be the length of your program. </p>
					<p><strong><u>Intermediate-term outcomes</u></strong> are stated as changes in values, behavior, policies, and systems. Intermediate-term outcomes are what you would expect to follow on from the short-term outcomes you have identified. So, if you have identified an increase in staff or parental knowledge as a short-term outcome, the Intermediate-term outcome is likely to be the application of that knowledge, for example a change in behavior. </p>
					<p><strong><u>Long-term outcomes</u></strong> are stated as changes in conditions like social. economic, civic, and environmental. This outcome should resolve the issue identified in your problem statement. Long-term outcomes are sometimes called 'impact outcomes' and usually take a long time to be seen (sometimes up to ten years) and will be influenced by factors which are outside of your control.</p>
					
					<div class="col-md-4 plpr">
						<textarea class="form-control required" rows="5" id="shortOutCome" name="shortOutCome" placeholder=""><?php if(isset($logic_model_details->shortOutCome) && $logic_model_details->shortOutCome!=''){echo $logic_model_details->shortOutCome;}else{echo '<ul>
	<li>Short-term outcomes</li>
	<li>Knowledge on how websites work</li>
	<li>Raised awareness on coding</li>
</ul>';}?></textarea>
					</div>
					
					<div class="col-md-4 plpr">
						<textarea class="form-control required" rows="5" id="intermediateOutCome" name="intermediateOutCome" placeholder=""><?php if(isset($logic_model_details->intermediateOutCome) && $logic_model_details->intermediateOutCome!=''){echo $logic_model_details->intermediateOutCome;}else{echo '<ul>
	<li>Intermediate-term outcomes</li>
	<li>Support of active volunteers</li>
	<li>Motivate participants to become active alumni</li>
	<li>Website improvement because of high quality images</li>
</ul>';}?></textarea>
					</div>
					
					<div class="col-md-4 plpr">
						<textarea class="form-control required" rows="5" id="longOutCome" name="longOutCome" placeholder=""><?php if(isset($logic_model_details->longOutCome) && $logic_model_details->longOutCome!=''){echo $logic_model_details->longOutCome;}else{echo '<ul>
	<li>Long-term outcomes</li>
	<li>Improved community environment</li>
	<li>Improved quality of media projects</li>
</ul>';}?></textarea>
					</div>
					<div class="clearfix"></div>
					
				</div>
			</div>
			<div class="ques"></div>
		</div>	
		<div class="box-footer">
			<button type="submit" class="btn btn-primary" id="submitBtn">Save & Update</button>
		</div>
		</form>
	</div>
</div>
<div class="clearfix"></div>
<script>
jQuery(function () {
	jQuery('#logicModelFrm').validate({
		ignore: [], 
		highlight: function(element) {
			jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error').addClass('has-success');
			element.remove();
		},
		submitHandler: function(form){
			var site_base_url = jQuery('#h_base_url').val();
			var form = jQuery('#logicModelFrm');
			var url = site_base_url+form.attr('action');
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			jQuery.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					jQuery('#submitBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					if(result=='success'){
						window.location=site_base_url+'logic_model';
					}else{						
						jQuery('#resMsg').html('<div class="alert alert-danger">'+result+'</div>');
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						jQuery('#submitBtn').html('Save & Update');
					}					
				},
				error: function(xhr, status, error_desc){				
					jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					jQuery('#resMsg').html('<div class="alert alert-danger">'+error_desc+'</div>');
					jQuery('#submitBtn').html('Save & Update');
				}
			});		
			return false;
		}
	});
});
</script>