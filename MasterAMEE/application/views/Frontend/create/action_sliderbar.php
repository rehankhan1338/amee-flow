<script type="text/javascript">  
jQuery(function (){
	if(jQuery('#editor1').length > 0){CKEDITOR.replace( 'editor1',{height: '150px',}); }
	if(jQuery('#editor2').length > 0){CKEDITOR.replace( 'editor2',{height: '150px',}); }
	if(jQuery('#editor3').length > 0){CKEDITOR.replace( 'editor3',{height: '150px',}); }
	if(jQuery('#editor4').length > 0){CKEDITOR.replace( 'editor4',{height: '150px',}); }
	if(jQuery('#editor5').length > 0){CKEDITOR.replace( 'editor5',{height: '300px',}); }	
}); 
</script> 
<style type="text/css">
<?php if(isset($dept_session_details->department_type)&& $dept_session_details->department_type==21){ ?>
.wizard .hormenu li{width:18%;}
<?php }else{ ?>
.wizard .hormenu li{width:24%;}
<?php } ?>
.wizard .hormenu li a span.h2{font-weight: 600;font-size: 18px;padding-bottom: 10px;}
</style>
<div class="bandit_img"><img src="<?php echo base_url();?>assets/frontend/images/pilot4.png" alt=""  class="img-responsive" /></div>
 
<div id="wizard" class="wizard">
	<ul class="hormenu anchor">
		<li>
			<a href="<?php echo base_url();?>department/create/surveys" class="<?php if(isset($action_menu) && $action_menu==1){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="1">
				<span class="h2" style="margin-top:0">Survey Builder</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
		<?php if(isset($dept_session_details->department_type)&& $dept_session_details->department_type==21){ ?>
		<li>
			<a href="<?php echo base_url();?>department/create/unit_reviews" class="<?php if(isset($action_menu) && $action_menu==2){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="2">
				<span class="h2" style="margin-top:0">Unit Reviews</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
		<?php } ?>
		<li>
			<a href="<?php echo base_url();?>department/create/effectiveness_data" class="<?php if(isset($action_menu) && $action_menu==3){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="3">
				<span class="h2" style="margin-top:0">Effectiveness Data</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
		
		<li>
			<a href="<?php echo base_url();?>department/create/tests" class="<?php if(isset($action_menu) && $action_menu==4){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="4">
				<span class="h2" style="margin-top:0">Test/Poll</span>
				<span class="dot"><span></span></span>
			</a>
		</li>
 		<li>
			<a href="<?php echo base_url();?>department/create/assignments_rubrics" class="<?php if(isset($action_menu) && $action_menu==5){echo 'done';}else{ echo 'disabled'; }?>" isdone="1" rel="5">
				<span class="h2" style="margin-top:0">Assignment/Rubric Builder</span>
				<span class="dot"><span></span></span>
			</a>
		</li>  
		
	</ul>
</div>