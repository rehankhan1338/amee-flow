<section class="content">
    <div class="box">  
 
        <div class="box-header no-border">
            <h3 class="box-title">Guest Access</h3>
            <div class="box-tools pull-right">
                <button id="delBtn" type="button" onclick="return deleteAccess();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="addBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageAccess('0');" class='btn btn-primary'> <i class="fa fa-plus"></i> Add New</button>               
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
                            <th>Date Added</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($guestAccessDataArr as $row){                        
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="uniAdminIds[]" name="uniAdminIds[]" value="<?php echo $row['uniAdminId'];?>" /> </td>
                            <td style="font-weight:500;"> <?php echo $row['fullName']; ?> </td>
                            <td><?php echo $row['email'];?></td>
                            <td><?php echo $row['contactNo'];?></td>                            
                            <td> <?php echo date('m/d/Y, h:i A',$row['onTime']);?></td>                            
                            <td>                                
                                <input <?php if(isset($row['isActive']) && $row['isActive']==0){?> checked="checked" <?php } ?> id="toggle-event-isActive<?php echo $row['uniAdminId'];?>" onchange="return update_toggle_swtich_values('<?php echo $row['uniAdminId'];?>','isActive');" data-toggle="toggle" data-size="mini" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Inactive" type="checkbox">
                                <span id="spinner_isActive_<?php echo $row['uniAdminId'];?>"></span>                                                
                            </td>
                            <td>                                
                                <a class="btn btn-primary btn-sm" id="edrole<?php echo $row['uniAdminId'];?>" onclick="return manageAccess('<?php echo $row['uniAdminId'];?>');">Edit</a>                                
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>					
            </div>	 
        </div>
    </div>
 
<?php 
include(APPPATH.'views/system-admin/guest-access/pop-model.php');
?>
</section>