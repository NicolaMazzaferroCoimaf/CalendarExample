<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: false,
                dateClick: function(info) {
                    window.location.href = '/absences/' + info.dateStr;
                }
            });

            calendar.render();
        });
    </script>
</head>
<body>
    <div style="width: 100%">
        <div id='calendar' style="width: 50%; margin: auto; margin-top: 5%;"></div>
    </div>
</body>
</html>
