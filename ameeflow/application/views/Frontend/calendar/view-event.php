<h5><?php echo date('l, d F Y',$eventDetails['eDate']).' on '.date('h:i A',$eventDetails['stime']);
if(isset($eventDetails['etime']) && $eventDetails['etime']!='' && $eventDetails['etime']>0){
    echo ' - '.date('h:i A',$eventDetails['etime']);
}

echo ' '.$this->config->item('timezone_array_config')[$eventDetails['etimeZoneId']]['short_name'];

?></h5>
<div class="eDesc fs16" style="line-height:25px;"><?php if(isset($eventDetails['eDesc']) && $eventDetails['eDesc']!=''){echo $eventDetails['eDesc'];}?></div>
<?php if(isset($eventDetails['eURL']) && $eventDetails['eURL']!=''){?>
<a target="_blank" href="<?php echo $eventDetails['eURL'];?>"> <?php echo $eventDetails['eURL'];?> </a>
<?php } ?>

<div class="mt-3">
    <a href="<?php echo base_url().'home/downloadIcs?eneId='.$eventDetails['eneId']; ?>" class="btn btn-primary btn-sm">Add to Calendar</a>&nbsp;&nbsp;
<?php if($ucreatedBy==$eventDetails['createdBy'] && $ucreatedById==$eventDetails['createdById']){?>

    
    <button type="button" id="editCalBtn" class="btn btn-secondary btn-sm" onclick="return manageEvent('<?php echo $eventDetails['eId'];?>','0');">Edit</button>&nbsp;&nbsp;
    <button type="button" id="delCalBtn" class="btn btn-danger btn-sm" onclick="return deleteEvent('<?php echo $eventDetails['eId'];?>');">Delete</button>

<?php } ?>
</div>