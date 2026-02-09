<script type="text/javascript">
function delete_entry(val){
 	if(val!="") {
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
 		  window.location = '<?php echo base_url();?>admin/faq/delete?id='+val;
 		} 
 	}
} 
</script> 
<style type="text/css">
.question_header {
    border: 1px solid #dedede;
    border-radius: 4px 4px 0 0;
    padding: 5px 10px;
    background-color: #f9f9f9;
}
.question_header .box-title {
    display: inline-block;
    width: calc(100% - 80px);
}
.question_header h4 a{color:#117e40;}
.acc_action_btns {
    display: inline-block;
    text-align: right;
    width: 70px;
	cursor:pointer;
}

.acc_action_btns a{
    display: inline-block; width:30px; height:30px; line-height:28px; background-color:#fff; border-radius:50%; margin-left:3px; text-align:center;color:#117e40;
}
.acc_action_btns a:hover,.acc_action_btns a:focus{ background-color:#117e40;color:#fff;}
#accordion .panel-collapse {
    border: 1px solid #dedede;
    border-top: none;
    border-radius: 0 0 4px 4px;
}
#accordion .panel {
    margin-bottom: 5px;
    border:none;
    border-radius: none;
}
</style>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
       
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Listing</h3>
			  <div class="box-tools pull-right">
					 
                      <a style="padding: 3px 5px; vertical-align:top; " href="<?php echo base_url();?>admin/faq/add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add New </a>
                    </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="acc_section" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
				
				 <?php if(count($faq_details)>0){ $i=1; foreach ($faq_details as $faq_data) { ?>
				 
                <div class="panel">
                  <div class="question_header">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="false" class="collapsed">
                        <?php echo $faq_data->question;?>
                      </a>
                    </h4>
                    <div class="acc_action_btns"><a href="<?php echo  base_url();?>admin/faq/edit/<?php echo $faq_data->id;?>"><i class="fa fa-pencil"></i></a><a onclick="return delete_entry('<?php echo $faq_data->id;?>');"><i class="fa fa-trash"></i></a></div>
                  </div>
                  <div id="collapse<?php echo $i;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      <?php echo $faq_data->description;?>
                    </div>
                  </div>
                </div>
				
				 <?php  $i++; }} else{ ?>          
				 	<h4 class="box-title" style="font-style:italic;">-- No data available --</h4>
				 <?php } ?>
				 
               <!-- <div class="panel  ">
                  <div class="question_header">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">
                        Collapsible Group Danger
                      </a>
                    </h4>
                    <div class="acc_action_btns"><a href="#"><i class="fa fa-pencil"></i></a><a href="#"><i class="fa fa-trash"></i></a></div>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>
                <div class="panel  ">
                  <div class="question_header">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="" aria-expanded="true">
                        Collapsible Group Success
                      </a>
                    </h4>
                    <div class="acc_action_btns"><a href="#"><i class="fa fa-pencil"></i></a><a href="#"><i class="fa fa-trash"></i></a></div>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true" style="">
                    <div class="box-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                      wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
                      eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
                      assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
                      nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
                      farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
                      labore sustainable VHS.
                    </div>
                  </div>
                </div>-->
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      

        
      <!-- /.box -->
    </section>
    