<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/departments/delete?id='+val;
 		} 
 	}
} 
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
      <h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 4px 15px; vertical-align:top; font-weight:600; " href="<?php echo base_url();?>admin/departments/add" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;Add New</a>
		</div>
    </div>
  <style type="text/css">
  .dataTables_wrapper{margin-bottom: 60px;}
  .dropdown-menu{left: -25px;min-width: 130px;background-color: #f5f5f5;}
  .dropdown-menu > li > a > .glyphicon, .dropdown-menu > li > a > .fa, .dropdown-menu > li > a > .ion{margin-right: 5px;}
  .dropdown-menu > li > a{color:#333;}
  .dropdown-menu .divider{margin:5px 0;}
  a{cursor:pointer;}
  .btn-group>.btn:first-child {
    margin-left: 0;
    padding: 3px 10px;
}
  </style>          
  <!-- start body div -->
	<div class="box-body row" >
	<div class="col-md-12 table-responsive">
		<table class="table table-hover table-striped" id="table_recordtbl" >
			<thead>
				<tr class="trbg">
					<th style="vertical-align:top;" width="3%">#</th>
		            <th style="vertical-align:top;">Department/Program Name</th> 
		            <th style="vertical-align:top;">Type</th> 
		            <th style="vertical-align:top;">Name</th>
		            <th style="vertical-align:top;">Email</th>
		            <th style="vertical-align:top;">Username</th>
		            <th style="vertical-align:top;">Password</th>
		            <th style="vertical-align:top;">Status</th>
		            <th style="vertical-align:top;">Last Login</th>
		            <th style="vertical-align:top;">Action</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; foreach ($departments_details as $row) { ?>
				<tr>
					<td><?php echo  $i;?></td>
				
					<td style="font-weight:600;"><?php echo $row->department_name;?></td> 
					
					<td>
						<?php if(!empty($row->department_type)){ $dept_id = $row->department_type;}
							$department_type_result = get_master_department_type_by_id($dept_id);
							echo $department_type_result->txt_type;
						?>
					</td> 
					
					<td><?php echo $row->first_name.' '.$row->last_name;?></td> 
					
					<td><?php echo $row->email;?></td> 
					
					<td><?php echo $row->user_name;?></td> 
					
					<td><?php echo $row->password_view;?></td> 
					
					<td>
						<?php if(isset($row->status)&& $row->status=='0'){?>
							<span style="color:#D73925; font-size:10px;"><i class="fa fa-circle"></i></span>
						<?php }else{ ?>
							<span style="color:#52AB0B;font-size:10px;"><i class="fa fa-circle"></i></span>
						<?php }?>
					</td>
					 
					<td><?php if(isset($row->last_login) && $row->last_login!=''){echo date('m/d/Y h:i A', $row->last_login);}else{echo '&ndash;';} ?></td> 

<td nowrap="nowrap">
	<div class="btn-group" style="width:95px;">
 		<button aria-expanded="false" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			Action <span class="caret"></span>
			<span class="sr-only">Toggle Dropdown</span>
		</button>
		<ul class="dropdown-menu" role="menu" style="width:auto">
			<li><a href="<?php echo  base_url();?>admin/departments/sendmail/<?php echo $row->id;?>" onclick="return confirm('Are you sure want to send mail!');"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Mail</a></li>
			<li><a href="<?php echo base_url();?>admin/departments/edit/<?php echo $row->id;?>"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li>
			<li><a onclick="return delete_entry('<?php echo $row->id;?>');"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</a></li>
		</ul>
	</div>	 
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
    