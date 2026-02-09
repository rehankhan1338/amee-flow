<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/university/delete?id='+val;
 		} 
 	}
} 
</script> 

<section class="content">
<div class="box">
	<div class="box-header with-border">
	    <h3 class="box-title" style="display: inline-block;">Question List</h3>           
		<div class="box-tools pull-right">
		  <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/survey_template/add?stid=<?php if(isset($_GET['stid'])&& $_GET['stid']!=''){echo $_GET['stid'];}?>" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Question </a>
		</div>
    </div>
            
  <!-- start body div -->
	<div class="box-body row">
	<div class="col-xs-12 table-responsive">
		<table class="table table-hover table-striped" style="font-size:15px; margin-top:15px;">		 
			 
			<tbody>
				<?php $i=1; foreach ($default_survey_questions_details as $questions_details) { ?>
				<tr> 
				
					<td style="padding:10px;">
					<?php if(isset($questions_details->question_title) && $questions_details->question_title!=''){
						echo 'Q'.$i.'. '.ucfirst($questions_details->question_title);}?>
						<b style="font-weight:600;">
							<?php if($questions_details->question_type==1){ echo ' (Multiple Choice)';}?>
							<?php if($questions_details->question_type==2){ echo ' (Matrix Table)';}?>
							<?php if($questions_details->question_type==3){ echo ' (Text Area)';}?>
							<?php if($questions_details->question_type==4){ echo ' (Net Promoter Score)';}?>
						</b>
					 	<div class="pull-right">
						<a href="<?php echo base_url();?>admin/survey_template/edit?question_id=<?php echo $questions_details->question_id;?>&survey_id=<?php if(isset($_GET['stid'])&& $_GET['stid']!=''){echo $_GET['stid'];}?>" style="font-size:16px;color:#3c763d;"><i class="fa fa-pencil"></i></a>
						<a  href="<?php echo base_url();?>admin/survey_template/delete_default_survey_question?question_id=<?php echo $questions_details->question_id;?>&survey_id=<?php if(isset($_GET['stid'])&& $_GET['stid']!=''){echo $_GET['stid'];}?>" onclick="return confirm('Are you sure you want to delete this question?');" style="font-size:16px;color:#a94442; margin-left:20px;"><i class="fa fa-trash"></i></a>
						</div>
					</td>
				</tr>
				<?php  $i++; } ?>          

			</tbody>
		                              
		</table>

	</div>

</div>


</div>
</section>