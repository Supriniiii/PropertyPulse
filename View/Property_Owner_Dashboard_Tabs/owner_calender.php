<?php
require_once '../../Database/db_config.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Viewer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>
<style>
              
html, body {
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
    background-color: #1b253d;
}
        
.btn-info.text-light:hover,
.btn-info.text-light:focus {
    background: #000;

}
        
table, tbody, td, tfoot, th, thead, tr {
    border-color: #ededed !important;
    border-style: solid;
    border-width: 1px !important;
    background-color: #1e8449;
  
}

.fc-toolbar-title {
    color: white;
}

#calendar {
    background-color:#145a32;
    padding: 20px;
    border-radius: 10px;
}
.custom-nav {
    background-color: #2a2a3e !important;
 }
</style>

<body>
     <nav class="navbar navbar-expand-lg navbar-dark custom-nav" id="topNavBar">
        <div class="container">
            <div>
                <b class="text-light fw-bold fs-3">Event Schedule Viewer</b>
            </div>
        </div>

        <div class="action">
            <!--Back button (already present in your code)-->
            <button style="background-color: #28a745;  border-radius: 55px; padding: 8px 16px;" class="text-light fw-bold fs-3">
                <a href="propertyowner_dashboard.php" style="text-decoration: none">Back</a>
            </button>
        </div>
    </nav>
    <div class="container py-5" id="page-container" style="background-color: #1b253d;">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar"></div>
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
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    $schedules = [];
    if ($link) {
        $result = $link->query("SELECT * FROM `service_schedule`");
        if ($result) {
            while ($row = $result->fetch_assoc()) {;
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

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: false, // Make calendar non-selectable
            themeSystem: 'bootstrap',
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal');
                var id = info.event.id;
                if (scheds[id]) {
                    _details.find('#ServiceDescription').text(scheds[id].ServiceDescription);
                    _details.find('#Notes').text(scheds[id].Notes);
                    _details.find('#StartDateTime').text(scheds[id].StartDateTime);
                    _details.find('#EndDateTime').text(scheds[id].EndDateTime);
                    _details.find('#Status').text(scheds[id].Status);
                    _details.modal('show');
                } else {
                    alert("Event is undefined");
                }
            },
            editable: false
        });

        calendar.render();
    });
</script>