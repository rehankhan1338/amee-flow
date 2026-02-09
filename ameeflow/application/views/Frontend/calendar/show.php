
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<style>
.fc-event-title{ font-weight:500;}
.fc-event-time{font-weight:600 !important; overflow: unset !important;}
.fc-event{padding:2px 0px 0px 2px;}
.fc-event:hover{opacity: .8;}
.fc .fc-daygrid-day-number{ font-size: 20px;font-weight: 500;}
</style>

<section class="content">
    
    <div class="box calendarPage">
        
        <div class="box-header no-border">
            <!-- <h3 class="box-title">Guest Access</h3> -->
            <div class="box-tools pull-right">
                <!-- <a href="<?php echo base_url().'home/downloadIcs?uniAdminId='.$uniAdminId; ?>" style="margin-right:5px;padding: 4px 30px; font-size:15px;" class="btn btn-primary">Add to Calendar</a> -->
                <?php if(isset($shareuaencryptId) && $shareuaencryptId!=''){?>                    
                    <a target="_blank" id="delBtn" href="<?php echo base_url().'calendar/share/'.$shareuaencryptId;?>" style="margin-right:5px;padding: 4px 30px; font-size:15px;" class='btn btn-secondary'> Public URL <i class="fa fa-external-link" aria-hidden="true"></i> </a>            
                <?php } ?>
            </div>
        </div>
        
        <?php          
            $jsonEvents = json_encode($eventDataArr);
            //[{ eId: 100, eTitle: 'Client Meeting', start: '2025-07-24T15:15:00' }]
        ?>
        <div class="box-body row mx-0">	
            <div id="calendar"></div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',        
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: true,
            hour12: true
        },
        selectable: true,
        allDay: false,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        events: <?php echo $jsonEvents;?>,
        eventClick: function(info) {
            var eId = info.event.id;
            var selDate = 0;
            $('#calendarModalLabel').html(info.event.title);
            $('#calendarModal').modal('show'); //info.event.url
            viewEvent(eId);
            return false;
        },
        <?php if(isset($manageSts) && $manageSts==1){?>
        dateClick: function(info) {
            var eId = 0;
            var selDate = info.dateStr;
            $('#calendarModalLabel').html('Add your event');
            $('#calendarModal').modal('show');
            manageEvent(eId,selDate);
        } <?php } ?>
    });
    calendar.render();
});
function ajaxCopyEvent(eId,selDate){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxFormFields?eId=';?>'+eId+'&selDate='+selDate+'&copySts=1',
        beforeSend: function(){            
            $('#calContentSec').html('<h5> <i class="fa fa-spinner fa-spin"></i> Please Wait </h5>');
        },
        success: function(result, status, xhr){
            $('#calContentSec').html(result);
        }
    });
}
function manageEvent(eId,selDate){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxFormFields?eId=';?>'+eId+'&selDate='+selDate,
        beforeSend: function(){
            if(parseInt(eId)==0){
                $('#copyEventField').show();
            }else{
                $('#copyEventField').hide();
            }
            $('#calContentSec').html('<h5> <i class="fa fa-spinner fa-spin"></i> Please Wait </h5>');
        },
        success: function(result, status, xhr){
            $('#calContentSec').html(result);
        }
    });
}
function viewEvent(eId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxEventDetails?eId=';?>'+eId+'&createdBy=<?php echo $createdBy;?>&createdById=<?php echo $createdById;?>',
        beforeSend: function(){
            $('#copyEventField').hide();
            $('#calContentSec').html('<h5> <i class="fa fa-spinner fa-spin"></i> Please Wait </h5>');
        },
        success: function(result, status, xhr){
            $('#calContentSec').html(result);
        }
    });
}
function deleteEvent(eId){
    var r = confirm("Warning: Are you sure you want to delete your event?");
	if (r == true) {
        $.ajax({
            type: "POST",
            url: '<?php echo base_url().'home/deleteEvent?eId=';?>'+eId+'&createdBy=<?php echo $createdBy;?>',
            beforeSend: function(){
                $('#delCalBtn').prop("disabled", true);
                $('#delCalBtn').html('Deleting <i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(result, status, xhr){
                var result_arr = result.split('||')
                if(result_arr[0]=='success'){
                    window.location = result_arr[1];
                }else{
                    $('#ajaxRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');	
                    $('#calSaveBtn').prop("disabled", false);
                    $('#calSaveBtn').html(btnText);
                }
            }
        });
    }
}
$(document).ready(function () {
	$('#calManageFrm').validate({
		ignore: [], 
		highlight: function(element) {
			$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); 
		},
		success: function(element) {
			element.closest('.form-group').removeClass('has-error');
			element.remove();
		},
		submitHandler: function(form){
			var btnText = $('#calSaveBtn').html();
			var site_base_url = '<?php echo base_url();?>';
			var form = $('#calManageFrm');
			var url = site_base_url+form.attr('action');
            for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				beforeSend: function(){
					$('#calSaveBtn').prop("disabled", true);
					$('#calSaveBtn').html('Please Wait &nbsp;<i class="fa fa-spinner fa-spin"></i>');
				},
				success: function(result, status, xhr){
					var result_arr = result.split('||')
					if(result_arr[0]=='success'){
						window.location = result_arr[1];
					}else{
						$('#ajaxRes').html('<div class="alert alert-danger">'+result_arr[1]+'</div>');	
						$('#calSaveBtn').prop("disabled", false);
						$('#calSaveBtn').html(btnText);
					}
				}
			});		
			return false;
		}
	});
});
</script>

<div class="modal fade" id="calendarModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">	
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ajaxRes" class="ajaxFrmRes"></div>
                <form id="calManageFrm" action="home/saveEvent" method="post">
                    <input type="hidden" id="caluniversityId" name="caluniversityId" value="<?php echo $universityId;?>" />
                    <input type="hidden" id="caluniAdminId" name="caluniAdminId" value="<?php echo $uniAdminId;?>" /> 
                    <input type="hidden" id="calcreatedBy" name="calcreatedBy" value="<?php echo $createdBy;?>" /> 
                    <input type="hidden" id="calcreatedById" name="calcreatedById" value="<?php echo $createdById;?>" />

                    
                    <div class="row" id="copyEventField" style="display:none;">
                        <?php if(count($myEventDataArr)>0){ ?>
                        <div class="col-12 form-fields">
                            <label class="form-label">Copy Event From </label>
                            <select id="copyEventId" name="copyEventId" class="form-control" onchange="return ajaxCopyEvent(this.value,'0');">
                                <option value="">Select...</option>
                                <?php 
                                    foreach($myEventDataArr as $ev){?>
                                    <option value="<?php echo $ev['id'];?>"><?php echo $ev['title'].' - '.date('m/d/Y',$ev['stime']);?></option>
                                <?php }  ?>
                            </select>
                        </div>  
                        <?php }  ?>
                    </div>
                    
                    <div id="calContentSec"></div>
                </form>
            </div>      
        </div>
    </div>
</div>