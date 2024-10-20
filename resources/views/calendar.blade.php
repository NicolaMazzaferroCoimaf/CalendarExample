<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />

    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.15/index.global.min.js'></script>


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            // plugins: [ 'dayGrid', 'interaction' ],
            initialView: 'dayGridMonth',
            events: function(fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: '/calendar-events',  // Endpoint che restituisce i dati delle assenze e ore lavorate
                    method: 'GET',
                    success: function(data) {
                        console.log("Eventi recuperati:", data);  // Log per controllare i dati
                        successCallback(data); // Passa i dati degli eventi al calendario
                    },
                    error: function() {
                        alert('C\'è stato un errore nel recuperare i dati!');
                        failureCallback();
                    }
                });
            },
            selectable: true,
            editable: true,
        });

        calendar.render();
    });
</script>
    
  </head>
  <body>
    <div style="width: 100%">

        <div id='calendar' style="width: 50%; margin-left:25%; margin-right:25%; margin-top:5%"></div>
    </div>
  </body>
</html>