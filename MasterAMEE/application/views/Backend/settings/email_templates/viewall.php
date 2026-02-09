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
      <div class="box snapshot_page">
	    
                    
          <!-- start body div -->
          <div class="box-body" style="padding:0;">
 
    <div class="table-responsive">
		<table class="table table-hover table-bordered table-striped" id="table_recordtbl12">
			<thead>
				<tr class="trbg">
					<th width="3%">#</th>
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
                    <td nowrap="nowrap" style="font-weight:600;"><?php echo $email_templates->purpose;?></td> 
                    <td nowrap="nowrap"><?php echo $email_templates->subject;?></td> 
                    <td nowrap="nowrap"><a class="btn fancybox" href="<?php echo base_url();?>admin/home/email_templates_message?id=<?php echo $email_templates->id;?>" style="padding:0;"><i style="font-size: 25px;" class="fa fa-list-alt" aria-hidden="true"></i></a><?php //echo $email_templates->message;?></td> 
                    <td nowrap="nowrap"> 
					<?php if($email_templates->status==0){?>
 					<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }else{ ?>
					<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
				<?php }?>
				</td>  
                    <td>
                        <a style="font-weight:600; padding:3px 15px; font-size:13px;" href="<?php echo  base_url();?>admin/setting/email_templates/edit?id=<?php echo $email_templates->id;?>" class="btn btn-primary btn-sm"> Edit</a> 
                       
                        </td>
                </tr>
                   <?php  $i++; } ?>          
                    
                </tbody>
                                      
      </table>
 
    </div>
      <p><strong>Note: </strong> The email templates below are pre-set.  If you would like to communicate with your evaluation/assessment team, please use the notification feature for internal communication.</p>
        </div>
        <!-- /.box-body -->
        <!-- Modal -->    
        </div>
        <!-- /.box-body -->

        
      <!-- /.box -->
    </section>
    