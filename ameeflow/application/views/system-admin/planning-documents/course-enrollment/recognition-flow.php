<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> 
<script>
function resendCertificate(selceId){
	var n = $(".case:checked").length;
	if(n>=1){
        var r = confirm("Are you sure want to resend it!");
		if (r == true) {
            var new_array=[];
            $(".case:checked").each(function() {
                var n_total=parseInt($(this).val());
                new_array.push(n_total);
            });
            $.ajax({
                type: "POST",
                url: '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/resendCertificate?rfIds=';?>'+new_array,
                data: {
                    proManagerName: $('#txtprojectManagerName').val(),
                    unitName: $('#txtunitName').val(),
                    universityName: $('#txtuniversityName').val()
                },
                beforeSend: function(){
                    $('#resendCertBtn').prop("disabled", true);
                    $('#resendCertBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result, status, xhr){
                    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/recognitionFlow?ced=';?>'+selceId;      
                }
            });
        }
	}else{
		alert("Please select at least one faculty!");
		return false;
	}
}
function getCourseEnrollData(val){
	if(val!=''){
        <?php if($pageCallFrom==1){?>
		    window.location = '<?php echo base_url().$this->config->item('system_directory_name').'course_enrollment/recognitionFlow?ced=';?>'+val;
        <?php }else{?>
            window.location = '<?php echo base_url().'recognition_flow/assessment_participants?ced=';?>'+val;
        <?php } ?>
	}
}
</script>
<?php if($pageCallFrom==1){?>
<input type="hidden" id="txtprojectManagerName" name="txtprojectManagerName" value="<?php echo $sessionDetailsArr['fullName'];?>" />
<input type="hidden" id="txtunitName" name="txtunitName" value="<?php echo $sessionDetailsArr['unitName'];?>" />
<input type="hidden" id="txtuniversityName" name="txtuniversityName" value="<?php echo $sessionDetailsArr['universityName'];?>" />
<?php } ?>
<section class="content">
    <div class="box">          
        <div class="box-header no-border">
            <h3 class="box-title" style="font-size:15px; font-weight:500">Recognition Flow</h3>
        </div>
        <!-- Modern Toolbar -->
        <div class="af-roles-toolbar">
            <div class="af-roles-toolbar-left">
                <div class="af-roles-search-wrap">
                    <span class="af-roles-search-icon"><i class="fa fa-search"></i></span>
                    <input type="text" class="af-roles-search-input" id="rfSearchInput" placeholder="Search faculty..." autocomplete="off" />
                    <button class="af-roles-search-clear" id="rfClearSearch" type="button"><i class="fa fa-times"></i></button>
                </div>
                <!-- Term/Year Selector -->
                <div class="af-select-filter-wrap" id="afRfTermWrap">
                    <span class="af-select-filter-btn" id="afRfTermBtn" role="button">
                        <i class="fa fa-calendar"></i>
                        <span class="af-select-filter-label"><?php 
                            $rfLabel = 'Select Term-Year';
                            foreach($courseEnrollmentDataArr as $course){
                                if($selceId==$course['ceId']){
                                    $rfLabel = $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year'];
                                }
                            }
                            echo $rfLabel;
                        ?></span>
                        <i class="fa fa-chevron-down" style="font-size:.6rem;"></i>
                    </span>
                    <div class="af-select-filter-dropdown" id="afRfTermDropdown">
                        <a href="#" class="af-select-filter-option" data-value="">Select...</a>
                        <?php foreach($courseEnrollmentDataArr as $course){?>
                        <a href="#" class="af-select-filter-option <?php if($selceId==$course['ceId']){?> selected<?php } ?>" data-value="<?php echo $course['ceId'];?>"><?php echo $this->config->item('terms_assessment_array_config')[$course['termId']]['name'].' - '.$course['year']; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if($pageCallFrom==1){?>
            <div class="af-roles-toolbar-right" style="flex-wrap:wrap; gap:6px;">
                <button id="resendCertBtn" type="button" onclick="return resendCertificate('<?php echo $selceId;?>');" class='btn btn-warning btn-sm' style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-envelope"></i> Resend Certificate </button>
                <button type="button" class="btn btn-primary btn-sm" id="addCeBtn" onclick="return uploadNewTermFaculty();" style="border-radius:22px; padding:6px 16px; font-size:13px;"> <i class="fa fa-upload"></i> Upload Faculty </button>
            </div>
            <?php } ?>
        </div>
       
        <div class="box-body row">					 
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="table_recordtbl">
                    <thead>
                        <tr>
                            <th width="1%"> <?php if($pageCallFrom==1){?> <input type="checkbox" id="selectall"> <?php }else{echo '#';}?></th>
                            <th>Faculty </th>
                            <th>Department Name</th>
                            <th>Course(s) Assessed</th>
                            <th>Sections</th>
                            <?php if($pageCallFrom==1){?>
                            <th>Last Updated</th>
                            <th>Certificate</th>
                            <th>Letter</th>
                            <th>Email Sent</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="append_company_products">
                        <?php $i = 1;
                            foreach($recognitionFlowDataArr as $row){
                        ?>
                        <tr>
                            <td> <?php if($pageCallFrom==1){?><input type="checkbox" class="case" id="rfIds[]" name="rfIds[]" value="<?php echo $row['rfId'];?>" /> <?php }else{echo $i;} ?> </td>
                            <td> <?php echo $row['facultyName'];?> <small><?php echo $row['facultyEmail'];?></small></td>
                            <td> <?php echo $row['deptName'];?> </td> 
                            <td> <?php echo $row['courseAssessed'];?> </td> 
                            <td> <?php echo $row['nofSections'];?> </td>  
                            <?php if($pageCallFrom==1){?>                          
                            <td> <?php if(isset($row['lastUpdatedOn']) && $row['lastUpdatedOn']!='' && $row['lastUpdatedOn']>0){
                                echo date('m/d/Y',$row['lastUpdatedOn']).'<small>'.date('h:i A',$row['lastUpdatedOn']).'</small>';
                            }
                            ?> </td>
                            <td> 
                                <a class="pro_name" target="_blank" href="<?php echo base_url().'recognition_flow/certificate/'.$row['encryptId'];?>"> View </a>                                 
                            </td>
                            <td> 
                                <a class="pro_name" target="_blank" href="<?php echo base_url().'recognition_flow/pdf/'.$row['encryptId'];?>"> View </a>                                 
                            </td>
                            <td> <?php echo $row['emailSentCnt'];?> </td>
                            <?php } ?>
                        </tr>
                        <?php $i++; }?>
                    </tbody>
                </table>							
            </div>	 
        </div>
    </div>
</section>

<script>
$(function(){
    /* Search */
    $('#rfSearchInput').on('input', function(){
        var v = $(this).val().toLowerCase();
        if(v.length > 0){ $('#rfClearSearch').css('display','flex'); } else { $('#rfClearSearch').hide(); }
        $('#table_recordtbl tbody tr').each(function(){
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(v === '' || rowText.indexOf(v) > -1);
        });
    });
    $('#rfClearSearch').on('click', function(){
        $('#rfSearchInput').val('');
        $(this).hide();
        $('#table_recordtbl tbody tr').show();
    });
    /* Term dropdown */
    $('#afRfTermBtn').on('click', function(e){
        e.stopPropagation();
        $('#afRfTermDropdown').toggleClass('show');
    });
    $('#afRfTermDropdown .af-select-filter-option').on('click', function(e){
        e.preventDefault(); e.stopPropagation();
        var val = $(this).data('value');
        if(val && val !== ''){ getCourseEnrollData(val); }
        $('#afRfTermDropdown').removeClass('show');
    });
    $(document).on('click', function(e){
        if(!$(e.target).closest('#afRfTermWrap').length){ $('#afRfTermDropdown').removeClass('show'); }
    });
});
</script>
<?php include(APPPATH.'views/system-admin/planning-documents/course-enrollment/recognition-flow-model.php');?>