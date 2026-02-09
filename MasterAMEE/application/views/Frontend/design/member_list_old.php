<style>
.contentwrapper p {
    margin: 10px 0;
}
</style>
<blockquote class="bq2 marginbottom0">
						
	 You are half way there!
	 <p> 

You&#8242;ve successfully completed your Alignment Matrix. </p> The third step in the assessment process is to design your rotation plan and create your assessment teams. 
	<span class="bq2_end"></span>
</blockquote>
 
<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>members/delete='+val;
 		} 
 	}
} 
</script> 

<div class="box">
<?php $i=1; foreach ($team_members_detail_group_by as $row) { ?>
<div class="col-md-3" style="border:1px solid #ddd;padding: 20px 20px; margin:10px;">

	 
			<div class="contenttitle2 nomargintop" style="margin-bottom:10px">
				<h3>Team <?php if(isset($row->team_id)&& $row->team_id!=''){echo $row->team_id;}?></h3>
				
				<!--<a href="<?php echo  base_url();?>members/edit/<?php echo $row->team_id;?>" class="btn btn-default btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
					   	<a class="btn btn-danger btn-sm"  href="<?php echo  base_url();?>members/delete/<?php echo $row->team_id;?>" onclick="return confirm('Are you sure you want to Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>-->
			</div><a href="<?php echo  base_url();?>members/edit/<?php echo $row->team_id;?>" class="btn btn-default btn-xs pull-right">Manage</a>
			<?php $j=1; $member_names_detail = get_member_names_result_by_id($row->team_id);
			foreach($member_names_detail as $members_name){
			 ?>
			<p><?php echo $j;?>. <?php if(isset($members_name->name)&& $members_name->name!=''){echo $members_name->name;}?> <!--&nbsp;<span><a href="<?php echo  base_url();?>members/edit/<?php echo $members_name->id;?>" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a></span>
								&nbsp;<span><a class="btn btn-danger btn-sm"  href="<?php echo  base_url();?>members/delete/<?php echo $members_name->id;?>" onclick="return confirm('Are you sure you want to Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span>--></p>
			<?php $j++;} ?>
	 
	
</div>
<?php  $i++; } ?>
</div> 