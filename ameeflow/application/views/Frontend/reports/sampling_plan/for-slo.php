<script type="text/javascript">
$(function(){ 
    $('#tbl_recordtbl_<?php echo $sloFor;?>').DataTable({
      "paging": false,
	  "pageLength": 100,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": true
    });
});
</script> 
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped" id="tbl_recordtbl_<?php echo $sloFor;?>">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th><?php echo strtoupper($sloFor);?> Course</th>
                    <th>Class/Sec.</th>
                    <th>Enroll.</th>
                    <th>Program</th>
                    <th>Instructor</th>
                    <th>Select</th>
                    <?php if($sloFor=='islo'){?> <th>Assigned ISLO</th><?php } ?>
                    <?php if($sloFor=='gislo'){?> <th>Assigned GISLO</th><?php } ?>
                    <?php if($sloFor=='pslo'){?> <th>Assigned PSLO</th><?php } ?>
                    <?php if($sloFor=='gpslo'){?> <th>Assigned GPSLO</th><?php } ?>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach($sloDataArr as $row){ 
                $chkSts = 0;
                $resChk = filter_array_two($getCourseTakenStsDataArr,$sloFor,'sloFor',$row['ceClassId'],'ceClassId');
                if(count($resChk)>0){
                    if(isset($resChk[0]['courseSts']) && $resChk[0]['courseSts']==1){
                        $chkSts = 1;
                    }
                }
                ?>
                <tr id="isoTr<?php echo $sloFor.$row['ceClassId'];?>" class="<?php if($chkSts==1){echo 'SelTr';}?>">   
                    <td><?php echo $i;?></td>                 
                    <td class="fw600"> <?php echo $row['subject'].' '.$row['courseNBR'];?> <small><?php echo $row['courseTitle'];?></small> </td>
                    <td> <?php echo $row['classNBR'].' ('.$row['sectionNo'].')';?> </td>
                    <td> <?php echo $row['enrolled'];?> </td> 
                    <td> <?php echo $row['program'];?> </td>
                    <td> <?php echo $row['lastName']; if(isset($row['firstName']) && $row['firstName']!=''){ echo ', '.$row['firstName'];}?> <small><?php echo $row['facultyEmail'];?></small> </td> 
                    <td class="modalacToggle">
                        <input value="<?php echo $sloFor.'||'.$row['ceClassId'];?>" class="partCase" <?php if($chkSts==1){?> checked="checked" <?php } ?> id="toggle-<?php echo $sloFor.$row['ceClassId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['ceClassId'];?>','<?php echo $sloFor;?>','<?php echo $ceId;?>');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="secondary" data-on="Yes" data-off="No" type="checkbox">
                        <span id="spinner_<?php echo $sloFor;?>_<?php echo $row['ceClassId'];?>"></span>
                    </td> 
                    <?php if($sloFor=='islo'){ ?> <td><?php 
                    $chkalignISLOArr = explode(',',$spDetails['alignISLO']);
                    $courseISLOArr = explode(',',$row['courseISLO']);
                    $cArr = array();
                    foreach($courseISLOArr as $c){
                        if(in_array($c,$chkalignISLOArr)){
                            $cArr[] = '<label class="selNo">'.$c.'</label>';
                        }else{
                            $cArr[] = $c;
                        }
                    }
                    echo implode(', ',$cArr);
                    ?></td><?php } ?>
                    <?php if($sloFor=='gislo'){?> <td><?php 
                    $chkalignISLOArr = explode(',',$spDetails['alignGISLO']);
                    $courseISLOArr = explode(',',$row['courseGISLO']);
                    $cArr = array();
                    foreach($courseISLOArr as $c){
                        if(in_array($c,$chkalignISLOArr)){
                            $cArr[] = '<label class="selNo">'.$c.'</label>';
                        }else{
                            $cArr[] = $c;
                        }
                    }
                    echo implode(', ',$cArr);
                    //echo str_replace(',',', ',$row['courseGISLO']);?></td><?php } ?>
                    <?php if($sloFor=='pslo'){?> <td><?php 
                    $chkalignISLOArr = explode(',',$spDetails['alignPSLO']);
                    $courseISLOArr = explode(',',$row['coursePSLO']);
                    $cArr = array();
                    foreach($courseISLOArr as $c){
                        if(in_array($c,$chkalignISLOArr)){
                            $cArr[] = '<label class="selNo">'.$c.'</label>';
                        }else{
                            $cArr[] = $c;
                        }
                    }
                    echo implode(', ',$cArr);
                    //echo str_replace(',',', ',$row['coursePSLO']);?></td><?php } ?>
                    <?php if($sloFor=='gpslo'){?> <td><?php 
                     $chkalignISLOArr = explode(',',$spDetails['alignGPSLO']);
                    $courseISLOArr = explode(',',$row['courseGPSLO']);
                    $cArr = array();
                    foreach($courseISLOArr as $c){
                        if(in_array($c,$chkalignISLOArr)){
                            $cArr[] = '<label class="selNo">'.$c.'</label>';
                        }else{
                            $cArr[] = $c;
                        }
                    }
                    echo implode(', ',$cArr);
                    //echo str_replace(',',', ',$row['courseGPSLO']);?></td><?php } ?>
                    <td> <span id="enoteLnk<?php echo $sloFor.$row['ceClassId'];?>" onclick="return manageNotes('<?php echo $row['ceClassId'];?>','<?php echo $sloFor;?>');"> <i class="icon-sm" data-feather="edit"></i> </span> </td>
                </tr>
                <?php $i++; }?>
                
            </tbody>
        </table>							
    </div>
</div>