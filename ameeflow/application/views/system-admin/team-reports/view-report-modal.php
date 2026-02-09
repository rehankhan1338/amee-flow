<div class="modal fade" id="viewReportModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="viewReportModelLabel" aria-hidden="true">

  <div class="modal-dialog modal-xl">     

    <div class="modal-content">	

      <div class="modal-header" id="viewReportHeadModel">

        <h5 class="modal-title fs18" id="viewReportModelLabel"><?php echo $this->config->item('share_report_for_array_config')[$shareReportFor]['name'];?></h5>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>

      <div class="modal-body" style="padding:5px 30px;">
        <button id="download-pdf" class="btn btn-secondary" style="padding: 3px 15px; font-size:15px; float:right; margin-top:15px;"> <i class="fa fa-download"></i> Download</button>		  
        <div id="viewReportRes"></div> 

      </div>      

    </div>

  </div>

</div>

<script>

function viewCompleteReport(chkId,chkenId,userId,reportFor){

    $.ajax({

        type: "POST",

        url: '<?php echo base_url().'home/ajaxSPreport?chkId=';?>'+chkId+'&chkenId='+chkenId+'&userId='+userId+'&reportFor='+reportFor,

        beforeSend: function(){

            $('#vrpt'+chkId).addClass('fa-spinner fa-spin');

            $('#vrpt'+chkId).removeClass('fa-info-circle');

        },

        success: function(result, status, xhr){

            $('#viewReportRes').html(result);

            $('#viewReportModel').modal('show');              

            $('#vrpt'+chkId).removeClass('fa-spinner fa-spin');

            $('#vrpt'+chkId).addClass('fa-info-circle');

        }

    });

}

</script>