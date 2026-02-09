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
			<label class="col-sm-3 control-label" for="inputEmail3">Title*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="txt_title" name="txt_title" placeholder="First Name" value="<?php if(!empty($tutorials_detail_row->txt_title)){echo $tutorials_detail_row->txt_title;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('txt_title'); ?></span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label" for="inputEmail3">You-tube Link*</label>
			<div class="col-sm-9">
				<input type="text" class="form-control required" id="txt_link" name="txt_link" placeholder="You-tube Link" value="<?php if(!empty($tutorials_detail_row->txt_link)){echo $tutorials_detail_row->txt_link;}else{echo '';} ?>"  >
				<span style="color:red;"><?php echo form_error('txt_link'); ?></span>
			</div>
		</div>
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