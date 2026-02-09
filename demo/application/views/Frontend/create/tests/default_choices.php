<?php if($question_type==1){ ?>
<div class="col-md-12">
	<div class="col-md-8">
		<label style="margin: 0px 0 10px -15px;">Choices</label>
	</div>
	
	<div class="col-md-4">
		<label style="margin: 0px 0 10px -15px;">Correct Answer</label>
	</div>	
</div>

<div class="col-md-12" id="div_choice_1">
	<div class="col-md-8">
		<div class="form-group answer_fields">
			<input type="text" name="choice_1" id="choice_1" value="" class="form-control required" placeholder="Insert text to write Choice 1"  />
		</div>
	</div>	
	<div class="col-md-4">
		<div class="form-group" style="padding-left: 60px;">
			<input type="radio" name="answer_radio" id="answer_radio" value="1" style="margin: 15px -3px 0;" class="required" />
		</div>
	</div>	
</div>

<div class="col-md-12">
	<div class="col-md-8">
		<div class="form-group answer_fields" id="div_choice_2">
			<input type="text" name="choice_2" id="choice_2" value="" class="form-control required" placeholder="Insert text to write Choice 2"  />
		</div>
	</div>	
	<div class="col-md-4">
		<div class="form-group" style="padding-left:60px;">
			<input type="radio" name="answer_radio" id="answer_radio" value="2" style="margin: 15px -3px 0;" />
		</div>
	</div>	
</div>	
<div class="multiple_choices_manage"></div>
	
<style type="text/css">
	#undergraduate_checkboxes {
	  display: none;
	  border: 1px #dadada solid;
	  position:absolute;
	  width:90.1%;
	  z-index:999;
	  background: #485b79 url(../images/default/headerbg.png);
	}
	#undergraduate_checkboxes label {
	  display: block;padding: 3px 15px;width: 47%%;color: #fff;font-size: 17px; text-align:left;
	}
	#undergraduate_checkboxes label:hover {
	  background-color: #fb9337; color:#fff; border-radius:3px;
	}
</style>

<div style="padding-left:30px; width:64.4%;">
	<div class="form-group" id="">
		<label>Select Point Value (Marks of Question)</label>
		<select name="point_value" id="point_value" class="form-control required" placeholder="Select Point Value">
			<option value="">Select Point Value (Marks of Question)</option>
			<?php for($i=1; $i<=20; $i++){?>
				<option value="<?php echo $i;?>"><?php echo $i;?></option>
			<?php } ?>
		</select>
	</div>
	
	<div class="form-group" id="" >
		<label>Click on the dropdown box to align your question with a program learning objective/outcome. </label>
		<div onclick="undergraduate_showCheckboxes()">
			<select class="form-control" id="undergraduate_direct_assesment" name="undergraduate_direct_assesment">
				<option value="">-- Select --</option>
			</select>
			<div class="overSelect"></div>
		</div>
		<div id="undergraduate_checkboxes">
			<?php foreach($department_pslos_undergraduate as $pslos_undergraduate){?>	
				<label for="undergraduate_<?php echo $pslos_undergraduate->id;?>">
				<input type="checkbox" name="undergraduate_dam[]" class="" onclick="return get_sub_indicator_manage(this.value)" id="undergraduate_<?php echo $pslos_undergraduate->id;?>" value="<?php echo $pslos_undergraduate->id;?>" /> &nbsp;&nbsp;<span id="plos_name<?php echo $pslos_undergraduate->id;?>"><?php echo $pslos_undergraduate->plso_title;?></span></label>
			<?php } ?>	
			
			<?php foreach($department_pslos_graduate as $pslos_graduate){?>	
				<label for="undergraduate_<?php echo $pslos_graduate->id;?>">
				<input type="checkbox" name="undergraduate_dam[]" class="" onclick="return get_sub_indicator_manage(this.value)" id="undergraduate_<?php echo $pslos_graduate->id;?>" value="<?php echo $pslos_graduate->id;?>" /> &nbsp;&nbsp;<span id="plos_name<?php echo $pslos_graduate->id;?>"><?php echo $pslos_graduate->plso_title;?></span></label>
			<?php } ?>
		</div>
	</div>
	
	<div class="form-group" id="plso_display" >
	
	</div>
</div>

	<script type="text/javascript">
	 var expanded = false;
	function undergraduate_showCheckboxes() {
	  var checkboxes = document.getElementById("undergraduate_checkboxes");
	  if (!expanded) {
	  	jQuery('#undergraduate_direct_assesment').html('<option>Click Here to Hide Options</option>'); 
	    checkboxes.style.display = "block";
	    expanded = true;
	  } else {
	  	jQuery('#undergraduate_direct_assesment').html('<option>-- Select --</option>'); 
	    checkboxes.style.display = "none";
	    expanded = false;
	  }
	}
	
	
	function get_sub_indicator_manage(plos_id){
	
	var test=document.getElementById('undergraduate_'+plos_id); 
	
	if (test.checked == 1){
	
		var plos_name = jQuery('#plos_name'+plos_id).html();
		html='<p id="app_plos_'+plos_id+'">'+plos_name+'</p>';
		jQuery('#plso_display').append(html);
		
	}else{
	
		//var plos_name = jQuery('#plos_name'+plos_id).html();
		jQuery('#app_plos_'+plos_id).remove();
		
	} 
 
}

	</script>
<?php } ?>


<?php if($question_type==3){ ?>

<!--<div class="form-group answer_fields" id="div_choice_2" style="padding-left:50px;">
	<textarea readonly="readonly" name="text_question_type_field" id="text_question_type_field" class="form-control" style="width:80%;resize:none;" placeholder="Example field look"></textarea>
</div>-->

<div class="form-group" id="" style="padding-left:50px;">
	<select name="point_value" id="point_value" class="form-control required" style="width:50%;" placeholder="Select Point Value">
		<option value="">Select Point Value (Marks of Question)</option>
		<?php for($i=1; $i<=20; $i++){?>
			<option value="<?php echo $i;?>"><?php echo $i;?></option>
		<?php } ?>
	</select>
</div>

<?php } ?>

