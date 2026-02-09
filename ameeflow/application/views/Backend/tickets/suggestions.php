<style>
.table small {display: block;margin-left: 5px; font-size: 90%;margin-top: 2px;}
</style>

<section class="content">
	 <div class="box no-border">
		<div class="box-body row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped" id="table_recordtbl">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th>Sugg. From</th>
							<th>Given Sugg. Msg</th>
							<th>Satisfied Sts.</th>
							<th>Contact Back</th>
							<th>Given Date</th> 
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if(count($suggestionsList)>0){ $i=1;foreach($suggestionsList as $row){ ?>
							<tr>
								<td><?php echo $i;?></td>
								<td style="font-weight:600;"><?php echo $row->fullName;?> <small><?php echo $row->email;?></small></td>
								<td><?php echo $row->givenSuggestionMsg;?></td>
								<td><?php echo $this->config->item('suggestion_box_satisfied_options_array_config')[$row->satisfiedOptionId]['name'];?></td>
								<td><?php if($row->contactMeSts==1){?>
									<label class="mstus accepted">Yes</label>
									<?php }else{ ?>
									<label class="mstus rejected">No</label>
									<?php } ?></td>
								<td><?php echo date('m/d/Y, h:i A',$row->createdOn);?></td>
								
								<td class="action_icons">
									<a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?');" href="<?php echo base_url();?>admin/tickets/delete_suggestion?id=<?php echo $row->suggestionId;?>" ><i class="fa fa-trash"></i></a></td>
							</tr>
						<?php $i++;} } ?>
					</tbody>
				</table>
			</div> 
		</div>
	</div>
</section>  