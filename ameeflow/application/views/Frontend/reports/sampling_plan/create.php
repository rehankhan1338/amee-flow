<section class="content">
    
<div class="box alignCoursePage">
    <div class="box-header no-border">
        <h3 class="box-title">Term/Year: &nbsp; <?php echo $this->config->item('terms_assessment_array_config')[$spDetails['termId']]['name'].' - '.$spDetails['year'];?></h3>
        <div class="box-tools pull-right">
            <a href="<?php echo base_url().'sampling_plan';?>" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class="btn btn-info"> Back</a>
            <button id="addSocBtn" type="button" style="margin-right:5px;padding: 3px 15px; font-size:15px;" onclick="return manageCCE('0','<?php echo $ceId;?>');" class='btn btn-primary'> Add New Course </button>               
            <a href="<?php echo base_url().'sampling_plan/outcomes/'.$spDetails['speId'];?>" style="margin-right:5px;padding: 3px 15px; font-size:15px;" class="btn btn-warning"> Update Outcomes </a>            
            <button id="saveSPBtn" type="button" style="padding: 3px 15px; font-size:15px;" onclick="return saveSamplingPlan('<?php echo $spDetails['speId'];?>','<?php echo $spDetails['spId'];?>');" class="btn btn-primary"> Save</button>
        </div>
        
    </div>

    <table class="table table-striped" style="width:35%">
        <tbody>
            <tr>
                <td class="fw600" style="padding:5px 10px; vertical-align:middle;"><i style="color:#00A1C9; font-size:18px;" class="fa fa-book" aria-hidden="true"></i> &nbsp;&nbsp;Courses Selected</td>
                <td style="padding:5px 10px;vertical-align:middle;"><span style="font-size:18px; font-weight:600;" id="selectIsoCnt"><?php if(isset($selectedCourseForIsoDetails['courses_selected_sp']) && $selectedCourseForIsoDetails['courses_selected_sp']!=''){echo $selectedCourseForIsoDetails['courses_selected_sp'];}else{echo '0';}?></span></td>
            </tr>
            <tr>
                <td style="padding:5px 10px;vertical-align:middle;" class="fw600"><i style="color:#008000; font-size:18px;" class="fa fa-users" aria-hidden="true"></i> &nbsp;&nbsp;Total Students Enrolled</td>
                <td style="padding:5px 10px;vertical-align:middle;"> <span style="font-size:18px; font-weight:600;" id="selTotalEnroll"><?php if(isset($selectedCourseForIsoDetails['courses_selected_enrolled_sp']) && $selectedCourseForIsoDetails['courses_selected_enrolled_sp']!=''){echo $selectedCourseForIsoDetails['courses_selected_enrolled_sp'];}else{echo '0';}?></span>  </td>
            </tr>
        </tbody>
    </table>
<?php
$defacultTabSts = 1;
if(isset($spDetails['alignISLO']) && $spDetails['alignISLO']!=''){
    $defacultTabSts = 1;
}else if(isset($spDetails['alignGISLO']) && $spDetails['alignGISLO']!=''){
    $defacultTabSts = 2;
}else if(isset($spDetails['alignPSLO']) && $spDetails['alignPSLO']!=''){
    $defacultTabSts = 3;
}else if(isset($spDetails['alignGPSLO']) && $spDetails['alignGPSLO']!=''){
    $defacultTabSts = 4;
}

?>
    <nav>
       
    <div class="nav nav-tabs mt-2" id="nav-tab" role="tablist">  
        <?php if(isset($spDetails['alignISLO']) && $spDetails['alignISLO']!=''){?>      
        <button class="nav-link <?php if($defacultTabSts==1){echo 'active';}?>" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">ISLO [<?php echo str_replace(',',', ',$spDetails['alignISLO']);?>]</button>
        <?php } if(isset($spDetails['alignGISLO']) && $spDetails['alignGISLO']!=''){?>
        <button class="nav-link <?php if($defacultTabSts==2){echo 'active';}?>" id="nav-glso-tab" data-bs-toggle="tab" data-bs-target="#nav-glso" type="button" role="tab" aria-controls="nav-glso" aria-selected="false">GISLO [<?php echo str_replace(',',', ',$spDetails['alignGISLO']);?>]</button>
        <?php } ?>
        <?php if(isset($spDetails['alignPSLO']) && $spDetails['alignPSLO']!=''){?>
        <button class="nav-link <?php if($defacultTabSts==3){echo 'active';}?>" id="nav-plso-tab" data-bs-toggle="tab" data-bs-target="#nav-plso" type="button" role="tab" aria-controls="nav-plso" aria-selected="false">PSLO [<?php echo str_replace(',',', ',$spDetails['alignPSLO']);?>]</button>
        <?php } ?>
        <?php if(isset($spDetails['alignGPSLO']) && $spDetails['alignGPSLO']!=''){?>
        <button class="nav-link <?php if($defacultTabSts==4){echo 'active';}?>" id="nav-gplso-tab" data-bs-toggle="tab" data-bs-target="#nav-gplso" type="button" role="tab" aria-controls="nav-gplso" aria-selected="false">GPSLO [<?php echo str_replace(',',', ',$spDetails['alignGPSLO']);?>]</button>
        <?php } ?>
    </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <?php if(isset($spDetails['alignISLO']) && $spDetails['alignISLO']!=''){ ?>
        <div class="tab-pane fade <?php if($defacultTabSts==1){echo 'show active';}?>" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php 
                $sloDataArr = $courseISLOClassDataArr;
                $sloFor = 'islo';
                include(APPPATH.'views/Frontend/reports/sampling_plan/for-slo.php');
            ?>
        </div>
        <?php } if(isset($spDetails['alignGISLO']) && $spDetails['alignGISLO']!=''){?>
        <div class="tab-pane fade <?php if($defacultTabSts==2){echo 'show active';}?>" id="nav-glso" role="tabpanel" aria-labelledby="nav-glso-tab">
            <?php 
                $sloDataArr = $courseGISLOClassDataArr;
                $sloFor = 'gislo';
                include(APPPATH.'views/Frontend/reports/sampling_plan/for-slo.php');
            ?>
        </div>
        <?php } ?>
        <?php if(isset($spDetails['alignPSLO']) && $spDetails['alignPSLO']!=''){?>
        <div class="tab-pane fade <?php if($defacultTabSts==3){echo 'show active';}?>" id="nav-plso" role="tabpanel" aria-labelledby="nav-plso-tab">
            <?php 
                $sloDataArr = $coursePSLOClassDataArr;
                $sloFor = 'pslo';
                include(APPPATH.'views/Frontend/reports/sampling_plan/for-slo.php');
            ?>
        </div>
        <?php } ?>
        <?php if(isset($spDetails['alignGPSLO']) && $spDetails['alignGPSLO']!=''){?>
        <div class="tab-pane fade <?php if($defacultTabSts==4){echo 'show active';}?>" id="nav-gplso" role="tabpanel" aria-labelledby="nav-gplso-tab">
            <?php 
                $sloDataArr = $courseGPSLOClassDataArr;
                $sloFor = 'gpslo';
                include(APPPATH.'views/Frontend/reports/sampling_plan/for-slo.php');
            ?>
        </div>
        <?php } ?>
    </div>
<script>
function saveSamplingPlan(speId,spId){
    var r = confirm("Are you sure want to save it!");
    if (r == true) {
        var new_array=[];
        $(".partCase:checked").each(function() {
            var n_total=$(this).val();
            new_array.push(n_total);
        });        
        var btnText = $('#saveSPBtn').html();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>sampling_plan/saveSamplingPlan", 
            data: { 
                'speId': speId, 
                'spId': spId, 
                'selParts': new_array
            },
			beforeSend: function(){ 
                $('#saveSPBtn').prop("disabled", true);
				$('#saveSPBtn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				var result_arr = result.split('||')
                if(result_arr[0]=='success'){
					window.location = '<?php echo base_url().'sampling_plan';?>';
				}else{
                    $('#saveSPBtn').prop("disabled", false);
					$('#saveSPBtn').html(btnText);
                }
			}
		});
    }
}
function update_toggle_swtich_values(ceClassId,sloFor,ceId){
	if(ceClassId>0){
		var checkstatus=$('#toggle-'+sloFor+ceClassId).prop('checked');
		if(checkstatus == true){
			var status=1;		
		}else{
			var status=0;		 
		}	
		$.ajax({url: "<?php echo base_url();?>sampling_plan/toggle_tem_classess?ceClassId="+ceClassId+"&sloFor="+sloFor+"&status="+status+"&ceId="+ceId+'&spId=<?php echo $spDetails['spId'];?>', 
			beforeSend: function(){ 
				$('#spinner_'+sloFor+'_'+ceClassId).html('<i class="fa fa-spinner fa-spin"></i>');
			},
			success: function(result){
				var result_arr = result.split('||')
                if(result_arr[0]=='success'){
					$('#spinner_'+sloFor+'_'+ceClassId).html('');
                    $('#selectIsoCnt').html(result_arr[1]);
                    $('#selTotalEnroll').html(result_arr[2]);
                    if(parseInt(status)==1){
                        $('#isoTr'+sloFor+ceClassId).addClass('SelTr');
                    }else{
                        $('#isoTr'+sloFor+ceClassId).removeClass('SelTr');
                    }
				}
			}
		});
	} 
}
</script>
<?php 
include(APPPATH.'views/Frontend/reports/sampling_plan/notes-modal.php');
include(APPPATH.'views/Frontend/reports/sampling_plan/manage-course-modal.php');
?>
</div>
</section>