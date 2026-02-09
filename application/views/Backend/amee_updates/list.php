<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/amee/delete?id='+val;
 		} 
 	}
} 
</script> 
<section class="content">

      <!-- Default box -->
       <div class="box">
	    <div class="box-header with-border">
              <h3 class="box-title">Listing</h3>
			  <div class="box-tools pull-right">
					 
                      <a style="padding: 3px 15px; vertical-align:top; " href="<?php echo base_url();?>admin/amee/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
                    </div>
            </div>
                    
          <!-- start body div -->
          <div class="box-body row">
 
    <div class="col-xs-12 table-responsive">
		<table class="table table-striped " id="table_recordtbl">
			<thead>
				<tr>
					<th style="vertical-align:top;" width="3%" nowrap="nowrap">#</th>
                    <th style="vertical-align:top;" >Title</th> 
					<th style="vertical-align:top;" nowrap="nowrap">Published Date</th>
					<th style="vertical-align:top;" >Content</th>
                    <th style="vertical-align:top;" nowrap="nowrap">Action</th>
				</tr>
			</thead>
			<tbody>
       <?php $i=1; foreach ($amee_updates_details as $amee_data) { ?>
                   <tr>
					<td><?php echo  $i;?></td>
					<td style="font-weight:600;"><?php echo $amee_data->title;?></td> 
					<td><?php echo date('m/d/Y',$amee_data->publish_date);?></td> 
					<td><?php echo $amee_data->body_content;?></td> 
					<td>
						<a href="<?php echo  base_url();?>admin/amee/edit/<?php echo $amee_data->id;?>" class="btn btn-success btn-sm" style="margin:3px;"> Edit</a> 
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $amee_data->id;?>');" style="margin:3px;"> Delete</a>
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
    