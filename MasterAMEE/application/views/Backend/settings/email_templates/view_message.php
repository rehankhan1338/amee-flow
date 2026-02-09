<h3 style="color:#575A5B;"><?php echo 'Mail Format : : '.$email_templates_details->purpose;?></h3>
<?php 
$logo = base_url().'assets/backend/logo/'.$configuration_details->logo;
echo str_replace('{logo}',$logo,$email_templates_details->message);
?>