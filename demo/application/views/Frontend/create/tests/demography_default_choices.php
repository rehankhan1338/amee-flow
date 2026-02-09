<?php if($question_type==1){ ?>
<div class="col-md-12">
	<div class="col-md-8">
		<label style="margin: 0px 0 10px -15px;">Choices</label>
	</div>	
</div>

<div class="col-md-12" id="div_choice_1">
	<div class="col-md-8">
		<div class="form-group answer_fields">
			<input type="text" name="choice_1" id="choice_1" value="" class="form-control required" placeholder="Insert text to write Choice 1"  />
		</div>
	</div>	
		
</div>

<div class="col-md-12">
	<div class="col-md-8">
		<div class="form-group answer_fields" id="div_choice_2">
			<input type="text" name="choice_2" id="choice_2" value="" class="form-control required" placeholder="Insert text to write Choice 2"  />
		</div>
	</div>	
		
</div>	
<div class="multiple_choices_manage"></div>

<?php } ?>


<?php if($question_type==3){ ?>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<textarea readonly="readonly" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
</div>



<?php } ?>

