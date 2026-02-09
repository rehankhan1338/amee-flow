<section class="content">
	<div class="box no-border">	 	
		<div class="box-body row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped " id="table_recordtbl12">
					<thead>
						<tr>
							<th width="3%">#</th>
							<th>Prompt For</th> 
							<th>API Role</th>
							<th>System Prompt</th> 
							<th>Max Token</th> 
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; foreach ($prompts_listing as $sec) { ?>
						<tr>
							<td><?php echo $i;?></td>
							<td style="font-weight:500;"><?php echo $sec['promptFor'];?></td> 
							<td style="line-height:25px;"><?php echo $sec['msgSystemRole'];?></td> 
							<td style="line-height:25px;"><?php echo $sec['msgUserRole'];?></td> 
							<td style="font-weight:500;"><?php echo $sec['maxTokenCnt'];?></td> 
							<td>
								<a style="font-weight:500;" href="<?php echo base_url().$this->config->item('admin_directory_name').'cms/prompting?id='.$sec['promptId']?>" class="btn btn-primary btn-sm">Edit</a> 
							</td>
						</tr>
						<?php $i++; } ?>          
					</tbody>
				</table>
			</div> 
		</div>
	</div>
</section>