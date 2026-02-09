<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin_review/delete_review?id='+val;
 		} 
 	}
} 
</script> 

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
       <div class="box">
	    
                    
          <!-- start body div -->
          <div class="box-body">
 
    <div class="col-xs-12 table-responsive">
		<table class="table table-hover" id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%">S.No</th>
                    <th nowrap="nowrap">Purpose</th> 
                    <th nowrap="nowrap">Subject</th> 
                    <th nowrap="nowrap">Message</th>  
                    <th>Status</th>
                    <th>Action</th>
				</tr>
			</thead>
			<tbody>
       <?php $i=1; foreach ($email_templates_details as $email_templates) { ?>
                   <tr>
                	<td><?php echo  $i;?></td>
                    <td nowrap="nowrap"><?php echo $email_templates->purpose;?></td> 
                    <td nowrap="nowrap"><?php echo $email_templates->subject;?></td> 
                    <td nowrap="nowrap"><a class="btn fancybox" href="<?php echo base_url();?>admin/home/email_templates_message?id=<?php echo $email_templates->id;?>" style="padding:0;">View</a><?php //echo $email_templates->message;?></td> 
                    <td nowrap="nowrap"> 
					<?php if($email_templates->status==0){?>
 					<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }else{ ?>
					<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }?>
				</td>  
                    <td>
                        <a href="<?php echo  base_url();?>admin/setting/email_templates/edit?id=<?php echo $email_templates->id;?>" class="btn btn-success btn-sm"> Edit</a> 
                       
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
    