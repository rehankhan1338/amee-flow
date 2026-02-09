<script type="text/javascript">
  function delete_entry(val) {
    if (val != "") {
      var r = confirm("Are you sure want to delete it!");
      if (r == true) {
        window.location = "<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'accounts/delete/';?>" + val;
      }
    }
  }
</script> 

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
			<div class="box-header no-border">
		  <h3 class="box-title">Create system admin accounts and grant access to AMEE Flow.</h3>
<div class="box-tools pull-right">
				    <a style="padding: 4px 15px;vertical-align:top; margin-left:5px;" href="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'accounts/add';?>" class='btn btn-primary'>Add New</a>
				    </div>
		</div>
				 
					<div class="box-body row">
					
					 
						<div class="col-xs-12 table-responsive">
							<table class="table table-striped" id="table_recordtbl">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th>University Name</th>
										<!-- <th>Login Info.</th>
										<th>Contact Info.</th> -->
										<th>Address</th>
										<th>Status</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody id="append_company_products">
                                <?php $i = 1;
                                     foreach($accountDataArr as $row){?>
                                     <tr>
                                         <td><?php echo $i; ?></td>
                                         <td style="font-weight:600;"><?php echo $row['universityName'];?> 
										 <small><?php echo $row['shortName'];?></small></td>
										 <td> <?php echo $row['email'];
										  echo '<small>P: '. base64_decode($row['randomId']).'</small>';?>  </td>
										  <td>
										 <?php 
										 echo $row['fullName'];
										
										 echo '<small>'.$row['contactNo'].'</small>';
											//  if($row->region>0){
											// 	echo $this->config->item('region_array_config')[$row->region]['name'];
											//  }else{
											// 	echo '&ndash;';
											//  }
										 ?>
										 </td>
										 <td><?php echo $row['address'];
										 echo '<small>'.$row['city'].', '.$this->config->item('usa_states_array_config')[$row['stateId']]['name'].' - '.$row['zipCode'].'</small>';?></td>
										  
                                         <td><?php if($row['isActive'] == 1){?>
				                         	<label class="mstus rejected" style="padding:0px 10px;">In-active</label>
				                         <?php }else{ ?>
				                         	<label class="mstus accepted" style="padding:0px 10px;">Active</label>
				                         <?php } ?></td>
                                         <td nowrap>
											<a class="btn btn-success btn-sm" href="<?php echo $this->config->item('ajax_base_url').$this->config->item('admin_directory_name').'accounts/edit/'.$row['uencryptId'];?>">Edit</a>
											<a onclick="return delete_entry('<?php echo $row['uencryptId']; ?>');" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>
                                         </td>
                                     </tr>
                                     <?php $i++; }?>
                                     </tbody>
							</table>							
						</div>	 
					</div>
		
			</div>
		</div>
	</div>
</section>