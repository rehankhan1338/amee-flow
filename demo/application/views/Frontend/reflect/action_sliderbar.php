<script type="text/javascript">  
jQuery(function () {
	if(jQuery('#editor1').length > 0){CKEDITOR.replace( 'editor1',{height: '200px',}); }	
}); 
</script>
<div class="bandit_img"><img src="<?php echo base_url();?>assets/frontend/images/pilot4.png" alt="" class="img-responsive" /></div>
<div id="wizard" class="wizard" >
	<ul class="hormenu anchor">
		<li>
			<a href="<?php echo base_url();?>department/reflect/action1" class="<?php if(isset($action_menu) && $action_menu==1){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="1">
				<span class="h2" style="margin-top:0">Action 1</span>
				<span class="dot"><span></span></span>
				<span class="label">Add Overview</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>department/reflect/action2" class="<?php if(isset($action_menu) && $action_menu==2){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="2">
				<span class="h2" style="margin-top:0">Action 2</span>
				<span class="dot"><span></span></span>
				<span class="label">Select MEASUREMENT TOOLS, BENCHMARKS & TARGETS</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>department/reflect/action3" class="<?php if(isset($action_menu) && $action_menu==3){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="3">
				<span class="h2" style="margin-top:0">Action 3</span>
				<span class="dot"><span></span></span>
				<span class="label">Assessment Plan</span>
			</a>
		</li> 		
	</ul>
</div>