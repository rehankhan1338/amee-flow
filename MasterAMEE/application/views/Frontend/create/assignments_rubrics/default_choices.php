<?php if($question_type==1){ ?>

<div class="form-group answer_fields" id="div_choice_1" style="padding-left:50px;">
	<input type="text" name="choice_1" id="choice_1" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 1"  />
</div>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<input type="text" name="choice_2" id="choice_2" value="" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice 2"  />
</div>

<div class="multiple_choices_manage" style="padding-left:50px;"></div>

<?php } ?>

<?php if($question_type==3){ ?>

<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<textarea readonly="readonly" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
</div>

<?php } ?>