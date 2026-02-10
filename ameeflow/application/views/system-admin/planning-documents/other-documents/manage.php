<section class="content">         
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title">Listing</h3>
            <div class="box-tools pull-right">
                <button id="delProBtn" type="button" onclick="return deleteDoc();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addProBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageDoc('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Document Name/Title </th>
                            <th>Project</th>
                            <th width="10%">Action</th>
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
                            <td> <input type="checkbox" class="case" id="docIds[]" name="docIds[]" value="<?php echo $row['docId'];?>" /> </td>
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
                            <td nowrap>
                                <a class="btn btn-primary btn-sm" id="epro<?php echo $row['docId'];?>" onclick="return manageDoc('<?php echo $row['docId'];?>');">Edit</a>
                                <a class="btn btn-danger btn-sm" id="deldoc<?php echo $row['docId'];?>" onclick="return deleteSingleDoc('<?php echo $row['docId'];?>');" style="margin-left:3px;"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/system-admin/planning-documents/other-documents/pro-models.php');
?>
</section>