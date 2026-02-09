<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/category/delete?id='+val;
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
					 
                      <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/category/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
                    </div>
            </div>
                    
          <!-- start body div -->
          <div class="box-body">
 
    <div class="col-xs-12 table-responsive">
		<table class="table table-hover " id="table_recordtbl">
			<thead>
				<tr>
					<th width="5%" nowrap="nowrap">S.No</th>
                    <th nowrap="nowrap">Name</th> 
                    <th nowrap="nowrap">Action</th>
				</tr>
			</thead>
			<tbody>
       <?php $i=1; foreach ($category_details as $category_data) { ?>
                   <tr>
                	<td><?php echo  $i;?></td>
                    <td style="font-weight:600;"><?php echo $category_data->name;?></td> 
                      
                    <td>
                        <a href="<?php echo  base_url();?>admin/category/edit/<?php echo $category_data->id;?>" class="btn btn-success btn-sm"> Edit</a> 
						<a class="btn btn-danger btn-sm" onclick="return delete_entry('<?php echo $category_data->id;?>');"> Delete</a>
                       
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
    