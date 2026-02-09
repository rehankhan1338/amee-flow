<section class="content">
<div class="row">
<!-- left column -->
<div class="col-md-12" >

<form data-toggle="validator" class="form-horizontal" id="frm" method="post" action="" enctype="multipart/form-data">

<!-- general form elements -->
<div class="box">
	<div class="box-body">
	<div class="col-md-10">
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3"> Name*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="name" name="name" placeholder="Name of Core Competency" value="<?php if(!empty($core_competency_row->name)){echo $core_competency_row->name;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('name'); ?></span>
			</div>
		</div>		
		
		<!--<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">Status*</label>
			<div class="col-sm-9">
				<select class="form-control required" id="status" name="status">
					<option value="1" <?php if(isset($core_competency_row->status) && $core_competency_row->status=='1'){ ?> selected="selected" <?php }?> >Active</option>
					<option value="0" <?php if(isset($core_competency_row->status) && $core_competency_row->status=='0'){ ?> selected="selected" <?php }?> >Deactive</option>
				</select>	
			</div>
		</div>-->
	</div>


	</div> 
  <div class="box-footer">
    <button class="btn btn-primary" type="submit">Submit</button>
  </div>
</div>
</form>
<!--/.col (left) -->
<!-- right column -->


</div>
<!--/.col (right) -->
</div>
      <!-- /.row -->
</section>