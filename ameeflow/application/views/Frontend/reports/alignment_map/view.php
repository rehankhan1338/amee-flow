<section class="content"> 
    <div class="box <?php if(isset($sharePermission) && $sharePermission==0){ echo 'mt-4';}?>"> 
        
        <div class="box-header no-border ">        
            <h3 class="box-title">Oversight Units
                <select class="form-control mt-2" onchange="return getOversigntData(this.value);">
                    <option value="">Select...</option>
                    <?php foreach($oversightsDataArr as $osd){?>
                        <option value="<?php echo $osd['oversigntId'];?>" <?php if($seloversigntId==$osd['oversigntId']){?> selected<?php } ?>> <?php echo $osd['unitName'];?> </option>
                    <?php } ?>
                </select>
            </h3> 
            <?php if(isset($sharePermission) && $sharePermission==1){?>
            <div class="box-tools pull-right">   
               <button id="feedbackBtn" type="button" style="padding: 3px 25px; margin-right:5px; font-size:15px;" onclick="return viewFeedback('<?php echo $mamDetailsArr['mamId'];?>','<?php echo $sessionDetailsArr['userId'];?>');" class='btn btn-warning'> Feedback <?php //echo $mamDetailsArr['feedbackCnt']; ?> </button>
               <button id="shareReportBtn" type="button" style="padding: 3px 25px; font-size:15px;" onclick="return shareReport('<?php //echo $spDetails['spId'];?>');" class='btn btn-primary'> Share </button>               
            </div>          
            <?php } ?>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%">#</th>
                            <th>Course</th>
                            <?php if($mamDetailsArr['ISLOCnt']>0){ for($is=1;$is<=$mamDetailsArr['ISLOCnt'];$is++){?>
                            <th style="text-align:center;">ISLO<br /><small>(<?php echo $is;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GISLOCnt']>0){ for($gis=1;$gis<=$mamDetailsArr['GISLOCnt'];$gis++){?>
                            <th style="text-align:center;">GISLO<br /><small>(<?php echo $gis;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['PSLOCnt']>0){ for($ps=1;$ps<=$mamDetailsArr['PSLOCnt'];$ps++){?>
                            <th style="text-align:center;">PSLO<br /><small>(<?php echo $ps;?>)</small></th>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GPSLOCnt']>0){ for($gps=1;$gps<=$mamDetailsArr['GPSLOCnt'];$gps++){?>
                            <th style="text-align:center;">GPSLO<br /><small>(<?php echo $gps;?>)</small></th>
                            <?php } } ?>
                            <?php if(isset($sharePermission) && $sharePermission==1){?>
                                <th>Notes</th>
                            <?php } ?>   
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($cousesDataArr as $row){ 
                                
                                if(isset($row['courseISLO']) && $row['courseISLO']!=''){
                                    $courseISLOArr = explode(',',$row['courseISLO']);
                                }else{
                                    $courseISLOArr = array();
                                }
                                
                                if(isset($row['courseGISLO']) && $row['courseGISLO']!=''){
                                    $courseGISLOArr = explode(',',$row['courseGISLO']);
                                }else{
                                    $courseGISLOArr = array();
                                }
                                if(isset($row['coursePSLO']) && $row['coursePSLO']!=''){
                                    $coursePSLOArr = explode(',',$row['coursePSLO']);
                                }else{
                                    $coursePSLOArr = array();
                                }
                                if(isset($row['courseGPSLO']) && $row['courseGPSLO']!=''){
                                    $courseGPSLOArr = explode(',',$row['courseGPSLO']);
                                }else{
                                    $courseGPSLOArr = array();
                                }
                        ?>
                        <tr>
                            <td> <?php echo $i;?> </td>
                            <td nowrap style="font-weight:500;"> <?php echo $row['courseSubject'].'-'.$row['courseNBR']; ?> </td>
                            <?php if($mamDetailsArr['ISLOCnt']>0){ for($is=1;$is<=$mamDetailsArr['ISLOCnt'];$is++){?>
                            <td style="text-align:center;"><?php if(in_array($is,$courseISLOArr)){echo 'Yes';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GISLOCnt']>0){ for($gis=1;$gis<=$mamDetailsArr['GISLOCnt'];$gis++){?>
                            <td style="text-align:center;"><?php if(in_array($gis,$courseGISLOArr)){echo 'Yes';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['PSLOCnt']>0){ for($ps=1;$ps<=$mamDetailsArr['PSLOCnt'];$ps++){?>
                            <td style="text-align:center;"><?php if(in_array($ps,$coursePSLOArr)){echo 'Yes';}?></td>
                            <?php } } ?>
                            <?php if($mamDetailsArr['GPSLOCnt']>0){ for($gps=1;$gps<=$mamDetailsArr['GPSLOCnt'];$gps++){?>
                            <td style="text-align:center;"><?php if(in_array($gps,$courseGPSLOArr)){echo 'Yes';}?></td>
                            <?php } } ?>
                            <?php if(isset($sharePermission) && $sharePermission==1){?>
                                <td> <a class="deBtn" id="editBtn<?php echo $row['mamCourseId'];?>" onclick="return manageNotesAM('<?php echo $row['mamCourseId'];?>','<?php echo $seloversigntId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a> </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
<?php if(isset($sharePermission) && $sharePermission==1){?>
<div class="modal fade" id="popCMAMModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCMAMModelLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCMAMModelLabel"><i class="fa fa-pencil-square-o" style="margin-right:6px;"></i> Update your master alignment map</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding:24px 28px;">
		<form id="popCMAMFrm" action="sampling_plan/saveNotesAM" method="post">
			<div id="resCMAM" class="ajaxFrmRes"></div>
			<div id="manageCMAMFieldSec"></div>
		</form>
      </div>      
    </div>
  </div>
</div>
<script> 
function manageNotesAM(mamCourseId,seloversigntId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'sampling_plan/ajaxAMnotesField?mamCourseId=';?>'+mamCourseId+'&seloversigntId='+seloversigntId,
        beforeSend: function(){
            if(parseInt(mamCourseId)==0){
            }else{
                $('#popCMAMModelLabel').html('Add your note');
                $('#editBtn'+mamCourseId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageCMAMFieldSec').html(result);
            $('#popCMAMModel').modal('show');
            if(parseInt(mamCourseId)==0){
            }else{              
                $('#editBtn'+mamCourseId).html('<i class="icon-sm" data-feather="edit"></i>');
                feather.replace();
            }
        }
    });	    
}
$(document).ready(function () {
	$('#popCMAMFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popCMAMSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#popCMAMFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popCMAMFrm').get(0));
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#popCMAMSaveBtn').prop("disabled", true);
					$('#popCMAMSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#resCMAM').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popCMAMSaveBtn').prop("disabled", false);
						$('#popCMAMSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script> 
<?php } ?>
<script> 
function getOversigntData(val){
	if(val!=''){
        <?php if(isset($sharePermission) && $sharePermission==1){?>
		window.location = '<?php echo base_url().'sampling_plan/alignment_map?osd=';?>'+val;
        <?php }else{ ?>
        window.location = '<?php echo base_url().'share/alignment_map/'.$enwithShareId.'?osd=';?>'+val;
        <?php } ?>
	}
}
</script>

<?php if(isset($sharePermission) && $sharePermission==1){
    include(APPPATH.'views/Frontend/reports/alignment_map/share-modal.php');
    include(APPPATH.'views/Frontend/reports/alignment_map/feedback-modal.php');
 }
?>

</section>