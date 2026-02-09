<?php if(count($notesDataArr)>0){
foreach($notesDataArr as $row){?>
<div class="col-12 my-2" style="background:#f4f4f4; border-radius:10px; padding:10px 20px 1px 20px;">
    <h5><?php echo $row['auName'];?> &nbsp;<small style="font-size: 75%;font-style: italic;"><?php echo date('m/d/Y, h:i A',$row['addedOn']);?></small> </h5>
    <p><?php echo $row['notes'];?></p>
</div>
<?php } }else{ echo '<h5>No notes found</h5>'; } ?>