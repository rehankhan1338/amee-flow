<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<strong>Assignments Question : : Manage</strong>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>

	<div class="modal-body">
		 
   			<h4><b>Q. </b><?php echo $assignments_rubrics_question_details->question_title;?></h4>
			
			<div class="col-md-12">
				<?php if(isset($assignments_rubrics_question_details->question_type) && $assignments_rubrics_question_details->question_type==1){?>
					<ul style="margin-left:10px; margin-top:10px;">
						<?php foreach($assignments_rubrics_question_ansers_details as $ansers_details){?>
							<li style="padding:3px 5px;"><?php echo $ansers_details->answer_choice;?></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>			
		 
 		<div class="clearfix"></div>
	</div>	 
</div>
</div>