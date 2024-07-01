<?php
require_once '../../Database/db_config.php';
//echo $_GET['ScheduleRequestID'] ;

if(isset($_GET['ScheduleRequestID'])){
$ScheduleRequestID=(int)$_GET['ScheduleRequestID'];
}else{
  $ScheduleRequestID=-1;
}
//ScheduleRequestID
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>

<style>

html {
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;  
    background-color:  #1b253d; /* Set the background color */
}
body {
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
    background-color: #1b253d; /* Set the background color */
}

.btn-info.text-light:hover,
.btn-info.text-light:focus {
    background: #000;

}
table, tbody, td, tfoot, th, thead, tr {
    border-color: #ededed !important;
    border-style: solid;
    border-width: 1px !important;
    background-color: #28a745;
  
}
#schedule-form {
background-color: #28a745;
padding: 20px; /* Optional: Add padding for better spacing */
border-radius: 10px; /* Optional: Add border-radius for rounded corners */
}
.fc-toolbar-title {
        color: white;
}




</style>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success bg-gradient" id="topNavBar">
        <div class="container">
            
            <div>
                <b class="text-light fw-bold fs-3">Event Scheduling</b>
            </div>
        </div>

        <div class="action">
            <!--Redirect to the previous page-->
            <button style="background-color: #28a745;  border-radius: 55px; padding: 8px 16px;" class="text-light fw-bold fs-3"  onclick="window.history.back()">
                Back
            </button>

        </div>
    </nav>
    <div class="container py-5" id="page-container" style="background-color: #1b253d;">
        <div class="row">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="card rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Schedule Form</h5>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                        <form method="post"  id="schedule-form">
                                    <input type="hidden" name="ScheduleID" value="">
                                    <div class="form-group mb-2">
                                        <label for="ServiceDescription" class="control-label">Service Description</label>
                                        <input value="<?php echo $ScheduleRequestID?>" name="ScheduleRequestID" id="ScheduleRequestID" type="hidden"/>
                                        <input type="text" class="form-control form-control-sm rounded-0" name="ServiceDescription" id="ServiceDescription" required>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="Notes" class="control-label">Notes</label>
                                        <textarea rows="3" class="form-control form-control-sm rounded-0" name="Notes" id="Notes"></textarea>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="StartDateTime" class="control-label">Start Date and Time</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="StartDateTime" id="StartDateTime" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="EndDateTime" class="control-label">End Date and Time</label>
                                        <input type="datetime-local" class="form-control form-control-sm rounded-0" name="EndDateTime" id="EndDateTime" required min="<?php echo date('Y-m-d\TH:i'); ?>">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="Status" class="control-label">Status</label>
                                        <select class="form-control form-control-sm rounded-0" name="Status" id="Status">
                                            <option value="Pending">Pending</option>
                                            <option value="In Progress">In Progress</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                         </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" form="schedule-form"><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Schedule Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
    <div class="container-fluid">
        <dl>
            <dt class="text-muted">Service Description</dt>
            <dd id="ServiceDescription" class="fw-bold fs-4"></dd>
            <dt class="text-muted">Notes</dt>
            <dd id="Notes" class=""></dd>
            <dt class="text-muted">Start Date and Time</dt>
            <dd id="StartDateTime" class=""></dd>
            <dt class="text-muted">End Date and Time</dt>
            <dd id="EndDateTime" class=""></dd>
            <dt class="text-muted">Status</dt>
            <dd id="Status" class=""></dd>
        </dl>
    </div>
</div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="edit" data-id="">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm rounded-0" id="delete" data-id="">Delete</button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->


<?php 
$schedules = [];
if ($link) {
    $result = $link->query("SELECT * FROM service_schedule");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $schedules[$row['ScheduleID']] = $row;
        }
        $result->free();
    }
    $link->close();
} else {
    echo "Database connection is not established.";
}
?>
</body>

<script>
    var scheds = <?= json_encode($schedules) ?>;
</script>

<script>
        
    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
        
    $(function() {
        if (scheds) {
    Object.keys(scheds).map(k => {
        var row = scheds[k];
        events.push({ 
            id: row.ScheduleID, 
            title: row.ServiceDescription, 
            start: row.StartDateTime,
            end: row.EndDateTime,
        });
    });
   }
        var date = new Date();
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();
 
        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
                
            //Random default events
            events: events,
    eventClick: function(info) {
    var _details = $('#event-details-modal');
    var id = info.event.id;
    if (scheds[id]) {
            
            //ScheduleRequestID
        _details.find('#ServiceDescription').text(scheds[id].ServiceDescription);
        _details.find('#Notes').text(scheds[id].Notes);
        _details.find('#ScheduleRequestID').text(scheds[id].ScheduleRequestID);
        _details.find('#StartDateTime').text(scheds[id].StartDateTime);
        _details.find('#EndDateTime').text(scheds[id].EndDateTime);
        _details.find('#Status').text(scheds[id].Status);
        _details.find('#edit,#delete').attr('data-id', id);
        _details.modal('show');
    } else {
        alert("Event is undefined");
    }
},
            eventDidMount: function(info) {
                // Do Something after events are mounted
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('');
            $(this).find('input:visible').first().focus();
        });

// Edit Button
$('#edit').click(function() {
    var id = $(this).attr('data-id');
    if (scheds[id]) {
        var _form = $('#schedule-form');
        
        _form.find('[name="ScheduleID"]').val(id);
        _form.find('[name="ServiceDescription"]').val(scheds[id].ServiceDescription);
        _form.find('[name="Notes"]').val(scheds[id].Notes);
        _form.find('[name="ScheduleRequestID"]').val(scheds[id].ScheduleRequestID);
        _form.find('[name="StartDateTime"]').val(scheds[id].StartDateTime.replace(" ", "T"));
        _form.find('[name="EndDateTime"]').val(scheds[id].EndDateTime.replace(" ", "T"));
        _form.find('[name="Status"]').val(scheds[id].Status);
        
        $('#event-details-modal').modal('hide');
        _form.find('[name="ServiceDescription"]').focus();
    } else {
        alert("Event is undefined");
    }
});

        // Delete Button / Deleting an Event
        $('#delete').click(function() {
            var id = $(this).attr('data-id');
            if (scheds[id]) {
                var _conf = confirm("Are you sure to delete this scheduled event?");
                if (_conf === true) {
            // Send an AJAX request to delete the scheduled event
            $.ajax({
                url: "delete_schedule.php",
                type: "GET",
                data: { id: id },
                success: function(response) {
                    // Redirect to dynamic-full-calendar.php after successful deletion
                    window.location.href = "service_provider_calender.php";
                },
                error: function(xhr, status, error) {
                    alert("Error deleting scheduled event: " + error);
                }
            });
        }
    } else {
        alert("Event is undefined");
    }
})
            
 
 //submit button   
$('#schedule-form').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
        
    if (!validateDates()) {
        return; // Stop the submission if validation fails
    }

    // Send an AJAX request to save the schedule
    $.ajax({
        url: "save_schedule.php?c=1",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            // Redirect to service_provider_calender.php after successful save
            window.location.href = "service_provider_calender.php";
        },
        error: function(xhr, status, error) {
            alert("Error saving scheduled event: " + error);
        }
    });
  });
});
    

//date validation
function validateDates() {
    var startDateTime = new Date($('#StartDateTime').val());
    var endDateTime = new Date($('#EndDateTime').val());
    var now = new Date();

    // Set the time of 'now' to midnight for accurate date comparison
    now.setHours(0, 0, 0, 0);

    if (startDateTime < now) {
        alert("Start date cannot be in the past. Please select a current or future date.");
        return false;
    }

    if (endDateTime < startDateTime) {
        alert("End date must be after the start date.");
        return false;
    }

    return true;
}
        
        
        
        
        
</script>