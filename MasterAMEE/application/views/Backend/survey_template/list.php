<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/survey_template/delete?id='+val;
 		} 
 	}
} 
</script> 
<section class="content">
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">Listing</h3>
		<div class="box-tools pull-right">
			<a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/Survey_template/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Template </a>
		</div>
	</div>

	<div class="box-body">
	<div class="col-xs-12 table-responsive">
	<table class="table table-hover " id="table_recordtbl">
		<thead>
		<tr>
			<th width="5%" nowrap="nowrap">S.No</th>
			<th nowrap="nowrap">Template Name</th>
			<th nowrap="nowrap">Total Questions</th> 
			<th nowrap="nowrap">Action</th>
		</tr>
		</thead>
		<tbody>
		<?php $i=1; foreach ($survey_templates_details as $templates_detail) { ?>
			<tr>
				<td><?php echo  $i;?></td>
				
				<td style="font-weight:600; letter-spacing:0.5px;"><?php echo ucwords($templates_detail->name);?></td> 
				
				<td>
					<?php $total_questions = get_count_of_default_surveys_questions($templates_detail->id);?>
					
					<span style="font-size: 17px;font-weight: 600;"><?php echo '('.$total_questions.') '; ?></span>
					<a href="<?php echo base_url();?>admin/survey_template/questions/<?php echo $templates_detail->id;?>">Preview Question</a>					
				</td>
				
				<td>
					<a class="btn btn-primary  btn-sm" href="<?php echo base_url();?>admin/survey_template/add_question/<?php echo $templates_detail->id;?>"> Add Question </a>
					<a href="<?php echo  base_url();?>admin/survey_template/edit/<?php echo $templates_detail->id;?>" class="btn btn-success btn-sm"> Edit</a> 
					<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $templates_detail->id;?>');"> Delete</a>			
				</td>
			</tr>
		<?php  $i++; } ?>          
		</tbody>
	</table>
	</div>
	</div> 
</div>
</section>
    