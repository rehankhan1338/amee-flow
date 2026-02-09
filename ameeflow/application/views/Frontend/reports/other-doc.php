<section class="content">         
    <div class="box">  
        
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="3%"> # </th>
                            <th>Document Name/Title </th>
                            <th>Project Name</th>
                            <th>File Type</th>
                            <!-- <th>Created On</th> -->
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($documentsDataArr as $row){                     
                                if($row['docType']==1){
                                    $rLnk = $row['docLnk'];
                                }else{
                                    $rLnk = base_url().'assets/upload/documents/other/'.$row['docFileName'];
                                }
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td class="fw600"> <a <?php if($row['docType']==1 || $row['docFileExt']=='pdf'){ ?> target="_blank"<?php } ?> id="proTitle<?php echo $row['docId'];?>" class="cp" href="<?php echo $rLnk;?>"> <?php echo $row['docTitle']; ?> <i class="fa fa-external-link" aria-hidden="true"></i> </a> </td>
                            <td> <?php 
                            if(isset($row['projectIds']) && $row['projectIds']!=''){
                                $projectIdsArr = explode(',',$row['projectIds']);
                                foreach($projectIdsArr as $p){
                                   $pRes = filter_array($projectDataArr,$p,'projectId');
                                   if(count($pRes)>0){
                                    echo '<p class="py-0 my-1">'.$pRes[0]['projectName'].'</p>';
                                   }
                                }
                            }else{
                                echo '-';
                            }
                            ?></td>
                            <td>
                                <?php if($row['docType']==1){ echo 'URL';}else{echo strtoupper($row['docFileExt']);} ?>
                            </td>
                            <!-- <td> <?php //echo date('m/d/Y, h:i A',$row['onTime']);?></td>                            -->
                            
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
 

</section>