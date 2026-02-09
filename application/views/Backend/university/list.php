<style>
th{ vertical-align:top !important;}
</style>
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/accounts/delete?id='+val;
 		} 
 	}
}
function send_mail(val){
 	if(val!="") {
		var r = confirm("Are you sure want to send a mail!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/accounts/sendmail?id='+val;
 		} 
 	}
} 
</script> 
<section class="content">
<div class="box">
	<div class="box-header with-border">
      <h3 class="box-title">Listing - Set-up cost $350 (subdomain database must be created first before URL can be used)</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 4px 15px; vertical-align:top; font-weight:600;" href="<?php echo base_url();?>admin/accounts/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New University </a>
		</div>
    </div>            
  <!-- start body div -->
	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-striped " id="table_recordtbl">
			<thead>
				<tr>
					<th width="3%">#</th>
		            <th>University Name</th> 
					<th>Subdomain URL</th>
		            <th>Name</th>
		            <th>Email</th>
		            <th>Phone</th>
		            <th>Action</th>
				</tr>
			</thead>			 
			<tbody>
				<?php $i=1; foreach ($university_details as $row){
					$sbURL = 'https://'.strtolower($row->subdomain_name).'.assessmentmadeeasy.com';
				 ?>
				<tr>
					<td><?php echo  $i;?></td>				
					<td style="font-weight:600;"><?php echo $row->university_name;?></td> 					
					<td><a style="font-weight:600;" href="<?php echo $sbURL;?>" target="_blank"><?php echo $sbURL;?></a></td> 					
					<td><?php echo $row->first_name.' '.$row->last_name;?></td> 				
					<td><?php echo $row->email;?></td>					 
					<td><?php echo $row->phone;?></td> 					  
					<td nowrap="nowrap">
						<a href="<?php echo  base_url();?>admin/accounts/edit/<?php echo $row->id;?>" class="btn btn-success btn-sm"> Edit</a>
						<?php if(isset($row->id) && $row->id!='1'){?> 
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"><i class="fa fa-trash"></i></a>
						<?php } ?>
						<!--<a class="btn btn-info btn-sm" onclick="return send_mail('<?php echo $row->id;?>');"> SendMail</a>-->
					</td>
				</tr>
				<?php  $i++; } ?>
				</tbody>		                              
		</table>
</div>
</div>  
</div>
</section>