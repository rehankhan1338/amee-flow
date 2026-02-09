    <div class="clearfix"></div>
     
</div>
    
</div>
</div><!--wrapper-->



<div class="footer">
<div class="container">
	
<div class="row">

	<?php if(isset($question_bar) && $question_bar==1 && isset($total_row) && $total_row>0){?>
		<div class="col-md-9 col-sm-9 col-xs-6">
		
			<?php $answers_count = get_test_answers_detail($test_detail->test_id,$test_detail->current_test_type, $auth_code);?>
			<div class="core_text"><?php echo $answers_count; ?> of <?php echo $total_row;?> answered</div>
			
			<?php $percentage = ($answers_count*100)/$total_row; ?>
			<div class="tile-progressbar">
				<span data-fill="<?php echo $percentage;?>%" style="width: <?php echo $percentage;?>%;"></span>
			</div>
		</div>
	<?php } ?>
	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="powered_by">
			<div class="core_text"><a href="https://mssra.com/" target="_blank" style="color:#fff;">Powered by MSSRA &nbsp;<i class="fa fa-external-link"></i></a></div>
			<!--<div class="amee_logo"><img src="<?php //echo base_url();?>assets/frontend/survey/images/amme_logo.png" align="" alt="AMEE"/></div>-->
		</div>
	</div>
</div>
	
	
	
</div>
</div><!--footer-->

</body>
</html>
