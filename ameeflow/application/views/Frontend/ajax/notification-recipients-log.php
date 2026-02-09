<div class="row">
<div class="col-xs-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="1%">#</th>
                <th>Name</th>
                <th>Email</th>
                <?php if(isset($notiDetailsArr['resOptionId']) && $notiDetailsArr['resOptionId']!='' && $notiDetailsArr['resOptionId']>0){?>
                <th>Response</th>
                <th>Resp. Date</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
                foreach($notiRecipientsLogArr as $recp){ ?>
            <tr>
                <td><?php echo $i;?></td>
                <td class="fw600"><?php echo $recp['recpName'];?></td>
                <td><?php echo $recp['recpEmail'];?></td>
                <?php if(isset($notiDetailsArr['resOptionId']) && $notiDetailsArr['resOptionId']!='' && $notiDetailsArr['resOptionId']>0){?>
                <td>
                    <?php 
                    if(isset($recp['resOptChoiceId']) && $recp['resOptChoiceId']!='' && $recp['resOptChoiceId']>0){
                        $choiceRes = filter_array($resOptionsChoiceArr,$recp['resOptChoiceId'],'resOptChoiceId');
                        if(count($choiceRes)>0){
                            echo $choiceRes[0]['choiceName'];
                        }
                    }else if(isset($recp['resTxt']) && $recp['resTxt']!=''){
                        echo $recp['resTxt'];
                    }else{echo '&ndash;';}
                    ?>
                </td>
                <td><?php if(isset($recp['resTime']) && $recp['resTime']!='' && $recp['resTime']>0){echo date('m/d/Y, h:i A',$recp['resTime']); }else{echo '&ndash;';} ?></td>
                <?php } ?>
            </tr>
            <?php $i++; }?>
        </tbody>
    </table>
</div>
</div>