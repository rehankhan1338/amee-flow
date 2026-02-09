<style type="text/css">
.wizard .hormenu li a span.h2{font-weight: 600;font-size: 18px;padding-bottom: 10px;}
</style>

<script type="text/javascript">  
jQuery(function (){
	if(jQuery('#editor1').length > 0){CKEDITOR.replace( 'editor1',{height: '150px',}); }
	if(jQuery('#editor2').length > 0){CKEDITOR.replace( 'editor2',{height: '150px',}); }
	if(jQuery('#editor3').length > 0){CKEDITOR.replace( 'editor3',{height: '150px',}); }
}); 
</script> 

<div class="bandit_img">
	<img src="<?php echo base_url();?>assets/frontend/images/pilot4.png" alt=""  class="img-responsive" />
</div>

<div id="wizard" class="wizard">
	<ul class="hormenu anchor">
		<li>
			<a href="<?php echo base_url();?>department/analyze?loop=1" class="<?php if(isset($_GET['loop']) && $_GET['loop']==1){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="1">
				<span class="h2" style="margin-top:0">Program Curriculum</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>department/analyze?loop=2" class="<?php if(isset($_GET['loop']) && $_GET['loop']==2){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="2">
				<span class="h2" style="margin-top:0">Academic Processes</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo base_url();?>department/analyze?loop=3" class="<?php if(isset($_GET['loop']) && $_GET['loop']==3){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="3">
				<span class="h2" style="margin-top:0">Evaluation Plan</span>
				<span class="dot"><span></span></span>
			</a>
		</li>		
	</ul>
</div>