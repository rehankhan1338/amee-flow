<?php if(isset($change_to) && $change_to==0){ ?>
	<span class="user_display_rater_deactive" onclick="return display_raters_page('1','<?php echo $id;?>');"></span>
<?php }else{?>
	<span class="user_display_rater_active" onclick="return display_raters_page('0','<?php echo $id;?>');"></span>
<?php } ?>