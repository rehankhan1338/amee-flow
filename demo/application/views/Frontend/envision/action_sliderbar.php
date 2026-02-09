<script type="text/javascript">  
jQuery(function (){
	if(jQuery('#editor1').length > 0){CKEDITOR.replace( 'editor1',{height: '200px',}); }
	if(jQuery('#editor2').length > 0){CKEDITOR.replace( 'editor2',{height: '200px',}); }
	if(jQuery('#editor3').length > 0){CKEDITOR.replace( 'editor3',{height: '200px',}); }
	if(jQuery('#editor4').length > 0){CKEDITOR.replace( 'editor4',{height: '200px',}); }
	if(jQuery('#editor5').length > 0){CKEDITOR.replace( 'editor5',{height: '300px',}); }	
}); 
</script> 
<div class="bandit_img"><img src="<?php echo base_url();?>assets/frontend/images/pilot4.png" alt=""  class="img-responsive" /></div>
<div id="wizard" class="wizard">
	<ul class="hormenu anchor">
		<li>
			<a href="<?php echo base_url();?>department/envision/action1" class="<?php if(isset($action_menu) && $action_menu==1){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="1">
				<span class="h2" style="margin-top:0">Action 1</span>
				<span class="dot"><span></span></span>
				<span class="label">ADD OVERVIEW, MISSION, VISION & GOALS</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>department/envision/action2" class="<?php if(isset($action_menu) && $action_menu==2){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="2">
				<span class="h2" style="margin-top:0">Action 2</span>
				<span class="dot"><span></span></span>
				<span class="label">ADD LEARNING OUTCOMES & OBJECTIVES</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>department/envision/action3" class="<?php if(isset($action_menu) && $action_menu==3){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="3">
				<span class="h2" style="margin-top:0">Action 3</span>
				<span class="dot"><span></span></span>
				<span class="label">Assign Core Competencies</span>
			</a>
		</li> 
		
	</ul>
</div>