<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> 

<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
$(function(){ 
    var mamTable = $('#table_recordtbl_mam').DataTable({
        dom: "<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-4'i><'col-sm-12 col-md-4 text-center'l><'col-sm-12 col-md-4'p>>",
        paging: true,
        pageLength: 100,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        scrollX: true,   // enable horizontal scroll
        fixedColumns: {
            leftColumns: 2 // fix first column
        },
        columnDefs: [
            { orderable: false, targets: 0 } // Disable sorting on first column (index 0)
        ],
        drawCallback: function(settings) {
            feather.replace();
        }
    });
    
});
</script>

<section class="content">
 
    <div class="box"> 
        <div class="row">		
            <div class="fs14 mx-2 my-2 col-12"><strong>Note -</strong> If your alignment map appears blank or incomplete, please verify that <strong>all required fields are fully and accurately filled out</strong>. Missing or incomplete data may prevent the system from processing your submission correctly.</div>
        </div>
        <div class="box-header no-border">
        
            <h3 class="box-title">Oversight Units
                <select class="form-control mt-2" onchange="return getOversigntData(this.value);">
                    <option value="">Select...</option>
                    <?php foreach($oversightsDataArr as $osd){?>
                        <option value="<?php echo $osd['oversigntId'];?>" <?php if($seloversigntId==$osd['oversigntId']){?> selected<?php } ?>> <?php echo $osd['unitName'];?> </option>
                    <?php } ?>
                </select>
            </h3>
            <div class="box-tools pull-right">                
                <!-- <button id="downloadCourseBtn" type="button" onclick="return mapInfo();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-info'> Info</button> -->
                <button id="downloadCourseBtn" type="button" onclick="return downloadMap();" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-warning'> Download Excel</button>
                <button id="delProBtn" type="button" onclick="return deleteCourse('<?php echo $seloversigntId;?>');" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
                <button id="emamBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageMam('<?php echo $mamDetailsArr['mamId'];?>');" class='btn btn-primary'> Update Map </button>               
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive" id="mam-table-wrap">
                <table class="table table-striped" id="table_recordtbl_mam">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
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
                            <th>Action</th>
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
                            <td> <input type="checkbox" class="case" id="courseIds[]" name="courseIds[]" value="<?php echo $row['mamCourseId'];?>" /> </td>
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
                            <td nowrap> 
                                <a class="deBtn" id="editBtn<?php echo $row['mamCourseId'];?>" onclick="return manageCourseMAM('<?php echo $row['mamCourseId'];?>','<?php echo $seloversigntId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a> 
                                &nbsp;&nbsp;<a class="deBtn" id="noteBtn<?php echo $row['mamCourseId'];?>" onclick="return viewNote('<?php echo $row['mamCourseId'];?>');"> <i class="icon-sm" data-feather="eye"></i> </a>
                            </td>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
<div class="modal fade" id="popCMAMModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCMAMModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCMAMModelLabel">Update your master alignment map</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCMAMFrm" action="master_alignment_map/manageClassEntry" method="post">
			<div id="resCMAM" class="ajaxFrmRes"></div>
			 <div class="row">	
				<div id="manageCMAMFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popCMAMSaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>
<script>
function downloadMap(){
    $('#downloadCourseBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
    var url = '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/download';?>'; 
    window.location.href = url;
    setTimeout(() => {
        $('#downloadCourseBtn').html('Download');
    }, 3000);
}
function deleteCourse(selceId){
	var n = $(".case:checked").length;
	if(n>=1){
		var r = confirm("Are you sure want to delete it!");
		if (r == true) {
            var new_array=[];
            $(".case:checked").each(function() {
                var n_total=parseInt($(this).val());
                new_array.push(n_total);
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/deleteCourse?courseIds=';?>'+new_array,
                beforeSend: function(){
                    $('#delProBtn').prop("disabled", true);
                    $('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'master-alignment-map?osd=';?>'+selceId;      
                }
            });
        }
	}else{
		alert("Please select at least one course!");
		return false;
	}
}
function manageCourseMAM(mamCourseId,seloversigntId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'master_alignment_map/ajaxCMAMFields?mamCourseId=';?>'+mamCourseId+'&seloversigntId='+seloversigntId,
        beforeSend: function(){
            if(parseInt(mamCourseId)==0){
            }else{
                $('#popCMAMModelLabel').html('Update your master alignment map');
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
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
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
						window.location = site_base_url+'master-alignment-map?osd=<?php echo $seloversigntId;?>';
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
<?php include(APPPATH.'views/system-admin/planning-documents/master-alignment-map/mam-model.php');
include(APPPATH.'views/system-admin/planning-documents/master-alignment-map/notes-modal.php');?>
</section>
