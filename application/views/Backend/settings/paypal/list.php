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
		<table class="table table-hover " id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%" nowrap="nowrap">S.No</th>
                    <th nowrap="nowrap">Purpose</th> 
                    <th nowrap="nowrap">Paypal IPN</th> 
                    <th nowrap="nowrap">Description</th>
					<th nowrap="nowrap">Amount</th>
					<th nowrap="nowrap">Duration</th>
					<th nowrap="nowrap">Currency Code</th>
                    <th nowrap="nowrap">Status</th>
                    <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			<tbody>
       <?php $i=1; foreach ($paypal_details as $paypal) { ?>
                   <tr>
                	<td><?php echo  $i;?></td>
                    <td style="font-weight:600;"><?php echo $paypal->purpose;?></td> 
                    <td ><?php echo $paypal->paypal_id;?></td> 
                    <td ><?php echo $paypal->item_name;?></td> 
					<td ><?php echo $paypal->amount;?></td>
					<td ><?php echo $paypal->duration;?></td>
					<td ><?php echo $paypal->currency_code;?></td>
                    <td  nowrap="nowrap"> 
					<?php if($paypal->status=='paypal'){?>
 					<span style="color:#52AB0B; font-size:12px;"><i class="fa fa-circle"></i> </span> Paypal (Live) 
				<?php }else{ ?>
					<span style="color:#D73925;font-size:12px;"><i class="fa fa-circle"></i> </span> Sandbox (Test)
				<?php }?>
				</td>  
                    <td>
                        <a href="<?php echo  base_url();?>admin/paypal/edit/<?php echo $paypal->id;?>" class="btn btn-success btn-sm"> Edit</a> 
                       
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
    