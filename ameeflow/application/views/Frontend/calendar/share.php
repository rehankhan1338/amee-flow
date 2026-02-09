<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $title;?></title>
	<link rel="icon" type="image/x-icon" href="<?php echo base_url();?>assets/backend/images/favicon.ico">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/backend/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" /> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.5.2/jquery-migrate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/feather-icons"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        .fc-event-title{ font-weight:500;}
        .fc-event-time{font-weight:600 !important; overflow: unset !important;}
        .fc-event{padding:2px 0px 0px 2px;}
        .fc-event:hover{opacity: .8;}
        .fc .fc-daygrid-day-number{ font-size: 20px;font-weight: 500;}
    </style>
</head>
<body class="">
<?php $jsonEvents = json_encode($eventDataArr); ?>
    <div class="container mt-3 mb-5">
        <?php if(isset($uaDetails['unitName']) && $uaDetails['unitName']!=''){?>
            <h2 class="text-center my-3 fw600"> <?php echo $uaDetails['unitName'];?></h2>
        <?php } ?>
        <h3 class="text-center mb-4"> Events Calendar</h3>
        <div id="calendar"></div>
    </div>
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
    });
    calendar.render();
});
function viewEvent(eId){
    $.ajax({
        type: "POST",
        url: '<?php echo base_url().'home/ajaxEventDetails?eId=';?>'+eId+'&createdBy=0&createdById=0',
        beforeSend: function(){
            $('#calContentSec').html('<h5> <i class="fa fa-spinner fa-spin"></i> Please Wait </h5>');
        },
        success: function(result, status, xhr){
            $('#calContentSec').html(result);
        }
    });
}
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
                <div id="calContentSec"></div>
            </div>      
        </div>
    </div>
</div>

</body>
</html>