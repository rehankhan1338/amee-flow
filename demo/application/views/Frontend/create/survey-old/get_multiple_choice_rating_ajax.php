<?php $options = explode('@@',$multiple_choice_rating_list->options);?>
<input type="hidden" name="h_choice_count" id="h_choice_count" value="<?php echo count($options)-1;?>">
<?php 
for($i=0;$i<count($options);$i++){ 
	if(trim($options[$i])!=''){
		$j=$i+1;
	?>
<div class="form-group answer_fields" id="div_choice_<?php echo $j;?>">
	<input type="text" name="choice_<?php echo $j;?>" id="choice_<?php echo $j;?>" value="<?php echo $options[$i];?>" class="form-control required" style="width:50%;" placeholder="Insert text to write Choice <?php echo $j;?>"  />
	<input type="hidden" name="new_choice_arr[]" id="new_choice_arr[]" value="<?php echo $j;?>" />
</div>

<?php } } ?>