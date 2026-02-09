<option value="0">Select...</option>
<?php foreach($termsOptions as $term){?>
<option <?php if(isset($selTerm) && $selTerm==$term['termId']){?> selected <?php }?> value="<?php echo $term['termId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$term['termId']]['name'];?></option>
<?php } ?>