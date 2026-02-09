<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/subadmins/delete?id='+val;
 		} 
 	}
} 
</script> 

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
       <div class="box">
	    
              <div class="box-header with-border">
                  <h3 class="box-title">List</h3>

                    <div class="box-tools pull-right">
					 
                      <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/subadmins/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
                    </div> 
					 
                </div>      
          <!-- start body div -->
          <div class="box-body">
 
    <div class="col-xs-12 table-responsive">
		<table class="table table-hover" id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%">S.No</th>
                    <th nowrap="nowrap">Name</th> 
                    <th nowrap="nowrap">E-Mail</th>
					<th nowrap="nowrap">UserName</th>
					<th nowrap="nowrap">Password</th>
 					<!--<th>Privillages</th>-->  
                    <th>Status</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody>
       <?php $i=1; foreach ($guest_details as $row) { ?>
                   <tr>
                	<td><?php echo  $i;?></td>
                    <td nowrap="nowrap"><?php echo $row->name;?></td> 
                  	<td nowrap="nowrap"><?php echo $row->email;?></td>
					<td nowrap="nowrap"><?php echo $row->username;?></td>
					<td nowrap="nowrap"><?php echo $row->password_show;?></td>
					<!--<td><a href="<?php echo base_url();?>admin_guest_access/set_privillages?guest_id=<?php echo $row->id;?>" >Set Privillages</a></td>-->
                    <td nowrap="nowrap"> 
					<?php if($row->status==1){?>
 					<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }else{ ?>
					<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }?>
				</td>  
                    <td>
                        <a href="<?php echo  base_url();?>admin/subadmins/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a> 
                       	<a class="btn btn-danger btn-sm btn_delete" onclick="return delete_entry('<?php echo $row->id;?>');">Delete</a>
                        </td>
                </tr>
                   <?php  $i++; } ?>          
                    
                </tbody>
                                      
      </table>
 
    </div>
      
        </div>
        <!-- /.box-body -->
        <!-- Modal -->    
        </div>
        <!-- /.box-body -->

        
      <!-- /.box -->
    </section>
    