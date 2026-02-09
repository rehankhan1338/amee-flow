<section class="content">


    <div class="box">  
        
        <div class="box-header no-border">

        

            <h3 class="box-title" style="font-size:15px; font-weight:500">Term - Year
                <select class="form-control mt-2" onchange="return getCourseEnrollData(this.value);">
                    <option value="">Select...</option>
                    <?php foreach($courseEnrollmentDataArr as $course){?>
                        <option value="<?php echo $course['ceId'];?>" <?php if($selceId==$course['ceId']){?> selected<?php } ?>> <?php echo $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year']; ?> </option>
                    <?php } ?>
                </select>
            </h3>
            <div class="box-tools pull-right">                
            <button id="delProBtn" type="button" onclick="return deleteClass('<?php echo $selceId;?>');" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class='btn btn-danger'> Delete </button>
            <!-- <button id="emamBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return manageMam('<?php //echo $mamDetailsArr['ceId'];?>');" class='btn btn-primary'> Update Map </button>                -->
            </div>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl1">
                    <thead>
                        <tr>
                            <th width="1%"><input type="checkbox" id="selectall"></th>
                            <th>Subject</th>
                            <th>Course #</th>
                            <th>Class #</th>
                            <th>Sec. #</th>
                            <th>Title</th>
                            <th>Enroll.</th>
                            <th>Faculty</th>
                            <th>Dept. Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($classesDataArr as $row){
                        ?>
                        <tr>
                            <td> <input type="checkbox" class="case" id="classIds[]" name="classIds[]" value="<?php echo $row['ceClassId'];?>" /> </td>
                            <td> <?php  echo $row['subject'];?> </td>
                            <td> <?php  echo $row['courseNBR'];?> </td>
                            <td> <?php  echo $row['classNBR'];?> </td>
                            <td> <?php  echo $row['sectionNo'];?> </td>
                            <td> <?php  echo $row['courseTitle'];?> </td>
                            <td> <?php  echo $row['enrolled'];?> </td>
                            <td> <?php 
                            $deptName = '';
                            if($row['ceFacultyId']>0){ 
                               $resFac = filter_array($facultyDataArr,$row['ceFacultyId'],'ceFacultyId');
                               if(count($resFac)>0){
                                    echo $resFac[0]['lastName'].', '.$resFac[0]['firstName'];
                                    $deptName = $resFac[0]['deptName'];
                               }
                            }
                            ?></td>
                            <td> <?php echo $deptName;?></td>
                            <td> <a class="deBtn" id="editCCEBtn<?php echo $row['ceClassId'];?>" onclick="return manageCCE('<?php echo $row['ceClassId'];?>','<?php echo $selceId;?>');"> <i class="icon-sm" data-feather="edit"></i> </a> </td>
                        </tr>
                        <?php $i++; }?>
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
<script>
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
function manageCCE(ceClassId,selceId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/ajaxCCEFields?ceClassId=';?>'+ceClassId+'&selceId='+selceId,
        beforeSend: function(){
            if(parseInt(ceClassId)==0){
            }else{
                $('#popCCEModelLabel').html('Upload your schedule of courses (SOC)');
                $('#editCCEBtn'+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');
            }
        },
        success: function(result, status, xhr){
            $('#manageCCEFieldSec').html(result);
            $('#popCCEModel').modal('show');
            if(parseInt(ceClassId)==0){
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
</section>