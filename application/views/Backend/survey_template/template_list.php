<style>
.pro_name{ color:#333; border-bottom:1px dashed #333; margin-left:5px; font-weight:600;}
.pro_name:hover{ text-decoration:none; border-bottom:1px solid #333;}
.msts{ border:1px dashed; padding:0px 10px;}
.active{ color:green}
.inactive{ color:#FF0000;}
</style>
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/content_tutorials/delete?id='+val;
 		} 
 	}
}
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
      <h3 class="box-title">Survey Templates Listing</h3>
		<div class="box-tools pull-right">
		  <a style="padding: 4px 15px; vertical-align:top; " href="<?php echo base_url();?>admin/survey/template/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Template </a>
		</div>
    </div>

	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-striped " id="table_recordtbl">
			<thead>
				<tr>
					<th width="3%" nowrap="nowrap">#</th>
		            <th nowrap="nowrap">Survey Template</th> 
					<th nowrap="nowrap">Questions</th>
					<th nowrap="nowrap">Status</th>
		            <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			 
			<tbody>
				<?php $i=1; foreach ($default_survey_templates_detail as $survey_templates) { ?>
				<tr>
					<td><?php echo  $i;?></td>
				
					<td style="font-weight:600;"><?php echo $survey_templates->name;?></td>	

					
					<td><?php $surveys_questions_count = get_default_surveys_questions_count_by_survey_template_id($survey_templates->id);
						
						echo '['.$surveys_questions_count.']'; //echo date('d M Y',$row->add_date);?>	
						<a href="<?php echo base_url();?>admin/survey_template?stid=<?php echo $survey_templates->id;?>" class="pro_name">View</a>					
					</td> 
					<td>
						<?php if($survey_templates->status==0){?>
							<label class="active msts">Active</label>
						<?php }else{ ?>
							<label class="inactive msts">Inactive</label>
						<?php } ?>
					</td>
							
									 
					<td style="font-weight:600;">
					
					<a href="<?php echo  base_url();?>admin/survey_template/add?stid=<?php echo $survey_templates->id;?>" class="btn btn-default btn-sm" style="margin-left:10px;"> <i class="fa fa-plus-circle"></i> Question</a> 
					<a href="<?php echo base_url();?>admin/survey_template/edit_template?id=<?php echo $survey_templates->id;?>" class="btn btn-success btn-sm" style="margin-left:10px;"> Edit</a> 
					
					</td>					 
				
					<!--<td nowrap="nowrap">
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $row->id;?>');"> Delete</a>
					</td>-->
				</tr>
				<?php  $i++; } ?> 
			</tbody>		                             
		</table>
	</div>
	</div>
  
</div>
</section>
    