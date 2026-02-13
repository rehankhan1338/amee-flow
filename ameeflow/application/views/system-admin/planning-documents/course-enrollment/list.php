<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> 

<section class="content">
    <div class="box">          
        <div class="box-header no-border">
            <h3 class="box-title" style="font-size:15px; font-weight:500">Oversight Units</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="ceSearchInput" placeholder="Search courses..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="ceClearSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
                <!-- Term/Year Selector -->
                <div class="af-select-filter-wrap" id="afCeTermWrap">
                    <span class="af-select-filter-btn" id="afCeTermBtn" role="button">
                        <i class="fa fa-calendar"></i>
                        <span class="af-select-filter-label"><?php 
                            $selectedLabel = 'Select Term-Year';
                            foreach($courseEnrollmentDataArr as $course){
                                if($selceId==$course['ceId']){
                                    $selectedLabel = $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year'];
                                }
                            }
                            echo $selectedLabel;
                        ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afCeTermDropdown">
                        <a href="#" class="af-select-filter-option" data-value="">Select...</a>
                        <?php foreach($courseEnrollmentDataArr as $course){?>
                        <a href="#" class="af-select-filter-option <?php if($selceId==$course['ceId']){?> selected<?php } ?>" data-value="<?php echo $course['ceId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year']; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="af-roles-toolbar-right" style="flex-wrap:wrap; gap:6px;">
                <button id="recognitionFlowBtn" type="button" onclick="return addIntoRecognitionFlow('<?php echo $selceId;?>');" class='btn btn-secondary btn-sm' style="border-radius:22px; padding:6px 14px; font-size:13px;"> <i class="fa fa-random"></i> Recognition Flow </button>
                <a href="<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/create'; ?>" class="btn btn-info btn-sm" style="border-radius:22px; padding:6px 14px; font-size:13px;"> <i class="fa fa-plus"></i> New SOC</a>
                <button id="downloadCourseBtn" type="button" onclick="return downloadCourse('<?php echo $selceId;?>');" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 14px; font-size:13px;"> <i class="fa fa-download"></i> Download </button>
                <button id="delProBtn" type="button" onclick="return deleteClass('<?php echo $selceId;?>');" class='btn btn-danger btn-sm' style="border-radius:22px; padding:6px 14px; font-size:13px;"> <i class="fa fa-trash"></i> Delete </button>
                <button id="addSocBtn" type="button" onclick="return manageCCE('0','<?php echo $selceId;?>');" class='btn btn-primary btn-sm' style="border-radius:22px; padding:6px 14px; font-size:13px;"> <i class="fa fa-plus"></i> Add Course </button>
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
                            <th>Course</th>
                            <th>Class/Sec.</th>
                            <th>Enroll.</th>
                            <th>Faculty</th>
                            <th>Dept. Name</th>
                            <th>Modality</th>
                            <th>Level</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php 
                        if(count($classesDataArr) > 0){
                            $i = 1;
                            foreach($classesDataArr as $row){
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="classIds[]" name="classIds[]" value="<?php echo $row['ceClassId'];?>" /> </td>
                            <td> <?php if($row['addedBy']==1){echo '<i class="fa fa-star"></i> ';}echo $row['subject'].'-'.$row['courseNBR'];?> <small><?php  echo $row['courseTitle'];?></small></td>
                            <td> <?php  echo $row['classNBR'].' ('.$row['sectionNo'].')';?> </td>
                            <td> <?php  echo $row['enrolled'];?> </td>
                            <td> <?php echo $row['lastName'];
                            if(isset($row['firstName']) && $row['firstName']!=''){ echo ', '.$row['firstName'];}?> <small><?php  echo $row['facultyEmail'];?></small> </td>
                            <td> <?php echo $row['deptName'];?></td>
                            <td> <?php echo $row['courseModality'];?></td>
                            <td> <?php echo $row['courseLevel'];?></td>
                            <td> <?php echo $row['courseType'];?></td>
                            <td nowrap> 
                                <a class="btn btn-primary btn-sm" id="editCCEBtn<?php echo $row['ceClassId'];?>" onclick="return manageCCE('<?php echo $row['ceClassId'];?>','<?php echo $selceId;?>');"> Edit </a>
                                <a class="btn btn-danger btn-sm" id="delclass<?php echo $row['ceClassId'];?>" onclick="return deleteSingleClass('<?php echo $row['ceClassId'];?>','<?php echo $selceId;?>');" style="margin-left:3px;"><i class="fa fa-trash"></i></a>
                                <?php if(isset($row['comment']) && $row['comment']!=''){?> <span data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row['comment'];?>" > <i class="icon-sm mx-2" data-feather="info"></i> </span> <?php } ?>
                            </td>
                        </tr>
                        <?php $i++; }
                        } else { ?>
                        <tr class="no-data-row">
                            <td colspan="10" class="text-center py-5">
                                <div class="no-data-message">
                                    <i class="fa fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                                    <p style="font-size: 1.1rem; color: #999; margin: 0; font-weight: 500;">No data found</p>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
 
<div class="modal fade" id="popCCEModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="popCCEModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">	
      <div class="modal-header">
        <h5 class="modal-title" id="popCCEModelLabel">Update your schedule of courses (SOC)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
		<form id="popCCEFrm" action="course_enrollment/manageClassEntry" method="post">
			<div id="resCCE" class="ajaxFrmRes"></div>
			 <div class="row">	
				<div id="manageCCEFieldSec"></div>				 
				<div class="col-12 mt-2">
					<button type="submit" id="popCCESaveBtn" class="btn btn-primary" style="padding:5px 50px;">Save</button>
				</div>
			 </div>
		 </form>		 
      </div>      
    </div>
  </div>
</div>

<input type="hidden" id="txtprojectManagerName" name="txtprojectManagerName" value="<?php echo $sessionDetailsArr['fullName'];?>" />
<input type="hidden" id="txtunitName" name="txtunitName" value="<?php echo $sessionDetailsArr['unitName'];?>" />
<input type="hidden" id="txtuniversityName" name="txtuniversityName" value="<?php echo $sessionDetailsArr['universityName'];?>" />

<script>
function downloadCourse(selceId){
    $('#downloadCourseBtn').html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
    var url = '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/download?ceId=';?>'+selceId; 
    window.location.href = url;
    setTimeout(() => {
        $('#downloadCourseBtn').html('Download');
    }, 3000);
}
function addIntoRecognitionFlow(selceId){
	var n = $(".case:checked").length;
	if(n>=1){
        var r = confirm("Are you sure want to add it!");
		if (r == true) {
            var new_array=[];
            $(".case:checked").each(function() {
                var n_total=parseInt($(this).val());
                new_array.push(n_total);
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/addIntoRecognitionFlow?classIds=';?>'+new_array+'&ceId='+selceId,
                data: {
                    proManagerName: $('#txtprojectManagerName').val(),
                    unitName: $('#txtunitName').val(),
                    universityName: $('#txtuniversityName').val()
                },
                beforeSend: function(){
                    $('#recognitionFlowBtn').prop("disabled", true);
                    $('#recognitionFlowBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'course-enrollment?ced=';?>'+selceId;      
                }
            });
        }
	}else{
		alert("Please select at least one course!");
		return false;
	}
}
function deleteClass(selceId){
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
                url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/deleteClass?classIds=';?>'+new_array,
                beforeSend: function(){
                    $('#delProBtn').prop("disabled", true);
                    $('#delProBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'course-enrollment?ced=';?>'+selceId;      
                }
            });
        }
	}else{
		alert("Please select at least one course!");
		return false;
	}
}
function deleteSingleClass(ceClassId, selceId){
	var r = confirm("Are you sure you want to delete this course?");
	if (r == true) {
		$.ajax({
			type: "POST",
			url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/deleteClass?classIds=';?>'+ceClassId,
			beforeSend: function(){
				$('#delclass'+ceClassId).prop("disabled", true);
				$('#delclass'+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result, status, xhr){
				window.location = '<?php echo base_url().$this->config->item('system_directory_name').'course-enrollment?ced=';?>'+selceId;
			}
		});
	}
}
function manageCCE(ceClassId,selceId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/ajaxCCEFields?ceClassId=';?>'+ceClassId+'&selceId='+selceId,
        beforeSend: function(){
            if(parseInt(ceClassId)==0){
                $('#addSocBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                $('#popCCEModelLabel').html('Add Course'); 
            }else{
                $('#popCCEModelLabel').html('Edit Course');
                $('#editCCEBtn'+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageCCEFieldSec').html(result);
            $('#popCCEModel').modal('show');
            if(parseInt(ceClassId)==0){
                $('#addSocBtn').html('Add New Course');
            }else{              
                $('#editCCEBtn'+ceClassId).html('<i class="icon-sm" data-feather="edit"></i>');
                feather.replace();
            }
        }
    });	    
}
$(document).ready(function () {
	$('#popCCEFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#popCCESaveBtn').html();
			var site_base_url = '<?php echo base_url().$this->config->item('system_directory_name');?>';
			var form = $('#popCCEFrm');
			var url = site_base_url+form.attr('action');
			var formData = new FormData($('#popCCEFrm').get(0));
			$.ajax({
				type: "POST",
				url: url,
				enctype: 'multipart/form-data',
				data: formData,
				processData: false,
				contentType: false,
				beforeSend: function(){
					$('#popCCESaveBtn').prop("disabled", true);
					$('#popCCESaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){//alert(result);
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = site_base_url+'course-enrollment?ced=<?php echo $selceId;?>';
					}else{
						// displayToaster(result_arr[0], result_arr[1]);
						$('#resCCE').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');
						$('#popCCESaveBtn').prop("disabled", false);
						$('#popCCESaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>
<?php include(APPPATH.'views/system-admin/planning-documents/course-enrollment/ce-model.php');?>
<script>
$(function(){
    /* Search */
    $('#ceSearchInput').on('input', function(){
        var v = $(this).val().toLowerCase();
        if(v.length > 0){ $('#ceClearSearch').css('display','flex'); } else { $('#ceClearSearch').hide(); }
        $('#table_recordtbl tbody tr').not('.no-data-row').each(function(){
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(v === '' || rowText.indexOf(v) > -1);
        });
    });
    $('#ceClearSearch').on('click', function(){
        $('#ceSearchInput').val('');
        $(this).hide();
        $('#table_recordtbl tbody tr').not('.no-data-row').show();
    });

    /* Term/Year dropdown */
    $('#afCeTermBtn').on('click', function(e){
        e.stopPropagation();
        $('#afCeTermDropdown').toggleClass('show');
    });
    $('#afCeTermDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        if(val && val !== ''){
            getCourseEnrollData(val);
        }
        $('#afCeTermDropdown').removeClass('show');
    });
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afCeTermWrap').length){ $('#afCeTermDropdown').removeClass('show'); }
    });
});
</script>
</section>