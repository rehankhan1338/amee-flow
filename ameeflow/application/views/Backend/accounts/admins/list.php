<section class="content">
    <div class="box">  
        
        <div class="box-header no-border">
            <h3 class="box-title"><?php echo $accountDetailsArr['universityName'];?></h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteUser('<?php echo $accountDetailsArr['universityId'];?>');" style="margin-right:5px;padding: 3px 25px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 25px; font-size:15px;" onclick="return manageUser('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New PM</button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="2%"> <input type="checkbox" id="selectall" /> </th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact #</th>
                            <th>Unit</th>
                            <th>Acct. Type</th>
                            <th>Last Login</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($accountAdminDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="uniAdminIds[]" name="uniAdminIds[]" value="<?php echo $row['uniAdminId'];?>" /> </td>
                            <td class="fw600"> <?php echo $row['fullName']; ?> </td>
                            <td><?php echo $row['email'];?> <small><?php echo 'P: '.base64_decode($row['randomId']);?></small> </td>
                            <td><?php echo $row['contactNo'];?> </td>
                            <td><?php echo $row['unitName'];?> </td>
                            <td class="fw600"><?php if($row['accType']=='system-admin'){echo 'Project Manager';}else{echo ucwords(str_replace('-',' ',$row['accType']));}?> </td>
                            <td> <?php if(isset($row['lastLogin']) && $row['lastLogin']>0){echo date('m/d/Y, h:i A',$row['lastLogin']);}?> </td>                             
                            <td><?php if($row['createdBy']==0){echo 'Super Admin'; }else{
                                $cres = filter_array($accountAdminDataArr,$row['createdBy'],'uniAdminId');
                                if(count($cres)>0){
                                    echo $cres[0]['fullName'];
                                }
                            }?> </td>
                            <td>
                                <?php if($row['isActive'] == 1){?>
                                    <label class="mstus rejected" style="padding:0px 10px;">In-active</label>
                                <?php }else{ ?>
                                    <label class="mstus accepted" style="padding:0px 10px;">Active</label>
                                <?php } ?>
                            </td>
                            <td nowrap>
                                 
                                <a class="btn btn-primary btn-sm" id="edrole<?php echo $row['uniAdminId'];?>" onclick="return manageUser('<?php echo $row['uniAdminId'];?>');">Edit</a>                                
                                 
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/Backend/accounts/admins/pop-model.php');
?>
</section>