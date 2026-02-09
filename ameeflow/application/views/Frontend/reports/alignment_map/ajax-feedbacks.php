<?php if(count($feedbackDataArr)>0){
foreach($feedbackDataArr as $row){?>
<div class="col-12 my-2" style="background:#f4f4f4; border-radius:10px; padding:10px 20px 1px 20px;">
    <h5><?php echo $row['swName'];?> &nbsp;<small style="font-size: 75%;font-style: italic;"><?php echo date('m/d/Y, h:i A',$row['actionTakenOn']);?></small> </h5>
    <?php echo $row['reason'];?>
</div>
<?php } }else{ echo '<h5>No feedback found</h5>'; } ?>